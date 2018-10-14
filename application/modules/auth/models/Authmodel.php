<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Authmodel extends MY_Model {

    public function check_email($params = array()) {
        $email = (isset($params["email"])) ? $params["email"] : "";

        try {
            $this->db->select("
                {$this->_table_user}.*
                ", FALSE);
            $this->db->from($this->_table_user);
            $this->db->where("{$this->_table_user}.username", $email);
            $this->db->where("{$this->_table_user}.status", GLOBAL_STATUS_ACTIVE);
            $query = $this->db->get();

            if($query === FALSE)
                throw new Exception();

            $result = $query->row();

            // if ($result) {
            //     $this->db->select("
            //         {$this->_table_role_permission}.*
            //         ");
            //     $this->db->from($this->_table_role_permission);
            //     $this->db->where("role_id", $id);
            //     $query = $this->db->get();

            //     if($query === FALSE)
            //         throw new Exception();

            //     $result_role_permission = $query->result();

            //     $result->{"role_permission"} = $result_role_permission;
            // }

            return $result;         
        } catch(Exception $e) {
            return FALSE;
        }
    }

}