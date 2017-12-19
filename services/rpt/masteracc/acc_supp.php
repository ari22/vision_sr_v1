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

$tbl .= '
<table width="80%">
 <thead style="border:2px solid black !important;">
<tr>
<td valign="top" width="30" align="left"><b>No.</b></td>
<td valign="top" width="100" align="left"><b>Customer Code</b></td>
<td valign="top" width="150" align="left"><b>Customer Name</b></td>
<td valign="top" width="250" align="left"><b>Mailing Address</b></td>
<td valign="top" width="200" align="left"><b>Phone/Fax/HP/Email</b></td>
<td valign="top" width="200" align="left"><b>Contact Person/Job Position </b></td>
<td valign="top" width="200" align="left"><b>Part Type <br />is Supplied</b></td>
<td valign="top" width="200" align="left"><b>NPWP</b></td>
</tr>
</thead>';
$tbl .='<tr><td valign="top"></td></tr>';

$no = 1;

$addr = '';
$area = '';
$city = '';
$country = '';
$zipcode = '';
$phone = '';
$hp = '';
$fax = '';
$email = '';

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
    $tbl .='<td valign="top" width="100" align="left">' . $dtlrow['supp_code'] . '</td>';
    $tbl .='<td valign="top" width="150" align="left">' . $dtlrow['supp_name'] . '</td>';
    $tbl .='<td valign="top" width="250" align="left">' . $addr . '</td>';
    $tbl .='<td valign="top" width="200" align="left">' . $phone . '/' . $fax . '/' . '/' . $hp . '/' . $email . '</td>';
    $tbl .='<td valign="top" width="200" align="left">' . $dtlrow['ocp1_title'] . '/' . $dtlrow['ocp1_name'] . '</td>';
    $tbl .='<td valign="top" width="200" align="left">'.$dtlrow['bus_item'].'</td>';
    $tbl .='<td valign="top" width="200" align="left">' . $dtlrow['onpwp'] . '</td>';
    $tbl .='</tr>';
}

$tbl .='</table>';
