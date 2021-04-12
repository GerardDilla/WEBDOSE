<?php


class Carreertalk_Model extends CI_Model{
  
  

public function insert($array){

      $data = array(
          'name'           => $array['fullname'],
          's_contact'      => $array['s_number'],
          'fb_user'        => $array['fb'],
          'last_school'    => $array['last_school'],
          'g_name'         => $array['guardian_name'],
          'g_occupation'   => $array['occupation'],
          'g_number'       => $array['g_number'],
          'address'        => $array['address'],
          'first_choice'   => $array['1st'],
          'second_choice'  => $array['2nd'],
          'third_choice'   => $array['3rd'],
          'date'           => $array['date'],
          'school'         => $array['school'],
          'active'         =>   '1'
       );

    $this->db->insert('ccao_inquiry', $data);

}


public function select_inquiry($array){
  $this->db->select('*');
  $this->db->from('ccao_inquiry');
  $this->db->where('school = ', $array['school']);
  $this->db->order_by('first_choice',ASC);
  $query = $this->db->get();
  return $query;
}


function insert_import($data)
 {
  $this->db->insert_batch('ccao_inquiry', $data);
 }



 function get_dropdown_data($school)
 {
  $this->db->select('*');
  $this->db->from('ccao_inquiry');
  $this->db->where('school = ',$school);
  $this->db->where('first_choice != ','N/A');
  $this->db->where('first_choice != ','');
  $this->db->order_by('first_choice');
  $this->db->group_by('first_choice');
  $query = $this->db->get();
  return $query->result_array();
 }



}
?>
