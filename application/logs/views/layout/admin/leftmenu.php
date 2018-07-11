<?php
$cur_ctrlr = $this->router->class;
$cur_ctrlr_fn = $this->router->method;

$dashboard_active = (!empty($cur_ctrlr) && $cur_ctrlr == 'dashboard' && ($cur_ctrlr_fn != "myaccount") ) ? ' active' : '' ;
$myaccount_active = ((!empty($cur_ctrlr) && $cur_ctrlr == 'dashboard')  && ($cur_ctrlr_fn == "myaccount") ) ? ' active' : '' ;
$reports_active = (!empty($cur_ctrlr) && $cur_ctrlr == 'reports') ? ' active' : '' ;
$activtylog_active = (!empty($cur_ctrlr) && $cur_ctrlr == 'reports') ? ' active' : '' ;

$cpanel_active = (!empty($cur_ctrlr) && $cur_ctrlr == 'cpanel') ? ' active' : '' ;
$cpaneldd_active = (!empty($cur_ctrlr) && $cur_ctrlr == 'cpanel') ? ' in' : 'collapse' ;
$users_active = (!empty($cur_ctrlr) && $cur_ctrlr == 'cpanel' && ($cur_ctrlr_fn == "users_list" || $cur_ctrlr_fn == "usersform")) ? ' active' : '' ;
$userroles_active = (!empty($cur_ctrlr) && $cur_ctrlr == 'cpanel' && ($cur_ctrlr_fn == "userroles_list" || $cur_ctrlr_fn == "userrolesform")) ? ' active' : '' ;
$modules_active = (!empty($cur_ctrlr) && $cur_ctrlr == 'cpanel' && ($cur_ctrlr_fn == "modules_list" || $cur_ctrlr_fn == "modulesform")) ? ' active' : '' ;
$siteconfigsform_active = (!empty($cur_ctrlr) && $cur_ctrlr == 'cpanel' && ($cur_ctrlr_fn == "siteconfigsform")) ? ' active' : '' ;
$activitylog_active = (!empty($cur_ctrlr) && $cur_ctrlr == 'cpanel' && ($cur_ctrlr_fn == "activitylog")) ? ' active' : '' ;
$logintrack_active = (!empty($cur_ctrlr) && $cur_ctrlr == 'cpanel' && ($cur_ctrlr_fn == "logintrack")) ? ' active' : '' ;
$maillog_active = (!empty($cur_ctrlr) && $cur_ctrlr == 'cpanel' && ($cur_ctrlr_fn == "maillog")) ? ' active' : '' ;
$mailtemplates_active = (!empty($cur_ctrlr) && $cur_ctrlr == 'cpanel' && ($cur_ctrlr_fn == "mailtemplate_master")) ? ' active' : '' ;

$nodes_active = (!empty($cur_ctrlr) && $cur_ctrlr == 'cpanel' && ($cur_ctrlr_fn == "nodes_list" || $cur_ctrlr_fn == "nodesform")) ? ' active' : '' ;
?>
        <!-- MENU SECTION -->
       <div id="left" >
            <div class="media user-media well-small">
                
                <div class="media-body">
                    <h5 class="media-heading"> <?php echo (!empty($this->loginuserdata['loginname'])) ? $this->loginuserdata['loginname'] : "" ; ?></h5>
                </div>
                <br />
            </div>

            <ul id="menu" class="collapse">

                
                <li class="panel <?php echo $dashboard_active; ?>">
					 <?php echo anchor("admin/dashboard/index", '<i class="icon-table"></i> Dashboard', array('title'=>'Dashboard')); ?>                 
                </li>
                
                <li class="panel <?php echo $myaccount_active; ?>">
					 <?php echo anchor("admin/dashboard/myaccount", '<i class="icon-gear"></i> My Account', array('title'=>'My Account')); ?>                 
                </li>
				<?php if (!empty($this->loginuserdata) && in_array($this->loginuserdata['usertype'], array('Super admin', 'Admin'))) { ?>
					<li class="panel <?php echo $reports_active; ?>">
						<?php echo anchor("admin/reports/index", '<i class="icon-list-ul"></i> Report', array('title'=>'Report')); ?>                   
					</li>
				<?php } ?>

				<?php if (!empty($this->loginuserdata) && in_array($this->loginuserdata['usertype'], array('Super admin', 'Admin'))) { ?>
					<li class="panel <?php echo $cpanel_active; ?>">
					
						<a href="#" data-parent="#menu" data-toggle="collapse" class="accordion-toggle" data-target="#component-nav">
                        <i class="icon-cogs"></i> C-Panel    
	   
                        <span class="pull-right">
                          <i class="icon-angle-down"></i>
                        </span>
                    </a>
						 <ul class="<?php echo $cpaneldd_active; ?>" id="component-nav" style="margin-left:25px;">
                       
							<li class="<?php echo $nodes_active; ?>">
							<a href="<?php echo site_url("admin/cpanel/nodes_list"); ?>" > <i class="icon-th-list "></i> RNI / Nodes </a>
							</li>
                       
							<li class="<?php echo $users_active; ?>">
							<a href="<?php echo site_url("admin/cpanel/users_list"); ?>" > <i class="icon-group"></i> Users </a>
							</li>
                       
							<li class="<?php echo $mailtemplates_active; ?>">
							<a href="<?php echo site_url("admin/cpanel/mailtemplate_master"); ?>" > <i class="icon-edit"></i> Mail Templates </a>
							</li>
                       
							<li class="<?php echo $userroles_active; ?>">
							<a href="<?php echo site_url("admin/cpanel/userroles_list"); ?>"><i class="icon-cog"></i> Roles</a>
							</li>
                       
							<li class="<?php echo $modules_active; ?>">
							<a href="<?php echo site_url("admin/cpanel/modules_list"); ?>"> <i class="icon-qrcode"></i> Modules</a>
							</li>
                       
							<li class="<?php echo $siteconfigsform_active; ?>">
							<a href="<?php echo site_url("admin/cpanel/siteconfigsform"); ?>"> <i class="icon-wrench"></i> Site Settings</a>
							</li>
                       
							<li class="<?php echo $activitylog_active; ?>">
							<a href="<?php echo site_url("admin/cpanel/activitylog"); ?>"> <i class="icon-tags"></i> Activity Log</a>
							</li>
                       
							<li class="<?php echo $logintrack_active; ?>">
							<a href="<?php echo site_url("admin/cpanel/logintrack"); ?>"><i class="icon-time"></i> Login Track</a>
							</li>
                       
							<li class="<?php echo $maillog_active; ?>">
							<a href="<?php echo site_url("admin/cpanel/maillog"); ?>"><i class="icon-envelope-alt"></i> Mail Log</a>
							</li>
                       
							
						</ul>             
					</li>
				<?php } ?>
              
                <li>
					<?php echo anchor("login/logout", '<i class="icon-signin"></i> Logout', array('title'=>'Logout')); ?>  
                </li>

            </ul>

        </div>
        <!--END MENU SECTION -->
