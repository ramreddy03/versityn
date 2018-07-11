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
                        <h1>  RNI / Nodes  </h1>
                    </div>
                </div>
                 
                  

                 <!--TABLE, PANEL, ACCORDION AND MODAL  -->
                          <div class="row">
							  
							  <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                              <b>   RNI / Nodes </b>
                              <?php //echo anchor("admin/cpanel/index", '<img src="'.$this->baseurl.'assets/default/img/close.png" height="20" width="20" />', array('title'=>'Close', 'style' => 'float:right;')); ?>&nbsp;  &nbsp; 
                               <?php echo anchor("admin/cpanel/nodesform", '<i class="icon-plus-sign-alt" style="float:right; color: #FFFFFF!important; font-size: 18px; margin-right:5px;"></i>', array('title'=>'Add new node')); ?>&nbsp; &nbsp; 
                               <?php echo anchor("admin/cpanel/nodesxlsheet", '<img src="'.$this->baseurl.'assets/default/img/xlsicon.png" height="20" width="20" />', array('title'=>'Export to excel', 'style' => 'float:right; margin: 0px 5px;')); ?>&nbsp; &nbsp;
							
                            </div>
                            <div class="panel-body">
								<?php
									if(!empty($disp_msg)) {
								?>
									<h4 class="text-success" style="text-align:center"><?php echo $disp_msg; ?></h4><br/>
								<?php
									}
								?>
                                <div class="table-responsive">
                                  
                                  <div id="sortableTable" class="body collapse in">
                                <table class="table table-bordered sortableTable responsive-table" id ="dashboard-table">
                                    <thead>
                                        <tr>
                                            <th width="10%">RNI ID<i class="icon-sort"></i><i class="icon-sort-down"></i> <i class="icon-sort-up"></i></th>
                                            <th width="30%">RNI Name<i class="icon-sort"></i><i class="icon-sort-down"></i> <i class="icon-sort-up"></i></th>
                                            <th width="20%">Default time<i class="icon-sort"></i><i class="icon-sort-down"></i> <i class="icon-sort-up"></i></th>
                                            <th width="20%">Verifier<i class="icon-sort"></i><i class="icon-sort-down"></i> <i class="icon-sort-up"></i></th>
                                            <th width="20%">Status<i class="icon-sort"></i><i class="icon-sort-down"></i> <i class="icon-sort-up"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody>
										
										<?php
											if (!empty($nodeslist) && count($nodeslist)>0) {
												foreach ($nodeslist as $onerec) {
													
													$actions1 = "";
													
													$tdclass = "";
													
													$viewdetailslink = anchor("admin/cpanel/nodesform/".$onerec['idrninodes_master'], $onerec['rninode'], array('title'=>'Edit details'));
													
													if($onerec['status'] == "D") {
														$statuslink = '<a style="cursor:pointer; text-decoration:under-line; color: #DB9009;" id="'.$onerec['idrninodes_master'].'" onclick="changestatus('.$onerec['idrninodes_master'].',\'A\', \''.$onerec['rninode'].'\', \'Activate\');">Activate</a> ';
														$statusstr = "Retired";
													} elseif ($onerec['status'] == "A") {
														$statuslink = '<a style="cursor:pointer; text-decoration:under-line; color: #DB9009;" id="'.$onerec['idrninodes_master'].'" onclick="changestatus('.$onerec['idrninodes_master'].',\'D\', \''.$onerec['rninode'].'\', \'Retire\');">Retire</a> ';
														$statusstr = "Active";
													} else {
														$statuslink = "";														
														$statusstr = "";														
													} 
										?>
										 <tr>
                                            <td class=" <?php echo $tdclass; ?>"><u><?php echo $viewdetailslink; ?></u></td>
                                            <td class=" <?php echo $tdclass; ?>"><?php echo $onerec['rniname']; ?></td>
                                            <td class=" <?php echo $tdclass; ?>"><?php echo $onerec['default_time']; ?></td>
                                            <td class=" <?php echo $tdclass; ?>"><?php echo ucwords($onerec['dpa_name']); ?></td>
                                            <td class=" <?php echo $tdclass; ?>"><?php echo $statusstr; ?> &nbsp; <?php echo $statuslink; ?></td>
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
										 <p class="text-warning">Click on <b>RNI ID</b> to edit/view details</p>
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
  
<script type="text/javascript">
	function changestatus(id_user, newstatus, dispname, lblalert) {
		if (confirm("Are you sure to "+lblalert+" "+dispname+"?")) {
			if (test = prompt('Comments')) {
				$.post("<?php echo site_url('admin/cpanel/change_node_status/'); ?>/"+id_user+"/"+newstatus+"",{comments:test, nodetitle:dispname} ,function(data)
				{
					window.location.href= '<?php echo current_url(); ?>';
				});
			} else {
				alert('Status not changed');
			}
		}
	}
</script>
