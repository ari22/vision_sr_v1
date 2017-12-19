<?php

//=========CHANGE LOG========
//ganti semua <td jadi <td valign="top"
//pembetulan format date
//engine => engine No.;chassis => Chassis No.

$tbl .= '
<div id="cntr1" align="center">
<table width="90%">
<tr><td valign="top" align="center"><b style="font-size:1.5em;">' . $comp_name . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.5em;">' . $rptTitle . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.1em;">' . $title . '</b></td></tr>
<tr><td valign="top" align="center"><b>Date : ' . dateView($ar_date) . '</b></td></tr>
</table>
';


$tbl .= '
<table width="90%">
<tr>
<td valign="top"></td>
<td valign="top" align="right"><b>Printed On: </b>' . date('d/m/Y') . '</td>
</tr>
</table>';

$tbl .= '
<table width="90%">
<thead style="border:2px solid black !important;">
<tr>
	<td valign="top" width="80px" align="left"><b>Invoice Date<br>Invoice No.</b></td>
	<td valign="top" width="140px" align="left"><b>Chassis No.<br>Cust. Name</b></td>
	<td valign="top" width="220px" 	><b>Vehicle Name</b></td>
	<td valign="top" align="right" 	width="80px"><b>Invoice<br />Amount</b></td>
	<td valign="top" align="right" 	width="80px"><b>Beginning<br />Balance</b></td>
        <td valign="top" align="right" 	width="80px"><b>Sales</b></td>
	<td valign="top" align="right" 	width="80px"><b>Payment</b></td>
	<td valign="top" align="right" 	width="80px"><b>Discount</b></td>
	<td valign="top" align="right" 	width="80px"><b>Ending<br />Balance</b></td>
	<td valign="top" align="center" width="80px"><b>Due Date</b></td>';

$tbl .= '</tr><thead>';
$tbl .= '<tr><td valign="top"></td></tr>';

$i = 0;
$j = 0;
$last_srep_code = '';
$last_srep_name = '';
$lnQty = 0;
$inv_total = 0;
$pd_begin = 0;
$veh_total = 0;
$pd_paid = 0;
$pd_disc = 0;
$pd_sales = 0;

$lSum = 0;
$sum_inv_total = 0;
$sum_pd_begin = 0;
$sum_inv_total = 0;
$sum_pd_paid = 0;
$sum_pd_begin = 0;
$sum_pd_disc = 0;
$sum_pd_sales = 0;

$pd_end = 0;
$sum_pd_end = 0;

$dat = strtotime($ar_date);

while ($dtlrow = mysql_fetch_array($dtl)) {
    $saldate = strtotime($dtlrow['sal_date']);
    $salexp = explode('-', $dtlrow['sal_date']);
    $salperiode = $salexp[0] . $salexp[1];

    if ($rpt_by == '1') {
        if ($salperiode == $periode) {
            $dtlrow['veh_total'] = $dtlrow['pd_begin'];
            $dtlrow['pd_begin'] = 0;
        } else {
            //$dtlrow['pd_begin'] = $dtlrow['pd_begin']- $dtlrow['pd_paid'];
            $dtlrow['veh_total'] = 0;
        }

        if ($dtlrow['veh_total'] !== 0) {
            $dtlrow['pd_end'] = $dtlrow['veh_total'] - $dtlrow['pd_paid'] - $dtlrow['pd_disc'];
        }
        if ($dtlrow['pd_begin'] !== 0) {
            $dtlrow['pd_end'] = $dtlrow['pd_begin'] - $dtlrow['pd_paid'] - $dtlrow['pd_disc'];
        }
    }

    if ($last_srep_code != $dtlrow['srep_code']) {
        if ($i >= 1) {

            $tbl.= '
			<tr>
				<td valign="top" colspan="3" align="right"><b style="font-size:1.1em;">TOTAL ' . $last_srep_code . ' : ' . $last_srep_name . ':</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($inv_total) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($pd_begin) . '</b></td>
                                <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($pd_sales) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($pd_paid) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($pd_disc) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($pd_end) . '</b></td>
				<td valign="top" align="right"></td>
			</tr>';

            $lnQty = 0;
            $inv_total = 0;
            $pd_begin = 0;
            $pd_paid = 0;
            $pd_end = 0;
            $pd_sales = 0;
        }
        $tbl.= '<tr><td valign="top" colspan="9" align="left"><b style="font-size:1.1em;">*** ' . $dtlrow['srep_code'] . ' : ' . $dtlrow['srep_name'] . ' ***</b></td></tr>';
        $last_srep_code = $dtlrow['srep_code'];
        $last_srep_name = $dtlrow['srep_name'];
    }



    $lnQty++;
    $inv_total += $dtlrow['inv_total'];
    $pd_begin += $dtlrow['pd_begin'];
    $pd_paid += $dtlrow['pd_paid'];
    $pd_disc += $dtlrow['pd_disc'];
    $pd_end += $dtlrow['pd_end'];
    $pd_sales += $dtlrow['veh_total'];

    $lSum++;
    $sum_inv_total += $dtlrow['inv_total'];
    $sum_pd_begin += $dtlrow['pd_begin'];
    $sum_pd_paid += $dtlrow['pd_paid'];
    $sum_pd_disc += $dtlrow['pd_disc'];
    $sum_pd_end += $dtlrow['pd_end'];
    $sum_pd_sales += $dtlrow['veh_total'];

    $sal_date = dateView($dtlrow['sal_date']);
    $due_date = dateView($dtlrow['due_date']);


    $tbl.= '
	<tr>
		<td valign="top" align="left">' . $sal_date . '<br>' . $dtlrow['sal_inv_no'] . '</td>
		<td valign="top" align="left">' . $dtlrow['chassis'] . '<br>' . $dtlrow['cust_name'] . '</td>
		<td valign="top" align="left">' . $dtlrow['veh_name'] . '</td>
		<td valign="top" align="right">' . number_format($dtlrow['inv_total']) . '</td>
		<td valign="top" align="right">' . number_format($dtlrow['pd_begin']) . '</td>
                <td valign="top" align="right">' . number_format($dtlrow['veh_total']) . '</td>
		<td valign="top" align="right">' . number_format($dtlrow['pd_paid']) . '</td>
		<td valign="top" align="right">' . number_format($dtlrow['pd_disc']) . '</td>
		<td valign="top" align="right">' . number_format($dtlrow['pd_end']) . '</td>
		<td valign="top" align="center">' . $due_date . '</td>
	</tr>';

    $i++;
    $j++;
    unset($dtlrow);
}

if ($i >= 1) {

    $tbl.= '
			<tr>
				<td valign="top" colspan="3" align="right"><b style="font-size:1.1em;">TOTAL ' . $last_srep_code . ' : ' . $last_srep_name . ':</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($inv_total) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($pd_begin) . '</b></td>
                                <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($pd_sales) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($pd_paid) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($pd_disc) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($pd_end) . '</b></td>
				<td valign="top" align="right"></td>
			</tr>';

    $lnQty = 0;
    $inv_total = 0;
    $pd_begin = 0;
    $pd_paid = 0;
    $pd_end = 0;
    $pd_sales = 0;
}

$tbl.= '<tr><td valign="top"></td></tr>';
$tbl.= '<tfoot>
	<tr>    
                <td colspan="2"></td>
		<td class="border-foot" style="border-left:2px solid black;border-top:2px solid black;border-bottom:2px solid black;" valign="top"  align="right"><b style="font-size:1.1em;">GRAND TOTAL :</b></td>
		<td class="border-foot" style="border-top:2px solid black;border-bottom:2px solid black;" valign="top" align="right"><b>' . number_format($sum_inv_total) . '</b></td>
		<td class="border-foot" style="border-top:2px solid black;border-bottom:2px solid black;" valign="top" align="right"><b>' . number_format($sum_pd_begin) . '</b></td>
                <td class="border-foot" style="border-top:2px solid black;border-bottom:2px solid black;" valign="top" align="right"><b>' . number_format($sum_pd_sales) . '</b></td>
		<td class="border-foot" style="border-top:2px solid black;border-bottom:2px solid black;" valign="top" align="right"><b>' . number_format($sum_pd_paid) . '</b></td>
		<td class="border-foot" style="border-top:2px solid black;border-bottom:2px solid black;" valign="top" align="right"><b>' . number_format($sum_pd_disc) . '</b></td>
		<td class="border-foot" style="border-right:2px solid black;border-top:2px solid black;border-bottom:2px solid black;" valign="top" align="right"><b>' . number_format($sum_pd_end) . '</b></td>
		<td valign="top" align="right"></td>
	</tr></tfoot>';
$tbl .='
</table>


</div>
';
?>