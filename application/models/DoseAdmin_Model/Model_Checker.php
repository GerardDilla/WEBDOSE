<?php 

class Model_Checker extends CI_Model{
	
	function check_enrolled($reference_number, $student_type)
	{
		if($student_type == 'highered')
		{
			$table_name = 'Student_Info';
			}
			else
			{
				$table_name = 'Basiced_Studentinfo';
				}
		
		$query = $this->db->query("
			SELECT Student_Number 
			FROM $table_name
			WHERE Reference_Number = '$reference_number'
		");
		
		foreach ($query->result() as $row)
		{
			$Student_Number = $row->Student_Number;
			}
		
		return $Student_Number;
		
		}
		
	function check_reserved($reference_number, $student_type)
	{
		if($student_type == 'highered')
		{
			$table_name = 'EnrolledStudent_Payments';
			}
			else
			{
				$table_name = 'Basiced_Payments';
				}
		$this->db->select('COUNT(Reference_Number) as counted_row');
		$this->db->from($table_name);
		$this->db->where('Reference_Number', $reference_number);
		$query = $this->db->get();
		
		$rowcount = $query->row_array();
		// $rowcount = $query->result_array();
		return $rowcount;
		
	}
	
	function account_checker($acc_no, $bank_name)
	{
		
		$this->db->select('Bank, Depositslip_Number, Amount');
		$this->db->from('Depositslip');
		$this->db->where('Depositslip_Number', $acc_no);
		$this->db->where('Bank', $bank_name);
		$query = $this->db->get();
		
		$rowcount = $query->num_rows();
		
		if($rowcount > 0)
		{
			foreach ($query->result() as $row)
			{
				$Bank = $row->Bank;
				$Depositslip_Number = $row->Depositslip_Number;
				$Amount = $row->Amount;
			
				}
			$array_output[] = array(
				'bank_name' => $Bank,
				'depositslip_number' => $Depositslip_Number,
				'amount' => $Amount
			);
			
			return $array_output;
			
			}
			else
			{
				return NULL;
				}
		
		
	}
	
}// end of class