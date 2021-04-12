<?php


class Schedule_Model extends CI_Model{

    public function get_time()
    {
        $this->db->select('*');
        $this->db->from('Time');

        $query = $this->db->get();

        // reset query
        $this->db->reset_query();

        return $query->result_array();
    }

    public function get_legend()
    {
        $this->db->select('*');
        $this->db->from('Legend');
        $query = $this->db->get();
        // reset query
        $this->db->reset_query();
        return $query->result_array();
    }

    //list of schedule of given sched_code
    public function get_sched_list($sched_code)
    {
        $this->db->select('*');
        $this->db->from('sched_display');
        $this->db->where('Sched_Code', $sched_code);

        $query = $this->db->get();

        // reset query
        $this->db->reset_query();

        return $query->result_array();
    }

    public function get_sched_block($array_data)
    {
        $this->db->select('*, C.id AS sched_display_id');
        $this->db->from('Sections AS A');
        $this->db->join('Sched AS B', 'A.Section_ID = B.Section_ID', 'inner');
        $this->db->join('Sched_Display AS C', 'B.Sched_Code = C.Sched_Code' ,'inner');
        //$this->db->join('Legend AS D', 'B.SchoolYear = D.School_Year AND B.Semester = D.Semester', 'inner');
        $this->db->join('`Subject` AS E', 'E.Course_Code = B.Course_Code', 'inner');
        $this->db->join('Room AS R', 'C.RoomID = R.ID', 'inner');
        $this->db->join('Instructor AS I', 'I.ID = C.Instructor_ID', 'left');
        $this->db->where('A.Active', 1);
        $this->db->where('A.Section_ID !=', 829);
        $this->db->where('B.Valid', 1);
        $this->db->where('C.Valid', 1);
        
        $this->db->where('B.SchoolYear', $array_data['school_year']);
        $this->db->where('B.Semester', $array_data['semester']);

        $this->db->where('B.Section_ID', $array_data['section']);
        $this->db->order_by('B.`Sched_Code`', 'ASC');

        $query = $this->db->get();
        // reset query
        $this->db->reset_query();

        return $query->result_array();
    }

    public function get_sched_open_row_count($array_data)
    {
        //$this->db->select('*, C.id AS sched_display_id');      
        $this->db->from('Sections AS A');
        $this->db->join('Sched AS B', 'A.Section_ID = B.Section_ID', 'inner');
        $this->db->join('Sched_Display AS C', 'B.Sched_Code = C.Sched_Code' ,'inner');
        //$this->db->join('Legend AS D', 'B.SchoolYear = D.School_Year AND B.Semester = D.Semester', 'inner');
        $this->db->join('`Subject` AS E', 'E.Course_Code = B.Course_Code', 'inner');
        $this->db->join('Room AS R', 'C.RoomID = R.ID', 'inner');
        $this->db->join('Instructor AS I', 'I.ID = C.Instructor_ID', 'left');
        $this->db->where('A.Active', 1);
        $this->db->where('A.Section_ID !=', 829);
        $this->db->where('B.Valid', 1);
        $this->db->where('B.SchoolYear', $array_data['school_year']);
        $this->db->where('B.Semester', $array_data['semester']);
        $this->db->where('C.Valid', 1);
        $this->db->order_by('B.`Sched_Code`', 'ASC');

        $count = $this->db->count_all_results();
        // reset query
        $this->db->reset_query();

        return $count;
    }

    public function get_sched_open_row_count_search($array_data)
    {
        //$this->db->select('*, C.id AS sched_display_id');      
        $this->db->from('Sections AS A');
        $this->db->join('Sched AS B', 'A.Section_ID = B.Section_ID', 'inner');
        $this->db->join('Sched_Display AS C', 'B.Sched_Code = C.Sched_Code' ,'inner');
        //$this->db->join('Legend AS D', 'B.SchoolYear = D.School_Year AND B.Semester = D.Semester', 'inner');
        $this->db->join('`Subject` AS E', 'E.Course_Code = B.Course_Code', 'inner');
        $this->db->join('Room AS R', 'C.RoomID = R.ID', 'inner');
        $this->db->join('Instructor AS I', 'I.ID = C.Instructor_ID', 'left');
        $this->db->where('B.Valid', 1);
        $this->db->where('B.SchoolYear', $array_data['school_year']);
        $this->db->where('B.Semester', $array_data['semester']);
        $this->db->where('C.Valid', 1);
        $this->db->like($array_data['search_type'], $array_data['search_value']);
        $this->db->order_by('B.`Sched_Code`', 'ASC');

        $count = $this->db->count_all_results();
        // reset query
        $this->db->reset_query();

        return $count;

    }

    public function get_sched_open($array_data)
    {
        $this->db->select('*, C.id AS sched_display_id');      
        $this->db->from('Sections AS A');
        $this->db->join('Sched AS B', 'A.Section_ID = B.Section_ID', 'inner');
        $this->db->join('Sched_Display AS C', 'B.Sched_Code = C.Sched_Code' ,'inner');
        //$this->db->join('Legend AS D', 'B.SchoolYear = D.School_Year AND B.Semester = D.Semester', 'inner');
        $this->db->join('`Subject` AS E', 'E.Course_Code = B.Course_Code', 'inner');
        $this->db->join('Room AS R', 'C.RoomID = R.ID', 'inner');
        $this->db->join('Instructor AS I', 'I.ID = C.Instructor_ID', 'left');
        $this->db->where('A.Active', 1);
        $this->db->where('A.Section_ID !=', 829);
        $this->db->where('B.Valid', 1);
        $this->db->where('C.Valid', 1);
        $this->db->where('A.Active', 1);
        $this->db->where('B.SchoolYear', $array_data['school_year']);
        $this->db->where('B.Semester', $array_data['semester']);
        $this->db->order_by('B.`Sched_Code`', 'ASC');
        $this->db->limit($array_data['limit'], $array_data['start']);

        $query = $this->db->get();
        // reset query
        $this->db->reset_query();

        return $query->result_array();
    }

    public function get_sched_open_search($array_data)
    {
        $this->db->select('*, C.id AS sched_display_id');      
        $this->db->from('Sections AS A');
        $this->db->join('Sched AS B', 'A.Section_ID = B.Section_ID', 'inner');
        $this->db->join('Sched_Display AS C', 'B.Sched_Code = C.Sched_Code' ,'inner');
        //$this->db->join('Legend AS D', 'B.SchoolYear = D.School_Year AND B.Semester = D.Semester', 'inner');
        $this->db->join('`Subject` AS E', 'E.Course_Code = B.Course_Code', 'inner');
        $this->db->join('Room AS R', 'C.RoomID = R.ID', 'inner');
        $this->db->join('Instructor AS I', 'I.ID = C.Instructor_ID', 'left');
        $this->db->where('A.Active', 1);
        $this->db->where('A.Section_ID !=', 829);
        $this->db->where('B.Valid', 1);
        $this->db->where('C.Valid', 1);
        $this->db->where('A.Active', 1);
        $this->db->where('B.SchoolYear', $array_data['school_year']);
        $this->db->where('B.Semester', $array_data['semester']);
        $this->db->like($array_data['search_type'], $array_data['search_value']);
        $this->db->order_by('B.`Sched_Code`', 'ASC');
        $this->db->limit($array_data['limit'], $array_data['start']);

        $query = $this->db->get();
        // reset query
        $this->db->reset_query();

        return $query->result_array();
    }
    
    public function get_sched_total_enrolled($array_data)
    {
        $this->db->select('(COUNT(A.Sched_Code)) AS total_enrolled');
        $this->db->from('EnrolledStudent_Subjects AS A');
        //$this->db->join('Legend AS B', 'A.School_Year = B.School_Year AND A.Semester = B.Semester', 'inner');
        //$this->db->where('Section', $array_data['section']);
        $this->db->where('A.Sched_Code', $array_data['sched_code']); 
        $this->db->where('A.Sched_Display_ID', $array_data['sched_display_id']);
        $this->db->where('A.School_Year', $array_data['school_year']);
        $this->db->where('A.Semester', $array_data['semester']);
        $this->db->where('Dropped', 0);

        //$this->db->group_by('Sched_Code');
        //$this->db->order_by('total_enrolled', 'DESC');
        $query = $this->db->get();
        // reset query
        $this->db->reset_query();

        return $query->result_array();
    }

    public function get_sched_total_enrolled_no_sd($array_data)
    {
        $this->db->select('(COUNT(A.Reference_Number)) AS total_enrolled');
        $this->db->from('EnrolledStudent_Subjects AS A');
        //$this->db->join('Sched_Display AS B', 'A.Sched_Code = B.Sched_Code', 'inner');
        //$this->db->where('Section', $array_data['section']);
        $this->db->where('A.Sched_Code', $array_data['sched_code']);
        //$this->db->where('B.id', $array_data['sched_display_id']);
        $this->db->where('A.School_Year', $array_data['school_year']);
        $this->db->where('A.Semester', $array_data['semester']);
        $this->db->where('Dropped', 0);
        $this->db->where('Cancelled', 0);
        //$this->db->group_by('Sched_Code');
        //$this->db->order_by('total_enrolled', 'DESC');

        $query = $this->db->get();
        // reset query
        $this->db->reset_query();

        return $query->result_array();

    }

    public function get_sched_total_advised($array_data)
    {

        $this->db->select('(COUNT(A.Reference_Number)) AS total_advised');
        $this->db->from('Advising AS A');
        $this->db->join('EnrolledStudent_Subjects as B', 'A.Reference_Number = B.Reference_Number and A.Sched_Code = B.Sched_Code','LEFT');
        $this->db->where('A.Sched_Code', $array_data['sched_code']);
        $this->db->where('A.School_Year', $array_data['school_year']);
        $this->db->where('A.Semester', $array_data['semester']);
        $this->db->where('B.ID', null);
        $this->db->where('A.Dropped', 0);
        $this->db->where('A.Cancelled', 0);
        $this->db->where('A.valid', 1);
        $query = $this->db->get();
        //Reset query
        $this->db->reset_query();
        return $query->result_array();

    }

    public function get_sched_info($array_data)
    {
        $this->db->select('*, C.id AS sched_display_id, T1.Schedule_Time AS stime, T2.Schedule_Time AS etime');      
        $this->db->from('Sections AS A');
        $this->db->join('Sched AS B', 'A.Section_ID = B.Section_ID', 'inner');
        $this->db->join('Sched_Display AS C', 'B.Sched_Code = C.Sched_Code' ,'inner');
        //$this->db->join('Legend AS D', 'B.SchoolYear = D.School_Year AND B.Semester = D.Semester', 'inner');
        $this->db->join('`Subject` AS E', 'E.Course_Code = B.Course_Code', 'inner');
        $this->db->join('Room AS R', 'C.RoomID = R.ID', 'inner');
        $this->db->join('Time AS T1', 'C.Start_Time = T1.Time_From', 'inner');
        $this->db->join('Time AS T2', 'C.End_Time = T2.Time_To', 'inner');
        $this->db->join('Instructor AS I', 'I.ID = C.Instructor_ID', 'left');
        $this->db->where('B.Valid', 1);
        $this->db->where('C.Valid', 1);
        $this->db->where('B.Sched_Code', $array_data['sc']);

        $query = $this->db->get();
        // reset query
        $this->db->reset_query();

        return $query->result_array();
    }

    public function get_sched_info_by_sched_display_id($sched_display_id)
    {
        $this->db->select('*, C.id AS sched_display_id, T1.Schedule_Time AS stime, T2.Schedule_Time AS etime');      
        $this->db->from('Sections AS A');
        $this->db->join('Sched AS B', 'A.Section_ID = B.Section_ID', 'inner');
        $this->db->join('Sched_Display AS C', 'B.Sched_Code = C.Sched_Code' ,'inner');
        //$this->db->join('Legend AS D', 'B.SchoolYear = D.School_Year AND B.Semester = D.Semester', 'inner');
        $this->db->join('`Subject` AS E', 'E.Course_Code = B.Course_Code', 'inner');
        $this->db->join('Room AS R', 'C.RoomID = R.ID', 'inner');
        $this->db->join('Time AS T1', 'C.Start_Time = T1.Time_From', 'inner');
        $this->db->join('Time AS T2', 'C.End_Time = T2.Time_To', 'inner');
        $this->db->join('Instructor AS I', 'I.ID = C.Instructor_ID', 'left');
        $this->db->where('B.Valid', 1);
        $this->db->where('C.Valid', 1);
        $this->db->where('C.id', $sched_display_id);

        $query = $this->db->get();
        // reset query
        $this->db->reset_query();

        return $query->result_array();
    }


    
}