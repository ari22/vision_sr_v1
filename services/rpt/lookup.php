<?php
session_start();
$comp_name = "BELUM DI SET";
if (isset($_SESSION['comp_name'])) {
    $comp_name = $_SESSION['comp_name'];
}

$tbl = tblstyle();

$optby = $_REQUEST['optby'];
$title = $_REQUEST['title'];

$fieldname = $table;
$_code = '_code';
$_name = '_name';

switch ($table) {
    case 'prt_radd':
        $fieldname = 'raddr';
        break;
    case 'country':
        $fieldname = 'cntry';
        break;
    case 'job_fld':
        $fieldname = 'job';
        break;
    case 'bus_fld':
        $fieldname = 'fld';
        break;
    case 'bus_item':
        $fieldname = 'item';
        break;
    case 'religion':
        $fieldname = 'relig';
        break;
    case 'rating':
        $fieldname = 'rate';
        break;
    case 'pay_type':
        $fieldname = 'pay';
        $_code = '_type';
        break;
    case 'so_source':
        $fieldname = 'sosrc';
        break;
    case 'srep_lev':
        $fieldname = 'slev';
        break;
    case 'educ_lev':
        $fieldname = 'educ';
        break;
    case 'coll_lev':
        $fieldname = 'clev';
        break;
    case 'prep_lev':
        $fieldname = 'plev';
        break;
    case 'opname':
        $fieldname = 'opn';
        break;
    case 'orep_lev':
        $fieldname = 'oplev';
        break;
    case 'prt_movr':
        $fieldname = 'mvrep';
        break;
    case 'dept_unt':
        $fieldname = 'dunit';
        break;
    case 'oreqtype':
        $fieldname = 'oreq';
        $_code = '_type';
        break;
    case 'action':
        $fieldname = 'act';
        break;
    case 'location':
        $fieldname = 'loc';
        break;
    case 'veh_brnd':
        $fieldname = 'brnd';
        break;
    case 'col_type':
        $fieldname = 'coltp';
        break;
    case 'veh_tran':
        $fieldname = 'trans';
        break;
    case 'veh_wrhs':
        $fieldname = 'wrhs';
        break;
    case 'prt_use4':
        $fieldname = 'use4';
        break;
    case 'prt_grp':
        $fieldname = 'grp';
        break;
    case 'prt_mdin':
        $fieldname = 'mdin';
        break;
    case 'prt_umsr':
        $fieldname = 'unit';
        $_code = '';
        break;
    case 'prt_sgrp':
        $fieldname = 'sgrp';
        break;
    case 'prt_wrhs':
        $fieldname = 'wrhs';
        break;
}


$code = $fieldname . $_code;
$name = $fieldname . $_name;

if (!empty($_REQUEST['optby'])) {

    switch ($optby) {
        case '1' :
            $order = " ORDER BY $code";
            break;
        case '2' :
            $order = " ORDER BY $name";
            break;
    }
}

$statsql = "select * from $table";
$statsql .= $order;
//echo $statsql; exit;

$dtl = mysql_query($statsql) or die(mysql_error());
if (mysql_num_rows($dtl) == 0) {
    echo "Tidak ada data";
    return;
}

$rptFile = 'view.php';

if ($table == 'prt_radd') {
    $rptFile = 'raddr.php';
}

include "lookup/" . $rptFile;

$filename = $title .'_Lookup_'. date('dmy') . '_' . date('his');

echo outputReport($output, $tbl, $filename, $statsql, $table);
