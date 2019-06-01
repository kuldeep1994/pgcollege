<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Account_group controller
 */
class Account_group extends Front_Controller
{
    protected $permissionCreate = 'Account_group.Account_group.Create';
    protected $permissionDelete = 'Account_group.Account_group.Delete';
    protected $permissionEdit   = 'Account_group.Account_group.Edit';
    protected $permissionView   = 'Account_group.Account_group.View';

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('account_group/account_group_model');
        $this->lang->load('account_group');
        
        

        Assets::add_module_js('account_group', 'account_group.js');
    }

    /**
     * Display a list of Account Group data.
     *
     * @return void
     */
    public function index()
    {
        
        
        
        

        // Don't display soft-deleted records
        $this->account_group_model->where($this->account_group_model->get_deleted_field(), 0);
        $records = $this->account_group_model->find_all();

        Template::set('records', $records);
        

        Template::render();
    }
    
}