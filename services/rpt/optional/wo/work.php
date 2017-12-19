<?php
$tbl .= '
<div id="cntr1" align="center">
<table width="80%">
<tr><td align="center"><b style="font-size:1.5em;">'.$comp_name.'</b></td></tr>
<tr><td align="center"><b style="font-size:1.5em;">'.$rptTitle.'</b></td></tr>
<tr><td align="center"><b style="font-size:1.1em;">'.$title.'</b></td></tr>
<tr><td align="center"><b>DATE : '.dateView($date1).' UP TO '.dateView($date2).'</b></td></tr>
</table>
';


$tbl .= '
<table width="80%"  >
<tr>
<td></td>
<td align="right"><b>Printed On: </b>' . date('d/m/Y') . '</td>
</tr>
</table>';

$tbl .= '<table width="80%">';
$tbl .= '<thead style="border:2px solid black !important;">
            <tr>
                <th width="30" align="left"><b>No.</b></th>
                <th align="left"><b>Work Code</b></th>
                <th align="left"><b>Work Name</b>
                <th align="left"><b>WO Date</b></th>
                <th align="left"><b>WO No.</b></th>
                <th align="left"><b>SPK No.</b></th>
                <th align="left"><b>Chassis</b></th>
                <th align="right"><b>Netto Price</b></th>';
$tbl .= '</tr></thead>';
$tbl .= '<tr><td></td></tr>';

$no = 1;
$i = 0;
$j = 0;

$t_price_bd = 0;

$price_bd = 0;

$last_wk_code = '';
$last_wk_desc = '';

while ($dtlrow = mysql_fetch_array($dtl)) {
    $t_price_bd += $dtlrow['price_bd'];


    if ($last_wk_desc != $dtlrow['wk_desc']) {
        if ($i >= 1) {

            $tbl .='<tr>';
            $tbl .='<td width="30"></td>';
            $tbl .='<td></td>';
            $tbl .='<td ></td>';
            $tbl .='<td></td>';
            $tbl .='<td ></td>';
            $tbl .='<td colspan="2" align="right"><b>TOTAL ' . $last_wk_code . ' : '.$last_wk_desc.' :</b></td>';
            $tbl .='<td align="right" style="border-top:1px solid #000;">' . number_format($price_bd) . '</td>';
            $tbl .='</tr>';

            $j = 0;
            $price_bd = 0;
            $no = 1;
        }

        $tbl.= '<tr><td colspan="8" align="left"><b style="font-size:1.1em;">' . $dtlrow['wk_code'] . ' : ' . $dtlrow['wk_desc'] . '</b></td></tr>';
        $last_wk_desc = $dtlrow['wk_desc'];
        $last_wk_code = $dtlrow['wk_code'];
    }

    $price_bd += $dtlrow['price_bd'];

    $wo_date = '';
    if ($dtlrow['wo_date'] != '0000-00-00') {
        $wo_date = date_create($dtlrow['wo_date']);
        $wo_date = date_format($wo_date, "d/m/Y");
    }

    $tbl .='<tr>';
    $tbl .='<td align="left" width="30">' . $no++ . '.</td>';
    $tbl .='<td align="left">' . $dtlrow['wk_code'] . '</td>';
    $tbl .='<td align="left">' . $dtlrow['wk_desc'] . '</td>';
    $tbl .='<td align="left">' . $wo_date . '</td>';
    $tbl .='<td align="left">' . $dtlrow['wo_no'] . '</td>';
    $tbl .='<td align="left">' . $dtlrow['so_no'] . '</td>';
    $tbl .='<td align="left">' . $dtlrow['chassis'] . '</td>';
    $tbl .='<td align="right" >' . number_format($dtlrow['price_bd']) . '</td>';
    $tbl .='</tr>';

    $i++;
    $j++;
    unset($dtlrow);
}

if ($i >= 1) {
    $tbl .='<tr>';
    $tbl .='<td width="30"></td>';
    $tbl .='<td></td>';
    $tbl .='<td ></td>';
    $tbl .='<td></td>';
    $tbl .='<td ></td>';
    $tbl .='<td colspan="2" align="right"><b>TOTAL ' . $last_wk_code . ' : '.$last_wk_desc.' :</b></td>';
    $tbl .='<td align="right" style="border-top:1px solid #000;">' . number_format($price_bd) . '</td>';
    $tbl .='</tr>';

    $j = 0;
    $price_bd = 0;
}


$tbl .='<tr><td colspan="8"><br /></td></tr>';
$tbl .= '<tfoot>';
$tbl .='<tr>';
$tbl .='<td width="30"></td>';
$tbl .='<td></td>';
$tbl .='<td ></td>';
$tbl .='<td></td>';
$tbl .='<td ></td>';
$tbl .='<td ></td>';
$tbl .='<td class="border-foot" style="border-left:2px solid black;border-bottom:2px solid black;border-top:2px solid black;" ><b>GRAND TOTAL</b></td>';
$tbl .='<td class="border-foot"  style="border-right:2px solid black;border-bottom:2px solid black;border-top:2px solid black;" align="right">' . number_format($t_price_bd) . '</td>';
$tbl .='</tr>';
$tbl .='</tfoot>';
$tbl .= '</table>';
