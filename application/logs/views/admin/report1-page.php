<?php $this->load->view('layout/'.$this->sel_theam_path.'/leftmenu'); ?>

<!-- PAGE LEVEL STYLES -->
<link href="<?php echo $this->baseurl;?>assets/default/css/chosen.min.css" rel="stylesheet" />
<!-- END PAGE LEVEL  STYLES -->
    

	<!--PAGE CONTENT -->
        <div id="content">
             
            <div class="inner" style="min-height: 700px;">
                <!-- <div class="row">
                    <div class="col-lg-12">
                        <h1> Report </h1>
                    </div>
                </div> -->
                
                <!-- Search Filters display start -->
                <div class="row">
					<div class="col-lg-12">
						<br/>
						<form method="post" id="search-fields-form">
						<ul class="list-inline">											
							<li>
								<label>AEM/DPA/FLEXI NET OP</label><br/>
								
								<select name="dpa_flexinet_id[]" class="form-control chzn-select" multiple="multiple" data-placeholder="Select AEM/DPA/FLEXI NET OP"  >
									<?php 
										if (!empty($search_filters['dpa']) && count($search_filters['dpa'])>0 ) {
											foreach ($search_filters['dpa'] as $onedpa) {
												$selecteddpa = (!empty($_POST['dpa_flexinet_id']) && in_array($onedpa, $_POST['dpa_flexinet_id'])) ? 'selected="Selected"' : '';
									?>
											<option value="<?php echo $onedpa; ?>" <?php echo $selecteddpa; ?>><?php echo $onedpa; ?></option>
									<?php
											}
										}										
									?>
								</select>
								
							</li>
							
							<li>
								<label>Verification Status</label><br/>
								<select name="verificationstatus[]" class="form-control chzn-select" multiple="multiple" data-placeholder="Select Verification Status">
									<?php 
										if (!empty($search_filters['verf_status']) && count($search_filters['verf_status'])>0 ) {
											foreach ($search_filters['verf_status'] as $onerec1) {
												$selectedverf = (!empty($_POST['verificationstatus']) && in_array($onerec1, $_POST['verificationstatus'])) ? 'selected="Selected"' : '';
									?>
											<option value="<?php echo $onerec1; ?>" <?php echo $selectedverf; ?>><?php echo $onerec1; ?></option>
									<?php
											}
										}										
									?>
								</select>
							</li>
							
							<li>
								<label>Scheduled on</label><br/>
								<select name="scheduledate[]" class="form-control chzn-select" multiple="multiple" data-placeholder="Select Scheduled on">
									<?php 
										if (!empty($search_filters['scheduledates']) && count($search_filters['scheduledates'])>0 ) {
											foreach ($search_filters['scheduledates'] as $dbdate => $onerec2) {
												$selecteddbdate = (!empty($_POST['scheduledate']) && in_array($dbdate, $_POST['scheduledate'])) ? 'selected="Selected"' : '';
									?>
											<option value="<?php echo $dbdate; ?>" <?php echo $selecteddbdate; ?>><?php echo $onerec2; ?></option>
									<?php
											}
										}										
									?>
								</select>
							</li>
							
							<li><input type="submit" name="search" class="btn btn-success btn-circle " value="Go"></li>
						</ul>
						</form>
					</div>
				</div>
                <!-- Search Filters display end -->
                  

                 <!--TABLE, PANEL, ACCORDION AND MODAL  -->
                          <div class="row">
							  
							  <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                              <h4> Post patching verification for date
                               <a href="#div-2" data-toggle="collapse" class="accordion-toggle minimize-box text-right " style="float:right;">
											<i class="icon-chevron-up"></i>
										</a>
                              </h4>
										
							</div>
                             
                            </div>
                            <div class="panel-body" id="div-2" style="height:auto;">
                                <div class="table-responsive">
                                  
                                  <div id="sortableTable" class="body collapse in">
                                <table class="table table-bordered sortableTable responsive-table" id ="report1-table">
                                    <thead>
                                        <tr>
											<th>Time<i class="icon-sort"></i><i class="icon-sort-down"></i> <i class="icon-sort-up"></i></th>
											<th>RNI/Node<i class="icon-sort"></i><i class="icon-sort-down"></i> <i class="icon-sort-up"></i></th>
											<th>AEM/DPA/FLEXI NET OP</th>
											<th>Verification Status</th>
											<th>Verified on</th>
											<th>Comments</th>
                                        </tr>
                                    </thead>
                                    <tbody>
										<?php
											if (count($search_results)>0) {
												foreach ($search_results as $oneschedule) {
													if ($oneschedule['verificationstatus'] == "Verified") {
														$trclass = "success"; // class="success"
														$verificationstatus = "Verified";
													} else if ($oneschedule['verificationstatus'] == "Issue") {
														$trclass = "danger"; // class="success"
														$verificationstatus = "Issue";
													} else {
														$trclass = "primary"; // class="success"
														$verificationstatus = "Pending";
													}
													
													$verifiedon = (!empty($oneschedule['verifiedon']) && $oneschedule['verifiedon'] != "0000-00-00") ? $this->commonclass->dateformat1($oneschedule['verifiedon']) : "";
										?>
										
                                        <tr class="<?php echo $trclass; ?>">
                                            <td><?php echo $oneschedule['time']; ?></td>
                                            <td><?php echo $oneschedule['rni_node']; ?></td>
                                            <td><?php echo $oneschedule['dpa_flexinet']; ?></td>
                                            <td><?php echo $verificationstatus; ?></td>
                                            <td><?php echo $verifiedon; ?></td>
                                            <td><?php echo $oneschedule['verifiedcomments']; ?></td>
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
