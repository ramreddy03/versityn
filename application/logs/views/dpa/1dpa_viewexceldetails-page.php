<?php 
$this->load->view('layout/'.$this->sel_theam_path.'/leftmenu'); 

?>

<!-- PAGE LEVEL STYLES -->

<link href="<?php echo $this->baseurl;?>assets/default/css/datepicker.css" rel="stylesheet" />
<!-- END PAGE LEVEL  STYLES -->
    
    
	<!--PAGE CONTENT -->
        <div id="content">
             
            <div class="inner" style="min-height: 700px;">
                
                 <!--TABLE, PANEL, ACCORDION AND MODAL  -->
                          <div class="row">
							  <br/>
							 
							  <div class="col-lg-8">
								  
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
									<tr>
										<td valign="top" width="40%"><label>Comments</label> 
											<div style="clear:both"></div><textarea name="verificationcomments" id="verificationcomments" rows="10" cols="50"></textarea></td>
										<td width="1%"></td>
										<td valign="top" width="59%">
											<label>Attachment</label>
											<input type="file" name="verificationattach" id="verificationattach" />
											<div style="clear:both"></div><br/><p></p>
											<label><input type="checkbox" name="accepttosendmail" id="accepttosendmail" /> Send e-mail to </label> 
											<div style="clear:both"></div><textarea name="sendverifyemails" id="sendverifyemails"><?php echo !empty($this->siteconfigs['verificationemails']) ? $this->siteconfigs['verificationemails'] : ''; ?></textarea><br/>
											<p style="font-weight:bold; margin-bottom:0px;" class="text-warning">Use comma(,) to seperate multiple emails</p>
											<label> <input type="checkbox" name="markcctomyself" id="markcctomyself" /> Mark CC to my self </label> <br/></td>
									</tr>
									<tr><td>&nbsp;</td></tr>
									<tr>
										<td colspan="3">
											<input type="hidden" name="scheduledate_disp123" id="scheduledate_disp" value="<?php echo $scheduledate_disp; ?>" />
											<input type="hidden" name="scheduleid123" id="scheduleid123" value="<?php echo $scheduleid; ?>" />
											<input type="hidden" name="verificationstatus" id="verificationstatus" value="" />
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


<div class="col-lg-4">
	
	<?php 
	
if ( $countdata['all'] > 0) { ?>

<div class="well well-small">
	
	<ul class="list-unstyled">
		<li>
		<span class="btn btn-default btn-sm" style="font-size:13px; font-weight:bold; background: #CCCCCC;">Total Nodes &nbsp; <span><?php echo $countdata['all']; ?></span>
		</li>
	</ul>
	
	<?php
		$patchedpendingpercent = (!empty($countdata['pendingpatching']) && ($countdata['pendingpatching'] > 0)) ? round( ($countdata['pendingpatching']/$countdata['all']) * 100 )."%" : '0%';
		$patchedpercent = (!empty($countdata['patched']) && ($countdata['patched'] > 0)) ? round( ($countdata['patched']/$countdata['all']) * 100 )."%" : '0%';
		$pendingpercent = (!empty($countdata['pending']) && ($countdata['pending'] > 0) && ($countdata['patched'] > 0)) ? round( ($countdata['pending']/$countdata['patched']) * 100 )."%" : '0%';
		$verifiedpercent = (!empty($countdata['verified']) && ($countdata['verified'] > 0) && ($countdata['patched'] > 0)) ? round( ($countdata['verified']/$countdata['patched']) * 100 )."%" : '0%';
		$issuespercent = (!empty($countdata['issue']) && ($countdata['issue'] > 0) && ($countdata['patched'] > 0)) ? round( ($countdata['issue']/$countdata['patched']) * 100 )."%" : '0%';
		$discontpercent = (!empty($countdata['Retired']) && ($countdata['Retired'] > 0)) && ($countdata['patched'] > 0) ? round( ($countdata['Retired']/$countdata['patched']) * 100 )."%" : '0%';

		$pendingpatchedpercent_pie = (!empty($countdata['pendingpatching']) && ($countdata['pendingpatching'] > 0)) ? round( ($countdata['pendingpatching']/$countdata['all']) * 100 ) : 0;
		$patchedpercent_pie = (!empty($countdata['patched']) && ($countdata['patched'] > 0)) ? round( ($countdata['patched']/$countdata['all']) * 100 ) : 0;
		$pendingpercent_pie = (!empty($countdata['pending']) && ($countdata['pending'] > 0) && ($countdata['patched'] > 0)) ? round( ($countdata['pending']/$countdata['patched']) * 100 ) : 0;
		$verifiedpercent_pie = (!empty($countdata['verified']) && ($countdata['verified'] > 0) && ($countdata['patched'] > 0)) ? round( ($countdata['verified']/$countdata['patched']) * 100 ) : 0;
		$issuespercent_pie = (!empty($countdata['issue']) && ($countdata['issue'] > 0) && ($countdata['patched'] > 0)) ? round( ($countdata['issue']/$countdata['patched']) * 100 ) : 0;
		$discontpercent_pie = (!empty($countdata['Retired']) && ($countdata['Retired'] > 0) && ($countdata['patched'] > 0)) ? round( ($countdata['Retired']/$countdata['patched']) * 100 ) : 0;
	?>
	<div class="progress progress-striped active md">
		<div class="progress-bar progress-bar-primary"  title="<?php echo $countdata['pending']; ?> Nodes" style="width: <?php echo $pendingpercent; ?>"><?php echo $countdata['pending']; ?></div>
		<div class="progress-bar progress-bar-success"  title="<?php echo $countdata['verified']; ?> Nodes" style="width: <?php echo $verifiedpercent; ?>"><?php echo $countdata['verified']; ?></div>
		<div class="progress-bar progress-bar-danger" title="<?php echo $countdata['issue']; ?> Nodes" style="width: <?php echo $issuespercent; ?>"><?php echo $countdata['issue']; ?></div>
		<div class="progress-bar progress-bar-warning" title="<?php echo $countdata['Retired']; ?> Nodes" style="width: <?php echo $discontpercent; ?>"><?php echo $countdata['Retired']; ?></div>
	</div>
	<?php if($countdata['pending'] > 0) { ?>
	<p><span class="label label-primary"><b>Pending:</b> <?php echo $countdata['pending']; ?> Nodes &nbsp; <?php echo $pendingpercent; ?></span></p>
	<?php } ?>
	
	<?php if($countdata['verified'] > 0) {  ?>
	<p><span class="label label-success"><b>Verified:</b> <?php echo $countdata['verified']; ?> Nodes &nbsp; <?php echo $verifiedpercent; ?></span></p>
	<?php } ?>
	
	<?php if($countdata['issue'] > 0) {  ?>
	<p><span class="label label-danger"><b>Issues:</b> <?php echo $countdata['issue']; ?> Nodes &nbsp; <?php echo $issuespercent; ?></span></p>
	<?php } ?>
	
	<?php if($countdata['Retired'] > 0) { ?>
	<p><span class="label label-warning"><b>Retired:</b> <?php echo $countdata['Retired']; ?> Nodes &nbsp; <?php echo $discontpercent; ?></span></p>
	<?php } ?>
	<p></p>
<div id="container" style="height: 300px; margin: 0 auto; display:none;"></div>
	
</div>


<style>
.label {
	font-size:90%!important;
}
.highcharts-title {
	font-size: 14px!important;
	width: 100%!important;
}
@media screen {
#container123, #container {
	width: 180px!important;
}
}
</style>
<script>
var piechartdata = [],
series = 3;

<?php if($patchedpercent_pie > 0) { 
$unpatchedpercent_pie = 100 - $patchedpercent_pie;	
$unpatchedpercent = $countdata['all'] - $countdata['patched'];	
?>
piechartdata.push({
	name: 'Patched : <?php echo $patchedpercent_pie; ?>% (<?php echo $countdata['patched']; ?> Nodes)',
	y: <?php echo $patchedpercent_pie; ?>,
	color: "#439B43"	
});
piechartdata.push({
	name: 'Pending : <?php echo $unpatchedpercent_pie; ?>% (<?php echo $unpatchedpercent; ?> Nodes)',
	y: <?php echo $unpatchedpercent_pie; ?>,
	color: "#3276B0"	
});
<?php } ?>


                    
                    
var categoriesdata=new Array();
<?php if(!empty($disp_multilevelchart) && $disp_multilevelchart == 1) { ?>
//var seldatestr = $( "#change_schedule option:selected" ).text();
var myList = document.getElementById("change_schedule");
var seldatestr = myList.options[myList.selectedIndex].text;
var colors=new Array();
colors[0] = "#BE81F7";
colors[1] = "#FE9A2E";
colors[2] = "#088A08";
colors[3] = "#A9BCF5";
colors[4] = "#424242";
colors[5] = "#F78181";
colors[6] = "#071918";
colors[7] = "#3B240B";
colors[8] = "#428BCA";
colors[9] = "#5CB85C";
colors[10] = "#5BC0DE";
colors[11] = "#F0AD4E";
colors[12] = "#8CACC6";
colors[13] = "#D9534F";
colors[14] = "#5FB404";
colors[15] = "#243B0B";
colors[16] = "#0B4C5F";
colors[17] = "#380B61";
colors[18] = "#013ADF";
var titledata = "Verification status  "+seldatestr;
var schtitledata = "Scheduling status  "+seldatestr;
var categoriesdata=new Array();
var drildowndata=new Array();
<?php if(count($multipie_res)>0) { 
	$loop = 0;
foreach ($multipie_res as $empname => $empdetails) {
	$cates = implode("', '", array_keys($empdetails['grpbytype']));
	$cate_vals = implode(", ", $empdetails['grpbytype']);
	$nodescount = $empdetails['nodescount'];
?>
categoriesdata[<?php echo $loop; ?>] = '<?php echo $empname; ?>';
drildowndata[<?php echo $loop; ?>]={
                    y: <?php echo $empdetails['totalpercent']; ?>,
                    color: colors[<?php echo $loop; ?>],
                    drilldown: {
                        name: '<?php echo $empname; ?>',
                        categories: ['<?php echo $cates; ?>'],
                        data: [<?php echo $cate_vals; ?>],
                        color: colors[<?php echo $loop; ?>]
                    }
                };
<?php
$loop++;
}
 } ?>
<?php } ?>
</script>
<?php } ?>

					<div class="panel panel-default">
						<div class="panel-heading">
						<a style="color:#FFFFFF; text-decoration:none;"><b>RNI Verification – Issues</b></a>
						</div>
						<div class="panel-body viewmappingslist" id="viewmappingslist" style="display:show;">
								<table class="table table-bordered sortableTable " id ="newscheduling-table">
                                    <thead>
                                        <tr>
                                            <th width="40%">RNI/ Node<i class="icon-sort"></i><i class="icon-sort-down"></i> <i class="icon-sort-up"></i></th>
                                            <th width="60%">Comments<i class="icon-sort"></i><i class="icon-sort-down"></i> <i class="icon-sort-up"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody>
										
										<?php
											if (!empty($postpatch_issues) && count($postpatch_issues)>0) {
												foreach ($postpatch_issues as $oneschedule) {													
													$actions1 = "";													
													$tdclass = "";			
													
												$downloadlink = ($oneschedule['verified_attachment_rand'] != "") ? anchor("dpa/dashboard/download_verification_doc/".$oneschedule['idpostpatch_schedule'], 'Download', array('title'=>'Download')) : "" ;	
												
												$verifiedcommentshelp = (strlen(trim($oneschedule['verifiedcomments'])) > 0) ? '<span title="'.$oneschedule['verifiedcomments'].'" data-toggle="modal" data-target="#buttonedModali_'.$oneschedule['idpostpatch_schedule'].'" style="float:right; cursor:pointer; text-decoration:underline; font-size: 80%; color: #3391F7; vertical-align:bottom;">more</span>' : '';
												$morelink = (strlen(trim($oneschedule['verifiedcomments'])) > 0) ? '<span title="'.$oneschedule['verifiedcomments'].'" data-toggle="modal" data-target="#buttonedModali_'.$oneschedule['idpostpatch_schedule'].'" style="cursor:pointer">...</span>' : '';
												
												$verifiedon = (!empty($oneschedule['verifiedon']) && $oneschedule['verifiedon'] != "0000-00-00") ? $this->commonclass->dateformat1($oneschedule['verifiedon']) : "";	
												$verificationstatus = $oneschedule['verificationstatus'];									
										?>
										 <tr>
                                            <td class=" <?php echo $tdclass; ?>"><?php echo $oneschedule['rni_node']; ?></td>
                                            <td class=" <?php echo $tdclass; ?>">
                                            <?php 
												echo ucfirst(substr($oneschedule['verifiedcomments'], 0, 75));
												echo (strlen($oneschedule['verifiedcomments']) > 75) ? $morelink : '';
												echo $verifiedcommentshelp; 
											?>
                                            <?php if ((strlen(trim($oneschedule['verifiedcomments'])) > 0 || !empty($oneschedule['verified_attachment_rand']))) { ?>
											<div class="modal fade" id="buttonedModali_<?php echo $oneschedule['idpostpatch_schedule']; ?>" tabindex="-1" role="dialog"  aria-labelledby="myModalLabel" aria-hidden="true">
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
																	<td><?php echo $verifiedon; ?> by <?php echo ucwords($oneschedule['dpa_flexinet']); ?></td>
																</tr>
																<tr>
																	<td valign="top"><b>Reported email ID</b></td>
																	<td><?php echo $oneschedule['verified_tomail']; ?></td>
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
                 <!--TABLE, PANEL, ACCORDION AND MODAL  -->

                
            </div>

        </div>
        <!--END PAGE CONTENT -->

    
<?php

//$rightmenudata['countdata'] = $countdata;
//$rightmenudata['disp_multilevelchart'] = 0;
//$this->load->view('layout/'.$this->sel_theam_path.'/dpa_rightmenu', $rightmenudata); ?>
