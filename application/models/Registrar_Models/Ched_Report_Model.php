<?php


class Ched_Report_Model extends CI_Model{
  
  

public function Get_sem(){
  $this->db->select('Semester');
  $this->db->from('EnrolledStudent_Subjects');
  $this->db->group_by('Semester');
  $query = $this->db->get();
  return $query;
	                           
}


public function Get_sy(){
  $this->db->select('*');
  $this->db->from('SchoolYear');
  $query = $this->db->get();
  return $query;
	                           
}

public function Get_course(){
  $this->db->select('*');
  $this->db->from('Programs');
  $this->db->order_by('Program_Code',ASC);
  $query = $this->db->get();
  return $query;
	                           
}

public function get_major($course_id)
{
    $query = $this->db->get_where('Program_Majors', array('Program_Code' => $course_id));
    return $query->result();
}



public function Get_yearlvl(){
  $this->db->select('Year_Level');
  $this->db->from('Sections');
  $this->db->where('Year_Level !=','N/A');
  $this->db->where('Year_Level !=','0');
  $this->db->group_by('Year_Level');
  $query = $this->db->get();
  return $query;
	                           
}


public function Get_user(){
  $this->db->select('*');
  $this->db->from('Users');
  $this->db->where('User_Department','Registrars Office');
  $this->db->where('User_ID','41');
  $query = $this->db->get();
  return $query;
	                           
}


public function GetMajor(){
  $this->db->select('Program_Major,ID,Program_Code');
  $this->db->where('Program_Major != ', 'N/A');
  $this->db->from('Program_Majors');
  $query = $this->db->get();
  return $query;
                                  
}

  /// GET ENROLLED
  public function Get_students($sy,$sm,$major,$program,$Yl,$submit){

    $this->db->select('
    A.Student_Number,
    A.Reference_Number,
    A.First_Name,
    A.`Middle_Name`,
    A.Last_Name,
    A.Gender,
    A.`Course`,

    A.Nationality,
    A.YearLevel,

    B.School_Year,
    B.`Semester`,
    B.`Program`,
    J.Program_Name,
    K.Program_Major,
    B.`Year_Level`,
    D.Sched_Code,
    D.Course_Code,
    G.`Course_Lab_Unit`,
    G.`Course_Lec_Unit`,
    G.`Course_Title`
     ');
    $this->db->from('Student_Info AS A');
    $this->db->join('EnrolledStudent_Subjects AS B', 'B.Reference_Number = A.Reference_Number', 'INNER');
    $this->db->join('Fees_Enrolled_College AS C', 'C.Reference_Number = B.Reference_Number' ,'LEFT');
    $this->db->join('Sched AS D', 'B.Sched_Code = D.Sched_Code','LEFT');
    $this->db->join('Sections AS E', 'E.Section_ID = D.Section_ID','LEFT');
    $this->db->join('`Subject` AS G', 'G.Course_Code = D.Course_Code','LEFT');
    $this->db->join('`Program_Majors` AS K', '`K`.`ID` = `A`.`Major`','LEFT');
    // $this->db->join('`Programs` AS J', '`J`.`Program_Code` = `K`.`Program_Code`','LEFT');
    $this->db->join('`Programs` AS J', '`J`.`Program_Code` = `A`.`Course`','LEFT');
    $this->db->where('B.Semester = ',  $sm);
    $this->db->where('B.School_Year = ',$sy);
    $this->db->where('C.semester = ',  $sm);
    $this->db->where('C.SchoolYear = ',$sy);
    $this->db->where('B.Program = ',$program);
    $this->db->where('C.YearLevel = ',$Yl);
    $this->db->where('A.Major = ',$major);
    $this->db->where('B.Reference_Number != ','0');
    $this->db->where('A.Student_Number != ', '0');
    $this->db->where('B.Reference_Number   > ','1');
    $this->db->where('A.Student_Number     >', '1');
    $this->db->where('B.Student_Number     > ','1');
    $this->db->where('A.Reference_Number   >', '1');
    $this->db->where('C.withdraw = ','0');
    $this->db->where('B.Cancelled = ','0');
    $this->db->where('B.Dropped = ','0');
    $this->db->where('D.Valid = ','1');
    $this->db->where('E.Active = ','1');
    $this->db->order_by('A.Last_Name');
    $this->db->order_by('A.Student_Number');
    $this->db->order_by('A.Student_Number','ASC');
    $query = $this->db->get();
    return $query;

  }










                          
}
?>
