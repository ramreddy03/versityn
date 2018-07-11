<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class University extends CI_Controller {

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
				redirect('login/universitylogin');
			}
	}


	 /*
	 * Function to update profile picture for the selected university
	 *
	 * return values : error / success
	 *
	 * JQUERY function
	 */

	public function university_update($sel_university)
	{
		## profile pics upload directory
		$uploaddir = '../assets/University_pics/';
		$config['upload_path'] = './assets/University_pics/';

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

		if ( $this->commonclass->update_record("universityregister", $updatedata, "id", $sel_university) ) {
			echo "success";

		} else {
			echo "error";
		}
		}
	}

	public function account(){


	$data_header['siteconfig'] = $this->siteconfig;
	$data['siteconfig'] = $this->siteconfig;
    $data['loginid'] = $this->sessiondata['userid'];

	$this->load->view('layouts/universityheader',$data_header);
	$this->load->view('university/universityaccount',$data);
	$this->load->view('layouts/universityfooter');

	}

	 public function setting(){

    //$data_header['siteconfig'] = $this->siteconfig;
	//	$data['siteconfig'] = $this->siteconfig;
		$disp_msg = $this->session->flashdata('disp_msg');
		##Login User details
		$where = "(id = '".$this->sessiondata['userid']."')";
		$query = $this->commonclass->retrive_records('universityregister','*',$where);
		// echo"<pre>"; print_R($_POST); echo"</pre>";
		//die();
		if(!empty($_POST)) {
			$seluserid = $this->sessiondata['userid'];
			if($_POST['Submit'] == "Save Profile") {
					$formdata = array(
								'universityid' => $_POST['universityid'],
								'countryid' => $_POST['countryid'],
								'username' => $_POST['username'],
								'email' => $_POST['email'],
								/* 'contact' => $_POST['contact'],
								'stdid' => $_POST['stdid'],
								'subject' => $_POST['subject'],
								'study' => $_POST['study'],
								'dob' => $_POST['dob'],		 */
							);

					if($this->commonclass->update_record("universityregister", $formdata, "id", $seluserid)) { # update record success
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

					if($this->commonclass->update_record("universityregister", $formdata, "id", $seluserid)) { # update record success
						$disp_msg = "Updated Password successfully";
						$this->session->set_flashdata('disp_msg', $disp_msg);
						redirect(current_url());	 # redirect to samepage
					}

				}
			}
		}

		  $where_serach = "(id = ". $query[0]['universityid'].")";
      $masteruniversity = $this->commonclass->retrive_records('university','*',$where_serach,array("id" => "DESC"),'');
	 // echo"<pre>"; print_R($masteruniversity); echo"</pre>";

		$data_header['siteconfig'] = $this->siteconfig;
		$data['siteconfig'] = $this->siteconfig;
		$data['mydata'] = $query[0];
		$data['disp_msg'] = $disp_msg;
		$data['masteruniversity'] = $masteruniversity[0];
		 $data['loginid'] = $this->sessiondata['userid'];

		$this->load->view('layouts/universityheader',$data_header);
		$this->load->view('university/myaccount',$data);
		$this->load->view('layouts/universityfooter');
   }
	public function index()
	{

	}

	public function dashbaord()
	{

	$id_university = $this->sessiondata['universityid'];

	$eventcount = $this->commonclass->retrive_records('events','count(*) as eventcount','(univId = '.$id_university.')');
	$Jobcount = $this->commonclass->retrive_records('jobs','count(*) as Jobcount','(status = 1 and universityid = '.$id_university.')',array());
	## Count
	$docwhere = "(univId = '".$id_university."')";
    $AdmissionCount = $this->commonclass->retrive_records('admissions','count(*) as admissionscount',$docwhere)	;
	$AdvtagCount = $this->commonclass->retrive_records('advertisement','count(*) as advertisementCount','(unvId = '.$id_university.')');

	$countdetails  = array();
	$countdetails['Jobcount'] = $Jobcount[0]['Jobcount'];
	$countdetails['eventcount'] = $eventcount[0]['eventcount'];
	$countdetails['AdvtagCount'] = $AdvtagCount[0]['advertisementCount'];
	$countdetails['AdmissionCount'] = $AdmissionCount[0]['admissionscount'];

	//echo"<pre>"; print_R($this->sessiondata); echo"</pre>";	 die();


   $eventdetails = $this->commonclass->retrive_records('events','*','((univId = '.$id_university.'))',array(),5);
   $jobs = $this->commonclass->retrive_records('jobs','*','(status=1 AND universityid = '.$id_university.')',array(),5);


		  $data['eventdetails'] = $eventdetails;
		 $data['loginid'] = $this->sessiondata['userid'];
		 $data['countdetails'] = $countdetails;
		 $data['jobs'] = $jobs;

		 $this->load->view('layouts/universityheader',$data_header);
		$this->load->view('university/dashbaord',$data);
		 $this->load->view('layouts/universityfooter');
	}

	public function events($selid  = ''){

		$disp_msg = $this->session->flashdata('disp_msg');
		##Login User details
		$query = $this->commonclass->retrive_records('events','*','(univId = '.$this->sessiondata['universityid'].')');
		$universityquery = $this->commonclass->retrive_records('university','*');

		$approval_inputFileName = "";
		$approvalName = "";
		$tmpName = "";
		$fileSize = "";
		$approvalfileType = "";
		if (!empty($_POST['submit']) && $_POST['submit'] == "Save") {
			if($selid == 0) {
				$uploads_dir = 'uploads';
				$foldername = 'Events';
				$subfoldername = $this->sessiondata['userid'];
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
				} else {*/
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
								'univId' => $this->sessiondata['universityid']

				);

				if($this->commonclass->insert_record("events", $formdata)) {
						$disp_msg = 'Event saved successfully!';
						$this->session->set_flashdata('disp_msg', $disp_msg);
									redirect(current_url());
					}
				}else if ($selid > 0) {
					$formdata = array(
								'univId' => $this->sessiondata['universityid'],
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
		$data['universityquery'] = $this->sessiondata['userid'];
		$data['selid'] = $selid;
		 $data['loginid'] = $this->sessiondata['userid'];

		$this->load->view('layouts/universityheader',$data_header);
		$this->load->view('university/events',$data);
		$this->load->view('layouts/universityfooter');
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

	public function postinformation_old($selid = ''){

		$paypalPackages = $this->commonclass->retrive_records("paypalPackages","*","(pay_status='ACTIVE')");


		//echo"<pre>"; print_R($this->sessiondata); echo"</pre>";die();
		//$results = $this->commonclass->retrive_records("admissiontemp","*","(universityid='".$this->sessiondata['universityid']."')");
		$results = $this->commonclass->retrive_records("admissiontemp","*","(universityid='".$this->sessiondata['universityid']."')");

		if($selid > 0) {
			$reviewedit = $this->commonclass->retrive_records("admissiontemp","*","(id = '".$selid."')");
			$EditRecord = (!empty($reviewedit[0])) ? $reviewedit[0] : array();
			//echo"<pre>"; print_R($reviewedit); echo"</pre>";
		}else{
			$EditRecord = '';
		}

		if (!empty($_POST['submit']) && $_POST['submit'] == "Review") {
			if ($selid > 0) {

				$updateformdata = array(
				'typeposting' => $_POST['typeofposting'],
				'course' => $_POST['Course'],
				'details' => $_POST['Details'],
				'contact' => $_POST['Contact'],
				'amount' => $_POST['paypalPackages'],
				'universityid' => $this->sessiondata['universityid']
						);

				if($this->commonclass->update_record("admissiontemp", $updateformdata, "id", $selid)) { # update record success
				$disp_msg = 'Record Updated Successfully!';
				}
				$this->session->set_flashdata('disp_msg', $disp_msg);
				redirect(current_url());

			}else {

				 $formdata = array(
						'typeposting' => $_POST['typeofposting'],
						'course' => $_POST['Course'],
						'details' => $_POST['Details'],
						'contact' => $_POST['Contact'],
						'amount' => $_POST['paypalPackages'],
						'universityid' => $this->sessiondata['universityid']
				);

				if($this->commonclass->insert_record("admissiontemp", $formdata)) {
						$disp_msg = 'Data Saved successfully!';
						$this->session->set_flashdata('disp_msg', $disp_msg);
						redirect(current_url());
				}
			}

		}
		if (!empty($_POST['submit']) && $_POST['submit'] == "Pay") {

			if ($selid > 0) {

				$updateformdata = array(
					'status' => 2
				);

				if($this->commonclass->update_record("admissiontemp", $updateformdata, "id", $selid)) { # update record success
				$disp_msg = 'Record Updated Successfully!';
				}
				$this->session->set_flashdata('disp_msg', $disp_msg);
				redirect(current_url());

			}else{
				 $formdata = array(
						'typeposting' => $_POST['typeofposting'],
						'course' => $_POST['Course'],
						'details' => $_POST['Details'],
						'amount' => $_POST['paypalPackages'],
						'contact' => $_POST['Contact'],
						'status' => 2,
						'universityid' => $this->sessiondata['universityid']
				);

				if($this->commonclass->insert_record("admissiontemp", $formdata)) {
						$disp_msg = 'Data Saved successfully!';
						$this->session->set_flashdata('disp_msg', $disp_msg);

                        $post_insert_id = $this->db->insert_id();

                        $userPostCartData = array(
                            'id' => $post_insert_id,
                		  	'name' => $_POST['typeofposting'],
                			'qty' => '1',
                			'price' => $_POST['paypalPackages']
                        );

                        $this->session->set_userdata('userCartData', $userPostCartData);

						//redirect(current_url());
				}
			}

            if(isset($post_insert_id) && !empty ($post_insert_id) ) {

              redirect('express_checkout');

            }
		}

		if (!empty($_POST['submit']) && $_POST['submit'] == "publish") {

		$admissiontempRecords =  $this->commonclass->retrive_records("admissiontemp","*","(id = '".$selid."')");
		$Movedrecord  = (!empty($admissiontempRecords[0])) ? $admissiontempRecords[0] : array();

		echo $typeofrecord = !empty($Movedrecord['typeposting']) ? $Movedrecord['typeposting']: '';
		$course = !empty($EditRecord['course'])? $EditRecord['course'] : '';
		$details = !empty($EditRecord['details'])? $EditRecord['details'] : '';
		$contact = !empty($EditRecord['contact'])? $EditRecord['contact'] : '';
		$status = !empty($EditRecord['status'])? $EditRecord['status'] : '';
		$amount = !empty($EditRecord['amount'])? $EditRecord['amount'] : '';

			 if($typeofrecord == "Admission"){

				 $formdata = array(
						'univId' => $this->sessiondata['universityid'],
						'branchname' => $course,
						'information' => $details,
						'Contact' => $contact,
						'amount' => $amount,
						'status' => 1,
				);

				if($this->commonclass->insert_record("admissions", $formdata)) {
						$disp_msg = 'Record Published  successfully!';
						$this->session->set_flashdata('disp_msg', $disp_msg);
						$this->db->query("DELETE FROM admissiontemp WHERE id = '".$selid."'");
						redirect('university/postinformation');
				}


			}
			if($typeofrecord == "scholarship"){  //echo"vasu"; die();
				 $formdata = array(
						'univId' => $this->sessiondata['universityid'],
						'branchname' => $course,
						'information' => $details,
						'Contact' => $contact,
						'amount' => $amount,
						'status' => 1,
				);

				if($this->commonclass->insert_record("scholarship", $formdata)) {
						$disp_msg = 'Record Published  successfully!';
						$this->session->set_flashdata('disp_msg', $disp_msg);
						$this->db->query("DELETE FROM admissiontemp WHERE id = '".$selid."'");
						redirect('university/postinformation');
				}
			}

			if($typeofrecord == "Job"){  //echo"vasu"; die();
				 $formdata = array(
						'universityid' => $this->sessiondata['universityid'],
						'title' => $course,
						'details' => $details,
						'contact' => $contact,'amount' => $amount,
						'status' => 1,
				);

				if($this->commonclass->insert_record("jobs", $formdata)) {
						$disp_msg = 'Record Published  successfully!';
						$this->session->set_flashdata('disp_msg', $disp_msg);
						$this->db->query("DELETE FROM admissiontemp WHERE id = '".$selid."'");
						redirect('university/postinformation');
				}
			}

			/* if($edit_typeofposting = "Job"){
				$sel_Achecked =  'checked = "checked"';
			} */
		/*
			if ($selid > 0) {

				$updateformdata = array(
					'status' => 1
				);

				if($this->commonclass->update_record("admissiontemp", $updateformdata, "id", $selid)) { # update record success
				$disp_msg = 'Record Updated Successfully!';
				}
				$this->session->set_flashdata('disp_msg', $disp_msg);
				redirect(current_url());

			} */
		}



		$disp_msg = $this->session->flashdata('disp_msg');
		//echo"<pre>"; print_R($results); echo"</pre>";
		$data['universityid'] = $this->sessiondata['universityid'];
		$data['disp_msg'] = $disp_msg;
		$data['results'] = $results;
		$disp_msg = $this->session->flashdata('disp_msg');
		$data['loginid'] = $this->sessiondata['userid'];
		$data['disp_msg'] = $disp_msg;
		$data['EditRecord'] = $EditRecord;
		//$data['EditRecord'] = $EditRecord;
		$data['paypalPackages'] = $paypalPackages;
		$data['selid'] = $selid;

		$this->load->view('layouts/universityheader',$data_header);
		$this->load->view('university/postinformation',$data);
		$this->load->view('layouts/universityfooter');


	}

	public function postinformation($selid = ''){

		$paypalPackages = $this->commonclass->retrive_records("paypalPackages","*","(pay_status='ACTIVE')");



		//$results = $this->commonclass->retrive_records("admissiontemp","*","(universityid='".$this->sessiondata['universityid']."')");
		//$results = $this->commonclass->retrive_records("admissiontemp","*","(universityid='".$this->sessiondata['universityid']."')");
		if($_POST['typeofposting'] == 'Admission'){

			if($_POST['submit'] =="Pay" || $_POST['submit'] =="Review"){

				 $formdata = array(
						'univId' => $this->sessiondata['universityid'],
						'branchname' => $_POST['Course'],
						'information' => $_POST['Details'],
						'Contact' => $_POST['Contact'],
						'amount' => $_POST['paypalPackages'],
						'status' => 1,
				);

				$post_insert_id = $this->db->insert_id();

						$userPostCartData = array(
						'id' => $post_insert_id,
						'name' => $_POST['typeofposting'],
						'qty' => '1',
						'price' => $_POST['paypalPackages']
						);

						$this->session->set_userdata('userCartData', $userPostCartData);


					//echo"<pre>"; print_R($formdata); echo"</pre>";die();
				if($this->commonclass->insert_record("admissions", $formdata)) {

						 if(isset($post_insert_id) && !empty ($post_insert_id) ) {

					redirect('express_checkout');

				}

						$disp_msg = 'Record Published  successfully!';
						redirect('university/admission');
				}



			}

		}elseif($_POST['typeofposting'] == 'Job'){

			if($_POST['submit'] =="Pay" || $_POST['submit'] =="Review"){

				 $formdata = array(
						// 'univId' => $this->sessiondata['universityid'],
						// 'branchname' => $_POST['Course'],
						// 'information' => $_POST['Details'],
						// 'Contact' => $_POST['Contact'],
						// 'amount' => $_POST['paypalPackages'],
						// 'status' => 1,

						'universityid' => $this->sessiondata['universityid'],
						'title' => $_POST['Course'],
						'details' => $_POST['Details'],
						'contact' => $_POST['Contact'],'amount' => $_POST['paypalPackages'],
						'status' => 1,
				);
					//echo"<pre>"; print_R($formdata); echo"</pre>";die();
				if($this->commonclass->insert_record("jobs", $formdata)) {
						$disp_msg = 'Record Published  successfully!';
						redirect('university/jobs');
				}

			}
		}else{

		if($_POST['submit'] =="Pay" || $_POST['submit'] =="Review"){

				 $formdata = array(
						'univId' => $this->sessiondata['universityid'],
						'branchname' => $_POST['Course'],
						'information' => $_POST['Details'],
						'Contact' => $_POST['Contact'],
						'amount' => $_POST['paypalPackages'],
						'status' => 1,
				);
					//echo"<pre>"; print_R($formdata); echo"</pre>";die();
				if($this->commonclass->insert_record("scholarship", $formdata)) {
						$disp_msg = 'Record Published  successfully!';
						redirect('university/scholarships');
				}

			}

		}


		$disp_msg = $this->session->flashdata('disp_msg');
		//echo"<pre>"; print_R($results); echo"</pre>";
		$data['universityid'] = $this->sessiondata['universityid'];
		$data['disp_msg'] = $disp_msg;
		$data['results'] = $results;
		$disp_msg = $this->session->flashdata('disp_msg');
		$data['loginid'] = $this->sessiondata['userid'];
		$data['disp_msg'] = $disp_msg;
		$data['EditRecord'] = $EditRecord;
		//$data['EditRecord'] = $EditRecord;
		$data['paypalPackages'] = $paypalPackages;
		$data['selid'] = $selid;

		$this->load->view('layouts/universityheader',$data_header);
		$this->load->view('university/postinformation',$data);
		$this->load->view('layouts/universityfooter');


	}



	 public function admission($sel_id=''){

		 $id_university =  $this->sessiondata['universityid'];

		$Admissions = $this->commonclass->retrive_records('admissions','*','(univId = '.$id_university.' and status != 2)');

		 if(!empty($sel_id)){

		$ViewAdms = $this->commonclass->retrive_records('admissions','*','(admitId = '.$sel_id.' AND univId = '.$id_university.')');
		  }else{
			$ViewAdms = '';
		  }
    //echo"<pre>"; print_R($this->sessiondata); echo"</pre>";

		$data_header['siteconfig'] = $this->siteconfig;
		$data_header['ViewAdms'] = $ViewAdms;
		$data['siteconfig'] = $this->siteconfig;
		$data['Admissions'] = $Admissions;
		$data['sel_id'] = $sel_id;
		 $data['loginid'] = $this->sessiondata['userid'];
		$this->load->view('layouts/universityheader',$data_header);
		$this->load->view('university/admission',$data);
		$this->load->view('layouts/universityfooter');
   }


    public function scholarships($sel_id = ''){


		 $id_university = $this->sessiondata['universityid'];
	//	die();
		$Admissions = $this->commonclass->retrive_records('scholarship','*','(univId = '.$id_university.' and status !=2)');

		 if(!empty($sel_id)){

		$ViewAdms = $this->commonclass->retrive_records('scholarship','*','(admitId = '.$sel_id.' AND univId = '.$id_university.')');
		  }else{
			$ViewAdms = '';
		  }

		$data_header['siteconfig'] = $this->siteconfig;
		$data_header['ViewAdms'] = $ViewAdms;
		$data['siteconfig'] = $this->siteconfig;
		$data['Admissions'] = $Admissions;
		$data['sel_id'] = $sel_id;
		 $data['loginid'] = $this->sessiondata['universityid'];

		$this->load->view('layouts/universityheader',$data_header);
		$this->load->view('university/scholarships',$data);
		$this->load->view('layouts/universityfooter');
   }

    public function jobs($sel_id = ''){

		$Jobs = $this->commonclass->retrive_records('jobs','*','(status = 1 and universityid = '.$this->sessiondata['universityid'].')');
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

		$this->load->view('layouts/universityheader',$data_header);
		$this->load->view('university/jobs',$data);
		$this->load->view('layouts/universityfooter');
   }


  	public function advertisementOLD($selid = ''){

			$paypalPackages = $this->commonclass->retrive_records("paypalPackages","*","(pay_status='ACTIVE')");

			//echo"<pre>"; print_R($paypalPackages); echo"</pre>";
		$results = $this->commonclass->retrive_records("advertisementemp","*","(universityid='".$this->sessiondata['universityid']."')");

		if($selid > 0) {
			$reviewedit = $this->commonclass->retrive_records("advertisementemp","*","(id = '".$selid."')");
			$EditRecord = (!empty($reviewedit[0])) ? $reviewedit[0] : array();
			//echo"<pre>"; print_R($reviewedit); echo"</pre>";
		}else{
			$EditRecord = '';
		}

		if (!empty($_POST['submit']) && $_POST['submit'] == "Review") {

				$uploads_dir = 'uploads';
				$foldername = 'Advertisement';
				$subfoldername = $this->sessiondata['userid'];
				$uploadpath = './'.$uploads_dir.'/'.$foldername.'/'.$subfoldername.'/';
				/* attachment uploads directory path start */
				//die();
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
				if (!$this->upload->do_upload('fileToUpload'))
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

					//echo"<pre>"; print_R($_FILES); echo"</pre>";
				//echo"<pre>"; print_R($_POST); echo"</pre>"; die();

			if ($selid > 0) {
				$updateformdata = array(

				//'typeposting' => $_POST['typeofposting'],
				'course' => $_POST['Course'],
				'details' => $_POST['Details'],
				'contact' => $_POST['Contact'],
				'amount' => $_POST['paypalPackages'],
				'advImgs' => $approvalName ,
				'ImgRndName' => $approval_inputFileName,
				'ImgType' => $approvalfileType,
				'universityid' => $this->sessiondata['universityid']
						);

				if($this->commonclass->update_record("advertisementemp", $updateformdata, "id", $selid)) { # update record success
				$disp_msg = 'Record Updated Successfully!';
				}
				$this->session->set_flashdata('disp_msg', $disp_msg);
				redirect(current_url());

			}else {

				 $formdata = array(
						//'typeposting' => $_POST['typeofposting'],
						'course' => $_POST['Course'],
						'details' => $_POST['Details'],
						'contact' => $_POST['Contact'],
				'amount' => $_POST['paypalPackages'],
						'advImgs' => $approvalName ,
						'ImgRndName' => $approval_inputFileName,
						'ImgType' => $approvalfileType,
						'universityid' => $this->sessiondata['universityid']
				);

				if($this->commonclass->insert_record("advertisementemp", $formdata)) {
						$disp_msg = 'Data Saved successfully!';
						$this->session->set_flashdata('disp_msg', $disp_msg);
						redirect(current_url());
				}
			}

		}
		if (!empty($_POST['submit']) && $_POST['submit'] == "Pay") {

			if ($selid > 0) {

				$updateformdata = array(
					'status' => 2
				);

				if($this->commonclass->update_record("advertisementemp", $updateformdata, "id", $selid)) { # update record success
				$disp_msg = 'Record Updated Successfully!';
				}
				$this->session->set_flashdata('disp_msg', $disp_msg);
				redirect(current_url());

			}else{

				$uploads_dir = 'uploads';
				$foldername = 'Advertisement';
				$subfoldername = $this->sessiondata['userid'];
				$uploadpath = './'.$uploads_dir.'/'.$foldername.'/'.$subfoldername.'/';
				/* attachment uploads directory path start */
				//die();
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
				if (!$this->upload->do_upload('fileToUpload'))
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



				 $formdata = array(
						'course' => $_POST['Course'],
						'details' => $_POST['Details'],
						'contact' => $_POST['Contact'],
				'amount' => $_POST['paypalPackages'],
						'advImgs' => $approvalName ,
						'ImgRndName' => $approval_inputFileName,
						'ImgType' => $approvalfileType,'status' => 2,
						'universityid' => $this->sessiondata['universityid']
				);

				if($this->commonclass->insert_record("advertisementemp", $formdata)) {
						$disp_msg = 'Data Saved successfully!';
						$this->session->set_flashdata('disp_msg', $disp_msg);
						redirect(current_url());
				}
			}
		}

		 if (!empty($_POST['submit']) && $_POST['submit'] == "publish") {


				$course = !empty($EditRecord['course'])? $EditRecord['course'] : '';
				$details = !empty($EditRecord['details'])? $EditRecord['details'] : '';
				$contact = !empty($EditRecord['contact'])? $EditRecord['contact'] : '';
				$amount = !empty($EditRecord['amount'])? $EditRecord['amount'] : '';
				$status = !empty($EditRecord['status'])? $EditRecord['status'] : '';
				$advImgs = !empty($EditRecord['advImgs'])? $EditRecord['advImgs'] : '';
				$ImgRndName = !empty($EditRecord['ImgRndName'])? $EditRecord['ImgRndName'] : '';
				$ImgType = !empty($EditRecord['ImgType'])? $EditRecord['ImgType'] : '';


				 $formdata = array(
						'unvId' => $this->sessiondata['universityid'],
						'advName' => $course,
						'advDesc' => $details,
						'Contact' => $contact,
						'advImgs' => $advImgs,
						'amount' => $amount,
						'ImgRndName' => $ImgRndName,
						'ImgType' => $ImgType,
						'status' => 1,
				);

			//print_R($formdata); die();

				if($this->commonclass->insert_record("advertisement", $formdata)) {
						$disp_msg = 'Record Published  successfully!';
						$this->session->set_flashdata('disp_msg', $disp_msg);
						$this->db->query("DELETE FROM advertisementemp WHERE id = '".$selid."'");
						redirect('university/advertisement/');
				}




			}




		$disp_msg = $this->session->flashdata('disp_msg');
		//echo"<pre>"; print_R($results); echo"</pre>";
		$data['paypalPackages'] = $paypalPackages;
		$data['loginid'] = $this->sessiondata['userid'];
		$data['disp_msg'] = $disp_msg;
		$data['results'] = $results;
		$disp_msg = $this->session->flashdata('disp_msg');
		$data['loginid'] = $this->sessiondata['userid'];
		$data['disp_msg'] = $disp_msg;
		$data['EditRecord'] = $EditRecord;
		$data['selid'] = $selid;

		$this->load->view('layouts/universityheader',$data_header);
		$this->load->view('university/postadvtage',$data);
		$this->load->view('layouts/universityfooter');


	}


	 public function Advertisementpreview($sel_id = ''){

		$advertisements = $this->commonclass->retrive_records('advertisement','*','(status = 1 and unvId = '.$this->sessiondata['universityid'].')');
		if(!empty($sel_id)){
			$Viewadvertisements = $this->commonclass->retrive_records('advertisement','*','(advId = '.$sel_id.')');
		 }else{
			$Viewadvertisements = '';
		  }
		//echo"<pre>"; print_R($Jobs); echo"</pre>";
		$data_header['siteconfig'] = $this->siteconfig;
		$data['siteconfig'] = $this->siteconfig;
		$data['advertisements'] = $advertisements;
		$data['Viewadvertisements'] = $Viewadvertisements;
		$data['sel_id'] = $sel_id;
		 $data['loginid'] = $this->sessiondata['userid'];

		$this->load->view('layouts/universityheader',$data_header);
		$this->load->view('university/advertisement',$data);
		$this->load->view('layouts/universityfooter');
   }


  	public function advertisement($selid = ''){

			$paypalPackages = $this->commonclass->retrive_records("paypalPackages","*","(pay_status='ACTIVE')");

			//echo"<pre>"; print_R($_POST); echo"</pre>";die();
		$results = $this->commonclass->retrive_records("advertisement","*","(unvId='".$this->sessiondata['universityid']."')");

		if($selid > 0) {
			$reviewedit = $this->commonclass->retrive_records("advertisement","*","(advId = '".$selid."')");
			$EditRecord = (!empty($reviewedit[0])) ? $reviewedit[0] : array();
			//echo"<pre>"; print_R($EditRecord); echo"</pre>";
		}else{
			$EditRecord = '';
		}
		//die();
	if (!empty($_POST['submit']) && $_POST['submit'] == "Pay & Publish") {

			if ($selid > 0) {

				$updateformdata = array(
					'status' => 1
				);

				if($this->commonclass->update_record("advertisement", $updateformdata, "advId", $selid)) { # update record success
				$disp_msg = 'Record Updated Successfully!';
				}
				$this->session->set_flashdata('disp_msg', $disp_msg);
				redirect(current_url());

			}else{

				$uploads_dir = 'uploads';
				$foldername = 'Advertisement';
				$subfoldername = $this->sessiondata['userid'];
				$uploadpath = './'.$uploads_dir.'/'.$foldername.'/'.$subfoldername.'/';
				/* attachment uploads directory path start */
				//die();
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
				// if (!$this->upload->do_upload('fileToUpload'))
				// { ## file not moved show error and redirecting to current page
					// $status = 'error';
					// $disp_msg = $this->upload->display_errors('', '');
					// $this->session->set_flashdata('disp_msg', $disp_msg);
					// redirect(current_url(), 'refresh');	 # redirect to samepage
				// } else {
					## retreiving uploaded data to save in database
					$data123 = $this->upload->data();
					$approval_inputFileName = basename($data123['full_path']);


				//}



				 $formdata = array(

							'unvId' => $this->sessiondata['universityid'],
							'advName' => $_POST['Course'],
							'advDesc' => $_POST['Details'],
							'Contact' => $_POST['Contact'],
							'advImgs' => $approvalName ,
							'amount' => $_POST['paypalPackages'],
							'ImgRndName' => $approval_inputFileName,
							'ImgType' => $approvalfileType,
							'status' => 1,

				);

				if($this->commonclass->insert_record("advertisement", $formdata)) {
						$disp_msg = 'Data Saved successfully!';
						$this->session->set_flashdata('disp_msg', $disp_msg);
						redirect(current_url());
                        /*$insert_id = $this->db->insert_id();

                        $userCartData = array(
                            'id' => $insert_id,
                		  	'name' => $this->uri->segment(2),
                			'qty' => '1',
                			'price' => $_POST['paypalPackages']
                        );

                        $this->session->set_userdata('userCartData', $userCartData);*/

				}
			}

            /*if(isset($insert_id) && !empty ($insert_id) ) {

              redirect('express_checkout');

            }*/

		}


		if (!empty($_POST['submit']) && $_POST['submit'] == "Pay to Publish") {

			if ($selid > 0) {

				$updateformdata = array(
					        'unvId' => $this->sessiondata['universityid'],
							'advName' => $_POST['Course'],
							'advDesc' => $_POST['Details'],
							'Contact' => $_POST['Contact'],
							'advImgs' => $approvalName ,
							'amount' => $_POST['paypalPackages'],
							'ImgRndName' => $approval_inputFileName,
							'ImgType' => $approvalfileType,
							'status' => 2
				);

				if($this->commonclass->update_record("advertisement", $updateformdata, "advId", $selid)) { # update record success
				$disp_msg = 'Record Updated Successfully!';
				}

				/*$userCartData = array(
                            'id' => $insert_id,
                		  	'name' => $this->uri->segment(2),
                			'qty' => '1',
                			'price' => $_POST['paypalPackages']
                        );

                $this->session->set_userdata('userCartData', $userCartData);
				$this->session->set_flashdata('disp_msg', $disp_msg);
				redirect('express_checkout');*/
					redirect(current_url());

			}else{

				$uploads_dir = 'uploads';
				$foldername = 'Advertisement';
				$subfoldername = $this->sessiondata['userid'];
				$uploadpath = './'.$uploads_dir.'/'.$foldername.'/'.$subfoldername.'/';
				/* attachment uploads directory path start */
				//die();
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
				// if (!$this->upload->do_upload('fileToUpload'))
				// { ## file not moved show error and redirecting to current page
					// $status = 'error';
					// $disp_msg = $this->upload->display_errors('', '');
					// $this->session->set_flashdata('disp_msg', $disp_msg);
					// redirect(current_url(), 'refresh');	 # redirect to samepage
				// } else {
					## retreiving uploaded data to save in database
					$data123 = $this->upload->data();
					$approval_inputFileName = basename($data123['full_path']);


				//}



				 $formdata = array(

							'unvId' => $this->sessiondata['universityid'],
							'advName' => $_POST['Course'],
							'advDesc' => $_POST['Details'],
							'Contact' => $_POST['Contact'],
							'advImgs' => $approvalName ,
							'amount' => $_POST['paypalPackages'],
							'ImgRndName' => $approval_inputFileName,
							'ImgType' => $approvalfileType,
							'status' => 1,

				);

				if($this->commonclass->insert_record("advertisement", $formdata)) {
						$disp_msg = 'Data Saved successfully!';
						$this->session->set_flashdata('disp_msg', $disp_msg);
						//redirect(current_url());
                        $insert_id = $this->db->insert_id();

                        $userCartData = array(
                            'id' => $insert_id,
                		  	'name' => $this->uri->segment(2),
                			'qty' => '1',
                			'price' => $_POST['paypalPackages']
                        );

                        $this->session->set_userdata('userCartData', $userCartData);

				}
			}

            /*if(isset($insert_id) && !empty ($insert_id) ) {

              redirect('express_checkout');

            }*/

		}

		if (!empty($_POST['submit']) && $_POST['submit'] == "Draft") {

				$uploads_dir = 'uploads';
				$foldername = 'Advertisement';
				$subfoldername = $this->sessiondata['userid'];
				$uploadpath = './'.$uploads_dir.'/'.$foldername.'/'.$subfoldername.'/';
				/* attachment uploads directory path start */
				//die();
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

					## retreiving uploaded data to save in database
					$data123 = $this->upload->data();
					$approval_inputFileName = basename($data123['full_path']);

				 $formdata = array(
							'unvId' => $this->sessiondata['universityid'],
							'advName' => $_POST['Course'],
							'advDesc' => $_POST['Details'],
							'Contact' => $_POST['Contact'],
							'advImgs' => $approvalName ,
							'amount' => $_POST['paypalPackages'],
							'ImgRndName' => $approval_inputFileName,
							'ImgType' => $approvalfileType,
							'status' => 2,
				);

				if($this->commonclass->insert_record("advertisement", $formdata)) {
						$disp_msg = 'Data Saved successfully!';
						$this->session->set_flashdata('disp_msg', $disp_msg);
						redirect(current_url());
				}


		}
		if (!empty($_POST['submit']) && $_POST['submit'] == "Re-Draft") {

				$uploads_dir = 'uploads';
				$foldername = 'Advertisement';
				$subfoldername = $this->sessiondata['userid'];
				$uploadpath = './'.$uploads_dir.'/'.$foldername.'/'.$subfoldername.'/';
				/* attachment uploads directory path start */
				//die();
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

					## retreiving uploaded data to save in database
					$data123 = $this->upload->data();
					$approval_inputFileName = basename($data123['full_path']);

				 $formdata = array(
							'unvId' => $this->sessiondata['universityid'],
							'advName' => $_POST['Course'],
							'advDesc' => $_POST['Details'],
							'Contact' => $_POST['Contact'],
							'advImgs' => $approvalName ,
							'amount' => $_POST['paypalPackages'],
							'ImgRndName' => $approval_inputFileName,
							'ImgType' => $approvalfileType,
							'status' => 2,
				);
				if($this->commonclass->update_record("advertisement", $formdata, "advId", $selid)) {

				//if($this->commonclass->insert_record("advertisement", $formdata)) {
						$disp_msg = 'Record Updated successfully!';
						$this->session->set_flashdata('disp_msg', $disp_msg);
						redirect('university/advertisement/');
				}


		}

		//echo"<pre>"; print_r($_POST); echo"</pre>";
		 if (!empty($_POST['submit']) && $_POST['submit'] == "Publish") {

				 //die();
				if ($selid > 0) {

				$updateformdata = array(
					'status' => 1
				);

				if($this->commonclass->update_record("advertisement", $updateformdata, "advId", $selid)) { # update record success
				$disp_msg = 'Published Successfully!';
				}
				$this->session->set_flashdata('disp_msg', $disp_msg);
				redirect('university/advertisement/');
				}


			}




		$disp_msg = $this->session->flashdata('disp_msg');
		//echo"<pre>"; print_R($results); echo"</pre>";
		$data['paypalPackages'] = $paypalPackages;
		$data['loginid'] = $this->sessiondata['userid'];
		$data['disp_msg'] = $disp_msg;
		$data['results'] = $results;
		$disp_msg = $this->session->flashdata('disp_msg');
		$data['loginid'] = $this->sessiondata['userid'];
		$data['disp_msg'] = $disp_msg;
		$data['EditRecord'] = $EditRecord;
		//$data['Viewadvertisements'] = $EditRecord;
		$data['selid'] = $selid;

		$this->load->view('layouts/universityheader',$data_header);
		$this->load->view('university/postadvtage',$data);
		$this->load->view('layouts/universityfooter');


	}

	public function jobdelete($id_record = ''){

		 $id = !empty($_POST['id']) ? $_POST['id']:'';
	  	 ## update data from post
		$updatedata =  array(
		'status' => 2
		);
		$this->commonclass->update_record('jobs', $updatedata, "id", $id);
		$disp_msg = "Status changed Successfully!";
		$this->session->set_flashdata('disp_msg', $disp_msg);

		## update record & insert activity on success end

			exit;

	}
	public function admissiondelete($id_record = ''){

		 $id = !empty($_POST['id']) ? $_POST['id']:'';
	  	 ## update data from post
		$updatedata =  array(
		'status' => 2
		);
		$this->commonclass->update_record('admissions', $updatedata, "admitId", $id);
		$disp_msg = "Status changed Successfully!";
		$this->session->set_flashdata('disp_msg', $disp_msg);

		## update record & insert activity on success end

			exit;

	}
	public function scholarshipdelete($id_record = ''){

		 $id = !empty($_POST['id']) ? $_POST['id']:'';
	  	 ## update data from post
		$updatedata =  array(
		'status' => 2
		);
		$this->commonclass->update_record('scholarship', $updatedata, "admitId", $id);
		$disp_msg = "Status changed Successfully!";
		$this->session->set_flashdata('disp_msg', $disp_msg);

		## update record & insert activity on success end

			exit;

	}
}
