<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends MX_Controller 
{

    function __construct()
    {
		parent::__construct();
		
		// if (!is_cli()) exit('Only CLI access allowed');

		$this->load->model('Cronmodel');
		$this->load->model('settings/Notificationmodel');
	}
	
	public function index()
	{
		$token = $this->input->get("token");
		
		if ($token == TOKEN_CRON) {

			// Get list ticket
			$list_ticket = $this->Cronmodel->get_list_ticket_raw();

	        // pre($list_ticket);
	        // print "<pre>";
	        // print_r($list_notif);
	        foreach ($list_ticket as $k => $v) {
	        	// Get list Notification
        		$list_notif = $this->Notificationmodel->get_list_by_params(array('id_type' => $v->id_type, 'days' => $v->calc_date));
	        	foreach ($list_notif as $key => $value) {
        			//Send email notif
        			$this->sentemail->sent($value->username, sprintf('Ticket <b>%s</b> has not been closed for <b>%s</b> days, please complete it immediately', $v->name, $v->calc_date));
	        	}
	        }
	        
			// echo "Success.";
		}
		else {
			echo "Token Unauthorized";
		}
	}

}
