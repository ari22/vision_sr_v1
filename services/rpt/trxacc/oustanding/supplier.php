<?php
//=======CHANGE LOG=======
//tabel dibetulin
//td valign

$tbl .= '
<div id="cntr1" align="center">
<table width="80%">
<tr><td align="center"><b style="font-size:1.5em;">' . $comp_name . '</b></td></tr>
<tr><td align="center"><b style="font-size:1.5em;">' . $rptTitle . '</b></td></tr>
<tr><td align="center"><b style="font-size:1.1em;">By Supplier</b></td></tr>
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
                <td width="150" align="left"><b>PO No.</b></td>
                <td width="100" align="left"><b>PO Date</b></td>
                <td width="100" align="left"><b>Part Code</b></td>
                <td width="150" align="left"><b>Part Name</b></td>
                <td width="100" align="right"><b>Item</b></td>
                <td width="100" align="right"><b>Total<br />Order Qty</b></td>
                <td width="100" align="right"><b>Total<br />Rcv Qty</b></td>
                <td width="100" align="right"><b>Total<br />BO Qty</b></td>
		<td width="100" align="right"><b>Total<br />BO Price</b></td>
                <td width="30"></td>
	 	<td width="150" align="left"><b>Quotation<br />No.</b></td>
                <td width="100" align="left"><b>Quotation<br />Date</b></td>
            </tr>
         </thead>';

$tbl .= '<tr><td></td></tr>';

$i = 0;
$j = 0;

$item = 0;
$qty = 0;
$rcv = 0;
$beg = 0;
$price = 0;

$item2 = 0;
$qty2 = 0;
$rcv2 = 0;
$beg2 = 0;
$price2 = 0;

$titem = 0;
$tqty = 0;
$trcv = 0;
$tbeg = 0;
$tprice = 0;

$last_curr_code = '';
$last_supp_code = '';
$last_supp_name = '';


while ($dtlrow = mysql_fetch_array($dtl)) {
    $titem += $dtlrow['tot_item'];
    $tqty += $dtlrow['tot_qty'];
    $trcv += $dtlrow['rcv_qty'];
    $tbeg += $dtlrow['beg_qty'];
    $tprice += $dtlrow['price_ad2'];

    if ($last_curr_code != $dtlrow['curr_code']) {
        if ($j >= 1) {

            $tbl .='<tr>';
            $tbl .='<td colspan="4"  align="right"><b>Total Supplier ' . $last_supp_code . ' :</b></td>';
            $tbl .='<td width="100" align="right" style="border-top:1px solid #000;"><b>' . number_format($item2) . '</b></td>';
            $tbl .='<td width="100" align="right" style="border-top:1px solid #000;"><b>' . number_format($qty2) . '</b></td>';
            $tbl .='<td width="100" align="right" style="border-top:1px solid #000;"><b>' . number_format($rcv2) . '</b></td>';
            $tbl .='<td width="100" align="right" style="border-top:1px solid #000;"><b>' . number_format($beg2) . '</b></td>';
            $tbl .='<td width="100" align="right" style="border-top:1px solid #000;"><b>' . number_format($price2) . '</b></td>';
            $tbl .='<td width="30"></td>';
            $tbl .='<td width="150"></td>';
            $tbl .='<td width="100"></td>';

            $tbl .='<tr>';
            $tbl .='<td colspan="4"  align="right"><b>Total Currency ' . $last_curr_code . ' :</b></td>';
            $tbl .='<td width="100" align="right" style="border-top:1px solid #000;"><b>' . number_format($item) . '</b></td>';
            $tbl .='<td width="100" align="right" style="border-top:1px solid #000;"><b>' . number_format($qty) . '</b></td>';
            $tbl .='<td width="100" align="right" style="border-top:1px solid #000;"><b>' . number_format($rcv) . '</b></td>';
            $tbl .='<td width="100" align="right" style="border-top:1px solid #000;"><b>' . number_format($beg) . '</b></td>';
            $tbl .='<td width="100" align="right" style="border-top:1px solid #000;"><b>' . number_format($price) . '</b></td>';
            $tbl .='<td width="30"></td>';
            $tbl .='<td width="150"></td>';
            $tbl .='<td width="100"></td>';

            $j = 0;
            $item = 0;
            $qty = 0;
            $rcv = 0;
            $beg = 0;
            $price = 0;

            $i = 0;
            $item2 = 0;
            $qty2 = 0;
            $rcv2 = 0;
            $beg2 = 0;
            $price2 = 0;
        }
        $tbl.= '<tr><td colspan="11" align="left"><b style="font-size:1.1em;">CURRENCY : ' . $dtlrow['curr_code'] . '</b></td></tr>';
        $last_curr_code = $dtlrow['curr_code'];
        $tbl.= '<tr><td colspan="11" align="left"><b style="font-size:1.1em;">SUPPLIER : ' . $dtlrow['supp_code'] . ' : ' . $dtlrow['supp_name'] . '</b></td></tr>';
        $last_supp_code = $dtlrow['supp_code'];
        $last_supp_name = $dtlrow['supp_name'];
    }elseif ($last_supp_code != $dtlrow['supp_code']) {
        if ($i >= 1) {
            $tbl .='<tr>';
            $tbl .='<td colspan="4"  align="right"><b>Total Supplier ' . $last_supp_code . ' :</b></td>';
            $tbl .='<td width="100" align="right" style="border-top:1px solid #000;"><b>' . number_format($item2) . '</b></td>';
            $tbl .='<td width="100" align="right" style="border-top:1px solid #000;"><b>' . number_format($qty2) . '</b></td>';
            $tbl .='<td width="100" align="right" style="border-top:1px solid #000;"><b>' . number_format($rcv2) . '</b></td>';
            $tbl .='<td width="100" align="right" style="border-top:1px solid #000;"><b>' . number_format($beg2) . '</b></td>';
            $tbl .='<td width="100" align="right" style="border-top:1px solid #000;"><b>' . number_format($price2) . '</b></td>';
            $tbl .='<td width="30"></td>';
            $tbl .='<td width="150"></td>';
            $tbl .='<td width="100"></td>';

            $i = 0;
            $item2 = 0;
            $qty2 = 0;
            $rcv2 = 0;
            $beg2 = 0;
            $price2 = 0;
        }

        $tbl.= '<tr><td colspan="11" align="left"><b style="font-size:1.1em;">SUPPLIER : ' . $dtlrow['supp_code'] . ' : ' . $dtlrow['supp_name'] . '</b></td></tr>';
        $last_supp_code = $dtlrow['supp_code'];
        $last_supp_name = $dtlrow['supp_name'];
    }




    $item += $dtlrow['tot_item'];
    $qty += $dtlrow['tot_qty'];
    $rcv += $dtlrow['rcv_qty'];
    $beg += $dtlrow['beg_qty'];
    $price += $dtlrow['price_ad2'];

    $item2 += $dtlrow['tot_item'];
    $qty2 += $dtlrow['tot_qty'];
    $rcv2 += $dtlrow['rcv_qty'];
    $beg2 += $dtlrow['beg_qty'];
    $price2 += $dtlrow['price_ad2'];

    $po_date = '';
    if ($dtlrow['po_date'] != '0000-00-00') {
        $po_date = date_create($dtlrow['po_date']);
        $po_date = date_format($po_date, "d/m/Y");
    }

    $quote_date = '';
    if ($dtlrow['quote_date'] != '0000-00-00') {
        $quote_date = date_create($dtlrow['quote_date']);
        $quote_date = date_format($quote_date, "d/m/Y");
    }

    $tbl .='<tr>';
    $tbl .='<td width="150" align="left">' . $dtlrow['po_no'] . '</td>';
    $tbl .='<td width="100" align="left">' . $po_date . '</td>';
    $tbl .='<td width="100" align="left">' . $dtlrow['part_code'] . '</td>';
    $tbl .='<td width="150" align="left">' . $dtlrow['part_name'] . '</td>';
    $tbl .='<td width="100" align="right">' . number_format($dtlrow['tot_item']) . '</td>';
    $tbl .='<td width="100" align="right">' . number_format($dtlrow['tot_qty']) . '</td>';
    $tbl .='<td width="100" align="right">' . number_format($dtlrow['rcv_qty']) . '</td>';
    $tbl .='<td width="100" align="right">' . number_format($dtlrow['beg_qty']) . '</td>';
    $tbl .='<td width="100" align="right">' . number_format($dtlrow['price_ad2']) . '</td>';
    $tbl .='<td width="30"></td>';
    $tbl .='<td width="150" align="left">' . $dtlrow['quote_no'] . '</td>';
    $tbl .='<td width="100" align="left">' . $quote_date . '</td>';

    $tbl .='</tr>';

    $i++;
    $j++;

    unset($dtlrow);
}

if ($i >= 1) {
            $tbl .='<tr>';
            $tbl .='<td colspan="4"  align="right"><b>Total Supplier ' . $last_supp_code . ' :</b></td>';
            $tbl .='<td width="100" align="right" style="border-top:1px solid #000;"><b>' . number_format($item2) . '</b></td>';
            $tbl .='<td width="100" align="right" style="border-top:1px solid #000;"><b>' . number_format($qty2) . '</b></td>';
            $tbl .='<td width="100" align="right" style="border-top:1px solid #000;"><b>' . number_format($rcv2) . '</b></td>';
            $tbl .='<td width="100" align="right" style="border-top:1px solid #000;"><b>' . number_format($beg2) . '</b></td>';
            $tbl .='<td width="100" align="right" style="border-top:1px solid #000;"><b>' . number_format($price2) . '</b></td>';
            $tbl .='<td width="30"></td>';
            $tbl .='<td width="150"></td>';
            $tbl .='<td width="100"></td>';

            $i = 0;
            $item2 = 0;
            $qty2 = 0;
            $rcv2 = 0;
            $beg2 = 0;
            $price2 = 0;
}

if ($j >= 1) {

    $tbl .='<tr>';
    $tbl .='<td colspan="4" align="right"><b>Total Currency ' . $last_curr_code . ' :</b></td>';
    $tbl .='<td width="100" align="right" style="border-top:1px solid #000;"><b>' . number_format($item) . '</b></td>';
    $tbl .='<td width="100" align="right" style="border-top:1px solid #000;"><b>' . number_format($qty) . '</b></td>';
    $tbl .='<td width="100" align="right" style="border-top:1px solid #000;"><b>' . number_format($rcv) . '</b></td>';
    $tbl .='<td width="100" align="right" style="border-top:1px solid #000;"><b>' . number_format($beg) . '</b></td>';
    $tbl .='<td width="100" align="right" style="border-top:1px solid #000;"><b>' . number_format($price) . '</b></td>';
    $tbl .='<td width="30"></td>';
    $tbl .='<td width="150"></td>';
    $tbl .='<td width="100"></td>';

    $j = 0;
    $item = 0;
    $qty = 0;
    $rcv = 0;
    $beg = 0;
    $price = 0;
}

$tbl .= '</table>';
