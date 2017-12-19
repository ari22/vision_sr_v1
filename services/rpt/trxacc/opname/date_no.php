<?php
//========CHANGE LOG=============
//ganti semua <td jadi <td valign="top"
$tbl .= '
<div id="cntr1" align="center">
<table width="80%">
<tr><td valign="top" align="center"><b style="font-size:1.5em;">' . $comp_name . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.5em;">' . $rptTitle . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.1em;">By Invoice Date By Invoice No.</b></td></tr>
<tr><td valign="top" align="center"><b>DATE : ' . dateView($date1) . ' UP TO ' . dateView($date2) . '</b></td></tr>
</table>
';

$tbl .= '
<table width="80%"  >
<tr>
<td valign="top"></td>
<td valign="top" align="right"><b>Printed On: </b>' . date('d/m/Y') . '</td>
</tr>
</table>';

$tbl .= '
        <table width="80%">
        <thead style="border:2px solid black !important;">
            <tr>
                <td valign="top" width="100" align="left"><b>Invoice Date</b></td>
                <td valign="top" width="150" align="left"><b>Invoice No.</b></td>
                <td valign="top" width="100" align="right"><b>Item</b></td>
                <td valign="top" width="100" align="right"><b>Total<br />Qty</b></td>
                <td valign="top" width="100" align="right"><b>Total<br />Price</b></td>
                <td valign="top" width="200"  align="left"><b>Note</b></td>
            </tr>
        </thead>';
$tbl .= '<tr><td valign="top"></td></tr>';

$i = 0;
$j = 0;

$no = 1;

$item = 0;
$qty = 0;
$price = 0;

$titem = 0;
$tqty = 0;
$tprice = 0;

$last_wrhs_code = '';

while ($dtlrow = mysql_fetch_array($dtl)) {
    $titem += $dtlrow['tot_item'];
    $tqty += $dtlrow['tot_qty'];
    $tprice += $dtlrow['tot_price'];

    if ($last_wrhs_code != $dtlrow['wrhs_code']) {
        if ($i >= 1) {
            $tbl .='<tr>';
            $tbl .='<td valign="top" width="100"></td>';
            $tbl .='<td valign="top" width="150" align="right"><b>TOTAL ' . $last_wrhs_code . ' :</b></td>';
            $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($item) . '</td>';
            $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($qty) . '</td>';
            $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($price) . '</td>';
            $tbl .='<td valign="top" width="200" align="center"></td>';
            $tbl .='</tr>';


            $j = 0;
            $item = 0;
            $qty = 0;
        }

        $tbl.= '<tr><td valign="top" colspan="6" align="left"><b style="font-size:1.1em;">WAREHOUSE : ' . $dtlrow['wrhs_code'] . '</b></td></tr>';
        $last_wrhs_code = $dtlrow['wrhs_code'];
    }

    $item += $dtlrow['tot_item'];
    $qty += $dtlrow['tot_qty'];
    $price += $dtlrow['tot_price'];

    $opn_date = '';
    if ($dtlrow['opn_date'] != '0000-00-00') {
        $opn_date = date_create($dtlrow['opn_date']);
        $opn_date = date_format($opn_date, "d/m/Y");
    }

    $tbl .='<tr>';
    $tbl .='<td valign="top" width="100" align="left">' . $opn_date . '</td>';
    $tbl .='<td valign="top" width="150" align="left">' . $dtlrow['opn_inv_no'] . '</td>';
    $tbl .='<td valign="top" width="100" align="right">' . number_format($dtlrow['tot_item']) . '</td>';
    $tbl .='<td valign="top" width="100" align="right">' . number_format($dtlrow['tot_qty']) . '</td>';
    $tbl .='<td valign="top" width="100" align="right">' . number_format($dtlrow['tot_price']) . '</td>';
    $tbl .='<td valign="top" width="200"  align="left">' . $dtlrow['note'] . '</td>';
    $tbl .='</tr>';

    $i++;
    $j++;

    unset($dtlrow);
}

if ($i >= 1) {
    $tbl .='<tr>';
    $tbl .='<td valign="top" width="100"></td>';
    $tbl .='<td valign="top" width="150" align="right"><b>TOTAL ' . $last_wrhs_code . ' :</b></td>';
    $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($item) . '</td>';
    $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($qty) . '</td>';
    $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($price) . '</td>';
    $tbl .='<td valign="top" width="200" align="center"></td>';
    $tbl .='</tr>';


    $j = 0;
    $item = 0;
    $qty = 0;
}

$tbl .='<tr><td valign="top"><br /></td></tr>';
$tbl .='<tfoot>';
$tbl .='<tr>';
$tbl .='<td valign="top" width="150"></td>';
$tbl .='<td class="border-foot" style="border-left:2px solid black;border-bottom:2px solid black;border-top:2px solid black;" valign="top" width="100" align="right"><b>GRAND TOTAL :</b></td>';
$tbl .='<td class="border-foot" style="border-bottom:2px solid black;border-top:2px solid black;" valign="top" width="100" align="right"><b>' . number_format($titem) . '</b></td>';
$tbl .='<td class="border-foot" style="border-bottom:2px solid black;border-top:2px solid black;" valign="top" width="100" align="right"><b>' . number_format($tqty) . '</b></td>';
$tbl .='<td class="border-foot" style="border-right:2px solid black;border-bottom:2px solid black;border-top:2px solid black;" valign="top" width="100" align="right"><b>' . number_format($tprice) . '</b></td>';
$tbl .='<td valign="top" width="200" align="center"></td>';
$tbl .='</tr>';
$tbl .= '</tfoot>';

$tbl .='</table>';
