<?php

session_start();
$comp_name = "BELUM DI SET";
if (isset($_SESSION['comp_name'])) {
    $comp_name = $_SESSION['comp_name'];
}

$tbl = tblstyle();
$rptTitle = "BOOKING FEE CANCELATION REPORT";


//$where = ' WHERE 1=1';
$order = '';
$join = '';
$group = '';
$filterdesc = '';
//$title = 'Pembatalan Uang Jaminan';

$opn_date1 = dateFormat($opn_date1);
$opn_date2 = dateFormat($opn_date2);


$where = " WHERE 1=1 and a.opn_date>='" . $opn_date1 . "' and a.opn_date<='" . $opn_date2 . "'";


if (!empty($_REQUEST['cust_code'])) {
    $where .= " and a.cust_code='$cust_code'";
}
if (!empty($_REQUEST['pay_type'])) {
    $where .= " and b.pay_type='$pay_type'";
}
if (!empty($_REQUEST['edc_code'])) {
    $where .= " and b.edc_code='$edc_code'";
}

if($wrhs_axs !== 'ALL'){
    $where .= " AND a.wrhs_code='$wrhs_axs' ";
}

if (!empty($cls_date)) {
    $cls_date = $_REQUEST['cls_date'];
    switch ($cls_date) {
        case '1' :
            $len = strlen($where);
            if ($len >> 0) {
                $where .= " AND ";
            }
            $where .= " (a.cls_date not in('0000-00-00')) ";
            $len = strlen($filterdesc);
            if ($len >> 0) {
                $filterdesc .= " AND ";
            } $filterdesc .= "Tanggal Close ";
            break;
        case '2' :
            $len = strlen($where);
            if ($len >> 0) {
                $where .= " AND ";
            }
            $where .= " (a.cls_date='0000-00-00' or a.cls_date is null or a.cls_date > '" . $so_date2 . "') ";
            $len = strlen($filterdesc);
            if ($len >> 0) {
                $filterdesc .= " AND ";
            } $filterdesc .= "Tanggal Close ";
            break;

        case '3' :
            break;
    }
}

switch ($group_by) {
    case '1':
        $order = " ORDER BY a.cust_code, a.cust_name";
        $rptFile = 'customer.php';
        $title = 'By Customer';
        break;

    case '2':
        $order = " ORDER BY a.pay_type";
        $rptFile = 'pay_type.php';
        $title = 'By Payment Type';
        break;

    case '3':
        $order = " ORDER BY b.edc_code";
        $rptFile = 'edc_code.php';
        $title = 'By EDC Machine';
        break;
}

$statsql = "select a.*,b.* from " . $db1 . ".vehdpcch a right join " . $db1 . ".vehdpccd b on a.dpc_inv_no=b.dpc_inv_no ";
$group = 'group by b.dpc_inv_no';

$statsql .= $where;

$mounth = rangeMounth($opn_date1, $opn_date2);

$statsql .= queryUnion($mounth,$db1,$statsql);

$statsql .= $group;
$statsql .= $order.' ASC';


//echo $statsql;exit;
$dtl = mysql_query($statsql) or die(mysql_error());
if (mysql_num_rows($dtl) == 0) {
    echo "Tidak ada data";
    return;
}

include "bataluangjaminan/" . $rptFile;

$filename = 'downpayment_cancellation_' . date('dmy') . '_' . date('his');

$tblimport = 'vehdpcch';

echo outputReport($output, $tbl, $filename, $statsql, $tblimport);
