<?php $this->load->view('layout/'.$this->sel_theam_path.'/leftmenu'); ?>


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
                            <?php echo anchor("admin/dashboard/addnewschedule", 'Add New', array('title'=>'Add new scheduling', 'style' => 'color:#FFFFFF!important;float:right;')); ?>
                            </div>
                            <div class="panel-body">
								<?php
									if(!empty($disp_msg)) {
								?>
									<h4 class="text-success" style="text-align:center"><?php echo $disp_msg; ?></h4><br/>
								<?php
									}
								?>
									<div class="col-lg-8">
										<div id="collapseOne" class="accordion-body collapse in body">
                                    <form class="form-horizontal" id="block-validate" method="post" enctype="multipart/form-data">

                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Scheduled on</label>
                                            <div class="col-lg-4">
                                               <input type="text" id="scheduledonupload" name="scheduledon" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Description</label>

                                            <div class="col-lg-4">
                                               <textarea rows="4" class="form-control" name="description"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Upload File</label>

                                            <div class="col-lg-4">
                                                <input type="file" id="uploadfile" name="uploadfile" />
                                                <br/>
                                                <?php echo anchor("admin/dashboard/downloadsampleupload", "<strong>Sample File</strong>", array('title'=>'Download')); ?>
                                            </div>
                                        </div>

                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-lg-4">&nbsp;</label>
                                            <label class="control-label col-lg-4">
                                               <input type="checkbox" id="savetomasters" name="savetomasters" value="save"> Save to masters list</label>

                                        </div>
                                        
                                        <div><br><br><br></div>

                                        
                                        <div class="form-actions no-margin-bottom" style="text-align:center;">
											<br/> &nbsp;
                                            <input type="submit" value="Save" class="btn btn-primary " name="submit" id="submitupd" /> &nbsp;
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
									
                            </div>
                        </div>
                        
                    </div>

                </div>
                 <!--TABLE, PANEL, ACCORDION AND MODAL  -->

                
            </div>

        </div>
        <!--END PAGE CONTENT -->

    
<?php $this->load->view('layout/'.$this->sel_theam_path.'/rightmenu'); ?>

   
