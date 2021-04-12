<?php


class Attendance_Model extends CI_Model
{
   public function get_bed_total_school_days($school_year)
   {
    $this->db->select('SUM(school_days) AS total_school_days');
    $this->db->from('basiced_grading_markingperiods');
    $this->db->where('schlvl', 'BED');
    $this->db->where('school_Year', $school_year);
    $query = $this->db->get();

    // reset query
    $this->db->reset_query();

    return $query->result_array();
   }

   public function get_student_total_ua($reference_no, $school_year)
   {
    $this->db->select('SUM(UA) AS total_ua');
    $this->db->from('basiced_grading_attendance');
    $this->db->where('Reference_Number', $reference_no);
    $this->db->where('school_year', $school_year);
    $query = $this->db->get();

    // reset query
    $this->db->reset_query();

    return $query->result_array();
   }
}