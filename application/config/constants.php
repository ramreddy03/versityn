<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


//define('REG_MESSAGE_SUSS', 'You have been successfully Registered');
define('REG_MESSAGE_SUSS', 'Thank you for registering. Please check your inbox to activate your account!!!');
define('Login_FAILDMESSAGE', 'Invalid login details OR Please enable login Link!');
define('HLP_MESSAGE_SUSS', 'Thank you for asking us. We will get back to your queries on the provided email!');
/*


/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate REG_MESSAGE_SUSSprocess for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

define('MULTIPLIER', 986662255);
/* End of file constants.php */
/* Location: ./application/config/constants.php */