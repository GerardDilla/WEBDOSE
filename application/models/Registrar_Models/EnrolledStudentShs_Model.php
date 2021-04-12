<?php


class EnrolledStudentShs_Model extends CI_Model{
  

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
    return $query->result_array(); 
  
  }
  
  

  public function Select_Strand(){
    $this->db->select('*');
    $this->db->from('SeniorHigh_Strand');
    $query = $this->db->get();
    return $query->result_array(); 

  }



  public function GetStudentList($array){

  $this->db->select('*,A.Strand AS ST');
  $this->db->from('Basiced_EnrolledFees_Local AS A');
  $this->db->join('Basiced_WithdrawInformation AS C','C.Student_Number = A.Student_Number','LEFT');
  $this->db->join('Basiced_Studentinfo AS B','B.Reference_Number = A.Reference_Number','LEFT');
  if($array['School_year'] != NULL){
    $this->db->where('A.SchoolYear',$array['School_year']);
    $this->db->order_by('B.Last_Name', 'ASC');
  }
  if($array['GLVL'] != NULL){
    $this->db->where('A.GradeLevel',$array['GLVL']);
    $this->db->order_by('B.Last_Name', 'ASC');
  }
  if($array['Strand'] != NULL){
    $this->db->where('A.Strand',$array['Strand']);
    $this->db->order_by('B.Last_Name', 'ASC');
  }
  if($array['Gender'] != NULL){ 
      $this->db->where('B.Gender',$array['Gender']);
      $this->db->order_by('B.Last_Name', 'ASC');
  }else{
  $this->db->where('A.SchoolYear',$array['School_year']);
  }
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
 $this->db->where('B.Last_Name !=','NULL');
 $this->db->where('C.Withdrawal_Fee IS NULL');
 $this->db->order_by('B.Last_Name', 'ASC');
  $query = $this->db->get();

  return $query; 
  
}



}
?>
