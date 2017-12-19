<?php

/*
  Fungsi : Membuka koneksi ke MySQL
  Return : koneksi aktif yang harus di disconnect setelah selesai pakai
 */

function connDB() {
    include 'database.php';
    $conn = mysql_connect($db['default']['hostname'], $db['default']['username'], $db['default']['password']) or die(mysql_error());
    mysql_select_db($db['default']['database']) or die(mysql_error());
    return $conn;
}


function connSMS() {
    $conn = mysql_connect("192.168.0.8", "user", "puser");
    mysql_select_db("sms") or die(mysql_error());
    return $conn;
}


function DTOC($ldTgl) {
    //echo $ldTgl."<br>";
    $lnPos = strpos($ldTgl, "/");
    //echo "Pos ".$lnPos."<br>";
    $bulan = substr($ldTgl, 0, $lnPos);
    $ldTgl = substr($ldTgl, $lnPos + 1, strlen($ldTgl) - $lnPos);
    //echo $ldTgl."<br>";
    $lnPos = strpos($ldTgl, "/");
    //echo "Pos ".$lnPos."<br>";
    $tanggal = substr($ldTgl, 0, $lnPos);
    $tahun = substr($ldTgl, $lnPos + 1, strlen($ldTgl) - $lnPos);
    //echo $ldTgl."<br>";
    //echo str_pad($bulan,2,"0",STR_PAD_LEFT);
    //echo str_pad($tanggal,2,"0",STR_PAD_LEFT)."<br>";
    return $tahun . str_pad($bulan, 2, "0", STR_PAD_LEFT) . str_pad($tanggal, 2, "0", STR_PAD_LEFT);
}


function msgFailed($id, $field, $value, $msg) {
    echo '{"success":false,"message":"' . $msg . ' ' . $value . '","' . $field . '":"' . $value . '","id":"' . $id . '"}';
}

function msgSuccess($id, $field, $value, $msg) {
    echo '{"success":true,"message":"' . $msg . ' ' . $value . '","' . $field . '":"' . $value . '","id":"' . $id . '"}';
}

function createId($table) {
    return $table . "aaa";
}

function autonumber($table, $field2, $field1, $valfield1) {

    if ($table == "veh_cust" || $table == "veh_spk" || $table == "veh_pcus" || $table == "acc_cust" || $table == "veh_supp" || $table == "acc_supp") {
        $today = date("ym");
        $trimmed = str_replace(' ', '', $field2);
        $name = substr($trimmed, 0, 3);
        $query = "SELECT max($field1) AS maxID FROM $table WHERE $field1 LIKE '$name%' order by id desc";
        $result = mysql_query($query) or die("Query failed with error: " . mysql_error());
        ;
        $data = mysql_fetch_array($result);
        $idMax = $data['maxID'];
        $noUrut = (int) substr($idMax, 6, 3);
        $noUrut++;
        $newID = strtoupper($name . '-' . sprintf('%03s', $noUrut));
    } else {
        $newID = $valfield1;
    }
    return $newID;
}

//==================== Tanggal dan tanggal ================================ //
function IsiGakBolehKosong($var, $errMsg) {
    $len = strlen($var);
    if ($len == 0) {
        echo '{"success":false,"message":"' . $errMsg . '"}';
        exit;
    }
}

function SudahTerisi($var, $errMsg) {
    $len = strlen($var);
    if ($len > 0) {
        echo '{"success":false,"message":"' . $errMsg . '"}';
        exit;
    }
}

$conn = connDB();
?>
