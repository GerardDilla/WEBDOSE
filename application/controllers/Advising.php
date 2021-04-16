<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Advising extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('set_views');
        $this->load->library('email');
        $this->load->library('pagination');
        $this->load->library('session');
        $this->load->library("Excel");
        $this->load->library("DateConverter");
        $this->load->helper(array('form', 'url', 'date'));

        $this->load->library('form_validation');
        $this->load->model('Registrar_Models/RegForm_Model');
        $this->load->model('Registrar_Models/Curriculum_Model');
        $this->load->model('Registrar_Models/SchedReport_Model');
        $this->load->model('Registrar_Models/Room_Model');
        $this->load->model('Registrar_Models/Class_List_Model');
        $this->load->model('Advising_Model/Schedule_Model');
        $this->load->model('Advising_Model/Student_Model');
        $this->load->model('Advising_Model/Program_Model');
        $this->load->model('Advising_Model/Course_Model');
        $this->load->model('Advising_Model/Fees_Model');
        $this->load->model('Advising_Model/Discrepancy_Check');
        $this->load->model('Advising_Model/Student_Balance_Model');
        $this->load->model('Registrar_Models/Class_List_Model');
        $this->load->model('Others_Model');
        $this->load->model('Account_Model/User_verification');
        $this->load->model('Account_Model/Module_Bypass_Model');

        //check if user is logged on
        $this->load->library('set_custom_session');
        $this->admin_data = $this->set_custom_session->admin_session();

        //user accessibility
        $this->load->library('User_accessibility');
        $this->user_accessibility->module_advising_access($this->admin_data['userid']);

        //set date
        $datestring = "%Y-%m-%d %h:%i";
        $time = time();
        $this->date_time = mdate($datestring, $time);

        //set logs
        $this->array_logs = array(
            'user_id' => $this->admin_data['userid'],
            'module' => 'Advising',
            'transaction_date' => $this->date_time,
        );

        //set bypass logs
        $this->array_bypass_logs = array(
            'user_id' => $this->admin_data['userid'],
            'module' => 'Advising',
            'transaction_date' => $this->date_time,
        );

        $this->unittypes = array(
            'graduating' => 30,
            'nongraduating' => 33,
            'pharma' => 34,
        );
    }

    public function index($id = "")
    {

        //get legend 
        $this->data['legend'] = $this->Schedule_Model->get_legend();
        //get time
        $this->data['time'] = $this->Schedule_Model->get_time();
        //get day

        if ($id && is_numeric($id)) {
            # code...
            $this->data['student_info'] = $this->Student_Model->get_student_info_by_reference_no($id);
            if ($this->data['student_info'] == NULL) {
                # code...
                //get student info by student no
                $this->data['student_info'] = $this->Student_Model->get_student_info_by_student_no($id);
            }
            if ($this->data['student_info'] == NULL) {
                redirect('Advising');
            }
            //check if student have curriculum
            $this->data['student_curriculum'] = $this->Student_Model->get_student_curriculum($this->data['student_info'][0]['Curriculum']);
            if (($this->data['student_curriculum'] == NULL) || ($this->data['student_info'][0]['Curriculum'] != "N/A")) {
                # code...
                //get list of curriculum
                $this->data['curriculum_list'] = $this->Program_Model->get_program_curriculum($this->data['student_info'][0]['Course']);
            } else {
                echo 'ERROR:NO CURRICULUM FOUND<BR><BR><BR>';
            }
            //echo $this->data['student_info'][0]['Course'];
            //get section list
            $this->data['section_list'] = $this->Program_Model->get_program_sections($this->data['student_info'][0]['Course']);

            $array_data = array(
                'reference_no' => $this->data['student_info'][0]['Reference_Number']
            );

            //check if there is advising session
            $this->data['advising_session'] = $this->Student_Model->get_sched_session($array_data);

            $this->data['advising_session_set'] = array();
            if ($this->data['advising_session'] != NULL) {
                if ($this->data['advising_session'][0]['Status'] === "REGULAR") {
                    $open = "";
                    $block = "Checked";
                } else {
                    $open = "Checked";
                    $block = "";
                }
                if ($this->data['advising_session'][0]['Graduating'] == 0) {
                    $graduating = "";
                    $nongraduating = "Checked";
                    $pharma = "";
                } else if ($this->data['advising_session'][0]['Program'] == 'BSP') {
                    $graduating = "";
                    $nongraduating = "";
                    $pharma = "Checked";
                }


                # code...
                //disable section and student type if there is advising session
                $this->data['advising_session_set'] = array(
                    'disable' => 'disabled',
                    'open' => $open,
                    'block' => $block,
                    'graduating' => $graduating,
                    'nongraduating' => $nongraduating,
                    'pharma' => $pharma,
                    'section' => $this->data['advising_session'][0]['Section'],
                    'school_year' => $this->data['advising_session'][0]['School_Year'],
                    'semester' => $this->data['advising_session'][0]['Semester']
                );

                //get fees
                $array_data['plan'] = "";
                //$this->data['fees'] = $this->display_fee($array_data);
            }

            //Checks if already advised
            //$legend = $this->Schedule_Model->get_legend();
            $searcharray = array(
                'Reference_Number' => $this->data['student_info'][0]['Reference_Number'],
                'Student_Number' => $this->data['student_info'][0]['Student_Number'],
                //'School_Year' => $legend[0]['School_Year'],
                //'Semester' => $legend[0]['Semester']
            );
            $this->data['AdvisedCheck'] = $this->Student_Model->check_advised($searcharray);

            //Checks previous Balance
            //$BalanceCheck = $this->Student_Balance_Model->GetTotalAndPaid($searcharray);
            //$Discounts = $this->Student_Balance_Model->GetDiscounts($searcharray);
            //$Balance = $BalanceCheck[0]['TOTAL'] <= $BalanceCheck[0]['PAID'] ? '0.00' : number_format((float)$BalanceCheck[0]['TOTAL'] - $BalanceCheck[0]['PAID'], 2, '.', '');
            //$ExcludedStatus = $this->Student_Balance_Model->GetExcludedStudents($searcharray);
            //$OverallBalance = $Balance  - $Discounts[0]['Discount'];
            //$this->data['ExcludedStatus'] = $ExcludedStatus;

            $this->data['encrypt_referencenumber'] = md5($this->data['student_info'][0]['Reference_Number']);

            //echo $this->data['Previous_Balanace']; 

        }



        $this->render($this->set_views->advising());
    }

    public function get_student_information()
    {
        $this->form_validation->set_rules('id', 'Student Number or Reference Number', 'required|numeric');
        if ($this->form_validation->run() == TRUE) {
            # code...
            $checker = 0;
            $student_info = $this->Student_Model->get_student_info_by_reference_no($this->input->post('id'));
            if ($student_info == NULL) {
                # code...
                //get student info by student no
                $student_info = $this->Student_Model->get_student_info_by_student_no($this->input->post('id'));
            }
            if ($student_info != NULL) {
                # code...
                //check if guidance have approved the student
                if (($student_info[0]['Guidance_Approval'] === 0) && ($student_info[0]['Course'] === "N/A")) {
                    # code...
                    $this->data['error'] = "Proceed to guidance for approval";
                    $checker = 1;
                }

                //check if student is already enrolled

                $enroll_check = $this->Student_Model->check_student_enrolled($student_info[0]['Reference_Number']);
                if ($enroll_check != NULL) {
                    # code...
                    $this->data['error'] = "THE STUDENT IS ALREADY ENROLLED!";
                    $checker = 1;
                }
            } else {
                $this->data['error'] = "Reference number or student number is invalid";
                $checker = 1;
            }

            if ($checker === 0) {
                redirect('Advising/index/' . $this->input->post('id'));
            }
        }

        $this->render($this->set_views->advising());
    }

    public function get_student_info()
    {
        if (($this->input->get('value') == NULL) or (!is_numeric($this->input->get('value')))) {
            # code...
            //redirect('Advising');
            echo "error:data is invalid";
        }

        //get student info by reference no
        $student_info = $this->Student_Model->get_student_info_by_reference_no($this->input->get('value'));
        if ($student_info == NULL) {
            # code...
            //get student info by student no
            $student_info = $this->Student_Model->get_student_info_by_student_no($this->input->get('value'));
        }
        if ($student_info == NULL) {
            # code...
            //redirect('Advising');
            echo "error: reference number or student number is invalid ";
        }

        //$array_output = array('' => , );

        //get student current year
        $student_year = $this->Student_Model->get_student_info_by_reference_no($student_info[0]['Reference_Number']);

        //check if student is approved by guidance for advising
        if (($student_info[0]['Guidance_Approval'] === 0) && ($student_year === 1)) {
            # code...
            //redirect('Advising');
            echo "error: proceed to guidance for advising approval ";
        }

        //check if student is new enrollee
        if ($student_info[0]['Student_Number'] === 0) {
            # code...

        }
    }

    public function get_time()
    {
        if (($this->input->get('check') == !1) or (!is_numeric($this->input->get('check')))) {
            # code...
            //redirect('Advising');
            echo "error";
        }

        $array_time = $this->Schedule_Model->get_time();
        echo json_encode($array_time);
        //echo 'yes';

    }

    public function get_sched_list()
    {
        if (($this->input->get('schedId') == NULL) or (!is_numeric($this->input->get('schedId')))) {
            # code...
            //redirect('Advising');
            echo "error";
        }

        $array_schedule_list = $this->Schedule_Model->get_sched_list($this->input->get('schedId'));
        echo json_encode($array_schedule_list);
        //echo "error";
    }

    public function get_course_sched_block()
    {
        if (($this->input->get('section') == NULL) or (!is_numeric($this->input->get('section')))) {
            # code...
            //redirect('Advising');
            echo 0;
            return;
        }

        //check if section and semester is available
        if (($this->input->get('semester') == NULL) or ($this->input->get('schoolYear') == NULL)) {
            echo 0;
            return;
        }



        $array_data = array(
            'section' => $this->input->get('section'),
            'school_year' => $this->input->get('schoolYear'),
            'semester' => $this->input->get('semester')
        );

        $sched_list = $this->Schedule_Model->get_sched_block($array_data);
        if ($sched_list == NULL) {
            # code...
            echo 0;
        } else {
            echo json_encode($sched_list);
        }
    }

    public function get_course_sched_open()
    {
        //check if section and semester is available
        if (($this->input->get('semester') == NULL) or ($this->input->get('schoolYear') == NULL)) {
            echo 0;
            return;
        }

        $array_data = array(
            'limit' => 5,
            'semester' => $this->input->get('semester'),
            'school_year' => $this->input->get('schoolYear')
        );
        //check if page is available
        if ($this->input->get('start') != NULL) {
            # code...
            $array_data['start'] = $this->input->get('start');
        } else {
            $array_data['start'] = 0;
        }
        if (($this->input->get('searchType') == NULL)) {
            $sched_list = $this->Schedule_Model->get_sched_open($array_data);
        } else {
            if ($this->input->get('searchType') === "Course_Code") {
                # code...
                $array_data['search_type'] = "B.Course_Code";
            } elseif ($this->input->get('searchType') === "Sched_Code") {
                # code...
                $array_data['search_type'] = "B.Sched_Code";
            } else {
                # code...
                $array_data['search_type'] = "E.Course_Title";
            }

            $array_data['search_value'] = $this->input->get('searchValue');
            $sched_list = $this->Schedule_Model->get_sched_open_search($array_data);
        }


        //$sched_list = $this->Schedule_Model->get_sched_open($array_data);
        if ($sched_list == NULL) {
            # code...
            echo 0;
        } else {
            echo json_encode($sched_list);
        }
    }

    public function get_course_sched_open_results_count()
    {
        //check if section and semester is available
        if (($this->input->get('semester') == NULL) or ($this->input->get('schoolYear') == NULL)) {
            echo 0;
            return;
        }
        $array_data = array(
            'semester' => $this->input->get('semester'),
            'school_year' => $this->input->get('schoolYear')
        );
        //check if search is used
        if ($this->input->get('searchType') == NULL) {
            echo $this->Schedule_Model->get_sched_open_row_count($array_data);
        } else {
            if ($this->input->get('searchType') === "Course_Code") {
                # code...
                $array_data['search_type'] = "B.Course_Code";
            } elseif ($this->input->get('searchType') === "Sched_Code") {
                # code...
                $array_data['search_type'] = "B.Sched_Code";
            } else {
                # code...
                $array_data['search_type'] = "E.Course_Title";
            }

            $array_data['search_value'] = $this->input->get('searchValue');
            echo $this->Schedule_Model->get_sched_open_row_count_search($array_data);
        }
    }

    public function get_sched_total_enrolled()
    {
        if (($this->input->get('schedCode') == NULL) or (!is_numeric($this->input->get('schedCode'))) or ($this->input->get('schedDisplayId') == NULL) or (!is_numeric($this->input->get('schedDisplayId')))) {
            # code...
            //redirect('Advising');
            echo 0;
            return;
        }

        $array_data = array(
            'sched_code' => $this->input->get('schedCode'),
            'sched_display_id' => $this->input->get('schedDisplayId'),
            'semester' => $this->input->get('semester'),
            'school_year' => $this->input->get('schoolyear'),
        );
        $total_enrolled = $this->Schedule_Model->get_sched_total_enrolled_no_sd($array_data);

        if ($total_enrolled == NULL) {
            # code...
            echo 0;
        } else {
            echo $total_enrolled[0]['total_enrolled'];
        }
    }

    public function get_sched_total_advised()
    {
        if (($this->input->get('schedCode') == NULL) or (!is_numeric($this->input->get('schedCode'))) or ($this->input->get('schedDisplayId') == NULL) or (!is_numeric($this->input->get('schedDisplayId')))) {
            # code...
            //redirect('Advising');
            echo 0;
            return;
        }

        $array_data = array(
            'sched_code' => $this->input->get('schedCode'),
            'sched_display_id' => $this->input->get('schedDisplayId'),
            'semester' => $this->input->get('semester'),
            'school_year' => $this->input->get('schoolyear'),
        );
        $total_enrolled = $this->Schedule_Model->get_sched_total_advised($array_data);

        if ($total_enrolled == NULL) {
            # code...
            echo 0;
        } else {
            echo $total_enrolled[0]['total_advised'];
        }
    }

    public function insert_sched_session()
    {
        $array_output = array();

        if (($this->input->get('schedDisplayId') == NULL) or (!is_numeric($this->input->get('schedDisplayId'))) or ($this->input->get('referenceNo') == NULL) or (!is_numeric($this->input->get('referenceNo')))) {
            $array_output['success'] = 0;
            $array_output['message'] = "No Data";
            echo json_encode($array_output);
            return;
        }

        if (($this->input->get('studType') == NULL) or ($this->input->get('section') == NULL)) {
            $array_output['success'] = 0;
            $array_output['message'] = "No Data";
            echo json_encode($array_output);
            return;
        }

        if (($this->input->get('semester') == NULL) or ($this->input->get('schoolYear') == NULL)) {
            $array_output['success'] = 0;
            $array_output['message'] = "No Data";
            echo json_encode($array_output);
            return;
        }

        //get student info
        $student_info = $this->Student_Model->get_student_info_by_reference_no($this->input->get('referenceNo'));

        if ($student_info == NULL) {
            $array_output['success'] = 0;
            $array_output['message'] = "No Data";
            echo json_encode($array_output);
            return;
        }
        $array_data = array(
            'sched_display_id' => $this->input->get('schedDisplayId'),
            'reference_no' => $this->input->get('referenceNo'),
            'student_no' => $student_info[0]['Student_Number'],
            'school_year' => $this->input->get('schoolYear'),
            'semester' => $this->input->get('semester'),
            'section' => $this->input->get('section'),
            'unittype' => $this->input->get('unittype'),
            'unitnumber' => ''
        );
        //$this->input->get('unittype') == 1 ? $this->unittypes['graduating'] : $this->unittypes['nongraduating']
        if ($this->input->get('unittype') == 1) {
            $array_data['unitnumber'] = $this->unittypes['graduating'];
        } else if ($this->input->get('unittype') == 0) {
            $array_data['unitnumber'] = $this->unittypes['nongraduating'];
        } else if ($this->input->get('unittype') == 2) {
            $array_data['unitnumber'] = $this->unittypes['pharma'];
        }

        //check if unit is checked
        if (!isset($array_data['unittype'])) {

            $array_output['success'] = 0;
            $array_output['message'] = "Please Choose if Student is Graduating or Non Graduating.";
            echo json_encode($array_output);
            return;
        }

        //check if course have pre req
        $course_info = $this->Course_Model->get_course_pre_req($array_data);
        if ($course_info == NULL) {
            # code...
            $array_output['success'] = 0;
            $array_output['message'] = "No Data";
            echo json_encode($array_output);
            return;
        }

        $array_data['course_code'] = $course_info[0]['subject'];

        //check if sched is already added
        $course_duplicate = $this->Student_Model->check_sched_session_duplicate($array_data);
        if ($course_duplicate != NULL) {
            $array_output['success'] = 0;
            $array_output['selected'] = 1;
            $array_output['message'] = $course_info[0]['subject'] . " is already selected.";
            echo json_encode($array_output);
            return;
        }


        //check if bypass is activated
        if (($this->session->advising_bypass) && ($this->session->advising_bypass['advising_bypass'] === true)) {
            # code...
            //insert bypass log
            $this->array_bypass_logs['bypassers_id'] = $this->session->advising_bypass['program_chair_id'];
            $this->array_bypass_logs['action'] = 'Added(' . $this->input->get('schedDisplayId') . ') Bypass(prerequisite)';
            $this->array_bypass_logs['reference_no'] = $this->input->get('referenceNo');
            $this->Module_Bypass_Model->insert_logs($this->array_bypass_logs);
            $this->session->unset_userdata('advising_bypass');
        }
        //check if the student passed the pre req course
        elseif ($course_info[0]['pre_req'] != NULL) {
            //insert bypass checker here
            if ($this->input->get('bypassCheck') === "1") {
                # code...
                $array_output['success'] = 2;
                $array_output['message'] = "Directing to Bypass Login";
                echo json_encode($array_output);
                return;
            } elseif ($student_info[0]['Reference_Number'] === 0) {
                $array_output['success'] = 0;
                $array_output['message'] = "Please enroll " . $course_info[0]['pre_req'] . " first.";
                echo json_encode($array_output);
                return;
            }

            //get student grades
            $array_data['course_code_pre_req'] = $course_info[0]['pre_req'];
            $student_course_result = $this->Student_Model->get_student_course_grade($array_data);

            //check if the student have taken the course
            if ($student_course_result == NULL) {
                $array_output['success'] = 0;
                $array_output['message'] = "Please enroll " . $course_info[0]['pre_req'] . " first.";
                echo json_encode($array_output);
                return;
            }

            //get legend data for bypass pre req req
            $legend_data = $this->Schedule_Model->get_legend();

            //remarks name
            if ($student_course_result[0]['Remarks_ID'] === 3) {
                # code...
                $remarks_type = "INC";
            } elseif ($student_course_result[0]['Remarks_ID'] === 8) {
                $remarks_type = "Ongoing";
            } elseif ($student_course_result[0]['Remarks_ID'] === 0) {
                $remarks_type = "Not yet Encoded";
            } elseif ($student_course_result[0]['Remarks_ID'] === 1) {
                # code...
                $remarks_type = "Passed";
            } else {
                # code...
                $remarks_type = "Failed";
            }

            //approve by using module bypass
            if ((($student_course_result[0]['Remarks_ID'] === 3) or ($student_course_result[0]['Remarks_ID'] === 8) or ($student_course_result[0]['Remarks_ID'] === 0)) && ($legend_data[0]['BypassPre'] === 1)) {
                # code...

                $array_output['message'] = "Note: The subject that you are trying to add have pre requisite of subject " . $course_info[0]['pre_req'] . " and is " . $remarks_type;
            } else
            //if($student_course_result[0]['Final_Grade'] < 75.00) //check if the student passed 
            {
                if (($student_course_result[0]['Remarks_ID'] === 3) or ($student_course_result[0]['Remarks_ID'] === 8) or ($student_course_result[0]['Remarks_ID'] === 0) or ($student_course_result[0]['Remarks_ID'] === 2)) {
                    # code...
                    $array_output['success'] = 0;
                    $array_output['message'] = "Cannot add the selected schedule because the status of the student's prerequisite subject is" . $course_info[0]['pre_req'] . ".";
                    echo json_encode($array_output);
                    return;
                }
            }
        }

        //check if there is still available slot

        $array_data['sched_code'] = $course_info[0]['Sched_Code'];

        $total_enrolled = $this->Schedule_Model->get_sched_total_enrolled_no_sd($array_data);
        $total_advised = $this->Schedule_Model->get_sched_total_advised($array_data);

        $consumed_slots = $total_enrolled[0]['total_enrolled'] + $total_advised[0]['total_advised'];

        $slot = $course_info[0]['Total_Slot'] -  $consumed_slots;
        //echo json_encode($array_output);
        if ($slot < 1) {
            $array_output['success'] = 0;
            $array_output['message'] = "The slot is full for " . $course_info[0]['subject'] . ". <br>Choose another schedule <br>(Advised: " . $total_advised[0]['total_advised'] . " , Enrolled: " . $total_enrolled[0]['total_enrolled'] . ")<br><br>";
            echo json_encode($array_output);
            return;
        }

        //check if there is conflict with other schedule
        $array_data['start_time'] = $course_info[0]['sched_start_time'];
        $array_data['end_time'] = $course_info[0]['sched_end_time'];
        $array_data['day_array'] = $course_info[0]['Day'];

        $conflict_check = $this->Student_Model->check_advising_conflict($array_data);
        if ($conflict_check) {
            $array_output['success'] = 0;
            $array_output['message'] = "Conflict with " . $conflict_check[0]['Course_Code'] . ". Choose another schedule";
            echo json_encode($array_output);
            return;
        }

        //Check if it exceeds unit count
        $unitcheck = $this->Student_Model->get_sched_session_units($array_data);
        $upcomingunit = $unitcheck[0]['total_units'] + ($course_info[0]['Course_Lec_Unit'] + $course_info[0]['Course_Lab_Unit']);
        if (!in_array($student_info[0]['Course'], $this->unit_excempted())) {
            if ($upcomingunit > $array_data['unitnumber']) {

                $array_output['success'] = 0;
                $array_output['message'] = "Failed to add " . $course_info[0]['subject'] . ", Exceeds maximun number of units (" . $array_data['unittype'] . ")";
                echo json_encode($array_output);
                return;
            }
        }


        //get year level
        //$year_level = $this->Student_Model->get_year_level($array_data);
        $year_level = $this->Student_Model->get_year_level_v2($array_data);
        if ($year_level[0]['Year_Level'] === 0) {
            $year_level[0]['Year_Level'] = 1;
        }

        //status
        if ($this->input->get('studType') === 'open') {
            $status = "IRREGULAR";
        } else {
            # code...
            $status = "REGULAR";
        }


        //add the sched to session
        $array_insert = array(
            'Reference_Number' => $this->input->get('referenceNo'),
            'Student_Number' => $student_info[0]['Student_Number'],
            'Sched_Code' => $course_info[0]['Sched_Code'],
            'Sched_Display_ID' => $this->input->get('schedDisplayId'),
            'Semester' => $array_data['semester'],
            'School_Year' => $array_data['school_year'],
            'Scheduler' => 'N/A',
            'Status' => $status,
            'Program' => $student_info[0]['Course'],
            'Major' => $student_info[0]['Major'],
            'Year_Level' => $year_level[0]['Year_Level'],
            'Section' =>  $this->input->get('section'),
            'Graduating' =>  $this->input->get('unittype'),
        );


        $this->Student_Model->insert_sched_session($array_insert);
        //print_r($array_insert);
        $array_output['success'] = 1;
        $array_output['message'] = "Added " . $course_info[0]['subject'] . " to the Queue!";
        echo json_encode($array_output);
        return;
    }

    //bypass 
    public function bypass_module_advising_login()
    {
        if (!$this->input->get('userName') || !$this->input->get('password') || !$this->input->get('referenceNo')) {

            # code...
            $array_output['success'] = 0;
            $array_output['message'] = "Incomplete data";
            echo json_encode($array_output);
            return;
        }
        $array_account = array(
            'username' => $this->input->get('userName'),
            'password' => $this->input->get('password')
        );


        //get student info
        $student_info = $this->Student_Model->get_student_info_by_reference_no($this->input->get('referenceNo'));

        if ($student_info == NULL) {
            $array_output['success'] = 0;
            $array_output['message'] = "No Data";
            echo json_encode($array_output);
            return;
        }

        //get student school
        $school_info = $this->Student_Model->get_student_school_info($student_info[0]['Course']);

        //get account info
        $user_info = $this->User_verification->get_user_info($array_account);

        if (!$user_info) {
            # code...
            $array_output['success'] = 0;
            $array_output['message'] = "Incorrect username or password";
            echo json_encode($array_output);
            return;
        }

        $user_access_array = array(
            'user_id' => $user_info[0]['User_ID'],
            'school_id' => $school_info[0]['School_ID']
        );

        //check if the user is the program chair of the given department
        $user_access_checker = $this->Module_Bypass_Model->get_advising_bypassers_access($user_access_array);

        //$user_info = $this->Module_Bypass_Model->get_program_chair_access($array_data);

        if ($user_access_checker) {
            # code...
            //set temporary session for bypass
            $array_session = array(
                'advising_bypass' => true,
                'program_chair_id' => $user_info[0]['User_ID']
            );
            $this->session->set_userdata('advising_bypass', $array_session);
            $array_output['success'] = 1;
            $array_output['message'] = "Success";
            echo json_encode($array_output);
            return;

            //$this->insert_sched_session();
        } else {
            $array_output['success'] = 0;
            $array_output['message'] = "User is not authorized tho use bypass function. ";
            echo json_encode($array_output);
            return;
        }
    }

    public function get_sched_data()
    {
        if (!$this->input->post('schedDisplayId')) {
            # code...
            $array_output['success'] = 0;
            $array_output['message'] = "Incomplete data";
            echo json_encode($array_output);
            return;
        }

        $array_output['output'] = $this->Schedule_Model->get_sched_info_by_sched_display_id($this->input->post('schedDisplayId'));
        $array_output['success'] = 1;
        echo json_encode($array_output);
        return;
    }

    public function get_student_advising_session()
    {
        if (($this->input->get('referenceNo') == NULL) or (!is_numeric($this->input->get('referenceNo')))) {
            echo 0;
            return;
        }
        $array_data = array(
            'reference_no' => $this->input->get('referenceNo')
        );

        $advising_session = $this->Student_Model->get_sched_session($array_data);

        echo json_encode($advising_session);
    }

    public function remove_advising_session()
    {
        $array_output = array();

        if (($this->input->get('sessionId') == NULL) or (!is_numeric($this->input->get('sessionId')))) {
            $array_output['success'] = 0;
            $array_output['message'] = "No Data";
            echo json_encode($array_output);
            return;
        }

        $array_data = array(
            'id' => $this->input->get('sessionId'),
        );

        $this->Student_Model->remove_advising_session($array_data);

        $array_output['success'] = 1;
        $array_output['message'] = "Success";
        echo json_encode($array_output);
        return;
    }

    public function display_fee($array_data)
    {
        //print_r($array_data).'<br>';
        if (($array_data['reference_no'] == '') or (!is_numeric($array_data['reference_no']))) {
            // Redirect to home page
            //redirect('Advising');
            $array_output['success'] = 0;
            $array_output['message'] = "error: no data";
            return;
        }
        //installment modifier
        $installment_interest = 1.05;

        //get student info
        $student_info = $this->Student_Model->get_student_info_by_reference_no($array_data['reference_no']);

        //get year level
        //$year_level = $this->Student_Model->get_year_level($array_data);
        $year_level = $this->Student_Model->get_year_level_v2($array_data);
        if ($year_level[0]['Year_Level'] === 0) {
            $year_level[0]['Year_Level'] = 1;
        }

        $array_data['program_code'] = $student_info[0]['Course'];
        $array_data['year_level'] = $year_level[0]['Year_Level'];

        //get advising session
        $advising_session = $this->Student_Model->get_sched_session($array_data);

        //compute total units
        $total_units = 0;
        foreach ($advising_session as $key => $sched) {
            # code...
            $total_units += $sched['Course_Lec_Unit'];
            $total_units += $sched['Course_Lab_Unit'];
        }

        //check if admitted sy is available
        if (($student_info[0]['AdmittedSY'] === 'N/A') || ($student_info[0]['AdmittedSY'] === 0)) {
            # code...
            $array_data['AdmittedSY'] =  $array_data['school_year'];
        } else {
            $array_data['AdmittedSY'] = $student_info[0]['AdmittedSY'];
        }

        //check if admitted sem is available
        //echo ' student info admitted sem:'.$student_info[0]['AdmittedSEM'].'<br>';
        if (($student_info[0]['AdmittedSEM'] == 'N/A') || ($student_info[0]['AdmittedSEM'] === 0)) {
            //echo 'enter admitted sem = n/a'.'<br>';
            # code...
            $array_data['AdmittedSEM'] =  $array_data['semester'];
        } else {
            $array_data['AdmittedSEM'] = $student_info[0]['AdmittedSEM'];
        }
        //$array_data['AdmittedSEM'] = $student_info[0]['AdmittedSEM'];
        //get fees details

        $array_fees = $this->Fees_Model->get_fees_without_admit($array_data);
        //print_r($array_data).'<br>';
        if ($array_fees == NULL) {
            # code...
            $array_output['success'] = 0;
            $array_output['message'] = "The selected fees was not yet set.";
            return;
        }
        $total_misc = 0;
        $total_other = 0;


        foreach ($array_fees as $key => $fees) {
            # code...
            if ($fees['Fees_Type'] === "MISC") {

                if ($array_data['plan'] === 'installment') {
                    $total_misc += ($fees['Fees_Amount'] * $installment_interest);
                } else {

                    $total_misc += $fees['Fees_Amount'];
                }
            } else {
                if ($array_data['plan'] === 'installment') {
                    $total_other += ($fees['Fees_Amount'] * $installment_interest);
                } else {
                    $total_other += $fees['Fees_Amount'];
                }
            }
        }

        //get subject other fee

        $array_subject_other_fee = $this->Fees_Model->get_subject_other_fee_session($array_data);
        foreach ($array_subject_other_fee as $key => $subject_other_fee) {
            # code...
            if ($array_data['plan'] === 'installment') {
                $total_other += ($subject_other_fee['Other_Fee'] * $installment_interest);
            } else {

                $total_other += $subject_other_fee['Other_Fee'];
            }
        }
        //check if student is a foreigner
        $foreigner_checker = $this->Student_Model->check_if_foreigner($array_data['reference_no']);

        if ($foreigner_checker === 1) {
            # code...
            #check if the foreigner selected the international program 
            $international_program_check = $this->Program_Model->check_international_program($array_data['program_code']);

            if (empty($international_program_check)) {
                # code...
                $foreign_fee = $this->Fees_Model->get_foreign_fee($array_data);

                if (!$foreign_fee) {
                    # code...
                    return;
                }

                if ($array_data['plan'] === 'installment') {
                    $total_other += ($foreign_fee[0]['Fees_Amount'] * $installment_interest);
                } else {
                    $total_other += $foreign_fee[0]['Fees_Amount'];
                }
            }


            //print "foreign fee <br/>";
            //print_r($foreign_fee);

        }



        $total_other = number_format($total_other, 2, '.', '');
        $total_misc = number_format($total_misc, 2, '.', '');

        //tuition fee
        $tuition = $array_fees[0]['TuitionPerUnit'] * $total_units;


        if ($array_data['plan'] === 'installment') {
            //$tuition += ($tuition * $installment_interest);
            $tuition *= $installment_interest;
        }
        $tuition = number_format($tuition, 2, '.', '');

        //get lab fee
        /*
        $lab_fees = $this->Fees_Model->get_lab_fee($array_data);
        $total_lab_fee = 0;
        foreach ($lab_fees as $key => $type) 
        {
            # code...
            if($array_data['plan'] === 'installment')
            {
                $total_lab_fee += ($type['Fee'] * $installment_interest );
            }
            else
            {
                $total_lab_fee += $type['Fee'];
            }
            
        }
        */

        //get subject lab fee
        $total_lab_fee = 0;

        $array_subject_lab_fee = $this->Fees_Model->get_subject_lab_fee_session($array_data);
        foreach ($array_subject_lab_fee as $key => $subject_lab_fee) {
            # code...
            if ($array_data['plan'] === 'installment') {
                $total_lab_fee += ($subject_lab_fee['Lab_Fee'] * $installment_interest);
            } else {

                $total_lab_fee += $subject_lab_fee['Lab_Fee'];
            }
        }


        $total_lab_fee = number_format($total_lab_fee, 2, '.', '');

        $total_fee = $total_other + $total_misc + $total_lab_fee + $tuition;

        $array_output = array(
            'success' => 1,
            'other_fee' => $total_other,
            'misc_fee' => $total_misc,
            'lab_fee' => $total_lab_fee,
            'tuition_fee' => $tuition,
            'total_fee' => $total_fee

        );
        /*
        $array_output = array(
            'success' => 1,
            'other_fee' => 5,
            'misc_fee' => 10, 
            'lab_fee' => 5, 
            'tuition_fee' => 6, 
            'total_fee' => 5
            
        );
        */
        return $array_output;

        //check student nationality

    }

    public function set_payment_plan()
    {
        $array_output['success'] = '';
        if (($this->input->get('referenceNo') == NULL) or (!is_numeric($this->input->get('referenceNo')))) {
            echo 0;
            return;
        }
        if (($this->input->get('plan') == NULL) or ($this->input->get('section') == NULL)) {
            echo 0;
            return;
        }
        if (($this->input->get('semester') == NULL) or ($this->input->get('schoolYear') == NULL)) {
            $array_output['success'] = 0;
            $array_output['message'] = "No Data";
            echo json_encode($array_output);
            return;
        }
        $array_data = array(
            'reference_no' => $this->input->get('referenceNo'),
            'plan' => $this->input->get('plan'),
            'school_year' => $this->input->get('schoolYear'),
            'semester' => $this->input->get('semester'),
            'section' => $this->input->get('section')
        );
        $array_fees = $this->display_fee($array_data);
        //check if array fees is available
        //$this->Fees_Model->get_fees_without_admit($array_data);
        if ($array_fees == NULL) {
            # code...
            //Get student info

            $student_info = $this->Student_Model->get_student_info_by_reference_no($array_data['reference_no']);
            $year_level = $this->Student_Model->get_year_level_v2($array_data);

            $array_output['success'] = 0;
            $array_output['message'] = "No Available Fees on:<br><br>";

            $array_output['message'] .= '- Section: <u>' . $year_level[0]['Section_Name'] . '</u><br>';

            $year_level = $this->Student_Model->get_year_level_v2($array_data);
            if ($year_level[0]['Year_Level'] === 0) {
                $year_level[0]['Year_Level'] = 1;
            }
            $array_output['message'] .= "- Year Level: <u>" . $year_level[0]['Year_Level'] . "</u><br>";

            if (($student_info[0]['AdmittedSY'] === 'N/A') || ($student_info[0]['AdmittedSY'] === 0)) {
                $array_output['message'] .= '- Admitted SY: <u>' . $array_data['school_year'] . ' none</u><br>';
            } else {
                $array_output['message'] .= '- Admitted SY: <u>' . $student_info[0]['AdmittedSY'] . '</u><br>';
            }

            if (($student_info[0]['AdmittedSEM'] === 'N/A') || ($student_info[0]['AdmittedSEM'] == '')) {
                $array_output['message'] .= '- Admitted SEM: <u>' . $array_data['semester'] . ' none</u><br>';
            } else {
                $array_output['message'] .= '- Admitted SEM: <u>' . $student_info[0]['AdmittedSEM'] . '</u><br>';
            }

            //check if student is a foreigner
            $foreigner_checker = $this->Student_Model->check_if_foreigner($array_data['reference_no']);

            if ($foreigner_checker === 1) {
                # code...
                //get foreign fee (other fee)

                $foreign_fee = $this->Fees_Model->get_foreign_fee($array_data);

                if (!$foreign_fee) {
                    # code...
                    $array_output['message'] .= '- Other Fee: <u>Foreign Fee</u> <br>';
                }
            }

            $array_output['message'] .= "</ul><br>
            <h4 style='color:#cc0000'>
            <b>Please Contact The Accounting Office.</b>
            </h2>";

            echo json_encode($array_output);
            return;
        }
        echo json_encode($array_fees);
    }

    public function advise_student()
    {
        echo '<br><br><br><br><br><br><br><br><br><br><br>';
        echo 'Schoolyear: ' . $this->input->post('school_year') . '<br>';
        echo 'Semester: ' . $this->input->post('semester') . '<br>';
        echo 'payment plan: ' . $this->input->post('payment') . '<br>';
        echo 'section: ' . $this->input->post('section') . '<br>';


        //rules for form validation
        $config = array(
            array(
                'field' => 'reference_no',
                'label' => 'Reference Number',
                'rules' => 'required|numeric'
            ),
            array(
                'field' => 'plan',
                'label' => 'Payment Plan',
                'rules' => 'required'
            ),
            array(
                'field' => 'payment',
                'label' => 'Payment',
                'rules' => 'required'
            ),
            array(
                'field' => 'school_year',
                'label' => 'School Year',
                'rules' => 'required'
            ),
            array(
                'field' => 'semester',
                'label' => 'Semester',
                'rules' => 'required'
            ),
            array(
                'field' => 'section',
                'label' => 'Section',
                'rules' => 'required'
            )
        );
        $this->form_validation->set_rules($config);
        //echo 'Reference: '.$this->input->post('reference_no').'<br>';
        //echo 'plan: '.$this->input->post('plan').'<br>';
        //echo 'payment: '.$this->input->post('payment').'<br>';
        if ($this->form_validation->run() == TRUE) {


            //get student info
            $student_info = $this->Student_Model->get_student_info_by_reference_no($this->input->post('reference_no'));

            //get current date time
            $datestring = "%Y-%m-%d %H:%i:%s";
            $time = time();
            $date_now = mdate($datestring, $time);

            //get current sem and sy
            //$array_legend = $this->Schedule_Model->get_legend();

            $array_data = array(
                'program_code' => $student_info[0]['Course'],
                'reference_no' => $this->input->post('reference_no'),
                'student_no' => $student_info[0]['Student_Number'],
                'date' => $date_now,
                'semester' => $this->input->post('semester'),
                'school_year' => $this->input->post('school_year'),
                'plan' => $this->input->post('plan'),
                'section' => $this->input->post('section'),
                'payment' => $this->input->post('payment'),
                'curriculum' => $this->input->post('curriculum'),
                'transaction_item' => "MATRICULATION",           //change later
                'transaction_type' => "CASH"                //change later

            );

            //check if admitted sy is available
            if (($student_info[0]['AdmittedSY'] === 'N/A') || ($student_info[0]['AdmittedSY'] === 0)) {
                # code...
                $array_data['AdmittedSY'] =  $array_data['school_year'];
            } else {
                $array_data['AdmittedSY'] = $student_info[0]['AdmittedSY'];
            }

            //check if admitted sem is available
            if (($student_info[0]['AdmittedSEM'] === 'N/A') || ($student_info[0]['AdmittedSEM'] === 0)) {
                # code...
                $array_data['AdmittedSEM'] =  $array_data['semester'];
            } else {
                $array_data['AdmittedSEM'] = $student_info[0]['AdmittedSEM'];
            }

            //get year level
            //$year_level = $this->Student_Model->get_year_level($this->input->post('reference_no'));
            $year_level = $this->Student_Model->get_year_level_v2($array_data);
            if ($year_level[0]['Year_Level'] === 0) {
                $year_level[0]['Year_Level'] = 1;
            }

            $array_data['year_level'] = $year_level[0]['Year_Level'];

            //check if the student is already advised
            $check_advised = $this->Student_Model->get_sched_advised($array_data);
            if ($check_advised != NULL) {
                # code...
                $array_data['check_advised'] = 1;

                //set the valid col of the tables
                //$this->array_logs['action'] = $this->Fees_Model->remove_payment_data($array_data);

                //logs
                //$this->Others_Model->insert_logs($this->array_logs);

                $this->array_logs['action'] = $this->Student_Model->remove_sched_info($array_data);

                //logs
                $this->Others_Model->insert_logs($this->array_logs);

                //get if for fees_temp_college_item
                $array_college_fees_data = $this->Fees_Model->get_fees_college_data($array_data);

                $array_data['fees_temp_college_id'] = $array_college_fees_data[0]['id'];

                //$this->Fees_Model->remove_fees_college_data($array_data);

                $this->array_logs['action'] = $this->Fees_Model->remove_fees_item($array_data['fees_temp_college_id']);

                //logs
                $this->Others_Model->insert_logs($this->array_logs);

                echo "enter readvised <br>";
            } else {
                # code...
                $array_data['check_advised'] = 0;
            }

            //insert student payment
            //$this->insert_payment_data($array_data);

            //insert sched info (advising)
            $this->insert_sched_info($array_data);

            //insert fees
            $this->insert_enrollment_fees($array_data);

            //update student information
            $this->update_student_info($array_data);

            $this->session->set_flashdata('advising_success', 'Student Advised! Proceed to Next Step');
            redirect('Advising/index/' . $student_info[0]['Student_Number']);
        } else {
            $this->session->set_flashdata('advising_error', validation_errors());
            //echo 'Failed Validation';
            //$this->render($this->set_views->advising());
            //redirect('Advising');
        }
    }

    public function insert_payment_data($array_data)
    {
        echo "enter insert payment function <br>";
        $array_insert = array(
            'Reference_Number' => $array_data['reference_no'],
            'Student_Number' => $array_data['student_no'],
            'AmountofPayment' => $array_data['payment'],
            'Transaction_Type' => $array_data['transaction_type'],
            'Transaction_Item' => $array_data['transaction_item'],
            'Semester' => $array_data['semester'],
            'SchoolYear' => $array_data['school_year'],
            'Date' => $array_data['date'],
        );

        //$this->array_logs['action'] = $this->Fees_Model->insert_payment_data($array_insert);

        //logs
        //$this->Others_Model->insert_logs($this->array_logs);

        return;
    }

    public function insert_sched_info($array_data)
    {
        $this->array_logs['action'] = $this->Student_Model->insert_sched_info($array_data);

        //logs
        $this->Others_Model->insert_logs($this->array_logs);

        //set session to zero
        //$this->Student_Model->delete_advising_session($array_data);

        return;
    }

    public function insert_enrollment_fees($array_data)
    {
        echo "enter insert enrollment fees <br>";
        $installment_interest = 1.05;

        //get computed fees
        $array_computed_fees = $this->display_fee($array_data);

        //print_r($array_data);
        //print_r($array_computed_fees);
        //break;

        if ($array_data['plan'] === 'installment') {
            //get installment plan formula
            $array_plan_formula = $this->Fees_Model->get_payment_plans();

            $array_data['initial_payment'] = number_format(($array_computed_fees['total_fee'] * ($array_plan_formula[0]['Upon_Registration'] / 100)), 2, '.', '');
            $array_data['first_payment'] = number_format(($array_computed_fees['total_fee'] * ($array_plan_formula[0]['First_Pay'] / 100)), 2, '.', '');
            $array_data['second_payment'] = number_format(($array_computed_fees['total_fee'] * ($array_plan_formula[0]['Second_Pay'] / 100)), 2, '.', '');
            $array_data['third_payment'] = number_format(($array_computed_fees['total_fee'] * ($array_plan_formula[0]['Third_Pay'] / 100)), 2, '.', '');
            $array_data['fourth_payment'] = number_format(($array_computed_fees['total_fee'] * ($array_plan_formula[0]['Fourth_Pay'] / 100)), 2, '.', '');

            $array_data['full_payment'] = 0;
        } else {
            $array_data['initial_payment'] = 0.00;
            $array_data['full_payment'] = 1;

            //check later. maybe wrong formula
            $array_data['initial_payment'] = $array_computed_fees['total_fee'];
            $array_data['first_payment'] = 0.00;
            $array_data['second_payment'] = 0.00;
            $array_data['third_payment'] = 0.00;
            $array_data['fourth_payment'] = 0.00;
        }

        //insert fee
        $array_insert_fee = array(
            'Reference_Number' => $array_data['reference_no'],
            'course' => $array_data['program_code'],
            'semester' => $array_data['semester'],
            'schoolyear' => $array_data['school_year'],
            'YearLevel' => $array_data['year_level'],
            'fullpayment' => $array_data['full_payment'],
            'tuition_Fee' => $array_computed_fees['tuition_fee'],
            'InitialPayment' => $array_data['initial_payment'],
            'First_Pay' => $array_data['first_payment'],
            'Second_Pay' => $array_data['second_payment'],
            'Third_Pay' => $array_data['third_payment'],
            'Fourth_Pay' => $array_data['fourth_payment']
        );

        //check if there is data in Fees temp college 
        $array_college_fees_data = $this->Fees_Model->get_fees_college_data($array_data);
        if ($array_college_fees_data != NULL) {
            # code...
            $array_data['fees_temp_college_id'] = $array_college_fees_data[0]['id'];
        }

        if (($array_data['check_advised'] === 1) && ($array_college_fees_data != NULL)) {

            //replace the fees_temp_college data
            $this->array_logs['action'] = $this->Fees_Model->replace_fees_college_data($array_insert_fee, $array_data);
            //logs
            $this->Others_Model->insert_logs($this->array_logs);
            echo "enter check advised replace fees data <br>";
        } else {
            # code...
            //insert to fees temp college and get id
            $array_fees_data = $this->Fees_Model->insert_fees_college($array_insert_fee);
            $array_data['fees_temp_college_id'] = $array_fees_data['insert_id'];
            $this->array_logs['action'] = $array_fees_data['query_log'];

            //print_r($this->array_logs)."<br>";

            //logs
            $this->Others_Model->insert_logs($this->array_logs);
        }

        //get fees details
        $array_fees = $this->Fees_Model->get_fees_without_admit($array_data);
        //print_r($array_data)."<br>";
        //print_r($array_fees)."<br>";
        foreach ($array_fees as $key => $fees) {
            # code...

            if ($array_data['plan'] === 'installment') {
                $fees['Fees_Amount'] *= $installment_interest;
            }

            $array_fees_item[] = array(
                'Fees_Temp_College_Id' => $array_data['fees_temp_college_id'],
                'Fees_Type' => $fees['Fees_Type'],
                'Fees_Name' => $fees['Fees_Name'],
                'Fees_Amount' => $fees['Fees_Amount']
            );
        }

        //get foreign fee
        //check if student is a foreigner
        $foreigner_checker = $this->Student_Model->check_if_foreigner($array_data['reference_no']);
        if ($foreigner_checker === 1) {
            # code...
            #check if the foreigner selected the international program 
            $international_program_check = $this->Program_Model->check_international_program($array_data['program_code']);

            if (empty($international_program_check)) {
                # code...
                $foreign_fee = $this->Fees_Model->get_foreign_fee($array_data);

                if (!$foreign_fee) {
                    # code...
                    return;
                }

                if ($array_data['plan'] == 0) {
                    $foreign_fee[0]['Fees_Amount'] *= $this->installment_interest;
                }

                $array_fees_item[] = array(
                    'Fees_Temp_College_Id' => $array_data['fees_temp_college_id'],
                    'Fees_Type' => $foreign_fee[0]['Fees_Type'],
                    'Fees_Name' => $foreign_fee[0]['Fees_Name'],
                    'Fees_Amount' => $foreign_fee[0]['Fees_Amount']
                    //'valid' => 1
                );
            }
        }

        //get subject other fee

        $array_subject_other_fee = $this->Fees_Model->get_subject_other_fee_advised($array_data);

        if ($array_subject_other_fee != NULL) {
            # code...
            foreach ($array_subject_other_fee as $key => $subject_other_fee) {
                # code...
                if ($array_data['plan'] === 'installment') {
                    $subject_other_fee['Other_Fee'] *= $installment_interest;
                }

                $array_fees_item[] = array(
                    'Fees_Temp_College_Id' => $array_data['fees_temp_college_id'],
                    'Fees_Type' => 'OTHER',
                    'Fees_Name' => $subject_other_fee['Subject_Type'],
                    'Fees_Amount' => $subject_other_fee['Other_Fee']
                );
            }
        }

        //get subject lab fee
        $total_lab_fee = 0;

        $array_subject_lab_fee = $this->Fees_Model->get_subject_lab_fee_advised($array_data);

        if ($array_subject_lab_fee != NULL) {
            # code...

            foreach ($array_subject_lab_fee as $key => $subject_lab_fee) {
                # code...
                if ($array_data['plan'] === 'installment') {
                    $subject_lab_fee['Lab_Fee'] *= $installment_interest;
                }
                $array_fees_item[] = array(
                    'Fees_Temp_College_Id' => $array_data['fees_temp_college_id'],
                    'Fees_Type' => 'LAB',
                    'Fees_Name' => $subject_lab_fee['Subject_Type'],
                    'Fees_Amount' => $subject_lab_fee['Lab_Fee']
                );
            }
        }

        //get lab fee
        /*
        $lab_fees = $this->Fees_Model->get_lab_fee($array_data);
        foreach ($lab_fees as $key => $type) 
        {
            # code...
            if($array_data['plan'] === 'installment')
            {
                $type['Fee'] *= $installment_interest;
            }

            $array_fees_item[] = array(
                'Fees_Temp_College_Id' => $array_data['fees_temp_college_id'],
                'Fees_Type' => 'LAB',
                'Fees_Name' => $type['subjecttype'],
                'Fees_Amount' => $type['Fee']
            );
    
        }
        */
        //insert batch 
        //print_r($array_fees_item)."<br>";
        $this->array_logs['action'] = $this->Fees_Model->insert_fees_item($array_fees_item);

        //logs
        $this->Others_Model->insert_logs($this->array_logs);

        //set session to zero ()
        $this->array_logs['action'] = $this->Student_Model->delete_advising_session($array_data);

        //logs
        $this->Others_Model->insert_logs($this->array_logs);

        return;
    }

    public function update_student_info($array_data)
    {
        //check if student have student number
        if ($array_data['student_no'] === 0) {
            $this->array_logs['action'] = $this->Student_Model->update_student_curriculum($array_data);

            //logs
            $this->Others_Model->insert_logs($this->array_logs);
        }
    }

    public function get_curriculum_info()
    {
        if (($this->input->get('curriculum') == NULL) or (!is_numeric($this->input->get('curriculum')))) {
            // Redirect to home page
            //redirect('Advising');
            echo $this->input->get('curriculum');
            //return;
        }
        $array_curriculum_info = $this->Student_Model->get_student_curriculum($this->input->get('curriculum'));
        echo json_encode($array_curriculum_info);
    }

    public function checker()
    {

        $array_data = array(
            'reference_no' => 19110,
            'section' => 142,
            'semester' => 'SECOND',
            'school_year' => '2018-2019'
        );
        //print_r($array_data).'<br>';

        $data = $this->display_fee($array_data);
        //print_r($data).'<br>';
        //echo $this->Schedule_Model->get_sched_open_row_count();

        /*$course_duplicate = $this->Student_Model->check_sched_session_duplicate($array_data);
        if ($course_duplicate != NULL) 
        {
            # code...
            echo 'conflict';
        }
        //
        /*
        print_r ($array_data);
        $course_duplicate = $this->Student_Model->check_sched_session_duplicate($array_data);
        if($course_duplicate != NULL)
        {
           echo "duplicate";
           //print_r ($course_duplicate);
        }
        else
        {
            echo "no dup";
            //print_r ($course_duplicate);
        }
        */
        //$array_data = array('reference_no' => 15000002 );
        //$this->display_fee($array_data);
        /*
        $student_info = $this->Student_Model->get_student_info_by_reference_no(15000002);

        $enroll_check = $this->Student_Model->check_student_enrolled($student_info[0]['Reference_Number']);
        if ($enroll_check != NULL) 
        {
            # code...
            echo "error: The student is already enrolled";
        }
        */
    }

    public function unitcheck_directory()
    {

        //rules for form validation
        $config = array(
            array(
                'field' => 'sem',
                'label' => 'Semester',
                'rules' => 'required'
            ),
            array(
                'field' => 'sy',
                'label' => 'School Year',
                'rules' => 'required'
            ),
            array(
                'field' => 'units',
                'label' => 'Units',
                'rules' => 'required|numeric'
            )
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == TRUE) {

            $sem = $this->input->post('sem');
            $sy = $this->input->post('sy');
            $units = $this->input->post('units');

            $filterbutton = $this->input->post('filterbutton');
            $printbutton = $this->input->post('printbutton');
            if (isset($filterbutton)) {

                redirect($this->router->fetch_class() . '/unitcheck/' . $sem . '/' . $sy . '/' . $units, 'refresh');
            }
            if (isset($printbutton)) {

                $this->unitcheck_excel($sem, $sy, $units);
            }
        } else {

            $this->session->set_flashdata('message', validation_errors());
            redirect($this->router->fetch_class() . '/unitcheck');
        }
    }
    public function unitcheck($sem = '', $sy = '', $exceed = '')
    {

        $array = array(

            'sem' => $sem,
            'sy' => $sy,
            'units' => $exceed

        );
        $this->data['inputs'] = $array;
        $this->data['sem'] = $this->Discrepancy_Check->semchoice();
        $this->data['sy'] = $this->Discrepancy_Check->sychoice();
        $this->data['list'] = $this->Discrepancy_Check->exceeding_units($array);
        $this->render($this->set_views->unitcount());
    }

    public function unitcheck_excel($sem = '', $sy = '', $exceed = '')
    {

        $array = array(

            'sem' => $sem,
            'sy' => $sy,
            'units' => $exceed

        );

        $this->data['list'] = $this->Discrepancy_Check->exceeding_units($array);

        $object = new Spreadsheet();
        $object->setActiveSheetIndex(0);

        //Width adjustment
        $object->getActiveSheet()->getColumnDimensionByColumn('A')->setAutoSize(false);
        $object->getActiveSheet()->getColumnDimensionByColumn('B')->setAutoSize(false);
        $object->getActiveSheet()->getColumnDimensionByColumn('C')->setAutoSize(false);
        $object->getActiveSheet()->getColumnDimensionByColumn('D')->setAutoSize(false);
        $object->getActiveSheet()->getColumnDimensionByColumn('E')->setAutoSize(false);
        $object->getActiveSheet()->getColumnDimensionByColumn('F')->setAutoSize(false);
        $object->getActiveSheet()->getColumnDimensionByColumn('G')->setAutoSize(false);
        $object->getActiveSheet()->getColumnDimension('A')->setWidth(10);
        $object->getActiveSheet()->getColumnDimension('B')->setWidth(10);
        $object->getActiveSheet()->getColumnDimension('C')->setWidth(10);
        $object->getActiveSheet()->getColumnDimension('D')->setWidth(10);
        $object->getActiveSheet()->getColumnDimension('E')->setWidth(10);
        $object->getActiveSheet()->getColumnDimension('F')->setWidth(10);
        $object->getActiveSheet()->getColumnDimension('G')->setWidth(10);

        $object->getActiveSheet()->mergeCells('A1:G1');
        $object->getActiveSheet()->setCellValue('A1', 'STUDENTS MORE THAN ' . $array['units'] . ' UNITS');
        $object->getActiveSheet()->mergeCells('A2:C2');
        $object->getActiveSheet()->setCellValue('A2', 'SEMESTER: ' . $array['sem']);
        $object->getActiveSheet()->mergeCells('D2:G2');
        $object->getActiveSheet()->setCellValue('D2', 'A.Y.: ' . $array['sy']);
        $object->getActiveSheet()->mergeCells('A3:G3');
        $object->getActiveSheet()->setCellValue('A3', '  ');
        $object->getActiveSheet()->setCellValue('A4', '#');
        $object->getActiveSheet()->setCellValue('B4', 'Student Number');
        $object->getActiveSheet()->setCellValue('C4', 'Name');
        $object->getActiveSheet()->setCellValue('D4', 'Section');
        $object->getActiveSheet()->setCellValue('E4', 'Status');
        $object->getActiveSheet()->setCellValue('F4', 'YearLevel');
        $object->getActiveSheet()->setCellValue('G4', 'Units');


        $count = 1;

        $excel_row = 5;
        foreach ($this->data['list']['array'] as $row) {
            $object->getActiveSheet()->setCellValue('A' . $excel_row, $count);
            $object->getActiveSheet()->setCellValue('B' . $excel_row, $row['Student_Number']);
            $object->getActiveSheet()->setCellValue('C' . $excel_row, $row['First_Name'] . ' ' . $row['Middle_Name'] . ' ' . $row['Last_Name']);
            $object->getActiveSheet()->setCellValue('D' . $excel_row, $row['Section_Name']);
            $object->getActiveSheet()->setCellValue('E' . $excel_row, $row['Status']);
            $object->getActiveSheet()->setCellValue('F' . $excel_row, $row['Year_Level']);
            $object->getActiveSheet()->setCellValue('G' . $excel_row, $row['SUBJECT_UNIT']);

            $excel_row++;

            $count = $count + 1;
        }

        $object_writer = new \PhpOffice\PhpSpreadsheet\Writer\Xls($object);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="ExceedingUnits.xls"');
        $object_writer->save('php://output');
    }

    public function curriculum_check()
    {

        $array['student_number'] = $this->input->get('student_number');
        $array['curriculum_id'] = $this->input->get('curriculum');
        $result = $this->Curriculum_Model->subject_list_and_grades($array);
        if ($result == 0) {
            echo 0;
            return;
        }
        echo json_encode($result);
    }
    //ASSESSMENT FORM
    public function temporary_regform_ajax()
    {

        $reference_number = $this->input->get('ref_num');
        if ($reference_number != '') {

            /*
            $legend = $this->Schedule_Model->get_legend();
            $array = array(
                'sy' => $legend[0]['School_Year'],
                'sem' => $legend[0]['Semester'],
                'refnum' => $reference_number
            );
            //Checks if already advised
            $legend = $this->Schedule_Model->get_legend();
            $searcharray = array(
                'Reference_Number' => $this->data['student_info'][0]['Reference_Number'],
                'School_Year' => $legend[0]['School_Year'],
                'Semester' => $legend[0]['Semester']
            );
            */
            $searcharray['Reference_Number'] = $reference_number;
            $AdvisedCheck = $this->Student_Model->check_advised($searcharray);
            $array = array(
                'sy' => $AdvisedCheck[0]['School_Year'],
                'sem' => $AdvisedCheck[0]['Semester'],
                'refnum' => $reference_number
            );
            $data['get_Advise'] = $this->RegForm_Model->Get_advising_ajax($array);

            foreach ($data['get_Advise']  as $row) {
                $section         = $row->Section_Name;
                $course        = $row->Course;
                $sem           = $row->Semester;
                $sy            = $row->School_Year;
                $yl            = $row->YL;
                $ref_num       = $row->Reference_Number;
                $stu_num       = $row->Student_Number;
                $admmitedSy    = $row->AdmittedSY;
                $admmitedSem    = $row->AdmittedSEM;
            }
            $data['get_TotalCountSubject']       = $this->RegForm_Model->Get_CountSubject_Advising_TRF($stu_num, $sem, $sy);
            $data['get_labfees']                 = $this->RegForm_Model->Get_LabFeesAdvising_TRF($ref_num, $course, $sem, $sy, $yl);
            $data['get_miscfees']                = $this->RegForm_Model->Get_MISC_FEE_TRF($ref_num, $course, $sem, $sy, $yl);
            $data['get_otherfees']                = $this->RegForm_Model->Get_OTHER_FEE_TRF($ref_num, $course, $sem, $sy, $yl);
            $data['get_tuitionfee']              = $this->RegForm_Model->Get_Tuition_FEE_TRF($course, $sem, $sy, $yl, $ref_num, $admmitedSy, $admmitedSem);
            //$data['get_totalcash']               = $this->RegForm_Model->Get_Total_CashPayment($ref_num,$sem,$sy);
            $data['get_totalunits']               = $this->RegForm_Model->totalUnitsAdvising_TRF($array);
            echo json_encode($data);
        }
    }
    public function print_logs()
    {

        $ref = $this->input->get('ref');
        $sy = $this->input->get('sy');
        $sm = $this->input->get('sm');

        //$this->array_logs['action'] = 'Printed Assessment Form For:'+$ref+','+$sy+':'+$sm;
        $this->array_logs['action'] = 'Printed Assessment Form. Reference Number:' . $ref . ', ' . $sy . ':' . $sm;
        $this->Others_Model->insert_logs($this->array_logs);
    }
    //ASSESSMENT FORM
    //Curriculum List
    public function Curriculum()
    {
        $this->data['program'] = $this->Curriculum_Model->curriculum_lists_dropdowns();
        $this->data['curriculum_year'] = $this->Curriculum_Model->curriculum_lists_dropdown();
        $this->data['curriculum_list'] = $this->Curriculum_Model->curriculum_lists();
        $this->render($this->set_views->CurriculumList());
    }
    public function CurriculumCourseList()
    {

        $this->data['curriculum_course_list'] = $this->Curriculum_Model->subject_list();
        $this->render($this->set_views->Curriculum_course_list());
    }
    //Curriculum List

    //Schedule Report and Excel export
    public function SchedReport()
    {
        $this->data['programs'] = $this->Program_Model->get_program_list();
        $this->render($this->set_views->SchedReport());
    }
    public function ajax_SchedReport_Excel()
    {

        $array_data = array(
            'search' => $this->input->get('searchkey'),
            'program' => $this->input->get('program'),
            'semester' => $this->input->get('sem'),
            'sy' => $this->input->get('sy')
        );

        //Save another log
        $this->array_logs['action'] =  'Printed Schedule Report of: ' . $array_data['sy'] . ':' . $array_data['semester'] . ':' . $array_data['program'] . ':' . $array_data['search'];
        //Logs
        $this->Others_Model->insert_logs($this->array_logs);

        $object = new Spreadsheet();
        $object->setActiveSheetIndex(0);
        $table_columns = array("Sched Code", "Subject Code", "Subject Title", "Section", "Lec Unit", "Lab Unit", "Total Slot", "Remaining Slot", "Enrolled", "Day", "Time", "Room", "Instructor");

        $column = 0;
        foreach ($table_columns as $field) {
            $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
            $column++;
        }
        $this->data['Sched_report'] = $this->Room_Model->get_schedule_list_search_program($array_data);

        $count = 0;
        $times = array();
        $timesassign = array();
        $object_writer = '';
        $excel_row = 2;
        foreach ($this->data['Sched_report'] as $row) {

            $sess['sched_code'] = $row['Sched_Code'];
            $sess['sched_display_id'] = $row['sched_display_id'];
            $sess['school_year'] = $array_data['sy'];
            $sess['semester'] = $array_data['semester'];
            //echo 'SC: '.$row['Sched_Code'];
            $times['start'] = $this->dateconverter->MilitaryToStandard($row['START']);
            $times['end'] = $this->dateconverter->MilitaryToStandard($row['END']);

            $total_enrollees_array = $this->Schedule_Model->get_sched_total_enrolled_no_sd($sess)[0]['total_enrolled'];
            $total_advised_array = $this->Schedule_Model->get_sched_total_advised($sess)[0]['total_advised'];
            $total_slot_consumed = $total_enrollees_array + $total_advised_array;

            $count++;

            $Difference = $row['Total_Slot'] - $total_slot_consumed;

            $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row['Sched_Code']);
            $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row['Course_Code']);
            $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row['Course_Title']);
            $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row['Section_Name']);
            $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $row['Course_Lec_Unit']);
            $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $row['Course_Lab_Unit']);
            $object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $row['Total_Slot']);
            $object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row,  $Difference);
            $object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, $total_slot_consumed);
            $object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, $row['Day']);
            $object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, $times['start'] . '-' . $times['end']);
            $object->getActiveSheet()->setCellValueByColumnAndRow(11, $excel_row, $row['Room']);
            $object->getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row, $row['Instructor_Name']);
            $excel_row++;
        }

        $object_writer = new \PhpOffice\PhpSpreadsheet\Writer\Xls($object);
        /*
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="Schedule_Report.xls"');
            $object_writer->save('php://output');
            */
        ob_start();
        $object_writer->save("php://output");
        $xlsData = ob_get_contents();
        ob_end_clean();

        $response =  array(
            'op' => 'ok',
            'file' => "data:application/vnd.ms-excel;base64," . base64_encode($xlsData)
        );

        die(json_encode($response));
    }
    public function ajax_schedreport_search()
    {

        $array_data = array(
            'search' => $this->input->get('searchkey'),
            'program' => $this->input->get('program'),
            'semester' => $this->input->get('sem'),
            'sy' => $this->input->get('sy'),
            'offset' => $this->input->get('offset'),
            'perpage' => $this->input->get('perpage')
        );
        $sched = $this->Room_Model->get_schedule_list_search_program($array_data);
        foreach ($sched as $row) {

            $sess['sched_code'] = $row['Sched_Code'];
            $sess['sched_display_id'] = $row['sched_display_id'];
            $sess['school_year'] = $array_data['sy'];
            $sess['semester'] = $array_data['semester'];

            $total_enrolled = $this->Schedule_Model->get_sched_total_enrolled_no_sd($sess)[0]['total_enrolled'];
            $total_advised = $this->Schedule_Model->get_sched_total_advised($sess)[0]['total_advised'];
            //echo $total_advised;
            $total_enrollees_array[$sess['sched_code']] =  $total_enrolled + $total_advised;
            //echo $sess['sched_code'].':'.$sess['sched_display_id'].'<br>';

        }
        $result = array(

            'sched' => $sched,
            'total_enrolled' => $total_enrollees_array,

        );
        echo json_encode($result);
    }
    public function ajax_schedreport_search_pagination()
    {
        $array_data = array(
            'search' => $this->input->get('searchkey'),
            'semester' => $this->input->get('sem'),
            'sy' => $this->input->get('sy'),
            'program' => $this->input->get('program')
        );
        $pages = $this->Room_Model->get_schedule_list_search_program_count($array_data);

        echo $pages;
    }
    //Schedule Report and Excel export

    //CLASS LISTING MODULE
    public function Class_List_Report()
    {
        $ClassList_Button    = $this->input->post('submit');
        $ClassList_Excel     = $this->input->post('export');


        //Checker of pages
        if (isset($ClassList_Button)) {
            $this->Class_Listing();
        } else if (isset($ClassList_Excel)) {
            //Checker if no Ref number in textbox
            $this->Class_Listing_Excel();
        }
    }
    public function Class_Listing()
    {

        $array = array(
            'sc'          => $this->input->post('sched_code')
        );
        $this->data['ClassList'] = $this->Class_List_Model->get_class_list($array);
        $this->render($this->set_views->classlistingReport());
    }
    public function getmaxunits()
    {

        echo json_encode($this->unittypes);
    }
    public function Class_Listing_Excel()
    {

        //echo $this->input->post('sched_code').'test';

        $array = array(
            'sc'     => $this->input->post('sched_code')
        );

        $this->data['ClassList'] = $this->Class_List_Model->get_class_list($array);

        foreach ($this->data['ClassList']  as $row) {
            $sc      = $row->Sched_Code;
            $sy      = $row->SchoolYear;
            $sem     = $row->Semester;
            $section = $row->Section;
            $cc      = $row->Course_Code;
            $yl      = $row->Year_Level;
            $st      = $row->Startime;
            $et      = $row->Endtime;
            $day     = $row->Day;
            $ct      = $row->Course_Title;
            $room    = $row->Room;
            $lec     = $row->Course_Lec_Unit;
            $lab     = $row->Course_Lab_Unit;
            $Ins     = $row->Instructor_Name;

            $totalUnits = $lec + $lab;
        }


        $object = new Spreadsheet();
        $object->setActiveSheetIndex(0);
        $object->getActiveSheet()->mergeCells('A1:E1');
        $object->getActiveSheet()->setCellValue('A1', 'OFFICIAL CLASS LIST');
        $object->getActiveSheet()->mergeCells('A2:B2');
        $object->getActiveSheet()->setCellValue('A2', 'SEMESTER: ' . $sem . '');
        $object->getActiveSheet()->mergeCells('D2:E2');
        $object->getActiveSheet()->setCellValue('D2', 'ACADEMIC YEAR: ' . $sy . '');
        $object->getActiveSheet()->mergeCells('A3:E3');
        $object->getActiveSheet()->setCellValue('A3', '  ');
        $object->getActiveSheet()->setCellValue('A4', 'Schedule Code:');
        $object->getActiveSheet()->setCellValue('B4', '' . $sc . '');
        $object->getActiveSheet()->setCellValue('A5', 'Course Code:');
        $object->getActiveSheet()->setCellValue('B5', '' . $cc . '');
        $object->getActiveSheet()->setCellValue('A6', 'Course Description:');
        $object->getActiveSheet()->setCellValue('B6', '' . $ct . '');
        $object->getActiveSheet()->setCellValue('A7', 'Units:');
        $object->getActiveSheet()->setCellValue('B7', '' . $totalUnits . '');
        $object->getActiveSheet()->setCellValue('A8', 'Instructor:');
        $object->getActiveSheet()->setCellValue('B8', '' . $Ins . '');
        $object->getActiveSheet()->setCellValue('A9', 'Day:');
        $object->getActiveSheet()->setCellValue('B9', '' . $day . '');
        $object->getActiveSheet()->setCellValue('D9', 'Time:');
        $object->getActiveSheet()->setCellValue('E9', '' . $st . '-' . $et . '');
        $object->getActiveSheet()->setCellValue('A10', 'Section:');
        $object->getActiveSheet()->setCellValue('B10', '' . $section . '');
        $object->getActiveSheet()->setCellValue('D10', 'Room:');
        $object->getActiveSheet()->setCellValue('E10', '' . $room . '');
        $object->getActiveSheet()->setCellValue('A12', '#');
        $object->getActiveSheet()->setCellValue('B12', 'Student Number');
        $object->getActiveSheet()->setCellValue('C12', 'Name');
        $object->getActiveSheet()->setCellValue('D12', 'Year Level');
        $object->getActiveSheet()->setCellValue('E12', 'Program');



        $array = array('A1', 'A12', 'B12', 'C12', 'D12', 'E12');
        foreach ($array  as $columnID) {
            $object->getActiveSheet()->getStyle($columnID)->getAlignment()
                ->setHorizontal('center');
        }

        // SIZE OF COLUMN
        $array = array('B4', 'B7');
        foreach ($array  as $columnID) {
            $object->getActiveSheet()->getStyle($columnID)->getAlignment()
                ->setHorizontal('left');
        }


        //SIZE OF COLUMN
        foreach (range('A', 'G') as $columnID) {
            $object->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(TRUE);
        }


        $column = 0;
        foreach ($table_columns as $field) {
            $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
            $column++;
        }

        $count = 1;

        $excel_row = 13;
        foreach ($this->data['ClassList']  as $row) {
            $object->setActiveSheetIndex()->getStyle('' . $excel_row . '')->getAlignment()
                ->setHorizontal('left');
            $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $count);
            $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->Student_Number);
            $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, strtoupper($row->Last_Name . ' ,' . $row->First_Name . ' ' . $row->Midde_Name));
            $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row->Year_Level);
            $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $row->Program);

            $excel_row++;

            $count = $count + 1;
        }

        $object_writer = new \PhpOffice\PhpSpreadsheet\Writer\Xls($object);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Sched Code(' . $sc . ').xls"');
        $object_writer->save('php://output');
    }
    public function unit_excempted($ajax = '')
    {

        $unit_exception = array(

            0 => 'CGNCII'

        );

        if ($ajax == 1) {
            echo json_encode($unit_exception);
        } else {
            return $unit_exception;
        }
    }

    public function GetBalanceExemption()
    {

        $searcharray = array(
            'Reference_Number' => $this->input->get('Reference_Number'),
            'Student_Number' => $this->input->get('Student_Number'),
            'SchoolYear' => $this->input->get('SchoolYear'),
            'Semester' => $this->input->get('Semester')
        );
        echo $this->Student_Balance_Model->GetExcludedStudents($searcharray);
    }

    public function GetAvailableCourses()
    {

        echo json_encode($this->Course_Model->get_course_choices());
    }
    public function GetAvailableMajors()
    {

        $Program = $this->input->get_post('Program');
        echo json_encode($this->Course_Model->get_major_choices($Program));
    }
    public function UpdateStudentCourse_Advising()
    {

        $output = array(
            'Error' => 0,
            'Message' => '',
        );
        $Reference_Number = $this->input->post('student_ref');
        $legend = $this->Schedule_Model->get_legend()[0];
        $input = array(
            'Course' => $this->input->post('Program_Manual_Input'),
            'Major' => $this->input->post('Major_Manual_Input'),
            'AdmittedSY' => $legend['School_Year'],
            'AdmittedSEM' => $legend['Semester']
        );
        if ($input['Course'] == null) {

            $output['Message'] = 'Error in updating Course: No Course chosen';
            $output['Error'] = 1;
        }
        if ($Reference_Number == null || $Reference_Number == 0 || $Reference_Number == '') {

            $output['Message'] = 'Error in updating Course: Invalid Reference Number';
            $output['Error'] = 1;
        } else {

            $updateStatus = $this->Course_Model->student_course_update($Reference_Number, $input);
            if ($updateStatus == TRUE) {
                $output['Message'] = 'Student Course Updated! You may now advise the Student';
            } else {
                $output['Message'] = 'Error in updating Course';
                $output['Error'] = 1;
            }
            //logs
            $this->array_logs['action'] = 'Manually Encoded Course of Reference number: ' . $Reference_Number . ' to ' . $input['Course'] . ' with the Major ID of: ' . $input['Major'];
            $this->Others_Model->insert_logs($this->array_logs);

            $this->session->set_flashdata('advising_success', $output['Message']);
        }

        redirect('Advising/index/' . $Reference_Number);
    }
}
