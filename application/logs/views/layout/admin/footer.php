<?php
$cur_ctrlr = $this->router->class;
$cur_ctrlr_fn = $this->router->method;
$cur_page = $cur_ctrlr."__".$cur_ctrlr_fn;

$validationscripts = array('dashboard__uploadexcel', 'cpanel__usersform', 'cpanel__userrolesform', 'cpanel__nodesform', 'cpanel__modulesform', 'cpanel__siteconfigsform',  'dashboard__myaccount', 'login__resetpassword', 'dashboard__addnode_schedule' );
$graphscripts = array('dashboard__viewexceldetails',);


?>
	  </div>

	<!--END MAIN WRAPPER -->

    <!-- FOOTER -->
    <div id="footer" style="height:auto!important;">
        <p>&copy; <?php echo date('Y');?> Sensus. All rights reserved.&nbsp;<br/>Best view with Mozilla Firefox 6.0+, IE 8.0, Chrome and screen resolution at 1024 X 768 with text size as medium.</p>
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
	

     
     
 
	<script src="<?php echo $this->baseurl;?>assets/highcharts/highcharts.js"></script>   
	<script src="<?php echo $this->baseurl;?>assets/highcharts/exporting.js"></script>  
 
<script>
		
$("#portalyear").change(function(){
if ( this.value.length >= 1) {
	var redirepath = "<?php echo site_url('admin/dashboard/index'); ?>/" + this.value;
} else {
	var redirepath = "<?php echo site_url('admin/dashboard/index'); ?>";	
}
	window.location = redirepath;
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

$(document).ready(function () {
 $('.normaldata-table').dataTable({
	"order": [[ 0, "desc" ]],
  });
 $('#dashboard-table').dataTable({
	"order": [[ 0, "desc" ]],
  });
  
	$('.report-table').dataTable({
	"aaSorting": [ [2,'asc'], [4,'desc'] ],
	});
	$('.report1-table').dataTable({
	"aaSorting": [ [3,'asc'], [4,'desc'] ],
	});
  
	$('#viewsource-table').dataTable({
	"iDisplayLength": 50,
	"aaSorting": [ [2,'asc'], [4,'asc'], [7,'desc'] ],
	"aoColumnDefs": [
        { 'bSortable': false, 'aTargets': [ 0,1 ] }
    ]
	});
  
	$('#dpaviewsource-table').dataTable({
	"order": [[ 3, "asc" ]]
	});
  
	$('#report2-table').dataTable({
	"order": [[ 0, "desc" ]],
	"iDisplayLength": 10
	});
  
	$('#report1-table').dataTable({
	"order": [[ 0, "desc" ]],
	"iDisplayLength": 50
	});
  
	$('#newscheduling-table').dataTable({
	"order": [[ 0, "desc" ]],
	"iDisplayLength": 25
	});
	$(".chzn-select").chosen();
    $(".chzn-select-deselect").chosen({
        allow_single_deselect: true
    });

	$('#dispimportform').click(function(){		
		$("#dispimportform").hide();
		$("#form_import_xl").show();		
	});
	$('#cancle_import_xl').click(function(){		
		$("#dispimportform").show();
		$("#form_import_xl").hide();		
	});
	
	$('.addnewmethod').click(function(){
		
		if($(this).attr("value")=="import"){
			$(".fromprevsession").hide();
			$(".manualentry").hide();
			$(".importspread").show();
		} else if($(this).attr("value")=="previous"){
			$(".manualentry").hide();
			$(".importspread").hide();
			$(".fromprevsession").show();
		} else if($(this).attr("value")=="manual"){
			$(".manualentry").show();
			$(".importspread").hide();
			$(".fromprevsession").hide();
		}
		
	});

	$('.addnodesmethod').click(function() {
		
		if($(this).attr("value")=="import"){
			$("#nodes_manualform").hide();
			$("#nodes_excelsheet").show();
		} else if($(this).attr("value")=="manual"){
			$("#nodes_manualform").show();
			$("#nodes_excelsheet").hide();
		}
		
	});
	
$(document).ready(function() {
    $('#verif_cbs_updstatus').click(function(event) {  //on click
        if(this.checked) { // check select status
            $('.verif_cbs_updstatus').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"              
            });
        }else{
            $('.verif_cbs_updstatus').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"                      
            });        
        }
    });
});

$("#previewupload").attr('disabled', true);
$('#uploadfile').on("change", function() {
    $('#previewupload').prop('disabled', !$(this).val()); 
});


$( "#notify_verifier" ).removeClass('btn-primary');
$( "#notify_verifier" ).addClass('btn-default');

$( "#seldeletednodes" ).removeClass('btn-primary');
$( "#seldeletednodes" ).addClass('btn-default');
$( "#selupdatednodes" ).removeClass('btn-primary');
$( "#selupdatednodes" ).addClass('btn-default');
$("#selupdatednodes").attr('disabled', true);
var $submit = $("#seldeletednodes").attr('disabled', true), 
	$cbs = $('.verif_cbs_updstatus').click(function() {
		if($cbs.is(":checked") == true) {
			$( "#seldeletednodes" ).removeClass('btn-default');
			$( "#seldeletednodes" ).addClass('btn-primary');
			$( "#selupdatednodes" ).removeClass('btn-default');
			$( "#selupdatednodes" ).addClass('btn-primary');
			$( "#notify_verifier" ).removeClass('btn-default');
			$( "#notify_verifier" ).addClass('btn-primary');
		} else {
			$( "#seldeletednodes" ).removeClass('btn-primary');
			$( "#seldeletednodes" ).addClass('btn-default');
			$( "#selupdatednodes" ).removeClass('btn-primary');
			$( "#selupdatednodes" ).addClass('btn-default');
			$( "#notify_verifier" ).removeClass('btn-primary');
			$( "#notify_verifier" ).addClass('btn-default');
		}
			$submit.attr('disabled', !$cbs.is(":checked") );
			$("#selupdatednodes").attr('disabled', !$cbs.is(":checked"));
			$("#notify_verifier").attr('disabled', !$cbs.is(":checked"));
	});
$("#selupdatednodes").attr('disabled', true);
$("#notify_verifier").attr('disabled', true);
var $submit = $("#seldeletednodes").attr('disabled', true), 
	$cbs1 = $('#verif_cbs_updstatus').click(function() {
		if($cbs1.is(":checked") == true) {
			$( "#seldeletednodes" ).removeClass('btn-default');
			$( "#seldeletednodes" ).addClass('btn-primary');
			$( "#selupdatednodes" ).removeClass('btn-default');
			$( "#selupdatednodes" ).addClass('btn-primary');
			$( "#notify_verifier" ).removeClass('btn-default');
			$( "#notify_verifier" ).addClass('btn-primary');
		} else {
			$( "#seldeletednodes" ).removeClass('btn-primary');
			$( "#seldeletednodes" ).addClass('btn-default');
			$( "#selupdatednodes" ).removeClass('btn-primary');
			$( "#selupdatednodes" ).addClass('btn-default');
			$( "#notify_verifier" ).removeClass('btn-primary');
			$( "#notify_verifier" ).addClass('btn-default');
		}
		$("#seldeletednodes").removeClass('btn-default');
		$("#seldeletednodes").addClass('btn-primary');
		$("#selupdatednodes").removeClass('btn-default');
		$("#selupdatednodes").addClass('btn-primary');
		$("#notify_verifier").removeClass('btn-default');
		$("#notify_verifier").addClass('btn-primary');
		$submit.attr('disabled', !$cbs1.is(":checked"));
			$("#selupdatednodes").attr('disabled', !$cbs1.is(":checked"));
			$("#notify_verifier").attr('disabled', !$cbs1.is(":checked"));
	});

$('#add').click(function() {
return !$('#select1 option:selected').remove().appendTo('#select2');
});
$('#remove').click(function() {
return !$('#select2 option:selected').remove().appendTo('#select1');
});
	$('#userform-rnis').submit(function() {
	$("#select2").find('option').each(function(){ 
		$(this).attr('selected', 'selected');
	 });
	});
	
});

function report_xl_export(daterdpaform) {
var searchquery = $('#search_query_field').val();
if(searchquery.length > 0) {	
	$( "#"+daterdpaform ).submit();
	//$.post( "<?php echo site_url("admin/reports/exporttoxl"); ?>/"+daterdpa, { searchquery: searchquery} );
} else {
	alert('Unable to export!');
}	
}

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

//function showhidediv(id2show,id2hide) {
function showhidediv(id2show, id2toggle) {
	 id2toggle = id2toggle || "";
	var cur_disp = document.getElementById(id2show).style.display;
	//var cur_disp1 = document.getElementById(id2hide).style.display;
	if (cur_disp == "none") {
		document.getElementById(id2show).style.display = "";
		//document.getElementById(id2hide).style.display = "none";
		if(id2toggle!=''){
			$("#"+id2toggle).html("Hide");		
		}
	} else if(cur_disp == "") {
		document.getElementById(id2show).style.display = "none";
		//document.getElementById(id2hide).style.display = "";
		if(id2toggle!=''){
			$("#"+id2toggle).html("Show");		
		}
	}
}
function fnnotify_verifier(scheduledate) {
	var nm = $( ".patching_cbs input:checkbox:checked" ).length;
	if (nm == 0) {
		alert("Please select RNI/ Nodes to send verification");
		return false;
	} else {
		selnodes=$('.patching_cbs input:checkbox:checked').map(function(n){  //map all the checked value to tempValue with `,` seperated
			return  $(this).attr('id');
	   }).get().join(',');

		if (confirm('Are you sure to send notification to verifiers ?')) {
			$.post( "<?php echo site_url("admin/dashboard/sendnotify_verifiers"); ?>/"+scheduledate, $( ".patching_cbs input:checkbox:checked" ).serialize(), function( data ) {
				alert('Mail sent successfully');
			});
				
		}
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

    
function adddeletednodes (selnodedisp, selnodeid) {
	if (confirm('Are you sure to add '+selnodedisp+' ?')) {			
		$.post( "<?php echo site_url("admin/dashboard/adddeletednodes"); ?>", { selnodeid: selnodeid} , function() {
			alert("RNI/Node added successfully");
			redirepath = "<?php echo current_url(); ?>";
			window.location = redirepath;
		});			
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
			//if(commentstr = prompt('Comments')) {
				var data =  $( ".patching_cbs input:checkbox:checked" ).serialize();
				$.post( "<?php echo site_url("admin/dashboard/deletenodes"); ?>", data, function() {
					alert("RNI/Nodes deleted successfully");
					redirepath = "<?php echo current_url(); ?>";
					window.location = redirepath;
				});
			//}
		}
	}
}


function send_manual_email () {	
	var nm = $( ".modi_cbs input:checkbox:checked" ).length;
	if (nm == 0) {
		alert("Please select RNI/ Nodes to send email");
		return false;
	} else {
		if($('#accepttosendmail').is(':checked')) {
			selnodes=$('.modi_cbs input:checkbox:checked').map(function(n){  //map all the checked value to tempValue with `,` seperated
					return $(this).attr('id');
		   }).get().join(',');
			if (confirm('Are you sure to send email update of '+selnodes+'?')) {
				 $( "#verificationstatus" ).val( 'Manual email' );
				 $( "#dpafrm_verification_status" ).submit();
			}
		} else {
			alert("Please select Send e-mail to option");
			return false;
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

function savetonodesmaster() {	
	if(confirm("Are you sure to save RNI/ Nodes?")) {
	//	alert('the action is: ' + $( "#frmsavenodes" ).attr('action'));
	//	$( "#frmsavenodes" ).submit();
	var data = '';
	/*$.post( "<?php echo site_url("admin/dashboard/savetonodesmaster"); ?>", data, function() {
				alert("RNI/Nodes deleted successfully");
				redirepath = "<?php echo site_url('admin/cpanel/nodeslist'); ?>";
				//window.location = redirepath;
			});*/
			alert('Saved Successfully');
	} else {
		var redirepath = "<?php echo site_url("admin/cpanel/cleartempnodes"); ?>";
	}
	window.location = redirepath;
}

function savefromprevoiuslist(selecteddate) {
	selecteddate = selecteddate || 0;
	var selcb1 = $('#savetoprevmaster').is(':checked');
	if(selcb1 == true) {
		var selcb = 1;	
	} else {
		var selcb = 0;
	}
	
	if(confirm("Are you sure to save verification details?")) {
		var redirepath = "<?php echo site_url("admin/dashboard/movetempdatatosave"); ?>/"+selecteddate+"/"+selcb+"/";
	window.location = redirepath;
	} else {
		//var redirepath = "<?php echo site_url("admin/dashboard/cleartemp"); ?>";
	}
}

function updatepostpatch() {	
	if(confirm("Are you sure to save verification details?")) {
		$( "#frmsavepatchingstatus" ).submit();
	//	var redirepath = "<?php echo site_url("admin/dashboard/overwriteimport"); ?>/"+scheduleid+"";
	} else {
		//var redirepath = "<?php echo site_url("admin/dashboard/clearexport"); ?>";
	}
	//window.location = redirepath;
}

function viewexceldetails_temp(scheduledate) {	
	var redirepath = "<?php echo site_url("admin/dashboard/viewexceldetails_temp"); ?>/"+scheduledate+"";
	window.location = redirepath;

}


function updatedpa_temp_fn (seltempid) {
	var selvaluedpa = $('#'+seltempid+' option:selected').val();
	$("#dispchangeval").load("<?php echo site_url("admin/dashboard/updatedpa_temp"); ?>/" + selvaluedpa);
	
}


$("#patching_statusfilter").change(function() {
	var str = $(this).val();
	if($(this).val()) {
		var str = "All";
		var str2 = "Completed";
		var txt = $(this).val();
		if (txt.indexOf(str) > -1 || txt.indexOf(str2) > -1) {
			$('.verification-filter :selected').attr('selected', '');
			$(".verification-filter").attr('disabled', false).trigger("chosen:updated");
		} else {
			$('.verification-filter :selected').attr('selected', '');
			$(".verification-filter").attr('disabled', true).trigger("chosen:updated");
		}
	} else {
		$('.verification-filter :selected').attr('selected', '');
		$(".verification-filter").attr('disabled', true).trigger("chosen:updated");
	}
});
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
  $("#mail_template_preview").change(function(){	
	  		var sel_rol = $("#mail_template_preview").val();
	  		if (sel_rol > 0) {
				var url = "<?php echo site_url("admin/cpanel/mailtemplate_master_preview"); ?>/"+sel_rol;
				window.location.href= url;
			} else {
				var url = "<?php echo site_url("admin/cpanel/mailtemplate_master"); ?>";
				window.location.href= url;
			}
  });
});
    
    /* Onchange User Drop Down */
    

$(function(){
	
<?php if(in_array($cur_page, $validationscripts )) { ?>
formValidation(); 
<?php } ?>
	
$( "#manual_scheduledon" ).datepicker({
	changeYear: true,
	changeMonth: true,
	minDate: 0,
	dateFormat: "mm/dd/yy",
	showAnim: "fadeIn",
	showWeek: true,
	firstDay: 1,
	onSelect: function (dateText, inst) {
		var day1 = $("#manual_scheduledon").datepicker('getDate').getDate();
		var month = $("#manual_scheduledon").datepicker('getDate').getMonth() + 1;             
		var month1 = month < 10 ? '0' + month : month; ;             
		var year1 = $("#manual_scheduledon").datepicker('getDate').getFullYear();
		var str_output = year1 + "-" + month1 + "-" + day1;
		
		$.get( "<?php echo site_url("admin/dashboard/check_schedule_date"); ?>/" + str_output, function( data ) {
			if(data>0) {
				$(".manualchoosenodes").prop("disabled", true);
				alert("Error: Post Patch Verification details exists for selected date, Please choose another date ");
			} else {
				$(".manualchoosenodes").prop("disabled", false);
			}
		});
		
	}
});
	
	
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
				$(".sel_previouslist").prop("disabled", true);
				alert("Error: Post Patch Verification details exists for selected date, Please choose another date ");
			} else {
				$(".sel_previouslist").prop("disabled", false);
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

/*
  var categoriesdata = [];
  var drildowndata = [];
  var titledata ="";
 */
 
    });
  <?php if($this->loginuserdata['usertype'] != 'Verifier') { ?>
  /* Dril down pie chart script starts here */
	
<?php if(in_array($cur_page, $graphscripts )) { ?>
        var colors = Highcharts.getOptions().colors,
            categories = categoriesdata,
            name = 'Post Patching Verification',
            data = drildowndata;
    
        // Build the data arrays
        var browserData = [];
        var versionsData = [];
        for (var i = 0; i < data.length; i++) {
    
            // add browser data
            browserData.push({
                name: categories[i],
                y: data[i].y,
                color: data[i].color
            });
    
			if(data[i].drilldown.data.length > 0) {
				// add version data
				for (var j = 0; j < data[i].drilldown.data.length; j++) {
					var brightness = 0.2 - (j / data[i].drilldown.data.length) / 5 ;
					versionsData.push({
						name: data[i].drilldown.categories[j],
						y: data[i].drilldown.data[j],
						color: Highcharts.Color(data[i].color).brighten(brightness).get()
					});
				}
			}
        }
       
        
        // Create the chart
        $('#container').highcharts({
            chart: {
                type: 'pie'
            },
            title: {
                text: titledata
            },
            yAxis: {
                title: {
                    text: ''
                }
            },
            plotOptions: {
                pie: {
                    shadow: false,
                    center: ['50%', '50%']
                }
            },
            tooltip: {
        	    valueSuffix: '%'
            },
            series: [{
                name: 'Total RNI / Nodes',
                data: browserData,
                size: '80%',
                dataLabels: {
                    formatter: function() {
                        return this.y > 5 ? this.point.name : null;
                    },
                    color: 'white',
                    distance: -30
                }
            }, {
                name: 'RNI / Nodes',
                data: versionsData,
                size: '80%',
                innerSize: '60%',
                dataLabels: {
                    formatter: function() {
                        // display only if larger than 1
                        return this.y > 1 ? '<b>'+ this.point.name +':</b> '+ this.y +'%'  : null;
                    }
                }
            }]
        });
        
        
        
         // Create the chart
        $('#container123').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            title: {
                text: schtitledata
            },
            tooltip: {
        	    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true
                    },
                    showInLegend: false,
                    size: 170,
                }
            },
            series: [{
                type: 'pie',
                name: 'Nodes',
                data:  piechartdata
            }]
        });
        
        
        
  /* Dril down pie chart script ends here */
  <?php } ?>
  <?php } ?>
    


    
</script>


     <!-- END PAGE LEVEL SCRIPTS -->
</body>

    <!-- END BODY -->
</html>
