<?php


class Others_Model extends CI_Model
{
    public function insert_logs($array_insert)
    {
        $this->db->insert('web_dose_logs', $array_insert);
    }
}