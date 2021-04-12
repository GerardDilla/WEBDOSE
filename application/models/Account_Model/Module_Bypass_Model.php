<?php


class Module_Bypass_Model extends CI_Model{

    public function get_advising_bypassers_access($array_data)
    {
        $this->db->trans_start();
        $this->db->select('*');
        $this->db->from('module_bypass');
        $this->db->where('User_ID', $array_data['user_id']);
        $this->db->where('School_ID', $array_data['school_id']);
        $this->db->where('parent_module_id', 2);
        $this->db->trans_complete();

        $query = $this->db->get();

        // reset query
        $this->db->reset_query();

        return $query->result_array();
    }

    public function insert_logs($array_insert)
    {
        $this->db->insert('bypass_logs', $array_insert);
    }
}