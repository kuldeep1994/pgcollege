<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Local_address controller
 */
class Local_address extends Front_Controller
{
    protected $permissionCreate = 'Local_address.Local_address.Create';
    protected $permissionDelete = 'Local_address.Local_address.Delete';
    protected $permissionEdit   = 'Local_address.Local_address.Edit';
    protected $permissionView   = 'Local_address.Local_address.View';

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('local_address/local_address_model');
        $this->lang->load('local_address');
        
        

        Assets::add_module_js('local_address', 'local_address.js');
    }

    /**
     * Display a list of Local Address data.
     *
     * @return void
     */
    public function index()
    {
        
        
        
        
        $records = $this->local_address_model->find_all();

        Template::set('records', $records);
        

        Template::render();
    }
    
}