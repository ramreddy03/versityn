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
							 <p></p>
					<div class="col-lg-12">
								  
                        <div class="panel panel-default">
								
                            <div class="panel-heading">
                               <h3>
									Post Patching & Verification for 
									<?php echo anchor("admin/dashboard/index", '<img src="'.$this->baseurl.'assets/default/img/close.png" height="20" width="20" />', array('title'=>'Close', 'style' => 'float:right;')); ?>
									
									<?php echo anchor("admin/dashboard/exporttoxlsheet/".$scheduleid, '<img src="'.$this->baseurl.'assets/default/img/xlsicon.png" height="20" width="20" />', array('title'=>'Export to excel', 'style' => 'float:right; margin: 0px 5px;')); ?>&nbsp; &nbsp;
									
									
									<?php if((empty($countdata['patched']) && $countdata['patched'] == 0) && (empty($countdata['verified']) && $countdata['verified'] == 0)) { ?>
									<span style="float:right; margin: 0px 5px; font-size: 12px; cursor: pointer; text-decoration:underline;" id="dispimportform">Import</span>
									<?php } ?>
										 <?php echo anchor("admin/dashboard/addnode_schedule/".$scheduleid, 'Add Node', array('title'=>'Add Node', 'style' => "float:right; margin: 0px 5px; font-size: 12px; cursor: pointer; text-decoration:underline; color:#FFFFFF")); ?>
							
									 <select style="margin-right:15px; font-size:16px!important;" id ="change_schedule">
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
                               </h3>
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
                                  <?php if($countdata['patched'] == 0 && $countdata['verified'] == 0) { ?>
								  <div id="form_import_xl" style="display:none;">
									  <h4>Import verification details excel</h4><br/>
								  <form class="form-horizontal" id="importfromspreadsheet" action="<?php echo site_url("admin/dashboard/importverificationxl"); ?>" method="post" enctype="multipart/form-data">
										<div class="form-group">
											<label class="control-label" style="text-align:left!important; float:left; margin:0 12px; padding-top:4px!important;">Upload File</label>
											<input type="hidden" id="scheduledate" name="scheduledate" value="<?php echo $scheduleid; ?>" />
											<input type="file" id="uploadfile" name="uploadfile" class="custom-file-input" style="float:left;" />
											
											<input type="submit" name="submit" value= "Preview" class="btn btn-primary  btn-xs" style="float:left;" id="previewupload" /> &nbsp;  
											<a id="cancle_import_xl" class="btn btn-primary btn-xs" style="float:left; margin-left: 10px">Cancel Import</a>
										</div>
									</form>
									<p></p><br/>
									<?php
										if(!empty($import_history) && count($import_history)>0) {
									?>
										<ul class="list-unstyled">
									<?php
											foreach ($import_history as $onehistory) {
												$updateddate = ($onehistory['updateddate'] != "0000-00-00") ? $this->commonclass->dateformat1($onehistory['updateddate']) : "00/00/0000";
									?>
										<li class="text-primary">Sheet imported by <b><?php echo $onehistory['login_uname']; ?></b> on <b><?php echo $updateddate; ?> at <?php echo $onehistory['updatetime']; ?></b></li>
									<?php
											}
									?>
										</ul>
									<?php
										}
									?>
									<hr/>
								  </div>
									<?php } else { ?>
									<h4 class="text-primary"><b>Patching / verification started, Import option not available</b></h4>
									<?php } ?>									
									<p></p><br/>
                                  
								  <div id="sortableTable" class="body collapse in">
							<form name="savepatchingstatus" method="post" action="<?php echo site_url("admin/dashboard/savepatchingstatus"); ?>" id="frmsavepatchingstatus"> 
                                <table class="table table-bordered sortableTable responsive-table" id ="viewsource-table">
                                    <thead>
                                        <tr>
                                            <th width="3%"><input type="checkbox" id="verif_cbs_updstatus" />&nbsp;</th>
                                            <th width="3%">&nbsp;</th>
                                            <th width="13%">Time<i class="icon-sort"></i><i class="icon-sort-down"></i> <i class="icon-sort-up"></i></th>
                                            <th width="20%">RNI/Node<i class="icon-sort"></i><i class="icon-sort-down"></i> <i class="icon-sort-up"></i></th>
                                            <th width="14%">Patching Status</th>
                                            <th width="10%">Patched on</th>
                                            <th width="8%">Verifier</th>
                                            <th width="14%">Verification Status</th>
                                            <th width="10%">Verified on</th>
                                        </tr>
                                    </thead>
                                    <tbody  class="patching_cbs">
										<?php
											if (count($postpatch_schedule)>0) {
												foreach ($postpatch_schedule as $oneschedule) {
													
													
													$patchingstatus = $oneschedule['patchingstatus'];
													$patchedon = (!empty($oneschedule['patchedon']) && $oneschedule['patchedon'] != "0000-00-00") ? $this->commonclass->dateformat1($oneschedule['patchedon']) : "";
													
													$verifiedon = (!empty($oneschedule['verifiedon']) && $oneschedule['verifiedon'] != "0000-00-00") ? $this->commonclass->dateformat1($oneschedule['verifiedon']) : "";
													
													if ($patchingstatus == "Completed") {	
														if ($oneschedule['verificationstatus'] == "Verified") {
															$trclass = "success"; // class="success"
															$verificationstatus = 'Verified';
															$patchingtdclass = "";
														} else if ($oneschedule['verificationstatus'] == "Issue") {
															$trclass = "danger"; // class="success"
															$verificationstatus = 'Issue';
															$patchingtdclass = "";
														} else if ($oneschedule['verificationstatus'] == "Discontinued") {
															$trclass = "warning"; // class="success"
															$verificationstatus = 'Discontinued';
															$patchingtdclass = "";
														} else {
															//$trclass = "info"; // class="success"
															$verificationstatus = 'Pending';
															$trclass = ""; // class="text-success"															
															$patchingtdclass = "text-success"; // class="text-success"															
														}
													} else {									
														$trclass = "";
														$verificationstatus = "-";
														$patchingtdclass = "";
													}
											$where = "(id_user='".$oneschedule['dpa_flexinet_id']."')";
											$exist_dpa = $this->commonclass->retrive_records("users", " * ", $where, array(), 1);
											$dpaid = (!empty($exist_dpa[0]['id_user'])) ? $exist_dpa[0]['id_user'] : 0;
											
												$firstname = (!empty($exist_dpa[0]['firstname'])) ? $exist_dpa[0]['firstname'] : '';
												$lastname = (!empty($exist_dpa[0]['lastname'])) ? $exist_dpa[0]['lastname'] : '';
												$email = (!empty($exist_dpa[0]['email'])) ? $exist_dpa[0]['email'] : '';
												$fullname = $firstname." ".$lastname;
												
												$dpadetails =  $fullname."___".$email."___".$oneschedule['rni_node']."___".$oneschedule['time'];
													
													$verifiedcommentshelp = (strlen(trim($oneschedule['verifiedcomments'])) > 0) ? '<span title="'.$oneschedule['verifiedcomments'].'" data-toggle="modal" data-target="#buttonedModal_'.$oneschedule['idpostpatch_schedule'].'" style="cursor:pointer"><i class=" icon-question-sign "></i></span>' : '';
													
													$editdetailslink = anchor("admin/dashboard/editselectednode/".$oneschedule['idpostpatch_schedule'], '<i class="icon-pencil"></i>' , array('title'=>'Edit details'));
													$verifiedcommentsattach = (!empty($oneschedule['verified_attachment_rand'])) ? anchor("admin/dashboard/downloadverificationattach/".$oneschedule['idpostpatch_schedule'], '<i class=" icon-download  "></i>', array('title'=>'Download')) : '';
													
										?>
                                        <tr class="<?php echo $trclass; ?>">
											<td>
												<?php if($patchingstatus == "Pending") { ?> 
												<input type="checkbox" name="change_patchstatuscbs[<?php echo $oneschedule['idpostpatch_schedule']; ?>]" id="<?php echo $oneschedule['rni_node']; ?>" value="<?php echo $dpadetails; ?>" class="verif_cbs_updstatus" />
												<?php } else { echo "&nbsp; &nbsp; "; } ?>
												&nbsp;
											</td>
											<td align="center">
												<?php if($patchingstatus == "Pending") { ?> 
												 <?php echo $editdetailslink; ?>
												<?php } else { echo "&nbsp;"; } ?>
												&nbsp;
											</td>
                                            <td class="<?php echo $patchingtdclass; ?>">
												 <?php echo $oneschedule['time']; ?>
                                            </td>
                                            <td class="<?php echo $patchingtdclass; ?>"> <?php echo $oneschedule['rni_node']; ?></td>
                                            <td class="<?php echo $patchingtdclass; ?>"><?php echo $patchingstatus; ?></td>
                                            <td class="<?php echo $patchingtdclass; ?>"><?php echo $patchedon; ?></td>
                                            <td><?php echo ucwords(strtolower($oneschedule['dpa_flexinet'])); ?></td>
                                            <td><?php echo $verificationstatus." &nbsp; ".$verifiedcommentshelp." &nbsp; ".$verifiedcommentsattach; ?>
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
																	<td><b>Verifier</b></td>
																	<td><?php echo ucwords(strtolower($oneschedule['dpa_flexinet'])); ?></td>
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
																	<td><?php echo $verifiedcommentsattach; ?></td>
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
                                           
                                            <td><?php echo $verifiedon; ?></td>
                                           <!-- <td><?php //echo $oneschedule['verifiedcomments']; ?></td> -->
                                        </tr>
										<?php
												}
											}
										?>
                                    </tbody>
                                </table>
                                <p>&nbsp;</p>
                                <input type="hidden" name = "scheduledate" id="scheduledate" value = "<?php echo $scheduleid; ?>" />
                                <!-- <input type="submit" id="submitupd" name="submit" class="btn btn-primary " value="Update patching status"> -->
                                <?php 
                                if( $countdata['patched'] < $countdata['all']) {
                                $date123 = strtotime($scheduleid);
                                $date456 = strtotime(date('Y-m-d'));  
                                $disablebtn = ($date123 > $date456) ? ' disabled="Disabled"' : '';
                                $scheduleid_arr = explode("-", $scheduleid);
                                $scheduleid_disp = date("dS M Y", mktime(0, 0, 0, $scheduleid_arr[1], $scheduleid_arr[2], $scheduleid_arr[0]));
                               echo $btncontent = ($date123 > $date456) ? '&nbsp;' : '<input type="checkbox" name="sendemails" value="1" checked="Checked" /> &nbsp; Send patching update notification inaddition to verifier <br/><a class="btn btn-default btn-sm btn-grad" onclick="change_patchingstatus();" id="selupdatednodes">Update patching status</a> &nbsp;';
                                ?>
								&nbsp;
								<a class="btn btn-default btn-sm btn-grad" onclick="fnnotify_verifier('<?php echo $scheduleid; ?>');" id="notify_verifier" title='Notify Verifier Patching schedule'>Notify Verifier</a> &nbsp;
								<a class="btn btn-default btn-sm btn-grad" onclick="deletenodes();" id="seldeletednodes">Delete</a> &nbsp;
								<?php echo anchor("admin/dashboard/addnode_schedule/".$scheduleid, 'Add Node', array('title'=>'Add Node', 'class' => 'btn btn-primary btn-sm btn-grad')); ?>&nbsp; &nbsp;
								<?php } ?>
                                </form>
                            </div>
                                  </div>
                            </div>
                        </div>
						
						<?php if (count($delpostpatch_schedule)>0) { ?>
						
						
						<div class="panel panel-default">
                            <div class="panel-heading"><span style="float:left; color: #FFFFFF!important; font-size: 14px; font-weight:bold;">Deleted Nodes</span>
                              <a style="float:right; color: #FFFFFF!important; font-size: 12px; margin-right: 15px!important; font-weight:bold; cursor:pointer;" onclick="showhidediv('viewdeletedlist', 'idshowhidespan')"> <span id="idshowhidespan"><u>Show</u></span> </a>
                               &nbsp;
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive viewdeletedlist"  id="viewdeletedlist" style="display:none;">                                  
                                  <div id="sortableTable" class="body collapse in">
                                <table class="table table-bordered sortableTable responsive-table" id ="dashboard-table">
                                    <thead>
                                        <tr>
                                            <th width="15%">Time<i class="icon-sort"></i><i class="icon-sort-down"></i> <i class="icon-sort-up"></i></th>
                                            <th width="20%">RNI/Node<i class="icon-sort"></i><i class="icon-sort-down"></i> <i class="icon-sort-up"></i></th>
                                            <th width="9%">Verifier</th>
                                            <th width="10%">&nbsp;</th>
                                        </tr>
                                    </thead>
                                    <tbody>
										
										<?php
											if (count($delpostpatch_schedule)>0) {
												foreach ($delpostpatch_schedule as $oneschedule) {
													
													$patchingstatus = $oneschedule['patchingstatus'];
													$patchedon = (!empty($oneschedule['patchedon']) && $oneschedule['patchedon'] != "0000-00-00") ? $this->commonclass->dateformat1($oneschedule['patchedon']) : "";
													
													$verifiedon = (!empty($oneschedule['verifiedon']) && $oneschedule['verifiedon'] != "0000-00-00") ? $this->commonclass->dateformat1($oneschedule['verifiedon']) : "";
													
													if ($patchingstatus == "Completed") {	
														if ($oneschedule['verificationstatus'] == "Verified") {
															$trclass = "success"; // class="success"
															$verificationstatus = 'Verified';
														} else if ($oneschedule['verificationstatus'] == "Issue") {
															$trclass = "danger"; // class="success"
															$verificationstatus = 'Issue';
														} else if ($oneschedule['verificationstatus'] == "Discontinued") {
															$trclass = "warning"; // class="success"
															$verificationstatus = 'Discontinued';
														} else {
															//$trclass = "info"; // class="success"
															$verificationstatus = 'Pending';
															$trclass = "text-success"; // class="text-success"															
														}
													} else {									
														$trclass = "";
														$verificationstatus = "-";
													}
											$where = "(id_user='".$oneschedule['dpa_flexinet_id']."')";
											$exist_dpa = $this->commonclass->retrive_records("users", " * ", $where, array(), 1);
											$dpaid = (!empty($exist_dpa[0]['id_user'])) ? $exist_dpa[0]['id_user'] : 0;
											
												$firstname = (!empty($exist_dpa[0]['firstname'])) ? $exist_dpa[0]['firstname'] : '';
												$lastname = (!empty($exist_dpa[0]['lastname'])) ? $exist_dpa[0]['lastname'] : '';
												$email = (!empty($exist_dpa[0]['email'])) ? $exist_dpa[0]['email'] : '';
												$fullname = $firstname." ".$lastname;
												
												$dpadetails =  $fullname."___".$email."___".$oneschedule['rni_node']."___".$oneschedule['time'];
											
													//$verifiedcommentshelp = (strlen(trim($oneschedule['verifiedcomments'])) > 0) ? '<span title="'.$oneschedule['verifiedcomments'].'"  data-toggle="modal" data-target="#buttonedModal"><i class=" icon-question-sign "></i></span>' : '';
													$verifiedcommentshelp = (strlen(trim($oneschedule['verifiedcomments'])) > 0) ? '<button title="'.$oneschedule['verifiedcomments'].'"  data-toggle="modal" data-target="#buttonedModal"><i class=" icon-question-sign "></i></button>' : '';
													
													$adddetailslink = anchor("admin/dashboard/editselectednode/".$oneschedule['idpostpatch_schedule'], '<i class="icon-pencil"></i>' , array('title'=>'Edit details'));
													
										?>
										 <tr class="<?php echo $trclass; ?>">
											
                                            <td>
												 <?php echo $oneschedule['time']; ?>
                                            </td>
                                            <td><?php echo $oneschedule['rni_node']; ?></td>
                                            <td><?php echo ucwords(strtolower($oneschedule['dpa_flexinet'])); ?></td>
											<td><a onclick="adddeletednodes('<?php echo $oneschedule['rni_node']; ?>', <?php echo $oneschedule['idpostpatch_schedule']; ?>);" style="cursor:pointer;">Add</a></td>
                                           <!-- <td><?php //echo $oneschedule['verifiedcomments']; ?></td> -->
                                        </tr>
										<?php
													}
												}
											
										?>
                                    </tbody>
                                </table>
                            </div>
                            
								
                                  </div>
                            </div>
                        </div>
                        
						<?php } ?>
					</div>
                </div>
                 <!--TABLE, PANEL, ACCORDION AND MODAL  -->
            </div>
        </div>
        <!--END PAGE CONTENT -->

<?php
$rightmenudata['countdata'] = $countdata;
$rightmenudata['multipie_res'] = $multipie_res;
$rightmenudata['disp_multilevelchart'] = 1;
$this->load->view('layout/'.$this->sel_theam_path.'/dpa_rightmenu', $rightmenudata); ?>
