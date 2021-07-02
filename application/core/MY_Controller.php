<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	public $template = array();
    public $data = array();
    public $middle = '';
    public $render_data = '';
    private $admin_data;

	function __construct() {

        parent::__construct();
        
        $this->data['message'] = '';

        $this->load->helper(array('form', 'language', 'url', 'date'));

        //$this->load->library('set_custom_session');
        $this->data['admin_data'] = NULL;

        $this->load->library('User_accessibility'); 
        
    }
	

    public function render($middleParam = '')
    {

        if ($middleParam == '')
        {
            $middleParam = $this->middle;
        }

      $this->data['admin_data'] = $this->set_custom_session->admin_session();
        
      //set user accessibility for nav bar
      $this->data['module_list'] = $this->user_accessibility->get_module_list();
      $this->data['user_module_access'] = $this->user_accessibility->get_user_module_access($this->data['admin_data']['userid']);

           $this->template['header'] = $this->load->view('layout/header.php', $this->data, true);
           $this->template['navbar'] = $this->load->view('layout/nav.php', $this->data, true);
           $this->template['sidebar'] = $this->load->view('layout/side.php', $this->data, true);
           $this->template['middle'] = $this->load->view($middleParam, $this->data, true);
           $this->template['footer'] = $this->load->view('layout/footer.php', $this->data, true);
           $this->load->view('layout/front', $this->template);
    }

    public function render_with_data($middleParam = '',$render_data)
    {

        if ($middleParam == '')
        {
            $middleParam = $this->middle;
        }

      $this->data['admin_data'] = $this->set_custom_session->admin_session();
        
      //set user accessibility for nav bar
      $this->data['module_list'] = $this->user_accessibility->get_module_list();
      $this->data['user_module_access'] = $this->user_accessibility->get_user_module_access($this->data['admin_data']['userid']);
      $this->data['render_data'] = $render_data;
           $this->template['header'] = $this->load->view('layout/header.php', $this->data, true);
           $this->template['navbar'] = $this->load->view('layout/nav.php', $this->data, true);
           $this->template['sidebar'] = $this->load->view('layout/side.php', $this->data, true);
           $this->template['middle'] = $this->load->view($middleParam, $this->data, true);
           $this->template['footer'] = $this->load->view('layout/footer.php', $this->data, true);
           $this->load->view('layout/front', $this->template);
    }
    public function render_with_data_nonav($middleParam = '',$render_data)
    {

        if ($middleParam == '')
        {
            $middleParam = $this->middle;
        }

      $this->data['admin_data'] = $this->set_custom_session->admin_session();
        
      //set user accessibility for nav bar
      $this->data['module_list'] = $this->user_accessibility->get_module_list();
      $this->data['user_module_access'] = $this->user_accessibility->get_user_module_access($this->data['admin_data']['userid']);
      $this->data['render_data'] = $render_data;
           $this->template['header'] = $this->load->view('layout/header.php', $this->data, true);
        //    $this->template['navbar'] = $this->load->view('layout/nav.php', $this->data, true);
        //    $this->template['sidebar'] = $this->load->view('layout/side.php', $this->data, true);
           $this->template['middle'] = $this->load->view($middleParam, $this->data, true);
           $this->template['footer'] = $this->load->view('layout/footer.php', $this->data, true);
           $this->load->view('layout/front', $this->template);
    }

    public function popupwindow($middleParam = '')
    {

        if ($middleParam == '')
        {
            $middleParam = $this->middle;
        }

      //  $this->data['admin_data'] = $this->set_custom_session->navbar_session();

           $this->template['header'] = $this->load->view('layout/header.php', $this->data, true);
           $this->template['middle'] = $this->load->view($middleParam, $this->data, true);
           $this->template['footer'] = $this->load->view('layout/footer.php', $this->data, true);
           $this->load->view('layout/front', $this->template);
    }

     //  ADMIN DOSE LOGIN
    public function login()
    {
     
           $this->template['header'] = $this->load->view('login/Login_header.php');
           $this->template['body'] = $this->load->view('login/Admin_login.php');
           $this->template['sidebar'] = $this->load->view('login/Login_footer.php');

    }

		

	
	
	
	
	
}
?>