<?php


class Grades_Model extends CI_Model
{
    public function get_basiced_subject_grade($array_data)
    {
        $this->db->select('subject_id, `Quarter`, finGrade');
        $this->db->from('basiced_grading_enrolled_grades_final');
        $this->db->where('subject_id', $array_data['subject_id']);
        $this->db->where('Reference_Number', $array_data['reference_no']);
        $this->db->where('School_Year', $array_data['school_year']);
        $query = $this->db->get();

        // reset query
        $this->db->reset_query();

        return $query->result_array();
    }

    public function get_baisced_total_grades($array_data)
    {
        $this->db->select('finGrade');
        $this->db->from('basiced_grading_enrolled_grades_final');
        $this->db->where('Reference_Number', $array_data['reference_no']);
        $this->db->where('School_Year', $array_data['school_year']);
        $query = $this->db->get();

        // reset query
        $this->db->reset_query();

        return $query->result_array();
    }
}