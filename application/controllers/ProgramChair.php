<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class ProgramChair extends MY_Controller  {

    public $student_data;
	
    function __construct() 
    {
        parent::__construct();
        $this->load->library('set_views');
        $this->load->library("DateConverter");
        
        $this->load->library('session');
        $this->load->helper(array('form', 'url', 'date'));

        //set date
        $datestring = "%Y-%m-%d %h:%i";
        $date_only = "%Y-%m-%d";
        $time = time();
        $this->date_time = mdate($datestring, $time);
        $this->date = mdate($date_only, $time);

        //check if user is logged on
        $this->load->library('set_custom_session');
        $this->admin_data = $this->set_custom_session->admin_session();

        //user accessibility
        $this->load->library('User_accessibility');
        $this->user_accessibility->module_program_chair_access($this->admin_data['userid']);

        $this->load->model('Program_Chair_Model/Student_Model');
        $this->load->model('Registrar_Models/RegForm_Model');
        $this->load->model('Global_Model/Global_User_Model');
        $this->load->model('Cashier_Model/Fees_Model');

    }

    public function view_student_sched($reference_number = "", $semester = "", $school_year = "")
    {
        
        $this->data['semester'] = $this->RegForm_Model->Get_sem();
        $this->data['school_year'] = $this->RegForm_Model->Get_sy();
        

        if ( (!$reference_number) || (!$semester) || (!$school_year) ) {
            # code...
        
            $this->render($this->set_views->view_student_sched());
            return;
        }

        $student_info = $this->Student_Model->get_info($reference_number);

        if (!$student_info) {
            # code...
            $this->session->set_flashdata('message_error','Student not found.');
            redirect('ProgramChair/view_student_sched');
        }

        #get user data 
        $user_data = $this->Global_User_Model->get_user_details($this->admin_data['userid']);

        #set parameters to call user class
        $array_user_params = array(
            'user_data' => $user_data[0]
        );
        $this->load->library('user', $array_user_params);

        #set parameters to call class student and 
        $array_params = array(
            'student_info' => $student_info[0],
            'student_type' => "HED"
        );

        $this->load->library('student', $array_params);

        #check if the program chair handles the student via Department
        $student_department = $this->Student_Model->get_student_department($this->student->get_program_code());
        if ($student_department != $this->user->get_department()) {
            # code...
            $this->session->set_flashdata('message_error','The student is not under your deparment.');
            redirect('ProgramChair/view_student_sched');
        }

        $enrolled_checker = $this->Student_Model->check_enrolled($semester, $school_year, $this->student->get_reference_number());

        if (!$enrolled_checker) {
            # code...
            $this->session->set_flashdata('message_error','Student not enrolled.');
            redirect('ProgramChair/view_student_sched');
        }

        $this->data['student_schedule'] = $this->Student_Model->get_schedule($semester, $school_year, $reference_number);

        #get remaining balance of student
        $this->student_data = new Student($array_params);

        
        $this->data['remaining_balance'] = $this->Fees_Model->get_hed_remaining_balance();
       

        $this->render($this->set_views->view_student_sched());

    }

    public function schedule_preview($reference_number = "", $semester = "", $school_year = "")
    {
        

        if ( (!$reference_number) || (!$semester) || (!$school_year) ) {
            # code...
        
            redirect('ProgramChair/view_student_sched');
            
        }

        $student_info = $this->Student_Model->get_info($reference_number);

        if (!$student_info) {
            # code...
            $this->session->set_flashdata('message_error','Student not found.');
            redirect('ProgramChair/view_student_sched');
        }

        #set parameters to call class student and 
        $array_params = array(
            'student_info' => $student_info[0],
            'student_type' => "HED"
        );

        $this->load->library('student', $array_params);


        $enrolled_checker = $this->Student_Model->check_enrolled($semester, $school_year, $this->student->get_reference_number());

        if (!$enrolled_checker) {
            # code...
            $this->session->set_flashdata('message_error','Student not enrolled.');
            redirect('ProgramChair/view_student_sched');
        }

        $this->data['student_schedule'] = $this->Student_Model->get_schedule($semester, $school_year, $reference_number);

        #get remaining balance of student
        $this->student_data = new Student($array_params);

        
        $this->data['remaining_balance'] = $this->Fees_Model->get_hed_remaining_balance();
       

        $this->load->view($this->set_views->preview_student_schedule());
    }

    public function select_student()
    {
        if ( (!$this->input->post('ref_stud_number')) || (!$this->input->post('semester')) || (!$this->input->post('school_year'))) {
            # code...
            $this->session->set_flashdata('message_error','Data not found.');
            redirect('ProgramChair/view_student_sched');
        }

        $student_info = $this->Student_Model->get_info($this->input->post('ref_stud_number'));

        if (!$student_info) {
            # code...
            $this->session->set_flashdata('message_error','Student not found.');
            redirect('ProgramChair/view_student_sched');
        }


        $enrolled_checker = $this->Student_Model->check_enrolled($this->input->post('semester'), $this->input->post('school_year'), $student_info[0]['Reference_Number']);
        if (!$enrolled_checker) {
            # code...
            $this->session->set_flashdata('message_error','Student not enrolled.');
            redirect('ProgramChair/view_student_sched');
        }

        redirect('ProgramChair/view_student_sched/'.$student_info[0]['Reference_Number'].'/'.$this->input->post('semester').'/'.$this->input->post('school_year'));


    }

}