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
        $this->load->model('master/Divisimodel');

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
        $page        = ($page < 1) ? TOTAL_ITEM_PER_PAGE : ($page - 1); 
        $start_limit = $page * TOTAL_ITEM_PER_PAGE;
        $end_limit   = TOTAL_ITEM_PER_PAGE;
        $total       = 0;

        $params = array(
            "start_limit" => $start_limit,
            "end_limit"   => $end_limit,
            "id_type"   => $id_type,
            );

        $all_data = $this->Rulesmodel->get_list_raw($params);

        $params = array(
            "get_total" => TRUE,
            "id_type"   => $id_type,
            );
        $total = $this->Rulesmodel->get_list_raw($params);  

        /**
         * -- Start --
         * Pagination
         */
        $base_url    = site_url($this->class_metadata["module"] . '/' . $this->class_metadata["class"] . '/' . $this->class_metadata["method"] . '/' . $id_type);
        $uri_segment = 5;
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

    public function detail($id_type = NULL)
    {
        // Get detail data
        $params = array(
            "id"       => $id_type,
            "is_deleted"    => NULL
            );
        $check_rules_order = $this->Typemodel->get_list_by_params($params);
        if (!$check_rules_order){
            $result["status"]  = FALSE;
            $result["message"] = sprintf("Unknown parameters, Please try again");
            $this->session->set_flashdata(PREFIX_SESSION ."_RESULT_PROCESS", $result);
            redirect($this->class_metadata["module"] ."/". $this->class_metadata["class"] ."/index/" . $id_type, "refresh");
        }

        /**
         * -- Start --
         * Store data for view
         */
        $get_name_type = $this->Typemodel->get_detail_by_id(array("id" => $id_type))->name;

        $params = array(
            'id_type'  => $id_type,
        );
        $all_data = $this->Rulesmodel->get_detail_with_detail_raw($params);

        // print "<pre>";
        $dt = array();
        foreach ($all_data as $key => $value) {
            if (!in_array($value->status_order_name, $dt))
                $dt[$value->status_order_name] = array();
        }

        foreach ($all_data as $key => $value) {
            $dt[$value->status_order_name][$value->status_order_detail_name] = $value->name_divisi;
        }

        $data_content['id_type']            = $id_type;
        $data_content['name_type']          = $get_name_type;
        $data_content['all_data']           = $dt;
        /**
         * Store data for view
         * -- End --
         */

        $this->load->view($this->class_metadata["module"] ."/". $this->class_metadata["class"] . "/detail", $data_content, array("no-templating" => True));
    }

    private function _do_edit($id_type) 
    {
        $status_first = $this->input->post('status_first')?:"";
        $status_last = $this->input->post('status_last')?:"";
        $status = $this->input->post('status')?:"";

        $id_status = array();
        array_push($id_status, $status_first);

        if ($status != '')
            $explode_status = explode(",", $this->input->post('status'));
            $id_status = array_merge($id_status, $explode_status);

        array_push($id_status, $status_last);

        // delete by id type
        $action = $this->Rulesmodel->delete_by_id_type($id_type);

        $action = $this->Rulesmodel->delete_detail_by_id_type($id_type);

        // loop by id status  
        foreach ($id_status as $key => $value) {
            $data_create = [
                "id_type"          => $id_type,
                "id_status"          => $value,
                "sort_number"          => $key + 1,
                "created_by"    => $this->session->userdata(PREFIX_SESSION . "_USER_ID"), 
                "created_at"    => date_now(),
                "updated_by"   => $this->session->userdata(PREFIX_SESSION . "_USER_ID"), 
                "updated_at"   => date_now(),
            ];

            $action = $this->Rulesmodel->create($data_create);
        }

        $result["status"]  = $action;
        $result["message"] = ($action) ? "Rules successfully updated." : "Rules failed updated.";

        // Store session
        $this->session->set_flashdata(PREFIX_SESSION ."_FORM_RESULT_PROCESS", $result);

        redirect($this->class_metadata["module"] . '/' . $this->class_metadata["class"] . '/next/' . $id_type, "refresh");
    }

    public function edit($id_type = NULL)
    {
        // If submit
        if ($this->input->post()) {
            self::_do_edit($id_type);
        }

        // Get detail data
        $params = array(
            "id"       => $id_type,
            "is_deleted"    => NULL
            );
        $check_rules_order = $this->Typemodel->get_list_by_params($params);
        if (!$check_rules_order){
            $result["status"]  = FALSE;
            $result["message"] = sprintf("Unknown parameters, Please try again");
            $this->session->set_flashdata(PREFIX_SESSION ."_RESULT_PROCESS", $result);
            redirect($this->class_metadata["module"] ."/". $this->class_metadata["class"] ."/index/" . $id_type, "refresh");
        }

        $params = array(
            'order_by'  => 'name',
            'sort_by'   => 'ASC',
        );
        $all_data_type = $this->Typemodel->get_list($params);

        $params = array(
            'order_by'  => 'name',
            'sort_by'   => 'ASC'
        );
        $where = array(
            'default'   => NULL,
            'is_deleted' => NULL
        );
        $all_data_status = $this->Statusmodel->get_list_by_params($params, $where);

        // get data first
        $where = array(
            'default'   => TRUE,
            'status_order' => 1,
            'is_deleted' => NULL
        );
        $data_status_first = $this->Statusmodel->get_detail_by_params($where);

        // get data last
        $where = array(
            'default'   => TRUE,
            'status_order' => 0,
            'is_deleted' => NULL
        );
        $data_status_last = $this->Statusmodel->get_detail_by_params($where);

        /**
         * -- Start --
         * Store data for view
         */
        $get_name_type = $this->Typemodel->get_detail_by_id(array("id" => $id_type))->name;

        $all_data = $this->Rulesmodel->get_list_status_by_id_type($id_type);
        $all_data_detail = $this->Rulesmodel->get_detail_list_status_by_id_type($id_type);

        $data_content['id_type']            = $id_type;
        $data_content['name_type']          = $get_name_type;
        $data_content['all_data']           = $all_data;
        $data_content["all_data_type"]      = $all_data_type;
        $data_content["all_data_status"]    = $all_data_status;
        $data_content["data_status_first"]    = $data_status_first;
        $data_content["data_status_last"]    = $data_status_last;
        $data_content["lihat_detail"]    = $all_data_detail;
        $data_content["list_type"]          = generate_array($all_data_type, "id", "name");
        $data_content["list_status"]        = generate_array($all_data_status, "id", "name");
        /**
         * Store data for view
         * -- End --
         */

        $this->load->view($this->class_metadata["module"] ."/". $this->class_metadata["class"] . "/form", $data_content);
    }

    private function _do_next($id_type){
        $post = $this->input->post()?:"";
        $arr = array();
        foreach ($post['status'] as $arrkey => $arrvalue) {
            $arr[$arrvalue] = [];
            foreach ($post as $key => $value) {
                $len_string = strlen('divisi_' . $arrvalue);
                if (substr($key, 0, $len_string) == 'divisi_' . $arrvalue){
                    $split = explode("_", $key);
                    $arr[$arrvalue][$split[2]] = $post['divisi_' . $arrvalue . '_' . $split[2]][0];
                }
            }
        }

        $action = $this->Rulesmodel->delete_detail_by_id_type($id_type);
        
        foreach ($arr as $arrkey => $arrvalue) {
            foreach ($arrvalue as $key => $value) {
                $data_create = [
                    "id_type_status"          => $arrkey,
                    "id_type"          => $id_type,
                    "id_status"          => $key,
                    "id_divisi"          => $value,
                ];

                $action = $this->Rulesmodel->create_detail($data_create);
            }
        }

        $result["status"]  = TRUE;
        $result["message"] = "Rules successfully updated.";

        // Store session
        $this->session->set_flashdata(PREFIX_SESSION ."_RESULT_PROCESS", $result);

        redirect($this->class_metadata["module"] . '/' . $this->class_metadata["class"] . '/index/' . $id_type, "refresh");
        
    }

    public function next($id_type = NULL)
    {
        // If submit
        if ($this->input->post()) {
            self::_do_next($id_type);
        }

        // Get detail data
        $params = array(
            "id"       => $id_type,
            "is_deleted"    => NULL
            );
        $check_rules_order = $this->Typemodel->get_list_by_params($params);
        if (!$check_rules_order){
            $result["status"]  = FALSE;
            $result["message"] = sprintf("Unknown parameters, Please try again");
            $this->session->set_flashdata(PREFIX_SESSION ."_RESULT_PROCESS", $result);
            redirect($this->class_metadata["module"] ."/". $this->class_metadata["class"] ."/index/" . $id_type, "refresh");
        }

        $params = array(
            'order_by'  => 'name',
            'sort_by'   => 'ASC',
        );
        $all_data_type = $this->Typemodel->get_list($params);

        $params = array(
            'order_by'  => 'name',
            'sort_by'   => 'ASC'
        );
        $where = array(
            'default'   => NULL,
            'is_deleted' => NULL
        );
        $all_data_status = $this->Statusmodel->get_list_by_params($params, $where);


        $all_data_divisi = $this->Divisimodel->get_list();

        /**
         * -- Start --
         * Store data for view
         */
        $get_name_type = $this->Typemodel->get_detail_by_id(array("id" => $id_type))->name;

        $all_data = $this->Rulesmodel->get_list_status_by_id_type($id_type, TRUE);

        $all_data_detail = $this->Rulesmodel->get_detail_list_status_by_id_type($id_type);

        // pre($all_data_detail);

        $data_content['id_type']            = $id_type;
        $data_content['name_type']          = $get_name_type;
        $data_content['all_data']           = $all_data;
        $data_content['all_data_detail']    = $all_data_detail;
        $data_content["all_data_type"]      = $all_data_type;
        $data_content["all_data_status"]    = $all_data_status;
        $data_content["all_data_divisi"]    = $all_data_divisi;
        $data_content["list_type"]          = generate_array($all_data_type, "id", "name");
        $data_content["list_status"]        = generate_array($all_data_status, "id", "name");
        $data_content["list_divisi"]        = generate_array($all_data_divisi, "id", "name");
        /**
         * Store data for view
         * -- End --
         */

        $this->load->view($this->class_metadata["module"] ."/". $this->class_metadata["class"] . "/form_next", $data_content);
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
