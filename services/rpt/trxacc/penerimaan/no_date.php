<?php

$tbl .= '
<div id="cntr1" align="center">
<table width="70%">
<tr><td valign="top" align="center"><b style="font-size:1.5em;">' . $comp_name . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.5em;">' . $rptTitle . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.1em;">By Invoice No. By Invoice Date</b></td></tr>
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
                <td valign="top" width="120" align="left"><b>Invoice No.</b></td>
                <td valign="top" width="100" align="left"><b>Invoice Date</b></td>
                <td valign="top" width="120" align="left"><b>Supplier Code</b></td>
                <td valign="top" width="120" align="left"><b>Supplier<br />Invoice No.</b></td>
                <td valign="top" width="100" align="left"><b>Supplier<br />Invoice Date</b></td>
                <td valign="top" width="50" align="right"><b>Item</b></td>
                <td valign="top"  width="50" align="right"><b>Qty</b></td>
            </tr>
        </thead>';

$tbl .= '<tr><td valign="top" colspan="9"></td></tr>';

$i = 0;
$j = 0;

$no = 1;

$item = 0;
$qty = 0;
$titem = 0;
$tqty = 0;

$last_wrhs_code = '';

while ($dtlrow = mysql_fetch_array($dtl)) {
    $titem += $dtlrow['tot_item'];
    $tqty += $dtlrow['tot_qty'];

    if ($last_wrhs_code != $dtlrow['wrhs_code']) {
        if ($i >= 1) {
            $tbl .='<tr>';
            $tbl .= '<td valign="top"></td>';
            $tbl .='<td valign="top" width="120"></td>';
            $tbl .='<td valign="top" width="100"></td>';
            $tbl .='<td valign="top" width="120"></td>';
            $tbl .='<td valign="top" width="120"align="right"></td>';
            $tbl .='<td valign="top" width="100" align="right"><b>TOTAL ' . $last_wrhs_code . ' :</b></td>';
            $tbl .='<td valign="top" width="50" align="right" style="border-top:1px solid #000;">' . number_format($item) . '</td>';
            $tbl .='<td valign="top" width="50" align="right" style="border-top:1px solid #000;">' . number_format($qty) . '</td>';
            $tbl .='</tr>';

            $j = 0;
            $item = 0;
            $qty = 0;
            $no = 1;
        }

        $tbl.= '<tr><td valign="top" colspan="8" align="left"><b style="font-size:1.1em;">WAREHOUSE : ' . $dtlrow['wrhs_code'] . '</b></td></tr>';
        $last_wrhs_code = $dtlrow['wrhs_code'];
    }

    $item += $dtlrow['tot_item'];
    $qty += $dtlrow['tot_qty'];



    $pur_date = '';
    if ($dtlrow['pur_date'] != '0000-00-00') {
        $pur_date = date_create($dtlrow['pur_date']);
        $pur_date = date_format($pur_date, "d/m/Y");
    }

    $supp_invdt = '';
    if ($dtlrow['supp_invdt'] != '0000-00-00') {
        $supp_invdt = date_create($dtlrow['supp_invdt']);
        $supp_invdt = date_format($supp_invdt, "d/m/Y");
    }


    $tbl .='<tr>';
    $tbl .= '<td valign="top" align="left" width="30">' . $no++ . '.</td>';
    $tbl .='<td valign="top" width="120" align="left">' . $dtlrow['pur_inv_no'] . '</td>';
    $tbl .='<td valign="top" width="100" align="left">' . $pur_date . '</td>';
    $tbl .='<td valign="top" width="120" align="left">' . $dtlrow['supp_code'] . '</td>';
    $tbl .='<td valign="top" width="120" align="left">' . $dtlrow['supp_invno'] . '</td>';
    $tbl .='<td valign="top" width="100" align="left">' . $supp_invdt . '</td>';
    $tbl .='<td valign="top" width="50" align="right">' . number_format($dtlrow['tot_item']) . '</td>';
    $tbl .='<td valign="top" width="50" align="right">' . number_format($dtlrow['tot_qty']) . '</td>';
    $tbl .='</tr>';


    $i++;
    $j++;

    unset($dtlrow);
}

if ($i >= 1) {
    $tbl .='<tr>';
    $tbl .= '<td valign="top"></td>';
    $tbl .='<td valign="top" width="120"></td>';
    $tbl .='<td valign="top" width="100"></td>';
    $tbl .='<td valign="top" width="120"></td>';
    $tbl .='<td valign="top" width="120"align="right"></td>';
    $tbl .='<td valign="top" width="100" align="right"><b>TOTAL ' . $last_wrhs_code . ' :</b></td>';
    $tbl .='<td valign="top" width="50" align="right" style="border-top:1px solid #000;">' . number_format($item) . '</td>';
    $tbl .='<td valign="top" width="50" align="right" style="border-top:1px solid #000;">' . number_format($qty) . '</td>';
    $tbl .='</tr>';

    $j = 0;
    $item = 0;
    $qty = 0;
    $no = 1;
}

$tbl .='<tr><td valign="top"><br /></td></tr>';
$tbl .='<tr>';
$tbl .='<td valign="top" colspan="5"></td>';
$tbl .='<td class="border-foot" valign="top" style="border-left:2px solid black;border-bottom:2px solid black;border-top:2px solid black;" align="right"><b>GRAND TOTAL :</b></td>';
$tbl .='<td class="border-foot" valign="top" style="border-bottom:2px solid black;border-top:2px solid black;" align="right"><b>' . number_format($titem) . '</b></td>';
$tbl .='<td class="border-foot" valign="top" style="border-right:2px solid black;border-bottom:2px solid black;border-top:2px solid black;" align="right"><b>' . number_format($tqty) . '</b></td>';
$tbl .='</tr>';

$tbl .= '</table>';
