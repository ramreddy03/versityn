<?php
	$this->load->view('layout/'.$this->sel_theam_path.'/leftmenu'); 
	
	$role = (!empty($userroleslist['role']) && $userroleslist['role'] != "") ? $userroleslist['role'] : '';
	
	$formtitle = ($selid > 0) ? "Manage Role" : "Add new role" ;
	
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
									<h4 class="text-success"></h4>
								<?php
									}
								?>
									<div class="col-lg-12">
										<div id="collapseOne" class="accordion-body collapse in body">
                                    <form class="form-horizontal" id="rolesform-validate" method="post" enctype="multipart/form-data">


										<div class="form-group col-lg-6">
                                            <label class="control-label col-lg-4">Role</label>

                                            <div class="col-lg-4">
                                               <input type="text" id="role" name="role" class="form-control" value="<?php echo $role; ?>" />
                                               
                                            </div>
                                        </div>
                                        
                                         
                                    <div style="clear:both;"></div>
                                          
											<div class="form-actions no-margin-bottom" style="text-align:center;">
												<br/> &nbsp;
												<input type="submit" value="Save" class="btn btn-primary " name="submit" /> &nbsp;
												<?php echo anchor("admin/cpanel/userroles_list", 'Cancel', array('title'=>'Cancel', 'class' => 'btn btn-danger')); ?>
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

   
<script>
var roleeditid = <?php echo $selid; ?>;
</script>
