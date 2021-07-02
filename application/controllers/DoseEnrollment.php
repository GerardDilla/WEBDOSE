<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class DoseEnrollment extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Digital_ID_Model/Forms_Model');
		$this->load->library('set_views');
		$this->load->library('session');
		$this->load->library('set_custom_session');

		$this->load->model('DoseAdmin_Model/Model_Reservation', 'model_reservation');
		$this->load->model('DoseAdmin_Model/Model_Program_List', 'model_program_list');
		$this->load->model('DoseAdmin_Model/Model_Others', 'model_others');
		$this->load->model('DoseAdmin_Model/Model_Session','model_session');
		$this->load->model('DoseAdmin_Model/Model_Enrollment','model_enrollment');
		$this->load->model('DoseAdmin_Model/Model_Transaction_Logs','model_transaction_logs');
		$this->load->model('DoseAdmin_Model/Model_Acknowledgement','model_acknowledgement');
		
	}

	public function index()
	{
		// $this->load->view('body/DoseAdmin/Basiced_Regprint');
		// if ($this->session->userdata('username') == TRUE) {
		// 	$this->main();
		// } else {
		// 	redirect('/DoseAdmin');
		// }
	}
	// end of function index



	function main()
	{
		// $this->load->view("adminpage_head");


		//load bank list in db
		$data['bank_list'] = $this->bank_list();

		if (($this->input->post('program_code') && $this->input->post('reference_number') && $this->input->post('client_name') && $this->input->post('student_type')) || (($this->session->userdata('reference_number') == TRUE) && ($this->session->userdata('program_code') == TRUE) && ($this->session->userdata('client_name') == TRUE) && ($this->session->userdata('student_type') == TRUE))) {
			$data['payment_location'] = $this->session->userdata('payment_location');
			$data['encoder'] = $this->session->userdata('user_fullname');
			$data['username'] = $this->session->userdata('username');

			if ($this->input->post('program_code') && $this->input->post('reference_number') && $this->input->post('client_name') && $this->input->post('student_type')) {
				$data['reference_number'] = $this->input->post('reference_number');
				$data['program_code'] = $this->input->post('program_code');
				$data['client_name'] = $this->input->post('client_name');
				$data['student_type'] = $this->input->post('student_type');
				// die($this->input->post('school_year'));
				//set the session
				if ($this->input->post('school_year')) {
					$data['school_year'] = $this->input->post('school_year');
					$this->set_sess('school_year', $data['school_year']);
				}

				if ($this->input->post('major_check')) {

					$data['program_major'] = $this->input->post('major1');

					if (($data['program_major'] == 0)) {
						$data['program_major'] = "0";
						$this->set_sess('major_check', '1');
					}

					$this->set_sess('program_major', $data['program_major']);
				}

				if (($this->input->post('track')) && ($this->input->post('strand'))) {
					$data['track'] = $this->input->post('track');
					$data['strand'] = $this->input->post('strand');

					$this->set_sess('track', $data['track']);
					$this->set_sess('strand', $data['strand']);
				} else {
					$data['track'] = 0;
					$data['strand'] = 'N/A';

					$this->set_sess('track', $data['track']);
					$this->set_sess('strand', $data['strand']);
				}

				/*
				if( ($this->input->post('program_code') != "G11") || ($this->input->post('program_code') != "G12") )
				{
					$data['track'] = 0;
					$data['strand'] = 'N/A';
					
					$this->set_sess('track', $data['track']);
					$this->set_sess('strand', $data['strand']);
				}
				*/
				//set the session
				$this->set_reference_number_session($data['reference_number'], $data['program_code'], $data['client_name'], $data['student_type']);
			}


			//if the user accidentally refresh the page	
			if (($this->session->userdata('reference_number') == TRUE) && ($this->session->userdata('program_code') == TRUE) && ($this->session->userdata('client_name') == TRUE) && ($this->session->userdata('student_type') == TRUE)) {
				$data['reference_number'] = $this->session->userdata('reference_number');
				$data['program_code'] = $this->session->userdata('program_code');
				$data['client_name'] = $this->session->userdata('client_name');
				$data['student_type'] = $this->session->userdata('student_type');

				if (($this->session->userdata('school_year') == TRUE)) {
					$data['school_year'] = $this->session->userdata('school_year');
				}

				if (($this->session->userdata('program_major') == TRUE) || ($this->session->userdata('major_check') == TRUE)) {

					$data['program_major'] = $this->session->userdata('program_major');
				}

				if (($this->session->userdata('track') == TRUE) && ($this->session->userdata('strand') == TRUE)) {
					$data['track'] = $this->session->userdata('track');
					$data['strand'] = $this->session->userdata('strand');
				} else {
					$data['track'] = $this->session->userdata('track');
					$data['strand'] = $this->session->userdata('strand');
				}
			} // end of session checker
			//insert document 	
			if ($this->input->post('document')) {
				$data['document'] = $this->input->post('document');
				$this->store_documents($data['document'], $data['reference_number'], $data['username']);
			}

			//$data['output_client_info'] = $this->client_info($data['reference_number']);



			// get data(schedule, subject)
			// for highered
			if ($data['student_type'] == 'highered') {
				$data['button_view_regform'] = '.bs-example-modal-regform';
				// condition if plan is available
				if ($this->input->get('plan_highered') != "") {
					$data['plan_highered'] = $this->input->get('plan_highered');
				} else {
					$data['plan_highered'] = "";
				}

				if ($this->input->get('highered_curriculum') != "") {
					$data['highered_curriculum'] = $this->input->get('highered_curriculum');
				} else {
					$data['highered_curriculum'] = "";
				}

				$data['output'] = $this->view_regform($data['program_code'], $data['program_major'], 'view', $data['reference_number'], $data['client_name'], $data['plan_highered'], $data['highered_curriculum']);
			}
			// for basiced
			else {

				$data['button_view_regform'] = '.bs-example-modal-regform2';
				// condition if plan is available
				if ($this->input->get('plan') != "") {
					$data['plan'] = $this->input->get('plan');
				} else {
					$data['plan'] = "full_payment";
				}

				//condition if track and strand is available	
				/*
					if( ($this->session->userdata('track') == TRUE) && ($this->session->userdata('strand') == TRUE) )
					{
						$data['output_basiced'] = $this->view_regform_basiced($data['program_code'] , 'view', $data['plan'], $data['reference_number'], $data['client_name'], $data['school_year'], "0", $data['track'], $data['strand']);
					}
					else
					{
						$data['output_basiced'] = $this->view_regform_basiced($data['program_code'] , 'view', $data['plan'], $data['reference_number'], $data['client_name'], $data['school_year'], "0", "", "");
					}
					*/

				$data['output_basiced'] = $this->view_regform_basiced($data['program_code'], 'view', $data['plan'], $data['reference_number'], $data['client_name'], $data['school_year'], "0", $this->session->userdata('track'), $this->session->userdata('strand'));
			}



			//payment method
			if ($this->input->post('payment_cash') || $this->input->post('payment_card')) {
				// data fee type for view regform
				//$data['fee_type'] = 'CASH';
				//$data['student_type'] = $this->input->post('student_type');
				//check if there is student number in student info
				//$data['check_enrolled'] = $this->check_enrolled($data['reference_number'], $data['student_type']);	

				/*
				if($data['check_enrolled'] == '0')
				{
					*/



				//pay using cash
				if ($this->input->post('payment_cash')) {
					$data['payment_cash'] = $this->input->post('payment_cash'); //amount paid
					$data['transaction_type'] = 'CASH';
					$data['fee_type'] = 'CASH';
				}
				if ($this->input->post('payment_card')) {
					$data['payment_cash'] = $this->input->post('payment_card'); //amount paid
					$data['card_number'] = $this->input->post('card_number');
					$data['bank'] = $this->input->post('bank');
					$data['transaction_type'] = 'CARD';
					$data['fee_type'] = 'CARD';
					$this->insert_card_log($data['reference_number'], $data['card_number'], $data['bank']);
				}

				// payment check if higher ed or basiced
				if ($data['student_type'] == 'highered') {
					$data['student_number'] = $this->cash_payment($data['reference_number'], $data['payment_cash'], $data['output'], $data['transaction_type'], $data['student_type']);

					// to insert sched and fees
					$this->insert_sched_fee($data['reference_number'], $data['student_number'], $data['output'], $data['program_code'], $data['program_major'], $data['plan_highered'], $data['highered_curriculum']);
					// INSERT LOGS
					$this->transaction_log($data['reference_number'], 'MATRICULATION', 0, $data['student_type'], $data['username']);
				} else //basic ed
				{
					$student_number = $this->get_studentnumber($data['reference_number'], 'Basiced_Studentinfo');

					//$data['plan'] = $this->input->post('plan');

					$this->cash_payment($data['reference_number'], $data['payment_cash'], $data['output_basiced'], $data['transaction_type'], $data['student_type']);
					// insert basic ed fees
					$this->view_regform_basiced($data['program_code'], 'insert', $data['plan'], $data['reference_number'], $data['client_name'], $data['school_year'], $student_number, $data['track'], $data['strand']);

					$this->update_basiced_stud_info($data['reference_number'], '0', $data['program_code'], $data['output_basiced'], $data['track'], $data['strand']);
					// INSERT LOGS
					$this->transaction_log($data['reference_number'], 'MATRICULATION', 0, $data['student_type'], $data['username']);
				}


				//insert acknowledge
				//check payment location
				if ($data['payment_location'] != 1) {
					$data['acknowledgement_number'] = $this->insert_acknowledge($data['reference_number'], $data['payment_cash'], $data['transaction_type'], 'MATRICULATION', $data['username'], $data['payment_location'], '1', $data['student_type']);
				} else {
					$data['acknowledgement_number'] = "N/A";
				}

				/*
						}// end of if($data['check_enrolled'] == '0')
						else
						{
							$data['student_number'] = $data['check_enrolled'];
							}
							*/

				if ($data['student_type'] == 'highered') {
					$this->load->view('adminpage_regprint', $data);
				} else {
					// $this->load->view('basiced_regprint', $data);
					$this->load->view($this->set_views->basiced_regprint(),$data);
				}
			} else {

				// $this->load->view('adminpage_regbody', $data);
				$this->render_with_data($this->set_views->admin_dose_regbody(),$data);
			}
			//$this->load->view('adminpage_regbody_code');

		} else {
			redirect('/DoseAdmin/main');
		}

		// $this->load->view("adminpage_footer");
	} // end of function main



	function view_regform($program_code, $program_major, $type, $reference_number, $client_name, $plan, $curriculum)
	{
		// $this->load->model('model_enrollment');
		$data['output'] = $this->model_enrollment->view_regform($program_code, $program_major, $type, $reference_number, $client_name, $plan, $curriculum);
		return $data['output'];
	} // end of function enrollment_view()

	function view_regform_basiced($grade_level, $type, $plan, $reference_number, $client_name, $school_year, $student_number, $track, $strand)
	{
		// $this->load->model('model_enrollment');
		$data['output'] = $this->model_enrollment->view_regform_basiced($grade_level, $type, $plan, $reference_number, $client_name, $school_year, $student_number, $track, $strand);
		return $data['output'];
	}


	function set_reference_number_session($reference_number, $program_code, $client_name, $student_type)
	{
		// $this->load->model('model_enrollment');
		$this->model_enrollment->set_reference_number_session($reference_number, $program_code, $client_name, $student_type);
	}

	function store_documents($document, $reference_number, $encoder_username)
	{
		// $this->load->model('model_enrollment');
		$this->model_enrollment->store_documents($document, $reference_number, $encoder_username);
	}

	function cash_payment($reference_number, $payment, $array_output, $transaction_type, $student_type)
	{
		// $this->load->model('model_enrollment');
		$student_number = $this->model_enrollment->cash_payment($reference_number, $payment, $array_output, 'MATRICULATION', $transaction_type, $student_type);
		return $student_number;
	}

	// to insert sched and fees
	function insert_sched_fee($reference_number, $student_number, $output, $program_code, $program_major, $plan, $curriculum)
	{
		// to insert subjects
		// $this->load->model('model_enrollment');
		$array_output = $this->model_enrollment->insert_sched_fee($reference_number, $student_number, $output, $program_code, $program_major);
		// to insert fees
		$this->model_enrollment->insert_enrollment_fee($array_output, $plan);
		// update student information student_number
		$this->model_enrollment->update_student_info($reference_number, $student_number, $program_code, $program_major, $output, $curriculum);
		//update slots
		//$this->model_enrollment->update_slots($output);	



	} // end of function insert_sched_fee

	function update_basiced_stud_info($reference_number, $student_number, $grade_level, $output, $track, $strand)
	{
		// $this->load->model('model_enrollment');
		$this->model_enrollment->update_basiced_stud_info($reference_number, $student_number, $grade_level, $output, $track, $strand);
	}

	function check_enrolled($reference_number, $student_type)
	{
		$this->load->model('model_checker');
		$result = $this->model_checker->check_enrolled($reference_number, $student_type);
		return $result;
	}

	function client_information($array_output, $client_name, $reference_number, $program_code, $student_type)
	{
	}

	function transaction_log($reference_no, $Transaction_Detail, $view, $student_type, $attendant)
	{
		// $this->load->model('model_transaction_logs');
		$transaction_id = $this->model_transaction_logs->insert_transaction_log($reference_no, $Transaction_Detail, $view, $student_type, $attendant);
		return $transaction_id;
	} // end of function transaction

	function insert_card_log($reference_number, $card_number, $bank)
	{
		// $this->load->model('model_enrollment');
		$this->model_enrollment->insert_card_log($reference_number, $card_number, $bank);
	}

	function bank_list()
	{
		// $this->load->model('model_reservation');
		$output = $this->model_reservation->bank_list();
		return $output;
	}

	function set_sess($name, $value)
	{
		// $this->load->model('model_session');
		$this->model_session->set_sess($name, $value);
	}

	function get_studentnumber($reference_number, $table)
	{
		// $this->load->model('model_enrollment');
		$output = $this->model_enrollment->get_studentnumber($reference_number, $table);

		return $output;
	}

	function insert_acknowledge($reference_number, $payment_amount, $transaction_type, $transaction_item, $transaction_attendant, $payment_location, $valid, $student_type)
	{
		$this->load->model('model_acknowledgement');
		$output = $this->model_acknowledgement->insert_acknowledge($reference_number, $payment_amount, $transaction_type, $transaction_item,  $transaction_attendant, $payment_location, $valid, $student_type);

		return $output;
	}
}//end of class
