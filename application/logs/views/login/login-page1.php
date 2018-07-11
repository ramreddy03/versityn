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
     <!-- PAGE LEVEL STYLES -->
     <link rel="stylesheet" href="<?php echo $this->baseurl;?>assets/login/bootstrap.css" />
    <link rel="stylesheet" href="<?php echo $this->baseurl;?>assets/login/login.css" />
    <link rel="stylesheet" href="<?php echo $this->baseurl;?>assets/login/magic.css" />
     <!-- END PAGE LEVEL STYLES -->
   <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
    <!-- END HEAD -->

    <!-- BEGIN BODY -->
<body >

<!-- PAGE CONTENT --> 
<div class="container text-center">
		
		
<div class="col-lg-6 logo-box" style="margin:auto">
    <div class="logo-header">
        <img src="<?php echo $portallogopath;?>" id="logoimg" alt=" SENSUS" />
    </div>
    <div class="tab-content">
        <div id="login" class="tab-pane active">
			<?php if (!empty($disp_msg)) { ?>
			<div class="alert alert-danger">
				<?php echo $disp_msg; ?>
			</div>
			<?php } ?>

			<div class="clear"></div>
            <form  id="login-form" class="form-signin" method="post">
                <h3 style="text-align:left!important;">Login</h3>
                <input type="text" placeholder="Username" class="form-control" name="uname" id="loginuname" />
                <input type="password" placeholder="Password" class="form-control" name="pwd" />
                
                <input class="btn text-muted text-center btn-success" type="submit" style="float:right;" value="Sign in" name="submit" />
                
            </form>
             <br/> <br/>
        </div>
      
        </div>
    </div>
    
    <br/>
    <br/>
    <br/>

</div>
</div>

	  <!--END PAGE CONTENT -->     
	      
      <!-- PAGE LEVEL SCRIPTS -->
		<script src="<?php echo $this->baseurl;?>assets/login/jquery-2.0.3.min.js"></script>
		<script src="<?php echo $this->baseurl;?>assets/login/bootstrap.js"></script>
		<script src="<?php echo $this->baseurl;?>assets/login/login.js"></script>
      <!--END PAGE LEVEL SCRIPTS -->
<script>
$("#loginuname").focus();
</script>
</body>
    <!-- END BODY -->
</html>
