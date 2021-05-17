<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Sdca_mailer
{
	protected $library;
    public function __construct($library){
		$this->library = $library;
    }
	public function sendEmail($cp,$from,$from_name,$send_to,$subject,$message)
	{
        $config = Array(
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
		$this->library['email']->initialize($config);
		$this->library['email']->set_newline("\r\n");
		$this->library['email']->from($from, $from_name);
		$this->library['email']->to($send_to);
		$this->library['email']->subject($subject);
		$this->library['email']->message($message);
		if($this->library['email']->send()){
				echo  'Email has been sent to '.$cp;
				echo  '<br><br>';
		}else{
				echo  "<h4>There was a problem with sending an email.</h4>";
				echo  "<br><br>For any concers, proceed to our <a href'#' style'font-size:15px; color:#00F;'>Helpdesk</a> or the MIS Office.";        
		}

	}
	public function sendHtmlEmail($cc,$cp,$from,$from_name,$send_to,$subject,$message,$add_data)
	{
        $config = Array(
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
			// 'wordwrap' => true
		);
		$this->library['email']->initialize($config);
		$this->library['email']->set_newline("\r\n");
		$this->library['email']->from($from, $from_name);
		$this->library['email']->to($send_to);
		$this->library['email']->subject($subject);
		$this->library['email']->cc($cc);
		$this->library['email']->message($this->library['load']->view($message,$add_data,true));
		if($this->library['email']->send()){
				echo  'Email has been sent to '.$cp;
				// exit;
			// echo json_encode(array('success'=>'Email has been sent to '.$cp));
		}else{
				// exit;
			// echo json_encode(array('error'=>'There was a problem sending an email'));
				echo  "<h4>There was a problem with sending an email.</h4>";
				echo  "<br><br>For any concers, proceed to our <a href'#' style'font-size:15px; color:#00F;'>Helpdesk</a> or the MIS Office.";        
		}

	}

}