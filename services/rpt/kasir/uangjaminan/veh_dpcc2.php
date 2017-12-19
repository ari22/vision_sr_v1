<?php

//========CHANGE LOG=============
//ganti semua <td jadi <td valign="top"
//footer dibuang
//Invoice<br />Date UJ => DP Invoice Date
//Invoice<br />No. UJ => DP Invoice No.
//Payment<br />Accounts Receivable => Accounts Receivable Payment
//format tanggal
//Date UJ => DP Date

$tbl .= '
<div id="cntr1" align="center">
<table width="100%">
<tr><td valign="top" align="center"><b style="font-size:1.5em;">' . $comp_name . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.5em;">' . $rptTitle . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.1em;">' . $title . '</b></td></tr>
<tr><td valign="top" align="center"><b>DATE : ' . dateView($ar_date) . '</b></td></tr>
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
<thead style="border:2px solid black !important;">
<tr>
	<td valign="top" align="left" width="60px"><b>DP Invoice Date</b></td>
	<td valign="top" align="left" width="100px"><b>DP Invoice No.</b></td>
	<td valign="top" align="left"><b>SPK Date</b></td>
	<td valign="top" align="left" width="100px"><b>SPK No.</b></td>
	<td valign="top" align="left" ><b>Customer Name</b></td>
	<td valign="top" align="left" width="220px"><b>Vehicle Name</b></td>
	<td valign="top" align="left" ><b>Color<br />Code</b></td>
	<td valign="top" align="right" width="80px"><b>Price</b></td>
	<td valign="top" align="right" width="80px"><b>Beginning<br />DP Balance</b></td>
	<td valign="top" align="right" width="80px"><b>DP</b></td>
	<td valign="top" align="right" width="80px"><b>Account Receivable Payment</b></td>
	<td valign="top" align="right" width="80px"><b>Ending<br />Balance</b></td>
	<td valign="top" align="right" width="80px"><b>Note</b></td>
</tr></thead>
';
$tbl .='<tr><td valign="top"></td></tr>';
$i = 0;
$last_cust_type = '';
$last_dp_date = '';
$lnQty = 0;

$sum_qty = 0;

$veh_price = 0;
$dp_begin = 0;
$dp_paid = 0;
$dp_used = 0;
$dp_end = 0;

$sum_veh_price = 0;
$sum_dp_begin = 0;
$sum_dp_paid = 0;
$sum_dp_used = 0;
$sum_dp_end = 0;

while ($dtlrow = mysql_fetch_array($dtl)) {
    /*if ($rpt_by == '2') {
        if ($dtlrow['dp_used'] !== '0') {
            $dtlrow['dp_used'] = $dtlrow['dp_used'] - $dtlrow['dp_begin'];
            $dtlrow['dp_begin'] = 0;
        }
    }*/
    if ($last_cust_type != $dtlrow['cust_type']) {
        if ($i >= 1) {

            $tbl.= '
                        <tr height="30px">
				<td valign="top" colspan="5"></td>
				<td valign="top" colspan="2" align="right" style="border-top:1px solid black;"><b style="font-size:1.1em;">Total Customer DP : </b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($veh_price) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($dp_begin) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($dp_paid) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($dp_used) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($dp_end) . '</b></td>
				<td valign="top"></td>
			</tr>';
            $i = 0;
            $veh_price = 0;
            $dp_begin = 0;
            $dp_paid = 0;
            $dp_used = 0;
            $dp_end = 0;
        }
        $last_cust_type = $dtlrow['cust_type'];
    }

    $lnQty++;
    $sum_qty++;


    $veh_price +=$dtlrow['veh_price'];
    $dp_begin +=$dtlrow['dp_begin'];
    $dp_paid +=$dtlrow['dp_paid'];
    $dp_used +=$dtlrow['dp_used'];
    $dp_end +=$dtlrow['dp_end'];


    $sum_veh_price +=$dtlrow['veh_price'];
    $sum_dp_begin +=$dtlrow['dp_begin'];
    $sum_dp_paid +=$dtlrow['dp_paid'];
    $sum_dp_used +=$dtlrow['dp_used'];
    $sum_dp_end +=$dtlrow['dp_end'];

    $so_date = dateView($dtlrow['so_date']);
    $dp_date = dateView($dtlrow['dp_date']);

    $tbl.= '
	<tr>
		<td valign="top" align="left">' . $dp_date . '</td>
		<td valign="top" align="left">' . $dtlrow['dp_inv_no'] . '</td>
		<td valign="top" align="left">' . $so_date . '</td>
		<td valign="top" align="left">' . $dtlrow['so_no'] . '</td>
		<td valign="top" align="left">' . $dtlrow['cust_name'] . '</td>
		<td valign="top" align="left">' . $dtlrow['veh_name'] . '</td>
		<td valign="top" align="left">' . $dtlrow['color_code'] . '</td>
		<td valign="top" align="right">' . number_format($dtlrow['veh_price']) . '</td>
		<td valign="top" align="right">' . number_format($dtlrow['dp_begin']) . '</td>
                <td valign="top" align="right">' . number_format($dtlrow['dp_paid']) . '</td>';
    $tbl .= '
		<td valign="top" align="right">' . number_format($dtlrow['dp_used']) . '</td>
		<td valign="top" align="right">' . number_format($dtlrow['dp_end']) . '</td>
		<td valign="top" align="right">' . $dtlrow['note'] . '</td>
	</tr>';
    $i++;
    unset($dtlrow);
}

if ($i >= 1) {

    $tbl.= '
                        <tr height="30px">
				<td valign="top" colspan="5"></td>
				<td valign="top" colspan="2" align="right" style="border-top:1px solid black;"><b style="font-size:1.1em;">Total Customer DP : </b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($veh_price) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($dp_begin) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($dp_paid) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($dp_used) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($dp_end) . '</b></td>
				<td valign="top"></td>
			</tr>';
    $i = 0;
    $veh_price = 0;
    $dp_begin = 0;
    $dp_paid = 0;
    $dp_used = 0;
    $dp_end = 0;
}
$tbl.= '<tr><td valign="top"><br></td></tr>
<tr height="30px">
				<td valign="top" colspan="5"></td>
				<td class="border-foot" valign="top" colspan="2" align="right" style="border-left:2px solid black;border-top:2px solid black;border-bottom:2px solid black;" ><b style="font-size:1.1em;">GRAND TOTAL :</b></td>
				<td class="border-foot" valign="top" align="right" style="border-top:2px solid black;border-bottom:2px solid black;"><b>' . number_format($sum_veh_price) . '</b></td>
				<td class="border-foot" valign="top" align="right" style="border-top:2px solid black;border-bottom:2px solid black;"><b>' . number_format($sum_dp_begin) . '</b></td>
				<td class="border-foot" valign="top" align="right" style="border-top:2px solid black;border-bottom:2px solid black;"><b>' . number_format($sum_dp_paid) . '</b></td>
				<td class="border-foot" valign="top" align="right" style="border-top:2px solid black;border-bottom:2px solid black;"><b>' . number_format($sum_dp_used) . '</b></td>
				<td class="border-foot" valign="top" align="right" style="border-right:2px solid black;border-top:2px solid black;border-bottom:2px solid black;"><b>' . number_format($sum_dp_end) . '</b></td>
				<td valign="top"></td>
			</tr>';

$tbl .='
</table>
</div>
';
?>