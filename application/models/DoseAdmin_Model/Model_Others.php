<?php 

class Model_Others extends CI_Model{
	
	function str_explode($value, $separator)
	{
		$output = explode($separator, $value);
		return $output;
	}
	
	function nationalities()
	{
		$this->db->select('Nationality');
		$query_nationality = $this->db->get('Nationalities');
		
		$output = "";
		$selected = "";
		foreach ($query_nationality->result() as $row)
		{
			$nationality = $row->Nationality;
			
			if($nationality == 'FILIPINO'){
				$selected = "selected";
			}
			
			$output .='<option value="'.$nationality.'" '.$selected.'>'.$nationality.'</option>';

			$selected = "";

		}
		
		return $output;
	}
	
	// x=to replace y= replace with
	function string_replace($value, $x, $y)
	{
		$output = str_replace($x, $y, $value);
		return $output;
	}
	
	function js_form_checker($condition, $table)
	{
		$query_value = "
			SELECT `COLUMN_NAME` 
				FROM `INFORMATION_SCHEMA`.`COLUMNS` 
					WHERE `TABLE_SCHEMA`='schoolsysdb' 
						AND `TABLE_NAME`='$table'
						$condition
						";
		$query = $this->db->query($query_value);
		
		$output = array();
		
		foreach ($query->result() as $row)
		{
			$output[] = $row->COLUMN_NAME;
			}
			
		return $output;
	}
	
	function select_school_year()
	{
		$query_school_year = $this->db->query("SELECT School_Year FROM Legend");
				
		foreach ($query_school_year->result() as $row)
		{
			$SchoolYear = $row->School_Year;
			}
			
		$explode_value = $this->str_explode($SchoolYear, '-');
		
		$first = $explode_value[0];
		$second = $explode_value[1];
		
		$first = $first + 1;
		$second = $second + 1;
		
		
		$SchoolYear_Second = $first.'-'.$second;
		
		$output = '<option value="'.$SchoolYear.'">'.$SchoolYear.'</option>';
		$output .= '<option value="'.$SchoolYear_Second.'">'.$SchoolYear_Second.'</option>';
		
		return $output;
	}
	
	function foreign_form()
	{
		$output = '<input type="text" class="form-control" placeholder="Sample Foreign" />';	
		//return $output;
	}
	
	function payment_loc_list()
	{
		$this->db->select('PL_ID, Description');
		$query = $this->db->get('Payment_Location');
		
		$output = "";
		foreach ($query->result() as $row)
		{
			$id = $row->PL_ID;
			$desc = $row->Description;
			
			
			$output .='<option value="'.$id.'">'.$desc.'</option>';
			}
		
		return $output;
	}
	
	function year_level()
	{
		$num = 5;
		$x = 1;
		$output = "";
		while($x <= $num)
		{
			$output .= '<option value='.$x.'>'.$x.'</option>';
			
			$x++;
			}
		return $output;
	}
	
}// end of class