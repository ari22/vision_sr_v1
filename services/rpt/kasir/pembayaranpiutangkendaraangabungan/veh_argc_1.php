<?php
//========CHANGE LOG=============
//ganti semua <td jadi <td valign="top"
//ganti tanggal d judul
//footer dibuang
//judul pertama tadinya ga kluar
//Nominal<br>Invoice => Invoice<br />Amount

$tbl .= '
<div id="cntr1" align="center">
<table width="100%">
<tr><td valign="top" align="center"><b style="font-size:1.5em;">'.$comp_name.'</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.5em;">'.$rptTitle.'</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.1em;">'.$title.'</b></td></tr>
<tr><td valign="top" align="center"><b>DATE : '.  dateView($arg_date1).' UP TO '.dateView($arg_date2).'</b></td></tr>
</table>
';


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
	<td valign="top" align="center" 	width="70px"><b>Payment<br>Date</b></td>
	<td valign="top" align="left" 	width="100px"><b>Invoice No.</b></td>
	<td valign="top" align="center" 	width="100px"><b>Invoice Date</b></td>
	<td valign="top" align="center" 	width="140px"><b>Chassis No.</b></td>
	<td valign="top" align="right" 	width="80px"><b>Invoice<br />Amount</b></td>
	<td valign="top" align="right" 	width="80px"><b>Payment</b></td>
	<td valign="top" align="right" 	width="80px"><b>Discount</b></td>
	<td valign="top" align="right" 	width="80px"><b>Payment<br />Type</b></td>
                <td valign="top" align="left" width="80"><b>Bank</b></td>
	<td valign="top" align="left" 	width="80px"><b>Check No.</b></td>
	<td valign="top" align="center" 	width="80px"><b>Check Date</b></td>
	<td valign="top" align="center" 	width="80px"><b>Due Date</b></td>
	<td valign="top" align="left" 	width="80px"><b>Note</b></td>
	<td valign="top" align="left" 	width="80px"><b>Added<br>By</b></td>';

$tbl .= '</tr></thead>';
$tbl .= '<tr><td valign="top"></td></tr>';

$i=0;
$j=0;
$last_cust_code ='';
$last_cust_name ='';
$last_arg_date='';
$lnQty = 0;
$pd_paid = 0;
$pd_disc = 0;
$inv_total=0;
$lSum = 0;
$grp_pd_paid = 0;
$grp_pd_disc = 0;
$sum_pd_paid = 0;
$sum_pd_disc = 0;
$sum_inv_total =0;
while($dtlrow=mysql_fetch_array($dtl)){


	if ($last_arg_date != $dtlrow['arg_date'])
	{
		if ($i>=1)
		{

			$tbl.= '
			<tr>
				<td valign="top" colspan="4" align="right"><b style="font-size:1.1em;">TOTAL '.dateView($last_arg_date).':</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;">'.number_format($inv_total).'</td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>'.number_format($pd_paid).'</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>'.number_format($pd_disc).'</b></td>

			</tr><tr><td valign="top"><br></td></tr>';

			$lnQty = 0;  $pd_paid = 0; $pd_disc = 0;
		}
		$tbl.= '<tr><td valign="top" colspan="8" align="left"><b style="font-size:1.1em;">*** Tanggal '.dateView($dtlrow['arg_date']).' ***</td></tr>';
		$last_arg_date = $dtlrow['arg_date'];

	}
	$lnQty++;  $pd_paid += $dtlrow['pd_paid'];  $pd_disc += $dtlrow['pd_disc']; $inv_total += $dtlrow['inv_total'];
	$lSum++;  $sum_pd_paid += $dtlrow['pd_paid']; $sum_pd_disc += $dtlrow['pd_disc']; $sum_inv_total += $dtlrow['inv_total'];

        $arg_date = dateView($dtlrow['arg_date']);
	$due_date = dateView($dtlrow['due_date']);
	$check_date = dateView($dtlrow['check_date']);

	$tbl.= '
	<tr>
		<td valign="top" align="left">'.$arg_date.'</td>
		<td valign="top" align="left">'.$dtlrow['arg_inv_no'].'</td>
		<td valign="top" align="left">'.$dtlrow['sal_inv_no'].'<br>'.dateView($dtlrow['sal_date']).'</td>
		<td valign="top" align="left">'.$dtlrow['chassis'].'</td>
		<td valign="top" align="right">'.number_format($dtlrow['inv_total']).'</td>
		<td valign="top" align="right">'.number_format($dtlrow['pd_paid']).'</td>
		<td valign="top" align="right">'.number_format($dtlrow['pd_disc']).'</td>
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

		$tbl.= '
		<tr>
			<td valign="top" colspan="4" align="right"><b style="font-size:1.1em;">TOTAL '.dateView($last_arg_date).':</b></td>
			<td valign="top" align="right" style="border-top:1px solid black;">'.number_format($inv_total).'</td>
			<td valign="top" align="right" style="border-top:1px solid black;"><b>'.number_format($pd_paid).'</b></td>
			<td valign="top" align="right" style="border-top:1px solid black;"><b>'.number_format($pd_disc).'</b></td>

		</tr><tr><td valign="top"><br></td></tr>';

		$lnQty = 0;  $pd_paid = 0; $pd_disc = 0;
	}

$tbl.= '<tr><td valign="top"><br><br></td></tr>
        <tfoot>
	<tr>
                <td colspan="3"></td>
		<td class="border-foot" style="border-left:2px solid black;border-top:2px solid black;border-bottom:2px solid black;" valign="top" align="right"><b style="font-size:1.1em;">GRAND TOTAL :</b></td>
		<td class="border-foot" style="border-top:2px solid black;border-bottom:2px solid black;" valign="top" align="right">'.number_format($sum_inv_total).'</td>
		<td class="border-foot" style="border-top:2px solid black;border-bottom:2px solid black;" valign="top" align="right"><b>'.number_format($sum_pd_paid).'</b></td>
		<td class="border-foot" style="border-right:2px solid black;border-top:2px solid black;border-bottom:2px solid black;" valign="top" align="right"><b>'.number_format($sum_pd_disc).'</b></td>

	</tr></tfoot>';
$tbl .='
</table>


</div>
';

?>