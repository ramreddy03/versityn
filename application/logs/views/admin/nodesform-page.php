<?php
	$this->load->view('layout/'.$this->sel_theam_path.'/leftmenu'); 
	
	$rninode = (!empty($rninodeslist['rninode']) && $rninodeslist['rninode'] != "") ? $rninodeslist['rninode'] : '';
	$rniname = (!empty($rninodeslist['rniname']) && $rninodeslist['rniname'] != "") ? $rninodeslist['rniname'] : '';
	$default_time = (!empty($rninodeslist['default_time']) && $rninodeslist['default_time'] != "") ? $rninodeslist['default_time'] : '';
	$ncid = (!empty($rninodeslist['ncid']) && $rninodeslist['ncid'] != "") ? $rninodeslist['ncid'] : '';
	
	$formtitle = ($selid > 0) ? "Manage RNI / Node" : "Add New RNI / Node" ;
	
	$users_res = $this->commonclass->retrive_records("users", " * ", "(id_role = 3)");
	if (count($users_res)>0) {
		$dpadropdown = '<select id="updatedpa_temp" name="dpa_details">';
		foreach ($users_res as $oneuserdetails) {	
			$seluserdetai = (!empty($rninodeslist['dpa_id']) && $oneuserdetails['id_user'] == $rninodeslist['dpa_id']) ?  'selected="Selected"' : "";	
			$selvalue_dpa = $oneuserdetails['id_user']."__".$oneuserdetails['username'];
			$dpadropdown .= '<option value="'.$selvalue_dpa.'" '.$seluserdetai.'>'.$oneuserdetails['firstname'].' '.$oneuserdetails['lastname'].' ('.$oneuserdetails['username'].')</option>';
		}
		$dpadropdown .= '</select>';
	}
?>

<!-- PAGE LEVEL STYLES -->
<link href="<?php echo $this->baseurl;?>assets/default/css/layout2.css" rel="stylesheet" />
<link href="<?php echo $this->baseurl;?>assets/plugins/flot/examples/examples.css" rel="stylesheet" />
<link rel="stylesheet" href="<?php echo $this->baseurl;?>assets/plugins/timeline/timeline.css" />
<!-- END PAGE LEVEL  STYLES -->
    
    
	<!--PAGE CONTENT -->
        <div id="content">
             
            <div class="inner" style="min-height: 700px;">
           <br/>

                 <!--TABLE, PANEL, ACCORDION AND MODAL  -->
                          <div class="row">
							  
							  <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                              <h4> <?php echo $formtitle; ?></h4>
                            </div>
                            <div class="panel-body">
								
								<?php
									if(!empty($disp_msg)) {
								?>
									<h4 class="text-success" style="text-align:center"><?php echo $disp_msg; ?></h4><br/>
								<?php
									}
								?>
									<div class="col-lg-12">
										<div id="collapseOne" class="accordion-body collapse in body">
										<?php if($selid == 0) { ?>
										<div class="form-group col-lg-12">
										<label class="control-label col-lg-2" style="text-align:left!important">Choose Type</label>
										<div class="col-lg-9">
										  <label class="radio-inline">
											  
											<?php
												$defaultselected = " checked='Checked'";
											?>
											 <input type="radio" name="addmethodtype" value="manual" class="addnodesmethod" style="padding-left:0px!important; margin-top:0px!important; vertical-align:middle" <?php echo $defaultselected; ?>> Manual process &nbsp;
										  </label>
										       
										  <label class="radio-inline">
											 <input type="radio" name="addmethodtype"  value="import" class="addnodesmethod" style="padding-left:0px!important; margin-top:0px!important; vertical-align:middle"> Import Excel
										  </label>
                                               
                                            </div>
											</div>
										<div class="clear"></div>
										<?php } ?>
										
										
										<!-- RNI Nodes form starts here -->	
										<div id="nodes_manualform" style="display:show;" class=" col-lg-12">
											<div class="clear"></div>
											<br/>
										<form class="form-horizontal" id="rninodeform-validate" method="post" enctype="multipart/form-data">
											<div class="form-group col-lg-6">
												<label class="control-label col-lg-4" style="text-align:left!important">RNI / Node</label>

												<div class="col-lg-6">
												   <input type="text" id="rniname" name="rniname" class="form-control" value="<?php echo $rniname; ?>" />
												</div>
											</div>
											

											<div class="form-group col-lg-6">
												<label class="control-label col-lg-4" style="text-align:left!important">RNI ID</label>

												<div class="col-lg-6">
												   <input type="text" id="rninode" name="rninode" class="form-control" value="<?php echo $rninode; ?>" />
												</div>
											</div>
											
											

											<div class="form-group col-lg-6">
												<label class="control-label col-lg-4" style="text-align:left!important">Default Time</label>

												<div class="col-lg-6">
												   <input type="text" id="default_time" name="default_time" class="form-control" value="<?php echo $default_time; ?>" />
												</div>
											</div>											
											
											

											<div class="form-group col-lg-6">
												<label class="control-label col-lg-4" style="text-align:left!important">NC ID</label>

												<div class="col-lg-6">
												   <input type="text" id="ncid" name="ncid" class="form-control" value="<?php echo $ncid; ?>" />
												</div>
											</div>											
											
											

											<div class="form-group col-lg-6">
												<label class="control-label col-lg-4" style="text-align:left!important">Verifier</label>

												<div class="col-lg-6">
												   <?php echo $dpadropdown ; ?>
												</div>
											</div>
											
											 
										<div style="clear:both;"></div>
											  
												<div class="form-actions no-margin-bottom" style="text-align:center;">
													<br/> &nbsp;
													<input type="submit" value="Save" class="btn btn-primary " name="submit" /> &nbsp;
													<?php echo anchor("admin/cpanel/nodes_list", 'Cancel', array('title'=>'Cancel', 'class' => 'btn btn-primary')); ?>
													<br/>
												
											</div>

										</form>
										<br/>
										</div>	
										<!-- RNI Nodes form ends here -->
										
										
										<!-- RNI Nodes Import from excel starts here -->
										<div id="nodes_excelsheet" style="display:none;" class=" col-lg-12">
											<div class="clear"></div><p>&nbsp;</p>
											<table border="0" width="98%" style="float:left">
												<tr>
												<td valign="top" width="47%" style="padding-left:15px!important;">
												<form class="form-horizontal" id="importnodesexcel" action="<?php echo site_url("admin/cpanel/importnodesexcel"); ?>" method="post" enctype="multipart/form-data">
													<div class="form-group">
														<label class="control-label col-lg-4" style="text-align:left!important">Upload File</label>
														<input type="file" id="uploadfile" name="uploadfile" class="custom-file-input" />
														<div class="clear"></div>
														
													</div>
														<div class="clear"></div>
													<div class="form-group">
														<label class="control-label col-lg-4" style="text-align:left!important">&nbsp;</label>
														<input type="submit" name="submit" value= "Preview" class="btn btn-primary " />
													</div>
												</form>
												</td>
												<td valign="top" width="39%" align="left">
												<div class="alert alert-warning col-lg-12" style="padding:10px!important;margin-top:5px;">
															Make sure,
															<br/>
															<ul>
																<li><b>RNI ID's</b> should be start from <b>Cell A5</b></li>
																<li><b>RNI/Node names</b> should start from <b>Cell B5 </b> </li>
																<li><b>Default time</b> should start from <b>Cell C5 </b> </li>
																<li><b>Verifier/ Alloted to</b> should start from <b>Cell D5 </b> </li>
																<li><b>NC ID</b> should start from <b>Cell E5 </b> </li>
																<li>Change format of all cells to <b>General</b></li>
															</ul>	<br/>														
														<?php echo anchor("admin/cpanel/downloadsamplenodes", "<strong>Download Sample File</strong>", array('title'=>'Download')); ?><br/>
														<?php $sampleimage_path = $this->baseurl."assets/default/img/RNI_sample.png"; ?>
														<?php echo anchor("admin/cpanel/downloadsamplenodes", '<img src="'.$sampleimage_path.'" alt="Download Sample File" width="250px" />', array('title'=>'Download')); ?><br/>
														
														</div>
												</td>
												</tr>
												</table>
										</div>
										<!-- RNI Nodes Import from excel ends here -->
										
										</div>
										<br/>
										
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

   
