<?php defined('BASEPATH') || exit('No direct script access allowed');

class Account_head_model extends BF_Model
{
    protected $table_name	= 'account_head';
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
			'field' => 'head_name',
			'label' => 'lang:account_head_field_head_name',
			'rules' => 'required|max_length[255]',
		),
		array(
			'field' => 'account_group',
			'label' => 'lang:account_head_field_account_group',
			'rules' => 'required|max_length[30]',
		),
		array(
			'field' => 'description',
			'label' => 'lang:account_head_field_description',
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
	
	public function getAccountGroup()
	{
		return $this->db->get('account_group')->result();
	}

	public function getAccountGroupName($id='')
	{
		return $this->db->get_where('account_group',array('id'=>$id))->row()->group_name;
	}
}