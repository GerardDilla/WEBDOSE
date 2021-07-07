<?php 

class Model_Transaction_Logs extends CI_Model{
	
	function insert_transaction_log ($reference_no, $Transaction_Detail, $view, $inquiry_type, $attendant) //inquiry type = basiced, highered
	{
		if($inquiry_type == 'highered')
		{
			$table_name = 'Student_Info';
			$student_type = 'HIGHERED';
			}
			else
			{
				$table_name = 'Basiced_Studentinfo';
				$student_type = 'BASICED';
				}
		
		$query = $this->db->query("SELECT Reference_Number, First_Name, Middle_Name, Last_Name FROM $table_name WHERE Reference_Number = '$reference_no'");

		foreach ($query->result() as $row)
		{
   			$fname = $row->First_Name;
   			$mname = $row->Middle_Name;
   			$lname = $row->Last_Name;
		}
		$fullname = $lname.', '.$fname.' '.$mname;
		
		$this->load->model('model_date_time');
		$date_now = $this->model_date_time->get_date_time();
		
		
		$data_transaction_logs = array(
   			'Reference_Number' => $reference_no,
			'Transaction_Detail' => $Transaction_Detail,
   			'Transaction_Requestor' =>  $fullname,
			'Date' =>  $date_now,
			'Student_Type' => $student_type,
			'Transaction_Attendant' => $attendant
			
			);

		$this->db->insert('Transaction_Log', $data_transaction_logs); 
		// get the id of stud info latest insert
		$insert_transaction_id = $this->db->insert_id();
		
		if($view == 1)
		{
			return $insert_transaction_id;
			}
		 
	}// end of function transaction logs
	
}// end of class