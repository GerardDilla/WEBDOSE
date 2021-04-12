<?php
defined('BASEPATH') or exit('No direct script access allowed');

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
    protected $nationality;
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
    protected $search_engine;
    protected $civilstatus;

    #Family Background
    protected $parent_status;
    protected $mother_name;
    protected $mother_address;
    protected $mother_occupation;
    protected $mother_email;
    protected $mother_deceased;
    protected $mother_contact;
    protected $mother_education;
    protected $mother_income;
    protected $father_name;
    protected $father_address;
    protected $father_occupation;
    protected $father_email;
    protected $father_deceased;
    protected $father_contact;
    protected $father_education;
    protected $father_income;
    protected $guardian_name;
    protected $guardian_address;
    protected $guardian_relationship;
    protected $guardian_contact;
    protected $guardian_education;
    protected $guardian_income;

    #Bed Academic Background
    protected $bed_elementary_education;
    protected $bed_elementary_graduated;
    protected $bed_secondary_education;
    protected $bed_secondary_graduated;

    #Hed Academic Background 
    protected $transferee_name;
    protected $elementary_school_name;
    protected $elementary_school_address;
    protected $elementary_school_grad;
    protected $secondary_school_name;
    protected $secondary_school_address;
    protected $secondary_school_grad;
    protected $shs_school_name;
    protected $shs_school_address;
    protected $shs_school_grad;

    #contact info
    protected $telephone;
    protected $cellphone;
    protected $email;

    #individual Address
    protected $address_no;
    protected $address_street;
    protected $address_subdivision;
    protected $address_barangay;
    protected $address_city;
    protected $address_province;

    #School Data
    protected $program_code;
    protected $major;
    protected $section;
    protected $semester;
    protected $year_level;
    protected $school_year;

    #4ps program
    protected $dswd_number;
    protected $physical_condition;
    protected $mental_condition;

    #Course Info
    protected $course1;
    protected $course2;
    protected $course3;
    protected $major1;
    protected $major2;
    protected $major3;

    #Other info
    protected $relative;
    protected $relative_department;

    public function __construct($parameters)
    {

        $this->array_student_info = $parameters['student_info'];
        
        // header('Content-Type: application/json; charset=utf-8');
        // die(json_encode($parameters, JSON_PRETTY_PRINT));

        $this->set_reference_number();
        $this->set_full_name();

        #Sets basic information individually 
        $this->set_basic_info();

        #Sets Infromation about relative
        $this->set_relative();

        #Sets 4ps information
        $this->set_4ps_program();

        //$this->ci = $this->array_student_info['Gender'];

        $this->set_admission_school_year();
        $this->birth_date = $this->array_student_info['Birth_Date'];
        $this->birth_place = $this->array_student_info['Birth_Place'];
        $this->set_student_number($this->array_student_info['Student_Number']);

        if (($parameters['student_type'] === 'SHS') || ($parameters['student_type'] === 'BED')) {
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
            $this->set_hed_education();
            $this->set_preferred_course();
            $this->set_family_info();
            $this->year_level = $this->array_student_info['YearLevel'];
            $this->set_hed_address();
            $this->program_code = $this->array_student_info['Course'];
        }
    }
    protected function set_basic_info()
    {

        #Individual name
        $this->first_name = $this->array_student_info['First_Name'];
        $this->middle_name = $this->array_student_info['Middle_Name'];
        $this->last_name = $this->array_student_info['Last_Name'];

        #Other Info
        $this->gender = $this->array_student_info['Gender'];
        $this->nationality = $this->array_student_info['Nationality'];
        $this->telephone = $this->array_student_info['Tel_No'];
        $this->cellphone = $this->array_student_info['CP_No'];
        $this->email = $this->array_student_info['Email'];
        $this->civilstatus = $this->array_student_info['Civil_Status'];

        $this->set_search_engine($this->array_student_info['Others_Know_SDCA']);

        #Academic Year Applied
        $this->semester = $this->array_student_info['Applied_Semester'];
        $this->school_year = $this->array_student_info['Applied_SchoolYear'];
    }
    protected function set_hed_education()
    {

        #Basic Education
        $this->elementary_school_name = $this->array_student_info['Grade_School_Name'];
        $this->elementary_school_address = $this->array_student_info['Grade_School_Address'];
        $this->elementary_school_grad = $this->array_student_info['Grade_School_Grad'];

        #Secondary Education 
        $this->secondary_school_name = $this->array_student_info['Secondary_School_Name'];
        $this->secondary_school_address = $this->array_student_info['Secondary_School_Address'];
        $this->secondary_school_grad = $this->array_student_info['Secondary_School_Grad'];

        #SHS Education
        $this->shs_school_name = $this->array_student_info['SHS_School_Name'];
        $this->shs_school_address = $this->array_student_info['SHS_School_Address'];
        $this->shs_school_grad = $this->array_student_info['SHS_School_Grad'];

        #transfer status
        $this->transferee_name = $this->array_student_info['Transferee_Name'];
    }
    protected function set_family_info()
    {

        $this->parent_status = $this->array_student_info['Parents_Status'];
        $this->mother_name = $this->array_student_info['Mother_Name'];
        $this->mother_address = $this->array_student_info['Mother_Address'];
        $this->mother_occupation = $this->array_student_info['Mother_Occupation'];
        $this->mother_contact = $this->array_student_info['Mother_Contact'];
        $this->mother_email = $this->array_student_info['Mother_Email'];
        $this->mother_income = $this->array_student_info['Mother_Income'];
        $this->mother_education = $this->array_student_info['Mother_Education'];

        $this->father_name = $this->array_student_info['Father_Name'];
        $this->father_address = $this->array_student_info['Father_Address'];
        $this->father_occupation = $this->array_student_info['Father_Occupation'];
        $this->father_contact = $this->array_student_info['Father_Contact'];
        $this->father_email = $this->array_student_info['Father_Email'];
        $this->father_income = $this->array_student_info['Father_Income'];
        $this->father_education = $this->array_student_info['Father_Education'];

        $this->guardian_name = $this->array_student_info['Guardian_Name'];
        $this->guardian_address = $this->array_student_info['Guardian_Address'];
        $this->guardian_relationship = $this->array_student_info['Guardian_Relationship'];
        $this->guardian_contact = $this->array_student_info['Guardian_Contact'];
        $this->guardian_income = $this->array_student_info['Guardian_Income'];
        $this->guardian_education = $this->array_student_info['Guardian_Education'];
    }
    protected function set_4ps_program()
    {
        $this->dswd_number = $this->array_student_info['dswd_no'];
        $this->physical_condition = $this->array_student_info['physical_condition'];
        $this->mental_condition = $this->array_student_info['mental_condition'];
    }
    protected function set_preferred_course(){

        $this->course1 = $this->array_student_info['Course_1st'];
        $this->course2 = $this->array_student_info['Course_2nd'];
        $this->course3 = $this->array_student_info['Course_3rd'];

        $this->major1 = $this->array_student_info['Course_Major_1st'];
        $this->major2 = $this->array_student_info['Course_Major_2nd'];
        $this->major3 = $this->array_student_info['Course_Major_3rd'];

    }
    protected function set_relative()
    {

        $this->relative = $this->array_student_info['Others_Relative_Name'];
        $this->relative_department = $this->array_student_info['Others_Relative_Department'];
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
        $output = "";
        if ($this->array_student_info['Address_No']) {
            # code...
            $output .= $this->array_student_info['Address_No'] . ', ';
        }

        if ($this->array_student_info['Address_Street']) {
            # code...
            $output .= $this->array_student_info['Address_Street'] . ', ';
        }

        if ($this->array_student_info['Subdivision']) {
            # code...
            $output .= $this->array_student_info['Subdivision'] . ', ';
        }

        if ($this->array_student_info['Barangay']) {
            # code...
            $output .= $this->array_student_info['Barangay'] . ', ';
        }

        if ($this->array_student_info['City']) {
            # code...
            $output .= $this->array_student_info['City'] . ', ';
        }

        if ($this->array_student_info['Province']) {
            # code...
            $output .= $this->array_student_info['Province'] . ' ';
        }

        #sets address individually
        $this->address_no = $this->array_student_info['Address_No'];
        $this->address_street = $this->array_student_info['Address_Street'];
        $this->address_subdivision = $this->array_student_info['Subdivision'];
        $this->address_barangay = $this->array_student_info['Barangay'];
        $this->address_city = $this->array_student_info['City'];
        $this->address_province = $this->array_student_info['Province'];

        $this->address = $output;
        return $this;
    }

    protected function set_hed_address()
    {
        $output = "";
        if ($this->array_student_info['Address_No']) {
            # code...
            $output .= $this->array_student_info['Address_No'] . ', ';
        }

        if ($this->array_student_info['Address_Street']) {
            # code...
            $output .= $this->array_student_info['Address_Street'] . ', ';
        }

        if ($this->array_student_info['Address_Subdivision']) {
            # code...
            $output .= $this->array_student_info['Address_Subdivision'] . ', ';
        }

        if ($this->array_student_info['Address_Barangay']) {
            # code...
            $output .= $this->array_student_info['Address_Barangay'] . ', ';
        }

        if ($this->array_student_info['Address_City']) {
            # code...
            $output .= $this->array_student_info['Address_City'] . ', ';
        }

        if ($this->array_student_info['Address_Province']) {
            # code...
            $output .= $this->array_student_info['Address_Province'] . ' ';
        }

        #sets address individually
        $this->address_no = $this->array_student_info['Address_No'];
        $this->address_street = $this->array_student_info['Address_Street'];
        $this->address_subdivision = $this->array_student_info['Address_Subdivision'];
        $this->address_barangay = $this->array_student_info['Address_Barangay'];
        $this->address_city = $this->array_student_info['Address_City'];
        $this->address_province = $this->array_student_info['Address_Province'];

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
        $this->full_name = strtoupper($this->array_student_info['Last_Name'] . ', ' . $this->array_student_info['First_Name'] . ' ' . $this->array_student_info['Middle_Name']);
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
        } else {
            # code...
            $this->bed_elementary_education = "";
        }

        if (isset($this->array_student_info['Previous_School_Years2'])) {
            # code...
            $this->bed_elementary_graduated = $this->array_student_info['Previous_School_Years2'];
        } else {
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
        } else {
            # code...
            $this->bed_secondary_education = "";
        }

        if (isset($this->array_student_info['Previous_School_Years3'])) {
            # code...
            $this->bed_secondary_graduated = $this->array_student_info['Previous_School_Years3'];
        } else {
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
    protected function set_search_engine($search_engine)
    {

        return $this->search_engine = $search_engine;
    }
}
