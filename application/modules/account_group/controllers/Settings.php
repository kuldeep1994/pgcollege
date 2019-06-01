<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Settings controller
 */
class Settings extends Admin_Controller
{
    protected $permissionCreate = 'Account_group.Settings.Create';
    protected $permissionDelete = 'Account_group.Settings.Delete';
    protected $permissionEdit   = 'Account_group.Settings.Edit';
    protected $permissionView   = 'Account_group.Settings.View';

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->auth->restrict($this->permissionView);
        $this->load->model('account_group/account_group_model');
        $this->lang->load('account_group');
        
            $this->form_validation->set_error_delimiters("<span class='error'>", "</span>");
        
        Template::set_block('sub_nav', 'settings/_sub_nav');

        Assets::add_module_js('account_group', 'account_group.js');
    }

    /**
     * Display a list of Account Group data.
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
                    $deleted = $this->account_group_model->delete($pid);
                    if ($deleted == false) {
                        $result = false;
                    }
                }
                if ($result) {
                    Template::set_message(count($checked) . ' ' . lang('account_group_delete_success'), 'success');
                } else {
                    Template::set_message(lang('account_group_delete_failure') . $this->account_group_model->error, 'error');
                }
            }
        }
        
        
        
        $records = $this->account_group_model->find_all();

        Template::set('records', $records);
        
    Template::set('toolbar_title', lang('account_group_manage'));

        Template::render();
    }
    
    /**
     * Create a Account Group object.
     *
     * @return void
     */
    public function create()
    {
        $this->auth->restrict($this->permissionCreate);
        
        if (isset($_POST['save'])) {
            if ($insert_id = $this->save_account_group()) {
                log_activity($this->auth->user_id(), lang('account_group_act_create_record') . ': ' . $insert_id . ' : ' . $this->input->ip_address(), 'account_group');
                Template::set_message(lang('account_group_create_success'), 'success');

                redirect(SITE_AREA . '/settings/account_group');
            }

            // Not validation error
            if ( ! empty($this->account_group_model->error)) {
                Template::set_message(lang('account_group_create_failure') . $this->account_group_model->error, 'error');
            }
        }

        Template::set('toolbar_title', lang('account_group_action_create'));

        Template::render();
    }
    /**
     * Allows editing of Account Group data.
     *
     * @return void
     */
    public function edit()
    {
        $id = $this->uri->segment(5);
        if (empty($id)) {
            Template::set_message(lang('account_group_invalid_id'), 'error');

            redirect(SITE_AREA . '/settings/account_group');
        }
        
        if (isset($_POST['save'])) {
            $this->auth->restrict($this->permissionEdit);

            if ($this->save_account_group('update', $id)) {
                log_activity($this->auth->user_id(), lang('account_group_act_edit_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'account_group');
                Template::set_message(lang('account_group_edit_success'), 'success');
                redirect(SITE_AREA . '/settings/account_group');
            }

            // Not validation error
            if ( ! empty($this->account_group_model->error)) {
                Template::set_message(lang('account_group_edit_failure') . $this->account_group_model->error, 'error');
            }
        }
        
        elseif (isset($_POST['delete'])) {
            $this->auth->restrict($this->permissionDelete);

            if ($this->account_group_model->delete($id)) {
                log_activity($this->auth->user_id(), lang('account_group_act_delete_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'account_group');
                Template::set_message(lang('account_group_delete_success'), 'success');

                redirect(SITE_AREA . '/settings/account_group');
            }

            Template::set_message(lang('account_group_delete_failure') . $this->account_group_model->error, 'error');
        }
        
        Template::set('account_group', $this->account_group_model->find($id));

        Template::set('toolbar_title', lang('account_group_edit_heading'));
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
    private function save_account_group($type = 'insert', $id = 0)
    {
        if ($type == 'update') {
            $_POST['id'] = $id;
        }

        // Validate the data
        $this->form_validation->set_rules($this->account_group_model->get_validation_rules());
        if ($this->form_validation->run() === false) {
            return false;
        }

        // Make sure we only pass in the fields we want
        
        $data = $this->account_group_model->prep_data($this->input->post());

        // Additional handling for default values should be added below,
        // or in the model's prep_data() method
        

        $return = false;
        if ($type == 'insert') {
            $id = $this->account_group_model->insert($data);

            if (is_numeric($id)) {
                $return = $id;
            }
        } elseif ($type == 'update') {
            $return = $this->account_group_model->update($id, $data);
        }

        return $return;
    }
}