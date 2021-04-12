<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller  {

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

        $this->load->model('Dashboard_Model');

    }	
 
//HIGHER EDUCATION
    public function index()
	{
        $this->data['get_legends']       = $this->Dashboard_Model->Get_Legend()->result_array();
        $this->render($this->set_views->admin_dashboard());
    }
    
    public function fecth_new()
    {
        $this->data['get_legends']       = $this->Dashboard_Model->Get_Legend()->result_array();

        $array = array(
             'sem' => $this->data['get_legends'][0]['Semester'],
             'sy'  => $this->data['get_legends'][0]['School_Year']
        );


        $resultdata =  $this->Dashboard_Model->Get_New($array)->result_array();
        echo json_encode($resultdata);
    }

    public function fecth_old()
    {
        $this->data['get_legends']       = $this->Dashboard_Model->Get_Legend()->result_array();

        $array = array(
             'sem' => $this->data['get_legends'][0]['Semester'],
             'sy'  => $this->data['get_legends'][0]['School_Year']
        );


        $resultdata =  $this->Dashboard_Model->Get_OLD($array)->result_array();
        echo json_encode($resultdata);
    }

    public function fecth_withdraw()
    {
        $this->data['get_legends']       = $this->Dashboard_Model->Get_Legend()->result_array();

        $array = array(
             'sem'     => $this->data['get_legends'][0]['Semester'],
             'sy'      => $this->data['get_legends'][0]['School_Year']
        );


        $resultdata =  $this->Dashboard_Model->Get_withdraw($array)->result_array();
        echo json_encode($resultdata);
    }

    public function fecth_reserved()
    {
        $this->data['get_legends']       = $this->Dashboard_Model->Get_Legend()->result_array();

        $array = array(
             'sem'     => $this->data['get_legends'][0]['Semester'],
             'sy'      => $this->data['get_legends'][0]['School_Year']
        );


        $resultdata =  $this->Dashboard_Model->Get_reserved($array)->result_array();
        echo json_encode($resultdata);
    }

    public function fecth_advised()
    {
        $this->data['get_legends']       = $this->Dashboard_Model->Get_Legend()->result_array();

        $array = array(
             'sem'     => $this->data['get_legends'][0]['Semester'],
             'sy'      => $this->data['get_legends'][0]['School_Year']
        );


        $resultdata =  $this->Dashboard_Model->Get_advised($array)->result_array();
        echo json_encode($resultdata);
    }
 
    public function fecth_summer_New()
    {
        $this->data['get_legends']       = $this->Dashboard_Model->Get_Legend()->result_array();

        $array = array(
             'sem'     => $this->data['get_legends'][0]['Semester'],
             'sy'      => $this->data['get_legends'][0]['School_Year'],
             'summer'  => $this->data['get_legends'][0]['Grading_School_Year']
        );


        $resultdata =  $this->Dashboard_Model->Get_summer_NEW($array)->result_array();
        echo json_encode($resultdata);
    }

    public function fecth_summer()
    {
        $this->data['get_legends']       = $this->Dashboard_Model->Get_Legend()->result_array();

        $array = array(
             'sem'     => $this->data['get_legends'][0]['Semester'],
             'sy'      => $this->data['get_legends'][0]['School_Year'],
             'summer'  => $this->data['get_legends'][0]['Grading_School_Year']
        );


        $resultdata =  $this->Dashboard_Model->Get_summer($array)->result_array();
        echo json_encode($resultdata);
    }

    public function fecth_summer_withdraw()
    {
        $this->data['get_legends']       = $this->Dashboard_Model->Get_Legend()->result_array();

        $array = array(
             'sem'     => $this->data['get_legends'][0]['Semester'],
             'sy'      => $this->data['get_legends'][0]['School_Year'],
             'summer'  => $this->data['get_legends'][0]['Grading_School_Year']
        );


        $resultdata =  $this->Dashboard_Model->Get_summer_withdraw($array)->result_array();
        echo json_encode($resultdata);
    }

    public function fecth_summer_reserved()
    {
        $this->data['get_legends']       = $this->Dashboard_Model->Get_Legend()->result_array();

        $array = array(
             'sem'     => $this->data['get_legends'][0]['Semester'],
             'sy'      => $this->data['get_legends'][0]['School_Year'],
             'summer'  => $this->data['get_legends'][0]['Grading_School_Year']
        );


        $resultdata =  $this->Dashboard_Model->Get_reserved_Summer($array)->result_array();
        echo json_encode($resultdata);
    }

    public function fecth_summer_advised()
    {
        $this->data['get_legends']       = $this->Dashboard_Model->Get_Legend()->result_array();

        $array = array(
             'sem'     => $this->data['get_legends'][0]['Semester'],
             'sy'      => $this->data['get_legends'][0]['School_Year'],
             'summer'  => $this->data['get_legends'][0]['Grading_School_Year']
        );


        $resultdata =  $this->Dashboard_Model->Get_advised_summer($array)->result_array();
        echo json_encode($resultdata);
    }
 //HIGHER EDUCATION


 //BASIC EDUCATION
     
    public function fecth_newbed_student()
    {
        $this->data['get_legends']    = $this->Dashboard_Model->Get_Legend()->result_array();

        $array = array(
            'sy'  => $this->data['get_legends'][0]['School_Year']
        );

        $resultdata =  $this->Dashboard_Model->Get_NewBED_Enrolled($array)->result_array();
        echo json_encode($resultdata);
    }


    public function fecth_bedold_student()
    {
        $this->data['get_legends']    = $this->Dashboard_Model->Get_Legend()->result_array();

        $array = array(
            'sy'  => $this->data['get_legends'][0]['School_Year']
        );

        $resultdata =  $this->Dashboard_Model->Get_bedOLD_Enrolled($array)->result_array();
        echo json_encode($resultdata);
    }

    public function fecth_reservedbed_student()
    {
        $this->data['get_legends']    = $this->Dashboard_Model->Get_Legend()->result_array();

        $array = array(
            'sy'  => $this->data['get_legends'][0]['School_Year']
        );

     //   $resultdata =  $this->Dashboard_Model->Get_bedOLD_Enrolled($array)->result_array();
      //  echo json_encode($resultdata);
    }


     //SENIOR HIGH SCHOOL

     public function fecth_newshs_student()
     {
         $this->data['get_legends']    = $this->Dashboard_Model->Get_Legend()->result_array();
 
         $array = array(
             'sy'  => $this->data['get_legends'][0]['School_Year']
         );
 
         $resultdata =  $this->Dashboard_Model->Get_NewSHS_Enrolled($array)->result_array();
         echo json_encode($resultdata);
     }

     public function fecth_oldshs_student()
     {
         $this->data['get_legends']    = $this->Dashboard_Model->Get_Legend()->result_array();
 
         $array = array(
             'sy'  => $this->data['get_legends'][0]['School_Year']
         );
 
         $resultdata =  $this->Dashboard_Model->Get_SHSOLD_Enrolled($array)->result_array();
         echo json_encode($resultdata);
     }
 
    //GET INQUIRY 

    public function fecth_shs_inquiry()
    {
        $this->data['get_legends']       = $this->Dashboard_Model->Get_Legend()->result_array();

        $array = array(
             'sem'     => $this->data['get_legends'][0]['Semester'],
             'sy'      => $this->data['get_legends'][0]['School_Year']
        );


        $resultdata =  $this->Dashboard_Model->SHS_INQUIRY($array)->result_array();
        echo json_encode($resultdata);
    }

    public function fecth_bed_inquiry()
    {
        $this->data['get_legends']       = $this->Dashboard_Model->Get_Legend()->result_array();

        $array = array(
             'sem'     => $this->data['get_legends'][0]['Semester'],
             'sy'      => $this->data['get_legends'][0]['School_Year']
        );


        $resultdata =  $this->Dashboard_Model->BED_INQUIRY($array)->result_array();
        echo json_encode($resultdata);
    }
   
    public function fecth_highered_inquiry()
    {
        $this->data['get_legends']       = $this->Dashboard_Model->Get_Legend()->result_array();

        $array = array(
             'sem'     => $this->data['get_legends'][0]['Semester'],
             'sy'      => $this->data['get_legends'][0]['School_Year']
        );


        $resultdata =  $this->Dashboard_Model->HIGHERED_INQUIRY($array)->result_array();
        echo json_encode($resultdata);
    }

    // BED RESERVE

    public function fecth_bed_reserved()
    {
        $this->data['get_legends']       = $this->Dashboard_Model->Get_Legend()->result_array();

        $array = array(
             'sem'     => $this->data['get_legends'][0]['Semester'],
             'sy'      => $this->data['get_legends'][0]['School_Year']
        );


        $resultdata =  $this->Dashboard_Model->BED_RESERVE($array)->result_array();
        echo json_encode($resultdata);
    }

    //SHS RESERVE
    public function fecth_shs_reserved()
    {
        $this->data['get_legends']       = $this->Dashboard_Model->Get_Legend()->result_array();

        $array = array(
             'sem'     => $this->data['get_legends'][0]['Semester'],
             'sy'      => $this->data['get_legends'][0]['School_Year']
        );


        $resultdata =  $this->Dashboard_Model->SHS_RESERVE($array)->result_array();
        echo json_encode($resultdata);
    }
   
   
}
?>
