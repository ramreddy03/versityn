<?php $this->load->view('layout/'.$this->sel_theam_path.'/leftmenu'); ?>

<!-- PAGE LEVEL STYLES -->
<link href="<?php echo $this->baseurl;?>assets/default/css/layout2.css" rel="stylesheet" />
<link href="<?php echo $this->baseurl;?>assets/plugins/flot/examples/examples.css" rel="stylesheet" />
<link rel="stylesheet" href="<?php echo $this->baseurl;?>assets/plugins/timeline/timeline.css" />
<!-- END PAGE LEVEL  STYLES -->
    

	<!--PAGE CONTENT -->
        <div id="content">
             
            <div class="inner" style="min-height: 700px;">
                <div class="row">
                    <div class="col-lg-12">
                        <h1> Roles </h1>
                    </div>
                </div>
                 
                  

                 <!--TABLE, PANEL, ACCORDION AND MODAL  -->
                          <div class="row">
							  
							  <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                              <b>  Roles</b>
                              <?php //echo anchor("admin/cpanel/index", '<img src="'.$this->baseurl.'assets/default/img/close.png" height="20" width="20" />', array('title'=>'Close', 'style' => 'float:right;')); ?>&nbsp;  &nbsp; 
                               <?php echo anchor("admin/cpanel/userrolesform", '<i class="icon-plus-sign-alt" style="float:right; color: #FFFFFF!important; font-size: 18px; margin-right:5px;"></i>', array('title'=>'Add new user')); ?>&nbsp; &nbsp; 
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                  
                                  <div id="sortableTable" class="body collapse in">
                                <table class="table table-bordered sortableTable responsive-table" id ="dashboard-table">
                                    <thead>
                                        <tr>
                                            <th width="15%">Role<i class="icon-sort"></i><i class="icon-sort-down"></i> <i class="icon-sort-up"></i></th>
                                            <th width="17%">Actions<i class="icon-sort"></i><i class="icon-sort-down"></i> <i class="icon-sort-up"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody>
										
										<?php
											if (count($userroleslist)>0) {
												foreach ($userroleslist as $onerec) {
													
													//$viewdetailslink = anchor("admin/dashboard/viewexceldetails/".$oneschedule['idpostpatch_upload'], 'View', array('title'=>'View details'));
													$actions1 = "";
													
													$tdclass = "";
													//$viewdetailslink = "";
													
												/*	if (strtotime($oneschedule['scheduledon']) < time() && round($verification_percent) < 100) {
														$tdclass = "text-danger"; // class="success"
													} else if (strtotime($oneschedule['scheduledon']) < time()) {
														$tdclass = "text-muted"; // class="success"
													} else if (strtotime($oneschedule['scheduledon']) > time() && (round($verification_percent) > 0 && round($verification_percent) < 100)) {
														$tdclass = "text-primary"; // class="success"
													} else if (strtotime($oneschedule['scheduledon']) > time() && (round($verification_percent) == 100)) {
														$tdclass = "text-success"; // class="success"
													}
												*/
													
													$viewdetailslink = anchor("admin/cpanel/userrolesform/".$onerec['iduser_role'], $onerec['role'], array('title'=>'View details'));
										?>
										 <tr>
                                            <td class=" <?php echo $tdclass; ?>"><u><?php echo $viewdetailslink; ?></u></td>
                                            <td class=" <?php echo $tdclass; ?>">&nbsp;</td>
                                        </tr>

										<?php
													
												}
											}
										?>

                                       
                                       

                                    </tbody>
                                </table>
                            </div>
                            <table width="99%">
								<tr>
									<td width="50%">
										 <p class="text-warning">Click on <b>Role</b> to edit/view details</p>
									</td>
									<td width="50%" align="right">
									<!--	<ul class="list-inline">											
											<li><a class="btn btn-primary btn-xs btn-circle btn-grad">&nbsp;</a> : Pending</li>
											<li><a class="btn btn-success btn-xs btn-circle btn-grad">&nbsp;</a> : Verified</li>
											<li><a class="btn btn-danger btn-xs btn-circle btn-grad">&nbsp;</a> : Issue</li>
										</ul> -->
									</td>
								</tr>
                            </table>
                           
								
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
