<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MX_Controller 
{
    function __construct()
    {
		parent::__construct();
		$this->load->model('Authmodel');
		$this->load->library('googleplus');

	}
	
	public function index()
	{
		// $data['message_display'] = $this->session->flashdata('message_display');
		// $data['user_data'] = $this->session->flashdata('user_data');
		$data_content['login_url'] = $this->googleplus->loginURL();
		$data_content["ses_result_process"] = $this->session->flashdata(PREFIX_SESSION . "_RESULT_PROCESS");
		$this->load->view('index', $data_content, array('login-header-footer' => True));
		
	}

	public function callback()
	{
		if (isset($_GET['code'])) {
			$this->googleplus->getAuthenticate();
			
			$google_user_info = $this->googleplus->getUserInfo();
			$email = $google_user_info["email"];

			$params = array(
	            "email" => $email,
	            );
	        $all_data = $this->Authmodel->check_email($params);

	        if ($all_data) {
	        	redirect('dashboard');
	        } 
	        else {
	        	$result = array(
	            	"status" => FALSE,
	                "message" => "Login was failed. Check your account again.",
	            );

	            // Set session error message
				$this->session->set_flashdata(PREFIX_SESSION ."_RESULT_PROCESS", $result);
				$page = "auth"; 
	        }

			// $this->session->set_userdata('login', true);
			// $this->session->set_userdata('user_profile', $this->googleplus->getUserInfo());
			// redirect('dashboard');
		} 
		else {
		 	$result = array(
            	"status" => FALSE,
                "message" => "Login was failed. Check your account again.",
            );

            // Store session
            $this->session->set_flashdata(PREFIX_SESSION ."_RESULT_PROCESS", $result);
			$page = "auth"; 
		}

		redirect($page, "refresh");
		
	}

	public function logout()
    {
    	$this->session->sess_destroy();
		$this->googleplus->revokeToken();
		redirect('/auth/');

        // // Removing session data
        // $this->session->unset_userdata('credential');
        // $data['message_display'] = 'Logout Successfully';
        // redirect('/auth/');
    }


}
