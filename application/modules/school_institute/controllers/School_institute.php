<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * School_institute controller
 */
class School_institute extends Front_Controller
{
    protected $permissionCreate = 'School_institute.School_institute.Create';
    protected $permissionDelete = 'School_institute.School_institute.Delete';
    protected $permissionEdit   = 'School_institute.School_institute.Edit';
    protected $permissionView   = 'School_institute.School_institute.View';

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('school_institute/school_institute_model');
        $this->lang->load('school_institute');
        
        

        Assets::add_module_js('school_institute', 'school_institute.js');
    }

    /**
     * Display a list of School-Institute data.
     *
     * @return void
     */
    public function index()
    {
        
        
        
        

        // Don't display soft-deleted records
        $this->school_institute_model->where($this->school_institute_model->get_deleted_field(), 0);
        $records = $this->school_institute_model->find_all();

        Template::set('records', $records);
        

        Template::render();
    }
    
}