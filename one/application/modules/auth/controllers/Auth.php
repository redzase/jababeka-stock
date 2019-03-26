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
		// CEK APAKAH USER SUDAH LOGIN ATAU BELUM
		is_logged_in(FALSE);
		
		// $data['message_display'] = $this->session->flashdata('message_display');
		// $data['user_data'] = $this->session->flashdata('user_data');
		$data_content['login_url'] = $this->googleplus->loginURL();
		$data_content["ses_result_process"] = $this->session->flashdata(PREFIX_SESSION . "_RESULT_PROCESS");
		$this->load->view('index', $data_content, array('login-header-footer' => True));
		
	}

	public function callback()
	{
		$this->load->library('session');
		
		if (isset($_GET['code'])) {
			$this->googleplus->getAuthenticate();
			
			$google_user_info = $this->googleplus->getUserInfo();
			$email = $google_user_info["email"];

			$params = array(
	            "email" => $email,
	            );
	        $all_data = $this->Authmodel->check_email($params);

	        if ($all_data) {
	        	$session_data = array(
					PREFIX_SESSION . "_USER_ID"       => $all_data->id,
					PREFIX_SESSION . "_USER_USERNAME" => $all_data->username,
					PREFIX_SESSION . "_ALL_ACCESS"    => $all_data->all_access,
					);

				$this->session->set_userdata($session_data);
				
				// Set SSO Session
				// $broker = new third_party\sso\Broker(SSO_SERVER, SSO_BROKER_ID, SSO_BROKER_SECRET);
				// $broker->attach(true);
				// $broker->login($email, $email);

	        	redirect('dashboard');
	        } 
	        else {
	        	$result = array(
	            	"status" => FALSE,
	                "message" => "Login failed. Check your account again.",
	            );

	            // Set session error message
				$this->session->set_flashdata(PREFIX_SESSION ."_RESULT_PROCESS", $result);
				$page = "auth"; 
	        }

			$this->session->set_userdata('login', true);
			// $this->session->set_userdata('user_profile', $this->googleplus->getUserInfo());
			// redirect('dashboard');
		} 
		else {
		 	$result = array(
            	"status" => FALSE,
                "message" => "Login failed. Check your account again.",
            );

            // Store session
            $this->session->set_flashdata(PREFIX_SESSION ."_RESULT_PROCESS", $result);
			$page = "auth"; 
		}

		redirect($page, "refresh");
		
	}

	public function logout()
    {
    	// $broker = new third_party\sso\Broker(SSO_SERVER, SSO_BROKER_ID, SSO_BROKER_SECRET);
     //    $broker->attach(true);
     //    $broker->logout();
        
    	$this->load->library('session');
    	$this->session->sess_destroy();
		$this->googleplus->revokeToken();
		redirect(SSO_SERVER_LOGIN);

        // // Removing session data
        // $this->session->unset_userdata('credential');
        // $data['message_display'] = 'Logout Successfully';
        // redirect('/auth/');
    }

  //   public function tes() {
  //   	$email = "carrypandin@gmail.com";

  //   	// Set SSO Session
		// $broker = new third_party\sso\Broker("http://cms.jababeka-stock.com/auth/sso", "stock", "C6wkZ29gBXQ2Xb0FYEbWHw");
		// $broker->attach(true);
		// // $broker->logout();die;
		// echo json_encode($broker->login($email, $email));
  //   }

    public function sso()
    {
    	require_once FCPATH . 'vendor/autoload.php';
		require_once APPPATH . 'libraries/MySSOServer.php';

		$ssoServer = new MySSOServer();
		$command = isset($_GET['command']) ? $_GET['command'] : null;

		if (!$command || !method_exists($ssoServer, $command)) {
		    header("HTTP/1.1 404 Not Found");
		    header('Content-type: application/json; charset=UTF-8');
		    
		    echo json_encode(['error' => 'Unknown command']);
		    exit();
		}

		$result = $ssoServer->$command();
    }


}
