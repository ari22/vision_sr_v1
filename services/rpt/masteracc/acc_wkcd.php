<?php
$tbl .= '
<div id="cntr1" align="center">
<table width="50%">
<tr><td valign="top" align="center"><b style="font-size:1.1em;">' . $comp_name . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.1em;">' . strtoupper($title) . ' REPORT</b></td></tr>
</table>
';

$tbl .= '
<table width="50%"  >
<tr>
<td valign="top" align="right" colspan="3"><b>Printed On: </b>' . date('d/m/Y') . '</td>
</tr>
</table>';

$tbl .= "
<table width='50%'>
 <thead style='border:2px solid black !important;'>
<tr>
<td valign='top' width='30' align='left'><b>No.</b></td>
<td valign='top' width='150' align='left'><b>Work Code</b></td>
<td valign='top' width='250' align='left'><b>Description/Specification</b></td>
<td valign='top' width='150' align='right'><b>Price</b></td>
</tr>
</thead>";
$tbl .='<tr><td valign="top"></td></tr>';

$no = 1;

while ($dtlrow = mysql_fetch_array($dtl)) {
    $tbl .= '<tr>';
    $tbl .= '<td valign="top" width="30" align="left">'.$no++.'.</td>';
    $tbl .= '<td valign="top" width="150" align="left">'.$dtlrow['wk_code'].'</td>';
    $tbl .= '<td valign="top" width="250" align="left">'.$dtlrow['wk_desc'].'</td>';
    $tbl .= '<td valign="top" width="150" align="right">'.number_format($dtlrow['sal_price']).'</td>';
    $tbl .= '</tr>';
}

$tbl .='</table>';
