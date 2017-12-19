<?php
//========CHANGE LOG=============
//ganti semua <td jadi <td valign="top"
//isi contact person dan job posistion kebalik
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
<th valign="top" width="100"><b>Insurance Code</b></th>
<th valign="top" width="150"><b>Insurance Name</b></th>
<th valign="top" width="250"><b>Mailing Address</b></th>
<th valign="top" width="200"><b>Phone/Fax/HP/Email</b></th>
<th valign="top" width="200"><b>Contact Person/Job Position </b></th>

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
    $tbl .='<td valign="top" width="30">' . $no++ . '.</td>';
    $tbl .='<td valign="top" width="100">' . $dtlrow['insr_code'] . '</td>';
    $tbl .='<td valign="top" width="150">' . $dtlrow['insr_name'] . '</td>';
    $tbl .='<td valign="top" width="250">' . $addr . '</td>';
    $tbl .='<td valign="top" width="200">' . $phone . ' / ' . $fax . ' / ' . $hp . ' / ' . $email . '</td>';
    $tbl .='<td valign="top" width="200">' . $dtlrow['ocp1_name']. ' / ' . $dtlrow['ocp1_title'] . '</td>';

    $tbl .='<td valign="top" width="200">' . $dtlrow['onpwp'] . '</td>';
    $tbl .='</tr>';
}

$tbl .='</table>';
