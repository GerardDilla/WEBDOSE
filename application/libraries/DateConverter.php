<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DateConverter 
{
	
	public function MilitaryToStandard($time='')
	{
		if($time == '700'){return '7:00AM';}
		if($time == '730'){return '7:30AM';}
		if($time == '800'){return '8:00AM';}
		if($time == '830'){return '8:30AM';}
		if($time == '900'){return '9:00AM';}
		if($time == '930'){return '9:30AM';}
		if($time == '1000'){return '10:00AM';}
		if($time == '1030'){return '10:30AM';}
		if($time == '1100'){return '11:00AM';}
		if($time == '1130'){return '11:30AM';}
		if($time == '1200'){return '12:00PM';}
		if($time == '1230'){return '12:30PM';}
		if($time == '1300'){return '1:00PM';}
		if($time == '1330'){return '1:30PM';}
		if($time == '1400'){return '2:00PM';}
		if($time == '1430'){return '2:30PM';}
		if($time == '1500'){return '3:00PM';}
		if($time == '1530'){return '3:30PM';}
		if($time == '1600'){return '4:00PM';}
		if($time == '1630'){return '4:30PM';}
		if($time == '1700'){return '5:00PM';}
		if($time == '1730'){return '5:30PM';}
		if($time == '1800'){return '6:00PM';}
		if($time == '1830'){return '6:30PM';}
		if($time == '1900'){return '7:00PM';}
		if($time == '1930'){return '7:30PM';}
		if($time == '2000'){return '8:00PM';}
		if($time == '2030'){return '8:30PM';}
		if($time == '2100'){return '9:00PM';}
	}
	
}
