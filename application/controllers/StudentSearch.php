<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class StudentSearch extends MY_Controller  {

	
  function __construct() 
  {
        parent::__construct();
        $this->load->model('Advising_Model/Student_Model');

         //check if user is logged on
        $this->load->library('set_custom_session');
        $this->admin_data = $this->set_custom_session->admin_session();

        
  }	
	public function index()
	{
      Echo 'Unauthorized Access';

  }
  public function search_student(){

    $array = array(
      'key' => $this->input->get('key'),
      'start' => $this->input->get('offset'),
      'limit' => $this->input->get('limit'),
      'type' => $this->input->get('educ_type')
    );
    $result = $this->Student_Model->search_student_info($array);
    echo json_encode($result);
    
  }
  public function search_student_page(){

    $array = array(
      'key' => $this->input->get('key'),
      'type' => $this->input->get('educ_type')
    );
    $result = $this->Student_Model->search_student_info_pages($array);
    echo json_encode($result);
    
  }
  public function searchSample(){
    $result = $this->Student_Model->testQuery(array('key'=>'magti'));
    echo '<pre>'.print_r($result,1).'</pre>';
  }
  public function decryptPassword(){
    $ref_no = 132;
    $decryptPass = $this->Student_Model->decryptPass($ref_no);
    echo '<pre>'.print_r($decryptPass,1).'</pre>';
  }
}//end class



