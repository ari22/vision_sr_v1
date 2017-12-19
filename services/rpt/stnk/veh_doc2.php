<?php

$tbl .= '
<div id="cntr1" align="center">
<table width="95%">
<tr><td valign="top" align="center"><b style="font-size:1.5em;">' . $comp_name . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.5em;">' . $repTitle . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.1em;">' . $title . '</b></td></tr>

</table>
';

$tbl .= '
<table width="95%"  >
<tr>
<td></td>
<td valign="top" align="right"><b>Printed On: </b>' . date('d/m/Y') . '</td>
</tr>
</table>';

$tbl .= '<table width="95%">';
$tbl .= '<thead style="border:2px solid black !important;">
<tr>
        <td width="30">#</td>
	<td valign="top" align="left" 	width="80px" 	 ><b>Receive Date From Agent</b></td>
	<td valign="top" align="left" 	width="80px" 	 ><b>Police No.</b></td>
	<td valign="top" align="left" 	width="150px" 	 ><b>STNK Name</b></td>
        <td valign="top" align="left" 	width="200px" 	 ><b>STNK Address</b></td>
	<td valign="top" align="left" 	width="90px" 	 ><b>Vehicle Type</b></td>
	<td valign="top" align="left" 	width="70px" 	 ><b>Chassis</b></td>
	<td valign="top" align="left" width="80px" 	 ><b>Sales</b></td>
	<td valign="top" align="right" 	width="180px" 	 ><b>Age STNK (day)</b></td>';

$tbl .= '</tr></thead>';
$tbl .= '<tr><td></td></tr>';
$i = 0;
$no = 1;
while ($dtlrow = mysql_fetch_array($dtl)) {
    $stnk_rdate = dateView($dtlrow['stnk_rdate']);
    $sal_date = dateView($dtlrow['sal_date']);
    $rcv_o_date = dateView($dtlrow['rcv_o_date']);
    $dlv_o_date = dateView($dtlrow['dlv_o_date']);
    $stnk_rdate = dateView($dtlrow['stnk_rdate']);
    
    $stnk_rdate2 = new DateTime($dtlrow['stnk_rdate']);
    

    $stnk_bdate = new DateTime($dtlrow['stnk_bdate']);
    $day = $stnk_rdate2->diff($stnk_bdate);
    
    $tbl.= '
	<tr>
        <td valign="top">' . $no++ . '.</td>
		<td valign="top" align="left">' . $stnk_rdate . '</td>
		<td valign="top" align="left">' . $dtlrow['veh_reg_no'] . '</td>
		<td valign="top" align="left">' . $dtlrow['cust_rname'] . '</td>
                <td valign="top" align="left">' .  $dtlrow['cust_raddr'] . '</td>
		<td valign="top" align="left">' . $dtlrow['veh_model'] . '</td>
		<td valign="top" align="left">' . $dtlrow['chassis'] . '</td>
		<td valign="top" align="left">' .  $dtlrow['srep_code']  . '</td>
		<td valign="top" align="right">'.  number_format($day->days) .'</td>
        </tr>
		';

    $i++;
    unset($dtlrow);
}
$tbl .='
    <tr><td><br /><br /></td></tr>
    <tr><td colspan="9"><b>Keterangan :</b></td></tr>
    <tr><td colspan="9">Umur STNK : Tgl. Terima dari Biro Jasa - Tgl. Berlaku STNK Awal</td>
    </tr>
</table>


</div>
';
?>