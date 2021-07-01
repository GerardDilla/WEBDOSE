<?php


class Inquiry_Reports_Model extends CI_Model
{

  //SELECT LEGEND 
  public function Select_Legends()
  {

    $this->db->select('*');
    $this->db->from('inquiry_legends');
    $query = $this->db->get();


    return $query;
  }


  //SELECT BED Grade Level
  public function Select_BED()
  {

    $this->db->select('*');
    $this->db->from('Basiced_Level');
    $this->db->Where('Grade_ID !=', '15');
    $this->db->Where('Grade_ID !=', '16');
    $query = $this->db->get();

    if ($query->num_rows() > 0) {
      return $query->result();
    } else {
      return $query->result();
    }
  }

  //SELECT HED Course
  public function Select_Course()
  {

    $this->db->select('*');
    $this->db->from('Programs');
    $query = $this->db->get();

    return $query;
  }

  //SELECT HED Inquiry
  public function Select_HED_Inquiry($array)
  {
    // echo $array['from'].' : '.$array['to'];
    // echo $array['1st_choice'];
    // die();
    $this->db->select('*,A.Reference_Number as ref_no,C.Remarks as Rmk,D.Reference_Number as EXM_RF');
    $this->db->from('Student_Info AS A');
    $this->db->join('highered_inquiry_log AS B', 'A.Reference_Number = B.Reference_Number', 'LEFT');
    $this->db->join('4ps_inquiry_infoid AS 4ps', 'A.Reference_Number = 4ps.Reference_Number and 4ps.type = "highered" and 4ps.Valid = 1', 'LEFT');
    $this->db->join('Guidance_HigherEdExamination AS D', 'D.Reference_Number = A.Reference_Number', 'LEFT');
    $this->db->join('Remarks AS C', 'C.Remarks_ID = D.Exam', 'LEFT');
    $this->db->join('student_account AS SA', 'A.Reference_Number = SA.reference_no', 'LEFT');

    if ($array['course'] != '0' && $array['1st_choice'] != '0') {
      // echo('Course and choice');
      $where = "A.Course='" . $array['course'] . " 'OR A.Course_1st='" . $array['1st_choice'] . "'";
      $this->db->where($where);
    } elseif ($array['course'] != '0') {
      // echo('Course');
      $this->db->where('A.Course', $array['course']);
    } elseif ($array['1st_choice'] != '0') {
      // echo('Choice');
      $this->db->where('A.Course_1st', $array['1st_choice']);
    }

    if ($array['from'] != '' && $array['to'] != '') {
      // echo('date');
      $this->db->where('B.DateInquired >=', $array['from']);
      $this->db->where('B.DateInquired <=', $array['to']);
    }
    if ($array['sy'] != '0') {
      // echo('sy');
      $this->db->where('A.Applied_SchoolYear', $array['sy']);
    }
    if ($array['sem'] != '0') {
      // echo('sem');
      $this->db->where('A.Applied_Semester', $array['sem']);
    }
    // die();

    $this->db->where('A.Course !=', '0');
    $this->db->where('A.Course_1st !=', '0');
    $query = $this->db->get();
    // die(json_encode($query->result_array()));
    if ($query->num_rows() > 0) {
      return $query->result();
    } else {
      return $query->result();
    }
  }



  //SELECT SHS Inquiry
  public function Select_SHS_Inquiry($array)
  {

    $this->db->select('*');
    $this->db->from('Basiced_Studentinfo AS A');
    $this->db->join('seniorhigh_inquiry_log AS B', 'A.Reference_Number = B.Reference_Number', 'LEFT');
    $this->db->join('4ps_inquiry_infoid AS 4ps', 'A.Reference_Number = 4ps.Reference_Number and 4ps.type != "highered" and 4ps.Valid = 1', 'LEFT');
    $this->db->join('Guidance_BasicEdExamination AS D', 'D.Reference_Number = A.Reference_Number', 'LEFT');
    $this->db->join('Remarks AS C', 'C.Remarks_ID = D.Exam', 'LEFT');


    if (isset($array['sy'])) {

      $this->db->where('B.SchoolYear', $array['sy']);
      if (isset($array['gradlvl'])) {
        $this->db->where('A.Gradelevel', $array['gradlvl']);
      }
    } else {
      $this->db->where('B.SchoolYear', $array['sy1']);
      $this->db->where('A.Gradelevel !=', 'G1');
      $this->db->where('A.Gradelevel !=', 'G2');
      $this->db->where('A.Gradelevel !=', 'G3');
      $this->db->where('A.Gradelevel !=', 'G4');
      $this->db->where('A.Gradelevel !=', 'G5');
      $this->db->where('A.Gradelevel !=', 'G6');
      $this->db->where('A.Gradelevel !=', 'G7');
      $this->db->where('A.Gradelevel !=', 'G8');
      $this->db->where('A.Gradelevel !=', 'G9');
      $this->db->where('A.Gradelevel !=', 'G10');
    }


    $query = $this->db->get();

    if ($query->num_rows() > 0) {
      return $query->result();
    } else {
      return $query->result();
    }
  }


  //SELECT BED Inquiry
  public function Select_BED_Inquiry($array)
  {

    $this->db->select('*');
    $this->db->from('Basiced_Studentinfo AS A');
    $this->db->join('basiced_inquiry_log AS B', 'A.Reference_Number = B.Reference_Number', 'LEFT');
    $this->db->join('4ps_inquiry_infoid AS 4ps', 'A.Reference_Number = 4ps.Reference_Number and 4ps.type != "highered" and 4ps.Valid = 1', 'LEFT');
    $this->db->join('Guidance_BasicEdExamination AS D', 'D.Reference_Number = A.Reference_Number', 'LEFT');
    $this->db->join('Remarks AS C', 'C.Remarks_ID = D.Exam', 'LEFT');


    if (isset($array['sy'])) {
      $this->db->where('B.SchoolYear', $array['sy']);
      if (isset($array['getlvl'])) {
        $this->db->where('A.Gradelevel', $array['getlvl']);
      }
    } else {
      $this->db->where('B.SchoolYear', $array['sy1']);
    }
    if ($array['from'] != '' && $array['to'] != '') {
      $this->db->where('B.DateInquired >=', $array['from']);
      $this->db->where('B.DateInquired <=', $array['to']);
    }


    $query = $this->db->get();
    if ($query->num_rows() > 0) {
      return $query->result();
    } else {
      return $query->result();
    }
  }
}
