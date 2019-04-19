<?php

class Sentemail {
	
    private $CI = NULL;

    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->library('email');
        $this->CI->config->load('sent_email');
        $this->CI->email->initialize($this->CI->config->item('sent_email'));
        $this->CI->email->set_newline("\r\n");
    }
	
	public function sent() {
        $from_email = 'jababeka.help@gmail.com';
        $to_email = 'mredzase@gmail.com';

        //Load email library
        $this->CI->email->from($from_email, 'Identification');
        $this->CI->email->to($to_email);
        $this->CI->email->subject('Send Email Codeigniter');
        $this->CI->email->message('The email send using codeigniter library');
        //Send mail
        if($this->CI->email->send())
            echo "Congragulation Email Send Successfully.";
        else
            echo "You have encountered an error";
        
    }
	
}
?>
