<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Executive extends MY_Controller  {

    private $user_data;
    
	function __construct() {
        parent::__construct();
        $this->load->library('set_views');
        $this->load->library('email');
        $this->load->library('pagination');
        $this->load->library('session');
        $this->load->library('set_custom_session');
        $this->load->model('Dashboard_Model');
      //  $this->load->library('Ajax_pagination');
        $this->perPage = 2;

        $this->load->model('Account_Model/User_verification');
        $this->load->model('Registrar_Models/Registrar_Model');
        $this->load->model('Executive_Model/Basiced');
        $this->load->model('Executive_Model/Shs');
        $this->load->model('Executive_Model/HigherED');
        $this->load->model('Dashboard_Model');
        $this->load->model('Admission_Model/Helpdesk_Model');

        //check if user is logged on
        $this->load->library('set_custom_session');
        $this->admin_data = $this->set_custom_session->admin_session();
   
        //user accessibility
        $this->load->library('User_accessibility');
        $this->user_accessibility->module_executive_access($this->admin_data['userid']);

    }	


    public function enrollment_report()
	  {
        $this->data['get_legends']       = $this->Dashboard_Model->Get_Legend()->result_array();
        $this->render($this->set_views->executive_report());
    }


    //BAR CHART JSON CODE FOR BASIC ED
    public function get_basiced(){

        $this->data['get_sy']  = $this->Basiced->Get_SchoolYear();
        $BasicedLevel = $this->Basiced->Select_Level();

        $array = array(
          'sy' =>$this->data['get_sy'][0]['School_Year'],
       );

        //INITIALIZE ARRAY AND COUNTER FOR FOREACH
        $LIST = array();
        $count = 0;
       
        foreach($BasicedLevel as $row){
             $array['GradeLevel']          = $row['Grade_LevelCode'];
             $list[$count]['NewStudent']   = $this->Basiced->NewStudents($array);
             $list[$count]['Inquiry']      = $this->Basiced->Inquiry($array);
             $list[$count]['Reserve']      = $this->Basiced->RESERVE($array);
             $list[$count]['Enrolled']     = $this->Basiced->Enrolled($array);
             $list[$count]['Grade_Level']  = $row['Grade_Level'];
             $count++;
             
        }
    
        $count = 0;
        $this->data['list'] = $list;
        echo json_encode($list);

    }


    //BAR CHART JSON CODE FOR SENIOR HIGH SCHOOL
    public function get_senior(){

      $this->data['get_sy']  = $this->Shs->Get_SchoolYear();
      $ShsStrand = $this->Shs->Select_Strand();

      $array = array(
        'sy' =>$this->data['get_sy'][0]['School_Year'],
      );

      //INITIALIZE ARRAY AND COUNTER FOR FOREACH
      $LIST = array();
      $count = 0;
      
      foreach($ShsStrand as $row){
            $array['Strand_Code']         = $row['Strand_Code'];
            $list[$count]['NewStudent']   = $this->Shs->NewStudents($array);
            $list[$count]['Inquiry']      = $this->Shs->Inquiry($array);
            $list[$count]['Reserve']      = $this->Shs->RESERVE($array);
            $list[$count]['Enrolled']     = $this->Shs->Enrolled($array);
            $list[$count]['Strand_Code']  = $row['Strand_Code'];
            $count++;
            
      }
  
      $count = 0;
      $this->data['list'] = $list;
      echo json_encode($list);

    }
     
    //BAR CHART JSON CODE FOR HIGHEREDUCATION
    public function get_highered(){

      $this->data['get_legend']  = $this->HigherED->Get_legend();
      $programlist = $this->HigherED->Get_Course();



      $array = array(
        'sy' =>$this->data['get_legend'][0]['School_Year'],
        'sem' =>$this->data['get_legend'][0]['Semester'],
      );

      //INITIALIZE ARRAY AND COUNTER FOR FOREACH
      $LIST = array();
      $count = 0;
      
      foreach($programlist as $row){
            $array['Program_Code']         = $row['Program_Code'];
            $list[$count]['NewStudent']   = $this->HigherED->Get_New($array);
            $list[$count]['Inquiry']      = $this->HigherED->Inquiry($array);
            $list[$count]['Reserve']      = $this->HigherED->Get_reserved($array);
            $list[$count]['Enrolled']     = $this->HigherED->Get_Enrolled($array);
            $list[$count]['Program_Code']  = $row['Program_Code'];
            $count++;
            
      }
  
      $count = 0;
      $this->data['list'] = $list;
      echo json_encode($list);

    }

 
    ///GET OTHER PROGRAMS
    public function get_other_programs(){

      $this->data['get_legend']  = $this->Dashboard_Model->Get_legends();
      $program = $this->Dashboard_Model->get_other_programs();

      $array = array(
        'sy' =>$this->data['get_legend'][0]['School_Year'],
        'sem' =>$this->data['get_legend'][0]['Semester'],
      );

      $LIST = array();
      $count = 0;
      
      foreach($program as $row){
            $array['Program_Code']         = $row['Program_Code'];
            $list[$count]['Enrolled']      = $this->Dashboard_Model->Get_Enrolled($array);
            $list[$count]['Program_Code']  = $row['Program_Code'];
            $count++;
            
      }
  
      $count = 0;
      $this->data['list'] = $list;
      echo json_encode($list);
    }


    public function HelpdeskReport()
    {

      $this->render($this->set_views->helpdesk_report()); 

    }
    public function getHelpdeskInquiries(){

      $input = array(
        'searchkey' => $this->input->get_post('searchkey'),
        'datefrom' => $this->input->get_post('datefrom'),
        'status' => $this->input->get_post('status'),
        'education' => $this->input->get_post('education')
      );
      $result = $this->Helpdesk_Model->getHelpdeskInquiries($input);
      echo json_encode(array('data' => $result));

    }
  

   //// ADMIN CREATE ACCOUNT  ///







 




}
?>
