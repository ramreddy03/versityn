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
                        <h1> Users </h1>
                    </div>
                </div>

                 <!--TABLE, PANEL, ACCORDION AND MODAL  -->
			  <div class="row">							  
				  <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                              <b>  Users</b>
                              <?php //echo anchor("admin/cpanel/index", '<img src="'.$this->baseurl.'assets/default/img/close.png" height="20" width="20" />', array('title'=>'Close', 'style' => 'float:right;')); ?>&nbsp;  &nbsp; 
                               <?php echo anchor("admin/cpanel/usersform", '<i class="icon-plus-sign-alt" style="float:right; color: #FFFFFF!important; font-size: 18px; margin-right:5px;"></i>', array('title'=>'Add new user')); ?>&nbsp; &nbsp; 
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                  
                                  <div id="sortableTable" class="body collapse in">
                                <table class="table table-bordered sortableTable responsive-table" id ="dashboard-table">
                                    <thead>
                                        <tr>
                                            <th width="10%">User name<i class="icon-sort"></i><i class="icon-sort-down"></i> <i class="icon-sort-up"></i></th>
                                            <th width="10%">First name<i class="icon-sort"></i><i class="icon-sort-down"></i> <i class="icon-sort-up"></i></th>
                                            <th width="10%">Last name<i class="icon-sort"></i><i class="icon-sort-down"></i> <i class="icon-sort-up"></i></th>
                                            <th width="15%">E-mail<i class="icon-sort"></i><i class="icon-sort-down"></i> <i class="icon-sort-up"></i></th>
                                            <th width="15%">Escalation e-mail<i class="icon-sort"></i><i class="icon-sort-down"></i> <i class="icon-sort-up"></i></th>
                                            <th width="10%">Role<i class="icon-sort"></i><i class="icon-sort-down"></i> <i class="icon-sort-up"></i></th>
                                            <th width="20%">Actions<i class="icon-sort"></i><i class="icon-sort-down"></i> <i class="icon-sort-up"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody>										
										<?php
											if (count($userslist)>0) {
												foreach ($userslist as $onerec) {													
													$actions1 = "";													
													$tdclass = "";
													$rnislink = "";														
													$viewdetailslink = anchor("admin/cpanel/usersform/".$onerec['id_user'], $onerec['username'], array('title'=>'Edit details'));
													$rnislink = anchor("admin/cpanel/addrnis/".$onerec['id_user'], "RNI Nodes", array('title'=>'Manage RNI Nodes'));
													
													if($onerec['isactive'] == 0) {
														$statuslink = '<a style="cursor:pointer" id="'.$onerec['id_user'].'" onclick="changestatus('.$onerec['id_user'].',1, \''.$onerec['username'].'\', \'Activate\');">Activate</a> ';
													} elseif ($onerec['isactive'] == 1) {
														$statuslink = '<a style="cursor:pointer" id="'.$onerec['id_user'].'" onclick="changestatus('.$onerec['id_user'].',0, \''.$onerec['username'].'\', \'De-activate\');">De-activate</a> ';
													} else {
														$statuslink = "";
														$rnislink = "";														
													} 
										?>
										 <tr>
                                            <td class=" <?php echo $tdclass; ?>"><u><?php echo $viewdetailslink; ?></u></td>
                                            <td class=" <?php echo $tdclass; ?>"><?php echo $onerec['firstname']; ?></td>
                                            <td class=" <?php echo $tdclass; ?>"><?php echo $onerec['lastname']; ?></td>
                                            <td class=" <?php echo $tdclass; ?>"><?php echo $onerec['email']; ?></td>
                                            <td class=" <?php echo $tdclass; ?>"><?php echo $onerec['escalation_email']; ?></td>
                                            <td class=" <?php echo $tdclass; ?>"><?php echo !empty($roleslist[$onerec['id_role']]) ? $roleslist[$onerec['id_role']] : ""; ?></td>
                                            <td class=" <?php echo $tdclass; ?>"><?php echo $statuslink." &nbsp; ".$rnislink; ?></td>
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
										 <p class="text-warning">Click on <b>First name</b> to edit/view details</p>
									</td>
									<td width="50%" align="right">
									</td>
								</tr>
                            </table>
                                  </div>
                            </div>
                        </div>
                        
                    </div>

                </div>
                 <!--TABLE, PANEL, ACCORDION AND MODAL  -->
				<?php
					if (count($tempuserslist)>0) {
				?>
                 <!--TABLE, PANEL, ACCORDION AND MODAL  -->
				  <div class="row">							  
					  <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                              <b> New account requests</b>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">                                  
                                  <div id="sortableTable" class="body collapse in">
                                <table class="table table-bordered sortableTable responsive-table normaldata-table">
                                    <thead>
                                        <tr>
                                            <th width="10%">Username<i class="icon-sort"></i><i class="icon-sort-down"></i> <i class="icon-sort-up"></i></th>
                                            <th width="10%">First name<i class="icon-sort"></i><i class="icon-sort-down"></i> <i class="icon-sort-up"></i></th>
                                            <th width="10%">Last name<i class="icon-sort"></i><i class="icon-sort-down"></i> <i class="icon-sort-up"></i></th>
                                            <th width="15%">E-mail<i class="icon-sort"></i><i class="icon-sort-down"></i> <i class="icon-sort-up"></i></th>
                                            <th width="15%">Escalation e-mail<i class="icon-sort"></i><i class="icon-sort-down"></i> <i class="icon-sort-up"></i></th>
                                            <th width="10%">Role<i class="icon-sort"></i><i class="icon-sort-down"></i> <i class="icon-sort-up"></i></th>
                                            <th width="20%">Actions<i class="icon-sort"></i><i class="icon-sort-down"></i> <i class="icon-sort-up"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody>										
										<?php
											if (count($tempuserslist)>0) {
												foreach ($tempuserslist as $onerec) {
													
													$actions1 = "";
													
													$tdclass = "";
													$rnislink = "";	
													
													$createlink = '<a style="cursor:pointer" id="'.$onerec['id_user'].'" onclick="createuser('.$onerec['id_user'].', \''.$onerec['username'].'\');">Accept</a> ';
													$rejectlink = '<a style="cursor:pointer" id="'.$onerec['id_user'].'" onclick="rejectuser('.$onerec['id_user'].', \''.$onerec['username'].'\');">Reject</a> ';
										?>
										 <tr>
                                            <td class=" <?php echo $tdclass; ?>"><?php echo $onerec['username']; ?></td>
                                            <td class=" <?php echo $tdclass; ?>"><?php echo $onerec['lastname']; ?></td>
                                            <td class=" <?php echo $tdclass; ?>"><?php echo $onerec['lastname']; ?></td>
                                            <td class=" <?php echo $tdclass; ?>"><?php echo $onerec['email']; ?></td>
                                            <td class=" <?php echo $tdclass; ?>"><?php echo $onerec['escalation_email']; ?></td>
                                            <td class=" <?php echo $tdclass; ?>"><?php echo !empty($roleslist[$onerec['id_role']]) ? $roleslist[$onerec['id_role']] : ""; ?></td>
                                            <td class=" <?php echo $tdclass; ?>"><?php echo $createlink; ?>  &nbsp; <?php echo $rejectlink; ?></td>
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
<?php } ?>                
            </div>
        </div>
    <!--END PAGE CONTENT -->   
    
<?php $this->load->view('layout/'.$this->sel_theam_path.'/rightmenu'); ?>
  
<script type="text/javascript">
	function changestatus(id_user, newstatus, dispname, lblalert) {
		if (confirm("Are you sure to "+lblalert+" "+dispname+"?")) {
			if (test = prompt('Comments')) {
				$.post("<?php echo site_url('admin/cpanel/change_user_status/'); ?>/"+id_user+"/"+newstatus+"",{comments:test} ,function(data)
				{
					window.location.href= '<?php echo current_url(); ?>';
				});
			} else {
				alert('Status not changed');
			}
		}
	}
	function createuser(id_user, dispname) {
		if (confirm("Are you sure to create account for "+dispname+"?")) {
				$.post("<?php echo site_url('admin/cpanel/create_user_status/'); ?>/"+id_user+"",{} ,function(data)
				{
					window.location.href= '<?php echo current_url(); ?>';
				});			
		}
	}
	function rejectuser(id_user, dispname) {
		if (confirm("Are you sure to reject request of "+dispname+"?")) {
			if (test = prompt('Comments')) {
				$.post("<?php echo site_url('admin/cpanel/reject_user_status/'); ?>/"+id_user+"",{} ,function(data)
				{
					window.location.href= '<?php echo current_url(); ?>';
				});		
			} else {
				alert('Request not changed');
			}	
		}
	}
</script>
