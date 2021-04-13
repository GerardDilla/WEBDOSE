<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Holds data for User
 *
 * 
 *
 * @param array $parameters Array containing the necessary params.
 *   $parameters = [
 *     'student_info'   =>  (array) first row of student data.
 *     'student_type'   =>  (string) type of student: HED, SHS, BED.
 *  ]
 */

class Student 
{
    private $array_student_info;
    protected $student_number;
    protected $reference_number;
    protected $first_name;
    protected $middle_name;
    protected $last_name;
    protected $full_name;
    protected $address;
    protected $gender;
    protected $birth_date;
    protected $admission_school_year;
    protected $elementary_education;
    protected $secondary_education;
    protected $year_graduated;
    protected $track_id;
    protected $track_title;
    protected $strand;
    protected $strand_title;
    protected $lrn;
    protected $bed_elementary_education;
    protected $bed_elementary_graduated;
    protected $bed_secondary_education;
    protected $bed_secondary_graduated;
    
    protected $program_code;
    protected $major;
    protected $section;
    protected $semester;
    protected $year_level;
    protected $school_year;

    public function __construct($parameters)
    {
        $this->array_student_info = $parameters['student_info'];
        $this->set_reference_number();
        $this->set_full_name();
        $this->first_name = $this->array_student_info['First_Name'];
        $this->middle_name = $this->array_student_info['Middle_Name'];
        $this->last_name = $this->array_student_info['Last_Name'];
        $this->gender = $this->array_student_info['Gender'];
        
        $this->set_admission_school_year();
        $this->birth_date = $this->array_student_info['Birth_Date'];
        $this->set_student_number($this->array_student_info['Student_Number']);

        if (($parameters['student_type'] === 'SHS') || ($parameters['student_type'] === 'BED') ) {
            # code...
            $this->set_lrn();
            $this->set_address();
            $this->set_bed_elementary_education();
            $this->set_bed_secondary_education();
        }

        if ($parameters['student_type'] === 'SHS') {
            # code...
            $this->set_strand();
            $this->track_id = $this->array_student_info['Track'];
        }
        if ($parameters['student_type'] === 'HED') {
            # code...
            $this->year_level = $this->array_student_info['YearLevel'];
            $this->set_hed_address();
            $this->program_code = $this->array_student_info['Course'];
        }
        

        

        
        
        
    }

    protected function set_student_number($student_number)
    {
        $this->student_number = $student_number;
        return $this;
    }

    public function get_student_number()
    {
        return $this->student_number;
    }

    public function get_student_no()
    {
        return $this->student_number;
    }

    protected function set_reference_number()
    {
        $this->reference_number = $this->array_student_info['Reference_Number'];
        return $this;
    }

    public function get_reference_number()
    {
        return $this->reference_number;
    }

    public function get_reference_no()
    {
        return $this->reference_number;
    }

    public function get_year_level()
    {
        return $this->year_level;
    }

    protected function set_address()
    {
        $output="";
        if ($this->array_student_info['Address_No']) {
            # code...
            $output .= $this->array_student_info['Address_No'].', ';
        }

        if ($this->array_student_info['Address_Street']) {
            # code...
            $output .= $this->array_student_info['Address_Street'].', ';
        }

        if ($this->array_student_info['Subdivision']) {
            # code...
            $output .= $this->array_student_info['Subdivision'].', ';
        }

        if ($this->array_student_info['Barangay']) {
            # code...
            $output .= $this->array_student_info['Barangay'].', ';
        }

        if ($this->array_student_info['City']) {
            # code...
            $output .= $this->array_student_info['City'].', ';
        }

        if ($this->array_student_info['Province']) {
            # code...
            $output .= $this->array_student_info['Province'].' ';
        }

        $this->address = $output;
        return $this;
    }

    protected function set_hed_address()
    {
        $output="";
        if ($this->array_student_info['Address_No']) {
            # code...
            $output .= $this->array_student_info['Address_No'].', ';
        }

        if ($this->array_student_info['Address_Street']) {
            # code...
            $output .= $this->array_student_info['Address_Street'].', ';
        }

        if ($this->array_student_info['Address_Subdivision']) {
            # code...
            $output .= $this->array_student_info['Address_Subdivision'].', ';
        }

        if ($this->array_student_info['Address_Barangay']) {
            # code...
            $output .= $this->array_student_info['Address_Barangay'].', ';
        }

        if ($this->array_student_info['Address_City']) {
            # code...
            $output .= $this->array_student_info['Address_City'].', ';
        }

        if ($this->array_student_info['Address_Province']) {
            # code...
            $output .= $this->array_student_info['Address_Province'].' ';
        }

        $this->address = $output;
        return $this;
    }

    public function get_address()
    {
        return $this->address;
    }

    public function set_birth_date($birth_date)
    {
        $this->birth_date = $birth_date;
        return $this;
    }

    public function get_birth_date()
    {
        return $this->birth_date;
    }

    protected function set_admission_school_year()
    {
        $this->admission_school_year = $this->array_student_info['AdmittedSY'];
        return $this;
    }

    public function get_admission_school_year()
    {
        return $this->admission_school_year;
    }

    protected function set_elementary_education($elementary_education)
    {
        $this->elementary_education = $elementary_education;
        return $this;
    }

    protected function set_secondary_education($secondary_education)
    {
        $this->secondary_education = $secondary_education;
        return $this;
    }

    protected function set_year_graduated($year_graduated)
    {
        $this->year_graduated = $year_graduated;
        return $this;
    }

    public function get_track_id()
    {
        return $this->track_id;
    }

    public function set_track_title($track_title)
    {
        $this->track_title = $track_title;
        return $this;
    }

    protected function set_strand()
    {
        $this->strand = $this->array_student_info['Strand'];
        return $this;
    }

    public function get_strand()
    {
        return $this->strand;
    }

    public function set_strand_title($strand_title)
    {
        $this->strand_title = $strand_title;
        return $this;
    }

    protected function set_lrn()
    {
        $this->lrn = $this->array_student_info['LRN'];
        return $this;
    }

    protected function set_full_name()
    {
        $this->full_name = strtoupper($this->array_student_info['Last_Name'].', '.$this->array_student_info['First_Name'].' '.$this->array_student_info['Middle_Name']);
        return $this;
    }

    public function get_full_name()
    {
        return $this->full_name;
    }

    protected function set_bed_elementary_education()
    {
        if (isset($this->array_student_info['Previous_School_Name2'])) {
            # code...
            $this->bed_elementary_education = $this->array_student_info['Previous_School_Name2'];
        }
        else {
            # code...
            $this->bed_elementary_education = "";
        }

        if (isset($this->array_student_info['Previous_School_Years2'])) {
            # code...
            $this->bed_elementary_graduated = $this->array_student_info['Previous_School_Years2'];
        }
        else {
            # code...
            $this->bed_elementary_graduated = "";
        }
        return $this;
    }

    protected function set_bed_secondary_education()
    {
        if (isset($this->array_student_info['Previous_School_Name3'])) {
            # code...
            $this->bed_secondary_education = $this->array_student_info['Previous_School_Name3'];
        }
        else {
            # code...
            $this->bed_secondary_education = "";
        }

        if (isset($this->array_student_info['Previous_School_Years3'])) {
            # code...
            $this->bed_secondary_graduated = $this->array_student_info['Previous_School_Years3'];
        }
        else {
            # code...
            $this->bed_secondary_graduated = "";
        }
        return $this;
    }

    public function get_bed_elementary_education()
    {
        return $this->bed_secondary_education;
    }

    public function get_bed_elementary_graduated()
    {
        return $this->bed_elementary_graduated;
    }

    public function get_bed_secondary_education()
    {
        return $this->bed_secondary_education;
    }

    public function get_bed_secondary_graduated()
    {
        return $this->bed_secondary_graduated;
    }
    public function get_program_code()
    {
        return $this->program_code;
    }



   
}