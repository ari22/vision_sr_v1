<?php

$tbl .= '
<div id="cntr1" align="center">
<table width="100%">
<tr><td align="center"><b style="font-size:1.5em;">' . $comp_name . '</b></td></tr>
<tr><td align="center"><b style="font-size:1.5em;">' . $rptTitle . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.1em;">Group By ' . $title . '</b></td></tr>';
if ($filterdesc !== '') {
    $tbl .= '    <tr><td valign="top" align="center"><span style="font-size:1.1em;">Filter By ' . $filterdesc . '</span></td></tr>';
}
$tbl .='<tr><td align="center"><b>DATE : ' . dateView($date1) . ' UP TO ' . dateView($date2) . '</b></td></tr>
</table>
';

$tbl .= '<table  width="100%"><tr><td><br /></td></tr><tr><td width="65%"></td>';

$tbl .= '<td align="right"><b>Printed On: </b>' . date('d/m/Y') . '</td></tr></table>';

$tbl .= '
<table  width="100%">
<thead style="border:2px solid black !important;">
<tr>
    <td class="border-head" valign="top" width="120"><b>Invoice No.</b></td>
    <td class="border-head" valign="top" width="80"><b>Invoice Date</b></td>
    <td class="border-head" valign="top" width="80"><b>From<br />Wrhs</b></td>
    <td class="border-head" valign="top" width="80"><b>From<br />Location</b></td>
    <td class="border-head" valign="top" width="80"><b>To<br />Wrhs</b></td>
    <td class="border-head" valign="top" width="80"><b>To<br />Location</b></td>
    <td class="border-head" valign="top" width="150"><b>Chassis</b></td>
    <td class="border-head" valign="top" width="120"><b>Engine</b></td>
    <td class="border-head" valign="top" width="80"><b>Brand</b></td>
    <td class="border-head" valign="top" width="80"><b>Type</b></td>
    <td class="border-head" valign="top" width="60"><b>Year</b></td>
    <td class="border-head" valign="top" width="50"><b>Transm</b></td>
    <td class="border-head" valign="top" width="120"><b>DO(SJ)</b></td>
    <td class="border-head" valign="top" width="80"><b>DO(SJ) Date</b></td>
    <td class="border-head" valign="top" width="80"  align="right"><b>Qty</b></td>';

$tbl .='</tr></thead>';
$tbl .= '<tr><td></td></tr>';
$no = 1;
$lnQty = 0;
$lnQty2 = 0;
$sumQty = 0;

$i = 0;
$j = 0;
$last_veh_code = '';
$last_veh_name = '';
$last_color_code = '';
$last_color_name = '';

while ($dtlrow = mysql_fetch_array($dtl)) {

    if ($last_color_name != $dtlrow['color_name']) {

        if ($j >= 1) {
            $tbl.= '<tr>
			<td valign="top" colspan="14" align="right">TOTAL ' . $last_veh_code . ' : ' . $last_veh_name . ':</td>
			<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($lnQty2) . ' UNIT</td>
                        </tr>';
            $j = 0;
            $lnQty2 = 0;
        }

        if ($i >= 1) {
            $tbl.= '<tr>
			<td valign="top" colspan="14" align="right"><b style="font-size:1.1em;">TOTAL ' . $last_color_code . ' : ' . $last_color_name . ':</b></td>
			<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($lnQty) . ' UNIT</b></td>';


            $tbl.='</tr>';

            $i = 0;
            $lnQty = 0;
        }



        $tbl.= '<tr><td valign="top" colspan="15" align="left"><b style="font-size:1.1em;">*** ' . $dtlrow['color_code'] . ' : ' . $dtlrow['color_name'] . ' ***</b></td></tr>';
        $last_color_code = $dtlrow['color_code'];
        $last_color_name = $dtlrow['color_name'];

        $tbl.= '<tr><td valign="top" colspan="15" align="left"><b style="font-size:1.1em;">' . $dtlrow['veh_code'] . ': ' . $dtlrow['veh_name'] . '</b></td></tr>';
        $last_veh_name = $dtlrow['veh_name'];
        $last_veh_code = $dtlrow['veh_code'];
        
    } elseif ($last_veh_name != $dtlrow['veh_name']) {

        $tbl.= '<tr><td valign="top"  colspan="15"  align="left"><b style="font-size:1.1em;"> ' . $dtlrow['veh_code'] . ' : ' . $dtlrow['veh_name'] . '</b></td></tr>';
        $last_veh_name = $dtlrow['veh_name'];
        $last_veh_code = $dtlrow['veh_code'];
    }

    $lnQty++;
    $lnQty2++;
    $sumQty++;



    $mov_date = dateView($dtlrow['mov_date']);
    $sji_date = dateView($dtlrow['sji_date']);

    $tbl .= '<tr>';
    $tbl .= '<td valign="top">' . $dtlrow['mov_inv_no'] . '</td>';
    $tbl .= '<td valign="top">' . $mov_date . '</td>';
    $tbl .= '<td valign="top">' . $dtlrow['wrhs_from'] . '</td>';
    $tbl .= '<td valign="top">' . $dtlrow['loc_from'] . '</td>';
    $tbl .= '<td valign="top">' . $dtlrow['wrhs_to'] . '</td>';
    $tbl .= '<td valign="top">' . $dtlrow['loc_to'] . '</td>';
    $tbl .= '<td valign="top">' . $dtlrow['chassis'] . '</td>';
    $tbl .= '<td valign="top">' . $dtlrow['engine'] . '</td>';
    $tbl .= '<td valign="top">' . $dtlrow['veh_brand'] . '</td>';
    $tbl .= '<td valign="top">' . $dtlrow['veh_type'] . '</td>';
    $tbl .= '<td valign="top">' . $dtlrow['veh_year'] . '</td>';
    $tbl .= '<td valign="top">' . $dtlrow['veh_transm'] . '</td>';  
    $tbl .= '<td valign="top">' . $dtlrow['sji_no'] . '</td>';
    $tbl .= '<td valign="top">' . $sji_date . '</td>';
    $tbl .= '<td valign="top" align="right">' . $dtlrow['qty'] . ' UNIT</td>';
    $tbl .= '<tr>';


    $i++;
    $j++;
    unset($dtlrow);
}

if ($j >= 1) {
    $tbl.= '<tr>
			<td valign="top" colspan="14" align="right">TOTAL ' . $last_veh_code . ' : ' . $last_veh_name . ':</td>
			<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($lnQty2) . ' UNIT</td>
                        </tr>';
    $j = 0;
    $lnQty2 = 0;
}

if ($i >= 1) {
    $tbl.= '<tr>
			<td valign="top" colspan="14" align="right"><b style="font-size:1.1em;">TOTAL ' . $last_color_code . ' : ' . $last_color_name . ':</b></td>
			<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($lnQty) . ' UNIT</b></td>';

    $tbl.='</tr>';

    $i = 0;
    $lnQty = 0;
}
$tbl.= '<tr><td><br /><br /></td></tr>';
$tbl.= '<tfoot>';
$tbl.= '<tr>
            <td  colspan="12"></td>
            <td class="border-foot" valign="top" colspan="2" align="right" style="border-left:2px solid black;"><b style="font-size:1.1em;">GRAND TOTAL :</b></td>
            <td class="border-foot" valign="top" align="right" style="border-right:2px solid black;"><b>' . number_format($sumQty) . ' UNIT</b></td>';

$tbl.='</tr>';
$tbl .='</table>';
?>