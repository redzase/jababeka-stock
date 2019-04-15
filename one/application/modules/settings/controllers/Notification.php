<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notification extends MY_Controller 
{

    private $_module = "NOTIFICATION";
    private $_image_path = "";
    private $_image_name = "";

    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('Notificationmodel');
        $this->load->model('master/Typemodel');
        $this->load->model('master/Statusmodel');

        $this->form_validation->CI =& $this;
    }

    public function index($id_type = NULL, $page = 1){

        // Check access module permission
        // check_access_module_permission($this->_module, PERMISSION_READ, True);

        if ($id_type == NULL){
            redirect('/dashboard', "refresh");
        }

        // CHeck if status in type
        if ($id_type !== NULL){
            $where_check_type_status = array(
                "id" => $id_type
            );

            $check_type_status = $this->Typemodel->get_detail_by_id($where_check_type_status);
            if (!$check_type_status){
                $result["status"]  = FALSE;
                $result["message"] = sprintf("Unknown parameters, Please try again");
                $this->session->set_flashdata(PREFIX_SESSION ."_RESULT_PROCESS", $result);
                redirect('/dashboard', "refresh");
            }
        }

        // If no sector_id defined, redirect to dashboard page
        $page        = ($page < 1) ? 1 : ($page - 1); 
        $start_limit = $page * TOTAL_ITEM_PER_PAGE;
        $end_limit   = TOTAL_ITEM_PER_PAGE;
        $total       = 0;

        $params = array(
            "start_limit" => $start_limit,
            "end_limit"   => $end_limit,
            "id_type" => $id_type
            );

        $all_data = $this->Notificationmodel->get_list($params);

        $params = array(
            "get_total" => TRUE,
            );
        $total = $this->Notificationmodel->get_list($params);  

        /**
         * -- Start --
         * Pagination
         */
        $base_url    = site_url($this->class_metadata["module"] . $this->class_metadata["method"]);
        $uri_segment = 4;
        $total_rows  = $total;
        $per_page    = TOTAL_ITEM_PER_PAGE;
        $suffix      = "";
        // $suffix   = ($search <> "") ? "?q={$search}" : "";
        
        $config = set_config_pagination($base_url, $suffix, $uri_segment, $total_rows, $per_page); 

        $this->pagination->initialize($config);
        /**
         * Pagination
         * -- End --
         */

        /**
         * -- Start --
         * Store data for view
         */
        $get_name_type = $this->Typemodel->get_detail_by_id(array("id" => $id_type))->name;

        $data_content['id_type']            = $id_type;
        $data_content['name_type']          = $get_name_type;
        $data_content["all_data"]           = $all_data; 
        $data_content["total"]              = $total;
        $data_content["start_no"]           = ($page * TOTAL_ITEM_PER_PAGE) + 1;
        $data_content["pagination"]         = $this->pagination->create_links();
        $data_content["ses_result_process"] = $this->session->flashdata(PREFIX_SESSION . "_RESULT_PROCESS");
        $data_content["module"]             = $this->_module;
        /**
         * Store data for view
         * -- End --
         */

        $this->load->view($this->class_metadata["module"] ."/". $this->class_metadata["class"] ."/index", $data_content);

    }

    private function _do_add($id_type = NULL) 
    {
        $id_user     = $this->input->post("select_user") ?: "";
        $days        = $this->input->post("days") ?: "";

        /**
         * -- Start -- 
         * Do validation
         */
        $config = array(
            array(
                "field" => "days",
                "label" => "Days",
                "rules" => "required",
                ),
            array(
                "field" => "select_user",
                "label" => "User",
                "rules" => "required",
                )
            );

        $this->form_validation->set_rules($config);
        /**
         * Do validation
         * -- End -- 
         */

        $dt_user = $this->Notificationmodel->get_user_by_params(array("id" => $id_user));

        if ($this->form_validation->run()) {

            // Check if has rules order already exists
            $params = array(
                "id_user"       => $id_user,
                "id_type"       => $id_type,
                "is_deleted"    => NULL
            );

            $check_notification = $this->Notificationmodel->get_detail_by_params($params);
            if ($check_notification){
                $result["status"]  = FALSE;
                $result["message"] = sprintf("Notification for user <b><i>%s</i></b> is already exists", $dt_user->username);
                $this->session->set_flashdata(PREFIX_SESSION ."_FORM_RESULT_PROCESS", $result);
                return false;
            }

            $data_create = [
                "id_user"          => $id_user,
                "id_type"          => $id_type,
                "days"          => $days,
                "created_by"    => $this->session->userdata(PREFIX_SESSION . "_USER_ID"), 
                "created_at"    => date_now(),
                "updated_by"   => $this->session->userdata(PREFIX_SESSION . "_USER_ID"), 
                "updated_at"   => date_now(),
            ];

            $action = $this->Notificationmodel->create($data_create);

            $result["status"]  = $action;
            $result["message"] = ($action) ? "Notification successfully created." : "Notification failed created.";

            // Store session
            $this->session->set_flashdata(PREFIX_SESSION ."_RESULT_PROCESS", $result);

            redirect($this->class_metadata["module"] . '/' . $this->class_metadata["class"] . '/index/' . $id_type, "refresh");
        }
    }

    public function add($id_type = NULL)
    {
        // If submit
        if ($this->input->post()) {
            self::_do_add($id_type);
        }

        $params = array(
            'order_by'  => 'username',
            'sort_by'   => 'ASC',
        );
        $all_data_user = $this->Notificationmodel->get_list_user($params);

        $get_name_type = $this->Typemodel->get_detail_by_id(array("id" => $id_type))->name;

        $data_content['id_type']            = $id_type;
        $data_content['name_type']            = $get_name_type;
        $data_content["all_data_user"]      = $all_data_user;
        $data_content["list_user"]          = generate_array($all_data_user, "id", "username");

        $this->load->view($this->class_metadata["module"] ."/". $this->class_metadata["class"] ."/form", $data_content);
    }

    private function _do_edit($id_type = NULL, $id) 
    {
        $id_user     = $this->input->post("select_user") ?: "";
        $days        = $this->input->post("days") ?: "";

        /**
         * -- Start -- 
         * Do validation
         */
        $config = array(
            array(
                "field" => "days",
                "label" => "Days",
                "rules" => "required",
                ),
            array(
                "field" => "select_user",
                "label" => "User",
                "rules" => "required",
                )
            );

        $this->form_validation->set_rules($config);
        /**
         * Do validation
         * -- End -- 
         */

        $dt_user = $this->Notificationmodel->get_user_by_params(array("id" => $id_user));

        if ($this->form_validation->run()) {

            // Check if has rules order already exists
            $params = array(
                "id_user"       => $id_user,
                "id_type"          => $id_type,
                "is_deleted"    => NULL
            );

            $check_notification = $this->Notificationmodel->get_detail_by_params($params);
            if ($check_notification and $check_notification->id !== $id){
                $result["status"]  = FALSE;
                $result["message"] = sprintf("Notification with user <b><i>%s</i></b> is already exists", $dt_user->username);
                $this->session->set_flashdata(PREFIX_SESSION ."_FORM_RESULT_PROCESS", $result);
                return false;
            }

            $data_update = array_merge([
                "id_user"          => $id_user,
                "id_type"          => $id_type,
                "days"          => $days,
                "updated_by"   => $this->session->userdata(PREFIX_SESSION . "_USER_ID"), 
                "updated_at"   => date_now(),
            ]);

            $action = $this->Notificationmodel->update($id, $data_update);

            $result["status"]  = $action;
            $result["message"] = ($action) ? "Notification successfully updated." : "Notification failed updated.";

            // Store session
            $this->session->set_flashdata(PREFIX_SESSION ."_RESULT_PROCESS", $result);

            redirect($this->class_metadata["module"] . '/' . $this->class_metadata["class"] . '/index/' . $id_type, "refresh");
        }
    }

    public function edit($id_type = NULL, $id)
    {
        // If submit
        if ($this->input->post()) {
            self::_do_edit($id_type, $id);
        }

        // $list_type = $this->input->get("select_type[]") ?: "";

        // $filter = [
        //     "list_type" => $list_type,
        // ];

        $params = array(
            'order_by'  => 'username',
            'sort_by'   => 'ASC',
        );
        $all_data_user = $this->Notificationmodel->get_list_user($params);

        // Get detail data
        $params = array(
            "id"        => $id,
            );
        $all_data = $this->Notificationmodel->get_detail_by_id($params);

        /**
         * -- Start --
         * Store data for view
         */
        $get_name_type = $this->Typemodel->get_detail_by_id(array("id" => $id_type))->name;

        $data_content['id_type']            = $id_type;
        $data_content['name_type']          = $get_name_type;
        $data_content["all_data"]           = $all_data;
        $data_content["all_data_user"]      = $all_data_user;
        $data_content["list_user"]          = generate_array($all_data_user, "id", "username");
        /**
         * Store data for view
         * -- End --
         */

        $this->load->view($this->class_metadata["module"] ."/". $this->class_metadata["class"] . "/form", $data_content);
    }

    public function delete($id_type = NULL, $id) 
    {
        $action = $this->Notificationmodel->delete($id);

        if ($action === TRUE) {
            $return = array(
                "status"  => TRUE,
                "message" => "Notification successfully deleted.",
                );
        } else {
            $return = array(
                "status"  => FALSE,
                "message" => "Notification failed deleted.",
                );
        }

        $this->session->set_flashdata(PREFIX_SESSION . "_RESULT_PROCESS", $return);

        redirect($this->class_metadata["module"] . '/' . $this->class_metadata["class"] . '/index/' . $id_type, "refresh");
    }

}
