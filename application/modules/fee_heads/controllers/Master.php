<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Master controller
 */
class Master extends Admin_Controller
{
    protected $permissionCreate = 'Fee_heads.Master.Create';
    protected $permissionDelete = 'Fee_heads.Master.Delete';
    protected $permissionEdit   = 'Fee_heads.Master.Edit';
    protected $permissionView   = 'Fee_heads.Master.View';

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->auth->restrict($this->permissionView);
        $this->load->model('fee_heads/fee_heads_model');
        $this->lang->load('fee_heads');
        
            $this->form_validation->set_error_delimiters("<span class='error'>", "</span>");
        
        Template::set_block('sub_nav', 'master/_sub_nav');

        Assets::add_module_js('fee_heads', 'fee_heads.js');
    }

    /**
     * Display a list of Fee Heads data.
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
                    $deleted = $this->fee_heads_model->delete($pid);
                    if ($deleted == false) {
                        $result = false;
                    }
                }
                if ($result) {
                    Template::set_message(count($checked) . ' ' . lang('fee_heads_delete_success'), 'success');
                } else {
                    Template::set_message(lang('fee_heads_delete_failure') . $this->fee_heads_model->error, 'error');
                }
            }
        }
        $pagerUriSegment = 5;
        $pagerBaseUrl = site_url(SITE_AREA . '/master/fee_heads/index') . '/';
        
        $limit  = $this->settings_lib->item('site.list_limit') ?: 15;

        $this->load->library('pagination');
        $pager['base_url']    = $pagerBaseUrl;
        $pager['total_rows']  = $this->fee_heads_model->count_all();
        $pager['per_page']    = $limit;
        $pager['uri_segment'] = $pagerUriSegment;

        $this->pagination->initialize($pager);
        $this->fee_heads_model->limit($limit, $offset);
        
        $records = $this->fee_heads_model->find_all();

        Template::set('records', $records);
        
    Template::set('toolbar_title', lang('fee_heads_manage'));

        Template::render();
    }
    
    /**
     * Create a Fee Heads object.
     *
     * @return void
     */
    public function create()
    {
        $this->auth->restrict($this->permissionCreate);
        
        if (isset($_POST['save'])) {
            if ($insert_id = $this->save_fee_heads()) {
                log_activity($this->auth->user_id(), lang('fee_heads_act_create_record') . ': ' . $insert_id . ' : ' . $this->input->ip_address(), 'fee_heads');
                Template::set_message(lang('fee_heads_create_success'), 'success');

                redirect(SITE_AREA . '/master/fee_heads');
            }

            // Not validation error
            if ( ! empty($this->fee_heads_model->error)) {
                Template::set_message(lang('fee_heads_create_failure') . $this->fee_heads_model->error, 'error');
            }
        }

        Template::set('toolbar_title', lang('fee_heads_action_create'));

        Template::render();
    }
    /**
     * Allows editing of Fee Heads data.
     *
     * @return void
     */
    public function edit()
    {
        $id = $this->uri->segment(5);
        if (empty($id)) {
            Template::set_message(lang('fee_heads_invalid_id'), 'error');

            redirect(SITE_AREA . '/master/fee_heads');
        }
        
        if (isset($_POST['save'])) {
            $this->auth->restrict($this->permissionEdit);

            if ($this->save_fee_heads('update', $id)) {
                log_activity($this->auth->user_id(), lang('fee_heads_act_edit_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'fee_heads');
                Template::set_message(lang('fee_heads_edit_success'), 'success');
                redirect(SITE_AREA . '/master/fee_heads');
            }

            // Not validation error
            if ( ! empty($this->fee_heads_model->error)) {
                Template::set_message(lang('fee_heads_edit_failure') . $this->fee_heads_model->error, 'error');
            }
        }
        
        elseif (isset($_POST['delete'])) {
            $this->auth->restrict($this->permissionDelete);

            if ($this->fee_heads_model->delete($id)) {
                log_activity($this->auth->user_id(), lang('fee_heads_act_delete_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'fee_heads');
                Template::set_message(lang('fee_heads_delete_success'), 'success');

                redirect(SITE_AREA . '/master/fee_heads');
            }

            Template::set_message(lang('fee_heads_delete_failure') . $this->fee_heads_model->error, 'error');
        }
        
        Template::set('fee_heads', $this->fee_heads_model->find($id));

        Template::set('toolbar_title', lang('fee_heads_edit_heading'));
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
    private function save_fee_heads($type = 'insert', $id = 0)
    {
        if ($type == 'update') {
            $_POST['id'] = $id;
        }

        // Validate the data
        $this->form_validation->set_rules($this->fee_heads_model->get_validation_rules());
        if ($this->form_validation->run() === false) {
            return false;
        }

        // Make sure we only pass in the fields we want
        
        $data = $this->fee_heads_model->prep_data($this->input->post());

        // Additional handling for default values should be added below,
        // or in the model's prep_data() method
        

        $return = false;
        if ($type == 'insert') {
            $id = $this->fee_heads_model->insert($data);

            if (is_numeric($id)) {
                $return = $id;
            }
        } elseif ($type == 'update') {
            $return = $this->fee_heads_model->update($id, $data);
        }

        return $return;
    }
}