<?php

$tbl .= '
<div id="cntr1" align="center">
<table width="80%">
<tr><td valign="top" align="center"><b style="font-size:1.5em;">' . $comp_name . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.5em;">' . $rptTitle . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.1em;">By Sales Person</b></td></tr>
<tr><td valign="top" align="center"><b>DATE : ' . dateView($date1) . ' UP TO ' . dateView($date2) . '</b></td></tr>
</table>
';


$tbl .= '
<table width="80%"  >
<tr>
<td></td>
<td valign="top" align="right"><b>Printed On: </b>' . date('d/m/Y') . '</td>
</tr>
</table>';

$tbl .= '<table width="80%">';
$tbl .= '<thead style="border:2px solid black !important;">
            <tr>
                <th valign="top" align="left"><b>Invoice No.</b></th>
                <th valign="top" align="left"><b>Invoice Date</b></th>
                <th valign="top" align="left"><b>Customer Name</b></th>
                <th valign="top" align="left"><b>SPK No.</b></th>
                <th valign="top" align="left"><b>Chassis</b></th>
                <th valign="top" align="right"><b>DPP</b></th>
                <th valign="top" align="right"><b>PPN</b></th>
                <th valign="top" align="right"><b>Others</b></th>
                <th valign="top" align="right"><b>Total Invoice</b></th>';
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


$last_srep_code = '';
$last_srep_name = '';

while ($dtlrow = mysql_fetch_array($dtl)) {
    $t_inv_bt += $dtlrow['inv_bt'];
    $t_inv_vat += $dtlrow['inv_vat'];
    $t_inv_stamp += $dtlrow['inv_stamp'];
    $t_inv_total += $dtlrow['inv_total'];

    if ($last_srep_name != $dtlrow['srep_name']) {
        if ($i >= 1) {
            $tbl .='<tr>';
            $tbl .='<td valign="top"></td>';
            $tbl .='<td valign="top"></td>';
            $tbl .='<td valign="top"></td>';
            $tbl .='<td valign="top" colspan="2" align="right"><b>TOTAL ' . $last_srep_code . ' : '.$last_srep_name.' :</b></td>';
            $tbl .='<td valign="top"  align="right" style="border-top:1px solid #000;">' . number_format($inv_bt) . '</td>';
            $tbl .='<td valign="top"  align="right" style="border-top:1px solid #000;">' . number_format($inv_vat) . '</td>';
            $tbl .='<td valign="top"  align="right" style="border-top:1px solid #000;">' . number_format($inv_stamp) . '</td>';
            $tbl .='<td valign="top"  align="right" style="border-top:1px solid #000;">' . number_format($inv_total) . '</td>';
            $tbl .='</tr>';

            $j = 0;
            $inv_bt = 0;
            $inv_vat = 0;
            $inv_stamp = 0;
            $inv_total = 0;
        }

        $tbl.= '<tr><td valign="top" colspan="9" align="left"><b style="font-size:1.1em;">' . $dtlrow['srep_code'] . ' : ' . $dtlrow['srep_name'] . '</b></td></tr>';
        $last_srep_name = $dtlrow['srep_name'];
        $last_srep_code = $dtlrow['srep_code'];
    }

    $inv_bt += $dtlrow['inv_bt'];
    $inv_vat += $dtlrow['inv_vat'];
    $inv_stamp += $dtlrow['inv_stamp'];
    $inv_total += $dtlrow['inv_total'];

    $sal_date = dateView($dtlrow['sal_date']);

    $tbl .='<tr>';
    $tbl .='<td valign="top" align="left">' . $dtlrow['sal_inv_no'] . '</td>';
    $tbl .='<td valign="top" align="left">' . $sal_date . '</td>';
    $tbl .='<td valign="top" align="left">' . $dtlrow['cust_name'] . '</td>';
    $tbl .='<td valign="top" align="left">' . $dtlrow['so_no'] . '</td>';
    $tbl .='<td valign="top" align="left">' . $dtlrow['chassis'] . '</td>';
    $tbl .='<td valign="top"  align="right">' . number_format($dtlrow['inv_bt']) . '</td>';
    $tbl .='<td valign="top"  align="right">' . number_format($dtlrow['inv_vat']) . '</td>';
    $tbl .='<td valign="top"  align="right">' . number_format($dtlrow['inv_stamp']) . '</td>';
    $tbl .='<td valign="top"  align="right">' . number_format($dtlrow['inv_total']) . '</td>';
    $tbl .='</tr>';

    $i++;
    $j++;
    unset($dtlrow);
}

if ($i >= 1) {
    $tbl .='<tr>';
    $tbl .='<td valign="top"></td>';
    $tbl .='<td valign="top"></td>';
    $tbl .='<td valign="top"></td>';
    $tbl .='<td valign="top" colspan="2" align="right"><b>TOTAL ' . $last_srep_code . ' : '.$last_srep_name.' :</b></td>';
    $tbl .='<td valign="top"  align="right" style="border-top:1px solid #000;">' . number_format($inv_bt) . '</td>';
    $tbl .='<td valign="top"  align="right" style="border-top:1px solid #000;">' . number_format($inv_vat) . '</td>';
    $tbl .='<td valign="top"  align="right" style="border-top:1px solid #000;">' . number_format($inv_stamp) . '</td>';
    $tbl .='<td valign="top"  align="right" style="border-top:1px solid #000;">' . number_format($inv_total) . '</td>';
    $tbl .='</tr>';

    $j = 0;
    $inv_bt = 0;
    $inv_vat = 0;
    $inv_stamp = 0;
    $inv_total = 0;
}

$tbl .='<tr><td valign="top" colspan="9"><br /></td></tr>';
$tbl .='<tfoot>';
$tbl .='<tr>';
$tbl .='<td valign="top"></td>';
$tbl .='<td valign="top"></td>';
$tbl .='<td valign="top"></td>';
$tbl .='<td valign="top"></td>';
$tbl .='<td class="border-foot" valign="top" style="border-left:2px solid black;border-top:2px solid black;border-bottom:2px solid black;" align="right"><b>GRAND TOTAL:</b></td>';
$tbl .='<td class="border-foot" valign="top" style="border-top:2px solid black;border-bottom:2px solid black;" align="right"><b>' . number_format($t_inv_bt) . '</b></td>';
$tbl .='<td class="border-foot" valign="top" style="border-top:2px solid black;border-bottom:2px solid black;" align="right"><b>' . number_format($t_inv_vat) . '</b></td>';
$tbl .='<td class="border-foot" valign="top" style="border-top:2px solid black;border-bottom:2px solid black;" align="right"><b>' . number_format($t_inv_stamp) . '</b></td>';
$tbl .='<td class="border-foot" valign="top" style="border-right:2px solid black;border-top:2px solid black;border-bottom:2px solid black;" align="right"><b>' . number_format($t_inv_total) . '</b></td>';
$tbl .='</tr>';
$tbl .='</tfoot>';
$tbl .= '</table>';
