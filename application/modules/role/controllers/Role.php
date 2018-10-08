<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Role extends MX_Controller 
{
    function __construct()
    {
		parent::__construct();
		// if($this->session->userdata('credential') =='') {
  //           redirect('/auth/logout/');
  //       }
		$this->load->model('Rolemodel');

	}
	
	public function index()
	{
		$param['tbl'] ='';
		$get_role = $this->Rolemodel->retrieve_role($param);
		$data['roles'] = $get_role['data'];
		$this->load->view('list',$data);
		
	}

	public function add()
	{
		$data['message_display'] = $this->session->flashdata('message_display');	
		$this->load->view('add', $data);
		
	}

	public function edit()
	{
			
		$id = $this->input->get('id');
		$config_tbl['filters']=array('id'=>$id);
		$get_role= $this->Rolemodel->retrieve_role($config_tbl);
		$data['role'] =  $get_role['data'];
		$this->load->view('edit', $data);
		
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

					$result = $this->Rolemodel->retrieve_role($check_role);

					
					
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
					$this->Rolemodel->update_data("role", $update_data);
					$post_response = $_POST['id'];
				}else{
				
					$post_response = $this->Rolemodel->insert_entry("role", $posting_data);
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
	
		$totalData = $this->Rolemodel->all_count();
			
		$totalFiltered = $totalData; 
			
		if(empty($this->input->post('search')['value']))
		{            
			$billings = $this->Rolemodel->all($limit,$start,$order,$dir);
		}
		else {
			$search = $this->input->post('search')['value']; 

			$billings =  $this->Rolemodel->search($limit,$start,$search,$order,$dir);

			$totalFiltered = $this->Rolemodel->search_count($search);
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


	public function delete()
	{
		$id = $this->input->get('id');
		$update_data['data'] = array('is_deleted'=>1);
		$update_data['filters'] = array('id'=>$id);
		$this->Rolemodel->update_data("role", $update_data);
		redirect('role');


	}

}
