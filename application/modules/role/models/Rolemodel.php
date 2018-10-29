<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Rolemodel extends MY_Model 
{

    public function get_list($params = array()) 
    {
        $start_limit = (isset($params["start_limit"])) ? $params["start_limit"] : "";
        $end_limit   = (isset($params["end_limit"])) ? $params["end_limit"] : "";
        $get_total   = (isset($params["get_total"])) ? TRUE : FALSE;

        try {
            if ($get_total) {
                $this->db->select("
                    COUNT({$this->_table_role}.id) AS total
                    ", FALSE);
            } else {
                $this->db->select("
                    {$this->_table_role}.*,
                    CASE WHEN {$this->_table_user}.id IS NOT NULL THEN COUNT({$this->_table_user}.id) 
                         ELSE 0
                    END AS total_user
                    ", FALSE);
            }
            $this->db->from($this->_table_role);
            $this->db->join($this->_table_user, "{$this->_table_role}.id = {$this->_table_user}.role_id", "LEFT");
            $this->db->where("{$this->_table_role}.status", GLOBAL_STATUS_ACTIVE);

            if ($get_total === FALSE) {
                if ($start_limit != "" or $end_limit != "")
                    $this->db->limit($end_limit, $start_limit);
            }

            $this->db->group_by("{$this->_table_role}.id");
            $this->db->order_by("{$this->_table_role}.created_date", "DESC");
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
                {$this->_table_role}.*
                ", FALSE);
            $this->db->from($this->_table_role);
            // $this->db->join($this->_table_role_permission, "{$this->_table_role}.id = {$this->_table_role_permission}.role_id");
            $this->db->where("{$this->_table_role}.status", GLOBAL_STATUS_ACTIVE);
            $this->db->where("{$this->_table_role}.id", $id);
            $query = $this->db->get();

            if($query === FALSE)
                throw new Exception();

            $result = $query->row();

            if ($result) {
                $this->db->select("
                    {$this->_table_role_permission}.*
                    ");
                $this->db->from($this->_table_role_permission);
                $this->db->where("role_id", $id);
                $query = $this->db->get();

                if($query === FALSE)
                    throw new Exception();

                $result_role_permission = $query->result();

                $result->{"role_permission"} = $result_role_permission;
            }

            return $result;         
        } catch(Exception $e) {
            return FALSE;
        }
    }

    public function get_module_permission() 
    {
        try {
            $this->db->select("
                {$this->_table_module_permission}.id,
                CONCAT({$this->_table_menu}.name, ' - ', {$this->_table_module}.name, ' - ', {$this->_table_permission}.name) AS name
                ", FALSE);
            $this->db->from($this->_table_module_permission);
            $this->db->join($this->_table_module, "{$this->_table_module_permission}.module_id = {$this->_table_module}.id");
            $this->db->join($this->_table_menu, "{$this->_table_module}.menu_id = {$this->_table_menu}.id");
            $this->db->join($this->_table_permission, "{$this->_table_module_permission}.permission_id = {$this->_table_permission}.id");
            $this->db->order_by("{$this->_table_menu}.sequence", "ASC");
            $query = $this->db->get();

            if($query === FALSE)
                throw new Exception();

            $result = $query->result();

            return $result;         
        } catch(Exception $e) {
            return FALSE;
        }
    }

    public function create($data_create = [], $data_role_permission = []) 
    {
        try {
            // Start database transaction
            $this->db->trans_begin();

            $query = $this->db->insert($this->_table_role, $data_create);

            if($query === FALSE)
                throw new Exception();

            // Last inserted id
            $insert_id = $this->db->insert_id();

            // If there is $data_role_permission
            if (count($data_role_permission) > 0) {
                // Add field "role_id"
                foreach ($data_role_permission as $key => $value) {
                    $data_role_permission[$key]["role_id"] = $insert_id;
                }
                
                $query = $this->db->insert_batch($this->_table_role_permission, $data_role_permission);

                if($query === FALSE)
                    throw new Exception();
            }
            else {
                throw new Exception("Role permission must be filled.");
            }
            
            // End database transaction
            $this->db->trans_commit();

            return True;
        } catch(Exception $e) {
            // Rollback database transaction
            $this->db->trans_rollback();

            return FALSE;
        }
    }

    public function update($id, $data_update = [], $data_role_permission = []) 
    {
        try {
            // Start database transaction
            $this->db->trans_begin();
            
            $this->db->where("id", $id);
            $this->db->where("status", GLOBAL_STATUS_ACTIVE); 
            $query = $this->db->update($this->_table_role, $data_update);

            if($query === FALSE)
                throw new Exception();

            // Delete old data first
            $this->db->where("role_id", $id);
            $query = $this->db->delete($this->_table_role_permission);

            // If there is $data_role_permission
            if (count($data_role_permission) > 0) {
                // Add field "role_id"
                foreach ($data_role_permission as $key => $value) {
                    $data_role_permission[$key]["role_id"] = $id;
                }

                $query = $this->db->insert_batch($this->_table_role_permission, $data_role_permission);

                if($query === FALSE)
                    throw new Exception();
            }
            else {
                throw new Exception("Role permission must be filled.");
            }

            // End database transaction
            $this->db->trans_commit();

            return TRUE;
        } catch(Exception $e) {
            // Rollback database transaction
            $this->db->trans_rollback();

            return FALSE;
        }
    }

    public function delete($id) 
    {
        try {
            $this->db->where("id", $id);
            $this->db->where("total_user", 0); 
            $this->db->where("status", GLOBAL_STATUS_ACTIVE); 
            $query = $this->db->update($this->_table_role, [
                "status" => GLOBAL_STATUS_NOTACTIVE
            ]);

            if($query === FALSE)
                throw new Exception();

            return TRUE;
        } catch(Exception $e) {
            return FALSE;
        }
    }

    // public function insert($params = array()) {
    //     $module_id    = (isset($params["module_id"])) ? $params["module_id"] : "";
    //     $title        = (isset($params["title"])) ? $params["title"] : "";
    //     $content      = (isset($params["content"])) ? $params["content"] : "";
    //     $source       = (isset($params["source"])) ? $params["source"] : "";
    //     $status       = (isset($params["status"])) ? $params["status"] : "";
    //     $url          = (isset($params["url"])) ? $params["url"] : "";
    //     $arr_file     = (isset($params["arr_file"])) ? $params["arr_file"] : "";
    //     $data_assets  = array();
    //     $data_publish = array();

    //     // JIKA STATUS PUBLISH.. ISI PUBLISHED_BY DAN PUBLISHED_DATE-NYA
    //     if ($status == ARTICLE_STATUS_PUBLISH) {
    //         $data_publish = array(
    //             "published_by"   => $this->session->userdata(PREFIX_SESSION . "_USER_ID"),
    //             "published_date" => dateSekarang(),
    //             );
    //     }

    //     try {
    //         // MULAI TRANSAKSI
    //         $this->db->trans_begin();

    //         $data = array(
    //             "module_id"     => $module_id,
    //             "title"         => $title,
    //             "content"       => $content,
    //             "source"        => $source,
    //             "status"        => $status,
    //             "url"           => $url,
    //             "created_by"    => $this->session->userdata(PREFIX_SESSION . "_USER_ID"), 
    //             "created_date"  => dateSekarang(),
    //             "modified_by"   => $this->session->userdata(PREFIX_SESSION . "_USER_ID"), 
    //             "modified_date" => dateSekarang(),
    //             );
    //         $data = array_merge($data, $data_publish);

    //         $query = $this->db->insert($this->_table_article, $data);

    //         if($query === FALSE)
    //             throw new Exception();

    //         // ID YANG BARU SAJA DI INSERT 
    //         $insert_id = $this->db->insert_id();

    //         foreach ($arr_file as $key => $value) {
    //             if (empty($value))
    //                 continue;

    //             $value = (object) $value;
    //             $order = $value->order;
    //             $block = $value->block;
    //             $type  = $value->type;

    //             $data_assets[] = array(
    //                 "article_id"    => $insert_id,
    //                 "order"         => $order,
    //                 "block"         => $block,
    //                 "type"          => $type,
    //                 "created_by"    => $this->session->userdata(PREFIX_SESSION . "_USER_ID"),
    //                 "created_date"  => dateSekarang(),
    //                 "modified_by"   => $this->session->userdata(PREFIX_SESSION . "_USER_ID"),
    //                 "modified_date" => dateSekarang(),
    //                 );
    //         }

    //         // JIKA DATA GAMBAR / VIDEO ANNOUNCER ADA.. INSERT KE TABEL article_assets
    //         if (count($data_assets) > 0) {
    //             $query = $this->db->insert_batch($this->_table_article_assets, $data_assets);

    //             if($query === FALSE)
    //                 throw new Exception();
    //         }
            
    //         // COMMIT TRANSAKSI
    //         $this->db->trans_commit();

    //         return TRUE;
    //     } catch(Exception $e) {
    //         // ROLLBACK TRANSAKSI
    //         $this->db->trans_rollback();

    //         return FALSE;
    //     }
    // }

    // public function update($params = array()) {
    //     $id             = (isset($params["id"])) ? $params["id"] : "";
    //     $module_id      = (isset($params["module_id"])) ? $params["module_id"] : "";
    //     $title          = (isset($params["title"])) ? $params["title"] : "";
    //     $content        = (isset($params["content"])) ? $params["content"] : "";
    //     $source         = (isset($params["source"])) ? $params["source"] : "";
    //     $status         = (isset($params["status"])) ? $params["status"] : "";
    //     $url            = (isset($params["url"])) ? $params["url"] : "";
    //     $arr_file       = (isset($params["arr_file"])) ? $params["arr_file"] : "";
    //     $arr_id_img     = (isset($params["arr_id_img"])) ? $params["arr_id_img"] : "";
    //     $arr_img_delete = (isset($params["arr_img_delete"])) ? $params["arr_img_delete"] : "";
    //     $data_assets    = array();
    //     $data_publish   = array();

    //     // JIKA STATUS PUBLISH.. ISI PUBLISHED_BY DAN PUBLISHED_DATE-NYA
    //     if ($status == ARTICLE_STATUS_PUBLISH) {
    //         $data_publish = array(
    //             "published_by"   => $this->session->userdata(PREFIX_SESSION . "_USER_ID"),
    //             "published_date" => dateSekarang(),
    //             );
    //     }

    //     try {
    //         // MULAI TRANSAKSI
    //         $this->db->trans_begin();

    //         $data = array(
    //             "module_id"     => $module_id,
    //             "title"         => $title,
    //             "content"       => $content,
    //             "source"        => $source,
    //             "status"        => $status,
    //             "url"           => $url,
    //             "modified_by"   => $this->session->userdata(PREFIX_SESSION . "_USER_ID"), 
    //             "modified_date" => dateSekarang(),
    //             );
    //         $data = array_merge($data, $data_publish);

    //         $this->db->where("id", $id);
    //         $query = $this->db->update($this->_table_article, $data);

    //         if($query === FALSE)
    //             throw new Exception();

    //         // INSERT GAMBAR
    //         if (!empty($arr_file)) {
    //             // INSERT DATA GAMBAR
    //             foreach ($arr_file as $key => $value) {
    //                 // ID GAMBAR
    //                 $id_img = (isset($arr_id_img[$key])) ? $arr_id_img[$key] : 0;

    //                 if (empty($value)) {
    //                     // APAKAH ADA GAMBAR YANG SEELUMNYA ADA DAN PADA SAAT UPDATE GAMBAR TERSEBUT DIHAPUS
    //                     $img_delete = (isset($arr_img_delete[$key])) ? $arr_img_delete[$key] : 0;

    //                     if ($img_delete) {
    //                         // HAPUS DATA GAMBAR TERLEBIH DAHULU
    //                         $this->db->where("id", $id_img);
    //                         $query = $this->db->delete($this->_table_article_assets);

    //                         if($query === FALSE)
    //                             throw new Exception();
    //                     }   

    //                     continue;
    //                 } else {
    //                     $value = (object) $value;
    //                     $order = $value->order;
    //                     $block = $value->block;
    //                     $type  = $value->type;
    //                 }

    //                 // HAPUS DATA GAMBAR TERLEBIH DAHULU
    //                 $this->db->where("id", $id_img);
    //                 $query = $this->db->delete($this->_table_article_assets);

    //                 if($query === FALSE)
    //                     throw new Exception();

    //                 $data_assets[] = array(
    //                     "article_id"    => $id,
    //                     "order"         => $order,
    //                     "block"         => $block,
    //                     "type"          => $type,
    //                     "created_by"    => $this->session->userdata(PREFIX_SESSION . "_USER_ID"),
    //                     "created_date"  => dateSekarang(),
    //                     "modified_by"   => $this->session->userdata(PREFIX_SESSION . "_USER_ID"),
    //                     "modified_date" => dateSekarang(),
    //                     );
    //             }

    //             if (count($data_assets) > 0) {
    //                 $query = $this->db->insert_batch($this->_table_article_assets, $data_assets);

    //                 if($query === FALSE)
    //                     throw new Exception();
    //             }
    //         }
            
    //         // COMMIT TRANSAKSI
    //         $this->db->trans_commit();

    //         return TRUE;
    //     } catch(Exception $e) {
    //         // ROLLBACK TRANSAKSI
    //         $this->db->trans_rollback();

    //         return FALSE;
    //     }
    // }

}