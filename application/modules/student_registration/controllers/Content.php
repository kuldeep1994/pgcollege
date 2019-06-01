<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Content controller
 */
class Content extends Admin_Controller
{
    protected $permissionCreate = 'Student_registration.Content.Create';
    protected $permissionDelete = 'Student_registration.Content.Delete';
    protected $permissionEdit   = 'Student_registration.Content.Edit';
    protected $permissionView   = 'Student_registration.Content.View';

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->auth->restrict($this->permissionView);
        $this->load->model('student_registration/student_registration_model');
        $this->load->model('school_institute/school_institute_model');
        $this->load->model('qualification/qualification_model');
        $this->load->model('subject/subject_model');
        $this->load->model('year_or_semester/year_or_semester_model');
        $this->load->model('course_wise_subjects/course_wise_subjects_model');
        $this->load->model('address/address_model');
        $this->load->model('course/course_model');
        $this->lang->load('student_registration');
        $this->load->model('fee_heads/fee_heads_model');
        $this->load->model('school_institute/school_institute_model');
        $this->load->model('board_or_university/board_or_university_model');
        $this->load->model('organization/organization_model');
        
            Assets::add_css('flick/jquery-ui-1.8.13.custom.css');
            Assets::add_js('jquery-ui-1.8.13.min.js');
            $this->form_validation->set_error_delimiters("<span class='error'>", "</span>");
        
        Template::set_block('sub_nav', 'content/_sub_nav');

        Assets::add_module_js('student_registration', 'student_registration.js');
    }

    /**
     * Display a list of Student Registration data.
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
                    $deleted = $this->student_registration_model->delete($pid);
                    if ($deleted == false) {
                        $result = false;
                    }
                }
                if ($result) {
                    Template::set_message(count($checked) . ' ' . lang('student_registration_delete_success'), 'success');
                } else {
                    Template::set_message(lang('student_registration_delete_failure') . $this->student_registration_model->error, 'error');
                }
            }
        }
        
        $records = $this->student_registration_model->where('deleted', 0)->find_all();

        Template::set('records', $records);
        
        Template::set('toolbar_title', lang('student_registration_manage'));

        Template::render();
    }
    
    /**
     * Create a Student Registration object.
     *
     * @return void
     */
    public function create()
    {
        $this->auth->restrict($this->permissionCreate);
        
        if (isset($_POST['save'])) 
        {

            if ($insert_id = $this->save_student_registration()) 
            {
                if($insert_id)
                {

                    //Update Student Test Subject In registration Table
                    $test_subject = $this->input->post('test_subjects');

                    if(!empty($test_subject)){
                        $data_test_subject['subjects'] = implode(',',$test_subject);
                        $this->db->where('id',$insert_id);
                        $this->db->update('bf_registration',$data_test_subject);
                    }

                    //Insert Student Address In Address Table
                    $permanent_address['street_address'] = $this->input->post('street_address_permanent');
                    $permanent_address['country'] = $this->input->post('country_permanent');
                    $permanent_address['state'] = $this->input->post('state_permanent');
                    $permanent_address['city'] = $this->input->post('city_permanent');
                    $permanent_address['zip_code'] = $this->input->post('zip_code_permanent');
                    $permanent_address['address_type'] = 'permanent';
                    $permanent_address['registration_id'] = $insert_id;
                    $this->db->insert('bf_address',$permanent_address);

                    //Insert Student Qualfication In qualification Table
                    if(!empty($_POST['class'])){ 
                        foreach($_POST['class'] as $key=>$value){
                                $qualification['class'] = $value;
                                $qualification['stream'] = $_POST['stream'][$key];
                                $qualification['organization'] = $_POST['organization'][$key];
                                $qualification['board'] = $_POST['board'][$key];
                                $qualification['roll_no'] = $_POST['roll_no'][$key];
                                $qualification['total_marks'] = $_POST['total_marks'][$key];
                                $qualification['obtained_marks'] = $_POST['obtained_mark'][$key];
                                $qualification['percentage'] = $_POST['percentage'][$key];
                                $qualification['pass_year'] = $_POST['pass_year'][$key];
                                $qualification['registration_id'] = $insert_id;

                                $this->db->insert('bf_qualification',$qualification);
                        }
                    }

                }

                log_activity($this->auth->user_id(), lang('student_registration_act_create_record') . ': ' . $insert_id . ' : ' . $this->input->ip_address(), 'student_registration');
                Template::set_message(lang('student_registration_create_success'), 'success');
                redirect(SITE_AREA . '/content/student_registration');

            }

            // Not validation error
            if ( ! empty($this->student_registration_model->error)) 
            {
                Template::set_message(lang('student_registration_create_failure') . $this->student_registration_model->error, 'error');
            }
        }

        //Get Country,state,city
        $country = $this->db->get('bf_countries_1')->result();
        $state = $this->db->get_where('bf_states_1',array('country_id'=>'101'))->result();
        $city = $this->db->get_where('bf_cities_1',array('state_id'=>'38'))->result();
        Template::set('countries', $country);
        Template::set('state', $state);
        Template::set('city', $city);

        //Get all courses
        $course = $this->course_model->where('deleted',0)->find_all();
        Template::set('course', $course);

        //Get All Courses Subjects
        $subject = $this->subject_model->where('deleted',0)->find_all();
        Template::set('subject', $subject);

        //Get fee category
        $fee_cat = $this->fee_heads_model->find_all();
        Template::set('fee_cat', $fee_cat);

        //Get last school
        $last_school = $this->school_institute_model->where('deleted',0)->find_all();
        Template::set('last_school', $last_school);

        //Get Board or University
        $board = $this->board_or_university_model->find_all();
        Template::set('board', $board);

        //Get Organization
        $organization = $this->organization_model->find_all();
        Template::set('organization', $organization);

        Template::set('toolbar_title', lang('student_registration_action_create'));

        Template::render();
    }
    /**
     * Allows editing of Student Registration data.
     *
     * @return void
     */
    public function edit()
    {
        $id = $this->uri->segment(5);
        if (empty($id)) {
            Template::set_message(lang('student_registration_invalid_id'), 'error');

            redirect(SITE_AREA . '/content/student_registration');
        }
        
        if (isset($_POST['save'])) 
        {
            $this->auth->restrict($this->permissionEdit);

            if ($this->save_student_registration('update', $id)) 
            {

                if($id){

                    //Update Student Test Subject In registration Table
                    $test_subject = $this->input->post('test_subjects');

                    if(!empty($test_subject)){
                        $data_test_subject['subjects'] = implode(',',$test_subject);
                        $this->db->where('id',$id);
                        $this->db->update('bf_registration',$data_test_subject);
                    }

                    //Insert Student Address In Address Table
                    $address['street_address'] = $this->input->post('street_address_permanent');
                    $address['country'] = $this->input->post('country_permanent');
                    $address['state'] = $this->input->post('state_permanent');
                    $address['city'] = $this->input->post('city_permanent');
                    $address['zip_code'] = $this->input->post('zip_code_permanent');
                    $address['address_type'] = 'permanent';
                    $address['registration_id'] = $id;

                    if(!empty($address)){
                        $this->db->where('id',$id);
                        $this->db->update('bf_address',$address);
                    }

                    //Update Student Qualfication In qualification Table
                    if(!empty($_POST['class'])){ 
                        $this->db->where('registration_id',$id);
                        if($this->db->delete('bf_qualification')){ 
                            foreach($_POST['class'] as $key=>$value){
                                    $qualification['class'] = $value;
                                    $qualification['stream'] = $_POST['stream'][$key];
                                    $qualification['organization'] = $_POST['organization'][$key];
                                    $qualification['board'] = $_POST['board'][$key];
                                    $qualification['roll_no'] = $_POST['roll_no'][$key];
                                    $qualification['total_marks'] = $_POST['total_marks'][$key];
                                    $qualification['obtained_marks'] = $_POST['obtained_mark'][$key];
                                    $qualification['percentage'] = $_POST['percentage'][$key];
                                    $qualification['pass_year'] = $_POST['pass_year'][$key];
                                    $qualification['registration_id'] = $id;

                                    $this->db->insert('bf_qualification',$qualification);
                            }
                        }
                    }

                }

                log_activity($this->auth->user_id(), lang('student_registration_act_edit_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'student_registration');
                Template::set_message(lang('student_registration_edit_success'), 'success');
                redirect(SITE_AREA . '/content/student_registration');
            }

            // Not validation error
            if ( ! empty($this->student_registration_model->error)) 
            {
                Template::set_message(lang('student_registration_edit_failure') . $this->student_registration_model->error, 'error');
            }
        }
        
        elseif (isset($_POST['delete'])) {
            $this->auth->restrict($this->permissionDelete);

            if ($this->student_registration_model->delete($id)) {
                log_activity($this->auth->user_id(), lang('student_registration_act_delete_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'student_registration');
                Template::set_message(lang('student_registration_delete_success'), 'success');

                redirect(SITE_AREA . '/content/student_registration');
            }

            Template::set_message(lang('student_registration_delete_failure') . $this->student_registration_model->error, 'error');
        }

        //Get Country 
        $records = $this->db->get('bf_countries_1')->result();
        Template::set('countries', $records);

        //Qualification
        $qualification = $this->qualification_model->find_all_by(array('registration_id'=>$id));
        Template::set('qualification', $qualification);

        //Address
        $address = $this->address_model->find_by(array('registration_id'=>$id));
        Template::set('address', $address);
        if(!empty($address->country)){
            $address_state = $this->address_model->getState($address->country);
            Template::set('state', $address_state);   
        }
        if(!empty($address->state)){
            $address_city = $this->address_model->getCity($address->state);
            Template::set('city', $address_city);
        }

        //Get All Courses
        $course = $this->course_model->where('deleted',0)->find_all();
        Template::set('course', $course);

        //Get Registration details
        $student_registration = $this->student_registration_model->find($id);
        Template::set('student_registration', $student_registration);

        //Get All Courses Subjects
        $subject = $this->subject_model->where('deleted',0)->find_all();
        Template::set('subject', $subject);

        //Student choose Subjects
        if(!empty($student_registration->subjects)){ 
            $st_subject = explode(',',$student_registration->subjects);
            Template::set('student_subject', $st_subject);
        }

        //Get fee category
        $fee_cat = $this->fee_heads_model->find_all();
        Template::set('fee_cat', $fee_cat);

        //Get last school
        $last_school = $this->school_institute_model->where('deleted',0)->find_all();
        Template::set('last_school', $last_school);

        //Get Board or University
        $board = $this->board_or_university_model->find_all();
        Template::set('board', $board);

        //Get Organization
        $organization = $this->organization_model->find_all();
        Template::set('organization', $organization);

        Template::set('toolbar_title', lang('student_registration_edit_heading'));
        Template::render();
    }

    public function admission()
    {
        $id = $this->uri->segment(5);
        if (empty($id)) {
            Template::set_message(lang('student_registration_invalid_id'), 'error');

            redirect(SITE_AREA . '/content/student_registration');
        }
        
        if (isset($_POST['save'])) 
        {
            $this->auth->restrict($this->permissionEdit);

            if ($this->save_student_registration('update', $id)) 
            {

                if($id){

                    //Update Student Subject In Student Subject Table
                    $subject = $this->input->post('student_subjects');

                    if(!empty($subject)){
                        $this->db->where('registration_id',$id);
                        if($this->db->delete('bf_student_subjects')){
                            foreach($subject as $row){
                                $student_subject['subject_id'] = $row;
                                $student_subject['registration_id'] = $id;
                                $this->db->insert('bf_student_subjects',$student_subject);
                            }
                        }
                    }

                    //Insert Student Address In Address Table
                    $address['street_address'] = $this->input->post('street_address_permanent');
                    $address['country'] = $this->input->post('country_permanent');
                    $address['state'] = $this->input->post('state_permanent');
                    $address['city'] = $this->input->post('city_permanent');
                    $address['zip_code'] = $this->input->post('zip_code_permanent');
                    $address['address_type'] = 'permanent';
                    $address['registration_id'] = $id;

                    if(!empty($address)){
                        $this->db->where('id',$id);
                        $this->db->update('bf_address',$address);
                    }

                    //Upload Student Photo
                    if(!empty($_FILES['photo_image']['name']))
                    {
                        $config['upload_path']   = 'assets/student_photo';
                        $config['allowed_types'] = 'jpg|gif|png|jpeg|JPG|PNG';
                        $config['file_name']     =  $_FILES['photo_image']['name'];
                        
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        if($this->upload->do_upload('photo_image'))
                        {
                            $fileDatas      = $this->upload->data();
                            $data['student_photo']  = $fileDatas['file_name'];
                        }
                        else
                        {
                            $error          = array('error' => $this->upload->display_errors());
                        }
                    }

                    //Upload Student Signature
                    if(!empty($_FILES['signature_image']['name']))
                    {
                        $config['upload_path']   = 'assets/student_signature';
                        $config['allowed_types'] = 'jpg|gif|png|jpeg|JPG|PNG';
                        $config['file_name']     =  $_FILES['signature_image']['name'];
                        
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        if($this->upload->do_upload('signature_image'))
                        {
                            $fileDatas      = $this->upload->data();
                            $data['student_signature']  = $fileDatas['file_name'];
                        }
                        else
                        {
                            $error          = array('error' => $this->upload->display_errors());
                        }
                    }

                    $data['registration_id'] = $id;
                    $data['course'] = $this->input->post('standard');
                    $data['year_sem'] = $this->input->post('year_sem');
                    $data['birth_place'] = $this->input->post('birth_place');
                    $data['stream_or_branch'] = $this->input->post('stream_or_branch');
                    $data['status'] = $this->input->post('status');
                    $data['disability'] = $this->input->post('disability');
                    $data['mark_of_identification'] = $this->input->post('mark_of_identification');
                    $data['student_id'] = $this->input->post('student_id');
                    $data['sr_no'] = $this->input->post('sr_no');
                    $data['medium'] = $this->input->post('medium');
                    $data['admission_date'] = $this->input->post('admission_date');
                    $data['pass_out'] = $this->input->post('pass_out');
                    $data['tc_issued'] = $this->input->post('tc_issued');
                    $data['promoted'] = $this->input->post('promoted');
                    $data['email'] = $this->input->post('email');

                    $chk_admission = $this->db->get_where('bf_student_admission',array('registration_id'=>$id))->row();
                    if(!empty($chk_admission)){
                        $this->db->where('registration_id',$id);
                        $this->db->update('bf_student_admission',$data);
                    }else{
                        $this->db->insert('bf_student_admission',$data);
                    }
                }

                log_activity($this->auth->user_id(), lang('student_registration_act_edit_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'student_registration');
                Template::set_message(lang('student_registration_edit_success'), 'success');
                redirect(SITE_AREA . '/content/student_registration');
            }

            // Not validation error
            if ( ! empty($this->student_registration_model->error)) 
            {
                Template::set_message(lang('student_registration_edit_failure') . $this->student_registration_model->error, 'error');
            }
        }
        
        elseif (isset($_POST['delete'])) {
            $this->auth->restrict($this->permissionDelete);

            if ($this->student_registration_model->delete($id)) {
                log_activity($this->auth->user_id(), lang('student_registration_act_delete_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'student_registration');
                Template::set_message(lang('student_registration_delete_success'), 'success');

                redirect(SITE_AREA . '/content/student_registration');
            }

            Template::set_message(lang('student_registration_delete_failure') . $this->student_registration_model->error, 'error');
        }

        //Get Country Record
        $records = $this->db->get('bf_countries_1')->result();
        Template::set('countries', $records);

        //Get Qualification Record
        $qualification = $this->qualification_model->find_all_by(array('registration_id'=>$id));
        Template::set('qualification', $qualification);

        //Get Address Record
        $address = $this->address_model->find_by(array('registration_id'=>$id));
        Template::set('address', $address);
        if(!empty($address->country)){
            $address_state = $this->address_model->getState($address->country);
            Template::set('state', $address_state);   
        }
        if(!empty($address->state)){
            $address_city = $this->address_model->getCity($address->state);
            Template::set('city', $address_city);
        }

        //Get Student Record
        $student_registration = $this->student_registration_model->find($id);
        Template::set('student_registration', $student_registration);

        //Get Course
        $course = $this->course_model->where('deleted',0)->find_all();
        Template::set('course', $course);

        //Year Or Semester List By Course
        if(!empty($student_registration->standard)){
        $year_sem = $this->year_or_semester_model->where('course_id',$student_registration->standard)->find_all();
        Template::set('year_sem', $year_sem);
        }

        //Get Student Subject
        $student_subject = $this->db->get_where('bf_student_subjects',array('registration_id'=>$id))->result();
        Template::set('student_subject', $student_subject);

        //Get All Courses Subjects
        $subject = $this->subject_model->where('deleted',0)->find_all();
        Template::set('subject', $subject);

        //Get Admission Details
        $admission = $this->db->get_where('bf_student_admission',array('registration_id'=>$id))->row();
        Template::set('admission', $admission);

        //Get fee category
        $fee_cat = $this->fee_heads_model->find_all();
        Template::set('fee_cat', $fee_cat);

        //Get last school
        $last_school = $this->school_institute_model->where('deleted',0)->find_all();
        Template::set('last_school', $last_school);

        Template::set('toolbar_title', lang('student_registration_edit_heading'));
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
    private function save_student_registration($type = 'insert', $id = 0)
    {
        if ($type == 'update') {
            $_POST['id'] = $id;
        }
        // Validate the data
        $this->form_validation->set_rules($this->student_registration_model->get_validation_rules());
        if ($this->form_validation->run() === false) {
            return false;
        }

        // Make sure we only pass in the fields we want
        
        $data = $this->student_registration_model->prep_data($this->input->post());

        // Additional handling for default values should be added below,
        // or in the model's prep_data() method
        
		$data['dob']	= $this->input->post('dob') ? $this->input->post('dob') : '0000-00-00';

        $return = false;
        if ($type == 'insert') {
            $id = $this->student_registration_model->insert($data);

            if (is_numeric($id)) {
                $return = $id;
            }
        } elseif ($type == 'update') {
            $return = $this->student_registration_model->update($id, $data);
        }

        return $return;
    }

    public function getStateByCountryId()
    {
        $contry_id = $this->input->post('country_id'); 
        $state = $this->student_registration_model->getState($contry_id);

        echo json_encode(array('token'=>$this->security->get_csrf_hash(),'data'=>$state));
    }

    public function getCityByStateId()
    {
        $state_id = $this->input->post('state_id'); 
        $city = $this->student_registration_model->getCity($state_id);

        echo json_encode(array('token'=>$this->security->get_csrf_hash(),'data'=>$city));
    }

    public function getCourseWiseSubject()
    {
        $year_semester = $this->input->post('year_semester'); 
        $course = $this->input->post('course'); 
        $subjects = $this->student_registration_model->getCourseWiseSubject($year_semester,$course);
  
        echo json_encode(array('token'=>$this->security->get_csrf_hash(),'data'=>$subjects));
    }

    public function removeStudentProfileImage(){

        $reg_id = $this->input->post('reg_id'); 
        $query  = $this->db->get_where('bf_student_admission',array('registration_id'=>$reg_id))->row();

        if(!empty($query)){

            $student_profile_image = $query->student_photo;
            $path = 'assets/student_photo/'; 
            $get_file = $path.$student_profile_image; 

            if(file_exists($get_file)){ 
                unlink($get_file); 
                $data_item = array('student_photo' => '');
                $this->db->where('registration_id', $reg_id);        
                if($this->db->update('bf_student_admission', $data_item)){
                   echo json_encode(array('token'=>$this->security->get_csrf_hash(),'msg'=>'success'));
                }
            }
            else{
                   echo json_encode(array('token'=>$this->security->get_csrf_hash(),'msg'=>''));
            }

        }
    }

    public function removeStudentSignature(){

        $reg_id = $this->input->post('reg_id'); 
        $query  = $this->db->get_where('bf_student_admission',array('registration_id'=>$reg_id))->row();

        if(!empty($query)){

            $student_signature = $query->student_signature;
            $path = 'assets/student_signature/'; 
            $get_file = $path.$student_signature; 

            if(file_exists($get_file)){ 
                unlink($get_file); 
                $data_item = array('student_signature' => '');
                $this->db->where('registration_id', $reg_id);        
                if($this->db->update('bf_student_admission', $data_item)){
                   echo json_encode(array('token'=>$this->security->get_csrf_hash(),'msg'=>'success'));
                }
            }
            else{
                   echo json_encode(array('token'=>$this->security->get_csrf_hash(),'msg'=>''));
            }

        }
    }

} 