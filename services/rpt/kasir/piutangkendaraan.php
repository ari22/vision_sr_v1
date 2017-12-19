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


    $where_header = " WHERE 1=1 ";
    if (!empty($_REQUEST['aging'])) {

        $aging = $_REQUEST['aging'];
        switch ($aging) {
            case '1':
                //$where_header .= " and a.due_date<='" . dateFormat($date) . "'";
                $title .= "<br />Aging By Due Date";
                break;
            case '2':
                //$where_header .= " and a.sal_date<='" . dateFormat($date) . "'";
                $title .= "<br />Aging By Invoice Date";
                break;
        }
    }


    if (!empty($_REQUEST['group_by'])) {
        $group_by = $_REQUEST['group_by'];
        switch ($group_by) {
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
        $len = strlen($where_header);
        if ($len >> 0) {
            $where_header .= " AND ";
        }
        $where_header .= " a.cust_code  = '" . $cust_code . "' ";
        $len = strlen($filterdesc);
        if ($len >> 0) {
            $filterdesc .= " AND ";
        } $filterdesc .= "Customer ";
    }

    if (!empty($_REQUEST['wrhs_code']) && $_REQUEST['wrhs_code'] != "ALL") {
        $wrhs_code = $_REQUEST['wrhs_code'];
        if ($wrhs_code !== 'ALL') {
            if ($wrhs_code !== 'ALL') {
                $len = strlen($where_header);
                if ($len >> 0) {
                    $where_header .= " AND ";
                }
                $where_header .= " a.wrhs_code  = '" . $wrhs_code . "' ";
                $len = strlen($filterdesc);
                if ($len >> 0) {
                    $filterdesc .= " AND ";
                } $filterdesc .= "Warehouse ";
            }
        }
    }
    if (!empty($_REQUEST['srep_code'])) {
        $srep_code = $_REQUEST['srep_code'];
        $len = strlen($where_header);
        if ($len >> 0) {
            $where_header .= " AND ";
        }
        $where_header .= " a.srep_code  = '" . $srep_code . "' ";
        $len = strlen($filterdesc);
        if ($len >> 0) {
            $filterdesc .= " AND ";
        } $filterdesc .= "Sales Rep. ";
    }

    if (!empty($_REQUEST['ar_date'])) {
        $len = strlen($where_header);
        if ($len >> 0) {
            $where_header .= " AND ";
        }

        $where_header .= " a.sal_date  <= '" . dateFormat($_REQUEST['ar_date']) . "' ";
        $len = strlen($filterdesc);
        if ($len >> 0) {
            $filterdesc .= " AND ";
        } $filterdesc .= "Tanggal Bayar ";
    }

    if (!empty($_REQUEST['sinv_code'])) {
        $sinv_code = $_REQUEST['sinv_code'];
        $len = strlen($where_header);
        if ($len >> 0) {
            $where_header .= " AND ";
        }
        $where_header .= " a.sinv_code  = '" . $sinv_code . "' ";
        $len = strlen($filterdesc);
        if ($len >> 0) {
            $filterdesc .= " AND ";
        } $filterdesc .= "Pay Type ";
    }

    if (!empty($_REQUEST['ar_date'])) {
        $len = strlen($where_detail);
        if ($len >> 0) {
            $where_detail .= " AND ";
        }
        if ($rpt_by == '1') {
            $where_detail .= " pay_date  <= '" . dateFormat($_REQUEST['ar_date']) . "' ";
        } else {
            $where_detail1 = " pay_date  < '" . dateFormat($_REQUEST['ar_date']) . "' ";
            $where_detail2 = " pay_date  = '" . dateFormat($_REQUEST['ar_date']) . "' ";
        }
        $len = strlen($filterdesc);
        if ($len >> 0) {
            $filterdesc .= " AND ";
        } $filterdesc .= "Tanggal Bayar ";
    }

    if (!empty($_REQUEST['pay_type'])) {
        $pay_type = $_REQUEST['pay_type'];
        $len = strlen($where_detail);
        if ($len >> 0) {
            $where_detail .= " AND ";
        }
        $where_detail .= " pay_type  = '" . $pay_type . "' ";
        $len = strlen($filterdesc);
        if ($len >> 0) {
            $filterdesc .= " AND ";
        } $filterdesc .= "Pay Type ";
    }



    if (!empty($_REQUEST['rpt_by'])) {


        switch ($rpt_by) {
            case '1':
                $statsql = "create temporary table temp_arh select a.* from " . $db1 . ".veh_arh a  ";
                $statsql .= $where_header;

                mysql_query($statsql) or die(mysql_error());

                $where = " where sal_inv_no in (select sal_inv_no from temp_arh) ";

                $statsql = "create temporary table temp_ard select * from " . $db1 . ".veh_ard " . $where . " and " . $where_detail;

                mysql_query($statsql) or die(mysql_error());

                $where = "where 1=1 ";

                $statsql = "select a.*,a.due_date,
                            sum(b.pay_val) as pd_paid,sum(b.disc_val) as pd_disc
                        from temp_arh a left join temp_ard b on a.sal_inv_no = b.sal_inv_no
                        ";

                $statsql .= $where;
                $statsql .= " Group by a.sal_inv_no ";
                $statsql .= $order . ' ASC';
                $dtl = mysql_query($statsql) or die(mysql_error());
                break;

            case '2':
                $statsql1 = "create temporary table temp_ard1
                                SELECT sal_inv_no,sum(pay_val) as pay_val, sum(disc_val) as disc_val 
                                    FROM " . $db1 . ".veh_ard WHERE ";
                $statsql1 .= $where_detail . $where_detail1 . " GROUP BY sal_inv_no";

                mysql_query($statsql1) or die(mysql_error());


                $statsql2 = "create temporary table temp_ard2
                        SELECT sal_inv_no,sum(pay_val) as pay_val, sum(disc_val) as disc_val 
                        FROM " . $db1 . ".veh_ard WHERE ";
                $statsql2 .= $where_detail . $where_detail2 . " GROUP BY sal_inv_no";

                mysql_query($statsql2) or die(mysql_error());

                $statsql3 = "create temporary table temp_arh
                SELECT a.sinv_code,a.inv_total, a.sal_inv_no,a.sal_date,a.chassis,a.engine,a.veh_code,a.veh_name,a.color_code,a.color_name,a.due_date,a.cust_code,a.cust_name,a.srep_code,a.srep_name,a.wrhs_code,a.lease_code,a.lease_name,
                IF(a.sal_date<'$ar_date',a.pd_begin-IFNULL(b.pay_val,000000000000),000000000000) as pd_begin,
                IF(a.sal_date='$ar_date',a.pd_begin,000000000000) as penjualan,
                IFNULL(c.pay_val,000000000000) as pd_paid,
                IFNULL(c.disc_val,00000000000000) as pd_disc,
                0000000000000 as pd_end 
                FROM " . $db1 . ".veh_arh a 
                LEFT JOIN temp_ard1 b ON a.sal_inv_no = b.sal_inv_no 
                LEFT JOIN temp_ard2 c ON a.sal_inv_no = c.sal_inv_no ";
                $statsql3 .= $where_header;

                mysql_query($statsql3) or die(mysql_error());

                $statsql4 = "create temporary table temp_arh2 SELECT sinv_code,sal_inv_no,sal_date,chassis,engine,veh_code,veh_name,color_code,color_name,due_date,cust_code,cust_name,srep_code,srep_name,wrhs_code, lease_code,lease_name,"
                        . "inv_total, sum(pd_begin) as pd_begin, sum(penjualan) as veh_total,sum(pd_paid) as pd_paid, sum(pd_disc) as pd_disc,sum(pd_begin+penjualan-pd_paid-pd_disc) as pd_end FROM temp_arh ";

                $statsql4 .= " Group by sal_inv_no ";
                $statsql4 .= $order . ' ASC';

                mysql_query($statsql4) or die(mysql_error());

                $statsql5 = "select * from temp_arh2 where 1=1 and pd_begin =0 and veh_total =0 and pd_paid =0 and pd_end =0";
                $dtl1 = mysql_query($statsql5) or die(mysql_error());
                
                while ($dtlrow1 = mysql_fetch_array($dtl1)) {

                    $rows[] = $dtlrow1['sal_inv_no'];
                }

                $encode = json_encode($rows);
                $encode = str_replace('[', '(', $encode);
                $encode = str_replace(']', ')', $encode);
                
                if($encode !== 'null'){
                    $statsql6 = "select * from temp_arh2 where sal_inv_no not in $encode";
                }else{
                    $statsql6 = "select * from temp_arh2";
                }
                
                $dtl = mysql_query($statsql6) or die(mysql_error());
                break;
        }
    }
}



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