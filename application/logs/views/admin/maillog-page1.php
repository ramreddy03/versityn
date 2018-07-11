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
                        <h1>  Mail Log </h1>
                    </div>
                </div>
                 
                  

                 <!--TABLE, PANEL, ACCORDION AND MODAL  -->
                          <div class="row">
							  
							  <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                              <b>  Mail Log</b>
                              <?php //echo anchor("admin/cpanel/index", '<img src="'.$this->baseurl.'assets/default/img/close.png" height="20" width="20" />', array('title'=>'Close', 'style' => 'float:right;')); ?>&nbsp;  &nbsp; 
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                  
                                  <div id="sortableTable" class="body collapse in">
                                <table class="table table-bordered sortableTable responsive-table" id ="dashboard-table">
                                    <thead>
                                        <tr>
                                            <th width="12%">Mail Type<i class="icon-sort"></i><i class="icon-sort-down"></i> <i class="icon-sort-up"></i></th>
                                            <th width="15%">Sent date<i class="icon-sort"></i><i class="icon-sort-down"></i> <i class="icon-sort-up"></i></th>
                                            <th width="15%">From<i class="icon-sort"></i><i class="icon-sort-down"></i> <i class="icon-sort-up"></i></th>
                                            <th width="15%">To<i class="icon-sort"></i><i class="icon-sort-down"></i> <i class="icon-sort-up"></i></th>
                                            <th width="15%">Subject<i class="icon-sort"></i><i class="icon-sort-down"></i> <i class="icon-sort-up"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody>
										
										<?php
											if (count($maillog)>0) {
												foreach ($maillog as $onerec) {													
										?>
										 <tr>
                                            <td class=" "><?php echo $onerec['mailtype']; ?></td>
                                            <td class=" "><?phpecho $onerec['updatedon'];  //echo !empty($onerec['sentdate']) ? $this->commonclass->dateformat1($onerec['sentdate']) : ""; ?></td>
                                            <td class=" "><?php echo $onerec['sentfrom_id']; ?></td>
                                            <td class=" "><?php echo $onerec['sentto_id']; ?></td>
                                            <td class=" "><?php echo $onerec['mail_subject']; ?></td>
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

