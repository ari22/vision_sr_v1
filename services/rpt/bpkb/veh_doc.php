<?php

$tbl .= '
<div id="cntr1" align="center">
<table width="100%">
<tr><td valign="top" align="center"><b style="font-size:1.5em;">' . $comp_name . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.5em;">' . $repTitle . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.1em;">' . $title . '</b></td></tr>

</table>
';

$tbl .= '
<table width="100%"  >
<tr>
<td></td>
<td valign="top" align="right"><b>Printed On: </b>' . date('d/m/Y') . '</td>
</tr>
</table>';

$tbl .= '<table width="100%">';
$tbl .= '<thead style="border:2px solid black !important;">
<tr>
        <td>#</td>
	<td valign="top" align="left" 	width="80px" 	 ><b>Doc No.<br>Date</b></td>
	<td valign="top" align="left" 	width="120px" 	 ><b>Sale Invoice No.<br />Sale Invoice Date</b></td>
	<td valign="top" align="left" 	width="220px" 	 ><b>STNK Date</b></td>
	<td valign="top" align="left" 	width="220px" 	 ><b>STNK Address</b></td>
	<td valign="top" align="left" 	width="120px" 	 ><b>Vehicle Type</b></td>
	<td valign="top" align="left" 	width="150px" 	 ><b>Chassis<br>Engine</b></td>
	<td valign="top" align="left" 	width="100px" 	 ><b>Sales</b></td>
	<td valign="top" align="left" 	width="80px" 	 ><b>Key No.</b></td>';

$tbl .= '</tr></thead>';
$tbl .= '<tr><td></td></tr>';

$i = 0;
$no=1;
while ($dtlrow = mysql_fetch_array($dtl)) {

    $doc_date = dateView($dtlrow['doc_date']);
    $sal_date = dateView($dtlrow['sal_date']);
    $rcv_o_date = dateView($dtlrow['rcv_o_date']);
    $dlv_o_date = dateView($dtlrow['dlv_o_date']);

    $tbl.= '
	<tr>
                <td valign="top">'.$no++.'.</td>
		<td valign="top" align="left">' . $dtlrow['doc_inv_no'] . '<br>' . $doc_date . '</td>
		<td valign="top" align="left">' . $dtlrow['sal_inv_no'] . '<br>' . $sal_date . '</td>
		<td valign="top" align="left">' . $dtlrow['cust_rname'] . '</td>
		<td valign="top" style="align:left;font-size:0.8em;">' . $dtlrow['cust_raddr'] . '</td>
		<td valign="top" align="left">' . $dtlrow['veh_model'] . '</td>
		<td valign="top" align="left">' . $dtlrow['chassis'] . '<br>' . $dtlrow['engine'] . '</td>
		<td valign="top" align="left">' . $dtlrow['srep_code'] . '</td>
		<td valign="top" align="left">' . $dtlrow['key_no'] . '</td>                   
        </tr>
		';

    $i++;
    unset($dtlrow);
}
$tbl .='
</table>


</div>
';
?>