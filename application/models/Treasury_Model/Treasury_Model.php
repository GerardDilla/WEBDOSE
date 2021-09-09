<?php


class Treasury_Model extends CI_Model
{
    public function index(){

    }
    public function proof_of_payment($array)
    {
        $this->db->select('*');
        $this->db->from('requirements_log rl');
        $this->db->join('proof_of_payment_info', 'rl.id = proof_of_payment_info.req_id', 'LEFT');
        $this->db->join('Student_Info si', 'rl.reference_no = si.Reference_Number', 'LEFT');
        $this->db->join('student_account sa', 'sa.reference_no = si.Reference_Number', 'LEFT');
        // $this->db->where('si.Student_Number !=', '');
        if(!empty($array['to'])){
            $this->db->where('rl.requirements_date >=', $array['from']);
            $this->db->where('rl.requirements_date <', $array['to']);
        }
        else{
            $this->db->like('rl.requirements_date',$array['from']);
        }
        $this->db->where('rl.requirements_name','proof_of_payment');
        // $this->db->where('si.Student_Number <=', 0);
        $this->db->where('si.Reference_Number >', 0);
        $this->db->group_by('rl.id');
        $query = $this->db->get();
        return $query->result_array();
    }
    public function updateProofofPaymentWithReqID($data,$id){
        $this->db->where('req_id',$id);
        $this->db->update('proof_of_payment_info',$data);
    }
    public function getStudentInfowithReqID($id){
        $this->db->select('*,si.Email as Student_Email');
        $this->db->from('proof_of_payment_info as pi');
        $this->db->join('requirements_log as rl','pi.req_id = rl.id','left');
        $this->db->join('Student_Info as si','pi.ref_no = si.Reference_Number','left');
        $this->db->where('pi.req_id',$id);
        $query = $this->db->get();
        return $query->row_array();
    }
    public function insertTransactionLog($data){
        $this->db->insert('Transaction_Log',$data);
    }
}