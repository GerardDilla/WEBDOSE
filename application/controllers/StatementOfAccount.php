<?php

use SebastianBergmann\CodeCoverage\Report\Html\Renderer;

defined('BASEPATH') OR exit('No direct script access allowed');

class StatementOfAccount extends MY_Controller  {

    protected $admin_data;
    protected $school_year;
    protected $semester;
    protected $term;
    protected $program_code;
    protected $school_email;
    protected $due_date;
    protected $date_time;

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

        $this->load->library('form_validation');
        
        //$this->load->model('');
        $this->load->model('Global_Model/Global_Program_Model');
        //$this->load->model('Account_Model/Logs_Model');
        $this->load->model('Accounting_Model/Student_Model');
        $this->load->model('Accounting_Model/Fees_Model');
        $this->load->model('Global_Model/Global_Fees_Model');
        $this->load->model('Global_Model/Global_Student_Model');

        //check if user is logged on
        $this->load->library('set_custom_session');
        $this->admin_data = $this->set_custom_session->admin_session();

        #email config
        $config['protocol'] = 'sendmail';
        //$config['charset'] = 'iso-8859-1';
        //$config['wordwrap'] = TRUE;

        $this->email->initialize($config);

        $this->school_email = "webmailer@sdca.edu.ph";

        $datestring = "%Y-%m-%d";
        $time = time();
        $this->date_time = mdate($datestring, $time);
        
    }

    public function index()
    {
        $this->data['array_program_code_list'] = $this->Global_Program_Model->get_program_code_list();
        $this->data['array_adivsing_term'] = $this->Global_Program_Model->get_advising_term();
        $this->render($this->set_views->send_soa());
    }

    public function send_email()
    {
        $this->program_code = $this->input->post('programCode');
        $this->semester = $this->input->post('semester');
        $this->school_year = $this->input->post('schoolYear');
        $this->term = $this->input->post('term');
        $this->due_date = $this->input->post('dueDate');

        #check if the form is complete
        $form_checker = $this->form_check();
        
        if ($form_checker == 0) {
            $this->session->set_flashdata('message_error','Data not found.');
            redirect('SOA');
        }

        #save due date
        $array_data = array(
            'program_code' => $this->program_code,
            'due_date' => $this->due_date,
            'user_id' => $this->admin_data['userid'],
            'date_sent' => $this->date_time
        );
        $insert_output_id = $this->Student_Model->inset_soa_due_data($array_data); 
        if ($insert_output_id == "") {
            # code...
            $this->session->set_flashdata('message_error','Batch email not sent. Please contact MIS office.');
            redirect('SOA');
        }

        #get student list by Program
        $array_students = $this->Student_Model->get_student_list_by_program($this->program_code, $this->semester, $this->school_year);

        #batch email
        foreach ($array_students as $key => $student) {
            $this->email->clear();
            $this->email->to($student['Email']);
            $this->email->from($this->school_email);
            $this->email->subject('Here is your info');
            $this->email->message('Hi '.$student['First_Name'].' '.$student['Middle_Name'].' '.$student['Last_Name'].' '.' Here is the info you requested. https://stdominiccollege.edu.ph/WEBDOSE/index.php/soa_download/'.$student['Student_Number'].'/'.$insert_output_id);
            $this->email->send();
        }

        $this->session->set_flashdata('message_success', 'Email Sent');
        redirect('SOA');

    }

    protected function form_check()
    {
        if (!$this->program_code || !$this->semester || !$this->school_year || !$this->term || !$this->due_date) {
            $output = 0;
        }
        else {
            $output = 1;
        }

        return $output;
    }

    public function sample_output()
    {
        
        $student_no = 20170223; //20180029;
        $semester = "second";
        $school_year = "2020-2021";//"2018-2019";
        $due_date = "2021-03-22";
        $student_info = $this->Global_Student_Model->get_student_info_by_student_no($student_no);
        
        $array_params = array(
            'student_info' => $student_info[0],
            'student_type' => "HED",
            'due_date' => $due_date
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
        $array_adivsing_term = $this->Global_Program_Model->get_advising_term();
        $array_params['array_advising_term'] = $array_adivsing_term;

        #get OR list
        $array_or_list = $this->Fees_Model->get_hed_or($reference_no, $semester, $school_year);
        $array_params['array_official_receipt'] = $array_or_list;

        #get remaining balance
        $array_remaining_balance = $this->Global_Fees_Model->get_hed_remaining_balance($reference_no, $student_no);
        $array_params['array_remaining_balance'] = $array_remaining_balance;

        #call soa class
        $this->load->library('Accounting/soa', $array_params);
        
        $this->soa->export();
        //$this->soa->test();

        

        
        
       




        
    }

    public function send_mail_test()
    {
        $this->program_code = "BSIT";
        $this->semester = "second";
        $this->school_year = "2020-2021";
        //$this->term = $this->input->post('term');
        $due_date = "2021-03-22";
        $student_no = "20150464";
        $due_id = 1;

        #check if the form is complete
        /*
        $form_checker = $this->form_check();
        
        if ($form_checker === 0) {
            $this->session->set_flashdata('message_error','Data not found.');
            redirect('SOA');
        }
        */

        #get student list by Program
        //$array_students = $this->Student_Model->get_student_list_by_program($this->program_code, $this->semester, $this->school_year);
        /*
        $array_students = array(
            array(
                'First_Name' => 'aldren',
                'Middle_Name' => 'B.',
                'Last_Name' => 'Sanchez',
                'Email' => 'aldrensanchez@sdca.edu.ph'
            ),
            array(
                'First_Name' => 'Gerhard ',
                'Middle_Name' => 'p.',
                'Last_Name' => 'Dilla',
                'Email' => 'gpdilla@sdca.edu.ph'
            ),
            array(
                'First_Name' => 'Charles',
                'Middle_Name' => ' ',
                'Last_Name' => 'Limuel',
                'Email' => 'charleslimuel08@sdca.edu.ph'
            ),
        );
        */
        $array_students = array(
            array(
                'First_Name' => 'aldren',
                'Middle_Name' => 'B.',
                'Last_Name' => 'Sanchez',
                'Email' => 'aldrensanchez55.games@gmail.com'
            ),
            array(
                'First_Name' => 'aldren',
                'Middle_Name' => 'B.',
                'Last_Name' => 'Sanchez 2',
                'Email' => 'gpdilla@sdca.edu.ph'
            ),
            array(
                'First_Name' => 'aldren',
                'Middle_Name' => 'B.',
                'Last_Name' => 'Sanchez 3',
                'Email' => 'albs55@yahoo.com'
            ),
        );
        //print_r($array_students);
        //return;
        #batch email
        foreach ($array_students as $key => $student) {
            $this->email->clear();
            $this->email->to($student['Email']);
            $this->email->cc('aldrensanchez@sdca.edu.ph');
            $this->email->from($this->school_email);
            $this->email->subject('Here is your info');
            $this->email->message('Hi '.$student['First_Name'].' '.$student['Middle_Name'].' '.$student['Last_Name'].' '.'https://stdominiccollege.edu.ph/WEBDOSE/index.php/soa_download/'. $student_no . '/' . $due_id );
            $this->email->send();
            //$this->email->send(FALSE);
            //$this->email->print_debugger(array('headers'));
            //echo "<br> loop send mail";
        }
        // Will only print the email headers, excluding the message subject and body
        //$this->email->print_debugger(array('headers'));
    }

    public function sample_outputs()
    {
        $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
        echo $f->format(1432);

       
    }

    public function test()
    {
        $student_no = $this->input->post('student_no');
        $semester = $this->input->post('semester');
        $school_year = $this->input->post('school_year');
        $due_date = $this->input->post('due_date');
        $student_info = $this->Global_Student_Model->get_student_info_by_student_no($student_no);
        
        $array_params = array(
            'student_info' => $student_info[0],
            'student_type' => "HED",
            'due_date' => $due_date
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
        $array_adivsing_term = $this->Global_Program_Model->get_advising_term();
        $array_params['array_advising_term'] = $array_adivsing_term;

        #get OR list
        $array_or_list = $this->Fees_Model->get_hed_or($reference_no, $semester, $school_year);
        $array_params['array_official_receipt'] = $array_or_list;

        #get remaining balance
        $array_remaining_balance = $this->Global_Fees_Model->get_hed_remaining_balance($reference_no, $student_no);
        $array_params['array_remaining_balance'] = $array_remaining_balance;

        #call soa class
        $this->load->library('Accounting/soa', $array_params);
        
        $this->soa->export();
    }

    public function format_checker()
    {
        $student_no = 20180029;
        $semester = "second";
        $school_year = "2018-2019";
        $student_info = $this->Global_Student_Model->get_student_info_by_student_no($student_no);
        
        $array_params = array(
            'student_info' => $student_info[0],
            'student_type' => "HED"
        );
        $this->load->library('student', $array_params);
        $reference_no = $this->student->get_reference_no();
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

        #call soa class
        $this->load->library('Accounting/soa', $array_params);
        
        $this->soa->reader();
    }


    public function soa_api()
    {
        
        $student_no = $this->input->get_post('student_no');
        $semester = $this->input->get_post('semester');
        $school_year = $this->input->get_post('school_year');

        $student_info = $this->Global_Student_Model->get_student_info_by_student_no($student_no);
        
        $array_params = array(
            'student_info' => $student_info[0],
            'student_type' => "HED"
        );
        $this->load->library('student', $array_params);
        $reference_no = $this->student->get_reference_no();
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
        $array_adivsing_term = $this->Global_Program_Model->get_advising_term();
        $array_params['array_advising_term'] = $array_adivsing_term;

        #call soa class
        $this->load->library('Accounting/soa', $array_params);
        
        $this->soa->export();

        
    }

    public function email_test()
    {
        $this->email->from($this->school_email, 'Your Name');
        $this->email->to('aldrensanchez@sdca.edu.ph');
        

        $this->email->subject('Email Test');
        $this->email->message('Testing the email class.');

        $this->email->send();
        echo $this->email->print_debugger();
    }

    
}