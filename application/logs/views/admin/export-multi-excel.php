<?php
$this->load->helper('url'); #loading url helper
// Turn off all error reporting
error_reporting(0);
set_time_limit(10);
 
$array_ref  = array_values($data); 
//echo $this->baseurl."assets/exportexcel/class.writeexcel_workbook.inc.php";
require_once "assets/exportexcel/class.writeexcel_workbook.inc.php";
require_once "assets/exportexcel/class.writeexcel_worksheet.inc.php";

$fname = tempnam("/tmp", "data.xls");

$workbook = new writeexcel_workbook($fname);
//print_r($workbook);
//exit;
$text_format = $workbook->addformat(array(
                                           'bold'    => 1,
                                            'color'   => 'blue',
                                        ));

$heading_style  = $workbook->addformat(array(
                                        'bold'    => 1,
                                        'color'   => 'blue',
                                        'size'    => 12,
                                        'merge'   => 1,
									));
$heading_style->set_align('left');
$heading_style->set_align('vcenter');
$heading_style->set_color('navy');
$heading_style->set_merge(); # This is the key feature

for ($i=0; $i<$nosheets; $i++) {
$newvar = "worksheet".$i;
$worksheet_name = $worksheet_names[$i];
$$newvar = $workbook->addworksheet($worksheet_name);
$$newvar->set_column('A:Z', 18);
$$newvar->insert_bitmap('A1', 'assets/exportexcel/excellogo.bmp', 0, 0, 0, 0);
$mainheadings  = array_values($mainheading);
$$newvar->freeze_panes(4, 0); # 1 row
$$newvar->set_row(2, 25);
$$newvar->set_row(3, 18);

$$newvar->write(2,2, $mainheadings[$i], $heading_style);

$headings = array_values($heads[$i]);
										
$text_format->set_fg_color('navy');
$text_format->set_border_color('black');
$text_format->set_color('white');
$text_format->set_align('center');
$text_format->set_align('vcenter');

$$newvar->write('A4',  $headings, $text_format);
$array_ref = array_values($data[$i]);
$$newvar->write_col('A5',  $array_ref);


}


$workbook->close();

//echo "<pre>"; print_r($workbook); echo "</pre>";
//header("Content-type: application/zip;");
//header("Content-type: application/csv");
header("Content-type: application/x-msdownload;  name=\"".$filename.".xls\"");
header("Content-Type: application/vnd.ms-excel;  name=\"".$filename.".xls\"");
//header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; name=\"".$filename.".xlsx\"");
header("Content-Disposition: inline; filename=\"".$filename.".xls\"");
$fh=fopen($fname, "rb");
fpassthru($fh);
unlink($fname);

?>
