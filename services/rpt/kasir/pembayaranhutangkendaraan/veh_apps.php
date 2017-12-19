<?php
//========CHANGE LOG=============
//ganti semua <td jadi <td valign="top"
//chassis => Chassis No.
//Customer => Supplier di judul

$tbl .= '
<div id="cntr1" align="center">
<table width="100%">
<tr><td valign="top" align="center"><b style="font-size:1.5em;">'.$comp_name.'</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.5em;">'.$rptTitle.'</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.1em;">'.$title.'</b></td></tr>
<tr><td valign="top" align="center"><b>'.$pay_date1.' UP TO '.$pay_date2.'</b></td></tr>
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
	<td valign="top" align="left" width="70"><b>Payment<br />Date</b></td>
	<td valign="top" align="left" width="80"><b>Invoice No.</b></td>
	<td valign="top" align="left" width="70"><b>Invoice<br />Date</b></td>
	<td valign="top" align="left" width="130"><b>Chassis No.<br />Engine</b></td>
	<td valign="top" align="left" width="160"><b>Vehicle Name</b></td>
	<td valign="top" align="right" width="80"><b>Payment</b></td>
	<td valign="top" align="right" width="80"><b>Discount</b></td>
	<td valign="top" align="left" width="60"><b>Payment<br />Type</b></td>
	<td valign="top" align="left" width="60"><b>Check No.</b></td>
	<td valign="top" align="left" width="70"><b>Check Date</b></td>
	<td valign="top" align="left" width="70"><b>Due Date</b></td>
	<td valign="top" align="left" width="60"><b>Bank Code</b></td>
	<td valign="top" align="left" width="120"><b>Note</b></td>';

$tbl .= '</tr></thead>';
$tbl .= '<tr><td valign="top"></td></tr>';

$i=0;
$j=0;
$last_supp_code ='';
$last_supp_name ='';
$last_pay_date = '';

$lnQty = 0;
$pay_val = 0;
$disc_val = 0;

$lSum = 0;
$grp_pay_val = 0;
$grp_disc_val =0;

$sum_pay_val = 0;
$sum_disc_val = 0;
while($dtlrow=mysql_fetch_array($dtl)){


if ($last_supp_code != $dtlrow['supp_code'])
	{
		if ($j>=1)
		{
			$tbl.= '
			<tr>
				<td valign="top" colspan="5" align="right"><b style="font-size:1.1em;">TOTAL '.dateView($last_pay_date).' :</td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>'.number_format($grp_pay_val).'</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>'.number_format($grp_disc_val).'</b></td>

			</tr><tr><td valign="top"><br></td></tr>';

			$lnQty = 0; $grp_pay_val = 0; $grp_disc_val = 0;  $j=0;
		}
		if ($i>=1)
		{

			$tbl.= '
			<tr>
				<td valign="top" colspan="5" align="right"><b style="font-size:1.1em;">TOTAL '.$last_supp_code.' : '.$last_supp_name.':</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>'.number_format($pay_val).'</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>'.number_format($disc_val).'</b></td>

			</tr><tr><td valign="top"><br></td></tr>';

			$lnQty = 0;  $pay_val = 0; $disc_val = 0;
		}
		$tbl.= '<tr><td valign="top" colspan="8" align="left"><b style="font-size:1.1em;">*** Supplier '.$dtlrow['supp_code'].' : '.$dtlrow['supp_name'].' ***</b></td></tr>';
		$last_supp_code = $dtlrow['supp_code'];
		$last_supp_name = $dtlrow['supp_name'];
        
		$tbl.= '<tr><td valign="top" colspan="8" align="left" style="font-size:1.1em;"><b>Date '.dateView($dtlrow['pur_date']).'</b></td></tr>';
		$last_pay_date = $dtlrow['pay_date'];
	}
	if ($last_pay_date != $dtlrow['pay_date'])
	{
		if ($j>=1)
		{
			$tbl.= '
			<tr>
				<td valign="top" colspan="5" align="right"><b style="font-size:1.1em;">Total '.dateView($last_pay_date).' :</td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>'.number_format($grp_pay_val).'</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>'.number_format($grp_disc_val).'</b></td>

			</tr><tr><td valign="top"><br></td></tr>';

			$lnQty = 0; $grp_pay_val = 0; $grp_disc_val = 0;  $j=0;
		}
		$tbl.= '<tr><td valign="top" colspan="8" align="left" style="font-size:1.1em;"><b>Date '.dateView($dtlrow['pur_date']).'</b></td></tr>';
		$last_pay_date = $dtlrow['pay_date'];
	}
	$lnQty++;  $pay_val += $dtlrow['pay_val'];  $disc_val += $dtlrow['disc_val'];
	$grp_pay_val += $dtlrow['pay_val'];  $grp_disc_val += $dtlrow['disc_val'];
	$lSum++;  $sum_pay_val += $dtlrow['pay_val']; $sum_disc_val += $dtlrow['disc_val'];

        $pur_date = dateView($dtlrow['pur_date']);
        $pay_date = dateView($dtlrow['pay_date']);
	$due_date = dateView($dtlrow['due_date']);
	$check_date = dateView($dtlrow['check_date']);

	$tbl.= '
	<tr>
		<td valign="top" align="left">'.$pay_date.'</td>
		<td valign="top" align="left">'.$dtlrow['pur_inv_no'].'</td>
		<td valign="top" align="left">'.$pur_date.'</td>
		<td valign="top" align="left">'.$dtlrow['chassis'].'<br>'.$dtlrow['engine'].'</td>
		<td valign="top" align="left">'.$dtlrow['veh_name'].'</td>
		<td valign="top" align="right">'.number_format($dtlrow['pay_val']).'</td>
		<td valign="top" align="right">'.number_format($dtlrow['disc_val']).'</td>
		<td valign="top" align="left">'.$dtlrow['pay_type'].'</td>
		<td valign="top" align="left">'.$dtlrow['check_no'].'</td>
		<td valign="top" align="left">'.$check_date.'</td>
		<td valign="top" align="left">'.$due_date.'</td>
		<td valign="top" align="left">'.$dtlrow['bank_code'].'</td>
		<td valign="top" align="left">'.$dtlrow['pay_desc'].'</td></tr>';

$i++;
$j++;
	unset($dtlrow);
}
if ($j>=1)
		{
			$tbl.= '
			<tr>
				<td valign="top" colspan="5" align="right" style="font-size:1.1em;"><b>TOTAL '.dateView($last_pay_date).' :</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>'.number_format($grp_pay_val).'</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>'.number_format($grp_disc_val).'</b></td>

			</tr><tr><td valign="top"><br></td></tr>';

			$lnQty = 0; $grp_pay_val = 0; $grp_disc_val = 0;  $j=0;
		}
if ($i>=1)
{

	$tbl.= '
			<tr>
				<td valign="top" colspan="5" align="right" style="font-size:1.1em;"><b>TOTAL '.$last_supp_code.' : '.$last_supp_name.':</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>'.number_format($pay_val).'</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>'.number_format($disc_val).'</b></td>

			</tr><tr><td valign="top"><br></td></tr>';

	$lnQty = 0;  $pay_val = 0; $disc_val = 0;
}
$tbl.= '<tfoot>
	<tr>
                <td colspan="4"></td>
		<td class="border-foot" style="border-left:2px solid black;border-top:2px solid black;border-bottom:2px solid black;" valign="top"  align="right"><b style="font-size:1.1em;">GRAND TOTAL :</b></td>
		<td class="border-foot" style="border-top:2px solid black;border-bottom:2px solid black;" valign="top" align="right"><b>'.number_format($sum_pay_val).'</b></td>
		<td class="border-foot" style="border-right:2px solid black;border-top:2px solid black;border-bottom:2px solid black;" valign="top" align="right"><b>'.number_format($sum_disc_val).'</b></td>
	</tr></tfoot>';
$tbl .='</table></div>';

?>