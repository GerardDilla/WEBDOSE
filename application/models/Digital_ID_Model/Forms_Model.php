<?php


class Forms_Model extends CI_Model{
    public function getDigitalCitizenship(){
        $this->db->select('*');
        $this->db->from('digital_citizenship dc');
        $this->db->join('Student_Info si','dc.reference_number = si.Reference_Number','LEFT');
        $this->db->where('dc.id >','0');
        $this->db->where('dc.reference_number >','0');
        return $this->db->get()->result_array();
    }
    public function getDigitalCitizenshipAccount($digital_id){
        $this->db->select('*');
        $this->db->from('digital_citizenship_accounts');
        $this->db->where('digital_id',$digital_id);
        $this->db->order_by('request','ASC');
        return $this->db->get()->result_array();
    }
    public function updateDigitalCitizenshipAccount($array)
    {
        $data = array(
            'status' => $array['status']
        );
        $this->db->where('id', $array['digital_id']);
        $this->db->update('digital_citizenship_accounts', $data);
    }
    public function getIdApplication(){
        $this->db->select('ia.*,
        si.*');
        $this->db->from('id_application ia');
        $this->db->join('Student_Info si','ia.reference_number = si.Reference_Number','LEFT');
        $this->db->where('ia.id >','0');
        $this->db->where('ia.reference_number >','0');
        return $this->db->get()->result_array();
    }
    public function updateIdApplication($array)
    {
        $data = array(
            'status' => $array['status']
        );
        $this->db->where('id', $array['id_application']);
        $this->db->update('id_application', $data);
        return $array['id_application'];
    }
    public function getSingleIdApplication($id){
        $this->db->select('*');
        $this->db->from('id_application ia');
        $this->db->join('Student_Info si','si.Reference_Number = ia.reference_number');
        $this->db->where('ia.id',$id);
        return $this->db->get()->row_array();
    }
}
