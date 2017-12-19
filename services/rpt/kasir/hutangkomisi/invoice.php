<?php

$tbl .= '
<div id="cntr1" align="center">
<table width="100%">
<tr><td valign="top"  align="center"><b style="font-size:1.5em;">' . $comp_name . '</b></td></tr>
<tr><td valign="top"  align="center"><b style="font-size:1.5em;">' . $rptTitle . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.1em;">' . $title . '</b></td></tr>
<tr><td valign="top"  align="center"><b>DATE : ' . dateView($sal_date) . '</b></td></tr>
</table>
';

$tbl .= '<table width="100%"><tr><td valign="top" ></td><td valign="top"  align="right"><b>Printed On: </b>' . date('d/m/Y') . '</td></tr></table>';

$tbl .= '
<table width="100%">
<thead style="border:2px solid black !important;" >
    <tr>
        <td valign="top"  width="120"><b>Invoice Date <br />Invoice No.</b></td>
        <td valign="top"  width="150"><b>Chassis<br />Engine</b></td>
        <td valign="top"  width="90" align="right"><b>Total Invoice</b></td>
        <td valign="top"  width="90" align="right"><b>Beginning<br />Balance</b></td>
        <td valign="top"  width="90" align="right"><b>Purchase</b></td>
        <td valign="top"  width="90" align="right"><b>Payment</b></td>
        <td valign="top"  width="90" align="right"><b>Discount</b></td>
        <td valign="top"  width="90" align="right"><b>Other Tax</b></td>
        <td valign="top"  width="90" align="right"><b>Ending<br />Balance</b></td>
        <td><b>Payment<br />Description</b></td>
    </tr>
</thead>';
$tbl .='<tr><td valign="top" ></td></tr>';

$sinv_code = '';
$i = 0;
$comm_val = 0;
$hd_begin = 0;
$payable = 0;
$hd_paid = 0;
$hd_disc = 0;
$hd_pph = 0;
$hd_end = 0;

$tcomm_val = 0;
$thd_begin = 0;
$tpayable = 0;
$thd_paid = 0;
$thd_disc = 0;
$thd_pph = 0;
$thd_end = 0;

while ($dtlrow = mysql_fetch_array($dtl)) {
    if ($sinv_code != $dtlrow['sinv_code']) {
        if ($i >= 1) {
            $tbl .='<tr>';
            $tbl .='<td colspan="2" align="right"><b>Total ' . $sinv_code . ':</b></td>';
            $tbl .= '<td valign="top"  align="right" style="border-top:1px solid black;">' . number_format($comm_val) . '</td>';
            $tbl .= '<td valign="top"  align="right" style="border-top:1px solid black;">' . number_format($hd_begin) . '</td>';
            $tbl .= '<td valign="top"  align="right" style="border-top:1px solid black;">' . number_format($payable) . '</td>';
            $tbl .= '<td valign="top"  align="right" style="border-top:1px solid black;">' . number_format($hd_paid) . '</td>';
            $tbl .= '<td valign="top"  align="right" style="border-top:1px solid black;">' . number_format($hd_disc) . '</td>';
            $tbl .= '<td valign="top"  align="right" style="border-top:1px solid black;">' . number_format($hd_pph) . '</td>';
            $tbl .= '<td valign="top"  align="right" style="border-top:1px solid black;">' . number_format($hd_end) . '</td>';
            $tbl .='</tr>';

            $i = 0;
            $comm_val = 0;
            $hd_begin = 0;
            $payable = 0;
            $hd_paid = 0;
            $hd_disc = 0;
            $hd_pph = 0;
            $hd_end = 0;
        }

        //$tbl.= '<tr><td colspan="9" align="left"><b style="font-size:1.1em;">*** Invoice Type ' . $dtlrow['pinv_code'] . ' ***</b></td><td valign="top"  width="5" style="border-left:1px solid #000;"></td></tr>';

        $sinv_code = $dtlrow['sinv_code'];
    }


    $sal_date = dateView($dtlrow['sal_date']);

    $begin = $dtlrow['hd_begin'];
    $pay = 0;

    if (intval($dtlrow['hd_paid']) !== 0) {
        $pay = $dtlrow['hd_begin'];
        $begin = 0;
    }

    $hdend = intval($dtlrow['hd_begin']) - intval($dtlrow['hd_paid']) - intval($dtlrow['hd_disc']) - intval($dtlrow['hd_pph']);


    $comm_val += $dtlrow['comm_val'];
    $hd_begin += $begin;
    $payable += $pay;
    $hd_paid += $dtlrow['hd_paid'];
    $hd_disc += $dtlrow['hd_disc'];
    $hd_pph += $dtlrow['hd_pph'];
    $hd_end += $hdend;

    $tcomm_val += $dtlrow['comm_val'];
    $thd_begin += $begin;
    $tpayable += $pay;
    $thd_paid += $dtlrow['hd_paid'];
    $thd_disc += $dtlrow['hd_disc'];
    $thd_pph += $dtlrow['hd_pph'];
    $thd_end += $hdend;


    $tbl .='<tr>';
    $tbl .='<td><b>' . $sal_date . '</b><br />' . $dtlrow['sal_inv_no'] . '</td>';
    $tbl .='<td>' . $dtlrow['chassis'] . '<br />' . $dtlrow['engine'] . '</td>';
    $tbl .= '<td valign="top"  align="right">' . number_format($dtlrow['comm_val']) . '</td>';
    $tbl .= '<td valign="top"  align="right">' . number_format($begin) . '</td>';
    $tbl .= '<td valign="top"  align="right">' . number_format($pay) . '</td>';
    $tbl .= '<td valign="top"  align="right">' . number_format($dtlrow['hd_paid']) . '</td>';
    $tbl .= '<td valign="top"  align="right">' . number_format($dtlrow['hd_disc']) . '</td>';
    $tbl .= '<td valign="top"  align="right">' . number_format($dtlrow['hd_pph']) . '</td>';
    $tbl .= '<td valign="top"  align="right">' . number_format($hdend) . '</td>';
    $tbl .='<td valign="top" >' . $dtlrow['note'] . '</td>';

    $tbl .='</tr>';

    $i++;
    unset($dtlrow);
}

if ($i >= 1) {
    $tbl .='<tr>';
    $tbl .='<td colspan="2" align="right"><b>Total ' . $sinv_code . ':</b></td>';
    $tbl .= '<td valign="top"  align="right" style="border-top:1px solid black;">' . number_format($comm_val) . '</td>';
    $tbl .= '<td valign="top"  align="right" style="border-top:1px solid black;">' . number_format($hd_begin) . '</td>';
    $tbl .= '<td valign="top"  align="right" style="border-top:1px solid black;">' . number_format($payable) . '</td>';
    $tbl .= '<td valign="top"  align="right" style="border-top:1px solid black;">' . number_format($hd_paid) . '</td>';
    $tbl .= '<td valign="top"  align="right" style="border-top:1px solid black;">' . number_format($hd_disc) . '</td>';
    $tbl .= '<td valign="top"  align="right" style="border-top:1px solid black;">' . number_format($hd_pph) . '</td>';
    $tbl .= '<td valign="top"  align="right" style="border-top:1px solid black;">' . number_format($hd_end) . '</td>';
    $tbl .='</tr>';

    $i = 0;
    $comm_val = 0;
    $hd_begin = 0;
    $payable = 0;
    $hd_paid = 0;
    $hd_disc = 0;
    $hd_pph = 0;
    $hd_end = 0;
}

$tbl .= '<tr><td><br /></td></tr>';
$tbl .= '<tfoot style="border:2px solid black !important;">';
$tbl .= '<tr>';
$tbl .= '<td class="border-foot" colspan="2" align="right"><b>Grand Total:</b></td>';
$tbl .= '<td align="right" style="border-top:1px solid black;">' . number_format($tcomm_val) . '</td>';
$tbl .= '<td align="right" style="border-top:1px solid black;">' . number_format($thd_begin) . '</td>';
$tbl .= '<td align="right" style="border-top:1px solid black;">' . number_format($tpayable) . '</td>';
$tbl .= '<td align="right" style="border-top:1px solid black;">' . number_format($thd_paid) . '</td>';
$tbl .= '<td align="right" style="border-top:1px solid black;">' . number_format($thd_disc) . '</td>';
$tbl .= '<td align="right" style="border-top:1px solid black;">' . number_format($thd_pph) . '</td>';
$tbl .= '<td align="right" style="border-top:1px solid black;">' . number_format($thd_end) . '</td>';
$tbl .= '<td></td>';
$tbl .='</tr>';
$tbl .='</tfoot>';
$tbl .='</table>';
