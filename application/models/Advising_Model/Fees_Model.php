<?php


class Fees_Model extends CI_Model
{
    
    public function get_fees_without_admit($array_data)
    {
        $this->db->select('*');
        $this->db->from('Fees_Listing AS `FEES`');
        $this->db->join('Fees_Listing_Items AS `ITEMS`', '`ITEMS`.`Fees_Listing_Id` = `FEES`.`id` AND `ITEMS`.`valid` = 1', 'inner');
        $this->db->join('`Fees_Listings_Items_Name` AS `NAME`', '`NAME`.`id` = `ITEMS`.`Fees_Listing_Items_Name_id` AND `NAME`.`optional` = 0', 'inner');
        //$this->db->join('Legend AS L', 'FEES.School_Year = L.School_Year AND FEES.Semester = L.Semester', 'inner');
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

    public function get_fees_with_admit($array_data)
    {
        $this->db->select('*');
        $this->db->from('Fees_Listing AS `FEES`');
        $this->db->join('Fees_Listing_Items AS `ITEMS`', '`ITEMS`.`Fees_Listing_Id` = `FEES`.`id` AND `ITEMS`.`valid` = 1', 'inner');
        $this->db->join('`Fees_Listings_Items_Name` AS `NAME`', '`NAME`.`id` = `ITEMS`.`Fees_Listing_Items_Name_id` AND `NAME`.`optional` = 0', 'inner');
        //$this->db->join('Legend AS L', 'FEES.School_Year = L.School_Year AND FEES.Semester = L.Semester', 'inner');
        $this->db->where('`FEES`.`Program_Code`', $array_data['program_code']);
        $this->db->where('`FEES`.`YearLevel`', $array_data['year_level']);
        $this->db->where('`FEES`.School_Year', $array_data['school_year']);
        $this->db->where('`FEES`.Semester', $array_data['semester']);
        $this->db->where('`FEES`.`valid`', 1);
        $query = $this->db->get();

        // reset query
        $this->db->reset_query();

        return $query->result_array();
    }

    public function get_lab_fee($array_data)
    {
        /*
        $this->db->select('*');
        $this->db->from('Programs AS Prog');
        $this->db->join('Sections AS Sec', 'Prog.Program_ID = Sec.Program_ID', 'inner');
        $this->db->join('Sched AS S', 'Sec.Section_ID = S.Section_ID', 'inner');
        $this->db->join('`Subject` AS Subj', 'S.Course_Code = Subj.Course_Code', 'inner');
        $this->db->join('subjecttype AS ST', 'ST.id = Subj.Course_Type_ID', 'inner');
        $this->db->join('Enrolled_LabFeesListing AS ELF', 'ST.id = ELF.Labtype_ID', 'inner');
        $this->db->join('Legend AS Leg', 'S.SchoolYear = Leg.School_Year AND Leg.`School_Year` = S.`SchoolYear`');
        $this->db->where('Prog.Program_Code', $array_data['program_code']);
        $this->db->where('S.Valid', 1);
        $this->db->where('Subj.Course_Type_Id <>', 46);
        $this->db->group_by("S.Sched_Code");
        */
        $this->db->distinct('DISTINCT S.Sched_Code, ST.subjecttype, ELF.Fee, `ASess`.`ID` AS session_id');
        $this->db->from('advising_session AS ASess'); 
        $this->db->join('Sched AS S', 'S.`Sched_Code` = ASess.`Sched_Code`', 'inner');
        $this->db->join('Sched_Display AS SD', 'ASess.`Sched_Display_ID` = SD.`id`', 'inner');
        $this->db->join('`Subject` AS Subj', '`Subj`.`Course_Code` = S.`Course_Code`', 'inner');
        $this->db->join('subjecttype AS ST', 'ST.id = Subj.Course_Type_ID', 'inner');
        // $this->db->join('Enrolled_LabFeesListing AS ELF', 'ST.id = ELF.Labtype_ID', 'inner');
        $this->db->join('Legend AS Leg', 'S.SchoolYear = Leg.School_Year AND Leg.`School_Year` = S.`SchoolYear`');
        $this->db->join('`Sections` AS Sec', '`Sec`.`Section_ID` = S.`Section_ID`', 'inner');
        $this->db->where('ASess.`Reference_Number`', $array_data['reference_no']);
        $this->db->where('ASess.`valid`', 1);
        $this->db->where('Subj.Course_Type_Id <>', 46);
        

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
    


    public function get_payment_plans()
    {
        $this->db->select('*');
        $this->db->from('Fees_Legend');
        $query = $this->db->get();

        // reset query
        $this->db->reset_query();

        return $query->result_array();
    }

    public function insert_fees_college($array_insert)
    {
        $this->db->insert('Fees_Temp_College', $array_insert);

        $query_log = $this->db->last_query();
        // reset query
        $this->db->reset_query();

        $array_return = array(
            'query_log' => $query_log,
            'insert_id' => $this->db->insert_id()
        );
        
        return $array_return;
    }

    public function get_fees_college_data($array_data)
    {
        $this->db->select('*');
        $this->db->from('Fees_Temp_College'); 
        $this->db->where('Reference_Number', $array_data['reference_no']);
        $this->db->where('Semester', $array_data['semester']);
        $this->db->where('SchoolYear', $array_data['school_year']);

        $query = $this->db->get();

        // reset query
        $this->db->reset_query();

        return $query->result_array();
    }

    public function replace_fees_college_data($array_update_fee, $array_data)
    {
        $this->db->set($array_update_fee);
        $this->db->where('id', $array_data['fees_temp_college_id']);
        $this->db->update('Fees_Temp_College', $array_update_fee);

        $query_log = $this->db->last_query();
        // reset query
        $this->db->reset_query();

        return $query_log;
    }

    public function insert_fees_item($array_insert)
    {
        
        $this->db->insert_batch('Fees_Temp_College_Item', $array_insert); 
        $query_log = $this->db->last_query();
        // reset query
        $this->db->reset_query();

        return $query_log;
    }

    public function remove_fees_item($id)
    {
        $this->db->set('valid', 0);
        $this->db->where('Fees_Temp_College_Id', $id);
        $this->db->update('Fees_Temp_College_Item');

        $query_log = $this->db->last_query();
        // reset query
        $this->db->reset_query();

        return $query_log;
    }

    public function get_subject_lab_fee_advised($array_data)
    {
        /*
        $this->db->select('`ST`.`subjecttype` AS `Subject Type`, `ELFL`.`Fee` AS `Lab_Fee`');
        $this->db->from('`Fees_Listing_Subject_Other` AS `FLSO`');
        $this->db->join('`subjecttype` AS `ST`', '`FLSO`.`subjecttype_id` = `ST`.`id` AND `FLSO`.`valid` AND `ST`.`is_lab` = 1', 'inner');
        $this->db->join('Sched AS `Sched`', '`FLSO`.`Course_Code` = `Sched`.`Course_Code`', 'inner');
        $this->db->join('`Subject` AS `Sub`', '`Sched`.Course_Code = `Sub`.Course_Code AND `FLSO`.`Semester` = `Sched`.`Semester` AND `FLSO`.`School_Year` = `Sched`.`SchoolYear`', 'inner');
        $this->db->join('`Enrolled_LabFeesListing` AS `ELFL`', '`ST`.`id` = `ELFL`.`Labtype_ID` AND `ELFL`.`Semester` = `Sched`.`Semester` AND `ELFL`.`School_Year` = `Sched`.`SchoolYear`', 'inner');
        $this->db->join('`Sections` AS `Sec`', '`Sched`.`Section_ID` = `Sec`.`Section_ID` ', 'inner');
        $this->db->join('`Programs` AS `Prog`', '`Sec`.`Program_ID` = `Prog`.`Program_ID` AND `FLSO`.`Program_Code` = `Prog`.`Program_Code`','inner');
        $this->db->join('Advising AS `Adv`', '`Sched`.`Sched_Code` = `Adv`.`Sched_Code` AND `Sched`.`Valid`', 'inner');
        $this->db->where('`Adv`.`Reference_Number`', $array_data['reference_no']);
        $this->db->where('`Adv`.`Semester`', $array_data['semester']);
        $this->db->where('`Adv`.`School_Year`', $array_data['sy']);
        $this->db->where('`Adv`.`valid`', 1);

        $query = $this->db->get();

        // reset query
        $this->db->reset_query();
        */
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
            INNER JOIN Advising AS `Adv` 
            ON `Sched`.`Sched_Code` = `Adv`.`Sched_Code` 
            AND `Sched`.`Valid` 
        WHERE `Adv`.`Reference_Number` = '$ref_no' 
            AND `Adv`.`Semester` = '$semester' 
            AND `Adv`.`School_Year` = '$school_year' 
            AND `Adv`.`valid`
            GROUP BY `FLSO`.`Course_Code`,`FLSO`.`subjecttype_id`;
        ");

        return $query->result_array();
    }

    public function get_subject_lab_fee_session($array_data)
    {
        /*
        $this->db->select('`ST`.`subjecttype` AS `Subject Type`, `ELFL`.`Fee` AS `Lab_Fee`');
        $this->db->from('`Fees_Listing_Subject_Other` AS `FLSO`');
        $this->db->join('`subjecttype` AS `ST`', '`FLSO`.`subjecttype_id` = `ST`.`id` AND `FLSO`.`valid` AND `ST`.`is_lab` = 1', 'inner');
        $this->db->join('Sched AS `Sched`', '`FLSO`.`Course_Code` = `Sched`.`Course_Code`', 'inner');
        $this->db->join('`Subject` AS `Sub`', '`Sched`.Course_Code = `Sub`.Course_Code AND `FLSO`.`Semester` = `Sched`.`Semester` AND `FLSO`.`School_Year` = `Sched`.`SchoolYear`', 'inner');
        $this->db->join('`Enrolled_LabFeesListing` AS `ELFL`', '`ST`.`id` = `ELFL`.`Labtype_ID` AND `ELFL`.`Semester` = `Sched`.`Semester` AND `ELFL`.`School_Year` = `Sched`.`SchoolYear`', 'inner');
        $this->db->join('`Sections` AS `Sec`', '`Sched`.`Section_ID` = `Sec`.`Section_ID`', 'inner');
        $this->db->join('`Programs` AS `Prog`', '`Sec`.`Program_ID` = `Prog`.`Program_ID` AND `FLSO`.`Program_Code` = `Prog`.`Program_Code`','inner');
        $this->db->join('advising_session AS `Adv`', '`Sched`.`Sched_Code` = `Adv`.`Sched_Code` AND `Sched`.`Valid`', 'inner');
        $this->db->where('`Adv`.`Reference_Number`', $array_data['reference_no']);
        $this->db->where('`Adv`.`Semester`', $array_data['semester']);
        $this->db->where('`Adv`.`School_Year`', $array_data['sy']);
        $this->db->where('`Adv`.`valid`', 1);

        $query = $this->db->get();

        // reset query
        $this->db->reset_query();
        */

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
            INNER JOIN advising_session AS `Adv` 
            ON `Sched`.`Sched_Code` = `Adv`.`Sched_Code` 
            AND `Sched`.`Valid` 
        WHERE `Adv`.`Reference_Number` = '$ref_no' 
            AND `Adv`.`Semester` = '$semester' 
            AND `Adv`.`School_Year` = '$school_year' 
            AND `Adv`.`valid`
            GROUP BY `FLSO`.`Course_Code`,`FLSO`.`subjecttype_id`;
        ");

        return $query->result_array();
    }

    public function get_subject_other_fee_advised($array_data)
    {
        /*
        $this->db->select('`ST`.`subjecttype` AS `Subject Type`, `ELFL`.`Fee` AS `Other_Fee`');
        $this->db->from('`Fees_Listing_Subject_Other` AS `FLSO`');
        $this->db->join('`subjecttype` AS `ST`', '`FLSO`.`subjecttype_id` = `ST`.`id` AND `FLSO`.`valid` AND `ST`.`is_lab` = 0', 'inner');
        $this->db->join('Sched AS `Sched`', '`FLSO`.`Course_Code` = `Sched`.`Course_Code`', 'inner');
        $this->db->join('`Subject` AS `Sub`', '`Sched`.Course_Code = `Sub`.Course_Code AND `FLSO`.`Semester` = `Sched`.`Semester` AND `FLSO`.`School_Year` = `Sched`.`SchoolYear`', 'inner');
        $this->db->join('`Enrolled_LabFeesListing` AS `ELFL`', '`ST`.`id` = `ELFL`.`Labtype_ID` AND `ELFL`.`Semester` = `Sched`.`Semester` AND `ELFL`.`School_Year` = `Sched`.`SchoolYear`', 'inner');
        $this->db->join('`Sections` AS `Sec`', '`Sched`.`Section_ID` = `Sec`.`Section_ID` ', 'inner');
        $this->db->join('`Programs` AS `Prog`', '`Sec`.`Program_ID` = `Prog`.`Program_ID` AND `FLSO`.`Program_Code` = `Prog`.`Program_Code`','inner');
        $this->db->join('Advising AS `Adv`', '`Sched`.`Sched_Code` = `Adv`.`Sched_Code` AND `Sched`.`Valid`', 'inner');
        $this->db->where('`Adv`.`Reference_Number`', $array_data['reference_no']);
        $this->db->where('`Adv`.`Semester`', $array_data['semester']);
        $this->db->where('`Adv`.`School_Year`', $array_data['sy']);
        $this->db->where('`Adv`.`valid`', 1);

        $query = $this->db->get();

        // reset query
        $this->db->reset_query();
        */

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
            INNER JOIN Advising AS `Adv` 
            ON `Sched`.`Sched_Code` = `Adv`.`Sched_Code` 
            AND `Sched`.`Valid` 
        WHERE `Adv`.`Reference_Number` = '$ref_no' 
            AND `Adv`.`Semester` = '$semester' 
            AND `Adv`.`School_Year` = '$school_year' 
            AND `Adv`.`valid`
            GROUP BY `FLSO`.`Course_Code`,`FLSO`.`subjecttype_id`;
        ");

        return $query->result_array();
    }

    public function get_subject_other_fee_session($array_data)
    {
        /*
        $this->db->select('`ST`.`subjecttype` AS `Subject Type`, `ELFL`.`Fee` AS `Other_Fee`');
        $this->db->from('`Fees_Listing_Subject_Other` AS `FLSO`');
        $this->db->join('`subjecttype` AS `ST`', '`FLSO`.`subjecttype_id` = `ST`.`id` AND `FLSO`.`valid` = 1 AND `ST`.`is_lab` = 0', 'inner');
        $this->db->join('Sched AS `Sched`', '`FLSO`.`Course_Code` = `Sched`.`Course_Code`', 'inner');
        $this->db->join('`Subject` AS `Sub`', '`Sched`.Course_Code = `Sub`.Course_Code AND `FLSO`.`Semester` = `Sched`.`Semester` AND `FLSO`.`School_Year` = `Sched`.`SchoolYear`', 'inner');
        $this->db->join('`Enrolled_LabFeesListing` AS `ELFL`', '`ST`.`id` = `ELFL`.`Labtype_ID` AND `ELFL`.`Semester` = `Sched`.`Semester` AND `ELFL`.`School_Year` = `Sched`.`SchoolYear`', 'inner');
        $this->db->join('`Sections` AS `Sec`', '`Sched`.`Section_ID` = `Sec`.`Section_ID` ', 'inner');
        $this->db->join('`Programs` AS `Prog`', '`Sec`.`Program_ID` = `Prog`.`Program_ID` AND `FLSO`.`Program_Code` = `Prog`.`Program_Code`','inner');
        $this->db->join('advising_session AS `Adv`', '`Sched`.`Sched_Code` = `Adv`.`Sched_Code` AND `Sched`.`Valid`', 'inner');
        $this->db->where('`Adv`.`Reference_Number`', $array_data['reference_no']);
        $this->db->where('`Adv`.`Semester`', $array_data['semester']);
        $this->db->where('`Adv`.`School_Year`', $array_data['sy']);
        $this->db->where('`Adv`.`valid`', 1);
        */
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
            INNER JOIN advising_session AS `Adv` 
            ON `Sched`.`Sched_Code` = `Adv`.`Sched_Code` 
            AND `Sched`.`Valid` 
        WHERE `Adv`.`Reference_Number` = '$ref_no' 
            AND `Adv`.`Semester` = '$semester' 
            AND `Adv`.`School_Year` = '$school_year' 
            AND `Adv`.`valid`
            GROUP BY `FLSO`.`Course_Code`,`FLSO`.`subjecttype_id`;
        ");

       

        return $query->result_array();
    }



}