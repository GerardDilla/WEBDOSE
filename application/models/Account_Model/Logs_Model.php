<?php


class Logs_Model extends CI_Model
{
    public function insert_transaction_logs($array_data)
    {
        
        $this->db->insert('web_dose_user_logs', $array_data);
        
        // reset query
        //$this->db->reset_query();

       
    }

    
}