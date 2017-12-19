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
<th valign="top" width="30" align="left"><b>No.</b></th>
<th valign="top" align="left"><b>Vehicle Name / Code</b></th>
<th valign="top" align="left"><b>Type</b></th>
<th valign="top" align="left"><b>Model</b></th>
<th valign="top" align="left"><b>Year</b></th>
<th valign="top" align="left"><b>Transm</b></th>
<th valign="top" align="left"><b>Chassis Prefix</b></th>
<th valign="top" align="left"><b>Engine Prefix</b></th>
<th valign="top" align="left"><b>Active</b></th>
<th valign="top" align="left"><b>Inactive</b></th>
</tr>
</thead>';

$tbl .='<tr><td valign="top"></td></tr>';

$no = 1;

while ($dtlrow = mysql_fetch_array($dtl)) {
    $tbl .= '<tr>';
    $tbl .= '<td valign="top" width="30" align="left">' . $no++ . '.</td>';
    $tbl .= '<td valign="top" align="left">'.$dtlrow['veh_name'].' / '.$dtlrow['veh_code'].'</td>';
    $tbl .= '<td valign="top" align="left">'.$dtlrow['veh_type'].'</td>';
    $tbl .= '<td valign="top" align="left">'.$dtlrow['veh_model'].'</td>';
    $tbl .= '<td valign="top" align="left">'.$dtlrow['veh_year'].'</td>';
    $tbl .= '<td valign="top" align="left">'.$dtlrow['veh_transm'].'</td>';
    $tbl .= '<td valign="top" align="left">'.$dtlrow['chas_pref'].'</td>';
    $tbl .= '<td valign="top" align="left">'.$dtlrow['eng_pref'].'</td>';
    $tbl .= '<td valign="top" align="left">'.$dtlrow['act_date'].'</td>';
    $tbl .= '<td valign="top" align="left">'.$dtlrow['exp_date'].'</td>';
    $tbl .= '</tr>';

}

$tbl .='</table>';
