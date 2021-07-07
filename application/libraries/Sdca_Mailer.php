<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class sdca_mailer
{
    public function __construct($parameters)
    {
        $this->email = $parameters['email'];
        $this->load = $parameters['load'];
    }
    public function webmailer_config()
    {
        $config = array(
            'protocol'  => 'smtp',
            'smtp_host' => 'ssl://smtp.gmail.com',
            'smtp_port' => '465',
            'smtp_timeout' => '7',
            'smtp_user' => 'webmailer@sdca.edu.ph',
            'smtp_pass' => 'sdca2017',
            'charset' => 'utf-8',
            'newline' => '\r\n',
            'mailtype'  => 'html',
            'validation' => true
        );
        $this->email->initialize($config);
    }
    public function id_application_done($cp,$from,$from_name,$send_to,$subject,$message,$add_data)
    {
        $this->webmailer_config();
        $this->email->set_newline("\r\n");
        $this->email->from($from, $from_name);
        $this->email->to($send_to);
        $this->email->subject($subject);
        $this->email->message($this->load->view($message, $add_data, true));
        if ($this->email->send()) {
            // echo  'Email has been sent to ' . $cp;
            // echo json_encode(array('success'=>'Email has been sent to '.$cp));
        } else {
            // echo json_encode(array('error' => 'There was a problem sending an email'));
            // echo  "There was a problem with sending an email.";
            // echo  "<br><br>For any concers, proceed to our <a href'#' style'font-size:15px; color:#00F;'>Helpdesk</a> or the MIS Office.";        
        }
    }
}
