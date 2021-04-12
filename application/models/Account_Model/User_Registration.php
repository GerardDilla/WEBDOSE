<?php


class User_Registration extends CI_Model{

    public function Get_user_list()
    {
       

        $query = $this->db->get();

        $this->db->reset_query();

        return $query;
    }

    public function get_user_info($array_data)
    {
        $this->db->trans_start();
        $this->db->select('*');
        $this->db->from('Users');
        $this->db->where('UserName',$array_data['username']);
        $this->db->where('AES_DECRYPT(`Password`, \''.$array_data['password'].'\') = \''.$array_data['password'].'\'');
        $query = $this->db->get();

        // reset query
        $this->db->reset_query();

        return $query->result_array();

    }

}