<?php


class Room_Model extends CI_Model{
  
  

public function Get_time(){
  $this->db->select('*');
  $this->db->from('Time');
  $query = $this->db->get();
  return $query->result_array();	                           
}


public function Get_room(){
  $this->db->select('*');
  $this->db->from('Room');
  $query = $this->db->get();
  return $query->result_array();
	                           
}

public function Get_instructor(){
  $this->db->select('*');
  $this->db->from('Instructor');
  $query = $this->db->get();
  return $query->result_array();

}

public function Get_section(){
  $this->db->select('*');
  $this->db->from('Sections');
  $this->db->where('Active',1);
  $query = $this->db->get();
  return $query->result_array();
}

public function Get_legend(){
  $this->db->select('*');
  $this->db->from('Legend');
  $query = $this->db->get();
  return $query->result_array();
}

public function Get_subject(){
  $this->db->select('*');
  $this->db->from('Subject');
  $query = $this->db->get();
  return $query->result_array();
}

public function Get_programs(){
  $this->db->select('*');
  $this->db->from('Programs');
  $query = $this->db->get();
  return $query->result_array();
}

public function get_coursecode($courseID){
  $this->db->select('*');
  $this->db->from('Subject');
  $this->db->where('Course_Code', $courseID);
  $query = $this->db->get();
  return $query->result_array();
}

//get section list. change the name later to get_section
public function get_program($programID){
  $this->db->select('*');
  $this->db->from('Sections');
  $this->db->join('Programs','Programs.Program_ID = Sections.Program_ID');
  $this->db->where('Sections.Program_ID',$programID);
  $this->db->where('Sections.Active','1');

  $query = $this->db->get();
  return $query->result_array();
}

public function save_sched_code($data){
  
  $this->db->insert('Sched_Display',$data);
  $query_log = $this->db->last_query();
  // reset query
  $this->db->reset_query();

  return $query_log;
}

public function save_sched($data){
 
  $this->db->insert('Sched',$data);
  return $this->db->insert_id();
}

public function checksched(){
  $this->db->select('Sched.sSched_Code,Subject.Course_Code,Subject.Course_Title,Sections.Section_Name,Subject.Course_Lec_Unit,Subject.Course_Lab_Unit,Sched.Total_Slot');
  $this->db->from('Sched');
  $this->db->join('Subject', 'Sched.Course_Code = Subject.ID');
  $this->db->join('Sections','Sched.Section_ID = Sections.Section_ID');
  $query = $this->db->get();
  return $query->result_array();
}

  //get the list of given sched
  //get schedcode schedules
  public function get_schedule_list($array_data)
  {
    $this->db->select('*, C.id AS sched_display_id');
    $this->db->from('Sections AS A');
    $this->db->join('Sched AS B', 'A.Section_ID = B.Section_ID', 'inner');
    $this->db->join('Sched_Display AS C', 'B.Sched_Code = C.Sched_Code' ,'inner');
    //$this->db->join('Legend AS D', 'B.SchoolYear = D.School_Year AND B.Semester = D.Semester', 'inner');
    $this->db->join('`Subject` AS E', 'E.Course_Code = B.Course_Code', 'inner');
    $this->db->join('Room AS R', 'C.RoomID = R.ID');
    $this->db->join('Instructor AS I', 'I.ID = C.Instructor_ID', 'left');
    $this->db->where('A.Active', 1);
    $this->db->where('B.Valid', 1);
    $this->db->where('C.Valid', 1);
    $this->db->where('B.Sched_Code', $array_data['sched_code']);
    $this->db->where('B.Semester', $array_data['semester']);
    $this->db->where('B.SchoolYear', $array_data['sy']);

    $query = $this->db->get();
    // reset query
    $this->db->reset_query();
    return $query->result_array();
  }

  public function get_schedule_list_search($array_data)
  {
    $this->db->select('*,C.Start_Time AS START, 
    C.End_Time AS END, C.id AS sched_display_id');
    $this->db->from('Sections AS A');
    $this->db->join('Sched AS B', 'A.Section_ID = B.Section_ID', 'inner');
    $this->db->join('Sched_Display AS C', 'B.Sched_Code = C.Sched_Code' ,'inner');
    //$this->db->join('Legend AS D', 'B.SchoolYear = D.School_Year AND B.Semester = D.Semester', 'inner');
    $this->db->join('`Subject` AS E', 'E.Course_Code = B.Course_Code', 'inner');
    $this->db->join('Room AS R', 'C.RoomID = R.ID');
    $this->db->join('Instructor AS I', 'I.ID = C.Instructor_ID', 'left');
    $this->db->group_start();
      $this->db->like('B.Sched_Code', $array_data['search']);
      $this->db->or_like('E.Course_Code', $array_data['search']);
      $this->db->or_like('E.Course_Title', $array_data['search']);
      $this->db->or_like('A.Section_Name', $array_data['search']);
      $this->db->or_like('A.Program_ID', $array_data['search']);
    $this->db->group_end();
    $this->db->group_start();
      $this->db->where('A.Active', 1);
      $this->db->where('B.Valid', 1);
      $this->db->where('C.Valid', 1);
      $this->db->where('B.Semester', $array_data['semester']);
      $this->db->where('B.SchoolYear', $array_data['sy']);
    $this->db->group_end();
    $this->db->limit($array_data['perpage'],$array_data['offset']);

    $query = $this->db->get();
    // reset query
    $this->db->reset_query();

    return $query->result_array();
  }

  public function get_schedule_list_search_program($array_data)
  {
    $this->db->select('*,C.Start_Time AS START, 
    C.End_Time AS END, C.id AS sched_display_id');
    $this->db->from('Sections AS A');
    $this->db->join('Sched AS B', 'A.Section_ID = B.Section_ID', 'inner');
    $this->db->join('Sched_Display AS C', 'B.Sched_Code = C.Sched_Code' ,'inner');
    //$this->db->join('Legend AS D', 'B.SchoolYear = D.School_Year AND B.Semester = D.Semester', 'inner');
    $this->db->join('`Subject` AS E', 'E.Course_Code = B.Course_Code', 'inner');
    $this->db->join('Room AS R', 'C.RoomID = R.ID');
    $this->db->join('Instructor AS I', 'I.ID = C.Instructor_ID', 'left');
    $this->db->group_start();
      $this->db->like('B.Sched_Code', $array_data['search']);
      $this->db->or_like('E.Course_Code', $array_data['search']);
      $this->db->or_like('E.Course_Title', $array_data['search']);
      $this->db->or_like('A.Section_Name', $array_data['search']);
    $this->db->group_end();
    if($array_data['program'] != ''){
      $this->db->where('A.Program_ID', $array_data['program']);
    }
    $this->db->group_start();
      $this->db->where('A.Active', 1);
      $this->db->where('B.Valid', 1);
      $this->db->where('C.Valid', 1);
      $this->db->where('B.Semester', $array_data['semester']);
      $this->db->where('B.SchoolYear', $array_data['sy']);
    $this->db->group_end();
    $this->db->limit($array_data['perpage'],$array_data['offset']);

    $query = $this->db->get();
    // reset query
    $this->db->reset_query();

    return $query->result_array();
  }

  public function get_schedule_list_search_count($array_data)
  {
    $this->db->select('*, C.id AS sched_display_id');
    $this->db->from('Sections AS A');
    $this->db->join('Sched AS B', 'A.Section_ID = B.Section_ID', 'inner');
    $this->db->join('Sched_Display AS C', 'B.Sched_Code = C.Sched_Code' ,'inner');
    //$this->db->join('Legend AS D', 'B.SchoolYear = D.School_Year AND B.Semester = D.Semester', 'inner');
    $this->db->join('`Subject` AS E', 'E.Course_Code = B.Course_Code', 'inner');
    $this->db->group_start();
      $this->db->like('B.Sched_Code', $array_data['search']);
      $this->db->or_like('E.Course_Code', $array_data['search']);
      $this->db->or_like('E.Course_Title', $array_data['search']);
      $this->db->or_like('A.Section_Name', $array_data['search']);
      $this->db->or_like('A.Program_ID', $array_data['search']);
    $this->db->group_end();
    $this->db->group_start();
      $this->db->where('A.Active', 1);
      $this->db->where('B.Valid', 1);
      $this->db->where('C.Valid', 1);
      $this->db->where('B.Semester', $array_data['semester']);
      $this->db->where('B.SchoolYear', $array_data['sy']);
    $this->db->group_end();
    $query = $this->db->get();
    // reset query
    $this->db->reset_query();

    return $query->num_rows();
  }

  public function get_schedule_list_search_program_count($array_data)
  {
    $this->db->select('*, C.id AS sched_display_id');
    $this->db->from('Sections AS A');
    $this->db->join('Sched AS B', 'A.Section_ID = B.Section_ID', 'inner');
    $this->db->join('Sched_Display AS C', 'B.Sched_Code = C.Sched_Code' ,'inner');
    //$this->db->join('Legend AS D', 'B.SchoolYear = D.School_Year AND B.Semester = D.Semester', 'inner');
    $this->db->join('`Subject` AS E', 'E.Course_Code = B.Course_Code', 'inner');
    $this->db->group_start();
      $this->db->like('B.Sched_Code', $array_data['search']);
      $this->db->or_like('E.Course_Code', $array_data['search']);
      $this->db->or_like('E.Course_Title', $array_data['search']);
      $this->db->or_like('A.Section_Name', $array_data['search']);
    $this->db->group_end();
    if($array_data['program'] != ''){
      $this->db->where('A.Program_ID', $array_data['program']);
    }
    $this->db->group_start();
      $this->db->where('A.Active', 1);
      $this->db->where('B.Valid', 1);
      $this->db->where('C.Valid', 1);
      $this->db->where('B.Semester', $array_data['semester']);
      $this->db->where('B.SchoolYear', $array_data['sy']);
    $this->db->group_end();
    $query = $this->db->get();
    // reset query
    $this->db->reset_query();

    return $query->num_rows();
  }
  
  //get the shcedule witihin the room
  public function get_room_sched($array_data)
  {
    $this->db->select('SD.Sched_Code,SD.Start_Time, SD.End_Time, SD.Day, SD.RoomID, I.Instructor_Name, S.Course_Code');
    $this->db->from('Sched_Display AS SD');
    $this->db->join('Sched AS S', 'S.Sched_Code = SD.Sched_Code');
    //$this->db->join('Legend AS L', 'S.SchoolYear = L.School_Year AND S.Semester = L.Semester');
    $this->db->join('Instructor AS I', 'I.ID = SD.Instructor_ID', 'left');
    $this->db->where('SD.RoomID', $array_data['room_id']);
    $this->db->where('S.Valid', 1);
    $this->db->where('SD.Valid', 1);
    $this->db->where('S.Semester', $array_data['semester']);
    $this->db->where('S.SchoolYear', $array_data['sy']);
    $this->db->order_by('SD.Start_Time');

    $query = $this->db->get();

    // reset query
    $this->db->reset_query();

    return $query->result_array();

  }

}
?>
