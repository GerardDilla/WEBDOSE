<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Holds data for User
 *
 * 
 *
 * @param array $parameters Array containing the necessary params.
 *   $parameters = [
 *     user_data => [
 *      'User_ID'           => (int)  user id. Required.
 *      'User_FullName'     => (string)  name. Required.
 *      'User_Position'     => (string)  position. Optional.
 *      'User_Department'   => (string)  username. Optional.
 *      'UserName'          => (string)  username. Required.
 *     ]
 *  ]
 * @param int $user_id ID of the user
 * @param string $name Name of the user
 * @param string $username Username of the user
 * @param string $position Employee position of the user
 * @param string $department department of the user
 */


class User
{
    protected $user_id;
    protected $name;
    protected $username;
    protected $position;
    protected $department;
    

    public function __construct($parameters)
    {
        $array_user_data = $parameters['user_data'];
        $this->set_user_id($array_user_data['User_ID']);
        $this->set_name($array_user_data['User_FullName']);
        $this->set_username($array_user_data['UserName']);
        $this->set_position($array_user_data['User_Position']);
        $this->set_department($array_user_data['User_Department']);
        
        
    }

    protected function set_user_id($user_id)
    {
        $this->user_id = $user_id;
        return $this;
    }

    public function get_user_id()
    {
        return $this->user_id;
    }

    protected function set_name($name)
    {
        $this->name = $name;
        return $this;
    }

    public function get_name()
    {
        return $this->name;
    }

    protected function set_username($username)
    {
        $this->username = $username;
        return $this;
    }

    public function get_username()
    {
        return $this->username;
    }

    protected function set_position($position)
    {
        if ($position) {
            # code...
            $this->position = $position;
        }
        else {
            # code...
            $this->position = "Position not set";
        }
        
        return $this;
    }

    public function get_position()
    {
        return $this->position;
    }

    protected function set_department($department)
    {
        if ($department) {
            # code...
            $this->department = $department;
        }
        else {
            # code...
            $this->department ="Department not set";
        }
        
        return $this;
    }

    public function get_department()
    {
        return $this->department;
    }

}