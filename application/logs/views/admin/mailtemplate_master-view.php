<?php $this->load->view('layout/'.$this->sel_theam_path.'/leftmenu');
$subject = !empty($editrecord['subject']) ? $editrecord['subject'] : '';
$title = !empty($editrecord['title']) ? $editrecord['title'] : '';
$mail_body = !empty($editrecord['mail_body']) ? $editrecord['mail_body'] : '';
$formtitle = ($editmailtempid > 0) ? ' Edit mail template ' : ' Create new mail template ';
?>
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
                        <h1>  Mail Templates  </h1>
                    </div>
                </div>
                 
                  

                 <!--TABLE, PANEL, ACCORDION AND MODAL  -->
                          <div class="row">
							  
							  <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                              <b>   Mail Templates </b>
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
                                            <th width="15%">Title<i class="icon-sort"></i><i class="icon-sort-down"></i> <i class="icon-sort-up"></i></th>
                                            <th width="35%">Subject<i class="icon-sort"></i><i class="icon-sort-down"></i> <i class="icon-sort-up"></i></th>
                                            <th width="15%"><i class="icon-sort"></i><i class="icon-sort-down"></i> <i class="icon-sort-up"></i></th>
                                            <!--<th width="60%">Mail Content<i class="icon-sort"></i><i class="icon-sort-down"></i> <i class="icon-sort-up"></i></th>-->
                                        </tr>
                                    </thead>
                                    <tbody>
										
										<?php
											if (!empty($mail_templates) && count($mail_templates)>0) {
												foreach ($mail_templates as $onerec) {
													$viewdetailslink = anchor("admin/cpanel/mailtemplate_master/".$onerec['idmail_templates'], $onerec['subject'], array('title'=>'Edit template'));
										?>
										 <tr>
                                            <td><?php echo ucwords($onerec['title']); ?></td>
                                            <td><u><?php echo $viewdetailslink; ?></u></td>
                                            <td><?php echo anchor("admin/cpanel/mailtemplate_master_preview/".$onerec['idmail_templates'], "Preview", array('title'=>'Preview template')); ?></td>
                                            <!-- <td><?php //echo ucwords($onerec['mail_body']); ?></td> -->
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
									<td width="60%">
										 <p class="text-warning">Click on <b>Subject</b> to edit/view details</p>
									</td>
									<td width="40%" align="right">
									</td>
								</tr>
                            </table>
                           
								
                                  </div>
                            </div>
                        </div>
                        
                    </div>

							  
							  <div class="col-lg-10">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                              <b><?php echo $formtitle; ?></b>
                            </div>
                            <div class="panel-body">
							
							<form class="form-horizontal" id="rninodeform-validate" method="post">
								<div class="form-group col-lg-11">
									<label class="control-label col-lg-3" style="text-align:left!important">Title</label>

									<div class="col-lg-9">
									   <input type="text" id="title" name="title" class="form-control" value="<?php echo $title; ?>" />
									</div>
								</div>
								
							
								<div class="form-group col-lg-11">
									<label class="control-label col-lg-3" style="text-align:left!important">Subject</label>

									<div class="col-lg-9">
									   <input type="text" id="subject" name="subject" class="form-control" value="<?php echo $subject; ?>" />
									</div>
								</div>
								
							
							
								<div class="form-group col-lg-11">
									<label class="control-label col-lg-3" style="text-align:left!important">Mail Content</label>

									<div class="col-lg-9">
										<textarea id="mail_body" name="mail_body"><?php echo $mail_body; ?></textarea><br/>
										<h4 class="text-danger"> Don't change the parameters between <strong>"%"</strong> and <strong>"%"</strong>symbol </h4>
									</div>
								</div>
								
							

								<div style="clear:both;"></div>

								<div class="form-actions no-margin-bottom" style="text-align:center;">
									<br/> &nbsp;
									<input type="submit" value="Save" class="btn btn-primary " name="submit" /> &nbsp;
									<?php echo anchor("admin/cpanel/mailtemplate_master", 'Cancel', array('title'=>'Cancel', 'class' => 'btn btn-danger')); ?>
									<br/>
								</div>

							</form>
							</div>
                        </div>
                        
                    </div>

                </div>
                 <!--TABLE, PANEL, ACCORDION AND MODAL  -->

                
            </div>

        </div>
    <!--END PAGE CONTENT -->
   
<script type="text/javascript" src="<?php echo $this->baseurl;?>assets/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
tinymce.init({
    selector: "textarea",
    plugins: [
        "advlist autolink lists link charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "table contextmenu paste "
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link "
});
</script>


    
<div id='right' style="display:show;">
</div>
