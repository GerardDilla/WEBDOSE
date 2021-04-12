<?php


class Global_Fees_Model extends CI_Model
{
    public function get_enrolled_fees($array_data)
    {
        $this->db->trans_start();
        $this->db->select('*');
        $this->db->from('Fees_Enrolled_College');
        $this->db->where('Reference_Number', $array_data['reference_no']);
        //$this->db->where('course', $array_data['course']);
        $this->db->where('semester', $array_data['semester']);
        $this->db->where('schoolyear', $array_data['schoolyear']);
        $this->db->trans_complete();

        $query = $this->db->get();
        // reset query
        //$this->db->reset_query();

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
        //$this->db->reset_query();

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
        //$this->db->reset_query();

        return $query->result_array();
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
      //$this->db->reset_query();

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
        //$this->db->reset_query();

        return $query->result_array();

    }

    public function insert_payments_throughput($array_insert)
    {
        $this->db->trans_start();
        $this->db->insert_batch('EnrolledStudent_Payments_Throughput', $array_insert);
        $this->db->trans_complete(); 
        
        $query_log = $this->db->last_query();
        // reset query
        //$this->db->reset_query();

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
        //$this->db->reset_query();

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
        //$this->db->reset_query();

        return $query->result_array();    
    }

    public function get_hed_remaining_balance($reference_no, $student_no)
    {
        $sql ='
            SELECT 
            SUM(`TOTAL`) AS `TOTAL`,
            SUM(`PAID`) AS `PAID`,
            schoolyear,
            semester,
            IF(
            (SUM(`TOTAL`) - SUM(`PAID`)) < 1,
            0,
            (SUM(`TOTAL`) - SUM(`PAID`))
            ) AS `BALANCE` 
        FROM
            (SELECT 
            `fees`.`withdraw` AS `WITHDRAW`,
            `fees`.`schoolyear`,
            `fees`.`semester`,
            IF(
                `fees`.`withdraw` < 1,
                (
                `fees`.`tuition_Fee` + SUM(
                    (
                    CASE
                        WHEN (`FECI`.`Fees_Type` = "MISC") 
                        THEN `FECI`.`Fees_Amount` 
                        ELSE 0.00 
                    END
                    )
                ) + SUM(
                    (
                    CASE
                        WHEN (`FECI`.`Fees_Type` = "OTHER") 
                        THEN `FECI`.`Fees_Amount` 
                        ELSE 0.00 
                    END
                    )
                ) + SUM(
                    (
                    CASE
                        WHEN (`FECI`.`Fees_Type` = "LAB") 
                        THEN `FECI`.`Fees_Amount` 
                        ELSE 0.00 
                    END
                    )
                )
                ),
                (SELECT 
                `fees`.`withdrawalfee` 
                FROM
                WithdrawInformation 
                WHERE Student_Number = '.$this->db->escape($student_no).'
                AND semester = `fees`.`semester` 
                AND SchoolYear = `fees`.SchoolYear 
                LIMIT 1)
            ) AS `TOTAL`,
            (SELECT 
                SUM(AmountofPayment) 
            FROM
                EnrolledStudent_Payments_Throughput 
            WHERE Reference_Number = `fees`.`Reference_Number` 
                AND itemPaid != "Excess" 
                AND itemPaid != "REFUND" 
                AND semester = `fees`.`semester` 
                AND schoolyear = `fees`.`schoolyear` 
                AND valid) AS `PAID` 
            FROM
            Fees_Enrolled_College AS `fees` 
            INNER JOIN `Fees_Enrolled_College_Item` AS `FECI` 
                ON `fees`.`id` = `FECI`.`Fees_Enrolled_College_Id` 
                AND `FECI`.`valid` 
            WHERE `fees`.`Reference_Number` = '.$this->db->escape($reference_no).' 
            GROUP BY schoolyear,
            semester) a 
        GROUP BY schoolyear,
            semester 
        
        ';

        $query = $this->db->query($sql);

        return $query->result_array();
    }

    public function get_student_other_fees($student_number, $school_level)
    {
        $this->db->select('itemPaid, itemAmount, currency');
        $this->db->from('student_OtherFees');
        $this->db->where('studentNumber', $student_number);
        $this->db->where('schoolLevel', $school_level);
        $this->db->where('valid', 1);
        $query = $this->db->get();

        return $query->result_array();

    }

    public function get_student_other_fees_payments($student_no, $item_paid, $school_level)
    {
        $this->db->select('SUM(itemAmount) AS total_paid');
        $this->db->from('cashier_OtherTransactionMr');
        $this->db->where('itemPaid', $item_paid);
        $this->db->where('studentNumber', $student_no);
        $this->db->where('schoolLevel', $school_level);
        $this->db->where('valid', 1);
        $query = $this->db->get();

        $output = $query->result_array();
        return $output[0]['total_paid'];

    }

    public function get_student_bus_ctr_fees($reference_no, $school_level)
    {
        $this->db->select('itemPaid, itemAmount, currency');
        $this->db->from('student_OtherFees_BusCtr');
        $this->db->where('Reference_Number', $reference_no);
        $this->db->where('schoolLevel', $school_level);
        $this->db->where('valid', 1);

        $query = $this->db->get();

        return $query->result_array();
    }

    public function get_student_bus_ctr_fees_payments($student_no, $item_paid, $school_level)
    {
      $this->db->select('SUM(itemAmount) AS total_paid');
      $this->db->from('cashier_BusinessCenter');
      $this->db->where('itemPaid', $item_paid);
      $this->db->where('studentNumber', $student_no);
      $this->db->where('schoolLevel', $school_level);
      $this->db->where('valid', 1);
      $query = $this->db->get();

      $output = $query->result_array();
      return $output[0]['total_paid'];
    }

}