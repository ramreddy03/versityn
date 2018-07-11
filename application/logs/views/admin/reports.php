<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reports extends CI_Controller {
/*
		__construct will execute for each and every method of this controller
	*/
	
	public function __construct()
	{
		parent::__construct();
			   
			$this->baseurl = $this->config->item('base_url'); #base url path
			$this->load->library('commonclass'); #loading comonclass library
			$this->load->library('session'); #loading session library
			$this->load->library('excel'); #loading session library
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
	 * Index Page for Dashboard controller.
	 *
	 */
	public function index()
	{
		
		$disp_msg = $this->session->flashdata('disp_msg');
		
		
		$search_filters = array();
		$search_results = array();
		
		$search_query = "SELECT * FROM postpatch_schedule WHERE 1=1 AND isdeleted=0  ";
		
		if (!empty($_POST)) {
			if(!empty($_POST['dpa_flexinet_id']) && count($_POST['dpa_flexinet_id'])>0) {
				$dpavals = implode("' , '", $_POST['dpa_flexinet_id']);
				$search_query .= " AND dpa_flexinet IN ('".$dpavals."') ";
			}
			
			if(!empty($_POST['patchingstatus']) && count($_POST['patchingstatus'])>0) {
				$patchingstatus = implode("' , '", $_POST['patchingstatus']);
				$search_query .= " AND patchingstatus IN ('".$patchingstatus."') ";
			}
			
			if(!empty($_POST['verificationstatus']) && count($_POST['verificationstatus'])>0) {
				$verfstatusvals = implode("' , '", $_POST['verificationstatus']);
				$search_query .= " AND verificationstatus IN ('".$verfstatusvals."') ";
			}
			
			if(!empty($_POST['scheduledate']) && count($_POST['scheduledate'])>0) {
				$scdvals = implode("' , '", $_POST['scheduledate']);
				$search_query .= " AND scheduledate IN ('".$scdvals."') ";
			}
		} else {
			$search_query .= " AND scheduledate = (SELECT MAX(scheduledate) FROM postpatch_schedule) ";
		
		}
		
		$search_query_res = $this->commonclass->execute_rawquery($search_query);
		$queryresults = $search_query_res->result_array();
		
		if (!empty($queryresults) && count($queryresults)>0) {
			foreach ($queryresults as $onerecord) {
				$scheduledate = ($onerecord['scheduledate'] != "0000-00-00") ? $this->commonclass->dateformat1($onerecord['scheduledate']) : "00/00/0000";
				$verifiedon = ($onerecord['verifiedon'] != "0000-00-00") ? $this->commonclass->dateformat1($onerecord['verifiedon']) : "00/00/0000";
				
				$search_results['dpawise'][$onerecord['dpa_flexinet']][$onerecord['idpostpatch_schedule']]['scheduledate'] = $scheduledate;
				$search_results['dpawise'][$onerecord['dpa_flexinet']][$onerecord['idpostpatch_schedule']]['time'] = $onerecord['time'];
				$search_results['dpawise'][$onerecord['dpa_flexinet']][$onerecord['idpostpatch_schedule']]['rni_node'] = $onerecord['rni_node'];
				$search_results['dpawise'][$onerecord['dpa_flexinet']][$onerecord['idpostpatch_schedule']]['patchingstatus'] = $onerecord['patchingstatus'];
				$search_results['dpawise'][$onerecord['dpa_flexinet']][$onerecord['idpostpatch_schedule']]['verificationstatus'] = $onerecord['verificationstatus'];
				$search_results['dpawise'][$onerecord['dpa_flexinet']][$onerecord['idpostpatch_schedule']]['verifiedcomments'] = $onerecord['verifiedcomments'];
				$search_results['dpawise'][$onerecord['dpa_flexinet']][$onerecord['idpostpatch_schedule']]['verifiedon'] = $onerecord['verifiedon'];
				$search_results['dpawise'][$onerecord['dpa_flexinet']][$onerecord['idpostpatch_schedule']]['verified_tomail'] = $onerecord['verified_tomail'];
				
				$search_results['datewise'][$scheduledate][$onerecord['idpostpatch_schedule']]['dpa_flexinet'] = $onerecord['dpa_flexinet'];
				$search_results['datewise'][$scheduledate][$onerecord['idpostpatch_schedule']]['time'] = $onerecord['time'];
				$search_results['datewise'][$scheduledate][$onerecord['idpostpatch_schedule']]['rni_node'] = $onerecord['rni_node'];
				$search_results['datewise'][$scheduledate][$onerecord['idpostpatch_schedule']]['patchingstatus'] = $onerecord['patchingstatus'];
				$search_results['datewise'][$scheduledate][$onerecord['idpostpatch_schedule']]['verificationstatus'] = $onerecord['verificationstatus'];
				$search_results['datewise'][$scheduledate][$onerecord['idpostpatch_schedule']]['verifiedcomments'] = $onerecord['verifiedcomments'];
				$search_results['datewise'][$scheduledate][$onerecord['idpostpatch_schedule']]['verifiedon'] = $onerecord['verifiedon'];
				$search_results['datewise'][$scheduledate][$onerecord['idpostpatch_schedule']]['verified_tomail'] = $onerecord['verified_tomail'];
			}
		}
		//echo "<pre>"; print_r($search_results); echo "</pre>";
		
		$dpa_emps =  $this->commonclass->retrive_records('postpatch_schedule', ' DISTINCT(dpa_flexinet) as dpa_flexinet ', "",array("dpa_flexinet" => "ASC"),'');
		if (count($dpa_emps)>0) {
			foreach($dpa_emps as $onedpa) {
				$search_filters['dpa'][] = $onedpa['dpa_flexinet'];
			}		
		}
		
		
		$verf_status_res =  $this->commonclass->retrive_records('postpatch_schedule', ' DISTINCT(verificationstatus) as verificationstatus ', "",array("dpa_flexinet" => "ASC"),'');
		if (count($verf_status_res)>0) {
			foreach($verf_status_res as $oneverif) {
				$search_filters['verf_status'][] = $oneverif['verificationstatus'];
			}		
		}
		
		
		$verf_status_res =  $this->commonclass->retrive_records('postpatch_schedule', ' DISTINCT(patchingstatus) as patchingstatus ', "",array("dpa_flexinet" => "ASC"),'');
		if (count($verf_status_res)>0) {
			foreach($verf_status_res as $oneverif) {
				$search_filters['patchingstatus'][] = $oneverif['patchingstatus'];
			}		
		}
		
		
		
		$scheduledate_res =  $this->commonclass->retrive_records('postpatch_schedule', ' DISTINCT(scheduledate) as scheduledate ', "",array("scheduledate" => "DESC"),'');
		if (count($scheduledate_res)>0) {
			foreach($scheduledate_res as $oneverif1) {
				$search_filters['scheduledates'][$oneverif1['scheduledate']] = ($oneverif1['scheduledate'] != "0000-00-00") ? $this->commonclass->dateformat1($oneverif1['scheduledate']) : "00/00/0000";
			}		
		}
		
		
		
		//echo "<pre>"; print_r($search_filters); echo "</pre>";
		
		## ____________  Data sending to the template starts  ____________ ##
		$data['disp_msg'] = $disp_msg; # display messages
		$data['search_filters'] = $search_filters; # search_filters
		$data['search_results'] = $search_results; # search_filters
		//$data['postpatch_uploads'] = $postpatch_uploads; # postpatch_schedule
		
		## ____________  Data sending to the template ends here  ____________ ##
		
		$this->load->view('layout/'.$this->sel_theam_path.'/header', $data); # html view page
		$this->load->view('admin/report2-page', $data); # html view page
		$this->load->view('layout/'.$this->sel_theam_path.'/footer', $data); # html view page
	}
	/* End of dashboard / index method */
		
	/**
	 * basicreport Page for Dashboard controller.
	 *
	 */
	public function basicreport()
	{
		
		$disp_msg = $this->session->flashdata('disp_msg');
		
		
		$search_filters = array();
		$search_results = array();
		
		$search_query = "SELECT * FROM postpatch_schedule WHERE 1=1 ";
		
		if (!empty($_POST)) {
			if(!empty($_POST['dpa_flexinet_id']) && count($_POST['dpa_flexinet_id'])>0) {
				$dpavals = implode("' , '", $_POST['dpa_flexinet_id']);
				$search_query .= " AND dpa_flexinet IN ('".$dpavals."') ";
			}
			
			if(!empty($_POST['verificationstatus']) && count($_POST['verificationstatus'])>0) {
				$verfstatusvals = implode("' , '", $_POST['verificationstatus']);
				$search_query .= " AND verificationstatus IN ('".$verfstatusvals."') ";
			}
			
			if(!empty($_POST['scheduledate']) && count($_POST['scheduledate'])>0) {
				$scdvals = implode("' , '", $_POST['scheduledate']);
				$search_query .= " AND scheduledate IN ('".$scdvals."') ";
			}
		}
		
		$search_query_res = $this->commonclass->execute_rawquery($search_query);
		$search_results = $search_query_res->result_array();
		
		$dpa_emps =  $this->commonclass->retrive_records('postpatch_schedule', ' DISTINCT(dpa_flexinet) as dpa_flexinet ', "",array("dpa_flexinet" => "ASC"),'');
		if (count($dpa_emps)>0) {
			foreach($dpa_emps as $onedpa) {
				$search_filters['dpa'][] = $onedpa['dpa_flexinet'];
			}		
		}
		
		
		$verf_status_res =  $this->commonclass->retrive_records('postpatch_schedule', ' DISTINCT(verificationstatus) as verificationstatus ', "",array("dpa_flexinet" => "ASC"),'');
		if (count($verf_status_res)>0) {
			foreach($verf_status_res as $oneverif) {
				$search_filters['verf_status'][] = $oneverif['verificationstatus'];
			}		
		}
		
		
		
		$scheduledate_res =  $this->commonclass->retrive_records('postpatch_schedule', ' DISTINCT(scheduledate) as scheduledate ', "",array("dpa_flexinet" => "ASC"),'');
		if (count($scheduledate_res)>0) {
			foreach($scheduledate_res as $oneverif1) {
				$search_filters['scheduledates'][$oneverif1['scheduledate']] = ($oneverif1['scheduledate'] != "0000-00-00") ? $this->commonclass->dateformat1($oneverif1['scheduledate']) : "00/00/0000";
			}		
		}
		
		
		
		## ____________  Data sending to the template starts  ____________ ##
		$data['disp_msg'] = $disp_msg; # display messages
		$data['search_filters'] = $search_filters; # search_filters
		$data['search_results'] = $search_results; # search_filters
		//$data['postpatch_uploads'] = $postpatch_uploads; # postpatch_schedule
		
		## ____________  Data sending to the template ends here  ____________ ##
		
		$this->load->view('layout/'.$this->sel_theam_path.'/header', $data); # html view page
		$this->load->view('admin/report1-page', $data); # html view page
		$this->load->view('layout/'.$this->sel_theam_path.'/footer', $data); # html view page
	}
	/* End of dashboard / index method */
	
	
	/**
	 * basicreport Page for Dashboard controller.
	 *
	 */
	public function exporttoxl($daterdpa)
	{
		
		$search_filters = array();
		$search_results = array();
		
		
		
		$search_query = "SELECT * FROM postpatch_schedule WHERE 1=1 and isdeleted = 0";
	
		$search_query_res = $this->commonclass->execute_rawquery($search_query);
		$queryresults = $search_query_res->result_array();
		
		if (!empty($queryresults) && count($queryresults)>0) {
			foreach ($queryresults as $onerecord) {
				
				$scheduledate = ($onerecord['scheduledate'] != "0000-00-00") ? $this->commonclass->dateformat3($onerecord['scheduledate']) : "00/00/0000";
				$verifiedon = ($onerecord['verifiedon'] != "0000-00-00") ? $this->commonclass->dateformat1($onerecord['verifiedon']) : "00/00/0000";
				
				if ($daterdpa == 'dpawise') {
				$heads_all = array('Date', 'Time', 'RNI / Node', 'Patching Status', 'Verification Status', 'Verified On', 'Verification issue email sent to', 'Verification Comments');
				
				$search_results[$onerecord['dpa_flexinet']][$onerecord['idpostpatch_schedule']]['scheduledate'] = $scheduledate;
				$search_results[$onerecord['dpa_flexinet']][$onerecord['idpostpatch_schedule']]['time'] = $onerecord['time'];
				$search_results[$onerecord['dpa_flexinet']][$onerecord['idpostpatch_schedule']]['rni_node'] = $onerecord['rni_node'];
				//$search_results[$onerecord['dpa_flexinet']][$onerecord['idpostpatch_schedule']]['dpa_flexinet'] = $onerecord['dpa_flexinet'];
				$search_results[$onerecord['dpa_flexinet']][$onerecord['idpostpatch_schedule']]['patchingstatus'] = $onerecord['patchingstatus'];
				$search_results[$onerecord['dpa_flexinet']][$onerecord['idpostpatch_schedule']]['verificationstatus'] = $onerecord['verificationstatus'];
				$search_results[$onerecord['dpa_flexinet']][$onerecord['idpostpatch_schedule']]['verifiedon'] = $verifiedon;
				$search_results[$onerecord['dpa_flexinet']][$onerecord['idpostpatch_schedule']]['verified_tomail'] = $onerecord['verified_tomail'];
				$search_results[$onerecord['dpa_flexinet']][$onerecord['idpostpatch_schedule']]['verifiedcomments'] = $onerecord['verifiedcomments'];
				
				/*
				$month_name_disp = $scheduledate;
				$heads[$onerecord['dpa_flexinet']] = $heads_all;
				$worksheet_names[$onerecord['dpa_flexinet']] = $month_name_disp;
				$mainheading[$onerecord['dpa_flexinet']] = "Post patching verification details for ".$month_name_disp;
				*/
				
				} else if ($daterdpa == 'datewise') {
				$heads_all = array('Time', 'RNI / Node', 'Patching Status', 'Verifier', 'Verification Status', 'Verification Comments', 'Verified On');	
				//$search_results[$scheduledate][$onerecord['idpostpatch_schedule']]['scheduledate'] = $scheduledate;
				$search_results[$scheduledate][$onerecord['idpostpatch_schedule']]['time'] = $onerecord['time'];
				$search_results[$scheduledate][$onerecord['idpostpatch_schedule']]['rni_node'] = $onerecord['rni_node'];
				$search_results[$scheduledate][$onerecord['idpostpatch_schedule']]['patchingstatus'] = $onerecord['patchingstatus'];
				$search_results[$scheduledate][$onerecord['idpostpatch_schedule']]['dpa_flexinet'] = $onerecord['dpa_flexinet'];
				$search_results[$scheduledate][$onerecord['idpostpatch_schedule']]['verificationstatus'] = $onerecord['verificationstatus'];
				$search_results[$scheduledate][$onerecord['idpostpatch_schedule']]['verifiedon'] = $verifiedon;
				$search_results[$scheduledate][$onerecord['idpostpatch_schedule']]['verified_tomail'] = $onerecord['verified_tomail'];
				$search_results[$scheduledate][$onerecord['idpostpatch_schedule']]['verifiedcomments'] = $onerecord['verifiedcomments'];
				
				
					/*$heads[$onerecord['dpa_flexinet']] = $heads_all;
					$worksheet_names[$onerecord['dpa_flexinet']] = $onerecord['dpa_flexinet'];
					$mainheading[$onerecord['dpa_flexinet']] = "Post patching verification details of ".$onerecord['dpa_flexinet'];
					*/
				}
				
			
			}
		}
		
		
		$totalarrkeys = array_keys($search_results);
		
		if (count($totalarrkeys)>0) {
			foreach($totalarrkeys as $onekey) {
				$heads[] = $heads_all;
				$worksheet_names[] = $onekey;
				$mainheading[] = "Post patching & verification details of ".$onekey;
				$data4xl[] = $search_results[$onekey];
			}				
		}
		
		
		
		
	//	echo "<pre>"; print_r($search_results); echo "</pre>";
		
		$nosheets = count($heads);
		$data['data'] = $data4xl;
		$data['nosheets'] = $nosheets;
		$data['heads'] = $heads;
		$data['worksheet_names'] = $worksheet_names;
		$data['mainheading'] = $mainheading;
		$data['filename'] = "Postpatch_verification_".date('m_d_Y'); ## no need of .xls here
		//$data['data'] = $search_results;
		//echo "<pre>"; print_r($data); echo "</pre>"; exit;
		$this->load->view('admin/export-multi-excel', $data);
		
		
	}
		
	
	
	
	
	
	
}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */
