<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller 
{
	private $_module = "SETTINGS_USER";

    function __construct()
    {
		parent::__construct();
		// if($this->session->userdata('credential') =='') {
  //           redirect('/auth/logout/');
  //       }
		$this->load->model('Usermodel');
		$this->load->model('role/Rolemodel');

	}
	
	// public function index()
	// {
	// 	// $param['tbl'] ='';
	// 	// $get_role = $this->Usermodel->retrieve_role($param);
	// 	// $data['roles'] = $get_role['data'];
	// 	$this->load->view('list',[]);
	// }

	public function index($page = 1) 
	{
		// Check access module permission
		check_access_module_permission($this->_module, PERMISSION_READ, True);

		$page        = ($page < 1) ? 1 : ($page - 1); 
        $start_limit = $page * TOTAL_ITEM_PER_PAGE;
        $end_limit   = TOTAL_ITEM_PER_PAGE;
        $total       = 0;

        $params = array(
            "start_limit" => $start_limit,
            "end_limit"   => $end_limit,
            );
        $all_data = $this->Usermodel->get_list($params);

        $params = array(
            "get_total" => TRUE,
            );
        $total = $this->Usermodel->get_list($params);  

        /**
         * -- Start --
         * Pagination
         */
		$base_url    = site_url($this->class_metadata["module"] ."/". $this->class_metadata["class"] ."/". $this->class_metadata["method"]);
		$uri_segment = 4;
		$total_rows  = $total;
		$per_page    = TOTAL_ITEM_PER_PAGE;
		$suffix      = "";
		// $suffix   = ($search <> "") ? "?q={$search}" : "";
        
        $config = set_config_pagination($base_url, $suffix, $uri_segment, $total_rows, $per_page); 

        $this->pagination->initialize($config);
        /**
         * Pagination
         * -- End --
         */

        /**
         * -- Start --
         * Store data for view
         */
        $data_content["all_data"]           = $all_data; 
        $data_content["total"]              = $total;
        $data_content["start_no"]           = ($page * TOTAL_ITEM_PER_PAGE) + 1;
        $data_content["pagination"]         = $this->pagination->create_links();
        $data_content["ses_result_process"] = $this->session->flashdata(PREFIX_SESSION . "_RESULT_PROCESS");
        $data_content["module"]             = $this->_module;
        /**
         * Store data for view
         * -- End --
         */

        $this->load->view('list', $data_content);
	}
	
	// public function add()
	// {
	// 	$data['message_display'] = $this->session->flashdata('message_display');	
	// 	$this->load->view('add', $data);
		
	// }

	private function _do_add() {
		$username         = $this->input->post("username");
		// $password         = $this->input->post("password");
		// $confirm_password = $this->input->post("confirm_password");
		$role             = $this->input->post("select_role");

        /**
         * -- Start -- 
         * Do validation
         */
        $config = array(
            array(
                "field" => "username",
                "label" => "User name",
                "rules" => "required",
                ),
            // array(
            //     "field" => "password",
            //     "label" => "Password",
            //     "rules" => "required",
            //     ),
            array(
                "field" => "select_role",
                "label" => "Role",
                "rules" => "required",
                ),
            );

        $this->form_validation->set_rules($config);
        /**
         * Do validation
         * -- End -- 
         */

        if ($this->form_validation->run()) {
            $data_create = [
				"username"       => $username,
				// "password"       => $password,
				"role_id"        => $role,
				"status"         => GLOBAL_STATUS_ACTIVE,
				// "created_by"  => $this->session->userdata(PREFIX_SESSION . "_USER_ID"), 
				"created_date"   => date_now(),
				// "modified_by" => $this->session->userdata(PREFIX_SESSION . "_USER_ID"), 
				"modified_date"  => date_now(),
            ];

            $action = $this->Usermodel->create($data_create);

            $result["status"]  = $action;
            $result["message"] = ($action) ? "User successfully created." : "User failed created.";

            // Store session
            $this->session->set_flashdata(PREFIX_SESSION ."_RESULT_PROCESS", $result);

            redirect($this->class_metadata["module"] ."/". $this->class_metadata["class"], "refresh");
        }
    }

	public function add()
	{
		// If submit
        if ($this->input->post()) {
            self::_do_add();
        }

		$all_role = $this->Rolemodel->get_list();

        /**
         * -- Start --
         * Store data for view
         */
		$data_content["all_role"] = generate_array($all_role, "id", "name");
        /**
         * Store data for view
         * -- End --
         */

        $this->load->view('form', $data_content);
	}

	// public function edit()
	// {
			
	// 	$id = $this->input->get('id');
	// 	$config_tbl['filters']=array('id'=>$id);
	// 	$get_role= $this->Usermodel->retrieve_role($config_tbl);
	// 	$data['role'] =  $get_role['data'];
	// 	$this->load->view('edit', $data);
		
	// }

	private function _do_edit($id) {
		$username         = $this->input->post("username");
		// $password         = $this->input->post("password");
		// $confirm_password = $this->input->post("confirm_password");
		$role             = $this->input->post("select_role");

        /**
         * -- Start -- 
         * Do validation
         */
        $config = array(
            array(
                "field" => "username",
                "label" => "User name",
                "rules" => "required",
                ),
            array(
                "field" => "password",
                "label" => "Password",
                "rules" => "required",
                ),
            array(
                "field" => "select_role",
                "label" => "Role",
                "rules" => "required",
                ),
            );

        $this->form_validation->set_rules($config);
        /**
         * Do validation
         * -- End -- 
         */

        if ($this->form_validation->run()) {
            $data_update = [
				"id"             => $id,
				"username"       => $username,
				// "password"       => $password,
				"role_id"        => $role,
				"status"         => GLOBAL_STATUS_ACTIVE,
				// "modified_by" => $this->session->userdata(PREFIX_SESSION . "_USER_ID"), 
				"modified_date"  => date_now(),
            ];

            $action = $this->Usermodel->update($id, $data_update);

            $result["status"]  = $action;
            $result["message"] = ($action) ? "Role successfully updated." : "Role failed updated.";

            // Store session
            $this->session->set_flashdata(PREFIX_SESSION ."_RESULT_PROCESS", $result);

            redirect($this->class_metadata["module"] ."/". $this->class_metadata["class"], "refresh");
        }
    }

	public function edit($id)
	{
		// If submit
        if ($this->input->post()) {
            self::_do_edit($id);
        }

        // Get detail data
        $params = array(
            "id" => $id,
            );
        $all_data = $this->Usermodel->get_detail($params);

        $all_role = $this->Rolemodel->get_list();

        /**
         * -- Start --
         * Store data for view
         */
		$data_content["all_data"]   = $all_data;
		$data_content["all_role"]   = generate_array($all_role, "id", "name");
        /**
         * Store data for view
         * -- End --
         */

        $this->load->view('form', $data_content);
	}

	public function action_add(){

        if (isset($_POST)){
			$data_user = $this->session->userdata('credential');
			$this->form_validation->set_rules('name', 'name', 'required');
			$this->form_validation->set_rules('status', 'status', 'required');

			$name = $this->input->post('name');
			$status = $this->input->post('status');
			

            if ($this->form_validation->run() == false) {
                $result['msg'] = $this->form_validation->error_array();
                $result['status'] = false;
				$result['error_title'] = "Sorry!";
				$result['error_content'] = "Insert Role Failed!";
				$this->output
								->set_status_header(200)
								->set_content_type('application/json', 'utf-8')
								->set_output(json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
								->_display();
								exit;
				
            } else {

				if (!isset($_POST['id'])){
					$check_role['filters'] = array(
						'name' => $name,
					);

					$result = $this->Usermodel->retrieve_role($check_role);

					
					
					if ($result['status'] == true){
						$result['msg'] = $this->form_validation->error_array();
						$result['status'] = false;
						$result['error_title'] = "Sorry!";
						$result['error_content'] = "Role Name already exists";
						$this->output
								->set_status_header(200)
								->set_content_type('application/json', 'utf-8')
								->set_output(json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
								->_display();
								exit;
					
					}
				}

				$posting_data = array(
					"name" => $name,
					"status" => $status,
					"created_date" =>  date('Y-m-d H:i:s' ),
					"modified_date" =>  date('Y-m-d H:i:s'),
					"created_by" => $data_user['id'],
					"modified_by" => $data_user['id'],
					
				);
				

				if (isset($_POST['id'])){

					$update_data['data'] = $posting_data;
					$update_data['filters'] = array('id'=>$_POST['id']);
					$this->Usermodel->update_data("role", $update_data);
					$post_response = $_POST['id'];
				}else{
				
					$post_response = $this->Usermodel->insert_entry("role", $posting_data);
				}

				$result['status'] = true;
				$result['msg'] = "Success!";
				$this->output
						->set_status_header(200)
						->set_content_type('application/json', 'utf-8')
						->set_output(json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
						->_display();
						exit;
			}
		}
	}


	public function get_role()
	{
		
		$columns = array( 
							0 =>'id', 
							1 =>'name',
							2 =>'status',
							3=> 'created_date',
							4=> '',

						);

		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
	
		$totalData = $this->Usermodel->all_count();
			
		$totalFiltered = $totalData; 
			
		if(empty($this->input->post('search')['value']))
		{            
			$billings = $this->Usermodel->all($limit,$start,$order,$dir);
		}
		else {
			$search = $this->input->post('search')['value']; 

			$billings =  $this->Usermodel->search($limit,$start,$search,$order,$dir);

			$totalFiltered = $this->Usermodel->search_count($search);
		}

		$data = array();
		if(!empty($billings))
		{
			foreach ($billings as $row)
			{

				if (permission('Update','Role')==true){
					$edit = '<a class="badge bg-blue" href="'. site_url('role/edit/?id='.$row->id) .'" ><i class="fa fa-edit"></i></a>&nbsp';
				}else{
					$edit = "";
				}
				if (permission('Delete','Role')==true){
					$delete = '<a class="badge bg-red" onclick="delete_confirm(\''. site_url('role/delete/?id='. $row->id) .'\')" ><i class="fa fa-trash"></i></a>';
				}else{
					$delete = "";
				}

				$bg = $row->status == 1 ? 'badge bg-green':'badge bg-red';
				$status = '<span class="'.$bg.'">'.status($row->status).'</span>';
				$nestedData['id'] = $row->id;
				$nestedData['name'] = $row->name;
				$nestedData['status'] =$status;
				$nestedData['created_date'] = date('j M Y h:i a',strtotime($row->created_date));
				$nestedData['action'] = $edit.$delete;

				
				$data[] = $nestedData;

			}
		}
			
		$json_data = array(
					"draw"            => intval($this->input->post('draw')),  
					"recordsTotal"    => intval($totalData),  
					"recordsFiltered" => intval($totalFiltered), 
					"data"            => $data   
					);
			
		echo json_encode($json_data); 
		

	}


	public function delete($id) {
        $action = $this->Usermodel->delete($id);

        if ($action === TRUE) {
            $return = array(
                "status"  => TRUE,
                "message" => "User successfully deleted.",
                );
        } else {
            $return = array(
                "status"  => FALSE,
                "message" => "User failed deleted.",
                );
        }

        $this->session->set_flashdata(PREFIX_SESSION . "_RESULT_PROCESS", $return);

        redirect($this->class_metadata["module"] ."/". $this->class_metadata["class"], "refresh");
    }

}
