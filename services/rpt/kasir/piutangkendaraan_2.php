<?php

session_start();
$comp_name = "BELUM DI SET";
if (isset($_SESSION['comp_name'])) {
    $comp_name = $_SESSION['comp_name'];
}

$tbl = tblstyle();

$dtl = '';
$rptTitle = "ACCOUNT RECEIVABLE REPORT";

$rptFile = "veh_arc3.php";
$order = " ";

$cust_type = '';

$title = '';
$filterdesc = '';

$ar_datefrom = '1970-01-01';
$ar_date = dateFormat($_REQUEST['ar_date']);

$date = explode('-', $ar_date);
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
$rpt_by = $_REQUEST['rpt_by'];


if (!empty(mysql_fetch_array(mysql_query("SHOW DATABASES LIKE '$db1' ")))) {
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
                //$order = " ORDER BY sinv_code asc ";
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

    if (!empty($_REQUEST['ar_date'])) {
        $len = strlen($where);
        if ($len >> 0) {
            $where .= " AND ";
        }

        if ($rpt_by == '1') {
            $where .= " a.sal_date  <= '" . dateFormat($_REQUEST['ar_date']) . "' ";
        } else {
            $where1 = " a.sal_date  < '" . dateFormat($_REQUEST['ar_date']) . "' ";
            $where2 = " a.sal_date  = '" . dateFormat($_REQUEST['ar_date']) . "' ";
        }
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


    if (!empty($_REQUEST['rpt_by'])) {


        switch ($rpt_by) {
            case '1':
                $statsql = "create temporary table temp_arh select a.*, DATEDIFF(curdate(),a.due_date) as aging from " . $db1 . ".veh_arh a  ";
                $statsql .= $where;

                //mysql_query($statsql) or die(mysql_error());

                $where = " where sal_inv_no in (select sal_inv_no from temp_arh) ";

                break;

            case '2':
                $where3 .= $where;
                /*  $statsql1 = "select a.*,  a.pd_paid=0, a.pd_disc=0,  DATEDIFF(curdate(),a.due_date) as aging from " . $db1 . ".veh_arh a  ";
                  $statsql1 .= $where;
                  $statsql1 .= $where1;
                  $statsql1 .= " and a.pd_end !=0  and a.pd_paid !=0 ";
                  $sql1 = "create temporary table temp_arh1 ".$statsql1;

                  mysql_query($sql1) or die(mysql_error());

                  $temp_arh1 = " sal_inv_no in (select sal_inv_no from temp_arh1) and ";


                  $statsql2 = "select a.*,  a.pd_paid=0, a.pd_disc=0,  DATEDIFF(curdate(),a.due_date) as aging from " . $db1 . ".veh_arh a  ";
                  $statsql2 .= $where;
                  $statsql2 .= $where2;

                  $sql2 = "create temporary table temp_arh2 ".$statsql2;

                  mysql_query($sql2) or die(mysql_error());

                  $temp_arh2 = " sal_inv_no in (select sal_inv_no from temp_arh2) and ";


                  $statsql = "create temporary table temp_arh ".$statsql1. " UNION ".$statsql2;

                  mysql_query($statsql) or die(mysql_error());


                 */
                $where = ' where 1=1 ';
                break;
        }
    }


    if (!empty($_REQUEST['ar_date'])) {
        $len = strlen($where);
        if ($len >> 0) {
            $where .= " AND ";
        }
        if ($rpt_by == '1') {
            $where .= " pay_date  <= '" . dateFormat($_REQUEST['ar_date']) . "' ";
        } else {
            $where1 = " pay_date  < '" . dateFormat($_REQUEST['ar_date']) . "' ";
            $where2 = " pay_date  = '" . dateFormat($_REQUEST['ar_date']) . "' ";
        }
        $len = strlen($filterdesc);
        if ($len >> 0) {
            $filterdesc .= " AND ";
        } $filterdesc .= "Tanggal Bayar ";
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


    if (!empty($_REQUEST['rpt_by'])) {

        switch ($rpt_by) {
            case '1':
                $statsql = "create temporary table temp_ard select * from " . $db1 . ".veh_ard " . $where;
               // $dtl = mysql_query($statsql) or die(mysql_error());
                break;

            case '2':
                /* $statsql1 = "select * from " . $db1 . ".veh_ard ";
                  $statsql1 .= $where;
                  $statsql1 .= $temp_arh1;
                  $statsql1 .= $where1;

                  $temp_ard1 = "create temporary table temp_ard1 " . $statsql1;
                  $dtl = mysql_query($temp_ard1) or die(mysql_error());


                  $statsql2 = "select * from " . $db1 . ".veh_ard ";
                  $statsql2 .= $where;
                  $statsql2 .= $temp_arh2;
                  $statsql2 .= $where2;

                  $temp_ard2 = "create temporary table temp_ard2 " . $statsql2;
                  $dtl = mysql_query($temp_ard2) or die(mysql_error());

                  $statsql = "create temporary table temp_ard " . $statsql1 . " UNION " . $statsql2;

                  $dtl = mysql_query($statsql) or die(mysql_error());
                 * 
                 */
                $statsql1 = "create temporary table temp_ard1 SELECT sal_inv_no,sum(pay_val) as pay_val, sum(disc_val) as disc_val ;
                                FROM " . $db1 . ".veh_ard ";
                $statsql1 .= $where;
                $statsql1 .= $where1 .'  GROUP BY sal_inv_no ';
                
                $statsql2 = "create temporary table temp_ard2 SELECT sal_inv_no,sum(pay_val) as pay_val, sum(disc_val) as disc_val ;
                                FROM " . $db1 . ".veh_ard ";
                $statsql2 .= $where;
                $statsql2 .= $where2 .'  GROUP BY sal_inv_no ';
                
                break;
        }
    }




    $where = "where 1=1 ";


    if (!empty($_REQUEST['rpt_by'])) {
        $rpt_by = $_REQUEST['rpt_by'];

        switch ($rpt_by) {
            case '1':
                $statsql = "select a.*,DATEDIFF(curdate(),a.due_date) as aging,a.due_date,
                            sum(b.pay_val) as pd_paid,sum(b.disc_val) as pd_disc
                        from temp_arh a left join temp_ard b on a.sal_inv_no = b.sal_inv_no
                        ";
                break;

            case '2':

                /*$statsql = "select a.*,DATEDIFF(curdate(),a.due_date) as aging,a.due_date,
                         sum(b.pay_val) as pd_paid,sum(b.disc_val) as pd_disc
                        from temp_arh a left join temp_ard b on a.sal_inv_no = b.sal_inv_no 
                        ";*/
                // $where .= " and a.pd_end not in('0') ";
                
                $statsql = "";
                break;
        }
    }


    $statsql .= $where;


    $statsql .= " Group by a.sal_inv_no ";
    //$mounths = rangeMounth($ar_datefrom, $ar_date);
    //$statsql .= queryUnion($mounths, $db1, $statsql);


    $statsql .= $order . ' ASC';
    //echo $statsql;exit;

   // $dtl = mysql_query($statsql) or die(mysql_error());
}

$statsql = "create temporary table paybefore
SELECT sal_inv_no,sum(pay_val) as pay_val, sum(disc_val) as disc_val 
	FROM veh_ard WHERE pay_date < '2016-10-30' GROUP BY sal_inv_no";
$dtl = mysql_query($statsql) or die(mysql_error());	
$statsql = "create temporary table pay
	SELECT sal_inv_no,sum(pay_val) as pay_val, sum(disc_val) as disc_val 
	FROM veh_ard WHERE pay_date = '2016-10-30' GROUP BY sal_inv_no";
$dtl = mysql_query($statsql) or die(mysql_error());	
$statsql = "create temporary table temp2
SELECT a.sal_inv_no,a.sal_date,a.veh_code,a.cust_code,a.cust_name,a.chassis,
	IF(a.sal_date<'2016-10-30',a.pd_begin-IFNULL(b.pay_val,000000000000),000000000000) as pd_begin,
	IF(a.sal_date='2016-10-30',a.pd_begin,000000000000) as penjualan,
	IFNULL(c.pay_val,000000000000) as pd_paid,
	IFNULL(c.disc_val,00000000000000) as pd_disc,
	0000000000000 as pd_end 
	FROM veh_arh a 
	LEFT JOIN paybefore b ON a.sal_inv_no = b.sal_inv_no 
	LEFT JOIN pay c ON a.sal_inv_no = c.sal_inv_no 
	WHERE a.sal_date<='2016-10-30' 
	ORDER BY a.cust_name";
$dtl = mysql_query($statsql) or die(mysql_error());	
//$statsql = "SELECT temp2 replace ALL pd_end WITH pd_begin+penjualan-pd_paid-pd_disc";
//$dtl = mysql_query($statsql) or die(mysql_error());
$statsql = "SELECT sum(pd_begin),sum(penjualan),sum(pd_paid), sum(pd_disc),sum(pd_begin+penjualan-pd_paid-pd_disc) as pd_end FROM temp2";
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