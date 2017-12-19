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
<tr><td valign="top" align="center"><b style="font-size:1.5em;">' . $comp_name . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.5em;">' . $rptTitle . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.1em;">' . $title . '</b></td></tr>
<tr><td valign="top" align="center"><b>DATE : ' . dateView($arg_date1) . ' UP TO ' . dateView($arg_date2) . '</b></td></tr>
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
    <td valign="top" width="80">Invoice No.</td>
    <td valign="top">Invoice Date</td>
    <td valign="top">Supplier</td>
    <td valign="top">Pay Date</td>
    <td valign="top">Payment Type</td>
    <td valign="top" width="50">Bank</td>
    <td valign="top" width="50">Check No.</td>
    <td valign="top">Description</td>
    <td valign="top" width="100">Sales No.</td>
    <td valign="top">Sales Date</td>
    <td valign="top" align="right">Receivable</td>
    <td valign="top" align="right">Payment(A)</td>
    <td valign="top" align="right">Discount(B)</td>
    <td valign="top" align="right">Total (A+B)</td>
</tr></thead>';
$tbl .= '<tr><td valign="top"></td></tr>';

$i = 0;
$j = 0;
$last_cust_code = '';
$last_cust_name = '';
$last_arg_date = '';
$lnQty = 0;

$hd_begin = 0;
$hd_paid = 0;
$hd_disc = 0;
$hd_end = 0;

$sum_hd_begin = 0;
$sum_hd_paid = 0;
$sum_hd_disc = 0;
$sum_hd_end = 0;

$last_apg_inv_no = '';


while ($dtlrow = mysql_fetch_array($dtl)) {

    if ($last_apg_inv_no != $dtlrow['apg_inv_no']) {
        if ($i >= 1) {

            $tbl.= '
			<tr>
				<td colspan="10" valign="top" align="right"><b style="font-size:1.1em;">TOTAL ' . $last_apg_inv_no . ':</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($hd_begin) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($hd_paid) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($hd_disc) . '</b></td>
                                <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($hd_end) . '</b></td>    
			</tr><tr><td valign="top"><br></td></tr>';

            $lnQty = 0;
            $hd_begin = 0;
            $hd_paid = 0;
            $hd_disc = 0;
            $hd_end = 0;
        }
        $tbl.= '<tr><td valign="top" colspan="8" align="left"><b style="font-size:1.1em;">*** ' . $dtlrow['apg_inv_no'] . ' ***</b></td></tr>';
        $last_apg_inv_no = $dtlrow['apg_inv_no'];
        
        
    }

    $hd_begin += $dtlrow['hd_begin'];
    $hd_paid += $dtlrow['hd_paid'];
    $hd_disc += $dtlrow['hd_disc'];
    $hd_end += $dtlrow['hd_paid'] + $dtlrow['hd_disc'];

    $sum_hd_begin += $dtlrow['hd_begin'];
    $sum_hd_paid += $dtlrow['hd_paid'];
    $sum_hd_disc += $dtlrow['hd_disc'];
    $sum_hd_end += $dtlrow['hd_paid'] + $dtlrow['hd_disc'];

    $apg_date = dateView($dtlrow['apg_date']);
    $add_date = dateView($dtlrow['add_date']);
    $pay_date = dateView($dtlrow['pay_date']);
    $pur_date = dateView($dtlrow['pur_date']);

    $tbl .= '<tr>';
    if ($last_apg_inv_no != $dtlrow['apg_inv_no']) {
            $tbl .= '<td valign="top">' . $dtlrow['apg_inv_no'] . '</td>';
    }else{
         $tbl .= '<td valign="top"></td>';
    }

    $tbl .= '<td valign="top">' . $apg_date . '</td>';
    $tbl .= '<td valign="top">' . $dtlrow['supp_name'] . '</td>';
    $tbl .= '<td valign="top">' . $pay_date . '</td>';
    $tbl .= '<td valign="top">' . $dtlrow['pay_type'] . '</td>';
    $tbl .= '<td valign="top">' . $dtlrow['bank_code'] . '</td>';
    $tbl .= '<td valign="top">' . $dtlrow['check_no'] . '</td>';
    $tbl .= '<td valign="top">' . $dtlrow['pay_desc'] . '</td>';
    $tbl .= '<td valign="top">' . $dtlrow['pur_inv_no'] . '</td>';
    $tbl .= '<td valign="top">' . $pur_date . '</td>';
    $tbl .= '<td valign="top" align="right">' . number_format($dtlrow['hd_begin']) . '</td>';
    $tbl .= '<td valign="top" align="right">' . number_format($dtlrow['hd_paid']) . '</td>';
    $tbl .= '<td valign="top" align="right">' . number_format($dtlrow['hd_disc']) . '</td>';
    $tbl .= '<td valign="top" align="right">' . number_format($dtlrow['hd_paid'] + $dtlrow['hd_disc']) . '</td>';
    $tbl .= '<tr>';

    $i++;
    $j++;
    unset($dtlrow);
}


if ($i >= 1) {

    $tbl.= '
			<tr>
				<td colspan="10" valign="top" align="right"><b style="font-size:1.1em;">TOTAL ' . $last_apg_inv_no . ':</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($hd_begin) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($hd_paid) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($hd_disc) . '</b></td>
                                <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($hd_end) . '</b></td>    
			</tr><tr><td valign="top"><br></td></tr>';

    $lnQty = 0;
    $hd_begin = 0;
    $hd_paid = 0;
    $hd_disc = 0;
    $hd_end = 0;
}

$tbl.= '<tr><td valign="top"><br><br></td></tr>
        <tfoot>
	<tr>
                <td colspan="9"></td>
		<td class="border-foot" style="border-left:2px solid black;border-top:2px solid black;border-bottom:2px solid black;" valign="top" align="right"><b style="font-size:1.1em;">TOTAL :</b></td>
		<td class="border-foot" style="border-top:2px solid black;border-bottom:2px solid black;" valign="top" align="right">' . number_format($sum_hd_begin) . '</td>
		<td class="border-foot" style="border-top:2px solid black;border-bottom:2px solid black;" valign="top" align="right"><b>' . number_format($sum_hd_paid) . '</b></td>
		<td class="border-foot" style="border-top:2px solid black;border-bottom:2px solid black;" valign="top" align="right">' . number_format($sum_hd_disc) . '</td>
		<td class="border-foot" style="border-right:2px solid black;border-top:2px solid black;border-bottom:2px solid black;" valign="top" align="right"><b>' . number_format($sum_hd_end) . '</b></td>
	</tr></tfoot>';

$tbl .='
</table>
</div>
';
?>