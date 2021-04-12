<?php


class EnrolledStudentBed_Model extends CI_Model{
  

  public function Select_Level(){
    $this->db->select('*');
    $this->db->from('Basiced_Level');
    $this->db->Where('Grade_ID !=', '16');
    $this->db->Where('Grade_ID !=', '15');
    $query = $this->db->get();
    return $query->result_array(); 
  
  }
  

  public function GetStudentList($array){

  $this->db->select('*');
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
  if($array['Gender'] != NULL){ 
      $this->db->where('B.Gender',$array['Gender']);
      $this->db->order_by('B.Last_Name', 'ASC');
  }else{
  $this->db->where('A.SchoolYear',$array['School_year']);
  }
 $this->db->where('A.Reference_Number !=','0');
 $this->db->where('A.`GradeLevel` !=','G12');
 $this->db->where('A.`GradeLevel` !=','G11');
 $this->db->where('B.Last_Name !=','NULL');
 $this->db->where('C.Withdrawal_Fee IS NULL');
 $this->db->order_by('B.Last_Name', 'ASC');
  $query = $this->db->get();

  return $query; 
  
}



}
?>
