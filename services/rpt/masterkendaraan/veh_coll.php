<?php
//========CHANGE LOG=============
//ganti semua <td jadi <td valign="top"
//judul diperbaiki
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
<th valign='top' width='150'><b>Collector Name<br />Collector Code</b></th>
<th valign='top' width='250'><b>Mailing Address</b></th>
<th valign='top' width='150'><b>Phone/HP</b></th>
<th valign='top' width='100'><b>Gender</b></th>
<th valign='top' width='100'><b>Collector Level</b></th>
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
    $tbl .='<td valign="top" width="30" align="top">' . $no++ . '.</td>';
    $tbl .='<td valign="top" width="150">' . $dtlrow['coll_name'] . '<br />' . $dtlrow['coll_code'] . '</td>';
    $tbl .='<td valign="top" width="250">' . $dtlrow['haddr'] . '</td>';
    $tbl .='<td valign="top" width="150">' . $dtlrow['hphone'] . ' / ' . $dtlrow['hp'] . '</td>';
    $tbl .='<td valign="top" width="100">' . $sex . '</td>';
    $tbl .='<td valign="top" width="100">' . $dtlrow['coll_lev'] . '</td>';
    $tbl .='</tr>';
}

$tbl .='</table>';
