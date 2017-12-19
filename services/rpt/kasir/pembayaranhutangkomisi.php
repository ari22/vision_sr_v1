<?php
session_start();
$comp_name = "BELUM DI SET";
if (isset($_SESSION['comp_name'])) {
    $comp_name = $_SESSION['comp_name'];
}

$tbl = tblstyle();
$rptTitle = "COMMISSION PAYABLE PAYMENT REPORT";

$order = " ";

$supp_type = '';
$title = '';
$filterdesc = '';

$pay_date1 = dateFormat($pay_date1);
$pay_date2 = dateFormat($pay_date2);

$where = " WHERE 1=1 ";

if (!empty($_REQUEST['group_by'])) {
    $group_by = $_REQUEST['group_by'];
    switch ($group_by) {
        case '1' :
            $rptFile = "apps.php";
            $title = '(By Intermediary)';
            $order = " ORDER BY b.pay_date,b.sal_inv_no";
            break;
        case '2' :
            $rptFile = "appp.php";
            $title = '(By Payment Type)';
            $order = " ORDER BY  b.pay_type,b.pay_date,b.sal_inv_no ";
            break;
    }
}

$where = " where 1=1 ";

if (!empty($_REQUEST['pay_date1']) && !empty($_REQUEST['pay_date2'])) {
    $len = strlen($where);
    if ($len >> 0) {
        $where .= " AND ";
    }
    $where .= " pay_date  <= '" . dateFormat($_REQUEST['pay_date2']) . "' and pay_date >= '" . dateFormat($_REQUEST['pay_date1']) . "' ";
    $len = strlen($filterdesc);
    if ($len >> 0) {
        $filterdesc .= " AND ";
    } $filterdesc .= "Payment Date ";
}

if (!empty($_REQUEST['pay_type'])) {
    $pay_type = $_REQUEST['pay_type'];
    $len = strlen($where);
    if ($len >> 0) {
        $where .= " AND ";
    }
    $where .= " pay_type  = '" . $pay_type . "' ";
    $len = strlen($filterdesc);
    if ($len >> 0) {
        $filterdesc .= " AND ";
    } $filterdesc .= "Pay Type ";
}


if ($wrhs_axs !== 'ALL') {
    $where .= " AND a.wrhs_code='$wrhs_axs' ";
}

$statsql = "select a.chassis,a.engine,a.veh_code,a.veh_name,
b.*, pay2_name
from " . $db1 . ".veh_comaph a left join " . $db1 . ".veh_comapd b on a.sal_inv_no = b.sal_inv_no";

//$statsql .= $where . " " . $order;
$statsql .= $where;

$mounth = rangeMounth($pay_date1, $pay_date2);

$statsql .= queryUnion($mounth,$db1,$statsql);

$statsql .= $order.' ASC';

//echo $statsql;exit;
$dtl = mysql_query($statsql) or die(mysql_error());
if (mysql_num_rows($dtl) == 0) {
    echo "Tidak ada data";
    return;
}

include "pembayaranhutangkomisi/" . $rptFile;

$filename = 'CommissionPayablePayment_' . date('dmy') . '_' . date('his');

$tblimport = 'veh_aph';

$keys = array(
    'key1' => 'payment'
);

echo outputReport($output, $tbl, $filename, $statsql, $tblimport, $keys);
?>