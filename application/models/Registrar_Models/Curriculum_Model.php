<?php

class Curriculum_Model extends CI_Model{


  
// Curriculum LIST MODEL

public function  curriculum_lists(){
  $Curriculum_year = $this->input->post('cy');
  $submit = $this->input->post('search_button');
  $Programs = $this->input->post('pro');
    
  $this->db->select('*');
  $this->db->from('Curriculum_Info');
  $this->db->join('Programs','Programs.Program_ID = Curriculum_Info.Program_ID');

  if(isset($submit)){
      $this->db->where('Curriculum_Info.Valid', '1');
      if(isset($Curriculum_year)){
      $this->db->where('Curriculum_Info.Curriculum_Year',$Curriculum_year);
      }
      if(isset($Programs)){
          $this->db->where('Curriculum_Info.Program_ID',$Programs);
      }
  }
  $query = $this->db->get();
  return $query;                       
}

public function  subject_list(){
  $Curriculum_id = $this->input->post('curtId');

  $this->db->select('*');
  $this->db->from('Curriculum');
  $this->db->where('Curriculum_ID',$Curriculum_id);
  $this->db->order_by("Curriculum_Semester", "Desc");
  $query = $this->db->get();
  return $query;
                        
}

public function subject_list_and_grades($array){

  $curriculum = $array['curriculum_id'];
  $id = $array['student_number'];
  $sql = "
      SELECT 
      a.Course_Code,
      a.Course_Title,
      IF(
        b.Grade IS NULL 
        OR b.Grade = '',
        ' ',
        b.Grade
      ) AS 'Grade',
      b.remarks AS 'Remarks',
      (
        a.Course_Lec_Unit + a.Course_Lab_Unit
      ) AS 'Units',
      IF(
        b.SEMTAKEN IS NULL 
        OR b.SEMTAKEN = '',
        ' ',
        b.SEMTAKEN
      ) AS 'SEMTAKEN',
      IF(
        b.SYTAKEN IS NULL 
        OR b.SYTAKEN = '',
        ' ',
        b.SYTAKEN
      ) AS 'SYTAKEN',
      IF(
        b.Completed IS NULL 
        OR b.Completed = '',
        ' ',
        b.Completed
      ) AS 'Completed',
      b.school 
    FROM
      (SELECT 
        Curri.Course_Code,
        Curri.Course_Title,
        SUB.Course_Lec_Unit,
        SUB.Course_Lab_Unit,
        Curri.Year_Level,
        Curri.Curriculum_Semester 
      FROM
        Curriculum AS Curri 
        INNER JOIN Curriculum_Info AS Curr 
          ON Curri.Curriculum_ID = Curr.Curriculum_ID 
        INNER JOIN `Subject` AS SUB 
          ON Curri.Course_Code = SUB.Course_Code 
      WHERE Curr.Curriculum_ID = '$curriculum') a 
      LEFT JOIN 
        (SELECT 
          'ST. DOMINIC COLLEGE OF ASIA' AS 'School',
          G.Subject_Code,
          IF(
            (G.`Subject_Code` LIKE 'EU%'),
            'PASSED',
            IF(
              G.Remarks_ID = '3' 
              AND G.Final_Grade < 75 
              OR G.Remarks_ID = '3',
              'INC',
              G.Final_Grade
            )
          ) AS 'Grade',
          IF(
            R.Remarks = 'Incomplete',
            'INC',
            UCASE(R.Remarks)
          ) AS Remarks,
          IF(
            G.Remarks_ID = '3',
            (SELECT 
              Final_Grade 
            FROM
              GradeCompletion 
            WHERE Student_Number = '$id' 
              AND Schedcode = G.Sched_Code),
            '---'
          ) AS 'Completed',
          G.Semester AS 'SEMTAKEN',
          G.School_Year AS 'SYTAKEN',
          IF(
            G.Semester = 
            (SELECT 
              Semester 
            FROM
              Legend) 
            AND G.School_Year = 
            (SELECT 
              School_Year 
            FROM
              Legend),
            'ON-GOING',
            'TAKEN'
          ) AS 'STATUS' 
        FROM
          Grading AS G 
          INNER JOIN Remarks AS R 
            ON G.Remarks_ID = R.Remarks_ID 
        WHERE Student_Number = '$id' 
        UNION
        ALL 
        SELECT 
          cg.School,
          cg.Credited_Subject AS 'Subject_Code',
          cg.Grade AS 'Grade',
          cg.Remark,
          '---' AS Completed,
          Semester AS 'SEMTAKEN',
          School_Year AS 'SYTAKEN',
          'CREDITED' AS `Status` 
        FROM
          Grading_Transferee AS cg 
        WHERE Student_Number = '$id' 
        ORDER BY SYTAKEN,
          SEMTAKEN) b 
        ON a.Course_Code = b.Subject_Code 
    WHERE b.Grade != '0' 
    ORDER BY b.SYTAKEN,
      b.SEMTAKEN 
  ";
  $result = $this->db->query($sql);
  if(!$result){
    return 0;
  }
  return $result->result_array();

}

public function  curriculum_lists_dropdown(){

  $this->db->select('*');
  $this->db->from('Curriculum_Info');
  $this->db->group_by('Curriculum_Year');
  $this->db->order_by("Curriculum_Year", "Asc");
  $query = $this->db->get();
  return $query;
                        
}


public function  curriculum_lists_dropdowns(){

  $this->db->select('*');
  $this->db->from('Curriculum_Info');
  $this->db->join('Programs','Programs.Program_ID = Curriculum_Info.Program_ID',LEFT);
  $this->db->group_by('Programs.Program_Code');
  $query = $this->db->get();
  return $query;
                        
}
                          
}
?>
