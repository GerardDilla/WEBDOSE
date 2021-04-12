<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class UserAccessibility extends MY_Controller  {

    protected $date_time;
    protected $date_year;
    protected $array_logs;
    protected $admin_data;

    public function __construct() 
    {
        parent::__construct();
        $this->load->library('set_views');
        $this->load->library('session');
        $this->load->library("DateConverter");
        $this->load->helper(array('form', 'url', 'date'));

        $this->load->library('form_validation');
        
        
        //$this->load->model('');
        $this->load->model('Account_Model/User_Accessibility_Model');
        $this->load->model('Global_Model/Global_User_Model');
        $this->load->model('Account_Model/Logs_Model');

        //check if user is logged on
        $this->load->library('set_custom_session');
        $this->admin_data = $this->set_custom_session->admin_session();

        #user accessibility
        $this->load->library('User_accessibility');
        $this->user_accessibility->module_admin_access($this->admin_data['userid']);
        
        //set date
        $datestring = "%Y-%m-%d %h:%i";
        $yearstring = "%Y";
        $time = time();
        $this->date_time = mdate($datestring, $time);
        $this->date_year = mdate($yearstring, $time);

        //set logs
        $this->array_logs = array(
            'admin_user_id' => $this->admin_data['userid'], 
            'date' => $this->date_time,
        );


    }

    public function index($user_id ="")
    {
        if (!$user_id || !is_numeric($user_id)) 
        {
            # code... 
            $this->render($this->set_views->user_accessibility());
            return;
        }

        $user_data = $this->Global_User_Model->get_user_details($user_id);
        $this->data['user_data'] = $user_data;
        #set parameter to call class user
        $array_params = array(
            'user_data' => $user_data[0]
        );

        $this->load->library('user', $array_params);
        
        #user roles
        $user_roles = $this->User_Accessibility_Model->get_user_module_access($this->user->get_user_id());

        #system roles list
        $roles_list = $this->User_Accessibility_Model->get_add_accessibilities();

        #set parameters to call class user_roles

        $this->load->library('User_Accessibility/user_roles');

        $this->user_roles->set_array_roles($roles_list);
        $this->user_roles->set_user_roles($user_roles);

        //print_r($this->user_roles->get_user_roles());
        //print_r($this->user_roles->get_array_roles());
        
        #set roles to display in view
        $this->user_roles->set_user_display_roles();

       

        $this->render($this->set_views->user_accessibility());
        return;
        
       
    }

    public function update_user_roles()
    {
        $output = array();
        
        if (!$this->input->post('userId')) {
            # code...
            $output["checker"] = 0;
            $output["message"] = "User ID not detected";
            echo json_encode($output);
            return;
        }

        $user_data = $this->Global_User_Model->get_user_details($this->input->post('userId'));
        #check if parameter userId is valid
        if (!$user_data) {
            # code...
            $output["checker"] = 0;
            $output["message"] = 'User ID: '.$this->input->post('userId').' have no data';
            echo json_encode($output);
            return;
        }

        #set parameters to call class user_roles
        $array_params = array(
            'user_data' => $user_data[0]
        );
        $this->load->library('user', $array_params);

        $this->load->library('User_Accessibility/user_roles', $array_params);

        if ($this->input->post('addRoles')) {
            # code...
            
            #set array to insert in DB
            $this->user_roles->set_roles_to_add($this->input->post('addRoles'));

            $this->User_Accessibility_Model->insert_user_roles();
            

        }

        if ($this->input->post('removeRoles')) {
            # code...
            $this->user_roles->set_roles_to_remove($this->input->post('removeRoles'));
            foreach ($this->user_roles->get_roles_to_remove() as $key => $array_where) {
                # code...
                $this->User_Accessibility_Model->remove_user_roles($array_where);
                
            }
        }
        #insert logs here
        $this->user_roles->set_action_log();
        $action_log = $this->user_roles->get_action_log();
        $this->array_logs['user_id'] = $this->user->get_user_id();
        $this->array_logs['action'] = $action_log;

        $this->Logs_Model->insert_transaction_logs($this->array_logs);
        

        $output["checker"] = 1;
        $output["message"] = 'Updated user role';
        echo json_encode($output);
        return;
    }

    public function search_user()
    {
        $search_key = $this->input->get('key');
        $search_type = $this->input->get('searchType');
        $start = $this->input->get('offset');
        $limit = $this->input->get('limit');
        
        if ($search_type == "username") {
            # code...
            $result = $this->Global_User_Model->search_user_by_username($search_key, $limit, $start);
        }
        elseif ($search_type == "name") {
            # code...
            $result = $this->Global_User_Model->search_user_by_name($search_key, $limit, $start);
        }
        elseif ($search_type == "department") {
            # code...
            $result = $this->Global_User_Model->search_user_by_department($search_key, $limit, $start);
        }
        else {
            # code...
            $result = $this->Global_User_Model->search_user_by_position($search_key, $limit, $start);
        }
        

        echo json_encode($result);
        return;
    }

    public function search_user_page()
    {
        $search_key = $this->input->get('key');
        $search_type = $this->input->get('searchType');

        if ($search_type == "username") {
            # code...
            $result = count($this->Global_User_Model->search_user_by_username($search_key, 0, 0));
        }
        elseif ($search_type == "name") {
            # code...
            $result = count($this->Global_User_Model->search_user_by_name($search_key, 0, 0));
        }
        elseif ($search_type == "department") {
            # code...
            $result = count($this->Global_User_Model->search_user_by_department($search_key, 0, 0));
        }
        else {
            # code...
            $result = count($this->Global_User_Model->search_user_by_position($search_key, 0, 0));
        }

        echo json_encode($result);
        return;
    }

    

}