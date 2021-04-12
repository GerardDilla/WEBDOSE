<?php

class Global_Program_Model extends CI_Model {

    public function get_program_code_list()
    {
        $this->db->select('Program_ID, Program_Code');
        $this->db->from('Programs');
        $query = $this->db->get();
        return $query->result_array();

    }

    public function get_advising_term()
    {
        $this->db->select('School_Year, Advising_Semester AS Semester, Term');
        $this->db->from('Legend');
        $query = $this->db->get();
        $output =  $query->result_array();
        return $output[0];
    }
}
