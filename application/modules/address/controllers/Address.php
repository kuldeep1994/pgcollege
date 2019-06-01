<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Address controller
 */
class Address extends Front_Controller
{
    protected $permissionCreate = 'Address.Address.Create';
    protected $permissionDelete = 'Address.Address.Delete';
    protected $permissionEdit   = 'Address.Address.Edit';
    protected $permissionView   = 'Address.Address.View';

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('address/address_model');
        $this->lang->load('address');
        
        

        Assets::add_module_js('address', 'address.js');
    }

    /**
     * Display a list of Address data.
     *
     * @return void
     */
    public function index()
    {
        
        
        
        
        $records = $this->address_model->find_all();

        Template::set('records', $records);
        

        Template::render();
    }
    
}