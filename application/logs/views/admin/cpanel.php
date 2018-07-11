<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cpanel extends CI_Controller {
/*
		__construct will execute for each and every method of this controller
	*/
	
	public function __construct()
	{
		parent::__construct();
			   
			$this->baseurl = $this->config->item('base_url'); #base url path
			$this->load->library('commonclass'); #loading comonclass library
			$this->load->library('session'); #loading session library
			$this->load->helper('url'); #loading url helper
			
			$this->sel_theam_path = "admin";
			
			$this->loginuserdata = $loginuserdata = $this->session->userdata('loginuserdata'); # Existing session data
			
			if ( (empty($loginuserdata)) || (!empty($loginuserdata) && $loginuserdata['usertype'] != "admin") ) {
				
					$disp_msg = 'Error: Login Required, to access this page!';
					$this->session->set_flashdata('disp_msg', $disp_msg);
					redirect('/login/index', 'refresh');
			}
			
			$siteconfigres =  $this->commonclass->retrive_records('siteconfig', ' * ', "",array("idsiteconfig" => "DESC"), 1); # users Table
			$this->siteconfigs = !empty($siteconfigres[0]) ? $siteconfigres[0] : array() ;
			
	}
		
	/**
	 * Index Page for cpanel controller.
	 *
	 */
	public function index()
	{
		
		$disp_msg = $this->session->flashdata('disp_msg');
		
		$postpatch_uploads =  $this->commonclass->retrive_records('postpatch_uploads', ' * ', "",array("idpostpatch_upload" => "DESC"),''); # postpatch_schedule Table
		
		## ____________  Data sending to the template starts  ____________ ##
		$data['disp_msg'] = $disp_msg; # display messages
		$data['postpatch_uploads'] = $postpatch_uploads; # postpatch_schedule
		
		## ____________  Data sending to the template ends here  ____________ ##
		
		$this->load->view('layout/'.$this->sel_theam_path.'/header', $data); # html view page
		$this->load->view('admin/cpanel-page', $data); # html view page
		$this->load->view('layout/'.$this->sel_theam_path.'/footer', $data); # html view page
	}
	/* End of cpanel / index method */
	
	
		
	/**
	 * activitylog Page for cpanel controller.
	 *
	 */
	public function activitylog()
	{
		
		$disp_msg = $this->session->flashdata('disp_msg');
		
		$activitylog =  $this->commonclass->retrive_records('activitylog', ' *, date(updateon) as updateondt ', "",array("idactivitylog" => "DESC"),''); # postpatch_schedule Table
		
		
		## ____________  Data sending to the template starts  ____________ ##
		$data['disp_msg'] = $disp_msg; # display messages
		$data['activitylog'] = $activitylog; # postpatch_schedule
		
		## ____________  Data sending to the template ends here  ____________ ##
		
		$this->load->view('layout/'.$this->sel_theam_path.'/header', $data); # html view page
		$this->load->view('admin/activitylog-page', $data); # html view page
		$this->load->view('layout/'.$this->sel_theam_path.'/footer', $data); # html view page
	}
	/* End of cpanel / activitylog method */
	
	
	
		
	/**
	 * maillog Page for cpanel controller.
	 *
	 */
	public function maillog()
	{
		
		$disp_msg = $this->session->flashdata('disp_msg');
		
		$maillog =  $this->commonclass->retrive_records('mail_log', ' * ', "",array("id_mail_log" => "DESC"),''); # postpatch_schedule Table
		
		
		## ____________  Data sending to the template starts  ____________ ##
		$data['disp_msg'] = $disp_msg; # display messages
		$data['maillog'] = $maillog; # postpatch_schedule
		
		## ____________  Data sending to the template ends here  ____________ ##
		
		$this->load->view('layout/'.$this->sel_theam_path.'/header', $data); # html view page
		$this->load->view('admin/maillog-page', $data); # html view page
		$this->load->view('layout/'.$this->sel_theam_path.'/footer', $data); # html view page
	}
	/* End of cpanel / maillog method */
	
	
		
	/**
	 * logintrack Page for cpanel controller.
	 *
	 */
	public function logintrack()
	{
		
		$disp_msg = $this->session->flashdata('disp_msg');
		
		$logintrack =  $this->commonclass->retrive_records('login_track', ' * ', "(logouttime = '0000-00-00 00:00:00' and loginid != ".$this->loginuserdata['loginid'].")",array("idlogin_track" => "DESC"),''); # postpatch_schedule Table
		$offlinelogintrack =  $this->commonclass->retrive_records('login_track', ' * ', "(logouttime != '0000-00-00 00:00:00')",array("idlogin_track" => "DESC"),''); # postpatch_schedule Table
		
		## ____________  Data sending to the template starts  ____________ ##
		$data['disp_msg'] = $disp_msg; # display messages
		$data['logintrack'] = $logintrack; # postpatch_schedule
		$data['offlinelogintrack'] = $offlinelogintrack; # postpatch_schedule
		
		## ____________  Data sending to the template ends here  ____________ ##
		
		$this->load->view('layout/'.$this->sel_theam_path.'/header', $data); # html view page
		$this->load->view('admin/logintrack-page', $data); # html view page
		$this->load->view('layout/'.$this->sel_theam_path.'/footer', $data); # html view page
	}
	/* End of cpanel / logintrack method */
	
	
	/**
	 * Users list Page for cpanel controller.
	 *
	 */
	public function nodes_list()
	{
		$disp_msg = $this->session->flashdata('disp_msg');
		
		$nodeslist =  $this->commonclass->retrive_records('rninodes_master', ' * ', "",array("idrninodes_master" => "DESC"),''); # users Table
		
		## ____________  Data sending to the template starts  ____________ ##
		$data['disp_msg'] = $disp_msg; # display messages
		$data['nodeslist'] = $nodeslist; # nodeslist
		
		## ____________  Data sending to the template ends here  ____________ ##
		
		$this->load->view('layout/'.$this->sel_theam_path.'/header', $data); # html view page
		$this->load->view('admin/nodes_list-page', $data); # html view page
		$this->load->view('layout/'.$this->sel_theam_path.'/footer', $data); # html view page
		
		
	}
	/* End of cpanel / users_listmethod */
	
	
	
	
	/**
	 * Import RNI nodes from excel sheet from cpanel controller.
	 *
	 */
	public function import_nodes()
	{
		//load our new PHPExcel library
		$this->load->library('excel');
		
		echo $inputFileName = FCPATH."dbtableimport/rninodes.xlsx";
		
		
		if(file_exists($inputFileName)) {
		
				$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
				$sheetDatas = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
				
				echo "<pre>"; print_r($sheetDatas); echo "</pre>";
				
				if (count($sheetDatas) > 0) {
					foreach ($sheetDatas as $sheetData) {
						if (!empty($sheetData['B'])) {
							$exp_def_time = explode(" - ", $sheetData['B']);
							
							$def_stime = trim($exp_def_time[0]);
							$def_etime = trim($exp_def_time[1]);
							$rni_name = trim($sheetData['C']);
							$rni_node = trim($sheetData['D']);
							
							
							$insertdata =  array(
								'rninode' => $rni_node,
								'rniname' => $rni_name,
								'default_time' => trim($sheetData['B']),
								'dafault_stime' => $def_stime,
								'default_etime' => $def_etime,
							);	
				//echo "<pre>"; print_r($insertdata); echo "</pre>";
							
							echo $this->commonclass->insert_record('rninodes_master', $insertdata); 
						
						}
					}
				}
		}
		
		
		exit;
	}
	
	
	/**
	 * Users list Page for cpanel controller.
	 *
	 */
	public function nodesform($selid = 0)
	{
		$disp_msg = $this->session->flashdata('disp_msg');
		
			
		if($selid > 0) {
			$rninodesres =  $this->commonclass->retrive_records('rninodes_master', ' * ', "(idrninodes_master=".$selid.")",array("idrninodes_master" => "DESC"),1); # users Table
			$rninodeslist = (!empty($rninodesres[0])) ? $rninodesres[0] : array();
		} else {
			$rninodeslist = array();
		}
		
		if (!empty($_POST['submit']) && $_POST['submit'] == "Save") {
			
			
			if($selid == 0) {
				
				$formdata = array(
								'rninode' => $_POST['rninode'],
								'rniname' => $_POST['rniname'],
								'default_time' => $_POST['default_time'],
								'ncid' => $_POST['ncid'],
								'createddate' => date('Y-m-d'),
							);
				if($this->commonclass->insert_record("rninodes_master", $formdata)) {
					$activitydata = array(
								'module' => 'admin',
								'type' => 'Activity',
								'page' => 'RNI / Node',
								'empid' => '',
								'activity' => "New RNI / Node (".$_POST['rninode'].") added by admin ",
								'updateby' => $this->loginuserdata['loginid'],
								'updateby_name' => $this->loginuserdata['loginname']
							);
					$this->commonclass->insert_record("activitylog", $activitydata);
						$disp_msg = 'RNI / Node details saved successfully!';
						$this->session->set_flashdata('disp_msg', $disp_msg);
				}
			} else if ($selid > 0) {
				
					$formdata = array(
								'rninode' => $_POST['rninode'],
								'rniname' => $_POST['rniname'],
								'default_time' => $_POST['default_time'],
								'ncid' => $_POST['ncid'],
								'updateby' => $this->loginuserdata['loginid']
							);
				
					if($this->commonclass->update_record("rninodes_master", $formdata, "idrninodes_master", $selid)) { # update record success
						$activitydata = array(
									'module' => 'admin',
									'type' => 'Alert',
									'page' => 'RNI / Node',
									'empid' => '',
									'activity' => "RNI / Node (".$_POST['rninode'].") details updated by admin (".$_POST['comments'].")",
									'updateby' => $this->loginuserdata['loginid'],
									'updateby_name' => $this->loginuserdata['loginname']
								);
						$this->commonclass->insert_record("activitylog", $activitydata);				
						$disp_msg = 'RNI / Node details saved successfully!';
						$this->session->set_flashdata('disp_msg', $disp_msg);					
					}
				}
				redirect(current_url()); # redirect to samepage	
			
			}
		
		## ____________  Data sending to the template starts  ____________ ##
		$data['disp_msg'] = $disp_msg; # display messages
		$data['rninodeslist'] = $rninodeslist; # rninodeslist
		$data['selid'] = $selid; # selid
		
		## ____________  Data sending to the template ends here  ____________ ##
		
		$this->load->view('layout/'.$this->sel_theam_path.'/header', $data); # html view page
		$this->load->view('admin/nodesform-page', $data); # html view page
		$this->load->view('layout/'.$this->sel_theam_path.'/footer', $data); # html view page
		
		
	}
	/* End of cpanel / users_listmethod */
	
	
	/**
	 * Change employee status function
	 *
	 * JQUERY function
	 */
	public function change_node_status($selid, $newstatus)
	{
		## comments from post
		$comments = (!empty($_POST['comments'])) ? $_POST['comments'] : '';
		$nodetitle = (!empty($_POST['nodetitle'])) ? $_POST['nodetitle'] : '';
		
		## employee table 
		$where = "(idrninodes_master = ".$selid.")";
		$rec_master = $this->commonclass->retrive_records("rninodes_master", " * ", $where, array(), 1); 
		$rec_sel = (!empty($rec_master[0]) && count($rec_master[0])>0 ) ? $rec_master[0] : "";
		
		
			if (count($rec_sel)>0) {
					## update data from post
					$updatedata =  array(
							'status' => $newstatus, ##new status
					);
					
					## update record & insert activity on success start
					if($this->commonclass->update_record('rninodes_master', $updatedata, "idrninodes_master", $selid)) { # update record success				
						/* Inserting Activity starts here */
						$activity_table = "activitylog";
						$newstatus_log = ($newstatus == "A") ? 'Activated' : 'Retired';
						$comments = (strlen($comments)>0) ? '('.$comments.')': '' ;
						$insert_activity = array(
							'module' => 'admin',
							'type' => 'alert',
							'page' => 'RNI / Node',
							'org_rec_id' => $selid,
							'activity' => ' '.$_POST['nodetitle'].' by '.$this->loginuserdata['loginname'].' '.$comments.' ',
							'updateby' => $this->loginuserdata['loginid'],
							'updateby_name' => $this->loginuserdata['loginname']
						);
						$this->commonclass->insert_record($activity_table, $insert_activity);
						/* Inserting Activity ends here */
						$disp_msg = $_POST['nodetitle']." ".$newstatus_log." Successfully!"; 
						$this->session->set_flashdata('disp_msg', $disp_msg);
					}
					## update record & insert activity on success end
			}
			exit;
	}
	/* End of method change_emp_status */
	
	
	
	/**
	 * Users list Page for cpanel controller.
	 *
	 */
	public function users_list()
	{
		$disp_msg = $this->session->flashdata('disp_msg');
		
		$userslist =  $this->commonclass->retrive_records('users', ' * ', "(id_user > 1)",array("id_user" => "DESC"),''); # users Table
		
		
			$user_roles =  $this->commonclass->retrive_records('user_roles', ' * ', "(isactive=1)",array("iduser_role" => "DESC"),''); # users Table
			$roleslist = array();
			
			if(count($user_roles)>0) {
				foreach ($user_roles as $onerole) {
					$roleslist[$onerole['iduser_role']] = $onerole['role'];
				}
			}
			
		## ____________  Data sending to the template starts  ____________ ##
		$data['disp_msg'] = $disp_msg; # display messages
		$data['userslist'] = $userslist; # userslist
		$data['roleslist'] = $roleslist; # roleslist
		
		## ____________  Data sending to the template ends here  ____________ ##
		
		$this->load->view('layout/'.$this->sel_theam_path.'/header', $data); # html view page
		$this->load->view('admin/userslist-page', $data); # html view page
		$this->load->view('layout/'.$this->sel_theam_path.'/footer', $data); # html view page
		
		
	}
	/* End of cpanel / users_listmethod */
	
	
	
	
	/**
	 * Users list Page for cpanel controller.
	 *
	 */
	public function usersform($seluserid = 0)
	{
		$disp_msg = $this->session->flashdata('disp_msg');
		
		
			$user_roles =  $this->commonclass->retrive_records('user_roles', ' * ', "(isactive=1)",array("iduser_role" => "DESC"),''); # users Table
			$roleslist = array();
			
			if(count($user_roles)>0) {
				foreach ($user_roles as $onerole) {
					$roleslist[$onerole['iduser_role']] = $onerole['role'];
				}
			}
			
		if($seluserid > 0) {
			$usersres =  $this->commonclass->retrive_records('users', ' * ', "(id_user=".$seluserid.")",array("id_user" => "DESC"),''); # users Table
			$userslist = (!empty($usersres[0])) ? $usersres[0] : array();
		} else {
			$userslist = array();
		}
		
		if (!empty($_POST['submit']) && $_POST['submit'] == "Save") {
			
			
			if($seluserid == 0) {
				
				$password = md5(strtolower($_POST['username']));
				$formdata = array(
								'id_role' => $_POST['id_role'],
								'username' => $_POST['username'],
								'password' => $password,
								'firstname' => $_POST['firstname'],
								'lastname' => $_POST['lastname'],
								'email' => $_POST['email'],
								'contact' => $_POST['contact'],
								'isactive' => 1,
								'createdon' => date('Y-m-d'),
								'createdby' => $this->loginuserdata['loginid']
							);
				if($this->commonclass->insert_record("users", $formdata)) {
					$activitydata = array(
								'module' => 'admin',
								'type' => 'Activity',
								'page' => 'C-Panel',
								'empid' => '',
								'activity' => "New user (".ucwords(strtolower($_POST['firstname']." ".$_POST['lastname'])).") added by admin ",
								'updateby' => $this->loginuserdata['loginid']
							);
					$this->commonclass->insert_record("activitylog", $activitydata);
						$disp_msg = 'User details saved successfully';
				}
			} else if ($seluserid > 0) {
				
					$formdata = array(
								'id_role' => $_POST['id_role'],
								'username' => $_POST['username'],
								'firstname' => $_POST['firstname'],
								'lastname' => $_POST['lastname'],
								'email' => $_POST['email'],
								'contact' => $_POST['contact'],
								/*'isactive' => $_POST['isactive'],*/
								'updateon' => date('Y-m-d'),
								'updateby' => $this->loginuserdata['loginid']
							);
				
					if($this->commonclass->update_record("users", $formdata, "id_user", $seluserid)) { # update record success
						$activitydata = array(
									'module' => 'admin',
									'type' => 'Alert',
									'page' => 'C-Panel',
									'empid' => '',
									'activity' => "User (".ucwords(strtolower($_POST['firstname']." ".$_POST['lastname'])).") details updated by admin (".$_POST['comments'].")",
									'updateby' => $this->loginuserdata['loginid'],
									'updateby_name' => $this->loginuserdata['loginname']
								);
						$this->commonclass->insert_record("activitylog", $activitydata);
						$disp_msg = 'User details updated successfully';
					}
				}
				
					$this->session->set_flashdata('disp_msg', $disp_msg);
					redirect('/cpanel/users_list', 'refresh');
			
			}
		
		
		## ____________  Data sending to the template starts  ____________ ##
		$data['disp_msg'] = $disp_msg; # display messages
		$data['userslist'] = $userslist; # userslist
		$data['roleslist'] = $roleslist; # roleslist
		$data['seluserid'] = $seluserid; # seluserid
		
		## ____________  Data sending to the template ends here  ____________ ##
		
		$this->load->view('layout/'.$this->sel_theam_path.'/header', $data); # html view page
		$this->load->view('admin/usersform-page', $data); # html view page
		$this->load->view('layout/'.$this->sel_theam_path.'/footer', $data); # html view page
		
		
	}
	/* End of cpanel / users_listmethod */
	
	
	/**
	 * Change employee status function
	 *
	 * JQUERY function
	 */
	public function change_user_status($userid, $newstatus)
	{
		## comments from post
		$comments = (!empty($_POST['comments'])) ? $_POST['comments'] : '';
		
		## employee table 
		$where = "(id_user = ".$userid.")";
		$rec_master = $this->commonclass->retrive_records("users", " * ", $where, array(), 1); 
		$rec_sel = (!empty($rec_master[0]) && count($rec_master[0])>0 ) ? $rec_master[0] : "";
		
			if (count($rec_sel)>0) {
					## update data from post
					$updatedata =  array(
							'isactive' => $newstatus, ##new status
					);
					
					## update record & insert activity on success start
					if($this->commonclass->update_record('users', $updatedata, "id_user", $userid)) { # update record success				
						/* Inserting Activity starts here */
						$activity_table = "activitylog";
						$comments = (strlen($comments)>0) ? '('.$comments.')': '' ;
						$insert_activity = array(
							'module' => 'admin',
							'type' => 'alert',
							'page' => 'users',
							'org_rec_id' => $userid,
							'empid' => $userid,
							'activity' => ' '.$logtitle.' by '.$this->loginuserdata['loginname'].' '.$comments.' ',
							'updateby' => $this->loginuserdata['loginid']
						);
						$this->commonclass->insert_record($activity_table, $insert_activity);
						/* Inserting Activity ends here */
						$disp_msg = "User ".$logtitle." Successfully!"; 
						$this->session->set_flashdata('disp_msg', $disp_msg);
					}
					## update record & insert activity on success end
			}
			exit;
	}
	/* End of method change_emp_status */
	
	
	
	
	/**
	 * Users list Page for cpanel controller.
	 *
	 */
	public function userroles_list()
	{
		$disp_msg = $this->session->flashdata('disp_msg');
		
		$userroleslist =  $this->commonclass->retrive_records('user_roles', ' * ', "",array("iduser_role" => "DESC"),''); # users Table
		
		## ____________  Data sending to the template starts  ____________ ##
		$data['disp_msg'] = $disp_msg; # display messages
		$data['userroleslist'] = $userroleslist; # postpatch_schedule
		
		## ____________  Data sending to the template ends here  ____________ ##
		
		$this->load->view('layout/'.$this->sel_theam_path.'/header', $data); # html view page
		$this->load->view('admin/userroleslist-page', $data); # html view page
		$this->load->view('layout/'.$this->sel_theam_path.'/footer', $data); # html view page
		
		
	}
	/* End of cpanel / userroles_list method */
	
	
	/**
	 * userrolesform Page for cpanel controller.
	 *
	 */
	public function userrolesform($selid = 0)
	{
		$disp_msg = $this->session->flashdata('disp_msg');
		
			
		if($selid > 0) {
			$userroles =  $this->commonclass->retrive_records('user_roles', ' * ', "(iduser_role = ".$selid.")",array("iduser_role" => "DESC"),''); # user roles Table
			$userroleslist = (!empty($userroles[0])) ? $userroles[0] : array();
		} else {
			$userroleslist = array();
		}
		
		
		
		if (!empty($_POST['submit']) && $_POST['submit'] == "Save") {
			
			
			if($selid == 0) {
				
				$formdata = array(
								'role' => $_POST['role'],
								'isactive' => 1
							);
				if($this->commonclass->insert_record("user_roles", $formdata)) {
					$activitydata = array(
									'module' => 'admin',
									'type' => 'Activity',
									'page' => 'C-Panel',
									'empid' => '',
									'activity' => "User role (".ucwords(strtolower($_POST['role'])).") added by admin",
									'updateby' => $this->loginuserdata['loginid']
								);
					$this->commonclass->insert_record("activitylog", $activitydata);
				}
			} else if ($selid > 0) {
				
					$formdata = array(
								'role' => $_POST['role'],
								/*'isactive' => $_POST['isactive'],*/
								'updateon' => date('Y-m-d'),
								'updateby' => $this->loginuserdata['loginid']
							);
				
					if($this->commonclass->update_record("user_roles", $formdata, "iduser_role", $selid)) { # update record success
						$activitydata = array(
										'module' => 'admin',
										'type' => 'Alert',
										'page' => 'C-Panel',
										'empid' => '',
										'activity' => "User role (".ucwords(strtolower($_POST['role'])).") updated by admin",
										'updateby' => $this->loginuserdata['loginid']
									);
						$this->commonclass->insert_record("activitylog", $activitydata);
					}
				}
			
			}
			
			
		## ____________  Data sending to the template starts  ____________ ##
		$data['disp_msg'] = $disp_msg; # display messages
		$data['userroleslist'] = $userroleslist; # userroleslist
		$data['selid'] = $selid; # selid
		
		## ____________  Data sending to the template ends here  ____________ ##
		
		$this->load->view('layout/'.$this->sel_theam_path.'/header', $data); # html view page
		$this->load->view('admin/userrolesform-page', $data); # html view page
		$this->load->view('layout/'.$this->sel_theam_path.'/footer', $data); # html view page
		
		
	}
	/* End of cpanel / userrolesformmethod */
	
	
	/**
	 * modules_list Page for cpanel controller.
	 *
	 */
	public function modules_list()
	{
		$disp_msg = $this->session->flashdata('disp_msg');
		
		$module_masterlist =  $this->commonclass->retrive_records('module_master', ' * ', "",array("idmodule_master" => "DESC"),''); # users Table
		
		## ____________  Data sending to the template starts  ____________ ##
		$data['disp_msg'] = $disp_msg; # display messages
		$data['module_masterlist'] = $module_masterlist; # postpatch_schedule
		
		## ____________  Data sending to the template ends here  ____________ ##
		
		$this->load->view('layout/'.$this->sel_theam_path.'/header', $data); # html view page
		$this->load->view('admin/moduleslist-page', $data); # html view page
		$this->load->view('layout/'.$this->sel_theam_path.'/footer', $data); # html view page
		
		
	}
	/* End of cpanel / modules_list method */
	
	
	/**
	 * modulesform Page for cpanel controller.
	 *
	 */
	public function modulesform($selmodule = 0)
	{
		$disp_msg = $this->session->flashdata('disp_msg');
		
		if ($selmodule > 0) {			
			$modulemaster =  $this->commonclass->retrive_records('module_master', ' * ', "(idmodule_master = ".$selmodule.")",array(),1); # modules Table
			$modulemaster = !empty($modulemaster[0]) ? $modulemaster[0] : array() ;
		} else {
			$modulemaster = array();
		}
		
		
		if (!empty($_POST['submit']) && $_POST['submit'] == "Save") {
			
			
			if($selmodule == 0) {
				
				$formdata = array(
								'module' => $_POST['module'],
								'uristring' => $_POST['uristring'],
								'isactive' => 1
							);
				if($this->commonclass->insert_record("module_master", $formdata)) {
					$activitydata = array(
									'module' => 'admin',
									'type' => 'Activity',
									'page' => 'C-Panel',
									'empid' => '',
									'activity' => "Module (".ucwords(strtolower($_POST['module'])).") added by admin",
									'updateby' => $this->loginuserdata['loginid']
								);
					$this->commonclass->insert_record("activitylog", $activitydata);
				}
			} else if ($selmodule > 0) {
				
					$formdata = array(
								'module' => $_POST['module'],
								'uristring' => $_POST['uristring'],
								'updateon' => date('Y-m-d'),
								'updateby' => $this->loginuserdata['loginid']
							);
				
					if($this->commonclass->update_record("module_master", $formdata, "idmodule_master", $selmodule)) { # update record success
						$activitydata = array(
										'module' => 'admin',
										'type' => 'Alert',
										'page' => 'C-Panel',
										'empid' => '',
										'activity' => "Module (".ucwords(strtolower($_POST['role'])).") updated by admin",
										'updateby' => $this->loginuserdata['loginid']
									);
						$this->commonclass->insert_record("activitylog", $activitydata);
					}
				}
			
			}
		
		## ____________  Data sending to the template starts  ____________ ##
		$data['disp_msg'] = $disp_msg; # display messages
		$data['selmodule'] = $selmodule; # display messages
		$data['modulemaster'] = $modulemaster; # postpatch_schedule
		
		## ____________  Data sending to the template ends here  ____________ ##
		
		$this->load->view('layout/'.$this->sel_theam_path.'/header', $data); # html view page
		$this->load->view('admin/modulesform-page', $data); # html view page
		$this->load->view('layout/'.$this->sel_theam_path.'/footer', $data); # html view page
		
		
	}
	/* End of cpanel / modulesform method */
	
	
	/**
	 * modulesform Page for cpanel controller.
	 *
	 */
	public function siteconfigsform()
	{
		$disp_msg = $this->session->flashdata('disp_msg');
		
		$siteconfigres =  $this->commonclass->retrive_records('siteconfig', ' * ', "",array("idsiteconfig" => "DESC"), 1); # users Table
		$siteconfigs = !empty($siteconfigres[0]) ? $siteconfigres[0] : array() ;
		
		
		if (!empty($_POST['submit']) && $_POST['submit'] == "Save") {
			
			
			if(empty($siteconfigs) && $siteconfigs == array()) {
				
				$formdata = array(
								'portalname' => $_POST['portalname'],
								'baseurl' => $_POST['baseurl'],
								'title' => $_POST['title'],
								'baseurl' => $_POST['baseurl'],
								'offlinestatus' => $_POST['offlinestatus'],
								'offlinemessage' => $_POST['offlinemessage'],
								'adminmailid' => $_POST['adminmailid'],
								'reportemails' => $_POST['reportemails'],
								'verificationemails' => $_POST['verificationemails'],
								'dateformat' => $_POST['dateformat'],
								'sendemails' => $_POST['sendemails'],
								'updateon' => date('Y-m-d'),
								'updateby' => $this->loginuserdata['loginid']
							);
					if($this->commonclass->insert_record("siteconfig", $formdata)) { # insert record success
						$activitydata = array(
								'module' => 'admin',
								'type' => 'Activity',
								'page' => 'C-Panel',
								'empid' => '',
								'activity' => "Site configurations added by ".$this->loginuserdata['loginname']." ",
								'updateby' => $this->loginuserdata['loginid'],
								'updateby_name' => $this->loginuserdata['loginname']
							);
						$this->commonclass->insert_record("activitylog", $activitydata);
						$disp_msg = 'Site configurations saved successfully!';
						$this->session->set_flashdata('disp_msg', $disp_msg);
				
					}
			} else if (!empty($siteconfigs) && count($siteconfigs)>0) {
				$editid = 1;
					$formdata = array(
									'portalname' => $_POST['portalname'],
									'baseurl' => $_POST['baseurl'],
									'title' => $_POST['title'],
									'baseurl' => $_POST['baseurl'],
									'offlinestatus' => $_POST['offlinestatus'],
									'offlinemessage' => $_POST['offlinemessage'],
									'adminmailid' => $_POST['adminmailid'],
									'reportemails' => $_POST['reportemails'],
									'verificationemails' => $_POST['verificationemails'],
									'dateformat' => $_POST['dateformat'],
									'sendemails' => $_POST['sendemails'],
									'updateon' => date('Y-m-d'),
									'updateby' => $this->loginuserdata['loginid']
								);
				
					if($this->commonclass->update_record("siteconfig", $formdata, "idsiteconfig", $editid)) { # update record success
					
						$activitydata = array(
								'module' => 'admin',
								'type' => 'Alert',
								'page' => 'C-Panel',
								'empid' => '',
								'activity' => "Site configurations updated by ".$this->loginuserdata['loginname']." ",
								'updateby' => $this->loginuserdata['loginid'],
								'updateby_name' => $this->loginuserdata['loginname']
							);
						$this->commonclass->insert_record("activitylog", $activitydata);
						$disp_msg = 'Site configurations saved successfully!';
						$this->session->set_flashdata('disp_msg', $disp_msg);
				
					}
				}
				
				
				redirect(current_url());	 # redirect to samepage	
			
			}
		
		
		
		
		
		## ____________  Data sending to the template starts  ____________ ##
		$data['disp_msg'] = $disp_msg; # display messages
		$data['siteconfigs'] = $siteconfigs; # siteconfigs
		
		## ____________  Data sending to the template ends here  ____________ ##
		
		$this->load->view('layout/'.$this->sel_theam_path.'/header', $data); # html view page
		$this->load->view('admin/siteconfigsform-page', $data); # html view page
		$this->load->view('layout/'.$this->sel_theam_path.'/footer', $data); # html view page
		
		
	}
	/* End of cpanel / modulesform method */
	
	
	public function addrnis($seluserid = "") {
		
	
		$disp_msg = $this->session->flashdata('disp_msg');
	
		$userslist_drop =  $this->commonclass->retrive_records('users', ' id_user,username', "(id_user > 1)",array("id_user" => "DESC"),''); # users Table
		
			$user = array();
			if(count($userslist_drop)>0){
				$i =1;
				foreach($userslist_drop as $singledrop){
					
					$user[$i]['id_user'] = $singledrop['id_user'];
					$user[$i]['username'] = $singledrop['username'];
					//$user[$i]['rninodes'] = $singledrop['rninodes'];
					$i++;
				}
			}

			$user_roles =  $this->commonclass->retrive_records('user_roles', ' * ', "(isactive=1)",array("iduser_role" => "DESC"),''); # users Table
			$roleslist = array();
			
			if(count($user_roles)>0) {
				foreach ($user_roles as $onerole) {
					$roleslist[$onerole['iduser_role']] = $onerole['role'];
				}
			}
			
		if($seluserid > 0) {
			$usersres =  $this->commonclass->retrive_records('users', ' * ', "(id_user=".$seluserid.")",array("id_user" => "DESC"),''); # users Table
			$userslist = (!empty($usersres[0])) ? $usersres[0] : array();
		} else {
			$userslist = array();
		}
		
		## RNI/Nodes Display Query Start Here 
		
			$rninodes =  $this->commonclass->retrive_records('rninodes_master', 'idrninodes_master,rniname', "(status='A' and (dpa_id IN (0)))",array("rniname" =>"asc"),''); 
			$rninodes_user =  $this->commonclass->retrive_records('rninodes_master', 'idrninodes_master,rniname', "(status='A' and (dpa_id IN ($seluserid)))",array("idrninodes_master" =>"asc"),''); 
			
				
			if (!empty($_POST['submit']) && $_POST['submit'] == "Save") {
				$seluserninodes = array();
				if (!empty($rninodes_user)) {
					foreach ($rninodes_user as $newval) {
						$seluserninodes[] = $newval['idrninodes_master'];
					}
				}
				$selusernodes = implode(", ", $seluserninodes);
				if ((!empty($_POST['id_user']) && $_POST['id_user'] > 0) && (!empty($_POST['sel_nodes']) && count($_POST['sel_nodes'])>0)  ) {
					$selec_user = explode("___", $_POST['id_user']);	
					$selectednodes = implode(", ", $_POST['sel_nodes']);
					if(!empty($seluserninodes)) {
						$run_query1 = "UPDATE rninodes_master SET dpa_id = '0' , dpa_name = '' where idrninodes_master in (".$selusernodes.") ";
						$query_result = $this->db->query($run_query1);
					}
					$run_query = "UPDATE rninodes_master SET dpa_id = '".$selec_user[0]."' , dpa_name = '".$selec_user[1]."' where idrninodes_master in (".$selectednodes.") ";	
					$query_result = $this->db->query($run_query);
					$disp_msg = 'RNI/ Nodes saved successfully!';
					$this->session->set_flashdata('disp_msg', $disp_msg);	
					redirect('admin/cpanel/addrnis/'.$seluserid, 'refresh');
				}
			
			}	
			
		
					
				
		
		## RNI/Nodes Display Query End Here
		
		//echo"<pre>"; print_r($userslist); echo"</pre>";
		## ____________  Data sending to the template starts  ____________ ##
		$data['disp_msg'] = $disp_msg; # display messages
		$data['userslist'] = $userslist; # userslist
		$data['roleslist'] = $roleslist; # roleslist
		$data['seluserid'] = $seluserid; # seluserid
		$data['rninodes'] = $rninodes; # seluserid
		$data['seluserrninodes'] = $rninodes_user; # seluserid
		$data['user'] = $user; # userslist
		
		## ____________  Data sending to the template ends here  ____________ ##
		
		$this->load->view('layout/'.$this->sel_theam_path.'/header', $data); # html view page
		$this->load->view('admin/addrnis-page', $data); # html view page
		$this->load->view('layout/'.$this->sel_theam_path.'/footer', $data); # html view page
	}
	
		
}

/* End of file cpanel.php */
/* Location: ./application/controllers/cpanel.php */
