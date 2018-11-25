<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends MX_Controller 
{

    function __construct()
    {
		parent::__construct();
		
		$this->load->model('Cronmodel');
		$this->load->model('sector/Sectorkavlingmodel');
	}
	
	public function index()
	{
		$token = $this->input->get("token");

		if ($token == TOKEN_CRON) {
			$is_automatic_unbooking = False;
			$limit_day = 0;
			$module = "STOCK_SECTOR_KAVLING";
			$note = "Automatic unbooking by system";

			// Get detail setting
			$params = [
				"code" => SETTING_CODE_AUTOMATIC_UNBOOKING,
	            ];
	        $detail_setting = $this->Cronmodel->get_detail_setting($params);

	        if ($detail_setting) {
				$is_automatic_unbooking = True;
				$limit_day              = $detail_setting->value;
	        }

	        if ($is_automatic_unbooking) {
		        // Get list sector kavling
		        $list_sector_kavling = $this->Cronmodel->get_list_sector_kavling();

		        foreach ($list_sector_kavling as $key => $value) {
					$kavling_id   = $value->id;
					$status_valid = $value->status_valid;
					$date_now     = new Datetime(date_now());
					$booking_date = new Datetime($value->booking_date);

		        	$date_diff = $date_now->diff($booking_date);

		        	if ($date_diff->d > $limit_day and $status_valid == STATUS_BOOKING_KAVLING_BOOKING) {
		        		$data_update = [
							"status_booking" => STATUS_BOOKING_KAVLING_UNBOOKING,
							"note"           => $note,
							// "modified_by" => $this->session->userdata(PREFIX_SESSION . "_USER_ID"), 
							"modified_date"  => date_now(),
		                ];

			            $action = $this->Sectorkavlingmodel->update($kavling_id, $data_update);

			            insert_logs($module, LOGS_ACTIVITY_UNBOOKING, $kavling_id, null, $note);
		        	}
		        }
			}
			else {
				echo "Automatic unbooking not active.";
				die;
			}

			echo "Success.";
		}
		else {
			redirect(SSO_SERVER_LOGIN);
		}
	}

}
