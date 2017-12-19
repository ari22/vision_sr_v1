<?php
$tbl .= '
<div id="cntr1" align="center">
<table width="100%">
<tr><td valign="top" align="center"><b style="font-size:1.5em;">' . $comp_name . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.5em;">' . $rptTitle . '</b></td></tr>
<tr><td valign="top" align="center"><b style="font-size:1.1em;">' . $title . '</b></td></tr>
<tr><td valign="top" align="center"><b>DATE : ' . $date1 . ' UP TO ' . $date2 . '</b></td></tr>
</table>
';


$tbl .= '
<table width="100%"  >
<tr>
<td></td>
<td valign="top" align="right"><b>Printed On: </b>' . date('d/m/Y') . '</td>
</tr>
</table>';

$tbl .= '<table width="100%">';
$tbl .= '<thead style="border:2px solid black !important;">
            <tr>
                <td valign="top" width="30" align="left"><b>No.</b></td>
                <td valign="top" width="120" align="left"><b>Delivery No.</b></td>
                <td valign="top" width="100" align="left"><b>Delivery Date</b></td>
                <td valign="top" width="120" align="left"><b>Invoice No.</b></td>
                <td valign="top" width="100" align="left"><b>Invoice Date</b></td>
                <td valign="top" width="120" align="left"><b>SPK No.</b></td>
                <td valign="top" width="100" align="left"><b>SPK Date</b></td>
                <td valign="top" width="120" align="left"><b>Chassis</b></td>
                <td valign="top" width="120" align="left"><b>Engine</b></td>
                <td valign="top" width="100" align="left"><b>Wrhs</b></td>
                <td valign="top" width="100" align="left"><b>Sales</b></td>
                <td valign="top" width="120" align="left"><b>Customer Name</b></td>
                <td valign="top" width="100" align="right"><b>Qty<br />(Unit)</b></td>';
$tbl .= '</tr></thead>';
$tbl .= '<tr><td></td></tr>';
$no = 1;
$i = 0;
$j = 0;
$qty2 = 0;
$no2 = 1;
$tqty = 0;
$qty = 0;

$last_veh_code = '';
$last_veh_name = '';

$last_wrhs_code = '';


while ($dtlrow = mysql_fetch_array($dtl)) {
    $tqty +=1;

    if ($last_wrhs_code != $dtlrow['wrhs_code']) {

        if ($j >= 1) {
            $tbl .='<tr>';
            $tbl .='<td valign="top" colspan="12" align="right"><b>Warehouse ' . $last_wrhs_code . ' :</b></td>';
            $tbl .='<td valign="top" width="100" align="right" style="border-top:2px solid #000;" align="right">' . $qty . '</td>';
            $tbl .='</tr>';
            $j = 0;
            $qty = 0;
            $no = 1;
        }
        

        $tbl.= '<tr><td valign="top" colspan="13" align="left"><b style="font-size:1.1em;">*** Warehouse : ' . $dtlrow['wrhs_code'] .  ' ***</b></td></tr>';
        $last_wrhs_code = $dtlrow['wrhs_code'];
        



    }

    if ($last_veh_code != $dtlrow['veh_code']) {
         if ($i >= 1) {
            $tbl .='<tr>';
            $tbl .='<td valign="top" colspan="12" align="right">Warehouse ' . $last_wrhs_code . ' :</td>';
            $tbl .='<td valign="top" width="100" align="right" style="border-top:1px solid #000;" align="right">' . $qty2 . '</td>';
            $tbl .='</tr>';
            $i = 0;
            $qty2 = 0;
            $no2 = 1;
           
        }
        
        $tbl.= '<tr><td valign="top" colspan="13" align="left"><b style="font-size:1.1em;">Type : ' . $dtlrow['veh_code'] . ' : ' . $dtlrow['veh_name'] . '</b></td></tr>';
        $last_veh_code = $dtlrow['veh_code'];
        $last_veh_name = $dtlrow['veh_name'];
    }
    $qty +=1;
    $qty2 +=1;
    $no2++;
    $sj_date = '';
    if ($dtlrow['sj_date'] != '0000-00-00') {
        $sj_date = date_create($dtlrow['sj_date']);
        $sj_date = date_format($sj_date, "d/m/Y");
    }

    $sal_date = '';
    if ($dtlrow['sal_date'] != '0000-00-00') {
        $sal_date = date_create($dtlrow['sal_date']);
        $sal_date = date_format($sal_date, "d/m/Y");
    }
    $so_date = '';
    if ($dtlrow['so_date'] != '0000-00-00') {
        $so_date = date_create($dtlrow['so_date']);
        $so_date = date_format($so_date, "d/m/Y");
    }

    $tbl .='<tr>';
    $tbl .='<td valign="top" width="30" align="left">' . $no++ . '.</td>';
    $tbl .='<td valign="top" width="120" align="left">' . $dtlrow['sj_no'] . '</td>';
    $tbl .='<td valign="top" width="100" align="left">' . $sj_date . '</td>';
    $tbl .='<td valign="top" width="120" align="left">' . $dtlrow['sal_inv_no'] . '</td>';
    $tbl .='<td valign="top" width="100" align="left">' . $sal_date . '</td>';
    $tbl .='<td valign="top" width="120" align="left">' . $dtlrow['so_no'] . '</td>';
    $tbl .='<td valign="top" width="100" align="left">' . $so_date . '</td>';
    $tbl .='<td valign="top" width="120" align="left">' . $dtlrow['chassis'] . '</td>';
    $tbl .='<td valign="top" width="120" align="left">' . $dtlrow['engine'] . '</td>';
    $tbl .='<td valign="top" width="100" align="left">' . $dtlrow['wrhs_code'] . '</td>';
    $tbl .='<td valign="top" width="100" align="left">' . $dtlrow['srep_code'] . '</td>';
    $tbl .='<td valign="top" width="120" align="left">' . $dtlrow['cust_name'] . '</td>';
    $tbl .='<td valign="top" width="100" align="right">1</td>';
    $tbl .='</tr>';

    $i++;
    $j++;

    unset($dtlrow);
}

if ($i >= 1) {
    $tbl .='<tr>';
    $tbl .='<td valign="top" colspan="12" align="right">Type ' . $last_veh_code . ' :</td>';
    $tbl .='<td valign="top" width="100" align="right"  style="border-top:1px solid #000;" align="right">' . $qty2 . '</td>';
    $tbl .='</tr>';
    $i = 0;
    $qty2 = 0;
    $no2 = 1;
   
}

if ($j >= 1) {
    $tbl .='<tr>';
    $tbl .='<td valign="top" colspan="12" align="right"><b>Warehouse ' . $last_wrhs_code . ' :</b></td>';
    $tbl .='<td valign="top" width="100" align="right" style="border-top:2px solid #000;" align="right">' . $qty . '</td>';
    $tbl .='</tr>';
    $j = 0;
     $qty = 0;
    $no = 1;
            
    
}

$tbl .='<tr><td><br /></td></tr>';
$tbl .= '<tfoot>';
$tbl .='<tr>';
$tbl .='<td colspan="11"></td>';
$tbl .='<td class="border-foot" style="border-left:2px solid black;border-top:2px solid black;border-bottom:2px solid black;" valign="top" align="right"><b>Grand Total :</b></td>';
$tbl .='<td class="border-foot" style="border-right:2px solid black;border-top:2px solid black;border-bottom:2px solid black;"  valign="top" width="100" align="right" align="right">' . $tqty . '</td>';
$tbl .='</tr>';
$tbl .= '</tfoot>';
$tbl .= '</table>';