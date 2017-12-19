<?php

session_start();
$comp_name = "BELUM DI SET";
if (isset($_SESSION['comp_name'])) {
    $comp_name = $_SESSION['comp_name'];
}

$tbl = tblstyle();

$rptTitle = "ACCOUNT RECEIVABLE REPORT";

$rptFile = "veh_arc3.php";
$order = " ";

$cust_type = '';

$title = '';
$filterdesc = '';

$ar_datefrom = '1970-01-01';
$ar_date = dateFormat($_REQUEST['ar_date']);

$date = explode('-', $ar_date);
$periode  = $date[0].$date[1];

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

$where = " WHERE 1=1 ";
//$where =" WHERE 1=1 and pd_end>0 ";
if (!empty($_REQUEST['aging'])) {

    $aging = $_REQUEST['aging'];
    switch ($aging) {
        case '1':
            //$where .= " and a.due_date<='" . dateFormat($date) . "'";
            $title .= "<br />Aging By Due Date";
            break;
        case '2':
            //$where .= " and a.sal_date<='" . dateFormat($date) . "'";
            $title .= "<br />Aging By Invoice Date";
            break;
    }
}


if (!empty($_REQUEST['group_by'])) {
    $group_by = $_REQUEST['group_by'];
    switch ($group_by) {
        /* case '0' :
          if  ($_REQUEST['l_aging']==0)
          {
          $rptFile = "veh_arc3.php";
          }else
          {
          $rptFile = "veh_arc4.php";
          }
          $title = '(Beginning Balance Group By Date)';
          $order = " ORDER BY cust_code,sal_date,srep_code";
          break; */
        case '1' :
            if ($_REQUEST['l_aging'] == 0) {
                $rptFile = "veh_arc3.php";
            } else {
                $rptFile = "veh_arc4.php";
            }
            $title = '(Beginning Balance Group By Customer)';
            $order = " ORDER BY cust_code,sal_date,srep_code";
            break;
        case '2' :
            if ($_REQUEST['l_aging'] == 0) {
                $rptFile = "veh_ars3.php";
            } else {
                $rptFile = "veh_ars4.php";
            }
            $title = '(Beginning Balance Group By Sales)';
            $order = " ORDER BY srep_code, sal_date, cust_code";
            break;
        case '3' :
            if ($_REQUEST['l_aging'] == 0) {
                $rptFile = "veh_ari3.php";
            } else {
                $rptFile = "veh_ari4.php";
            }
            $title = '(Beginning Balance Group By Invoice Type)';
            $order = " ORDER BY sinv_code asc ";
            break;
        case '4' :
            if ($_REQUEST['l_aging'] == 0) {
                $rptFile = "veh_arl3.php";
            } else {
                $rptFile = "veh_arl4.php";
            }
            $title = '(Beginning Balance Group By Leasing)';
            $order = " ORDER BY lease_code, sal_inv_no, sal_date, cust_code";
            break;
    }
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

if (!empty($_REQUEST['wrhs_code']) && $_REQUEST['wrhs_code'] != "ALL") {
    $wrhs_code = $_REQUEST['wrhs_code'];
    if ($wrhs_code !== 'ALL') {
        if ($wrhs_code !== 'ALL') {
            $len = strlen($where);
            if ($len >> 0) {
                $where .= " AND ";
            }
            $where .= " a.wrhs_code  = '" . $wrhs_code . "' ";
            $len = strlen($filterdesc);
            if ($len >> 0) {
                $filterdesc .= " AND ";
            } $filterdesc .= "Warehouse ";
        }
    }
}
if (!empty($_REQUEST['srep_code'])) {
    $srep_code = $_REQUEST['srep_code'];
    $len = strlen($where);
    if ($len >> 0) {
        $where .= " AND ";
    }
    $where .= " a.srep_code  = '" . $srep_code . "' ";
    $len = strlen($filterdesc);
    if ($len >> 0) {
        $filterdesc .= " AND ";
    } $filterdesc .= "Sales Rep. ";
}
/* if (!empty($_REQUEST['aging'])) {
  $aging = $_REQUEST['aging'];

  switch ($aging) {
  case '1':
  $where .= " and a.due_date<='" . dateFormat($date) . "'";
  break;
  case '2':
  $where .= " and a.sal_date<='" . dateFormat($date) . "'";
  break;
  }
  } */


/* $statsql = "create temporary table temp_arh 
  select * from veh_arh a ".$where ;
  //echo $statsql;
  //mysql_query($statsql) or die(mysql_error()); */

//$where = " where a.sal_inv_no in (select sal_inv_no from temp_arh) " ;
if (!empty($_REQUEST['ar_date'])) {
    $len = strlen($where);
    if ($len >> 0) {
        $where .= " AND ";
    }
    $where .= " a.sal_date  <= '" . dateFormat($_REQUEST['ar_date']) . "' ";
    $len = strlen($filterdesc);
    if ($len >> 0) {
        $filterdesc .= " AND ";
    } $filterdesc .= "Tanggal Bayar ";
}

if (!empty($_REQUEST['sinv_code'])) {
    $sinv_code = $_REQUEST['sinv_code'];
    $len = strlen($where);
    if ($len >> 0) {
        $where .= " AND ";
    }
    $where .= " a.sinv_code  = '" . $sinv_code . "' ";
    $len = strlen($filterdesc);
    if ($len >> 0) {
        $filterdesc .= " AND ";
    } $filterdesc .= "Pay Type ";
}


/* $statsql = "create temporary table temp_ard 
  select * from veh_ard b ".$where ;
  //echo $statsql;

  //mysql_query($statsql) or die(mysql_error());

  //$where = "where 1=1 " ; */
/* $statsql ="select a.lease_code,a.lease_name,a.sinv_code,a.sal_inv_no,a.sal_date,a.chassis,a.engine,a.cust_code,a.cust_name,a.srep_code,a.srep_name,a.pd_begin,
  a.chassis,a.engine,a.veh_code,a.veh_name,a.inv_total,DATEDIFF(curdate(),a.due_date) as aging,a.due_date,
  sum(b.pay_val) as pd_paid,sum(b.disc_val) as pd_disc
  from veh_arh a inner join veh_ard b on a.sal_inv_no = b.sal_inv_no
  "; */

if (!empty($_REQUEST['rpt_by'])) {
    $rpt_by = $_REQUEST['rpt_by'];

    switch ($rpt_by) {
        case '1':
            $statsql = "select a.*, sum(b.pay_val) as pay_val, sum(b.disc_val) as disc_val, DATEDIFF(curdate(),a.due_date) as aging from " . $dbs . ".veh_arh a left join  " . $dbs . ".veh_ard b on a.sal_inv_no=b.sal_inv_no ";
            //$where .= " and b.pay_date  <= '" . $ar_date . "' and b.sal_inv_no !='' ";
            break;

        case '2':
            $where .= " and a.pd_end not in('0')";
            $statsql = "select a.*,  pd_paid=0, pd_disc=0,sum(pd_end) as pd_begin, DATEDIFF(curdate(),a.due_date) as aging from " . $dbs . ".veh_arh a ";
            break;
    }
}
$statsql2 = $statsql;
$statsql2 .= $where;

$mounths = rangeMounth($ar_datefrom, $ar_date);

if($dbs !== $db1){
   $statsql2  = str_replace($dbs, $db1, $statsql2);

}

$statsql .= $where;

$statsql .= queryUnion($mounths, $db1, $statsql);




$statsql .= " Group by a.sal_inv_no " . $order . ' ASC';
echo $statsql;exit;
$dtl = mysql_query($statsql) or die(mysql_error());
if (mysql_num_rows($dtl) == 0) {
    echo "Tidak ada data";
    return;
}


include "piutangkendaraan/" . $rptFile;

$filename = 'AccountReceivablePayment_' . date('dmy') . '_' . date('his');

$tblimport = 'veh_arh';
$keys = array(
    'key1' => 'default'
);
echo outputReport($output, $tbl, $filename, $statsql, $tblimport, $keys);
?>