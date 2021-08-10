<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Controller  {

    private $user_data;
    
	function __construct() {
        parent::__construct();
        $this->load->library('set_views');
        $this->load->library('email');
        $this->load->library('pagination');
        $this->load->library('session');
        $this->load->library('set_custom_session');
      
      //  $this->load->library('Ajax_pagination');
        $this->perPage = 2;

        $this->load->model('Account_Model/User_verification');
        $this->load->model('Registrar_Models/Registrar_Model');
        
        
    }	
    
	public function index()
	{   
        // echo base_url(uri_string());
        $current_uri = base_url(uri_string());
        $admin_uri = base_url('Admin');
        if($current_uri!=$admin_uri){
            redirect(base_url('index.php/Admin'));
        }
        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        if($this->form_validation->run() == FALSE) 
		{
            $this->login();
        }
        else{
            $credentials = array(
                'username' => $this->input->post('username'),
                'password' => $this->input->post('password')
            );
            $check = $this->User_verification->login($credentials);
            if($check->num_rows() != 0){
                foreach($check->result_array() as $row){
                    $array = array(
                        'userid' => $row['User_ID'],
                        'fullname' => $row['User_FullName'],
                        'position' => $row['User_Position'],
                        'username' => $row['UserName']
                    );
                }
                $this->session->set_userdata('logged_in',$array);
                $this->user_data = $this->set_custom_session->admin_session();
                $check = $this->User_verification->check_module_assignment($array['userid']);
                $only_des = 0;
                foreach($check->result_array() as $row){
                    if($row['parent_module_id'] != 10){
                        $only_des ++;
                    }
                }
                if($only_des == 0){
                    redirect('Des/digital_citizenship','refresh');
                }else{
                    redirect('Registrar/Create_Sched','refresh');
                }
            }else{
                $this->session->set_flashdata('login_message','Invalid Username or Password');
                
                $this->login();
            }
        }
    }
    public function logout(){
        $this->session->unset_userdata('logged_in');
        redirect('Admin');
    }

    public function Dashboard()
	{
        $this->render($this->set_views->admin_dashboard());
    }
    
    public function Manage_Account()
	{
        $this->data['AccountList'] = $this->User_verification->login($credentials);
        $this->render($this->set_views->admind_create_Account());
    }
    /*
    public function temp_assign_module(){
        $this->load->model('Account_Model/User_Accessibility_Model');
        $this->data['accessibilities'] = $this->User_Accessibility_Model->get_add_accessibilities();
        $this->render('body/registrar/Temp_assign_accessibilities');
    }
    public function temp_assign_process(){
        $insert['parent_module_id'] = $this->input->post('access_type_new');
        $old_access = $this->input->post('access_type_old');
        $this->load->model('Account_Model/User_Accessibility_Model');
        $users = $this->User_Accessibility_Model->get_all_users($old_access);
        foreach($users as $row){
            $insert['User_id'] = $row['User_ID'];
            $insert_id = $this->User_Accessibility_Model->insert_new_module($insert);
            echo $row['User_FullName'].':'.$row['tabAdvising'].':'.$insert_id.'<br>';
        }
        echo '<br><strong>Insert Done!</strong>';
    }
    */
    /*Admission */








 




}
?>
