<?php
//========CHANGE LOG=============
//ganti semua <td jadi <td valign="top"
//ganti tanggal d judul
//footer dibuang
//Nominal => Invoice<br />Amount
//Tanggal => Date di Judul
$tbl .= '
<div id="cntr1" align="center">
<table width="100%">
<tr><td valign="top" align="center"><b style="font-size:1.5em;">'.$comp_name.'</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.5em;">'.$rptTitle.'</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.1em;">'.$title.'</b></td></tr>
<tr><td valign="top" align="center"><b>DATE : '.$pay_date1.' UP TO '.$pay_date2.'</b></td></tr>
</table>';


$tbl .= '
<table width="100%"  >
<tr>
<td valign="top"></td>
<td valign="top" align="right"><b>Printed On: </b>' . date('d/m/Y') . '</td>
</tr>
</table>';

$tbl .= '<table width="100%">';
$tbl .= '<thead style="border:2px solid black !important;">
<tr>
	<td valign="top" align="center" 	width="70px"><b>Pay Date</b></td>
	<td valign="top" align="left" 	width="100px"><b>Invoice No.<br />Invoice Date</b></td>
	<td valign="top" align="left" 	width="100px"><b>PO No.<br />PO Date</b></td>
	<td valign="top" align="center" 	width="140px"><b>Chassis</b></td>
	<td valign="top" align="right" 	width="80px"><b>Vehicle Price</b></td>
	<td valign="top" align="right" 	width="80px"><b>Payment</b></td>
	<td valign="top" align="right" 	width="80px"><b>Discount</b></td>
	<td valign="top" align="right" 	width="80px"><b>Payment<br>Type</b></td>
                <td valign="top" align="left"><b>Bank</b></td>
	<td valign="top" align="left" 	width="80px"><b>Check No.</b></td>
	<td valign="top" align="center" 	width="80px"><b>Check Date</b></td>
	<td valign="top" align="center" 	width="80px"><b>Due Date</b></td>
	<td valign="top" align="left" 	width="80px"><b>Note</b></td>
	<td valign="top" align="left" 	width="80px"><b>Added<br>By</b></td>';

$tbl .= '</tr></thead>';
$tbl .= '<tr><td valign="top"></td></tr>';
$i=0;
$j=0;
$last_supp_code ='';
$last_supp_name ='';
$last_pay_date='';
$lnQty = 0;
$hd_paid = 0;
$hd_disc = 0;
$inv_total=0;
$lSum = 0;
$grp_hd_paid = 0;
$grp_hd_disc = 0;
$sum_hd_paid = 0;
$sum_hd_disc = 0;
$sum_inv_total =0;
while($dtlrow=mysql_fetch_array($dtl)){


	if ($last_pay_date != $dtlrow['pay_date'])
	{
		if ($i>=1)
		{

			$tbl.= '
			<tr>
				<td valign="top" colspan="4" align="right"><b style="font-size:1.1em;">TOTAL '.dateView($last_pay_date).':</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;">'.number_format($inv_total).'</td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>'.number_format($hd_paid).'</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>'.number_format($hd_disc).'</b></td>

			</tr><tr><td valign="top"><br></td></tr>';

			$lnQty = 0;  $hd_paid = 0; $hd_disc = 0;
		}
		$tbl.= '<tr><td valign="top" colspan="8" align="left"><b style="font-size:1.1em;">*** Date '.dateView($dtlrow['pay_date']).' ***</b></td></tr>';
		$last_pay_date = $dtlrow['pay_date'];
	}
	$lnQty++;  $hd_paid += $dtlrow['dp_paid'];  $hd_disc += $dtlrow['dp_disc']; $inv_total += $dtlrow['veh_price'];
	$lSum++;  $sum_hd_paid += $dtlrow['dp_paid']; $sum_hd_disc += $dtlrow['dp_disc']; $sum_inv_total += $dtlrow['veh_price'];


        $pay_date = dateView($dtlrow['pay_date']);
	$due_date = dateView($dtlrow['due_date']);
	$check_date = dateView($dtlrow['check_date']);

	$tbl.= '
	<tr>
		<td valign="top" align="left">'.$pay_date.'</td>
		<td valign="top" align="left">'.$dtlrow['dp_inv_no'].'<br>'.dateView($dtlrow['dp_date']).'</td>
		<td valign="top" align="left">'.$dtlrow['po_no'].'<br>'.dateView($dtlrow['po_date']).'</td>
		<td valign="top" align="left">'.$dtlrow['chassis'].'</td>
		<td valign="top" align="right">'.number_format($dtlrow['veh_price']).'</td>
		<td valign="top" align="right">'.number_format($dtlrow['dp_paid']).'</td>
		<td valign="top" align="right">'.number_format($dtlrow['dp_disc']).'</td>
		<td valign="top" align="right">'.$dtlrow['pay_type'].'</td>
                <td valign="top" align="left">'.$dtlrow['bank_code'].'</td>
		<td valign="top" align="left">'.$dtlrow['check_no'].'</td>
		<td valign="top" align="center">'.$check_date.'</td>
		<td valign="top" align="center">'.$due_date.'</td>
		<td valign="top" align="left">'.$dtlrow['pay_desc'].'</td>
		<td valign="top" align="left">'.$dtlrow['add_by'].'</td>';

$i++;
$j++;
	unset($dtlrow);
}
if ($i>=1)
{
	if ($i>=1)
		{

			$tbl.= '
			<tr>
				<td valign="top" colspan="4" align="right"><b style="font-size:1.1em;">TOTAL '.dateView($last_pay_date).':</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;">'.number_format($inv_total).'</td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>'.number_format($hd_paid).'</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>'.number_format($hd_disc).'</b></td>

			</tr><tr><td valign="top"><br></td></tr>';

			$lnQty = 0;  $hd_paid = 0; $hd_disc = 0;
		}
}
$tbl.= '<tr><td valign="top"><br><br></td></tr>
        <tfoot>
	<tr>    
                <td colspan="3"></td>
		<td style="border-left:2px solid black;border-top:2px solid black;border-bottom:2px solid black;" valign="top" align="right"><b style="font-size:1.1em;">GRAND TOTAL :</b></td>
		<td style="border-top:2px solid black;border-bottom:2px solid black;" valign="top" align="right">'.number_format($sum_inv_total).'</td>
		<td style="border-top:2px solid black;border-bottom:2px solid black;" valign="top" align="right"><b>'.number_format($sum_hd_paid).'</b></td>
		<td style="border-right:2px solid black;border-top:2px solid black;border-bottom:2px solid black;" valign="top" align="right"><b>'.number_format($sum_hd_disc).'</b></td>

	</tr></tfoot>';
$tbl .='
</table>


</div>
';
?>