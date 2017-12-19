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
 <thead style="border:2px solid black !important;">
    <tr>
<td valign="top" width="30" align="left"><b>No.</b></td>
<td valign="top" width="100" align="left"><b>Part Code</b></td>
<td valign="top" width="200" align="left"><b>Part Name</b></td>
<td valign="top" width="200" align="left"><b>Part Alias</b></td>
<td valign="top" width="100" align="left"><b>Unit</b></td>
<td valign="top" width="100" align="right"><b>Rest<br />Stock</b></td>
<td valign="top" width="100" align="right"><b>Qty<br />Pick</b></td>
<td valign="top" width="100" align="right"><b>Min<br />Qty</b></td>
<td valign="top" width="100" align="right"><b>Max<br />Qty</b></td>
<td valign="top" width="100" align="right"><b>Qty<br />Order</b></td>
<td valign="top" width="150" align="left"><b>Brand</b></td>
<td valign="top" width="250" align="left"><b>Description</b></td>
</tr>
</thead>';
$tbl .='<tr><td valign="top"></td></tr>';

$no = 1;
$qty = 0;
$qty_pick = 0;
$min_qty = 0;
$max_qty = 0;
$qty_order = 0;


while ($dtlrow = mysql_fetch_array($dtl)) {
    $qty += $dtlrow['qty'];
    $qty_pick += $dtlrow['qty_pick'];
    $min_qty += $dtlrow['min_qty'];
    $max_qty += $dtlrow['max_qty'];
    $qty_order += $dtlrow['qty_order'];


    $tbl .= '<tr>';
    $tbl .='<td valign="top" width="30" align="left">' . $no++ . '.</td>';
    $tbl .="<td valign='top' width='100' align='left'>" . $dtlrow['part_code'] . "</td>";
    $tbl .="<td valign='top' width='150' align='left'>" . $dtlrow['part_name'] . "</td>";
    $tbl .="<td valign='top' width='200' align='left'>" . $dtlrow['part_alias'] . "</td>";
    $tbl .="<td valign='top' width='100' align='left'>" . $dtlrow['unit'] . "</td>";
    $tbl .="<td valign='top' width='100' align='right'>" . number_format($dtlrow['qty']) . "</td>";
    $tbl .="<td valign='top' width='100' align='right'>" . number_format($dtlrow['qty_pick']) . "</td>";
    $tbl .="<td valign='top' width='100' align='right'>" . number_format($dtlrow['min_qty']) . "</td>";
    $tbl .="<td valign='top' width='100' align='right'>" . number_format($dtlrow['max_qty']) . "</td>";
    $tbl .="<td valign='top' width='100' align='right'>" . number_format($dtlrow['qty_order']) . "</td>";
    $tbl .="<td valign='top' width='150' align='left'>" . $dtlrow['brand_code'] . "</td>";
    $tbl .="<td valign='top' width='250' align='left'>" . $dtlrow['note'] . "</td>";
    $tbl .= '</tr>';
}
$tbl .= '<tr><td valign="top" colspan="12"></td></tr>';
$tbl .= '<tr><td valign="top" colspan="12"></td></tr>';
$tbl .= '<tr><td valign="top" colspan="12"></td></tr>';
$tbl .= '<tr><td valign="top" colspan="12"></td></tr>';
$tbl .= '<tr><td valign="top" colspan="12"></td></tr>';
$tbl .= '<tr><td valign="top" colspan="12"></td></tr>';
$tbl .= '<tr><td valign="top" colspan="5" align="right"><b>Grand Total :</b></td>';
$tbl .= "<td valign='top' width='100' align='right'><b>" . number_format($qty) . "</b></td>";
$tbl .="<td valign='top' width='100' align='right'><b>" . number_format($qty_pick) . "</b></td>";
$tbl .="<td valign='top' width='100' align='right'><b>" . number_format($min_qty) . "</b></td>";
$tbl .="<td valign='top' width='100' align='right'><b>" . number_format($max_qty) . "</b></td>";
$tbl .="<td valign='top' width='100' align='right'><b>" . number_format($qty_order) . "</b></td>";
$tbl .= '</tr>';
$tbl .='</table>';
