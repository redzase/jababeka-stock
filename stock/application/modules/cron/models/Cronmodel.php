<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cronmodel extends MY_Model 
{

    public function get_detail_setting($params = array()) 
    {
        $code = (isset($params["code"])) ? $params["code"] : "";

        try {
            $this->db->select("
                {$this->_table_setting}.*
                ", FALSE);
            $this->db->from($this->_table_setting);
            $this->db->where("{$this->_table_setting}.status", GLOBAL_STATUS_ACTIVE);
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

    public function get_list_sector_kavling($params = array()) 
    {
        // $start_limit = (isset($params["start_limit"])) ? $params["start_limit"] : "";
        // $end_limit   = (isset($params["end_limit"])) ? $params["end_limit"] : "";

        try {
            // if ($get_total) {
            //     $this->db->select("
            //         COUNT({$this->_table_sector_kavling}.id) AS total
            //         ", FALSE);
            // } else {
                $this->db->select("
                    {$this->_table_sector_kavling}.*,
                    CASE WHEN {$this->_dbase_jababeka_table_kavlings}.kav_ref IS NULL THEN 3
                         WHEN {$this->_table_sector_kavling}.status_booking = 1 THEN 4
                         WHEN {$this->_table_sector_kavling}.status_booking = 0 THEN 1
                         WHEN {$this->_table_sector_kavling}.status_booking = 2 THEN 2
                         ELSE 1
                    END 'status_valid',
                    (SELECT CASE WHEN {$this->_table_logs}.activity = '". LOGS_ACTIVITY_BOOKING ."'
                                    THEN {$this->_table_logs}.created_date
                                 ELSE
                                    null
                            END
                     FROM {$this->_table_logs} JOIN {$this->_table_module}
                                                 ON {$this->_table_logs}.module_id = {$this->_table_module}.id
                     WHERE {$this->_table_module}.code = '". MODULE_CODE_STOCK_SECTOR_KAVLING ."'
                       AND {$this->_table_logs}.foreign_id = {$this->_table_sector_kavling}.id
                     ORDER BY {$this->_table_logs}.created_date DESC 
                     LIMIT 1) AS 'booking_date'
                    ", FALSE);
            // }
            // 1 = Available
            // 2 = Booked
            // 3 = Sold
            // 4 = Reserved
            $this->db->from($this->_table_sector_kavling);
            $this->db->join($this->_dbase_jababeka_table_kavlings, "{$this->_table_sector_kavling}.reference_kavling_id = {$this->_dbase_jababeka_table_kavlings}.kav_ref", "LEFT");
            $this->db->where("{$this->_table_sector_kavling}.status", GLOBAL_STATUS_ACTIVE);
            $this->db->where_in("CASE WHEN {$this->_dbase_jababeka_table_kavlings}.kav_ref IS NULL THEN 3
                                 WHEN {$this->_table_sector_kavling}.status_booking = 1 THEN 4
                                 WHEN {$this->_table_sector_kavling}.status_booking = 0 THEN 1
                                 WHEN {$this->_table_sector_kavling}.status_booking = 2 THEN 2
                                 ELSE 1
                            END", [STATUS_BOOKING_KAVLING_BOOKING]);

            // if ($get_total === FALSE) {
            //     if ($start_limit != "" or $end_limit != "")
            //         $this->db->limit($end_limit, $start_limit);
            // }

            // $this->db->order_by("{$this->_table_sector_kavling}.created_date DESC, {$this->_table_sector_kavling}.id DESC");
            $query = $this->db->get();

            if($query === FALSE)
                throw new Exception();

            $result = $query->result();

            return $result;         
        } catch(Exception $e) {
            return FALSE;
        }
    }

}