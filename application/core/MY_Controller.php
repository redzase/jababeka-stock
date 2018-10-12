<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class MY_Controller extends MX_Controller {
	
	protected $class_metadata = array();

	function __construct() {
		parent::__construct();

		// // CEK APAKAH USER SUDAH LOGIN ATAU BELUM
		// is_logged_in(TRUE);

		$router                              =& load_class('Router', 'core');
		$this->class_metadata["module"]      = $router->fetch_module();
		$this->class_metadata["directory"]   = $router->fetch_directory();
		$this->class_metadata["class"]       = $router->fetch_class();
		$this->class_metadata["method"]      = $router->fetch_method();
		$this->class_metadata["current_url"] = $this->uri->uri_string();

		if (!empty($this->class_metadata["directory"])) {
			// UNTUK MENDAPATKAN DIREKTORI SEBENARNYA
			$start     = strrpos($this->class_metadata["directory"], "controllers") + strlen("controllers");
			$end       = strlen($this->class_metadata["directory"]);
			$directory = substr($this->class_metadata["directory"], $start, $end);
			$directory = str_replace("/", "", $directory);

			$this->class_metadata["directory"] = $directory;
		}

		// UNTUK DATA USER_ID DUMMY
		// $this->session->set_userdata(PREFIX_SESSION . "_USER_ID", 1);
	}
	
}