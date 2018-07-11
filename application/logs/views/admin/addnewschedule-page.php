<?php $this->load->view('layout/'.$this->sel_theam_path.'/leftmenu'); ?>


<style>
.custom-dd {
	width:auto!important;
	min-height:150px;
	min-width:150px;
} 
/*.custom-dd option {
	display:inline-block;
}*/
</style>
			
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
                              <b> Add Post Patch Verification</b>
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
									<div class="col-lg-12">
										<div id="collapseOne" class="accordion-body collapse in body">
                                    <form class="form-horizontal" id="savedatatem" method="post" enctype="multipart/form-data">
										<div class="form-group">
                                            <label class="control-label col-lg-2" style="text-align:left!important">Scheduled on</label>
                                            <div class="col-lg-4">
                                               <input type="text" id="scheduledon" name="scheduledon" class="form-control" autocomplete="off">
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="control-label col-lg-2" style="text-align:left!important">DPA</label>

                                            <div class="col-lg-4">
                                                <select name="sel_dpa" id="dpaname_0">
												   <?php
													if(count($users_res)>0) {
														foreach ($users_res as $oneuser) {
															$key = $oneuser['username']."__".$oneuser['id_user']."__".$oneuser['email'];
													?>
														<option value="<?php echo $key; ?>"><?php echo ucwords($oneuser['username']); ?></option>
													<?php
														}
													}
												   ?>

                                               </select>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="control-label col-lg-2">&nbsp;</label>

                                            <div class="col-lg-6" style="display: inline">
												<table width="100%">
													<tr>
														<td valign="middle" width="40%">
															<label >Available Nodes</label>
															<select id="select1" MULTIPLE class=" chzn-done custom-dd ">
															   <?php
																if(count($nodes_res)>0) {
																	foreach ($nodes_res as $onenode) {
																		$key = $onenode['idrninodes_master']."__".$onenode['rninode']."__".$onenode['default_time']."__".$onenode['rniname'];
																?>
																	<option value="<?php echo $key; ?>"><?php echo $onenode['rniname']; ?></option>
																<?php
																	}
																}
															   ?>
														   </select> 															
														</td>
														<td valign="middle" width="20%">
															<a id="add" title="Add" ><img src="<?php echo $this->baseurl;?>assets/default/img/arrow1.png" height="18" width="20" /></a>
															<br/>
															<a id="remove" title="Remove"><img src="<?php echo $this->baseurl;?>assets/default/img/arrow2.png" height="18" width="20" /></a>
														</td>
														<td valign="middle" width="40%">
															<label >Selected Nodes</label>
															<select  id="select2" multiple name="sel_nodes[]" class=" chzn-done custom-dd ">
															</select>
														</td>
													</tr>
												</table>
                                            </div>
                                        </div>
                 
                                         
                 
                                        <!--
                                        
                                        
                                        <div id="itemRows"></div>
                                        
                                        <a id="addScnt" onclick="addRow(this.form);" >Assign Nodes for another DPA</a>
                                        
                                        -->
                                        
                                        <div class="form-actions no-margin-bottom" style="text-align:center;">
											<br/> &nbsp;
                                            <!-- <input type="submit" value="Show Report" class="btn btn-primary " name="submit" onclick="selallopts();"  /> &nbsp; -->
                                            <a onclick="savedataintemp();" class="btn btn-primary " id="show-report" >Show Report</a> &nbsp;
                                            <?php echo anchor("admin/dashboard/cleartemp", 'Reset', array('title'=>'Reset', 'class' => 'btn btn-danger')); ?> &nbsp;
                                            <?php echo anchor("admin/dashboard/index", 'Cancel', array('title'=>'Cancel', 'class' => 'btn btn-danger')); ?>
                                            <br/>
                                        </div>

                                    </form>
                                    <br/>
                                </div>
										<br/>
										
									<!--<link href="assets/dropzone/css/dropzone.css" type="text/css" rel="stylesheet" />
									<form action="uploadexcel.php" class="dropzone"></form>	-->
									</div>
									
									<div class="clear"></div><br/>
									
									<div class="col-lg-12" id="disp_rec_confirm">
									
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
$rightmenudata['disp_multilevelchart'] = 0;
$this->load->view('layout/'.$this->sel_theam_path.'/rightmenu', $rightmenudata); ?>

   
