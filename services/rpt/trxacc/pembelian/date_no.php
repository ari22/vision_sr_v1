<?php
$tbl .= '
<div id="cntr1" align="center">
<table width="100%">
<tr><td valign="top" align="center"><b style="font-size:1.5em;">' . $comp_name . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.5em;">' . $rptTitle . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.1em;">By Invoice Date By Invoice No.</b></td></tr>
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

$tbl .= '
        <table width="100%">
        <thead style="border:2px solid black !important;">
            <tr>
                
                <td valign="top" width="100" align="left"><b>Invoice<br />Date</b></td>
                <td valign="top" width="150" align="left"><b>Invoice<br />No.</b></td>
                <td valign="top" width="200" align="left"><b>Supplier<br />Code</b></td>
                <td valign="top" width="150" align="left"><b>Supplier<br />Invoice No.</b></td>
                <td valign="top" width="150" align="left"><b>Supplier<br />Invoice Date</b></td>
                <td valign="top" width="100" align="right"><b>Item</b></td>
                <td valign="top" width="100" align="right"><b>Qty</b></td>
                <td valign="top" width="100" align="right"><b>DPP</b></td>
                <td valign="top" width="100" align="right"><b>PPN</b></td>
                <td valign="top" width="100" align="right"><b>Others</b></td>
                <td valign="top" width="100" align="right"><b>Total Invoice</b></td>
            </tr>
        </thead>';
$tbl .= '<tr><td valign="top"></td></tr>';

$i = 0;
$j = 0;

$tot_item = 0;
$tot_qty = 0;
$inv_bt = 0;
$inv_vat = 0;
$inv_stamp = 0;
$inv_total = 0;

$t_tot_item = 0;
$t_tot_qty = 0;
$t_inv_bt = 0;
$t_inv_vat = 0;
$t_inv_stamp = 0;
$t_inv_total = 0;

$last_supp_code = '';
$last_supp_name = '';

$last_wrhs_code = '';

while ($dtlrow = mysql_fetch_array($dtl)) {
    $t_tot_item += $dtlrow['tot_item'];
    $t_tot_qty += $dtlrow['tot_qty'];
    $t_inv_bt += $dtlrow['inv_bt'];
    $t_inv_vat += $dtlrow['inv_vat'];
    $t_inv_stamp += $dtlrow['inv_stamp'];
    $t_inv_total += $dtlrow['inv_total'];

    if ($last_wrhs_code != $dtlrow['wrhs_code']) {

        if ($i >= 1) {
            $tbl .='<tr>';
            $tbl .='<td valign="top" width="100"></td>';
            $tbl .='<td valign="top" width="150"></td>';
            $tbl .='<td valign="top" width="200"></td>';
            $tbl .='<td valign="top" width="150"></td>';
            $tbl .='<td valign="top" width="150" align="right">TOTAL ' . $last_wrhs_code . ' :</td>';
            $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($tot_item) . '</td>';
            $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($tot_qty) . '</td>';
            $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($inv_bt) . '</td>';
            $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($inv_vat) . '</td>';
            $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($inv_stamp) . '</td>';
            $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($inv_total) . '</td>';
            $tbl .='</tr>';

            $j = 0;
            $tot_item = 0;
            $tot_qty = 0;
            $inv_bt = 0;
            $inv_vat = 0;
            $inv_stamp = 0;
            $inv_total = 0;
        }

        $tbl.= '<tr><td valign="top" colspan="11" align="left"><b style="font-size:1.1em;">WAREHOUSE : ' . $dtlrow['wrhs_code'] . '</b></td></tr>';
        $last_wrhs_code = $dtlrow['wrhs_code'];
    }


    $tot_item += $dtlrow['tot_item'];
    $tot_qty += $dtlrow['tot_qty'];
    $inv_bt += $dtlrow['inv_bt'];
    $inv_vat += $dtlrow['inv_vat'];
    $inv_stamp += $dtlrow['inv_stamp'];
    $inv_total += $dtlrow['inv_total'];

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
    $tbl .='<td valign="top" width="100" align="left">' . $pur_date . '</td>';
    $tbl .='<td valign="top" width="150" align="left">' . $dtlrow['pur_inv_no'] . '</td>';
    $tbl .='<td valign="top" width="200" align="left">' . $dtlrow['supp_code'] . '</td>';
    $tbl .='<td valign="top" width="150" align="left">' . $dtlrow['supp_invno'] . '</td>';
    $tbl .='<td valign="top" width="150" align="left">' . $supp_invdt . '</td>';
    $tbl .='<td valign="top" width="100" align="right">' . number_format($dtlrow['tot_item']) . '</td>';
    $tbl .='<td valign="top" width="100" align="right">' . number_format($dtlrow['tot_qty']) . '</td>';
    $tbl .='<td valign="top" width="100" align="right">' . number_format($dtlrow['inv_bt']) . '</td>';
    $tbl .='<td valign="top" width="100" align="right">' . number_format($dtlrow['inv_vat']) . '</td>';
    $tbl .='<td valign="top" width="100" align="right">' . number_format($dtlrow['inv_stamp']) . '</td>';
    $tbl .='<td valign="top" width="100" align="right">' . number_format($dtlrow['inv_total']) . '</td>';
    $tbl .='</tr>';

    $i++;
    $j++;

    unset($dtlrow);
}

if ($i >= 1) {
    $tbl .='<tr>';
    $tbl .='<td valign="top" width="100"></td>';
    $tbl .='<td valign="top" width="150"></td>';
    $tbl .='<td valign="top" width="200"></td>';
    $tbl .='<td valign="top" width="150"></td>';
    $tbl .='<td valign="top" width="150" align="right">TOTAL ' . $last_wrhs_code . ' :</td>';
    $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($tot_item) . '</td>';
    $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($tot_qty) . '</td>';
    $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($inv_bt) . '</td>';
    $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($inv_vat) . '</td>';
    $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($inv_stamp) . '</td>';
    $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($inv_total) . '</td>';
    $tbl .='</tr>';

    $j = 0;
    $tot_item = 0;
    $tot_qty = 0;
    $inv_bt = 0;
    $inv_vat = 0;
    $inv_stamp = 0;
    $inv_total = 0;
}

$tbl .='<tr><td valign="top" colspan="11"></td></tr>';
$tbl .='<tr><td valign="top" colspan="11"></td></tr>';
$tbl .='<tr><td valign="top" colspan="11"></td></tr>';
$tbl .='<tr>';
$tbl .='<td valign="top" width="100"></td>';
$tbl .='<td valign="top" width="150"></td>';
$tbl .='<td valign="top" width="200"></td>';
$tbl .='<td valign="top" width="150"></td>';
$tbl .='<td class="border-foot" valign="top" width="150" align="right"><b>GRAND TOTAL:</b></td>';
$tbl .='<td class="border-foot" valign="top" width="100" align="right" style="border-top:1px solid #000;"><b>' . number_format($t_tot_item) . '</b></td>';
$tbl .='<td class="border-foot" valign="top" width="100" align="right" style="border-top:1px solid #000;"><b>' . number_format($t_tot_qty) . '</b></td>';
$tbl .='<td class="border-foot" valign="top" width="100" align="right" style="border-top:1px solid #000;"><b>' . number_format($t_inv_bt) . '</b></td>';
$tbl .='<td class="border-foot" valign="top" width="100" align="right" style="border-top:1px solid #000;"><b>' . number_format($t_inv_vat) . '</b></td>';
$tbl .='<td class="border-foot" valign="top" width="100" align="right" style="border-top:1px solid #000;"><b>' . number_format($t_inv_stamp) . '</b></td>';
$tbl .='<td class="border-foot" valign="top" width="100" align="right" style="border-top:1px solid #000;"><b>' . number_format($t_inv_total) . '</b></td>';
$tbl .='</tr>';
$tbl .= '</table>';
