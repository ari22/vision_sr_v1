<?php

//========CHANGE LOG=============
//ganti semua <td jadi <td valign="top"
//engine => engine No.;chassis => Chassis No.

$tbl .= '
<div id="cntr1" align="center">
<table width="80%">
<tr><td valign="top" align="center"><b style="font-size:1.5em;">' . $comp_name . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.5em;">' . $rptTitle . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.1em;">' . $title . '</b></td></tr>
<tr><td valign="top" align="center"><b>DATE : ' . $ap_date . '</b></td></tr>
</table>
';


$tbl .= '
<table width="80%">
<tr>
<td valign="top"></td>
<td valign="top" align="right"><b>Printed On: </b>' . date('d/m/Y') . '</td>
</tr>
</table>';

$tbl .= '
<table width="80%">
<thead style="border:2px solid black !important;">
<tr>
	<td class="border-head" valign="top" align="left" 	width="100px" 	 ><b>Invoice Date<br>Invoice No.</b></td>
	<td class="border-head" valign="top" align="left" 	width="140px" 	 ><b>Chassis No.<br>Engine No.</b></td>
	<td class="border-head" valign="top" align="left" 	width="220px" 	 ><b>Vehicle Name</b></td>
	<td class="border-head" valign="top" align="right" 	width="80px" 	 ><b>Total<br>Invoice</b></td>
	<td class="border-head" valign="top" align="right" 	width="80px" 	 ><b>Beginning<br />Balance</b></td>
	<td class="border-head" valign="top" align="right" 	width="80px" 	 ><b>Payment</b></td>
	<td class="border-head" valign="top" align="right" 	width="80px" 	 ><b>Discount</b></td>
	<td class="border-head" valign="top" align="right" 	width="80px" 	 ><b>Ending<br />Balance</b></td>
	<td class="border-head" valign="top" align="center" 	width="80px" 	 ><b>Due Date</b></td>';

$tbl .= '</tr><thead>';
$tbl .= '<tr><td valign="top"></td></tr>';

$i = 0;
$j = 0;
$last_supp_code = '';
$last_supp_name = '';
$last_pur_date = '';
$lnQty = 0;
$inv_total = 0;
$hd_begin = 0;
$hd_paid = 0;
$hd_disc = 0;
$grp_inv_total = 0;
$grp_hd_begin = 0;
$grp_hd_paid = 0;
$grp_hd_disc = 0;

$lSum = 0;
$sum_inv_total = 0;
$sum_hd_begin = 0;
$sum_inv_total = 0;
$sum_hd_paid = 0;
$sum_hd_begin = 0;
$sum_hd_disc = 0;

$qty = 1;
$sumqty = 0;

while ($dtlrow = mysql_fetch_array($dtl)) {
    if ($dtlrow['hd_paid'] < 0) {
        $dtlrow['hd_paid'] = 0;
    }
    if ($rpt_by == '2') {
        $dtlrow['hd_paid'] = 0;
        $dtlrow['hd_disc'] = 0;
    }

    if ($last_supp_code != $dtlrow['supp_code']) {
        if ($j >= 1) {
            $tbl.= '
			<tr>
				<td valign="top" colspan="3" align="right"><b style="font-size:1.1em;">Total Date ' . dateView($last_pur_date) . ':</td>
				<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($grp_inv_total) . '</td>
				<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($grp_hd_begin) . '</td>
				<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($grp_hd_paid) . '</td>
				<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($grp_hd_disc) . '</td>
				<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($grp_hd_begin - $grp_hd_paid - $grp_hd_disc) . '</td>
			</tr><tr><td valign="top"><br></td></tr>';

            $lnQty = 0;
            $grp_inv_total = 0;
            $grp_hd_begin = 0;
            $grp_hd_paid = 0;
            $grp_hd_disc = 0;
            $j = 0;
        }
        if ($i >= 1) {
            $tbl.= '
			<tr>
				<td valign="top" colspan="3" align="right"><b style="font-size:1.1em;">TOTAL ' . $last_supp_code . ' : ' . $last_supp_name . ':</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($inv_total) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($hd_begin) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($hd_paid) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($hd_disc) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($hd_begin - $hd_paid - $hd_disc) . '</b></td>
			</tr><tr><td valign="top"><br></td></tr>';

            $lnQty = 0;
            $inv_total = 0;
            $hd_begin = 0;
            $hd_paid = 0;
            $hd_disc = 0;
        }
        $tbl.= '<tr><td valign="top" colspan="8" align="left"><b style="font-size:1.1em;">*** Supplier ' . $dtlrow['supp_code'] . ' : ' . $dtlrow['supp_name'] . ' ***</b></td></tr>';
        $last_supp_code = $dtlrow['supp_code'];
        $last_supp_name = $dtlrow['supp_name'];
    }
    if ($last_pur_date != $dtlrow['pur_date']) {
        if ($j >= 1) {
            $tbl.= '
			<tr>
				<td valign="top" colspan="3" align="right"><b style="font-size:1.1em;">Total Date ' . dateView($last_pur_date) . ':</td>
				<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($grp_inv_total) . '</td>
				<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($grp_hd_begin) . '</td>
				<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($grp_hd_paid) . '</td>
				<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($grp_hd_disc) . '</td>
				<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($grp_hd_begin - $grp_hd_paid - $grp_hd_disc) . '</td>
			</tr><tr><td valign="top"><br></td></tr>';

            $lnQty = 0;
            $grp_inv_total = 0;
            $grp_hd_begin = 0;
            $grp_hd_paid = 0;
            $j = 0;
        }
        $tbl.= '<tr><td valign="top" colspan="8" align="left"><b style="font-size:1.1em;">Date ' . dateView($dtlrow['pur_date']) . '</b></td></tr>';
        $last_pur_date = $dtlrow['pur_date'];
    }

    $sumqty += $qty;
    $lnQty++;
    $inv_total += $dtlrow['inv_total'];
    $hd_begin += $dtlrow['hd_begin'];
    $hd_paid += $dtlrow['hd_paid'];
    $hd_disc += $dtlrow['hd_disc'];

    $grp_inv_total += $dtlrow['inv_total'];
    $grp_hd_begin += $dtlrow['hd_begin'];
    $grp_hd_paid += $dtlrow['hd_paid'];
    $grp_hd_disc += $dtlrow['hd_disc'];

    $lSum++;
    $sum_inv_total += $dtlrow['inv_total'];
    $sum_hd_begin += $dtlrow['hd_begin'];
    $sum_hd_paid += $dtlrow['hd_paid'];
    $sum_hd_disc += $dtlrow['hd_disc'];

    $pur_date = dateView($dtlrow['pur_date']);
    $due_date = dateView($dtlrow['due_date']);

    $tbl.= '
	<tr>
		<td valign="top" align="left">' . $pur_date . '<br>' . $dtlrow['pur_inv_no'] . '</td>
		<td valign="top" align="left">' . $dtlrow['chassis'] . '<br>' . $dtlrow['engine'] . '</td>
		<td valign="top" align="left">' . $dtlrow['veh_name'] . '</td>
		<td valign="top" align="right">' . number_format($dtlrow['inv_total']) . '</td>
		<td valign="top" align="right">' . number_format($dtlrow['hd_begin']) . '</td>
		<td valign="top" align="right">' . number_format($dtlrow['hd_paid']) . '</td>
		<td valign="top" align="right">' . number_format($dtlrow['hd_disc']) . '</td>
		<td valign="top" align="right">' . number_format($dtlrow['hd_begin'] - $dtlrow['hd_paid'] - $dtlrow['hd_disc']) . '</td>
		<td valign="top" align="center">' . $due_date . '</td>';

    $i++;
    $j++;
    unset($dtlrow);
}

if ($j >= 1) {
    $tbl.= '
	<tr>
		<td valign="top" colspan="3" align="right"><b style="font-size:1.1em;">Total Date ' . dateView($last_pur_date) . ':</td>
		<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($grp_inv_total) . '</td>
		<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($grp_hd_begin) . '</td>
		<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($grp_hd_paid) . '</td>
		<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($grp_hd_disc) . '</td>
		<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($grp_hd_begin - $grp_hd_paid - $grp_hd_disc) . '</td>
	</tr><tr><td valign="top"><br></td></tr>';

    $lnQty = 0;
    $grp_inv_total = 0;
    $grp_hd_begin = 0;
    $grp_hd_paid = 0;
    $j = 0;
}

if ($i >= 1) {
    $tbl.= '
			<tr>
				<td valign="top" colspan="3" align="right"><b style="font-size:1.1em;">TOTAL ' . $last_supp_code . ' : ' . $last_supp_name . ':</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($inv_total) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($hd_begin) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($hd_paid) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($hd_disc) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($hd_begin - $hd_paid - $hd_disc) . '</b></td>
			</tr><tr><td valign="top"><br></td></tr>';

    $lnQty = 0;
}
$tbl.= '<tfoot>
	<tr>
                <td colspan="2"></td>
		<td class="border-foot" style="border-left:2px solid black;" valign="top" align="right"><b style="font-size:1.1em;">GRAND TOTAL :</b></td>
		<td class="border-foot" valign="top" align="right"><b>' . number_format($sum_inv_total) . '</b></td>
		<td class="border-foot" valign="top" align="right"><b>' . number_format($sum_hd_begin) . '</b></td>
		<td class="border-foot" valign="top" align="right"><b>' . number_format($sum_hd_paid) . '</b></td>
		<td class="border-foot" valign="top" align="right"><b>' . number_format($sum_hd_disc) . '</b></td>
		<td class="border-foot" valign="top" align="right"><b>' . number_format($sum_hd_begin - $sum_hd_paid - $sum_hd_disc) . '</b></td>
		<td class="border-foot"style="border-right:2px solid black;" valign="top" align="right" style="border-top:1px solid black;"><b>Qty : ' . $sumqty . ' Unit</b></td>
	</tr></tfoot>';
$tbl .='
</table>


</div>
';
?>