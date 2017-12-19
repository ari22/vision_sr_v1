<?php

$tbl .= '
<div id="cntr1" align="center">
<table width="80%">
<tr><td align="center"><b style="font-size:1.5em;">' . $comp_name . '</b></td></tr>
<tr><td align="center"><b style="font-size:1.5em;">' . $rptTitle . '</b></td></tr>
<tr><td align="center"><b style="font-size:1.1em;">By Part Code</b></td></tr>
<tr><td align="center"><b>DATE : ' . dateView($date1) . ' UP TO ' . dateView($date2) . '</b></td></tr>
</table>
';

$tbl .= '
<table width="80%"  >
<tr>
<td></td>
<td align="right"><b>Printed On: </b>' . date('d/m/Y') . '</td>
</tr>
</table>';

$tbl .= '
        <table width="80%">
        <thead style="border:2px solid black !important;">
            <tr>
            <td width="30" align="left"><b>No.</b></td>
            <td width="100" align="left"><b>Part Code</b></td>
            <td width="150" align="left"><b>Part Name</b></td>
            <td width="100" align="right"><b>Unit</b></td>
            <td width="100" align="right"><b>Qty</b></td>
            <td width="100" align="left"><b>Warehouse<br />From</b></td>
            <td width="100" align="left"><b>Location<br />From</b></td>
            <td width="100" align="left"><b>Warehouse<br />To</b></td>
            <td width="100" align="left"><b>Location<br />To</b></td>
            <td width="100" align="left"><b>Invoice Date</b></td>
            <td width="150" align="left"><b>Invoice No.</b></td>
            </tr>
        </thead>';
$tbl .= '<tr><td colspan="6"></td></tr>';

$no = 1;
$qty = 0;

while ($dtlrow = mysql_fetch_array($dtl)) {

    $tqty += $dtlrow['qty'];

    $mov_date = '';
    if ($dtlrow['mov_date'] != '0000-00-00') {
        $mov_date = date_create($dtlrow['mov_date']);
        $mov_date = date_format($mov_date, "d/m/Y");
    }


    $tbl .= '<tr>';
    $tbl .= '<td width="30" align="left">' . $no++ . '</td>';
    $tbl .= '<td width="100" align="left">' . $dtlrow['part_code'] . '</td>';
    $tbl .= '<td width="150" align="left">' . $dtlrow['part_name'] . '</td>';
    $tbl .= '<td width="100" align="right">' . $dtlrow['unit'] . '</td>';
    $tbl .= '<td width="100" align="right">' . number_format($dtlrow['qty']) . '</td>';
    $tbl .= '<td width="100" align="left">' . $dtlrow['wrhs_from'] . '</td>';
    $tbl .= '<td width="100" align="left">' . $dtlrow['loc_from'] . '</td>';
    $tbl .= '<td width="100" align="left">' . $dtlrow['wrhs_to'] . '</td>';
    $tbl .= '<td width="100" align="left">' . $dtlrow['loc_to'] . '</td>';
    $tbl .= '<td width="100" align="left">' . $mov_date . '</td>';
    $tbl .= '<td width="150" align="left">' . $dtlrow['mov_inv_no'] . '</td>';
    $tbl .= '</tr>';
}





$tbl .='<tr><td colspan="16"><br /></td></tr>';
$tbl .='<tfoot>';
$tbl .= '<tr>';
$tbl .='<td colspan="3"></td>';
$tbl .='<td class="border-foot" style="border-left:2px solid black;border-bottom:2px solid black;border-top:2px solid black;" align="right">Grand Total :</td>';
$tbl .= '<td class="border-foot" style="border-bottom:2px solid black;border-top:2px solid black;" align="right">' . $dtlrow['unit'] . '</td>';
$tbl .= '<td class="border-foot" style="border-right:2px solid black;border-bottom:2px solid black;border-top:2px solid black;" width="100" align="right">' . number_format($tqty) . '</td>';
$tbl .= '</tr>';
$tbl .='</tfoot>';
$tbl .= '</table>';

