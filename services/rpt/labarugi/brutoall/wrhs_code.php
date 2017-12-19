<?php
////========CHANGE LOG=============
//ganti semua <td jadi <td valign="top"
//betulin judul
//border2
//TAX DATE => RECEIPT DATE
//tax no => tax invoice no
//Total Laba Rugi Bruto Dari Whrs => Total Gross Profit and Loss from Wrhs
//Total Laba Rugi Bruto => Total Gross Profit and Loss
//Tipe => Type
//garis di profit and loss bbn

$tbl .= '
<div id="cntr1" align="center">
<table width="100%">
<tr><td valign="top" align="center"><b style="font-size:1.5em;">' . $comp_name . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.5em;">' . $title . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.1em;">By Warehouse</b></td></tr>
<tr><td valign="top" align="center"><b>DATE : ' . dateView($date1) . ' UP TO ' . dateView($date2) . '</b></td></tr>
</table>
';


$tbl .= '
<table width="100%"  >
<tr>
<td valign="top"></td>
<td valign="top" align="right"><b>Printed On: </b>' . date('d/m/Y') . '</td>
</tr>
</table>';

$tbl .= '<table width="100%">';
$tbl .= '<thead style="border:2px solid black !important;">
            <tr>
                <td valign="top" width="150"><b>Chassis</b></td>
                <td valign="top" width="200"><b>Customer Name</b></td>
                <td valign="top" width="150"><b>Tax Invoice No.</b></td>
                <td valign="top" width="100"><b>Receipt Date</b></td>
                <td valign="top" width="150"><b>Receipt No.</b></td>
                <td valign="top" width="150" style="text-align:right"><b>GROSS INCOME (UNIT)</b></td>
                <td valign="top" width="30"></td>
                <td valign="top" width="150"><b>Refund<br />Insurance</b></td>
                <td valign="top" width="150"><b>Insurance Name</b></td>
                <td valign="top" width="100" style="text-align:right"><b>GROSS INCOME<br />(OPTIONAL)</b></td>
                <td valign="top" width="100" style="text-align:right"><b>PROFIT AND LOSS<br />BBN</b></td>
                <td valign="top" width="100" style="text-align:right"><b>GROSS INCOME<br />(TOTAL)</b></td>
                <td valign="top" width="100" style="text-align:right"><b>QTY</b></td>
            </tr>
        </thead>';

$tbl .= '<tr><td valign="top"></td></tr>';

$i = 0;
$j = 0;

$last_veh_code = '';
$last_veh_name = '';
$last_wrhs_code = '';

$qty = 0;
$labarugibruto = 0;
$labarugibbn = 0;
$labaunit = 0;
$totprice = 0;

$qty2 = 0;
$labarugibruto2 = 0;
$labarugibbn2 = 0;
$labaunit2 = 0;
$totprice2 = 0;


$tqty = 0;
$tlabarugibruto = 0;
$tlabarugibbn = 0;
$tlabaunit = 0;
$ttotprice = 0;

while ($dtlrow = mysql_fetch_array($dtl)) {

    $laba = $dtlrow['veh_bt'] - $dtlrow['pur_bt'];

    $tqty += 1;
    $tlabarugibruto += $laba + $dtlrow['tot_price'] + ($dtlrow['veh_bbn'] - $dtlrow['price_ad']);
    $tlabarugibbn += $dtlrow['veh_bbn'] - $dtlrow['price_ad'];
    $tlabaunit +=$laba;
    $ttotprice +=$dtlrow['tot_price'];


    if ($last_wrhs_code != $dtlrow['wrhs_code']) {

        if ($i >= 1) {
            $tbl .='<tr>';
            $tbl .='<td valign="top" colspan="5"  align="right"><b>Total Gross Profit and Loss  From Wrhs' . $last_wrhs_code . ' :</b></td>';
            $tbl .='<td valign="top" width="112"   style="border-top:1px solid #000;" align="right">' . number_format($labaunit) . '</td>';
            $tbl .='<td valign="top" width="20"></td>';
            $tbl .='<td valign="top" width="115"></td>';
            $tbl .='<td valign="top" width="115"></td>';
            $tbl.='<td valign="top" width="100" align="right" style="border-top:1px solid #000;" align="right">' . number_format($totprice) . '</td>';
            $tbl .='<td valign="top" width="76" align="right" style="border-top:1px solid #000;">' . number_format($labarugibbn2) . '</td>';
            $tbl.='<td valign="top" width="82" align="right" style="border-top:1px solid #000;" align="right">' . number_format($labarugibruto) . '</td>';
            $tbl.='<td valign="top" width="73" style="border-top:1px solid #000;" align="right">' . $qty . ' <b>UNIT</b></td>';
            $tbl .='</tr>';

            $i = 0;
            $qty = 0;
            $labarugibruto = 0;
            $labarugibbn = 0;
            $labaunit = 0;
            $totprice = 0;
        }

        $tbl.= '<tr><td valign="top" colspan="11" align="left"><b style="font-size:1.1em;">***WAREHOUSE : ' . $dtlrow['wrhs_code'] . '***</b></td></tr>';
        $last_wrhs_code = $dtlrow['wrhs_code'];
    }

    if ($last_veh_code != $dtlrow['veh_code']) {
        if ($j >= 1) {
            $tbl .='<tr>';
            $tbl .='<td valign="top" colspan="5" align="right">Total Gross Profit and Loss ' . $last_veh_code . '</td>';
            $tbl .='<td valign="top" width="112"  style="border-top:1px solid #000;" align="right">' . number_format($labaunit2) . '</td>';
            $tbl .='<td valign="top" width="20"></td>';
            $tbl .='<td valign="top" width="115"></td>';
            $tbl .='<td valign="top" width="115"></td>';
            $tbl.='<td valign="top" width="100" align="right" style="border-top:1px solid #000;" align="right">' . number_format($totprice2) . '</td>';
            $tbl .='<td valign="top" width="76" align="right" style="border-top:1px solid #000;">' . number_format($labarugibbn2) . '</td>';
            $tbl.='<td valign="top" width="82" align="right" style="border-top:1px solid #000;" align="right">' . number_format($labarugibruto2) . '</td>';
            $tbl.='<td valign="top" width="73" style="border-top:1px solid #000;" align="right">' . $qty2 . ' <b>Unit</b></td>';
            $tbl .='</tr>';

            $j = 0;
            $qty2 = 0;
            $labarugibruto2 = 0;
            $labarugibbn2 = 0;
            $labaunit2 = 0;
            $totprice2 = 0;
        }
        $tbl.= '<tr><td valign="top" colspan="11" align="left"><b style="font-size:1.1em;">Type : ' . $dtlrow['veh_code'] . ' : ' . $dtlrow['veh_name'] . '</b></td></tr>';
        $last_veh_code = $dtlrow['veh_code'];
        $last_veh_name = $dtlrow['veh_name'];
    }

    $qty += 1;
    $labarugibruto += $laba + $dtlrow['tot_price'] + ($dtlrow['veh_bbn'] - $dtlrow['price_ad']);
    $labarugibbn += $dtlrow['veh_bbn'] - $dtlrow['price_ad'];
    $labaunit +=$laba;
    $totprice +=$dtlrow['tot_price'];

    $qty2 += 1;
    $labarugibruto2 += $laba + $dtlrow['tot_price'] + ($dtlrow['veh_bbn'] - $dtlrow['price_ad']);
    $labarugibbn2 += $dtlrow['veh_bbn'] - $dtlrow['price_ad'];
    $labaunit2 +=$laba;
    $totprice2 +=$dtlrow['tot_price'];

    $kwit_date = dateView($dtlrow['kwit_date']);

    $tbl .='<tr>';
    $tbl .='<td valign="top" width="112">' . $dtlrow['chassis'] . '</td>';
    $tbl .='<td valign="top" width="151">' . $dtlrow['cust_name'] . '</td>';
    $tbl .='<td valign="top" width="112">' . $dtlrow['fp_no'] . '</td>';
    $tbl .='<td valign="top" width="82">' . $kwit_date . '</td>';
    $tbl .='<td valign="top" width="116">' . $dtlrow['kwit_no'] . '</td>';
    $tbl .='<td valign="top" width="112" align="right">' . number_format($dtlrow['veh_bt'] - $dtlrow['pur_bt']) . '</td>';
    $tbl .='<td valign="top" width="20"></td>';
    $tbl .='<td valign="top" width="115"></td>';
    $tbl .='<td valign="top" width="115"></td>';
    $tbl.='<td valign="top" width="100" align="right">' . number_format($dtlrow['tot_price']) . '</td>';
    $tbl .='<td valign="top" width="76" align="right">' . number_format($dtlrow['veh_bbn'] - $dtlrow['price_ad']) . '</td>';
    $tbl.='<td valign="top" width="82" align="right">' . number_format($laba + $dtlrow['tot_price'] + ($dtlrow['veh_bbn'] - $dtlrow['price_ad'])) . '</td>';
    $tbl.='<td valign="top" width="73"></td>';
    $tbl .='</tr>';

    $i++;
    $j++;

    unset($dtlrow);
}

if ($j >= 1) {
    $tbl .='<tr>';
    $tbl .='<td valign="top" colspan="5" align="right">Total Gross Profit and Loss ' . $last_veh_code . '</td>';
    $tbl .='<td valign="top" width="112"  style="border-top:1px solid #000;" align="right">' . number_format($labaunit2) . '</td>';
    $tbl .='<td valign="top" width="20"></td>';
    $tbl .='<td valign="top" width="115"></td>';
    $tbl .='<td valign="top" width="115"></td>';
    $tbl.='<td valign="top" width="100" align="right" style="border-top:1px solid #000;" align="right">' . number_format($totprice2) . '</td>';
    $tbl .='<td valign="top" width="76" align="right" style="border-top:1px solid #000;">' . number_format($labarugibbn2) . '</td>';
    $tbl.='<td valign="top" width="82" align="right" style="border-top:1px solid #000;" align="right">' . number_format($labarugibruto2) . '</td>';
    $tbl.='<td valign="top" width="73" style="border-top:1px solid #000;" align="right">' . $qty2 . ' <b>Unit</b></td>';
    $tbl .='</tr>';

    $j = 0;
    $qty2 = 0;
    $labarugibruto2 = 0;
    $labarugibbn2 = 0;
    $labaunit2 = 0;
    $totprice2 = 0;
}
if ($i >= 1) {
    $tbl .='<tr>';
    $tbl .='<td valign="top" colspan="5"  align="right"><b>Total Gross Profit and Loss from Wrhs ' . $last_wrhs_code . ' :</b></td>';
    $tbl .='<td valign="top" width="112" style="border-top:1px solid #000;" align="right">' . number_format($labaunit) . '</td>';
    $tbl .='<td valign="top" width="20"></td>';
    $tbl .='<td valign="top" width="115"></td>';
    $tbl .='<td valign="top" width="115"></td>';
    $tbl.='<td valign="top" width="100" align="right" style="border-top:1px solid #000;" align="right">' . number_format($totprice) . '</td>';
    $tbl .='<td valign="top" width="76" align="right" style="border-top:1px solid #000;">' . number_format($labarugibbn) . '</td>';
    $tbl.='<td valign="top" width="82" align="right" style="border-top:1px solid #000;" align="right">' . number_format($labarugibruto) . '</td>';
    $tbl.='<td valign="top" width="73" style="border-top:1px solid #000;" align="right">' . $qty . ' <b>UNIT</b></td>';
    $tbl .='</tr>';

    $i = 0;
    $qty = 0;
    $labarugibruto = 0;
    $labarugibbn = 0;
    $labaunit = 0;
    $totprice = 0;
}
/*
$tbl .= '<tr><td valign="top"><br /></td></tr>';
$tbl .= '<tr style="color:blue;">
                <td valign="top" colspan="5" align="right"><b>TOTAL GROSS INCOME PENJUALAN :</b></td>
                <td valign="top" width="150" style="text-align:right">' . number_format($tlabaunit) . '</td>
                <td valign="top" width="30"></td>
                <td valign="top" width="150"></td>
                <td valign="top" width="150"></td>
                <td valign="top" width="100" style="text-align:right">' . number_format($ttotprice) . '</td>
                <td valign="top" width="100" style="text-align:right"></td>
                <td valign="top" width="100" style="text-align:right">' . number_format($tlabarugibruto) . '</td>
                <td valign="top" width="100" style="text-align:right"><b>' . number_format($tqty) . ' UNIT</b></td>
            </tr>';
*/
$tbl .= '<tr><td valign="top"><br /></td></tr>';
$tbl .= '<tfoot>';
$tbl .= '<tr>
                 <td colspan="2"></td>
                <td class="border-foot" style="border-left:2px solid black;border-bottom:2px solid black;border-top:2px solid black;" valign="top" colspan="3" align="right"><b>TOTAL SALES GROSS INCOME :</b></td>
                <td class="border-foot" style="border-right:2px solid black;border-bottom:2px solid black;border-top:2px solid black;" valign="top" width="150" align="right"><b>' . number_format($tlabaunit) . '</b></td>
                <td class="border-foot" valign="top" width="30"></td>
                <td class="border-foot" valign="top" width="150"></td>
                <td class="border-foot" valign="top" width="150"></td>
                <td class="border-foot" style="border-left:2px solid black;border-bottom:2px solid black;border-top:2px solid black;" valign="top" width="100" align="right"><b>' . number_format($ttotprice) . '</b></td>
                <td class="border-foot" style="border-bottom:2px solid black;border-top:2px solid black;" valign="top" width="100"  align="right"><b>' . number_format($tlabarugibbn) . '</b></td>
                <td class="border-foot" style="border-bottom:2px solid black;border-top:2px solid black;" valign="top" width="100"  align="right"><b>' . number_format($tlabarugibruto) . '</b></td>
                <td class="border-foot" style="border-right:2px solid black;border-bottom:2px solid black;border-top:2px solid black;" valign="top" width="100" align="right"><b>' . number_format($tqty) . ' UNIT</b></td>
            </tr>';
$tbl .= '</tfoot>';
$tbl .= '</table>';
