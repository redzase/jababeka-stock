<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Memo extends MY_Controller 
{

    private $_module = "STOCK_MEMO";
    private $_image_path = "";
    private $_image_name = "";

    public function __construct()
    {
        parent::__construct();
        
        $this->load->library("upload");
        $this->load->model('sector/Sectormodel');
        $this->load->model('Memomodel');

        $this->form_validation->CI =& $this;
    }

    private function _do_upload($pdfFieldName) 
    {
        $uploadPath = PDF_UPLOAD_PATH . "/". date("Y/m/d") ."/";

        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, TRUE);
        }

        $config["upload_path"]   = $uploadPath;
        $config["allowed_types"] = 'pdf|'. ALLOWED_UPLOAD_TYPE;
        $config["encrypt_name"]  = FALSE;
        $config["overwrite"]     = FALSE;

        // $this->load->library("upload", $config);
        $this->upload->initialize($config);

        $image_name = "";

        if (!$this->upload->do_upload($pdfFieldName)) {
            $return["status"]  = FALSE;
            $return["message"] = str_replace(array("<p>", "</p>"), array("", ""), $this->upload->display_errors());
            return $return;
        } else {
            $resultUpload = $this->upload->data();
            $pdf_name     = $resultUpload["file_name"];

            /**
             * -- Start --
             * Process rename file
             */
            $old_pdf_name = $uploadPath . $pdf_name;
            $new_pdf_name = $uploadPath . date("His") . rand(0, 9) . clean_text_and_space($pdf_name, SEPARATOR);

            rename($old_pdf_name, $new_pdf_name);
            /**
             * Process rename file
             * -- End --
             */

            // Get new filename
            $pdf_name = str_replace($uploadPath, "", $new_pdf_name);
        }

        return [
            "status"   => TRUE,
            "message"  => "",
            "filename" => (!empty($pdf_name)) ? $pdf_name : "",
            "filepath" => (!empty($pdf_name)) ? date("Y/m/d") ."/". $pdf_name : "",
        ];
    }

    public function filePdf_check($pdfFieldName, $todo) 
    {
        if ($todo == "UPDATE" AND $_FILES['pdf_field_name']['name'] == '')
            return TRUE;

        $result = $this->_do_upload("pdf_field_name");

        if (is_array($result) and $result["status"] === FALSE) {
            $this->form_validation->set_message(__FUNCTION__, "Upload File: " . $result["message"]);
            return FALSE;
        } else {
            $this->_image_name = $result["filename"];
            $this->_image_path = $result["filepath"];
            return TRUE;
        }
    }

    public function index($page = 1) 
    {
        // Check access module permission
        check_access_module_permission($this->_module, PERMISSION_READ, True);

        // $page        = ($page < 1) ? 1 : ($page - 1); 
        // $start_limit = $page * TOTAL_ITEM_PER_PAGE;
        // $end_limit   = TOTAL_ITEM_PER_PAGE;
        // $total       = 0;
        
        $current_year = date("Y");
        $list_sector = $this->input->get("select_sector[]") ?: "";
        $year = $this->input->get("select_year") ?: $current_year;
        $is_get = ($this->input->get()) ? true : false;
        $all_data_memo = [];
        $filter = [
            "list_sector" => $list_sector,
            "year"        => $year,
        ];

        $params = array(
            // "start_limit" => $start_limit,
            // "end_limit"   => $end_limit,
            );
        $all_data_sector = $this->Sectormodel->get_list($params);

        $params = array(
            "sector_id"      => $list_sector,
            // "start_limit" => $start_limit,
            // "end_limit"   => $end_limit,
            );
        $all_data_sector_filter = $this->Memomodel->get_sector_filter($params);

        // $params = array(
        //     // "start_limit" => $start_limit,
        //     // "end_limit"   => $end_limit,
        //     );
        // $all_data_year = $this->Memomodel->get_list_year($params);

        // $list_year = ["" => "-- Pilih Tahun --"];
        // foreach ($all_data_year as $key => $value) {
        //     $list_year[$value->start_date_year] = $value->start_date_year;
        //     $list_year[$value->end_date_year] = $value->end_date_year;
        // }        
        
        $list_year = ["" => "-- Pilih Tahun --"];
        for ($i=$current_year-10; $i <= $current_year+5; $i++) { 
            $list_year[$i] = $i;
        }

        // if (!empty($list_sector) and !empty($year)) {
            $params = array(
                "sector_id"      => $list_sector,
                "year"           => $year,
                // "start_limit" => $start_limit,
                // "end_limit"   => $end_limit,
                );
            $all_data_memo = $this->Memomodel->get_list($params);

            $list_memo = [];
            foreach ($all_data_memo as $key => $value) {
                if (!isset($list_memo[$value->sector_id])) {
                    $list_memo[$value->sector_id] = [];
                }

                $start_year = date_now(17, $value->start_date);
                $end_year = date_now(17, $value->end_date);

                if ($year == $start_year) {
                    $start_month = date_now(16, $value->start_date);

                    if ($year == $end_year) {
                        $total_range_month = month_between_date($value->start_date, $value->end_date);
                    } elseif ($year < $end_year) {
                        $total_range_month = month_between_date($value->start_date, "{$year}-12-30");
                    }
                } else {
                    $start_month = 1;

                    if ($year == $end_year) {
                        $total_range_month = month_between_date("{$year}-01-01", $value->end_date);
                    } elseif ($year < $end_year) {
                        $total_range_month = month_between_date("{$year}-01-01", "{$year}-12-30");
                    }
                }

                // if ($year == $end_year) {
                //     $total_range_month = month_between_date($value->start_date, $value->end_date);
                // } elseif ($year < $end_year) {
                //     $total_range_month = month_between_date($value->start_date, "{$year}-12-01");
                // } elseif ($year > $end_year) {
                //     $total_range_month = month_between_date("{$year}-01-01", $value->end_date);
                // }

                $list_memo[$value->sector_id] = array_merge($list_memo[$value->sector_id], [[
                    "start_month"       => $start_month,
                    "total_range_month" => $total_range_month,
                    "title"             => $value->title,
                    "filename"          => $value->filename,
                    "filepath"          => $value->filepath,
                ]]);
            }
        // }

        /**
         * -- Start --
         * Store data for view
         */
        // $data_content["all_data"]        = $all_data; 
        $data_content["filter"]             = $filter;
        $data_content["is_get"]             = $is_get;
        $data_content["all_data_memo"]      = $all_data_memo;
        $data_content["list_memo"]          = $list_memo;
        $data_content["all_data_sector"]    = $all_data_sector_filter;
        $data_content["list_sector"]        = generate_array($all_data_sector, "id", "name");
        // $data_content["list_year"]       = array_unique($list_year);
        $data_content["list_year"]          = $list_year;
        // $data_content["total"]           = $total;
        // $data_content["start_no"]        = ($page * TOTAL_ITEM_PER_PAGE) + 1;
        // $data_content["pagination"]      = $this->pagination->create_links();
        $data_content["ses_result_process"] = $this->session->flashdata(PREFIX_SESSION . "_RESULT_PROCESS");
        $data_content["module"]             = $this->_module;
        /**
         * Store data for view
         * -- End --
         */

        $this->load->view($this->class_metadata["module"] ."/". $this->class_metadata["class"] ."/index", $data_content);
    }

    public function list($sector_id = "", $page = 1) 
    {
        // Check access module permission
        check_access_module_permission($this->_module, PERMISSION_READ, True);

        // If no sector_id defined, redirect to dashboard page
        if (empty($sector_id)) {
            redirect("dashboard", "refresh");
        }

        $page        = ($page < 1) ? 1 : ($page - 1); 
        $start_limit = $page * TOTAL_ITEM_PER_PAGE;
        $end_limit   = TOTAL_ITEM_PER_PAGE;
        $total       = 0;

        $params = array(
            "sector_id"   => $sector_id,
            "start_limit" => $start_limit,
            "end_limit"   => $end_limit,
            );
        $all_data = $this->Memomodel->get_list($params);

        $params = array(
            "sector_id" => $sector_id,
            "get_total" => TRUE,
            );
        $total = $this->Memomodel->get_list($params);  

        /**
         * -- Start --
         * Pagination
         */
        $base_url    = site_url($this->class_metadata["module"] ."/". $this->class_metadata["class"] ."/". $this->class_metadata["method"] ."/". $sector_id);
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

        // Get detail data sector
        $params = array(
            "id" => $sector_id,
            );
        $detail_sector = $this->Sectormodel->get_detail($params);

        /**
         * -- Start --
         * Store data for view
         */
        $data_content["detail_sector"]      = $detail_sector; 
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

        $this->load->view($this->class_metadata["module"] ."/". $this->class_metadata["class"] ."/list", $data_content);
    }

    private function _do_add($sector_id) 
    {
        $title = $this->input->post("title") ?: "";
        $date_range = $this->input->post("date_range") ?: "";

        $start_date = "";
        $end_date = "";

        // Reformat date_range
        $arr_date_range = explode("-", $date_range);
        if (count($arr_date_range) == 2) {
            $start_date = DateTime::createFromFormat('d F Y', trim($arr_date_range[0]))->format('Y-m-d');
            $end_date = DateTime::createFromFormat('d F Y', trim($arr_date_range[1]))->format('Y-m-d');
        }

        /**
         * -- Start -- 
         * Do validation
         */
        $config = array(
            array(
                "field" => "title",
                "label" => "Title",
                "rules" => "required",
                ),
            array(
                "field" => "date_range",
                "label" => "Date Range",
                "rules" => "required",
                ),
            array(
                "field" => "pdf_field_name",
                "label" => "Upload File",
                "rules" => "callback_filePdf_check[INSERT]",
                ),
            );

        $this->form_validation->set_rules($config);
        /**
         * Do validation
         * -- End -- 
         */

        if ($this->form_validation->run()) {
            $data_create = [
                "sector_id"     => $sector_id,
                "start_date"    => $start_date,
                "end_date"      => $end_date,
                "title"         => $title,
                "filename"      => $this->_image_name,
                "filepath"      => $this->_image_path,
                "status"        => GLOBAL_STATUS_ACTIVE,
                "created_by"    => $this->session->userdata(PREFIX_SESSION . "_USER_ID"), 
                "created_date"  => date_now(),
                "modified_by"   => $this->session->userdata(PREFIX_SESSION . "_USER_ID"), 
                "modified_date" => date_now(),
            ];

            $action = $this->Memomodel->create($data_create);

            $result["status"]  = $action;
            $result["message"] = ($action) ? "Memo successfully created." : "Sector failed created.";

            // Store session
            $this->session->set_flashdata(PREFIX_SESSION ."_RESULT_PROCESS", $result);

            redirect($this->class_metadata["module"] ."/". $this->class_metadata["class"] ."/list/". $sector_id, "refresh");
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
        $title = $this->input->post("title") ?: "";
        $date_range = $this->input->post("date_range") ?: "";

        $start_date = "";
        $end_date = "";

        // Reformat date_range
        $arr_date_range = explode("-", $date_range);
        if (count($arr_date_range) == 2) {
            $start_date = DateTime::createFromFormat('d F Y', trim($arr_date_range[0]))->format('Y-m-d');
            $end_date = DateTime::createFromFormat('d F Y', trim($arr_date_range[1]))->format('Y-m-d');
        }

        /**
         * -- Start -- 
         * Do validation
         */
        $config = array(
            array(
                "field" => "title",
                "label" => "Title",
                "rules" => "required",
                ),
            array(
                "field" => "date_range",
                "label" => "Date Range",
                "rules" => "required",
                ),
            // array(
            //     "field" => "pdf_field_name",
            //     "label" => "Upload File",
            //     "rules" => "callback_filePdf_check[INSERT]",
            //     ),
            );

        $this->form_validation->set_rules($config);
        /**
         * Do validation
         * -- End -- 
         */

        if ($this->form_validation->run()) {
            $data_file = [];

            if (!empty($this->_image_path)) {
                $data_file = [
                    "filename" => $this->_image_name,
                    "filepath" => $this->_image_path,
                ];
            }
            
            $data_update = array_merge([
                "sector_id"     => $sector_id,
                "start_date"    => $start_date,
                "end_date"      => $end_date,
                "title"         => $title,
                "status"        => GLOBAL_STATUS_ACTIVE,
                "modified_by"   => $this->session->userdata(PREFIX_SESSION . "_USER_ID"), 
                "modified_date" => date_now(),
            ], $data_file);

            $action = $this->Memomodel->update($id, $data_update);

            $result["status"]  = $action;
            $result["message"] = ($action) ? "Memo successfully updated." : "Sector failed updated.";

            // Store session
            $this->session->set_flashdata(PREFIX_SESSION ."_RESULT_PROCESS", $result);

            redirect($this->class_metadata["module"] ."/". $this->class_metadata["class"] ."/list/". $sector_id, "refresh");
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
            "id"        => $id,
            "sector_id" => $sector_id,
            );
        $all_data = $this->Memomodel->get_detail($params);

        /**
         * -- Start --
         * Store data for view
         */
        $data_content["sector_id"] = $sector_id;
        $data_content["all_data"]  = $all_data;
        /**
         * Store data for view
         * -- End --
         */

        $this->load->view($this->class_metadata["module"] ."/". $this->class_metadata["class"] ."/form", $data_content);
    }

    public function delete($sector_id, $id) 
    {
        $action = $this->Memomodel->delete($id);

        if ($action === TRUE) {
            $return = array(
                "status"  => TRUE,
                "message" => "Memo successfully deleted.",
                );
        } else {
            $return = array(
                "status"  => FALSE,
                "message" => "Sector failed deleted.",
                );
        }

        $this->session->set_flashdata(PREFIX_SESSION . "_RESULT_PROCESS", $return);

        redirect($this->class_metadata["module"] ."/". $this->class_metadata["class"] ."/list/". $sector_id, "refresh");
    }

    public function ajax_list_logs($sector_id, $page = 1) 
    {
        if ($this->input->is_ajax_request()) {
            $page        = ($page < 1) ? 1 : ($page - 1); 
            $start_limit = $page * TOTAL_ITEM_PER_PAGE;
            $end_limit   = TOTAL_ITEM_PER_PAGE;
            $total       = 0;

            $params = array(
                "start_limit" => $start_limit,
                "end_limit"   => $end_limit,
                "sector_id"   => $sector_id,
                );
            $all_data = $this->Memomodel->get_list_logs($params);

            $params = array(
                "get_total"  => TRUE,
                "sector_id"  => $sector_id,
                );
            $total = $this->Memomodel->get_list_logs($params);  

            /**
             * START
             * PAGINATION
             */
            $base_url    = site_url($this->class_metadata["module"] ."/". $this->class_metadata["class"] ."/". $this->class_metadata["method"] ."/". $sector_id);
            $uri_segment = 5;
            $total_rows  = $total;
            $per_page    = TOTAL_ITEM_PER_PAGE;
            $suffix      = "";
            
            $config = set_config_pagination($base_url, $suffix, $uri_segment, $total_rows, $per_page); 

            $this->pagination->initialize($config);
            /**
             * END
             * PAGINATION
             */

            /**
             * START
             * SIMPAN DATA KE VARIABLE UNTUK DIGUNAKAN DI VIEW
             */
            $data_content["all_data"]    = $all_data;
            $data_content["total"]       = $total;
            $data_content["start_no"]    = ($page * TOTAL_ITEM_PER_PAGE) + 1;
            $data_content["pagination"]  = $this->pagination->create_links();
            /**
             * END
             * SIMPAN DATA KE VARIABLE UNTUK DIGUNAKAN DI VIEW
             */
            
            $this->load->view($this->class_metadata["module"] ."/". $this->class_metadata["class"] ."/ajax_list_logs", $data_content, array('no-templating' => True));
        } else {
            echo "Ajax request needed to do this process!";
        }
    }

}
