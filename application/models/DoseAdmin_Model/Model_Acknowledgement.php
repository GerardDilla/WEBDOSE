<?php 
class Model_Acknowledgement extends CI_Model{
	
	
	function get_num($reference_number)
	{
		$this->db->select('AR_Number');
		$this->db->from('Acknowledgement_Receipt');
		$this->db->where('Reference_Number', $reference_number); 
		$query = $this->db->get();
		
		foreach ($query->result() as $row)
		{
			$output = $row->AR_Number;
			}
		return $output;
		}
		
	function insert_acknowledge($reference_number, $payment_amount, $transaction_type, $transaction_item, $transaction_attendant, $payment_location, $valid, $student_type)
	{
		if($student_type == 'highered')
		{
			$table_name = 'Student_Info';
			$level = 'YearLevel';
			}
			else
			{
				$table_name = 'Basiced_Studentinfo';
				$level = 'Gradelevel';
				}
		
		$query = $this->db->query("
			SELECT A.$level, B.Semester, B.School_year 
			FROM $table_name AS A 
			JOIN Legend AS B 
			WHERE A.Reference_Number = '$reference_number'
			");
		foreach ($query->result() as $row)
		{
			$year_level = $row->$level;
			$semester = $row->Semester;
			$school_year = $row->School_year;
			}
		
		$this->load->model('model_date_time');
		$date_time = $this->model_date_time->get_date_time();
		
		
		$data = array(
		   'Reference_Number' => $reference_number,
		   'AmountofPayment' => $payment_amount,
		   'Transaction_Type' => $transaction_type,
		   'Transaction_Item' => $transaction_item,
		   'Semester' => $semester,
		   'SchoolYear' => $school_year,
		   'SchoolLevel' => $student_type,
		   'Transaction_Attendant' => $transaction_attendant,
		   'Transaction_Date' => $date_time,
		   'Location' => $payment_location,
		   'Valid' => $valid
		);
		
		$this->db->insert('Acknowledgement_Receipt', $data); 
		
		$acknowledge_receipt_number = $this->db->insert_id();
		
		return $acknowledge_receipt_number;
	}
}