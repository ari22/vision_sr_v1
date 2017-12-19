<?php
$tbl .= '
<div id="cntr1" align="center">
<table width="80%">
<tr><td align="center"><b style="font-size:1.5em;">'.$comp_name.'</b></td></tr>
<tr><td align="center"><b style="font-size:1.5em;">'.$rptTitle.'</b></td></tr>
<tr><td align="center"><b style="font-size:1.1em;">'.$title.'</b></td></tr>
<tr><td align="center"><b>DATE : '.dateView($date1).' UP TO '.dateView($date2).'</b></td></tr>
</table>
';


$tbl .= '
<table width="80%"  >
<tr>
<td></td>
<td align="right"><b>Printed On: </b>' . date('d/m/Y') . '</td>
</tr>
</table>';

$tbl .= '<table width="80%">';
$tbl .= '<thead style="border:2px solid black !important;">
            <tr>
                <th align="left"><b>WO No.</b></th>
                <th align="left"><b>WO Date</b></th>
                <th align="left"><b>SPK No.</b></th>
                <th align="left"><b>Chassis</b></th>
                <th  align="right"><b>DPP</b></th>
                <th  align="right"><b>PPN</b></th>
                <th  align="right"><b>Others</b></th>
                <th  align="right"><b>Total Invoice</b></th>';
$tbl .= '</tr></thead>';
$tbl .= '<tr><td></td></tr>';

$i = 0;
$j = 0;

$t_inv_bt = 0;
$t_inv_vat = 0;
$t_inv_stamp = 0;
$t_inv_total = 0;

$inv_bt = 0;
$inv_vat = 0;
$inv_stamp = 0;
$inv_total = 0;


$last_supp_code = '';
$last_supp_name = '';

while ($dtlrow = mysql_fetch_array($dtl)) {
    $t_inv_bt += $dtlrow['inv_bt'];
    $t_inv_vat += $dtlrow['inv_vat'];
    $t_inv_stamp += $dtlrow['inv_stamp'];
    $t_inv_total += $dtlrow['inv_total'];

    if ($last_supp_name != $dtlrow['supp_name']) {
        if ($i >= 1) {
            $tbl .='<tr>';
            $tbl .='<td></td>';
            $tbl .='<td></td>';
            $tbl .='<td></td>';
            $tbl .='<td align="right"><b>TOTAL ' . $last_supp_code . ' : '.$last_supp_name.' :</b></td>';
            $tbl .='<td  align="right" style="border-top:1px solid #000;">' . number_format($inv_bt) . '</td>';
            $tbl .='<td  align="right" style="border-top:1px solid #000;">' . number_format($inv_vat) . '</td>';
            $tbl .='<td  align="right" style="border-top:1px solid #000;">' . number_format($inv_stamp) . '</td>';
            $tbl .='<td  align="right" style="border-top:1px solid #000;">' . number_format($inv_total) . '</td>';
            $tbl .='</tr>';

            $j = 0;
            $inv_bt = 0;
            $inv_vat = 0;
            $inv_stamp = 0;
            $inv_total = 0;
        }

        $tbl.= '<tr><td colspan="8" align="left"><b style="font-size:1.1em;">' . $dtlrow['supp_code'] . ' : ' . $dtlrow['supp_name'] . '</b></td></tr>';
        $last_supp_name = $dtlrow['supp_name'];
        $last_supp_code = $dtlrow['supp_code'];
    }

    $inv_bt += $dtlrow['inv_bt'];
    $inv_vat += $dtlrow['inv_vat'];
    $inv_stamp += $dtlrow['inv_stamp'];
    $inv_total += $dtlrow['inv_total'];

    $wo_date = '';
    if ($dtlrow['wo_date'] != '0000-00-00') {
        $wo_date = date_create($dtlrow['wo_date']);
        $wo_date = date_format($wo_date, "d/m/Y");
    }

    $tbl .='<tr>';
    $tbl .='<td align="left">' . $dtlrow['wo_no'] . '</td>';
    $tbl .='<td align="left">' . $wo_date . '</td>';
    $tbl .='<td align="left">' . $dtlrow['so_no'] . '</td>';
    $tbl .='<td align="left">' . $dtlrow['chassis'] . '</td>';
    $tbl .='<td  align="right">' . number_format($dtlrow['inv_bt']) . '</td>';
    $tbl .='<td  align="right">' . number_format($dtlrow['inv_vat']) . '</td>';
    $tbl .='<td  align="right">' . number_format($dtlrow['inv_stamp']) . '</td>';
    $tbl .='<td  align="right">' . number_format($dtlrow['inv_total']) . '</td>';
    $tbl .='</tr>';

    $i++;
    $j++;
    unset($dtlrow);
}

if ($i >= 1) {
    $tbl .='<tr>';
    $tbl .='<td></td>';
    $tbl .='<td></td>';
    $tbl .='<td></td>';
    $tbl .='<td align="right"><b>TOTAL ' . $last_supp_code . ' : '.$last_supp_name.' :</b></td>';
    $tbl .='<td  align="right" style="border-top:1px solid #000;">' . number_format($inv_bt) . '</td>';
    $tbl .='<td  align="right" style="border-top:1px solid #000;">' . number_format($inv_vat) . '</td>';
    $tbl .='<td  align="right" style="border-top:1px solid #000;">' . number_format($inv_stamp) . '</td>';
    $tbl .='<td  align="right" style="border-top:1px solid #000;">' . number_format($inv_total) . '</td>';
    $tbl .='</tr>';

    $j = 0;
    $inv_bt = 0;
    $inv_vat = 0;
    $inv_stamp = 0;
    $inv_total = 0;
}

$tbl .='<tr><td colspan="8"><br /></td></tr>';
$tbl .= '<tfoot>';
$tbl .='<tr>';
$tbl .='<td></td>';
$tbl .='<td></td>';
$tbl .='<td></td>';
$tbl .='<td class="border-foot" style="border-left:2px solid black;border-bottom:2px solid black;border-top:2px solid black;" align="right"><b>GRAND TOTAL:</b></td>';
$tbl .='<td class="border-foot" style="border-bottom:2px solid black;border-top:2px solid black;"  align="right">' . number_format($t_inv_bt) . '</td>';
$tbl .='<td class="border-foot" style="border-bottom:2px solid black;border-top:2px solid black;"  align="right">' . number_format($t_inv_vat) . '</td>';
$tbl .='<td class="border-foot" style="border-bottom:2px solid black;border-top:2px solid black;"  align="right">' . number_format($t_inv_stamp) . '</td>';
$tbl .='<td class="border-foot" style="border-right:2px solid black;border-bottom:2px solid black;border-top:2px solid black;"  align="right">' . number_format($t_inv_total) . '</td>';
$tbl .='</tr>';
$tbl .='</tfoot>';
 
$tbl .= '</table>';
