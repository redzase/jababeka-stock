<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends MY_Controller 
{

    public function __construct()
    {
        
        parent::__construct();
        $this->load->model('master/Typemodel');
    }

    public function index($id_type = NULL){

        if ($id_type === NULL){
            $result["status"]  = FALSE;
            $result["message"] = sprintf("Unknown parameters, Please try again");
            $this->session->set_flashdata(PREFIX_SESSION ."_RESULT_PROCESS", $result);
            redirect('/dashboard', "refresh");
        }

        $get_name_type = $this->Typemodel->get_detail_by_id(array("id" => $id_type))->name;

        $data_content['id_type']            = $id_type;
        $data_content['name_type']          = $get_name_type;

        $this->load->view('index', $data_content);
    }

}
