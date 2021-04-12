<?php


class shs extends CI_Model{
  

public function Get_SchoolYear(){
$this->db->select('*');
$this->db->from('Legend');
$query = $this->db->get();
return $query->result_array();

}  
public function Select_Level(){
$this->db->select('*');
$this->db->from('Basiced_Level');
$this->db->Where('Grade_ID !=', '15');
$this->db->Where('Grade_ID !=', '16');
$query = $this->db->get();
return $query->result_array();

}

public function Select_Strand(){

  $this->db->select('*');
  $this->db->from('SeniorHigh_Strand');
  $query = $this->db->get();
  return $query->result_array();
}

//BasicED Inquiry
public function Inquiry($array)
{
  $this->db->select('A.Reference_Number');
  $this->db->from('seniorhigh_inquiry_log AS A');
  $this->db->join('Basiced_Studentinfo AS B','A.Reference_Number = B.Reference_Number','LEFT');
  $this->db->where('B.Strand',$array['Strand_Code']);
  $this->db->where('A.SchoolYear',$array['sy']);
  $this->db->where('A.Reference_Number !=','0');
  $this->db->where('B.Reference_Number !=','0');

  $query = $this->db->get();
  return $query->num_rows();
}

//RESERVE Basiced
public function RESERVE($array)
{
  $this->db->select('A.Reference_No');
  $this->db->from('Basiced_ReservationFee AS A');
  $this->db->join('Basiced_EnrolledFees_Local AS B','A.Reference_No = B.Reference_Number','LEFT');
  $this->db->where('A.SchoolYear',$array['sy']);
  $this->db->where('B.Strand',$array['Strand_Code']);
  $this->db->where('B.`GradeLevel` !=','N');
  $this->db->where('B.`GradeLevel` !=','K1');
  $this->db->where('B.`GradeLevel` !=','K2');
  $this->db->where('B.`GradeLevel` !=','G1');
  $this->db->where('B.`GradeLevel` !=','G2');
  $this->db->where('B.`GradeLevel` !=','G3');
  $this->db->where('B.`GradeLevel` !=','G4');
  $this->db->where('B.`GradeLevel` !=','G5');
  $this->db->where('B.`GradeLevel` !=','G6');
  $this->db->where('B.`GradeLevel` !=','G7');
  $this->db->where('B.`GradeLevel` !=','G8');
  $this->db->where('B.`GradeLevel` !=','G9');
  $this->db->where('B.`GradeLevel` !=','G10');
  $this->db->where('B.Reference_Number !=','0');
  $this->db->where('A.`Applied` =','0'); 
  $query = $this->db->get();

  return $query->num_rows();

}

//NEW ENROLLED
public function NewStudents($array)
{
  $this->db->select('A.Student_Number');
  $this->db->from('Basiced_EnrolledFees_Local AS A');
  $this->db->join('Basiced_Studentinfo AS B','A.Reference_Number = B.Reference_Number','LEFT');
  $this->db->join('Basiced_WithdrawInformation AS C','C.Student_Number = A.Student_Number','LEFT');
  $this->db->where('A.Strand',$array['Strand_Code']);
  $this->db->where('A.SchoolYear',$array['sy']);
  $this->db->where('A.Reference_Number != ','0');
  $this->db->where('C.Withdrawal_Fee IS NULL');
  $this->db->where('B.`GradeLevel` !=','N');
  $this->db->where('B.`GradeLevel` !=','K1');
  $this->db->where('B.`GradeLevel` !=','K2');
  $this->db->where('B.`GradeLevel` !=','G1');
  $this->db->where('B.`GradeLevel` !=','G2');
  $this->db->where('B.`GradeLevel` !=','G3');
  $this->db->where('B.`GradeLevel` !=','G4');
  $this->db->where('B.`GradeLevel` !=','G5');
  $this->db->where('B.`GradeLevel` !=','G6');
  $this->db->where('B.`GradeLevel` !=','G7');
  $this->db->where('B.`GradeLevel` !=','G8');
  $this->db->where('B.`GradeLevel` !=','G9');
  $this->db->where('B.`GradeLevel` !=','G10');
  $this->db->where('B.`AdmittedSY` =',$array['sy']);
  $query = $this->db->get();

  return $query->num_rows();
  
}

public function Enrolled($array)
{
  $this->db->select('A.Student_Number');
  $this->db->from('Basiced_EnrolledFees_Local AS A');
  $this->db->join('Basiced_WithdrawInformation AS C','C.Student_Number = A.Student_Number','LEFT');
  $this->db->where('A.Strand',$array['Strand_Code']);
  $this->db->where('A.SchoolYear',$array['sy']);
  $this->db->where('A.Reference_Number !=','0');
  $this->db->where('A.`GradeLevel` !=','N');
  $this->db->where('A.`GradeLevel` !=','K1');
  $this->db->where('A.`GradeLevel` !=','K2');
  $this->db->where('A.`GradeLevel` !=','G1');
  $this->db->where('A.`GradeLevel` !=','G2');
  $this->db->where('A.`GradeLevel` !=','G3');
  $this->db->where('A.`GradeLevel` !=','G4');
  $this->db->where('A.`GradeLevel` !=','G5');
  $this->db->where('A.`GradeLevel` !=','G6');
  $this->db->where('A.`GradeLevel` !=','G7');
  $this->db->where('A.`GradeLevel` !=','G8');
  $this->db->where('A.`GradeLevel` !=','G9');
  $this->db->where('A.`GradeLevel` !=','G10');
  $this->db->where('C.Withdrawal_Fee IS NULL');
  $query = $this->db->get();

  return $query->num_rows();
  
}




}
?>
