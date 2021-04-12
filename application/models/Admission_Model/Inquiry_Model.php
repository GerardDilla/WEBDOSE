<?php


class Inquiry_Model extends CI_Model{
  
  

public function Select_LevelBED(){

  $this->db->select('*');
  $this->db->from('Basiced_Level');
  $this->db->Where('Grade_ID !=', '15');
  $this->db->Where('Grade_ID !=', '16');
  $query = $this->db->get();
 
    if($query->num_rows()> 0){
       return $query->result();
  }else{
       return $query->result();
        }


}


public function Select_LevelSHS(){

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


public function Select_Knowabout(){

  $this->db->select('*');
  $this->db->from('Knowabout');
  $query = $this->db->get();
 
    if($query->num_rows()> 0){
       return $query->result();
  }else{
       return $query->result();
        }


}


public function Select_duration(){

  $this->db->select('*');
  $this->db->from('Programs');
  $this->db->group_by('Program_Duration');
  $query = $this->db->get();
 
    if($query->num_rows()> 0){
       return $query->result();
  }else{
       return $query->result();
        }


}



public function Select_religion(){

  $this->db->select('*');
  $this->db->from('religion');
  $query = $this->db->get();
 
    if($query->num_rows()> 0){
       return $query->result();
  }else{
       return $query->result();
        }


}


public function Select_course(){

  $this->db->select('*');
  $this->db->from('course');
  $query = $this->db->get();
 
    if($query->num_rows()> 0){
       return $query->result();
  }else{
       return $query->result();
        }


}








}
?>
