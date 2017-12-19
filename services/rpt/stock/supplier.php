<?php

error_reporting(E_ALL ^ E_NOTICE);
$tbl .= '
<div id="cntr1" align="center">
<table width="90%">
<tr><td valign="top" align="center"><b style="font-size:1.5em;">' . $comp_name . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.5em;">' . $rptTitle . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.1em;">Group By ' . $title . '</b></td></tr>';
if($filterdesc !== ''){
    $tbl .= '    <tr><td valign="top" align="center"><span style="font-size:1.1em;">Filter By ' . $filterdesc . '</span></td></tr>';
}
$tbl .='<tr><td valign="top" align="center"><b>Stock on : ' . dateView($stk_date) . '</b></td></tr></table>';

$tbl .= '
<table width="90%">
<tr>
<td></td>
<td valign="top" align="right"><b>Printed On: </b>' . date('d/m/Y') . '</td>
</tr>
</table>';

$tbl .= '
<table width="90%">
<thead style="border:2px solid black !important;">
<tr>
	<td valign="top" width="70px"><b>Stock<br />Date</b></td>
	<td valign="top" width="120px"><b>Chassis<br>Engine</b></td>
	<td valign="top" width="80px"><b>Warehouse<br>Location</b></td>
	<td valign="top" width="100px"><b>Key No.<br>Service Book</b></td>
	<td valign="top" width="80px"><b>Year<br />Color</b></td>
	<td valign="top" width="60px"><b>Model</b></td>
	<td valign="top" width="140px"><b>Standard Optional</b></td>
	<td valign="top" width="120px"><b>PO No.<br>PO Date</b></td>
	<td valign="top" width="90px"><b>DO (SJ) No.<br>DO (SJ) Date</b></td>
	<td valign="top" width="90px" align="right"><b>Stock<br>Status</b></td>
        <td valign="top" align="right" width="90px" 	><b>Stock<br>Age</b></td>
	<td valign="top" align="right" width="80px" 	><b>Qty<br>(unit)</b></td>
</tr></thead>';

$tbl .= '<tr><td></td></tr>';


$i = 0;
$j = 0;
$last_veh_code = '';
$last_veh_name = '';
$last_supp_code = '';
$last_supp_name = '';

$end_qty = 0;
$t_end_qty = 0;


while ($dtlrow = mysql_fetch_array($dtl)) {
    $sumqty += $dtlrow['end_qty'];

    if ($last_supp_code != $dtlrow['supp_code']) {

        if ($j >= 1) {
            $tbl.= '
			<tr>
				<td valign="top" colspan="11" align="right">TOTAL ' . $last_veh_code . ' : ' . $last_veh_name . ':</td>
				<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($end_qty) . ' UNIT</td>
			</tr>';
            $j = 0;
            $end_qty = 0;
        }
        if ($i >= 1) {

            $tbl.= '
			<tr>
                            <td valign="top" colspan="11" align="right"><b style="font-size:1.1em;">TOTAL ' . $last_supp_code . ' : ' . $last_supp_name . ':</b></td>
                            <td valign="top" align="right" style="border-top:1px solid black;" ><b>' . number_format($t_end_qty) . ' UNIT</b></td>
			</tr>';

            $t_end_qty = 0;
            $i = 0;
        }

        $tbl.= '<tr><td valign="top" colspan="12" align="left"><b style="font-size:1.1em;">*** ' . $dtlrow['supp_code'] . ' : ' . $dtlrow['supp_name'] . ' *** </b></td></tr>';
        $last_supp_name = $dtlrow['supp_name'];
        $last_supp_code = $dtlrow['supp_code'];

        $tbl.= '<tr><td valign="top" colspan="12" align="left" ><b style="font-size:1.1em;">' . $dtlrow['veh_code'] . ' : ' . $dtlrow['veh_name'] . '</b></td></tr>';
        $last_veh_name = $dtlrow['veh_name'];
        $last_veh_code = $dtlrow['veh_code'];
    } elseif ($last_veh_code != $dtlrow['veh_code']) {
        if ($j >= 1) {
            $tbl.= '
			<tr>
				<td valign="top" colspan="11" align="right">TOTAL ' . $last_veh_code . ' : ' . $last_veh_name . ':</td>
				<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($end_qty) . ' UNIT</td>
			</tr>';
            $j = 0;
            $end_qty = 0;
        }
        $tbl.= '<tr><td valign="top" colspan="12" align="left" ><b style="font-size:1.1em;">' . $dtlrow['veh_code'] . ' : ' . $dtlrow['veh_name'] . '</b></td></tr>';
        $last_veh_name = $dtlrow['veh_name'];
        $last_veh_code = $dtlrow['veh_code'];
    }

    $end_qty += $dtlrow['end_qty'];
    $t_end_qty += $dtlrow['end_qty'];

    $stk_date1 = dateView($dtlrow['stk_date']);
    $po_date = dateView($dtlrow['po_date']);
    $sji_date = dateView($dtlrow['sji_date']);

    $datenow = new DateTime(date('Y-m-d'));
    
    if($dtlrow['sal_date'] !== '0000-00-00'){
       $datenow = new DateTime($dtlrow['sal_date']);
    }
    
    $stk_date = new DateTime($dtlrow['stk_date']);
    $day = $datenow->diff($stk_date);

    $tbl .= '<tr>'
            . '<td valign="top" width="70px" valign="top">' . $stk_date1 . '</td>'
            . '<td valign="top" width="120px"><b>' . $dtlrow['chassis'] . '</b><br />' . $dtlrow['engine'] . '</td>'
            . '<td valign="top" width="80px">' . $dtlrow['wrhs_code'] . '<br />' . $dtlrow['loc_code'] . '</td>'
            . '<td valign="top" width="80px">' . $dtlrow['key_no'] . '<br />' . $dtlrow['serv_book'] . '</td>'
            . '<td valign="top" width="80px"><b>' . $dtlrow['veh_year'] . '</b><br />' . $dtlrow['color_code'] . '</td>'
            . '<td valign="top" width="60px">' . $dtlrow['veh_model'] . '</td>'
            . '<td valign="top" width="140px">' . $dtlrow['stdoptcode'] . '</td>'
            . '<td valign="top" width="120px"><b>' . $dtlrow['po_no'] . '</b><br />' . $po_date . '</td>'
            . '<td valign="top" width="90px">' . $dtlrow['sji_no'] . '<br />' . $sji_date . '</td>'
            . '<td valign="top" align="right" width="90px">' . $dtlrow['stk_code'] . '</td>'
            . '<td valign="top" align="right" width="90px">' . number_format($day->days) . ' Day</td>'
            . '<td valign="top" align="right" width="80px">' . number_format($dtlrow['end_qty']) . ' UNIT</td>'
            . '</tr>';


    $i++;
    $j++;
    unset($dtlrow);
}

if ($j >= 1) {
    $tbl.= '
			<tr>
				<td valign="top" colspan="11" align="right">TOTAL ' . $last_veh_code . ' : ' . $last_veh_name . ':</td>
				<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($end_qty) . ' UNIT</td>
			</tr>';
    $j = 0;
    $end_qty = 0;
}
if ($i >= 1) {

    $tbl.= '
			<tr>
                            <td valign="top" colspan="11" align="right"><b style="font-size:1.1em;">TOTAL ' . $last_supp_code . ' : ' . $last_supp_name . ':</b></td>
                            <td valign="top" align="right" style="border-top:1px solid black;" ><b>' . number_format($t_end_qty) . ' UNIT</b></td>
			</tr>';

    $t_end_qty = 0;
    $i = 0;
}

$tbl .= '<tr><td><br /></td></tr>';
$tbl .='<tfoot>'
        . '<tr>'
        . '<td colspan="9"></td>'
        . '<td class="border-foot" style="border-left:2px solid black;border-top:2px solid black;border-bottom:2px solid black;" valign="top" align="right" colspan="2"><b>STOCK TOTAL ' . $pur_date . ' :</b></td>'
        . '<td class="border-foot" style="border-right:2px solid black;border-top:2px solid black;border-bottom:2px solid black;" valign="top" width="90" align="right"><b>' . number_format($sumqty) . ' UNIT</b></td>'
        . '</tr>'
        . '</tfoot>';

$tbl .= '</table>';
$tbl .='</div>';
