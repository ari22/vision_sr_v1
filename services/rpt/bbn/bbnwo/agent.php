<?php

if($status == 1){ 
	$width = '100%';
	$width2 = '3';
}else{
	$width = '80%';
	$width2 = '2';
}

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
$tbl .= '<th valign="top" align="left" width="120"><b>WO No.</b></th>';
$tbl .= '<th valign="top" align="left" width="80"><b>WO Date</b></th>';

if($status == 1){ 
	$tbl .= '<th valign="top" align="left"  width="80"><b>SPK  No.</b></th>';	
	$tbl .= '<th valign="top" align="left"  width="120"><b>Chassis</b></th>';
	$tbl .= '<th valign="top" align="left"  width="250"><b>Vehicle</b></th>';
	$tbl .= '<th valign="top" align="right" width="90"><b>BBN Price</b></th>';
	$tbl .= '<th valign="top" align="right" width="90"><b>BBN Disc</b></th>';
	$tbl .= '<th valign="top" align="right" width="90"><b>Net Price</b></th>';
	$tbl .= '<th valign="top" align="right" width="90"><b>Discount Invoice</b></th>';
}else{
	$tbl .= '<th valign="top" align="right" width="90"><b>Price Before Tax</b></th>';
}

$tbl .= '<th valign="top" align="right" width="90"><b>Tax (VAT)</b></th>';
$tbl .= '<th valign="top" align="right" width="90"><b>Others</b></th>';
$tbl .= '<th valign="top" align="right" width="90"><b>Grand Total</b></th>';
$tbl .= '</tr></thead>';
$tbl .= '<tr><td></td></tr>';

$last_wo_no = '';
$last_wo_date = '';
$last_supp_code = '';
$last_supp_name = '';

$i = 0;
$j = 0;

$price_bd  = 0;
$disc_val = 0;
$price_ad = 0;
$inv_disc = 0;
$inv_bt = 0;
$inv_vat = 0;
$inv_stamp = 0;
$inv_total = 0;

$price_bd2  = 0;
$disc_val2 = 0;
$price_ad2 = 0;
$inv_disc2 = 0;
$inv_bt2 = 0;
$inv_vat2 = 0;
$inv_stamp2 = 0;
$inv_total2 = 0;

$tprice_bd  = 0;
$tdisc_val = 0;
$tprice_ad = 0;
$tinv_disc = 0;
$tinv_bt = 0;
$tinv_vat = 0;
$tinv_stamp = 0;
$tinv_total = 0;

while ($dtlrow = mysql_fetch_array($dtl)) {
	
		if ($last_supp_code != $dtlrow['supp_code']) {
			if ($i >= 1) {
				$tbl .='<tr>';
				
				if($status == 1){ 
					$tbl .='<td valign="top" colspan="5" align="right"><b>TOTAL ' . $last_wo_no.'  :</b></td>';	
					$tbl .='<td valign="top"  align="right" style="border-top:1px solid #000;">' . number_format($price_bd) . '</td>';
					$tbl .='<td valign="top"  align="right" style="border-top:1px solid #000;">' . number_format($disc_val) . '</td>';
					$tbl .='<td valign="top"  align="right" style="border-top:1px solid #000;">' . number_format($price_ad) . '</td>';						
					$tbl .='<td valign="top"  align="right" style="border-top:1px solid #000;">' . number_format($inv_disc) . '</td>';        								 
				
				}else{
					$tbl .='<td valign="top" colspan="2" align="right"><b>TOTAL ' . $last_wo_no.'  :</b></td>';	
					$tbl .='<td valign="top"  align="right" style="border-top:1px solid #000;">' . number_format($inv_bt) . '</td>';
				}
			 				
				$tbl .='<td valign="top"  align="right" style="border-top:1px solid #000;">' . number_format($inv_vat) . '</td>';
				$tbl .='<td valign="top"  align="right" style="border-top:1px solid #000;">' . number_format($inv_stamp) . '</td>';
				$tbl .='<td valign="top"  align="right" style="border-top:1px solid #000;">' . number_format($inv_total) . '</td>';
				
				
				$tbl .='</tr>';
				$tbl .='<tr><td><br /></td></tr>';

				$i = 0;
				$price_bd  = 0;
				$disc_val = 0;
				$price_ad = 0;
				$inv_disc = 0;
				$inv_bt = 0;
				$inv_vat = 0;
				$inv_stamp = 0;
				$inv_total = 0;
			}
			
			if ($j >= 1) {
				$tbl .='<tr>';
				
				if($status == 1){ 
					$tbl .='<td valign="top" colspan="5" align="right"><b>TOTAL ' . $last_supp_code.'-'.$last_supp_name.'  :</b></td>';	
					$tbl .='<td valign="top"  align="right" style="border-top:1px solid #000;">' . number_format($price_bd2) . '</td>';
					$tbl .='<td valign="top"  align="right" style="border-top:1px solid #000;">' . number_format($disc_val2) . '</td>';
					$tbl .='<td valign="top"  align="right" style="border-top:1px solid #000;">' . number_format($price_ad2) . '</td>';						
					$tbl .='<td valign="top"  align="right" style="border-top:1px solid #000;">' . number_format($inv_disc2) . '</td>';        								 
				
				}else{
					$tbl .='<td valign="top" colspan="2" align="right"><b>TOTAL ' . $$last_supp_code.'-'.$last_supp_name.'  :</b></td>';	
					$tbl .='<td valign="top"  align="right" style="border-top:1px solid #000;">' . number_format($inv_bt2) . '</td>';
				}
			 				
				$tbl .='<td valign="top"  align="right" style="border-top:1px solid #000;">' . number_format($inv_vat2) . '</td>';
				$tbl .='<td valign="top"  align="right" style="border-top:1px solid #000;">' . number_format($inv_stamp2) . '</td>';
				$tbl .='<td valign="top"  align="right" style="border-top:1px solid #000;">' . number_format($inv_total2) . '</td>';
				
				
				$tbl .='</tr>';
				
				$tbl .='<tr><td><br /></td></tr>';
				
				$j = 0;
				$price_bd2  = 0;
				$disc_val2 = 0;
				$price_ad2 = 0;
				$inv_disc2 = 0;
				$inv_bt2 = 0;
				$inv_vat2 = 0;
				$inv_stamp2 = 0;
				$inv_total2 = 0;
			}
			
			$tbl.= '<tr><td valign="top" colspan="' . $width2 . '" align="left"><b style="font-size:1.1em;">' . $dtlrow['supp_code'] . ': ' . $dtlrow['supp_name'] . '</b></td></tr>';
			$last_supp_code = $dtlrow['supp_code'];
			$last_supp_name = $dtlrow['supp_name'];
			
			//$tbl.= '<tr><td valign="top" colspan="'.$width2.'" align="left"><b style="font-size:1.1em;">' . $dtlrow['wo_no'] . ' </b></td></tr>';
			$last_wo_no = $dtlrow['wo_no'];
			
			
		}elseif ($last_wo_no != $dtlrow['wo_no']) {
			if ($i >= 1) {
				$tbl .='<tr>';
				
				if($status == 1){ 
					$tbl .='<td valign="top" colspan="5" align="right"><b>TOTAL ' . $last_wo_no.'  :</b></td>';	
					$tbl .='<td valign="top"  align="right" style="border-top:1px solid #000;">' . number_format($price_bd) . '</td>';
					$tbl .='<td valign="top"  align="right" style="border-top:1px solid #000;">' . number_format($disc_val) . '</td>';
					$tbl .='<td valign="top"  align="right" style="border-top:1px solid #000;">' . number_format($price_ad) . '</td>';						
					$tbl .='<td valign="top"  align="right" style="border-top:1px solid #000;">' . number_format($inv_disc) . '</td>';        								 
				
				}else{
					$tbl .='<td valign="top" colspan="2" align="right"><b>TOTAL ' . $last_wo_no.'  :</b></td>';	
					$tbl .='<td valign="top"  align="right" style="border-top:1px solid #000;">' . number_format($inv_bt) . '</td>';
				}
			 				
				$tbl .='<td valign="top"  align="right" style="border-top:1px solid #000;">' . number_format($inv_vat) . '</td>';
				$tbl .='<td valign="top"  align="right" style="border-top:1px solid #000;">' . number_format($inv_stamp) . '</td>';
				$tbl .='<td valign="top"  align="right" style="border-top:1px solid #000;">' . number_format($inv_total) . '</td>';
				
				
				$tbl .='</tr>';
				
				$tbl .='<tr><td><br /></td></tr>';
				
				$i = 0;
				$price_bd  = 0;
				$disc_val = 0;
				$price_ad = 0;
				$inv_disc = 0;
				$inv_bt = 0;
				$inv_vat = 0;
				$inv_stamp = 0;
				$inv_total = 0;
			}

			//$tbl.= '<tr><td valign="top" colspan="'.$width2.'" align="left"><b style="font-size:1.1em;">' . $dtlrow['wo_no'] . ' </b></td></tr>';
			$last_wo_no = $dtlrow['wo_no'];
	
		}else{
			$dtlrow['wo_no'] = '';
			$dtlrow['wo_date'] =  '';
			$dtlrow['supp_name'] = '';
		}
		

	
	
	if($status == 1){ 
		$tprice_bd += $dtlrow['price_bd'];
		$tdisc_val += $dtlrow['disc_val'];
		$tprice_ad += $dtlrow['price_ad'];
		$tinv_disc += $dtlrow['inv_disc'];
		
		$price_bd += $dtlrow['price_bd'];
		$disc_val += $dtlrow['disc_val'];
		$price_ad += $dtlrow['price_ad'];
		$inv_disc += $dtlrow['inv_disc'];
		
		$price_bd2 += $dtlrow['price_bd'];
		$disc_val2 += $dtlrow['disc_val'];
		$price_ad2 += $dtlrow['price_ad'];
		$inv_disc2 += $dtlrow['inv_disc'];
	}

	$inv_bt += $dtlrow['inv_bt'];
	$inv_vat += $dtlrow['inv_vat'];
	$inv_stamp += $dtlrow['inv_stamp'];
	$inv_total += $dtlrow['inv_total'];
	
	$inv_bt2 += $dtlrow['inv_bt'];
	$inv_vat2 += $dtlrow['inv_vat'];
	$inv_stamp2 += $dtlrow['inv_stamp'];
	$inv_total2 += $dtlrow['inv_total'];
	
	$tinv_bt += $dtlrow['inv_bt'];
	$tinv_vat += $dtlrow['inv_vat'];
	$tinv_stamp += $dtlrow['inv_stamp'];
	$tinv_total += $dtlrow['inv_total'];
	
	
	
	if($dtlrow['wo_date'] !== ''){
		$wo_date = dateView($dtlrow['wo_date']);
	}else{
		$wo_date='';
	}
	
	$tbl .='<tr>';
	$tbl .='<td>'.$dtlrow['wo_no'].'</td>';
	$tbl .='<td>'.$wo_date.'</td>';
	
	if($status == 1){ 
		$tbl .= '<td valign="top">'.$dtlrow['so_no'].'</td>';	
		$tbl .= '<td valign="top">'.$dtlrow['chassis'].'</td>';
		$tbl .= '<td valign="top">'.$dtlrow['veh_name'].'</td>';
		
		$tbl .='<td valign="top"  align="right">' . number_format($dtlrow['price_bd']) . '</td>';
		$tbl .='<td valign="top"  align="right">' . number_format($dtlrow['disc_val']) . '</td>';
		$tbl .='<td valign="top"  align="right">' . number_format($dtlrow['price_ad']) . '</td>';
	
		$tbl .='<td valign="top"  align="right">' . number_format($dtlrow['inv_disc']) . '</td>';
	}else{
		$tbl .='<td valign="top"  align="right">' . number_format($dtlrow['inv_bt']) . '</td>';
	}
    $tbl .='<td valign="top"  align="right">' . number_format($dtlrow['inv_vat']) . '</td>';
    $tbl .='<td valign="top"  align="right">' . number_format($dtlrow['inv_stamp']) . '</td>';
    $tbl .='<td valign="top"  align="right">' . number_format($dtlrow['inv_total']) . '</td>';
	$tbl .='</tr>';  
	
	$i++;
    $j++;
    unset($dtlrow);
	  
}

if ($i >= 1) {
				$tbl .='<tr>';
				
				if($status == 1){ 
					$tbl .='<td valign="top" colspan="5" align="right"><b>TOTAL ' . $last_wo_no.'  :</b></td>';	
					$tbl .='<td valign="top"  align="right" style="border-top:1px solid #000;">' . number_format($price_bd) . '</td>';
					$tbl .='<td valign="top"  align="right" style="border-top:1px solid #000;">' . number_format($disc_val) . '</td>';
					$tbl .='<td valign="top"  align="right" style="border-top:1px solid #000;">' . number_format($price_ad) . '</td>';						
					$tbl .='<td valign="top"  align="right" style="border-top:1px solid #000;">' . number_format($inv_disc) . '</td>';        								 
				
				}else{
					$tbl .='<td valign="top" colspan="2" align="right"><b>TOTAL ' . $last_wo_no.'  :</b></td>';	
					$tbl .='<td valign="top"  align="right" style="border-top:1px solid #000;">' . number_format($inv_bt) . '</td>';
				}
			 				
				$tbl .='<td valign="top"  align="right" style="border-top:1px solid #000;">' . number_format($inv_vat) . '</td>';
				$tbl .='<td valign="top"  align="right" style="border-top:1px solid #000;">' . number_format($inv_stamp) . '</td>';
				$tbl .='<td valign="top"  align="right" style="border-top:1px solid #000;">' . number_format($inv_total) . '</td>';
				
				
				$tbl .='</tr>';
				$tbl .='<tr><td><br /></td></tr>';

				$i = 0;
				$price_bd  = 0;
				$disc_val = 0;
				$price_ad = 0;
				$inv_disc = 0;
				$inv_bt = 0;
				$inv_vat = 0;
				$inv_stamp = 0;
				$inv_total = 0;
			}
			
			if ($j >= 1) {
				$tbl .='<tr>';
				
				if($status == 1){ 
					$tbl .='<td valign="top" colspan="5" align="right"><b>TOTAL ' . $last_supp_code.'-'.$last_supp_name.'  :</b></td>';	
					$tbl .='<td valign="top"  align="right" style="border-top:1px solid #000;">' . number_format($price_bd2) . '</td>';
					$tbl .='<td valign="top"  align="right" style="border-top:1px solid #000;">' . number_format($disc_val2) . '</td>';
					$tbl .='<td valign="top"  align="right" style="border-top:1px solid #000;">' . number_format($price_ad2) . '</td>';						
					$tbl .='<td valign="top"  align="right" style="border-top:1px solid #000;">' . number_format($inv_disc2) . '</td>';        								 
				
				}else{
					$tbl .='<td valign="top" colspan="2" align="right"><b>TOTAL ' . $$last_supp_code.'-'.$last_supp_name.'  :</b></td>';	
					$tbl .='<td valign="top"  align="right" style="border-top:1px solid #000;">' . number_format($inv_bt2) . '</td>';
				}
			 				
				$tbl .='<td valign="top"  align="right" style="border-top:1px solid #000;">' . number_format($inv_vat2) . '</td>';
				$tbl .='<td valign="top"  align="right" style="border-top:1px solid #000;">' . number_format($inv_stamp2) . '</td>';
				$tbl .='<td valign="top"  align="right" style="border-top:1px solid #000;">' . number_format($inv_total2) . '</td>';
				
				
				$tbl .='</tr>';
				
				$tbl .='<tr><td><br /></td></tr>';
				
				$j = 0;
				$price_bd2  = 0;
				$disc_val2 = 0;
				$price_ad2 = 0;
				$inv_disc2 = 0;
				$inv_bt2 = 0;
				$inv_vat2 = 0;
				$inv_stamp2 = 0;
				$inv_total2 = 0;
}

$tbl .='<tr><td valign="top" colspan="6"><br /></td></tr>';
$tbl .='<tfoot>';
if($status == 1){ 
	$tbl .='<td colspan="2"></td>';
	$tbl .='<td class="border-foot" colspan="3" class="border-foot" valign="top" style="border-left:2px solid black;border-top:2px solid black;border-bottom:2px solid black;" align="right"><b>GRAND TOTAL:</b></td>';
				 
	$tbl .='<td class="border-foot" class="border-foot" valign="top"  align="right" style="border-top:2px solid black;border-bottom:2px solid black;"><b>' . number_format($tprice_bd) . '</b></td>';
	$tbl .='<td class="border-foot" valign="top"  align="right" style="border-top:2px solid black;border-bottom:2px solid black;"><b>' . number_format($tdisc_val) . '</b></td>';
	$tbl .='<td class="border-foot" valign="top"  align="right" style="border-top:2px solid black;border-bottom:2px solid black;"><b>' . number_format($tprice_ad) . '</b></td>';
     
}else{
	$tbl .='<td class="border-foot" colspan="2" valign="top"  align="right" style="border-left:2px solid black;border-top:2px solid black;border-bottom:2px solid black;"><b>GRAND TOTAL:</b></td>';
}
                       
			       
if($status == 1){ 
	$tbl .='<td class="border-foot" valign="top"  align="right" style="border-top:2px solid black;border-bottom:2px solid black;"><b>' . number_format($tinv_disc) . '</b></td>';        
}else{
	$tbl .='<td class="border-foot" valign="top"  align="right" style="border-top:2px solid black;border-bottom:2px solid black;"><b>' . number_format($tinv_bt) . '</b></td>';
}
			 
$tbl .='<td class="border-foot" valign="top"  align="right" style="border-top:2px solid black;border-bottom:2px solid black;"><b>' . number_format($tinv_vat) . '</b></td>';
$tbl .='<td class="border-foot" valign="top"  align="right" style="border-top:2px solid black;border-bottom:2px solid black;"><b>' . number_format($tinv_stamp) . '</b></td>';
$tbl .='<td class="border-foot" valign="top"  align="right" style="border-right:2px solid black;border-top:2px solid black;border-bottom:2px solid black;"><b>' . number_format($tinv_total) . '</b></td>';
            			
$tbl .='</tr>';

$tbl .='</tfoot>';

$tb .='</table>';