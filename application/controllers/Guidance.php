<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Guidance extends MY_Controller
{


  function __construct()
  {
    parent::__construct();
    $this->load->library('set_views');
    $this->load->library("Excel");
    $this->load->model('Guidance_Model/EnrolledStudents_Model');
    //check if user is logged on
    $this->load->library('set_custom_session');
    $this->load->library('pagination');
    $this->admin_data = $this->set_custom_session->admin_session();

    //user accessibility
    $this->load->library('User_accessibility');
    $this->user_accessibility->module_admission_access($this->admin_data['userid']);
  }



  //Get Program Major
  function fetch_major()
  {
    if ($this->input->post('Program_id')) {
      $resultdata = $this->EnrolledStudents_Model->GetMajor($this->input->post('Program_id'));
      echo json_encode($resultdata);
    }
  }

  //Get Sections
  function fetch_sections()
  {
    if ($this->input->post('Program_id')) {
      $resultdata = $this->EnrolledStudents_Model->GetSection_Name($this->input->post('Program_id'));
      echo json_encode($resultdata);
    }
  }

  //Get Municipality
  function fetch_muni()
  {
    if ($this->input->post('Province_code')) {
      $resultdata = $this->EnrolledStudents_Model->Get_Municipality($this->input->post('Province_code'));
      echo json_encode($resultdata);
    }
  }

  //Get Barangay
  function fetch_barangay()
  {
    if ($this->input->post('Municipality_code')) {
      $resultdata = $this->EnrolledStudents_Model->Get_Barangay($this->input->post('Municipality_code'));
      echo json_encode($resultdata);
    }
  }


  //CHOICE BUTTON
  public function EnrolledStudentREPORT()
  {

    $SB    = $this->input->post('search_button');
    $EX   = $this->input->post('export');


    //Checker of pages
    if (isset($SB)) {
      $this->reportenrollstudents();
    } else if (isset($EX)) {
      $this->reportenrollstudents_excel();
    }
  }


  //ENROLLED STUDENT VIEW
  public function reportenrollstudents()
  {
    $this->form_validation->set_rules('Gender', 'Test Field', 'required');
    $this->data['Get_SEM']                 = $this->EnrolledStudents_Model->GetSEM();
    $this->data['Get_YEAR']                = $this->EnrolledStudents_Model->GetYEAR();
    $this->data['Get_Course']              = $this->EnrolledStudents_Model->Get_Course();
    $this->data['Get_YearLevel']           = $this->EnrolledStudents_Model->GetYearLevel();
    $this->data['Get_Nationality']         = $this->EnrolledStudents_Model->Get_Nationality();
    $this->data['Get_Gender']              = $this->EnrolledStudents_Model->Get_Gender();
    $this->data['Getprovince']             = $this->EnrolledStudents_Model->Get_province();



    $array = array(

      'sy'       => $this->input->post('School_year'),
      'sm'       => $this->input->post('Sem'),
      'nt'       => $this->input->post('National'),
      'pmajor'   => $this->input->post('Program'),
      'major'    => $this->input->post('mjr'),
      'Gender'   => $this->input->post('Gender'),
      'Yl'       => $this->input->post('YearLevel'),
      'Sec'      => $this->input->post('Section'),
      'submit'   => $this->input->post('search_button'),
      'municipality'   => $this->input->post('municipality')
    );


    $this->data['GetStudent'] = $this->EnrolledStudents_Model->GetStudentList($array);
    $this->render($this->set_views->guidance_enrolled_student());
  }



  public function reportenrollstudents_excel()
  {

    $array = array(

      'sy'       => $this->input->post('School_year'),
      'sm'       => $this->input->post('Sem'),
      'nt'       => $this->input->post('National'),
      'pmajor'   => $this->input->post('Program'),
      'major'    => $this->input->post('mjr'),
      'Gender'   => $this->input->post('Gender'),
      'Yl'       => $this->input->post('Yearlevel'),
      'Sec'      => $this->input->post('Section'),
      'submit'   => $this->input->post('search_button'),
      'municipality'   => $this->input->post('municipality')

    );

    $this->load->library("Excel");
    $object = new Spreadsheet();
    $object->setActiveSheetIndex()->getColumnDimension('A')->setWidth(10);
    $object->setActiveSheetIndex()->getColumnDimension('B')->setWidth(25);
    $object->setActiveSheetIndex()->getColumnDimension('C')->setWidth(25);
    $object->setActiveSheetIndex()->getColumnDimension('D')->setWidth(25);
    $object->setActiveSheetIndex()->getColumnDimension('E')->setWidth(25);
    $object->setActiveSheetIndex()->getColumnDimension('F')->setWidth(25);
    $object->setActiveSheetIndex()->getColumnDimension('G')->setWidth(25);
    $object->setActiveSheetIndex()->getColumnDimension('H')->setWidth(25);
    $object->setActiveSheetIndex()->getColumnDimension('I')->setWidth(25);
    $object->setActiveSheetIndex()->getColumnDimension('J')->setWidth(25);
    $object->setActiveSheetIndex()->getColumnDimension('K')->setWidth(25);
    $object->setActiveSheetIndex()->getColumnDimension('L')->setWidth(25);
    $object->setActiveSheetIndex()->getColumnDimension('M')->setWidth(25);
    $object->setActiveSheetIndex()->getColumnDimension('N')->setWidth(25);
    $object->setActiveSheetIndex()->getColumnDimension('O')->setWidth(25);
    $object->setActiveSheetIndex()->getColumnDimension('P')->setWidth(25);
    $object->setActiveSheetIndex()->getColumnDimension('Q')->setWidth(25);
    $object->setActiveSheetIndex()->getColumnDimension('R')->setWidth(25);
    $object->setActiveSheetIndex()->getColumnDimension('S')->setWidth(25);
    $object->setActiveSheetIndex()->getColumnDimension('T')->setWidth(25);

    $object->getActiveSheet()->setCellValue('A1', 'HEI Name:');
    $object->getActiveSheet()->setCellValue('B1', 'St. Dominic College of Asia:');
    $object->getActiveSheet()->setCellValue('A2', 'HEI UII:');
    $object->getActiveSheet()->setCellValue('B2', '04296');
    $object->getActiveSheet()->setCellValue('A3', 'Acad Year: ');
    $object->getActiveSheet()->setCellValue('B3', $array['sy']);
    $object->setActiveSheetIndex(0)->mergeCells('D1:F1', 'G1:J1', 'K1:M1');
    $object->setActiveSheetIndex(0);

    $table_columns1 = array("", "", "", "STUDENT`S NAME", "", "", "STUDENT`S PROFILE", "", "", "", "", "", "", "", "", "", "", "", "PERMANENT ADDRESS", "", "");
    $table_columns = array("SEQ", "LEARNER`S REFERENCE NO.", "STUDENT ID", "LAST NAME", "GIVEN NAME", "MIDDLE NAME", "SEX", "BIRTHDATE", "COMPLETE PROGRAM NAME", "YEAR LEVEL", "FATHER`S NAME", "MOTHER`S MAIDEN NAME", "DSWD HOUSEHOLD NO.", "HOUSEHOLD PER CAPITA INCOME", "STREET & BARANGAY", "TOWN/CITY/MUN", "PROVINCE", "ZIPCODE", "TOTAL ASSESSMENT", "DISABILITY");

    $column = 0;

    foreach ($table_columns1 as $field) {
      $object->getActiveSheet()->setCellValueByColumnAndRow($column, 4, $field);
      $column++;
    }
    $column = 0;
    foreach ($table_columns as $field) {
      $object->getActiveSheet()->setCellValueByColumnAndRow($column, 5, $field);
      $column++;
    }

    $employee_data = $this->EnrolledStudents_Model->GetStudentList($array);

    $excel_row = 6;
    $count = 1;
    foreach ($employee_data->result_array() as $row) {
      $object->setActiveSheetIndex()->getStyle('' . $excel_row . '')->getAlignment()
        ->setHorizontal('left');
      $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $count);
      $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, '');
      $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row['Student_Number']);
      $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, strtoupper($row['Last_Name']));
      $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, strtoupper($row['First_Name']));
      $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, strtoupper($row['Middle_Name']));
      $object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, strtoupper($row['Gender']));
      $object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $row['Birth_Date']);
      $object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, strtoupper($row['courseTitle']));
      $object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, $row['YL']);
      $object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, strtoupper($row['Father_Name']));
      $object->getActiveSheet()->setCellValueByColumnAndRow(11, $excel_row, strtoupper($row['Mother_Name']));
      $object->getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row, '');
      $object->getActiveSheet()->setCellValueByColumnAndRow(13, $excel_row, '');
      $object->getActiveSheet()->setCellValueByColumnAndRow(14, $excel_row, strtoupper($row['Address_Barangay']));
      $CITY = strtoupper($row['Address_City']);
      $default = array('CITY', 'OF');
      $repalce = array('', '');
      $object->getActiveSheet()->setCellValueByColumnAndRow(15, $excel_row, ltrim(str_replace($default, $repalce, $CITY)));
      $object->getActiveSheet()->setCellValueByColumnAndRow(16, $excel_row, strtoupper($row['Address_Province']));
      $object->getActiveSheet()->setCellValueByColumnAndRow(17, $excel_row, strtoupper($row['Address_Zip']));
      $object->getActiveSheet()->setCellValueByColumnAndRow(18, $excel_row, '');
      $object->getActiveSheet()->setCellValueByColumnAndRow(19, $excel_row, '');
      $count = $count + 1;
      $excel_row++;
    }

    $object_writer = new \PhpOffice\PhpSpreadsheet\Writer\Xls($object);
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="Student_Data.xls"');
    $object_writer->save('php://output');
  }
}//end class
