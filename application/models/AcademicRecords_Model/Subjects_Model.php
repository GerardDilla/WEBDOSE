<?php


class Subjects_Model extends CI_Model
{
    public function get_form137_subject_arrangement($grade_level, $school_year)
    {
        $this->db->select('subjects_id, parent_subject.subject_name AS parent_subject_name, subject_title, subjects.parent_subject AS parent_subject_id');
        $this->db->from('basiced_grading_subjects_arrangement AS subject_arrangement');
        $this->db->join('basiced_grading_subjects_parent AS parent_subject', 'parent_subject.id = subject_arrangement.parent_id', 'left');
        $this->db->join('basiced_grading_subjects AS subjects', 'subjects.id = subject_arrangement.subjects_id', 'left');
        $this->db->where('subject_arrangement.grade_level', $grade_level);
        $this->db->where('subject_arrangement.SchoolYear', $school_year);
        $this->db->order_by('subject_arrangement.position');
        $query = $this->db->get();

        // reset query
        $this->db->reset_query();

        return $query->result_array();
    }

    public function get_shs_subject_arrangement($grade_level, $school_year)
    {
        $this->db->select('subject_arrangement.subjects_id,  subjects.subject_title, subjects.parent_subject AS division_id, subjects.semester');
        $this->db->from('basiced_grading_subjects_arrangement AS subject_arrangement');
        $this->db->join('basiced_grading_subjects AS subjects', 'subjects.id = subject_arrangement.subjects_id', 'left');
        $this->db->where('subject_arrangement.grade_level', $grade_level);
        $this->db->where('subject_arrangement.SchoolYear', $school_year);
        $this->db->where('subject_arrangement.subjects_id !=', -1);
        $this->db->group_by('subjects_id');
        $this->db->order_by('subjects.semester', 'ASC');
        $this->db->order_by('subject_arrangement.position', 'ASC');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function get_shs_division()
    {
        $this->db->select('*');
        $this->db->from('basiced_grading_subjects_division');
        $query = $this->db->get();

        return $query->result_array();
    }
}
