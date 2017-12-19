<?php
$tbl .= '
<div id="cntr1" align="center">
<table width="80%">
<tr><td valign="top" align="center"><b style="font-size:1.1em;">' . $comp_name . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.1em;">' . strtoupper($title) . ' REPORT</b></td></tr>
</table>
';
$tbl .= '
<table width="80%"  >
<tr>
<td valign="top" align="right" colspan="3"><b>Printed On: </b>' . date('d/m/Y') . '</td>
</tr>
</table>';

$tbl .= "
<table width='80%'>
 <thead style='border:2px solid black !important;'>
<tr>
<td valign='top' width='30' align='left'><b>No.</b></td>
<td valign='top' width='150' align='left'><b>Opname  Name<br />Opname Code</b></td>
<td valign='top' width='250' align='left'><b>Mailing Address</b></td>
<td valign='top' width='150' align='left'><b>Phone/HP</b></td>
<td valign='top' width='100' align='left'><b>Gender</b></td>
<td valign='top' width='100' align='left'><b>Opname Level</b></td>
</tr>
</thead>";
$tbl .='<tr><td valign="top"></td></tr>';

$no = 1;

while ($dtlrow = mysql_fetch_array($dtl)) {
    $sex = '';
    if ($dtlrow['sex'] == 1) {
        $sex = 'Male';
    }
    if ($dtlrow['sex'] == 2) {
        $sex = 'Female';
    }
    if ($dtlrow['sex'] == 3) {
        $sex = 'Company';
    }

    $tbl .='<tr>';
    $tbl .='<td valign="top" width="30"  align="left">' . $no++ . '.</td>';
    $tbl .='<td valign="top" width="150" align="left">' . $dtlrow['oprep_name'] . '<br />' . $dtlrow['oprep_code'] . '</td>';
    $tbl .='<td valign="top" width="250" align="left">' . $dtlrow['haddr'] . '</td>';
    $tbl .='<td valign="top" width="150" align="left">' . $dtlrow['hphone'] . '/' . $dtlrow['hp'] . '</td>';
    $tbl .='<td valign="top" width="100" align="left">' . $sex . '</td>';
    $tbl .='<td valign="top" width="100" align="left">' . $dtlrow['oprep_lev'] . '</td>';
    $tbl .='</tr>';
}

$tbl .='</table>';
