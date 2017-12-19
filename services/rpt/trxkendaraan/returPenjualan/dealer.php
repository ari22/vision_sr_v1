<?php

if ($l_rsal_price == 1) {
    $width = '100%';
} else {
    $width = '80%';
}
$tbl .= '
<div id="cntr1" align="center">
<table width="' . $width . '">
<tr><td align="center"><b style="font-size:1.5em;">' . $comp_name . '</b></td></tr>
<tr><td align="center"><b style="font-size:1.5em;">' . $rptTitle . '</b></td></tr>
<tr><td align="center"><b style="font-size:1.1em;">Group By ' . $title . '</b></td></tr>';
if($filterdesc !== ''){
    $tbl .= '    <tr><td valign="top" align="center"><span style="font-size:1.1em;">Filter By ' . $filterdesc . '</span></td></tr>';
} 
$tbl .='<tr><td align="center"><b>DATE : ' . dateView($rsl_date1) . ' UP TO ' . dateView($rsl_date2) . '</b></td></tr>
</table>
';

$tbl .= '<table width="' . $width . '"   ><tr><td><br /></td></tr><tr><td width="65%"></td>';
if ($l_rsal_price == 1) {
    $tbl .= '<td><b>a - b = c = g + h + i</b></td><td><b>c + d + e = f</b></td>';
}
$tbl .= '<td align="right"><b>Printed On: </b>' . date('d/m/Y') . '</td></tr></table>';

$tbl .= '
<table width="' . $width . '">
<thead style="border:2px solid black !important;">
<tr>
<td valign="top" width="100"><b>Invoice No.<br />Invoice Date</b></td>
<td valign="top"  width="120"><b>Chassis</b></td>
<td valign="top"  width="50"><b>Wrhs</b></td>
<td valign="top"  width="160"><b>Color</b></td>
<td valign="top"  width="150"><b>Sales</b></td>
<td valign="top"  width="140"><b>Sale Invoice No.<br />Sale Invoice Date</b></td>
<td valign="top"  width="100"><b>Delivery No.<br />Delivery Date</b></td>
<td valign="top"  width="100"><b>Receipt No.<br />Receipt Date</b></td>
<td valign="top" align="right" width="20"><b>Qty<br />(Unit)</b></td>';

if ($l_rsal_price == 1) {
    $tbl .='<td valign="top" width="100" align="right"><b>Sale Price (a)<br />BBN (d)</b></td>
                <td valign="top" width="100" align="right"><b>Discount (b)<br />Others (e)</b></td>
                <td valign="top" width="100" align="right"><b>Subtotal (c)<br />Price Total (f)</b></td>
                <td valign="top" width="100" align="right"><b>DPP (g)<br />PBM (i)</b></td>
                <td valign="top" width="115" align="right"><b>PPN (h)</b></td>';
}

$tbl .='</tr></thead>';
$tbl .= '<tr><td></td></tr>';
$no = 1;
$lnQty = 0;
$lnQty2 = 0;
$sumQty = 0;

$i = 0;
$j = 0;
$last_veh_code = '';
$last_veh_name = '';
$last_cust_name = '';
$last_cust_code = '';


$veh_price = 0;
$veh_bbn = 0;
$veh_disc = 0;
$veh_misc = 0;
$veh_at = 0;
$veh_total = 0;
$veh_bt = 0;
$veh_pbm = 0;
$veh_vat = 0;
$veh_vat_yad = 0;
$sum_veh_vat = 0;

$veh_price2 = 0;
$veh_bbn2 = 0;
$veh_disc2 = 0;
$veh_misc2 = 0;
$veh_at2 = 0;
$veh_total2 = 0;
$veh_bt2 = 0;
$veh_pbm2 = 0;
$veh_vat2 = 0;
$veh_vat_yad2 = 0;
$sum_veh_vat2 = 0;
$sum_veh_vat_yad2 = 0;


$tveh_price = 0;
$tveh_bbn = 0;
$tveh_disc = 0;
$tveh_misc = 0;
$tveh_at = 0;
$tveh_total = 0;
$tveh_bt = 0;
$tveh_pbm = 0;
$tveh_vat = 0;
$sum_veh_vat_yad = 0;

$colCount = 0;
if ($l_rsal_price == 1) {
    $colCount = 14;
} else {
    $colCount = 9;
}

while ($dtlrow = mysql_fetch_array($dtl)) {

    $tveh_price += $dtlrow['veh_price'];
    $tveh_bbn += $dtlrow['veh_bbn'];
    $tveh_disc += $dtlrow['veh_disc'];
    $tveh_misc += $dtlrow['veh_misc'];
    $tveh_at += $dtlrow['veh_at'];
    $tveh_total += $dtlrow['veh_total'];
    $tveh_bt += $dtlrow['veh_bt'];
    $tveh_pbm += $dtlrow['veh_pbm'];
    $tveh_vat += $dtlrow['veh_vat'];

    if ($last_cust_code != $dtlrow['cust_code']) {
        if ($i >= 1) {
            $tbl.= '<tr>
			<td valign="top" colspan="8" align="right">TOTAL ' . $last_veh_code . ' : ' . $last_veh_name . ':</td>
			<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($lnQty) . '</td>';

            if ($l_rsal_price == 1) {
                $tbl.= '<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($veh_price) . '<br />' . number_format($veh_bbn) . '</td>';
                $tbl.= '<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($veh_disc) . '<br />' . number_format($veh_misc) . '</td>';
                $tbl.= '<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($veh_at) . '<br />' . number_format($veh_total) . '</td>';
                $tbl.= '<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($veh_bt) . '<br />' . number_format($veh_pbm) . '</td>';
                $tbl.= '<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($veh_vat) . '</td>';
            }

            $tbl.='</tr>';

            $lnQty = 0;
            $veh_price = 0;
            $veh_bbn = 0;
            $veh_disc = 0;
            $veh_misc = 0;
            $veh_at = 0;
            $veh_total = 0;
            $veh_bt = 0;
            $veh_pbm = 0;
            $veh_vat = 0;
            $veh_vat = 0;
            $veh_vat_yad = 0;
            $i = 0;
        }

        if ($j >= 1) {
            $tbl.= '<tr>
			<td valign="top" colspan="8" align="right"><b style="font-size:1.1em;">TOTAL ' . $last_cust_code . ' : ' . $last_cust_name . ':</b></td>
			<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($lnQty2) . '</b></td>';

            if ($l_rsal_price == 1) {
                $tbl.= '<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($veh_price2) . '<br />' . number_format($veh_bbn2) . '</b></td>';
                $tbl.= '<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($veh_disc2) . '<br />' . number_format($veh_misc2) . '</b></td>';
                $tbl.= '<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($veh_at2) . '<br />' . number_format($veh_total2) . '</b></td>';
                $tbl.= '<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($veh_bt2) . '<br />' . number_format($veh_pbm2) . '</b></td>';
                $tbl.= '<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($veh_vat2) . '</td></b>';
            }

            $tbl.='</tr>';
            $j = 0;
            $lnQty2 = 0;
            $veh_price2 = 0;
            $veh_bbn2 = 0;
            $veh_disc2 = 0;
            $veh_misc2 = 0;
            $veh_at2 = 0;
            $veh_total2 = 0;
            $veh_bt2 = 0;
            $veh_pbm2 = 0;
            $veh_vat2 = 0;
            $veh_vat2 = 0;
            $veh_vat_yad2 = 0;
        }


        $tbl.= '<tr></tr><tr><td valign="top" colspan="' . $colCount . '" align="left"><b style="font-size:1.1em;">*** ' . $dtlrow['cust_code'] . ' : ' . $dtlrow['cust_name'] . ' ***</b></td></tr>';
        $last_cust_code = $dtlrow['cust_code'];
        $last_cust_name = $dtlrow['cust_name'];

        $tbl.= '<tr></tr><tr><td valign="top" colspan="' . $colCount . '" align="left"><b style="font-size:1.1em;">' . $dtlrow['veh_code'] . ' : ' . $dtlrow['veh_name'] . '</b></td></tr>';
        $last_veh_name = $dtlrow['veh_name'];
        $last_veh_code = $dtlrow['veh_code'];
    } elseif ($last_veh_code != $dtlrow['veh_code']) {
        if ($i >= 1) {
            $tbl.= '<tr>
			<td valign="top" colspan="8" align="right">TOTAL ' . $last_veh_code . ' : ' . $last_veh_name . ':</td>
			<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($lnQty) . '</td>';

            if ($l_rsal_price == 1) {
                $tbl.= '<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($veh_price) . '<br />' . number_format($veh_bbn) . '</td>';
                $tbl.= '<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($veh_disc) . '<br />' . number_format($veh_misc) . '</td>';
                $tbl.= '<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($veh_at) . '<br />' . number_format($veh_total) . '</td>';
                $tbl.= '<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($veh_bt) . '<br />' . number_format($veh_pbm) . '</td>';
                $tbl.= '<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($veh_vat) . '</td>';
            }

            $tbl.='</tr>';

            $lnQty = 0;
            $veh_price = 0;
            $veh_bbn = 0;
            $veh_disc = 0;
            $veh_misc = 0;
            $veh_at = 0;
            $veh_total = 0;
            $veh_bt = 0;
            $veh_pbm = 0;
            $veh_vat = 0;
            $veh_vat = 0;
            $veh_vat_yad = 0;
            $i = 0;
        }

        $tbl.= '<tr></tr><tr><td valign="top" colspan="' . $colCount . '" align="left"><b style="font-size:1.1em;">' . $dtlrow['veh_code'] . ' : ' . $dtlrow['veh_name'] . '</b></td></tr>';
        $last_veh_name = $dtlrow['veh_name'];
        $last_veh_code = $dtlrow['veh_code'];
    }

    $lnQty++;
    $lnQty2++;

    $sum_veh_vat += $dtlrow['veh_vat'];
    $veh_vat += $dtlrow['veh_vat'];
    $veh_vat2 += $dtlrow['veh_vat'];



    $veh_price += $dtlrow['veh_price'];
    $veh_bbn += $dtlrow['veh_bbn'];
    $veh_disc += $dtlrow['veh_disc'];
    $veh_misc += $dtlrow['veh_misc'];
    $veh_at += $dtlrow['veh_at'];
    $veh_total += $dtlrow['veh_total'];
    $veh_bt += $dtlrow['veh_bt'];
    $veh_pbm += $dtlrow['veh_pbm'];

    $veh_price2 += $dtlrow['veh_price'];
    $veh_bbn2 += $dtlrow['veh_bbn'];
    $veh_disc2 += $dtlrow['veh_disc'];
    $veh_misc2 += $dtlrow['veh_misc'];
    $veh_at2 += $dtlrow['veh_at'];
    $veh_total2 += $dtlrow['veh_total'];
    $veh_bt2 += $dtlrow['veh_bt'];
    $veh_pbm2 += $dtlrow['veh_pbm'];
    // $veh_vat += $dtlrow['veh_vat'];

    $rsl_date = dateView($dtlrow['rsl_date']);
    $sal_date = dateView($dtlrow['sal_date']);
    $sj_date = dateView($dtlrow['sj_date']);
    $kwit_date = dateView($dtlrow['kwit_date']);
    $fp_date = dateView($dtlrow['fp_date']);

    $tbl .= '<tr>';
    $tbl .= '<td valign="top"><b>' . $dtlrow['rsl_inv_no'] . '</b><br />' . $rsl_date . '</td>';
    $tbl .= '<td valign="top">' . $dtlrow['chassis'] . '</td>';
    $tbl .= '<td valign="top">' . $dtlrow['wrhs_code'] . '</td>';
    $tbl .= '<td valign="top">' . $dtlrow['color_code'] . '</td>';
    $tbl .= '<td valign="top">' . $dtlrow['srep_name'] . '</td>';
    $tbl .= '<td valign="top">' . $dtlrow['sal_inv_no'] . '<br />' . $sal_date . '</td>';
    $tbl .= '<td valign="top">' . $dtlrow['sj_no'] . '<br />' . $sj_date . '</td>';
    $tbl .= '<td valign="top">' . $dtlrow['kwit_no'] . '<br />' . $kwit_date . '</td>';
    $tbl .= '<td valign="top" align="right">1</td>';

    if ($l_rsal_price == 1) {
        $tbl .= '<td valign="top" align="right">' . number_format($dtlrow['veh_price']) . '<br />' . number_format($dtlrow['veh_bbn']) . '</td>';
        $tbl .= '<td valign="top" align="right">' . number_format($dtlrow['veh_disc']) . '<br />' . number_format($dtlrow['veh_misc']) . '</td>';
        $tbl .= '<td valign="top" align="right">' . number_format($dtlrow['veh_at']) . '<br />' . number_format($dtlrow['veh_total']) . '</td>';
        $tbl .= '<td valign="top" align="right">' . number_format($dtlrow['veh_bt']) . '<br />' . number_format($dtlrow['veh_pbm']) . '</td>';
        $tbl .= '<td valign="top" align="right">' . number_format($dtlrow['veh_vat']) . '</td>';
    }

    $tbl .= '</tr>';

    $i++;
    $j++;
    $sumQty++;
    unset($dtlrow);
}

if ($i >= 1) {
    $tbl.= '<tr>
			<td valign="top" colspan="8" align="right">TOTAL ' . $last_veh_code . ' : ' . $last_veh_name . ':</td>
			<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($lnQty) . '</td>';

    if ($l_rsal_price == 1) {
        $tbl.= '<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($veh_price) . '<br />' . number_format($veh_bbn) . '</td>';
        $tbl.= '<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($veh_disc) . '<br />' . number_format($veh_misc) . '</td>';
        $tbl.= '<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($veh_at) . '<br />' . number_format($veh_total) . '</td>';
        $tbl.= '<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($veh_bt) . '<br />' . number_format($veh_pbm) . '</td>';
        $tbl.= '<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($veh_vat) . '</td>';
    }

    $tbl.='</tr>';

    $lnQty = 0;
    $veh_price = 0;
    $veh_bbn = 0;
    $veh_disc = 0;
    $veh_misc = 0;
    $veh_at = 0;
    $veh_total = 0;
    $veh_bt = 0;
    $veh_pbm = 0;
    $veh_vat = 0;
    $veh_vat = 0;
    $veh_vat_yad = 0;
    $i = 0;
}

if ($j >= 1) {
    $tbl.= '<tr>
			<td valign="top" colspan="8" align="right"><b style="font-size:1.1em;">TOTAL ' . $last_cust_code . ' : ' . $last_cust_name . ':</b></td>
			<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($lnQty2) . '</b></td>';

    if ($l_rsal_price == 1) {
        $tbl.= '<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($veh_price2) . '<br />' . number_format($veh_bbn2) . '</b></td>';
        $tbl.= '<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($veh_disc2) . '<br />' . number_format($veh_misc2) . '</b></td>';
        $tbl.= '<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($veh_at2) . '<br />' . number_format($veh_total2) . '</b></td>';
        $tbl.= '<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($veh_bt2) . '<br />' . number_format($veh_pbm2) . '</b></td>';
        $tbl.= '<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($veh_vat2) . '</td></b>';
    }

    $tbl.='</tr>';
    $j = 0;
    $lnQty2 = 0;
    $veh_price2 = 0;
    $veh_bbn2 = 0;
    $veh_disc2 = 0;
    $veh_misc2 = 0;
    $veh_at2 = 0;
    $veh_total2 = 0;
    $veh_bt2 = 0;
    $veh_pbm2 = 0;
    $veh_vat2 = 0;
    $veh_vat2 = 0;
    $veh_vat_yad2 = 0;
}

$tbl.= '<tr><td><br /><br /></td></tr>';
$tbl.= '<tfoot>';
$tbl.= '<tr>
            <td  colspan="6"></td>
            <td colspan="2" align="right" style="border-left:2px solid black;border-top:2px solid black;border-bottom:2px solid black;"><b style="font-size:1.1em;">GRAND TOTAL:</b></td>
            <td valign="top" align="right" style="border-top:2px solid black;border-bottom:2px solid black;';

if ($l_rsal_price == 0) {
    $tbl .= 'border-right:2px solid black;';
}
$tbl.= '"><b>' . number_format($sumQty) . '</b></td>';

if ($l_rsal_price == 1) {
    $tbl.= '<td style="border-top:2px solid black;border-bottom:2px solid black;" valign="top" align="right"><b>' . number_format($tveh_price) . '<br />' . number_format($tveh_bbn) . '</b></td>';
    $tbl.= '<td style="border-top:2px solid black;border-bottom:2px solid black;" valign="top" align="right"><b>' . number_format($tveh_disc) . '<br />' . number_format($tveh_misc) . '</b></td>';
    $tbl.= '<td style="border-top:2px solid black;border-bottom:2px solid black;" valign="top" align="right"><b>' . number_format($tveh_at) . '<br />' . number_format($tveh_total) . '</b></td>';
    $tbl.= '<td style="border-top:2px solid black;border-bottom:2px solid black;" valign="top" align="right"><b>' . number_format($tveh_bt) . '<br />' . number_format($tveh_pbm) . '</b></td>';
    $tbl.= '<td style="border-right:2px solid black;border-top:2px solid black;border-top:2px solid black;border-bottom:2px solid black;" valign="top" align="right"><b>' . number_format($sum_veh_vat) . '</b></td>';
}

$tbl.='</tr>';
$tbl.='</tfoot>';
$tbl .='</table>';
?>