<?php


class SchedReport_Model extends CI_Model{
  
  
  public function get_schedule_list_search($sem,$sy)
  {
    $this->db->select('*,
    L.Schedule_Time AS START, 
    L2.Schedule_Time AS END,
    B.Sched_Code as SC, 
    C.id as SDI');
    $this->db->from('Sections AS A');
    $this->db->join('Sched AS B', 'A.Section_ID = B.Section_ID', 'inner');
    $this->db->join('Sched_Display AS C', 'B.Sched_Code = C.Sched_Code' ,'inner');
    //$this->db->join('Legend AS D', 'B.SchoolYear = D.School_Year AND B.Semester = D.Semester', 'inner');
    $this->db->join('`Subject` AS E', 'E.Course_Code = B.Course_Code', 'inner');
    $this->db->join('Room AS R', 'C.RoomID = R.ID');
    $this->db->join('Instructor AS I', 'I.ID = C.Instructor_ID', 'left');
    $this->db->join('`Time` AS `L`', '`C`.`Start_Time` = `L`.`Time_From`','LEFT');
    $this->db->join('`Time` AS `L2`', '`C`.`End_Time` = `L2`.`Time_To`','LEFT');
    $this->db->where('A.Active', 1);
    $this->db->where('B.Valid', 1);
    $this->db->where('C.Valid', 1);
    $this->db->where('B.Semester',$sem);
    $this->db->where('B.SchoolYear',$sy);
    $query = $this->db->get();
  
    return $query->result();
 

  }

  public function get_total_enrolled($sess)
  {
    $this->db->select('Count(Reference_Number) as total_enrolled, Sched_Code');
    $this->db->where('Sched_Code', $sess['sched_code']);
    $this->db->where('School_Year', $sess['school_year']);
    $this->db->where('Semester', $sess['semester']);
    $this->db->where('Dropped', 0);
    $query = $this->db->get('EnrolledStudent_Subjects');
  
    if($query->num_rows()> 0){
        return $query->result_array();
    }else{
        return $query->result_array();
    }

  }
  
  

                          
}
?>
