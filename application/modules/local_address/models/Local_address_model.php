<?php defined('BASEPATH') || exit('No direct script access allowed');

class Local_address_model extends BF_Model
{
    protected $table_name	= 'address';
	protected $key			= 'id';
	protected $date_format	= 'datetime';

	protected $log_user 	= false;
	protected $set_created	= false;
	protected $set_modified = false;
	protected $soft_deletes	= false;


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
			'field' => 'street_address',
			'label' => 'lang:local_address_field_street_address',
			'rules' => 'required|max_length[255]',
		),
		array(
			'field' => 'city',
			'label' => 'lang:local_address_field_city',
			'rules' => 'required|max_length[50]',
		),
		array(
			'field' => 'state',
			'label' => 'lang:local_address_field_state',
			'rules' => 'required|max_length[50]',
		),
		array(
			'field' => 'zip_code',
			'label' => 'lang:local_address_field_zip_code',
			'rules' => 'required|max_length[30]',
		),
		array(
			'field' => 'country',
			'label' => 'lang:local_address_field_country',
			'rules' => 'required|max_length[30]',
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
	
	/* Get Country */
	public function getCountry()
	{
		return $this->db->get('countries_1')->result();
	}
	
	/* Get State */
	public function getState($contry_id='')
	{
		return $this->db->get_where('states_1',array('country_id'=>$contry_id))->result();
	}
	
	/* Get City */
	public function getCity($state_id='')
	{
		return $this->db->get_where('cities_1',array('state_id'=>$state_id))->result();
	}

	/* Get Country Name*/
	public function getCountryName($id='')
	{
		return $this->db->get_where('countries_1',array('id'=>$id))->row()->name;
	}
	
	/* Get State Name*/
	public function getStateName($id='')
	{
		return $this->db->get_where('states_1',array('id'=>$id))->row()->name;
	}
	
	/* Get City Name*/
	public function getCityName($id='')
	{
		return $this->db->get_where('cities_1',array('id'=>$id))->row()->name;
	}
}