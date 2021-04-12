<?php


class Shs_Model extends CI_Model{
  
  

public function Select_Level(){

  $this->db->select('*');
  $this->db->from('Basiced_Level');
  $this->db->Where('Grade_ID !=', '1');
  $this->db->Where('Grade_ID !=', '2');
  $this->db->Where('Grade_ID !=', '3');
  $this->db->Where('Grade_ID !=', '4');
  $this->db->Where('Grade_ID !=', '5');
  $this->db->Where('Grade_ID !=', '6');
  $this->db->Where('Grade_ID !=', '7');
  $this->db->Where('Grade_ID !=', '8');
  $this->db->Where('Grade_ID !=', '9');
  $this->db->Where('Grade_ID !=', '10');
  $this->db->Where('Grade_ID !=', '11');
  $this->db->Where('Grade_ID !=', '12');
  $this->db->Where('Grade_ID !=', '13');
  $this->db->Where('Grade_ID !=', '14');

  $query = $this->db->get();
 
  return $query;  

}




public function Select_Strand(){

  $this->db->select('*');
  $this->db->from('SeniorHigh_Strand');
  $query = $this->db->get();
 
    if($query->num_rows()> 0){
       return $query->result();
  }else{
       return $query->result();
        }

}

//Inquiry NEW STUDENT
public function Inquiry($array)
{
  $this->db->select('Count(A.Reference_Number) AS REF');
  $this->db->from('Transaction_Log AS A');
  $this->db->join('Basiced_Studentinfo AS B','A.Reference_Number = B.Reference_Number','INNER');
  $this->db->where('B.GradeLevel',$array['gradlvl']);
  $this->db->where('B.AdmittedSY',$array['sy']);
  $this->db->where('B.Strand',$array['Strand_Code']);
  $this->db->where('A.Reference_Number !=','0');
  $this->db->where('B.`AdmittedSY` = ',$array['sy']); 
  $this->db->where('A.`Student_Type`=','BASICED'); 
  $query = $this->db->get();

  if($query->num_rows()> 0){
    return $query->result();
 }else{
    return $query->result();
 }
  
}



//TAKER NEW STUDENT

public function Taker($array)
{
  $this->db->select('Count(A.Reference_Number) AS REF');
  $this->db->from('Guidance_BasicEdExamination AS A');
  $this->db->join('Basiced_Studentinfo AS B','A.Reference_Number = B.Reference_Number','INNER');
  $this->db->where('B.GradeLevel', $array['gradlvl']);
  $this->db->where('B.Strand', $array['Strand_Code']);
  $this->db->where('A.School_Year',$array['sy']);
  $this->db->where('A.Reference_Number !=','0');
  $this->db->where('B.`AdmittedSY` =',$array['sy']); 
  $query = $this->db->get();

  if($query->num_rows()> 0){
    return $query->result();
 }else{
    return $query->result();
 }
  
}


//RESERVE NEW
public function New_RESERVE($array)
{
  $this->db->select('Count(A.Reference_No) AS REF');
  $this->db->from('Basiced_ReservationFee AS A');
  $this->db->join('Basiced_Studentinfo AS B','A.Reference_No = B.Reference_Number','INNER');
  $this->db->where('B.GradeLevel',$array['gradlvl']);
  $this->db->where('B.Strand', $array['Strand_Code']);
  $this->db->where('B.AdmittedSY',$array['sy']);
  $this->db->where('B.Reference_Number !=','0');
  $this->db->where('B.`AdmittedSY` =',$array['sy']); 
  $this->db->where('A.`Applied` =','0'); 
  $query = $this->db->get();

  if($query->num_rows()> 0){
    return $query->result();
 }else{
    return $query->result();
 }
  
}


//RESERVE NEW
public function OLD_RESERVE($array)
{
  $this->db->select('Count(A.Reference_No) AS REF');
  $this->db->from('Basiced_ReservationFee AS A');
  $this->db->join('Basiced_Studentinfo AS B','A.Reference_No = B.Reference_Number','INNER');
  $this->db->join('Basiced_WithdrawInformation AS C','C.Student_Number = B.Student_Number','LEFT');
  $this->db->where('B.GradeLevel',$array['gradlvl']);
  $this->db->where('B.Strand', $array['Strand_Code']);
  $this->db->where('B.AdmittedSY',$array['sy']);
  $this->db->where('B.Reference_Number !=','0');
  $this->db->where('B.`AdmittedSY` !=',$array['sy']); 
  $this->db->where('C.Withdrawal_Fee IS NULL');
  $this->db->where('A.`Applied` =','0'); 
  $query = $this->db->get();

  if($query->num_rows()> 0){
    return $query->result();
 }else{
    return $query->result();
 }
  
}


//NEW ENROLLED
public function Get_New_Enrolled($array)
{
  $this->db->select('Count(A.Reference_Number) AS REF');
  $this->db->from('Basiced_EnrolledFees_Local AS A');
  $this->db->join('Basiced_Studentinfo AS B','A.Reference_Number = B.Reference_Number','INNER');
 $this->db->join('Basiced_WithdrawInformation AS C','C.Student_Number = B.Student_Number','LEFT');
  $this->db->where('A.GradeLevel',$array['gradlvl']);
  $this->db->where('A.Strand', $array['Strand_Code']);
  $this->db->where('A.SchoolYear',$array['sy']);
  $this->db->where('A.Reference_Number !=','0');
  $this->db->where('B.`AdmittedSY` =',$array['sy']);
  $this->db->where('C.Withdrawal_Fee IS NULL');
  $query = $this->db->get();

  if($query->num_rows()> 0){
    return $query->result();
 }else{
    return $query->result();
 }
  
}


//OLD ENROLLED
public function Get_OLD_Enrolled($array)
{
  $this->db->select('Count(A.Reference_Number) AS REF');
  $this->db->from('Basiced_EnrolledFees_Local AS A');
  $this->db->join('Basiced_Studentinfo AS B','A.Reference_Number = B.Reference_Number','INNER');
  $this->db->where('A.GradeLevel',$array['gradlvl']);
  $this->db->where('A.Strand', $array['Strand_Code']);
  $this->db->where('A.SchoolYear',$array['sy']);
  $this->db->where('A.Reference_Number !=','0');
  $this->db->where('B.`AdmittedSY` !=',$array['sy']);
  $query = $this->db->get();

  if($query->num_rows()> 0){
    return $query->result();
 }else{
    return $query->result();
 }
  
}








}
?>
