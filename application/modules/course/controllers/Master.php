<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Master controller
 */
class Master extends Admin_Controller
{
    protected $permissionCreate = 'Course.Master.Create';
    protected $permissionDelete = 'Course.Master.Delete';
    protected $permissionEdit   = 'Course.Master.Edit';
    protected $permissionView   = 'Course.Master.View';

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->auth->restrict($this->permissionView);
        $this->load->model('course/course_model');
        $this->lang->load('course');
        
            $this->form_validation->set_error_delimiters("<span class='error'>", "</span>");
        
        Template::set_block('sub_nav', 'master/_sub_nav');

        Assets::add_module_js('course', 'course.js');
    }

    /**
     * Display a list of Course data.
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
                    $deleted = $this->course_model->delete($pid);
                    if ($deleted == false) {
                        $result = false;
                    }
                }
                if ($result) {
                    Template::set_message(count($checked) . ' ' . lang('course_delete_success'), 'success');
                } else {
                    Template::set_message(lang('course_delete_failure') . $this->course_model->error, 'error');
                }
            }
        }
        
        
        
        $records = $this->course_model->where('deleted',0)->find_all();

        Template::set('records', $records);
        
        Template::set('toolbar_title', lang('course_manage'));

        Template::render();
    }
    
    /**
     * Create a Course object.
     *
     * @return void
     */
    public function create()
    {
        $this->auth->restrict($this->permissionCreate);
        
        if (isset($_POST['save'])) {
            if ($insert_id = $this->save_course()) {
                log_activity($this->auth->user_id(), lang('course_act_create_record') . ': ' . $insert_id . ' : ' . $this->input->ip_address(), 'course');
                Template::set_message(lang('course_create_success'), 'success');

                redirect(SITE_AREA . '/master/course');
            }

            // Not validation error
            if ( ! empty($this->course_model->error)) {
                Template::set_message(lang('course_create_failure') . $this->course_model->error, 'error');
            }
        }

        Template::set('toolbar_title', lang('course_action_create'));

        Template::render();
    }
    /**
     * Allows editing of Course data.
     *
     * @return void
     */
    public function edit()
    {
        $id = $this->uri->segment(5);
        if (empty($id)) {
            Template::set_message(lang('course_invalid_id'), 'error');

            redirect(SITE_AREA . '/master/course');
        }
        
        if (isset($_POST['save'])) {
            $this->auth->restrict($this->permissionEdit);

            if ($this->save_course('update', $id)) {
                log_activity($this->auth->user_id(), lang('course_act_edit_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'course');
                Template::set_message(lang('course_edit_success'), 'success');
                redirect(SITE_AREA . '/master/course');
            }

            // Not validation error
            if ( ! empty($this->course_model->error)) {
                Template::set_message(lang('course_edit_failure') . $this->course_model->error, 'error');
            }
        }
        
        elseif (isset($_POST['delete'])) {
            $this->auth->restrict($this->permissionDelete);

            if ($this->course_model->delete($id)) {
                log_activity($this->auth->user_id(), lang('course_act_delete_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'course');
                Template::set_message(lang('course_delete_success'), 'success');

                redirect(SITE_AREA . '/master/course');
            }

            Template::set_message(lang('course_delete_failure') . $this->course_model->error, 'error');
        }
        
        Template::set('course', $this->course_model->find($id));

        Template::set('toolbar_title', lang('course_edit_heading'));
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
    private function save_course($type = 'insert', $id = 0)
    {
        if ($type == 'update') {
            $_POST['id'] = $id;
        }

        // Validate the data
        $this->form_validation->set_rules($this->course_model->get_validation_rules());
        if ($this->form_validation->run() === false) {
            return false;
        }

        // Make sure we only pass in the fields we want
        
        $data = $this->course_model->prep_data($this->input->post());

        // Additional handling for default values should be added below,
        // or in the model's prep_data() method
        

        $return = false;
        if ($type == 'insert') {
            $id = $this->course_model->insert($data);

            if (is_numeric($id)) {
                $return = $id;
            }
        } elseif ($type == 'update') {
            $return = $this->course_model->update($id, $data);
        }

        return $return;
    }
}