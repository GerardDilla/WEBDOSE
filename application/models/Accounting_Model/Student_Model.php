<?php

class Student_Model extends CI_Model {

    public function get_student_list_by_program($program_code, $semester, $school_year)
    {   
        $this->db->select('enrolled.Reference_Number, student.First_Name, student.Middle_Name, student.Last_Name, student.Email');
        $this->db->from('Fees_Enrolled_College AS enrolled');
        $this->db->join('Student_Info AS student', 'enrolled.Reference_Number = student.Reference_Number');
        $this->db->where('enrolled.semester',$semester);
        $this->db->where('enrolled.schoolyear', $school_year);
        $this->db->where('enrolled.course', $program_code);
        // $this->db->limit(30,0);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function getStudentListPaginated($program_code, $semester, $school_year,$limit,$offset){
        $this->db->select('enrolled.Reference_Number, student.First_Name, student.Middle_Name, student.Last_Name, student.Email');
        $this->db->from('Fees_Enrolled_College AS enrolled');
        $this->db->join('Student_Info AS student', 'enrolled.Reference_Number = student.Reference_Number');
        $this->db->where('enrolled.semester',$semester);
        $this->db->where('enrolled.schoolyear', $school_year);
        $this->db->where('enrolled.course', $program_code);
        $this->db->limit($limit,$offset);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function get_student_id($limit,$offset){
        $query = $this->db->get('Student_ID',$limit,$offset);
        return $query->result_array();
    }
    public function inset_soa_due_data($array_data)
    {
        $this->db->trans_start();
        $this->db->insert('soa_due_date_list', $array_data);
        $output = $this->db->insert_id();
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE)
        {
                // generate an error... or use the log_message() function to log your error
                $output = "";
        }
        
        // reset query
        #$this->db->reset_query();

        return $output;
    }
    
    public function get_soa_due_date($due_id)
    {
        $this->db->select('*');
        $this->db->from('soa_due_date_list');
        $this->db->where('id', $due_id);
        $query = $this->db->get();
        $output = $query->result_array();
        return $output[0];
    }
}