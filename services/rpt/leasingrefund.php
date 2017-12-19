<?php
session_start();
$comp_name = "BELUM DI SET";
if (isset($_SESSION['comp_name'])) {
    $comp_name = $_SESSION['comp_name'];
}

$tbl = tblstyle();

$date1 = dateFormat($date1);        
$date2 = dateFormat($date2);

$rptTitle = 'LEASING & REFUND VEHICLE INSURANCE REPORT';

$table = 'veh_slh';

//$where = ' WHERE 1=1';
$where = " WHERE 1=1 and a.sal_date >='" . $date1 . "' and a.sal_date <='" . $date2 . "' and  lease_code not in('')";
$order = '';
$join = '';
$group = '';

/*
$select = "a.cust_name,a.cust_code,a.lease_code,a.lease_name,a.so_no,a.so_date,
a.veh_model,a.veh_type,a.chassis,a.engine,a.veh_year,a.color_code,a.color_name,
a.crd_term,a.crd_mthpay,a.crd_irate,a.crdinscode,a.srep_code,a.srep_name,a.crdinscomm,a.crdinsdisc,a.wrhs_code";
*/

if (!empty($_REQUEST['wrhs_code'])) {
    $where .= " and a.wrhs_code='$wrhs_code'";
}

if (!empty($_REQUEST['lease_code'])) {
    $where .= " and a.lease_code='$lease_code'";
}

if (!empty($_REQUEST['cust_code'])) {
    $where .= " and a.cust_code='$cust_code'";
}

if (!empty($_REQUEST['srep_code'])) {
    $where .= " and a.srep_code='$srep_code'";
}

if (!empty($_REQUEST['insr_code'])) {
    $where .= " and a.crdinscode='$insr_code'";
}



switch ($cls) {
    case '1':
        $title = '(CLOSED)';
        $where .= " and a.cls_date NOT IN('0000-00-00')";
        break;
    case '2':
        $title = '(NOT CLOSED)';
        $where .= " and a.cls_date IN('0000-00-00')";
        break;

}

switch ($group_by) {
    case '1':
        $order = " ORDER BY cust_name, lease_code";
        $rptFile = 'leasingrefund/customer.php';
        break;

    case '2':
        $order = " ORDER BY lease_code, cust_name";
        $rptFile = 'leasingrefund/leasing.php';
        break;

    case '3':
        $order = " ORDER BY crdinscode, crdinsname";
        $rptFile = 'leasingrefund/insurance.php';
        break;

    case '4':
        $order = " ORDER BY chassis, veh_model";
        $rptFile = 'leasingrefund/chassis.php';
        break;

    case '5':
        $order = " ORDER BY srep_name, cust_name";
        $rptFile = 'leasingrefund/sales.php';
        break;
}

$statsql = "select * from " . $db1 . ".$table a";

$statsql .= $join;
$statsql .= $where;

$mounth = rangeMounth($date1, $date2);

$statsql .= queryUnion($mounth,$db1,$statsql);

$statsql .= $group;
$statsql .= $order.' ASC';

$dtl = mysql_query($statsql) or die(mysql_error());

if (mysql_num_rows($dtl) == 0) {
    echo "Tidak ada data";
    return;
}


include $rptFile;

$filename = 'leasingrefund_' . date('dmy') . '_' . date('his');

$tblimport = 'veh_slh';

$keys = array(
    'key1' => 'creditlease'
);
echo outputReport($output, $tbl, $filename, $statsql, $tblimport, $keys);
