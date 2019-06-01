<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Master controller
 */
class Master extends Admin_Controller
{
    protected $permissionCreate = 'Board_or_university.Master.Create';
    protected $permissionDelete = 'Board_or_university.Master.Delete';
    protected $permissionEdit   = 'Board_or_university.Master.Edit';
    protected $permissionView   = 'Board_or_university.Master.View';

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->auth->restrict($this->permissionView);
        $this->load->model('board_or_university/board_or_university_model');
        $this->lang->load('board_or_university');
        
            $this->form_validation->set_error_delimiters("<span class='error'>", "</span>");
        
        Template::set_block('sub_nav', 'master/_sub_nav');

        Assets::add_module_js('board_or_university', 'board_or_university.js');
    }

    /**
     * Display a list of Board or University data.
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
                    $deleted = $this->board_or_university_model->delete($pid);
                    if ($deleted == false) {
                        $result = false;
                    }
                }
                if ($result) {
                    Template::set_message(count($checked) . ' ' . lang('board_or_university_delete_success'), 'success');
                } else {
                    Template::set_message(lang('board_or_university_delete_failure') . $this->board_or_university_model->error, 'error');
                }
            }
        }
        $pagerUriSegment = 5;
        $pagerBaseUrl = site_url(SITE_AREA . '/master/board_or_university/index') . '/';
        
        $limit  = $this->settings_lib->item('site.list_limit') ?: 15;

        $this->load->library('pagination');
        $pager['base_url']    = $pagerBaseUrl;
        $pager['total_rows']  = $this->board_or_university_model->count_all();
        $pager['per_page']    = $limit;
        $pager['uri_segment'] = $pagerUriSegment;

        $this->pagination->initialize($pager);
        $this->board_or_university_model->limit($limit, $offset);
        
        $records = $this->board_or_university_model->find_all();

        Template::set('records', $records);
        
    Template::set('toolbar_title', lang('board_or_university_manage'));

        Template::render();
    }
    
    /**
     * Create a Board or University object.
     *
     * @return void
     */
    public function create()
    {
        $this->auth->restrict($this->permissionCreate);
        
        if (isset($_POST['save'])) {
            if ($insert_id = $this->save_board_or_university()) {
                log_activity($this->auth->user_id(), lang('board_or_university_act_create_record') . ': ' . $insert_id . ' : ' . $this->input->ip_address(), 'board_or_university');
                Template::set_message(lang('board_or_university_create_success'), 'success');

                redirect(SITE_AREA . '/master/board_or_university');
            }

            // Not validation error
            if ( ! empty($this->board_or_university_model->error)) {
                Template::set_message(lang('board_or_university_create_failure') . $this->board_or_university_model->error, 'error');
            }
        }

        Template::set('toolbar_title', lang('board_or_university_action_create'));

        Template::render();
    }
    /**
     * Allows editing of Board or University data.
     *
     * @return void
     */
    public function edit()
    {
        $id = $this->uri->segment(5);
        if (empty($id)) {
            Template::set_message(lang('board_or_university_invalid_id'), 'error');

            redirect(SITE_AREA . '/master/board_or_university');
        }
        
        if (isset($_POST['save'])) {
            $this->auth->restrict($this->permissionEdit);

            if ($this->save_board_or_university('update', $id)) {
                log_activity($this->auth->user_id(), lang('board_or_university_act_edit_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'board_or_university');
                Template::set_message(lang('board_or_university_edit_success'), 'success');
                redirect(SITE_AREA . '/master/board_or_university');
            }

            // Not validation error
            if ( ! empty($this->board_or_university_model->error)) {
                Template::set_message(lang('board_or_university_edit_failure') . $this->board_or_university_model->error, 'error');
            }
        }
        
        elseif (isset($_POST['delete'])) {
            $this->auth->restrict($this->permissionDelete);

            if ($this->board_or_university_model->delete($id)) {
                log_activity($this->auth->user_id(), lang('board_or_university_act_delete_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'board_or_university');
                Template::set_message(lang('board_or_university_delete_success'), 'success');

                redirect(SITE_AREA . '/master/board_or_university');
            }

            Template::set_message(lang('board_or_university_delete_failure') . $this->board_or_university_model->error, 'error');
        }
        
        Template::set('board_or_university', $this->board_or_university_model->find($id));

        Template::set('toolbar_title', lang('board_or_university_edit_heading'));
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
    private function save_board_or_university($type = 'insert', $id = 0)
    {
        if ($type == 'update') {
            $_POST['id'] = $id;
        }

        // Validate the data
        $this->form_validation->set_rules($this->board_or_university_model->get_validation_rules());
        if ($this->form_validation->run() === false) {
            return false;
        }

        // Make sure we only pass in the fields we want
        
        $data = $this->board_or_university_model->prep_data($this->input->post());

        // Additional handling for default values should be added below,
        // or in the model's prep_data() method
        

        $return = false;
        if ($type == 'insert') {
            $id = $this->board_or_university_model->insert($data);

            if (is_numeric($id)) {
                $return = $id;
            }
        } elseif ($type == 'update') {
            $return = $this->board_or_university_model->update($id, $data);
        }

        return $return;
    }
}