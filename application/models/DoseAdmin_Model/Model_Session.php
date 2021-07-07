<?php 

class Model_Session extends CI_Model{
	
	function set_sess($name, $value)
	{
		$this->session->set_userdata($name, $value);
	}
	
	function unset_sess($name)
	{
		$this->session->unset_userdata($name);
	}
	
}