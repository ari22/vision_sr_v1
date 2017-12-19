<?php

$width = '80%';

$tbl .= '
<div id="cntr1" align="center">
<table width="'.$width.'">
<tr><td valign="top" align="center"><b style="font-size:1.5em;">' . $comp_name . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.5em;">' . $rptTitle . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.1em;">' . $title . '</b></td></tr>
<tr><td valign="top" align="center"><b>DATE : ' . dateView($date1) . ' UP TO ' . dateView($date2) . '</b></td></tr>
</table>
';


$tbl .= '
<table width="'.$width.'"  >
<tr>
<td></td>
<td valign="top" align="right"><b>Printed On: </b>' . date('d/m/Y') . '</td>
</tr>
</table>';

$tbl .= '<table width="'.$width.'">';
$tbl .= '<thead style="border:2px solid black !important;">';
$tbl .= '<tr>';
$tbl .= '<th valign="top" align="right" width="40"><b>No.</b></th>';
$tbl .= '<th valign="top" align="left" width="80"><b>WO Date</b></th>';
$tbl .= '<th valign="top" align="left" width="120"><b>WO No.</b></th>';
$tbl .= '<th valign="top" align="left"  width="80"><b>SPK  No.</b></th>';	
$tbl .= '<th valign="top" align="left"  width="120"><b>Chassis</b></th>';
$tbl .= '<th valign="top" align="left"  width="120"><b>Color</b></th>';
$tbl .= '<th valign="top" align="left"  width="120"><b>Customer</b></th>';
$tbl .= '<th valign="top" align="right" width="90"><b>Net Price</b></th>';
$tbl .= '</tr></thead>';
//$tbl .= '<tr><td></td></tr>';

$last_wo_no = '';
$last_wo_date = '';
$last_veh_code = '';
$last_veh_name = '';

$no=1;
$i = 0;
$j = 0;

$price_ad =0;
$tprice_ad =0;

while ($dtlrow = mysql_fetch_array($dtl)) {

	if ($last_veh_code != $dtlrow['veh_code']) {
		if ($i >= 1) {
			$tbl .='<tr>';
				
				$tbl .='<td valign="top" colspan="7" align="right"><b>TOTAL ' . $last_veh_code.'  :</b></td>';					 
				$tbl .='<td valign="top"  align="right" style="border-top:1px solid #000;">' . number_format($price_ad) . '</td>';					
				$tbl .='</tr>';
				
			$i = 0;
			$price_ad = 0;
			$no=1;
		}
		$tbl.= '<tr><td valign="top" colspan="8" align="left"><b style="font-size:1.1em;">' . $dtlrow['veh_code'] . ' - ' . $dtlrow['veh_name'] . ' </b></td></tr>';

		$last_veh_code = $dtlrow['veh_code'];
		$last_veh_name = $dtlrow['veh_name'];
	}
	
	$price_ad += $dtlrow['price_ad'];
	$tprice_ad += $dtlrow['price_ad'];
	$wo_date = dateView($dtlrow['wo_date']);
	
	$tbl .='<tr>';
	$tbl .='<td align="right">'.$no++.'.</td>';
	$tbl .='<td>'.$wo_date.'</td>';
	$tbl .='<td>'.$dtlrow['wo_no'].'</td>';
	$tbl .= '<td valign="top">'.$dtlrow['so_no'].'</td>';	
	$tbl .= '<td valign="top">'.$dtlrow['chassis'].'</td>';
	$tbl .= '<td valign="top">'.$dtlrow['color_name'].'</td>';
	$tbl .= '<td valign="top">'.$dtlrow['cust_name'].'</td>';
	$tbl .= '<td valign="top"  align="right">' . number_format($dtlrow['price_ad']) . '</td>';
	$tbl .= '</tr>';  
	
	$i++;
    $j++;
    unset($dtlrow);
	  
}
	

$tbl .='<tr><td valign="top" colspan="8"><br /></td></tr>';
$tbl .='<tfoot>';
$tbl .='<tr>';
$tbl .='<td colspan="7"  align="right" class="border-foot" valign="top" style="border-left:2px solid black;border-top:2px solid black;border-bottom:2px solid black;"><b>GRAND TOTAL:</b></td>';					 
$tbl .='<td class="border-foot" valign="top"  align="right" style="border-right:2px solid black;border-top:2px solid black;border-bottom:2px solid black;"><b>' . number_format($price_ad) . '</b></td>';									 			
$tbl .='</tr>';

$tbl .='</tfoot>';

$tb .='</table>';