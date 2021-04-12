<?php


class Discrepancy_Check extends CI_Model{

    public function exceeding_units($data)
    { 
        $this->db->select('
            ES.Student_Number,
            ES.Reference_Number,
            ES.Year_Level,
            ES.Status,
            SC.Sched_Code,
            Sec.Section_Name,
            SI.First_Name,
            SI.Middle_Name,
            SI.Last_Name,
            S.Course_Code,
            S.Course_Lec_Unit,
            S.Course_Lab_Unit,
            SUM(S.Course_Lec_Unit + S.Course_Lab_Unit) AS `SUBJECT_UNIT`
        ');
        $this->db->join('Sched as SC','SC.Sched_Code = ES.Sched_Code','inner');
        $this->db->join('Subject as S','S.Course_Code = SC.Course_Code','inner');
        $this->db->join('Sections as Sec','Sec.Section_ID = SC.Section_ID','left');
        $this->db->join('Student_Info as SI','SI.Reference_Number = ES.Reference_Number','inner');
        $this->db->where('ES.School_Year',$data['sy']);
        $this->db->where('ES.Semester',$data['sem']);
        $this->db->where('ES.Cancelled !=','1');
        $this->db->where('ES.Dropped !=','1');
        $this->db->having('SUBJECT_UNIT >',$data['units']);
        $this->db->group_by('ES.Reference_Number');
        $this->db->order_by('ES.Student_Number');
        $result = $this->db->get('EnrolledStudent_Subjects as ES');

        $this->db->reset_query();
        $results = array(
            'array' => $result->result_array(),
            'count' => $result->num_rows()
        );
        return $results;

        
    }

    public function semchoice(){

        $this->db->select('Semester');
        $this->db->group_by('Semester');
        $result = $this->db->get('EnrolledStudent_Subjects');

        $this->db->reset_query();
        $results = array(
            'array' => $result->result_array(),
            'count' => $result->num_rows()
        );
        return $results;

    }

    public function sychoice(){

        $this->db->select('School_Year');
        $this->db->group_by('School_Year');
        $this->db->order_by('School_Year','desc');
        $result = $this->db->get('EnrolledStudent_Subjects');

        $this->db->reset_query();
        $results = array(
            'array' => $result->result_array(),
            'count' => $result->num_rows()
        );
        return $results;
        
    }


   

}