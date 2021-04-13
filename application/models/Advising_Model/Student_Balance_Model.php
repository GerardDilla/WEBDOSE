<?php


class Student_Balance_Model extends CI_Model{

    
    public function getOutstandingbal($array){

		$this->db->select('
		SUM(InitialPayment + First_Pay + Second_Pay + Third_Pay + Fourth_Pay) AS Fees,
		semester,
		schoolyear
		');
		$this->db->where('Reference_Number',$array['Reference_Number']);
		$result = $this->db->get('Fees_Enrolled_College');
		return $result->result_array();

	}
	public function gettotalpaid($array){

		$this->db->select('
			SUM(AmountofPayment) AS AmountofPayment,
			semester, 
			schoolyear
		');
		$this->db->where('Reference_Number',$array['Reference_Number']);
		$result = $this->db->get('EnrolledStudent_Payments_Throughput');
		return $result->result_array();

	}

	public function GetTotalAndPaid($array){

		$query = '
		
			SELECT 
			SUM(`TOTAL`) as `TOTAL`,
			SUM(`PAID`) as `PAID`
			FROM
			(SELECT 
				`fees`.`withdraw` AS `WITHDRAW`,
				CONCAT(
				`fees`.`semester`,
				"|",
				`fees`.`schoolyear`
				) AS `SEMESTER|SY`,
				IF(
				`fees`.`withdraw` < 1,
				(
					`fees`.`tuition_Fee` + SUM(
					(
						CASE
						WHEN (`FECI`.`Fees_Type` = "MISC") 
						THEN `FECI`.`Fees_Amount` 
						ELSE 0.00 
						END
					)
					) + SUM(
					(
						CASE
						WHEN (`FECI`.`Fees_Type` = "OTHER") 
						THEN `FECI`.`Fees_Amount` 
						ELSE 0.00 
						END
					)
					) + SUM(
					(
						CASE
						WHEN (`FECI`.`Fees_Type` = "LAB") 
						THEN `FECI`.`Fees_Amount` 
						ELSE 0.00 
						END
					)
					)
				),
				(SELECT 
					`fees`.`withdrawalfee` 
				FROM
					WithdrawInformation 
				WHERE Student_Number = '.$array['Student_Number'].' 
					AND semester = `fees`.`semester` 
					AND SchoolYear = `fees`.SchoolYear 
				LIMIT 1)
				) AS `TOTAL`,
				(SELECT 
				SUM(AmountofPayment) 
				FROM
				EnrolledStudent_Payments_Throughput 
				WHERE Reference_Number = `fees`.`Reference_Number` 
				AND semester = `fees`.`semester` 
				AND schoolyear = `fees`.`schoolyear`
				AND itemPaid != "Excess"
				AND valid) AS `PAID` 
			FROM
				Fees_Enrolled_College AS `fees` 
				INNER JOIN `Fees_Enrolled_College_Item` AS `FECI` 
				ON `fees`.`id` = `FECI`.`Fees_Enrolled_College_Id` 
				AND `FECI`.`valid` 
			WHERE `fees`.`Reference_Number` = "'.$array['Reference_Number'].'" 
			GROUP BY `SEMESTER|SY` 
			) a 
		';
		$result = $this->db->query($query);
		return $result->result_array();

	}

	public function GetDiscounts($array){
		
		$this->db->select('
		SUM(discount) as Discounts
		');
		$this->db->where('Reference_Number',$array['Reference_Number']);
		$result = $this->db->get('Fees_Enrolled_College');
		return $result->result_array();

	}

	public function GetExcludedStudents($array){

		$this->db->where('Reference_Number',$array['Reference_Number']);
		$this->db->where('Student_Number',$array['Student_Number']);
		$this->db->where('SchoolYear',$array['SchoolYear']);
		$this->db->where('Semester',$array['Semester']);
		$this->db->where('schoolLevel','HigherED');
		$this->db->where('valid',1);
		$result = $this->db->get('approve_Payment');
		return $result->num_rows();

	}

}