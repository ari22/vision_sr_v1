<?php

$tbl .= '
<div id="cntr1" align="center">
<table width="100%">
<tr><td align="center"><b style="font-size:1.5em;">' . $comp_name . '</b></td></tr>
<tr><td align="center"><b style="font-size:1.5em;">DEBIT NOTE REPORT</b></td></tr>
<tr><td align="center"><b>BY VEHICLE TYPE</b></td></tr>
<tr><td align="center"><b>' . $mounths[$mounth] . ' ' . $year . '</b></td></tr>
</table>
';

$tbl .= '
<table width="100%"  ><tr><td></td><td align="right"><b>Printed On: </b>' . date('d/m/Y') . '</td></tr></table>';

$tbl .= '
<table width="100%">
<thead style="border:2px solid black !important;">
<tr>
    <td valign="top" width="80"><b>Supplier<br />DO(SJ) Date</b></td>
    <td valign="top" width="90"><b>Supplier<br />DO(SJ) No.</b></td>
    <td valign="top" width="90"><b>Chassis</b></td>
    <td valign="top" width="90"><b>Color</b></td>
    <td valign="top" width="90"><b>Debit Note<br />No.</b></td>
    <td valign="top" width="80"><b>Supplier<br />Tax Date</b></td>
    <td valign="top" width="90"><b>Supplier<br />Tax No.</b></td>
    <td valign="top" width="90"><b>Optional<br />Tax No.</b></td>
    <td valign="top" align="right" width="80"><b>DPP</b></td>
    <td valign="top" align="right" width="80"><b>Current  Vat</b></td>
    <td valign="top" align="right" width="80"><b>Outstanding Vat</b></td>
    <td valign="top" align="right" width="80"><b>PBM</b></td>
    <td valign="top" align="right" width="80"><b>PPH22</b></td>
    <td valign="top" align="right" width="80"><b>Others</b></td>
    <td valign="top" align="right" width="100"><b>Purchase Price<br >(Debit Note)</b></td>
    <td valign="top" align="right" width="20"><b>Qty<br />(Unit)</b></td>
    <td valign="top" align="right" width="0"></td>
</tr>
</thead>';
$tbl .='<tr><td></td></tr>';

$i = 0;
$j = 0;
$last_veh_code = '';
$last_veh_name = '';

//bkn total
$pur_bt = 0;
$pur_pbm = 0;
$pur_pph = 0;
$pur_misc = 0;
$pur_price = 0;

$lnQty = 0;

$sl_pur_bt = 0;
$sl_pur_pbm = 0;
$sl_pur_pph = 0;
$sl_pur_misc = 0;
$sl_pur_price = 0;

$sl_lnQty = 0;

$mt_pur_bt = 0;
$mt_pur_pbm = 0;
$mt_pur_pph = 0;
$mt_pur_misc = 0;
$mt_pur_price = 0;

$mt_lnQty = 0;

//total
$tpur_bt = 0;
$tpur_pbm = 0;
$tpur_pph = 0;
$tpur_misc = 0;
$tpur_price = 0;

$tlnQty = 0;

$tsl_pur_bt = 0;
$tsl_pur_pbm = 0;
$tsl_pur_pph = 0;
$tsl_pur_misc = 0;
$tsl_pur_price = 0;

$tsl_lnQty = 0;

$tmt_pur_bt = 0;
$tmt_pur_pbm = 0;
$tmt_pur_pph = 0;
$tmt_pur_misc = 0;
$tmt_pur_price = 0;

$tmt_lnQty = 0;

//taxes
$veh_vat = 0;
$grp_veh_vat = 0;
$sl_veh_vat = 0;
$mt_veh_vat = 0;
$sum_sl_veh_vat = 0;
$sum_mt_veh_vat = 0;
$sum_veh_vat = 0;

$veh_vat_yad = 0;
$grp_veh_vat_yad = 0;
$sl_veh_vat_yad = 0;
$mt_veh_vat_yad = 0;
$sum_sl_veh_vat_yad = 0;
$sum_mt_veh_vat_yad = 0;
$sum_veh_vat_yad = 0;

$mt = 0;
$sl = 0;
$tmt = 0;
$tsl = 0;

while ($dtlrow = mysql_fetch_array($dtl)) {

    $tlnQty++;

    $tpur_bt += $dtlrow['pur_bt'];
    $tpur_pbm += $dtlrow['pur_pbm'];
    $tpur_pph += $dtlrow['pur_pph'];
    $tpur_misc += $dtlrow['pur_misc'];
    $tpur_price += $dtlrow['pur_price'];


    if ($last_veh_name != $dtlrow['veh_name']) {
        if ($i >= 1) {
            $tbl .= '<tr>';
            $tbl .= '<td valign="top" colspan="8" align="right"><b>TOTAL ' . $last_veh_code . ' : ' . $last_veh_name . ':</b></td>';
            $tbl .= '<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($pur_bt) . '</b></td>';
            $tbl .= '<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($veh_vat) . '</b></td>';
            $tbl .= '<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($veh_vat_yad) . '</b></td>';
            $tbl .= '<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($pur_pbm) . '</b></td>';
            $tbl .= '<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($pur_pph) . '</b></td>';
            $tbl .= '<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($pur_misc) . '</b></td>';
            $tbl .= '<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($pur_price) . '</b></td>';
            $tbl .= '<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($lnQty) . '</b></td>';
            $tbl .= '<td valign="top" align="right"></td>';
            $tbl .= '</tr>';

            $tbl .= '<tr>';
            $tbl .= '<td valign="top" colspan="8" align="right"><b>METALLIC : </b></td>';
            $tbl .= '<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($mt_pur_bt) . '</b></td>';
            $tbl .= '<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($mt_veh_vat) . '</b></td>';
            $tbl .= '<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($mt_veh_vat_yad) . '</b></td>';
            $tbl .= '<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($mt_pur_pbm) . '</b></td>';
            $tbl .= '<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($mt_pur_pph) . '</b></td>';
            $tbl .= '<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($mt_pur_misc) . '</b></td>';
            $tbl .= '<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($mt_pur_price) . '</b></td>';
            $tbl .= '<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($mt) . '</b></td>';
            $tbl .= '<td valign="top" align="right"></td>';
            $tbl .= '</tr>';
            
            $tbl .= '<tr>';
            $tbl .= '<td valign="top" colspan="8" align="right"><b>SOLID : </b></td>';
            $tbl .= '<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($sl_pur_bt) . '</b></td>';
            $tbl .= '<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($sl_veh_vat) . '</b></td>';
            $tbl .= '<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($sl_veh_vat_yad) . '</b></td>';
            $tbl .= '<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($sl_pur_pbm) . '</b></td>';
            $tbl .= '<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($sl_pur_pph) . '</b></td>';
            $tbl .= '<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($sl_pur_misc) . '</b></td>';
            $tbl .= '<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($sl_pur_price) . '</b></td>';
            $tbl .= '<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($sl) . '</b></td>';
            $tbl .= '<td valign="top" align="right"></td>';
            $tbl .= '</tr>';

            $i = 0;
            $pur_bt = 0;
            $veh_vat = 0;
            $veh_vat_yad = 0;
            $pur_pbm = 0;
            $pur_pph = 0;
            $pur_misc = 0;
            $pur_price = 0;
            $lnQty = 0;
            
            $mt = 0;
            $mt_pur_bt = 0;
            $mt_veh_vat = 0;
            $mt_veh_vat_yad = 0;
            $mt_pur_pbm = 0;
            $mt_pur_pph = 0;
            $mt_pur_misc = 0;
            $mt_pur_price = 0;
            $mt_lnQty = 0;
            
            $sl = 0;
            $sl_pur_bt = 0;
            $sl_veh_vat = 0;
            $sl_veh_vat_yad = 0;
            $sl_pur_pbm = 0;
            $sl_pur_pph = 0;
            $sl_pur_misc = 0;
            $sl_pur_price = 0;
            $sl_lnQty = 0;
        }

        $tbl.= '<tr><td colspan="16" align="left"><b style="font-size:1.1em;">*** ' . $dtlrow['veh_code'] . ' : ' . $dtlrow['veh_name'] . ' ***</b></td></tr>';
        $last_veh_name = $dtlrow['veh_name'];
        $last_veh_code = $dtlrow['veh_code'];
    }

    if (!empty($dtlrow['fp_no'])) {
        $veh_vat = $veh_vat + $dtlrow['pur_vat'];
        $grp_veh_vat = $grp_veh_vat + $dtlrow['pur_vat'];
        $sum_veh_vat = $sum_veh_vat + $dtlrow['pur_vat'];
    } else {
        $veh_vat_yad = $veh_vat_yad + $dtlrow['pur_vat'];
        $grp_veh_vat_yad = $grp_veh_vat_yad + $dtlrow['pur_vat'];
        $sum_veh_vat_yad = $sum_veh_vat_yad + $dtlrow['pur_vat'];
    }

    $pur_bt += $dtlrow['pur_bt'];
    $pur_pbm += $dtlrow['pur_pbm'];
    $pur_pph += $dtlrow['pur_pph'];
    $pur_misc += $dtlrow['pur_misc'];
    $pur_price += $dtlrow['pur_price'];
    
    $lnQty++;

    if ($dtlrow['color_type'] == 'MT') {
        $mt++;
        $tmt++;

        $mt_pur_bt += $dtlrow['pur_bt'];
        $mt_pur_pbm += $dtlrow['pur_pbm'];
        $mt_pur_pph += $dtlrow['pur_pph'];
        $mt_pur_misc += $dtlrow['pur_misc'];
        $mt_pur_price += $dtlrow['pur_price'];

        $tmt_pur_bt += $dtlrow['pur_bt'];
        $tmt_pur_pbm += $dtlrow['pur_pbm'];
        $tmt_pur_pph += $dtlrow['pur_pph'];
        $tmt_pur_misc += $dtlrow['pur_misc'];
        $tmt_pur_price += $dtlrow['pur_price'];
        
        if (!empty($dtlrow['fp_no'])) {
            $mt_veh_vat = $mt_veh_vat + $dtlrow['pur_vat'];
            $sum_mt_veh_vat = $sum_mt_veh_vat + $dtlrow['pur_vat'];
        } else {
            $mt_veh_vat_yad = $mt_veh_vat_yad + $dtlrow['pur_vat'];
            $sum_mt_veh_vat_yad = $sum_mt_veh_vat_yad + $dtlrow['pur_vat'];
        }
    }
    if ($dtlrow['color_type'] == 'SL') {
        $sl++;
        $tsl++;
    
        $sl_pur_bt += $dtlrow['pur_bt'];
        $sl_pur_pbm += $dtlrow['pur_pbm'];
        $sl_pur_pph += $dtlrow['pur_pph'];
        $sl_pur_misc += $dtlrow['pur_misc'];
        $sl_pur_price += $dtlrow['pur_price'];
    
        $tsl_pur_bt += $dtlrow['pur_bt'];
        $tsl_pur_pbm += $dtlrow['pur_pbm'];
        $tsl_pur_pph += $dtlrow['pur_pph'];
        $tsl_pur_misc += $dtlrow['pur_misc'];
        $tsl_pur_price += $dtlrow['pur_price'];
        
        if (!empty($dtlrow['fp_no'])) {
            $sl_veh_vat = $sl_veh_vat + $dtlrow['pur_vat'];
            $sum_sl_veh_vat = $sum_sl_veh_vat + $dtlrow['pur_vat'];
        } else {
            $sl_veh_vat_yad = $sl_veh_vat_yad + $dtlrow['pur_vat'];
            $sum_sl_veh_vat_yad = $sum_sl_veh_vat_yad + $dtlrow['pur_vat'];
        }
    }


    $sji_date = dateView($dtlrow['sji_date']);
    $fpi_date = dateView($dtlrow['fpi_date']);

    $tbl .= '<tr>';
    $tbl .= '<td valign="top" >' . $sji_date . '</td>';
    $tbl .= '<td valign="top" >' . $dtlrow['sji_no'] . '</td>';
    $tbl .= '<td valign="top" >' . $dtlrow['chassis'] . '</td>';
    $tbl .= '<td valign="top" >' . $dtlrow['color_name'] . '</td>';
    $tbl .= '<td valign="top" >' . $dtlrow['dni_no'] . '</td>';
    $tbl .= '<td valign="top" >' . $fpi_date . '</td>';
    $tbl .= '<td valign="top" >' . $dtlrow['fpi_no'] . '</td>';
    $tbl .= '<td valign="top" ></td>';

    $tbl .= '<td valign="top" align="right">' . number_format($dtlrow['pur_bt']) . '</td>';

    $tbl .= '<td valign="top"   align="right">';
    if (!empty($dtlrow['fp_no'])) {
        $tbl.= number_format($dtlrow['pur_vat']);
    }else{
        $tbl.= '0';
    }
    
    $tbl.= '</td><td valign="top"   align="right">';
    if (empty($dtlrow['fp_no'])) {
        $tbl.= number_format($dtlrow['pur_vat']);
    }else{
        $tbl.= '0';
    }

    $tbl.= '</td>';

    $tbl .= '<td valign="top" align="right">' . number_format($dtlrow['pur_pbm']) . '</td>';
    $tbl .= '<td valign="top" align="right">' . number_format($dtlrow['pur_pph']) . '</td>';
    $tbl .= '<td valign="top" align="right">' . number_format($dtlrow['pur_misc']) . '</td>';
    $tbl .= '<td valign="top" align="right">' . number_format($dtlrow['pur_price']) . '</td>';
    $tbl .= '<td valign="top" align="right">1</td>';
    $tbl .= '</tr>';

    $i++;
    $j++;
    unset($dtlrow);
}


if ($i >= 1) {
    $tbl .= '<tr>';
    $tbl .= '<td valign="top" colspan="8" align="right"><b>TOTAL ' . $last_veh_code . ' : ' . $last_veh_name . ':</b></td>';
    $tbl .= '<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($pur_bt) . '</b></td>';
    $tbl .= '<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($veh_vat) . '</b></td>';
    $tbl .= '<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($veh_vat_yad) . '</b></td>';
    $tbl .= '<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($pur_pbm) . '</b></td>';
    $tbl .= '<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($pur_pph) . '</b></td>';
    $tbl .= '<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($pur_misc) . '</b></td>';
    $tbl .= '<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($pur_price) . '</b></td>';
    $tbl .= '<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($lnQty) . '</b></td>';
    $tbl .= '</tr>';
    
    $tbl .= '<tr>';
    $tbl .= '<td valign="top" colspan="8" align="right"><b>METALLIC : </b></td>';
    $tbl .= '<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($mt_pur_bt) . '</b></td>';
    $tbl .= '<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($mt_veh_vat) . '</b></td>';
    $tbl .= '<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($mt_veh_vat_yad) . '</b></td>';
    $tbl .= '<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($mt_pur_pbm) . '</b></td>';
    $tbl .= '<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($mt_pur_pph) . '</b></td>';
    $tbl .= '<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($mt_pur_misc) . '</b></td>';
    $tbl .= '<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($mt_pur_price) . '</b></td>';
            $tbl .= '<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($mt) . '</b></td>';
            $tbl .= '<td valign="top" align="right"></td>';
    $tbl .= '</tr>';
    
    $tbl .= '<tr>';
    $tbl .= '<td valign="top" colspan="8" align="right"><b>SOLID : </b></td>';
    $tbl .= '<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($sl_pur_bt) . '</b></td>';
    $tbl .= '<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($sl_veh_vat) . '</b></td>';
    $tbl .= '<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($sl_veh_vat_yad) . '</b></td>';
    $tbl .= '<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($sl_pur_pbm) . '</b></td>';
    $tbl .= '<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($sl_pur_pph) . '</b></td>';
    $tbl .= '<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($sl_pur_misc) . '</b></td>';
    $tbl .= '<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($sl_pur_price) . '</b></td>';
            $tbl .= '<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($sl) . '</b></td>';
            $tbl .= '<td valign="top" align="right"></td>';
    $tbl .= '</tr>';

    $i = 0;
    $pur_bt = 0;
    $veh_vat = 0;
    $veh_vat_yad = 0;
    $pur_pbm = 0;
    $pur_pph = 0;
    $pur_misc = 0;
    $pur_price = 0;
    $lnQty = 0;
    
    $mt = 0;
    $mt_mt_pur_bt = 0;
    $mt_veh_vat = 0;
    $mt_veh_vat_yad = 0;
    $mt_pur_pbm = 0;
    $mt_pur_pph = 0;
    $mt_pur_misc = 0;
    $mt_pur_price = 0;
    $mt_lnQty = 0;
    
    $sl = 0;
    $sl_pur_bt = 0;
    $sl_veh_vat = 0;
    $sl_veh_vat_yad = 0;
    $sl_pur_pbm = 0;
    $sl_pur_pph = 0;
    $sl_pur_misc = 0;
    $sl_pur_price = 0;
    $sl_lnQty = 0;
}

$tbl .= '<tr><td><br /></td></tr>';
$tbl .= '<tfoot>';
$tbl .= '<tr>';
$tbl .= '<td colspan="5"></td>';
$tbl .= '<td style="border-top:2px solid black;border-left:2px solid black;" valign="top" colspan="3" align="right"><b>TOTAL DEBIT NOTE SUPPLIER :</b></td>';
$tbl .= '<td valign="top" align="right" style="border-top:2px solid black;"><b>' . number_format($tpur_bt) . '</b></td>';
$tbl .= '<td valign="top" align="right" style="border-top:2px solid black;"><b>' . number_format($sum_veh_vat) . '</b></td>';
$tbl .= '<td valign="top" align="right" style="border-top:2px solid black;"><b>' . number_format($sum_veh_vat_yad) . '</b></td>';
$tbl .= '<td valign="top" align="right" style="border-top:2px solid black;"><b>' . number_format($tpur_pbm) . '</b></td>';
$tbl .= '<td valign="top" align="right" style="border-top:2px solid black;"><b>' . number_format($tpur_pph) . '</b></td>';
$tbl .= '<td valign="top" align="right" style="border-top:2px solid black;"><b>' . number_format($tpur_misc) . '</b></td>';
$tbl .= '<td valign="top" align="right" style="border-top:2px solid black;"><b>' . number_format($tpur_price) . '</b></td>';
$tbl .= '<td valign="top" align="right" style="border-top:2px solid black;"><b>' . number_format($tlnQty) . '</b></td>';
            $tbl .= '<td valign="top" align="right" style="border-right:2px solid black; border-top:2px solid black;"></td>';
$tbl .= '</tr>';

$tbl .= '<tr>';
$tbl .= '<td colspan="5"></td>';
$tbl .= '<td style="border-left:2px solid black;" valign="top" colspan="3" align="right"><b>TOTAL METALLIC : </b></td>';
$tbl .= '<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($tmt_pur_bt) . '</b></td>';
$tbl .= '<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($sum_mt_veh_vat) . '</b></td>';
$tbl .= '<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($sum_mt_veh_vat_yad) . '</b></td>';
$tbl .= '<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($tmt_pur_pbm) . '</b></td>';
$tbl .= '<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($tmt_pur_pph) . '</b></td>';
$tbl .= '<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($tmt_pur_misc) . '</b></td>';
$tbl .= '<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($tmt_pur_price) . '</b></td>';
$tbl .= '<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($tmt) . '</b></td>';
$tbl .= '<td valign="top" align="right" style="border-right:2px solid black;"></td>';
$tbl .= '</tr>';

$tbl .= '<tr>';
$tbl .= '<td colspan="5"></td>';
$tbl .= '<td style="border-left:2px solid black;border-bottom:2px solid black;" valign="top" colspan="3" align="right"><b>TOTAL SOLID : </b></td>';
$tbl .= '<td valign="top" align="right" style="border-top:1px solid black; border-bottom:2px solid black;"><b>' . number_format($tsl_pur_bt) . '</b></td>';
$tbl .= '<td valign="top" align="right" style="border-top:1px solid black; border-bottom:2px solid black;"><b>' . number_format($sum_sl_veh_vat) . '</b></td>';
$tbl .= '<td valign="top" align="right" style="border-top:1px solid black; border-bottom:2px solid black;"><b>' . number_format($sum_sl_veh_vat_yad) . '</b></td>';
$tbl .= '<td valign="top" align="right" style="border-top:1px solid black; border-bottom:2px solid black;"><b>' . number_format($tsl_pur_pbm) . '</b></td>';
$tbl .= '<td valign="top" align="right" style="border-top:1px solid black; border-bottom:2px solid black;"><b>' . number_format($tsl_pur_pph) . '</b></td>';
$tbl .= '<td valign="top" align="right" style="border-top:1px solid black; border-bottom:2px solid black;"><b>' . number_format($tsl_pur_misc) . '</b></td>';
$tbl .= '<td valign="top" align="right" style="border-top:1px solid black; border-bottom:2px solid black;"><b>' . number_format($tsl_pur_price) . '</b></td>';
$tbl .= '<td valign="top" align="right" style="border-bottom:2px solid black;border-top:1px solid black;"><b>' . number_format($tsl) . '</b></td>';
$tbl .= '<td valign="top" align="right" style="border-right:2px solid black; border-bottom:2px solid black;"></td>';
$tbl .= '</tr>';

$tbl .= '</tfoot>';
$tbl .='</table>';
