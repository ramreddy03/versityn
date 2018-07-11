<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class loginfunctions {
	/*
	*	Function : sec_session_start
	*	Usage: to start secure session
	*
	*	Params : 
	*	mandatory params: 
	*
	*
	*	return 
	*	
	*/
	public function sec_session_start() {
		$session_name = 'sec_session_id'; // Set a custom session name
		$secure = false; // Set to true if using https.
		$httponly = true; // This stops javascript being able to access the session id. 
		
		ini_set('session.use_only_cookies', 1); // Forces sessions to only use cookies. 
		$cookieParams = session_get_cookie_params(); // Gets current cookies params.
		session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly); 
		session_name($session_name); // Sets the session name to the one set above.
		session_start(); // Start the php session
		session_regenerate_id(true); // regenerated the session, delete the old one.     
	}
	/* End of sec_session_start method */
	
	/*
	*	Function : login 
	*	Usage: perform login process
	*
	*	Params : $username, $password, $role
	*	mandatory params: - All -
	*
	*
	*	return true on login success, false on failure
	*	
	*/
	public function login($username, $password, $role) {
		$CI =& get_instance();  # codeigniter library
		$CI->load->library('session');
		
		date_default_timezone_set('UTC'); #timestamp setting
		
		if ($role == "Student") {  ## Employee table
			# SELECT part other than *
			$CI->db->select('idemployee as userid, username, password, email');
					
			#table name
			$table = "students";
			#status for whr condition
		//	$status_cond = "isactive != 0";
			$status_cond = "isactive != 0";
		} else {  ## portal users table
			# SELECT part other than *
			//$CI->db->select('idportalusers as userid, username, password, email');			
			#table name
			//$table = "portalusers";
			#status for whr condition
			//$status_cond = "is_active != 0";
			$status_cond = "";
		}
		
		#table name
		$CI->db->from($table);	
		
		# where conditions
		$where = "((username = '".$username."' OR email='".$username."' ) AND ".$status_cond.")";
		$CI->db->where($where);
		
		#limit
		$CI->db->limit(1);
		
		# Query execution and retriving results			
		$query = $CI->db->get(); 
		
		$num_rows = $query->num_rows(); # no.of rows from the db table
		$resultset = $query->result_array(); # results from the db table
			
		if($num_rows > 0) { // If record exists
			$userdetails = $resultset[0];		
			// We check if the account is locked from too many login attempts
			if($this->checkbrute($userdetails['userid'], $table) == true) { 
				// Account is locked
				$disp_msg = "Account is locked";
				// Send an email to user saying their account is locked
				//echo $CI->send_mail();
				return 100;
			} else {
				$db_password = $userdetails['password'];
		 		$user_id = $userdetails['userid'];
				 if($db_password == $password) { // Check if the password in the database matches the password the user submitted. 
				 	
					// Password is correct!		 
					   $ip_address = $_SERVER['REMOTE_ADDR']; // Get the IP address of the user. 
					   $user_browser = $_SERVER['HTTP_USER_AGENT']; // Get the user-agent string of the user.
					   $user_id = preg_replace("/[^0-9]+/", "", $user_id); // XSS protection as we might print this value
					   $username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $username); // XSS protection as we might print this value
					   
						$login_string = hash('sha512', $password.$ip_address.$user_browser);
						$sessiondata = array(
							'user_id'  => $user_id,
							/*'username' => $username,*/
							'usertype' => $table,
							'login_string' => $login_string
						);
						
					/* saving data in login track starts here */
					$ipaddr = $_SERVER['REMOTE_ADDR'];
					$browser = get_browser(null, true);

					#table name
					$CI->db->from('login_track');	
						
					# where conditions
					$where = "(usertype = '".$table."' AND loginid='".$user_id."' AND logouttime = '0000-00-00 00:00:00')";
					$CI->db->where($where);
							
					# Query execution and retriving results			
					$query = $CI->db->get(); 
					
					$existinglogins = $query->num_rows(); # no.of rows from the db table
					$existinglogin = $query->result_array(); # results from the db table
							 
					if ($existinglogins>0) { # if any existing logins for the logging in user
						foreach ($existinglogin as $existingrec) {		
							$updatedata = array(
							   'logouttime' => date("Y-m-d H:i:s", mktime(date('H')+5, date('i')+30, date('s'), date("m"), date("d"), date("Y"))),
							   'comments' => "multiple logins"
							);
							
							$CI->db->where('idlogin_track', $existingrec['idlogin_track']);
							$CI->db->update('login_track', $updatedata); # force signout
						}
					}					

					$data = array(
					   'usertype' => $table ,
					   //'device' => 'mobile',
					   'loginid' => $user_id ,
					   'logintime' => date("Y-m-d H:i:s", mktime(date('H')+5, date('i')+30, date('s'), date("m"), date("d"), date("Y"))),
					   'ip' => $ipaddr ,
					   'browser' => $browser['browser']." ".$browser['version'],
					   'sessionid' => $login_string
					);
					
					$insert_flag = $CI->db->insert('login_track', $data);  #insert record in to login_track
					$inserted_id = $CI->db->insert_id(); #inserted record id
					/* saving data in login track ends here */
					
					$sessiondata['idlogin_track'] = $inserted_id; #inserted record id to session var
					
					$CI->session->set_userdata('prtsesdata', $sessiondata); # Creating session (prtsesdata: portal session data)
					
					$inactive = SESION_IDLE_TIME; ## idle time from constants.php
					$newtime = time() + $inactive;
					$CI->session->set_userdata('timeout_idle', $newtime);
						
					   // Login successful.
					   return 1;    
				 } else {
					// Password is not correct
					// We record this attempt in the database
					$now = time();
					$data = array(
					   'user_id' => $user_id ,
					   'tablename' => $table ,
					   'time' => $now
					);
					$insert_flag = $CI->db->insert('login_attempts', $data); 
					return false;
				 }
			}
				  
		} else {
			// No record
			return false;
		}
		
	}
	
	/* End of login method */
	
	/*
	*	Function : checkbrute 
	*	Usage: check for 5 incorrect login attempts
	*
	*	Params : $user_id, $table
	*	mandatory params: - All -
	*
	*
	*	return true on account locked after 5 incorret attempts, false on success
	*	
	*/	
	public function checkbrute($user_id, $table) {
		$CI =& get_instance();  # codeigniter library
		$CI->load->library('session');
	   // Get timestamp of current time
	   $now = time();
	   // All login attempts are counted from the past 1 hours. 
	   $valid_attempts = $now - (5 * 60); 
	   
		# SELECT part other than *
		$CI->db->select('time');
		
		#table name
		$CI->db->from('login_attempts');
		
		# where conditions
		$where = "(user_id= '".$user_id."' AND tablename = '".$table."' AND time > '".$valid_attempts."')";
		$CI->db->where($where);	
		
		# Query execution and retriving results			
		$query = $CI->db->get(); 
		$attempts = $query->num_rows(); # no.of rows from the db table
		$loginattempts = $query->result_array(); # results from the db table
		
		  // If there has been more than 5 failed logins
		  if($attempts > 5) {
			 return true;
		  } else {
			 return false;
		  }
		  
	}	
	/* End of checkbrute method */
	
	/*
	*	Function : login_check 
	*	Usage: login check for each and every page
	*
	*	Params :
	*	mandatory params:
	*
	*
	*	return true on login exists, false on new login
	*	
	*/
	public function login_check() {
		$CI =& get_instance();  # codeigniter library
		$CI->load->library('session');
		$sessiondata = $CI->session->userdata('prtsesdata');
		
		//print_r($sessiondata);
		
	   // Check if all session variables are set
	   if(isset($sessiondata['user_id'], $sessiondata['login_string'])) {
		 $user_id = $sessiondata['user_id'];
		 $login_string = $sessiondata['login_string'];
		 $table = $sessiondata['usertype'];
		 $ip_address = $_SERVER['REMOTE_ADDR']; // Get the IP address of the user. 
		 $user_browser = $_SERVER['HTTP_USER_AGENT']; // Get the user-agent string of the user.
	 	 
		#table name
		$CI->db->from('login_track');	
			
		# where conditions
		$where = "(usertype = '".$table."' AND loginid='".$user_id."' AND logouttime = '0000-00-00 00:00:00' AND sessionid = '". $login_string ."')";
		$CI->db->where($where);
				
		# Query execution and retriving results			
		$query = $CI->db->get(); 
		
		$existinglogins = $query->num_rows(); # no.of rows from the db table
		$existinglogin = $query->result_array(); # results from the db table
		if ($existinglogins == 0) {
		 return "101"; # no session
		//   return "102"; # Multiple sessions
		} else if ($existinglogins == 1) {
		$CI->db->select('password');
		#table name
		$CI->db->from($table);	
		
		$pk = "id".$table;		
		# where conditions
		$where = "($pk = '".$user_id."')";
		$CI->db->where($where);
		
		#limit
		$CI->db->limit(1);
		
		# Query execution and retriving results			
		$query = $CI->db->get(); 
		
		$num_rows = $query->num_rows(); # no.of rows from the db table
		$resultset = $query->result_array(); # results from the db table
		
	 
			if($num_rows == 1) { // If the user exists
				$db_password = $resultset[0]['password'];
				
			   $login_check = hash('sha512', $db_password.$ip_address.$user_browser);
			   if($login_check == $login_string) {
				  // Logged In!!!!
				  return true;
			   } else {
				  // Not logged in
				  return "104";
			   }
			} else {
				// Not logged in
		 return "101";
			}
		} else {
		 // Multiple sessions
		 return "102";
	   }
			
	   } else {
		 // Not logged in, no session
		 return "103";
	   }
	}


} //ending class
?>
