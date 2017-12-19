<?php

//========CHANGE LOG=============
//ganti semua <td jadi <td valign="top"
//chassis => Chassis No.
//Customer => Supplier di judul

$tbl .= '
<div id="cntr1" align="center">
<table width="100%">
<tr><td valign="top" align="center"><b style="font-size:1.5em;">' . $comp_name . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.5em;">' . $rptTitle . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.1em;">' . $title . '</b></td></tr>
<tr><td valign="top" align="center"><b>' . $pay_date1 . ' UP TO ' . $pay_date2 . '</b></td></tr>
</table>
';


$tbl .= '
<table width="100%">
<tr>
<td valign="top"></td>
<td valign="top" align="right"><b>Printed On: </b>' . date('d/m/Y') . '</td>
</tr>
</table>';

$tbl .= '
<table width="100%">
<thead style="border:2px solid black !important;">
<tr>
    <td valign="top"><b>Pay Date</b></td>
    <td valign="top"><b>Sales<br />Invoice No.</b></td>
    <td valign="top"><b>Sales<br />Invoice Date</b></td>
    <td valign="top"><b>Chassis</b></td>
    <td valign="top"><b>Payment Type</b></td>
    <td valign="top"><b>Bank</b></td>
    <td valign="top" align="right"><b>Payment</b></td>
    <td valign="top" align="right"><b>Discount</b></td>
    <td valign="top" align="right"><b>Other Tax</b></td>
    <td valign="top"><b>Check No.</b></td>
    <td valign="top"><b>Check Date</b></td>
    <td valign="top"><b>Due Date</b></td>
    <td valign="top"><b>Note</b></td>
</tr>
</thead>';

$tbl .= '<tr><td valign="top"></td></tr>';

$payer = '';

$i = 0;

$pay_val = 0;
$disc_val = 0;
$pph = 0;

$tpay_val = 0;
$tdisc_val = 0;
$tpph = 0;

while ($dtlrow = mysql_fetch_array($dtl)) {
    if ($payer != $dtlrow['pay2_name']) {

        if ($i >= 1) {
            $tbl.= '<tr>';
            $tbl.= '<td colspan="6" align="right"><b>Total Intermediary ' . $payer . ':</b></td>';
            $tbl.= '<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($pay_val) . '</td>';
            $tbl.= '<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($disc_val) . '</td>';
            $tbl.= '<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($pph) . '</td>';
            $tbl.= '</tr>';

            $i = 0;

            $pay_val = 0;
            $disc_val = 0;
            $pph = 0;
        }

        $payer = $dtlrow['pay2_name'];
    }

    $pay_val += $dtlrow['pay_val'];
    $disc_val += $dtlrow['disc_val'];
    $pph += $dtlrow['pph'];

    $tpay_val += $dtlrow['pay_val'];
    $tdisc_val += $dtlrow['disc_val'];
    $tpph += $dtlrow['pph'];

    $pay_date = dateView($dtlrow['pay_date']);
    $sal_date = dateView($dtlrow['sal_date']);
    $check_date = dateView($dtlrow['check_date']);
    $due_date = dateView($dtlrow['due_date']);

    $tbl.= '<tr>';
    $tbl.= '<td>' . $pay_date . '</td>';
    $tbl.= '<td>' . $dtlrow['sal_inv_no'] . '</td>';
    $tbl.= '<td>' . $sal_date . '</td>';
    $tbl.= '<td>' . $dtlrow['chassis'] . '</td>';
    $tbl.= '<td>' . $dtlrow['pay_type'] . '</td>';
     $tbl.= '<td>' . $dtlrow['bank_code'] . '</td>';
    $tbl.= '<td valign="top" align="right">' . number_format($dtlrow['pay_val']) . '</td>';
    $tbl.= '<td valign="top" align="right">' . number_format($dtlrow['disc_val']) . '</td>';
    $tbl.= '<td valign="top" align="right">' . number_format($dtlrow['pph']) . '</td>';
    $tbl.= '<td>' . $dtlrow['check_no'] . '</td>';
    $tbl.= '<td>' . $check_date . '</td>';
    $tbl.= '<td>' . $due_date . '</td>';
    $tbl.= '<td>' . $dtlrow['note'] . '</td>';
    $tbl.= '</tr>';

    $i++;
    unset($dtlrow);
}

if ($i >= 1) {
    $tbl.= '<tr>';
    $tbl.= '<td colspan="6" align="right"><b>Total Intermediary ' . $payer . ':</b></td>';
    $tbl.= '<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($pay_val) . '</td>';
    $tbl.= '<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($disc_val) . '</td>';
    $tbl.= '<td valign="top" align="right" style="border-top:1px solid black;">' . number_format($pph) . '</td>';
    $tbl.= '</tr>';

    $i = 0;

    $pay_val = 0;
    $disc_val = 0;
    $pph = 0;
}

$tbl .= '<tr><td><br /></td></tr>';

$tbl .= '<tfoot style="border:2px solid black !important;">';
$tbl.= '<tr>';
$tbl.= '<td class="border-foot" colspan="6" align="right"><b>Total Payment:</b></td>';
$tbl.= '<td align="right" style="border-top:1px solid black;">' . number_format($tpay_val) . '</td>';
$tbl.= '<td align="right" style="border-top:1px solid black;">' . number_format($tdisc_val) . '</td>';
$tbl.= '<td align="right" style="border-top:1px solid black;">' . number_format($tpph) . '</td>';
$tbl.='<td colspan="4"></td>';
$tbl.= '</tr>';
$tbl .='</tfoot>';


$tbl .='</table></div>';
?>