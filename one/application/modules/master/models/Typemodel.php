<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Typemodel extends MY_Model 
{
    public function get_list($params = array()) 
    {
        $start_limit = (isset($params["start_limit"])) ? $params["start_limit"] : "";
        $end_limit   = (isset($params["end_limit"])) ? $params["end_limit"] : "";
        $order_by   = (isset($params["order_by"])) ? $params["order_by"] : "created_at";
        $sort_by   = (isset($params["sort_by"])) ? $params["sort_by"] : "DESC";
        $get_total   = (isset($params["get_total"])) ? TRUE : FALSE;

        try {
            if ($get_total) {
                $this->db->select("
                    COUNT({$this->_table_mst_type}.id) AS total
                    ", FALSE);
            } else {
                $this->db->select("
                    {$this->_table_mst_type}.*,
                    ", FALSE);
            }
            $this->db->from($this->_table_mst_type);
            $this->db->where("{$this->_table_mst_type}.is_deleted", NULL);

            if ($get_total === FALSE) {
                if ($start_limit != "" or $end_limit != "")
                    $this->db->limit($end_limit, $start_limit);
            }

            $this->db->order_by(sprintf("{$this->_table_mst_type}.%s", $order_by), $sort_by);
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

    public function get_list_by_params($params = array()) {
        try {
            $this->db->select("
                {$this->_table_mst_type}.*
                ", FALSE);
            $this->db->from($this->_table_mst_type);
            foreach ($params as $key => $value) {
                $this->db->where(sprintf("{$this->_table_mst_type}.%s", $key), $value);
            }

            $query = $this->db->get();

            if($query === FALSE)
                throw new Exception();

            $result = $query->row();

            return $result;         
        } catch(Exception $e) {
            return FALSE;
        }
    }

    public function get_detail_by_id($params = array()) {
        $id = (isset($params["id"])) ? $params["id"] : "";

        try {
            $this->db->select("
                {$this->_table_mst_type}.*
                ", FALSE);
            $this->db->from($this->_table_mst_type);
            $this->db->where("{$this->_table_mst_type}.id", $id);
            $this->db->where("{$this->_table_mst_type}.is_deleted", NULL);
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
            $query = $this->db->insert($this->_table_mst_type, $data_create);

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
            $this->db->where("is_deleted", NULL); 
            $query = $this->db->update($this->_table_mst_type, $data_update);

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
            $this->db->where("is_deleted", NULL); 
            $query = $this->db->update($this->_table_mst_type, [
                "is_deleted" => GLOBAL_STATUS_ACTIVE
            ]);

            if($query === FALSE)
                throw new Exception();

            return TRUE;
        } catch(Exception $e) {
            return FALSE;
        }
    }

}