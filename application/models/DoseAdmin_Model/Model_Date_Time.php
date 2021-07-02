<?php 
class Model_date_time extends CI_Model{
	
	function get_date()
	{
		$datestring = "%Y-%m-%d";
		$time = time();
		$date_now = mdate($datestring, $time);
		
		return $date_now;
		}
	
	function get_date_time()
	{
		$datestring = "%Y-%m-%d %H:%i:%s";
		$time = time();
		$date_now = mdate($datestring, $time);
		
		return $date_now;
		}
		
	function get_year()
	{
		$datestring = "%Y";
		$time = time();
		$date_now = mdate($datestring, $time);
		
		return $date_now;
		}
	
}// end of class