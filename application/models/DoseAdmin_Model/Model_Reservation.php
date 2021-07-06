<?php

class Model_Reservation extends CI_Model
{

	function __construct()
	{
		date_default_timezone_set('Asia/Manila');
		$this->load->model('DoseAdmin_Model/Model_Date_Time','model_date_time');
		$this->load->model('DoseAdmin_Model/Model_Others','model_others');
	}

	function search($search_value, $search_filter, $form_url, $get_name_search_value, $page, $student_type)
	{
		if ($page == '') {
			$page = 0;
		}

		/*
		if(is_numeric($search_value))
		{
			$type = "(A.Reference_Number = '$search_value' OR A.Student_Number ='$search_value')";
			//$type = "A.Reference_Number = '$search_value' ";
			//$search_type= 'reference_number';
			}// end of	if($search_type == 'lastname')
			
		else
		{
			$type = "A.Last_Name LIKE '%$search_value%'";
			//$search_type= 'last_name';
			}// end of	if($search_type == 'lastname')
		*/
		if ($search_filter === 'reference_number') {
			# code...
			$type = "A.Reference_Number = '$search_value'";
		} elseif ($search_filter === 'student_number') {
			# code...
			$type = "A.Student_Number ='$search_value'";
		} elseif ($search_filter === 'last_name') {
			# code...
			$type = "A.Last_Name LIKE '%$search_value%'";
		} else {
			# code...
			return "";
		}

		$search = $this->query_search($type, $form_url, $get_name_search_value, $search_value, $search_filter, $page, $student_type);
		return $search;
	} // end of function search($search_type, $search_value)

	function query_search($search_type, $form_url, $get_name_search_value, $search_value, $search_filter, $page, $student_type)
	{
		$table_page_hash = '#table';

		$num = $page;

		// $this->load->model('model_date_time');
		$date_today = $this->model_date_time->get_year();
		$date_advance = $date_today + 1;
		$school_year = $date_today . '-' . $date_advance;

		if ($student_type == 'highered') {
			//$first_query = "SELECT A.Reference_Number, A.Student_Number, A.First_Name, A.Middle_Name, A.Last_Name, A.Course_1st, A.Course_2nd, A.Course_3rd FROM Student_Info AS A WHERE A.Enroll = 0 AND $search_type LIMIT $page, 10";
			//$second_query = "SELECT A.Reference_Number, A.Student_Number, A.First_Name, A.Middle_Name, A.Last_Name, A.Course_1st, A.Course_2nd, A.Course_3rd FROM Student_Info AS A WHERE A.Enroll = 0 AND $search_type";

			$first_query = "SELECT A.Reference_Number, A.Student_Number, A.First_Name, A.Middle_Name, A.Last_Name, A.Course_1st, A.Course_2nd, A.Course_3rd FROM Student_Info AS A WHERE A.Student_Number = 0 AND $search_type LIMIT $page, 10";
			$second_query = "SELECT A.Reference_Number, A.Student_Number, A.First_Name, A.Middle_Name, A.Last_Name, A.Course_1st, A.Course_2nd, A.Course_3rd FROM Student_Info AS A WHERE A.Student_Number = 0 AND $search_type";
			// table head
			$output = '<thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Reference Number</th>
                                            <th>First Name</th>
                                            <th>Middle Name</th>
                                            <th>Last Name</th>
                                            <th>First Choice</th>
                                            <th>Second Choice</th>
                                            <th>Third Choice</th> 
                                            <th>Select</th>
                                        </tr>
                                    </thead>';
			$output .= '<tbody>';
		} elseif ($student_type == 'basiced') {


			/*
				$first_query = "SELECT Reference_Number, First_Name, Middle_Name, Last_Name, Gradelevel FROM Basiced_Studentinfo WHERE Enroll = 0 AND Gradelevel != 'G11' AND Gradelevel !='G12' AND $search_type LIMIT $page, 10";
				$second_query = "SELECT Reference_Number, First_Name, Middle_Name, Last_Name, Gradelevel FROM Basiced_Studentinfo WHERE Enroll = 0 AND Gradelevel != 'G11' AND Gradelevel !='G12' AND $search_type";
				*/

			/*
				$first_query = "
					SELECT A.Reference_Number, A.First_Name, A.Middle_Name, A.Last_Name, A.Gradelevel
					FROM Basiced_Studentinfo AS A INNER JOIN Basiced_EnrolledFees_Local AS B ON A.Reference_Number = B.Reference_Number  
					WHERE A.Gradelevel !='G10' 
					AND A.Gradelevel !='G12'
					AND A.Gradelevel != 'G11' 
					AND B.SchoolYear != '$school_year'
					AND $search_type 
					LIMIT $page, 10
					";
				$second_query = "
					SELECT A.Reference_Number, A.First_Name, A.Middle_Name, A.Last_Name, A.Gradelevel
					FROM Basiced_Studentinfo AS A INNER JOIN Basiced_EnrolledFees_Local AS B ON A.Reference_Number = B.Reference_Number  
					WHERE A.Gradelevel !='G10' 
					AND A.Gradelevel !='G12'
					AND A.Gradelevel != 'G11' 
					AND B.SchoolYear != '$school_year'
					AND $search_type 
					";
					
				$first_query_v2 = "
					SELECT A.Reference_Number, A.First_Name, A.Middle_Name, A.Last_Name, A.Gradelevel 
					FROM Basiced_Studentinfo AS A
					WHERE A.Enroll = 0 
					#AND A.Gradelevel !='G10'
					AND A.Gradelevel != 'G11' 
					AND A.Gradelevel !='G12' 
					AND $search_type 
					LIMIT $page, 10
					";
					
				$second_query_v2 = "
					SELECT A.Reference_Number, A.First_Name, A.Middle_Name, A.Last_Name, A.Gradelevel 
					FROM Basiced_Studentinfo AS A
					WHERE A.Enroll = 0
					#AND A.Gradelevel !='G10' 
					AND A.Gradelevel != 'G11' 
					AND A.Gradelevel !='G12' 
					AND $search_type 
				";
				*/

			$first_query = "
					SELECT A.Reference_Number, A.Student_Number, A.First_Name, A.Middle_Name, A.Last_Name, A.Gradelevel 
					FROM Basiced_Studentinfo AS A INNER JOIN Basiced_EnrolledFees_Local AS B ON A.Reference_Number = B.Reference_Number  
					WHERE A.Gradelevel !='G10' 
					AND A.Gradelevel !='G12'
					AND A.Gradelevel != 'G11' 
					AND B.SchoolYear != '$school_year'
					AND $search_type 
					UNION
					SELECT A.Reference_Number , A.Student_Number,  A.First_Name, A.Middle_Name, A.Last_Name, A.Gradelevel 
					FROM Basiced_Studentinfo AS A
					WHERE A.Reference_Number NOT IN (SELECT Reference_Number FROM Basiced_EnrolledFees_Local WHERE SchoolYear = '$school_year' )
					#AND A.Gradelevel !='G10'
					AND A.Gradelevel != 'G11' 
					AND A.Gradelevel !='G12' 
					AND $search_type 
					LIMIT $page, 10
				";

			$second_query = "
					SELECT A.Reference_Number, A.Student_Number, A.First_Name, A.Middle_Name, A.Last_Name, A.Gradelevel 
					FROM Basiced_Studentinfo AS A INNER JOIN Basiced_EnrolledFees_Local AS B ON A.Reference_Number = B.Reference_Number  
					WHERE A.Gradelevel !='G10' 
					AND A.Gradelevel !='G12'
					AND A.Gradelevel != 'G11' 
					AND B.SchoolYear != '$school_year'
					AND $search_type 
					UNION
					SELECT A.Reference_Number , A.Student_Number,  A.First_Name, A.Middle_Name, A.Last_Name, A.Gradelevel 
					FROM Basiced_Studentinfo AS A
					WHERE A.Reference_Number NOT IN (SELECT Reference_Number FROM Basiced_EnrolledFees_Local WHERE SchoolYear = '$school_year' )
					#AND A.Gradelevel !='G10'
					AND A.Gradelevel != 'G11' 
					AND A.Gradelevel !='G12' 
					AND $search_type 
				";


			// table head
			$output = '<thead>
											<tr>
												<th>#</th>
												<th>Reference Number</th>
												<th>Student Number</th>
												<th>First Name</th>
												<th>Middle Name</th>
												<th>Last Name</th>
												<th>Grade Level</th>
												<th>Select</th>
											</tr>
										</thead>';
			$output .= '<tbody>';
		} else {
			/*
					$first_query = "SELECT Reference_Number, First_Name, Middle_Name, Last_Name, Gradelevel, Strand FROM Basiced_Studentinfo WHERE Enroll = 0 AND (Gradelevel = 'G11' OR Gradelevel = 'G12') AND $search_type LIMIT $page, 10";
					$second_query = "SELECT Reference_Number, First_Name, Middle_Name, Last_Name, Gradelevel, Strand FROM Basiced_Studentinfo WHERE Enroll = 0 AND (Gradelevel = 'G11' OR Gradelevel = 'G12') AND $search_type";
					*/
			/*
				$first_query = "
					SELECT A.Reference_Number, A.First_Name, A.Middle_Name, A.Last_Name, A.Gradelevel, A.Strand
					FROM Basiced_Studentinfo AS A INNER JOIN Basiced_EnrolledFees_Local AS B ON A.Reference_Number = B.Reference_Number  
					WHERE (A.Gradelevel = 'G10' OR A.Gradelevel = 'G11' OR A.Gradelevel = 'G12')
					AND B.SchoolYear != '$school_year'
					AND $search_type 
					LIMIT $page, 10
					";
				$second_query = "
					SELECT A.Reference_Number, A.First_Name, A.Middle_Name, A.Last_Name, A.Gradelevel, A.Strand
					FROM Basiced_Studentinfo AS A INNER JOIN Basiced_EnrolledFees_Local AS B ON A.Reference_Number = B.Reference_Number  
					WHERE (A.Gradelevel = 'G10' OR A.Gradelevel = 'G11' OR A.Gradelevel = 'G12')
					AND B.SchoolYear != '$school_year'
					AND $search_type 
					";
					
				$first_query_v2 = "
					SELECT A.Reference_Number, A.First_Name, A.Middle_Name, A.Last_Name, A.Gradelevel, A.Strand
					FROM Basiced_Studentinfo AS A
					WHERE A.Enroll = 0 
					AND (A.Gradelevel = 'G10' OR A.Gradelevel = 'G11' OR A.Gradelevel = 'G12')
					AND $search_type 
					LIMIT $page, 10
					";
					
				$second_query_v2 = "
					SELECT A.Reference_Number, A.First_Name, A.Middle_Name, A.Last_Name, A.Gradelevel, A.Strand 
					FROM Basiced_Studentinfo AS A
					WHERE A.Enroll = 0
					AND (A.Gradelevel = 'G10' OR A.Gradelevel = 'G11' OR A.Gradelevel = 'G12')
					AND $search_type 
				";
				*/


			$first_query = "
					SELECT A.Reference_Number, A.Student_Number, A.First_Name, A.Middle_Name, A.Last_Name, A.Gradelevel, A.Strand
					FROM Basiced_Studentinfo AS A INNER JOIN Basiced_EnrolledFees_Local AS B ON A.Reference_Number = B.Reference_Number  
					WHERE (A.Gradelevel = 'G10' OR A.Gradelevel = 'G11' OR A.Gradelevel = 'G12')
					AND B.SchoolYear != '$school_year'
					AND $search_type
					UNION
					SELECT A.Reference_Number, A.Student_Number, A.First_Name, A.Middle_Name, A.Last_Name, A.Gradelevel, A.Strand
					FROM Basiced_Studentinfo AS A
					WHERE A.Reference_Number NOT IN (SELECT Reference_Number FROM Basiced_EnrolledFees_Local WHERE SchoolYear = '$school_year' )
					AND (A.Gradelevel = 'G10' OR A.Gradelevel = 'G11' OR A.Gradelevel = 'G12')
					AND $search_type 
					LIMIT $page, 10
				";

			$second_query = "
					SELECT A.Reference_Number, A.Student_Number, A.First_Name, A.Middle_Name, A.Last_Name, A.Gradelevel, A.Strand
					FROM Basiced_Studentinfo AS A INNER JOIN Basiced_EnrolledFees_Local AS B ON A.Reference_Number = B.Reference_Number  
					WHERE (A.Gradelevel = 'G10' OR A.Gradelevel = 'G11' OR A.Gradelevel = 'G12')
					AND B.SchoolYear != '$school_year'
					AND $search_type
					UNION
					SELECT A.Reference_Number, A.Student_Number, A.First_Name, A.Middle_Name, A.Last_Name, A.Gradelevel, A.Strand
					FROM Basiced_Studentinfo AS A
					WHERE A.Reference_Number NOT IN (SELECT Reference_Number FROM Basiced_EnrolledFees_Local WHERE SchoolYear = '$school_year' )
					AND (A.Gradelevel = 'G10' OR A.Gradelevel = 'G11' OR A.Gradelevel = 'G12')
					AND $search_type 
				";

			// table head
			$output = '<thead>
												<tr>
													<th>#</th>
													<th>Reference Number</th>
													<th>Student Number</th>
													<th>First Name</th>
													<th>Middle Name</th>
													<th>Last Name</th>
													<th>Grade Level</th>
													<th>Strand</th>
													<th>Select</th>
												</tr>
											</thead>';
			$output .= '<tbody>';
		}

		$query = $this->db->query($first_query);

		/*
		$rowcount_search = $query->num_rows();
		
		if($rowcount_search == 0)
		{
			$query = $this->db->query($first_query_v2);
			
			$second_query = $second_query_v2;
			}
		*/



		foreach ($query->result() as $row) {
			$num++;
			$ref_number = $row->Reference_Number;
			$student_number = $row->Student_Number;
			$fname = $row->First_Name;
			$mname = $row->Middle_Name;
			$lname = $row->Last_Name;
			if ($student_type == 'highered') {
				$course_1 = $row->Course_1st;
				$course_2 = $row->Course_2nd;
				$course_3 = $row->Course_3rd;
			} elseif ($student_type == 'basiced') {
				$grade_level = $row->Gradelevel;
			} else {
				$grade_level = $row->Gradelevel;
				$strand = $row->Strand;
			}
			//pattern if search have space 
			$pattern_space = preg_match('/\s/', $search_value);
			if ($pattern_space > 0) {
				// $this->load->model('model_others');
				$search_value = $this->model_others->string_replace($search_value, ' ', '+');
			}
			///////

			$link_url = $form_url . '?select_value=' . $ref_number . '&' . $get_name_search_value . '=' . $search_value . '&search_filter=' . $search_filter . '&student_type=' . $student_type . '&page=' . $page . $table_page_hash;


			if ($student_type == 'highered') {
				$output .= '
						<tr>
						   <th>' . $num . '</th> 
						   <th>' . $ref_number . '</th> 
                           <th>' . $fname . '</th>
                           <th>' . $mname . '</th>
                           <th>' . $lname . '</th>
                           <th>' . $course_1 . '</th>
                           <th>' . $course_2 . '</th>
                           <th>' . $course_3 . '</th>
						   <th><a href=' . site_url($link_url) . '>Click Here</a></th>
                        </tr>
					';
			} elseif ($student_type == 'basiced') {
				$output .= '
							<tr>
							   <th>' . $num . '</th> 
							   <th>' . $ref_number . '</th> 
							   <th>' . $student_number . '</th> 
							   <th>' . $fname . '</th>
							   <th>' . $mname . '</th>
							   <th>' . $lname . '</th>
							   <th>' . $grade_level . '</th>
							   <th><a href=' . site_url($link_url) . '>Click Here</a></th>
							</tr>
						';
			} else {
				$output .= '
								<tr>
								   <th>' . $num . '</th> 
								   <th>' . $ref_number . '</th>
								   <th>' . $student_number . '</th>  
								   <th>' . $fname . '</th>
								   <th>' . $mname . '</th>
								   <th>' . $lname . '</th>
								   <th>' . $grade_level . '</th>
								   <th>' . $strand . '</th>
								   <th><a href=' . site_url($link_url) . '>Click Here</a></th>
								</tr>
							';
			}
		} // end of foreach ($query->result() as $row)

		///////////for page////////////////
		$query_row_check = $this->db->query($second_query);

		$dividend  = $query_row_check->num_rows();
		$divisor = 10;
		$page_output_quotient = $dividend / $divisor;
		$page_output_remainder = $dividend % $divisor;
		$page_output_checker = is_float($page_output_quotient);


		if ($page_output_checker == 1) {
			$page_output_num = $page_output_quotient;
		} else {
			$page_output_num = (int)$page_output_quotient;
			$page_output_num = $page_output_num + 1;
		}
		$num = 0;
		$page_num = 0;

		$page_output = '<span>';

		while ($page_output_num >= $num) {
			$num++;

			$link_url_page = $form_url . '?' . $get_name_search_value . '=' . $search_value . '&student_type=' . $student_type . '&page=' . $page_num . $table_page_hash;
			$page_output .= '<a href=' . site_url($link_url_page) . '>' . $num . '</a>, ';
			$page_num = $page_num + 10;
		}

		$page_output .= '</span>';

		//////////////////////////////////


		$output .= '<tr>
						<th colspan = "9">' . $page_output . '</th>
					</tr>
		';

		$output .= '</tbody>';

		return $output;
	} // end of function query_search

	function query_select($reference_number, $student_type)
	{
		if ($student_type == 'highered') {
			$query_input = "SELECT Reference_Number, First_Name, Middle_Name, Last_Name, Course_1st, Course_2nd, Course_3rd, Course_Major_1st, Course_Major_2nd, Course_Major_3rd, (SELECT Program_Major FROM Program_Majors WHERE ID = Course_Major_1st) AS Major_1st, (SELECT Program_Major FROM Program_Majors WHERE ID = Course_Major_2nd) AS Major_2nd, (SELECT Program_Major FROM Program_Majors WHERE ID = Course_Major_3rd) AS Major_3rd  FROM Student_Info WHERE Reference_Number = '$reference_number'";
		} else {
			$query_input = "SELECT Reference_Number, First_Name, Middle_Name, Last_Name, Gradelevel FROM Basiced_Studentinfo WHERE Reference_Number = '$reference_number'";
		}

		$query = $this->db->query($query_input);

		foreach ($query->result() as $row) {
			$ref_number = $row->Reference_Number;
			$fname = $row->First_Name;
			$mname = $row->Middle_Name;
			$lname = $row->Last_Name;

			if ($student_type == 'highered') {
				$first_choice = $row->Course_1st;
				$second_choice = $row->Course_2nd;
				$third_choice = $row->Course_3rd;
				$major_first = $row->Course_Major_1st;
				$major_second = $row->Course_Major_2nd;
				$major_third = $row->Course_Major_3rd;
				$major_first_name = $row->Major_1st;
				$major_second_name = $row->Major_2nd;
				$major_third_name = $row->Major_3rd;
			} else {
				$grade_level = $row->Gradelevel;
			}

			$full_name = $lname . ', ' . $fname . ' ' . $mname;
		}

		if ($student_type == 'highered') {
			$array_output[] = array(
				'full_name' => $full_name,
				'first_choice' => $first_choice,
				'second_choice' => $second_choice,
				'third_choice' => $third_choice,
				'major_first' => $major_first,
				'major_second' => $major_second,
				'major_third' => $major_third,
				'major_first_name' => $major_first_name,
				'major_second_name' => $major_second_name,
				'major_third_name' => $major_third_name,
				'enrollment_button_link' => '.bs-example-modal-enrollment',
				'reservation_button_link' => '.bs-example-modal-reservation'
			);
		} else {
			$array_output[] = array(
				'full_name' => $full_name,
				'grade_level' => $grade_level,
				'enrollment_button_link' => '.bs-example-modal-enrollmentbasiced',
				'reservation_button_link' => '.bs-example-modal-enrollmentbasicedres'
			);
		}

		return $array_output;
	} // end of function query_select

	function reserve($payment, $reference_number, $student_type)
	{
		if ($student_type == 'highered') {
			$table_name = 'EnrolledStudent_Fees';
		} else {
			$table_name = 'Basiced_EnrolledFees';
		}

		$array_insert_payment = array(
			'Reference_Number' => $reference_number,
			'Reservation_Fee' => $payment
		);
		$this->db->insert($table_name, $array_insert_payment);
	} // end of Function Reserve

	function print_receipt($reference_no, $payment, $student_type)
	{
		if ($student_type == 'highered') {
			$table_name = 'Student_Info';
		} else {
			$table_name = 'Basiced_Studentinfo';
		}

		$query = $this->db->query("SELECT Reference_Number, First_Name, Middle_Name, Last_Name, Gender FROM $table_name WHERE Reference_Number = '$reference_no'");

		$output = '<table>';

		foreach ($query->result() as $row) {
			$fname = $row->First_Name;
			$mname = $row->Middle_Name;
			$lname = $row->Last_Name;
			$gender = $row->Gender;


			$output .= '
				
				<tr>
					<td>Reference Number:</td>
					<td>' . $reference_no . '</td>
				</tr>
				<tr>
					<td>Name:</td>
					<td>' . $lname . ', ' . $fname . ' ' . $mname . '</td>
				</tr>
				<tr>
					<td>Amount:</td>
					<td>' . $payment . '</td>
				</tr>
				<tr>
					<th colspan="2"> &nbsp;</th>
				</tr>
				<tr>
					<th colspan="2"> &nbsp;</th>
				</tr>
				<tr>
					<th colspan="2">&nbsp; </th>
				</tr>
				<tr>
					<th colspan="2">&nbsp; </th>
				</tr>
				
			';
		}

		return $output;
	} // end of print_receipt


	function update_reserve($reference_no, $student_type)
	{
		if ($student_type == 'highered') {
			$table_name = 'Student_Info';
		} else {
			$table_name = 'Basiced_Studentinfo';
		}

		$data = array(
			'Reserve' => 1,
		);

		$this->db->where('Reference_Number', $reference_no);
		$this->db->update($table_name, $data);
	} // end of function update_reserve($reference_no)

	function reference_no_checker($reference_number, $student_type)
	{
		if ($student_type == 'highered') {
			$table_name = 'Student_Info';
		} else {
			$table_name = 'Basiced_Studentinfo';
		}
		$query = $this->db->query("SELECT Reference_Number FROM $table_name WHERE Reference_Number = '$reference_number' LIMIT 1");
		$rowcount = $query->num_rows();
		return $rowcount;
	} // end of function reference_no_checker()



	function set_reference_number_session($reference_number, $client_name)
	{
		$array_session = array(
			'reference_number' => $reference_number,
			'client_name' => $client_name
		);
		$this->session->set_userdata($array_session);
	}

	function bank_list()
	{
		$output = "";
		$this->db->select('Bank_Name');
		$this->db->from('Banks');
		$query = $this->db->get();

		$rowcount = $query->num_rows();
		//check sql
		if ($rowcount > 0) {
			foreach ($query->result() as $row) {
				$bank = $row->Bank_Name;

				$output .= '<option value="' . $bank . '">' . $bank . '</option>';
			}
			return $output;
		} else {
			return NULL;
		}
	} // end of function bank_list

	function payment_checker($bank_amount, $amount_pay)
	{
		if ($bank_amount >= $amount_pay) {
			$output = $bank_amount - $amount_pay;
			return $output;
		} else {
			return NULL;
		}
	}

	function update_bank_deposit_slip($acc_no, $bank, $payment_checker)
	{
		$data = array(
			'Amount' => $payment_checker
		);

		$this->db->where('Depositslip_Number', $acc_no);
		$this->db->where('Bank', $bank);
		$this->db->update('Depositslip', $data);
	}

	function insert_deposit_slip($bank_name, $depositslip_no, $depositslip_amount, $depositslip_date)
	{
		$query = $this->db->query("
			SELECT *
			FROM Depositslip
			WHERE Bank = '$bank_name'
			AND Depositslip_Number = '$depositslip_no' 
		 ");

		$rowcount = $query->num_rows();
		//check sql
		if ($rowcount == 0) {
			$data = array(
				'Bank' => $bank_name,
				'Depositslip_Number' => $depositslip_no,
				'Amount' => $depositslip_amount,
				'Date' => $depositslip_date
			);

			$this->db->insert('Depositslip', $data);

			return '<strong>Success!</strong> Your deposit slip has been successfully saved.';
		} else {
			return '<strong>Fail!</strong>';
		}
	}

	function insert_exam_info($reference_number, $student_type, $other_info, $this_info)
	{
		if ($student_type == 'highered') {
			$table_name = 'Student_Info';
		} else {
			$table_name = 'Basiced_Studentinfo';
		}

		$query = $this->db->query("SELECT Reference_Number FROM $table_name WHERE Reference_Number = '$reference_number' AND Exam = '0' ");

		$rowcount = $query->num_rows();

		if ($rowcount > 0) {
			// $this->load->model('model_date_time');
			$datenow = $this->model_date_time->get_date();

			$data = array(
				'Exam' => '1',
				'Exam_Date' => $datenow
			);

			$this->db->where('Reference_Number', $reference_number);
			$this->db->update($table_name, $data);
		}
	} //end of function insert_exam_info

	function insert_priority_info($reference_number, $student_type, $other_info, $this_info)
	{
		if ($student_type == 'highered') {
			$table_name = 'Student_Info';
		} else {
			$table_name = 'Basiced_Studentinfo';
		}

		$query = $this->db->query("SELECT Reference_Number FROM $table_name WHERE Reference_Number = '$reference_number' ");

		$rowcount = $query->num_rows();

		if ($rowcount > 0) {
			$data = array(
				'Inquiry_ID' => $this_info
			);

			$this->db->where('Reference_Number', $reference_number);
			$this->db->update($table_name, $data);
		}
	} // end of insert_priority_info

	function seniorhigh_track_strand_form()
	{
		$this->load->model('model_program_list');
		$track_list_output = $this->model_program_list->seniorhigh_tracklist();

		$output = '
			
				<select class="form-control" placeholder="Track" name="this_information" id="sel1" onChange="seniorhigh_stand(this.value)">
                	<option value="">Please Select a Track</option>
                    ' . $track_list_output . '
                </select>
			
			
			
			';

		return $output;
	} // end of seniorhigh_track_strand

	function update_seniorhigh_strand($reference_number, $student_type, $track, $strand)
	{
		$table_name = 'Basiced_Studentinfo';
		$query = $this->db->query("SELECT Reference_Number FROM $table_name WHERE Reference_Number = '$reference_number' ");

		$rowcount = $query->num_rows();

		if ($rowcount > 0) {
			$data = array(
				'Track' => $track,
				'Strand' => $strand
			);

			$this->db->where('Reference_Number', $reference_number);
			$this->db->update($table_name, $data);
		}
	}

	function highered_document_list()
	{
		$array_document_list = array(10, 9, 17, 2);
		$this->db->select('*');
		$this->db->from('Document_List');
		$this->db->where_in('ID', $array_document_list);

		$query = $this->db->get();



		return $query->result_array();
	}
}// end of class