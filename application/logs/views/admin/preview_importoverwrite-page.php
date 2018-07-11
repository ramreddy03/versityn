<?php 
$this->load->view('layout/'.$this->sel_theam_path.'/leftmenu'); 
		
		$users_res = $this->commonclass->retrive_records("users", " * ", "(id_role = 2)");
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
                               <h5>
									Post patching verification details preview
								  </select>
                               </h5>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                  
                                  <div id="sortableTable" class="body collapse in">
							<form name="savepatchingstatus" method="post" action="<?php echo site_url("admin/dashboard/overwriteimport"); ?>" id="frmsavepatchingstatus"> 
							
                                <table class="table table-bordered sortableTable " id ="report1-table">
                                    <thead>
                                        <tr>
											<th width="15%">Scheduled Date</th>
											<th width="15%">Scheduled Time</th>
											<th width="50%">RNI / Node</th>
											<th width="15%">Verifier</th>
                                        </tr>
                                    </thead>
                                    <tbody  class="patching_cbs">
										<?php
											if (count($postpatch_import_temp)>0) {
												foreach ($postpatch_import_temp as $onerec) {
													
						/* if (count($users_res)>0) {
								$dpadropdown = '<select id="updatedpa_temp__'.$onerec['idpostpatch_schedule'].'" onchange="updatedpa_temp_fn(\'updatedpa_temp__'.$onerec['idpostpatch_schedule'].'\');">';
								foreach ($users_res as $oneuserdetails) {	
									$seluserdetai = ($oneuserdetails['id_user'] == $onerec['dpa_flexinet_id']) ?  'selected="Selected"' : "";	
									$selvalue_dpa = $onerec['idpostpatch_schedule']."__".$oneuserdetails['id_user']."__".$oneuserdetails['username'];
									$dpadropdown .= '<option value="'.$selvalue_dpa.'" '.$seluserdetai.'>'.ucwords($oneuserdetails['username']).'</option>';
								}
								$dpadropdown .= '</select>';
							} */
											$where = "(id_user='".$onerec['dpa_flexinet_id']."')";
											$exist_dpa = $this->commonclass->retrive_records("users", " * ", $where, array(), 1);
											$dpaid = (!empty($exist_dpa[0]['id_user'])) ? $exist_dpa[0]['id_user'] : 0;
											
												$firstname = (!empty($exist_dpa[0]['firstname'])) ? $exist_dpa[0]['firstname'] : '';
												$lastname = (!empty($exist_dpa[0]['lastname'])) ? $exist_dpa[0]['lastname'] : '';
												$email = (!empty($exist_dpa[0]['email'])) ? $exist_dpa[0]['email'] : '';
												$fullname = $firstname." ".$lastname;
												
												
										$dpadropdown = ucwords($onerec['dpa_flexinet']);
										$dpadetails =  $fullname."___".$email."___".$onerec['rni_node']."___".$onerec['time'];	
										?>
                                        <tr>
												<td>
													<input type="hidden" name="change_patchstatuscbs[]" value="<?php echo $dpadetails; ?>" />
													<?php echo $onerec['scheduledate']; ?></td>
												<td><?php echo $onerec['time']; ?></td>
												<td><?php echo $onerec['rni_node']; ?></td>
												<td><?php echo $dpadropdown; ?></td>
                                        </tr>
										<?php
												}
											}
										?>
                                    </tbody>
                                </table>
                                
								<div style="float:left; text-align: right; display: inline; margin-bottom: 5px; width:100%;">
									<input type="checkbox" name="sendemails" value="1" checked /> &nbsp; Notify verifier via email <br/>
									<input type="hidden" name="scheduleid" value="<?php echo $onerec['scheduledate']; ?>" /> 
								<a title="Save" class="btn btn-primary" onclick="updatepostpatch();">Save</a>
								<a title="Cancel" class="btn btn-primary" onclick="viewexceldetails_temp('<?php echo $onerec['scheduledate']; ?>');">Cancel Import</a>
								</div>
                                </form>
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

    
