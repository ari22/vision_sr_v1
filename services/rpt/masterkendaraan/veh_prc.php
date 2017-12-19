<?php
//========CHANGE LOG=============
//ganti semua <td jadi <td valign="top"
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
<th valign="top" width="30" rowspan="2"><b>No.</b></th>
<th valign="top" width="150" rowspan="2"><b>Vehicle Name</b></th>
<th valign="top" width="100" rowspan="2"><b>Vehicle Code</b></th>
<th valign="top" rowspan="2" width="100"><b>Type/Model</b></th>
<th valign="top" rowspan="2" width="100"><b>Year</b></th>
<th valign="top" rowspan="2" width="100"><b>Transm</b></th>
<th valign="top" rowspan="2" width="150"><b>Chassis Prefix/<br />Engine Prefix</b></th>
<th valign="top" colspan="6" align="center" style="border-bottom:1px solid"><b>Sale</b></th>
</tr>
<tr>
<th valign="top" width="120"  align="right"><b>Base Price</b></th>
<th valign="top" width="120"  align="right"><b>PPN</b></th>
<th valign="top" width="120"  align="right"><b>PBM</b></th>
<th valign="top" width="120"  align="right"><b>BBN</b></th>
<th valign="top" width="120"  align="right"><b>Etc.</b></th>
<th valign="top" width="120"  align="right"><b>Total Price</b></th>
</tr>
</thead>';
$tbl .='<tr><td valign="top"></td></tr>';
$no = 1;


while ($dtlrow = mysql_fetch_array($dtl)) {
    $tbl .='<tr>';
    $tbl .='<td valign="top" width="30">' . $no++ . '.</td>';
    $tbl .='<td valign="top" width="150">' . $dtlrow['veh_name'] . '</td>';
    $tbl .='<td valign="top" width="100">' . $dtlrow['veh_code'] . '</td>';
    $tbl .='<td valign="top" width="100">' . $dtlrow['veh_type'] . ' / ' . $dtlrow['veh_model'] . '</td>';
    $tbl .='<td valign="top" width="100">' . $dtlrow['veh_year'] . '</td>';
    $tbl .='<td valign="top" width="100">' . $dtlrow['veh_transm'] . '</td>';
    $tbl .='<td valign="top" width="150">' . $dtlrow['chas_pref'] . ' / ' . $dtlrow['eng_pref'] . '</td>';
    $tbl .='<td valign="top" width="120" align="right">' . number_format($dtlrow['salb_price']) . '</td>';
    $tbl .='<td valign="top" width="120"  align="right">' . number_format($dtlrow['sal_vat']) . '</td>';
    $tbl .='<td valign="top" width="120"  align="right">' . number_format($dtlrow['sal_pbm']) . '</td>';
    $tbl .='<td valign="top" width="120"  align="right">' . number_format($dtlrow['sal_bbn']) . '</td>';
    $tbl .='<td valign="top" width="120"  align="right">' . number_format($dtlrow['sal_misc']) . '</td>';
    $tbl .='<td valign="top" width="120"  align="right">' . number_format($dtlrow['sal_price']) . '</td>';
    $tbl .='</tr>';
}

$tbl .='</table>';
