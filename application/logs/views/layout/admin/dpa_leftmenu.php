<?php
$cur_ctrlr = $this->router->class;
$cur_ctrlr_fn = $this->router->method;

$dashboard_active = (!empty($cur_ctrlr) && $cur_ctrlr == 'dashboard' && ($cur_ctrlr_fn != "myaccount") ) ? ' active' : '' ;
$myaccount_active = ((!empty($cur_ctrlr) && $cur_ctrlr == 'dashboard')  && ($cur_ctrlr_fn == "myaccount") ) ? ' active' : '' ;
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
					 <?php echo anchor("dpa/dashboard/index", '<i class="icon-table"></i> Dashboard', array('title'=>'Dashboard')); ?>                 
                </li>

                
                <li class="panel <?php echo $myaccount_active; ?>">
					 <?php echo anchor("dpa/dashboard/myaccount", '<i class="icon-gear"></i> My Account', array('title'=>'My Account')); ?>                 
                </li>

                <li>
					<?php echo anchor("login/logout", '<i class="icon-signin"></i> Logout', array('title'=>'Logout')); ?>  
                </li>

            </ul>

        </div>
        <!--END MENU SECTION -->
