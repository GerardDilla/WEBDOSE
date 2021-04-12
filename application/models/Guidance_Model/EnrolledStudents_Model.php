<?php


class EnrolledStudents_Model extends CI_Model{
  


  public function GetSEM(){
    $this->db->select('*');
    $query = $this->db->get('Semesters');
    return $query;
                                    
  }
  
  public function GetYEAR(){
    $this->db->select('*');
    $query = $this->db->get('SchoolYear');
    return $query;
                                    
  }
  

   
  public function Get_Nationality(){
    $this->db->select('Nationality');
    $this->db->group_by("Nationality");
    $this->db->from('Nationalities');
    $query = $this->db->get();
    return $query;
                                    
  }
  
  
  public function Get_Course(){
    $this->db->select('Program_Code');
    $this->db->from('Programs');
    $query = $this->db->get();
    return $query;
                                    
  }
  

  
    public function GetMajor($Program_id){
    $this->db->select('*');
    $this->db->where('Program_Code = ',$Program_id);
    $this->db->from('Program_Majors');
    $query = $this->db->get();
    return $query->result_array();                            
  }


  public function GetSection_Name($Program_id){
    $this->db->select('*,Section_Name as SN');
    $this->db->from('Programs');
    $this->db->join('Sections', 'Sections.Program_ID = Programs.Program_ID','LEFT');
    $this->db->where('Sections.Active','1');
    $this->db->where('Programs.Program_Code',$Program_id);
    $this->db->order_by('Sections.Section_Name');
    $query = $this->db->get();
    return $query->result_array();  
                                    
  }
  


  public function Get_Gender(){
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
  
  
  public function GetYearLevel(){
    $this->db->select('Year_Level');
    $this->db->group_by('Year_Level');
    $this->db->where('Active','1');
    $this->db->where('Year_Level != ', 'N/A');
    $this->db->from('Sections');
    $query = $this->db->get();
    return $query;
                                    
  }
  
  

  public function Get_province(){
    $this->db->select('*');
    $this->db->order_by('provDesc','ASC');
    $this->db->where('provDesc != ', '0');
    $query = $this->db->get('refprovince');
    return $query;
                                    
  }

  
  public function Get_Municipality($Province_code){

    $this->db->select('*');
    $this->db->from('refcitymun AS A');
    $this->db->join('refprovince AS B', 'A.provCode = B.provCode','LEFT');
    $this->db->where('B.provDesc',$Province_code);
    $this->db->order_by('A.citymunDesc',ASC);
    $query = $this->db->get();
    return $query->result_array();  

  }
  
  
  public function Get_Barangay($Municipality_code){

    $this->db->select('*');
    $this->db->from('refcitymun AS A');
    $this->db->join('refbrgy AS B', 'A.citymunCode = B.citymunCode','LEFT');
    $this->db->where('A.citymunDesc',$Municipality_code);
    $this->db->order_by('B.brgyDesc',ASC);
    $query = $this->db->get();
    return $query->result_array();  
                                    
  }
  
  

  
  public function Get_highschool(){
    $this->db->select('Secondary_School_Name');
    $this->db->group_by('Secondary_School_Name');
    $this->db->where('Secondary_School_Name != ', 'N/A');
    $this->db->where('Secondary_School_Name != ', 'x');
    $this->db->where('Secondary_School_Name != ', '.');
    $this->db->where('Secondary_School_Name != ', '-');
    $this->db->where('Secondary_School_Name != ', '');
    $this->db->where('Secondary_School_Name != ', '123');
    $query = $this->db->get('Student_Info');
    return $query;
                                    
  }
  
  
  
  
  
  public function GetStudentList($array){
  
  
      $this->db->select('*,Fees_Enrolled_College.YearLevel AS YL');
      $this->db->from('Fees_Enrolled_College');
      $this->db->join('Student_Info', 'Student_Info.Reference_Number = Fees_Enrolled_College.Reference_Number');
      $this->db->join('Program_Majors','Program_Majors.ID = Student_Info.Major');
      $this->db->join('course','course.courseCode = Student_Info.Course','LEFT');
  
      if($array['submit'] != NULL){
        $this->db->where('Student_Info.Student_Number != ', '0');
   }
     if($array['sm'] != NULL){
         $this->db->where('Fees_Enrolled_College.semester',$array['sm']);
     }
     if($array['sy'] != NULL){ 
         $this->db->where('Fees_Enrolled_College.schoolyear',$array['sy']);
     }
     if($array['nt'] != NULL){ 
        $this->db->where('Student_Info.Nationality',$array['nt']);
     }
     if($array['major'] != NULL){ 
       $this->db->where('Student_Info.Major',$array['major']);
     }
     if($array['pmajor'] != NULL){ 
       $this->db->where('Student_Info.Course',$array['pmajor']);
     }
     if($array['Gender'] != NULL){ 
       $this->db->where('Student_Info.Gender',$array['Gender']);
     }
     if($array['nt'] != NULL){ 
       $this->db->where('Student_Info.Nationality',$array['nt']);
     }
     if($array['Sec'] != NULL){ 
      $this->db->where('D.Section',$array['Sec']);
    }
    if($array['municipality'] != NULL){ 
      $this->db->where('Student_Info.Address_City',$array['municipality']);
    }
     if($array['Yl'] != NULL){ 
       $this->db->where('Fees_Enrolled_College.YearLevel',$array['Yl']);
     }else{
     $this->db->where('Fees_Enrolled_College.semester',$array['sm']);
     $this->db->where('Fees_Enrolled_College.schoolyear',$array['sy']);
     $this->db->where('Fees_Enrolled_College.withdraw','0');
     $this->db->group_by('Fees_Enrolled_College.Reference_Number');
     $this->db->order_by('Student_Info.Last_Name', 'ASC');
     
     }
      $query = $this->db->get();
  
      if($query->num_rows()> 0){
        return $query;
            }else{
        return $query;
              }
  }


}
?>
