<?php


class EnrolledStudent_Foreign_Model extends CI_Model{
  

  
  public function Get_Nationality(){
    $this->db->select('Nationality');
    $this->db->group_by("Nationality");
    $this->db->from('Nationalities');
    $this->db->where('Nationality !=','FILIPINO');
    $query = $this->db->get();
    return $query;
                                    
  }

  public function GetStudentList_Foreign($array){
  
  
      $this->db->select('*,Fees_Enrolled_College.YearLevel AS YL');
      $this->db->from('Fees_Enrolled_College');
      $this->db->join('Student_Info', 'Student_Info.Reference_Number = Fees_Enrolled_College.Reference_Number','INNER');
      $this->db->join('Program_Majors','Program_Majors.ID = Student_Info.Major','LEFT');
   
          if($array['semester'] != NULL){
                $this->db->where('Fees_Enrolled_College.semester',$array['semester']);
            }
            if($array['school_year'] != NULL){ 
                $this->db->where('Fees_Enrolled_College.schoolyear',$array['school_year']);
            }
            if($array['nationality'] != NULL){ 
              $this->db->where('Student_Info.Nationality',$array['nationality']);
            }
            if($array['major'] != NULL){ 
              $this->db->where('Student_Info.Major',$array['major']);
            }
            if($array['program'] != NULL){ 
              $this->db->where('Student_Info.Course',$array['program']);
            }
            if($array['gender'] != NULL){ 
              $this->db->where('Student_Info.Gender',$array['gender']);
            }
            if($array['yearlevel'] != NULL){ 
              $this->db->where('Fees_Enrolled_College.YearLevel',$array['yearlevel']);
            }

      $this->db->where('Fees_Enrolled_College.semester',$array['semester']);
      $this->db->where('Fees_Enrolled_College.schoolyear',$array['school_year']);
      $this->db->where('Fees_Enrolled_College.withdraw','0');
      $this->db->where('Student_Info.Nationality !=','FILIPINO');
      $this->db->order_by('Student_Info.Nationality', 'ASC');
      $query = $this->db->get();
      return $query->result_array();
  }


}
?>
