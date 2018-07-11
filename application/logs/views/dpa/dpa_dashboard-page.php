<?php $this->load->view('layout/'.$this->sel_theam_path.'/dpa_leftmenu'); ?>

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
                        <h1> Dashboard </h1>
                    </div>
                </div>
                
                  
                 <!--TABLE, PANEL, ACCORDION AND MODAL  -->
                          <div class="row">
							  
							  <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                              <b> Post Patch Verification</b>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                  
                                  <div id="sortableTable" class="body collapse in">
                                <table class="table table-bordered sortableTable responsive-table" id ="dashboard-table">
                                    <thead>
                                        <tr>
                                            <th width="15%">Schedule date<i class="icon-sort"></i><i class="icon-sort-down"></i> <i class="icon-sort-up"></i></th>
                                            <th width="15%">Total Nodes<i class="icon-sort"></i><i class="icon-sort-down"></i> <i class="icon-sort-up"></i></th>
                                            <th width="17%">Verification Status<i class="icon-sort"></i><i class="icon-sort-down"></i> <i class="icon-sort-up"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody>
										
										<?php
											if (count($postpatch_uploads)>0) {
												foreach ($postpatch_uploads as $oneschedule) {
													
													//$viewdetailslink = anchor("dpa/dashboard/viewexceldetails/".$oneschedule['idpostpatch_upload'], 'View', array('title'=>'View details'));
													$actions1 = "";
													
													$scheduledate = (!empty($oneschedule['scheduledon']) && $oneschedule['scheduledon'] != "0000-00-00") ? $this->commonclass->dateformat1($oneschedule['scheduledon']) : "00/00/0000";
													
													## All nodes count
													$allnodeswhere = "(scheduledate = '".$oneschedule['scheduledon']."' AND dpa_flexinet_id = ".$this->loginuserdata['loginid']." AND patchingstatus = 'Completed' AND isdeleted = 0)";
													$allnodescount = $this->commonclass->retrive_records("postpatch_schedule", " count(*) as allnodes ", $allnodeswhere, array(), 1);
													$allnodes = (!empty($allnodescount[0]['allnodes'])) ? $allnodescount[0]['allnodes'] : 0 ;
													$allnodes_str = $allnodes ;
													
													if ($allnodes >0) {
														
														
														## pending nodes count
														$pendingnodeswhere = "(scheduledate = '".$oneschedule['scheduledon']."' AND verificationstatus = 'Pending' AND dpa_flexinet_id = ".$this->loginuserdata['loginid']." AND patchingstatus = 'Completed' AND isdeleted = 0)";
														$pendingnodescount = $this->commonclass->retrive_records("postpatch_schedule", " count(*) as pendingnodes ", $pendingnodeswhere, array(), 1);
														$pendingnodes = (!empty($pendingnodescount[0]['pendingnodes'])) ? $pendingnodescount[0]['pendingnodes'] : 0 ;
														$pendingnodes_str = '<span class="btn btn-primary btn-xs btn-circle btn-grad status_btns">'.$pendingnodes.'</span> ';
														
														## verified nodes count
														$verifynodeswhere = "(scheduledate = '".$oneschedule['scheduledon']."' AND verificationstatus = 'Verified' AND dpa_flexinet_id = ".$this->loginuserdata['loginid']." AND patchingstatus = 'Completed' AND isdeleted = 0)";
														$verifiednodescount = $this->commonclass->retrive_records("postpatch_schedule", " count(*) as verifiednodes ", $verifynodeswhere, array(), 1);
														$verifiednodes = (!empty($verifiednodescount[0]['verifiednodes'])) ? $verifiednodescount[0]['verifiednodes'] : 0 ;
														$verifiednodes_str = '<span class="btn btn-success btn-xs btn-circle btn-grad status_btns">'.$verifiednodes.'</span> ';
														
														## Issue nodes count
														$issuenodeswhere = "(scheduledate = '".$oneschedule['scheduledon']."' AND verificationstatus = 'Issue' AND dpa_flexinet_id = ".$this->loginuserdata['loginid']." AND patchingstatus = 'Completed' AND isdeleted = 0)";
														$issuenodescount = $this->commonclass->retrive_records("postpatch_schedule", " count(*) as issuenodes ", $issuenodeswhere, array(), 1);
														$issuenodes = (!empty($issuenodescount[0]['issuenodes'])) ? $issuenodescount[0]['issuenodes'] : 0 ;
														$issuenodes_str = '<span class="btn btn-danger btn-xs btn-circle btn-grad status_btns">'.$issuenodes.'</span>';
														
														## Retired nodes count
														$discontnodeswhere = "(scheduledate = '".$oneschedule['scheduledon']."' AND verificationstatus = 'Retired' AND dpa_flexinet_id = ".$this->loginuserdata['loginid']." AND patchingstatus = 'Completed' AND isdeleted = 0)";
														$discontnodescount = $this->commonclass->retrive_records("postpatch_schedule", " count(*) as discontnodes ", $discontnodeswhere, array(), 1);
														$discontnodes = (!empty($discontnodescount[0]['discontnodes'])) ? $discontnodescount[0]['discontnodes'] : 0 ;
														$discontnodes_str = '<span class="btn btn-warning btn-xs btn-circle btn-grad status_btns">'.$discontnodes.'</span>';
														
														$nodes = "<div class='smallcountdisp'>".$allnodes_str."</div>  ";
														
														$verification_percent = (($verifiednodes) / $allnodes) * 100;
														
														$verifyingnodes = "  ".$pendingnodes_str."&nbsp;&nbsp;".$verifiednodes_str."&nbsp;&nbsp;".$issuenodes_str."&nbsp;&nbsp;".$discontnodes_str."&nbsp;&nbsp;";
														
														$verification_status = "".$verifyingnodes. round($verification_percent)."%";
														
													} else {
														$nodes = 0;
														$verification_status = '0%';
													}
													
													$tdclass = "";
													
													if (strtotime($oneschedule['scheduledon']) < time() && round($verification_percent) < 100) {
														$tdclass = "text-danger"; // class="success"
													} else if (strtotime($oneschedule['scheduledon']) < time()) {
														$tdclass = "text-muted"; // class="success"
													} else if (strtotime($oneschedule['scheduledon']) > time() && (round($verification_percent) > 0 && round($verification_percent) < 100)) {
														$tdclass = "text-primary"; // class="success"
													} else if (strtotime($oneschedule['scheduledon']) > time() && (round($verification_percent) == 100)) {
														$tdclass = "text-success"; // class="success"
													}
													
											if ($allnodes >0) {		
													//$viewdetailslink = anchor("dpa/dashboard/viewexceldetails/".$oneschedule['idpostpatch_upload'], $scheduledate, array('title'=>'View details'));
													$viewdetailslink = anchor("dpa/dashboard/viewexceldetails/".$oneschedule['scheduledon'], $scheduledate, array('title'=>'View details'));
										?>
										 <tr>
                                            <td class=" <?php echo $tdclass; ?>"><u><?php echo $viewdetailslink; ?></u></td>
                                            <td class=" <?php echo $tdclass; ?>"><b><?php echo $nodes; ?></b></td>
                                            <td class=" <?php echo $tdclass; ?>"><?php echo $verification_status; ?></td>
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
									<td width="50%">
										 <p class="text-warning">Click on <b>Scheduled on</b> to view details</p>
									</td>
									<td width="50%" align="right">
										<ul class="list-inline">			
											<li><a class="btn btn-primary btn-xs btn-circle btn-grad status_btns">&nbsp;</a>  Pending</li>
											<li><a class="btn btn-success btn-xs btn-circle btn-grad status_btns">&nbsp;</a>  Verified</li>
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
    
<?php 
$rightmenudata['disp_multilevelchart'] = 0;
$this->load->view('layout/'.$this->sel_theam_path.'/rightmenu', $rightmenudata); ?>
