<?php

$tbl .= '
<div id="cntr1" align="center">
<table width="100%">
<tr><td valign="top" align="center"><b style="font-size:1.5em;">' . $comp_name . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.5em;">' .$rptTitle.' '. $title . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.1em;">By Leasing Code & Customer Name</b></td></tr>
<tr><td valign="top" align="center"><b>DATE : ' . dateView($date1) . ' UP TO ' . dateView($date2) . '</b></td></tr>
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
                <td valign="top" width="30" align="left"><b>No.</b></td>
                <td valign="top" width="150" align="left"><b>Leasing<br />Customer Name</b></td>
                <td valign="top" width="100" align="left"><b>SPK No.<br />SPK Date</b></td>
                <td valign="top" width="80" align="left"><b>Model<br />Type</b></td>
                <td valign="top" width="100" align="left"><b>Chassis<br />Engine</b></td>
                <td valign="top" width="150" align="left"><b>Year<br />Color</b></td>
                <td valign="top" width="80" align="right"><b>Credit Term<br />(month(s))</b></td>
                <td valign="top" width="90" align="right"><b>Installment<br />(/Month)</b></td>
                <td valign="top" width="90" align="right"><b>Interest<br />(/Year)</b></td>
                <td valign="top" width="30"></td>
                <td valign="top" width="120" align="left"><b>Insurance<br />Sales</b></td>
                <td valign="top" width="90" align="right"><b>Refund/<br />Commission</b></td>
                <td valign="top" width="90" align="right"><b>Subsidy/<br />Discount</b></td>
				<td valign="top" width="90" align="right"><b>Sales Price/<br />BBN</b></td>
                <td valign="top" width="90" align="right"><b>Discount/<br />Etc.</b></td>
				<td valign="top" width="90" align="right"><b>Sub Total/<br />Total Price</b></td>
            </tr>
        </thead>';

$tbl .= '<tr><td valign="top"></td></tr>';

$no = 1;
$i = 0;
$last_wrhs_code = '';


$crdinscomm = 0;
$crdinsdisc = 0;
$veh_price = 0;
$veh_bbn = 0;
$vehdisc = 0;
$vehmisc = 0;
$vehat = 0;
$vehtotal = 0;

$tcrdinscomm = 0;
$tcrdinsdisc = 0;
$tvehprice = 0;
$tvehbbn = 0;
$tvehdisc = 0;
$tvehmisc = 0;
$tvehat = 0;
$tvehtotal = 0;


while ($dtlrow = mysql_fetch_array($dtl)) {
    $tcrdinscomm += $dtlrow['crdinscomm'];
    $tcrdinsdisc += $dtlrow['crdinsdisc'];
	$tvehprice += $dtlrow['veh_price'];
	$tvehbbn += $dtlrow['veh_bbn'];
	$tvehdisc += $dtlrow['veh_disc'];
	$tvehmisc += $dtlrow['veh_misc'];
	$tvehat += $dtlrow['veh_at'];
	$tvehtotal += $dtlrow['veh_total'];

    if ($last_wrhs_code != $dtlrow['wrhs_code']) {
        if ($i >= 1) {
            $tbl .= '<tr>';
            $tbl .= '<td valign="top" colspan="11" align="right"><b>TOTAL ' . $last_wrhs_code . '</b></td>';
            $tbl .= '<td valign="top" width="90" align="right" style="border-top:1px solid black;">' . number_format($crdinscomm) . '</td>';
            $tbl .= '<td valign="top" width="90" align="right" style="border-top:1px solid black;">' . number_format($crdinsdisc) . '</td>';
			$tbl .= '<td valign="top" width="90" align="right" style="border-top:1px solid black;">' . number_format($veh_price) . '<br />' . number_format($veh_bbn) . '</td>';
            $tbl .= '<td valign="top" width="90" align="right" style="border-top:1px solid black;">' . number_format($vehdisc) . '<br />' . number_format($vehmisc) . '</td>';
			$tbl .= '<td valign="top" width="90" align="right" style="border-top:1px solid black;">' . number_format($vehat) . '<br />' . number_format($vehtotal) . '</td>';
            $tbl .= '</tr>';

            $i = 0;
            $crdinscomm = 0;
			$crdinsdisc = 0;
			$veh_price = 0;
			$veh_bbn = 0;
			$vehdisc = 0;
			$vehmisc = 0;
			$vehat = 0;
			$vehtotal = 0;
        }
        $tbl.= '<tr><td valign="top" colspan="13" align="left"><b style="font-size:1.1em;">***WAREHOUSE : ' . $dtlrow['wrhs_code'] . '***</b></td></tr>';
        $last_wrhs_code = $dtlrow['wrhs_code'];
    }

    $crdinscomm += $dtlrow['crdinscomm'];
    $crdinsdisc += $dtlrow['crdinsdisc'];
	$veh_price += $dtlrow['veh_price'];
	$veh_bbn += $dtlrow['veh_bbn'];
	$vehdisc += $dtlrow['veh_disc'];
	$vehmisc += $dtlrow['veh_misc'];
	$vehat += $dtlrow['veh_at'];
	$vehtotal += $dtlrow['veh_total'];

    $so_date = dateView($dtlrow['so_date']);

    $leasing = '-';
    if($dtlrow['lease_code'] !== ''){
        $leasing = $dtlrow['lease_code'] . ' : ' . $dtlrow['lease_name'];
    }
    
    $tbl .= '<tr>';
    $tbl .= '<td valign="top" width="30" align="left">' . $no++ . '.</td>';
    $tbl .= '<td valign="top" width="150" align="left">' . $leasing . '<br />'. $dtlrow['cust_name'] . '</td>';
    $tbl .= '<td valign="top" width="100" align="left"><b>' . $dtlrow['so_no'] . '</b><br />' . $so_date . '</td>';
    $tbl .= '<td valign="top" width="80" align="left">' . $dtlrow['veh_model'] . '<br />' . $dtlrow['veh_type'] . '</td>';
    $tbl .= '<td valign="top" width="100" align="left">' . $dtlrow['chassis'] . '<br />' . $dtlrow['engine'] . '</td>';
    $tbl .= '<td valign="top" width="150" align="left">' . $dtlrow['veh_year'] . '<br />' . $dtlrow['color_name'] . '</td>';
    $tbl .= '<td valign="top" width="80" align="right">' . number_format($dtlrow['crd_term']) . '</td>';
    $tbl .= '<td valign="top" width="90" align="right">' . number_format($dtlrow['crd_mthpay']) . '</td>';
    $tbl .= '<td valign="top" width="90" align="right">' . $dtlrow['crd_irate'] . '</td>';
    $tbl .= '<td valign="top" width="30"></td>';
    $tbl .= '<td valign="top" width="120" align="left">' . $dtlrow['crdinscode'] . '<br />' . $dtlrow['srep_name'] . '</td>';
    $tbl .= '<td valign="top" width="90" align="right">' . number_format($dtlrow['crdinscomm']) . '</td>';
    $tbl .= '<td valign="top" width="90" align="right">' . number_format($dtlrow['crdinsdisc']) . '</td>';
		$tbl .= '<td valign="top" width="90" align="right">' . number_format($dtlrow['veh_price']) . '<br />' . number_format($dtlrow['veh_bbn']) . '</td>';
	$tbl .= '<td valign="top" width="90" align="right">' . number_format($dtlrow['veh_disc']) . '<br />' . number_format($dtlrow['veh_misc']) . '</td>';
	$tbl .= '<td valign="top" width="90" align="right">' . number_format($dtlrow['veh_at']) . '<br />' . number_format($dtlrow['veh_total']) . '</td>';
    $tbl .= '</tr>';

    $i++;

    unset($dtlrow);
}

if ($i >= 1) {
            $tbl .= '<tr>';
            $tbl .= '<td valign="top" colspan="11" align="right"><b>TOTAL ' . $last_wrhs_code . '</b></td>';
            $tbl .= '<td valign="top" width="90" align="right" style="border-top:1px solid black;">' . number_format($crdinscomm) . '</td>';
            $tbl .= '<td valign="top" width="90" align="right" style="border-top:1px solid black;">' . number_format($crdinsdisc) . '</td>';
			$tbl .= '<td valign="top" width="90" align="right" style="border-top:1px solid black;">' . number_format($veh_price) . '<br />' . number_format($veh_bbn) . '</td>';
            $tbl .= '<td valign="top" width="90" align="right" style="border-top:1px solid black;">' . number_format($vehdisc) . '<br />' . number_format($vehmisc) . '</td>';
			$tbl .= '<td valign="top" width="90" align="right" style="border-top:1px solid black;">' . number_format($vehat) . '<br />' . number_format($vehtotal) . '</td>';
            $tbl .= '</tr>';

            $i = 0;
            $crdinscomm = 0;
			$crdinsdisc = 0;
			$veh_price = 0;
			$veh_bbn = 0;
			$vehdisc = 0;
			$vehmisc = 0;
			$vehat = 0;
			$vehtotal = 0;
}

$tbl .='<tr><td><br /></td></tr>';
$tbl .='<tfoot>';
$tbl .= '<tr>';
$tbl .= '<td colspan="9"></td>';
$tbl .= '<td class="border-foot" style="border-left:2px solid black;border-top:2px solid black;border-bottom:2px solid black;" valign="top" colspan="2" align="right"><b>GRAND TOTAL :</b></td>';
$tbl .= '<td class="border-foot" style="border-top:2px solid black;border-bottom:2px solid black;" valign="top" width="90" align="right"><b>' . number_format($tcrdinscomm) . '</b></td>';
$tbl .= '<td class="border-foot" style="border-right:2px solid black;border-top:2px solid black;border-bottom:2px solid black;" valign="top" width="90" align="right"><b>' . number_format($tcrdinsdisc) . '</b></td>';
$tbl .= '<td class="border-foot" style="border-right:2px solid black;border-top:2px solid black;border-bottom:2px solid black;" valign="top" width="90" align="right"><b>' . number_format($tvehprice) . '<br />' . number_format($tvehbbn) . '</b></td>';
$tbl .= '<td class="border-foot" style="border-right:2px solid black;border-top:2px solid black;border-bottom:2px solid black;" valign="top" width="90" align="right"><b>' . number_format($tvehdisc) . '<br />' . number_format($tvehmisc) . '</b></td>';
$tbl .= '<td class="border-foot" style="border-right:2px solid black;border-top:2px solid black;border-bottom:2px solid black;" valign="top" width="90" align="right"><b>' . number_format($tvehat) . '<br />' . number_format($tvehtotal) . '</b></td>';
$tbl .= '</tr>';
$tbl .= '</tfoot>';
$tbl .= '</table>';
