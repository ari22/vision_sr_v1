<?php

$comp_name = "BELUM DI SET";
if (isset($_SESSION['comp_name'])) {
    $comp_name = $_SESSION['comp_name'];
}
$tbl .= '
<div id="cntr1"  align="center">
<table width="95%">
<tr><td valign="top" align="center"><b style="font-size:1.5em;">' . $comp_name . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.5em;">' . $rptTitle . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.1em;">Group By ' . $title . '</b></td></tr>';

if ($filterdesc !== '') {
    $tbl .= '    <tr><td valign="top" align="center"><span style="font-size:1.1em;">Filter By ' . $filterdesc . '</span></td></tr>';
}

$tbl .='<tr><td valign="top" align="center"><b>DATE : ' . dateView($po_date1) . ' UP TO ' . dateView($po_date2) . '</b></td></tr>
</table>
';

$tbl .= '
<table width="95%"  >
<tr>
<td></td>
<td valign="top" align="right"><b>Printed On: </b>' . date('d/m/Y') . '</td>
</tr>
</table>';

$tbl .= '
<table width="95%">
<thead style="border:2px solid black !important;">
<tr>
<th valign="top" width="60" align="left"><b>PO Date</b></th>
<th valign="top" width="100" align="left"><b>PO No.</b></th>
<th valign="top" width="50" align="left"><b>Supplier</b></th>
<th valign="top" width="50" align="left"><b>Brand</b></th>
<th valign="top" width="50" align="left"><b>Type</b></th>
<th valign="top" width="60" align="left"><b>Year</b></th>
<th valign="top" width="60" align="left"><b>Transm</b></th>
<th valign="top" width="100" align="left"><b>Color</b></th>
<th valign="top" width="80" align="left"><b>Made By</b></th>
<th valign="top" width="80" align="left"><b>Approved By</b></th>
<th valign="top" width="50" align="right"><b>Qty Order</b></th>
<th valign="top" width="50" align="right"><b>Received</b></th>
<th valign="top" width="50" align="right"><b>Received Not</b></th>
<th valign="top" width="90" align="right"><b>Price</b></th>
</tr>
</thead>';


$tbl .= '<tr><td></td></tr>';

$i = 0;
$j = 0;
$last_veh_code = '';
$last_veh_name = '';
$last_loc_name = '';
$last_loc_code = '';

$lnQty = 0;
$lnQty2 = 0;


$qty = 0;
$rcv_qty = 0;
$beg_qty = 0;
$price = 0;

$tqty = 0;
$trcv_qty = 0;
$tbeg_qty = 0;
$tprice = 0;

$sumprice = 0;

$sumqty = 0;
$sumrcv_qty = 0;
$sumbeg_qty = 0;
$sumprice = 0;


while ($dtlrow = mysql_fetch_array($dtl)) {

    if ($dtlrow['pur_inv_no'] !== '') {
        $dtlrow['rcv_qty'] = 1;
        $dtlrow['beg_qty'] = 0;
    } else {
        $dtlrow['rcv_qty'] = 0;
        $dtlrow['beg_qty'] = 1;
    }

    $sumqty += $dtlrow['qty'];
    $sumrcv_qty += $dtlrow['rcv_qty'];
    $sumbeg_qty += $dtlrow['beg_qty'];
    $sumprice += $dtlrow['unit_price'];

    if ($last_loc_code != $dtlrow['loc_code']) {
        if ($j >= 1) {
            $tbl.= '
			<tr>
				<td valign="top" colspan="10" align="right">TOTAL ' . $last_veh_code . ' : ' . $last_veh_name . ':</td>
                                <td valign="top" align="right" style="border-top:1px solid black;">' . number_format($qty) . '</td>
                                <td valign="top" align="right" style="border-top:1px solid black;">' . number_format($rcv_qty) . '</td>
                                <td valign="top" align="right" style="border-top:1px solid black;">' . number_format($beg_qty) . ' UNIT</td>
                                <td valign="top" align="right" style="border-top:1px solid black;">' . number_format($price) . '</td>
			</tr>';
            $j = 0;
            $qty = 0;
            $rcv_qty = 0;
            $beg_qty = 0;
            $price = 0;
            $lnQty2 = 0;
        }
        if ($i >= 1) {

            $tbl.= '
			<tr>
                            <td valign="top" colspan="10" align="right"><b style="font-size:1.1em;">TOTAL ' . $last_loc_code . ' : </b></td>
                            <td valign="top" align="right" style="border-top:1px solid black;">' . number_format($tqty) . '</td>
                            <td valign="top" align="right" style="border-top:1px solid black;">' . number_format($trcv_qty) . '</td>
                            <td valign="top" align="right" style="border-top:1px solid black;">' . number_format($tbeg_qty) . ' UNIT</td>
                            <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($tprice) . '</b></td>
			</tr>';

            $tlSum = 0;
            $tqty = 0;
            $trcv_qty = 0;
            $tbeg_qty = 0;
            $tprice = 0;
            $i = 0;
            $lnQty = 0;
        }

        $tbl.= '<tr><td valign="top" colspan="12" align="left"><b style="font-size:1.1em;">*** LOCATION : ' . $dtlrow['loc_code'] . '  ***</b></td></tr>';

        //$last_loc_name = $dtlrow['loc_name'];
        $last_loc_code = $dtlrow['loc_code'];

        $tbl.= '<tr><td valign="top" colspan="12" align="left"><b style="font-size:1.1em;"> ' . $dtlrow['veh_code'] . ': ' . $dtlrow['veh_name'] . '</b></td></tr>';
        $last_veh_name = $dtlrow['veh_name'];
        $last_veh_code = $dtlrow['veh_code'];
    } elseif ($last_veh_name != $dtlrow['veh_name']) {
        if ($j >= 1) {
            $tbl.= '
			<tr>
				<td valign="top" colspan="10" align="right">TOTAL ' . $last_veh_code . ' : ' . $last_veh_name . ':</td>
                                <td valign="top" align="right" style="border-top:1px solid black;">' . number_format($qty) . '</td>
                                <td valign="top" align="right" style="border-top:1px solid black;">' . number_format($rcv_qty) . '</td>
                                <td valign="top" align="right" style="border-top:1px solid black;">' . number_format($beg_qty) . ' UNIT</td>
                                <td valign="top" align="right" style="border-top:1px solid black;">' . number_format($price) . '</td>
			</tr>';
            $j = 0;
            $qty = 0;
            $rcv_qty = 0;
            $beg_qty = 0;
            $price = 0;
            $lnQty2 = 0;
        }
        $tbl.= '<tr><td valign="top" colspan="12" align="left"><b style="font-size:1.1em;"> ' . $dtlrow['veh_code'] . '</b></td></tr>';

        $last_veh_name = $dtlrow['veh_name'];
        $last_veh_code = $dtlrow['veh_code'];
    }

    //$sum_color_value = $sum_color_value + $dtlrow['tot_price'];
    $lnQty++;
    $lnQty2++;
    //$qty++;

    $qty += $dtlrow['qty'];
    $rcv_qty += $dtlrow['rcv_qty'];
    $beg_qty += $dtlrow['beg_qty'];


    $tqty += $dtlrow['qty'];
    $trcv_qty += $dtlrow['rcv_qty'];
    $tbeg_qty += $dtlrow['beg_qty'];

    $price += $dtlrow['unit_price'];
    $tprice += $dtlrow['unit_price'];

    $po_date = dateView($dtlrow['po_date']);

    $tbl .='<tr>
                <td valign="top">' . $po_date . '</td>
                <td valign="top">' . $dtlrow['po_no'] . '</td>
                <td valign="top">' . $dtlrow['supp_code'] . '</td>
                <td valign="top">' . $dtlrow['veh_brand'] . '</td>
                <td valign="top">' . $dtlrow['veh_type'] . '</td>
                <td valign="top">' . $dtlrow['veh_year'] . '</td>
                <td valign="top">' . $dtlrow['veh_transm'] . '</td>
                <td valign="top">' . $dtlrow['color_name'] . '</td>
                <td valign="top">' . $dtlrow['po_made_by'] . '</td>
                <td valign="top">' . $dtlrow['po_appr_by'] . '</td>
                <td valign="top" align="right">' . $dtlrow['qty'] . '</td>
                <td valign="top" align="right">' . $dtlrow['rcv_qty'] . '</td>
                <td valign="top" align="right">' . $dtlrow['beg_qty'] . ' UNIT</td>
                <td valign="top" align="right">' . number_format($dtlrow['unit_price']) . '</td>
            </tr>';


    $i++;
    $j++;
    unset($dtlrow);
}

if ($j >= 1) {
    $tbl.= '
			<tr>
				<td valign="top" colspan="10" align="right">TOTAL ' . $last_veh_code . ' : ' . $last_veh_name . ':</td>
                                <td valign="top" align="right" style="border-top:1px solid black;">' . number_format($qty) . '</td>
                                <td valign="top" align="right" style="border-top:1px solid black;">' . number_format($rcv_qty) . '</td>
                                <td valign="top" align="right" style="border-top:1px solid black;">' . number_format($beg_qty) . ' UNIT</td>
                                <td valign="top" align="right" style="border-top:1px solid black;">' . number_format($price) . '</td>
			</tr>';
    $j = 0;
    $qty = 0;
    $rcv_qty = 0;
    $beg_qty = 0;
    $price = 0;
    $lnQty2 = 0;
}
if ($i >= 1) {

    $tbl.= '
			<tr>
                            <td valign="top" colspan="10" align="right"><b style="font-size:1.1em;">TOTAL ' . $last_loc_code .':</b></td>
                            <td valign="top" align="right" style="border-top:1px solid black;">' . number_format($tqty) . '</td>
                            <td valign="top" align="right" style="border-top:1px solid black;">' . number_format($trcv_qty) . '</td>
                            <td valign="top" align="right" style="border-top:1px solid black;">' . number_format($tbeg_qty) . ' UNIT</td>
                            <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($tprice) . '</b></td>
			</tr>';

    $tlSum = 0;
    $tqty = 0;
    $trcv_qty = 0;
    $tbeg_qty = 0;
    $tprice = 0;
    $i = 0;
    $lnQty = 0;
}
$tbl .= '<tr><td><br /></td></tr>';
$tbl .='<tfoot>'
        . '<tr>'
        . '<td valign="top" colspan="8"></td>'
        . '<td class="border-foot"  colspan="2" valign="top" style="border-left:2px solid black;border-top:2px solid black;border-bottom:2px solid black;" width="80" align="right"><b>GRAND TOTAL :</b></td>'
        . '<td class="border-foot" valign="top" style="border-top:2px solid black;border-bottom:2px solid black;" width="50" align="right">' . number_format($sumqty) . '</td>'
        . '<td class="border-foot" valign="top" style="border-top:2px solid black;border-bottom:2px solid black;" width="50" align="right">' . number_format($sumrcv_qty) . '</td>'
        . '<td class="border-foot" valign="top" style="border-top:2px solid black;border-bottom:2px solid black;" width="50" align="right">' . number_format($sumbeg_qty) . ' UNIT</td>'
        . '<td class="border-foot" valign="top" style="border-right:2px solid black;border-top:2px solid black;border-bottom:2px solid black;" width="90" align="right"><b>' . number_format($sumprice) . '</b></td>'
        . '</tr></tfoot>'
        . '</table>';

$tbl .='</div>';
?>