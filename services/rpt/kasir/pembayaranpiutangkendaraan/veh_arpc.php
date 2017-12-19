<?php

//=========CHANGE LOG========
//ganti semua <td jadi <td valign="top"
//pembetulan format date
//chassis => Chassis No.
//pembetulan footer

$tbl .= '
<div id="cntr1" align="center">
<table width="100%">
<tr><td valign="top" align="center"><b style="font-size:1.5em;">' . $comp_name . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.5em;">' . $rptTitle . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.1em;">' . $title . '</b></td></tr>
<tr><td valign="top" align="center"><b>' . $pay_date1 . ' UP TO ' . $pay_date2 . '</b></td></tr>
</table>
';

$tbl .= '
<table width="100%">
<tr>
<td valign="top"></td>
<td valign="top" align="right"><b>Printed On: </b>' . date('d/m/Y') . '</td>
</tr>
</table>';

$tbl .= '
<table width="100%"> 
<thead style="border:2px solid black !important;padding:top:10px !important;padding-bottom:10px !important;">
<tr>
	<th valign="top" align="center"><b>Payment Date</b></th>
	<th valign="top" align="left"><b>Invoice No.</b></th>
	<th valign="top" align="left"><b>Invoice Date</b></th>
	<th valign="top"  align="left"><b>Chassis No.</b></th>
	<th valign="top" align="right"><b>Payment</b></th>
	<th valign="top" align="right"><b>Discount</b></th>
        <th valign="top" align="right">Usage Downpayment</th>
        <th valign="top"  align="left"><b>Bank</b></th>
	<th valign="top"  align="left"><b>Payment Type</b></th>
	<th valign="top"  align="left"><b>Check No.</b></th>
	<th valign="top"  align="left"><b>Check Date</b></th>
	<th valign="top"  align="left"><b>Due Date</b></th>
        <th valign="top"  align="left"><b>Payer Name</b></th>
	<th valign="top" align="left"><b>Description</b></th>
	<th valign="top" align="left"><b>Added By</b></th>';

$tbl .= '</tr></thead>';
$tbl .= '<tr><td valign="top"><br /></td></tr>';

$i = 0;
$j = 0;
$last_cust_code = '';
$last_cust_name = '';
$last_lease_code = '';
$last_lease_name = '';
$last_pay_date = '';
$lnQty = 0;

$pay = 0;
$usage = 0;
$pay2 = 0;
$usage2 = 0;
$sum_usage = 0;
$sum_pay = 0;

$disc_val = 0;
$lSum = 0;


$sum_disc_val = 0;

$lnQty2 = 0;
$pay2 = 0;
$disc_val2 = 0;
$usage2 = 0;

$payment = 0;
$usages = 0;

while ($dtlrow = mysql_fetch_array($dtl)) {

    if ($last_cust_code != $dtlrow['cust_code']) {
        if ($j >= 1) {

            $tbl.= '
			<tr>
				<td valign="top" colspan="4" align="right"><b style="font-size:1.1em;"> Total Date : ' . dateView($last_pay_date) . ' : </b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($pay2) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($disc_val2) . '</b></td>
                                <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($usage2) . '</b></td>
			</tr>';
            $tbl .='<tr><td></td></tr>';

            $lnQty2 = 0;
            $pay2 = 0;
            $disc_val2 = 0;
            $usage2 = 0;
            $j = 0;
        }

        if ($i >= 1) {

            $tbl.= '
			<tr>
				<td valign="top" colspan="4" align="right"><b style="font-size:1.1em;">TOTAL ' . $last_cust_code . ' : </b></td>
				<td valign="top" align="right" style="border-top:2px solid black;"><b>' . number_format($pay) . '</b></td>
				<td valign="top" align="right" style="border-top:2px solid black;"><b>' . number_format($disc_val) . '</b></td>
                                <td valign="top" align="right" style="border-top:2px solid black;"><b>' . number_format($usage) . '</b></td>
			</tr>';

            $lnQty = 0;
            $pay = 0;
            $disc_val = 0;
            $usage = 0;
            $i = 0;
        }
        $tbl.= '<tr><td valign="top" colspan="4" align="left"><b style="font-size:1.1em;">*** Customer ' . $dtlrow['cust_code'] . ' : ' . $dtlrow['cust_name'] . ' ***</b></td><td colspan="6"><b>' . $dtlrow['lease_code'] . ' ' . $dtlrow['lease_name'] . '</b><td></tr>';
        $tbl.='<tr><td colspan="8"></td></tr>';
        $last_cust_code = $dtlrow['cust_code'];
        $last_cust_name = $dtlrow['cust_name'];

        $last_pay_date = $dtlrow['pay_date'];
        // $last_pay_date = $dtlrow['pay_date'];
    } elseif ($last_pay_date != $dtlrow['pay_date']) {
        if ($j >= 1) {

            $tbl.= '
			<tr>
				<td valign="top" colspan="4" align="right"><b style="font-size:1.1em;"> Total Date : ' . dateView($last_pay_date) . ' : </b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($pay2) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($disc_val2) . '</b></td>
                                <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($usage2) . '</b></td>
			</tr>';
            $tbl .='<tr><td></td></tr>';

            $lnQty2 = 0;
            $pay2 = 0;
            $disc_val2 = 0;
            $usage2 = 0;
            $j = 0;
        }
        $last_pay_date = $dtlrow['pay_date'];
    }

    $lnQty++;
    $lSum++;

    $dp_inv_no = $dtlrow['dp_inv_no'];

    if ($dp_inv_no !== '') {
        $usage += $dtlrow['pay_val'];
        $sum_usage += $dtlrow['pay_val'];
        $usage2 += $dtlrow['pay_val'];
        $usages = $dtlrow['pay_val'];
        $payment= 0;
    } else {
        $pay += $dtlrow['pay_val'];
        $sum_pay += $dtlrow['pay_val'];
        $pay2 += $dtlrow['pay_val'];
        $payment = $dtlrow['pay_val'];
        $usages = 0;
    }


    $disc_val += $dtlrow['disc_val'];
    $disc_val2 += $dtlrow['disc_val'];
    $sum_disc_val += $dtlrow['disc_val'];

    $pay_date = dateView($dtlrow['pay_date']);
    $due_date = dateView($dtlrow['due_date']);
    $check_date = dateView($dtlrow['check_date']);
    $sal_date = dateView($dtlrow['sal_date']);


    $tbl.= '
	<tr>
		<td valign="top" align="left">' . $pay_date . '</td>
		<td valign="top" align="left">' . $dtlrow['sal_inv_no'] . '</td>
		<td valign="top"  align="left">' . $sal_date . '</td>
		<td valign="top" align="left">' . $dtlrow['chassis'] . '</td>
		<td valign="top" align="right">' . number_format($payment) . '</td>
		<td valign="top" align="right">' . number_format($dtlrow['disc_val']) . '</td>
                <td valign="top" align="right">' . number_format($usages) . '</td>  
                <td valign="top"  align="left">' . $dtlrow['bank_code'] . '</td>
		<td valign="top"  align="left">' . $dtlrow['pay_type'] . '</td>
		<td valign="top"  align="left">' . $dtlrow['check_no'] . '</td>
		<td valign="top" align="left">' . $check_date . '</td>
		<td valign="top" align="left">' . $due_date . '</td>
                <td valign="top" align="left">' . $dtlrow['payer_name'] . '</td>
		<td valign="top" align="left">' . $dtlrow['pay_desc'] . '</td>
		<td valign="top" align="left">' . $dtlrow['add_by'] . '</td>';

    $i++;
    $j++;
    unset($dtlrow);
}

if ($j >= 1) {

    $tbl.= '
			<tr>
				<td valign="top" colspan="4" align="right"><b style="font-size:1.1em;"> Total Date : ' . dateView($last_pay_date) . ' : </b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($pay2) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($disc_val2) . '</b></td>
                                <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($usage2) . '</b></td>
			</tr>';
    $tbl .='<tr><td></td></tr>';

    $lnQty2 = 0;
    $pay2 = 0;
    $disc_val2 = 0;
    $usage2 = 0;
    $j = 0;
}

if ($i >= 1) {

    $tbl.= '
			<tr>
				<td valign="top" colspan="4" align="right"><b style="font-size:1.1em;">TOTAL ' . $last_cust_code . ' : </b></td>
				<td valign="top" align="right" style="border-top:2px solid black;"><b>' . number_format($pay) . '</b></td>
				<td valign="top" align="right" style="border-top:2px solid black;"><b>' . number_format($disc_val) . '</b></td>
                                <td valign="top" align="right" style="border-top:2px solid black;"><b>' . number_format($usage) . '</b></td>
			</tr>';

    $lnQty = 0;
    $pay = 0;
    $disc_val = 0;
    $usage = 0;
    $i = 0;
}
$tbl.= '<tr><td valign="top"></td></tr>
        <tfoot>
            <tr>
                <td colspan="3"></td>
		<td class="border-foot" style="border-left:2px solid black;border-top:2px solid black;border-bottom:2px solid black;" valign="top"  align="right"><b style="font-size:1.1em;">GRAND TOTAL :</b></td>
		<td class="border-foot" style="border-top:2px solid black;border-bottom:2px solid black;" valign="top" align="right"><b>' . number_format($sum_pay) . '</b></td>
		<td class="border-foot" style="border-top:2px solid black;border-bottom:2px solid black;" valign="top" align="right"><b>' . number_format($sum_disc_val) . '</b></td>
                <td class="border-foot" style="border-right:2px solid black;border-top:2px solid black;border-bottom:2px solid black;" valign="top" align="right"><b>' . number_format($sum_usage) . '</b></td>    
            </tr>
        </tfoot>';
$tbl .='
</table>


</div>
';
?>