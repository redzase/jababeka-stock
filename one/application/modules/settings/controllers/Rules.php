<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rules extends MY_Controller 
{

    private $_module = "RULES";
    private $_image_path = "";
    private $_image_name = "";

    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('Rulesmodel');
        $this->load->model('master/Typemodel');
        $this->load->model('master/Statusmodel');

        $this->form_validation->CI =& $this;
    }

    public function index($page = 1){

        // Check access module permission
        // check_access_module_permission($this->_module, PERMISSION_READ, True);

        // If no sector_id defined, redirect to dashboard page
        $page        = ($page < 1) ? 1 : ($page - 1); 
        $start_limit = $page * TOTAL_ITEM_PER_PAGE;
        $end_limit   = TOTAL_ITEM_PER_PAGE;
        $total       = 0;

        $params = array(
            "start_limit" => $start_limit,
            "end_limit"   => $end_limit,
            );

        $all_data = $this->Rulesmodel->get_list($params);

        $params = array(
            "get_total" => TRUE,
            );
        $total = $this->Rulesmodel->get_list($params);  

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

    private function _do_add() 
    {
        $id_type     = $this->input->post("select_type") ?: "";
        $id_status   = $this->input->post("select_status") ?: "";
        $sequence    = $this->input->post("sequence") ?: "";

        /**
         * -- Start -- 
         * Do validation
         */
        $config = array(
            array(
                "field" => "sequence",
                "label" => "Sequence",
                "rules" => "required",
                ),
            array(
                "field" => "select_type",
                "label" => "Type Ticket",
                "rules" => "required",
                ),
            array(
                "field" => "select_status",
                "label" => "Status Order",
                "rules" => "required",
                )
            );

        $this->form_validation->set_rules($config);
        /**
         * Do validation
         * -- End -- 
         */

        $dt_type = $this->Typemodel->get_detail_by_id(array("id" => $id_type));
        $dt_status = $this->Statusmodel->get_detail_by_id(array("id" => $id_status));

        if ($this->form_validation->run()) {

            // Check if has rules order already exists
            $params = array(
                "id_type"       => $id_type,
                "id_status"     => $id_status,
                "is_deleted"    => NULL
            );

            $check_rules_order = $this->Rulesmodel->get_detail_by_params($params);
            if ($check_rules_order){
                $result["status"]  = FALSE;
                $result["message"] = sprintf("Rules with type <b><i>%s</i></b>, status order <b><i>%s</i></b> is already exists", $dt_type->name, $dt_status->name);
                $this->session->set_flashdata(PREFIX_SESSION ."_FORM_RESULT_PROCESS", $result);
                return false;
            }

            // Check if has rules order already exists
            $params = array(
                "id_type"       => $id_type,
                "sort_number"     => $sequence,
                "is_deleted"    => NULL
            );

            $check_rules_order = $this->Rulesmodel->get_detail_by_params($params);
            if ($check_rules_order){
                $result["status"]  = FALSE;
                $result["message"] = sprintf("Rules with sequence <b><i>%s</i></b> is already exists", $sequence);
                $this->session->set_flashdata(PREFIX_SESSION ."_FORM_RESULT_PROCESS", $result);
                return false;
            }

            $data_create = [
                "id_type"          => $id_type,
                "id_status"          => $id_status,
                "sort_number"          => $sequence,
                "created_by"    => $this->session->userdata(PREFIX_SESSION . "_USER_ID"), 
                "created_at"    => date_now(),
                "updated_by"   => $this->session->userdata(PREFIX_SESSION . "_USER_ID"), 
                "updated_at"   => date_now(),
            ];

            $action = $this->Rulesmodel->create($data_create);

            $result["status"]  = $action;
            $result["message"] = ($action) ? "Rules successfully created." : "Rules failed created.";

            // Store session
            $this->session->set_flashdata(PREFIX_SESSION ."_RESULT_PROCESS", $result);

            redirect($this->class_metadata["module"] ."/". $this->class_metadata["class"] ."/", "refresh");
        }
    }

    public function add()
    {
        // If submit
        if ($this->input->post()) {
            self::_do_add();
        }

        // $list_type = $this->input->get("select_type[]") ?: "";

        // $filter = [
        //     "list_type" => $list_type,
        // ];

        $params = array(
            'order_by'  => 'name',
            'sort_by'   => 'ASC',
        );
        $all_data_type = $this->Typemodel->get_list($params);

        $params = array(
            'order_by'  => 'name',
            'sort_by'   => 'ASC',
        );
        $all_data_status = $this->Statusmodel->get_list($params);

        $data_content["all_data_type"]      = $all_data_type;
        $data_content["all_data_status"]    = $all_data_status;
        $data_content["list_type"]          = generate_array($all_data_type, "id", "name");
        $data_content["list_status"]        = generate_array($all_data_status, "id", "name");

        $this->load->view($this->class_metadata["module"] ."/". $this->class_metadata["class"] ."/form", $data_content);
    }

    private function _do_edit($id) 
    {
        $id_type     = $this->input->post("select_type") ?: "";
        $id_status   = $this->input->post("select_status") ?: "";
        $sequence    = $this->input->post("sequence") ?: "";

        /**
         * -- Start -- 
         * Do validation
         */
        $config = array(
            array(
                "field" => "sequence",
                "label" => "Sequence",
                "rules" => "required",
                ),
            array(
                "field" => "select_type",
                "label" => "Type Ticket",
                "rules" => "required",
                ),
            array(
                "field" => "select_status",
                "label" => "Status Order",
                "rules" => "required",
                )
            );

        $this->form_validation->set_rules($config);
        /**
         * Do validation
         * -- End -- 
         */

        $dt_type = $this->Typemodel->get_detail_by_id(array("id" => $id_type));
        $dt_status = $this->Statusmodel->get_detail_by_id(array("id" => $id_status));

        if ($this->form_validation->run()) {

            // Check if has rules order already exists
            $params = array(
                "id_type"       => $id_type,
                "id_status"     => $id_status,
                "is_deleted"    => NULL
            );

            $check_rules_order = $this->Rulesmodel->get_detail_by_params($params);
            if ($check_rules_order and $check_rules_order->id !== $id){
                $result["status"]  = FALSE;
                $result["message"] = sprintf("Rules with type <b><i>%s</i></b>, status order <b><i>%s</i></b> is already exists", $dt_type->name, $dt_status->name);
                $this->session->set_flashdata(PREFIX_SESSION ."_FORM_RESULT_PROCESS", $result);
                return false;
            }

            // Check if has rules order already exists
            $params = array(
                "id_type"       => $id_type,
                "sort_number"   => $sequence,
                "is_deleted"    => NULL
            );

            $check_rules_order = $this->Rulesmodel->get_detail_by_params($params);
            if ($check_rules_order and $check_rules_order->id !== $id){
                $result["status"]  = FALSE;
                $result["message"] = sprintf("Rules with type <b><i>%s</i></b>, sequence <b><i>%s</i></b> is already exists", $dt_type->name, $sequence);
                $this->session->set_flashdata(PREFIX_SESSION ."_FORM_RESULT_PROCESS", $result);
                return false;
            }

            $data_update = array_merge([
                "id_type"          => $id_type,
                "id_status"          => $id_status,
                "sort_number"          => $sequence,
                "updated_by"   => $this->session->userdata(PREFIX_SESSION . "_USER_ID"), 
                "updated_at"   => date_now(),
            ]);

            $action = $this->Rulesmodel->update($id, $data_update);

            $result["status"]  = $action;
            $result["message"] = ($action) ? "Rules successfully updated." : "Rules failed updated.";

            // Store session
            $this->session->set_flashdata(PREFIX_SESSION ."_RESULT_PROCESS", $result);

            redirect($this->class_metadata["module"] ."/". $this->class_metadata["class"] ."/", "refresh");
        }
    }

    public function edit($id)
    {
        // If submit
        if ($this->input->post()) {
            self::_do_edit($id);
        }

        // $list_type = $this->input->get("select_type[]") ?: "";

        // $filter = [
        //     "list_type" => $list_type,
        // ];

        $params = array(
            'order_by'  => 'name',
            'sort_by'   => 'ASC',
        );
        $all_data_type = $this->Typemodel->get_list($params);

        $params = array(
            'order_by'  => 'name',
            'sort_by'   => 'ASC',
        );
        $all_data_status = $this->Statusmodel->get_list($params);

        // Get detail data
        $params = array(
            "id"        => $id,
            );
        $all_data = $this->Rulesmodel->get_detail_by_id($params);

        /**
         * -- Start --
         * Store data for view
         */
        $data_content["all_data"]           = $all_data;
        $data_content["all_data_type"]      = $all_data_type;
        $data_content["all_data_status"]    = $all_data_status;
        $data_content["list_type"]          = generate_array($all_data_type, "id", "name");
        $data_content["list_status"]        = generate_array($all_data_status, "id", "name");
        /**
         * Store data for view
         * -- End --
         */

        $this->load->view($this->class_metadata["module"] ."/". $this->class_metadata["class"] . "/form", $data_content);
    }

    public function delete($id) 
    {
        $action = $this->Rulesmodel->delete($id);

        if ($action === TRUE) {
            $return = array(
                "status"  => TRUE,
                "message" => "Rules successfully deleted.",
                );
        } else {
            $return = array(
                "status"  => FALSE,
                "message" => "Rules failed deleted.",
                );
        }

        $this->session->set_flashdata(PREFIX_SESSION . "_RESULT_PROCESS", $return);

        redirect($this->class_metadata["module"] ."/". $this->class_metadata["class"] ."/", "refresh");
    }

}
