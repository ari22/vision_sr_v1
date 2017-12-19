<?php

$tbl .= '
<div id="cntr1" align="center">
<table width="90%">
<tr><td valign="top" align="center"><b style="font-size:1.5em;">' . $comp_name . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.5em;">' . $repTitle . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.1em;">' . $title . '</b></td></tr>

</table>
';

$tbl .= '
<table width="90%"  >
<tr>
<td></td>
<td valign="top" align="right"><b>Printed On: </b>' . date('d/m/Y') . '</td>
</tr>
</table>';

$tbl .= '<table width="90%">';
$tbl .= '<thead style="border:2px solid black !important;">
<tr>
        <td width="30">#</td>
	<td valign="top" align="left" 	width="80px" 	 ><b>Receive Date From Agent</b></td>
	<td valign="top" align="left" 	width="80px" 	 ><b>Police No./<br />STNK Phone</b></td>
	<td valign="top" align="left" 	width="150px" 	 ><b>STNK Name/<br />Leasing Name</b></td>
        <td valign="top" align="left" 	width="200px" 	 ><b>STNK Address/<br />HP</b></td>
	<td valign="top" align="left" 	width="90px" 	 ><b>Vehicle Type</b></td>
	<td valign="top" align="left" 	width="70px" 	 ><b>Chassis<br />Receiving Name</b></td>
	<td valign="top" align="left" width="50px" 	 ><b>Sales</b></td>
	<td valign="top" align="right" 	width="180px" 	 ><b>Age BPKB (day)</b></td>';

$tbl .= '</tr></thead>';
$tbl .= '<tr><td></td></tr>';
$i = 0;
$no = 1;
while ($dtlrow = mysql_fetch_array($dtl)) {
    $bpkb_rdate = dateView($dtlrow['bpkb_rdate']);
    $sal_date = dateView($dtlrow['sal_date']);
    $rcv_o_date = dateView($dtlrow['rcv_o_date']);
    $dlv_o_date = dateView($dtlrow['dlv_o_date']);
    $bpkb_rdate = dateView($dtlrow['bpkb_rdate']);
    
    $bpkb_rdate2 = new DateTime($dtlrow['bpkb_rdate']);
    

    $bpkb_date = new DateTime($dtlrow['bpkb_date']);
    $day = $bpkb_rdate2->diff($bpkb_date);
    
    $tbl.= '
	<tr>
        <td valign="top">' . $no++ . '.</td>
		<td valign="top" align="left">' . $bpkb_rdate . '</td>
		<td valign="top" align="left">' . $dtlrow['veh_reg_no'] . '<br />'.$dtlrow['cust_rphon'].'</td>
		<td valign="top" align="left">' . $dtlrow['cust_rname'] . '<br />'.$dtlrow['lease_name'].'</td>
                <td valign="top" align="left">' .  $dtlrow['cust_raddr'] . '<br />'.$dtlrow['cust_hp'].'</td>
		<td valign="top" align="left">' . $dtlrow['veh_model'] . '</td>
		<td valign="top" align="left">' . $dtlrow['chassis'] . '<br />' . $dtlrow['bpkb_sname'] . '</td>
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
    <tr><td colspan="9">Umur BPKB : Tgl. Terima dari Biro Jasa - Tgl. BPKB</td>
    </tr>
</table>


</div>
';
?>