<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sector extends MY_Controller 
{

    private $_image_path = "";

    public function __construct()
    {
		parent::__construct();
		// if($this->session->userdata('credential') =='') {
  //           redirect('/auth/logout/');
  //       }
        
        $this->load->library("upload");
		$this->load->model('Sectormodel');

        // $this->load->library('form_validation');
        $this->form_validation->CI =& $this;
	}

	private function _do_upload($imageFieldName) 
    {
        $uploadPath          = PHOTO_UPLOAD_PATH . "/". date("Y/m/d") ."/";
        $uploadPathOriginals = PHOTO_ORIGINALS_UPLOAD_PATH . "/". date("Y/m/d") ."/";

        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, TRUE);
        }

        if (!is_dir($uploadPathOriginals)) {
            mkdir($uploadPathOriginals, 0777, TRUE);
        }

        $config["upload_path"]     = $uploadPath;
        $config["allowed_types"]   = ALLOWED_UPLOAD_TYPE;
        $config["max_size"]        = MAX_PHOTO_UPLOAD_SIZE;
        $config['min_width']       = MIN_UPLOAD_WIDTH_PHOTO;
        $config['min_height']      = MIN_UPLOAD_HEIGHT_PHOTO;
        // $config["encrypt_name"] = TRUE;

        // $this->load->library("upload", $config);
        $this->upload->initialize($config);

        $image_name = "";

        if (!$this->upload->do_upload($imageFieldName)) {
            $return["status"]  = FALSE;
            $return["message"] = str_replace(array("<p>", "</p>"), array("", ""), $this->upload->display_errors());
            return $return;
        } else {
            $resultUpload = $this->upload->data();
            $image_name   = $resultUpload["file_name"];

            /* s: PROSES RENAME FILE */
            $old_image_name = $uploadPath . $image_name;
            $new_image_name = $uploadPath . date("His") . rand(0, 9) . clean_text_and_space($image_name, SEPARATOR);

            rename($old_image_name, $new_image_name);
            /* e: PROSES RENAME FILE */

            // MENDAPATKAN NAMA FILE YANG BARU
            $image_name = str_replace($uploadPath, "", $new_image_name);

            // COPY FILE KE FOLDER /ORIGNALS
            copy($new_image_name, $uploadPathOriginals . $image_name);
        }

        return (!empty($image_name)) ? date("Y/m/d") ."/". $image_name : "";
    }

    public function fileImage_check($imageFieldName, $todo) 
    {
        if ($todo == "UPDATE" AND $_FILES['image_field_name']['name'] == '')
            return TRUE;

        $result = $this->_do_upload("image_field_name");

        if (is_array($result) and $result["status"] === FALSE) {
            $this->form_validation->set_message(__FUNCTION__, "File Denah Perumahan: " . $result["message"]);
            return FALSE;
        } else {
            // $this->_image_path = PHOTO_OTHERS_PATH . "/" . $result;
            $this->_image_path = $result;
            return TRUE;
        }
    }

	public function index($page = 1) 
	{
		$page        = ($page < 1) ? 1 : ($page - 1); 
        $start_limit = $page * TOTAL_ITEM_PER_PAGE;
        $end_limit   = TOTAL_ITEM_PER_PAGE;
        $total       = 0;

        $params = array(
            // "start_limit" => $start_limit,
            // "end_limit"   => $end_limit,
            );
        $all_data = $this->Sectormodel->get_list($params);

  //       $params = array(
  //           "get_total" => TRUE,
  //           );
  //       $total = $this->Sectormodel->get_list($params);  

  //       /**
  //        * -- Start --
  //        * Pagination
  //        */
		// $base_url    = site_url($this->class_metadata["module"] ."/". $this->class_metadata["class"] ."/". $this->class_metadata["method"]);
		// $uri_segment = 4;
		// $total_rows  = $total;
		// $per_page    = TOTAL_ITEM_PER_PAGE;
		// $suffix      = "";
		// // $suffix   = ($search <> "") ? "?q={$search}" : "";
        
  //       $config = set_config_pagination($base_url, $suffix, $uri_segment, $total_rows, $per_page); 

  //       $this->pagination->initialize($config);
  //       /**
  //        * Pagination
  //        * -- End --
  //        */

        /**
         * -- Start --
         * Store data for view
         */
        $data_content["all_data"]           = $all_data; 
        $data_content["total"]              = $total;
        $data_content["start_no"]           = ($page * TOTAL_ITEM_PER_PAGE) + 1;
        // $data_content["pagination"]         = $this->pagination->create_links();
        $data_content["ses_result_process"] = $this->session->flashdata(PREFIX_SESSION . "_RESULT_PROCESS");
        /**
         * Store data for view
         * -- End --
         */

        $this->load->view($this->class_metadata["module"] ."/". $this->class_metadata["class"] ."/list", $data_content);
	}

	private function _do_add() 
	{
        $reference_sector_id = $this->input->post("reference_sector_id");
        $name                = $this->input->post("name");
        $icon_size           = $this->input->post("icon_size");
        $color_sold          = $this->input->post("color_sold");
        $color_available     = $this->input->post("color_available");
        $color_booked        = $this->input->post("color_booked");
        $color_requested     = $this->input->post("color_requested");

        /**
         * -- Start -- 
         * Do validation
         */
        $config = array(
            array(
                "field" => "reference_sector_id",
                "label" => "Reference Sector",
                "rules" => "required",
                ),
            array(
                "field" => "name",
                "label" => "Nama Sector",
                "rules" => "required",
                ),
            array(
                "field" => "icon_size",
                "label" => "Icon Size",
                "rules" => "required",
                ),
            array(
                "field" => "color_sold",
                "label" => "Color Sold",
                "rules" => "required",
                ),
            array(
                "field" => "color_available",
                "label" => "Color Available",
                "rules" => "required",
                ),
            array(
                "field" => "color_booked",
                "label" => "Color Booked",
                "rules" => "required",
                ),
            array(
                "field" => "color_requested",
                "label" => "Color Requested",
                "rules" => "required",
                ),
            array(
                "field" => "image_field_name",
                "label" => "File Denah Perumahan",
                "rules" => "callback_fileImage_check[INSERT]",
                ),
            );

        $this->form_validation->set_rules($config);
        /**
         * Do validation
         * -- End -- 
         */

        if ($this->form_validation->run()) {
            $data_create = [
                "reference_sector_id" => $reference_sector_id,
                "name"                => $name,
                "icon_size"           => $icon_size,
                "color_sold"          => $color_sold,
                "color_available"     => $color_available,
                "color_booked"        => $color_booked,
                "color_requested"     => $color_requested,
                "sketch"              => $this->_image_path,
                "status"              => GLOBAL_STATUS_ACTIVE,
                // "created_by"       => $this->session->userdata(PREFIX_SESSION . "_USER_ID"), 
                "created_date"        => date_now(),
                // "modified_by"      => $this->session->userdata(PREFIX_SESSION . "_USER_ID"), 
                "modified_date"       => date_now(),
            ];

            $action = $this->Sectormodel->create($data_create);

            $result["status"]  = $action;
            $result["message"] = ($action) ? "Sector successfully created." : "Sector failed created.";

            // Store session
            $this->session->set_flashdata(PREFIX_SESSION ."_RESULT_PROCESS", $result);

            redirect($this->class_metadata["module"] ."/". $this->class_metadata["class"], "refresh");
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
		$reference_sector_id = $this->input->post("reference_sector_id");
        $name                = $this->input->post("name");
        $icon_size           = $this->input->post("icon_size");
        $color_sold          = $this->input->post("color_sold");
        $color_available     = $this->input->post("color_available");
        $color_booked        = $this->input->post("color_booked");
        $color_requested     = $this->input->post("color_requested");

        /**
         * -- Start -- 
         * Do validation
         */
        $config = array(
            array(
                "field" => "reference_sector_id",
                "label" => "Reference Sector",
                "rules" => "required",
                ),
            array(
                "field" => "name",
                "label" => "Nama Sector",
                "rules" => "required",
                ),
            array(
                "field" => "icon_size",
                "label" => "Icon Size",
                "rules" => "required",
                ),
            array(
                "field" => "color_sold",
                "label" => "Color Sold",
                "rules" => "required",
                ),
            array(
                "field" => "color_available",
                "label" => "Color Available",
                "rules" => "required",
                ),
            array(
                "field" => "color_booked",
                "label" => "Color Booked",
                "rules" => "required",
                ),
            array(
                "field" => "color_requested",
                "label" => "Color Requested",
                "rules" => "required",
                ),
            array(
                "field" => "image_field_name",
                "label" => "File Denah Perumahan",
                "rules" => "callback_fileImage_check[UPDATE]",
                ),
            );

        $this->form_validation->set_rules($config);
        /**
         * Do validation
         * -- End -- 
         */

        if ($this->form_validation->run()) {
            $data_sketch = [];

            if (!empty($this->_image_path)) {
                $data_sketch = [
                    "sketch" => $this->_image_path,
                ];
            }
            
            $data_update = array_merge([
                "reference_sector_id" => $reference_sector_id,
                "name"                => $name,
                "icon_size"           => $icon_size,
                "color_sold"          => $color_sold,
                "color_available"     => $color_available,
                "color_booked"        => $color_booked,
                "color_requested"     => $color_requested,
                "status"              => GLOBAL_STATUS_ACTIVE,
                // "modified_by"      => $this->session->userdata(PREFIX_SESSION . "_USER_ID"), 
                "modified_date"       => date_now(),
            ], $data_sketch);

            $action = $this->Sectormodel->update($id, $data_update);

            $result["status"]  = $action;
            $result["message"] = ($action) ? "Sector successfully updated." : "Sector failed updated.";

            // Store session
            $this->session->set_flashdata(PREFIX_SESSION ."_RESULT_PROCESS", $result);

            redirect($this->class_metadata["module"] ."/". $this->class_metadata["class"], "refresh");
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
            "id" => $id,
            );
        $all_data = $this->Sectormodel->get_detail($params);

        /**
         * -- Start --
         * Store data for view
         */
        $data_content["all_data"] = $all_data;
        /**
         * Store data for view
         * -- End --
         */

        $this->load->view($this->class_metadata["module"] ."/". $this->class_metadata["class"] ."/form", $data_content);
	}

	// public function delete($id) 
 //    {
 //        $action = $this->Sectormodel->delete($id);

 //        if ($action === TRUE) {
 //            $return = array(
 //                "status"  => TRUE,
 //                "message" => "Sector successfully deleted.",
 //                );
 //        } else {
 //            $return = array(
 //                "status"  => FALSE,
 //                "message" => "Sector failed deleted.",
 //                );
 //        }

 //        $this->session->set_flashdata(PREFIX_SESSION . "_RESULT_PROCESS", $return);

 //        redirect($this->class_metadata["module"] ."/". $this->class_metadata["class"], "refresh");
 //    }

}
