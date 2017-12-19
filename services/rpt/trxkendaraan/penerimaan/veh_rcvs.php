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
<table width="80%"  >
<tr>
<td></td>
<td valign="top" align="right"><b>Printed On: </b>' . date('d/m/Y') . '</td>
</tr>
</table>';

$tbl .= '
<table width="80%">
<thead style="border:2px solid black !important;">

<tr>
	<th valign="top" width="70px" align="left">Invoice Date</th>
	<th valign="top" width="120px" align="left">Invoice No.</th>
	<th valign="top" width="150px" align="left">Chassis</th>
	<th valign="top" width="100px" align="left">Engine</th>
	<th valign="top" width="80px" align="left">Brand</th>
	<th valign="top" width="120px" align="left">Type</th>
	<th valign="top" width="40px" align="center">Year</th>
	<th valign="top" width="40px" align="center">Transm</th>
        <th valign="top" width="50px" align="left">Color</th>
	<th valign="top" width="90px" align="left">Supplier<br />Code</th>
	<th valign="top" width="90px" align="left">DO (SJ) No.</th>
	<th valign="top" width="80px" align="left">DO (SJ) Date</th>
	<th valign="top" width="80px" align="right">Qty</th>
</tr>
</thead>';
$tbl .='<tr><td></td></tr>';
$i = 0;
$j = 0;
$last_veh_code = '';
$last_veh_name = '';
$last_supp_name = '';
$last_supp_code = '';
$lnQty = 0;
$lnQty2 = 0;
$value = 0;
$lSum = 0;
$sum_qty = 0;
$sum_value = 0;
$sum_color_value = 0;


while ($dtlrow = mysql_fetch_array($dtl)) {

    if ($last_supp_name != $dtlrow['supp_name']) {
        if ($i >= 1) {

            $tbl.= '
			<tr>
				<td  colspan="12" valign="top" align="right">TOTAL ' . $last_veh_code . ' : ' . $last_veh_name . ':</td>
				<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($lnQty) . ' UNIT</td>
			</tr>';

            $lnQty = 0;
            $i = 0;
        }

        if ($j >= 1) {
            $tbl.= '
			<tr>
				<td  colspan="12" valign="top" align="right"><b style="font-size:1.1em;">TOTAL ' . $last_supp_code . ' : ' . $last_supp_name . ':</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($lnQty2) . ' UNIT</b></td>
			</tr>';
            $j = 0;
            $lnQty2 = 0;
        }

        $tbl.= '<tr><td valign="top" colspan="13" align="left"><b style="font-size:1.1em;">*** ' . $dtlrow['supp_code'] . ': ' . $dtlrow['supp_name'] . ' *** </b></td></tr>';

        $last_supp_name = $dtlrow['supp_name'];
        $last_supp_code = $dtlrow['supp_code'];

        $tbl.= '<tr><td valign="top" colspan="13" align="left"><b style="font-size:1.1em;">' . $dtlrow['veh_code'] . ' : ' . $dtlrow['veh_name'] . '</b></td></tr>';
        $last_veh_name = $dtlrow['veh_name'];
        $last_veh_code = $dtlrow['veh_code'];
    } elseif ($last_veh_name != $dtlrow['veh_name']) {
        if ($i >= 1) {

            $tbl.= '
			<tr>
				<td  colspan="12" valign="top" align="right">TOTAL ' . $last_veh_code . ' : ' . $last_veh_name . ':</td>
				<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($lnQty) . ' UNIT</td>
			</tr>';

            $lnQty = 0;
            $i = 0;
        }

        $tbl.= '<tr><td valign="top" colspan="13" align="left"><b style="font-size:1.1em;">' . $dtlrow['veh_code'] . ' : ' . $dtlrow['veh_name'] . '</b></td></tr>';
        $last_veh_name = $dtlrow['veh_name'];
        $last_veh_code = $dtlrow['veh_code'];
    }


    $sum_color_value = $sum_color_value + $dtlrow['tot_price'];
    $lnQty +=$dtlrow['qty'];
    $lnQty2 +=$dtlrow['qty'];
    $sum_qty +=$dtlrow['qty'];
    $value = $value + $dtlrow['tot_price'];

    $sum_value = $sum_value + $dtlrow['tot_price'];

    $pur_date = dateView($dtlrow['pur_date']);
    $sji_date = dateView($dtlrow['sji_date']);

    $tbl.= '
	<tr>
		<td valign="top">' . $pur_date . '</td>
		<td valign="top">' . $dtlrow['pur_inv_no'] . '</td>
		<td valign="top" align="left">' . $dtlrow['chassis'] . '</td>
		<td valign="top" align="left">' . $dtlrow['engine'] . '</td>
		<td valign="top" align="left">' . $dtlrow['veh_brand'] . '</td>
		<td valign="top" align="left">' . $dtlrow['veh_type'] . '</td>
		<td valign="top" align="center">' . $dtlrow['veh_year'] . '</td>
		<td valign="top" align="center">' . $dtlrow['veh_transm'] . '</td>	
		<td valign="top" align="left">' . $dtlrow['supp_code'] . '</td>
		<td valign="top" align="left">' . $dtlrow['supp_code'] . '</td>
		<td valign="top" align="left">' . $dtlrow['sji_no'] . '</td>
		<td valign="top" align="center">' . $sji_date . '</td>
		<td valign="top" align="right">' . number_format($dtlrow['qty']) . ' UNIT</td>
	</tr>';
    $i++;
    $j++;
    unset($dtlrow);
}

if ($i >= 1) {

    $tbl.= '
			<tr>
				<td  colspan="12" valign="top" align="right">TOTAL ' . $last_veh_code . ' : ' . $last_veh_name . ':</td>
				<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($lnQty) . ' UNIT</td>
			</tr>';

    $lnQty = 0;
    $i = 0;
}

if ($j >= 1) {
    $tbl.= '
			<tr>
				<td  colspan="12" valign="top" align="right"><b style="font-size:1.1em;">TOTAL ' . $last_supp_code . ' : ' . $last_supp_name . ':</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($lnQty2) . ' UNIT</b></td>
			</tr>';
    $j = 0;
    $lnQty2 = 0;
}

$tbl.= '
<tr><td valign="top" colspan="12"><br /></td></tr>
<tfoot>
<tr>    
        <td valign="top"  colspan="10"></td>
	<td valign="top"  colspan="2" style="padding-top:10px;padding-bottom:10px;border-left:2px solid black;border-top:2px solid black;border-bottom:2px solid black;" align="right" ><b>GRAND TOTAL:</b></td>
	<td valign="top" style="padding-top:10px;padding-bottom:10px;border-right:2px solid black;border-top:2px solid black;border-bottom:2px solid black;" align="right"><b>' . number_format($sum_qty) . ' UNIT</b></td>
	
</tr></tfoot>';

$tbl .='</table>';

$tbl .='</div>';
?>