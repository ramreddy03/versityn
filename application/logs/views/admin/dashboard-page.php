<?php $this->load->view('layout/'.$this->sel_theam_path.'/leftmenu'); ?>

<!-- PAGE LEVEL STYLES -->
<link href="<?php echo $this->baseurl;?>assets/default/css/layout2.css" rel="stylesheet" />
<link href="<?php echo $this->baseurl;?>assets/plugins/flot/examples/examples.css" rel="stylesheet" />
<link rel="stylesheet" href="<?php echo $this->baseurl;?>assets/plugins/timeline/timeline.css" />
<!-- END PAGE LEVEL  STYLES -->
    

	<!--PAGE CONTENT -->
        <div id="content">
             
            <div class="inner" style="min-height: 700px;">
                <div class="row">
                    <div class="col-lg-12">
                        <h1> Admin Dashboard </h1>
                    </div>
                </div>
                 

                 <!--TABLE, PANEL, ACCORDION AND MODAL  -->
                          <div class="row">
							  
							  <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                              <span style="float:left; color: #FFFFFF!important; font-size: 14px; margin-right: 15px!important; font-weight:bold;"> Post Patching & Verification</span>
                               &nbsp; <?php echo anchor("admin/dashboard/addverification", '<span style="float:right; color: #FFFFFF!important; font-size: 12px; margin-left: 15px!important; text-decoration: underline; font-weight:bold;">Add scheduling</span>', array('title'=>'Add scheduling')); ?> &nbsp; &nbsp; 
                              <select id="portalyear" style="float:right; ">
								  <?php for($startyear=$this->siteconfigs['startyear']; $startyear<=date('Y'); $startyear++) { ?>
									<option value="<?php echo $startyear; ?>"><?php echo $startyear; ?></option>
								  <?php } ?>
                              </select>
                              &nbsp;
                            </div>
                            <div class="panel-body">
								<?php
										if(!empty($disp_msg)) {
									?>
										<h4 class="text-success" style="text-align:center"><?php echo $disp_msg; ?></h4><br/>
									<?php
										}
									?>
                                <div class="table-responsive">
                                  
                                  <div id="sortableTable" class="body collapse in">
                                <table class="table table-bordered sortableTable responsive-table" id ="dashboard-table">
                                    <thead>
                                        <tr>
                                            <th width="20%">Schedule date<i class="icon-sort"></i><i class="icon-sort-down"></i> <i class="icon-sort-up"></i></th>
                                            <th width="20%">Total Nodes<i class="icon-sort"></i><i class="icon-sort-down"></i> <i class="icon-sort-up"></i></th>
                                            <th width="23%">Patching Status<i class="icon-sort"></i><i class="icon-sort-down"></i> <i class="icon-sort-up"></i></th>
                                            <th width="27%">Verification Status<i class="icon-sort"></i><i class="icon-sort-down"></i> <i class="icon-sort-up"></i></th>
											<th width="7%"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
										
										<?php
											if (count($postpatch_uploads)>0) {
												foreach ($postpatch_uploads as $oneschedule) {
													
													$actions1 = "";
													
													$scheduledate = (!empty($oneschedule['scheduledon']) && $oneschedule['scheduledon'] != "0000-00-00") ? $this->commonclass->dateformat1($oneschedule['scheduledon']) : "00/00/0000";
													
													$createdon = (!empty($oneschedule['createdon']) && $oneschedule['createdon'] != "0000-00-00") ? $this->commonclass->dateformat1($oneschedule['createdon']) : "00/00/0000";
													
													## All nodes count
													$allnodeswhere = "(scheduledate = '".$oneschedule['scheduledon']."' AND isdeleted=0)";
													$allnodescount = $this->commonclass->retrive_records("postpatch_schedule", " count(*) as allnodes ", $allnodeswhere, array(), 1);
													$allnodes = (!empty($allnodescount[0]['allnodes'])) ? $allnodescount[0]['allnodes'] : 0 ;
													$allnodes_str = $allnodes ;
													
													if ($allnodes >0) {
														
														## pending patching nodes count
														$pendingpatchingnodeswhere = "(scheduledate = '".$oneschedule['scheduledon']."' AND patchingstatus = 'Pending' AND isdeleted=0)";
														$pendingpatchingnodescount = $this->commonclass->retrive_records("postpatch_schedule", " count(*) as pendingpatchingnodes ", $pendingpatchingnodeswhere, array(), 1);
														$pendingpatchingnodes = (!empty($pendingpatchingnodescount[0]['pendingpatchingnodes'])) ? $pendingpatchingnodescount[0]['pendingpatchingnodes'] : 0 ;
														$pendingpatchingnodes_str = '<span class="btn btn-primary btn-xs btn-grad status_btns">'.$pendingpatchingnodes.'</span> ';
														
														
														## patching nodes count
														$patchingnodeswhere = "(scheduledate = '".$oneschedule['scheduledon']."' AND patchingstatus = 'Completed' AND isdeleted=0)";
														$patchingnodescount = $this->commonclass->retrive_records("postpatch_schedule", " count(*) as patchingnodes ", $patchingnodeswhere, array(), 1);
														$patchingnodes = (!empty($patchingnodescount[0]['patchingnodes'])) ? $patchingnodescount[0]['patchingnodes'] : 0 ;
														$patchingnodes_str = '<span class="btn btn-success btn-xs btn-grad status_btns">'.$patchingnodes.'</span> ';
														
														## pending nodes count
														$pendingnodeswhere = "(scheduledate = '".$oneschedule['scheduledon']."' AND patchingstatus = 'Completed' AND verificationstatus = 'Pending' AND isdeleted=0)";
														$pendingnodescount = $this->commonclass->retrive_records("postpatch_schedule", " count(*) as pendingnodes ", $pendingnodeswhere, array(), 1);
														$pendingnodes = (!empty($pendingnodescount[0]['pendingnodes'])) ? $pendingnodescount[0]['pendingnodes'] : 0 ;
														$pendingnodes_str = '<span class="btn btn-primary btn-xs btn-circle btn-grad status_btns">'.$pendingnodes.'</span> ';
														
														
														## verified nodes count
														$verifynodeswhere = "(scheduledate = '".$oneschedule['scheduledon']."' AND patchingstatus = 'Completed' AND verificationstatus = 'Verified' AND isdeleted=0)";
														$verifiednodescount = $this->commonclass->retrive_records("postpatch_schedule", " count(*) as verifiednodes ", $verifynodeswhere, array(), 1);
														$verifiednodes = (!empty($verifiednodescount[0]['verifiednodes'])) ? $verifiednodescount[0]['verifiednodes'] : 0 ;
														$verifiednodes_str = '<span class="btn btn-success btn-xs btn-circle btn-grad status_btns">'.$verifiednodes.'</span> ';
														
														## Issue nodes count
														$issuenodeswhere = "(scheduledate = '".$oneschedule['scheduledon']."' AND patchingstatus = 'Completed' AND verificationstatus = 'Issue' AND isdeleted=0)";
														$issuenodescount = $this->commonclass->retrive_records("postpatch_schedule", " count(*) as issuenodes ", $issuenodeswhere, array(), 1);
														$issuenodes = (!empty($issuenodescount[0]['issuenodes'])) ? $issuenodescount[0]['issuenodes'] : 0 ;
														$issuenodes_str = '<span class="btn btn-danger btn-xs btn-circle btn-grad status_btns">'.$issuenodes.'</span>';
														
														## Retired nodes count
														$discontnodeswhere = "(scheduledate = '".$oneschedule['scheduledon']."' AND patchingstatus = 'Completed' AND verificationstatus = 'Retired' AND dpa_flexinet_id = ".$this->loginuserdata['loginid']." AND isdeleted=0)";
														$discontnodescount = $this->commonclass->retrive_records("postpatch_schedule", " count(*) as discontnodes ", $discontnodeswhere, array(), 1);
														$discontnodes = (!empty($discontnodescount[0]['discontnodes'])) ? $discontnodescount[0]['discontnodes'] : 0 ;
														$discontnodes_str = '<span class="btn btn-warning btn-xs btn-circle btn-grad status_btns">'.$discontnodes.'</span>';
														
														$verifyingnodes = "  ".$pendingnodes_str."&nbsp;&nbsp;".$verifiednodes_str."&nbsp;&nbsp;".$issuenodes_str."&nbsp;&nbsp;".$discontnodes_str."&nbsp;&nbsp;";
														
														if($patchingnodes > 0) {
															$patching_percent = (($patchingnodes) / $allnodes) * 100;
															$verification_percent = (($verifiednodes) / $patchingnodes) * 100;
														} else {
															$patching_percent = 0;
															$verification_percent = 0;
														}
														
														$verification_status = round($verification_percent)."%";
														$patching_status = round($patching_percent)."%";
														
													} else {
														$verification_percent = 0;
														$verification_status = '0%';
														$patching_status = '0%';
													}
													
													$tdclass = "";
													
													if (strtotime($oneschedule['scheduledon']) < time() && round($verification_percent) < 100) {
														$tdclass = "text-muted"; // class="success"
													} else if (strtotime($oneschedule['scheduledon']) < time()) {
														$tdclass = "text-muted"; // class="success"
													} else if (strtotime($oneschedule['scheduledon']) > time() && (round($verification_percent) > 0 && round($verification_percent) < 100)) {
														$tdclass = "text-primary"; // class="success"
													} else if (strtotime($oneschedule['scheduledon']) > time() && (round($verification_percent) == 100)) {
														$tdclass = "text-success"; // class="success"
													}
													if ($allnodes >0) {	
													//$viewdetailslink = anchor("admin/dashboard/viewexceldetails/".$oneschedule['idpostpatch_upload'], $scheduledate, array('title'=>'View details'));
													
													$date_decode = $scheduledate;
													$viewdetailslink = anchor("admin/dashboard/viewexceldetails/".$oneschedule['scheduledon'], $scheduledate, array('title'=>'View details'));
													$viewlink = anchor("admin/dashboard/viewexceldetails/".$oneschedule['scheduledon'], '<i class="icon-check"></i>', array('title'=>'View details'));
													
													
													$deletelink = ($verification_percent == 0 && $patching_percent == 0) ? '<a title="Delete" style="cursor:pointer; font-size: 17px!important; font-weight:bold!important; color: #C00000;" id="delete_postpatch_'.$oneschedule['scheduledon'].'" onclick="delete_postpatch(\''.$oneschedule['scheduledon'].'\', \''.$scheduledate.'\');"><i class="icon-trash"></i></a> ' : '';
										?>
										 <tr>
                                            <td class=" <?php echo $tdclass; ?>"><u><?php echo $viewdetailslink; ?></u></td>
                                            <td class=" <?php echo $tdclass; ?>"><b><?php echo $allnodes; ?></b></td>
                                            <td class=" <?php echo $tdclass; ?>"><?php echo $pendingpatchingnodes_str ."&nbsp; &nbsp;".$patchingnodes_str ."&nbsp; &nbsp;". $patching_status; ?></td>
                                            <td class=" <?php echo $tdclass; ?>"><?php echo $verifyingnodes ."&nbsp; &nbsp;". $verification_status; ?></td>
											<td><div style="width: 25px!important; float:left;"><?php echo $deletelink; ?>&nbsp;</div> </td>
                                        </tr>

										<?php
													}
												}
											}
										?>

                                       
                                       

                                    </tbody>
                                </table>
                            </div>
                            <table width="99%">
								<tr>
									<td width="30%" valign="top">
										 <p class="text-warning">Click on <b>Schedule date</b> to view details</p>
										 <p class="text-warning">Click on <b><a style="font-size: 16px!important; font-weight:bold!important; color: #C00000;"><i class="icon-trash"></i></a></b> to delete <b>schedule</b> </p>
									</td>
									<td width="70%" align="right" valign="top">
										<ul class="list-inline">											

											<li><a class="btn btn-primary btn-xs btn-circle btn-grad status_btns">&nbsp;</a>  Pending</li>
											<li><a class="btn btn-success btn-xs btn-circle btn-grad status_btns">&nbsp;</a>  Patched / Verified</li>
											<li><a class="btn btn-danger btn-xs btn-circle btn-grad status_btns">&nbsp;</a>  Issue</li>
											<li><a class="btn btn-warning btn-xs btn-circle btn-grad status_btns">&nbsp;</a> Retired</li>
										</ul>
									</td>
								</tr>
                            </table>
                           
								
                                  </div>
                            </div>
                        </div>
                        
                    </div>

                </div>
                 <!--TABLE, PANEL, ACCORDION AND MODAL  -->

                
            </div>

        </div>
    <!--END PAGE CONTENT -->
<style>
.status_btns {
font-size: 11px;
min-height: 18px!important;
padding: 0;
min-width: 18px!important;
}
.btn-circle {
width: auto!important;
height: 18px!important;
}
</style>  
    
<?php $this->load->view('layout/'.$this->sel_theam_path.'/rightmenu'); ?>

<script type="text/javascript">
	function delete_postpatch(delscheduledate, dispdate) {
		if (confirm("Are you sure to delete post patching details of "+dispdate+"?")) {
			if (test = prompt('Comments')) {
				$.post("<?php echo site_url('admin/dashboard/delete_postpatch'); ?>",{delscheduledate:delscheduledate, dispdate:dispdate, comments:test} ,function(data)
				{
					if (data == 1) {
						window.location.href= '<?php echo current_url(); ?>';
					} else {
						alert('Post patching details not deleted');
					}
				});
			} else {
				alert('Post patching details not deleted');
			}
		}
	}


</script>
