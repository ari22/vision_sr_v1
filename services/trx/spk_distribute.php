<?php

//////////////////
// Distribute SPK //
//////////////////
// User memasukan nomor awal SPK, nomor akhir SPK yang akan didistribute dan nama Sales Rep.
// Validasi dilakukan untuk melihat apakah nomor SPK yang dimasukan sudah ada yang pernah diregister.
// SPK diupdate nama salesnya ke dalam tabel veh_spkreg dan direkam ke history veh_spkhst.
session_start();
$table = 'veh_spkreg';
$msg = '';
$success = 'false';
if (isset($func)) {
    if ($func == 'read') {
        include("spk_available.php");
    }
    if ($func == 'dist') {
        if (isset($so_no) or isset($list_so_no) && isset($srep_code)) {
            if (!isset($srep_code)) {
                $success = 'false';
                $msg.='Please choose a sales person.<br>';
            } else {
                $query_select = new SqlSyntax;
                $query_select->query = "select * from veh_srep ";
                $query_select->where = "srep_code='$srep_code'";
                $SqlEngineSelect = new SqlEngine;
                $row = $SqlEngineSelect->GetData($query_select);
                $srep_code = $row['srep_code'];
                $srep_name = $row['srep_name'];
                if (strlen($srep_name) == 0) {
                    $success = 'false';
                    $msg.=" Please choose a sales person ";
                } else {
                    if (isset($list_so_no)) {
                        if (strlen($list_so_no) == 0) {
                            $success = 'false';
                            $msg.='Please choose a SPK No.';
                        } else {
                            $arr = explode(",", $list_so_no);
                            //echo json_encode($sarr);
                            foreach ($arr as &$so_no) {
                                $sql = new SqlSyntax;
                                $sql->query = "select count(so_no) as n_count from $table ";
                                $sql->where = "so_no = '$so_no' and year(use_date)<='1999'";
                                $SqlEngine = new SqlEngine;
                                $row = $SqlEngine->GetData($sql);
                                $count = $row['n_count'];
                                //echo "$count<br>";
                                if ($count >> 0) {
                                    $sql = new SqlSyntax;
                                    $sql->query = "update veh_spkreg set srep_code='$srep_code', srep_name='$srep_name', so_reg_by='" . $_SESSION['C_USER'] . "', so_dst_by='" . $_SESSION['C_USER'] . "', so_dstdate=NOW()";
                                    $sql->where = "so_no = '$so_no'";
                                    $SqlEngine = new SqlEngine;
                                    $row = $SqlEngine->PutData($sql);
                                    if ($row >> 0) {
                                        $sql = new SqlSyntax;
                                        $sql->query = "insert into veh_spkhst (so_no,so_regdate,srep_code,srep_name,so_reg_by,so_note,action,act_date,use_date) values ('$so_no',NOW(),'$srep_code','$srep_name','" . $_SESSION['C_USER'] . "','','Distributed',NOW(),'')";
                                        $SqlEngine = new SqlEngine;
                                        $row = $SqlEngine->PutData($sql);
                                        $success = 'true';
                                        $msg = 'SPK has been distributed.<br>';
                                    }
                                } else {
                                    $success = 'false';
                                    $msg = 'SPK has never been registered or is in use.<br>';
                                }
                            }
                        }
                        $msg = $msg;
                    }
                }
                echo '{"success":' . $success . ',"message":"' . $msg . '"}';
            }
        }
    }
}
?>