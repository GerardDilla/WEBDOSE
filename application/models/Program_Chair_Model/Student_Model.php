<?php


class Student_Model extends CI_Model
{
    public function get_info($ref_student_number)
    {
        $this->db->select('*');
        $this->db->from('Student_Info');
        $this->db->where('Student_Number',$ref_student_number);
        $this->db->or_where('Reference_Number',$ref_student_number);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function check_enrolled($semester, $school_year, $reference_number)
    {
        $this->db->select('*');
        $this->db->from('EnrolledStudent_Subjects');
        $this->db->where('Semester', $semester);
        $this->db->where('School_Year', $school_year);
        $this->db->where('Reference_Number', $reference_number);
        $query = $this->db->get();
        return $query->result_array();                       
    }

    public function get_schedule($semester, $school_year, $reference_number)
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
        $this->db->join('EnrolledStudent_Subjects AS B', 'B.Reference_Number = A.Reference_Number', 'INNER');
        $this->db->join('Sched AS D', 'B.Sched_Code = D.Sched_Code','LEFT');
        $this->db->join('`Sections` AS E', 'E.Section_ID = D.Section_ID','LEFT');
        // $this->db->join('`Legend` AS F', 'D.SchoolYear = F.School_Year AND `D`.`Semester` = `F`.`Semester` ','LEFT');
        $this->db->join('`Subject` AS G', 'G.Course_Code = D.Course_Code','LEFT');
        $this->db->join('`Sched_Display` AS H', 'H.Sched_Code = D.Sched_Code','LEFT');
        $this->db->join('`Room` AS I', 'H.RoomID = I.ID','LEFT');
        $this->db->join('`Instructor` AS J', 'J.ID = `D`.`Instructor_ID`','LEFT');
        $this->db->join('`Program_Majors` AS K', 'A.Major = `K`.`ID`','LEFT');
        $this->db->join('`Time` AS `L`', '`H`.`Start_Time` = `L`.`Time_From`','LEFT');
        $this->db->join('`Time` AS `L2`', '`H`.`End_Time` = `L2`.`Time_To`','LEFT');
        $this->db->where('B.Semester',  $semester);
        $this->db->where('B.School_Year', $school_year);
        $this->db->where('B.Reference_Number',$reference_number);
        $this->db->where('B.Cancelled','0');
        $this->db->where('B.Dropped','0');
        $this->db->where('D.Valid', '1');
        $this->db->where('H.Valid', '1');
        $this->db->order_by('D.Sched_Code','ASC');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function get_student_department($student_program_code)
    {
        $this->db->select('SI.School_Code');
        $this->db->from('Programs AS P');
        $this->db->join('School_Info AS SI', 'P.School_ID = SI.School_ID', 'inner');
        $this->db->where('P.Program_Code', $student_program_code);

        $query = $this->db->get();
        $department = $query->result_array();

        return $department[0]['School_Code'];
    } 
}