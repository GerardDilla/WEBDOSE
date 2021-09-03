<?php


class Student_Model extends CI_Model
{

    public function get_student_year($reference_no)
    {
        $this->db->select('*');
        $this->db->from('Fees_Enrolled_College');
        $this->db->where('Reference_Number', $reference_no);
        $this->db->order_by('YearLevel', 'DESC');
        $query = $this->db->get();

        // reset query
        $this->db->reset_query();

        $array_result = $query->result_array();

        return $array_result[0]['YearLevel'];
    }

    public function get_student_info_by_reference_no($reference_no)
    {
        $this->db->select('*, PM1.`Program_Major` AS 1st_major, PM2.`Program_Major` AS 2nd_major, PM3.`Program_Major` AS 3rd_major');
        $this->db->from('Student_Info AS SI');
        $this->db->join('`Program_Majors` AS PM1', 'PM1.`ID` = SI.`Course_Major_1st`');
        $this->db->join('Program_Majors AS PM2', 'PM2.`ID` = SI.`Course_Major_2nd`');
        $this->db->join('Program_Majors AS PM3', 'PM3.`ID` = SI.`Course_Major_3rd`');
        $this->db->where('Reference_Number', $reference_no);
        $query = $this->db->get();

        // reset query
        $this->db->reset_query();

        return $query->result_array();
    }

    public function get_student_info_by_student_no($student_no)
    {
        $this->db->select('*');
        $this->db->from('Student_Info');
        $this->db->join('Program_Majors', '`Program_Majors`.`ID` = `Student_Info`.`Major`');
        $this->db->where('Student_Number', $student_no);
        $this->db->where('Student_Number !=', 0);


        $query = $this->db->get();

        // reset query
        $this->db->reset_query();

        return $query->result_array();
    }

    public function check_student_enrolled($reference_no)
    {
        $this->db->select('*');
        $this->db->from('Fees_Enrolled_College AS FEC');
        $this->db->join('Legend AS L', 'FEC.schoolyear = L.School_Year AND FEC.semester = L.Semester', 'inner');
        $this->db->where('FEC.Reference_Number', $reference_no);

        $query = $this->db->get();

        // reset query
        $this->db->reset_query();

        return $query->result_array();
    }

    public function get_student_curriculum($curriculum_id)
    {
        $this->db->select('*');
        $this->db->from('Curriculum_Info');
        $this->db->where('Curriculum_ID', $curriculum_id);
        $this->db->where('Valid', 1);

        $query = $this->db->get();

        // reset query
        $this->db->reset_query();

        return $query->result_array();
    }

    public function get_student_course_grade($array_data)
    {
        $this->db->select('*');
        $this->db->from('Grading');
        $this->db->where('Student_Number', $array_data['student_no']);
        $this->db->where('Subject_Code', $array_data['course_code_pre_req']);

        $query = $this->db->get();

        // reset query
        $this->db->reset_query();

        return $query->result_array();
    }

    public function check_sched_session_duplicate($array_data)
    {
        $this->db->select('*');
        $this->db->from('advising_session AS ASess');
        $this->db->join('Sched AS S', 'S.`Sched_Code` = ASess.`Sched_Code`', 'inner');
        $this->db->where('ASess.`Reference_Number`', $array_data['reference_no']);
        $this->db->where('S.`Course_Code`', $array_data['course_code']);
        $this->db->where('ASess.`valid`', 1);
        $query = $this->db->get();

        // reset query
        $this->db->reset_query();

        return $query->result_array();
    }


    public function insert_sched_session($array_data)
    {

        $this->db->insert('advising_session', $array_data);
    }

    public function get_sched_session($array_data)
    {
        $this->db->select('*, `ASess`.`ID` AS session_id');
        $this->db->from('advising_session AS ASess');
        $this->db->join('Sched AS S', 'S.`Sched_Code` = ASess.`Sched_Code`', 'inner');
        $this->db->join('Sched_Display AS SD', 'ASess.`Sched_Display_ID` = SD.`id`', 'inner');
        $this->db->join('`Subject` AS Subj', '`Subj`.`Course_Code` = S.`Course_Code`', 'inner');
        $this->db->join('`Sections` AS Sec', '`Sec`.`Section_ID` = S.`Section_ID`', 'inner');
        $this->db->join('Room AS R', 'R.`ID` = SD.`RoomID`', 'inner');
        $this->db->join('`Instructor` AS Ins', 'Ins.`ID` = SD.`Instructor_ID`', 'left');
        $this->db->where('ASess.`Reference_Number`', $array_data['reference_no']);
        $this->db->where('ASess.`valid`', 1);
        $query = $this->db->get();

        // reset query
        $this->db->reset_query();

        return $query->result_array();
    }
    public function get_sched_session_units($array_data)
    {
        $this->db->select('SUM(Subj.Course_Lec_Unit + Course_Lab_Unit) AS total_units');
        $this->db->from('advising_session AS ASess');
        $this->db->join('Sched AS S', 'S.`Sched_Code` = ASess.`Sched_Code`', 'inner');
        $this->db->join('Sched_Display AS SD', 'ASess.`Sched_Display_ID` = SD.`id`', 'inner');
        $this->db->join('`Subject` AS Subj', '`Subj`.`Course_Code` = S.`Course_Code`', 'inner');
        $this->db->join('`Sections` AS Sec', '`Sec`.`Section_ID` = S.`Section_ID`', 'inner');
        $this->db->join('Room AS R', 'R.`ID` = SD.`RoomID`', 'inner');
        $this->db->join('`Instructor` AS Ins', 'Ins.`ID` = SD.`Instructor_ID`', 'left');
        $this->db->where('ASess.`Reference_Number`', $array_data['reference_no']);
        $this->db->where('ASess.`valid`', 1);
        $query = $this->db->get();

        // reset query
        $this->db->reset_query();

        return $query->result_array();
    }
    public function get_sched_advised($array_data)
    {
        $this->db->select('*');
        $this->db->from('Advising AS Adv');
        $this->db->join('Sched AS S', 'S.`Sched_Code` = Adv.`Sched_Code`', 'inner');
        $this->db->join('Sched_Display AS SD', 'Adv.`Sched_Display_ID` = SD.`id`', 'inner');
        $this->db->join('`Subject` AS Subj', '`Subj`.`Course_Code` = S.`Course_Code`', 'inner');
        $this->db->join('`Sections` AS Sec', '`Sec`.`Section_ID` = S.`Section_ID`', 'inner');
        $this->db->join('Room AS R', 'R.`ID` = SD.`RoomID`', 'inner');
        $this->db->join('`Instructor` AS Ins', 'Ins.`ID` = SD.`Instructor_ID`', 'left');
        $this->db->where('Adv.`Reference_Number`', $array_data['reference_no']);
        $this->db->where('Adv.`valid`', 1);
        $query = $this->db->get();

        // reset query
        $this->db->reset_query();

        return $query->result_array();
    }

    public function check_advising_conflict($array_data)
    {
        $day_array = explode(',', $array_data['day_array']);

        $where_check_time = '
        ((C.`Start_Time` BETWEEN "' . $array_data['end_time'] . '" AND "' . $array_data['start_time'] . '") 
        OR (C.`End_Time` BETWEEN "' . $array_data['end_time'] . '" AND "' . $array_data['start_time'] . '")
        OR ("' . $array_data['start_time'] . '" BETWEEN C.`Start_Time` AND C.`End_Time` AND "' . $array_data['end_time'] . '"  BETWEEN C.`Start_Time` AND C.`End_Time` )
        OR ("' . $array_data['start_time'] . '" >= C.`Start_Time` AND "' . $array_data['start_time'] . '" < C.`End_Time`)
        OR ("' . $array_data['end_time'] . '" > C.`Start_Time` AND "' . $array_data['end_time'] . '" <= C.`End_Time`)
        OR ("' . $array_data['start_time'] . '"  <= C.`Start_Time` AND "' . $array_data['end_time'] . '"  >= C.`End_Time`) )
        ';

        $this->db->select('*');
        $this->db->from('advising_session AS ASess');
        $this->db->join('Sched AS S', 'S.`Sched_Code` = ASess.`Sched_Code`', 'inner');
        $this->db->join('Sched_Display AS C', 'ASess.`Sched_Display_ID` = C.`id`', 'inner');
        //$this->db->join('Legend AS L', 'S.SchoolYear = L.School_Year AND S.Semester = L.Semester', 'inner');
        $this->db->where('ASess.School_Year', $array_data['school_year']);
        $this->db->where('ASess.Semester', $array_data['semester']);
        $this->db->where('ASess.`Reference_Number`', $array_data['reference_no']);
        $this->db->where('`ASess`.`valid`', 1);
        // $this->db->where('C.RoomID !=', 93); //excempt room TBA

        $count = 0;
        $dayget = '';
        foreach ($day_array as $data) {
            if ($count == 0) {
                $dayget .= "`Day` LIKE '$data' ESCAPE '!'";
                $count++;
            } else {
                $dayget .= "OR `Day`LIKE '$data' ESCAPE '!'";
            }
        }
        $this->db->where('(' . $dayget . ')');

        $this->db->where($where_check_time);

        $query = $this->db->get();

        // reset query
        $this->db->reset_query();

        return $query->result_array();
    }

    public function remove_advising_session($array_data)
    {
        $this->db->set('valid', 0);
        $this->db->where('ID', $array_data['id']);
        $this->db->update('advising_session');
    }

    public function delete_advising_session($array_data)
    {
        $this->db->set('valid', 0);
        $this->db->where('Reference_Number', $array_data['reference_no']);
        $this->db->update('advising_session');

        $query_log = $this->db->last_query();
        // reset query
        $this->db->reset_query();

        return $query_log;
    }

    public function get_year_level($array_data)
    {
        $this->db->select('COUNT(DISTINCT `School_Year`) AS year_level');
        $this->db->from('EnrolledStudent_Subjects');
        $this->db->where('Reference_Number', $array_data['reference_no']);

        $query = $this->db->get();

        //echo $this->db->last_query();

        // reset query
        $this->db->reset_query();

        return $query->result_array();
    }

    public function get_year_level_v2($array_data)
    {
        $this->db->select('*');
        $this->db->from('Sections');
        $this->db->where('Section_ID', $array_data['section']);

        $query = $this->db->get();

        //echo $this->db->last_query();

        // reset query
        $this->db->reset_query();

        return $query->result_array();
    }

    public function insert_sched_info($array_data)
    {
        /*
        $this->db->select('`Reference_Number`, `Student_Number`, `Sched_Code`, `Sched_Display_ID`, `Semester`, School_Year, `Status`, Program, Major, Year_Level, Section');
        $this->db->from('`advising_session`'); 
        $this->db->where('`Reference_Number`', $array_data['reference_no']);
        $this->db->where('`valid`', 1);
        $query = $this->db->get();
        $this->db->insert('EnrolledStudent_Payments', $array_insert);
        */
        $reference_no = $array_data['reference_no'];
        $query = $this->db->query("
            INSERT INTO Advising (Reference_Number, Student_Number, Sched_Code, Sched_Display_ID, Semester, School_Year, `Status`, Program, Major, Year_Level, Section)
            SELECT Adv.`Reference_Number`, Adv.`Student_Number`, Adv.`Sched_Code`, Adv.`Sched_Display_ID`, Adv.`Semester`, Adv.School_Year, Adv.`Status`, 
            Adv.Program, Adv.Major, Adv.Year_Level, Sec.Section_Name 
            FROM `advising_session` AS Adv
            INNER JOIN Sections AS Sec ON Adv.Section = Sec.Section_ID
            WHERE Adv.`Reference_Number` = $reference_no
            AND Adv.`valid` = '1'
        ");

        $query_log = $this->db->last_query();
        // reset query
        $this->db->reset_query();

        return $query_log;
    }

    public function remove_sched_info($array_data)
    {
        $this->db->set('valid', 0);
        $this->db->where('Reference_Number', $array_data['reference_no']);
        $this->db->where('Semester', $array_data['semester']);
        $this->db->where('School_Year', $array_data['school_year']);
        $this->db->update('Advising');

        $query_log = $this->db->last_query();
        // reset query
        $this->db->reset_query();

        return $query_log;
    }

    public function update_student_curriculum($array_data)
    {
        $this->db->set('Curriculum', $array_data['curriculum']);
        $this->db->where('Reference_Number', $array_data['reference_no']);
        $this->db->update('Student_Info');

        $query_log = $this->db->last_query();
        // reset query
        $this->db->reset_query();

        return $query_log;
    }
    public function search_student_info($array_data)
    {
        if ($array_data['type'] == "college") {
            $this->db->select('*');
            $this->db->from('Student_Info');
            $this->db->like('Student_Number', $array_data['key']);
            $this->db->or_like('Reference_Number', $array_data['key']);
            $this->db->or_like('First_Name', $array_data['key']);
            $this->db->or_like('Middle_Name', $array_data['key']);
            $this->db->or_like('Last_Name', $array_data['key']);
            // $this->db->where('Student_Number !=', 0);
            $this->db->limit($array_data['limit'], $array_data['start']);

            $query = $this->db->get();
            $this->db->reset_query();
            return $query->result_array();
        } else if ($array_data['type'] == "basiced") {
            $this->db->select('*');
            $this->db->from('Basiced_Studentinfo');
            $this->db->like('Student_Number', $array_data['key']);
            $this->db->or_like('Reference_Number', $array_data['key']);
            $this->db->or_like('First_Name', $array_data['key']);
            $this->db->or_like('Middle_Name', $array_data['key']);
            $this->db->or_like('Last_Name', $array_data['key']);
            // $this->db->where('Student_Number !=', 0);
            $this->db->limit($array_data['limit'], $array_data['start']);

            $query = $this->db->get();
            $this->db->reset_query();
            return $query->result_array();
        }
    }
    public function search_student_info_pages($array_data)
    {
        if ($array_data['type'] == "college") {
            $this->db->select('*');
            $this->db->from('Student_Info');
            $this->db->like('Student_Number', $array_data['key']);
            $this->db->or_like('Reference_Number', $array_data['key']);
            $this->db->or_like('First_Name', $array_data['key']);
            $this->db->or_like('Middle_Name', $array_data['key']);
            $this->db->or_like('Last_Name', $array_data['key']);
            // $this->db->where('Student_Number !=', 0);

            $query = $this->db->get();
            $this->db->reset_query();
            return $query->num_rows();
        } else if ($array_data['type'] == "basiced") {
            $this->db->select('*');
            $this->db->from('Basiced_Studentinfo');
            $this->db->like('Student_Number', $array_data['key']);
            $this->db->or_like('Reference_Number', $array_data['key']);
            $this->db->or_like('First_Name', $array_data['key']);
            $this->db->or_like('Middle_Name', $array_data['key']);
            $this->db->or_like('Last_Name', $array_data['key']);

            // $this->db->where('Student_Number !=', 0);

            $query = $this->db->get();
            $this->db->reset_query();
            return $query->num_rows();
        }
    }
    public function check_advised($array)
    {

        $this->db->where('Reference_Number', $array['Reference_Number']);
        //$this->db->where('School_Year', $array['School_Year']);
        //$this->db->where('Semester', $array['Semester']);
        $this->db->where('Dropped', 0);
        $this->db->where('Cancelled', 0);
        $this->db->where('valid', 1);
        $this->db->order_by('ID', 'DESC');
        /*
        $this->db->order_by('School_Year', 'DESC');
        $this->db->order_by('Semester', 'DESC');
        */
        $result = $this->db->get('Advising');
        $this->db->reset_query();
        return $result->result_array();
    }

    public function get_student_school_info($program_code)
    {
        $this->db->trans_start();
        $this->db->select('*');
        $this->db->from('Programs AS P');
        $this->db->join('School_Info AS SI', 'P.School_ID = SI.School_ID');
        $this->db->where('P.Program_Code', $program_code);
        $this->db->trans_complete();

        $query = $this->db->get();

        // reset query
        $this->db->reset_query();

        return $query->result_array();
    }

    public function check_if_foreigner($reference_no)
    {
        $this->db->trans_start();
        $this->db->select('Reference_Number');
        $this->db->from('Student_Info');
        $this->db->where('Reference_Number', $reference_no);
        $this->db->where('Nationality !=', 'FILIPINO');
        $this->db->trans_complete();

        $query = $this->db->get();

        // reset query
        $this->db->reset_query();

        return $query->num_rows();
    }
    public function testQuery($array_data)
    {
        $this->db->select('*');
        $this->db->from('Basiced_Studentinfo');
        $this->db->like('Student_Number', $array_data['key']);
        $this->db->or_like('Reference_Number', $array_data['key']);
        $this->db->or_like('First_Name', $array_data['key']);
        $this->db->or_like('Middle_Name', $array_data['key']);
        $this->db->or_like('Last_Name', $array_data['key']);
        $this->db->orWhere(function ($query, $array_data) {
            $query->db->or_like('Last_Name', $array_data['key']);
            $this->db->or_like('First_Name', $array_data['key']);
            $this->db->or_like('Middle_Name', $array_data['key']);
        });
        // $sql = "SELECT * FROM Basiced_Studentinfo WHERE Last_Name = '?' AND Student_Number <> 0";
        // $this->db->query($sql, array($array_data['key']));

        // $query = $this->db->query("SELECT * FROM Basiced_Studentinfo WHERE Last_Name = 'MAGTIRA' AND Student_Number != 0");
        // $this->db->where('Student_Number !=', 0);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function decryptPass($id)
    {
        $this->db->select('*,AES_DECRYPT(`Password`, \`Password\`)');
        $this->db->from('Users');
        $this->db->where('User_ID', $id);
        $result = $this->db->get();
        return $result->result_array();
        // $this->db->where('AES_DECRYPT(`Password`, \`'.$array_data['password'].'\`) = \''.$array_data['password'].'\'');
    }
}
