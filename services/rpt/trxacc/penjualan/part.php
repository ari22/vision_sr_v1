<?php

//========CHANGE LOG=============
//ganti semua <td jadi <td valign="top"
//inv_disc tadiny diisi inv_bt
//tambah total utk tiap part
//tabel dibetulin

$tbl .= '
<div id="cntr1" align="center">
<table width="70%">
<tr><td valign="top" align="center"><b style="font-size:1.5em;">' . $comp_name . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.5em;">' . $rptTitle . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.1em;">By Part Code</b></td></tr>
<tr><td valign="top" align="center"><b>DATE : ' . dateView($date1) . ' UP TO ' . dateView($date2) . '</b></td></tr>
</table>
';

$tbl .= '
<table width="70%"  >
<tr>
<td valign="top"></td>
<td valign="top" align="right"><b>Printed On: </b>' . date('d/m/Y') . '</td>
</tr>
</table>';


$tbl .= '
        <table width="70%">
        <thead style="border:2px solid black !important;">
            <tr>
            <td valign="top" width="30" align="left"><b>No.</b></td>
            <td valign="top" width="70" align="left"><b>Part Code</b></td>
            <td valign="top" align="left"><b>Part Name</b></td>
            <td valign="top" align="left"><b>Invoice Date</b></td>
            <td valign="top" align="left"><b>Invoice No.</b></td>
            <td valign="top" width="30" align="right"><b>Qty</b></td>
            </tr>
        </thead>';


$tbl .= '<tr><td valign="top" colspan="6"></td></tr>';

$i = 0;
$j = 0;

$no = 1;

$qty = 0;
$tqty = 0;
$tqty2 = 0;

$last_wrhs_code = '';
$last_part_code = '';

while ($dtlrow = mysql_fetch_array($dtl)) {
    if ($last_part_code != $dtlrow['part_code']) {
        if ($j >= 1) {


            $tbl .= '<tr>';
            $tbl .= '<td valign="top" width="30"></td>';
            $tbl .= '<td valign="top"></td>';
            $tbl .= '<td valign="top"></td>';
            $tbl .= '<td valign="top"></td>';
            $tbl .= '<td valign="top" align="right"><b>TOTAL ' . $last_part_code . ' :</b></td>';
            $tbl .= '<td valign="top" style="border-top:1px solid #000;" align="right">' . number_format($tqty) . '</td>';
            $tbl .= '</tr>';

            $j = 0;
            $tqty = 0;
        }
        $last_part_code = $dtlrow['part_code'];
    }
    if ($last_wrhs_code != $dtlrow['wrhs_code']) {
        if ($i >= 1) {
            $tbl .= '<tr>';
            $tbl .= '<td valign="top" width="30"></td>';
            $tbl .= '<td valign="top"></td>';
            $tbl .= '<td valign="top"></td>';
            $tbl .= '<td valign="top"></td>';
            $tbl .= '<td valign="top" align="right"><b>TOTAL ' . $last_wrhs_code . ' :</b></td>';
            $tbl .= '<td valign="top" style="border-top:1px solid #000;" align="right">' . number_format($qty) . '</td>';
            $tbl .= '</tr>';

            $i = 0;
            $qty = 0;
        }

        $tbl.= '<tr><td valign="top" colspan="9" align="left"><b style="font-size:1.1em;">WAREHOUSE : ' . $dtlrow['wrhs_code'] . '</b></td></tr>';
        $last_wrhs_code = $dtlrow['wrhs_code'];
    }


    $qty += $dtlrow['qty'];
    $tqty += $dtlrow['tot_qty'];
    $tqty2 += $dtlrow['tot_qty'];

    $sal_date = dateView($dtlrow['sal_date']);

    $tbl .= '<tr>';
    $tbl .= '<td valign="top" width="30" align="left">' . $no++ . '</td>';
    $tbl .= '<td valign="top" align="left">' . $dtlrow['part_code'] . '</td>';
    $tbl .= '<td valign="top" align="left">' . $dtlrow['part_name'] . '</td>';
    $tbl .= '<td valign="top" align="left">' . $sal_date . '</td>';
    $tbl .= '<td valign="top" align="left">' . $dtlrow['sal_inv_no'] . '</td>';
    $tbl .= '<td valign="top" align="right">' . number_format($dtlrow['tot_qty']) . '</td>';
    $tbl .= '</tr>';

    $i++;
    $j++;

    unset($dtlrow);
}

if ($j >= 1) {


    $tbl .= '<tr>';
    $tbl .= '<td valign="top" width="30"></td>';
    $tbl .= '<td valign="top"></td>';
    $tbl .= '<td valign="top"></td>';
    $tbl .= '<td valign="top"></td>';
    $tbl .= '<td valign="top" align="right"><b>TOTAL ' . $last_part_code . ' :</b></td>';
    $tbl .= '<td valign="top" style="border-top:1px solid #000;" align="right">' . number_format($tqty) . '</td>';
    $tbl .= '</tr>';

    $j = 0;
    $tqty = 0;
}
if ($i >= 1) {
    $tbl .= '<tr>';
    $tbl .= '<td valign="top" width="30"></td>';
    $tbl .= '<td valign="top"></td>';
    $tbl .= '<td valign="top"></td>';
    $tbl .= '<td valign="top"></td>';
    $tbl .= '<td valign="top" align="right"><b>TOTAL ' . $last_wrhs_code . ' :</b></td>';
    $tbl .= '<td valign="top" style="border-top:1px solid #000;" align="right">' . number_format($qty) . '</td>';
    $tbl .= '</tr>';

    $i = 0;
    $qty = 0;
}

$tbl .='<tr><td valign="top" colspan="16"><br /></td></tr>';
$tbl .='<tfoot>';
$tbl .= '<tr>';
$tbl .= '<td valign="top" width="30"></td>';
$tbl .= '<td valign="top"></td>';
$tbl .= '<td valign="top"></td>';
$tbl .= '<td valign="top"></td>';
$tbl .= '<td class="border-foot" style="border-left:2px solid black;border-bottom:2px solid black;border-top:2px solid black;" valign="top" align="right"><b>GRAND TOTAL :</b></td>';
$tbl .= '<td class="border-foot" style="border-right:2px solid black;border-bottom:2px solid black;border-top:2px solid black;" valign="top" align="right"><b>' . number_format($tqty2) . '</b></td>';
$tbl .= '</tr>';
$tbl .='</tfoot>';
$tbl .= '</table>';
