<?php defined('BASEPATH') || exit('No direct script access allowed');

class Admission_form_sale_model extends BF_Model
{
    protected $table_name	= 'admission_form_sale';
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
			'field' => 'academic_year',
			'label' => 'lang:admission_form_sale_field_academic_year',
			'rules' => 'required|max_length[100]',
		),
		array(
			'field' => 'student_name',
			'label' => 'lang:admission_form_sale_field_student_name',
			'rules' => 'required|max_length[100]',
		),
		array(
			'field' => 'mobile_no',
			'label' => 'lang:admission_form_sale_field_mobile_no',
			'rules' => 'required',
		),
		array(
			'field' => 'course',
			'label' => 'lang:admission_form_sale_field_course',
			'rules' => 'required',
		),
		array(
			'field' => 'date',
			'label' => 'lang:admission_form_sale_field_date',
			'rules' => 'required',
		),
		array(
			'field' => 'father_name',
			'label' => 'lang:admission_form_sale_field_father_name',
			'rules' => 'required|max_length[100]',
		),
		array(
			'field' => 'form_no',
			'label' => 'lang:admission_form_sale_field_form_no',
			'rules' => 'required',
		),
		array(
			'field' => 'amount',
			'label' => 'lang:admission_form_sale_field_amount',
			'rules' => 'required|max_length[255]',
		),
	);
	protected $insert_validation_rules  = array();
	protected $skip_validation 			= false;

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
}