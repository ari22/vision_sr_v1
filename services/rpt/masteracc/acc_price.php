<?php
$tbl .= '
            <div id="cntr1" align="center">
            <table width="100%">
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

$tbl .= '<table width="80%" style="border:2px solid black;"><tr>';
$tbl .= '<thead style="border:2px solid black !important;">';
$tbl .= '<td valign="top" width="30" align="left"><b>No.</b></td>';
$tbl .= '<td valign="top" width="100" align="left"><b>Part Code</b></td>';
$tbl .= '<td valign="top" width="250" align="left"><b>Part Name</td>';
$tbl .= '<td valign="top" width="120" align="left"><b>Location</b></td>';
$tbl .= '<td valign="top"  width="150" align="right"><b>Sale Price</b></td>';
$tbl .= '<td valign="top"  width="150" align="right"><b>Sale+PPN</b></td>';
$tbl .= '<td valign="top"  width="150" align="right"><b>Disc(%)</b></td>';
$tbl .= '</tr></thead>';

$no = 1;
$i = 0;
$j = 0;
$last_wrhs_code = '';

$t_price = 0;
$t_sal_vat = 0;
$t_disc = 0;


$c_price = 0;
$c_sal_vat = 0;
$c_disc = 0;

$tbl .= '<tr><td valign="top" colspan="7"></td></tr>';
$tbl .= '<tr><td valign="top" colspan="7"></td></tr>';

while ($dtlrow = mysql_fetch_array($dtl)) {
    $price = $dtlrow['sal_price'];
    $sal_vat = ($price / 100) * 10;

    $t_price += $price;
    $t_sal_vat += $sal_vat;
    $t_disc += $dtlrow['sal_disc'];

    if ($last_wrhs_code != $dtlrow['wrhs_code']) {
        if ($i >= 1) {
            $tbl.= '<tr>'
                    . '<td valign="top"  colspan="4" align="right"><b>Total: ' . $last_wrhs_code . '</b></td>'
                    . '<td valign="top" align="right" style="border-top:1px solid black;" width="150">' . number_format($c_price) . '</td>'
                    . '<td valign="top" align="right" style="border-top:1px solid black;" width="150">' . number_format($c_sal_vat) . '</td>'
                    . '</tr>';

            $tbl .= '<tr><td valign="top" colspan="7"></td></tr>';
            $tbl .= '<tr><td valign="top" colspan="7"></td></tr>';

            $j = 0;
            $c_price = 0;
            $c_sal_vat = 0;
            $c_disc = 0;
        }

        $tbl.= '<tr><td valign="top" colspan="7" align="left"><b style="font-size:1.1em;">' . $dtlrow['wrhs_code'] . '</b></td></tr>';
        $last_wrhs_code = $dtlrow['wrhs_code'];
    }

    $c_price += $price;
    $c_sal_vat += $sal_vat;
    $c_disc += $dtlrow['sal_disc'];

    $tbl .='<tr>';
    $tbl .='<td valign="top" width="30" align="left">' . $no++ . '.</td>';
    $tbl .='<td valign="top" width="100" align="left">' . $dtlrow['part_code'] . '</td>';
    $tbl .='<td valign="top" width="250" align="left">' . $dtlrow['part_name'] . '</td>';
    $tbl .='<td valign="top" width="120" align="left">' . $dtlrow['location'] . '</td>';
    $tbl .='<td valign="top" width="150" align="right">' . number_format($dtlrow['sal_price']) . '</td>';
    $tbl .='<td valign="top" width="150" align="right">' . number_format($sal_vat) . '</td>';
    $tbl .='<td valign="top" width="150" align="right">' . number_format($dtlrow['sal_disc']) . '</td>';
    $tbl .='</tr>';

    $i++;
    $j++;
    unset($dtlrow);
}

if ($i >= 1) {
    $tbl.= '<tr>'
            . '<td valign="top"  colspan="4" align="right"><b>Total: ' . $last_wrhs_code . '</b></td>'
            . '<td valign="top" align="right" style="border-top:1px solid black;" width="150">' . number_format($c_price) . '</td>'
            . '<td valign="top" align="right" style="border-top:1px solid black;" width="150">' . number_format($c_sal_vat) . '</td>'
            . '</tr>';

    $tbl .= '<tr><td valign="top" colspan="7"></td></tr>';
    $tbl .= '<tr><td valign="top" colspan="7"></td></tr>';

    $j = 0;
    $c_price = 0;
    $c_sal_vat = 0;
    $c_disc = 0;
}
$tbl .= '<tr>';
$tbl .= '<td valign="top" colspan="3"></td>';
$tbl .= '<td valign="top" colspan="4"><table width="75%" style="border:2px solid black;"><tr>';
$tbl.= '<tr>'
        . '<td valign="top" align="right" colspan="4" ><b>Grand Total: </b></td>'
        . '<td valign="top" align="right" width="150">' . number_format($t_price) . '</td>'
        . '<td valign="top" align="right" width="150">' . number_format($t_sal_vat) . '</td>'
        . '</tr>';
$tbl .='</table>'
        . '</td>';

$tbl .= '</tr>';

$tbl .='</table>';
