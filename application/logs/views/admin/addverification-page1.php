<?php $this->load->view('layout/'.$this->sel_theam_path.'/leftmenu'); ?>

<style>
#new_scheduledon, #manual_scheduledon {
	width: 125px!important;
}
.manualchoosenodes {
	height: 325px!important;
	max-width: 95%!important;
}
.custom-dd {
	width:auto!important;
	min-height:150px;
	min-width:150px;
} 
/*.custom-dd option {
	display:inline-block;
}*/
#content {
    transition: margin 0.4s ease 0s!important;
}

input[type="file"] {
	float:left;
}
</style>
			
<!-- PAGE LEVEL STYLES -->
<link href="<?php echo $this->baseurl;?>assets/default/css/datepicker.css" rel="stylesheet" />
<!-- END PAGE LEVEL  STYLES 
<!-- PAGE LEVEL STYLES  
<link href="<?php echo $this->baseurl;?>assets/default/css/layout2.css" rel="stylesheet" />
<link href="<?php echo $this->baseurl;?>assets/plugins/flot/examples/examples.css" rel="stylesheet" />
<link rel="stylesheet" href="<?php echo $this->baseurl;?>assets/plugins/timeline/timeline.css" />
<!-- END PAGE LEVEL  STYLES -->
    
    
	<!--PAGE CONTENT -->
        <div id="content">
             
            <div class="inner" style="min-height: 700px;">
           <div class="row">
                    <div class="col-lg-9">
                        <h1> Post Patching Schedule </h1>
                    </div>
                </div>
                
                 <!--TABLE, PANEL, ACCORDION AND MODAL  -->
                          <div class="row">
							  
							  <div class="col-lg-8">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                              <b> Add Post Patching Schedule</b>
                            </div>
                            <div class="panel-body">
									<div class="col-lg-12  form-horizontal">
										 <?php
												if(!empty($disp_msg)) {
											?>
												<h4 class="text-success" style="text-align:center"><?php echo $disp_msg; ?></h4><br/>
											<?php
												}
											?>
										<div id="collapseOne" class="accordion-body collapse in body">
												
											<?php
												$defaultselected = " checked='Checked'";
											?>
											<div class="form-group">
										<label class="control-label col-lg-3" style="text-align:left!important">Choose Type</label>
										<div class="col-lg-9">
										  <label class="radio-inline">
											 <input type="radio" name="addmethodtype" value="import" class="addnewmethod" style="padding-left:0px!important; margin-top:0px!important; vertical-align:middle" <?php echo $defaultselected; ?>> Import Excel &nbsp;
										  </label>
										  
										  <label class="radio-inline">
											 <input type="radio" name="addmethodtype"  value="previous" class="addnewmethod" style="padding-left:0px!important; margin-top:0px!important; vertical-align:middle"> Create from prevoius session
										  </label>
                                               
										  <label class="radio-inline">
											 <input type="radio" name="addmethodtype"  value="manual" class="addnewmethod" style="padding-left:0px!important; margin-top:0px!important; vertical-align:middle"> Manual process
										  </label>
                                               
                                            </div>
											</div>
											
											
											
											<div class="importspread" style="display:show;" id="importfromspreadsheet123" >
												<table border="0" width="100%">
												<tr>
												<td valign="top" width="60%">
												<form class="form-horizontal" id="importfromspreadsheet" action="<?php echo site_url("admin/dashboard/importfromspreadsheet"); ?>" method="post" enctype="multipart/form-data">
													<div class="form-group">
														<label class="control-label col-lg-5" style="text-align:left!important">Upload File</label>
														<input type="file" id="uploadfile" name="uploadfile" class="custom-file-input" />
														<div class="clear"></div>
														
													</div>
														<div class="clear"></div>
													<div class="form-group">
														<label class="control-label col-lg-5" style="text-align:left!important">&nbsp;</label>
														<input type="submit" name="submit" value= "Preview" class="btn btn-primary " />
													</div>
												</form>
												</td>
												<td valign="top" width="39%" align="left">
												<div class="alert alert-warning col-lg-12" style="padding:10px!important;margin-top:5px;">
															Note:
															<br/>
															<ul>
																<li><b>Cell A1</b> should be <b>schedule date</b> in <b>yyyy-mm-dd</b> (OR) <b>yyyy/mm/dd</b>  format</li>
																<li><b>RNI/Node names</b> should start from <b>Cell B2 </b> </li>
																<li><b>Time slot</b> should start from <b>Cell D2 </b> (Optional)</li>
																<li><b>Verifier names</b> should start from <b>Cell E2 </b> (Optional)</li>
																<li><b>Verifier names</b> should be login usernames </li>
																<li>Change format of all cells to <b>General</b></li>
															</ul>	<br/>														
														<?php echo anchor("admin/dashboard/downloadsampleupload", "<strong>Download Sample File</strong>", array('title'=>'Download')); ?><br/>
														<?php $sampleimage_path = $this->baseurl."assets/default/img/sample_sheet.png"; ?>
														<?php echo anchor("admin/dashboard/downloadsampleupload", '<img src="'.$sampleimage_path.'" alt="Download Sample File" width="250px" />', array('title'=>'Download')); ?><br/>
														
														</div>
												</td>
												</tr>
												</table>
												
											</div>
											
											
											<div class="fromprevsession" style="display:none;">
												<div class="form-group">
													<label class="control-label col-lg-3" style="text-align:left!important">Schedule date</label>
													<div class="col-lg-4">
														<input type="text" id="new_scheduledon" name="new_scheduledon" class="form-control" autocomplete="off" />
													</div>
												</div>
											<div class="clear"></div>
												<div class="form-group">
													<label class="control-label col-lg-3" style="text-align:left!important">Choose previous session</label>
													<div class="col-lg-4">
														<select name="sel_previouslist" id="sel_previouslist">
															<option value=""> - Select - </option>
														   <?php				
															 if(count($lists_res)>0) {
																foreach ($lists_res as $onemaster) {
																	$dateexp = explode("-",$onemaster['list_id']);
																	$dd_disp = date("dS M Y", mktime(0, 0, 0, $dateexp[1], $dateexp[2], $dateexp[0]));
															?>
																<option value="<?php echo $onemaster['list_id']; ?>"> <?php echo $dd_disp; ?></option>
															<?php
																}
															} 
														   ?>
													   </select><br/>
												</div>
                                              
												</div>
											
											
											
											
									<div class="clear"></div><br/>
									
									<div class="col-lg-12" id="dispchangeval">
									
									</div>
									
									<div class="col-lg-12" id="disp_records_preview">
									
									</div>
											
									
											
											</div>
											
										
											<div class="manualentry" style="display:none;">
												<form class="form-horizontal" id="addmanualentry" action="<?php echo site_url("admin/dashboard/addmanualentry"); ?>" method="post" enctype="multipart/form-data">
													<div class="form-group">
														<label class="control-label col-lg-3" style="text-align:left!important">Schedule date</label>
														<div class="col-lg-4">
															<input type="text" id="manual_scheduledon" name="manual_scheduledon" class="form-control" autocomplete="off" />
														</div>
													</div>
													<div class="clear"></div>
													<div class="form-group">
														<!-- <label class="control-label col-lg-3" style="text-align:left!important">Choose Nodes</label> -->
														<div class="col-lg-12">
															<table width="100%">
																	<tr>
																		<td valign="middle" width="48%">
																			<label >Available Nodes</label> <br/>
																			<select id="select1" multiple="MULTIPLE" class=" chzn-done custom-dd manualchoosenodes ">
																			   <?php
																				if(count($nodes_res)>0) {
																					foreach ($nodes_res as $onenode) {
																						$key = $onenode['idrninodes_master']."__".$onenode['rniname']."__".$onenode['default_time']."__".$onenode['rninode']."__".$onenode['dpa_id']."__".$onenode['dpa_name'];
																				?>
																					<option value="<?php echo $key; ?>"><?php echo $onenode['rniname']; ?></option>
																				<?php
																					}
																				}
																			   ?>
																		   </select> 															
																		</td>
																		<td valign="middle" width="6%">
																			<a id="add" title="Add" ><img src="<?php echo $this->baseurl;?>assets/default/img/arrow1.png" height="18" width="20" /></a>
																			<br/>
																			<a id="remove" title="Remove"><img src="<?php echo $this->baseurl;?>assets/default/img/arrow2.png" height="18" width="20" /></a>
																		</td>
																		<td valign="middle" width="48%">
																			<label >Selected Nodes</label> <br/>
																			<select  id="select2" multiple name="sel_nodes[]" class=" chzn-done custom-dd manualchoosenodes ">
																			</select>
																		</td>
																	</tr>
																</table>
														   
														  <br/>
													</div>
												  
													</div>
												
													
														<input type="submit" name="submit" value= "Preview" class="btn btn-primary " />
												</form>
											</div>
											
											
									<div class="clear"></div><br/>
									
									
											
											
                                              <br/>
                                </div>
										<br/>
									</div>
									
									<div class="clear"></div><br/>
									
                            </div>
                        </div>
                        
                    </div>
                    
                 <!--TABLE, PANEL, ACCORDION AND MODAL  --> 
                 <!--Master list display starts here --> 
				<div class="col-lg-4">
					<div class="panel panel-default">
						<div class="panel-heading">
						<a onclick="showhidediv('viewmappingslist', 'idshowhidespan')" style="color:#FFFFFF; text-decoration:underline;"><b><span id="idshowhidespan">Show</span> Master list</b></a>
						</div>
						<div class="panel-body viewmappingslist" id="viewmappingslist" style="display:none;">
							<div class="col-lg-12  form-horizontal">
								<table class="table table-bordered sortableTable " id ="newscheduling-table">
                                    <thead>
                                        <tr>
                                            <th width="70%">RNI/ Node<i class="icon-sort"></i><i class="icon-sort-down"></i> <i class="icon-sort-up"></i></th>
                                            <th width="30%">Verifier<i class="icon-sort"></i><i class="icon-sort-down"></i> <i class="icon-sort-up"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody>
										
										<?php
											if (!empty($nodes_res) && count($nodes_res)>0) {
												foreach ($nodes_res as $onerec) {
													
													$actions1 = "";
													
													$tdclass = "";
													
													$viewdetailslink = anchor("admin/cpanel/nodesform/".$onerec['idrninodes_master'], $onerec['rninode'], array('title'=>'Edit details'));
													
													if($onerec['status'] == "D") {
														$statuslink = '<a style="cursor:pointer" id="'.$onerec['idrninodes_master'].'" onclick="changestatus('.$onerec['idrninodes_master'].',\'A\', \''.$onerec['rninode'].'\', \'Activate\');">Activate</a> ';
													} elseif ($onerec['status'] == "A") {
														$statuslink = '<a style="cursor:pointer" id="'.$onerec['idrninodes_master'].'" onclick="changestatus('.$onerec['idrninodes_master'].',\'D\', \''.$onerec['rninode'].'\', \'Retire\');">Retire</a> ';
													} else {
														$statuslink = "";														
													} 
										?>
										 <tr>
                                            <td class=" <?php echo $tdclass; ?>"><?php echo $onerec['rniname']; ?></td>
                                            <td class=" <?php echo $tdclass; ?>"><?php echo ucwords($onerec['dpa_name']); ?></td>
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
                 <!--Master list display ends here --> 
                
            </div>
            </div>
            </div>

        <!--END PAGE CONTENT -->

    
<?php $this->load->view('layout/'.$this->sel_theam_path.'/rightmenu'); ?>
<div style="clear:both;"></div>
<?php 
//$rightmenudata['disp_multilevelchart'] = 0;
//$this->load->view('layout/'.$this->sel_theam_path.'/rightmenu', $rightmenudata); ?>
