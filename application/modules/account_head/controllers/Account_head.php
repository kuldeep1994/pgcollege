<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Account_head controller
 */
class Account_head extends Front_Controller
{
    protected $permissionCreate = 'Account_head.Account_head.Create';
    protected $permissionDelete = 'Account_head.Account_head.Delete';
    protected $permissionEdit   = 'Account_head.Account_head.Edit';
    protected $permissionView   = 'Account_head.Account_head.View';

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('account_head/account_head_model');
        $this->lang->load('account_head');
        
        

        Assets::add_module_js('account_head', 'account_head.js');
    }

    /**
     * Display a list of Account Head data.
     *
     * @return void
     */
    public function index()
    {
        
        
        
        

        // Don't display soft-deleted records
        $this->account_head_model->where($this->account_head_model->get_deleted_field(), 0);
        $records = $this->account_head_model->find_all();

        Template::set('records', $records);
        

        Template::render();
    }
    
}