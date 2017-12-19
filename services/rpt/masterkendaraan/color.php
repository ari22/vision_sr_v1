<?php
//========CHANGE LOG=============
//ganti semua <td jadi <td valign="top"
//Expired => Inactive

$tbl .= '
<div id="cntr1" align="center">
<table width="100%">
<tr><td valign="top" align="center"><b style="font-size:1.1em;">' . $comp_name . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.1em;">' . strtoupper($title) . ' REPORT</b></td></tr>
</table>
';
$tbl .= '
<table width="100%"  >
<tr>
<td valign="top" align="right" colspan="3"><b>Printed On: </b>' . date('d/m/Y') . '</td>
</tr>
</table>';

$tbl .= '
<table width="100%">
<thead style="border:2px solid black !important;">
<tr>
<th valign="top" width="30"><b>No.</b></th>
<th valign="top" width="200"><b>Color Name / Code</b></th>
<th valign="top" width="100"><b>Type</b></th>
<th valign="top" width="100"><b>Active</b></th>
<th valign="top" width="100"><b>Inactive</b></th>
<th valign="top"><b>Note</b></th>
</tr>
</thead>';
$tbl .='<tr><td valign="top"></td></tr>';
$no = 1;


while ($dtlrow = mysql_fetch_array($dtl)) {
    $tbl .= '<tr>';
    $tbl .= '<td valign="top" width="30">' . $no++ . '.</td>';
    $tbl .= '<td valign="top" width="200">' . $dtlrow['color_name'] . ' / '.$dtlrow['color_code'].'</td>';
    $tbl .= '<td valign="top" width="100">' . $dtlrow['type'] . '</td>';
    $tbl .= '<td valign="top" width="100">' . $dtlrow['act_date'] . '</td>';
    $tbl .= '<td valign="top" width="100">' . $dtlrow['exp_date'] . '</td>';
    $tbl .= '<td valign="top">' . $dtlrow['note'] . '</td>';
    $tbl .= '</tr>';
}

$tbl .='</table>';
