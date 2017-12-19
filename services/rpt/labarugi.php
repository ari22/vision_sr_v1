<?php
session_start();
$comp_name = "BELUM DI SET";
if (isset($_SESSION['comp_name'])) {
    $comp_name = $_SESSION['comp_name'];
}

$tbl = tblstyle();

$table = 'veh_slh';

switch ($form) {
    case 'penjualan':
        $title = 'CALCULATION OF INCOME GROSS VEHICLE SALES REPORT';
        break;

    case 'all':
        $title = 'CALCULATION OF SALES GROSS PROFIT LOSS VEHICLE, INSURANCE, OPTIONAL REPORT';
        break;

    case 'optional':
       
        $title = 'CALCULATION OF INCOME GROSS VEHICLE SALES OPTIONAL REPORT';
        break;
}


$where = ' WHERE 1=1';
$order = '';
$join = '';
$group = '';


$select = ' a.cust_code, a.cust_name, a.wrhs_code, a.veh_code, a.veh_name, a.veh_brand, a.veh_type, a.veh_model, a.veh_year, a.chassis, a.fp_no, a.kwit_no, a.kwit_date, a.veh_price, a.veh_bbn, a.veh_disc, a.veh_misc, a.veh_at, a.veh_total, a.veh_vat, a.veh_pbm, a.veh_bt';
$select .=' ,a.pur_price, a.pur_misc, a.pur_vat, a.pur_bt,b.qty';

if (!empty($_REQUEST['wrhs_code']) && $_REQUEST['wrhs_code'] != "ALL") {
    $wrhs_code = $_REQUEST['wrhs_code'];
    $len = strlen($where);
    if ($len >> 0) {
        $where .= " AND ";
    }
    $where .= " a.wrhs_code  = '" . $wrhs_code . "' ";
    if ($len >> 0) {
        $filterdesc .= ", ";
    } $filterdesc .= "Warehouse =" . $wrhs_code;
}
if (!empty($_REQUEST['veh_code'])) {
    $veh_code = $_REQUEST['veh_code'];
    $len = strlen($where);
    if ($len >> 0) {
        $where .= " AND ";
    }
    $where .= " a.veh_code  = '" . $veh_code . "' ";
    if ($len >> 0) {
        $filterdesc .= ", ";
    } $filterdesc .= "Vehicle Code = " . $veh_code;
}
if (!empty($_REQUEST['cust_code1'])) {
    $cust_code = $_REQUEST['cust_code1'];
    $len = strlen($where);
    if ($len >> 0) {
        $where .= " AND ";
    }
    $where .= " a.cust_code  = '" . $cust_code. "' ";
    if ($len >> 0) {
        $filterdesc .= ", ";
    } $filterdesc .= "Customer = " . $cust_code;
}
if (!empty($_REQUEST['cust_code'])) {
    $cust_code = $_REQUEST['cust_code'];
    $len = strlen($where);
    if ($len >> 0) {
        $where .= " AND ";
    }
    $where .= " a.cust_code  = '" . $cust_code. "' ";
    if ($len >> 0) {
        $filterdesc .= ", ";
    } $filterdesc .= "Customer = " . $cust_code;
}

$date1 = dateFormat($date1);        
$date2 = dateFormat($date2);

//if($form !== 'optional'){
    $where .= " and a.cls_date NOT IN('0000-00-00') and a.cls_date >='" . $date1 . "' and a.cls_date <='" . $date2 . "'";
//}

switch ($group_by) {
    case '1':
        $order = " ORDER BY a.chassis,a.cust_type";
        //$order = " ORDER BY a.veh_code, a.veh_name";
        switch ($form) {
            case 'penjualan':
                $rptFile = 'brutopenjualan/veh_code.php';
                break;

            case 'all':
                $rptFile = 'brutoall/veh_code.php';
                break;

            case 'optional':
                $rptFile = 'brutooptional/veh_code.php';
                break;
        }

        break;

    case '2':
        $where .= " and a.cust_type='2'";
        $order = " ORDER BY a.cust_type";
        switch ($form) {
            case 'penjualan':
                $rptFile = 'brutopenjualan/cust_reseller.php';
                break;
                
            case 'all':
                 $rptFile = 'brutoall/cust_reseller.php';
                break;

            case 'optional':
                 $rptFile = 'brutooptional/cust_reseller.php';
                break;
        }
        break;

    case '3':
        $order = " ORDER BY a.wrhs_code,a.veh_code, a.veh_name";

        switch ($form) {
            case 'penjualan':
                $rptFile = 'brutopenjualan/wrhs_code.php';
                break;

            case 'all':
                 $rptFile = 'brutoall/wrhs_code.php';
                break;

            case 'optional':
                  $rptFile = 'brutooptional/wrhs_code.php';
                break;
        }


        break;

    case '4':
        $order = " ORDER BY a.cust_code, a.cust_name";

        switch ($form) {

            case 'all':
                 $rptFile = 'brutoall/customer.php';
                break;

            case 'optional':
                 $rptFile = 'brutooptional/customer.php';
                break;
        }
        break;
}

if($form == 'all'){
    $statsql = "select a.wrhs_code,a.veh_code,a.veh_name,a.kwit_no,a.kwit_date,a.chassis,a.cust_name,a.cust_code,a.fp_no,a.veh_bt,a.pur_bt,a.veh_bbn,c.tot_price,d.price_ad from $db1.$table a left join $db1.veh_prh b on a.pur_inv_no=b.pur_inv_no left join $db1.acc_wslh c on a.sal_inv_no=c.vsl_inv_no left join $db1.veh_bprd d on a.sal_inv_no=d.sal_inv_no";
}
if($form == 'penjualan'){
    $statsql = "select a.* from $db1.$table a left join $db1.veh_prh b on a.pur_inv_no=b.pur_inv_no";
}
if($form == 'optional'){
    $select = ' a.sal_inv_no,a.wrhs_code, a.cust_name, a.cust_code, a.chassis, a.veh_code, a.veh_name, a.srv_price, a.srv_disc, a.srv_bt, a.inv_stamp, a.srv_at, a.pur_misc';
    $select .= ' ,price_bd, disc_val, price_ad';
    $statsql = "select $select from $db1.$table a left join (select sal_inv_no,sum(price_bd) as price_bd, sum(disc_val) as disc_val, sum(price_ad) as  price_ad from $db1.acc_wprd group by sal_inv_no) b on a.sal_inv_no=b.sal_inv_no";
}
$statsql .= $join;
$statsql .= $where;
//$statsql .= $group;
//$statsql .= $order;

$mounth = rangeMounth($date1, $date2);

$statsql .= queryUnion($mounth,$db1,$statsql);

$statsql .= $group;
$statsql .= $order.' ASC';
//echo $statsql;exit;

$dtl = mysql_query($statsql) or die(mysql_error());
if (mysql_num_rows($dtl) == 0) {
    echo "Tidak ada data";
    return;
}
$dtl2 = 0;
if($form == 'penjualan'){
    $statsql2 = "select $select from $db1.veh_rslh a left join $db1.veh_rprh b on a.pur_inv_no=b.pur_inv_no";
    $statsql2 .= $join;
    $statsql2 .= $where;
    //$statsql2 .= $group;
    //$statsql2 .= $order;
    $mounth = rangeMounth($date1, $date2);

    $statsql2 .= queryUnion($mounth,$db1,$statsql2);

    $statsql2 .= $group;
    $statsql2 .= $order.' ASC';
    //echo $statsql2;exit;
    $dtl2 = mysql_query($statsql2) or die(mysql_error());
}
$countreturn = mysql_num_rows($dtl2);


/*
  $dtlrow = mysql_fetch_array($dtl);
  $dtlrow = mysql_fetch_array($dtl2);


  echo '<pre>';
  print_r($dtlrow);
  echo '</pre>';
  exit;
 * 
 */
if (mysql_num_rows($dtl) == 0 ) {
    echo "Tidak ada data";
    return;
}



 include "labarugi/" . $rptFile;
 $filename = 'labarugi_' . date('d') . '_' . date('m') . '_' . date('Y');

echo outputReport($output, $tbl, $filename);