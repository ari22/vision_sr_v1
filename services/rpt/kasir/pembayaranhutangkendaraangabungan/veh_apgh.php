<?php

//========CHANGE LOG=============
//ganti semua <td jadi <td valign="top"
//ganti tanggal d judul
//footer dibuang
//judul pertama tadinya ga kluar
//Nominal<br>Invoice => Invoice<br />Amount

$tbl .= '
<div id="cntr1" align="center">
<table width="80%">
<tr><td valign="top" align="center"><b style="font-size:1.5em;">' . $comp_name . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.5em;">' . $rptTitle . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.1em;">' . $title . '</b></td></tr>
<tr><td valign="top" align="center"><b>DATE : ' . dateView($apg_date1) . ' UP TO ' . dateView($apg_date2) . '</b></td></tr>
</table>
';


$tbl .= '
<table width="80%"  >
<tr>
<td valign="top"></td>
<td valign="top" align="right"><b>Printed On: </b>' . date('d/m/Y') . '</td>
</tr>
</table>';

$tbl .= '<table width="80%">';
$tbl .= '<thead style="border:2px solid black !important;">
<tr>
    <td valign="top">Invoice No.</td>
<td valign="top">Invoice Date</td>
<td valign="top">Supplier</td>
<td valign="top">Pay Date</td>
<td valign="top">Payment Type</td>
<td valign="top" align="right">Payment</td>
<td valign="top" align="right">Discount</td>
<td valign="top">Description</td>
</tr></thead>';
$tbl .= '<tr><td valign="top"></td></tr>';

$i = 0;
$j = 0;

$lnQty = 0;
$sum_hd_paid = 0;
$sum_hd_disc = 0;

while ($dtlrow = mysql_fetch_array($dtl)) {
    
    $sum_hd_paid += $dtlrow['hd_paid'];
    $sum_hd_disc += $dtlrow['hd_disc'];

    $apg_date = dateView($dtlrow['apg_date']);
    $add_date = dateView($dtlrow['add_date']);
    $pay_date = dateView($dtlrow['pay_date']);

    $tbl .= '<tr>';
    $tbl .= '<td>' . $dtlrow['apg_inv_no'] . '</td>';
    $tbl .= '<td>' . $apg_date . '</td>';
    $tbl .= '<td>' . $dtlrow['supp_name'] . '</td>';
    $tbl .= '<td>' . $pay_date . '</td>';
    $tbl .= '<td>' . $dtlrow['pay_type'] . '</td>';
    $tbl .= '<td valign="top" align="right">' . number_format($dtlrow['hd_paid']) . '</td>';
    $tbl .= '<td valign="top" align="right">' . number_format($dtlrow['hd_disc']) . '</td>';
    $tbl .= '<td>' . $dtlrow['pay_desc'] . '</td>';
    $tbl .= '<tr>';

    $i++;
    $j++;
    unset($dtlrow);
}

$tbl.= '<tr><td valign="top"><br><br></td></tr>
        <tfoot>
	<tr>
                <td colspan="4"></td>
		<td class="border-foot" style="border-left:2px solid black;border-top:2px solid black;border-bottom:2px solid black;" valign="top" align="right"><b style="font-size:1.1em;">TOTAL :</b></td>
		<td class="border-foot" style="border-top:2px solid black;border-bottom:2px solid black;" valign="top" align="right">'.number_format($sum_hd_paid).'</td>
		<td class="border-foot" style="border-right:2px solid black;border-top:2px solid black;border-bottom:2px solid black;" valign="top" align="right"><b>'.number_format($sum_hd_disc).'</b></td>
		
	</tr></tfoot>';

$tbl .='
</table>
</div>
';
?>