<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Master controller
 */
class Master extends Admin_Controller
{
    protected $permissionCreate = 'Fee_stucture.Master.Create';
    protected $permissionDelete = 'Fee_stucture.Master.Delete';
    protected $permissionEdit   = 'Fee_stucture.Master.Edit';
    protected $permissionView   = 'Fee_stucture.Master.View';

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->auth->restrict($this->permissionView);
        $this->load->model('fee_stucture/fee_stucture_model');
        $this->load->model('course/course_model');
        $this->load->model('course_wise_subjects/course_wise_subjects_model');
        $this->load->model('fee_heads/fee_heads_model');
        $this->lang->load('fee_stucture');
        
            $this->form_validation->set_error_delimiters("<span class='error'>", "</span>");
        
        Template::set_block('sub_nav', 'master/_sub_nav');

        Assets::add_module_js('fee_stucture', 'fee_stucture.js');
    }

    /**
     * Display a list of Fee Stucture data.
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
                    $deleted = $this->fee_stucture_model->delete($pid);
                    if ($deleted == false) {
                        $result = false;
                    }
                }
                if ($result) {
                    Template::set_message(count($checked) . ' ' . lang('fee_stucture_delete_success'), 'success');
                } else {
                    Template::set_message(lang('fee_stucture_delete_failure') . $this->fee_stucture_model->error, 'error');
                }
            }
        }
        $pagerUriSegment = 5;
        $pagerBaseUrl = site_url(SITE_AREA . '/master/fee_stucture/index') . '/';
        
        $limit  = $this->settings_lib->item('site.list_limit') ?: 15;

        $this->load->library('pagination');
        $pager['base_url']    = $pagerBaseUrl;

        if (isset($_POST['action_search'])) {

            $course = $this->input->post('course');
            $year = $this->input->post('year_semester');
            if($course!='' and $year!=''){
                $pager['total_rows'] = $this->fee_stucture_model->count_by(array('course_id'=>$course, 'year_or_semester_id'=>$year));
            }else{
                $pager['total_rows'] = $this->fee_stucture_model->count_all();
            }
        }else{
                $pager['total_rows'] = $this->fee_stucture_model->count_all();
        }
        $pager['per_page']    = $limit;
        $pager['uri_segment'] = $pagerUriSegment;

        $this->pagination->initialize($pager);
        $this->fee_stucture_model->limit($limit, $offset);

        if (isset($_POST['action_search'])) {

            $course = $this->input->post('course');
            $year = $this->input->post('year_semester');

            if($course!='' and $year!=''){
                $records = $this->fee_stucture_model->find_all_by(array('course_id'=>$course, 'year_or_semester_id'=>$year)) ;
            }else{
                $records = $this->fee_stucture_model->find_all() ;
            }
        }else{
                $records = $this->fee_stucture_model->find_all();
        }

        Template::set('records', $records);

        //Get All Courses
        $course = $this->course_model->where('deleted',0)->find_all();
        Template::set('course', $course);
        
    Template::set('toolbar_title', lang('fee_stucture_manage'));

        Template::render();
    }
    
    /**
     * Create a Fee Stucture object.
     *
     * @return void
     */
    public function create()
    {
        $this->auth->restrict($this->permissionCreate);
        
        if (isset($_POST['save'])) {
            if ($insert_id = $this->save_fee_stucture()) {
                log_activity($this->auth->user_id(), lang('fee_stucture_act_create_record') . ': ' . $insert_id . ' : ' . $this->input->ip_address(), 'fee_stucture');
                Template::set_message(lang('fee_stucture_create_success'), 'success');

                redirect(SITE_AREA . '/master/fee_stucture');
            }

            // Not validation error
            if ( ! empty($this->fee_stucture_model->error)) {
                Template::set_message(lang('fee_stucture_create_failure') . $this->fee_stucture_model->error, 'error');
            }
        }

        $course = $this->course_model->where('deleted',0)->find_all();
        Template::set('course', $course);

        $fee_head = $this->fee_heads_model->find_all();
        Template::set('fee_head', $fee_head);

        Template::set('toolbar_title', lang('fee_stucture_action_create'));

        Template::render();
    }
    /**
     * Allows editing of Fee Stucture data.
     *
     * @return void
     */
    public function edit()
    {
        $id = $this->uri->segment(5);
        if (empty($id)) {
            Template::set_message(lang('fee_stucture_invalid_id'), 'error');

            redirect(SITE_AREA . '/master/fee_stucture');
        }
        
        if (isset($_POST['save'])) {
            $this->auth->restrict($this->permissionEdit);

            if ($this->save_fee_stucture('update', $id)) {
                log_activity($this->auth->user_id(), lang('fee_stucture_act_edit_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'fee_stucture');
                Template::set_message(lang('fee_stucture_edit_success'), 'success');
                redirect(SITE_AREA . '/master/fee_stucture');
            }

            // Not validation error
            if ( ! empty($this->fee_stucture_model->error)) {
                Template::set_message(lang('fee_stucture_edit_failure') . $this->fee_stucture_model->error, 'error');
            }
        }
        
        elseif (isset($_POST['delete'])) {
            $this->auth->restrict($this->permissionDelete);

            if ($this->fee_stucture_model->delete($id)) {
                log_activity($this->auth->user_id(), lang('fee_stucture_act_delete_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'fee_stucture');
                Template::set_message(lang('fee_stucture_delete_success'), 'success');

                redirect(SITE_AREA . '/master/fee_stucture');
            }

            Template::set_message(lang('fee_stucture_delete_failure') . $this->fee_stucture_model->error, 'error');
        }

        $fee_stucture = $this->fee_stucture_model->find($id);
        Template::set('fee_stucture', $fee_stucture);

        $course = $this->course_model->where('deleted',0)->find_all();
        Template::set('course', $course);

        $year_sem = $this->course_wise_subjects_model->getYearOrSemester($fee_stucture->course_id);
        Template::set('year_sem', $year_sem);

        $fee_head = $this->fee_heads_model->find_all();
        Template::set('fee_head', $fee_head);

        Template::set('toolbar_title', lang('fee_stucture_edit_heading'));
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
    private function save_fee_stucture($type = 'insert', $id = 0)
    {
        if ($type == 'update') {
            $_POST['id'] = $id;
        }

        // Validate the data
        $this->form_validation->set_rules($this->fee_stucture_model->get_validation_rules());
        if ($this->form_validation->run() === false) {
            return false;
        }

        // Make sure we only pass in the fields we want
        
        $data = $this->fee_stucture_model->prep_data($this->input->post());

        // Additional handling for default values should be added below,
        // or in the model's prep_data() method
        

        $return = false;
        if ($type == 'insert') {
            $id = $this->fee_stucture_model->insert($data);

            if (is_numeric($id)) {
                $return = $id;
            }
        } elseif ($type == 'update') {
            $return = $this->fee_stucture_model->update($id, $data);
        }

        return $return;
    }
}