<?php


class Enrollment_Tracker_Report_Model extends CI_Model
{
    public function Enrollment_Summary_Report_List($array)
    {
        $this->db->select('
            si.Reference_Number as Ref_Num_si,
            si.Student_Number as Std_Num_si,
            ftc.Reference_Number as Ref_Num_ftc,
            fec.Reference_Number as Ref_Num_fec,
            si.First_Name, si.Middle_Name, si.Last_Name,
            si.Gender, si.Nationality, si.YearLevel,
            si.Course_1st, si.Course_2nd, si.Course_3rd,
            si.Others_Know_SDCA, si.Tel_No, si.CP_No,
            si.Address_City, si.Address_Province,
            si.Applied_SchoolYear, si.Applied_Semester
        ');
        $this->db->from('Student_Info si');
        $this->db->order_by('si.Reference_Number', 'DESC');
        $this->db->join('Fees_Temp_College ftc', 'si.Reference_Number = ftc.Reference_Number', 'LEFT');
        // $this->db->join('EnrolledStudent_Payments ep', 'si.Reference_Number = ep.Reference_Number', 'left');
        // $this->db->where('ep.Reference_Number !=','');
        // $this->db->where('ftc.Reference_Number !=','');
        $this->db->join('Fees_Enrolled_College fec', 'si.Reference_Number = fec.Reference_Number', 'LEFT');

        if (!empty($array['sy']) || $array['sy'] != 0) {
            $this->db->where('si.Applied_SchoolYear =', $array['sy']);
        }
        if (!empty($array['sem']) || $array['sem'] != 0) {
            $this->db->where('si.Applied_Semester =', $array['sem']);
        }
        if (!empty($array['course'] || $array['course'] != null)) {
            $this->db->where('si.Course =', $array['course']);
        }
        $this->db->group_by('si.Reference_Number');
        $query = $this->db->get();

        return $query->result_array();
        // die(json_encode( $query->result_array()));
    }
    public function Enrollment_Summary_Like_Search($data)
    {
        $this->db->select('
            si.Reference_Number as Ref_Num_si,
            si.Student_Number as Std_Num_si,
            ftc.Reference_Number as Ref_Num_ftc,
            fec.Reference_Number as Ref_Num_fec,
            si.First_Name, si.Middle_Name, si.Last_Name,
            si.Gender, si.Nationality, si.YearLevel,
            si.Course_1st, si.Course_2nd, si.Course_3rd,
            si.Others_Know_SDCA, si.Tel_No, si.CP_No,
            si.Address_City, si.Address_Province,
            si.Applied_SchoolYear, si.Applied_Semester
        ');
        $this->db->from('Student_Info si');
        $this->db->order_by('si.Reference_Number', 'DESC');
        $this->db->join('Fees_Temp_College ftc', 'si.Reference_Number = ftc.Reference_Number', 'LEFT');
        $this->db->join('Fees_Enrolled_College fec', 'si.Reference_Number = fec.Reference_Number', 'LEFT');
        $this->db->like('si.First_Name', $data);
        $this->db->or_like('si.Middle_Name', $data);
        $this->db->or_like('si.Last_Name', $data);
        $this->db->or_like('si.Email', $data);
        $this->db->or_like('si.CP_No', $data);
        $this->db->or_like('si.Tel_No', $data);
        $this->db->or_like('si.Reference_Number', $data);
        $this->db->or_like('si.Student_Number', $data);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function Inquiry_List($array)
    {
        $this->db->select('
            si.Reference_Number as Ref_Num_si,
            si.Student_Number as Std_Num_si,
            fec.Reference_Number as Ref_Num_fec,
            si.First_Name,si.Middle_Name,Last_Name,

            si.Gender,si.Nationality,si.YearLevel,

            si.Course_1st,si.Course_2nd,si.Course_3rd,
            si.Others_Know_SDCA,si.Tel_No,si.CP_No,
            si.Address_City,si.Address_Province,
            si.Applied_SchoolYear,si.Applied_Semester
        ');
        $this->db->from('Student_Info si');
        $this->db->order_by('si.Reference_Number', 'DESC');
        $this->db->join('Fees_Temp_College ftc', 'si.Reference_Number = ftc.Reference_Number', 'LEFT');
        $this->db->join('Fees_Enrolled_College fec', 'si.Reference_Number = fec.Reference_Number', 'LEFT');
        $this->db->where('ftc.Reference_Number is null');
        $this->db->where('fec.Reference_Number IS NULL');
        if (!empty($array['sy']) || $array['sy'] != 0) {
            $this->db->where('si.Applied_SchoolYear =', $array['sy']);
        }
        if (!empty($array['sem']) || $array['sem'] != 0) {
            $this->db->where('si.Applied_Semester =', $array['sem']);
        }
        if (!empty($array['course'] || $array['course'] != null)) {
            $this->db->where('si.Course =', $array['course']);
        }
        $this->db->group_by('si.Reference_Number');
        $query = $this->db->get();
        return $query->result_array();
    }
    public function Advised_List($array)
    {
        $this->db->select('
            ftc.Course as Course_ftc,
            ftc.Reference_Number as Ref_Num_ftc,
            
            si.Reference_Number as Ref_Num_si,
            si.Student_Number as Std_Num_si,
            si.First_Name,si.Middle_Name,Last_Name,

            si.Gender,si.Nationality,si.YearLevel,
            
            si.Course_1st,si.Course_2nd,si.Course_3rd,
            si.Others_Know_SDCA,si.Tel_No,si.CP_No,
            si.Address_City,si.Address_Province,
            si.Applied_SchoolYear,si.Applied_Semester
        ');
        $this->db->from('Fees_Temp_College ftc');

        $this->db->order_by('ftc.id', 'DESC');
        $this->db->join('Student_Info si', 'si.Reference_Number = ftc.Reference_Number', 'LEFT');
        // $this->db->join('EnrolledStudent_Payments ep', 'ep.Reference_Number = ftc.Reference_Number', 'left');
        $this->db->join('Fees_Enrolled_College fec', 'si.Reference_Number = fec.Reference_Number', 'LEFT');
        $this->db->where('fec.Reference_Number is null');
        $this->db->where('si.First_Name IS NOT NULL');
        $this->db->where('si.Reference_Number IS NOT NULL');
        if (!empty($array['sy']) || $array['sy'] != 0) {
            $this->db->where('si.Applied_SchoolYear =', $array['sy']);
        }
        if (!empty($array['sem']) || $array['sem'] != 0) {
            $this->db->where('si.Applied_Semester =', $array['sem']);
        }
        if (!empty($array['course'] || $array['course'] != null)) {
            $this->db->where('si.Course =', $array['course']);
        }
        $this->db->group_by('si.Reference_Number');
        $query = $this->db->get();
        return $query->result_array();
    }
    public function Enrolled_Student_List($array)
    {
        // die($array['sem']);
        // die(json_encode($array));
        $this->db->select('*');
        // $this->db->from('EnrolledStudent_Payments ep');
        $this->db->from('Fees_Enrolled_College fec');
        $this->db->order_by('id', 'DESC');
        $this->db->join('Student_Info si', 'si.Reference_Number = fec.Reference_Number', 'LEFT');
        // $this->db->where('ep.valid','1');
        $this->db->where('si.Reference_Number is not null');
        if (!empty($array['sy']) || $array['sy'] != 0) {
            $this->db->where('si.Applied_SchoolYear', $array['sy']);
        }
        if (!empty($array['sem']) || $array['sem'] != 0) {
            $this->db->where('si.Applied_Semester', $array['sem']);
        }
        if (!empty($array['course'] || $array['course'] != null)) {
            $this->db->where('si.Course', $array['course']);
        }
        $this->db->group_by('fec.Reference_Number');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function Highered_Reserved($array)
    {
        $this->db->select('*,
            rf.Reference_No as Ref_No_rf,
            si.Course as Course_si,
        ');
        $this->db->from('ReservationFee rf');
        $this->db->join('Student_Info si', 'rf.`Reference_No` = si.`Reference_Number`', 'LEFT');
        $this->db->join('EnrolledStudent_Payments ep', 'rf.Reference_No = ep.Reference_Number', 'left');
        $this->db->join('Fees_Enrolled_College fec', 'rf.Reference_No = fec.Reference_Number', 'LEFT');
        //   $this->db->where('rf.semester', $array['sem']);
        //   $this->db->where('rf.schoolyear', $array['sy']);
        if (!empty($array['sy']) || $array['sy'] != 0) {
            $this->db->where('si.Applied_SchoolYear =', $array['sy']);
        }
        if (!empty($array['sem']) || $array['sem'] != 0) {
            $this->db->where('si.Applied_Semester =', $array['sem']);
        }
        if (!empty($array['course'] || $array['course'] != null)) {
            $this->db->where('si.Course =', $array['course']);
        }
        $this->db->group_by('si.Reference_Number');
        $this->db->where('si.Reference_Number IS NOT NULL');
        $this->db->where('fec.Reference_Number IS NULL');
        $this->db->where('ep.Reference_Number IS NULL');
        $query = $this->db->get();

        return $query->result_array();
    }
}
