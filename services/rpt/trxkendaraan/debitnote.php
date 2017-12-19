<?php
session_start();
$comp_name = "BELUM DI SET";
if (isset($_SESSION['comp_name'])) {
    $comp_name = $_SESSION['comp_name'];
}

$tbl = tblstyle();
$rptFile = "veh_prv.php";
$order = " ORDER BY a.veh_code,a.color_code,a.pur_date";
$rptTitle = "DEBIT NOTE REPORT";
$supp_type = '';
$title='';
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


/*
if (!empty($_REQUEST['group_by']))
{
	$group_by = $_REQUEST['group_by'];
	switch ($group_by)
	{
		case '1' :
			$rptFile = "veh_prv.php"; 
			$order = " ORDER BY a.veh_type";
			$title = '(By Vehicle Type By Color Type)';
			break;
		case '2' :
			$rptFile = "veh_prc.php"; 
			$order = " ORDER BY a.color_code,a.veh_code,a.pur_date";
			$title = '(By Color Type By Vehicle Type)';
			break;
	}
}
*/


$statsql ="select a.*,a.wrhs_code as wrhs_name from veh_prh a  ";
$where .=" AND YEAR(opn_date) = $year AND MONTH(opn_date) = $mounth";
$where .= " AND (a.sji_date not in('0000-00-00')) ";
$where .= " AND wrhs_code='$wrhs_axs' ";

$statsql .= $where . $order;

$dtl = mysql_query($statsql) or die(mysql_error());
if (mysql_num_rows($dtl)==0)
{
	echo "Tidak ada data";
	return ;
}


include "debitnote/type.php"; 

$filename = 'debitnote_' . date('dmy') . '_' . date('his');

$tblimport = 'veh_prh';
$keys = array(
    'key1' => 'debit_note',
);

echo outputReport($output, $tbl, $filename, $statsql, $tblimport,$keys);

?>