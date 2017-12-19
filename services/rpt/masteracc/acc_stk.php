<?php
$tbl .= '
<div id="cntr1" align="center">
<table width="100%">
<tr><td valign="top" align="center"><b style="font-size:1.1em;">' . $comp_name . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.1em;">' . strtoupper($title) . ' REPORT</b></td></tr>
</table>
';

$tbl .= '
<table width="100%"  >
<tr>
<td valign="top" align="right" colspan="3"><b>Printed On: </b>' . date('d/m/Y') . '</td>
</tr>
</table>';

$tbl .= '
<table width="100%">
 <thead style="border:2px solid black !important;">';
$tbl .= '<td valign="top" width="30" align="left"><b>No.</b></td>';
$tbl .= '<td valign="top" width="100" align="left"><b>Part Code</b></td>';
$tbl .= '<td valign="top" width="150" align="left"><b>Part Name</td>';
$tbl .= '<td valign="top" width="70" align="left"><b>Unit</b></td>';
$tbl .= '<td valign="top" width="100" align="left"><b>Location</b></td>';
$tbl .= '<td valign="top" width="150" align="right"><b>Rest<br />Stock</b></td>';
$tbl .= '<td valign="top" width="150" align="right"><b>Qty<br />Pick</b></td>';
$tbl .= '<td valign="top" width="150" align="right"><b>Min<br />Qty</b></td>';
$tbl .= '<td valign="top"  width="150" align="right"><b>Max<br />Qty</b></td>';
$tbl .= '<td valign="top"  width="150" align="right"><b>Qty<br />Order</b></td>';
$tbl .= '<td valign="top"  width="150" align="right"><b>Qty<br />B.O</b></td>';
$tbl .= '<td valign="top"  width="150" align="right"><b>Purchase<br />Price</b></td>';
$tbl .= '<td valign="top"  width="150" align="right"><b>HPP<br />Average</b></td>';
$tbl .= '<td valign="top"  width="150" align="right"><b>Sale<br />Price</b></td>';
$tbl .= '<td valign="top"  width="150" align="right"><b>Tot HPP<br />average</b></td>';
$tbl .= '<td valign="top"  width="150" align="right"><b>Tot Sale<br />Price</b></td>';
$tbl .= '</tr>
</thead>';
$tbl .='<tr><td valign="top"></td></tr>';
$no = 1;
$i = 0;
$j = 0;
$last_wrhs_code = '';
$qty = 0;
$qty_pick = 0;
$qty_order = 0;
$qty_bo = 0;
$ttot_hpp = 0;
$ttot_sal = 0;


$sumqty = 0;
$sumqty_pick = 0;
$sumqty_order = 0;
$sumqty_bo = 0;
$sumttot_hpp = 0;
$sumttot_sal = 0;


while ($dtlrow = mysql_fetch_array($dtl)) {
    $tot_hpp = $dtlrow['aver_price'] * $dtlrow['qty'];
    $tot_sal = $dtlrow['sal_price'] * $dtlrow['qty'];


    $sumqty += $dtlrow['qty'];
    $sumqty_pick += $dtlrow['qty_pick'];
    $sumqty_order += $dtlrow['qty_order'];
    $sumqty_bo += $dtlrow['qty_border'];
    $sumttot_hpp += $tot_hpp;
    $sumttot_sal += $tot_sal;



    if ($last_wrhs_code != $dtlrow['wrhs_code']) {
        if ($i >= 1) {
            $tbl.= '<tr>'
                    . '<td valign="top"  colspan="5" align="right"><b>Total: ' . $last_wrhs_code . '</b></td>'
                    . '<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($qty) . '</td>'
                    . '<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($qty_pick) . '</td>'
                    . '<td valign="top"></td>'
                    . '<td valign="top"></td>'
                    . '<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($qty_order) . '</td>'
                    . '<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($qty_bo) . '</td>'
                    . '<td valign="top"></td>'
                    . '<td valign="top"></td>'
                    . '<td valign="top"></td>'
                    . '<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($ttot_hpp) . '</td>'
                    . '<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($ttot_sal) . '</td>'
                    . '</tr>';

            $tbl .= '<tr><td valign="top" colspan="16"></td></tr>';
            $tbl .= '<tr><td valign="top" colspan="16"></td></tr>';
            $j = 0;
            $qty = 0;
            $qty_pick = 0;
            $qty_order = 0;
            $qty_bo = 0;
            $ttot_hpp = 0;
            $ttot_sal = 0;
        }
        $tbl.= '<tr><td valign="top" colspan="16" align="left"><b style="font-size:1.1em;">' . $dtlrow['wrhs_code'] . '</b></td></tr>';
        $last_wrhs_code = $dtlrow['wrhs_code'];
    }

    $qty += $dtlrow['qty'];
    $qty_pick += $dtlrow['qty_pick'];
    $qty_order += $dtlrow['qty_order'];
    $qty_bo += $dtlrow['qty_border'];
    $ttot_hpp += $tot_hpp;
    $ttot_sal += $tot_sal;

    $tbl .= '<tr>';
    $tbl .='<td valign="top" width="30" align="left">' . $no++ . '.</td>';
    $tbl .='<td valign="top" width="120" align="left">' . $dtlrow['part_code'] . '</td>';
    $tbl .='<td valign="top" width="150" align="left">' . $dtlrow['part_name'] . '</td>';
    $tbl .='<td valign="top" width="70" align="left">' . $dtlrow['unit'] . '</td>';
    $tbl .='<td valign="top" width="120" align="left">' . $dtlrow['location'] . '</td>';
    $tbl .='<td valign="top" width="150" align="right">' . number_format($dtlrow['qty']) . '</td>';
    $tbl .='<td valign="top" width="150" align="right">' . number_format($dtlrow['qty_pick']) . '</td>';
    $tbl .='<td valign="top" width="150" align="right">' . number_format($dtlrow['min_qty']) . '</td>';
    $tbl .='<td valign="top" width="150" align="right">' . number_format($dtlrow['max_qty']) . '</td>';
    $tbl .='<td valign="top" width="150" align="right">' . number_format($dtlrow['qty_order']) . '</td>';
    $tbl .='<td valign="top" width="150" align="right">' . number_format($dtlrow['qty_border']) . '</td>';
    $tbl .='<td valign="top" width="150" align="right">' . number_format($dtlrow['pur_price']) . '</td>';
    $tbl .='<td valign="top" width="150" align="right">' . number_format($dtlrow['aver_price']) . '</td>';
    $tbl .='<td valign="top" width="150" align="right">' . number_format($dtlrow['sal_price']) . '</td>';
    $tbl .='<td valign="top" width="150" align="right">' . number_format($tot_hpp) . '</td>';
    $tbl .='<td valign="top" width="150" align="right">' . number_format($tot_sal) . '</td>';
    $tbl .= '</tr>';



    $i++;
    $j++;
    unset($dtlrow);
}

if ($i >= 1) {
    $tbl.= '<tr>'
            . '<td valign="top"  colspan="5" align="right"><b>Total: ' . $last_wrhs_code . '</b></td>'
            . '<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($qty) . '</td>'
            . '<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($qty_pick) . '</td>'
            . '<td valign="top"></td>'
            . '<td valign="top"></td>'
            . '<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($qty_order) . '</td>'
            . '<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($qty_bo) . '</td>'
            . '<td valign="top"></td>'
            . '<td valign="top"></td>'
            . '<td valign="top"></td>'
            . '<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($ttot_hpp) . '</td>'
            . '<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($ttot_sal) . '</td>'
            . '</tr>';

    $tbl .= '<tr><td valign="top" colspan="16"></td></tr>';
    $tbl .= '<tr><td valign="top" colspan="16"></td></tr>';
    $j = 0;
    $qty = 0;
    $qty_pick = 0;
    $qty_order = 0;
    $qty_bo = 0;
    $ttot_hpp = 0;
    $ttot_sal = 0;
}

$tbl.= '<tr>'
        . '<td valign="top"  colspan="5" align="right"><b>Grand Total:</b></td>'
        . '<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($sumqty) . '</td>'
        . '<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($sumqty_pick) . '</td>'
        . '<td valign="top"></td>'
        . '<td valign="top"></td>'
        . '<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($sumqty_order) . '</td>'
        . '<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($sumqty_bo) . '</td>'
        . '<td valign="top"></td>'
        . '<td valign="top"></td>'
        . '<td valign="top"></td>'
        . '<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($sumttot_hpp) . '</td>'
        . '<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($sumttot_sal) . '</td>'
        . '</tr>';
$tbl .='</table>';
