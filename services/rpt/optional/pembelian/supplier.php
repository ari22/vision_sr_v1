<?php
$tbl .= '
<div id="cntr1" align="center">
<table width="80%">
<tr><td valign="top" align="center"><b style="font-size:1.5em;">'.$comp_name.'</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.5em;">'.$rptTitle.'</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.1em;">By Supplier</b></td></tr>
<tr><td valign="top" align="center"><b>DATE : '.dateView($date1).' UP TO '.dateView($date2).'</b></td></tr>
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
                <th valign="top" align="left"><b>SPK No.</b></th>
                <th valign="top" align="left"><b>Chassis</b></th>
                <th valign="top" align="right"><b>DPP</b></th>
                <th valign="top" align="right"><b>PPN</b></th>
                <th valign="top" align="right"><b>Others</b></th>
                <th valign="top" align="right"><b>Total Invoice</b></th>
            </tr>
        </thead>';


$tbl .= '<tr><td valign="top" colspan="9"></td></tr>';

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
            $tbl .='<td valign="top" colspan="3"></td>';
            $tbl .='<tdalign="right"><b>TOTAL ' . $last_supp_code . ' :</b></td>';
            $tbl .='<td valign="top" align="right" style="border-top:1px solid #000;">' . number_format($inv_bt) . '</td>';
            $tbl .='<td valign="top" align="right" style="border-top:1px solid #000;">' . number_format($inv_vat) . '</td>';
            $tbl .='<td valign="top" align="right" style="border-top:1px solid #000;">' . number_format($inv_stamp) . '</td>';
            $tbl .='<td valign="top" align="right" style="border-top:1px solid #000;">' . number_format($inv_total) . '</td>';
            $tbl .='</tr>';

            $j = 0;
            $inv_bt = 0;
            $inv_vat = 0;
            $inv_stamp = 0;
            $inv_total = 0;
        }

        $tbl.= '<tr><td valign="top" colspan="9" align="left"><b style="font-size:1.1em;">' . $dtlrow['supp_code'] . ' : ' . $dtlrow['supp_name'] . '</b></td></tr>';
        $last_supp_name = $dtlrow['supp_name'];
        $last_supp_code = $dtlrow['supp_code'];
    }

    $inv_bt += $dtlrow['inv_bt'];
    $inv_vat += $dtlrow['inv_vat'];
    $inv_stamp += $dtlrow['inv_stamp'];
    $inv_total += $dtlrow['inv_total'];

   $pur_date = '';
    if ($dtlrow['pur_date'] != '0000-00-00') {
        $pur_date = date_create($dtlrow['pur_date']);
        $pur_date = date_format($pur_date, "d/m/Y");
    }

    $tbl .='<tr>';
    $tbl .='<td valign="top" align="left">' . $dtlrow['pur_inv_no'] . '</td>';
    $tbl .='<td valign="top" align="left">' . $pur_date . '</td>';
    $tbl .='<td valign="top" align="left">' . $dtlrow['so_no'] . '</td>';
    $tbl .='<td valign="top" align="left">' . $dtlrow['chassis'] . '</td>';
    $tbl .='<td valign="top" align="right">' . number_format($dtlrow['inv_bt']) . '</td>';
    $tbl .='<td valign="top" align="right">' . number_format($dtlrow['inv_vat']) . '</td>';
    $tbl .='<td valign="top" align="right">' . number_format($dtlrow['inv_stamp']) . '</td>';
    $tbl .='<td valign="top" align="right">' . number_format($dtlrow['inv_total']) . '</td>';
    $tbl .='</tr>';

    $i++;
    $j++;
    unset($dtlrow);
}

if ($i >= 1) {
    $tbl .='<tr>';
    $tbl .='<td valign="top" colspan="3"></td>';
    $tbl .='<td valign="top" align="right"><b>TOTAL ' . $last_supp_code . ' :</b></td>';
    $tbl .='<td valign="top" align="right" style="border-top:1px solid #000;">' . number_format($inv_bt) . '</td>';
    $tbl .='<td valign="top" align="right" style="border-top:1px solid #000;">' . number_format($inv_vat) . '</td>';
    $tbl .='<td valign="top" align="right" style="border-top:1px solid #000;">' . number_format($inv_stamp) . '</td>';
    $tbl .='<td valign="top" align="right" style="border-top:1px solid #000;">' . number_format($inv_total) . '</td>';
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
$tbl .='<td></td>';
$tbl .='<td></td>';
$tbl .='<td></td>';
$tbl .='<td class="border-foot" valign="top" style="border-left:2px solid black;border-top:2px solid black;border-bottom:2px solid black;" align="right"><b>GRAND TOTAL:</b></td>';
$tbl .='<td class="border-foot" valign="top" style="border-top:2px solid black;border-bottom:2px solid black;" align="right">' . number_format($t_inv_bt) . '</td>';
$tbl .='<td class="border-foot" valign="top" style="border-top:2px solid black;border-bottom:2px solid black;" align="right">' . number_format($t_inv_vat) . '</td>';
$tbl .='<td class="border-foot" valign="top" style="border-top:2px solid black;border-bottom:2px solid black;" align="right">' . number_format($t_inv_stamp) . '</td>';
$tbl .='<td class="border-foot" valign="top" style="border-right:2px solid black;border-top:2px solid black;border-bottom:2px solid black;" align="right">' . number_format($t_inv_total) . '</td>';
$tbl .='</tr>';
$tbl .='</tfoot>';
$tbl .= '</table>';
