<?php


class Course_Model extends CI_Model
{
    
    public function get_course_pre_req($array_data)
    {
        $this->db->select('*, SP.Course_Code AS pre_req, Subj.Course_Code AS `subject`, SD.`Start_Time` AS sched_start_time , SD.`End_Time` AS sched_end_time');
        $this->db->from('Sched_Display AS SD');
        $this->db->join('Sched AS S', 'S.`Sched_Code` = SD.`Sched_Code`', 'inner');
        $this->db->join('`Subject` AS Subj', '`Subj`.`Course_Code` = S.`Course_Code`', 'inner');
        $this->db->join('Subject_Prerequisite AS SP', 'SP.Subject_ID = Subj.ID', 'left');
        $this->db->where('SD.id', $array_data['sched_display_id']);
        //$this->db->where('SP.valid', 1);

        $query = $this->db->get();
        // reset query
        $this->db->reset_query();

        return $query->result_array();
    }

    public function get_course_choices(){

        $query = $this->db->get('Programs');
        return $query->result_array();
    }

    public function get_major_choices($program_id){

        $this->db->where('Program_Code',$program_id);
        $query = $this->db->get('Program_Majors');
        return $query->result_array();
    }

    public function student_course_update($ref,$input){

        $this->db->trans_start();
        $this->db->where('Reference_Number',$ref);
        $query = $this->db->update('Student_Info',$input);
        $this->db->trans_complete();

        return $this->db->trans_status();
    }

}