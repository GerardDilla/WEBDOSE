<?php
defined('BASEPATH') or exit('No direct script access allowed');
// require_once "vendor/autoload.php";
class Admission extends MY_Controller
{


  function __construct()
  {
    parent::__construct();
    $this->load->library('set_views');
    $this->load->library("Excel");
    $this->load->library('Phpword');
    $this->load->library('form_validation');
    $this->load->model('Admission_Model/Basiced_Inquiry_Model');
    $this->load->model('Admission_Model/Shs_Model');
    $this->load->model('Admission_Model/Inquiry_Reports_Model');
    $this->load->model('Admission_Model/Inquiry_Model');
    $this->load->model('Admission_Model/Edit_Info_Model');
    $this->load->model('Admission_Model/New_Students_Model');
    $this->load->model('Admission_Model/Enrollment_Tracker_Report_Model');
    $this->load->model('Others_Model');
    //check if user is logged on
    $this->load->library('set_custom_session');
    $this->load->library('pagination');
    $this->admin_data = $this->set_custom_session->admin_session();

    //user accessibility
    $this->load->library('User_accessibility');
    $this->user_accessibility->module_admission_access($this->admin_data['userid']);

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
    $this->load->helper('string');
  }




  public function Button_BED()
  {
    $Sb      = $this->input->post('search_button');
    $exp     = $this->input->post('export');

    if (isset($Sb)) {

      $this->BasicEd();
    } else if (isset($exp)) {

      $this->Basic_Enrollment_Excel();
    }
  }

  public function BasicEd()
  {
    $this->data['get_sy']  = $this->Basiced_Inquiry_Model->Get_SchoolYear();
    $BasicedLevel = $this->Basiced_Inquiry_Model->Select_Level();

    $array = array(
      'sy' => $this->input->post('sy'),
    );

    //INITIALIZE ARRAY AND COUNTER FOR FOREACH
    $LIST = array();
    $count = 0;

    foreach ($BasicedLevel as $row) {
      $array['GradeLevel']  = $row->Grade_LevelCode;
      $list[$count]['NEWEnrolled'] = $this->Basiced_Inquiry_Model->Get_New_Enrolled($array)[0]->REF;
      $list[$count]['OLDEnrolled'] = $this->Basiced_Inquiry_Model->Get_OLD_Enrolled($array)[0]->REF;
      $list[$count]['Taker']       = $this->Basiced_Inquiry_Model->Taker($array)[0]->REF;
      $list[$count]['Inquiry']     = $this->Basiced_Inquiry_Model->Inquiry($array)[0]->REF;
      $list[$count]['NewReserve']  = $this->Basiced_Inquiry_Model->New_RESERVE($array)[0]->REF;
      $list[$count]['OldReserve']  = $this->Basiced_Inquiry_Model->OLD_RESERVE($array)[0]->REF;
      $list[$count]['Grade_Level'] = $row->Grade_Level;
      $count++;
    }

    $count = 0;
    $this->data['list'] = $list;

    $this->array_logs['module'] = 'BED ENROLL SUMMARY REPORT';
    $this->array_logs['action'] = 'Search BED Enroll Summary: School Year: ' . $array['sy'];
    $this->Others_Model->insert_logs($this->array_logs);


    $this->render($this->set_views->ad_basiced());
  }


  public function Basic_Enrollment_Excel()
  {
    $BasicedLevel = $this->Basiced_Inquiry_Model->Select_Level();

    $array = array(
      'sy' => $this->input->post('sy'),
    );

    //INITIALIZE ARRAY AND COUNTER FOR FOREACH
    $LIST = array();
    $count = 0;

    foreach ($BasicedLevel as $row) {
      $array['GradeLevel']  = $row->Grade_LevelCode;
      $list[$count]['NEWEnrolled'] = $this->Basiced_Inquiry_Model->Get_New_Enrolled($array)[0]->REF;
      $list[$count]['OLDEnrolled'] = $this->Basiced_Inquiry_Model->Get_OLD_Enrolled($array)[0]->REF;
      $list[$count]['Taker']       = $this->Basiced_Inquiry_Model->Taker($array)[0]->REF;
      $list[$count]['Inquiry']     = $this->Basiced_Inquiry_Model->Inquiry($array)[0]->REF;
      $list[$count]['NewReserve']  = $this->Basiced_Inquiry_Model->New_RESERVE($array)[0]->REF;
      $list[$count]['OldReserve']  = $this->Basiced_Inquiry_Model->OLD_RESERVE($array)[0]->REF;
      $list[$count]['Grade_Level'] = $row->Grade_Level;
      $count++;
    }

    $count = 0;
    $this->data['list'] = $list;
    $object = new PHPExcel();
    $object->setActiveSheetIndex(0);
    $object->getActiveSheet()->getStyle('A1:H1')->getAlignment()
      ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $object->getActiveSheet()->mergeCells('A1:H1');
    $object->getActiveSheet()->setCellValue('A1', 'Basic Education Enrollment Summary');
    $object->getActiveSheet()->getStyle('A2:H2')->getAlignment()
      ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $object->getActiveSheet()->mergeCells('A2:H2');
    $object->getActiveSheet()->setCellValue('A2', 'SCHOOLYEAR ' . $array['sy'] . ' ');
    $object->getActiveSheet()->getStyle('A3:E3')->getAlignment()
      ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $object->getActiveSheet()->mergeCells('A3:E3');
    $object->getActiveSheet()->setCellValue('A3', 'NEW STUDENTS');
    $object->getActiveSheet()->mergeCells('G3:H3');
    $object->getActiveSheet()->getColumnDimension('G')->setWidth(20);
    $object->getActiveSheet()->getColumnDimension('H')->setWidth(20);
    $object->getActiveSheet()->getStyle('G3:H3')->getAlignment()
      ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $object->getActiveSheet()->setCellValue('G3', 'CONTINUING STUDENTS');
    $object->getActiveSheet()->getStyle('A4')->getAlignment()
      ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $object->getActiveSheet()->getColumnDimension('A')->setWidth(20);
    $object->getActiveSheet()->setCellValue('A4', 'LEVEL');
    $object->getActiveSheet()->getColumnDimension('B')->setWidth(20);
    $object->getActiveSheet()->setCellValue('B4', 'INQUIRY');
    $object->getActiveSheet()->getColumnDimension('C')->setWidth(20);
    $object->getActiveSheet()->getStyle('C4')->getAlignment()
      ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $object->getActiveSheet()->setCellValue('C4', 'TEST TAKERS');
    $object->getActiveSheet()->getColumnDimension('D')->setWidth(20);
    $object->getActiveSheet()->getStyle('D4')->getAlignment()
      ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $object->getActiveSheet()->setCellValue('D4', 'RESERVED');
    $object->getActiveSheet()->getColumnDimension('E')->setWidth(20);
    $object->getActiveSheet()->getStyle('E4')->getAlignment()
      ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $object->getActiveSheet()->setCellValue('E4', 'ENROLLED');
    $object->getActiveSheet()->getStyle('G4')->getAlignment()
      ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $object->getActiveSheet()->setCellValue('G4', 'RESERVED');
    $object->getActiveSheet()->getStyle('H4')->getAlignment()
      ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $object->getActiveSheet()->setCellValue('H4', 'ENROLLED');
    $column = 0;
    foreach ($table_columns as $field) {
      $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
      $column++;
    }
    $count = 1;

    $excel_row = 5;
    foreach ($this->data['list']  as $row) {
      $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row['Grade_Level']);
      $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row['Inquiry']);
      $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row['Taker']);
      $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row['NewReserve']);
      $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $row['NEWEnrolled']);
      $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, '');
      $object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $row['OldReserve']);
      $object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $row['OLDEnrolled']);
      $excel_row++;
      $count = $count + 1;
    }

    $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="BasicEdEnrollmentSummary.xls"');
    $object_writer->save('php://output');

    $this->array_logs['module'] = 'BED ENROLL SUMMARY REPORT';
    $this->array_logs['action'] = 'Export BED Enroll Summary: School Year: ' . $array['sy'];
    $this->Others_Model->insert_logs($this->array_logs);
  }
  //CLASS LISTING MODULE



  public function Button_Shs()
  {
    $Sb      = $this->input->post('search_button');
    $exp     = $this->input->post('export');

    if (isset($Sb)) {

      $this->Shs();
    } else if (isset($exp)) {

      $this->Shs_Enrollment_Excel();
    }
  }



  public function Shs()
  {
    $this->data['get_lvl'] = $this->Shs_Model->Select_Level();
    $this->data['get_sy']  = $this->Basiced_Inquiry_Model->Get_SchoolYear();
    $ShsStrand = $this->Shs_Model->Select_Strand();

    $array = array(
      'sy'      => $this->input->post('sy'),
      'gradlvl' => $this->input->post('gradlvl'),
    );

    //INITIALIZE ARRAY AND COUNTER FOR FOREACH
    $LIST = array();
    $count = 0;

    foreach ($ShsStrand as $row) {
      $array['Strand_Code']        = $row->Strand_Code;
      $list[$count]['Inquiry']     = $this->Shs_Model->Inquiry($array)[0]->REF;
      $list[$count]['Taker']       = $this->Shs_Model->Taker($array)[0]->REF;
      $list[$count]['OLDReserve']  = $this->Shs_Model->OLD_RESERVE($array)[0]->REF;
      $list[$count]['NewReserve']  = $this->Shs_Model->New_RESERVE($array)[0]->REF;
      $list[$count]['NEWEnrolled'] = $this->Shs_Model->Get_New_Enrolled($array)[0]->REF;
      $list[$count]['OLDEnrolled'] = $this->Shs_Model->Get_OLD_Enrolled($array)[0]->REF;
      $list[$count]['Strand_Code'] = $row->Strand_Code;
      $count++;
    }

    $count = 0;
    $this->data['list'] = $list;
    $this->render($this->set_views->ad_shs());

    $this->array_logs['module'] = 'SHS ENROLL SUMMARY REPORT';
    $this->array_logs['action'] = 'Search SHS Enroll Summary: School Year: ' . $array['sy'] . ' Grade level:' . $array['gradlvl'];
    $this->Others_Model->insert_logs($this->array_logs);
  }


  public function Shs_Enrollment_Excel()
  {
    $ShsStrand = $this->Shs_Model->Select_Strand();

    $array = array(
      'sy'      => $this->input->post('sy'),
      'gradlvl' => $this->input->post('gradlvl'),
    );

    //INITIALIZE ARRAY AND COUNTER FOR FOREACH
    $LIST = array();
    $count = 0;

    foreach ($ShsStrand as $row) {
      $array['Strand_Code']        = $row->Strand_Code;
      $list[$count]['Inquiry']     = $this->Shs_Model->Inquiry($array)[0]->REF;
      $list[$count]['Taker']       = $this->Shs_Model->Taker($array)[0]->REF;
      $list[$count]['OLDReserve']  = $this->Shs_Model->OLD_RESERVE($array)[0]->REF;
      $list[$count]['NewReserve']  = $this->Shs_Model->New_RESERVE($array)[0]->REF;
      $list[$count]['NEWEnrolled'] = $this->Shs_Model->Get_New_Enrolled($array)[0]->REF;
      $list[$count]['OLDEnrolled'] = $this->Shs_Model->Get_OLD_Enrolled($array)[0]->REF;
      $list[$count]['Strand_Code'] = $row->Strand_Code;
      $count++;
    }

    $count = 0;
    $this->data['list'] = $list;
    $object = new PHPExcel();
    $object->setActiveSheetIndex(0);
    $object->getActiveSheet()->getStyle('A1')->getAlignment()
      ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $object->getActiveSheet()->mergeCells('A1:H1');
    $object->getActiveSheet()->setCellValue('A1', '  Senior High School  Enrollment Summary');
    $object->getActiveSheet()->mergeCells('A2:D2');
    $object->getActiveSheet()->getStyle('A2')->getAlignment()
      ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $object->getActiveSheet()->setCellValue('A2', 'SCHOOLYEAR ' . $array['sy'] . ' ');
    $object->getActiveSheet()->mergeCells('E2:H2');
    $object->getActiveSheet()->getStyle('E2')->getAlignment()
      ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $object->getActiveSheet()->setCellValue('E2', '' . $array['gradlvl'] . ' ');
    $object->getActiveSheet()->getStyle('A3')->getAlignment()
      ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $object->getActiveSheet()->mergeCells('A3:E3');
    $object->getActiveSheet()->setCellValue('A3', 'NEW STUDENTS');
    $object->getActiveSheet()->getStyle('G3')->getAlignment()
      ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $object->getActiveSheet()->mergeCells('G3:H3');
    $object->getActiveSheet()->setCellValue('G3', 'CONTINUING STUDENTS');
    $object->getActiveSheet()->getColumnDimension('A')->setWidth(20);
    $object->getActiveSheet()->getStyle('A4')->getAlignment()
      ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $object->getActiveSheet()->setCellValue('A4', 'STRAND');
    $object->getActiveSheet()->getColumnDimension('B')->setWidth(20);
    $object->getActiveSheet()->getStyle('B4')->getAlignment()
      ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $object->getActiveSheet()->setCellValue('B4', 'INQUIRY');
    $object->getActiveSheet()->getStyle('C4')->getAlignment()
      ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $object->getActiveSheet()->getColumnDimension('C')->setWidth(20);
    $object->getActiveSheet()->setCellValue('C4', 'TEST TAKERS');
    $object->getActiveSheet()->getStyle('D4')->getAlignment()
      ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $object->getActiveSheet()->getColumnDimension('D')->setWidth(20);
    $object->getActiveSheet()->setCellValue('D4', 'RESERVED');
    $object->getActiveSheet()->getStyle('E4')->getAlignment()
      ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $object->getActiveSheet()->getColumnDimension('E')->setWidth(20);
    $object->getActiveSheet()->setCellValue('E4', 'ENROLLED');
    $object->getActiveSheet()->getStyle('G4')->getAlignment()
      ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $object->getActiveSheet()->getColumnDimension('G')->setWidth(20);
    $object->getActiveSheet()->setCellValue('G4', 'RESERVED');
    $object->getActiveSheet()->getStyle('H4')->getAlignment()
      ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $object->getActiveSheet()->getColumnDimension('H')->setWidth(20);
    $object->getActiveSheet()->setCellValue('H4', 'ENROLLED');
    $column = 0;
    foreach ($table_columns as $field) {
      $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
      $column++;
    }
    $count = 1;

    $excel_row = 5;
    foreach ($this->data['list']  as $row) {
      $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row['Strand_Code']);
      $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row['Inquiry']);
      $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row['Taker']);
      $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row['NewReserve']);
      $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $row['NEWEnrolled']);
      $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, '');
      $object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $row['OLDReserve']);
      $object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $row['OLDEnrolled']);
      $excel_row++;
      $count = $count + 1;
    }

    $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="ShSEnrollmentSummary.xls"');
    $object_writer->save('php://output');

    $this->array_logs['module'] = 'SHS ENROLL SUMMARY REPORT';
    $this->array_logs['action'] = 'Export SHS Enroll Summary: School Year: ' . $array['sy'] . ' Grade level:' . $array['gradlvl'];
    $this->Others_Model->insert_logs($this->array_logs);
  }



  public function SHS_Inquiry()
  {
    $this->data['get_strand']  = $this->Inquiry_Model->Select_Strand();
    $this->data['get_Knowabout']  = $this->Inquiry_Model->Select_Knowabout();
    $this->render($this->set_views->ad_inquiry_shs());
  }

  public function BED_Inquiry()
  {
    $this->data['get_lvl']        = $this->Inquiry_Model->Select_LevelBED();
    $this->data['get_Knowabout']  = $this->Inquiry_Model->Select_Knowabout();
    $this->render($this->set_views->ad_inquiry_bed());
  }

  public function HED_Inquiry()
  {
    $this->data['get_duration']   = $this->Inquiry_Model->Select_duration();
    $this->data['get_Knowabout']  = $this->Inquiry_Model->Select_Knowabout();
    $this->data['get_religion']   = $this->Inquiry_Model->Select_religion();
    $this->data['get_course']     = $this->Inquiry_Model->Select_course();
    $this->render($this->set_views->ad_inquiry_hed());
  }


  public function Inquiry_HED()
  {
    $Sb      = $this->input->post('search_button');
    $exp     = $this->input->post('export');

    if (isset($Sb)) {

      $this->HED_Inquiry_Reports();
    } else if (isset($exp)) {

      $this->HED_Inquiry_Excel();
    }
  }


  //Inquiry Reports 
  //balik
  public function HED_Inquiry_Reports()
  {

    $this->data['get_sy']      = $this->Inquiry_Reports_Model->Select_Legends();
    $this->data['get_course']  = $this->Inquiry_Reports_Model->Select_Course();

    foreach ($this->data['get_sy']->result_array() as $row) {

      $sy  =  $row['SchoolYear'];
      $sem =  $row['Semester'];
    }


    $array = array(
      'sy1'     => $sy,
      'sem1'    => $sem,
      'sy'      => $this->input->post('sy'),
      'sem'     => $this->input->post('sem'),
      'course'  => $this->input->post('course'),
      'from'  => $this->input->post('inquiry_from'),
      'to'  => $this->input->post('inquiry_to'),
      '1st_choice'  => $this->input->post('1st_choice'),
      'single_search'  => $this->input->post('single_search'),
      'submit'  => $this->input->post('search_button')
    );
    // die(json_encode($array));
    $this->data['get_inquiry'] = null;
    if($array['submit'] !== null){
      $this->data['get_inquiry']  = $this->Inquiry_Reports_Model->Select_HED_Inquiry($array);
    }
    
    // die(json_encode($this->data['get_inquiry']));
    $this->render($this->set_views->ad_inquiry_reports_hed());
  }

  //HED Excel Reports
  public function HED_Inquiry_Excel()
  {

    $this->data['get_sy']      = $this->Inquiry_Reports_Model->Select_Legends();
    $this->data['get_course']  = $this->Inquiry_Reports_Model->Select_Course();

    foreach ($this->data['get_sy']->result_array() as $row) {

      $sy  =  $row['SchoolYear'];
      $sem =  $row['Semester'];
    }


    $array = array(
      'sy1'     => $sy,
      'sem1'    => $sem,
      'sy'      => $this->input->post('sy'),
      'sem'     => $this->input->post('sem'),
      'course'  => $this->input->post('course'),
      'from'  => $this->input->post('inquiry_from'),
      'to'  => $this->input->post('inquiry_to'),
      '1st_choice'  => $this->input->post('1st_choice'),
      'single_search'  => $this->input->post('single_search'),
      'submit'  => $this->input->post('search_button')
    );



    $this->data['get_inquiry']  = $this->Inquiry_Reports_Model->Select_HED_Inquiry($array);


    $object = new PHPExcel();
    $object->setActiveSheetIndex(0);
    $object->getActiveSheet()->getStyle('A1')->getAlignment()
      ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $object->getActiveSheet()->mergeCells('A1:I1');
    $object->getActiveSheet()->setCellValue('A1', 'Higher Edcuation Inquiry');
    $object->getActiveSheet()->setCellValue('A2', '#');
    $object->getActiveSheet()->setCellValue('B2', 'Reference_Number');
    $object->getActiveSheet()->setCellValue('C2', 'Name');
    $object->getActiveSheet()->setCellValue('D2', 'Program');
    $object->getActiveSheet()->setCellValue('E2', 'Search Engine');
    $object->getActiveSheet()->setCellValue('F2', 'Contact #');
    $object->getActiveSheet()->setCellValue('G2', 'Email');
    $object->getActiveSheet()->setCellValue('H2', 'School Last Attended');
    $object->getActiveSheet()->setCellValue('I2', 'Residence');
    $object->getActiveSheet()->setCellValue('J2', 'Status');
    $object->getActiveSheet()->setCellValue('K2', 'Remarks');
    $object->getActiveSheet()->setCellValue('L2', 'Applied School Year');
    $object->getActiveSheet()->setCellValue('M2', 'Applied Semester');
    $object->getActiveSheet()->setCellValue('N2', 'Date Inquired');
    $object->getActiveSheet()->setCellValue('O2', 'DSWD Number');
    $object->getActiveSheet()->getColumnDimension('B')->setWidth(20);
    $object->getActiveSheet()->getColumnDimension('C')->setWidth(40);
    $object->getActiveSheet()->getColumnDimension('D')->setWidth(20);
    $object->getActiveSheet()->getColumnDimension('E')->setWidth(15);
    $object->getActiveSheet()->getColumnDimension('F')->setWidth(45);
    $object->getActiveSheet()->getColumnDimension('G')->setWidth(40);
    $object->getActiveSheet()->getColumnDimension('H')->setWidth(30);
    $object->getActiveSheet()->getColumnDimension('J')->setWidth(40);
    $object->getActiveSheet()->getColumnDimension('K')->setWidth(40);

    foreach ($table_columns as $field) {
      $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
      $column++;
    }
    $count = 1;

    $excel_row = 3;
    foreach ($this->data['get_inquiry']  as $row) {
      if ($row->Others_Know_SDCA == NULL) {
        $OKS = 'N/A';
      } else {
        $OKS = $row->Others_Know_SDCA;
      }

      $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $count);
      $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->ref_no);
      $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row,  strtoupper($row->Last_Name . ',' . $row->First_Name . '' . $row->Middle_Name));
      if ($row->EXM_RF == NULL) {
        $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row,  strtoupper($row->Course_1st));
      } else {
        $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row,  strtoupper($row->Course));
      }
      $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row,  strtoupper($OKS));
      $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $row->CP_No);
      $object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $row->Email);

      if ($row->Transferee_Name == NULL || $row->Transferee_Name == 'N/A' || $row->Transferee_Name == '' || $row->Transferee_Name == '-') {
        if ($row->SHS_School_Name == NULL || $row->SHS_School_Name == 'N/A' || $row->SHS_School_Name == '' || $row->SHS_School_Name == '-') {
          $object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row,  strtoupper($row->Secondary_School_Name));
        } else {
          $object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row,  strtoupper($row->SHS_School_Name));
        }
      } else {
        $object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row,  strtoupper($row->Transferee_Name));
      }

      $object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row,  strtoupper($row->Address_City . ',' . $row->Address_Province));

      if ($row->Transferee_Name == NULL || $row->Transferee_Name == 'N/A' || $row->Transferee_Name == '' || $row->Transferee_Name == '-') {
        $object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row,  strtoupper('N'));
      } else {
        $object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row,  strtoupper('T'));
      }

      if ($row->EXM_RF == NULL) {
        $object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row,  strtoupper('Follow Up'));
      } else {
        $object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row,  strtoupper('With Exam'));
      }
      $object->getActiveSheet()->setCellValueByColumnAndRow(11, $excel_row,  strtoupper($row->Applied_SchoolYear));
      $object->getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row,  strtoupper($row->Applied_Semester));
      $object->getActiveSheet()->setCellValueByColumnAndRow(13, $excel_row,  strtoupper($row->DateInquired));
      $object->getActiveSheet()->setCellValueByColumnAndRow(14, $excel_row,  strtoupper($row->dswd_no ? $row->dswd_no : 'N/A'));
      $excel_row++;
      $count = $count + 1;
    }

    $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="HedInquiryExcel.xls"');
    $object_writer->save('php://output');
  }
  /////////////////////////////////////////BED INQUIRY //////////////////////////////////////////////
  public function Inquiry_BED()
  {
    $Sb      = $this->input->post('search_button');
    $exp     = $this->input->post('export');

    if (isset($Sb)) {

      $this->BED_Inquiry_Reports();
    } else if (isset($exp)) {

      $this->BED_Inquiry_Excel();
    }
  }


  public function BED_Inquiry_Reports()
  {
    $this->data['get_sy']  = $this->Basiced_Inquiry_Model->Get_SchoolYear();
    $this->data['get_lvl'] = $this->Basiced_Inquiry_Model->Select_Level();
    $this->data['get_sy1']  = $this->Inquiry_Reports_Model->Select_Legends();

    foreach ($this->data['get_sy1']->result_array() as $row) {

      $sy  =  $row['SchoolYear'];
      $sem =  $row['Semester'];
    }

    $array = array(
      'sy1'     => $sy,
      'sem1'    => $sem,
      'sy' => $this->input->post('sy'),
      'getlvl' => $this->input->post('getlvl'),
      'from'  => $this->input->post('inquiry_from'),
      'to'  => $this->input->post('inquiry_to'),
    );

    //  echo  $array['from'];
    //  echo  $array['to'];
    $this->data['get_inquiry']  = $this->Inquiry_Reports_Model->Select_BED_Inquiry($array);
    $this->render($this->set_views->ad_inquiry_reports_bed());
  }

  public function BED_Inquiry_Excel()
  {

    $this->data['get_sy']  = $this->Basiced_Inquiry_Model->Get_SchoolYear();
    $this->data['get_lvl'] = $this->Basiced_Inquiry_Model->Select_Level();
    $this->data['get_sy1'] = $this->Inquiry_Reports_Model->Select_Legends();

    foreach ($this->data['get_sy1']->result_array() as $row) {

      $sy  =  $row['SchoolYear'];
      $sem =  $row['Semester'];
    }

    $array = array(
      'sy1'     => $sy,
      'sem1'    => $sem,
      'sy' => $this->input->post('sy'),
      'getlvl' => $this->input->post('getlvl'),
      'from'  => $this->input->post('inquiry_from'),
      'to'  => $this->input->post('inquiry_to'),
    );


    $this->data['get_inquiry']  = $this->Inquiry_Reports_Model->Select_SHS_Inquiry($array);


    $object = new PHPExcel();
    $object->setActiveSheetIndex(0);
    $object->getActiveSheet()->getStyle('A1')->getAlignment()
      ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $object->getActiveSheet()->mergeCells('A1:J1');
    $object->getActiveSheet()->setCellValue('A1', 'Senior High School Inquiry');
    $object->getActiveSheet()->setCellValue('A2', '#');
    $object->getActiveSheet()->setCellValue('B2', 'Name');
    $object->getActiveSheet()->setCellValue('C2', 'Grade Level');
    $object->getActiveSheet()->setCellValue('D2', 'Strand');
    $object->getActiveSheet()->setCellValue('F2', 'Search Engine');
    $object->getActiveSheet()->setCellValue('E2', 'Contact #');
    $object->getActiveSheet()->setCellValue('G2', 'School Last Attended');
    $object->getActiveSheet()->setCellValue('H2', 'Residence');
    $object->getActiveSheet()->setCellValue('I2', 'Status');
    $object->getActiveSheet()->setCellValue('J2', 'Remarks');
    $object->getActiveSheet()->setCellValue('K2', 'DSWD Number');
    $object->getActiveSheet()->getColumnDimension('B')->setWidth(50);
    $object->getActiveSheet()->getColumnDimension('C')->setWidth(15);
    $object->getActiveSheet()->getColumnDimension('D')->setWidth(15);
    $object->getActiveSheet()->getColumnDimension('E')->setWidth(15);
    $object->getActiveSheet()->getColumnDimension('F')->setWidth(30);
    $object->getActiveSheet()->getColumnDimension('G')->setWidth(45);
    $object->getActiveSheet()->getColumnDimension('H')->setWidth(45);

    foreach ($table_columns as $field) {
      $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
      $column++;
    }
    $count = 1;

    $excel_row = 3;
    foreach ($this->data['get_inquiry']  as $row) {
      if ($row->Others_Know_SDCA == NULL) {
        $OKS = 'N/A';
      } else {
        $OKS = $row->Others_Know_SDCA;
      }

      if ($row->Strand == NULL) {
        $Strand = 'N/A';
      } else {
        $Strand = $row->Strand;
      }

      $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $count);
      $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row,  strtoupper($row->Last_Name . ',' . $row->First_Name . '' . $row->Middle_Name));
      $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row,  strtoupper($row->Gradelevel));
      $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row,  strtoupper($Strand));
      $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row,  strtoupper($OKS));
      $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $row->Mobile_No);
      $object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row,  strtoupper($row->Previous_School_Name1));
      $object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row,  strtoupper($row->City . ',' . $row->Province));
      $object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row,  strtoupper($row->Applied_Status));
      $object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row,  strtoupper($row->Remarks));
      $object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row,  strtoupper($row->dswd_no ? $row->dswd_no : 'N/A'));
      $excel_row++;
      $count = $count + 1;
    }

    $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="SHSInquiryExcel.xls"');
    $object_writer->save('php://output');
  }


  //SHS///////////////////////////////////////////////SHS////////////////////////////////////////////INQUIRY/////////////////////
  public function Inquiry_SHS()
  {
    $Sb      = $this->input->post('search_button');
    $exp     = $this->input->post('export');

    if (isset($Sb)) {

      $this->SHS_Inquiry_Reports();
    } else if (isset($exp)) {

      $this->SHS_Inquiry_Excel();
    }
  }

  public function SHS_Inquiry_Reports()
  {
    $this->data['get_lvl']      = $this->Shs_Model->Select_Level();
    $this->data['get_sy']       = $this->Basiced_Inquiry_Model->Get_SchoolYear();
    $this->data['get_sy1']      = $this->Inquiry_Reports_Model->Select_Legends();

    foreach ($this->data['get_sy1']->result_array() as $row) {

      $sy  =  $row['SchoolYear'];
      $sem =  $row['Semester'];
    }

    $array = array(
      'sy1'     => $sy,
      'sem1'    => $sem,
      'sy' => $this->input->post('sy'),
      'gradlvl' => $this->input->post('gradlvl')
    );


    $this->data['get_inquiry']  = $this->Inquiry_Reports_Model->Select_SHS_Inquiry($array);
    $this->render($this->set_views->ad_inquiry_reports_shs());
  }
  //Inquiry Reports 

  //SHS Excel Reports
  public function SHS_Inquiry_Excel()
  {

    $this->data['get_lvl'] = $this->Shs_Model->Select_Level();
    $this->data['get_sy']  = $this->Basiced_Inquiry_Model->Get_SchoolYear();
    $this->data['get_sy1']  = $this->Inquiry_Reports_Model->Select_Legends();
    foreach ($this->data['get_sy1']->result_array() as $row) {

      $sy  =  $row['SchoolYear'];
      $sem =  $row['Semester'];
    }

    $array = array(
      'sy1'     => $sy,
      'sem1'    => $sem,
      'sy' => $this->input->post('sy'),
      'gradlvl' => $this->input->post('gradlvl')
    );


    $this->data['get_inquiry']  = $this->Inquiry_Reports_Model->Select_SHS_Inquiry($array);


    $object = new PHPExcel();
    $object->setActiveSheetIndex(0);
    $object->getActiveSheet()->getStyle('A1')->getAlignment()
      ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $object->getActiveSheet()->mergeCells('A1:J1');
    $object->getActiveSheet()->setCellValue('A1', 'Senior High School Inquiry');
    $object->getActiveSheet()->setCellValue('A2', '#');
    $object->getActiveSheet()->setCellValue('B2', 'Name');
    $object->getActiveSheet()->setCellValue('C2', 'Grade Level');
    $object->getActiveSheet()->setCellValue('D2', 'Strand');
    $object->getActiveSheet()->setCellValue('F2', 'Search Engine');
    $object->getActiveSheet()->setCellValue('E2', 'Contact #');
    $object->getActiveSheet()->setCellValue('G2', 'School Last Attended');
    $object->getActiveSheet()->setCellValue('H2', 'Residence');
    $object->getActiveSheet()->setCellValue('I2', 'Status');
    $object->getActiveSheet()->setCellValue('J2', 'Remarks');
    $object->getActiveSheet()->setCellValue('K2', 'DSWD Number');
    $object->getActiveSheet()->getColumnDimension('B')->setWidth(50);
    $object->getActiveSheet()->getColumnDimension('C')->setWidth(15);
    $object->getActiveSheet()->getColumnDimension('D')->setWidth(15);
    $object->getActiveSheet()->getColumnDimension('E')->setWidth(15);
    $object->getActiveSheet()->getColumnDimension('F')->setWidth(30);
    $object->getActiveSheet()->getColumnDimension('G')->setWidth(45);
    $object->getActiveSheet()->getColumnDimension('H')->setWidth(45);

    foreach ($table_columns as $field) {
      $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
      $column++;
    }
    $count = 1;

    $excel_row = 3;
    foreach ($this->data['get_inquiry']  as $row) {
      if ($row->Others_Know_SDCA == NULL) {
        $OKS = 'N/A';
      } else {
        $OKS = $row->Others_Know_SDCA;
      }

      if ($row->Strand == NULL) {
        $Strand = 'N/A';
      } else {
        $Strand = $row->Strand;
      }

      $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $count);
      $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row,  strtoupper($row->Last_Name . ',' . $row->First_Name . '' . $row->Middle_Name));
      $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row,  strtoupper($row->Gradelevel));
      $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row,  strtoupper($Strand));
      $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row,  strtoupper($OKS));
      $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $row->Mobile_No);
      $object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row,  strtoupper($row->Previous_School_Name1));
      $object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row,  strtoupper($row->City . ',' . $row->Province));
      $object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row,  strtoupper($row->Applied_Status));
      $object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row,  strtoupper($row->Remarks));
      $object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row,  strtoupper($row->dswd_no ? $row->dswd_no : 'N/A'));
      $excel_row++;
      $count = $count + 1;
    }

    $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="SHSInquiryExcel.xls"');
    $object_writer->save('php://output');
  }


  //HIGHER EDUCATION EDIT STUDENT INFO ///
  public function Student_Info()
  {
    $search = $this->input->post('search');
    $update = $this->input->post('update');
    $refstu = $this->input->post('sturef_number');

    //Checker if blank or Unknown Reference/Student Number
    $this->data['info']  = $this->Edit_Info_Model->Get_Info($refstu);
    if (($refstu === "") || ($this->data['info']->num_rows() <= 0)) {
      $this->session->set_flashdata('success', '');
      $this->session->set_flashdata('noref', 'Unknown Reference/Student Number');
      redirect('Admission/HED_Edit_Info');
    } else {
      $this->session->set_flashdata('noref', '');
      $this->session->set_flashdata('success', '');
      if (isset($search)) {
        $this->HED_Edit_Info();
      } else if (isset($update)) {
        $this->HED_UPDATE_Info();
      }
    }
  }

  public function HED_Edit_Info()
  {
    $sturef =  $this->input->post('sturef_number');
    $this->data['get_knowabout'] = $this->Inquiry_Model->Select_Knowabout();
    $this->data['get_info']      = $this->Edit_Info_Model->Select_Studeninfo($sturef);
    $this->render($this->set_views->ad_edit_info());
  }

  public function HED_UPDATE_Info()
  {

    $sturef =  $this->input->post('sturef_number');

    if (isset($sturef)) {
      // echo  $sturef;
    } else {
      return;
    }

    $array = array(
      'stu_num'                    => $this->input->post('stu_num'),
      'ref_num'                    => $this->input->post('ref_num'),
      'f_name'                     => $this->input->post('first_name'),
      'm_name'                     => $this->input->post('middle_name'),
      'l_name'                     => $this->input->post('last_name'),
      'address_no'                 => $this->input->post('address_no'),
      'address_st'                 => $this->input->post('address_st'),
      'subdivision'                => $this->input->post('subdivision'),
      'barangay'                   => $this->input->post('barangay'),
      'province'                   => $this->input->post('province'),
      'city'                       => $this->input->post('city'),
      'b-date'                     => $this->input->post('b-date'),
      'nationality'                => $this->input->post('nationality'),
      'phone_num'                  => $this->input->post('phone_num'),
      'mobile_num'                 => $this->input->post('mobile_num'),
      'Age'                        => $this->input->post('Age'),
      'b_place'                    => $this->input->post('b_place'),
      'zip_code'                   => $this->input->post('zip_code'),
      'parent_Status'              => $this->input->post('parent_Status'),
      'gender'                     => $this->input->post('gender'),
      'email_add'                  => $this->input->post('email_add'),
      'father_name'                => $this->input->post('father_name'),
      'father_occupation'          => $this->input->post('father_occupation'),
      'father_contact'             => $this->input->post('father_contact'),
      'father_add'                 => $this->input->post('father_add'),
      'father_email'               => $this->input->post('father_email'),
      'father_inc'                 => $this->input->post('father_inc'),
      'father_ed'                  => $this->input->post('father_ed'),
      'mother_name'                => $this->input->post('mother_name'),
      'mother_occupation'          => $this->input->post('mother_occupation'),
      'mother_contact'             => $this->input->post('mother_contact'),
      'mother_address'             => $this->input->post('mother_address'),
      'mother_email'               => $this->input->post('mother_email'),
      'mother_inc'                 => $this->input->post('mother_inc'),
      'mother_ed'                  => $this->input->post('mother_ed'),
      'first_choice'               => $this->input->post('first_choice'),
      'second_choice'              => $this->input->post('second_choice'),
      'third_choice'               => $this->input->post('third_choice'),
      'OTKSDCA'                    => $this->input->post('OTKSDCA'),
      'Relative'                   => $this->input->post('Relative'),
      'Relative_name'              => $this->input->post('Relative_name'),
      'relative_department'        => $this->input->post('relative_department'),
      'relative_relationship'      => $this->input->post('relative_relationship'),
      'relative_contact'           => $this->input->post('relative_contact'),
      'secondary_school'           => $this->input->post('secondary_school'),
      'elementary_school'          => $this->input->post('elementary_school'),
      'secondary_address'          => $this->input->post('secondary_address'),
      'gradeschool_address'        => $this->input->post('gradeschool_address'),
      'secondary_grad'             => $this->input->post('secondary_grad'),
      'elem_grad'                  => $this->input->post('elem_grad'),
      'transfere_nameschool'       => $this->input->post('transfere_nameschool'),
      'transfere_lastattend'       => $this->input->post('transfere_lastattend'),
      'transfere_schooladdress'    => $this->input->post('transfere_schooladdress'),
      'transfere_course'           => $this->input->post('transfere_course'),
      'guardian_name'              => $this->input->post('guardian_name'),
      'guardian_contact'           => $this->input->post('guardian_contact'),
      'guardian_address'           => $this->input->post('guardian_address'),
      'guardian_relationship'      => $this->input->post('guardian_relationship'),
      'shs_name'                   => $this->input->post('shs_name'),
      'shs_address'                => $this->input->post('shs_address'),
      'shs_grad'                   => $this->input->post('shs_grad')
    );
    $this->array_logs['action'] =   $this->Edit_Info_Model->Update_Info($array);
    $this->array_logs['module'] = 'EDIT INFO HED';
    //Logs
    $this->Others_Model->insert_logs($this->array_logs);

    $this->session->set_flashdata('success', 'Update Successful');
    redirect('/Admission/HED_Edit_Info/' . $array['ref_num'], 'refresh');
  }
  //HIGHER EDUCATION EDIT STUDENT INFO ///



  public function Student_Info_BED()
  {
    $search = $this->input->post('search');
    $update = $this->input->post('update');
    $refstu = $this->input->post('sturef_number');

    //Checker if blank or Unknown Reference/Student Number
    $this->data['info']  = $this->Edit_Info_Model->Get_Info_BED($refstu);
    if (($refstu === "") || ($this->data['info']->num_rows() <= 0)) {
      $this->session->set_flashdata('success', '');
      $this->session->set_flashdata('noref', 'Unknown Reference/Student Number');
      redirect('Admission/BED_Edit_Info');
    } else {
      $this->session->set_flashdata('noref', '');
      $this->session->set_flashdata('success', '');
      if (isset($search)) {
        $this->BED_Edit_Info();
      } else if (isset($update)) {
        $this->BED_UPDATE_Info();
      }
    }
  }

  public function BED_Edit_Info()
  {

    $sturef =  $this->input->post('sturef_number');
    $this->data['get_knowabout'] = $this->Inquiry_Model->Select_Knowabout();
    $this->data['get_info']  = $this->Edit_Info_Model->Select_StudeninfoBED($sturef);
    $this->render($this->set_views->ad_edit_bed_info());
  }

  public function BED_UPDATE_Info()
  {

    $sturef =  $this->input->post('sturef_number');

    if (isset($sturef)) {
      // echo  $sturef;
    } else {
      return;
    }

    $array = array(
      'stu_num'                    => $this->input->post('stu_num'),
      'ref_num'                    => $this->input->post('ref_num'),
      'lrn'                        => $this->input->post('lrn'),
      'f_name'                     => $this->input->post('first_name'),
      'm_name'                     => $this->input->post('middle_name'),
      'l_name'                     => $this->input->post('last_name'),
      'nickname'                   => $this->input->post('nickname'),
      'Grade_lvl'                  => $this->input->post('Grade_lvl'),
      'b-date'                     => $this->input->post('b-date'),
      'age'                        => $this->input->post('age'),
      'gender'                     => $this->input->post('gender'),
      'b-place'                    => $this->input->post('b-place'),
      'religion'                   => $this->input->post('religion'),
      'nationality'                => $this->input->post('nationality'),
      'alien_num'                  => $this->input->post('alien_num'),
      'mobile_num'                 => $this->input->post('mobile_num'),
      'phone_num'                  => $this->input->post('phone_num'),
      'house_no'                   => $this->input->post('house_no'),
      'street'                     => $this->input->post('street'),
      'subdivision'                => $this->input->post('subdivision'),
      'barangay'                   => $this->input->post('barangay'),
      'city_muni'                  => $this->input->post('city_muni'),
      'zip'                        => $this->input->post('zip'),
      'province'                   => $this->input->post('province'),
      'parent_status'              => $this->input->post('parent_status'),
      'fathers_name'               => $this->input->post('fathers_name'),
      'father_status'              => $this->input->post('father_status'),
      'father_bday'                => $this->input->post('father_bday'),
      'father_Age'                 => $this->input->post('father_Age'),
      'father_employer'            => $this->input->post('father_employer'),
      'father_avg_income'          => $this->input->post('father_avg_income'),
      'father_position'            => $this->input->post('father_position'),
      'father_lvl_education'       => $this->input->post('father_lvl_education'),
      'father_address'             => $this->input->post('father_address'),
      'father_city'                => $this->input->post('father_city'),
      'father_province'            => $this->input->post('father_province'),
      'father_country'             => $this->input->post('father_country'),
      'father_zip'                 => $this->input->post('father_zip'),
      'father_Telephone'           => $this->input->post('father_Telephone'),
      'father_email'               => $this->input->post('father_email'),
      'father_mobile'              => $this->input->post('father_mobile'),
      'mother_name'                => $this->input->post('mother_name'),
      'mother_status'              => $this->input->post('mother_status'),
      'mother_bday'                => $this->input->post('mother_bday'),
      'mother_age'                 => $this->input->post('mother_age'),
      'mother_employer'            => $this->input->post('mother_employer'),
      'mother_avg_income'          => $this->input->post('mother_avg_income'),
      'mother_lvl_education'       => $this->input->post('mother_lvl_education'),
      'mother_adrress'             => $this->input->post('mother_adrress'),
      'mother_city'                => $this->input->post('mother_city'),
      'mother_province'            => $this->input->post('mother_province'),
      'mother_country'             => $this->input->post('mother_country'),
      'mother_zip'                 => $this->input->post('mother_zip'),
      'mother_telephone'           => $this->input->post('mother_telephone'),
      'mother_email'               => $this->input->post('mother_email'),
      'mother_mobile'              => $this->input->post('mother_mobile'),
      'guardian_name'              => $this->input->post('guardian_name'),
      'guardian_status'            => $this->input->post('guardian_status'),
      'guardian_bday'              => $this->input->post('guardian_bday'),
      'guardian_age'               => $this->input->post('guardian_age'),
      'guardian_employer'          => $this->input->post('guardian_employer'),
      'guardian_avg_income'        => $this->input->post('guardian_avg_income'),
      'guardian_position'          => $this->input->post('guardian_position'),
      'guardian_lvl_education'     => $this->input->post('guardian_lvl_education'),
      'guardian_address'           => $this->input->post('guardian_address'),
      'guardian_city'              => $this->input->post('guardian_city'),
      'guardian_province'          => $this->input->post('guardian_province'),
      'guardian_country'           => $this->input->post('guardian_country'),
      'guardian_zip'               => $this->input->post('guardian_zip'),
      'guardian_telephone'         => $this->input->post('guardian_telephone'),
      'guardian_email'             => $this->input->post('guardian_email'),
      'guardian_mobile'            => $this->input->post('guardian_mobile'),
      'name_of_school1'            => $this->input->post('name_of_school1'),
      'level1'                     => $this->input->post('level1'),
      'year_attended1'             => $this->input->post('year_attended1'),
      'awards1'                    => $this->input->post('awards1'),
      'name_of_school2'            => $this->input->post('name_of_school2'),
      'level2'                     => $this->input->post('level2'),
      'year_attended2'             => $this->input->post('year_attended2'),
      'awards2'                    => $this->input->post('awards2'),
      'name_of_school3'            => $this->input->post('name_of_school3'),
      'level3'                     => $this->input->post('level3'),
      'year_attended3'             => $this->input->post('year_attended3'),
      'awards3'                    => $this->input->post('awards3'),
      'subject_best1'              => $this->input->post('subject_best1'),
      'subject_best2'              => $this->input->post('subject_best2'),
      'subject_best3'              => $this->input->post('subject_best3'),
      'subject_best4'              => $this->input->post('subject_best4'),
      'least_best1'                => $this->input->post('least_best1'),
      'least_best2'                => $this->input->post('least_best2'),
      'least_best3'                => $this->input->post('least_best3'),
      'least_best4'                => $this->input->post('least_best4'),
      'name_of_org1'               => $this->input->post('name_of_org1'),
      'postion1'                   => $this->input->post('postion1'),
      'year1'                      => $this->input->post('year1'),
      'name_of_org2'               => $this->input->post('name_of_org2'),
      'postion2'                   => $this->input->post('postion2'),
      'year2'                      => $this->input->post('year2'),
      'otk'                        => $this->input->post('otk'),
      'Relatives'                   => $this->input->post('Relatives'),
      'Relative_name'              => $this->input->post('Relative_name'),
      'relative_department'        => $this->input->post('relative_department'),
      'relative_relationship'      => $this->input->post('relative_relationship'),
      'relative_contact'           => $this->input->post('relative_contact')

    );


    $this->array_logs['action'] =  $this->Edit_Info_Model->Update_Info_BED($array);
    $this->array_logs['module'] = 'EDIT INFO BED';
    //Logs
    $this->Others_Model->insert_logs($this->array_logs);

    $this->session->set_flashdata('success', 'Update Successful');
    redirect('/Admission/BED_Edit_Info/' . $array['ref_num'], 'refresh');
  }



  public function Student_Info_SHS()
  {
    $search = $this->input->post('search');
    $update = $this->input->post('update');
    $refstu = $this->input->post('sturef_number');

    //Checker if blank or Unknown Reference/Student Number
    $this->data['info']  = $this->Edit_Info_Model->Get_Info_BED($refstu);
    if (($refstu === "") || ($this->data['info']->num_rows() <= 0)) {
      $this->session->set_flashdata('success', '');
      $this->session->set_flashdata('noref', 'Unknown Reference/Student Number');
      redirect('Admission/SHS_Edit_Info');
    } else {
      $this->session->set_flashdata('noref', '');
      $this->session->set_flashdata('success', '');
      if (isset($search)) {
        $this->SHS_Edit_Info();
      } else if (isset($update)) {
        $this->SHS_UPDATE_Info();
      }
    }
  }

  public function SHS_Edit_Info()
  {

    $sturef =  $this->input->post('sturef_number');
    $this->data['get_knowabout'] = $this->Inquiry_Model->Select_Knowabout();
    $this->data['get_info']  = $this->Edit_Info_Model->Select_StudeninfoBED($sturef);
    $this->render($this->set_views->ad_edit_shs_info());
  }

  public function SHS_UPDATE_Info()
  {

    $sturef =  $this->input->post('sturef_number');

    if (isset($sturef)) {
      // echo  $sturef;
    } else {
      return;
    }

    $array = array(
      'stu_num'                    => $this->input->post('stu_num'),
      'ref_num'                    => $this->input->post('ref_num'),
      'lrn'                        => $this->input->post('lrn'),
      'f_name'                     => $this->input->post('first_name'),
      'm_name'                     => $this->input->post('middle_name'),
      'l_name'                     => $this->input->post('last_name'),
      'nickname'                   => $this->input->post('nickname'),
      'Grade_lvl'                  => $this->input->post('Grade_lvl'),
      'b-date'                     => $this->input->post('b-date'),
      'age'                        => $this->input->post('age'),
      'gender'                     => $this->input->post('gender'),
      'b-place'                    => $this->input->post('b-place'),
      'religion'                   => $this->input->post('religion'),
      'nationality'                => $this->input->post('nationality'),
      'alien_num'                  => $this->input->post('alien_num'),
      'mobile_num'                 => $this->input->post('mobile_num'),
      'phone_num'                  => $this->input->post('phone_num'),
      'house_no'                   => $this->input->post('house_no'),
      'street'                     => $this->input->post('street'),
      'subdivision'                => $this->input->post('subdivision'),
      'barangay'                   => $this->input->post('barangay'),
      'city_muni'                  => $this->input->post('city_muni'),
      'zip'                        => $this->input->post('zip'),
      'province'                   => $this->input->post('province'),
      'parent_status'              => $this->input->post('parent_status'),
      'fathers_name'               => $this->input->post('fathers_name'),
      'father_status'              => $this->input->post('father_status'),
      'father_bday'                => $this->input->post('father_bday'),
      'father_Age'                 => $this->input->post('father_Age'),
      'father_employer'            => $this->input->post('father_employer'),
      'father_avg_income'          => $this->input->post('father_avg_income'),
      'father_position'            => $this->input->post('father_position'),
      'father_lvl_education'       => $this->input->post('father_lvl_education'),
      'father_address'             => $this->input->post('father_address'),
      'father_city'                => $this->input->post('father_city'),
      'father_province'            => $this->input->post('father_province'),
      'father_country'             => $this->input->post('father_country'),
      'father_zip'                 => $this->input->post('father_zip'),
      'father_Telephone'           => $this->input->post('father_Telephone'),
      'father_email'               => $this->input->post('father_email'),
      'father_mobile'              => $this->input->post('father_mobile'),
      'mother_name'                => $this->input->post('mother_name'),
      'mother_status'              => $this->input->post('mother_status'),
      'mother_bday'                => $this->input->post('mother_bday'),
      'mother_age'                 => $this->input->post('mother_age'),
      'mother_employer'            => $this->input->post('mother_employer'),
      'mother_avg_income'          => $this->input->post('mother_avg_income'),
      'mother_lvl_education'       => $this->input->post('mother_lvl_education'),
      'mother_adrress'             => $this->input->post('mother_adrress'),
      'mother_city'                => $this->input->post('mother_city'),
      'mother_province'            => $this->input->post('mother_province'),
      'mother_country'             => $this->input->post('mother_country'),
      'mother_zip'                 => $this->input->post('mother_zip'),
      'mother_telephone'           => $this->input->post('mother_telephone'),
      'mother_email'               => $this->input->post('mother_email'),
      'mother_mobile'              => $this->input->post('mother_mobile'),
      'guardian_name'              => $this->input->post('guardian_name'),
      'guardian_status'            => $this->input->post('guardian_status'),
      'guardian_bday'              => $this->input->post('guardian_bday'),
      'guardian_age'               => $this->input->post('guardian_age'),
      'guardian_employer'          => $this->input->post('guardian_employer'),
      'guardian_avg_income'        => $this->input->post('guardian_avg_income'),
      'guardian_position'          => $this->input->post('guardian_position'),
      'guardian_lvl_education'     => $this->input->post('guardian_lvl_education'),
      'guardian_address'           => $this->input->post('guardian_address'),
      'guardian_city'              => $this->input->post('guardian_city'),
      'guardian_province'          => $this->input->post('guardian_province'),
      'guardian_country'           => $this->input->post('guardian_country'),
      'guardian_zip'               => $this->input->post('guardian_zip'),
      'guardian_telephone'         => $this->input->post('guardian_telephone'),
      'guardian_email'             => $this->input->post('guardian_email'),
      'guardian_mobile'            => $this->input->post('guardian_mobile'),
      'name_of_school1'            => $this->input->post('name_of_school1'),
      'level1'                     => $this->input->post('level1'),
      'year_attended1'             => $this->input->post('year_attended1'),
      'awards1'                    => $this->input->post('awards1'),
      'name_of_school2'            => $this->input->post('name_of_school2'),
      'level2'                     => $this->input->post('level2'),
      'year_attended2'             => $this->input->post('year_attended2'),
      'awards2'                    => $this->input->post('awards2'),
      'name_of_school3'            => $this->input->post('name_of_school3'),
      'level3'                     => $this->input->post('level3'),
      'year_attended3'             => $this->input->post('year_attended3'),
      'awards3'                    => $this->input->post('awards3'),
      'subject_best1'              => $this->input->post('subject_best1'),
      'subject_best2'              => $this->input->post('subject_best2'),
      'subject_best3'              => $this->input->post('subject_best3'),
      'subject_best4'              => $this->input->post('subject_best4'),
      'least_best1'                => $this->input->post('least_best1'),
      'least_best2'                => $this->input->post('least_best2'),
      'least_best3'                => $this->input->post('least_best3'),
      'least_best4'                => $this->input->post('least_best4'),
      'name_of_org1'               => $this->input->post('name_of_org1'),
      'postion1'                   => $this->input->post('postion1'),
      'year1'                      => $this->input->post('year1'),
      'name_of_org2'               => $this->input->post('name_of_org2'),
      'postion2'                   => $this->input->post('postion2'),
      'year2'                      => $this->input->post('year2'),
      'otk'                        => $this->input->post('otk'),
      'Relatives'                   => $this->input->post('Relatives'),
      'Relative_name'              => $this->input->post('Relative_name'),
      'relative_department'        => $this->input->post('relative_department'),
      'relative_relationship'      => $this->input->post('relative_relationship'),
      'relative_contact'           => $this->input->post('relative_contact')

    );


    $this->array_logs['action'] = $this->Edit_Info_Model->Update_Info_BED($array);
    $this->array_logs['module'] = 'EDIT INFO SHS';
    //Logs
    $this->Others_Model->insert_logs($this->array_logs);

    $this->session->set_flashdata('success', 'Update Successful');
    redirect('/Admission/SHS_Edit_Info/' . $array['ref_num'], 'refresh');
  }

  //CHOICE BUTTON
  public function NewStudentReport()
  {

    $SB    = $this->input->post('search_button');
    $EX   = $this->input->post('export');


    //Checker of pages
    if (isset($SB)) {
      $this->New_Students();
    } else if (isset($EX)) {
      $this->NewStudentExcel();
    }
  }

  public function New_Students()
  {
    $this->data['get_sy']  = $this->New_Students_Model->get_school_year();
    $this->data['get_sem']  = $this->New_Students_Model->get_sem();

    $array = array(
      'sy' => $this->input->post('sy'),
      'sm' => $this->input->post('sem'),
    );

    $this->data['GetStudent'] = $this->New_Students_Model->Get_New_Students($array);
    $this->render($this->set_views->search_new_student_info());
  }

  public function NewStudentExcel()
  {


    $array = array(
      'sy' => $this->input->post('sy'),
      'sm' => $this->input->post('sem'),
    );


    $this->load->library("Excel");
    $object = new PHPExcel();
    $table_columns = array("#", "NAME", "STUDENT NUMBER", "COURSE", "GENDER", "ADDRESS", "APPLIED STATUS", "YEAR", "CONTACT NUMBER", "HIGH SCHOOL", "TRANFERED SCHOOL ", "CURICULUM", "BIRTHDAY", "NATIONALITY");
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

    $column = 0;

    foreach ($table_columns1 as $field) {
      $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
      $column++;
    }
  }
  // Enrollment Tracker Report Landing page
  public function Enrollment_Tracker_Report()
  {
    $this->data['get_sy']      = $this->Inquiry_Reports_Model->Select_Legends()->result_array();
    $this->data['get_course']  = $this->Inquiry_Reports_Model->Select_Course();

    $this->render($this->set_views->Enrollment_Tracker_Report());
  }

  // AJAX
  //* Enrollment tracker get all report
  public function Enrollment_Summary_Report()
  {
    $array = array(
      'sy' => $this->input->post('sy'),
      'sem' => $this->input->post('sem'),
      'course' => $this->input->post('course'),
    );

    // $this->data['get_sy'][0]['SchoolYear'];
    if (isset($array['sy']) || isset($array['sy']) || isset($array['sy'])) {
      $this->data['Enrollment_Summary_Report_List'] = $this->Enrollment_Tracker_Report_Model->Enrollment_Summary_Report_List($array);
    }

    echo json_encode($this->data['Enrollment_Summary_Report_List']);
  }

  //* Get all Inquiries in higher education
  public function Tracker_Inquiry_Report()
  {
    $array = array(
      'sy' => $this->input->post('sy'),
      'sem' => $this->input->post('sem'),
      'course' => $this->input->post('course'),
    );
    if (isset($array['sy']) || isset($array['sy']) || isset($array['sy'])) {
      $this->data['inquiry_list'] = $this->Enrollment_Tracker_Report_Model->inquiry_list($array);
    }
    echo json_encode($this->data['inquiry_list']);
  }

  //* Get all Advised in inquiries in higher education
  public function Tracker_Advised_Report()
  {
    $array = array(
      'sy' => $this->input->post('sy'),
      'sem' => $this->input->post('sem'),
      'course' => $this->input->post('course'),
    );
    if (isset($array['sy']) || isset($array['sy']) || isset($array['sy'])) {
      $this->data['advised_List'] = $this->Enrollment_Tracker_Report_Model->Advised_List($array);
    }
    echo json_encode($this->data['advised_List']);
  }

  //* Get all Reserved in inquiries in higher education
  public function Tracker_Reserved_Report()
  {
    $array = array(
      'sy' => $this->input->post('sy'),
      'sem' => $this->input->post('sem'),
      'course' => $this->input->post('course'),
    );
    if (isset($array['sy']) || isset($array['sy']) || isset($array['sy'])) {
      $this->data['highered_reserved_list'] = $this->Enrollment_Tracker_Report_Model->Highered_Reserved($array);
    }
    echo json_encode($this->data['highered_reserved_list']);
  }

  //* Get all Enrolled in inquiries in higher education
  public function Tracker_Enrolled_Report()
  {
    $array = array(
      'sy' => $this->input->post('sy'),
      'sem' => $this->input->post('sem'),
      'course' => $this->input->post('course'),
    );
    if (isset($array['sy']) || isset($array['sy']) || isset($array['sy'])) {
      $this->data['enrolled_list'] = $this->Enrollment_Tracker_Report_Model->Enrolled_Student_List($array);
    }
    echo json_encode($this->data['enrolled_list']);
  }

  // Enrollment Tracker Excel
  public function Enrollment_Tracker_Excel($sy = '', $sem = '', $course = '', $tab = '')
  {
    $array = array(
      'sy' => $sy + "",
      'sem' => $sem + "",
      'course' => $course + "",
    );
    $tab = $tab;
    if ($array['sy'] != 0 || $array['sem'] != 0 || $array['course'] != null) {
      if ($tab == 'Enrollment_Tracker') {
        $this->data['Enrollment_Summary_Report_List'] = $this->Enrollment_Tracker_Report_Model->Enrollment_Summary_Report_List($array);
        $this->enrollment_summary_excel($this->data['Enrollment_Summary_Report_List'], $tab);
      } else if ($tab == 'Inquiry') {
        // echo json_encode($array);
        $this->data['inquiry_list'] = $this->Enrollment_Tracker_Report_Model->inquiry_list($array);
        $this->summary_excel($this->data['inquiry_list'], $tab);
        // $this->data['Enrollment_Summary_Report_List'] = $this->Enrollment_Tracker_Report_Model->Enrollment_Summary_Report_List($array);
        // $this->data['inquiry_list'] = $this->Enrollment_Tracker_Report_Model->inquiry_list($array);
      } else if ($tab == 'Advised') {
        $this->data['advised_List'] = $this->Enrollment_Tracker_Report_Model->Advised_List($array);
        $this->summary_excel($this->data['advised_List'], $tab);
      } else if ($tab == 'Reserved') {
        $this->data['highered_reserved_list'] = $this->Enrollment_Tracker_Report_Model->Highered_Reserved($array);
        $this->summary_excel($this->data['highered_reserved_list'], $tab);
      } else if ($tab == 'Enrolled') {
        $this->data['enrolled_list'] = $this->Enrollment_Tracker_Report_Model->Enrolled_Student_List($array);
        $this->summary_excel($this->data['enrolled_list'], $tab);
      }
    }
    $this->array_logs['module'] = $tab . ' Higher Ed Student Report';
    $this->array_logs['action'] = 'Export ' . $tab . ' Higher Ed Student: School Year: ' . $array['sy'] . ' SEMESTER:' . $array['sm'];
    $this->Others_Model->insert_logs($this->array_logs);
  }

  // Enrollment Summary Excel
  public function enrollment_summary_excel($seperate, $tab)
  {
    $object = new PHPExcel();
    // SET FREEZE GRID
    $object->getActiveSheet()->freezePane("A3");
    // SET MERGE
    $object->setActiveSheetIndex(0)->mergeCells('A1:T1');
    // SET WIDTH
    $object->getActiveSheet()->getColumnDimension('B')->setWidth(10);
    $object->getActiveSheet()->getColumnDimension('C')->setWidth(20);
    $object->getActiveSheet()->getColumnDimension('D')->setWidth(30);
    $object->getActiveSheet()->getColumnDimension('E')->setWidth(25);
    $object->getActiveSheet()->getColumnDimension('F')->setWidth(25);
    $object->getActiveSheet()->getColumnDimension('G')->setWidth(25);
    $object->getActiveSheet()->getColumnDimension('H')->setWidth(10);
    $object->getActiveSheet()->getColumnDimension('I')->setWidth(10);
    $object->getActiveSheet()->getColumnDimension('J')->setWidth(10);
    $object->getActiveSheet()->getColumnDimension('K')->setWidth(18);
    $object->getActiveSheet()->getColumnDimension('L')->setWidth(18);
    $object->getActiveSheet()->getColumnDimension('M')->setWidth(18);
    $object->getActiveSheet()->getColumnDimension('N')->setWidth(25);
    $object->getActiveSheet()->getColumnDimension('O')->setWidth(15);
    $object->getActiveSheet()->getColumnDimension('P')->setWidth(15);
    $object->getActiveSheet()->getColumnDimension('Q')->setWidth(20);
    $object->getActiveSheet()->getColumnDimension('R')->setWidth(20);
    $object->getActiveSheet()->getColumnDimension('S')->setWidth(13);
    $object->getActiveSheet()->getColumnDimension('T')->setWidth(10);
    // SET DATA CENTER
    $object->getActiveSheet()->getStyle('A1:T2')->getAlignment()
      ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    // SET DATA TO BOLD
    $object->getActiveSheet()->getStyle('A2:T2')->getFont()->setBold(true);

    // SET VALUE TO CELL
    $object->getActiveSheet()
      ->setCellValue('A1', $tab . ' Student Data')
      // Table Headers
      ->setCellValue('A2', '#')
      ->setCellValue('B2', 'Status')
      ->setCellValue('C2', 'Reference Number')
      ->setCellValue('D2', 'Student Number')
      ->setCellValue('E2', 'Last Name')
      ->setCellValue('F2', 'First Name')
      ->setCellValue('G2', 'Middle name')
      ->setCellValue('H2', 'Gender')
      ->setCellValue('I2', 'Nationality')
      ->setCellValue('J2', 'YearLevel')
      ->setCellValue('K2', '1st Choice')
      ->setCellValue('L2', '2st Choice')
      ->setCellValue('M2', '3st Choice')
      ->setCellValue('N2', 'Search Engine')
      ->setCellValue('O2', 'Contact Telephone')
      ->setCellValue('P2', 'Contact Cellphone')
      ->setCellValue('Q2', 'Address City')
      ->setCellValue('R2', 'Address Province')
      ->setCellValue('S2', 'School Year')
      ->setCellValue('T2', 'Semester');
    $color_background = array(
      'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => 'FF0000')
      )
    );

    $excel_row = 3;
    $excel_column = 0;
    $count = 1;
    foreach ($seperate as $laman) {
      // echo $laman['Reference_Number']." ".$laman['First_Name'];
      $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row,  $count);
      if ($laman['Ref_Num_fec'] != null && $laman['Ref_Num_si'] != null && $laman['Ref_Num_ftc'] != null) {
        $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row,  strtoupper('Enrolled'));
        $object->getActiveSheet()->getStyle('B' . $excel_row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('75ff69');
      } else if ($laman['Ref_Num_ftc'] != null) {
        $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row,  strtoupper('Payment'));
        $object->getActiveSheet()->getStyle('B' . $excel_row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('36cdff');
      } else {
        $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row,  strtoupper('Avising'));
        // $object->getActiveSheet()->getStyle('B'.$excel_row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('FF0000');
      }
      $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row,  strtoupper($laman['Ref_Num_si']));
      $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row,  strtoupper($laman['Std_Num_si']));
      $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row,  strtoupper($laman['Last_Name']));
      $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row,  strtoupper($laman['First_Name']));
      $object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row,  strtoupper($laman['Middle_Name']));
      $object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row,  strtoupper($laman['Gender']));
      $object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row,  strtoupper($laman['Nationality']));
      $object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row,  strtoupper($laman['YearLevel']));
      $object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row,  strtoupper($laman['Course_1st']));
      $object->getActiveSheet()->setCellValueByColumnAndRow(11, $excel_row,  strtoupper($laman['Course_2nd']));
      $object->getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row,  strtoupper($laman['Course_3rd']));
      if ($laman['Others_Know_SDCA'] == 'Come_All') {
        $object->getActiveSheet()->setCellValueByColumnAndRow(
          13,
          $excel_row,
          strtoupper(
            $laman['Others_Know_SDCA'] . " Referral Name: " . $laman['Referral_Name']
          )
        );
      } else {
        $object->getActiveSheet()->setCellValueByColumnAndRow(13, $excel_row,  strtoupper($laman['Others_Know_SDCA']));
      }
      $object->getActiveSheet()->setCellValueByColumnAndRow(14, $excel_row, $laman['Tel_No']);
      $object->getActiveSheet()->setCellValueByColumnAndRow(15, $excel_row, $laman['CP_No']);
      $object->getActiveSheet()->setCellValueByColumnAndRow(16, $excel_row, strtoupper($laman['Address_City']));
      $object->getActiveSheet()->setCellValueByColumnAndRow(17, $excel_row, strtoupper($laman['Address_Province']));
      $object->getActiveSheet()->setCellValueByColumnAndRow(18, $excel_row, strtoupper($laman['Applied_SchoolYear']));
      $object->getActiveSheet()->setCellValueByColumnAndRow(19, $excel_row, strtoupper($laman['Applied_Semester']));

      $excel_row++;
      $excel_column++;
      $count++;
    }

    $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $tab . '_Student_Data.xls"');
    $object_writer->save('php://output');
  }

  // Static Design
  public function excel_summary_static_design()
  {
    $object = new PHPExcel();
    // SET FREEZE GRID
    $object->getActiveSheet()->freezePane("A3");
    // Set WIDTH
    $object->setActiveSheetIndex(0)->mergeCells('A1:P1');
    $object->getActiveSheet()->getColumnDimension('B')->setWidth(20);
    $object->getActiveSheet()->getColumnDimension('C')->setWidth(25);
    $object->getActiveSheet()->getColumnDimension('D')->setWidth(25);
    $object->getActiveSheet()->getColumnDimension('E')->setWidth(25);
    $object->getActiveSheet()->getColumnDimension('G')->setWidth(15);
    $object->getActiveSheet()->getColumnDimension('H')->setWidth(10);
    $object->getActiveSheet()->getColumnDimension('I')->setWidth(15);
    $object->getActiveSheet()->getColumnDimension('J')->setWidth(15);
    $object->getActiveSheet()->getColumnDimension('K')->setWidth(18);
    $object->getActiveSheet()->getColumnDimension('L')->setWidth(18);
    $object->getActiveSheet()->getColumnDimension('M')->setWidth(25);
    $object->getActiveSheet()->getColumnDimension('N')->setWidth(25);
    $object->getActiveSheet()->getColumnDimension('O')->setWidth(12);
    $object->getActiveSheet()->getColumnDimension('P')->setWidth(12);
    // SET DATA CENTER
    $object->getActiveSheet()->getStyle('A1')->getAlignment()
      ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    // SET DATA TO BOLD
    $object->getActiveSheet()->getStyle('A2:P2')->getFont()->setBold(true);

    // SET VALUE TO CELL
    $object->getActiveSheet()
      // Table Headers
      ->setCellValue('A2', '#')
      ->setCellValue('B2', 'Reference Number')
      ->setCellValue('C2', 'Last Name')
      ->setCellValue('D2', 'First Name')
      ->setCellValue('E2', 'Middle name')
      ->setCellValue('F2', 'Gender')
      ->setCellValue('G2', 'Nationality')
      ->setCellValue('H2', 'YearLevel')
      ->setCellValue('I2', 'Course')
      ->setCellValue('J2', 'Search Engine')
      ->setCellValue('K2', 'Contact Telephone')
      ->setCellValue('L2', 'Contact Cellphone')
      ->setCellValue('M2', 'Address City')
      ->setCellValue('N2', 'Address Province')
      ->setCellValue('O2', 'School Year')
      ->setCellValue('P2', 'Semester');
    return $object;
  }
  // Enrolled Excel
  public function summary_excel($seperate, $tab)
  {
    $object = $this->excel_summary_static_design();
    // Title
    $object->getActiveSheet()->setCellValue('A1', $tab . '_Student_Data');

    $excel_row = 3;
    $excel_column = 0;
    $count = 1;
    foreach ($seperate as $laman) {
      // echo $laman['Reference_Number']." ".$laman['First_Name'];
      $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row,  $count);
      if ($tab == 'Inquiry') {
        $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row,  strtoupper($laman['Ref_Num_si']));
      } else if ($tab == 'Advised') {
        $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row,  strtoupper($laman['Ref_Num_ftc']));
      } else if ($tab == 'Reserved') {
        $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row,  strtoupper($laman['Ref_No_rf']));
      } else if ($tab == 'Enrolled') {
        $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row,  strtoupper($laman['Reference_Number']));
      }
      $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row,  strtoupper($laman['Last_Name']));
      $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row,  strtoupper($laman['First_Name']));
      $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row,  strtoupper($laman['Middle_Name']));
      $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row,  strtoupper($laman['Gender']));
      $object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row,  strtoupper($laman['Nationality']));
      $object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row,  strtoupper($laman['YearLevel']));
      $object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row,  strtoupper($laman['course']));
      if ($laman['Others_Know_SDCA'] == 'Come_All') {
        $object->getActiveSheet()->setCellValueByColumnAndRow(
          9,
          $excel_row,
          strtoupper(
            $laman['Others_Know_SDCA'] . " Referral Name: " . $laman['Referral_Name']
          )
        );
      } else {
        $object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row,  strtoupper($laman['Others_Know_SDCA']));
      }
      $object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, $laman['Tel_No']);
      $object->getActiveSheet()->setCellValueByColumnAndRow(11, $excel_row, $laman['CP_No']);
      $object->getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row, strtoupper($laman['Address_City']));
      $object->getActiveSheet()->setCellValueByColumnAndRow(13, $excel_row, strtoupper($laman['Address_Province']));
      $object->getActiveSheet()->setCellValueByColumnAndRow(14, $excel_row, strtoupper($laman['Applied_SchoolYear']));
      $object->getActiveSheet()->setCellValueByColumnAndRow(15, $excel_row, strtoupper($laman['Applied_Semester']));

      $excel_row++;
      $excel_column++;
      $count++;
    }

    $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $tab . '_Student_Data.xls"');
    $object_writer->save('php://output');
  }

  // public function single_search_summary()
  // {
  //   $data = $this->input->post('search_text');
  //   $single_search = $this->Enrollment_Tracker_Report_Model->Enrollment_Summary_Like_Search($data);
  //   echo json_encode($single_search);
  // }

  // public function single_search_inquiry()
  // {
  //   $data = $this->input->post('search_text');
  //   $single_search = $this->Enrollment_Tracker_Report_Model->Inquiry_List_Like_Search($data);
  //   echo json_encode($single_search);
  // }

  // public function single_search_advised()
  // {
  //   $data = $this->input->post('search_text');
  //   $single_search = $this->Enrollment_Tracker_Report_Model->Advised_List_Like_Search($data);
  //   echo json_encode($single_search);
  // }

  // public function single_search_reserved()
  // {
  //   $data = $this->input->post('search_text');
  //   $single_search = $this->Enrollment_Tracker_Report_Model->Highered_Reserved_Like_Search($data);
  //   echo json_encode($single_search);
  // }

  // public function single_search_enrolled()
  // {
  //   $data = $this->input->post('search_text');
  //   $single_search = $this->Enrollment_Tracker_Report_Model->Enrolled_Student_List_Like_Search($data);
  //   echo json_encode($single_search);
  // }


  // public function Count_Tally(){
  //   // $array = array(
  //   //   'from' => '2021-01-01',
  //   //   'to' => '2021-12-30'
  //   // );
  //   $array = array(
  //     'from' => $this->input->post('from'),
  //     'to' => $this->input->post('to')
  //   );
  //   $transactions = $this->Enrollment_Tracker_Report_Model->Get_Transaction_log($array);
  //   $programs = $this->Enrollment_Tracker_Report_Model->Get_All_Programs();
  //   $program_array = array();
  //   foreach($programs as $program ){
  //     $counting = 0;
  //     foreach($transactions as $transaction){
  //       if($program['Program_Code'] == $transaction['Course']){
  //         $counting +=1;
  //       }
  //     }
  //     $program_array[$program['Program_Code']][]= $counting;
  //   }
  //   die(json_encode($program_array));
  // }
  // Enrollment Tally Report Landing page
  public function Enrollment_Tally_Report()
  {
    // $this->data['get_sy'] = $this->Inquiry_Reports_Model->Select_Legends()->result_array();
    $this->data['get_course']  = $this->Inquiry_Reports_Model->Select_Course();
    $this->data['get_province'] = $this->Enrollment_Tracker_Report_Model->Get_All_Province();

    $this->render($this->set_views->Enrollment_Tally_Report());
  }

  public function Count_Program_Tally()
  {
    // $array = array(
    //   'sy' => '2019-2020',
    //   'sem' => '0',
    //   'course' => '',
    // );
    $array = array(
      'sy' => $this->input->post('sy'),
      'sem' => $this->input->post('sem'),
      // 'course' => $this->input->post('course'),
    );
    $program_array = $this->Program_Tally($array);
    echo json_encode($program_array);
  }

  public function Program_Tally($array)
  {
    $students = $this->Enrollment_Tracker_Report_Model->Enrollment_Summary_Report_List($array);
    $reserved_students = $this->Enrollment_Tracker_Report_Model->Highered_Reserved($array);
    // die(json_encode($students));
    $programs = $this->Enrollment_Tracker_Report_Model->Get_All_Programs();
    $program_array = array();
    foreach ($programs as $program) {
      $inquiry_count = 0;
      $advising_count = 0;
      $reserved_count = 0;
      $enrolled_count = 0;
      foreach ($students as $student) {
        if ($program['Program_Code'] == $student['Course_1st']) {
          $inquiry_count += 1;
          // }
          // if ($program['Program_Code'] == $student['Course']) {
          if ($student['Ref_Num_fec'] != null && $student['Ref_Num_si'] != null && $student['Ref_Num_ftc'] != null) {
            $enrolled_count += 1;
          }
          if ($student['Ref_Num_ftc'] != null) {
            $advising_count += 1;
          }
        }
      }
      foreach ($reserved_students as $reserved_student) {
        if ($program['Program_Code'] == $reserved_student['Course_1st']) {
          $reserved_count += 1;
        }
      }
      $counted_array = array($inquiry_count, $advising_count, $reserved_count, $enrolled_count);

      $program_array[$program['Program_Code']][] = $counted_array;
    }
    // die(json_encode($students));
    return $program_array;
  }
  public function Count_City_Tally()
  {
    $array = array(
      'sy' => $this->input->post('sy'),
      'sem' => $this->input->post('sem'),
    );
    $students = $this->Enrollment_Tracker_Report_Model->City_Tally($array);
    echo json_encode($students);
  }

  public function Program_Word_Export($sy, $sem)
  {
    // die('asdsad');
    $array = array(
      'sy' => $sy,
      'sem' => $sem,
    );
    $program_tally = $this->Program_Tally($array);
    // die(json_encode($program_tally));
    $phpWord = new \PhpOffice\PhpWord\PhpWord();
    // $phpWord->getCompatibility()->setOoxmlVersion(14);
    // $phpWord->getCompatibility()->setOoxmlVersion(15);
    $section = $phpWord->addSection();
    $center_align = array(
      'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER
    );
    $bold_text = array(
      'name' => 'Arial',
      'size' => 12,
      'bold' => true,
    );
    $table_header = array(
      'name' => 'Arial',
      'size' => 9,
      'bold' => true,
    );
    $table_body = array(
      'name' => 'Arial',
      'size' => 9,
      // 'bold' => true,
    );
    $tableStyle = [
      // 'borderSize' => 6,
      'align' => 'center'
    ];
    $cell_tableStyle = [
      'borderSize' => 6,
    ];
    $table_header_bottom = [
      // 'borderTopSize' => 6,
      'borderRightSize' => 6,
      'borderBottomSize' => 6,
      'borderLeftSize' => 6,
      'gridSpan' => 5
    ];
    $table_header_top = [
      'borderTopSize' => 6,
      'borderRightSize' => 6,
      // 'borderBottomSize' => 6,
      'borderLeftSize' => 6,
      'gridSpan' => 5
    ];
    $date_today = date("F j, Y");

    // $image = $section->addTable();
    $image = $section->addHeader();
    $image = $image->addTable();
    $image->addRow();
    // $table->addCell(4500)->addText('This is the header.');
    $image->addCell(5000)->addImage(
      base_url() . '/img/word_header.jpg',
      array(
        'width'  => 450,
        'height' => 60,
        'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER
      )
    );
    // $table->addRow();

    $section->addText(
      'ENROLLMENT STATUS REPORT',
      $bold_text,
      $center_align
    );

    $section->addText(
      'As of ' . $date_today,
      array(
        'name' => 'Arial',
        'size' => 10
      ),
      $center_align
    );

    $phpWord->addTableStyle('myTable', $tableStyle);
    $table = $section->addTable(
      'myTable'
    );

    $cellRowSpan = array('vMerge' => 'restart');
    $cellRowContinue = array('vMerge' => 'continue');
    $cellColSpan = array('gridSpan' => 2);

    $table->addRow();
    $table_title_top = 'Higher Education AY ' . $array['sy'];
    $table->addCell(null, $table_header_top)->addText($table_title_top, $bold_text, $center_align);

    $table->addRow();
    if ($array['sem'] == 'FIRST') {
      $table_title_bottom = ' 1st Semester';
    } else if ($array['sem'] == 'SECOND') {
      $table_title_bottom = ' 2nd Semester';
    } else {
      $table_title_bottom = ' Summer';
    }
    $table->addCell(null, $table_header_bottom)->addText($table_title_bottom, array(
      'name' => 'Arial',
      'size' => 10
    ), $center_align);

    $table->addRow();
    $table->addCell(3000, $cell_tableStyle)->addText('Course', $table_header, $center_align);
    $table->addCell(3000, $cell_tableStyle)->addText('Inquiry', $table_header, $center_align);
    $table->addCell(3000, $cell_tableStyle)->addText('Advising', $table_header, $center_align);
    $table->addCell(3000, $cell_tableStyle)->addText('Reserved', $table_header, $center_align);
    $table->addCell(3000, $cell_tableStyle)->addText('Enrolled', $table_header, $center_align);
    $total_inquiry = 0;
    $total_advising = 0;
    $total_reserved = 0;
    $total_enrolled = 0;
    foreach ($program_tally as $key => $product) {
      $table->addRow();
      $table->addCell(3000, $cell_tableStyle)->addText($key, $table_body, $center_align);
      $table->addCell(3000, $cell_tableStyle)->addText($product[0][0], $table_body, $center_align);
      $table->addCell(3000, $cell_tableStyle)->addText($product[0][1], $table_body, $center_align);
      $table->addCell(3000, $cell_tableStyle)->addText($product[0][2], $table_body, $center_align);
      $table->addCell(3000, $cell_tableStyle)->addText($product[0][3], $table_body, $center_align);
      $total_inquiry += $product[0][0];
      $total_advising += $product[0][1];
      $total_reserved += $product[0][2];
      $total_enrolled += $product[0][3];
    }
    $table->addRow();
    $table->addCell(3000, $cell_tableStyle)->addText('Total', $table_header, $center_align);
    $table->addCell(3000, $cell_tableStyle)->addText($total_inquiry, $table_body, $center_align);
    $table->addCell(3000, $cell_tableStyle)->addText($total_advising, $table_body, $center_align);
    $table->addCell(3000, $cell_tableStyle)->addText($total_reserved , $table_body, $center_align);
    $table->addCell(3000, $cell_tableStyle)->addText($total_enrolled, $table_body, $center_align);
    // header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
    // header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    // header('Expires: 0');
    // header("Cache-Control: public");
    // header("Content-Description: File Transfer");
    // header("Content-Transfer-Encoding: binary");
    // header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Content-Disposition: attachment;filename="PROGRAMS-ENROLLMENT-STATUS-REPORT.docx"');
    $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
    $objWriter->save('php://output');
    exit;
  }

  public function City_Word_Export($sy, $sem)
  {
    // die('asdsad');
    $array = array(
      'sy' => $sy,
      'sem' => $sem,
      // 'course' => $this->input->post('course'),
    );
    // $array = array(
    //   'sy' => '2021-2022',
    //   'sem' => 'FIRST',
    //   // 'course' => $this->input->post('course'),
    // );
    $city_tally = $this->Enrollment_Tracker_Report_Model->City_Tally($array);
    // die(json_encode($program_tally));
    $phpWord = new \PhpOffice\PhpWord\PhpWord();
    // $phpWord->getCompatibility()->setOoxmlVersion(14);
    // $phpWord->getCompatibility()->setOoxmlVersion(15);
    $section = $phpWord->addSection();
    $center_align = array(
      'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER
    );
    $bold_text = array(
      'name' => 'Arial',
      'size' => 12,
      'bold' => true,
    );
    $table_header = array(
      'name' => 'Arial',
      'size' => 9,
      'bold' => true,
    );
    $table_body = array(
      'name' => 'Arial',
      'size' => 9,
      // 'bold' => true,
    );
    $tableStyle = [
      // 'borderSize' => 6,
      'align' => 'center'
    ];
    $cell_tableStyle = [
      'borderSize' => 6,
    ];
    $table_header_bottom = [
      // 'borderTopSize' => 6,
      'borderRightSize' => 6,
      'borderBottomSize' => 6,
      'borderLeftSize' => 6,
      'gridSpan' => 5
    ];
    $table_header_top = [
      'borderTopSize' => 6,
      'borderRightSize' => 6,
      // 'borderBottomSize' => 6,
      'borderLeftSize' => 6,
      'gridSpan' => 5
    ];
    $date_today = date("F j, Y");

    $image = $section->addHeader();
    $image = $image->addTable();
    $image->addRow();
    // $table->addCell(4500)->addText('This is the header.');
    $image->addCell(5000)->addImage(
      base_url() . '/img/word_header.jpg',
      array(
        'width'  => 450,
        'height' => 60,
        'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER
      )
    );
    // $table->addRow();

    $section->addText(
      'TOP 10 CITIES REPORT',
      $bold_text,
      $center_align
    );

    $section->addText(
      'As of ' . $date_today,
      array(
        'name' => 'Arial',
        'size' => 10
      ),
      $center_align
    );

    $phpWord->addTableStyle('myTable', $tableStyle);
    $table = $section->addTable(
      'myTable'
    );

    $cellRowSpan = array('vMerge' => 'restart');
    $cellRowContinue = array('vMerge' => 'continue');
    $cellColSpan = array('gridSpan' => 2);

    $table->addRow();
    $table_title_top = 'Higher Education AY ' . $array['sy'];
    $table->addCell(null, $table_header_top)->addText($table_title_top, $bold_text, $center_align);

    $table->addRow();
    if ($array['sem'] == 'FIRST') {
      $table_title_bottom = ' 1st Semester';
    } else if ($array['sem'] == 'SECOND') {
      $table_title_bottom = ' 2nd Semester';
    } else {
      $table_title_bottom = ' Summer';
    }
    $table->addCell(null, $table_header_bottom)->addText($table_title_bottom, array(
      'name' => 'Arial',
      'size' => 10
    ), $center_align);

    $table->addRow();
    $table->addCell(3000, $cell_tableStyle)->addText('City', $table_header, $center_align);
    $table->addCell(3000, $cell_tableStyle)->addText('Inquiry', $table_header, $center_align);
    $total_inquiry = 0;
    foreach ($city_tally as $tally) {
      $table->addRow();
      $table->addCell(3000, $cell_tableStyle)->addText($tally['Address_City'], $table_body, $center_align);
      $table->addCell(3000, $cell_tableStyle)->addText($tally['count_student'], $table_body, $center_align);
      $total_inquiry += $tally['count_student'];
    }
    $table->addRow();
    $table->addCell(3000, $cell_tableStyle)->addText('Total', $table_header, $center_align);
    $table->addCell(3000, $cell_tableStyle)->addText($total_inquiry, $table_body, $center_align);
    // header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
    // header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    // header('Expires: 0');
    // header("Cache-Control: public");
    // header("Content-Description: File Transfer");
    // header("Content-Transfer-Encoding: binary");
    // header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    $file_name = '';
    header('Content-Disposition: attachment;filename="CITIES-ENROLLMENT-STATUS-REPORT.docx"');
    $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
    $objWriter->save('php://output');
    exit;
  }
}//end class