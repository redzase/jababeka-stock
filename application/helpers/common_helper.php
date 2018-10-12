<?php

if(!function_exists("pre")){
    function pre($param = array()){
        echo "<PRE>";
        var_dump($param);
        exit;
    }
}

if(!function_exists("set_config_pagination")) {
    function set_config_pagination($base_url, $suffix, $uri_segment, $total_rows, $per_page = TOTAL_ITEM_PER_PAGE, $num_links = TOTAL_NUM_LINKS) {
        $config = array();

        $config["base_url"]         = $base_url;
        $config["suffix"]           = $suffix;
        $config['uri_segment']      = $uri_segment;
        $config["total_rows"]       = $total_rows;
        $config["per_page"]         = $per_page;
        $config['num_links']        = $num_links;
        $config['full_tag_open']    = '<ul class="pagination">';
        $config['full_tag_close']   = '</ul>';
        $config['first_link']       = FALSE;
        $config['prev_link']        = '<i class="fa fa-angle-left"></i>';
        $config['prev_tag_open']    = '<li class="paginate_button">';
        $config['prev_tag_close']   = '</li>';
        $config['cur_tag_open']     = '<li class="paginate_button active"><a href="#">';
        $config['cur_tag_close']    = '</a></li>';
        $config['num_tag_open']     = '<li class="paginate_button">';
        $config['num_tag_close']    = '</li>';
        $config['next_link']        = '<i class="fa fa-angle-right"></i>';
        $config['next_tag_open']    = '<li class="paginate_button">';
        $config['next_tag_close']   = '</li>';
        $config['last_link']        = FALSE;
        $config['use_page_numbers'] = TRUE;

        return $config;
    }
}

if(!function_exists("get_validate_sess")) {
    function get_validate_sess($ses_result_process) {
        if (!empty($ses_result_process)) {
            if ($ses_result_process ["status"] === TRUE) {
                $class = "alert-success";
                $titleMessage = "Success!";
            } else {
                $class = "alert-danger";
                $titleMessage = "Error!";
            }
            
            echo "<div class=\"alert {$class}\">", "<strong>{$titleMessage}</strong><br />", $ses_result_process ["message"], "</div>";
        }
    }
}

if(! function_exists("date_now")){
    function date_now($act = 1, $param = FALSE) {
        if ($param === NULL OR $param == "0000-00-00 00:00:00")
            return "-";

        if ($act == 1) {
            return date("Y-m-d H:i:s");
        } else if ($act == 2) {
            return date("Y-m-d");
        } else if ($act == 3) {
            return date("d F Y H:i", strtotime($param));
        } else if ($act == 4) {
            return date("d F Y", strtotime($param));
        } else if ($act == 5) {
            return date("Y/m/d");
        } else if ($act == 6) {
            return date("d/m/Y H:i");
        } else if ($act == 7) {
            $paramex = explode("/", substr($param, 0, 10));
            $jam = substr($param, 11, 6);
            return "{$paramex[2]}-{$paramex[1]}-{$paramex[0]} {$jam}";
        } else if ($act == 8) {
            return date("d M Y");
        } else if ($act == 9) {
            return date("Ymd");
        } else if ($act == 10) {
            $paramex = explode("/", substr($param, 0, 10));
            return "{$paramex[2]}-{$paramex[1]}-{$paramex[0]}";
        } else if ($act == 11) {
            $paramex = explode("-", substr($param, 0, 10));
            return "{$paramex[2]}-{$paramex[1]}-{$paramex[0]}";
        } else if ($act == 12) {
            return date("d F Y H:i:s", strtotime($param));
        } else if ($act == 13) {
            return date("d F Y", strtotime($param));
        } else if ($act == 14) {
            return date("H:i", strtotime($param));
        } else if ($act == 15) { 
            return date("d", strtotime($param));
        } else if ($act == 16) {
            return date("m", strtotime($param));
        } else if ($act == 17) {
            return date("Y", strtotime($param));
        } else if ($act == 18) {
            return date("Y-m-d H:i:s", strtotime($param));
        } else if ($act == 19) {
            return date("Y-m-d", strtotime($param));
        } else if ($act == 20) {
            return date("Y-m-d H:i", strtotime($param));
        } else if ($act == 21) {
            return date("d F Y H:i", strtotime($param));
        } else if ($act == 22) {
            return date("d-m-Y", strtotime($param));
        }
    }
}

if(!function_exists("get_validate_form")) {
    function get_validate_form() {
        if (validation_errors () != FALSE) : 
            echo "<div class=\"alert alert-danger\">", "<strong>Error!</strong><br />", validation_errors (), "</div>";
        endif;
    }
}













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