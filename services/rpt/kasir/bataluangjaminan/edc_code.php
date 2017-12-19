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

$tbl .= '<table width="100%">';
$tbl .= '<thead style="border:2px solid black !important;">';
$tbl .= '<tr>';
$tbl .= '<td valign="top" width="90"><b>Invoice<br />Date</b></td>';
$tbl .= '<td valign="top" width="120"><b>Invoice No.</b></td>';
$tbl .= '<td valign="top" width="120"><b>DP Invoice No.</b></td>';
$tbl .= '<td valign="top" width="90"><b>DP Invoice Date</b></td>';
$tbl .= '<td valign="top" width="90"><b>Customer Code</b></td>';
$tbl .= '<td valign="top" width="150"><b>Customer Name</b></td>';
$tbl .= '<td valign="top" width="120"><b>Check No.</b></td>';
$tbl .= '<td valign="top" width="90"><b>Check Date</b></td>';
$tbl .= '<td valign="top" width="100"><b>Payment Date</b></td>';
$tbl .= '<td valign="top" width="90"><b>Due Date</b></td>';
$tbl .= '<td valign="top" width="120"><b>DP</b></td>';
$tbl .= '<td valign="top" width="120"><b>Payment Type</b></td>';
$tbl .= '<td valign="top" width="90"><b>Bank</b></td>';
$tbl .= '<td valign="top" width="150"><b>Note</b></td>';
$tbl .= '<td valign="top" width="120"><b>Payment By</b></td>';
$tbl .= '</tr>';
$tbl .= '</thead>';

$i = 0;
$j = 0;
$nominal = 0;
$tnominal = 0;

$edc_code = '';

$tbl .= '<tr><td valign="top" valign="top"></td></tr>';
while ($dtlrow = mysql_fetch_array($dtl)) {

    $tnominal += $dtlrow['inv_at'];

    if ($edc_code != $dtlrow['edc_code']) {

        if ($j >= 1) {
            $tbl .='<tr>';
            $tbl .='<td valign="top" width="90"></td>';
            $tbl .='<td valign="top" width="120"></td>';
            $tbl .='<td valign="top" width="120"></td>';
            $tbl .='<td valign="top" width="90"></td>';
            $tbl .='<td valign="top" width="90"></td>';
            $tbl .='<td valign="top" width="150"></td>';
            $tbl .='<td valign="top" width="120"></td>';
            $tbl .='<td valign="top" width="90"></td>';
            $tbl .='<td valign="top" width="90"></td>';
            $tbl .='<td valign="top" width="90">Total EDC ' . $edc_code . ':</td>';
            $tbl .= '<td valign="top" width="120" align="right" style="border-top:1px solid #000;"><b>' . number_format($nominal) . '</b></td>';
            $tbl .='<td valign="top" width="120"></td>';
            $tbl .='<td valign="top" width="90"></td>';
            $tbl .='<td valign="top" width="150"></td>';
            $tbl .='<td valign="top" width="120"></td>';
            $tbl .='</tr>';

            $j = 0;
            $nominal = 0;
        }
        $tbl.= '<tr><td valign="top" colspan="15" align="left"><b style="font-size:1.1em;">*** EDC: ' . $dtlrow['edc_code'] . '***</b></td></tr>';
        $edc_code = $dtlrow['edc_code'];
    }

    $nominal += $dtlrow['inv_at'];

    $dpc_date = dateView($dtlrow['dpc_date']);
    $dp_date = dateView($dtlrow['dp_date']);
    $check_date = dateView($dtlrow['check_date']);
    $due_date = dateView($dtlrow['due_date']);
    $pay_date = dateView($dtlrow['pay_date']);
    
    $tbl .='<tr>';
    $tbl .='<td valign="top" width="90">' . $dpc_date . '</td>';
    $tbl .='<td valign="top" width="120">' . $dtlrow['dpc_inv_no'] . '</td>';
    $tbl .='<td valign="top" width="120">' . $dtlrow['dp_inv_no'] . '</td>';
    $tbl .='<td valign="top" width="90">' . $dp_date . '</td>';
    $tbl .='<td valign="top" width="90">' . $dtlrow['cust_code'] . '</td>';
    $tbl .='<td valign="top" width="150">' . $dtlrow['cust_name'] . '</td>';
    $tbl .='<td valign="top" width="120">' . $dtlrow['check_no'] . '</td>';
    $tbl .='<td valign="top" width="90">' . $check_date . '</td>';
    $tbl .='<td valign="top" width="90">' . $pay_date . '</td>';
    $tbl .='<td valign="top" width="90">' . $due_date . '</td>';
    $tbl .='<td valign="top" width="120" align="right">' . number_format($dtlrow['inv_at']) . '</td>';
    $tbl .='<td valign="top" width="120">' . $dtlrow['pay_type'] . '</td>';
    $tbl .='<td valign="top" width="90">' . $dtlrow['bank_code'] . '</td>';
    $tbl .='<td valign="top" width="150">' . $dtlrow['note'] . '</td>';
    $tbl .='<td valign="top" width="120">' . $dtlrow['payer_name'] . '</td>';

    $tbl .='</tr>';

    $i++;
    $j++;

    unset($dtlrow);
}

if ($j >= 1) {
    $tbl .='<tr>';
    $tbl .='<td valign="top" width="90"></td>';
    $tbl .='<td valign="top" width="120"></td>';
    $tbl .='<td valign="top" width="120"></td>';
    $tbl .='<td valign="top" width="90"></td>';
    $tbl .='<td valign="top" width="90"></td>';
    $tbl .='<td valign="top" width="150"></td>';
    $tbl .='<td valign="top" width="120"></td>';
    $tbl .='<td valign="top" width="90"></td>';
    $tbl .='<td valign="top" width="90"></td>';
    $tbl .='<td valign="top" width="90">Total EDC ' . $edc_code . ':</td>';
    $tbl .= '<td valign="top" width="120" align="right" style="border-top:1px solid #000;"><b>' . number_format($nominal) . '</b></td>';
    $tbl .='<td valign="top" width="120"></td>';
    $tbl .='<td valign="top" width="90"></td>';
    $tbl .='<td valign="top" width="150"></td>';
    $tbl .='<td valign="top" width="120"></td>';
    $tbl .='</tr>';
    $j = 0;
    $nominal = 0;
}

$tbl .= '<tr><td valign="top"><br /></td></tr>'
        . '<tfoot><tr>';
$tbl .= '<td colspan="8"></td>';
$tbl .= '<td class="border-foot" colspan="2" style="border-left:2px solid black;border-top:2px solid black;border-bottom:2px solid black;" valign="top" width="240" align="right"><b>Total Cancelation DP:</b></td>';
$tbl .= '<td class="border-foot" style="border-right:2px solid black;border-top:2px solid black;border-bottom:2px solid black;" valign="top" width="120" align="right"> <b>' . number_format($tnominal) . '</b></td>';
$tbl .= '</tr></tfoot>';
$tbl .= '</table>';
