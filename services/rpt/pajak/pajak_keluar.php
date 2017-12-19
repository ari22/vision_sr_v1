<?php
$tbl .= '
<div id="cntr1" align="center">
<table width="60%">
<tr><td valign="top" align="center"><b style="font-size:1.5em;">' . $comp_name . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.5em;">TAX LIST OUTPUT</b></td></tr>
<tr><td valign="top" align="center"><b>TAX PERIOD : ' . $mounths[$mounth] . ' ' . $year . '</b></td></tr>
</table>
';

$tbl .= '
<table width="60%"  >
<tr>
<td></td>
<td valign="top" align="right"><b>Printed On: </b>' . date('d/m/Y') . '</td>
</tr>
</table>';

$tbl .= '
        <table width="60%" >
        <thead style="border:2px solid black !important;">
            <tr>
                <td valign="top" width="30"><b>No.</b></td>
                <td valign="top" width="200"><b>NAMA PEMBELI BKP /<br />PENERIMA JKP</b></td>
                <td valign="top" width="150"><b>NPWP</b></td>
                <td valign="top" width="150"><b>NOMOR SERI<br />FAKTUR PAJAK</b></td>
                <td valign="top" width="100"><b>TGL. FAKTUR PAJAK</b></td>
                <td valign="top" width="50" align="right"><b>PPN</b></td>
            </tr>
        </thead>';

$tbl .= '<tr><td></td></tr>';

$no = 1;

$t_vat =0;

while ($dtlrow = mysql_fetch_array($dtl)) {
    $t_vat += $dtlrow['veh_vat'];
    
    $fp_date = dateView($dtlrow['fp_date']);
    
    $tbl .= "<tr>";
    $tbl .='<td valign="top" width="30">'.$no++.'. </td>';
    $tbl .='<td valign="top" width="200">'.$dtlrow['cust_name'].'</td>';
    $tbl .='<td valign="top" width="100">'.$dtlrow['cust_npwp'].'</td>';
    $tbl .='<td valign="top" width="150">'.$dtlrow['fp_no'].'</td>';
    $tbl .='<td valign="top" width="100">'.$fp_date.'</td>';
    $tbl .='<td valign="top" width="50" align="right">'.number_format(ceil($dtlrow['veh_vat'])).'</td>';
    $tbl .= "</tr>";
}

$tbl .='<tr><td><br /></td></tr>';
$tbl .=' <tfoot>';
$tbl .='<tr><td valign="top" colspan="6" align="right"></td></tr>';
$tbl .='<tr><td colspan="3"></td>'
        . '<td class="border-foot" colspan="2" style="border-left:2px solid black;border-bottom:2px solid black;border-top:2px solid black;" valign="top" align="right"><b>JUMLAH PPN KELUARAN KENDARAAN:</b></td>'
        . '<td class="border-foot" style="border-right:2px solid black;border-bottom:2px solid black;border-top:2px solid black;" valign="top" align="right"><b>'.number_format($t_vat).'</b></td></tr>';
$tbl .='</tfoot>';
$tbl .= '</table>';