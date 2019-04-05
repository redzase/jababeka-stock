<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller 
{
    function __construct()
    {
		parent::__construct();
		$this->load->model('master/Typemodel');
	}
	
	public function index()
	{
        $params = array(
            'order_by'  => 'name',
            'sort_by'   => 'ASC',
        );
        $all_data_type = $this->Typemodel->get_list($params);

        $data_content["all_data_type"]      = $all_data_type;
        $data_content["list_type"]          = generate_array($all_data_type, "id", "name");
        $data_content["ses_result_process"] = $this->session->flashdata(PREFIX_SESSION . "_RESULT_PROCESS");
		$this->load->view('index', $data_content);
		
	}
}
