<?php
//========CHANGE LOG=============
//ganti semua <td jadi <td valign="top"
//'/' => ' / '

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
<table width="100%">
 <thead style="border:2px solid black !important;">
<tr>
<th valign="top" width="30"><b>No.</b></th>
<th valign="top" width="100"><b>Customer Code</b></th>
<th valign="top" width="150"><b>Customer Name</b></th>
<th valign="top" width="250"><b>Mailing Address</b></th>
<th valign="top" width="200"><b>Phone/Fax/HP/Email</b></th>
<th valign="top" width="200"><b>Contact Person/Job Position </b></th>
<th valign="top" width="200"><b>Gender</b></th>
<th valign="top" width="200"><b>NPWP</b></th>
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
        $hp = $dtlrow['ohp'];
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
    $tbl .='<td valign="top" width="30">' . $no++ . '.</td>';
    $tbl .='<td valign="top" width="100">' . $dtlrow['cust_code'] . '</td>';
    $tbl .='<td valign="top" width="150">' . $dtlrow['cust_name'] . '</td>';
    $tbl .='<td valign="top" width="250">' . $addr . '</td>';
    $tbl .='<td valign="top" width="200">' . $phone . ' / ' . $fax . ' / ' . $hp . ' / ' . $email . '</td>';
    $tbl .='<td valign="top" width="200">' . $dtlrow['ocp1_title'] . ' / ' . $dtlrow['ocp1_name'] . '</td>';
    $tbl .='<td valign="top" width="200">' . $sex . '</td>';
    $tbl .='<td valign="top" width="200">' . $dtlrow['tx_npwp'] . '</td>';
    $tbl .='</tr>';


}

$tbl .='</table>';
