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
//diperbaiki biar klo 1 pelanggan lbh dr 1 kendaraan ga error

$tbl .= '
<div id="cntr1" align="center">
<table width="100%">
<tr><td valign="top" align="center"><b style="font-size:1.5em;">' . $comp_name . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.5em;">' . $title . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.1em;">By Customer</b></td></tr>
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
                <td valign="top" width="150"><b>Tax Invoice No.</b></td>
                <td valign="top" width="110"><b>Receipt Date</b></td>
                <td valign="top" width="150"><b>Receipt No.</b></td>
                <td valign="top" width="140" style="text-align:right; border-left:2px solid #000;"><b>GROSS INCOME (UNIT)</b></td>
                <td valign="top" width="30"></td>
                <td valign="top" width="150" style="border-left:2px solid #000;"><b>Insurance<br />Refund</b></td>
                <td valign="top" width="150" style="border-right:2px solid #000;"><b>Insurance Name</b></td>
                <td valign="top" width="110" style="text-align:right; border-right:2px solid #000;"><b>GROSS INCOME<br />(OPTIONAL)</b></td>
                <td valign="top" width="100" style="text-align:right; border-right:2px solid #000;"><b>BBN PROFIT AND LOSS</b></td>
                <td valign="top" width="100" style="text-align:right"><b>GROSS INCOME<br />(TOTAL)</b></td>
                <td valign="top" width="100" style="text-align:right"><b>QTY</b></td>
            </tr>
        </thead>';

$tbl .= '<tr><td valign="top"></td></tr>';

$i = 0;
$j = 0;

$last_cust_code = '';
$last_cust_name = '';
$last_veh_code = '';
$last_veh_name = '';

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
    
    if ($last_cust_code != $dtlrow['cust_code']) {
        if ($j >= 1) {
            $tbl .='<tr>';
            $tbl .='<td valign="top" colspan="4" align="right">Total Gross Profit and Loss ' . $last_veh_code . '</td>';
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
            $tbl .='<td valign="top" colspan="4"  align="right"><b>Total Gross Profit and Loss  From Customer' . $last_cust_code . ' :</b></td>';
            $tbl .='<td valign="top" width="112"   style="border-top:1px solid #000;" align="right">' . number_format($labaunit) . '</td>';
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
   // }
    //if ($last_veh_code != $dtlrow['veh_code']) {
        $tbl.= '<tr><td valign="top" colspan="11" align="left"><b style="font-size:1.1em;">***CUSTOMER : ' . $dtlrow['cust_code'] . ' : '.$dtlrow['cust_name'].'***</b></td></tr>';
        $last_cust_code = $dtlrow['cust_code'];
        $last_cust_name = $dtlrow['cust_name'];

        $tbl.= '<tr><td valign="top" colspan="11" align="left"><b style="font-size:1.1em;">Type : ' . $dtlrow['veh_code'] . ' : ' . $dtlrow['veh_name'] . '</b></td></tr>';
        $last_veh_code = $dtlrow['veh_code'];
        $last_veh_name = $dtlrow['veh_name'];
    }elseif ($last_veh_code != $dtlrow['veh_code']) {
        if ($j >= 1) {
            $tbl .='<tr>';
            $tbl .='<td valign="top" colspan="4" align="right">Total Gross Profit and Loss ' . $last_veh_code . '</td>';
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
    $tbl .='<td valign="top" colspan="4" align="right">Total Gross Profit and Loss ' . $last_veh_code . '</td>';
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
    $labaunit2 = 0;
    $totprice2 = 0;
}

if ($i >= 1) {
    $tbl .='<tr>';
    $tbl .='<td valign="top" colspan="4"  align="right"><b>Total Gross Profit and Loss from Customer ' . $last_cust_code . ' :</b></td>';
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
    $labaunit = 0;
    $totprice = 0;
}
/*
$tbl .= '<tr><td valign="top"><br /></td></tr>';
$tbl .= '<tr style="border:2px solid blue;">
                <td valign="top" colspan="4" align="right" style="color:blue;"><b>TOTAL GROSS INCOME PENJUALAN :</b></td>
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
                 <td></td>
                <td class="border-foot" style="border-left:2px solid black;border-top:2px solid black;border-bottom:2px solid black;" valign="top" colspan="3" align="right"><b>TOTAL SALES GROSS INCOME :</b></td>
                <td class="border-foot" style="border-right:2px solid black;border-top:2px solid black;border-bottom:2px solid black;" valign="top" width="150"  align="right"><b>' . number_format($tlabaunit) . '</b></td>
                <td class="border-foot" valign="top" width="30"></td>
                <td class="border-foot" valign="top" width="150"></td>
                <td class="border-foot" valign="top" width="150"></td>
                <td class="border-foot" style="border-left:2px solid black;border-top:2px solid black;border-bottom:2px solid black;" valign="top" width="100"  align="right"><b>' . number_format($ttotprice) . '</b></td>
                <td class="border-foot" style="border-top:2px solid black;border-bottom:2px solid black;" valign="top" width="100"  align="right"><b>' . number_format($tlabarugibbn) . '</b></td>
                <td class="border-foot" style="border-top:2px solid black;border-bottom:2px solid black;" valign="top" width="100"  align="right"><b>' . number_format($tlabarugibruto) . '</b></td>
                <td class="border-foot" style="border-right:2px solid black;border-top:2px solid black;border-bottom:2px solid black;" valign="top" width="100"  align="right"><b>' . number_format($tqty) . ' UNIT</b></td>
            </tr>';
$tbl .= '</tfoot>';
$tbl .= '</table>';
