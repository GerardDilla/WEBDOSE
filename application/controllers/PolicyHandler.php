<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class PolicyHandler extends MY_Controller  {
    
    public function __construct() 
    {
        parent::__construct();
        $this->load->model('Policy_Model');
    }
    public function PrivacyPolicy(){

        $array = array(
            'Reference_Number' => $this->input->get('id'),
            'System' => $this->input->get('sys'),
            'Date' => date("Y-m-d"),
        );
        $result = $this->Policy_Model->insert_agreement($array);
        echo 'insert ID:'.$result;
    }
    public function CheckAgreement(){
        $array = array(
            'Reference_Number' => $this->input->get('id'),
            'System' => $this->input->get('sys')
        );
        $result = $this->Policy_Model->check_privacy_agreement($array);
        echo $result;
    }
}
