<?php


class Helpdesk_Model extends CI_Model{
  
  public function getHelpdeskInquiries($input){

    $this->db->select('
      HI.`InquirerName`,
      HI.`InquirerEmail`,
      HI.`StudentNumber`,
      HI.`InquirySubject`,
      HI.`DateSubmitted`,
      HI.`Status`,
      HI.`Inquiry`,
      HC.`TopicCategory`,
      SI.`School_Name`,
      P.`Program_Code`,
      IF(`HI`.`Resolved` = 1, "YES", "NO") AS Resolved,
      IF(HI.`StudentStrand` = 0, "N/A", HI.`StudentStrand`) AS StudentStrand,
      IF(HI.`ContactNumber` = null, "N/A", HI.`ContactNumber`) AS ContactNumber
    ');
    $this->db->join('helpdesktopiccategory as HC','HI.StudentLevel = HC.ID','left');
    $this->db->join('School_Info as SI','HI.StudentDepartment = SI.School_ID','left');
    $this->db->join('Programs as P','HI.StudentProgram = P.Program_ID','left');

    if(!empty($input['searchkey'])){
      foreach($input['searchkey'] as $index => $searchkey){

        if($index == 0){
          $this->db->group_start();
            $this->db->like('HI.`InquirerName`',$searchkey);
            $this->db->or_like('HI.`InquirerEmail`',$searchkey);
            $this->db->or_like('HI.`StudentNumber`',$searchkey);
            $this->db->or_like('HI.`Inquiry`',$searchkey);
          $this->db->group_end();
        }else{
          $this->db->or_group_start();
            $this->db->like('HI.`InquirerName`',$searchkey);
            $this->db->or_like('HI.`InquirerEmail`',$searchkey);
            $this->db->or_like('HI.`StudentNumber`',$searchkey);
            $this->db->or_like('HI.`Inquiry`',$searchkey);
          $this->db->group_end();
        }

      }
    }
    
    if(!empty($input['datefrom'])){
      $this->db->where('HI.DateSubmitted >=', $input['datefrom'][0].' 00:00:00');
      $this->db->where('HI.DateSubmitted <', $input['datefrom'][1].' 00:00:00');
    }

    if(!empty($input['education'])){
      $this->db->group_start();
        foreach($input['education'] as $key => $education){

          if($key == 0){
            $this->db->where('HI.StudentLevel',$education);
          }else{
            $this->db->or_where('HI.StudentLevel',$education);
          }
          
        }
      $this->db->group_end();
    } 

    if($input['status'] != '' || $input['status'] != null){
      $this->db->where('HI.Resolved',$input['status']);
    } 
    
    $query = $this->db->get('helpdeskinquiries as HI');
    return $query->result_array();

  }

}
?>
