<?php


class Student_Inquiry_Model extends CI_Model
{
    public function index(){
        
    }
    public function getStudentInquiry()
    {
        $today = date('Y-m-d');
        $this->db->select("MAX(date_created) AS last_date,COUNT(id) as total_unseen,Student_Info.YearLevel,Student_Info.Course,Student_Info.First_Name,Student_Info.Middle_Name,Student_Info.Last_Name,Student_Info.Reference_Number as ref_no,COUNT(student_inquiry.id) as total_message,CONCAT(Student_Info.First_Name, ' ',Student_Info.Middle_Name,' ', Student_Info.Last_Name) as Full_Name");
        $this->db->from('student_inquiry');
        $this->db->join('Student_Info', 'student_inquiry.ref_no = Student_Info.Reference_Number');
        $this->db->like('date_created',$today);
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
    public function countTotalMessages($ref_no)
    {
        $this->db->select('count(id) as total_unseen');
        $this->db->from('student_inquiry');
        $this->db->where('ref_no', $ref_no);
        // $this->db->where('status <> ', 'seen');
        $this->db->where('user_type', 'student');
        $this->db->group_by('ref_no');
        $result = $this->db->get()->row_array();
        return empty($result['total_unseen']) ? 0 : $result['total_unseen'];
    }
}
?>