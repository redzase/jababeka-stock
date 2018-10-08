<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MX_Controller 
{
    function __construct()
    {
		parent::__construct();
		$this->load->model('Authmodel');

	}
	
	public function index()
	{
		$data['message_display'] = $this->session->flashdata('message_display');
		$data['user_data'] = $this->session->flashdata('user_data');
		$this->load->view('index',$data,array('login-header-footer'=>true));
		
	}

	
	public function login(){

        if (isset($_POST['submit'])){
			
			$this->form_validation->set_rules('username', 'username', 'required');
			$this->form_validation->set_rules('password', 'password', 'trim|required');

            if ($this->form_validation->run() == false) {
                $result['msg'] = $this->form_validation->error_array();
                $result['status'] = false;
				$result['error_title'] = "Sorry!";
				$result['error_content'] = "Login is Failed!";
				$this->session->set_flashdata('message_display', $result);
				
                redirect('/auth/');

            } else {

				$pass = $this->input->post('password');
				$data = array(
					'username' => $this->input->post('username'),
				);
				$result = $this->Authmodel->login($data);

				if ($result['status']==false){
					$result['msg']['username'] = 'Invalid Username or Password';
					$result['status'] = false;
					$this->session->set_flashdata('message_display', $result);
					redirect('/auth/');

				}

				if ($result['status']==true){
					if ($result['data'][0]->is_deleted==1){
						$result['msg']['username'] = 'User was deleted';
						$result['status'] = false;
						$this->session->set_flashdata('message_display', $result);
						redirect('/auth/');

					}
					if ($result['data'][0]->status==0){
						$result['msg']['username'] = 'User is not active';
						$result['status'] = false;
						$this->session->set_flashdata('message_display', $result);
						redirect('/auth/');

					}

				}
	
				if(password_verify($pass,$result['data'][0]->password)){
				
					$param_user['filters']=array('username'=>$data['username']);
					$get_credential = $this->Authmodel->retrieve_admin($param_user);					
					$this->db->where('id',$get_credential['data'][0]->id);
					$this->db->update('user', array('last_login'=> date('Y-m-d H:i:s')));
					$users_data = array(
						'id' => $get_credential['data'][0]->id,
						'username' => $get_credential['data'][0]->username,
						'role_name' => $get_credential['data'][0]->name,
						'last_login' => $get_credential['data'][0]->last_login,
					);
					// Add user data in session
					$this->session->set_userdata('credential', $users_data);
					redirect('/product/');
	
				} else {
					
					$result['msg']['username'] = 'Invalid Username or Password';
					$result['status'] = false;
					$this->session->set_flashdata('message_display', $result);
					redirect('/auth/');
				}
				
			}
		}
	}


	public function logout()
    {
        // Removing session data
        $this->session->unset_userdata('credential');
        $data['message_display'] = 'Logout Successfully';
        redirect('/auth/');
    }


}
