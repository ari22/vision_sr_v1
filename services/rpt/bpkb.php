<?php

session_start();
$comp_name = "BELUM DI SET";
if (isset($_SESSION['comp_name'])) {
    $comp_name = $_SESSION['comp_name'];
}

$tbl = tblstyle();

$repTitle = "DELIVERY OF BPKB REPORT";

$rptFile = "veh_doc.php";
$order = " ORDER BY sal_date ";

$supp_type = '';

$title = '';
$filterdesc = '';

$date1 = '';
$date2 = '';
$field = '';

$where = "where 1=1 ";

if ($_REQUEST['status1'] == 1) {

    $date1 = dateFormat($sal_date1);
    $date2 = dateFormat($sal_date2);

    $title = "Not Received From Agent";
    $where .= " and sal_date >='" . $date1 . "' and sal_date <='" . $date2 . "' and bpkb_date = '0000-00-00' and bpkb_rdate = '0000-00-00' ";

    $order = " ORDER BY sal_date, sal_inv_no  ASC ";
} else {
    if ($_REQUEST['status2'] == 1) {
        $date1 = dateFormat($bpkb_rdate1);
        $date2 = dateFormat($bpkb_rdate2);

        $title = "Already received From Agent But Submitted to Customer";
        $rptFile = "veh_doc2.php";
        $where .= "and bpkb_rdate>= '" . $date1 . "' and bpkb_rdate <='" . $date2 . "' ";
        $where .= "  and bpkb_sdate = '0000-00-00' ";

        $order = " ORDER BY bpkb_rdate, veh_reg_no  ASC ";
    } else {
        $order = " ORDER BY bpkb_rdate, bpkb_sdate, cust_rname  ASC ";

        $date1 = dateFormat($bpkb_rdate1);
        $date2 = dateFormat($bpkb_rdate2);

        $title = "Already Submitted to Customer";
        $rptFile = "veh_doc3.php";
        $where .= "and bpkb_rdate>= '" . $date1 . "' and bpkb_rdate <='" . $date2 . "' ";
        $where .= "and bpkb_sdate>= '" . dateFormat($bpkb_sdate1) . "' and bpkb_sdate <='" . dateFormat($bpkb_sdate2) . "' ";
    }
}

//$where .= " and opn_date >='" . $date1 . "' and opn_date <='" . $date2 . "'";



$statsql = "select * from " . $db1 . ".veh_doc ";
$statsql .= $where;

//$mounth = rangeMounth($date1, $date2);
//$statsql .= queryUnion($mounth, $db1, $statsql);

$statsql .= $order;

//echo $statsql; exit;
$dtl = mysql_query($statsql) or die(mysql_error());
if (mysql_num_rows($dtl) == 0) {
    echo "Tidak ada data";
    return;
}


include "bpkb/" . $rptFile;

$filename = 'bpkb_' . date('d') . '_' . date('m') . '_' . date('Y');

echo outputReport($output, $tbl, $filename);
?>