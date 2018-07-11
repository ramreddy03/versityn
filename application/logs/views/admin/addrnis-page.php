<?php
	$this->load->view('layout/'.$this->sel_theam_path.'/leftmenu'); 
	
	$id_role = (!empty($userslist['id_role']) && $userslist['id_role'] != "") ? $userslist['id_role'] : '';
	$username = (!empty($userslist['username']) && $userslist['username'] != "") ? $userslist['username'] : '';
	$firstname = (!empty($userslist['firstname']) && $userslist['firstname'] != "") ? $userslist['firstname'] : '';
	$lastname = (!empty($userslist['lastname']) && $userslist['lastname'] != "") ? $userslist['lastname'] : '';
	$email = (!empty($userslist['email']) && $userslist['email'] != "") ? $userslist['email'] : '';
	$contact = (!empty($userslist['contact']) && $userslist['contact'] != "") ? $userslist['contact'] : '';
	
	$formtitle = ($seluserid > 0) ? "Manage RNI/ Nodes" : "" ;
	
	 $rninode = !empty($userslist['rninodes'])? $userslist['rninodes']:'';
	 $test = explode(",",$rninode);
?>

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
                              <h4> <?php echo $formtitle; ?></h4>
                            </div>
                            <div class="panel-body">
								<?php
									if(!empty($disp_msg)) {
								?>
									<h4 class="text-success"><?php echo $disp_msg;?></h4>
								<?php
									}
								?>
									<div class="col-lg-12">
										<div id="collapseOne" class="accordion-body collapse in body">
                                    <form class="form-horizontal" id="userform-rnis" method="post" enctype="multipart/form-data">

										
											<table width="100%">
											
											<tr>
												<td ><label><b> User: </b> </label>  
												<select  id="id_user" name="id_user">
												<option value=""> - Select - </option>
												<?php
													if(count($user)>0) {
														foreach ($user as  $dispval) {	
															$sel_role = ($seluserid == $dispval['id_user']) ? 'selected="Selected"' : '';
												?>
													<option value="<?php echo $dispval['id_user']."___".$dispval['username']; ?>" <?php echo $sel_role; ?>><?php echo $dispval['firstname']." ".$dispval['lastname']. " (". ucfirst($dispval['username']).")"; ?></option>
												<?php
														}
													}
												?>
                                               </select>
												</td>
											
											</tr>	
										
                                    
										<tr>
										<td>
										<table width="80%">
													<tr>
														<td valign="middle" width="40%">
															<label >Available Nodes</label>
															<select id="select1" MULTIPLE class=" chzn-done custom-dd ">
															   <?php
																if(count($rninodes)>0) {
																	foreach ($rninodes as $onenode) {
																		$key = $onenode['idrninodes_master'];
																?>
																	<option value="<?php echo $key; ?>"><?php echo $onenode['rniname']; ?></option>
																<?php
																	}
																}
															   ?>
															  
														   </select> 															
														</td>
														<td valign="middle" width="10%">
															<a id="add" title="Add" ><img src="<?php echo $this->baseurl;?>assets/default/img/arrow1.png" height="18" width="20" /></a>
															<br/>
															<a id="remove" title="Remove"><img src="<?php echo $this->baseurl;?>assets/default/img/arrow2.png" height="18" width="20" /></a>
														</td>
														<td valign="middle" width="50%">
															<label >Selected Nodes</label><div class="clear"></div>
															<select  id="select2" multiple name="sel_nodes[]" class=" chzn-done custom-dd ">
																 <?php
																if(count($seluserrninodes)>0) {
																	foreach ($seluserrninodes as $onenode) {
																		$key = $onenode['idrninodes_master'];
																?>
																	<option value="<?php echo $key; ?>"><?php echo $onenode['rniname']; ?></option>
																<?php
																	}
																}
															   ?>
															</select>
														</td>
													</tr>
												</table>
										</td>
										</tr>
											</table>
											<div style="clear:both;"></div>
                                          
											<div class="form-actions no-margin-bottom" style="text-align:center;">
												<br/> &nbsp;
												<input type="submit" value="Save" class="btn btn-primary " name="submit" id ="rninodessubmit" onclick="selectoptions();" /> &nbsp;
												<?php echo anchor("admin/cpanel/users_list", 'Cancel', array('title'=>'Cancel', 'class' => 'btn btn-danger')); ?>
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

   
<script type="text/javascript">
var usereditid = <?php echo $seluserid; ?>;


</script>
