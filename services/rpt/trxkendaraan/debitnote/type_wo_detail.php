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
    <td valign="top" align="right" width="80"><b>PPN Mounth</b></td>
    <td valign="top" align="right" width="80"><b>PPN YAD</b></td>
    <td valign="top" align="right" width="80"><b>PBM</b></td>
    <td valign="top" align="right" width="80"><b>PPH22</b></td>
    <td valign="top" align="right" width="80"><b>Etc.</b></td>
    <td valign="top" align="right" width="80"><b>Purchase Price<br >(Debit Note)</b></td>
    <td valign="top" align="right"><b>Qty<br />(Unit)</b></td>
</tr>
</thead>';
$tbl .='<tr><td></td></tr>';

$i = 0;
$j = 0;
$last_veh_code = '';
$last_veh_name = '';

$pur_bt = 0;
$pur_pbm = 0;
$pur_pph = 0;
$pur_misc = 0;
$pur_price = 0;

$lnQty = 0;

$tpur_bt = 0;
$tpur_pbm = 0;
$tpur_pph = 0;
$tpur_misc = 0;
$tpur_price = 0;

$tlnQty = 0;

$veh_vat = 0;
$grp_veh_vat = 0;
$sum_veh_vat = 0;
$veh_vat_yad = 0;
$grp_veh_vat_yad = 0;
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
            $tbl .= '<td valign="top" colspan="8" align="right"><b>TOTAL TYPE ' . $last_veh_code . ':</b></td>';
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
            $tbl .= '<td valign="top" colspan="8" align="right"><b>METALLIC: &nbsp;&nbsp;&nbsp;&nbsp;' . number_format($mt) . ' Unit</b></td>';
            $tbl .= '</tr>';
            $tbl .= '<tr>';
            $tbl .= '<td valign="top" colspan="8" align="right"><b>SOLID: &nbsp;&nbsp;&nbsp;&nbsp;' . number_format($sl) . ' Unit</b></td>';
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
            $sl = 0;
        }

        $tbl.= '<tr><td colspan="16" align="left"><b style="font-size:1.1em;">*** ' . $dtlrow['veh_code'] . ' - ' . $dtlrow['veh_name'] . ' ***</b></td></tr>';
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
    }
    if ($dtlrow['color_type'] == 'SL') {
        $sl++;
        $tsl++;
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
    $tbl .= '<td valign="top" colspan="8" align="right"><b>TOTAL TYPE ' . $last_veh_code . ':</b></td>';
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
    $tbl .= '<td valign="top" colspan="8" align="right"><b>METALLIC: &nbsp;&nbsp;&nbsp;&nbsp;' . number_format($mt) . ' Unit</b></td>';
    $tbl .= '</tr>';
    $tbl .= '<tr>';
    $tbl .= '<td valign="top" colspan="8" align="right"><b>SOLID: &nbsp;&nbsp;&nbsp;&nbsp;' . number_format($sl) . ' Unit</b></td>';
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
    $sl = 0;
}

$tbl .= '<tr><td><br /></td></tr>';
$tbl .= '<tfoot>';
$tbl .= '<tr>';
$tbl .= '<td colspan="6"></td>';
$tbl .= '<td style="border-top:2px solid black;border-left:2px solid black;" valign="top" colspan="2" align="right"><b>TOTAL DEBIT NOTE SUPPLIER :</b></td>';
$tbl .= '<td valign="top" align="right" style="border-top:2px solid black;"><b>' . number_format($tpur_bt) . '</b></td>';
$tbl .= '<td valign="top" align="right" style="border-top:2px solid black;"><b>' . number_format($sum_veh_vat) . '</b></td>';
$tbl .= '<td valign="top" align="right" style="border-top:2px solid black;"><b>' . number_format($sum_veh_vat_yad) . '</b></td>';
$tbl .= '<td valign="top" align="right" style="border-top:2px solid black;"><b>' . number_format($tpur_pbm) . '</b></td>';
$tbl .= '<td valign="top" align="right" style="border-top:2px solid black;"><b>' . number_format($tpur_pph) . '</b></td>';
$tbl .= '<td valign="top" align="right" style="border-top:2px solid black;"><b>' . number_format($tpur_misc) . '</b></td>';
$tbl .= '<td valign="top" align="right" style="border-top:2px solid black;"><b>' . number_format($tpur_price) . '</b></td>';
$tbl .= '<td valign="top" align="right" style="border-right:2px solid black;border-top:2px solid black;"><b>' . number_format($tlnQty) . '</b></td>';
$tbl .= '</tr>';

$tbl .= '<tr>';
$tbl .= '<td colspan="6"></td>';
$tbl .= '<td style="border-left:2px solid black;" valign="top" colspan="2" align="right"><b>METALLIC: &nbsp;&nbsp;&nbsp;&nbsp;' . number_format($tmt) . ' Unit</b></td>';
$tbl .= '<td colspan="8" style="border-right:2px solid black;"></td>';
$tbl .= '</tr>';
$tbl .= '<tr>';
$tbl .= '<td colspan="6"></td>';
$tbl .= '<td style="border-left:2px solid black;border-bottom:2px solid black;" valign="top" colspan="2" align="right"><b>SOLID: &nbsp;&nbsp;&nbsp;&nbsp;' . number_format($tsl) . ' Unit</b></td>';
$tbl .= '<td colspan="8" style="border-bottom:2px solid black;border-right:2px solid black;"></td>';
$tbl .= '</tr>';

$tbl .= '</tfoot>';
$tbl .='</table>';
