<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_roles extends User
{
    private $array_roles;
    private $user_roles;
    private $roles_to_add;
    private $roles_to_remove;
    private $action_log = array();

    public function __construct($parameters = "")
    {
        //$this->set_array_roles($parameters['array_roles']);
        //$this->set_user_roles($parameters['user_roles']);
        if ($parameters) 
        {
            # code...
            parent::__construct( $parameters );
        }
        
        
    }

    public function set_array_roles($array_roles)
    {
        $this->array_roles = $array_roles;
        return $this;
    }

    public function get_array_roles()
    {
        return $this->array_roles;
    }

    public function set_user_roles($user_roles)
    {
        $this->user_roles = $user_roles;
        return $this;
    }

    public function get_user_roles()
    {
        return $this->user_roles;
    }

    public function set_user_display_roles()
    {
        $display_roles = array();

        #set column for user role
        $user_roles = array_column($this->user_roles, 'parent_module_id');

        foreach ($this->array_roles as $key => $roles) {
            # code...
            $user_role_key = array_search($roles['parent_module_id'], $user_roles);
            /*
            echo "<br>";
            echo "role=".$roles['parent_module_id'];
            echo "<br>";
            echo "user_role=".$user_role_key;
            echo "<br>";
            */
            if (is_numeric($user_role_key)) {
                # code...
                $this->array_roles[$key]['selected']= 1;
            }
            else {
                # code...
                $this->array_roles[$key]['selected']= 0;
            }
        }
        

        return $this;
    }

    public function set_roles_to_add(array $array_roles)
    {
        $array_output = array();

        foreach ($array_roles as $key => $role_id) {
            # code...
            $array_output[] = array(
                'User_id' => $this->user_id,
                'parent_module_id' => $role_id,
                'valid' => 1
            );
        }

        $this->roles_to_add = $array_output;
        return $this;
    }

    public function get_roles_to_add()
    {
        return $this->roles_to_add;
    }

    public function set_roles_to_remove(array $array_roles)
    {
        $array_output = array();
        foreach ($array_roles as $key => $role_id) {
            # code...
            $array_output[] = array(
                'User_id' => $this->user_id,
                'parent_module_id' => $role_id,
                'valid' => 1
            );
        }

        $this->roles_to_remove = $array_output;
        return $this;
    }

    public function get_roles_to_remove()
    {
        return $this->roles_to_remove;
    }

    public function set_action_log()
    {
        if ($this->roles_to_add) {
            # code...
            $this->action_log['add'] = $this->roles_to_add;
        }

        if ($this->roles_to_remove) {
            # code...
            $this->action_log['remove'] = $this->roles_to_remove;
        }

        return $this;
    }

    public function get_action_log()
    {
        return json_encode($this->action_log);
    }
}