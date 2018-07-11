<?php
	$this->load->view('layout/'.$this->sel_theam_path.'/leftmenu'); 
	
	$username = !empty($logindata['username']) ? $logindata['username'] : '';
	$firstname = !empty($logindata['firstname']) ? $logindata['firstname'] : '';
	$lastname = !empty($logindata['lastname']) ? $logindata['lastname'] : '';
	$email = !empty($logindata['email']) ? $logindata['email'] : '';
	$contact = !empty($logindata['contact']) ? $logindata['contact'] : '';
	
?>


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
                        <h1> My Account </h1>
                    </div>
                </div>
                

                 <!--TABLE, PANEL, ACCORDION AND MODAL  -->
                          <div class="row">
							  
							  <div class="col-lg-12">
								 
                        <div class="panel panel-default">
                            <div class="panel-heading">
                              <b> Manage My Profile</b>
                            </div>
                            <div class="panel-body">
								 <?php
									if(!empty($disp_msg)) {
								?>
									<h4 class="text-success" style="text-align:center;"><?php echo $disp_msg; ?></h4><br/>
								<?php
									}
								?>
								<table width="100%">
									<tr>
										<td width="50%" valign="top">
											<h4>My Profile</h4><br/>
											<form method="post" id="myaccount">
										<div class="form-group col-lg-10">
                                            <label class="control-label col-lg-12">Username</label>
                                            <div class="col-lg-8">
                                                <input type="text" class="form-control" value="<?php echo $username; ?>" readonly="Readonly" />
                                            </div>
                                        </div>

										<!-- <div class="form-group col-lg-6">
                                            <label class="control-label col-lg-4">Role</label>
                                            <div class="col-lg-4">
                                                <input type="text" class="form-control" value="<?php //echo $role; ?>" readonly="Readonly"  />
                                            </div>
                                        </div> -->

										<div class="form-group col-lg-10">
                                            <label class="control-label col-lg-12">Email</label>
                                            <div class="col-lg-8">
                                                <input type="text" class="form-control" value="<?php echo $email; ?>" readonly="Readonly"  />
                                            </div>
                                        </div>

										<div class="form-group col-lg-10">
                                            <label class="control-label col-lg-12">First Name</label>
                                            <div class="col-lg-8">
                                                <input type="text" id="firstname" name="firstname" class="form-control" value="<?php echo $firstname; ?>" />
                                            </div>
                                        </div>

										<div class="form-group col-lg-10">
                                            <label class="control-label col-lg-12">Last Name</label>
                                            <div class="col-lg-8">
                                                <input type="text" id="lastname" name="lastname" class="form-control" value="<?php echo $lastname; ?>" />
                                            </div>
                                        </div>

										<div class="form-group col-lg-10">
                                            <label class="control-label col-lg-12">Phone</label>
                                            <div class="col-lg-8">
                                                <input type="text" id="contact" name="contact" class="form-control" value="<?php echo $contact; ?>" />
                                            </div>
                                        </div>
                                         <div style="clear:both;"></div>
                                          
											<div class="form-actions no-margin-bottom col-lg-8" style="text-align:left;">
												<br/> &nbsp;
												<input type="submit" value="Save Profile" class="btn btn-primary " name="submit" /> &nbsp;
												<br/>
												</div>
												</form>
										</td>
										
										
										<td width="50%" valign="top">
										
										<h4>Change Password</h4><br/>
											<form method="post" id="changepassword">
										

										<div class="form-group col-lg-10">
                                            <label class="control-label col-lg-12">New Password</label>
                                            <div class="col-lg-8">
                                                <input type="password" id="newpassword" name="newpassword" class="form-control" value="" />
                                            </div>
                                        </div>

										<div class="form-group col-lg-10">
                                            <label class="control-label col-lg-12">Re-type New Password</label>
                                            <div class="col-lg-8">
                                                <input type="password" id="rpwd" name="rpwd" class="form-control" value="" />
                                            </div>
                                        </div>

                                         <div style="clear:both;"></div>
                                          
											<div class="form-actions no-margin-bottom col-lg-8" style="text-align:left;">
												<br/> &nbsp;
												<input type="submit" value="Change Password" class="btn btn-primary " name="submit" /> &nbsp;
												<br/>
												</div>
												</form>
										</td>
									</tr>
								</table>
								
								<div class ="clear"></div>
<br/>
<br/>
<br/>
							</div>
                        </div>
                        
                    </div>

                </div>
                 <!--TABLE, PANEL, ACCORDION AND MODAL  -->

                
            </div>

        </div>
        <!--END PAGE CONTENT -->

    
<?php $this->load->view('layout/'.$this->sel_theam_path.'/rightmenu'); ?>
