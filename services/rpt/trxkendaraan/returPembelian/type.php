<?php

error_reporting(E_ALL ^ E_NOTICE);
$tbl .= '
<div id="cntr1" align="center">
<table width="100%">
<tr><td valign="top" align="center"><b style="font-size:1.5em;">' . $comp_name . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.5em;">' . $rptTitle . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.1em;">Group By ' . $title . '</b></td></tr>';

if($filterdesc !== ''){
    $tbl .= '    <tr><td valign="top" align="center"><span style="font-size:1.1em;">Filter By ' . $filterdesc . '</span></td></tr>';
}   

$tbl .='<tr><td valign="top" align="center"><b>DATE : ' . dateView($rpr_date1) . ' UP TO ' . dateView($rpr_date2) . '</b></td></tr>
</table>
';

$tbl .= '
<table width="100%"  >
<tr>
<td valign="top"></td>
<td valign="top" align="right"><b>Printed On: </b>' . date('d/m/Y') . '</td>
</tr>
</table>';


$tbl .= '
<table width="100%">
<thead style="border:2px solid black !important;">
<tr>
<td valign="top" width="60"><b>Invoice Date</b></td>
<td valign="top" width="80"><b>Invoice No.</b></td>
<td valign="top" width="90"><b>Chassis</b></td>
<td valign="top" width="80"><b>Engine</b></td>
<td valign="top" width="60"><b>Brand</b></td>
<td valign="top" width="60"><b>Type</b></td>
<td valign="top" width="60"><b>Year</b></td>
<td valign="top" width="60"><b>Transm</b></td>
<td valign="top" width="60"><b>Supplier<br />Code</b></td>
<td valign="top" width="80"><b>Purchase<br />Invoice No.</b></td>
<td valign="top" width="60"><b>Purchase<br />Invoice Date</b></td>
<td valign="top" width="70"><b>DO(SJ) No.</b></td>
<td valign="top" width="60"><b>DO(SJ) Date</b></td>
<td valign="top" width="70"><b>Supplier<br />Receipt No.</b></td>
<td valign="top" width="60"><b>Supplier<br />Receipt Date</b></td>
<td valign="top" width="40" align="right"><b>Qty<br />(unit)</b></td>
<td valign="top" width="70" align="right"><b>Purchase<br />Price</b></td>
</tr>
</thead>';

$tbl .= '<tr><td valign="top"></td></tr>';

$i = 0;
$j = 0;

$last_veh_code = '';
$last_veh_name = '';
$last_color_name = '';
$last_color_code = '';

$lnQty = 0;
$lnQty2 = 0;
$price = 0;
$price2 = 0;

$sumQty = 0;
$sumprice = 0;

while ($dtlrow = mysql_fetch_array($dtl)) {

    $qty += 1;


    if ($last_veh_name != $dtlrow['veh_name']) {
        if ($j >= 1) {
            $tbl.= '
			<tr>
				<td valign="top" colspan="15" align="right">TOTAL ' . $last_color_code . ' : ' . $last_color_name . ':</td>
				<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($lnQty2) . '</td>
                                <td valign="top" align="right" style="border-top:1px solid black;">' . number_format($price2) . '</td>
			</tr>';
            $j = 0;
            $lnQty2 = 0;
            $price2 = 0;
        }
        if ($i >= 1) {

            $tbl.= '
			<tr>
                            <td valign="top" colspan="15" align="right"><b style="font-size:1.1em;">TOTAL ' . $last_veh_code . ' : ' . $last_veh_name . ':</b></td>
                            <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($lnQty) . '</b></td>
                            <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($price) . '</b></td>
			</tr>';


            $i = 0;
            $lnQty = 0;
            $price = 0;
        }

        $tbl.= '<tr><td valign="top" colspan="12" align="left"><b style="font-size:1.1em;">*** ' . $dtlrow['veh_code'] . ' : ' . $dtlrow['veh_name'] . ' ***</b></td></tr>';
        $last_veh_name = $dtlrow['veh_name'];
        $last_veh_code = $dtlrow['veh_code'];

        $tbl.= '<tr><td valign="top" colspan="15" align="left"><b style="font-size:1.1em;">' . $dtlrow['color_code'] . ': ' . $dtlrow['color_name'] . '</b></td></tr>';

        $last_color_name = $dtlrow['color_name'];
        $last_color_code = $dtlrow['color_code'];
    } elseif ($last_color_name != $dtlrow['color_name']) {

        if ($j >= 1) {
            $tbl.= '
			<tr>
				<td valign="top" colspan="15" align="right">TOTAL ' . $last_color_code . ' : ' . $last_color_name . ':</td>
				<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($lnQty2) . '</td>
                                <td valign="top" align="right" style="border-top:1px solid black;">' . number_format($price2) . '</td>
			</tr>';
            $j = 0;
            $lnQty2 = 0;
            $price2 = 0;
        }

        $tbl.= '<tr><td valign="top" colspan="15" align="left"><b style="font-size:1.1em;">' . $dtlrow['color_code'] . ': ' . $dtlrow['color_name'] . '</b></td></tr>';

        $last_color_name = $dtlrow['color_name'];
        $last_color_code = $dtlrow['color_code'];
    }

    $lnQty++;
    $lnQty2++;
    $sumQty++;

    $price += $dtlrow['pur_price'];
    $price2 += $dtlrow['pur_price'];
    $sumprice += $dtlrow['pur_price'];


    $rpr_date = dateView($dtlrow['rpr_date']);
    $pur_date = dateView($dtlrow['pur_date']);
    $sj_date = dateView($dtlrow['sj_date']);
    $kwiti_date = dateView($dtlrow['kwiti_date']);

    $tbl .='<tr>
            <td valign="top" width="60">' . $rpr_date . '</td>
            <td valign="top" width="80">' . $dtlrow['rpr_inv_no'] . '</td>
            <td valign="top" width="90">' . $dtlrow['chassis'] . '</td>
            <td valign="top" width="80">' . $dtlrow['engine'] . '</td>
            <td valign="top" width="60">' . $dtlrow['veh_brand'] . '</td>
            <td valign="top" width="60">' . $dtlrow['veh_type'] . '</td>
            <td valign="top" width="60">' . $dtlrow['veh_year'] . '</td>
            <td valign="top" width="60">' . $dtlrow['veh_transm'] . '</td>
            <td valign="top" width="60">' . $dtlrow['supp_code'] . '</td>
            <td valign="top" width="80">' . $dtlrow['pur_inv_no'] . '</td>
            <td valign="top" width="60">' . $pur_date . '</td>
            <td valign="top" width="70">' . $dtlrow['sj_no'] . '</td>
            <td valign="top" width="60">' . $sj_date . '</td>
            <td valign="top" width="70">' . $dtlrow['kwiti_no'] . '</td>
            <td valign="top" width="60">' . $kwiti_date . '</td>
            <td valign="top"  width="40" align="right">1</td>
            <td valign="top" width="70" align="right">' . number_format($dtlrow['pur_price']) . '</td>
            </tr>';

    $i++;
    $j++;
    unset($dtlrow);
}

if ($j >= 1) {
    $tbl.= '
			<tr>
				<td valign="top" colspan="15" align="right">TOTAL ' . $last_color_code . ' : ' . $last_color_name . ':</td>
				<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($lnQty2) . '</td>
                                <td valign="top" align="right" style="border-top:1px solid black;">' . number_format($price2) . '</td>
			</tr>';
    $j = 0;
    $lnQty2 = 0;
    $price2 = 0;
}
if ($i >= 1) {

    $tbl.= '
			<tr>
                            <td valign="top" colspan="15" align="right"><b style="font-size:1.1em;">TOTAL ' . $last_veh_code . ' : ' . $last_veh_name . ':</b></td>
                            <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($lnQty) . '</b></td>
                            <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($price) . '</b></td>
			</tr>';


    $i = 0;
    $lnQty = 0;
    $price = 0;
}

$tbl .='<tr><td valign="top"><br /></td></tr>';

$tbl .='<tfoot>';
$tbl .= '<tr>
            <td valign="top" colspan="13"></td>
            <td valign="top" colspan="2"   style="border-left:2px solid black;border-bottom:2px solid black;border-top:2px solid black;" align="right"><b style="font-size:1.1em;">GRAND TOTAL :</b></td>
            <td valign="top" align="right" style="border-bottom:2px solid black;border-top:2px solid black;"><b>' . number_format($sumQty) . '</b></td>
            <td valign="top" align="right" style="border-right:2px solid black;border-bottom:2px solid black;border-top:2px solid black;"><b>' . number_format($sumprice) . '</b></td>
	</tr>';
$tbl .='</tfoot>';

$tbl .='</table>';
