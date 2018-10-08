<?php
Class Dashboardmodel extends CI_Model{

    public function retrieve_role_menu($data)
        {
                $this->db->select('mn.name menu_name, mn.parent_id');
                $this->db->from('role_menu rm');
                $this->db->join('menu mn', 'mn.id=rm.menu_id', 'left');
                $this->db->join('role rl', 'rl.id=rm.role_id', 'left');

                if(isset($data['filters']) and $data['filters'] !=='') {
                    $this->db->where($data['filters']);
                }
                if(isset($data['orderby']) and $data['orderby'] !=='') {
                    $this->db->order_by($data['orderby']);
                }else{
                    $this->db->order_by('rm.created_date');
                }
                $query = $this->db->get();
                if($query->num_rows() != 0)
                {
                    $response = array("status" => true, "data" => $query->result());
                    return $response;
                }
                else {
                    return $response = array("status" => false, "data" => "NULL");
                }
    
        }

}