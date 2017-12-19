<?php

error_reporting(E_ALL ^ E_NOTICE);
//error_reporting(0);
$bulan = array(
    '',
    'JANUARY',
    'FEBRUARY',
    'MARCH',
    'APRIL',
    'MAY',
    'JUNE',
    'JULY',
    'AUGUST',
    'SEPTEMBER',
    'OCTOBER',
    'NOVEMBER',
    'DECEMBER'
);
$tbl .= '
<div id="cntr1" align="center">
<table width="70%">
<tr><td valign="top" align="center"><b style="font-size:1.5em;">' . $comp_name . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.5em;">' . $rptTitle . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.1em;">Group By ' . $title . '</b></td></tr>';
if($filterdesc !== ''){
    $tbl .= '    <tr><td valign="top" align="center"><span style="font-size:1.1em;">Filter By ' . $filterdesc . '</span></td></tr>';
}
$tbl .='<tr><td valign="top" align="center"><b>' . $bulan[$mounth] . '  ' . $year . ' </b></td></tr>
</table>
';
$tbl .= '
    <table width="100%"  >
    <tr>
    <td valign="top"></td>
    <td valign="top" align="right"><b>Printed On: </b>' . date('d/m/Y') . '</td>
    </tr>
    </table>';

$tbl .= '
<table width="100%" >
<thead style="border:2px solid black !important;">
<tr>
<td valign="top"><b>Stock Date</b></td>
<td valign="top"><b>Chassis</b></td>
<td valign="top"><b>Engine</b></td>
<td valign="top"><b>Supplier</b></td>
<td valign="top"><b>Year</b></td>
<td valign="top" align="right" width="50px"><b>Begin Qty</b></td>
<td valign="top" align="right" width="50px"><b>Purc. Qty</b></td>
<td valign="top" align="right" width="50px"><b>Purc. Ret. Qty</b></td>
<td valign="top" align="right" width="50px"><b>Pick Qty</b></td>
<td valign="top" align="right" width="50px"><b>Sale Qty</b></td>
<td valign="top" align="right" width="50px"><b>Sale Ret. Qty</b></td>
<td valign="top" align="right" width="50px"><b>Opname<br />Qty</b></td>
<td valign="top" align="right" width="50px"><b>End Qty</b></td>
<td valign="top" width="20px"></td>
<td valign="top" align="right" width="90px"><b>Begin<br />HPP</b></td>
<td valign="top" align="right" width="90px"><b>Pur<br />HPP</b></td>
<td valign="top" align="right" width="90px"><b>Pick<br />HPP</b></td>
<td valign="top" align="right" width="90px"><b>Sal <br />HPP</b></td>
<td valign="top" align="right" width="90px"><b>Sale Ret.<br />HPP</b></td>
<td valign="top" align="right" width="90px"><b>End<br />HPP</b></td>
</tr>
</thead>';

$tbl .= '
<tr>
	<td valign="top" colspan="20"></td>
</tr>
';

$i = 0;
$j = 0;
$last_veh_code = '';
$last_veh_name = '';
$last_wrhs_name = '';
$last_wrhs_code = '';

$sum_beg_qty = 0;
$sum_pur_qty = 0;
$sum_rpur_qty = 0;
$sum_pick_qty = 0;
$sum_sal_qty = 0;
$sum_rsal_qty = 0;
$sum_opn_qty = 0;
$sum_end_qty = 0;

$sum_shpp_awal = 0;
$sum_shpp_beli = 0;
$sum_shpp_pick = 0;
$sum_shpp_jual = 0;
$sum_shpp_retJual = 0;
$sum_shpp_akhir = 0;


$beg_qty = 0;
$pur_qty = 0;
$rpur_qty = 0;
$pick_qty = 0;
$sal_qty = 0;
$rsal_qty = 0;
$opn_qty = 0;
$end_qty = 0;

$shpp_awal = 0;
$shpp_beli = 0;
$shpp_pick = 0;
$shpp_jual = 0;
$shpp_retJual = 0;
$shpp_akhir = 0;


$t_beg_qty = 0;
$t_pur_qty = 0;
$t_rpur_qty = 0;
$t_pick_qty = 0;
$t_sal_qty = 0;
$t_rsal_qty = 0;
$t_opn_qty = 0;
$t_end_qty = 0;

$t_hpp_awal = 0;
$t_hpp_beli = 0;
$t_hpp_pick = 0;
$t_hpp_jual = 0;
$t_hpp_retJual = 0;
$t_hpp_akhir = 0;


if ($strlen == 1) {
    $mounth = '0' . $mounth;
}

$dat = strtotime($year . '-' . $mounth . '-31');

while ($dtlrow = mysql_fetch_array($dtl)) {
    if ($dbs == $db1) {

        $saldate = strtotime($dtlrow['sal_date']);
        $purdate = strtotime($dtlrow['pur_date']);
        $rprdate = strtotime($dtlrow['rpr_date']);
        $pickdate = strtotime($dtlrow['pick_date']);
        $rsldate = strtotime($dtlrow['rsl_date']);


        if ($saldate > $dat || $saldate == '') {
            $dtlrow['sal_qty'] = 0;
        }
        if ($purdate > $dat || $purdate == '') {
            $dtlrow['pur_qty'] = 0;
        }
        if ($rprdate > $dat || $rprdate == '') {
            $dtlrow['rpur_qty'] = 0;
        }
        if ($pickdate > $dat || $pickdate == '') {
            $dtlrow['pick_qty'] = 0;
        }
        if ($rsldate > $dat || $rsldate == '') {
            $dtlrow['rsl_date'] = 0;
        }

        $dtlrow['end_qty'] = $dtlrow['beg_qty'] + $dtlrow['pur_qty'] - $dtlrow['rpur_qty'] - $dtlrow['pick_qty'] - $dtlrow['sal_qty'] + $dtlrow['rsal_qty'] + $dtlrow['opn_qty'];
    }

    $hpp_awal = 0;
    $hpp_beli = 0;
    $hpp_pick = 0;
    $hpp_jual = 0;
    $hpp_retJual = 0;
    $hpp_akhir = 0;
    
    if ($dtlrow['beg_qty'] == 1) {
        $hpp_awal = $dtlrow['pur_bt'];
    }
    if ($dtlrow['pur_qty'] == 1) {
        $hpp_beli = $dtlrow['pur_bt'];
    }
    if ($dtlrow['pick_qty'] == 1) {
        $hpp_pick = $dtlrow['pur_bt'];
    }
    
    if ($dtlrow['sal_qty'] == 1) {
        $hpp_jual = $dtlrow['pur_bt'];
    }
    if ($dtlrow['rsal_qty'] == 1) {
        $hpp_retJual = $dtlrow['pur_bt'];
    }
    if ($dtlrow['end_qty'] == 1) {
        $hpp_akhir = $dtlrow['pur_bt'];
    }
    

    if ($last_wrhs_code != $dtlrow['wrhs_code']) {

        if ($j >= 1) {
            $tbl.= '
			<tr>
				<td valign="top" colspan="5" align="right"><b>TOTAL ' . $last_veh_code . ' : ' . $last_veh_name . ':</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;" width="50px">' . number_format($beg_qty) . '</td>
                                <td valign="top" align="right" style="border-top:1px solid black;" width="50px">' . number_format($pur_qty) . '</td>
                                <td valign="top" align="right" style="border-top:1px solid black;" width="50px">' . number_format($rpur_qty) . '</td>
                                <td valign="top" align="right" style="border-top:1px solid black;" width="50px">' . number_format($pick_qty) . '</td>
                                <td valign="top" align="right" style="border-top:1px solid black;" width="50px">' . number_format($sal_qty) . '</td>
                                <td valign="top" align="right" style="border-top:1px solid black;" width="50px">' . number_format($rsal_qty) . '</td>
                                <td valign="top" align="right" style="border-top:1px solid black;" width="50px">' . number_format($opn_qty) . '</td>
                                <td valign="top" align="right" style="border-top:1px solid black;" width="50px">' . number_format($end_qty) . '</td>
                                <td valign="top" width="20px"></td>
                                <td valign="top" align="right" style="border-top:1px solid black;" width="90px">' . number_format($shpp_awal) . '</td>
                                <td valign="top" align="right" style="border-top:1px solid black;" width="90px">' . number_format($shpp_beli) . '</td>
                                <td valign="top" align="right" style="border-top:1px solid black;" width="90px">' . number_format($shpp_pick) . '</td>
                                <td valign="top" align="right" style="border-top:1px solid black;" width="90px">' . number_format($shpp_jual) . '</td>
                                <td valign="top" align="right" style="border-top:1px solid black;" width="90px">' . number_format($shpp_retJual) . '</td>
                                <td valign="top" align="right" style="border-top:1px solid black;" width="90px">' . number_format($shpp_akhir) . '</td>
			</tr>';
            $j = 0;
            $beg_qty = 0;
            $pur_qty = 0;
            $rpur_qty = 0;
            $pick_qty = 0;
            $sal_qty = 0;
            $rsal_qty = 0;
            $opn_qty = 0;
            $end_qty = 0;

            $shpp_awal = 0;
            $shpp_beli = 0;
            $shpp_pick = 0;
            $shpp_jual = 0;
            $shpp_retJual = 0;
            $shpp_akhir = 0;
        }
        if ($i >= 1) {
            $tbl.= '
			<tr>
                            <td valign="top" colspan="5" align="right"><b style="font-size:1.1em;">TOTAL  ' . $last_wrhs_code . ':</b></td>
                            <td valign="top" align="right" style="border-top:1px solid black;" width="50px"><b>' . number_format($t_beg_qty) . '</b></td>
                            <td valign="top" align="right" style="border-top:1px solid black;" width="50px"><b>' . number_format($t_pur_qty) . '</b></td>
                            <td valign="top" align="right" style="border-top:1px solid black;" width="50px"><b>' . number_format($t_rpur_qty) . '</b></td>
                            <td valign="top" align="right" style="border-top:1px solid black;" width="50px"><b>' . number_format($t_pick_qty) . '</b></td>
                            <td valign="top" align="right" style="border-top:1px solid black;" width="50px"><b>' . number_format($t_sal_qty) . '</b></td>
                            <td valign="top" align="right" style="border-top:1px solid black;" width="50px"><b>' . number_format($t_rsal_qty) . '</b></td>
                            <td valign="top" align="right" style="border-top:1px solid black;" width="50px"><b>' . number_format($t_opn_qty) . '</b></td>
                            <td valign="top" align="right" style="border-top:1px solid black;" width="50px"><b>' . number_format($t_end_qty) . '</b></td>
                             <td valign="top" width="20px"></td>
                            <td valign="top" align="right" style="border-top:1px solid black;" width="90px"><b>' . number_format($t_hpp_awal) . '</b></td>
                            <td valign="top" align="right" style="border-top:1px solid black;" width="90px"><b>' . number_format($t_hpp_beli) . '</b></td>
                            <td valign="top" align="right" style="border-top:1px solid black;" width="90px"><b>' . number_format($t_hpp_pick) . '</b></td>
                            <td valign="top" align="right" style="border-top:1px solid black;" width="90px"><b>' . number_format($t_hpp_jual) . '</b></td>
                            <td valign="top" align="right" style="border-top:1px solid black;" width="90px"><b>' . number_format($t_hpp_retJual) . '</b></td>
                            <td valign="top" align="right" style="border-top:1px solid black;" width="90px"><b>' . number_format($t_hpp_akhir) . '</b></td>
			</tr>';
            $i = 0;
            $t_beg_qty = 0;
            $t_pur_qty = 0;
            $t_rpur_qty = 0;
            $t_pick_qty = 0;
            $t_sal_qty = 0;
            $t_rsal_qty = 0;
            $t_opn_qty = 0;
            $t_end_qty = 0;

            $t_hpp_awal = 0;
            $t_hpp_beli = 0;
            $t_hpp_pick = 0;
            $t_hpp_jual = 0;
            $t_hpp_retJual = 0;
            $t_hpp_akhir = 0;
        }
        $tbl.='<tr><td valign="top"><br /></td></tr>';
        $tbl.= '<tr><td valign="top" colspan="20" align="left"><b style="font-size:1.1em;">*** WAREHOUSE : ' . $dtlrow['wrhs_code'] . ' : ' . $dtlrow['wrhs_name'] . ' ***</b></td></tr>';
        $last_wrhs_name = $dtlrow['wrhs_name'];
        $last_wrhs_code = $dtlrow['wrhs_code'];

        $tbl.= '<tr><td valign="top" colspan="20" align="left"><b style="font-size:1.1em;">' . $dtlrow['veh_code'] . ': ' . $dtlrow['veh_name'] . '</b></td></tr>';
        $last_veh_name = $dtlrow['veh_name'];
        $last_veh_code = $dtlrow['veh_code'];
    } elseif ($last_veh_code != $dtlrow['veh_code']) {

        if ($j >= 1) {
            $tbl.= '
			<tr>
				<td valign="top" colspan="5" align="right"><b>TOTAL ' . $last_veh_code . ' : ' . $last_veh_name . ':</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;" width="50px">' . number_format($beg_qty) . '</td>
                                <td valign="top" align="right" style="border-top:1px solid black;" width="50px">' . number_format($pur_qty) . '</td>
                                <td valign="top" align="right" style="border-top:1px solid black;" width="50px">' . number_format($rpur_qty) . '</td>
                                <td valign="top" align="right" style="border-top:1px solid black;" width="50px">' . number_format($pick_qty) . '</td>
                                <td valign="top" align="right" style="border-top:1px solid black;" width="50px">' . number_format($sal_qty) . '</td>
                                <td valign="top" align="right" style="border-top:1px solid black;" width="50px">' . number_format($rsal_qty) . '</td>
                                <td valign="top" align="right" style="border-top:1px solid black;" width="50px">' . number_format($opn_qty) . '</td>
                                <td valign="top" align="right" style="border-top:1px solid black;" width="50px">' . number_format($end_qty) . '</td>
                                <td valign="top" width="20px"></td>
                                <td valign="top" align="right" style="border-top:1px solid black;" width="90px">' . number_format($shpp_awal) . '</td>
                                <td valign="top" align="right" style="border-top:1px solid black;" width="90px">' . number_format($shpp_beli) . '</td>
                                <td valign="top" align="right" style="border-top:1px solid black;" width="90px">' . number_format($shpp_pick) . '</td>
                                <td valign="top" align="right" style="border-top:1px solid black;" width="90px">' . number_format($shpp_jual) . '</td>
                                <td valign="top" align="right" style="border-top:1px solid black;" width="90px">' . number_format($shpp_retJual) . '</td>
                                <td valign="top" align="right" style="border-top:1px solid black;" width="90px">' . number_format($shpp_akhir) . '</td>
			</tr>';
            $j = 0;
            $beg_qty = 0;
            $pur_qty = 0;
            $rpur_qty = 0;
            $pick_qty = 0;
            $sal_qty = 0;
            $rsal_qty = 0;
            $opn_qty = 0;
            $end_qty = 0;

            $shpp_awal = 0;
            $shpp_beli = 0;
            $shpp_pick = 0;
            $shpp_jual = 0;
            $shpp_retJual = 0;
            $shpp_akhir = 0;
        }
        $tbl.= '<tr><td valign="top" colspan="20" align="left"><b style="font-size:1.1em;">' . $dtlrow['veh_code'] . ': ' . $dtlrow['veh_name'] . '</b></td></tr>';
        $last_veh_name = $dtlrow['veh_name'];
        $last_veh_code = $dtlrow['veh_code'];
    }


    $sum_beg_qty += $dtlrow['beg_qty'];
    $sum_pur_qty += $dtlrow['pur_qty'];
    $sum_rpur_qty += $dtlrow['rpur_qty'];
    $sum_pick_qty += $dtlrow['pick_qty'];
    $sum_sal_qty += $dtlrow['sal_qty'];
    $sum_rsal_qty += $dtlrow['rsal_qty'];
    $sum_opn_qty += $dtlrow['opn_qty'];
    $sum_end_qty += $dtlrow['end_qty'];

    $sum_shpp_awal += $hpp_awal;
    $sum_shpp_beli += $hpp_beli;
    $sum_shpp_pick += $hpp_pick;
    $sum_shpp_jual += $hpp_jual;
    $sum_shpp_retJual += $hpp_retJual;
    $sum_shpp_akhir += $hpp_akhir;


    $beg_qty += $dtlrow['beg_qty'];
    $pur_qty += $dtlrow['pur_qty'];
    $rpur_qty += $dtlrow['rpur_qty'];
    $pick_qty += $dtlrow['pick_qty'];
    $sal_qty += $dtlrow['sal_qty'];
    $rsal_qty += $dtlrow['rsal_qty'];
    $opn_qty += $dtlrow['opn_qty'];
    $end_qty += $dtlrow['end_qty'];

    $shpp_awal += $hpp_awal;
    $shpp_beli += $hpp_beli;
    $shpp_pick += $hpp_pick;
    $shpp_jual += $hpp_jual;
    $shpp_retJual += $hpp_retJual;
    $shpp_akhir += $hpp_akhir;


    $t_beg_qty += $dtlrow['beg_qty'];
    $t_pur_qty += $dtlrow['pur_qty'];
    $t_rpur_qty += $dtlrow['rpur_qty'];
    $t_pick_qty += $dtlrow['pick_qty'];
    $t_sal_qty += $dtlrow['sal_qty'];
    $t_rsal_qty += $dtlrow['rsal_qty'];
    $t_opn_qty += $dtlrow['opn_qty'];
    $t_end_qty += $dtlrow['end_qty'];

    $t_hpp_awal += $hpp_awal;
    $t_hpp_beli += $hpp_beli;
    $t_hpp_pick += $hpp_pick;
    $t_hpp_jual += $hpp_jual;
    $t_hpp_retJual += $hpp_retJual;
    $t_hpp_akhir += $hpp_akhir;


    $stk_date = '';
    if ($dtlrow['stk_date'] != '0000-00-00 00:00:00') {
        $stk_date = date_create($dtlrow['stk_date']);
        $stk_date = date_format($stk_date, "d/m/Y");
    }


    $tbl .= '<tr>'
            . '<td valign="top">' . $stk_date . '</td>'
            . '<td valign="top">' . $dtlrow['chassis'] . '</td>'
            . '<td valign="top">' . $dtlrow['engine'] . '</td>'
            . '<td valign="top">' . $dtlrow['supp_code'] . '</td>'
            . '<td valign="top">' . $dtlrow['veh_year'] . '</td>'
            . '<td valign="top" align="right" width="50px">' . $dtlrow['beg_qty'] . '</td>'
            . '<td valign="top" align="right" width="50px">' . $dtlrow['pur_qty'] . '</td>'
            . '<td valign="top" align="right" width="50px">' . $dtlrow['rpur_qty'] . '</td>'
            . '<td valign="top" align="right" width="50px">' . $dtlrow['pick_qty'] . '</td>'
            . '<td valign="top" align="right" width="50px">' . $dtlrow['sal_qty'] . '</td>'
            . '<td valign="top" align="right" width="50px">' . $dtlrow['rsal_qty'] . '</td>'
            . '<td valign="top" align="right" width="50px">' . $dtlrow['opn_qty'] . '</td>'
            . '<td valign="top" align="right" width="50px">' . $dtlrow['end_qty'] . '</td>'
            . '<td valign="top" width="20px"></td>'
            . '<td valign="top" align="right" width="90px">' . number_format($hpp_awal) . '</td>'
            . '<td valign="top" align="right" width="90px">' . number_format($hpp_beli) . '</td>'
            . '<td valign="top" align="right" width="90px">' . number_format($hpp_pick) . '</td>'
            . '<td valign="top" align="right" width="90px">' . number_format($hpp_jual) . '</td>'
            . '<td valign="top" align="right" width="90px">' . number_format($hpp_retJual) . '</td>'
            . '<td valign="top" align="right" width="90px">' . number_format($hpp_akhir) . '</td>'
            . '</tr>';


    $i++;
    $j++;
    unset($dtlrow);
}

if ($j >= 1) {
    $tbl.= '
			<tr>
				<td valign="top" colspan="5" align="right"><b>TOTAL ' . $last_veh_code . ' : ' . $last_veh_name . ':</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;" width="50px">' . number_format($beg_qty) . '</td>
                                <td valign="top" align="right" style="border-top:1px solid black;" width="50px">' . number_format($pur_qty) . '</td>
                                <td valign="top" align="right" style="border-top:1px solid black;" width="50px">' . number_format($rpur_qty) . '</td>
                                <td valign="top" align="right" style="border-top:1px solid black;" width="50px">' . number_format($pick_qty) . '</td>
                                <td valign="top" align="right" style="border-top:1px solid black;" width="50px">' . number_format($sal_qty) . '</td>
                                <td valign="top" align="right" style="border-top:1px solid black;" width="50px">' . number_format($rsal_qty) . '</td>
                                <td valign="top" align="right" style="border-top:1px solid black;" width="50px">' . number_format($opn_qty) . '</td>
                                <td valign="top" align="right" style="border-top:1px solid black;" width="50px">' . number_format($end_qty) . '</td>
                                <td valign="top" width="20px"></td>
                                <td valign="top" align="right" style="border-top:1px solid black;" width="90px">' . number_format($shpp_awal) . '</td>
                                <td valign="top" align="right" style="border-top:1px solid black;" width="90px">' . number_format($shpp_beli) . '</td>
                                <td valign="top" align="right" style="border-top:1px solid black;" width="90px">' . number_format($shpp_pick) . '</td>
                                <td valign="top" align="right" style="border-top:1px solid black;" width="90px">' . number_format($shpp_jual) . '</td>
                                <td valign="top" align="right" style="border-top:1px solid black;" width="90px">' . number_format($shpp_retJual) . '</td>
                                <td valign="top" align="right" style="border-top:1px solid black;" width="90px">' . number_format($shpp_akhir) . '</td>
			</tr>';
    $j = 0;
    $beg_qty = 0;
    $pur_qty = 0;
    $rpur_qty = 0;
    $pick_qty = 0;
    $sal_qty = 0;
    $rsal_qty = 0;
    $opn_qty = 0;
    $end_qty = 0;

    $shpp_awal = 0;
    $shpp_beli = 0;
    $shpp_pick = 0;
    $shpp_jual = 0;
    $shpp_retJual = 0;
    $shpp_akhir = 0;
}
if ($i >= 1) {
    $tbl.= '
			<tr>
                            <td valign="top" colspan="5" align="right"><b style="font-size:1.1em;">TOTAL  ' . $last_wrhs_code . ':</b></td>
                            <td valign="top" align="right" style="border-top:1px solid black;" width="50px"><b>' . number_format($t_beg_qty) . '</b></td>
                            <td valign="top" align="right" style="border-top:1px solid black;" width="50px"><b>' . number_format($t_pur_qty) . '</b></td>
                            <td valign="top" align="right" style="border-top:1px solid black;" width="50px"><b>' . number_format($t_rpur_qty) . '</b></td>
                            <td valign="top" align="right" style="border-top:1px solid black;" width="50px"><b>' . number_format($t_pick_qty) . '</b></td>
                            <td valign="top" align="right" style="border-top:1px solid black;" width="50px"><b>' . number_format($t_sal_qty) . '</b></td>
                            <td valign="top" align="right" style="border-top:1px solid black;" width="50px"><b>' . number_format($t_rsal_qty) . '</b></td>
                            <td valign="top" align="right" style="border-top:1px solid black;" width="50px"><b>' . number_format($t_opn_qty) . '</b></td>
                            <td valign="top" align="right" style="border-top:1px solid black;" width="50px"><b>' . number_format($t_end_qty) . '</b></td>
                             <td valign="top" width="20px"></td>
                            <td valign="top" align="right" style="border-top:1px solid black;" width="90px"><b>' . number_format($t_hpp_awal) . '</b></td>
                            <td valign="top" align="right" style="border-top:1px solid black;" width="90px"><b>' . number_format($t_hpp_beli) . '</b></td>
                            <td valign="top" align="right" style="border-top:1px solid black;" width="90px"><b>' . number_format($t_hpp_pick) . '</b></td>
                            <td valign="top" align="right" style="border-top:1px solid black;" width="90px"><b>' . number_format($t_hpp_jual) . '</b></td>
                            <td valign="top" align="right" style="border-top:1px solid black;" width="90px"><b>' . number_format($t_hpp_retJual) . '</b></td>
                            <td valign="top" align="right" style="border-top:1px solid black;" width="90px"><b>' . number_format($t_hpp_akhir) . '</b></td>
			</tr>';
    $i = 0;
    $t_beg_qty = 0;
    $t_pur_qty = 0;
    $t_rpur_qty = 0;
    $t_pick_qty = 0;
    $t_sal_qty = 0;
    $t_rsal_qty = 0;
    $t_opn_qty = 0;
    $t_end_qty = 0;

    $t_hpp_awal = 0;
    $t_hpp_beli = 0;
    $t_hpp_pick = 0;
    $t_hpp_jual = 0;
    $t_hpp_retJual = 0;
    $t_hpp_akhir = 0;
}
$tbl .='<tr><td valign="top"><br /></td></tr><tr><td valign="top"></td></tr><tr><td valign="top"></td></tr>';
$tbl .='<tfoot style="border:2px solid black !important;">'
        . '<tr>'
        . '<td class="border-foot" valign="top" colspan="5" align="right"><b style="font-size:1.1em;">TOTAL STOCK ' . $bulan[$mounth] . ' ' . $year . ':</b></td>'
        . '<td class="border-foot" valign="top" align="right" width="50"><b>' . number_format($sum_beg_qty) . '</b></td>'
        . '<td class="border-foot" valign="top" align="right" width="50"><b>' . number_format($sum_pur_qty) . '</b></td>'
        . '<td class="border-foot" valign="top" align="right" width="50"><b>' . number_format($sum_rpur_qty) . '</b></td>'
        . '<td class="border-foot" valign="top" align="right" width="50"><b>' . number_format($sum_pick_qty) . '</b></td>'
        . '<td class="border-foot" valign="top" align="right" width="50"><b>' . number_format($sum_sal_qty) . '</b></td>'
        . '<td class="border-foot" valign="top" align="right" width="50"><b>' . number_format($sum_rsal_qty) . '</b></td>'
        . '<td class="border-foot" valign="top" align="right" width="50"><b>' . number_format($sum_opn_qty) . '</b></td>'
        . '<td class="border-foot" valign="top" align="right" width="50"><b>' . number_format($sum_end_qty) . '</b></td>'
        . '<td class="border-foot" valign="top" width="20px"></td>'
        . '<td class="border-foot" valign="top" align="right" width="90"><b>' . number_format($sum_shpp_awal) . '</b></td>'
        . '<td class="border-foot" valign="top" align="right" width="90"><b>' . number_format($sum_shpp_beli) . '</b></td>'
        . '<td class="border-foot" valign="top" align="right" width="90"><b>' . number_format($sum_shpp_pick) . '</b></td>'
        . '<td class="border-foot" valign="top" align="right" width="90"><b>' . number_format($sum_shpp_jual) . '</b></td>'
        . '<td class="border-foot" valign="top" align="right" width="90"><b>' . number_format($sum_shpp_retJual) . '</b></td>'
        . '<td class="border-foot" valign="top" align="right" width="90"><b>' . number_format($sum_shpp_akhir) . '</b></td>'
        . '</tr>'
        . '</tfoot>';

$tbl .='</table>';

