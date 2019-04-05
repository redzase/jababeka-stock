<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ticket extends MY_Controller 
{

    private $_module = "TICKET";
    private $_image_path = "";
    private $_image_name = "";

    public function __construct()
    {
        
        parent::__construct();
        $this->load->model('master/Typemodel');
        $this->load->model('master/Statusmodel');
        $this->load->model('settings/Rulesmodel');
        $this->load->model('Ticketmodel');
        $this->load->model('settings/Userdivisimodel');
    }

    public function index($id_type = NULL)
    {

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

        $get_name_type = $this->Typemodel->get_detail_by_id(array("id" => $id_type))->name;

        $data_content['id_type']            = $id_type;
        $data_content['name_type']          = $get_name_type;
        $data_content["ses_result_process"] = $this->session->flashdata(PREFIX_SESSION . "_RESULT_PROCESS");
        $this->load->view('index', $data_content);
    }

    public function list($id_type = NULL, $id_status = NULL, $page = 1)
    {

        // Check access module permission
        // check_access_module_permission($this->_module, PERMISSION_READ, True);
        $all_data_rules = array();
        if ($id_type !== NULL){
            $all_data_rules = $this->Rulesmodel->get_list_status_by_id_type($id_type, TRUE);
            if (!$all_data_rules){
                $result["status"]  = FALSE;
                $result["message"] = sprintf("Rules is not definition, please input rules first");
                $this->session->set_flashdata(PREFIX_SESSION ."_RESULT_PROCESS", $result);
                redirect($this->class_metadata["module"] ."/", "refresh");
            }

            // CHeck if status in type
            $where_check_type_status = array(
                "id_type" => $id_type,
                "is_deleted" => NULL
            );

            if ($id_status !== NULL){
                $where_check_type_status = array_merge(array("id_status" => $id_status), $where_check_type_status);
            }

            $check_type_status = $this->Rulesmodel->get_detail_by_params($where_check_type_status);
            if (!$check_type_status){
                $result["status"]  = FALSE;
                $result["message"] = sprintf("Unknown parameters, Please try again");
                $this->session->set_flashdata(PREFIX_SESSION ."_RESULT_PROCESS", $result);
                redirect($this->class_metadata["module"] ."/". $this->class_metadata["method"] ."/" . $id_type, "refresh");
            }

        }

        // get data first
        $where = array(
            'default'   => TRUE,
            'status_order' => 1,
            'is_deleted' => NULL
        );
        $data_status_first = $this->Statusmodel->get_detail_by_params($where);

        // If no sector_id defined, redirect to dashboard page
        $page        = ($page < 1) ? 1 : ($page - 1); 
        $start_limit = $page * TOTAL_ITEM_PER_PAGE;
        $end_limit   = TOTAL_ITEM_PER_PAGE;
        $total       = 0;

        $params = array(
            "start_limit" => $start_limit,
            "end_limit"   => $end_limit,
            );

        $where = array(
            "id_type" => $id_type,
            "is_deleted" => NULL
        );

        if ($id_status !== NULL){
            $where = array_merge(array("id_status" => $id_status), $where);
        }

        $all_data = $this->Ticketmodel->get_list_by_params($where, $params);

        $params = array(
            "get_total" => TRUE,
            );
        $total = $this->Ticketmodel->get_list_by_params($where, $params);  

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

        $get_name_type = $this->Typemodel->get_detail_by_id(array("id" => $id_type))->name;

        /**
         * -- Start --
         * Store data for view
         */
        
        $data_content['data_status_first']  = $data_status_first;
        $data_content['id_type']            = $id_type;
        $data_content['id_status']          = $id_status;
        $data_content['name_type']          = $get_name_type;
        $data_content["all_data"]           = $all_data;
        $data_content["all_data_rules"]     = $all_data_rules; 
        $data_content["total"]              = $total;
        $data_content["start_no"]           = ($page * TOTAL_ITEM_PER_PAGE) + 1;
        $data_content["pagination"]         = $this->pagination->create_links();
        $data_content["ses_result_process"] = $this->session->flashdata(PREFIX_SESSION . "_RESULT_PROCESS");
        $data_content["module"]             = $this->_module;
        /**
         * Store data for view
         * -- End --
         */

        $this->load->view($this->class_metadata["module"] ."/list", $data_content);
    }

    public function add($id_type = NULL)
    {
        if ($id_type !== NULL){
            $check_id_type = $this->Rulesmodel->get_list_by_id_type($id_type);
            if (!$check_id_type){
                $result["status"]  = FALSE;
                $result["message"] = sprintf("Rules is not definition, please input rules first");
                $this->session->set_flashdata(PREFIX_SESSION ."_FORM_RESULT_PROCESS", $result);
                redirect($this->class_metadata["module"] ."/list/" . $id_type, "refresh");
            }
        }

        // If submit
        if ($this->input->post()) {
            self::_do_add($id_type);
        }

        $all_data_rules = $this->Rulesmodel->get_list_by_id_type($id_type);

        $get_name_type = $this->Typemodel->get_detail_by_id(array("id" => $id_type))->name;

        $data_content['id_type']            = $id_type;
        $data_content['name_type']          = $get_name_type;
        $data_content["all_data_rules"]      = $all_data_rules;
        $data_content["list_rules"]          = generate_array($all_data_rules, "id_status", "status_order_name");

        $this->load->view($this->class_metadata["module"] ."/form", $data_content);
    }

    public function edit($id_type = NULL, $sort_number = NULL, $id = NULL)
    {
        // If submit
        if ($this->input->post()) {
            self::_do_edit($id_type, $id);
        }

        $all_data_rules = $this->Rulesmodel->get_list_by_id_type($id_type, $sort_number);

        $get_name_type = $this->Typemodel->get_detail_by_id(array("id" => $id_type))->name;

        $params = array(
            "id" => $id,
            );
        $all_data = $this->Ticketmodel->get_detail_by_id($params);

        $data_content['id_type']            = $id_type;
        $data_content['name_type']          = $get_name_type;
        $data_content["all_data_rules"]      = $all_data_rules;
        $data_content["all_data"]      = $all_data;
        $data_content["list_rules"]          = generate_array($all_data_rules, "id_status", "status_order_name");

        $this->load->view($this->class_metadata["module"] ."/form", $data_content);
    }

    private function _do_detail($id_type = NULL, $id = NULL) 
    {
        // get data first
        $id_status     = $this->input->post("status") ?: "";
        $title           = $this->input->post("title") ?: "";
        $description           = $this->input->post("description") ?: "";

        $data_create = [
            "id_status"          => $id_status,
            "updated_by"   => $this->session->userdata(PREFIX_SESSION . "_USER_ID"), 
            "updated_at"   => date_now(),
        ];

        $action = $this->Ticketmodel->update($id, $data_create);

        $result["status"]  = $action;
        $result["message"] = ($action) ? "Ticket successfully updated." : "Ticket failed updated.";

        // Store session
        $this->session->set_flashdata(PREFIX_SESSION ."_RESULT_PROCESS", $result);

        redirect($this->class_metadata["module"] ."/list/". $id_type . "/" . $id_status, "refresh");
    }

    private function _do_comment($id_type = NULL, $id_status = NULL, $id = NULL) 
    {
        // get data first
        $comment           = $this->input->post("comment") ?: "";

        $data_create = [
            "id_ticket"         => $id,
            "id_user"           => $this->session->userdata(PREFIX_SESSION . "_USER_ID"), 
            "comment"           => $comment,
            "created_at"        => date_now(),
        ];

        $action = $this->Ticketmodel->create_ticket($data_create);

        $result["status"]  = $action;
        $result["message"] = ($action) ? "Comment successfully created." : "Comment failed created.";

        // Store session
        $this->session->set_flashdata(PREFIX_SESSION ."_FORM_RESULT_PROCESS", $result);

        redirect($this->class_metadata["module"] ."/detail/". $id_type . "/" . $id_status . "/" . $id, "refresh");
    }

    public function detail($id_type = NULL, $id_status = NULL, $id = NULL)
    {
        // If submit
        if ($this->input->post()) {
            if (!empty($this->input->post("comment"))){
                self::_do_comment($id_type, $id_status, $id);
            }

            if (!empty($this->input->post("status"))){
                self::_do_detail($id_type, $id);
            }
        }

        $session_id_user = $this->session->userdata(PREFIX_SESSION . "_USER_ID");

        $params = array(
            "id_user"           => $session_id_user,
            "is_deleted"        => NULL
            );

        $all_data_divisi = $this->Userdivisimodel->get_detail_by_params();

        $params = array(
            "id_type"           => $id_type,
            "id_status_parent"  => $id_status,
            "id_divisi"         => $all_data_divisi->id_divisi
            );
        $all_data_rules = $this->Rulesmodel->get_list_with_detail_raw($params);

        $get_name_type = $this->Typemodel->get_detail_by_id(array("id" => $id_type))->name;

        $params = array(
            "id" => $id,
            );
        $all_data = $this->Ticketmodel->get_detail_by_id($params);

        $data_content['id_type']            = $id_type;
        $data_content['name_type']          = $get_name_type;
        $data_content["all_data_rules"]     = $all_data_rules;
        $data_content["all_data"]           = $all_data;

        $all_data_comment = $this->Ticketmodel->get_list_comment_by_id_ticket($id);

        $data_content["all_data_comment"]   = $all_data_comment;        

        $this->load->view($this->class_metadata["module"] ."/detail", $data_content);
    }

    private function _do_add($id_type = NULL) 
    {

        // get data first
        $where = array(
            'default'   => TRUE,
            'status_order' => 1,
            'is_deleted' => NULL
        );
        $data_status_first = $this->Statusmodel->get_detail_by_params($where);

        $id_status     = $data_status_first->id;
        $title           = $this->input->post("title") ?: "";
        $description           = $this->input->post("description") ?: "";

        /**
         * -- Start -- 
         * Do validation
         */
        $config = array(
            array(
                "field" => "title",
                "label" => "Title",
                "rules" => "required",
                )
            );

        $this->form_validation->set_rules($config);
        /**
         * Do validation
         * -- End -- 
         */


        if ($this->form_validation->run()) {

            $data_create = [
                "id_type"          => $id_type,
                "id_status"          => $id_status,
                "name"          => $title,
                "description"          => $description,
                "created_by"    => $this->session->userdata(PREFIX_SESSION . "_USER_ID"), 
                "created_at"    => date_now(),
                "updated_by"   => $this->session->userdata(PREFIX_SESSION . "_USER_ID"), 
                "updated_at"   => date_now(),
            ];

            $action = $this->Ticketmodel->create($data_create);

            $result["status"]  = $action;
            $result["message"] = ($action) ? "Ticket successfully created." : "Ticket failed created.";

            // Store session
            $this->session->set_flashdata(PREFIX_SESSION ."_RESULT_PROCESS", $result);

            redirect($this->class_metadata["module"] ."/list/". $id_type, "refresh");
        }
    }

    private function _do_edit($id_type = NULL, $id = NULL) 
    {
        // get data first
        $where = array(
            'default'   => TRUE,
            'status_order' => 1,
            'is_deleted' => NULL
        );
        $data_status_first = $this->Statusmodel->get_detail_by_params($where);
        
        $id_status     = $data_status_first->id;
        $title           = $this->input->post("title") ?: "";
        $description           = $this->input->post("description") ?: "";

        /**
         * -- Start -- 
         * Do validation
         */
        $config = array(
            array(
                "field" => "title",
                "label" => "Title",
                "rules" => "required",
                )
            );

        $this->form_validation->set_rules($config);
        /**
         * Do validation
         * -- End -- 
         */


        if ($this->form_validation->run()) {

            $data_create = [
                "id_type"          => $id_type,
                "id_status"          => $id_status,
                "name"          => $title,
                "description"          => $description,
                "created_by"    => $this->session->userdata(PREFIX_SESSION . "_USER_ID"), 
                "created_at"    => date_now(),
                "updated_by"   => $this->session->userdata(PREFIX_SESSION . "_USER_ID"), 
                "updated_at"   => date_now(),
            ];

            $action = $this->Ticketmodel->update($id, $data_create);

            $result["status"]  = $action;
            $result["message"] = ($action) ? "Ticket successfully created." : "Ticket failed created.";

            // Store session
            $this->session->set_flashdata(PREFIX_SESSION ."_RESULT_PROCESS", $result);

            redirect($this->class_metadata["module"] ."/list/". $id_type, "refresh");
        }
    }

    public function delete($id_type = NULL, $id = NULL) 
    {
        $action = $this->Ticketmodel->delete($id);

        if ($action === TRUE) {
            $return = array(
                "status"  => TRUE,
                "message" => "Ticket successfully deleted.",
                );
        } else {
            $return = array(
                "status"  => FALSE,
                "message" => "Ticket failed deleted.",
                );
        }

        $this->session->set_flashdata(PREFIX_SESSION . "_RESULT_PROCESS", $return);

        redirect($this->class_metadata["module"] ."/list/". $id_type, "refresh");
    }

}
