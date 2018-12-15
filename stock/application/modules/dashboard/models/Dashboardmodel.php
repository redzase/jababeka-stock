<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboardmodel extends MY_Model 
{
    public function get_total_sector() 
    {
        try {
            $this->db->select("
                COUNT({$this->_table_sector}.id) AS total
                ", FALSE);
            $this->db->from($this->_table_sector);
            $this->db->where("{$this->_table_sector}.status", GLOBAL_STATUS_ACTIVE);
            $query = $this->db->get();

            if($query === FALSE)
                throw new Exception();

            $result = $query->row();
            $result = ($result) ? $result->total : 0;

            return $result;         
        } catch(Exception $e) {
            return FALSE;
        }
    }

    public function get_total_kavling() 
    {
        try {
            $this->db->select("
                COUNT({$this->_table_sector_kavling}.id) AS total
                ", FALSE);
            $this->db->from($this->_table_sector_kavling);
            $this->db->where("{$this->_table_sector_kavling}.status", GLOBAL_STATUS_ACTIVE);
            $query = $this->db->get();

            if($query === FALSE)
                throw new Exception();

            $result = $query->row();
            $result = ($result) ? $result->total : 0;

            return $result;         
        } catch(Exception $e) {
            return FALSE;
        }
    }

    public function get_total_kavling_available() 
    {
        try {
            $this->db->select("
                COUNT({$this->_table_sector_kavling}.id) AS total
                ", FALSE);
            $this->db->from($this->_table_sector_kavling);
            $this->db->join($this->_dbase_jababeka_table_kavlings, "{$this->_table_sector_kavling}.reference_kavling_id = {$this->_dbase_jababeka_table_kavlings}.kav_ref");
            $this->db->where("{$this->_table_sector_kavling}.status", GLOBAL_STATUS_ACTIVE);
            $this->db->where("{$this->_table_sector_kavling}.status_booking", 0);
            $query = $this->db->get();

            if($query === FALSE)
                throw new Exception();

            $result = $query->row();
            $result = ($result) ? $result->total : 0;

            return $result;         
        } catch(Exception $e) {
            return FALSE;
        }
    }

    public function get_total_kavling_sold() 
    {
        try {
            $this->db->select("
                COUNT({$this->_table_sector_kavling}.id) AS total
                ", FALSE);
            $this->db->from($this->_table_sector_kavling);
            $this->db->join($this->_dbase_jababeka_table_kavlings, "{$this->_table_sector_kavling}.reference_kavling_id = {$this->_dbase_jababeka_table_kavlings}.kav_ref", "LEFT");
            $this->db->where("{$this->_table_sector_kavling}.status", GLOBAL_STATUS_ACTIVE);
            $this->db->where("{$this->_dbase_jababeka_table_kavlings}.kav_ref IS NULL", NULL, FALSE);
            $query = $this->db->get();

            if($query === FALSE)
                throw new Exception();

            $result = $query->row();
            $result = ($result) ? $result->total : 0;

            return $result;         
        } catch(Exception $e) {
            return FALSE;
        }
    }

    public function get_total_kavling_booked() 
    {
        try {
            $this->db->select("
                COUNT({$this->_table_sector_kavling}.id) AS total
                ", FALSE);
            $this->db->from($this->_table_sector_kavling);
            $this->db->join($this->_dbase_jababeka_table_kavlings, "{$this->_table_sector_kavling}.reference_kavling_id = {$this->_dbase_jababeka_table_kavlings}.kav_ref");
            $this->db->where("{$this->_table_sector_kavling}.status", GLOBAL_STATUS_ACTIVE);
            $this->db->where("{$this->_table_sector_kavling}.status_booking", 2);
            $query = $this->db->get();

            if($query === FALSE)
                throw new Exception();

            $result = $query->row();
            $result = ($result) ? $result->total : 0;

            return $result;         
        } catch(Exception $e) {
            return FALSE;
        }
    }

    public function get_total_kavling_available_requested() 
    {
        try {
            $this->db->select("
                COUNT({$this->_table_sector_kavling}.id) AS total
                ", FALSE);
            $this->db->from($this->_table_sector_kavling);
            $this->db->join($this->_dbase_jababeka_table_kavlings, "{$this->_table_sector_kavling}.reference_kavling_id = {$this->_dbase_jababeka_table_kavlings}.kav_ref");
            $this->db->where("{$this->_table_sector_kavling}.status", GLOBAL_STATUS_ACTIVE);
            $this->db->where("{$this->_table_sector_kavling}.status_booking", 1);
            $query = $this->db->get();

            if($query === FALSE)
                throw new Exception();

            $result = $query->row();
            $result = ($result) ? $result->total : 0;

            return $result;         
        } catch(Exception $e) {
            return FALSE;
        }
    }

}