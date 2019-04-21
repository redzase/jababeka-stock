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
                    {$this->_table_mst_status}.default,
                    {$this->_table_mst_status}.status_order
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

    public function get_list_raw($params = array()){
        $start_limit = (isset($params["start_limit"])) ? $params["start_limit"] : "";
        $end_limit   = (isset($params["end_limit"])) ? $params["end_limit"] : "";
        $get_total   = (isset($params["get_total"])) ? TRUE : FALSE;
        $id_type     = (isset($params["id_type"])) ? $params["id_type"] : "";

        $select = "*";
        if ($get_total) {
            $select = "COUNT(tbl.id) AS total";
        }

        $limit = "";
        if ($get_total === FALSE) {
            if ($start_limit != "" or $end_limit != "")
                $limit = sprintf("LIMIT %s, %s", $start_limit, $end_limit);
        }

        $where_id_type = "";
        if ($id_type != "") {
            $where_id_type = sprintf(" AND t.id =  '%s' ", $id_type);
        }

        $q = sprintf("SELECT %s FROM 
                        (SELECT
                            NULL as id,
                            NULL as id_type,
                            NULL as id_status,
                            NULL as sort_number,
                            NULL AS type_ticket_name,
                            s.name AS status_order_name,
                            s.default,
                            s.status_order 
                        FROM
                            {$this->_table_mst_status} s
                        WHERE
                            s.default is not NULL
                        AND s.status_order = 1
                        UNION
                        SELECT
                            a.id as id,
                            a.id_type as id_type,
                            a.id_status as id_status,
                            a.sort_number as sort_number,
                            t.name as type_ticket_name,
                            s.name as status_order_name, 
                            s.default,
                            s.status_order
                        FROM
                            {$this->_table_type_status} a
                        LEFT JOIN {$this->_table_mst_type} t on a.id_type = t.id
                        LEFT JOIN {$this->_table_mst_status} s on a.id_status = s.id
                        WHERE
                            a.is_deleted is NULL
                        AND s.default is NULL
                        %s
                        UNION
                        SELECT
                            NULL as id,
                            NULL as id_type,
                            NULL as id_status,
                            NULL as sort_number,
                            NULL AS type_ticket_name,
                            s.name as status_order_name, 
                            s.default,
                            s.status_order
                        FROM
                            {$this->_table_mst_status} s 
                        WHERE
                            s.default is not NULL
                        AND s.status_order = 0) as tbl %s", $select, $where_id_type, $limit);

        try {

            $query  = $this->db->query($q);
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

    public function get_list_with_detail_raw($params = array()){
        $id_type                = (isset($params["id_type"])) ? $params["id_type"] : "";
        $id_status_parent       = (isset($params["id_status_parent"])) ? $params["id_status_parent"] : "";
        $id_divisi              = (isset($params["id_divisi"])) ? $params["id_divisi"] : "";

        $where_id_type = "";
        if ($id_type != "") {
            $where_id_type = sprintf(" AND tbl.id_type =  '%s' ", $id_type);
        }

        $where_id_status_parent = "";
        if ($id_status_parent != "") {
            $where_id_status_parent = sprintf(" AND tbl.id_status =  '%s' ", $id_status_parent);
        }

        $where_id_divisi = "";
        if ($id_divisi != "") {
            $where_id_divisi = sprintf(" AND dt.id_divisi =  '%s' ", $id_divisi);
        }

        $q = sprintf("SELECT 
                            tbl.*,
                            dt.id_divisi,
                            dt.id_status as id_status_detail,
                            s.NAME AS status_order_name_detail,
                            s.status_order as status_order_detail
                        FROM
                            (SELECT
                                a.id AS id,
                                a.id_type AS id_type,
                                a.id_status AS id_status,
                                a.sort_number AS sort_number,
                                t.NAME AS type_ticket_name,
                                s.NAME AS status_order_name,
                                s.DEFAULT,
                                s.status_order 
                            FROM
                                tbl_type_status a
                                LEFT JOIN mst_type t ON a.id_type = t.id
                                LEFT JOIN mst_status s ON a.id_status = s.id 
                            WHERE
                                a.is_deleted IS NULL ) as tbl
                            INNER JOIN tbl_type_status_detail dt ON tbl.id = dt.id_type_status
                            LEFT JOIN mst_status s ON dt.id_status = s.id 
                            WHERE dt.is_deleted IS NULL %s %s %s
                            ORDER BY tbl.sort_number", $where_id_type, $where_id_status_parent, $where_id_divisi);

        try {

            $query  = $this->db->query($q);
            if($query === FALSE)
                throw new Exception();

            $result = $query->result();

            return $result;         
        } catch(Exception $e) {
            return FALSE;
        }
    }

    public function get_username_with_detail_raw($params = array()){
        $id_type                = (isset($params["id_type"])) ? $params["id_type"] : "";
        $id_status_parent       = (isset($params["id_status_parent"])) ? $params["id_status_parent"] : "";

        $where_id_type = "";
        if ($id_type != "") {
            $where_id_type = sprintf(" AND tbl.id_type =  '%s' ", $id_type);
        }

        $where_id_status_parent = "";
        if ($id_status_parent != "") {
            $where_id_status_parent = sprintf(" AND tbl.id_status =  '%s' ", $id_status_parent);
        }

        $q = sprintf("SELECT 
                            u.username
                        FROM
                            (SELECT
                                a.id AS id,
                                a.id_type AS id_type,
                                a.id_status AS id_status
                            FROM
                                tbl_type_status a
                                LEFT JOIN mst_type t ON a.id_type = t.id
                                LEFT JOIN mst_status s ON a.id_status = s.id 
                            WHERE
                                a.is_deleted IS NULL ) as tbl
                            INNER JOIN tbl_type_status_detail dt ON tbl.id = dt.id_type_status
                            LEFT JOIN tbl_user_divisi d ON dt.id_divisi = d.id_divisi 
                            LEFT JOIN user u ON d.id_user = u.id
                            WHERE dt.is_deleted IS NULL AND d.is_deleted IS NULL %s %s
                            group by u.username", $where_id_type, $where_id_status_parent);

        try {

            $query  = $this->db->query($q);
            if($query === FALSE)
                throw new Exception();

            $result = $query->result();

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

    public function get_list_status_by_id_type($id_type = NULL, $default = NULL) {
        try {
            $this->db->select("
                {$this->_table_type_status}.*,
                {$this->_table_mst_type}.name as type_ticket_name,
                {$this->_table_mst_status}.name as status_order_name, 
                {$this->_table_mst_status}.default,
                {$this->_table_mst_status}.status_order
                ", FALSE);
            $this->db->from($this->_table_type_status);
            $this->db->join($this->_table_mst_type, "{$this->_table_type_status}.id_type = {$this->_table_mst_type}.id", 'left');
            $this->db->join($this->_table_mst_status, "{$this->_table_type_status}.id_status = {$this->_table_mst_status}.id", 'left');
            $this->db->where("{$this->_table_type_status}.id_type", $id_type);
            $this->db->where("{$this->_table_type_status}.is_deleted", NULL);
            
            if ($default == NULL)
                $this->db->where("{$this->_table_mst_status}.default", NULL);


            $this->db->order_by("{$this->_table_mst_type}.id", "asc");
            $this->db->order_by("{$this->_table_type_status}.sort_number", "asc");

            $query = $this->db->get();
            
            if($query === FALSE)
                throw new Exception();

            $result = $query->result();

            return $result;         
        } catch(Exception $e) {
            return FALSE;
        }
    }

    public function get_detail_list_status_by_id_type($id_type = NULL) {
        try {
            $this->db->select("
                {$this->_table_type_status_detail}.*,
                {$this->_table_mst_status}.name as status_order_name,
                {$this->_table_mst_status}.status_order
                ", FALSE);
            $this->db->from($this->_table_type_status_detail);
            $this->db->join($this->_table_mst_status, "{$this->_table_type_status_detail}.id_status = {$this->_table_mst_status}.id", "left");
            $this->db->where("{$this->_table_type_status_detail}.id_type", $id_type);
            $this->db->where("{$this->_table_type_status_detail}.is_deleted", NULL);

            $query = $this->db->get();
            
            if($query === FALSE)
                throw new Exception();

            $result = $query->result();

            return $result;         
        } catch(Exception $e) {
            return FALSE;
        }
    }

    public function get_full_detail_list($params = array()) {
        try {
            $this->db->select("
                {$this->_table_type_status}.*,
                {$this->_table_type_status_detail}.id_divisi,
                {$this->_table_mst_status}.name as status_order_name,
                {$this->_table_mst_status}.status_order
                ", FALSE);
            $this->db->from($this->_table_type_status);
            $this->db->join($this->_table_type_status_detail, "{$this->_table_type_status_detail}.id_type_status = {$this->_table_type_status}.id", "left");
            $this->db->join($this->_table_mst_status, "{$this->_table_type_status_detail}.id_status = {$this->_table_mst_status}.id", "left");
            $this->db->where("{$this->_table_type_status}.id_type", $id_type);
            $this->db->where("{$this->_table_type_status}.is_deleted", NULL);

            $query = $this->db->get();
            
            if($query === FALSE)
                throw new Exception();

            $result = $query->result();

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

    public function create_detail($data_create = []) 
    {
        try {
            $query = $this->db->insert($this->_table_type_status_detail, $data_create);

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

    public function delete_detail_by_id_type($id_type) 
    {
        try {
            $this->db->where("id_type", $id_type);
            $query = $this->db->update($this->_table_type_status_detail, [
                "is_deleted" => GLOBAL_STATUS_ACTIVE
            ]);

            if($query === FALSE)
                throw new Exception();

            return TRUE;
        } catch(Exception $e) {
            return FALSE;
        }
    }


    public function delete_by_id_type($id_type) 
    {
        try {
            $this->db->where("id_type", $id_type);
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