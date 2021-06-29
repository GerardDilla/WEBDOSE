<?php


class Fees_Model extends CI_Model
{
  public function get_enrolled_fees($array_data)
  {
    $this->db->trans_start();
    $this->db->select('*');
    $this->db->from('Fees_Enrolled_College');
    $this->db->where('Reference_Number', $array_data['reference_no']);
    $this->db->where('course', $array_data['course']);
    $this->db->where('semester', $array_data['semester']);
    $this->db->where('schoolyear', $array_data['schoolyear']);
    $this->db->trans_complete();

    $query = $this->db->get();
    // reset query
    $this->db->reset_query();

    return $query->result_array();
  }

  public function get_fees_listing($array_data)
  {
    $this->db->select('*');
    $this->db->from('Fees_Listing AS `FEES`');
    $this->db->join('Fees_Listing_Items AS `ITEMS`', '`ITEMS`.`Fees_Listing_Id` = `FEES`.`id` AND `ITEMS`.`valid` = 1', 'inner');
    $this->db->join('`Fees_Listings_Items_Name` AS `NAME`', '`NAME`.`id` = `ITEMS`.`Fees_Listing_Items_Name_id` AND `NAME`.`optional` = 0 AND NAME.valid = 1', 'inner');
    $this->db->where('`FEES`.`Program_Code`', $array_data['program_code']);
    $this->db->where('`FEES`.`YearLevel`', $array_data['year_level']);
    $this->db->where('`FEES`.School_Year', $array_data['school_year']);
    $this->db->where('`FEES`.Semester', $array_data['semester']);
    $this->db->where('`FEES`.AdmitSchoolYear', $array_data['AdmittedSY']);
    $this->db->where('`FEES`.AdmitSemester', $array_data['AdmittedSEM']);
    $this->db->where('`FEES`.`valid`', 1);
    $query = $this->db->get();

    // reset query
    $this->db->reset_query();

    return $query->result_array();
  }

  public function get_subject_other_fees($array_data)
  {

    $ref_no = $array_data['reference_no'];
    $semester = $array_data['semester'];
    $school_year =  $array_data['school_year'];

    $query = $this->db->query("
        SELECT 
            `ST`.`subjecttype` AS `Subject_Type`,
            IFNULL(
                IF(
                  (SELECT 
                    COUNT(`ID`) 
                  FROM
                    `Fees_Listing_Subject_Other` 
                  WHERE `Course_Code` = `Sub`.`Course_Code` 
                    AND `Program_Code` = `Prog`.`Program_Code` 
                    AND `subjecttype_id` = `FLSO`.`subjecttype_id` 
                    AND `Semester` = `Sched`.`Semester` 
                    AND `School_Year` = `Sched`.`SchoolYear` 
                    AND `valid`) >= 1,
                  (SELECT 
                    `amount` 
                  FROM
                    `Fees_Listing_Subject_Other` 
                  WHERE `Course_Code` = `Sub`.`Course_Code` 
                    AND `Program_Code` = `Prog`.`Program_Code` 
                    AND `subjecttype_id` = `FLSO`.`subjecttype_id` 
                    AND `Semester` = `Sched`.`Semester` 
                    AND `School_Year` = `Sched`.`SchoolYear` 
                    AND `valid`),
                  (SELECT 
                    `amount` 
                  FROM
                    `Fees_Listing_Subject_Other` 
                  WHERE `Course_Code` = `Sub`.`Course_Code` 
                    AND `Program_Code` = 'N/A' 
                    AND `subjecttype_id` = `FLSO`.`subjecttype_id` 
                    AND `Semester` = `Sched`.`Semester` 
                    AND `School_Year` = `Sched`.`SchoolYear` 
                    AND `valid`)
                ),
                0.00
              ) AS `Other_Fee` 
        FROM
            `Fees_Listing_Subject_Other` AS `FLSO` 
            INNER JOIN `subjecttype` AS `ST` 
            ON `FLSO`.`subjecttype_id` = `ST`.`id` 
            AND `FLSO`.`valid` 
            AND `ST`.`is_lab` = 0 
            INNER JOIN Sched AS `Sched` 
            ON `FLSO`.`Course_Code` = `Sched`.`Course_Code` 
            INNER JOIN `Subject` AS `Sub` 
            ON `Sched`.Course_Code = `Sub`.Course_Code 
            AND `FLSO`.`Semester` = `Sched`.`Semester` 
            AND `FLSO`.`School_Year` = `Sched`.`SchoolYear`  
            INNER JOIN `Sections` AS `Sec` 
            ON `Sched`.`Section_ID` = `Sec`.`Section_ID` 
            INNER JOIN `Programs` AS `Prog` 
            ON `Sec`.`Program_ID` = `Prog`.`Program_ID` 
            INNER JOIN EnrolledStudent_Subjects AS `Adv` 
            ON `Sched`.`Sched_Code` = `Adv`.`Sched_Code` 
            AND `Sched`.`Valid` 
        WHERE `Adv`.`Reference_Number` = '$ref_no' 
            AND `Adv`.`Semester` = '$semester' 
            AND `Adv`.`School_Year` = '$school_year'
            AND (`Adv`.`Dropped` = '0' OR  `Adv`.`Charged` = '1')
            AND `Adv`.`Cancelled` = 0   
            GROUP BY `FLSO`.`Course_Code`,`FLSO`.`subjecttype_id`;
            
        ");



    return $query->result_array();
  }

  public function get_subject_lab_fee($array_data)
  {
    $ref_no = $array_data['reference_no'];
    $semester = $array_data['semester'];
    $school_year =  $array_data['school_year'];

    $query = $this->db->query("
        SELECT 
            `ST`.`subjecttype` AS `Subject_Type`,
            IFNULL(
                IF(
                  (SELECT 
                    COUNT(`ID`) 
                  FROM
                    `Fees_Listing_Subject_Other` 
                  WHERE `Course_Code` = `Sub`.`Course_Code` 
                    AND `Program_Code` = `Prog`.`Program_Code` 
                    AND `subjecttype_id` = `FLSO`.`subjecttype_id` 
                    AND `Semester` = `Sched`.`Semester` 
                    AND `School_Year` = `Sched`.`SchoolYear` 
                    AND `valid`) >= 1,
                  (SELECT 
                    `amount` 
                  FROM
                    `Fees_Listing_Subject_Other` 
                  WHERE `Course_Code` = `Sub`.`Course_Code` 
                    AND `Program_Code` = `Prog`.`Program_Code` 
                    AND `subjecttype_id` = `FLSO`.`subjecttype_id` 
                    AND `Semester` = `Sched`.`Semester` 
                    AND `School_Year` = `Sched`.`SchoolYear` 
                    AND `valid`),
                  (SELECT 
                    `amount` 
                  FROM
                    `Fees_Listing_Subject_Other` 
                  WHERE `Course_Code` = `Sub`.`Course_Code` 
                    AND `Program_Code` = 'N/A' 
                    AND `subjecttype_id` = `FLSO`.`subjecttype_id` 
                    AND `Semester` = `Sched`.`Semester` 
                    AND `School_Year` = `Sched`.`SchoolYear` 
                    AND `valid`)
                ),
                0.00
              ) AS `Lab_Fee` 
        FROM
            `Fees_Listing_Subject_Other` AS `FLSO` 
            INNER JOIN `subjecttype` AS `ST` 
            ON `FLSO`.`subjecttype_id` = `ST`.`id` 
            AND `FLSO`.`valid` 
            AND `ST`.`is_lab` = 1 
            INNER JOIN Sched AS `Sched` 
            ON `FLSO`.`Course_Code` = `Sched`.`Course_Code` 
            INNER JOIN `Subject` AS `Sub` 
            ON `Sched`.Course_Code = `Sub`.Course_Code 
            AND `FLSO`.`Semester` = `Sched`.`Semester` 
            AND `FLSO`.`School_Year` = `Sched`.`SchoolYear` 
            INNER JOIN `Sections` AS `Sec` 
            ON `Sched`.`Section_ID` = `Sec`.`Section_ID` 
            INNER JOIN `Programs` AS `Prog` 
            ON `Sec`.`Program_ID` = `Prog`.`Program_ID`  
            INNER JOIN EnrolledStudent_Subjects AS `Adv` 
            ON `Sched`.`Sched_Code` = `Adv`.`Sched_Code` 
            AND `Sched`.`Valid` 
        WHERE `Adv`.`Reference_Number` = '$ref_no' 
            AND `Adv`.`Semester` = '$semester' 
            AND `Adv`.`School_Year` = '$school_year'
            AND (`Adv`.`Dropped` = '0' OR  `Adv`.`Charged` = '1')
            AND `Adv`.`Cancelled` = 0 
            GROUP BY `FLSO`.`Course_Code`,`FLSO`.`subjecttype_id`;
        ");

    return $query->result_array();
  }

  public function get_payment_plans()
  {
    $this->db->select('*');
    $this->db->from('Fees_Legend');
    $query = $this->db->get();

    // reset query
    $this->db->reset_query();

    return $query->result_array();
  }

  public function replace_fees_college_data($array_update_fee, $array_data)
  {
    $this->db->trans_start();
    $this->db->set($array_update_fee);
    $this->db->where('id', $array_data['fees_enrolled_college_id']);
    $this->db->update('Fees_Enrolled_College', $array_update_fee);
    $this->db->trans_complete();

    $query_log = $this->db->last_query();
    // reset query
    $this->db->reset_query();

    return $query_log;
  }

  /*
    public function remove_fees_item($id)
    {
        $this->db->trans_start();
        $this->db->set('valid', 0);
        $this->db->where('Fees_Enrolled_College_Id', $id);
        $this->db->update('Fees_Enrolled_College_Item');
        $this->db->trans_complete();

        $query_log = $this->db->last_query();
        // reset query
        $this->db->reset_query();

        return $query_log;
    }
    */
  public function remove_fees_item($id)
  {
    /*
      $this->db->trans_start();
      $this->db->join('Fees_Listings_Items_Name AS FIN', 'FIN.`Fees_Name` = FI.`Fees_Name` AND FIN.`Fees_Type` = FI.`Fees_Type`', 'inner');
      $this->db->set('FI.`valid`', 0);
      $this->db->where('FI.Fees_Enrolled_College_Id', $id);
      $this->db->where('FIN.`optional`', 0);
      $this->db->update('Fees_Enrolled_College_Item AS FI');
      $this->db->trans_complete();
      */
    $sql = "
      UPDATE Fees_Enrolled_College_Item AS FI
      LEFT JOIN Fees_Listings_Items_Name AS FIN ON FIN.`Fees_Name` = FI.`Fees_Name` AND FIN.`Fees_Type` = FI.`Fees_Type`
      SET FI.`valid` = 0
      WHERE FI.Fees_Enrolled_College_Id = $id
      AND (! FIN.`optional` OR FIN.`optional` IS NULL)
      ";
    $query = $this->db->query($sql);

    $query_log = $this->db->last_query();
    // reset query
    $this->db->reset_query();

    return $query_log;
  }


  public function insert_fees_item($array_insert)
  {
    $this->db->trans_start();
    $this->db->insert_batch('Fees_Enrolled_College_Item', $array_insert);
    $this->db->trans_complete();
    if ($this->db->trans_status() === FALSE) {
      // generate an error... or use the log_message() function to log your error
      echo $this->db->last_query();
    }

    $query_log = $this->db->last_query();
    // reset query
    $this->db->reset_query();

    return $query_log;
  }

  public function get_fees_item($id)
  {
    $this->db->trans_start();
    $this->db->select('*');
    $this->db->from('Fees_Enrolled_College_Item');
    $this->db->where('Fees_Enrolled_College_Id', $id);
    $this->db->where('valid', 1);
    $this->db->trans_complete();

    $query = $this->db->get();

    // reset query
    $this->db->reset_query();

    return $query->result_array();
  }

  public function get_student_total_payment($array_data)
  {
    $this->db->trans_start();
    $this->db->select('SUM(AmountofPayment) AS total_payment, OR_Number, Transaction_Item, transDate, Transaction_Type, description, cashier, fix');
    $this->db->from('EnrolledStudent_Payments_Throughput');
    $this->db->where('Reference_Number', $array_data['reference_no']);
    $this->db->where('Semester', $array_data['semester']);
    $this->db->where('SchoolYear', $array_data['school_year']);
    $this->db->where('valid', 1);
    $this->db->group_by('OR_Number');
    $this->db->trans_complete();

    $query = $this->db->get();

    // reset query
    $this->db->reset_query();

    return $query->result_array();
  }

  public function remove_payments_throughput($array_data)
  {
    $this->db->trans_start();
    $this->db->set('valid', 0);
    $this->db->set('web_dose_module', 1);
    $this->db->set('reassessed', $array_data['date']);
    $this->db->where('Reference_Number', $array_data['reference_no']);
    $this->db->where('Semester', $array_data['semester']);
    $this->db->where('SchoolYear', $array_data['school_year']);
    $this->db->where('valid', 1);
    $this->db->update('EnrolledStudent_Payments_Throughput');
    $this->db->trans_complete();

    $query_log = $this->db->last_query();
    // reset query
    $this->db->reset_query();

    return $query_log;
  }

  public function insert_payments_throughput($array_insert)
  {
    $this->db->trans_start();
    $this->db->insert_batch('EnrolledStudent_Payments_Throughput', $array_insert);
    $this->db->trans_complete();

    $query_log = $this->db->last_query();
    // reset query
    $this->db->reset_query();

    return $query_log;
  }

  public function get_student_payment_list($array_data)
  {
    $this->db->trans_start();
    $this->db->select('*');
    $this->db->from('EnrolledStudent_Payments');
    $this->db->where('Reference_Number', $array_data['reference_no']);
    $this->db->where('Semester', $array_data['semester']);
    $this->db->where('SchoolYear', $array_data['school_year']);
    $this->db->where('OR_Number !=', 'NULL');
    $this->db->where('valid', 1);
    $this->db->trans_complete();

    $query = $this->db->get();

    // reset query
    $this->db->reset_query();

    return $query->result_array();
  }

  public function remove_student_refund($array_data)
  {
    $this->db->trans_start();
    $this->db->set('valid', 0);
    $this->db->set('web_dose_module', 1);
    $this->db->where('Reference_Number', $array_data['reference_no']);
    $this->db->where('Semester', $array_data['semester']);
    $this->db->where('SchoolYear', $array_data['school_year']);
    $this->db->where('valid', 1);
    $this->db->update('EnrolledStudent_Refund');
    $this->db->trans_complete();

    $query_log = $this->db->last_query();
    // reset query
    $this->db->reset_query();

    return $query_log;
  }

  public function insert_refund($array_data)
  {
    $this->db->trans_start();
    $this->db->insert('EnrolledStudent_Refund', $array_data);
    $this->db->trans_complete();

    $query_log = $this->db->last_query();
    // reset query
    $this->db->reset_query();

    return $query_log;
  }

  public function get_null_tuition()
  {
    $this->db->trans_start();
    $this->db->select('*');
    $this->db->from('Fees_Enrolled_College');
    $this->db->where('tuition_Fee IS NULL');
    $this->db->limit(5);
    $this->db->trans_complete();

    $query = $this->db->get();

    // reset query
    $this->db->reset_query();

    return $query->result_array();
  }

  public function get_foreign_fee($array_data)
  {
    $this->db->select('*');
    $this->db->from('Fees_Listing AS `FEES`');
    $this->db->join('Fees_Listing_Items AS `ITEMS`', '`ITEMS`.`Fees_Listing_Id` = `FEES`.`id` AND `ITEMS`.`valid` = 1', 'inner');
    $this->db->join('`Fees_Listings_Items_Name` AS `NAME`', '`NAME`.`id` = `ITEMS`.`Fees_Listing_Items_Name_id`', 'inner');
    //$this->db->join('Legend AS L', 'FEES.School_Year = L.School_Year AND FEES.Semester = L.Semester', 'inner');
    $this->db->where('`FEES`.`Program_Code`', $array_data['program_code']);
    $this->db->where('`FEES`.`YearLevel`', $array_data['year_level']);
    $this->db->where('`FEES`.School_Year', $array_data['school_year']);
    $this->db->where('`FEES`.Semester', $array_data['semester']);
    $this->db->where('`FEES`.AdmitSchoolYear', $array_data['AdmittedSY']);
    $this->db->where('`FEES`.AdmitSemester', $array_data['AdmittedSEM']);
    $this->db->where('`FEES`.`valid`', 1);
    $this->db->where('`ITEMS`.`Fees_Listing_Items_Name_id`', 16);
    $query = $this->db->get();

    // reset query
    $this->db->reset_query();

    return $query->result_array();
  }
}
