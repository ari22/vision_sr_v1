<?php
//========CHANGE LOG=============
//ganti semua <td jadi <td valign="top"
//pembetulan judul
//pembetulan tabel (total)
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
            <td valign="top" width="100" align="left"><b>SPB Date</b></td>
            <td valign="top" width="150" align="left"><b>SPB No.</b></td>
            <td valign="top" width="150" align="left"><b>Department</b></td>
            <td valign="top" width="100" align="left"><b>Unit Code</b></td>
            <td valign="top" width="100" align="right"><b>Item</b></td>
            <td valign="top" width="100" align="right"><b>Total<br />Qty</b></td>
            <td valign="top" width="100" align="right"><b>Part Price</b></td>
            <td valign="top" width="100" align="right"><b>Part Disc.</b></td>
            <td valign="top" width="100" align="right"><b>Netto Price</b></td>
            <td valign="top" width="100" align="right"><b>Invoice Disc.</b></td>
            <td valign="top" width="100" align="right"><b>DPP</b></td>
            <td valign="top" width="100" align="right"><b>PPN</b></td>
            <td valign="top" width="100" align="right"><b>Others</b></td>
            <td valign="top" width="100" align="right"><b>Total Invoice</b></td>
            <td valign="top" width="30"></td>
            <td valign="top" width="150" align="left"><b>Note</b></td>
           </tr>
        </thead>';
$tbl .= '<tr><td valign="top" colspan="6"></td></tr>';

$i = 0;
$j = 0;

$item = 0;
$qty = 0;
$price = 0;
$disc = 0;
$inv_disc = 0;
$inv_bt = 0;
$inv_vat = 0;
$inv_stamp = 0;
$inv_total = 0;

$titem = 0;
$tqty = 0;
$tprice = 0;
$tdisc = 0;
$tinv_disc = 0;
$tinv_bt = 0;
$tinv_vat = 0;
$tinv_stamp = 0;
$tinv_total = 0;

$last_wrhs_code = '';

while ($dtlrow = mysql_fetch_array($dtl)) {

    $titem += $dtlrow['tot_item'];
    $tqty += $dtlrow['tot_qty'];
    $tprice += $dtlrow['tot_price'];
    $tdisc += $dtlrow['tot_disc'];
    $tinv_disc += $dtlrow['inv_disc'];
    $tinv_bt += $dtlrow['inv_bt'];
    $tinv_vat += $dtlrow['inv_vat'];
    $tinv_stamp += $dtlrow['inv_stamp'];
    $tinv_total += $dtlrow['inv_total'];


    if ($last_wrhs_code != $dtlrow['wrhs_code']) {
        if ($i >= 1) {
            $tbl .='<tr>';
            $tbl .='<td valign="top" width="100"></td>';
            $tbl .='<td valign="top" width="150"></td>';
            $tbl .='<td valign="top"  colspan="2" align="right"><b>TOTAL ' . $last_wrhs_code . ':</b></td>';
            $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($item) . '</td>';
            $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($qty) . '</td>';
            $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($price) . '</td>';
            $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($disc) . '</td>';
            $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($price) . '</td>';
            $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($inv_disc) . '</td>';
            $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($inv_bt) . '</td>';
            $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($inv_vat) . '</td>';
            $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($inv_stamp) . '</td>';
            $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($inv_total) . '</td>';
            $tbl .='<td valign="top" width="30"></td>';
            $tbl .='<td valign="top" width="150"></td>';
            $tbl .='</tr>';

            $j = 0;
            $item = 0;
            $qty = 0;
            $price = 0;
            $disc = 0;
            $inv_disc = 0;
            $inv_bt = 0;
            $inv_vat = 0;
            $inv_stamp = 0;
            $inv_total = 0;
        }

        $tbl.= '<tr><td valign="top" colspan="16" align="left"><b style="font-size:1.1em;">WAREHOUSE : ' . $dtlrow['wrhs_code'] . '</b></td></tr>';
        $last_wrhs_code = $dtlrow['wrhs_code'];
    }


    $item += $dtlrow['tot_item'];
    $qty += $dtlrow['tot_qty'];
    $price += $dtlrow['tot_price'];
    $disc += $dtlrow['tot_disc'];
    $inv_disc += $dtlrow['inv_disc'];
    $inv_bt += $dtlrow['inv_bt'];
    $inv_vat += $dtlrow['inv_vat'];
    $inv_stamp += $dtlrow['inv_stamp'];
    $inv_total += $dtlrow['inv_total'];


    $sal_date = '';
    if ($dtlrow['sal_date'] != '0000-00-00') {
        $sal_date = date_create($dtlrow['sal_date']);
        $sal_date = date_format($sal_date, "d/m/Y");
    }

    $tbl .='<tr>';
    $tbl .='<td valign="top" width="100" align="left">' . $sal_date . '</td>';
    $tbl .='<td valign="top" width="150" align="left">' . $dtlrow['sal_inv_no'] . '</td>';
    $tbl .='<td valign="top" width="150" align="left">' . $dtlrow['cust_name'] . '</td>';
    $tbl .='<td valign="top" width="100" align="left">' . $dtlrow['dunit_code'] . '</td>';
    $tbl .='<td valign="top" width="100" align="right">' . number_format($dtlrow['tot_item']) . '</td>';
    $tbl .='<td valign="top" width="100" align="right">' . number_format($dtlrow['tot_qty']) . '</td>';
    $tbl .='<td valign="top" width="100" align="right">' . number_format($dtlrow['tot_price']) . '</td>';
    $tbl .='<td valign="top" width="100" align="right">' . number_format($dtlrow['tot_disc']) . '</td>';
    $tbl .='<td valign="top" width="100" align="right">' . number_format($dtlrow['tot_price']) . '</td>';
    $tbl .='<td valign="top" width="100" align="right">' . number_format($dtlrow['inv_disc']) . '</td>';
    $tbl .='<td valign="top" width="100" align="right">' . number_format($dtlrow['inv_bt']) . '</td>';
    $tbl .='<td valign="top" width="100" align="right">' . number_format($dtlrow['inv_vat']) . '</td>';
    $tbl .='<td valign="top" width="100" align="right">' . number_format($dtlrow['inv_stamp']) . '</td>';
    $tbl .='<td valign="top" width="100" align="right">' . number_format($dtlrow['inv_total']) . '</td>';
    $tbl .='<td valign="top" width="30"></td>';
    $tbl .='<td valign="top" width="150" align="left">' . $dtlrow['note'] . '</td>';
    $tbl .='</tr>';

    $i++;
    $j++;

    unset($dtlrow);
}

if ($i >= 1) {
    $tbl .='<tr>';
    $tbl .='<td valign="top" width="100"></td>';
    $tbl .='<td valign="top" width="150"></td>';
    $tbl .='<td valign="top" align="right" colspan="2"><b>TOTAL ' . $last_wrhs_code . ' :</b></td>';
    $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($item) . '</td>';
    $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($qty) . '</td>';
    $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($price) . '</td>';
    $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($disc) . '</td>';
    $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($price) . '</td>';
    $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($inv_disc) . '</td>';
    $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($inv_bt) . '</td>';
    $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($inv_vat) . '</td>';
    $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($inv_stamp) . '</td>';
    $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($inv_total) . '</td>';
    $tbl .='<td valign="top" width="30"></td>';
    $tbl .='<td valign="top" width="150"></td>';
    $tbl .='</tr>';

    $j = 0;
    $item = 0;
    $qty = 0;
    $price = 0;
    $disc = 0;
    $inv_disc = 0;
    $inv_bt = 0;
    $inv_vat = 0;
    $inv_stamp = 0;
    $inv_total = 0;
}


$tbl .='<tr><td valign="top" colspan="16"><br /></td></tr>';
$tbl .='<tfoot>';
$tbl .='<tr>';
$tbl .='<td valign="top" width="100"></td>';
$tbl .='<td valign="top" width="150"></td>';
$tbl .='<td class="border-foot" style="border-left:2px solid black;border-bottom:2px solid black;border-top:2px solid black;" valign="top" colspan="2" align="right"><b>GRAND TOTAL :</b></td>';
$tbl .='<td class="border-foot" style="border-bottom:2px solid black;border-top:2px solid black;" valign="top" width="100" align="right"><b>' . number_format($titem) . '</b></td>';
$tbl .='<td class="border-foot" style="border-bottom:2px solid black;border-top:2px solid black;" valign="top" width="100" align="right"><b>' . number_format($tqty) . '</b></td>';
$tbl .='<td class="border-foot" style="border-bottom:2px solid black;border-top:2px solid black;" valign="top" width="100" align="right"><b>' . number_format($tprice) . '</b></td>';
$tbl .='<td class="border-foot" style="border-bottom:2px solid black;border-top:2px solid black;" valign="top" width="100" align="right"><b>' . number_format($tdisc) . '</b></td>';
$tbl .='<td class="border-foot" style="border-bottom:2px solid black;border-top:2px solid black;" valign="top" width="100" align="right"><b>' . number_format($tprice) . '</b></td>';
$tbl .='<td class="border-foot" style="border-bottom:2px solid black;border-top:2px solid black;" valign="top" width="100" align="right"><b>' . number_format($tinv_disc) . '</b></td>';
$tbl .='<td class="border-foot" style="border-bottom:2px solid black;border-top:2px solid black;" valign="top" width="100" align="right"><b>' . number_format($tinv_bt) . '</b></td>';
$tbl .='<td class="border-foot" style="border-bottom:2px solid black;border-top:2px solid black;" valign="top" width="100" align="right"><b>' . number_format($tinv_vat) . '</b></td>';
$tbl .='<td class="border-foot" style="border-bottom:2px solid black;border-top:2px solid black;" valign="top" width="100" align="right"><b>' . number_format($tinv_stamp) . '</b></td>';
$tbl .='<td class="border-foot" style="border-right:2px solid black;border-bottom:2px solid black;border-top:2px solid black;" valign="top" width="100" align="right"><b>' . number_format($tinv_total) . '</b></td>';
$tbl .='<td valign="top" width="30"></td>';
$tbl .='<td valign="top" width="150"></td>';
$tbl .='</tr>';
$tbl .='</tfoot>';
$tbl .='</table>';
