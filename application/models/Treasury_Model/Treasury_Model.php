<?php


class Treasury_Model extends CI_Model
{
    public function index(){

    }
    public function proof_of_payment($array)
    {
        $this->db->select('*');
        $this->db->from('requirements_log rl');
        if(!empty($array['to'])){
            $this->db->where('rl.requirements_date >=', $array['from']);
            $this->db->where('rl.requirements_date <', $array['to']);
        }
        else{
            $this->db->like('rl.requirements_date',$array['from']);
        }
        $this->db->where('rl.requirements_name','proof_of_payment');
        $this->db->join('proof_of_payment_info', 'rl.id = proof_of_payment_info.req_id', 'LEFT');
        $this->db->join('Student_Info si', 'rl.reference_no = si.Reference_Number', 'LEFT');
        $this->db->join('student_account sa', 'sa.reference_no = si.Reference_Number', 'LEFT');
        // $this->db->where('si.Student_Number !=', '');
        $this->db->where('si.Student_Number <=', 0);
        $this->db->group_by('rl.id');
        $query = $this->db->get();
        return $query->result_array();
    }
}