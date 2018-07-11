<?php $this->load->view('layout/'.$this->sel_theam_path.'/leftmenu'); ?>



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
					
					
<div class="col-lg-12" style="text-align: center; margin-top: 15px;">
	
<div style="width: 50%; margin:auto!important">
<div class="panel panel-info" style="text-align: left;">
	<div class="panel-heading">
		<h4><i class="icon-bookmark"></i>  &nbsp; Quick Menu</h4>
	</div>
	<div class="panel-body" style="text-align: center; padding: 15px;">
		
		 <?php //echo anchor("admin/cpanel/users_list", '<i class="icon-group icon-3x"></i> <span> Users</span>', array('title'=>'Users')); ?> 
		 
		 
		 <?php //echo anchor("admin/cpanel/users_list", '<i class="icon-cog icon-3x"></i> <span> Roles</span>', array('title'=>'Users')); ?> 
		 
		 
		 <?php //echo anchor("admin/cpanel/users_list", '<i class="icon-group icon-3x"></i> <span> Users</span>', array('title'=>'Users')); ?> 
		 
		 
		<a href="<?php echo site_url("admin/dashboard/index"); ?>" class="quick-btn" style=" margin-top: 15px;">
			<i class="icon-home icon-3x"></i>
			<span> Dashboard</span>
		</a>
		 
		<a href="<?php echo site_url("admin/cpanel/users_list"); ?>" class="quick-btn" style=" margin-top: 15px;">
			<i class="icon-group icon-3x"></i>
			<span> Users</span>
		</a>

		<a href="<?php echo site_url("admin/cpanel/userroles_list"); ?>" class="quick-btn" style=" margin-top: 15px;">
			<i class="icon-cog icon-3x"></i>
			<span>Roles</span>
		</a>
		<a href="<?php echo site_url("admin/cpanel/modules_list"); ?>" class="quick-btn" style=" margin-top: 15px;">
			<i class="icon-qrcode icon-3x"></i>
			<span>Modules</span>
		</a>
		
		<div class="clear"></div>
		
		<a href="<?php echo site_url("admin/cpanel/siteconfigsform"); ?>" class="quick-btn" style=" margin-top: 15px;">
			<i class="icon-wrench  icon-3x"></i>
			<span>Site Settings</span>
		</a>
		<a href="<?php echo site_url("admin/cpanel/activitylog"); ?>" class="quick-btn" style=" margin-top: 15px;">
			<i class="icon-tags  icon-3x"></i>
			<span>Activity Log</span>
		</a>
		<a href="<?php echo site_url("admin/cpanel/logintrack"); ?>" class="quick-btn" style=" margin-top: 15px;">
			<i class="icon-time  icon-3x"></i>
			<span>Login Track</span>
		</a>
		<a href="<?php echo site_url("admin/cpanel/users_list"); ?>" class="quick-btn" style=" margin-top: 15px;">
			<i class="icon-envelope-alt  icon-3x"></i>
			<span>Mail Log</span>
		</a>
	</div>
</div>


</div>


</div>
	</div>
                <!-- Search Filters display end -->
                  
  
            </div>

        </div>
    <!--END PAGE CONTENT -->
    
