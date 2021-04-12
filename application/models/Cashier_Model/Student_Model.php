<?php


class Student_Model extends CI_Model
{
    public function get_info_academic_by_stud_no($student_no)
    {
        $this->db->select('Reference_Number, Student_Number, First_Name, Middle_Name, Last_Name, Course, Major, AdmittedSY, AdmittedSEM, YearLevel');
        $this->db->from('Student_Info');
        $this->db->join('Program_Majors', '`Program_Majors`.`ID` = `Student_Info`.`Major`');
        $this->db->where('Student_Number', $student_no);

        $query = $this->db->get();

        // reset query
        $this->db->reset_query();

        return $query->result_array();
    }

    public function get_info_academic_by_ref_no($reference_no)
    {
        $this->db->select('Reference_Number, Student_Number, First_Name, Middle_Name, Last_Name, Course, Major, AdmittedSY, AdmittedSEM, YearLevel');
        $this->db->from('Student_Info');
        $this->db->join('Program_Majors', '`Program_Majors`.`ID` = `Student_Info`.`Major`');
        $this->db->where('Reference_Number', $reference_no);

        $query = $this->db->get();

        // reset query
        $this->db->reset_query();

        return $query->result_array();
    }

    public function generate_student_number($reference_no)
    {
        $this->db->trans_start();
        $this->db->set('Used', $reference_no);
        $this->db->insert('BasicEDStudentNumber');
        $insert_id = $this->db->insert_id(); 
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE)
        {
            // generate an error... or use the log_message() function to log your error
            $message = "fail to generate student number";
            $insert_id = "";
        }
        else
        {
            $message = "Generate student number sucessful";
            
        } 

        $array_output = array(
            "message" => $message,
            "insert_id" => $insert_id
        );
        
        
        // reset query
        $this->db->reset_query();

        return $array_output;
    }

    public function update_student_number($array_data)
    {
        $this->db->trans_start();
        $this->db->set('Student_Number', $array_data['student_no']);
        $this->db->where('Reference_Number', $array_data['reference_no']);
        $this->db->update('Student_Info');
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE)
        {
            // generate an error... or use the log_message() function to log your error
            $message = "fail to insert student number";
        }
        else
        {
            $message = "Insert student number sucessful";
        } 
        
        
        // reset query
        $this->db->reset_query();

        return $message;
    }

    public function get_bed_student_info_by_reference_no()
    {
        $this->db->select('student.Reference_Number, student.Student_Number, student.First_Name, student.Middle_Name, 
        student.Last_Name, student.AdmittedSY, student.Gradelevel, student.Track, student.Strand, tracks.Track AS track_name');
        $this->db->from('Basiced_Studentinfo AS student');
        $this->db->join('SeniorHigh_Tracks AS tracks', 'student.Track = tracks.ID', 'left');
        $this->db->where('Reference_Number', $this->student_data->get_reference_no());

        $query = $this->db->get();

        // reset query
        $this->db->reset_query();

        return $query->result_array();
    }

    public function get_bed_student_info_by_student_no()
    {
        $this->db->select('student.Reference_Number, student.Student_Number, student.First_Name, student.Middle_Name, 
        student.Last_Name, student.AdmittedSY, student.Gradelevel, student.Track, student.Strand, tracks.Track AS track_name');
        $this->db->from('Basiced_Studentinfo AS student');
        $this->db->join('SeniorHigh_Tracks AS tracks', 'student.Track = tracks.ID', 'left');
        $this->db->where('Student_Number', $this->student_data->get_reference_no());

        $query = $this->db->get();

        // reset query
        $this->db->reset_query();

        return $query->result_array();
    }

    public function generate_bed_student_number()
    {
        $this->db->trans_start();
        $this->db->set('Used', $this->student_data->get_reference_no());
        $this->db->insert('BasicEDStudentNumber');
        $insert_id = $this->db->insert_id(); 
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE)
        {
            // generate an error... or use the log_message() function to log your error
            $message = "fail to generate student number";
            $insert_id = "";
        }
        else
        {
            $message = "Generate student number sucessful";
            
        } 

        $array_output = array(
            "message" => $message,
            "insert_id" => $insert_id
        );
        
        
        // reset query
        $this->db->reset_query();

        return $array_output;
    }

    public function update_bed_student_number()
    {
        $this->db->trans_start();
        $this->db->set('Student_Number', $this->student_data->get_student_no());
        $this->db->where('Reference_Number', $this->student_data->get_reference_no());
        $this->db->update('Basiced_Studentinfo');
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE)
        {
            // generate an error... or use the log_message() function to log your error
            $message = "fail to insert student number";
        }
        else
        {
            $message = "Insert student number sucessful";
        } 
        
        
        // reset query
        $this->db->reset_query();

        return $message;
    }

    public function add_stud_number_to_enrolled_fees()
    {
        $this->db->trans_start();
        $this->db->set('Student_Number', $this->student_data->get_student_no());
        $this->db->where('Reference_Number', $this->student_data->get_reference_no());
        $this->db->where('SchoolYear', $this->student_data->get_school_year());
        $this->db->update('Basiced_EnrolledFees_Local');
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE)
        {
            // generate an error... or use the log_message() function to log your error
            $message = "fail to insert student number to enrolled fees";
        }
        else
        {
            $message = "Insert student number to enrolled fees sucessful";
        } 
        
        
        // reset query
        $this->db->reset_query();

        return $message;
    }

    public function get_shs_student_info_by_reference_no()
    {
        $this->db->select('student.Reference_Number, student.Student_Number, student.First_Name, student.Middle_Name, 
        student.Last_Name, student.AdmittedSY, student.Gradelevel, student.Track, student.Strand, tracks.Track AS track_name');
        $this->db->from('Basiced_Studentinfo AS student');
        $this->db->join('SeniorHigh_Tracks AS tracks', 'student.Track = tracks.ID', 'inner');
        $this->db->where('Reference_Number', $this->student_data->get_reference_no());

        $query = $this->db->get();

        // reset query
        $this->db->reset_query();

        return $query->result_array();
    }

    public function get_shs_student_info_by_student_no()
    {
        $this->db->select('student.Reference_Number, student.Student_Number, student.First_Name, student.Middle_Name, 
        student.Last_Name, student.AdmittedSY, student.Gradelevel, student.Track, student.Strand, tracks.Track AS track_name');
        $this->db->from('Basiced_Studentinfo AS student');
        $this->db->join('SeniorHigh_Tracks AS tracks', 'student.Track = tracks.ID', 'inner');
        $this->db->where('Student_Number', $this->student_data->get_reference_no());

        $query = $this->db->get();

        // reset query
        $this->db->reset_query();

        return $query->result_array();
    }

    public function get_track_list()
    {
        $this->db->select('*');
        $this->db->from('SeniorHigh_Tracks');

        $query = $this->db->get();

        // reset query
        $this->db->reset_query();

        return $query->result_array();
    }

    public function get_strand_list($track)
    {
        $this->db->select('*');
        $this->db->from('SeniorHigh_Strand');
        $this->db->where('Track_ID', $track);

        $query = $this->db->get();

        // reset query
        $this->db->reset_query();

        return $query->result_array();
    }

    public function insert_advised_schedule()
    {
        $this->db->trans_start();
        $sql = "
        INSERT INTO EnrolledStudent_Subjects (Reference_Number, Student_Number, Sched_Code, Semester, School_Year, Scheduler, Sdate, 
            Status, Program, Major, Year_Level, Payment_Plan, Section, Dropped, Cancelled, Sched_Display_ID)
        SELECT Reference_Number, Student_Number, Sched_Code, Semester, School_Year, Scheduler, Sdate, 
            Status, Program, Major, Year_Level, Payment_Plan, Section, Dropped, Cancelled, Sched_Display_ID
        FROM Advising
        WHERE Reference_Number = ".$this->db->escape($this->student_data->get_reference_no())." 
        AND Semester = ".$this->db->escape($this->student_data->get_semester())."
        AND School_Year = ".$this->db->escape($this->student_data->get_school_year())."
        AND valid
        AND Dropped = 0
        AND Cancelled = 0
        ";
        $query = $this->db->query($sql);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE)
        {
            // generate an error... or use the log_message() function to log your error
            $message = "failed to insert advised schedule to enrolled subjects";
        }
        else
        {
            $message = "insert advised schedule to enrolled subjects sucessful";
        } 
        
        
        // reset query
        $this->db->reset_query();

        return $message;
    }

    public function check_enrolled_subjects()
    {
        $this->db->select('ID');
        $this->db->from('EnrolledStudent_Subjects');
        $this->db->where('Reference_Number', $this->student_data->get_reference_no());
        $this->db->where('Semester', $this->student_data->get_semester());
        $this->db->where('School_Year', $this->student_data->get_school_year());
        $this->db->where('Dropped', 0);
        $this->db->where('Cancelled', 0);

        $query = $this->db->get();

        // reset query
        $this->db->reset_query();

        return $query->result_array();
    }



}