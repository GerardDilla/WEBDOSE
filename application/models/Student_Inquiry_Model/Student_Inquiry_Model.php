<?php


class Student_Inquiry_Model extends CI_Model
{
    public function index(){
        
    }
    public function getStudentInquiry()
    {
        $this->db->select('*');
        $this->db->from('student_inquiry');
        $this->db->join('Student_Info', 'student_inquiry.ref_no = Student_Info.Reference_Number');
        $this->db->where('user_type', 'student');
        $this->db->group_by('ref_no');
        return $this->db->get()->result_array();
    }
    public function countTotalUnseenMessage($ref_no)
    {
        $this->db->select('count(id) as total_unseen');
        $this->db->from('student_inquiry');
        $this->db->where('ref_no', $ref_no);
        $this->db->where('status <> ', 'seen');
        $this->db->where('user_type', 'student');
        $this->db->group_by('ref_no');
        $result = $this->db->get()->row_array();
        return empty($result['total_unseen']) ? 0 : $result['total_unseen'];
    }
}
?>