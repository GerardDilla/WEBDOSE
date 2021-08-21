<?php


class Forms_Model extends CI_Model
{
    public function getDigitalCitizenship($array)
    {
        $date_tom = Date('Y-m-d', strtotime($array['date_today'] . ' + 1 days'));
        $this->db->select('*');
        $this->db->from('digital_citizenship dc');
        $this->db->join('Student_Info si', 'dc.reference_number = si.Reference_Number', 'LEFT');
        $this->db->where('dc.id >', '0');
        $this->db->where('dc.reference_number >', '0');
        if (!empty($array['inquiry_from']) && !empty($array['inquiry_to'])) {
            $this->db->where('dc.created_at >=', $array['inquiry_from']);
            $this->db->where('dc.created_at <=', $array['inquiry_to']);
            // die('asdasd');
        }
        if (!empty($array['identity_no'])) {
            $this->db->where('dc.reference_number', $array['identity_no']);
            $this->db->or_Where('si.Student_Number', $array['identity_no']);
            $this->db->group_by('si.Student_Number', 'ASC');
        }
        if ($array['search'] == 0) {
            $this->db->where('dc.created_at <', $date_tom);
            $this->db->where('dc.created_at >=', $array['date_today']);
        }
        return $this->db->get()->result_array();
    }
    public function getDigitalCitizenshipAccount($digital_id)
    {
        $this->db->select('*');
        $this->db->from('digital_citizenship_accounts');
        $this->db->where('digital_id', $digital_id);
        $this->db->order_by('request', 'ASC');
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
    public function getIdApplication($array)
    {
        // echo $array['search'];
        // die($array['search']);
        $date_tom = Date('Y-m-d', strtotime($array['date_today'] . ' + 1 days'));
        // die($array['date_today']);
        $this->db->select('*');
        $this->db->from('id_application ia');
        $this->db->join('Student_Info si', 'ia.reference_number = si.Reference_Number', 'LEFT');
        $this->db->where('ia.id >', '0');
        $this->db->where('ia.reference_number >', '0');
        if (!empty($array['inquiry_from']) && !empty($array['inquiry_to'])) {
            $this->db->where('ia.created_at >=', $array['inquiry_from']);
            $this->db->where('ia.created_at <=', $array['inquiry_to']);
            // die('asdasds');
        }
        if (!empty($array['identity_no'])) {
            $this->db->where('ia.reference_number', $array['identity_no']);
            $this->db->or_Where('si.Student_Number', $array['identity_no']);
            $this->db->group_by('si.Student_Number', 'ASC');
        }
        if ($array['search'] == 0) {
            $this->db->where('ia.created_at <', $date_tom);
            $this->db->where('ia.created_at >=', $array['date_today']);
        }
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
    public function getSingleIdApplication($id)
    {
        $this->db->select('*');
        $this->db->from('id_application ia');
        $this->db->join('Student_Info si', 'si.Reference_Number = ia.reference_number');
        $this->db->where('ia.id', $id);
        return $this->db->get()->row_array();
    }
}
