<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\HeaderFooterDrawing;
use PhpOffice\PhpSpreadsheet\RichText\RichText;

class StudentRecords extends MY_Controller
{

    protected $date_time;
    protected $array_logs;
    protected $form_approved_by;
    protected $form_verified_by;
    protected $form_prepared_by;

    function __construct()
    {
        parent::__construct();
        $this->load->library('set_views');
        $this->load->library('email');
        $this->load->library('session');
        $this->load->helper(array('form', 'url', 'date'));
        $this->load->model('AcademicRecords_Model/Student_Model');
        $this->load->model('AcademicRecords_Model/Grades_Model');
        $this->load->model('AcademicRecords_Model/Subjects_Model');
        $this->load->model('AcademicRecords_Model/Attendance_Model');

        //check if user is logged on
        $this->load->library('set_custom_session');
        $this->admin_data = $this->set_custom_session->admin_session();

        //user accessibility
        $this->load->library('User_accessibility');
        $this->user_accessibility->module_advising_access($this->admin_data['userid']);

        //set date
        $datestring = "%Y-%m-%d %h:%i";
        $time = time();
        $this->date_time = mdate($datestring, $time);

        //set logs
        $this->array_logs = array(
            'user_id' => $this->admin_data['userid'],
            'module' => 'Advising',
            'transaction_date' => $this->date_time,
        );

        // $this->load->library("Excel");

        //get current date time
        //$date_time = "%Y-%m-%d %H:%i:%s";
        $footer_datestring = "%d-%M-%y";
        $datestring = "%M %d, %Y";


        $this->date_now = mdate($datestring, $time);
        $this->date_footer = mdate($footer_datestring, $time);

        $this->form_approved_by = "SUE S. KALINAWAN, RN MAN";
        $this->form_prepared_by = strtoupper($this->admin_data['fullname']);
        $this->form_verified_by = "";
    }

    public function index()
    {
        $this->render($this->set_views->basiced_form137());
    }

    public function juniorhigh_permanent_academic_record()
    {
        if ($this->input->post('studentNumber') && is_numeric($this->input->post('studentNumber'))) {
            # code...
            $student_info = $this->Student_Model->get_student_details_by_student_no($this->input->post('studentNumber'));
        } else {
            # code...
            $output["checker"] = 0;
            $output["message"] = "Wrong format for student number";
            echo json_encode($output);
            return;
        }

        if (!$student_info) {
            # code...
            # code...
            $output["checker"] = 0;
            $output["message"] = "Student not found";
            echo json_encode($output);
            return;
        }

        //remarks from post
        $remarks = 'remarks sample';

        //set grade level list for elementary
        $array_grade_level = array('G7', 'G8', 'G9', 'G10');

        //set grade level names for excel file
        $array_grade_level_names = array('Grade 7', 'Grade 8', 'Grade 9', 'Grade 10', 'Grade 11');

        //get student enrolled grades levels
        $array_student_enrolled_levels = $this->Student_Model->get_student_enrolled_levels($student_info[0]['Reference_Number']);
        //print_r($array_student_enrolled_levels);


        //set display of student grades
        $this->data['array_output'] = array();


        foreach ($array_grade_level as $grade_level_key => $grade_level) {
            # code...
            $array_subject_grades = array();
            if ($this->in_array_r($grade_level, $array_student_enrolled_levels, 'GradeLevel')) {
                # code...
                //set subject grades
                //$array_subject_grades = "";

                //get key of array_student_enrolled_levels
                $student_enrolled_levels_key = array_search($grade_level, array_column($array_student_enrolled_levels, 'GradeLevel'));
                //print 'enrolled levels: '.$student_enrolled_levels_key;

                //get grade level subject list and position
                $array_subjects_list = $this->Subjects_Model->get_form137_subject_arrangement($grade_level, $array_student_enrolled_levels[$student_enrolled_levels_key]['SchoolYear']);
                //print_r($array_subjects_list);
                foreach ($array_subjects_list as $key => $subject) {

                    //check if the row is not a parent subject 
                    if ($subject['subjects_id'] != -1) {
                        # code...


                        //get subject quarter grades
                        $array_data = array(
                            'subject_id' => $subject['subjects_id'],
                            'reference_no' => $student_info[0]['Reference_Number'],
                            'school_year' =>  $array_student_enrolled_levels[$student_enrolled_levels_key]['SchoolYear']
                        );
                        $array_grades = $this->Grades_Model->get_basiced_subject_grade($array_data);
                        //print_r($array_grades);
                        //compute average of subjects
                        $subject_grade = $this->basiced_subject_grade_average($array_grades);

                        if ($subject_grade >= 75) {
                            # code...
                            $remark = "Promoted";
                        } else {
                            $remark = "Retain";
                        }

                        //get year level total school days
                        $total_school_days = $this->Attendance_Model->get_bed_total_school_days($array_data['school_year']);

                        //get student total UA
                        $student_total_ua = $this->Attendance_Model->get_student_total_ua($array_data['reference_no'], $array_data['school_year']);

                        $student_total_attendance = $total_school_days[0]['total_school_days'] - $student_total_ua[0]['total_ua'];

                        $array_subject_grades[] = array(
                            'subject_id' => $subject['subjects_id'],
                            'subject_title' => $subject['subject_title'],
                            'subject_grade' => $subject_grade,
                            'remark' => $remark,
                            'parent_subject_id' => $subject['parent_subject_id'],
                            'total_school_days' => $total_school_days[0]['total_school_days'],
                            'total_attendance' => $student_total_attendance,
                            'school_name' => 'ST. DOMINIC COLLEGE BASIC EDUCATION',
                            'school_year' => $array_data['school_year']
                        );
                    } else {
                        $array_subject_grades[] = array(
                            'subject_title' => $subject['parent_subject_name']
                        );
                    }

                    //print_r($array_subject_grades);
                } // end of foreach subject list in a grade level

                $array_subjects_remove = array();
                $remove_subject_tle = array();
                $remove_subject_elective = array();

                #combine tle subjects
                #get subjects to combine
                $array_subject_search_result = $this->basiced_get_subject('TLE', $array_subject_grades);
                if ($array_subject_search_result) {

                    # code...
                    #combine subjects
                    $tle = $this->basiced_combine_subject_grades('TLE', $array_subject_grades, $array_subject_search_result);
                    #delete subjects
                    //$array_subject_grades = $this->remove_subjects($array_subject_grades, $array_subject_search_result);
                    #add elective data to subjects
                    $array_subject_grades[] = $tle;
                    //$array_subjects_remove = array_merge(array_keys($array_subjects_remove) , array_keys($array_subject_search_result));
                    $remove_subject_tle = $array_subject_search_result;
                    //print_r($elective);
                }

                #combine elective subject
                #get subjects to combine
                $array_subject_search_result = $this->basiced_get_subject('ELECTIVE', $array_subject_grades);
                if ($array_subject_search_result) {
                    # code...

                    #combine subjects
                    $elective = $this->basiced_combine_subject_grades('ELECTIVE', $array_subject_grades, $array_subject_search_result);
                    #delete subjects
                    //$array_subject_grades = $this->remove_subjects($array_subject_grades, $array_subject_search_result);
                    #add elective data to subjects
                    $array_subject_grades[] = $elective;
                    //$array_subjects_remove = array_merge(array_keys($array_subjects_remove) , array_keys($array_subject_search_result));
                    //print_r($elective);
                    $remove_subject_elective = $array_subject_search_result;
                }

                $array_subjects_remove = array_merge(array_keys($remove_subject_tle), array_keys($remove_subject_elective));


                if ($array_subjects_remove) {
                    # code...

                    $array_subject_grades = $this->remove_subjects($array_subject_grades, $array_subjects_remove);
                }


                $this->data['array_output'][] = $array_subject_grades;

                //print_r($array_subject_grades);

            } else {
                $this->data['array_output'][] = 0;
            }
        }
        //print_r($this->data['array_output']);
        //echo "<br/>";
        //echo is_array($this->data['array_output'][0]) ? 'yes' : 'no';

        #get gen. average for K2

        if ($this->in_array_r('G6', $array_student_enrolled_levels, 'GradeLevel')) {
            #get key of array_student_enrolled_levels
            $student_enrolled_levels_key = array_search('G6', array_column($array_student_enrolled_levels, 'GradeLevel'));
            $array_data = array(
                'reference_no' => $student_info[0]['Reference_Number'],
                'school_year' =>  $array_student_enrolled_levels[$student_enrolled_levels_key]['SchoolYear']
            );
            $array_grades = $this->Grades_Model->get_baisced_total_grades($array_data);

            $grades_total = 0;

            foreach ($array_grades as $key => $grade) {
                # code...
                $grades_total += $grade['finGrade'];
            }
            $grades_count = count($array_grades);

            $completed_course_gen_average = round(($grades_total / $grades_count));
        } else {
            $completed_course_gen_average = "N/A";
            $array_data['school_year'] = "N/A";
        }


        $array_info = array(
            'educational_stage' => 'junior_high',
            'course_completed' => 'ELEMENTARY COURSE COMPLETED',
            'course_completed_school' => $this->input->post('courseCompleted'),
            'course_completed_gen_average' => $completed_course_gen_average,
            'course_completed_sy' => $array_data['school_year'],
            'grade_table_row_height' => 10.5,
            'grade_table_font_size' => 8,
            'fname' => $student_info[0]['First_Name'],
            'mname' => $student_info[0]['Middle_Name'],
            'lname' => $student_info[0]['Last_Name'],
            'gender' => $student_info[0]['Gender'],
            'lrn' => $student_info[0]['LRN'],
            'birth_date' => $student_info[0]['Birth_Date'],
            'address' => $student_info[0]['Address_No'] . ', ' . $student_info[0]['Address_Street'] . ', ' . $student_info[0]['Subdivision'] . ', '
                . $student_info[0]['Barangay'] . ', ' . $student_info[0]['City'] . ', ' . $student_info[0]['Province'],
            'remarks' => $this->input->post('recordRemarks'),
            'released_by' => $this->input->post('recordReleased'),
            'reference_no' => $this->input->post('recordReferenceNo'),
            'transfer_admission' => $this->input->post('transferAdmission'),
            'header' => "JUNIOR HIGH SCHOOL (SF10-JHS)"

        );
        //address 
        $this->export_excel($this->data['array_output'], $array_grade_level_names, $array_info);
        //print_r($this->data['array_output']);
        //$this->render($this->set_views->basiced_form137());


    }

    public function elementary_permanent_academic_record()
    {
        if ($this->input->post('studentNumber') && is_numeric($this->input->post('studentNumber'))) {
            # code...
            $student_info = $this->Student_Model->get_student_details_by_student_no($this->input->post('studentNumber'));
        } else {
            # code...
            $output["checker"] = 0;
            $output["message"] = "Wrong format for student number";
            echo json_encode($output);
            return;
        }

        if (!$student_info) {
            # code...
            # code...
            $output["checker"] = 0;
            $output["message"] = "Student not found";
            echo json_encode($output);
            return;
        }

        //remarks from post
        $remarks = 'remarks sample';

        //set grade level list for elementary
        $array_grade_level = array('G1', 'G2', 'G3', 'G4', 'G5', 'G6');

        //set grade level names for excel file
        $array_grade_level_names = array('Grade 1', 'Grade 2', 'Grade 3', 'Grade 4', 'Grade 5', 'Grade 6', 'Grade 7');

        //get student enrolled grades levels
        $array_student_enrolled_levels = $this->Student_Model->get_student_enrolled_levels($student_info[0]['Reference_Number']);
        //print_r($array_student_enrolled_levels);


        //set display of student grades
        $this->data['array_output'] = array();
        $array_subject_grades = array();

        foreach ($array_grade_level as $grade_level_key => $grade_level) {
            # code...
            $array_subject_grades = array();
            if ($this->in_array_r($grade_level, $array_student_enrolled_levels, 'GradeLevel')) {
                # code...
                //set subject grades
                //$array_subject_grades = "";

                //get key of array_student_enrolled_levels
                $student_enrolled_levels_key = array_search($grade_level, array_column($array_student_enrolled_levels, 'GradeLevel'));
                //print 'enrolled levels: '.$student_enrolled_levels_key;

                //get grade level subject list and position
                $array_subjects_list = $this->Subjects_Model->get_form137_subject_arrangement($grade_level, $array_student_enrolled_levels[$student_enrolled_levels_key]['SchoolYear']);
                //print_r($array_subjects_list);
                foreach ($array_subjects_list as $key => $subject) {

                    //check if the row is not a parent subject 
                    if ($subject['subjects_id'] != -1) {
                        # code...


                        //get subject quarter grades
                        $array_data = array(
                            'subject_id' => $subject['subjects_id'],
                            'reference_no' => $student_info[0]['Reference_Number'],
                            'school_year' =>  $array_student_enrolled_levels[$student_enrolled_levels_key]['SchoolYear']
                        );
                        $array_grades = $this->Grades_Model->get_basiced_subject_grade($array_data);
                        //print_r($array_grades);
                        //compute average of subjects
                        $subject_grade = $this->basiced_subject_grade_average($array_grades);

                        if ($subject_grade >= 75) {
                            # code...
                            $remark = "Promoted";
                        } else {
                            $remark = "Retain";
                        }

                        //get year level total school days
                        $total_school_days = $this->Attendance_Model->get_bed_total_school_days($array_data['school_year']);

                        //get student total UA
                        $student_total_ua = $this->Attendance_Model->get_student_total_ua($array_data['reference_no'], $array_data['school_year']);

                        $student_total_attendance = $total_school_days[0]['total_school_days'] - $student_total_ua[0]['total_ua'];


                        $array_subject_grades[] = array(
                            'subject_id' => $subject['subjects_id'],
                            'subject_title' => $subject['subject_title'],
                            'subject_grade' => $subject_grade,
                            'remark' => $remark,
                            'parent_subject_id' => $subject['parent_subject_id'],
                            'total_school_days' => $total_school_days[0]['total_school_days'],
                            'total_attendance' => $student_total_attendance,
                            'school_name' => 'ST. DOMINIC COLLEGE BASIC EDUCATION',
                            'school_year' => $array_data['school_year']
                        );
                    } else {
                        $array_subject_grades[] = array(
                            'subject_title' => $subject['parent_subject_name']
                        );
                    }

                    //print_r($array_subject_grades);
                } // end of foreach subject list in a grade level

                $array_subjects_remove = array();
                $remove_subject_tle = array();
                $remove_subject_elective = array();

                #combine tle subjects
                #get subjects to combine
                $array_subject_search_result = $this->basiced_get_subject('TLE', $array_subject_grades);
                if ($array_subject_search_result) {

                    # code...
                    #combine subjects
                    $tle = $this->basiced_combine_subject_grades('TLE', $array_subject_grades, $array_subject_search_result);
                    #delete subjects
                    //$array_subject_grades = $this->remove_subjects($array_subject_grades, $array_subject_search_result);
                    #add elective data to subjects
                    $array_subject_grades[] = $tle;
                    //$array_subjects_remove = array_merge(array_keys($array_subjects_remove) , array_keys($array_subject_search_result));
                    $remove_subject_tle = $array_subject_search_result;
                    //print_r($elective);
                }

                #combine elective subject
                #get subjects to combine
                $array_subject_search_result = $this->basiced_get_subject('ELECTIVE', $array_subject_grades);
                if ($array_subject_search_result) {
                    # code...

                    #combine subjects
                    $elective = $this->basiced_combine_subject_grades('ELECTIVE', $array_subject_grades, $array_subject_search_result);
                    #delete subjects
                    //$array_subject_grades = $this->remove_subjects($array_subject_grades, $array_subject_search_result);
                    #add elective data to subjects
                    $array_subject_grades[] = $elective;
                    //$array_subjects_remove = array_merge(array_keys($array_subjects_remove) , array_keys($array_subject_search_result));
                    //print_r($elective);
                    $remove_subject_elective = $array_subject_search_result;
                }

                $array_subjects_remove = array_merge(array_keys($remove_subject_tle), array_keys($remove_subject_elective));


                if ($array_subjects_remove) {
                    # code...

                    $array_subject_grades = $this->remove_subjects($array_subject_grades, $array_subjects_remove);
                }



                $this->data['array_output'][] = $array_subject_grades;

                //print_r($array_subject_grades);

            } else {
                $this->data['array_output'][] = 0;
            }
        }
        //print_r($this->data['array_output']);
        //echo "<br/>";
        //echo is_array($this->data['array_output'][0]) ? 'yes' : 'no';

        #get gen. average for K2

        if ($this->in_array_r('K2', $array_student_enrolled_levels, 'GradeLevel')) {
            #get key of array_student_enrolled_levels
            $student_enrolled_levels_key = array_search('G6', array_column($array_student_enrolled_levels, 'GradeLevel'));
            $array_data = array(
                'reference_no' => $student_info[0]['Reference_Number'],
                'school_year' =>  $array_student_enrolled_levels[$student_enrolled_levels_key]['SchoolYear']
            );
            $array_grades = $this->Grades_Model->get_baisced_total_grades($array_data);

            $grades_total = 0;

            foreach ($array_grades as $key => $grade) {
                # code...
                $grades_total += $grade['finGrade'];
            }
            $grades_count = count($array_grades);

            $completed_course_gen_average = round(($grades_total / $grades_count));
        } else {
            $completed_course_gen_average = "N/A";
            $array_data['school_year'] = "N/A";
        }


        $array_info = array(
            'educational_stage' => 'elementary',
            'course_completed' => 'KINDERGARTEN COMPLETED',
            'course_completed_school' => $this->input->post('courseCompleted'),
            'course_completed_gen_average' => $completed_course_gen_average,
            'course_completed_sy' => $array_data['school_year'],
            'grade_table_row_height' => 10.5,
            'grade_table_font_size' => 8,
            'fname' => $student_info[0]['First_Name'],
            'mname' => $student_info[0]['Middle_Name'],
            'lname' => $student_info[0]['Last_Name'],
            'gender' => $student_info[0]['Gender'],
            'lrn' => $student_info[0]['LRN'],
            'birth_date' => $student_info[0]['Birth_Date'],
            'address' => $student_info[0]['Address_No'] . ', ' . $student_info[0]['Address_Street'] . ', ' . $student_info[0]['Subdivision'] . ', '
                . $student_info[0]['Barangay'] . ', ' . $student_info[0]['City'] . ', ' . $student_info[0]['Province'],
            'remarks' => $this->input->post('recordRemarks'),
            'released_by' => $this->input->post('recordReleased'),
            'reference_no' => $this->input->post('recordReferenceNo'),
            'transfer_admission' => $this->input->post('transferAdmission'),
            'header' => "ELEMENTARY SCHOOL (SF10-ES)"

        );
        //address 

        $this->export_excel($this->data['array_output'], $array_grade_level_names, $array_info);

        //$this->render($this->set_views->basiced_form137());

    }

    public function shs_student_form()
    {
        $this->render($this->set_views->shs_form137());
    }

    public function shs_permanent_academic_record()
    {
        #check if the student is in shs
        if (!$this->input->post('studentNumber') || !is_numeric($this->input->post('studentNumber'))) {
            # code...
            redirect('StudentRecords/shs_student_form');
        }

        $student_info = $this->Student_Model->get_student_details_by_student_no($this->input->post('studentNumber'));

        $grade_level = $student_info[0]['Gradelevel'];
        if (($grade_level === "G11") || ($grade_level === "G12")) {
            # code...
            #set parameters to call class student and shs_form
            $array_params = array(
                'student_info' => $student_info[0],
                'student_type' => "SHS"
            );
            $this->load->library('student', $array_params);

            $this->load->library('Student_Records/shs_form', $array_params);
        } else {
            redirect('StudentRecords/shs_student_form');
        }

        # set student number. change later
        //$student_info = $this->Student_Model->get_student_details_by_student_no(201800124);


        #add strand title
        $strand_title = $this->Student_Model->get_strand_title($this->student->get_strand());
        $this->shs_form->set_strand_title($strand_title[0]['Strand_Title']);

        #add elementary school info
        //$elementary_school_name = $this->student->get_bed_elementary_education();
        //$elementary_school_graduated = $this->student->get_bed_elementary_graduated();
        $elementary_school_name = $this->input->post('elementarySchoolName');
        $elementary_school_graduated = $this->input->post('elementaryYear');
        $elementary_gen_average = $this->input->post('elementaryGeneralAvergae');

        $this->shs_form->set_elementary_school_info($elementary_school_name, $elementary_school_graduated, $elementary_gen_average);

        #add secondary school info
        //$secondary_school_name = $this->student->get_bed_secondary_education();
        //$secondary_school_graduated = $this->student->get_bed_secondary_graduated();
        $secondary_school_name = $this->input->post('secondarySchoolName');
        $secondary_school_graduated = $this->input->post('secondaryYear');
        $secondary_gen_average = $this->input->post('secondaryGeneralAvergae');
        $this->shs_form->set_secondary_school_info($secondary_school_name, $secondary_school_graduated, $secondary_gen_average);
        $this->shs_form->set_admission_date($this->input->post('admissionDate'));



        $this->shs_form->set_approved_by($this->form_approved_by);
        $this->shs_form->set_prepared_by($this->form_prepared_by);
        $this->shs_form->set_verified_by($this->form_verified_by);
        //$this->shs_form->set_released_by($this->input->post('recordReleased'));
        $this->shs_form->set_released_by("");
        $this->shs_form->set_form_remarks($this->input->post('recordRemarks'));
        $this->shs_form->set_record_reference_no($this->input->post('recordReferenceNo'));

        //$array_entrance_data = array('PSA BIRTH CERTIFICATE', 'FORM 137-A', 'FORM 138', 'GMC', 'PICTURE');
        $this->shs_form->set_entrance_data($this->input->post('entranceData'));

        $this->shs_form->set_birth_date($this->input->post('birthDate'));

        #check if the user clicked "is the student a graduate"
        if ($this->input->post('graduationDate')) {
            # code...
            $this->shs_form->set_shs_year_graduated($this->input->post('graduationDate'));
            $this->shs_form->set_graduation_status(1);

            #get track title
            $track_title = $this->Student_Model->get_track_title($this->student->get_track_id());
            $this->shs_form->set_track_title($track_title[0]['Track']);
        } else {
            $this->shs_form->set_shs_year_graduated('Undergraduate');
        }

        $this->shs_form->export();

        //$this->shs_form->reader();
    }

    public function shs_read_format()
    {
        # set student number. change later
        $student_info = $this->Student_Model->get_student_details_by_student_no(201800124);

        #set parameters to call class student and shs_form
        $array_params = array(
            'student_info' => $student_info[0],
            'student_type' => "SHS"
        );
        $this->load->library('student', $array_params);

        $this->load->library('Student_Records/shs_form', $array_params);
        $this->shs_form->set_registrar_head('ROMEO EMMANUEL B. TAGBO, MAP');
        //$this->shs_form->export();

        $this->shs_form->reader();
    }

    public function export_excel($array_data = "", $array_grade_level_names = "", $array_info)
    {

        if (!$array_data || !$array_grade_level_names) {
            # code...
            redirect();
        }

        if ($array_info['educational_stage'] == 'junior_high') {
            # code...
            //for first col year level table
            $array_first_col_grades = array(
                'col_1' => 'A',
                'col_2' => 'B',
                'col_3' => 'C',
                'col_4' => 'D',
            );
            $center_col_grades = 'E';
            $array_second_col_grades = array(
                'col_1' => 'F',
                'col_2' => 'G',
                'col_3' => 'H',
                'col_4' => 'I',
            );

            #set breakline for header
            $header_break_line = "\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n";
        } elseif ($array_info['educational_stage'] == 'elementary') {
            # code...
            $array_first_col_grades = array(
                'col_1' => 'B',
                'col_2' => 'C',
                'col_3' => 'D',
                'col_4' => 'E',
            );
            $center_col_grades = 'F';
            $array_second_col_grades = array(
                'col_1' => 'G',
                'col_2' => 'H',
                'col_3' => 'I',
                'col_4' => 'J',
            );
            #set breakline for header
            $header_break_line = "\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n";
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $cell_start = 1;

        $sheet->mergeCells($array_first_col_grades['col_4'] . $cell_start . ':' . $array_second_col_grades['col_1'] . $cell_start);
        $sheet->setCellValue($array_first_col_grades['col_4'] . $cell_start, 'REPUBLIC OF THE PHILIPPINES');
        $sheet->setCellValue($array_second_col_grades['col_4'] . $cell_start, 'Page 1 of 1');
        $cell_start++;
        $sheet->mergeCells($array_first_col_grades['col_4'] . $cell_start . ':' . $array_second_col_grades['col_1'] . $cell_start);
        $sheet->setCellValue($array_first_col_grades['col_4'] . $cell_start, 'DEPARTMENT OF EDUCATION');
        $cell_start++;
        $sheet->mergeCells($array_first_col_grades['col_4'] . $cell_start . ':' . $array_second_col_grades['col_1'] . $cell_start);
        $sheet->setCellValue($array_first_col_grades['col_4'] . $cell_start, 'REGION IV-A, CALABARZON');
        $cell_start++;
        $sheet->mergeCells($array_first_col_grades['col_4'] . $cell_start . ':' . $array_second_col_grades['col_1'] . $cell_start);
        $sheet->setCellValue($array_first_col_grades['col_4'] . $cell_start, 'DIVISION OF BACOOR CITY');

        //megered cells for left header logo
        $sheet->mergeCells($array_first_col_grades['col_2'] . ($cell_start - 3) . ':' . $array_first_col_grades['col_3'] . ($cell_start - 1));
        //megered cells for right header logo
        $sheet->mergeCells($array_second_col_grades['col_2'] . ($cell_start - 3) . ':' . $array_second_col_grades['col_3'] . ($cell_start - 1));
        //mergred cells for center header logo
        $sheet->mergeCells($array_first_col_grades['col_2'] . ($cell_start + 1) . ':' . $array_second_col_grades['col_3'] . ($cell_start + 5));
        $cell_start += 6;
        $sheet->mergeCells($array_first_col_grades['col_1'] . $cell_start . ':' . $array_second_col_grades['col_4'] . $cell_start);
        $sheet->setCellValue($array_first_col_grades['col_1'] . $cell_start, 'OFFICE OF THE REGISTRAR');
        $cell_start++;
        $sheet->mergeCells($array_first_col_grades['col_1'] . $cell_start . ':' . $array_second_col_grades['col_4'] . $cell_start);
        $sheet->setCellValue($array_first_col_grades['col_1'] . $cell_start, 'LEARNER\'S PERMANENT ACADEMIC RECORD ' . $array_info['header']);
        #cell format
        //$spreadsheet->getActiveSheet()->getStyle()->getFont($array_first_col_grades['col_1'].$cell_start)->setSize(11.5);
        /*
        $cell_start++;
        $sheet->mergeCells($array_first_col_grades['col_1'].$cell_start.':'.$array_second_col_grades['col_4'].$cell_start);
        $sheet->setCellValue($array_first_col_grades['col_1'].$cell_start, $array_info['header']);
        */

        //add logo
        $drawing = new Drawing();
        $drawing->setName('Logo1');
        $drawing->setDescription('Logo1');
        $drawing->setPath('./img/StudentRecords/logo1.png');
        $drawing->setCoordinates($array_first_col_grades['col_2'] . '1');
        $drawing->setWorksheet($spreadsheet->getActiveSheet());

        $drawing = new Drawing();
        $drawing->setName('Logo2');
        $drawing->setDescription('Logo2');
        $drawing->setPath('./img/StudentRecords/logo2.png');
        $drawing->setCoordinates($array_second_col_grades['col_2'] . '1');
        $drawing->setWorksheet($spreadsheet->getActiveSheet());

        $drawing = new Drawing();
        $drawing->setName('Logo3');
        $drawing->setDescription('Logo3');
        $drawing->setPath('./img/StudentRecords/logo3.png');
        $drawing->setCoordinates($array_first_col_grades['col_2'] . '5');
        $drawing->setWorksheet($spreadsheet->getActiveSheet());

        $cell_start++;
        $sheet->mergeCells($array_first_col_grades['col_1'] . $cell_start . ':' . $array_second_col_grades['col_4'] . $cell_start);
        $sheet->setCellValue($array_first_col_grades['col_1'] . $cell_start, '(Formerly Form 137)');


        $cell_start++; //16
        $sheet->setCellValue($array_first_col_grades['col_1'] . $cell_start, 'STUDENT  INFORMATION');
        $cell_start++; //17
        $sheet->setCellValue($array_first_col_grades['col_1'] . $cell_start, 'NAME');
        $sheet->mergeCells($array_first_col_grades['col_2'] . $cell_start . ':' . $center_col_grades . $cell_start);
        $sheet->setCellValue(
            $array_first_col_grades['col_2'] . $cell_start,
            strtoupper($array_info['lname'] . ', ' . $array_info['fname'] . ' ' . $array_info['mname'])
        );

        $sheet->mergeCells($array_second_col_grades['col_1'] . $cell_start . ':' . $array_second_col_grades['col_2'] . $cell_start);
        $sheet->setCellValue($array_second_col_grades['col_1'] . $cell_start, 'Learner Ref. No. (LRN)');
        $sheet->mergeCells($array_second_col_grades['col_3'] . $cell_start . ':' . $array_second_col_grades['col_4'] . $cell_start);
        $sheet->setCellValue($array_second_col_grades['col_3'] . $cell_start, $array_info['lrn']);

        $cell_start++; //18
        $sheet->setCellValue($array_first_col_grades['col_1'] . $cell_start, 'ADDRESS');
        $sheet->mergeCells($array_first_col_grades['col_2'] . $cell_start . ':' . $center_col_grades . ($cell_start + 1));
        $sheet->setCellValue($array_first_col_grades['col_2'] . $cell_start, $array_info['address']);

        $sheet->mergeCells($array_second_col_grades['col_1'] . $cell_start . ':' . $array_second_col_grades['col_2'] . $cell_start);
        $sheet->setCellValue($array_second_col_grades['col_1'] . $cell_start, 'DATE  OF  BIRTH ');
        $sheet->mergeCells($array_second_col_grades['col_3'] . $cell_start . ':' . $array_second_col_grades['col_4'] . $cell_start);
        $sheet->setCellValue($array_second_col_grades['col_3'] . $cell_start, $array_info['birth_date']);

        $cell_start++; //19
        $sheet->mergeCells($array_second_col_grades['col_1'] . $cell_start . ':' . $array_second_col_grades['col_2'] . $cell_start);
        $sheet->setCellValue($array_second_col_grades['col_1'] . $cell_start, 'GENDER');
        $sheet->mergeCells($array_second_col_grades['col_3'] . $cell_start . ':' . $array_second_col_grades['col_4'] . $cell_start);
        $sheet->setCellValue($array_second_col_grades['col_3'] . $cell_start, $array_info['gender']);

        $cell_start++; //20
        $sheet->setCellValue($array_first_col_grades['col_1'] . $cell_start, 'Remarks:');
        $sheet->mergeCells($array_first_col_grades['col_2'] . $cell_start . ':' . $array_second_col_grades['col_1'] . $cell_start);
        $sheet->setCellValue($array_first_col_grades['col_2'] . $cell_start, $array_info['remarks']);

        $cell_start++; //21
        $sheet->setCellValue($array_first_col_grades['col_1'] . $cell_start, 'SCHOLASTIC RECORD');

        $cell_start++; //22
        $sheet->mergeCells($array_first_col_grades['col_1'] . $cell_start . ':' . $array_first_col_grades['col_2'] . ($cell_start + 1));
        $sheet->setCellValue($array_first_col_grades['col_1'] . $cell_start, $array_info['course_completed']);
        $sheet->setCellValue($array_first_col_grades['col_3'] . $cell_start, $array_info['course_completed_school']);

        $sheet->mergeCells($array_first_col_grades['col_3'] . $cell_start . ':' . $array_second_col_grades['col_1'] . $cell_start);

        $sheet->mergeCells($array_second_col_grades['col_2'] . $cell_start . ':' . $array_second_col_grades['col_3'] . $cell_start);
        $sheet->setCellValue($array_second_col_grades['col_2'] . $cell_start, 'SCHOOL YEAR');
        $sheet->setCellValue($array_second_col_grades['col_4'] . $cell_start, $array_info['course_completed_sy']);

        $cell_start++; //25
        $sheet->mergeCells($array_first_col_grades['col_3'] . $cell_start . ':' . $array_second_col_grades['col_1'] . $cell_start);

        $sheet->mergeCells($array_second_col_grades['col_2'] . $cell_start . ':' . $array_second_col_grades['col_3'] . $cell_start);
        $sheet->setCellValue($array_second_col_grades['col_2'] . $cell_start, 'GEN. AVERAGE');
        $sheet->setCellValue($array_second_col_grades['col_4'] . $cell_start, $array_info['course_completed_gen_average']);

        #set body
        $body_cell_start = $cell_start + 1;

        //sample array
        //$array_data = array(1);


        $max_subject_rows = 22;
        $odd_even = 1;



        $current_col = $array_first_col_grades;
        //echo 'cell start'.$cell_start;
        //echo '<br/>';

        foreach ($array_data as $key => $grade_level) {
            $cell_start_temp = $cell_start;
            $temp_max_rows = $max_subject_rows;
            //echo 'cell start temp'.$cell_start_temp;
            //echo '<br/>';
            # code...

            //echo is_array($grade_level) ? 'yes' : 'no';
            //echo '<br/>';
            //set border style
            $style_array_border_all = [
                'borders' => [
                    'bottom' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                    ],
                    'top' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                    ],
                    'left' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                    ],
                    'right' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                    ],

                ]

            ];
            if (!empty($grade_level)) {
                # code...
                $cell_start_temp++;
                $sheet->setCellValue($current_col['col_1'] . $cell_start_temp, $array_grade_level_names[$key]);
                $sheet->mergeCells($current_col['col_2'] . $cell_start_temp . ':' . $current_col['col_4'] . $cell_start_temp);
                $sheet->setCellValue($current_col['col_2'] . $cell_start_temp, $grade_level[0]['school_name']);
                #cell format
                $spreadsheet->getActiveSheet()->getStyle($current_col['col_1'] . $cell_start_temp . ':' . $current_col['col_4'] . $cell_start_temp)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $spreadsheet->getActiveSheet()->getStyle($current_col['col_2'] . $cell_start_temp . ':' . $current_col['col_4'] . $cell_start_temp)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $spreadsheet->getActiveSheet()->getStyle($current_col['col_1'] . $cell_start_temp)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $spreadsheet->getActiveSheet()->getStyle($current_col['col_4'] . $cell_start_temp)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                //set font bold
                $spreadsheet->getActiveSheet()->getStyle($current_col['col_1'] . $cell_start_temp . ':' . $current_col['col_4'] . ($cell_start_temp + 3))->getFont()->setBold(true);

                $cell_start_temp++;
                $sheet->setCellValue($current_col['col_1'] . $cell_start_temp, 'No. School Days:');
                $sheet->setCellValue($current_col['col_2'] . $cell_start_temp, $grade_level[0]['total_school_days']);
                $sheet->setCellValue($current_col['col_3'] . $cell_start_temp, 'SY');
                $sheet->setCellValue($current_col['col_4'] . $cell_start_temp, $grade_level[0]['school_year']);
                #cell format
                $spreadsheet->getActiveSheet()->getStyle($current_col['col_1'] . $cell_start_temp)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $spreadsheet->getActiveSheet()->getStyle($current_col['col_2'] . $cell_start_temp)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $spreadsheet->getActiveSheet()->getStyle($current_col['col_4'] . $cell_start_temp)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $spreadsheet->getActiveSheet()->getStyle($current_col['col_4'] . $cell_start_temp)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);


                $cell_start_temp++;
                $sheet->setCellValue($current_col['col_1'] . $cell_start_temp, 'Days Present:');
                $sheet->setCellValue($current_col['col_2'] . $cell_start_temp, $grade_level[0]['total_attendance']);
                #cell format
                $spreadsheet->getActiveSheet()->getStyle($current_col['col_1'] . $cell_start_temp)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $spreadsheet->getActiveSheet()->getStyle($current_col['col_4'] . $cell_start_temp)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);


                $cell_start_temp++;
                $sheet->mergeCells($current_col['col_1'] . $cell_start_temp . ':' . $current_col['col_2'] . $cell_start_temp);
                $sheet->setCellValue($current_col['col_1'] . $cell_start_temp, 'Subjects');
                $sheet->setCellValue($current_col['col_3'] . $cell_start_temp, 'Final Rating');
                $sheet->setCellValue($current_col['col_4'] . $cell_start_temp, 'Remarks');
                #cell format
                $spreadsheet->getActiveSheet()->getStyle($current_col['col_1'] . $cell_start_temp . ':' . $current_col['col_2'] . $cell_start_temp)->applyFromArray($style_array_border_all);
                $spreadsheet->getActiveSheet()->getStyle($current_col['col_3'] . $cell_start_temp)->applyFromArray($style_array_border_all);
                $spreadsheet->getActiveSheet()->getStyle($current_col['col_4'] . $cell_start_temp)->applyFromArray($style_array_border_all);
                $spreadsheet->getActiveSheet()->getStyle($current_col['col_1'] . $cell_start_temp . ':' . $current_col['col_4'] . $cell_start_temp)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $cell_start_temp++;

                //for cell format
                $current_cell_no = $cell_start_temp;

                $temp_max_rows -= 5;

                $grades_sum = 0;
                $grades_total_average = 0;
                $subjects_no = 0;

                #cell format
                //$spreadsheet->getActiveSheet()->getStyle('A24:B25')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                #set parameters for general average for MAPEH
                $mapeh_cell_no = 0;
                $mapeh_subject_count = 0;
                $mapeh_total_grade_sum = 0;
                $mapeh_general_average = 0;
                $mapeh_remarks = "";
                foreach ($grade_level as $grade_key => $subject_details) {
                    //positioning of subject title
                    # code...
                    if ($subject_details['parent_subject_id'] > 0) {
                        # code...
                        $sheet->setCellValue($current_col['col_2'] . $cell_start_temp, $subject_details['subject_title']);
                        $mapeh_total_grade_sum += $subject_details['subject_grade'];
                        $mapeh_subject_count++;
                    } else {
                        $sheet->setCellValue($current_col['col_1'] . $cell_start_temp, $subject_details['subject_title']);
                    }

                    if (($subject_details['subject_id'] != -1) && ($subject_details['subject_id'])) {
                        # code...
                        $sheet->setCellValue($current_col['col_3'] . $cell_start_temp, $subject_details['subject_grade']);
                        $sheet->setCellValue($current_col['col_4'] . $cell_start_temp, $subject_details['remark']);
                        $subjects_no++;
                        $grades_sum += $subject_details['subject_grade'];
                    } else {
                        # code...
                        $mapeh_cell_no = $cell_start_temp;
                    }

                    #cell format
                    $spreadsheet->getActiveSheet()->getStyle($current_col['col_1'] . $cell_start_temp . ':' . $current_col['col_2'] . $cell_start_temp)->applyFromArray($style_array_border_all);
                    $spreadsheet->getActiveSheet()->getStyle($current_col['col_3'] . $cell_start_temp)->applyFromArray($style_array_border_all);
                    $spreadsheet->getActiveSheet()->getStyle($current_col['col_4'] . $cell_start_temp)->applyFromArray($style_array_border_all);

                    $cell_start_temp++;
                    $temp_max_rows--;
                }
                #set MAPEH average and remarks
                $mapeh_general_average = round(($mapeh_total_grade_sum / $mapeh_subject_count));
                if ($mapeh_general_average >= 75) {
                    # code...
                    $mapeh_remarks = "Promoted";
                } else {
                    $mapeh_remarks = "Retained";
                }
                $sheet->setCellValue($current_col['col_3'] . $mapeh_cell_no, $mapeh_general_average);
                $sheet->setCellValue($current_col['col_4'] . $mapeh_cell_no, $mapeh_remarks);

                $grades_total_average = round(($grades_sum / $subjects_no));

                while ($temp_max_rows > 3) {
                    # code...

                    $sheet->mergeCells($current_col['col_1'] . $cell_start_temp . ':' . $current_col['col_2'] . $cell_start_temp);

                    #cell format
                    $spreadsheet->getActiveSheet()->getStyle($current_col['col_1'] . $cell_start_temp . ':' . $current_col['col_2'] . $cell_start_temp)->applyFromArray($style_array_border_all);
                    $spreadsheet->getActiveSheet()->getStyle($current_col['col_3'] . $cell_start_temp)->applyFromArray($style_array_border_all);
                    $spreadsheet->getActiveSheet()->getStyle($current_col['col_4'] . $cell_start_temp)->applyFromArray($style_array_border_all);

                    $cell_start_temp++;
                    $temp_max_rows--;
                }

                $sheet->mergeCells($current_col['col_1'] . $cell_start_temp . ':' . $current_col['col_2'] . $cell_start_temp);
                $sheet->setCellValue($current_col['col_1'] . $cell_start_temp, 'General Average');
                $sheet->setCellValue($current_col['col_3'] . $cell_start_temp, $grades_total_average);

                //promoted or retained
                if ($grades_total_average >= 75) {
                    # code...
                    $sheet->setCellValue($current_col['col_4'] . $cell_start_temp, 'Promoted');
                } else {
                    $sheet->setCellValue($current_col['col_4'] . $cell_start_temp, 'Retained');
                }

                #cell format
                $spreadsheet->getActiveSheet()->getStyle($current_col['col_1'] . $cell_start_temp . ':' . $current_col['col_2'] . $cell_start_temp)->applyFromArray($style_array_border_all);
                $spreadsheet->getActiveSheet()->getStyle($current_col['col_3'] . $cell_start_temp)->applyFromArray($style_array_border_all);
                $spreadsheet->getActiveSheet()->getStyle($current_col['col_4'] . $cell_start_temp)->applyFromArray($style_array_border_all);
                $spreadsheet->getActiveSheet()->getStyle($current_col['col_1'] . $cell_start_temp)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                $spreadsheet->getActiveSheet()->getStyle($current_col['col_1'] . $cell_start_temp . ':' . $current_col['col_4'] . $cell_start_temp)->getFont()->setBold(true);
                //set cells to align center
                $spreadsheet->getActiveSheet()->getStyle($current_col['col_3'] . $current_cell_no . ':' . $current_col['col_4'] . $cell_start_temp)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $cell_start_temp++;
                $sheet->mergeCells($current_col['col_1'] . $cell_start_temp . ':' . $current_col['col_2'] . $cell_start_temp);
                $sheet->setCellValue($current_col['col_1'] . $cell_start_temp, 'Eligible for Admission to');
                $sheet->mergeCells($current_col['col_3'] . $cell_start_temp . ':' . $current_col['col_4'] . $cell_start_temp);
                $sheet->setCellValue($current_col['col_3'] . $cell_start_temp, $array_grade_level_names[$key + 1]);

                #cell format
                $spreadsheet->getActiveSheet()->getStyle($current_col['col_1'] . $cell_start_temp . ':' . $current_col['col_2'] . $cell_start_temp)->applyFromArray($style_array_border_all);
                $spreadsheet->getActiveSheet()->getStyle($current_col['col_3'] . $cell_start_temp . ':' . $current_col['col_4'] . $cell_start_temp)->applyFromArray($style_array_border_all);
                $spreadsheet->getActiveSheet()->getStyle($current_col['col_1'] . $cell_start_temp)->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->getStyle($current_col['col_1'] . $cell_start_temp)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                $spreadsheet->getActiveSheet()->getStyle($current_col['col_3'] . $cell_start_temp)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $cell_start_temp++;
                $sheet->mergeCells($current_col['col_1'] . $cell_start_temp . ':' . $current_col['col_4'] . $cell_start_temp);
                $sheet->setCellValue($current_col['col_1'] . $cell_start_temp, 'sdca - sdca - sdca - sdca - Nothing Follows - sdca - sdca - sdca - sdca');

                #cell format
                $spreadsheet->getActiveSheet()->getStyle($current_col['col_1'] . $cell_start_temp . ':' . $current_col['col_4'] . $cell_start_temp)->applyFromArray($style_array_border_all);
                $spreadsheet->getActiveSheet()->getStyle($current_col['col_1'] . $cell_start_temp)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $spreadsheet->getActiveSheet()->getStyle($current_col['col_1'] . $cell_start_temp . ':' . $current_col['col_4'] . $cell_start_temp)->getFont()->setItalic(true);
            } else {
                //blank table

                $cell_start_temp++;
                $sheet->mergeCells($current_col['col_1'] . $cell_start_temp . ':' . $current_col['col_4'] . $cell_start_temp);
                #cell format
                $spreadsheet->getActiveSheet()->getStyle($current_col['col_1'] . $cell_start_temp . ':' . $current_col['col_4'] . $cell_start_temp)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $spreadsheet->getActiveSheet()->getStyle($current_col['col_2'] . $cell_start_temp . ':' . $current_col['col_4'] . $cell_start_temp)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $spreadsheet->getActiveSheet()->getStyle($current_col['col_1'] . $cell_start_temp)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $spreadsheet->getActiveSheet()->getStyle($current_col['col_4'] . $cell_start_temp)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                //set font bold
                $spreadsheet->getActiveSheet()->getStyle($current_col['col_1'] . $cell_start_temp . ':' . $current_col['col_4'] . ($cell_start_temp + 3))->getFont()->setBold(true);

                $cell_start_temp++;
                $sheet->mergeCells($current_col['col_1'] . $cell_start_temp . ':' . $current_col['col_2'] . $cell_start_temp);
                $sheet->setCellValue($current_col['col_1'] . $cell_start_temp, 'No. School Days:');
                $sheet->setCellValue($current_col['col_3'] . $cell_start_temp, 'SY');
                #cell format
                $spreadsheet->getActiveSheet()->getStyle($current_col['col_1'] . $cell_start_temp)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $spreadsheet->getActiveSheet()->getStyle($current_col['col_2'] . $cell_start_temp)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $spreadsheet->getActiveSheet()->getStyle($current_col['col_4'] . $cell_start_temp)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $spreadsheet->getActiveSheet()->getStyle($current_col['col_4'] . $cell_start_temp)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                $cell_start_temp++;
                $sheet->mergeCells($current_col['col_1'] . $cell_start_temp . ':' . $current_col['col_2'] . $cell_start_temp);
                $sheet->setCellValue($current_col['col_1'] . $cell_start_temp, 'Days Present:');
                #cell format
                $spreadsheet->getActiveSheet()->getStyle($current_col['col_1'] . $cell_start_temp)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $spreadsheet->getActiveSheet()->getStyle($current_col['col_4'] . $cell_start_temp)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);


                $cell_start_temp++;
                $sheet->mergeCells($current_col['col_1'] . $cell_start_temp . ':' . $current_col['col_2'] . $cell_start_temp);
                $sheet->setCellValue($current_col['col_1'] . $cell_start_temp, 'Subjects');
                $sheet->setCellValue($current_col['col_3'] . $cell_start_temp, 'Final Rating');
                $sheet->setCellValue($current_col['col_4'] . $cell_start_temp, 'Remarks');
                #cell format
                $spreadsheet->getActiveSheet()->getStyle($current_col['col_1'] . $cell_start_temp . ':' . $current_col['col_2'] . $cell_start_temp)->applyFromArray($style_array_border_all);
                $spreadsheet->getActiveSheet()->getStyle($current_col['col_3'] . $cell_start_temp)->applyFromArray($style_array_border_all);
                $spreadsheet->getActiveSheet()->getStyle($current_col['col_4'] . $cell_start_temp)->applyFromArray($style_array_border_all);
                $spreadsheet->getActiveSheet()->getStyle($current_col['col_1'] . $cell_start_temp . ':' . $current_col['col_4'] . $cell_start_temp)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);


                $cell_start_temp++;
                $temp_max_rows -= 5;




                while ($temp_max_rows > 3) {
                    # code...

                    $sheet->mergeCells($current_col['col_1'] . $cell_start_temp . ':' . $current_col['col_2'] . $cell_start_temp);
                    #cell format
                    $spreadsheet->getActiveSheet()->getStyle($current_col['col_1'] . $cell_start_temp . ':' . $current_col['col_2'] . $cell_start_temp)->applyFromArray($style_array_border_all);
                    $spreadsheet->getActiveSheet()->getStyle($current_col['col_3'] . $cell_start_temp)->applyFromArray($style_array_border_all);
                    $spreadsheet->getActiveSheet()->getStyle($current_col['col_4'] . $cell_start_temp)->applyFromArray($style_array_border_all);


                    $cell_start_temp++;
                    $temp_max_rows--;
                }

                $sheet->mergeCells($current_col['col_1'] . $cell_start_temp . ':' . $current_col['col_2'] . $cell_start_temp);
                $sheet->setCellValue($current_col['col_1'] . $cell_start_temp, 'General Average');
                #cell format
                $spreadsheet->getActiveSheet()->getStyle($current_col['col_1'] . $cell_start_temp . ':' . $current_col['col_2'] . $cell_start_temp)->applyFromArray($style_array_border_all);
                $spreadsheet->getActiveSheet()->getStyle($current_col['col_3'] . $cell_start_temp)->applyFromArray($style_array_border_all);
                $spreadsheet->getActiveSheet()->getStyle($current_col['col_4'] . $cell_start_temp)->applyFromArray($style_array_border_all);
                $spreadsheet->getActiveSheet()->getStyle($current_col['col_1'] . $cell_start_temp)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                $spreadsheet->getActiveSheet()->getStyle($current_col['col_1'] . $cell_start_temp)->getFont()->setBold(true);
                //set cells to align center
                //$spreadsheet->getActiveSheet()->getStyle($current_col['col_3'].$current_cell_no.':'.$current_col['col_4'].$cell_start_temp)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $cell_start_temp++;
                $sheet->mergeCells($current_col['col_1'] . $cell_start_temp . ':' . $current_col['col_2'] . $cell_start_temp);
                $sheet->setCellValue($current_col['col_1'] . $cell_start_temp, 'Eligible for Admission to');
                $sheet->mergeCells($current_col['col_3'] . $cell_start_temp . ':' . $current_col['col_4'] . $cell_start_temp);
                #cell format
                $spreadsheet->getActiveSheet()->getStyle($current_col['col_1'] . $cell_start_temp . ':' . $current_col['col_2'] . $cell_start_temp)->applyFromArray($style_array_border_all);
                $spreadsheet->getActiveSheet()->getStyle($current_col['col_3'] . $cell_start_temp . ':' . $current_col['col_4'] . $cell_start_temp)->applyFromArray($style_array_border_all);
                $spreadsheet->getActiveSheet()->getStyle($current_col['col_1'] . $cell_start_temp . ':' . $current_col['col_4'] . $cell_start_temp)->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->getStyle($current_col['col_1'] . $cell_start_temp)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                $spreadsheet->getActiveSheet()->getStyle($current_col['col_3'] . $cell_start_temp)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $cell_start_temp++;
                $sheet->mergeCells($current_col['col_1'] . $cell_start_temp . ':' . $current_col['col_4'] . $cell_start_temp);
                $sheet->setCellValue($current_col['col_1'] . $cell_start_temp, 'sdca - sdca - sdca - sdca - Nothing Follows - sdca - sdca - sdca - sdca');
                #cell format
                $spreadsheet->getActiveSheet()->getStyle($current_col['col_1'] . $cell_start_temp . ':' . $current_col['col_4'] . $cell_start_temp)->applyFromArray($style_array_border_all);
                $spreadsheet->getActiveSheet()->getStyle($current_col['col_1'] . $cell_start_temp)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $spreadsheet->getActiveSheet()->getStyle($current_col['col_1'] . $cell_start_temp . ':' . $current_col['col_4'] . $cell_start_temp)->getFont()->setItalic(true);
            }
            $odd_even++;
            if ($odd_even % 2 == 0) {
                # code...
                $current_col = $array_second_col_grades;
            } else {
                #cell format
                $spreadsheet->getActiveSheet()->getRowDimension($cell_start_temp)->setRowHeight(7.5);
                $current_col = $array_first_col_grades;
                $cell_start = $cell_start_temp + 1;
            }
        }

        #cell format
        for ($i = 26; $i <= $cell_start_temp + 4; $i++) {
            # code...
            $spreadsheet->getActiveSheet()->getRowDimension($i)->setRowHeight($array_info['grade_table_row_height']);
        }

        #font size of table grades
        $spreadsheet->getActiveSheet()->getStyle($array_first_col_grades['col_1'] . '26:' . $array_second_col_grades['col_4'] . $cell_start_temp)->getFont()->setSize($array_info['grade_table_font_size']);
        $spreadsheet->getActiveSheet()->getStyle($array_first_col_grades['col_1'] . '26:' . $array_second_col_grades['col_1'] . $cell_start_temp)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);



        //end body

        //footer

        $footer_cell_start = $cell_start;

        #signatory cell format
        $style_array_signatory = [
            'font' => [
                'bold' => TRUE,
                'name' => 'Arial Narrow'
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_BOTTOM
            ]
        ];


        $cell_start++;
        $sheet->mergeCells($array_first_col_grades['col_1'] . $cell_start . ':' . $array_second_col_grades['col_4'] . $cell_start);
        $sheet->setCellValue($array_first_col_grades['col_1'] . $cell_start, 'CERTIFICATION OF TRANSFER');
        #cell format
        $spreadsheet->getActiveSheet()->getStyle($array_first_col_grades['col_1'] . $cell_start)->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle($array_first_col_grades['col_1'] . $cell_start . ':' . $array_first_col_grades['col_1'] . ($cell_start + 5))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $cell_start++;
        $sheet->mergeCells($array_first_col_grades['col_1'] . $cell_start . ':' . $array_second_col_grades['col_4'] . $cell_start);

        #add richtext
        $rich_text = new RichText();
        $rich_text->createText('This is to certify that this is a true copy of the record of ');
        $bold_text = $rich_text->createTextRun(strtoupper($array_info['fname'] . " " . $array_info['mname'] . " " . $array_info['lname']));
        $bold_text->getFont()->setBold(true);
        $bold_text->getFont()->setName('Arial');
        $bold_text->getFont()->setSize(8);

        //add full name here
        $sheet->setCellValue($array_first_col_grades['col_1'] . $cell_start, $rich_text);

        $cell_start++;
        $sheet->mergeCells($array_first_col_grades['col_1'] . $cell_start . ':' . $array_second_col_grades['col_4'] . $cell_start);

        #add richtext
        $rich_text = new RichText();
        $rich_text->createText('She/He is eligible to transfer and admission to ');
        $bold_text = $rich_text->createTextRun($array_info['transfer_admission']);
        $bold_text->getFont()->setBold(true);
        $bold_text->getFont()->setName('Arial');
        $bold_text->getFont()->setSize(8);
        //add designated transfer level
        $sheet->setCellValue($array_first_col_grades['col_1'] . $cell_start, $rich_text);

        $cell_start++;
        $cell_start++;
        $sheet->mergeCells($array_first_col_grades['col_1'] . $cell_start . ':' . $array_second_col_grades['col_4'] . $cell_start);
        //end of transcript
        $sheet->setCellValue($array_first_col_grades['col_1'] . $cell_start, 'sdca - sdca - sdca - sdca - sdca - sdca - sdca - sdca - sdca - sdca - End of Transcript - sdca - sdca - sdca - sdca - sdca - sdca - sdca - sdca - sdca - sdca');
        #cell format
        $spreadsheet->getActiveSheet()->getStyle($array_first_col_grades['col_1'] . $cell_start . ':' . $array_second_col_grades['col_4'] . $cell_start)->applyFromArray($style_array_border_all);
        $spreadsheet->getActiveSheet()->getStyle($array_first_col_grades['col_1'] . $cell_start)->getFont()->setItalic(true);

        $cell_start++;
        //$spreadsheet->getActiveSheet()->getRowDimension($cell_start)->setRowHeight(2.25);
        //end of transcript
        $sheet->mergeCells($array_first_col_grades['col_1'] . $cell_start . ':' . $array_second_col_grades['col_4'] . $cell_start);
        $sheet->setCellValue($array_first_col_grades['col_1'] . $cell_start, 'sdca - sdca - sdca - sdca - sdca - sdca - sdca - sdca - sdca - sdca - End of Transcript - sdca - sdca - sdca - sdca - sdca - sdca - sdca - sdca - sdca - sdca');
        #cell format
        $spreadsheet->getActiveSheet()->getStyle($array_first_col_grades['col_1'] . $cell_start . ':' . $array_second_col_grades['col_4'] . $cell_start)->applyFromArray($style_array_border_all);
        $spreadsheet->getActiveSheet()->getStyle($array_first_col_grades['col_1'] . $cell_start)->getFont()->setItalic(true);

        $cell_start++;
        $sheet->mergeCells($array_first_col_grades['col_1'] . $cell_start . ':' . $array_first_col_grades['col_2'] . ($cell_start + 8));

        //insert SDCA Logo
        $drawing = new Drawing();
        $drawing->setName('Logo4');
        $drawing->setDescription('Logo4');
        $drawing->setPath('./img/StudentRecords/logo4.png');
        $drawing->setCoordinates($array_first_col_grades['col_1'] . $cell_start);
        $drawing->setOffsetX(26);
        $drawing->setOffsetY(2);
        $drawing->setWorksheet($spreadsheet->getActiveSheet());

        $sheet->mergeCells($array_first_col_grades['col_3'] . $cell_start . ':' . $center_col_grades . $cell_start);
        $sheet->setCellValue($array_first_col_grades['col_3'] . $cell_start, 'LEVEL OF PROFICIENCY');
        $sheet->setCellValue($array_second_col_grades['col_1'] . $cell_start, 'Prepared by:');
        $sheet->setCellValue($array_second_col_grades['col_3'] . $cell_start, 'Verified by:');

        #cell format
        $spreadsheet->getActiveSheet()->getStyle($array_first_col_grades['col_3'] . $cell_start)->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle($array_first_col_grades['col_3'] . $cell_start)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle($array_first_col_grades['col_3'] . $cell_start . ':' . $center_col_grades . ($cell_start + 5))->applyFromArray($style_array_border_all);
        $spreadsheet->getActiveSheet()->getStyle($array_second_col_grades['col_1'] . $cell_start . ':' . $array_second_col_grades['col_2'] . ($cell_start + 4))->applyFromArray($style_array_border_all);
        $spreadsheet->getActiveSheet()->getStyle($array_second_col_grades['col_3'] . $cell_start . ':' . $array_second_col_grades['col_4'] . ($cell_start + 4))->applyFromArray($style_array_border_all);

        $cell_start++;
        $level_of_proficiency_cell = $cell_start;
        //$sheet->mergeCells('C'.$cell_start.':'.'D'.$cell_start);
        // $sheet->setCellValue($array_first_col_grades['col_3'].$cell_start, 'A - Advanced');
        //$sheet->setCellValue($array_first_col_grades['col_4'].$cell_start, '90 % and above');

        $cell_start++;
        //$sheet->mergeCells('C'.$cell_start.':'.'D'.$cell_start);
        //$sheet->setCellValue($array_first_col_grades['col_3'].$cell_start, 'P - Proficient');
        //$sheet->setCellValue($array_first_col_grades['col_4'].$cell_start, '85 - 89 %');
        $sheet->mergeCells($array_second_col_grades['col_1'] . $cell_start . ':' . $array_second_col_grades['col_2'] . $cell_start);
        $sheet->mergeCells($array_second_col_grades['col_3'] . $cell_start . ':' . $array_second_col_grades['col_4'] . $cell_start);
        $sheet->setCellValue($array_second_col_grades['col_1'] . $cell_start, $this->form_prepared_by);
        $sheet->setCellValue($array_second_col_grades['col_3'] . $cell_start, $this->form_verified_by);

        #cell format
        $spreadsheet->getActiveSheet()->getStyle($array_second_col_grades['col_1'] . $cell_start)->applyFromArray($style_array_signatory);
        $spreadsheet->getActiveSheet()->getStyle($array_second_col_grades['col_3'] . $cell_start)->applyFromArray($style_array_signatory);

        $cell_start++;
        //$sheet->mergeCells('C'.$cell_start.':'.'D'.$cell_start);
        //$sheet->setCellValue($array_first_col_grades['col_3'].$cell_start, 'AP - Approaching Proficiency');
        //$sheet->setCellValue($array_first_col_grades['col_4'].$cell_start, '80 - 84 %');
        $sheet->mergeCells($array_second_col_grades['col_1'] . $cell_start . ':' . $array_second_col_grades['col_2'] . $cell_start);
        $sheet->setCellValue($array_second_col_grades['col_1'] . $cell_start, 'Records Evaluator');
        $sheet->mergeCells($array_second_col_grades['col_3'] . $cell_start . ':' . $array_second_col_grades['col_4'] . $cell_start);
        $sheet->setCellValue($array_second_col_grades['col_3'] . $cell_start, 'Asst. Registrar');

        #cell format
        $spreadsheet->getActiveSheet()->getStyle($array_second_col_grades['col_1'] . $cell_start . ':' . $array_second_col_grades['col_3'] . $cell_start)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle($array_first_col_grades['col_3'] . $cell_start)->getAlignment()->setWrapText(true);

        $cell_start++;
        //$sheet->mergeCells('C'.$cell_start.':'.'D'.$cell_start);
        //$sheet->setCellValue($array_first_col_grades['col_3'].$cell_start, 'D - Developing');
        //$sheet->setCellValue($array_first_col_grades['col_4'].$cell_start, '75 - 79 %');
        $sheet->mergeCells($array_second_col_grades['col_1'] . $cell_start . ':' . $array_second_col_grades['col_2'] . $cell_start);
        $sheet->setCellValue($array_second_col_grades['col_1'] . $cell_start, 'Date: ' . $this->date_now); #Add date later
        $sheet->mergeCells($array_second_col_grades['col_3'] . $cell_start . ':' . $array_second_col_grades['col_4'] . $cell_start);
        $sheet->setCellValue($array_second_col_grades['col_3'] . $cell_start, 'Date: ' . $this->date_now); #Add date later

        $cell_start++;
        //$sheet->mergeCells('C'.$cell_start.':'.'D'.$cell_start);
        //$sheet->setCellValue($array_first_col_grades['col_3'].$cell_start, 'B - Beginning');
        //$sheet->setCellValue($array_first_col_grades['col_4'].$cell_start, '74 % and below');
        $sheet->setCellValue($array_second_col_grades['col_1'] . $cell_start, 'Approved by:');

        #level of proficiency
        $proficiency_list = "A - Advanced" . $this->custom_space_loop(34) . "90 % and above \r\n";
        $proficiency_list .= "P - Proficient" . $this->custom_space_loop(35) . "85 - 89 % \r\n";
        $proficiency_list .= "AP - Approaching Proficiency" . $this->custom_space_loop(1) . "80 - 84 % \r\n";
        $proficiency_list .= "D - Developing" . $this->custom_space_loop(32) . "75 - 79 % \r\n";
        $proficiency_list .= "B - Beginning" . $this->custom_space_loop(35) . "74 % and below";

        $sheet->mergeCells($array_first_col_grades['col_3'] . $level_of_proficiency_cell . ':' . $center_col_grades . $cell_start);
        $sheet->setCellValue($array_first_col_grades['col_3'] . $level_of_proficiency_cell, $proficiency_list);

        #cell format
        $spreadsheet->getActiveSheet()->getStyle($array_first_col_grades['col_3'] . $level_of_proficiency_cell)->getAlignment()->setWrapText(true);


        #cell format
        $spreadsheet->getActiveSheet()->getStyle($array_second_col_grades['col_1'] . $cell_start)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle($array_second_col_grades['col_1'] . $cell_start . ':' . $array_second_col_grades['col_4'] . ($cell_start + 3))->applyFromArray($style_array_border_all);

        $cell_start++;
        $sheet->setCellValue($array_first_col_grades['col_3'] . $cell_start, 'Released by:');
        $sheet->mergeCells($array_first_col_grades['col_4'] . $cell_start . ':' . $center_col_grades . $cell_start);
        $sheet->setCellValue($array_first_col_grades['col_4'] . $cell_start, $array_info['released_by']);

        #cell format
        $spreadsheet->getActiveSheet()->getStyle($array_first_col_grades['col_3'] . $cell_start . ':' . $center_col_grades . ($cell_start + 2))->applyFromArray($style_array_border_all);
        $spreadsheet->getActiveSheet()->getStyle($array_first_col_grades['col_4'] . $cell_start)->applyFromArray($style_array_signatory);


        $cell_start++;
        $sheet->setCellValue($array_first_col_grades['col_3'] . $cell_start, 'Date:');
        $sheet->setCellValue($array_first_col_grades['col_4'] . $cell_start, $this->date_now);
        $sheet->mergeCells($array_second_col_grades['col_1'] . $cell_start . ':' . $array_second_col_grades['col_4'] . $cell_start);
        $sheet->setCellValue($array_second_col_grades['col_1'] . $cell_start, $this->form_approved_by);

        #cell format
        $spreadsheet->getActiveSheet()->getStyle($array_first_col_grades['col_3'] . $cell_start)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $spreadsheet->getActiveSheet()->getStyle($array_second_col_grades['col_1'] . $cell_start)->applyFromArray($style_array_signatory);

        $cell_start++;
        $sheet->mergeCells($array_second_col_grades['col_1'] . $cell_start . ':' . $array_second_col_grades['col_4'] . $cell_start);
        $sheet->setCellValue($array_second_col_grades['col_1'] . $cell_start, 'Registrar');

        #cell format
        $spreadsheet->getActiveSheet()->getStyle($array_second_col_grades['col_1'] . $cell_start)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);


        $cell_start++;
        $sheet->mergeCells($array_first_col_grades['col_2'] . $cell_start . ':' . $array_first_col_grades['col_3'] . $cell_start);
        $sheet->setCellValue($array_first_col_grades['col_2'] . $cell_start, 'IMPORTANT NOTICE');
        $sheet->mergeCells($array_first_col_grades['col_4'] . $cell_start . ':' . $array_second_col_grades['col_4'] . ($cell_start + 3));
        $sheet->setCellValue($array_first_col_grades['col_4'] . $cell_start, 'This copy is an exact reproduction of the transcript of file with the Office of the Registrar and is considered an original copy when it bears the dry seal of the College and the original signature in ink of the registrar. Any erasure or alteration made on this copy renders the  whole transcript invalid.');

        #cell format
        $spreadsheet->getActiveSheet()->getStyle($array_first_col_grades['col_2'] . $cell_start)->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle($array_first_col_grades['col_4'] . $cell_start)->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle($array_first_col_grades['col_2'] . $cell_start)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

        $cell_start += 3;
        $sheet->setCellValue($array_first_col_grades['col_2'] . $cell_start, $array_info['reference_no']);
        $sheet->setCellValue($array_first_col_grades['col_1'] . $cell_start, $this->date_footer);
        //set form font name to arial
        $spreadsheet->getActiveSheet()->getStyle($array_first_col_grades['col_1'] . '11:' . $array_second_col_grades['col_4'] . $cell_start)->getFont()->applyFromArray(['name' => 'Arial']);

        #Header style
        $style_array = [
            'font' => [
                'bold' => TRUE,
                'name' => 'Arial Narrow'
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_BOTTOM
            ]
        ];
        $spreadsheet->getActiveSheet()->getStyle($array_first_col_grades['col_4'] . '1:' . $array_first_col_grades['col_4'] . '4')->applyFromArray($style_array);

        $style_array = [
            'font' => [
                'bold' => TRUE
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ]
        ];
        $spreadsheet->getActiveSheet()->getStyle($array_first_col_grades['col_1'] . '10:' . $array_first_col_grades['col_1'] . '11')->applyFromArray($style_array);
        $spreadsheet->getActiveSheet()->getStyle($array_first_col_grades['col_1'] . '11')->getFont()->setSize(11.5);

        $style_array = [
            'font' => [
                'italic' => TRUE,
                'size' => 9

            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP
            ]
        ];
        $spreadsheet->getActiveSheet()->getStyle($array_first_col_grades['col_1'] . '12')->applyFromArray($style_array);

        #form section title style

        $style_array = [
            'font' => [
                'bold' => TRUE,
                'size' => 10,
                'underline' => \PhpOffice\PhpSpreadsheet\Style\Font::UNDERLINE_SINGLE
            ],
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ]
        ];
        $spreadsheet->getActiveSheet()->getStyle($array_first_col_grades['col_1'] . '13')->applyFromArray($style_array);
        $spreadsheet->getActiveSheet()->getStyle($array_first_col_grades['col_1'] . '18')->applyFromArray($style_array);

        #student information tab
        //$spreadsheet->getActiveSheet()->getStyle('A17:A20')->getFont()->setSize(9);
        $style_array = [
            'font' => [
                'size' => 9
            ],
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_BOTTOM
            ]
        ];
        //for name and address alignment
        $spreadsheet->getActiveSheet()->getStyle($array_first_col_grades['col_1'] . '14:' . $array_first_col_grades['col_1'] . '17')->applyFromArray($style_array);

        $style_array = [
            'font' => [
                'size' => 9
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_BOTTOM
            ]
        ];
        //for lrn, birth date, remarks, and gender alignment
        $spreadsheet->getActiveSheet()->getStyle($array_second_col_grades['col_1'] . '14')->applyFromArray($style_array);
        $spreadsheet->getActiveSheet()->getStyle($array_second_col_grades['col_1'] . '15')->applyFromArray($style_array);
        $spreadsheet->getActiveSheet()->getStyle($array_second_col_grades['col_1'] . '16')->applyFromArray($style_array);
        $spreadsheet->getActiveSheet()->getStyle($array_first_col_grades['col_1'] . '17')->applyFromArray($style_array);
        $spreadsheet->getActiveSheet()->getStyle($array_second_col_grades['col_3'] . '14')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        $style_array = [
            'font' => [
                'size' => 9
            ],
            'borders' => [
                'bottom' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                ]
            ]
        ];
        //for underline name, remarks, and address
        $spreadsheet->getActiveSheet()->getStyle($array_first_col_grades['col_2'] . '14:' . $center_col_grades . '14')->applyFromArray($style_array);
        $spreadsheet->getActiveSheet()->getStyle($array_first_col_grades['col_2'] . '15:' . $center_col_grades . '15')->applyFromArray($style_array);
        $spreadsheet->getActiveSheet()->getStyle($array_first_col_grades['col_2'] . '17:' . $array_second_col_grades['col_1'] . '17')->applyFromArray($style_array);
        $spreadsheet->getActiveSheet()->getStyle($array_first_col_grades['col_2'] . '15')->getAlignment()->setWrapText(true);

        //for underline LRN, date of birth, and gender
        $spreadsheet->getActiveSheet()->getStyle($array_second_col_grades['col_3'] . '14:' . $array_second_col_grades['col_4'] . '14')->applyFromArray($style_array);
        $spreadsheet->getActiveSheet()->getStyle($array_second_col_grades['col_3'] . '15:' . $array_second_col_grades['col_4'] . '15')->applyFromArray($style_array);
        $spreadsheet->getActiveSheet()->getStyle($array_second_col_grades['col_3'] . '16:' . $array_second_col_grades['col_4'] . '16')->applyFromArray($style_array);

        //lrn number format
        $spreadsheet->getActiveSheet()->getStyle($array_second_col_grades['col_3'] . '14')->getNumberFormat()->setFormatCode('###');
        #scholastic tab 
        $style_array = [
            'font' => [
                'size' => 9,
                'bold' => TRUE
            ],
            'borders' => [
                'bottom' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                ],
                'top' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                ],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_BOTTOM
            ]

        ];
        //Border
        $spreadsheet->getActiveSheet()->getStyle($array_first_col_grades['col_1'] . '19:' . $array_first_col_grades['col_2'] . '20')->applyFromArray($style_array);
        $spreadsheet->getActiveSheet()->getStyle($array_first_col_grades['col_1'] . '19')->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle($array_first_col_grades['col_3'] . '19:' . $array_second_col_grades['col_1'] . '19')->applyFromArray($style_array);
        $spreadsheet->getActiveSheet()->getStyle($array_first_col_grades['col_3'] . '20:' . $array_second_col_grades['col_1'] . '20')->applyFromArray($style_array);
        $spreadsheet->getActiveSheet()->getStyle($array_second_col_grades['col_2'] . '19:' . $array_second_col_grades['col_3'] . '20')->applyFromArray($style_array);
        $spreadsheet->getActiveSheet()->getStyle($array_second_col_grades['col_4'] . '19')->applyFromArray($style_array);
        $spreadsheet->getActiveSheet()->getStyle($array_second_col_grades['col_4'] . '20')->applyFromArray($style_array);

        //border left and border right 
        $spreadsheet->getActiveSheet()->getStyle($array_first_col_grades['col_1'] . '19:' . $array_first_col_grades['col_2'] . '20')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $spreadsheet->getActiveSheet()->getStyle($array_second_col_grades['col_4'] . '19:' . $array_second_col_grades['col_4'] . '20')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $style_array = [
            'font' => [
                'size' => 9,
                'bold' => TRUE
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_BOTTOM
            ]

        ];
        //school year and gen average alignment
        $spreadsheet->getActiveSheet()->getStyle($array_second_col_grades['col_2'] . '19:' . $array_second_col_grades['col_2'] . '20')->applyFromArray($style_array);

        #page margin
        $spreadsheet->getActiveSheet()->getPageMargins()->setTop(0.25);
        $spreadsheet->getActiveSheet()->getPageMargins()->setRight(0.45);
        $spreadsheet->getActiveSheet()->getPageMargins()->setLeft(0.45);
        $spreadsheet->getActiveSheet()->getPageMargins()->setBottom(.25);
        $spreadsheet->getActiveSheet()->getPageMargins()->setHeader(.3);
        $spreadsheet->getActiveSheet()->getPageMargins()->setFooter(.3);

        #column width
        $spreadsheet->getActiveSheet()->getColumnDimension($array_first_col_grades['col_1'])->setWidth(14.28); //13.57
        $spreadsheet->getActiveSheet()->getColumnDimension($array_first_col_grades['col_2'])->setWidth(11); //10.29
        $spreadsheet->getActiveSheet()->getColumnDimension($array_first_col_grades['col_3'])->setWidth(10); //9.29
        $spreadsheet->getActiveSheet()->getColumnDimension($array_first_col_grades['col_4'])->setWidth(12.28); //11.57
        $spreadsheet->getActiveSheet()->getColumnDimension($center_col_grades)->setWidth(5.28); //4.57
        $spreadsheet->getActiveSheet()->getColumnDimension($array_second_col_grades['col_1'])->setWidth(15.28); //14.57
        $spreadsheet->getActiveSheet()->getColumnDimension($array_second_col_grades['col_2'])->setWidth(9.71); //9
        $spreadsheet->getActiveSheet()->getColumnDimension($array_second_col_grades['col_3'])->setWidth(9.71); //9
        $spreadsheet->getActiveSheet()->getColumnDimension($array_second_col_grades['col_4'])->setWidth(12.57); //11.86

        if ($array_info['educational_stage'] == 'elementary') {
            # code...
            #column width
            $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(5.42);
        }

        #row height
        $spreadsheet->getActiveSheet()->getDefaultRowDimension()->setRowHeight(10);
        $spreadsheet->getActiveSheet()->getRowDimension('10')->setRowHeight(2.25);
        $spreadsheet->getActiveSheet()->getRowDimension('21')->setRowHeight(9.75);

        for ($i = 1; $i <= 26; $i++) {
            # code...
            $spreadsheet->getActiveSheet()->getRowDimension($i)->setRowHeight(14.25);
        }

        for ($i = $footer_cell_start; $i <= $cell_start; $i++) {
            $spreadsheet->getActiveSheet()->getRowDimension($i)->setRowHeight(12);
        }
        $spreadsheet->getActiveSheet()->getRowDimension('9')->setRowHeight(6);


        #font size of table grades
        $spreadsheet->getActiveSheet()->getStyle($array_first_col_grades['col_1'] . $body_cell_start . ':' . $array_second_col_grades['col_4'] . $cell_start)->getFont()->setSize(8);

        #paper size
        $spreadsheet->getActiveSheet()->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_LEGAL);

        #fit to page
        $spreadsheet->getActiveSheet()->getPageSetup()->setFitToPage(TRUE);

        #level of proficiency
        $spreadsheet->getActiveSheet()->getStyle($array_first_col_grades['col_3'] . $level_of_proficiency_cell)->getFont()->setSize(6.5);

        #header image
        $header_image = new HeaderFooterDrawing();
        $header_image->setName('PhpSpreadsheet_logo');
        $header_image->setPath('./img/StudentRecords/sdca_watermark_logo.png');
        //$header_image->setHeight(200);
        $sheet->getHeaderFooter()->addImage($header_image, \PhpOffice\PhpSpreadsheet\Worksheet\HeaderFooter::IMAGE_HEADER_CENTER);

        #adding line break for header
        $sheet->getHeaderFooter()->setOddHeader($header_break_line . "&G");



        #export to excel
        $writer = new Xlsx($spreadsheet);
        //
        $filename = strtoupper($array_info['lname'] . ", " . $array_info['fname'] . " " . $array_info['mname']);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); // download file 

    }

    private function custom_space_loop($loop_num)
    {
        $space = "";
        for ($i = 0; $i < $loop_num; $i++) {
            # code...
            $space .= " ";
        }
        return $space;
    }

    private function in_array_r($needle, $haystack, $column, $strict = false)
    {
        foreach ($haystack as $item) {
            if (($strict ? $item[$column] === $needle : $item[$column] == $needle) || (is_array($item) && $this->in_array_r($needle, $item, $column, $strict))) {
                return true;
            }
        }

        return false;
    }

    private function basiced_subject_grade_average($array_grades)
    {
        $total_sum = 0;
        foreach ($array_grades as $key => $grades) {
            # code...
            $total_sum += $grades['finGrade'];
        }

        $average = $total_sum / 4;
        return round($average);
    }

    private function basiced_get_subject($subject_type, $array_subjects)
    {

        $subject_title = array_column($array_subjects, 'subject_title');

        $input = preg_quote($subject_type, '~');
        $result_search = preg_grep('~' . $input . '~', $subject_title);

        return $result_search;
    }

    private function basiced_combine_subject_grades($subject_type, $array_subjects, $result_search)
    {

        $array_output = array();



        #get the first key of array search
        $reset_result_key = array_key_first($result_search);


        $array_output = array(
            'subject_id' => $array_subjects[$reset_result_key]['subject_id'],
            'subject_title' => $subject_type,
            'subject_grade' => 0,
            'remark' => $array_subjects[$reset_result_key]['remark'],
            'parent_subject_id' => $array_subjects[$reset_result_key]['parent_subject_id'],
            'total_school_days' => $array_subjects[$reset_result_key]['total_school_days'],
            'total_attendance' => $array_subjects[$reset_result_key]['total_attendance'],
            'school_name' => $array_subjects[$reset_result_key]['school_name'],
            'school_year' => $array_subjects[$reset_result_key]['school_year']
        );

        foreach ($result_search as $key => $subject_id) {
            # code...
            $array_output['subject_grade'] += $array_subjects[$key]['subject_grade'];
        }

        if ($array_output['subject_grade'] >= 75) {
            # code...
            $array_output['remark'] = "Promoted";
        } else {
            # code...
            $array_output['remark'] = "Retain";
        }



        return $array_output;
    }

    private function remove_subjects($array_subjects, $result_search)
    {
        $array_output = $array_subjects;
        foreach ($result_search as $key => $subject) {
            # code...
            unset($array_output[$subject]);
            //array_splice($array_output, $subject, 1);
        }



        return $array_output;
    }

    public function test()
    {
        $_POST['studentNumber'] = 201600193;

        $this->elementary_permanent_academic_record();
    }

    public function test2()
    {

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Hello World !');

        $writer = new Xlsx($spreadsheet);
        $writer->save('hello world.xlsx');
    }

    public function download()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Hello World !');

        $writer = new Xlsx($spreadsheet);

        $filename = 'name-of-the-generated-file';

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); // download file 

    }

    public function get_student_info()
    {
        if (($this->input->get('studentNumber') == NULL) or (!is_numeric($this->input->get('studentNumber')))) {
            # code...
            $output["checker"] = 0;
            $output["message"] = "data is invalid";
            echo json_encode($output);
            return;
        }

        $student_info = $this->Student_Model->get_student_details_by_student_no($this->input->get('studentNumber'));

        if (!$student_info) {
            # code...
            $output["checker"] = 0;
            $output["message"] = "Student not found";
            echo json_encode($output);
            return;
        }

        $output["checker"] = 1;
        $output["message"] = "";
        $output["output"] = $student_info;
        echo json_encode($output);
        return;
    }

    public function get_shs_student_info()
    {
        if (($this->input->get('studentNumber') == NULL) or (!is_numeric($this->input->get('studentNumber')))) {
            # code...
            $output["checker"] = 0;
            $output["message"] = "data is invalid";
            echo json_encode($output);
            return;
        }

        $student_info = $this->Student_Model->get_student_details_by_student_no($this->input->get('studentNumber'));

        if (!$student_info) {
            # code...
            $output["checker"] = 0;
            $output["message"] = "Student not found";
            echo json_encode($output);
            return;
        }

        $array_params = array(
            'student_info' => $student_info[0],
            'student_type' => "SHS"
        );
        $this->load->library('student', $array_params);

        #check if the student is G11 or G12
        $grade_level = $student_info[0]['Gradelevel'];
        if (($grade_level === "G11") || ($grade_level === "G12")) {
            # code...
            $output["checker"] = 1;
            $output["message"] = "";
            $output["output"] = $student_info;
            $output["elementarySchoolName"] = $this->student->get_bed_elementary_education();
            $output["elementarySchoolGraduated"] = $this->student->get_bed_elementary_graduated();
            $output["secondarySchoolName"] = $this->student->get_bed_secondary_education();
            $output["secondarySchoolGraduated"] = $this->student->get_bed_secondary_graduated();
            $output["birthDate"] = mdate("%Y-%m-%d", strtotime($this->student->get_birth_date())); //%d/%m/%Y
            echo json_encode($output);
            return;
        } else {
            $output["checker"] = 0;
            $output["message"] = "The student is not in Grade 11 or 12 ";
            echo json_encode($output);
            return;
        }
    }
}//end class