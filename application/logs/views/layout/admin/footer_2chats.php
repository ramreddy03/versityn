<?php
$cur_ctrlr = $this->router->class;
$cur_ctrlr_fn = $this->router->method;
$cur_page = $cur_ctrlr."__".$cur_ctrlr_fn;

$validationscripts = array('dashboard__uploadexcel', 'cpanel__usersform','cpanel__userrolesform','cpanel__nodesform','cpanel__modulesform','cpanel__siteconfigsform', 'dashboard__myaccount');
$graphscripts = array('dashboard__viewexceldetails',);


?>
	  </div>

	<!--END MAIN WRAPPER -->

    <!-- FOOTER -->
    <div id="footer">
        <p>&copy; <?php echo date('Y');?> Sensus. All rights reserved.&nbsp;</p>
    </div>
    <!--END FOOTER -->


	<!-- GLOBAL SCRIPTS -->
	<script src="<?php echo $this->baseurl;?>assets/default/js/jquery-2.0.3.min.js"></script>
	<script src="<?php echo $this->baseurl;?>assets/default/js/jquery-ui.min.js"></script> 
	<script src="<?php echo $this->baseurl;?>assets/default/js/jquery-1.10.2.js"></script>
	<script src="<?php echo $this->baseurl;?>assets/default/js/jquery-ui.js"></script>
	<script src="<?php echo $this->baseurl;?>assets/default/js/bootstrap.min.js"></script>
	<script src="<?php echo $this->baseurl;?>assets/default/js/modernizr-2.6.2-respond-1.1.0.min.js"></script>
	<script src="<?php echo $this->baseurl;?>assets/default/js/chosen.jquery.min.js"></script>
	<!-- END GLOBAL SCRIPTS -->

	<!-- DATA TABLE SCRIPTS -->
	<link href="<?php echo $this->baseurl;?>assets/default/css/dataTables.bootstrap.css" rel="stylesheet" />
	<script src="<?php echo $this->baseurl;?>assets/default/js/jquery.dataTables.js"></script>
	<script src="<?php echo $this->baseurl;?>assets/default/js/dataTables.bootstrap.js"></script>
	
	<!-- END DATA TABLE SCRIPTS -->
	
	<?php if(in_array($cur_page, $validationscripts )) { ?>
	<!-- FORM VALIDATION SCRIPTS -->
	<script src="<?php echo $this->baseurl;?>assets/default/js/validationengine/jquery.validationEngine.js"></script>
	<script src="<?php echo $this->baseurl;?>assets/default/js/validationengine/jquery.validationEngine-en.js"></script>
	<script src="<?php echo $this->baseurl;?>assets/default/js/validationengine/jquery.validate.min.js"></script>
	<script src="<?php echo $this->baseurl;?>assets/default/js/validationengine/validationInit.js"></script>

	<!-- END FORM VALIDATION SCRIPTS -->
	<?php } ?>
	
	<?php if(in_array($cur_page, $graphscripts )) { ?>
    <!-- GRAPHS/PIE CHART SCRIPTS -->
	<script  src="<?php echo $this->baseurl;?>assets/default/js/flot/jquery.flot.js"></script>
	<script src="<?php echo $this->baseurl;?>assets/default/js/flot/jquery.flot.resize.js"></script>
	<script  src="<?php echo $this->baseurl;?>assets/default/js/flot/jquery.flot.pie.js"></script>
	<script src="<?php echo $this->baseurl;?>assets/default/js/flot/pie_chart.js"></script>   
    <!--END GRAPHS/PIE CHART SCRIPTS -->
     <?php } ?>
     
     

<script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>
 
<script>
	
 $(document).ready(function(){
	$('.addnewmethod').click(function(){
		
		if($(this).attr("value")=="import"){
			$(".fromprevsession").hide();
			$(".importspread").show();
		} else if($(this).attr("value")=="previous"){
			$(".importspread").hide();
			$(".fromprevsession").show();
		}
		
	});
});
$(document).ready(function() {
	$('#userform-rnis').submit(function() {
	$("#select2").find('option').each(function(){ 
		$(this).attr('selected', 'selected');
	 });
	});
});
function savedataintemp() {
var seldate = $('#scheduledon').val();
$("#select2").find('option').each(function(){ 
	$(this).attr('selected', 'selected');
 });
var dpanamescount = $("#dpaname_0 :selected").length;
var selnodescount = $("#select2 :selected").length;

if(seldate.length == 0) {
	alert("Please Select Scheduled on date!");
} else if (dpanamescount == 0) {
	alert("Please Select DPA!");
} else if (selnodescount == 0) {
	alert("Please Select Nodes!");
} else {
	$.post( "<?php echo site_url("admin/dashboard/savedataintemp"); ?>", $( "form#savedatatem" ).serialize(), function( data ) {
		$('#disp_rec_confirm').html(data);
	});
}
	
}
function savefrommasterlist(selecteddate, masterlistid) {
	if(confirm("Please note selected list can not be edited once you save")) {
		var redirepath = "<?php echo site_url("admin/dashboard/movefrommasterlist"); ?>/"+selecteddate+"/"+masterlistid;
		window.location = redirepath;
	} else {
		alert("Error: Please refresh page and try again!");
	}
}
function savetodbfn(selecteddate) {
	var selmasterlist1= $("#masterlistid option:selected").val();
	var selcb1 = $('#savetomasterlist').is(':checked');
	if(selcb1 == true) {
		var selcb = 1;
		var selmasterlist = selmasterlist1;		
	} else {
		var selcb = 0;
		var selmasterlist = 0;	
	}
	
	if(confirm("Please note selected list can not be edited once you save")) {
		var redirepath = "<?php echo site_url("admin/dashboard/movedatatoorg"); ?>/"+selecteddate+"/"+selcb+"/"+selmasterlist;
	} else {
		var redirepath = "<?php echo site_url("admin/dashboard/cleartemp"); ?>";
	}
	window.location = redirepath;
}
function selallopts() {
	$("#select2").find('option').each(function(){ 
		$(this).attr('selected', 'selected');
	 });
}
</script>

<script type="text/javascript"> 

$(document).ready(function () {
   $('#add').click(function() {
    return !$('#select1 option:selected').remove().appendTo('#select2');
   });
   $('#remove').click(function() {
    return !$('#select2 option:selected').remove().appendTo('#select1');
   });
  
 });
      
    
function change_patchingstatus () {	
	var nm = $( ".patching_cbs input:checkbox:checked" ).length;
	if (nm == 0) {
		alert("Please select RNI/ Nodes to change patching status");
		return false;
	} else {
		selnodes=$('.patching_cbs input:checkbox:checked').map(function(n){  //map all the checked value to tempValue with `,` seperated
				return  $(this).attr('id');
	   }).get().join(',');

		if (confirm('Are you sure to change patching status of '+selnodes+' ?')) {
			 $( "#frmsavepatchingstatus" ).submit();
		}
	}
}

    
function deletenodes () {	
	var nm = $( ".patching_cbs input:checkbox:checked" ).length;
	if (nm == 0) {
		alert("Please select RNI/ Nodes to delete");
		return false;
	} else {
		selnodes=$('.patching_cbs input:checkbox:checked').map(function(n){  //map all the checked value to tempValue with `,` seperated
				return  $(this).attr('id');
	   }).get().join(',');

		if (confirm('Are you sure to delete '+selnodes+' ?')) {
			
			var data =  $( ".patching_cbs input:checkbox:checked" ).serialize();
			$.post( "<?php echo site_url("admin/dashboard/deletenodes"); ?>", data, function() {
				alert("RNI/Nodes deleted successfully");
				redirepath = "<?php echo current_url(); ?>";
				window.location = redirepath;
			});
		}
	}
}


function save_verif_status (verificationstatus) {	
	var nm = $( ".modi_cbs input:checkbox:checked" ).length;
	if (nm == 0) {
		alert("Please select RNI/ Nodes to change verification status");
		return false;
	} else {
		selnodes=$('.modi_cbs input:checkbox:checked').map(function(n){  //map all the checked value to tempValue with `,` seperated
				return  $(this).attr('id');
	   }).get().join(',');

		if (confirm('Are you sure to change verification status of '+selnodes+' to '+verificationstatus+'?')) {
			 $( "#verificationstatus" ).val( verificationstatus );
			 $( "#dpafrm_verification_status" ).submit();
		}
	}
}

$(document).ready(function () {
 $('.normaldata-table').dataTable({
	"order": [[ 0, "desc" ]],
  });
 $('#dashboard-table').dataTable({
	"order": [[ 0, "desc" ]],
  });
  
	$('#viewsource-table').dataTable({
	"order": [[ 0, "desc" ]],
	"iDisplayLength": 50
	});
  
	$('#dpaviewsource-table').dataTable({
	"order": [[ 0, "desc" ]]
	});
  
	$('#report2-table').dataTable({
	"order": [[ 0, "desc" ]],
	"iDisplayLength": 10
	});
  
	$('#report1-table').dataTable({
	"order": [[ 0, "desc" ]],
	"iDisplayLength": 50
	});
	$(".chzn-select").chosen();
    $(".chzn-select-deselect").chosen({
        allow_single_deselect: true
    });
});


function savefromprevoiuslist(selecteddate='0') {
	var selcb1 = $('#savetoprevmaster').is(':checked');
	if(selcb1 == true) {
		var selcb = 1;
		var selmasterlist = 0;		
	} else {
		var selcb = 0;
		var selmasterlist = 0;	
	}
	
	if(confirm("Are you sure to save verification details?")) {
		var redirepath = "<?php echo site_url("admin/dashboard/movetempdatatosave"); ?>/"+selecteddate+"/"+selcb+"/"+selmasterlist;
	} else {
		var redirepath = "<?php echo site_url("admin/dashboard/cleartemp"); ?>";
	}
	window.location = redirepath;
}


function updatedpa_temp_fn (seltempid) {
	var selvaluedpa = $('#'+seltempid+' option:selected').val();
	$("#dispchangeval").load("<?php echo site_url("admin/dashboard/updatedpa_temp"); ?>/" + selvaluedpa);
	
}


$("#sel_previouslist").change(function() {
var seldate = $('#new_scheduledon').val();

if(seldate.length > 0) {
var day1 = $("#new_scheduledon").datepicker('getDate').getDate();
var month = $("#new_scheduledon").datepicker('getDate').getMonth() + 1;             
var month1 = month < 10 ? '0' + month : month; ;             
var year1 = $("#new_scheduledon").datepicker('getDate').getFullYear();
var str_output = year1 + "-" + month1 + "-" + day1;
		
	if(this.value != "") {		
		$("#disp_records_preview").load("<?php echo site_url("admin/dashboard/disp_prevoiuslist"); ?>/" + this.value+"/"+str_output);
	} else {
		$("#disp_records_preview").html("&nbsp;");
	}
} else {
	$('#sel_masterslist').prop('selectedIndex',0);
		$("#disp_records_preview").html("&nbsp;");
	alert("Please select date first!");
}
/*
if(seldate.length == 0) {
	alert("Please Select Scheduled on date!");
} else if ( this.value.length == 0) {
	alert("Please Choose List!");
} else {
	 $("#disp_records_confirm").load("<?php echo site_url("admin/dashboard/disp_masterslist"); ?>/" + this.value+"/"+seldate);
}
*/
});

$("#sel_masterslist").change(function() {
var seldate = $('#masterslist_scheduledon').val();

if(seldate.length > 0) {
var day1 = $("#masterslist_scheduledon").datepicker('getDate').getDate();
var month = $("#masterslist_scheduledon").datepicker('getDate').getMonth() + 1;             
var month1 = month < 10 ? '0' + month : month; ;             
var year1 = $("#masterslist_scheduledon").datepicker('getDate').getFullYear();
var str_output = year1 + "-" + month1 + "-" + day1;
		
	if(this.value != "") {		
		$("#disp_records_confirm").load("<?php echo site_url("admin/dashboard/disp_masterslist"); ?>/" + this.value+"/"+str_output);
	} else {
		$("#disp_records_confirm").html("&nbsp;");
	}
} else {
	$('#sel_masterslist').prop('selectedIndex',0);
		$("#disp_records_confirm").html("&nbsp;");
	alert("Please select date first!");
}
/*
if(seldate.length == 0) {
	alert("Please Select Scheduled on date!");
} else if ( this.value.length == 0) {
	alert("Please Choose List!");
} else {
	 $("#disp_records_confirm").load("<?php echo site_url("admin/dashboard/disp_masterslist"); ?>/" + this.value+"/"+seldate);
}
*/
});
/* Onchange User Drop Down */

 $(function(){
  $("#id_user").change(function(){	
	  		var sel_rol = $("#id_user").val();
	  		var arr = sel_rol.split('___');
	  		if (arr[0] > 0) {
				var url = "<?php echo site_url("admin/cpanel/addrnis"); ?>/"+arr[0];
				window.location.href= url;
			}
  });
});
    
    /* Onchange User Drop Down */
    

$(function(){
	
<?php if(in_array($cur_page, $validationscripts )) { ?>
formValidation(); 
<?php } ?>
	
$( "#new_scheduledon" ).datepicker({
	changeYear: true,
	changeMonth: true,
	minDate: 0,
	dateFormat: "mm/dd/yy",
	showAnim: "fadeIn",
	showWeek: true,
	firstDay: 1,
	onSelect: function (dateText, inst) {
		var day1 = $("#new_scheduledon").datepicker('getDate').getDate();
		var month = $("#new_scheduledon").datepicker('getDate').getMonth() + 1;             
		var month1 = month < 10 ? '0' + month : month; ;             
		var year1 = $("#new_scheduledon").datepicker('getDate').getFullYear();
		var str_output = year1 + "-" + month1 + "-" + day1;
		
		$.get( "<?php echo site_url("admin/dashboard/check_schedule_date"); ?>/" + str_output, function( data ) {
			if(data>0) {
				$(".addnewmethod").prop("disabled", true);
				alert("Error: Post Patch Verification details exists for selected date, Please choose another date ");
			} else {
				$(".addnewmethod").prop("disabled", false);
			}
		});
		
	}
});
	
$( "#masterslist_scheduledon" ).datepicker({
	changeYear: true,
	changeMonth: true,
	minDate: 0,
	dateFormat: "mm/dd/yy",
	showAnim: "fadeIn",
	showWeek: true,
	firstDay: 1,
	onSelect: function (dateText, inst) {
		var day1 = $("#masterslist_scheduledon").datepicker('getDate').getDate();
		var month = $("#masterslist_scheduledon").datepicker('getDate').getMonth() + 1;             
		var month1 = month < 10 ? '0' + month : month; ;             
		var year1 = $("#masterslist_scheduledon").datepicker('getDate').getFullYear();
		var str_output = year1 + "-" + month1 + "-" + day1;
		
		$.get( "<?php echo site_url("admin/dashboard/check_schedule_date"); ?>/" + str_output, function( data ) {
			if(data>0) {
				$("#sel_masterslist").prop("disabled", true);
				alert("Error: Post Patch Verification details exists for selected date, Please choose another date ");
			} else {
				$("#sel_masterslist").prop("disabled", false);
			}
		});
		
	}
});
	
$( "#scheduledon" ).datepicker({
	changeYear: true,
	changeMonth: true,
	minDate: 0,
	dateFormat: "mm/dd/yy",
	showAnim: "fadeIn",
	showWeek: true,
	firstDay: 1,
	 onSelect: function (dateText, inst) {
		var day1 = $("#scheduledon").datepicker('getDate').getDate();
		var month = $("#scheduledon").datepicker('getDate').getMonth() + 1;             
		var month1 = month < 10 ? '0' + month : month; ;             
		var year1 = $("#scheduledon").datepicker('getDate').getFullYear();
		var str_output = year1 + "-" + month1 + "-" + day1;
	$("#dpaname_0").load("<?php echo site_url("admin/dashboard/load_dpa"); ?>/" + str_output);
				$("#select1").load("<?php echo site_url("admin/dashboard/load_rninodes"); ?>/" + str_output);
				$("#disp_rec_confirm").load("<?php echo site_url("admin/dashboard/disp_existing_nodes"); ?>/" + str_output);		
	/*	        
		$.get( "<?php echo site_url("admin/dashboard/check_schedule_date"); ?>/" + str_output, function( data ) {
			if(data>0) {
				$("#show-report").prop("disabled", true);
				alert("Error: Scheduled date already exists, Please choose another date !");
			} else {
					
			}
		});
		*/
    }
});
	
$( "#scheduledonupload" ).datepicker({
	changeYear: true,
	changeMonth: true,
	minDate: 0,
	dateFormat: "mm/dd/yy",
	showAnim: "fadeIn",
	showWeek: true,
	firstDay: 1,
	 onSelect: function (dateText, inst) {
		var day1 = $("#scheduledonupload").datepicker('getDate').getDate();
		var month = $("#scheduledonupload").datepicker('getDate').getMonth() + 1;             
		var month1 = month < 10 ? '0' + month : month; ;             
		var year1 = $("#scheduledonupload").datepicker('getDate').getFullYear();
		var str_output = year1 + "-" + month1 + "-" + day1;
		        
		$.get( "<?php echo site_url("admin/dashboard/check_schedule_date"); ?>/" + str_output, function( data ) {
			if(data>0) {
				$("#submitupd").prop("disabled", true);
				alert("Error: Post Patch Verification details exists for selected date, Please choose another date ");
			} else {
				$("#submitupd").prop("disabled", false);
			}
		});
		
    }
});

$("#change_schedule").change(function(){
if ( this.value.length >= 1) {
	var redirepath = "<?php echo site_url("admin/dashboard/viewexceldetails"); ?>/" + this.value;
} else {
	var redirepath = "<?php echo site_url("admin/dashboard/index"); ?>";	
}

window.location = redirepath;
});

$("#dpa_change_schedule").change(function(){
if ( this.value.length >= 1) {
	var redirepath = "<?php echo site_url("dpa/dashboard/viewexceldetails"); ?>/" + this.value;
} else {
	var redirepath = "<?php echo site_url("dpa/dashboard/index"); ?>";	
}
window.location = redirepath;
});
/*
  var categoriesdata = [];
  var drildowndata = [];
  var titledata ="";
 */
 
    });
  <?php if($this->loginuserdata['usertype'] == "admin") { ?>
  /* Dril down pie chart script starts here */
	$(function () {
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'container',
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            title: {
                text: 'post patching verification, 2010'
            },
            tooltip: {
                formatter: function() {
                    return '<b>'+ this.point.name +'</b>: '+ this.percentage +' %';
                }
            },
            legend: {
                enabled:true
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    size: 125,
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            series: [{
                type: 'pie',
                name: 'testname1',
                center: [70, 100],
                showInLegend:true,
                data: [
                    ['Commerce',   33.0],
                    ['Engineering',       32.3],
                    {
                        name: 'Financial Services',
                        y: 18.8,
                        sliced: true,
                        selected: true
                    },
                    ['Logistics, Aviation & Shipping',    5.5],
                    ['Seafood & Marine',     9.2],
                    ['Corporate Services & others',   1.2]
                ]
                },{
                type: 'pie',
                name: 'testname2',
                center: [70, 250],
                showInLegend:false,
                data: [
                    ['Commerce',   33.0],
                    ['Engineering',       32.3],
                    {
                        name: 'Financial Services',
                        y: 18.8,
                        sliced: true,
                        selected: true
                    },
                    ['Logistics, Aviation & Shipping',    5.5],
                    ['Seafood & Marine',     9.2],
                    ['Corporate Services & others',   1.2]
                ]
                }]
        },function(chart) {
            
        $(chart.series[0].data).each(function(i, e) {
            e.legendItem.on('click', function(event) {
                var legendItem=e.name;
                
                event.stopPropagation();
                
                $(chart.series).each(function(j,f){
                       $(this.data).each(function(k,z){
                           if(z.name==legendItem)
                           {
                               if(z.visible)
                               {
                                   z.setVisible(false);
                               }
                               else
                               {
                                   z.setVisible(true);
                               }
                           }
                       });
                });
                
            });
        });
    });
    });
    
});
      
  /* Dril down pie chart script ends here */
  <?php } ?>
    


    
</script>


     <!-- END PAGE LEVEL SCRIPTS -->
</body>

    <!-- END BODY -->
</html>
