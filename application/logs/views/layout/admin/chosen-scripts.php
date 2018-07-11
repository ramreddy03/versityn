<script src="<?php echo $this->baseurl;?>assets/default/js/chosen.jquery.js"></script> 
  <link rel="stylesheet" href="<?php echo $this->baseurl;?>assets/default/css/chosen.css">
    <style type="text/css" media="all">
    /* fix rtl for demo */
    .chosen-rtl .chosen-drop { left: -9000px; }
  </style>
<script type="text/javascript">
    var config = {
      '.chosen-select'           : {},
      '.chosen-select-deselect'  : {allow_single_deselect:true},
      '.chosen-select-no-single' : {disable_search_threshold:10},
      '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
      '.chosen-select-width'     : {width:"95%"}
    }
    for (var selector in config) {
      $(selector).chosen(config[selector]);
    }
  </script>
