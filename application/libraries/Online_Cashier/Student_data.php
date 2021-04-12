<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class student_data
{
    protected $reference_no;
    protected $student_no;
    protected $semester;
    protected $school_year;
    protected $amount_paid;
    protected $or_no;
    protected $payment_type;
    protected $transaction_type;
    protected $description;
    protected $grade_level;
    protected $track;
    protected $strand;
    protected $school_level;

    #add constructor later
    /*
    public function __construct($parameters)
    {
        $this->reference_no = $parameters['reference_no'];
        $this->semester = $parameters['semester'];
        $this->school_year = $parameters['school_year'];
    }
    */
    public function set_reference_no($reference_no)
    {
        $this->reference_no = $reference_no;
        return $this;
    }

    public function get_reference_no()
    {
        return $this->reference_no;
    }

    public function set_student_no($student_no)
    {
        $this->student_no = $student_no;
        return $this;
    }

    public function get_student_no()
    {
        return $this->student_no;
    }

    public function set_semester($semester)
    {
        $this->semester = $semester;
        return $this;
    }

    public function get_semester()
    {
        return $this->semester;
    }

    public function set_school_year($school_year)
    {
        $this->school_year = $school_year;
        return $this;
    }

    public function get_school_year()
    {
        return $this->school_year;
    }

    public function set_amount($amount_paid)
    {
        $this->amount_paid = $amount_paid;
        return $this;
    }

    public function get_amount()
    {
        return $this->amount_paid;
    }

    public function set_or_no($or_no)
    {
        $this->or_no = $or_no;
        return $this;
    }

    public function get_or_no()
    {
        return $this->or_no;
    }

    public function set_payment_type($payment_type)
    {
        $this->payment_type = $payment_type;
        return $this;
    }

    public function get_payment_type()
    {
        return $this->payment_type;
    }

    public function set_transaction_type($transaction_type)
    {
        $this->transaction_type = $transaction_type;
        return $this;
    }

    public function get_transaction_type()
    {
        return $this->transaction_type;
    }

    public function set_description($description)
    {
        $this->description = $description;
        return $this;
    }

    public function get_description()
    {
        return $this->description;
    }

    public function set_grade_level($grade_level)
    {
        $this->grade_level = $grade_level;
        return $this;
    }

    public function get_grade_level()
    {
        return $this->grade_level;
    }

    public function set_track($track)
    {
        $this->track = $track;
        return $this;
    }

    public function get_track()
    {
        return $this->track;
    }

    public function set_strand($strand)
    {
        $this->strand = $strand;
        return $this;
    }

    public function get_strand()
    {
        return $this->strand;
    }

    public function set_school_level()
    {
        $array_shs = array('G11', 'G12');

        #check if shs
        if (in_array($this->grade_level, $array_shs)) {
            # code...
            $this->school_level = "SHS";
        }
        else {
            $this->school_level = "BED";
        }
        
        return $this;
    }

    public function get_school_level()
    {
        return $this->school_level;
    }
}