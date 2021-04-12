<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Schedule
{

    protected $sched_code;
    protected $semester;
    protected $school_year;
    protected $day;
    protected $time_start;
    protected $time_end;

    protected $merge_into_sched_code;
    protected $merge_into_semester;
    protected $merge_into_school_year;
    protected $merge_into_day;
    protected $merge_into_time_start;
    protected $merge_into_time_end;
    

    public function __construct($parameters)
    {
        $this->sched_code = $parameters['sched_code'];
        $this->semester = $parameters['semester'];
        $this->school_year = $parameters['school_year'];
        $this->day = $parameters['day'];
        $this->time_start = $parameters['time_start'];
        $this->time_end = $parameters['time_end'];
        
    }

    function __destruct() 
    {
        echo "class schedule destructed"; 
    }

    public function get_sched_code()
    {
        return $this->sched_code;
    }

    public function get_semester()
    {
        return $this->semester;
    }

    public function get_school_year()
    {
        return $this->school_year;
    }

    public function get_day()
    {
        return $this->day;
    }

    public function get_time_start()
    {
        return $this->time_start;
    }

    public function get_time_end()
    {
        return $this->time_end;
    }

    public function set_merge_into_sched_code($sched_code)
    {
        $this->merge_into_sched_code = $sched_code;
        return $this;
    }

    public function get_merge_into_sched_code()
    {
        return $this->merge_into_sched_code;
    }

    public function set_merge_into_semester($semester)
    {
        $this->merge_into_semester = $semester;
        return $this;
    }

    public function get_merge_into_semester()
    {
        return $this->merge_into_semester;
    }

    public function set_merge_into_school_year($school_year)
    {
        $this->merge_into_school_year = $school_year;
        return $this;
    }

    public function get_merge_into_school_year()
    {
        return $this->merge_into_school_year;
    }

    public function set_merge_into_day($day)
    {
        $this->merge_into_day = $day;
        return $this;
    }

    public function get_merge_into_day()
    {
        return $this->merge_into_day;
    }

    public function set_merge_into_time_start($time_start)
    {
        $this->merge_into_time_start = $time_start;
        return $this;
    }

    public function get_merge_into_time_start()
    {
        return $this->merge_into_time_start;
    }

    public function set_merge_into_time_end($time_end)
    {
        $this->merge_into_time_end = $time_end;
        return $this;
    }

    public function get_merge_into_time_end()
    {
        return $this->merge_into_time_end;
    }



    

    
}