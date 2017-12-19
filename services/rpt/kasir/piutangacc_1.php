<?php

session_start();
$comp_name = "BELUM DI SET";

if (isset($_SESSION['comp_name'])) {
    $comp_name = $_SESSION['comp_name'];
}

$tbl = tblstyle();

$rptTitle = "ACCESSORIES ACCOUNT RECEIVABLE REPORT";
$title = '';

$rptFile = "veh_arc3.php";
$order = " ";

$date1 = '1970-01-01';
$date2 = dateFormat($date);

$where = " WHERE 1=1  and a.opn_date<='" . dateFormat($date) . "'";

if (!empty($_REQUEST['cust_name'])) {
    $where .=" and a.cust_name='" . $cust_name . "'";
}

if (!empty($_REQUEST['sinv_code'])) {
    $where .=" and a.sinv_code='" . $sinv_code . "'";
}


if (!empty($_REQUEST['report_by'])) {
    $report_by = $_REQUEST['report_by'];

    switch ($report_by) {
        case '2':
            $where .= " and a.pd_end not in('0')";
            break;
    }
}

if (!empty($_REQUEST['group_by'])) {
    $group_by = $_REQUEST['group_by'];

    switch ($group_by) {
        case '1':
            $folder = 'customer/';
            $order .= " ORDER BY cust_code,cust_name";
            $rptFile = 'customer.php';
            break;
        case '2':
            $folder = 'invoice/';
            $order .= " ORDER BY sinv_code";
            $rptFile = 'invoice.php';
            break;
    }
}
if (!empty($_REQUEST['aging'])) {
    $aging = $_REQUEST['aging'];

    switch ($aging) {
        case '1':
            //$where .= " and a.due_date<='" . dateFormat($date) . "'";
            $title .= "Aging By Due Date";
            //    $rptFile = 'aging.php';
            break;
        case '2':
            //$where .= " and a.sal_date<='" . dateFormat($date) . "'";
            $title .= "Aging By Invoice Date";
            break;
    }
}

if (!empty($_REQUEST['age'])) {
    $age = $_REQUEST['age'];

    switch ($age) {
        case '2':
            $rptFile = 'aging.php';
            break;
    }
}



$statsql = "select a.* from " . $db1 . ".acc_arh a  ";

$statsql .= $where;

$mounth = rangeMounth($date1, $date2);

$statsql .= queryUnion($mounth, $db1, $statsql);

$statsql .= $order . ' ASC';

//$statsql .= $where . $order;
//echo $statsql;exit;
$dtl = mysql_query($statsql) or die(mysql_error());
if (mysql_num_rows($dtl) == 0) {
    echo "Tidak ada data";
    return;
}


include "piutangacc/" . $folder . $rptFile;
$filename = 'piutangacc_' . date('d') . '_' . date('m') . '_' . date('Y');

echo outputReport($output, $tbl, $filename);
?>