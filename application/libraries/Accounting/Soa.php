<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Exports data to SOA form
 *
 * 
 *
 * @param array $parameters Array containing the necessary params.
 *   $parameters = [
 *     'student_info'   =>  (array) first row of student data.
 *     'student_type'   =>  (string) type of student: HED, SHS, BED.
 *     'enrolled_fees'  =>  (array) data of enrolled fees of the student(discount, fullpayment, InitialPayment, First_Pay, Second_Pay, Third_Pay)
 *     'scholarship_discount' => (decimal) sum of column Scholarship_Discount in table fees_enrolled_college_item
 *     'total_paid' => (decimal) sum of column AmountofPayment in table enrolledstudent_payments
 *     'array_advising_term' => (array) list of current term information(School year, Term, and Semester)
 *     'array_official_receipt => (array) list of official receipts
 *     'array_remaining_balance => (array) list of remaining balance
 *     'due_date' => (string) due date
 *  ]
 */

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\HeaderFooterDrawing;
use PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf;
use TNkemdilim\MoneyToWords\Converter;
use TNkemdilim\MoneyToWords\Languages as Language;
use PhpOffice\PhpSpreadsheet\RichText\RichText;

//FOR TEST ONLY Remove it later
use PhpOffice\PhpSpreadsheet\Worksheet\IOFactory;
//require __DIR__ . '/../Header.php';


class Soa extends Student
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
    private $approved_by;
    private $prepared_by;
    private $verified_by;
    private $released_by;
    private $max_row_page;
    private $page;
    private $date_string;
    protected $date_now;
    private $admission_date;
    private $form_remarks;
    private $record_reference_no;
    private $entrance_data;
    private $pages;
    private $no_pages;
    private $graduation_status;
    protected $image_path;
    protected $student_type;

    protected $current_school_year;
    protected $current_semester;
    protected $current_term;

    protected $payment_plan;
    protected $array_enrolled_fees;
    protected $total_assessment;
    protected $scholarship_discount;
    protected $total_discount;
    protected $total_paid;
    protected $assessment_balance;
    protected $other_semester_balance_list;
    protected $other_semester_balance_total;
    protected $other_fees_balance_list;
    protected $other_fees_balance_total;
    protected $other_fees_balance_dollar_total;
    protected $total_amount_due;
    protected $term_due;
    protected $official_receipt_list;

    protected $info_course_grade_level;
    protected $info_school_year_semester;
    protected $info_balance;

    protected $due_date;

    public function __construct($parameters)
    {
        parent::__construct( $parameters );
        $this->CI =& get_instance();
        $this->CI->load->model('Global_Model/Global_Fees_Model');

        $this->array_enrolled_fees = $parameters['enrolled_fees'];
        $this->scholarship_discount = $parameters['scholarship_discount'];
        $this->total_paid = $parameters['total_paid'];
        $this->official_receipt_list = $this->set_official_receipt_list($parameters['array_official_receipt']);
        $this->set_advising_term($parameters['array_advising_term']);
        $this->set_payment_plan();
        $this->set_total_assessment();
        $this->set_total_discount();
        $this->set_information_names($parameters['student_type']);
        $this->student_type = $parameters['student_type'];
        $this->other_semester_balance_list =array();
        $this->set_other_semester_balance($parameters['array_remaining_balance']);
        $this->other_fees_balance_list = array();
        $this->set_other_balance();
        $this->set_assessment_balance();
        $this->set_total_amount_due();
        $this->set_due_date($parameters['due_date']);
        
        $this->spreadsheet = new Spreadsheet();
        $this->format();
        $this->sheet = $this->spreadsheet->getActiveSheet();
        $this->cell_start = 1;

        $this->max_row_page = 83;
        $this->page = 1;

        $this->date_string = "%F %d, %Y";
        $this->date_now = mdate($this->date_string, time());

        $this->pages = array();
        $this->no_pages = 0;

        $this->image_path = "img/StudentRecords/";

        
    }
    
    /*
    public function set_enrolled_fees_data($array_enrolled_fees)
    {
        $this->array_enrolled_fees = $array_enrolled_fees;

        return $this;
    }

    
    public function set_scholarship_discount($discount)
    {
        $this->scholarship_discount = $discount;
        return $this;
    }
    */
    protected function set_official_receipt_list($array_official_receipt)
    {
        $output = "";
        foreach ($array_official_receipt as $key => $value) {
            # code...
            $output .= $value['OR_Number'].", ";
        }
        $output = rtrim($output,", ");
        return $output;
    }

    protected function set_advising_term($array_advising_term)
    {
        $this->current_school_year = $array_advising_term['School_Year'];
        $this->current_semester = $array_advising_term['Semester'];
        $this->current_term = $array_advising_term['Term'];

        return $this;
    }
    
    protected function set_information_names($student_type)
    {
        if ($student_type === 'HED') {
            # code...
            $rich_text = new RichText();
            $bold_text = $rich_text->createTextRun('Course: ');
            $rich_text->createText($this->program_code);
            $bold_text->getFont()->setBold(true);
            $bold_text->getFont()->setSize(8);
            $this->info_course_grade_level = $rich_text;
            $this->info_school_year_semester = $this->array_enrolled_fees['semester'].':'.$this->array_enrolled_fees['schoolyear'];
            $this->info_balance = "Other Semester Balance:";
        }
        else {
            $this->info_course_grade_level = "Grade Level:";
            $this->info_school_year_semester = 'S.Y.'.$this->array_enrolled_fees['schoolyear'];
            $this->info_balance = "Previous Balance:";
        }

        return $this;
         
    }

    protected function set_payment_plan()
    {
        if ($this->array_enrolled_fees['fullpayment'] === 1) {
            # code...
            $this->payment_plan = "FULL PAYMENT";
        }
        else {
            $this->payment_plan = "INSTALLMENT";
        }
    }
    
    protected function set_total_assessment()
    {
        $this->total_assessment = $this->array_enrolled_fees['InitialPayment'] + $this->array_enrolled_fees['First_Pay'] + $this->array_enrolled_fees['Second_Pay'] + $this->array_enrolled_fees['Third_Pay'];
        return $this;  
    }

    protected function set_total_discount()
    {
        $this->total_discount = $this->scholarship_discount + $this->array_enrolled_fees['discount'];
    }

    protected function set_assessment_balance()
    {
        $this->assessment_balance = $this->total_assessment - $this->total_discount;
        $this->assessment_balance -= $this->total_paid; 
        return $this;
    }

    protected function set_total_amount_due()
    {
        $total_paid = $this->total_paid;
        $term_due = 0;
        $array_balance = array(
            'INITIAL'   =>  $this->array_enrolled_fees['InitialPayment'],
            'PRELIM'    =>  $this->array_enrolled_fees['First_Pay'],
            'MIDTERM'   =>  $this->array_enrolled_fees['Second_Pay'],
            'FINALS'    =>  $this->array_enrolled_fees['Third_Pay'],
        );
        foreach ($array_balance as $key => $value) {
            # code...
            if ($total_paid >= $value) {
                # code...
                $total_paid = $total_paid - $value;
            }
            elseif (($value > $total_paid) && ($total_paid > 0) ) {
                # code...
                $term_due = $term_due + ($value - $total_paid);
                $total_paid = 0;
            }
            else {
                $term_due += $value;
            }

            if ($key === $this->current_term) {
                # code...
                break;
            }
        }
        $this->term_due = $term_due;
        
        $this->total_amount_due = $this->other_semester_balance_total + $this->other_fees_balance_total + $this->term_due;//
        return $this;
    }

    protected function set_other_balance()
    {
        $total_balance = 0;
        $total_dollar_balance = 0;
        #set student level
        if ($this->student_type === "HED") {
            # code...
            $school_level = "HigherED";
        }
        else{
            $school_level = "BasicED";
        }
        #list of other fees
        $array_other_fees = $this->CI->Global_Fees_Model->get_student_other_fees($this->student_number, $school_level);

        foreach ($array_other_fees as $key => $fees) {
            # code...
            $fee_total_balance = $fees['itemAmount'];
            $fee_payment = $this->CI->Global_Fees_Model->get_student_other_fees_payments($this->student_number, $fees['itemPaid'], $school_level);
            $fee_total_balance = $fee_total_balance - $fee_payment;
            if ($fee_total_balance > 0) {
                # code...
                $this->other_fees_balance_list[] = array(
                    'item_paid' => $fees['itemPaid'],
                    'balance' => $fee_total_balance
                );
                if ($fees['currency'] === "P") {
                    # code...
                    $total_balance += $fee_total_balance; 
                }
                else {
                    # code...
                    $total_dollar_balance += $fee_total_balance; 
                }
                    
            }
        }

        #list of business center fees
        $array_bus_ctr_fees = $this->CI->Global_Fees_Model->get_student_bus_ctr_fees($this->reference_number, $school_level);

        foreach ($array_bus_ctr_fees as $key => $fees) {
            # code...
            $fee_total_balance = $fees['itemAmount'];
            $fee_payment = $this->CI->Global_Fees_Model->get_student_bus_ctr_fees_payments($this->student_number, $fees['itemPaid'], $school_level);
            $fee_total_balance = $fee_total_balance - $fee_payment;
            if ($fee_total_balance > 0) {
                # code...
                $this->other_fees_balance_list[] = array(
                    'item_paid' => $fees['itemPaid'],
                    'balance' => $fee_total_balance
                );
                if ($fees['currency'] === "P") {
                    # code...
                    $total_balance += $fee_total_balance; 
                }
                else {
                    # code...
                    $total_dollar_balance += $fee_total_balance; 
                }
            }
        }

        $this->other_fees_balance_total = $total_balance;
        $this->other_fees_balance_dollar_total = $total_dollar_balance;

        return $this;
    }

    protected function set_other_semester_balance($array_remaining_balance)
    {
        $total_balance = 0;
        foreach ($array_remaining_balance as $key => $value) {
            # code...
            if ($value['BALANCE'] > 0) {
                # code...
                $this->other_semester_balance_list[] = array(
                    'semester' => $value['semester'],
                    'school_year' => $value['schoolyear'],
                    'balance' => $value['BALANCE']
                );
                $total_balance += $value['BALANCE'];
            }
        }
        $end_array = end($this->other_semester_balance_list);
        if ($end_array['semester'] === $this->current_semester && $end_array['school_year'] === $this->current_school_year) {
            # code...
            $total_balance -= $end_array['balance'];
            array_pop($this->other_semester_balance_list);
        }

        $this->other_semester_balance_total = $total_balance;
        return $this;
    }

    protected function set_due_date($due_date_string)
    {
        $this->due_date = mdate("%l, %F %d", strtotime($due_date_string));
        return $this;
    }

    public function test()
    {
        echo $this->other_semester_balance_total;
        echo '<br>';
        echo $this->other_fees_balance_total;
        echo '<br>';
        echo $this->term_due;
        echo '<br>';
        echo $this->assessment_balance;
        echo '<br>';
        echo $this->total_amount_due;
    }

    private function format()
    {
        #column width .71 more than the excel format
        $this->spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(20);
        $this->spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $this->spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(17.72);
        $this->spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(11);
        $this->spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(.71);
        $this->spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(17);
        $this->spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(16.29);
        $this->spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(10);
        $this->spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(10);
        $this->spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(10);

        $this->spreadsheet->getActiveSheet()->getPageMargins()->setTop(0.1);
        $this->spreadsheet->getActiveSheet()->getPageMargins()->setRight(0.1);
        $this->spreadsheet->getActiveSheet()->getPageMargins()->setLeft(0.1);
        $this->spreadsheet->getActiveSheet()->getPageMargins()->setBottom(0.75);
        $this->spreadsheet->getActiveSheet()->getPageMargins()->setHeader(0.2);
        $this->spreadsheet->getActiveSheet()->getPageMargins()->setFooter(0.3);
        //$this->spreadsheet->getActiveSheet()->getPageSetup()->setFitToPage(TRUE);

        #row height
        //$this->spreadsheet->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);

        #font
        $this->spreadsheet->getDefaultStyle()->getFont()->setName('Arial');
        $this->spreadsheet->getDefaultStyle()->getFont()->setSize(8);
    }

    private function body_format($body_row_count, $current_row_count, array $array_table_row_subheading, array $array_table_row_subject_type, $body_school_name_row_count)
    {
        
    }

    private function header_format(array $cell_space, $cell_start)
    {
        #align
        $this->sheet->getStyle('A'.($cell_start - 5))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $this->sheet->getStyle('A'.$cell_start)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $this->sheet->getStyle('A'.($cell_start + 1).':'.'F'.($cell_start + 4))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $this->sheet->getStyle('A'.($cell_start + 5).':'.'F'.($cell_start + 6))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        #font size
        $this->sheet->getStyle('A'.$cell_start.':'.'F'.($cell_start + 3))->getFont()->setSize(8);
        $this->sheet->getStyle('A'.($cell_start + 4))->getFont()->setSize(8);
        $this->sheet->getStyle('A'.($cell_start + 5).':'.'F'.($cell_start + 6))->getFont()->setSize(8);
        $this->sheet->getStyle('G'.($cell_start + 6))->getFont()->setSize(8);

        #font style
        $this->sheet->getStyle('A'.$cell_start)->getFont()->setBold(true);
        $this->sheet->getStyle('F'.($cell_start + 3))->getFont()->setBold(true);

        #border
        $this->sheet->getStyle('A'.($cell_start + 5))->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
        $this->sheet->getStyle('F'.($cell_start + 5))->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
        $this->sheet->getStyle('A'.($cell_start + 6))->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
        $this->sheet->getStyle('F'.($cell_start + 6))->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);

        #cell space
        foreach ($cell_space as $key => $cell) {
            # code...
            $this->sheet->getRowDimension($cell)->setRowHeight(2.25);
        }

        return $this;
    }

    private function balance_table_display_format($cell_start, $array_other_balance_cell, $other_student_balance_cell)
    {
        #align
        $this->sheet->getStyle('A'.$cell_start.':'.'A'.($cell_start + 4))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $this->sheet->getStyle('A'.($cell_start + 5))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $this->sheet->getStyle('A'.($cell_start + 6).':'.'A'.($cell_start + 7))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $this->sheet->getStyle('A'.($cell_start + 17))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $this->sheet->getStyle('B'.$cell_start.':'.'B'.($cell_start + 4))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $this->sheet->getStyle('C'.$cell_start.':'.'C'.($cell_start + 4))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $this->sheet->getStyle('D'.($cell_start + 1).':'.'D'.($cell_start + 4))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $this->sheet->getStyle('F'.$cell_start)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $this->sheet->getStyle('F'.($cell_start + 1).':'.'F'.($cell_start + 4))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $this->sheet->getStyle('F'.($cell_start + 6).':'.'F'.($cell_start + 7))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $this->sheet->getStyle('F'.($cell_start + 17))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $this->sheet->getStyle('F'.$other_student_balance_cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        foreach ($array_other_balance_cell as $key => $cell) {
            # code...
            $this->sheet->getStyle('D'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        }

        #font size
        $this->sheet->getStyle('A'.$cell_start.':'.'F'.($cell_start + 5))->getFont()->setSize(9);
        $this->sheet->getStyle('A'.($cell_start + 6).':'.'F'.($cell_start + 17))->getFont()->setSize(9);
        //$this->sheet->getStyle('F'.$cell_start)->getFont()->setSize(8);
        
        #font style
        $this->sheet->getStyle('A'.($cell_start + 6).':'.'A'.($cell_start + 7))->getFont()->setBold(true);
        $this->sheet->getStyle('F'.($cell_start + 1).':'.'F'.($cell_start + 4))->getFont()->setBold(true);
        $this->sheet->getStyle('F'.($cell_start + 6))->getFont()->setBold(true);
        $this->sheet->getStyle('A'.$other_student_balance_cell)->getFont()->setBold(true);
        $this->sheet->getStyle('F'.$other_student_balance_cell)->getFont()->setBold(true);
        $this->sheet->getStyle('F'.($cell_start + 17))->getFont()->setBold(true);

        #border
        $this->sheet->getStyle('A'.$cell_start.':'.'F'.$cell_start)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
        $this->sheet->getStyle('A'.($cell_start + 5).':'.'F'.($cell_start + 5))->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
        $this->sheet->getStyle('A'.$cell_start.':'.'A'.($cell_start + 5))->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
        //$this->sheet->getStyle('B'.$cell_start.':'.'B'.($cell_start + 5))->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
        $this->sheet->getStyle('B'.$cell_start)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
        $this->sheet->getStyle('C'.$cell_start.':'.'C'.($cell_start + 5))->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
        $this->sheet->getStyle('C'.$cell_start.':'.'D'.$cell_start)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
        $this->sheet->getStyle('F'.$cell_start)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
        $this->sheet->getStyle('F'.$cell_start.':'.'F'.($cell_start + 5))->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
        $this->sheet->getStyle('A'.($cell_start + 5))->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
        $this->sheet->getStyle('F'.($cell_start + 6))->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
        $this->sheet->getStyle('F'.$other_student_balance_cell)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
        $this->sheet->getStyle('A'.($cell_start + 17).':'.'F'.($cell_start + 17))->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
        $this->sheet->getStyle('A'.($cell_start + 17).':'.'F'.($cell_start + 17))->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
        $this->sheet->getStyle('A'.($cell_start + 17))->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
        $this->sheet->getStyle('F'.($cell_start + 17))->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);

        foreach ($array_other_balance_cell as $key => $cell) {
            # code...
            $this->sheet->getStyle('D'.$cell)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_HAIR);
        }

        //$this->sheet->getStyle('D'.$cell_start.':'.'D'.($cell_start + 5))->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        return $this;
    }

    private function payment_option_display_format($cell_start)
    {
        #font size
        $this->sheet->getStyle('G'.$cell_start.':'.'H'.($cell_start + 8))->getFont()->setSize(8);
        $this->sheet->getStyle('G'.($cell_start + 10))->getFont()->setSize(9);
        $this->sheet->getStyle('G'.($cell_start + 11).':'.'H'.($cell_start + 17))->getFont()->setSize(8);

        #font style
        $this->sheet->getStyle('G'.$cell_start.':'.'G'.($cell_start + 1))->getFont()->setBold(true);
        $this->sheet->getStyle('G'.($cell_start + 10).':'.'G'.($cell_start + 11))->getFont()->setBold(true);

        return $this;
    }

    

    private function footer_format($cell_start)
    {
        #align
        $this->sheet->getStyle('G'.$cell_start.':'.'G'.($cell_start + 1))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        #font size
        $this->sheet->getStyle('G'.$cell_start.':'.'G'.($cell_start + 1))->getFont()->setSize(9);

        #font style
        $this->sheet->getStyle('G'.($cell_start + 1))->getFont()->setBold(true);

        #border
        $this->sheet->getStyle('G'.$cell_start.':'.'J'.$cell_start)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
    }


    private function images()
    {
        
    }


    private function header()
    {
        $array_cell_space = array();
        $header_cell_start = 0;
        $header_logo = $this->cell_start;
        $this->sheet->mergeCells('A'.$this->cell_start.':'.'J'.$this->cell_start);
        $drawing = new Drawing();
        $drawing->setName('Logo1');
        $drawing->setDescription('Logo1');
        $drawing->setPath('img/Accounting/logo_sdca.png');
        $drawing->setCoordinates('A'.$header_logo);
        $drawing->setWorksheet($this->spreadsheet->getActiveSheet());

        $this->cell_start += 5;
        $header_cell_start = $this->cell_start;
        $this->sheet->mergeCells('A'.$this->cell_start.':'.'H'.$this->cell_start);
        $this->sheet->setCellValue('A'.$this->cell_start, 'STATEMENT OF ACCOUNT');

       
        $this->cell_start++;
        #add richtext
        $rich_text = new RichText();
        $bold_text = $rich_text->createTextRun('Student Number: ');
        $rich_text->createText($this->student_number);
        $bold_text->getFont()->setBold(true);
        $bold_text->getFont()->setSize(8);
        $this->sheet->mergeCells('A'.$this->cell_start.':'.'B'.$this->cell_start);
        $this->sheet->setCellValue('A'.$this->cell_start, $rich_text);
        #add richtext
        $rich_text = new RichText();
        $bold_text = $rich_text->createTextRun('Date: ');
        $rich_text->createText($this->date_now);
        $bold_text->getFont()->setBold(true);
        $bold_text->getFont()->setSize(8);
        $this->sheet->mergeCells('F'.$this->cell_start.':'.'G'.$this->cell_start);
        $this->sheet->setCellValue('F'.$this->cell_start, $rich_text);

        $this->cell_start++;
        #add richtext
        $rich_text = new RichText();
        $bold_text = $rich_text->createTextRun('Name: ');
        $rich_text->createText($this->full_name);
        $bold_text->getFont()->setBold(true);
        $bold_text->getFont()->setSize(8);
        $this->sheet->mergeCells('A'.$this->cell_start.':'.'B'.$this->cell_start);
        $this->sheet->setCellValue('A'.$this->cell_start, $rich_text);
        #add richtext
        $rich_text = new RichText();
        $bold_text = $rich_text->createTextRun('Payment Plan: ');
        $rich_text->createText($this->payment_plan);
        $bold_text->getFont()->setBold(true);
        $bold_text->getFont()->setSize(8);
        $this->sheet->mergeCells('F'.$this->cell_start.':'.'H'.$this->cell_start);
        $this->sheet->setCellValue('F'.$this->cell_start, $rich_text);

        $this->cell_start++;
        $this->sheet->mergeCells('A'.$this->cell_start.':'.'B'.$this->cell_start);
        $this->sheet->setCellValue('A'.$this->cell_start, $this->info_course_grade_level);
        $this->sheet->mergeCells('F'.$this->cell_start.':'.'G'.$this->cell_start);
        $this->sheet->setCellValue('F'.$this->cell_start, $this->info_school_year_semester);

        $this->cell_start++;
        #add richtext
        $rich_text = new RichText();
        $rich_text->createText('This is to remind your monthly/quarterly payment is due on or ');
        $underline_text = $rich_text->createTextRun($this->due_date);
        $rich_text->createText('in the amount of');
        $underline_text->getFont()->setUnderline(true);
        $underline_text->getFont()->setSize(8);
        $this->sheet->mergeCells('F'.$this->cell_start.':'.'H'.$this->cell_start);
        $this->sheet->setCellValue('F'.$this->cell_start, $rich_text);
        $this->sheet->mergeCells('A'.$this->cell_start.':'.'H'.$this->cell_start);
        $this->sheet->setCellValue('A'.$this->cell_start, $rich_text);

        $this->cell_start++;
        $this->sheet->mergeCells('A'.$this->cell_start.':'.'D'.$this->cell_start);
        $converter = new Converter("pesos", "cents");
        $total_amount_due_word = $converter->convert($this->total_amount_due);
        $this->sheet->setCellValue('A'.$this->cell_start, $total_amount_due_word);//set total balance to words
        $this->sheet->setCellValue('F'.$this->cell_start, number_format($this->total_amount_due, 2));//set total balance

        $this->cell_start++;
        $this->sheet->mergeCells('A'.$this->cell_start.':'.'D'.$this->cell_start);
        $converter = new Converter("dollar", "cents");
        if ($this->other_fees_balance_dollar_total > 0) {
            # code...
            $total_dollar_amount_due_word = $converter->convert($this->other_fees_balance_dollar_total);
        }
        else {
            # code...
            $total_dollar_amount_due_word = "Zero";
        }
        $this->sheet->setCellValue('A'.$this->cell_start, $total_dollar_amount_due_word);//set current balance to words 
        $this->sheet->setCellValue('F'.$this->cell_start, "$".number_format($this->other_fees_balance_dollar_total, 2));//set current balance
        $this->sheet->mergeCells('G'.$this->cell_start.':'.'H'.$this->cell_start);
        $this->sheet->setCellValue('G'.$this->cell_start, "Broken Down as follows:");

        $array_cell_space[] = ($this->cell_start + 1);
        $this->header_format($array_cell_space, $header_cell_start);
        $this->cell_start += 2;





    }

    private function body()
    {
        $body_cell_start = $this->cell_start;
        $balance_table_display_cell_start = $this->cell_start;
        $payment_option_display_cell_start = $this->cell_start;
        
        $this->balance_table_display($balance_table_display_cell_start);
        $this->payment_option_display($payment_option_display_cell_start);

        $this->cell_start++;
        $this->sheet->mergeCells('A'.$this->cell_start.':'.'H'.$this->cell_start);
        $this->sheet->setCellValue('A'.$this->cell_start, "Kindly settle your account at the cashier. Present this statement when making payment. Please disregard if payment has been made.");

        $this->cell_start+=2;
        $footer_cell_start = $this->cell_start;
        $this->sheet->mergeCells('G'.$this->cell_start.':'.'J'.$this->cell_start);
        $this->sheet->setCellValue('G'.$this->cell_start,"Lorille J. Leones");//change later
        
        $this->cell_start++;
        $this->sheet->mergeCells('G'.$this->cell_start.':'.'J'.$this->cell_start);
        $this->sheet->setCellValue('G'.$this->cell_start,"Accounting Officer");
        $this->footer_format($footer_cell_start);


    }

    private function balance_table_display($cell_start)
    {
        $format_cell_start = $cell_start;
        $this->sheet->setCellValue('A'.$cell_start, "Total Assessment");
        $this->sheet->setCellValue('B'.$cell_start, number_format($this->total_assessment, 2));
        $this->sheet->mergeCells('C'.$cell_start.':'.'D'.$cell_start);
        $this->sheet->setCellValue('C'.$cell_start, "PAYMENT SCHEME");
        $this->sheet->setCellValue('F'.$cell_start, "Due for ".$this->current_term);
        
        $cell_start++;
        $term_due_cell_start = $cell_start;
        $this->sheet->setCellValue('A'.$cell_start, "Discount:");
        $this->sheet->setCellValue('B'.$cell_start, number_format($this->total_discount, 2));
        $this->sheet->setCellValue('C'.$cell_start, "Upon Registration");
        $this->sheet->setCellValue('D'.$cell_start, number_format($this->array_enrolled_fees['InitialPayment'], 2));

        $cell_start++;
        $this->sheet->setCellValue('A'.$cell_start, "Total Paid:");
        $this->sheet->setCellValue('B'.$cell_start, number_format($this->total_paid, 2));
        $this->sheet->setCellValue('C'.$cell_start, "First Payment");
        $this->sheet->setCellValue('D'.$cell_start, number_format($this->array_enrolled_fees['First_Pay'], 2));

        $cell_start++;
        $this->sheet->setCellValue('A'.$cell_start, "Assessment Balance:");
        $this->sheet->setCellValue('B'.$cell_start, number_format($this->assessment_balance, 2));
        $this->sheet->setCellValue('C'.$cell_start, "Second Payment");
        $this->sheet->setCellValue('D'.$cell_start, number_format($this->array_enrolled_fees['Second_Pay'], 2));

        $cell_start++;
        $this->sheet->setCellValue('A'.$cell_start, "OR Numbers:");
        $this->sheet->setCellValue('C'.$cell_start, "Third Payment");
        $this->sheet->setCellValue('D'.$cell_start, number_format($this->array_enrolled_fees['Third_Pay'], 2));

        $cell_start++;
        $this->sheet->mergeCells('A'.$cell_start.':'.'B'.$cell_start);
        $this->sheet->setCellValue('A'.$cell_start, $this->official_receipt_list);//List of OR Numbers

        $cell_start++;
        $this->sheet->mergeCells('A'.$cell_start.':'.'B'.$cell_start);
        $this->sheet->setCellValue('A'.$cell_start, "Other Semester Balance:");
        $this->sheet->setCellValue('F'.$cell_start, number_format($this->other_semester_balance_total, 2));// other semester balance

        $cell_start++;
        $array_other_balance_cell = array();
        #other semester balance
        $other_cell_count = 8;
        foreach ($this->other_semester_balance_list as $key => $value) {
            # code...
            $this->sheet->mergeCells('B'.$cell_start.':'.'C'.$cell_start);
            $this->sheet->setCellValue('B'.$cell_start, $value['semester']." ".$value['school_year']);
            $this->sheet->setCellValue('D'.$cell_start, number_format($value['balance'], 2));
            $other_cell_count--;
            $array_other_balance_cell[] = $cell_start;
            $cell_start++;
        }

        $cell_start++;
        $other_student_balance_cell = $cell_start;
        $this->sheet->setCellValue('A'.$cell_start, "Others:");
        $this->sheet->setCellValue('F'.$cell_start, number_format($this->other_fees_balance_total, 2));// others
        
        $cell_start++;
        #other student balance
        foreach ($this->other_fees_balance_list as $key => $value) {
            # code...
            $this->sheet->mergeCells('B'.$cell_start.':'.'C'.$cell_start);
            $this->sheet->setCellValue('B'.$cell_start, $value['item_paid']);
            $this->sheet->setCellValue('D'.$cell_start, number_format($value['balance'], 2));
            $other_cell_count--;
            $array_other_balance_cell[] = $cell_start;
            $cell_start++;
        }

       


        $cell_start+= $other_cell_count;
        $this->sheet->mergeCells('A'.$cell_start.':'.'B'.$cell_start);
        $this->sheet->setCellValue('A'.$cell_start, "TOTAL Amount due for ".$this->current_term);//change the quarter
        $this->sheet->setCellValue('F'.$cell_start, number_format($this->total_amount_due, 2));// amount due

        #set term due
        $this->set_term_due($term_due_cell_start);

        $this->cell_start = $cell_start;
        $this->balance_table_display_format($format_cell_start, $array_other_balance_cell, $other_student_balance_cell);
        return $this;

    }

    private function payment_option_display($cell_start)
    {
        $format_cell_start = $cell_start;
        $this->sheet->mergeCells('G'.$cell_start.':'.'H'.$cell_start);
        $this->sheet->setCellValue('G'.$cell_start, "PAYMENT OPTIONS");//set as bold

        $cell_start++;
        $this->sheet->mergeCells('G'.$cell_start.':'.'H'.$cell_start);
        $this->sheet->setCellValue('G'.$cell_start, " BILLS PAYMENT FACILITY");//set as bold

        $cell_start++;
        $this->sheet->mergeCells('G'.$cell_start.':'.'H'.$cell_start);
        $this->sheet->setCellValue('G'.$cell_start, " ASIA UNITED BANK");
        $this->sheet->mergeCells('I'.$cell_start.':'.'J'.$cell_start);
        $this->sheet->setCellValue('I'.$cell_start, "SA# 120-01-890142-6");

        $cell_start++;
        $this->sheet->mergeCells('G'.$cell_start.':'.'H'.$cell_start);
        $this->sheet->setCellValue('G'.$cell_start, " UNION BANK");
        $this->sheet->mergeCells('I'.$cell_start.':'.'J'.$cell_start);
        $this->sheet->setCellValue('I'.$cell_start, "SA# 0004-7001-2500");

        $cell_start++;
        $this->sheet->mergeCells('G'.$cell_start.':'.'H'.$cell_start);
        $this->sheet->setCellValue('G'.$cell_start, " EASTWEST BANK");
        $this->sheet->mergeCells('I'.$cell_start.':'.'J'.$cell_start);
        $this->sheet->setCellValue('I'.$cell_start, "SA# 2000-0065-6417");

        $cell_start++;
        $this->sheet->mergeCells('G'.$cell_start.':'.'J'.$cell_start);
        $this->sheet->setCellValue('G'.$cell_start, " SM BACOOR DEPARTMENT STORE");

        $cell_start++;
        $this->sheet->mergeCells('G'.$cell_start.':'.'J'.$cell_start);
        $this->sheet->setCellValue('G'.$cell_start, " SM HYPERMARKET - MOLINO");

        $cell_start++;
        $this->sheet->mergeCells('G'.$cell_start.':'.'J'.$cell_start);
        $this->sheet->setCellValue('G'.$cell_start, " SM HYPERMARKET - IMUS");

        $cell_start++;
        $this->sheet->mergeCells('G'.$cell_start.':'.'J'.$cell_start);
        $this->sheet->setCellValue('G'.$cell_start, " SM SAVEMORE - ZAPOTE");

        $cell_start+= 2;
        $this->sheet->mergeCells('G'.$cell_start.':'.'J'.$cell_start);
        $this->sheet->setCellValue('G'.$cell_start, " OVER-THE-COUNTER DEPOSIT");//set as bold

        $cell_start++;
        $this->sheet->mergeCells('G'.$cell_start.':'.'J'.$cell_start);
        $this->sheet->setCellValue('G'.$cell_start, " Account Name: St. Dominic College of Asia, Inc.");//set as bold

        $cell_start++;
        $this->sheet->mergeCells('G'.$cell_start.':'.'H'.$cell_start);
        $this->sheet->setCellValue('G'.$cell_start, " RCBC");
        $this->sheet->mergeCells('I'.$cell_start.':'.'J'.$cell_start);
        $this->sheet->setCellValue('I'.$cell_start, "SA# 1-345-00086-7");

        $cell_start++;
        $this->sheet->mergeCells('G'.$cell_start.':'.'H'.$cell_start);
        $this->sheet->setCellValue('G'.$cell_start, " BDO");
        $this->sheet->mergeCells('I'.$cell_start.':'.'J'.$cell_start);
        $this->sheet->setCellValue('I'.$cell_start, "SA# 70161291");

        $cell_start++;
        $this->sheet->mergeCells('G'.$cell_start.':'.'J'.$cell_start);
        $this->sheet->setCellValue('G'.$cell_start, "*Students must secure a duly accomplished payment slip");

        $cell_start++;
        $this->sheet->mergeCells('G'.$cell_start.':'.'J'.$cell_start);
        $this->sheet->setCellValue('G'.$cell_start, "including their Student Name and Student Number to be");

        $cell_start++;
        $this->sheet->mergeCells('G'.$cell_start.':'.'J'.$cell_start);
        $this->sheet->setCellValue('G'.$cell_start, "presented to the Bank Teller. Present the validated slip");

        $cell_start++;
        $this->sheet->mergeCells('G'.$cell_start.':'.'J'.$cell_start);
        $this->sheet->setCellValue('G'.$cell_start, "to the SDCA Cashier for issuance of Official Receipt.");

        $this->payment_option_display_format($format_cell_start);

        return $this;
    }

    private function set_term_due($cell_start)
    {
        $total_paid = $this->total_paid;
        $array_balance = array(
            'INITIAL'   =>  $this->array_enrolled_fees['InitialPayment'],
            'PRELIM'    =>  $this->array_enrolled_fees['First_Pay'],
            'MIDTERM'   =>  $this->array_enrolled_fees['Second_Pay'],
            'FINALS'    =>  $this->array_enrolled_fees['Third_Pay'],
        );

        foreach ($array_balance as $key => $value) {
            # code...
            if ($total_paid >= $value) {
                # code...
                $total_paid = $total_paid - $value;
            }
            elseif (($value > $total_paid) && ($total_paid > 0) ) {
                # code...
                $this->sheet->setCellValue('F'.$cell_start, number_format(($value - $total_paid), 2));
                $total_paid = 0;
            }
            else {
                $this->sheet->setCellValue('F'.$cell_start, number_format($value, 2));
            }

            if ($key === $this->current_term) {
                # code...
                break;
            }
            $cell_start++;
        }
        return $this;
    }

    private function footer($end_tag)
    {
        
    }

   

    public function export()
    {
        $this->header();
        $this->body();

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf($this->spreadsheet);
        
        $writer->writeAllSheets();
 
        $filename = $this->full_name;
 
        header('Cache-Control: max-age=0');
        //$writer->setPreCalculateFormulas(false);
        header('Content-Disposition: attachment;filename="'. $filename .'.pdf"'); 
        $writer->save('php://output'); // download file 
        

        /*
        $writer = new Xlsx($this->spreadsheet);
 
        $filename = $this->full_name;
 
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output'); // download file 
        */
    
        
    }

    public function reader()
    {
        $inputFileType = 'Xlsx';
        $inputFileName = './img/sample/soa_hed.xlsx';

        

       

        /**  Create a new Reader of the type defined in $inputFileType  **/
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
        /**  Load $inputFileName to a Spreadsheet Object  **/
        $spreadsheet = $reader->load($inputFileName);

        $worksheet = $spreadsheet->getActiveSheet();
        
        echo"col A ";
        echo $worksheet->getColumnDimension('A')->getWidth();
        echo "<br>";
        echo"col B ";
        echo $worksheet->getColumnDimension('B')->getWidth();
        echo "<br>";
        echo"col C ";
        echo $worksheet->getColumnDimension('C')->getWidth();
        echo "<br>";
        echo"col D ";
        echo $worksheet->getColumnDimension('D')->getWidth();
        echo "<br>";
        echo"col E ";
        echo $worksheet->getColumnDimension('E')->getWidth();
        echo "<br>";
        echo"col F ";
        echo $worksheet->getColumnDimension('F')->getWidth();
        echo "<br>";
        echo"col g ";
        echo $worksheet->getColumnDimension('G')->getWidth();
        echo "<br>";
        echo"col h ";
        echo $worksheet->getColumnDimension('H')->getWidth();
        echo "<br>";
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