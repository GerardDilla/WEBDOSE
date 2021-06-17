<?php

use SebastianBergmann\CodeCoverage\Report\Html\Renderer;

defined('BASEPATH') OR exit('No direct script access allowed');

class StudentInquiry extends MY_Controller  {
    public function __construct(){
        parent::__construct();
        header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST');
        header('Access-Control-Request-Headers: Content-Type');
        
        // parent::__construct();
        $this->load->library('set_views');
        // $this->load->library('email');
        // $this->load->library('pagination');
        // $this->load->library('session');
        $this->load->library('set_custom_session');
        $this->load->model('Student_Inquiry_Model/Student_Inquiry_Model');
      //  $this->load->library('Ajax_pagination');
        // $this->perPage = 2;

        // $this->load->model('Account_Model/User_verification');
        // $this->load->model('Registrar_Models/Registrar_Model');
    }
    public function index(){
        $getStudentInquiry = $this->Student_Inquiry_Model->getStudentInquiry();
		$count = 0;
		foreach ($getStudentInquiry as $inquiry) {
			$getStudentInquiry[$count]['total_message'] = $this->Student_Inquiry_Model->countTotalUnseenMessage($inquiry['ref_no']);
			++$count;
		}
		$this->data['getStudentInquiry'] = $getStudentInquiry;
        $this->render($this->set_views->college_inquiry());
    }
}