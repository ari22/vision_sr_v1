<?php

session_start();
$comp_name = "BELUM DI SET";

if (isset($_SESSION['comp_name'])) {
    $comp_name = $_SESSION['comp_name'];
}

$tbl = tblstyle();

$rptTitle = "COMMISION PAYABLE REPORT";
$title = '';

$order = " ";
$where = " WHERE 1=1 and a.opn_date<='" . dateFormat($date) . "'";

$date1 = '1970-01-01';
$date2 = dateFormat($date);


if (!empty($_REQUEST['report_by'])) {
    $report_by = $_REQUEST['report_by'];

    switch ($report_by) {
        case '2':
            $where .= " and a.hd_end not in('0')";
            break;
    }
}

if (!empty($_REQUEST['group_by'])) {
    $group_by = $_REQUEST['group_by'];

    switch ($group_by) {
        case '1':
            $order .= " ORDER BY a.pay2_name";
            $rptFile = 'payer.php';
            break;
        case '2':
            $order .= " ORDER BY a.sinv_code";
            $rptFile = 'invoice.php';
            break;
    }
}

if ($wrhs_axs !== 'ALL') {
    $where .= " AND a.wrhs_code='$wrhs_axs' ";
}

$statsql = "select a.* from " . $db1 . ".veh_comaph a  ";

//$statsql .= $where . $order;

$statsql .= $where;

$mounth = rangeMounth($date1, $date2);

$statsql .= queryUnion($mounth,$db1,$statsql);

$statsql .= $order.' ASC';

$dtl = mysql_query($statsql) or die(mysql_error());
if (mysql_num_rows($dtl) == 0) {
    echo "Tidak ada data";
    return;
}

include "hutangkomisi/" . $rptFile;
$filename = 'hutangkomisi_' . date('d') . '_' . date('m') . '_' . date('Y');

echo outputReport($output, $tbl, $filename);
?>