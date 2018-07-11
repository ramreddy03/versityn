<?php $this->load->view('layout/'.$this->sel_theam_path.'/leftmenu'); ?>

<!-- PAGE LEVEL STYLES -->
<link href="<?php echo $this->baseurl;?>assets/default/css/chosen.min.css" rel="stylesheet" />
<!-- END PAGE LEVEL  STYLES -->
    
<style>
.chzn-select {
	min-width: 170px;
}
</style>
	<!--PAGE CONTENT -->
        <div id="content">
             
            <div class="inner" style="min-height: 700px;">
                <!-- <div class="row">
                    <div class="col-lg-12">
                        <h1> Report </h1>
                    </div>
                </div> -->
                
                <!-- Search Filters display start -->
                <div class="row">
					<div class="col-lg-12">
						<br/>
						<form method="post" id="search-fields-form">
						<ul class="list-inline">
							
							<li>
								<label>Schedule date</label><br/>
								<select name="scheduledate[]" class="form-control chzn-select" multiple="multiple" data-placeholder="Select Schedule date">
									<?php 
										if (!empty($search_filters['scheduledates']) && count($search_filters['scheduledates'])>0 ) {
											foreach ($search_filters['scheduledates'] as $dbdate => $onerec2) {
												$selecteddbdate = (!empty($_POST['scheduledate']) && in_array($dbdate, $_POST['scheduledate'])) ? 'selected="Selected"' : '';
									?>
											<option value="<?php echo $dbdate; ?>" <?php echo $selecteddbdate; ?>><?php echo $onerec2; ?></option>
									<?php
											}
										}										
									?>
								</select>
							</li>	
							
							<li>
								<label>Patching Status</label><br/>
								<select name="patchingstatus[]" class="form-control chzn-select" multiple="multiple" data-placeholder="Select Patching Status" id="patching_statusfilter">
									
									<?php 
										if (!empty($search_filters['patchingstatus']) && count($search_filters['patchingstatus'])>0 ) {
											$allpatchings = implode("','", $search_filters['patchingstatus']);
											$all_selected = (!empty($_POST['patchingstatus']) && ($_POST['patchingstatus'][0] == "All")) ? 'selected="Selected"' : ''; 
									?>
											<option value="All<?php //echo $allpatchings; ?>" <?php echo $all_selected; ?>>All</option>
									<?php
											foreach ($search_filters['patchingstatus'] as $onerec1) {
												$selectedverf = (!empty($_POST['patchingstatus']) && in_array($onerec1, $_POST['patchingstatus'])) ? 'selected="Selected"' : '';
									?>
											<option value="<?php echo $onerec1; ?>" <?php echo $selectedverf; ?>><?php echo $onerec1; ?></option>
									<?php
											}
										}										
									?>
								</select>
							</li>
									
							<li class ="verification-filter1">
								<label>Verification Status</label><br/>
								<?php 
								$verify_disabled = (!empty($_POST['patchingstatus']) && ( in_array("All", $_POST['patchingstatus']) || in_array("Completed", $_POST['patchingstatus']) ))  ? '' : 'disabled';
								$allpatchings = implode("','", $search_filters['verf_status']);
								$all_selected = (!empty($_POST['verificationstatus'][0]) && ($_POST['verificationstatus'][0] == "'Verified','Issue','Pending'")) ? 'selected="Selected"' : '';  ?>
								<select name="verificationstatus[]" class="form-control chzn-select verification-filter" multiple="multiple" data-placeholder="Select Verification Status" <?php echo $verify_disabled; ?>>
									<option value="<?php echo $allpatchings; ?>" <?php echo $all_selected; ?>>All</option>
									<?php 
										if (!empty($search_filters['verf_status']) && count($search_filters['verf_status'])>0 ) {
											foreach ($search_filters['verf_status'] as $onerec1) {
												$selectedverf = (!empty($_POST['verificationstatus']) && in_array($onerec1, $_POST['verificationstatus'])) ? 'selected="Selected"' : '';
									?>
											<option value="<?php echo $onerec1; ?>" <?php echo $selectedverf; ?>><?php echo $onerec1; ?></option>
									<?php
											}
										}										
									?>	
								</select>
							</li>
																
							<li class ="verification-filter1">
								<label>Verifier</label><br/>
								
								<?php 
								$verify_disabled = (!empty($_POST['patchingstatus']) && ( in_array("All", $_POST['patchingstatus']) || in_array("Completed", $_POST['patchingstatus']) ))  ? '' : 'disabled'; 
								$allpatchings = implode("','", $search_filters['dpa']);
								$all_selected = (!empty($_POST['dpa_flexinet_id']) && (in_array("'Bushan','charan','Hanu','Jayashanker','Jeff','Johnny','Mark','Nick','Rafiq','Wes'", $_POST['dpa_flexinet_id']))) ? 'selected="Selected"' : ''; 
								?>
								<select name="dpa_flexinet_id[]" class="form-control chzn-select verification-filter" multiple="multiple" data-placeholder="Select Verifier" <?php echo $verify_disabled; ?> >
									<option value="<?php echo $allpatchings; ?>" <?php echo $all_selected; ?>>All</option>
									<?php 
										if (!empty($search_filters['dpa']) && count($search_filters['dpa'])>0 ) {
											foreach ($search_filters['dpa'] as $onedpa) {
												$selecteddpa = (!empty($_POST['dpa_flexinet_id']) && in_array($onedpa, $_POST['dpa_flexinet_id'])) ? 'selected="Selected"' : '';
									?>
											<option value="<?php echo $onedpa; ?>" <?php echo $selecteddpa; ?>><?php echo $onedpa; ?></option>
									<?php
											}
										}										
									?>
								</select>
								
							</li>
													
							<li><input type="submit" name="search" class="btn btn-success btn-circle " value="Go"></li>
						</ul>
						</form>
					</div>
				</div>
                <!-- Search Filters display end -->
                  

                 <!--TABLE, PANEL, ACCORDION AND MODAL  -->
                          <div class="row">
							  
							  <div class="col-lg-12">
                        <div class="panel panel-default box success">
                            
								<header>
									<div class="icons"><i class="icon-list-ul"></i></div>
									<h5>Post Patching & Verification Report</h5>
									<div class="toolbar">
										<a href="#datewise" data-toggle="tab" class="btn btn-default btn-xs btn-grad">Date View</a>
										<a href="#dpawise" data-toggle="tab" class="btn btn-default btn-xs btn-grad">Verifier View</a>
									</div>
								</header>
                             
                            <div class="panel-body" id="div-2" style="height:auto;">
                            
									<div class="tab-content">
										
										<div class="tab-pane fade in active" id="datewise">
											<?php
												if (!empty($search_results['datewise']) && count($search_results['datewise'])>0) {
													
											?>
											<form id="frmreport_xl_export_date" method="post" action="<?php echo site_url("admin/reports/exporttoxl/datewise"); ?>">
											<input type="hidden" name="searchquery" id="search_query_field" value="<?php echo $search_query; ?>" />
											</form>
											<a style='float:right; cursor:pointer;' title='Export to Excel' onclick="report_xl_export('frmreport_xl_export_date');">Export to Excel</a>
											<?php //echo anchor("admin/reports/exporttoxl/datewise", 'Export to Excel', array('title'=>'Export to Excel', 'style' => 'float:right;', 'id' => 'report-xl-export')); ?>  
											<div class="clear"></div>
											<br/>
											<?php
													foreach ($search_results['datewise'] as $dispdate => $onedateres) {
											?>
											<div class="btn btn-info btn-xs" style="width:100%; text-align:left;">Verification Details for <b><?php echo $dispdate; ?></b></div>
											<br/>
												<div class="table-responsive">
												  
												  <div id="sortableTable" class="body collapse in">
												  <table class="table table-bordered sortableTable responsive-table report-table" id ="report12-table">
													<thead>
														<tr>
															<th>Time<i class="icon-sort"></i><i class="icon-sort-down"></i> <i class="icon-sort-up"></i></th>
															<th>RNI/Node<i class="icon-sort"></i><i class="icon-sort-down"></i> <i class="icon-sort-up"></i></th>
															<th>Patching Status</th>
															<th>Verifier</th>
															<th>Verification Status</th>
															<th>Verified on</th>
															<th>Verification email to</th>
															<th>Comments</th>
														</tr>
													</thead>
													<tbody>
														<?php
															if (count($onedateres)>0) {
																foreach ($onedateres as $oneschedule) {
																	
																if($oneschedule['patchingstatus'] == "Completed") {
																	if ($oneschedule['verificationstatus'] == "Verified") {
																		$trclass = "success"; // class="success"
																		$verificationstatus = "Verified";
																	} else if ($oneschedule['verificationstatus'] == "Issue") {
																		$trclass = "danger"; // class="success"
																		$verificationstatus = "Issue";
																	} else if ($oneschedule['verificationstatus'] == "Discontinued") {
																		$trclass = "warning"; // class="success"
																		$verificationstatus = "Discontinued";
																	} else {
																		$trclass = "info"; // class="success"
																		$verificationstatus = "Pending";
																	}
																} else {
																	$trclass = ""; 
																	$verificationstatus = "-";																	
																}
																	
																$verifiedon = (!empty($oneschedule['verifiedon']) && $oneschedule['verifiedon'] != "0000-00-00") ? $this->commonclass->dateformat1($oneschedule['verifiedon']) : "";
																
																$patchingstatus = $oneschedule['patchingstatus'];
														?>
														
														<tr class="<?php echo $trclass; ?>">
															<td><?php echo $oneschedule['time']; ?></td>
															<td><?php echo $oneschedule['rni_node']; ?></td>
															<td><?php echo $patchingstatus; ?></td>
															<td><?php echo $oneschedule['dpa_flexinet']; ?></td>
															<td><?php echo $verificationstatus; ?></td>
															<td><?php echo $verifiedon; ?></td>
															<td><?php echo $oneschedule['verified_tomail']; ?></td>
															<td><?php echo $oneschedule['verifiedcomments']; ?></td>
														</tr>

															<?php
																	}
																}
															?>
														   

													   

													</tbody>
												</table>
												   
												   </div>
										   
												
												  </div>
												  
												<?php
														}
													} else {
												?>
														<div class="alert alert-danger">
													No matching details found
														</div>
												<?php
													}
												?>
											
										</div>
										
										<div class="tab-pane fade" id="dpawise">
											
											<?php
												if (!empty($search_results['dpawise']) && count($search_results['dpawise'])>0) {
											?>
											<form id="frmreport_xl_export_dpa" method="post" action="<?php echo site_url("admin/reports/exporttoxl/dpawise"); ?>">
											<input type="hidden" name="searchquery" id="search_query_field" value="<?php echo $search_query; ?>" />
											</form>
											<a style='float:right; cursor:pointer;' title='Export to Excel' onclick="report_xl_export('frmreport_xl_export_dpa');">Export to Excel</a>
											<?php //echo anchor("admin/reports/exporttoxl/dpawise", 'Export to Excel', array('title'=>'Export to Excel', 'style' => 'float:right;')); ?>  
											<div class="clear"></div>
											<br/>
											<?php
													foreach ($search_results['dpawise'] as $dispdpawise => $onedateres) {
											?>
											<div class="btn btn-info btn-xs" style="width:100%; text-align:left;">Verification Details of <b><?php echo $dispdpawise; ?></b></div>
											<br/>
												<div class="table-responsive">
												  
												  <div id="sortableTable" class="body collapse in">
												  <table class="table table-bordered sortableTable responsive-table report1-table" id ="report12-table">
													<thead>
														<tr>
															<th>Scheduledate<i class="icon-sort"></i><i class="icon-sort-down"></i> <i class="icon-sort-up"></i></th>
															<th>Time<i class="icon-sort"></i><i class="icon-sort-down"></i> <i class="icon-sort-up"></i></th>
															<th>RNI/Node<i class="icon-sort"></i><i class="icon-sort-down"></i> <i class="icon-sort-up"></i></th>
															<th>Patching Status</th>
															<th>Verification Status</th>
															<th>Verified on</th>
															<th>Verification email to</th>
															<th>Comments</th>
														</tr>
													</thead>
													<tbody>
														<?php
															if (count($onedateres)>0) {
																foreach ($onedateres as $oneschedule) {
																	
																if($oneschedule['patchingstatus'] == "Completed") {
																	if ($oneschedule['verificationstatus'] == "Verified") {
																		$trclass = "success"; // class="success"
																		$verificationstatus = "Verified";
																	} else if ($oneschedule['verificationstatus'] == "Issue") {
																		$trclass = "danger"; // class="success"
																		$verificationstatus = "Issue";
																	} else if ($oneschedule['verificationstatus'] == "Discontinued") {
																		$trclass = "warning"; // class="success"
																		$verificationstatus = "Discontinued";
																	} else {
																		$trclass = "info"; // class="success"
																		$verificationstatus = "Pending";
																	}
																} else {
																	$trclass = ""; 
																	$verificationstatus = "-";																	
																}
																	
																	
																	$verifiedon = (!empty($oneschedule['verifiedon']) && $oneschedule['verifiedon'] != "0000-00-00") ? $this->commonclass->dateformat1($oneschedule['verifiedon']) : "";
														?>
														
														<tr class="<?php echo $trclass; ?>">
															<td><?php echo $oneschedule['scheduledate']; ?></td>
															<td><?php echo $oneschedule['time']; ?></td>
															<td><?php echo $oneschedule['rni_node']; ?></td>
															<td><?php echo $oneschedule['patchingstatus']; ?></td>
															<td><?php echo $verificationstatus; ?></td>
															<td><?php echo $verifiedon; ?></td>
															<td><?php echo $oneschedule['verified_tomail']; ?></td>
															<td><?php echo $oneschedule['verifiedcomments']; ?></td>
														</tr>

															<?php
																	}
																}
															?>
														   

													   

													</tbody>
												</table>
												   
												   </div>
										   
												
												  </div>
												  
												<?php
														}
													}else {
												?>
														<div class="alert alert-danger">
													No matching details found
														</div>
												<?php
													}
												?>
												
												
										</div>
										
									</div>
                            
                            
                            
                            
                            </div>
                        </div>
                        
                    </div>

                </div>
                 <!--TABLE, PANEL, ACCORDION AND MODAL  -->

                
            </div>

        </div>
    <!--END PAGE CONTENT -->
    
    
<?php $this->load->view('layout/'.$this->sel_theam_path.'/rightmenu'); ?>
