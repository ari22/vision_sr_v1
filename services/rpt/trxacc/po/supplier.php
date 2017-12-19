<?php
//========CHANGE LOG=============
//ganti semua <td jadi <td valign="top"

$tbl .= '
<div id="cntr1" align="center">
<table width="80%">
<tr><td valign = "top" align="center"><b style="font-size:1.5em;">' . $comp_name . '</b></td></tr>
<tr><td valign = "top" align="center"><b style="font-size:1.5em;">' . $rptTitle . '</b></td></tr>
<tr><td valign = "top" align="center"><b style="font-size:1.1em;">By Suppler</b></td></tr>
<tr><td valign = "top" align="center"><b>DATE : ' . dateView($date1) . ' UP TO ' . dateView($date2) . '</b></td></tr>
</table>
';

$tbl .= '
<table width="80%"  >
<tr>
<td valign = "top"></td>
<td valign = "top" align="right"><b>Printed On: </b>' . date('d/m/Y') . '</td>
</tr>
</table>';

$tbl .= '
        <table width="80%">
        <thead style="border:2px solid black !important;">
           <tr>
                <td valign = "top" width="150" align="left"><b>PO No.</b></td>
                <td valign = "top" width="100" align="left"><b>PO Date</b></td>

                <td valign = "top" width="100" align="right"><b>Item</b></td>
                <td valign = "top" width="100" align="right"><b>Qty</b></td>
                <td valign = "top" width="100" align="right"><b>DPP</b></td>
                <td valign = "top" width="100" align="right"><b>PPN</b></td>
                <td valign = "top" width="30"></td>
                <td valign = "top" width="200" align="left"><b>Note</b></td>
            </tr>
      </thead>';

$tbl .= '<tr><td valign = "top" colspan="8"></td></tr>';

$i = 0;
$j = 0;

$item = 0;
$qty = 0;
$inv_bt = 0;
$inv_vat = 0;

$item2 = 0;
$qty2 = 0;
$inv_bt2 = 0;
$inv_vat2 = 0;

$titem = 0;
$tqty = 0;

$tinv_bt = 0;
$tinv_vat = 0;

$last_curr_code = '';

$last_supp_code = '';
$last_supp_name = '';

while ($dtlrow = mysql_fetch_array($dtl)) {

    $titem += $dtlrow['tot_item'];
    $tqty += $dtlrow['tot_qty'];
    $tinv_bt += $dtlrow['inv_bt'];
    $tinv_vat += $dtlrow['inv_vat'];

    if ($last_curr_code != $dtlrow['curr_code']) {
        if ($i >= 1) {
            $tbl .='<tr>';
            $tbl .='<td valign = "top" colspan="2" align="right"><b>TOTAL ' . $last_supp_code . ' :</b></td>';
            $tbl .='<td valign = "top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($item2) . '</td>';
            $tbl .='<td valign = "top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($qty2) . '</td>';
            $tbl .='<td valign = "top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($inv_bt2) . '</td>';
            $tbl .='<td valign = "top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($inv_vat2) . '</td>';
            $tbl .='</tr>';

            $j = 0;
            $item2 = 0;
            $qty2 = 0;
            $inv_bt2 = 0;
            $inv_vat2 = 0;

            $tbl .='<tr>';
            $tbl .='<td valign = "top" colspan="2" align="right"><b>TOTAL Currency ' . $last_curr_code . ' :</b></td>';
            $tbl .='<td valign = "top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($item) . '</td>';
            $tbl .='<td valign = "top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($qty) . '</td>';
            $tbl .='<td valign = "top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($inv_bt) . '</td>';
            $tbl .='<td valign = "top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($inv_vat) . '</td>';

            $tbl .='</tr>';

            $i = 0;
            $item = 0;
            $qty = 0;
            $inv_bt = 0;
            $inv_vat = 0;
        }
        $tbl.= '<tr><td valign = "top" colspan="11" align="left"><b style="font-size:1.1em;">CURRENCY : ' . $dtlrow['curr_code'] . '</b></td></tr>';
        $tbl.= '<tr><td valign = "top" colspan="11" align="left"><b style="font-size:1.1em;"> ' . $dtlrow['supp_code'] . ' : ' . $dtlrow['supp_name'] . '</b></td></tr>';
        $last_supp_code = $dtlrow['supp_code'];
        $last_supp_name = $dtlrow['supp_name'];
        $last_curr_code = $dtlrow['curr_code'];
    }elseif ($last_supp_code != $dtlrow['supp_code']) {
        if ($j >= 1) {

            $tbl .='<tr>';
            $tbl .='<td valign = "top" colspan="2" align="right"><b>TOTAL ' . $last_supp_code . ' :</b></td>';
            $tbl .='<td valign = "top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($item2) . '</td>';
            $tbl .='<td valign = "top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($qty2) . '</td>';
            $tbl .='<td valign = "top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($inv_bt2) . '</td>';
            $tbl .='<td valign = "top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($inv_vat2) . '</td>';

            $tbl .='</tr>';

            $j = 0;
            $item2 = 0;
            $qty2 = 0;
            $inv_bt2 = 0;
            $inv_vat2 = 0;
        }
        $tbl.= '<tr><td valign = "top" colspan="11" align="left"><b style="font-size:1.1em;"> ' . $dtlrow['supp_code'] . ' : ' . $dtlrow['supp_name'] . '</b></td></tr>';
        $last_supp_code = $dtlrow['supp_code'];
        $last_supp_name = $dtlrow['supp_name'];
    }

    $item += $dtlrow['tot_item'];
    $qty += $dtlrow['tot_qty'];
    $inv_bt += $dtlrow['inv_bt'];
    $inv_vat += $dtlrow['inv_vat'];

    $item2 += $dtlrow['tot_item'];
    $qty2 += $dtlrow['tot_qty'];
    $inv_bt2 += $dtlrow['inv_bt'];
    $inv_vat2 += $dtlrow['inv_vat'];

    $po_date = '';
    if ($dtlrow['po_date'] != '0000-00-00') {
        $po_date = date_create($dtlrow['po_date']);
        $po_date = date_format($po_date, "d/m/Y");
    }

    $tbl .='<tr>';
    $tbl .='<td valign = "top" width="150" align="left">' . $dtlrow['po_no'] . '</td>';
    $tbl .='<td valign = "top" width="100" align="left">' . $po_date . '</td>';
    $tbl .='<td valign = "top" width="100" align="right">' . number_format($dtlrow['tot_item']) . '</td>';
    $tbl .='<td valign = "top" width="100" align="right">' . number_format($dtlrow['tot_qty']) . '</td>';
    $tbl .='<td valign = "top" width="100" align="right">' . number_format($dtlrow['inv_bt']) . '</td>';
    $tbl .='<td valign = "top" width="100" align="right">' . number_format($dtlrow['inv_vat']) . '</td>';
    $tbl .='<td valign = "top" width="30"></td>';
    $tbl .='<td valign = "top" width="200" align="left">' . $dtlrow['note'] . '</td>';
    $tbl .='</tr>';

    $i++;
    $j++;

    unset($dtlrow);
}

if ($j >= 1) {

    $tbl .='<tr>';
    $tbl .='<td valign = "top" colspan="2" align="right"><b>TOTAL ' . $last_supp_code . ' :</b></td>';
    $tbl .='<td valign = "top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($item2) . '</td>';
    $tbl .='<td valign = "top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($qty2) . '</td>';
    $tbl .='<td valign = "top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($inv_bt2) . '</td>';
    $tbl .='<td valign = "top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($inv_vat2) . '</td>';

    $tbl .='</tr>';

    $j = 0;
    $item2 = 0;
    $qty2 = 0;
    $inv_bt2 = 0;
    $inv_vat2 = 0;
}

if ($i >= 1) {

    $tbl .='<tr>';
    $tbl .='<td valign = "top"  colspan="2" align="right"><b>TOTAL Currency ' . $last_curr_code . ' :</b></td>';
    $tbl .='<td valign = "top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($item) . '</td>';
    $tbl .='<td valign = "top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($qty) . '</td>';
    $tbl .='<td valign = "top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($inv_bt) . '</td>';
    $tbl .='<td valign = "top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($inv_vat) . '</td>';

    $tbl .='</tr>';

    $i = 0;
    $item = 0;
    $qty = 0;
    $inv_bt = 0;
    $inv_vat = 0;
}

$tbl .='<tr><td valign = "top"><br /></td></tr>';
$tbl .='<tfoot>';
$tbl .='<tr>';
$tbl .='<td></td>';
$tbl .='<td class="border-foot" style="border-left:2px solid black;border-bottom:2px solid black;border-top:2px solid black;" valign = "top"  align="right"><b>GRAND TOTAL :</b></td>';
$tbl .='<td class="border-foot" style="border-bottom:2px solid black;border-top:2px solid black;" valign = "top" width="100" align="right"><b>' . number_format($titem) . '</b></td>';
$tbl .='<td class="border-foot" style="border-bottom:2px solid black;border-top:2px solid black;" valign = "top" width="100" align="right"><b>' . number_format($tqty) . '</b></td>';
$tbl .='<td class="border-foot" style="border-bottom:2px solid black;border-top:2px solid black;" valign = "top" width="100" align="right"><b>' . number_format($tinv_bt) . '</b></td>';
$tbl .='<td class="border-foot" style="border-right:2px solid black;border-bottom:2px solid black;border-top:2px solid black;" valign = "top" width="100" align="right"><b>' . number_format($tinv_vat) . '</b></td>';
$tbl .='</tr>';
$tbl .='</tfoot>';

$tbl .= '</table>';
