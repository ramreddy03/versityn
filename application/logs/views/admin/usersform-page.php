<?php
	$this->load->view('layout/'.$this->sel_theam_path.'/leftmenu'); 
	
	$id_role = (!empty($userslist['id_role']) && $userslist['id_role'] != "") ? $userslist['id_role'] : '';
	$username = (!empty($userslist['username']) && $userslist['username'] != "") ? $userslist['username'] : '';
	$firstname = (!empty($userslist['firstname']) && $userslist['firstname'] != "") ? $userslist['firstname'] : '';
	$lastname = (!empty($userslist['lastname']) && $userslist['lastname'] != "") ? $userslist['lastname'] : '';
	$email = (!empty($userslist['email']) && $userslist['email'] != "") ? $userslist['email'] : '';
	$escalation_email = (!empty($userslist['escalation_email']) && $userslist['escalation_email'] != "") ? $userslist['escalation_email'] : '';
	$contact = (!empty($userslist['contact']) && $userslist['contact'] != "") ? $userslist['contact'] : '';
		$readonly_edit = (!empty($userslist['username']) && $userslist['username'] != "") ? ' readonly="Readonly"' : '';
	
	$formtitle = ($seluserid > 0) ? "Manage user" : "Add new user" ;
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
                                    <form class="form-horizontal" id="userform-validate" method="post" enctype="multipart/form-data">



										<div class="form-group col-lg-6">
                                            <label class="control-label col-lg-4" style="text-align:left!important">Role</label>
                                            <div class="col-lg-6">
                                               <select  id="id_role" name="id_role" class="form-control">
												<option value=""> - Select - </option>
												<?php
													if(count($roleslist)>0) {
														foreach ($roleslist as $roleid => $dispval) {
															$sel_role = ($roleid == $id_role) ? 'selected="Selected"' : '';
												?>
													<option value="<?php echo $roleid; ?>" <?php echo $sel_role; ?>><?php echo $dispval; ?></option>
												<?php
														}
													}
												?>
                                               </select>
                                            </div>
                                        </div>
                                        
										<div class="form-group col-lg-6">
                                            <label class="control-label col-lg-4" style="text-align:left!important">Username</label>

                                            <div class="col-lg-6">
                                               <input type="text" id="username" name="username" class="form-control"  value="<?php echo $username; ?>" <?php echo $readonly_edit; ?> />
                                            </div>
                                        </div>
                                        
                                        <div class="form-group col-lg-6">
                                            <label class="control-label col-lg-4" style="text-align:left!important">First name</label>

                                            <div class="col-lg-6">
                                               <input type="text" id="firstname" name="firstname" class="form-control" value="<?php echo $firstname; ?>" />
                                            </div>
                                        </div>
                                        

                                         <div class="form-group col-lg-6">
                                            <label class="control-label col-lg-4" style="text-align:left!important">Last name</label>

                                            <div class="col-lg-6">
                                               <input type="text" id="lastname" name="lastname" class="form-control" value="<?php echo $lastname; ?>">
                                            </div>
                                        </div> 
                                        
                                        <div class="form-group col-lg-6">
                                            <label class="control-label col-lg-4" style="text-align:left!important">E-mail</label>

                                            <div class="col-lg-6">
                                               <input type="text" id="email" name="email" class="form-control" value="<?php echo $email; ?>">
                                            </div>
                                        </div>
                                        
                                         <div class="form-group col-lg-6">
                                            <label class="control-label col-lg-4" style="text-align:left!important">Phone</label>

                                            <div class="col-lg-6">
                                               <input type="text" id="contact" name="contact" class="form-control" value="<?php echo $contact; ?>">
                                            </div>
                                        </div>
                                        
                                         <div class="form-group col-lg-6">
                                            <label class="control-label col-lg-4" style="text-align:left!important">Escalation E-mail</label>

                                            <div class="col-lg-6">
                                              <textarea id="escalation_email" name="escalation_email" class="form-control" ><?php echo $escalation_email; ?></textarea>
                                              <div style="clear:both;"></div>
                                               <span class="text-warning">Use comma(,) to seperate multiple emails</span> 
                                            </div>
                                        </div>
                                        
                                        <?php if ($seluserid > 0) { ?>
                                        
                                         <div class="form-group col-lg-6">
                                            <label class="control-label col-lg-4" style="text-align:left!important">Comments</label>

                                            <div class="col-lg-6">
                                               <textarea id="comments" name="comments" class="form-control"></textarea>
                                            </div>
                                        </div>
                                        <?php } ?>
                                         
                                    <div style="clear:both;"></div>
                                          
											<div class="form-actions no-margin-bottom" style="text-align:center;">
												<br/> &nbsp;
												<input type="submit" value="Save" class="btn btn-primary " name="submit" /> &nbsp;
												<?php echo anchor("admin/cpanel/users_list", 'Cancel', array('title'=>'Cancel', 'class' => 'btn btn-primary')); ?>
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
var usereditid = <?php echo $seluserid; ?>;
</script>
