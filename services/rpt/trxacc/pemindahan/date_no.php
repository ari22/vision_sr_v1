<?php

$tbl .= '
<div id="cntr1" align="center">
<table width="80%">
<tr><td align="center"><b style="font-size:1.5em;">' . $comp_name . '</b></td></tr>
<tr><td align="center"><b style="font-size:1.5em;">' . $rptTitle . '</b></td></tr>
<tr><td align="center"><b style="font-size:1.1em;">By Invoice Date By Invoice No.</b></td></tr>
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
                <td align="left"><b>Invoice Date</b></td>
                <td width="150" align="left"><b>Invoice No.</b></td>
                <td align="left"><b>Warehouse From</b></td>
                <td align="left"><b>Warehouse To</b></td>
                <td width="50" align="right"><b>Item</b></td>
                <td width="50" align="right"><b>Total<br />Qty</b></td>
                <td width="30"></td>
                <td align="left"><b>Moved By</b></td>
           </tr>
        </thead>';
$tbl .= '<tr><td colspan="6"></td></tr>';

$i = 0;
$j = 0;

$titem = 0;
$tqty = 0;

$last_wrhs_code = '';

while ($dtlrow = mysql_fetch_array($dtl)) {

    $titem += $dtlrow['tot_item'];
    $tqty += $dtlrow['tot_qty'];

    $mov_date = '';
    if ($dtlrow['mov_date'] != '0000-00-00') {
        $mov_date = date_create($dtlrow['mov_date']);
        $mov_date = date_format($mov_date, "d/m/Y");
    }

    $tbl .='<tr>';

    $tbl .='<td align="left">' . $mov_date . '</td>';
    $tbl .='<td width="150" align="left">' . $dtlrow['mov_inv_no'] . '</td>';
    $tbl .='<td align="left">' . $dtlrow['wrhs_from'] . '</td>';
    $tbl .='<td align="left">' . $dtlrow['wrhs_to'] . '</td>';
    $tbl .='<td align="right">' . number_format($dtlrow['tot_item']) . '</td>';
    $tbl .='<td align="right">' . number_format($dtlrow['tot_qty']) . '</td>';
    $tbl .='<td width="30"></td>';
    $tbl .='<td align="left">' . $dtlrow['mvrep_code'] . ' : ' . $dtlrow['mvrep_name'] . '</td>';
    $tbl .='</tr>';

    $i++;
    $j++;

    unset($dtlrow);
}

$tbl .='<tr><td colspan="7"><br /></td></tr>';
$tbl .='<tfoot>';
$tbl .='<tr>';
$tbl .='<td width="150"></td>';
$tbl .='<td  colspan="2" width="100"></td>';
$tbl .='<td class="border-foot" style="border-left:2px solid black;border-bottom:2px solid black;border-top:2px solid black;" align="right"><b>GRAND TOTAL :</b></td>';
$tbl .='<td class="border-foot" style="border-bottom:2px solid black;border-top:2px solid black;" align="right">' . number_format($titem) . '</td>';
$tbl .='<td class="border-foot" style="border-right:2px solid black;border-bottom:2px solid black;border-top:2px solid black;"  align="right">' . number_format($tqty) . '</td>';
$tbl .='<td width="30"></td>';
$tbl .='<td width="100"></td>';
$tbl .='</tr>';
$tbl .='</table>';
