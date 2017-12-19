<?php

$tbl .= '
<div id="cntr1" align="center">
<table width="100%">
<tr><td valign="top" align="center"><b style="font-size:1.5em;">' . $comp_name . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.5em;">' . $rptTitle . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.1em;">' . $title . '</b></td></tr>
<tr><td valign="top" align="center"><b>DATE : ' . dateView($ap_date) . '</b></td></tr>
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
	<td valign="top" width="80px"><b>Invoice<br />Date</b></td>
	<td valign="top" width="80px"><b>Invoice No.</b></td>
	<td valign="top" width="80px"><b>Supplier<br />Name</b></td>
	<td valign="top" width="80px"><b>Supplier<br />Invoice No.</b></td>
	<td valign="top" width="80px"><b>Supplier<br />Invoice Date</b></td>
	<td valign="top" align="right" 	width="80px"><b>Total<br />Invoice</b></td>
	<td valign="top" align="right" 	width="80px"><b>Beginning<br />Balance</b></td>
	<td valign="top" align="right" 	width="80px"><b>Purchase</b></td>
	<td valign="top" align="right" 	width="80px"><b>Payment</b></td>
	<td valign="top" align="right" 	width="80px"><b>Discount</b></td>
	<td valign="top" align="right" 	width="80px"><b>Ending<br />Balance</b></td>
	<td valign="top" align="right" 	width="80px"><b>Note</b></td>
	<td valign="top" align="right" 	width="80px"><b>Due Date</b></td>';

$tbl .= '</tr></thead>';
$tbl .= '<tr><td></td></tr>';

$last_pur_date = '';
$last_supp_code = '';
$last_supp_name = '';

$i = 0;
$j = 0;
$lnQty = 0;
$lSum = 0;

$inv_total = 0;
$hd_begin = 0;
$hd_purprice = 0;
$hd_paid = 0;
$hd_disc = 0;
$hd_end = 0;

$grp_inv_total = 0;
$grp_hd_begin = 0;
$grp_hd_purprice = 0;
$grp_hd_paid = 0;
$grp_hd_disc = 0;
$grp_hd_end = 0;

$sum_inv_total = 0;
$sum_hd_begin = 0;
$sum_hd_purprice = 0;
$sum_hd_paid = 0;
$sum_hd_disc = 0;
$sum_hd_end = 0;

$dat = strtotime($ap_date);

while ($dtlrow = mysql_fetch_array($dtl)) {

    $purdate = strtotime($dtlrow['pur_date']);
    $purexp = explode('-', $dtlrow['pur_date']);
    $purperiode = $purexp[0] . $purexp[1];

    if ($rpt_type == '1') {
        if ($purperiode == $periode) {
            $dtlrow['hd_purprice'] = $dtlrow['hd_begin'];
            $dtlrow['hd_begin'] = 0;
        } else {
            //$dtlrow['pd_begin'] = $dtlrow['pd_begin']- $dtlrow['pd_paid'];
            $dtlrow['hd_purprice'] = 0;
        }

        if ($dtlrow['hd_purprice'] !== 0) {
            $dtlrow['hd_end'] = $dtlrow['hd_purprice'] - $dtlrow['hd_paid'] - $dtlrow['hd_disc'];
        }
        if ($dtlrow['hd_begin'] !== 0) {
            $dtlrow['hd_end'] = $dtlrow['hd_begin'] - $dtlrow['hd_paid'] - $dtlrow['hd_disc'];
        }
    }

    if ($last_supp_code != $dtlrow['supp_code']) {
        if ($j >= 1) {
            $tbl.= '
			<tr>
				<td valign="top" colspan="5" align="right"><b style="font-size:1.1em;">Total Date ' . dateView($last_pur_date) . ' :</td>
				<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($grp_inv_total) . '</td>
				<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($grp_hd_begin) . '</td>
				<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($grp_hd_purprice) . '</td>
				<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($grp_hd_paid) . '</td>
				<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($grp_hd_disc) . '</td>
				<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($grp_hd_end) . '</td>
				<td></td><td></td>
			</tr>
			<tr><td valign="top" colspan="13"><br></td></tr>';

            $lnQty = 0;
            $j = 0;
            $grp_inv_total = 0;
            $grp_hd_begin = 0;
            $grp_hd_purprice = 0;
            $grp_hd_paid = 0;
            $grp_hd_disc = 0;
            $grp_hd_end = 0;
        }
        if ($i >= 1) {
            $tbl.= '
			<tr>
				<td valign="top" colspan="5" align="right"><b style="font-size:1.1em;">TOTAL  ' . $last_supp_code . ' : ' . $last_supp_name . ' :</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($inv_total) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($hd_begin) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($hd_purprice) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($hd_paid) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($hd_disc) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($hd_end) . '</b></td>
			<td></td><td></td>
			</tr>
			<tr><td valign="top" colspan="13"><br></td></tr>';

            $lnQty = 0;
            $i = 0;


            $inv_total = 0;
            $hd_begin = 0;
            $hd_purprice = 0;
            $hd_paid = 0;
            $hd_disc = 0;
            $hd_end = 0;
        }
        $tbl.= '<tr><td valign="top" colspan="8" align="left"><b style="font-size:1.1em;">*** ' . $dtlrow['supp_code'] . ' ' . $dtlrow['supp_name'] . '***</b></td></tr>';
        $last_supp_code = $dtlrow['supp_code'];
        $last_supp_name = $dtlrow['supp_name'];
        $last_pur_date = $dtlrow['pur_date'];
    }
    if ($last_pur_date != $dtlrow['pur_date']) {
        if ($j >= 1) {
            $tbl.= '
			<tr>
				<td valign="top" colspan="5" align="right"><b style="font-size:1.1em;">Total Date ' . dateView($last_pur_date) . ' :</td>
				<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($grp_inv_total) . '</td>
				<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($grp_hd_begin) . '</td>
				<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($grp_hd_purprice) . '</td>
				<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($grp_hd_paid) . '</td>
				<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($grp_hd_disc) . '</td>
				<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($grp_hd_end) . '</td>
			<td></td><td></td>
			</tr>
			<tr><td valign="top" colspan="13"><br></td></tr>';

            $lnQty = 0;
            $j = 0;
            $grp_inv_total = 0;
            $grp_hd_begin = 0;
            $grp_hd_purprice = 0;
            $grp_hd_paid = 0;
            $grp_hd_disc = 0;
            $grp_hd_end = 0;
        }
        $tbl.= '<tr><td valign="top" colspan="8" align="left"><b style="font-size:1.1em;"> ' . dateView($dtlrow['pur_date']) . '</b> </td></tr>';
        $last_pur_date = $dtlrow['pur_date'];
    }

    $lnQty++;
    $lSum++;

    $inv_total +=$dtlrow['inv_total'];
    $hd_begin +=$dtlrow['hd_begin'];
    $hd_purprice +=$dtlrow['hd_purprice'];
    $hd_paid +=$dtlrow['hd_paid'];
    $hd_disc +=$dtlrow['hd_disc'];
    $hd_end +=$dtlrow['hd_end'];

    $grp_inv_total +=$dtlrow['inv_total'];
    $grp_hd_begin +=$dtlrow['hd_begin'];
    $grp_hd_purprice +=$dtlrow['hd_purprice'];
    $grp_hd_paid +=$dtlrow['hd_paid'];
    $grp_hd_disc +=$dtlrow['hd_disc'];
    $grp_hd_end +=$dtlrow['hd_end'];

    $sum_inv_total +=$dtlrow['inv_total'];
    $sum_hd_begin +=$dtlrow['hd_begin'];
    $sum_hd_purprice +=$dtlrow['hd_purprice'];
    $sum_hd_paid +=$dtlrow['hd_paid'];
    $sum_hd_disc +=$dtlrow['hd_disc'];
    $sum_hd_end +=$dtlrow['hd_end'];

    $pur_date = dateView($dtlrow['pur_date']);
    $due_date = dateView($dtlrow['due_date']);
    $supp_invdt = dateView($dtlrow['supp_invdt']);


    $tbl .='<tr>';
    $tbl .='<td valign="top" align="left">' . $pur_date . '</td>';
    $tbl .='<td valign="top" align="left">' . $dtlrow['pur_inv_no'] . '</td>';
    $tbl .='<td valign="top" align="left">' . $dtlrow['supp_name'] . '</td>';
    $tbl .='<td valign="top" align="left">' . $dtlrow['supp_invno'] . '</td>';
    $tbl .='<td valign="top" align="left">' . $supp_invdt . '</td>';
    $tbl .='<td valign="top" align="right">' . number_format($dtlrow['inv_total']) . '</td>';
    $tbl .='<td valign="top" align="right">' . number_format($dtlrow['hd_begin']) . '</td>';
    $tbl .='<td valign="top" align="right">' . number_format($dtlrow['hd_purprice']) . '</td>';
    $tbl .='<td valign="top" align="right">' . number_format($dtlrow['hd_paid']) . '</td>';
    $tbl .='<td valign="top" align="right">' . number_format($dtlrow['hd_disc']) . '</td>';
    $tbl .='<td valign="top" align="right">' . number_format($dtlrow['hd_end']) . '</td>';
    $tbl .='<td valign="top" align="right">' . $dtlrow['note'] . '</td>';
    $tbl .='<td valign="top" align="right">' . $due_date . '</td>';
    $tbl .='</tr>';


    $i++;
    $j++;
    unset($dtlrow);
}

if ($j >= 1) {
    $tbl.= '
			<tr>
				<td valign="top" colspan="5" align="right"><b style="font-size:1.1em;">Total Date ' . dateView($last_pur_date) . ' :</td>
				<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($grp_inv_total) . '</td>
				<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($grp_hd_begin) . '</td>
				<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($grp_hd_purprice) . '</td>
				<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($grp_hd_paid) . '</td>
				<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($grp_hd_disc) . '</td>
				<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($grp_hd_end) . '</td>
				<td></td><td></td>
			</tr>
			<tr><td valign="top" colspan="13"><br></td></tr>';

    $lnQty = 0;
    $j = 0;
    $grp_inv_total = 0;
    $grp_hd_begin = 0;
    $grp_hd_purprice = 0;
    $grp_hd_paid = 0;
    $grp_hd_disc = 0;
    $grp_hd_end = 0;
}
if ($i >= 1) {
    $tbl.= '
			<tr>
				<td valign="top" colspan="5" align="right"><b style="font-size:1.1em;">TOTAL ' . $last_supp_code . ' : ' . $last_supp_name . ' :</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($inv_total) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($hd_begin) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($hd_purprice) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($hd_paid) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($hd_disc) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($hd_end) . '</b></td>
			<td></td><td></td>
			</tr>
			<tr><td valign="top" colspan="13"><br></td></tr>';

    $lnQty = 0;
    $i = 0;


    $inv_total = 0;
    $hd_begin = 0;
    $hd_purprice = 0;
    $hd_paid = 0;
    $hd_disc = 0;
    $hd_end = 0;
}

$tbl.= '<tr><td><br /></td></tr>';
$tbl.= '<tfoot>
	<tr>
                <td colspan="4"></td>
		<td class="border-foot" style="border-left:2px solid black;border-top:2px solid black;border-bottom:2px solid black;" valign="top" align="right"><b style="font-size:1.1em;">GRAND TOTAL :</b></td>
		<td class="border-foot" style="border-top:2px solid black;border-bottom:2px solid black;" valign="top" align="right"><b>' . number_format($sum_inv_total) . '</b></td>
		<td class="border-foot" style="border-top:2px solid black;border-bottom:2px solid black;" valign="top" align="right"><b>' . number_format($sum_hd_begin) . '</b></td>
		<td class="border-foot" style="border-top:2px solid black;border-bottom:2px solid black;" valign="top" align="right"><b>' . number_format($sum_hd_purprice) . '</b></td>
		<td class="border-foot" style="border-top:2px solid black;border-bottom:2px solid black;" valign="top" align="right"><b>' . number_format($sum_hd_paid) . '</b></td>
		<td class="border-foot" style="border-top:2px solid black;border-bottom:2px solid black;" valign="top" align="right"><b>' . number_format($sum_hd_disc) . '</b></td>
		<td class="border-foot" style="border-right:2px solid black;border-top:2px solid black;border-bottom:2px solid black;" valign="top" align="right"><b>' . number_format($sum_hd_end) . '</b></td>
		<td></td><td></td>
	</tr></tfoot>';
$tbl .='</table></div>';
?>