<?php


class Policy_Model extends CI_Model
{
    public function insert_agreement($array_insert)
    {
        $this->db->insert('privacy_policy_agreement', $array_insert);
        return $this->db->insert_id();
    }
    public function check_privacy_agreement($array){

        $this->db->where('System',$array['System']);
        $this->db->where('Reference_Number',$array['Reference_Number']);
        $this->db->where('active',1);
        $result = $this->db->get('privacy_policy_agreement');
        return $result->num_rows();
    }
}