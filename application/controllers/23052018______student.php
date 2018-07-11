<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student extends CI_Controller {

	/**
	 * controller for students.
	 *
	*/
   	public function __construct()
	{
		parent::__construct();
			$this->load->database();
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
      			 redirect('/login/index');
      		}
	}
	public function index()
	{
	if(!empty($_POST)){
		// Insert only post text into table when images are selected
		if(!empty($_POST['post']) && empty($_FILES['multiple_images']['name'][0])) {
			$data = array(
		        'post' =>  $this->input->post('post', TRUE),
		        'studentid' => $this->sessiondata['userid'] ,
		        'liked_ids' => '',
		        'filename' => '',
		        'randname' => '',
		        'filetype' => '',
		        'adddate' =>  date('Y-m-d H:i:s')
			);
		$this->db->insert('studentspost_docs', $data);
		redirect(current_url());
		}

		$approval_inputFileName = "";
		$approvalName = "";
		$tmpName = "";
		$fileSize = "";
		$approvalfileType = "";

		if (!empty($_FILES)) {
			$this->load->library('upload');
				$uploads_dir = 'uploads';
				$foldername = $this->sessiondata['username'];
				$uploadpath = './'.$uploads_dir.'/'.$foldername.'/';
				/* attachment uploads directory path start */
			    $number_of_files_uploaded = count($_FILES['multiple_images']['name']);
    		// Faking upload calls to $_FILE
		    for ($i = 0; $i < $number_of_files_uploaded; $i++) {
			    $_FILES['file']['name']     = $_FILES['multiple_images']['name'][$i];
			    $_FILES['file']['type']     = $_FILES['multiple_images']['type'][$i];
			    $_FILES['file']['tmp_name'] = $_FILES['multiple_images']['tmp_name'][$i];
			    $_FILES['file']['error']    = $_FILES['multiple_images']['error'][$i];
			    $_FILES['file']['size']     = $_FILES['multiple_images']['size'][$i];

				$approvalName[] = $_FILES['file']['name']; ## file actual name

				$tmpName  = $_FILES['file']['tmp_name']; ## temp directory name

				$fileSize = $_FILES['file']['size']; ## file size
				$approvalfileType[] = $_FILES['file']['type']; ## file type

				/* file uploading starts here */
				if (!file_exists($uploadpath)) {
					mkdir($uploadpath, 0777, TRUE);
				}
				## attachment random name => i-140_userid_currenttimestamp
				$approval_randname = $this->sessiondata['username']."_".date('Y-m-dH-i-s');
				## renaming actual file with random name
				$config['file_name'] = $approval_randname;
				## upload path
         		$config['upload_path'] = $uploadpath;
				## allowed file types
				//$config['allowed_types'] = 'xls|xlsx|.xls|.xlsx|pdf|msword|png|jpe|jpeg|jpg|gif|bmp|doc|docx|zip|.csv|csv|txt|.txt ';
				$config['allowed_types'] = 'png|jpe|jpeg|jpg|gif|bmp';
				## uploads library
				$this->upload->initialize($config);
				## uploading file.csv

				if (!$this->upload->do_upload('file'))
				{ ## file not moved show error and redirecting to current page
					$status = 'error';
					$disp_msg = $this->upload->display_errors('', '');
					$this->session->set_flashdata('disp_msg', $disp_msg);
					redirect(current_url(), 'refresh');	 # redirect to samepage
				} else {
					## retreiving uploaded data to save in database
					$data123 = $this->upload->data();
					$approval_inputFileName[] = basename($data123['full_path']);
				}
			}
				$disp_msg = "Files Uploaded Successfully!";

				/* file uploading ends here */
		}
		$data = array(
		        'post' =>  $this->input->post('post', TRUE),
		        'studentid' => $this->sessiondata['userid'] ,
		        'liked_ids' => '',
		        'filename' => implode(",",$approvalName),
		        'randname' => implode(",",$approval_inputFileName),
		        'filetype' => implode(",",$approvalfileType),
		        'adddate' =>  date('Y-m-d H:i:s')
			);
		// Insert post text along with multiple images
		$this->db->insert('studentspost_docs', $data);
	    redirect(current_url());
	}
	// $studentdocs = $this->commonclass->retrive_records('student_docs','*', '(studentid='.$this->sessiondata['userid'].' and status =1)');
	// $getAllFriendsIds = "SELECT requeterid FROM friends_request WHERE senderid =".$this->sessiondata['userid'];
	//query to get all the posts and related data
	/*echo $this->sessiondata['userid']; exit;
	,
					(select universityname from university uni  where uni.id = ".$this->sessiondata['userid'].") AS universityname */
	$get_all_posts = "SELECT std.*,
					(select firstname from students sd  where sd.id = std.studentid) AS firstname,
					(select lastname from students sd  where sd.id = std.studentid) AS lastname,
					(select username from students sd  where sd.id = std.studentid) AS username,
					(select COUNT(*) from post_comments as pc where pc.post_id = std.id) as comment_count,
					(select universityname from university uni  where uni.id = (select id_university from students sd where sd.id = std.studentid)) AS universityname
					FROM studentspost_docs std WHERE std.studentid IN
(select id from students sd  where sd.id IN (select fr.requeterid from friends_request fr WHERE status = 1 AND fr.senderid  = ".$this->sessiondata['userid']." )  OR id=".$this->sessiondata['userid'].") ORDER BY std.id DESC ";
//, (select GROUP_CONCAT(pc.comment) AS comment from post_comments as pc where pc.post_id = std.id ORDER BY pc.created_at ) as comment, (select GROUP_CONCAT(sd.username) from students as sd where sd.id IN (select pc.user_id from post_comments as pc where pc.post_id = std.id ORDER BY pc.created_at)) as studentname

    $queryresult    = $this->commonclass->execute_rawquery($get_all_posts);
    $studentspostdocs = $queryresult->result_array();
   // echo "<pre>"; var_dump($studentspostdocs); exit();
	$where = "(id = '".$this->sessiondata['userid']."')";
	$Search_university_results = $this->commonclass->retrive_records('students','*',$where);
	$id_university = $Search_university_results[0]['id_university'] ? $Search_university_results[0]['id_university']:'';

	$eventcount = $this->commonclass->retrive_records('events','count(*) as eventcount','(univId = '.$id_university.')');

	##Count Code start here
	$accfriends = $this->commonclass->retrive_records('friends_request','count(*) as acpfrinds','(status = 1 and senderid = '.$this->sessiondata['userid'].')',array());
	$pendingfriends = $this->commonclass->retrive_records('friends_request','count(*) as pending','(status = 2 and senderid = '.$this->sessiondata['userid'].')',array());
	## Count
	$docwhere = "(stu_id = '".$this->sessiondata['userid']."')";
    $shareddocscount = $this->commonclass->retrive_records('shared_doc_students','count(*) as shareddocscount',$docwhere);

	$countnewsfeed = $this->commonclass->retrive_records('newsfeed','count(*) as countnewsfeed','(status = "Active")');
	$countdetails  = array();
	$countdetails['accfriends'] = $accfriends[0]['acpfrinds'];
	$countdetails['pendingfriends'] = $pendingfriends[0]['pending'];
	$countdetails['shareddocscount'] = $shareddocscount[0]['shareddocscount'];
	$countdetails['eventcount'] = $eventcount[0]['eventcount'];
	$countdetails['countnewsfeed'] = $countnewsfeed[0]['countnewsfeed'];

    $eventdetails = $this->commonclass->retrive_records('events','*','',array(),5);
    $jobs = $this->commonclass->retrive_records('jobs','*','(status=1)',array(),5);

    $Search_university_results = '';
    if(!empty($_POST)){
      if($_POST['submit'] == 'Go'){
        $Search_university  = !empty($_POST['country']) ? $_POST['country']: '';
        $where = "(id_university = '".$Search_university."' AND id != '".$this->sessiondata['userid']."' )";
        $Search_university_results = $this->commonclass->retrive_records('students','*',$where);

      }else{
        $disp_msg = "No Records Found";
      }
    }

    $friends_requests =$this->commonclass->retrive_records('friends_request','*',"(requeterid = ".$this->sessiondata['userid'].")");


    $data_header['siteconfig'] = $this->siteconfig;
    $data['siteconfig'] = $this->siteconfig;
    $data['loginid'] = $this->sessiondata['userid'];
    $data['friends_requests'] = $friends_requests;
    $data['Searchuniversityresults'] = $Search_university_results;
    $data['eventdetails'] = $eventdetails;
    $data['jobs'] = $jobs;
    $data['countdetails'] = $countdetails;
    $data['studentdocs'] = $studentdocs;
    //foreach ($studentspostdocs as $row)
	$data['studentspostdocs'] = $studentspostdocs ;
    $data['sessiondata'] = $this->sessiondata;

    $this->load->view('layouts/studentheader',$data_header);
    $this->load->view('student/dashboard',$data);
    $this->load->view('layouts/studenfooter');
	}

	public function myaccount(){

		$disp_msg = $this->session->flashdata('disp_msg');
		##Login User details
		$where = "(id = '".$this->sessiondata['userid']."')";
		$query = $this->commonclass->retrive_records('students','*',$where);
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
								'stdid' => $_POST['stdid'],
								'subject' => $_POST['subject'],
								'study' => $_POST['study'],
								'dob' => $_POST['dob'],
							);

					if($this->commonclass->update_record("students", $formdata, "id", $seluserid)) { # update record success
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

					if($this->commonclass->update_record("students", $formdata, "id", $seluserid)) { # update record success
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
		 $data['loginid'] = $this->sessiondata['userid'];

		$this->load->view('layouts/studentheader',$data_header);
		$this->load->view('student/myaccount',$data);
		$this->load->view('layouts/studenfooter');
	}

		 /*
	 * Function to update profile picture for the selected employee
	 *
	 * return values : error / success
	 *
	 * JQUERY function
	 */

	public function profilepic_update($sel_user)
	{
		## profile pics upload directory
		$uploaddir = '../assets/profile_pics/';
		$config['upload_path'] = './assets/profile_pics/';

		## Image allowed types
		$config['allowed_types'] = 'jpg|jpeg|bmp|png|gif';

		## uploads library
		$this->load->library('upload', $config);

		## Upload file start
		if (!$this->upload->do_upload('uploadfile')) { ## error while uploading
			echo "error";
		} else {
			$upd_image = $this->upload->data();
			$file_name = basename($upd_image['full_path']);

			$updatedata =  array(
				'profilepic_name' => $file_name
			);

		if ( $this->commonclass->update_record("students", $updatedata, "id", $sel_user) ) {
			echo "success";

		} else {
			echo "error";
		}
		}
	}


   public function countryserach(){

		//echo"<pre>"; print_R($_POST); echo"</pre>"; die();
		if(!empty($_POST["country_id"])) {
      $keyword = !empty($_POST['country_id']) ? $_POST['country_id']:''	;
      $where_serach = "(country_id = ".$keyword.")";
      $masteruniversity = $this->commonclass->retrive_records('university','id,universityname',$where_serach,array("id" => "DESC"),'');
		}else{
			$masteruniversity = '';
		}
		$university = '';
		$res = array();
		$i = 0;

		    //Display states list
			if(count($masteruniversity) > 0){
			$university .='<option value="">Select university</option>';
			//fo($row = $query->fetch_assoc()){
			foreach ($masteruniversity as $row)  {
			$university .='<option value="'.$row['id'].'">'.$row['universityname'].'</option>';
			}
			}else{
			$university .= '<option value="">university not available</option>';
    }

	  echo $university;
	 }

   public function connections(){
     //echo"<pre>"; print_R($_POST); echo"</pre>";
    $Search_university_results = '';
    if(!empty($_POST)){
      if($_POST['submit'] == 'Go'){
        $Search_university  = !empty($_POST['university']) ? $_POST['university']: '';
        $where = "(id_university = '".$Search_university."' AND id != '".$this->sessiondata['userid']."')";
        $Search_university_results = $this->commonclass->retrive_records('students','*',$where);

      }else{
        $disp_msg = "No Records Found";
      }
    }

		$expensesquery  = 'SELECT *  FROM `country`  ORDER BY `country_name`  ASC';
		$queryresult    = $this->commonclass->execute_rawquery($expensesquery);
		$rowCount = $queryresult->result_array();

	// $rowCount = $this->commonclass->retrive_records('country','*');


    $friends_requests = $this->commonclass->retrive_records('friends_request','*',"(requeterid = ".$this->sessiondata['userid'].")");


   // echo"<pre>"; print_R($Search_university_results); echo"</pre>";
    $data_header['siteconfig'] = $this->siteconfig;
    $data['siteconfig'] = $this->siteconfig;
    $data['rowCount'] = $rowCount;
    $data['loginid'] = $this->sessiondata['userid'];
    $data['Searchuniversityresults'] = $Search_university_results;
    $data['friends_requests'] = $friends_requests;


		$this->load->view('layouts/studentheader',$data_header);
		$this->load->view('student/connections',$data);
		$this->load->view('layouts/studenfooter');
   }




 /**
	 * Change payment status function used to change payment status
	 *
	 * JQUERY function
	 */
   public function prestudentrequest($empid, $newstatus)
 	{
 		$this->session->set_flashdata('disp_msg', $disp_msg);

 		## comments from request
 		$comments = (!empty($_POST['comments'])) ? $_POST['comments'] : '';
 		$newstatus = (!empty($_POST['newstatus'])) ? $_POST['newstatus'] : '';
 		echo $pid = (!empty($_POST['seluser'])) ? $_POST['seluser'] : '';
 		echo $senderid = $this->sessiondata['userid'];

 		//SELECT *  FROM `friends_request` WHERE `senderid` LIKE '%2%' ORDER BY `requeterid`  DESC
 		$expensesquery  = 'SELECT *  FROM `friends_request` WHERE `senderid` LIKE "%'.$senderid.'%" ORDER BY `requeterid`  DESC';
 		$queryresult    = $this->commonclass->execute_rawquery($expensesquery);
 		$friends_requests = $queryresult->result_array();

 			if($friends_requests[0]['requeterid'] != $pid){
 				if (!empty($_POST)>0) {
 				/* update data array*/
 				$updatedata =  array(
 				'senderid' => $this->sessiondata['userid'], ##new status
 				'requeterid' => $pid, ##new status
 				'status' => $newstatus, ##new status
 				'credatedon' => date('Y-m-d H:i:s'), ##new status
 				);
 				## record updation, and on success insert activity start
 				$this->commonclass->insert_record('friends_request', $updatedata);
 				$updatedata2 =  array(
 				'senderid' => $pid, ##new status
 				'requeterid' => $this->sessiondata['userid'], ##new status
 				'status' => $newstatus, ##new status
 				'credatedon' => date('Y-m-d H:i:s'), ##new status
 				);
 				$this->commonclass->insert_record('friends_request', $updatedata2);
 				echo $disp_msg = "Friend Request send successfully!  ";
 				$this->session->set_flashdata('disp_msg', $disp_msg);
 				exit;
 				}
 			}else{
 				echo $disp_msg = "I am alreday Friend!";
 				$this->session->set_flashdata('disp_msg', $disp_msg);
 				exit;
 			}
 	}

	public function accept()
	{
		## comments from request
		$comments = (!empty($_POST['comments'])) ? $_POST['comments'] : '';
		$newstatus = (!empty($_POST['newstatus'])) ? $_POST['newstatus'] : '';
		 $pid = (!empty($_POST['seluser'])) ? $_POST['seluser'] : '';
		//echo"<pre>"; print_R($_POST); echo"</pre>";

		 	## if employee exists, process start
			if (!empty($_POST)>0) {
				/* update data array*/
				$updatedata =  array(
						'status' => $newstatus, ##new status
				);
				## record updation, and on success insert activity start
				if($this->commonclass->update_record('friends_request', $updatedata,'id',$pid)) { # update record success
					/* Inserting Activity starts here */

					## set flash data
					$disp_msg = "Status Changed Success fully!  ";
					$this->session->set_flashdata('disp_msg', $disp_msg);
				}
				## record updation, and on success insert activity end
			}
		 	## if employee exists, process end
	}
	public function reject($empid, $newstatus)
	{
		## comments from request
		//$comments = (!empty($_POST['comments'])) ? $_POST['comments'] : '';
			 $pid = (!empty($_POST['seluser'])) ? $_POST['seluser'] : '';
			$newstatus = (!empty($_POST['newstatus'])) ? $_POST['newstatus'] : '';


		//echo"<pre>"; print_R($_POST); echo"</pre>";
		 	## if employee exists, process start
			if (!empty($_POST)>0) {
				/* update data array*/
				$updatedata =  array(
						'status' => $newstatus, ##new status
				);
				## record updation, and on success insert activity start
				if($this->commonclass->update_record('friends_request', $updatedata,'id',$pid)) { # update record success
					/* Inserting Activity starts here */

					## set flash data
					$disp_msg = "Status Changed Success fully!  ";
					$this->session->set_flashdata('disp_msg', $disp_msg);
				}
				## record updation, and on success insert activity end
			}
		 	## if employee exists, process end
	}

    public function data(){

		$this->session->set_flashdata('disp_msg', $disp_msg);


		/* if($single['senderid'] != $loginid){
				$where = "(senderid = '".$this->sessiondata['userid']."'  AND status = 1 )";
		}else{
				$where = "(requeterid = '".$this->sessiondata['userid']."' AND status = 1 )";
		} */
		$where = "(status = 1 )";
        $Friends = $this->commonclass->retrive_records('friends_request','*',$where);

		$docwhere = "(stu_id = '".$this->sessiondata['userid']."')";
        $shareddocs = $this->commonclass->retrive_records('shared_doc_students','*',$docwhere);


		$approval_inputFileName = "";
		$approvalName = "";
		$tmpName = "";
		$fileSize = "";
		$approvalfileType = "";
		if (!empty($_FILES)) {
				$uploads_dir = 'uploads';
				$foldername = $this->sessiondata['username'];
				$uploadpath = './'.$uploads_dir.'/'.$foldername.'/';
				/* attachment uploads directory path start */

				$approvalName = $_FILES['file']['name']; ## file actual name
				$tmpName  = $_FILES['file']['tmp_name']; ## temp directory name
				$fileSize = $_FILES['file']['size']; ## file size
				$approvalfileType = $_FILES['file']['type']; ## file type

				/* file uploading starts here */
				if (!file_exists($uploadpath)) {
					mkdir($uploadpath, 0777, TRUE);
				}
				## attachment random name => i-140_userid_currenttimestamp
				$approval_randname = $this->sessiondata['username']."_".date('Y-m-dH-i-s');
				## renaming actual file with random name
				$config['file_name'] = $approval_randname;
				## upload path
         		$config['upload_path'] = $uploadpath;
				## allowed file types
				$config['allowed_types'] = 'xls|xlsx|.xls|.xlsx|pdf|msword|png|jpe|jpeg|jpg|gif|bmp|doc|docx|zip|.csv|csv|txt|.txt ';
				## uploads library
				$this->load->library('upload', $config);
				## uploading file.csv
				if (!$this->upload->do_upload('file'))
				{ ## file not moved show error and redirecting to current page
					$status = 'error';
					$disp_msg = $this->upload->display_errors('', '');
					$this->session->set_flashdata('disp_msg', $disp_msg);
					redirect(current_url(), 'refresh');	 # redirect to samepage
				} else {
					## retreiving uploaded data to save in database
					$data123 = $this->upload->data();
					$approval_inputFileName = basename($data123['full_path']);

				}
					$insertdata =  array(
					'studentid' => $this->sessiondata['userid'],
					'filename' => $approvalName ,
					'randname ' => $approval_inputFileName,
					'filetype' => $approvalfileType,
					'adddate' => date('Y-m-d') ,
					'addedby' => $this->sessiondata['userid'],
					);
					$this->commonclass->insert_record('student_docs', $insertdata);

					$disp_msg = "Files Uploaded Successfully!";
					redirect(current_url());
				/* file uploading ends here */
		}

		 $studentdocs = $this->commonclass->retrive_records('student_docs','*', '(studentid='.$this->sessiondata['userid'].')');


		//die();
		$data_header['siteconfig'] = $this->siteconfig;
		$data['siteconfig'] = $this->siteconfig;
		$data['disp_msg'] = $this->disp_msg;
		$data['studentdocs'] = $studentdocs;
		$data['Friends'] = $Friends;
		$data['shareddocs'] = $shareddocs;
		$data['sessiondata'] = $this->sessiondata;
		$data['loginid'] = $this->sessiondata['userid'];
		$this->load->view('layouts/studentheader',$data_header);
		$this->load->view('student/data',$data);
		$this->load->view('layouts/studenfooter');
   }

	public function friendsshareddoc()
  {
    $id              = !empty($_POST['id']) ? $_POST['id'] : '';
    $friendsid      = !empty($_POST['friendsid']) ? $_POST['friendsid'] : '';

    $activity_table  = "shared_doc_students";
    $insert_activity = array(
      'stu_id' => $friendsid,
      'login_id' => $this->sessiondata['userid'],
      'shared_id' => $id,
	  'satus' => 1,
		'addedon' => date('Y-m-d H:i:s'),

    );
    $insertid        = $this->commonclass->insert_record($activity_table, $insert_activity);
    return 1;
    exit;
  }


     public function events($sel_id = ''){

		$where = "(id = '".$this->sessiondata['userid']."')";
        $Search_university_results = $this->commonclass->retrive_records('students','*',$where);
		$id_university = $Search_university_results[0]['id_university'] ? $Search_university_results[0]['id_university']:'';

		$Events = $this->commonclass->retrive_records('events','*','(univId = '.$id_university.')');

		  if(!empty($sel_id)){

		$ViewEvents = $this->commonclass->retrive_records('events','*','(eventId = '.$sel_id.')');
		  }else{
			$ViewEvents = '';
		  }
		//echo"<pre>"; print_R($Events); echo"</pre>";
		$data_header['siteconfig'] = $this->siteconfig;
		$data['siteconfig'] = $this->siteconfig;
		$data['Events'] = $Events;
		$data['ViewEvents'] = $ViewEvents;
		$data['id_university'] = $id_university;
		$data['sel_id'] = $sel_id;
     $data['loginid'] = $this->sessiondata['userid'];
		$this->load->view('layouts/studentheader',$data_header);
		$this->load->view('student/events',$data);
		$this->load->view('layouts/studenfooter');
   }

    public function admission($sel_id=''){

		$where = "(id = '".$this->sessiondata['userid']."')";
        $Search_university_results = $this->commonclass->retrive_records('students','*',$where);
		 $id_university = $Search_university_results[0]['id_university'] ? $Search_university_results[0]['id_university']:'';
	//	die();
		$Admissions = $this->commonclass->retrive_records('admissions','*','(status != 2)'); //univId = '.$id_university.' and

		 if(!empty($sel_id)){

		$ViewAdms = $this->commonclass->retrive_records('admissions','*','(admitId = '.$sel_id.')');// AND univId = '.$id_university.'
		  }else{
			$ViewAdms = '';
		  }
  //  echo"<pre>"; print_R($Admissions); echo"</pre>";

		$data_header['siteconfig'] = $this->siteconfig;
		$data_header['ViewAdms'] = $ViewAdms;
		$data['siteconfig'] = $this->siteconfig;
		$data['Admissions'] = $Admissions;
		$data['sel_id'] = $sel_id;
		 $data['loginid'] = $this->sessiondata['userid'];
		$this->load->view('layouts/studentheader',$data_header);
		$this->load->view('student/admission',$data);
		$this->load->view('layouts/studenfooter');
   }

    public function advertisement($sel_id=''){

		$where = "(id = '".$this->sessiondata['userid']."')";
        $Search_university_results = $this->commonclass->retrive_records('students','*',$where);
		 $id_university = $Search_university_results[0]['id_university'] ? $Search_university_results[0]['id_university']:'';
	//	die();
		$advertisement = $this->commonclass->retrive_records('advertisement','*');//,'(unvId = '.$id_university.')'

		 if(!empty($sel_id)){

		$ViewAdms = $this->commonclass->retrive_records('advertisement','*','(advId = '.$sel_id.')');// AND unvId = '.$id_university.'
		  }else{
			$ViewAdms = '';
		  }
   //echo"<pre>"; print_R($ViewAdms); echo"</pre>";

		$data_header['siteconfig'] = $this->siteconfig;
		$data_header['ViewAdms'] = $ViewAdms;
		$data['siteconfig'] = $this->siteconfig;
		$data['advertisement'] = $advertisement;
		$data['sel_id'] = $sel_id;
		 $data['loginid'] = $this->sessiondata['userid'];
		$this->load->view('layouts/studentheader',$data_header);
		$this->load->view('student/advertisement',$data);
		$this->load->view('layouts/studenfooter');
   }



    public function scholarships($sel_id = ''){


	$where = "(id = '".$this->sessiondata['userid']."')";
        $Search_university_results = $this->commonclass->retrive_records('students','*',$where);
		 $id_university = $Search_university_results[0]['id_university'] ? $Search_university_results[0]['id_university']:'';
	//	die();
		$Admissions = $this->commonclass->retrive_records('scholarship','*','(status != 2)'); //univId = '.$id_university.' and

		 if(!empty($sel_id)){

		$ViewAdms = $this->commonclass->retrive_records('scholarship','*','(admitId = '.$sel_id.')'); // AND univId = '.$id_university.'
		  }else{
			$ViewAdms = '';
		  }

		$data_header['siteconfig'] = $this->siteconfig;
		$data_header['ViewAdms'] = $ViewAdms;
		$data['siteconfig'] = $this->siteconfig;
		$data['Admissions'] = $Admissions;
		$data['sel_id'] = $sel_id;
		 $data['loginid'] = $this->sessiondata['userid'];

		$this->load->view('layouts/studentheader',$data_header);
		$this->load->view('student/scholarships',$data);
		$this->load->view('layouts/studenfooter');
   }


    public function advment(){

    $data_header['siteconfig'] = $this->siteconfig;
		$data['siteconfig'] = $this->siteconfig;
		 $data['loginid'] = $this->sessiondata['userid'];

		$this->load->view('layouts/studentheader',$data_header);
		$this->load->view('student/advment',$data);
		$this->load->view('layouts/studenfooter');
   }

    public function jobs($sel_id = ''){



		$Jobs = $this->commonclass->retrive_records('jobs','*','(status = 1)');
		if(!empty($sel_id)){
			$ViewJobs = $this->commonclass->retrive_records('jobs','*','(id = '.$sel_id.')');
		 }else{
			$ViewJobs = '';
		  }
		//echo"<pre>"; print_R($Jobs); echo"</pre>";
		$data_header['siteconfig'] = $this->siteconfig;
		$data['siteconfig'] = $this->siteconfig;
		$data['Jobs'] = $Jobs;
		$data['ViewJobs'] = $ViewJobs;
		$data['sel_id'] = $sel_id;
		 $data['loginid'] = $this->sessiondata['userid'];

		$this->load->view('layouts/studentheader',$data_header);
		$this->load->view('student/jobs',$data);
		$this->load->view('layouts/studenfooter');
   }
	 public function setting(){

    //$data_header['siteconfig'] = $this->siteconfig;
	//	$data['siteconfig'] = $this->siteconfig;
		$disp_msg = $this->session->flashdata('disp_msg');
		##Login User details
		$where = "(id = '".$this->sessiondata['userid']."')";
		$query = $this->commonclass->retrive_records('students','*',$where);
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
								'stdid' => $_POST['stdid'],
								'subject' => $_POST['subject'],
								'study' => $_POST['study'],
								'dob' => $_POST['dob'],
							);

					if($this->commonclass->update_record("students", $formdata, "id", $seluserid)) { # update record success
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

					if($this->commonclass->update_record("students", $formdata, "id", $seluserid)) { # update record success
						$disp_msg = "Updated Password successfully";
						$this->session->set_flashdata('disp_msg', $disp_msg);
						redirect(current_url());	 # redirect to samepage
					}

				}
			}
		}


		 $friends_requests = $this->commonclass->retrive_records('friends_request','*',"(requeterid = ".$this->sessiondata['userid'].")");


		$data_header['siteconfig'] = $this->siteconfig;
		$data['siteconfig'] = $this->siteconfig;
		$data['mydata'] = $query[0];
		$data['disp_msg'] = $disp_msg;
		$data['friends_requests'] = $friends_requests;
		 $data['loginid'] = $this->sessiondata['userid'];

		$this->load->view('layouts/studentheader',$data_header);
		$this->load->view('student/myaccount',$data);
		$this->load->view('layouts/studenfooter');
   }

public function groups(){

		$data_header['siteconfig'] = $this->siteconfig;
		$data['siteconfig'] = $this->siteconfig;
		 $data['loginid'] = $this->sessiondata['userid'];

		$this->load->view('layouts/studentheader',$data_header);
		$this->load->view('student/groups',$data);
		$this->load->view('layouts/studenfooter');
}

public function notefications(){

    $data_header['siteconfig'] = $this->siteconfig;
		$data['siteconfig'] = $this->siteconfig;
		 $data['loginid'] = $this->sessiondata['userid'];

		$this->load->view('layouts/studentheader',$data_header);
		$this->load->view('student/notefications',$data);
		$this->load->view('layouts/studenfooter');
}

public function newsfeed($sel_id = ''){

		$newsfeed = $this->commonclass->retrive_records('newsfeed','*','(status = "Active")');
		//print_R($newsfeed);
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
		 $data['loginid'] = $this->sessiondata['userid'];

		$this->load->view('layouts/studentheader',$data_header);
		$this->load->view('student/newsfeed',$data);
		$this->load->view('layouts/studenfooter');
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
					'status' => 'Inactive',
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
			redirect('/student/newsfeed');

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
		$data['loginid'] = $this->sessiondata['userid'];
		$this->load->view('layouts/studentheader',$data_header);
		$this->load->view('student/addnewsfeed',$data);
		$this->load->view('layouts/studenfooter');
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

	// delete_data

	public function delete_data($id_record = ''){

	 	$disp_msg = $this->session->flashdata('disp_msg');
		$shared_doc_students =  $this->commonclass->retrive_records('shared_doc_students', '*', "(shared_id='".$id_record."')",array(),''); #Employee Table

		if(count($shared_doc_students)>0){
			foreach($shared_doc_students as $single){
				$id = !empty($single['id']) ? $single['id']:'';
				$formdata = array('satus' => 0);
				if($this->commonclass->update_record("shared_doc_students", $formdata, "id", $id)) { # update record success
					$disp_msg = 'News updated successfully';
				}
			}
		}
		$where = "(id =".$id_record.")";
		$doc_rec = $this->commonclass->retrive_records("student_docs", " * ", $where, array(), 1);
		$uploads_dir = 'uploads';
		$foldername = $this->sessiondata['username'];

		$name = !empty($doc_rec[0]['randname'])?$doc_rec[0]['randname']:'';
		$uploadpath = $foldername.'/'.$name;
		$file_path_new = FCPATH."uploads/".$uploadpath;
		unlink($file_path_new);

		$this->db->query("DELETE FROM student_docs WHERE id = '".$id_record."'");

	}
	public function account(){

	 $friends_requests = $this->commonclass->retrive_records('friends_request','*',"(requeterid = ".$this->sessiondata['userid'].")");

	$data_header['siteconfig'] = $this->siteconfig;
	$data['siteconfig'] = $this->siteconfig;
    $data['loginid'] = $this->sessiondata['userid'];
    $data['friends_requests'] = $friends_requests;

	$this->load->view('layouts/studentheader',$data_header);
	$this->load->view('student/studentaccount',$data);
	$this->load->view('layouts/studenfooter');

	}


   public function connections1(){
     //echo"<pre>"; print_R($_POST); echo"</pre>";
    $Search_university_results = '';
    if(!empty($_POST)){
      if($_POST['submit'] == 'Go'){
        $Search_university  = !empty($_POST['university']) ? $_POST['university']: '';
        $where = "(id_university = '".$Search_university."' AND id != '".$this->sessiondata['userid']."')";
        $Search_university_results = $this->commonclass->retrive_records('students','*',$where);

      }else{
        $disp_msg = "No Records Found";
      }
    }
		$expensesquery  = 'SELECT *  FROM `country`  ORDER BY `country_name`  ASC';
		$queryresult    = $this->commonclass->execute_rawquery($expensesquery);
		$rowCount = $queryresult->result_array();

	// $rowCount = $this->commonclass->retrive_records('country','*');

    $friends_requests = $this->commonclass->retrive_records('friends_request','*',"(requeterid = ".$this->sessiondata['userid'].")");

    $data_header['siteconfig'] = $this->siteconfig;
    $data['siteconfig'] = $this->siteconfig;
    $data['rowCount'] = $rowCount;
    $data['loginid'] = $this->sessiondata['userid'];
    $data['Searchuniversityresults'] = $Search_university_results;
    $data['friends_requests'] = $friends_requests;

		$this->load->view('layouts/studentheader',$data_header);
		$this->load->view('student/connections1',$data);
		$this->load->view('layouts/studenfooter');
   }

   	public function inactive($empid, $newstatus)
	{
		## comments from request
		//$comments = (!empty($_POST['comments'])) ? $_POST['comments'] : '';
			$pid = (!empty($_POST['seluser'])) ? $_POST['seluser'] : '';
			$newstatus = (!empty($_POST['newstatus'])) ? $_POST['newstatus'] : '';


		//echo"<pre>"; print_R($_POST); echo"</pre>";
		 	## if employee exists, process start
			if (!empty($_POST)>0) {
				/* update data array*/
				$updatedata =  array(
						'isactive' => $newstatus, ##new status
				);
				## record updation, and on success insert activity start
				if($this->commonclass->update_record('students', $updatedata,'id',$pid)) { # update record success
					/* Inserting Activity starts here */

					## set flash data
					//$disp_msg = "Status Changed Successfully!  ";
					//$this->session->set_flashdata('disp_msg', $disp_msg);

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
				## record updation, and on success insert activity end
			}
		 	## if employee exists, process end
	}

	/**
	* Ajax call for likes counter update/insert
	* Author : Ram
	*/
	public function likes_counter()
	{
		$post_id = ($this->input->post('selected_post_data_1', TRUE)) / MULTIPLIER;
		//$user_id = ($this->input->post('selected_post_data_2', TRUE)) / MULTIPLIER;
		$user_id = $this->sessiondata['userid'];

		$qry = $this->db->get_where('studentspost_docs', array('id' => $post_id));
		if($qry->num_rows() > 0){
			$qry = $qry->row();
			$liked_ids = $qry->liked_ids;
		} else {
			echo json_encode(array('status' => 'invalid', 'message'=> 'Invalid Response! Try reloading the page'));
			exit();
		}

		if(!empty($liked_ids)) {
			$liked_ids_arr = explode(",", $liked_ids);
			$pos = array_search($user_id, $liked_ids_arr);
			if($pos !== false)  {
				unset($liked_ids_arr[$pos]);
				$updatedata =  [ 'liked_ids' => implode(",", $liked_ids_arr) ];
				if($this->commonclass->update_record('studentspost_docs', $updatedata,'id',$post_id)) {
					$message = "success";
				} else { $message = "failed"; }
			} else {
				$liked_ids_arr[] = $user_id;
			 	$updatedata =  [ 'liked_ids' => implode(",", $liked_ids_arr), ];
					if($this->commonclass->update_record('studentspost_docs', $updatedata,'id',$post_id)) {
						$message = "success";
					} else { $message = "failed"; }
			 }
		} else {
			$updatedata =  [ 'liked_ids' => $user_id ];
				if($this->commonclass->update_record('studentspost_docs', $updatedata,'id',$post_id)) {
					$message = "success";
				} else {
					$message = "failed";
				}
		}
		$qry = $this->db->get_where('studentspost_docs', array('id' => $post_id));
		if($qry->num_rows() > 0){
			$qry = $qry->row();
			$liked_ids = $qry->liked_ids;
			if($liked_ids === "") { $liked_ids = 0; }
			else {
					$liked_ids = count(explode(",", $liked_ids));
				}
		}
		echo json_encode(array('status' => $message, 'count'=> $liked_ids));
	}// end of likes_counter


}//end of Student Controller
