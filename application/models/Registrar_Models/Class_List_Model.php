<?php


class Class_List_Model extends CI_Model{
  
  
  public function get_class_list($array)
  {
    $this->db->select
    ('
    A.`Sched_Code`,
    A.`Semester`,
    A.`SchoolYear`,
    A.`Course_Code`,
    B.`Program`,
    B.`Reference_Number`,
    B.`Student_Number`,
    I.`Section_Name`,
    B.`Year_Level`,
    C.`First_Name`,
    C.`Middle_Name`,
    C.`Last_Name`,
    D.`Day`,
    E.`Room`,
    F.`Schedule_Time AS Startime`,
    F2.`Schedule_Time AS Endtime`,
    G.`Instructor_Name`,
    H.Course_Title,
    H.Course_Lec_Unit,
    H.Course_Lab_Unit
    ');
    $this->db->from('Sched AS A');
    $this->db->join('EnrolledStudent_Subjects AS B ', 'A.`Sched_Code` = B.`Sched_Code`', 'inner');
    $this->db->join('Student_Info AS C', 'B.`Student_Number` = C.`Student_Number`' ,'left');
    $this->db->join('Sched_Display AS D', 'D.`Sched_Code` = A.`Sched_Code`', 'left');
    $this->db->join('Room AS E', 'E.`ID` = D.`RoomID`');
    $this->db->join('Time AS F', 'F.`Time_From` = D.`Start_Time`', 'left');
    $this->db->join('Time AS F2', 'F2.`Time_To` = D.`End_Time`','LEFT');
    $this->db->join('Instructor AS G', 'D.`Instructor_ID` = G.`ID`','left');
    $this->db->join('Subject AS H', 'H.`Course_Code`= A.`Course_Code`','left');
    $this->db->join('Sections AS I', 'I.`Section_ID`= A.`Section_ID`','left');
    $this->db->where('A.Sched_Code =', $array['sc']);
    $this->db->where('B.Dropped  !=','1');
    $this->db->where('B.Cancelled !=','1');
    $this->db->order_by('C.Last_Name','ASC');
    $this->db->group_by('B.Reference_Number');
    $query = $this->db->get();
  
    if($query->num_rows()> 0){
        return $query->result();
    }else{
        return $query->result();
    }

  }

  public function get_class_list_count($array)
  {
    $this->db->select('COUNT(*) as count');
    $this->db->from('Sched AS A');
    $this->db->join('EnrolledStudent_Subjects AS B ', 'A.`Sched_Code` = B.`Sched_Code`', 'inner');
    $this->db->join('Student_Info AS C', 'B.`Student_Number` = C.`Student_Number`' ,'left');
    $this->db->join('Sched_Display AS D', 'D.`Sched_Code` = A.`Sched_Code`', 'left');
    $this->db->join('Room AS E', 'E.`ID` = D.`RoomID`');
    $this->db->join('Time AS F', 'F.`Time_From` = D.`Start_Time`', 'left');
    $this->db->join('Time AS F2', 'F2.`Time_To` = D.`End_Time`','LEFT');
    $this->db->join('Instructor AS G', 'D.`Instructor_ID` = G.`ID`','left');
    $this->db->join('Subject AS H', 'H.`Course_Code`= A.`Course_Code`','left');
    $this->db->join('Sections AS I', 'I.`Section_ID`= A.`Section_ID`','left');
    $this->db->where('A.Sched_Code =', $array['sc']);
    $this->db->where('B.Dropped  !=','1');
    $this->db->where('B.Cancelled !=','1');
    $this->db->order_by('C.Last_Name','ASC');
    $this->db->group_by('B.Reference_Number');
    $query = $this->db->get();

    return $query->result_array();
    

  }


                          
}
?>
