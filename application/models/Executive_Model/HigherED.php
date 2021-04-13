<?php


class HigherED extends CI_Model{
  

public function Get_legend(){
$this->db->select('*');
$this->db->from('Legend');
$query = $this->db->get();
return $query->result_array();

}  

public function Get_Course(){
  $this->db->select('*');
  $this->db->from('Programs');
  $this->db->Order_by('Program_Code','ASC');
  $this->db->where('Program_Code !=','0');
  $this->db->where('Program_Code !=','N/A');
  $query = $this->db->get();
  
  return $query->result_array();

}

public function Inquiry($array)
{
  $this->db->select('A.Reference_Number');
  $this->db->from('highered_inquiry_log AS A');
  $this->db->join('Fees_Enrolled_College AS B','A.Reference_Number = B.Reference_Number','LEFT');
  $this->db->where('B.course',$array['Program_Code']);
  $this->db->where('A.SchoolYear',$array['sy']);
  $this->db->where('A.Semester',$array['sem']);
  $this->db->where('A.schoolyear',$array['sy']);
  $this->db->where('A.semester',$array['sem']);
  $this->db->where('A.Reference_Number !=','0');
  $this->db->where('B.Reference_Number !=','0');

  $query = $this->db->get();
  return $query->num_rows();
}


public function Get_Enrolled($array)
{
  $this->db->select(`A`.`Reference_Number`);
  $this->db->from('Fees_Enrolled_College AS A');
  $this->db->where('A.course', $array['Program_Code']);
  $this->db->where('A.semester', $array['sem']);
  $this->db->where('A.schoolyear', $array['sy']);
  $query = $this->db->get();
  return $query->num_rows();
}

public function Get_New($array)
{
  $this->db->select(`A`.`Reference_Number`);
  $this->db->from('Fees_Enrolled_College AS A');
  $this->db->join('Student_Info AS B','A.Reference_Number = B.Reference_Number','LEFT');
  $this->db->where('A.course',$array['Program_Code']);
  $this->db->where('A.semester',$array['sem']);
  $this->db->where('A.schoolyear',$array['sy']);
  $this->db->where('B.AdmittedSEM',$array['sem']);
  $this->db->where('B.AdmittedSY',$array['sy']);
  $query = $this->db->get();
  return $query->num_rows();
}

public function Get_reserved($array)
{
  $this->db->select('A.`Reference_No`');
  $this->db->from('ReservationFee  AS A');
  $this->db->join('Student_Info AS B','A.`Reference_No` = B.`Reference_Number`','LEFT');
  $this->db->join('Fees_Enrolled_College AS C','A.`Reference_No` = C.`Reference_Number`','LEFT');
  $this->db->where('B.Course',$array['Program_Code']);
  $this->db->where('A.semester', $array['sem']);
  $this->db->where('A.schoolyear', $array['sy']);
  $this->db->where('C.`Reference_Number IS NULL');
  $query = $this->db->get();

  return $query->num_rows();
}

}
?>
