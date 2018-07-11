<!DOCTYPE html>
<?php 
$siteconfigres =  $this->commonclass->retrive_records('siteconfig', ' * ', "",array("idsiteconfig" => "DESC"), 1); # users Table
$siteconfigs = !empty($siteconfigres[0]) ? $siteconfigres[0] : array() ;
$portaltitle = (!empty($siteconfigs['title']) && $siteconfigs['title'] != "") ? $siteconfigs['title'] : "Sensus PMP";
if ((!empty($siteconfigs['logo_name']) && $siteconfigs['logo_name'] != "") ) { 
	$portallogopath = $this->baseurl."logos/".$siteconfigs['logo_name'];
	$portallogopath = file_exists($this->baseurl."logos/".$siteconfigs['logo_name']) ? $this->baseurl."logos/".$siteconfigs['logo_name'] : $this->baseurl."assets/logo.png";
} else {
	$portallogopath = $this->baseurl."assets/logo.png";
}
?>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="UTF-8" />
    <title><?php echo $siteconfigs['title']; ?></title>
     <meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
     <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <![endif]-->
    <!-- GLOBAL STYLES -->
    <link rel="stylesheet" href="<?php echo $this->baseurl;?>assets/default/css/bootstrap.css" />
    <link rel="stylesheet" href="<?php echo $this->baseurl;?>assets/default/css/main.css" />
    <link rel="stylesheet" href="<?php echo $this->baseurl;?>assets/default/css/theme.css" />
    <link rel="stylesheet" href="<?php echo $this->baseurl;?>assets/default/css/MoneAdmin.css" />
    <link rel="stylesheet" href="<?php echo $this->baseurl;?>assets/default/Font-Awesome/css/font-awesome.css" />
    <!--END GLOBAL STYLES -->

</head>

    <!-- END HEAD -->

    <!-- BEGIN BODY -->
<body class="padTop53 " >

    <!-- MAIN WRAPPER -->
    <div id="wrap" >
        

        <!-- HEADER SECTION -->
        <div id="top">

            <nav class="navbar navbar-inverse navbar-fixed-top " style="padding: 10px 0px; ">
                <a data-original-title="Show/Hide Menu" data-placement="bottom" data-tooltip="tooltip" class="accordion-toggle btn btn-primary btn-sm visible-xs" data-toggle="collapse" href="#menu" id="menu-toggle">
                    <i class="icon-align-justify"></i>
                </a>
                <!-- LOGO SECTION -->
                <header class="navbar-header">
					<?php //echo anchor("admin/dashboard/index", '<i class="icon-table"></i> Dashboard', array('title'=>'Dashboard')); ?>  
                   <a href="<?php echo site_url("admin/dashboard/index"); ?>" class="navbar-brand">
                    <img src="<?php echo $portallogopath;?>" alt="SENSUS" />
                        
                      </a>
                </header>
                <!-- END LOGO SECTION -->
                <ul class="nav navbar-top-links navbar-right">

                    <!--ADMIN SETTINGS SECTIONS -->

                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="icon-user "></i>&nbsp; <i class="icon-chevron-down "></i>
                        </a>

                        <ul class="dropdown-menu dropdown-user">
                            <li> <?php echo anchor("admin/dashboard/myaccount", '<i class="icon-gear"></i> My Account', array('title'=>'My Account')); ?>    </li>
                            <li class="divider"></li>
                            <li><?php echo anchor("login/logout", '<i class="icon-signin"></i> Logout', array('title'=>'Logout')); ?>  
                            </li>
                        </ul>

                    </li>
                    <!--END ADMIN SETTINGS -->
                </ul>

            </nav>

        </div>
        <!-- END HEADER SECTION -->

