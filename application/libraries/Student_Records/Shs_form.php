<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\HeaderFooterDrawing;

//FOR TEST ONLY Remove it later
use PhpOffice\PhpSpreadsheet\Worksheet\IOFactory;
//require __DIR__ . '/../Header.php';


class Shs_form extends Student
{
    private $spreadsheet;
    private $sheet;
    private $cell_start;
    private $header_logo;
    private $footer_logo;
    private $array_grade_level_names;
    private $array_grade_level;
    private $CI;
    private $grade_passing_mark;
    private $array_division;
    protected $approved_by;
    protected $prepared_by;
    protected $verified_by;
    protected $released_by;
    private $max_row_page;
    private $page;
    private $date_string;
    protected $date_now;
    protected $elementary_school_name;
    protected $elementary_school_graduated;
    protected $elementary_school_gen_average;
    protected $secondary_school_name;
    protected $secondary_school_graduated;
    protected $secondary_school_gen_average;
    protected $shs_year_graduated;
    protected $admission_date;
    protected $form_remarks;
    protected $record_reference_no;
    protected $entrance_data;
    private $pages;
    private $no_pages;
    protected $graduation_status;

    public function __construct($parameters)
    {
        parent::__construct( $parameters );

        $this->CI =& get_instance();

        $this->CI->load->model('AcademicRecords_Model/Student_Model');
        $this->CI->load->model('AcademicRecords_Model/Grades_Model');
        $this->CI->load->model('AcademicRecords_Model/Subjects_Model');
        
        $this->spreadsheet = new Spreadsheet();
        $this->format();
        $this->sheet = $this->spreadsheet->getActiveSheet();
        $this->cell_start = 1;

        $this->array_grade_level_names = array('Grade 11', 'Grade 12');
        $this->array_grade_level = array('G11', 'G12');

        $this->grade_passing_mark = 75;

        $this->max_row_page = 83;
        $this->page = 1;

        $this->date_string = "%F %d, %Y";
        $this->date_now = mdate($this->date_string, time());

        $this->set_division();

        $this->pages = array();
        $this->no_pages = 0;

        
    }

    public function set_approved_by($approved_by)
    {
        $this->approved_by = $approved_by;
        return $this;
    }

    private function set_division()
    {
        $this->array_division = $this->CI->Subjects_Model->get_shs_division();
        return $this;
    }

    public function set_elementary_school_info($elementary_school_name, $elementary_school_graduated, $elementary_school_gen_average)
    {
        $this->elementary_school_name = $elementary_school_name;
        $this->elementary_school_graduated = $elementary_school_graduated;
        $this->elementary_school_gen_average = $elementary_school_gen_average;
        return $this;
    }

    public function set_secondary_school_info($secondary_school_name, $secondary_school_graduated, $secondary_school_gen_average)
    {
        $this->secondary_school_name = $secondary_school_name;
        $this->secondary_school_graduated = $secondary_school_graduated;
        $this->secondary_school_gen_average = $secondary_school_gen_average;
        return $this;
    }

    public function set_shs_year_graduated($shs_year_graduated)
    {
        if (strtotime($shs_year_graduated) === false) {
            # code...
            $this->shs_year_graduated = $shs_year_graduated;
        }
        else {
            # code...
            $this->shs_year_graduated = mdate($this->date_string, strtotime($shs_year_graduated));
        }
        
        return $this;
    }

    public function set_form_remarks($form_remarks)
    {
        $this->form_remarks = $form_remarks;
        return $this;
    }

    public function set_prepared_by($prepared_by)
    {
        $this->prepared_by = $prepared_by;
        return $this;
    }

    public function set_verified_by($verified_by)
    {
        $this->verified_by = $verified_by;
        return $this;
    }

    public function set_released_by($released_by)
    {
        $this->released_by = $released_by;
        return $this;
    }

    public function set_record_reference_no($record_reference_no)
    {
        $this->record_reference_no = $record_reference_no;
        return $this;
    }

    public function set_entrance_data($array_entrance_data)
    {
        $output = "";
        foreach ($array_entrance_data as $key => $value) {
            # code...
            $output .= $value.', ';
        }
        $output = substr($output, 0, -2);
        $this->entrance_data = $output;
        return $this;
    }

    public function set_admission_date($admission_date)
    {
        $this->admission_date = $admission_date;
        $this->admission_date = mdate($this->date_string, strtotime($this->admission_date));
        return $this;
    }

    public function set_graduation_status($graduation_status)
    {
        $this->graduation_status = $graduation_status;
        return $this;
    }

    private function set_subjects()
    {
        $output = array();
        #get student enrolled grades levels
        $array_student_enrolled_levels = $this->CI->Student_Model->get_student_enrolled_levels($this->reference_number);
        $division_col = array_column($this->array_division, 'id');

        foreach ($this->array_grade_level as $grade_level_key => $grade_level) {
            # code...
            //$array_subject_grades = array();

            if ($this->in_array_r($grade_level, $array_student_enrolled_levels, 'GradeLevel')) {
                # code...
                #get key of array_student_enrolled_levels
                $student_enrolled_levels_key = array_search($grade_level, array_column($array_student_enrolled_levels, 'GradeLevel'));

                #get grade level subject list and position
                $array_subjects_list = $this->CI->Subjects_Model->get_shs_subject_arrangement($grade_level, $array_student_enrolled_levels[$student_enrolled_levels_key]['SchoolYear']);

                foreach ($array_subjects_list as $key => $subject) {
                    # code...

                     
                    $array_data = array(
                        'subject_id' => $subject['subjects_id'],
                        'reference_no' => $this->reference_number,
                        'school_year' =>  $array_student_enrolled_levels[$student_enrolled_levels_key]['SchoolYear']
                    );

                    $array_grades = $this->CI->Grades_Model->get_basiced_subject_grade($array_data);

                    #check if the student enrolled the subject
                    if ($array_grades) {
                        # code...
                        $grading_quarter = array_column($array_grades,'Quarter');
                        $first_quarter_key = array_search('FIRST', $grading_quarter);
                        $second_quarter_key = array_search('SECOND', $grading_quarter);

                        $final_grade = $this->get_grade_average($array_grades);

                        $remark = $this->grade_pass_fail($final_grade);

                        $division_key = array_search($subject['division_id'], $division_col);


                        $output[] = array(
                            'subject_title' => $subject['subject_title'],
                            'first' => round($array_grades[$first_quarter_key]['finGrade']),
                            'second' => round($array_grades[$second_quarter_key]['finGrade']),
                            'final' => $final_grade,
                            'remark' => $remark,
                            'parent_subject_id' => $subject['parent_subject_id'],
                            'school_year' => $array_data['school_year'],
                            'grade_level_name' => $this->array_grade_level_names[$grade_level_key],
                            'semester' => $subject['semester'],
                            'division' => $this->array_division[$division_key]['subject_name']
                        );
                        
                        
                    }

                   

                    
                }
            }
            //$output[] = $array_subject_grades;
            
        }//end of foreach
        
        return $output;
       
    }

    private function in_array_r($needle, $haystack, $column, $strict = false) 
    {
        foreach ($haystack as $item) {
            if (($strict ? $item[$column] === $needle : $item[$column] == $needle) || (is_array($item) && $this->in_array_r($needle, $item, $column, $strict ))) {
                return true;
            }
        }
    
        return false;
    }

    private function get_grade_average($array_grades)
    {
        $total_sum = 0;
        foreach ($array_grades as $key => $grades) {
            # code...
            $total_sum += round($grades['finGrade']);
        }

        $average = round($total_sum / 2);
        return number_format($average, 2);
    }

    private function grade_pass_fail($final_grade)
    {
        if ($final_grade >= $this->grade_passing_mark) {
            # code...
            $output = "Promoted";
        }
        else {
            # code...
            $output = "Retain";
        }

        return $output;
    }

    private function format()
    {
        #column width .71 more than the excel format
        $this->spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(18.71);
        $this->spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(9.14);
        $this->spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(9.14);
        $this->spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(9.14);
        $this->spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(9.14);
        $this->spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(7.28515625);
        $this->spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(7);
        $this->spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(7.28515625);
        $this->spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(7.14);
        $this->spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(12.5703125);

        $this->spreadsheet->getActiveSheet()->getPageMargins()->setTop(0.25);
        $this->spreadsheet->getActiveSheet()->getPageMargins()->setRight(0.45);
        $this->spreadsheet->getActiveSheet()->getPageMargins()->setLeft(0.45);
        $this->spreadsheet->getActiveSheet()->getPageMargins()->setBottom(.25);
        $this->spreadsheet->getActiveSheet()->getPageMargins()->setHeader(.3);
        $this->spreadsheet->getActiveSheet()->getPageMargins()->setFooter(.3);

        #row height
        $this->spreadsheet->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
        
        

        #font
        $this->spreadsheet->getDefaultStyle()->getFont()->setName('Arial');
        $this->spreadsheet->getDefaultStyle()->getFont()->setSize(11);
        $this->spreadsheet->getActiveSheet()->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_LEGAL);
        $this->spreadsheet->getActiveSheet()->getPageSetup()->setFitToPage(FALSE);
        $this->spreadsheet->getActiveSheet()->getPageSetup()->setScale(92);



    }

    private function body_format($body_row_count, $current_row_count, array $array_table_row_subheading, array $array_table_row_subject_type, $body_school_name_row_count)
    {
        #font size
        $this->sheet->getStyle('A'.$body_row_count.':'.'J'.$current_row_count)->getFont()->setSize(8);
        //$this->sheet->getStyle('A'.$body_row_count.':'.'J'.$current_row_count)->getFont()->setName('Arial');

        #align
        $this->sheet->getStyle('A'.$body_row_count.':'.'A'.$current_row_count)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $this->sheet->getStyle('A'.$body_row_count.':'.'A'.$current_row_count)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_BOTTOM);
        $this->sheet->getStyle('G'.$body_row_count.':'.'J'.$current_row_count)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $this->sheet->getStyle('G'.$body_row_count.':'.'J'.$current_row_count)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        
        #cell format
        $this->sheet->getStyle('G'.$body_row_count.':'.'J'.$current_row_count)->getNumberFormat()->setFormatCode('###0.00');

        #border
        $this->sheet->getStyle('A'.$body_row_count.':'.'A'.$current_row_count)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $this->sheet->getStyle('G'.$body_row_count.':'.'G'.$current_row_count)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $this->sheet->getStyle('H'.$body_row_count.':'.'H'.$current_row_count)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $this->sheet->getStyle('I'.$body_row_count.':'.'I'.$current_row_count)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $this->sheet->getStyle('J'.$body_row_count.':'.'J'.$current_row_count)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $this->sheet->getStyle('J'.$body_row_count.':'.'J'.$current_row_count)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $this->sheet->getStyle('A'.$body_row_count.':'.'J'.$current_row_count)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        for ($i = $body_row_count; $i <= $current_row_count; $i++) 
        { 
            # code...
            $this->sheet->getRowDimension($i)->setRowHeight(10.5);
        }

        foreach ($array_table_row_subheading as $key => $row) {
            # code...
            $this->sheet->getStyle('A'.$row.':'.'J'.$row)->getFont()->setSize(9);
            $this->sheet->getStyle('A'.$row.':'.'A'.($row + 1))->getFont()->setBold(true);
            $this->sheet->getStyle('A'.$row.':'.'A'.($row + 1))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $this->sheet->getStyle('A'.$row)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_BOTTOM);
            $this->sheet->getStyle('A'.($row + 1))->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        }

        foreach ($array_table_row_subject_type as $key => $row) {
            # code...
            $this->sheet->getStyle('A'.$row)->getFont()->setBold(true);
        }

        if ($body_school_name_row_count != "") {
            # code...
            $this->sheet->getRowDimension($body_school_name_row_count)->setRowHeight(15);
            $this->sheet->getStyle('A'.$body_school_name_row_count)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $this->sheet->getStyle('A'.$body_school_name_row_count)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_BOTTOM);
        }

        
    }

    private function header_format(array $cell_space, $cell_start)
    {
        #row height
        $this->spreadsheet->getActiveSheet()->getRowDimension($cell_start -2)->setRowHeight(6);
        $this->spreadsheet->getActiveSheet()->getRowDimension($cell_start - 1)->setRowHeight(12);
        $this->spreadsheet->getActiveSheet()->getRowDimension($cell_start)->setRowHeight(12);
        foreach ($cell_space as $key => $cell) {
            # code...
            $this->sheet->getRowDimension($cell)->setRowHeight(2.25);
        }

        #align
        $this->sheet->getStyle('A'.$cell_start.':'.'A'.($cell_start + 5))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $this->sheet->getStyle('A'.$cell_start.':'.'A'.($cell_start + 2))->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_BOTTOM);
        $this->sheet->getStyle('A'.($cell_start + 4).':'.'A'.($cell_start + 5))->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $this->sheet->getStyle('A'.($cell_start + 8).':'.'J'.($cell_start + 9))->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_BOTTOM);
        $this->sheet->getStyle('B'.($cell_start + 9))->getAlignment()->setWrapText(true);

        #font size
        $this->sheet->getStyle('A'.$cell_start.':'.'A'.($cell_start + 2))->getFont()->setSize(8);
        $this->sheet->getStyle('A'.($cell_start + 4))->getFont()->setSize(11);
        $this->sheet->getStyle('A'.($cell_start + 5))->getFont()->setSize(16);
        $this->sheet->getStyle('A'.($cell_start + 7))->getFont()->setSize(10);
        $this->sheet->getStyle('A'.($cell_start + 8).':'.'J'.($cell_start + 9))->getFont()->setSize(9);
        $this->sheet->getStyle('B'.($cell_start + 9).':'.'F'.($cell_start + 9))->getFont()->setSize(8);

        #font style
        $this->sheet->getStyle('A'.($cell_start + 4).':'.'A'.($cell_start + 5))->getFont()->setBold(true);
        $this->sheet->getStyle('A'.($cell_start + 7))->getFont()->setBold(true);
        $this->sheet->getStyle('A'.($cell_start + 7))->getFont()->setUnderline(true);

        #border
        $this->sheet->getStyle('B'.($cell_start + 8).':'.'F'.($cell_start + 8))->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $this->sheet->getStyle('J'.($cell_start + 8))->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $this->sheet->getStyle('I'.($cell_start + 9).':'.'J'.($cell_start + 9))->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $this->sheet->getStyle('B'.($cell_start + 9).':'.'F'.($cell_start + 9))->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        
        
    
        
    }

    private function body_header_format(array $cell_space, $cell_start)
    {
        foreach ($cell_space as $key => $cell) {
            # code...
            $this->sheet->getRowDimension($cell)->setRowHeight(2.25);
        }

        #lrn format
        $this->sheet->getStyle('H'.($cell_start + 6))->getNumberFormat()->setFormatCode('###');

        #align
        $this->sheet->getStyle('G'.($cell_start + 6))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $this->sheet->getStyle('H'.($cell_start + 6))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        

        #font size
        $this->sheet->getStyle('A'.($cell_start).':'.'J'.($cell_start + 7))->getFont()->setSize(9);
        $this->sheet->getStyle('I'.($cell_start + 1).':'.'I'.($cell_start + 2))->getFont()->setSize(9);
        $this->sheet->getStyle('A'.($cell_start + 7))->getFont()->setSize(10);

        #border
        $this->sheet->getStyle('B'.($cell_start + 1).':'.'E'.($cell_start + 1))->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $this->sheet->getStyle('H'.($cell_start + 1))->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $this->sheet->getStyle('J'.($cell_start + 1))->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $this->sheet->getStyle('B'.($cell_start + 2).':'.'E'.($cell_start + 2))->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $this->sheet->getStyle('H'.($cell_start + 2))->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $this->sheet->getStyle('J'.($cell_start + 2))->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $this->sheet->getStyle('B'.($cell_start + 4).':'.'J'.($cell_start + 4))->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $this->sheet->getStyle('B'.($cell_start + 5).':'.'J'.($cell_start + 5))->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $this->sheet->getStyle('B'.($cell_start + 6).':'.'F'.($cell_start + 6))->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $this->sheet->getStyle('H'.($cell_start + 6).':'.'J'.($cell_start + 6))->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $this->sheet->getStyle('B'.($cell_start + 7).':'.'J'.($cell_start + 7))->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);


    }  

    private function table_head_format($cell_start)
    {
        #align
        $this->sheet->getStyle('A'.$cell_start.':'.'J'.($cell_start + 1))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $this->sheet->getStyle('A'.$cell_start.':'.'J'.($cell_start + 1))->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $this->sheet->getStyle('J'.$cell_start)->getAlignment()->setWrapText(true);

        #font style
        $this->sheet->getStyle('A'.$cell_start.':'.'J'.($cell_start + 1))->getFont()->setBold(true);

        #font size
        $this->sheet->getStyle('A'.$cell_start.':'.'J'.$cell_start)->getFont()->setSize(10);
        $this->sheet->getStyle('G'.($cell_start + 1).':'.'I'.($cell_start + 1))->getFont()->setSize(9);

        #border
        $this->sheet->getStyle('A'.$cell_start.':'.'J'.($cell_start + 1))->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    }

    private function footer_format($cell_start)
    {
        #align
        $this->sheet->getStyle('A'.$cell_start.':'.'J'.$cell_start)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_BOTTOM);
        $this->sheet->getStyle('A'.$cell_start.':'.'J'.$cell_start)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $this->sheet->getStyle('C'.($cell_start + 2))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $this->sheet->getStyle('C'.($cell_start + 3).':'.'E'.($cell_start + 3))->getAlignment()->setWrapText(true);
        $this->sheet->getStyle('C'.($cell_start + 3).':'.'E'.($cell_start + 3))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $this->sheet->getStyle('C'.($cell_start + 3).':'.'E'.($cell_start + 3))->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
        $this->sheet->getStyle('H'.($cell_start + 3).':'.'H'.($cell_start + 4))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $this->sheet->getStyle('G'.($cell_start + 8).':'.'G'.($cell_start + 9))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $this->sheet->getStyle('E'.($cell_start + 10))->getAlignment()->setWrapText(true);
        $this->sheet->getStyle('E'.($cell_start + 10))->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
        $this->sheet->getStyle('A'.($cell_start + 12).':'.'B'.($cell_start + 12))->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        #font size
        $this->sheet->getStyle('A'.$cell_start)->getFont()->setSize(8);
        $this->sheet->getStyle('C'.($cell_start + 2))->getFont()->setSize(6.5);
        $this->sheet->getStyle('G'.($cell_start + 2))->getFont()->setSize(8);
        $this->sheet->getStyle('C'.($cell_start + 3).':'.'E'.($cell_start + 3))->getFont()->setSize(6.5);
        $this->sheet->getStyle('G'.($cell_start + 2).':'.'J'.($cell_start + 4))->getFont()->setSize(8);
        $this->sheet->getStyle('G'.($cell_start + 5))->getFont()->setSize(7.5);
        $this->sheet->getStyle('H'.($cell_start + 5))->getFont()->setSize(8);
        $this->sheet->getStyle('G'.($cell_start + 6))->getFont()->setSize(8);
        $this->sheet->getStyle('C'.($cell_start + 7))->getFont()->setSize(7.5);
        $this->sheet->getStyle('D'.($cell_start + 7))->getFont()->setSize(6);
        $this->sheet->getStyle('E'.($cell_start + 7))->getFont()->setSize(7.5);
        $this->sheet->getStyle('F'.($cell_start + 7))->getFont()->setSize(7);
        $this->sheet->getStyle('C'.($cell_start + 8))->getFont()->setSize(7.5);
        $this->sheet->getStyle('D'.($cell_start + 8))->getFont()->setSize(7);
        $this->sheet->getStyle('E'.($cell_start + 8))->getFont()->setSize(7.5);
        $this->sheet->getStyle('F'.($cell_start + 8))->getFont()->setSize(7);
        $this->sheet->getStyle('G'.($cell_start + 8))->getFont()->setSize(8);
        $this->sheet->getStyle('G'.($cell_start + 9))->getFont()->setSize(8);
        $this->sheet->getStyle('C'.($cell_start + 10))->getFont()->setSize(8);
        $this->sheet->getStyle('E'.($cell_start + 10))->getFont()->setSize(7.5);
        $this->sheet->getStyle('A'.($cell_start + 12).':'.'B'.($cell_start + 12))->getFont()->setSize(7);

        #font style
        $this->sheet->getStyle('A'.$cell_start)->getFont()->setItalic(true);
        $this->sheet->getStyle('C'.($cell_start + 2))->getFont()->setBold(true);
        $this->sheet->getStyle('H'.($cell_start + 3))->getFont()->setBold(true);
        $this->sheet->getStyle('D'.($cell_start + 7))->getFont()->setBold(true);
        $this->sheet->getStyle('G'.($cell_start + 8))->getFont()->setBold(true);
        $this->sheet->getStyle('C'.($cell_start + 10))->getFont()->setBold(true);

        #row height
        for ($i = $cell_start; $i <= 13; $i++) 
        { 
            # code...
            $this->sheet->getRowDimension($i)->setRowHeight(12);
        }
        $this->sheet->getRowDimension($cell_start + 1)->setRowHeight(2.25);
        $this->sheet->getRowDimension($cell_start + 5)->setRowHeight(15);
        $this->sheet->getRowDimension($cell_start + 6)->setRowHeight(15);
        $this->sheet->getRowDimension($cell_start + 7)->setRowHeight(17.25);
        $this->sheet->getRowDimension($cell_start + 8)->setRowHeight(9.75);
        $this->sheet->getRowDimension($cell_start + 9)->setRowHeight(12.75);
        $this->sheet->getRowDimension($cell_start + 10)->setRowHeight(15);
        $this->sheet->getRowDimension($cell_start + 12)->setRowHeight(15.75);

        #border
        $this->sheet->getStyle('A'.$cell_start.':'.'J'.$cell_start)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $this->sheet->getStyle('C'.($cell_start + 2).':'.'J'.($cell_start + 2))->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $this->sheet->getStyle('C'.($cell_start + 2).':'.'C'.($cell_start + 9))->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $this->sheet->getStyle('F'.($cell_start + 2).':'.'F'.($cell_start + 9))->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $this->sheet->getStyle('J'.($cell_start + 2).':'.'J'.($cell_start + 9))->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $this->sheet->getStyle('G'.($cell_start + 5).':'.'J'.($cell_start + 5))->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $this->sheet->getStyle('C'.($cell_start + 6).':'.'F'.($cell_start + 6))->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $this->sheet->getStyle('C'.($cell_start + 7).':'.'F'.($cell_start + 7))->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $this->sheet->getStyle('C'.($cell_start + 9).':'.'J'.($cell_start + 9))->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        return $this;
    }

    private function end_tag_format($cell_start)
    {
        #align
        $this->sheet->getStyle('A'.$cell_start.':'.'J'.$cell_start)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_BOTTOM);
        $this->sheet->getStyle('A'.$cell_start.':'.'J'.$cell_start)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        #font style
        $this->sheet->getStyle('A'.$cell_start)->getFont()->setItalic(true);

        #border
        $this->sheet->getStyle('A'.$cell_start.':'.'J'.$cell_start)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        return $this;
    }

    private function admission_message_format($cell_start)
    {
        #font size
        $this->sheet->getStyle('A'.$cell_start)->getFont()->setSize(9);

        #align
        $this->sheet->getStyle('A'.$cell_start)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_BOTTOM);
        $this->sheet->getStyle('A'.$cell_start)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $this->sheet->getStyle('A'.$cell_start)->getAlignment()->setWrapText(true);

        #font style
        $this->sheet->getStyle('A'.$cell_start)->getFont()->setItalic(true);
        $this->sheet->getStyle('A'.$cell_start)->getFont()->setBold(true);

        #border
        $this->sheet->getStyle('A'.$cell_start.':'.'J'.($cell_start + 3))->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        return $this;

    }

    private function images()
    {
        #insert watermark
        #header image
        $header_image = new HeaderFooterDrawing();
        $header_image->setName('PhpSpreadsheet_logo');
        $header_image->setPath('./img/StudentRecords/sdca_watermark_logo.png');
        $this->sheet->getHeaderFooter()->addImage($header_image, \PhpOffice\PhpSpreadsheet\Worksheet\HeaderFooter::IMAGE_HEADER_CENTER);

        #adding line break for header
        $header_break_line ="\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n";
        $this->sheet->getHeaderFooter()->setOddHeader($header_break_line."&G");
    }

    private function get_admission_message()
    {
        if ($this->gender == 'Male') {
            # code...
            $honorifics = "Mr.";
        }
        else {
            # code...
            $honorifics = "Ms.";
        }
        $track_title = ucwords(strtolower($this->track_title));
        $strand_title = ucwords(strtolower($this->strand_title));


        $output = $honorifics.' '.ucwords(strtolower($this->first_name.' '.$this->middle_name.' '.$this->last_name)).' has satisfactorily completed the requirements for graduation in Senior High School. She graduated Grade 12 Senior High School with an '.$track_title.' Strand '.$strand_title.' ('.$this->strand.') on '.$this->shs_year_graduated.'. She is eligible for admission to College.';
        return $output;
    }

    private function table_head()
    {
        $cell_start = $this->cell_start;

        $this->sheet->mergeCells('A'.$this->cell_start.':'.'F'.($this->cell_start + 1));
        $this->sheet->setCellValue('A'.$this->cell_start, 'DESCRIPTIVE TITLE OF SUBJECTS');
        $this->sheet->mergeCells('G'.$this->cell_start.':'.'I'.$this->cell_start);
        $this->sheet->setCellValue('G'.$this->cell_start, 'SEMESTRAL GRADE');
        $this->sheet->mergeCells('J'.$this->cell_start.':'.'J'.($this->cell_start + 1));
        $this->sheet->setCellValue('J'.$this->cell_start, 'ACTION TAKEN');

        $this->cell_start++;
        $this->sheet->setCellValue('G'.$this->cell_start, 'FIRST');
        $this->sheet->setCellValue('H'.$this->cell_start, 'SECOND');
        $this->sheet->setCellValue('I'.$this->cell_start, 'FINAL');

        $this->table_head_format($cell_start);
    }

    private function header()
    {
        $array_cell_space = array();
        $header_cell_start = 0;
        $header_logo = $this->cell_start;
        $drawing = new Drawing();
        $drawing->setName('Logo1');
        $drawing->setDescription('Logo1');
        $drawing->setPath('./img/StudentRecords/shs_logo.png');
        $drawing->setCoordinates('D'.$header_logo);
        $drawing->setWorksheet($this->spreadsheet->getActiveSheet());
        $this->pages[] = $this->cell_start;
        $this->no_pages++;

        $this->cell_start += 4;
        $this->sheet->mergeCells('A'.$this->cell_start.':'.'J'.$this->cell_start);
        
        $this->cell_start++;
        $header_cell_start = $this->cell_start;
        $this->sheet->mergeCells('A'.$this->cell_start.':'.'J'.$this->cell_start);
        $this->sheet->setCellValue('A'.$this->cell_start, 'St. Dominic Complex E. Aguinaldo Highway, Talaba, Bacoor, Cavite, Philippines 4102');
        
        $this->cell_start++;
        $this->sheet->mergeCells('A'.$this->cell_start.':'.'J'.$this->cell_start);
        $this->sheet->setCellValue('A'.$this->cell_start, 'Tel. Nos. +63 (46) 417-7322; 416-4498');
        
        $this->cell_start++;
        $this->sheet->mergeCells('A'.$this->cell_start.':'.'J'.$this->cell_start);
        $this->sheet->setCellValue('A'.$this->cell_start, 'www.stdominiccollege.edu.ph');

        $this->cell_start++;
        $array_cell_space[] = $this->cell_start;

        $this->cell_start++;
        $this->sheet->mergeCells('A'.$this->cell_start.':'.'J'.$this->cell_start);
        $this->sheet->setCellValue('A'.$this->cell_start, 'OFFICE OF THE REGISTRAR');

        $this->cell_start++;
        $this->sheet->mergeCells('A'.$this->cell_start.':'.'J'.$this->cell_start);
        $this->sheet->setCellValue('A'.$this->cell_start, 'SENIOR HIGH SCHOOL STUDENT\'S PERMANENT RECORD');

        $this->cell_start += 2;
        $this->sheet->setCellValue('A'.$this->cell_start, 'STUDENT  INFORMATION');

        $this->cell_start++;
        $this->sheet->setCellValue('A'.$this->cell_start, 'NAME');
        $this->sheet->mergeCells('B'.$this->cell_start.':'.'F'.$this->cell_start);
        $this->sheet->setCellValue('B'.$this->cell_start, $this->full_name);//Name
        $this->sheet->mergeCells('G'.$this->cell_start.':'.'I'.$this->cell_start);
        $this->sheet->setCellValue('G'.$this->cell_start, 'DATE OF ADMISSION');
        $this->sheet->setCellValue('J'.$this->cell_start, $this->admission_date);//Date

        $this->cell_start++;
        $this->sheet->setCellValue('A'.$this->cell_start, 'ADDRESS');
        $this->sheet->mergeCells('B'.$this->cell_start.':'.'F'.$this->cell_start);
        $this->sheet->setCellValue('B'.$this->cell_start, $this->address);//address
        $this->sheet->mergeCells('G'.$this->cell_start.':'.'H'.$this->cell_start);
        $this->sheet->setCellValue('G'.$this->cell_start, 'DATE  OF  BIRTH');
        $this->sheet->mergeCells('I'.$this->cell_start.':'.'J'.$this->cell_start);
        $this->sheet->setCellValue('I'.$this->cell_start, mdate($this->date_string, strtotime($this->birth_date)));//date of birth
        $this->cell_start++;
        $array_cell_space[] = $this->cell_start;
        $this->header_format($array_cell_space, $header_cell_start);
        return $this;
    }

    private function body()
    {
        $body_header_cell_start = 0;
        $array_cell_space = array();

        $this->header();

        $this->cell_start++;
        $body_header_cell_start = $this->cell_start;
        $this->sheet->mergeCells('A'.$this->cell_start.':'.'B'.$this->cell_start);
        $this->sheet->setCellValue('A'.$this->cell_start, 'PRELIMINARY  EDUCATION');

        $this->cell_start++;
        $this->sheet->setCellValue('A'.$this->cell_start, '    ELEMENTARY');
        $this->sheet->mergeCells('B'.$this->cell_start.':'.'E'.$this->cell_start);
        $this->sheet->setCellValue('B'.$this->cell_start, $this->elementary_school_name);//elementary
        $this->sheet->mergeCells('F'.$this->cell_start.':'.'G'.$this->cell_start);
        $this->sheet->setCellValue('F'.$this->cell_start, 'General  Average');
        $this->sheet->setCellValue('H'.$this->cell_start, $this->elementary_school_gen_average);//gen average
        $this->sheet->setCellValue('I'.$this->cell_start, 'YEAR');
        $this->sheet->setCellValue('J'.$this->cell_start, $this->elementary_school_graduated);//year

        $this->cell_start++;
        $this->sheet->setCellValue('A'.$this->cell_start, '    SECONDARY');
        $this->sheet->mergeCells('B'.$this->cell_start.':'.'E'.$this->cell_start);
        $this->sheet->setCellValue('B'.$this->cell_start, $this->secondary_school_name);//secondary
        $this->sheet->mergeCells('F'.$this->cell_start.':'.'G'.$this->cell_start);
        $this->sheet->setCellValue('F'.$this->cell_start, 'General  Average');
        $this->sheet->setCellValue('H'.$this->cell_start, $this->secondary_school_gen_average);//gen average
        $this->sheet->setCellValue('I'.$this->cell_start, 'YEAR');
        $this->sheet->setCellValue('J'.$this->cell_start, $this->secondary_school_graduated);//year
        
        $this->cell_start++;
        $array_cell_space[] = $this->cell_start;

        $this->cell_start++;
        $this->sheet->setCellValue('A'.$this->cell_start, 'ENTRANCE  DATA');
        $this->sheet->mergeCells('B'.$this->cell_start.':'.'J'.$this->cell_start);
        $this->sheet->setCellValue('B'.$this->cell_start, $this->entrance_data);//entrance data

        $this->cell_start++;
        $strand_title = $this->strand." (".$this->strand_title.")";
        $this->sheet->setCellValue('A'.$this->cell_start, 'ACADEMIC STRAND');
        $this->sheet->mergeCells('B'.$this->cell_start.':'.'J'.$this->cell_start);
        $this->sheet->setCellValue('B'.$this->cell_start, $strand_title);//strand

        $this->cell_start++;
        $this->sheet->setCellValue('A'.$this->cell_start, 'YEAR GRADUATED');
        $this->sheet->mergeCells('B'.$this->cell_start.':'.'F'.$this->cell_start);
        $this->sheet->setCellValue('B'.$this->cell_start, $this->shs_year_graduated);//year graduated
        $this->sheet->setCellValue('G'.$this->cell_start, 'LRN');
        $this->sheet->mergeCells('H'.$this->cell_start.':'.'J'.$this->cell_start);
        $this->sheet->setCellValue('H'.$this->cell_start, $this->lrn);//LRN
        $this->cell_start++;
        $this->sheet->setCellValue('A'.$this->cell_start, 'Remarks:');
        $this->sheet->mergeCells('B'.$this->cell_start.':'.'G'.$this->cell_start);
        $this->sheet->setCellValue('B'.$this->cell_start, $this->form_remarks);//Remarks
        
        $this->cell_start++;
        $array_cell_space[] = $this->cell_start;
        $this->body_header_format($array_cell_space, $body_header_cell_start);

        $this->cell_start++;

        $this->table_head();

        #set var
        $grade_level_name ="";
        $semester ="";
        $school_year="";
        $division ="";
        $body_row_count = $this->cell_start +1;
        $body_school_name_row_count ="";

        $array_subjects = $this->set_subjects();
        $array_table_row_subheading = array();
        $array_table_row_subject_type = array();
        
        $this->cell_start++;
        $this->sheet->mergeCells('A'.$this->cell_start.':'.'F'.$this->cell_start);
        $this->sheet->setCellValue('A'.$this->cell_start, 'ST. DOMINIC COLLEGE OF ASIA SENIOR HIGH SCHOOL');
        $array_table_row_subheading[] = $this->cell_start;
        $body_school_name_row_count = $this->cell_start;


        
        

        foreach ($array_subjects as $subject_key => $subject) {
            # code...
            $this->cell_start++;
            
            if ($subject['semester'] != $semester) {
                # code...
                $semester = $subject['semester'];
                $division ="";

                $array_table_row_subheading[] = $this->cell_start;

                if ($subject['school_year'] != $school_year) {
                    # code...
                    $school_year = $subject['school_year'];
                }

                if ($subject['grade_level_name'] != $grade_level_name ) {
                    # code...
                    $grade_level_name = $subject['grade_level_name'];
                }

                $this->sheet->mergeCells('A'.$this->cell_start.':'.'F'.$this->cell_start);
                $this->sheet->setCellValue('A'.$this->cell_start, strtoupper($semester).' Semester     S.Y. '.$school_year);
                
                $this->cell_start++;
                $this->sheet->mergeCells('A'.$this->cell_start.':'.'F'.$this->cell_start);
                $this->sheet->setCellValue('A'.$this->cell_start, strtoupper($grade_level_name));
                $this->cell_start++;
            }
            if ($subject['division'] != $division) {
                # code...
                $division = $subject['division'];

                $array_table_row_subject_type[] = $this->cell_start;
                
                $this->sheet->mergeCells('A'.$this->cell_start.':'.'F'.$this->cell_start);
                $this->sheet->setCellValue('A'.$this->cell_start, strtoupper($division).' SUBJECTS');
                $this->cell_start++;
            }

            $this->sheet->mergeCells('A'.$this->cell_start.':'.'F'.$this->cell_start);
            $this->sheet->setCellValue('A'.$this->cell_start, $subject['subject_title']);
            $this->sheet->setCellValue('G'.$this->cell_start, number_format($subject['first'], 2));
            $this->sheet->setCellValue('H'.$this->cell_start, number_format($subject['second'], 2));
            $this->sheet->setCellValue('I'.$this->cell_start, number_format($subject['final'], 2));
            $this->sheet->setCellValue('J'.$this->cell_start, $subject['remark']);

            #check row for next page command
            if ($this->cell_start >= ($this->max_row_page * $this->page)) {
                # code...

                #setup format for body subjects 
                $this->body_format($body_row_count, $this->cell_start, $array_table_row_subheading, $array_table_row_subject_type, $body_school_name_row_count);
                $this->footer('Turn to Next Page');
                $this->cell_start++;
                $this->header();
                $this->cell_start++;
                $this->table_head();
                $this->page++;
                $body_row_count = $this->cell_start + 1;
                $body_school_name_row_count ="";
                $array_table_row_subheading = array();
                $array_table_row_subject_type = array();
                

            }

            
        }//end of main foreach

        if ($this->graduation_status === 1) {
            # code...
            $end_tag_cell_space = 5;
        }
        else {
            # code...
            $end_tag_cell_space = 1;
        }

        #add end tag of "nothing follows"
        if (($this->cell_start + $end_tag_cell_space) >= ($this->max_row_page * $this->page)) {
            # code...
            $this->body_format($body_row_count, $this->cell_start, $array_table_row_subheading, $array_table_row_subject_type, $body_school_name_row_count);
            $this->footer('Turn to Next Page');
            $this->cell_start++;
            $this->header();
            $this->cell_start++;
            $this->table_head();
            $this->page++;
            $body_row_count = $this->cell_start + 1;
        }
        $this->cell_start++;
        $this->sheet->mergeCells('A'.$this->cell_start.':'.'J'.$this->cell_start);
        $this->sheet->setCellValue('A'.$this->cell_start, 'sdca - sdca - sdca - sdca - sdca - sdca - sdca - sdca - sdca - sdca - Nothing Follows - sdca - sdca - sdca - sdca - sdca - sdca - sdca - sdca - sdca - sdca');
        $this->end_tag_format($this->cell_start);

        if ($this->graduation_status === 1) {
            # code...
            $this->cell_start++;
            $this->sheet->mergeCells('A'.$this->cell_start.':'.'J'.($this->cell_start + 3));
            $this->sheet->setCellValue('A'.$this->cell_start, $this->get_admission_message());
            $admission_message_cell_start = $this->cell_start;
            

        }

        #condition if the form have multiple pages
        if ($this->page > 1) {
            # code...
            $this->cell_start = (($this->max_row_page * $this->page) + 14);
        }
        else {
            # code...
            $this->cell_start = $this->max_row_page * $this->page;
        }

        #setup format for body subjects 
        $this->body_format($body_row_count, $this->cell_start, $array_table_row_subheading, $array_table_row_subject_type, $body_school_name_row_count);

        if ($this->graduation_status === 1) {
            # code...
            $this->admission_message_format($admission_message_cell_start);
        }

        $this->footer('End of Transcipt');
        

        return $this;
    }

    private function footer($end_tag)
    {
        $this->cell_start++;
        $footer_cell_start = $this->cell_start;
        $this->sheet->mergeCells('A'.$this->cell_start.':'.'J'.$this->cell_start);
        $this->sheet->setCellValue('A'.$this->cell_start, 'sdca - sdca - sdca - sdca - sdca - sdca - sdca - sdca - sdca - sdca - '.$end_tag.' - sdca - sdca - sdca - sdca - sdca - sdca - sdca - sdca - sdca - sdca');
        
        $this->cell_start+=2;
        $this->sheet->mergeCells('A'.$this->cell_start.':'.'B'.$this->cell_start);
        $this->footer_logo = $this->cell_start;
        $this->sheet->mergeCells('C'.$this->cell_start.':'.'F'.$this->cell_start);
        $this->sheet->setCellValue('C'.$this->cell_start, 'LEVEL OF PROFICIENCY');
        $this->sheet->mergeCells('G'.$this->cell_start.':'.'J'.$this->cell_start);
        $this->sheet->setCellValue('G'.$this->cell_start, 'Prepared by:');

        $first_profeciency = "A - Advanced\r\nP - Proficient\r\nAP - Approaching Proficiency\r\nD - Developing\r\nB - Beginning";
        $second_profeciency = "90 % and above\r\n85 - 89 %\r\n80 - 84 %\r\n75 - 79 %\r\n74 % and below";
        $this->cell_start++;
        $this->sheet->mergeCells('C'.$this->cell_start.':'.'D'.($this->cell_start + 3));
        $this->sheet->setCellValue('C'.$this->cell_start, $first_profeciency);//profeciency 1
        $this->sheet->mergeCells('E'.$this->cell_start.':'.'F'.($this->cell_start + 3));
        $this->sheet->setCellValue('E'.$this->cell_start, $second_profeciency);//profeciency 2
        $this->sheet->mergeCells('H'.$this->cell_start.':'.'J'.$this->cell_start);
        $this->sheet->setCellValue('H'.$this->cell_start, $this->prepared_by);//Prepared by

        $this->cell_start++;
        $this->sheet->mergeCells('H'.$this->cell_start.':'.'J'.$this->cell_start);
        $this->sheet->setCellValue('H'.$this->cell_start, 'Records Evaluator');

        $this->cell_start++;
        $this->sheet->setCellValue('G'.$this->cell_start, 'Date:');//Prepared by
        $this->sheet->mergeCells('H'.$this->cell_start.':'.'J'.$this->cell_start);
        $this->sheet->setCellValue('H'.$this->cell_start, $this->date_now);//date now

        $this->cell_start++;
        $this->sheet->mergeCells('G'.$this->cell_start.':'.'J'.$this->cell_start);
        $this->sheet->setCellValue('G'.$this->cell_start, 'Approved by:');

        $this->cell_start++;
        $this->sheet->setCellValue('C'.$this->cell_start, 'Verified by:');
        $this->sheet->setCellValue('D'.$this->cell_start, $this->verified_by);//verified by
        $this->sheet->setCellValue('E'.$this->cell_start, 'Date:');

        $this->cell_start++;
        $this->sheet->setCellValue('C'.$this->cell_start, 'Released by:');
        $this->sheet->setCellValue('D'.$this->cell_start, $this->released_by);//released by
        $this->sheet->setCellValue('E'.$this->cell_start, 'Date:');
        $this->sheet->mergeCells('G'.$this->cell_start.':'.'J'.$this->cell_start);
        $this->sheet->setCellValue('G'.$this->cell_start, $this->approved_by);

        $this->cell_start++;
        $this->sheet->mergeCells('G'.$this->cell_start.':'.'J'.$this->cell_start);
        $this->sheet->setCellValue('G'.$this->cell_start, 'Registrar');

        $this->cell_start++;
        $this->sheet->mergeCells('C'.$this->cell_start.':'.'D'.$this->cell_start);
        $this->sheet->setCellValue('C'.$this->cell_start, 'IMPORTANT NOTICE');
        $this->sheet->mergeCells('E'.$this->cell_start.':'.'J'.($this->cell_start + 2));
        $this->sheet->setCellValue('E'.$this->cell_start, 'This copy is an exact reproduction of the transcript of file with the Office of the Registrar and is considered an original copy when it bears the dry seal of the College and the original signature in ink of the registrar. Any erasure or alteration made on this copy renders the  whole transcript invalid.');

        $this->cell_start+=2;
        $this->sheet->setCellValue('A'.$this->cell_start, mdate("%d-%M-%y", time()));//date now
        $this->sheet->mergeCells('B'.$this->cell_start.':'.'C'.$this->cell_start);
        $this->sheet->setCellValue('B'.$this->cell_start, $this->record_reference_no);//reference

        $drawing = new Drawing();
        $drawing->setName('Logo4');
        $drawing->setDescription('Logo4');
        $drawing->setPath('./img/StudentRecords/shs_footer_logo.png');
        $drawing->setCoordinates('A'.$this->footer_logo);
        $drawing->setOffsetX(35);
        $drawing->setOffsetY(10);
        $drawing->setWorksheet($this->spreadsheet->getActiveSheet());

        $this->footer_format($footer_cell_start);
    }

    private function set_page()
    {
        $page_no = 0;
        foreach ($this->pages as $key => $cell_no) {
            # code...
            $page_no++;
            $this->sheet->mergeCells('I'.$cell_no.':'.'J'.$cell_no);
            $this->sheet->setCellValue('I'.$cell_no, 'Page '.$page_no.'of '.$this->no_pages);
            
            #font size
            $this->sheet->getStyle('I'.$cell_no)->getFont()->setSize(8);

            #align
            $this->sheet->getStyle('I'.$cell_no.':'.'J'.$cell_no)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_BOTTOM);
            $this->sheet->getStyle('I'.$cell_no.':'.'J'.$cell_no)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        }
        
    }

    public function export()
    {
        //$this->set_subjects();
        //$this->format();
        //$this->header();
        $this->body();
        $this->set_page();
        //$this->footer();
        $this->images();
        
        
        $writer = new Xlsx($this->spreadsheet);
 
        $filename = $this->full_name;
 
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output'); // download file 
        
    }

    public function reader()
    {
        $inputFileType = 'Xlsx';
        $inputFileName = './img/sample/1.xlsx';

        

       

        /**  Create a new Reader of the type defined in $inputFileType  **/
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
        /**  Load $inputFileName to a Spreadsheet Object  **/
        $spreadsheet = $reader->load($inputFileName);

        $worksheet = $spreadsheet->getActiveSheet();
        
        
        //echo $worksheet->getColumnDimension('A')->getWidth();

        #get page margin

        echo"Top ".$worksheet->getPageMargins()->getTop();
        echo "<br>";
        echo"right ".$worksheet->getPageMargins()->getRight();
        echo "<br>";
        echo"left ".$worksheet->getPageMargins()->getLeft();
        echo "<br>";
        echo"bottom ".$worksheet->getPageMargins()->getBottom();
        echo "<br>";
        echo"header ".$worksheet->getPageMargins()->getHeader();
        echo "<br>";
        echo"footer ".$worksheet->getPageMargins()->getFooter();
        echo "<br>";
        echo"default row height ".$worksheet->getDefaultRowDimension()->getRowHeight();
        echo "<br>";
        

        echo '<table>' . PHP_EOL;
        foreach ($worksheet->getRowIterator() as $key => $row) {
            echo '<tr>' . PHP_EOL;
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(FALSE); // This loops through all cells,
                                                            //    even if a cell value is not set.
                                                            // By default, only cells that have a value
                                                            //    set will be iterated.
            echo '<td>' .
            $key .
            '</td>' . PHP_EOL;

            echo '<td>' .
            $worksheet->getRowDimension($key)->getRowHeight() .
            '</td>' . PHP_EOL;
            foreach ($cellIterator as $cell) {
                echo '<td>' .
                    $cell->getValue() ."(size:". $cell->getStyle()->getFont()->getSize().")"." (cell format:". $cell->getStyle()->getNumberFormat()->getFormatCode().")".
                    '</td>' . PHP_EOL;
            }
            echo '</tr>' . PHP_EOL;
        }
        echo '</table>' . PHP_EOL;

        echo "<br>fin";
    }
}