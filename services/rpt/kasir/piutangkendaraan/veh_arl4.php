<?php

//=========CHANGE LOG========
//ganti semua <td jadi <td valign="top"
//pembetulan format date
//engine => engine No.;chassis => Chassis No.

$tbl .= '
<div id="cntr1" align="center">
<table width="100%">
<tr><td valign="top" align="center"><b style="font-size:1.5em;">' . $comp_name . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.5em;">' . $rptTitle . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.1em;">' . $title . '</b></td></tr>
<tr><td valign="top" align="center"><b>Date : ' . $_REQUEST['ar_date'] . '</b></td></tr>
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
	<td valign="top" align="left" 	width="120px"><b>Invoice Date<br>Invoice No.</b></td>
	<td valign="top" align="left" width="200px"><b>Chassis No.<br>Cust. Name</b></td>
	<td valign="top" align="right" 	width="80px"><b>Invoice<br />Amount</b></td>
	<td valign="top" align="right" 	width="80px"><b>Beginning<br />Balance</b></td>
	<td valign="top" align="right" 	width="80px"><b>Payment</b></td>
	<td valign="top" align="right" 	width="80px"><b>Discount</b></td>
	<td valign="top" align="right" 	width="80px"><b>Ending<br />Balance</b></td>
	<td valign="top" align="right" 	width="80px"><b>Due Date</b></td>
	<td valign="top" align="center" width="80px"><b>Not<br />Due</b></td>
	<td valign="top" align="right" 	width="80px"><b><=2 Week<br>0-14 day</b></td>
	<td valign="top" align="right" 	width="80px"><b><=4 Week<br>15-28 day</b></td>
	<td valign="top" align="right" 	width="80px"><b><=8 Week<br>29-56 day</b></td>
	<td valign="top" align="right" 	width="80px"><b><=12 Week<br>57-84 day</b></td>
	<td valign="top" align="right" 	width="80px"><b>>12 Week</b></td>';
$tbl .= '</tr><thead>';
$tbl .= '<tr><td valign="top"></td></tr>';

$i = 0;
$j = 0;
$last_lease_code = '';
$last_lease_name = '';
$lnQty = 0;
$inv_total = 0;
$pd_begin = 0;
$pd_paid = 0;
$pd_disc = 0;

$lSum = 0;
$sum_inv_total = 0;
$sum_pd_begin = 0;
$sum_inv_total = 0;
$sum_pd_paid = 0;
$sum_pd_disc = 0;
$sum_pd_begin = 0;

$pd_end = 0;
$sum_pd_end = 0;

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


$lease_inv_total = 0;
$lease_pd_begin = 0;
$lease_pd_paid = 0;
$lease_pd_disc = 0;
$lease_pd_end = 0;
$lease_pd_sales = 0;

$nonlease_inv_total = 0;
$nonlease_pd_begin = 0;
$nonlease_pd_paid = 0;
$nonlease_pd_disc = 0;
$nonlease_pd_end = 0;
$nonlease_pd_sales = 0;


$sumlease_inv_total += $aging1;
$sumlease_pd_begin += $aging2;
$sumlease_pd_paid += $aging3;
$sumlease_pd_disc += $aging4;
$sumlease_pd_end += $aging5;
$sumlease_pd_sales += $aging6;

$sumnonlease_inv_total += $aging1;
$sumnonlease_pd_begin += $aging2;
$sumnonlease_pd_paid += $aging3;
$sumnonlease_pd_disc += $aging4;
$sumnonlease_pd_end += $aging5;
$sumnonlease_pd_sales += $aging6;


$dat = strtotime($ar_date);

while ($dtlrow = mysql_fetch_array($dtl)) {

    $saldate = strtotime($dtlrow['sal_date']);
    $salexp = explode('-', $dtlrow['sal_date']);
    $salperiode = $salexp[0] . $salexp[1];

    if ($rpt_by == '1') {
        if ($salperiode == $periode) {
            $dtlrow['veh_total'] = $dtlrow['pd_begin'];
            $dtlrow['pd_begin'] = 0;
        } else {
            //$dtlrow['pd_begin'] = $dtlrow['pd_begin']- $dtlrow['pd_paid'];
            $dtlrow['veh_total'] = 0;
        }

        if ($dtlrow['veh_total'] !== 0) {
            $dtlrow['pd_end'] = $dtlrow['veh_total'] - $dtlrow['pd_paid'] - $dtlrow['pd_disc'];
        }
        if ($dtlrow['pd_begin'] !== 0) {
            $dtlrow['pd_end'] = $dtlrow['pd_begin'] - $dtlrow['pd_paid'] - $dtlrow['pd_disc'];
        }
    }

    if ($last_lease_code != $dtlrow['lease_code']) {
        if ($i >= 1) {

            $tbl.= '
			<tr>
				<td valign="top" colspan="2" align="right"><b style="font-size:1.1em;">TOTAL ' . $last_lease_code . ' : ' . $last_lease_name . ':</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($inv_total) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($pd_begin) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($pd_paid) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($pd_disc) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($pd_end) . '</b></td>
                                <td></td>
                                <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($aging1) . '</b></td>
                                <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($aging2) . '</b></td>
                                <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($aging3) . '</b></td>
                                <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($aging4) . '</b></td>
                                <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($aging5) . '</b></td>
                                <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($aging6) . '</b></td>
			</tr>';

            $lnQty = 0;
            $inv_total = 0;
            $pd_begin = 0;
            $pd_paid = 0;
            $pd_end = 0;
            $aging1 = 0;
            $aging2 = 0;
            $aging3 = 0;
            $aging4 = 0;
            $aging5 = 0;
            $aging6 = 0;
        }
        $tbl.= '<tr><td valign="top" colspan="13" align="left"><b style="font-size:1.1em;">*** ' . $dtlrow['lease_code'] . ' : ' . $dtlrow['lease_name'] . ' ***</b></td></tr>';
        $last_lease_code = $dtlrow['lease_code'];
        $last_lease_name = $dtlrow['lease_name'];
    }

    if ($dtlrow['lease_code'] !== '') {
        $lease_inv_total += $dtlrow['inv_total'];
        $lease_pd_begin += $dtlrow['pd_begin'];
        $lease_pd_paid += $dtlrow['pd_paid'];
        $lease_pd_disc += $dtlrow['pd_disc'];
        $lease_pd_end += $dtlrow['pd_end'];
        $lease_pd_sales += $dtlrow['veh_total'];
    } else {
        $nonlease_inv_total += $dtlrow['inv_total'];
        $nonlease_pd_begin += $dtlrow['pd_begin'];
        $nonlease_pd_paid += $dtlrow['pd_paid'];
        $nonlease_pd_disc += $dtlrow['pd_disc'];
        $nonlease_pd_end += $dtlrow['pd_end'];
        $nonlease_pd_sales += $dtlrow['veh_total'];
    }


    $lnQty++;
    $inv_total += $dtlrow['inv_total'];
    $pd_begin += $dtlrow['pd_begin'];
    $pd_paid += $dtlrow['pd_paid'];
    $pd_disc += $dtlrow['pd_disc'];
    $pd_end += $dtlrow['pd_end'];
    $lSum++;
    $sum_inv_total += $dtlrow['inv_total'];
    $sum_pd_begin += $dtlrow['pd_begin'];
    $sum_pd_paid += $dtlrow['pd_paid'];
    $sum_pd_disc += $dtlrow['pd_disc'];
    $sum_pd_end += $dtlrow['pd_end'];

    $sal_date = dateView($dtlrow['sal_date']);
    $due_date = dateView($dtlrow['due_date']);

    $datenow = new DateTime($ar_date);
    switch ($aging) {
        case '1':
            if ($dtlrow['due_date'] !== '0000-00-00') {
                $d_date = new DateTime($dtlrow['due_date']);
                $dsdate = strtotime($dtlrow['due_date']);
            } else {
                $d_date = new DateTime($dtlrow['sal_date']);
                $dsdate = strtotime($dtlrow['sal_date']);
            }

            break;
        case '2':
            $d_date = new DateTime($dtlrow['sal_date']);
            $dsdate = strtotime($dtlrow['sal_date']);

            break;
    }

    if ($dsdate > $dat) {
        $dtlrow['aging'] = -1;
    } else {
        $day = $datenow->diff($d_date);
        $dtlrow['aging'] = $day->days;
    }
    

    if ($dtlrow['aging'] < 0) {
        $aging1 += $dtlrow['pd_end'];
        $sum_aging1 += $dtlrow['pd_end'];

        if ($dtlrow['lease_code'] !== '') {
            $aginglease1 += $dtlrow['pd_end'];
        } else {
            $agingnonlease1 += $dtlrow['pd_end'];
        }
    }

    if ($dtlrow['aging'] >= 0 && $dtlrow['aging'] <= 14) {
        $aging2 += $dtlrow['pd_end'];
        $sum_aging2 += $dtlrow['pd_end'];

        if ($dtlrow['lease_code'] !== '') {
            $aginglease2 += $dtlrow['pd_end'];
        } else {
            $agingnonlease2 += $dtlrow['pd_end'];
        }
    }

    if ($dtlrow['aging'] >= 15 && $dtlrow['aging'] <= 28) {
        $aging3 += $dtlrow['pd_end'];
        $sum_aging3 += $dtlrow['pd_end'];

        if ($dtlrow['lease_code'] !== '') {
            $aginglease3 += $dtlrow['pd_end'];
        } else {
            $agingnonlease3 += $dtlrow['pd_end'];
        }
    }

    if ($dtlrow['aging'] >= 29 && $dtlrow['aging'] <= 56) {
        $aging4 += $dtlrow['pd_end'];
        $sum_aging4 += $dtlrow['pd_end'];

        if ($dtlrow['lease_code'] !== '') {
            $aginglease4 += $dtlrow['pd_end'];
        } else {
            $agingnonlease4 += $dtlrow['pd_end'];
        }
    }

    if ($dtlrow['aging'] >= 57 && $dtlrow['aging'] <= 84) {
        $aging5 += $dtlrow['pd_end'];
        $sum_aging5 += $dtlrow['pd_end'];

        if ($dtlrow['lease_code'] !== '') {
            $aginglease5 += $dtlrow['pd_end'];
        } else {
            $agingnonlease5 += $dtlrow['pd_end'];
        }
    }

    if ($dtlrow['aging'] > 84) {
        $aging6 += $dtlrow['pd_end'];
        $sum_aging6 += $dtlrow['pd_end'];

        if ($dtlrow['lease_code'] !== '') {
            $aginglease6 += $dtlrow['pd_end'];
        } else {
            $agingnonlease6 += $dtlrow['pd_end'];
        }
    }




    $sal_date = dateView($dtlrow['sal_date']);
    $due_date = dateView($dtlrow['due_date']);

    $tbl.= '
	<tr>
		<td valign="top" align="left">' . $sal_date . '<br>' . $dtlrow['sal_inv_no'] . '</td>
		<td valign="top" align="left">' . $dtlrow['chassis'] . '<br>' . $dtlrow['cust_name'] . '</td>
		<td valign="top" align="right">' . number_format($dtlrow['inv_total']) . '</td>
		<td valign="top" align="right">' . number_format($dtlrow['pd_begin']) . '</td>
		<td valign="top" align="right">' . number_format($dtlrow['pd_paid']) . '</td>
		<td valign="top" align="right">' . number_format($dtlrow['pd_disc']) . '</td>
		<td valign="top" align="right">' . number_format($dtlrow['pd_end']) . '</td>
		<td valign="top" align="right">' . $due_date . '</td>';
    $tbl .= '<td valign="top" align="center">';

    if ($dtlrow['aging'] < 0) {
       $tbl.= number_format($dtlrow['pd_end']);
    }
    $tbl .= '</td>';
    $tbl .= '<td valign="top" align="right">';
    if ($dtlrow['aging'] >= 0 && $dtlrow['aging'] <= 14) {
        $tbl.= number_format($dtlrow['pd_end']);
    }
    $tbl .= '</td>';
    $tbl .= '<td valign="top" align="right">';
    if ($dtlrow['aging'] > 14 && $dtlrow['aging'] <= 28) {
        $tbl.= number_format($dtlrow['pd_end']);
    }
    $tbl .= '</td>';
    $tbl .= '<td valign="top" align="right">';
    if ($dtlrow['aging'] > 28 && $dtlrow['aging'] <= 56) {
        $tbl.= number_format($dtlrow['pd_end']);
    }
    $tbl .= '</td>';
    $tbl .= '<td valign="top" align="right">';
    if ($dtlrow['aging'] > 56 && $dtlrow['aging'] <= 84) {
        $tbl.= number_format($dtlrow['pd_end']);
    }
    $tbl .= '</td>';
    $tbl .= '<td valign="top" align="right">';
    if ($dtlrow['aging'] > 84) {
        $tbl.= number_format($dtlrow['pd_end']);
    }
    $tbl .= '</td>
	</tr>';

    $i++;
    $j++;
    unset($dtlrow);
}
if ($i >= 1) {

    $tbl.= '
			<tr>
				<td valign="top" colspan="2" align="right"><b style="font-size:1.1em;">TOTAL ' . $last_lease_code . ' : ' . $last_lease_name . ':</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($inv_total) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($pd_begin) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($pd_paid) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($pd_disc) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($pd_end) . '</b></td>
                                 <td></td>
                                <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($aging1) . '</b></td>
                                <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($aging2) . '</b></td>
                                <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($aging3) . '</b></td>
                                <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($aging4) . '</b></td>
                                <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($aging5) . '</b></td>
                                <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($aging6) . '</b></td>
			</tr>';

    $lnQty = 0;
    $inv_total = 0;
    $pd_begin = 0;
    $pd_paid = 0;
    $pd_end = 0;
    $aging1 = 0;
    $aging2 = 0;
    $aging3 = 0;
    $aging4 = 0;
    $aging5 = 0;
    $aging6 = 0;
}

$tbl.= '
	<tr>    
                <td></td>
		<td style="border-left:2px solid black;border-top:2px solid black;" valign="top"  align="right"><b style="font-size:1.1em;">Leasing :</b></td>
		<td style="border-top:2px solid black;" valign="top" align="right"><b>' . number_format($lease_inv_total) . '</b></td>
		<td style="border-top:2px solid black;" valign="top" align="right"><b>' . number_format($lease_pd_begin) . '</b></td>
		<td style="border-top:2px solid black;" valign="top" align="right"><b>' . number_format($lease_pd_paid) . '</b></td>
		<td style="border-top:2px solid black;" valign="top" align="right"><b>' . number_format($lease_pd_disc) . '</b></td>
		<td style="border-top:2px solid black;" valign="top" align="right"><b>' . number_format($lease_pd_end) . '</b></td>
		<td style="border-top:2px solid black;" ></td>
		<td style="border-top:2px solid black;" valign="top" align="right"><b>' . number_format($aginglease1) . '</b></td>
		<td style="border-top:2px solid black;" valign="top" align="right"><b>' . number_format($aginglease2) . '</b></td>
		<td style="border-top:2px solid black;" valign="top" align="right"><b>' . number_format($aginglease3) . '</b></td>
		<td style="border-top:2px solid black;" valign="top" align="right"><b>' . number_format($aginglease4) . '</b></td>                   
		<td style="border-top:2px solid black;" valign="top" align="right"><b>' . number_format($aginglease5) . '</b></td>
		<td style="border-right:2px solid black;border-top:2px solid black;" valign="top" align="right"><b>' . number_format($aginglease6) . '</b></td>
		
	</tr>';
$tbl.= '
	<tr>    
                <td></td>
		<td style="border-left:2px solid black;" valign="top"  align="right"><b style="font-size:1.1em;">Non Leasing :</b></td>
		<td valign="top" align="right"><b>' . number_format($nonlease_inv_total) . '</b></td>
		<td valign="top" align="right"><b>' . number_format($nonlease_pd_begin) . '</b></td>
		<td valign="top" align="right"><b>' . number_format($nonlease_pd_paid) . '</b></td>
		<td valign="top" align="right"><b>' . number_format($nonlease_pd_disc) . '</b></td>
		<td valign="top" align="right"><b>' . number_format($nonlease_pd_end) . '</b></td>
		<td></td>
		<td valign="top" align="right"><b>' . number_format($agingnonlease1) . '</b></td>
		<td valign="top" align="right"><b>' . number_format($agingnonlease2) . '</b></td>
		<td valign="top" align="right"><b>' . number_format($agingnonlease3) . '</b></td>
		<td valign="top" align="right"><b>' . number_format($agingnonlease4) . '</b></td>                   
		<td valign="top" align="right"><b>' . number_format($agingnonlease5) . '</b></td>
		<td style="border-right:2px solid black;" valign="top" align="right"><b>' . number_format($agingnonlease6) . '</b></td>
	</tr>';

$tbl.= '
        <tfoot>
            <tr>
                <td></td>
		<td style="border-left:2px solid black;border-bottom:2px solid black;" valign="top" align="right"><b style="font-size:1.1em;">GRAND TOTAL :</b></td>
		<td style="border-bottom:2px solid black;"  valign="top" align="right"><b>' . number_format($sum_inv_total) . '</b></td>
		<td style="border-bottom:2px solid black;" valign="top" align="right"><b>' . number_format($sum_pd_begin) . '</b></td>
		<td style="border-bottom:2px solid black;" valign="top" align="right"><b>' . number_format($sum_pd_paid) . '</b></td>
		<td style="border-bottom:2px solid black;" valign="top" align="right"><b>' . number_format($sum_pd_disc) . '</b></td>
		<td style="border-bottom:2px solid black;" valign="top" align="right"><b>' . number_format($sum_pd_end) . '</b></td>
                <td style="border-bottom:2px solid black;" ></td>
                <td style="border-bottom:2px solid black;" valign="top" align="right"><b>' . number_format($sum_aging1) . '</b></td>
                <td style="border-bottom:2px solid black;" valign="top" align="right"><b>' . number_format($sum_aging2) . '</b></td>
                <td style="border-bottom:2px solid black;" valign="top" align="right"><b>' . number_format($sum_aging3) . '</b></td>
                <td style="border-bottom:2px solid black;" valign="top" align="right"><b>' . number_format($sum_aging4) . '</b></td>
                <td style="border-bottom:2px solid black;" valign="top" align="right"><b>' . number_format($sum_aging5) . '</b></td>
                <td style="border-right:2px solid black;border-bottom:2px solid black;" valign="top" align="right"><b>' . number_format($sum_aging6) . '</b></td>  
            </tr>
        </tfoot>';
$tbl .='
</table>


</div>
';
?>