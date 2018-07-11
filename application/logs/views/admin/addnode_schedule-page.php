<?php $this->load->view('layout/'.$this->sel_theam_path.'/leftmenu'); 
/*$scheduledateorg =  $selnodedetails[0]['scheduledate'];
$scheduledate = (!empty($selnodedetails[0]['scheduledate']) && $selnodedetails[0]['scheduledate'] != "0000-00-00") ? $this->commonclass->dateformat1($selnodedetails[0]['scheduledate']) : "00/00/0000";
$scheduletime = $selnodedetails[0]['time'];
$rninode = $selnodedetails[0]['rni_node'];
$saveddpaid = $selnodedetails[0]['dpa_flexinet_id']; */
$tims = array(
			'12:00 PM - 3:00 PM',
			'3:00 PM - 6:00 PM',
		);
$scheduledateorg = $selscheduledate;
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
                              <b> Add new node </b>
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
								<form class="form-horizontal" id="addselectednode_schedule" method="post" enctype="multipart/form-data">
										<div class="form-group">
                                            <label class="control-label col-lg-2" style="text-align:left!important">Schedule date&time</label>
                                              <label class="control-label col-lg-4" style="text-align:left!important"><?php echo $selscheduledate; ?></label>
                                        </div>
										<div class="form-group">
                                            <label class="control-label col-lg-2" style="text-align:left!important">Time&time</label>
                                               <select name="time" id="time">
												   <?php
													if(count($tims)>0) {
														foreach ($tims as $onetim) {
													?>
														<option value="<?php echo $onetim; ?>"><?php echo $onetim; ?></option>
													<?php
														}
													}
												   ?>
                                               </select>
                                        </div>
										<div class="form-group">
                                            <label class="control-label col-lg-2" style="text-align:left!important">RNI/Node</label>
                                                <select name="rniname" id="rniname">
												   <?php
													if(count($remainingnodeslist)>0) {
														foreach ($remainingnodeslist as $onenode) {
													?>
														<option value="<?php echo $onenode['rniname']; ?>" ><?php echo $onenode['rniname']; ?></option>
													<?php
														}
													}
												   ?>

                                               </select>
                                        </div>
                                         <div class="form-group">
                                            <label class="control-label col-lg-2" style="text-align:left!important">Verifier</label>

                                                <select name="dpa_flexinet" id="dpa_flexinet">
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
                                               <input type="hidden" name="dpa_flexinet_id" id="dpa_flexinet_id" />
                                        </div>
                                    
								   <input type="hidden" name="patchstatus"  value="Pending">
								   <input type="hidden" name="verificationstatus"  value="Pending">
								   <input type="hidden" name="patchedon"  value="0000-00-00">
								   <input type="hidden" name="verifiedon"  value="0000-00-00">
								
										<input type="hidden" name="scheduledateorg" value= "<?php echo $scheduledateorg; ?>" />
										<input type="submit" name="submit" value= "Add" class="btn btn-primary " />
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
