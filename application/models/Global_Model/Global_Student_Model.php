<?php


class Global_Student_Model extends CI_Model{

    public function get_student_info_by_student_no($student_no)
    {
        $this->db->select('*');
        $this->db->from('Student_Info');
        $this->db->join('Program_Majors', '`Program_Majors`.`ID` = `Student_Info`.`Major`');
        $this->db->where('Student_Number', $student_no);
        $this->db->where('Student_Number !=', 0);
        

        $query = $this->db->get();

        return $query->result_array();
    }
}