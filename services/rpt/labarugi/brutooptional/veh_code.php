<?php
//========CHANGE LOG=============
//ganti semua <td jadi <td valign="top"
//total invoice purchase => Total<br />Sales Invoice
//discount invoice purchase => Discount<br />in Invoice
//total price sale => Total<br />Sales Price
//Discount<br />Purchase Price => Total<br />Purchase Price
//kolom etc di pembelian diisi dengan pur_misc
//diperbaiki biar klo 1 tipe kendaraan lbh dr 1 warehouse ga error

$tbl .= '
<div id="cntr1" align="center">
<table width="100%">
<tr><td valign="top" align="center"><b style="font-size:1.5em;">' . $comp_name . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.5em;">' . $title . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.1em;">By Vehicle Type</b></td></tr>
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
                <td valign="top" width="190"><b>Chassis</b></td>
                <td valign="top" width="190" style="border-right:2px solid #000;"><b>Customer Name</b></td>
                <td valign="top" width="100" align="right"><b>Total Sales Invoice</b></td>
                <td valign="top" width="100" align="right"><b>Discount<br />in Invoice</b></td>
                <td valign="top" width="100" align="right"><b>DPP</b></td>
                <td valign="top" width="100" align="right"><b>Etc.</b></td>
                <td valign="top" width="100" align="right"><b>Total<br />Sales Price</b></td>
                <td valign="top" width="110" align="right"  style="border-left:2px solid #000;"><b>Total Purchase Invoice</b></td>
                <td valign="top" width="100" align="right"><b>Discount<br />in Invoice</b></td>
                <td valign="top" width="100" align="right"><b>DPP</b></td>
                <td valign="top" width="100" align="right"><b>Etc.</b></td>
                <td valign="top" width="110" align="right"><b>Total<br />Purchase Price</b></td>
                <td valign="top" width="100" align="right" style="border-left:2px solid #000;"><b>GROSS INCOME</b></td>
            </tr>
        </thead>';

$tbl .= '<tr><td valign="top"></td></tr>';


$i = 0;
$j = 0;

$last_veh_code = '';
$last_veh_name = '';
$last_wrhs_code = '';

$srv_price = 0;
$srv_disc = 0;
$srv_bt = 0;
$inv_stamp = 0;
$srv_at = 0;
$price_bd = 0;
$disc_val = 0;
$price_ad = 0;
$labarugi = 0;
$pur_misc = 0;
$dpp=0;

            $srv_price1 = 0;
            $srv_disc1 = 0;
            $srv_bt1 = 0;
            $inv_stamp1 = 0;
            $srv_at1 = 0;
            $price_bd1 = 0;
            $disc_val1 = 0;
            $price_ad1 = 0;
            $labarugi1 = 0;
            $pur_misc1 = 0;
            $dpp1 =0;

$tsrv_price = 0;
$tsrv_disc = 0;
$tsrv_bt = 0;
$tinv_stamp = 0;
$tsrv_at = 0;
$tprice_bd = 0;
$tdisc_val = 0;
$tprice_ad = 0;
$tlabarugi = 0;
$tpur_misc = 0;
$tdpp = 0;


while ($dtlrow = mysql_fetch_array($dtl)) {

    $tsrv_price += $dtlrow['srv_price'];
    $tsrv_disc += $dtlrow['srv_disc'];
    $tsrv_bt += $dtlrow['srv_bt'];
    $tinv_stamp += $dtlrow['inv_stamp'];
    $tsrv_at += $dtlrow['srv_at'];
    $tprice_bd += $dtlrow['price_bd'];
    $tdisc_val += $dtlrow['disc_val'];
    $tprice_ad += $dtlrow['price_ad'];
    $tpur_misc += $dtlrow['pur_misc'];

    $tdpp +=$dtlrow['price_bd'] - $dtlrow['disc_val'];
    $tlabarugi +=   $dtlrow['srv_at'] - $dtlrow['price_ad'];


    if ($last_veh_code != $dtlrow['veh_code']) {
        if ($j >= 1) {
            $tbl .='<tr>';
            $tbl .='<td valign="top" colspan="2" align="right">Total Gross Income From Wrhs ' . $last_wrhs_code . '</td>';
            $tbl.='<td valign="top" width="100" align="right" style="border-top:1px solid #000;" align="right">' . number_format($srv_price1) . '</td>';
            $tbl .= '<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($srv_disc1) . '</td>';
            $tbl .= '<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($srv_bt1) . '</td>';
            $tbl .= '<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($inv_stamp1) . '</td>';
            $tbl .= '<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($srv_at1) . '</td>';
            $tbl .= '<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($price_bd1) . '</td>';
            $tbl .= '<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($disc_val1) . '</td>';
            $tbl .= '<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($dpp1) . '</td>';
            $tbl .= '<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($pur_misc1) . '</td>';
            $tbl .= '<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($price_ad1) . '</td>';
            $tbl .= '<td valign="top" width="100" align="right" style="border-top:1px solid #000;">'.number_format($labarugi1).'</td>';
            $tbl .='</tr>';

            $j = 0;
            $srv_price1 = 0;
            $srv_disc1 = 0;
            $srv_bt1 = 0;
            $inv_stamp1 = 0;
            $srv_at1 = 0;
            $price_bd1 = 0;
            $disc_val1 = 0;
            $price_ad1 = 0;
            $labarugi1 = 0;
            $pur_misc1 = 0;
            $dpp1 =0;
        }

        if ($i >= 1) {
            $tbl .='<tr>';
            $tbl .='<td valign="top" colspan="2" align="right"><b>Total Gross Income ' . $last_veh_code . ' :</b></td>';
            $tbl.='<td valign="top" width="100" align="right" style="border-top:1px solid #000;" align="right">' . number_format($srv_price) . '</td>';
            $tbl .= '<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($srv_disc) . '</td>';
            $tbl .= '<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($srv_bt) . '</td>';
            $tbl .= '<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($inv_stamp) . '</td>';
            $tbl .= '<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($srv_at) . '</td>';
            $tbl .= '<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($price_bd) . '</td>';
            $tbl .= '<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($disc_val) . '</td>';
            $tbl .= '<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($dpp) . '</td>';
            $tbl .= '<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($pur_misc) . '</td>';
            $tbl .= '<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($price_ad) . '</td>';
            $tbl .= '<td valign="top" width="100" align="right" style="border-top:1px solid #000;">'.number_format($labarugi).'</td>';
            $tbl .='</tr>';

            $i = 0;
            $srv_price = 0;
            $srv_disc = 0;
            $srv_bt = 0;
            $inv_stamp = 0;
            $srv_at = 0;
            $price_bd = 0;
            $disc_val = 0;
            $price_ad = 0;
            $labarugi = 0;
            $pur_misc = 0;
            $dpp =0;
        }

        $tbl.= '<tr><td valign="top" colspan="13" align="left"><b style="font-size:1.1em;">*** Tipe : ' . $dtlrow['veh_code'] . ' : ' . $dtlrow['veh_name'] . ' ***</b></td></tr>';
        $last_veh_code = $dtlrow['veh_code'];
        $last_veh_name = $dtlrow['veh_name'];

        $tbl.= '<tr><td valign="top" colspan="13" align="left"><b style="font-size:1.1em;">WAREHOUSE : ' . $dtlrow['wrhs_code'] . '</b></td></tr>';
        $last_wrhs_code = $dtlrow['wrhs_code'];
    }elseif ($last_wrhs_code != $dtlrow['wrhs_code']) {
        if ($j >= 1) {
            $tbl .='<tr>';
            $tbl .='<td valign="top" colspan="2" align="right">Total Gross Income From Wrhs ' . $last_wrhs_code . '</td>';
            $tbl.='<td valign="top" width="100" align="right" style="border-top:1px solid #000;" align="right">' . number_format($srv_price1) . '</td>';
            $tbl .= '<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($srv_disc1) . '</td>';
            $tbl .= '<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($srv_bt1) . '</td>';
            $tbl .= '<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($inv_stamp1) . '</td>';
            $tbl .= '<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($srv_at1) . '</td>';
            $tbl .= '<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($price_bd1) . '</td>';
            $tbl .= '<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($disc_val1) . '</td>';
            $tbl .= '<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($dpp1) . '</td>';
            $tbl .= '<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($pur_misc1) . '</td>';
            $tbl .= '<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($price_ad1) . '</td>';
            $tbl .= '<td valign="top" width="100" align="right" style="border-top:1px solid #000;">'.number_format($labarugi1).'</td>';
            $tbl .='</tr>';

            $j = 0;
            $srv_price1 = 0;
            $srv_disc1 = 0;
            $srv_bt1 = 0;
            $inv_stamp1 = 0;
            $srv_at1 = 0;
            $price_bd1 = 0;
            $disc_val1 = 0;
            $price_ad1 = 0;
            $labarugi1 = 0;
            $pur_misc1 = 0;
            $dpp1 =0;
        }
        $tbl.= '<tr><td valign="top" colspan="13" align="left"><b style="font-size:1.1em;">WAREHOUSE : ' . $dtlrow['wrhs_code'] . '</b></td></tr>';
        $last_wrhs_code = $dtlrow['wrhs_code'];
    }

    $srv_price += $dtlrow['srv_price'];
    $srv_disc += $dtlrow['srv_disc'];
    $srv_bt += $dtlrow['srv_bt'];
    $inv_stamp += $dtlrow['inv_stamp'];
    $srv_at += $dtlrow['srv_at'];
    $price_bd += $dtlrow['price_bd'];
    $disc_val += $dtlrow['disc_val'];
    $price_ad += $dtlrow['price_ad'];
    $pur_misc += $dtlrow['pur_misc'];
    $dpp += $dtlrow['price_bd'] - $dtlrow['disc_val'];

    $srv_price1 += $dtlrow['srv_price'];
    $srv_disc1 += $dtlrow['srv_disc'];
    $srv_bt1 += $dtlrow['srv_bt'];
    $inv_stamp1 += $dtlrow['inv_stamp'];
    $srv_at1 += $dtlrow['srv_at'];
    $price_bd1 += $dtlrow['price_bd'];
    $disc_val1 += $dtlrow['disc_val'];
    $price_ad1 += $dtlrow['price_ad'];
    $pur_misc1 += $dtlrow['pur_misc'];

    $labarugi +=  $dtlrow['srv_at'] - $dtlrow['price_ad'];


    $tbl .= '<tr>';
    $tbl .= '<td valign="top" width="171">' . $dtlrow['chassis'] . '</td>';
    $tbl .= '<td valign="top" width="200">' . $dtlrow['cust_name'] . '</td>';
    $tbl .= '<td valign="top" width="95" align="right">' . number_format($dtlrow['srv_price']) . '</td>';
    $tbl .= '<td valign="top" width="100" align="right">' . number_format($dtlrow['srv_disc']) . '</td>';
    $tbl .= '<td valign="top" width="100" align="right">' . number_format($dtlrow['srv_bt']) . '</td>';
    $tbl .= '<td valign="top" width="100" align="right">' . number_format($dtlrow['inv_stamp']) . '</td>';
    $tbl .= '<td valign="top" width="100" align="right">' . number_format($dtlrow['srv_at']) . '</td>';
    $tbl .= '<td valign="top" width="100" align="right">' . number_format($dtlrow['price_bd']) . '</td>';
    $tbl .= '<td valign="top" width="100" align="right">' . number_format($dtlrow['disc_val']) . '</td>';
    $tbl .= '<td valign="top" width="100" align="right">' . number_format($dtlrow['price_bd'] - $dtlrow['disc_val']).'</td>';
    $tbl .= '<td valign="top" width="100" align="right">' . number_format($dtlrow['pur_misc']) . '</td>';
    $tbl .= '<td valign="top" width="100" align="right">' . number_format($dtlrow['price_ad']) . '</td>';
    $tbl .= '<td valign="top" width="100" align="right">'.number_format($dtlrow['srv_at'] - $dtlrow['price_ad']).'</td>';
    $tbl .= '</tr>';

    $i++;
    $j++;

    unset($dtlrow);
}

if ($j >= 1) {
    $tbl .='<tr>';
    $tbl .='<td valign="top" colspan="2" align="right">Total Gross Income From Wrhs ' . $last_wrhs_code . '</td>';
    $tbl.='<td valign="top" width="100" align="right" style="border-top:1px solid #000;" align="right">' . number_format($srv_price) . '</td>';
    $tbl .= '<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($srv_disc) . '</td>';
    $tbl .= '<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($srv_bt) . '</td>';
    $tbl .= '<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($inv_stamp) . '</td>';
    $tbl .= '<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($srv_at) . '</td>';
    $tbl .= '<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($price_bd) . '</td>';
    $tbl .= '<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($disc_val) . '</td>';
    $tbl .= '<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($dpp) . '</td>';
    $tbl .= '<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($pur_misc) . '</td>';
    $tbl .= '<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($price_ad) . '</td>';
    $tbl .= '<td valign="top" width="100" align="right" style="border-top:1px solid #000;">'.number_format($labarugi).'</td>';
    $tbl .='</tr>';

    $j = 0;
}

if ($i >= 1) {
    $tbl .='<tr>';
    $tbl .='<td valign="top" colspan="2" align="right"><b>Total Gross Income ' . $last_veh_code . ' :</b></td>';
    $tbl.='<td valign="top" width="100" align="right" style="border-top:1px solid #000;" align="right">' . number_format($srv_price) . '</td>';
    $tbl .= '<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($srv_disc) . '</td>';
    $tbl .= '<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($srv_bt) . '</td>';
    $tbl .= '<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($inv_stamp) . '</td>';
    $tbl .= '<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($srv_at) . '</td>';
    $tbl .= '<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($price_bd) . '</td>';
    $tbl .= '<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($disc_val) . '</td>';
    $tbl .= '<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($dpp) . '</td>';
    $tbl .= '<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($pur_misc) . '</td>';
    $tbl .= '<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($price_ad) . '</td>';
    $tbl .= '<td valign="top" width="100" align="right" style="border-top:1px solid #000;">'.number_format($labarugi).'</td>';
    $tbl .='</tr>';

    $i = 0;
    $srv_price = 0;
    $srv_disc = 0;
    $srv_bt = 0;
    $inv_stamp = 0;
    $srv_at = 0;
    $price_bd = 0;
    $disc_val = 0;
    $price_ad = 0;
}
$tbl .= '<tr><td valign="top"><br /></td></tr>';

$tbl .='<tr  style="border:2px solid blue;">';
$tbl .='<td valign="top" colspan="2" align="right" style="color:blue;"><b>TOTAL SALE GROSS INCOME :</b></td>';
    $tbl .= '<td valign="top" width="95" align="right">' . number_format($tsrv_price) . '</td>';
    $tbl .= '<td valign="top" width="100" align="right">' . number_format($tsrv_disc) . '</td>';
    $tbl .= '<td valign="top" width="100" align="right">' . number_format($tsrv_bt) . '</td>';
    $tbl .= '<td valign="top" width="100" align="right">' . number_format($tinv_stamp) . '</td>';
    $tbl .= '<td valign="top" width="100" align="right">' . number_format($tsrv_at) . '</td>';
    $tbl .= '<td valign="top" width="100" align="right">' . number_format($tprice_bd) . '</td>';
    $tbl .= '<td valign="top" width="100" align="right">' . number_format($tdisc_val) . '</td>';
    $tbl .= '<td valign="top" width="100" align="right">' . number_format($tdpp) . '</td>';
    $tbl .= '<td valign="top" width="100" align="right">' . number_format($tpur_misc) . '</td>';
    $tbl .= '<td valign="top" width="100" align="right">' . number_format($tprice_ad) . '</td>';
    $tbl .= '<td valign="top" width="100" align="right">'.number_format($tlabarugi).'</td>';
$tbl .='</tr>';
$tbl .= '<tr><td valign="top"><br /></td></tr>';

$tbl .='<tr style="border:2px solid #000;" >';
$tbl .='<td class="border-foot" valign="top" colspan="2" align="right"><b>TOTAL GROSS INCOME :</b></td>';
    $tbl .= '<td class="border-foot" valign="top" width="95" align="right"><b>' . number_format($tsrv_price) . '</b></td>';
    $tbl .= '<td class="border-foot" valign="top" width="100" align="right"><b>' . number_format($tsrv_disc) . '</b></td>';
    $tbl .= '<td class="border-foot" valign="top" width="100" align="right"><b>' . number_format($tsrv_bt) . '</b></td>';
    $tbl .= '<td class="border-foot" valign="top" width="100" align="right"><b>' . number_format($tinv_stamp) . '</b></td>';
    $tbl .= '<td class="border-foot" valign="top" width="100" align="right"><b>' . number_format($tsrv_at) . '</b></td>';
    $tbl .= '<td class="border-foot" valign="top" width="100" align="right"><b>' . number_format($tprice_bd) . '</b></td>';
    $tbl .= '<td class="border-foot" valign="top" width="100" align="right"><b>' . number_format($tdisc_val) . '</b></td>';
    $tbl .= '<td class="border-foot" valign="top" width="100" align="right"><b>' . number_format($tdpp) . '</b></td>';
    $tbl .= '<td class="border-foot" valign="top" width="100" align="right"><b>' . number_format($tpur_misc) . '</b></td>';
    $tbl .= '<td class="border-foot" valign="top" width="100" align="right"><b>' . number_format($tprice_ad) . '</b></td>';
    $tbl .= '<td class="border-foot" valign="top" width="100" align="right"><b>'.number_format($tlabarugi).'</b></td>';
$tbl .='</tr>';
$tbl .='</table>';
