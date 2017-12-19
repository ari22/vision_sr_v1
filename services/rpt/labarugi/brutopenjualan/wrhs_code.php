<?php

//==========CHANGE LOG========
//<td => <td valign="top"
//Debet Note => Debit Note
//Basic Price => Base Price
//tadinya ad 2 tanggal printed on, yg 1 dihapus
//pengaturan ukuran kolom2
//Total Laba Rugi Bruto Dari Whrs => Total Gross Profit and Loss from Wrhs
//Total Laba Rugi Bruto => Total Gross Profit and Loss
//TOTAL Profit and Loss Bruto Sale => TOTAL SALES Gross Profit and Loss
//TOTAL Profit and Loss Bruto RETUR => TOTAL RETUR Gross Profit and Loss
//Tipe => Type
//RETUR SALE => SALES RETURN

$tbl .= '
<div id="cntr1" align="center">
<table width="100%">
<tr><td valign="top" align="center"><b style="font-size:1.5em;">' . $comp_name . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.5em;">' . $title . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.1em;">By Warehouse</b></td></tr>
<tr><td valign="top" align="center"><b>DATE : ' . dateView($date1) . ' UP TO ' . dateView($date2) . '</b></td></tr>
</table>
';



$tbl .= '<table width="100%">';
$tbl .= '
            <tr>
                <td valign="top" width="150"></td>
                <td valign="top" width="150"></td>
                <td valign="top" width="100"></td>
                <td valign="top" width="100"></td>
                <td valign="top" width="100"></td>
                <td valign="top" width="100"></td>
                <td valign="top" width="100"></td>

                <td valign="top" width="100"></td>
                <td valign="top" width="100"></td>
                <td valign="top" width="100"></td>
                <td valign="top" width="100"></td>
                <td valign="top" width="100"></td>
                <td valign="top" width="100"></td>
            </tr>
            <tr>
                <td valign="top" colspan="2"></td>
                <td valign="top"><b>SALE</b></td>
                <td valign="top" colspan="3" align="right"><b>a - b = c  = g + h + i</b></td>
                <td valign="top" align="right"><b>c + d + e = f</b></td>
                <td valign="top" colspan="4" align="center"><b>PURCHASE</b></td>
                <td valign="top" colspan="2" align="right"><b>Printed On: </b>' . date('d/m/Y') . '</td>
            </tr>
        </table>';
$tbl .= '
        <table width="100%">
        <thead style="border:2px solid black !important;">
            <tr>
                <td valign="top" width="140"><b>Chassis /<br />Tax No.</b></td>
                <td valign="top" width="140" style="border-right:2px solid black;"><b>Receipt No./Date</b></td>
                <td valign="top" align="right" width="110"><b>Price OFF TR (a)<br />BBN (d)</b></td>
                <td valign="top" align="right" width="100"><b>Discount (b)<br />Etc. (e)</b></td>
                <td valign="top" align="right" width="110"><b>Netto OFF TR (c)<br />Price On TR (f)</b></td>
                <td valign="top" align="right" width="100"><b>PPN(h)<br />PBM(i)</b></td>
                <td valign="top" align="right" width="100"><b>Base Price (g)<br />(Receipt)</b></td>
                <td valign="top" align="right" width="100" style="border-left:2px solid black;"><b>Total Price<br />(Debit Note)</b></td>
                <td valign="top" align="right" width="100"><b>Etc.</b></td>
                <td valign="top" align="right" width="100"><b>PPN<br />PPH 22</b></td>
                <td valign="top" align="right" width="100"><b>Base Price<br />(Debit Note)</b></td>
                <td valign="top" align="right" width="100" style="border-left:2px solid black;"><b>Gross Profit and Loss</b></td>
                <td valign="top" align="right" width="100"><b>QTY</b></td>
            </tr>
        </thead>';

$tbl .= '<tr><td valign="top"></td></tr>';

$i = 0;
$j = 0;

$qty = 0;
$veh_price = 0;
$veh_bbn = 0;
$veh_disc = 0;
$veh_misc = 0;
$veh_at = 0;
$veh_total = 0;
$veh_vat = 0;
$veh_pbm = 0;
$veh_bt = 0;
$pur_price = 0;
$pur_misc = 0;
$pur_vat = 0;
$pur_bt = 0;
$laba = 0;

$qty1 = 0;
$veh_price1 = 0;
$veh_bbn1 = 0;
$veh_disc1 = 0;
$veh_misc1 = 0;
$veh_at1 = 0;
$veh_total1 = 0;
$veh_vat1 = 0;
$veh_pbm1 = 0;
$veh_bt1 = 0;
$pur_price1 = 0;
$pur_misc1 = 0;
$pur_vat1 = 0;
$pur_bt1 = 0;
$laba1 = 0;

$tqty = 0;
$tveh_price = 0;
$tveh_bbn = 0;
$tveh_disc = 0;
$tveh_misc = 0;
$tveh_at = 0;
$tveh_total = 0;
$tveh_vat = 0;
$tveh_pbm = 0;
$tveh_bt = 0;
$tpur_price = 0;
$tpur_misc = 0;
$tpur_vat = 0;
$tpur_bt = 0;
$tlaba = 0;

$last_veh_code = '';
$last_veh_name = '';
$last_wrhs_code = '';

$tbl .='<tr><td valign="top" colspan="13" style="color:blue;font-weight:bold;font-size:1.1em;" align="left">SALE</td></tr>';

while ($dtlrow = mysql_fetch_array($dtl)) {

    $tqty += 1;
    $tveh_price += $dtlrow['veh_price'];
    $tveh_bbn += $dtlrow['veh_bbn'];
    $tveh_disc += $dtlrow['veh_disc'];
    $tveh_misc += $dtlrow['veh_misc'];
    $tveh_at += $dtlrow['veh_at'];
    $tveh_total += $dtlrow['veh_total'];
    $tveh_vat += $dtlrow['veh_vat'];
    $tveh_pbm += $dtlrow['veh_pbm'];
    $tveh_bt += $dtlrow['veh_bt'];
    $tpur_price += $dtlrow['pur_price'];
    $tpur_misc += $dtlrow['pur_misc'];
    $tpur_vat += $dtlrow['pur_vat'];
    $tpur_bt += $dtlrow['pur_bt'];
    $tlaba += $dtlrow['veh_bt'] - $dtlrow['pur_bt'];

    if ($last_wrhs_code != $dtlrow['wrhs_code']) {
        if ($j >= 1) {
            $tbl .='<tr>';
            $tbl .='<td valign="top" colspan="2" valign="top"><b>Total Gross Profit and Loss from Wrhs ' . $last_wrhs_code . ' :</b></td>';
            $tbl .='<td valign="top" width="100" align="right" style="border-top:2px solid #000;">' . number_format($veh_price) . '<br />' . number_format($veh_bbn) . '</td>';
            $tbl .='<td valign="top" width="100" align="right" style="border-top:2px solid #000;">' . number_format($veh_disc) . '<br />' . number_format($veh_misc) . '</td>';
            $tbl .='<td valign="top" width="100" align="right" style="border-top:2px solid #000;">' . number_format($veh_at) . '<br />' . number_format($veh_total) . '</td>';
            $tbl .='<td valign="top" width="100" align="right" style="border-top:2px solid #000;">' . number_format($veh_vat) . '<br />' . number_format($veh_pbm) . '</td>';
            $tbl .='<td valign="top" width="100" align="right" style="border-top:2px solid #000;">' . number_format($veh_bt) . '</td>';
            $tbl .='<td valign="top" width="100" align="right" style="border-top:2px solid #000;">' . number_format($pur_price) . '</td>';
            $tbl .='<td valign="top" width="100" align="right" style="border-top:2px solid #000;">' . number_format($pur_misc) . '</td>';
            $tbl .='<td valign="top" width="100" align="right" style="border-top:2px solid #000;">' . number_format($pur_vat) . '</td>';
            $tbl .='<td valign="top" width="100" align="right" style="border-top:2px solid #000;">' . number_format($pur_bt) . '</td>';
            $tbl .='<td valign="top" width="100" align="right" style="border-top:2px solid #000;">' . number_format($laba) . '</td>';
            $tbl .='<td valign="top" width="100" align="right" style="border-top:2px solid #000;">' . number_format($qty) . ' Unit</td>';
            $tbl .='</tr>';

            $j = 0;
            $qty = 0;
            $veh_price = 0;
            $veh_bbn = 0;
            $veh_disc = 0;
            $veh_misc = 0;
            $veh_at = 0;
            $veh_total = 0;
            $veh_vat = 0;
            $veh_pbm = 0;
            $veh_bt = 0;
            $pur_price = 0;
            $pur_misc = 0;
            $pur_vat = 0;
            $pur_bt = 0;
            $laba = 0;
        }

        $tbl.= '<tr><td valign="top" colspan="11" align="left"><b style="font-size:1.1em;">***WAREHOUSE : ' . $dtlrow['wrhs_code'] . '***</b></td></tr>';
        $last_wrhs_code = $dtlrow['wrhs_code'];
    }

    if ($last_veh_code != $dtlrow['veh_code']) {
        if ($i >= 1) {
            $tbl .='<tr>';
            $tbl .='<td valign="top" colspan="2" valign="top">Total Gross Profit and Loss ' . $last_veh_code . ' :</td>';
            $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($veh_price1) . '<br />' . number_format($veh_bbn1) . '</td>';
            $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($veh_disc1) . '<br />' . number_format($veh_misc1) . '</td>';
            $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($veh_at1) . '<br />' . number_format($veh_total1) . '</td>';
            $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($veh_vat1) . '<br />' . number_format($veh_pbm1) . '</td>';
            $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($veh_bt1) . '</td>';
            $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($pur_price1) . '</td>';
            $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($pur_misc1) . '</td>';
            $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($pur_vat1) . '</td>';
            $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($pur_bt1) . '</td>';
            $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($laba1) . '</td>';
            $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($qty1) . ' <b>UNIT</b></td>';
            $tbl .='</tr>';

            $i = 0;
            $qty1 = 0;
            $veh_price1 = 0;
            $veh_bbn1 = 0;
            $veh_disc1 = 0;
            $veh_misc1 = 0;
            $veh_at1 = 0;
            $veh_total1 = 0;
            $veh_vat1 = 0;
            $veh_pbm1 = 0;
            $veh_bt1 = 0;
            $pur_price1 = 0;
            $pur_misc1 = 0;
            $pur_vat1 = 0;
            $pur_bt1 = 0;
            $laba1 = 0;
        }


        $tbl.= '<tr><td valign="top" colspan="11" align="left"><b style="font-size:1.1em;">Type : ' . $dtlrow['veh_code'] . ' : ' . $dtlrow['veh_name'] . '</b></td></tr>';
        $last_veh_code = $dtlrow['veh_code'];
        $last_veh_name = $dtlrow['veh_name'];
    }


    $qty += 1;
    $veh_price += $dtlrow['veh_price'];
    $veh_bbn += $dtlrow['veh_bbn'];
    $veh_disc += $dtlrow['veh_disc'];
    $veh_misc += $dtlrow['veh_misc'];
    $veh_at += $dtlrow['veh_at'];
    $veh_total += $dtlrow['veh_total'];
    $veh_vat += $dtlrow['veh_vat'];
    $veh_pbm += $dtlrow['veh_pbm'];
    $veh_bt += $dtlrow['veh_bt'];
    $pur_price += $dtlrow['pur_price'];
    $pur_misc += $dtlrow['pur_misc'];
    $pur_vat += $dtlrow['pur_vat'];
    $pur_bt += $dtlrow['pur_bt'];
    $laba += $dtlrow['veh_bt'] - $dtlrow['pur_bt'];

    $qty1 += 1;
    $veh_price1 += $dtlrow['veh_price'];
    $veh_bbn1 += $dtlrow['veh_bbn'];
    $veh_disc1 += $dtlrow['veh_disc'];
    $veh_misc1 += $dtlrow['veh_misc'];
    $veh_at1 += $dtlrow['veh_at'];
    $veh_total1 += $dtlrow['veh_total'];
    $veh_vat1 += $dtlrow['veh_vat'];
    $veh_pbm1 += $dtlrow['veh_pbm'];
    $veh_bt1 += $dtlrow['veh_bt'];
    $pur_price1 += $dtlrow['pur_price'];
    $pur_misc1 += $dtlrow['pur_misc'];
    $pur_vat1 += $dtlrow['pur_vat'];
    $pur_bt1 += $dtlrow['pur_bt'];
    $laba1 += $dtlrow['veh_bt'] - $dtlrow['pur_bt'];



    $kwit_date = '';
    if ($dtlrow['kwit_date'] != '0000-00-00') {
        $kwit_date = date_create($dtlrow['kwit_date']);
        $kwit_date = date_format($kwit_date, "d/m/Y");
    }

    $tbl .='<tr>';
    $tbl .='<td valign="top" width="150">' . $dtlrow['chassis'] . '<br />' . $dtlrow['fp_no'] . '</td>';
    $tbl .='<td valign="top" width="150">' . $dtlrow['kwit_no'] . '<br />' . $kwit_date . '</td>';
    $tbl .='<td valign="top" width="100" align="right">' . number_format($dtlrow['veh_price']) . '<br />' . number_format($dtlrow['veh_bbn']) . '</td>';
    $tbl .='<td valign="top" width="100" align="right">' . number_format($dtlrow['veh_disc']) . '<br />' . number_format($dtlrow['veh_misc']) . '</td>';
    $tbl .='<td valign="top" width="100" align="right">' . number_format($dtlrow['veh_at']) . '<br />' . number_format($dtlrow['veh_total']) . '</td>';
    $tbl .='<td valign="top" width="100" align="right">' . number_format($dtlrow['veh_vat']) . '<br />' . number_format($dtlrow['veh_pbm']) . '</td>';
    $tbl .='<td valign="top" width="100" align="right">' . number_format($dtlrow['veh_bt']) . '</td>';
    $tbl .='<td valign="top" width="100" align="right">' . number_format($dtlrow['pur_price']) . '</td>';
    $tbl .='<td valign="top" width="100" align="right">' . number_format($dtlrow['pur_misc']) . '</td>';
    $tbl .='<td valign="top" width="100" align="right">' . number_format($dtlrow['pur_vat']) . '</td>';
    $tbl .='<td valign="top" width="100" align="right">' . number_format($dtlrow['pur_bt']) . '</td>';
    $tbl .='<td valign="top" width="100" align="right">' . number_format($dtlrow['veh_bt'] - $dtlrow['pur_bt']) . '</td>';
    $tbl .='<td valign="top" width="100"></td>';
    $tbl .='</tr>';

    $i++;
    $j++;

    unset($dtlrow);
}


if ($i >= 1) {
    $tbl .='<tr>';
    $tbl .='<td valign="top" colspan="2" valign="top"><b>Total Gross Profit and Loss ' . $last_veh_code . ' :</b></td>';
    $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($veh_price1) . '<br />' . number_format($veh_bbn1) . '</td>';
    $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($veh_disc1) . '<br />' . number_format($veh_misc1) . '</td>';
    $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($veh_at1) . '<br />' . number_format($veh_total1) . '</td>';
    $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($veh_vat1) . '<br />' . number_format($veh_pbm1) . '</td>';
    $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($veh_bt1) . '</td>';
    $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($pur_price1) . '</td>';
    $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($pur_misc1) . '</td>';
    $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($pur_vat1) . '</td>';
    $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($pur_bt1) . '</td>';
    $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($laba1) . '</td>';
    $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($qty1) . ' <b>UNIT</b></td>';
    $tbl .='</tr>';

    $i = 0;
    $qty1 = 0;
    $veh_price1 = 0;
    $veh_bbn1 = 0;
    $veh_disc1 = 0;
    $veh_misc1 = 0;
    $veh_at1 = 0;
    $veh_total1 = 0;
    $veh_vat1 = 0;
    $veh_pbm1 = 0;
    $veh_bt1 = 0;
    $pur_price1 = 0;
    $pur_misc1 = 0;
    $pur_vat1 = 0;
    $pur_bt1 = 0;
    $laba1 = 0;
}
if ($j >= 1) {
    $tbl .='<tr>';
    $tbl .='<td valign="top" colspan="2" valign="top"><b>Total Gross Profit and Loss from Wrhs ' . $last_wrhs_code . ' :</b></td>';
    $tbl .='<td valign="top" width="100" align="right" style="border-top:2px solid #000;">' . number_format($veh_price) . '<br />' . number_format($veh_bbn) . '</td>';
    $tbl .='<td valign="top" width="100" align="right" style="border-top:2px solid #000;">' . number_format($veh_disc) . '<br />' . number_format($veh_misc) . '</td>';
    $tbl .='<td valign="top" width="100" align="right" style="border-top:2px solid #000;">' . number_format($veh_at) . '<br />' . number_format($veh_total) . '</td>';
    $tbl .='<td valign="top" width="100" align="right" style="border-top:2px solid #000;">' . number_format($veh_vat) . '<br />' . number_format($veh_pbm) . '</td>';
    $tbl .='<td valign="top" width="100" align="right" style="border-top:2px solid #000;">' . number_format($veh_bt) . '</td>';
    $tbl .='<td valign="top" width="100" align="right" style="border-top:2px solid #000;">' . number_format($pur_price) . '</td>';
    $tbl .='<td valign="top" width="100" align="right" style="border-top:2px solid #000;">' . number_format($pur_misc) . '</td>';
    $tbl .='<td valign="top" width="100" align="right" style="border-top:2px solid #000;">' . number_format($pur_vat) . '</td>';
    $tbl .='<td valign="top" width="100" align="right" style="border-top:2px solid #000;">' . number_format($pur_bt) . '</td>';
    $tbl .='<td valign="top" width="100" align="right" style="border-top:2px solid #000;">' . number_format($laba) . '</td>';
    $tbl .='<td valign="top" width="100" align="right" style="border-top:2px solid #000;">' . number_format($qty) . ' Unit</td>';
    $tbl .='</tr>';

    $j = 0;
    $qty = 0;
    $veh_price = 0;
    $veh_bbn = 0;
    $veh_disc = 0;
    $veh_misc = 0;
    $veh_at = 0;
    $veh_total = 0;
    $veh_vat = 0;
    $veh_pbm = 0;
    $veh_bt = 0;
    $pur_price = 0;
    $pur_misc = 0;
    $pur_vat = 0;
    $pur_bt = 0;
    $laba = 0;
}


$tbl .='<tr><td valign="top"><br /></td></tr>';

$tbl .='<tr style="border:2px solid blue;color:blue;">';
$tbl .='<td valign="top" colspan="2" valign="top"><b>TOTAL SALES Gross Profit and Loss</b></td>';
$tbl .='<td valign="top" width="100" align="right">' . number_format($tveh_price) . '<br />' . number_format($tveh_bbn) . '</td>';
$tbl .='<td valign="top" width="100" align="right">' . number_format($tveh_disc) . '<br />' . number_format($tveh_misc) . '</td>';
$tbl .='<td valign="top" width="100" align="right" >' . number_format($tveh_at) . '<br />' . number_format($tveh_total) . '</td>';
$tbl .='<td valign="top" width="100" align="right" >' . number_format($tveh_vat) . '<br />' . number_format($tveh_pbm) . '</td>';
$tbl .='<td valign="top" width="100" align="right" >' . number_format($tveh_bt) . '</td>';
$tbl .='<td valign="top" width="100" align="right" >' . number_format($tpur_price) . '</td>';
$tbl .='<td valign="top" width="100" align="right" >' . number_format($tpur_misc) . '</td>';
$tbl .='<td valign="top" width="100" align="right" >' . number_format($tpur_vat) . '</td>';
$tbl .='<td valign="top" width="100" align="right" >' . number_format($tpur_bt) . '</td>';
$tbl .='<td valign="top" width="100" align="right" >' . number_format($tlaba) . '</td>';
$tbl .='<td valign="top" width="100" align="right" >' . number_format($tqty) . ' Unit</td>';
$tbl .='</tr>';

$tbl .='<tr><td valign="top"><br /></td></tr>';

if ($countreturn > 0) {
    $tbl .='<tr><td valign="top" colspan="13" style="color:blue;font-weight:bold;font-size:1.1em;" align="left">SALES RETURN</td></tr>';


    $i2 = 0;
    $j2 = 0;

    $qty2 = 0;
    $veh_price2 = 0;
    $veh_bbn2 = 0;
    $veh_disc2 = 0;
    $veh_misc2 = 0;
    $veh_at2 = 0;
    $veh_total2 = 0;
    $veh_vat2 = 0;
    $veh_pbm2 = 0;
    $veh_bt2 = 0;
    $pur_price2 = 0;
    $pur_misc2 = 0;
    $pur_vat2 = 0;
    $pur_bt2 = 0;
    $laba2 = 0;

    $qty22 = 0;
    $veh_price22 = 0;
    $veh_bbn22 = 0;
    $veh_disc22 = 0;
    $veh_misc22 = 0;
    $veh_at22 = 0;
    $veh_total22 = 0;
    $veh_vat22 = 0;
    $veh_pbm22 = 0;
    $veh_bt22 = 0;
    $pur_price22 = 0;
    $pur_misc22 = 0;
    $pur_vat22 = 0;
    $pur_bt22 = 0;
    $laba22 = 0;

    $tqty2 = 0;
    $tveh_price2 = 0;
    $tveh_bbn2 = 0;
    $tveh_disc2 = 0;
    $tveh_misc2 = 0;
    $tveh_at2 = 0;
    $tveh_total2 = 0;
    $tveh_vat2 = 0;
    $tveh_pbm2 = 0;
    $tveh_bt2 = 0;
    $tpur_price2 = 0;
    $tpur_misc2 = 0;
    $tpur_vat2 = 0;
    $tpur_bt2 = 0;
    $tlaba2 = 0;

    $last_veh_code2 = '';
    $last_veh_name2 = '';
    $last_wrhs_code2 = '';

    while ($dtlrow2 = mysql_fetch_array($dtl2)) {

        $tqty2 += 1;
        $tveh_price2 += $dtlrow2['veh_price'];
        $tveh_bbn2 += $dtlrow2['veh_bbn'];
        $tveh_disc2 += $dtlrow2['veh_disc'];
        $tveh_misc2 += $dtlrow2['veh_misc'];
        $tveh_at2 += $dtlrow2['veh_at'];
        $tveh_total2 += $dtlrow2['veh_total'];
        $tveh_vat2 += $dtlrow2['veh_vat'];
        $tveh_pbm2 += $dtlrow2['veh_pbm'];
        $tveh_bt2 += $dtlrow2['veh_bt'];
        $tpur_price2 += $dtlrow2['pur_price'];
        $tpur_misc2 += $dtlrow2['pur_misc'];
        $tpur_vat2 += $dtlrow2['pur_vat'];
        $tpur_bt2 += $dtlrow2['pur_bt'];
        $tlaba2 += $dtlrow2['veh_bt'] - $dtlrow2['pur_bt'];

        if ($last_wrhs_code2 != $dtlrow2['wrhs_code']) {
            if ($j2 >= 1) {
                $tbl .='<tr>';
                $tbl .='<td valign="top" colspan="2" valign="top">Total Gross Profit and Loss from Whrs ' . $last_wrhs_code2 . ' :</td>';
                $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">-' . number_format($veh_price22) . '<br />-' . number_format($veh_bbn22) . '</td>';
                $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">-' . number_format($veh_disc22) . '<br />-' . number_format($veh_misc22) . '</td>';
                $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">-' . number_format($veh_at22) . '<br />-' . number_format($veh_total22) . '</td>';
                $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">-' . number_format($veh_vat22) . '<br />-' . number_format($veh_pbm22) . '</td>';
                $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">-' . number_format($veh_bt22) . '</td>';
                $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">-' . number_format($pur_price22) . '</td>';
                $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">-' . number_format($pur_misc22) . '</td>';
                $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">-' . number_format($pur_vat22) . '</td>';
                $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">-' . number_format($pur_bt22) . '</td>';
                $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">-' . number_format($laba22) . '</td>';
                $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">-' . number_format($qty22) . ' Unit</td>';
                $tbl .='</tr>';

                $j2 = 0;

                $qty22 = 0;
                $veh_price22 = 0;
                $veh_bbn22 = 0;
                $veh_disc22 = 0;
                $veh_misc22 = 0;
                $veh_at22 = 0;
                $veh_total22 = 0;
                $veh_vat22 = 0;
                $veh_pbm22 = 0;
                $veh_bt22 = 0;
                $pur_price22 = 0;
                $pur_misc22 = 0;
                $pur_vat22 = 0;
                $pur_bt22 = 0;
                $laba22 = 0;
            }

            $tbl.= '<tr><td valign="top" colspan="11" align="left"><b style="font-size:1.1em;">***WAREHOUSE : ' . $dtlrow2['wrhs_code'] . '***</b></td></tr>';
            $last_wrhs_code2 = $dtlrow2['wrhs_code'];
        }

        if ($last_veh_code2 != $dtlrow2['veh_code']) {

            if ($i2 >= 1) {
                $tbl .='<tr>';
                $tbl .='<td valign="top" colspan="2" valign="top">Total Gross Profit and Loss ' . $last_veh_code2 . ' :</td>';
                $tbl .='<td valign="top" width="100" align="right" style="border-top:2px solid #000;">-' . number_format($veh_price2) . '<br />-' . number_format($veh_bbn2) . '</td>';
                $tbl .='<td valign="top" width="100" align="right" style="border-top:2px solid #000;">-' . number_format($veh_disc2) . '<br />-' . number_format($veh_misc2) . '</td>';
                $tbl .='<td valign="top" width="100" align="right" style="border-top:2px solid #000;">-' . number_format($veh_at2) . '<br />-' . number_format($veh_total2) . '</td>';
                $tbl .='<td valign="top" width="100" align="right" style="border-top:2px solid #000;">-' . number_format($veh_vat2) . '<br />-' . number_format($veh_pbm2) . '</td>';
                $tbl .='<td valign="top" width="100" align="right" style="border-top:2px solid #000;">-' . number_format($veh_bt2) . '</td>';
                $tbl .='<td valign="top" width="100" align="right" style="border-top:2px solid #000;">-' . number_format($pur_price2) . '</td>';
                $tbl .='<td valign="top" width="100" align="right" style="border-top:2px solid #000;">-' . number_format($pur_misc2) . '</td>';
                $tbl .='<td valign="top" width="100" align="right" style="border-top:2px solid #000;">-' . number_format($pur_vat2) . '</td>';
                $tbl .='<td valign="top" width="100" align="right" style="border-top:2px solid #000;">-' . number_format($pur_bt2) . '</td>';
                $tbl .='<td valign="top" width="100" align="right" style="border-top:2px solid #000;">-' . number_format($laba2) . '</td>';
                $tbl .='<td valign="top" width="100" align="right" style="border-top:2px solid #000;">-' . number_format($qty2) . ' <b>UNIT</b></td>';
                $tbl .='</tr>';

                $i2 = 0;
                $qty2 = 0;
                $veh_price2 = 0;
                $veh_bbn2 = 0;
                $veh_disc2 = 0;
                $veh_misc2 = 0;
                $veh_at2 = 0;
                $veh_total2 = 0;
                $veh_vat2 = 0;
                $veh_pbm2 = 0;
                $veh_bt2 = 0;
                $pur_price2 = 0;
                $pur_misc2 = 0;
                $pur_vat2 = 0;
                $pur_bt2 = 0;
                $laba2 = 0;
            }
            $tbl.= '<tr><td valign="top" colspan="11" align="left"><b style="font-size:1.1em;">Type : ' . $dtlrow2['veh_code'] . ' : ' . $dtlrow2['veh_name'] . '</b></td></tr>';
            $last_veh_code2 = $dtlrow2['veh_code'];
            $last_veh_name2 = $dtlrow2['veh_name'];
        }



        $qty2 += 1;
        $veh_price2 += $dtlrow2['veh_price'];
        $veh_bbn2 += $dtlrow2['veh_bbn'];
        $veh_disc2 += $dtlrow2['veh_disc'];
        $veh_misc2 += $dtlrow2['veh_misc'];
        $veh_at2 += $dtlrow2['veh_at'];
        $veh_total2 += $dtlrow2['veh_total'];
        $veh_vat2 += $dtlrow2['veh_vat'];
        $veh_pbm2 += $dtlrow2['veh_pbm'];
        $veh_bt2 += $dtlrow2['veh_bt'];
        $pur_price2 += $dtlrow2['pur_price'];
        $pur_misc2 += $dtlrow2['pur_misc'];
        $pur_vat2 += $dtlrow2['pur_vat'];
        $pur_bt2 += $dtlrow2['pur_bt'];
        $laba2 += $dtlrow2['veh_bt'] - $dtlrow2['pur_bt'];

        $qty22 += 1;
        $veh_price22 += $dtlrow2['veh_price'];
        $veh_bbn22 += $dtlrow2['veh_bbn'];
        $veh_disc22 += $dtlrow2['veh_disc'];
        $veh_misc22 += $dtlrow2['veh_misc'];
        $veh_at22 += $dtlrow2['veh_at'];
        $veh_total22 += $dtlrow2['veh_total'];
        $veh_vat22 += $dtlrow2['veh_vat'];
        $veh_pbm22 += $dtlrow2['veh_pbm'];
        $veh_bt22 += $dtlrow2['veh_bt'];
        $pur_price22 += $dtlrow2['pur_price'];
        $pur_misc22 += $dtlrow2['pur_misc'];
        $pur_vat22 += $dtlrow2['pur_vat'];
        $pur_bt22 += $dtlrow2['pur_bt'];
        $laba22 += $dtlrow2['veh_bt'] - $dtlrow2['pur_bt'];

        $kwit_date2 = '';
        if ($dtlrow2['kwit_date'] != '0000-00-00') {
            $kwit_date2 = date_create($dtlrow2['kwit_date']);
            $kwit_date2 = date_format($kwit_date2, "d/m/Y");
        }

        $tbl .='<tr>';
        $tbl .='<td valign="top" width="150">' . $dtlrow2['chassis'] . '<br />' . $dtlrow2['fp_no'] . '</td>';
        $tbl .='<td valign="top" width="150">' . $dtlrow2['kwit_no'] . '<br />' . $kwit_date2 . '</td>';
        $tbl .='<td valign="top" width="100" align="right">-' . number_format($dtlrow2['veh_price']) . '<br />-' . number_format($dtlrow2['veh_bbn']) . '</td>';
        $tbl .='<td valign="top" width="100" align="right">-' . number_format($dtlrow2['veh_disc']) . '<br />-' . number_format($dtlrow2['veh_misc']) . '</td>';
        $tbl .='<td valign="top" width="100" align="right">-' . number_format($dtlrow2['veh_at']) . '<br />-' . number_format($dtlrow2['veh_total']) . '</td>';
        $tbl .='<td valign="top" width="100" align="right">-' . number_format($dtlrow2['veh_vat']) . '<br />-' . number_format($dtlrow2['veh_pbm']) . '</td>';
        $tbl .='<td valign="top" width="100" align="right">-' . number_format($dtlrow2['veh_bt']) . '</td>';
        $tbl .='<td valign="top" width="100" align="right">-' . number_format($dtlrow2['pur_price']) . '</td>';
        $tbl .='<td valign="top" width="100" align="right">-' . number_format($dtlrow2['pur_misc']) . '</td>';
        $tbl .='<td valign="top" width="100" align="right">-' . number_format($dtlrow2['pur_vat']) . '</td>';
        $tbl .='<td valign="top" width="100" align="right">-' . number_format($dtlrow2['pur_bt']) . '</td>';
        $tbl .='<td valign="top" width="100" align="right">-' . number_format($dtlrow2['veh_bt'] - $dtlrow2['pur_bt']) . '</td>';
        $tbl .='<td valign="top" width="100"></td>';
        $tbl .='</tr>';

        $i2++;
        $j2++;

        unset($dtlrow2);
    }


    if ($i2 >= 1) {
        $tbl .='<tr>';
        $tbl .='<td valign="top" colspan="2" valign="top">Total Gross Profit and Loss ' . $last_veh_code2 . ' :</td>';
        $tbl .='<td valign="top" width="100" align="right" style="border-top:2px solid #000;">-' . number_format($veh_price2) . '<br />-' . number_format($veh_bbn2) . '</td>';
        $tbl .='<td valign="top" width="100" align="right" style="border-top:2px solid #000;">-' . number_format($veh_disc2) . '<br />-' . number_format($veh_misc2) . '</td>';
        $tbl .='<td valign="top" width="100" align="right" style="border-top:2px solid #000;">-' . number_format($veh_at2) . '<br />-' . number_format($veh_total2) . '</td>';
        $tbl .='<td valign="top" width="100" align="right" style="border-top:2px solid #000;">-' . number_format($veh_vat2) . '<br />-' . number_format($veh_pbm2) . '</td>';
        $tbl .='<td valign="top" width="100" align="right" style="border-top:2px solid #000;">-' . number_format($veh_bt2) . '</td>';
        $tbl .='<td valign="top" width="100" align="right" style="border-top:2px solid #000;">-' . number_format($pur_price2) . '</td>';
        $tbl .='<td valign="top" width="100" align="right" style="border-top:2px solid #000;">-' . number_format($pur_misc2) . '</td>';
        $tbl .='<td valign="top" width="100" align="right" style="border-top:2px solid #000;">-' . number_format($pur_vat2) . '</td>';
        $tbl .='<td valign="top" width="100" align="right" style="border-top:2px solid #000;">-' . number_format($pur_bt2) . '</td>';
        $tbl .='<td valign="top" width="100" align="right" style="border-top:2px solid #000;">-' . number_format($laba2) . '</td>';
        $tbl .='<td valign="top" width="100" align="right" style="border-top:2px solid #000;">-' . number_format($qty2) . ' <b>UNIT</b></td>';
        $tbl .='</tr>';

        $i2 = 0;
        $qty2 = 0;
        $veh_price2 = 0;
        $veh_bbn2 = 0;
        $veh_disc2 = 0;
        $veh_misc2 = 0;
        $veh_at2 = 0;
        $veh_total2 = 0;
        $veh_vat2 = 0;
        $veh_pbm2 = 0;
        $veh_bt2 = 0;
        $pur_price2 = 0;
        $pur_misc2 = 0;
        $pur_vat2 = 0;
        $pur_bt2 = 0;
        $laba2 = 0;
    }

    if ($j2 >= 1) {
        $tbl .='<tr>';
        $tbl .='<td valign="top" colspan="2" valign="top">Total Gross Profit and Loss from Whrs ' . $last_wrhs_code2 . ' :</td>';
        $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">-' . number_format($veh_price22) . '<br />-' . number_format($veh_bbn22) . '</td>';
        $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">-' . number_format($veh_disc22) . '<br />-' . number_format($veh_misc22) . '</td>';
        $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">-' . number_format($veh_at22) . '<br />-' . number_format($veh_total22) . '</td>';
        $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">-' . number_format($veh_vat22) . '<br />-' . number_format($veh_pbm22) . '</td>';
        $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">-' . number_format($veh_bt22) . '</td>';
        $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">-' . number_format($pur_price22) . '</td>';
        $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">-' . number_format($pur_misc22) . '</td>';
        $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">-' . number_format($pur_vat22) . '</td>';
        $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">-' . number_format($pur_bt22) . '</td>';
        $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">-' . number_format($laba22) . '</td>';
        $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">-' . number_format($qty22) . ' Unit</td>';
        $tbl .='</tr>';

        $j2 = 0;

        $qty22 = 0;
        $veh_price22 = 0;
        $veh_bbn22 = 0;
        $veh_disc22 = 0;
        $veh_misc22 = 0;
        $veh_at22 = 0;
        $veh_total22 = 0;
        $veh_vat22 = 0;
        $veh_pbm22 = 0;
        $veh_bt22 = 0;
        $pur_price22 = 0;
        $pur_misc22 = 0;
        $pur_vat22 = 0;
        $pur_bt22 = 0;
        $laba22 = 0;
    }

    $tbl .='<tr><td valign="top"><br /></td></tr>';
    $tbl .='<tr style="border:2px solid blue;color:blue;">';
    $tbl .='<td valign="top" colspan="2" valign="top"><b>TOTAL RETURN Gross Profit and Loss</b></td>';
    $tbl .='<td valign="top" width="100" align="right">-' . number_format($tveh_price2) . '<br />-' . number_format($tveh_bbn2) . '</td>';
    $tbl .='<td valign="top" width="100" align="right">-' . number_format($tveh_disc2) . '<br />-' . number_format($tveh_misc2) . '</td>';
    $tbl .='<td valign="top" width="100" align="right">-' . number_format($tveh_at2) . '<br />-' . number_format($tveh_total2) . '</td>';
    $tbl .='<td valign="top" width="100" align="right">-' . number_format($tveh_vat2) . '<br />-' . number_format($tveh_pbm2) . '</td>';
    $tbl .='<td valign="top" width="100" align="right">-' . number_format($tveh_bt2) . '</td>';
    $tbl .='<td valign="top" width="100" align="right">-' . number_format($tpur_price2) . '</td>';
    $tbl .='<td valign="top" width="100" align="right">-' . number_format($tpur_misc2) . '</td>';
    $tbl .='<td valign="top" width="100" align="right">-' . number_format($tpur_vat2) . '</td>';
    $tbl .='<td valign="top" width="100" align="right">-' . number_format($tpur_bt2) . '</td>';
    $tbl .='<td valign="top" width="100" align="right">-' . number_format($tlaba2) . '</td>';
    $tbl .='<td valign="top" width="100" align="right">-' . number_format($tqty2) . ' Unit</td>';
    $tbl .='</tr>';
}
$tbl .='<tr><td valign="top"><br /></td></tr>';

$tbl .='<tr style="border:2px solid black;">';
$tbl .='<td class="border-foot" valign="top" colspan="2" valign="top"  align="right"><b>TOTAL Gross Profit and Loss:</b></td>';
$tbl .='<td class="border-foot" valign="top" width="100" align="right"><b>' . number_format($tveh_price - $tveh_price2) . '<br />' . number_format($tveh_bbn - $tveh_bbn2) . '</b></td>';
$tbl .='<td class="border-foot" valign="top" width="100" align="right"><b>' . number_format($tveh_disc - $tveh_disc2) . '<br />' . number_format($tveh_misc - $tveh_misc2) . '</b></td>';
$tbl .='<td class="border-foot" valign="top" width="100" align="right"><b>' . number_format($tveh_at - $tveh_at2) . '<br />' . number_format($tveh_total - $tveh_total2) . '</b></td>';
$tbl .='<td class="border-foot" valign="top" width="100" align="right"><b>' . number_format($tveh_vat - $tveh_vat2) . '<br />' . number_format($tveh_pbm - $tveh_pbm2) . '</b></td>';
$tbl .='<td class="border-foot" valign="top" width="100" align="right"><b>' . number_format($tveh_bt - $tveh_bt2) . '</b></td>';
$tbl .='<td class="border-foot" valign="top" width="100" align="right"><b>' . number_format($tpur_price - $tpur_price2) . '</b></td>';
$tbl .='<td class="border-foot" valign="top" width="100" align="right"><b>' . number_format($tpur_misc - $tpur_misc2) . '</b></td>';
$tbl .='<td class="border-foot" valign="top" width="100" align="right"><b>' . number_format($tpur_vat - $tpur_vat2) . '</b></td>';
$tbl .='<td class="border-foot" valign="top" width="100" align="right"><b>' . number_format($tpur_bt - $tpur_bt2) . '</b></td>';
$tbl .='<td class="border-foot" valign="top" width="100" align="right"><b>' . number_format($tlaba - $tlaba2) . '</b></td>';
$tbl .='<td class="border-foot" valign="top" width="100" align="right"><b>' . number_format($tqty - $tqty2) . ' Unit</b></td>';
$tbl .='</tr>';
$tbl .= '</table>';

