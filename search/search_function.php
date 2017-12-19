<?php

error_reporting(E_ALL ^ E_NOTICE);
error_reporting(0);
include '../services/globalFunctions.php';
ob_end_clean();

function rupiah($angka) {
    //$rupiah = "Rp. " . number_format($angka, 0, ',', '.');
    $rupiah = number_format($angka, 0, '.', ',');
    return $rupiah;
}

function getwrhscode() {
    session_start();
    $usr_id = $_SESSION["C_ID"];
    $usrsql = "select wrhs_axs, wrhs_input from usr where id='$usr_id'";
    $usr = mysql_query($usrsql);
    $usr = mysql_fetch_assoc($usr);

    $wrhs_axs = $usr['wrhs_axs'];
    $wrhs_input = $usr['wrhs_input'];

    return $wrhs_axs;
}

function getwrhsfield($tbl) {
    $field = 'wrhs_code';

    if ($tbl == 'veh_movh') {
        $field = 'wrhs_from';
    }

    return $field;
}

function getwrhs($tbl) {
    $stat = false;

    switch ($tbl) {
        case 'veh_spk':
            $stat = true;
            break;
        case 'veh_slh':
            $stat = true;
            break;
        case 'veh_po':
            $stat = true;
            break;
        case 'veh_prh':
            $stat = true;
            break;
        case 'veh_movh':
            $stat = true;
            break;
        case 'veh_rslh':
            $stat = true;
            break;
        case 'veh_rprh':
            $stat = true;
            break;
        case 'veh_dpch':
            $stat = true;
            break;
        case 'veh_arh':
            $stat = true;
            break;
        case 'veh_argh':
            $stat = true;
            break;
        case 'veh_aph':
            $stat = true;
            break;
        case 'veh_apgh':
            $stat = true;
            break;
        case 'veh_argd':
            $stat = true;
            break;
        case 'veh_spkhst':
            $stat = true;
            break;
        case 'veh_spkreg':
            $stat = true;
            break;
        case 'veh_bwoh':
            $stat = true;
            break;
        case 'veh_bwod':
            $stat = true;
            break;
        case 'veh_bprh':
            $stat = true;
            break;
        case 'veh_bprd':
            $stat = true;
            break;
        case 'veh_stk':
            $stat = true;
            break;
    }

    return $stat;
}

function json_out($json) {
    echo json_encode($json);
}

$datas = $_GET['data'];
foreach ($datas as $r) {
    $fieldrows[] = array(
        'name' => 'data[]',
        'value' => $r
    );
}

$data = $fieldrows;

$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';
$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';

$tbl = $_GET["table"];

if ($tbl == 'credit') {
    $tbl = 'veh_slh';
}

$sql = 'select * from ' . $tbl . ' where ';



for ($i = 0; $i < (count($data)); $i+=4) {
    //echo $i;
    if (strpos($data[$i]["value"], 'date') !== false) {
        if ($data[$i + 2]["value"] == null) {
            
        } else {
            $date = str_replace('/', '-', $data[$i + 2]["value"]);
            $data[$i + 2]["value"] = date('Y-m-d', strtotime($date)); //echo $data[$i+2]["value"];
        }
        if ($data[$i + 3]["value"] == null) {
            
        } else {
            $date = str_replace('/', '-', $data[$i + 3]["value"]);
            $data[$i + 3]["value"] = date('Y-m-d', strtotime($date)); //echo $data[$i+2]["value"];
        }
    }
    if ($i > 0) {
        $sql .= ' and ';
    }
    switch ($data[$i + 1]["value"]) {

        case '1':
            if ($i == 0) {
                $sql .= "1 ";
            } else {
                $sql .= "1=1 ";
            }

            if ($tbl == 'acc_slh') {
                $sinv_code = $_GET['sinv_code'];
                $sql .=" and sinv_code='$sinv_code' ";
            }

            if ($tbl == 'set_vglh') {
                $sql .=" and inv_div IN ('VEH','ACC') ";
            }

            break;
        case '2':
            $sql .= $data[$i]["value"] . " LIKE '" . $data[$i + 2]["value"] . "'";
            break;
        case '3':
            $sql .= $data[$i]["value"] . " > '" . $data[$i + 2]["value"] . "' and " . $data[$i]["value"] . " < '" . $data[$i + 3]["value"] . "'";
            break;
        case '4':
            $sql .= $data[$i]["value"] . " LIKE '" . $data[$i + 2]["value"] . "%'";
            break;
        case '5':
            $sql .= $data[$i]["value"] . " LIKE '%" . $data[$i + 2]["value"] . "%'";
            break;
    }
}

$getwrhs = getwrhs($tbl);

if ($getwrhs !== false) {
    $wrhs_field = getwrhsfield($tbl);
    $wrhs_code = getwrhscode();

    if ($wrhs_code !== 'ALL') {
        $sql.= " and $wrhs_field='$wrhs_code'";
    }
}

if (isset($order)) {
    if (isset($sort)) {
        $sql .= " ORDER BY $sort $order ";
    } else {
        $sql .= " order by $order";
    }
}

$count = "select count(*) as n_count from ($sql) a ";
if (isset($page)) {
    $start = ($rows * ($page - 1));
    $sql .= " LIMIT $start,$rows ";
}


$result_count = mysql_query($count);
$row_count = mysql_fetch_array($result_count);

$table = array();
//echo $sql;exit;
$result = mysql_query($sql);
if (mysql_num_rows($result) > 0) {

    $tbl = $_GET["table"];

    switch ($tbl) {
        case 'acc_mst':
            while ($row = mysql_fetch_assoc($result)) {
                $ppn = ($row['sal_price'] / 100) * 10;
                $row['sal_price'] = $row['sal_price'];
                $row['total'] = $ppn + $row['sal_price'];

                $table[] = $row;
                unset($row);
            }
            break;


        default:
            while ($row = mysql_fetch_assoc($result)) {

                if ($row['sex']) {
                    if ($row['sex'] == 1) {
                        $sex = 'M';
                    }
                    if ($row['sex'] == 2) {
                        $sex = 'F';
                    }
                    if ($row['sex'] == 3) {
                        $sex = 'C';
                    }
                    $row['sex'] = $sex;
                }

                $table[] = $row;
                unset($row);
            }
            break;
    }

    $json = array(
        'total' => $row_count['n_count'],
        'rows' => $table
    );

    json_out($json);
} else {
    $json = array(
        'total' => 0,
        'rows' => array()
    );
    json_out($json);
}

mysql_close($conn);
return;
?>
