<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sectorkavlingmodel extends MY_Model 
{

    public function get_list($params = array()) 
    {
        $sector_id                = (isset($params["sector_id"])) ? $params["sector_id"] : "";
        $filter                   = (isset($params["filter"])) ? $params["filter"] : [];
        $is_show_empty_coordinate = (isset($params["is_show_empty_coordinate"])) ? TRUE : FALSE;
        $start_limit              = (isset($params["start_limit"])) ? $params["start_limit"] : "";
        $end_limit                = (isset($params["end_limit"])) ? $params["end_limit"] : "";
        $get_total                = (isset($params["get_total"])) ? TRUE : FALSE;

        try {
            if ($get_total) {
                $this->db->select("
                    COUNT({$this->_table_sector_kavling}.id) AS total
                    ", FALSE);
            } else {
                $this->db->select("
                    {$this->_table_sector_kavling}.*,
                    {$this->_table_sector}.icon_size,
                    {$this->_table_sector}.color_sold,
                    {$this->_table_sector}.color_available,
                    {$this->_table_sector}.color_booked,
                    {$this->_table_sector}.color_requested,
                    CASE WHEN {$this->_dbase_jababeka_table_kavlings}.kav_ref IS NULL THEN 3
                         WHEN {$this->_table_sector_kavling}.status_booking = 1 THEN 4
                         WHEN {$this->_table_sector_kavling}.status_booking = 0 THEN 1
                         WHEN {$this->_table_sector_kavling}.status_booking = 2 THEN 2
                         ELSE 1
                    END 'status_valid',
                    ", FALSE);
            }
            // 1 = Available
            // 2 = Booked
            // 3 = Sold
            // 4 = Available Requested
            $this->db->from($this->_table_sector_kavling);
            $this->db->join($this->_table_sector, "{$this->_table_sector_kavling}.sector_id = {$this->_table_sector}.id");
            $this->db->join($this->_dbase_jababeka_table_kavlings, "{$this->_table_sector_kavling}.reference_kavling_id = {$this->_dbase_jababeka_table_kavlings}.kav_ref", "LEFT");
            $this->db->where("{$this->_table_sector_kavling}.sector_id", $sector_id);
            $this->db->where("{$this->_table_sector_kavling}.status", GLOBAL_STATUS_ACTIVE);

            /**
             * -- Start --
             * Filter
             */
            if (isset($filter["reference_kavling_id"]) and !empty($filter["reference_kavling_id"])) {
                $this->db->where("{$this->_table_sector_kavling}.reference_kavling_id", $filter["reference_kavling_id"]);
            }

            if (isset($filter["street_name"]) and !empty($filter["street_name"])) {
                $this->db->like("{$this->_table_sector_kavling}.street_name", $filter["street_name"]);
            }

            if (isset($filter["filter_status"]) and is_array($filter["filter_status"]) and count($filter["filter_status"]) > 0) {
                $this->db->where_in("CASE WHEN {$this->_dbase_jababeka_table_kavlings}.kav_ref IS NULL THEN 3
                         WHEN {$this->_table_sector_kavling}.status_booking = 1 THEN 4
                         WHEN {$this->_table_sector_kavling}.status_booking = 0 THEN 1
                         WHEN {$this->_table_sector_kavling}.status_booking = 2 THEN 2
                         ELSE 1
                    END", $filter["filter_status"]);
            }
            /**
             * Filter
             * -- End --
             */
            
            if ($is_show_empty_coordinate) {
                $this->db->where("{$this->_table_sector_kavling}.offset_x", 0);
                $this->db->where("{$this->_table_sector_kavling}.offset_y", 0);
            }

            if ($get_total === FALSE) {
                if ($start_limit != "" or $end_limit != "")
                    $this->db->limit($end_limit, $start_limit);
            }

            $this->db->order_by("{$this->_table_sector_kavling}.created_date DESC, {$this->_table_sector_kavling}.id DESC");
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

    public function import($sector_id, $data_import = []) 
    {
        $data_kavling = array();

        try {
            // Start transaction
            $this->db->trans_begin();

            foreach ($data_import as $key => $value) {
                $data_kavling[] = [
                    "sector_id"            => $sector_id,
                    "reference_kavling_id" => $value["kav_ref"],
                    "street_name"          => $value["nama_jalan"],
                    "block_name"           => $value["nama_blok"],
                    "house_number"         => $value["nomor"],
                    "status"               => GLOBAL_STATUS_ACTIVE,
                    // "created_by"        => $this->session->userdata(PREFIX_SESSION . "_USER_ID"), 
                    "created_date"         => date_now(),
                    // "modified_by"       => $this->session->userdata(PREFIX_SESSION . "_USER_ID"), 
                    "modified_date"        => date_now(),
                ];
            }

            // JIKA ADA DATA MODULE YANG AKAN DI INSERT
            if (count($data_kavling) > 0) {
                $query = $this->db->insert_batch($this->_table_sector_kavling, $data_kavling);

                if($query === FALSE)
                    throw new Exception();
            }

            // Commit transaction
            $this->db->trans_commit();

            return TRUE;
        } catch(Exception $e) {
            // Rollback transaction
            $this->db->trans_rollback();

            return FALSE;
        }
    }

    public function delete($id) 
    {
        try {
            $this->db->where("id", $id);
            $this->db->where("status", GLOBAL_STATUS_ACTIVE); 
            $query = $this->db->update($this->_table_sector_kavling, [
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