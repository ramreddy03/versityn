<?php 
$this->load->view('layout/'.$this->sel_theam_path.'/leftmenu'); 

?>

<!-- PAGE LEVEL STYLES -->
<link href="<?php echo $this->baseurl;?>assets/default/css/layout2.css" rel="stylesheet" />
<link href="<?php echo $this->baseurl;?>assets/plugins/flot/examples/examples.css" rel="stylesheet" />
<link rel="stylesheet" href="<?php echo $this->baseurl;?>assets/plugins/timeline/timeline.css" />
<!-- END PAGE LEVEL  STYLES -->
    
    
	<!--PAGE CONTENT -->
        <div id="content">
             
            <div class="inner" style="min-height: 700px;">
                
                 <!--TABLE, PANEL, ACCORDION AND MODAL  -->
                          <div class="row">
							  <br/>
							 
							  <div class="col-lg-12">
								  
                        <div class="panel panel-default">
								
                            <div class="panel-heading">
                               <h3>
									Post Patch Verification for <?php //echo $scheduledate_disp; ?>
									 <select style=" margin-right:15px; font-size:16px;" id ="dpa_change_schedule">
									  <option value=""> - Select - </option>
									  <?php 
										if ($patchuploads_dd) {
											foreach ($patchuploads_dd as $pkeyid => $dispdate) {
												$selected = ($pkeyid == $scheduleid) ? 'selected = "Selected"' : '';
									  ?>
									  <option value="<?php echo $pkeyid; ?>" <?php echo $selected; ?>><?php echo $dispdate; ?></option>
									  <?php
											}
										}
									  ?>
								  </select>
									<?php echo anchor("dpa/dashboard/index", '<img src="'.$this->baseurl.'assets/default/img/close.png" height="20" width="20" />', array('title'=>'Close', 'style' => 'float:right;')); ?>&nbsp;&nbsp;&nbsp;
									<?php echo anchor("dpa/dashboard/exporttoxl/".$scheduleid, '<img src="'.$this->baseurl.'assets/default/img/xlsicon.png" height="20" width="20" />', array('title'=>'Close', 'style' => 'float:right; margin: 0px 5px;')); ?>&nbsp; &nbsp;
                               </h3>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
									<?php
										if (!empty($disp_msg)) {
										?>
										<div class="success"><?php echo $disp_msg; ?></div>
										<?php
										}
									?>
									<form method="post" id ="dpafrm_verification_status" enctype="multipart/form-data" action="<?php echo site_url("dpa/dashboard/change_verification_status"); ?>">
                                  
                                  <div id="sortableTable" class="body collapse in">
                                <table class="table table-bordered sortableTable responsive-table" id ="dpaviewsource-table">
                                    <thead>
                                        <tr>
											<th></th>
                                            <th>Time<i class="icon-sort"></i><i class="icon-sort-down"></i> <i class="icon-sort-up"></i></th>
                                            <th>RNI/Node<i class="icon-sort"></i><i class="icon-sort-down"></i> <i class="icon-sort-up"></i></th>
                                            <th>Status</th>
                                            <th>File</th>
                                        </tr>
                                    </thead>
                                    <tbody class="modi_cbs">

										<?php
											if (count($postpatch_schedule)>0) {
												foreach ($postpatch_schedule as $oneschedule) {
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
													
													//idpostpatch_schedule
													
												$downloadlink = ($oneschedule['verified_attachment_rand'] != "") ? anchor("dpa/dashboard/download_verification_doc/".$oneschedule['idpostpatch_schedule'], 'Download', array('title'=>'Download')) : "" ;	
												
												$verifiedcommentshelp = (strlen(trim($oneschedule['verifiedcomments'])) > 0) ? '<span title="'.$oneschedule['verifiedcomments'].'" data-toggle="modal" data-target="#buttonedModal_'.$oneschedule['idpostpatch_schedule'].'"><i class=" icon-question-sign "></i></span>' : '';
												
												
												$verifiedon = (!empty($oneschedule['verifiedon']) && $oneschedule['verifiedon'] != "0000-00-00") ? $this->commonclass->dateformat1($oneschedule['verifiedon']) : "";
										?>
										
                                        <tr class="<?php echo $trclass; ?>">
											<td>
												<?php if ($oneschedule['verificationstatus'] != "Discontinued") { ?>
												<input type="checkbox" name="cbgroups[]" value="<?php echo $oneschedule['idpostpatch_schedule']; ?>" id="<?php echo $oneschedule['rni_node']; ?>" />
												<?php } ?>
											</td>
                                            <td><?php echo $oneschedule['time']; ?></td>
                                            <td><?php echo $oneschedule['rni_node']; ?></td>
                                            
                                            <td><?php echo $verificationstatus." &nbsp; ".$verifiedcommentshelp; ?>
                                            
                                            <?php if (in_array($oneschedule['verificationstatus'], array("Verified", "Issue"))	
														&& (strlen(trim($oneschedule['verifiedcomments'])) > 0 || !empty($oneschedule['verified_attachment_rand']))) { ?>
											<div class="modal fade" id="buttonedModal_<?php echo $oneschedule['idpostpatch_schedule']; ?>" tabindex="-1" role="dialog"  aria-labelledby="myModalLabel" aria-hidden="true">
												<div class="modal-dialog">
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
															<h4 class="modal-title" id="H1"><?php echo $oneschedule['rni_node']; ?></h4>
														</div>
														<div class="modal-body">
															<table width="100%" cellpadding="7">
																<tr>
																	<td width="30%"><b>Verification Status</b></td>
																	<td width="65%"><b><?php echo $verificationstatus; ?></b></td>
																</tr>
																<tr>
																	<td><b>Verified on</b></td>
																	<td><?php echo $verifiedon; ?></td>
																</tr>
																<tr>
																	<td valign="top"><b>Comments</b></td>
																	<td style="text-align: justify;"><?php echo $oneschedule['verifiedcomments']; ?></td>
																</tr>
																
																<tr>
																	<td><b>Attachment</b></td>
																	<td><?php echo $downloadlink; ?></td>
																</tr>
																
															</table>
														</div>
														<div class="modal-footer">
															<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
														</div>
													</div>
												</div>
											</div>
											<?php } ?>
                                            
                                            </td>                                            
                                            <td><?php echo $downloadlink; ?></td>
                                        </tr>

										<?php
												}
											}
										?>
                                    </tbody>
                                </table>
                                
                                <div class="clear"></div>
                                <?php if (count($postpatch_schedule)>0) { ?>
								<table width="100%" border="0">
									<tr><td>&nbsp;</td></tr>
									<tr>
										<td valign="top" width="40%"><label>Comments</label> 
											<div style="clear:both"></div><textarea name="verificationcomments" id="verificationcomments" rows="10" cols="50"></textarea></td>
										<td valign="top" width="60%">
											<label>Attachment</label>
											<input type="file" name="verificationattach" id="verificationattach" />
											<div style="clear:both"></div><br/><p></p>
										<label><input type="checkbox" name="accepttosendmail" id="accepttosendmail" /> Send e-mail to </label> <br/>
	<div style="clear:both"></div><textarea name="sendverifyemails" id="sendverifyemails"><?php echo !empty($this->siteconfigs['verificationemails']) ? $this->siteconfigs['verificationemails'] : ''; ?></textarea><br/>

											<label> <input type="checkbox" name="markcctomyself" id="markcctomyself" checked /> Mark CC to my self </label> <br/>

</td>
									</tr>
									<tr><td>&nbsp;</td></tr>
									<tr>
										<td colspan="2">
											<input type="hidden" name="scheduledate_disp123" id="scheduledate_disp" value="<?php echo $scheduledate_disp; ?>" />
											<input type="hidden" name="scheduleid123" id="scheduleid123" value="<?php echo $scheduleid; ?>" />
											<input type="hidden" name="verificationstatus" id="verificationstatus" value="" />
											<!-- <a class="btn btn-danger btn-sm btn-grad" onclick="save_verif_status('Errror');">Error</a> &nbsp; -->
											<a class="btn btn-danger btn-sm btn-grad" onclick="save_verif_status('Issue');">Mark as Issue</a> &nbsp; 
											<a class="btn btn-success btn-sm btn-grad" onclick="save_verif_status('Verified');">Verified</a> &nbsp;
											<?php echo anchor("dpa/dashboard/index", '<span class="btn btn-primary btn-sm btn-grad" >Cancel</span>', array('title'=>'Cancel')); ?>
										</td>
									</tr>
									<tr><td>&nbsp;</td></tr>
								</table>
								<?php } ?>
								
                            </div>
									
									
									</form>
                                  </div>
                            </div>
                        </div>
                        
                    </div>

                </div>
                 <!--TABLE, PANEL, ACCORDION AND MODAL  -->

                
            </div>

        </div>
        <!--END PAGE CONTENT -->

    
<?php

$rightmenudata['countdata'] = $countdata;
$rightmenudata['disp_multilevelchart'] = 0;
$this->load->view('layout/'.$this->sel_theam_path.'/dpa_rightmenu', $rightmenudata); ?>
