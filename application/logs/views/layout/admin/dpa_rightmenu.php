<!-- RIGHT STRIP  SECTION -->
<link href="<?php echo $this->baseurl;?>assets/default/css/examples.css" rel="stylesheet" />
<div id="right">
	<br/>
	<?php 
	//print_r($this->loginuserdata);
	//$coundata = $rightmenudata['countdata'];
	//$query_multipie_res = $rightmenudata['query_multipie_res'];
	
	
	if ( $countdata['all'] > 0) { ?>

<div class="well well-small">
	
	<ul class="list-unstyled">
		<li>
		<span class="btn btn-default btn-sm" style="font-size:13px; font-weight:bold; background: #CCCCCC;">Total Nodes &nbsp; <span><?php echo $countdata['all']; ?></span>
		</li>
		<!-- <li>Patched Nodes &nbsp; : <span><?php //echo $countdata['patched']; ?></span></li>-->
	</ul>
	
	<?php
		$patchedpendingpercent = (!empty($countdata['pendingpatching']) && ($countdata['pendingpatching'] > 0)) ? round( ($countdata['pendingpatching']/$countdata['all']) * 100 )."%" : '0%';
		$patchedpercent = (!empty($countdata['patched']) && ($countdata['patched'] > 0)) ? round( ($countdata['patched']/$countdata['all']) * 100 )."%" : '0%';
		$pendingpercent = (!empty($countdata['pending']) && ($countdata['pending'] > 0) && ($countdata['patched'] > 0)) ? round( ($countdata['pending']/$countdata['patched']) * 100 )."%" : '0%';
		$verifiedpercent = (!empty($countdata['verified']) && ($countdata['verified'] > 0) && ($countdata['patched'] > 0)) ? round( ($countdata['verified']/$countdata['patched']) * 100 )."%" : '0%';
		$issuespercent = (!empty($countdata['issue']) && ($countdata['issue'] > 0) && ($countdata['patched'] > 0)) ? round( ($countdata['issue']/$countdata['patched']) * 100 )."%" : '0%';
		$discontpercent = (!empty($countdata['Retired']) && ($countdata['Retired'] > 0)) && ($countdata['patched'] > 0) ? round( ($countdata['Retired']/$countdata['patched']) * 100 )."%" : '0%';

		$pendingpatchedpercent_pie = (!empty($countdata['pendingpatching']) && ($countdata['pendingpatching'] > 0)) ? floor( ($countdata['pendingpatching']/$countdata['all']) * 100 ) : 0;
		$patchedpercent_pie = (!empty($countdata['patched']) && ($countdata['patched'] > 0)) ? floor( ($countdata['patched']/$countdata['all']) * 100 ) : 0;
		$pendingpercent_pie = (!empty($countdata['pending']) && ($countdata['pending'] > 0) && ($countdata['patched'] > 0)) ? floor( ($countdata['pending']/$countdata['patched']) * 100 ) : 0;
		$verifiedpercent_pie = (!empty($countdata['verified']) && ($countdata['verified'] > 0) && ($countdata['patched'] > 0)) ? floor( ($countdata['verified']/$countdata['patched']) * 100 ) : 0;
		$issuespercent_pie = (!empty($countdata['issue']) && ($countdata['issue'] > 0) && ($countdata['patched'] > 0)) ? floor( ($countdata['issue']/$countdata['patched']) * 100 ) : 0;
		$discontpercent_pie = (!empty($countdata['Retired']) && ($countdata['Retired'] > 0) && ($countdata['patched'] > 0)) ? floor( ($countdata['Retired']/$countdata['patched']) * 100 ) : 0;
		
		if($this->loginuserdata['usertype'] != 'Verifier' ) {
	?>
	<p>&nbsp;</p>
	<span><img src="<?php echo $this->baseurl; ?>/assets/default/img/piechart.png" height="12" width="12" onclick="showhidediv('container123')" style="cursor:pointer;" />&nbsp; <b>Patching</b></span><span class="pull-right"><small><?php echo $countdata['patched']; ?> Nodes &nbsp; <?php echo $patchedpercent; ?></small></span>

	<div class="progress progress-striped active md" title="<?php echo $countdata['patched']; ?> Nodes">
		<div class="progress-bar progress-bar-success" style="width: <?php echo $patchedpercent; ?>"></div>
		<div class="progress-bar progress-bar-primary" style="width: <?php echo $patchedpendingpercent; ?>"></div>
	</div>
	<div id="container123" style="width: 100%; height: 300px; margin: 0 auto; display:none;"></div>

	<p>&nbsp;</p>
	
	<span><img src="<?php echo $this->baseurl; ?>/assets/default/img/piechart.png" height="12" width="12" onclick="showhidediv('container')" style="cursor:pointer;" />&nbsp; <b>Verification</b></span>
	<?php } ?>
	<div class="progress progress-striped active md">
		<div class="progress-bar progress-bar-primary"  title="<?php echo $countdata['pending']; ?> Nodes" style="width: <?php echo $pendingpercent; ?>"><?php echo $countdata['pending']; ?></div>
		<div class="progress-bar progress-bar-success"  title="<?php echo $countdata['verified']; ?> Nodes" style="width: <?php echo $verifiedpercent; ?>"><?php echo $countdata['verified']; ?></div>
		<div class="progress-bar progress-bar-danger" title="<?php echo $countdata['issue']; ?> Nodes" style="width: <?php echo $issuespercent; ?>"><?php echo $countdata['issue']; ?></div>
		<div class="progress-bar progress-bar-warning" title="<?php echo $countdata['Retired']; ?> Nodes" style="width: <?php echo $discontpercent; ?>"><?php echo $countdata['Retired']; ?></div>
	</div>
	<?php if($countdata['pending'] > 0) { ?>
	<p><span class="label label-primary"><b>Pending:</b> <?php echo $countdata['pending']; ?> Nodes &nbsp; <?php echo $pendingpercent; ?></span></p>
	<?php } ?>
	
	<?php if($countdata['verified'] > 0) {  ?>
	<p><span class="label label-success"><b>Verified:</b> <?php echo $countdata['verified']; ?> Nodes &nbsp; <?php echo $verifiedpercent; ?></span></p>
	<?php } ?>
	
	<?php if($countdata['issue'] > 0) {  ?>
	<p><span class="label label-danger"><b>Issues:</b> <?php echo $countdata['issue']; ?> Nodes &nbsp; <?php echo $issuespercent; ?></span></p>
	<?php } ?>
	
	<?php if($countdata['Retired'] > 0) { ?>
	<p><span class="label label-warning"><b>Retired:</b> <?php echo $countdata['Retired']; ?> Nodes &nbsp; <?php echo $discontpercent; ?></span></p>
	<?php } ?>
	<p></p>
<div id="container" style="height: 300px; margin: 0 auto; display:none;"></div>
	
</div>


<style>
.label {
	font-size:90%!important;
}
.highcharts-title {
	font-size: 14px!important;
	width: 100%!important;
}
@media screen {
#container123, #container {
	width: 180px!important;
}
}
</style>
<script>
var piechartdata = [],
series = 3;

<?php if($patchedpercent_pie > 0) { 
$unpatchedpercent_pie = 100 - $patchedpercent_pie;	
$unpatchedpercent = $countdata['all'] - $countdata['patched'];	
?>
piechartdata.push({
	name: 'Patched : <?php echo $patchedpercent_pie; ?>% (<?php echo $countdata['patched']; ?> Nodes)',
	y: <?php echo $patchedpercent_pie; ?>,
	color: "#439B43"	
});
piechartdata.push({
	name: 'Pending : <?php echo $unpatchedpercent_pie; ?>% (<?php echo $unpatchedpercent; ?> Nodes)',
	y: <?php echo $unpatchedpercent_pie; ?>,
	color: "#3276B0"	
});
<?php } else { ?>
piechartdata.push({
	name: 'Pending : 100% (<?php echo $countdata['all'] - $countdata['patched']; ?> Nodes)',
	y: 100,
	color: "#3276B0"	
});
<?php } ?>


                    
                    
var categoriesdata=new Array();
<?php if(!empty($disp_multilevelchart) && $disp_multilevelchart == 1) { ?>
//var seldatestr = $( "#change_schedule option:selected" ).text();
var myList = document.getElementById("change_schedule");
var seldatestr = myList.options[myList.selectedIndex].text;
var colors=new Array();
colors[0] = "#BE81F7";
colors[1] = "#FE9A2E";
colors[2] = "#088A08";
colors[3] = "#A9BCF5";
colors[4] = "#424242";
colors[5] = "#F78181";
colors[6] = "#071918";
colors[7] = "#3B240B";
colors[8] = "#428BCA";
colors[9] = "#5CB85C";
colors[10] = "#5BC0DE";
colors[11] = "#F0AD4E";
colors[12] = "#8CACC6";
colors[13] = "#D9534F";
colors[14] = "#5FB404";
colors[15] = "#243B0B";
colors[16] = "#0B4C5F";
colors[17] = "#380B61";
colors[18] = "#013ADF";
var titledata = "Verification status  "+seldatestr;
var schtitledata = "Scheduling status  "+seldatestr;
var categoriesdata=new Array();
var drildowndata=new Array();
<?php if(count($multipie_res)>0) { 
	$loop = 0;
foreach ($multipie_res as $empname => $empdetails) {
	$cates = implode("', '", array_keys($empdetails['grpbytype']));
	$cate_vals = implode(", ", $empdetails['grpbytype']);
	$nodescount = $empdetails['nodescount'];
?>
categoriesdata[<?php echo $loop; ?>] = '<?php echo $empname; ?>';
drildowndata[<?php echo $loop; ?>]={
                    y: <?php echo $empdetails['totalpercent']; ?>,
                    color: colors[<?php echo $loop; ?>],
                    drilldown: {
                        name: '<?php echo $empname; ?>',
                        categories: ['<?php echo $cates; ?>'],
                        data: [<?php echo $cate_vals; ?>],
                        color: colors[<?php echo $loop; ?>]
                    }
                };
<?php
$loop++;
}
 } ?>
<?php } ?>
</script>
<?php } 

?>







</div>
<?php if(!empty($disp_multilevelchart) && $disp_multilevelchart == 1) { ?>
<style>
.highcharts-container {
	height: 315px!important;
}
</style>
<?php } ?>
<!-- END RIGHT STRIP  SECTION -->
