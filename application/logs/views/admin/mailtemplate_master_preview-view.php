<?php $this->load->view('layout/'.$this->sel_theam_path.'/leftmenu');
$subject = !empty($editrecord['subject']) ? $editrecord['subject'] : '';
$title = !empty($editrecord['title']) ? $editrecord['title'] : '';
$mail_body = !empty($editrecord['mail_body']) ? $editrecord['mail_body'] : '';

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
                        <h1>  Mail Template Preview  </h1>
                    </div>
                </div>
                 
                  

                 <!--TABLE, PANEL, ACCORDION AND MODAL  -->
                          <div class="row">
							  
							  <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                              <b>   Mail Template Preview </b>
                               <select id="mail_template_preview">
								<?php if(count($mail_templates) > 0) {
										foreach($mail_templates as $onetemplate) {
											$selected = ($onetemplate['idmail_templates'] == $editmailtempid ) ? 'selected="Selected"' : '';
								?>
								<option value="<?php echo $onetemplate['idmail_templates']; ?>"><?php echo $onetemplate['title']; ?></option>
								<?php } ?>
								<?php } ?>
							   </select>
							    <?php echo anchor("admin/cpanel/mailtemplate_master", '<img src="'.$this->baseurl.'assets/default/img/close.png" height="20" width="20" />', array('title'=>'Close', 'style' => 'float:right;')); ?>
							   <?php echo anchor("admin/cpanel/mailtemplate_master/".$editmailtempid, 'Edit', array('title'=>'Edit', 'style' => 'float:right; margin-right: 5px;')); ?>
                            </div>
                             <div class="panel-body">
							
								<p>&nbsp;<br/></p>
							<div style="clear:both;"></div>
							
								<div class="form-group col-lg-12">
									<label class="control-label col-lg-2" style="text-align:left!important">Title</label>

									<div class="col-lg-10">
									   <b><?php echo $title; ?></b>
									</div>
								</div>
								<p>&nbsp;<br/></p>
								<div class="form-group col-lg-12">
									<label class="control-label col-lg-2" style="text-align:left!important">Subject</label>

									<div class="col-lg-10">
									   <b><?php echo $subject; ?></b>
									</div>
								</div>
								<p>&nbsp;<br/></p>
							<div style="clear:both;"></div>
							
								<div class="form-group col-lg-12">
									<label class="control-label col-lg-2" style="text-align:left!important">Mail Content</label>

									<div class="col-lg-10">
										<?php echo $mail_body; ?><br/>										
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
   

    
<div id='right' style="display:show;">
</div>
