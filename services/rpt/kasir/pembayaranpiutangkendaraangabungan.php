<?php

session_start();
$comp_name = "BELUM DI SET";
if (isset($_SESSION['comp_name'])) {
    $comp_name = $_SESSION['comp_name'];
}

$tbl = tblstyle();

$rptTitle = "VEHICLE ACCOUNT RECEIVABLE COMBINED REPORT";


$order = " ORDER BY arg_date,pay_type,check_no,arg_inv_no";

$cust_type = '';

$title = '(By Date)';
$filterdesc = '';

$where = " WHERE 1=1 ";

if ($wrhs_axs !== 'ALL') {
    $where .= " AND a.wrhs_code='$wrhs_axs' ";
}

$arg_date1 = dateFormat($arg_date1);
$arg_date2 = dateFormat($arg_date2);


if (!empty($_REQUEST['arg_date1']) && !empty($_REQUEST['arg_date2'])) {
    $len = strlen($where);
    if ($len >> 0) {
        $where .= " AND ";
    }
    $where .= " a.arg_date  <= '" . dateFormat($_REQUEST['arg_date2']) . "' and a.arg_date >= '" . dateFormat($_REQUEST['arg_date1']) . "' ";
    $len = strlen($filterdesc);
    if ($len >> 0) {
        $filterdesc .= " AND ";
    } $filterdesc .= "Payment Date ";
}


if (!empty($_REQUEST['sort_by'])) {
    $sort_by = $_REQUEST['sort_by'];
    switch ($sort_by) {
        case '1' :
            $order = " ORDER BY arg_inv_no,arg_date";
            break;
        case '2' :
            $order = " ORDER BY arg_date,arg_inv_no";
            break;
        case '2' :
            $order = " ORDER BY cust_code, cust_name";
            break;
    }
}
if (!empty($_REQUEST['pay_type'])) {
    $pay_type = $_REQUEST['pay_type'];
    $len = strlen($where);
    if ($len >> 0) {
        $where .= " AND ";
    }
    $where .= " a.pay_type  = '" . $pay_type . "' ";
    $len = strlen($filterdesc);
    if ($len >> 0) {
        $filterdesc .= " AND ";
    } $filterdesc .= "Pay Type ";
}

if (!empty($_REQUEST['cust_code'])) {
    $cust_code = $_REQUEST['cust_code'];
    $len = strlen($where);
    if ($len >> 0) {
        $where .= " AND ";
    }
    $where .= " a.cust_code  = '" . $cust_code . "' ";
    $len = strlen($filterdesc);
    if ($len >> 0) {
        $filterdesc .= " AND ";
    } $filterdesc .= "Customer ";
}



if (!empty($cls)) {
    $cls = $_REQUEST['cls'];

    switch ($cls) {
        case '1' :
            $len = strlen($where);
            if ($len >> 0) {
                $where .= " AND ";
            }
            $where .= " (a.cls_date !='0000-00-00' or a.cls_date <= '" . $arg_date2 . "') ";
            $len = strlen($filterdesc);
            if ($len >> 0) {
                $filterdesc .= " AND ";
            } $filterdesc .= "Close Date ";

            $where .= "and a.cls_date>='" . $arg_date1 . "' and a.cls_date<='" . $arg_date2 . "'";
            break;
        case '2' :
            $len = strlen($where);
            if ($len >> 0) {
                $where .= " AND ";
            }
            $where .= " (a.cls_date='0000-00-00' or a.cls_date is null or a.cls_date > '" . $arg_date2 . "') ";
            $len = strlen($filterdesc);
            if ($len >> 0) {
                $filterdesc .= " AND ";
            } $filterdesc .= "Close Date ";
            break;
        case '3' :
            break;
    }
}

$rptFile = "veh_argh.php";
 
$statsql = "select a.*,
                sum(b.pd_paid) as pd_paid,sum(b.pd_disc) as pd_disc
                from " . $db1 . ".veh_argh a left join " . $db1 . ".veh_argd b on a.arg_inv_no = b.arg_inv_no
                ";

if (!empty($trans)) {
    $trans = $_REQUEST['trans'];

    if ($trans == '1') {
        $rptFile = "veh_argd.php";
        
        $statsql = "select a.*,
                b.sal_inv_no,b.sal_date,b.cust_code,b.chassis,b.engine,
                b.so_no,b.so_date,b.inv_total,b.pd_begin,b.pd_paid,b.pd_disc,b.pd_end,b.pph23,
                b.add_by,b.add_date,b.ref_no,b.pay_vat,b.pay_bbn, b.note
                from " . $db1 . ".veh_argd b left join " . $db1 . ".veh_argh a on b.arg_inv_no = a.arg_inv_no
                ";
    }
}


//$statsql .= $where . " " . $order ;
$statsql .= $where;

if ($trans !== '1') {
        $statsql .= " Group by a.arg_inv_no ";
}
$mounth = rangeMounth($arg_date1, $arg_date2);

$statsql .= queryUnion($mounth, $db1, $statsql);

$statsql .= $order . ' ASC';
//echo $statsql;exit;
$dtl = mysql_query($statsql) or die(mysql_error());
if (mysql_num_rows($dtl) == 0) {
    echo "Tidak ada data";
    return;
}


include "pembayaranpiutangkendaraangabungan/" . $rptFile;
$filename = 'VehicleAccountGroupReceivable_' . date('dmy') . '_' . date('his');

$tblimport = 'veh_argh';

echo outputReport($output, $tbl, $filename, $statsql, $tblimport);
?>