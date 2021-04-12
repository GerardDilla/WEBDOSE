<?php


class Student_Model extends CI_Model
{
    public function get_student_details_by_student_no($student_no)
    {
        $this->db->select('*');
        $this->db->from('Basiced_Studentinfo');
        $this->db->where('Student_number', $student_no);
        $query = $this->db->get();

        // reset query
        $this->db->reset_query();

        return $query->result_array();

    }

    public function get_student_enrolled_levels($reference_no)
    {
        $this->db->select('GradeLevel, SchoolYear');
        $this->db->from('Basiced_EnrolledFees_Local');
        $this->db->where('Reference_Number', $reference_no);
        $query = $this->db->get();

        // reset query
        $this->db->reset_query();

        return $query->result_array();
    }

    public function get_strand_title($stand_code)
    {
        $this->db->select('Strand_Title');
        $this->db->from('SeniorHigh_Strand');
        $this->db->where('Strand_Code', $stand_code);

        $query = $this->db->get();
        return $query->result_array();

    }

    public function get_track_title($track)
    {
        $this->db->select('Track');
        $this->db->from('SeniorHigh_Tracks');
        $this->db->where('ID', $track);

        $query = $this->db->get();
        return $query->result_array();
    }

}