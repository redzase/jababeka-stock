<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Memomodel extends MY_Model 
{

    public function get_list_year($params = array()) 
    {
        $start_limit = (isset($params["start_limit"])) ? $params["start_limit"] : "";
        $end_limit   = (isset($params["end_limit"])) ? $params["end_limit"] : "";

        try {
            $this->db->select("
                DATE_FORMAT({$this->_table_memo}.start_date, '%Y') AS start_date_year,
                DATE_FORMAT({$this->_table_memo}.end_date, '%Y') AS end_date_year,
                ", FALSE);
            $this->db->from($this->_table_memo);
            $this->db->where("{$this->_table_memo}.status", GLOBAL_STATUS_ACTIVE);

            if ($start_limit != "" or $end_limit != "")
                $this->db->limit($end_limit, $start_limit);

            $query = $this->db->get();

            if($query === FALSE)
                throw new Exception();

            $result = $query->result();

            return $result;         
        } catch(Exception $e) {
            return FALSE;
        }
    }

    public function get_list($params = array()) 
    {
        $sector_id   = (isset($params["sector_id"])) ? $params["sector_id"] : "";
        $start_limit = (isset($params["start_limit"])) ? $params["start_limit"] : "";
        $end_limit   = (isset($params["end_limit"])) ? $params["end_limit"] : "";
        $get_total   = (isset($params["get_total"])) ? TRUE : FALSE;

        // Convert to array if not array
        $sector_id = (is_array($sector_id)) ? $sector_id : [$sector_id];

        try {
            if ($get_total) {
                $this->db->select("
                    COUNT({$this->_table_memo}.id) AS total
                    ", FALSE);
            } else {
                $this->db->select("
                    {$this->_table_memo}.*,
                    {$this->_table_user}.username AS created_by_name
                    ", FALSE);
            }
            $this->db->from($this->_table_memo);
            $this->db->join($this->_table_user, "{$this->_table_memo}.created_by = {$this->_table_user}.id");
            $this->db->where_in("{$this->_table_memo}.sector_id", $sector_id);
            $this->db->where("{$this->_table_memo}.status", GLOBAL_STATUS_ACTIVE);

            if ($get_total === FALSE) {
                if ($start_limit != "" or $end_limit != "")
                    $this->db->limit($end_limit, $start_limit);
            }

            $this->db->order_by("{$this->_table_memo}.created_date", "DESC");
            $query = $this->db->get();

            if($query === FALSE)
                throw new Exception();

            if ($get_total) {
                $result = $query->row();
                $result = ($result) ? $result->total : 0;
            } else {
                $result = $query->result();
            }

            return $result;         
        } catch(Exception $e) {
            return FALSE;
        }
    }

    public function get_detail($params = array()) {
        $id        = (isset($params["id"])) ? $params["id"] : "";
        $sector_id = (isset($params["sector_id"])) ? $params["sector_id"] : "";

        try {
            $this->db->select("
                {$this->_table_memo}.*
                ", FALSE);
            $this->db->from($this->_table_memo);
            $this->db->where("{$this->_table_memo}.status", GLOBAL_STATUS_ACTIVE);
            $this->db->where("{$this->_table_memo}.id", $id);
            $this->db->where("{$this->_table_memo}.sector_id", $sector_id);
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
            $query = $this->db->insert($this->_table_memo, $data_create);

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
            $query = $this->db->update($this->_table_memo, $data_update);

            if($query === FALSE)
                throw new Exception();

            return TRUE;
        } catch(Exception $e) {
            return FALSE;
        }
    }

    public function delete($id) 
    {
        try {
            $this->db->where("id", $id);
            $this->db->where("status", GLOBAL_STATUS_ACTIVE); 
            $query = $this->db->update($this->_table_memo, [
                "status" => GLOBAL_STATUS_NOTACTIVE
            ]);

            if($query === FALSE)
                throw new Exception();

            return TRUE;
        } catch(Exception $e) {
            return FALSE;
        }
    }

}