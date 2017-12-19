<?php
//========CHANGE LOG=============
//ganti semua <td jadi <td valign="top"
//align di grand total
$tbl .= '
<div id="cntr1" align="center">
<table width="80%">
<tr><td valign="top" align="center"><b style="font-size:1.5em;">' . $comp_name . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.5em;">' . $rptTitle . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.1em;">By Invoice No. By Invoice Date</b></td></tr>
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
        <table width="80%" >
        <thead style="border:2px solid black !important;">
           <tr>
                <td valign="top" width="150" align="left"><b>Invoice No.</b></td>
                <td valign="top" width="100" align="left"><b>Invoice Date</b></td>
                <td valign="top" width="100" align="right"><b>Item</b></td>
                <td valign="top" width="100" align="right"><b>Qty</b></td>
                <td valign="top" width="100" align="right"><b>DPP</b></td>
                <td valign="top" width="100" align="right"><b>PPN</b></td>
                <td valign="top" width="30"></td>
                <td valign="top" width="150" align="left"><b>Delivery No.</b></td>
                <td valign="top" width="100" align="left"><b>Delivery Date</b></td>
                <td valign="top" width="150" align="left"><b>Sale<br />Invoice No.</b></td>
                <td valign="top" width="100" align="left"><b>Sale<br />Invoice Date</b></td>
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
            $tbl .='<td valign="top" width="150"></td>';
            $tbl .='<td valign="top" width="100"><b>TOTAL ' . $last_wrhs_code . ' :</b></td>';
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

    $rsl_date = '';
    if ($dtlrow['rsl_date'] != '0000-00-00') {
        $rsl_date = date_create($dtlrow['rsl_date']);
        $rsl_date = date_format($rsl_date, "d/m/Y");
    }

    $so_date = '';
    if ($dtlrow['so_date'] != '0000-00-00') {
        $so_date = date_create($dtlrow['so_date']);
        $so_date = date_format($so_date, "d/m/Y");
    }

    $sal_date = '';
    if ($dtlrow['sal_date'] != '0000-00-00') {
        $sal_date = date_create($dtlrow['sal_date']);
        $sal_date = date_format($sal_date, "d/m/Y");
    }

    $tbl .='<tr>';
    $tbl .='<td valign="top" width="150" align="left">' . $dtlrow['rsl_inv_no'] . '</td>';
    $tbl .='<td valign="top" width="100" align="left">' . $rsl_date . '</td>';
    $tbl .='<td valign="top" width="100" align="right">' . number_format($dtlrow['tot_item']) . '</td>';
    $tbl .='<td valign="top" width="100" align="right">' . number_format($dtlrow['tot_qty']) . '</td>';
    $tbl .='<td valign="top" width="100" align="right">' . number_format($dtlrow['inv_bt']) . '</td>';
    $tbl .='<td valign="top" width="100" align="right">' . number_format($dtlrow['inv_vat']) . '</td>';
    $tbl .='<td valign="top" width="30"></td>';
    $tbl .='<td valign="top" width="150" align="left">' . $dtlrow['so_no'] . '</td>';
    $tbl .='<td valign="top" width="100" align="left">' . $so_date . '</td>';
    $tbl .='<td valign="top" width="150" align="left">' . $dtlrow['sal_inv_no'] . '</td>';
    $tbl .='<td valign="top" width="100" align="left">' . $sal_date . '</td>';

    $tbl .='</tr>';

    $i++;
    $j++;

    unset($dtlrow);
}

if ($i >= 1) {
    $tbl .='<tr>';
    $tbl .='<td valign="top" width="150"></td>';
    $tbl .='<td valign="top" width="100"><b>TOTAL ' . $last_wrhs_code . ' :</b></td>';
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
$tbl .='<td></td>';
$tbl .='<td class="border-foot" style="border-left:2px solid black;border-bottom:2px solid black;border-top:2px solid black;" valign="top" align="right"><b>GRAND TOTAL :</b></td>';
$tbl .='<td class="border-foot" style="border-bottom:2px solid black;border-top:2px solid black;" valign="top" width="100" align="right"><b>' . number_format($titem) . '</b></td>';
$tbl .='<td class="border-foot" style="border-bottom:2px solid black;border-top:2px solid black;" valign="top" width="100" align="right"><b>' . number_format($tqty) . '</b></td>';
$tbl .='<td class="border-foot" style="border-bottom:2px solid black;border-top:2px solid black;" valign="top" width="100" align="right"><b>' . number_format($tinv_bt) . '</b></td>';
$tbl .='<td class="border-foot" style="border-bottom:2px solid black;border-top:2px solid black;" valign="top" width="100" align="right"><b>' . number_format($tinv_vat) . '</b></td>';
$tbl .='<td class="border-foot" style="border-right:2px solid black;border-bottom:2px solid black;border-top:2px solid black;" valign="top" width="30"></td>';
$tbl .='<td class="border-foot" valign="top" width="150"></td>';
$tbl .='<td class="border-foot" valign="top" width="100"></td>';
$tbl .='<td class="border-foot" valign="top" width="150"></td>';
$tbl .='<td class="border-foot" valign="top" width="100"></td>';
$tbl .='</tr>';
$tbl .='</tfoot>';

$tbl .='</table>';
