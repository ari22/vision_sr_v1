<?php

$tbl .= '<div id="cntr1" align="center">';
$tbl .= '
<table width="80%">
<tr><td valign="top" align="center"><b style="font-size:1.1em;">' . $comp_name . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.1em;">' . $title . ' REPORT ' . $status . '</b></td></tr>
</table>
';

$tbl .= '
<table width="80%">
<tr>
<td></td>
<td valign="top" align="right"><b>Printed On: </b>' . date('d/m/Y') . '</td>
</tr>
</table>';

$tbl .= '
<table width="80%">
<thead style="border:2px solid black !important;">
<tr>
    <td class="border-head"  valign="top"rowspan="2" width="30"><b>No.</b></td>
    <td class="border-head"  valign="top"rowspan="2"><b>Registered<br />SPK</b></td>
    <td class="border-head"  valign="top" colspan="2" align="center" style="border-bottom:1px solid #000"><b>Registration</b></td>
    <td class="border-head"  valign="top"rowspan="2"></td>
    <td class="border-head"  valign="top" colspan="2" style="border-bottom:1px solid #000"><b></b></td>
    <td class="border-head"  valign="top" colspan="2" style="border-bottom:1px solid #000"><b>Distribution</b></td>
    <td class="border-head"  valign="top"rowspan="2"><b>Used Date (b)<br />Note</b></td>
    <td class="border-head"  valign="top"rowspan="2"><b>(b - a)<br />Days</b></td>
</tr>
<tr>
    <td><b>Date</b></td>
    <td><b>By</b></td>
    <td><b>Date (a)</b></td>
    <td><b>By</b></td>
    <td><b>To</b></td>
    <td></td>
</tr>

</thead>';
$tbl .="<tr><td></td></tr>";

$no = 1;
$unused = 0;
$used = 0;
$sumday = 0;
$sumday2=0;
$tot =0;
while ($dtlrow = mysql_fetch_array($dtl)) {
	
	if($dtlrow['use_date'] == '0000-00-00 00:00:00'){
		$unused++;
	}
    $so_dstdate = '';
    $use_date2 = '';
    $dstdate = '';
    $days = '';

    $so_regdate = dateView($dtlrow['so_regdate']);

    if ($dtlrow['use_date'] !== '0000-00-00 00:00:00') {
        $use_date = dateView($dtlrow['use_date']);
		$used++;
		$tot ++;
    }
    if ($dtlrow['so_dstdate'] !== '0000-00-00 00:00:00') {
        $so_dstdate = dateView($dtlrow['so_dstdate']);
    }
	
	$min = '';
	
    if ($dtlrow['use_date'] !== '0000-00-00 00:00:00') {
		$ex_so_dstdate = explode(' ', $dtlrow['so_dstdate']);
		$usedate2 = explode(' ', $dtlrow['use_date']);
		
		if(strtotime($ex_so_dstdate[0]) > strtotime($usedate2[0])){
			$min = '-';
		}
		
        $dstdate = new DateTime($ex_so_dstdate[0]);
        $usedate2 = new DateTime($usedate2[0]);
        $day = $dstdate->diff($usedate2);
        $days = intval($min.$day->days);
    }
	
	$av1 = strtotime($dtlrow['use_date']);
	$av2 = strtotime($dtlrow['so_dstdate']);
	
	
	//$sumday2 += ($av1 - $av2);
	$sumday2 +=$days;
	
    $tbl .="<tr>";
    $tbl .="<td>" . number_format($no) . ".</td>";
    $tbl .="<td>" . $dtlrow['so_no'] . "</td>";
    $tbl .="<td>" . $so_regdate . "</td>";
    $tbl .="<td>" . $dtlrow['so_reg_by'] . "</td>";
    $tbl .="<td></td>";
    $tbl .="<td>" . $so_dstdate . "</td>";
    $tbl .="<td>" . $dtlrow['so_dst_by'] . "</td>";
    $tbl .="<td>" . $dtlrow['srep_code'] . "</td>";
    $tbl .="<td>" . $dtlrow['srep_name'] . "</td>";
    $tbl .="<td>" . $use_date . "<br />" . $dtlrow['so_note'] . "</td>";
    $tbl .="<td align='right'>" . number_format($days)  . "<br /></td>";
    $tbl .="</tr>";


    $no++;
}

//$sumday = date(' t ', $sumday2) / 3;
$sumday = $sumday2 / $tot;
$tbl .='<tr><td><br /><br /></td></tr>';
if($so_status == 0){
	$tbl .="<tr><td colspan='9'  align='right'><b>Total Registered & Distributd SPK Unused:</b></td><td align='right' colspan='1'><b>".number_format($unused)."</b></td></tr>";
	$tbl .="<tr><td colspan='9'  align='right'><b>Total Registerd  & Distributed SPK Used:</b></td><td align='right' colspan='1'><b>".number_format($used)."</b></td></tr>";
}
$tbl .="<tr><td colspan='9'  align='right'><b>Average  of SPK Use Date minus Distribution Date:</b></td><td align='right' colspan='1'><b>".number_format($sumday, 3,",",".")." days</b></td></tr>";
$tbl .='</table>';
$tbl .='</div>';
