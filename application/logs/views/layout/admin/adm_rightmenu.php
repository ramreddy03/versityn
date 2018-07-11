<!-- RIGHT STRIP  SECTION -->
<link href="<?php echo $this->baseurl;?>assets/default/css/examples.css" rel="stylesheet" />
<div id="right">
	<br/>
	<?php 
	//$coundata = $rightmenudata['countdata'];
	//$query_multipie_res = $rightmenudata['query_multipie_res'];
	
	
	if ( $countdata['all'] > 0) { ?>

<div id="container"></div>


<div class="demo-container">
<div id="placeholder" class="demo-placeholder"></div>
</div>


<div class="well well-small">
	
	<ul class="list-unstyled">
		<li>Total Nodes &nbsp; : <span><?php echo $countdata['all']; ?></span></li>
	</ul>
	
	<?php
		$pendingpercent = (!empty($countdata['pending']) && ($countdata['pending'] > 0)) ? round( ($countdata['pending']/$countdata['all']) * 100 )."%" : '0%';
		$verifiedpercent = (!empty($countdata['verified']) && ($countdata['verified'] > 0)) ? round( ($countdata['verified']/$countdata['all']) * 100 )."%" : '0%';
		$issuespercent = (!empty($countdata['issue']) && ($countdata['issue'] > 0)) ? round( ($countdata['issue']/$countdata['all']) * 100 )."%" : '0%';
		$discontpercent = (!empty($countdata['Discontinued']) && ($countdata['Discontinued'] > 0)) ? round( ($countdata['Discontinued']/$countdata['all']) * 100 )."%" : '0%';

		$pendingpercent_pie = (!empty($countdata['pending']) && ($countdata['pending'] > 0)) ? round( ($countdata['pending']/$countdata['all']) * 100 ) : 0;
		$verifiedpercent_pie = (!empty($countdata['verified']) && ($countdata['verified'] > 0)) ? round( ($countdata['verified']/$countdata['all']) * 100 ) : 0;
		$issuespercent_pie = (!empty($countdata['issue']) && ($countdata['issue'] > 0)) ? round( ($countdata['issue']/$countdata['all']) * 100 ) : 0;
		$discontpercent_pie = (!empty($countdata['Discontinued']) && ($countdata['Discontinued'] > 0)) ? round( ($countdata['Discontinued']/$countdata['all']) * 100 ) : 0;
	?>
	
	<span>Pending</span><span class="pull-right"><small><?php echo $pendingpercent; ?></small></span>

	<div class="progress progress-striped active" title="<?php echo $countdata['pending']; ?> Nodes">
		<div class="progress-bar progress-bar-primary" style="width: <?php echo $pendingpercent; ?>"></div>
	</div>
	
	<span>Verified</span><span class="pull-right"><small><?php echo $verifiedpercent; ?></small></span>

	<div class="progress progress-striped active" title="<?php echo $countdata['verified']; ?> Nodes">
		<div class="progress-bar progress-bar-success" style="width: <?php echo $verifiedpercent; ?>"></div>
	</div>
	
	<span>Issues</span><span class="pull-right"><small><?php echo $issuespercent; ?></small></span>

	<div class="progress progress-striped active" title="<?php echo $countdata['issue']; ?> Nodes">
		<div class="progress-bar progress-bar-danger" style="width: <?php echo $issuespercent; ?>"></div>
	</div>
	
	<span>Discontinued</span><span class="pull-right"><small><?php echo $discontpercent; ?></small></span>

	<div class="progress progress-striped active" title="<?php echo $countdata['Discontinued']; ?> Nodes">
		<div class="progress-bar progress-bar-warning" style="width: <?php echo $discontpercent; ?>"></div>
	</div>
</div>


<style>
.highcharts-title {
	font-size: 14px!important;
	width: 100%!important;
}
</style>
<script>
var piechartdata = [],
series = 3;

piechartdata[0] = {
	label: "Pending",
	data: "<?php echo $pendingpercent_pie; ?>",
	color: "#5E9CD2"
};

piechartdata[1] = {
	label: "Verified",
	data: "<?php echo $verifiedpercent_pie; ?>",
	color: "#74C374"
}

piechartdata[2] = {
	label: "Issue",
	data: "<?php echo $issuespercent_pie; ?>",
	color: "#D9534F"
};

piechartdata[3] = {
	label: "Discontinued",
	data: "<?php echo $discontpercent_pie; ?>",
	color: "#F2B968"
};

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
var titledata = "Post Patching Verification Report for "+seldatestr;
var categoriesdata=new Array();
var drildowndata=new Array();
<?php if(count($multipie_res)>0) { 
	$loop = 0;
foreach ($multipie_res as $empname => $empdetails) {
	$cates = implode("', '", array_keys($empdetails['grpbytype']));
	$cate_vals = implode(", ", $empdetails['grpbytype']);
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
<?php } ?>
</div>
<?php if(!empty($disp_multilevelchart) && $disp_multilevelchart == 1) { ?>
<style>
.highcharts-container {
	height: 315px!important;
}
</style>
<?php } ?>
<!-- END RIGHT STRIP  SECTION -->
