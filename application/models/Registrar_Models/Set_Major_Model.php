<?php

class Set_Major_Model extends CI_Model{
  
  
public function GetInfo($student_number){

  $this->db->select('*');
  $this->db->where('Student_Number ',$student_number);
  $this->db->join('Program_Majors AS B','A.Major = B.ID');
  $this->db->from('Student_Info AS A');
  $query = $this->db->get();
  return $query->result_array();

}


public function SelectMajor(){

  $this->db->select('*');
  $this->db->from('Program_Majors');
  $this->db->where('Program_Major !=','N/A');
  $query = $this->db->get();
  return $query->result_array();

}


public function UpdateMajor($array){

  $this->db->set('Major',$array['Major'] );
  $this->db->where('Reference_Number =',$array['ref_num']);
  $this->db->where('Student_Number =',$array['stu_num']);
  $this->db->update('Student_Info');

  $query_log = $this->db->last_query();
  return $query_log;

}







                          
}
?>
