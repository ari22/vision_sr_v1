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
	<td valign="top" align="left" width="70px"><b>PO Date</b></td>
	<td valign="top" align="left" width="80px"><b>PO No.</b></td>
	<td valign="top" align="left" width="120px" ><b>Supplier Name</b></td>
	<td valign="top" align="left" width="220px"><b>Vehicle Name</b></td>
	<td valign="top" align="left" width="50px"><b>Color<br />Code</b></td>
	<td valign="top" align="right" width="80px"><b>Price</b></td>
	<td valign="top" align="right" width="80px"><b>Beginning<br />DP Balance</b></td>
	<td valign="top" align="right" width="80px"><b>DP</b></td>
	<td valign="top" align="right" width="80px"><b>Account Payable Payment</b></td>
	<td valign="top" align="right" width="80px"><b>Ending<br />Balance</b></td>
	<td valign="top" align="right" width="80px"><b>Note</b></td>
</tr></thead>
';
$tbl .='<tr><td valign="top"></td></tr>';
$i = 0;
$last_dp_date = '';
$lnQty = 0;

$sum_qty = 0;
$sum_veh_price = 0;
$sum_dp_begin = 0;
$sum_dp_paid = 0;
$sum_dp_used = 0;
$sum_dp_end = 0;

while ($dtlrow = mysql_fetch_array($dtl)) {

    $lnQty++;
    $sum_qty++;


    $sum_veh_price +=$dtlrow['veh_price'];
    $sum_dp_begin +=$dtlrow['dp_begin'];
    $sum_dp_paid +=$dtlrow['dp_paid'];
    $sum_dp_used +=$dtlrow['dp_used'];
    $sum_dp_end +=($dtlrow['dp_begin'] + $dtlrow['dp_paid']) - $dtlrow['dp_used'];

    $po_date = dateView($dtlrow['po_date']);
    $dp_date = dateView($dtlrow['dp_date']);

    $tbl.= '
	<tr>
		<td valign="top" align="left">' . $po_date . '</td>
		<td valign="top" align="left">' . $dtlrow['po_no'] . '</td>
		<td valign="top" align="left">' . $dtlrow['supp_name'] . '</td>
		<td valign="top" align="left">' . $dtlrow['veh_name'] . '</td>
		<td valign="top" align="left">' . $dtlrow['color_code'] . '</td>
		<td valign="top" align="right">' . number_format($dtlrow['veh_price']) . '</td>
		<td valign="top" align="right">' . number_format($dtlrow['dp_begin']) . '</td>
                <td valign="top" align="right">' . number_format($dtlrow['dp_paid']) . '</td>';
    $tbl .= '
		<td valign="top" align="right">' . number_format($dtlrow['dp_used']) . '</td>
		<td valign="top" align="right">' . number_format(($dtlrow['dp_begin'] + $dtlrow['dp_paid']) - $dtlrow['dp_used']) . '</td>
		<td valign="top" align="right">' . $dtlrow['note'] . '</td>
	</tr>';
    $i++;
    unset($dtlrow);
}


$tbl.= '<tr><td valign="top"><br></td></tr>
<tr height="30px">
				<td valign="top" colspan="3"></td>
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