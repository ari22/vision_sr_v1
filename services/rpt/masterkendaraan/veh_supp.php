<?php
//========CHANGE LOG=============
//ganti semua <td jadi <td valign="top"
//' / ' => ' / '
//Part Type <br />is supplied =>Supplied Part Type
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
$tbl .= '
<table width="100%" >
<thead style="border:2px solid black !important;">
<tr>
<th valign="top" width="30" align="left"><b>No.</b></th>
<th valign="top" align="left"><b>Supplier Code</b></th>
<th valign="top" align="left"><b>Supplier Name</b></th>
<th valign="top" align="left"><b>Mailing Address</b></th>
<th valign="top" align="left"><b>Phone/Fax/HP/Email</b></th>
<th valign="top" align="left"><b>Contact Person/Job Position </b></th>
<th valign="top" align="left"><b>Supplied Part Type</b></th>
<th valign="top" align="left"><b>NPWP</b></th>
</tr>
</thead>';
$tbl .='<tr><td valign="top"></td></tr>';
$no = 1;

while ($dtlrow = mysql_fetch_array($dtl)) {

    if ($dtlrow['postaddr'] == 1) {

        $addr = $dtlrow['oaddr'];
        $area = $dtlrow['oarea'];
        $city = $dtlrow['ocity'];
        $country = $dtlrow['ocountry'];
        $zipcode = $dtlrow['ozipcode'];
        $phone = $dtlrow['ophone'];
        $hp = $dtlrow['hp'];
        $fax = $dtlrow['ofax'];
        $email = $dtlrow['oemail'];
    } else if ($dtlrow['postaddr'] == 2) {

        $addr = $dtlrow['haddr'];
        $area = $dtlrow['harea'];
        $city = $dtlrow['hcity'];
        $country = $dtlrow['hcountry'];
        $zipcode = $dtlrow['hzipcode'];
        $phone = $dtlrow['hphone'];
        $hp = $dtlrow['hp'];
        $fax = $dtlrow['hfax'];
        $email = $dtlrow['hemail'];
    }

    $tbl .='<tr>';
    $tbl .='<td valign="top" width="30" align="left">' . $no++ . '.</td>';
    $tbl .='<td valign="top" align="left">' . $dtlrow['supp_code'] . '</td>';
    $tbl .='<td valign="top" align="left">' . $dtlrow['supp_name'] . '</td>';
    $tbl .='<td valign="top" align="left">' . $addr . '</td>';
    $tbl .='<td valign="top" align="left">' . $phone . ' / ' . $fax . ' / ' . $hp . ' / ' . $email . '</td>';
    $tbl .='<td valign="top" align="left">' . $dtlrow['ocp1_title'] . ' / ' . $dtlrow['ocp1_name'] . '</td>';
    $tbl .='<td valign="top" align="left">'.$dtlrow['bus_item'].'</td>';
    $tbl .='<td valign="top" align="left">' . $dtlrow['onpwp'] . '</td>';
    $tbl .='</tr>';
}

$tbl .='</table>';
