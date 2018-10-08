<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MX_Controller 
{
    function __construct()
    {
		// parent::__construct();
		// if($this->session->userdata('credential') =='') {
  //           redirect('/auth/logout/');
		// }
		// $this->load->model('Dashboardmodel');
	}
	
	public function index()
	{
		$this->load->view('index');
		
	}
}
