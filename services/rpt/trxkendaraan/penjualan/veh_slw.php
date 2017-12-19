<?php

if ($l_sal_price == 1) {
    $width = '100%';
} else {
    $width = '70%';
}
$tbl .= '
<div id="cntr1" align="center">
<table width="' . $width . '">
<tr><td align="center"><b style="font-size:1.5em;">' . $comp_name . '</b></td></tr>
<tr><td align="center"><b style="font-size:1.5em;">' . $rptTitle . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.1em;">Group By ' . $title . '</b></td></tr>';
if($filterdesc !== ''){
    $tbl .= '    <tr><td valign="top" align="center"><span style="font-size:1.1em;">Filter By ' . $filterdesc . '</span></td></tr>';
}
$tbl .='<tr><td align="center"><b>DATE : ' . dateView($sal_date1) . ' UP TO ' . dateView($sal_date2) . '</b></td></tr>
</table>
';

$tbl .= '<table width="' . $width . '"   ><tr><td><br /></td></tr><tr><td width="65%"></td>';
if ($l_sal_price == 1) {
    $tbl .= '<td><b>a - b = c = g + h + i</b></td><td><b>c + d + e = f</b></td>';
}
$tbl .= '<td align="right"><b>Printed On: </b>' . date('d/m/Y') . '</td></tr></table>';

$tbl .= '
<table width="' . $width . '">
<thead style="border:2px solid black !important;">
<tr>
    <td class="border-head" valign="top" width="100"><b>Invoice No.<br />Invoice Date</b></td>
    <td class="border-head" valign="top" width="100"><b>Chassis<br />Sales Person</b></td>
    <td class="border-head" valign="top" width="100"><b>Customer<br />Supervisor</b></td>
    <td class="border-head" valign="top" width="90"><b>DO (SJ) No.<br />DO (SJ) Date</b></td>
    <td class="border-head" valign="top" width="90"><b>Receipt No.<br />Receipt Date</b></td>
    <td class="border-head" valign="top" width="90"><b>Tax No.<br />Tax Date</b></td>
    <td class="border-head" valign="top" width="50"><b>Color</b></td>
    <td class="border-head" valign="top" width="100"><b>SPK No.<br />Note</b></td>
    <td class="border-head" valign="top" width="30" align="right"><b>Qty<br />(Unit)</b></td>';

if ($l_sal_price == 1) {
    $tbl .='    <td class="border-head" valign="top" width="90" align="right"><b>Sale Price (a)<br />BBN (d)</b></td>
                <td class="border-head" valign="top" width="90" align="right"><b>Discount (b)<br />Others (e)</b></td>
                <td class="border-head" valign="top" width="90" align="right"><b>Subtotal (c)<br />Total Price (f)</b></td>
                <td class="border-head" valign="top" width="90" align="right"><b>DPP (g)<br />PBM (i)</b></td>
                <td class="border-head" valign="top" width="140" align="right"><b>Current VAT (h)<br />Outstanding VAT (h)</b></td>';
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

$last_wrhs_code = '';
$last_wrhs_name = '';


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
if ($l_sal_price == 1) {
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
    //$tveh_vat += $dtlrow['veh_vat'];

    if ($last_wrhs_name != $dtlrow['wrhs_name']) {

        if ($j >= 1) {
            $tbl.= '<tr>
			<td valign="top" colspan="8" align="right">TOTAL ' . $last_veh_code . ' : ' . $last_veh_name . ':</td>
			<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($lnQty2) . '</td>';

            if ($l_sal_price == 1) {
                $tbl.= '<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($veh_price2) . '<br />' . number_format($veh_bbn2) . '</td>';
                $tbl.= '<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($veh_disc2) . '<br />' . number_format($veh_misc2) . '</td>';
                $tbl.= '<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($veh_at2) . '<br />' . number_format($veh_total2) . '</td>';
                $tbl.= '<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($veh_bt2) . '<br />' . number_format($veh_pbm2) . '</td>';
                $tbl.= '<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($veh_vat2) . '<br />' . number_format($veh_vat_yad2) . '</td>';
            }

            $tbl.='</tr>';

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

        if ($i >= 1) {
            $tbl.= '<tr>
			<td valign="top" colspan="8" align="right"><b style="font-size:1.1em;">TOTAL ' . $last_wrhs_code . ':</b></td>
			<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($lnQty) . '</b></td>';

            if ($l_sal_price == 1) {
                $tbl.= '<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($veh_price) . '<br />' . number_format($veh_bbn) . '</b></td>';
                $tbl.= '<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($veh_disc) . '<br />' . number_format($veh_misc) . '</b></td>';
                $tbl.= '<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($veh_at) . '<br />' . number_format($veh_total) . '</b></td>';
                $tbl.= '<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($veh_bt) . '<br />' . number_format($veh_pbm) . '</b></td>';
                $tbl.= '<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($veh_vat) . '<br />' . number_format($veh_vat_yad) . '</b></td>';
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
        }


        $tbl.= '<tr><td valign="top" colspan="' . $colCount . '" align="left"><b style="font-size:1.1em;">***  WAREHOUSE ' . $dtlrow['wrhs_code'] . ' ***</b></td></tr>';
        $last_wrhs_name = $dtlrow['wrhs_name'];
        $last_wrhs_code = $dtlrow['wrhs_code'];


        $tbl.= '<tr><td valign="top" colspan="' . $colCount . '" align="left"><b style="font-size:1.1em;">' . $dtlrow['veh_code'] . ' : ' . $dtlrow['veh_name'] . '</b></td></tr>';
        $last_veh_name = $dtlrow['veh_name'];
        $last_veh_code = $dtlrow['veh_code'];
    } elseif ($last_veh_name != $dtlrow['veh_name']) {
        if ($j >= 1) {
            $tbl.= '<tr>
			<td valign="top" colspan="8" align="right">TOTAL ' . $last_veh_code . ' : ' . $last_veh_name . ':</td>
			<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($lnQty2) . '</td>';

            if ($l_sal_price == 1) {
                $tbl.= '<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($veh_price2) . '<br />' . number_format($veh_bbn2) . '</td>';
                $tbl.= '<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($veh_disc2) . '<br />' . number_format($veh_misc2) . '</td>';
                $tbl.= '<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($veh_at2) . '<br />' . number_format($veh_total2) . '</td>';
                $tbl.= '<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($veh_bt2) . '<br />' . number_format($veh_pbm2) . '</td>';
                $tbl.= '<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($veh_vat2) . '<br />' . number_format($veh_vat_yad2) . '</td>';
            }

            $tbl.='</tr>';

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

        $tbl.= '<tr><td valign="top" colspan="' . $colCount . '" align="left"></td></tr><tr><td valign="top" colspan="' . $colCount . '" align="left"><b style="font-size:1.1em;"> ' . $dtlrow['veh_code'] . ': ' . $dtlrow['veh_name'] . '</b></td></tr>';
        $last_veh_name = $dtlrow['veh_name'];
        $last_veh_code = $dtlrow['veh_code'];
    }

    $lnQty++;
    $lnQty2++;



    if (!empty($dtlrow['fp_no'])) {
        $veh_vat += $dtlrow['veh_vat'];
        $sum_veh_vat += $dtlrow['veh_vat'];

        $veh_vat2 += $dtlrow['veh_vat'];
        $sum_veh_vat2 += $dtlrow['veh_vat'];
    } else {
        $veh_vat_yad = $veh_vat_yad + $dtlrow['veh_vat'];
        $sum_veh_vat_yad = $sum_veh_vat_yad + $dtlrow['veh_vat'];

        $veh_vat_yad2 += $dtlrow['veh_vat'];
        $sum_veh_vat_yad2 += $dtlrow['veh_vat'];
    }



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

    $sal_date = dateView($dtlrow['sal_date']);
    $sj_date = dateView($dtlrow['sj_date']);
    $kwit_date = dateView($dtlrow['kwit_date']);
    $fp_date = dateView($dtlrow['fp_date']);

    $tbl .= '<tr>';
    $tbl .= '<td valign="top"><b>' . $dtlrow['sal_inv_no'] . '</b><br />' . $sal_date . '</td>';
    $tbl .= '<td valign="top">' . $dtlrow['chassis'] . '<br />' . $dtlrow['srep_name'] . '</td>';
    $tbl .= '<td valign="top">' . $dtlrow['cust_name'] . '<br />' . $dtlrow['sspv_name'] . '</td>';
    $tbl .= '<td valign="top">' . $dtlrow['sj_no'] . '<br />' . $sj_date . '</td>';
    $tbl .= '<td valign="top">' . $dtlrow['kwit_no'] . '<br />' . $kwit_date . '</td>';
    $tbl .= '<td valign="top">' . $dtlrow['fp_no'] . '<br />' . $fp_date . '</td>';
    $tbl .= '<td valign="top">' . $dtlrow['color_code'] . '</td>';
    $tbl .= '<td valign="top">' . $dtlrow['so_no'] . '<br />' . $dtlrow['note'] . '</td>';
    $tbl .= '<td valign="top" align="right">1</td>';

    if ($l_sal_price == 1) {
        $tbl .= '<td valign="top" align="right">' . number_format($dtlrow['veh_price']) . '<br />' . number_format($dtlrow['veh_bbn']) . '</td>';
        $tbl .= '<td valign="top" align="right">' . number_format($dtlrow['veh_disc']) . '<br />' . number_format($dtlrow['veh_misc']) . '</td>';
        $tbl .= '<td valign="top" align="right">' . number_format($dtlrow['veh_at']) . '<br />' . number_format($dtlrow['veh_total']) . '</td>';
        $tbl .= '<td valign="top" align="right">' . number_format($dtlrow['veh_bt']) . '<br />' . number_format($dtlrow['veh_pbm']) . '</td>';

        $tbl .= '<td valign="top" align="right">';
        if (!empty($dtlrow['fp_no'])) {
            $tbl.= number_format($dtlrow['veh_vat']);
        } else {
            $tbl.=0;
        }
        $tbl .='<br />';
        if (empty($dtlrow['fp_no'])) {
            $tbl.= number_format($dtlrow['veh_vat']);
        } else {
            $tbl.=0;
        }
        $tbl .='</td>';
    }

    $tbl .= '</tr>';

    $i++;
    $j++;
    $sumQty++;
    unset($dtlrow);
}

if ($j >= 1) {
    $tbl.= '<tr>
			<td valign="top" colspan="8" align="right">TOTAL ' . $last_veh_code . ' : '.$last_veh_name.':</td>
			<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($lnQty2) . '</td>';

    if ($l_sal_price == 1) {
        $tbl.= '<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($veh_price2) . '<br />' . number_format($veh_bbn2) . '</td>';
        $tbl.= '<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($veh_disc2) . '<br />' . number_format($veh_misc2) . '</td>';
        $tbl.= '<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($veh_at2) . '<br />' . number_format($veh_total2) . '</td>';
        $tbl.= '<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($veh_bt2) . '<br />' . number_format($veh_pbm2) . '</td>';
        $tbl.= '<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($veh_vat2) . '<br />' . number_format($veh_vat_yad2) . '</td>';
    }

    $tbl.='</tr>';

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

if ($i >= 1) {
    $tbl.= '<tr>
			<td valign="top" colspan="8" align="right"><b style="font-size:1.1em;">TOTAL ' . $last_wrhs_code . ':</b></td>
			<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($lnQty) . '</b></td>';

    if ($l_sal_price == 1) {
        $tbl.= '<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($veh_price) . '<br />' . number_format($veh_bbn) . '</b></td>';
        $tbl.= '<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($veh_disc) . '<br />' . number_format($veh_misc) . '</b></td>';
        $tbl.= '<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($veh_at) . '<br />' . number_format($veh_total) . '</b></td>';
        $tbl.= '<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($veh_bt) . '<br />' . number_format($veh_pbm) . '</b></td>';
        $tbl.= '<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($veh_vat) . '<br />' . number_format($veh_vat_yad) . '</b></td>';
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
}

$tbl.= '<tr><td><br /><br /></td></tr>';
$tbl.= '<tfoot>';
$tbl.= '<tr>
            <td  colspan="6"></td>
            <td class="border-foot" valign="top" colspan="2" align="right" style="border-left:2px solid black;"><b style="font-size:1.1em;">GRAND TOTAL :</b></td>
            <td class="border-foot" valign="top" align="right" style="';
if ($l_sal_price !== '1') {
    $tbl.='border-right:2px solid black;';
}
$tbl .='"><b>' . number_format($sumQty) . '</b></td>';

if ($l_sal_price == '1') {
    $tbl.= '<td class="border-foot" valign="top" align="right"><b>' . number_format($tveh_price) . '<br />' . number_format($tveh_bbn) . '</b></td>';
    $tbl.= '<td class="border-foot" valign="top" align="right"><b>' . number_format($tveh_disc) . '<br />' . number_format($tveh_misc) . '</b></td>';
    $tbl.= '<td class="border-foot" valign="top" align="right"><b>' . number_format($tveh_at) . '<br />' . number_format($tveh_total) . '</b></td>';
    $tbl.= '<td class="border-foot" valign="top" align="right"><b>' . number_format($tveh_bt) . '<br />' . number_format($tveh_pbm) . '</b></td>';
    $tbl.= '<td class="border-foot" style="border-right:2px solid black;" valign="top" align="right"><b>' . number_format($sum_veh_vat) . '<br />' . number_format($sum_veh_vat_yad) . '</b></td>';
}

$tbl.='</tr>';
$tbl.='</tfoot>';

$tbl .='</table>';
?>