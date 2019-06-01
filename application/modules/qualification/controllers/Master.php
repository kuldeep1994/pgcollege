<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Master controller
 */
class Master extends Admin_Controller
{
    protected $permissionCreate = 'Qualification.Master.Create';
    protected $permissionDelete = 'Qualification.Master.Delete';
    protected $permissionEdit   = 'Qualification.Master.Edit';
    protected $permissionView   = 'Qualification.Master.View';

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->auth->restrict($this->permissionView);
        $this->load->model('qualification/qualification_model');
        $this->lang->load('qualification');
        
            $this->form_validation->set_error_delimiters("<span class='error'>", "</span>");
        
        Template::set_block('sub_nav', 'master/_sub_nav');

        Assets::add_module_js('qualification', 'qualification.js');
    }

    /**
     * Display a list of Qualification data.
     *
     * @return void
     */
    public function index($offset = 0)
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
                    $deleted = $this->qualification_model->delete($pid);
                    if ($deleted == false) {
                        $result = false;
                    }
                }
                if ($result) {
                    Template::set_message(count($checked) . ' ' . lang('qualification_delete_success'), 'success');
                } else {
                    Template::set_message(lang('qualification_delete_failure') . $this->qualification_model->error, 'error');
                }
            }
        }
        $pagerUriSegment = 5;
        $pagerBaseUrl = site_url(SITE_AREA . '/master/qualification/index') . '/';
        
        $limit  = $this->settings_lib->item('site.list_limit') ?: 15;

        $this->load->library('pagination');
        $pager['base_url']    = $pagerBaseUrl;
        $pager['total_rows']  = $this->qualification_model->count_all();
        $pager['per_page']    = $limit;
        $pager['uri_segment'] = $pagerUriSegment;

        $this->pagination->initialize($pager);
        $this->qualification_model->limit($limit, $offset);
        
        $records = $this->qualification_model->find_all();

        Template::set('records', $records);
        
    Template::set('toolbar_title', lang('qualification_manage'));

        Template::render();
    }
    
    /**
     * Create a Qualification object.
     *
     * @return void
     */
    public function create()
    {
        $this->auth->restrict($this->permissionCreate);
        
        if (isset($_POST['save'])) {
            if ($insert_id = $this->save_qualification()) {
                log_activity($this->auth->user_id(), lang('qualification_act_create_record') . ': ' . $insert_id . ' : ' . $this->input->ip_address(), 'qualification');
                Template::set_message(lang('qualification_create_success'), 'success');

                redirect(SITE_AREA . '/master/qualification');
            }

            // Not validation error
            if ( ! empty($this->qualification_model->error)) {
                Template::set_message(lang('qualification_create_failure') . $this->qualification_model->error, 'error');
            }
        }

        Template::set('toolbar_title', lang('qualification_action_create'));

        Template::render();
    }
    /**
     * Allows editing of Qualification data.
     *
     * @return void
     */
    public function edit()
    {
        $id = $this->uri->segment(5);
        if (empty($id)) {
            Template::set_message(lang('qualification_invalid_id'), 'error');

            redirect(SITE_AREA . '/master/qualification');
        }
        
        if (isset($_POST['save'])) {
            $this->auth->restrict($this->permissionEdit);

            if ($this->save_qualification('update', $id)) {
                log_activity($this->auth->user_id(), lang('qualification_act_edit_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'qualification');
                Template::set_message(lang('qualification_edit_success'), 'success');
                redirect(SITE_AREA . '/master/qualification');
            }

            // Not validation error
            if ( ! empty($this->qualification_model->error)) {
                Template::set_message(lang('qualification_edit_failure') . $this->qualification_model->error, 'error');
            }
        }
        
        elseif (isset($_POST['delete'])) {
            $this->auth->restrict($this->permissionDelete);

            if ($this->qualification_model->delete($id)) {
                log_activity($this->auth->user_id(), lang('qualification_act_delete_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'qualification');
                Template::set_message(lang('qualification_delete_success'), 'success');

                redirect(SITE_AREA . '/master/qualification');
            }

            Template::set_message(lang('qualification_delete_failure') . $this->qualification_model->error, 'error');
        }
        
        Template::set('qualification', $this->qualification_model->find($id));

        Template::set('toolbar_title', lang('qualification_edit_heading'));
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
    private function save_qualification($type = 'insert', $id = 0)
    {
        if ($type == 'update') {
            $_POST['id'] = $id;
        }

        // Validate the data
        $this->form_validation->set_rules($this->qualification_model->get_validation_rules());
        if ($this->form_validation->run() === false) {
            return false;
        }

        // Make sure we only pass in the fields we want
        
        $data = $this->qualification_model->prep_data($this->input->post());

        // Additional handling for default values should be added below,
        // or in the model's prep_data() method
        

        $return = false;
        if ($type == 'insert') {
            $id = $this->qualification_model->insert($data);

            if (is_numeric($id)) {
                $return = $id;
            }
        } elseif ($type == 'update') {
            $return = $this->qualification_model->update($id, $data);
        }

        return $return;
    }
}