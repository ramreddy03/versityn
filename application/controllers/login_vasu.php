<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	 
		public function __construct()
	{
		parent::__construct();
			   
			$this->baseurl = $this->config->item('base_url'); #base url path
			$this->load->library('commonclass'); #loading comonclass library
			$this->load->library('session'); #loading session library
			$this->load->helper('url'); #loading url helper
			$this->load->library('email'); #loading email library	
			//$this->config->load('constants');#loading email constants	
			
	}
	public function index()
	{
		//echo"<pre>"; print_R($_POST); echo"</pre>"; die();
		$disp_msg = $this->session->flashdata('disp_msg');		
		if(!empty($_POST)){

			if($_POST['submit'] == "Login"){		

				$username =  !empty($_POST['username']) ? $_POST['username']: '';
				$password =  !empty($_POST['password']) ? $_POST['password']: '';
				$Administrator =  !empty($_POST['admincheckbox']) ? $_POST['admincheckbox']: '';
				if($Administrator == "Administrator"){
					
				$newpassword = base64_encode($password);
				$where = "(username = '".$username."' AND password = '".$newpassword."')";
				$query = $this->commonclass->retrive_records('users','*',$where);
				$userdetails  = (!empty($query[0])) ? $query[0]: '';
				
				if(!empty($userdetails)){	
				
          			$SessionNewData = array( 
                  'username'  => $username, 
                  'password'     => $password, 
                'userid'  => $userdetails['id'], 
                  'logged_in' => TRUE 
				); 	
					
				$CI =& get_instance();  # codeigniter library
				$CI->load->library('session');
				$sessiondata = $SessionNewData; #inserted record id to session var
				$CI->session->set_userdata('prtsesdata',$sessiondata);
				redirect('/admin/index');
				}else{
						$disp_msg = Login_FAILDMESSAGE;
						$this->session->set_flashdata('disp_msg', $disp_msg);
						
					}
				}else{
					
				$newpassword = base64_encode($password);
				 $where = "(username = '".$username."' AND password = '".$newpassword."' AND isactive = 1)"; 
				$query = $this->commonclass->retrive_records('students','*',$where);
				$userdetails  = (!empty($query[0])) ? $query[0]: '';
					if(!empty($userdetails)>0){										
						$user_role_whr = "(id = ".$userdetails['id_role'].")";
						$chk_user_role = $this->commonclass->retrive_records("roles", " * ", $user_role_whr, array(), 1);
						$userrole = (!empty($chk_user_role[0])) ? $chk_user_role[0]['rolename'] : '';
						$foldername = (in_array($userrole, array('Super admin', 'Admin'))) ? 'admin' : 'Student' ;
						if($userdetails['id_role'] == 3 ){
							if($foldername =='Student'){
                 $SessionNewData = array( 
                  'username'  => $username, 
                  'userid'  => $userdetails['id'], 
                  'password'     => $password, 
                  'role'     => $userrole, 
                  'logged_in' => TRUE 
                ); 
                $CI =& get_instance();  # codeigniter library
                $CI->load->library('session');
                $sessiondata = $SessionNewData; #inserted record id to session var
                $CI->session->set_userdata('prtsesdata',$sessiondata);
								redirect('/student/index');
							}
						}				
					}else{
						$disp_msg = Login_FAILDMESSAGE;
						$this->session->set_flashdata('disp_msg', $disp_msg);
						
					}
				}
			}
		}			
		$masteruniversitys = $this->commonclass->retrive_records('university','id,universityname');
		//echo"</pre>"; print_R($masteruniversitys); echo"</pre>";
		$disp_msg = (!empty($disp_msg)) ? $disp_msg : '';
		## ____________  Data sending to the template starts  ____________ ##
		$data['disp_msg'] = $disp_msg; # display messages
		$data['masteruniversitys'] = $masteruniversitys; # display messages
		## ____________  Data sending to the template ends here  ____________ ##	
		$this->load->view('login/login-page',$data);
		//$this->load->view('layouts/sheader');		
		//$this->load->view('login/login-page1',$data);
		//$this->load->view('layouts/sfooter');
	}
	public function adminlogin()
	{
		//echo"<pre>"; print_R($_POST); echo"</pre>"; die();
		$disp_msg = $this->session->flashdata('disp_msg');		
		if(!empty($_POST)){

			if($_POST['submit'] == "Submit"){		

				$username =  !empty($_POST['username']) ? $_POST['username']: '';
				$password =  !empty($_POST['password']) ? $_POST['password']: '';
				$Administrator =  !empty($_POST['Administrator']) ? $_POST['Administrator']: '';
				if(($Administrator == "Administrator")){
					
				$newpassword = base64_encode($password);
				$where = "(username = '".$username."' AND password = '".$newpassword."')";
				$query = $this->commonclass->retrive_records('users','*',$where);
				$userdetails  = (!empty($query[0])) ? $query[0]: '';
				
				
          			$SessionNewData = array( 
                  'username'  => $username, 
                  'password'     => $password, 
                  'userid'  => $query[0]['id'], 
                  'logged_in' => TRUE 
				); 	
					
				$CI =& get_instance();  # codeigniter library
				$CI->load->library('session');
				$sessiondata = $SessionNewData; #inserted record id to session var
				$CI->session->set_userdata('prtsesdata',$sessiondata);
				//redirect('/admin/index');

				}else{
				$newpassword = base64_encode($password);
				$where = "(username = '".$username."' AND password = '".$newpassword."' AND isactive = 1)";
				$query = $this->commonclass->retrive_records('students','*',$where);
				$userdetails  = (!empty($query[0])) ? $query[0]: '';
					if(count($userdetails)>0){										
						$user_role_whr = "(id = ".$userdetails['id_role'].")";
						$chk_user_role = $this->commonclass->retrive_records("roles", " * ", $user_role_whr, array(), 1);
						$userrole = (!empty($chk_user_role[0])) ? $chk_user_role[0]['rolename'] : '';
						$foldername = (in_array($userrole, array('Super admin', 'Admin'))) ? 'admin' : 'Student' ;
						if($userdetails['id_role'] == 3 ){
							if($foldername =='Student'){
                 $SessionNewData = array( 
                  'username'  => $username, 
                  'userid'  => $userdetails['id'], 
                  'password'     => $password, 
                  'role'     => $userrole, 
                  'logged_in' => TRUE 
                ); 
                $CI =& get_instance();  # codeigniter library
                $CI->load->library('session');
                $sessiondata = $SessionNewData; #inserted record id to session var
                $CI->session->set_userdata('prtsesdata',$sessiondata);
								redirect('/student/index');
							}
						}				
					}else{
						$disp_msg = Login_FAILDMESSAGE;
						$this->session->set_flashdata('disp_msg', $disp_msg);
						
					}
				}
			}
		}			
		$masteruniversitys = $this->commonclass->retrive_records('university','id,universityname');
		//echo"</pre>"; print_R($masteruniversitys); echo"</pre>";
		$disp_msg = (!empty($disp_msg)) ? $disp_msg : '';
		## ____________  Data sending to the template starts  ____________ ##
		$data['disp_msg'] = $disp_msg; # display messages
		$data['masteruniversitys'] = $masteruniversitys; # display messages
		## ____________  Data sending to the template ends here  ____________ ##	
		//$this->load->view('login/login-page',$data);
		//$this->load->view('layouts/sheader');		
		$this->load->view('login/login-page',$data);
		//$this->load->view('layouts/sfooter');
	}
	public function register(){	

		 $disp_msg = $this->session->flashdata('disp_msg');
		if(!empty($_POST)){		
			if($_POST['submit'] == "Register"){	
				$username =  !empty($_POST['username']) ? $_POST['username']: '';
				$password =  !empty($_POST['password']) ? base64_encode($_POST['password']): '';
				$university =  !empty($_POST['university']) ? $_POST['university']: '';
				$study =  !empty($_POST['study']) ? $_POST['study']: '';
				$contact =  !empty($_POST['contact']) ? $_POST['contact']: '';
				$subject =  !empty($_POST['subject']) ? $_POST['subject']: '';
				$email =  !empty($_POST['email']) ? $_POST['email']: '';		
				$country =  !empty($_POST['country']) ? $_POST['country']: '';				
				$activation_code = $this->commonclass->rand_string(5);
				$password=base64_encode($username);	
				$insertdate = Array(
					'username' => $username,
					'password' => $password,
					'id_university' => $university ,
					'country' => $country,
					'study' => $study,
					'subject' => $subject,
					'email' => $email,
					'isactive' => 0,
					'id_role' => 3,
					'randamstring' => $activation_code,
					'contact' => $contact
				
				);
				//echo"<pre>"; print_r($insertdate); echo"</pre>"; die();
				if($this->commonclass->insert_record("students", $insertdate)) {
					
					//$activation_link = site_url('login/activation/'.$activation_code);
				$activation_link_mail = "<a href='".site_url('login/activeprofile/'.$activation_code)."' style='padding:5px 10px; margin:5px; border-radius: 5px; border: 1px solid #dddddd;  color: #FFFFFF; background: #2E7D1A;'>Please click to Activate</a>";
			                
             	$mailtemplatetable = "mail_templates";
					$where = "(code_title = 'newuserregistration')";
					$mail_master = $this->commonclass->retrive_records($mailtemplatetable, " * ", $where, array(), 1); 
					$mailtemplate = (!empty($mail_master[0]) && count($mail_master[0])>0 ) ? $mail_master[0] : "";

					
					
						//$from = "karasivasu@gmail.com";
						$from = "karasivasu@gmail.com";
						$to = array($email);
						$subject = $mailtemplate['subject'];
						$message = $mailtemplate['mail_body'];
						
						$exist_values = array("%username%", "%activelink%");
						$needto_replace = array($username, $activation_link_mail);
						
						$mail_body_content = str_replace($exist_values, $needto_replace, $message);
						
						
						$this->email->clear();		
						$config['wordwrap'] = TRUE;
						$config['bcc_batch_mode'] = TRUE;
						$config['mailtype'] = 'html';
						$this->email->initialize($config);
						$this->email->to($to);
						//$this->email->cc('deepak.thodeti@gmail.com');
						$this->email->from($from);
						$this->email->subject($subject);
						$this->email->message($mail_body_content);
						
						$this->email->send();
					$disp_msg = REG_MESSAGE_SUSS;
					$this->session->set_flashdata('disp_msg', $disp_msg);
					redirect('/login/index');
					
				}else{
					$disp_msg = "Error: Please try again";
					$this->session->set_flashdata('disp_msg', $disp_msg);
					redirect('/login/index',$disp_msg);
				} 
			
      }			
		}
		
		$disp_msg = (!empty($disp_msg)) ? $disp_msg : '';
		## ____________  Data sending to the template starts  ____________ ##
		$data['disp_msg'] = $disp_msg; # display messages
		## ____________  Data sending to the template ends here  ____________ ##
			
		$this->load->view('login/register-page',$data);
	}
  
  /**
	 * Logout page.	 
	 */
	public function logout()
	{
		$this->load->library('session'); #loading session library
		$this->load->helper('url'); #loading url helper
		$sessiondata = $this->session->userdata('prtsesdata'); # Existing session data
		$sessiontimeout = $this->session->flashdata('sessiontimeout');		
		
		
		$comments = ($sessiontimeout == 1) ? "Session Timeout" : "Manual Signoff";

			$this->session->unset_userdata('prtsesdata');		
			$this->session->sess_destroy(); #session destroy
		if ($sessiontimeout == 1) {
			$disp_msg = "Error: Your session has expired. Please log-in again!"; #message
		} else {
			$disp_msg = "Success: Logout Success!"; #message
		}
			$this->session->set_flashdata('disp_msg', $disp_msg);			
			redirect('/login/index'); #redirect to login
		
				
	}
  
  public function SentMail()
	{
              

					$mailtemplatetable = "mail_templates";
					$where = "(code_title = 'newuserregistration')";
					$mail_master = $this->commonclass->retrive_records($mailtemplatetable, " * ", $where, array(), 1); 
					$mailtemplate = (!empty($mail_master[0]) && count($mail_master[0])>0 ) ? $mail_master[0] : "";

					
					
						$from = "karasivasu@gmail.com";
						$to = array($email);
						$subject = $mailtemplate['subject'];
						$message = $mailtemplate['mail_body'];
						
						$exist_values = array("%username%", "%activelink%");
						$needto_replace = array($username, $activelink);
						
						$mail_body_content = str_replace($exist_values, $needto_replace, $message);
						
						
						$this->email->clear();		
						$config['wordwrap'] = TRUE;
						$config['bcc_batch_mode'] = TRUE;
						$config['mailtype'] = 'html';
						$this->email->initialize($config);
						$this->email->to($to);
						//$this->email->cc('deepak.thodeti@gmail.com');
						$this->email->from($from);
						$this->email->subject($subject);
						$this->email->message($mail_body_content);
						
						
					//echo"<pre>"; print_R($mailtemplate); echo"</pre>";
             /// $this->email->from('karasivasu@gmail.com', 'Vasu');
            //  $this->email->to('karasivasu@gmail.com');
             // $this->email->cc('deepak.thodeti@gmail.com');

              /* $this->email->subject('Email Test'); */
              //$this->email->message('Testing the email class.');

              //$this->email->send();
  }
  
  public function activeprofile()
	{	
		   $RANDSTRING = $this->uri->segment(3);
		   echo $where = "(randamstring = '".$RANDSTRING."')";
		   $query = $this->commonclass->retrive_records('students','*',$where);
		   $seluserid = $query[0]['id'];
		   $update = Array(
		   'isactive' => 1,
		   );
		if($this->commonclass->update_record("students", $update, "id", $seluserid)) { # update record success
			$disp_msg = "Profile Actived Successfully! Please Login";
			$this->session->set_flashdata('disp_msg', $disp_msg);
			redirect('/login/index',$disp_msg); #redirect to login
		}		
        
	}
	/* End of logout method */
	
	 public function  forgot(){
		 
		 //echo"<pre>"; print_R($_POST); echo"</pre>"; die();
		 # retrive flash message data
		$disp_msg = $this->session->flashdata('disp_msg');		
		if (!empty($_POST)) {
			$username = $_POST['username'];		//$username = 'karasivasu@gmail.com';			
			## portal users table
			$table = "students";
			$where = "((username = '".$username."' OR email='".$username."' ) AND isactive != 0)";
			$user_master = $this->commonclass->retrive_records($table, " * ", $where, array(), 1);		
			//echo"<pre>"; print_R($user_master); echo"</pre>"; die();
			if (!empty($user_master) && count($user_master) > 0) { ## form entered details matched with database values
			$user_master = $user_master[0];			
//echo"<pre>"; print_R($user_master); echo"</pre>"; 			
			## retrieving mail template to send new password
					$mailtemplatetable = "mail_templates";
					$where = "(code_title = 'forgotpassword')";
					$mail_master = $this->commonclass->retrive_records($mailtemplatetable, " * ", $where, array(), 1); 
					$mailtemplate = (!empty($mail_master[0]) && count($mail_master[0])>0 ) ? $mail_master[0] : "";
					
						$sel_user = $user_master['id'];
						//$fullname = ucwords(strtolower($user_master['lastname']." ".$user_master['firstname']));
						$fullname = ucwords(strtolower($user_master['username']));
						
						$randpwd = rand(11111, 99999);
					$updatedata =  array(						
						'password' => base64_encode($randpwd)
						
					);
					//$aa =  $this->commonclass->update_record($table, $updatedata, 'id', $sel_user);
				
					if ( $this->commonclass->update_record($table, $updatedata, 'id', $sel_user) ) {
					$where = "(id = '".$sel_user."')";
					$user_master = $this->commonclass->retrive_records($table, " * ", $where, array(), 1);
						
					//echo"<pre>"; print_R($user_master); echo"</pre>"; die();	
					
						$user_master = $user_master[0];
						$email = $user_master['email'];
						$username = $user_master['username'];
						$password = base64_decode($user_master['password']);
						
						$from = "karasivasu@gmail.com";
						$to = array($email);
						$subject = $mailtemplate['subject'];
						$message = $mailtemplate['mail_body'];
						
						$exist_values = array("%fullname%", "%temporarypwd%", "%changepedbutton%");
						$needto_replace = array($fullname, $randpwd, $activation_link_mail);
						
						$mail_body_content = str_replace($exist_values, $needto_replace, $message);
						
						
						$this->email->clear();		
						$config['wordwrap'] = TRUE;
						$config['bcc_batch_mode'] = TRUE;
						$config['mailtype'] = 'html';
						$this->email->initialize($config);
						$this->email->to($to);
						$this->email->cc('deepak.thodeti@gmail.com');
						$this->email->from($from);
						$this->email->subject($subject);
						$this->email->message($mail_body_content);
						 if ($this->email->send()) {								
							$disp_msg = "Success: Password reset succssfully, please check your mail for details!";
							$this->session->set_flashdata('disp_msg', $disp_msg);	
							redirect('/login/index',$disp_msg); #redirect	
						} else {
							$disp_msg = "Error: Password reset succssfully, Unable to send login details!";
							//echo $disp_msg .= "<br/><br/>".$mail_body_content;	
							$this->session->set_flashdata('disp_msg', $disp_msg);				
							redirect('/login/index',$disp_msg); #redirect
						} 
						
					}
					
		
			} else { ## form values not matched with db values
				$disp_msg = "Error: Invalid Username / Email!"; #message
				$this->session->set_flashdata('disp_msg', $disp_msg);			
				//redirect(current_url(), 'refresh'); #redirect
			}
		}
		
		
		$disp_msg = (!empty($disp_msg)) ? $disp_msg : '';
		## ____________  Data sending to the template starts  ____________ ##
		$data['disp_msg'] = $disp_msg; # display messages
		## ____________  Data sending to the template ends here  ____________ ##
		//$this->load->view('layouts/sheader');		
		$this->load->view('login/forgot-page',$data);
		//$this->load->view('layouts/sfooter');
		
	 }
	 
   
   public function newcountryserach(){
		
		
		if(!empty($_POST["countrykeyword"])) {
		$keyword = !empty($_POST['countrykeyword']) ? $_POST['countrykeyword']:''	;
		$where_serach = "(country_name like '".$keyword."%')";		
		$masteruniversitys = $this->commonclass->retrive_records('country','id,country_name',$where_serach,array("id" => "DESC"),6);
		}else{
			$masteruniversitys = '';
		}
		
		 $output = ''; 
		
      foreach ($masteruniversitys as $country)  
      {        
		 
         $output .= "<option value='".$country['id']."'>". $country['country_name']."</option>";  
      }   
	 
      echo $output;  
	  
	  
	 }
   
	 public function countryserach(){
		
		//$keyword = !empty($_POST['keyword']) ? $_POST['keyword']:'';
		
		//$masteruniversitys = $this->commonclass->retrive_records('university','id,universityname');
		//SELECT * FROM country WHERE country_name like '" . $_POST["keyword"] . "%' ORDER BY country_name LIMIT 0,6";
		if(!empty($_POST["keyword"])) {
		$keyword = !empty($_POST['countrykeyword']) ? $_POST['keyword']:''	;
		$where_serach = "(universityname like '".$keyword."%')";		
		$masteruniversitys = $this->commonclass->retrive_records('university','id,universityname',$where_serach,array("id" => "DESC"),6);
		 //echo"<pre>"; print_R($masteruniversitys); echo"</pre>";
		}else{
			$masteruniversitys = '';
		}
		
		 $output = ''; 
		
      foreach ($masteruniversitys as $country)  
      {  
         //here we build a dropdown item line for each  
         //query result  
		 
         $output .= "<option value='".$country['id']."'>". $country['universityname']."</option>";  
      }   
	 
      echo $output; 
	 }
  public function CheckingEmails()
  {
    //
    
    $email       = !empty($_POST['email']) ? $_POST['email'] : '';
    //$id = $_POST['id']
   // $where          = "( email LIKE'%".$email."%')";
    //echo $where          = "( email ='".$email."')";
    //$students = $this->commonclass->retrive_records('students', '*', '(email LIKE "'%.$email.%'")', array("id" => "ASC"), '');   

    $expensesquery  = "SELECT *  FROM `students` WHERE `email` LIKE '%".$email."%'";
    $queryresult    = $this->commonclass->execute_rawquery($expensesquery);
    $students = $queryresult->result_array();
    //echo"<pre>"; print_R($students); echo"</pre>";
    if (count($students)> 0) {
      echo $msg = "invalid";
    } else {
      echo $msg = 0;
    }   
    exit;
  }
  public function universitylogin(){
	//echo"<pre>"; print_R($_POST); echo"</pre>"; die();
		$disp_msg = $this->session->flashdata('disp_msg');		
		if(!empty($_POST)){

			if($_POST['submit'] == "Login"){		

				$username =  !empty($_POST['username']) ? $_POST['username']: '';
				$password =  !empty($_POST['password']) ? $_POST['password']: '';
				
					
				$newpassword = base64_encode($password);
				 $where = "(username = '".$username."' AND password = '".$newpassword."' AND isactive = 1)"; 
				$query = $this->commonclass->retrive_records('universityregister','*',$where);
				$userdetails  = (!empty($query[0])) ? $query[0]: '';
					if(!empty($userdetails)>0){	
                 $SessionNewData = array( 
                  'username'  => $username, 
                  'userid'  => $userdetails['id'], 
                  'password'     => $password, 
                  'role'     => $userrole, 
                  'logged_in' => TRUE 
                ); 
                $CI =& get_instance();  # codeigniter library
                $CI->load->library('session');
                $sessiondata = $SessionNewData; #inserted record id to session var
                $CI->session->set_userdata('prtsesdata',$sessiondata);
				redirect('/university/dashbaord');
							}
						
					}else{
						$disp_msg = Login_FAILDMESSAGE;
						$this->session->set_flashdata('disp_msg', $disp_msg);
						
					}
				}
			
		}			
		$masteruniversitys = $this->commonclass->retrive_records('university','id,universityname');
		//echo"</pre>"; print_R($masteruniversitys); echo"</pre>";
		$disp_msg = (!empty($disp_msg)) ? $disp_msg : '';
		## ____________  Data sending to the template starts  ____________ ##
		$data['disp_msg'] = $disp_msg; # display messages
		$data['masteruniversitys'] = $masteruniversitys; # display messages
		## ____________  Data sending to the template ends here  ____________ ##	
		$this->load->view('university/login-page',$data);
  }
  public function universityregister(){
	 // echo"<pre>"; print_R($_POST); echo"</pre>";
	   $disp_msg = $this->session->flashdata('disp_msg');
		if(!empty($_POST)){		
			if($_POST['submit'] == "Register"){	
				$username =  !empty($_POST['username']) ? $_POST['username']: '';
				$password =  !empty($_POST['password']) ? base64_encode($_POST['password']): '';
				$university =  !empty($_POST['university']) ? $_POST['university']: '';				
				$email =  !empty($_POST['email']) ? $_POST['email']: '';		
				$country =  !empty($_POST['country']) ? $_POST['country']: '';				
				$activation_code = $this->commonclass->rand_string(5);
				$password=base64_encode($username);	
				$insertdate = Array(
					'username' => $username,
					'password' => $password,
					'universityid' => $university ,
					'countryid' => $country,
					'email' => $email,
					'status' => 0,				
					'randamstring' => $activation_code
				
				);
				//echo"<pre>"; print_r($insertdate); echo"</pre>"; die();
				if($this->commonclass->insert_record("universityregister", $insertdate)) {
					
					//$activation_link = site_url('login/activation/'.$activation_code);
				$activation_link_mail = "<a href='".site_url('login/universityactiveprofile/'.$activation_code)."' style='padding:5px 10px; margin:5px; border-radius: 5px; border: 1px solid #dddddd;  color: #FFFFFF; background: #2E7D1A;'>Please click to Activate</a>";
			                
             	$mailtemplatetable = "mail_templates";
					$where = "(code_title = 'newuserregistration')";
					$mail_master = $this->commonclass->retrive_records($mailtemplatetable, " * ", $where, array(), 1); 
					$mailtemplate = (!empty($mail_master[0]) && count($mail_master[0])>0 ) ? $mail_master[0] : "";
						//$from = "karasivasu@gmail.com";
						$from = "karasivasu@gmail.com";
						$to = array($email);
						$subject = $mailtemplate['subject'];
						$message = $mailtemplate['mail_body'];
						
						$exist_values = array("%username%", "%activelink%");
						$needto_replace = array($username, $activation_link_mail);
						
						$mail_body_content = str_replace($exist_values, $needto_replace, $message);
						
						
						$this->email->clear();		
						$config['wordwrap'] = TRUE;
						$config['bcc_batch_mode'] = TRUE;
						$config['mailtype'] = 'html';
						$this->email->initialize($config);
						$this->email->to($to);
						//$this->email->cc('deepak.thodeti@gmail.com');
						$this->email->from($from);
						$this->email->subject($subject);
						$this->email->message($mail_body_content);
						
						$this->email->send();
					$disp_msg = REG_MESSAGE_SUSS;
					$this->session->set_flashdata('disp_msg', $disp_msg);
					redirect('/login/universitylogin');
					
				}else{
					$disp_msg = "Error: Please try again";
					$this->session->set_flashdata('disp_msg', $disp_msg);
					redirect('/login/universitylogin',$disp_msg);
				} 
			
			}			
		}
		
		$disp_msg = (!empty($disp_msg)) ? $disp_msg : '';
		## ____________  Data sending to the template starts  ____________ ##
		$data['disp_msg'] = $disp_msg; # display messages
		## ____________  Data sending to the template ends here  ____________ ##
			
		$this->load->view('university/universityregister',$data);
  }
  
   public function CheckinguniversityEmails()
  {
    $email       = !empty($_POST['email']) ? $_POST['email'] : '';
    $expensesquery  = "SELECT *  FROM `universityregister` WHERE `email` LIKE '%".$email."%'";
    $queryresult    = $this->commonclass->execute_rawquery($expensesquery);
    $students = $queryresult->result_array();
    //echo"<pre>"; print_R($students); echo"</pre>";
    if (count($students)> 0) {
      echo $msg = "invalid";
    } else {
      echo $msg = 0;
    }   
    exit;
  }
  
  
  public function universityactiveprofile()
	{	
		   $RANDSTRING = $this->uri->segment(3);
		   echo $where = "(randamstring = '".$RANDSTRING."')";
		   $query = $this->commonclass->retrive_records('universityregister','*',$where);
		   $seluserid = $query[0]['id'];
		   $update = Array(
		   'status' => 1,
		   );
		if($this->commonclass->update_record("universityregister", $update, "id", $seluserid)) { # update record success
			$disp_msg = "University Actived Successfully! Please Login";
			$this->session->set_flashdata('disp_msg', $disp_msg);
			redirect('/login/universitylogin',$disp_msg); #redirect to login
		}		
        
	}
  
}
