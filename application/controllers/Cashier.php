<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Cashier extends MY_Controller  {

    public function __construct() 
    {
        parent::__construct();
        $this->load->library('set_views');
        $this->load->library('Online_Cashier/student_data');
        $this->load->library('session');
        $this->load->library("DateConverter");
        $this->load->helper(array('form', 'url', 'date'));

        $this->load->library('form_validation');
        
        $this->load->model('Global_Model/Global_Student_Model');
        $this->load->model('Global_Model/Global_Fees_Model');
        $this->load->model('Cashier_Model/Student_Model');
        $this->load->model('Cashier_Model/Fees_Model');
        $this->load->model('Cashier_Model/Logs_Model');

        //check if user is logged on
        $this->load->library('set_custom_session');
        $this->admin_data = $this->set_custom_session->admin_session();

        //user accessibility
        $this->load->library('User_accessibility');
        $this->user_accessibility->module_cashier_access($this->admin_data['userid']);
        
        //set date
        $datestring = "%Y-%m-%d %h:%i";
        $yearstring = "%Y";
        $time = time();
        $this->date_time = mdate($datestring, $time);
        $this->date_year = mdate($yearstring, $time);

        //set logs
        $this->array_logs = array(
            'user_id' => $this->admin_data['userid'], 
            'date' => $this->date_time,
        );


    }

    public function index( $reference_no ="", $semester = "", $school_year = "")
    {
        if ($reference_no && $semester && $school_year) 
        {
            # code...
            if (!is_numeric($reference_no)) 
            {
                # code...
                redirect('Cashier');
            }
            $this->student_data->set_reference_no($reference_no);
            $this->student_data->set_school_year($school_year);
            $this->student_data->set_semester($semester);
            
            $this->data['semester'] = $this->student_data->get_semester();
            $this->data['school_year'] = $this->student_data->get_school_year();
            //to update
            $this->data['student_info'] = $this->Student_Model->get_info_academic_by_ref_no($reference_no);
            
            if (!$this->data['student_info']) 
            {
                # code...
                $this->session->set_flashdata('message_error','Data not found.');
                redirect('Cashier');
            }
            
            #set student number param
            if ($this->data['student_info'][0]['Student_Number'] > 0) {
                # code...
                $this->student_data->set_student_no($this->data['student_info'][0]['Student_Number']);
            }

            $array_data = array(
                'reference_no' => $this->data['student_info'][0]['Reference_Number'],
                'semester' => $semester,
                'schoolyear' => $school_year
            );

            #get student Enrolled Fess
            $this->data['fees_enrolled'] = $this->Global_Fees_Model->get_enrolled_fees($array_data);
            if ($this->data['fees_enrolled']) 
            {
                # code...
                 #get student total payment from throughput table
                $this->data['total_payment'] = $this->Fees_Model->get_student_total_payment($array_data);
                #total tuition
                $this->data['total_tuition_fee'] = $this->data['fees_enrolled'][0]['InitialPayment'] + $this->data['fees_enrolled'][0]['First_Pay']+ $this->data['fees_enrolled'][0]['Second_Pay'] + $this->data['fees_enrolled'][0]['Third_Pay'];
                echo $this->data['total_tuition_fee'];
                #remaining balance
                $this->data['balance'] = $this->data['total_tuition_fee'] - $this->data['total_payment'][0]['total_payment'];
            }

            #get result for balance checker
            /*
                @params array keys
                'error'= 1 if there is an error
                'message' = message to be displayed 
                'payment_approval' = 1 if fees can be paid
            */
            $this->data['array_balance_checker'] = $this->hed_check_payment_approval();
            
            if ($this->data['array_balance_checker']['message']) {
                # code...
                $this->session->set_flashdata('message_error', $this->data['array_balance_checker']['message']);
            }

            #get list of unapplied reservation payments
            $this->data['reservation_payments_to_apply'] = $this->Fees_Model->get_to_apply_hed_reservations();

            #get list of payments
            $this->data['payments_list'] = $this->Fees_Model->get_hed_payments();
            
            
        }
        elseif ($this->input->post("stud_ref_number") && $this->input->post("semester") && $this->input->post("school_year")) 
        {
            # code...
            $semester = $this->input->post("semester");
            $school_year = $this->input->post("school_year");

            //check by student number
            $this->data['student_info'] = $this->Student_Model->get_info_academic_by_stud_no($this->input->post("stud_ref_number"));

            if (!$this->data['student_info']) 
            {
                # code...
                //check by reference
                $this->data['student_info'] = $this->Student_Model->get_info_academic_by_ref_no($this->input->post("stud_ref_number"));
                
                if (!$this->data['student_info']) 
                {
                    $this->session->set_flashdata('message_error','Data not found.');
                    redirect('Cashier');
                }

                redirect('Cashier/index/'.$this->data['student_info'][0]['Reference_Number'].'/'.$this->input->post("semester").'/'.$this->input->post("school_year"));
                
            }
        }
        else 
        {
            # code...
            $this->render($this->set_views->enrollment_payment());
            return;
        }



        

        

        $this->render($this->set_views->enrollment_payment());
    }

    public function hed_check_payment_approval()
    {
        $array_output = array(
            'error' => 0,
            'message' => "",
            'payment_approval' => 0
        );
        if (!$this->student_data->get_reference_no()) {
            # code...
            $array_output['error'] = 1;
            $array_output['message'] = "No available Reference Number";
            return $array_output;
        }

        if (!$this->student_data->get_student_no()) {
            # new student
            $array_output['payment_approval'] = 1;
            return $array_output;
        }

        #check selected school_year and semester if the accounting approved
        $payment_approval_checker = $this->Fees_Model->check_hed_payment_approval();
        if ($payment_approval_checker) {
            # code...
            $array_output['payment_approval'] = 1;
            return $array_output;
        }
        
        #get balance list
        $balance = $this->Fees_Model->get_hed_remaining_balance();

        if (!$balance) {
            # code...
            $array_output['message'] = "Please advise the student first.";
            $array_output['payment_approval'] = 1;
            return $array_output;
        }

        foreach ($balance as $key => $value) {
            # code...
            if (($value['semester'] === $this->student_data->get_semester()) && ($value['schoolyear'] === $this->student_data->get_school_year())) {
                # code...
                $array_output['payment_approval'] = 1;
                return $array_output;
            }
            if ($value['BALANCE'] > 0) {
                # code...
                $array_output['message'] = 'There is remaining balance on '.$value['semester'].' SEMESTER, AY '.$value['schoolyear'].'.';
                return $array_output;
            }

        }

         
        
    }

    public function hed_reservation()
    {
        if ($this->input->post("reference_no") && $this->input->post("semester") && $this->input->post("school_year") && 
        $this->input->post("amount") && $this->input->post("or_no") && $this->input->post("payment_type")) 
        {
            # code...

            $reference_no = $this->input->post("reference_no");
            $semester = $this->input->post("semester");
            $school_year = $this->input->post("school_year");
            $amount = number_format($this->input->post("amount"), 2, '.', '');
            $or_no = $this->input->post("or_no");
            $payment_type = $this->input->post("payment_type");
            $description = $this->input->post("description");

            if (!is_numeric($reference_no)) 
            {
                # code...
                $this->session->set_flashdata('message_error','Enter correct format for reference number.');
                redirect('Cashier');
            }

            if (!is_numeric($amount)) 
            {
                # code...
                $this->session->set_flashdata('message_error','Use number format for amount.');
                redirect('Cashier');
            }

            #check if OR number have duplicate
            $or_duplication_checker = $this->Fees_Model->check_duplicate_or($or_no);
            $or_duplication_checker_enrollment = $this->Fees_Model->check_duplicate_or_enrollment($or_no);
            if ($or_duplication_checker || $or_duplication_checker_enrollment) 
            {
                # code...
                $this->session->set_flashdata('message_error','OR Number is already in use.');
                redirect('Cashier/index/'.$reference_no.'/'.$semester.'/'.$school_year);
            }
            
            #insert Reservation details
            $array_insert = array(
                "Reference_No" => $reference_no,
                "Semester" => $semester,
                "SchoolYear" => $school_year,
                "Amount" => $amount,
                "Transaction_Item" => "RESERVATION",
                "OR_Number" => $or_no,
                "Payment_Type" => $payment_type,
                "Description" => $description,
                "Append_Cashier" => $this->admin_data['userid'],
                "Append_Date" => $this->date_time,
                "valid" => 1,
                "web_dose_module" => 1
            );

            $transaction_output = $this->Fees_Model->insert_reservation($array_insert);

            #insert logs

            $this->array_logs['reference_number'] = $reference_no;
            $this->array_logs['process'] = "HED Reservation";
            $this->array_logs['transaction_output'] = $transaction_output;
            print_r($this->array_logs);

            $this->Logs_Model->insert_transaction_logs($this->array_logs);

            $this->session->set_flashdata('message_success','Transaction Successful.');
            redirect('Cashier/index/'.$reference_no.'/'.$semester.'/'.$school_year);


        }
        else 
        {
            # code...
            $this->session->set_flashdata('message_error','system error.');
            redirect('Cashier');
            
        }
    }

    public function hed_matriculation_input()
    {
        if (!$this->input->post("reference_no") || !$this->input->post("semester") || !$this->input->post("school_year") || 
        !$this->input->post("amount") || !$this->input->post("or_no") || !$this->input->post("payment_type") || 
        !$this->input->post("transaction_type")) 
        {
            # code...
            $this->hed_error_handler('System error');
        }

        if (!is_numeric($this->input->post("reference_no"))) 
        {
            # code...
            $this->hed_error_handler('Enter correct format for reference number.');
        }

        if (!is_numeric($this->input->post("amount"))) 
        {
            # code...
            $this->hed_error_handler('Use number format for amount.');
            redirect('Cashier');
        }

        #set parameters 
        $this->student_data->set_reference_no($this->input->post("reference_no"));
        $this->student_data->set_semester($this->input->post("semester"));
        $this->student_data->set_school_year($this->input->post("school_year"));
        $this->student_data->set_amount($this->input->post("amount"));
        $this->student_data->set_or_no($this->input->post("or_no"));
        $this->student_data->set_payment_type($this->input->post("payment_type"));
        $this->student_data->set_transaction_type($this->input->post("transaction_type"));

        if ($this->input->post("description")) 
        {
            # code...
            $this->student_data->set_description($this->input->post("description"));
        }

        #check for duplicate or
        $or_duplication_checker = $this->Fees_Model->check_duplicate_or($this->student_data->get_or_no());
        $or_duplication_checker_enrollment = $this->Fees_Model->check_duplicate_or_enrollment($this->student_data->get_or_no());
        if ($or_duplication_checker || $or_duplication_checker_enrollment) 
        {
            # code...
            $this->session->set_flashdata('message_error','OR Number is already in use.');
            redirect('Cashier/index/'.$this->student_data->get_reference_no().'/'.$this->student_data->get_semester().'/'.$this->student_data->get_school_year());
        }

        #inserting payment
        $this->hed_matriculation();

        #check if there is reservation payments to apply
        $this->auto_apply_hed_reservations();

        #insert advised schedule to enrolled subjects
        $this->insert_to_enrolled_schedule();

        $this->session->set_flashdata('message_success','Transaction Successful.');
        redirect('Cashier/index/'.$this->student_data->get_reference_no().'/'.$this->student_data->get_semester().'/'.$this->student_data->get_school_year());
    }

    private function insert_to_enrolled_schedule()
    {
        #check if there is already schedule in enrolled subjects
        $schedule_checker = $this->Student_Model->check_enrolled_subjects();
        if (!$schedule_checker) 
        {
            # code...
            $transaction_output = $this->Student_Model->insert_advised_schedule();

            $this->array_logs['transaction_output'] = $transaction_output;
            $this->Logs_Model->insert_transaction_logs($this->array_logs);
        }

        return;

    }

    private function auto_apply_hed_reservations()
    {
        $reservation_payments = $this->Fees_Model->check_to_apply_hed_reservations();
        if (!$reservation_payments) 
        {
            return;
        }

        # apply reservations to matriculation

        foreach ($reservation_payments as $key => $payment) 
        {
            # set parameters
            $this->student_data->set_amount($payment['Amount']);
            $this->student_data->set_transaction_type($payment['Transaction_Item']);
            $this->student_data->set_or_no($payment['OR_Number']);
            $this->student_data->set_payment_type($payment['Payment_Type']);
            if ($payment['Description']) 
            {
                # code...
                $this->student_data->set_description($payment['Description']);
            }
            else 
            {
                # code...
                $this->student_data->set_description(NULL);
            }

            #insert reservation payment to matriculation
            $this->hed_matriculation();

            #update reservation data
            $array_update = array(
                'Applied' => 1,
                'Applied_Date' => $payment['Append_Date'],
                'Applied_Cashier' => $payment['Append_Cashier']
            );

            $transaction_output = $this->Fees_Model->update_applied_hed_reservation($array_update, $payment['reservation_id']);

            #insert logs
            $this->array_logs['transaction_output'] = $transaction_output;
            $this->Logs_Model->insert_transaction_logs($this->array_logs);

        }
    }

    private function hed_error_handler($message)
    {
        $this->session->set_flashdata('message_error',$message);
        redirect('Cashier');
    }

    private function hed_matriculation()
    {
        $reference_no = $this->student_data->get_reference_no();
        $semester = $this->student_data->get_semester();
        $school_year = $this->student_data->get_school_year();
        $amount = $this->student_data->get_amount();
        $amount_insert = $amount;
        $or_no = $this->student_data->get_or_no();
        $payment_type = $this->student_data->get_payment_type();
        $transaction_type = $this->student_data->get_transaction_type();
        $description = $this->student_data->get_description();

        $student_info = $this->Student_Model->get_info_academic_by_ref_no($reference_no);

        if (!$student_info) 
        {
            # code...
            $this->hed_error_handler('Student data not found.');
            
        }

        #throughput process start
        $array_fees_throughput = array();
        $array_data = array(
            'reference_no' => $reference_no,
            'semester' => $semester,
            'schoolyear' => $school_year
        );

        #set log data
        $this->array_logs['reference_number'] = $reference_no;
        $this->array_logs['process'] = "HED Enrollment";

        #get fees enrolled
        $fees_enrolled = $this->Global_Fees_Model->get_enrolled_fees($array_data);

        #generate student number if student is new
        if ($student_info[0]['Student_Number'] == 0) 
        {
            # code...
            $array_student_number_output = $this->Student_Model->generate_student_number($reference_no);
            $array_data['student_no'] = $array_student_number_output['insert_id'];
            #include in refactoring later
            $this->student_data->set_student_no($array_student_number_output['insert_id']);
            #insert logs
            $this->array_logs['transaction_output'] = $array_student_number_output['message'];
            $this->Logs_Model->insert_transaction_logs($this->array_logs);

            #update student number of student
            $transaction_output = $this->Student_Model->update_student_number($array_data);
            $this->array_logs['transaction_output'] = $transaction_output;
            $this->Logs_Model->insert_transaction_logs($this->array_logs);
        }
        else 
        {
            # code...
            $array_data['student_no'] = $student_info[0]['Student_Number'];
            #include in refactoring later
            $this->student_data->set_student_no($student_info[0]['Student_Number']);
        }
        
        

        #get student Enrolled Fess
        $fees_enrolled = $this->Global_Fees_Model->get_enrolled_fees($array_data);

        #get payment throughput
        $payment_throughput = $this->Fees_Model->get_payment_throughput_list($array_data);
        
        #set array to get enrolled fees item
        $array_fees_item_list = array(
            'fees_enrolled_id' => $fees_enrolled[0]['id']
        );

        if ($payment_throughput) 
        {
            #check if payment is equal to fee amount of item
            if ($payment_throughput[0]['throughput_amount_paid'] != $payment_throughput[0]['item_amount']) 
            {
                # code...
                $array_throughput_data = $array_data;
                $array_throughput_data['item_id'] = $payment_throughput[0]['throughput_item_id'];

                $throughput_item_paid = $this->Fees_Model->check_throughput_item_total_paid($array_throughput_data);

                #check if payment is equal to fee amount of item
                if ($payment_throughput[0]['item_amount'] != $throughput_item_paid[0]['total_payment']) 
                {
                    #check if fees amount is higher than payment
                    if (($payment_throughput[0]['item_amount'] - $throughput_item_paid[0]['total_payment']) > $amount) 
                    {
                        # inssuficient payment
                        $payment_amount = $amount;
                    }
                    else
                    {
                        $payment_amount = $payment_throughput[0]['item_amount'] - $throughput_item_paid[0]['total_payment'];
                    }
                    # add payment to array
                    $array_fees_throughput[] = array(
                        'Reference_Number' => $reference_no,
                        'AmountofPayment' => $payment_amount,
                        'OR_Number' => $or_no,
                        'itemPaid' => $payment_throughput[0]['item_name'],
                        'Fees_Enrolled_College_Item_id' => $payment_throughput[0]['item_id'],
                        'Transaction_Item' => $transaction_type,
                        'transDate' => $this->date_time,
                        'Transaction_Type' => $payment_type,
                        'description' => $description,
                        'Semester' => $semester,
                        'SchoolYear' => $school_year,
                        'cashier' => $this->admin_data['userid'],
                        'web_dose_module' => 1
                    );
                   
                    $amount = number_format($amount - ($payment_throughput[0]['item_amount'] - $throughput_item_paid[0]['total_payment']), 2, '.', '');
                }
            }

            #get unpaid fees item
            $array_item_id = array();
            foreach ($payment_throughput as $key => $value) 
            {
                # code...
                $array_item_id[] = $value['item_id'];
                
            }
            
            $array_fees_item_list['array_item_id'] = $array_item_id;
            #get unpaid fees
            $array_unpaid_fees = $this->Fees_Model->get_unpaid_fees_item($array_fees_item_list);
        }
        else 
        {
            #get unpaid fees
            $array_unpaid_fees = $this->Fees_Model->get_fees_item($array_fees_item_list);
        }
        #get total paid tuition fee
        $paid_tuition_fee = $this->Fees_Model->get_paid_tuition_fee($array_data);
        if ($paid_tuition_fee) 
        {
            #add tuition array to array unpaid fees
            $array_unpaid_fees[] = array(
                'Fees_Name' => 'Tuition',
                'Fees_Amount' => ($fees_enrolled[0]['tuition_Fee'] - $paid_tuition_fee[0]['total_payment']),
                'item_id' => 0
            );
        }
        else
        {
                #add tuition array to array unpaid fees
            $array_unpaid_fees[] = array(
                'Fees_Name' => 'Tuition',
                'Fees_Amount' => $fees_enrolled[0]['tuition_Fee'],
                'item_id' => 0
            );
        }
        

                    
        #allocate payment to fee items
        foreach ($array_unpaid_fees as $key => $fees) 
        {
            # code...
            if ($amount > 0) 
            {
                # code...
                if ($amount >= $fees['Fees_Amount']) 
                {
                    # add payment to array
                    $array_fees_throughput[] = array(
                        'Reference_Number' => $reference_no,
                        'AmountofPayment' => $fees['Fees_Amount'],
                        'OR_Number' => $or_no,
                        'itemPaid' => $fees['Fees_Name'],
                        'Fees_Enrolled_College_Item_id' => $fees['item_id'],
                        'Transaction_Item' => $transaction_type,
                        'transDate' => $this->date_time,
                        'Transaction_Type' => $payment_type,
                        'description' => $description,
                        'Semester' => $semester,
                        'SchoolYear' => $school_year,
                        'cashier' => $this->admin_data['userid'],
                        'web_dose_module' => 1
                    );
                    
                }
                else
                {
                    # add payment to array
                    $array_fees_throughput[] = array(
                        'Reference_Number' => $reference_no,
                        'AmountofPayment' => $amount,
                        'OR_Number' => $or_no,
                        'itemPaid' => $fees['Fees_Name'],
                        'Fees_Enrolled_College_Item_id' => $fees['item_id'],
                        'Transaction_Item' => $transaction_type,
                        'transDate' => $this->date_time,
                        'Transaction_Type' => $payment_type,
                        'description' => $description,
                        'Semester' => $semester,
                        'SchoolYear' => $school_year,
                        'cashier' => $this->admin_data['userid'],
                        'web_dose_module' => 1
                    );
                }
                $amount = number_format($amount - $fees['Fees_Amount'], 2, '.', '');
            }
            else 
            {
                # code...
                break;
            }


        } 

        #if there is exess payment
        if ($amount > 0) 
        {
            # add payment to array
            $array_fees_throughput[] = array(
                'Reference_Number' => $reference_no,
                'AmountofPayment' => $amount,
                'OR_Number' => $or_no,
                'itemPaid' => 'Excess',
                'Fees_Enrolled_College_Item_id' => $fees['item_id'],
                'Transaction_Item' => $transaction_type,
                'transDate' => $this->date_time,
                'Transaction_Type' => $payment_type,
                'description' => $description,
                'Semester' => $semester,
                'SchoolYear' => $school_year,
                'cashier' => $this->admin_data['userid'],
                'web_dose_module' => 1
            );

            #set array for refund
            $array_student_refund = array(
                'Reference_Number' => $reference_no,
                'Student_Number' => $array_data['student_no'],
                'Semester' => $semester,
                'SchoolYear' => $school_year,
                'source' => $transaction_type,
                'source_ID' => 0,
                'source_OR' => $or_no,
                'source_Description' => 'EXCESS PAYMENT',
                'valid' => 1,
                'web_dose_module' => 1
            );
            $transaction_output = $this->Fees_Model->insert_refund($array_student_refund);

            $this->array_logs['transaction_output'] = $transaction_output;
            $this->Logs_Model->insert_transaction_logs($this->array_logs);

        }
        
        #insert fees throughput
        $transaction_output = $this->Fees_Model->insert_payments_throughput($array_fees_throughput);
        $this->array_logs['transaction_output'] = $transaction_output;
        $this->Logs_Model->insert_transaction_logs($this->array_logs);
        #throughput process end
        
        #insert Enrollment details
        $array_payment_data = array(
            "Reference_Number" => $reference_no,
            "Student_Number" => $array_data['student_no'],
            "AmountofPayment" => $amount_insert,
            "OR_Number" => $or_no,
            "Date" => $this->date_time,
            "Transaction_Type" => $payment_type,
            "description" => $description,
            "Transaction_Item" => $transaction_type,
            "Semester" => $semester,
            "SchoolYear" => $school_year,
            "cashier" => $this->admin_data['userid'],
            "valid" => 1,
            "web_dose_module" => 1
        );

        $transaction_output = $this->Fees_Model->insert_student_payment($array_payment_data);

        #insert logs
        $this->array_logs['transaction_output'] = $transaction_output;
        $this->Logs_Model->insert_transaction_logs($this->array_logs);

        return;
       

       
    }

    public function check_or()
    {
        if ($this->input->get("or_no")) 
        {
            # code...
            #check if OR number have duplicate
            $or_duplication_checker = $this->Fees_Model->check_duplicate_or($this->input->get("or_no"));
            $or_duplication_checker_enrollment = $this->Fees_Model->check_duplicate_or_enrollment($this->input->get("or_no"));
            if ($or_duplication_checker || $or_duplication_checker_enrollment) 
            {
                 # code...
                $output["checker"] = 0;
                $output["message"] = "OR Number already in use. Please use different OR Number.";
                
            }
            else 
            {
                # code...
                $output["checker"] = 1;
            }

            echo json_encode($output);
            return;

        }
        
    }

    public function basiced_home($reference_no ="", $school_year = "")
    {
        if ($reference_no && $school_year) 
        {
            # code...
            if (!is_numeric($reference_no)) 
            {
                # code...
                redirect('Cashier');
            }
            #set params
            $this->student_data->set_reference_no($reference_no);
            $this->student_data->set_school_year($school_year);
            $this->data['school_year'] = $this->student_data->get_school_year();
            $this->data['student_info'] = $this->Student_Model->get_bed_student_info_by_reference_no();
            
            if (!$this->data['student_info']) 
            {
                # code...
                $this->session->set_flashdata('message_error','Data not found.');
                redirect('Cashier/basiced_home');
            }

            #set student number param
            if ($this->data['student_info'][0]['Student_Number'] > 0) {
                # code...
                $this->student_data->set_student_no($this->data['student_info'][0]['Student_Number']);
            }

            #set grade level 
            $this->student_data->set_grade_level($this->data['student_info'][0]['Gradelevel']);
            $this->student_data->set_school_level();
            $this->data['school_level'] = $this->student_data->get_school_level();

            #check if enrolled fees main is available and get data if available
            $this->data['fees_enrolled'] = $this->bed_enrolled_fees_checker();

            if ($this->data['fees_enrolled']) 
            {
                # code...
                 #get student total payment from throughput table
                $total_payment = $this->Fees_Model->get_bed_total_payment();
                $this->data['total_payment'] = $total_payment[0]['total_payment'];
                #total tuition
                $this->data['total_tuition_fee'] = $this->data['fees_enrolled'][0]['Initial_Payment'] + $this->data['fees_enrolled'][0]['First_Payment']+ 
                    $this->data['fees_enrolled'][0]['Second_Payment'] + $this->data['fees_enrolled'][0]['Third_Payment']+ $this->data['fees_enrolled'][0]['Fourth_Payment']+
                    $this->data['fees_enrolled'][0]['Fifth_Payment']+ $this->data['fees_enrolled'][0]['Sixth_Payment']+$this->data['fees_enrolled'][0]['Seventh_Payment'];
                
                #remaining balance
                $this->data['balance'] = $this->data['total_tuition_fee'] - $this->data['total_payment'];
            }

            #get result for balance checker
            /*
                @params array keys
                'error'= 1 if there is an error
                'message' = message to be displayed 
                'payment_approval' = 1 if fees can be paid
            */
            $this->data['array_balance_checker'] = $this->bed_shs_check_payment_approval();

            if ($this->data['array_balance_checker']['message']) {
                # code...
                $this->session->set_flashdata('message_error', $this->data['array_balance_checker']['message']);
            }

            #get list of unapplied reservation payments
            $this->data['reservation_payments_to_apply'] = $this->Fees_Model->get_to_apply_bed_reservations();

            #get list of payments
            $this->data['payments_list'] = $this->Fees_Model->get_bed_payments();
            
            
        }
        else
        {
             # code...
             $this->render($this->set_views->bed_enrollment_payment());
             return;
        }

        $this->render($this->set_views->bed_enrollment_payment());
    }

    public function basiced_form_select_student()
    {
        if (!$this->input->post("stud_ref_number")  || !$this->input->post("school_year")) 
        {
            # code...
            $this->session->set_flashdata('message_error','System error.');
            redirect('Cashier/basiced_home');
        }

        if (!is_numeric($this->input->post("stud_ref_number"))) 
        {
            # code...
            redirect('Cashier/basiced_home');
        }

        #set params
        $this->student_data->set_reference_no($this->input->post("stud_ref_number"));
        $this->student_data->set_school_year($this->input->post("school_year"));
        
        


        #check by student number
        $student_info = $this->Student_Model->get_bed_student_info_by_student_no();

        if (!$student_info) 
        {
            # code...
            //check by reference
            $student_info = $this->Student_Model->get_bed_student_info_by_reference_no();
            
            if (!$student_info) 
            {
                $this->session->set_flashdata('message_error','Data not found.');
                redirect('Cashier');
            }

            redirect('Cashier/basiced_home/'.$this->student_data->get_reference_no().'/'.$this->student_data->get_school_year());
            
        }
    }

    public function bed_shs_check_payment_approval()
    {
        $array_output = array(
            'error' => 0,
            'message' => "",
            'payment_approval' => 0
        );
        if (!$this->student_data->get_reference_no()) {
            # code...
            $array_output['error'] = 1;
            $array_output['message'] = "No available Reference Number";
            return $array_output;
        }

        if (!$this->student_data->get_student_no()) {
            # new student
            $array_output['payment_approval'] = 1;
            return $array_output;
        }

        #check selected school_year if the accounting approved
        $payment_approval_checker = $this->Fees_Model->check_bed_shs_payment_approval();
        if ($payment_approval_checker) {
            # code...
            $array_output['payment_approval'] = 1;
            return $array_output;
        }
        
        #get balance list
        $balance = $this->Fees_Model->get_bed_remaining_balance();

        if (!$balance) {
            # code...
            $array_output['message'] = "Please advise the student first.";
            $array_output['payment_approval'] = 1;
            return $array_output;
        }

        foreach ($balance as $key => $value) {
            # code...
            if ($value['schoolyear'] === $this->student_data->get_school_year()) {
                # code...
                $array_output['payment_approval'] = 1;
                return $array_output;
            }
            if ($value['BALANCE'] > 0) {
                # code...
                $array_output['message'] = 'There is remaining balance on '.$value['semester'].' SEMESTER, AY '.$value['schoolyear'].'.';
                return $array_output;
            }

        }

         
        
    }

    private function bed_enrolled_fees_checker()
    {
        $fees_enrolled_checker = $this->Fees_Model->get_bed_enrolled_fees_main();
            
        if (!$fees_enrolled_checker) {
            # check if fees enrolled temp is available
            $fees_enrolled_checker_temp = $this->Fees_Model->get_bed_enrolled_fees();

            #if $fees_enrolled_checker_temp have value, then mirror the data to feed main enrolled fees
            if (!$fees_enrolled_checker_temp) {
                $output = "";
            }
            else {
                # code...
                $output = $fees_enrolled_checker_temp;
            }
            
        }
        else {
            # code...
            $output = $fees_enrolled_checker;
        }

        return $output;
    }

    private function bed_mirror_fees_enrolled()
    {
        $this->array_logs['reference_number'] = $this->student_data->get_reference_no();
        $this->array_logs['process'] = "BED Enrolled Fees Mirroring";

        $fees_enrolled_checker = $this->Fees_Model->get_bed_enrolled_fees_main();

        #if $fees_enrolled_checker_temp have value, then mirror the data to feed main enrolled fees
        if (!$fees_enrolled_checker) {

            $fees_enrolled_temp = $this->Fees_Model->get_bed_enrolled_fees();

            if (!$fees_enrolled_temp) 
            {
                # code...
                $this->session->set_flashdata('message_error','Fees enrolled not available. Please advise the student first.');
                redirect('Cashier');
            }
            # mirror data
            $transaction_output = $this->Fees_Model->insert_bed_enrolled_fees_main($fees_enrolled_temp[0]['id']);
            $this->array_logs['transaction_output'] = $transaction_output;
            $this->Logs_Model->insert_transaction_logs($this->array_logs);

            $output = $this->Fees_Model->get_bed_enrolled_fees_main();

            #update fees item amount if payment scheme is not cash
            if ($output[0]['Payment_Scheme'] != "CASH") {
                # code...
                $array_params = array(
                    'array_fees' => $output
                );
        
                $this->load->library('Online_Cashier/bed_fees', $array_params);
                $this->bed_fees->set_payment_plan();

                #update bed enrolled fees local
                $transaction_output = $this->Fees_Model->update_bed_enrolled_fees();

                #insert logs
                $this->array_logs['transaction_output'] = $transaction_output;
                $this->Logs_Model->insert_transaction_logs($this->array_logs);
            }

        }
    }

    public function bed_check_or()
    {
        if ($this->input->get("or_no")) 
        {
            # code...
            $this->student_data->set_or_no($this->input->get("or_no"));
            #check if OR number have duplicate
            $or_duplication_checker = $this->Fees_Model->bed_check_duplicate_or();
            $or_duplication_checker_enrollment = $this->Fees_Model->bed_check_duplicate_or_enrollment();
            if ($or_duplication_checker || $or_duplication_checker_enrollment) 
            {
                # code...
                $output["checker"] = 0;
                $output["message"] = "OR Number already in use. Please use different OR Number.";
            }
            else 
            {
                # code...
                $output["checker"] = 1;
            }

            echo json_encode($output);
            return;

        }
        
    }

    private function bed_payment_input_checker()
    {
        if (!$this->input->post("reference_no") || !$this->input->post("school_year") || 
        !$this->input->post("amount") || !$this->input->post("or_no") || !$this->input->post("payment_type") ||
        !$this->input->post("transaction_type")) 
        {
            # code...
            $this->session->set_flashdata('message_error','system error.');
            redirect('Cashier/basiced_home');
        }

        if (!is_numeric($this->input->post("reference_no"))) 
        {
            # code...
            $this->session->set_flashdata('message_error','Enter correct format for reference number.');
            redirect('Cashier/basiced_home');
        }

        if (!is_numeric($this->input->post("amount"))) 
        {
            # code...
            $this->session->set_flashdata('message_error','Use number format for amount.');
            redirect('Cashier/basiced_home');
        }
        
        #set params
        $this->student_data->set_reference_no($this->input->post("reference_no"));
        $this->student_data->set_school_year($this->input->post("school_year"));
        $this->student_data->set_amount($this->input->post("amount"));
        $this->student_data->set_or_no($this->input->post("or_no"));
        $this->student_data->set_payment_type($this->input->post("payment_type"));
        $this->student_data->set_description($this->input->post("description"));
        $this->student_data->set_transaction_type($this->input->post("transaction_type"));

        #check if reference number is available 
        $student_info = $this->Student_Model->get_bed_student_info_by_reference_no();
        if (!$student_info) {
            # code...
            $this->session->set_flashdata('message_error','Student data not found.');
            redirect('Cashier/basiced_home');
        }

        if ($student_info[0]['Student_Number'] != 0) {
            # code...
            $this->student_data->set_student_no($student_info[0]['Student_Number']);
        }
        

        #check if OR number have duplicate
        $or_duplication_checker = $this->Fees_Model->bed_check_duplicate_or();
        $or_duplication_checker_enrollment = $this->Fees_Model->bed_check_duplicate_or_enrollment();
        if ($or_duplication_checker || $or_duplication_checker_enrollment) 
        {
            # code...
            $this->session->set_flashdata('message_error','OR Number is already in use.');
            redirect('Cashier/basiced_home/'.$this->student_data->get_reference_no().'/'.$this->student_data->get_school_year().'/'.$this->student_data->get_grade_level());
        }

        return;
    }

    public function bed_reservation()
    {
        $this->bed_payment_input_checker();

        #insert Reservation details
        $array_insert = array(
            "Reference_No" => $this->student_data->get_reference_no(),
            "SchoolYear" => $this->student_data->get_school_year(),
            "Amount" => $this->student_data->get_amount(),
            "Transaction_Item" => "RESERVATION",
            "OR_Number" => $this->student_data->get_or_no(),
            "Payment_Type" => $this->student_data->get_payment_type(),
            "Append_Cashier" => $this->admin_data['userid'],
            "Append_Date" => $this->date_time,
            "valid" => 1,
            "web_dose_module" => 1
        );


        $transaction_output = $this->Fees_Model->bed_insert_reservation($array_insert);

        #insert logs

        $this->array_logs['reference_number'] = $this->student_data->get_reference_no();
        $this->array_logs['process'] = "BED Reservation";
        $this->array_logs['transaction_output'] = $transaction_output;

        $this->Logs_Model->insert_transaction_logs($this->array_logs);

        $this->session->set_flashdata('message_success','Transaction Successful.');
        redirect('Cashier/basiced_home/'.$this->student_data->get_reference_no().'/'.$this->student_data->get_school_year());

    }

    public function bed_matriculation_input()
    {
        $this->bed_payment_input_checker();

        #mirror bed enrolled fees
        $this->bed_mirror_fees_enrolled();

        #set log data
        $this->array_logs['reference_number'] = $this->student_data->get_reference_no();
        $this->array_logs['process'] = "BED Enrollment";

        #get enrolled fees
        $fees_enrolled = $this->Fees_Model->get_bed_enrolled_fees_main();
        
        #set parameter to call class BED_fees
        $array_params = array(
            'array_fees' => $fees_enrolled
        );

        $this->load->library('Online_Cashier/bed_fees', $array_params);

        #throughput process
        $this->bed_matriculation();

        //return;
        #reservation auto apply
        $this->auto_apply_bed_reservation();

        $this->session->set_flashdata('message_success','Transaction Successful.');
        redirect('Cashier/basiced_home/'.$this->student_data->get_reference_no().'/'.$this->student_data->get_school_year().'/'.$this->student_data->get_grade_level());
    }

    private function bed_matriculation()
    {

        #generate student number id student is new
        if (!$this->student_data->get_student_no()) 
        {
            # code...
            $array_student_number_output = $this->Student_Model->generate_bed_student_number();
            $this->student_data->set_student_no($array_student_number_output['insert_id']);
            #insert logs
            $this->array_logs['transaction_output'] = $array_student_number_output['message'];
            $this->Logs_Model->insert_transaction_logs($this->array_logs);

            #update student number of student
            $transaction_output = $this->Student_Model->update_bed_student_number();
            $this->array_logs['transaction_output'] = $transaction_output;
            $this->Logs_Model->insert_transaction_logs($this->array_logs);

            #add student number in fees enrolled table
            $transaction_output = $this->Student_Model->add_stud_number_to_enrolled_fees();
            $this->array_logs['transaction_output'] = $transaction_output;
            $this->Logs_Model->insert_transaction_logs($this->array_logs);
        }

        #set bed fees parameters
        $this->bed_fees->set_reference_no($this->student_data->get_reference_no());
        $this->bed_fees->set_student_no($this->student_data->get_student_no());
        $this->bed_fees->set_school_year($this->student_data->get_school_year());
        $this->bed_fees->set_amount($this->student_data->get_amount());
        $this->bed_fees->set_or_no($this->student_data->get_or_no());
        $this->bed_fees->set_payment_type($this->student_data->get_payment_type());
        $this->bed_fees->set_description($this->student_data->get_description());
        $this->bed_fees->set_transaction_type($this->student_data->get_transaction_type());
        $this->bed_fees->set_cashier($this->admin_data['userid']);
        $this->bed_fees->set_transaction_date($this->date_time);

        #get payment throughput
        $payment_throughput = $this->Fees_Model->get_bed_payment_throughput_list();
        
        #get payment throughput array to insert
        $this->bed_fees->set_array_paid_fees_item($payment_throughput);
        $array_fees_throughput = $this->bed_fees->get_array_payments_throughput();
        /*
        print "<br>";
        print_r($array_fees_throughput);
        print "<br>";
        print_r($this->bed_fees->get_array_update_fees_enrolled());
       

        return;
        */
        #check if there is excess payment
        if ($this->bed_fees->get_excess_payment()) {
            #set array for refund
            $array_student_refund = array(
                'Reference_Number' => $this->student_data->get_reference_no(),
                'Student_Number' => $this->student_data->get_student_no(),
                'SchoolYear' => $this->student_data->get_school_year(),
                'source' => $this->student_data->get_transaction_type(),
                'source_ID' => 0,
                'source_OR' => $this->student_data->get_or_no(),
                'source_Description' => 'EXCESS PAYMENT',
                'valid' => 1,
                'web_dose_module' => 1
            );

            $transaction_output = $this->Fees_Model->insert_bed_refund($array_student_refund);

            $this->array_logs['transaction_output'] = $transaction_output;
            $this->Logs_Model->insert_transaction_logs($this->array_logs);
        }

        #insert fees throughput
        $transaction_output = $this->Fees_Model->insert_bed_payments_throughput($array_fees_throughput);
        $this->array_logs['transaction_output'] = $transaction_output;
        $this->Logs_Model->insert_transaction_logs($this->array_logs);

        #insert Enrollment details
        $array_payment_data = array(
            "Reference_Number" => $this->student_data->get_reference_no(),
            "Student_Number" => $this->student_data->get_student_no(),
            "AmountofPayment" => $this->student_data->get_amount(),
            "OR_Number" => $this->student_data->get_or_no(),
            "Date" => $this->date_time,
            "Transaction_Type" => $this->student_data->get_payment_type(),
            "description" => $this->student_data->get_description(),
            "Transaction_Item" => $this->student_data->get_transaction_type(),
            "SchoolYear" => $this->student_data->get_school_year(),
            "cashier" => $this->admin_data['userid'],
            "valid" => 1,
            "web_dose_module" => 1
        );

        $transaction_output = $this->Fees_Model->insert_bed_student_payment($array_payment_data);

        #insert logs
        $this->array_logs['transaction_output'] = $transaction_output;
        $this->Logs_Model->insert_transaction_logs($this->array_logs);
        
        #update bed enrolled fees local
        $transaction_output = $this->Fees_Model->update_bed_enrolled_fees();

        #insert logs
        $this->array_logs['transaction_output'] = $transaction_output;
        $this->Logs_Model->insert_transaction_logs($this->array_logs);

        
        return;
        
    }

    private function auto_apply_bed_reservation()
    {
        $reservation_payments = $this->Fees_Model->check_to_apply_bed_reservations();
        if (!$reservation_payments) 
        {
            return;
        }

        # apply reservations to matriculation

        foreach ($reservation_payments as $key => $payment) 
        {
            # set parameters
            $this->student_data->set_amount($payment['Amount']);
            $this->student_data->set_transaction_type($payment['Transaction_Item']);
            $this->student_data->set_or_no($payment['OR_Number']);
            $this->student_data->set_payment_type($payment['Payment_Type']);
            if ($payment['Description']) 
            {
                # code...
                $this->student_data->set_description($payment['Description']);
            }
            else 
            {
                # code...
                $this->student_data->set_description(NULL);
            }

            #get enrolled fees
            $fees_enrolled = $this->Fees_Model->get_bed_enrolled_fees_main();

            #re set fees enrolled data
            $this->bed_fees->set_array_fees($fees_enrolled[0]);

            #insert reservation payment to matriculation
            $this->bed_matriculation();

            #update reservation data
            $array_update = array(
                'Applied' => 1,
                'Applied_Date' => $payment['Append_Date'],
                'Applied_Cashier' => $payment['Append_Cashier']
            );

            $transaction_output = $this->Fees_Model->update_applied_bed_reservation($array_update, $payment['reservation_id']);

            #insert logs
            $this->array_logs['transaction_output'] = $transaction_output;
            $this->Logs_Model->insert_transaction_logs($this->array_logs);

        }
        return;
    }

    public function shs_home($reference_no ="", $school_year = "", $grade_level ="", $track ="", $strand ="")
    {
        #track list
        $this->data['track_list'] = $this->Student_Model->get_track_list();

        if ($reference_no && $school_year && $grade_level && $track && $strand) 
        {
            # code...
            if (!is_numeric($reference_no)) 
            {
                # code...
                redirect('Cashier/shs_home');
            }
            #set params
            $this->student_data->set_reference_no($reference_no);
            $this->student_data->set_school_year($school_year);
            $this->student_data->set_grade_level($grade_level);
            $this->student_data->set_track($track);
            $this->student_data->set_strand($strand);
            $this->data['school_year'] = $this->student_data->get_school_year();
            $this->data['student_info'] = $this->Student_Model->get_shs_student_info_by_reference_no();
            $this->data['grade_level'] = $this->student_data->get_grade_level();
            $this->data['track'] = $this->student_data->get_track();
            $this->data['strand'] = $this->student_data->get_strand();
            
            if (!$this->data['student_info']) 
            {
                # code...
                $this->session->set_flashdata('message_error','Data not found.');
                redirect('Cashier/shs_home');
            }

            #check if enrolled fees main is available and get data if available
            $this->data['fees_enrolled'] = $this->bed_enrolled_fees_checker();

            if ($this->data['fees_enrolled']) 
            {
                # code...
                 #get student total payment from throughput table
                $total_payment = $this->Fees_Model->get_bed_total_payment();
                $this->data['total_payment'] = $total_payment[0]['total_payment'];
                #total tuition
                $this->data['total_tuition_fee'] = $this->data['fees_enrolled'][0]['Initial_Payment'] + $this->data['fees_enrolled'][0]['First_Payment']+ 
                    $this->data['fees_enrolled'][0]['Second_Payment'] + $this->data['fees_enrolled'][0]['Third_Payment']+ $this->data['fees_enrolled'][0]['Fourth_Payment']+
                    $this->data['fees_enrolled'][0]['Fifth_Payment']+ $this->data['fees_enrolled'][0]['Sixth_Payment']+$this->data['fees_enrolled'][0]['Seventh_Payment'];
                
                #remaining balance
                $this->data['balance'] = $this->data['total_tuition_fee'] - $this->data['total_payment'];
            }

            #get list of unapplied reservation payments
            $this->data['reservation_payments_to_apply'] = $this->Fees_Model->get_to_apply_bed_reservations();

            #get list of payments
            $this->data['payments_list'] = $this->Fees_Model->get_bed_payments();
            
            
        }
        else
        {
             # code...
             $this->render($this->set_views->shs_enrollment_payment());
             return;
        }

        $this->render($this->set_views->shs_enrollment_payment());
    }

    public function shs_form_select_student()
    {
        if (!$this->input->post("stud_ref_number") || !$this->input->post("grade_level") || !$this->input->post("school_year") || 
        !$this->input->post("strand")|| !$this->input->post("track")) 
        {
            # code...
            $this->session->set_flashdata('message_error','System error.');
            redirect('Cashier/shs_home');
        }

        if (!is_numeric($this->input->post("stud_ref_number"))) 
        {
            # code...
            redirect('Cashier/shs_home');
        }

        #set params
        $this->student_data->set_reference_no($this->input->post("stud_ref_number"));
        $this->student_data->set_school_year($this->input->post("school_year"));
        $this->student_data->set_grade_level($this->input->post("grade_level"));
        $this->student_data->set_track($this->input->post("track"));
        $this->student_data->set_strand($this->input->post("strand"));
        
        


        #check by student number
        $student_info = $this->Student_Model->get_shs_student_info_by_student_no();

        if (!$student_info) 
        {
            # code...
            //check by reference
            $student_info = $this->Student_Model->get_shs_student_info_by_reference_no();
            
            if (!$student_info) 
            {
                $this->session->set_flashdata('message_error','Data not found.');
                redirect('Cashier/shs_home');
            }

            redirect('Cashier/shs_home/'.$this->student_data->get_reference_no().'/'.$this->student_data->get_school_year().'/'.
            $this->student_data->get_grade_level().'/'.$this->student_data->get_track().'/'.$this->student_data->get_strand());
            
        }
    }

    private function shs_enrolled_fees_checker()
    {
        $this->array_logs['reference_number'] = $this->student_data->get_reference_no();
        $this->array_logs['process'] = "BED Enrolled Fees Mirroring";

        $fees_enrolled_checker = $this->Fees_Model->get_shs_enrolled_fees_main();
            
        if (!$fees_enrolled_checker) 
        {
            # check if fees enrolled temp is available
            $fees_enrolled_checker_temp = $this->Fees_Model->get_shs_enrolled_fees();

            #if $fees_enrolled_checker_temp have value, then mirror the data to feed main enrolled fees
            if ($fees_enrolled_checker_temp) 
            {
                # mirror data
                $transaction_output = $this->Fees_Model->insert_bed_enrolled_fees_main($fees_enrolled_checker_temp[0]['id']);
                $this->array_logs['transaction_output'] = $transaction_output;
                $this->Logs_Model->insert_transaction_logs($this->array_logs);

                $output = $this->Fees_Model->get_shs_enrolled_fees_main();

                #update fees item amount if payment scheme is not cash
                if ($output[0]['Payment_Scheme'] != "CASH") {
                    # code...
                    $array_params = array(
                        'array_fees' => $output
                    );
            
                    $this->load->library('Online_Cashier/bed_fees', $array_params);
                    $this->bed_fees->set_payment_plan();

                    #update bed enrolled fees local
                    $transaction_output = $this->Fees_Model->update_bed_enrolled_fees();

                    #insert logs
                    $this->array_logs['transaction_output'] = $transaction_output;
                    $this->Logs_Model->insert_transaction_logs($this->array_logs);
                }

            }
            else
            {
                $output = "";
            }
            
        }
        else 
        {
            # code...
            $output = $fees_enrolled_checker;
        }

        return $output;
    }

    private function shs_payment_input_checker()
    {
        if (!$this->input->post("reference_no") || !$this->input->post("school_year") || 
        !$this->input->post("amount") || !$this->input->post("or_no") || !$this->input->post("payment_type") ||
        !$this->input->post("grade_level") || !$this->input->post("transaction_type") || 
        !$this->input->post("track") || !$this->input->post("strand")) 
        {
            # code...
            $this->session->set_flashdata('message_error','system error.');
            redirect('Cashier/shs_home');
        }

        if (!is_numeric($this->input->post("reference_no"))) 
        {
            # code...
            $this->session->set_flashdata('message_error','Enter correct format for reference number.');
            redirect('Cashier/basiced_home');
        }

        if (!is_numeric($this->input->post("amount"))) 
        {
            # code...
            $this->session->set_flashdata('message_error','Use number format for amount.');
            redirect('Cashier/basiced_home');
        }
        
        #set params
        $this->student_data->set_reference_no($this->input->post("reference_no"));
        $this->student_data->set_school_year($this->input->post("school_year"));
        $this->student_data->set_amount($this->input->post("amount"));
        $this->student_data->set_or_no($this->input->post("or_no"));
        $this->student_data->set_payment_type($this->input->post("payment_type"));
        $this->student_data->set_description($this->input->post("description"));
        $this->student_data->set_grade_level($this->input->post("grade_level"));
        $this->student_data->set_transaction_type($this->input->post("transaction_type"));
        $this->student_data->set_track($this->input->post("track"));
        $this->student_data->set_strand($this->input->post("strand"));

        #check if reference number is available 
        $student_info = $this->Student_Model->get_shs_student_info_by_reference_no();
        if (!$student_info) {
            # code...
            $this->session->set_flashdata('message_error','Student data not found.');
            redirect('Cashier/shs_home');
        }

        $this->student_data->set_student_no($student_info[0]['Student_Number']);

        #check if OR number have duplicate
        $or_duplication_checker = $this->Fees_Model->bed_check_duplicate_or();
        $or_duplication_checker_enrollment = $this->Fees_Model->bed_check_duplicate_or_enrollment();
        if ($or_duplication_checker || $or_duplication_checker_enrollment) 
        {
            # code...
            $this->session->set_flashdata('message_error','OR Number is already in use.');
            redirect('Cashier/shs_home/'.$this->student_data->get_reference_no().'/'.$this->student_data->get_school_year().'/'.$this->student_data->get_grade_level().'/'.
                $this->student_data->get_track().'/'.$this->student_data->get_strand());
        }

        return;
    }

    public function shs_reservation()
    {
        $this->shs_payment_input_checker();

        #insert Reservation details
        $array_insert = array(
            "Reference_No" => $this->student_data->get_reference_no(),
            "SchoolYear" => $this->student_data->get_school_year(),
            "Amount" => $this->student_data->get_amount(),
            "Transaction_Item" => "RESERVATION",
            "OR_Number" => $this->student_data->get_or_no(),
            "Payment_Type" => $this->student_data->get_payment_type(),
            "Append_Cashier" => $this->admin_data['userid'],
            "Append_Date" => $this->date_time,
            "valid" => 1,
            "web_dose_module" => 1
        );


        $transaction_output = $this->Fees_Model->bed_insert_reservation($array_insert);

        #insert logs

        $this->array_logs['reference_number'] = $this->student_data->get_reference_no();
        $this->array_logs['process'] = "SHS Reservation";
        $this->array_logs['transaction_output'] = $transaction_output;

        $this->Logs_Model->insert_transaction_logs($this->array_logs);

        $this->session->set_flashdata('message_success','Transaction Successful.');
        redirect('Cashier/shs_home/'.$this->student_data->get_reference_no().'/'.$this->student_data->get_school_year().'/'.$this->student_data->get_grade_level().'/'.
            $this->student_data->get_track().'/'.$this->student_data->get_strand());

    }

    public function shs_matriculation_input()
    {
        $this->shs_payment_input_checker();

        #mirror bed enrolled fees
        $this->bed_mirror_fees_enrolled();

        #set log data
        $this->array_logs['reference_number'] = $this->student_data->get_reference_no();
        $this->array_logs['process'] = "SHS Enrollment";

        #get enrolled fees
        $fees_enrolled = $this->Fees_Model->get_shs_enrolled_fees_main();
        
        #set parameter to call class BED_fees
        $array_params = array(
            'array_fees' => $fees_enrolled
        );

        $this->load->library('Online_Cashier/bed_fees', $array_params);

        #throughput process
        $this->bed_matriculation();

        //return;
        #reservation auto apply
        $this->auto_apply_bed_reservation();

        $this->session->set_flashdata('message_success','Transaction Successful.');
        redirect('Cashier/shs_home/'.$this->student_data->get_reference_no().'/'.$this->student_data->get_school_year().'/'.$this->student_data->get_grade_level().'/'.
            $this->student_data->get_track().'/'.$this->student_data->get_strand());
    }

    public function get_strand_list()
    {
        if ($this->input->get("track")) 
        {
            # code...
            $strand_list = $this->Student_Model->get_strand_list($this->input->get("track"));
            
            if ($strand_list) 
            {
                # code...
                $output["checker"] = 1;
                $output["output"] = $strand_list;
            }
            else 
            {
                # code...
                $output["checker"] = 0;
            }

            echo json_encode($output);
            return;

        }
    }

    public function get_bed_payment_plan_computation()
    {
        #set payment plan
        
        #get fees listing
        $fees_listing = $this->Fees_Model->get_bed_fees_listing();
        $this->bed_fees->set_fees_listing($fees_listing);

    }

    public function test()
    {
        $_POST['reference_no'] = "1377";
        $_POST['semester'] = "SECOND";
        $_POST['school_year'] = "2019-2020";
        $_POST['amount'] = "5000";
        $_POST['or_no'] = "123456789asd";
        $_POST['payment_type'] = "CASH";
        $_POST['transaction_type'] = "MATRICULATION";
        $this->hed_matriculation_input();


    }

    public function test_bed()
    {
        
        $this->student_data->set_reference_no(1918);
        $this->student_data->set_grade_level("G8");
        $this->student_data->set_school_year("2019-2020");

        $fees = $this->Fees_Model->get_bed_enrolled_fees_main();
        $array_params = array(
            'array_fees' => $fees
        );

        $this->load->library('Online_Cashier/bed_fees', $array_params);

        print_r($this->bed_fees->get_array_fees_item());

        $this->bed_fees->set_reference_no(123);
        print $this->bed_fees->get_reference_no();
       
    }

    
       
        


}