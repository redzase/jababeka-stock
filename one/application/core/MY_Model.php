<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class MY_Model extends CI_Model {

	protected $_dbase_jababeka_table_kavlings = "stocksync.kavlings";
	
	protected $_table_permission        = "permission";
	protected $_table_module            = "module";
	protected $_table_module_permission = "module_permission";
	protected $_table_role              = "role";
	protected $_table_role_permission   = "role_permission";
	protected $_table_user              = "user";
	protected $_table_menu              = "menu";
	protected $_table_menu_module       = "menu_module";

	protected $_table_sector            = "sector";
	protected $_table_sector_kavling    = "sector_kavling";
	protected $_table_logs              = "logs";
 	
	protected $_table_mst_divisi        = "mst_divisi";
	protected $_table_mst_status        = "mst_status";
	protected $_table_mst_type        	= "mst_type";
	protected $_table_mst_notification  = "mst_notification";

	protected $_table_type_status       = "tbl_type_status";
	protected $_table_type_status_detail = "tbl_type_status_detail";
	protected $_table_tiket        		= "tbl_tiket";
	protected $_table_user_divisi       = "tbl_user_divisi";

}