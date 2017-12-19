<?php
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
                <td valign="top" width="100" align="left"><b>Invoice Date</b></td>
                <td valign="top" width="150" align="left"><b>Invoice No.</b></td>
                <td valign="top" width="100" align="right"><b>Item</b></td>
                <td valign="top" width="100" align="right"><b>Qty</b></td>
                <td valign="top" width="100" align="right"><b>DPP</b></td>
                <td valign="top" width="100" align="right"><b>PPN</b></td>
                <td valign="top" width="30"></td>
                <td valign="top" width="150" align="left"><b>Delivery No.</b></td>
                <td valign="top" width="100" align="left"><b>Delivery Date</b></td>
                <td valign="top" width="150" align="left"><b>Purchase<br />Invoice No.</b></td>
                <td valign="top" width="100" align="left"><b>Purchase<br />Invoice Date</b></td>
           </tr>
        </thead>';
$tbl .= '<tr><td valign="top" colspan="6"></td></tr>';

$i = 0;
$j = 0;

$item = 0;
$qty = 0;
$inv_bt = 0;
$inv_vat = 0;

$titem = 0;
$tqty = 0;
$tinv_bt = 0;
$tinv_vat = 0;

$last_wrhs_code = '';

while ($dtlrow = mysql_fetch_array($dtl)) {

    $titem += $dtlrow['tot_item'];
    $tqty += $dtlrow['tot_qty'];
    $tinv_bt += $dtlrow['inv_bt'];
    $tinv_vat += $dtlrow['inv_vat'];

    if ($last_wrhs_code != $dtlrow['wrhs_code']) {
        if ($i >= 1) {
            $tbl .='<tr>';
            $tbl .='<td valign="top" width="100"></td>';
            $tbl .='<td valign="top" width="150"><b>TOTAL ' . $last_wrhs_code . ' :</b></td>';
            $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($item) . '</td>';
            $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($qty) . '</td>';
            $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($inv_bt) . '</td>';
            $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($inv_vat) . '</td>';
            $tbl .='<td valign="top" width="30"></td>';
            $tbl .='<td valign="top" width="150"></td>';
            $tbl .='<td valign="top" width="100"></td>';
            $tbl .='<td valign="top" width="150"></td>';
            $tbl .='<td valign="top" width="100"></td>';
            $tbl .='</tr>';

            $j = 0;
            $item = 0;
            $qty = 0;
            $inv_bt = 0;
            $inv_vat = 0;
        }

        $tbl.= '<tr><td valign="top" colspan="11" align="left"><b style="font-size:1.1em;">WAREHOUSE : ' . $dtlrow['wrhs_code'] . '</b></td></tr>';
        $last_wrhs_code = $dtlrow['wrhs_code'];
    }


    $item += $dtlrow['tot_item'];
    $qty += $dtlrow['tot_qty'];
    $inv_bt += $dtlrow['inv_bt'];
    $inv_vat += $dtlrow['inv_vat'];

    $rpr_date = '';
    if ($dtlrow['rpr_date'] != '0000-00-00') {
        $rpr_date = date_create($dtlrow['rpr_date']);
        $rpr_date = date_format($rpr_date, "d/m/Y");
    }

    $po_date = '';
    if ($dtlrow['po_date'] != '0000-00-00') {
        $po_date = date_create($dtlrow['po_date']);
        $po_date = date_format($po_date, "d/m/Y");
    }

    $pur_date = '';
    if ($dtlrow['pur_date'] != '0000-00-00') {
        $pur_date = date_create($dtlrow['pur_date']);
        $pur_date = date_format($pur_date, "d/m/Y");
    }

    $tbl .='<tr>';
    $tbl .='<td valign="top" width="100" align="left">' . $rpr_date . '</td>';
    $tbl .='<td valign="top" width="150" align="left">' . $dtlrow['rpr_inv_no'] . '</td>';
    $tbl .='<td valign="top" width="100" align="right">' . number_format($dtlrow['tot_item']) . '</td>';
    $tbl .='<td valign="top" width="100" align="right">' . number_format($dtlrow['tot_qty']) . '</td>';
    $tbl .='<td valign="top" width="100" align="right">' . number_format($dtlrow['inv_bt']) . '</td>';
    $tbl .='<td valign="top" width="100" align="right">' . number_format($dtlrow['inv_vat']) . '</td>';
    $tbl .='<td valign="top" width="30"></td>';
    $tbl .='<td valign="top" width="150" align="left">' . $dtlrow['po_no'] . '</td>';
    $tbl .='<td valign="top" width="100" align="left">' . $po_date . '</td>';
    $tbl .='<td valign="top" width="150" align="left">' . $dtlrow['pur_inv_no'] . '</td>';
    $tbl .='<td valign="top" width="100" align="left">' . $pur_date . '</td>';

    $tbl .='</tr>';

    $i++;
    $j++;

    unset($dtlrow);
}

if ($i >= 1) {
    $tbl .='<tr>';
    $tbl .='<td valign="top" width="100"></td>';
    $tbl .='<td valign="top" width="150"><b>TOTAL ' . $last_wrhs_code . ' :</b></td>';
    $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($item) . '</td>';
    $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($qty) . '</td>';
    $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($inv_bt) . '</td>';
    $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($inv_vat) . '</td>';
    $tbl .='<td valign="top" width="30"></td>';
    $tbl .='<td valign="top" width="150"></td>';
    $tbl .='<td valign="top" width="100"></td>';
    $tbl .='<td valign="top" width="150"></td>';
    $tbl .='<td valign="top" width="100"></td>';
    $tbl .='</tr>';

    $j = 0;
    $item = 0;
    $qty = 0;
    $inv_bt = 0;
    $inv_vat = 0;
}

$tbl .='<tr><td valign="top"><br /></td></tr>';
$tbl .='<tfoot>';
$tbl .='<tr>';
$tbl .='<td valign="top"></td>';
$tbl .='<td class="border-foot" valign="top" style="border-left:2px solid black;border-bottom:2px solid black;border-top:2px solid black;" align="right"><b>GRAND TOTAL :</b></td>';
$tbl .='<td class="border-foot" valign="top" style="border-bottom:2px solid black;border-top:2px solid black;" width="100" align="right"><b>' . number_format($titem) . '</b></td>';
$tbl .='<td class="border-foot" valign="top" style="border-bottom:2px solid black;border-top:2px solid black;" width="100" align="right"><b>' . number_format($tqty) . '</b></td>';
$tbl .='<td class="border-foot" valign="top" style="border-bottom:2px solid black;border-top:2px solid black;" width="100" align="right"><b>' . number_format($tinv_bt) . '</b></td>';
$tbl .='<td class="border-foot" valign="top" style="border-right:2px solid black;border-bottom:2px solid black;border-top:2px solid black;" width="100" align="right"><b>' . number_format($tinv_vat) . '</b></td>';
$tbl .='<td valign="top" width="30"></td>';
$tbl .='<td valign="top" width="150"></td>';
$tbl .='<td valign="top" width="100"></td>';
$tbl .='<td valign="top" width="150"></td>';
$tbl .='<td valign="top" width="100"></td>';
$tbl .='</tr>';
$tbl .='</tfoot>';
$tbl .='</table>';
