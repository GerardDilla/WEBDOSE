<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_Accessibility_Model extends CI_Model{

    public function get_module_access($array_data)
    {
        $this->db->select('*');
        $this->db->from('module_assignment');
        $this->db->where('User_id', $array_data['user_id']);
        $this->db->where('parent_module_id', $array_data['module_id']);
        $this->db->where('valid', 1);
        $query = $this->db->get();
        // reset query
        //$this->db->reset_query();

        return $query->num_rows();
    }

    public function get_user_module_access($user_id)
    {
        $this->db->select('*');
        $this->db->from('module_assignment');
        $this->db->where('User_id', $user_id);
        $this->db->where('valid', 1);
        $query = $this->db->get();
        // reset query
        //$this->db->reset_query();

        return $query->result_array();
    }

    public function get_all_users($access){

        $this->db->select('*');
        $this->db->from('Users');
        $this->db->where($access, 1);
        $query = $this->db->get();
        //$this->db->reset_query();

        return $query->result_array();

    }
    public function get_add_accessibilities(){


        $this->db->select('*');
        $this->db->from('parent_module');
        $this->db->where('valid', 1);
        $query = $this->db->get();
        //$this->db->reset_query();
        return $query->result_array();

    }
    public function insert_new_module($array){
        $this->db->insert('module_assignment', $array);
        //$this->db->reset_query();
        return $this->db->insert_id();
    }

    public function insert_user_roles()
    {
        $this->db->trans_start();
        $this->db->insert_batch('module_assignment', $this->user_roles->get_roles_to_add());
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE)
        {
            // generate an error... or use the log_message() function to log your error
            $message = "fail to insert User Roles";
        }
        else
        {
            $message = "Insert Roles sucessful";
        } 
        
        
        // reset query
        #$this->db->reset_query();

        return $message;
    }
    // public function getEncryption($password){
    //     $this->db->select("*,AES_ENCRYPT(`message`, 'sdca') as encrypted_pass");
    //     $this->db->where('message','sdca');
    //     $result = $this->db->get('student_inquiry');
    //     return $result->row_array();
    //     $this->db->query();
    // }
    public function createUserAccount($data){
        $this->db->insert('Users',$data);
        return $this->db->insert_id();
    }
    public function UpdateEncryptedPassword($id,$password){
        // $this->db->where('User_ID',$id);
        // $this->db->update('Users',$data);
        $this->db->query("UPDATE Users SET `Password` = AES_ENCRYPT('$password','$password') WHERE User_Id = $id");
    }
    public function UpdateUser($id,$data){
        $this->db->where('User_ID',$id);
        $this->db->update('Users',$data);
    }
    public function remove_user_roles($array_where)
    {
        $this->db->trans_start();
        $this->db->set('valid', 0);
        $this->db->where($array_where);
        $this->db->update('module_assignment');
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE)
        {
            // generate an error... or use the log_message() function to log your error
            $message = "fail to remove User Roles";
        }
        else
        {
            $message = "Remove Roles sucessful";
        } 
        
        
        // reset query
        #$this->db->reset_query();

        return $message;
    }
    public function getUserInfo($id){
        $this->db->where('User_Id',$id);
        return $this->db->get('Users')->row_array();
    }
    public function getUserTable(){
        $this->db->order_by('Users.User_FullName', 'ASC');
        return $this->db->get('Users')->result_array();
    }
    public function checkDuplicate($column,$value){
        $this->db->where($column,$value);
        return $this->db->get('Users')->row_array();
    }
    

}