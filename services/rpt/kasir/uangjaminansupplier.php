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

$rptTitle = "BOOKING FEE SUPPLIER REPORT";

$rptFile = "veh_dpcc1.php";
$order = " ORDER BY po_no";

$cust_type = '';
$title = '';
$filterdesc = '';

$date = dateFormat($date);

$date = explode('-', $date);
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
                $title = '(Sort By PO No.)';
                $order = " ORDER BY po_no, po_date";
                break;
            case '2' :
                $rptFile = "veh_dpcc2.php";
                $title = '(Sort By Supplier)';
                $order = " ORDER BY supp_code, supp_name";
                break;
        }
    }

    if ($wrhs_axs !== 'ALL') {
        $where_header .= " AND a.wrhs_code='$wrhs_axs' ";
    }
    if (!empty($_REQUEST['po_no'])) {
        $po_no = $_REQUEST['po_no'];
        $len = strlen($where_header);
        if ($len >> 0) {
            $where_header .= " AND ";
        }
        $where_header .= " a.po_no  = '" . $po_no . "' ";
        $len = strlen($filterdesc);
        if ($len >> 0) {
            $filterdesc .= " AND ";
        } $filterdesc .= "SPK No. ";
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
        } $filterdesc .= "Customer";
    }

    if (!empty($_REQUEST['date'])) {
        $ar_date = dateFormat($_REQUEST['date']);
        $len = strlen($where_header);
        if ($len >> 0) {
            $where_header .= " AND ";
        }
        $where_header .= " a.po_date  <= '" . $date . "' ";
        $len = strlen($filterdesc);
        if ($len >> 0) {
            $filterdesc .= " AND ";
        } $filterdesc .= "Date UJ ";
    }

    if (!empty($_REQUEST['date'])) {
        $len = strlen($where_detail);
        if ($len >> 0) {
            $where_detail .= " AND ";
        }
        if ($rpt_by == '1') {
            $where_detail .= " pay_date  <= '" . dateFormat($_REQUEST['date']) . "' ";
        } else {
            $where_detail1 = " pay_date  < '" . dateFormat($_REQUEST['date']) . "' ";
            $where_detail2 = " pay_date  = '" . dateFormat($_REQUEST['date']) . "' ";
        }
        $len = strlen($filterdesc);
        if ($len >> 0) {
            $filterdesc .= " AND ";
        } $filterdesc .= "Tanggal Bayar ";
    }

    if (!empty($_REQUEST['rpt_by'])) {
        $rpt_by = $_REQUEST['rpt_by'];

        switch ($rpt_by) {
            case '1':
               
                $statsql = "create temporary table temp_dpsd select * from " . $db1 . ".veh_dpsd where " . $where_detail;

                mysql_query($statsql) or die(mysql_error());

                $statsql = "create temporary table temp_po select * from " . $db1 . ".veh_po ";
                mysql_query($statsql) or die(mysql_error());

                $statsql = "create temporary table temp_dpsh select 
                            a.po_no,a.po_date,a.supp_code,a.supp_name,a.veh_code,a.veh_name,a.color_code,a.color_name,a.note,
                            a.veh_price,a.dp_end,
                            IF(b.posted=1,IFNULL(b.pay_bt,000000000000),000000000000) as dp_begin,
                            IF(b.posted=0,IFNULL(b.pay_bt,000000000000),000000000000) as dp_paid,
                            IF(b.use_date <='$date',b.used_val,000000000000) as used_val
                            from " . $db1 . ".veh_dpsh a 
                            inner join temp_dpsd b on a.po_no = b.po_no
                            left join temp_po c on a.po_no = c.po_no
                        ";

                mysql_query($statsql) or die(mysql_error());

                $statsql = "select po_no,po_date,supp_code,supp_name,veh_code,veh_name,color_code,color_name,note,
                            veh_price, sum((dp_begin + dp_paid)- used_val) as dp_end, sum(dp_begin) as dp_begin,sum(dp_paid) as dp_paid, sum(used_val) as dp_used from temp_dpsh ";
                $where = "where 1=1 ";
                $statsql .= $where;

                $statsql .= " Group by po_no ";
                $statsql .= $order . ' ASC';

                $dtl = mysql_query($statsql) or die(mysql_error());
                break;

            case '2':

                break;
        }
    }
}


if (mysql_num_rows($dtl) == 0) {
    echo "Tidak ada data";
    return;
}

include "uangjaminansupplier/" . $rptFile;

$filename = 'downpayment_supplier' . date('dmy') . '_' . date('his');

$tblimport = 'veh_dpsh';

echo outputReport($output, $tbl, $filename, $statsql, $tblimport);
?>