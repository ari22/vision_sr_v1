<?php

$tbl .= '
<div id="cntr1" align="center">
<table width="100%">
<tr><td valign="top" align="center"><b style="font-size:1.5em;">' . $comp_name . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.5em;">' . $rptTitle . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.2em;">' . $mounths[$mounth] . ' ' . $year . '</b></td></tr>
</table>
';

$tbl .= '<table width="100%"  ><tr><td valign="top" ></td><td valign="top" align="right"><b>Printed On: </b>' . date('d/m/Y') . '</td></tr></table>';
$tbl.= '<table><tr><td valign="top" style="font-size:1.1em;font-weight:bold;">Employee : '.$srep_code.' : '.$srep_name.'</td></tr></table>';
$tbl .= '
<table width="100%">
<thead style="border:2px solid black !important;">
<tr>
<th valign="top" align="left"><b>No.</b></th>
<th valign="top" align="left"><b>Invoice Date</b></th>
<th valign="top" align="left" width="100"><b>Invoice No.</b></th>
<th valign="top" align="left"><b>Vehicle</b></th>
<th valign="top" align="left"><b>Customer</b></th>
<th valign="top" align="left"><b>Chassis</b></th>
<th valign="top" align="left"><b>Engine</b></th>
<th valign="top" align="left"><b>Color</b></th>
<th valign="top" align="right"><b>1 Point =<br />(a)</b></th>
<th valign="top" align="right"><b>%<br />(b)</b></th>
<th valign="top" align="right"><b>Point<br />(c)</b></th>
<th valign="top" align="right"><b>Sale Price<br />Vehicle (d)</b></th>
<th valign="top" align="right"><b>Value Point<br />(a x c)</b></th>
<th valign="top" align="right"><b>Percentage Value<br />(b x d)</b></th>
<th valign="top" align="right"><b>Total Incentive<br />(a x c)+(b x d)</b></th>
</tr>
</thead>';

$tbl.='<tr><td valign="top" ></td></tr>';
$no = 1;
$type = '';
$total = 0;



$vp = 0;
$pv = 0;

$tsal_incpnt = 0;
$tveh_price = 0;
$ttotal = 0;
$tvp = 0;
$tpv = 0;

if($point == ''){
    $point = 0;
}
while ($dtlrow = mysql_fetch_array($dtl)) {
    $vp = intval($point) * $dtlrow['sal_incpct'];
    $pv = intval($persen) * $dtlrow['veh_price'];
    $total = $vp + $pv;
    
    $tvp += $vp;
    $tpv += $pv;
    $tsal_incpnt += $dtlrow['sal_incpct'];
    $tveh_price += $dtlrow['veh_price'];
    $ttotal +=$total;
 

    $saldate = dateView($dtlrow['sal_date']);   
     
    $tbl .= '<tr>';
    $tbl .= '<td valign="top" >' . $no++ . '.</td>';
    $tbl .= '<td valign="top" >' . $saldate . '</td>';
    $tbl .= '<td valign="top" >' . $dtlrow['sal_inv_no'] . '</td>';
    $tbl .= '<td valign="top" >' . $dtlrow['veh_name'] . '</td>';
    $tbl .= '<td valign="top" >' . $dtlrow['cust_name'] . '</td>';
    $tbl .= '<td valign="top" >' . $dtlrow['chassis'] . '</td>';
    $tbl .= '<td valign="top" >' . $dtlrow['engine'] . '</td>';
    $tbl .= '<td valign="top" >' . $dtlrow['color_name'] . '</td>';
    $tbl .= '<td valign="top" align="right">' . number_format(intval($point)) . '</td>';
    $tbl .= '<td valign="top" align="right">' . number_format(intval($persen)) . '</td>';
    $tbl .= '<td valign="top" align="right">' . number_format($dtlrow['sal_incpct']) . '</td>';
    $tbl .= '<td valign="top" align="right">' . number_format($dtlrow['veh_price']) . '</td>';
    $tbl .= '<td valign="top" align="right">' . number_format($vp) . '</td>';
    $tbl .= '<td valign="top" align="right">' . number_format($pv) . '</td>';
    $tbl .= '<td valign="top" align="right">' . number_format($total) . '</td>';
    $tbl .= '</tr>';

    unset($dtlrow);
}


$tbl .= '<tr>';
$tbl .= '<td valign="top" align="right" colspan="10"><b>Total :</b></td>';
$tbl .= '<td valign="top" align="right" style="border-top:1px solid black;" >' . number_format($tsal_incpnt) . '</td>';
$tbl .= '<td valign="top" align="right" style="border-top:1px solid black;" >' . number_format($tveh_price) . '</td>';
$tbl .= '<td valign="top" align="right" style="border-top:1px solid black;" >' . number_format($tvp) . '</td>';
$tbl .= '<td valign="top" align="right" style="border-top:1px solid black;" >' . number_format($tpv) . '</td>';
$tbl .= '<td valign="top" align="right" style="border-top:1px solid black;" >' . number_format($ttotal) . '</td>';
$tbl .= '</tr>';


$tbl .= '<tr><td valign="top" ><br /></td></tr>';
$tbl .= '<tfoot>';
$tbl .= '<tr>';
$tbl .= '<td colspan="8"></td>';
$tbl .= '<td colspan="2" class="border-foot" valign="top" align="right" style="border-left:2px solid black;border-bottom:2px solid black;border-top:2px solid black;"><b>Grand Total :</b></td>';
$tbl .= '<td class="border-foot" valign="top" align="right" style="border-bottom:2px solid black;border-top:2px solid black;" ><b>' . number_format($tsal_incpnt) . '</b></td>';
$tbl .= '<td class="border-foot" valign="top" align="right" style="border-bottom:2px solid black;border-top:2px solid black;" ><b>' . number_format($tveh_price) . '</b></td>';
$tbl .= '<td class="border-foot" valign="top" align="right" style="border-bottom:2px solid black;border-top:2px solid black;" ><b>' . number_format($tvp) . '</b></td>';
$tbl .= '<td class="border-foot" valign="top" align="right" style="border-bottom:2px solid black;border-top:2px solid black;" ><b>' . number_format($tpv) . '</b></td>';
$tbl .= '<td class="border-foot" valign="top" align="right" style="border-right:2px solid black;border-bottom:2px solid black;border-top:2px solid black;" ><b>' . number_format($ttotal) . '</b></td>';
$tbl .= '</tr>';
$tbl .='</tfoot>';

$tbl.='</table>';
$tbl.='<br /><br />';
$tbl .='<table width="100%"><tr><td valign="top" align="right;"><b>Multiplier Point : ' . $point . ' </b></td></tr></table>';
