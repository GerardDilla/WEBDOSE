<?php

class Fees_Model extends CI_Model {

    public function get_scholarship_discount($fees_college_id)
    {
        $this->db->select("SUM( Scholarship_Discount) AS discount");
        $this->db->from("Fees_Enrolled_College_Item");
        $this->db->where("Fees_Enrolled_College_Id", $fees_college_id);
        $query = $this->db->get();

        $output = $query->result_array();
        return $output[0]['discount'];
    }

    public function get_total_payment($reference_number, $semester, $school_year)
    {
        $this->db->select('SUM(AmountofPayment) AS total_payment');
        $this->db->from('EnrolledStudent_Payments_Throughput');
        $this->db->where('Reference_Number', $reference_number);
        $this->db->where('Semester', $semester);
        $this->db->where('SchoolYear', $school_year);
        $this->db->where('valid', 1);
        $query = $this->db->get();

        $output = $query->result_array();
        return $output[0]['total_payment'];
    }

    public function get_hed_or($reference_number, $semester, $school_year)
    {
        $this->db->select('OR_Number');
        $this->db->from('EnrolledStudent_Payments');
        $this->db->where('Reference_Number', $reference_number);
        $this->db->where('Semester', $semester);
        $this->db->where('SchoolYear', $school_year);
        $this->db->where('valid', 1);
        $this->db->where('OR_Number IS NOT NULL');
        $query = $this->db->get();

        return $query->result_array();
        
    }
}