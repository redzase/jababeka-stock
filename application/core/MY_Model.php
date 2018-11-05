<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class MY_Model extends CI_Model {

	protected $_dbase_jababeka_table_kavlings = "jbbkresi_salestock.kavlings";
	
	protected $_table_permission        = "permission";
	protected $_table_module            = "module";
	protected $_table_module_permission = "module_permission";
	protected $_table_role              = "role";
	protected $_table_role_permission   = "role_permission";
	protected $_table_user              = "user";
	protected $_table_menu              = "menu";

	protected $_table_sector            = "sector";
	protected $_table_sector_kavling    = "sector_kavling";
	protected $_table_logs              = "logs";
    
}