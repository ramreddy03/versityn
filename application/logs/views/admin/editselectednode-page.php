<?php $this->load->view('layout/'.$this->sel_theam_path.'/leftmenu'); 
$scheduledateorg =  $selnodedetails[0]['scheduledate'];
$scheduledate = (!empty($selnodedetails[0]['scheduledate']) && $selnodedetails[0]['scheduledate'] != "0000-00-00") ? $this->commonclass->dateformat1($selnodedetails[0]['scheduledate']) : "00/00/0000";
$scheduletime = $selnodedetails[0]['time'];
$rninode = $selnodedetails[0]['rni_node'];
$saveddpaid = $selnodedetails[0]['dpa_flexinet_id'];

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
                              <b> Manage Post Patch Verification</b>
                              <?php 
                              echo $viewdetailslink = anchor("admin/dashboard/viewexceldetails/".$scheduledateorg, '<img src="'.$this->baseurl.'assets/default/img/close.png" height="20" width="20" />', array('title'=>'View details', 'style' => 'float:right;'));
                               //echo $scheduledateorg. anchor("admin/dashboard/viewexceldetails/"+$scheduledateorg, '<img src="'.$this->baseurl.'assets/default/img/close.png" height="20" width="20" />', array('title'=>'Close', 'style' => 'float:right;')); ?>
                            <?php //echo anchor("admin/dashboard/uploadexcel", 'Import From Excel', array('title'=>'Import from excel', 'style' => 'color:#FFFFFF!important;float:right;')); ?>
                            </div>
                            <div class="panel-body">
								<?php
									if(!empty($disp_msg)) {
								?>
									<h4 class="text-success" style="text-align:center"><?php echo $disp_msg; ?></h4><br/>
								<?php
									}
								?>
								<form class="form-horizontal" id="editselectednode" method="post" enctype="multipart/form-data">
										<div class="form-group">
                                            <label class="control-label col-lg-2" style="text-align:left!important">Schedule date&time</label>
                                              <label class="control-label col-lg-4" style="text-align:left!important"><?php echo $scheduledate." &nbsp; ".$scheduletime; ?></label>
                                        </div>
										<div class="form-group">
                                            <label class="control-label col-lg-2" style="text-align:left!important">RNI/Node&time</label>
                                              <label class="control-label col-lg-4" style="text-align:left!important"><?php echo $rninode; ?></label>
                                        </div>
                                         <div class="form-group">
                                            <label class="control-label col-lg-2" style="text-align:left!important">Verifier</label>

                                            <div class="col-lg-4">
                                                <select name="sel_dpa" id="dpaname_editpage">
												   <?php
													if(count($users_res)>0) {
														foreach ($users_res as $oneuser) {
															$key = $oneuser['username']."__".$oneuser['id_user']."__".$oneuser['email'];
															$seldpaopt = ($saveddpaid == $oneuser['id_user']) ? 'selected="Selected"' : '';
													?>
														<option value="<?php echo $key; ?>" <?php echo $seldpaopt; ?>><?php echo $oneuser['firstname']." ".$oneuser['lastname']." (".$oneuser['username'].")"; ?></option>
													<?php
														}
													}
												   ?>

                                               </select>
                                            </div>
                                        </div>
                                        
                                         <?php 
                                $date123 = strtotime($scheduledateorg);
                                $date456 = strtotime(date('Y-m-d'));  
                                //$disablebtn = ($date123 > $date456) ? ' disabled="Disabled"' : '';
                               // $scheduleid_arr = explode("-", $scheduleid);
                               // $scheduleid_disp = date("dS M Y", mktime(0, 0, 0, $scheduleid_arr[1], $scheduleid_arr[2], $scheduleid_arr[0]));
                              
                              if ($date123 <= $date456) {
                                ?>
                                
                                
                                         <div class="form-group">
                                            <label class="control-label col-lg-2" style="text-align:left!important">Patching Status</label>
                                            <?php
												$pendingselected = ($selnodedetails[0]['patchingstatus'] == "Pending") ? 'checked="Checked"' : '';
												$patchedselected = ($selnodedetails[0]['patchingstatus'] == "Completed") ? 'checked="Checked"' : '';
                                            ?>
                                            <div class="col-lg-4">
                                               <label class="radio-inline">
												 <input type="radio" name="patchstatus" value="Pending" class="patchstatus" style="padding-left:0px!important; margin-top:0px!important; vertical-align:middle" <?php echo $pendingselected; ?>> Pending &nbsp;
											  </label>
											  
											  <label class="radio-inline">
												 <input type="radio" name="patchstatus"  value="Completed" class="patchstatus" style="padding-left:0px!important; margin-top:0px!important; vertical-align:middle" <?php echo $patchedselected; ?>> Patched
											  </label>
                                            </div>
                                        </div>
                                        <?php /* if($selnodedetails[0]['patchingstatus'] == "Completed") { ?>
										<div class="form-group">
                                            <label class="control-label col-lg-2" style="text-align:left!important">Verification Status</label>
                                            <?php
												$vpendingselected = ($selnodedetails[0]['verificationstatus'] == "Pending") ? 'checked="Checked"' : '';
												$vpatchedselected = ($selnodedetails[0]['verificationstatus'] == "Verified") ? 'checked="Checked"' : '';
												$vissueselected = ($selnodedetails[0]['verificationstatus'] == "Issue") ? 'checked="Checked"' : '';
                                            ?>
                                            <div class="col-lg-4">
                                               <label class="radio-inline">
												 <input type="radio" name="verificationstatus" value="Pending" class="patchstatus" style="padding-left:0px!important; margin-top:0px!important; vertical-align:middle" <?php echo $vpendingselected; ?>> Pending &nbsp;
											  </label>
											  
											  <label class="radio-inline">
												 <input type="radio" name="verificationstatus"  value="Verified" class="patchstatus" style="padding-left:0px!important; margin-top:0px!important; vertical-align:middle" <?php echo $vpatchedselected; ?>> Verified
											  </label>
											  
											  <label class="radio-inline">
												 <input type="radio" name="verificationstatus"  value="Issue" class="patchstatus" style="padding-left:0px!important; margin-top:0px!important; vertical-align:middle" <?php echo $vissueselected; ?>> Issue
											  </label>
                                            </div>
                                        </div>
										<div class="form-group">
                                            <label class="control-label col-lg-2" style="text-align:left!important">Verification Comments</label>
                                            <?php
												$verifiedcomments = $selnodedetails[0]['verifiedcomments'];
                                            ?>
                                            <div class="col-lg-4">
												<textarea name="verifiedcomments" ><?php echo $verifiedcomments; ?></textarea>
                                              
                                            </div>
                                        </div>
										<div class="form-group">
                                            <label class="control-label col-lg-2" style="text-align:left!important">Verification Attachment</label>
                                            <?php
												$verifieddoc = (!empty($selnodedetails[0]['verified_attachment_name'])) ? $selnodedetails[0]['verified_attachment_name'] : "-";
                                            ?>
                                            <div class="col-lg-4">
												<?php echo $verifieddoc; ?>
                                              
                                            </div>
                                        </div>
                                        <?php } */ ?>
                                       
								   <?php } else { ?> 
								   <input type="hidden" name="patchstatus"  value="Pending">
								   <input type="hidden" name="verificationstatus"  value="Pending">
								   <input type="hidden" name="patchedon"  value="0000-00-00">
								   <input type="hidden" name="verificationstatus"  value="Pending">
								   <input type="hidden" name="verifiedon"  value="0000-00-00">
								   <?php } ?>
										<input type="hidden" name="scheduledateorg" value= "<?php echo $scheduledateorg; ?>" />
										<input type="submit" name="submit" value= "Update" class="btn btn-primary " />
								</form>
								
                            </div>
                        </div>
                        
                    </div>

                </div>
                 <!--TABLE, PANEL, ACCORDION AND MODAL  --> 
            </div>

        </div>
        <!--END PAGE CONTENT -->


<?php 

$rightmenudata['disp_multilevelchart'] = 0;
$this->load->view('layout/'.$this->sel_theam_path.'/rightmenu', $rightmenudata); ?>
