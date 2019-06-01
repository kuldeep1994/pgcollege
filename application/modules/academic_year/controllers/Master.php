<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Master controller
 */
class Master extends Admin_Controller
{
    protected $permissionCreate = 'Academic_year.Master.Create';
    protected $permissionDelete = 'Academic_year.Master.Delete';
    protected $permissionEdit   = 'Academic_year.Master.Edit';
    protected $permissionView   = 'Academic_year.Master.View';

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->auth->restrict($this->permissionView);
        $this->load->model('academic_year/academic_year_model');
        $this->lang->load('academic_year');
        
            $this->form_validation->set_error_delimiters("<span class='error'>", "</span>");
        
        Template::set_block('sub_nav', 'master/_sub_nav');

        Assets::add_module_js('academic_year', 'academic_year.js');
    }

    /**
     * Display a list of Academic Year data.
     *
     * @return void
     */
    public function index()
    {
        // Deleting anything?
        if (isset($_POST['delete'])) {
            $this->auth->restrict($this->permissionDelete);
            $checked = $this->input->post('checked');
            if (is_array($checked) && count($checked)) {

                // If any of the deletions fail, set the result to false, so
                // failure message is set if any of the attempts fail, not just
                // the last attempt

                $result = true;
                foreach ($checked as $pid) {
                    $deleted = $this->academic_year_model->delete($pid);
                    if ($deleted == false) {
                        $result = false;
                    }
                }
                if ($result) {
                    Template::set_message(count($checked) . ' ' . lang('academic_year_delete_success'), 'success');
                } else {
                    Template::set_message(lang('academic_year_delete_failure') . $this->academic_year_model->error, 'error');
                }
            }
        }
        
        
        
        $records = $this->academic_year_model->where('deleted',0)->find_all();

        Template::set('records', $records);
        
        Template::set('toolbar_title', lang('academic_year_manage'));

        Template::render();
    }
    
    /**
     * Create a Academic Year object.
     *
     * @return void
     */
    public function create()
    {
        $this->auth->restrict($this->permissionCreate);
        
        if (isset($_POST['save'])) {
            if ($insert_id = $this->save_academic_year()) {
                log_activity($this->auth->user_id(), lang('academic_year_act_create_record') . ': ' . $insert_id . ' : ' . $this->input->ip_address(), 'academic_year');
                Template::set_message(lang('academic_year_create_success'), 'success');

                redirect(SITE_AREA . '/master/academic_year');
            }

            // Not validation error
            if ( ! empty($this->academic_year_model->error)) {
                Template::set_message(lang('academic_year_create_failure') . $this->academic_year_model->error, 'error');
            }
        }

        Template::set('toolbar_title', lang('academic_year_action_create'));

        Template::render();
    }
    /**
     * Allows editing of Academic Year data.
     *
     * @return void
     */
    public function edit()
    {
        $id = $this->uri->segment(5);
        if (empty($id)) {
            Template::set_message(lang('academic_year_invalid_id'), 'error');

            redirect(SITE_AREA . '/master/academic_year');
        }
        
        if (isset($_POST['save'])) {
            $this->auth->restrict($this->permissionEdit);

            if ($this->save_academic_year('update', $id)) {
                log_activity($this->auth->user_id(), lang('academic_year_act_edit_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'academic_year');
                Template::set_message(lang('academic_year_edit_success'), 'success');
                redirect(SITE_AREA . '/master/academic_year');
            }

            // Not validation error
            if ( ! empty($this->academic_year_model->error)) {
                Template::set_message(lang('academic_year_edit_failure') . $this->academic_year_model->error, 'error');
            }
        }
        
        elseif (isset($_POST['delete'])) {
            $this->auth->restrict($this->permissionDelete);

            if ($this->academic_year_model->delete($id)) {
                log_activity($this->auth->user_id(), lang('academic_year_act_delete_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'academic_year');
                Template::set_message(lang('academic_year_delete_success'), 'success');

                redirect(SITE_AREA . '/master/academic_year');
            }

            Template::set_message(lang('academic_year_delete_failure') . $this->academic_year_model->error, 'error');
        }
        
        Template::set('academic_year', $this->academic_year_model->find($id));

        Template::set('toolbar_title', lang('academic_year_edit_heading'));
        Template::render();
    }

    //--------------------------------------------------------------------------
    // !PRIVATE METHODS
    //--------------------------------------------------------------------------

    /**
     * Save the data.
     *
     * @param string $type Either 'insert' or 'update'.
     * @param int    $id   The ID of the record to update, ignored on inserts.
     *
     * @return boolean|integer An ID for successful inserts, true for successful
     * updates, else false.
     */
    private function save_academic_year($type = 'insert', $id = 0)
    {
        if ($type == 'update') {
            $_POST['id'] = $id;
        }

        // Validate the data
        $this->form_validation->set_rules($this->academic_year_model->get_validation_rules());
        if ($this->form_validation->run() === false) {
            return false;
        }

        // Make sure we only pass in the fields we want
        
        $data = $this->academic_year_model->prep_data($this->input->post());

        // Additional handling for default values should be added below,
        // or in the model's prep_data() method
        

        $return = false;
        if ($type == 'insert') {
            $id = $this->academic_year_model->insert($data);

            if (is_numeric($id)) {
                $return = $id;
            }
        } elseif ($type == 'update') {
            $return = $this->academic_year_model->update($id, $data);
        }

        return $return;
    }
}