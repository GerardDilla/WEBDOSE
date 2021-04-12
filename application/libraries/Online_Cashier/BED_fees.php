<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class bed_fees extends student_data {

    protected $array_fees;
    protected $array_fees_item;
    protected $array_item_key_names;
    protected $array_payments_throughput;
    protected $transaction_date;
    protected $cashier;
    protected $enrolled_fees_id;
    protected $array_paid_fees_item;
    protected $excess_payment;
    protected $array_update_fees_enrolled;
    protected $array_incomplete_payment_item_name;
    protected $payment_plan;
    protected $fees_listing;
    protected $interest;
    /*
        Set the following @parameters from parent class:

        protected $reference_no;
        protected $student_no;
        protected $school_year;
        protected $amount_paid;
        protected $or_no;
        protected $payment_type;
        protected $transaction_type;
        protected $description;
        protected $grade_level;

    */

    public function __construct($parameters)
    {
        $this->array_fees = $parameters['array_fees'][0];
        $this->enrolled_fees_id = $this->array_fees['id'];
        $this->array_fees_item = array();
        $this->set_array_item_key_names();
        $this->create_array_fees_item();
        $this->array_payments_throughput = array();
        $this->array_update_fees_enrolled = array();
        
        
    }

    public function set_array_fees(array $array_fees)
    {
        $this->array_fees = $array_fees;
        $this->array_fees_item = array();
        $this->array_payments_throughput = array();
        $this->array_update_fees_enrolled = array();
        $this->incomplete_payment_item_name = "";

        $this->set_array_item_key_names();
        $this->create_array_fees_item();
        return $this;
    }

    public function set_cashier($cashier)
    {
        $this->cashier = $cashier;
        return $this;
    }

    public function set_transaction_date($transaction_date)
    {
        $this->transaction_date = $transaction_date;
        return $this;
    }

    public function get_enrolled_fees_id()
    {
        return $this->enrolled_fees_id;
    }

    public function get_excess_payment()
    {
        return $this->excess_payment;
    }

    protected function set_array_item_key_names()
    {
        $this->array_item_key_names = array(
            "Registration", "Energy", "Library", "Medical", "Guidance", "Internet", "SchoolID", "Insurance", "Publication", 
            "ClassPicture", "Development", "AntiBullying", "Scouting", "SpecialStudents", "StudentHandbook", 
            "TestMaterials", "Cultural", "ActivityMaterial", "MovingUP", "Wellness", "TestPaper", "DigitalCampus", 
            "StudentAthletesDevFund", "FoundationWeekFee", "AthleticFee", "TurnItInFee","InternationalCertification", 
            "Immersion", "LmsAndOtherOnlineResources", "Journals", "AptitudeTest", "Sanitation", "CompLab", "ScienceLab", 
            "AVLab", "Multimedia", "RoboticsFee", "Other1", "Other2", "Other3", "Other4", "Other5", "Tuition" 
        );
        return $this;
    }

    private function create_array_fees_item()
    {
        foreach ($this->array_item_key_names as $name) {
            # code...
            if ($this->array_fees[$name] > 0) {
                # code...
                $array_temp = array(
                    'fee_name' => $name,
                    'fee_amount' => $this->array_fees[$name]
                );
                $this->array_fees_item[] = $array_temp;
            }
        }
        return $this;
    }

    public function set_array_paid_fees_item($array_paid_fees_item)
    {
        $this->array_paid_fees_item = $array_paid_fees_item;
        return $this;
    }


    private function set_throughput_process()
    {
        $this->check_incomplete_fee_item_payment();
        $this->set_payments_throughput();
        $this->set_update_enrolled_fees();
        return $this;
    }

    public function get_array_payments_throughput()
    {
        $this->set_throughput_process();
        return $this->array_payments_throughput;
    }

    private function check_incomplete_fee_item_payment()
    {
        if (!$this->array_paid_fees_item) {
            # code...
            return $this;
        }

        $this->array_incomplete_payment_item_name = array();

        #search array_fees_item
        $fee = array_column($this->array_fees_item, 'fee_name');

        foreach ($this->array_paid_fees_item as $key => $fee_item) {
            # code...
            $fee_amount = 0;
            $fee_key = array_search(ltrim($fee_item['itemPaid'], 'p'), $fee);

            if ($this->array_fees_item[$fee_key]['fee_amount'] === $fee_item['AmountofPayment']) {
                # remove row in fees item because the fee item is already paid. 
                unset($this->array_fees_item[$fee_key]);     
                
            }
            else {
                # code...
                $fee_amount = number_format($this->array_fees_item[$fee_key]['fee_amount'] - $fee_item['AmountofPayment'], 2, '.', '');

                $this->update_array_fees_item($fee_key, $fee_amount);

                $this->array_incomplete_payment_item_name[] = $this->array_fees_item[$fee_key]['fee_name'];

                
                
            }

            
        }


        return $this;

    }

    private function update_array_fees_item($fee_key, $fee_amount)
    {
        $this->array_fees_item[$fee_key]['fee_amount'] = $fee_amount;
        return $this;
    }

    


    private function set_payments_throughput()
    {
        $amount_paid = $this->amount_paid;
        //print "enter set payments";
        //print_r($this->array_fees_item);
        foreach ($this->array_fees_item as $key => $fee) {
            //print "<br>";
            //print "loop".$key;
            if ($amount_paid > 0) {
                
                # set array of payment throughput
                if ($amount_paid >= $fee['fee_amount']) {
                    # code...
                    $this->set_array_payments_throughput($fee['fee_amount'], $fee['fee_name']);
                }
                else {
                    # code...
                    $this->set_array_payments_throughput($amount_paid, $fee['fee_name']);
                }
            }
            else {
                break;
            }
            //print_r($this->array_payments_throughput[$key]);
            //print "<br>";

            $amount_paid = number_format($amount_paid - $fee['fee_amount'], 2, '.', '');
            //print "computation: ".$amount_paid.' - '.$fee['fee_amount'];
            //print "<br>";
            //print "remaining payment".$amount_paid;
            //print "<br>";
        }
        #check for excess payment
        if ($amount_paid > 0) {
            # code...
            $this->excess_payment = $amount_paid;
            $this->set_array_payments_throughput($amount_paid, "Excess");
        }
        return $this;
    }

    private function set_array_payments_throughput($payment, $fee_item)
    {
       $this->array_payments_throughput[] = array(
           'Reference_Number' => $this->reference_no,
           'Student_Number' => $this->student_no,
           'AmountofPayment' => $payment,
           'OR_Number' => $this->or_no,
           'itemPaid' => 'p'.$fee_item,
           'Transaction_Item' => $this->transaction_type,
           'transDate' => $this->transaction_date,
           'Transaction_Type' => $this->payment_type,
           'description' => $this->description,
           'SchoolYear' => $this->school_year,
           'cashier' => $this->cashier,
           'valid' => 1,
           'web_dose_module' => 1
       );
       return $this;
        
    }

    private function set_update_enrolled_fees()
    {
        //$this->array_update_fees_enrolled = array();
        $payment_throughput = $this->array_payments_throughput;

       

        if ($this->array_incomplete_payment_item_name) {
            
            foreach ($payment_throughput as $key => $throughput) {
                # code...
                $amount = number_format(($throughput['AmountofPayment'] + $this->array_fees[$throughput['itemPaid']]), 2, '.', '');

                $this->array_update_fees_enrolled[$throughput['itemPaid']] = $amount;
                unset($payment_throughput[$key]);
            }
            
            
        }

        
        foreach ($payment_throughput as $key => $payment) {
            # code...
            $this->array_update_fees_enrolled[$payment['itemPaid']] = $payment['AmountofPayment'];
        }

        #remove excess in array
        if ($this->array_update_fees_enrolled['pExcess']) {
            # code...
            unset($this->array_update_fees_enrolled['pExcess']);
        }

        #upate web_dose_module
        $this->array_update_fees_enrolled['web_dose_module'] = 1;

        #update student number in enrolled fees local if student number is not available 
        if ($this->array_fees['Student_Number'] == 0) {
            # code...
            $this->array_update_fees_enrolled['Student_Number'] = $this->student_no;
        }

        return $this;
    }

    public function get_array_update_fees_enrolled()
    {
        return $this->array_update_fees_enrolled;
    }

    public function get_array_fees_item()
    {
        return $this->array_fees_item;
    }

    public function set_payment_plan()
    {
        $this->payment_plan = $this->array_fees['Payment_Scheme'];
        $this->set_payment_plan_interest();
        $this->set_fees_item_computation();
        $this->set_computed_fees_item_amount();
        return $this;
    }

    public function set_fees_listing($fees_listing)
    {
        $this->fees_listing = $fees_listing;
        return $this;
    }

    public function set_payment_plan_interest()
    {
        if ($this->payment_plan === "SEMI-ANNUAL") {
            # code...
            $this->interest = 1.04;
        }
        elseif ($this->payment_plan === "QUARTERLY") {
            # code...
            $this->interest = 1.08;
        }
        elseif ($this->payment_plan === "QUARTERLY-FLEXI") {
            # code...
            $this->interest = 1.08;
        }
        elseif ($this->payment_plan === "QUARTERLY-BUDDY") {
            # code...
            $this->interest = 1.08;
        }
        elseif ($this->payment_plan === "MONTHLY") {
            # code...
            $this->interest = 1.12;
        }
        elseif ($this->payment_plan === "MONTHLY-FLEXI") {
            # code...
            $this->interest = 1.12;
        }
        elseif ($this->payment_plan === "MONTHLY-PROMO") {
            # code...
            $this->interest = 1.12;
        }
        else{
            $this->interest = 1;
        }
        return $this;
    }

    private function set_fees_item_computation()
    {
        foreach ($this->array_fees_item as $key => $fee) {
            # code...
            $this->array_fees_item[$key]['fee_amount'] = number_format($fee['fee_amount'] * $this->interest, 2, '.', '');
        }
        return $this;
    }

    private function set_computed_fees_item_amount()
    {
        foreach ($this->array_fees_item as $key => $fee) {
            # code...
            $this->array_update_fees_enrolled[$fee['fee_name']] = $fee['fee_amount'];
        }
        return $this;
    }

    


    

    
}