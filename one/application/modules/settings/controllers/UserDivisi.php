<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserDivisi extends MY_Controller 
{

    private $_module = "USER_DIVISI";
    private $_image_path = "";
    private $_image_name = "";

    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('Userdivisimodel');
        $this->load->model('master/Typemodel');
        $this->load->model('master/Statusmodel');
        $this->load->model('master/Divisimodel');

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

        $all_data = $this->Userdivisimodel->get_list($params);

        $params = array(
            "get_total" => TRUE,
            );
        $total = $this->Userdivisimodel->get_list($params);  

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
        $id_user     = $this->input->post("select_user") ?: "";
        $id_divisi   = $this->input->post("select_divisi") ?: "";

        /**
         * -- Start -- 
         * Do validation
         */
        $config = array(
            array(
                "field" => "select_divisi",
                "label" => "Divisi",
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

        if ($this->form_validation->run()) {

            // Check if has rules order already exists
            $params = array(
                "id_user"       => $id_user,
                "is_deleted"    => NULL
            );

            $check_notification = $this->Userdivisimodel->get_detail_by_params($params);
            if ($check_notification){
                $result["status"]  = FALSE;
                $result["message"] = sprintf("User has been assign to another division ");
                $this->session->set_flashdata(PREFIX_SESSION ."_FORM_RESULT_PROCESS", $result);
                return false;
            }

            $data_create = [
                "id_user"          => $id_user,
                "id_divisi"          => $id_divisi,
                "created_by"    => $this->session->userdata(PREFIX_SESSION . "_USER_ID"), 
                "created_at"    => date_now(),
                "updated_by"   => $this->session->userdata(PREFIX_SESSION . "_USER_ID"), 
                "updated_at"   => date_now(),
            ];

            $action = $this->Userdivisimodel->create($data_create);

            $result["status"]  = $action;
            $result["message"] = ($action) ? "User divisi successfully created." : "User divisi failed created.";

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

        $params = array(
            'order_by'  => 'username',
            'sort_by'   => 'ASC',
        );
        $all_data_user = $this->Userdivisimodel->get_list_user($params);

        $all_data_divisi = $this->Divisimodel->get_list();

        $data_content["all_data_user"]      = $all_data_user;
        $data_content["list_user"]          = generate_array($all_data_user, "id", "username");
        $data_content["all_data_divisi"]    = $all_data_divisi;
        $data_content["list_divisi"]        = generate_array($all_data_divisi, "id", "name");

        $this->load->view($this->class_metadata["module"] ."/". $this->class_metadata["class"] ."/form", $data_content);
    }

    private function _do_edit($id) 
    {
        $id_user     = $this->input->post("select_user") ?: "";
        $id_divisi   = $this->input->post("select_divisi") ?: "";

        /**
         * -- Start -- 
         * Do validation
         */
        $config = array(
            array(
                "field" => "select_divisi",
                "label" => "Divisi",
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

        if ($this->form_validation->run()) {

            $data_update = array_merge([
                "id_user"      => $id_user,
                "id_divisi"    => $id_divisi,
                "updated_by"   => $this->session->userdata(PREFIX_SESSION . "_USER_ID"), 
                "updated_at"   => date_now(),
            ]);

            $action = $this->Userdivisimodel->update($id, $data_update);

            $result["status"]  = $action;
            $result["message"] = ($action) ? "User divisi successfully updated." : "User divisi failed updated.";

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
            'order_by'  => 'username',
            'sort_by'   => 'ASC',
        );
        $all_data_user = $this->Userdivisimodel->get_list_user($params);

        // Get detail data
        $params = array(
            "id"        => $id,
            );
        $all_data = $this->Userdivisimodel->get_detail_by_id($params);

        $all_data_divisi = $this->Divisimodel->get_list();

        /**
         * -- Start --
         * Store data for view
         */
        $data_content["all_data"]           = $all_data;
        $data_content["all_data_user"]      = $all_data_user;
        $data_content["list_user"]          = generate_array($all_data_user, "id", "username");
        $data_content["all_data_divisi"]    = $all_data_divisi;
        $data_content["list_divisi"]        = generate_array($all_data_divisi, "id", "name");
        /**
         * Store data for view
         * -- End --
         */

        $this->load->view($this->class_metadata["module"] ."/". $this->class_metadata["class"] . "/form", $data_content);
    }

    public function delete($id) 
    {
        $action = $this->Userdivisimodel->delete($id);

        if ($action === TRUE) {
            $return = array(
                "status"  => TRUE,
                "message" => "User divisi successfully deleted.",
                );
        } else {
            $return = array(
                "status"  => FALSE,
                "message" => "User divisi failed deleted.",
                );
        }

        $this->session->set_flashdata(PREFIX_SESSION . "_RESULT_PROCESS", $return);

        redirect($this->class_metadata["module"] ."/". $this->class_metadata["class"] ."/", "refresh");
    }

}
