<?php

use SebastianBergmann\CodeCoverage\Report\Html\Renderer;

defined('BASEPATH') or exit('No direct script access allowed');

class StatementOfAccount extends MY_Controller
{

    protected $admin_data;
    protected $school_year;
    protected $semester;
    protected $term;
    protected $program_code;
    protected $school_email;
    protected $due_date;
    protected $date_time;
    protected $per_page;
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

        // $this->load->library('email');
        // $this->load->library('sdca_mailer', array('email' => $this->email, 'load' => $this->load));

        $this->load->model('Global_Model/Global_Program_Model');
        $this->load->model('Account_Model/Logs_Model');
        $this->load->model('Accounting_Model/Student_Model');
        $this->load->model('Accounting_Model/Fees_Model');
        $this->load->model('Global_Model/Global_Fees_Model');
        $this->load->model('Global_Model/Global_Student_Model');

        //check if user is logged on
        $this->load->library('set_custom_session');
        $this->admin_data = $this->set_custom_session->admin_session();

        #email config
        $config['protocol']    = 'smtp';
        $config['smtp_host']    = 'ssl://smtp.gmail.com';
        $config['smtp_port']    = '465';
        $config['smtp_timeout'] = '7';
        // $config['smtp_user']    = 'webmailer@sdca.edu.ph';
        $config['smtp_user']    = 'sdcamailer_soa@sdca.edu.ph';
        // $config['smtp_pass']    = 'dgojehpfiftlzoqy';
        // $config['smtp_pass']    = 'sdca2017';
        $config['smtp_pass']    = 'sdca2021';
        $config['charset']    = 'utf-8';
        $config['newline']    = "\r\n";
        $config['mailtype'] = 'html';
        $config['validation'] = TRUE;
        // $config['wordwrap'] = TRUE;

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
        // $form_checker = $this->form_check();

        // if ($form_checker == 0) {
        //     $this->session->set_flashdata('message_error', 'Data not found.');
        //     redirect('SOA');
        // }

        #save due date
        $array_data = array(
            'program_code' => $this->program_code,
            'due_date' => $this->due_date,
            'user_id' => $this->admin_data['userid'],
            'date_sent' => $this->date_time
        );
        // $insert_output_id = $this->Student_Model->inset_soa_due_data($array_data);
        // if ($insert_output_id == "") {
        //     $this->session->set_flashdata('message_error', 'Batch email not sent. Please contact MIS office.');
        //     redirect('SOA');
        // }

        #get student list by Program

        $array_students = $this->Student_Model->get_student_list_by_program($this->program_code, $this->semester, $this->school_year);
        $sample_students = $this->Student_Model->get_student_id('10','10');
        $total_email = count($array_students);
        // $total_email = 256;
        $email_success_count = 0;
        $email_error_count = 0;
        $per_page = 50;
        
        // echo  'program code: '.$this->program_code.'<br>school_year: '.$this->school_year.'<br>semester: '.$this->semester; exit;
        $sample_array = array();
        $less = $total_email%$per_page;
        
        if($less==0){
            $count_page = $total_email/$per_page;
        }
        else{
            $total_email_with_less = $total_email-$less;

            $count_page = ($total_email_with_less/$per_page) + 1;
        }
        // echo $count_page;
        // echo '<pre>'.print_r($array_students,1).'</pre>';
        // echo json_encode(array('total'=>$total_email,'success'=>$email_success_count,'error'=>$email_success_count,'less'=>$total_email%$per_page,'total_page'=>$count_page));
        // exit;
        foreach ($array_students as $key => $student) {
            $this->email->clear();
            // $this->email->to($student['Email']);
            // $this->email->from($this->school_email);
            // $this->email->subject('Here is your info');
            $this->email->to('jhonnormancorpuz@gmail.com');
            $this->email->from('jhonnormanfabregas@gmail.ph','St. Dominic College of Asia');
            $this->email->subject('SOA - '.strtoupper($student['First_Name'] . ' ' . $student['Middle_Name'] . ' ' . $student['Last_Name']).' - '.$this->program_code);
            $this->email->message('Hi ' . $student['First_Name'] . ' ' . $student['Middle_Name'] . ' ' . $student['Last_Name'] . ' ' . ' Here is the info you requested. http://localhost/WEBDOSE/index.php/soa_downloadpdf/(:any)/(:any)/(:any)/(:any)/' . $student['Student_Number'] . '/' . $insert_output_id);
            if($this->email->send()){
                ++$email_success_count;
                // echo '<pre>'.print_r($student,1).'</pre><br>';
            }
            else{
                ++$email_error_count;
            }
        }
        echo json_encode(array('total'=>$total_email,'success'=>$email_success_count,'error'=>$email_error_count));
        
        exit;
        $this->session->set_flashdata('message_success', 'Email Sent');
        // redirect('SOA');
    }
    // public function 
    public function getEmailData(){
        $this->program_code = $this->input->get('programCode');
        $this->semester = $this->input->get('semester');
        if($this->semester=="1"){
            $this->semester=="FIRST";
        }
        else if($this->semester=="2"){
            $this->semester = "SECOND";
        }
       
        $this->school_year = $this->input->get('schoolYear');
        $array_students = $this->Student_Model->get_student_list_by_program($this->program_code, $this->semester, $this->school_year);
        // $total_email = 256;
        $total_email = count($array_students);
        $email_success_count = 0;
        $email_error_count = 0;
        $this->per_page = 5;
        $less = $total_email%$this->per_page;
        if($less==0){
            $count_page = $total_email/$this->per_page;
        }
        else{
            $total_email_with_less = $total_email-$less;

            $count_page = ($total_email_with_less/$this->per_page) + 1;
        }
        // $this->session->unset_userdata('soa_email_logs');
        $this->session->set_userdata('soa_email_logs',array());
        echo json_encode(array('total'=>$total_email,'per_page'=>$this->per_page,'less'=>$less,'total_page'=>$count_page));
        // exit;
    }
    public function batchSend(){
        $page = $this->input->get('page');
        $userid = $this->session->logged_in['userid'];
        $date_today = date("Y-m-d H:i:s");
        $email_success_count = 0;
        $email_error_count = 0;
        $per_page = $this->input->get('per_page');
        $offset = ($page-1)*$per_page;
        $program_code = $this->input->get('programCode');
        $semester = $this->input->get('semester');
        $school_year = $this->input->get('schoolYear');
        $due_date = $this->input->get('due_date');
        $email_logs = $this->session->userdata('soa_email_logs');
        if($semester=="1"){
            $semester=="FIRST";
        }
        else if($semester=="2"){
            $semester = "SECOND";
        }
        if($page==1){
            $insert_logs['user_id'] = $userid;
            $insert_logs['module'] = 'Statement of Account - Send batch Email';
            $insert_logs['action'] = 'Send Batch Email: Program Code:"'.$program_code.'",Semester:"'.$semester.'",School Year:"'.$school_year.'"';
            // $insert_logs['action'] = 'INSERT INTO `web_dose_logs` (`user_id`,`module`) "program_code":"'.$program_code.'","semester":"'.$semester.'","school_year":"'.$school_year.'"}';
            $insert_logs['transaction_date'] = $date_today;
            // $this->Student_Model->insertWebDoseLogs($insert_logs);
        }
        $array_students = $this->Student_Model->getStudentListPaginated($program_code, $semester, $school_year,$per_page,$offset);
        foreach ($array_students as $key => $student) {
            $this->email->clear();
            // $this->email->to($student['Email']);
            // $this->email->from($this->school_email);
            // $this->email->subject('Here is your info');
            // $ref_no = "",$sem="",$sy="",$due =""
            
            // $this->email->to($student['Email']);
            $this->email->to('jhonnormanfabregas@gmail.com');
            $this->email->from('soa_accounting@sdca.edu.ph','St. Dominic College of Asia');
            $this->email->subject('SOA - '.strtoupper($student['First_Name'] . ' ' . $student['Middle_Name'] . ' ' . $student['Last_Name']).' - '.$program_code.' - PAGE:'.$page);
            // $this->email->message('Hi ' . $student['First_Name'] . ' ' . $student['Middle_Name'] . ' ' . $student['Last_Name'] . ' ' . ' Here is the info you requested. http://localhost/WEBDOSE/index.php/soa_downloadpdf/'.$student['Reference_Number'].'/'.$semester.'/'.$school_year.'/' . $student['Student_Number'] . '/' . $insert_output_id);
            // $this->email->message('Hi ' . $student['First_Name'] . ' ' . $student['Middle_Name'] . ' ' . $student['Last_Name'] . ' ' . ' Here is the info you requested. {wrap}http://[::1]/WEBDOSE/index.php/StatementOfAccount/soa?ref_no='.$student['Reference_Number'].'&sem='.$semester.'&sy='.$school_year.'&due=' . $due_date .'{/wrap}');
            $this->email->message($this->load->view('body/Accounting/EmailSoa',array('student'=>$student,'link'=>'https://stdominiccollege.edu.ph/WEBDOSE/index.php/StudentSoa/soa_download?ref_no='.$student['Reference_Number'].'&sem='.$semester.'&sy='.$school_year.'&due=' . $due_date),true));
            // $this->email->message($this->load->view('body/Accounting/EmailSoa',array('student'=>$student,'link'=>'http://[::1]/WEBDOSE/index.php/StudentSoa/soa_download?ref_no='.$student['Reference_Number'].'&sem='.$semester.'&sy='.$school_year.'&due=' . $due_date),true));
            // $this->email->send();
            if($this->email->send()){
                array_push($email_logs,array(
                    'status' => 'success',
                    'reference_no' => $student['Reference_Number'],
                    'full_name' => strtoupper($student['First_Name'] . ' ' . $student['Middle_Name'] . ' ' . $student['Last_Name'])
                ));
                ++$email_success_count;
            }
            else{
                array_push($email_logs,array(
                    'status' => 'error',
                    'reference_no' => $student['Reference_Number'],
                    'full_name' => strtoupper($student['First_Name'] . ' ' . $student['Middle_Name'] . ' ' . $student['Last_Name']),
                    'program_code' => $program_code,
                    'semester' => $semester,
                    'school_year' => $school_year,
                    'due_date' => $due_date
                ));
                ++$email_error_count;
            }
        $this->session->set_userdata('soa_email_logs',$email_logs);
        }
        echo json_encode('success');
    }
    public function retrySend(){
        // $program_code = $this->input->post('programCode');
        // $semester = $this->input->post('semester');
        // $school_year = $this->input->post('schoolYear');
        // $due_date = $this->input->post('due_date');
        $program_code = 'CGNCII';
        $semester = 'FIRST';
        $school_year = '2021-2022';
        $due_date = '';
        $ref_no = $this->input->post('reference_no');
        $student = $this->Student_Model->getStudentInfoByRefNo($ref_no);
        // if($ref_no == "26455"||$ref_no == "26617"||$ref_no == "26734"){
        //     $this->email->to('asd');
        // }
        // else{
        //     $this->email->to('jhonnormanfabregas@gmail.com');
        // }
        $this->email->to('jhonnormanfabregas@gmail.com');
        $this->email->from('soa_accounting@sdca.edu.ph','St. Dominic College of Asia');
        $this->email->subject('SOA - '.strtoupper($student['First_Name'] . ' ' . $student['Middle_Name'] . ' ' . $student['Last_Name']).' - '.$program_code);
        // $this->email->message('Hi ' . $student['First_Name'] . ' ' . $student['Middle_Name'] . ' ' . $student['Last_Name'] . ' ' . ' Here is the info you requested. http://localhost/WEBDOSE/index.php/soa_downloadpdf/'.$student['Reference_Number'].'/'.$semester.'/'.$school_year.'/' . $student['Student_Number'] . '/' . $insert_output_id);
        // $this->email->message('Hi ' . $student['First_Name'] . ' ' . $student['Middle_Name'] . ' ' . $student['Last_Name'] . ' ' . ' Here is the info you requested. {wrap}http://[::1]/WEBDOSE/index.php/StatementOfAccount/soa?ref_no='.$student['Reference_Number'].'&sem='.$semester.'&sy='.$school_year.'&due=' . $due_date .'{/wrap}');
        $this->email->message($this->load->view('body/Accounting/EmailSoa',array('student'=>$student,'link'=>'https://stdominiccollege.edu.ph/WEBDOSE/index.php/StudentSoa/soa_download?ref_no='.$student['Reference_Number'].'&sem='.$semester.'&sy='.$school_year.'&due=' . $due_date),true));
        // $this->email->message($this->load->view('body/Accounting/EmailSoa',array('student'=>$student,'link'=>'http://[::1]/WEBDOSE/index.php/StudentSoa/soa_download?ref_no='.$student['Reference_Number'].'&sem='.$semester.'&sy='.$school_year.'&due=' . $due_date),true));
        // $this->email->send();
        if($this->email->send()){
            echo json_encode('success');
        }
        else{
            echo json_encode('error');
        }
    }
    public function getEmailLogs(){
        echo json_encode(array('logs'=> $this->session->userdata('soa_email_logs')));
    }
    protected function form_check()
    {
        if (!$this->program_code || !$this->semester || !$this->school_year || !$this->term || !$this->due_date) {
            $output = 0;
        } else {
            $output = 1;
        }

        return $output;
    }

    public function soa()
    {
        // $student_no = 20170223; //20180029;
        // $semester = "second";
        // $school_year = "2020-2021"; //"2018-2019";
        // $due_date = "2021-03-22";
        $ref_no = $this->input->get('ref_no'); //20180029;
        $semester = $this->input->get('sem');
        $school_year = $this->input->get('sy'); //"2018-2019";
        $due_date = $this->input->get('due');
        
        // echo '<pre>'.print_r(array('student_no'=>$student_no,'semester'=>$semester,'school_year'=>$school_year,'due_date'=>$due_date),1).'</pre>';
        // exit;
        $student_no = $this->Student_Model->getStudentNumber($ref_no)['Student_Number'];
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

        $array_students = array(

            array(
                'First_Name' => 'juan',
                'Middle_Name' => 'D.',
                'Last_Name' => 'Cruz 2',
                'Email' => 'gpdilla@sdca.edu.ph'
            ),
            array(
                'First_Name' => 'juan',
                'Middle_Name' => 'D.',
                'Last_Name' => 'Cruz 2',
                'Email' => 'gerarddilla@gmail.com'
            ),

        );
        //print_r($array_students);
        //return;
        #batch email
        foreach ($array_students as $key => $student) {
            $this->email->clear();
            $this->email->to($student['Email']);
            $this->email->from($this->school_email);
            $this->email->subject('Here is your info');
            $this->email->message('Hi ' . $student['First_Name'] . ' ' . $student['Middle_Name'] . ' ' . $student['Last_Name'] . ' ' . 'https://stdominiccollege.edu.ph/WEBDOSE/index.php/soa_download/' . $student_no . '/' . $due_id);
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
        $this->email->to('gpdilla@sdca.edu.ph');


        $this->email->subject('Email Test');
        $this->email->message('Testing the email class.');

        $this->email->send();
        echo $this->email->print_debugger();
    }
    public function testLogs(){
        $data = array(
            'reference_no'=>1,
        );
    }
}
