<?php


class SubjectEdit_Model extends CI_Model
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
            C.id AS fees_enrolled_college_id,
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
        $this->db->where('A.Student_Number = ', $array['student_num']);
        $this->db->or_where('A.Reference_Number = ', $array['student_num']);
        $this->db->group_end();
        $this->db->where('A.Student_Number != ', '0');
        $this->db->where('B.Cancelled = ', '0');
        $this->db->where('B.Dropped = ', '0');
        $this->db->where('D.Valid = ', '1');
        $this->db->where('H.Valid = ', '1');
        $this->db->order_by('D.Sched_Code', 'ASC');
        $this->db->group_by('D.Sched_Code');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return $query->result_array();
        }
    }

    public function Validate_enrollment_status($array)
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
            C.id AS fees_enrolled_college_id,
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
            J.Instructor_Name,
            CI.Curriculum_Name
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
        $this->db->join('`Curriculum_Info` AS CI', 'CI.Curriculum_ID = `A`.`Curriculum`', 'LEFT');
        $this->db->join('`Instructor` AS J', 'J.ID = `D`.`Instructor_ID`', 'LEFT');
        $this->db->join('`Program_Majors` AS K', '`K`.`ID` = `A`.`Major`', 'LEFT');
        $this->db->join('`Time` AS `L`', '`H`.`Start_Time` = `L`.`Time_From`', 'LEFT');
        $this->db->join('`Time` AS `L2`', '`H`.`End_Time` = `L2`.`Time_To`', 'LEFT');
        $this->db->group_start();
        $this->db->where('A.Student_Number = ', $array['student_num']);
        $this->db->or_where('A.Reference_Number = ', $array['student_num']);
        $this->db->group_end();
        $this->db->where('A.Student_Number != ', '0');
        $this->db->where('B.Cancelled = ', '0');
        $this->db->where('B.Dropped = ', '0');
        $this->db->where('D.Valid = ', '1');
        $this->db->order_by('D.Sched_Code', 'ASC');
        $this->db->group_by('D.Sched_Code');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return $query->result_array();
        }
    }

    public function validate_sched($sc)
    {

        $this->db->select('count(*) as result');
        $this->db->from('Sched');
        $this->db->where('Sched_Code', $sc);
        $this->db->where('Valid', 1);
        $result = $this->db->get();
        return $result->result_array();
    }
    public function validate_sched_existing($array_data)
    {

        $this->db->form('EnrolledStudent_Subjects AS e');
        $this->db->where('e.`School_Year`', $array_data['sy']);
        $this->db->where('e.`Semester`', $array_data['sem']);
        $this->db->where('e.`Student_Number`', $array_data['sn']);
        $this->db->where('e.`Sched_Code`', $array_data['sc']);

        $query = $this->db->get();
        // reset query
        $this->db->reset_query();

        return $query->result_array();
    }
    public function validate_sched_conflict($array_data)
    {

        $this->db->select('
        e.`Student_Number`, 
        e.`Reference_Number`,
        e.`Sched_Code as SC`,
        s.`Sched_Code`,
        s.`Course_Code`,
        sd.`Start_Time`,
        sd.`End_Time`,
        sd.`Day`,
        sd.`RoomID`
        ');
        $this->db->from('EnrolledStudent_Subjects AS e');
        $this->db->join('Sched AS s', 'e.Sched_Code = s.`Sched_Code`');
        $this->db->join('Sched_Display AS sd', 'sd.Sched_Code = s.`Sched_Code`');
        $this->db->where('e.`School_Year`', $array_data['sy']);
        $this->db->where('e.`Semester`', $array_data['sem']);
        $this->db->where('e.`Dropped`', '0');
        $this->db->where('e.`Cancelled`', '0');
        $this->db->where('e.`Charged`', '0');
        $this->db->where('e.`Reference_Number`', $array_data['sn']);
        $this->db->where('sd.`Valid`', 1);
        $this->db->like('sd.`Day`', $array_data['day']);

        $where_check_time = '
        ((sd.`Start_Time` BETWEEN ' . $array_data['end_time'] . ' AND ' . $array_data['start_time'] . ') 
        OR (sd.`End_Time` BETWEEN ' . $array_data['end_time'] . ' AND ' . $array_data['start_time'] . ')
        OR (' . $array_data['start_time'] . ' BETWEEN sd.`Start_Time` AND sd.`End_Time` AND ' . $array_data['end_time'] . '  BETWEEN sd.`Start_Time` AND sd.`End_Time` )
        OR (' . $array_data['start_time'] . ' >= sd.`Start_Time` AND ' . $array_data['start_time'] . ' < sd.`End_Time`)
        OR (' . $array_data['end_time'] . ' > sd.`Start_Time` AND ' . $array_data['end_time'] . ' <= sd.`End_Time`)
        OR (' . $array_data['start_time'] . '  <= sd.`Start_Time` AND ' . $array_data['end_time'] . '  >= sd.`End_Time`) )
        ';
        $this->db->where($where_check_time);

        /*
        $this->input->where('sd.`Start_Time` >=',$array_data['st']);
        $this->input->where('sd.`End_Time` <=',$array_data['et']);
        */

        $query = $this->db->get();

        // reset query
        $this->db->reset_query();

        return $query->result_array();
    }
    public function get_sched_open($array_data)
    {
        $this->db->select('*, C.id AS sched_display_id');
        $this->db->from('Sections AS A');
        $this->db->join('Sched AS B', 'A.Section_ID = B.Section_ID', 'inner');
        $this->db->join('Sched_Display AS C', 'B.Sched_Code = C.Sched_Code', 'inner');
        //$this->db->join('Legend AS D', 'B.SchoolYear = D.School_Year AND B.Semester = D.Semester', 'inner');
        $this->db->join('`Subject` AS E', 'E.Course_Code = B.Course_Code', 'inner');
        $this->db->join('Room AS R', 'C.RoomID = R.ID', 'inner');
        $this->db->join('Instructor AS I', 'I.ID = C.Instructor_ID', 'left');
        $this->db->where('B.Valid', 1);
        $this->db->where('C.Valid', 1);
        $this->db->where('B.SchoolYear', $array_data['school_year']);
        $this->db->where('B.Semester', $array_data['semester']);
        $this->db->order_by('B.`Sched_Code`', 'ASC');
        $this->db->limit($array_data['limit'], $array_data['start']);

        $query = $this->db->get();
        // reset query
        $this->db->reset_query();

        return $query->result_array();
    }
    public function addsubject_enrolled($array)
    {

        $this->db->trans_start();
        $this->db->insert('EnrolledStudent_Subjects', $array);
        $this->db->trans_complete();

        return $this->db->trans_status();
    }
    public function get_programs()
    {
        $result = $this->db->get('Programs');
        return $result->result_array();
    }
    public function get_program_info($array)
    {

        $this->db->where('Program_Code', $array['Program_Code']);
        $result = $this->db->get('Programs');
        return $result->result_array();
    }
    public function get_program_majors($array)
    {

        $this->db->join('Program_Majors AS B', 'A.Program_Code = B.Program_Code');
        $this->db->where('A.Program_Code', $array['Program_Code']);
        $result = $this->db->get('Programs AS A');
        return $result->result_array();
    }
    public function shift_program($array, $ref)
    {

        $this->db->trans_start();
        $this->db->where('Reference_Number', $ref);
        $this->db->update('Student_Info', $array);
        $this->db->trans_complete();

        return $this->db->trans_status();
    }
    public function get_curriculum($array)
    {

        $this->db->join('Curriculum_Info AS B', 'A.Program_ID = B.Program_ID');
        $this->db->where('A.Program_Code', $array['Program_Code']);
        $result = $this->db->get('Programs as A');
        return $result->result_array();
    }

    public function Get_enrolled_with_charged($array)
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
            C.id AS fees_enrolled_college_id,
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
        $this->db->where('A.Student_Number = ', $array['student_num']);
        $this->db->or_where('A.Reference_Number = ', $array['student_num']);
        $this->db->group_end();
        $this->db->where('A.Student_Number != ', '0');
        $this->db->where('B.Cancelled = ', '0');
        //$this->db->where('B.Dropped = ','0');
        $this->db->group_start();
        $this->db->where('B.Dropped', '0');
        $this->db->or_where('B.Charged', '1');
        $this->db->group_end();
        $this->db->where('D.Valid = ', '1');
        $this->db->order_by('D.Sched_Code', 'ASC');
        $this->db->group_by('D.Sched_Code');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return $query->result_array();
        }
    }

    public function merge_sched_conflict_checker($array_data)
    {

        $this->db->select('
        e.`Student_Number`, 
        e.`Reference_Number`,
        e.`Sched_Code as SC`,
        s.`Sched_Code`,
        s.`Course_Code`,
        sd.`Start_Time`,
        sd.`End_Time`,
        sd.`Day`,
        sd.`RoomID`
        ');
        $this->db->from('EnrolledStudent_Subjects AS e');
        $this->db->join('Sched AS s', 'e.Sched_Code = s.`Sched_Code`');
        $this->db->join('Sched_Display AS sd', 'sd.Sched_Code = s.`Sched_Code`');
        $this->db->where('e.Sched_Code !=', $array_data['sched_code']);
        $this->db->where('e.`School_Year`', $array_data['school_year']);
        $this->db->where('e.`Semester`', $array_data['semester']);
        $this->db->where('e.`Dropped`', '0');
        $this->db->where('e.`Cancelled`', '0');
        $this->db->where('e.`Charged`', '0');
        $this->db->where('e.`Reference_Number`', $array_data['reference_no']);
        $this->db->where('sd.`Valid`', 1);
        $this->db->like('sd.`Day`', $array_data['day']);

        $where_check_time = '
        ((sd.`Start_Time` BETWEEN ' . $array_data['end_time'] . ' AND ' . $array_data['start_time'] . ') 
        OR (sd.`End_Time` BETWEEN ' . $array_data['end_time'] . ' AND ' . $array_data['start_time'] . ')
        OR (' . $array_data['start_time'] . ' BETWEEN sd.`Start_Time` AND sd.`End_Time` AND ' . $array_data['end_time'] . '  BETWEEN sd.`Start_Time` AND sd.`End_Time` )
        OR (' . $array_data['start_time'] . ' >= sd.`Start_Time` AND ' . $array_data['start_time'] . ' < sd.`End_Time`)
        OR (' . $array_data['end_time'] . ' > sd.`Start_Time` AND ' . $array_data['end_time'] . ' <= sd.`End_Time`)
        OR (' . $array_data['start_time'] . '  <= sd.`Start_Time` AND ' . $array_data['end_time'] . '  >= sd.`End_Time`) )
        ';
        $this->db->where($where_check_time);


        $query = $this->db->get();


        return $query->result_array();
    }

    public function Drop_Subject($reference_no, $sched_code)
    {
        $this->db->trans_start();
        $this->db->set('Dropped', '1');
        $this->db->where('Reference_Number', $reference_no);
        $this->db->where('Sched_Code', $sched_code);
        $this->db->update('EnrolledStudent_Subjects');
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            // generate an error... or use the log_message() function to log your error
            $message = "fail to insert Reservation data";
        } else {
            $message = "Insert Reservation data Success";
        }


        return $message;
    }
}
