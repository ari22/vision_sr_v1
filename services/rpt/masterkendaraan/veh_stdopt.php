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
<table width="50%"  >
<tr>
<td valign="top" align="right" colspan="3"><b>Printed On: </b>' . date('d/m/Y') . '</td>
</tr>
</table>';

$tbl .= "
<table width='50%'>
<thead style='border:2px solid black !important;'>
<tr>
<th valign='top' width='30' align='left'><b>No.</b></th>
<th valign='top' width='150' align='left'><b>Optional Code</b></th>
<th valign='top' width='250' align='left'><b>Optional Name</b></th>
</tr>
</thead>";
$tbl .='<tr><td valign="top"></td></tr>';
$no = 1;

while ($dtlrow = mysql_fetch_array($dtl)) {
    $tbl .='<tr>';
    $tbl .='<td valign="top" width="30" align="left">' . $no++ . '.</td>';
    $tbl .='<td valign="top" width="150" align="left">' . $dtlrow['stdoptcode'] .'</td>';
    $tbl .='<td valign="top" width="250" align="left">' . $dtlrow['stdoptname'] . '</td>';
    $tbl .='</tr>';
}

$tbl .='</table></div>';

