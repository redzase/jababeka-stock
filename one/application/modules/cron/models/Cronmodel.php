<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cronmodel extends MY_Model 
{

    public function get_list_ticket_raw($params = array()){
        $id_type = (isset($params["id_type"])) ? $params["id_type"] : "";

        $where_id_type = "";
        if ($id_type != "") {
            $where_id_type = sprintf(" AND t.id_type =  '%s' ", $id_type);
        }

        $q = sprintf("SELECT 
                        t.name, 
                        t.id_status as status_id,
                        s.name as status_name,
                        t.id_type,
                        ty.name as type_name,
                        t.created_by, t.created_at,
                        t.updated_by, t.updated_at,
                        DATEDIFF(CURRENT_TIMESTAMP, t.updated_at) as calc_date
                    FROM tbl_tiket t
                    LEFT JOIN mst_status s on t.id_status = s.id and s.is_deleted is NULL
                    LEFT JOIN mst_type ty on t.id_type = ty.id and ty.is_deleted is NULL
                    WHERE t.is_deleted is NULL %s
                    AND t.id_status <> 4", $where_id_type);

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
}