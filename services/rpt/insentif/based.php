<?php

$tbl .= '
<div id="cntr1" align="center">
<table width="90%">
<tr><td valign="top" align="center"><b style="font-size:1.5em;">' . $comp_name . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.5em;">' . $rptTitle . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.2em;">' . $mounths[$mounth] . ' ' . $year . '</b></td></tr>
</table>
';

$tbl .= '<table width="90%"  ><tr><td valign="top" ></td><td valign="top" align="right"><b>Printed On: </b>' . date('d/m/Y') . '</td></tr></table>';
$tbl.= '<table><tr><td valign="top" style="font-size:1.1em;font-weight:bold;">Employee : '.$srep_code.' : '.$srep_name.'</td></tr></table>';

$tbl .= '
<table width="90%">
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
<th valign="top" align="right"><b>%</b></th>
<th valign="top" align="right"><b>Point</b></th>
<th valign="top" align="left"><b>Incentive Type</b></th>
<th valign="top" align="right"><b>1 Point=</b></th>
<th valign="top" align="right"><b>Sale Price</b></th>
<th valign="top" align="right"><b>Total Incentive</b></th>
</tr>
</thead>';

$tbl.='<tr><td valign="top" ></td></tr>';
$no = 1;
$type = '';
$total = 0;
$point = 0;
$tsal_incpnt = 0;
$tveh_price = 0;
$ttotal = 0;

while ($dtlrow = mysql_fetch_array($dtl)) {
    $tsal_incpnt +=$dtlrow['sal_incpnt'];
    $tveh_price +=$dtlrow['veh_price'];
    
    $saldate = dateView($dtlrow['sal_date']);   
    $sal_inctyp = $dtlrow['sal_inctyp'];

    switch ($sal_inctyp) {
        case '1':
            $type = ' : ';
            break;
        case '2':
            $type = 'Pnt';
            break;
        case '3':
            $type = 'Pct';
            $total = ($dtlrow['veh_price'] / 100) * $dtlrow['sal_incpct'];
            break;
        case '4':
            $type = 'PP';
            $total = ($dtlrow['veh_price'] / 100) * $dtlrow['sal_incpct'];
            break;
    }
    
    $ttotal +=$total;
    // -= None, Pnt=Point, Pct = Percentage, PP= Point+Percentage

    $tbl .= '<tr>';
    $tbl .= '<td valign="top" >' . $no++ . '.</td>';
    $tbl .= '<td valign="top" >' . $saldate . '</td>';
    $tbl .= '<td valign="top" >' . $dtlrow['sal_inv_no'] . '</td>';
    $tbl .= '<td valign="top" >' . $dtlrow['veh_name'] . '</td>';
    $tbl .= '<td valign="top" >' . $dtlrow['cust_name'] . '</td>';
    $tbl .= '<td valign="top" >' . $dtlrow['chassis'] . '</td>';
    $tbl .= '<td valign="top" >' . $dtlrow['engine'] . '</td>';
    $tbl .= '<td valign="top" >' . $dtlrow['color_name'] . '</td>';
    $tbl .= '<td valign="top" align="right">' . number_format($dtlrow['sal_incpct']) . '</td>';
    $tbl .= '<td valign="top" align="right">' . number_format($dtlrow['sal_incpnt']) . '</td>';
    $tbl .= '<td valign="top" >' . $type . '</td>';
    $tbl .= '<td valign="top" align="right">'.$point.'</td>';
    $tbl .= '<td valign="top" align="right">' . number_format($dtlrow['veh_price']) . '</td>';
    $tbl .= '<td valign="top" align="right">' . number_format($total) . '</td>';
    $tbl .= '</tr>';

    unset($dtlrow);
}

$tbl .= '<tr>';
$tbl .= '<td valign="top" align="right" colspan="9"><b>Total :</b></td>';
$tbl .= '<td valign="top" align="right" style="border-top:1px solid black;" >' . number_format($tsal_incpnt) . '</td>';
$tbl .= '<td valign="top" style="border-top:1px solid black;" ></td>';
$tbl .= '<td valign="top" align="right" style="border-top:1px solid black;" ></td>';
$tbl .= '<td valign="top" align="right" style="border-top:1px solid black;" >' . number_format($tveh_price) . '</td>';
$tbl .= '<td valign="top" align="right" style="border-top:1px solid black;" >' . number_format($ttotal) . '</td>';
$tbl .= '</tr>';

$tbl .= '<tr><td valign="top" ><br /></td></tr>';
$tbl .= '<tfoot>';
$tbl .= '<tr>';
$tbl .= '<td colspan="7"></td>';
$tbl .= '<td colspan="2" class="border-foot" style="border-left:2px solid black;border-bottom:2px solid black;border-top:2px solid black;" valign="top" align="right"><b>Grand Total :</b></td>';
$tbl .= '<td class="border-foot" style="border-bottom:2px solid black;border-top:2px solid black;" valign="top" align="right"><b>' . number_format($tsal_incpnt) . '</b></td>';
$tbl .= '<td class="border-foot" style="border-bottom:2px solid black;border-top:2px solid black;" valign="top" style="border-top:1px solid black;" ></td>';
$tbl .= '<td class="border-foot" style="border-bottom:2px solid black;border-top:2px solid black;" valign="top" align="right"></td>';
$tbl .= '<td class="border-foot" style="border-bottom:2px solid black;border-top:2px solid black;" valign="top" align="right"><b>' . number_format($tveh_price) . '</b></td>';
$tbl .= '<td class="border-foot" style="border-right:2px solid black;border-bottom:2px solid black;border-top:2px solid black;" valign="top" align="right"><b>' . number_format($ttotal) . '</b></td>';
$tbl .= '</tr>';

$tbl .='</tfoot>';

$tbl.='</table>';
$tbl.='<br /><br />';
$tbl .='<table width="90%"><tr><td valign="top" align="right;"><b>Incentive Type: -= None, Pnt=Point, Pct = Percentage, PP= Point+Percentage</b></td></tr></table>';
