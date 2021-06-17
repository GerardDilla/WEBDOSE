<?php


class User_verification extends CI_Model{

    public function login($credentials)
    {
        $password = $credentials['password'];
        $this->db->select('User_ID');
        $this->db->select('User_FullName');
        $this->db->select('User_Position');
        $this->db->select('UserName');
        $this->db->where('UserName',$credentials['username']);
        // $this->db->where('Password',$credentials['password']);
        // $this->db->where('AES_DECRYPT(`Password`, \''.$credentials['password'].'\') = \''.$credentials['password'].'\'');
        $this->db->where('tabValid',1);
        $this->db->from('Users');
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