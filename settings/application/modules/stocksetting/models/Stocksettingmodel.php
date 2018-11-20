<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Stocksettingmodel extends MY_Model 
{

    public function get_detail($params = array()) 
    {
        $code = (isset($params["code"])) ? $params["code"] : "";

        try {
            $this->db->select("
                {$this->_table_setting}.*
                ", FALSE);
            $this->db->from($this->_table_setting);
            // $this->db->where("{$this->_table_setting}.status", GLOBAL_STATUS_ACTIVE);
            $this->db->where("{$this->_table_setting}.code", $code);
            $query = $this->db->get();

            if($query === FALSE)
                throw new Exception();

            $result = $query->row();

            return $result;         
        } catch(Exception $e) {
            return FALSE;
        }
    }

    public function update($code, $data_update = []) 
    {
        try {
            $this->db->where("code", $code);
            // $this->db->where("status", GLOBAL_STATUS_ACTIVE); 
            $query = $this->db->update($this->_table_setting, $data_update);

            if($query === FALSE)
                throw new Exception();

            return TRUE;
        } catch(Exception $e) {
            return FALSE;
        }
    }

}