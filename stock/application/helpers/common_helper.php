<?php

require_once FCPATH . 'vendor/autoload.php';
use third_party\sso\NotAttachedException;
// use Jasny\SSO\Exception as SsoException;

if(!function_exists("pre")){
    function pre($param = array()){
        echo "<PRE>";
        var_dump($param);
        exit;
    }
}

if(!function_exists("instance"))
{
    function instance() 
    {
        $ci =& get_instance();

        return $ci;
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

if(!function_exists("generate_array")) {
    function generate_array($data, $column_index, $column_value, $column_attribute = array()) {
        $result = "";

        foreach ($data as $key => $value) {
            if ($column_index === FALSE)
                $result[] = $value->{$column_value};
            else {
                $reformat = "";
                foreach ($column_attribute as $value_col_attr) {
                    if (isset($value_col_attr["format"]) and isset($value_col_attr["value"]) and isset($value_col_attr["type"])) {
                        $format          = $value_col_attr["format"];
                        $value_attribute = ($value_col_attr["type"] == "DYNAMIC") ? $value->{$value_col_attr["value"]} : $value_col_attr["value"];

                        $reformat .= str_replace("#REPLACE#", $value_attribute, $format);
                    }
                }

                $val = trim($value->{$column_value} ." ". $reformat);

                if (is_array($column_index)) {
                    $index = "";
                    $str = "";

                    foreach ($column_index as $key1 => $value1)
                        $index .= ($value1 === FALSE) ? "[]" : "[".strtoupper($value->{$value1})."]";
                    
                    $str = "result$index=".$val;

                    parse_str($str);
                } else {
                    $result[strtoupper($value->{$column_index})] = $val;
                }
            }
        }

        return (is_array($result)) ? $result : array(0);
    }
}

if(!function_exists("clean_text_and_space")) 
{
    function clean_text_and_space($teks, $separator = "") {
        $find = array( '|<(.*?)>|', '|</(.*?)>|', '|[_]{1,}|', '|[ ]{1,}|', '|[^a-zA-Z0-9\/\:\-.]|', '|[-]{2,}|', '|[,]|', '|:|', '|quot|', '|039|', '|[.]{2,}|', '|[.]{3,}|', '|[/]|' );
        $replace = array( $separator, $separator, $separator, $separator, $separator, $separator, $separator, $separator, $separator, $separator, $separator, $separator, $separator );

        $newname = preg_replace( $find, $replace, $teks );

        return $newname;
    }
}

if(!function_exists('csv_to_array'))
{
    function csv_to_array($filename='', $delimiter=',')
    {
        if(!file_exists($filename) || !is_readable($filename))
            return FALSE;

        $header = NULL;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== FALSE)
        {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
            {
                if(!$header)
                    $header = $row;
                else
                    $data[] = array_combine($header, $row);
            }
            fclose($handle);
        }
        return $data;
    }
}    

// if(!function_exists("is_logged_in")) 
// {
//     function is_logged_in($bool = FALSE) 
//     {
//         instance()->load->library("session");

//         $ses_user_data = instance()->session->userdata(PREFIX_SESSION . "_USER_ID");

        // if($bool === FALSE){
        //     if($ses_user_data){
        //         redirect("dashboard");
        //     }
        // } else if($bool === TRUE){
        //     if(!$ses_user_data){
        //         redirect("auth");
        //     }
        // }
//     }
// }

if(!function_exists("is_logged_in")) 
{
    function is_logged_in($bool = FALSE) 
    {
        instance()->load->library("session");

        $is_exist = True;

        $broker = new third_party\sso\Broker(SSO_SERVER, SSO_BROKER_ID, SSO_BROKER_SECRET);
        $broker->attach(true);
        
        try {
            $user = $broker->getUserInfo();
            
            if (empty($user)) {
                throw new Exception();
            }
            
            instance()->session->set_userdata($user);
        } 
        catch (NotAttachedException $e) {
            $is_exist = False;
        } 
        // catch (SsoException $e) {
        //     $is_exist = False;
        // }
        catch (Exception $e) {
            $is_exist = False;
        }

        if($bool === FALSE) {
            if($is_exist) {
                redirect("dashboard");
            }
        } else if($bool === TRUE) {
            if(!$is_exist) {
                redirect(SSO_SERVER_LOGIN);
            }
        }
    }
}

if(!function_exists("check_access_module_permission")) 
{
    function check_access_module_permission($module, $permission, $redirect = False) 
    {
        if (!isset(instance()->session->userdata(PREFIX_SESSION . "_ALL_ACCESS")["module_permission"][$module][$permission])) {
            if ($redirect) {
                redirect("dashboard", "refresh");
            }
            else {
                return False;                
            }
        }

        return True;
    }
}

if(!function_exists("insert_logs")) 
{
    function insert_logs($module_code, $activity, $foreign_id, $created_by, $note = null) 
    {
        instance()->load->model("sector/Logsmodel");

        $result = [
            "status"  => False,
            "message" => "Log failed created.",
        ];

        // Get detail data
        $params = array(
            "code" => $module_code,
            );
        $all_data = instance()->Logsmodel->get_detail_module($params);

        if ($all_data) {
            $data_create = [
                "module_id"     => $all_data->id,
                "activity"      => $activity,
                "note"          => $note,
                "foreign_id"    => $foreign_id,
                "created_by"    => $created_by, 
                "created_date"  => date_now(),
                "modified_by"   => $created_by, 
                "modified_date" => date_now(),
            ];

            $action = instance()->Logsmodel->create($data_create);

            $result["status"]  = $action;
            $result["message"] = ($action) ? "Log successfully created." : "Log failed created.";
        }

        return $result;
    }
}