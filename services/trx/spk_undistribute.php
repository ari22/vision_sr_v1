<?php

//////////////////
// Distribute SPK //
//////////////////
// User memasukan nomor awal SPK, nomor akhir SPK yang akan di-undistribute.
// Validasi dilakukan untuk melihat apakah nomor SPK yang dimasukan sudah ada yang pernah diregister dan sudah didistribute.
// SPK diupdate nama salesnya ke dalam tabel veh_spkreg dan direkam ke history veh_spkhst.

session_start();
$table = 'veh_spkreg';

$success = 'false';
$msg = '';
if (isset($func)) {
    if ($func == "read") {
        include("spk_available.php");
    }
    if ($func == "undist") {
        if (isset($list_so_no)) {
            if (strlen($list_so_no) == 0) {
                $success = 'false';
                $msg.='Please choose SPK No.';
            } else {
                $arr = explode(",", $list_so_no);
                //echo json_encode($sarr);
                foreach ($arr as &$so_no) {
                    $sql = new SqlSyntax;
                    $sql->query = "select so_no,srep_code,use_date from $table ";
                    $sql->where = "so_no = '$so_no'";
                    $SqlEngine = new SqlEngine;
                    $row = $SqlEngine->GetData($sql);
                    $srep_code = $row['srep_code'];
                    $lensrep_code = strlen($srep_code);
                    //$use_date = date( 'Y-m-d H:i:s', $row['use_date']);
                    $use_date = $row['use_date'];
                    $split_date = explode("-", $use_date);
                    $year = $split_date[0];
                    if ($lensrep_code == 0) {
                        $success = 'false';
                        $msg = "SPK:  has never been distributed and can not be undistibuted<br>";
                    } else {

                        if ($year != '0000') {
                            $msg = "SPK has been used on '. $use_date . 'and can not be undistributed.<br>";
                        } else {
                            $sql = new SqlSyntax;
                            $sql->query = "update $table set srep_code='',srep_name='',so_reg_by='" . $_SESSION['C_USER'] . "'";
                            $sql->where = "so_no='$so_no'";
                            $SqlEngine = new SqlEngine;
                            $row = $SqlEngine->PutData($sql);


                            $sql = new SqlSyntax;
                            $sql->query = "insert into veh_spkhst (so_no,so_regdate,srep_code,srep_name,so_reg_by,so_note,action,act_date,use_date) values ('$so_no',NOW(),'','','" . $_SESSION['C_USER'] . "','','Undistribute',NOW(),'')";
                            $SqlEngine = new SqlEngine;
                            $row = $SqlEngine->PutData($sql);
                            $msg = 'SPK  has been undistributed successfully.<br>';
                            $success = 'true';
                        }
                    }
                }
            }
            echo '{"success":' . $success . ',"message":"' . $msg . '"}';
        }
    }
}
?>