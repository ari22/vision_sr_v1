<?php
$tbl .= '
<div id="cntr1" align="center">
<table width="80%">
<tr><td valign="top" align="center"><b style="font-size:1.5em;">'.$comp_name.'</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.5em;">'.$rptTitle.'</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.1em;">By Work Code</b></td></tr>
<tr><td valign="top" align="center"><b>DATE : '.dateView($date1).' UP TO '.dateView($date2).'</b></td></tr>
</table>
';


$tbl .= '
<table width="80%"  >
<tr>
<td></td>
<td valign="top" align="right"><b>Printed On: </b>' . date('d/m/Y') . '</td>
</tr>
</table>';

$tbl .= '<table width="80%">';
$tbl .= '<thead style="border:2px solid black !important;">
            <tr>
                <th valign="top" width="30" align="left"><b>No.</b></th>
                <th valign="top" align="left"><b>Work Code</b></th>
                <th valign="top" align="left"><b>Work Name</b></th>
                <th valign="top" align="left"><b>Invoice Date</b></th>
                <th valign="top" align="left"><b>Invoice No.</b></th>
                <th valign="top" align="left"><b>SPK No.</b></th>
                <th valign="top" align="left"><b>Chassis</b></th>
                <th valign="top" align="right"><b>Netto Price</b></th>
            </tr>
        </thead>';


$tbl .= '<tr><td valign="top" colspan="9"></td></tr>';

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
            $tbl .='<td valign="top" width="30"></td>';
            $tbl .='<td></td>';
            $tbl .='<td></td>';
            $tbl .='<td></td>';
            $tbl .='<td></td>';
            $tbl .='<td valign="top" colspan="2" align="right"><b>TOTAL ' . $last_wk_code . ' : '.$last_wk_desc.' :</b></td>';
            $tbl .='<td valign="top" align="right" style="border-top:1px solid #000;">' . number_format($price_bd) . '</td>';
            $tbl .='</tr>';

            $j = 0;
            $price_bd = 0;
            $no = 1;
        }

        $tbl.= '<tr><td valign="top" colspan="8" align="left"><b style="font-size:1.1em;">' . $dtlrow['wk_code'] . ' : ' . $dtlrow['wk_desc'] . '</b></td></tr>';
        $last_wk_desc = $dtlrow['wk_desc'];
        $last_wk_code = $dtlrow['wk_code'];
    }

    $price_bd += $dtlrow['price_bd'];

    $pur_date = '';
    if ($dtlrow['pur_date'] != '0000-00-00') {
        $pur_date = date_create($dtlrow['pur_date']);
        $pur_date = date_format($pur_date, "d/m/Y");
    }


    $tbl .='<tr>';
    $tbl .='<td valign="top" width="30" align="left">' . $no++ . '.</td>';
    $tbl .='<td valign="top" align="left">' . $dtlrow['wk_code'] . '</td>';
    $tbl .='<td valign="top" align="left">' . $dtlrow['wk_desc'] . '</td>';
    $tbl .='<td valign="top" align="left">' . $pur_date . '</td>';
    $tbl .='<td valign="top" align="left">' . $dtlrow['pur_inv_no'] . '</td>';
    $tbl .='<td valign="top" align="left">' . $dtlrow['so_no'] . '</td>';
    $tbl .='<td valign="top" align="left">' . $dtlrow['chassis'] . '</td>';
    $tbl .='<td valign="top" align="right" >' . number_format($dtlrow['price_bd']) . '</td>';
    $tbl .='</tr>';

    $i++;
    $j++;
    unset($dtlrow);
}

if ($i >= 1) {
    $tbl .='<tr>';
    $tbl .='<td valign="top" width="30"></td>';
    $tbl .='<td></td>';
    $tbl .='<td></td>';
    $tbl .='<td></td>';
    $tbl .='<td></td>';
    $tbl .='<td valign="top" colspan="2" align="right"><b>TOTAL ' . $last_wk_code . ' : '.$last_wk_desc.' :</b></td>';
    $tbl .='<td valign="top" align="right" style="border-top:1px solid #000;">' . number_format($price_bd) . '</td>';
    $tbl .='</tr>';

    $j = 0;
    $price_bd = 0;
}

$tbl .='<tr><td valign="top" colspan="9"><br /></td></tr>';
$tbl .='<tfoot>';
$tbl .='<tr>';
$tbl .='<td valign="top" width="30"></td>';
$tbl .='<td></td>';
$tbl .='<td></td>';
$tbl .='<td></td>';
$tbl .='<td></td>';
$tbl .='<td></td>';
$tbl .='<td class="border-foot" valign="top" style="border-left:2px solid black;border-top:2px solid black;border-bottom:2px solid black;" align="right"><b>GRAND TOTAL:</b></td>';
$tbl .='<td class="border-foot" valign="top" style="border-right:2px solid black;border-top:2px solid black;border-bottom:2px solid black;" align="right">' . number_format($t_price_bd) . '</td>';
$tbl .='</tr>';
$tbl .='</tfoot>';
$tbl .= '</table>';
