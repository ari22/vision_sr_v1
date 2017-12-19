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
<td valign="top"></td>
<td valign="top" align="right"><b>Printed On: </b>' . date('d/m/Y') . '</td>
</tr>
</table>';

$tbl .= '<table width="100%">';
$tbl .= '<thead style="border:2px solid black !important;">
           <tr>
                <td valign="top"><b>Invoice<br />Date</b></td>
                <td valign="top"><b>Invoice No.</b></td>
                <td valign="top"><b>DP Invoice No.</b></td>
                <td valign="top"><b>DP Invoice Date</b></td>
                <td valign="top"><b>Customer<br />Code</b></td>
                <td valign="top"><b>Customer Name</b></td>
                <td valign="top"><b>Check No.</b></td>
                <td valign="top"><b>Check Date</b></td>
                <td valign="top"  align="right"><b>Payment</b></td>
                <td valign="top"><b>Due Date</b></td>
                
                <td valign="top"><b>Bank</b></td>
                <td valign="top"><b>EDC</b></td>
                <td valign="top"><b>Note</b></td>
                <td valign="top"><b>Payment By</b></td>
            </tr>
        </thead>';

$tbl .= '<tr><td valign="top"></td></tr>';

$i = 0;
$j = 0;
$nominal = 0;
$tnominal = 0;

$pay_type = '';

while ($dtlrow = mysql_fetch_array($dtl)) {
    $tnominal += $dtlrow['inv_at'];
    
    if ($pay_type != $dtlrow['pay_type']) {
        if ($j >= 1) {

            $tbl .= '<tr>';
            $tbl .= '<td valign="top" width="90"></td>';
            $tbl .= '<td valign="top" width="120"></td>';
            $tbl .= '<td valign="top" width="120"></td>';
            $tbl .= '<td valign="top" width="90"></td>';
            $tbl .= '<td valign="top" width="120"></td>';
            $tbl .= '<td valign="top" width="90"></td>';
            $tbl .= '<td valign="top"  colspan="2" width="180" align="right"><b>Total Payment ' . $pay_type . ':</b></td>';
            $tbl .= '<td valign="top" width="120" align="right" style="border-top:1px solid #000;"> <b>' . number_format($nominal) . '</b></td>';
            $tbl .= '<td valign="top" width="50"></td>';
            $tbl .= '<td valign="top" width="100"></td>';
            $tbl .= '<td valign="top" width="90"></td>';
            $tbl .= '<td valign="top" width="90"></td>';
            $tbl .= '<td valign="top" width="120"></td>';
            //$tbl .= '<td valign="top" width="100"></td>';
            $tbl .= '</tr>';

            $j = 0;
            $nominal = 0;
        }


        $tbl.= '<tr><td valign="top" colspan="14" align="left"><b style="font-size:1.1em;">*** PAYMENT TYPE : ' . $dtlrow['pay_type'] . '***</b></td></tr>';
        $pay_type = $dtlrow['pay_type'];
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
    $tbl .= '<td valign="top" width="120">' . $dtlrow['cust_code'] . '</td>';
    $tbl .= '<td valign="top" width="90">' . $dtlrow['cust_code'] . '</td>';
    $tbl .= '<td valign="top" width="90">' . $pay_date . '</td>';
    $tbl .= '<td valign="top" width="90">' . $due_date . '</td>';
    $tbl .= '<td valign="top" width="120" align="right">' . number_format($dtlrow['inv_at']) . '</td>';
    $tbl .= '<td valign="top" width="50"></td>';

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
    $tbl .= '<td valign="top"  colspan="2" width="180" align="right"><b>Total Payment ' . $pay_type . ':</b></td>';
    $tbl .= '<td valign="top" width="120" align="right"  style="border-top:1px solid #000;"> <b>' . number_format($nominal) . '</b></td>';
    $tbl .= '<td valign="top" width="50"></td>';
    $tbl .= '<td valign="top" width="100"></td>';
    $tbl .= '<td valign="top" width="90"></td>';
    $tbl .= '<td valign="top" width="90"></td>';
    $tbl .= '<td valign="top" width="120"></td>';
   // $tbl .= '<td valign="top" width="100"></td>';
    $tbl .= '</tr>';

    $j = 0;
    $nominal = 0;
}

$tbl .= '<tr><td valign="top"><br /></td></tr>'
        . '<tfoot><tr>';
$tbl .= '<td colspan="7"></td>';
$tbl .= '<td class="border-foot" style="border-left:2px solid black;border-top:2px solid black;border-bottom:2px solid black;" valign="top" width="240" align="right"><b>Total Cancelation DP:</b></td>';
$tbl .= '<td class="border-foot" style="border-right:2px solid black;border-top:2px solid black;border-bottom:2px solid black;" valign="top" width="120" align="right"> <b>' . number_format($tnominal) . '</b></td>';
$tbl .= '</tr></tfoot>';


$tbl .= '</table>';
