<?php
$tbl .= '
<div id="cntr1" align="center">
<table width="70%">
<tr><td valign="top" align="center"><b style="font-size:1.5em;">' . $comp_name . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.5em;">' . $rptTitle . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.1em;">By Invoice No. By Invoice Date</b></td></tr>
<tr><td valign="top" align="center"><b>DATE : ' . dateView($date1) . ' UP TO ' . dateView($date2) . '</b></td></tr>
</table>
';

$tbl .= '
<table width="70%"  >
<tr>
<td valign="top"></td>
<td valign="top" align="right"><b>Printed On: </b>' . date('d/m/Y') . '</td>
</tr>
</table>';

$tbl .= '
        <table width="70%">
        <thead style="border:2px solid black !important;">
            <tr>
                <td valign="top" width="30" align="left"><b>No.</b></td>
                <td valign="top" width="120" align="left"><b>Part Code</b></td>
                <td valign="top" width="100" align="left"><b>Part Name</b></td>               
                <td valign="top" width="100" align="left"><b>Invoice Date</b></td>
                <td valign="top" width="120" align="left"><b>Invoice No.</b></td>
                <td valign="top" width="50" align="right"><b>Item</b></td>
            </tr>
        </thead>';

$tbl .= '<tr><td valign="top" colspan="9"></td></tr>';

$i = 0;
$j = 0;

$no = 1;

$item = 0;
$qty = 0;

$item2 = 0;
$qty2 = 0;

$titem = 0;
$tqty = 0;

$last_wrhs_code = '';
$last_part_code = '';
$last_part_name = '';


while ($dtlrow = mysql_fetch_array($dtl)) {
    $titem += $dtlrow['tot_item'];
    $tqty += $dtlrow['tot_qty'];

    if ($last_wrhs_code != $dtlrow['wrhs_code']) {

        if ($i >= 1) {
            $tbl .='<tr>';
            $tbl .= '<td valign="top" width="30"></td>';
            $tbl .='<td valign="top" width="120"></td>';
            $tbl .='<td valign="top" width="100"></td>';
            $tbl .='<td valign="top" width="100"></td>';
            $tbl .='<td valign="top" width="120" align="right"><b>TOTAL WAREHOUSE' . $last_wrhs_code . ' :</b></td>';
            $tbl .='<td valign="top" width="50" align="right" style="border-top:1px solid #000;">' . number_format($item) . '</td>';
            //$tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($qty) . '</td>';
            $tbl .='</tr>';

            $i = 0;
            $item = 0;
            $qty = 0;
        }

        $tbl.= '<tr><td valign="top" colspan="7" align="left"><b style="font-size:1.1em;">WAREHOUSE : ' . $dtlrow['wrhs_code'] . '</b></td></tr>';
        $last_wrhs_code = $dtlrow['wrhs_code'];
    }

    if ($last_part_name != $dtlrow['part_name']) {

        if ($j >= 1) {
            $tbl .='<tr>';

            $tbl .= '<td valign="top" width="30"></td>';
            $tbl .='<td valign="top" width="120"></td>';
            $tbl .='<td valign="top" width="100"></td>';
            $tbl .='<td valign="top" width="100"></td>';
            $tbl .='<td valign="top" width="120" align="right"><b>TOTAL PART CODE' . $last_part_code . ' :</b></td>';
            $tbl .='<td valign="top" width="50" align="right" style="border-top:1px solid #000;">' . number_format($item2) . '</td>';
            //$tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($qty2) . '</td>';
            $tbl .='</tr>';

            $j = 0;
            $item2 = 0;
            $qty2 = 0;
        }

        $last_part_name = $dtlrow['part_name'];
        $last_part_code = $dtlrow['part_code'];
    }



    $item += $dtlrow['tot_item'];
    $qty += $dtlrow['tot_qty'];

    $item2 += $dtlrow['tot_item'];
    $qty2 += $dtlrow['tot_qty'];

    $rcv_date = '';
    if ($dtlrow['rcv_date'] != '0000-00-00') {
        $rcv_date = date_create($dtlrow['rcv_date']);
        $rcv_date = date_format($rcv_date, "d/m/Y");
    }


    $tbl .='<tr>';
    $tbl .= '<td valign="top" width="30" align="left">' . $no++ . '.</td>';
    $tbl .='<td valign="top" width="120" align="left">' . $dtlrow['part_code'] . '</td>';
    $tbl .='<td valign="top" width="100" align="left">' . $dtlrow['part_name'] . '</td>';
    $tbl .='<td valign="top" width="100" align="left">' . $rcv_date . '</td>';
    $tbl .='<td valign="top" width="120" align="left">' . $dtlrow['pur_inv_no'] . '</td>';
    $tbl .='<td valign="top" width="50" align="right">' . number_format($dtlrow['tot_item']) . '</td>';
    //$tbl .='<td valign="top" width="100" align="right">' . number_format($dtlrow['tot_qty']) . '</td>';
    $tbl .='</tr>';


    $i++;
    $j++;

    unset($dtlrow);
}


if ($i >= 1) {
    $tbl .='<tr>';

    $tbl .= '<td valign="top" width="30"></td>';
    $tbl .='<td valign="top" width="120"></td>';
    $tbl .='<td valign="top" width="100"></td>';
    $tbl .='<td valign="top" width="100"></td>';
    $tbl .='<td valign="top" width="120" align="right"><b>TOTAL WAREHOUSE' . $last_wrhs_code . ' :</b></td>';
    $tbl .='<td valign="top" width="50" align="right" style="border-top:1px solid #000;">' . number_format($item) . '</td>';
    //$tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($qty) . '</td>';
    $tbl .='</tr>';

    $i = 0;
    $item = 0;
    $qty = 0;
}


if ($j >= 1) {
    $tbl .='<tr>';

    $tbl .= '<td valign="top" width="30"></td>';
    $tbl .='<td valign="top" width="120"></td>';
    $tbl .='<td valign="top" width="100"></td>';
    $tbl .='<td valign="top" width="100"></td>';
    $tbl .='<td valign="top" width="120" align="right"><b>TOTAL PART CODE' . $last_part_code . ' :</b></td>';
    $tbl .='<td valign="top" width="50" align="right" style="border-top:1px solid #000;">' . number_format($item2) . '</td>';
    //$tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($qty2) . '</td>';
    $tbl .='</tr>';

    $j = 0;
    $item2 = 0;
    $qty2 = 0;
}


$tbl .='<tr>';

$tbl .= '<td valign="top" width="30"></td>';
$tbl .='<td valign="top" width="120"></td>';
$tbl .='<td valign="top" width="100"></td>';
$tbl .='<td valign="top" width="100"></td>';
$tbl .='<td class="border-foot" valign="top" width="120" align="right"><b>GRAND TOTAL :</b></td>';
$tbl .='<td class="border-foot" valign="top" width="50" align="right" style="border-top:1px solid #000;">' . number_format($titem) . '</td>';
//$tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;">' . number_format($tqty) . '</td>';
$tbl .='</tr>';

$tbl .= '</table>';
