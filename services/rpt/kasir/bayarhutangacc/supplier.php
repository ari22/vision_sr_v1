<?php

$tbl .= '
<div id="cntr1" align="center">
<table width="80%">
<tr><td valign="top"  align="center"><b style="font-size:1.5em;">' . $comp_name . '</b></td></tr>
<tr><td valign="top"  align="center"><b style="font-size:1.5em;">' . $rptTitle . ' : ' . $title . '</b></td></tr>
<tr><td valign="top"  align="center"><b>DATE : ' . $date1 . ' UP TO ' . $date2 . '</b></td></tr>
</table>
';

$tbl .= '<table width="80%"><tr><td valign="top" ></td><td valign="top"  align="right"><b>Printed On: </b>' . date('d/m/Y') . '</td></tr></table>';
$tbl .= '
<table width="80%">
<thead style="border:2px solid black !important;">
    <tr>
        <td valign="top"><b>Payment<br />Date</b></td>
        <td valign="top"><b>Invoice No.</b></td>
        <td valign="top"><b>Invoice Date</b></td>
        <td valign="top"><b>Supplier<br />Invoice No.</b></td>
        <td valign="top" align="right"><b>Payment</b></td>
        <td valign="top" align="right"><b>Discount</b></td>
        <td valign="top"><b>Payment<br />Type</b></td>
        <td valign="top"><b>Check No.</b></td>
        <td valign="top"><b>Check Date</b></td>
        <td valign="top"><b>Due Date</b></td>
        <td valign="top"><b>Note</b></td>
        <td valign="top"><b>Added<br />By</b></td>
    </tr>
</thead>';

$i = 0;
$j = 0;
$last_supp_code = '';
$last_supp_name = '';

$pay_val = 0;
$disc_val = 0;
$pay_val2 = 0;
$disc_val2 = 0;
$pay_date2 = '';

$tpay_val = 0;
$tdisc_val = 0;

while ($dtlrow = mysql_fetch_array($dtl)) {
    $tpay_val += $dtlrow['pay_val'];
    $tdisc_val += $dtlrow['disc_val'];

    $pay_date2 = dateView($dtlrow['pay_date']);
    
    if ($last_supp_code != $dtlrow['supp_code']) {
        
        if ($pay_date2 != $dtlrow['pay_date']) {
            $tbl .= '<tr>';
            $tbl .= '<td valign="top"  colspan="4" align="right">Total Date : ' . $pay_date2 . ':</td>';
            $tbl .= '<td valign="top"  align="right" style="border-top:1px solid black;">' . number_format($pay_val) . '</td>';
            $tbl .= '<td valign="top"  align="right" style="border-top:1px solid black;">' . number_format($disc_val) . '</td>';
            $tbl .= '</tr>';
            
            $pay_val2 = 0;
            $disc_val2 = 0;
            $j = 0;
            
        }

        if ($i >= 1) {
            $tbl .= '<tr>';
            $tbl .= '<td valign="top"  colspan="4" align="right"><b>Payment Total ' . $last_supp_code . ':</b></td>';
            $tbl .= '<td valign="top"  align="right" style="border-top:2px solid black;">' . number_format($pay_val) . '</td>';
            $tbl .= '<td valign="top"  align="right" style="border-top:2px solid black;">' . number_format($disc_val) . '</td>';
            $tbl .= '</tr>';
            $pay_val = 0;
            $disc_val = 0;
            $i = 0;
        }

        
        $tbl .='<tr><td></td></tr>';

        $tbl.= '<tr><td colspan="11" align="left"><b style="font-size:1.1em;">*** ' . $dtlrow['supp_code'] . ' : ' . $dtlrow['supp_name'] . ' ***</b></td></tr>';
        $last_supp_code = $dtlrow['supp_code'];
        $last_supp_name = $dtlrow['supp_name'];
        
    }

   
    
    $pay_val += $dtlrow['pay_val'];
    $disc_val += $dtlrow['disc_val'];
    $pay_val2 += $dtlrow['pay_val'];
    $disc_val2 += $dtlrow['disc_val'];

    $pur_date = dateView($dtlrow['pur_date']);
    $pay_date = dateView($dtlrow['pay_date']);
    $check_date = dateView($dtlrow['check_date']);
    $due_date = dateView($dtlrow['due_date']);

    $tbl .='<tr>';
    $tbl .='<td valign="top">' . $pay_date . '</td>';
    $tbl .='<td valign="top">' . $dtlrow['pur_inv_no'] . '</td>';
    $tbl .='<td valign="top">' . $pur_date . '</td>';
    $tbl .='<td valign="top">' . $dtlrow['supp_invno'] . '</td>';
    $tbl .='<td valign="top"  align="right">' . number_format($dtlrow['pay_val']) . '</td>';
    $tbl .='<td valign="top"  align="right">' . number_format($dtlrow['disc_val']) . '</td>';
    $tbl .='<td valign="top">' . $dtlrow['pay_type'] . '</td>';
    $tbl .='<td valign="top">' . $dtlrow['check_no'] . '</td>';
    $tbl .='<td valign="top">' . $check_date . '</td>';
    $tbl .='<td valign="top">' . $due_date . '</td>';
    $tbl .='<td valign="top">' . $dtlrow['note'] . '</td>';
    $tbl .='<td valign="top">' . $dtlrow['add_by'] . '</td>';
    $tbl .='</tr>';

    $i++;
    $j++;
    unset($dtlrow);
}



if ($pay_date2 != $dtlrow['pay_date']) {
    $tbl .= '<tr>';
    $tbl .= '<td valign="top"  colspan="4" align="right">Total Date : ' . $pay_date2 . ':</td>';
    $tbl .= '<td valign="top"  align="right" style="border-top:1px solid black;">' . number_format($pay_val) . '</td>';
    $tbl .= '<td valign="top"  align="right" style="border-top:1px solid black;">' . number_format($disc_val) . '</td>';
    $tbl .= '</tr>';
    $pay_val2 = 0;
    $disc_val2 = 0;
    $j = 0;
    
}

if ($i >= 1) {
    $tbl .= '<tr>';
    $tbl .= '<td valign="top"  colspan="4" align="right"><b>Payment Total ' . $last_supp_code . ':</b></td>';
    $tbl .= '<td valign="top"  align="right" style="border-top:2px solid black;">' . number_format($pay_val) . '</td>';
    $tbl .= '<td valign="top"  align="right" style="border-top:2px solid black;">' . number_format($disc_val) . '</td>';
    $tbl .= '</tr>';
    $pay_val = 0;
    $disc_val = 0;
    $i = 0;
}


$tbl .= '<tr><td><br /></td></tr>';
$tbl .= '<tr>';
$tbl .= '<td class="border-foot" valign="top"  colspan="4" align="right"><b>GRAND TOTAL :</b></td>';
$tbl .= '<td class="border-foot" valign="top"  align="right" style="border-top:2px solid black;">' . number_format($tpay_val) . '</td>';
$tbl .= '<td class="border-foot" valign="top"  align="right" style="border-top:2px solid black;">' . number_format($tdisc_val) . '</td>';
$tbl .= '</tr>';

$tbl .='</table>';
?>