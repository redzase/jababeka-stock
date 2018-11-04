<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kavling extends MY_Controller 
{

    private $_module = "STOCK_SECTOR_KAVLING";

    public function __construct()
    {
		parent::__construct();
		// if($this->session->userdata('credential') =='') {
  //           redirect('/auth/logout/');
  //       }
        
        $this->load->library("upload");
		$this->load->model('Sectormodel');
        $this->load->model('Sectorkavlingmodel');
	}

    private function _do_add_coordinate($sector_id) 
    {
        $select_kavling = $this->input->post("select_kavling");
        $offset_x       = $this->input->post("offset_x");
        $offset_y       = $this->input->post("offset_y");

        /**
         * -- Start -- 
         * Do validation
         */
        $config = array(
            array(
                "field" => "select_kavling",
                "label" => "Pilih Kavling",
                "rules" => "required",
                ),
            array(
                "field" => "offset_x",
                "label" => "Koordinat",
                "rules" => "required",
                ),
            array(
                "field" => "offset_y",
                "label" => "Koordinat",
                "rules" => "required",
                ),
            );

        $this->form_validation->set_rules($config);
        /**
         * Do validation
         * -- End -- 
         */

        if ($this->form_validation->run()) {
            $data_update = [
                "offset_x"       => $offset_x,
                "offset_y"       => $offset_y,
                // "modified_by" => $this->session->userdata(PREFIX_SESSION . "_USER_ID"), 
                "modified_date"  => date_now(),
            ];

            $action = $this->Sectorkavlingmodel->update($select_kavling, $data_update);

            $result["status"]  = $action;
            $result["message"] = ($action) ? "Coordinate successfully updated." : "Coordinate failed updated.";

            // Store session
            $this->session->set_flashdata(PREFIX_SESSION ."_RESULT_PROCESS", $result);

            redirect($this->class_metadata["module"] ."/". $this->class_metadata["class"] ."/index/". $sector_id, "refresh");
        }
    }

    public function index($sector_id, $page = 1) 
    {
        // Check access module permission
        check_access_module_permission($this->_module, PERMISSION_READ, True);

        // If submit
        if ($this->input->post()) {
            self::_do_add_coordinate($sector_id);
        }
        
        // Get filter value
        $reference_kavling_id = $this->input->get("reference_kavling_id") ?: "";
        $street_name          = $this->input->get("street_name") ?: "";
        $chk_filter_status    = $this->input->get("chk_filter_status") ?: "";
        $filter_status        = [];

        if (!empty($chk_filter_status) and is_array($chk_filter_status)) {
            foreach ($chk_filter_status as $key => $value) {
                $filter_status[] = $value;
            }
        }

        $filter = [
            "reference_kavling_id" => $reference_kavling_id,
            "street_name"          => $street_name,
            "filter_status"        => $filter_status,
        ];
        $page        = ($page < 1) ? 1 : ($page - 1); 
        $start_limit = $page * TOTAL_ITEM_PER_PAGE;
        $end_limit   = TOTAL_ITEM_PER_PAGE;
        $total       = 0;

        // Get detail data
        $params = array(
            "id" => $sector_id,
            );
        $detail_sector = $this->Sectormodel->get_detail($params);

        $params = array(
            "sector_id"      => $sector_id,
            // "start_limit" => $start_limit,
            // "end_limit"   => $end_limit,
            "filter"         => $filter,
            );
        $all_data = $this->Sectorkavlingmodel->get_list($params);
        $all_data_kavling = $this->Sectorkavlingmodel->get_list(["sector_id" => $sector_id, "is_show_empty_coordinate" => True]);

        // $params = array(
        //     "sector_id" => $sector_id,
        //     "get_total" => TRUE,
        //     );
        // $total = $this->Sectorkavlingmodel->get_list($params);  

        // /**
        //  * -- Start --
        //  * Pagination
        //  */
        // $base_url    = site_url($this->class_metadata["module"] ."/". $this->class_metadata["class"] ."/". $this->class_metadata["method"] ."/". $sector_id);
        // $uri_segment = 5;
        // $total_rows  = $total;
        // $per_page    = TOTAL_ITEM_PER_PAGE;
        // $suffix      = "";
        // // $suffix   = ($search <> "") ? "?q={$search}" : "";
        
        // $config = set_config_pagination($base_url, $suffix, $uri_segment, $total_rows, $per_page); 

        // $this->pagination->initialize($config);
        // /**
        //  * Pagination
        //  * -- End --
        //  */

        /**
         * -- Start --
         * Formating for dropdown list kavling
         */
        $all_kavling[""] = "-- Pilih Kavling --";
        foreach ($all_data_kavling as $key => $value) {
            $all_kavling[$value->id] = $value->street_name .", ". $value->block_name .", ". $value->house_number;
        }
        /**
         * Formating for dropdown list kavling
         * -- End --
         */

        /**
         * -- Start --
         * Store data for view
         */
        // $data_content["all_kavling"]      = array_merge(["" => "-- Pilih Kavling --"], generate_array($all_data, "id", "street_name"));
        $data_content["filter"]              = $filter;
        $data_content["all_kavling"]         = $all_kavling;
        $data_content["list_status_kavling"] = unserialize(LIST_STATUS_KAVLING); 
        $data_content["detail_sector"]       = $detail_sector; 
        $data_content["all_data"]            = $all_data; 
        $data_content["total"]               = $total;
        $data_content["start_no"]            = ($page * TOTAL_ITEM_PER_PAGE) + 1;
        // $data_content["pagination"]          = $this->pagination->create_links();
        $data_content["ses_result_process"]  = $this->session->flashdata(PREFIX_SESSION . "_RESULT_PROCESS");
        $data_content["module"]              = $this->_module;
        /**
         * Store data for view
         * -- End --
         */

        $this->load->view($this->class_metadata["module"] ."/". $this->class_metadata["class"] ."/list", $data_content);
    }

    private function _do_add($sector_id) 
    {
        $reference_kavling_id = $this->input->post("reference_kavling_id");
        $street_name          = $this->input->post("street_name");
        $block_name           = $this->input->post("block_name");
        $house_number         = $this->input->post("house_number");

        /**
         * -- Start -- 
         * Do validation
         */
        $config = array(
            array(
                "field" => "reference_kavling_id",
                "label" => "Reference Kavling",
                "rules" => "required",
                ),
            array(
                "field" => "street_name",
                "label" => "Nama Jalan",
                "rules" => "required",
                ),
            array(
                "field" => "block_name",
                "label" => "Nama Blok",
                "rules" => "required",
                ),
            array(
                "field" => "house_number",
                "label" => "Nomor Rumah",
                "rules" => "required",
                ),
            );

        $this->form_validation->set_rules($config);
        /**
         * Do validation
         * -- End -- 
         */

        if ($this->form_validation->run()) {
            $data_create = [
                "sector_id"            => $sector_id,
                "reference_kavling_id" => $reference_kavling_id,
                "street_name"          => $street_name,
                "block_name"           => $block_name,
                "house_number"         => $house_number,
                "status"               => GLOBAL_STATUS_ACTIVE,
                // "created_by"        => $this->session->userdata(PREFIX_SESSION . "_USER_ID"), 
                "created_date"         => date_now(),
                // "modified_by"       => $this->session->userdata(PREFIX_SESSION . "_USER_ID"), 
                "modified_date"        => date_now(),
            ];

            $action = $this->Sectorkavlingmodel->create($data_create);

            $result["status"]  = $action;
            $result["message"] = ($action) ? "Kavling successfully created." : "Kavling failed created.";

            // Store session
            $this->session->set_flashdata(PREFIX_SESSION ."_RESULT_PROCESS", $result);

            redirect($this->class_metadata["module"] ."/". $this->class_metadata["class"] ."/index/". $sector_id, "refresh");
        }
    }

    public function add($sector_id)
    {
        // If submit
        if ($this->input->post()) {
            self::_do_add($sector_id);
        }

        /**
         * -- Start --
         * Store data for view
         */
        $data_content["sector_id"] = $sector_id;
        /**
         * Store data for view
         * -- End --
         */
        
        $this->load->view($this->class_metadata["module"] ."/". $this->class_metadata["class"] ."/form", $data_content);
    }

    private function _do_edit($sector_id, $id) 
    {
        $reference_kavling_id = $this->input->post("reference_kavling_id");
        $street_name          = $this->input->post("street_name");
        $block_name           = $this->input->post("block_name");
        $house_number         = $this->input->post("house_number");

        /**
         * -- Start -- 
         * Do validation
         */
        $config = array(
            array(
                "field" => "reference_kavling_id",
                "label" => "Reference Kavling",
                "rules" => "required",
                ),
            array(
                "field" => "street_name",
                "label" => "Nama Jalan",
                "rules" => "required",
                ),
            array(
                "field" => "block_name",
                "label" => "Nama Blok",
                "rules" => "required",
                ),
            array(
                "field" => "house_number",
                "label" => "Nomor Rumah",
                "rules" => "required",
                ),
            );

        $this->form_validation->set_rules($config);
        /**
         * Do validation
         * -- End -- 
         */

        if ($this->form_validation->run()) {
            $data_update = [
                "sector_id"            => $sector_id,
                "reference_kavling_id" => $reference_kavling_id,
                "street_name"          => $street_name,
                "block_name"           => $block_name,
                "house_number"         => $house_number,
                // "modified_by"       => $this->session->userdata(PREFIX_SESSION . "_USER_ID"), 
                "modified_date"        => date_now(),
            ];

            $action = $this->Sectorkavlingmodel->update($id, $data_update);

            $result["status"]  = $action;
            $result["message"] = ($action) ? "Kavling successfully updated." : "Kavling failed updated.";

            // Store session
            $this->session->set_flashdata(PREFIX_SESSION ."_RESULT_PROCESS", $result);

            redirect($this->class_metadata["module"] ."/". $this->class_metadata["class"] ."/index/". $sector_id, "refresh");
        }
    }

    public function edit($sector_id, $id)
    {
        // If submit
        if ($this->input->post()) {
            self::_do_edit($sector_id, $id);
        }

        // Get detail data
        $params = array(
            "id" => $id,
            );
        $all_data = $this->Sectorkavlingmodel->get_detail($params);

        /**
         * -- Start --
         * Store data for view
         */
        $data_content["sector_id"] = $sector_id;
        $data_content["all_data"] = $all_data;
        /**
         * Store data for view
         * -- End --
         */

        $this->load->view($this->class_metadata["module"] ."/". $this->class_metadata["class"] ."/form", $data_content);
    }

    private function _do_import($sector_id) 
    {
        $uploadPath = CSV_UPLOAD_PATH . "/". date("Y/m/d") ."/";

        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, TRUE);
        }

        $config['upload_path']   = $uploadPath;
        $config['allowed_types'] = 'csv'; 
        $config["encrypt_name"]  = TRUE;
        $config["overwrite"]     = FALSE;
        $return                  = [
            "status" => False,
            "message" => "No data to process.",
        ];

        // $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if ( ! $this->upload->do_upload('massupload')) {
            // pre($this->upload->display_errors()); 
            $return["status"]  = FALSE;
            $return["message"] = str_replace(array("<p>", "</p>"), array("", ""), $this->upload->display_errors());
            // return $return;
        } 
        else {
            $result = $this->upload->data(); 
            $csv    = csv_to_array($result['full_path'], ',') ; 

            if(count($csv) > 0) {
                // foreach($csv as $key => $value){
                //     $result = $this->Sectorkavlingmodel->import($csv);
                // }
                $result_insert = $this->Sectorkavlingmodel->import($sector_id, $csv);

                $return["status"]  = $result_insert;
                $return["message"] = $result_insert ? "Kavling imported successfully." : "Kavling imported failed.";
            }
        }

        // SIMPAN KE SESSION
        $this->session->set_flashdata(PREFIX_SESSION . "_RESULT_PROCESS", $return);
            
        redirect($this->class_metadata["module"] ."/". $this->class_metadata["class"] ."/index/". $sector_id, "refresh");
    }

    public function import($sector_id)
    {
        // If submit
        if ($this->input->post()) {
            self::_do_import($sector_id);
        }

        /**
         * -- Start --
         * Store data for view
         */
        $data_content["sector_id"] = $sector_id;
        /**
         * Store data for view
         * -- End --
         */
        
        $this->load->view($this->class_metadata["module"] ."/". $this->class_metadata["class"] ."/import", $data_content);
    }

    public function delete($sector_id, $id) 
    {
        $action = $this->Sectorkavlingmodel->delete($id);

        if ($action === TRUE) {
            $return = array(
                "status"  => TRUE,
                "message" => "Kavling successfully deleted.",
                );
        } else {
            $return = array(
                "status"  => FALSE,
                "message" => "Kavling failed deleted.",
                );
        }

        $this->session->set_flashdata(PREFIX_SESSION . "_RESULT_PROCESS", $return);

        redirect($this->class_metadata["module"] ."/". $this->class_metadata["class"] ."/index/". $sector_id, "refresh");
    }

    public function update_status($sector_id, $kavling_id, $status) 
    {
        if ($status == STATUS_BOOKING_KAVLING_REMOVE_FROM_MAP) {
            $data_update = [
                "offset_x" => 0,
                "offset_y" => 0,
                // "modified_by" => $this->session->userdata(PREFIX_SESSION . "_USER_ID"), 
                "modified_date"  => date_now(),
            ];
 
            $response_message = "Coordinate {{SUCCESS_OR_FAILED}} deleted.";
        }
        else {
            $data_update = [
                "status_booking" => $status,
                // "modified_by" => $this->session->userdata(PREFIX_SESSION . "_USER_ID"), 
                "modified_date"  => date_now(),
            ];

            $response_message = "Status {{SUCCESS_OR_FAILED}} updated.";
        }

        $action = $this->Sectorkavlingmodel->update($kavling_id, $data_update);

        $result["status"]  = $action;
        $result["message"] = ($action) ? str_replace('{{SUCCESS_OR_FAILED}}', 'successfully', $response_message) : str_replace('{{SUCCESS_OR_FAILED}}', 'failed', $response_message);

        // Store session
        $this->session->set_flashdata(PREFIX_SESSION ."_RESULT_PROCESS", $result);

        redirect($this->class_metadata["module"] ."/". $this->class_metadata["class"] ."/index/". $sector_id, "refresh");
    }
    
}
