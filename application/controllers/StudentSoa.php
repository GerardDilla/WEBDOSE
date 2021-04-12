<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class StudentSoa extends CI_Controller {

    public function __construct() 
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST');
        header('Access-Control-Request-Headers: Content-Type');

        parent::__construct();
        $this->load->library('set_views');
        $this->load->library('session');
        $this->load->library("DateConverter");
        $this->load->library("email");

        $this->load->library('encryption');
        $this->encryption->initialize(array('key' => 'sdcasoa2021'));

        $this->load->library('form_validation');
        $this->load->helper(array('form', 'language', 'url', 'date'));

        $this->load->model('Global_Model/Global_Program_Model');
        //$this->load->model('Account_Model/Logs_Model');
        $this->load->model('Accounting_Model/Student_Model');
        $this->load->model('Accounting_Model/Fees_Model');
        $this->load->model('Global_Model/Global_Fees_Model');
        $this->load->model('Global_Model/Global_Student_Model');
        $this->config->set_item('permitted_uri_chars', '+=\a-z 0-9~%.:_\-');
    }

    public function soa_download($student_no ="", $due_id ="")
    {
        
        if (!$student_no || !$due_id) {
            # code...
            echo "no data";
            return;
        }
        
        $array_advising_term = $this->Global_Program_Model->get_advising_term();
        $semester = $array_advising_term['Semester'];
        $school_year = $array_advising_term['School_Year'];
        $student_info = $this->Global_Student_Model->get_student_info_by_student_no($student_no);

        if ($student_info == NULL) {
            # code...
            echo "wrong info";
            return;
        }

        #check due date
        $due_data_array = $this->Student_Model->get_soa_due_date($due_id);
        if (!$due_data_array) {
            # code...
            echo 'no data on due date';
            return;
        }


        if ($due_data_array['program_code'] != $student_info[0]['Course']) {
            # code...
            echo 'wrong course';
            return;
        }
        
        $array_params = array(
            'student_info' => $student_info[0],
            'student_type' => "HED",
            'due_date' => $due_data_array['due_date']
        );
        $this->load->library('student', $array_params);
        $reference_no = $this->student->get_reference_no();
        $student_no = $this->student->get_student_no();
        $array_info = array(
            'reference_no' => $reference_no,
            'semester' => $semester,
            'schoolyear' => $school_year
        );

        #get enrolled fees
        $array_enrolled_fees = $this->Global_Fees_Model->get_enrolled_fees($array_info);
        //$this->soa->set_enrolled_fees_data($array_enrolled_fees[0]);
        $array_params['enrolled_fees'] = $array_enrolled_fees[0];
        
        #get Scholarship discount
        $scholarship_discount = $this->Fees_Model->get_scholarship_discount($array_enrolled_fees[0]['id']);
        $array_params['scholarship_discount'] = $scholarship_discount;

        #get total paid
        $total_paid = $this->Fees_Model->get_total_payment($reference_no, $semester, $school_year);
        $array_params['total_paid'] = $total_paid;

        #get advising term
        $array_params['array_advising_term'] = $array_advising_term;

        #get OR list
        $array_or_list = $this->Fees_Model->get_hed_or($reference_no, $semester, $school_year);
        $array_params['array_official_receipt'] = $array_or_list;

        #get remaining balance
        $array_remaining_balance = $this->Global_Fees_Model->get_hed_remaining_balance($reference_no, $student_no);
        $array_params['array_remaining_balance'] = $array_remaining_balance;

        #call soa class
        $this->load->library('Accounting/soa', $array_params);

        $this->load->view($this->set_views->student_soa());
        
        $this->soa->export();
        //$this->soa->test();

        
    }

    public function test()
    {
        $this->load->view($this->set_views->student_soa());
    }

    public function sample_outputs()
    {
       echo "sample";

       
    }
}