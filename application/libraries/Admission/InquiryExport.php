<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Exports data to Inquiry form
 *
 * 
 *
 * @param array $parameters Array containing the necessary params.
 *   $parameters = [
 *     'student_info'   =>  (array) first row of student data.
 *     'student_type'   =>  (string) type of student: HED, SHS, BED.
 *  ]
 */

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\HeaderFooterDrawing;
use PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf;
use TNkemdilim\MoneyToWords\Converter;
use TNkemdilim\MoneyToWords\Languages as Language;

//FOR TEST ONLY Remove it later
use PhpOffice\PhpSpreadsheet\Worksheet\IOFactory;
//require __DIR__ . '/../Header.php';

class inquiryexport extends Student
{
   private $inputFileType;
   private $inputFileName;
   private $Studentdata;
   private $spreadsheet;
   private $sheet1;
   private $sheet2;
   private $datalegend;
   private $cell;
   private $EducationChoices;
   private $IncomeChoices;

   public function __construct($parameters = array())
   {
      parent::__construct($parameters);
      #Gets Student Info and settings for importing
      $this->inputFileType = 'Xlsx'; // Xlsx - Xml - Ods - Slk - Gnumeric - Csv\
      $this->inputFileName = './export_template/InquiryTemplate.xlsx';

      #Setup spreadsheet
      //$this->spreadsheet = new Spreadsheet();
      // $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($this->inputFileType);
      // $this->spreadsheet = $reader->load($this->inputFileName);
      $this->spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($this->inputFileName);
      $this->sheet1 = $this->spreadsheet->getSheet(0);
      $this->sheet2 = $this->spreadsheet->getSheet(1);
      $this->cell;



      #Form choices
      $this->EducationChoices = array(
         'High School',
         'Associate Degree',
         'Bachelor\'s Degree',
         'Master\'s Degree',
         'Doctoral Degree',
         'Professional Degree',
      );

      $this->IncomeChoices = array(
         #Answer key => Label
         'Php 10,000 Below' => 'Below Php 10,000',
         'Php 10,000 - Php 49,999' => 'Php 10,000 - Php 49,999',
         'Php 50,000 - Php 99,999' => 'Php 50,000 - Php 99,999',
         'Above Php 100,000' => 'Php 100,000 and above'
      );
   }
   public function test()
   {

      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet->setCellValue('A1', 'Hello World !');

      // $writer = new Xlsx($spreadsheet);
      // $writer->save('hello world.xlsx');

      #Download as pdf
      $writer = new \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf($spreadsheet);
      $writer->writeAllSheets();
      header('Content-Disposition: attachment;filename="Student_inquiry_' . $this->student_number . '.pdf"');
      header('Cache-Control: max-age=0');
      $writer->save('php://output'); // download file 



      #Download as xlsx
      // // $writer = new Xlsx($this->spreadsheet);
      // $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($this->spreadsheet, 'Mpdf');
      // header('Content-Type: application/vnd.ms-excel');
      // header('Content-Disposition: attachment;filename="teststes.xlsx"'); 
      // header('Cache-Control: max-age=0');

      // $writer->save('php://output'); // download file 

   }

   public function Export()
   {

      #spreadsheet data
      $this->SpreadsheetData();

      #spreadsheet header
      $this->SpreadsheetHeader();

      #spreadsheet styles
      $this->SpreadsheetDesign();

      #download / export spreadsheet
      $this->SpreadsheetWriter();
   }

   private function SpreadsheetDesign()
   {
      //$this->spreadsheet->getActiveSheet()->getSheetView()->setZoomScale(75);

      #PAGE 1
      #Application for admission desgin
      $this->set_banner_text($this->sheet1, 'APPLICATION FOR ADMISSION', 'B8');

      #Personal Information desgin
      $this->set_banner_text($this->sheet1, 'PERSONAL INFORMATION', 'B18');

      #Educational Background desgin
      $this->set_banner_text($this->sheet1, 'EDUCATIONAL BACKGROUND', 'B37');

      #Preferred Courses
      $this->set_banner_text($this->sheet1, 'PERSONAL INFORMATION', 'B55');

      #Preferred Course Design
      // $this->sheet1->getStyle('A55:H56')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('#cc0000');

      #Preferred Course Design
      // $this->sheet1->getStyle('A64:H64')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('#cc0000');

      $this->sheet1->getPageMargins()
         ->setLeft(0.1)
         ->setRight(0.1)
         ->setTop(0.1)
         ->setBottom(0.1)
         ->setHeader(0);



      // $this->sheet1->getStyle('A1:H1')
      //    ->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

      // $this->sheet1->getStyle('A72:H72')
      //    ->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

      // $this->sheet1->getStyle('A1:A72')
      //    ->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

      // $this->sheet1->getStyle('H1:H72')
      //    ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

      $this->sheet1->getPageSetup()->setFitToWidth(1);

      #PAGE 2

      #Family Information
      $this->set_banner_text($this->sheet2, 'FAMILY INFORMATION', 'B2');

      // #Application for admission desgin
      // $this->sheet2->getStyle('A8:H9')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('#cc0000');
      // $this->sheet2->getStyle('A8')
      //    ->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

      // #Personal Information desgin
      // $this->sheet2->getStyle('A18:H19')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('#cc0000');
      // $this->sheet2->getStyle('A18')
      //    ->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

      // #Educational Background desgin
      // $this->sheet2->getStyle('A37:H38')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('#cc0000');
      // $this->sheet2->getStyle('A37')
      //    ->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

      $this->sheet2->getPageMargins()
         ->setLeft(0.1)
         ->setRight(0.2)
         ->setTop(0.1)
         ->setBottom(0.1)
         ->setHeader(0);

      // $this->sheet2->getStyle('A1:L1')
      //    ->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

      // $this->sheet2->getStyle('A77:L77')
      //    ->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

      // $this->sheet2->getStyle('A1:A77')
      //    ->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

      // $this->sheet2->getStyle('L1:L77')
      //    ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

      $this->sheet2->getPageSetup()->setFitToWidth(1);
   }

   private function SpreadsheetHeader()
   {

      $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
      $drawing->setName('Paid');
      $drawing->setDescription('Paid');
      $drawing->setPath('img/StudentRecords/sdcalogo.png'); // put your path and image here
      $drawing->setCoordinates('B2');
      $drawing->setOffsetX(110);
      $drawing->setRotation(25);
      $drawing->getShadow()->setVisible(true);
      $drawing->getShadow()->setDirection(45);
      $drawing->setWidthAndHeight(400, 100);
      $drawing->setResizeProportional(true);
      $drawing->setWorksheet($this->sheet1);

      $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
      $drawing->setName('Paid');
      $drawing->setDescription('Paid');
      $drawing->setPath('img/StudentRecords/thumbnail.png'); // put your path and image here
      $drawing->setCoordinates('F4');
      $drawing->setOffsetX(1000);
      $drawing->setRotation(25);
      $drawing->getShadow()->setVisible(true);
      $drawing->getShadow()->setDirection(45);
      $drawing->setWidthAndHeight(115, 115);
      $drawing->setResizeProportional(true);
      $drawing->setWorksheet($this->sheet1);
   }

   private function SpreadsheetData()
   {

      #First Page Render
      $Exportdata = $this->DataLibrary(1);
      // $this->debugger($Exportdata);
      foreach ($Exportdata as $Inputname => $data) {
         // echo $Inputname.' = '.$data['Cell'].':'.$data['Value'];
         $this->sheet1->setCellValue($data['Cell'], $data['Value']);
      }

      #Second Page Render
      $Exportdata2 = $this->DataLibrary(2);
      // $this->debugger($Exportdata2);
      foreach ($Exportdata2 as $Inputname => $data) {
         // echo $Inputname.' = '.$data['Cell'].':'.$data['Value'];
         $this->sheet2->setCellValue($data['Cell'], $data['Value']);
      }
   }

   private function SpreadsheetWriter()
   {
      #Download as pdf
      $writer = new \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf($this->spreadsheet);
      $writer->writeAllSheets();
      header('Content-Disposition: attachment;filename="StudentInquiry_' . trim($this->first_name) . '-' . trim($this->last_name) . '.pdf"');
      header('Cache-Control: max-age=0');
      $writer->save('php://output'); // download file 


      #Download as xlsx
      // $writer = new Xlsx($this->spreadsheet);

      // header('Content-Type: application/vnd.ms-excel');
      // header('Content-Disposition: attachment;filename="teststes.xlsx"'); 
      // header('Cache-Control: max-age=0');

      // $writer->save('php://output'); // download file 

   }

   private function DataLibrary($page = '')
   {

      #page 1
      $data[1] = array(

         #AdmissionInfo
         'Semester' => $this->set('C14', $this->semester),
         'AppliedYear' => $this->set('F14', $this->school_year),
         'Type' => $this->set('C16', $this->transferee_name == 'N/A' || $this->transferee_name == null ? 'Freshmen' : 'Transferee'),

         #Name
         'LastName' => $this->set('C23' . $this->cell, $this->last_name),
         'FirstName' => $this->set('D23', $this->first_name),
         'MiddleName' => $this->set('E23', $this->middle_name),

         #Address
         'HouseNumber' => $this->set('C25', $this->address_no),
         'Street' => $this->set('D25', $this->address_street),
         'Subdivision' => $this->set('E25', $this->address_subdivision),
         'Barangay' => $this->set('F25', $this->address_barangay),
         'City' => $this->set('C27', $this->address_city),
         'Province=' => $this->set('E27', $this->address_province),

         #Birth date
         'Birthdate=' => $this->set('C29', $this->birth_date),
         'Birthplace' => $this->set('F29', $this->birth_place),

         #Other info
         'Gender' => $this->set('C31', $this->gender),
         'Citizenship' => $this->set('F31', $this->nationality),
         'TelephoneNumber' => $this->set('C33', $this->telephone),
         'CellPhone' => $this->set('F33', $this->cellphone),
         'Email' => $this->set('C35', $this->email),
         'CivilStatus' => $this->set('F35', $this->civilstatus),

         #Grade School / Elementary
         'GS-Name' => $this->set('C42', $this->bed_elementary_education ? $this->bed_elementary_education : $this->elementary_school_name),
         'GS-Address' => $this->set('C43', $this->elementary_school_address),
         'GS-GradYear' => $this->set('F42', $this->bed_elementary_graduated ? $this->bed_elementary_graduated : $this->elementary_school_grad),

         #Secondary
         'SD-Name' => $this->set('C47', $this->secondary_school_name),
         'SD-Address' => $this->set('C48', $this->secondary_school_address),
         'SD-GradYear' => $this->set('F47', $this->secondary_school_grad),

         #Seniorhigh
         'SH-Name' => $this->set('C52', $this->shs_school_name),
         'SH-Address' => $this->set('C53', $this->shs_school_address),
         'SH-GradYear' => $this->set('F52', $this->shs_school_grad),

         #Preferred Courses
         'Course1' => $this->set('C58', $this->course1),
         'Course2' => $this->set('C60', $this->course2),
         'Course3' => $this->set('C62', $this->course3),
         'Major1' => $this->set('F58', $this->major1),
         'Major2' => $this->set('F60', $this->major2),
         'Major3' => $this->set('F62', $this->major3),

         #Search Engine
         'SearchEngine' => $this->set('D66', $this->search_engine),

      );

      #page 2
      $data[2] = array(

         #Mother Information
         'ParentStatus' => $this->set('D5', $this->parent_status),

         'M-Name' => $this->set('C10', $this->mother_name),
         'M-Birthday' => $this->set('C12', $this->value),
         'M-Address' => $this->set('C14', $this->mother_address),
         'M-Occupation' => $this->set('C16', $this->mother_occupation),
         'M-Email' => $this->set('C18', $this->mother_email),
         'M-Deceased' => $this->set('E12', $this->value),
         'M-Contact' => $this->set('E16', $this->mother_contact),

         #UNDEFINED
         //'M-Education' => $this->set('A33', $this->mother_education),
         //'M-Income' => $this->set('C33', $this->mother_income),

         #Father Information
         'F-Name' => $this->set('I10', $this->father_name),
         'F-Birthday' => $this->set('I12', $this->value),
         'F-Address' => $this->set('I14', $this->father_address),
         'F-Occupation' => $this->set('I16', $this->father_occupation),
         'F-Email' => $this->set('I18', $this->father_email),
         'F-Deceased' => $this->set('K12', $this->value),
         'F-Contact' => $this->set('K16', $this->father_contact),

         #UNDEFINED
         // 'F-Education' => $this->set('E33', $this->father_education),
         // 'F-Income' => $this->set('G33', $this->father_income),

         #Guardian Information
         'G-Name' => $this->set('C37', $this->guardian_name),
         'G-Address' => $this->set('C39', $this->guardian_address),
         'G-Relationship' => $this->set('I37', $this->guardian_relationship),
         'G-Contact' => $this->set('I39', $this->guardian_contact),
         #UNDEFINED
         // 'G-Education' => $this->set('A44', $this->guardian_education),
         // 'G-Income' => $this->set('C44', $this->guardian_income),

         #4ps
         '4ps' => $this->set('K42', $this->dswd_number ? 'Yes' : 'No'),
         'DSWD_No' => $this->set('J44', $this->dswd_number ? $this->dswd_number : ''),
         'PhysicalConditions' => $this->set('J50', $this->dswd_number ? $this->physical_condition : ''),
         'MentalConditions' => $this->set('J51', $this->dswd_number ? $this->mental_condition : ''),

         #Relatives
         'RelativeStatus' => $this->set('J61', $this->relative_department),
         'RelativeName' => $this->set('C61', $this->relative),
         'RelativeDepartment' => $this->set('C63', $this->relative_department),
         'RelativeContact' => $this->set('J63', $this->value),

         #DATE
         // 'InquiryDate' => $this->set('C65', $this->value),

      );


      #Set education details
      $mother_education_cells = array('B22', 'B24', 'B26', 'B28', 'B30', 'B32');
      $data[2] = array_merge($data[2], $this->set_education_choice(
         $mother_education_cells,
         'Mother',
         $this->mother_education
      ));

      $father_education_cells = array('H22', 'H24', 'H26', 'H28', 'H30', 'H32');
      $data[2] = array_merge($data[2], $this->set_education_choice(
         $father_education_cells,
         'Father',
         $this->father_education
      ));

      $guardian_education_cells = array('B43', 'B45', 'B47', 'B49', 'B51', 'B53');
      $data[2] = array_merge($data[2], $this->set_education_choice(
         $guardian_education_cells,
         'Guardian',
         $this->guardian_education
      ));

      #Set income details
      $mother_income_cells = array('D22', 'D24', 'D26', 'D28');
      $data[2] = array_merge($data[2], $this->set_income_choice(
         $mother_income_cells,
         'Mother',
         $this->mother_income
      ));

      $father_income_cells = array('J22', 'J24', 'J26', 'J28');
      $data[2] = array_merge($data[2], $this->set_income_choice(
         $father_income_cells,
         'Father',
         $this->father_income
      ));

      $guardian_income_cells = array('D43', 'D45', 'D47', 'D49');
      $data[2] = array_merge($data[2], $this->set_income_choice(
         $guardian_income_cells,
         'Guardian',
         $this->guardian_income
      ));

      #Set income details


      // $this->debugger($data[2]);
      return $data[$page];
   }
   private function set_education_choice($cells, $prefix = '', $answer = '')
   {

      $choices = array();
      foreach ($this->EducationChoices as $index => $Education) {

         $check = '[ ]';
         if ($answer == $Education) {
            $check = '[✔]';
         }
         $choices[$prefix . ' ' . $Education] = $this->set($cells[$index], $check . ' ' . $Education);
      }
      // $this->debugger($choices);
      return $choices;
   }
   private function set_income_choice($cells, $prefix = '', $answer = '')
   {

      $choices = array();
      $cellindex = 0;
      foreach ($this->IncomeChoices as $index => $Income) {

         $check = '[ ]';
         if ($answer == $index) {
            $check = '[✔]';
         }
         $choices[$prefix . ' ' . $Income] = $this->set($cells[$cellindex], $check . ' ' . $Income);
         $cellindex++;
      }
      //$this->debugger($choices);
      return $choices;
   }
   private function set_banner_text($sheet, $text = 'Test', $cell = '')
   {

      $styleArray = array(
         'font'  => array(
            'bold'  => false,
            'color' => array('rgb' => 'FFF'),
            'size'  => 15,
            'name'  => 'Arial'
         )
      );

      $sheet->getCell($cell)->setValue($text);
      $sheet->getStyle($cell)->applyFromArray($styleArray);

      return $this;
   }
   private function set($cell = '', $value = '')
   {
      return array(
         'Cell' => $cell,
         'Value' => strtoupper($value  ?: 'N/A'),
      );
   }
   private function debugger($data)
   {
      header('Content-Type: application/json; charset=utf-8');
      die(json_encode($data, JSON_PRETTY_PRINT));
   }
}
