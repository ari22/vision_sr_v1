<?php
//========CHANGE LOG=============
//ganti semua <td jadi <td valign="top"
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

$tbl .= "
<table width='100%'>
 <thead style='border:2px solid black !important;'>
<tr>
<th valign='top' width='30'><b>No.</b></th>
<th valign='top' width='150'><b>Agent  Name<br />Agent Code</b></th>
<th valign='top' width='250'><b>Mailing Address</b></th>
<th valign='top' width='150'><b>Phone/Fax/Email</b></th>
<th valign='top' width='100'><b>Contact Person</b></th>
</tr>
</thead>";
$tbl .='<tr><td valign="top"></td></tr>';
$no = 1;


while ($dtlrow = mysql_fetch_array($dtl)) {
    $tbl .='<tr>';
    $tbl .='<td valign="top" width="30" align="top">' . $no++ . '.</td>';
    $tbl .='<td valign="top" width="150">' . $dtlrow['agent_name'] . '<br />' . $dtlrow['agent_code'] . '</td>';
    $tbl .='<td valign="top" width="250">' . $dtlrow['oaddr'] . '</td>';
    $tbl .='<td valign="top" width="150">' . $dtlrow['ophone'] . ' / ' . $dtlrow['ofax'] . ' / ' . $dtlrow['oemail'] . '</td>';
    $tbl .='<td valign="top" width="100">' . $dtlrow['ocp1_name'] . ' / ' . '</td>';
    $tbl .='</tr>';
}

$tbl .='</table>';
