<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stocksetting extends MY_Controller 
{
	private $_module = "SETTINGS_STOCK_SETTING";
	
    function __construct()
    {
		parent::__construct();
		
		$this->load->model('Stocksettingmodel');

	}

	public function index() 
	{
		// Check access module permission
		check_access_module_permission($this->_module, PERMISSION_UPDATE, True);
		
		// If submit
        if ($this->input->post()) {
            self::_do_edit();
        }

        // Get detail data
        $params = array(
            "code" => SETTING_CODE_AUTOMATIC_UNBOOKING,
            );
        $all_data = $this->Stocksettingmodel->get_detail($params);

        /**
         * -- Start --
         * Store data for view
         */
		$data_content["ses_result_process"] = $this->session->flashdata(PREFIX_SESSION . "_RESULT_PROCESS");
		$data_content["all_data"]           = $all_data;
		$data_content["select_day"]         = [
			1 => "1",
			2 => "2",
			3 => "3",
			4 => "4",
			5 => "5",
		];
        /**
         * Store data for view
         * -- End --
         */

        $this->load->view('form', $data_content);
	}

	private function _do_edit() 
	{
		$chk_automatic_unbooking = (null !== $this->input->post("chk_automatic_unbooking")) ? $this->input->post("chk_automatic_unbooking") : False;
		$select_day              = ($chk_automatic_unbooking) ? $this->input->post("select_day") : 0;

        /**
         * -- Start -- 
         * Do validation
         */
        if ($chk_automatic_unbooking) {
        	$config = array(
	            // array(
	            //     "field" => "chk_automatic_unbooking",
	            //     "label" => "Set Automatic Unbooking",
	            //     "rules" => "required",
	            //     ),
	            array(
	                "field" => "select_day",
	                "label" => "Dalam Hari",
	                "rules" => "required",
	                ),
	            );
        }
        else {
        	$config = [];
    	}

        $this->form_validation->set_rules($config);
        /**
         * Do validation
         * -- End -- 
         */

        if ($this->form_validation->run() or empty($chk_automatic_unbooking)) {
            $data_update = [
				"value"         => $select_day,
				"status"        => $chk_automatic_unbooking,
				"modified_by"   => $this->session->userdata(PREFIX_SESSION . "_USER_ID"), 
				"modified_date" => date_now(),
            ];

            $action = $this->Stocksettingmodel->update(SETTING_CODE_AUTOMATIC_UNBOOKING, $data_update);

            $result["status"]  = $action;
            $result["message"] = ($action) ? "Setting successfully updated." : "Setting failed updated.";

            // Store session
            $this->session->set_flashdata(PREFIX_SESSION ."_RESULT_PROCESS", $result);

            redirect($this->class_metadata["module"] ."/". $this->class_metadata["class"], "refresh");
        }
    }

}
