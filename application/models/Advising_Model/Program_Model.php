<?php


class Program_Model extends CI_Model
{
    public function get_program_curriculum($program)
    {
        $this->db->select('*');
        $this->db->from('Programs AS P'); 
        $this->db->join('Curriculum_Info AS CI', 'P.`Program_ID` = CI.`Program_ID`');
        $this->db->where('CI.`Valid`', 1);
        $this->db->where('P.`Program_Code`', $program);

        $query = $this->db->get();

        // reset query
        $this->db->reset_query();

        return $query->result_array();
    }

    public function get_program_sections($program)
    {
        $this->db->select('*');
        $this->db->from('Sections');
        $this->db->join('Programs','Programs.Program_ID = Sections.Program_ID');
        $this->db->where('Programs.Program_Code',$program);
        $this->db->where('Sections.Active', 1);

        $query = $this->db->get();

        // reset query
        $this->db->reset_query();

        return $query->result_array();
    }
    public function get_program_list(){
        $query = $this->db->get('Programs');
        return $query->result_array();
    }
    /*
    public function get_section_name_by_advising($array_data)
    {
        $this->db->select('*');
        $this->db->from('Advising AS Adv');
        $this->db->join('Sections AS Sec', 'Adv.Section = Sec.Section_ID', 'inner');
        $this->db->where('Adv.Reference_Number',$array_data['reference_no']);
        $this->db->where('Adv.Semester',$array_data['semester']);
        $this->db->where('Adv.School_Year',$array_data['school_year']);
        $this->db->where('Adv.valid', 1);

        $query = $this->db->get();

        // reset query
        $this->db->reset_query();

        return $query->result_array();
    }
    */

    public function check_international_program($program_code)
    {
        $this->db->select('*');
        $this->db->from('Programs');
        $this->db->where('Program_Code', $program_code);
        $this->db->where('international_program', 1);

        $query = $this->db->get();
        return $query->result_array();
    }
}