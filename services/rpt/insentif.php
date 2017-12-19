<?php

session_start();
$comp_name = "BELUM DI SET";
if (isset($_SESSION['comp_name'])) {
    $comp_name = $_SESSION['comp_name'];
}
$tbl = tblstyle();
// veh_slh harus sudah close

$order = " ORDER BY a.srep_code,a.srep_name";
$rptTitle = "INSENTIVE SALES REPORT";
$supp_type = '';
$title = '';
$filterdesc = '';
$where = "where 1=1 ";


$dtl = 0;


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

$db = $dbs;

if (!empty(mysql_fetch_array(mysql_query("SHOW DATABASES LIKE '$db' ")))) {

    if (!empty($_REQUEST['srep_name'])) {
        $where .= " AND a.srep_code='" . $_REQUEST['srep_code'] . "' AND a.srep_name='" . $_REQUEST['srep_name'] . "'";
    }
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

    if (!empty($_REQUEST['report_by'])) {

        $report_by = $_REQUEST['report_by'];


        switch ($report_by) {
            case '1':
                $rptFile = "based.php";
                break;
            case '2':
                $rptFile = "multiplier.php";
                break;
        }
    }

    $statsql = "select a.*,a.wrhs_code as wrhs_name from $db.veh_slh a  ";

    if (!empty($_REQUEST['off'])) {
        if ($_REQUEST['off'] !== 0) {
            $statsql = "select a.* from $db.veh_slh a left join veh_arh b on a.sal_inv_no=b.sal_inv_no ";
            $where .= ' AND b.pd_end <= 0 ';
        }
    }

    $where .=" AND YEAR(a.sal_date) = $year AND MONTH(a.sal_date) = $mth";

    $statsql .= $where . $order;

    $dtl = mysql_query($statsql) or die(mysql_error());
}
if (mysql_num_rows($dtl) == 0) {
    echo "Tidak ada data";
    return;
}


include "insentif/" . $rptFile;
$filename = 'insentif_' . date('d') . '_' . date('m') . '_' . date('Y');

echo outputReport($output, $tbl, $filename);
?>
