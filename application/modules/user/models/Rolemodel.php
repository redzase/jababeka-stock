<?php
Class Rolemodel extends CI_Model{


    public function insert_entry($table="role", $data)
    {       
            $result = $this->db->insert($table, $data);
            $insert_id = $this->db->insert_id();
            return  $insert_id;
    }  

    public function update_data($table="role", $data)
    {       

            $result = $this->db->where($data['filters'])
                ->update($table="role", $data['data']);
            
    }

    public function retrieve_role($data)
        {
                $this->db->select('role.*');
                $this->db->from('role ');
                // $this->db->join('product_update_assets pr_u_ast', 'pr_u.id=pr_u_ast.product_update_id', 'left');
                
                if(isset($data['filters']) and $data['filters'] !=='') {
                    $this->db->where($data['filters']);
                }
                if(isset($data['orderby']) and $data['orderby'] !=='') {
                    $this->db->order_by($data['orderby']);
                }else{
                    $this->db->order_by('role.created_date');
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

    function all_count()
        {   
            $query = $this
                    ->db
                    ->where('is_deleted=0')
                    ->get('role');
        
            return $query->num_rows();  
    
        }
        
    function all($limit,$start,$col,$dir)
        {   
            $query = $this
                    ->db
                    ->where('is_deleted=0')
                    ->limit($limit,$start)
                    ->order_by($col,$dir)
                    ->get('role');
            
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
                    ->where('is_deleted=0')
                    ->like('role.id',$search)
                    ->or_like('name',$search)
                    ->limit($limit,$start)
                    ->order_by($col,$dir)
                    ->get('role');
            
            
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
                    ->where('is_deleted=0')
                    ->like('role.id',$search)
                    ->or_like('name',$search)
                    ->get('role');
        
            return $query->num_rows();
        } 

    
}