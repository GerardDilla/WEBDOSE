<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DoseAdmin extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Digital_ID_Model/Forms_Model');
        $this->load->library('set_views');
        $this->load->library('session');
        $this->load->library('set_custom_session');

        
        $this->load->model('DoseAdmin_Model/Model_Enrollment','model_enrollment');
        $this->load->model('DoseAdmin_Model/Model_Reservation','model_reservation');
        $this->load->model('DoseAdmin_Model/Model_Program_List','model_program_list');
        $this->load->model('DoseAdmin_Model/Model_Checker','model_checker');
        $this->load->model('DoseAdmin_Model/Model_Others','model_others');
        $this->load->model('DoseAdmin_Model/Model_Transaction_Logs','model_transaction_logs');
        $this->fullname = $this->session->userdata('logged_in')['fullname'];
        $this->username = $this->session->userdata('logged_in')['username'];
        $this->payment_location = '1'; // SDCA location
    }
    public function index()
    {
        $this->render($this->set_views->test_test());
    }
    function main()
    {

        // $this->load->view("adminpage_head");

        //Documents checkbox field(highered)
        
        $data['highered_documents'] = $this->model_reservation->highered_document_list();

        $data['attendant'] = $this->fullname;
        $data['username'] = $this->username;
        $data['payment_location'] = $this->payment_location;
        //load priority list in db
        $data['priority_list'] = $this->priority_list();
        //load bank list in db
        $data['bank_list'] = $this->bank_list();
        //to insert voucher, and payslip
        if (($this->input->post('bank_name') && $this->input->post('depositslip_no') && $this->input->post('depositslip_amount') && $this->input->post('depositslip_date'))) {


            //for deposit slip
            if ($this->input->post('bank_name') && $this->input->post('depositslip_no') && $this->input->post('depositslip_amount') && $this->input->post('depositslip_date')) {
                $data['bank_name'] = $this->input->post('bank_name');
                $data['depositslip_no'] = $this->input->post('depositslip_no');
                $data['depositslip_amount'] = $this->input->post('depositslip_amount');
                $data['depositslip_date'] = $this->input->post('depositslip_date');

                $data['alert'] = $this->insert_deposit_slip($data['bank_name'], $data['depositslip_no'], $data['depositslip_amount'], $data['depositslip_date']);
            }
        } // end of main if of voucher , slip
        else {
            $data['alert'] = '';
        }



        ////////////////////////////////////////////////////////////////
        //for other information UPDATE
        if ($this->input->post('reference_no') && $this->input->post('student_type') && $this->input->post('other_information') && $this->input->post('this_information')) {
            // die('test');
            $data['reference_no'] = $this->input->post('reference_no');
            $data['student_type'] = $this->input->post('student_type');
            $data['other_information'] = $this->input->post('other_information');
            $data['this_information'] = $this->input->post('this_information');

            //for insert exam
            if ($data['other_information'] == 'exam') {
                $this->insert_exam_info($data['reference_no'], $data['student_type'], $data['other_information'], $data['this_information']);
            }

            if ($data['other_information'] == 'priority') {
                $this->insert_priority_info($data['reference_no'], $data['student_type'], $data['other_information'], $data['this_information']);
            }
            if ($data['other_information'] == 'strand') {
                $data['strand'] = $this->session->userdata('strand');
                $this->update_seniorhigh_strand($data['reference_no'], $data['student_type'], $data['this_information'], $data['strand']);
            }

            $data['strand'] = $this->session->userdata('strand');
            $data['track'] = $this->input->post('Track');

            // insert transaction logs
            $data['transaction_id'] = $this->transaction_log($data['reference_no'], $data['other_information'], 1, $data['student_type'], $data['username']);
        }
        

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // for reservation payment
        if ($this->input->post('full_name') && $this->input->post('reservation_payment')  && $this->input->post('reference_no') && $this->input->post('student_type') && $data['payment_location']) {
            $data['student_type'] = $this->input->post('student_type');
            $data['reservation_payment'] = $this->input->post('reservation_payment');
            $data['reference_no'] = $this->input->get('select_value');
            // die($data['student_type']);
            $data['checker'] = $this->check_reserved($data['reference_no'], $data['student_type']);
            // die(json_encode($data['checker']['counted_row']));
            // die($data['reference_no']);
            if ($data['checker']['counted_row'] == 0) // check if reserved
            {
                // die('test');

                $this->reserve($data['reservation_payment'], $data['reference_no'], $data['student_type']);
                // insert transaction logs
                $data['transaction_id'] = $this->transaction_log($data['reference_no'], 'RESERVATION', 1, $data['student_type'], $data['username']);
                $this->update_reserve($data['reference_no'], $data['student_type']);

                //check payment location
                if ($data['payment_location'] != 1) {
                    $data['acknowledgement_number'] = $this->insert_acknowledge($data['reference_no'], $data['reservation_payment'], 'CASH', 'RESERVATION', $data['username'], $data['payment_location'], '1', $data['student_type']);
                } else {
                    $data['acknowledgement_number'] = "";
                }
            } else {
                $data['acknowledgement_number'] = "N/A";
            }
            // die($data['acknowledgement_number']);

            /// pay with cash 
            $data['print_page'] = $this->print_receipt($data['reference_no'], $data['reservation_payment'], $data['student_type']);
            $this->load->view($this->set_views->adminpage_resprint(),$data);
            // $this->render_with_data($this->set_views->adminpage_resprint(),$data);

            //$this->load->view('formpage_print');
        } else {
            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            // for selection
            //edit
            if (($this->input->get('select_value') && $this->input->get('search_value') && $this->input->get('student_type') && $this->input->get('search_filter')) || ($this->input->get('search_value') && $this->input->get('student_type') && $this->input->get('search_filter'))) {
                $data['student_type'] = $this->input->get('student_type');
                $data['output_select'] = '';
                $data['select_value'] = '';
                //if input click here
                if ($this->input->get('select_value') && $this->input->get('search_value') && $this->input->get('student_type') && $this->input->get('search_filter')) {
                    //check if the reference number is available

                    $data['checker_input'] = $this->input->get('select_value');
                    $data['check_result'] = $this->reference_no_checker($data['checker_input'], $data['student_type']);
                    if ($data['check_result'] == '1') {
                        $data['select_value'] = $this->input->get('select_value'); // reference_number
                        $data['output_select'] = $this->get_value($data['select_value'], $data['student_type']); //full name 
                    }
                }

                ////////////form for update strand will appear
                if (($this->input->get('select_value')) && ($this->input->get('student_type') == 'seniorhigh') && $this->input->get('search_filter')) {
                    $data['track_strand_form'] = $this->seniorhigh_track_strand_form();
                    $data['div_style'] = "";
                } else {
                    $data['track_strand_form'] = " ";
                    $data['div_style'] = "display: none;";
                }

                ///////////////////////////////////////

                // for search
                if ($this->input->get('search_value') && $this->input->get('student_type') && $this->input->get('search_filter')) {
                    //insert function search
                    $data['output_search'] = $this->search();
                }
            } else {
                $data['select_value'] = '';
                $data['output_search'] = '';
                $data['output_select'] = '';
            }
            $data['grade_level_output'] = $this->grade_level('');
            $data['select_school_year'] = $this->select_school_year();
            $data['form_url_enrollment'] = 'DoseEnrollment/Main'; //link for submit for enrollment
            $data['program_list_output'] = $this->course_list(); // print list of programs
            // $data['test'] = 'testing';
            $data['js_ajax'] = $this->load->view($this->set_views->admin_dose_js_ajax());
            $this->render_with_data($this->set_views->admin_dose_body(),$data);
        } // end of if($this->input->get('select_value') && $this->input->post('reservation_payment'))
        // $this->load->view('js_ajax');

        // $this->load->view("adminpage_footer");
    } // end of function main

    // function login()
    // {
    //     $data['username'] = $this->input->post('Username');
    //     $data['password'] = $this->input->post('Password');
    //     $data['payment_loc'] = $this->input->post('Payment_location');
    //     $this->load->model('model_account');
    //     $this->model_account->login($data['username'], $data['password'], $data['payment_loc']);
    // } 
    // end of Function login

    function search()
    {
        $data['student_type'] = $this->input->get('student_type');
        //$data['search_type'] = $this->input->get('search_type');
        $data['page'] = $this->input->get('page');
        $data['search_value'] = $this->input->get('search_value');
        $data['search_filter'] = $this->input->get('search_filter');
        $data['form_url'] = "DoseAdmin/main";
        //$data['get_name_search_type'] = 'search_type';
        $data['get_name_search_value'] = 'search_value';
        // $this->load->model('model_reservation');
        $data['output_search'] = $this->model_reservation->search($data['search_value'], $data['search_filter'], $data['form_url'], $data['get_name_search_value'], $data['page'], $data['student_type']);
        return $data['output_search'];
    } // end of function search

    function get_value($select_value, $student_type)
    {
        //$data['select_value'] = $this->input->get('select_value');
        // $this->load->model('model_reservation');
        $data['output_select'] = $this->model_reservation->query_select($select_value, $student_type);
        return $data['output_select'];
    }

    function reserve($reservation_payment, $reference_no, $student_type)
    {
        // $this->load->model('model_reservation');
        //$this->model_reservation->reserve($reservation_payment, $reference_no, $student_type);	
        //insert to enrolled student payment
        // $this->load->model('model_enrollment');
        $this->model_enrollment->cash_payment($reference_no, $reservation_payment, 'NULL', 'RESERVATION', 'CASH', $student_type);
    }

    function print_receipt($reference_no, $payment, $student_type)
    {
        // $this->load->model('model_reservation');
        $data['output'] = $this->model_reservation->print_receipt($reference_no, $payment, $student_type);
        return $data['output'];
    }
    function update_reserve($reference_no, $student_type)
    {
        // $this->load->model('model_reservation');
        $this->model_reservation->update_reserve($reference_no, $student_type);
    }

    function reference_no_checker($reference_number, $student_type)
    {
        // $this->load->model('model_reservation');
        $data['output'] = $this->model_reservation->reference_no_checker($reference_number, $student_type);
        return $data['output'];
    }

    function course_list()
    {
        // $this->load->model('model_program_list');
        $data['program_list_output'] = $this->model_program_list->program_list();
        return $data['program_list_output'];
    } // end of course_list


    function transaction_log($reference_no, $Transaction_Detail, $view, $student_type, $attendant)
    {
        // $this->load->model('model_transaction_logs');
        $transaction_id = $this->model_transaction_logs->insert_transaction_log($reference_no, $Transaction_Detail, $view, $student_type, $attendant);
        return $transaction_id;
    } // end of function transaction

    function check_reserved($reference_number, $student_type)
    {
        // $this->load->model('model_checker');
        $result = $this->model_checker->check_reserved($reference_number, $student_type);
        return $result;
    }

    function bank_list()
    {
        // $this->load->model('model_reservation');
        $output = $this->model_reservation->bank_list();
        return $output;
    }

    function insert_deposit_slip($bank_name, $depositslip_no, $depositslip_amount, $depositslip_date)
    {
        // $this->load->model('model_reservation');
        $output = $this->model_reservation->insert_deposit_slip($bank_name, $depositslip_no, $depositslip_amount, $depositslip_date);
        return $output;
    }

    function grade_level($condition)
    {
        // $this->load->model('model_program_list');
        $output = $this->model_program_list->grade_level($condition);
        return $output;
    }

    function select_school_year()
    {
        // $this->load->model('model_others');
        $output = $this->model_others->select_school_year();
        return $output;
    }

    function insert_exam_info($reference_number, $student_type, $other_info, $this_info)
    {
        // $this->load->model('model_reservation');
        $this->model_reservation->insert_exam_info($reference_number, $student_type, $other_info, $this_info);
    }

    function insert_priority_info($reference_number, $student_type, $other_info, $this_info)
    {
        // $this->load->model('model_reservation');
        $this->model_reservation->insert_priority_info($reference_number, $student_type, $other_info, $this_info);
    }

    function update_seniorhigh_strand($reference_number, $student_type, $track, $strand)
    {
        // $this->load->model('model_reservation');
        $this->model_reservation->update_seniorhigh_strand($reference_number, $student_type, $track, $strand);
    }

    function priority_list()
    {
        // $this->load->model('model_program_list');
        $output = $this->model_program_list->get_priority_list();
        return $output;
    } // end of priotiy list

    function seniorhigh_track_strand_form()
    {
        // $this->load->model('model_reservation');
        $output = $this->model_reservation->seniorhigh_track_strand_form();
        return $output;
    }

    function payment_loc_list()
    {
        // $this->load->model('model_others');
        $output = $this->model_others->payment_loc_list();
        return $output;
    }

    function insert_acknowledge($reference_number, $payment_amount, $transaction_type, $transaction_item, $transaction_attendant, $payment_location, $valid, $student_type)
    {
        $this->load->model('model_acknowledgement');
        $output = $this->model_acknowledgement->insert_acknowledge($reference_number, $payment_amount, $transaction_type, $transaction_item,  $transaction_attendant, $payment_location, $valid, $student_type);

        return $output;
    }

    public function ajax_basiced_fees_checker()
    {
        if (!$this->input->get('schoolYear') && !$this->input->get('gradeLevel')) {
            # code...
            $output["checker"] = 0;
            $output["message"] = "incomplete data";
            // die(json_encode($output));
            echo json_encode($output);
            return;
        }

        $basiced_fees = $this->model_enrollment->check_basiced_fees($this->input->get('gradeLevel'), $this->input->get('schoolYear'));

        if (!$basiced_fees) {
            # code...
            $output["checker"] = 0;
            $output["message"] = "Fees not available. Please contact Accounting office.";
            echo json_encode($output);
            return;
        }

        $output["checker"] = 1;
        $output["message"] = "";
        echo json_encode($output);
        return;
    }

    public function ajax_shs_fees_checker()
    {
        if (!$this->input->get('schoolYear') && !$this->input->get('gradeLevel') && !$this->input->get('shsTrack') && !$this->input->get('shsStrand')) {
            # code...
            $output["checker"] = 0;
            $output["message"] = "incomplete data";
            echo json_encode($output);
            return;
        }
        #shs fees checker 
        $shs_fees = $this->model_enrollment->basiced_fees_listing_checker(
            $this->input->get('shsTrack'),
            $this->input->get('shsStrand'),
            $this->input->get('gradeLevel'),
            $this->input->get('schoolYear')
        );

        if ($shs_fees < 1) {
            # code...
            $output["checker"] = 0;
            $output["message"] = "Fees not available. Please contact Accounting office.";
            echo json_encode($output);
            return;
        }
        $output["checker"] = 1;
        $output["message"] = "";
        echo json_encode($output);
        // return;
    }
    function seniorhigh_strand()
	{
		if ($this->input->get('track')) {
			$track = $this->input->get('track');

			// $this->load->model('model_program_list');
			$output = $this->model_program_list->seniorhigh_strand($track);

			echo $output;
		}
	}
    function ajax_seniorhigh_track()
	{
		if ($this->input->get('grade_level')) {
			$grade_level = $this->input->get('grade_level');

			//check if the input is g11 or g12
			if (($grade_level == "G11") || ($grade_level == "G12")) {
				// $this->load->model('model_program_list');
				$output = $this->model_program_list->ajax_seniorhigh_track($grade_level);
			} else {
				$output = "";
			}

			echo $output;
		}
	}
    function save_strand()
	{
		if ($this->input->get('strand_code')) {
			$value = 'strand';
			$strand_code = $this->input->get('strand_code');

			$this->load->model('model_session');

			$this->model_session->unset_sess($value);

			$this->model_session->set_sess($value, $strand_code);

			//echo $this->session->userdata($major_num).$major_num.$major_id;
		}
	}
    // insert the course major to session
	function save_major()
	{
		if ($this->input->get('major_id') && $this->input->get('major_num')) {
			$major_id = $this->input->get('major_id');
			$major_num = $this->input->get('major_num');

			$this->load->model('model_session');

			//$this->model_session->unset_sess($major_num);
			$this->model_session->unset_sess($major_id);

			//$this->model_session->set_sess($major_num, $major_id);
			$this->model_session->set_sess($major_id, $major_num);
			//echo $this->session->userdata($major_num).$major_num.$major_id;
		}
	}
    function address()
	{
		$this->load->model('model_address');
		if ($this->input->get('type') && $this->input->get('value')) {
			$type = $this->input->get('type');
			$value = $this->input->get('value');

			//Gerard 1-24-20
			$option_only = $this->input->get('option_only');



			$output = $this->model_address->address_condition($type, $value, $option_only);

			print $output;
		} // end of main if
	}
    //foreign form
	function foreign_form()
	{
		if ($this->input->get('type')) {
			$type = $this->input->get('type');

			if ($type != "FILIPINO") {
				$this->load->model('model_others');
				$output = $this->model_others->foreign_form();

				print $output;
			} else {
				print "";
			}
		}
	}
}
