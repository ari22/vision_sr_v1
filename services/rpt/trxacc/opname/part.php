<?php
//========CHANGE LOG=============
//ganti semua <td jadi <td valign="top"
//ganti judul
$tbl .= '
<div id="cntr1" align="center">
<table width="80%">
<tr><td valign="top" align="center"><b style="font-size:1.5em;">' . $comp_name . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.5em;">' . $rptTitle . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.1em;">By Part Code</b></td></tr>
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
            <td valign="top" width="30" align="left"><b>No.</b></td>
            <td valign="top" width="100" align="left"><b>Part Code</b></td>
            <td valign="top" width="150" align="left"><b>Part Name</b></td>
            <td valign="top" width="100" align="left"><b>Location</b></td>
            <td valign="top" width="100" align="right"><b>Qty</b></td>
            <td valign="top" width="100" align="right"><b>Sum</b></td>
            <td valign="top" width="30"></td>
            <td valign="top" width="100" align="left"><b>Invoice Date</b></td>
            <td valign="top" width="150" align="left"><b>Invoice No.</b></td>
            </tr>
        </thead>';
$tbl .= '<tr><td valign="top"></td></tr>';

$i = 0;
$j = 0;

$no = 1;

$qty = 0;
$price = 0;

$tqty = 0;
$tprice = 0;

$last_wrhs_code = '';

while ($dtlrow = mysql_fetch_array($dtl)) {

    $tqty += $dtlrow['qty'];
    $tprice += $dtlrow['price_bd'];

    if ($last_wrhs_code != $dtlrow['wrhs_code']) {

        if ($i >= 1) {
            $tbl .= '<tr>';
            $tbl .= '<td valign="top" width="30"></td>';
            $tbl .= '<td valign="top" width="100"></td>';
            $tbl .= '<td valign="top" width="150"></td>';
            $tbl .= '<td valign="top" width="100"><b>TOTAL ' . $last_wrhs_code . ' :</b></td>';
            $tbl .= '<td valign="top" width="100" style="border-top:1px solid #000;" align="right">' . number_format($qty) . '</td>';
            $tbl .= '<td valign="top" width="100" style="border-top:1px solid #000;" align="right">' . number_format($price) . '</td>';
            $tbl .= '<td valign="top" width="30"></td>';
            $tbl .= '<td valign="top" width="100"></td>';
            $tbl .= '<td valign="top" width="150"></td>';
            $tbl .= '</tr>';

            $i = 0;
            $qty = 0;
            $price = 0;
        }

        $tbl.= '<tr><td valign="top" colspan="9" align="left"><b style="font-size:1.1em;">WAREHOUSE : ' . $dtlrow['wrhs_code'] . '</b></td></tr>';
        $last_wrhs_code = $dtlrow['wrhs_code'];
    }

    $qty += $dtlrow['qty'];
    $price += $dtlrow['price_bd'];

    $opn_date = '';
    if ($dtlrow['opn_date'] != '0000-00-00') {
        $opn_date = date_create($dtlrow['opn_date']);
        $opn_date = date_format($opn_date, "d/m/Y");
    }

    $tbl .= '<tr>';
    $tbl .= '<td valign="top" width="30" align="left">' . $no++ . '</td>';
    $tbl .= '<td valign="top" width="100" align="left">' . $dtlrow['part_code'] . '</td>';
    $tbl .= '<td valign="top" width="150" align="left">' . $dtlrow['part_name'] . '</td>';
    $tbl .= '<td valign="top" width="100" align="left">' . $dtlrow['location'] . '</td>';
    $tbl .= '<td valign="top" width="100" align="right">' . number_format($dtlrow['qty']) . '</td>';
    $tbl .= '<td valign="top" width="100" align="right">' . number_format($dtlrow['price_bd']) . '</td>';
    $tbl .= '<td valign="top" width="30"></td>';
    $tbl .= '<td valign="top" width="100" align="left">' . $opn_date . '</td>';
    $tbl .= '<td valign="top" width="150" align="left">' . $dtlrow['opn_inv_no'] . '</td>';
    $tbl .= '</tr>';

    $i++;
    $j++;

    unset($dtlrow);
}

if ($i >= 1) {
    $tbl .= '<tr>';
    $tbl .= '<td valign="top" width="30"></td>';
    $tbl .= '<td valign="top" width="100"></td>';
    $tbl .= '<td valign="top" width="150"></td>';
    $tbl .= '<td valign="top" width="100"><b>TOTAL ' . $last_wrhs_code . ' :</b></td>';
    $tbl .= '<td valign="top" width="100" style="border-top:1px solid #000;" align="right">' . number_format($qty) . '</td>';
    $tbl .= '<td valign="top" width="100" style="border-top:1px solid #000;" align="right">' . number_format($price) . '</td>';
    $tbl .= '<td valign="top" width="30"></td>';
    $tbl .= '<td valign="top" width="100"></td>';
    $tbl .= '<td valign="top" width="150"></td>';
    $tbl .= '</tr>';

    $i = 0;
    $qty = 0;
    $price = 0;
}

$tbl .='<tr><td valign="top"><br /></td></tr>';
$tbl .='<tfoot>';
$tbl .= '<tr>';
$tbl .= '<td valign="top" width="30"></td>';
$tbl .= '<td valign="top" width="100"></td>';
$tbl .= '<td valign="top" width="150"></td>';
$tbl .= '<td class="border-foot" style="border-left:2px solid black;border-bottom:2px solid black;border-top:2px solid black;" valign="top" width="100"><b>GRAND TOTAL :</b></td>';
$tbl .= '<td class="border-foot" style="border-bottom:2px solid black;border-top:2px solid black;" valign="top" width="100" style="border-top:1px solid #000;" align="right"><b>' . number_format($tqty) . '</b></td>';
$tbl .= '<td class="border-foot" style="border-right:2px solid black;border-bottom:2px solid black;border-top:2px solid black;" valign="top" width="100" style="border-top:1px solid #000;" align="right"><b>' . number_format($tprice) . '</b></td>';
$tbl .= '<td valign="top" width="30"></td>';
$tbl .= '<td valign="top" width="100"></td>';
$tbl .= '<td valign="top" width="150"></td>';
$tbl .= '</tr>';
$tbl .= '</tfoot>';
$tbl .= '</table>';
