<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Master controller
 */
class Master extends Admin_Controller
{
    protected $permissionCreate = 'Course_wise_subjects.Master.Create';
    protected $permissionDelete = 'Course_wise_subjects.Master.Delete';
    protected $permissionEdit   = 'Course_wise_subjects.Master.Edit';
    protected $permissionView   = 'Course_wise_subjects.Master.View';

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->auth->restrict($this->permissionView);
        $this->load->model('course_wise_subjects/course_wise_subjects_model');
        $this->load->model('year_or_semester/year_or_semester_model');
        $this->load->model('course/course_model');
        $this->load->model('subject/subject_model');
        $this->lang->load('course_wise_subjects');
        
            $this->form_validation->set_error_delimiters("<span class='error'>", "</span>");
        
        Template::set_block('sub_nav', 'master/_sub_nav');

        Assets::add_module_js('course_wise_subjects', 'course_wise_subjects.js');
    }

    /**
     * Display a list of Course wise subjects data.
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
                    $deleted = $this->course_wise_subjects_model->delete($pid);
                    if ($deleted == false) {
                        $result = false;
                    }
                }
                if ($result) {
                    Template::set_message(count($checked) . ' ' . lang('course_wise_subjects_delete_success'), 'success');
                } else {
                    Template::set_message(lang('course_wise_subjects_delete_failure') . $this->course_wise_subjects_model->error, 'error');
                }
            }
        }
        $pagerUriSegment = 5;
        $pagerBaseUrl = site_url(SITE_AREA . '/master/course_wise_subjects/index') . '/';
        
        $limit  = $this->settings_lib->item('site.list_limit') ?: 15;

        $this->load->library('pagination');
        $pager['base_url']    = $pagerBaseUrl;
        $pager['total_rows']  = $this->course_wise_subjects_model->count_all();
        $pager['per_page']    = $limit;
        $pager['uri_segment'] = $pagerUriSegment;

        $this->pagination->initialize($pager);
        $this->course_wise_subjects_model->limit($limit, $offset);
        
        $records = $this->course_wise_subjects_model->find_all();

        Template::set('records', $records);
        
    Template::set('toolbar_title', lang('course_wise_subjects_manage'));

        Template::render();
    }
    
    /**
     * Create a Course wise subjects object.
     *
     * @return void
     */
    public function create()
    {
        $this->auth->restrict($this->permissionCreate);
        
        if (isset($_POST['save'])) {
            if ($insert_id = $this->save_course_wise_subjects()) {
                log_activity($this->auth->user_id(), lang('course_wise_subjects_act_create_record') . ': ' . $insert_id . ' : ' . $this->input->ip_address(), 'course_wise_subjects');
                Template::set_message(lang('course_wise_subjects_create_success'), 'success');

                redirect(SITE_AREA . '/master/course_wise_subjects');
            }

            // Not validation error
            if ( ! empty($this->course_wise_subjects_model->error)) {
                Template::set_message(lang('course_wise_subjects_create_failure') . $this->course_wise_subjects_model->error, 'error');
            }
        }

        $course = $this->course_model->where('deleted',0)->find_all();
        Template::set('course', $course);

        $subject = $this->subject_model->where('deleted',0)->find_all();
        Template::set('subject', $subject);

        Template::set('toolbar_title', lang('course_wise_subjects_action_create'));

        Template::render();
    }
    /**
     * Allows editing of Course wise subjects data.
     *
     * @return void
     */
    public function edit()
    {
        $id = $this->uri->segment(5);
        if (empty($id)) {
            Template::set_message(lang('course_wise_subjects_invalid_id'), 'error');

            redirect(SITE_AREA . '/master/course_wise_subjects');
        }
        
        if (isset($_POST['save'])) {
            $this->auth->restrict($this->permissionEdit);

            if ($this->save_course_wise_subjects('update', $id)) {
                log_activity($this->auth->user_id(), lang('course_wise_subjects_act_edit_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'course_wise_subjects');
                Template::set_message(lang('course_wise_subjects_edit_success'), 'success');
                redirect(SITE_AREA . '/master/course_wise_subjects');
            }

            // Not validation error
            if ( ! empty($this->course_wise_subjects_model->error)) {
                Template::set_message(lang('course_wise_subjects_edit_failure') . $this->course_wise_subjects_model->error, 'error');
            }
        }
        
        elseif (isset($_POST['delete'])) {
            $this->auth->restrict($this->permissionDelete);

            if ($this->course_wise_subjects_model->delete($id)) {
                log_activity($this->auth->user_id(), lang('course_wise_subjects_act_delete_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'course_wise_subjects');
                Template::set_message(lang('course_wise_subjects_delete_success'), 'success');

                redirect(SITE_AREA . '/master/course_wise_subjects');
            }

            Template::set_message(lang('course_wise_subjects_delete_failure') . $this->course_wise_subjects_model->error, 'error');
        }

        $course = $this->course_model->where('deleted',0)->find_all();
        Template::set('course', $course);

        $subject = $this->subject_model->where('deleted',0)->find_all();
        Template::set('subject', $subject);

        $course_wise_subjects = $this->course_wise_subjects_model->find($id);

        Template::set('course_wise_subjects', $course_wise_subjects);

        $year_sem = $this->year_or_semester_model->where('course_id',$course_wise_subjects->course_id)->find_all();
        Template::set('year_sem', $year_sem);

        Template::set('toolbar_title', lang('course_wise_subjects_edit_heading'));
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
    private function save_course_wise_subjects($type = 'insert', $id = 0)
    {
        if ($type == 'update') {
            $_POST['id'] = $id;
        }

        // Validate the data
        $this->form_validation->set_rules($this->course_wise_subjects_model->get_validation_rules());
        if ($this->form_validation->run() === false) {
            return false;
        }

        // Make sure we only pass in the fields we want
        
        $data = $this->course_wise_subjects_model->prep_data($this->input->post());

        // Additional handling for default values should be added below,
        // or in the model's prep_data() method
        

        $return = false;
        if ($type == 'insert') {
            $id = $this->course_wise_subjects_model->insert($data);

            if (is_numeric($id)) {
                $return = $id;
            }
        } elseif ($type == 'update') {
            $return = $this->course_wise_subjects_model->update($id, $data);
        }

        return $return;
    }
    public function getYearOrSemester()
    {
        $course_id = $this->input->post('course_id'); 
        $year_sem =  $this->course_wise_subjects_model->getYearOrSemester($course_id);
        echo json_encode(array('token'=>$this->security->get_csrf_hash(),'data'=>$year_sem));
    }
}