<?php


class Fees_Model extends CI_Model
{
    public function check_duplicate_or($or_no)
    {
        $this->db->select('ID');
        $this->db->from('ReservationFee');
        $this->db->where('OR_Number', $or_no);

        $query = $this->db->get();

        // reset query
        #$this->db->reset_query();

        return $query->result_array();
    }

    public function check_duplicate_or_enrollment($or_no)
    {
        $this->db->select('id');
        $this->db->from('EnrolledStudent_Payments');
        $this->db->where('OR_Number', $or_no);

        $query = $this->db->get();

        // reset query
        #$this->db->reset_query();

        return $query->result_array();
    }

    public function insert_reservation($array_data)
    {
        $this->db->trans_start();
        $this->db->insert('ReservationFee', $array_data);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            // generate an error... or use the log_message() function to log your error
            $message = "fail to insert Reservation data";
        } else {
            $message = "Insert Reservation data Success";
        }


        // reset query
        #$this->db->reset_query();

        return $message;
    }

    public function get_student_total_payment($array_data)
    {
        $this->db->trans_start();
        $this->db->select('SUM(AmountofPayment) AS total_payment');
        $this->db->from('EnrolledStudent_Payments_Throughput');
        $this->db->where('Reference_Number', $array_data['reference_no']);
        $this->db->where('Semester', $array_data['semester']);
        $this->db->where('SchoolYear', $array_data['schoolyear']);
        $this->db->where('valid', 1);
        $this->db->group_by('Reference_Number');
        $this->db->trans_complete();

        $query = $this->db->get();

        // reset query
        #$this->db->reset_query();

        return $query->result_array();
    }

    public function get_payment_throughput_list($array_data)
    {
        $this->db->select('fees.id AS fees_enrolled_id, throughput.Fees_Enrolled_College_Item_id AS throughput_item_id, throughput.AmountofPayment AS throughput_amount_paid,
            item.id AS item_id, item.Fees_Name AS item_name, item.Fees_Amount AS item_amount');
        $this->db->from('Fees_Enrolled_College AS fees');
        $this->db->join('Fees_Enrolled_College_Item AS item', 'fees.id = item.Fees_Enrolled_College_Id', 'inner');
        $this->db->join('EnrolledStudent_Payments_Throughput AS throughput', 'throughput.Fees_Enrolled_College_Item_id = item.id AND throughput.valid', 'inner');
        $this->db->where('fees.semester', $array_data['semester']);
        $this->db->where('fees.schoolyear', $array_data['schoolyear']);
        //$this->db->where('fees.course', $array_data['course']);
        $this->db->where('fees.Reference_Number', $array_data['reference_no']);
        $this->db->order_by('throughput.id', 'DESC');

        $query = $this->db->get();

        // reset query
        #$this->db->reset_query();

        return $query->result_array();
    }

    public function check_throughput_item_total_paid($array_data)
    {
        $this->db->select('SUM(AmountofPayment) AS total_payment');
        $this->db->from('EnrolledStudent_Payments_Throughput');
        $this->db->where('Reference_Number', $array_data['reference_no']);
        $this->db->where('semester', $array_data['semester']);
        $this->db->where('SchoolYear', $array_data['schoolyear']);
        $this->db->where('Fees_Enrolled_College_Item_id', $array_data['item_id']);
        $this->db->where('valid', 1);

        $query = $this->db->get();

        // reset query
        #$this->db->reset_query();

        return $query->result_array();
    }

    public function get_unpaid_fees_item($array_data)
    {
        $this->db->select('id AS item_id, Fees_Type, Fees_Name, Fees_Amount');
        $this->db->from('Fees_Enrolled_College_Item');
        $this->db->where('Fees_Enrolled_College_Id', $array_data['fees_enrolled_id']);
        $this->db->where_not_in('id', $array_data['array_item_id']);
        $this->db->where('valid', 1);


        $query = $this->db->get();

        // reset query
        #$this->db->reset_query();

        return $query->result_array();
    }

    public function get_fees_item($array_data)
    {
        $this->db->select('id AS item_id, Fees_Type, Fees_Name, Fees_Amount');
        $this->db->from('Fees_Enrolled_College_Item');
        $this->db->where('Fees_Enrolled_College_Id', $array_data['fees_enrolled_id']);
        $this->db->where('valid', 1);


        $query = $this->db->get();

        // reset query
        #$this->db->reset_query();

        return $query->result_array();
    }

    public function insert_refund($array_data)
    {
        $this->db->trans_start();
        $this->db->insert('EnrolledStudent_Refund', $array_data);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            // generate an error... or use the log_message() function to log your error
            $message = "fail to insert Refund data";
        } else {
            $message = "Insert refund sucessful";
        }


        // reset query
        #$this->db->reset_query();

        return $message;
    }

    public function insert_payments_throughput($array_data)
    {
        $this->db->trans_start();
        $this->db->insert_batch('EnrolledStudent_Payments_Throughput', $array_data);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            // generate an error... or use the log_message() function to log your error
            $message = "fail to insert Fees Throughput";
        } else {
            $message = "Insert fees throughput sucessful";
        }

        // reset query
        #$this->db->reset_query();

        return $message;
    }

    public function insert_student_payment($array_data)
    {
        $this->db->trans_start();
        $this->db->insert('EnrolledStudent_Payments', $array_data);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            // generate an error... or use the log_message() function to log your error
            $message = "fail to insert Student payment data";
        } else {
            $message = "Insert student payment sucessful";
        }


        // reset query
        #$this->db->reset_query();

        return $message;
    }

    public function get_paid_tuition_fee($array_data)
    {
        $this->db->trans_start();
        $this->db->select('SUM(AmountofPayment) AS total_payment');
        $this->db->from('EnrolledStudent_Payments_Throughput');
        $this->db->where('Reference_Number', $array_data['reference_no']);
        $this->db->where('Semester', $array_data['semester']);
        $this->db->where('SchoolYear', $array_data['schoolyear']);
        $this->db->where('itemPaid', 'Tuition');
        $this->db->where('valid', 1);
        $this->db->group_by('Reference_Number');
        $this->db->trans_complete();

        $query = $this->db->get();

        // reset query
        #$this->db->reset_query();

        return $query->result_array();
    }

    public function get_to_apply_hed_reservations()
    {
        $this->db->select('reservation.ID AS reservation_id, reservation.Semester, reservation.SchoolYear, reservation.Amount, reservation.Transaction_Item, 
        reservation.OR_Number, reservation.Payment_Type, reservation.Description, reservation.Append_Cashier, reservation.Append_Date, Users.User_FullName AS cashier_name');
        $this->db->from('ReservationFee AS reservation');
        $this->db->join('Users', 'reservation.Append_Cashier = Users.User_ID', 'inner');
        $this->db->where('Reference_No', $this->student_data->get_reference_no());
        $this->db->where('Semester', $this->student_data->get_semester());
        $this->db->where('SchoolYear', $this->student_data->get_school_year());
        $this->db->where('valid', 1);
        $this->db->where('Applied', 0);


        $query = $this->db->get();

        // reset query
        #$this->db->reset_query();

        return $query->result_array();
    }

    public function get_hed_payments()
    {
        $this->db->select('payment.id as payment_id, payment.AmountofPayment, payment.OR_Number, payment.Date, payment.Transaction_Type, payment.Transaction_Item, 
        payment.description, Users.User_FullName as cashier_name');
        $this->db->from('EnrolledStudent_Payments AS payment');
        $this->db->join('Users', 'payment.cashier = Users.User_ID', 'inner');
        $this->db->where('Reference_Number', $this->student_data->get_reference_no());
        $this->db->where('Semester', $this->student_data->get_semester());
        $this->db->where('SchoolYear', $this->student_data->get_school_year());
        $this->db->where('valid', 1);


        $query = $this->db->get();

        // reset query
        #$this->db->reset_query();

        return $query->result_array();
    }

    public function check_to_apply_hed_reservations()
    {
        $this->db->select('ID AS reservation_id, Semester, SchoolYear, Amount, Transaction_Item, OR_Number, Payment_Type, Description, Append_Cashier, Append_Date');
        $this->db->from('ReservationFee');
        $this->db->where('Reference_No', $this->student_data->get_reference_no());
        $this->db->where('Semester', $this->student_data->get_semester());
        $this->db->where('SchoolYear', $this->student_data->get_school_year());
        $this->db->where('valid', 1);
        $this->db->where('Applied', 0);


        $query = $this->db->get();

        // reset query
        #$this->db->reset_query();

        return $query->result_array();
    }

    public function update_applied_hed_reservation($array_data, $reservation_id)
    {
        $this->db->trans_start();
        $this->db->where('ID', $reservation_id);
        $this->db->update('ReservationFee', $array_data);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            // generate an error... or use the log_message() function to log your error
            $message = "fail to Update student HED Reservation(applied)";
        } else {
            $message = "Update HED Reservation sucessful(applied)";
        }


        // reset query
        #$this->db->reset_query();

        return $message;
    }

    public function get_hed_remaining_balance()
    {
        $sql = '
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
                WHERE Student_Number = ' . $this->db->escape($this->student_data->get_student_no()) . '
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
            WHERE `fees`.`Reference_Number` = ' . $this->db->escape($this->student_data->get_reference_no()) . ' 
            GROUP BY schoolyear,
            semester) a 
        GROUP BY schoolyear,
            semester 
        
        ';

        $query = $this->db->query($sql);

        return $query->result_array();
    }

    public function check_hed_payment_approval()
    {
        $this->db->select('*');
        $this->db->from('approve_Payment');
        $this->db->where('Reference_Number', $this->student_data->get_reference_no());
        $this->db->where('Student_Number', $this->student_data->get_student_no());
        $this->db->where('Semester', $this->student_data->get_semester());
        $this->db->where('SchoolYear', $this->student_data->get_school_year());
        $this->db->where('schoolLevel', 'HigherED');
        $this->db->where('valid', 1);

        $query = $this->db->get();

        // reset query
        #$this->db->reset_query();

        return $query->result_array();
    }

    public function get_bed_remaining_balance()
    {
        $sql = '
        SELECT 
        SUM(`TOTAL`) AS `TOTAL`,
        SUM(`PAID`) AS `PAID`,
        schoolyear,
        IF(
          (SUM(`TOTAL`) - SUM(`PAID`)) < 1,
          0,
          (SUM(`TOTAL`) - SUM(`PAID`))
        ) AS `BALANCE` 
      FROM
        (SELECT 
          `bed_withdraw`.`ID`,
          `fees`.`SchoolYear`,
          IF(
            `bed_withdraw`.`ID` IS NULL,
            (
              `fees`.`Initial_Payment` + `fees`.`First_Payment` + `fees`.`Second_Payment` + `fees`.`Third_Payment` + `fees`.`Fourth_Payment` + `fees`.`Fifth_Payment` + `fees`.`Sixth_Payment` + `fees`.`Seventh_Payment`
            ),
            `bed_withdraw`.Withdrawal_Fee
          ) AS `TOTAL`,
          (SELECT 
            IF(
                SUM(AmountofPayment) IS NULL,
                0.00,
                SUM(AmountofPayment)
            ) AS AmountofPayment 
          FROM
            `Basiced_Payments_Throuhput` 
          WHERE Reference_Number = `fees`.`Reference_Number` 
            AND itemPaid != "pExcess" 
            AND SchoolYear = `fees`.`SchoolYear` 
            AND valid) AS `PAID` 
        FROM
          `Basiced_EnrolledFees_Local` AS `fees` 
          LEFT JOIN Basiced_WithdrawInformation AS bed_withdraw 
            ON fees.`SchoolYear` = `bed_withdraw`.`SchoolYear` 
            AND `bed_withdraw`.`Student_Number` = fees.`Student_Number` 
        WHERE `fees`.`Reference_Number` = ' . $this->db->escape($this->student_data->get_reference_no()) . ' 
        GROUP BY schoolyear) a 
      GROUP BY schoolyear
        ';

        $query = $this->db->query($sql);

        return $query->result_array();
    }

    public function check_bed_shs_payment_approval()
    {
        $school_levels = array('BasicED', 'SeniorHIGH');
        $this->db->select('*');
        $this->db->from('approve_Payment');
        $this->db->where('Reference_Number', $this->student_data->get_reference_no());
        $this->db->where('Student_Number', $this->student_data->get_student_no());
        $this->db->where('SchoolYear', $this->student_data->get_school_year());
        $this->db->where_in('schoolLevel', $school_levels);
        $this->db->where('valid', 1);

        $query = $this->db->get();

        // reset query
        #$this->db->reset_query();

        return $query->result_array();
    }

    public function get_bed_enrolled_fees()
    {
        $this->db->select('*');
        $this->db->from('Basiced_EnrolledFees');
        $this->db->where('Reference_Number', $this->student_data->get_reference_no());
        $this->db->where('SchoolYear', $this->student_data->get_school_year());

        $query = $this->db->get();

        // reset query
        #$this->db->reset_query();

        return $query->result_array();
    }

    public function get_bed_enrolled_fees_main()
    {
        $this->db->select('*');
        $this->db->from('Basiced_EnrolledFees_Local');
        $this->db->where('Reference_Number', $this->student_data->get_reference_no());
        $this->db->where('SchoolYear', $this->student_data->get_school_year());

        $query = $this->db->get();

        // reset query
        #$this->db->reset_query();

        return $query->result_array();
    }

    public function insert_bed_enrolled_fees_main($enrolled_fees_id)
    {
        /* columns
        Reference_Number, Student_Number, GradeLevel, Track, Strand, SchoolYear, Payment_Scheme, Scholarship, Initial_Payment,
        First_Payment, Second_Payment, Third_Payment, Fourth_Payment, Fifth_Payment, Sixth_Payment, Seventh_Payment, Total, Installment_Total, Tuition, Registration, 
        Energy, Library, Medical, Guidance, Internet, Insurance, Publication, ClassPicture, Development, AntiBullying, Scouting, SpecialStudents, StudentHandbook, 
        TestMaterials, Cultural, ActivityMaterial, MovingUP, Wellness, TestPaper, DigitalCampus, StudentAthletesDevFund, FoundationWeekFee, AthleticFee, TurnItInFee,
        InternationalCertification, Immersion, CompLab, ScienceLab, AVLab, Multimedia, RoboticsFee, Other1, Other2, Other3, Other4, Other5 
        FROM basiced_enrolledfees
        */
        $this->db->trans_start();
        $sql = "
        INSERT INTO Basiced_EnrolledFees_Local (Reference_Number, Student_Number, GradeLevel, Track, Strand, SchoolYear, Payment_Scheme, Scholarship, Initial_Payment,
            First_Payment, Second_Payment, Third_Payment, Fourth_Payment, Fifth_Payment, Sixth_Payment, Seventh_Payment, Total, Installment_Total, Tuition, Registration, 
            Energy, Library, Medical, Guidance, Internet, Insurance, Publication, ClassPicture, Development, AntiBullying, Scouting, SpecialStudents, StudentHandbook, 
            TestMaterials, Cultural, ActivityMaterial, MovingUP, Wellness, TestPaper, DigitalCampus, StudentAthletesDevFund, FoundationWeekFee, AthleticFee, TurnItInFee,
            InternationalCertification, Immersion, LmsAndOtherOnlineResources, Journals, CompLab, ScienceLab, AVLab, Multimedia, RoboticsFee, Other1, Other2, Other3, Other4, Other5)
        SELECT Reference_Number, Student_Number, GradeLevel, Track, Strand, SchoolYear, Payment_Scheme, Scholarship, Initial_Payment,
            First_Payment, Second_Payment, Third_Payment, Fourth_Payment, Fifth_Payment, Sixth_Payment, Seventh_Payment, Total, Installment_Total, Tuition, Registration, 
            Energy, Library, Medical, Guidance, Internet, Insurance, Publication, ClassPicture, Development, AntiBullying, Scouting, SpecialStudents, StudentHandbook, 
            TestMaterials, Cultural, ActivityMaterial, MovingUP, Wellness, TestPaper, DigitalCampus, StudentAthletesDevFund, FoundationWeekFee, AthleticFee, TurnItInFee,
            InternationalCertification, Immersion, LmsAndOtherOnlineResources, Journals, CompLab, ScienceLab, AVLab, Multimedia, RoboticsFee, Other1, Other2, Other3, Other4, Other5 
        FROM Basiced_EnrolledFees
        WHERE id = " . $this->db->escape($enrolled_fees_id);
        $query = $this->db->query($sql);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            // generate an error... or use the log_message() function to log your error
            $message = "failed to Mirror bed enrolled fees";
        } else {
            $message = "Mirror bed enrollment fees sucessful";
        }


        // reset query
        #$this->db->reset_query();

        return $message;
    }

    public function get_bed_payment_list()
    {
        $this->db->select('id AS payment_id, AmountofPayment, OR_Number, Transaction_Type, Transaction_Item');
        $this->db->from('Basiced_Payments');
        $this->db->where('Reference_Number', $this->student_data->get_reference_no());
        $this->db->where('SchoolYear', $this->student_data->get_school_year());
        $this->db->where('OR_Number IS NOT NULL');
        $this->db->where('valid', 1);

        $query = $this->db->get();

        // reset query
        #$this->db->reset_query();

        return $query->result_array();
    }

    public function get_to_apply_bed_reservations()
    {
        $this->db->select('reservation.ID AS reservation_id, reservation.SchoolYear, reservation.Amount, reservation.Transaction_Item, 
        reservation.OR_Number, reservation.Payment_Type, reservation.Description, reservation.Append_Cashier, reservation.Append_Date, Users.User_FullName AS cashier_name');
        $this->db->from('Basiced_ReservationFee AS reservation');
        $this->db->join('Users', 'reservation.Append_Cashier = Users.User_ID', 'inner');
        $this->db->where('Reference_No', $this->student_data->get_reference_no());
        $this->db->where('SchoolYear', $this->student_data->get_school_year());
        $this->db->where('valid', 1);
        $this->db->where('Applied', 0);


        $query = $this->db->get();

        // reset query
        #$this->db->reset_query();

        return $query->result_array();
    }

    public function get_bed_payments()
    {
        $this->db->select('payment.id as payment_id, payment.AmountofPayment, payment.OR_Number, payment.Date, payment.Transaction_Type, payment.Transaction_Item, 
        payment.description, Users.User_FullName as cashier_name');
        $this->db->from('Basiced_Payments AS payment');
        $this->db->join('Users', 'payment.cashier = Users.User_ID', 'inner');
        $this->db->where('Reference_Number', $this->student_data->get_reference_no());
        $this->db->where('SchoolYear', $this->student_data->get_school_year());
        $this->db->where('valid', 1);


        $query = $this->db->get();

        // reset query
        #$this->db->reset_query();

        return $query->result_array();
    }

    public function get_bed_total_payment()
    {
        $this->db->select('SUM(AmountofPayment) AS total_payment');
        $this->db->from('Basiced_Payments');
        $this->db->where('Reference_Number', $this->student_data->get_reference_no());
        $this->db->where('SchoolYear', $this->student_data->get_school_year());
        $this->db->where('OR_Number IS NOT NULL');
        $this->db->where('valid', 1);

        $query = $this->db->get();

        // reset query
        #$this->db->reset_query();

        return $query->result_array();
    }

    public function bed_check_duplicate_or()
    {
        $this->db->select('ID');
        $this->db->from('Basiced_ReservationFee');
        $this->db->where('OR_Number', $this->student_data->get_or_no());

        $query = $this->db->get();

        // reset query
        #$this->db->reset_query();

        return $query->result_array();
    }

    public function bed_check_duplicate_or_enrollment()
    {
        $this->db->select('id');
        $this->db->from('Basiced_Payments');
        $this->db->where('OR_Number', $this->student_data->get_or_no());

        $query = $this->db->get();

        // reset query
        #$this->db->reset_query();

        return $query->result_array();
    }

    public function bed_insert_reservation($array_data)
    {
        $this->db->trans_start();
        $this->db->insert('Basiced_ReservationFee', $array_data);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            // generate an error... or use the log_message() function to log your error
            $message = "fail to insert BED Reservation data";
        } else {
            $message = "Insert Bed Reservation data Success";
        }


        // reset query
        #$this->db->reset_query();

        return $message;
    }

    public function get_bed_payment_throughput_list()
    {
        $this->db->select('SUM(AmountofPayment) AS AmountofPayment , itemPaid');
        $this->db->from('Basiced_Payments_Throuhput');
        $this->db->where('Reference_Number', $this->student_data->get_reference_no());
        $this->db->where('SchoolYear', $this->student_data->get_school_year());
        $this->db->group_by('itemPaid');
        $this->db->order_by('id', 'DESC');

        $query = $this->db->get();

        // reset query
        #$this->db->reset_query();

        return $query->result_array();
    }


    public function insert_bed_refund($array_data)
    {
        $this->db->trans_start();
        $this->db->insert('Basiced_Refund', $array_data);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            // generate an error... or use the log_message() function to log your error
            $message = "fail to insert Refund data";
        } else {
            $message = "Insert refund sucessful";
        }


        // reset query
        #$this->db->reset_query();

        return $message;
    }

    public function insert_bed_payments_throughput($array_data)
    {
        $this->db->trans_start();
        $this->db->insert_batch('Basiced_Payments_Throuhput', $array_data);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            // generate an error... or use the log_message() function to log your error
            $message = "fail to insert Fees Throughput";
        } else {
            $message = "Insert fees throughput sucessful";
        }

        // reset query
        #$this->db->reset_query();

        return $message;
    }

    public function insert_bed_student_payment($array_data)
    {
        $this->db->trans_start();
        $this->db->insert('Basiced_Payments', $array_data);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            // generate an error... or use the log_message() function to log your error
            $message = "fail to insert BED payment data";
        } else {
            $message = "Insert BED payment data sucessful";
        }


        // reset query
        #$this->db->reset_query();

        return $message;
    }

    public function update_bed_enrolled_fees()
    {
        $this->db->trans_start();
        $this->db->where('id', $this->bed_fees->get_enrolled_fees_id());
        $this->db->update('Basiced_EnrolledFees_Local', $this->bed_fees->get_array_update_fees_enrolled());
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            // generate an error... or use the log_message() function to log your error
            $message = "fail to Update BED Enrolled Fees";
        } else {
            $message = "BED Update Enrolled Fees sucessful";
        }


        // reset query
        #$this->db->reset_query();

        return $message;
    }

    public function check_to_apply_bed_reservations()
    {
        $this->db->select('ID AS reservation_id, SchoolYear, Amount, Transaction_Item, OR_Number, Payment_Type, Description, Append_Cashier, Append_Date');
        $this->db->from('Basiced_ReservationFee');
        $this->db->where('Reference_No', $this->student_data->get_reference_no());
        $this->db->where('SchoolYear', $this->student_data->get_school_year());
        $this->db->where('valid', 1);
        $this->db->where('Applied', 0);


        $query = $this->db->get();

        // reset query
        #$this->db->reset_query();

        return $query->result_array();
    }

    public function update_applied_bed_reservation($array_data, $reservation_id)
    {
        $this->db->trans_start();
        $this->db->where('ID', $reservation_id);
        $this->db->update('Basiced_ReservationFee', $array_data);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            // generate an error... or use the log_message() function to log your error
            $message = "fail to Update student BED Reservation(applied)";
        } else {
            $message = "Update BED Reservation sucessful(applied)";
        }


        // reset query
        #$this->db->reset_query();

        return $message;
    }

    public function get_shs_enrolled_fees()
    {
        $this->db->select('*');
        $this->db->from('Basiced_EnrolledFees');
        $this->db->where('Reference_Number', $this->student_data->get_reference_no());
        $this->db->where('GradeLevel', $this->student_data->get_grade_level());
        $this->db->where('SchoolYear', $this->student_data->get_school_year());
        $this->db->where('Track', $this->student_data->get_track());
        $this->db->where('Strand', $this->student_data->get_strand());

        $query = $this->db->get();

        // reset query
        #$this->db->reset_query();

        return $query->result_array();
    }

    public function get_shs_enrolled_fees_main()
    {
        $this->db->select('*');
        $this->db->from('Basiced_EnrolledFees_Local');
        $this->db->where('Reference_Number', $this->student_data->get_reference_no());
        $this->db->where('GradeLevel', $this->student_data->get_grade_level());
        $this->db->where('SchoolYear', $this->student_data->get_school_year());
        $this->db->where('Track', $this->student_data->get_track());
        $this->db->where('Strand', $this->student_data->get_strand());

        $query = $this->db->get();

        // reset query
        #$this->db->reset_query();

        return $query->result_array();
    }

    public function get_bed_fees_listing()
    {
        $this->db->select('*');
        $this->db->from('Basiced_FeesListing');
        $this->db->where('GradeLevel', $this->student_data->get_grade_level());
        $this->db->where('SchoolYear', $this->student_data->get_school_year());
        $query = $this->db->get();

        // reset query
        #$this->db->reset_query();

        return $query->result_array();
    }

    public function get_shs_fees_listing()
    {
        $this->db->select('*');
        $this->db->from('Basiced_FeesListing');
        $this->db->where('GradeLevel', $this->student_data->get_grade_level());
        $this->db->where('SchoolYear', $this->student_data->get_school_year());
        $this->db->where('Track', $this->student_data->get_track());
        $this->db->where('Strand', $this->student_data->get_strand());
        $query = $this->db->get();

        // reset query
        #$this->db->reset_query();

        return $query->result_array();
    }

    public function proof_of_payment($array)
    {
        $this->db->select('*');
        $this->db->from('requirements_log rl');
        $this->db->where('rl.requirements_date >=', $array['from']);
        $this->db->where('rl.requirements_date <=', $array['to']);
        $this->db->join('Student_Info si', 'rl.reference_no = si.Reference_Number', 'LEFT');
        $this->db->join('student_account sa', 'sa.reference_no = si.Reference_Number', 'LEFT');
        $query = $this->db->get();
        return $query->result_array();
    }
}
