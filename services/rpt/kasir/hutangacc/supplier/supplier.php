<?php

$tbl .= '
<div id="cntr1" align="center">
<table width="95%">
<tr><td valign="top"  align="center"><b style="font-size:1.5em;">' . $comp_name . '</b></td></tr>
<tr><td valign="top"  align="center"><b style="font-size:1.5em;">' . $rptTitle . '</b></td></tr>
<tr><td valign="top"  align="center"><b>DATE : ' . dateView($ap_date) . '</b></td></tr>
</table>
';

$tbl .= '<table width="95%"><tr><td valign="top" ></td><td valign="top"  align="right"><b>Printed On: </b>' . date('d/m/Y') . '</td></tr></table>';

$tbl .= '
<table width="95%">
<thead style="border:2px solid black !important;" >
    <tr>
        <td valign="top"  width="120"><b>Invoice<br />No.</b></td>
        <td valign="top"  width="70"><b>Invoice<br />Date</b></td>
        <td valign="top" width="100"><b>Supplier<br />Invoice No.</b></td>
        <td valign="top" width="70"><b>Supplier<br />Invoice Date</b></td>
        <td valign="top"  width="90" align="right"><b>Total Invoice</b></td>
        <td valign="top"  width="90" align="right"><b>Beginning<br />Balance</b></td>
        <td valign="top"  width="90" align="right"><b>Purchase</b></td>
        <td valign="top"  width="90" align="right"><b>Payment</b></td>
        <td valign="top"  width="90" align="right"><b>Discount</b></td>
        <td valign="top"  width="90" align="right"><b>Ending<br />Balance</b></td>
        <td valign="top" ><b>Note</b></td>
        <td valign="top"  width="70"><b>Due Date</b></td>
    </tr>
</thead>';
$tbl .='<tr><td valign="top" ></td></tr>';
$i = 0;
$j = 0;
$last_supp_code = '';
$last_supp_name = '';

$inv_total = 0;
$hd_begin = 0;
$hd_purprice = 0;
$hd_paid = 0;
$hd_disc = 0;
$hd_end = 0;

$tinv_total = 0;
$thd_begin = 0;
$thd_purprice = 0;
$thd_paid = 0;
$thd_disc = 0;
$thd_end = 0;

$dat = strtotime($ap_date);

while ($dtlrow = mysql_fetch_array($dtl)) {
    $purdate = strtotime($dtlrow['pur_date']);
    $purexp = explode('-', $dtlrow['pur_date']);
    $purperiode = $purexp[0] . $purexp[1];

    if ($rpt_by == '1') {
        if ($purperiode == $periode) {
            $dtlrow['hd_purprice'] = $dtlrow['hd_begin'];
            $dtlrow['hd_begin'] = 0;
        } else {
            //$dtlrow['pd_begin'] = $dtlrow['pd_begin']- $dtlrow['pd_paid'];
            $dtlrow['hd_purprice'] = 0;
        }

        if ($dtlrow['hd_purprice'] !== 0) {
            $dtlrow['hd_end'] = $dtlrow['hd_purprice'] - $dtlrow['hd_paid'] - $dtlrow['hd_disc'];
        }
        if ($dtlrow['hd_begin'] !== 0) {
            $dtlrow['hd_end'] = $dtlrow['hd_begin'] - $dtlrow['hd_paid'] - $dtlrow['hd_disc'];
        }
    }

    $tinv_total += $dtlrow['inv_total'];
    $thd_begin += $dtlrow['hd_begin'];
    $thd_purprice += $dtlrow['hd_purprice'];
    $thd_paid += $dtlrow['hd_paid'];
    $thd_disc += $dtlrow['hd_disc'];
    $thd_end += $dtlrow['hd_end'];

    if ($last_supp_code != $dtlrow['supp_code']) {
        if ($i >= 1) {

            $tbl .= '<tr>';
            $tbl .= '<td valign="top"  colspan="4" align="right"><b>' . $last_supp_code . ' : ' . $last_supp_name . ':</b></td>';
            $tbl .= '<td valign="top"  align="right" style="border-top:1px solid black;">' . number_format($inv_total) . '</td>';
            $tbl .= '<td valign="top"  align="right" style="border-top:1px solid black;">' . number_format($hd_begin) . '</td>';
            $tbl .= '<td valign="top"  align="right" style="border-top:1px solid black;">' . number_format($hd_purprice) . '</td>';
            $tbl .= '<td valign="top"  align="right" style="border-top:1px solid black;">' . number_format($hd_paid) . '</td>';
            $tbl .= '<td valign="top"  align="right" style="border-top:1px solid black;">' . number_format($hd_disc) . '</td>';
            $tbl .= '<td valign="top"  align="right" style="border-top:1px solid black;">' . number_format($hd_end) . '</td>';
            $tbl .= '</tr>';

            $tbl .='<tr><td valign="top" ></td></tr>';
            $tbl .='<tr><td valign="top" ></td></tr>';
            $inv_total = 0;
            $hd_begin = 0;
            $hd_purprice = 0;
            $hd_paid = 0;
            $hd_disc = 0;
            $hd_end = 0;
            $i = 0;
        }

        $tbl.= '<tr><td valign="top" colspan="11" align="left"><b style="font-size:1.1em;">*** Supplier ' . $dtlrow['supp_code'] . ' : ' . $dtlrow['supp_name'] . ' ***</b></td></tr>';

        $last_supp_code = $dtlrow['supp_code'];
        $last_supp_name = $dtlrow['supp_name'];
    }

    $inv_total += $dtlrow['inv_total'];
    $hd_begin += $dtlrow['hd_begin'];
    $hd_purprice += $dtlrow['hd_purprice'];
    $hd_paid += $dtlrow['hd_paid'];
    $hd_disc += $dtlrow['hd_disc'];
    $hd_end += $dtlrow['hd_end'];

    $pur_date = dateView($dtlrow['pur_date']);
    $due_date = dateView($dtlrow['due_date']);
    $supp_invdt = dateView($dtlrow['supp_invdt']);

    $tbl .= '<tr>';
    $tbl .= '<td valign="top" >' . $pur_date . '</td>';
    $tbl .= '<td valign="top" >' . $dtlrow['pur_inv_no'] . '</td>';
    $tbl .= '<td valign="top" >' . $dtlrow['supp_invno'] . '</td>';
    $tbl .= '<td valign="top" >' . $supp_invdt . '</td>';
    $tbl .= '<td valign="top"  align="right">' . number_format($dtlrow['inv_total']) . '</td>';
    $tbl .= '<td valign="top"  align="right">' . number_format($dtlrow['hd_begin']) . '</td>';
    $tbl .= '<td valign="top"  align="right">' . number_format($dtlrow['hd_purprice']) . '</td>';
    $tbl .= '<td valign="top"  align="right">' . number_format($dtlrow['hd_paid']) . '</td>';
    $tbl .= '<td valign="top"  align="right">' . number_format($dtlrow['hd_disc']) . '</td>';
    $tbl .= '<td valign="top"  align="right">' . number_format($dtlrow['hd_end']) . '</td>';
    $tbl .= '<td valign="top" >' . $dtlrow['note'] . '</td>';
    $tbl .= '<td valign="top" >' . $due_date . '</td>';
    $tbl .= '</tr>';

    $i++;
    $j++;
    unset($dtlrow);
}


if ($last_supp_code != $dtlrow['supp_code']) {
    if ($i >= 1) {

        $tbl .= '<tr>';
        $tbl .= '<td valign="top"  colspan="4" align="right"><b>' . $last_supp_code . ' : ' . $last_supp_name . ':</b></td>';
        $tbl .= '<td valign="top"  align="right" style="border-top:1px solid black;">' . number_format($inv_total) . '</td>';
        $tbl .= '<td valign="top"  align="right" style="border-top:1px solid black;">' . number_format($hd_begin) . '</td>';
        $tbl .= '<td valign="top"  align="right" style="border-top:1px solid black;">' . number_format($hd_purprice) . '</td>';
        $tbl .= '<td valign="top"  align="right" style="border-top:1px solid black;">' . number_format($hd_paid) . '</td>';
        $tbl .= '<td valign="top"  align="right" style="border-top:1px solid black;">' . number_format($hd_disc) . '</td>';
        $tbl .= '<td valign="top"  align="right" style="border-top:1px solid black;">' . number_format($hd_end) . '</td>';
        $tbl .= '</tr>';

        $tbl .='<tr><td valign="top" ></td></tr>';
        $tbl .='<tr><td valign="top" ></td></tr>';
        $inv_total = 0;
        $hd_begin = 0;
        $hd_purprice = 0;
        $hd_paid = 0;
        $hd_disc = 0;
        $hd_end = 0;
        $i = 0;
    }

}

$tbl.='<tr><td valign="top" ><br /></td></tr>';

$tbl .='<tfoot>';
$tbl .= '<tr>';
$tbl .= '<td colspan="2"></td>';
$tbl .= '<td class="border-foot" colspan="2" style="border-left:2px solid black;border-top:2px solid black;border-bottom:2px solid black;" valign="top" align="right"><b>GRAND TOTAL :</b></td>';
$tbl .= '<td class="border-foot" style="border-top:2px solid black;border-bottom:2px solid black;" valign="top"  align="right"><b>' . number_format($tinv_total) . '</b></td>';
$tbl .= '<td class="border-foot" style="border-top:2px solid black;border-bottom:2px solid black;" valign="top"  align="right"><b>' . number_format($thd_begin) . '</b></td>';
$tbl .= '<td class="border-foot" style="border-top:2px solid black;border-bottom:2px solid black;" valign="top"  align="right"><b>' . number_format($thd_purprice) . '</b></td>';
$tbl .= '<td class="border-foot" style="border-top:2px solid black;border-bottom:2px solid black;" valign="top"  align="right"><b>' . number_format($thd_paid) . '</b></td>';
$tbl .= '<td class="border-foot" style="border-top:2px solid black;border-bottom:2px solid black;" valign="top"  align="right"><b>' . number_format($thd_disc) . '</b></td>';
$tbl .= '<td class="border-foot" style="border-right:2px solid black;border-top:2px solid black;border-bottom:2px solid black;" valign="top"  align="right"><b>' . number_format($thd_end) . '</b></td>';
$tbl .= '</tr>';
$tbl .='</tfoot>';

$tbl .='</table>';
