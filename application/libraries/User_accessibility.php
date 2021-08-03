<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_accessibility
{
    protected $CI; 
    private $module;

	public function __construct()
    {
        // Do something with $params
        $this->CI =& get_instance();
        $this->CI->load->library('session');
        $this->CI->load->helper('url');
        $this->CI->load->model('Account_Model/User_Accessibility_Model');

        $this->module = array(
            'admin' => 1,
            'registrar' => 5,
            'advising' => 2,
            'admission' => 3,
            'executive' => 6,
            'cashier' => 7,
            'program_chair' => 8,
            'accounting' => 9,
            'des' => 10
        );

    }

    public function module_admin_access($user_id)
    {
        $array_data = array(
            'user_id' => $user_id, 
            'module_id' => $this->module['admin']
        );

        $output = $this->CI->User_Accessibility_Model->get_module_access($array_data);

        if ($output == 0) 
        {
            redirect('Advising');
        }
    }

    public function module_registrar_access($user_id)
    {
        $array_data = array(
            'user_id' => $user_id, 
            'module_id' => $this->module['registrar']
        );

        $output = $this->CI->User_Accessibility_Model->get_module_access($array_data);

        if ($output == 0) 
        {
            redirect('Advising');
        }
    }

    public function module_program_chair_access($user_id)
    {
        $array_data = array(
            'user_id' => $user_id, 
            'module_id' => $this->module['program_chair']
        );

        $output = $this->CI->User_Accessibility_Model->get_module_access($array_data);

        if ($output == 0) 
        {
            redirect('Advising');
        }
    }
    
    public function module_advising_access($user_id)
    {
        
        $array_data = array(
            'user_id' => $user_id, 
            'module_id' => $this->module['advising']
        );

        $output = $this->CI->User_Accessibility_Model->get_module_access($array_data);
        
        if ($output == 0 ) 
        {
            # code...
            
            redirect('Registrar/Create_Sched');
        }
    }

    public function module_cashier_access($user_id)
    {
        $array_data = array(
            'user_id' => $user_id, 
            'module_id' => $this->module['cashier']
        );

        $output = $this->CI->User_Accessibility_Model->get_module_access($array_data);

        if ($output == 0) 
        {
            redirect('Registrar/Create_Sched');
        }
    }

    public function module_admission_access($user_id)
    {
        
        $array_data = array(
            'user_id' => $user_id, 
            'module_id' => $this->module['admission']
        );

        $output = $this->CI->User_Accessibility_Model->get_module_access($array_data);
        
        if ($output == 0 ) 
        {
            # code...
            
            redirect('Registrar/Create_Sched');
        }
    }

    public function module_executive_access($user_id)
    {
        
        $array_data = array(
            'user_id' => $user_id, 
            'module_id' => $this->module['executive']
        );

        $output = $this->CI->User_Accessibility_Model->get_module_access($array_data);
        
        if ($output == 0 ) 
        {
            # code...
            
            redirect('Executive/enrollment_report');
        }
    }

    public function get_module_list()
    {
        return $this->module;
    }

    public function get_user_module_access($user_id)
    {
        $output = $this->CI->User_Accessibility_Model->get_user_module_access($user_id);

        $array_output = array();

        if ($output) 
        {
            # code...
            foreach ($output as $key => $module) 
            {
                # code...
                $array_output[] = $module['parent_module_id'];
                
            }
        }

       

        return $array_output;
    }

    
}