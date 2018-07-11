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
                            <?php echo anchor("admin/dashboard/uploadexcel", 'Import From Excel', array('title'=>'Import from excel', 'style' => 'color:#FFFFFF!important;float:right;')); ?>
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
                                               <input type="text" id="masterslist_scheduledon" name="scheduledon" class="form-control" autocomplete="off">
                                            </div>
                                        </div>
                                        
                                        
										<div class="form-group">
                                            <label class="control-label col-lg-2" style="text-align:left!important">Choose From List</label>
                                            <div class="col-lg-4">
												 <select name="sel_masterslist" id="sel_masterslist">
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
                                               </select>
                                            </div>
                                        </div>
                                        
                                        
                                        
                                        </form>
                                              <br/>
                                </div>
										<br/>
										
									<!--<link href="assets/dropzone/css/dropzone.css" type="text/css" rel="stylesheet" />
									<form action="uploadexcel.php" class="dropzone"></form>	-->
									</div>
									
									<div class="clear"></div><br/>
									
									<div class="col-lg-12" id="disp_records_confirm">
									
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
