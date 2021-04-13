<?php


class Dashboard_Model extends CI_Model
{
  
    //GET LEGEND
    public function Get_Legend(){
        $this->db->select('*');
        $this->db->from('Legend');
        $query = $this->db->get();
    
          return $query;
      }

      public function Get_Legends(){
        $this->db->select('*');
        $this->db->from('Legend');
        $query = $this->db->get();
    
        return $query->result_array();
      }



      public function Get_New($array)
    {
      $this->db->select('Count(A.`Reference_Number`) AS REF');
      $this->db->from('Fees_Enrolled_College AS A');
      $this->db->join('Student_Info AS B','B.`Reference_Number` = A.`Reference_Number`','INNER');
      $this->db->where('A.semester', $array['sem']);
      $this->db->where('A.schoolyear', $array['sy']);
      $this->db->where('A.withdraw !=', '1');
      $this->db->where('`B`.`AdmittedSY`', $array['sy']);
      $this->db->where('`B`.`AdmittedSEM`', $array['sem']);
      $query = $this->db->get();
    
      return $query;
    }


    public function Get_OLD($array)
    {
      $this->db->select('Count(A.`Reference_Number`) AS REF');
      $this->db->from('Fees_Enrolled_College AS A');
      $this->db->join('Student_Info AS B','B.`Reference_Number` = A.`Reference_Number`','INNER');
      $this->db->where('A.semester', $array['sem']);
      $this->db->where('A.schoolyear', $array['sy']);
       $this->db->where('A.withdraw !=', '1');
      $this->db->where('`B`.`AdmittedSY` !=', $array['sy']);
      $query = $this->db->get();
    
      return $query;
    }


    public function Get_withdraw($array)
    {
      $this->db->select('Count(A.`Reference_Number`) AS REF');
      $this->db->from('Fees_Enrolled_College AS A');
      $this->db->join('Student_Info AS B','B.`Reference_Number` = A.`Reference_Number`','INNER');
      $this->db->where('A.semester', $array['sem']);
      $this->db->where('A.schoolyear', $array['sy']);
      $this->db->where('A.withdraw', '1');
    $query = $this->db->get();
    
      return $query;
    }


    public function Get_reserved($array)
    {
      $this->db->select('Count(A.`Reference_No`) AS REF');
      $this->db->from('ReservationFee  AS A');
      $this->db->join('Student_Info AS C','A.`Reference_No` = C.`Reference_Number`','LEFT');
      $this->db->join('Fees_Enrolled_College AS B','A.`Reference_No` = B.`Reference_Number`','LEFT');
      $this->db->where('A.semester', $array['sem']);
      $this->db->where('A.schoolyear', $array['sy']);
      $this->db->where('B.`Reference_Number IS NULL');
      $query = $this->db->get();
    
      return $query;
    }


    public function Get_advised($array)
    {
      $this->db->select('Count(A.`Reference_Number`) AS REF');
      $this->db->from('Fees_Temp_College  AS A');
      $this->db->join('Fees_Enrolled_College AS B','A.`Reference_Number` = B.`Reference_Number`','LEFT');
      $this->db->where('A.semester', $array['sem']);
      $this->db->where('A.schoolyear', $array['sy']);
      $this->db->where('B.`Reference_Number IS NULL');
      $query = $this->db->get();
    
      return $query;
    }


    // fOR SUMMER
    public function Get_summer_NEW($array)
    {
      $this->db->select('Count(A.`Reference_Number`) AS REF');
      $this->db->from('Fees_Enrolled_College AS A');
      $this->db->join('Student_Info AS B','B.`Reference_Number` = A.`Reference_Number`','LEFT');
      $this->db->where('A.semester', 'SUMMER');
      $this->db->where('A.schoolyear', $array['summer']);
      $this->db->where('`B`.`AdmittedSY`',$array['summer']);
      $this->db->where('`B`.`AdmittedSEM`','SUMMER');
      $query = $this->db->get();
      return $query;
    }

    public function Get_summer($array)
    {
      $this->db->select('Count(A.`Reference_Number`) AS REF');
      $this->db->from('Fees_Enrolled_College AS A');
      $this->db->join('Student_Info AS B','B.`Reference_Number` = A.`Reference_Number`','LEFT');
      $this->db->where('A.semester', 'SUMMER');
      $this->db->where('A.schoolyear', $array['summer']);
      $query = $this->db->get();
      return $query;
    }

    public function Get_summer_withdraw($array)
    {
      $this->db->select('Count(A.`Reference_Number`) AS REF');
      $this->db->from('Fees_Enrolled_College AS A');
      $this->db->join('Student_Info AS B','B.`Reference_Number` = A.`Reference_Number`','LEFT');
      $this->db->where('A.semester', 'SUMMER');
      $this->db->where('A.schoolyear', $array['summer']);
      $this->db->where('A.withdraw', '1');
      $query = $this->db->get();
      return $query;
    }


    public function Get_reserved_Summer($array)
    {
      $this->db->select('Count(A.`Reference_No`) AS REF');
      $this->db->from('ReservationFee  AS A');
      $this->db->join('Fees_Enrolled_College AS B','A.`Reference_No` = B.`Reference_Number`','LEFT');
      $this->db->where('A.semester', 'SUMMER');
      $this->db->where('A.schoolyear', $array['summer']);
      $this->db->where('B.`Reference_Number IS NULL');
      $query = $this->db->get();
    
      return $query;
    }

    
    public function Get_advised_summer($array)
    {
      $this->db->select('Count(A.`Reference_Number`) AS REF');
      $this->db->from('Fees_Temp_College  AS A');
      $this->db->join('Fees_Enrolled_College AS B','A.`Reference_Number` = B.`Reference_Number`','LEFT');
      $this->db->where('A.semester','SUMMER');
      $this->db->where('A.schoolyear', $array['summer']);
      $this->db->where('B.`Reference_Number IS NULL');
      $query = $this->db->get();
    
      return $query;
    }

  
   //BASIC EDUCATION
    public function Get_NewBED_Enrolled($array)
    {
      $this->db->select('Count(A.Student_Number) AS REF');
      $this->db->from('Basiced_EnrolledFees_Local AS A');
      $this->db->join('Basiced_Studentinfo AS B','A.Reference_Number = B.Reference_Number','LEFT');
      $this->db->join('Basiced_WithdrawInformation AS C','C.Student_Number = A.Student_Number','LEFT');
      $this->db->where('A.SchoolYear',$array['sy']);
      $this->db->where('A.Reference_Number != ','0');
      $this->db->where('C.Withdrawal_Fee IS NULL');
      $this->db->where('B.`AdmittedSY` =',$array['sy']);
      $this->db->where('A.`GradeLevel` !=','G11');
      $this->db->where('A.`GradeLevel` !=','G12');
      $query = $this->db->get();

      return $query;
      
    }

    public function Get_bedOLD_Enrolled($array)
    {
      $this->db->select('Count(A.Student_Number) AS REF');
      $this->db->from('Basiced_EnrolledFees_Local AS A');
      $this->db->join('Basiced_Studentinfo AS B','A.Reference_Number = B.Reference_Number','LEFT');
      $this->db->join('Basiced_WithdrawInformation AS C','C.Student_Number = A.Student_Number','LEFT');
      $this->db->where('A.SchoolYear',$array['sy']);
      $this->db->where('A.Reference_Number != ','0');
      $this->db->where('C.Withdrawal_Fee IS NULL');
      $this->db->where('B.`AdmittedSY` !=',$array['sy']);
      $this->db->where('A.`GradeLevel` !=','G11');
      $this->db->where('A.`GradeLevel` !=','G12');
      $query = $this->db->get();

      return $query;
      
    }


       public function BED_RESERVE($array)
      {
        $this->db->select('Count(A.Reference_No) AS REF');
        $this->db->from('Basiced_ReservationFee AS A');
        $this->db->join('Basiced_EnrolledFees_Local AS B','A.Reference_No = B.Reference_Number','LEFT');
        $this->db->where('A.SchoolYear',$array['sy']);
        $this->db->where('B.Reference_Number !=','0');
        $this->db->where('B.`GradeLevel` !=','G11');
        $this->db->where('B.`GradeLevel` !=','G12');
        $this->db->where('A.`Applied` =','0'); 
        $query = $this->db->get();

        return $query;
  
      }

       //SENIOR HIGH SCHOOl

       public function Get_NewSHS_Enrolled($array)
    {
      $this->db->select('Count(A.Student_Number) AS REF');
      $this->db->from('Basiced_EnrolledFees_Local AS A');
      $this->db->join('Basiced_Studentinfo AS B','A.Reference_Number = B.Reference_Number','LEFT');
      $this->db->join('Basiced_WithdrawInformation AS C','C.Student_Number = A.Student_Number','LEFT');
      $this->db->where('A.SchoolYear',$array['sy']);
      $this->db->where('B.`AdmittedSY` =',$array['sy']);
      $this->db->where('A.Reference_Number != ','0');
      $this->db->where('C.Withdrawal_Fee IS NULL');
      $this->db->where('A.`GradeLevel` !=','N');
      $this->db->where('A.`GradeLevel` !=','K1');
      $this->db->where('A.`GradeLevel` !=','K2');
      $this->db->where('A.`GradeLevel` !=','G1');
      $this->db->where('A.`GradeLevel` !=','G2');
      $this->db->where('A.`GradeLevel` !=','G3');
      $this->db->where('A.`GradeLevel` !=','G4');
      $this->db->where('A.`GradeLevel` !=','G5');
      $this->db->where('A.`GradeLevel` !=','G6');
      $this->db->where('A.`GradeLevel` !=','G7');
      $this->db->where('A.`GradeLevel` !=','G8');
      $this->db->where('A.`GradeLevel` !=','G9');
      $this->db->where('A.`GradeLevel` !=','G10');

      $query = $this->db->get();

      return $query;
      
    }

    public function Get_SHSOLD_Enrolled($array)
    {
      $this->db->select('Count(A.Student_Number) AS REF');
      $this->db->from('Basiced_EnrolledFees_Local AS A');
      $this->db->join('Basiced_Studentinfo AS B','A.Reference_Number = B.Reference_Number','LEFT');
      $this->db->join('Basiced_WithdrawInformation AS C','C.Student_Number = A.Student_Number','LEFT');
      $this->db->where('A.SchoolYear',$array['sy']);
      $this->db->where('B.`AdmittedSY` !=',$array['sy']);
      $this->db->where('A.Reference_Number != ','0');
      $this->db->where('C.Withdrawal_Fee IS NULL');
      $this->db->where('A.`GradeLevel` !=','N');
      $this->db->where('A.`GradeLevel` !=','K1');
      $this->db->where('A.`GradeLevel` !=','K2');
      $this->db->where('A.`GradeLevel` !=','G1');
      $this->db->where('A.`GradeLevel` !=','G2');
      $this->db->where('A.`GradeLevel` !=','G3');
      $this->db->where('A.`GradeLevel` !=','G4');
      $this->db->where('A.`GradeLevel` !=','G5');
      $this->db->where('A.`GradeLevel` !=','G6');
      $this->db->where('A.`GradeLevel` !=','G7');
      $this->db->where('A.`GradeLevel` !=','G8');
      $this->db->where('A.`GradeLevel` !=','G9');
      $this->db->where('A.`GradeLevel` !=','G10');
      $query = $this->db->get();

      return $query;
      
    }


       public function SHS_RESERVE($array)
      {
        $this->db->select('Count(A.Reference_No) AS REF');
        $this->db->from('Basiced_ReservationFee AS A');
        $this->db->join('Basiced_EnrolledFees_Local AS B','A.Reference_No = B.Reference_Number','INNER');
        $this->db->where('B.SchoolYear',$array['sy']);
        $this->db->where('B.Reference_Number !=','0');
        $this->db->where('B.`GradeLevel` !=','N');
        $this->db->where('B.`GradeLevel` !=','K1');
        $this->db->where('B.`GradeLevel` !=','K2');
        $this->db->where('B.`GradeLevel` !=','G1');
        $this->db->where('B.`GradeLevel` !=','G2');
        $this->db->where('B.`GradeLevel` !=','G3');
        $this->db->where('B.`GradeLevel` !=','G4');
        $this->db->where('B.`GradeLevel` !=','G5');
        $this->db->where('B.`GradeLevel` !=','G6');
        $this->db->where('B.`GradeLevel` !=','G7');
        $this->db->where('B.`GradeLevel` !=','G8');
        $this->db->where('B.`GradeLevel` !=','G9');
        $this->db->where('B.`GradeLevel` !=','G10');
        $this->db->where('A.`Applied` =','0'); 
        $query = $this->db->get();

        return $query;
  
      }


      public function BED_INQUIRY($array)
      {
        $this->db->select('Count(Reference_Number) AS REF');
        $this->db->from('basiced_inquiry_log');
        $this->db->where('SchoolYear',$array['sy']);
        $query = $this->db->get();

        return $query;
  
      }

      public function SHS_INQUIRY($array)
      {
        $this->db->select('Count(A.Reference_Number) AS REF');
        $this->db->from('seniorhigh_inquiry_log AS A');
        $this->db->join('Basiced_Studentinfo AS B','A.Reference_Number = B.Reference_Number','INNER');
        $this->db->where('A.SchoolYear',$array['sy']);
        $this->db->where('A.Reference_Number !=','0');
        $this->db->where('B.Reference_Number !=','0');
        $this->db->where('B.Gradelevel =','G11');
        $this->db->or_where('B.Gradelevel =','G12');
       
        $query = $this->db->get();

        return $query;
  
      }

      public function HIGHERED_INQUIRY($array)
      {
        $this->db->select('Count(Reference_Number) AS REF');
        $this->db->from('highered_inquiry_log');
        $this->db->where('SchoolYear',$array['sy']);
        $this->db->where('Semester',$array['sem']);
        $query = $this->db->get();

        return $query;
  
      }

      
     public function get_other_programs(){

      $this->db->select('*');
      $this->db->from('Programs');
      $this->db->Order_by('Program_Code','ASC');
      $this->db->where('Program_Code =','MBA');
      $this->db->or_where('Program_Code =','MAP');
      $this->db->or_where('Program_Code =','WSA');
      $this->db->or_where('Program_Code =','CGNCII');
      $query = $this->db->get();

      return $query->result_array();

     }

     public function Get_Enrolled($array)
     {
       $this->db->select(`A`.`Reference_Number`);
       $this->db->from('Fees_Enrolled_College AS A');
       $this->db->where('A.course', $array['Program_Code']);
       $this->db->where('A.semester', $array['sem']);
       $this->db->where('A.schoolyear', $array['sy']);
       $query = $this->db->get();
       return $query->num_rows();
     }


    //Count all inquiry
    public function Inquiry_Count($array){
      $this->db->select('COUNT(
        si.Reference_Number) as Ref_Num_si
      ');
      $this->db->from('Student_Info si');
      $this->db->order_by('si.Reference_Number','DESC');
      $this->db->join('Fees_Temp_College ftc', 'si.Reference_Number = ftc.Reference_Number', 'left');
      $this->db->join('EnrolledStudent_Payments ep', 'si.Reference_Number = ep.Reference_Number', 'left');
      $this->db->where('si.Applied_Semester', $array['sem']);
      $this->db->where('si.Applied_SchoolYear', $array['sy']);
      $query = $this->db->get();
      return $query;
    }
    //Count all advising
    public function Advising_Count($array){
      $this->db->select('COUNT(*,
        ftc.Course as Course_ftc
      )');
      $this->db->from('Fees_Temp_College ftc');
      $this->db->order_by('id','DESC');
      $this->db->join('Student_Info si', 'si.Reference_Number = ftc.Reference_Number', 'left');
      $this->db->where('si.First_Name !=','');
      $this->db->where('ftc.semester', $array['sem']);
      $this->db->where('ftc.schoolyear', $array['sy']);
      $query = $this->db->get();
      return $query->num_rows();
    }
    //Count all enrolled student
    public function Enrolled_Student_Count($array){
      $this->db->select('COUNT(*)');
      $this->db->from('EnrolledStudent_Payments ep');
      $this->db->where('ep.valid',1);
      $this->db->order_by('id','DESC');
      $this->db->join('Student_Info si', 'si.Reference_Number = ep.Reference_Number', 'left');
      $this->db->where('ep.Semester', $array['sem']);
      $this->db->where('ep.SchoolYear', $array['sy']);
      $query = $this->db->get();
      return $query->num_rows();
    }
}