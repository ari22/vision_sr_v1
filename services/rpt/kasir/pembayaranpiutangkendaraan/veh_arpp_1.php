<?php

//=========CHANGE LOG========
//ganti semua <td jadi <td valign="top"
//pembetulan format date
//chassis => Chassis No.
//pembetulan footer

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
	<th valign="top" width="100px" 	 ><b>Payment Date</b></th>
	<th valign="top" width="120px" 	 ><b>Invoice No.</b></th>
	<th valign="top" align="center" 	width="70px" 	 ><b>Invoice Date</b></th>
	<th valign="top"	width="120px" 	 ><b>Chassis No.</b></th>
	<th valign="top" 	width="180px" 	 ><b>Vehicle Name</b></th>
	<th valign="top" align="right" 	width="80px" 	 ><b>Payment</b></th>
	<th valign="top" align="right" 	width="80px" 	 ><b>Discount</b></th>
	<th valign="top" align="right" 	width="80px" 	 ><b>Payment Type</b></th>
	<th valign="top" align="right" 	width="80px" 	 ><b>Check No.</b></th>
	<th valign="top" align="center" 	width="80px" 	 ><b>Check Date</b></th>
	<th valign="top" align="center" 	width="80px" 	 ><b>Due Date</b></th>
	<th valign="top" align="left" 	width="150px" 	 ><b>Description</b></th>
	<th valign="top" align="left" 	width="80px" 	 ><b>Added By</b></th>';
$tbl .= '</tr></thead>';
$tbl .= '<tr><td valign="top"><br /></td></tr>';

$i = 0;
$j = 0;
$last_pay_type = '';
$last_pay_name = '';
$last_pay_date = '';
$lnQty = 0;
$pay = 0;
$disc_val = 0;
$lSum = 0;
$grp_pay_val = 0;
$grp_disc_val = 0;
$sum_pay_val = 0;
$sum_disc_val = 0;
while ($dtlrow = mysql_fetch_array($dtl)) {


    if ($last_pay_type != $dtlrow['pay_type']) {
        if ($i >= 1) {
            if ($last_pay_date != $dtlrow['pay_date']) {
                $last_pay_date = dateView($dtlrow['pay_date']);
                if ($j >= 1) {
                    $tbl.= '
					<tr></tr><tr>
						<td valign="top" align="right" colspan="5">Total Payment On ' . $last_pay_date . ' :</td>
						<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($grp_pay_val) . '</b></td>
						<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($grp_disc_val) . '</b></td>

					</tr><tr><td valign="top"><br></td></tr>';

                    $lnQty = 0;
                    $grp_pay_val = 0;
                    $grp_disc_val = 0;
                }
                $last_pay_date = $dtlrow['pay_date'];
            }

            $tbl.= '
			<tr>
				<td valign="top" colspan="5" align="right"><b style="font-size:1.1em;">Total Payment Type' . $last_pay_type . ':</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($pay) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($disc_val) . '</b></td>

			</tr><tr><td valign="top"><br></td></tr>';

            $lnQty = 0;
            $pay = 0;
            $disc_val = 0;
            $j = 0;
        }
        $tbl.= '<tr><td valign="top" colspan="8" align="left"><b style="font-size:1.1em;">*** ' . $dtlrow['pay_type'] . ' ***</b></td></tr>';
        $last_pay_type = $dtlrow['pay_type'];
    }
    if ($last_pay_date != $dtlrow['pay_date']) {
        if ($j >= 1) {
            $last_pay_date = dateView($dtlrow['pay_date']);
            $tbl.= '
			<tr></tr><tr>
				<td valign="top" align="right" colspan="5">Total Payment On ' . $last_pay_date . ' :</td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($grp_pay_val) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($grp_disc_val) . '</b></td>

			</tr><tr><td valign="top"><br></td></tr>';

            $lnQty = 0;
            $grp_pay_val = 0;
            $grp_disc_val = 0;
        }
        $last_pay_date = $dtlrow['pay_date'];
    }

    $lnQty++;
    $pay += $dtlrow['pay_val'];
    $disc_val += $dtlrow['disc_val'];
    $grp_pay_val += $dtlrow['pay_val'];
    $grp_disc_val += $dtlrow['disc_val'];
    $lSum++;
    $sum_pay_val += $dtlrow['pay_val'];
    $sum_disc_val += $dtlrow['disc_val'];

    $sal_date = dateView($dtlrow['sal_date']);
    $pay_date = dateView($dtlrow['pay_date']);
    $due_date = dateView($dtlrow['due_date']);
    $check_date = dateView($dtlrow['check_date']);

    $tbl.= '
	<tr>
		<td valign="top" align="left">' . $pay_date . '</td>
		<td valign="top" align="left">' . $dtlrow['sal_inv_no'] . '</td>
		<td valign="top" align="center">' . $sal_date . '</td>
		<td valign="top" align="left">' . $dtlrow['chassis'] . '</td>
		<td valign="top" align="left">' . $dtlrow['veh_name'] . '</td>
		<td valign="top" align="right">' . number_format($dtlrow['pay_val']) . '</td>
		<td valign="top" align="right">' . number_format($dtlrow['disc_val']) . '</td>
		<td valign="top" align="right">' . $dtlrow['pay_type'] . '</td>
		<td valign="top" align="right">' . $dtlrow['check_no'] . '</td>
		<td valign="top" align="center">' . $check_date . '</td>
		<td valign="top" align="center">' . $due_date . '</td>
		<td valign="top" align="left">' . $dtlrow['pay_desc'] . '</td>
		<td valign="top" align="left">' . $dtlrow['add_by'] . '</td>
		</tr>';

    $i++;
    $j++;
    unset($dtlrow);
}
if ($i >= 1) {
    if ($last_pay_date != $dtlrow['pay_date']) {
        $last_pay_date = dateView($dtlrow['pay_date']);
        if ($j >= 1) {
            $tbl.= '
			<tr></tr><tr>
				<td valign="top" align="right" colspan="5">Total Payment Date ' . $last_pay_date . ' :</td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($grp_pay_val) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($grp_disc_val) . '</b></td>

			</tr><tr><td valign="top"><br></td></tr>';

            $lnQty = 0;
            $grp_pay_val = 0;
            $grp_disc_val = 0;
        }
    }
    $tbl.= '
			<tr>
				<td valign="top" colspan="5" align="right"><b style="font-size:1.1em;">TOTAL ' . $last_pay_type . ':</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($pay) . '</b></td>
				<td valign="top" align="right" style="border-top:1px solid black;"><b>' . number_format($disc_val) . '</b></td>

			</tr><tr><td valign="top"><br></td></tr>';

    $lnQty = 0;
    $pay = 0;
    $disc_val = 0;
}
$tbl.= '<tr><td valign="top"></td></tr>
        <tfoot>
            <tr>
                <td colspan="4"></td>
		<td class="border-foot" style="border-left:2px solid black;border-top:2px solid black;border-bottom:2px solid black;" valign="top" align="right"><b style="font-size:1.1em;">GRAND TOTAL :</b></td>
		<td class="border-foot" style="border-top:2px solid black;border-bottom:2px solid black;" valign="top" align="right"><b>' . number_format($sum_pay_val) . '</b></td>
		<td class="border-foot" style="border-right:2px solid black;border-top:2px solid black;border-bottom:2px solid black;" valign="top" align="right"><b>' . number_format($sum_disc_val) . '</b></td>
            </tr>
        </tfoot>';
$tbl .='
</table>


</div>
';
?>