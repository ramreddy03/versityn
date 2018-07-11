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
                              <b>  Masters list</b>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                  
                                  <div id="sortableTable" class="body collapse in">
                                <table class="table table-bordered sortableTable responsive-table normaldata-table" id ="masterlists-table">
                                    <thead>
                                        <tr>
                                            <th>List ID<i class="icon-sort"></i><i class="icon-sort-down"></i> <i class="icon-sort-up"></i></th>
                                            <th>DPA<i class="icon-sort"></i><i class="icon-sort-down"></i> <i class="icon-sort-up"></i></th>
                                            <th>RNI / Node<i class="icon-sort"></i><i class="icon-sort-down"></i> <i class="icon-sort-up"></i></th>
                                            <th>Default Time<i class="icon-sort"></i><i class="icon-sort-down"></i> <i class="icon-sort-up"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody>
										
										<?php
											if (count($lists_res)>0) {
												foreach ($lists_res as $oneschedule) {
																										
										?>
										 <tr>
                                            <td>List <?php echo $oneschedule['list_id']; ?></td>
                                            <td><?php echo ucwords($oneschedule['dpa_name']); ?></td>
                                            <td><?php echo $oneschedule['rni_node_name']; ?></td>
                                            <td><?php echo $oneschedule['rni_node_time']; ?></td>
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

                
            </div>

        </div>
    <!--END PAGE CONTENT -->
    
    
<?php $this->load->view('layout/'.$this->sel_theam_path.'/rightmenu'); ?>
