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
        $req_id = $this->input->get('id');
        $getStudentInfowithReqID = $this->Treasury_Model->getStudentInfowithReqID($req_id);
        $folder_name = $getStudentInfowithReqID['ref_no'].'/'.$getStudentInfowithReqID['Last_Name'].', '.$getStudentInfowithReqID['First_Name'] . ' ' . $getStudentInfowithReqID['Middle_Name'];
        $all_uploadeddata = array(
            // 'parent_id' => '1Hrg19tx5YgsxFJ2T--HblVRmoJtfnhhj',
            'parent_id' => '1aNXXe7fO_amTVsXYFMz8yz36NqeYCXnu',
            'folder_name' => $folder_name,
            'token_type' => 'treasury',
            'file_name' => $getStudentInfowithReqID['file_submitted'],
        );
        // echo '<pre>'.print_r($getStudentInfowithReqID,1).'</pre>';
        // exit;
        $string = http_build_query($all_uploadeddata);
        // $ch = curl_init("http://localhost:4004/gdriveuploader/move");
        $ch = curl_init("http://stdominiccollege.edu.ph:4004/gdriveuploader/move");
        curl_setopt($ch,CURLOPT_POST,true);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_FAILONERROR, true);
        $result = curl_exec($ch);
        if($result=="success"){
            $this->Treasury_Model->updateProofofPaymentWithReqID(array('proof_status'=>0),$req_id);
        }
        if (curl_errno($ch)) {
            $error_msg = curl_error($ch);
            echo $error_msg;
        }
        else{
            echo $result;
        }
        curl_close($ch);
        // $this->load->view('Email/ValidatedProofofPayment',array('data'=>$getStudentInfowithReqID));
    }
    public function verifyProofofPayment(){
        $req_id = $this->input->get('req_id');
        $amount_paid = $this->input->get('amount_paid');
        $this->Treasury_Model->updateProofofPaymentWithReqID(array('amount_paid'=>$amount_paid),$req_id);
        $getStudentInfowithReqID = $this->Treasury_Model->getStudentInfowithReqID($req_id);
        // $folder_name = $this->session->userdata('last_name').', '.$this->session->userdata('first_name') . ' ' . $this->session->userdata('middle_name');
        $folder_name = $getStudentInfowithReqID['ref_no'].'/'.$getStudentInfowithReqID['Last_Name'].', '.$getStudentInfowithReqID['First_Name'] . ' ' . $getStudentInfowithReqID['Middle_Name'];
        // echo json_encode(array('msg'=>'success','data'=>$getStudentInfowithReqID));
        // exit;
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
        $all_uploadeddata = array(
            'parent_id' => '1f6rcykwmcgbePXKPLR6cpzymPPjX8ayd',
            // 'parent_id' => '1lLObKQNw6GZqFu5x-qtoFtkXyaK60pzH',
            'folder_name' => $folder_name,
            'token_type' => 'treasury',
            'file_name' => $getStudentInfowithReqID['file_submitted'],
        );
        $string = http_build_query($all_uploadeddata);
        // $ch = curl_init("http://localhost:4004/gdriveuploader/move");
        $ch = curl_init("http://stdominiccollege.edu.ph:4004/gdriveuploader/move");
        curl_setopt($ch,CURLOPT_POST,true);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_FAILONERROR, true);
        $result = curl_exec($ch);
        
        if($result=="success"){
            $email_status = $this->sendEMail($email_data);
            if($email_status['msg']=='success'){
                $this->Treasury_Model->updateProofofPaymentWithReqID(array('proof_status'=>1),$req_id);
                echo json_encode(array('msg'=>'success'));
            }
            else{
                echo json_encode(array('msg'=>$email_status['msg']));
            }
        }
        else{
            echo json_encode(array('msg'=>"There's a problem on Google Drive Api",'error'=>empty(curl_error($ch))?'':curl_error($ch)));
        }
        curl_close($ch);

        
    }
    public function rejectProofOfPayment(){
        $req_id = $this->input->get('id');
        $getStudentInfowithReqID = $this->Treasury_Model->getStudentInfowithReqID($req_id);
        $email_data = array(
            // 'from' => 'treasuryoffice@sdca.edu.ph',
            'from' => 'jfabregas@sdca.edu.ph',
            'from_name' => 'SDCA Treasury',
            'send_to' => 'jhonnormanfabregas@gmail.com',
            // 'send_to' => $getStudentInfowithReqID['Student_Email'],
            'subject' => 'Validate Proof of Payment',
            'message' => 'Email/RejectedProofOfPayment',
            'data' => array('data'=>$getStudentInfowithReqID)
        );
        $email_status = $this->sendEMail($email_data);
        if($email_status['msg']=='success'){
            $this->Treasury_Model->updateProofofPaymentWithReqID(array('proof_status'=>-1),$req_id);
            echo json_encode(array('msg'=>'success'));
        }
        else{
            echo json_encode(array('msg'=>$email_status['msg']));
        }
    }
    public function viewProofOfPaymentImage(){
        $id = $this->input->get('id');
        $getStudentInfowithReqID = $this->Treasury_Model->getStudentInfowithReqID($id);
        // echo '<pre>'.print_r($getStudentInfowithReqID,1).'</pre>';
        // exit;
        // $all_uploadeddata = array('file_name'=>$data['file_name'],"folder_id"=>'','token_type'=>'treasury');
        $all_uploadeddata = array('file_name'=>$getStudentInfowithReqID['file_submitted'],"folder_id"=>'','token_type'=>'treasury');
        $string = http_build_query($all_uploadeddata);
        // $ch = curl_init("http://stdominiccollege.edu.ph:4004/gdriveuploader/get_id");
        $ch = curl_init("http://localhost:4004/gdriveuploader/get_id");
        curl_setopt($ch,CURLOPT_POST,true);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        // curl_setopt($ch, CURLOPT_FAILONERROR, true);
        $result = curl_exec($ch);
        $decode_result = json_decode($result, true);
        if(!empty($result)){
            if($decode_result['msg']=="success"){
                if(empty($decode_result['id'])){
                    // echo json_encode(array('msg'=>'error','error'=>'ERROR:Returned empty value!'));
                    echo '<strong>ERROR: Returned empty value!</strong>';

                }
                else{
                    // echo json_encode(array('msg'=>'success','link'=>'https://drive.google.com/file/d/'.$decode_result['id'].'/view'));
                    redirect('https://drive.google.com/file/d/'.$decode_result['id'].'/view');
                }
            }
            else{
                // echo json_encode(array('msg'=>'error','error'=>'ERROR:'.$decode_result['msg']));
                echo '<strong>ERROR:'.$decode_result['msg'].'</strong>';
            }
        }else{
            // echo json_encode(array('msg'=>'error','error'=>'ERROR:Google Drive API is Offline!!'));
            echo '<strong>ERROR:Google Drive API is Offline!!</strong>';
        }
        curl_close($ch);
    }
}