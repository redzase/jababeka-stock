<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MX_Controller 
{

    function __construct()
    {
		parent::__construct();
		
		// $this->load->model('Authmodel');
		$this->load->library('googleplus');

	}
	
	public function index()
	{
		// CEK APAKAH USER SUDAH LOGIN ATAU BELUM
		is_logged_in(FALSE);
		
		redirect(SSO_SERVER_LOGIN);
		
	}

	public function logout()
    {
    	$broker = new third_party\sso\Broker(SSO_SERVER, SSO_BROKER_ID, SSO_BROKER_SECRET);
        $broker->attach(true);
        $broker->logout();
        
    	$this->load->library('session');
    	$this->session->sess_destroy();
		$this->googleplus->revokeToken();
		redirect(SSO_SERVER_LOGIN);

        // // Removing session data
        // $this->session->unset_userdata('credential');
        // $data['message_display'] = 'Logout Successfully';
        // redirect('/auth/');
    }

}
