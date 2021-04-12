<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Global_User_Model extends CI_Model {

    public function get_user_details($user_id)
    {
        $this->db->select('*');
        $this->db->from('Users');
        $this->db->where('User_ID', $user_id);
        $query = $this->db->get();

        return $query->result_array();
    
    }

    public function search_user_by_username($search_key, $limit, $start)
    {
        $this->db->select('User_ID, UserName, User_FullName, User_Position, User_Department, tabValid');
        $this->db->from('Users');
        $this->db->like('UserName', $search_key);

        if ($limit > 0) {
            # code...
            $this->db->limit($limit, $start);
        }

        $query = $this->db->get();

        return $query->result_array();

    }

    public function search_user_by_name($search_key, $limit, $start)
    {
        $this->db->select('User_ID, UserName, User_FullName, User_Position, User_Department, tabValid');
        $this->db->from('Users');
        $this->db->like('User_FullName', $search_key);

        if ($limit > 0) {
            # code...
            $this->db->limit($limit, $start);
        }

        $query = $this->db->get();

        return $query->result_array();

    }

    public function search_user_by_department($search_key, $limit, $start)
    {
        $this->db->select('User_ID, UserName, User_FullName, User_Position, User_Department, tabValid');
        $this->db->from('Users');
        $this->db->like('User_Department', $search_key);

        if ($limit > 0) {
            # code...
            $this->db->limit($limit, $start);
        }

        $query = $this->db->get();

        return $query->result_array();

    }

    public function search_user_by_position($search_key, $limit, $start)
    {
        $this->db->select('User_ID, UserName, User_FullName, User_Position, User_Department, tabValid');
        $this->db->from('Users');
        $this->db->like('User_Position', $search_key);

        if ($limit > 0) {
            # code...
            $this->db->limit($limit, $start);
        }

        $query = $this->db->get();

        return $query->result_array();

    }

    

}