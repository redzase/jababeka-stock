<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Rulesmodel extends MY_Model 
{
    public function get_list($params = array()) 
    {
        $start_limit = (isset($params["start_limit"])) ? $params["start_limit"] : "";
        $end_limit   = (isset($params["end_limit"])) ? $params["end_limit"] : "";
        $get_total   = (isset($params["get_total"])) ? TRUE : FALSE;

        try {
            if ($get_total) {
                $this->db->select("
                    COUNT({$this->_table_type_status}.id) AS total
                    ", FALSE);
            } else {
                $this->db->select("
                    {$this->_table_type_status}.*,
                    {$this->_table_mst_type}.name as type_ticket_name,
                    {$this->_table_mst_status}.name as status_order_name,
                    ", FALSE);
            }
            $this->db->from($this->_table_type_status);
            $this->db->join($this->_table_mst_type, "{$this->_table_type_status}.id_type = {$this->_table_mst_type}.id", 'left');
            $this->db->join($this->_table_mst_status, "{$this->_table_type_status}.id_status = {$this->_table_mst_status}.id", 'left');
            $this->db->where("{$this->_table_type_status}.is_deleted", NULL);

            if ($get_total === FALSE) {
                if ($start_limit != "" or $end_limit != "")
                    $this->db->limit($end_limit, $start_limit);
            }

            $this->db->order_by("{$this->_table_mst_type}.id", "asc");
            $this->db->order_by("{$this->_table_type_status}.sort_number", "asc");
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

    public function get_detail_by_id($params = array()) {
        $id = (isset($params["id"])) ? $params["id"] : "";

        try {
            $this->db->select("
                {$this->_table_type_status}.*
                ", FALSE);
            $this->db->from($this->_table_type_status);
            $this->db->where("{$this->_table_type_status}.id", $id);
            $this->db->where("{$this->_table_type_status}.is_deleted", NULL);
            $query = $this->db->get();

            if($query === FALSE)
                throw new Exception();

            $result = $query->row();

            return $result;         
        } catch(Exception $e) {
            return FALSE;
        }
    }

    public function get_detail_by_params($params = array()) {
        try {
            $this->db->select("
                {$this->_table_type_status}.*
                ", FALSE);
            $this->db->from($this->_table_type_status);
            foreach ($params as $key => $value) {
                $this->db->where(sprintf("{$this->_table_type_status}.%s", $key), $value);
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

    public function get_list_by_id_type($id_type = NULL, $sort_number=NULL) {
        try {
            $this->db->select("
                {$this->_table_type_status}.*,
                {$this->_table_mst_type}.name as type_ticket_name,
                {$this->_table_mst_status}.name as status_order_name,
                ", FALSE);
            $this->db->from($this->_table_type_status);
            $this->db->join($this->_table_mst_type, "{$this->_table_type_status}.id_type = {$this->_table_mst_type}.id", 'left');
            $this->db->join($this->_table_mst_status, "{$this->_table_type_status}.id_status = {$this->_table_mst_status}.id", 'left');
            $this->db->where("{$this->_table_type_status}.id_type", $id_type);
            $this->db->where("{$this->_table_type_status}.is_deleted", NULL);

            if ($sort_number !== NULL){
                $this->db->where(sprintf("{$this->_table_type_status}.sort_number >= %s", $sort_number));                
            }

            $query = $this->db->get();

            if($query === FALSE)
                throw new Exception();

            $result = $query->result();

            return $result;         
        } catch(Exception $e) {
            return FALSE;
        }
    }

    public function create($data_create = []) 
    {
        try {
            $query = $this->db->insert($this->_table_type_status, $data_create);

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
            $query = $this->db->update($this->_table_type_status, $data_update);

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
            $query = $this->db->update($this->_table_type_status, [
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