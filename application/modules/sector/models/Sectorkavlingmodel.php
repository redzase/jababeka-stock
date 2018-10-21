<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sectorkavlingmodel extends MY_Model 
{

    public function get_list($params = array()) 
    {
        $sector_id   = (isset($params["sector_id"])) ? $params["sector_id"] : "";
        $start_limit = (isset($params["start_limit"])) ? $params["start_limit"] : "";
        $end_limit   = (isset($params["end_limit"])) ? $params["end_limit"] : "";
        $get_total   = (isset($params["get_total"])) ? TRUE : FALSE;

        try {
            if ($get_total) {
                $this->db->select("
                    COUNT({$this->_table_sector_kavling}.id) AS total
                    ", FALSE);
            } else {
                $this->db->select("
                    {$this->_table_sector_kavling}.*
                    ", FALSE);
            }
            $this->db->from($this->_table_sector_kavling);
            // $this->db->join($this->_table_sector_kavling_permission, "{$this->_table_sector_kavling}.id = {$this->_table_sector_kavling_permission}.role_id");
            $this->db->where("{$this->_table_sector_kavling}.sector_id", $sector_id);
            $this->db->where("{$this->_table_sector_kavling}.status", GLOBAL_STATUS_ACTIVE);

            if ($get_total === FALSE) {
                if ($start_limit != "" or $end_limit != "")
                    $this->db->limit($end_limit, $start_limit);
            }

            $this->db->order_by("{$this->_table_sector_kavling}.created_date", "DESC");
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

    public function get_detail($params = array()) {
        $id = (isset($params["id"])) ? $params["id"] : "";

        try {
            $this->db->select("
                {$this->_table_sector_kavling}.*
                ", FALSE);
            $this->db->from($this->_table_sector_kavling);
            // $this->db->join($this->_table_sector_kavling_permission, "{$this->_table_sector_kavling}.id = {$this->_table_sector_kavling_permission}.role_id");
            $this->db->where("{$this->_table_sector_kavling}.status", GLOBAL_STATUS_ACTIVE);
            $this->db->where("{$this->_table_sector_kavling}.id", $id);
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
            $query = $this->db->insert($this->_table_sector_kavling, $data_create);

            if($query === FALSE)
                throw new Exception();

            return True;
        } catch(Exception $e) {
            return FALSE;
        }
    }

    public function update($id, $data_update = []) 
    {
        try {
            $this->db->where("id", $id);
            $this->db->where("status", GLOBAL_STATUS_ACTIVE); 
            $query = $this->db->update($this->_table_sector_kavling, $data_update);

            if($query === FALSE)
                throw new Exception();

            return TRUE;
        } catch(Exception $e) {
            return FALSE;
        }
    }

    // public function delete($id) 
    // {
    //     try {
    //         $this->db->where("id", $id);
    //         $this->db->where("total_user", 0); 
    //         $this->db->where("status", GLOBAL_STATUS_ACTIVE); 
    //         $query = $this->db->update($this->_table_sector_kavling, [
    //             "status" => GLOBAL_STATUS_NOTACTIVE
    //         ]);

    //         if($query === FALSE)
    //             throw new Exception();

    //         return TRUE;
    //     } catch(Exception $e) {
    //         return FALSE;
    //     }
    // }

}