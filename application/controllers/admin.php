<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

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
			$this->sessiondata = $this->session->userdata('prtsesdata');     
      $siteconfigdetails = $this->commonclass->retrive_records("siteconfig", " * ");
      $this->siteconfig  = !empty($siteconfigdetails[0]) ? $siteconfigdetails[0]: '';
			  if($this->sessiondata['logged_in'] != 1){ ## Login Checking
			   redirect('login/index');	 
			  }
	}

	public function index()
	{


	$eventcount = $this->commonclass->retrive_records('events','count(*) as eventcount','');
	##Count Code start here
	$accfriends = $this->commonclass->retrive_records('students','count(*) as acpfrinds','(isactive = 1 )',array());
	$pendingfriends = $this->commonclass->retrive_records('students','count(*) as pending','(isactive = 0)',array());
	## Count
	
    $JobCount = $this->commonclass->retrive_records('jobs','count(*) as JobCount','(status = 1)');  	
	$countnewsfeed = $this->commonclass->retrive_records('newsfeed','count(*) as countnewsfeed','(status = "Active")');	
	$countdetails  = array();
	$countdetails['accfriends'] = $accfriends[0]['acpfrinds'];
	$countdetails['pendingfriends'] = $pendingfriends[0]['pending'];
	$countdetails['JobCount'] = $JobCount[0]['JobCount'];
	$countdetails['eventcount'] = $eventcount[0]['eventcount'];
	$countdetails['countnewsfeed'] = $countnewsfeed[0]['countnewsfeed'];
	
	
		$where = '(isactive != 0)';
		$student_query = $this->commonclass->retrive_records("students", " * ",$where);
		
		$student_result = array();
		$i = 0;
		if(count($student_query)>0){
			foreach($student_query as $sing_rec){
					
					$where_uni = "(id = ".$sing_rec['id_university'].")";
					$university = $this->commonclass->retrive_records("university", " * ",$where_uni);
		
					$status = ($sing_rec['isactive'] == 1) ? 'Active': 'Delete';
					$student_result[$i]['id'] = $sing_rec['id'];
					$student_result[$i]['username'] = $sing_rec['username'];
					$student_result[$i]['name'] = $sing_rec['firstname'].' '.$sing_rec['lastname'];
					$student_result[$i]['surname'] = $sing_rec['surname'];
					$student_result[$i]['email'] = $sing_rec['email'];
					$student_result[$i]['contact'] = $sing_rec['contact'];
					$student_result[$i]['status'] = $status;
					$student_result[$i]['newstatus'] = $sing_rec['isactive'];
					$student_result[$i]['universityname'] = $university[0]['universityname'];
					$student_result[$i]['country'] = $university[0]['country'];
					$student_result[$i]['state'] = $university[0]['state'];
					$student_result[$i]['city'] = $university[0]['city'];
					$student_result[$i]['address'] = $university[0]['address'];
			$i++;}
		}
$disp_msg = $this->session->flashdata('disp_msg');	
		$data_header['results'] = $student_result;
		$data_header['siteconfig'] = $this->siteconfig;
		$data['siteconfig'] = $this->siteconfig;
		$data['countdetails'] = $countdetails;
		$data['disp_msg'] = $disp_msg;
		
		$this->load->view('layouts/adminheader',$data_header);
		$this->load->view('admin/dashboard',$data);
		$this->load->view('layouts/adminfooter');

		
	}
	
	public function university($selid = ''){
		
		$selid = !empty($selid) ? $selid: '';
		$disp_msg = $this->session->flashdata('disp_msg');		
		
		$university_result = $this->commonclass->retrive_records("university", " * ");
		/* $university_result = array();
		$i = 0;
		if(count($university)>0){
			foreach($university as $sing_rec){
											
					$university_result[$i]['universityname'] = $sing_rec['universityname'];
					$university_result[$i]['country'] = $sing_rec['country'];
					$university_result[$i]['country_id'] = $sing_rec['country_id'];
					$university_result[$i]['state'] = $sing_rec['state'];
					$university_result[$i]['city'] = $sing_rec['city'];
					$university_result[$i]['address'] = $sing_rec['address'];
					$university_result[$i]['id'] = !empty($sing_rec['id']) ? $sing_rec['id']: '';
			$i++;}
		} */
		$countrymaster =  $this->commonclass->retrive_records('country', ' * ', ""); # users Table
				
		if($selid > 0) {
			$university =  $this->commonclass->retrive_records('university', ' * ', "(id = ".$selid.")"); # users Table
				
			$universitydata =  $university[0] ;
		} else {
			$universitydata = array();
		}
		
		if (!empty($_POST['submit']) && $_POST['submit'] == "Save") {			
			if($selid > 0) {
						
				$formdata = array(
								
							'universityname' => $_POST['universityname'],
							'country_id' => $_POST['Country'],
							'state' => $_POST['State'],
							'city' => $_POST['City'],
							'address' => $_POST['address'],							
							'createdon' => date('Y-m-d HH:mm:ss')
							);
				
					if($this->commonclass->update_record("university", $formdata, "id", $selid)) { # update record success
					
					
						$disp_msg = 'University details updated successfully';
					}
		
			}else{
					$formdata = array(								
							'universityname' => $_POST['universityname'],
							'country_id' => $_POST['Country'],
							'state' => $_POST['State'],
							'city' => $_POST['City'],
							'address' => $_POST['address'],
							'status' => 1,
							'createdon' => date('Y-m-d HH:mm:ss')
							);
					if($this->commonclass->insert_record("university", $formdata)) {
					$disp_msg = 'University Added successfully';	
					} 
			
					
				}
				
					$this->session->set_flashdata('disp_msg', $disp_msg);
					   redirect('/admin/university');	 
			
			}
		
	
		$data_header['results'] = $university_result;
		$data['universitydata'] = $universitydata;
		$data['disp_msg'] = $disp_msg;
		$data['selid'] = $selid;
		$data_header['siteconfig'] = $this->siteconfig;
		$data['siteconfig'] = $this->siteconfig;
		$data['countrymaster'] = $countrymaster;
		
		$this->load->view('layouts/adminheader',$data_header);
		$this->load->view('admin/university',$data);
		$this->load->view('layouts/adminfooter');
	}
	

	
	
	/**
	 * userrolesform Page for cpanel controller.
	 *
	 */
	public function roles($selid = 0)
	{
		$disp_msg = $this->session->flashdata('disp_msg');	
		$roles = $this->commonclass->retrive_records("roles", " * ");
		$roles_result = array();
		$i = 0;
		if(count($roles)>0){
			foreach($roles as $sing_rec){
											
					$roles_result[$i]['rolename'] = $sing_rec['rolename'];
					$roles_result[$i]['status'] = $sing_rec['status'];
				   $roles_result[$i]['id'] = !empty($sing_rec['id']) ? $sing_rec['id']: '';
			$i++;}
		}
		if($selid > 0) {
			$userroles =  $this->commonclass->retrive_records('roles', ' * ', "(id = ".$selid.")"); # user roles Table
			$userroleslist = (!empty($userroles[0])) ? $userroles[0] : array();
		} else {
			$userroleslist = array();
		}		
		if (!empty($_POST['submit']) && $_POST['submit'] == "Save") {
		if($selid == 0) {				
				$formdata = array(
								'rolename' => $_POST['rolename'],
								'status' => 1
				);
				
				if($this->commonclass->insert_record("roles", $formdata)) {				
						$disp_msg = 'Role saved successfully!';				
			
					}
				}
			 else if ($selid > 0) {				
					$formdata = array(
								'rolename' => $_POST['rolename'],	
							);
					
					if($this->commonclass->update_record("roles", $formdata, "id", $selid)) { # update record success					
					$disp_msg = 'Role Updated Successfully!';
					}
					$this->session->set_flashdata('disp_msg', $disp_msg);
					redirect(current_url());
				}
					
			}
			//exit;
			
		## ____________  Data sending to the template starts  ____________ ##
		$data['disp_msg'] = $disp_msg; # display messages
		$data['userroleslist'] = $userroleslist; # userroleslist
		$data['selid'] = $selid; # selid
		$data_header['siteconfig'] = $this->siteconfig;
		$data['results'] = $roles_result;
		## ____________  Data sending to the template ends here  ____________ ##
		
		$this->load->view('layouts/adminheader',$data_header);
		$this->load->view('admin/userrolesform-page', $data); # html view page
		$this->load->view('layouts/adminfooter');
		
		
	}
	/**
	 * userrolesform Page for cpanel controller.
	 *
	 */
	public function paypalPackages($selid = 0)
	{
		$disp_msg = $this->session->flashdata('disp_msg');	
		
		$paypalPackages = $this->commonclass->retrive_records("paypalPackages", " * ");
		
			
		if($selid > 0) {
			$userroles =  $this->commonclass->retrive_records('paypalPackages', ' * ', "(pay_id = ".$selid.")"); # user roles Table
			$userroleslist = (!empty($userroles[0])) ? $userroles[0] : array();
		} else {
			$userroleslist = array();
		}		
		if (!empty($_POST['submit']) && $_POST['submit'] == "Save") {
		if($selid == 0) {				
				$formdata = array(
								'pay_term' => $_POST['pay_term'],
								'pay_mnth_year' => $_POST['pay_mnth_year'],
								'pay_cost' => $_POST['pay_cost'],
								'pay_status' => $_POST['pay_status'],
								
				);
				
				if($this->commonclass->insert_record("paypalPackages", $formdata)) {				
						$disp_msg = 'Paypal Packages saved successfully!';				
			
					}
						$this->session->set_flashdata('disp_msg', $disp_msg);
					redirect(current_url());
				}
			 else if ($selid > 0) {				
					$formdata = array(
								'pay_term' => $_POST['pay_term'],
								'pay_mnth_year' => $_POST['pay_mnth_year'],
								'pay_cost' => $_POST['pay_cost'],
								'pay_status' => $_POST['pay_status'],
								
							);
					
					if($this->commonclass->update_record("paypalPackages", $formdata, "pay_id", $selid)) { # update record success					
					$disp_msg = 'Paypal Packages Updated Successfully!';
					}
					$this->session->set_flashdata('disp_msg', $disp_msg);
					redirect(current_url());
				}
					
			}
			//exit;
			
		## ____________  Data sending to the template starts  ____________ ##
		$data['disp_msg'] = $disp_msg; # display messages
		$data['userroleslist'] = $userroleslist; # userroleslist
		$data['selid'] = $selid; # selid
		$data_header['siteconfig'] = $this->siteconfig;
		$data['results'] = $paypalPackages;
		## ____________  Data sending to the template ends here  ____________ ##
		
		$this->load->view('layouts/adminheader',$data_header);
		$this->load->view('admin/paypalPackages-page', $data); # html view page
		$this->load->view('layouts/adminfooter');
		
		
	}
	public function myaccount(){
		
		$disp_msg = $this->session->flashdata('disp_msg');		
		##Login User details
		$where = "(id = '".$this->sessiondata['userid']."')";
		$query = $this->commonclass->retrive_records('users','*',$where);
		//echo"<pre>"; print_R($_POST); echo"</pre>";	
		
		if(!empty($_POST)) {
			$seluserid = $this->sessiondata['userid'];
			if($_POST['Submit'] == "Save Profile") {
					$formdata = array(
								'firstname' => $_POST['firstname'],
								'lastname' => $_POST['lastname'],
								'firstname' => $_POST['firstname'],
								'email' => $_POST['email'],
								'contact' => $_POST['contact'],								
							);
				
					if($this->commonclass->update_record("users", $formdata, "id", $seluserid)) { # update record success
						$disp_msg = "Updated Profile successfully";
						$this->session->set_flashdata('disp_msg', $disp_msg);
						redirect(current_url());	 # redirect to samepage		
					}
			} else if($_POST['Submit'] == "Change Password") {
				 if($query[0]['password'] !=  base64_encode($_POST['changepassword'])){
							$disp_msg ="Current password is worng";
						$this->session->set_flashdata('disp_msg', $disp_msg);
						redirect(current_url());	 # redirect to samepage		 
				}else if($_POST['newpassword'] !=  $_POST['retypepassword']){
							$disp_msg ="Missmatching the Password";
						$this->session->set_flashdata('disp_msg', $disp_msg);
						redirect(current_url());	 # redirect to samepage		 
				}else{
				$formdata = array(
								'password' => base64_encode($_POST['newpassword']),
							);
				
					if($this->commonclass->update_record("users", $formdata, "id", $seluserid)) { # update record success
						$disp_msg = "Updated Password successfully";
						$this->session->set_flashdata('disp_msg', $disp_msg);
						redirect(current_url());	 # redirect to samepage		
					}		
						
				}
			}
		}
		
		
		
		$data_header['siteconfig'] = $this->siteconfig;
		$data['siteconfig'] = $this->siteconfig;
		$data['mydata'] = $query[0];
		$data['disp_msg'] = $disp_msg;

		$this->load->view('layouts/adminheader',$data_header);
		$this->load->view('admin/myaccount',$data);
		$this->load->view('layouts/adminfooter');
	}
	
	public function events($selid  = ''){
		
		$disp_msg = $this->session->flashdata('disp_msg');		
		##Login User details		
		$query = $this->commonclass->retrive_records('events','*');
		$universityquery = $this->commonclass->retrive_records('university','*');
		//echo"<pre>"; print_R($_POST); echo"</pre>";	
		//echo"<pre>"; print_R($_FILES); echo"</pre>";	die();
		$approval_inputFileName = "";
		$approvalName = "";
		$tmpName = "";
		$fileSize = "";
		$approvalfileType = "";
		if (!empty($_POST['submit']) && $_POST['submit'] == "Save") {
			if($selid == 0) {	
				$uploads_dir = 'uploads';
				$foldername = 'Events';
				$subfoldername = $_POST['university'];
				$uploadpath = './'.$uploads_dir.'/'.$foldername.'/'.$subfoldername.'/';
				/* attachment uploads directory path start */
				
				$approvalName = $_FILES['fileToUpload']['name']; ## file actual name
				$tmpName  = $_FILES['fileToUpload']['tmp_name']; ## temp directory name
				$fileSize = $_FILES['fileToUpload']['size']; ## file size
				$approvalfileType = $_FILES['fileToUpload']['type']; ## file type
				
				/* file uploading starts here */
				if (!file_exists($uploadpath)) {
					mkdir($uploadpath, 0777, TRUE);
				}
				## attachment random name => i-140_userid_currenttimestamp
				$approval_randname = $subfoldername."_".date('Y-m-dH-i-s');		
				## renaming actual file with random name
				$config['file_name'] = $approval_randname;	
				## upload path			
         		$config['upload_path'] = $uploadpath;
				## allowed file types
				$config['allowed_types'] = 'png|jpe|jpeg|jpg|gif|bmp';
				## uploads library
				$this->load->library('upload', $config);
				## uploading file.csv
				//echo"<pre>"; print_R($config); echo"</pre>";	 die();
				/*if (!$this->upload->do_upload('fileToUpload'))
				{ ## file not moved show error and redirecting to current page				
					$status = 'error';
					$disp_msg = $this->upload->display_errors('', '');	
					$this->session->set_flashdata('disp_msg', $disp_msg);
					redirect(current_url(), 'refresh');	 # redirect to samepage		
				} else {	*/				
					## retreiving uploaded data to save in database 
					$data123 = $this->upload->data();
					$approval_inputFileName = basename($data123['full_path']);
					
				
			/*	} */
			
		
				
				$formdata = array(
								'eventName' => $_POST['eventname'],
								'eventDesc' => $_POST['eventDesc'],
								'eventStrtDt' => $_POST['eventStrtDt'],
								'eventEndDt' => $_POST['eventEndDt'],
								'eventImgs' => $approvalName ,
								'ImgRndName' => $approval_inputFileName,
								'ImgType' => $approvalfileType,
								'univId' => $_POST['university'],
								
				);
				
				if($this->commonclass->insert_record("events", $formdata)) {				
						$disp_msg = 'Event saved successfully!';
						$this->session->set_flashdata('disp_msg', $disp_msg);						
									redirect(current_url());		
					}
				}else if ($selid > 0) {				
					$formdata = array(
								'univId' => $_POST['university'],
								'eventName' => $_POST['eventname'],
								'eventDesc' => $_POST['eventDesc'],
								'eventStrtDt' => $_POST['eventStrtDt'],
								//'eventImgs' => $approvalName ,
								//'ImgRndName' => $approval_inputFileName,
								//'ImgType' => $approvalfileType,
								'eventEndDt' => $_POST['eventEndDt'],
							);
					
					if($this->commonclass->update_record("events", $formdata, "eventId", $selid)) { # update record success					
					$disp_msg = 'Event Updated Successfully!';
					}
					$this->session->set_flashdata('disp_msg', $disp_msg);
					redirect(current_url());
				}
					
			}
			//exit;
			if($selid > 0) {
			$events =  $this->commonclass->retrive_records('events', ' * ', "(eventId = ".$selid.")"); # user roles Table
			$eventslist = (!empty($events[0])) ? $events[0] : array();
			} else {
			$eventslist = array();
			}
		
		$data['results'] = $query;
		$data['eventslist'] = $eventslist;
		$data['disp_msg'] = $disp_msg;
		$data['universityquery'] = $universityquery;
		$data['selid'] = $selid;
		
		
		$this->load->view('layouts/adminheader',$data_header);
		$this->load->view('admin/events',$data);
		$this->load->view('layouts/adminfooter');
	}
	public function eventdelete($id_record = ''){		
	 
	 	$disp_msg = $this->session->flashdata('disp_msg');		
		$shared_doc_students =  $this->commonclass->retrive_records('events', '*', "(eventId='".$id_record."')",array(),''); #Employee Table
		
		
		$where = "(eventId =".$id_record.")";
		$doc_rec = $this->commonclass->retrive_records("events", " * ", $where, array(), 1);			
		$uploads_dir = 'uploads';
		//$foldername = $this->sessiondata['username'];
		
				$uploads_dir = 'uploads';
				$foldername = 'Events';
				$subfoldername = $doc_rec[0]['univId'];
				$uploadpath1 = $uploads_dir.'/'.$foldername.'/'.$subfoldername; //echo"<br/>";
				
							
		$name = !empty($doc_rec[0]['ImgRndName'])?$doc_rec[0]['ImgRndName']:'';	
		 $uploadpath = $uploadpath1.'/'.$name;		 //echo"<br/>";	
		$file_path_new = FCPATH.$uploadpath;						
		unlink($file_path_new); 
	$this->db->query("DELETE FROM events WHERE eventId = '".$id_record."'");	
		 
	}
	
	public function admissionstatus(){	 
	
	 $id = !empty($_POST['id']) ? $_POST['id']:'';
	 $newstatus = !empty($_POST['newstatus']) ? $_POST['newstatus']:'';	 
	  	 ## update data from post
		$updatedata =  array(
		'status' => $newstatus
		);
		$this->commonclass->update_record('admissions', $updatedata, "admitId", $id);
		$disp_msg = "Status changed Successfully!"; 
		$this->session->set_flashdata('disp_msg', $disp_msg);
		 
		## update record & insert activity on success end
			
			exit;
	}
	

	public function admission($selid  = ''){
		
		$disp_msg = $this->session->flashdata('disp_msg');		
		##Login User details		
		$query = $this->commonclass->retrive_records('admissions','*');
		$universityquery = $this->commonclass->retrive_records('university','*');
		//univId	admitStrtDt	status	createdDt	updtDt

		$approvalfileType = "";
		if (!empty($_POST['submit']) && $_POST['submit'] == "Save") {
			if($selid == 0) {					
				$formdata = array(							
					'admitStrtDt' => $_POST['admitStrtDt'],
					'branchname' => $_POST['branchname'],
					'status' => $status ,					
					'univId' => $_POST['university'],
					'status' => $_POST['status'],
					'createdDt' => !empty($_POST['createdDt']) ?  $_POST['createdDt'] : ''
				);
				
				if($this->commonclass->insert_record("admissions", $formdata)) {				
						$disp_msg = 'Administion saved successfully!';
						$this->session->set_flashdata('disp_msg', $disp_msg);						
									redirect(current_url());		
					}
				}else if ($selid > 0) {				
					$formdata = array(
						'admitStrtDt' => $_POST['admitStrtDt'],
						'branchname' => $_POST['branchname'],
						'status' => $status ,					
						'univId' => $_POST['university'],
						'status' => $_POST['status'],
						'updtDt' => !empty($_POST['updtDt']) ?  $_POST['updtDt'] :''
						);
					
					if($this->commonclass->update_record("admissions", $formdata, "admitId", $selid)) { # update record success					
					$disp_msg = 'Administion Updated Successfully!';
					}
					$this->session->set_flashdata('disp_msg', $disp_msg);
					redirect(current_url());
				}
					
			}
			//exit;
			if($selid > 0) {
			$admissions =  $this->commonclass->retrive_records('admissions', ' * ', "(admitId = ".$selid.")"); # user roles Table
			$admissionsslist = (!empty($admissions[0])) ? $admissions[0] : array();
			} else {
			$admissionsslist = array();
			}
		
		$data['results'] = $query;
		$data['admissionsslist'] = $admissionsslist;
		$data['disp_msg'] = $disp_msg;
		$data['universityquery'] = $universityquery;
		$data['selid'] = $selid;
		
		
		$this->load->view('layouts/adminheader',$data_header);
		$this->load->view('admin/admissions',$data);
		$this->load->view('layouts/adminfooter');
	}
  
  public function advertisement($selid  = ''){
		
		$disp_msg = $this->session->flashdata('disp_msg');		
		##Login User details		
		$query = $this->commonclass->retrive_records('advertisement','*');
		$universityquery = $this->commonclass->retrive_records('university','*');
		//echo"<pre>"; print_R($_POST); echo"</pre>";	
		//echo"<pre>"; print_R($_FILES); echo"</pre>";
    //die();
		$approval_inputFileName = "";
		$approvalName = "";
		$tmpName = "";
		$fileSize = "";
		$approvalfileType = "";
		if (!empty($_POST['submit']) && $_POST['submit'] == "Save") {
			if($selid == 0) {	
				$uploads_dir = 'uploads';
				$foldername = 'Advertisement';
				$subfoldername = $_POST['university'];
				$uploadpath = './'.$uploads_dir.'/'.$foldername.'/'.$subfoldername.'/';
				/* attachment uploads directory path start */
				
				$approvalName = $_FILES['fileToUpload']['name']; ## file actual name
				$tmpName  = $_FILES['fileToUpload']['tmp_name']; ## temp directory name
				$fileSize = $_FILES['fileToUpload']['size']; ## file size
				$approvalfileType = $_FILES['fileToUpload']['type']; ## file type
				
				/* file uploading starts here */
				if (!file_exists($uploadpath)) {
					mkdir($uploadpath, 0777, TRUE);
				}
				## attachment random name => i-140_userid_currenttimestamp
				$approval_randname = $subfoldername."_".date('Y-m-dH-i-s');		
				## renaming actual file with random name
				$config['file_name'] = $approval_randname;	
				## upload path			
         		$config['upload_path'] = $uploadpath;
				## allowed file types
				$config['allowed_types'] = 'png|jpe|jpeg|jpg|gif|bmp';
				## uploads library
				$this->load->library('upload', $config);
				## uploading file.csv
				//echo"<pre>"; print_R($config); echo"</pre>";	 die();
				/*if (!$this->upload->do_upload('fileToUpload'))
				{ ## file not moved show error and redirecting to current page				
					$status = 'error';
					$disp_msg = $this->upload->display_errors('', '');	
					$this->session->set_flashdata('disp_msg', $disp_msg);
					redirect(current_url(), 'refresh');	 # redirect to samepage		
				} else { */					
					## retreiving uploaded data to save in database 
					$data123 = $this->upload->data();
					$approval_inputFileName = basename($data123['full_path']);
					
				
				/*}*/
			
			//advId	unvId	advName	advDesc	advImgs	ImgType	ImgRndName	ImgSize	status	createdDt	updtDt

				
				$formdata = array(
								'advName' => $_POST['advName'],
								'advDesc' => $_POST['advtDesc'],
								'createdDt' => $_POST['createdDt'],
								'advImgs' => $approvalName ,
								'ImgRndName' => $approval_inputFileName,
								'ImgType' => $approvalfileType,
								'status' =>  $_POST['status'],
								'unvId' => $_POST['university'],
								
				);
				
				if($this->commonclass->insert_record("advertisement", $formdata)) {				
						$disp_msg = 'Advertisement saved successfully!';
						$this->session->set_flashdata('disp_msg', $disp_msg);						
									redirect(current_url());		
					}
				}else if ($selid > 0) {				
					$formdata = array(
								/* 'univId' => $_POST['university'],
								'eventName' => $_POST['eventname'],
								'eventDesc' => $_POST['eventDesc'],
								'eventStrtDt' => $_POST['eventStrtDt'],
								'eventImgs' => $approvalName ,
								'ImgRndName' => $approval_inputFileName,
								'ImgType' => $approvalfileType,
								'eventEndDt' => $_POST['eventEndDt'], */
								'advName' => $_POST['advName'],
								'advDesc' => $_POST['advtDesc'],
								'createdDt' => $_POST['createdDt'],						
								'status' =>  $_POST['status'],
								'updtDt' => date('Y-m-d'),
							);
					
					if($this->commonclass->update_record("advertisement", $formdata, "advId", $selid)) { # update record success					
					$disp_msg = 'Advertisement Updated Successfully!';
					}
					$this->session->set_flashdata('disp_msg', $disp_msg);
					redirect(current_url());
				}
					
			}
			//exit;
			if($selid > 0) {
			$advertisements =  $this->commonclass->retrive_records('advertisement', ' * ', "(advId = ".$selid.")"); # user roles Table
			$advertisementlist = (!empty($advertisements[0])) ? $advertisements[0] : array();
			} else {
			$advertisementlist = array();
			}
		
		$data['results'] = $query;
		$data['advertisementlist'] = $advertisementlist;
		$data['disp_msg'] = $disp_msg;
		$data['universityquery'] = $universityquery;
		$data['selid'] = $selid;
		
		
		$this->load->view('layouts/adminheader',$data_header);
		$this->load->view('admin/advertisement',$data);
		$this->load->view('layouts/adminfooter');
	}
	
	
	public function newscategory($selid  = ''){
		
		$disp_msg = $this->session->flashdata('disp_msg');		
		##Login User details		
		$query = $this->commonclass->retrive_records('newsfeed_category','*');
		$subquery = $this->commonclass->retrive_records('newsfeed_category','*', "(subcategoryid = 0)"); 
		
	    	//echo"<pre>"; print_R($_POST); echo"</pre>";	
		//echo"<pre>"; print_R($_FILES); echo"</pre>";	die();
	
		if (!empty($_POST['submit']) && $_POST['submit'] == "Save") {
			if($selid == 0) {
			   
				$formdata = array(
								'category' => $_POST['category'],
								'status' => $_POST['status'],
								'subcategoryid' => $_POST['subcategoryid'],
								
				);
				
				if($this->commonclass->insert_record("newsfeed_category", $formdata)) {				
						$disp_msg = 'Category saved successfully!';
						$this->session->set_flashdata('disp_msg', $disp_msg);						
									redirect(current_url());		
					}
				}else if ($selid > 0) {				
					$formdata = array(
								'category' => $_POST['category'],
								'status' => $_POST['status'],
								'subcategoryid' => $_POST['subcategoryid'],
							);
					
					if($this->commonclass->update_record("newsfeed_category", $formdata, "id", $selid)) { # update record success					
					$disp_msg = 'Category Updated Successfully!';
					}
					$this->session->set_flashdata('disp_msg', $disp_msg);
					redirect(current_url());
				}
					
			}
			//exit;
			if($selid > 0) {
			$newsfeed_category =  $this->commonclass->retrive_records('newsfeed_category', ' * ', "(id = ".$selid.")"); # user roles Table
			$newsfeedcategorylist = (!empty($newsfeed_category[0])) ? $newsfeed_category[0] : array();
			} else {
			$newsfeedcategorylist = array();
			}
		
		$data['results'] = $query;
		$data['subresults'] = $subquery;
		$data['newsfeedcategorylist'] = $newsfeedcategorylist;
		$data['disp_msg'] = $disp_msg;
		$data['selid'] = $selid;
		
		
		$this->load->view('layouts/adminheader',$data_header);
		$this->load->view('admin/masternewcategories',$data);
		$this->load->view('layouts/adminfooter');
	}
	
	
    public function newsfeed($sel_id = ''){
    
		$newsfeed = $this->commonclass->retrive_records('newsfeed','*');
		
		if(!empty($sel_id)){
			$singlenewsfeed = $this->commonclass->retrive_records('newsfeed','*','(nfId = '.$sel_id.')');
		}else{
			$singlenewsfeed = '';
		}
		  
		  
		$data_header['siteconfig'] = $this->siteconfig;
		$data['siteconfig'] = $this->siteconfig;
		$data['newsfeed'] = $newsfeed;
		$data['singlenewsfeed'] = $singlenewsfeed;
		$data['sel_id'] = $sel_id;
    
		$this->load->view('layouts/adminheader',$data_header);
		$this->load->view('admin/newsfeed',$data);
		$this->load->view('layouts/adminfooter');
   }
   
   public function addnewsfeed($sel_id = ''){

		$newsfeed = $this->commonclass->retrive_records('newsfeed','*');
		$newsfeedcategory = $this->commonclass->retrive_records('newsfeed_category','*','(subcategoryid = 0)');	
	
	
		if (!empty($_POST['submit']) && $_POST['submit'] == "Save") {			
			if($sel_id > 0) {						
				$formdata = array(								
					'catid' => $_POST['categoryid'],
					'subcatid' => !empty($_POST['subcategoryid']) ? $_POST['subcategoryid']: '',
					'name' => $_POST['name'],
					'description' => $_POST['description'],
					'startdate' => $_POST['startdate'],
					'status' => 'Active',
					'updtDt' => date('Y-m-d H:m:s')
				);
			if($this->commonclass->update_record("newsfeed", $formdata, "nfId", $sel_id)) { # update record success
			$disp_msg = 'News updated successfully';
			}
		
			}else{
					$formdata = array(								
					'catid' => $_POST['categoryid'],
					'subcatid' => !empty($_POST['subcategoryid']) ? $_POST['subcategoryid']: '',
					'name' => $_POST['name'],
					'description' => $_POST['description'],
					'startdate' => $_POST['startdate'],
					'status' => 'Active',							
					'createdDt' => date('Y-m-d H:m:s')
					);
					if($this->commonclass->insert_record("newsfeed", $formdata)) {
						$disp_msg = 'News Added successfully';	
					} 					
				}				
			$this->session->set_flashdata('disp_msg', $disp_msg);
			redirect('/admin/newsfeed');	 
			
			}
		  
		  if(!empty($sel_id)){
			$singlenewsfeed1 = $this->commonclass->retrive_records('newsfeed','*','(nfId = '.$sel_id.')');
			$singlenewsfeed = !empty($singlenewsfeed1[0]) ? $singlenewsfeed1[0]: '';
		}else{
			$singlenewsfeed = '';
		}
		
		//echo"<pre>"; print_R($singlenewsfeed); echo"</pre>";
		
		$data_header['siteconfig'] = $this->siteconfig;
		$data['siteconfig'] = $this->siteconfig;
		//$data['newsfeed'] = $newsfeed;
		$data['singlenewsfeed'] = $singlenewsfeed;
		$data['sel_id'] = $sel_id;
		$data['newsfeedcategory'] = $newsfeedcategory	;
    
		$this->load->view('layouts/adminheader',$data_header);
		$this->load->view('admin/addnewsfeed',$data);
		$this->load->view('layouts/adminfooter');
   }
   
   public function subcatid(){
	   //echo"<pre>"; print_R($_POST['cat_id']); echo"</pre>";
	     $newsfeedcategory = $this->commonclass->retrive_records('newsfeed_category','*','(subcategoryid = '.$_POST['cat_id'].')');	 
	  //echo"<pre>"; print_R(count($newsfeedcategory)); echo"</pre>";
	   $output = ''; 
	  if(count($newsfeedcategory)>0){		  
		$output .= '<label> Sub Category </label>'; 
		$output .= "<select name='subcategoryid' class='form-control'> ";
		foreach($newsfeedcategory as $single){
			$output .= "<option value='".$single['id']."'>". $single['category']."</option>";  
		}
		$output .= "</select>";
		 echo $output;
	  }
   }
   
   public function newschangestatus($id, $newstatus){
	   ## update data from post
		$updatedata =  array(
							'status' => 'Active', ##new status
									);
		$this->commonclass->update_record('newsfeed', $updatedata, "nfId", $id);
		$disp_msg = "News status changed Successfully!"; 
		$this->session->set_flashdata('disp_msg', $disp_msg);
		
		## update record & insert activity on success end
			
			exit;
   }
	
	
	public function jobs($selid  = ''){
		
		$disp_msg = $this->session->flashdata('disp_msg');		
		##Login User details		
		$query = $this->commonclass->retrive_records('jobs','*');
		
		if (!empty($_POST['submit']) && $_POST['submit'] == "Save") {
			if($selid == 0) {					
				$formdata = array(
				'title' => $_POST['title'],
				'location' => $_POST['location'],
				'details' => $_POST['details'],
				'enddate' => $_POST['enddate'],
				'startdate' => $_POST['startdate'],
				'status' => 1,								
				);				
				if($this->commonclass->insert_record("jobs", $formdata)) {				
					$disp_msg = 'Job Added saved successfully!';
					$this->session->set_flashdata('disp_msg', $disp_msg);						
					redirect(current_url());		
				}
			}else if ($selid > 0) {				
				$formdata = array(
				'title' => $_POST['title'],
				'location' => $_POST['location'],
				'details' => $_POST['details'],
				'enddate' => $_POST['enddate'],
				'startdate' => $_POST['startdate'],				
				);
				if($this->commonclass->update_record("jobs", $formdata, "id", $selid)) { # update record success					
					$disp_msg = 'Job Updated Successfully!';
				}
				$this->session->set_flashdata('disp_msg', $disp_msg);
				redirect(current_url());
				}					
			}
			//exit;
			if($selid > 0) {
			$jobs =  $this->commonclass->retrive_records('jobs', ' * ', "(id = ".$selid.")"); # user roles Table
			$jobslist = (!empty($jobs[0])) ? $jobs[0] : array();
			} else {
			$jobslist = array();
			}
		
		$data['results'] = $query;
		$data['jobslist'] = $jobslist;
		$data['disp_msg'] = $disp_msg;
		$data['selid'] = $selid;
		
		
		$this->load->view('layouts/adminheader',$data_header);
		$this->load->view('admin/jobs',$data);
		$this->load->view('layouts/adminfooter');
	}
	
	 public function jobsstatus($id, $newstatus){
	   ## update data from post
		$updatedata =  array(
							'status' => $newstatus, ##new status
									);
		$this->commonclass->update_record('jobs', $updatedata, "id", $id);
		$disp_msg = "status changed Successfully!"; 
		$this->session->set_flashdata('disp_msg', $disp_msg);
		
		## update record & insert activity on success end
			
			exit;
   }
   
   	
	 public function Activestatus($id, $newstatus){
	   ## update data from post
		$updatedata =  array(
							'isactive' => $newstatus, ##new status
									);
		$this->commonclass->update_record('students', $updatedata, "id", $id);
		$disp_msg = "status changed Successfully!"; 
		$this->session->set_flashdata('disp_msg', $disp_msg);
		
		## update record & insert activity on success end
			
			exit;
   }
   
    public function InActivestatus($id, $newstatus){
	   ## update data from post
		$updatedata =  array(
							'isactive' => $newstatus, ##new status
									);
		$this->commonclass->update_record('students', $updatedata, "id", $id);
		$disp_msg = "status changed Successfully!"; 
		$this->session->set_flashdata('disp_msg', $disp_msg);
		
		## update record & insert activity on success end
			
			exit;
   }
   
   
   public function universitypost(){
		
		$admissiontempResults = $this->commonclass->retrive_records('admissiontemp','*', '(status = 2)');
		$advertisemenresults = $this->commonclass->retrive_records('advertisementemp','*', '(status = 2)');
		$universityregister = $this->commonclass->retrive_records('universityregister','*', '');
		
		$data['disp_msg'] = $disp_msg;
		$data['selid'] = $selid;	
		$data['admissiontempResults'] = $admissiontempResults;	
		$data['advertisemenresults'] = $advertisemenresults;	
		$data['universityregister'] = $universityregister;	
		$this->load->view('layouts/adminheader',$data_header);
		$this->load->view('admin/universitypost',$data);
		$this->load->view('layouts/adminfooter');	 
   } 

   public function universitypostchangestatus(){
		
	 $id = !empty($_POST['id']) ? $_POST['id']:'';
	 $newstatus = !empty($_POST['newstatus']) ? $_POST['newstatus']:'';	 
	  	 ## update data from post
		$updatedata =  array(
		'status' => $newstatus
		);
		$this->commonclass->update_record('admissiontemp', $updatedata, "id", $id);
		$disp_msg = "Status changed Successfully!"; 
		$this->session->set_flashdata('disp_msg', $disp_msg);
		 
		## update record & insert activity on success end
			
			exit;
   }
     public function advertisementstatus(){
		
	 $id = !empty($_POST['id']) ? $_POST['id']:'';
	 $newstatus = !empty($_POST['newstatus']) ? $_POST['newstatus']:'';	 
	  	 ## update data from post
		$updatedata =  array(
		'status' => $newstatus
		);
		$this->commonclass->update_record('advertisementemp', $updatedata, "id", $id);
		$disp_msg = "Status changed Successfully!"; 
		$this->session->set_flashdata('disp_msg', $disp_msg);
		 
		## update record & insert activity on success end
			
			exit;
   }
   
	public function scholarships($selid  = ''){
		
		$disp_msg = $this->session->flashdata('disp_msg');		
		##Login User details		
		//$query = $this->commonclass->retrive_records('scholarship','*',"(status !=2"));
		$query = $this->commonclass->retrive_records('scholarship','*','( status != 2)');
		
		$universityquery = $this->commonclass->retrive_records('university','*');
		//univId	admitStrtDt	status	createdDt	updtDt

		$approvalfileType = "";
		if (!empty($_POST['submit']) && $_POST['submit'] == "Save") {
			if($selid == 0) {					
				$formdata = array(							
					'admitStrtDt' => $_POST['admitStrtDt'],
					'branchname' => $_POST['branchname'],
					'status' => $status ,					
					'univId' => $_POST['university'],
					'status' => $_POST['status'],
					'createdDt' => !empty($_POST['createdDt']) ?  $_POST['createdDt'] : ''
				);
				
				if($this->commonclass->insert_record("scholarship", $formdata)) {				
						$disp_msg = 'Scholarship saved successfully!';
						$this->session->set_flashdata('disp_msg', $disp_msg);						
									redirect(current_url());		
					}
				}else if ($selid > 0) {				
					$formdata = array(
						'admitStrtDt' => $_POST['admitStrtDt'],
						'branchname' => $_POST['branchname'],
						'status' => $status ,					
						'univId' => $_POST['university'],
						'status' => $_POST['status'],
						'updtDt' => !empty($_POST['updtDt']) ?  $_POST['updtDt'] :''
						);
					
					if($this->commonclass->update_record("scholarship", $formdata, "admitId", $selid)) { # update record success					
					$disp_msg = 'Scholarship Updated Successfully!';
					}
					$this->session->set_flashdata('disp_msg', $disp_msg);
					redirect(current_url());
				}
					
			}
			//exit;
			if($selid > 0) {
			$admissions =  $this->commonclass->retrive_records('scholarship', ' * ', "(admitId = ".$selid.")"); # user roles Table
			$admissionsslist = (!empty($admissions[0])) ? $admissions[0] : array();
			} else {
			$admissionsslist = array();
			}
		
		$data['results'] = $query;
		$data['admissionsslist'] = $admissionsslist;
		$data['disp_msg'] = $disp_msg;
		$data['universityquery'] = $universityquery;
		$data['selid'] = $selid;
		
		
		$this->load->view('layouts/adminheader',$data_header);
		$this->load->view('admin/scholarship',$data);
		$this->load->view('layouts/adminfooter');
	}
	
	public function scholarshipstatus(){	 
	
	 $id = !empty($_POST['id']) ? $_POST['id']:'';
	 $newstatus = !empty($_POST['newstatus']) ? $_POST['newstatus']:'';	 
	  	 ## update data from post
		$updatedata =  array(
		'status' => $newstatus
		);
		$this->commonclass->update_record('scholarship', $updatedata, "admitId", $id);
		$disp_msg = "Status changed Successfully!"; 
		$this->session->set_flashdata('disp_msg', $disp_msg);
		 
		## update record & insert activity on success end
			
			exit;
	}
	
  
}
