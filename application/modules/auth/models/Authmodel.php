<?php
Class Authmodel extends CI_Model{


    public function login($data) {

        $condition = "username =" . "'" . $data['username'] . "'";
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where($condition);
        $this->db->limit(1);
        $query = $this->db->get();
        
        if($query->num_rows() != 0)
            {
                $response = array("status" => true, "data" => $query->result());
                return $response;
            }else{
                return $response = array("status" => false, "data" => "NULL");
        }
    }

   

    public function retrieve_admin($data)
        {
                $this->db->select('user.*,role.name');
                $this->db->from('user');
                $this->db->join('role', 'role.id=user.role_id', 'left');
                
                if(isset($data['filters']) and $data['filters'] !=='') {
                    $this->db->where($data['filters']);
                }
                if(isset($data['orderby']) and $data['orderby'] !=='') {
                    $this->db->order_by($data['orderby']);
                }else{
                    $this->db->order_by('user.created_date');
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

    public function retrieve_role()
        {
                $this->db->select('role.id,role.name');
                $this->db->from('role');
                $this->db->order_by('role.id');
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

    function all_count()
        {   
            $query = $this
                    ->db
                    ->get('user');
        
            return $query->num_rows();  
    
        }
        
    function all($limit,$start,$col,$dir)
        {   
            $query = $this
                    ->db
                    ->select('user.*,role.name  role_name, user.status  admin_status')
                    ->from('user')
                    ->join('role', 'role.id=user.role_id', 'left')
                    ->limit($limit,$start)
                    ->order_by($col,$dir)
                    ->get();
            
            if($query->num_rows()>0)
            {
                return $query->result(); 
            }
            else
            {
                return null;
            }
            
        }
        
    function search($limit,$start,$search,$col,$dir)
        {
            $query = $this
                    ->db
                    ->select('user.*,role.name  role_name, user.status  admin_status')
                    ->from('user')
                    ->join('role', 'role.id=user.role_id', 'left')
                    ->like('user.id',$search)
                    ->or_like('username',$search)
                    ->or_like('role.name',$search)
                    ->limit($limit,$start)
                    ->order_by($col,$dir)
                    ->get();
            
            
            if($query->num_rows()>0)
            {
                return $query->result();  
            }
            else
            {
                return null;
            }
        }
    
    function search_count($search)
        {
            $query = $this
                    ->db
                    ->select('user.*,role.name  role_name, user.status  admin_status')
                    ->from('user')
                    ->join('role', 'role.id=user.role_id', 'left')
                    ->like('user.id',$search)
                    ->or_like('username',$search)
                    ->or_like('role.name',$search)
                    ->get();
        
            return $query->num_rows();
        } 


    
}   