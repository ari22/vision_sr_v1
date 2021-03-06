<?php

$tbl .= '
<div id="cntr1" align="center">
<table width="95%">
<tr><td valign="top" align="center"><b style="font-size:1.1em;">' . $comp_name . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.1em;">'.$titlehead.'</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.1em;">Group By ' . $title . '</b></td></tr>';
if ($filterdesc !== '') {
    $tbl .= '    <tr><td valign="top" align="center"><span style="font-size:1.1em;">Filter By ' . $filterdesc . '</span></td></tr>';
}

$tbl .= '<tr><td valign="top" align="center"><b>DATE : ' . dateView($so_date1) . ' UP TO ' . dateView($so_date2) . '</b></td></tr>
</table>
';

$tbl .= '
<table width="95%">
<tr>
<td></td>
<td valign="top" align="right"><b>Printed On: </b>' . date('d/m/Y') . '</td>
</tr>
</table>';

$tbl .= '
<table width="95%">
<thead style="border:2px solid black !important;font-weight:bold;">
<tr>
    <td class="border-head" valign="top" width="60">No.</td>
    <td class="border-head" valign="top" >Cancel<br />Date</td>
    <td class="border-head" valign="top" >DO No.<br />DO Date</td>
    <td class="border-head" valign="top" >Invoice No.<br />Invoice Date</td>
    <td class="border-head" valign="top" >Chassis<br />Engine</td>
    <td class="border-head" valign="top" >Wrhs<br />Sales</td>
    <td class="border-head" valign="top" >Customer</td>
    <td class="border-head" valign="top" >Note</td>
    <td class="border-head" valign="top" >Cancel By</td>
    <td class="border-head" valign="top"  align="right">Qty<br />(Unit)</td>
</tr>

</thead>';

$tbl .= '<tr><td></td></tr>';

$i = 0;
$j = 0;
$n = 1;

$lnQty = 0;
$lnQty2 = 0;
$sum_qty = 0;

$last_veh_code = '';
$last_veh_name = '';
$last_color_code = '';
$last_color_name = '';


while ($dtlrow = mysql_fetch_array($dtl)) {
    if ($last_veh_code != $dtlrow['veh_code']) {

        if ($i >= 1) {

            $tbl.= '
			<tr>
				<td valign="top" colspan="9" align="right">TOTAL ' . $last_color_code . ' : ' . $last_color_name . ':</td>
				<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($lnQty) . '</td>
			</tr>';


            $i = 0;
            $lnQty = 0;
        }

        if ($j >= 1) {

            $tbl.= '
			<tr>
				<td valign="top" colspan="9" align="right"><b style="font-size:1.1em;" align="right">TOTAL ' . $last_veh_code . ' : ' . $last_veh_name . ':</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($lnQty2) . '</b></td>
			</tr>';

            $j = 0;
            $lnQty2 = 0;
        }
        $tbl.= '<tr><td valign="top" colspan="10" align="left"><b style="font-size:1.1em;">*** ' . $dtlrow['veh_code'] . ' : ' . $dtlrow['veh_name'] . ' ***</b></td></tr>';
        $last_veh_code = $dtlrow['veh_code'];
        $last_veh_name = $dtlrow['veh_name'];


        $tbl.= '<tr><td valign="top" colspan="10" align="left"><b style="font-size:1.1em;">' . $dtlrow['color_code'] . ' : ' . $dtlrow['color_name'] . '</b></td></tr>';
        $last_color_code = $dtlrow['color_code'];
        $last_color_name = $dtlrow['color_name'];

        $n = 1;
    } elseif ($last_color_code != $dtlrow['color_code']) {
        if ($i >= 1) {

            $tbl.= '
			<tr>
				<td valign="top" colspan="8" align="right">TOTAL ' . $last_color_code . ' : ' . $last_color_name . ':</td>
				<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($lnQty) . '</td>
			</tr>';

            $lnQty = 0;
            $i = 0;
        }
        $tbl.= '<tr><td valign="top" colspan="10" align="left"><b style="font-size:1.1em;">' . $dtlrow['color_code'] . ' : ' . $dtlrow['color_name'] . '</b></td></tr>';

        $last_color_code = $dtlrow['color_code'];
        $last_color_name = $dtlrow['color_name'];
        $n = 1;
    }


    $lnQty++;
    $lnQty2++;
    $sum_qty++;


    $canc_date = dateView($dtlrow['canc_date']);
    $kwit_date = dateView($dtlrow['kwit_date']);
    $sal_date = dateView($dtlrow['sal_date']);

    $tbl.='<tr>';
    $tbl.='<td valign="top" align="right">' . $n . '.</td>';
    $tbl.='<td valign="top">' . $canc_date . '</td>';
    $tbl.='<td valign="top">' . $dtlrow['kwit_no'] . '<br />' . $kwit_date . '</td>';
    $tbl.='<td valign="top">' . $dtlrow['sal_inv_no'] . '<br />' . $sal_date . '</td>';
    $tbl.='<td valign="top">' . $dtlrow['chassis'] . '<br />' . $dtlrow['engine'] . '</td>';
    $tbl.='<td valign="top">' . $dtlrow['wrhs_code'] . '<br />' . $dtlrow['srep_code'] . '</td>';
    $tbl.='<td valign="top">' . $dtlrow['cust_name'] . '</td>';
    $tbl.='<td valign="top">' . $dtlrow['canc_note'] . '</td>';
    $tbl.='<td valign="top">' . $dtlrow['canc_by'] . '</td>';
    $tbl.='<td valign="top" align="right">' . number_format(1) . '</td>';
    $tbl.='</tr>';

    $n++;
    $i++;
    $j++;
    unset($dtlrow);
}

if ($i >= 1) {

    $tbl.= '
			<tr>
				<td valign="top" colspan="9" align="right">TOTAL ' . $last_color_code . ' : ' . $last_color_name . ':</td>
				<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($lnQty) . '</td>
			</tr>';


    $i = 0;
    $lnQty = 0;
}

if ($j >= 1) {

    $tbl.= '
			<tr>
				<td valign="top" colspan="9" align="right"><b style="font-size:1.1em;" align="right">TOTAL ' . $last_veh_code . ' : ' . $last_veh_name . ':</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($lnQty2) . '</b></td>
			</tr>';

    $j = 0;
    $lnQty2 = 0;
}

$tbl.= '<tr><td><br /><br /></td></tr>';
$tbl.= '<tfoot>
			<tr>    <td colspan="7"></td>
				<td class="border-foot" valign="top" colspan="2" align="right" style="border-left:2px solid black;"><b style="font-size:1.1em;">GRAND TOTAL : </b></td>
				<td class="border-foot" valign="top" align="right"  style="border-right:2px solid black;"><b>' . number_format($sum_qty) . '</b></td>
	    </tr></tfoot>';

$tbl .='</table>';
$tbl .= '</div>';
