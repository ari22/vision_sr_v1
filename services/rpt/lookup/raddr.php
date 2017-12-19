<?php

$tbl .= '
<div id="cntr1" align="center">
<table width="100%">
<tr><td valign="top" align="center"><b style="font-size:1.1em;">' . $comp_name . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.1em;">RECEIVING ADDRESS REPORT</b></td></tr>
</table>
';
$tbl .='<br /><br />';
$tbl .= '
<table width="100%"  >
<tr>
<td valign="top" align="right" colspan="3"><b>Printed On: </b>'.date('d/m/Y').'</td>
</tr>
</table>';

$tbl .= '
<table width="100%">
<thead style="border:2px solid black !important;">
<tr>
<td valign="top" width="30" align="left"><b>No.</b></td>
<td valign="top" width="150" align="left"><b>Receiver Name<br />Receiver Code</b></td>
<td valign="top" width="300" align="left"><b>Mailing Address</b></td>
<td valign="top" width="150" align="left"><b>Phone</b></td>
<td valign="top" width="150" align="left"><b>Fax</b></td>
<td valign="top" width="150" align="left"><b>Contact Person<br />Job Position </b></td>
<td valign="top" align="left"><b>Description</b></td>
</tr>
</thead>';
$tbl .= '
<tr><td></td></tr>';
$no = 1;

while ($dtlrow = mysql_fetch_array($dtl)) {
    $tbl .='<tr>';
    $tbl .='<td valign="top" width="30"  align="left">' . $no++ . '.</td>';
    $tbl .='<td valign="top" width="150" align="left">' . $dtlrow[$name] . '<br />' . $dtlrow[$code] . '</td>';
    $tbl .='<td valign="top" width="300"  align="left">' . $dtlrow['oaddr'] . '</td>';
    $tbl .='<td valign="top" width="150" align="left">' . $dtlrow['ophone'] . '</td>';
    $tbl .='<td valign="top" width="150" align="left">' . $dtlrow['ofax'] . '</td>';
    $tbl .='<td valign="top" width="150" align="left">' . $dtlrow['ocp1_name'] . '<br />' . $dtlrow['ocp1_title'] . '</td>';
    $tbl .='<td align="left">' . $dtlrow['oname'] . '</td>';
    $tbl .='</tr>';
}

$tbl .='</table>';
