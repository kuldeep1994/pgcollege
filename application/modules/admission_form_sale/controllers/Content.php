<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Content controller
 */
class Content extends Admin_Controller
{
    protected $permissionCreate = 'Admission_form_sale.Content.Create';
    protected $permissionDelete = 'Admission_form_sale.Content.Delete';
    protected $permissionEdit   = 'Admission_form_sale.Content.Edit';
    protected $permissionView   = 'Admission_form_sale.Content.View';

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->auth->restrict($this->permissionView);
        $this->load->model('admission_form_sale/admission_form_sale_model');
        $this->lang->load('admission_form_sale');
        
            Assets::add_css('flick/jquery-ui-1.8.13.custom.css');
            Assets::add_js('jquery-ui-1.8.13.min.js');
            $this->form_validation->set_error_delimiters("<span class='error'>", "</span>");
        
        Template::set_block('sub_nav', 'content/_sub_nav');

        Assets::add_module_js('admission_form_sale', 'admission_form_sale.js');
    }

    /**
     * Display a list of Admission Form Sale data.
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
                    $deleted = $this->admission_form_sale_model->delete($pid);
                    if ($deleted == false) {
                        $result = false;
                    }
                }
                if ($result) {
                    Template::set_message(count($checked) . ' ' . lang('admission_form_sale_delete_success'), 'success');
                } else {
                    Template::set_message(lang('admission_form_sale_delete_failure') . $this->admission_form_sale_model->error, 'error');
                }
            }
        }
        
        
        
        $records = $this->admission_form_sale_model->find_all_by('deleted','0');

        Template::set('records', $records);
        
        Template::set('toolbar_title', lang('admission_form_sale_manage'));

        Template::render();
    }
    
    /**
     * Create a Admission Form Sale object.
     *
     * @return void
     */
    public function create()
    {
        $this->auth->restrict($this->permissionCreate);
        
        $admission_form_sale = $this->db->get_where('bf_account_head',array('head_name'=>'Admission Form Sale','deleted'=>'0'))->row();
        
        if (isset($_POST['save'])) 
        {
                if(!empty($admission_form_sale))
                {
                    $data['account_id'] = $admission_form_sale->id;
                    $data['cr'] = 'cr';
                    $data['Narration'] = 'Asset From Admission Form Sale';

                    if ($insert_id = $this->save_admission_form_sale()) 
                    {
                        $this->db->insert('bf_transactions',$data);

                        log_activity($this->auth->user_id(), lang('admission_form_sale_act_create_record') . ': ' . $insert_id . ' : ' . $this->input->ip_address(), 'admission_form_sale');
                        Template::set_message(lang('admission_form_sale_create_success'), 'success');

                        redirect(SITE_AREA . '/content/admission_form_sale/reciept/'.$insert_id);
                    }

                    // Not validation error
                    if ( ! empty($this->admission_form_sale_model->error)) 
                    {
                        Template::set_message(lang('admission_form_sale_create_failure') . $this->admission_form_sale_model->error, 'error');
                    }
                }
                else
                {
                    Template::set_message(lang('admission_form_sale_create_failure_msg') . $this->admission_form_sale_model->error, 'error');
                    redirect(SITE_AREA . '/content/admission_form_sale');
                }
        }
        

        $course = $this->db->get_where('course',array('deleted'=>'0'))->result();

        Template::set('toolbar_title', lang('admission_form_sale_action_create'));

        Template::set('course', $course);

        Template::render();
    }
    /**
     * Allows editing of Admission Form Sale data.
     *
     * @return void
     */
    public function edit()
    {
        $id = $this->uri->segment(5);
        if (empty($id)) {
            Template::set_message(lang('admission_form_sale_invalid_id'), 'error');

            redirect(SITE_AREA . '/content/admission_form_sale');
        }
        
        if (isset($_POST['save'])) {
            $this->auth->restrict($this->permissionEdit);

            if ($this->save_admission_form_sale('update', $id)) {
                log_activity($this->auth->user_id(), lang('admission_form_sale_act_edit_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'admission_form_sale');
                Template::set_message(lang('admission_form_sale_edit_success'), 'success');
                redirect(SITE_AREA . '/content/admission_form_sale');
            }

            // Not validation error
            if ( ! empty($this->admission_form_sale_model->error)) {
                Template::set_message(lang('admission_form_sale_edit_failure') . $this->admission_form_sale_model->error, 'error');
            }
        }
        
        elseif (isset($_POST['delete'])) {
            $this->auth->restrict($this->permissionDelete);

            if ($this->admission_form_sale_model->delete($id)) {
                log_activity($this->auth->user_id(), lang('admission_form_sale_act_delete_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'admission_form_sale');
                Template::set_message(lang('admission_form_sale_delete_success'), 'success');

                redirect(SITE_AREA . '/content/admission_form_sale');
            }

            Template::set_message(lang('admission_form_sale_delete_failure') . $this->admission_form_sale_model->error, 'error');
        }
        
        Template::set('admission_form_sale', $this->admission_form_sale_model->find($id));
        
        $course = $this->db->get('course')->result();
        Template::set('course', $course);

        Template::set('toolbar_title', lang('admission_form_sale_edit_heading'));
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
    private function save_admission_form_sale($type = 'insert', $id = 0)
    {
        if ($type == 'update') {
            $_POST['id'] = $id;
        }

        // Validate the data
        $this->form_validation->set_rules($this->admission_form_sale_model->get_validation_rules());
        if ($this->form_validation->run() === false) {
            return false;
        }

        // Make sure we only pass in the fields we want
        
        $data = $this->admission_form_sale_model->prep_data($this->input->post());

        // Additional handling for default values should be added below,
        // or in the model's prep_data() method
        
		$data['date']	= $this->input->post('date') ? $this->input->post('date') : '0000-00-00';

        $return = false;
        if ($type == 'insert') {
            $id = $this->admission_form_sale_model->insert($data);

            if (is_numeric($id)) {
                $return = $id;
            }
        } elseif ($type == 'update') {
            $return = $this->admission_form_sale_model->update($id, $data);
        }

        return $return;
    }

    public function reciept($id='')
    { 
        $data = $this->db->get_where('bf_admission_form_sale',array('id'=>$id))->row();
        $course = $this->db->get_where('bf_course',array('id'=>$data->course))->row()->course_name;
        Template::set('reciept_data', $data);
        Template::set('course', $course);
        Template::set_view('content/reciept');
        Template::render();
    }
}