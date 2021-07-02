<?php

class Model_Program_List extends CI_Model
{

	/*function program_list()
	{
		
		$output = "";
		$string_major = ' Major in ';
		$separator = '_';
		
		$query = $this->db->query("SELECT A.Program_Code, A.Program_Name, B.ID, B.Program_Major FROM Programs AS A
LEFT JOIN Program_Majors AS B ON A.Program_Code = B.Program_Code");
		
		foreach ($query->result() as $row)
		{
			$program_name = $row->Program_Name;
			$program_code = $row->Program_Code;
			$major_id = $row->ID;
			$program_major = $row->Program_Major;
			
			if($major_id != NULL)
			{
				$output .='<option value="'.$program_code.$separator.$major_id.'">'.$program_name.$string_major.$program_major.'</option>';
				}
			
			$output .='<option value="'.$program_code.$separator.'">'.$program_name.'</option>';
			}
		
		return $output;
				
			
	}*/
	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->library('set_custom_session');

		$this->load->model('DoseAdmin_Model/Model_Session', 'model_session');
	}

	function program_list()
	{
		$this->db->select('Program_Name, Program_Code');
		$this->db->order_by("Program_Name", "asc");
		$query_programs = $this->db->get('Programs');

		$output = "";
		foreach ($query_programs->result() as $row) {
			$program_name = $row->Program_Name;
			$program_code = $row->Program_Code;
			if (strpos($program_code, 'YIBU') === false) {
			}
			$output .= '<option value="' . $program_code . '">' . $program_name . '</option>';
		}

		return $output;
	}
	function program_list_no_yibu()
	{
		$this->db->select('Program_Name, Program_Code');
		$this->db->order_by("Program_Name", "asc");
		$this->db->where('international_program !=', '1');
		$query_programs = $this->db->get('Programs');

		$output = "";
		foreach ($query_programs->result() as $row) {
			$program_name = $row->Program_Name;
			$program_code = $row->Program_Code;
			if (strpos($program_code, 'YIBU') === false) {
			}
			$output .= '<option value="' . $program_code . '">' . $program_name . '</option>';
		}

		return $output;
	}

	function course_major($course, $major)
	{
		$query = $this->db->query("SELECT B.ID, B.Program_Major FROM Programs AS A
		INNER JOIN Program_Majors AS B ON A.Program_Code = B.Program_Code WHERE A.Program_Code ='$course' ");

		$rowcount = $query->num_rows();
		//check sql
		if ($rowcount > 0) {
			$output = '<select name="' . $major . '" class="form-control" id="sel1" onChange="set_major(\'' . $major . '\', this.value)" >';
			foreach ($query->result() as $row) {
				$major_id = $row->ID;
				$program_major = $row->Program_Major;
				$output .= '<option value="' . $major_id . '">' . $program_major . '</option>';
			}
			$output .= '</select>';
			//session
			$row = $query->row(0);
			$session_major_id = $row->ID;

			// $this->load->model('model_session');
			$this->model_session->set_sess($major, $session_major_id);
		} else {
			$output = '<select name="' . $major . '" class="form-control" id="sel1" > <option value = "0"> N/A </option> </select>';
			// $this->load->model('model_session');
			$this->model_session->set_sess($major, 0);
		}
		return $output;
	}


	function grade_level($condition)
	{
		$this->db->select('Grade_Level, Grade_LevelCode');
		if ($condition != NULL) {
			$this->db->where($condition);
		}

		$query_programs = $this->db->get('Basiced_Level');

		$output = "";
		foreach ($query_programs->result() as $row) {
			$Grade_Level = $row->Grade_Level;
			$Grade_LevelCode = $row->Grade_LevelCode;

			$output .= '<option value="' . $Grade_LevelCode . '">' . $Grade_Level . '</option>';
		}

		return $output;
	} // end of grade_level

	function get_priority_list()
	{
		$this->db->select('ID, Inquiry');
		$query_priority_list = $this->db->get('Inquiry_Priority');

		$output = "";
		foreach ($query_priority_list->result() as $row) {
			$ID = $row->ID;
			$Inquiry = $row->Inquiry;

			$output .= '<option value="' . $ID . '">' . $Inquiry . '</option>';
		}

		return $output;
	} // end of get_priority_list


	function seniorhigh_tracklist()
	{

		$query = $this->db->query("SELECT ID, Track FROM SeniorHigh_Tracks");

		$rowcount = $query->num_rows();

		//check sql
		if ($rowcount > 0) {
			$output = '';
			foreach ($query->result() as $row) {
				$track_id = $row->ID;
				$track_name = $row->Track;
				$output .= '<option value="' . $track_id . '">' . $track_name . '</option>';
			}
		} else {
			$output = '<option value = "N/A"> N/A </option>';
		}

		return $output;
	}

	function seniorhigh_strand($track)
	{
		// value for select name, session
		$value = 'strand';
		$query = $this->db->query("SELECT B.Strand_Code, B.Strand_Title FROM SeniorHigh_Tracks AS A INNER JOIN SeniorHigh_Strand AS B ON A.ID = B.Track_ID WHERE A.ID = '$track'
");

		$rowcount = $query->num_rows();

		//check sql
		if ($rowcount > 0) {
			$output = '<select name="' . $value . '" class="form-control" id="shsStrand" onChange="set_strand(this.value)" >';
			foreach ($query->result() as $row) {
				$strand_code = $row->Strand_Code;
				$strand_title = $row->Strand_Title;
				$output .= '<option value="' . $strand_code . '">' . $strand_title . '</option>';
			}
			$output .= '</select>';
			//session
			$row = $query->row(0);
			$session_strand_code = $row->Strand_Code;

			// $this->load->model('model_session');
			$this->model_session->set_sess($value, $session_strand_code);
		} else {
			$output = '<select name="' . $value . '" class="form-control" id="shsStrand" > <option value = "N/A"> N/A </option> </select>';
			// $this->load->model('model_session');
			$this->model_session->set_sess($value, 'N/A');
		}

		return $output;
	} //end seniorhight strand

	function seniorhigh_strand_without_form($track)
	{
		// value for select name, session
		$value = 'strand';
		$query = $this->db->query("SELECT B.Strand_Code, B.Strand_Title FROM SeniorHigh_Tracks AS A INNER JOIN SeniorHigh_Strand AS B ON A.ID = B.Track_ID WHERE A.ID = '$track'
");

		$rowcount = $query->num_rows();

		//check sql
		if ($rowcount > 0) {
			$output = ' ';
			foreach ($query->result() as $row) {
				$strand_code = $row->Strand_Code;
				$strand_title = $row->Strand_Title;
				$output .= '<option value="' . $strand_code . '">' . $strand_title . '</option>';
			}
			//session
			$row = $query->row(0);
			$session_strand_code = $row->Strand_Code;

			// $this->load->model('model_session');
			$this->model_session->set_sess($value, $session_strand_code);
		} else {
			$output = '<option value = "N/A"> N/A </option>';
			// $this->load->model('model_session');
			$this->model_session->set_sess($value, 'N/A');
		}

		return $output;
	} // end track without form

	function ajax_seniorhigh_track($grade_level)
	{
		$value = "track";
		$output = '<select required class="form-control" placeholder="' . $value . '" name="' . $value . '" id="shsTrack" onChange="seniorhigh_stand_assessment(this.value)">';
		$output .= '<option value=""> Select Track </option>';
		$output .= $this->seniorhigh_tracklist();
		$output .= '</select>';
		return $output;
	}

	function get_track_view($track)
	{

		$this->db->select('Track');
		$this->db->where('ID', $track);
		$this->db->from('SeniorHigh_Tracks');
		$query = $this->db->get();

		$rowcount = $query->num_rows();

		//check sql
		if ($rowcount > 0) {
			foreach ($query->result() as $row) {
				$track_name = $row->Track;
			}
		} else {
			$track_name = 'N/A';
		}

		return $track_name;
	}

	function get_strand_view($strand)
	{

		$this->db->select('Strand_Title');
		$this->db->where('Strand_Code', $strand);
		$this->db->from('SeniorHigh_Strand');
		$query = $this->db->get();

		$rowcount = $query->num_rows();

		//check sql
		if ($rowcount > 0) {
			foreach ($query->result() as $row) {
				$strand_title = $row->Strand_Title;
			}
		} else {
			$strand_title = 'N/A';
		}

		return $strand_title;
	}
	//BELL-BELL 2.22.21
	function get_email_chair_person($program_code)
	{
		$query = $this->db
			->select('*')
			->from('Programs')
			->where('Program_Code', $program_code)
			->get()->row_array();
		return $query;
	}
}// end of class