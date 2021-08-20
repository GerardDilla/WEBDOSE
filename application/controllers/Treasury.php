<?php

// use SebastianBergmann\CodeCoverage\Report\Html\Renderer;

defined('BASEPATH') OR exit('No direct script access allowed');

class Treasury extends MY_Controller  {
    public function __construct(){
        parent::__construct();
        header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST');
        header('Access-Control-Request-Headers: Content-Type');
        
        // parent::__construct();
        $this->load->library('set_views');
        $this->load->library('email');
        $this->load->library('session');
        $this->load->library('set_custom_session');
        $this->admin_data = $this->set_custom_session->admin_session();

        //user accessibility
        $this->load->library('User_accessibility');
        $this->user_accessibility->module_treasury_access($this->admin_data['userid']);
        $this->load->model('Treasury_Model/Treasury_Model');
    }
    public function sendEMail($data){
        $config = array(
            'protocol'  => 'smtp',
            'smtp_host' => 'ssl://smtp.gmail.com',
            'smtp_port' => '465',
            'smtp_timeout' => '7',
            'smtp_user' => 'webmailer@sdca.edu.ph',
            'smtp_pass' => 'sdca2017',
            // 'smtp_user' => 'des.ict@sdca.edu.ph',
            // 'smtp_pass' => 'digitalcampus',
            'charset' => 'utf-8',
            'newline' => '\r\n',
            'mailtype'  => 'html',
            'validation' => true
        );
        
        $this->email->initialize($config);
        $this->email->set_newline("\r\n");
        $this->email->from($data['from'], $data['from_name']);
        $this->email->to($data['send_to']);
        $this->email->subject($data['subject']);
        $this->email->message($this->load->view($data['message'], $data['data'], true));
        if ($this->email->send()) {
            // echo  'Email has been sent to ' . $cp;
            // echo json_encode(array('success'=>'Email has been sent to '.$cp));
            // echo json_encode(array('status'=>'success'));
            return array('msg'=>'success');
        } else {
            // echo json_encode(array('status'=>'error','msg'=>'There was a problem sending an email'));
            return array('msg'=>'There was a problem sending an email');
            // echo json_encode(array('error' => 'There was a problem sending an email'));
            // echo  "There was a problem with sending an email.";
            // echo  "<br><br>For any concers, proceed to our <a href'#' style'font-size:15px; color:#00F;'>Helpdesk</a> or the MIS Office.";        
        }
        
    }
    public function index(){
        $this->render($this->set_views->proof_of_payment());
    }
    public function proof_of_payment_ajax(){
        $array = array(
            'from'=>$this->input->post('from'),
            'to'=>$this->input->post('to'),
        );
        // $array = array(
        //     'from'=>'2021-05-11',
        //     'to'=>'2021-05-12',
        // );
        $proofs = $this->Treasury_Model->proof_of_payment($array);
        // echo '<pre>'.print_r($proofs,1).'</pre>';
        echo json_encode($proofs);
    }
    public function sampleView(){
        $getStudentInfowithReqID = $this->Treasury_Model->getStudentInfowithReqID('9');
        echo '<pre>'.print_r($getStudentInfowithReqID,1).'</pre>';
        exit;
        $this->load->view('Email/ValidatedProofofPayment',array('data'=>$getStudentInfowithReqID));
    }
    public function verifyProofofPayment(){
        $req_id = $this->input->get('req_id');
        $getStudentInfowithReqID = $this->Treasury_Model->getStudentInfowithReqID($req_id);
        $email_data = array(
            'from' => 'treasuryoffice@sdca.edu.ph',
            // 'from' => 'jfabregas@sdca.edu.ph',
            'from_name' => 'SDCA Treasury',
            // 'send_to' => 'jhonnormanfabregas@gmail.com',
            'send_to' => $getStudentInfowithReqID['Student_Email'],
            'subject' => 'Validate Proof of Payment',
            'message' => 'Email/ValidatedProofofPayment',
            'data' => array('data'=>$getStudentInfowithReqID)
        );
        $email_status = $this->sendEMail($email_data);
        if($email_status['msg']=='success'){
            $this->Treasury_Model->updateProofofPaymentWithReqID(array('proof_status'=>1),$req_id);
            echo json_encode(array('msg'=>'success'));
        }
        else{
            echo json_encode(array('msg'=>$email_status['msg']));
        }
    }
}