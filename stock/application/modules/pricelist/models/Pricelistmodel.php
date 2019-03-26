<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pricelistmodel extends MY_Model 
{

    // public function get_list_year($params = array()) 
    // {
    //     $start_limit = (isset($params["start_limit"])) ? $params["start_limit"] : "";
    //     $end_limit   = (isset($params["end_limit"])) ? $params["end_limit"] : "";

    //     try {
    //         $this->db->select("
    //             DATE_FORMAT({$this->_table_pricelist}.start_date, '%Y') AS start_date_year,
    //             DATE_FORMAT({$this->_table_pricelist}.end_date, '%Y') AS end_date_year,
    //             ", FALSE);
    //         $this->db->from($this->_table_pricelist);
    //         $this->db->where("{$this->_table_pricelist}.status", GLOBAL_STATUS_ACTIVE);

    //         if ($start_limit != "" or $end_limit != "")
    //             $this->db->limit($end_limit, $start_limit);

    //         $query = $this->db->get();

    //         if($query === FALSE)
    //             throw new Exception();

    //         $result = $query->result();

    //         return $result;         
    //     } catch(Exception $e) {
    //         return FALSE;
    //     }
    // }

    public function get_sector_filter($params = array()) 
    {
        $sector_id   = (isset($params["sector_id"])) ? $params["sector_id"] : "";

        // Convert to array if not array
        $sector_id = (is_array($sector_id)) ? $sector_id : [$sector_id];

        try {
            $this->db->select("
                {$this->_table_sector}.*,
                ", FALSE);
            $this->db->from($this->_table_sector);

            if (!(count($sector_id) == 1 and empty($sector_id[0]))) {
                $this->db->where_in("{$this->_table_sector}.id", $sector_id);
            }

            $this->db->where("{$this->_table_sector}.status", GLOBAL_STATUS_ACTIVE);
            $this->db->order_by("{$this->_table_sector}.created_date", "DESC");
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
        $year        = (isset($params["year"])) ? $params["year"] : "";
        $start_limit = (isset($params["start_limit"])) ? $params["start_limit"] : "";
        $end_limit   = (isset($params["end_limit"])) ? $params["end_limit"] : "";
        $get_total   = (isset($params["get_total"])) ? TRUE : FALSE;

        // Convert to array if not array
        $sector_id = (is_array($sector_id)) ? $sector_id : [$sector_id];

        try {
            if ($get_total) {
                $this->db->select("
                    COUNT({$this->_table_pricelist}.id) AS total
                    ", FALSE);
            } else {
                $this->db->select("
                    {$this->_table_pricelist}.*,
                    {$this->_table_user}.username AS created_by_name
                    ", FALSE);
            }
            $this->db->from($this->_table_pricelist);
            $this->db->join($this->_table_user, "{$this->_table_pricelist}.created_by = {$this->_table_user}.id");

            if (!(count($sector_id) == 1 and empty($sector_id[0]))) {
                $this->db->where_in("{$this->_table_pricelist}.sector_id", $sector_id);
            }
            if (!empty($year)) {
                $this->db->where("DATE_FORMAT({$this->_table_pricelist}.start_date, '%Y') <=", $year);   
                $this->db->where("DATE_FORMAT({$this->_table_pricelist}.end_date, '%Y') >=", $year);   
            }

            $this->db->where("{$this->_table_pricelist}.status", GLOBAL_STATUS_ACTIVE);

            if ($get_total === FALSE) {
                if ($start_limit != "" or $end_limit != "")
                    $this->db->limit($end_limit, $start_limit);
            }

            $this->db->order_by("{$this->_table_pricelist}.created_date", "DESC");
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
                {$this->_table_pricelist}.*
                ", FALSE);
            $this->db->from($this->_table_pricelist);
            $this->db->where("{$this->_table_pricelist}.status", GLOBAL_STATUS_ACTIVE);
            $this->db->where("{$this->_table_pricelist}.id", $id);
            $this->db->where("{$this->_table_pricelist}.sector_id", $sector_id);
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
            $query = $this->db->insert($this->_table_pricelist, $data_create);

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
            $query = $this->db->update($this->_table_pricelist, $data_update);

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
            $query = $this->db->update($this->_table_pricelist, [
                "status" => GLOBAL_STATUS_NOTACTIVE
            ]);

            if($query === FALSE)
                throw new Exception();

            return TRUE;
        } catch(Exception $e) {
            return FALSE;
        }
    }

    public function get_list_logs($params = array()) 
    {
        $sector_id   = (isset($params["sector_id"])) ? $params["sector_id"] : "";
        $start_limit = (isset($params["start_limit"])) ? $params["start_limit"] : "";
        $end_limit   = (isset($params["end_limit"])) ? $params["end_limit"] : "";
        $get_total   = (isset($params["get_total"])) ? TRUE : FALSE;

        try {
            if ($get_total) {
                $this->db->select("
                    COUNT({$this->_table_pricelist_logs}.id) AS total
                    ", FALSE);
            } else {
                $this->db->select("
                    {$this->_table_pricelist_logs}.*,
                    {$this->_table_user}.username AS created_by_name
                    ", FALSE);
            }
            $this->db->from($this->_table_pricelist_logs);
            $this->db->join($this->_table_user, "{$this->_table_pricelist_logs}.created_by = {$this->_table_user}.id");

            if (!empty($sector_id)) {
                $this->db->where_in("{$this->_table_pricelist_logs}.sector_id", $sector_id);
            }

            if ($get_total === FALSE) {
                if ($start_limit != "" or $end_limit != "")
                    $this->db->limit($end_limit, $start_limit);
            }

            $this->db->order_by("{$this->_table_pricelist_logs}.created_date", "DESC");
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

}