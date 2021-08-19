<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Des extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('Digital_ID_Model/Forms_Model');
		$this->load->library('set_views');
		$this->load->library('session');
		$this->load->library('set_custom_session');
		$this->load->library('email');
		$this->load->library('sdca_mailer', array('email' => $this->email, 'load' => $this->load));
		$this->date_today = date("Y-m-d");
	}
	public function index()
	{
	}
	public function digital_citizenship()
	{
		if(!empty($this->input->post('export')))
			$this->data['student'] = $this->getDigitalCitizenship();
		else
			$this->data['student'] = $this->getDigitalCitizenship();

		$this->render($this->set_views->digital_citizenship());
	}
	// DIgital
	public function getDigitalCitizenship()
	{
		$array = array(
			'date_today' => date("Y-m-d"),
			'inquiry_from' => $this->input->post('inquiry_from'),
			'inquiry_to' => $this->input->post('inquiry_to'),
			'identity_no' => $this->input->post('identity_no'),
			'search' => $this->input->post('search_button'),
		);
		$getDigitalCitizenship = $this->Forms_Model->getDigitalCitizenship($array);
		return $getDigitalCitizenship;

		// $student = $this->AssesmentModel->get_student_with_course($getDigitalCitizenship['reference_number']);
		// $first_name = $this->clean($student['First_Name']);
		// $last_name = $this->clean($student['Last_Name']);
		// $getDigitalCitizenship['email'] = $first_name.'.'.$last_name.'@sdca.edu.ph';

		// echo json_encode($getDigitalCitizenship);
	}
	public function getDigitalCitizenshipAccount()
	{
		$digital_id = $this->input->post('digital_id');
		$getDigitalCitizenshipAccount = $this->Forms_Model->getDigitalCitizenshipAccount($digital_id);
		echo json_encode($getDigitalCitizenshipAccount);
	}

	public function updateDigitalCitizenshipAccount()
	{
		$digital_id = $this->input->post('digital_id');
		$status = $this->input->post('status');
		$array = array(
			'digital_id' => $digital_id,
			'status' => $status,
		);
		$this->Forms_Model->updateDigitalCitizenshipAccount($array);
	}
	// ID
	public function id_application()
	{
		// $this->data['student'] = $this->getIdApplication();
		// if(!empty($this->input->post('search_button')))
		// 	$this->data['student'] = $this->getIdApplication();
		// else
		if(!empty($this->input->post('export')))
			$this->data['student'] = $this->getIdApplication();
		else
			$this->data['student'] = $this->getIdApplication();
		
		// die(json_encode($this->data['student']));
		$this->render($this->set_views->id_application());
	}
	public function getIdApplication()
	{
		$array = array(
			'date_today' => date("Y-m-d"),
			'inquiry_from' => $this->input->post('inquiry_from'),
			'inquiry_to' => $this->input->post('inquiry_to'),
			'identity_no' => $this->input->post('identity_no'),
			'search' => $this->input->post('search_button'),
		);
		$getIdApplication = $this->Forms_Model->getIdApplication($array);
		return $getIdApplication;
		// echo json_encode($getIdApplication);
	}
	public function updateIdApplication()
	{
		$id_application = $this->input->post('id_application');
		$status = $this->input->post('status');
		$custom_msg = $this->input->post('custom_msg');
		// die($id_application);
		$array = array(
			'id_application' => $id_application,
			'status' => $status,
		);
		// Session for sender
		// {"userid","fullname","position","username":"bell}
		$this->data['admin_data'] = $this->set_custom_session->admin_session();
		$this->Forms_Model->updateIdApplication($array);
		if ($status == 'done') {
			$id_user = $this->Forms_Model->getSingleIdApplication($array['id_application']);
			if (empty($custom_msg)) {
				$email_data = array(
					'send_to' => $id_user['first_name'] . ' ' . $id_user['last_name'],
					'reply_to' => 'webmailer@sdca.edu.ph',
					'sender_name' => 'St. Dominic College of Asia',
					'send_to_email' => $id_user['Email'],
					'subject' => 'ID Application Update',
					'message' => 'Email/IdApplication'
				);
				$this->sdca_mailer->id_application_done(
					$email_data['send_to'],
					$email_data['reply_to'],
					$email_data['sender_name'],
					$email_data['send_to_email'],
					$email_data['subject'],
					$email_data['message'],
					$this->data['admin_data']
				);
			}else{
				$email_data = array(
					'send_to' => $id_user['first_name'] . ' ' . $id_user['last_name'],
					'reply_to' => 'webmailer@sdca.edu.ph',
					'sender_name' => 'St. Dominic College of Asia',
					'send_to_email' => $id_user['Email'],
					'subject' => 'ID Application Update',
					'message' => $custom_msg,
				);
				$this->sdca_mailer->id_application_custome_msg(
					$email_data['send_to'],
					$email_data['reply_to'],
					$email_data['sender_name'],
					$email_data['send_to_email'],
					$email_data['subject'],
					$email_data['message']
				);
			}
		}
	}
	public function idApplicationError()
	{
		$id_application = $this->input->post('id_application');
		$id_user = $this->Forms_Model->getSingleIdApplication($id_application);
		$email_data = array(
			'send_to' => $id_user['first_name'] . ' ' . $id_user['last_name'],
			'reply_to' => 'webmailer@sdca.edu.ph',
			'sender_name' => 'St. Dominic College of Asia',
			'send_to_email' => $id_user['Email'],
			'subject' => 'ID Application Error',
			'message' => 'Email/IdApplicationError'
		);
		// Session for sender
		// {"userid","fullname","position","username":"bell}
		$this->data['admin_data'] = $this->set_custom_session->admin_session();
		// die(json_encode($this->set_custom_session->admin_session()));
		$this->sdca_mailer->id_application_done(
			$email_data['send_to'],
			$email_data['reply_to'],
			$email_data['sender_name'],
			$email_data['send_to_email'],
			$email_data['subject'],
			$email_data['message'],
			$this->data['admin_data']
		);
	}
}
