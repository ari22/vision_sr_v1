<?php

error_reporting(E_ALL ^ E_NOTICE);
//error_reporting(0);
$bulan = array(
    '',
    'JANUARY',
    'FEBRUARY',
    'MARCH',
    'APRIL',
    'MAY',
    'JUNE',
    'JULY',
    'AUGUST',
    'SEPTEMBER',
    'OCTOBER',
    'NOVEMBER',
    'DECEMBER'
);

$tbl .= '
<div id="cntr1" align="center">
<table width="90%">
<tr><td valign="top" align="center"><b style="font-size:1.5em;">' . $comp_name . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.5em;">' . $rptTitle . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.1em;">Group By ' . $title . '</b></td></tr>';
if ($filterdesc !== '') {
    $tbl .= '    <tr><td valign="top" align="center"><span style="font-size:1.1em;">Filter By ' . $filterdesc . '</span></td></tr>';
}
$tbl .='<tr><td valign="top" align="center"><b>' . $bulan[$mounth] . '  ' . $year . ' </b></td></tr>
</table>
';
$tbl .= '
    <table width="90%"  >
    <tr>
    <td valign="top"></td>
    <td valign="top" align="right"><b>Printed On: </b>' . date('d/m/Y') . '</td>
    </tr>
    </table>';

$tbl .= '
<table width="90%">
<thead style="border:2px solid black !important;">
<tr>
    <td valign="top"><b>Chassis</b></td>
    <td valign="top"><b>Engine</b></td>
    <td valign="top"><b>Model</b></td>
    <td valign="top"><b>Transm</b></td>
    <td valign="top"><b>Year</b></td>
    <td valign="top"><b>Key No.</b></td>
    <td valign="top"  width="80"><b>Serv. Book</b></td>
    <td valign="top" width="80"><b>Cust. Code</b></td>
    <td valign="top"><b>Cust. Name</b></td>
    <td valign="top" width="120"><b>Purchase No.</b></td>
    <td valign="top"><b>Purchase Date</b></td>
    <td valign="top" width="120"><b>Sales No.</b></td>
    <td valign="top"><b>Sales Date</b></td>
    <td valign="top" align="right"><b>Total</b></td>
</tr>
</thead>';

$tbl .= '
<tr>
	<td valign="top" colspan="13"></td>
</tr>
';

$i = 0;
$j = 0;
$lnQty = 0;
$last_veh_code = '';
$last_veh_name = '';
$last_color_name = '';
$last_color_code = '';

$unit = 0;
$tunit = 0;
$sumunit = 0;

while ($dtlrow = mysql_fetch_array($dtl)) {


    if ($last_veh_code != $dtlrow['veh_code']) {

        if ($j >= 1) {
            $tbl.= '
			<tr>
				<td valign="top" colspan="13" align="right">TOTAL ' . $last_color_code . ' : ' . $last_color_name . ':</td>
                                <td valign="top" align="right" style="border-top:1px solid black;">' . number_format($unit) . ' Unit</td>
			</tr>';
            $j = 0;
            $unit = 0;
        }

        if ($i >= 1) {

            $tbl.= '
			<tr>
                            <td valign="top" colspan="13" align="right"><b style="font-size:1.1em;">TOTAL ' . $last_veh_code . ' : ' . $last_veh_name . ':</b></td>
                            <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($tunit) . ' UNIT</b></td>
			</tr>';
            $i = 0;
            $tunit = 0;
        }

        $tbl.= '<tr><td valign="top" colspan="13" align="left"><b style="font-size:1.1em;">*** ' . $dtlrow['veh_code'] . ' : ' . $dtlrow['veh_name'] . ' ***</b></td></tr>';
        $last_veh_name = $dtlrow['veh_name'];
        $last_veh_code = $dtlrow['veh_code'];

        $tbl.= '<tr><td valign="top" colspan="12" align="left"><b style="font-size:1.1em;">' . $dtlrow['color_code'] . ' : ' . $dtlrow['color_name'] . '</b></td></tr>';
        $last_color_name = $dtlrow['color_name'];
        $last_color_code = $dtlrow['color_code'];
    } elseif ($last_color_code != $dtlrow['color_code']) {
        if ($j >= 1) {
            $tbl.= '
			<tr>
				<td valign="top" colspan="13" align="right">TOTAL ' . $last_color_code . ' : ' . $last_color_name . ':</td>
                                <td valign="top" align="right" style="border-top:1px solid black;">' . number_format($unit) . ' Unit</td>
			</tr>';
            $j = 0;
            $unit = 0;
        }

        $tbl.= '<tr><td valign="top" colspan="13" align="left"><b style="font-size:1.1em;">' . $dtlrow['color_code'] . ' : ' . $dtlrow['color_name'] . '</b></td></tr>';
        $last_color_name = $dtlrow['color_name'];
        $last_color_code = $dtlrow['color_code'];
    }


    $unit += $dtlrow['unit'];
    $tunit += $dtlrow['unit'];
    $sumunit += $dtlrow['unit'];

    $pur_date = dateView($dtlrow['pur_date']);
    $sal_date = dateView($dtlrow['sal_date']);

    $tbl .='<tr>';
    $tbl .='<td>' . $dtlrow['chassis'] . '</td>';
    $tbl .='<td>' . $dtlrow['engine'] . '</td>';
    $tbl .='<td>' . $dtlrow['veh_model'] . '</td>';
    $tbl .='<td>' . $dtlrow['veh_transm'] . '</td>';
    $tbl .='<td>' . $dtlrow['veh_year'] . '</td>';
    $tbl .='<td>' . $dtlrow['key_no'] . '</td>';
    $tbl .='<td>' . $dtlrow['serv_book'] . '</td>';
    $tbl .='<td>' . $dtlrow['cust_code'] . '</td>';
    $tbl .='<td>' . $dtlrow['cust_name'] . '</td>';
    $tbl .='<td>' . $dtlrow['pur_inv_no'] . '</td>';
    $tbl .='<td>' . $pur_date . '</td>';
    $tbl .='<td>' . $dtlrow['sal_inv_no'] . '</td>';
    $tbl .='<td>' . $sal_date . '</td>';
    $tbl .='<td align="right">' . number_format($dtlrow['unit']) . ' Unit</td>';
    $tbl .='</tr>';


    $i++;
    $j++;
    unset($dtlrow);
}

if ($j >= 1) {
            $tbl.= '
			<tr>
				<td valign="top" colspan="13" align="right">TOTAL ' . $last_color_code . ' : ' . $last_color_name . ':</td>
                                <td valign="top" align="right" style="border-top:1px solid black;">' . number_format($unit) . ' Unit</td>
			</tr>';
            $j = 0;
            $unit = 0;
        }

        if ($i >= 1) {

            $tbl.= '
			<tr>
                            <td valign="top" colspan="13" align="right"><b style="font-size:1.1em;">TOTAL ' . $last_veh_code . ' : ' . $last_veh_name . ':</b></td>
                            <td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($tunit) . ' UNIT</b></td>
			</tr>';
            $i = 0;
            $tunit = 0;
        }
$tbl .='<tr><td valign="top"></td></tr><tr><td valign="top"></td></tr><tr><td valign="top"></td></tr>';

$tbl .='<tfoot style="border:2px solid black !important;">'
        . '<tr>'
        . '<td class="border-foot" valign="top" colspan="13" align="right"><b style="font-size:1.1em;">TOTAL STOCK ' . $bulan[$mounth] . ' ' . $year . ':</b></td>'
        . '<td class="border-foot" valign="top" align="right" width="50"><b>' . number_format($sumunit) . ' UNIT</b></td>'
        . '</tr>'
        . '</tfoot>';

$tbl .='</table>';
