<?php


class Enroll_Summary_Model extends CI_Model{
  

  public function Get_Legend(){
    $this->db->select('*');
    $this->db->from('Legend');
    $query = $this->db->get();

      return $query;
  
  }
  

  public function Get_sem(){ 
    $this->db->select('semester');
    $this->db->from('Fees_Enrolled_College');
    $this->db->group_by('Semester',DESC);
    $this->db->where('semester !=','FIRSTx');
    $this->db->where('semester !=','SECONDx');
    $query = $this->db->get();
    return $query;
                                 
  }
 ///GET School Year
  public function Get_sy(){
   $this->db->select('*');
   $query = $this->db->get('SchoolYear');
   return $query;
                                   
 }
  
    
     public function Get_Course(){
      $this->db->select('Programs.Program_Code AS Prog, Program_Majors.Program_Major AS Major,Program_Majors.ID as Major_ID');
      $this->db->from('Programs');
      $this->db->join('Program_Majors','Program_Majors.`Program_Code` = Programs.`Program_Code`','LEFT');
      $this->db->Order_by('Programs.Program_Code',ASC);
      $query = $this->db->get();
      
      if($query->num_rows()> 0){
        return $query->result();
     }else{
        return $query->result();
     }
    }

    //New Year with Major
    public function Get_NewMajor($array)
    {
      $this->db->select('Count(A.`Reference_Number`) AS REF');
      $this->db->from('Fees_Enrolled_College AS A');
      $this->db->join('Student_Info AS B','B.`Reference_Number` = A.`Reference_Number`','LEFT');
      $this->db->join('Program_Majors AS C','C.`ID` = B.`Major`','LEFT');
    //  $this->db->join('`Legend` AS D', 'D.School_Year = A.schoolyear AND `D`.`Semester` = `A`.`Semester` ','LEFT');
      $this->db->where('B.Major', $array['Major_id']);
      $this->db->where('A.course', $array['program']);
      $this->db->where('B.AdmittedSEM', $array['sem']);
      $this->db->where('B.AdmittedSY', $array['sy']);
      $this->db->where('B.Reference_Number !=','0');
      $this->db->where('A.Reference_Number !=','0');
      $this->db->where('`B`.`AdmittedSY` = A.`schoolyear`');
      $this->db->where('`A`.`withdraw` =','0');
      $query = $this->db->get();
    
      if($query->num_rows()> 0){
        return $query->result();
     }else{
        return $query->result();
     }
    }

    //Old with Major
    public function Get_OldMajor($array)
    {
      $this->db->select('Count(A.`Reference_Number`) AS REF');
      $this->db->from('Fees_Enrolled_College AS A');
      $this->db->join('Student_Info AS B','B.`Reference_Number` = A.`Reference_Number`','LEFT');
      $this->db->join('Program_Majors AS C','C.`ID` = B.`Major`','LEFT');
   //  $this->db->join('`Legend` AS D', 'D.School_Year = A.schoolyear AND `D`.`Semester` = `A`.`Semester` ','LEFT');
      $this->db->where('B.Major', $array['Major_id']);
      $this->db->where('A.course', $array['program']);
      $this->db->where('A.semester', $array['sem']);
      $this->db->where('A.schoolyear', $array['sy']);
      $this->db->where('B.Reference_Number !=','0');
      $this->db->where('A.Reference_Number !=','0');
      $this->db->where('`A`.`withdraw` =','0');
      $query = $this->db->get();
    
      if($query->num_rows()> 0){
        return $query->result();
     }else{
        return $query->result();
     }
      
    }

    // 1st Year with Major
    public function Get_1stMajor($array)
    {
      $this->db->select('Count(A.`Reference_Number`) AS REF');
      $this->db->from('Fees_Enrolled_College AS A');
      $this->db->join('Student_Info AS B','B.`Reference_Number` = A.`Reference_Number`','LEFT');
      $this->db->join('Program_Majors AS C','C.`ID` = B.`Major`','LEFT');
     // $this->db->join('`Legend` AS D', 'D.School_Year = A.schoolyear AND `D`.`Semester` = `A`.`Semester` ','LEFT');
      $this->db->where('B.Major', $array['Major_id']);
      $this->db->where('A.course', $array['program']);
      $this->db->where('A.semester', $array['sem']);
      $this->db->where('A.schoolyear', $array['sy']);
      $this->db->where('B.Reference_Number !=','0');
      $this->db->where('A.Reference_Number !=','0');
      $this->db->where('`A`.`withdraw` =','0');
      $this->db->where('A.`YearLevel` =','1');
    //  $this->db->where('`B`.`AdmittedSY` = D.`School_Year`');
      $query = $this->db->get();
    
      if($query->num_rows()> 0){
        return $query->result();
     }else{
        return $query->result();
     }
    }

    // 2nd Year with Major
    public function Get_2ndMajor($array)
    {
      $this->db->select('Count(A.`Reference_Number`) AS REF');
      $this->db->from('Fees_Enrolled_College AS A');
      $this->db->join('Student_Info AS B','B.`Reference_Number` = A.`Reference_Number`','LEFT');
      $this->db->join('Program_Majors AS C','C.`ID` = B.`Major`','LEFT');
     // $this->db->join('`Legend` AS D', 'D.School_Year = A.schoolyear AND `D`.`Semester` = `A`.`Semester` ','LEFT');
      $this->db->where('B.Major', $array['Major_id']);
      $this->db->where('A.course', $array['program']);
      $this->db->where('A.semester', $array['sem']);
      $this->db->where('A.schoolyear', $array['sy']);
      $this->db->where('B.Reference_Number !=','0');
      $this->db->where('A.Reference_Number !=','0');
      $this->db->where('A.`YearLevel` =','2');
      $this->db->where('`A`.`withdraw` =','0');
      $query = $this->db->get();
    
      if($query->num_rows()> 0){
        return $query->result();
     }else{
        return $query->result();
     }
    }

    // 3rd Year with Major
    public function Get_3rdMajor($array)
    {
      $this->db->select('Count(A.`Reference_Number`) AS REF');
      $this->db->from('Fees_Enrolled_College AS A');
      $this->db->join('Student_Info AS B','B.`Reference_Number` = A.`Reference_Number`','LEFT');
      $this->db->join('Program_Majors AS C','C.`ID` = B.`Major`','LEFT');
    //  $this->db->join('`Legend` AS D', 'D.School_Year = A.schoolyear AND `D`.`Semester` = `A`.`Semester` ','LEFT');
      $this->db->where('B.Major', $array['Major_id']);
      $this->db->where('A.course', $array['program']);
      $this->db->where('A.semester', $array['sem']);
      $this->db->where('A.schoolyear', $array['sy']);
      $this->db->where('B.Reference_Number !=','0');
      $this->db->where('A.Reference_Number !=','0');
      $this->db->where('`A`.`withdraw` =','0');
      $this->db->where('A.`YearLevel` =','3');
      $query = $this->db->get();
    
      if($query->num_rows()> 0){
        return $query->result();
     }else{
        return $query->result();
     }
    }


    // 4th Year with Major
    public function Get_4thMajor($array)
    {
      $this->db->select('Count(A.`Reference_Number`) AS REF');
      $this->db->from('Fees_Enrolled_College AS A');
      $this->db->join('Student_Info AS B','B.`Reference_Number` = A.`Reference_Number`','LEFT');
      $this->db->join('Program_Majors AS C','C.`ID` = B.`Major`','LEFT');
    //  $this->db->join('`Legend` AS D', 'D.School_Year = A.schoolyear AND `D`.`Semester` = `A`.`Semester` ','LEFT');
      $this->db->where('B.Major', $array['Major_id']);
      $this->db->where('A.course', $array['program']);
      $this->db->where('A.semester', $array['sem']);
      $this->db->where('A.schoolyear', $array['sy']);
      $this->db->where('B.Reference_Number !=','0');
      $this->db->where('A.Reference_Number !=','0');
      $this->db->where('A.`YearLevel` =','4');
      $this->db->where('`A`.`withdraw` =','0');
      $query = $this->db->get();
    
      if($query->num_rows()> 0){
        return $query->result();
     }else{
        return $query->result();
     }
    }


    // 5th Year with Major
    public function Get_5thMajor($array)
    {
      $this->db->select('Count(A.`Reference_Number`) AS REF');
      $this->db->from('Fees_Enrolled_College AS A');
      $this->db->join('Student_Info AS B','B.`Reference_Number` = A.`Reference_Number`','LEFT');
      $this->db->join('Program_Majors AS C','C.`ID` = B.`Major`','LEFT');
     // $this->db->join('`Legend` AS D', 'D.School_Year = A.schoolyear AND `D`.`Semester` = `A`.`Semester` ','LEFT');
      $this->db->where('B.Major', $array['Major_id']);
      $this->db->where('A.course', $array['program']);
      $this->db->where('A.semester', $array['sem']);
      $this->db->where('A.schoolyear', $array['sy']);
      $this->db->where('B.Reference_Number !=','0');
      $this->db->where('A.Reference_Number !=','0');
      $this->db->where('A.`YearLevel` =','5');
      $this->db->where('`A`.`withdraw` =','0');
      $query = $this->db->get();
    
      if($query->num_rows()> 0){
        return $query->result();
     }else{
        return $query->result();
     }
    }

    

    

     // Enlisted with Major
     public function Get_EnlistedMajor($array)
     {
       $this->db->select('Count(A.`Reference_Number`) AS REF');
       $this->db->from('Advising AS A');
       $this->db->join('Fees_Enrolled_College AS B','A.`Reference_Number` = B.`Reference_Number`','LEFT');
       $this->db->where('A.Program', $array['program']);
       $this->db->where('A.Major', $array['Major_id']);
       $this->db->where('A.Semester', $array['sem']);
       $this->db->where('A.School_Year', $array['sy']);
       $this->db->where('B.Reference_Number IS NULL');
       $query = $this->db->get();
       
       if($query->num_rows()> 0){
         return $query->result();
      }else{
         return $query->result();
      }
      
     }

       //First Year with Major
    public function Get_WithdrawMajor($array)
    {
      $this->db->select('Count(A.`Reference_Number`) AS REF');
      $this->db->from('Fees_Enrolled_College AS A');
      $this->db->join('Student_Info AS B','B.`Reference_Number` = A.`Reference_Number`','LEFT');
      $this->db->join('Program_Majors AS C','C.`ID` = B.`Major`','LEFT');
      $this->db->where('B.Major', $array['Major_id']);
      $this->db->where('A.course', $array['program']);
      $this->db->where('A.semester', $array['sem']);
      $this->db->where('A.schoolyear', $array['sy']);
      $this->db->where('B.Reference_Number !=','0');
      $this->db->where('A.Reference_Number !=','0');
      $this->db->where('A.`withdraw` =','1');
      $this->db->where('`A`.`withdraw` =','0');
      $query = $this->db->get();
      
     
      if($query->num_rows()> 0){
        return $query->result();
     }else{
        return $query->result();
     }
     
    }

     //First Year 
    public function Get_New($array)
    {
      $this->db->select('Count(A.`Reference_Number`) AS REF');
      $this->db->from('Fees_Enrolled_College AS A');
      $this->db->join('Student_Info AS B','B.`Reference_Number` = A.`Reference_Number`','LEFT');
      $this->db->join('Program_Majors AS C','C.`ID` = B.`Major`','LEFT');
      $this->db->where('A.course', $array['program']);
      $this->db->where('A.semester', $array['sem']);
      $this->db->where('A.schoolyear', $array['sy']);
      $this->db->where('B.AdmittedSEM', $array['sem']);
      $this->db->where('B.AdmittedSY', $array['sy']);
      $this->db->where('B.Reference_Number !=','0');
      $this->db->where('A.Reference_Number !=','0');
      $this->db->where('`A`.`withdraw` =','0');
      $query = $this->db->get();
    
      if($query->num_rows()> 0){
        return $query->result();
     }else{
        return $query->result();
     }
    }

 
    //2nd Year And 3rd Year
    public function Get_Old($array)
    {
      $this->db->select('Count(A.`Reference_Number`) AS REF');
      $this->db->from('Fees_Enrolled_College AS A');
      $this->db->join('Student_Info AS B','B.`Reference_Number` = A.`Reference_Number`','LEFT');
      $this->db->join('Program_Majors AS C','C.`ID` = B.`Major`','LEFT');
    // $this->db->join('`Legend` AS D', 'D.School_Year = A.schoolyear AND `D`.`Semester` = `A`.`Semester` ','LEFT');
      $this->db->where('A.course', $array['program']);
      $this->db->where('A.semester', $array['sem']);
      $this->db->where('A.schoolyear', $array['sy']);
      $this->db->where('A.Reference_Number !=','0');
      $this->db->where('`A`.`withdraw` =','0');
      $query = $this->db->get();
    
      if($query->num_rows()> 0){
        return $query->result();
     }else{
        return $query->result();
     }
      
    }

     // 1st Year with Major
     public function Get_1st($array)
     {
       $this->db->select('Count(A.`Reference_Number`) AS REF');
       $this->db->from('Fees_Enrolled_College AS A');
       $this->db->join('Student_Info AS B','B.`Reference_Number` = A.`Reference_Number`','LEFT');
       $this->db->join('Program_Majors AS C','C.`ID` = B.`Major`','LEFT');
       $this->db->where('A.course', $array['program']);
       $this->db->where('A.semester', $array['sem']);
       $this->db->where('A.schoolyear', $array['sy']);
       $this->db->where('B.Reference_Number !=','0');
       $this->db->where('A.Reference_Number !=','0');
       $this->db->where('A.`YearLevel` =','1');
       $this->db->where('`A`.`withdraw` =','0');
       $query = $this->db->get();
     
       if($query->num_rows()> 0){
         return $query->result();
      }else{
         return $query->result();
      }
    }


     // 2nd Year 
     public function Get_2nd($array)
     {
       $this->db->select('Count(A.`Reference_Number`) AS REF');
       $this->db->from('Fees_Enrolled_College AS A');
       $this->db->join('Student_Info AS B','B.`Reference_Number` = A.`Reference_Number`','LEFT');
       $this->db->join('Program_Majors AS C','C.`ID` = B.`Major`','LEFT');
       $this->db->where('A.course', $array['program']);
       $this->db->where('A.semester', $array['sem']);
       $this->db->where('A.schoolyear', $array['sy']);
       $this->db->where('B.Reference_Number !=','0');
       $this->db->where('A.Reference_Number !=','0');
       $this->db->where('A.`YearLevel` =','2');
       $this->db->where('`A`.`withdraw` =','0');
       $query = $this->db->get();
     
       if($query->num_rows()> 0){
         return $query->result();
      }else{
         return $query->result();
      }
     }


     // 3rd Year 
     public function Get_3rd($array)
     {
       $this->db->select('Count(A.`Reference_Number`) AS REF');
       $this->db->from('Fees_Enrolled_College AS A');
       $this->db->join('Student_Info AS B','B.`Reference_Number` = A.`Reference_Number`','LEFT');
       $this->db->join('Program_Majors AS C','C.`ID` = B.`Major`','LEFT');
    //   $this->db->join('`Legend` AS D', 'D.School_Year = A.schoolyear AND `D`.`Semester` = `A`.`Semester` ','LEFT');
       $this->db->where('A.course', $array['program']);
       $this->db->where('A.semester', $array['sem']);
       $this->db->where('A.schoolyear', $array['sy']);
       $this->db->where('B.Reference_Number !=','0');
       $this->db->where('A.Reference_Number !=','0');
       $this->db->where('A.`YearLevel` =','3');
       $this->db->where('`A`.`withdraw` =','0');
       $query = $this->db->get();
     
       if($query->num_rows()> 0){
         return $query->result();
      }else{
         return $query->result();
      }
     }

      // 4th Year 
      public function Get_4th($array)
      {
        $this->db->select('Count(A.`Reference_Number`) AS REF');
        $this->db->from('Fees_Enrolled_College AS A');
        $this->db->join('Student_Info AS B','B.`Reference_Number` = A.`Reference_Number`','LEFT');
        $this->db->join('Program_Majors AS C','C.`ID` = B.`Major`','LEFT');
      //  $this->db->join('`Legend` AS D', 'D.School_Year = A.schoolyear AND `D`.`Semester` = `A`.`Semester` ','LEFT');
        $this->db->where('A.course', $array['program']);
        $this->db->where('A.semester', $array['sem']);
        $this->db->where('A.schoolyear', $array['sy']);
        $this->db->where('B.Reference_Number !=','0');
        $this->db->where('A.Reference_Number !=','0');
        $this->db->where('A.`YearLevel` =','4');
        $this->db->where('`A`.`withdraw` =','0');
       
        $query = $this->db->get();
      
        if($query->num_rows()> 0){
          return $query->result();
       }else{
          return $query->result();
       }
      }


       // 4th Year 
       public function Get_5th($array)
       {
         $this->db->select('Count(A.`Reference_Number`) AS REF');
         $this->db->from('Fees_Enrolled_College AS A');
         $this->db->join('Student_Info AS B','B.`Reference_Number` = A.`Reference_Number`','LEFT');
         $this->db->join('Program_Majors AS C','C.`ID` = B.`Major`','LEFT');
        // $this->db->join('`Legend` AS D', 'D.School_Year = A.schoolyear AND `D`.`Semester` = `A`.`Semester` ','LEFT');
         $this->db->where('A.course', $array['program']);
         $this->db->where('A.semester', $array['sem']);
         $this->db->where('A.schoolyear', $array['sy']);
         $this->db->where('B.Reference_Number !=','0');
         $this->db->where('A.Reference_Number !=','0');
         $this->db->where('A.`YearLevel` =','5');
         $this->db->where('`A`.`withdraw` =','0');
         $query = $this->db->get();
       
         if($query->num_rows()> 0){
           return $query->result();
        }else{
           return $query->result();
        }
       }


     // Withdraw
    public function Get_Withdraw($array)
    {
      $this->db->select('Count(A.`Reference_Number`) AS REF');
      $this->db->from('Fees_Enrolled_College AS A');
      $this->db->join('Student_Info AS B','B.`Reference_Number` = A.`Reference_Number`','LEFT');
      $this->db->join('Program_Majors AS C','C.`ID` = B.`Major`','LEFT');
      $this->db->where('A.course', $array['program']);
      $this->db->where('A.semester', $array['sem']);
      $this->db->where('A.schoolyear', $array['sy']);
      $this->db->where('B.Reference_Number !=','0');
      $this->db->where('A.Reference_Number !=','0');
      $this->db->where('A.`withdraw` =','1');

      $query = $this->db->get();
      
     
      if($query->num_rows()> 0){
        return $query->result();
     }else{
        return $query->result();
     }
     
    }




     // Enlisted
     public function Get_Enlisted($array)
     {
       $this->db->select('Count(A.`Reference_Number`) AS REF');
       $this->db->from('Advising AS A');
       $this->db->join('Fees_Enrolled_College AS B','A.`Reference_Number` = B.`Reference_Number`','LEFT');
       $this->db->where('A.Program', $array['program']);
       $this->db->where('A.Semester', $array['sem']);
       $this->db->where('A.School_Year', $array['sy']);
       $this->db->where('B.Reference_Number IS NULL');
       $query = $this->db->get();
       

       if($query->num_rows()> 0){
         return $query->result();
      }else{
         return $query->result();
      }
      
     }



  


}
?>
