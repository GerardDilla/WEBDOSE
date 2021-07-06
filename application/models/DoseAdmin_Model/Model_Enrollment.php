<?php

class Model_Enrollment extends CI_Model
{

	function view_regform($program_code, $program_major, $type, $reference_number, $client_name, $plan, $curriculum)
	{
		//remove later
		//$temp = 0;
		if ($plan == "") {
			# code...
			$plan = "full";
		}
		$section_name = $this->slot_checker_v2($program_code);
		$output = '';
		$total_units = 0;
		$total_lab = 0;
		if (($section_name != "")) {
			//$temp = 1;
			/*
				$query = $this->db->query("
				SELECT B.Year_Level, C.Sched_Code, C.Course_Code, E.Course_Title, B.Section_Name, C.SchoolYear, C.Semester, E.Course_Lec_Unit AS 'Lecture_Unit', E.Course_Lab_Unit AS 'Lab_Unit', D.Day, C.Start_Time, C.End_Time, F.Room, C.Total_Slot FROM 
				Programs AS A 
				INNER JOIN Sections AS B ON A.Program_ID = B.Program_ID
				INNER JOIN Sched AS C ON B.Section_ID = C.Section_ID
				INNER JOIN `DayPrinting` AS D ON  C.DayID = D.ID
				INNER JOIN `Subject` AS E ON C.Course_Code = E.Course_Code
				INNER JOIN Room AS F ON C.RoomID = F.ID
				INNER JOIN Legend AS G ON C.SchoolYear = G.School_Year 
				WHERE A.Program_Code = '$program_code'
				AND C.Semester = G.Semester
				AND B.Section_Name = '$section_name'
				AND C.Valid = 1
			");
			*/

			/*
			$query = $this->db->query("
				SELECT B.Year_Level, C.Sched_Code, C.Course_Code, E.Course_Title, B.Section_Name, C.SchoolYear, C.Semester, E.Course_Lec_Unit AS 'Lecture_Unit', E.Course_Lab_Unit AS 'Lab_Unit', D.Day, C.Start_Time, C.End_Time, F.Room, C.Total_Slot FROM 
				Programs AS A 
				INNER JOIN Sections AS B ON A.Program_ID = B.Program_ID
				INNER JOIN Sched AS C ON B.Section_ID = C.Section_ID
				INNER JOIN `Day` AS D ON C.DayID = D.ID
				INNER JOIN `Subject` AS E ON C.Course_Code = E.Course_Code
				INNER JOIN Room AS F ON C.RoomID = F.ID
				INNER JOIN Legend AS G ON C.SchoolYear = G.School_Year 
				WHERE A.Program_Code = '$program_code'
				AND C.Semester = G.Semester
				AND B.Section_Name = '$section_name'
				AND C.Valid = 1
			");
			*/

			$query = $this->db->query("
				SELECT B.Year_Level, C.Sched_Code, C.Course_Code, E.Course_Title, B.Section_Name, C.SchoolYear, C.Semester, E.Course_Lec_Unit AS 'Lecture_Unit', E.Course_Lab_Unit AS 'Lab_Unit',IFNULL(D.Day,'TBA') AS Day, C.Start_Time, C.End_Time, F.Room, C.Total_Slot FROM 
				Programs AS A 
				INNER JOIN Sections AS B ON A.Program_ID = B.Program_ID
				INNER JOIN Sched AS C ON B.Section_ID = C.Section_ID
				LEFT JOIN `Day` AS D ON C.DayID = D.ID
				INNER JOIN `Subject` AS E ON C.Course_Code = E.Course_Code
				LEFT JOIN Room AS F ON C.RoomID = F.ID
				INNER JOIN Legend AS G ON C.SchoolYear = G.School_Year 
				WHERE A.Program_Code = '$program_code'
				AND C.Semester = G.Semester
				AND B.Section_Name = '$section_name'
				AND C.Valid = 1
			");
			foreach ($query->result() as $row) {
				$Sched_Code = $row->Sched_Code;
				$Course_Code = $row->Course_Code;
				$Course_Title = $row->Course_Title;
				$Lecture_Unit = $row->Lecture_Unit;
				$Lab_Unit = $row->Lab_Unit;
				$Day = $row->Day;
				$Start_Time = $row->Start_Time;
				$End_Time = $row->End_Time;
				$Room = $row->Room;
				$Year_Level = $row->Year_Level;
				$SchoolYear = $row->SchoolYear;
				$Semester = $row->Semester;

				$total_units = $total_units + $Lecture_Unit;
				$total_units = $total_units + $Lab_Unit;



				if ($Lab_Unit > 0) {
					$total_lab = $total_lab + 1;
				}



				$output .= '
					<tr>
					<td>' . $Sched_Code . '</td>
					<td>' . $Course_Code . '</td>
					<td>' . $Course_Title . '</td>
					<td>' . $Lecture_Unit . '</td>
					<td>' . $Lab_Unit . '</td>
					<td>' . $Day . '</td>
					<td>' . $Start_Time . ' - ' . $End_Time . '</td>
					<td>' . $Room . '</td>
					</tr>
				';
			}
			$null = '';

			//check student nationality
			$nationality = $this->get_student_nationality($reference_number);
			if ($nationality != "FILIPINO") {
				$add_foreign_fee = 1;
			} else {
				$add_foreign_fee = 0;
			}

			$array_fee = $this->get_fee_v2($total_units, $SchoolYear, $Semester, $program_code, $program_major, $type, $null, $null, $null, $null, $null, $add_foreign_fee, $section_name);

			foreach ($array_fee as $info) {
				//$other_fee = $info['other_fee'];
				//$misc_fee = $info['misc_fee'];
				//$tuition = $info['tuition'];
				$other_fee = $info['other_fee'];
				$misc_fee = $info['misc_fee'];
				$tuition = $info['tuition'];
			}
			$lab_fee = $this->get_lab_fee_v2($program_code, $section_name);

			//$total_fee =  1000;
			//$overall =  number_format($total_fee + $lab_fee, 2);

			$total_fee = $other_fee + $misc_fee + $lab_fee + $tuition;


			if ($plan == "installment") {
				/*
					$total_add = $total_fee * .05;
					$total_all = $total_fee + $total_add;
					$total_fee = $total_all;
					*/


				$lab_fee = $lab_fee + ($lab_fee * .05);
				$misc_fee = $misc_fee + ($misc_fee * .05);
				$other_fee = $other_fee + ($other_fee * .05);
				$tuition = $tuition + ($tuition * .05);

				$total_fee = $other_fee + $misc_fee + $lab_fee + $tuition;
			}


			$program_major_name = $this->get_major_name($program_major);


			///get curriculum info
			$curriculum_list = $this->get_curriculum($program_code, $program_major_name);

			//check curriculum
			if ($curriculum != 0) {
				$curriculum_year = $this->get_curriculum_year($curriculum);
				$curriculum_year = '<option value=".' . $curriculum . '">' . $curriculum_year . '</option>';
			} else {
				$curriculum_year = '<option>Select</option>';
			}

			//client information in view page
			$client_information = '
					<p>Reference Number: ' . $reference_number . '</p>
					<p>Full Name: ' . $client_name . '</p>
					<p>Nationality: ' . $nationality . '</p>
					<p>Program: ' . $program_code . '</p>
					<p>Program Major: ' . $program_major_name . '</p>
					<p>Section: ' . $section_name . '</p>
					<p>Year: ' . $SchoolYear . '</p>
					<p>Plan: ' . $plan . '</p>
					
					<form method="get" action="">
					<p>Payment Plans: <select name ="plan_highered" class="form-control" placeholder="">
									<option value="">Select</option>
									<option value="full">Full Payment</option>
                                    <option value="installment">Installment Payment</option>
                               		</select> 
					</p>
					<p>
					Curriculum: <select name ="highered_curriculum" class="form-control" placeholder="">
								' . $curriculum_year . '
								' . $curriculum_list . '
								</select>
					</p>
					<p>
					<input type="submit">
					</p>
					</form>
				';


			$array_output[] = array(
				'output' => $output,
				'section_name' => $section_name,
				'school_year' => $SchoolYear,
				'year_level' => $Year_Level,
				'semester' => $Semester,
				'other_fee' => $other_fee,
				'misc_fee' => $misc_fee,
				'lab_fee' => $lab_fee,
				'total_fee' => $total_fee,
				'total_units' => $total_units,
				'client_information' => $client_information
			);
			return $array_output;
		} // end of if($section_name !=0)
		else {
			$client_information = '
					<p>Reference Number: ' . $reference_number . '</p>
					<p>Full Name: ' . $client_name . '</p>
					<p>Program: ' . $program_code . '</p>
					
				';
			$array_output[] = array(
				'output' => 'Not available',
				'section_name' => 'Not available',
				'school_year' => 'Not available',
				'year_level' => 'Not available',
				'semester' => 'Not available',
				'other_fee' => 'Not available',
				'misc_fee' => 'Not available',
				'lab_fee' => 'Not available',
				'total_fee' => 'Not available',
				'total_units' => 'Not available',
				'client_information' => $client_information
			);
			return $array_output;
		}
	} // function view_regform

	function get_major_name($program_major)
	{
		$this->db->select('Program_Major');
		$this->db->from('Program_Majors');
		$this->db->where('ID', $program_major);
		$query = $this->db->get();

		foreach ($query->result() as $row) {
			$major_name = $row->Program_Major;
		}
		return $major_name;
	}

	function get_student_nationality($reference_number)
	{
		$this->db->select('Nationality');
		$this->db->from('Student_Info');
		$this->db->where('Reference_Number', $reference_number);
		$query = $this->db->get();

		foreach ($query->result() as $row) {
			$nationality = $row->Nationality;
		}
		return $nationality;
	}

	function get_curriculum($program_code, $program_major)
	{
		$query = $this->db->query("
			SELECT A.Curriculum_ID, A.Curriculum_Year 
			FROM Curriculum_Info AS A
			INNER JOIN Programs AS B ON A.Program_ID = B.Program_ID
			WHERE B.Program_Code = '$program_code'
			AND A.Program_Major= '$program_major'
			ORDER BY A.Curriculum_Year ASC
		");

		$output = '';
		foreach ($query->result() as $row) {
			$curriculum_id = $row->Curriculum_ID;
			$curriculum_year = $row->Curriculum_Year;

			$output .= '<option value="' . $curriculum_id . '">' . $curriculum_year . '</option>';
		}
		return $output;
	}

	function get_curriculum_year($curriculum_id)
	{
		$this->db->select('Curriculum_Year');
		$this->db->from('Curriculum_Info');
		$this->db->where('Curriculum_ID', $curriculum_id);
		$query = $this->db->get();

		foreach ($query->result() as $row) {
			$curriculum_year = $row->Curriculum_Year;
		}
		return $curriculum_year;
	}

	function slot_checker_v2($program_code)
	{
		$query_section_info = $this->db->query("
			SELECT A.Program_ID, A.Program_Code, B.Section_Name, B.Section_ID, B.Year_Level, C.School_Year, C.Semester, 
			(SELECT Total_Slot FROM Sched WHERE Section_ID = B.Section_ID AND Valid = 1 LIMIT 1) AS 'Total_Slot'
			FROM Programs AS A
			INNER JOIN Sections AS B ON A.Program_ID = B.Program_ID
			JOIN Legend AS C
			WHERE A.Program_Code = '$program_code'
			AND B.Year_Level = '1'
			AND B.Active = '1'
			
		");

		$rowcount_section_checker = $query_section_info->num_rows();

		if ($rowcount_section_checker > 0) {

			foreach ($query_section_info->result() as $row) {
				$program_code = $row->Program_Code;
				$section_name = $row->Section_Name;
				$year_level = $row->Year_Level;
				$school_year = $row->School_Year;
				$semester = $row->Semester;
				$total_slot = $row->Total_Slot;

				$query_enrolled_total_slot = $this->db->query("
					SELECT (COUNT(Sched_Code)) AS 'total_enrolled' 
					FROM EnrolledStudent_Subjects 
					WHERE Section = '$section_name' 
					AND Year_Level = '$year_level' 
					AND Semester = '$semester' 
					AND School_Year ='$school_year'
					GROUP BY Sched_Code 
					ORDER BY total_enrolled DESC
				");

				$rowcount_slot_enrolled = $query_enrolled_total_slot->num_rows();

				if (($rowcount_slot_enrolled > 0)) {
					foreach ($query_enrolled_total_slot->result() as $row) {
						$total_enrolled = $row->total_enrolled;
					}
				} else {
					$total_enrolled = 0;
				}
				/*
				foreach ($query_enrolled_total_slot->result() as $row)
				{
					$total_enrolled = $row->total_enrolled;
					}
				*/

				if (($total_slot > $total_enrolled) || ($total_enrolled == "")) {
					break;
				}
			} //end main foreach

			if ($total_slot > $total_enrolled) {
				return $section_name;
			} else {
				return NULL;
			}
		} //end main if
		else {
			return NULL;
		}
	} // end function

	function slot_checker($program_code)
	{
		$disable_section = '';

		$query_checker = $this->db->query("
			SELECT  B.Section_ID, A.Program_Code,  B.Section_Name, C.Total_Slot  FROM 
			Programs AS A 
			INNER JOIN Sections AS B ON A.Program_ID = B.Program_ID
			INNER JOIN Sched AS C ON B.Section_ID = C.Section_ID
			WHERE C.Total_Slot = '0'
			AND A.Program_Code = '$program_code'
			GROUP BY B.Section_ID, C.Total_Slot");

		$rowcount = $query_checker->num_rows();

		if ($rowcount > 0) {



			foreach ($query_checker->result() as $row) {
				$section_name = $row->Section_Name;
				$slot = $row->Slot_Available;

				if ($slot == '0') {
					$disable_section .= "AND Section_Name != '$section_name' ";
				}
			}
		}
		//return $disable_section;

		$query_section_select = $this->db->query("
			SELECT Section_Name 
			FROM Sections AS A
			INNER JOIN Programs AS B ON A.Program_ID = B.Program_ID
			WHERE Year_Level != '0' 
			AND B.Program_Code = '$program_code'
			$disable_section 
			ORDER BY Section_ID
			LIMIT 1
			
			
		");


		if ($query_section_select->num_rows() > 0) {

			foreach ($query_section_select->result() as $row) {
				$section_name = $row->Section_Name;
				return $section_name;
			}
		} // end of if ($query_section_select->num_rows() > 0)
		else {
			return '0';
		}
	} // end of function slot_checker($program_code)

	function set_reference_number_session($reference_number, $program_code, $client_name, $student_type)
	{
		$array_session = array(
			'reference_number' => $reference_number,
			'program_code' => $program_code,
			'client_name' => $client_name,
			'student_type' => $student_type
		);
		$this->session->set_userdata($array_session);
	} // end of function set_reference_number_session

	function get_fee($total_units, $SchoolYear, $Semester, $program_code, $program_major, $type, $input_reference_number, $input_student_number, $input_year_level, $input_lab_fee, $plan, $add_foreign_fee)
	{
		$query = $this->db->query("
			SELECT TuitionPerUnit , Athletic , Energy , Guidance , IDValidation , Insurance , Internet , Library , Medical , Publication , Registration , Activities , Council , Development , Cultural , ValuesEnrichment , Deposit , Affiliation , AMHeartAscFee , BFCSFee , BLSSFAT , Broadcasting , CAAFee , ClinicalAffiliation , CollegeDay , EducMemFee , FieldStudyFee , ForeignFee , GradFee , HomeRoom , Intrams , MSCert , NSTP , OJTFee , Other1 , Other2 , Other3 , Other4 , Other5 , Philcross , Practicum , Research , SASEMemFee , SeminarFee , Swimming , TeamBuilding , TESDA , ThesisProposal , ThesisWriting , Tour , Transpo , TutFee , workskills , VaccinationA , VaccinationB , VeteransFee , ccncII , bartendingncII , fbsncII , fbsncIII , bpncII , hkncII , foncII , chsncII , caregivingncII  
			FROM Fees_Listing
			WHERE Program_Code = '$program_code'
			AND Semester = '$Semester'
			AND School_Year = '$SchoolYear'
			AND YearLevel = '1'
		");
		$rowcount = $query->num_rows();

		foreach ($query->result() as $row) {
			$TuitionPerUnit = $row->TuitionPerUnit;
			$Athletic = $row->Athletic;
			$Energy = $row->Energy;
			$Guidance = $row->Guidance;
			$IDValidation = $row->IDValidation;
			$Insurance = $row->Insurance;
			$Internet = $row->Internet;
			$Library = $row->Library;
			$Medical = $row->Medical;
			$Publication = $row->Publication;
			$Registration = $row->Registration;
			$Activities = $row->Activities;
			$Council = $row->Council;
			$Development = $row->Development;
			$Cultural = $row->Cultural;
			$ValuesEnrichment = $row->ValuesEnrichment;
			$Deposit = $row->Deposit;
			$Affiliation = $row->Affiliation;
			$AMHeartAscFee = $row->AMHeartAscFee;
			$BFCSFee = $row->BFCSFee;
			$BLSSFAT = $row->BLSSFAT;
			$Broadcasting = $row->Broadcasting;
			$CAAFee = $row->CAAFee;
			$ClinicalAffiliation = $row->ClinicalAffiliation;
			$CollegeDay = $row->CollegeDay;
			$EducMemFee = $row->EducMemFee;
			$FieldStudyFee = $row->FieldStudyFee;
			$ForeignFee = $row->ForeignFee;
			$GradFee = $row->GradFee;
			$HomeRoom = $row->HomeRoom;
			$Intrams = $row->Intrams;
			$MSCert = $row->MSCert;
			$NSTP = $row->NSTP;
			$OJTFee = $row->OJTFee;
			$Other1 = $row->Other1;
			$Other2 = $row->Other2;
			$Other3 = $row->Other3;
			$Other4 = $row->Other4;
			$Other5 = $row->Other5;
			$Philcross = $row->Philcross;
			$Practicum = $row->Practicum;
			$Research = $row->Research;
			$SASEMemFee = $row->SASEMemFee;
			$SeminarFee = $row->SeminarFee;
			$Swimming = $row->Swimming;
			$TeamBuilding = $row->TeamBuilding;
			$TESDA = $row->TESDA;
			$ThesisProposal = $row->ThesisProposal;
			$ThesisWriting = $row->ThesisWriting;
			$Tour = $row->Tour;
			$Transpo = $row->Transpo;
			$TutFee = $row->TutFee;
			$workskills = $row->workskills;
			$VaccinationA = $row->VaccinationA;
			$VaccinationB = $row->VaccinationB;
			$VeteransFee = $row->VeteransFee;
			$ccncII = $row->ccncII;
			$bartendingncII = $row->bartendingncII;
			$fbsncII = $row->fbsncII;
			$fbsncIII = $row->fbsncIII;
			$bpncII = $row->bpncII;
			$hkncII = $row->hkncII;
			$foncII = $row->foncII;
			$chsncII = $row->chsncII;
			$caregivingncII = $row->caregivingncII;
		}
		//$float = (float)$tuition_per_unit;


		$other_array = array($Deposit, $Affiliation, $AMHeartAscFee, $BFCSFee, $BLSSFAT, $Broadcasting, $CAAFee, $ClinicalAffiliation, $CollegeDay, $EducMemFee, $FieldStudyFee, $GradFee, $HomeRoom, $Intrams, $MSCert, $NSTP, $OJTFee, $Other1, $Other2, $Other3, $Other4, $Other5, $Philcross, $Practicum, $Research, $SASEMemFee, $SeminarFee, $Swimming, $TeamBuilding, $TESDA, $ThesisProposal, $ThesisWriting, $Tour, $Transpo, $TutFee, $workskills, $VaccinationA, $VaccinationB,  $ccncII, $bartendingncII, $fbsncII, $fbsncIII, $bpncII, $hkncII, $foncII, $chsncII, $caregivingncII);

		$misc_array = array($Athletic, $Energy, $Guidance, $IDValidation, $Insurance, $Internet, $Library, $Medical, $Publication, $Registration, $Activities, $Council, $Development, $Cultural, $ValuesEnrichment);

		//add foreign fee if foreigner
		if ($add_foreign_fee == '1') {
			array_push($other_array, $ForeignFee);
		}

		//$other_fee =number_format(array_sum($other_array),2);
		//$misc_fee =number_format(array_sum($misc_array),2);
		//$tuition = number_format($TuitionPerUnit * $total_units, 2);

		$other_fee = array_sum($other_array);
		$misc_fee = array_sum($misc_array);
		$tuition = $TuitionPerUnit * $total_units;

		if ($type == 'view') {
			$array_output[] = array(
				'other_fee' => $other_fee,
				'misc_fee' => $misc_fee,
				'tuition' => $tuition

			);
			return $array_output;
		}
		if ($type == 'insert') {
			if ($plan == "full") {
				$fullpayment = 1;
			} else {
				$fullpayment = 0;
				//$input_lab_fee = $input_lab_fee + ($input_lab_fee * .05);
				$misc_fee = $misc_fee + ($misc_fee * .05);
				$other_fee = $other_fee + ($other_fee * .05);
				$tuition = $tuition + ($tuition * .05);
			}

			$array_insert_fees = array(
				'Reference_Number' => $input_reference_number,
				'studentnumber' => $input_student_number,
				'course' => $program_code,
				'semester' => $Semester,
				'schoolyear' => $SchoolYear,
				'YearLevel' => $input_year_level,
				'fullpayment' => $fullpayment,
				'Total_Misc' => $misc_fee,
				'Total_Lab' => $input_lab_fee,
				'Total_Other' => $other_fee,
				//'InitialPayment' => $reference_number,  // insert initial if needed or put downpayment
				'tuition' => $tuition,
				'athletic' => $Athletic,
				'energy' => $Energy,
				'guidance' => $Guidance,
				'idvalidation' => $IDValidation,
				'insurance' => $Insurance,
				'internet' => $Internet,
				'library' => $Library,
				'medical' => $Medical,
				'publication' => $Publication,
				'registration' => $Registration,
				'activities' => $Activities,
				'council' => $Council,
				'development' => $Development,
				'cultural' => $Cultural,
				'valuesenrichment' => $ValuesEnrichment,
				'deposit' => $Deposit,
				'caafee' => $CAAFee,
				//'tutorialfee' => $reference_number,
				'fieldstudyfee' => $FieldStudyFee,
				'educatormemfee' => $EducMemFee,
				'sasememfee' => $SASEMemFee,
				//'practiceteachingfee' => $Practicum,
				//'foodbeveragefee' => $food,
				'vaccinationA' => $VaccinationA,
				'vaccinationB' => $VaccinationB,
				'veteransfee' => $VeteransFee,
				'bfcsfee' => $BFCSFee,
				'foreignfee' => $ForeignFee,
				'seminarfee' => $SeminarFee,
				'nstp' => $NSTP,
				'research' => $Research,
				'intrams' => $Intrams,
				'collegeday' => $CollegeDay,
				'tour' => $Tour,
				'swimming' => $Swimming,
				'thesisproposal' => $ThesisProposal,
				'thesiswriting' => $ThesisWriting,
				'graduationfee' => $GradFee,
				'transportation' => $Transpo,
				'affiliation' => $Affiliation,
				'teambuilding' => $TeamBuilding,
				'TESDA' => $TESDA,
				'clinicalaffiliation' => $ClinicalAffiliation,
				'homeroom' => $HomeRoom,
				'other1' => $Other1,
				'other2' => $Other2,
				'other3' => $Other3,
				'other4' => $Other4,
				'other5' => $Other5,
				'ojt' => $OJTFee,
				'practicum' => $Practicum,
				'philcross' => $Philcross,
				'ccncII' => $ccncII,
				'bartendingncII' => $bartendingncII,
				'fbsncII' => $fbsncII,
				'fbsncIII' => $fbsncIII,
				'bpncII' => $bpncII,
				'hkncII' => $hkncII,
				'foncII' => $foncII,
				'chsncII' => $chsncII,
				'caregivingncII' => $caregivingncII,
				'AMHeartAscFee' => $AMHeartAscFee,
				'broadcasting' => $Broadcasting,
				'mscertification' => $MSCert,
				//'transportation1' => $Transpo,
				//'affiliation1' => $Affiliation,
				'blssfat' => $BLSSFAT,
				'workskills' => $workskills
				//'curpayment' => $Cultural,

			);
			$this->db->insert('EnrolledStudent_Fees', $array_insert_fees);
		}





		//return $rowcount;
	}

	function get_lab_fee($program_code, $section_name)
	{
		$total_lab_fee = 0;
		$query = $this->db->query("SELECT G.subjecttype, G.Fee FROM 
				Programs AS A 
				INNER JOIN Sections AS B ON A.Program_ID = B.Program_ID
				INNER JOIN Sched AS C ON B.Section_ID = C.Section_ID
				INNER JOIN `Subject` AS E ON C.Course_Code = E.Course_Code
				INNER JOIN subjecttype AS G ON G.id = E.Course_Type_ID				
				WHERE A.Program_Code = '$program_code'
				AND B.Section_Name = '$section_name'
				AND E.Course_Type_Id <> 46");

		foreach ($query->result() as $row) {
			$Fee = $row->Fee;
			$total_lab_fee = $Fee + $total_lab_fee;
		}
		return $total_lab_fee;
	}

	function get_lab_fee_v2($program_code, $section_name)
	{
		$total_lab_fee = 0;
		/*
		$query = $this->db->query("SELECT G.subjecttype, L.Fee FROM 
				Programs AS A 
				INNER JOIN Sections AS B ON A.Program_ID = B.Program_ID
				INNER JOIN Sched AS C ON B.Section_ID = C.Section_ID
				INNER JOIN `Subject` AS E ON C.Course_Code = E.Course_Code
				INNER JOIN subjecttype AS G ON G.id = E.Course_Type_ID	
				INNER JOIN Enrolled_LabFeesListing AS L ON G.id = L.Labtype_ID				
				WHERE A.Program_Code = '$program_code'
				AND B.Section_Name = '$section_name'
				AND E.Course_Type_Id <> 46
				GROUP BY G.subjecttype");
		*/

		$query = $this->db->query("SELECT G.subjecttype, L.Fee FROM 
				Programs AS A 
				INNER JOIN Sections AS B ON A.Program_ID = B.Program_ID
				INNER JOIN Sched AS C ON B.Section_ID = C.Section_ID
				INNER JOIN `Subject` AS E ON C.Course_Code = E.Course_Code
				INNER JOIN subjecttype AS G ON G.id = E.Course_Type_ID	
				INNER JOIN Enrolled_LabFeesListing AS L ON G.id = L.Labtype_ID
				INNER JOIN Legend AS Leg ON C.SchoolYear = Leg.School_Year 				
				WHERE A.Program_Code = '$program_code'
				AND B.Section_Name = '$section_name'
				AND C.Valid = 1
				AND E.Course_Type_Id <> 46
				GROUP BY C.Sched_Code");



		foreach ($query->result() as $row) {
			$Fee = $row->Fee;
			$total_lab_fee += $Fee;
		}
		return $total_lab_fee;
	}

	function get_fee_v2($total_units, $SchoolYear, $Semester, $program_code, $program_major, $type, $input_reference_number, $input_student_number, $input_year_level, $input_lab_fee, $plan, $add_foreign_fee, $section_name)
	{
		/*
		$query = $this->db->query("
			SELECT TuitionPerUnit, `NAME`.`Fees_Name`,`ITEMS`.`Fees_Amount`, `NAME`.`Fees_Type`      
			FROM Fees_Listing AS `FEES`
			INNER JOIN Fees_Listing_Items AS `ITEMS`
			ON `ITEMS`.`Fees_Listing_Id` = `FEES`.`id` AND `ITEMS`.`valid` = '1'
			INNER JOIN `Fees_Listings_Items_Name` AS `NAME`
			ON `NAME`.`id` = `ITEMS`.`Fees_Listing_Items_Name_id`
			AND `NAME`.`optional` = 0
			WHERE `FEES`.`Program_Code` = '$program_code'
			AND `FEES`.`Semester` = '$Semester'
			AND `FEES`.`School_Year` = '$SchoolYear'
			AND `FEES`.`YearLevel` = '1'
			AND `FEES`.`valid` = '1'
		");
		*/
		$query = $this->db->query("
			SELECT TuitionPerUnit, `NAME`.`Fees_Name`,`ITEMS`.`Fees_Amount`, `NAME`.`Fees_Type`      
			FROM Fees_Listing AS `FEES`
			INNER JOIN Fees_Listing_Items AS `ITEMS`
			ON `ITEMS`.`Fees_Listing_Id` = `FEES`.`id` AND `ITEMS`.`valid` = '1'
			INNER JOIN `Fees_Listings_Items_Name` AS `NAME`
			ON `NAME`.`id` = `ITEMS`.`Fees_Listing_Items_Name_id`
			AND `NAME`.`optional` = 0			
			WHERE `FEES`.`Program_Code` = '$program_code'
			AND `FEES`.`Semester` = '$Semester'
			AND `FEES`.`School_Year` = '$SchoolYear'
			AND `FEES`.`YearLevel` = '1'
			AND `FEES`.`valid` = '1'
		");
		$rowcount = $query->num_rows();

		$total_misc = 0;
		$total_other = 0;
		foreach ($query->result() as $row) {
			$TuitionPerUnit = $row->TuitionPerUnit;
			$Fees_Amount = $row->Fees_Amount;
			$Fees_Type = $row->Fees_Type;
			$Fees_Name = $row->Fees_Name;

			if ($Fees_Type == "MISC") {
				$total_misc += $Fees_Amount;
			}

			if ($Fees_Type == "OTHER") {
				$total_other += $Fees_Amount;
			}
		}

		$tuition = $TuitionPerUnit * $total_units;
		$tuition = number_format($tuition, 2, '.', '');

		if ($type == 'view') {
			$array_output[] = array(
				'other_fee' => $total_other,
				'misc_fee' => $total_misc,
				'tuition' => $tuition

			);
			return $array_output;
		} // end type= view

		elseif ($type = 'insert') {
			/*
			if($plan == "full")
			{
				$Initial_Payment = 0.00;
				$fullpayment = 1;
				$Initial_Payment += $total_misc + $total_other + $tuition;
				$First_Pay = 0.00;
				$Second_Pay = 0.00;
				$Third_Pay = 0.00;
				$Fourth_Pay = 0.00;
			}//end plan = full
			else
			{
				$fullpayment = 0;
				//$input_lab_fee = $input_lab_fee + ($input_lab_fee * .05);
				$total_misc += ($total_misc * .05);
				$total_other += ($total_other * .05);
				$tuition += ($tuition * .05);
				
				$total_tuition = $tuition + $total_misc + $total_other + $input_lab_fee;
				
				
				
				$array_plan = $this->payment_plans($total_tuition, 'highered', '');
				foreach ($array_plan as $info)
				{
					$Initial_Payment = $info['initial'];
					$First_Pay = $info['first'];
					$Second_Pay = $info['second'];
					$Third_Pay = $info['third'];
					$Fourth_Pay = $info['fourth'];
    			}
				
				
				
				
			}//end else
			*/
			if ($plan == "installment") {
				$fullpayment = 0;
				//$input_lab_fee = $input_lab_fee + ($input_lab_fee * .05);
				$total_misc += ($total_misc * .05);
				$total_other += ($total_other * .05);
				$tuition += ($tuition * .05);

				$total_tuition = $tuition + $total_misc + $total_other + $input_lab_fee;



				$array_plan = $this->payment_plans($total_tuition, 'highered', '');
				foreach ($array_plan as $info) {
					$Initial_Payment = $info['initial'];
					$First_Pay = $info['first'];
					$Second_Pay = $info['second'];
					$Third_Pay = $info['third'];
					$Fourth_Pay = $info['fourth'];
				}
			} //end plan = installment
			else {


				$Initial_Payment = 0.00;
				$fullpayment = 1;
				$Initial_Payment += $total_misc + $total_other + $tuition;
				$First_Pay = 0.00;
				$Second_Pay = 0.00;
				$Third_Pay = 0.00;
				$Fourth_Pay = 0.00;
			} //end else



			//check if if the student is already advised
			$query_check_reference_number = $this->db->query("
				SELECT Reference_Number, id
				FROM Fees_Temp_College
				WHERE Reference_Number = '$input_reference_number'
			");
			$rowcount_check_ref_num = $query_check_reference_number->num_rows();

			if ($rowcount_check_ref_num > 0) {

				foreach ($query_check_reference_number->result() as $row) {
					$insert_id_fees = $row->id;
				}

				$array_update_fees = array(
					'Reference_Number' => $input_reference_number,
					'course' => $program_code,
					'semester' => $Semester,
					'schoolyear' => $SchoolYear,
					'YearLevel' => $input_year_level,
					'fullpayment' => $fullpayment,
					'tuition_Fee' => $tuition,
					'InitialPayment' => $Initial_Payment,
					'First_Pay' => $First_Pay,
					'Second_Pay' => $Second_Pay,
					'Third_Pay' => $Third_Pay,
					'Fourth_Pay' => $Fourth_Pay

				);

				$this->db->where('Reference_Number', $input_reference_number);
				$this->db->update('Fees_Temp_College', $array_update_fees);


				$data_update_fees_item = array(
					'valid' => '0'

				);

				$this->db->where('Fees_Temp_College_Id', $insert_id_fees);
				$this->db->update('Fees_Temp_College_Item', $data_update_fees_item);
			} //end rowcount_check_ref_num >0
			else {




				//insert fees to Fees_Temp_College
				$array_insert_fees = array(
					'Reference_Number' => $input_reference_number,
					'course' => $program_code,
					'semester' => $Semester,
					'schoolyear' => $SchoolYear,
					'YearLevel' => $input_year_level,
					'fullpayment' => $fullpayment,
					'tuition_Fee' => $tuition,
					'InitialPayment' => $Initial_Payment,
					'First_Pay' => $First_Pay,
					'Second_Pay' => $Second_Pay,
					'Third_Pay' => $Third_Pay,
					'Fourth_Pay' => $Fourth_Pay
				);

				$this->db->insert('Fees_Temp_College', $array_insert_fees);

				// get the id of stud info latest insert
				$insert_id_fees = $this->db->insert_id();
			} //end else rowcount >0

			///select lab query
			/*$query_lab_result = $this->db->query("SELECT G.subjecttype, L.Fee FROM 
					Programs AS A 
					INNER JOIN Sections AS B ON A.Program_ID = B.Program_ID
					INNER JOIN Sched AS C ON B.Section_ID = C.Section_ID
					INNER JOIN `Subject` AS E ON C.Course_Code = E.Course_Code
					INNER JOIN subjecttype AS G ON G.id = E.Course_Type_ID	
					INNER JOIN Enrolled_LabFeesListing AS L ON G.id = L.Labtype_ID				
					WHERE A.Program_Code = '$program_code'
					AND B.Section_Name = '$section_name'
					AND E.Course_Type_Id <> 46
					GROUP BY G.subjecttype");*/

			$query_lab_result = $this->db->query("SELECT G.subjecttype, L.Fee FROM 
				Programs AS A 
				INNER JOIN Sections AS B ON A.Program_ID = B.Program_ID
				INNER JOIN Sched AS C ON B.Section_ID = C.Section_ID
				INNER JOIN `Subject` AS E ON C.Course_Code = E.Course_Code
				INNER JOIN subjecttype AS G ON G.id = E.Course_Type_ID	
				INNER JOIN Enrolled_LabFeesListing AS L ON G.id = L.Labtype_ID
				INNER JOIN Legend AS Leg ON C.SchoolYear = Leg.School_Year 				
				WHERE A.Program_Code = '$program_code'
				AND B.Section_Name = '$section_name'
				AND C.Valid = 1
				AND E.Course_Type_Id <> 46
				GROUP BY C.Sched_Code");


			foreach ($query->result() as $row) {
				$TuitionPerUnit = $row->TuitionPerUnit;
				$Fees_Amount = $row->Fees_Amount;
				$Fees_Type = $row->Fees_Type;
				$Fees_Name = $row->Fees_Name;

				if ($plan == "installment") {
					$Fees_Amount *= 1.05;
				}

				$insert_array_fees_item[] = array(
					'Fees_Temp_College_Id' => $insert_id_fees,
					'Fees_Type' => $Fees_Type,
					'Fees_Name' => $Fees_Name,
					'Fees_Amount' => $Fees_Amount
				);
			} //end foreach


			foreach ($query_lab_result->result() as $row) {
				$subjecttype = $row->subjecttype;
				$Fee = $row->Fee;

				if ($plan == "installment") {
					$Fee *= 1.05;
				}

				$insert_array_fees_item[] = array(
					'Fees_Temp_College_Id' => $insert_id_fees,
					'Fees_Type' => "LAB",
					'Fees_Name' => $subjecttype,
					'Fees_Amount' => $Fee
				);
			}


			$this->db->insert_batch('Fees_Temp_College_Item', $insert_array_fees_item);
		} // end type= insert

	} //end function get fee v2

	function payment_plans($tuition, $type, $plan) // type= highered/basiced;
	{

		if ($type == "highered") {
			if ($plan == "") {
				$query = "
				SELECT Upon_Registration, First_Pay, Second_Pay, Third_Pay, Fourth_Pay
				FROM Fees_Legend
				";
				$query_college_plan = $this->db->query($query);

				foreach ($query_college_plan->result() as $row) {
					$Upon_Registration = $row->Upon_Registration;
					$First_Pay = $row->First_Pay;
					$Second_Pay = $row->Second_Pay;
					$Third_Pay = $row->Third_Pay;
					$Fourth_Pay = $row->Fourth_Pay;
				}

				$total_initial = number_format(($tuition * ($Upon_Registration / 100)), 2, '.', '');
				$total_first = number_format(($tuition * ($First_Pay / 100)), 2, '.', '');
				$total_second = number_format(($tuition * ($Second_Pay / 100)), 2, '.', '');
				$total_third = number_format(($tuition * ($Third_Pay / 100)), 2, '.', '');
				$total_fourth = number_format(($tuition * ($Fourth_Pay / 100)), 2, '.', '');

				$array_return[] = array(
					'initial' => $total_initial,
					'first' => $total_first,
					'second' => $total_second,
					'third' => $total_third,
					'fourth' => $total_fourth,
				);
			} //end if plan == ""

		} // end type highered

		return $array_return;
	} // end function payment_plans

	function additional_fees()
	{
		$query = $this->db->query("
			SELECT `NAME`.`Fees_Name`,`ITEMS`.`Fees_Amount`, `NAME`.`Fees_Type`      
			FROM Fees_Listing AS `FEES`
			INNER JOIN Fees_Listing_Items AS `ITEMS`
			ON `ITEMS`.`Fees_Listing_Id` = `FEES`.`id`
			INNER JOIN `Fees_Listings_Items_Name` AS `NAME`
			ON `NAME`.`id` = `ITEMS`.`Fees_Listing_Items_Name_id`
			AND `NAME`.`optional` = 1
			WHERE `FEES`.`Program_Code` = '$program_code'
			AND `FEES`.`Semester` = '$Semester'
			AND `FEES`.`School_Year` = '$SchoolYear'
			AND `FEES`.`YearLevel` = '1'
		");
	}

	/*
	function store_documents($document, $reference_number)
	{
		$transcript = 0;
		$good_moral = 0;
		$birth_cert = 0;
		$picture = 0;
		$hs_diploma = 0;
		$form_138 = 0;
		foreach($document as $value)
		{
			if($value == 'transcript')
			{
				$transcript = 1;
				}

			if($value == 'good_moral')
			{
				$good_moral = 1;
				}
				
			if($value == 'birth_cert')
			{
				$birth_cert = 1;
				}
				
			if($value == 'picture')
			{
				$picture = 1;
				}
				
			if($value == 'hs_diploma')
			{
				$hs_diploma = 1;
				}
				
			if($value == 'form_138')
			{
				$form_138 = 1;
				}
				
			
			}// end of foreach
			
		$data = array(
			'Reference_Number' => $reference_number,
			'Transcript_of_Records' => $transcript,
			'Birth_Certificate' => $birth_cert,
			'Picture' => $picture,
			'Good_Moral' => $good_moral,
			'Highschool_Diploma' => $hs_diploma,
			'Form_138' => $form_138
		);
		$this->db->insert('Documents', $data);
			
			
	}// end of function store_documents
	*/

	function store_documents($array_document, $reference_number, $encoder_username)
	{
		$datestring = "%m/%d/%Y";
		$time = time();
		$date_now = mdate($datestring, $time);

		//check if there is existing data
		$checker = $this->check_document($reference_number);

		if ($checker == TRUE) {
			# code...
			$this->update_document_validity($reference_number);
		}

		$array_insert_batch = array();
		foreach ($array_document as $document) {
			# code...
			$array_insert_batch[] = array(
				'Reference_Number' => $reference_number,
				'Document_ID' => $document,
				'Date' => $date_now,
				'User' => $encoder_username
			);
		}

		$this->db->insert_batch('Documents', $array_insert_batch);
	}

	function check_document($reference_number)
	{
		$this->db->select('*');
		$this->db->from('Documents');
		$this->db->where('Reference_Number', $reference_number);

		$query = $this->db->get();


		if ($query->num_rows() > 0) {
			return true;
		}

		return false;
	}

	function update_document_validity($reference_number)
	{
		$data = array(
			'Valid' => 0
		);

		$this->db->where('Reference_Number', $reference_number);
		$this->db->update('Documents', $data);
	}

	//insert fees in the db
	function cash_payment($reference_number, $payment, $array_output, $transaction_item, $transaction_type, $student_type)
	{

		$this->load->model('model_date_time');
		$date_now = $this->model_date_time->get_date_time();

		if ($transaction_item == 'MATRICULATION') {
			if ($student_type == 'highered') {
				$table_name = 'EnrolledStudent_Payments';
				foreach ($array_output as $info) {
					$school_year = $info['school_year'];
					$semester = $info['semester'];
				}

				//$student_number = $this->student_id_generator();
				//$student_number = '0';
				$student_number = $this->select_student_number($reference_number, 'Student_Number', 'Student_Info');
				$insert_data = array(
					'Reference_Number' => $reference_number,
					'Student_Number' => $student_number,
					'AmountofPayment' => $payment,
					'Transaction_Type' => $transaction_type,
					'Transaction_Item' => $transaction_item,
					'Semester' => $semester,
					'SchoolYear' => $school_year,
					'Date' => $date_now

				);
			} // end of if student type highered
			else {
				$table_name = 'Basiced_Payments';
				foreach ($array_output as $info) {
					$school_year = $info['SchoolYear'];
				}

				//$student_number = $this->basiced_student_id_generator();
				$student_number = $this->select_student_number($reference_number, 'Student_Number', 'Basiced_Studentinfo');
				$insert_data = array(
					'Reference_Number' => $reference_number,
					'Student_Number' => $student_number,
					'AmountofPayment' => $payment,
					'Transaction_Type' => $transaction_type,
					'Transaction_Item' => $transaction_item,
					'SchoolYear' => $school_year,
					'Date' => $date_now

				);
			}
		} // end of if matriculation
		else //for reservation
		{
			if ($student_type == 'highered') {
				$table_name = 'EnrolledStudent_Payments';
				$student_number = 0;
				$insert_data = array(
					'Reference_Number' => $reference_number,
					'AmountofPayment' => $payment,
					'Transaction_Type' => $transaction_type,
					'Transaction_Item' => $transaction_item,
					'Date' => $date_now

				);
			} else {
				$student_number = 0;
				$table_name = 'Basiced_Payments';
				$insert_data = array(
					'Reference_Number' => $reference_number,
					'AmountofPayment' => $payment,
					'Transaction_Type' => $transaction_type,
					'Transaction_Item' => $transaction_item,
					'Date' => $date_now
				);
			}
		}
		// die($table_name.', '.$insert_data);
		$this->db->insert($table_name, $insert_data);

		return $student_number;
	} // enf of function cash_payment

	// to create student id
	function student_id_generator()
	{
		$insert_data = array(
			'Used' => '1'

		);

		$this->db->insert('HigherEDStudentNumber', $insert_data);

		$insert_stud_id = $this->db->insert_id();
		return $insert_stud_id;
	} // end of student id generator

	function select_student_number($reference_number, $column_name, $table_name)
	{
		$this->db->select($column_name);
		$this->db->where('Reference_Number', $reference_number);
		$query_studentnumber = $this->db->get($table_name);

		foreach ($query_studentnumber->result() as $row) {
			$student_number = $row->$column_name;
		}
		return $student_number;
	}

	function basiced_student_id_generator()
	{
		$insert_data = array(
			'Used' => '1'

		);

		$this->db->insert('BasicEDStudentNumber', $insert_data);

		$insert_stud_id = $this->db->insert_id();
		return $insert_stud_id;
	} // end of student id generator

	//to insert sched of enrolled student
	function insert_sched_fee($reference_number, $student_number, $output, $program_code, $program_major)
	{
		$type = 'insert';
		foreach ($output as $info) {
			$section_name = $info['section_name'];
			$total_units = $info['total_units'];
			$lab_fee = $info['lab_fee'];
			//$school_year = $info['school_year'];
			//$year_level = $info['year_level'];
			//$semester = $info['semester'];
		}

		$query = $this->db->query("
				SELECT B.Year_Level, C.Sched_Code, C.Course_Code, B.Section_Name, C.SchoolYear, C.Semester FROM 
				Programs AS A 
				INNER JOIN Sections AS B ON A.Program_ID = B.Program_ID
				INNER JOIN Sched AS C ON B.Section_ID = C.Section_ID
				LEFT JOIN `Day` AS D ON  C.DayID = D.ID
				INNER JOIN `Subject` AS E ON C.Course_Code = E.Course_Code
				LEFT JOIN Room AS F ON C.RoomID = F.ID
				WHERE A.Program_Code = '$program_code'
				AND B.Section_Name = '$section_name'
				AND C.Valid = 1

		");

		foreach ($query->result() as $row) {
			$Sched_Code = $row->Sched_Code;
			$Course_Code = $row->Course_Code;
			$Year_Level = $row->Year_Level;
			$SchoolYear = $row->SchoolYear;
			$Semester = $row->Semester;
			//put the sched to the array
			$insert_array_sched[] = array(
				'Reference_Number' => $reference_number,
				'Student_Number' => $student_number,
				'Sched_Code' => $Sched_Code,
				'Semester' => $Semester,
				'School_Year' => $SchoolYear,
				'Status' => 'Open', // to be edited later
				'Program' => $program_code,
				'Major' => $program_major,
				'Year_Level' => $Year_Level,
				'Section' => $section_name,
				'Status' => 'REGULAR'
			);

			$data_update_valid = array(
				'valid' => 0
			);

			$this->db->where('Reference_Number', $reference_number);
			$this->db->where('Semester', $Semester);
			$this->db->where('School_Year', $SchoolYear);
			$this->db->update('Advising', $data_update_valid);
		} // end of foreach($query->result() as $row)
		// insert the array
		$this->db->insert_batch('Advising', $insert_array_sched);
		//insert fees in db
		//$this->get_fee($total_units, $SchoolYear, $Semester, $program_code, $type, $reference_number, $student_number, $Year_Level, $lab_fee);
		$array_output[] = array(
			'total_units' => $total_units,
			'SchoolYear' => $SchoolYear,
			'Semester' => $Semester,
			'program_code' => $program_code,
			'program_major' => $program_major,
			'type' => $type,
			'reference_number' => $reference_number,
			'student_number' => $student_number,
			'Year_Level' => $Year_Level,
			'lab_fee' => $lab_fee,
			'section_name' => $section_name
		);
		return $array_output;
	} // end of function insert_sched_fee

	function insert_enrollment_fee($array_insert, $plan)
	{
		foreach ($array_insert as $info) {
			$total_units = $info['total_units'];
			$SchoolYear = $info['SchoolYear'];
			$Semester = $info['Semester'];
			$program_code = $info['program_code'];
			$program_major = $info['program_major'];
			$type = $info['type'];
			$reference_number = $info['reference_number'];
			$student_number = $info['student_number'];
			$Year_Level = $info['Year_Level'];
			$lab_fee = $info['lab_fee'];
			$section_name = $info['section_name'];
		}


		//check student nationality
		$nationality = $this->get_student_nationality($reference_number);
		if ($nationality != "FILIPINO") {
			$add_foreign_fee = 1;
		} else {
			$add_foreign_fee = 0;
		}

		$this->get_fee_v2($total_units, $SchoolYear, $Semester, $program_code, $program_major, $type, $reference_number, $student_number, $Year_Level, $lab_fee, $plan, $add_foreign_fee, $section_name);
	} // end of insert_enrollment_fee

	function update_student_info($reference_number, $student_number, $program_code, $program_major, $output, $curriculum)
	{
		foreach ($output as $info) {
			$school_year = $info['school_year'];
			$semester = $info['semester'];
			$year_level = $info['year_level'];
		}

		if ($student_number == 0) {
			$update_info = array(
				'Course' => $program_code,
				'Major' => $program_major,
				'AdmittedSY' => $school_year,
				'AdmittedSEM' => $semester,
				'YearLevel' => $year_level,
				'Curriculum' => $curriculum,
				'Enroll' => 1
			);
		} else {
			$update_info = array(
				'YearLevel' => $year_level,
				'Enroll' => 1
			);
		}


		$this->db->where('Reference_Number', $reference_number);
		$this->db->update('Student_Info', $update_info);
	} // end of function update_student_info

	//update slots
	function update_slots($output)
	{

		foreach ($output as $info) {
			$section_name = $info['section_name'];
		}

		$query_update_slots = $this->db->query("
			SELECT B.Sched_Code, B.Slot_Available  
			FROM Sections AS A 
			INNER JOIN Sched AS B ON A.Section_ID = B.Section_ID
			WHERE A.Section_Name = '$section_name'
		");

		foreach ($query_update_slots->result() as $row) {
			$updated_slot = 0;
			$Sched_Code = $row->Sched_Code;
			$Slot_Available = $row->Slot_Available;
			$updated_slot = $Slot_Available - 1;

			$update_array_slot[] = array(
				'Sched_Code' => $Sched_Code,
				'Slot_Available' => $updated_slot,
			);
		}

		$this->db->update_batch('Sched', $update_array_slot, 'Sched_Code');
	} // end of function update_slots

	function basiced_fees_listing_checker($track, $strand, $grade_level, $school_year)
	{
		$this->db->select('Count(*) as total');
		$this->db->from('Basiced_FeesListing');
		$this->db->where('GradeLevel', $grade_level);
		$this->db->where('SchoolYear', $school_year);
		$this->db->where('Track', $track);
		$this->db->where('Strand', $strand);
		$query = $this->db->get();

		foreach ($query->result() as $row) {
			$total = $row->total;
		}
		//$this->db->flush_cache();
		return $total;
	} // end function basiced checker

	function view_regform_basiced($grade_level, $type, $plan, $reference_number, $client_name, $school_year, $student_number, $track, $strand)
	{

		if (($grade_level != "G11") && ($grade_level != "G12")) {
			$show_track_strand = '';
		} else {
			$this->load->model('model_program_list');
			$track_view = $this->model_program_list->get_track_view($track);
			$strand_view = $this->model_program_list->get_strand_view($strand);
			$show_track_strand = '<p>Track:' . $track_view . '</p> <p>Strand: ' . $strand_view . '</p>';
		}

		if ($this->basiced_fees_listing_checker($track, $strand, $grade_level, $school_year) > 0) {
			$this->db->where('Track', $track);
			$this->db->where('Strand', $strand);
		} elseif ($this->basiced_fees_listing_checker($track, "N/A", $grade_level, $school_year) > 0) {
			$this->db->where('Track', $track);
			$this->db->where('Strand', 'N/A');
		} else {
			$this->db->where('Track', 'N/A');
			$this->db->where('Strand', 'N/A');
		}

		$this->db->select('Total, Tuition, Registration, Energy, Library, LibraryID, Medical, Guidance, Internet, SchoolID, Insurance, Publication, 
			ClassPicture, Development, AntiBullying, Scouting, SpecialStudents, StudentHandbook, TestMaterials, Cultural, ActivityMaterial, MovingUP, 
			Wellness, TestPaper, DigitalCampus, StudentAthletesDevFund, FoundationWeekFee, AthleticFee, TurnItInFee, InternationalCertification, 
			Immersion, LmsAndOtherOnlineResources, Journals, AptitudeTest, Sanitation, MultimediaResource, Assessment, CompLab, ScienceLab, AVLab, Multimedia, RoboticsFee, Other1, Other2, Other3, Other4, Other5, 
			due_s, due_q, due_qf, due_m, due_mf, due_mp');
		$this->db->from('Basiced_FeesListing');
		$this->db->where('GradeLevel', $grade_level);
		$this->db->where('SchoolYear', $school_year);




		//Track and Stand Available

		$query_fees = $this->db->get();

		$rowcount = $query_fees->num_rows();
		//check sql
		if ($rowcount > 0) {
			foreach ($query_fees->result() as $row) {

				$Total = $row->Total;
				$Tuition = $row->Tuition;
				$Registration = $row->Registration;
				$Energy = $row->Energy;
				$Library = $row->Library;
				$LibraryID = $row->LibraryID;
				$Medical = $row->Medical;
				$Guidance = $row->Guidance;
				$Internet = $row->Internet;
				$SchoolID = $row->SchoolID;
				$Insurance = $row->Insurance;
				$Publication = $row->Publication;
				$ClassPicture = $row->ClassPicture;
				$Development = $row->Development;
				$AntiBullying = $row->AntiBullying;
				$Scouting = $row->Scouting;
				$SpecialStudents = $row->SpecialStudents;
				$StudentHandbook = $row->StudentHandbook;
				$TestMaterials = $row->TestMaterials;
				$Cultural = $row->Cultural;
				$ActivityMaterial = $row->ActivityMaterial;
				$MovingUP = $row->MovingUP;
				$Wellness = $row->Wellness;
				$TestPaper = $row->TestPaper;
				$DigitalCampus = $row->DigitalCampus;
				$StudentAthletesDevFund = $row->StudentAthletesDevFund;
				$FoundationWeekFee = $row->FoundationWeekFee;
				$AthleticFee = $row->AthleticFee;
				$TurnItInFee = $row->TurnItInFee;
				$InternationalCertification = $row->InternationalCertification;
				$Immersion = $row->Immersion;
				$LmsAndOtherOnlineResources = $row->LmsAndOtherOnlineResources;
				$Journals = $row->Journals;
				$AptitudeTest = $row->AptitudeTest;
				$Sanitation = $row->Sanitation;
				$MultimediaResource = $row->MultimediaResource;
				$Assessment = $row->Assessment;
				$CompLab = $row->CompLab;
				$ScienceLab = $row->ScienceLab;
				$AVLab = $row->AVLab;
				$Multimedia = $row->Multimedia;
				$RoboticsFee = $row->RoboticsFee;
				$Other1 = $row->Other1;
				$Other2 = $row->Other2;
				$Other3 = $row->Other3;
				$Other4 = $row->Other4;
				$Other5 = $row->Other5;
				$due_s = explode(",", $row->due_s);
				$due_q = explode(",", $row->due_q);
				$due_qf = explode(",", $row->due_qf);
				$due_m = explode(",", $row->due_m);
				$due_mf = explode(",", $row->due_mf);
				$due_mp = explode(",", $row->due_mp);
			}

			$output_total_fee = '
				<tr>
					<td>Total Tuition Fee:</td>
					<td>' . $Total . '</td>
				</tr>
			
				';
			// condition if plan is available	
			if (($plan != 0) || ($plan != "")) {
				if ($plan == 'full_payment') {
					$fee_total = $Total;
					$fee_initial = $Total;
					$fee_first = 0.00;
					$fee_second = 0.00;
					$fee_third = 0.00;
					$fee_fourth = 0.00;
					$fee_fifth = 0.00;
					$fee_sixth = 0.00;
					$fee_seventh = 0.00;

					$plan_name = 'CASH';
					$output_plan_fee = '
						<tr>
							<td>Upon Enrollment</td>
							<td>' . $fee_initial . '</td> 
						</tr>
						';
				} // end of cash

				//start computation of plans
				if ($plan == 'semi_annual') {
					$fee_total = round(($Total * 1.04), 2);
					if (($grade_level == "G11") || ($grade_level == "G12")) {
						# code...
						$fee_initial = $due_s[0];
						$fee_first = $due_s[1];
					} else {
						# code...
						if ($due_s[0] > 0) {
							# code...
							$fee_initial = $due_s[0];
							$fee_first = $due_s[1];
						} else {
							$fee_initial = $fee_total / 2;
							$fee_first = $fee_total - $fee_initial;
						}
					}


					$fee_second = 0.00;
					$fee_third = 0.00;
					$fee_fourth = 0.00;
					$fee_fifth = 0.00;
					$fee_sixth = 0.00;
					$fee_seventh = 0.00;

					$plan_name = 'SEMI-ANNUAL';
					$output_plan_fee = '
						<tr>
							<td>Upon Enrollment</td>
							<td>' . $fee_initial . '</td> 
						</tr>
						<tr>
							<td>First Pay</td>
							<td>' . $fee_first . '</td> 
						</tr>
						';
				} // end of semi annual


				if ($plan == 'quarterly') {
					$fee_initial_name = 'Quarterly' . $grade_level;
					$fee_total = round(($Total * 1.08), 2);
					if (($grade_level == "G11") || ($grade_level == "G12")) {
						# code...
						$fee_initial = $due_q[0];
						$fee_first = $due_q[1];
						$fee_second = $due_q[2];
						$fee_third = $due_q[3];
					} else {
						if ($due_q[0] > 0) {
							# code...
							$fee_initial = $due_q[0];
							$fee_first = $due_q[1];
							$fee_second = $due_q[2];
							$fee_third = $due_q[3];
						} else {
							# code...
							$fee_initial = $this->get_fees_legend($fee_initial_name);
							$fee_initial = round($fee_initial, 2);
							$fee_first = ($fee_total - $fee_initial) / 3;
							$fee_first = round($fee_first, 2);
							$fee_second = $fee_first;
							$fee_third = $fee_total - ($fee_initial + $fee_first + $fee_second);
							$fee_third = round($fee_third, 2);
						}
					}


					$fee_fourth = 0.00;
					$fee_fifth = 0.00;
					$fee_sixth = 0.00;
					$fee_seventh = 0.00;

					$plan_name = 'QUARTERLY';
					$output_plan_fee = '
						<tr>
							<td>Upon Enrollment</td>
							<td>' . $fee_initial . '</td> 
						</tr>
						<tr>
							<td>First Pay</td>
							<td>' . $fee_first . '</td> 
						</tr>
						<tr>
							<td>Second Pay</td>
							<td>' . $fee_second . '</td> 
						</tr>
						<tr>
							<td>Third Pay</td>
							<td>' . $fee_third . '</td> 
						</tr>
						';
				} // end of quarterly

				if ($plan == 'q_flexi') {
					$fee_initial_name = 'QFlexi_Initial';
					$fee_total = round(($Total * 1.08), 2);
					if (($grade_level == "G11") || ($grade_level == "G12")) {
						# code...
						$fee_initial = $due_qf[0];
						$fee_first = $due_qf[1];
						$fee_second = $due_qf[2];
						$fee_third = $due_qf[3];
					} else {
						if ($due_qf[0] > 0) {
							# code...
							$fee_initial = $due_qf[0];
							$fee_first = $due_qf[1];
							$fee_second = $due_qf[2];
							$fee_third = $due_qf[3];
						} else {
							# code...
							$fee_initial =  $this->get_fees_legend($fee_initial_name);
							$fee_initial = round($fee_initial, 2);
							$fee_first = ($fee_total - $fee_initial) / 3;
							$fee_first = round($fee_first, 2);
							$fee_second = $fee_first;
							$fee_third = $fee_total - ($fee_initial + $fee_first + $fee_second);
							$fee_third = round($fee_third, 2);
						}
					}


					$fee_fourth = 0.00;
					$fee_fifth = 0.00;
					$fee_sixth = 0.00;
					$fee_seventh = 0.00;

					$plan_name = 'QUARTERLY-FLEXI';
					$output_plan_fee = '
						<tr>
							<td>Upon Enrollment</td>
							<td>' . $fee_initial . '</td> 
						</tr>
						<tr>
							<td>First Pay</td>
							<td>' . $fee_first . '</td> 
						</tr>
						<tr>
							<td>Second Pay</td>
							<td>' . $fee_second . '</td> 
						</tr>
						<tr>
							<td>Third Pay</td>
							<td>' . $fee_third . '</td> 
						</tr>
						';
				} // end of q_flexi


				if ($plan == 'q_buddy') {
					$fee_initial_name = 'QBuddy_Initial';
					$fee_total = $Total * 1.08;
					$fee_initial =  $this->get_fees_legend($fee_initial_name);
					$fee_initial = round($fee_initial, 2);
					$fee_first = ($fee_total - $fee_initial) / 3;
					$fee_first = round($fee_first, 2);
					$fee_second = $fee_first;
					$fee_third = $fee_total - ($fee_initial + $fee_first + $fee_second);
					$fee_third = round($fee_third, 2);
					$fee_fourth = 0.00;
					$fee_fifth = 0.00;
					$fee_sixth = 0.00;
					$fee_seventh = 0.00;

					$plan_name = 'QUARTERLY-BUDDY';
					$output_plan_fee = '
						<tr>
							<td>Upon Enrollment</td>
							<td>' . $fee_initial . '</td> 
						</tr>
						<tr>
							<td>First Pay</td>
							<td>' . $fee_first . '</td> 
						</tr>
						<tr>
							<td>Second Pay</td>
							<td>' . $fee_second . '</td> 
						</tr>
						<tr>
							<td>Third Pay</td>
							<td>' . $fee_third . '</td> 
						</tr>
						';
				} // end of q_buddy

				if ($plan == 'monthly') {
					if (($grade_level == "G11") || ($grade_level == "G12")) {
						$divisor = 7;
					} else {
						$divisor = 6;
					}
					$fee_initial_name = 'Monthly' . $grade_level;
					$fee_total = round(($Total * 1.12), 2);
					if (($grade_level == "G11") || ($grade_level == "G12")) {
						# code...
						$fee_initial = $due_m[0];
						$fee_first = $due_m[1];
						$fee_second = $due_m[2];
						$fee_third = $due_m[3];
						$fee_fourth = $due_m[4];
						$fee_fifth = $due_m[5];
						$fee_sixth = $due_m[6];
						$fee_seventh = $due_m[7];
					} else {
						if ($due_m[0] > 0) {
							# code...
							$fee_initial = $due_m[0];
							$fee_first = $due_m[1];
							$fee_second = $due_m[2];
							$fee_third = $due_m[3];
							$fee_fourth = $due_m[4];
							$fee_fifth = $due_m[5];
							$fee_sixth = $due_m[6];
							$fee_seventh = $due_m[7];
						} else {
							$fee_initial =  $this->get_fees_legend($fee_initial_name);
							$fee_initial = round($fee_initial, 2);
							$fee_first = ($fee_total - $fee_initial) / $divisor;
							$fee_first = round($fee_first, 2);
							$fee_second = $fee_first;
							$fee_third = $fee_first;
							$fee_fourth = $fee_first;
							$fee_fifth = $fee_first;

							$fee_sixth = $fee_total - ($fee_initial + $fee_first + $fee_second + $fee_third + $fee_fourth + $fee_fifth);
							$fee_seventh = 0.00;
						}
					}






					$plan_name = 'MONTHLY';
					$output_plan_fee = '
						<tr>
							<td>Upon Enrollment</td>
							<td>' . $fee_initial . '</td> 
						</tr>
						<tr>
							<td>First Month Pay</td>
							<td>' . $fee_first . '</td> 
						</tr>
						<tr>
							<td>Second Month Pay</td>
							<td>' . $fee_second . '</td> 
						</tr>
						<tr>
							<td>Third Month Pay</td>
							<td>' . $fee_third . '</td> 
						</tr>
						<tr>
							<td>Fourth Month Pay</td>
							<td>' . $fee_fourth . '</td> 
						</tr>
						<tr>
							<td>Fifth Month Pay</td>
							<td>' . $fee_fifth . '</td> 
						</tr>
						<tr>
							<td>Sixth Month  Pay</td>
							<td>' . $fee_sixth . '</td> 
						</tr>
						';
					if ($grade_level == "G11") {
						# code...
						$output_plan_fee .= '
								<tr>
									<td>Seventh Month  Pay</td>
									<td>' . $fee_seventh . '</td> 
								</tr>
							';
					}
				} // end of monthly

				if ($plan == 'm_flexi') {
					$fee_initial_name = 'MFlexi_Initial';
					$fee_total = round(($Total * 1.12), 2);
					if (($grade_level == "G11") || ($grade_level == "G12")) {
						# code...
						$fee_initial = $due_mf[0];
						$fee_first = $due_mf[1];
						$fee_second = $due_mf[2];
						$fee_third = $due_mf[3];
						$fee_fourth = $due_mf[4];
						$fee_fifth = $due_mf[5];
						$fee_sixth = $due_mf[6];
					} else {
						if ($due_mf[0] > 0) {
							# code...
							$fee_initial = $due_mf[0];
							$fee_first = $due_mf[1];
							$fee_second = $due_mf[2];
							$fee_third = $due_mf[3];
							$fee_fourth = $due_mf[4];
							$fee_fifth = $due_mf[5];
							$fee_sixth = $due_mf[6];
						} else {
							# code...
							$fee_initial =  $this->get_fees_legend($fee_initial_name);
							$fee_initial = round($fee_initial, 2);
							$fee_first = ($fee_total - $fee_initial) / 6;
							$fee_first = round($fee_first, 2);
							$fee_second = $fee_first;
							$fee_third = $fee_first;
							$fee_fourth = $fee_first;
							$fee_fifth = $fee_first;
							$fee_sixth = $fee_total - ($fee_initial + $fee_first + $fee_second + $fee_third + $fee_fourth + $fee_fifth);
						}
					}

					$fee_seventh = 0.00;

					$plan_name = 'MONTHLY-FLEXI';
					$output_plan_fee = '
						<tr>
							<td>Upon Enrollment</td>
							<td>' . $fee_initial . '</td> 
						</tr>
						<tr>
							<td>First Month Pay</td>
							<td>' . $fee_first . '</td> 
						</tr>
						<tr>
							<td>Second Month Pay</td>
							<td>' . $fee_second . '</td> 
						</tr>
						<tr>
							<td>Third Month Pay</td>
							<td>' . $fee_third . '</td> 
						</tr>
						<tr>
							<td>Fourth Month Pay</td>
							<td>' . $fee_fourth . '</td> 
						</tr>
						<tr>
							<td>Fifth Month Pay</td>
							<td>' . $fee_fifth . '</td> 
						</tr>
						<tr>
							<td>Sixth Month  Pay</td>
							<td>' . $fee_sixth . '</td> 
						</tr>
						';
				} // end of m_flexi

				//old plan = m_buddy
				if ($plan == 'm_promo') {
					$fee_initial_name = 'MPromo_Initial';
					$fee_total = round(($Total * 1.12), 2);
					if (($grade_level == "G11") || ($grade_level == "G12")) {
						# code...
						$fee_initial = $due_mp[0];
						$fee_first = $due_mp[1];
						$fee_second = $due_mp[2];
						$fee_third = $due_mp[3];
						$fee_fourth = $due_mp[4];
						$fee_fifth = $due_mp[5];
						$fee_sixth = $due_mp[6];
						$fee_seventh = $due_mp[7];
					} else {
						if ($due_mp[0] > 0) {
							# code...
							$fee_initial = $due_mp[0];
							$fee_first = $due_mp[1];
							$fee_second = $due_mp[2];
							$fee_third = $due_mp[3];
							$fee_fourth = $due_mp[4];
							$fee_fifth = $due_mp[5];
							$fee_sixth = $due_mp[6];
							$fee_seventh = $due_mp[7];
						} else {
							# code...
							$fee_initial =  $this->get_fees_legend($fee_initial_name);
							$fee_initial = round($fee_initial, 2);
							$fee_first = ($fee_total - $fee_initial) / 7;
							$fee_first = round($fee_first, 2);
							$fee_second = $fee_first;
							$fee_third = $fee_first;
							$fee_fourth = $fee_first;
							$fee_fifth = $fee_first;
							$fee_sixth = $fee_first;
							$fee_seventh = $fee_total - ($fee_initial + $fee_first + $fee_second + $fee_third + $fee_fourth + $fee_fifth + $fee_sixth);
						}
					}
					/**/

					//$fee_seventh = $fee_total - ($fee_initial + $fee_first + $fee_second + $fee_third + $fee_fourth + $fee_fifth + $fee_sixth);

					$plan_name = 'MONTHLY-PROMO';
					$output_plan_fee = '
						<tr>
							<td>Upon Enrollment</td>
							<td>' . $fee_initial . '</td> 
						</tr>
						<tr>
							<td>First Month Pay</td>
							<td>' . $fee_first . '</td> 
						</tr>
						<tr>
							<td>Second Month Pay</td>
							<td>' . $fee_second . '</td> 
						</tr>
						<tr>
							<td>Third Month Pay</td>
							<td>' . $fee_third . '</td> 
						</tr>
						<tr>
							<td>Fourth Month Pay</td>
							<td>' . $fee_fourth . '</td> 
						</tr>
						<tr>
							<td>Fifth Month Pay</td>
							<td>' . $fee_fifth . '</td> 
						</tr>
						<tr>
							<td>Sixth Month Pay</td>
							<td>' . $fee_sixth . '</td> 
						</tr>
						<tr>
							<td>Seventh Month Pay</td>
							<td>' . $fee_seventh . '</td> 
						</tr>
						';
				} // end of m_buddy



				$output_total_fee = '
					<tr>
						<td>Total Tuition Fee:</td>
						<td>' . $fee_total . '</td>
					</tr>
				
					';
			} // end of if($plan != 0) 
			else {
				//$fee_initial = 0.00;
				$fee_first = 0.00;
				$fee_second = 0.00;
				$fee_third = 0.00;
				$fee_fourth = 0.00;
				$fee_fifth = 0.00;
				$fee_sixth = 0.00;
				$fee_seventh = 0.00;
				$plan_name = '';
				$output_plan_fee = '';
			}
			// get the school year

			/*
				$query_school_year = $this->db->query("SELECT School_Year FROM Legend");
				
				foreach ($query_school_year->result() as $row)
				{
					$SchoolYear = $row->School_Year;
					}
					
				*/



			$payment_plans_list = $this->get_basiced_payment_plans();
			$payment_plans_list_output = '';
			foreach ($payment_plans_list as $plans) {
				# code...
				$payment_plans_list_output .= '<option value="' . $plans['value'] . '">' . $plans['name'] . '</option>';
			}
			//temporary


			if ($plan != '') {
				# code...
				//$plan_checker = '<option value="'.$plan.'">'.$plan_name.'</option>';
				$payment_plan_array = $this->get_specific_basiced_payment_plan($plan);
				foreach ($payment_plan_array as $plan_type) {
					# code...
					$plan_checker = '<option value="' . $plan_type['value'] . '">' . $plan_type['name'] . '</option>';
				}
			} else {
				$plan_checker = '<option value="">Select</option>';
			}

			$client_information = '
					<p>Reference Number: ' . $reference_number . '</p>
					<p>Full Name: ' . $client_name . '</p>
					<p>Grade Level: ' . $grade_level . '</p>
					' . $show_track_strand . '
					<p>Year: ' . $school_year . '</p>
					<form method="get" action="">
					<p>Payment Plans: <select name = "plan" class="form-control" placeholder="" onchange="this.form.submit()">
				
									' . $plan_checker . $payment_plans_list_output . '
                               </select> 
					</p>
							 
					</form>
					';

			/*$client_information = '
					<p>Reference Number: '.$reference_number.'</p>
					<p>Full Name: '.$client_name.'</p>
					<p>Grade Level: '.$grade_level.'</p>
					'.$show_track_strand.'
					<p>Year: '.$school_year.'</p>
					<form method="get" action="">
					<p>Payment Plans: <select name = "plan" class="form-control" placeholder="" onchange="this.form.submit()">
									<option value="">Select</option>
									<option value="full_payment">Full Payment</option>
                                    <option value="semi_annual">Semi Annual</option>
                                    <option value="quarterly">Quarterly</option>
                                    <option value="q_flexi">Q-Flexi</option>
                                    <option value="monthly">Monthly</option>
                                    <option value="m_flexi">M-Flexi</option>
									<!-- <option value="m_promo">M-Promo</option> -->
									<option value="q_buddy">Q-Buddy</option>
                               </select> 
					</p>
							 
					</form>
					'; */
			// return the outout
			if ($type == 'view') {
				$array_output[] = array(
					'output_plan_fee' => $output_plan_fee,
					'plan_name' => $plan_name,
					'output_total_fee' => $output_total_fee,
					'client_information' => $client_information,
					'SchoolYear' => $school_year,
				);
				return $array_output;
			} else //for type= insert
			{

				$fees_items = array(
					'Tuition' => $Tuition,
					'Registration' => $Registration,
					'Energy' => $Energy,
					'Library' => $Library,
					'LibraryID' => $LibraryID,
					'Medical' => $Medical,
					'Guidance' => $Guidance,
					'Internet' => $Internet,
					'SchoolID' => $SchoolID,
					'Insurance' => $Insurance,
					'Publication' => $Publication,
					'ClassPicture' => $ClassPicture,
					'Development' => $Development,
					'AntiBullying' => $AntiBullying,
					'Scouting' => $Scouting,
					'SpecialStudents' => $SpecialStudents,
					'StudentHandbook' => $StudentHandbook,
					'TestMaterials' => $TestMaterials,
					'Cultural' => $Cultural,
					'ActivityMaterial' => $ActivityMaterial,
					'MovingUP' => $MovingUP,
					'Wellness' => $Wellness,
					'TestPaper' => $TestPaper,
					'DigitalCampus' => $DigitalCampus,
					'StudentAthletesDevFund' => $StudentAthletesDevFund,
					'FoundationWeekFee' => $FoundationWeekFee,
					'AthleticFee' => $AthleticFee,
					'TurnItInFee' => $TurnItInFee,
					'InternationalCertification' => $InternationalCertification,
					'Immersion' => $Immersion,
					'LmsAndOtherOnlineResources' => $LmsAndOtherOnlineResources,
					'Journals' => $Journals,
					'AptitudeTest' => $AptitudeTest,
					'Sanitation' => $Sanitation,
					'MultimediaResource' => $MultimediaResource,
					'Assessment' => $Assessment,
					'CompLab' => $CompLab,
					'ScienceLab' => $ScienceLab,
					'AVLab' => $AVLab,
					'Multimedia' => $Multimedia,
					'RoboticsFee' => $RoboticsFee,
					'Other1' => $Other1,
					'Other2' => $Other2,
					'Other3' => $Other3,
					'Other4' => $Other4,
					'Other5' => $Other5,
				);

				#computation

				$data = array(
					'Payment_Scheme' => $plan_name,
					'GradeLevel' => $grade_level,
					'SchoolYear' => $school_year,
					'Total' => $Total,
					'Reference_Number' => $reference_number,
					'Student_Number' => '0',
					'Initial_Payment' => $fee_initial,
					'First_Payment' => $fee_first,
					'Second_Payment' => $fee_second,
					'Third_Payment' => $fee_third,
					'Fourth_Payment' => $fee_fourth,
					'Fifth_Payment' => $fee_fifth,
					'Sixth_Payment' => $fee_sixth,
					'Seventh_Payment' => $fee_seventh,
					'Student_Number' => $student_number,
					'Track' => $track,
					'Strand' => $strand

				);
				$array_checker = array(
					'reference_number' => $reference_number,
					'grade_level' => $grade_level,
					'school_year' => $school_year,
				);
				// $array_checker = array(
				// 	'reference_number' => '213213235',
				// 	'grade_level' => 'G10',
				// 	'school_year' => '2019-2020',
				// );
				$fees_items = $this->compute_bed_fees_items($plan_name, $fees_items);

				$array_insert = array_merge($data, $fees_items);
				$fees_checker = $this->basiced_fees_checker($array_checker);
				// echo json_encode($fees_checker);
				// die($fees_checker['id']);
				if (empty($fees_checker)) {
					# add Installment_Total col
					$this->db->insert('Basiced_EnrolledFees', $array_insert);
					// die('Empty');
				} else {
					$this->db->where('id', $fees_checker['id']);
					$this->db->update('Basiced_EnrolledFees', $array_insert);
					// die('Not Empty');
				}
			}
		}
	} // end of function basiced
	// Basiced_EnrolledFees Checker
	public function basiced_fees_checker($array)
	{
		$this->db->select('*');
		$this->db->from('Basiced_EnrolledFees');
		$this->db->where("Reference_Number", $array['reference_number']);
		// $this->db->where('GradeLevel', $array['grade_level']);
		$this->db->where('SchoolYear', $array['school_year']);
		$this->db->order_by('id','DESC');
		$query = $this->db->get();
		return $query->row_array();
	}
	private function compute_bed_fees_items($payment_plan, $array_fees)
	{
		if ($payment_plan === "SEMI-ANNUAL") {
			# code...
			$interest = 1.04;
		} elseif ($payment_plan === "QUARTERLY") {
			# code...
			$interest = 1.08;
		} elseif ($payment_plan === "QUARTERLY-FLEXI") {
			# code...
			$interest = 1.08;
		} elseif ($payment_plan === "QUARTERLY-BUDDY") {
			# code...
			$interest = 1.08;
		} elseif ($payment_plan === "MONTHLY") {
			# code...
			$interest = 1.12;
		} elseif ($payment_plan === "MONTHLY-FLEXI") {
			# code...
			$interest = 1.12;
		} elseif ($payment_plan === "MONTHLY-PROMO") {
			# code...
			$interest = 1.12;
		} else {
			$interest = 1;
		}

		foreach ($array_fees as $key => $fee) {
			# code...
			$array_fees[$key] = number_format($fee * $interest, 2, '.', '');
		}

		return $array_fees;
	}

	function get_basiced_payment_plans()
	{
		$this->db->select('*');
		$this->db->from('basiced_payment_plan_type');
		$this->db->where("active", 1);

		$query = $this->db->get();

		// reset query
		//$this->db->reset_query();

		return $query->result_array();
	}
	function get_specific_basiced_payment_plan($plan)
	{
		$this->db->select('*');
		$this->db->from('basiced_payment_plan_type');
		$this->db->where("value", $plan);

		$query = $this->db->get();

		// reset query
		//$this->db->reset_query();

		return $query->result_array();
	}

	function get_fees_legend($value)
	{
		$query = $this->db->query("SELECT $value FROM Fees_Legend");

		foreach ($query->result() as $row) {
			$output = $row->$value;
		}
		return $output;
	}

	function update_basiced_stud_info($reference_number, $student_number, $grade_level, $output, $track, $strand)
	{
		foreach ($output as $info) {
			$school_year = $info['SchoolYear'];
		}

		$this->db->select('Student_number');
		$this->db->where('Reference_Number', $reference_number);
		$query_studentnumber = $this->db->get('Basiced_Studentinfo');

		foreach ($query_studentnumber->result() as $row) {
			$student_number_v2 = $row->Student_number;
		}

		if ($student_number_v2 != 0) {
			$update_info = array(
				'Gradelevel' => $grade_level,
				'Track' => $track,
				'Strand' => $strand
			);
		} else {
			$update_info = array(
				'Student_Number' => $student_number,
				'Gradelevel' => $grade_level,
				'AdmittedSY' => $school_year,
				'Track' => $track,
				'Strand' => $strand,
				'Enroll' => 1
			);
		}



		$this->db->where('Reference_Number', $reference_number);
		$this->db->update('Basiced_Studentinfo', $update_info);
	} // end of function update_student_info

	function insert_card_log($reference_number, $card_number, $bank)
	{
		$this->load->model('model_date_time');
		$datenow = $this->model_date_time->get_date_time();

		$data = array(
			'Reference_Number' => $reference_number,
			'Bank' => $bank,
			'Card_Number' => $card_number,
			'Date' => $datenow
		);
		$this->db->insert('Card_Payment', $data);
	}

	function get_studentnumber($reference_number, $table)
	{
		$this->db->select('Student_Number');
		$this->db->where('Reference_Number', $reference_number);
		$query = $this->db->get($table);

		foreach ($query->result() as $row) {
			$output = $row->Student_Number;
		}
		return $output;
	}

	public function check_basiced_fees($grade_level, $school_year)
	{
		$this->db->select('*');
		$this->db->from('Basiced_FeesListing');
		$this->db->where('GradeLevel', $grade_level);
		$this->db->where('SchoolYear', $school_year);

		$query = $this->db->get();

		// reset query
		//$this->db->reset_query();

		return $query->result_array();
	}
}// end of class