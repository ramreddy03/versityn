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
									<?php echo anchor("admin/dashboard/index", '<img src="'.$this->baseurl.'assets/default/img/close.png" height="20" width="20" />', array('title'=>'Close', 'style' => 'float:right;')); ?>
									
									<?php echo anchor("admin/dashboard/exporttoxlsheet/".$scheduleid, '<img src="'.$this->baseurl.'assets/default/img/xlsicon.png" height="20" width="20" />', array('title'=>'Export to excel', 'style' => 'float:right; margin: 0px 5px;')); ?>&nbsp; &nbsp;
							
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
                                <div class="table-responsive">
                                  
                                  <div id="sortableTable" class="body collapse in">
                                <table class="table table-bordered sortableTable responsive-table" id ="viewsource-table">
                                    <thead>
                                        <tr>
                                            <th>Time<i class="icon-sort"></i><i class="icon-sort-down"></i> <i class="icon-sort-up"></i></th>
                                            <th>RNI/Node<i class="icon-sort"></i><i class="icon-sort-down"></i> <i class="icon-sort-up"></i></th>
                                            <th>AEM/DPA/FLEXI NET OP</th>
                                            <th>Verification Status</th>
                                            <th>Verified on</th>
                                            <th>Comments</th>
                                        </tr>
                                    </thead>
                                    <tbody>
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
													
													$verifiedon = (!empty($oneschedule['verifiedon']) && $oneschedule['verifiedon'] != "0000-00-00") ? $this->commonclass->dateformat1($oneschedule['verifiedon']) : "";
										?>
                                        <tr class="<?php echo $trclass; ?>">
                                            <td><?php echo $oneschedule['time']; ?></td>
                                            <td><?php echo $oneschedule['rni_node']; ?></td>
                                            <td><?php echo $oneschedule['dpa_flexinet']; ?></td>
                                            <td><?php echo $verificationstatus; ?></td>
                                            <td><?php echo $verifiedon; ?></td>
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
$rightmenudata['multipie_res'] = $multipie_res;
$this->load->view('layout/'.$this->sel_theam_path.'/dpa_rightmenu', $rightmenudata); ?>
