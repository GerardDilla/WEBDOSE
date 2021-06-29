<?php


class RegForm_Model extends CI_Model
{

  ///GET Sem
  public function Get_sem()
  {
    $this->db->select('Semester');
    $this->db->from('Semesters');
    $query = $this->db->get();
    return $query;
  }
  ///GET School Year
  public function Get_sy()
  {
    $this->db->select('schoolyear');
    $this->db->from('Fees_Enrolled_College');
    $this->db->where('schoolyear !=', 'x2018-2019x');
    $this->db->Order_by('schoolyear', 'DESC');
    $this->db->group_by('schoolyear');
    $query = $this->db->get();
    return $query;
  }


  ///CHECK ENROLLED STUDENT SUBJECT
  public function Check_Enrolled_Student($array)
  {
    $this->db->select('*');
    $this->db->from('EnrolledStudent_Subjects');
    $this->db->where('Semester = ', $array['sem']);
    $this->db->where('School_Year = ', $array['sy']);
    $this->db->where('Student_Number = ', $array['refnum']);
    $query = $this->db->get();
    return $query;
  }

  /// CHECK FEES STUDENT
  public function Check_Fees_Student($array)
  {
    $this->db->select('*');
    $this->db->from('Fees_Enrolled_College AS A');
    $this->db->join('Student_Info AS B', 'B.Reference_Number = A.Reference_Number', 'INNER');
    $this->db->where('semester = ', $array['sem']);
    $this->db->where('schoolyear = ', $array['sy']);
    $this->db->where('B.Student_Number = ', $array['refnum']);
    $this->db->or_where('B.Reference_Number = ', $array['refnum']);
    $query = $this->db->get();
    return $query;
  }

  /// GET ADVISE
  public function Get_advising($array)
  {

    $this->db->select('
        A.Student_Number,
        A.Reference_Number,
        A.AdmittedSY,
        A.AdmittedSEM,
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
        C.tuition_Fee,
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
         L2.`Schedule_Time` AS END,,
        I.`Room`,
        J.`Instructor_Name`
         ');
    $this->db->from('Student_Info AS A');
    $this->db->join('Advising AS B', 'B.Reference_Number = A.Reference_Number', 'INNER');
    $this->db->join('Fees_Enrolled_College AS C', 'C.Reference_Number = B.Reference_Number', 'INNER');
    $this->db->join('Sched AS D', 'B.Sched_Code = D.Sched_Code', 'LEFT');
    $this->db->join('`Sections` AS E', 'E.Section_ID = D.Section_ID', 'LEFT');
    // $this->db->join('`Legend` AS F', 'D.SchoolYear = F.School_Year AND `D`.`Semester` = `F`.`Semester` ','LEFT');
    $this->db->join('`Subject` AS G', 'G.Course_Code = D.Course_Code', 'LEFT');
    $this->db->join('`Sched_Display` AS H', 'H.Sched_Code = D.Sched_Code', 'LEFT');
    $this->db->join('`Room` AS I', 'H.RoomID = I.ID', 'LEFT');
    $this->db->join('`Instructor` AS J', 'J.ID = `D`.`Instructor_ID`', 'LEFT');
    $this->db->join('`Program_Majors` AS K', 'A.Major = `K`.`ID`', 'LEFT');
    $this->db->join('`Time` AS `L`', '`H`.`Start_Time` = `L`.`Time_From`', 'LEFT');
    $this->db->join('`Time` AS `L2`', '`H`.`End_Time` = `L2`.`Time_To`', 'LEFT');
    $this->db->where('B.Semester = ',  $array['sem']);
    $this->db->where('B.School_Year = ', $array['sy']);
    $this->db->where('C.semester = ',  $array['sem']);
    $this->db->where('C.SchoolYear = ', $array['sy']);
    $this->db->group_start();
    $this->db->where('B.Student_Number = ', $array['refnum']);
    $this->db->or_where('B.Reference_Number = ', $array['refnum']);
    $this->db->group_end();
    $this->db->where('D.Valid = ', '1');
    $this->db->where('B.Valid = ', '1');
    $this->db->where('H.Valid = ', '1');
    $query = $this->db->get();

    return $query->result_array();
  }

  /// GET ADVISE
  public function Get_advising_ajax($array)
  {

    $this->db->select('
          A.Student_Number,
          A.Reference_Number,
          A.AdmittedSY,
          A.AdmittedSEM,
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
          C.tuition_Fee,
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
          J.`Instructor_Name`
          ');
    $this->db->from('Student_Info AS A');
    $this->db->join('Advising AS B', 'B.Reference_Number = A.Reference_Number', 'INNER');
    $this->db->join('Fees_Temp_College AS C', 'C.Reference_Number = B.Reference_Number', 'INNER');
    $this->db->join('Sched AS D', 'B.Sched_Code = D.Sched_Code', 'LEFT');
    $this->db->join('`Sections` AS E', 'E.Section_ID = D.Section_ID', 'LEFT');
    //$this->db->join('`Legend` AS F', 'D.SchoolYear = F.School_Year AND `D`.`Semester` = `F`.`Semester` ','LEFT');
    $this->db->join('`Subject` AS G', 'G.Course_Code = D.Course_Code', 'LEFT');
    $this->db->join('`Sched_Display` AS H', 'H.Sched_Code = D.Sched_Code', 'LEFT');
    $this->db->join('`Room` AS I', 'H.RoomID = I.ID', 'LEFT');
    $this->db->join('`Instructor` AS J', 'J.ID = `D`.`Instructor_ID`', 'LEFT');
    $this->db->join('`Program_Majors` AS K', 'A.Major = `K`.`ID`', 'LEFT');
    $this->db->join('`Time` AS `L`', '`H`.`Start_Time` = `L`.`Time_From`', 'LEFT');
    $this->db->join('`Time` AS `L2`', '`H`.`End_Time` = `L2`.`Time_To`', 'LEFT');
    $this->db->where('B.Semester = ',  $array['sem']);
    $this->db->where('B.School_Year = ', $array['sy']);
    $this->db->where('C.semester = ',  $array['sem']);
    $this->db->where('C.SchoolYear = ', $array['sy']);
    $this->db->group_start();
    $this->db->where('B.Student_Number = ', $array['refnum']);
    $this->db->or_where('B.Reference_Number = ', $array['refnum']);
    $this->db->group_end();
    //$this->db->where('B.Student_Number != ','0');
    $this->db->where('D.Valid = ', '1');
    $this->db->where('B.Valid  = ', '1');
    $query = $this->db->get();

    if ($query->num_rows() > 0) {
      return $query->result();
    } else {
      return $query->result();
    }
  }


  /// GET ENROLLED
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
        B.`Section` AS ENROLLED_SECTION,
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
        C.tuition_Fee,
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
    //$this->db->join('`Legend` AS F', 'D.SchoolYear = F.School_Year AND `D`.`Semester` = `F`.`Semester` ','LEFT');
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
    $this->db->group_start();
    $this->db->where('B.Student_Number = ', $array['refnum']);
    $this->db->or_where('B.Reference_Number = ', $array['refnum']);
    $this->db->group_end();
    $this->db->where('B.Cancelled = ', '0');
    $this->db->where('B.Dropped = ', '0');
    $this->db->where('D.Valid = ', '1');
    $this->db->where('H.Valid = ', '1');
    $this->db->order_by('D.Sched_Code', 'ASC');
    $query = $this->db->get();

    return $query->result_array();
  }

  /// GET COUNT SUBJECT FROM ENROLLED
  public function Get_CountSubject_enrolled($array)
  {
    $this->db->select('*');
    $this->db->from('Student_Info AS A');
    $this->db->join('EnrolledStudent_Subjects AS B', 'B.Reference_Number = A.Reference_Number', 'INNER');
    $this->db->join('Fees_Enrolled_College AS C', 'C.Reference_Number = B.Reference_Number', 'INNER');
    $this->db->join('Sched AS D', 'B.Sched_Code = D.Sched_Code', 'LEFT');
    $this->db->join('`Sections` AS E', 'E.Section_ID = D.Section_ID', 'LEFT');
    //$this->db->join('`Legend` AS F', 'D.SchoolYear = F.School_Year AND `D`.`Semester` = `F`.`Semester` ','LEFT');
    $this->db->join('`Subject` AS G', 'G.Course_Code = D.Course_Code', 'LEFT');
    $this->db->join('`Sched_Display` AS H', 'H.Sched_Code = D.Sched_Code', 'LEFT');
    $this->db->join('`Room` AS I', 'D.RoomID = I.ID', 'LEFT');
    $this->db->join('`Instructor` AS J', 'J.ID = `D`.`Instructor_ID`', 'LEFT');
    $this->db->where('B.Semester =', $array['sem']);
    $this->db->where('B.School_Year =', $array['sy']);
    $this->db->where('C.semester = ', $array['sem']);
    $this->db->where('C.SchoolYear = ', $array['sy']);
    $this->db->where('B.Student_Number = ', $array['stu_num']);
    $this->db->where('B.Cancelled = ', '0');
    $this->db->where('B.Dropped = ', '0');
    $this->db->where('D.Valid = ', '1');
    $this->db->group_by('D.Sched_Code');
    $query = $this->db->get();


    return $query->result_array();
  }




  /// GET COUNT SUBJECT FROM Advising: TEMPORARY REG FORM
  public function Get_CountSubject_Advising_TRF($ref_num, $sem, $sy)
  {
    $this->db->select('G.`Course_Title` AS `Course_Titles`');
    $this->db->from('Student_Info AS A');
    $this->db->join('Advising AS B', 'B.Reference_Number = A.Reference_Number', 'INNER');
    $this->db->join('Sched AS D', 'B.Sched_Code = D.Sched_Code', 'LEFT');
    $this->db->join('`Sections` AS E', 'E.Section_ID = D.Section_ID', 'LEFT');
    //$this->db->join('`Legend` AS F', 'D.SchoolYear = F.School_Year AND `D`.`Semester` = `F`.`Semester` ','LEFT');
    $this->db->join('`Subject` AS G', 'G.Course_Code = D.Course_Code', 'LEFT');
    $this->db->join('`Sched_Display` AS H', 'H.Sched_Code = D.Sched_Code', 'LEFT');
    $this->db->join('`Room` AS I', 'D.RoomID = I.ID', 'LEFT');
    $this->db->join('`Instructor` AS J', 'J.ID = `D`.`Instructor_ID`', 'LEFT');
    $this->db->where('B.Semester = ', $sem);
    $this->db->where('B.School_Year = ', $sy);
    $this->db->where('E.Active = ', '1');
    $this->db->where('B.Student_Number = ', $ref_num);
    $this->db->where('B.Student_Number != ', '0');
    $this->db->where('B.Cancelled = ', '0');
    $this->db->where('B.Dropped = ', '0');
    $this->db->where('B.Valid = ', '1');
    $this->db->where('D.Valid = ', '1');
    $this->db->group_by('D.Sched_Code');
    $query = $this->db->get();
    return $query;
  }




  public function Get_LabFeesAdvising_TRF($ref_num, $course, $sem, $sy, $yl)
  {

    $this->db->select('IFNULL(SUM(`B`.`Fees_Amount`),0.00) AS `Fees_Amount`');
    $this->db->from('Fees_Temp_College AS A');
    $this->db->join('Fees_Temp_College_Item AS B', 'A.id = B.Fees_Temp_College_Id', 'INNER');
    $this->db->where('A.course              = ', $course);
    $this->db->where('A.Semester            = ', $sem);
    $this->db->where('A.SchoolYear          =  ', $sy);
    $this->db->where('A.YearLevel           = ', $yl);
    $this->db->where('A.Reference_Number    = ', $ref_num);
    $this->db->where('B.Fees_Type           = ', 'LAB');
    $this->db->where('B.valid    = ', '1');
    $query = $this->db->get();

    if ($query->num_rows() > 0) {
      return $query->result();
    } else {
      return $query->result();
    }
  }



  public function Get_LabFeesEnrolled($array)
  {

    $this->db->select_sum('B.Fees_Amount');
    $this->db->from('Fees_Enrolled_College AS A');
    $this->db->join('Fees_Enrolled_College_Item AS B', 'A.id = B.Fees_Enrolled_College_Id', 'INNER');
    $this->db->where('A.course              = ', $array['course']);
    $this->db->where('A.Semester            = ', $array['sem']);
    $this->db->where('A.SchoolYear          =  ', $array['sy']);
    $this->db->where('A.YearLevel           = ', $array['yl']);
    $this->db->where('A.Reference_Number    = ', $array['ref_num']);
    $this->db->where('B.Fees_Type           = ', 'LAB');
    $this->db->where('B.valid    = ', '1');
    $query = $this->db->get();

    return $query->result_array();
  }




  /// GET MiSC FEES
  public function Get_MISC_FEE($array)
  {

    $this->db->select_sum('B.Fees_Amount');
    $this->db->from('Fees_Enrolled_College AS A');
    $this->db->join('Fees_Enrolled_College_Item AS B', 'A.id = B.Fees_Enrolled_College_Id', 'INNER');
    $this->db->where('A.course             = ', $array['course']);
    $this->db->where('A.Semester            = ', $array['sem']);
    $this->db->where('A.SchoolYear          =  ', $array['sy']);
    $this->db->where('A.YearLevel           = ', $array['yl']);
    $this->db->where('B.Fees_Type           = ', 'MISC');
    $this->db->where('A.Reference_Number    = ', $array['ref_num']);
    $this->db->where('B.valid    = ', '1');
    $query = $this->db->get();

    return $query->result_array();
  }
  // MISC FEE FOR TEMPORARY REGFORM
  public function Get_MISC_FEE_TRF($ref_num, $course, $sem, $sy, $yl)
  {

    $this->db->select_sum('B.Fees_Amount');
    $this->db->from('Fees_Temp_College AS A');
    $this->db->join('Fees_Temp_College_Item AS B', 'A.id = B.Fees_Temp_College_Id', 'INNER');
    $this->db->where('A.course             = ', $course);
    $this->db->where('A.Semester            = ', $sem);
    $this->db->where('A.SchoolYear          =  ', $sy);
    $this->db->where('A.YearLevel           = ', $yl);
    $this->db->where('B.Fees_Type           = ', 'MISC');
    $this->db->where('A.Reference_Number    = ', $ref_num);
    $this->db->where('B.valid    = ', '1');
    $query = $this->db->get();

    if ($query->num_rows() > 0) {
      return $query->result();
    } else {
      return $query->result();
    }
  }

  /// GET OTHER FEES
  public function Get_OTHER_FEE($array)
  {

    $this->db->select_sum('B.Fees_Amount');
    $this->db->from('Fees_Enrolled_College AS A');
    $this->db->join('Fees_Enrolled_College_Item AS B', 'A.id = B.Fees_Enrolled_College_Id', 'INNER');
    $this->db->where('A.course              = ', $array['course']);
    $this->db->where('A.Semester            = ', $array['sem']);
    $this->db->where('A.SchoolYear          =  ', $array['sy']);
    $this->db->where('A.YearLevel           = ', $array['yl']);
    $this->db->where('A.Reference_Number    = ', $array['ref_num']);
    $this->db->where('B.Fees_Type           = ', 'OTHER');
    $this->db->where('B.valid    = ', '1');
    $query = $this->db->get();

    return $query->result_array();
  }
  // OTHER FEE FOR TEMPORARY REGFORM
  public function Get_OTHER_FEE_TRF($ref_num, $course, $sem, $sy, $yl)
  {

    $this->db->select('IFNULL(SUM(`B`.`Fees_Amount`),0.00) AS `Fees_Amount`');
    $this->db->from('Fees_Temp_College AS A');
    $this->db->join('Fees_Temp_College_Item AS B', 'A.id = B.Fees_Temp_College_Id', 'INNER');
    $this->db->where('A.course              = ', $course);
    $this->db->where('A.Semester            = ', $sem);
    $this->db->where('A.SchoolYear          =  ', $sy);
    $this->db->where('A.YearLevel           = ', $yl);
    $this->db->where('A.Reference_Number    = ', $ref_num);
    $this->db->where('B.Fees_Type           = ', 'OTHER');
    $this->db->where('B.valid    = ', '1');
    $query = $this->db->get();

    if ($query->num_rows() > 0) {
      return $query->result();
    } else {
      return $query->result();
    }
  }



  /// GET TUITION FEES
  public function Get_Tuition_FEE_TRF($course, $sem, $sy, $yl, $ref_num, $admmitedSy, $admmitedSem)
  {

    $this->db->select('TuitionPerUnit,B.Fees_Name,B.Fees_Amount,B.Fees_Type');
    $this->db->from('Fees_Temp_College AS A');
    $this->db->join('Fees_Temp_College_Item AS B', 'A.id = B.Fees_Temp_College_Id', 'INNER');
    $this->db->join('Fees_Listing AS C', 'A.course = C.Program_Code', 'INNER');
    $this->db->where('A.semester            = ', $sem);
    $this->db->where('A.schoolyear          = ', $sy);
    $this->db->where('A.YearLevel           = ', $yl);
    $this->db->where('A.Reference_Number    = ', $ref_num);
    $this->db->where('A.course              = ', $course);
    $this->db->where('C.School_Year         = ', $sy);
    $this->db->where('C.Semester            = ', $sem);
    $this->db->where('C.AdmitSchoolYear     = ', $admmitedSy);
    $this->db->where('C.AdmitSemester      = ', $admmitedSem);
    $this->db->group_by('B.Fees_Name');

    $query = $this->db->get();

    if ($query->num_rows() > 0) {
      return $query->result();
    } else {
      return $query->result();
    }
  }


  /// GET TOTAL CASH PAYMENT
  public function Get_Total_CashPayment($array)
  {

    $this->db->select_sum('AmountofPayment');
    $this->db->from('EnrolledStudent_Payments_Throughput');
    $this->db->where('Reference_Number    = ', $array['ref_num']);
    $this->db->where('SchoolYear          = ', $array['sy']);
    $this->db->where('Semester            = ', $array['sem']);
    $this->db->where('valid               = ', '1');
    $query = $this->db->get();

    return $query->result_array();
  }


  /* 
    //Insert to Enrolled  
    public function InsertEnroll($array){

      $data = array(
        'Reference_Number'     => $array['ref_num'],
        'Student_Number'       => $array['stu_num'],
        'Sched_Code'           => $array['scode'],
        'Semester'             => $array['sem'],
        'School_Year'          => $array['sy'],
        'Scheduler'            => $array['Sr'],
        'Sdate'                => $array['Sd'],
        'Status'               => $array['St'],
        'Program'              => $array['Pg'],
        'Major'                => $array['Major'],
        'Year_Level'           => $array['Year_Level'],
        'Payment_Plan'         => $array['Payment_Plan'],
        'Section'              => $array['Section'],
        'Dropped'              => $array['Dropped'],
        'Cancelled'            => $array['Cancelled'],
        'Sched_Display_ID'     => $array['Sched_Display_ID']

          );
 
      $this->db->insert('EnrolledStudent_Subjects', $data);
    } 
  

  
    public function Get_advisingInsert($array){

      $this->db->select('
       A.Student_Number,
       A.Reference_Number,
       A.First_Name,
       A.`Middle_Name`,
       A.Last_Name,
       A.`Course`,
       A.Major,
       A.Address_No,
       A.Address_Street,
       A.Address_Subdivision,
       A.Address_Barangay,
       A.Address_City,
       A.Address_Province,
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
       D.Sched_Code,
       D.Course_Code,
       E.`Section_Name`,
       G.`Course_Lab_Unit`,
       G.`Course_Lec_Unit`,
       G.`Course_Title`,
       I.`Room`,
       J.`Instructor_Name`
        ');
       $this->db->from('Student_Info AS A');
       $this->db->join('Advising AS B', 'B.Reference_Number = A.Reference_Number', 'INNER');
       $this->db->join('Fees_Enrolled_College AS C', 'C.Reference_Number = B.Reference_Number' ,'INNER');
       $this->db->join('Sched AS D', 'B.Sched_Code = D.Sched_Code','LEFT');
       $this->db->join('`Sections` AS E', 'E.Section_ID = D.Section_ID','LEFT');
      // $this->db->join('`Legend` AS F', 'D.SchoolYear = F.School_Year AND `D`.`Semester` = `F`.`Semester` ','LEFT');
       $this->db->join('`Subject` AS G', 'G.Course_Code = D.Course_Code','LEFT');
       $this->db->join('`Room` AS I', 'D.RoomID = I.ID','LEFT');
       $this->db->join('`Instructor` AS J', 'J.ID = `D`.`Instructor_ID`','LEFT');
       $this->db->join('`Program_Majors` AS K', 'A.Major = `K`.`ID`','LEFT');
       $this->db->where('B.Semester = ',  $array['sem']);
       $this->db->where('B.School_Year = ', $array['sy']);
       $this->db->where('C.semester = ', $array['sem']);
       $this->db->where('C.SchoolYear = ', $array['sy']);
       $this->db->where('B.Reference_Number = ', $array['refnum']);
       $this->db->where('B.Reference_Number != ','0');
       $this->db->where('D.Valid = ','1');
       $this->db->where('B.Valid = ','1');
       $query = $this->db->get();

       if($query->num_rows()> 0){
         return $query->result();
      }else{
         return $query->result();
      }

     }  */

  public function Get_Info($ref)
  {
    $this->db->select('*');
    $this->db->from('Student_Info');
    $this->db->where('Student_Number', $ref);
    $this->db->or_where('Reference_Number', $ref);
    $query = $this->db->get();
    return $query;
  }

  /*
  public function totalUnitsAdvising($ref_num,$sem,$sy){

    $this->db->select('
        A.Student_Number,
        A.Reference_Number,
        A.First_Name,
        A.`Middle_Name`,
        A.Last_Name,
        A.`Course`,
        A.Major,
        A.Address_No,
        A.Address_Street,
        A.Address_Subdivision,
        A.Address_Barangay,
        A.Address_City,
        A.Address_Province,
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
        D.Sched_Code,
        D.Course_Code,
        E.`Section_Name`,
        G.`Course_Lab_Unit`,
        G.`Course_Lec_Unit`,
        G.`Course_Title`,
        H.`Day`,
        H.`Start_Time`,
        H.`End_Time`,
        I.`Room`,
        J.`Instructor_Name`
         ');
        $this->db->from('Student_Info AS A');
        $this->db->join('Advising AS B', 'B.Reference_Number = A.Reference_Number', 'INNER');
        $this->db->join('Fees_Enrolled_College AS C', 'C.Reference_Number = B.Reference_Number' ,'INNER');
        $this->db->join('Sched AS D', 'B.Sched_Code = D.Sched_Code','LEFT');
        $this->db->join('`Sections` AS E', 'E.Section_ID = D.Section_ID','LEFT');
       // $this->db->join('`Legend` AS F', 'D.SchoolYear = F.School_Year AND `D`.`Semester` = `F`.`Semester` ','LEFT');
        $this->db->join('`Subject` AS G', 'G.Course_Code = D.Course_Code','LEFT');
        $this->db->join('`Sched_Display` AS H', 'H.Sched_Code = D.Sched_Code','LEFT');
        $this->db->join('`Room` AS I', 'H.RoomID = I.ID','LEFT');
        $this->db->join('`Instructor` AS J', 'J.ID = `D`.`Instructor_ID`','LEFT');
        $this->db->join('`Program_Majors` AS K', 'A.Major = `K`.`ID`','LEFT');
        $this->db->where('B.Semester = ', $sem);
        $this->db->where('B.School_Year = ',$sy);
        $this->db->where('C.semester = ',$sem);
        $this->db->where('C.SchoolYear = ',$sy);
        $this->db->where('B.Reference_Number = ',$ref_num);
        $this->db->where('B.Reference_Number != ','0');
        $this->db->where('B.Valid  = ','1');
    
        $this->db->group_by('`D`.`Sched_Code`');
  
        $query = $this->db->get();

        return $query->result_array();

    
  } */

  public function totalUnitsAdvising_TRF($array)
  {

    $this->db->select('
          A.Student_Number,
          A.Reference_Number,
          A.First_Name,
          A.`Middle_Name`,
          A.Last_Name,
          A.`Course`,
          A.Major,
          A.Address_No,
          A.Address_Street,
          A.Address_Subdivision,
          A.Address_Barangay,
          A.Address_City,
          A.Address_Province,
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
          D.Sched_Code,
          D.Course_Code,
          E.`Section_Name`,
          G.`Course_Lab_Unit`,
          G.`Course_Lec_Unit`,
          G.`Course_Title`,
          H.`Day`,
          H.`Start_Time`,
          H.`End_Time`,
          I.`Room`,
          J.`Instructor_Name`
          ');
    $this->db->from('Student_Info AS A');
    $this->db->join('Advising AS B', 'B.Reference_Number = A.Reference_Number', 'INNER');
    $this->db->join('Fees_Temp_College AS C', 'C.Reference_Number = B.Reference_Number', 'INNER');
    $this->db->join('Sched AS D', 'B.Sched_Code = D.Sched_Code', 'LEFT');
    $this->db->join('`Sections` AS E', 'E.Section_ID = D.Section_ID', 'LEFT');
    //$this->db->join('`Legend` AS F', 'D.SchoolYear = F.School_Year AND `D`.`Semester` = `F`.`Semester` ','LEFT');
    $this->db->join('`Subject` AS G', 'G.Course_Code = D.Course_Code', 'LEFT');
    $this->db->join('`Sched_Display` AS H', 'H.Sched_Code = D.Sched_Code', 'LEFT');
    $this->db->join('`Room` AS I', 'H.RoomID = I.ID', 'LEFT');
    $this->db->join('`Instructor` AS J', 'J.ID = `D`.`Instructor_ID`', 'LEFT');
    $this->db->join('`Program_Majors` AS K', 'A.Major = `K`.`ID`', 'LEFT');
    $this->db->where('B.Semester = ',  $array['sem']);
    $this->db->where('B.School_Year = ', $array['sy']);
    $this->db->where('C.semester = ',  $array['sem']);
    $this->db->where('C.SchoolYear = ', $array['sy']);
    $this->db->where('B.Reference_Number = ', $array['refnum']);
    $this->db->where('B.Reference_Number != ', '0');
    $this->db->where('B.Valid  = ', '1');

    $this->db->group_by('`D`.`Sched_Code`');

    $query = $this->db->get();

    if ($query->num_rows() > 0) {

      return $query->result();
    } else {

      return $query->result();
    }
  }

  public function totalUnitsEnrolled($array)
  {

    $this->db->select('
        A.Student_Number,
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
        C.tuition_Fee,
        D.Sched_Code,
        D.Course_Code,
        E.`Section_Name`,
        G.`Course_Lab_Unit`,
        G.`Course_Lec_Unit`,
        G.`Course_Title`,
        H.`Day`,
        H.`Start_Time`,
        H.`End_Time`,
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
    $this->db->where('B.Semester = ', $array['sem']);
    $this->db->where('B.School_Year = ', $array['sy']);
    $this->db->where('C.semester = ', $array['sem']);
    $this->db->where('C.SchoolYear = ', $array['sy']);
    $this->db->where('B.Reference_Number = ', $array['ref_num']);
    $this->db->where('B.Cancelled = ', '0');
    $this->db->where('B.Dropped = ', '0');
    $this->db->where('D.Valid = ', '1');
    $this->db->group_by('`D`.`Sched_Code`');
    $this->db->order_by('D.Sched_Code', 'ASC');
    $query = $this->db->get();

    return $query->result_array();
  }

  public function get_subject_lab_fee($array_data)
  {
    $ref_no = $array_data['reference_no'];
    $semester = $array_data['semester'];
    $school_year =  $array_data['school_year'];

    $query = $this->db->query("
        SELECT 
            `ST`.`subjecttype` AS `Subject_Type`,
            IFNULL(
              IF(
                (SELECT 
                  COUNT(`ID`) 
                FROM
                  `Fees_Listing_Subject_Other` 
                WHERE `Course_Code` = `Sub`.`Course_Code` 
                  AND `Program_Code` = `Prog`.`Program_Code` 
                  AND `subjecttype_id` = `FLSO`.`subjecttype_id` 
                  AND `Semester` = `Sched`.`Semester` 
                  AND `School_Year` = `Sched`.`SchoolYear` 
                  AND `valid`) >= 1,
                (SELECT 
                  `amount` 
                FROM
                  `Fees_Listing_Subject_Other` 
                WHERE `Course_Code` = `Sub`.`Course_Code` 
                  AND `Program_Code` = `Prog`.`Program_Code` 
                  AND `subjecttype_id` = `FLSO`.`subjecttype_id` 
                  AND `Semester` = `Sched`.`Semester` 
                  AND `School_Year` = `Sched`.`SchoolYear` 
                  AND `valid`),
                (SELECT 
                  `amount` 
                FROM
                  `Fees_Listing_Subject_Other` 
                WHERE `Course_Code` = `Sub`.`Course_Code` 
                  AND `Program_Code` = 'N/A' 
                  AND `subjecttype_id` = `FLSO`.`subjecttype_id` 
                  AND `Semester` = `Sched`.`Semester` 
                  AND `School_Year` = `Sched`.`SchoolYear` 
                  AND `valid`)
              ),
              0.00
            ) AS `Lab_Fee` 
        FROM
            `Fees_Listing_Subject_Other` AS `FLSO` 
            INNER JOIN `subjecttype` AS `ST` 
            ON `FLSO`.`subjecttype_id` = `ST`.`id` 
            AND `FLSO`.`valid` 
            AND `ST`.`is_lab` = 1 
            INNER JOIN Sched AS `Sched` 
            ON `FLSO`.`Course_Code` = `Sched`.`Course_Code` 
            INNER JOIN `Subject` AS `Sub` 
            ON `Sched`.Course_Code = `Sub`.Course_Code 
            AND `FLSO`.`Semester` = `Sched`.`Semester` 
            AND `FLSO`.`School_Year` = `Sched`.`SchoolYear` 
            INNER JOIN `Sections` AS `Sec` 
            ON `Sched`.`Section_ID` = `Sec`.`Section_ID` 
            INNER JOIN `Programs` AS `Prog` 
            ON `Sec`.`Program_ID` = `Prog`.`Program_ID`  
            INNER JOIN EnrolledStudent_Subjects AS `Adv` 
            ON `Sched`.`Sched_Code` = `Adv`.`Sched_Code` 
            AND `Sched`.`Valid` 
        WHERE `Adv`.`Reference_Number` = '$ref_no' 
            AND `Adv`.`Semester` = '$semester' 
            AND `Adv`.`School_Year` = '$school_year'
            AND `Adv`.`Dropped` = 0
            AND `Adv`.`Cancelled` = 0 
            GROUP BY `FLSO`.`Course_Code`,`FLSO`.`subjecttype_id`;
        ");

    return $query->result_array();
  }

  public function Insert_logs($insert)
  {

    $this->db->insert('regform', $insert);
    return $this->db->insert_id();
  }

  public function Count_Print($array)
  {

    $this->db->select('*');
    $this->db->from('regform');
    $this->db->where('Semester            =', $array['sem']);
    $this->db->where('School_Year         =', $array['sy']);
    $this->db->where('Student_Number      =', $array['refnum']);
    $this->db->or_where('Reference_Number =', $array['refnum']);
    $query = $this->db->get();
    return $query;
  }
}
