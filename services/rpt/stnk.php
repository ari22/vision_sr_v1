<?php

session_start();
$comp_name = "BELUM DI SET";
if (isset($_SESSION['comp_name'])) {
    $comp_name = $_SESSION['comp_name'];
}

$tbl = tblstyle();

$repTitle = 'DELIVERY OF STNK REPORT';



$supp_type = '';

$title = '';
$filterdesc = '';

$date1 = '';
$date2 = '';
$field = '';

$where = "where 1=1 ";


if ($_REQUEST['status1'] == 1) {
    $rptFile = "veh_doc.php";
    $date1 = dateFormat($sal_date1);
    $date2 = dateFormat($sal_date2);

    $title = "Not Received From Agent";
    $where .= " and sal_date >='" . $date1 . "' and sal_date <='" . $date2 . "' and stnk_sdate = '0000-00-00' and stnk_rdate = '0000-00-00' ";

    $order = " ORDER BY sal_date, sal_inv_no  ASC ";
} else {
    if ($_REQUEST['status2'] == 1) {
        $date1 = dateFormat($stnk_rdate1);
        $date2 = dateFormat($stnk_rdate2);

        $title = "Already received From Agent But Submitted to Customer";
        $rptFile = "veh_doc2.php";
        $where .= "and stnk_rdate>= '" . $date1 . "' and stnk_rdate <='" . $date2 . "' ";
        $where .= "  and stnk_sdate = '0000-00-00' ";
        $order = " ORDER BY stnk_rdate, veh_reg_no  ASC ";
    } else {
        $order = " ORDER BY stnk_rdate, stnk_sdate  ASC ";
        $date1 = dateFormat($stnk_rdate1);
        $date2 = dateFormat($stnk_rdate2);

        $title = "Already Submitted to Customer";
        $rptFile = "veh_doc3.php";
        $where .= "and stnk_rdate>= '" . $date1 . "' and stnk_rdate <='" . $date2 . "' ";
        $where .= "and stnk_sdate>= '" . dateFormat($stnk_sdate1) . "' and stnk_sdate <='" . dateFormat($stnk_sdate2) . "' ";
    }
}

//$where .= " and sal_date >='" . $date1 . "' and sal_date <='" . $date2 . "'";



$statsql = "select * from " . $db1 . ".veh_doc ";
$statsql .= $where;


//$mounth = rangeMounth($date1, $date2);
//$statsql .= queryUnion($mounth, $db1, $statsql);

$statsql .= $order;

//echo $statsql;exit;
$dtl = mysql_query($statsql) or die(mysql_error());

if (mysql_num_rows($dtl) == 0) {
    echo "Tidak ada data";
    return;
}


include "stnk/" . $rptFile;

$filename = 'stnk_' . date('d') . '_' . date('m') . '_' . date('Y');

echo outputReport($output, $tbl, $filename);
?>