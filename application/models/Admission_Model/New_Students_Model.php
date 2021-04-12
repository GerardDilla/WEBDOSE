<?php


class New_Students_Model extends CI_Model{
  
  

   public function get_sem(){

      $this->db->select('*');
      $this->db->from('Semesters');
      $query = $this->db->get();
      return $query->result_array(); 
   
   }

   public function get_school_year(){

      $this->db->select('*');
      $this->db->from('SchoolYear');
      $query = $this->db->get();
      return $query->result_array(); 
   
   }
   

public function Get_New_Students($array){

   $this->db->select('*');
   $this->db->from('Student_Info AS A');
   $this->db->join('Fees_Enrolled_College AS B','A.Reference_Number = B.Reference_Number','INNER');
   $this->db->where('A.AdmittedSY =', $array['sy']);
   $this->db->where('A.AdmittedSEM =', $array['sm']);
   $this->db->where('A.Student_Number !=','0');
   $this->db->where('B.withdraw =','0');
   $this->db->group_by('A.Student_Number');
   $this->db->group_by('B.Reference_Number');
   $this->db->order_by('A.Course');
   $query = $this->db->get();

   return $query->result_array(); 

}





}
?>
