<?php

session_start();
$comp_name = "BELUM DI SET";
if (isset($_SESSION['comp_name'])) {
    $comp_name = $_SESSION['comp_name'];
}

$tbl = tblstyle();
$rptTitle = "BBN PAYABLE REPORT";

$rptFile = "prt_aps2.php";
$order = " ";

$supp_type = '';
$title = '';
$filterdesc = '';

$ap_date = dateFormat($_REQUEST['ap_date']);


$date = explode('-', $ap_date);
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


if (!empty(mysql_fetch_array(mysql_query("SHOW DATABASES LIKE '$db1' ")))) {

    $where_header =" WHERE 1=1 and LEFT(a.pur_inv_no,3)='APB' ";
    
    if (!empty($_REQUEST['aging'])) {

        $aging = $_REQUEST['aging'];
        switch ($aging) {
            case '1':
                $title .= "<br />Aging By Due Date";
                break;
            case '2':
                $title .= "<br />Aging By Invoice Date";
                break;
        }
    }

    if ($_REQUEST['rpt_type'] == 1) {
        if ($_REQUEST['l_aging'] == 0) {
            $title = '(Beginning Balance)';
            $rptFile = "prt_aps1.php";
            $order = ' ORDER BY supp_code,supp_name,pur_inv_no';
        } else {
            $rptFile = "prt_aps2.php";
            if ($_REQUEST['aging_sortby'] == 0) {
                $order = ' ORDER BY supp_code,supp_name,pur_inv_no';
            } else {
                $order = ' ORDER BY supp_code,supp_name,pur_inv_no';
            }
        }
    }
    if ($_REQUEST['rpt_type'] == 2) {
       // $where_header .=" and hd_begin - hd_paid>0 ";
        $title = '(Beginning Balance Update)';
        if ($_REQUEST['l_aging'] == 0) {
            $rptFile = "prt_aps1.php";
            $order = ' ORDER BY supp_code,supp_name,pur_inv_no';
        } else {
            $rptFile = "prt_aps2.php";
            if ($_REQUEST['aging_sortby'] == 0) {
                $order = ' ORDER BY supp_code,supp_name,pur_inv_no';
            } else {
                $order = ' ORDER BY supp_code,supp_name,pur_inv_no';
            }
        }
    }

    if (!empty($_REQUEST['supp_code'])) {
        $supp_code = $_REQUEST['supp_code'];
        $len = strlen($where_header);
        if ($len >> 0) {
            $where_header .= " AND ";
        }
        $where_header .= " a.supp_code  = '" . $supp_code . "' ";
        $len = strlen($filterdesc);
        if ($len >> 0) {
            $filterdesc .= " AND ";
        } $filterdesc .= "Supplier ";
    }

    if (!empty($_REQUEST['wrhs_code'])) {
        $wrhs_code = $_REQUEST['wrhs_code'];
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


    if (!empty(dateFormat($_REQUEST['ap_date']))) {
        $len = strlen($where_header);
        if ($len >> 0) {
            $where_header .= " AND ";
        }
        $where_header .= " a.pur_date  <= '" . dateFormat($_REQUEST['ap_date']) . "' ";
        $len = strlen($filterdesc);
        if ($len >> 0) {
            $filterdesc .= " AND ";
        } $filterdesc .= "Payment Date ";
    }

    if (!empty($_REQUEST['ap_date'])) {
        $len = strlen($where);
        if ($len >> 0) {
            $where_detail .= " AND ";
        }
        if ($rpt_type == '1') {
            $where_detail .= " pay_date  <= '" . dateFormat($_REQUEST['ap_date']) . "' ";
        } else {
            $where_detail1 = " pay_date  < '" . dateFormat($_REQUEST['ap_date']) . "' ";
            $where_detail2 = " pay_date  = '" . dateFormat($_REQUEST['ap_date']) . "' ";
        }
        $len = strlen($filterdesc);
        if ($len >> 0) {
            $filterdesc .= " AND ";
        } $filterdesc .= "Tanggal Bayar ";
    }

    if (!empty($_REQUEST['rpt_type'])) {
        switch ($rpt_type) {
            case '1':
                $statsql = "create temporary table temp_aph select a.*, DATEDIFF(curdate(),a.due_date) as aging from " . $db1 . ".acc_aph a  ";
                $statsql .= $where_header;

                mysql_query($statsql) or die(mysql_error());
               
                $where = " where pur_inv_no in (select pur_inv_no from temp_aph) ";

                $statsql = "create temporary table temp_apd select * from " . $db1 . ".acc_apd b " . $where . " and " . $where_detail;
                mysql_query($statsql) or die(mysql_error());
 
                $where = "where 1=1 ";
                
                $statsql = "select a.*, a.inv_total as hd_purprice,
                            sum(b.pay_val) as hd_paid,sum(b.disc_val) as hd_disc
                            from temp_aph a left join temp_apd b on a.pur_inv_no = b.pur_inv_no
                        ";
                /*$statsql = "select a.*, 
                            IF(YEAR(a.pur_date) <= '$year' and Month(a.pur_date) < '$mounth',a.inv_total,000000000000) as hd_begin,
                            IF(YEAR(a.pur_date) = '$year' and Month(a.pur_date) = '$mounth',a.inv_total,000000000000) as hd_purprice,    
                            sum(b.pay_val) as hd_paid,
                            sum(b.disc_val) as hd_disc,
                            sum(a.inv_total - hd_paid - hd_disc) as hd_end
                            from temp_aph a left join temp_apd b on a.pur_inv_no = b.pur_inv_no
                        ";*/

                $statsql .= $where;
                $statsql .= " Group by a.pur_inv_no ";
                $statsql .= $order . ' ASC';
                $dtl = mysql_query($statsql) or die(mysql_error());

                break;

            case '2':
                $statsql1 = "create temporary table temp_apd1
                                SELECT pur_inv_no,sum(pay_val) as pay_val, sum(disc_val) as disc_val 
                                    FROM " . $db1 . ".acc_apd WHERE ";
                $statsql1 .= $where_detail . $where_detail1 . " GROUP BY pur_inv_no";

                mysql_query($statsql1);
                
                //echo $statsql1. '<br /><br />';

                $statsql2 = "create temporary table temp_apd2
                        SELECT pur_inv_no,sum(pay_val) as pay_val, sum(disc_val) as disc_val 
                        FROM " . $db1 . ".acc_apd WHERE ";
                $statsql2 .= $where_detail . $where_detail2 . " GROUP BY pur_inv_no";

                mysql_query($statsql2);
                
               // echo $statsql2. '<br /><br />';
                
                $statsql3 = "create temporary table temp_aph SELECT a.pinv_code,a.inv_total, a.pur_inv_no,a.pur_date,a.supp_invno,a.due_date,a.supp_code,a.supp_name,a.wrhs_code, 
                IF(a.pur_date<'$ap_date',a.hd_begin-IFNULL(b.pay_val,000000000000),000000000000) as hd_begin, 
                IF(a.pur_date='$ap_date',a.hd_begin,000000000000) as hd_purprice, 
                IFNULL(c.pay_val,000000000000) as hd_paid, 
                IFNULL(c.disc_val,00000000000000) as hd_disc, 0000000000000 as hd_end 
                FROM " . $db1 . ".acc_aph a 
                LEFT JOIN temp_apd1 b ON a.pur_inv_no = b.pur_inv_no 
                LEFT JOIN temp_apd2 c ON a.pur_inv_no = c.pur_inv_no";

                $statsql3 .= $where_header;

                mysql_query($statsql3) or die(mysql_error());

                //echo $statsql3. '<br /><br />';
                 
                $statsql4 = "create temporary table temp_aph2 SELECT pinv_code,pur_inv_no,pur_date,supp_invno,due_date,supp_code,supp_name,wrhs_code, "
                        . "inv_total, sum(hd_begin) as hd_begin, sum(hd_purprice) as hd_purprice,sum(hd_paid) as hd_paid, sum(hd_disc) as hd_disc,sum(hd_begin+hd_purprice-hd_paid-hd_disc) as hd_end FROM temp_aph ";

                $statsql4 .= " Group by pur_inv_no ";
                $statsql4 .= $order . ' ASC';
                
                mysql_query($statsql4) or die(mysql_error());
                
               
                //echo $statsql4. '<br /><br />'; exit;
                 
                $statsql5 = "select * from temp_aph2 where 1=1 and hd_begin =0 and hd_purprice =0 and hd_paid =0 and hd_end =0";
                $dtl1 = mysql_query($statsql5) or die(mysql_error());

                
                while ($dtlrow1 = mysql_fetch_array($dtl1)) {

                    $rows[] = $dtlrow1['pur_inv_no'];
                }

                $encode = json_encode($rows);
                $encode = str_replace('[', '(', $encode);
                $encode = str_replace(']', ')', $encode);

                if($encode !== 'null'){
                    $statsql6 = "select * from temp_aph2 where pur_inv_no not in $encode";
                }else{
                    $statsql6 = "select * from temp_aph2";
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

include "hutangbbn/" . $rptFile;
$filename = 'hutangbbn_' . date('d') . '_' . date('m') . '_' . date('Y');

echo outputReport($output, $tbl, $filename);
?>