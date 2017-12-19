<?php

$tbl .= '
<div id="cntr1" align="center">
<table width="80%">
<tr><td align="center"><b style="font-size:1.5em;">' . $comp_name . '</b></td></tr>
<tr><td align="center"><b style="font-size:1.5em;">' . $rptTitle . '</b></td></tr>
<tr><td align="center"><b style="font-size:1.1em;">By Part Code</b></td></tr>
<tr><td align="center"><b>DATE : ' . dateView($date1) . ' UP TO ' . dateView($date2) . '</b></td></tr>
</table>
';

$tbl .= '
<table width="80%"  >
<tr>
<td></td>
<td align="right"><b>Printed On: </b>' . date('d/m/Y') . '</td>
</tr>
</table>';

$tbl .= '
        <table width="80%">
        <thead style="border:2px solid black !important;">        
               <tr>
                    <td width="30" align="left"><b>No.</b></td>
                    <td width="100" align="left"><b>Part<br />Code</b></td>
                    <td width="150" align="left"><b>Part<br />Name</b></td>
                    <td width="100" align="left"><b>Warehouse</b></td>
                    <td width="100" align="left"><b>Location</b></td>
                    <td width="100" align="left"><b>PO Date</b></td>
                    <td width="150" align="left"><b>PO No.</b></td>
                    <td width="100" align="right"><b>Order<br />Qty</b></td>
                    <td width="100" align="right"><b>Rcv<br />Qty</b></td>
                    <td width="100" align="right"><b>BO<br />Qty</b></td>
                    <td width="100" align="right"><b>Total<br />Price</b></td>
                </tr>          
        </thead>';

$tbl .= '<tr><td></td></tr>';

$i = 0;
$j = 0;
$no = 1;

$qty = 0;
$rcv = 0;
$beg = 0;
$price = 0;

$qty2 = 0;
$rcv2 = 0;
$beg2 = 0;
$price2 = 0;

$tqty = 0;
$trcv = 0;
$tbeg = 0;
$tprice = 0;

$last_curr_code = '';
$last_part_code = '';

while ($dtlrow = mysql_fetch_array($dtl)) {
    $tqty += $dtlrow['qty'];
    $trcv += $dtlrow['rcv_qty'];
    $tbeg += $dtlrow['beg_qty'];
    $tprice += $dtlrow['price_ad'];

    if ($last_part_code != $dtlrow['part_code']) {
        if ($i >= 1) {

            $tbl .='<tr>';
            $tbl .='<td width="30"></td>';
            $tbl .='<td width="100"></td>';
            $tbl .='<td width="150"></td>';
            $tbl .='<td width="100"></td>';
            $tbl .='<td width="100"></td>';
            $tbl .='<td width="100"></td>';
            $tbl .='<td width="150"><b>Total ' . $last_part_code . ' :</b></td>';
            $tbl .='<td width="100" align="right" style="border-top:1px solid #000;"><b>' . number_format($qty2) . '</b></td>';
            $tbl .='<td width="100" align="right" style="border-top:1px solid #000;"><b>' . number_format($rcv2) . '</b></td>';
            $tbl .='<td width="100" align="right" style="border-top:1px solid #000;"><b>' . number_format($beg2) . '</b></td>';
            $tbl .='<td width="100" align="right" style="border-top:1px solid #000;"><b>' . number_format($price2) . '</b></td>';
            $tbl .='</tr>';

            $i = 0;
            $qty2 = 0;
            $rcv2 = 0;
            $beg2 = 0;
            $price2 = 0;
        }

        $last_part_code = $dtlrow['part_code'];
    }

    if ($last_curr_code != $dtlrow['curr_code']) {
        if ($j >= 1) {

            $tbl .='<tr>';
            $tbl .='<td width="30"></td>';
            $tbl .='<td width="100"></td>';
            $tbl .='<td width="150"></td>';
            $tbl .='<td width="100"></td>';
            $tbl .='<td width="100"></td>';
            $tbl .='<td width="100"></td>';
            $tbl .='<td width="150"><b>Total Currency ' . $last_curr_code . ' :</b></td>';
            $tbl .='<td width="100" align="right" style="border-top:1px solid #000;"><b>' . number_format($qty) . '</b></td>';
            $tbl .='<td width="100" align="right" style="border-top:1px solid #000;"><b>' . number_format($rcv) . '</b></td>';
            $tbl .='<td width="100" align="right" style="border-top:1px solid #000;"><b>' . number_format($beg) . '</b></td>';
            $tbl .='<td width="100" align="right" style="border-top:1px solid #000;"><b>' . number_format($price) . '</b></td>';
            $tbl .='</tr>';

            $j = 0;
            $qty = 0;
            $price = 0;
            $no = 1;
        }



        $tbl.= '<tr><td colspan="11" align="left"><b style="font-size:1.1em;">CURRENCY : ' . $dtlrow['curr_code'] . '</b></td></tr>';
        $last_curr_code = $dtlrow['curr_code'];
    }



    $qty += $dtlrow['qty'];
    $rcv += $dtlrow['rcv_qty'];
    $beg += $dtlrow['beg_qty'];
    $price += $dtlrow['price_ad'];

    $qty2 += $dtlrow['qty'];
    $rcv2 += $dtlrow['rcv_qty'];
    $beg2 += $dtlrow['beg_qty'];
    $price2 += $dtlrow['price_ad'];

    $po_date = '';
    if ($dtlrow['po_date'] != '0000-00-00') {
        $po_date = date_create($dtlrow['po_date']);
        $po_date = date_format($po_date, "d/m/Y");
    }

    $tbl .='<tr>';
    $tbl .='<td width="30" align="left">' . $no++ . '.</td>';
    $tbl .='<td width="100" align="left">' . $dtlrow['part_code'] . '</td>';
    $tbl .='<td width="150" align="left">' . $dtlrow['part_name'] . '</td>';
    $tbl .='<td width="100" align="left">' . $dtlrow['wrhs_code'] . '</td>';
    $tbl .='<td width="100" align="left">' . $dtlrow['location'] . '</td>';
    $tbl .='<td width="100" align="left">' . $po_date . '</td>';
    $tbl .='<td width="150" align="left">' . $dtlrow['po_no'] . '</td>';
    $tbl .='<td width="100" align="right">' . number_format($dtlrow['qty']) . '</td>';
    $tbl .='<td width="100" align="right">' . number_format($dtlrow['rcv_qty']) . '</td>';
    $tbl .='<td width="100" align="right">' . number_format($dtlrow['beg_qty']) . '</td>';
    $tbl .='<td width="100" align="right">' . number_format($dtlrow['price_ad']) . '</td>';
    $tbl .='</tr>';

    $i++;
    $j++;

    unset($dtlrow);
}




if ($i >= 1) {

    $tbl .='<tr>';
    $tbl .='<td width="30"></td>';
    $tbl .='<td width="100"></td>';
    $tbl .='<td width="150"></td>';
    $tbl .='<td width="100"></td>';
    $tbl .='<td width="100"></td>';
    $tbl .='<td width="100"></td>';
    $tbl .='<td width="150"><b>Total ' . $last_part_code . ' :</b></td>';
    $tbl .='<td width="100" align="right" style="border-top:1px solid #000;"><b>' . number_format($qty2) . '</b></td>';
    $tbl .='<td width="100" align="right" style="border-top:1px solid #000;"><b>' . number_format($rcv2) . '</b></td>';
    $tbl .='<td width="100" align="right" style="border-top:1px solid #000;"><b>' . number_format($beg2) . '</b></td>';
    $tbl .='<td width="100" align="right" style="border-top:1px solid #000;"><b>' . number_format($price2) . '</b></td>';
    $tbl .='</tr>';

    $i = 0;
    $qty2 = 0;
    $rcv2 = 0;
    $beg2 = 0;
    $price2 = 0;
}

if ($j >= 1) {

    $tbl .='<tr>';
    $tbl .='<td width="30"></td>';
    $tbl .='<td width="100"></td>';
    $tbl .='<td width="150"></td>';
    $tbl .='<td width="100"></td>';
    $tbl .='<td width="100"></td>';
    $tbl .='<td width="100"></td>';
    $tbl .='<td width="150"><b>Total Currency ' . $last_curr_code . ' :</b></td>';
    $tbl .='<td width="100" align="right" style="border-top:1px solid #000;"><b>' . number_format($qty) . '</b></td>';
    $tbl .='<td width="100" align="right" style="border-top:1px solid #000;"><b>' . number_format($rcv) . '</b></td>';
    $tbl .='<td width="100" align="right" style="border-top:1px solid #000;"><b>' . number_format($beg) . '</b></td>';
    $tbl .='<td width="100" align="right" style="border-top:1px solid #000;"><b>' . number_format($price) . '</b></td>';
    $tbl .='</tr>';

    $j = 0;
    $qty = 0;
    $price = 0;
    $no = 1;
}

$tbl .='<tr><td><br /></td></tr>';

$tbl .='<tr>';
$tbl .='<td colspan="6" width="100"></td>';
$tbl .='<td class="border-foot" style="border-left:2px solid black;border-bottom:2px solid black;border-top:2px solid black;" width="150"><b>Grand Total :</b></td>';
$tbl .='<td class="border-foot" style="border-bottom:2px solid black;border-top:2px solid black;" width="100" align="right"><b>' . number_format($tqty) . '</b></td>';
$tbl .='<td class="border-foot" style="border-bottom:2px solid black;border-top:2px solid black;" width="100" align="right"><b>' . number_format($trcv) . '</b></td>';
$tbl .='<td class="border-foot" style="border-bottom:2px solid black;border-top:2px solid black;" width="100" align="right"><b>' . number_format($tbeg) . '</b></td>';
$tbl .='<td class="border-foot" style="border-right:2px solid black;border-bottom:2px solid black;border-top:2px solid black;" width="100" align="right"><b>' . number_format($tprice) . '</b></td>';
$tbl .='</tr>';

$tbl .='</table>';

