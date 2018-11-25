<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Authmodel extends MY_Model {

    public function check_email($params = array()) {
        $email = (isset($params["email"])) ? $params["email"] : "";

        try {
            $this->db->select("
                {$this->_table_user}.*
                ", FALSE);
            $this->db->from($this->_table_user);
            $this->db->where("{$this->_table_user}.username", $email);
            $this->db->where("{$this->_table_user}.status", GLOBAL_STATUS_ACTIVE);
            $query = $this->db->get();

            if($query === FALSE)
                throw new Exception();

            $result = $query->row();

            if ($result) {
                /**
                 * -- Start --
                 * Update last login
                 */
                $data = array(
                    "last_login" => date_now()
                    );

                $this->db->where("username", $email);
                $query = $this->db->update($this->_table_user, $data);

                if($query === FALSE)
                    throw new Exception();
                /**
                 * Update last login
                 * -- End --
                 */
                
                /**
                 * -- Start --
                 * Get menu role module permission
                 */
                $this->db->select("
                    {$this->_table_module_permission}.module_id,
                    {$this->_table_module}.name AS module_name,
                    {$this->_table_module}.code AS module_code,
                    {$this->_table_module}.url AS module_url,
                    {$this->_table_module_permission}.permission_id,
                    {$this->_table_permission}.code AS permission_code,
                    {$this->_table_permission}.name AS permission_name,
                    {$this->_table_menu}.id AS menu_id,
                    {$this->_table_menu}.name AS menu_name,
                    {$this->_table_menu}.code AS menu_code,
                    {$this->_table_menu}.url AS menu_url,
                    {$this->_table_menu}.icon AS menu_icon,
                    ");
                $this->db->from($this->_table_role_permission);
                $this->db->join($this->_table_role, "{$this->_table_role_permission}.role_id = {$this->_table_role}.id");
                $this->db->join($this->_table_module_permission, "{$this->_table_role_permission}.module_permission_id = {$this->_table_module_permission}.id");
                $this->db->join($this->_table_module, "{$this->_table_module_permission}.module_id = {$this->_table_module}.id");
                $this->db->join($this->_table_menu, "{$this->_table_module}.menu_id = {$this->_table_menu}.id");
                $this->db->join($this->_table_permission, "{$this->_table_module_permission}.permission_id = {$this->_table_permission}.id");
                $this->db->where("{$this->_table_role}.id", $result->role_id);
                $this->db->order_by("{$this->_table_module}.id ASC");
                $query = $this->db->get();

                if($query === FALSE)
                    throw new Exception();

                $result_access = $query->result();

                $all_access = [];
                foreach ($result_access as $key => $value) {
                    // Get list menu by role
                    if (!isset($all_access["menu"][$value->menu_code])) {
                        $all_access["menu"][$value->menu_code] = [
                            "id" => $value->menu_id,
                            "name" => $value->menu_name,
                            "code" => $value->menu_code,
                            "url" => $value->menu_url,
                            "icon" => $value->menu_icon,
                        ];
                    }

                    // Get list module by menu
                    if (!isset($all_access["module"][$value->menu_code][$value->module_code])) {
                        $all_access["module"][$value->menu_code][$value->module_code] = [
                            "id" => $value->module_id,
                            "name" => $value->module_name,
                            "url" => $value->module_url,
                            "code" => $value->module_code,
                        ];
                    }

                    // Get list permission by module
                    if (!isset($all_access["module_permission"][$value->module_code][$value->permission_code])) {
                        $all_access["module_permission"][$value->module_code][$value->permission_code] = [
                            "id" => $value->permission_id,
                            "name" => $value->permission_name,
                            "code" => $value->permission_code,
                        ];
                    }
                }

                $result->{"all_access"} = $all_access;
                /**
                 * Get menu role module permission
                 * -- End --
                 */
            }

            return $result;         
        } catch(Exception $e) {
            return FALSE;
        }
    }

}