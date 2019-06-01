<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Master controller
 */
class Master extends Admin_Controller
{
    protected $permissionCreate = 'Year_or_semester.Master.Create';
    protected $permissionDelete = 'Year_or_semester.Master.Delete';
    protected $permissionEdit   = 'Year_or_semester.Master.Edit';
    protected $permissionView   = 'Year_or_semester.Master.View';

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->auth->restrict($this->permissionView);
        $this->load->model('year_or_semester/year_or_semester_model');
        $this->load->model('course/course_model');
        $this->lang->load('year_or_semester');
        
            $this->form_validation->set_error_delimiters("<span class='error'>", "</span>");
        
        Template::set_block('sub_nav', 'master/_sub_nav');

        Assets::add_module_js('year_or_semester', 'year_or_semester.js');
    }

    /**
     * Display a list of Year or Semester data.
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
                    $deleted = $this->year_or_semester_model->delete($pid);
                    if ($deleted == false) {
                        $result = false;
                    }
                }
                if ($result) {
                    Template::set_message(count($checked) . ' ' . lang('year_or_semester_delete_success'), 'success');
                } else {
                    Template::set_message(lang('year_or_semester_delete_failure') . $this->year_or_semester_model->error, 'error');
                }
            }
        }
        $pagerUriSegment = 5;
        $pagerBaseUrl = site_url(SITE_AREA . '/master/year_or_semester/index') . '/';
        
        $limit  = $this->settings_lib->item('site.list_limit') ?: 15;

        $this->load->library('pagination');
        $pager['base_url']    = $pagerBaseUrl;
        $pager['total_rows']  = $this->year_or_semester_model->count_all();
        $pager['per_page']    = $limit;
        $pager['uri_segment'] = $pagerUriSegment;

        $this->pagination->initialize($pager);
        $this->year_or_semester_model->limit($limit, $offset);
        
        $records = $this->year_or_semester_model->find_all();

        Template::set('records', $records);
        
    Template::set('toolbar_title', lang('year_or_semester_manage'));

        Template::render();
    }
    
    /**
     * Create a Year or Semester object.
     *
     * @return void
     */
    public function create()
    {
        $this->auth->restrict($this->permissionCreate);

        if (isset($_POST['save'])) {

            //Get All Year or Semester By Course
            $year_semester = $this->year_or_semester_model->where('course_id',$this->input->post('course_id'))->find_all();
            //Get Single Course By Course Id
            $single_course = $this->course_model->find_by('id',$this->input->post('course_id'));
            if(sizeof($year_semester)<($single_course->no_of_frequency)){

                if ($insert_id = $this->save_year_or_semester()) {
                    log_activity($this->auth->user_id(), lang('year_or_semester_act_create_record') . ': ' . $insert_id . ' : ' . $this->input->ip_address(), 'year_or_semester');
                    Template::set_message(lang('year_or_semester_create_success'), 'success');

                    redirect(SITE_AREA . '/master/year_or_semester');
                }

            }
            else{
                Template::set_message(lang('year_or_semester_create_failure_limit') . $this->year_or_semester_model->error, 'error');
            }
            // Not validation error
            if ( ! empty($this->year_or_semester_model->error)) {
                Template::set_message(lang('year_or_semester_create_failure') . $this->year_or_semester_model->error, 'error');
            }
        }

        //Get All Course 
        $course = $this->course_model->where('deleted',0)->find_all();
        Template::set('course', $course);

        Template::set('toolbar_title', lang('year_or_semester_action_create'));

        Template::render();
    }
    /**
     * Allows editing of Year or Semester data.
     *
     * @return void
     */
    public function edit()
    {
        $id = $this->uri->segment(5);
        if (empty($id)) {
            Template::set_message(lang('year_or_semester_invalid_id'), 'error');

            redirect(SITE_AREA . '/master/year_or_semester');
        }
        
        if (isset($_POST['save'])) {
            $this->auth->restrict($this->permissionEdit);

            if ($this->save_year_or_semester('update', $id)) {
                log_activity($this->auth->user_id(), lang('year_or_semester_act_edit_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'year_or_semester');
                Template::set_message(lang('year_or_semester_edit_success'), 'success');
                redirect(SITE_AREA . '/master/year_or_semester');
            }

            // Not validation error
            if ( ! empty($this->year_or_semester_model->error)) {
                Template::set_message(lang('year_or_semester_edit_failure') . $this->year_or_semester_model->error, 'error');
            }
        }
        
        elseif (isset($_POST['delete'])) {
            $this->auth->restrict($this->permissionDelete);

            if ($this->year_or_semester_model->delete($id)) {
                log_activity($this->auth->user_id(), lang('year_or_semester_act_delete_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'year_or_semester');
                Template::set_message(lang('year_or_semester_delete_success'), 'success');

                redirect(SITE_AREA . '/master/year_or_semester');
            }

            Template::set_message(lang('year_or_semester_delete_failure') . $this->year_or_semester_model->error, 'error');
        }
        //Get All Course 
        $course = $this->course_model->where('deleted',0)->find_all();
        Template::set('course', $course);
        
        Template::set('year_or_semester', $this->year_or_semester_model->find($id));

        Template::set('toolbar_title', lang('year_or_semester_edit_heading'));
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
    private function save_year_or_semester($type = 'insert', $id = 0)
    {
        if ($type == 'update') {
            $_POST['id'] = $id;
        }

        // Validate the data
        $this->form_validation->set_rules($this->year_or_semester_model->get_validation_rules());
        if ($this->form_validation->run() === false) {
            return false;
        }

        // Make sure we only pass in the fields we want
        
        $data = $this->year_or_semester_model->prep_data($this->input->post());

        // Additional handling for default values should be added below,
        // or in the model's prep_data() method
        

        $return = false;
        if ($type == 'insert') {
            $id = $this->year_or_semester_model->insert($data);

            if (is_numeric($id)) {
                $return = $id;
            }
        } elseif ($type == 'update') {
            $return = $this->year_or_semester_model->update($id, $data);
        }

        return $return;
    }
}