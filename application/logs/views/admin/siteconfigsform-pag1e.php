<?php
	$this->load->view('layout/'.$this->sel_theam_path.'/leftmenu'); 
	
	$portalname = (!empty($siteconfigs['portalname']) && $siteconfigs['portalname'] != "") ? $siteconfigs['portalname'] : '';
	$baseurl = (!empty($siteconfigs['baseurl']) && $siteconfigs['baseurl'] != "") ? $siteconfigs['baseurl'] : '';
	$title = (!empty($siteconfigs['title']) && $siteconfigs['title'] != "") ? $siteconfigs['title'] : '';
	$offlinestatus_1 = (isset($siteconfigs['offlinestatus']) && $siteconfigs['offlinestatus'] == 1) ? 'checked = "checked"' : '';
	$offlinestatus_0 = (isset($siteconfigs['offlinestatus']) && $siteconfigs['offlinestatus'] == 0) ? 'checked = "checked"' : '';
	$offlinemessage = (!empty($siteconfigs['offlinemessage']) && $siteconfigs['offlinemessage'] != "") ? $siteconfigs['offlinemessage'] : '';
	$adminmailid = (!empty($siteconfigs['adminmailid']) && $siteconfigs['adminmailid'] != "") ? $siteconfigs['adminmailid'] : '';
	$webmastermailid = (!empty($siteconfigs['webmastermailid']) && $siteconfigs['webmastermailid'] != "") ? $siteconfigs['webmastermailid'] : '';
	$dateformat = (!empty($siteconfigs['dateformat']) && $siteconfigs['dateformat'] != "") ? $siteconfigs['dateformat'] : '';
	$patchingnotificationmails = (!empty($siteconfigs['patchingnotificationmails']) && $siteconfigs['patchingnotificationmails'] != "") ? $siteconfigs['patchingnotificationmails'] : '';
	$verificationnotificationmails = (!empty($siteconfigs['verificationnotificationmails']) && $siteconfigs['verificationnotificationmails'] != "") ? $siteconfigs['verificationnotificationmails'] : '';
	$verificationemails = (!empty($siteconfigs['verificationemails']) && $siteconfigs['verificationemails'] != "") ? $siteconfigs['verificationemails'] : '';
	$reportemails = (!empty($siteconfigs['reportemails']) && $siteconfigs['reportemails'] != "") ? $siteconfigs['reportemails'] : '';
	
	
	$cron_patching_hours = (!empty($siteconfigs['cron_patching_hours']) && $siteconfigs['cron_patching_hours'] != "") ? $siteconfigs['cron_patching_hours'] : '';
	$cron_verification_hours = (!empty($siteconfigs['cron_verification_hours']) && $siteconfigs['cron_verification_hours'] != "") ? $siteconfigs['cron_verification_hours'] : '';
	
	
	$textboxclass = " col-lg-6";
	$labelclass = " col-lg-5";
	$emptyclass = " col-lg-1";
	
?>


<!-- PAGE LEVEL STYLES -->
<link href="<?php echo $this->baseurl;?>assets/default/css/layout2.css" rel="stylesheet" />
<link href="<?php echo $this->baseurl;?>assets/plugins/flot/examples/examples.css" rel="stylesheet" />
<link rel="stylesheet" href="<?php echo $this->baseurl;?>assets/plugins/timeline/timeline.css" />
<style>
.form-horizontal .control-label {
	text-align: left!important;
}
</style>
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
                              <h4><i class="icon-wrench"></i>&nbsp; Site Settings</h4>
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
                                    <form class="form-horizontal" id="sitesettings-validate" method="post" enctype="multipart/form-data">
										
										<h4 class="text-primary">General settings</h4>
										<hr/><br/>
										
										
										<div class="form-group col-lg-6">
                                            <label class="control-label <?php echo $labelclass; ?>">Portal Name</label>
                                            <div class="<?php echo $textboxclass; ?>">
                                               <input type="text" id="portalname" name="portalname" class="form-control" value="<?php echo $portalname; ?>" />
                                            </div>
                                            <div class="<?php echo $emptyclass; ?>"></div>
                                        </div>
                                        
										<div class="form-group col-lg-6">
                                            <div class="<?php echo $emptyclass; ?>"></div>
                                            <label class="control-label <?php echo $labelclass; ?>">Title</label>

                                            <div class="<?php echo $textboxclass; ?>">
                                               <input type="text" id="title" name="title" class="form-control" value="<?php echo $title; ?>" />
                                            </div>
                                        </div>
                                        
                                        <div class="form-group col-lg-6">
                                            <label class="control-label <?php echo $labelclass; ?>">Base URL</label>

                                            <div class="<?php echo $textboxclass; ?>">
                                               <input type="text" id="baseurl" name="baseurl" class="form-control" value="<?php echo $baseurl; ?>" />
                                            </div>
                                            <div class="<?php echo $emptyclass; ?>"></div>
                                        </div>
                                        

                                       
                                       <input type="hidden" id="dateformat" name="dateformat" class="form-control" value="<?php echo $dateformat; ?>">
                                       <!--     <div class="form-group col-lg-6">
                                            <label class="control-label <?php echo $labelclass; ?>">Date Format</label>

                                            <div class="<?php //echo $textboxclass; ?>">
                                               <input type="text" id="dateformat" name="dateformat" class="form-control" value="<?php //echo $dateformat; ?>">
                                            </div>
                                        </div>  -->
                                        
                                        <div class="form-group col-lg-6">
                                            <div class="<?php echo $emptyclass; ?>"></div>
                                            <label class="control-label <?php echo $labelclass; ?>">Logo</label>

                                            <div class="<?php echo $textboxclass; ?>">
                                                <input type="file" id="logo_name" name="logo_name" />
                                                <br/>
                                                <?php // echo anchor("admin/dashboard/downloadsampleupload", "<strong>Sample File</strong>", array('title'=>'Download')); ?>
                                            </div>
                                        </div>
                                        
                                        
                                         <div class="form-group col-lg-6">
                                            <label class="control-label <?php echo $labelclass; ?>">Offline Status</label>

                                            <div class="<?php echo $textboxclass; ?>">
                                              <label class="radio-inline">
                                                 <input type="radio" id="offlinestatus_0" name="offlinestatus" value="0" <?php echo $offlinestatus_0; ?> style="padding-left:0px!important; margin-top:0px!important; vertical-align:middle"> Online &nbsp;
                                              </label>
                                              <label class="radio-inline">
                                                 <input type="radio" id="offlinestatus_1" name="offlinestatus" value="1" <?php echo $offlinestatus_1; ?> style="padding-left:0px!important; margin-top:0px!important; vertical-align:middle"> Offline
                                              </label>
                                            <div class="<?php echo $emptyclass; ?>"></div>
                                               
                                            </div>
                                        </div>
                                        
                                        <div class="form-group col-lg-6">
                                            <div class="<?php echo $emptyclass; ?>"></div>
                                            <label class="control-label <?php echo $labelclass; ?>">Offline Message</label>

                                            <div class="<?php echo $textboxclass; ?>">
                                               <textarea rows="4" class="form-control" name="offlinemessage" id="offlinemessage" /><?php echo $offlinemessage; ?></textarea>
                                            </div>
                                        </div>
                                        
                                        
                                    <div class="clear" style="clear:both;"></div><br/>
                                    	<h4 class="text-primary">Notification periods</h4>
										<hr/><br/>
										
                                    
                                     <div class="form-group col-lg-6">
                                            <label class="control-label <?php echo $labelclass; ?>">Pending patching alert after</label>

                                            <div class="<?php echo $textboxclass; ?>">
                                            <select id="cron_patching_hours" name="cron_patching_hours" >
												<option value=""> - Select - </option>
												<?php
													for($i=1; $i<=24; $i++) {
														$selected1 = ($i == $cron_patching_hours) ? 'selected="Selected"' : '';
												?>
												<option value="<?php echo $i; ?>" <?php echo $selected1; ?>><?php echo $i; ?></option>
												<?php
													}
												?>
                                            </select> hours
                                            <div class="<?php echo $emptyclass; ?>"></div>
                                            </div>
                                        </div>
                                        
                                    
                                     <div class="form-group col-lg-6">
                                            <div class="<?php echo $emptyclass; ?>"></div>
                                            <label class="control-label <?php echo $labelclass; ?>">Pending verification alert after</label>

                                            <div class="<?php echo $textboxclass; ?>">
                                             <select id="cron_verification_hours" name="cron_verification_hours" >
												<option value=""> - Select - </option>
												<?php
													for($i1=1; $i1<=24; $i1++) {
														$selected12 = ($i1 == $cron_verification_hours) ? 'selected="Selected"' : '';
												?>
												<option value="<?php echo $i1; ?>" <?php echo $selected12; ?>><?php echo $i1; ?></option>
												<?php
													}
												?>
                                            </select> hours
                                            </div>
                                        </div>
                                        
                                        
                                        
                                    <div class="clear" style="clear:both;"></div><br/>
                                    	<h4 class="text-primary">E-mails</h4>
										<hr/><br/>
										<p class="text-warning" style="font-weight:bold;">Use comma(,) to seperate multiple emails</p>
                                    
                                     <div class="form-group col-lg-6">
                                            <label class="control-label <?php echo $labelclass; ?>">Admin e-mail</label>

                                            <div class="<?php echo $textboxclass; ?>">
                                               <input type="text" id="adminmailid" name="adminmailid" class="form-control" value="<?php echo $adminmailid; ?>">
                                            </div>
                                            <div class="<?php echo $emptyclass; ?>"></div>
                                        </div>
                                        
                                        <div class="form-group col-lg-6">
                                            <div class="<?php echo $emptyclass; ?>"></div>
                                            <label class="control-label <?php echo $labelclass; ?>">Patching notification </label>

                                            <div class="<?php echo $textboxclass; ?>">
                                               <textarea rows="4" class="form-control" name="patchingnotificationmails" id="patchingnotificationmails" /><?php echo $patchingnotificationmails; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label class="control-label <?php echo $labelclass; ?>">Escalation Notification </label>

                                            <div class="<?php echo $textboxclass; ?>">
                                               <textarea rows="4" class="form-control" name="verificationnotificationmails" id="verificationnotificationmails" /><?php echo $verificationnotificationmails; ?></textarea>
                                            </div>
                                            <div class="<?php echo $emptyclass; ?>"></div>
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <div class="<?php echo $emptyclass; ?>"></div>
                                            <label class="control-label <?php echo $labelclass; ?>">Verification update e-mail</label>

                                            <div class="<?php echo $textboxclass; ?>">
                                               <textarea rows="4" class="form-control" name="verificationemails" id="verificationemails" /><?php echo $verificationemails; ?></textarea>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group col-lg-6">
                                            <label class="control-label <?php echo $labelclass; ?>">Report e-mails</label>

                                            <div class="<?php echo $textboxclass; ?>">
                                               <textarea rows="4" class="form-control" name="reportemails" id="reportemails" /><?php echo $reportemails; ?></textarea>
                                            </div>
                                            <div class="<?php echo $emptyclass; ?>"></div>
                                        </div>
                                        
                                         
                                    <div style="clear:both;"></div>
                                          
											<div class="form-actions no-margin-bottom" style="text-align:center;">
												<br/> &nbsp;
												<input type="submit" value="Save" class="btn btn-primary " name="submit" /> &nbsp;
												<?php // echo anchor("admin/cpanel/index", 'Cancel', array('title'=>'Cancel', 'class' => 'btn btn-danger')); ?>
												<br/>
											
                                        </div>

                                    </form>
                                    <br/>
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

   
