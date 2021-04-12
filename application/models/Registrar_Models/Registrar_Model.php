<?php


class Registrar_Model extends CI_Model{
  
  

public function Get_Latest_SEM(){
  $this->db->select('Semester');
  $this->db->from('Legend');
  $query = $this->db->get();
  return $query;
	
                                  
}

public function Get_Latest_School_Year(){
  $this->db->select('*');
  $this->db->from('Legend');
  $query = $this->db->get();
  return $query;
                                  
}

public function GetSEM(){
  $this->db->select('Semester');
  $this->db->group_by('Semester'); 
  $query = $this->db->get('Fees_Enrolled_College');
  return $query;
                                  
}

public function GetYEAR(){
  $this->db->select('schoolyear');
  $this->db->group_by('schoolyear'); 
  $query = $this->db->get('Fees_Enrolled_College');
  return $query;
                                  
}


public function Get_Nationality(){
  $this->db->select('Nationality');
  $this->db->group_by("Nationality");
  $this->db->from('Student_Info');
  $query = $this->db->get();
  return $query;
                                  
}


public function Get_Course(){
  $this->db->select('Course');
  $this->db->group_by("Course");
  $this->db->where('Course != ', 'N/A');
  $this->db->from('Student_Info');
  $query = $this->db->get();
  return $query;
                                  
}


public function Get_Gender(){
  $this->db->select('Gender');
  $this->db->group_by('Gender');
  $this->db->where('Gender != ', 'N/A');
  $this->db->where('Gender != ', '');
  $this->db->where('Gender != ', '0');
  $this->db->where('Gender != ', 'x');
  $this->db->from('Student_Info');
  $query = $this->db->get();
  return $query;
                                  
}

public function GetMajor(){
  $this->db->select('Program_Major,ID');
  $this->db->where('Program_Major != ', 'N/A');
  $this->db->group_by('Program_Major');
  $this->db->from('Program_Majors');
  $query = $this->db->get();
  return $query;
                                  
}


public function GetYearLevel(){
  $this->db->select('Year_Level');
  $this->db->group_by('Year_Level');
  $this->db->where('Active','1');
  $this->db->where('Year_Level != ', 'N/A');
  $this->db->from('Sections');
  $query = $this->db->get();
  return $query;
                                  
}

public function GetSection_Name(){
  $this->db->select('Section_Name');
  $this->db->group_by('Section_Name');
  $this->db->where('Active','1');
  $query = $this->db->get('Sections');
  return $query;
                                  
}



public function Get_Barangay(){
  $this->db->select('*');
  $query = $this->db->get('refbrgy');
  return $query;
                                  
}


public function Get_province(){
  $this->db->select('*');
  $this->db->order_by('provDesc','ASC');
  $this->db->where('provDesc != ', '0');
  $query = $this->db->get('refprovince');
  return $query;
                                  
}

public function Get_Municipality(){
  $this->db->select('*');
  $query = $this->db->get('refcitymun');
  return $query;
                                  
}


public function Get_highschool(){
  $this->db->select('Secondary_School_Name');
  $this->db->group_by('Secondary_School_Name');
  $this->db->where('Secondary_School_Name != ', 'N/A');
  $this->db->where('Secondary_School_Name != ', 'x');
  $this->db->where('Secondary_School_Name != ', '.');
  $this->db->where('Secondary_School_Name != ', '-');
  $this->db->where('Secondary_School_Name != ', '');
  $this->db->where('Secondary_School_Name != ', '123');
  $query = $this->db->get('Student_Info');
  return $query;
                                  
}





public function GetStudentList($sy,$sm,$nt,$pmajor,$major,$gen,$Yl,$Sec,$submit){



    $this->db->select('*');
    $this->db->from('Fees_Enrolled_College');
    $this->db->join('Student_Info', 'Student_Info.Reference_Number = Fees_Enrolled_College.Reference_Number');
    $this->db->join('Program_Majors','Program_Majors.ID = Student_Info.Major');
  //  $this->db->join('Curriculum_Info','Curriculum_Info.Curriculum_ID = Student_Info.Curriculum');

    if(isset($submit)){
      $this->db->where('Student_Info.Student_Number != ', '0');
      //Where Conditions
      if(isset($sm)){
      //  echo 'With sy <br>';
        $this->db->where('Fees_Enrolled_College.semester',$sm);
      }
      if(isset($sy)){
      //  echo 'With sm <br>';
        $this->db->where('Fees_Enrolled_College.schoolyear',$sy);
      }
      if(isset($nt)){
      //  echo 'With nt <br>';
        $this->db->where('Student_Info.Nationality',$nt);
      }
      if(isset($major)){
     //  echo 'With major <br>';
        $this->db->where('Student_Info.Major',$major);
      }
      if(isset($pmajor)){
       // echo 'With major <br>';
         $this->db->where('Student_Info.Course',$pmajor);
      }
      if(isset($gen)){
        // echo 'With major <br>';
          $this->db->where('Student_Info.Gender',$gen);
       }
       if(isset($Yl)){
        // echo 'With major <br>';
          $this->db->where('Fees_Enrolled_College.YearLevel',$Yl);
       }
     
    }
    else{
      $this->db->where('Student_Info.Student_Number != ', '0');
      $this->db->where('Student_Info.Student_Number' , '');
    }
  
    $this->db->order_by('Student_Info.Last_Name', 'ASC');
    $this->db->group_by('Student_Info.Student_Number');
    $query = $this->db->get();

    if($query->num_rows()> 0){
      return $query;
          }else{
      return $query;
            }
}
  
public function count_gender(){
 
  return $this->db->count_all('Student_Info');

}

public function count_student(){
 
  return $this->db->count_all('Student_Info');

}
//Check Conflict: Gerard
public function conflict_check($sched_code,$day,$st,$et){

  $day_array = explode(',', $day);
  //$this->db->where('Sched_Code', $sched_code);
  $this->db->where("( 
  '$st' <=  `Start_Time` AND `Start_Time` <= '$et'
  OR 
  '$st' <=  `End_Time` AND `End_Time` <= '$et' 
  )");
  
  $count = 0;
  $dayget = '';
  foreach($day_array as $data){
    if($count == 0){
      $dayget .= "`Day` LIKE '%$data%' ESCAPE '!'";
    }
    else{
      $dayget .= "OR `Day`LIKE '%$data%' ESCAPE '!'";
    }
    $count++;
  }
  $this->db->where('('.$dayget.')');
  $query = $this->db->get('Sched_Display');
  return $query;

}
  public function conflict_check_section($array_data)
  {
    $day_array = explode(',', $array_data['day_array']);
    
    $where_check_time = '
    ((C.`Start_Time` BETWEEN '.$array_data['end_time'].' AND '.$array_data['start_time'].') 
    OR (C.`End_Time` BETWEEN '.$array_data['end_time'].' AND '.$array_data['start_time'].')
    OR ('.$array_data['start_time'].' BETWEEN C.`Start_Time` AND C.`End_Time` AND '.$array_data['end_time'].'  BETWEEN C.`Start_Time` AND C.`End_Time` )
    OR ('.$array_data['start_time'].' >= C.`Start_Time` AND '.$array_data['start_time'].' < C.`End_Time`)
    OR ('.$array_data['end_time'].' > C.`Start_Time` AND '.$array_data['end_time'].' <= C.`End_Time`)
    OR ('.$array_data['start_time'].'  <= C.`Start_Time` AND '.$array_data['end_time'].'  >= C.`End_Time`) )
    ';

    $this->db->select('*');
    $this->db->from('Sections AS A');
    $this->db->join('Sched AS B', 'A.Section_ID = B.Section_ID');
    $this->db->join('Sched_Display AS C', 'B.Sched_Code = C.Sched_Code');
    //$this->db->join('Legend AS D', 'B.SchoolYear = D.School_Year AND B.Semester = D.Semester');
    $this->db->where('A.Active', 1);
    $this->db->where('B.Valid', 1);
    $this->db->where('C.Valid', 1);
    $this->db->where('B.Semester', $array_data['semester']);
    $this->db->where('B.SchoolYear', $array_data['sy']);
    $this->db->where('A.Section_ID', $array_data['section_id']);


    $count = 0;
    $dayget = '';
    foreach($day_array as $data)
    {
      if($count == 0)
      {
        $dayget .= "`Day` LIKE '%$data%' ESCAPE '!'";
        $count++;
      }
      else
      {
        $dayget .= "OR `Day`LIKE '%$data%' ESCAPE '!'";
      }
      
    }
    $this->db->where('('.$dayget.')');

    $this->db->where($where_check_time);
   
    $query = $this->db->get();

    // reset query
    $this->db->reset_query();

    return $query->result_array();

  }

  public function conflict_check_room($array_data)
  {
    $day_array = explode(',', $array_data['day_array']);
   
    $where_check_time = '
    ((C.`Start_Time` BETWEEN '.$array_data['end_time'].' AND '.$array_data['start_time'].') 
    OR (C.`End_Time` BETWEEN '.$array_data['end_time'].' AND '.$array_data['start_time'].')
    OR ('.$array_data['start_time'].' BETWEEN C.`Start_Time` AND C.`End_Time` AND '.$array_data['end_time'].'  BETWEEN C.`Start_Time` AND C.`End_Time` )
    OR ('.$array_data['start_time'].' >= C.`Start_Time` AND '.$array_data['start_time'].' < C.`End_Time`)
    OR ('.$array_data['end_time'].' > C.`Start_Time` AND '.$array_data['end_time'].' <= C.`End_Time`)
    OR ('.$array_data['start_time'].'  <= C.`Start_Time` AND '.$array_data['end_time'].'  >= C.`End_Time`) )
    ';
    

    $this->db->select('*');
    $this->db->from('Sched AS A');
    $this->db->join('Sched_Display AS C', 'C.Sched_Code = A.Sched_Code');
    //$this->db->join('Legend AS D', 'A.SchoolYear = D.School_Year AND A.Semester = D.Semester');
    $this->db->where('A.Valid', 1);
    $this->db->where('C.Valid', 1);
    $this->db->where('C.RoomID', $array_data['room_id']);
    $this->db->where('C.RoomID !=', 93); //excempt room TBA
    $this->db->where('A.Semester', $array_data['semester']);
    $this->db->where('A.SchoolYear', $array_data['sy']);
    
    $count = 0;
    $dayget = '';
    foreach($day_array as $data)
    {
      if($count == 0)
      {
        $dayget .= "`Day` LIKE '%$data%' ESCAPE '!'";
        $count++;
      }
      else
      {
        $dayget .= "OR `Day`LIKE '%$data%' ESCAPE '!'";
      }
      
    }
    $this->db->where('('.$dayget.')');

    $this->db->where($where_check_time);
    
    $query = $this->db->get();

    // reset query
    $this->db->reset_query();

    return $query->result_array();

  }

  public function conflict_check_course($array_data)
  {
    $this->db->select('*');
    $this->db->from('Sections AS A');
    $this->db->join('Sched AS B', 'A.Section_ID = B.Section_ID');
    $this->db->join('Sched_Display AS C', 'B.Sched_Code = C.Sched_Code');
    $this->db->join('Legend AS D', 'B.SchoolYear = D.School_Year AND B.Semester = D.Semester');
    $this->db->join('`Subject` AS E', 'E.Course_Code = B.Course_Code');
    $this->db->where('A.Active', 1);
    $this->db->where('B.Valid', 1);
    $this->db->where('C.Valid', 1);
    $this->db->where('A.Section_ID', $array_data['section_id']);
    $this->db->where('E.id', $array_data['sched_id']);

    $query = $this->db->get();

    // reset query
    $this->db->reset_query();

    return $query->result_array();
  }

  //conflict check when editing schedule
  public function conflict_check_section_edit($array_data)
  {
    $day_array = explode(',', $array_data['day_array']);
    
    $where_check_time = '
    ((C.`Start_Time` BETWEEN '.$array_data['end_time'].' AND '.$array_data['start_time'].') 
    OR (C.`End_Time` BETWEEN '.$array_data['end_time'].' AND '.$array_data['start_time'].')
    OR ('.$array_data['start_time'].' BETWEEN C.`Start_Time` AND C.`End_Time` AND '.$array_data['end_time'].'  BETWEEN C.`Start_Time` AND C.`End_Time` )
    OR ('.$array_data['start_time'].' >= C.`Start_Time` AND '.$array_data['start_time'].' < C.`End_Time`)
    OR ('.$array_data['end_time'].' > C.`Start_Time` AND '.$array_data['end_time'].' <= C.`End_Time`)
    OR ('.$array_data['start_time'].'  <= C.`Start_Time` AND '.$array_data['end_time'].'  >= C.`End_Time`) )
    ';

    $this->db->select('*');
    $this->db->from('Sections AS A');
    $this->db->join('Sched AS B', 'A.Section_ID = B.Section_ID');
    $this->db->join('Sched_Display AS C', 'B.Sched_Code = C.Sched_Code');
    //$this->db->join('Legend AS D', 'B.SchoolYear = D.School_Year AND B.Semester = D.Semester');
    $this->db->where('A.Active', 1);
    $this->db->where('B.Valid', 1);
    $this->db->where('C.Valid', 1);
    $this->db->where('C.id !=', $array_data['schedule_id']);
    $this->db->where('A.Section_ID', $array_data['section_id']);
    $this->db->where('B.Semester', $array_data['semester']);
    $this->db->where('B.SchoolYear', $array_data['sy']);

    $count = 0;
    $dayget = '';
    foreach($day_array as $data)
    {
      if($count == 0)
      {
        $dayget .= "`Day` LIKE '%$data%' ESCAPE '!'";
        $count++;
      }
      else
      {
        $dayget .= "OR `Day`LIKE '%$data%' ESCAPE '!'";
      }
      
    }
    $this->db->where('('.$dayget.')');

    $this->db->where($where_check_time);
   
    $query = $this->db->get();

    // reset query
    $this->db->reset_query();

    return $query->result_array();

  }

  public function conflict_check_room_edit($array_data)
  {
    $day_array = explode(',', $array_data['day_array']);
   
    $where_check_time = '
    ((C.`Start_Time` BETWEEN '.$array_data['end_time'].' AND '.$array_data['start_time'].') 
    OR (C.`End_Time` BETWEEN '.$array_data['end_time'].' AND '.$array_data['start_time'].')
    OR ('.$array_data['start_time'].' BETWEEN C.`Start_Time` AND C.`End_Time` AND '.$array_data['end_time'].'  BETWEEN C.`Start_Time` AND C.`End_Time` )
    OR ('.$array_data['start_time'].' >= C.`Start_Time` AND '.$array_data['start_time'].' < C.`End_Time`)
    OR ('.$array_data['end_time'].' > C.`Start_Time` AND '.$array_data['end_time'].' <= C.`End_Time`)
    OR ('.$array_data['start_time'].'  <= C.`Start_Time` AND '.$array_data['end_time'].'  >= C.`End_Time`) )
    ';
    

    $this->db->select('*');
    $this->db->from('Sched AS A');
    $this->db->join('Sched_Display AS C', 'C.Sched_Code = A.Sched_Code');
    //$this->db->join('Legend AS D', 'A.SchoolYear = D.School_Year AND A.Semester = D.Semester');
    $this->db->where('A.Valid', 1);
    $this->db->where('C.Valid', 1);
    $this->db->where('C.id !=', $array_data['schedule_id']);
    $this->db->where('C.RoomID', $array_data['room_id']);
    $this->db->where('A.Semester', $array_data['semester']);
    $this->db->where('A.SchoolYear', $array_data['sy']);
    
    $count = 0;
    $dayget = '';
    foreach($day_array as $data)
    {
      if($count == 0)
      {
        $dayget .= "`Day` LIKE '%$data%' ESCAPE '!'";
        $count++;
      }
      else
      {
        $dayget .= "OR `Day`LIKE '%$data%' ESCAPE '!'";
      }
      
    }
    $this->db->where('('.$dayget.')');

    $this->db->where($where_check_time);
    
    $query = $this->db->get();

    // reset query
    $this->db->reset_query();

    return $query->result_array();

  }

  public function get_course_info($array_data)
  {
    $this->db->select('*');
    $this->db->from('Sections AS A');
    $this->db->join('Sched AS B', 'A.Section_ID = B.Section_ID');
    $this->db->join('Sched_Display AS C', 'B.Sched_Code = C.Sched_Code');
    //$this->db->join('Legend AS D', 'B.SchoolYear = D.School_Year AND B.Semester = D.Semester');
    $this->db->join('`Subject` AS E', 'E.Course_Code = B.Course_Code');
    $this->db->where('A.Active', 1);
    $this->db->where('B.Valid', 1);
    $this->db->where('C.Valid', 1);
    $this->db->where('A.Section_ID', $array_data['section_id']);
    $this->db->where('E.Course_Code', $array_data['course_id']);
    $this->db->where('B.Semester', $array_data['semester']);
    $this->db->where('B.SchoolYear', $array_data['sy']);

    $query = $this->db->get();

    // reset query
    $this->db->reset_query();

    return $query->result_array();
  }

  //get schedule code schedule list
  public function get_sched_code_schedule($array_data)
  {
    $this->db->select('*,C.id AS sched_display_id');
    $this->db->from('Sections AS A');
    $this->db->join('Sched AS B', 'A.Section_ID = B.Section_ID');
    $this->db->join('Sched_Display AS C', 'B.Sched_Code = C.Sched_Code');
    //$this->db->join('Legend AS D', 'B.SchoolYear = D.School_Year AND B.Semester = D.Semester');
    $this->db->join('`Subject` AS E', 'E.Course_Code = B.Course_Code');
    $this->db->join('Room AS R', 'C.RoomID = R.ID');
    $this->db->join('Instructor AS I', 'I.ID = C.Instructor_ID', 'left');
    $this->db->where('A.Active', 1);
    $this->db->where('B.Valid', 1);
    $this->db->where('C.Valid', 1);
    $this->db->where('A.Section_ID', $array_data['section_id']);
    $this->db->where('E.Course_Code', $array_data['course_id']);

    $query = $this->db->get();

    // reset query
    $this->db->reset_query();

    return $query->result_array();
  }

  //get selected sched_display info
  public function get_schedule_info($sched_display_id)
  {
    $this->db->select('A.id AS Sched_Display_ID, B.Sched_Code, A.Start_Time,A.End_Time,A.Day,A.RoomID,A.Instructor_ID, B.Semester, B.SchoolYear, C.Course_Title, B.Sched_Code, B.Total_Slot,B.Section_ID');
    $this->db->from('Sched_Display as A');
    $this->db->join('Sched as B', 'B.Sched_Code = A.Sched_Code', 'inner');
    $this->db->join('Subject as C', 'B.Course_Code = C.Course_Code', 'inner');
    $this->db->where('A.id', $sched_display_id);
    $query = $this->db->get();

    // reset query
    $this->db->reset_query();

    return $query->result_array();
  }
  public function check_schedule_instances($sched_code){

    $this->db->select('Count(*) as i_count');
    $this->db->from('Sched_Display');
    $this->db->where('Sched_Code', $sched_code);
    $this->db->where('Valid', '1');
    $query = $this->db->get();
    // reset query
    $this->db->reset_query();
    return $query->result_array();

  }
  public function update_schedule($schedule_id, $schedule_data)
  {
    $this->db->where('id', $schedule_id);
    $this->db->update('Sched_Display', $schedule_data);

    $query_log = $this->db->last_query();
    // reset query
    $this->db->reset_query();
  
    return $query_log;
    
  }
  public function update_sched_table($schedule_id, $schedule_data)
  {
    $this->db->where('Sched_Code', $schedule_id);
    $this->db->update('Sched', $schedule_data);

    $query_log = $this->db->last_query();
    // reset query
    $this->db->reset_query();
  
    return $query_log;
    
  }
  public function dissolve_schedule($sched_code, $schedule_data)
  {
    $this->db->where('Sched_Code', $sched_code);
    $this->db->update('Sched_Display', $schedule_data);

    $query_log = $this->db->last_query();
    // reset query
    $this->db->reset_query();
  
    return $query_log;
    
  }

  public function remove_sched_display($id)
  {

    $this->db->set('Valid', 0);
    $this->db->where('id', $id);
    $this->db->update('Sched_Display');
    //reset query
    $this->db->reset_query();

  } 
  public function remove_schedule($id)
  {

    $this->db->set('Valid', 0);
    $this->db->where('Sched_Code', $id);
    $this->db->update('Sched');
    //reset query
    $this->db->reset_query();

  } 

  public function get_sched_info_by_sched_code($sched_code)
  {
    $this->db->trans_start();
    $this->db->select('*');
    $this->db->from('Sched');
    $this->db->where('Sched_Code', $sched_code);
    $this->db->where('Valid', 1);
    $this->db->trans_complete();

    $query = $this->db->get();

    // reset query
    $this->db->reset_query();

    return $query->result_array();
  }
                          
}
?>
