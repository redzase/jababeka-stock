<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Logsmodel extends MY_Model 
{

    public function get_list($params = array()) 
    {
        $sector_id   = (isset($params["sector_id"])) ? $params["sector_id"] : "";
        $kavling_id  = (isset($params["kavling_id"])) ? $params["kavling_id"] : "";
        $start_limit = (isset($params["start_limit"])) ? $params["start_limit"] : "";
        $end_limit   = (isset($params["end_limit"])) ? $params["end_limit"] : "";
        $get_total   = (isset($params["get_total"])) ? TRUE : FALSE;

        try {
            if ($get_total) {
                $this->db->select("
                    COUNT({$this->_table_logs}.id) AS total
                    ", FALSE);
            } else {
                // $this->db->select("
                //     {$this->_table_logs}.*,
                //     {$this->_table_module}.code AS module_code,
                //     {$this->_table_module}.name AS module_name,
                //     {$this->_table_user}.username,
                //     CASE WHEN {$this->_table_module}.code = 'STOCK_SECTOR_KAVLING' 
                //             THEN (SELECT CONCAT({$this->_table_sector_kavling}.street_name, ', ', {$this->_table_sector_kavling}.block_name, ', ', {$this->_table_sector_kavling}.house_number)
                //                   FROM {$this->_table_sector_kavling}
                //                   WHERE id = {$this->_table_logs}.foreign_id)
                //          ELSE
                //         ''
                //     END AS foreign_id_name
                //     ", FALSE);
                $this->db->select("
                    {$this->_table_logs}.*,
                    {$this->_table_module}.code AS module_code,
                    {$this->_table_module}.name AS module_name,
                    {$this->_table_user}.username,
                    {$this->_table_sector}.name AS sector_name,
                    CONCAT({$this->_table_sector_kavling}.street_name, ', ', {$this->_table_sector_kavling}.block_name, ', ', {$this->_table_sector_kavling}.house_number) AS foreign_id_name
                    ", FALSE);
            }
            $this->db->from($this->_table_logs);
            $this->db->join($this->_table_module, "{$this->_table_logs}.module_id = {$this->_table_module}.id");
            $this->db->join($this->_table_user, "{$this->_table_logs}.created_by = {$this->_table_user}.id");
            $this->db->join($this->_table_sector_kavling, "{$this->_table_logs}.foreign_id = {$this->_table_sector_kavling}.id");
            $this->db->join($this->_table_sector, "{$this->_table_sector_kavling}.sector_id = {$this->_table_sector}.id");
            $this->db->where("{$this->_table_sector_kavling}.sector_id", $sector_id);

            if (!empty($kavling_id) and $kavling_id <> "no_kavling") {
                $this->db->where("{$this->_table_sector_kavling}.id", $kavling_id);
            }

            if ($get_total === FALSE) {
                if ($start_limit != "" or $end_limit != "")
                    $this->db->limit($end_limit, $start_limit);
            }

            $this->db->order_by("{$this->_table_logs}.created_date DESC");
            $query = $this->db->get();

            if($query === FALSE)
                throw new Exception();

            if ($get_total) {
                $result = $query->row();
                $result = ($result) ? $result->total : 0;
            } else
                $result = $query->result();

            return $result;         
        } catch(Exception $e) {
            return FALSE;
        }
    }

    public function get_detail_module($params = array()) {
        $code = (isset($params["code"])) ? $params["code"] : "";

        try {
            $this->db->select("
                {$this->_table_module}.*
                ", FALSE);
            $this->db->from($this->_table_module);
            $this->db->where("{$this->_table_module}.status", GLOBAL_STATUS_ACTIVE);
            $this->db->where("{$this->_table_module}.code", $code);
            $query = $this->db->get();

            if($query === FALSE)
                throw new Exception();

            $result = $query->row();

            return $result;         
        } catch(Exception $e) {
            return FALSE;
        }
    }

    public function create($data_create = []) 
    {
        try {
            $query = $this->db->insert($this->_table_logs, $data_create);

            if($query === FALSE)
                throw new Exception();

            return True;
        } catch(Exception $e) {
            return FALSE;
        }
    }

}