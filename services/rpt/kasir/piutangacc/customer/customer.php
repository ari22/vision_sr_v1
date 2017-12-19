<?php

$tbl .= '
<div id="cntr1" align="center">
<table width="90%">
<tr><td valign="top"  align="center"><b style="font-size:1.5em;">' . $comp_name . '</b></td></tr>
<tr><td valign="top"  align="center"><b style="font-size:1.5em;">' . $rptTitle . '</b></td></tr>
<tr><td valign="top"  align="center"><b>DATE : ' . dateView($ar_date) . '</b></td></tr>
</table>
';

$tbl .= '<table width="90%"><tr><td valign="top" ></td><td valign="top"  align="right"><b>Printed On: </b>' . date('d/m/Y') . '</td></tr></table>';

$tbl .= '
<table width="90%">
<thead style="border:2px solid black !important;">
    <tr>
        <td valign="top"  width="70"><b>Invoice<br />Date</b></td>
        <td valign="top"  width="120"><b>Invoice No.</b></td>
        <td valign="top"  width="90" align="right"><b>Total Invoice</b></td>
        <td valign="top"  width="90" align="right"><b>Beginning<br />Balance</b></td>
        <td valign="top"  width="90" align="right"><b>Sale</b></td>
        <td valign="top"  width="90" align="right"><b>Payment</b></td>
        <td valign="top"  width="90" align="right"><b>Discount</b></td>
        <td valign="top"  width="90" align="right"><b>Ending<br />Balance</b></td>
        <td valign="top" ><b>Note</b></td>
        <td valign="top"  width="70"><b>Due Date</b></td>
    </tr>
</thead>';
$tbl .='<tr><td valign="top" ><br /></td></tr>';
$i = 0;
$j = 0;
$last_cust_code = '';
$last_cust_name = '';

$inv_total = 0;
$pd_begin = 0;
$veh_total = 0;
$pd_paid = 0;
$pd_disc = 0;
$pd_end = 0;

$tinv_total = 0;
$tpd_begin = 0;
$tveh_total = 0;
$tpd_paid = 0;
$tpd_disc = 0;
$tpd_end = 0;

$dat = strtotime($ar_date);

while ($dtlrow = mysql_fetch_array($dtl)) {

    $saldate = strtotime($dtlrow['sal_date']);
    $salexp = explode('-', $dtlrow['sal_date']);
    $salperiode = $salexp[0] . $salexp[1];

    if ($rpt_by == '1') {
        if ($salperiode == $periode) {
            $dtlrow['veh_total'] = $dtlrow['pd_begin'];
            $dtlrow['pd_begin'] = 0;
        } else {
            //$dtlrow['pd_begin'] = $dtlrow['pd_begin']- $dtlrow['pd_paid'];
            $dtlrow['veh_total'] = 0;
        }

        if ($dtlrow['veh_total'] !== 0) {
            $dtlrow['pd_end'] = $dtlrow['veh_total'] - $dtlrow['pd_paid'] - $dtlrow['pd_disc'];
        }
        if ($dtlrow['pd_begin'] !== 0) {
            $dtlrow['pd_end'] = $dtlrow['pd_begin'] - $dtlrow['pd_paid'] - $dtlrow['pd_disc'];
        }
    }


    $tinv_total += $dtlrow['inv_total'];
    $tpd_begin += $dtlrow['pd_begin'];
    $tveh_total += $dtlrow['veh_total'];
    $tpd_paid += $dtlrow['pd_paid'];
    $tpd_disc += $dtlrow['pd_disc'];
    $tpd_end += $dtlrow['pd_end'];

    if ($last_cust_code != $dtlrow['cust_code']) {
        if ($i >= 1) {

            $tbl .= '<tr>';
            $tbl .= '<td valign="top"  colspan="2" align="right"><b>TOTAL CUSTOMER ' . $last_cust_code . ':</b></td>';
            $tbl .= '<td valign="top"  align="right" style="border-top:1px solid black;">' . number_format($inv_total) . '</td>';
            $tbl .= '<td valign="top"  align="right" style="border-top:1px solid black;">' . number_format($pd_begin) . '</td>';
            $tbl .= '<td valign="top"  align="right" style="border-top:1px solid black;">'. number_format($veh_total).'</td>';
            $tbl .= '<td valign="top"  align="right" style="border-top:1px solid black;">' . number_format($pd_paid) . '</td>';
            $tbl .= '<td valign="top"  align="right" style="border-top:1px solid black;">' . number_format($pd_disc) . '</td>';
            $tbl .= '<td valign="top"  align="right" style="border-top:1px solid black;">' . number_format($pd_end) . '</td>';
            $tbl .= '</tr>';

            $tbl .='<tr><td valign="top" ></td></tr>';
            $tbl .='<tr><td valign="top" ></td></tr>';
            
            $inv_total = 0;
            $pd_begin = 0;
            $veh_total = 0;
            $pd_paid = 0;
            $pd_disc = 0;
            $pd_end = 0;

            $i = 0;
        }

        $tbl.= '<tr><td valign="top" colspan="11" align="left"><b style="font-size:1.1em;">*** Customer ' . $dtlrow['cust_code'] . ' : ' . $dtlrow['cust_name'] . ' ***</b></td></tr>';
        $last_cust_code = $dtlrow['cust_code'];
        $last_cust_name = $dtlrow['cust_name'];
    }

    $inv_total += $dtlrow['inv_total'];
    $pd_begin += $dtlrow['pd_begin'];
    $veh_total += $dtlrow['veh_total'];
    $pd_paid += $dtlrow['pd_paid'];
    $pd_disc += $dtlrow['pd_disc'];
    $pd_end += $dtlrow['pd_end'];

    $sal_date = dateView($dtlrow['sal_date']);
    $due_date = dateView($dtlrow['due_date']);

    $tbl .= '<tr>';
    $tbl .= '<td valign="top" >' . $sal_date . '</td>';
    $tbl .= '<td valign="top" >' . $dtlrow['sal_inv_no'] . '</td>';
    $tbl .= '<td valign="top"  align="right">' . number_format($dtlrow['inv_total']) . '</td>';
    $tbl .= '<td valign="top"  align="right">' . number_format($dtlrow['pd_begin']) . '</td>';
    $tbl .= '<td valign="top"  align="right">' . number_format($dtlrow['veh_total']) . '</td>';
    $tbl .= '<td valign="top"  align="right">' . number_format($dtlrow['pd_paid']) . '</td>';
    $tbl .= '<td valign="top"  align="right">' . number_format($dtlrow['pd_disc']) . '</td>';
    $tbl .= '<td valign="top"  align="right">' . number_format($dtlrow['pd_end']) . '</td>';
    $tbl .= '<td valign="top" >' . $dtlrow['note'] . '</td>';
    $tbl .= '<td valign="top" >' . $due_date . '</td>';
    $tbl .= '</tr>';

    $i++;
    $j++;
    unset($dtlrow);
}

    if ($last_cust_code != $dtlrow['cust_code']) {
        if ($i >= 1) {

            $tbl .= '<tr>';
            $tbl .= '<td valign="top"  colspan="2" align="right"><b>TOTAL CUSTOMER ' . $last_cust_code . ':</b></td>';
            $tbl .= '<td valign="top"  align="right" style="border-top:1px solid black;">' . number_format($inv_total) . '</td>';
            $tbl .= '<td valign="top"  align="right" style="border-top:1px solid black;">' . number_format($pd_begin) . '</td>';
            $tbl .= '<td valign="top"  align="right" style="border-top:1px solid black;">'. number_format($veh_total).'</td>';
            $tbl .= '<td valign="top"  align="right" style="border-top:1px solid black;">' . number_format($pd_paid) . '</td>';
            $tbl .= '<td valign="top"  align="right" style="border-top:1px solid black;">' . number_format($pd_disc) . '</td>';
            $tbl .= '<td valign="top"  align="right" style="border-top:1px solid black;">' . number_format($pd_end) . '</td>';
            $tbl .= '</tr>';

            $tbl .='<tr><td valign="top" ></td></tr>';
            $tbl .='<tr><td valign="top" ></td></tr>';
            
            $inv_total = 0;
            $pd_begin = 0;
            $veh_total = 0;
            $pd_paid = 0;
            $pd_disc = 0;
            $pd_end = 0;

            $i = 0;
        }

    }

$tbl.='<tr><td valign="top" ><br /></td></tr>';

$tbl .='<tfoot>';
$tbl .= '<tr><td></td>';
$tbl .= '<td class="border-foot" style="border-left:2px solid black;border-top:2px solid black;border-bottom:2px solid black;" valign="top" align="right"><b>GRAND TOTAL :</b></td>';
$tbl .= '<td class="border-foot" style="border-top:2px solid black;border-bottom:2px solid black;" valign="top"  align="right"><b>' . number_format($tinv_total) . '</b></td>';
$tbl .= '<td class="border-foot" style="border-top:2px solid black;border-bottom:2px solid black;" valign="top"  align="right"><b>' . number_format($tpd_begin) . '</b></td>';
$tbl .= '<td class="border-foot" style="border-top:2px solid black;border-bottom:2px solid black;" valign="top"  align="right"><b>' . number_format($tveh_total) . '</b></td>';
$tbl .= '<td class="border-foot" style="border-top:2px solid black;border-bottom:2px solid black;" valign="top"  align="right"><b>' . number_format($tpd_paid) . '</b></td>';
$tbl .= '<td class="border-foot" style="border-top:2px solid black;border-bottom:2px solid black;" valign="top"  align="right"><b>' . number_format($tpd_disc) . '</b></td>';
$tbl .= '<td class="border-foot" style="border-right:2px solid black;border-top:2px solid black;border-bottom:2px solid black;" valign="top"  align="right"><b>' . number_format($tpd_end) . '</b></td>';
$tbl .= '</tr>';
$tbl .='</tfoot>';
$tbl .='</table>';
