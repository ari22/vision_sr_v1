<?php

//========CHANGE LOG=============
//ganti semua <td jadi <td valign="top"
//ganti tanggal d judul
//Invoice No. UJ<br />Date => Invoice No.<br />Invoice Date
//Use<br />Use Date => Used In<br />Date Used
//Used => Used in AR
//pembetulan tabel (tadinya tidak sesuai)
//kykny tanggalny ga bner d, keluarny kykny ga sesuai sama database

$tbl .= '
<div id="cntr1" align="center">
<table width="100%">
<tr><td valign="top" align="center"><b style="font-size:1.5em;">' . $comp_name . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.5em;">' . $rptTitle . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.1em;">' . $title . '</b></td></tr>
<tr><td valign="top" align="center"><b>DATE : ' . dateView($pay_date1) . ' UP TO ' . dateView($pay_date2) . '</b></td></tr>
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
	<td valign="top" align="left" width="50px"><b>Payment Date</b></td>
	<td valign="top" align="left" width="80px"><b>TTS No.<br />TTS Date</b></td>
	<td valign="top" align="left" width="60px"><b>SPK No.<br />SPK Date</b></td>
	<td valign="top" align="left" width="180px"><b>Customer Name<br />Sales Name</b></td>
	<td valign="top" align="left" width="70px"><b>Used In<br />Date Used</b></td>
	<td valign="top" align="right" width="80px"><b>DP</b></td>
	<td valign="top" align="right" width="80px"><b>Used in AR</b></td>
	<td valign="top" align="right" width="80px"><b>Cancellation</b></td>
	<td valign="top" align="right" width="80px"><b>Payment<br />Type</b></td>
	<td valign="top" align="right" width="80px"><b>Check No.</b></td>
	<td valign="top" align="right" width="80px"><b>Check Date</b></td>
	<td valign="top" align="right" width="80px"><b>Due Date</b></td>
	<td valign="top" align="left" width="120px"><b>Note</b></td>
</tr></thead>
';
$tbl .='<tr><td valign="top"></td></tr>';

$i = 0;
$j = 0;

$last_pay_date = '';
$lnQty = 0;
$value = 0;
$dp_val = 0;
$lSum = 0;
$pd_begin = 0;
$pd_end = 0;
$pay_val = 0;
$unit_price = 0;
$used_val = 0;
$cancel_val = 0;
$date_pay_val = 0;
$date_unit_price = 0;
$date_used_val = 0;
$date_cancel_val = 0;

$sum_qty = 0;
$sum_value = 0;
$sum_dp_val = 0;
$sum_pd_begin = 0;
$sum_pd_end = 0;
$sum_pay_val = 0;
$sum_unit_price = 0;
$sum_used_val = 0;
$sum_cancel_val = 0;

while ($dtlrow = mysql_fetch_array($dtl)) {

    if ($last_pay_date != $dtlrow['pay_date']) {
        if ($j >= 1) {
            $tbl.= '
				<tr>
					<td valign="top" colspan="2"></td>
					<td valign="top" align="right" colspan="2"><b>TOTAL ' . dateView($last_pay_date) . ' :</b></td>
					<td valign="top" align="right" style="border-top:1px solid black;"><b></b></td>
					<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($date_pay_val) . '</b></td>
					<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($date_used_val) . '</b></td>
					<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($date_cancel_val) . '</b></td>
					<td valign="top"></td>
					<td valign="top"></td>
					<td valign="top"></td>
					<td valign="top"></td>
					<td valign="top"></td>
					
				</tr>';
            $tbl .= '<tr><td><br /></td></tr>';
            
            $j = 0;
            $date_unit_price = 0;
            $date_pay_val = 0;
            $date_used_val = 0;
            $date_cancel_val = 0;
            $j = 0;
            $date_pay_val = 0;
            $date_used_val = 0;
            $date_cancel_val = 0;

            $lSum = 0;
            $lnQty = 0;
            $value = 0;
            $unit_price = 0;
            $pd_begin = 0;
            $pay_val = 0;
            $used_val = 0;
            $cancel_val = 0;
            $pd_end = 0;
        }


        //$tbl.= '<tr><td valign="top" colspan="14" align="left"><b style="font-size:1.1em;">*** ' . $dtlrow['pay_date'] . ' ***</b></td></tr>';
        $last_pay_date = $dtlrow['pay_date'];
    }

    $lnQty++;
    $sum_qty++;
    $pay_val = $pay_val + $dtlrow['pay_val'];
    $date_pay_val = $date_pay_val + $dtlrow['pay_val'];
    $sum_pay_val = $sum_pay_val + $dtlrow['pay_val'];
    $unit_price = $unit_price + $dtlrow['unit_price'];
    $date_unit_price = $date_unit_price + $dtlrow['unit_price'];
    $sum_unit_price = $sum_unit_price + $dtlrow['unit_price'];

    $value = $value + $dtlrow['pay_val'];
    $sum_value = $sum_value + $dtlrow['pay_val'];

    if (substr($dtlrow['sal_inv_no'], 0, 3) == 'VSL') {
        $used_val = $used_val + $dtlrow['used_val'];
        $date_used_val = $date_used_val + $dtlrow['used_val'];
        $sum_used_val = $sum_used_val + $dtlrow['used_val'];
    } else {
        $cancel_val = $cancel_val + $dtlrow['used_val'];
        $date_cancel_val = $date_cancel_val + $dtlrow['used_val'];
        $sum_cancel_val = $sum_cancel_val + $dtlrow['used_val'];
    }

    $so_date = dateView($dtlrow['so_date']);
    $tts_date = dateView($dtlrow['tts_date']);
    $pay_date = dateView($dtlrow['pay_date']);
    $sal_date = dateView($dtlrow['sal_date']);


    $tbl.= '
	<tr>
		<td valign="top" align="left">' . $pay_date . '</td>
		<td valign="top" align="left">' . $dtlrow['tts_no'] . '<br>' . $tts_date . '</td>
		<td valign="top" align="left">' . $dtlrow['so_no'] . '<br />' . $so_date . '</td>
		<td valign="top" align="left">' . $dtlrow['cust_name'] . '<br /><br />' . $dtlrow['srep_name'] . '</td>
		<td valign="top" align="left">' . $dtlrow['sal_inv_no'] . '<br>' . $sal_date . '</td>
		<td valign="top" align="right">' . number_format($dtlrow['pay_val']) . '</td>
		<td valign="top" align="right">';
    if (substr($dtlrow['sal_inv_no'], 0, 3) == 'VSL') {
        $tbl.=number_format($dtlrow['used_val']);
    } else {
        $tbl.="0";
    }
    $tbl.='</td><td valign="top" align="right">';
    if (substr($dtlrow['sal_inv_no'], 0, 3) == 'VSL') {
        $tbl.="0";
    } else {
        $tbl.=number_format($dtlrow['used_val']);
    }
    $tbl.='</td>';
    $tbl .= '
		<td valign="top" align="right">' . $dtlrow['pay_type'] . '</td>
		<td valign="top" align="right">' . $dtlrow['check_no'] . '</td>
		<td valign="top" align="right">' . dateView($dtlrow['check_date']) . '</td>
		<td valign="top" align="right">' . dateView($dtlrow['due_date']) . '</td>
		<td valign="top" align="left">' . $dtlrow['pay_desc'] . '</td>
	</tr>';
    $i++;
    $j++;
    unset($dtlrow);
}


        if ($j >= 1) {
            $tbl.= '
				<tr>
					<td valign="top" colspan="2"></td>
					<td valign="top" align="right" colspan="2"><b>TOTAL ' . dateView($last_pay_date) . ' :</b></td>
					<td valign="top" align="right" style="border-top:1px solid black;"><b></b></td>
					<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($date_pay_val) . '</b></td>
					<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($date_used_val) . '</b></td>
					<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($date_cancel_val) . '</b></td>
					<td valign="top"></td>
					<td valign="top"></td>
					<td valign="top"></td>
					<td valign="top"></td>
					<td valign="top"></td>
					
				</tr>';
            $tbl .= '<tr><td><br /></td></tr>';
            
            $j = 0;
            $date_unit_price = 0;
            $date_pay_val = 0;
            $date_used_val = 0;
            $date_cancel_val = 0;
            $j = 0;
            $date_pay_val = 0;
            $date_used_val = 0;
            $date_cancel_val = 0;

            $lSum = 0;
            $lnQty = 0;
            $value = 0;
            $unit_price = 0;
            $pd_begin = 0;
            $pay_val = 0;
            $used_val = 0;
            $cancel_val = 0;
            $pd_end = 0;
        }
        
$tbl.= '<tr><td valign="top"><br /></td></tr><tfoot>
<tr height="30px">
                                <td colspan="2"></td>
				<td class="border-foot" colspan="2" valign="top" align="right" style="border-left:2px solid black;border-left:2px solid black;border-top:2px solid black;border-bottom:2px solid black;" ><b style="font-size:1.1em;">GRAND TOTAL :</b></td>
				<td class="border-foot" valign="top" align="right" style="border-top:2px solid black;;border-bottom:2px solid black;"><b></b></td>
				<td class="border-foot" valign="top" align="right" style="border-top:2px solid black;border-bottom:2px solid black;"><b>' . number_format($sum_pay_val) . '</b></td>
				<td class="border-foot" valign="top" align="right" style="border-top:2px solid black;border-bottom:2px solid black;"><b>' . number_format($sum_used_val) . '</b></td>
				<td class="border-foot" valign="top" align="right" style="border-right:2px solid black;border-top:2px solid black;border-bottom:2px solid black;"><b>' . number_format($sum_cancel_val) . '</b></td>
				<td valign="top"></td>
				<td valign="top"></td>
				<td valign="top"></td>
			</tr></tfoot>';

$tbl .='
</table>


</div>
';
?>