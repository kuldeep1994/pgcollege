<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Developer controller
 */
class Developer extends Admin_Controller
{
    protected $permissionCreate = 'Local_address.Developer.Create';
    protected $permissionDelete = 'Local_address.Developer.Delete';
    protected $permissionEdit   = 'Local_address.Developer.Edit';
    protected $permissionView   = 'Local_address.Developer.View';

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->auth->restrict($this->permissionView);
        $this->load->model('local_address/local_address_model');
        $this->lang->load('local_address');
        
            $this->form_validation->set_error_delimiters("<span class='error'>", "</span>");
        
        Template::set_block('sub_nav', 'developer/_sub_nav');

        Assets::add_module_js('local_address', 'local_address.js');
    }

    /**
     * Display a list of Local Address data.
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
                    $deleted = $this->local_address_model->delete($pid);
                    if ($deleted == false) {
                        $result = false;
                    }
                }
                if ($result) {
                    Template::set_message(count($checked) . ' ' . lang('local_address_delete_success'), 'success');
                } else {
                    Template::set_message(lang('local_address_delete_failure') . $this->local_address_model->error, 'error');
                }
            }
        }
        
        
        
        $records = $this->local_address_model->find_all();

        Template::set('records', $records);
        
    Template::set('toolbar_title', lang('local_address_manage'));

        Template::render();
    }
    
    /**
     * Create a Local Address object.
     *
     * @return void
     */
    public function create()
    {
        $this->auth->restrict($this->permissionCreate);
        
        if (isset($_POST['save'])) {
            if ($insert_id = $this->save_local_address()) {
                log_activity($this->auth->user_id(), lang('local_address_act_create_record') . ': ' . $insert_id . ' : ' . $this->input->ip_address(), 'local_address');
                Template::set_message(lang('local_address_create_success'), 'success');

                redirect(SITE_AREA . '/developer/local_address');
            }

            // Not validation error
            if ( ! empty($this->local_address_model->error)) {
                Template::set_message(lang('local_address_create_failure') . $this->local_address_model->error, 'error');
            }
        }

        Template::set('toolbar_title', lang('local_address_action_create'));

        Template::render();
    }
    /**
     * Allows editing of Local Address data.
     *
     * @return void
     */
    public function edit()
    {
        $id = $this->uri->segment(5);
        if (empty($id)) {
            Template::set_message(lang('local_address_invalid_id'), 'error');

            redirect(SITE_AREA . '/developer/local_address');
        }
        
        if (isset($_POST['save'])) {
            $this->auth->restrict($this->permissionEdit);

            if ($this->save_local_address('update', $id)) {
                log_activity($this->auth->user_id(), lang('local_address_act_edit_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'local_address');
                Template::set_message(lang('local_address_edit_success'), 'success');
                redirect(SITE_AREA . '/developer/local_address');
            }

            // Not validation error
            if ( ! empty($this->local_address_model->error)) {
                Template::set_message(lang('local_address_edit_failure') . $this->local_address_model->error, 'error');
            }
        }
        
        elseif (isset($_POST['delete'])) {
            $this->auth->restrict($this->permissionDelete);

            if ($this->local_address_model->delete($id)) {
                log_activity($this->auth->user_id(), lang('local_address_act_delete_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'local_address');
                Template::set_message(lang('local_address_delete_success'), 'success');

                redirect(SITE_AREA . '/developer/local_address');
            }

            Template::set_message(lang('local_address_delete_failure') . $this->local_address_model->error, 'error');
        }
        
        Template::set('local_address', $this->local_address_model->find($id));

        Template::set('toolbar_title', lang('local_address_edit_heading'));
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
    private function save_local_address($type = 'insert', $id = 0)
    {
        if ($type == 'update') {
            $_POST['id'] = $id;
        }

        // Validate the data
        $this->form_validation->set_rules($this->local_address_model->get_validation_rules());
        if ($this->form_validation->run() === false) {
            return false;
        }

        // Make sure we only pass in the fields we want
        
        $data = $this->local_address_model->prep_data($this->input->post());

        // Additional handling for default values should be added below,
        // or in the model's prep_data() method
        

        $return = false;
        if ($type == 'insert') {
            $id = $this->local_address_model->insert($data);

            if (is_numeric($id)) {
                $return = $id;
            }
        } elseif ($type == 'update') {
            $return = $this->local_address_model->update($id, $data);
        }

        return $return;
    }
}