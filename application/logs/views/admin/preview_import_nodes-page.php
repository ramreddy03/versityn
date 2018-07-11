<?php 
$this->load->view('layout/'.$this->sel_theam_path.'/leftmenu'); 
		
?>

    
    
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
									RNI/ Nodes preview
								  </select>
                               </h5>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                  
                                  <div id="sortableTable" class="body collapse in">
							<form name="savenodes" method="post" action="<?php echo site_url("admin/cpanel/savetonodesmaster"); ?>" id="frmsavenodes"> 
								<div style="float:left; text-align: right; display: inline; margin-bottom: 5px; width:100%;">
								<a title="Save" class="btn btn-primary" onclick="savetonodesmaster();">Save</a></div>
								<div style="clear:both;"></div><br/>
                                <table class="table table-bordered sortableTable " id ="savenodes-table123">
                                    <thead>
                                        <tr>
											<th width="15%">RNI ID</th>
											<th width="15%">NC ID</th>
											<th width="15%">RNI/ Node</th>
											<th width="15%">Default Time</th>
											<th width="15%">DPA</th>
											<th width="50%">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody  class="patching_cbs">
										<?php
											if (count($temp_nodes)>0) {
												foreach ($temp_nodes as $onerec) {
													
												$status = ($onerec['status'] == "A") ? 'Active' : 'Retired';
										?>
                                        <tr>
												<td><?php echo $onerec['rninode']; ?></td>
												<td><?php echo $onerec['ncid']; ?></td>
												<td><?php echo $onerec['rniname']; ?></td>
												<td><?php echo $onerec['default_time']; ?></td>
												<td><?php echo $onerec['dpa_name']; ?></td>
												<td><?php echo $status; ?></td>
                                        </tr>
										<?php
												}
											}
										?>
                                    </tbody>
                                </table>
                                
								<div style="float:left; text-align: right; display: inline; margin-bottom: 5px; width:100%;">
								<a title="Save" class="btn btn-primary" onclick="savetonodesmaster();">Save</a></div>
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

    
