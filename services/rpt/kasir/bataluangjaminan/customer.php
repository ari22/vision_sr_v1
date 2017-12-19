<?php
$tbl .= '
<div id="cntr1" align="center">
<table width="100%">
<tr><td valign="top" align="center"><b style="font-size:1.5em;">'.$comp_name.'</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.5em;">'.$rptTitle.'</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.1em;">'.$title.'</b></td></tr>
<tr><td valign="top" align="center"><b>DATE : '.dateView($opn_date1).' UP TO '.dateView($opn_date2).'</b></td></tr>
</table>
';


$tbl .= '
<table width="100%"  >
<tr>
<td valign="top" valign="top"></td>
<td valign="top" align="right"><b>Printed On: </b>' . date('d/m/Y') . '</td>
</tr>
</table>';

$tbl .= '<table width="100%" >';
$tbl .= '<thead style="border:2px solid black !important;">
           <tr>
                <td valign="top" width="90"><b>Invoice Date</b></td>
                <td valign="top" width="120"><b>Invoice No.</b></td>
                <td valign="top" width="120"><b>DP Invoice No.</b></td>
                <td valign="top" width="90"><b>DP Invoice Date</b></td>
                <td valign="top" width="120"><b>Check No.</b></td>
                <td valign="top" width="90"><b>Check Date</b></td>
                <td valign="top" width="90"><b>Payment Date</b></td>
                <td valign="top" width="90"><b>Due Date</b></td>
                <td valign="top" width="120" align="right"><b>DP</b></td>
                <td valign="top" width="50"></td>
                <td valign="top" width="100"><b>Payment Type</b></td>
                <td valign="top" width="90"><b>Bank</b></td>
                <td valign="top" width="90"><b>EDC</b></td>
                <td valign="top" width="120"><b>Note</b></td>
                <td valign="top" width="100"><b>Payment By</b></td>
            </tr>
        </thead>';

$tbl .= '<tr><td valign="top" valign="top"></td></tr>';

$i = 0;
$j = 0;
$nominal = 0;
$tnominal = 0;

$last_cust_code = '';
$last_cust_name = '';

while ($dtlrow = mysql_fetch_array($dtl)) {
    $tnominal += $dtlrow['inv_at'];
    if ($last_cust_code != $dtlrow['cust_code']) {
        if ($j >= 1) {

            $tbl .= '<tr>';
            $tbl .= '<td valign="top" width="90"></td>';
            $tbl .= '<td valign="top" width="120"></td>';
            $tbl .= '<td valign="top" width="120"></td>';
            $tbl .= '<td valign="top" width="90"></td>';
            $tbl .= '<td valign="top" width="120"></td>';
            $tbl .= '<td valign="top" width="90"></td>';
            $tbl .= '<td valign="top"  colspan="2" width="180" align="right"><b>Total Payment ' . $last_cust_code . ':</b></td>';
            $tbl .= '<td valign="top" width="120" align="right" style="border-top:1px solid #000;"> <b>' . number_format($nominal) . '</b></td>';
            $tbl .= '<td valign="top" width="50"></td>';
            $tbl .= '<td valign="top" width="100"></td>';
            $tbl .= '<td valign="top" width="90"></td>';
            $tbl .= '<td valign="top" width="90"></td>';
            $tbl .= '<td valign="top" width="120"></td>';
            $tbl .= '<td valign="top" width="100"></td>';
            $tbl .= '</tr>';

            $j = 0;
            $nominal = 0;
        }


        $tbl.= '<tr><td valign="top" colspan="15" align="left"><b style="font-size:1.1em;">***' . $dtlrow['cust_code'] . ' : ' . $dtlrow['cust_name'] . '***</b></td></tr>';
        $last_cust_code = $dtlrow['cust_code'];
        $last_cust_name = $dtlrow['cust_name'];
    }

    $nominal += $dtlrow['inv_at'];

    $dpc_date = dateView($dtlrow['dpc_date']);
    $dp_date = dateView($dtlrow['dp_date']);
    $check_date = dateView($dtlrow['check_date']);
    $due_date = dateView($dtlrow['due_date']);
    $pay_date = dateView($dtlrow['pay_date']);

    $tbl .= '<tr>';
    $tbl .= '<td valign="top" width="90">' . $dpc_date . '</td>';
    $tbl .= '<td valign="top" width="120">' . $dtlrow['dpc_inv_no'] . '</td>';
    $tbl .= '<td valign="top" width="120">' . $dtlrow['dp_inv_no'] . '</td>';
    $tbl .= '<td valign="top" width="90">' . $dp_date . '</td>';
    $tbl .= '<td valign="top" width="120">' . $dtlrow['check_no'] . '</td>';
    $tbl .= '<td valign="top" width="90">' . $check_date . '</td>';
    $tbl .= '<td valign="top" width="90">' . $pay_date . '</td>';
    $tbl .= '<td valign="top" width="90">' . $due_date . '</td>';
    $tbl .= '<td valign="top" width="120" align="right">' . number_format($dtlrow['inv_at']) . '</td>';
    $tbl .= '<td valign="top" width="50"></td>';
    $tbl .= '<td valign="top" width="100">' . $dtlrow['pay_type'] . '</td>';
    $tbl .= '<td valign="top" width="90">' . $dtlrow['bank_code'] . '</td>';
    $tbl .= '<td valign="top" width="90">' . $dtlrow['edc_code'] . '</td>';
    $tbl .= '<td valign="top" width="120">' . $dtlrow['note'] . '</td>';
    $tbl .= '<td valign="top" width="100">' . $dtlrow['payer_name'] . '</td>';
    $tbl .= '</tr>';


    $i++;
    $j++;

    unset($dtlrow);
}

if ($j >= 1) {

    $tbl .= '<tr>';
    $tbl .= '<td valign="top" width="90"></td>';
    $tbl .= '<td valign="top" width="120"></td>';
    $tbl .= '<td valign="top" width="120"></td>';
    $tbl .= '<td valign="top" width="90"></td>';
    $tbl .= '<td valign="top" width="120"></td>';
    $tbl .= '<td valign="top" width="90"></td>';
    $tbl .= '<td valign="top"  colspan="2" width="180" align="right"><b>Total Payment ' . $last_cust_code . ':</b></td>';
    $tbl .= '<td valign="top" width="120" align="right"  style="border-top:1px solid #000;"> <b>' . number_format($nominal) . '</b></td>';
    $tbl .= '<td valign="top" width="50"></td>';
    $tbl .= '<td valign="top" width="100"></td>';
    $tbl .= '<td valign="top" width="90"></td>';
    $tbl .= '<td valign="top" width="90"></td>';
    $tbl .= '<td valign="top" width="120"></td>';
    $tbl .= '<td valign="top" width="100"></td>';
    $tbl .= '</tr>';

    $j = 0;
    $nominal = 0;
}

$tbl .= '<tr><td valign="top" valign="top"><br /></td></tr>'
        . '<tfoot ><tr>';
$tbl .='<td colspan="7"></td>';
$tbl .= '<td class="border-foot" style="border-left:2px solid black;border-top:2px solid black;border-bottom:2px solid black;" valign="top" width="240" align="right"><b>Total Cancelation DP:</b></td>';
$tbl .= '<td class="border-foot" style="border-right:2px solid black;border-top:2px solid black;border-bottom:2px solid black;" valign="top" width="120" align="right"> <b>' . number_format($tnominal) . '</b></td>';
$tbl .= '</tr></tfoot>';

$tbl .= '</table>';
