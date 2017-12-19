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
if ($filterdesc !== '') {
    $tbl .= '    <tr><td valign="top" align="center"><span style="font-size:1.1em;">Filter By ' . $filterdesc . '</span></td></tr>';
}
$tbl .='<tr><td valign="top" align="center"><b>' . $bulan[$mounth] . '  ' . $year . ' </b></td></tr>
</table>
';

$tbl .= '
    <table width="70%"  >
    <tr>
    <td valign="top"></td>
    <td valign="top" align="right"><b>Printed On: </b>' . date('d/m/Y') . '</td>
    </tr>
    </table>';

$tbl .= '
<table width="70%">
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
<td valign="top" align="right" width="50px"><b>Opname Qty</b></td>
<td valign="top" align="right" width="50px"><b>End Qty</b></td>
</tr>
</thead>';

$tbl .= '
<tr>
	<td valign="top" colspan="13"></td>
</tr>
';

$i = 0;
$j = 0;
$lnQty = 0;
$last_veh_code = '';
$last_veh_name = '';
$last_color_name = '';
$last_color_code = '';

$beg_qty = 0;
$pur_qty = 0;
$rpur_qty = 0;
$pick_qty = 0;
$sal_qty = 0;
$rsal_qty = 0;
$opn_qty = 0;
$end_qty = 0;

$t_beg_qty = 0;
$t_pur_qty = 0;
$t_rpur_qty = 0;
$t_pick_qty = 0;
$t_sal_qty = 0;
$t_rsal_qty = 0;
$t_opn_qty = 0;
$t_end_qty = 0;

$s_beg_qty = 0;
$s_pur_qty = 0;
$s_rpur_qty = 0;
$s_pick_qty = 0;
$s_sal_qty = 0;
$s_rsal_qty = 0;
$s_opn_qty = 0;
$s_end_qty = 0;

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

    $s_beg_qty += $dtlrow['beg_qty'];
    $s_pur_qty += $dtlrow['pur_qty'];
    $s_rpur_qty += $dtlrow['rpur_qty'];
    $s_pick_qty += $dtlrow['pick_qty'];
    $s_sal_qty += $dtlrow['sal_qty'];
    $s_rsal_qty += $dtlrow['rsal_qty'];
    $s_opn_qty += $dtlrow['opn_qty'];
    $s_end_qty += $dtlrow['end_qty'];

    if ($last_color_code != $dtlrow['color_code']) {

        if ($j >= 1) {
            $tbl.= '
			<tr>
				<td valign="top" colspan="5" align="right">TOTAL ' . $last_veh_code . ' : ' . $last_veh_name . ':</td>
				<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($beg_qty) . '</td>
                                <td valign="top" align="right" style="border-top:1px solid black;">' . number_format($pur_qty) . '</td>
                                <td valign="top" align="right" style="border-top:1px solid black;">' . number_format($rpur_qty) . '</td>
                                <td valign="top" align="right" style="border-top:1px solid black;">' . number_format($pick_qty) . '</td>
                                <td valign="top" align="right" style="border-top:1px solid black;">' . number_format($sal_qty) . '</td>
                                <td valign="top" align="right" style="border-top:1px solid black;">' . number_format($rsal_qty) . '</td>
                                <td valign="top" align="right" style="border-top:1px solid black;">' . number_format($opn_qty) . '</td>
                                <td valign="top" align="right" style="border-top:1px solid black;">' . number_format($end_qty) . '</td>
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
        }

        if ($i >= 1) {

            $tbl.= '
			<tr>
                            <td valign="top" colspan="5" align="right"><b style="font-size:1.1em;">TOTAL ' . $last_color_code . ' : ' . $last_color_name . ':</b></td>
                            <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($t_beg_qty) . '</b></td>
                            <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($t_pur_qty) . '</b></td>
                            <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($t_rpur_qty) . '</b></td>
                            <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($t_pick_qty) . '</b></td>
                            <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($t_sal_qty) . '</b></td>
                            <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($t_rsal_qty) . '</b></td>
                            <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($t_opn_qty) . '</b></td>
                            <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($t_end_qty) . '</b></td>
			</tr>';

            $i = 0;
            $lnQty = 0;
            $t_beg_qty = 0;
            $t_pur_qty = 0;
            $t_rpur_qty = 0;
            $t_pick_qty = 0;
            $t_sal_qty = 0;
            $t_rsal_qty = 0;
            $t_opn_qty = 0;
            $t_end_qty = 0;
        }

        $tbl.= '<tr><td valign="top" colspan="12" align="left"><b style="font-size:1.1em;">*** ' . $dtlrow['color_code'] . ' : ' . $dtlrow['color_name'] . ' ***</b></td></tr>';
        $last_color_name = $dtlrow['color_name'];
        $last_color_code = $dtlrow['color_code'];

        $tbl.= '<tr><td valign="top" colspan="13" align="left"><b style="font-size:1.1em;">' . $dtlrow['veh_code'] . ' : ' . $dtlrow['veh_name'] . '</b></td></tr>';
        $last_veh_name = $dtlrow['veh_name'];
        $last_veh_code = $dtlrow['veh_code'];
    } elseif ($last_veh_code != $dtlrow['veh_code']) {
        if ($j >= 1) {
            $tbl.= '
			<tr>
				<td valign="top" colspan="5" align="right">TOTAL ' . $last_veh_code . ' : ' . $last_veh_name . ':</td>
				<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($beg_qty) . '</td>
                                <td valign="top" align="right" style="border-top:1px solid black;">' . number_format($pur_qty) . '</td>
                                <td valign="top" align="right" style="border-top:1px solid black;">' . number_format($rpur_qty) . '</td>
                                <td valign="top" align="right" style="border-top:1px solid black;">' . number_format($pick_qty) . '</td>
                                <td valign="top" align="right" style="border-top:1px solid black;">' . number_format($sal_qty) . '</td>
                                <td valign="top" align="right" style="border-top:1px solid black;">' . number_format($rsal_qty) . '</td>
                                <td valign="top" align="right" style="border-top:1px solid black;">' . number_format($opn_qty) . '</td>
                                <td valign="top" align="right" style="border-top:1px solid black;">' . number_format($end_qty) . '</td>
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
        }

        $tbl.= '<tr><td valign="top" colspan="13" align="left"><b style="font-size:1.1em;">' . $dtlrow['veh_code'] . ' : ' . $dtlrow['veh_name'] . '</b></td></tr>';
        $last_veh_name = $dtlrow['veh_name'];
        $last_veh_code = $dtlrow['veh_code'];
    }


    $beg_qty += $dtlrow['beg_qty'];
    $pur_qty += $dtlrow['pur_qty'];
    $rpur_qty += $dtlrow['rpur_qty'];
    $pick_qty += $dtlrow['pick_qty'];
    $sal_qty += $dtlrow['sal_qty'];
    $rsal_qty += $dtlrow['rsal_qty'];
    $opn_qty += $dtlrow['opn_qty'];
    $end_qty += $dtlrow['end_qty'];

    $t_beg_qty += $dtlrow['beg_qty'];
    $t_pur_qty += $dtlrow['pur_qty'];
    $t_rpur_qty += $dtlrow['rpur_qty'];
    $t_pick_qty += $dtlrow['pick_qty'];
    $t_sal_qty += $dtlrow['sal_qty'];
    $t_rsal_qty += $dtlrow['rsal_qty'];
    $t_opn_qty += $dtlrow['opn_qty'];
    $t_end_qty += $dtlrow['end_qty'];


    $stk_date = dateView($dtlrow['stk_date']);

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
            . '</tr>';



    $i++;
    $j++;
    unset($dtlrow);
}

if ($j >= 1) {
    $tbl.= '
			<tr>
				<td valign="top" colspan="5" align="right">TOTAL ' . $last_veh_code . ' : ' . $last_veh_name . ':</td>
				<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($beg_qty) . '</td>
                                <td valign="top" align="right" style="border-top:1px solid black;">' . number_format($pur_qty) . '</td>
                                <td valign="top" align="right" style="border-top:1px solid black;">' . number_format($rpur_qty) . '</td>
                                <td valign="top" align="right" style="border-top:1px solid black;">' . number_format($pick_qty) . '</td>
                                <td valign="top" align="right" style="border-top:1px solid black;">' . number_format($sal_qty) . '</td>
                                <td valign="top" align="right" style="border-top:1px solid black;">' . number_format($rsal_qty) . '</td>
                                <td valign="top" align="right" style="border-top:1px solid black;">' . number_format($opn_qty) . '</td>
                                <td valign="top" align="right" style="border-top:1px solid black;">' . number_format($end_qty) . '</td>
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
}

if ($i >= 1) {

    $tbl.= '
			<tr>
                            <td valign="top" colspan="5" align="right"><b style="font-size:1.1em;">TOTAL ' . $last_color_code . ' : ' . $last_color_name . ':</b></td>
                            <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($t_beg_qty) . '</b></td>
                            <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($t_pur_qty) . '</b></td>
                            <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($t_rpur_qty) . '</b></td>
                            <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($t_pick_qty) . '</b></td>
                            <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($t_sal_qty) . '</b></td>
                            <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($t_rsal_qty) . '</b></td>
                            <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($t_opn_qty) . '</b></td>
                            <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($t_end_qty) . '</b></td>
			</tr>';

    $i = 0;
    $lnQty = 0;
    $t_beg_qty = 0;
    $t_pur_qty = 0;
    $t_rpur_qty = 0;
    $t_pick_qty = 0;
    $t_sal_qty = 0;
    $t_rsal_qty = 0;
    $t_opn_qty = 0;
    $t_end_qty = 0;
}

$tbl .='<tr><td valign="top"></td></tr><tr><td valign="top"></td></tr><tr><td valign="top"></td></tr>';
$tbl .='<tfoot style="border:2px solid black !important;">'
        . '<tr>'
        . '<td class="border-foot" valign="top" colspan="5" align="right"><b style="font-size:1.1em;">TOTAL STOCK ' . $bulan[$mounth] . ' ' . $year . ':</b></td>'
        . '<td class="border-foot" valign="top" align="right" width="50"><b>' . number_format($s_beg_qty) . '</b></td>'
        . '<td class="border-foot" valign="top" align="right" width="50"><b>' . number_format($s_pur_qty) . '</b></td>'
        . '<td class="border-foot" valign="top" align="right" width="50"><b>' . number_format($s_rpur_qty) . '</b></td>'
        . '<td class="border-foot" valign="top" align="right" width="50"><b>' . number_format($s_pick_qty) . '</b></td>'
        . '<td class="border-foot" valign="top" align="right" width="50"><b>' . number_format($s_sal_qty) . '</b></td>'
        . '<td class="border-foot" valign="top" align="right" width="50"><b>' . number_format($s_rsal_qty) . '</b></td>'
        . '<td class="border-foot" valign="top" align="right" width="50"><b>' . number_format($s_opn_qty) . '</b></td>'
        . '<td class="border-foot" valign="top" align="right" width="50"><b>' . number_format($s_end_qty) . '</b></td>'
        . '</tr>'
        . '</tfoot>';

$tbl .='</table>';

