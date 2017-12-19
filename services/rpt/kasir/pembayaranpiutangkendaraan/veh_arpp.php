<?php

//=========CHANGE LOG========
//ganti semua <td jadi <td valign="top"
//pembetulan format date
//chassis => Chassis No.
//pembetulan footer

$tbl .= '
<div id="cntr1" align="center">
<table width="120%">
<tr><td valign="top" align="center"><b style="font-size:1.5em;">' . $comp_name . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.5em;">' . $rptTitle . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.1em;">' . $title . '</b></td></tr>
<tr><td valign="top" align="center"><b>' . $pay_date1 . ' UP TO ' . $pay_date2 . '</b></td></tr>
</table>
';

$tbl .= '
<table width="120%">
<tr>
<td valign="top"></td>
<td valign="top" align="right"><b>Printed On: </b>' . date('d/m/Y') . '</td>
</tr>
</table>';

$tbl .= '
<table width="120%">
<thead style="border:2px solid black !important;">
<tr>
	<th valign="top" align="center"><b>Payment Date</b></th>
	<th valign="top" align="left"><b>Invoice No.</b></th>
	<th valign="top" align="center"><b>Invoice Date</b></th>
        <th valign="top" align="left"><b>Customer<br />Leasing</b></th>
	<th valign="top" align="left"><b>Chassis No.</b></th>
	<th valign="top" align="right"><b>Payment</b></th>
	<th valign="top" align="right"><b>Discount</b></th>
        <th valign="top" align="right">Usage Downpayment</th>
        <th valign="top"  align="left"><b>Bank</b></th>
	<th valign="top" align="left"><b>Check No.</b></th>
	<th valign="top" align="left"><b>Check Date</b></th>
	<th valign="top" align="left"><b>Due Date</b></th>
        <th valign="top"  align="left"><b>Payer Name</b></th>
	<th valign="top" align="left"><b>Description</b></th>
	<th valign="top" align="left"><b>Added By</b></th>';
$tbl .= '</tr></thead>';
$tbl .= '<tr><td valign="top"><br /></td></tr>';

$i = 0;
$j = 0;
$last_pay_type = '';
$last_sinv_name = '';
$last_pay_date = '';
$lnQty = 0;

$grp_pay = 0;
$grp_usage = 0;
$pay = 0;
$usage = 0;

$pay2 = 0;
$usage2 = 0;

$sum_usage = 0;
$sum_pay = 0;


$disc_val = 0;
$lSum = 0;

$grp_disc_val = 0;
$sum_disc_val = 0;
$payment = 0;
$usages = 0;

while ($dtlrow = mysql_fetch_array($dtl)) {


    if ($last_pay_type != $dtlrow['pay_type']) {
        if ($i >= 1) {
            if ($last_pay_date != $dtlrow['pay_date']) {
                if ($j >= 1) {
                    $tbl.= '
					<tr></tr><tr>
						<td valign="top" align="right" colspan="5"><b>Total Payment Date ' . dateView($last_pay_date) . ' :</b></td>
						<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($grp_pay) . '</b></td>
						<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($grp_disc_val) . '</b></td>
                                                <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($grp_usage) . '</b></td>     
					</tr><tr><td valign="top"><br></td></tr>';

                    $lnQty = 0;
                    $grp_pay = 0;
                    $grp_disc_val = 0;
                    $grp_usage = 0;
                }
            }
            $tbl.= '
			<tr>
				<td valign="top" colspan="5" align="right"><b style="font-size:1.1em;">Total Payment Type ' . $last_pay_type . ':</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($pay) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($disc_val) . '</b></td>
                                <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($usage) . '</b></td>    
			</tr><tr><td valign="top"><br></td></tr>';

            $lnQty = 0;
            $pay = 0;
            $usage = 0;
            $disc_val = 0;
            $j = 0;
        }
        $tbl.= '<tr><td valign="top" colspan="8" align="left"><b style="font-size:1.1em;">*** ' . $dtlrow['pay_type'] . ' ***</b></td></tr>';
        $last_pay_type = $dtlrow['pay_type'];
        $last_pay_date = $dtlrow['pay_date'];
    }
    if ($last_pay_date != $dtlrow['pay_date']) {
        if ($j >= 1) {
            $tbl.= '
			<tr></tr><tr>
				<td valign="top" align="right" colspan="5"><b>Total Payment Date ' . dateView($last_pay_date) . ' :</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($grp_pay) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($grp_disc_val) . '</b></td>
                                <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($grp_usage) . '</b></td>    
			</tr><tr><td valign="top"><br></td></tr>';

            $lnQty = 0;
            $grp_pay = 0;
            $grp_usage = 0;
            $grp_disc_val = 0;
        }
        $last_pay_date = $dtlrow['pay_date'];
    }

    $dp_inv_no = $dtlrow['dp_inv_no'];

    $lnQty++;
    $lSum++;

    if ($dp_inv_no !== '') {
        $usage += $dtlrow['pay_val'];
        $grp_usage += $dtlrow['pay_val'];
        $sum_usage += $dtlrow['pay_val'];
        $usage2 = $dtlrow['pay_val'];
        $usages = $dtlrow['pay_val'];
        $payment = 0;
    } else {
        $pay += $dtlrow['pay_val'];
        $grp_pay += $dtlrow['pay_val'];
        $sum_pay += $dtlrow['pay_val'];
        $pay2 = $dtlrow['pay_val'];
        $payment = $dtlrow['pay_val'];
        $usages = 0;
    }

    $disc_val += $dtlrow['disc_val'];
    $grp_disc_val += $dtlrow['disc_val'];
    $sum_disc_val += $dtlrow['disc_val'];

    $pay_date = dateView($dtlrow['pay_date']);
    $due_date = dateView($dtlrow['due_date']);
    $check_date = dateView($dtlrow['check_date']);
    $sal_date = dateView($dtlrow['sal_date']);

    $tbl.= '
	<tr>
		<td valign="top" align="left">' . $pay_date . '</td>
		<td valign="top" align="left">' . $dtlrow['sal_inv_no'] . '</td>
		<td valign="top" align="center">' . $sal_date . '</td>
                <td valign="top">' . $dtlrow['cust_code'] . '-' . $dtlrow['cust_name'] . '<br />' . $dtlrow['lease_name'] . '</td>
		<td valign="top" align="left">' . $dtlrow['chassis'] . '</td>
		<td valign="top" align="right">' . number_format($payment) . '</td>
		<td valign="top" align="right">' . number_format($dtlrow['disc_val']) . '</td>
                <td valign="top" align="right">' . number_format($usages) . '</td>
                <td valign="top"  align="left">' . $dtlrow['bank_code'] . '</td>
		<td valign="top" align="left">' . $dtlrow['check_no'] . '</td>
		<td valign="top" align="left">' . $check_date . '</td>
		<td valign="top" align="left">' . $due_date . '</td>
                <td valign="top" align="left">' . $dtlrow['payer_name'] . '</td>
		<td valign="top" align="left">' . $dtlrow['pay_desc'] . '</td>
		<td valign="top" align="left">' . $dtlrow['add_by'] . '</td>';

    $i++;
    $j++;
    unset($dtlrow);
}
if ($i >= 1) {
    if ($last_pay_date != $dtlrow['pay_date']) {
        if ($j >= 1) {
            $tbl.= '
			<tr></tr><tr>
				<td valign="top" align="right" colspan="5"><b>Total Payment Date ' . dateView($last_pay_date) . ' :</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($grp_pay) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($grp_disc_val) . '</b></td>
                                <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($grp_usage) . '</b></td>    
			</tr><tr><td valign="top"><br></td></tr>';

            $lnQty = 0;
            $grp_pay = 0;
            $grp_usage = 0;
            $grp_disc_val = 0;
        }
    }
    $tbl.= '
			<tr>
				<td valign="top" colspan="5" align="right"><b style="font-size:1.1em;">Total Payment Type ' . $last_pay_type . ':</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($pay) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($disc_val) . '</b></td>
                                <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($usage) . '</b></td>    
			</tr><tr><td valign="top"><br></td></tr>';

    $lnQty = 0;
    $pay = 0;
    $usage = 0;
    $disc_val = 0;
}


$tbl.= '<tr><td valign="top"></td></tr>
        <tfoot>
            <tr>
                <td colspan="4"></td>
		<td class="border-foot" style="border-left:2px solid black;border-top:2px solid black;border-bottom:2px solid black;" valign="top" align="right"><b style="font-size:1.1em;">GRAND TOTAL :</b></td>
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