<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller 
{

    private $_module = "STOCK_DASHBOARD";

    public function __construct()
    {
		parent::__construct();
        
		$this->load->model('Dashboardmodel');
	}

	public function index() 
	{
        // Check access module permission
        check_access_module_permission($this->_module, PERMISSION_READ, True);

		$total_sector                         = $this->Dashboardmodel->get_total_sector();
		$total_kavling                        = $this->Dashboardmodel->get_total_kavling();
		$total_kavling_available              = $this->Dashboardmodel->get_total_kavling_available();
		$total_kavling_sold                   = $this->Dashboardmodel->get_total_kavling_sold();
		$total_kavling_booked                 = $this->Dashboardmodel->get_total_kavling_booked();
		// $total_kavling_available_requested = $this->Dashboardmodel->get_total_kavling_available_requested();

        /**
         * -- Start --
         * Store data for view
         */
		$data_content["total_sector"]                         = $total_sector; 
		$data_content["total_kavling"]                        = $total_kavling; 
		$data_content["total_kavling_available"]              = $total_kavling_available; 
		$data_content["total_kavling_sold"]                   = $total_kavling_sold; 
		$data_content["total_kavling_booked"]                 = $total_kavling_booked; 
		// $data_content["total_kavling_available_requested"] = $total_kavling_available_requested; 
		$data_content["module"]                               = $this->_module;
        /**
         * Store data for view
         * -- End --
         */

        $this->load->view($this->class_metadata["module"] ."/". $this->class_metadata["class"] ."/list", $data_content);
	}

}
