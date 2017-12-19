<?php

$tbl .= '
<table width="100%">
<tr><td valign="top" align="center"><b style="font-size:1.1em;">' . $comp_name . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.1em;">SPK REPORT</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.1em;">Group By ' . $title . '</b></td></tr>';
if($filterdesc !== ''){
    $tbl .= '    <tr><td valign="top" align="center"><span style="font-size:1.1em;">Filter By ' . $filterdesc . '</span></td></tr>';
}
    
$tbl .= '<tr><td valign="top" align="center"><b>DATE : ' . dateView($so_date1) . ' UP TO ' . dateView($so_date2) . '</b></td></tr>
</table>
';

$tbl .= '
<table width="100%">
<tr>
<td></td>
<td valign="top" align="right"><b>Printed On: </b>' . date('d/m/Y') . '</td>
</tr>
</table>';

$tbl .= '
<table width="100%">
<thead style="border:2px solid black !important;">
<tr>
	<td class="border-head"  valign="top" rowspan="2" align="center" width="50"><b>SPK Date</b></td>
        <td class="border-head"  valign="top" rowspan="2" align="left" width="60"><b>SPK No.</b></td>
        <td class="border-head"  valign="top" rowspan="2" align="left" width="100"><b>Customer</b></td>
        <td class="border-head"  valign="top" rowspan="2" align="left" width="30"><b>Type<br />Year</b></td>
        <td class="border-head"  valign="top" rowspan="2" align="left" width="30"><b>Transm</b></td>
        <td class="border-head"  valign="top" rowspan="2" align="left" width="200"><b>Sales Person<br />Supervisor</b></td>
        <td class="border-head"  valign="top" rowspan="2"><b>Stock<br />Estimate</b></td>
        <td class="border-head"  valign="top" rowspan="2" align="left"><b>Made By<br />Approved By</b></td>
        <td class="border-head"  valign="top" rowspan="2" align="right"><b>Qty<br>(unit)</b></td>
        <td class="border-head"  valign="top" rowspan="2" align="right"><b>Sale Price</b></td>
        <td class="border-head"  valign="top" rowspan="2" align="right"><b>Discount</b></td>
        <td class="border-head"  valign="top" rowspan="2" align="right"><b>Net Price</b></td>
	<td class="border-head"  valign="top" align="center" colspan="5" style="border-bottom:1px solid #000"><b>Down payment</b></td>
</tr>
<tr>
        <td valign="top" style="padding-bottom:10px;font-size:0.9em;" align="right"><b>Amount</b></td>
	<td valign="top" align="center" style="padding-bottom:10px;font-size:0.9em;"><b>Payment Type</b></td>	
	<td valign="top" align="center" style="padding-bottom:10px;font-size:0.9em;"><b>Pay Date</b></td>
	<td valign="top" align="center" style="padding-bottom:10px;font-size:0.9em;"><b>Cheque No.</b></td>
	<td valign="top" align="center" style="padding-bottom:10px;font-size:0.9em;"><b>Date</b></td>
</tr>
</thead>';

$tbl .= '<tr><td></td></tr>';


$i = 0;
$j = 0;

$last_veh_code = '';
$last_veh_name = '';
$last_cust_code = '';
$last_cust_name = '';


$lnQty = 0;
$lnQty2 = 0;


$unit_price = 0;
$unit_disc = 0;
$tot_price = 0;
$dp_val = 0;

$unit_price2 = 0;
$unit_disc2 = 0;
$tot_price2 = 0;
$dp_val2 = 0;

$lSum = 0;

$sum_qty = 0;

$sum_unit_price = 0;
$sum_unit_disc = 0;
$sum_tot_price = 0;
$sum_dp_val = 0;


while ($dtlrow = mysql_fetch_array($dtl)) {

    if ($last_cust_code != $dtlrow['cust_code']) {

        if ($i >= 1) {

            $tbl.= '
			<tr>
				<td valign="top" colspan="8" align="right">TOTAL ' . $last_veh_code . ' : ' . $last_veh_name . ':</td>
				<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($lnQty) . '</td>
				<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($unit_price) . '</td>
				<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($unit_disc) . '</td>
				<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($tot_price) . '</td>
                                <td valign="top" align="right" style="border-top:1px solid black;">' . number_format($dp_val) . '</td>
			</tr>';

            $lSum = 0;
            $lnQty = 0;
            $unit_price = 0;
            $unit_disc = 0;
            $tot_price = 0;
            $dp_val = 0;
            $i = 0;
        }

        if ($j >= 1) {

            $tbl.= '
			<tr>
				<td valign="top" colspan="8" align="right"><b style="font-size:1.1em;" align="right">TOTAL ' . $last_cust_code . ' : ' . $last_cust_name . ':</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($lnQty2) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($unit_price2) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($unit_disc2) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($tot_price2) . '</b></td>
                                <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($dp_val2) . '</b></td>
			</tr>';

            $lSum2 = 0;
            $lnQty2 = 0;
            $unit_price2 = 0;
            $unit_disc2 = 0;
            $tot_price2 = 0;
            $dp_val2 = 0;
            $j = 0;
        }


        $tbl.= '<tr><td valign="top" colspan="17" align="left"><b style="font-size:1.1em;">*** ' . $dtlrow['cust_code'] . ' : ' . $dtlrow['cust_name'] . ' ***</b></td></tr>';
        $last_cust_code = $dtlrow['cust_code'];
        $last_cust_name = $dtlrow['cust_name'];

        $tbl.= '<tr><td valign="top" colspan="17" align="left"><b style="font-size:1.1em;">' . $dtlrow['veh_code'] . ' : ' . $dtlrow['veh_name'] . '</b></td></tr>';
        $last_veh_code = $dtlrow['veh_code'];
        $last_veh_name = $dtlrow['veh_name'];
    }elseif ($last_veh_code != $dtlrow['veh_code']) {
        if ($i >= 1) {

            $tbl.= '
			<tr>
				<td valign="top" colspan="8" align="right">TOTAL ' . $last_veh_code . ' : ' . $last_veh_name . ':</td>
				<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($lnQty) . '</td>
				<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($unit_price) . '</td>
				<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($unit_disc) . '</td>
				<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($tot_price) . '</td>
                                <td valign="top" align="right" style="border-top:1px solid black;">' . number_format($dp_val) . '</td>
			</tr>';

            $lSum = 0;
            $lnQty = 0;
            $unit_price = 0;
            $unit_disc = 0;
            $tot_price = 0;
            $dp_val = 0;
            $i = 0;
        }
        $tbl.= '<tr><td valign="top" colspan="17" align="left"><b style="font-size:1.1em;">' . $dtlrow['veh_code'] . ' : ' . $dtlrow['veh_name'] . '</b></td></tr>';
        $last_veh_code = $dtlrow['veh_code'];
        $last_veh_name = $dtlrow['veh_name'];
    }

    $lnQty++;
    $lnQty2++;
    $sum_qty++;

    $unit_price += $dtlrow['unit_price'];
    $unit_disc += $dtlrow['unit_disc'];
    $tot_price += $dtlrow['tot_price'];
    $dp_val += $dtlrow['pay_val'];

    $unit_price2 += $dtlrow['unit_price'];
    $unit_disc2 += $dtlrow['unit_disc'];
    $tot_price2 += $dtlrow['tot_price'];
    $dp_val2 += $dtlrow['pay_val'];

    $sum_unit_price += $dtlrow['unit_price'];
    $sum_unit_disc += $dtlrow['unit_disc'];
    $sum_tot_price += $dtlrow['tot_price'];
    $sum_dp_val += $dtlrow['pay_val'];


    $pay_date = dateView($dtlrow['pay_date']);
    $pred_stk_d = dateView($dtlrow['pred_stk_d']);
    $check_date = dateView($dtlrow['check_date']);
    $so_date = dateView($dtlrow['so_date']);

    $tbl.='<tr>';
    $tbl.='<td valign="top" align="center">' . $so_date . '</td>';
    $tbl.='<td valign="top">' . $dtlrow['so_no'] . '</td>';
    $tbl.='<td valign="top">' . $dtlrow['cust_name'] . '</td>';
    $tbl.='<td valign="top">' . $dtlrow['veh_type'] . '<br />' . $dtlrow['veh_year'] . '</td>';
    $tbl.='<td valign="top">' .  $dtlrow['veh_transm'] . '</td>';
    $tbl.='<td valign="top">' . $dtlrow['srep_name'] . '<br />' . $dtlrow['sspv_name'] . '</td>';
    $tbl.='<td valign="top">' . $pred_stk_d . '</td>';
    $tbl.='<td valign="top">' . $dtlrow['so_made_by'] . '<br />' . $dtlrow['so_appr_by'] . '</td>';
    $tbl.='<td valign="top" align="right">' . $dtlrow['qty'] . '</td>';
    $tbl.='<td valign="top" align="right">' . number_format($dtlrow['unit_price']) . '</td>';
    $tbl.='<td valign="top" align="right">' . number_format($dtlrow['unit_disc']) . '</td>';
    $tbl.='<td valign="top" align="right">' . number_format($dtlrow['tot_price']) . '</td>';
    $tbl.='<td valign="top" align="right">' . number_format($dtlrow['pay_val']) . '</td>';
    $tbl.='<td valign="top" align="left">' . $dtlrow['pay_type'] . '</td>';
    $tbl.='<td valign="top" align="left">' . $pay_date . '</td>';
    $tbl.='<td valign="top" align="left">' . $dtlrow['check_no'] . '</td>';
    $tbl.='<td valign="top" align="left">' . $check_date . '</td>';
    $tbl.='</tr>';

    $i++;
    $j++;
    unset($dtlrow);
}

if ($i >= 1) {

    $tbl.= '
			<tr>
				<td valign="top" colspan="8" align="right">TOTAL ' . $last_veh_code . ' : ' . $last_veh_name . ':</td>
				<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($lnQty) . '</td>
				<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($unit_price) . '</td>
				<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($unit_disc) . '</td>
				<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($tot_price) . '</td>
                                <td valign="top" align="right" style="border-top:1px solid black;">' . number_format($dp_val) . '</td>
			</tr>';

    $lSum = 0;
    $lnQty = 0;
    $unit_price = 0;
    $unit_disc = 0;
    $tot_price = 0;
    $dp_val = 0;
    $i = 0;
}

if ($j >= 1) {

    $tbl.= '
			<tr>
				<td valign="top" colspan="8" align="right"><b style="font-size:1.1em;" align="right">TOTAL ' . $last_cust_code . ' : ' . $last_cust_name . ':</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($lnQty2) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($unit_price2) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($unit_disc2) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($tot_price2) . '</b></td>
                                <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($dp_val2) . '</b></td>
			</tr>';

    $lSum2 = 0;
    $lnQty2 = 0;
    $unit_price2 = 0;
    $unit_disc2 = 0;
    $tot_price2 = 0;
    $dp_val2 = 0;
    $j = 0;
}

$tbl.= '<tr><td><br /><br /></td></tr>';
$tbl.= '<tfoot>
			<tr>    <td colspan="6"></td>
				<td class="border-foot" valign="top" colspan="2" align="right" style="border-left:2px solid black;"><b style="font-size:1.1em;">GRAND TOTAL:</b></td>
				<td class="border-foot" valign="top" align="right" style=""><b>' . number_format($sum_qty) . '</b></td>
				<td class="border-foot" valign="top" align="right" style=""><b>' . number_format($sum_unit_price) . '</b></td>
				<td class="border-foot" valign="top" align="right" style=""><b>' . number_format($sum_unit_disc) . '</b></td>
				<td class="border-foot" valign="top" align="right" style=""><b>' . number_format($sum_tot_price) . '</b></td>
                                <td class="border-foot" valign="top" align="right" style="border-right:2px solid black;"><b>' . number_format($sum_dp_val) . '</b></td>
	    </tr></tfoot>';

$tbl .='</table>';


?>