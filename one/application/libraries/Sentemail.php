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
	
	public function sent($to_email, $msg) {
        $from_email = 'jababeka.help@gmail.com';

        //Load email library
        $this->CI->email->from($from_email, 'Jababeka Help');
        $this->CI->email->to($to_email);
        $this->CI->email->subject('Status Topic is changed !');
        $this->CI->email->message($msg);
        //Send mail
        if($this->CI->email->send())
            return true;

        return false;
    }
	
}
?>
