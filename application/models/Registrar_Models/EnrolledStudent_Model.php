<?php


class EnrolledStudent_Model extends CI_Model
{



  public function GetSEM()
  {
    $this->db->select('*');
    $query = $this->db->get('Semesters');
    return $query;
  }

  public function GetYEAR()
  {
    $this->db->select('*');
    $query = $this->db->get('SchoolYear');
    return $query;
  }


  public function Get_Nationality()
  {
    $this->db->select('Nationality');
    $this->db->group_by("Nationality");
    $this->db->from('Nationalities');
    $query = $this->db->get();
    return $query;
  }


  public function Get_Course()
  {
    $this->db->select('Program_Code');
    $this->db->from('Programs');
    $this->db->order_by('Program_Code', ASC);
    $query = $this->db->get();
    return $query;
  }



  public function GetMajor($Program_id)
  {
    $this->db->select('*');
    $this->db->where('Program_Code = ', $Program_id);
    $this->db->from('Program_Majors');
    $query = $this->db->get();
    return $query->result_array();
  }


  public function GetSection_Name($Program_id)
  {
    $this->db->select('*,Section_Name as SN');
    $this->db->from('Programs');
    $this->db->join('Sections', 'Sections.Program_ID = Programs.Program_ID', 'LEFT');
    $this->db->where('Sections.Active', '1');
    $this->db->where('Programs.Program_Code', $Program_id);
    $this->db->order_by('Sections.Section_Name');
    $query = $this->db->get();
    return $query->result_array();
  }



  public function Get_Gender()
  {
    $this->db->select('Gender');
    $this->db->group_by('Gender');
    $this->db->where('Gender != ', 'N/A');
    $this->db->where('Gender != ', '');
    $this->db->where('Gender != ', '0');
    $this->db->where('Gender != ', 'x');
    $this->db->from('Student_Info');
    $query = $this->db->get();
    return $query;
  }


  public function GetYearLevel()
  {
    $this->db->select('Year_Level');
    $this->db->group_by('Year_Level');
    $this->db->where('Active', '1');
    $this->db->where('Year_Level != ', 'N/A');
    $this->db->from('Sections');
    $query = $this->db->get();
    return $query;
  }



  public function GetStudentList($array)
  {

    // die($array['test']);
    $this->db->select('*,Fees_Enrolled_College.YearLevel AS YL');
    $this->db->from('Fees_Enrolled_College');
    $this->db->join('Student_Info', 'Student_Info.Reference_Number = Fees_Enrolled_College.Reference_Number', 'INNER');
    $this->db->join('Program_Majors', 'Program_Majors.ID = Student_Info.Major', 'LEFT');
    if ($array['search'] == '1') {
      if ($array['sm'] != '') {
        $this->db->where('Fees_Enrolled_College.semester', $array['sm']);
      }
      if ($array['sy'] != '') {
        $this->db->where('Fees_Enrolled_College.schoolyear', $array['sy']);
      }
      if ($array['nt'] != '') {
        $this->db->where('Student_Info.Nationality', $array['nt']);
      }
      if ($array['major'] != '') {
        $this->db->where('Student_Info.Major', $array['major']);
      }
      if ($array['pmajor'] != '') {
        $this->db->where('Fees_Enrolled_College.Course', $array['pmajor']);
      }
      if ($array['Gender'] != '') {
        $this->db->where('Student_Info.Gender', $array['Gender']);
      }
      if ($array['YL'] != '') {
        $this->db->where('Fees_Enrolled_College.YearLevel', $array['YL']);
      }
    } else {
      $this->db->where('Fees_Enrolled_College.semester', $array['sm']);
      $this->db->where('Fees_Enrolled_College.schoolyear', $array['sy']);
    }
    $this->db->where('Fees_Enrolled_College.withdraw', '0');
    $this->db->order_by('Student_Info.Last_Name', 'ASC');
    $query = $this->db->get();

    if ($query->num_rows() > 0) {
      return $query;
    } else {
      return $query;
    }
  }
}
