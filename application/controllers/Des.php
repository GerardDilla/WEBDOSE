<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\HeaderFooterDrawing;
use PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf;

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
		$array = array(
			'date_today' => date("Y-m-d"),
			'inquiry_from' => $this->input->post('inquiry_from'),
			'inquiry_to' => $this->input->post('inquiry_to'),
			'identity_no' => $this->input->post('identity_no'),
			'search' => 0,
		);
		if(!empty($this->input->post('search_button'))){
			$array['search'] = 1;
		}
		
		if (!empty($this->input->post('export')))
			$this->data['student'] = $this->digitalExcel($array);
		else
			$this->data['student'] = $this->getDigitalCitizenship($array);

		$this->render($this->set_views->digital_citizenship());
	}
	// DIgital
	public function getDigitalCitizenship($array)
	{
		$getDigitalCitizenship = $this->Forms_Model->getDigitalCitizenship($array);
		return $getDigitalCitizenship;

		// $student = $this->AssesmentModel->get_student_with_course($getDigitalCitizenship['reference_number']);
		// $first_name = $this->clean($student['First_Name']);
		// $last_name = $this->clean($student['Last_Name']);
		// $getDigitalCitizenship['email'] = $first_name.'.'.$last_name.'@sdca.edu.ph';

		// echo json_encode($getDigitalCitizenship);
	}
	public function digitalExcel($array)
	{
		$object = new Spreadsheet();
		$object->setActiveSheetIndex(0);

		$object->getActiveSheet()->setCellValue('A1', 'Student Number');
		$object->getActiveSheet()->setCellValue('B1', 'Last Name');
		$object->getActiveSheet()->setCellValue('C1', 'First Name');
		$object->getActiveSheet()->setCellValue('D1', 'Middle Name');
		$object->getActiveSheet()->setCellValue('E1', 'YEAR/LEVEL');
		$object->getActiveSheet()->setCellValue('F1', 'COURSE');
		$object->getActiveSheet()->setCellValue('G1', 'New/OLD');

		$this->data['student'] = $this->getDigitalCitizenship($array);
		$count = 1;
		$excel_row = 2;
		foreach ($this->data['student']  as $student) {
			$object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $student['Student_Number']);
			$object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $student['Last_Name']);
			$object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $student['First_Name']);
			$object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $student['Middle_Name']);
			$object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $student['YearLevel']);
			$object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $student['Course']);
			$object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, 'New');
			$excel_row++;
			$count = $count + 1;
		}

		$object_writer =  new \PhpOffice\PhpSpreadsheet\Writer\Xls($object);
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="digital_citizenship.xls"');
		$object_writer->save('php://output');
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
		$array = array(
			'date_today' => date("Y-m-d"),
			'inquiry_from' => $this->input->post('inquiry_from'),
			'inquiry_to' => $this->input->post('inquiry_to'),
			'identity_no' => $this->input->post('identity_no'),
			'search' => 0,
		);
		// echo $this->input->post('search_button');
		// die($this->input->post('search_button'));
		if(!empty($this->input->post('search_button'))){
			$array['search'] = 1;
		}
		// $this->data['student'] = $this->getIdApplication($array);
		// die(json_encode($this->data['student']));
		if (!empty($this->input->post('export')))
			$this->data['student'] = $this->idExcel($array);
		else
			$this->data['student'] = $this->getIdApplication($array);

		// die(json_encode($this->data['student']));
		$this->render($this->set_views->id_application());
	}
	public function getIdApplication($array)
	{
		$getIdApplication = $this->Forms_Model->getIdApplication($array);
		return $getIdApplication;
		// echo json_encode($getIdApplication);
	}
	public function idExcel($array)
	{
		$object = new Spreadsheet();
		$object->setActiveSheetIndex(0);

		$object->getActiveSheet()->setCellValue('A1', 'Student Number');
		$object->getActiveSheet()->setCellValue('B1', 'LRN');
		$object->getActiveSheet()->setCellValue('C1', 'Last Name');
		$object->getActiveSheet()->setCellValue('D1', 'First Name');
		$object->getActiveSheet()->setCellValue('E1', 'Middle Name');
		$object->getActiveSheet()->setCellValue('F1', 'COURSE');
		$object->getActiveSheet()->setCellValue('G1', 'Guardian');
		$object->getActiveSheet()->setCellValue('H1', 'Guardian Address');
		$object->getActiveSheet()->setCellValue('I1', 'Guardian Contact Details');
		$object->getActiveSheet()->setCellValue('J1', 'New/Old');

		$this->data['student'] = $this->getIdApplication($array);
		$count = 1;
		$excel_row = 2;
		foreach ($this->data['student']  as $student) {
			$object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $student['Student_Number']);
			$object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, "");
			$object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $student['Last_Name']);
			$object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $student['First_Name']);
			$object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $student['Middle_Name']);
			$object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $student['Course']);
			$object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $student['Guardian_Name']);
			$object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, $student['Guardian_Address']);
			$object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, $student['Guardian_Contact']);
			$object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, 'New');
			$excel_row++;
			$count = $count + 1;
		}

		$object_writer =  new \PhpOffice\PhpSpreadsheet\Writer\Xls($object);
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="id_application.xls"');
		$object_writer->save('php://output');
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
			} else {
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
