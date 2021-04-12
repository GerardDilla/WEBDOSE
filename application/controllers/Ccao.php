<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Ccao extends MY_Controller  {

	
  function __construct() 
  {
        parent::__construct();
        $this->load->library('set_views');
        $this->load->library("Excel");
        $this->load->model('Ccao_Model/Carreertalk_Model');
         //check if user is logged on
        $this->load->library('set_custom_session');
        $this->load->library('pagination');
        $this->admin_data = $this->set_custom_session->admin_session();

        //user accessibility
        $this->load->library('User_accessibility');
        $this->user_accessibility->module_admission_access($this->admin_data['userid']);
        
  }	


  ///Career Talk Encoding
  public function Encoding(){

    $this->render($this->set_views->ccao_encoding()); 
    $this->session->set_flashdata('Inquiry','');
    
  }

  public function Encoding_Insert(){

    $array = array(
      'date'           => $this->input->post('date'),
      'school'         => $this->input->post('school'),
      'fullname'       => $this->input->post('fullname'),
      's_number'       => $this->input->post('s_number'),
      'fb'             => $this->input->post('fb'),
      'last_school'    => $this->input->post('last_school'),
      'guardian_name'  => $this->input->post('guardian_name'),
      'occupation'     => $this->input->post('occupation'),
      'g_number'       => $this->input->post('g_number'),
      'address'        => $this->input->post('address'),
      '1st'            => $this->input->post('1st'),
      '2nd'            => $this->input->post('2nd'),
      '3rd'            => $this->input->post('3rd'),
      '3rd'            => $this->input->post('3rd'),
      'school'         => $this->input->post('school'),
    );

    $this->Carreertalk_Model->insert($array);
    $this->session->set_flashdata('Inquiry','Data Sucessfully Inserted'); 
    redirect('/Ccao/Encoding', 'refresh');
    

  }
  ///Career Talk Encoding





///Choices Button

public function Check_Inquiry_Button(){

  $Sb      = $this->input->post('submit');
  $exp     = $this->input->post('export');
  
  if(isset($Sb)){

    $this->Reports();

  }
  else if(isset($exp)){

    $this->Reports_excel();
  }

}

///Choices Button


  ///Career Talk Reports
  public function Reports(){

    $array = array(
      'school'           => $this->input->post('school'),
    );
    $this->data['get_inquiry']   = $this->Carreertalk_Model->select_inquiry($array);
    $this->render($this->set_views->ccao_reports()); 
  
  }
 ///Career Talk Reports


   ///Reports Excel
 public function Reports_excel()
  {

    $array = array(
      'school'      => $this->input->post('school'),
    );

    $object = new PHPExcel();
    $object->setActiveSheetIndex(0);

    $object->getActiveSheet()->setCellValue('A1','#');
    $object->getActiveSheet()->setCellValue('B1','Date');
    $object->getActiveSheet()->setCellValue('C1','Name');
    $object->getActiveSheet()->setCellValue('D1','Contact Number');
    $object->getActiveSheet()->setCellValue('E1','Fb Account');
    $object->getActiveSheet()->setCellValue('F1','School');
    $object->getActiveSheet()->setCellValue('G1','Guardian Name');
    $object->getActiveSheet()->setCellValue('H1','Occupation');
    $object->getActiveSheet()->setCellValue('I1','Contact Number');
    $object->getActiveSheet()->setCellValue('J1','Present Address');
    $object->getActiveSheet()->setCellValue('K1','1st Choice');
    $object->getActiveSheet()->setCellValue('L1','2nd Choice');
    $object->getActiveSheet()->setCellValue('M1','3rd Choice');
   


    $inquiry_data = $this->Carreertalk_Model->select_inquiry($array);

    $column = 0;
    foreach($table_columns as $field)
    {
      $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
      $column++;
    }

    $count = 1;
    $excel_row = 2;

      foreach($inquiry_data->result()  as $row)
      {
          $object->getActiveSheet()->setCellValueByColumnAndRow(0,  $excel_row, $count);
          $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->date);
          $object->getActiveSheet()->setCellValueByColumnAndRow(2,  $excel_row, $row->name);
          $object->getActiveSheet()->setCellValueByColumnAndRow(3,  $excel_row, $row->s_contact);
          $object->getActiveSheet()->setCellValueByColumnAndRow(4,  $excel_row, $row->fb_user);
          $object->getActiveSheet()->setCellValueByColumnAndRow(5,  $excel_row, $row->last_school);
          $object->getActiveSheet()->setCellValueByColumnAndRow(6,  $excel_row, $row->g_name);
          $object->getActiveSheet()->setCellValueByColumnAndRow(7,  $excel_row, $row->g_occupation);
          $object->getActiveSheet()->setCellValueByColumnAndRow(8,  $excel_row, $row->g_number);
          $object->getActiveSheet()->setCellValueByColumnAndRow(9,  $excel_row, $row->address);
          $object->getActiveSheet()->setCellValueByColumnAndRow(10,  $excel_row, $row->first_choice);
          $object->getActiveSheet()->setCellValueByColumnAndRow(11, $excel_row, $row->second_choice);
          $object->getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row, $row->third_choice);
       
        
          $excel_row++;

          $count = $count + 1;
      }

    $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="InquiryReport.xls"');
    $object_writer->save('php://output');
    
  }

  ///Career Talk Reports





 ///Career Talk Reports
 public function Import_Reports(){

  $this->render($this->set_views->Import_Reports()); 

}
///Career Talk Reports



function import()
 {
  if(isset($_FILES["file"]["name"]))
  {
   $path = $_FILES["file"]["tmp_name"];
   $object = PHPExcel_IOFactory::load($path);
   foreach($object->getWorksheetIterator() as $worksheet)
   {
    $highestRow = $worksheet->getHighestRow();
    $highestColumn = $worksheet->getHighestColumn();
    for($row=2; $row<=$highestRow; $row++)
    {
     $name                 = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
     $dd                   = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
     $last_school          = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
     $s_contact            = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
     $fb_user              = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
     $first_choice         = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
     $second_choice        = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
     $third_choice         = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
     $school               = $worksheet->getCellByColumnAndRow(9, $row)->getValue();


     $data[]  = array(
      'name'                 => $name,
      'date'                 => $dd,
      'last_school'          => $last_school,
      's_contact'            => $s_contact,
      'fb_user'              => $fb_user,
      'first_choice'         => $first_choice,
      'second_choice'        => $second_choice,
      'third_choice'         => $third_choice,
      'school'               => $school,
      'active'              => '1'
     );

    }
   }
   $this->Carreertalk_Model->insert_import($data);
   echo 'Data Imported successfully';
  } 
 }




 public function Dropdown_Data(){

  $school = $this->input->get('school');
  $result = $this->Carreertalk_Model->get_dropdown_data($school);
  echo json_encode($result);

}







}//end class

