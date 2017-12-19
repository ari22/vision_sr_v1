<?php

//========CHANGE LOG=============
//ganti semua <td jadi <td valign="top"
//engine => engine No.;chassis => Chassis No.
//Not Due Date => Not Due

$tbl .= '
<div id="cntr1" align="center">
<table width="100%">
<tr><td valign="top" align="center"><b style="font-size:1.5em;">' . $comp_name . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.5em;">' . $rptTitle . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.1em;">' . $title . '</b></td></tr>
<tr><td valign="top" align="center"><b>DATE : ' . $ap_date . '</b></td></tr>
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
	<td class="border-head" valign="top" align="left" 	width="120px" ><b>Invoice Date<br>Invoice No.</b></td>
	<td class="border-head" valign="top" align="left" 	width="140px" ><b>Chassis No.<br>Engine No.</b></td>
	<td class="border-head" valign="top" align="right" 	width="80px"><b>Total<br>Invoice</b></td>
	<td class="border-head" valign="top" align="right" 	width="80px" 	 ><b>Beginning<br />Balance</b></td>
         <td class="border-head" valign="top" align="right" 	width="80px" 	 ><b>Purchase</b></td>
	<td class="border-head" valign="top" align="right" 	width="80px" 	 ><b>Payment</b></td>
	<td class="border-head" valign="top" align="right" 	width="80px" 	 ><b>Discount</b></td>
	<td class="border-head" valign="top" align="right" 	width="80px" 	 ><b>Ending<br />Balance</b></td>
	<td class="border-head" valign="top" align="center" 	width="80px" 	 ><b>Due Date</b></td>
	<td class="border-head" valign="top" align="center" 	width="80px" 	 ><b>Not<br />Due</b></td>
	<td class="border-head" valign="top" align="right" 	width="80px" 	 ><b><=2 Week<br>0-14 day</b></td>
	<td class="border-head" valign="top" align="right" 	width="80px" 	 ><b><=4 Week<br>15-28 day</b></td>
	<td class="border-head" valign="top" align="right" 	width="80px" 	 ><b><=8 Week<br>29-56 day</b></td>
	<td class="border-head" valign="top" align="right" 	width="80px" 	 ><b><=12 Week<br>57-84 day</b></td>
	<td class="border-head" valign="top" align="right" 	width="80px" 	 ><b>>12 Week</b></td>';
$tbl .= '</tr><thead>';
$tbl .= '<tr><td valign="top"></td></tr>';

$i = 0;
$j = 0;
$last_pur_date = '';
$last_veh_code = '';
$last_veh_name = '';
$lnQty = 0;

$inv_total = 0;
$hd_begin = 0;
$hd_purprice = 0;
$hd_paid = 0;
$hd_disc = 0;
$hd_end = 0;

$lSum = 0;
$sum_inv_total = 0;
$sum_hd_begin = 0;
$sum_hd_purprice = 0;
$sum_hd_paid = 0;
$sum_hd_disc = 0;
$sum_hd_end = 0;

$lGrp = 0;
$grp_inv_total = 0;
$grp_hd_begin = 0;
$grp_hd_purprice = 0;
$grp_hd_paid = 0;
$grp_hd_disc = 0;
$grp_hd_end = 0;


$aging1 = 0;
$aging2 = 0;
$aging3 = 0;
$aging4 = 0;
$aging5 = 0;
$aging6 = 0;

$sum_aging1 = 0;
$sum_aging2 = 0;
$sum_aging3 = 0;
$sum_aging4 = 0;
$sum_aging5 = 0;
$sum_aging6 = 0;

$grp_aging1 = 0;
$grp_aging2 = 0;
$grp_aging3 = 0;
$grp_aging4 = 0;
$grp_aging5 = 0;
$grp_aging6 = 0;

$qty = 1;
$sumqty = 0;

$dat = strtotime($ap_date);

while ($dtlrow = mysql_fetch_array($dtl)) {
        
    $purdate = strtotime($dtlrow['pur_date']);
    $purexp = explode('-', $dtlrow['pur_date']);
    $purperiode = $purexp[0] . $purexp[1];

    if ($rpt_by == '1') {
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

    if ($last_veh_code != $dtlrow['veh_code']) {
        if ($i >= 1) {

            $tbl.= '
			<tr>
				<td valign="top" colspan="2" align="right"><b style="font-size:1.1em;">TOTAL ' . dateView($last_pur_date) . ':</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($inv_total) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($hd_begin) . '</b></td>
                                <td valign="top" align="right" style="border-top:1px solid black;">' . number_format($hd_purprice) . '</td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($hd_paid) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($hd_disc) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($hd_end) . '</b></td>
                                <td></td>
                                <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($aging1) . '</b></td>
                                <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($aging2) . '</b></td>
                                <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($aging3) . '</b></td>
                                <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($aging4) . '</b></td>
                                <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($aging5) . '</b></td>
                                <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($aging6) . '</b></td>
			</tr>
                        <tr><td valign="top"><br></td></tr>';

            $lnQty = 0;
            $inv_total = 0;
            $hd_begin = 0;
            $hd_purprice = 0;
            $hd_paid = 0;
            $hd_disc = 0;
            $hd_end = 0;


            $aging1 = 0;
            $aging2 = 0;
            $aging3 = 0;
            $aging4 = 0;
            $aging5 = 0;
            $aging6 = 0;
        }
        if ($j >= 1) {

            $tbl.= '
			<tr>
				<td valign="top" colspan="2" align="right"><b style="font-size:1.1em;">Total ' . $last_veh_code . ' :</td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($grp_inv_total) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($grp_hd_begin) . '</b></td>
                                <td valign="top" align="right" style="border-top:1px solid black;">' . number_format($grp_hd_purprice) . '</td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($grp_hd_paid) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($grp_hd_disc) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($grp_hd_end) . '</b></td>
                                <td></td>
                                <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($grp_aging1) . '</b></td>
                                <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($grp_aging2) . '</b></td>
                                <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($grp_aging3) . '</b></td>
                                <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($grp_aging4) . '</b></td>
                                <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($grp_aging5) . '</b></td>
                                <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($grp_aging6) . '</b></td>
			</tr>
                        <tr><td valign="top"><br></td></tr>';

            $lnGrp = 0;
            $grp_inv_total = 0;
            $grp_hd_begin = 0;
            $grp_hd_purprice = 0;
            $grp_hd_paid = 0;
            $grp_hd_disc = 0;
            $grp_hd_end = 0;

            $grp_aging1 = 0;
            $grp_aging2 = 0;
            $grp_aging3 = 0;
            $grp_aging4 = 0;
            $grp_aging5 = 0;
            $grp_aging6 = 0;
            $j = 0;
        }
        $tbl.= '<tr><td valign="top" colspan="8" align="left"><b style="font-size:1.1em;">*** ' . $dtlrow['veh_code'] . ' : ' . $dtlrow['veh_name'] . ' ***</b> </td></tr>';
        $last_veh_code = $dtlrow['veh_code'];
        $last_veh_name = $dtlrow['veh_name'];

        $tbl.= '<tr><td valign="top" colspan="12" align="left"><b style="font-size:1.1em;">Date ' . dateView($dtlrow['pur_date']) . '</b></td></tr>';
        $last_pur_date = $dtlrow['pur_date'];
    }
    if ($last_pur_date != $dtlrow['pur_date']) {
        if ($i >= 1) {

            $tbl.= '
			<tr>
				<td valign="top" colspan="2" align="right"><b style="font-size:1.1em;">TOTAL ' . dateView($last_pur_date) . ':</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($inv_total) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($hd_begin) . '</b></td>
                                    <td valign="top" align="right" style="border-top:1px solid black;">' . number_format($hd_purprice) . '</td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($hd_paid) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($hd_disc) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($hd_end) . '</b></td>
                                <td></td>
                                <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($aging1) . '</b></td>
                                <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($aging2) . '</b></td>
                                <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($aging3) . '</b></td>
                                <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($aging4) . '</b></td>
                                <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($aging5) . '</b></td>
                                <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($aging6) . '</b></td>
			</tr>
                        <tr><td valign="top"><br></td></tr>';

            $lnQty = 0;
            $inv_total = 0;
            $hd_begin = 0;
            $hd_purprice = 0;
            $hd_paid = 0;
            $hd_disc = 0;
            $hd_end = 0;

            $aging1 = 0;
            $aging2 = 0;
            $aging3 = 0;
            $aging4 = 0;
            $aging5 = 0;
            $aging6 = 0;
        }
        $tbl.= '<tr><td valign="top" colspan="12" align="left"><b style="font-size:1.1em;">Date ' . dateView($dtlrow['pur_date']) . '</b></td></tr>';
        $last_pur_date = $dtlrow['pur_date'];
    }

    $sumqty += $qty;

    $lnQty++;

    $lGrp++;

    $lSum++;

    $inv_total += $dtlrow['inv_total'];
    $hd_begin += $dtlrow['hd_begin'];
    $hd_purprice += $dtlrow['hd_purprice'];
    $hd_paid += $dtlrow['hd_paid'];
    $hd_disc += $dtlrow['hd_disc'];
    $hd_end += $dtlrow['hd_end'];

    $grp_inv_total += $dtlrow['inv_total'];
    $grp_hd_begin += $dtlrow['hd_begin'];
    $grp_hd_purprice += $dtlrow['hd_purprice'];
    $grp_hd_paid += $dtlrow['hd_paid'];
    $grp_hd_disc += $dtlrow['hd_disc'];
    $grp_hd_end += $dtlrow['hd_end'];


    $sum_inv_total += $dtlrow['inv_total'];
    $sum_hd_begin += $dtlrow['hd_begin'];
    $sum_hd_purprice += $dtlrow['hd_purprice'];
    $sum_hd_paid += $dtlrow['hd_paid'];
    $sum_hd_disc += $dtlrow['hd_disc'];
    $sum_hd_end += $dtlrow['hd_end'];
    
    $pur_date = dateView($dtlrow['pur_date']);
    $due_date = dateView($dtlrow['due_date']);

    
    $datenow = new DateTime($ap_date);
    switch ($aging) {
        case '1':
            if ($dtlrow['due_date'] !== '0000-00-00') {
                $d_date = new DateTime($dtlrow['due_date']);
                $dsdate = strtotime($dtlrow['due_date']);
            } else {
                $d_date = new DateTime($dtlrow['pur_date']);
                $dsdate = strtotime($dtlrow['pur_date']);
            }

            break;
        case '2':
            $d_date = new DateTime($dtlrow['pur_date']);
            $dsdate = strtotime($dtlrow['pur_date']);

            break;
    }
    
    if ($dsdate > $dat) {
        $dtlrow['aging'] = -1;
    } else {
        $day = $datenow->diff($d_date);
        $dtlrow['aging'] = $day->days;
    }
    
   

    if ($dtlrow['aging'] < 0) {
        $aging1 += $dtlrow['hd_end'];
        $grp_aging1 +=$dtlrow['hd_end'];
        $sum_aging1 +=$dtlrow['hd_end'];
    }

    if ($dtlrow['aging'] >= 0 && $dtlrow['aging'] <= 14) {
        $aging2 +=$dtlrow['hd_end'];
        $grp_aging2 +=$dtlrow['hd_end'];
        $sum_aging2 +=$dtlrow['hd_end'];
    }

    if ($dtlrow['aging'] >= 15 && $dtlrow['aging'] <= 28) {
        $aging3 += $dtlrow['hd_end'];
        $grp_aging3 +=$dtlrow['hd_end'];
        $sum_aging3 += $dtlrow['hd_end'];
    }

    if ($dtlrow['aging'] >= 29 && $dtlrow['aging'] <= 56) {
        $aging4 += $dtlrow['hd_end'];
        $grp_aging4 +=$dtlrow['hd_end'];
        $sum_aging4 += $dtlrow['hd_end'];
    }

    if ($dtlrow['aging'] >= 57 && $dtlrow['aging'] <= 84) {
        $aging5 +=$dtlrow['hd_end'];
        $grp_aging5 +=$dtlrow['hd_end'];
        $sum_aging5 +=$dtlrow['hd_end'];
    }

    if ($dtlrow['aging'] > 84) {
        $aging6 +=$dtlrow['hd_end'];
        $grp_aging6 +=$dtlrow['hd_end'];
        $sum_aging6 +=$dtlrow['hd_end'];
    }


    $tbl.= '
	<tr>
		<td valign="top" align="left">' . $pur_date . '<br>' . $dtlrow['pur_inv_no'] . '</td>
		<td valign="top" align="left">' . $dtlrow['chassis'] . '<br>' . $dtlrow['engine'] . '</td>
		<td valign="top" align="right">' . number_format($dtlrow['inv_total']) . '</td>
		<td valign="top" align="right">' . number_format($dtlrow['hd_begin']) . '</td>
                    <td valign="top" align="right">' . number_format($dtlrow['hd_purprice']) . '</td>
		<td valign="top" align="right">' . number_format($dtlrow['hd_paid']) . '</td>
		<td valign="top" align="right">' . number_format($dtlrow['hd_disc']) . '</td>
		<td valign="top" align="right">' . number_format($dtlrow['hd_end']) . '</td>
		<td valign="top" align="center">' . $due_date . '</td>';
    
    $tbl .= '<td valign="top" align="right">';
    if ($dtlrow['aging'] < 0) {
        $tbl.= number_format($dtlrow['hd_end']);
    }
    $tbl .= '</td>';
    $tbl .= '<td valign="top" align="right">';
    if ($dtlrow['aging'] <= 14) {
        $tbl.= number_format($dtlrow['hd_end']);
    }
    $tbl .= '</td>';
    $tbl .= '<td valign="top" align="right">';
    if ($dtlrow['aging'] > 14 && $dtlrow['aging'] <= 28) {
        $tbl.= number_format($dtlrow['hd_end']);
    }
    $tbl .= '</td>';
    $tbl .= '<td valign="top" align="right">';
    if ($dtlrow['aging'] > 28 && $dtlrow['aging'] <= 56) {
        $tbl.= number_format($dtlrow['hd_end']);
    }
    $tbl .= '</td>';
    $tbl .= '<td valign="top" align="right">';
    if ($dtlrow['aging'] > 56 && $dtlrow['aging'] <= 84) {
         $tbl.= number_format($dtlrow['hd_end']);
    }
    $tbl .= '</td>';
    $tbl .= '<td valign="top" align="right">';
    if ($dtlrow['aging'] > 84) {
         $tbl.= number_format($dtlrow['hd_end']);
    }
    $tbl .= '</td>';

    $i++;
    $j++;
    unset($dtlrow);
}

if ($i >= 1) {

    $tbl.= '
			<tr>
				<td valign="top" colspan="2" align="right"><b style="font-size:1.1em;">TOTAL ' . dateView($last_pur_date) . ':</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($inv_total) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($hd_begin) . '</b></td>
                                <td valign="top" align="right" style="border-top:1px solid black;">' . number_format($hd_purprice) . '</td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($hd_paid) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($hd_disc) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($hd_end) . '</b></td>
                                <td></td>
                                <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($aging1) . '</b></td>
                                <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($aging2) . '</b></td>
                                <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($aging3) . '</b></td>
                                <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($aging4) . '</b></td>
                                <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($aging5) . '</b></td>
                                <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($aging6) . '</b></td>
			</tr>
                        <tr><td valign="top"><br></td></tr>';

    $lnQty = 0;
    $inv_total = 0;
    $hd_begin = 0;
    $hd_purprice = 0;
    $hd_paid = 0;
    $hd_disc = 0;
    $hd_end = 0;


    $aging1 = 0;
    $aging2 = 0;
    $aging3 = 0;
    $aging4 = 0;
    $aging5 = 0;
    $aging6 = 0;
}
if ($j >= 1) {

    $tbl.= '
			<tr>
				<td valign="top" colspan="2" align="right"><b style="font-size:1.1em;">Total ' . $last_veh_code . ' :</td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($grp_inv_total) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($grp_hd_begin) . '</b></td>
                                <td valign="top" align="right" style="border-top:1px solid black;">' . number_format($grp_hd_purprice) . '</td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($grp_hd_paid) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($grp_hd_disc) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($grp_hd_end) . '</b></td>
                                <td></td>
                                <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($grp_aging1) . '</b></td>
                                <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($grp_aging2) . '</b></td>
                                <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($grp_aging3) . '</b></td>
                                <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($grp_aging4) . '</b></td>
                                <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($grp_aging5) . '</b></td>
                                <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($grp_aging6) . '</b></td>
			</tr>
                        <tr><td valign="top"><br></td></tr>';

    $lnGrp = 0;
    $grp_inv_total = 0;
    $grp_hd_begin = 0;
    $grp_hd_purprice = 0;
    $grp_hd_paid = 0;
    $grp_hd_disc = 0;
    $grp_hd_end = 0;

    $grp_aging1 = 0;
    $grp_aging2 = 0;
    $grp_aging3 = 0;
    $grp_aging4 = 0;
    $grp_aging5 = 0;
    $grp_aging6 = 0;
    $j = 0;
}

$tbl.= '<tfoot>
	<tr>
                <td></td>
		<td class="border-foot" style="border-left:2px solid black;" valign="top" align="right"><b style="font-size:1.1em;">GRAND TOTAL :</b></td>
		<td class="border-foot" valign="top" align="right"><b>' . number_format($sum_inv_total) . '</b></td>
		<td class="border-foot" valign="top" align="right"><b>' . number_format($sum_hd_begin) . '</b></td>
                <td class="border-foot" valign="top" align="right"><b>' . number_format($sum_hd_purprice) . '</b></td>
		<td class="border-foot" valign="top" align="right"><b>' . number_format($sum_hd_paid) . '</b></td>
		<td class="border-foot" valign="top" align="right"><b>' . number_format($sum_hd_disc) . '</b></td>
		<td class="border-foot" valign="top" align="right"><b>' . number_format($sum_hd_end) . '</b></td>
                <td class="border-foot" valign="top"><b>Qty : ' . $sumqty . ' Unit</b></td>
                <td class="border-foot" valign="top" align="right"><b>' . number_format($sum_aging1) . '</b></td>
                <td class="border-foot" valign="top" align="right"><b>' . number_format($sum_aging2) . '</b></td>
                <td class="border-foot" valign="top" align="right"><b>' . number_format($sum_aging3) . '</b></td>
                <td class="border-foot" valign="top" align="right"><b>' . number_format($sum_aging4) . '</b></td>
                <td class="border-foot" valign="top" align="right"><b>' . number_format($sum_aging5) . '</b></td>
                <td class="border-foot" style="border-right:2px solid black;" valign="top" align="right"><b>' . number_format($sum_aging6) . '</b></td>    
	</tr></tfoot>';
$tbl .='
</table>


</div>
';
?>