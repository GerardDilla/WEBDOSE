<?php


class Student_Model extends CI_Model{

    public function get_student_info_by_reference_no($reference_no)
    {
        $this->db->select('*, PM1.`Program_Major` AS 1st_major, PM2.`Program_Major` AS 2nd_major, PM3.`Program_Major` AS 3rd_major');
        $this->db->from('Student_Info AS SI');    
        $this->db->join('`Program_Majors` AS PM1', 'PM1.`ID` = SI.`Course_Major_1st`');
        $this->db->join('Program_Majors AS PM2', 'PM2.`ID` = SI.`Course_Major_2nd`');
        $this->db->join('Program_Majors AS PM3', 'PM3.`ID` = SI.`Course_Major_3rd`');
        $this->db->where('Reference_Number', $reference_no);
        $query = $this->db->get();

        // reset query
        $this->db->reset_query();

        return $query->result_array();
    }

    public function check_if_foreigner($reference_no)
    {
        $this->db->trans_start();
        $this->db->select('Reference_Number');
        $this->db->from('Student_Info');
        $this->db->where('Reference_Number', $reference_no);
        $this->db->where('Nationality !=', 'FILIPINO');
        $this->db->trans_complete();

        $query = $this->db->get();

        // reset query
        $this->db->reset_query();

        return $query->num_rows();
    }

}