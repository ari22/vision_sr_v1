<?php

$tbl .= '
    <div id="cntr1" align="center">
<table width="85%">
<tr><td  valign="top" align="center"><b style="font-size:1.5em;">' . $comp_name . '</b></td></tr>
<tr><td  valign="top" align="center"><b style="font-size:1.5em;">' . $rptTitle . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.1em;">Group By ' . $title . '</b></td></tr>';

if($filterdesc !== ''){
    $tbl .= '    <tr><td valign="top" align="center"><span style="font-size:1.1em;">Filter By ' . $filterdesc . '</span></td></tr>';
} 

$tbl .='<tr><td  valign="top" align="center"><b>DATE : ' . dateView($po_date1) . ' UP TO ' . dateView($po_date2) . '</b></td></tr>
</table>
';

$tbl .= '
<table width="85%">
<tr>
<td></td>
<td  valign="top" align="right"><b>Printed On: </b>' . date('d/m/Y') . '</td>
</tr>
</table>';

$tbl .= '
<table width="85%" >
<thead style="border:2px solid black !important;padding-top:5px;padding-bottom:20px !important;">
<tr>
	<th class="border-head"  valign="top" align="left" width="70px"><b>PO Date</b></th>
	<th class="border-head"  valign="top" align="left" width="150px"><b>PO No.</b></th>
	<th class="border-head"  valign="top" align="left" width="100px"><b>Supplier Code</b></th>
        <th class="border-head"  valign="top" align="left" width="100px"><b>Brand</b></th>
	<th class="border-head"  valign="top" align="left" width="120px"><b>Type</b></th>
	<th class="border-head"  valign="top" align="center" width="50px"><b>Year</b></th>
	<th class="border-head"  valign="top" align="center" width="100px"><b>Transmission</b></th>
	<th class="border-head"  valign="top" align="left" width="90px"><b>Made By</b></th>
	<th class="border-head"  valign="top" align="left" width="90px"><b>Approved By</b></th>
	<th class="border-head"  valign="top" align="center" width="50px"><b>Qty</b></th>
	<th class="border-head"  valign="top" align="right" width="90px" ><b>PO Price</b></th>

</tr>
</thead>';

$tbl .='<tr><td><br /></td></tr>';

$i = 0;
$j = 0;
$qty = 0;
$last_veh_code = '';
$last_veh_name = '';
$last_color_name = '';
$last_color_code = '';
$lnQty = 0;
$value = 0;
$lSum = 0;
$sum_qty = 0;
$sum_value = 0;
$sum_color_value = 0;
while ($dtlrow = mysql_fetch_array($dtl)) {

    if ($last_color_code != $dtlrow['color_code']) {

        if ($j >= 1) {
            $tbl.= '
			<tr>
				<td  valign="top" colspan="9" align="right">TOTAL ' . $last_veh_code . ' : '.$last_veh_name.':</td>
				<td  valign="top" align="center" style="border-top:1px solid black;">' . number_format($lnQty) . '</td>
				<td  valign="top" align="right" style="border-top:1px solid black;">' . number_format($value) . '</td>
						
			</tr>';
            $tbl .='<tr><td></td></tr>';

            $lSum = 0;
            $lnQty = 0;
            $value = 0;
            $j = 0;
        }

        if ($i >= 1) {
            $tbl.= '
			<tr>
				<td  valign="top" colspan="9" align="right"><b style="font-size:1.1em;">TOTAL ' . $last_color_code . ' : ' . $last_color_name . ':</b></td>
				<td  valign="top" align="center" style="border-top:1px solid black;"><b>' . number_format($qty) . '</b></td>
				<td  valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($sum_color_value) . '</b></td>
			</tr>';
            $tbl .='<tr><td></td></tr>';
            $i = 0;
            $qty = 0;
            $sum_color_value = 0;
        }



        $tbl.= '<tr><td  valign="top" colspan="10"><b style="font-size:1.1em;">*** ' . $dtlrow['color_code'] . ' : ' . $dtlrow['color_name'] . ' ***</b></td></tr>';

        $last_color_name = $dtlrow['color_name'];
        $last_color_code = $dtlrow['color_code'];

        $tbl .='<tr><td></td></tr>';
        $tbl.= '<tr><td  valign="top" colspan="11" align="left"><b style="font-size:1.1em;">' . $dtlrow['veh_code'] . ' : ' . $dtlrow['veh_name'] . '</b></td></tr>';
        $last_veh_name = $dtlrow['veh_name'];
        $last_veh_code = $dtlrow['veh_code'];
    }
    if ($last_veh_code != $dtlrow['veh_code']) {
        if ($j >= 1) {
            $tbl.= '
			<tr>
				<td  valign="top" colspan="9" align="right">TOTAL ' . $last_veh_code . ' : '.$last_veh_name.':</td>
				<td  valign="top" align="center" style="border-top:1px solid black;">' . number_format($lnQty) . '</td>
				<td  valign="top" align="right" style="border-top:1px solid black;">' . number_format($value) . '</td>
						
			</tr>';
            $tbl .='<tr><td></td></tr>';

            $lSum = 0;
            $lnQty = 0;
            $value = 0;
            $j = 0;
           
        }
        $tbl .='<tr><td></td></tr>';
        $tbl.= '<tr><td  valign="top" colspan="11" align="left"><b style="font-size:1.1em;">' . $dtlrow['veh_code'] . ' : ' . $dtlrow['veh_name'] . '</b></td></tr>';
        $last_veh_name = $dtlrow['veh_name'];
        $last_veh_code = $dtlrow['veh_code'];
    }

    $sum_color_value = $sum_color_value + $dtlrow['tot_price'];
    $qty++;
    $lnQty++;
    $sum_qty++;
    $value = $value + $dtlrow['tot_price'];

    $sum_value = $sum_value + $dtlrow['tot_price'];




    $tbl.= '
	<tr>
		<td  valign="top" align="left">' . dateView($dtlrow['po_date']) . '</td>
		<td  valign="top" align="left">' . $dtlrow['po_no'] . '</td>
		<td  valign="top" align="left">' . $dtlrow['supp_code'] . '</td>
                <td  valign="top" width="80px">' . $dtlrow['veh_brand'] . '</td>
		<td  valign="top" align="left">' . $dtlrow['veh_type'] . '</td>
		<td  valign="top" align="center">' . $dtlrow['veh_year'] . '</td>
		<td  valign="top" align="center">' . $dtlrow['veh_transm'] . '</td>	
		<td  valign="top" align="left">' . $dtlrow['po_made_by'] . '</td>
		<td  valign="top" align="left">' . $dtlrow['po_appr_by'] . '</td>
		<td  valign="top" align="center">' . $dtlrow['qty'] . '</td>
		<td  valign="top" align="right">' . number_format($dtlrow['tot_price']) . '</td>
	</tr>';
    $i++;
    $j++;
    unset($dtlrow);
}

if ($j >= 1) {
    $tbl.= '
			<tr>
				<td  valign="top" colspan="9" align="right">TOTAL ' . $last_veh_code . ' : '.$last_veh_name.':</td>
				<td  valign="top" align="center" style="border-top:1px solid black;">' . number_format($lnQty) . '</td>
				<td  valign="top" align="right" style="border-top:1px solid black;">' . number_format($value) . '</td>
						
			</tr>';
    $tbl .='<tr><td></td></tr>';

    $lSum = 0;
    $lnQty = 0;
    $value = 0;
    $j = 0;
   
}

if ($i >= 1) {
    $tbl.= '
			<tr>
				<td  valign="top" colspan="9" align="right"><b style="font-size:1.1em;">TOTAL ' . $last_color_code . ' : ' . $last_color_name . ':</b></td>
				<td  valign="top" align="center" style="border-top:1px solid black;"><b>' . number_format($qty) . '</b></td>
				<td  valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($sum_color_value) . '</b></td>
			</tr>';
    $tbl .='<tr><td></td></tr>';
    $i = 0;
    $qty = 0;
    $sum_color_value = 0;
}

$tbl.= '
     <tr><td><br></td></tr>
    <tfoot>
   
<tr>
	<td colspan="7"></td>
	<td class="border-foot" colspan="2" style="border-left:2px solid black;border-top:2px solid black;border-bottom:2px solid black;" valign="top"  align="right"><b>GRAND TOTAL:</b></td>
	<td class="border-foot" style="border-top:2px solid black;border-bottom:2px solid black;" valign="top"  width="50px" align="center"><b>' . number_format($sum_qty) . '</b></td>
	<td class="border-foot" style="border-right:2px solid black;border-top:2px solid black;border-bottom:2px solid black;" valign="top"  width="90px" align="right" ><b>' . number_format($sum_value) . '</b></td>
	
</tr></tfoot>';

$tbl .='</table></div>';
?>