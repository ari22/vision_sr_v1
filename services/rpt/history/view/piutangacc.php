<?php

$tbl .= '
    <div id="cntr1" align="center">
<table width="85%">
<tr><td valign="top" align="center"><b style="font-size:1.1em;">' . $comp_name . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.1em;">Accessories Receivable History Report</b></td></tr>
<tr><td valign="top" align="center"><b>DATE : ' . dateView($opn_date1) . ' UP TO ' . dateView($opn_date2) . '</b></td></tr>
</table>
';
$tbl .= '
<table width="85%">
<tr>
<td></td>
<td valign="top" align="right"><b>Printed On: </b>' . date('d/m/Y') . '</td>
</tr>
</table>';

$tbl .= '
<table width="85%">
<thead style="border:2px solid black !important;">
<tr>
<th valign="top" align="left" width="20">No.</th>
<th valign="top" align="left" width="100">Payment Date</th>
<th valign="top" align="left" width="100">Payment Type</th>
<th valign="top" align="left" width="90">Cheque Date</th>
<th valign="top" align="left" width="90">TOP Date</th>
<th valign="top" align="left">Note</th>
<th valign="top" align="right" width="120">Beginning Balance</th>
<th valign="top" align="right" width="90">Discount</th>
<th valign="top" align="right" width="90">Payment</th>
<th valign="top" align="right" width="90">Ending Balance</th>
</tr>
</thead>';

$tbl .='<tr><td></td></tr>';

$invoice = mysql_fetch_array($dtl2);
$begin_val =  $invoice['inv_total'];
$ending_val = 0;

$no = 1;
$sum_pay_val = 0;
$sum_disc_val = 0;

while ($dtlrow = mysql_fetch_array($dtl)) {

    $pay_date = dateView($dtlrow['pay_date']);
    $check_date = dateView($dtlrow['check_date']);
    $due_date = dateView($dtlrow['due_date']);

    $sum_pay_val += $dtlrow['pay_val'];
    $sum_disc_val += $dtlrow['disc_val'];

   
     
    if ($no > 1) {
        $ending_val = $ending_val - $dtlrow['pay_val'] - $dtlrow['disc_val'];
        $begin_val = $ending_val + $dtlrow['pay_val'] + $dtlrow['disc_val'];  
    } else {
         $begin_val = $begin_val;
         $ending_val = $begin_val - $dtlrow['pay_val'] - $dtlrow['disc_val'];
    }
   
    
    $tbl .='<tr>';
    $tbl .='<td>' . $no++ . '.</td>';
    $tbl .='<td>' . $pay_date . '</td>';
    $tbl .='<td>' . $dtlrow['pay_type'] . '</td>';
    $tbl .='<td>' . $check_date . '</td>';
    $tbl .='<td>' . $due_date . '</td>';
    $tbl .='<td>' . $dtlrow['pay_desc'] . '</td>';
    $tbl .='<td align="right">' . number_format($begin_val) . '</td>';
    $tbl .='<td align="right">' . number_format($dtlrow['disc_val']) . '</td>';
    $tbl .='<td align="right">' . number_format($dtlrow['pay_val']) . '</td>';
    $tbl .='<td align="right">' . number_format($ending_val) . '</td>';
    $tbl .='</tr>';
    
     unset($dtlrow);
}

$tbl .='<tr><td><br /></td></tr>';

$tbl .='<tfoot>';
$tbl .='<td colspan="3"></td>';
$tbl .='<td class="border-foot" style="border-left:2px solid black;" colspan="2"  align="right"><b>Total Invoice : </b></td>';
$tbl .='<td class="border-foot"><b>' . number_format($invoice['inv_total']) . '</b></td>';
$tbl .='<td class="border-foot" style="border-left:2px solid black;border-top:2px solid black;border-bottom:2px solid black;" align="right"><b>Grand Total :</b></td>';
$tbl .='<td class="border-foot" style="border-top:2px solid black;border-bottom:2px solid black;" align="right"><b>' . number_format($sum_disc_val) . '</b></td>';
$tbl .='<td class="border-foot" style="border-right:2px solid black;border-top:2px solid black;border-bottom:2px solid black;" align="right"><b>' . number_format($sum_pay_val) . '</b></td>';
$tbl .='</tfoot>';

$tbl .='</table></div>';
