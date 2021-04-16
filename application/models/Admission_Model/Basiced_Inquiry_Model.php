<?php


class Basiced_Inquiry_Model extends CI_Model
{



   public function Select_Level()
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


   public function Get_SchoolYear()
   {
      $this->db->select('*');
      $this->db->from('Basiced_EnrolledFees_Local');
      $this->db->Order_by('schoolyear', 'DESC');
      $this->db->group_by('schoolyear');
      $query = $this->db->get();
      return $query;
   }



   //NEW ENROLLED
   public function Get_New_Enrolled($array)
   {
      $this->db->select('Count(A.Student_Number) AS REF');
      $this->db->from('Basiced_EnrolledFees_Local AS A');
      $this->db->join('Basiced_Studentinfo AS B', 'A.Reference_Number = B.Reference_Number', 'LEFT');
      $this->db->join('Basiced_WithdrawInformation AS C', 'C.Student_Number = A.Student_Number', 'LEFT');
      $this->db->where('A.GradeLevel', $array['GradeLevel']);
      $this->db->where('A.SchoolYear', $array['sy']);
      $this->db->where('A.Reference_Number != ', '0');
      $this->db->where('C.Withdrawal_Fee IS NULL');
      $this->db->where('B.`AdmittedSY` =', $array['sy']);
      $query = $this->db->get();

      if ($query->num_rows() > 0) {
         return $query->result();
      } else {
         return $query->result();
      }
   }

   //OLD ENROLLED
   public function Get_OLD_Enrolled($array)
   {
      $this->db->select('Count(A.Student_Number) AS REF');
      $this->db->from('Basiced_EnrolledFees_Local AS A');
      $this->db->join('Basiced_Studentinfo AS B', 'A.Reference_Number = B.Reference_Number', 'LEFT');
      $this->db->join('Basiced_WithdrawInformation AS C', 'C.Student_Number = A.Student_Number', 'LEFT');
      $this->db->where('A.GradeLevel', $array['GradeLevel']);
      $this->db->where('A.SchoolYear', $array['sy']);
      $this->db->where('A.Reference_Number !=', '0');
      $this->db->where('C.Withdrawal_Fee IS NULL');
      $this->db->where('B.`AdmittedSY` !=', $array['sy']);
      $query = $this->db->get();

      if ($query->num_rows() > 0) {
         return $query->result();
      } else {
         return $query->result();
      }
   }

   //TAKER NEW STUDENT

   public function Taker($array)
   {
      $this->db->select('Count(A.Reference_Number) AS REF');
      $this->db->from('Guidance_BasicEdExamination AS A');
      $this->db->join('Basiced_Studentinfo AS B', 'A.Reference_Number = B.Reference_Number', 'INNER');
      $this->db->where('B.GradeLevel', $array['GradeLevel']);
      $this->db->where('A.School_Year', $array['sy']);
      $this->db->where('A.Reference_Number !=', '0');
      $this->db->where('B.`AdmittedSY` =', $array['sy']);
      $query = $this->db->get();

      if ($query->num_rows() > 0) {
         return $query->result();
      } else {
         return $query->result();
      }
   }

   //Inquiry NEW STUDENT
   public function Inquiry($array)
   {
      $this->db->select('Count(A.Reference_Number) AS REF');
      $this->db->from('Transaction_Log AS A');
      $this->db->join('Basiced_Studentinfo AS B', 'A.Reference_Number = B.Reference_Number', 'INNER');
      $this->db->where('B.GradeLevel', $array['GradeLevel']);
      $this->db->where('B.AdmittedSY', $array['sy']);
      $this->db->where('A.Reference_Number !=', '0');
      $this->db->where('B.`AdmittedSY` = ', $array['sy']);
      $this->db->where('A.`Student_Type`=', 'BASICED');
      $query = $this->db->get();

      if ($query->num_rows() > 0) {
         return $query->result();
      } else {
         return $query->result();
      }
   }

   //RESERVE NEW
   public function New_RESERVE($array)
   {
      $this->db->select('Count(A.Reference_No) AS REF');
      $this->db->from('Basiced_ReservationFee AS A');
      $this->db->join('Basiced_Studentinfo AS B', 'A.Reference_No = B.Reference_Number', 'INNER');
      $this->db->where('B.GradeLevel', $array['GradeLevel']);
      $this->db->where('B.AdmittedSY', $array['sy']);
      $this->db->where('B.Reference_Number !=', '0');
      $this->db->where('B.`AdmittedSY` =', $array['sy']);
      $this->db->where('A.`Applied` =', '0');
      $query = $this->db->get();

      if ($query->num_rows() > 0) {
         return $query->result();
      } else {
         return $query->result();
      }
   }


   //RESERVE NEW
   public function OLD_RESERVE($array)
   {
      $this->db->select('Count(A.Reference_No) AS REF');
      $this->db->from('Basiced_ReservationFee AS A');
      $this->db->join('Basiced_Studentinfo AS B', 'A.Reference_No = B.Reference_Number', 'INNER');
      $this->db->where('B.GradeLevel', $array['GradeLevel']);
      $this->db->where('B.AdmittedSY', $array['sy']);
      $this->db->where('B.Reference_Number !=', '0');
      $this->db->where('B.`AdmittedSY` != ', $array['sy']);
      $this->db->where('A.`Applied`=', '0');
      $query = $this->db->get();

      if ($query->num_rows() > 0) {
         return $query->result();
      } else {
         return $query->result();
      }
   }
}
