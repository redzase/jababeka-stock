<?php

function product_type($product_type){
    $response = "-";
    if ($product_type==1){
        $response = "Residential";
    }elseif($product_type==2){
        $response = "Commercial";
    }elseif($product_type==3){
        $response = "Kawasan";
    }
    return $response;
}

function status($product_status){
    $response = "-";
    if ($product_status==1){
        $response = "Active";
    }elseif($product_status==0){
        $response = "Not Active";
    }
    return $response;
}

function notif($notif_status){
    $response = "-";
    if ($notif_status==1){
        $response = "Enable";
    }elseif($notif_status==0){
        $response = "Disable";
    }
    return $response;
}


function is_coupon($coupon_status){
    $response = "-";
    if ($coupon_status==1){
        $response = "True";
    }elseif($coupon_status==0){
        $response = "False";
    }
    return $response;
}



function hash_password($password){
   return password_hash($password, PASSWORD_BCRYPT);
}


function menu($menu,$sub_menu=true){

    
    $credential = $_SESSION['credential'];

     //get main CodeIgniter object
     $ci =& get_instance();
       
     //load databse library
     $ci->load->database();
     	
		if (isset($credential['role_name'])){


            $ci->db->select('mn.name menu_name, mn.parent_id');
            $ci->db->from('role_menu rm');
            $ci->db->join('role rl', 'rl.id=rm.role_id', 'inner');
            $ci->db->join('menu mn', 'mn.id=rm.menu_id', 'inner');
            $ci->db->where("rl.name='".$credential['role_name']."'");
            
            $query = $ci->db->get();

            if($query->num_rows() != 0)
            {
                $get_role = array("status" => true, "data" => $query->result());
            }else{
                $get_role = array("status" => false, "data" => "NULL");
            }
    

			$tmp_menu = array();
            $tmp_sub_menu = array();
        
            
            if($get_role['status']==true){
                foreach($get_role['data'] as $row){
                    if ($row->parent_id==0){
                        array_push($tmp_menu, $row->menu_name);
                    }else{
                        array_push($tmp_sub_menu, $row->menu_name);
                    }
                }
            }else{
                return false; 
            }

    
			if ($sub_menu==true){
                if (in_array($menu, $tmp_sub_menu)){
                    return true;
                }
            }else{
                if (in_array($menu, $tmp_menu)){
                    return true;            
                }
            }
            return false;
		}else{
            return false;
        }

}


function permission($permission="",$menu=""){

    
    $credential = $_SESSION['credential'];

     //get main CodeIgniter object
     $ci =& get_instance();
       
     //load databse library
     $ci->load->database();
     	
		if (isset($credential['role_name'])){
            $ci
            ->db
            ->select('rmp.*, rl.name role_name, mn.name menu_name, mn.parent_id')
            ->from('role_menu_permission rmp')
            ->join('role_menu rm', 'rm.id=rmp.role_menu_id', 'left')
            ->join('role rl', 'rl.id=rm.role_id', 'left')
            ->join('menu mn', 'mn.id=rm.menu_id', 'left');

            $ci->db->where("rl.name='".$credential['role_name']."'");
            $ci->db->where("mn.name='".$menu."'");
            $ci->db->where("rmp.permission='".$permission."'");
            
            $query = $ci->db->get();

            if($query->num_rows() != 0)
            {
                return true;
            }else{
                return false;
            }
            return false;
		}else{
            return false;
        }

}

function send_broadcast_one_signal($data, $is_broadcast = true) {
    $content = array(
        "en" => $data["message"]
    );
    // $headings = array(
    //     "en" => "$headings"
    // );
    if ($is_broadcast) {
        $fields = array(
            'app_id' => ONE_SIGNAL_APPID,
            'contents' => $content,
            'included_segments' => ['All'],
            'data' => [
                'type' => $data["type"],
                'id' => $data["id"],
            ],
        );
    } 
    else {
        $fields = array(
            'app_id' => ONE_SIGNAL_APPID,
            'contents' => $content,
            'include_player_ids' => $data["player_ids"],
            'data' => [
                'type' => $data["type"],
                'id' => $data["id"],
            ],
        );
    }
    $fields = json_encode($fields);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, ONE_SIGNAL_URL);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8', 'Authorization: Basic '.ONE_SIGNAL_APPKEY));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    
    $response = curl_exec($ch);
    curl_close($ch);

    $response = json_decode($response, true);

    return isset($response["id"]) and !empty($response["id"]);
}