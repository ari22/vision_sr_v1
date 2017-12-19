<?php

$tbl .= '<div id="cntr1" align="center">';
$tbl .= '
<table width="80%">
<tr><td valign="top" align="center"><b style="font-size:1.1em;">' . $comp_name . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.1em;">' . $title . ' REPORT ' . $status . '</b></td></tr>
</table>
';

$tbl .= '
<table width="80%">
<tr>
<td></td>
<td valign="top" align="right"><b>Printed On: </b>' . date('d/m/Y') . '</td>
</tr>
</table>';

$tbl .= '
<table width="80%">
<thead style="border:2px solid black !important;">
<tr>
    <td class="border-head"  valign="top"rowspan="2" width="30"><b>No.</b></td>
    <td class="border-head"  valign="top"rowspan="2"><b>Registered<br />SPK</b></td>
    <td class="border-head"  valign="top" colspan="2" align="center" style="border-bottom:1px solid #000"><b>Registration</b></td>
    <td class="border-head"  valign="top"rowspan="2"></td>
    <td class="border-head"  valign="top" colspan="2" style="border-bottom:1px solid #000"><b></b></td>
    <td class="border-head"  valign="top" colspan="2" style="border-bottom:1px solid #000"><b>Distribution</b></td>
    <td class="border-head"  valign="top"rowspan="2"><b>Used Date (b)<br />Note</b></td>
</tr>
<tr>
    <td><b>Date</b></td>
    <td><b>By</b></td>
    <td><b>Date (a)</b></td>
    <td><b>By</b></td>
    <td><b>To</b></td>
    <td></td>
</tr>

</thead>';
$tbl .="<tr><td></td></tr>";

$no = 1;
$so_dstdate = '';
$use_date = '';

while ($dtlrow = mysql_fetch_array($dtl)) {

    $so_regdate = dateView($dtlrow['so_regdate']);

    if ($dtlrow['use_date'] !== '0000-00-00 00:00:00') {
        $use_date = dateView($dtlrow['use_date']);
    }
    if ($dtlrow['so_dstdate'] !== '0000-00-00 00:00:00') {
        $so_dstdate = dateView($dtlrow['so_dstdate']);
    }

    $tbl .="<tr>";
    $tbl .="<td>" . $no . ".</td>";
    $tbl .="<td>" . $dtlrow['so_no'] . "</td>";
    $tbl .="<td>" . $so_regdate . "</td>";
    $tbl .="<td>" . $dtlrow['so_reg_by'] . "</td>";
    $tbl .="<td></td>";
    $tbl .="<td>" . $so_dstdate . "</td>";
    $tbl .="<td>" . $dtlrow['so_dst_by'] . "</td>";
    $tbl .="<td>" . $dtlrow['srep_code'] . "</td>";
    $tbl .="<td>" . $dtlrow['srep_name'] . "</td>";
    $tbl .="<td>" . $use_date . "<br />" . $dtlrow['so_note'] . "</td>";
    $tbl .="</tr>";


    $no++;
}

$tbl .='</table>';
$tbl .='</div>';
