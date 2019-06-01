<?php defined('BASEPATH') || exit('No direct script access allowed');

class Student_registration_model extends BF_Model{
    protected $table_name	= 'registration';
	protected $key			= 'id';
	protected $date_format	= 'datetime';

	protected $log_user 	= true;
	protected $set_created	= true;
	protected $set_modified = true;
	protected $soft_deletes	= true;

	protected $created_field     = 'created_on';
    protected $created_by_field  = 'created_by';
	protected $modified_field    = 'modified_on';
    protected $modified_by_field = 'modified_by';
    protected $deleted_field     = 'deleted';
    protected $deleted_by_field  = 'deleted_by';

	// Customize the operations of the model without recreating the insert,
    // update, etc. methods by adding the method names to act as callbacks here.
	protected $before_insert 	= array();
	protected $after_insert 	= array();
	protected $before_update 	= array();
	protected $after_update 	= array();
	protected $before_find 	    = array();
	protected $after_find 		= array();
	protected $before_delete 	= array();
	protected $after_delete 	= array();

	// For performance reasons, you may require your model to NOT return the id
	// of the last inserted row as it is a bit of a slow method. This is
    // primarily helpful when running big loops over data.
	protected $return_insert_id = true;

	// The default type for returned row data.
	protected $return_type = 'object';

	// Items that are always removed from data prior to inserts or updates.
	protected $protected_attributes = array();

	// You may need to move certain rules (like required) into the
	// $insert_validation_rules array and out of the standard validation array.
	// That way it is only required during inserts, not updates which may only
	// be updating a portion of the data.
	protected $validation_rules 		= array(
		array(
			'field' => 'student_name',
			'label' => 'lang:student_registration_field_student_name',
			'rules' => 'required|max_length[30]',
		),
		array(
			'field' => 'gender',
			'label' => 'lang:student_registration_field_gender',
			'rules' => 'required|max_length[30]',
		),
		array(
			'field' => 'dob',
			'label' => 'lang:student_registration_field_dob',
			'rules' => 'required|max_length[50]',
		),
		array(
			'field' => 'nationality',
			'label' => 'lang:student_registration_field_nationality',
			'rules' => 'required|max_length[30]',
		),
		array(
			'field' => 'annual_income',
			'label' => 'lang:student_registration_field_annual_income',
			'rules' => 'max_length[255]',
		),
		array(
			'field' => 'relegion',
			'label' => 'lang:student_registration_field_relegion',
			'rules' => 'required|max_length[30]',
		),
		array(
			'field' => 'caste',
			'label' => 'lang:student_registration_field_caste',
			'rules' => 'required|max_length[30]',
		),
		array(
			'field' => 'cast_category',
			'label' => 'lang:student_registration_field_cast_category',
			'rules' => 'required|max_length[30]',
		),
		array(
			'field' => 'mobile_number',
			'label' => 'lang:student_registration_field_mobile_number',
			'rules' => '',
		),
	);
	protected $insert_validation_rules  = array();
	protected $skip_validation 			= false;

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct(){
        parent::__construct();
	}
	
	/* Get Country */
	public function getCountry(){
		return $this->db->get('countries_1')->result();
	}
	
	/* Get State */
	public function getState($contry_id=''){
		return $this->db->get_where('states_1',array('country_id'=>$contry_id))->result();
	}
	
	/* Get City */
	public function getCity($state_id=''){
		return $this->db->get_where('cities_1',array('state_id'=>$state_id))->result();
	}

	/* Get Country Name*/
	public function getCountryName($id=''){
		return $this->db->get_where('countries_1',array('id'=>$id))->row()->name;
	}
	
	/* Get State Name*/
	public function getStateName($id=''){
		return $this->db->get_where('states_1',array('id'=>$id))->row()->name;
	}
	
	/* Get City Name*/
	public function getCityName($id=''){
		return $this->db->get_where('cities_1',array('id'=>$id))->row()->name;
	}

	/* Get Course wise Subject*/
	public function getCourseWiseSubject($year_semester='',$course=''){
		$this->db->select('cws.*,sb.title');
		$this->db->from('course_wise_subjects cws');
		$this->db->join('subject sb','sb.id=cws.subject_id');
		$this->db->where('cws.year_or_semester_id',$year_semester);
		$this->db->where('cws.course_id',$course);
		$query = $this->db->get();
		if(!empty($query) and $query->num_rows()>0){
			return $query->result();
		}
	}
}