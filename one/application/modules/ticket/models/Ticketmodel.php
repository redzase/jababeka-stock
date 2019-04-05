<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ticketmodel extends MY_Model 
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
                    COUNT({$this->_table_tiket}.id) AS total
                    ", FALSE);
            } else {
                $this->db->select("
                    {$this->_table_tiket}.*,
                    {$this->_table_mst_type}.name as type_ticket_name,
                    {$this->_table_mst_status}.name as status_order_name,
                    ", FALSE);
            }
            $this->db->from($this->_table_tiket);
            $this->db->join($this->_table_mst_type, "{$this->_table_tiket}.id_type = {$this->_table_mst_type}.id", 'left');
            $this->db->join($this->_table_mst_status, "{$this->_table_tiket}.id_status = {$this->_table_mst_status}.id", 'left');
            $this->db->where("{$this->_table_tiket}.is_deleted", NULL);

            $this->db->order_by(sprintf("{$this->_table_tiket}.%s", $order_by), $sort_by);

            if ($get_total === FALSE) {
                if ($start_limit != "" or $end_limit != "")
                    $this->db->limit($end_limit, $start_limit);
            }

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
                {$this->_table_tiket}.*,
                {$this->_table_mst_status}.name as status_order_name,
                ", FALSE);
            $this->db->from($this->_table_tiket);
            $this->db->join($this->_table_mst_status, "{$this->_table_tiket}.id_status = {$this->_table_mst_status}.id", 'left');
            $this->db->where("{$this->_table_tiket}.id", $id);
            $this->db->where("{$this->_table_tiket}.is_deleted", NULL);
            $query = $this->db->get();

            if($query === FALSE)
                throw new Exception();

            $result = $query->row();

            return $result;         
        } catch(Exception $e) {
            return FALSE;
        }
    }

    public function get_list_comment_by_id_ticket($id_ticket) {
        try {
            $this->db->select("
                {$this->_table_tiket_comment}.*,
                {$this->_table_user}.username
                ", FALSE);
            $this->db->from($this->_table_tiket_comment);
            $this->db->join($this->_table_user, "{$this->_table_tiket_comment}.id_user = {$this->_table_user}.id");
            $this->db->where("{$this->_table_tiket_comment}.id_ticket", $id_ticket);
            $query = $this->db->get();

            if($query === FALSE)
                throw new Exception();

            $result = $query->result();

            return $result;         
        } catch(Exception $e) {
            return FALSE;
        }
    }

    public function get_list_by_params($where = array(), $params = array()) {
        $start_limit = (isset($params["start_limit"])) ? $params["start_limit"] : "";
        $end_limit   = (isset($params["end_limit"])) ? $params["end_limit"] : "";
        $order_by   = (isset($params["order_by"])) ? $params["order_by"] : "created_at";
        $sort_by   = (isset($params["sort_by"])) ? $params["sort_by"] : "DESC";
        $get_total   = (isset($params["get_total"])) ? TRUE : FALSE;
        try {
            if ($get_total) {
                $this->db->select("
                    COUNT({$this->_table_tiket}.id) AS total
                    ", FALSE);
            } else {
                $this->db->select("
                    {$this->_table_tiket}.*,
                    {$this->_table_mst_type}.name as type_ticket_name,
                    {$this->_table_mst_status}.name as status_order_name,
                    {$this->_table_type_status}.sort_number,
                    ", FALSE);
            }

            $this->db->from($this->_table_tiket);
            $this->db->join($this->_table_type_status, "{$this->_table_type_status}.id_type = {$this->_table_tiket}.id_type AND {$this->_table_type_status}.id_status = {$this->_table_tiket}.id_status");

            $this->db->join($this->_table_mst_type, "{$this->_table_tiket}.id_type = {$this->_table_mst_type}.id", 'left');
            $this->db->join($this->_table_mst_status, "{$this->_table_tiket}.id_status = {$this->_table_mst_status}.id", 'left');
            $this->db->where("{$this->_table_type_status}.is_deleted", NULL);

            foreach ($where as $key => $value) {
                $this->db->where(sprintf("{$this->_table_tiket}.%s", $key), $value);
            }

            $this->db->order_by(sprintf("{$this->_table_tiket}.%s", $order_by), $sort_by);

            if ($get_total === FALSE) {
                if ($start_limit != "" or $end_limit != "")
                    $this->db->limit($end_limit, $start_limit);
            }

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

    public function create($data_create = []) 
    {
        try {
            $query = $this->db->insert($this->_table_tiket, $data_create);

            if($query === FALSE)
                throw new Exception();

            return True;
        } catch(Exception $e) {
            return FALSE;
        }
    }

    public function create_ticket($data_create = []) 
    {
        try {
            $query = $this->db->insert($this->_table_tiket_comment, $data_create);

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
            $query = $this->db->update($this->_table_tiket, $data_update);

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
            $query = $this->db->update($this->_table_tiket, [
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