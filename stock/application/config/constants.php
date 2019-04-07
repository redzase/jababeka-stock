<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code


// Others
define('MODULE_CODE_STOCK_SECTOR_KAVLING', 'STOCK_SECTOR_KAVLING');
define('TOKEN_CRON', 'RI27AXFx8Bx1iHpQsHFp5w');
define('LIST_MONTH', serialize(array(
	1 => "Jan",
	2 => "Feb",
	3 => "Mar",
	4 => "Apr",
	5 => "May",
	6 => "Jun",
	7 => "Jul",
	8 => "Aug",
	9 => "Sep",
	10 => "Oct",
	11 => "Nov",
	12 => "Des",
	))
);


// My Constants
define('GLOBAL_STATUS_ACTIVE', 1);
define('GLOBAL_STATUS_NOTACTIVE', 0);
define('TOTAL_ITEM_PER_PAGE', 10);
define('TOTAL_NUM_LINKS', 9);
define('PREFIX_SESSION', "SES_CMS_JABABEKA_STOCK");
define('MENU_CODE', "STOCK");


// Photo
define('ALLOWED_UPLOAD_TYPE', "jpg|jpeg|png");
define('PHOTO_UPLOAD_PATH', "./static/uploads/photos");
define('PHOTO_ORIGINALS_UPLOAD_PATH', "./static/uploads/photos_originals");
define('MAX_PHOTO_UPLOAD_SIZE', 2048);
define('MIN_UPLOAD_WIDTH_PHOTO', 380);
define('MIN_UPLOAD_HEIGHT_PHOTO', 330);
define('SEPARATOR', '-');
define('PHOTO_PATH', "/static/uploads/photos");
define('ORIGINALS_PHOTO_PATH', "/static/uploads/photos_originals");


// Import CSV
define('CSV_UPLOAD_PATH', "./static/uploads/csv");


// Upload PDF
define('PDF_UPLOAD_PATH', "./static/uploads/pdf");
define('ORIGINALS_PDF_PATH', "/static/uploads/pdf");


// Master Status
define('LIST_STATUS_KAVLING', serialize(array(
	1 => "Available",
	2 => "Booked",
	3 => "Sold",
	4 => "Reserved",
	))
);
define('STATUS_BOOKING_KAVLING_REMOVE_FROM_MAP', 999999);
define('STATUS_BOOKING_KAVLING_UNBOOKING', 0);
define('STATUS_BOOKING_KAVLING_AVAILABLE', 0);
define('STATUS_BOOKING_KAVLING_RESERVED', 1);
define('STATUS_BOOKING_KAVLING_BOOKING', 2);


// Module Permission
define('PERMISSION_CREATE', 'CREATE');
define('PERMISSION_READ', 'READ');
define('PERMISSION_UPDATE', 'UPDATE');
define('PERMISSION_DELETE', 'DELETE');
define('PERMISSION_MAPPING', 'MAPPING');
define('PERMISSION_BOOKING', 'BOOKING');
define('PERMISSION_UNBOOKING', 'UNBOOKING');
define('PERMISSION_RESERVED', 'RESERVED');
define('PERMISSION_AVAILABLE', 'AVAILABLE');


// Activity Logs
define('LOGS_ACTIVITY_LIST', serialize(array(
	"INSERT_FIRST_ROW" => "Input data pertama",
	"BOOKING"          => "Booking",
	"UNBOOKING"        => "Unbooking",
	"AVAILABLE"        => "Set Available",
	"RESERVED"         => "Reserved",
	"EDIT"             => "Edit",
	"REMOVE_FROM_MAP"  => "Hapus dari peta",
	))
);
define('LOGS_ACTIVITY_INSERT_FIRST_ROW', 'INSERT_FIRST_ROW');
define('LOGS_ACTIVITY_BOOKING', 'BOOKING');
define('LOGS_ACTIVITY_UNBOOKING', 'UNBOOKING');
define('LOGS_ACTIVITY_AVAILABLE', 'AVAILABLE');
define('LOGS_ACTIVITY_RESERVED', 'RESERVED');
define('LOGS_ACTIVITY_EDIT', 'EDIT');
define('LOGS_ACTIVITY_REMOVE_FROM_MAP', 'REMOVE_FROM_MAP');


// SSO
define('SSO_SERVER_LOGIN', 'http://one.jababeka-stock.com');
define('SSO_SERVER_LOGOUT', 'http://one.jababeka-stock.com/auth/logout');
define('SSO_SERVER', 'http://one.jababeka-stock.com/auth/sso');
define('SSO_BROKER_ID', 'stock');
define('SSO_BROKER_SECRET', 'C6wkZ29gBXQ2Xb0FYEbWHw');


// Code table setting
define('SETTING_CODE_AUTOMATIC_UNBOOKING', 'AUTOMATIC_UNBOOKING');