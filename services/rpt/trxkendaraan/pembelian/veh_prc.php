<?php

$comp_name = "BELUM DI SET";
if (isset($_SESSION['comp_name'])) {
    $comp_name = $_SESSION['comp_name'];
}

$tbl .= '
<div id="cntr1" align="center">
<table width="100%">
<tr><td valign="top" align="center"><b style="font-size:1.5em;">' . $comp_name . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.5em;">' . $rptTitle . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.1em;">Group By ' . $title . '</b></td></tr>';

if($filterdesc !== ''){
    $tbl .= '    <tr><td valign="top" align="center"><span style="font-size:1.1em;">Filter By ' . $filterdesc . '</span></td></tr>';
}   

$tbl .='<tr><td valign="top" align="center"><b>DATE : ' . dateView($pur_date1) . ' UP TO ' . dateView($pur_date2) . '</b></td></tr>
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
<tr >
	<th valign="top" align="left"><b>Invoice Date</b></th>
	<th valign="top" align="left" width="80"><b>Invoice No.</b></th>
	<th valign="top" align="left"><b>Chassis</b></th>
	<th valign="top" align="left"><b>Engine</b></th>
	<th valign="top" align="left"><b>Brand</b></th>
	<th valign="top" align="left" width="90"><b>Type</b></th>
	<th valign="top" align="center"><b>Year</b></th>
	<th valign="top" align="left"><b>Transm</b></th>
	<th valign="top" align="left"><b>Supplier<br />Code</b></th>
	<th valign="top" align="left"><b>Supplier<br />DO(SJ) No.</b></th>
	<th valign="top" align="left"><b>Supplier<br>DO(SJ) Date</b></th>
	<th valign="top" align="left" ><b>Supplier<br />Receipt No.</b></th>
	<th valign="top" align="left" ><b>Supplier<br />Receipt Date</b></th>
	<th valign="top" align="left" width="110"><b>Supplier<br />Tax No.</b></th>
	<th valign="top" align="center"><b>Supplier<br />Tax Date</b></th>
        <th valign="top" align="right" width="30px"><b>Qty<br>(Unit)</b></th>
	<th valign="top" align="right" width="80px"><b>Purchase<br />Price</b></th>
</tr>
</thead>
<tr><td valign="top"></td></tr>
';

$i = 0;
$j = 0;
$last_veh_code = '';
$last_veh_name = '';
$last_color_name = '';
$last_color_code = '';

$lnQty = 0;
$lnQty2 = 0;
$sum_qty = 0;

$value = 0;
$value2 = 0;
$sum_value = 0;

while ($dtlrow = mysql_fetch_array($dtl)) {

    if ($last_color_name != $dtlrow['color_name']) {
        if ($i >= 1) {

            $tbl.= '
			<tr>
				<td valign="top"  align="right" colspan="15">TOTAL ' . $last_veh_code . ' : ' . $last_veh_name . ':</td>
				<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($lnQty) . '</td>
				<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($value) . '</td>
			</tr>';
            $i = 0;
            $lnQty = 0;
            $value = 0;
        }


        if ($j >= 1) {
            $tbl.= '
			<tr>
				<td valign="top"  align="right" colspan="15"><b style="font-size:1.1em;">TOTAL ' . $last_color_code . ' : ' . $last_color_name . ':</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($lnQty2) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($value2) . '</b></td>
			</tr>';
            $j = 0;
            $lnQty2 = 0;
            $value2 = 0;
        }


        $tbl.= '<tr><td valign="top" colspan="17" align="left"><b style="font-size:1.1em;">*** ' . $dtlrow['color_code'] . ' : ' . $dtlrow['color_name'] . ' ***</b></td></tr>';

        $last_color_name = $dtlrow['color_name'];
        $last_color_code = $dtlrow['color_code'];

        $tbl.= '<tr><td valign="top" colspan="17" align="left"><b style="font-size:1.1em;">' . $dtlrow['veh_code'] . ' : ' . $dtlrow['veh_name'] . '</b></td></tr>';
        $last_veh_name = $dtlrow['veh_name'];
        $last_veh_code = $dtlrow['veh_code'];
    } elseif ($last_veh_name != $dtlrow['veh_name']) {

        if ($i >= 1) {

            $tbl.= '
			<tr>
				<td valign="top"  align="right" colspan="15">TOTAL ' . $last_veh_code . ' : ' . $last_veh_name . ':</td>
				<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($lnQty) . '</td>
				<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($value) . '</td>
			</tr>';
            $i = 0;
            $lnQty = 0;
            $value = 0;
        }

        $tbl.= '<tr><td valign="top" colspan="17" align="left"><b style="font-size:1.1em;">' . $dtlrow['veh_code'] . ' : ' . $dtlrow['veh_name'] . '</b></td></tr>';
        $last_veh_name = $dtlrow['veh_name'];
        $last_veh_code = $dtlrow['veh_code'];
    }


    $lnQty +=$dtlrow['qty'];
    $lnQty2 +=$dtlrow['qty'];
    $sum_qty +=$dtlrow['qty'];

    $value +=$dtlrow['tot_price'];
    $value2 +=$dtlrow['tot_price'];

    $sum_value = $sum_value + $dtlrow['tot_price'];

    $pur_date = dateView($dtlrow['pur_date']);
    $sji_date = dateView($dtlrow['sji_date']);
    $kwiti_date = dateView($dtlrow['kwiti_date']);
    $fpi_date = dateView($dtlrow['fpi_date']);
    
    $tbl.= '
	<tr>
		<td valign="top" align="left">' . $pur_date . '</td>
		<td valign="top" align="left">' . $dtlrow['pur_inv_no'] . '</td>
		<td valign="top" align="left">' . $dtlrow['chassis'] . '</td>
		<td valign="top" align="left">' . $dtlrow['engine'] . '</td>
		<td valign="top" align="left">' . $dtlrow['veh_brand'] . '</td>
		<td valign="top" align="left">' . $dtlrow['veh_type'] . '</td>
		<td valign="top" align="center">' . $dtlrow['veh_year'] . '</td>
		<td valign="top" align="left">' . $dtlrow['veh_transm'] . '</td>	
		<td valign="top" align="left">' . $dtlrow['supp_code'] . '</td>
		<td valign="top" align="left">' . $dtlrow['sji_no'] . '</td>
		<td valign="top" align="center">' . $sji_date . '</td>
		<td valign="top" align="left">' . $dtlrow['kwiti_no'] . '</td>
		<td valign="top" align="left">' . $kwiti_date . '</td>
		<td valign="top" align="left">' . $dtlrow['fpi_no'] . '</td>
		<td valign="top" align="center">' . $fpi_date . '</td>
		<td valign="top" align="right">' . number_format($dtlrow['qty']) . '</td>
		<td valign="top" align="right">' . number_format($dtlrow['tot_price']) . '</td>		
	</tr>';
    $i++;
    $j++;
    unset($dtlrow);
}

if ($i >= 1) {

    $tbl.= '
			<tr>
				<td valign="top"  align="right" colspan="15">TOTAL ' . $last_veh_code . ' : ' . $last_veh_name . ':</td>
				<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($lnQty) . '</td>
				<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($value) . '</td>
			</tr>';
    $i = 0;
    $lnQty = 0;
    $value = 0;
}


if ($j >= 1) {
    $tbl.= '
			<tr>
				<td valign="top"  align="right" colspan="15"><b style="font-size:1.1em;">TOTAL ' . $last_color_code . ' : ' . $last_color_name . ':</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($lnQty2) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($value2) . '</b></td>
			</tr>';
    $j = 0;
    $lnQty2 = 0;
    $value2 = 0;
}
$tbl.= '
<tr><td valign="top" colspan="17"><br /></td></tr>
<tfoot>
<tr>
	<td valign="top"  colspan="13"></td>
	<td class="border-foot" valign="top" style="border-left:2px solid black;border-top:2px solid black;border-bottom:2px solid black;" align="right" colspan="2"><b>GRAND TOTAL:</b></td>
	<td class="border-foot" valign="top" style="border-bottom:2px solid black;;border-top:2px solid black;" align="right"><b>' . number_format($sum_qty) . '</b></td>
	<td class="border-foot" valign="top" style="border-right:2px solid black;border-top:2px solid black;border-bottom:2px solid black;" align="right"><b>' . number_format($sum_value) . '</b></td>
</tr></tfoot>';

$tbl .='
</table>


</div>
';
?>