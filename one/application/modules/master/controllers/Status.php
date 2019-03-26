<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Status extends MY_Controller 
{

    private $_module = "MST_STATUS";
    private $_image_path = "";
    private $_image_name = "";

    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('Statusmodel');

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

        $all_data = $this->Statusmodel->get_list($params);

        $params = array(
            "get_total" => TRUE,
            );
        $total = $this->Statusmodel->get_list($params);  

        /**
         * -- Start --
         * Pagination
         */
        $base_url    = site_url($this->class_metadata["module"] ."/". $this->class_metadata["class"] ."/". $this->class_metadata["method"]);
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
        $name         = $this->input->post("name") ?: "";
        $status_order = $this->input->post("status_order") ?: "";

        /**
         * -- Start -- 
         * Do validation
         */
        $config = array(
            array(
                "field" => "name",
                "label" => "Name",
                "rules" => "required",
                ),
            array(
                "field" => "status_order",
                "label" => "Status Order",
                "rules" => "required",
                )
            );

        $this->form_validation->set_rules($config);
        /**
         * Do validation
         * -- End -- 
         */

        if ($this->form_validation->run()) {

            // Check if has status order is active
            // $params = array(
            //     "status_order"  => $status_order,
            //     "is_deleted"    => NULL
            // );

            // $check_status_order = $this->Statusmodel->get_detail_by_params($params);
            // if ($check_status_order){
            //     $result["status"]  = FALSE;
            //     $result["message"] = "Status order is already exists";
            //     $this->session->set_flashdata(PREFIX_SESSION ."_FORM_RESULT_PROCESS", $result);
            //     return false;
            // }

            $data_create = [
                "name"          => $name,
                "status_order"  => $status_order,
                "created_by"    => $this->session->userdata(PREFIX_SESSION . "_USER_ID"), 
                "created_at"    => date_now(),
                "updated_by"   => $this->session->userdata(PREFIX_SESSION . "_USER_ID"), 
                "updated_at"   => date_now(),
            ];

            $action = $this->Statusmodel->create($data_create);

            $result["status"]  = $action;
            $result["message"] = ($action) ? "Status successfully created." : "Status failed created.";

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

        $this->load->view($this->class_metadata["module"] ."/". $this->class_metadata["class"] ."/form");
    }

    private function _do_edit($id) 
    {
        $name         = $this->input->post("name") ?: "";
        $status_order = $this->input->post("status_order") ?: "";

        /**
         * -- Start -- 
         * Do validation
         */
        $config = array(
            array(
                "field" => "name",
                "label" => "Name",
                "rules" => "required",
                ),
            array(
                "field" => "status_order",
                "label" => "Status Order",
                "rules" => "required",
                )
            );

        $this->form_validation->set_rules($config);
        /**
         * Do validation
         * -- End -- 
         */

        if ($this->form_validation->run()) {

            // Check if has status order is active
            // $params = array(
            //     "status_order"  => $status_order,
            //     "is_deleted"    => NULL
            // );

            // $check_status_order = $this->Statusmodel->get_detail_by_params($params);
            // if ($check_status_order and $check_status_order->id !== $id){
            //     $result["status"]  = FALSE;
            //     $result["message"] = "Status order is already exists";
            //     $this->session->set_flashdata(PREFIX_SESSION ."_FORM_RESULT_PROCESS", $result);
            //     return false;
            // }

            $data_update = array_merge([
                "name"          => $name,
                "status_order"  => $status_order,
                "updated_by"    => $this->session->userdata(PREFIX_SESSION . "_USER_ID"), 
                "updated_at"  => date_now(),
            ]);

            $action = $this->Statusmodel->update($id, $data_update);

            $result["status"]  = $action;
            $result["message"] = ($action) ? "Status successfully updated." : "Status failed updated.";

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

        // Get detail data
        $params = array(
            "id"        => $id,
            );
        $all_data = $this->Statusmodel->get_detail_by_id($params);

        /**
         * -- Start --
         * Store data for view
         */
        $data_content["all_data"]  = $all_data;
        /**
         * Store data for view
         * -- End --
         */

        $this->load->view($this->class_metadata["module"] ."/". $this->class_metadata["class"] ."/form", $data_content);
    }

    public function delete($id) 
    {
        $action = $this->Statusmodel->delete($id);

        if ($action === TRUE) {
            $return = array(
                "status"  => TRUE,
                "message" => "Status successfully deleted.",
                );
        } else {
            $return = array(
                "status"  => FALSE,
                "message" => "Status failed deleted.",
                );
        }

        $this->session->set_flashdata(PREFIX_SESSION . "_RESULT_PROCESS", $return);

        redirect($this->class_metadata["module"] ."/". $this->class_metadata["class"] ."/", "refresh");
    }

}
