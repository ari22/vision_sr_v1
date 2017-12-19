<?php

$tbl .= '
<div id="cntr1" align="center">
<table width="50%">
<tr><td align="center"><b style="font-size:1.1em;">' . $comp_name . '</b></td></tr>
<tr><td align="center"><b style="font-size:1.1em;">Look-Up : '.strtoupper($title).'</b></td></tr>
</table>
';

$tbl .= '
<table width="50%"  >
<tr>
<td align="right" colspan="3"><b>Printed On: </b>'.date('d/m/Y').'</td>
</tr>
</table>';
$tbl .= '
<table width="50%">
<thead style="border:2px solid black !important;">
<tr><th width="30" align="left"><b>No.</b></th><th width="200" align="left"><b>Code</b></th><th align="left"><b>Description</b></th></tr>
</thead>';

$no = 1;
$tbl .= '
<tr><td></td></tr>';
while ($dtlrow = mysql_fetch_array($dtl)) {
   $tbl .='<tr>';
   $tbl .='<td width="30" align="left">'.$no++.'.</td>';
   $tbl .='<td width="200" align="left">'.$dtlrow[$code].'</td>';
   $tbl .='<td align="left">'.$dtlrow[$name].'</td>';
   $tbl .='</tr>';
}

$tbl .='</table>';
