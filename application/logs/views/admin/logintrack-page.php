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
                        <h1> Login Track </h1>
                    </div>
                </div>
                 
                  

                 <!--TABLE, PANEL, ACCORDION AND MODAL  -->
                          <div class="row">
							  
							  <div class="col-lg-5">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                              <b>  Online Members</b>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                  
                                  <div id="sortableTable" class="body collapse in">
                                <table class="table table-bordered sortableTable responsive-table normaldata-table" id ="dashboard-table123">
                                    <thead>
                                        <tr>
                                            <th width="16%">User type<i class="icon-sort"></i><i class="icon-sort-down"></i> <i class="icon-sort-up"></i></th>
                                            <th width="15%">User<i class="icon-sort"></i><i class="icon-sort-down"></i> <i class="icon-sort-up"></i></th>
                                            <th width="20%">Login<i class="icon-sort"></i><i class="icon-sort-down"></i> <i class="icon-sort-up"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody>
										
										<?php
											if (count($logintrack)>0) {
												foreach ($logintrack as $onerec) {
													
		
													$loginuserres =  $this->commonclass->retrive_records('users', ' * ', "(id_user=".$onerec['loginid'].")",array(),1); # loginuserres
													$logindetails = !empty($loginuserres[0]) ? $loginuserres[0] : array();
													
										?>
										 <tr>
                                            <td class=" "><?php echo $onerec['usertype']; ?></td>
                                            <td class=" "><?php echo !empty($logindetails['username']) ? ucwords(strtolower($logindetails['username'])) : ''; ?></td>
                                            <td class=" "><?php echo $onerec['logintime']; ?></td>
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

							  
							  <div class="col-lg-7">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                              <b>  Login Track</b>
                              <?php //echo anchor("admin/cpanel/index", '<img src="'.$this->baseurl.'assets/default/img/close.png" height="20" width="20" />', array('title'=>'Close', 'style' => 'float:right;')); ?>&nbsp;  &nbsp; 
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                  
                                  <div id="sortableTable" class="body collapse in">
                                <table class="table table-bordered sortableTable responsive-table" id ="dashboard-table">
                                    <thead>
                                        <tr>
                                            <th width="16%">User type<i class="icon-sort"></i><i class="icon-sort-down"></i> <i class="icon-sort-up"></i></th>
                                            <th width="15%">User<i class="icon-sort"></i><i class="icon-sort-down"></i> <i class="icon-sort-up"></i></th>
                                            <th width="20%">Login<i class="icon-sort"></i><i class="icon-sort-down"></i> <i class="icon-sort-up"></i></th>
                                            <th width="15%">Logout<i class="icon-sort"></i><i class="icon-sort-down"></i> <i class="icon-sort-up"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody>
										
										<?php
											if (count($offlinelogintrack)>0) {
												foreach ($offlinelogintrack as $onerec) {
													
		
													$loginuserres =  $this->commonclass->retrive_records('users', ' * ', "(id_user=".$onerec['loginid'].")",array(),1); # loginuserres
													$logindetails = $loginuserres[0];
													
										?>
										 <tr>
                                            <td class=" "><?php echo $onerec['usertype']; ?></td>
                                            <td class=" "><?php echo ucwords(strtolower($logindetails['firstname']." ".$logindetails['lastname'])); ?></td>
                                            <td class=" "><?php echo $onerec['logintime']; ?></td>
                                            <td class=" "><?php echo $onerec['logouttime']; ?></td>
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

