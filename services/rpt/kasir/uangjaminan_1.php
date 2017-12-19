<?php

//=============CHANGE LOG===========
//ganti title :
/*
  Sort Number DP =>Sort By DP No.
  Sort Date => Sort By Date
 */
session_start();
$comp_name = "BELUM DI SET";
if (isset($_SESSION['comp_name'])) {
    $comp_name = $_SESSION['comp_name'];
}

$tbl = tblstyle();

$rptTitle = "BOOKING FEE REPORT";


$rptFile = "veh_dpcc1.php";
$order = " ORDER BY so_no";

$cust_type = '';
$title = '';
$filterdesc = '';

$rptFile = "veh_dpcc1.php";

if (!empty($_REQUEST['group_by'])) {
    $group_by = $_REQUEST['group_by'];
    switch ($group_by) {
        case '1' :
            //$rptFile = "veh_dpcc1.php";
            $title = '(Sort By DP No.)';
            $order = " ORDER BY so_no, so_date";
            break;
        case '2' :
            // $rptFile = "veh_dpcc2.php";
            $title = '(Sort By Date)';
            $order = " ORDER BY cust_type, cust_code, cust_name";
            break;
    }
}


$where = "  WHERE 1=1 ";

$date1 = '1970-01-01';
$date2 = dateFormat($ar_date);

$date = explode('-', $date2);
$periode = $date[0] . $date[1];

$year = $date[0];
$mounth = $date[1];

$lenmth = strlen($mounth);

$mth = $mounth;

if ($lenmth == 1) {
    $int = 0;
    $mth = $int . $mounth;
}


$tahun = $_SESSION['tahun'];
$bulan = $_SESSION['bulan'];

$lenmth2 = strlen($bulan);
if ($lenmth2 == 1) {
    $int2 = 0;
    $bulan = $int2 . $bulan;
}

$period = strtotime($tahun . $bulan);
$periodselect = strtotime($year . $mth);

if ($periodselect < $period) {
    $dbs = $db1 . '_pr' . $year . $mth;
} else {
    $dbs = $db1;
}

$db1 = $dbs;

$statsql = "select a.*,c.chassis,c.engine,c.veh_code,c.veh_name,c.color_code,c.unit_price,c.tot_price,c.srep_code,c.srep_name,c.color_code,c.color_name
  from (
  select a.veh_price,a.dp_begin,a.dp_paid, a.dp_inv_no,a.dp_date,a.so_no,a.so_date,a.cust_code,a.cust_name,a.cust_type,a.note,
  count(b.pay_type)as pay_type,sum(b.pay_val) as pay_val,sum(b.used_val) as used_val,b.posted
  from ".$db1.".veh_dpch a inner join ".$db1.".veh_dpcd b on a.dp_inv_no = b.dp_inv_no and a.so_no = b.so_no
  group by a.dp_inv_no,a.dp_date,a.so_no,a.so_date,a.cust_code,a.cust_name,b.posted ) a
  left join ".$db1.".veh_spk c on a.so_no = c.so_no
  ";
  
if ($wrhs_axs !== 'ALL') {
    $where .= " AND a.wrhs_code='$wrhs_axs' ";
}
if (!empty($_REQUEST['ar_date'])) {
    $ar_date = dateFormat($_REQUEST['ar_date']);
    $len = strlen($where);
    if ($len >> 0) {
        $where .= " AND ";
    }
    $where .= " a.dp_date  <= '" . $ar_date . "' ";
    $len = strlen($filterdesc);
    if ($len >> 0) {
        $filterdesc .= " AND ";
    } $filterdesc .= "Date UJ ";
}

if (!empty($_REQUEST['so_no'])) {
    $so_no = $_REQUEST['so_no'];
    $len = strlen($where);
    if ($len >> 0) {
        $where .= " AND ";
    }
    $where .= " a.so_no  = '" . $so_no . "' ";
    $len = strlen($filterdesc);
    if ($len >> 0) {
        $filterdesc .= " AND ";
    } $filterdesc .= "SPK No. ";
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
    } $filterdesc .= "Customer";
}

/*
  if (!empty($_REQUEST['rpt_by'])) {
  $rpt_by = $_REQUEST['rpt_by'];

  switch ($rpt_by) {
  case '1':
  $statsql = "select a.* from " . $db1 . ".veh_dpch a ";
  break;

  case '2':
  //$where .= " and b.used_val = 0 and a.dp_end != 0 ";
  $statsql = "select a.* from " . $db1 . ".veh_dpch a ";
  //$statsql = "select a.*,  pd_paid=0, pd_disc=0,sum(pd_end) as pd_begin, DATEDIFF(curdate(),a.due_date) as aging from veh_arh a ";
  $rptFile = "veh_dpcc2.php";
  break;
  }
  }
 */
//$statsql .= $where . $order;
//$statsql .= $where . " Group by a.dp_inv_no " . $order;



$statsql .= $where;

$mounth = rangeMounth($date1, $date2);

$statsql .= queryUnion($mounth, $db1, $statsql);

$statsql .= " Group by a.dp_inv_no " ;
$statsql .= $order . ' ASC';
//echo $statsql;exit;
$dtl = mysql_query($statsql) or die(mysql_error());
if (mysql_num_rows($dtl) == 0) {
    echo "Tidak ada data";
    return;
}


include "uangjaminan/" . $rptFile;

$filename = 'downpayment_' . date('dmy') . '_' . date('his');

$tblimport = 'veh_dpch';

echo outputReport($output, $tbl, $filename, $statsql, $tblimport);
?>