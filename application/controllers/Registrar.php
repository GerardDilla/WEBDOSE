<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\HeaderFooterDrawing;
use PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf;

class Registrar extends MY_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->library('set_views');
    // $this->load->library("Excel");
    $this->load->library("DateConverter");
    $this->load->model('Registrar_Models/Room_Model');
    $this->load->model('Registrar_Models/Registrar_Model');
    $this->load->model('Registrar_Models/Actionlogs_Model');
    $this->load->model('Registrar_Models/Ched_Report_Model');
    $this->load->model('Registrar_Models/RegForm_Model');
    $this->load->model('Registrar_Models/Curriculum_Model');
    $this->load->model('Registrar_Models/SchedReport_Model');
    $this->load->model('Registrar_Models/Enroll_Summary_Model');
    $this->load->model('Registrar_Models/DroppingSubjects_Model');
    $this->load->model('Registrar_Models/Class_List_Model');
    $this->load->model('Registrar_Models/ChangeSection_Model');
    $this->load->model('Registrar_Models/ChangeSubject_Model');
    $this->load->model('Registrar_Models/EnrolledStudent_Model');
    $this->load->model('Registrar_Models/Student_Model');
    $this->load->model('Advising_Model/Schedule_Model');
    $this->load->model('Advising_Model/Student_Model');
    $this->load->model('Advising_Model/Program_Model');
    $this->load->model('Registrar_Models/SubjectEdit_Model');
    $this->load->model('Registrar_Models/EnrolledStudentShs_Model');
    $this->load->model('Registrar_Models/EnrolledStudentBed_Model');
    $this->load->model('Registrar_Models/Set_Major_Model');
    $this->load->model('Registrar_Models/EnrolledStudent_Foreign_Model');

    //$this->load->model('Advising_Model/Fees_Model');
    $this->load->model('Registrar_Models/Fees_Model');
    $this->load->model('Others_Model');

    //check if user is logged on
    $this->load->library('set_custom_session');
    $this->load->library('pagination');
    $this->admin_data = $this->set_custom_session->admin_session();

    //user accessibility
    $this->load->library('User_accessibility');
    $this->user_accessibility->module_registrar_access($this->admin_data['userid']);

    //set date
    $datestring = "%Y-%m-%d %h:%i";
    $date_only = "%Y-%m-%d";
    $time = time();
    $this->date_time = mdate($datestring, $time);
    $this->date = mdate($date_only, $time);

    //set logs
    $this->array_logs = array(
      'user_id' => $this->admin_data['userid'],
      'module' => 'Scheduling',
      'transaction_date' => $this->date_time,
    );

    $this->installment_interest = 1.05;
  }
  public function RoomView()
  {
    $this->data['time'] = $this->Room_Model->Get_time();
    $this->data['Room'] = $this->Room_Model->Get_room();
    $this->render($this->set_views->room_view());
  }

  public function Create_Sched($program = "", $section = "", $sched_code = "", $semester = "", $sy = "")
  {

    if ($program != "") {
      //get section 
      $this->data['section_list'] = $this->Room_Model->get_program($program);
    }
    if ($section != "") {
      # code...
      $this->data['section_id'] = $section;
    }
    if ($semester != "") {
      # code...
      $array_data['semester'] = $semester;
      $this->data['semester'] = $semester;
    } else {
      # code...
      $array_data['semester'] = "";
    }
    if ($sy != "") {
      # code...
      $array_data['sy'] = $sy;
      $this->data['sy'] = $sy;
    } else {
      # code...
      $array_data['sy'] = "";
    }
    if ($sched_code != "") {
      # code...
      $array_data['sched_code'] = $sched_code;
    } else {
      # code...
      $array_data['sched_code'] = "";
    }
    $this->data['sched_code'] = $sched_code;
    $this->data['time'] = $this->Room_Model->Get_time();
    $this->data['Room'] = $this->Room_Model->Get_room();
    $this->data['instructor'] = $this->Room_Model->Get_instructor();
    $this->data['section'] = $this->Room_Model->Get_section();
    $this->data['legend'] = $this->Room_Model->Get_legend();
    $this->data['subject'] = $this->Room_Model->Get_subject();
    $this->data['programs'] = $this->Room_Model->Get_programs();
    //$this->data['checksched'] = $this->Room_Model->checksched();
    $this->data['checksched'] = $this->Room_Model->get_schedule_list($array_data);
    $this->render($this->set_views->create_sched());
  }

  public function ajax_getsched_search()
  {
    $array_data = array(
      'search' => $this->input->get('searchkey'),
      'semester' => $this->input->get('sem'),
      'sy' => $this->input->get('sy'),
      'offset' => $this->input->get('offset'),
      'perpage' => $this->input->get('perpage')
    );
    $sched = $this->Room_Model->get_schedule_list_search($array_data);
    foreach ($sched as $row) {

      $sess['sched_code'] = $row['Sched_Code'];
      $sess['sched_display_id'] = $row['sched_display_id'];
      $sess['school_year'] = $array_data['sy'];
      $sess['semester'] = $array_data['semester'];

      $total_enrollees = $this->Schedule_Model->get_sched_total_enrolled_no_sd($sess)[0]['total_enrolled'];
      $total_advised = $this->Schedule_Model->get_sched_total_advised($sess)[0]['total_advised'];
      $total_enrollees_array[$sess['sched_code']] = $total_enrollees + $total_advised;
      //echo $sess['sched_code'].':'.$sess['sched_display_id'].'<br>';

    }
    $result = array(

      'sched' => $sched,
      'total_enrolled' => $total_enrollees_array,

    );
    echo json_encode($result);
  }

  public function ajax_getsched_search_pagination()
  {

    $array_data = array(
      'search' => $this->input->get('searchkey'),
      'semester' => $this->input->get('sem'),
      'sy' => $this->input->get('sy')
    );
    $pages = $this->Room_Model->get_schedule_list_search_count($array_data);

    echo $pages;
  }

  /*
  public function Sched_Management($semester = "", $sy = "", $search="", $Offset = ""){

    echo $userdata['fullname'];
    $array_data = array(
      'search' => $search,
      'semester' => $semester,
      'sy' => $sy,
      'offset' => $Offset,
    );

    $this->data['sy'] = $sy;
    $this->data['sem'] = $semester;

    $this->data['sched_code'] = $sched_code;
    $this->data['time'] = $this->Room_Model->Get_time();
    $this->data['Room'] = $this->Room_Model->Get_room();
    $this->data['instructor'] = $this->Room_Model->Get_instructor();

    //GETS DATA

    //Gets result with offset
    $this->data['checksched'] = $this->Room_Model->get_schedule_list_search($array_data);
    $rownumber = $this->Room_Model->get_schedule_list_search_count($array_data);
    foreach($this->data['checksched'] as $row){

      $sess['sched_code'] = $row['Sched_Code'];
      $sess['sched_display_id'] = $row['sched_display_id'];
      $sess['school_year'] = $sy;
      $sess['semester'] = $semester;

      $total_enrollees_array[$sess['sched_display_id']] = $this->Schedule_Model->get_sched_total_enrolled_no_sd($sess)[0]['total_enrolled'];
      //
      //echo $sess['sched_code'].':'.$sess['sched_display_id'].'<br>';

    }
    $this->data['Sched_slot'] =  $total_enrollees_array;

    //PAGINATION SETUP
    $config['base_url'] = base_url().'/index.php/'.$this->router->fetch_class().'/'.$this->router->fetch_method().'/'.$array_data['semester'].'/'.$array_data['sy'].'/'.$array_data['search'];
		$config['total_rows'] = $rownumber;
		$config['per_page'] = 10;
		$config['num_links'] = $config['total_rows']/$config['per_page'];
		$config['reuse_query_string'] = TRUE;
		//Integrate bootstrap pagination
		$design = $this->pagination_design();

		$config = array_merge($config,$design);
    $this->pagination->initialize($config);
    

    $this->popupwindow($this->set_views->edit_sched());

  }
  */
  public function Sched_search()
  {
    $Semester = $this->input->post('schedsem');
    $SchoolYear = $this->input->post('schedsy');
    $Search = $this->input->post('specified_sched');
    redirect('/registrar/Sched_Management/' . $Semester . '/' . $SchoolYear . '/' . $Search, 'refresh');
  }

  public function Get_CourseTitle()
  {
    if ($this->input->get('ID')) {
      # code...
      $course_id = $this->input->get('ID');

      $coursemodel = $this->Room_Model->get_coursecode($course_id);

      //echo json_encode($coursemodel[0]['Course_Title']);
      //echo $coursemodel[0]['Course_Title'];

      $array_output = array($coursemodel[0]['Course_Title'], $coursemodel[0]['Course_Lec_Unit'], $coursemodel[0]['Course_Lab_Unit']);

      echo json_encode($array_output);
    } else {
      return "";
    }
  }

  public function savesubject()
  {

    //check if day, start time, end time, room, instructor,

    $Start_Time = $this->input->post('starttime');
    $End_Time = $this->input->post('endtime');
    $array_day = $this->input->post('day');

    $day = implode(',', $this->input->post('day'));

    $RoomID = $this->input->post('room');
    $Instructor_ID = $this->input->post('instructor');


    $Program = $this->input->post('program');
    $Course_Code = $this->input->post('course');
    $Total_Slot = $this->input->post('totalslot');
    $Section_ID = $this->input->post('section');
    $SchoolYear = $this->input->post('schedsy');
    $Semester = $this->input->post('schedsem');


    //print_r($array_day);
    //echo $day;
    if (!isset($Course_Code) || trim($Course_Code) == '' || !isset($Total_Slot) || trim($Total_Slot) == '' || !isset($Section_ID) || trim($Section_ID) == '') {
      $this->session->set_flashdata('msg', 'You did not fill all required fields');
      redirect('/registrar/Create_Sched', 'refresh');
    } else {
      $this->session->set_flashdata('program', $Program);
      $this->session->set_flashdata('course', $Course_Code);
      $this->session->set_flashdata('totalslot', $Total_Slot);
      $this->session->set_flashdata('section', $Section_ID);


      $array_checker = array(
        'semester' => $this->input->post('schedsem'),
        'sy' => $this->input->post('schedsy'),
        'start_time' => $this->input->post('starttime'),
        'end_time' => $this->input->post('endtime'),
        'day_array' => $day,
        'room_id' => $this->input->post('room'),
        'section_id' => $this->input->post('section'),
        'course_id' => $this->input->post('course')
      );

      //check if conflict with section
      $check_section = $this->Registrar_Model->conflict_check_section($array_checker);

      if ($check_section != NULL) {
        $this->session->set_flashdata('msg', 'Conflict with Section');
        redirect('/registrar/Create_Sched', 'refresh');
      }
      //check if conflict with room
      $check_room = $this->Registrar_Model->conflict_check_room($array_checker);

      if ($check_room != NULL) {
        $this->session->set_flashdata('msg', 'Conflict with Room');
        redirect('/registrar/Create_Sched', 'refresh');
      }

      $sched_code_data = array(
        'Start_Time' => $Start_Time,
        'End_Time' => $End_Time,
        'Day' => $day,
        'RoomID' => $RoomID,
        'Instructor_ID' => $Instructor_ID
      );

      $sched_data = array(
        'Course_Code' => $Course_Code,
        'Total_Slot' => $Total_Slot,
        'Section_ID' => $Section_ID,
        'SchoolYear' => $SchoolYear,
        'Semester' => $Semester
      );

      $array_data = array(
        'semester' => $this->input->post('schedsem'),
        'sy' => $this->input->post('schedsy'),
        'section_id' => $Section_ID,
        'course_id' => $Course_Code

      );

      //check if sched_code is already available
      $course_info = $this->Registrar_Model->get_course_info($array_data);

      if ($course_info == NULL) {
        # code...
        //save to sched
        $sched_code_id = $this->Room_Model->save_sched($sched_data);
        $sched_code_data['Sched_Code'] = $sched_code_id;
      } else {
        $sched_code_data['Sched_Code'] = $course_info[0]['Sched_Code'];
      }


      //save to sched_display
      $this->array_logs['action'] = $this->Room_Model->save_sched_code($sched_code_data);
      //Logs
      $this->Others_Model->insert_logs($this->array_logs);

      //save to sched_display
      $this->array_logs['action'] = 'Encoded Schedule: ' . $sched_code_id;
      //Logs
      $this->Others_Model->insert_logs($this->array_logs);

      $this->session->set_flashdata('sched_msg', 'Successfully Added Schedule For <u>' . $Course_Code . '</u> With a Schedule Code of <u>' . $sched_code_data['Sched_Code'] . '</u>');
      redirect('/registrar/Create_Sched/' . $Program . '/' . $Section_ID . '/' . $sched_code_data['Sched_Code'] . '/' . $Semester . '/' . $SchoolYear, 'refresh');
    }
  }

  public function update_schedule()
  {

    $this->load->helper(array('form', 'url'));

    $this->load->library('form_validation');
    //rules for form validation
    $config = array(
      array(
        'field' => 'starttime',
        'label' => 'Start Time',
        'rules' => 'required'
      ),
      array(
        'field' => 'endtime',
        'label' => 'End Time',
        'rules' => 'callback_endtime_message[endtime],required|greater_than[' . $this->input->post('starttime') . ']'
      ),
      array(
        'field' => 'day[]',
        'label' => 'Day',
        'rules' => 'required'
      ),
      array(
        'field' => 'room',
        'label' => 'Room',
        'rules' => 'required'
      ),
      array(
        'field' => 'schedule_id',
        'label' => 'Schedule ID',
        'rules' => 'required'
      )
    );
    $this->form_validation->set_rules($config);
    $remove = $this->input->post('removebutton');
    //echo $this->input->post('schedule_id');
    //echo $this->session->flashdata('editmessage');
    if (isset($remove)) {

      $this->session->set_flashdata('editmessage', 'Schedule Removed');
      $this->Registrar_Model->remove_sched_display($this->input->post('schedule_id'));
      redirect('Registrar/Sched_management', 'Refresh');
    }
    if ($this->form_validation->run() == TRUE) {
      //change array to string
      $day = implode(',', $this->input->post('day'));

      //get schedule info
      $schedule_info = $this->Registrar_Model->get_schedule_info($this->input->post('schedule_id'));

      if ($schedule_info == NULL) {
        # code...
        $this->session->set_flashdata('msg', 'Error: Unable to find Schedule');
        redirect('/registrar/Create_Sched', 'refresh');
      }

      $array_data = array(
        'start_time' => $this->input->post('starttime'),
        'end_time' => $this->input->post('endtime'),
        'day_array' => $day,
        'room_id' => $this->input->post('room'),
        'section_id' => $schedule_info[0]['Section_ID'],
        'course_id' => $schedule_info[0]['Course_Code'],
        'schedule_id' => $this->input->post('schedule_id')
      );

      //check if conflict(section)
      $check_section = $this->Registrar_Model->conflict_check_section_edit($array_data);
      if ($check_section != NULL) {

        $this->session->set_flashdata('msg', 'Conflict with Section');
        redirect('/registrar/Create_Sched', 'refresh');
      }

      //check if conflict(room)
      if ($this->input->post('room') != 93  || $this->input->post('room') != 113) {
        $check_room = $this->Registrar_Model->conflict_check_room_edit($array_data);
        if ($check_room != NULL) {
          $this->session->set_flashdata('msg', 'Conflict with Room');
          redirect('/registrar/Create_Sched', 'refresh');
        }
      }

      $schedule_data = array(
        'Start_Time' => $this->input->post('starttime'),
        'End_Time' => $this->input->post('endtime'),
        'Day' => $day,
        'RoomID' => $this->input->post('room'),
        'Instructor_ID' => $this->input->post('instructor')
      );

      //update the schedule
      $this->Registrar_Model->update_schedule($this->input->post('schedule_id'), $schedule_data);
      redirect('/registrar/Sched_Management', 'refresh');
    } else {
      redirect('/registrar/Create_Sched', 'refresh');
    }
  }
  public function ajax_remove_sched()
  {

    //Get input
    $sd_id = $this->input->get('schedule_id');
    //get schedule info
    $schedule_info = $this->Registrar_Model->get_schedule_info($sd_id);
    if ($schedule_info == NULL) {
      echo 'Error: Cannot Find Schedule';
    } else {

      //Removes Sched
      $enrolled = $this->Class_List_Model->get_class_list(array('sc' => $schedule_info[0]['Sched_Code']));
      $instance = $this->Registrar_Model->check_schedule_instances($schedule_info[0]['Sched_Code']);

      //echo json_encode($enrolled);
      if (empty($enrolled)) {

        if ($instance[0]['i_count'] == 1) {
          //$this->Registrar_Model->remove_schedule($schedule_info[0]['SchedCode']);
          //$this->Registrar_Model->remove_sched_display($sd_id);
          //Logs 
          $this->array_logs['action'] =  'Removed Schedule: ' . $schedule_info[0]['Sched_Code'] . ' with Sched Instance: ' . $sd_id;
          $this->Others_Model->insert_logs($this->array_logs);
          echo 'Schedule Code: <u>' . $schedule_info[0]['Sched_Code'] . '</u> Has Been Removed';
        } else {
          //$this->Registrar_Model->remove_sched_display($sd_id);
          //Logs 
          $this->array_logs['action'] =  'Removed Sched Instance: ' . $sd_id;
          $this->Others_Model->insert_logs($this->array_logs);
          echo 'An Instance of Schedule Code: <u>' . $schedule_info[0]['Sched_Code'] . '</u> Has Been Removed';
        }
      } else {

        echo 'Cannot Remove the schedule if there are students currently enrolled.';
      }
    }
  }
  public function ajax_update_schedule()
  {

    $this->load->helper(array('form', 'url'));
    $this->load->library('form_validation');
    //rules for form validation
    $config = array(
      array(
        'field' => 'starttime',
        'label' => 'Start Time',
        'rules' => 'required'
      ),
      array(
        'field' => 'endtime',
        'label' => 'End Time',
        'rules' => 'callback_endtime_message[endtime],required|greater_than[' . $this->input->post('starttime') . ']'
      ),
      array(
        'field' => 'day[]',
        'label' => 'Day',
        'rules' => 'required'
      ),
      array(
        'field' => 'room',
        'label' => 'Room',
        'rules' => 'required'
      ),
      array(
        'field' => 'schedule_id',
        'label' => 'Schedule ID',
        'rules' => 'required'
      )
    );
    $this->form_validation->set_rules($config);

    if ($this->form_validation->run() == TRUE) {
      //change array to string
      $day = implode(',', $this->input->post('day'));

      //get schedule info
      $schedule_info = $this->Registrar_Model->get_schedule_info($this->input->post('schedule_id'));

      if ($schedule_info == NULL) {
        echo 'Error: Unable to find Schedule';
        return;
      }

      $array_data = array(
        'semester' => $this->input->post('schedsem'),
        'sy' => $this->input->post('schedsy'),
        'start_time' => $this->input->post('starttime'),
        'end_time' => $this->input->post('endtime'),
        'day_array' => $day,
        'room_id' => $this->input->post('room'),
        'section_id' => $this->input->post('section'),
        'course_id' => $schedule_info[0]['Course_Code'],
        'schedule_id' => $this->input->post('schedule_id')
      );

      #change value to  829 before updating
      if ($this->input->post('section') == 829) {
        # code...

        $this->set_sched_dissolved($this->input->post('instructor'), $this->input->post('section'), $schedule_info[0]['Sched_Code']);
        return;
      }
      //check if conflict(section)
      $check_section = $this->Registrar_Model->conflict_check_section_edit($array_data);
      if ($check_section != NULL) {
        echo 'Conflict with Section';
        return;
      }
      //check if conflict(room)
      if ($array_data['room_id'] != 93) {
        if ($array_data['room_id'] != 113) {

          $check_room = $this->Registrar_Model->conflict_check_room_edit($array_data);
          if ($check_room != NULL) {
            echo 'Conflict with Room';
            return;
          }
        }
      }

      //check if conflict(room)
      if ($array_data['section_id'] == 818  || $array_data['section_id'] == 829) {
        $enrolled = $this->Class_List_Model->get_class_list(array('sc' => $schedule_info[0]['Sched_Code']));
        if (!empty($enrolled)) {
          echo 'Cannot Dissolve the schedule if there are students currently enrolled.';
          return;
        }
      }

      $schedule_data = array(
        'Start_Time' => $this->input->post('starttime'),
        'End_Time' => $this->input->post('endtime'),
        'Day' => $day,
        'RoomID' => $this->input->post('room'),
        'Instructor_ID' => $this->input->post('instructor')
      );

      //update the schedule
      $this->array_logs['action'] =  $this->Registrar_Model->update_schedule($this->input->post('schedule_id'), $schedule_data);
      //Logs
      $this->Others_Model->insert_logs($this->array_logs);

      //update the schedule slot and section
      $schedtable_array['Total_Slot'] = $this->input->post('edit_total_slot');
      $schedtable_array['Section_ID'] = $this->input->post('section');

      $this->array_logs['action'] =  $this->Registrar_Model->update_sched_table($schedule_info[0]['Sched_Code'], $schedtable_array);
      //Logs
      $this->Others_Model->insert_logs($this->array_logs);

      //Save another log
      $this->array_logs['action'] =  'Updated Schedule For: ' . $schedule_info[0]['Sched_Code'];
      //Logs
      $this->Others_Model->insert_logs($this->array_logs);

      echo 'Successfully Updated!';
    } else {
      echo validation_errors();
    }
  }

  public function set_sched_dissolved($instructor_id, $section_id, $sched_code)
  {
    #change room id later before uploading
    $schedule_data = array(
      'Start_Time' => "",
      'End_Time' => "",
      'Day' => "",
      'RoomID' => 93,
      'Instructor_ID' => $instructor_id
    );
    $schedtable_array = array(
      'Total_Slot' => 0,
      'Section_ID' => $section_id
    );

    //update the schedule
    $this->array_logs['action'] =  $this->Registrar_Model->dissolve_schedule($sched_code, $schedule_data);
    //Logs
    $this->Others_Model->insert_logs($this->array_logs);

    $this->array_logs['action'] =  $this->Registrar_Model->update_sched_table($sched_code, $schedtable_array);
    //Logs
    $this->Others_Model->insert_logs($this->array_logs);

    //Save another log
    $this->array_logs['action'] =  'Updated Schedule For: ' . $sched_code;
    //Logs
    $this->Others_Model->insert_logs($this->array_logs);

    echo 'Successfully Updated!';
  }

  public function Get_program()
  {

    //echo $this->input->get('Program_ID');
    if ($this->input->get('Program_ID')) {
      # code...
      $program_id = $this->input->get('Program_ID');

      $programmodel = $this->Room_Model->get_program($program_id);

      //echo json_encode($coursemodel[0]['Course_Title']);
      //echo $programmodel[0]['Section_Name'];


      echo json_encode($programmodel);
    } else {
      echo  "errors" . $this->input->get('Program_ID');
    }
  }

  public function get_time()
  {

    if (($this->input->get('check') == !1) or (!is_numeric($this->input->get('check')))) {
      # code...
      //redirect('Advising');
      echo "error";
      return;
    }
    $array_time = $this->Room_Model->Get_time();
    echo json_encode($array_time);
  }

  public function get_room_sched()
  {

    if ((($this->input->get('roomId') == NULL) or (!is_numeric($this->input->get('roomId')))) && (($this->input->get('semester') == NULL)) && (($this->input->get('schoolYear') == NULL))) {
      # code...
      //redirect('Registrar');
      echo "error:data is invalid";
      return;
    }

    $array_data = array(
      'room_id' => $this->input->get('roomId'),
      'semester' => $this->input->get('semester'),
      'sy' => $this->input->get('schoolYear')
    );

    //get available schedules
    $array_schedule = $this->Room_Model->get_room_sched($array_data);
    echo json_encode($array_schedule);
  }

  public function get_sched_code_info()
  {

    if (($this->input->get('section') == NULL) or (!is_numeric($this->input->get('section'))) && $this->input->get('courseCode') == NULL) {
      # code...
      //redirect('Registrar');
      echo "error:data is invalid";
      return;
    }
    $array_data = array(
      'section_id' => $this->input->get('section'),
      'course_id' => $this->input->get('courseCode')
    );
    $course_info = $this->Registrar_Model->get_sched_code_schedule($array_data);

    if ($course_info != NULL) {
      # code...
      echo json_encode($course_info);
    }
    //get course code info

  }

  public function get_schedule_info()
  {

    if (($this->input->get('id') == NULL) or (!is_numeric($this->input->get('id')))) {
      # code...
      //redirect('Registrar');
      echo "error:data is invalid";
      return;
    }

    $schedule_info = $this->Registrar_Model->get_schedule_info($this->input->get('id'));

    echo json_encode($schedule_info);
  }

  ///SCHEDULE CHECKERS: Gerard
  public function ScheduleFormValidation()
  {
    //For Ajax use
    $this->load->helper(array('form', 'url'));

    $this->load->library('form_validation');
    $start_time = $this->input->post('starttime');
    $end_time = $this->input->post('endtime');
    //echo $start_time;
    //echo $end_time;
    $this->form_validation->set_rules('schedsem', 'Semester', 'required');
    $this->form_validation->set_rules('schedsy', 'School Year', 'required');
    $this->form_validation->set_rules('starttime', 'Start Time', 'required');
    $this->form_validation->set_rules('endtime', 'End Time', 'callback_endtime_message[endtime],required|greater_than[' . $this->input->post('starttime') . ']');
    $this->form_validation->set_rules('day[]', 'Day', 'required');
    $this->form_validation->set_rules('room', 'Room', 'required');
    //$this->form_validation->set_rules('instructor', 'Instructor', 'required');
    $this->form_validation->set_rules('section', 'Section', 'required');
    $this->form_validation->set_rules('program', 'Program', 'required');
    $this->form_validation->set_rules('course', 'Course', 'required');
    $this->form_validation->set_rules('totalslot', 'Total Slot', 'required');

    $array[] = '';

    if ($this->form_validation->run() == FALSE) {
      echo '<span style="color:#cc0000"> ' . form_error('schedsem') . '</span>';
      echo '<span style="color:#cc0000"> ' . form_error('schedsy') . '</span>';
      echo '<span style="color:#cc0000"> ' . form_error('program') . '</span>';
      echo '<span style="color:#cc0000"> ' . form_error('section') . '</span>';
      echo '<span style="color:#cc0000"> ' . form_error('course') . '</span>';
      echo '<span style="color:#cc0000"> ' . form_error('starttime') . '</span>';
      echo '<span style="color:#cc0000"> ' . form_error('endtime') . '</span>';
      echo '<span style="color:#cc0000"> ' . form_error('day[]') . '</span>';
      echo '<span style="color:#cc0000"> ' . form_error('room') . '</span>';
      //echo '<span style="color:#cc0000"> '.form_error('instructor').'</span>';
      echo '<span style="color:#cc0000"> ' . form_error('totalslot') . '</span>';
      //echo validation_errors();
    } else {
      //Call model

      //change array to string
      $day = implode(',', $this->input->post('day'));

      $array_data = array(
        'semester' => $this->input->post('schedsem'),
        'sy' => $this->input->post('schedsy'),
        'start_time' => $this->input->post('starttime'),
        'end_time' => $this->input->post('endtime'),
        'day_array' => $day,
        'room_id' => $this->input->post('room'),
        'section_id' => $this->input->post('section'),
        'course_id' => $this->input->post('course')
      );

      //check if conflict(course)
      /*
      $check_course = $this->Registrar_Model->conflict_check_course($array_data);
      
      if($check_course != NULL)
      {

        echo 'Unable to Add Schedule. Conflicts with course checker:<br><ul>';
        foreach($check_course as $value)
        {
          echo '<li>'.$value['Sched_Code'].' '.$value['Course_Code'].'</li>';
        }
        echo '</ul>';
      }
      */

      //check if conflict(section)
      $check_section = $this->Registrar_Model->conflict_check_section($array_data);

      if ($check_section != NULL) {
        echo 'Unable to Add Schedule. Conflicts with section checker:<br><ul>';
        foreach ($check_section as $value) {
          echo '<li>' . $value['Sched_Code'] . ' ' . $value['Course_Code'] . '</li>';
        }
        echo '</ul>';
        return;
      }

      //check if conflict(room)
      if ($this->input->post('room') != 93) {
        if ($this->input->post('room') != 113) {

          $check_room = $this->Registrar_Model->conflict_check_room($array_data);
          if ($check_room != NULL) {
            echo 'Unable to Add Schedule. Conflicts with room checker:<br><ul>';
            foreach ($check_room as $value) {
              echo '<li>' . $value['Sched_Code'] . ' ' . $value['Course_Code'] . ' </li>';
            }
            echo '</ul>';
          }
        }
      }



      /*
      echo 'array data:<br><ul>';
      foreach ($array_data as $key => $value) 
      {
        # code...
        echo '<li>'.$key.' '.$value.'</li>';
      }
      echo '</ul>';

      */
    }
  }

  public function edit_schedule_form_validation()
  {

    $this->load->helper(array('form', 'url'));

    $this->load->library('form_validation');

    #change value to  829 before updating 
    if ($this->input->post('section') == 750) {
      # code...
      //get schedule info
      $schedule_info = $this->Registrar_Model->get_schedule_info($this->input->post('schedule_id'));

      if ($schedule_info == NULL) {
        # code...
        echo 'Error: Unable to find Schedule in Database';
        return;
      }

      return;
    }
    //rules for form validation
    $config = array(
      array(
        'field' => 'schedsem',
        'label' => 'Semester',
        'rules' => 'required'
      ),
      array(
        'field' => 'schedsy',
        'label' => 'School Year',
        'rules' => 'required'
      ),
      array(
        'field' => 'starttime',
        'label' => 'Start Time',
        'rules' => 'required'
      ),
      array(
        'field' => 'endtime',
        'label' => 'End Time',
        'rules' => 'callback_endtime_message[endtime],required|greater_than[' . $this->input->post('starttime') . ']'
      ),
      array(
        'field' => 'day[]',
        'label' => 'Day',
        'rules' => 'required'
      ),
      array(
        'field' => 'room',
        'label' => 'Room',
        'rules' => 'required'
      ),
      array(
        'field' => 'schedule_id',
        'label' => 'Schedule ID',
        'rules' => 'required'
      )
    );
    $this->form_validation->set_rules($config);

    if ($this->form_validation->run() == FALSE) {
      echo '<span style="color:#cc0000"> ' . form_error('schedsem') . '</span>';
      echo '<span style="color:#cc0000"> ' . form_error('schedsy') . '</span>';
      echo '<span style="color:#cc0000"> ' . form_error('starttime') . '</span>';
      echo '<span style="color:#cc0000"> ' . form_error('endtime') . '</span>';
      echo '<span style="color:#cc0000"> ' . form_error('day[]') . '</span>';
      echo '<span style="color:#cc0000"> ' . form_error('room') . '</span>';
      echo '<span style="color:#cc0000"> ' . form_error('schedule_id') . '</span>';
    } else {
      //change array to string
      $day = implode(',', $this->input->post('day'));

      //get schedule info
      $schedule_info = $this->Registrar_Model->get_schedule_info($this->input->post('schedule_id'));

      if ($schedule_info == NULL) {
        # code...
        echo 'Error: Unable to find Schedule in Database';
        return;
      }

      $array_data = array(
        'semester' => $this->input->post('schedsem'),
        'sy' => $this->input->post('schedsy'),
        'start_time' => $this->input->post('starttime'),
        'end_time' => $this->input->post('endtime'),
        'day_array' => $day,
        'room_id' => $this->input->post('room'),
        'section_id' => $this->input->post('section'),
        'course_id' => $schedule_info[0]['Course_Code'],
        'schedule_id' => $this->input->post('schedule_id')
      );

      //check if conflict(section)
      $check_section = $this->Registrar_Model->conflict_check_section_edit($array_data);

      if ($check_section != NULL) {
        echo 'Unable to Add Schedule. Conflicts with section checker:<br><ul>';
        foreach ($check_section as $value) {
          echo '<li>' . $value['Sched_Code'] . ' ' . $value['Course_Code'] . '</li>';
        }
        echo '</ul>';
        return;
      }

      //check if conflict(room)
      if ($this->input->post('room') != 93) {
        if ($this->input->post('room') != 113) {

          //echo 'Room ID: '.$this->input->post('room');
          $check_room = $this->Registrar_Model->conflict_check_room_edit($array_data);
          if ($check_room != NULL) {
            echo 'Unable to Add Schedule. Conflicts with room checker:<br><ul>';
            foreach ($check_room as $value) {
              echo '<li>' . $value['Sched_Code'] . ' ' . $value['Course_Code'] . ' </li>';
            }
            echo '</ul>';
          }
        }
      }
    }
  }

  public function endtime_message()
  {
    $this->form_validation->set_message('endtime_message', '%s Must be above Start Time.');
    return true;
  }

  public function testerCheck()
  {
    $check = $this->ScheduleChecker('20190001', 'M,F', '700', '800');
    if ($check->num_rows() >= 1) {

      echo 'Unable to Add Schedule. Conflicts with:<br><ul>';
      foreach ($check->result_array() as $row) {
        echo '<li>' . $row['Sched_Code'] . '</li>';
      }
      echo '</ul>';
    } else {
      echo 'Query Error';
    }
  }

  public function ScheduleChecker($schedcode, $day, $st, $et)
  {

    $result = $this->Registrar_Model->conflict_check($schedcode, $day, $st, $et);

    return $result;
  }

  public function test_check_v2()
  {

    $array_data = array(
      'day_array' => 'T',
      'start_time' => 830,
      'end_time' => 1000,
      'section_id' => 199,
      'room_id' => 40
    );

    //check if conflict(section)
    $check_section = $this->Registrar_Model->conflict_check_section($array_data);

    //check if conflict(section)
    $check_room = $this->Registrar_Model->conflict_check_room($array_data);

    if ($check_section != NULL) {
      # code...
      //echo "conflict";
      //echo $check_section['Course_Code'];
      echo "for section <br>";
      foreach ($check_section as $value) {
        # code...
        echo $value['Course_Code'] . "<br>";
      }
    }

    if ($check_room != NULL) {
      # code...
      //echo "conflict";
      //echo $check_section['Course_Code'];
      echo "for room <br>";
      foreach ($check_room as $value) {
        # code...
        echo $value['Course_Code'] . "<br>";
      }
    }
  }

  public function test_sched_list()
  {

    $result = $this->Room_Model->get_schedule_list($sched_code);
    print_r($result);
  }

  public function test_checker()
  {
    $array_data = array(
      'start_time' => $this->input->post('starttime'),
      'end_time' => $this->input->post('endtime'),
      'day_array' => $day,
      'room_id' => $this->input->post('room'),
      'section_id' => $this->input->post('section'),
      'course_id' => $this->input->post('course')
    );

    //check if conflict(course)
    $check_course = $this->Registrar_Model->conflict_check_course($array_data);
  }

  //AJAX, UPDATE SCHEDULE CHOICES: GERARD//
  public function get_time_choices()
  {
    $array_time = $this->Room_Model->Get_time();
    echo json_encode($array_time);
  }

  public function get_room_choices()
  {
    $array_time = $this->Room_Model->Get_room();
    echo json_encode($array_time);
  }

  public function get_instructor_choices()
  {
    $array_time = $this->Room_Model->Get_instructor();
    echo json_encode($array_time);
  }
  //AJAX, UPDATE SCHEDULE CHOICES: GERARD//

  //REGISTRAR ACTIVITY LOGS//
  public function Activity_Logs()
  {

    $this->data['user'] = $this->Actionlogs_Model->Get_user();
    $this->data['get_table'] = $this->Actionlogs_Model->Get_table();
    $this->render($this->set_views->action_logs());
  }
  //REGISTRAR ACTIVITY LOGS//



  //REGISTRAR CHED REPORT//
  public function Ched_Report()
  {

    $this->data['get_legend']     = $this->Ched_Report_Model->Get_sem();
    $this->data['get_sy']         = $this->Ched_Report_Model->Get_sy();
    $this->data['get_ylvl']       = $this->Ched_Report_Model->Get_yearlvl();
    $this->data['Get_Course']     = $this->EnrolledStudent_Model->Get_Course();
    $this->data['Get_Major']      = $this->Ched_Report_Model->GetMajor();
    $this->data['get_user']       = $this->Ched_Report_Model->Get_user();
    $this->data['legend']         = $this->Enroll_Summary_Model->Get_Legend();

    // $sy         = $this->input->post('sy');
    // $sm         = $this->input->post('sem');
    // $major      = $this->input->post('mjr');
    // $program    = $this->input->post('course');
    // $Yl         = $this->input->post('year_lvl');
    // $submit     = $this->input->post('search_button');

    // $sy         = '2020-2021';
    // $sm         = 'FIRST';
    // $major      = '0';
    // $program    = 'BACOMM';
    // $Yl         = '1';
    // $submit     = 'submit';

    // $sess = array(

    //   'sy'        => $sy,
    //   'sm'        => $sm,
    //   'major'     => $major,
    //   'program'   => $program,
    //   'Yl'        => $Yl,
    //   'submit'    => $submit,

    // );

    $ched_array = array(

      'sy'        => $this->input->post('sy'),
      'sm'        => $this->input->post('sem'),
      'major'     => $this->input->post('mjr'),
      'program'   => $this->input->post('course'),
      'Yl'        => $this->input->post('year_lvl'),
      'submit'    => $this->input->post('search_button'),

    );

    $this->session->set_userdata($ched_array);

    $this->data['get_students']   = $this->Ched_Report_Model->Get_students($ched_array);
    //  die(json_encode($this->data['get_students']->result_array()));
    //  $this->array_logs['module'] = 'Ched Report';
    //  $this->array_logs['action'] = 'Search Ched Report: School Year: '.$sy.' SEMESTER:'.$sm;
    //  $this->Others_Model->insert_logs($this->array_logs);

    $this->render($this->set_views->ched_report());
  }
  //REGISTRAR CHED REPORT//

  //REGISTRAR CHED REPORT GET MAJOR DROPDOWN//
  public function get_major()
  {

    $course_id = $this->input->post('course_id');
    $course = $this->Ched_Report_Model->get_major($course_id);
    if (count($course) > 0) {
      $pro_select_box .= '';
      $pro_select_box .= '<option value=""> Select Major</option>';
      foreach ($course as $row) {
        $pro_select_box .= '<option value="' . $row->ID . '">' . $row->Program_Major . '</option>';
      }
      echo json_encode($pro_select_box);
    }
  }
  //REGISTRAR CHED REPORT GET MAJOR DROPDOWN//

  //CHECKER BUTTON OF CHED REPORT/ CHED EXCEL//
  public function Check_Ched_Button()
  {

    $Sb      = $this->input->post('search_button');
    $exp     = $this->input->post('export');

    // $this->Ched_Report();

    if (isset($Sb)) {

      $this->Ched_Report();
    } else if (isset($exp)) {

      $this->Ched_excel();
    }
  }
  //CHECKER BUTTON OF CHED REPORT/ CHED EXCEL//


  // CHED EXCEL//
  public function Ched_excel()
  {
    // $sy         = $this->session->userdata('sy');
    // $sm         = $this->session->userdata('sm');
    // $major      = $this->session->userdata('major');
    // $program    = $this->session->userdata('program');
    // $Yl         = $this->session->userdata('Yl');
    // $submit     = $this->session->userdata('submit');

    $ched_array = array(
      'sy'        => $this->session->userdata('sy'),
      'sm'        => $this->session->userdata('sm'),
      'major'     => $this->session->userdata('major'),
      'program'   => $this->session->userdata('program'),
      'Yl'        => $this->session->userdata('Yl'),
      'submit'    => $this->session->userdata('submit'),
    );


    $object = new Spreadsheet();
    $object->setActiveSheetIndex(0);

    // MERGE CELLS
    $cell_merge = array(
      'C2:F2', 'C3:F3', 'C4:F4', 'C5:F5',
      'A7:F7',
      'A8:A9', 'B8:B9', 'C8:C9', 'D8:D9', 'E8:E9', 'F8:F9', 'G8:G9', 'H8:H9', 'I8:I9', 'J8:J9', 'K8:K9',
      'L8:N8', 'O8:Q8', 'R8:T8', 'U8:W8', 'X8:Z8', 'AA8:AC8', 'AD8:AF8', 'AG8:AI8', 'AJ8:AL8', 'AM8:AO8', 'AP8:AR8', 'AS8:AU8', 'AV8:AV9'
    );
    foreach ($cell_merge as $merge) {
      $object->setActiveSheetIndex(0)->mergeCells($merge);
    }

    // SET WIDTH COLUMN
    $object->getActiveSheet()->getColumnDimension('A')->setWidth(6.15);
    $object->getActiveSheet()->getColumnDimension('B')->setWidth(15.60);
    $object->getActiveSheet()->getColumnDimension('C')->setWidth(21.45);
    $object->getActiveSheet()->getColumnDimension('D')->setWidth(21.45);
    $object->getActiveSheet()->getColumnDimension('E')->setWidth(21.45);
    $object->getActiveSheet()->getColumnDimension('F')->setWidth(15);
    $object->getActiveSheet()->getColumnDimension('G')->setWidth(8);
    $object->getActiveSheet()->getColumnDimension('H')->setWidth(11);
    $object->getActiveSheet()->getColumnDimension('I')->setWidth(11.30);
    $object->getActiveSheet()->getColumnDimension('J')->setWidth(38.45);
    $object->getActiveSheet()->getColumnDimension('K')->setWidth(43);
    //
    $object->getActiveSheet()->getColumnDimension('L')->setWidth(12);
    $object->getActiveSheet()->getColumnDimension('M')->setWidth(39);
    $object->getActiveSheet()->getColumnDimension('N')->setWidth(8);
    $object->getActiveSheet()->getColumnDimension('O')->setWidth(12);
    $object->getActiveSheet()->getColumnDimension('P')->setWidth(39);
    $object->getActiveSheet()->getColumnDimension('Q')->setWidth(8);
    $object->getActiveSheet()->getColumnDimension('R')->setWidth(12);
    $object->getActiveSheet()->getColumnDimension('S')->setWidth(39);
    $object->getActiveSheet()->getColumnDimension('T')->setWidth(8);
    $object->getActiveSheet()->getColumnDimension('U')->setWidth(12);
    $object->getActiveSheet()->getColumnDimension('V')->setWidth(39);
    $object->getActiveSheet()->getColumnDimension('W')->setWidth(8);
    $object->getActiveSheet()->getColumnDimension('X')->setWidth(12);
    $object->getActiveSheet()->getColumnDimension('Y')->setWidth(39);
    $object->getActiveSheet()->getColumnDimension('Z')->setWidth(8);
    $object->getActiveSheet()->getColumnDimension('AA')->setWidth(12);
    $object->getActiveSheet()->getColumnDimension('AB')->setWidth(39);
    $object->getActiveSheet()->getColumnDimension('AC')->setWidth(8);
    $object->getActiveSheet()->getColumnDimension('AD')->setWidth(12);
    $object->getActiveSheet()->getColumnDimension('AE')->setWidth(39);
    $object->getActiveSheet()->getColumnDimension('AF')->setWidth(8);
    $object->getActiveSheet()->getColumnDimension('AG')->setWidth(12);
    $object->getActiveSheet()->getColumnDimension('AH')->setWidth(39);
    $object->getActiveSheet()->getColumnDimension('AI')->setWidth(8);
    $object->getActiveSheet()->getColumnDimension('AJ')->setWidth(12);
    $object->getActiveSheet()->getColumnDimension('AK')->setWidth(39);
    $object->getActiveSheet()->getColumnDimension('AL')->setWidth(8);
    $object->getActiveSheet()->getColumnDimension('AM')->setWidth(12);
    $object->getActiveSheet()->getColumnDimension('AN')->setWidth(39);
    $object->getActiveSheet()->getColumnDimension('AO')->setWidth(8);
    $object->getActiveSheet()->getColumnDimension('AP')->setWidth(12);
    $object->getActiveSheet()->getColumnDimension('AQ')->setWidth(39);
    $object->getActiveSheet()->getColumnDimension('AR')->setWidth(8);
    $object->getActiveSheet()->getColumnDimension('AS')->setWidth(12);
    $object->getActiveSheet()->getColumnDimension('AT')->setWidth(39);
    $object->getActiveSheet()->getColumnDimension('AU')->setWidth(8);
    $object->getActiveSheet()->getColumnDimension('AV')->setWidth(13);

    // SET HEIGHT ROW
    $object->getActiveSheet()->getRowDimension('9')->setRowHeight(36.75);

    // SET FREEZE GRID
    $object->getActiveSheet()->freezePane("L10");



    // SET STYLE
    // Whole Design
    $align_and_border = array(
      'font' => array(
        'bold'  =>  true,
      ),
      'alignment' => array(
        'horizontal' => 'center',
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
        'wrap' => true
      ),
      'borders' => array(
        'allborders' => array(
          'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
        )
      )
    );
    // Array Colors For Subject
    $color_course = array(
      'sub_1' => 'FDE9D9',
      'sub_2' => 'B7DEE8',
      'sub_3' => 'CCC0DA',
      'sub_4' => 'D8E4BC',
      'sub_5' => 'E6B8B7',
      'sub_6' => 'B8CCE4',
      'sub_7' => '8DB4E2',
      'sub_8' => 'C4BD97',
      'sub_9' => 'D9D9D9',
      'sub_10' => 'FABF8F',
      'sub_11' => 'B7DEE8',
      'sub_12' => 'DAEEF3',
    );

    // Bold
    $cell_bold = array(
      'B2', 'B3', 'B4', 'B5',
      'A7',

    );
    foreach ($cell_bold as $bold) {
      $object->getActiveSheet()->getStyle($bold)->getFont()->setBold(true);
    }

    // Set Border
    //** border style
    $allBorder = array(
      'borders' => array(
        'allborders' => array(
          'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
        )
      )
    );
    $bottomBorder = array(
      'borders' => array(
        'bottom' => array(
          'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
        )
      )
    );

    //** border bottom
    $cell_border_bottom = array(
      'C2:F2', 'C3:F3', 'C4:F4', 'C5:F5'
    );
    foreach ($cell_border_bottom as $border_bottom) {
      $object->getActiveSheet()->getStyle($border_bottom)->applyFromArray($bottomBorder);
    }


    // SET VALUE TO CELL
    $object->getActiveSheet()
      ->setCellValue('B2', 'HEI:')
      ->setCellValue('B3', 'Address:')
      ->setCellValue('B4', 'Academic Year:')
      ->setCellValue('B5', 'Term:')
      ->setCellValue('C2', 'ST. DOMINIC COLLEGE OF ASIA')
      ->setCellValue('C3', 'St. DominicComplex E. Aguinaldo Highway, Talaba, 4, Bacoor City, Cavite')
      ->setCellValue('C4', $ched_array['sy'])
      ->setCellValue('C5', $ched_array['sm'] . ' Semester')
      ->setCellValue('A7', 'Instruction: Please DO NOT INSERT or DELETE COLUMNS; insert or delete rows as necessary.')
      // Table Headers
      ->setCellValue('A8', 'Count')
      ->setCellValue('B8', 'Student No.')
      ->setCellValue('C8', 'Surname')
      ->setCellValue('D8', 'First Name')
      ->setCellValue('E8', 'Middle Name')
      ->setCellValue('F8', 'Suffix
      (Jr., I, II, III)')
      ->setCellValue('G8', 'Sex')
      ->setCellValue('H8', 'Nationality')
      ->setCellValue('I8', 'Year Level')
      ->setCellValue('J8', 'Program')
      ->setCellValue('K8', 'Major')
      //
      ->setCellValue('L8', 'Course / Subject 1')
      ->setCellValue('L9', 'Course Code')
      ->setCellValue('M9', 'Course Description or Descriptive Title')
      ->setCellValue('N9', 'Units')

      ->setCellValue('O8', 'Course / Subject 2')
      ->setCellValue('O9', 'Course Code')
      ->setCellValue('P9', 'Course Description or Descriptive Title')
      ->setCellValue('Q9', 'Units')

      ->setCellValue('R8', 'Course / Subject 3')
      ->setCellValue('R9', 'Course Code')
      ->setCellValue('S9', 'Course Description or Descriptive Title')
      ->setCellValue('T9', 'Units')

      ->setCellValue('U8', 'Course / Subject 4')
      ->setCellValue('U9', 'Course Code')
      ->setCellValue('V9', 'Course Description or Descriptive Title')
      ->setCellValue('W9', 'Units')

      ->setCellValue('X8', 'Course / Subject 5')
      ->setCellValue('X9', 'Course Code')
      ->setCellValue('Y9', 'Course Description or Descriptive Title')
      ->setCellValue('Z9', 'Units')

      ->setCellValue('AA8', 'Course / Subject 6')
      ->setCellValue('AA9', 'Course Code')
      ->setCellValue('AB9', 'Course Description or Descriptive Title')
      ->setCellValue('AC9', 'Units')

      ->setCellValue('AD8', 'Course / Subject 7')
      ->setCellValue('AD9', 'Course Code')
      ->setCellValue('AE9', 'Course Description or Descriptive Title')
      ->setCellValue('AF9', 'Units')

      ->setCellValue('AG8', 'Course / Subject 8')
      ->setCellValue('AG9', 'Course Code')
      ->setCellValue('AH9', 'Course Description or Descriptive Title')
      ->setCellValue('AI9', 'Units')

      ->setCellValue('AJ8', 'Course / Subject 9')
      ->setCellValue('AJ9', 'Course Code')
      ->setCellValue('AK9', 'Course Description or Descriptive Title')
      ->setCellValue('AL9', 'Units')

      ->setCellValue('AM8', 'Course / Subject 10')
      ->setCellValue('AM9', 'Course Code')
      ->setCellValue('AN9', 'Course Description or Descriptive Title')
      ->setCellValue('AO9', 'Units')

      ->setCellValue('AP8', 'Course / Subject 11')
      ->setCellValue('AP9', 'Course Code')
      ->setCellValue('AQ9', 'Course Description or Descriptive Title')
      ->setCellValue('AR9', 'Units')

      ->setCellValue('AS8', 'Course / Subject 12')
      ->setCellValue('AS9', 'Course Code')
      ->setCellValue('AT9', 'Course Description or Descriptive Title')
      ->setCellValue('AU9', 'Units')

      ->setCellValue('AV8', 'Total Units');


    // Table Header
    $table_header = array(
      // 'A8:A9','B8:B9','C8:C9','D8:D9','E8:E9','F8:F9','G8:G9','H8:H9','I8:I9','J8:J9','K8:K9',
      'A8:K8', 'A9:K9',
      'L8:AV9'
    );
    foreach ($table_header as $header) {
      $object->getActiveSheet()->getStyle($header)->applyFromArray($align_and_border);
    }

    // SET CELL ALIGNMENT
    $cell_on_left = array(
      'B2', 'B3', 'B4', 'B5',
      'C2', 'C3', 'C4', 'C5'
    );
    foreach ($cell_on_left as $left) {
      $object->getActiveSheet()->getStyle($left)->getAlignment()
        ->setHorizontal('left');
    }


    $student_data = $this->Ched_Report_Model->Get_students($ched_array);
    //use comment to define process.

    $excel_row = 9;
    $count = 0;
    $student_number = "";

    //subject column start
    $subject_col_start = 12;
    //subject title column start
    $subject_title_col_start = 13;
    //unit column start
    $unit_col_start = 14;
    foreach ($student_data->result_array() as $row) {
      //set count??

      $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $count);

      // set the position of the subject and units setCellValueByColumnAndRow(column position, row position, cell value);
      if ($student_number === $row['Student_Number']) {
        //increment subject column start
        $subject_col_start += 3;
        //subject column start
        $subject_title_col_start += 3;
        //increment unit column start
        $unit_col_start += 3;

        $object->getActiveSheet()->setCellValueByColumnAndRow($subject_col_start, $excel_row, $row['Course_Code']);
        $object->getActiveSheet()->setCellValueByColumnAndRow($subject_title_col_start, $excel_row, $row['Course_Title']);
        $object->getActiveSheet()->setCellValueByColumnAndRow($unit_col_start, $excel_row, $row['Course_Lab_Unit'] + $row['Course_Lec_Unit']);
      } else {
        $count++;
        $excel_row++;
        //reset subject column start
        $subject_col_start = 12;
        //reset subject column start
        $subject_title_col_start = 13;
        //reset unit column start
        $unit_col_start = 14;
        $student_number = $row['Student_Number'];
        $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, strtoupper($row['Student_Number']));
        $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, strtoupper($row['Last_Name']));
        $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, strtoupper($row['First_Name']));
        $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, strtoupper($row['Middle_Name']));
        $object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, '');
        if (($row['Gender'] === 'MALE') || ($row['Gender'] === 'Male')) {
          $object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, 'Male');
        } else {
          $object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, 'Female');
        }
        $object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, strtoupper($row['Nationality']));
        $object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, strtoupper($row['YearLevel']));
        $object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, strtoupper($row['Program_Name']));
        $object->getActiveSheet()->setCellValueByColumnAndRow(11, $excel_row, strtoupper($row['Program_Major']));
        $object->getActiveSheet()->setCellValueByColumnAndRow($subject_col_start, $excel_row, $row['Course_Code']);
        $object->getActiveSheet()->setCellValueByColumnAndRow($subject_title_col_start, $excel_row, $row['Course_Title']);
        $object->getActiveSheet()->setCellValueByColumnAndRow($unit_col_start, $excel_row, $row['Course_Lab_Unit'] + $row['Course_Lec_Unit']);
        // Total of teh Units
        $subject_name_col_start = 48;
        // Add all in Total units Column
        $object->getActiveSheet()->setCellValueByColumnAndRow(
          $subject_name_col_start,
          $excel_row,
          "=N" . $excel_row . "+Q" . $excel_row . "+T" . $excel_row . "+W" . $excel_row . "+Z" . $excel_row . "+AC" . $excel_row . "+AF" . $excel_row . "+AI" .
            $excel_row . "+AL" . $excel_row . "+AO" . $excel_row . "+AR" . $excel_row . "+AU" . $excel_row
        );
      }
    }
    // SET FILTERS
    $object->getActiveSheet()->setAutoFilter('A9:AV' . $excel_row);
    // Table Data Border
    $object->getActiveSheet()->getStyle("A10:AV" . $excel_row)->applyFromArray($allBorder);
    // Set Colors To Subjects
    $object->getActiveSheet()->getStyle('L8:N' . $excel_row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB($color_course['sub_1']);
    $object->getActiveSheet()->getStyle('O8:Q' . $excel_row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB($color_course['sub_2']);
    $object->getActiveSheet()->getStyle('R8:T' . $excel_row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB($color_course['sub_3']);
    $object->getActiveSheet()->getStyle('U8:W' . $excel_row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB($color_course['sub_4']);
    $object->getActiveSheet()->getStyle('X8:Z' . $excel_row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB($color_course['sub_5']);
    $object->getActiveSheet()->getStyle('AA8:AC' . $excel_row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB($color_course['sub_6']);
    $object->getActiveSheet()->getStyle('AD8:AF' . $excel_row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB($color_course['sub_7']);
    $object->getActiveSheet()->getStyle('AG8:AI' . $excel_row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB($color_course['sub_8']);
    $object->getActiveSheet()->getStyle('AJ8:AL' . $excel_row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB($color_course['sub_9']);
    $object->getActiveSheet()->getStyle('AM8:AO' . $excel_row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB($color_course['sub_10']);
    $object->getActiveSheet()->getStyle('AP8:AR' . $excel_row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB($color_course['sub_11']);
    $object->getActiveSheet()->getStyle('AS8:AU' . $excel_row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB($color_course['sub_12']);

    $object_writer = new \PhpOffice\PhpSpreadsheet\Writer\Xls($object);
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="Student_Data.xls"');
    $object_writer->save('php://output');

    $this->array_logs['module'] = 'Ched Report';
    $this->array_logs['action'] = 'Export Ched Report: School Year: ' . $ched_array['sy'] . ' SEMESTER:' . $ched_array['sm'];
    $this->Others_Model->insert_logs($this->array_logs);
  }


  public function Ched_excel_old()
  {


    $sy         = $this->session->userdata('sy');
    $sm         = $this->session->userdata('sm');
    $major      = $this->session->userdata('major');
    $program    = $this->session->userdata('program');
    $Yl         = $this->session->userdata('Yl');
    $submit     = $this->session->userdata('submit');


    $object = new Spreadsheet();



    $object->setActiveSheetIndex(0);
    $object->getActiveSheet()->mergeCells('A1:Z1');
    $object->getActiveSheet()->setCellValue('A1', 'ENROLLMENT LIST');
    $object->getActiveSheet()->getStyle('A1')->getAlignment()
      ->setHorizontal('center');
    $object->getActiveSheet()->mergeCells('A2:Z2');
    $object->getActiveSheet()->setCellValue('A2', 'School Year:' . $sy . ' Semester:' . $sm . '');
    $object->getActiveSheet()->getStyle('A2')->getAlignment()
      ->setHorizontal('center');
    $object->getActiveSheet()->setCellValue('N3', 'COURSE: ' . $program . ' Major in ' . $major . '');
    $object->getActiveSheet()->mergeCells('A3:M3');
    $object->getActiveSheet()->setCellValue('A3', 'SCHOOL  : ST. DOMINIC COLLEGE OF ASIA ');
    $object->getActiveSheet()->setCellValue('A4', 'ADDRESS:  Emilio Aguinaldo Highway, Talaba, Bacoor, Cavite');
    $object->getActiveSheet()->mergeCells('N4:Z4');
    $object->getActiveSheet()->setCellValue('N4', 'YEAR LEVEL: ' . $Yl . '');
    $object->getActiveSheet()->setCellValue('A5', '');
    $object->getActiveSheet()->setCellValue('B5', 'NAME OF STUDENTS');
    $object->getActiveSheet()->setCellValue('C5', 'M');
    $object->getActiveSheet()->setCellValue('D5', 'F');
    $object->getActiveSheet()->setCellValue('E5', 'SUBJECT');
    $object->getActiveSheet()->setCellValue('F5', 'UNITS');
    $object->getActiveSheet()->setCellValue('G5', 'SUBJECT');
    $object->getActiveSheet()->setCellValue('H5', 'UNITS');
    $object->getActiveSheet()->setCellValue('I5', 'SUBJECT');
    $object->getActiveSheet()->setCellValue('J5', 'UNITS');
    $object->getActiveSheet()->setCellValue('K5', 'SUBJECT');
    $object->getActiveSheet()->setCellValue('L5', 'UNITS');
    $object->getActiveSheet()->setCellValue('M5', 'SUBJECT');
    $object->getActiveSheet()->setCellValue('N5', 'UNITS');
    $object->getActiveSheet()->setCellValue('O5', 'SUBJECT');
    $object->getActiveSheet()->setCellValue('P5', 'UNITS');
    $object->getActiveSheet()->setCellValue('Q5', 'SUBJECT');
    $object->getActiveSheet()->setCellValue('R5', 'UNITS');
    $object->getActiveSheet()->setCellValue('S5', 'SUBJECT');
    $object->getActiveSheet()->setCellValue('T5', 'UNITS');
    $object->getActiveSheet()->setCellValue('U5', 'SUBJECT');
    $object->getActiveSheet()->setCellValue('V5', 'UNITS');
    $object->getActiveSheet()->setCellValue('W5', 'SUBJECT');
    $object->getActiveSheet()->setCellValue('X5', 'UNITS');
    $object->getActiveSheet()->setCellValue('Y5', 'SUBJECT');
    $object->getActiveSheet()->setCellValue('Z5', 'UNITS');
    $object->getActiveSheet()->getColumnDimension('B')->setWidth(50);
    $object->getActiveSheet()->getColumnDimension('C')->setWidth(10);
    $object->getActiveSheet()->getColumnDimension('D')->setWidth(10);
    $object->getActiveSheet()->getColumnDimension('E')->setWidth(15);
    $object->getActiveSheet()->getColumnDimension('F')->setWidth(10);
    $object->getActiveSheet()->getColumnDimension('G')->setWidth(15);
    $object->getActiveSheet()->getColumnDimension('H')->setWidth(10);
    $object->getActiveSheet()->getColumnDimension('I')->setWidth(15);
    $object->getActiveSheet()->getColumnDimension('J')->setWidth(10);
    $object->getActiveSheet()->getColumnDimension('K')->setWidth(15);
    $object->getActiveSheet()->getColumnDimension('L')->setWidth(10);
    $object->getActiveSheet()->getColumnDimension('M')->setWidth(15);
    $object->getActiveSheet()->getColumnDimension('N')->setWidth(10);
    $object->getActiveSheet()->getColumnDimension('O')->setWidth(15);
    $object->getActiveSheet()->getColumnDimension('P')->setWidth(10);
    $object->getActiveSheet()->getColumnDimension('Q')->setWidth(15);
    $object->getActiveSheet()->getColumnDimension('R')->setWidth(10);
    $object->getActiveSheet()->getColumnDimension('S')->setWidth(15);
    $object->getActiveSheet()->getColumnDimension('T')->setWidth(10);
    $object->getActiveSheet()->getColumnDimension('U')->setWidth(15);
    $object->getActiveSheet()->getColumnDimension('V')->setWidth(10);
    $object->getActiveSheet()->getColumnDimension('W')->setWidth(15);
    $object->getActiveSheet()->getColumnDimension('X')->setWidth(10);
    $object->getActiveSheet()->getColumnDimension('Y')->setWidth(15);
    $object->getActiveSheet()->getColumnDimension('Z')->setWidth(10);



    $student_data = $this->Ched_Report_Model->Get_students($sy, $sm, $major, $program, $Yl, $submit);
    //use comment to define process.

    $excel_row = 5;
    $count = 0;
    $student_number = "";

    //subject column start
    $subject_col_start = 5;
    //unit column start
    $unit_col_start = 4;
    foreach ($student_data->result_array() as $row) {
      //set count??

      $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $count);

      // set the position of the subject and units setCellValueByColumnAndRow(column position, row position, cell value);
      if ($student_number === $row['Student_Number']) {
        //increment subject column start
        $subject_col_start += 2;
        //increment unit column start
        $unit_col_start += 2;

        $object->getActiveSheet()->setCellValueByColumnAndRow($subject_col_start, $excel_row, $row['Course_Code']);
        $object->getActiveSheet()->setCellValueByColumnAndRow($unit_col_start, $excel_row, $row['Course_Lab_Unit'] + $row['Course_Lec_Unit']);
      } else {
        $count++;
        $excel_row++;
        //reset subject column start
        $subject_col_start = 4;
        //reset unit column start
        $unit_col_start = 5;
        $student_number = $row['Student_Number'];
        $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, strtoupper($row['Last_Name'] . ',' . $row['First_Name'] . ',' . $row['Middle_Name']));
        if (($row['Gender'] === 'MALE') || ($row['Gender'] === 'Male')) {
          $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, '*');
        } else {
          $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, '*');
        }
        $object->getActiveSheet()->setCellValueByColumnAndRow($subject_col_start, $excel_row, $row['Course_Code']);
        $object->getActiveSheet()->setCellValueByColumnAndRow($unit_col_start, $excel_row, $row['Course_Lab_Unit'] + $row['Course_Lec_Unit']);
      }
    }
    $object_writer = new \PhpOffice\PhpSpreadsheet\Writer\Xls($object);
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="Student_Data.xls"');
    $object_writer->save('php://output');

    $this->array_logs['module'] = 'Ched Report';
    $this->array_logs['action'] = 'Export Ched Report: School Year: ' . $sy . ' SEMESTER:' . $sm;
    $this->Others_Model->insert_logs($this->array_logs);
  }
  // CHED EXCEL//


  // CHECKER FORMS //
  public function Choose_Form()
  {

    $F    = $this->input->post('Search-Button');
    $Pr   = $this->input->post('Print_View');
    $ref  = $this->input->post('refnum');

    $this->session->set_flashdata('noref', '');

    $this->data['info']  = $this->RegForm_Model->Get_Info($ref);
    if ($this->data['info']->num_rows() <= 0) {
      $this->session->set_flashdata('noref', 'Unknown Student Number');
      redirect('Registrar/Forms', 'refresh');
    }

    //Checker of pages
    if (isset($F)) {
      $this->Forms();
    } else if (isset($Pr)) {
      //Checker if no Ref number in textbox
      $this->Print_regform();
    }
  }
  // CHECKER FORMS //

  // REG FORM //
  public function Forms()
  {

    $this->data['get_sem']       = $this->RegForm_Model->Get_sem();
    $this->data['get_sy']        = $this->RegForm_Model->Get_sy();
    $this->data['legend']        = $this->Enroll_Summary_Model->Get_Legend();


    $array = array(
      'sy' => $this->input->post('sy'),
      'sem' => $this->input->post('sem'),
      'refnum' => $this->input->post('refnum')
    );

    $this->session->set_flashdata('NoFees', '');


    $this->data['check_enrolled_student']  = $this->RegForm_Model->Check_Enrolled_Student($array);
    $this->data['check_fees_student']      = $this->RegForm_Model->Check_Fees_Student($array);
    $this->data['countPrint']              = $this->RegForm_Model->Count_Print($array);
    if ($array['refnum']) {

      if ($this->data['check_fees_student']->num_rows() == 0) {

        $this->session->set_flashdata('NoFees', 'PLEASE PAY FIRST TO CASHIER!!');
      } else {

        if ($this->data['check_fees_student']->num_rows() != 0) {
          $this->data['get_data']  = $this->RegForm_Model->Get_enrolled($array);
          foreach ($this->data['get_data']  as $row) {

            $array = array(
              'section'    => $row['Section_Name'],
              'course'     => $row['Program'],
              'sem'        => $row['Semester'],
              'sy'         => $row['School_Year'],
              'yl'         => $row['YL'],
              'ref_num'    => $row['Reference_Number'],
              'stu_num'    => $row['Student_Number'],
              'admmitedSy' => $row['AdmittedSY'],
              'admmitedSem' => $row['AdmittedSEM']
            );
          }

          $this->data['get_TotalCountSubject']       = $this->RegForm_Model->Get_CountSubject_enrolled($array);
          $this->data['get_labfees']                 = $this->RegForm_Model->Get_LabFeesEnrolled($array);
          $this->data['get_miscfees']                = $this->RegForm_Model->Get_MISC_FEE($array);
          $this->data['get_othefees']                = $this->RegForm_Model->Get_OTHER_FEE($array);
          $this->data['get_totalcash']               = $this->RegForm_Model->Get_Total_CashPayment($array);
          $this->data['get_totalunits']              = $this->RegForm_Model->totalUnitsEnrolled($array);
        }
      }
    }


    $this->render($this->set_views->form());
  }
  // REG FORM //

  //PRITING REG FORM
  public function Print_regform()
  {

    $array = array(
      'sy' => $this->input->post('sy'),
      'sem' => $this->input->post('sem'),
      'refnum' => $this->input->post('refnum')
    );

    $this->data['check_enrolled_student']  = $this->RegForm_Model->Check_Enrolled_Student($array);
    $this->data['check_fees_student']      = $this->RegForm_Model->Check_Fees_Student($array);

    if ($this->data['check_fees_student']->num_rows() <= 0) {
      $this->session->set_flashdata('NoSS', 'NO RESULT');
      redirect('Registrar/Forms');
    }

    if ($this->data['check_fees_student']->num_rows() != 0) {

      $this->data['get_data']  = $this->RegForm_Model->Get_enrolled($array);
      foreach ($this->data['get_data']  as $row) {
        $array = array(
          'section'    => $row['Section_Name'],
          'course'     => $row['Program'],
          'sem'        => $row['Semester'],
          'sy'         => $row['School_Year'],
          'yl'         => $row['YL'],
          'ref_num'    => $row['Reference_Number'],
          'stu_num'    => $row['Student_Number'],
          'admmitedSy' => $row['AdmittedSY'],
          'admmitedSem' => $row['AdmittedSEM']
        );
      }
      $this->data['get_TotalCountSubject']       = $this->RegForm_Model->Get_CountSubject_enrolled($array);
      $this->data['get_labfees']                 = $this->RegForm_Model->Get_LabFeesEnrolled($array);
      $this->data['get_miscfees']                = $this->RegForm_Model->Get_MISC_FEE($array);
      $this->data['get_othefees']                = $this->RegForm_Model->Get_OTHER_FEE($array);
      $this->data['get_totalcash']               = $this->RegForm_Model->Get_Total_CashPayment($array);
      $this->data['get_totalunits']              = $this->RegForm_Model->totalUnitsEnrolled($array);
    }


    $this->load->view('body/registrar/PrintRegForm');
  }

  public function print_logs_ajax()
  {

    $insert = array();
    $array = array(
      'Semester'               => $this->input->post('Semester'),
      'SchoolYear'             => $this->input->post('SchoolYear'),
      'Student_Number'         => $this->input->post('Student_Number'),
      'Reference_Number'       => $this->input->post('Reference_Number')
    );

    $insert['Semester']          = $array['Semester'];
    $insert['School_Year']       = $array['SchoolYear'];
    $insert['Student_Number']    = $array['Student_Number'];
    $insert['Reference_Number']  = $array['Reference_Number'];
    $insert['User_id']           = $this->admin_data['userid'];
    $insert['Date']              = date("Y-m-d H:i:s");

    if ($this->RegForm_Model->Insert_logs($insert)) {
      echo 1;
      $this->print_logs($array);
    } else {
      echo 0;
    }
  }
  public function print_logs($array)
  {

    $this->array_logs['module'] = 'PRINT REGFORM';
    $this->array_logs['action'] = 'Printed Reg Form. Student Number:' . $array['Student_Number'] . ', Reference Number:' . $array['Reference_Number'] . ', School Year: ' . $array['SchoolYear'] . ' SEMESTER:' . $array['Semester'];
    $this->Others_Model->insert_logs($this->array_logs);
  }


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

    $column = 1;
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

      $total_consumed_slots = $total_enrollees_array + $total_advised_array;

      $count++;

      $Difference = $row['Total_Slot'] - $total_consumed_slots;

      $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row['Sched_Code']);
      $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row['Course_Code']);
      $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row['Course_Title']);
      $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $row['Section_Name']);
      $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $row['Course_Lec_Unit']);
      $object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $row['Course_Lab_Unit']);
      $object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $row['Total_Slot']);
      $object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row,  $Difference);
      $object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, $total_consumed_slots);
      $object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, $row['Day']);
      $object->getActiveSheet()->setCellValueByColumnAndRow(11, $excel_row, $times['start'] . '-' . $times['end']);
      $object->getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row, $row['Room']);
      $object->getActiveSheet()->setCellValueByColumnAndRow(13, $excel_row, $row['Instructor_Name']);
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


  //Enroll Summary Module

  // CHECKER FORMS //
  public function Summary()
  {

    $E    = $this->input->post('submit');
    $EX   = $this->input->post('export');


    //Checker of pages
    if (isset($E)) {
      $this->Enroll_summary();
    } else if (isset($EX)) {
      //Checker if no Ref number in textbox
      $this->Enroll_summary_Excell();
    }
  }
  // CHECKER FORMS //

  public function Enroll_summary()
  {
    $this->data['legend']            = $this->Enroll_Summary_Model->Get_Legend();
    $this->data['get_sem']           = $this->Enroll_Summary_Model->Get_sem();
    $this->data['get_sy']            = $this->Enroll_Summary_Model->Get_sy();
    $programlist = $this->Enroll_Summary_Model->Get_Course();


    $array = array(
      'sy' => $this->input->post('sy'),
      'sem' => $this->input->post('sem'),
    );


    //INITIALIZE ARRAY AND COUNTER FOR FOREACH
    $LIST = array();
    $count = 0;

    //PUTS RESULTS INTO ARRAY WHILE GETTING TALLY FROM OTHER TABLE
    foreach ($programlist as $row) {

      //ASSIGNS PROGRAM TO AN ARRAY TO BE USED FOR QUERY
      $array['program']  = $row->Prog;
      $array['Major_id'] = $row->Major_ID;


      //GETS TALLY OF ENROLLEES AND PUTS TO $list ARRAY
      if (($array['Major_id'] === '0') || ($array['Major_id'] === 'N/A') || ($array['Major_id'] === NULL)) {
        $list[$count]['new'] = $this->Enroll_Summary_Model->Get_New($array)[0]->REF;
        $list[$count]['old'] = $this->Enroll_Summary_Model->Get_Old($array)[0]->REF;
        $list[$count]['1st'] = $this->Enroll_Summary_Model->Get_1st($array)[0]->REF;
        $list[$count]['2nd'] = $this->Enroll_Summary_Model->Get_2nd($array)[0]->REF;
        $list[$count]['3rd'] = $this->Enroll_Summary_Model->Get_3rd($array)[0]->REF;
        $list[$count]['4th'] = $this->Enroll_Summary_Model->Get_4th($array)[0]->REF;
        $list[$count]['5th'] = $this->Enroll_Summary_Model->Get_5th($array)[0]->REF;
        $list[$count]['withdraw'] = $this->Enroll_Summary_Model->Get_Withdraw($array)[0]->REF;
        $list[$count]['Enlisted'] = $this->Enroll_Summary_Model->Get_Enlisted($array)[0]->REF;
      } else {
        $list[$count]['new'] = $this->Enroll_Summary_Model->Get_NewMajor($array)[0]->REF;
        $list[$count]['old'] = $this->Enroll_Summary_Model->Get_OldMajor($array)[0]->REF;
        $list[$count]['1st'] = $this->Enroll_Summary_Model->Get_1stMajor($array)[0]->REF;
        $list[$count]['2nd'] = $this->Enroll_Summary_Model->Get_2ndMajor($array)[0]->REF;
        $list[$count]['3rd'] = $this->Enroll_Summary_Model->Get_3rdMajor($array)[0]->REF;
        $list[$count]['4th'] = $this->Enroll_Summary_Model->Get_4thMajor($array)[0]->REF;
        $list[$count]['5th'] = $this->Enroll_Summary_Model->Get_5thMajor($array)[0]->REF;
        $list[$count]['withdraw'] = $this->Enroll_Summary_Model->Get_WithdrawMajor($array)[0]->REF;
        $list[$count]['Enlisted'] = $this->Enroll_Summary_Model->Get_EnlistedMajor($array)[0]->REF;
      }
      //COMBINES PROGRAM AND MAJOR TOGETHER INTO ONE STRING AND PUTS IN ARRAY
      $list[$count]['program'] = $row->Prog . ' (' . $row->Major . ')';


      $count++;
    }

    //DEMO WHEN PLACED IN VIEW:
    $count = 0;

    $this->data['list'] = $list;

    // foreach($list as $row){
    // echo $row['program'].' =  New:'.$row['new'].', Old:'.$row['old'].', Withraw:'.$row['withdraw'].'<hr>';
    // }


    $this->array_logs['module'] = 'HED ENROLL SUMMARY REPORT';
    $this->array_logs['action'] = 'Search HED Enroll Summary: School Year: ' . $array['sy'] . ' SEMESTER:' . $array['sm'];
    $this->Others_Model->insert_logs($this->array_logs);

    $this->render($this->set_views->Enroll_Summary());
  }

  public function Enroll_summary_Excell()
  {

    $object = new Spreadsheet();
    $object->setActiveSheetIndex(0);
    $table_columns = array("#", "Course", "NEW", "OLD", "WITHDRAW", "TOTAL", "ENLISTED", "FIRST", "SECOND", "THIRD", "FOURTH", "FIFTH");
    $object->getActiveSheet()->getColumnDimension('B')->setWidth(50);
    $object->getActiveSheet()->getColumnDimension('C')->setWidth(10);
    $object->getActiveSheet()->getColumnDimension('D')->setWidth(10);
    $object->getActiveSheet()->getColumnDimension('E')->setWidth(13);
    $object->getActiveSheet()->getColumnDimension('F')->setWidth(10);
    $object->getActiveSheet()->getColumnDimension('G')->setWidth(13);
    $object->getActiveSheet()->getColumnDimension('H')->setWidth(10);
    $object->getActiveSheet()->getColumnDimension('I')->setWidth(10);
    $object->getActiveSheet()->getColumnDimension('J')->setWidth(10);
    $column = 0;
    foreach ($table_columns as $field) {
      $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
      $column++;
    }


    $programlist = $this->Enroll_Summary_Model->Get_Course();


    $array = array(
      'sy' => $this->input->post('sy'),
      'sem' => $this->input->post('sem'),
    );


    //INITIALIZE ARRAY AND COUNTER FOR FOREACH
    $LIST = array();
    $count = 0;

    //PUTS RESULTS INTO ARRAY WHILE GETTING TALLY FROM OTHER TABLE
    foreach ($programlist as $row) {

      //ASSIGNS PROGRAM TO AN ARRAY TO BE USED FOR QUERY
      $array['program']  = $row->Prog;
      $array['Major_id'] = $row->Major_ID;



      //GETS TALLY OF ENROLLEES AND PUTS TO $list ARRAY
      if (($array['Major_id'] === '0') || ($array['Major_id'] === 'N/A') || ($array['Major_id'] === NULL)) {

        $list[$count]['new'] = $this->Enroll_Summary_Model->Get_New($array)[0]->REF;
        $list[$count]['old'] = $this->Enroll_Summary_Model->Get_Old($array)[0]->REF;
        $list[$count]['1st'] = $this->Enroll_Summary_Model->Get_1st($array)[0]->REF;
        $list[$count]['2nd'] = $this->Enroll_Summary_Model->Get_2nd($array)[0]->REF;
        $list[$count]['3rd'] = $this->Enroll_Summary_Model->Get_3rd($array)[0]->REF;
        $list[$count]['4th'] = $this->Enroll_Summary_Model->Get_4th($array)[0]->REF;
        $list[$count]['5th'] = $this->Enroll_Summary_Model->Get_5th($array)[0]->REF;
        $list[$count]['Enlisted'] = $this->Enroll_Summary_Model->Get_Enlisted($array)[0]->REF;
        $list[$count]['withdraw'] = $this->Enroll_Summary_Model->Get_Withdraw($array)[0]->REF;
      } else {

        $list[$count]['new'] = $this->Enroll_Summary_Model->Get_NewMajor($array)[0]->REF;
        $list[$count]['old'] = $this->Enroll_Summary_Model->Get_OldMajor($array)[0]->REF;
        $list[$count]['1st'] = $this->Enroll_Summary_Model->Get_1stMajor($array)[0]->REF;
        $list[$count]['2nd'] = $this->Enroll_Summary_Model->Get_2ndMajor($array)[0]->REF;
        $list[$count]['3rd'] = $this->Enroll_Summary_Model->Get_3rdMajor($array)[0]->REF;
        $list[$count]['4th'] = $this->Enroll_Summary_Model->Get_4thMajor($array)[0]->REF;
        $list[$count]['5th'] = $this->Enroll_Summary_Model->Get_5thMajor($array)[0]->REF;
        $list[$count]['withdraw'] = $this->Enroll_Summary_Model->Get_WithdrawMajor($array)[0]->REF;
        $list[$count]['Enlisted'] = $this->Enroll_Summary_Model->Get_EnlistedMajor($array)[0]->REF;
      }
      //COMBINES PROGRAM AND MAJOR TOGETHER INTO ONE STRING AND PUTS IN ARRAY
      $list[$count]['program'] = $row->Prog . ' (' . $row->Major . ')';
      $count++;
    }

    //DEMO WHEN PLACED IN VIEW:
    $count = 1;

    $this->data['list'] = $list;

    $excel_row = 2;
    foreach ($this->data['list']  as $row) {

      if ($row['program']  === NULL) {
        $Major = 'N/A';
      } else {
        $Major = $row['program'];
      }


      $New         = $row['new'];
      $Old         = $row['old'];
      $FirstY      = $row['1st'];
      $SecondY     = $row['2nd'];
      $ThirdY      = $row['3rd'];
      $FourthY     = $row['4th'];
      $FiftY       = $row['5th'];
      $Withdraw    = $row['withdraw'];
      $Enlisted    = $row['Enlisted'];

      $Difference = 0;
      $SumOfOld = 0;
      $Difference = $row['old'] - $row['new'];

      /// Sum = NEw  + Old 
      $SumOfOldAndNew  = $New + $Difference;

      /// Sum of New
      $SumOfNew = $SumOfNew + $New;

      /// Sum of Old
      $SumOfOld = $SumOfOld + $Difference;

      /// Sum of Withdraw
      $SumOfWithdraw = $SumOfWithdraw + $Withdraw;

      /// Total First Year
      $TotalFirstY = $TotalFirstY + $FirstY;

      /// Total Second Year
      $TotalSecondY = $TotalSecondY + $SecondY;

      /// Total 3rd Year
      $TotalThirdY = $TotalThirdY + $ThirdY;

      /// Total 4th Year
      $TotalFourthY = $TotalFourthY + $FourthY;

      /// Total 5th Year
      $TotalFifthY  = $TotalFifthY  + $FiftY;

      /// Total Enlisted
      $TotalEnlisted = $TotalEnlisted  + $Enlisted;


      $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $count);
      $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $Major);
      $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row['new']);
      $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $SumOfOld);
      $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $row['withdraw']);
      $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $SumOfOldAndNew);
      $object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $row['Enlisted']);
      $object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $row['1st']);
      $object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, $row['2nd']);
      $object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, $row['3rd']);
      $object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row,  $row['4th']);
      $object->getActiveSheet()->setCellValueByColumnAndRow(11, $excel_row, $row['5th']);
      $excel_row++;

      $count = $count + 1;
    }

    $object_writer = new \PhpOffice\PhpSpreadsheet\Writer\Xls($object);
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="Enrollment_Summary.xls"');
    $object_writer->save('php://output');

    $this->array_logs['module'] = 'HED ENROLL SUMMARY REPORT';
    $this->array_logs['action'] = 'Export HED Enroll Summary: School Year: ' . $array['sy'] . ' SEMESTER:' . $array['sm'];
    $this->Others_Model->insert_logs($this->array_logs);
  }
  //Schedule Report Excel

  //Modify Subjects Module
  public function array_test()
  {

    //GETS PROGRAM LIST WITH MAJORS
    $programlist = $this->Enroll_Summary_Model->Get_Course();

    //CHANGE THIS INTO INPUTS
    $array = array(
      'sem' => 'SECOND',
      'sy' => '2018-2019'
    );

    //INITIALIZE ARRAY AND COUNTER FOR FOREACH
    $LIST = array();
    $count = 0;

    //PUTS RESULTS INTO ARRAY WHILE GETTING TALLY FROM OTHER TABLE
    foreach ($programlist as $row) {

      //ASSIGNS PROGRAM TO AN ARRAY TO BE USED FOR QUERY
      $array['program']  = $row->Prog;
      $array['Major_id'] = $row->Major_ID;

      //GETS TALLY OF ENROLLEES AND PUTS TO $list ARRAY
      if (($array['Major_id'] === '0') || ($array['Major_id'] === 'N/A') || ($array['Major_id'] === NULL)) {
        $list[$count]['new'] = $this->Enroll_Summary_Model->Get_New($array)[0]->REF;
        $list[$count]['old'] = $this->Enroll_Summary_Model->Get_Old($array)[0]->REF;
        $list[$count]['withdraw'] = $this->Enroll_Summary_Model->Get_Withdraw($array)[0]->REF;
      } else {
        $list[$count]['new'] = $this->Enroll_Summary_Model->Get_NewMajor($array)[0]->REF;
        $list[$count]['old'] = $this->Enroll_Summary_Model->Get_OldMajor($array)[0]->REF;
        $list[$count]['withdraw'] = $this->Enroll_Summary_Model->Get_WithdrawMajor($array)[0]->REF;
      }
      //COMBINES PROGRAM AND MAJOR TOGETHER INTO ONE STRING AND PUTS IN ARRAY
      $list[$count]['program'] = $row->Prog . ' (' . $row->Major . ')';


      $count++;
    }

    //DEMO WHEN PLACED IN VIEW:
    $count = 0;
    foreach ($list as $row) {

      echo $row['program'] . ' =  New:' . $row['new'] . ', Old:' . $row['old'] . ', Withraw:' . $row['withdraw'] . '<hr>';
    }
  }

  public function Shifting($id = '')
  {

    $msg = '';
    $submit = $this->input->post('submit');

    $array = array(
      'student_num' => $this->input->post('id')
    );
    $result = $this->SubjectEdit_Model->Validate_enrollment_status($array);
    if (empty($result) && isset($submit)) {
      $msg = 'NO RESULT';
      $this->session->set_flashdata('message', $msg);
    } else {
      $this->data['Programs'] = $this->SubjectEdit_Model->get_programs();
    }
    $this->data['Data'] = $result;
    $this->render($this->set_views->shifting());
  }
  public function Shift_Student()
  {

    $config = array(
      array(
        'field' => 'Reference_Number',
        'label' => 'Student Number / Reference Number',
        'rules' => 'required'
      ),
      array(
        'field' => 'program',
        'label' => 'Program',
        'rules' => 'required'
      ),
      array(
        'field' => 'curriculum',
        'label' => 'Curriculum',
        'rules' => 'required'
      ),
    );

    $this->form_validation->set_rules($config);

    if ($this->form_validation->run() == FALSE) {

      $msg = validation_errors();
      $this->session->set_flashdata('shift_message', $msg);
    } else {

      $ref = $this->input->post('Reference_Number');
      $StudentInfo = $this->Student_Model->get_student_info_by_reference_no($ref);
      $array = array(
        'Course' => $this->input->post('program'),
        'Major' => $this->input->post('major') ?: 0,
        'Curriculum' => $this->input->post('curriculum') ?: 0,
      );

      if (($this->SubjectEdit_Model->shift_program($array, $ref)) === TRUE) {

        $this->array_logs['action'] = 'Shifted Reference Number:' . $ref . ' from ' . $StudentInfo[0]['Course'] . ' to ' . $array['Course'] . ': Major = ' . $array['Major'] . ': Curriculum = ' . $array['Curriculum'];
        $this->array_logs['module'] = 'Shifting';
        //Logs
        $this->Others_Model->insert_logs($this->array_logs);
        $msg .= 'Successfully Shifted to: <u>' . $array['Course'] . '</u>';
        $msg .= '<br><br>';
        $msg .= 'Please note that \'Change section\' must be performed after every shift.';
        $msg .= '<br>Failure to do so will result to the student not having complete data.<br><br>';
        $msg .= 'To Change section, Click <a target="_blank" href="' . base_url() . 'index.php/Registrar/ChangeSection">HERE</a>';

        $this->session->set_flashdata('shift_message', $msg);
      } else {

        $msg = 'Error in Shifting';
        $this->session->set_flashdata('message', $msg);
      }
    }

    redirect($this->router->fetch_class() . '/Shifting/' . $ref . '/' . $sy . '/' . $sem, 'refresh');
  }
  public function get_program_majors_ajax()
  {
    $array['Program_Code'] = $this->input->get('Program_Code');
    $result = $this->SubjectEdit_Model->get_program_majors($array);
    echo json_encode($result);
  }
  public function get_program_info()
  {

    $array['Program_Code'] = $this->input->get('Program_Code');
    $result = $this->SubjectEdit_Model->get_program_info($array);
    echo json_encode($result);
  }
  public function get_curriculum()
  {

    $array['Program_Code'] = $this->input->get('Program_Code');
    $result = $this->SubjectEdit_Model->get_curriculum($array);
    echo json_encode($result);
  }

  public function Adding($id = '', $sy = '', $sem = '')
  {

    $array = array(
      'student_num' => !empty($id) ? $id : $this->input->post('id'),
      'sy' => $sy,
      'sem' => $sem
    );
    $this->data['Legend'] = $this->Schedule_Model->get_legend();
    $this->data['Sdata'] = $this->SubjectEdit_Model->Get_enrolled($array);
    $this->data['Student_units'] = '';
    $sc = '';
    foreach ($this->data['Sdata'] as $row) {
      if ($sc != $row['Sched_Code']) {
        $this->data['Student_units'] = intval($this->data['Student_units']) + ($row['Course_Lab_Unit'] + $row['Course_Lec_Unit']);
      }
      $sc = $row['Sched_Code'];
    }
    $this->render($this->set_views->adding());
  }
  public function Add_Subject()
  {

    //$Sched_Code = $this->input->post('form_sched_code');
    $searcharray = array(
      'student_num' => $this->input->post('form_ref_num'),
      'sy' => $this->input->post('form_sy'),
      'sem' => $this->input->post('form_sem'),
      'sc' => $this->input->post('form_sched_code')
    );

    //SECONDARY CHECKS
    $validate = $this->Add_secondary_check($searcharray);
    //print_r($validate);
    if (!empty($validate)) {

      $color = 'red';
      $msg = '';
      foreach ($validate as $message) {
        $msg .= '- ' . $message . '<br>';
      }
      $this->session->set_flashdata('message', $msg);
      $this->session->set_flashdata('color', $color);
      redirect($this->router->fetch_class() . '/Adding/' . $searcharray['student_num'] . '/' . $searcharray['sy'] . '/' . $searcharray['sem'], 'refresh');
    }

    //Get other insert items
    $itemresult = $this->SubjectEdit_Model->Get_enrolled($searcharray);

    if (!empty($itemresult)) {

      $insertarray = array(
        'Reference_Number' => $itemresult[0]['Reference_Number'],
        'Student_Number' => $itemresult[0]['Student_Number'],
        'Sched_Code' => $searcharray['sc'],
        'Semester' => $itemresult[0]['Semester'],
        'School_Year' => $itemresult[0]['School_Year'],
        'Status' => $itemresult[0]['Status'],
        'Program' => $itemresult[0]['Program'],
        'Major' => $itemresult[0]['Major'],
        'Year_Level' => $itemresult[0]['Year_Level'],
        'Payment_Plan' => $itemresult[0]['Payment_Plan'],
        'Section' => $itemresult[0]['Section']
      );
      // Inserts to EnrolledSubject
      $result = $this->SubjectEdit_Model->addsubject_enrolled($insertarray);
      // Message Handler

      // student fees assessment
      $itemresult = $this->SubjectEdit_Model->Get_enrolled_with_charged($searcharray);
      $this->array_logs['module'] = 'Adding';
      $itemresult['sched_code'] = $this->input->post('form_sched_code');
      $this->update_student_fees($itemresult);

      if ($result === FALSE) {
        $msg = 'Adding Failed';
        $color = 'red';
      } else {
        $msg = 'Subject Added!';
        $color = 'green';
      }
    } else {
      $msg = 'Adding Failed: No Enrolled Subjects';
      $color = 'red';
    }

    //Set messages
    $this->session->set_flashdata('message', $msg);
    $this->session->set_flashdata('color', $color);

    // Redirect to adding
    redirect($this->router->fetch_class() . '/Adding/' . $searcharray['student_num'] . '/' . $searcharray['sy'] . '/' . $searcharray['sem'], 'refresh');
  }
  private function Add_secondary_check($array)
  {

    $validation_message = array();

    //Secondary Checkers
    $sched_info = $this->Schedule_Model->get_sched_info($array);
    //print_r($sched_info);

    //Checks if Sched Code Exists and gets data
    if (!empty($sched_info)) {

      foreach ($sched_info as $row) {

        //Checks conflicts in EnrolledStudent_Subjects
        $arraydata = array(

          'sy' => $row['SchoolYear'],
          'sem' => $row['Semester'],
          'sn' => $array['student_num'],
          'day' => $row['Day'],
          'start_time' => $row['Start_Time'],
          'end_time' => $row['End_Time']

        );
        $valid_conflict = $this->SubjectEdit_Model->validate_sched_conflict($arraydata);
        //print_r($valid_conflict);
        if (!empty($valid_conflict)) {

          $validation_message[] = 'Conflicts with: ' . $valid_conflict[0]['Sched_Code'];
        }
        //--Checks conflicts in EnrolledStudent_Subjects


        //Checks Available Slots
        $arraydata2 = array(

          'sched_code' => $row['Sched_Code'],
          'sched_display_id' => $row['sched_display_id'],
          'school_year' => $row['SchoolYear'],
          'semester' => $row['Semester']

        );

        $enrolled = $this->Schedule_Model->get_sched_total_enrolled_no_sd($arraydata2);
        $advised = $this->Schedule_Model->get_sched_total_advised($arraydata2);
        $occupiedSlots = $enrolled[0]['total_enrolled'] + $advised[0]['total_advised'];

        $valid_slots = $row['Total_Slot'] - $occupiedSlots;

        if ($valid_slots <= 0) {

          $validation_message[] = 'Slots are full for: ' . $row['Sched_Code'];
        }
        //--Checks Available Slots


      }
    } else {
      $validation_message[] = 'Schedule Code is Invalid';
    }

    return $validation_message;
  }
  public function Validate_Sched()
  {

    $sc = $this->input->get('sc');
    $result = $this->SubjectEdit_Model->validate_sched($sc);
    echo $result[0]['result'];
  }
  public function Validate_Sched_conflict()
  {

    $array = array(

      'sy' => $this->input->get('sy'),
      'sem' => $this->input->get('sem'),
      'sn' => $this->input->get('sn'),
      'day' => $this->input->get('day'),
      'start_time' => $this->input->get('start_time'),
      'end_time' => $this->input->get('end_time')

    );


    $result = $this->SubjectEdit_Model->validate_sched_conflict($array);
    echo json_encode($result);
  }
  public function get_subjectchoice_search()
  {

    $array = array(
      'semester' => $this->input->get('semester'),
      'school_year' => $this->input->get('schoolYear'),
      'limit' => $this->input->get('limit'),
      'start' => $this->input->get('offset'),
    );
    if ($this->input->get('searchType') === "Course_Code") {
      $array['search_type'] = "B.Course_Code";
    } elseif ($this->input->get('searchType') === "Sched_Code") {
      $array['search_type'] = "B.Sched_Code";
    } else {
      $array['search_type'] = "E.Course_Title";
    }

    $array['search_value'] = $this->input->get('searchValue');

    echo json_encode($this->Schedule_Model->get_sched_open_search($array));
  }
  public function get_subjectchoice_search_count()
  {

    $array = array(
      'semester' => $this->input->get('semester'),
      'school_year' => $this->input->get('schoolYear'),
    );
    if ($this->input->get('searchType') === "Course_Code") {
      # code...
      $array['search_type'] = "B.Course_Code";
    } elseif ($this->input->get('searchType') === "Sched_Code") {
      # code...
      $array['search_type'] = "B.Sched_Code";
    } else {
      # code...
      $array['search_type'] = "E.Course_Title";
    }

    $array['search_value'] = $this->input->get('searchValue');

    echo $this->Schedule_Model->get_sched_open_row_count_search($array);
  }
  public function get_sched_total_enrolled()
  {

    if (($this->input->get('schedCode') == NULL) or (!is_numeric($this->input->get('schedCode'))) or ($this->input->get('schedDisplayId') == NULL) or (!is_numeric($this->input->get('schedDisplayId')))) {
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
    //$total_enrolled = $this->Schedule_Model->get_sched_total_enrolled($array_data);

    if ($total_enrolled == NULL) {
      echo 0;
    } else {
      echo $total_enrolled[0]['total_enrolled'];
    }
  }
  public function get_sched_total_advised()
  {

    if (($this->input->get('schedCode') == NULL) or (!is_numeric($this->input->get('schedCode'))) or ($this->input->get('schedDisplayId') == NULL) or (!is_numeric($this->input->get('schedDisplayId')))) {
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
    $total_advised = $this->Schedule_Model->get_sched_total_advised($array_data);
    //$total_enrolled = $this->Schedule_Model->get_sched_total_enrolled($array_data);

    if ($total_advised == NULL) {
      echo 0;
    } else {
      echo $total_advised[0]['total_advised'];
    }
  }
  public function get_sched_info()
  {

    $array_data = array(
      'sc' => $this->input->get('schedCode'),
    );
    $info = $this->Schedule_Model->get_sched_info($array_data);

    if ($info == NULL) {
      echo 0;
    } else {
      echo json_encode($info);
    }
  }

  public function drop_choice()
  {

    $sy  = $this->input->post('School_year');
    $sem = $this->input->post('Semester');
    $sn  = $this->input->post('student_num');

    redirect($this->router->fetch_class() . '/Dropping/' . $sn . '/' . $sy . '/' . $sem, 'refresh');
  }

  public function Dropping($sn = '', $sy = '', $sem = '')
  {

    $array = array(
      'sy'          =>  $sy,
      'sem'         =>  $sem,
      'student_num' =>  $sn
    );

    //$this->data['Legend']       = $this->DroppingSubjects_Model->Get_Legend();
    $this->data['Legend'] = $this->Schedule_Model->get_legend();
    $this->data['getsem']        = $this->DroppingSubjects_Model->Get_sem();
    $this->data['getsy']       = $this->DroppingSubjects_Model->Get_sy();
    $this->data['Student_Info'] = $this->DroppingSubjects_Model->Get_enrolled($array);
    //$this->data['Student_Info'] = $this->SubjectEdit_Model->Get_enrolled($array);


    if ($this->data['Student_Info'] <= 0) {
      $this->session->set_flashdata('nosn', 'No Result');
    }

    $this->render($this->set_views->dropping());
  }
  public function DropSubject()
  {

    if ($this->input->post('sched_code') === '') {

      $this->session->set_flashdata('NoSched', 'PLEASE CHOOSE SUBJECT TO DROP!!');
      redirect($this->router->fetch_class() . '/Dropping/' . $sn . '/' . $sy . '/' . $sem, 'refresh');
    }
    $this->session->set_flashdata('NoSched', '');
    $array = array(
      'sn'         => $this->input->post('sn'),
      'sc'         => $this->input->post('sched_code'),
      'sem'        => $this->input->post('sem'),
      'sy'         => $this->input->post('sy')

    );


    $sy  = $this->input->post('sy');
    $sem = $this->input->post('sem');
    $sn  = $this->input->post('sn');
    $refund = $this->input->post('refund');

    //FOR DROPPING
    if ($refund == 'refund') {

      $this->array_logs['action'] = $this->DroppingSubjects_Model->Drop_Subject($array);
      $this->array_logs['module'] = 'Dropping';
      //Logs
      $this->Others_Model->insert_logs($this->array_logs);

      // FOR CHARGING
    }
    if ($refund == 'norefund') {

      $this->array_logs['action'] = $this->DroppingSubjects_Model->Charged_Subject($array);
      $this->array_logs['module'] = 'Dropping';
      //Logs
      $this->Others_Model->insert_logs($this->array_logs);
    }



    // student fees assessment
    $array_data = array(
      'student_num'         => $this->input->post('sn'),
      'sem'        => $this->input->post('sem'),
      'sy'         => $this->input->post('sy')
    );
    $itemresult = $this->SubjectEdit_Model->Get_enrolled_with_charged($array_data);
    $this->array_logs['module'] = 'Dropping';
    $itemresult['sched_code'] = $this->input->post('sched_code');
    $this->update_student_fees($itemresult);

    redirect($this->router->fetch_class() . '/Dropping/' . $sn . '/' . $sy . '/' . $sem, 'refresh');
  }
  public function getstudentinfo()
  {


    //2nd level form checker
    $config = array(
      array(
        'field' => 'semester',
        'label' => 'Semester',
        'rules' => 'required'
      ),
      array(
        'field' => 'schoolYear',
        'label' => 'School Year',
        'rules' => 'required'
      ),
      array(
        'field' => 'studentid',
        'label' => 'Student Number',
        'rules' => 'required|numeric|trim'
      )
    );

    $input = array(
      'sem' => $this->input->get('semester'),
      'sy' => $this->input->get('schoolYear'),
      'student_num' => $this->input->get('studentid')
    );
    $studentinfo = $this->SubjectEdit_Model->Get_enrolled($input);

    echo json_encode($studentinfo);
  }
  //Modify Subjects Module
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

    $this->array_logs['module'] = 'Class List Report';
    $this->array_logs['action'] = 'Search Class List = Schedule Code: ' . $array['sc'];
    $this->Others_Model->insert_logs($this->array_logs);
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
      $object->setActiveSheetIndex(0)->getStyle('' . $excel_row . '')->getAlignment()
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

    $this->array_logs['module'] = 'Class List Report';
    $this->array_logs['action'] = 'Export Class List = Schedule Code: ' . $sc;
    $this->Others_Model->insert_logs($this->array_logs);
  }
  //CLASS LISTING MODULE

  //PAGINATION LINKS DESIGN
  public function pagination_design()
  {

    // integrate bootstrap pagination
    $config['full_tag_open'] = '<ul class="pagination">';
    $config['full_tag_close'] = '</ul>';
    $config['first_link'] = false;
    $config['last_link'] = false;
    $config['first_tag_open'] = '<li>';
    $config['first_tag_close'] = '</li>';
    $config['prev_link'] = 'Prev';
    $config['prev_tag_open'] = '<li class="prev">';
    $config['prev_tag_close'] = '</li>';
    $config['next_link'] = 'Next';
    $config['next_tag_open'] = '<li>';
    $config['next_tag_close'] = '</li>';
    $config['last_tag_open'] = '<li>';
    $config['last_tag_close'] = '</li>';
    $config['cur_tag_open'] = '<li class="active"><a href="#">';
    $config['cur_tag_close'] = '</a></li>';
    $config['num_tag_open'] = '<li>';
    $config['num_tag_close'] = '</li>';

    return $config;
  }



  //CHOICE  SHS BUTTON
  public function EnrolledStudentShsREPORT()
  {

    $SB    = $this->input->post('search_button');
    $EX   = $this->input->post('export');


    //Checker of pages
    if (isset($SB)) {
      $this->EnrolledStudentsSHS();
    } else if (isset($EX)) {
      $this->EnrolledStudentShsExcel();
    }
  }

  // ENROLLED STUDENT SHS REPORT

  public function EnrolledStudentsSHS()
  {

    $this->data['Get_Levels']    = $this->EnrolledStudentShs_Model->Select_Level();
    $this->data['Get_Strand']    = $this->EnrolledStudentShs_Model->Select_Strand();

    $array = array(
      'School_year'  => $this->input->post('School_year'),
      'Gender'       => $this->input->post('Gender'),
      'GLVL'         => $this->input->post('GLVL'),
      'Strand'       => $this->input->post('Strand')
    );

    $this->data['GetStudent'] = $this->EnrolledStudentShs_Model->GetStudentList($array);
    $this->render($this->set_views->enrolled_studentShs());
  }

  // ENROLLED STUDENT SHS EXCEL

  public function EnrolledStudentShsExcel()
  {

    $array = array(
      'School_year'  => $this->input->post('School_year'),
      'Gender'       => $this->input->post('Gender'),
      'GLVL'         => $this->input->post('GLVL'),
      'Strand'       => $this->input->post('Strand')
    );

    // $this->load->library("Excel");
    $object = new Spreadsheet();
    $table_columns = array("#", "NAME", "STUDENT NUMBER", "GRADE LEVEL", "STRAND", "GENDER", "ADDRESS", "CONTACT NUMBER", "BIRTHDAY", "NATIONALITY");
    $object->getActiveSheet()->getColumnDimension('B')->setWidth(40);
    $object->getActiveSheet()->getColumnDimension('C')->setWidth(25);
    $object->getActiveSheet()->getColumnDimension('D')->setWidth(20);
    $object->getActiveSheet()->getColumnDimension('E')->setWidth(20);
    $object->getActiveSheet()->getColumnDimension('F')->setWidth(20);
    $object->getActiveSheet()->getColumnDimension('G')->setWidth(100);
    $object->getActiveSheet()->getColumnDimension('H')->setWidth(20);
    $object->getActiveSheet()->getColumnDimension('I')->setWidth(20);
    $object->getActiveSheet()->getColumnDimension('J')->setWidth(60);
    $object->getActiveSheet()->getColumnDimension('K')->setWidth(20);


    $column = 1;

    foreach ($table_columns1 as $field) {
      $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
      $column++;
    }
    $column = 1;
    foreach ($table_columns as $field) {
      $object->getActiveSheet()->setCellValueByColumnAndRow($column, 2, $field);
      $column++;
    }

    $employee_data = $this->EnrolledStudentShs_Model->GetStudentList($array);

    $excel_row = 3;
    $count = 1;
    foreach ($employee_data->result_array() as $row) {
      $object->getActiveSheet()->getStyle('' . $excel_row . '')->getAlignment()
        ->setHorizontal('left');
      $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row,  $count);
      $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row,  strtoupper($row['Last_Name'] . ' ' . $row['First_Name'] . ' ' . $row['Middle_Name']));
      $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row,  $row['Student_number']);
      $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row,  strtoupper($row['GradeLevel']));
      $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row,  strtoupper($row['ST']));
      $object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row,  strtoupper($row['Gender']));
      $object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row,  strtoupper($row['Address_No'] . ' ' . $row['Address_Street'] . ' ' . $row['Address_Subdivision'] . ' ' . $row['Address_Barangay'] . '  ' . $row['Address_City'] . '  ' . $row['Address_Province']));
      $object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row,  $row['Mobile_No']);
      $object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row,  $row['Birth_Date']);
      $object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row,  $row['Nationality']);
      $count = $count + 1;
      $excel_row++;
    }

    $object_writer = new \PhpOffice\PhpSpreadsheet\Writer\Xls($object);
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="StudentShs_Data.xls"');
    $object_writer->save('php://output');


    $this->array_logs['module'] = 'Enrolled Student Shs Report';
    $this->array_logs['action'] = 'Export Enrolled Shs Student: School Year: ' . $array['sy'];
    $this->Others_Model->insert_logs($this->array_logs);
  }


  //CHOICE  BED  BUTTON
  public function EnrolledStudentBEDREPORT()
  {

    $SB    = $this->input->post('search_button');
    $EX   = $this->input->post('export');


    //Checker of pages
    if (isset($SB)) {
      $this->EnrolledStudentsBED();
    } else if (isset($EX)) {
      $this->EnrolledStudentBEDExcel();
    }
  }

  // ENROLLED STUDENT BED REPORT
  public function EnrolledStudentsBED()
  {

    $this->data['Get_Levels']    = $this->EnrolledStudentBed_Model->Select_Level();

    $array = array(
      'School_year'  => $this->input->post('School_year'),
      'Gender'       => $this->input->post('Gender'),
      'GLVL'         => $this->input->post('GLVL'),
    );

    $this->data['GetStudent'] = $this->EnrolledStudentBed_Model->GetStudentList($array);
    $this->render($this->set_views->enrolled_studentBed());
  }

  // ENROLLED STUDENT BED EXCEL

  public function EnrolledStudentBEDExcel()
  {

    $array = array(
      'School_year'  => $this->input->post('School_year'),
      'Gender'       => $this->input->post('Gender'),
      'GLVL'         => $this->input->post('GLVL'),
    );


    // $this->load->library("Excel");
    $object = new Spreadsheet();
    $table_columns = array("#", "NAME", "STUDENT NUMBER", "GRADE LEVEL", "GENDER", "ADDRESS", "CONTACT NUMBER", "BIRTHDAY", "NATIONALITY");
    $object->getActiveSheet()->getColumnDimension('B')->setWidth(40);
    $object->getActiveSheet()->getColumnDimension('C')->setWidth(25);
    $object->getActiveSheet()->getColumnDimension('D')->setWidth(20);
    $object->getActiveSheet()->getColumnDimension('E')->setWidth(20);
    $object->getActiveSheet()->getColumnDimension('F')->setWidth(100);
    $object->getActiveSheet()->getColumnDimension('G')->setWidth(20);
    $object->getActiveSheet()->getColumnDimension('H')->setWidth(20);
    $object->getActiveSheet()->getColumnDimension('I')->setWidth(20);
    $object->getActiveSheet()->getColumnDimension('J')->setWidth(60);
    $object->getActiveSheet()->getColumnDimension('K')->setWidth(20);


    $column = 1;

    foreach ($table_columns1 as $field) {
      $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
      $column++;
    }
    $column = 1;
    foreach ($table_columns as $field) {
      $object->getActiveSheet()->setCellValueByColumnAndRow($column, 2, $field);
      $column++;
    }

    $employee_data = $this->EnrolledStudentBed_Model->GetStudentList($array);

    $excel_row = 3;
    $count = 1;
    foreach ($employee_data->result_array() as $row) {
      $object->getActiveSheet()->getStyle('' . $excel_row . '')->getAlignment()
        ->setHorizontal('left');
      $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row,  $count);
      $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row,  strtoupper($row['Last_Name'] . ' ' . $row['First_Name'] . ' ' . $row['Middle_Name']));
      $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row,  $row['Student_number']);
      $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row,  strtoupper($row['GradeLevel']));
      $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row,  strtoupper($row['Gender']));
      $object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row,  strtoupper($row['Address_No'] . ' ' . $row['Address_Street'] . ' ' . $row['Address_Subdivision'] . ' ' . $row['Address_Barangay'] . '  ' . $row['Address_City'] . '  ' . $row['Address_Province']));
      $object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row,  $row['Mobile_No']);
      $object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row,  $row['Birth_Date']);
      $object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row,   strtoupper($row['Nationality']));
      $count = $count + 1;
      $excel_row++;
    }

    $object_writer = new \PhpOffice\PhpSpreadsheet\Writer\Xls($object);
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="StudentBED_Data.xls"');
    $object_writer->save('php://output');


    $this->array_logs['module'] = 'Enrolled Student BED Report';
    $this->array_logs['action'] = 'Export Enrolled BED Student: School Year: ' . $array['sy'];
    $this->Others_Model->insert_logs($this->array_logs);
  }


  //CHOICE BUTTON
  public function EnrolledStudentREPORT()
  {

    $SB    = $this->input->post('search_button');
    $EX   = $this->input->post('export');


    //Checker of pages
    if (isset($SB)) {
      $this->EnrolledStudent();
    } else if (isset($EX)) {
      $this->EnrolledStudentExcel();
    }
  }

  //Get Program Major
  function fetch_major()
  {
    if ($this->input->post('Program_id')) {
      $resultdata = $this->EnrolledStudent_Model->GetMajor($this->input->post('Program_id'));
      echo json_encode($resultdata);
    }
  }

  //Get Sections
  function fetch_sections()
  {
    if ($this->input->post('Program_id')) {
      $resultdata = $this->EnrolledStudent_Model->GetSection_Name($this->input->post('Program_id'));
      echo json_encode($resultdata);
    }
  }



  //REGISTRAR FOREIGN ENROLLED STUDENT REPORT MODULE
  public function EnrolledStudentForeign()
  {
    $this->data['Get_SEM']                 = $this->EnrolledStudent_Model->GetSEM();
    $this->data['Get_YEAR']                = $this->EnrolledStudent_Model->GetYEAR();
    $this->data['Get_Nationality']         = $this->EnrolledStudent_Foreign_Model->Get_Nationality();
    $this->data['Get_Course']              = $this->EnrolledStudent_Model->Get_Course();
    $this->data['Get_YearLevel']           = $this->EnrolledStudent_Model->GetYearLevel();
    $this->render($this->set_views->enrolled_student_foreign());
  }

  public function Get_Foreign_ajax()
  {

    $array = array(
      'school_year'  => $this->input->post('school_year'),
      'semester'     => $this->input->post('semester'),
      'gender'       => $this->input->post('gender'),
      'nationality'  => $this->input->post('nationality'),
      'program'      => $this->input->post('program'),
      'major'        => $this->input->post('major'),
      'yearlevel'    => $this->input->post('yearlevel'),

    );

    $resultdata = $this->EnrolledStudent_Foreign_Model->GetStudentList_Foreign($array);
    echo json_encode($resultdata);
  }

  public function EnrolledStudentForeignExCell()
  {


    $array = array(
      'school_year'  => $this->input->post('School_year'),
      'semester'     => $this->input->post('Sem'),
      'gender'       => $this->input->post('Gender'),
      'nationality'  => $this->input->post('National'),
      'program'      => $this->input->post('Program'),
      'major'        => $this->input->post('mjr'),
      'yearlevel'    => $this->input->post('YL'),

    );

    // $this->load->library("Excel");
    $object = new Spreadsheet();
    $table_columns = array("#", "NAME", "STUDENT NUMBER", "COURSE", "GENDER", "ADDRESS", "APPLIED STATUS", "YEAR", "CONTACT NUMBER", "HIGH SCHOOL", "LAST SCHOOL ATTENDED", "CURICULUM", "BIRTHDAY", "NATIONALITY");
    $object->getActiveSheet()->getColumnDimension('B')->setWidth(40);
    $object->getActiveSheet()->getColumnDimension('C')->setWidth(25);
    $object->getActiveSheet()->getColumnDimension('D')->setWidth(20);
    $object->getActiveSheet()->getColumnDimension('E')->setWidth(20);
    $object->getActiveSheet()->getColumnDimension('F')->setWidth(100);
    $object->getActiveSheet()->getColumnDimension('G')->setWidth(20);
    $object->getActiveSheet()->getColumnDimension('H')->setWidth(20);
    $object->getActiveSheet()->getColumnDimension('I')->setWidth(20);
    $object->getActiveSheet()->getColumnDimension('J')->setWidth(60);
    $object->getActiveSheet()->getColumnDimension('K')->setWidth(20);
    $object->getActiveSheet()->getColumnDimension('L')->setWidth(25);
    $object->getActiveSheet()->getColumnDimension('M')->setWidth(25);
    $object->getActiveSheet()->getColumnDimension('N')->setWidth(30);
    $object->getActiveSheet()->getColumnDimension('O')->setWidth(30);
    $object->getActiveSheet()->getColumnDimension('P')->setWidth(25);
    $object->getActiveSheet()->getColumnDimension('Q')->setWidth(25);
    $object->getActiveSheet()->getColumnDimension('R')->setWidth(25);
    $object->getActiveSheet()->getColumnDimension('S')->setWidth(25);
    $object->getActiveSheet()->getColumnDimension('T')->setWidth(25);
    $object->getActiveSheet()->getColumnDimension('U')->setWidth(25);

    $column = 1;

    foreach ($table_columns1 as $field) {
      $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
      $column++;
    }
    $column = 1;
    foreach ($table_columns as $field) {
      $object->getActiveSheet()->setCellValueByColumnAndRow($column, 2, $field);
      $column++;
    }

    $employee_data = $this->EnrolledStudent_Foreign_Model->GetStudentList_Foreign($array);

    $excel_row = 3;
    $count = 1;
    foreach ($employee_data as $row) {
      $object->getActiveSheet()->getStyle('' . $excel_row . '')->getAlignment()
        ->setHorizontal('left');
      $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row,  $count);
      $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row,  strtoupper($row['Last_Name'] . ',' . $row['First_Name'] . '' . $row['Middle_Name']));
      $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row,  $row['Student_Number']);
      $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row,  strtoupper($row['Course']));
      $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row,  strtoupper($row['Gender']));
      $object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row,  strtoupper($row['Address_No'] . ' ' . $row['Address_Street'] . ' ' . $row['Address_Subdivision'] . ' ' . $row['Address_Barangay'] . '  ' . $row['Address_City'] . '  ' . $row['Address_Province']));
      if ($row['Transferee_Name'] == NULL || $row['Transferee_Name'] == 'N/A' || $row['Transferee_Name'] == '' || $row['Transferee_Name'] == '-' || $row['Transferee_Name'] == 'Na' || $row['Transferee_Name'] == 'NA') :
        $New = 'New';
      else :
        $New =  'Transferee';
      endif;

      $object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row,  $New);
      $object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row,  $row['YL']);
      $object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row,  $row['CP_No']);
      $object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row,  $row['Secondary_School_Name']);
      if ($row['Transferee_Name'] == NULL || $row['Transferee_Name'] == 'N/A' || $row['Transferee_Name'] == '' || $row['Transferee_Name'] == '-' || $row['Transferee_Name'] == 'Na' || $row['Transferee_Name'] == 'NA') :
        $lastschool = $row['Secondary_School_Name'];
      else :
        $lastschool = $row['Transferee_Name'];
      endif;
      $object->getActiveSheet()->setCellValueByColumnAndRow(11, $excel_row, $lastschool);
      $object->getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row,  $row['Course'] . ':' . $row['AdmittedSY'] . ':' . $row['Program_Majors']);
      $object->getActiveSheet()->setCellValueByColumnAndRow(13, $excel_row,  $row['Birth_Date']);
      $object->getActiveSheet()->setCellValueByColumnAndRow(14, $excel_row,  $row['Nationality']);
      $count = $count + 1;
      $excel_row++;
    }

    $object_writer = new \PhpOffice\PhpSpreadsheet\Writer\Xls($object);
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="Student_Data.xls"');
    $object_writer->save('php://output');


    $this->array_logs['module'] = 'Enrolled Student Report';
    $this->array_logs['action'] = 'Export Enrolled Student: School Year: ' . $array['sy'] . ' SEMESTER:' . $array['sm'];
    $this->Others_Model->insert_logs($this->array_logs);
  }
  ///REGISTRAR FOREIGN ENROLLED STUDENT REPORT MODULE


  ///REGISTRAR ENROLLED STUDENT REPORT MODULE
  // dito
  public function EnrolledStudent()
  {

    $this->data['Get_SEM']                 = $this->EnrolledStudent_Model->GetSEM();
    $this->data['Get_YEAR']                = $this->EnrolledStudent_Model->GetYEAR();
    $this->data['Get_Nationality']         = $this->EnrolledStudent_Model->Get_Nationality();
    $this->data['Get_Course']              = $this->EnrolledStudent_Model->Get_Course();
    $this->data['Get_YearLevel']           = $this->EnrolledStudent_Model->GetYearLevel();

    $array = array(
      'sy'         => $this->input->post('School_year'),
      'sm'         => $this->input->post('Sem'),
      'nt'         => $this->input->post('National'),
      'pmajor'     => $this->input->post('Program'),
      'major'      => $this->input->post('mjr'),
      'Gender'     => $this->input->post('Gender'),
      'YL'         => $this->input->post('YL'),
      'Sec'        => $this->input->post('Section'),
      'submit'     => $this->input->post('search_button'),
      'search'       => '0',
      'excel'       => '0',
    );
    if ($this->input->post('search_button') !== null) {
      $array['search'] = '1';
    }
    if ($this->input->post('export') !== null) {
      $array['excel'] = '1';
    }
    // die(json_encode($array));
    $this->data['GetStudent'] = $this->EnrolledStudent_Model->GetStudentList($array);


    // die($this->data['GetStudent']);

    $this->array_logs['module'] = 'Enrolled Student Report';
    $this->array_logs['action'] = 'Search Enrolled Student: School Year: ' . $array['sy'] . ' SEMESTER:' . $array['sm'];
    $this->Others_Model->insert_logs($this->array_logs);
    // die(json_encode($this->array_logs['GetStudent']));


    $this->render($this->set_views->enrolled_student());
  }

  public function EnrolledStudentExcel()
  {


    $array = array(
      'sy'         => $this->input->post('School_year'),
      'sm'         => $this->input->post('Sem'),
      'nt'         => $this->input->post('National'),
      'pmajor'     => $this->input->post('Program'),
      'major'      => $this->input->post('mjr'),
      'Gender'     => $this->input->post('Gender'),
      'YL'         => $this->input->post('YL'),
      'Sec'        => $this->input->post('Section'),
      'submit'     => $this->input->post('search_button'),
      'search'       => '0',
      'excel'       => '0',
    );
    if ($this->input->post('search_button') !== null) {
      $array['search'] = '1';
    }
    if ($this->input->post('export') !== null) {
      $array['excel'] = '1';
    }


    // $this->load->library("Excel");
    $object = new Spreadsheet();
    $table_columns = array("#", "NAME", "STUDENT NUMBER", "COURSE", "GENDER", "ADDRESS", "APPLIED STATUS", "YEAR", "CONTACT NUMBER", "HIGH SCHOOL", "LAST SCHOOL ATTENDED", "CURICULUM", "BIRTHDAY", "NATIONALITY");
    $object->getActiveSheet()->getColumnDimension('B')->setWidth(40);
    $object->getActiveSheet()->getColumnDimension('C')->setWidth(25);
    $object->getActiveSheet()->getColumnDimension('D')->setWidth(20);
    $object->getActiveSheet()->getColumnDimension('E')->setWidth(20);
    $object->getActiveSheet()->getColumnDimension('F')->setWidth(100);
    $object->getActiveSheet()->getColumnDimension('G')->setWidth(20);
    $object->getActiveSheet()->getColumnDimension('H')->setWidth(20);
    $object->getActiveSheet()->getColumnDimension('I')->setWidth(20);
    $object->getActiveSheet()->getColumnDimension('J')->setWidth(60);
    $object->getActiveSheet()->getColumnDimension('K')->setWidth(20);
    $object->getActiveSheet()->getColumnDimension('L')->setWidth(25);
    $object->getActiveSheet()->getColumnDimension('M')->setWidth(25);
    $object->getActiveSheet()->getColumnDimension('N')->setWidth(30);
    $object->getActiveSheet()->getColumnDimension('O')->setWidth(30);
    $object->getActiveSheet()->getColumnDimension('P')->setWidth(25);
    $object->getActiveSheet()->getColumnDimension('Q')->setWidth(25);
    $object->getActiveSheet()->getColumnDimension('R')->setWidth(25);
    $object->getActiveSheet()->getColumnDimension('S')->setWidth(25);
    $object->getActiveSheet()->getColumnDimension('T')->setWidth(25);
    $object->getActiveSheet()->getColumnDimension('U')->setWidth(25);

    $column = 1;

    foreach ($table_columns1 as $field) {
      $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
      $column++;
    }
    $column = 1;
    foreach ($table_columns as $field) {
      $object->getActiveSheet()->setCellValueByColumnAndRow($column, 2, $field);
      $column++;
    }

    $employee_data = $this->EnrolledStudent_Model->GetStudentList($array);

    $excel_row = 3;
    $count = 1;
    foreach ($employee_data->result_array() as $row) {
      $object->getActiveSheet()->getStyle('' . $excel_row . '')->getAlignment()
        ->setHorizontal('left');
      $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row,  $count);
      $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row,  strtoupper($row['Last_Name'] . ',' . $row['First_Name'] . '' . $row['Middle_Name']));
      $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row,  $row['Student_Number']);
      $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row,  strtoupper($row['Course']));
      $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row,  strtoupper($row['Gender']));
      $object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row,  strtoupper($row['Address_No'] . ' ' . $row['Address_Street'] . ' ' . $row['Address_Subdivision'] . ' ' . $row['Address_Barangay'] . '  ' . $row['Address_City'] . '  ' . $row['Address_Province']));
      if ($row['Transferee_Name'] == NULL || $row['Transferee_Name'] == 'N/A' || $row['Transferee_Name'] == '' || $row['Transferee_Name'] == '-' || $row['Transferee_Name'] == 'Na' || $row['Transferee_Name'] == 'NA') :
        $New = 'New';
      else :
        $New =  'Transferee';
      endif;

      $object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row,  $New);
      $object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row,  $row['YL']);
      $object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row,  $row['CP_No']);
      $object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row,  $row['Secondary_School_Name']);
      if ($row['Transferee_Name'] == NULL || $row['Transferee_Name'] == 'N/A' || $row['Transferee_Name'] == '' || $row['Transferee_Name'] == '-' || $row['Transferee_Name'] == 'Na' || $row['Transferee_Name'] == 'NA') :
        $lastschool = $row['Secondary_School_Name'];
      else :
        $lastschool = $row['Transferee_Name'];
      endif;
      $object->getActiveSheet()->setCellValueByColumnAndRow(11, $excel_row, $lastschool);
      $object->getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row,  $row['Course'] . ':' . $row['AdmittedSY'] . ':' . $row['Program_Majors']);
      $object->getActiveSheet()->setCellValueByColumnAndRow(13, $excel_row,  $row['Birth_Date']);
      $object->getActiveSheet()->setCellValueByColumnAndRow(14, $excel_row,  $row['Nationality']);
      $count = $count + 1;
      $excel_row++;
    }

    $object_writer = new \PhpOffice\PhpSpreadsheet\Writer\Xls($object);
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="Student_Data.xls"');
    $object_writer->save('php://output');


    $this->array_logs['module'] = 'Enrolled Student Report';
    $this->array_logs['action'] = 'Export Enrolled Student: School Year: ' . $array['sy'] . ' SEMESTER:' . $array['sm'];
    $this->Others_Model->insert_logs($this->array_logs);
  }

  ///REGISTRAR ENROLLED STUDENT REPORT MODULE


  ///REGISTRAR CHANGE CLASS SECTION
  public function ChangeSection()
  {

    // $this->data['Legend']       = $this->DroppingSubjects_Model->Get_Legend();

    $this->data['getsem']        = $this->DroppingSubjects_Model->Get_sem();
    $this->data['getsy']       = $this->DroppingSubjects_Model->Get_sy();

    $array = array(
      'student_num'       => $this->input->post('student_num'),
      'sem'             => $this->input->post('Semester'),
      'sy'      => $this->input->post('School_year')
    );

    $this->data['data']   = $this->ChangeSection_Model->Get_enrolled($array);


    if ($array['student_num'] != '') {
      if (empty($this->data['data'])) {
        $this->session->set_flashdata('nosn', 'Filter entered did not find any records');
      } else {
        unset($_SESSION['nosn']);
      }
    }

    foreach ($this->data['data'] as $row) {

      $Course = $row->Course;
    }
    $this->data['get_TotalCountSubject']        = $this->ChangeSection_Model->Get_CountSubject_enrolled($array);
    $this->data['section']                      = $this->ChangeSection_Model->get_section($Course);

    $this->render($this->set_views->Change_Section());
  }



  function fetch_sched()
  {
    $array = array(
      'sem' => $this->input->get('semester'),
      'sy'  => $this->input->get('schoolyear'),
      'section' => $this->input->get('sections')
    );
    $result = $this->ChangeSection_Model->get_sched($array);
    echo json_encode($result);
  }


  public function InsertAndUpdate()
  {
    $this->UpdateSched();
    $this->InsertNewSched();

    // student fees assessment
    $array_data = array(
      'student_num'         => $this->input->post('sn'),
      'sem'               => $this->input->post('sem'),
      'sy'                => $this->input->post('sy')
    );
    $itemresult = $this->SubjectEdit_Model->Get_enrolled_with_charged($array_data);
    $this->array_logs['module'] = 'Change Section';
    //   $itemresult['sched_code'] = $this->input->post('sched_code');  //
    $this->update_student_fees($itemresult);
    // student fees assessment
    redirect('/registrar/ChangeSection/' . $Semester . '/' . $SchoolYear . '/' . $Search, 'refresh');
  }

  public function UpdateSched()
  {

    $array = array(
      'sn'       => $this->input->post('sn'),
      'sem'     => $this->input->post('sem'),
      'sy'      => $this->input->post('sy')
    );

    $this->array_logs['action'] = $this->ChangeSection_Model->Update_Sched($array);
    $this->array_logs['module'] = 'Change Section';
    //Logs
    $this->Others_Model->insert_logs($this->array_logs);
  }

  public function InsertNewSched()
  {

    $echoSection     = $this->input->post('SCCC'); //Section
    $echoSchedCode   = $this->input->post('schedData'); //SchedCode
    $echoSemester    = $this->input->post('SEMS'); //Semester
    $echoSchoolYear  = $this->input->post('SYS'); //ScchoolYear
    $echoYearLevel   = $this->input->post('YearLevels'); //YearLevel
    $echoSchedID     = $this->input->post('SchedID');

    $echoRef           = $this->input->post('ref');
    $echoCourse        = $this->input->post('course');
    $echoSn            = $this->input->post('sn');
    $echoMajor         = $this->input->post('major');
    $echoPayment_plan  = $this->input->post('payment_plan');
    $echoScheduler     = $this->input->post('scheduler');
    $echoSdate         = $this->input->post('sdate');
    $echoStatus        = $this->input->post('status');

    if ($echoMajor == 'N/A') {
      $Major = '0';
    }

    $count = 0;
    $insert = array();

    $insert['Reference_Number']  = $echoRef;
    $insert['Student_Number']    = $echoSn;
    $insert['Semester']          = $echoSemester;
    $insert['School_Year']       = $echoSchoolYear;
    $insert['Scheduler']         = $echoScheduler;
    $insert['Sdate']             = $echoSdate;
    $insert['Status']            = $echoStatus;
    $insert['Program']           = $echoCourse;
    $insert['Major']             = $Major;
    $insert['Year_Level']        = $echoYearLevel;
    $insert['Payment_Plan']      = $echoPayment_plan;
    $insert['Section']           = $echoSection;
    $insert['Dropped']           = '0';
    $insert['Cancelled']         = '0';
    $insert['Charged']           = '0';

    // echo "<pre>";
    // echo json_encode($insert, JSON_PRETTY_PRINT) . '<hr>';
    // echo "</pre>";

    foreach ($echoSchedCode  as $row) {


      // echo $row . '<br>';

      $insert['Sched_Code'] = $row;
      $insert['Sched_Display_ID'] = $echoSchedID[$count];

      $count++;
      $this->array_logs['action'] = $this->ChangeSection_Model->InsertNewSched($insert);
      $this->array_logs['module'] = 'Change Section';
      //Logs
      $this->Others_Model->insert_logs($this->array_logs);
    }
    // die();
  }




  ///REGISTRAR CHANGE CLASS SECTION


  //get student fees
  public function get_fee($array_student_data)
  {
    //get student enrolled fees

    $array_data = array(
      'program_code' => $array_student_data[0]['Program'],
      'year_level' => $array_student_data[0]['YL'],
      'school_year' => $array_student_data[0]['School_Year'],
      'semester' => $array_student_data[0]['Semester'],
      'AdmittedSY' => $array_student_data[0]['AdmittedSY'],
      'AdmittedSEM' => $array_student_data[0]['AdmittedSEM'],
      'plan' => $array_student_data[0]['fullpayment'],
      'reference_no' => $array_student_data[0]['Reference_Number'],
    );



    $array_fees = $this->Fees_Model->get_fees_listing($array_data);
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

        if ($array_data['plan'] == 0) {
          $total_misc += ($fees['Fees_Amount'] * $this->installment_interest);
        } else {
          $total_misc += $fees['Fees_Amount'];
        }
      } else {
        if ($array_data['plan'] == 0) {
          $total_other += ($fees['Fees_Amount'] * $this->installment_interest);
        } else {
          $total_other += $fees['Fees_Amount'];
        }
      }
    }

    //check if student is a foreigner
    $foreigner_checker = $this->Student_Model->check_if_foreigner($array_data['reference_no']);

    if ($foreigner_checker === 1) {
      # code...
      //get foreign fee (other fee)

      $foreign_fee = $this->Fees_Model->get_foreign_fee($array_data);

      if ($foreign_fee) {
        if ($array_data['plan'] == 0) {
          $total_other += ($foreign_fee[0]['Fees_Amount'] * $this->installment_interest);
        } else {
          $total_other += $foreign_fee[0]['Fees_Amount'];
        }
      }


      //print "foreign fee <br/>";
      //print_r($foreign_fee);

    }

    //get subject other fee
    $array_subject_other_fee = $this->Fees_Model->get_subject_other_fees($array_data);
    foreach ($array_subject_other_fee as $key => $subject_other_fee) {
      # code...
      if ($array_data['plan'] == 0) {
        $total_other += ($subject_other_fee['Other_Fee'] * $this->installment_interest);
      } else {

        $total_other += $subject_other_fee['Other_Fee'];
      }
    }

    $total_other = number_format($total_other, 2, '.', '');
    $total_misc = number_format($total_misc, 2, '.', '');

    //compute total units
    $total_units = 0;
    foreach ($array_student_data as $key => $student_data) {
      # code...
      if (is_numeric($key)) {
        # code...
        $total_units += $student_data['Course_Lec_Unit'];
        $total_units += $student_data['Course_Lab_Unit'];
      }
    }


    //tuition fee
    $tuition = $array_fees[0]['TuitionPerUnit'] * $total_units;

    if ($array_data['plan'] == 0) {
      $tuition *=  $this->installment_interest;
    }
    $tuition = number_format($tuition, 2, '.', '');

    //get subject lab fee
    $total_lab_fee = 0;
    $array_subject_lab_fee = $this->Fees_Model->get_subject_lab_fee($array_data);
    foreach ($array_subject_lab_fee as $key => $subject_lab_fee) {
      # code...
      if ($array_data['plan'] == 0) {
        $total_lab_fee += ($subject_lab_fee['Lab_Fee'] * $this->installment_interest);
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


    return $array_output;
  }

  public function update_student_fees($array_student_data)
  {
    $array_data = array(
      'program_code' => $array_student_data[0]['Program'],
      'year_level' => $array_student_data[0]['YL'],
      'school_year' => $array_student_data[0]['School_Year'],
      'semester' => $array_student_data[0]['Semester'],
      'AdmittedSY' => $array_student_data[0]['AdmittedSY'],
      'AdmittedSEM' => $array_student_data[0]['AdmittedSEM'],
      'plan' => $array_student_data[0]['fullpayment'],
      'reference_no' => $array_student_data[0]['Reference_Number'],
      'fees_enrolled_college_id' => $array_student_data[0]['fees_enrolled_college_id'],
      'date' => $this->date
    );
    // echo '<pre>';
    // echo json_encode($array_data);
    // echo '</pre>';
    // die();

    $array_computed_fees = $this->get_fee($array_student_data);
    if (!$array_computed_fees) {
      # code...
      return;
    }
    //print_r($array_computed_fees);
    //return;

    if ($array_data['plan'] == 0) {
      //get installment plan formula
      $array_plan_formula = $this->Fees_Model->get_payment_plans();

      $array_data['initial_payment'] = number_format(($array_computed_fees['total_fee'] * ($array_plan_formula[0]['Upon_Registration'] / 100)), 2, '.', '');
      $array_data['first_payment'] = number_format(($array_computed_fees['total_fee'] * ($array_plan_formula[0]['First_Pay'] / 100)), 2, '.', '');
      $array_data['second_payment'] = number_format(($array_computed_fees['total_fee'] * ($array_plan_formula[0]['Second_Pay'] / 100)), 2, '.', '');
      $array_data['third_payment'] = number_format(($array_computed_fees['total_fee'] * ($array_plan_formula[0]['Third_Pay'] / 100)), 2, '.', '');
      $array_data['fourth_payment'] = number_format(($array_computed_fees['total_fee'] * ($array_plan_formula[0]['Fourth_Pay'] / 100)), 2, '.', '');

      //$array_data['full_payment'] = 0;

    } else {
      $array_data['initial_payment'] = 0.00;
      //$array_data['full_payment'] = 1;
      $array_data['initial_payment'] = $array_computed_fees['total_fee'];
      $array_data['first_payment'] = 0.00;
      $array_data['second_payment'] = 0.00;
      $array_data['third_payment'] = 0.00;
      $array_data['fourth_payment'] = 0.00;
    }

    //update student fee
    $array_update_fee = array(
      'course' => $array_data['program_code'],
      'tuition_Fee' => $array_computed_fees['tuition_fee'],
      'InitialPayment' => $array_data['initial_payment'],
      'First_Pay' => $array_data['first_payment'],
      'Second_Pay' => $array_data['second_payment'],
      'Third_Pay' => $array_data['third_payment'],
      'Fourth_Pay' => $array_data['fourth_payment']
    );

    //print_r($array_update_fee);
    //return;

    //replace the fees_enrolled_college data
    $this->array_logs['action'] = $this->Fees_Model->replace_fees_college_data($array_update_fee, $array_data);
    //logs
    //$this->Others_Model->insert_logs($this->array_logs);

    //start updating fees_enrolled_college_item table
    $array_fees = $this->Fees_Model->get_fees_listing($array_data);
    //$array_fees_item = array();
    foreach ($array_fees as $key => $fees) {

      if ($array_data['plan'] == 0) {
        $fees['Fees_Amount'] *= $this->installment_interest;
      }

      $array_fees_item[] = array(
        'Fees_Enrolled_College_Id' => $array_data['fees_enrolled_college_id'],
        'Fees_Type' => $fees['Fees_Type'],
        'Fees_Name' => $fees['Fees_Name'],
        'Fees_Amount' => $fees['Fees_Amount'],
        'valid' => 1
      );
    }

    //get foreign fee
    //check if student is a foreigner
    $foreigner_checker = $this->Student_Model->check_if_foreigner($array_data['reference_no']);
    if ($foreigner_checker === 1) {
      # code...
      //get foreign fee (other fee)

      $foreign_fee = $this->Fees_Model->get_foreign_fee($array_data);

      if ($foreign_fee) {
        if ($array_data['plan'] == 0) {
          $foreign_fee[0]['Fees_Amount'] *= $this->installment_interest;
        }

        $array_fees_item[] = array(
          'Fees_Enrolled_College_Id' => $array_data['fees_enrolled_college_id'],
          'Fees_Type' => $foreign_fee[0]['Fees_Type'],
          'Fees_Name' => $foreign_fee[0]['Fees_Name'],
          'Fees_Amount' => $foreign_fee[0]['Fees_Amount'],
          'valid' => 1
        );
      }
    }

    //get subject other fee
    $array_subject_other_fee = $this->Fees_Model->get_subject_other_fees($array_data);
    if ($array_subject_other_fee != NULL) {
      # code...
      foreach ($array_subject_other_fee as $key => $subject_other_fee) {
        # code...
        if ($array_data['plan'] == 0) {
          $subject_other_fee['Other_Fee'] *= $this->installment_interest;
        }

        $array_fees_item[] = array(
          'Fees_Enrolled_College_Id' => $array_data['fees_enrolled_college_id'],
          'Fees_Type' => 'OTHER',
          'Fees_Name' => $subject_other_fee['Subject_Type'],
          'Fees_Amount' => $subject_other_fee['Other_Fee'],
          'valid' => 1
        );
      }
    }

    //get subject lab fee
    $array_subject_lab_fee = $this->Fees_Model->get_subject_lab_fee($array_data);
    if ($array_subject_lab_fee != NULL) {
      # code...

      foreach ($array_subject_lab_fee as $key => $subject_lab_fee) {
        # code...
        if ($array_data['plan'] == 0) {
          $subject_lab_fee['Lab_Fee'] *= $this->installment_interest;
        }
        $array_fees_item[] = array(
          'Fees_Enrolled_College_Id' => $array_data['fees_enrolled_college_id'],
          'Fees_Type' => 'LAB',
          'Fees_Name' => $subject_lab_fee['Subject_Type'],
          'Fees_Amount' => $subject_lab_fee['Lab_Fee'],
          'valid' => 1
        );
      }
    }

    //print_r($array_fees_item);
    //return;

    //update valid to 0 in Fees_Enrolled_College_Item
    $this->array_logs['action'] = $this->Fees_Model->remove_fees_item($array_data['fees_enrolled_college_id']);
    //logs
    //$this->Others_Model->insert_logs($this->array_logs);

    $this->array_logs['action'] = $this->Fees_Model->insert_fees_item($array_fees_item);
    //logs
    //$this->Others_Model->insert_logs($this->array_logs);

    //get fees college item
    $array_fees_item_tuition = $this->Fees_Model->get_fees_item($array_data['fees_enrolled_college_id']);
    //print_r($array_fees_item_tuition);


    ///////////////////////////fees throughput start///////////////////////////

    //$array_fees_item_tuition = $array_fees_item;
    $array_fees_item_tuition[] = array(
      'Fees_Name' => 'Tuition',
      'Fees_Amount' => $array_computed_fees['tuition_fee'],
      'id' => 0,
      'valid' => 1
    );

    //print_r($array_fees_item_tuition);
    //return;

    //get student total payment
    //$array_student_total_payment = $this->Fees_Model->get_student_total_payment($array_data);

    //get student payment list with OR
    $array_student_payment_list = $this->Fees_Model->get_student_payment_list($array_data);
    $array_fees_throughput = array();
    //$payment_balance = number_format(0, 2, '.', '');
    $debt = number_format(0, 2, '.', '');

    foreach ($array_student_payment_list as $key_payment_list => $payment) {
      # code...
      $remaining_payment = number_format($payment['AmountofPayment'], 2, '.', '');

      //add remaning balance to payment
      //$remaining_payment = number_format($remaining_payment + $payment_balance, 2, '.', '');

      /*
      print 'enter next student payment: '.$remaining_payment;
      print '</br>';
      */

      foreach ($array_fees_item_tuition as $key_fees_item => $fee) {
        # code...
        /*
        print $fee['Fees_Name'];
        print '</br>';
        print 'remaining '.$remaining_payment;
        print '</br>';
        print 'fee amount '.$fee['Fees_Amount'];
        print '</br>';
        print_r($fee);
        print '</br>';
        print '</br>';
        */

        if ($fee['valid'] === 0) {
          # code...
          //print 'skip </br>';
          continue;
        } elseif ($debt > $remaining_payment) {
          # code...
          //print 'enter debt is higher than remaining payment';
          //print '</br>';


          $debt  = number_format($debt - $remaining_payment, 2, '.', '');

          $array_fees_throughput[] = array(
            'Reference_Number' => $array_data['reference_no'],
            'AmountofPayment' => $remaining_payment,
            'OR_Number' => $payment['OR_Number'],
            'itemPaid' => $fee['Fees_Name'],
            'Fees_Enrolled_College_Item_id' => $fee['id'],
            'Transaction_Item' => $payment['Transaction_Item'],
            'transDate' => $payment['Date'],
            'Transaction_Type' => $payment['Transaction_Type'],
            'description' => $payment['description'],
            'Semester' => $array_data['semester'],
            'SchoolYear' => $array_data['school_year'],
            'cashier' => $payment['cashier'],
            'web_dose_module' => 1
          );



          //print_r($array_fees_throughput[$key_fees_item]);
          //$payment_balance = number_format($remaining_payment, 2, '.', '');
          //print 'enter payment balance: '.$payment_balance;
          //print 'debt: '.$debt;
          //print '</br>';
          break;
        } elseif (($debt > 0) && ($remaining_payment >= $debt)) {
          # code...
          //print 'enter debt payment';
          //print '</br>';

          $remaining_payment = number_format($remaining_payment - $debt, 2, '.', '');

          /*
          print 'remaining: '.$remaining_payment;
          print '</br>';
          print 'debt: '.$debt;
          print '</br>';

          print 'array count: '.count($array_fees_throughput);
          print '</br>';
          */

          $array_fees_throughput[] = array(
            'Reference_Number' => $array_data['reference_no'],
            'AmountofPayment' => $debt,
            'OR_Number' => $payment['OR_Number'],
            'itemPaid' => $fee['Fees_Name'],
            'Fees_Enrolled_College_Item_id' => $fee['id'],
            'Transaction_Item' => $payment['Transaction_Item'],
            'transDate' => $payment['Date'],
            'Transaction_Type' => $payment['Transaction_Type'],
            'description' => $payment['description'],
            'Semester' => $array_data['semester'],
            'SchoolYear' => $array_data['school_year'],
            'cashier' => $payment['cashier'],
            'web_dose_module' => 1
          );

          //print 'array count: '.count($array_fees_throughput);
          //print '</br>';

          //set debt to 0
          $debt = number_format(0, 2, '.', '');
          //print 'debt: '.$debt;
          //print '</br>';

          //print_r($array_fees_throughput[$key_fees_item]);
          //print '</br>';


          //change valid to 0
          $array_fees_item_tuition[$key_fees_item]['valid'] = 0;
          /*
          print 'set valid to'. $array_fees_item_tuition[$key_fees_item]['valid'];
          print '</br>';
          print '</br>';
          */
        } elseif (($remaining_payment >= $fee['Fees_Amount']) && ($fee['valid'] == 1)) {
          # code...
          //print 'enter fees payment normal';
          //print '</br>';
          $remaining_payment = number_format($remaining_payment - $fee['Fees_Amount'], 2, '.', '');
          $array_fees_throughput[] = array(
            'Reference_Number' => $array_data['reference_no'],
            'AmountofPayment' => number_format($fee['Fees_Amount'], 2, '.', ''),
            'OR_Number' => $payment['OR_Number'],
            'itemPaid' => $fee['Fees_Name'],
            'Fees_Enrolled_College_Item_id' => $fee['id'],
            'Transaction_Item' => $payment['Transaction_Item'],
            'transDate' => $payment['Date'],
            'Transaction_Type' => $payment['Transaction_Type'],
            'description' => $payment['description'],
            'Semester' => $array_data['semester'],
            'SchoolYear' => $array_data['school_year'],
            'cashier' => $payment['cashier'],
            'web_dose_module' => 1
          );

          //print_r($array_fees_throughput[$key_fees_item]);
          //print '</br>';


          //change valid to 0
          $array_fees_item_tuition[$key_fees_item]['valid'] = 0;
          /*
          print 'set valid to'. $array_fees_item_tuition[$key_fees_item]['valid'];
          print '</br>';
          print '</br>';
          */
        } elseif ($remaining_payment === 0) {
          # code...
          break;
        } else {
          //print 'enter amount is higher than payment';
          //print '</br>';
          $debt = number_format($fee['Fees_Amount'] - $remaining_payment, 2, '.', '');

          $array_fees_throughput[] = array(
            'Reference_Number' => $array_data['reference_no'],
            'AmountofPayment' => $remaining_payment,
            'OR_Number' => $payment['OR_Number'],
            'itemPaid' => $fee['Fees_Name'],
            'Fees_Enrolled_College_Item_id' => $fee['id'],
            'Transaction_Item' => $payment['Transaction_Item'],
            'transDate' => $payment['Date'],
            'Transaction_Type' => $payment['Transaction_Type'],
            'description' => $payment['description'],
            'Semester' => $array_data['semester'],
            'SchoolYear' => $array_data['school_year'],
            'cashier' => $payment['cashier'],
            'web_dose_module' => 1
          );
          //print_r($array_fees_throughput[$key_fees_item]);
          //$payment_balance = number_format($remaining_payment, 2, '.', '');
          //print 'enter payment balance: '.$payment_balance;
          /*
          print '</br>';
          print 'debt: '.$debt;
          print '</br>';
          print '</br>';  
          */
          break;
        }
      }
    }

    /*
    print 'remaining payment: '.$remaining_payment;
    print '</br>';
    //print 'balance: '.$payment_balance;
    //print '</br>';
    print_r($fee);
    print '</br>';

    print_r($array_fees_item_tuition);
    */

    //update col valid to 0 in enrolled student refund table
    $this->array_logs['action'] = $this->Fees_Model->remove_student_refund($array_data);
    //logs
    $this->Others_Model->insert_logs($this->array_logs);

    // if there is an excess payment
    if (($remaining_payment > 0) && ($array_fees_item_tuition[$key_fees_item]['valid'] == 0)) {
      # for excess fee
      print 'excess';

      $array_fees_throughput[] = array(
        'Reference_Number' => $array_data['reference_no'],
        'AmountofPayment' => $remaining_payment,
        'OR_Number' => $payment['OR_Number'],
        'itemPaid' => 'Excess',
        //'Fees_Enrolled_College_Item_id' => $fee['id'],
        'Fees_Enrolled_College_Item_id' => '-1',
        'Transaction_Item' => $payment['Transaction_Item'],
        'transDate' => $payment['Date'],
        'Transaction_Type' => $payment['Transaction_Type'],
        'description' => $payment['description'],
        'Semester' => $array_data['semester'],
        'SchoolYear' => $array_data['school_year'],
        'cashier' => $payment['cashier'],
        'web_dose_module' => 1
      );

      //get subject code
      $sched_info = $this->Registrar_Model->get_sched_info_by_sched_code($array_student_data['sched_code']);

      //get student number
      $student_info = $this->Student_Model->get_student_info_by_reference_no($array_data['reference_no']);

      $array_student_refund = array(
        'Reference_Number' => $array_data['reference_no'],
        'Student_Number' => $student_info[0]['Student_Number'],
        'Semester' => $array_data['semester'],
        'SchoolYear' => $array_data['school_year'],
        'source' => $payment['Transaction_Item'],
        'source_ID' => 0,
        'source_OR' => $payment['OR_Number'],
        'source_Description' => $this->array_logs['module'] . ' (' . $sched_info[0]['Course_Code'] . ')',
        'valid' => 1,
        'web_dose_module' => 1
      );

      //insert data in refund table
      $this->array_logs['action'] = $this->Fees_Model->insert_refund($array_student_refund);
      //logs
      $this->Others_Model->insert_logs($this->array_logs);
    }

    //print_r($array_fees_throughput);
    //return;



    //update data in enrolled student payment througput
    $this->array_logs['action'] = $this->Fees_Model->remove_payments_throughput($array_data);
    //logs
    $this->Others_Model->insert_logs($this->array_logs);

    //insert throughput payments
    $this->array_logs['action'] = $this->Fees_Model->insert_payments_throughput($array_fees_throughput);
    //logs
    $this->Others_Model->insert_logs($this->array_logs);


    return;
  }

  public function automate_reassessment_fix()
  {
    $array_null_fees = $this->Fees_Model->get_null_tuition();
    $count = 0;
    //print_r($array_null_fees);
    //print count($array_null_fees);
    foreach ($array_null_fees as $key => $value) {
      # code...
      $this->reassessment_fix($value['Reference_Number'], $value['schoolyear'], $value['semester']);
      $count++;
      print "Reference " . $value['Reference_Number'] . "<br>";
    }

    print $count;
  }

  public function reassessment_fix($student_num, $sy, $sem)
  {
    if (!$student_num || !$sy || !$sem) {
      # code...
      echo "incomplete data";
      return;
    }

    $this->array_logs['module'] = "web_dose_reassessment";

    $array_student_info = array(
      'student_num' => $student_num,
      'sy' => $sy,
      'sem' => $sem
    );
    $itemresult = $this->SubjectEdit_Model->Get_enrolled($array_student_info);
    $itemresult['sched_code'] = 'Reassessment';
    $this->update_student_fees($itemresult);
  }

  public function test()
  {
    $searcharray = array(
      'student_num' => 20992,
      'sy' => '2019-2020',
      'sem' => 'FIRST'
    );

    //$itemresult = $this->SubjectEdit_Model->Get_enrolled($searcharray);
    $itemresult = $this->SubjectEdit_Model->Get_enrolled_with_charged($searcharray);
    $itemresult['sched_code'] = 'Reassessment';

    $result = $this->get_fee($itemresult);


    print_r($result);

    //$this->update_student_fees($itemresult);


  }

  public function search_student()
  {

    $array = array(
      'key' => $this->input->get('key'),
      'start' => $this->input->get('offset'),
      'limit' => $this->input->get('limit')
    );
    $result = $this->Student_Model->search_student_info($array);
    echo json_encode($result);
  }
  public function search_student_page()
  {

    $array = array(
      'key' => $this->input->get('key')
    );
    $result = $this->Student_Model->search_student_info_pages($array);
    echo json_encode($result);
  }

  /////CHANGE SUBJECTS ////////////////////////////


  public function Change_Subject($student_num = '', $sem = '', $sy = '')
  {

    //$this->data['Legend']       = $this->DroppingSubjects_Model->Get_Legend();

    $this->data['getsem']        = $this->DroppingSubjects_Model->Get_sem();
    $this->data['getsy']       = $this->DroppingSubjects_Model->Get_sy();

    $array = array(
      'student_num'       => !empty($student_num) ? $student_num  : $this->input->post('student_num'),
      'sem'               => !empty($sem) ? $sem  : $this->input->post('Semester'),
      'sy'                => !empty($sy) ? $sy  : $this->input->post('School_year')
    );


    $this->data['data']   = $this->ChangeSubject_Model->Get_enrolled($array)->result_array();
    $this->render($this->set_views->Change_Subject());
  }


  public function UpdateChange_subject()
  {

    $array = array(

      'sc'   =>  $this->input->post('subject_to_change_sc'),
      'sn'   =>  $this->input->post('stu_ref'),
      'sy'   =>  $this->input->post('sy'),
      'sem'  =>  $this->input->post('sem')

    );

    $this->array_logs['action'] = $this->ChangeSubject_Model->Update_Change_Sched($array);
    $this->array_logs['module'] = 'Change Subject';
    $this->Others_Model->insert_logs($this->array_logs);
  }

  public function InsertChange_subject()
  {



    $array = array(

      'sc'           =>  $this->input->post('subject_to_enrolled_sc'),
      'sn'           =>  $this->input->post('stu_ref'),
      'rn'           =>  $this->input->post('ref_num'),
      'sy'           =>  $this->input->post('sy'),
      'sem'          =>  $this->input->post('sem'),

      'ref_num'       =>  $this->input->post('ref_num'),
      'scheduler'     =>  $this->input->post('scheduler'),
      'sdate'         =>  $this->input->post('sdate'),
      'status'        =>  $this->input->post('status'),
      'program'       =>  $this->input->post('program'),
      'major'         =>  $this->input->post('major'),
      'year_level'    =>  $this->input->post('year_level'),
      'payment_plan'  =>  $this->input->post('payment_plan'),
      'section'       =>  $this->input->post('section'),
      'sched_display_id' => $this->input->post('sched_display_id')

    );
    /*
     echo    $array['ref_num'].' Reference Number <br>';
     echo    $array['sn'].'  Student Number<br>';
     echo    $array['sc'].'  Sched Code<br>';
     echo    $array['sem'].' Semester<br>';
     echo    $array['sy'].'  School_Year<br>';
     echo    $array['scheduler'].'  Scheduler<br>';
     echo    $array['sdate'].'  SDATE<br>';
     echo    $array['status'].'  Status<br>';
     echo    $array['program'].'  Program<br>';
     echo    $array['major'].'  Program Major<br>';
     echo    $array['year_level'].'  Year Level<br>';
     echo    $array['payment_plan'].' Payment Plan<br>';
     echo    $array['section'].' Section<br>';
     echo    $array['sched_display_id'].' Sched Display ID<br>';*/


    $insert = array();

    $insert['Reference_Number']  = $array['ref_num'];
    $insert['Student_Number']    = $array['sn'];
    $insert['Semester']          = $array['sem'];
    $insert['School_Year']       = $array['sy'];
    $insert['Scheduler']         = $array['scheduler'];
    $insert['Sdate']             = $array['sdate'];
    $insert['Status']            = $array['status'];
    $insert['Program']           = $array['program'];
    $insert['Major']             = $array['major'];
    $insert['Year_Level']        = $array['year_level'];
    $insert['Payment_Plan']      = $array['payment_plan'];
    $insert['Section']           = $array['section'];
    $insert['Dropped']           = '0';
    $insert['Cancelled']         = '0';
    $insert['Charged']           = '0';
    $insert['Sched_Code']        =  $array['sc'];
    $insert['Sched_Display_ID']  = $array['sched_display_id'];

    $this->array_logs['action'] = $this->ChangeSubject_Model->InsertNewSubject($insert);
    $this->array_logs['module'] = 'Change Subject';
    //Logs
    $this->Others_Model->insert_logs($this->array_logs);

    //$this->Others_Model->insert_logs($insert);
  }


  public function ChangeSubjectInsertAndUpdate()
  {

    $this->UpdateChange_subject();
    $this->InsertChange_subject();



    // student fees assessment
    $array_data = array(
      'student_num'         => $this->input->post('stu_ref'),
      'sem'               => $this->input->post('sem'),
      'sy'                => $this->input->post('sy')
    );

    $itemresult = $this->SubjectEdit_Model->Get_enrolled($array_data);
    $this->array_logs['module'] = 'Change Subject';
    //   $itemresult['sched_code'] = $this->input->post('sched_code');  //
    $this->update_student_fees($itemresult);
    // student fees assessment


    redirect('/registrar/Change_Subject/' . $this->input->post('stu_ref') . '/' . $this->input->post('sem') . '/' . $this->input->post('sy'), 'refresh');
  }


  /////CHANGE SUBJECTS ////////////////////////////


  /// SET MAJOR  ///

  public function SetMajor($student_num = '')
  {

    $student_number =  $this->input->post('student_num');
    $this->data['Major'] = $this->Set_Major_Model->SelectMajor();
    $this->data['data']  = $this->Set_Major_Model->GetInfo($student_number);
    $this->render($this->set_views->set_major());
  }

  public function UpdateMajor()
  {

    $array = array(
      'stu_num' => $this->input->post('stu_num'),
      'ref_num' => $this->input->post('ref_num'),
      'Major'   => $this->input->post('Major')
    );

    $this->array_logs['action'] =  $this->Set_Major_Model->UpdateMajor($array);
    $this->array_logs['module'] = 'Set Major';
    $this->Others_Model->insert_logs($this->array_logs);


    redirect('/registrar/SetMajor/' . $this->input->post('student_num'), 'refresh');
  }


  /////STUDENT RECORDS ////////////////////////////
  public function BED()
  {
    $this->render($this->set_views->Bed_Student_Records());
  }

  /////STUDENT RECORDS ////////////////////////////

  public function merge_schedule()
  {
    $array_sched_code_list = array(
      array(
        'sched' => 202000100,
        'merge_sched' => 202000117
      ),
      array(
        'sched' => 202000162,
        'merge_sched' => 202000454
      ),
      array(
        'sched' => 202000162,
        'merge_sched' => 202000008
      ),
      array(
        'sched' => 202000162,
        'merge_sched' => 202000351
      ),
      array(
        'sched' => 202000162,
        'merge_sched' => 202000308
      ),
      array(
        'sched' => 202000356,
        'merge_sched' => 202000200
      ),
      array(
        'sched' => 202000388,
        'merge_sched' => 202000024
      ),
      array(
        'sched' => 202000405,
        'merge_sched' => 202000230
      ),
      array(
        'sched' => 202000162,
        'merge_sched' => 202000490
      ),
      array(
        'sched' => 202000162,
        'merge_sched' => 202000472
      )
    );

    foreach ($array_sched_code_list as $key => $sched) {
      # code...
      $this->execute_merge_schedule($sched['sched'], $sched['merge_sched']);
    }
  }


  public function execute_merge_schedule($sched_code, $merge_into_sched_code)
  {
    //$sched_code = 202000162;
    //$merge_into_sched_code = 202000472;
    $dissolve_checker = 1;

    $this->array_logs['action'] = array();

    $array_sched_info = $this->Registrar_Model->get_sched_info($sched_code);

    if (!$array_sched_info) {
      # code...
      echo "sched info error <br>";
      return;
    }

    $array_merge_into_sched_info = $this->Registrar_Model->get_sched_info($merge_into_sched_code);

    if (!$array_merge_into_sched_info) {
      # code...
      echo "merge into sched info error <br>";
      return;
    }

    /*
    $this->array_logs['module'] = "Merge schedule";
    $this->array_logs['action']['sched_code']= $sched_code;
    $this->array_logs['action']['merge_sched_code']= $merge_into_sched_code;
    */

    #set parameter to call class user
    $array_params = array(
      'sched_code' => $array_sched_info[0]['Sched_Code'],
      'semester' => $array_sched_info[0]['Semester'],
      'school_year' => $array_sched_info[0]['SchoolYear'],
      'day' => $array_sched_info[0]['Day'],
      'time_start' => $array_sched_info[0]['Start_Time'],
      'time_end' => $array_sched_info[0]['End_Time']

    );

    $this->load->library('Registrar/schedule', $array_params);

    $schedule_obj = new Schedule($array_params);

    #set parameters to merge into
    $schedule_obj->set_merge_into_sched_code($array_merge_into_sched_info[0]['Sched_Code']);
    $schedule_obj->set_merge_into_semester($array_merge_into_sched_info[0]['Semester']);
    $schedule_obj->set_merge_into_school_year($array_merge_into_sched_info[0]['SchoolYear']);
    $schedule_obj->set_merge_into_day($array_merge_into_sched_info[0]['Day']);
    $schedule_obj->set_merge_into_time_start($array_merge_into_sched_info[0]['Start_Time']);
    $schedule_obj->set_merge_into_time_end($array_merge_into_sched_info[0]['End_Time']);

    $this->array_logs['module'] = "Merge schedule";
    $this->array_logs['action']['sched_code'] = $schedule_obj->get_sched_code();
    $this->array_logs['action']['merge_sched_code'] = $schedule_obj->get_merge_into_sched_code();

    #get student list that will merge into the sched
    $student_list = $this->EnrolledStudent_Model->get_student_list_by_sched_code($merge_into_sched_code);

    if (!$student_list) {
      # code...
      return;
    }

    #insert schedule conflict checker

    $arraydata = array(
      'school_year' => $schedule_obj->get_school_year(),
      'semester' => $schedule_obj->get_semester(),
      'day' => $schedule_obj->get_day(),
      'start_time' => $schedule_obj->get_time_start(),
      'end_time' => $schedule_obj->get_time_end(),
      'sched_code' => $schedule_obj->get_sched_code()

    );

    foreach ($student_list as $key => $student) {
      # code...

      $array_data['reference_no'] = $student['Reference_Number'];

      echo "<br>";
      echo $student['Reference_Number'];
      //Checks conflicts in EnrolledStudent_Subjects. 

      $valid_conflict = $this->SubjectEdit_Model->validate_sched_conflict($arraydata);

      if ($valid_conflict) {
        # code...
        echo "<br>conflict";
        print_r($valid_conflict);
        echo "<br>";
        $this->array_logs['action']['retain'][] = $student['Reference_Number'];
        $dissolve_checker = 0;
      } else {
        # code...
        $this->array_logs['action']['merge'][] = $student['Reference_Number'];

        #update current schedule
        $this->SubjectEdit_Model->Drop_Subject($student['Reference_Number'], $merge_into_sched_code);

        #insert new schedule
        $insertarray = array(
          'Reference_Number' => $student['Reference_Number'],
          'Student_Number' => $student['Student_Number'],
          'Sched_Code' => $schedule_obj->get_sched_code(),
          'Semester' => $schedule_obj->get_semester(),
          'School_Year' => $schedule_obj->get_school_year(),
          'Status' => $student['Status'],
          'Program' => $student['Program'],
          'Major' => $student['Major'],
          'Year_Level' => $student['Year_Level'],
          'Payment_Plan' => $student['Payment_Plan'],
          'Section' => $student['Section'],
          'Sched_Display_ID' => $student['Sched_Display_ID'],
          'from_cashier' => $student['from_cashier']
        );
        // Inserts to EnrolledSubject
        $result = $this->SubjectEdit_Model->addsubject_enrolled($insertarray);
      }
    }

    $this->array_logs['action'] = json_encode($this->array_logs['action']);
    //Logs
    $this->Others_Model->insert_logs($this->array_logs);

    print_r($this->array_logs);

    #dissolve the old schedule
    if ($dissolve_checker === 1) {
      # code...
      $this->set_sched_dissolved($array_merge_into_sched_info[0]['Instructor_ID'], 829, $schedule_obj->get_merge_into_sched_code());
    }
  }

  //  Instructor Manager Functions
  public function BypassManager()
  {

    $this->Departments = $this->Registrar_Model->get_departments_choice();
    $this->render($this->set_views->bypass_manager());
  }
  public function BypassAPI($command)
  {
    switch ($command) {

        #Gets list of Users
      case 'list':

        $Filters = array(
          'Searchkey' => $this->input->get('Searchkey'),
          'Department' => $this->input->get('Department'),
        );
        $Users = $this->Registrar_Model->get_bypass_users($Filters);
        echo json_encode($Users);

        break;

        #Gets Info of Selected User
      case 'info':

        $Inputs = array(
          'UserID' => $this->input->get('UserID'),
        );
        $UserInfo = $this->Registrar_Model->get_user_info($Inputs);
        echo json_encode($UserInfo);

        break;

        #Updates Selected User
      case 'update':

        $params = array();
        parse_str($this->input->post('formdata'), $params);
        echo $params['user_id'];
        #Make Array of Schools Bypass
        $School = array();
        foreach ($params as $index => $value) {
          if ($index != 'user_id') {
            $School[$index] = $value;
          }
        }

        #Disable all bypass
        $this->Registrar_Model->disable_permissions($params['user_id']);
        if (!empty($School)) {
          foreach ($School as $index => $value) {
            $School_Code = $this->Registrar_Model->get_school_id($index);
            $insert = array(
              'School_ID' => $School_Code,
              'User_ID' => $params['user_id'],
              'valid' => 1,
              'parent_module_id' => 2,
            );
            $this->Registrar_Model->insert_permission($insert);
          }
        }

        break;

        #Invalid Handler
      default:
        echo 'Invalid Command';
        break;
    }
  }
}//end class
