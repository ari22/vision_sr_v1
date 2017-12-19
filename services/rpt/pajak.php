<?php

session_start();
$comp_name = "BELUM DI SET";
if (isset($_SESSION['comp_name'])) {
    $comp_name = $_SESSION['comp_name'];
}

$tbl = tblstyle();


$dtl = 0;
$year = $_REQUEST['year'];
$mounth = $_REQUEST['mounth'];

$lenmth = strlen($mounth);

$mth = $mounth;

if ($lenmth == 1) {
    $int = 0;
    $mth = $int . $mounth;
}

$select = " * ";
$group = "";
$period = $_SESSION['tahun'] . $_SESSION['bulan'];
$periodselect = $year . $mounth;

if ($periodselect !== $period) {
    $dbs = $db1 . '_pr' . $year . $mth;
} else {
    $dbs = $db1;
}

if (!empty(mysql_fetch_array(mysql_query("SHOW DATABASES LIKE '$dbs' ")))) {

    $order = " ";
    $filterdesc = '';
    $where = "where 1=1 ";

    $mounths = array
        (
        "1" => "Januari",
        "2" => "Februari",
        "3" => "Maret",
        "4" => "April",
        "5" => "Mei",
        "6" => "Juni",
        "7" => "Juli",
        "8" => "Agustus",
        "9" => "September",
        "10" => "Oktober",
        "11" => "November",
        "12" => "Desember"
    );

    if (isset($status)) {
        if ($status == 'exit') {
            $title = 'TAX LIST OUTPUT';

            $rptFile = "pajak_keluar.php";

            $where .=" AND YEAR(fp_date) = $year AND MONTH(fp_date) = $mounth";
        }
        if ($status == 'entry') {
            $title = 'ENTER TAX LIST';
            $rptFile = "pajak_masuk.php";
            $where .=" AND YEAR(fpi_date) = $year AND MONTH(fpi_date) = $mounth";
            $group = " GROUP BY fpi_no";
            
            $select = " sum(pur_vat) as pur_vat, supp_name,supp_npwp,fpi_no,fpi_date ";
        }
    }

    $statsql = "select $select from " . $dbs . ".$table ";
    $statsql .= $where . $order;
    $statsql .= $group;

    $dtl = mysql_query($statsql) or die(mysql_error());
}


if (mysql_num_rows($dtl) == 0) {
    echo "Tidak ada data";
    return;
}


include "pajak/" . $rptFile;
$filename = 'pajak_' . date('d') . '_' . date('m') . '_' . date('Y');

echo outputReport($output, $tbl, $filename);
