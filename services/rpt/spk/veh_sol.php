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
<table width="100%"  >
<tr>
<td></td>
<td valign="top" align="right"><b>Printed On: </b>' . date('d/m/Y') . '</td>
</tr>
</table>';

$tbl .= '
<table width="100%">
<thead style="border:2px solid black !important;">
<tr>
	<td class="border-head"  valign="top" align="left" rowspan="2" width="50"><b>SPK Date</b></td>
	<td class="border-head"  valign="top" align="left" rowspan="2" width="60"><b>SPK No.</b></td>
	<td class="border-head"  valign="top" align="left" rowspan="2" width="100"><b>Customer</b></td>
	<td class="border-head"  valign="top" align="left" rowspan="2" width="30"><b>Type</b></td>
	<td class="border-head"  valign="top" align="left" rowspan="2" width="30"><b>Year</b></td>
	<td class="border-head"  valign="top" align="left" rowspan="2"><b>Color</b></td>
	<td class="border-head"  valign="top" align="left" rowspan="2"><b>Sales</b></td>
	<td class="border-head"  valign="top" align="left" rowspan="2"><b>Made by</b></td>
	<td class="border-head"  valign="top" align="left" rowspan="2"><b>Approved By</b></td>
	<td class="border-head"  valign="top" align="center" rowspan="2"><b>Qty<br>(unit)</b></td>
	<td class="border-head"  valign="top" align="right" rowspan="2"><b>Sale Price</b></td>        
        <td class="border-head"  valign="top" rowspan="2" align="right"><b>Discount</b></td>
        <td class="border-head"  valign="top" rowspan="2" align="right"><b>Net Price</b></td>
	<td class="border-head"  valign="top" align="center" 	 colspan="5" style="border-bottom:1px solid #000"><b>Down payment</b></td>
</tr>
<tr>
        <td valign="top" style="padding-bottom:10px;font-size:0.9em;" align="right"><b>Amount</b></td>
	<td valign="top" align="center" style="padding-bottom:10px;font-size:0.9em;"><b>Payment Type</b></td>	
	<td valign="top" align="center" style="padding-bottom:10px;font-size:0.9em;"><b>Pay Date</b></td>
	<td valign="top" align="center" style="padding-bottom:10px;font-size:0.9em;"><b>Cheque No.</b></td>
	<td valign="top" align="center" style="padding-bottom:10px;font-size:0.9em;"><b>Date</b></td>
</tr>
</thead>';

$tbl .= '

<tr>
	<td valign="top"  width="70px" ></td>
	<td valign="top"  width="60px" ></td>
	<td valign="top"  width="140px" ></td>
	<td valign="top"  width="80px" ></td>
	<td valign="top"  width="50px" ></td>
	<td valign="top"  width="50px" ></td>
	<td valign="top"  width="140px"></td>
	<td valign="top"  width="90px" ></td>
	<td valign="top"  width="90px" ></td>
	<td valign="top"  width="50px" ></td>
	<td valign="top"  width="90px"></td>
	<td valign="top"  width="70px"></td>
	<td valign="top"  width="90px"></td>
	<td valign="top"  width="70px"></td>
	<td valign="top"  width="60px"></td>
	<td valign="top"  width="70px"></td>
</tr>
';

$i = 0;
$j = 0;
$last_veh_code = '';
$last_veh_name = '';
$last_lease_code = '';
$last_lease_name = '';

$lcsalpaytype = '';
$lcsalpaytype2 = '';
$lnsalpaytype = '';


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
$sum_value = 0;
$sum_dp_val = 0;
$lnCash = 0;



$sum_unit_disc = 0;
$sum_tot_price = 0;


$lease_sum_qty = 0;
$lease_unit_price = 0;
$lease_unit_disc = 0;
$lease_tot_price = 0;
$lease_dp_val = 0;

$not_sum_qty = 0;
$not_unit_price = 0;
$not_unit_disc = 0;
$not_tot_price = 0;
$not_dp_val = 0;



while ($dtlrow = mysql_fetch_array($dtl)) {
    if (empty($dtlrow['lease_code'])) {
        $lnCash = 1;
    } else {
        $lnCash = 2;
    }
    if ($lnsalpaytype != $lnCash) {
        if ($i >= 1) {

            $tbl.= '
			<tr>
				<td valign="top" colspan="9" align="right">TOTAL ' . $last_veh_code . ' : ' . $last_veh_name . ':</td>
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
				<td valign="top" colspan="9" align="right"><b style="font-size:1.1em;">TOTAL ' . $lcsalpaytype . ':</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($lnQty2) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($unit_price2) . '</b></td>
                                <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($unit_disc2) . '</b></td>
                                <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($tot_price2) . '</b></td>
			
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($dp_val2) . '</b></td>
			</tr>';


            $lnQty2 = 0;
            $value2 = 0;
            $unit_price2 = 0;
            $unit_disc2 = 0;
            $tot_price2 = 0;
        }
        if (empty($dtlrow['lease_code'])) {
            $lnsalpaytype = 1;
        } else {
            $lnsalpaytype = 2;
        }

        switch ($lnsalpaytype) {
            case 1 : $lcsalpaytype = 'NON LEASING';
                break;
            case 2 : $lcsalpaytype = $last_lease_code . ' : ' . $last_lease_name;
                break;
        }

        switch ($lnsalpaytype) {
            case 1 : $lcsalpaytype2 = 'NON LEASING';
                break;
            case 2 : $lcsalpaytype2 = $dtlrow['lease_code'] . ' : ' . $dtlrow['lease_name'];
                break;
        }

        $tbl.= '<tr><td valign="top" colspan="17" align="left"><b style="font-size:1.1em;">*** ' . $lcsalpaytype2 . ' ***</b></td></tr>';

        $last_lease_name = $dtlrow['lease_name'];
        $last_lease_code = $dtlrow['lease_code'];

        $tbl.= '<tr><td valign="top" colspan="17" align="left"><b style="font-size:1.1em;">' . $dtlrow['veh_code'] . ' : ' . $dtlrow['veh_name'] . '</b></td></tr>';
        $last_veh_code = $dtlrow['veh_code'];
        $last_veh_name = $dtlrow['veh_name'];
    } elseif ($last_veh_code != $dtlrow['veh_code']) {
        if ($i >= 1) {

            $tbl.= '
			<tr>
				<td valign="top" colspan="9" align="right">TOTAL ' . $last_veh_code . ' : ' . $last_veh_name . ':</td>
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

    $unit_price += $dtlrow['unit_price'];
    $unit_disc += $dtlrow['unit_disc'];
    $tot_price += $dtlrow['tot_price'];
    $dp_val += $dtlrow['pay_val'];

    $unit_price2 += $dtlrow['unit_price'];
    $unit_disc2 += $dtlrow['unit_disc'];
    $tot_price2 += $dtlrow['tot_price'];
    $dp_val2 += $dtlrow['pay_val'];


    $sum_qty++;
    $sum_value += $dtlrow['unit_price'];
    $sum_dp_val += $dtlrow['pay_val'];

    $sum_unit_disc += $dtlrow['unit_disc'];
    $sum_tot_price += $dtlrow['tot_price'];

    if (!empty($dtlrow['lease_code'])) {
        $lease_sum_qty++;
        $lease_unit_price += $dtlrow['unit_price'];
        $lease_unit_disc += $dtlrow['unit_disc'];
        $lease_tot_price += $dtlrow['tot_price'];
        $lease_dp_val += $dtlrow['pay_val'];
    } else {
        $not_sum_qty++;
        $not_unit_price += $dtlrow['unit_price'];
        $not_unit_disc += $dtlrow['unit_disc'];
        $not_tot_price += $dtlrow['tot_price'];
        $not_dp_val += $dtlrow['pay_val'];
    }



    $pay_date = dateView($dtlrow['pay_date']);
    $pred_stk_d = dateView($dtlrow['pred_stk_d']);
    $check_date = dateView($dtlrow['check_date']);
    $so_date = dateView($dtlrow['so_date']);


    $tbl.= '
	<tr>
		<td valign="top" align="left">' . $so_date . '</td>
		<td valign="top" align="left">' . $dtlrow['so_no'] . '</td>
		<td valign="top" align="left">' . $dtlrow['cust_name'] . '</td>
		<td valign="top" align="left">' . $dtlrow['veh_type'] . '</td>
		<td valign="top" align="center">' . $dtlrow['veh_year'] . '</td>
		<td valign="top" align="left">' . $dtlrow['color_code'] . '</td>
		<td valign="top" align="left">' . $dtlrow['srep_name'] . '</td>
		<td valign="top" align="left">' . $dtlrow['so_made_by'] . '</td>
		<td valign="top" align="left">' . $dtlrow['so_appr_by'] . '</td>
		<td valign="top" align="right">' . $dtlrow['qty'] . '</td>
	        <td valign="top" align="right">' . number_format($dtlrow['unit_price']) . '</td>
                <td valign="top" align="right">' . number_format($dtlrow['unit_disc']) . '</td>
                <td valign="top" align="right">' . number_format($dtlrow['tot_price']) . '</td>
                <td valign="top" align="right">' . number_format($dtlrow['pay_val']) . '</td>
		<td valign="top" align="center">' . $dtlrow['pay_type'] . '</td>		
		<td valign="top" align="center">' . $pay_date . '</td>
		<td valign="top" >' . $dtlrow['check_no'] . '</td>
		<td valign="top" align="center">' . $check_date . '</td>
	</tr>';
    $i++;
    $j++;
    unset($dtlrow);
}

if ($i >= 1) {

    $tbl.= '
			<tr>
				<td valign="top" colspan="9" align="right">TOTAL ' . $last_veh_code . ' : ' . $last_veh_name . ':</td>
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

switch ($lnsalpaytype) {
    case 1 : $lcsalpaytype = 'NON LEASING';
        break;
    case 2 : $lcsalpaytype = $last_lease_code . ' : ' . $last_lease_name;
        break;
}
if ($j >= 1) {
    $tbl.= '
			<tr>
				<td valign="top" colspan="9" align="right"><b style="font-size:1.1em;">TOTAL ' . $lcsalpaytype . ' :</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($lnQty2) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($unit_price2) . '</b></td>
                                <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($unit_disc2) . '</b></td>
                                <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($tot_price2) . '</b></td>
			
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($dp_val2) . '</b></td>
			</tr>';


    $lnQty2 = 0;
    $value2 = 0;
    $unit_price2 = 0;
    $unit_disc2 = 0;
    $tot_price2 = 0;
}


$tbl.= '
    <tr><td><br /></td></tr> <tr><td></td></tr> <tr><td></td></tr>
    <tfoot>
        <tr>
            <td colspan="7"></td>
            <td style="padding-top:10px;border-top:2px solid black;border-left:2px solid black;" valign="top" colspan="2" align="right"><b>SPK Leasing:</b></td>
            <td style="padding-top:10px;border-top:2px solid black;" valign="top" align="right" >' . number_format($lease_sum_qty) . '</td>
            <td style="padding-top:10px;border-top:2px solid black;" valign="top" align="right" >' . number_format($lease_unit_price) . '</td>
            <td style="padding-top:10px;border-top:2px solid black;" valign="top" align="right" >' . number_format($lease_unit_disc) . '</td>
            <td style="padding-top:10px;border-top:2px solid black;" valign="top" align="right" >' . number_format($lease_tot_price) . '</td>
         
            <td style="padding-top:10px;border-top:2px solid black;" valign="top" align="right" >' . number_format($lease_dp_val) . '</td>
            <td valign="top"  style="border-top:2px solid black;border-right:2px solid black;" valign="top" align="right"></td>
            <td valign="top" ></td>
            <td valign="top" ></td>

        </tr>
        <tr>
            <td colspan="7"></td>
            <td style="border-left:2px solid black;" valign="top" colspan="2" align="right"><b>SPK Non Leasing:</b></td>
            <td valign="top" align="right" >' . number_format($not_sum_qty) . '</td>
            <td valign="top" align="right" >' . number_format($not_unit_price) . '</td>
            <td valign="top" align="right" >' . number_format($not_unit_disc) . '</td>
            <td valign="top" align="right" >' . number_format($not_tot_price) . '</td>
   
            <td valign="top" align="right">' . number_format($not_dp_val) . '</td>
            <td style="border-right:2px solid black;" valign="top" align="right"></td>
            <td></td>
            <td></td>
        </tr>
        <tr>	
            <td colspan="7"></td>
            <td style="padding-bottom:10px;border-bottom:2px solid black;border-left:2px solid black;" valign="top" colspan="2" align="right"><b>GRAND TOTAL:</b></td>
            <td style="padding-bottom:10px;border-bottom:2px solid black;" valign="top" align="right" ><b>' . number_format($sum_qty) . '</b></td>
            <td style="padding-bottom:10px;border-bottom:2px solid black;" valign="top" align="right" ><b>' . number_format($sum_value) . '</b></td>
            <td style="padding-bottom:10px;border-bottom:2px solid black;" valign="top" align="right" ><b>' . number_format($sum_unit_disc) . '</td>
            <td style="padding-bottom:10px;border-bottom:2px solid black;" valign="top" align="right" ><b>' . number_format($sum_tot_price) . '</td>
          
            <td style="padding-bottom:10px;border-bottom:2px solid black;" valign="top" align="right" ><b>' . number_format($sum_dp_val) . '</b></td>
            <td style="padding-bottom:10px;border-bottom:2px solid black;border-right:2px solid black;"></td>
            <td></td>
            <td></td>

        </tr>
    </tfoot>';

$tbl .='</table>';
?>