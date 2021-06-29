<?php


class ChangeSection_Model extends CI_Model
{



  public function Get_Legend()
  {
    $this->db->select('*');
    $this->db->from('Legend');
    $query = $this->db->get();
    return $query->result_array();
  }


  public function Get_enrolled($array)
  {

    $this->db->select('
  A.Student_Number,
  A.AdmittedSY,
  A.AdmittedSEM,
  A.Reference_Number,
  A.First_Name,
  A.`Middle_Name`,
  A.Last_Name,
  A.`Course`,
  A.Address_No,
  A.Address_Street,
  A.Address_Subdivision,
  A.Address_Barangay,
  A.Address_City,
  A.Address_Province,
  K.`Program_Major`,
  B.School_Year,
  B.`Semester`,
  B.`Scheduler`,
  B.`Sdate`,
  B.`Status`,
  B.`Program`,
  B.`Major`,
  B.`Year_Level`,
  B.`Payment_Plan`,
  B.`Section`,
  B.`Dropped`,
  B.`Cancelled`,
  C.`fullpayment`,
  C.InitialPayment,
  C.First_Pay,
  C.Second_Pay,
  C.Third_Pay,
  C.Fourth_Pay,
  C.Scholarship,
  C.YearLevel AS YL,
  D.Sched_Code,
  D.Course_Code,
  E.`Section_Name`,
  G.`Course_Lab_Unit`,
  G.`Course_Lec_Unit`,
  G.`Course_Title`,
  H.`Day`,
 `H`.`Start_Time`,
 `H`.`End_Time`,
  L.`Time_From`,
  L2.`Time_to`,
  L.`Schedule_Time` AS START,
  L2.`Schedule_Time` AS END,
  I.`Room`,
  J.Instructor_Name
   ');
    $this->db->from('Student_Info AS A');
    $this->db->join('EnrolledStudent_Subjects AS B', 'B.Reference_Number = A.Reference_Number', 'INNER');
    $this->db->join('Fees_Enrolled_College AS C', 'C.Reference_Number = B.Reference_Number', 'LEFT');
    $this->db->join('Sched AS D', 'B.Sched_Code = D.Sched_Code', 'LEFT');
    $this->db->join('`Sections` AS E', 'E.Section_ID = D.Section_ID', 'LEFT');
    //  $this->db->join('`Legend` AS F', 'D.SchoolYear = F.School_Year AND `D`.`Semester` = `F`.`Semester` ','LEFT');
    $this->db->join('`Subject` AS G', 'G.Course_Code = D.Course_Code', 'LEFT');
    $this->db->join('`Sched_Display` AS H', 'H.Sched_Code = D.Sched_Code', 'LEFT');
    $this->db->join('`Room` AS I', 'H.RoomID = I.ID', 'LEFT');
    $this->db->join('`Instructor` AS J', 'J.ID = `D`.`Instructor_ID`', 'LEFT');
    $this->db->join('`Program_Majors` AS K', '`K`.`ID` = `A`.`Major`', 'LEFT');
    $this->db->join('`Time` AS `L`', '`H`.`Start_Time` = `L`.`Time_From`', 'LEFT');
    $this->db->join('`Time` AS `L2`', '`H`.`End_Time` = `L2`.`Time_To`', 'LEFT');
    $this->db->where('B.Semester = ',  $array['sem']);
    $this->db->where('B.School_Year = ', $array['sy']);
    $this->db->where('C.semester = ',  $array['sem']);
    $this->db->where('C.SchoolYear = ', $array['sy']);
    //$this->db->where('A.Student_Number = ', $array['student_num']);
    $this->db->group_start();
    $this->db->where('A.Student_Number = ', $array['student_num']);
    $this->db->or_where('A.Reference_Number = ', $array['student_num']);
    $this->db->group_end();
    $this->db->where('A.Student_Number != ', '0');
    $this->db->where('B.Cancelled = ', '0');
    $this->db->where('B.Dropped = ', '0');
    $this->db->where('D.Valid = ', '1');
    $this->db->where('E.Active = ', '1');
    $this->db->order_by('D.Sched_Code', 'ASC');
    $this->db->group_by('D.Sched_Code');
    $query = $this->db->get();

    if ($query->num_rows() > 0) {
      return $query->result();
    } else {
      return $query->result();
    }
  }


  public function get_section($Course)
  {
    $this->db->select('A.Section_Name');
    $this->db->from('Sections A');
    $this->db->join('Programs AS B', 'A.`Program_ID` = B.`Program_ID`', 'INNER');
    $this->db->where('B.Program_Code', $Course);
    $this->db->where('A.Active =', '1');
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
      return $query->result();
    } else {
      return $query->result();
    }
  }


  public function Get_CountSubject_enrolled($array)
  {
    $this->db->select('G.`Course_Title` AS `Course_Titles`');
    $this->db->from('Student_Info AS A');
    $this->db->join('EnrolledStudent_Subjects AS B', 'B.Reference_Number = A.Reference_Number', 'INNER');
    $this->db->join('Fees_Enrolled_College AS C', 'C.Reference_Number = B.Reference_Number', 'INNER');
    $this->db->join('Sched AS D', 'B.Sched_Code = D.Sched_Code', 'LEFT');
    $this->db->join('`Sections` AS E', 'E.Section_ID = D.Section_ID', 'LEFT');
    //  $this->db->join('`Legend` AS F', 'D.SchoolYear = F.School_Year AND `D`.`Semester` = `F`.`Semester` ','LEFT');
    $this->db->join('`Subject` AS G', 'G.Course_Code = D.Course_Code', 'LEFT');
    $this->db->join('`Sched_Display` AS H', 'H.Sched_Code = D.Sched_Code', 'LEFT');
    $this->db->join('`Room` AS I', 'D.RoomID = I.ID', 'LEFT');
    $this->db->join('`Instructor` AS J', 'J.ID = `D`.`Instructor_ID`', 'LEFT');
    $this->db->where('B.Semester = ', $array['sem']);
    $this->db->where('B.School_Year = ', $array['sy']);
    $this->db->where('C.semester = ', $array['sem']);
    $this->db->where('C.SchoolYear = ', $array['sy']);
    $this->db->where('B.Student_Number = ', $array['student_num']);
    $this->db->where('B.Student_Number != ', '0');
    $this->db->where('B.Cancelled = ', '0');
    $this->db->where('B.Dropped = ', '0');
    $this->db->where('E.Active = ', '1');
    $this->db->where('D.Valid = ', '1');
    $this->db->group_by('D.Sched_Code');
    $query = $this->db->get();


    return $query;
  }


  public function get_sched($array)
  {
    $this->db->select('B.`id`,D.`Year_Level`,A.`Semester`,A.`SchoolYear`,A.`Sched_Code`,A.`Course_Code`,C.`Course_Lab_Unit`,C.`Course_Lec_Unit`, D.`Section_Name`');
    $this->db->from('Sched A');
    $this->db->join('Sched_Display AS B', 'A.`Sched_Code` = B.`Sched_Code`', 'INNER');
    $this->db->join('Subject AS C', 'A.`Course_Code` = C.`Course_Code`', 'LEFT');
    $this->db->join('Sections AS D', 'A.`Section_ID` = D.`Section_ID`', 'LEFT');
    $this->db->where('A.`Semester    = ', $array['sem']);
    $this->db->where('A.`SchoolYear` =', $array['sy']);
    $this->db->where('A.`Valid`      =', '1');
    $this->db->where('D.`Active`     = ', '1');
    $this->db->where('D.`Section_Name`= ', $array['section']);
    $this->db->group_by('A.Sched_Code');
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
      return $query->result();
    } else {
      return $query->result();
    }
  }

  public function Update_Sched($array)
  {

    $this->db->set('Cancelled', '1');
    $this->db->where('Student_Number', $array['sn']);
    $this->db->where('School_Year', $array['sy']);
    $this->db->where('Semester', $array['sem']);
    $this->db->update('EnrolledStudent_Subjects');

    $query_log = $this->db->last_query();
    return $query_log;
  }



  public function InsertNewSched($array)
  {


    $this->db->insert('EnrolledStudent_Subjects', $array);

    $query_log = $this->db->last_query();
    return $query_log;
  }
}
