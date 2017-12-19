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
$rpt_by = $_REQUEST['rpt_by'];

if (!empty(mysql_fetch_array(mysql_query("SHOW DATABASES LIKE '$db1' ")))) {
    $where_header = "  WHERE 1=1 ";

    if (!empty($_REQUEST['group_by'])) {
        $group_by = $_REQUEST['group_by'];
        switch ($group_by) {
            case '1' :
                $rptFile = "veh_dpcc1.php";
                $title = '(Sort By DP No.)';
                $order = " ORDER BY so_no, so_date";
                break;
            case '2' :
                $rptFile = "veh_dpcc2.php";
                $title = '(Sort By Date)';
                $order = " ORDER BY cust_type, cust_code, cust_name";
                break;
        }
    }

    if ($wrhs_axs !== 'ALL') {
        $where_header .= " AND a.wrhs_code='$wrhs_axs' ";
    }
    if (!empty($_REQUEST['ar_date'])) {
        $ar_date = dateFormat($_REQUEST['ar_date']);
        $len = strlen($where_header);
        if ($len >> 0) {
            $where_header .= " AND ";
        }
        $where_header .= " a.dp_date  <= '" . $ar_date . "' ";
        $len = strlen($filterdesc);
        if ($len >> 0) {
            $filterdesc .= " AND ";
        } $filterdesc .= "Date UJ ";
    }

    if (!empty($_REQUEST['so_no'])) {
        $so_no = $_REQUEST['so_no'];
        $len = strlen($where_header);
        if ($len >> 0) {
            $where_header .= " AND ";
        }
        $where_header .= " a.so_no  = '" . $so_no . "' ";
        $len = strlen($filterdesc);
        if ($len >> 0) {
            $filterdesc .= " AND ";
        } $filterdesc .= "SPK No. ";
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
        } $filterdesc .= "Customer";
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


    if (!empty($_REQUEST['rpt_by'])) {

        switch ($rpt_by) {
            case '1':

                $statsql = "create temporary table temp_dpcd select * from " . $db1 . ".veh_dpcd where " . $where_detail;

                mysql_query($statsql) or die(mysql_error());

                $statsql = "create temporary table temp_spk select * from " . $db1 . ".veh_spk ";
                mysql_query($statsql) or die(mysql_error());

                $statsql = "create temporary table temp_dpch select a.dp_inv_no,a.dp_date,a.cust_type,a.so_no,a.so_date,a.cust_code,a.cust_name,a.veh_name,a.color_code,a.color_name,a.note,
                            a.veh_price,a.dp_end,
                            IF(b.posted=1,IFNULL(b.pay_val,000000000000),000000000000) as dp_begin,
                            IF(b.posted=0,IFNULL(b.pay_val,000000000000),000000000000) as dp_paid,
                            IF(b.use_date <='$ar_date',b.used_val,000000000000) as used_val
                            from " . $db1 . ".veh_dpch a 
                            inner join temp_dpcd b on a.dp_inv_no = b.dp_inv_no and a.so_no = b.so_no
                            left join temp_spk c on a.so_no = c.so_no
                        ";

                mysql_query($statsql) or die(mysql_error());

                $statsql = "select dp_inv_no,dp_date,cust_type,so_no,so_date,cust_code,cust_name,veh_name,color_code,color_name,note,
                            veh_price, sum((dp_begin + dp_paid)- used_val) as dp_end, sum(dp_begin) as dp_begin,sum(dp_paid) as dp_paid, sum(used_val) as dp_used from temp_dpch ";
                $where = "where 1=1 ";
                $statsql .= $where;

                $statsql .= " Group by dp_inv_no ";
                $statsql .= $order . ' ASC';

                $dtl = mysql_query($statsql) or die(mysql_error());

                break;

            case '2':
                $statsql = "create temporary table temp_dpcd1
                                SELECT dp_inv_no,sum(pay_val) as pay_val, sum(used_val) as used_val 
                                    FROM " . $db1 . ".veh_dpcd WHERE ";
                $statsql .= $where_detail . $where_detail1 . " GROUP BY dp_inv_no";

                mysql_query($statsql);

                //echo $statsql;echo '<br /><br />';
                $statsql = "create temporary table temp_dpcd2
                                SELECT dp_inv_no,sum(pay_val) as pay_val, sum(used_val) as used_val 
                                    FROM " . $db1 . ".veh_dpcd WHERE ";
                $statsql .= $where_detail . $where_detail2 . " GROUP BY dp_inv_no";

                mysql_query($statsql);
                // echo $statsql;echo '<br /><br />';
                $statsql = "create temporary table temp_dpcd3
                                SELECT use_date,dp_inv_no,sum(pay_val) as pay_val, sum(used_val) as used_val 
                                    FROM " . $db1 . ".veh_dpcd WHERE ";
                $statsql .= "use_date <= '" . $ar_date . "' GROUP BY dp_inv_no";

                mysql_query($statsql);
                 //echo $statsql;echo '<br /><br />';
                $statsql = "create temporary table temp_spk select * from " . $db1 . ".veh_spk WHERE so_date <= '$ar_date'";

                mysql_query($statsql);
                 //echo $statsql;echo '<br /><br />';
                $statsql = "create temporary table temp_dpch 
                            SELECT 
                            a.dp_inv_no,a.dp_date,a.cust_type,a.so_no,a.so_date,a.cust_code,a.cust_name,a.veh_name,a.color_code,a.color_name,a.note,
                            a.veh_price,
                            IF(a.dp_date<'$ar_date',IFNULL(b.pay_val,000000000000),000000000000) as dp_begin,
                            IFNULL(c.pay_val,000000000000) as dp_paid,
                            IF(d.use_date <='$ar_date',IFNULL(d.used_val,000000000000),000000000000) as dp_used
                            FROM " . $db1 . ".veh_dpch a
                            LEFT JOIN temp_dpcd1 b on a.dp_inv_no=b.dp_inv_no
                            LEFT JOIN temp_dpcd2 c on a.dp_inv_no=c.dp_inv_no
                            LEFT JOIN temp_dpcd3 d on a.dp_inv_no=d.dp_inv_no
                            LEFT JOIN temp_spk e on a.so_no=e.so_no ";

                $where = "where 1=1 ";
                $statsql .= $where;
                $statsql .= " Group by dp_inv_no ";
                mysql_query($statsql);
                // echo $statsql;echo '<br /><br />';
                $statsql = "create temporary table temp_dpch2 select dp_inv_no,dp_date,cust_type,so_no,so_date,cust_code,cust_name,veh_name,color_code,color_name,note,
                                veh_price,sum(dp_begin) as dp_begin,sum(dp_paid) as dp_paid, sum(dp_used) as dp_used, sum((dp_begin + dp_paid) - dp_used) as dp_end
                                from temp_dpch group by dp_inv_no";
                mysql_query($statsql);
                // echo $statsql;echo '<br /><br />';

                $statsql = "select dp_inv_no,dp_date,cust_type,so_no,so_date,cust_code,cust_name,veh_name,color_code,color_name,note,"
                        . "sum(veh_price) as veh_price,sum(dp_begin) as dp_begin,sum(dp_paid) as dp_paid, sum(dp_used) as dp_used, sum(dp_end) as dp_end "
                        . "from temp_dpch2 where dp_end > 0 or dp_paid != 0";
                $statsql .= " Group by dp_inv_no ";
                $statsql .= $order . ' ASC';

                $dtl = mysql_query($statsql) or die(mysql_error());
                // echo $statsql;echo '<br /><br />';exit;
                break;
        }
    }
}

if (mysql_num_rows($dtl) == 0) {
    echo "Tidak ada data";
    return;
}

//$statsql = "select * from veh_dpch a inner join veh_dpcd b on a.dp_inv_no=b.dp_inv_no";
//$dtl = mysql_query($statsql) or die(mysql_error());
include "uangjaminan/" . $rptFile;

$filename = 'downpayment_' . date('dmy') . '_' . date('his');

$tblimport = 'veh_dpch';

echo outputReport($output, $tbl, $filename, $statsql, $tblimport);
?>