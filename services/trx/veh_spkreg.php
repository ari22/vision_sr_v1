<?php

session_start();
$table = "veh_spkreg";
$table2 = "veh_spkhst";

$date_now = date('Y-m-d');

$usr_id = $_SESSION["C_ID"];
$usrsql = "select wrhs_axs, wrhs_input from usr where id='$usr_id'";
$usr = mysql_query($usrsql);
$usr = mysql_fetch_assoc($usr);

$wrhs_axs = $usr['wrhs_axs'];
$wrhs_input = $usr['wrhs_input'];

if (isset($func)) {
    if ($func == 'reccount') {
        $result = "select * from $table where 1=1 ";
        $sql = "select count(raddr_code) as n_count,max(id) as max_id from ($result) a ";
        $result = mysql_query($sql);
        $row = mysql_fetch_array($result);
        echo json_encode($row); //$row['n_count'];
    }
    if ($func == 'prefix') {
        $sql = mysql_query("select spk_prefix, spk_length from ssystem;");
        $result = mysql_fetch_assoc($sql);
        echo $result['spk_prefix'];
    }
    if ($func == 'read') {
        include("spk_available.php");
    }

    if ($func == 'create') {

        if (isset($so_no) && isset($sd_no)) {

            if ($so_no > $sd_no) {
                $temp = $so_no;
                $so_no = $sd_no;
                $sd_no = $temp;
            }

            //$lnso_no = strlen(trim($so_no));echo '<br />';
            //$lnsd_no= strlen(trim($sd_no));
            $lnso_no = $so_no;
            $lnsd_no = $sd_no;

            if ($lnso_no == 0 || $lnsd_no == 0) {
                echo '{"success":false,"message":"Cannot be empty.","so_no":"' . $lnso_no . '"}';
                return;
            }

            $number_limit = intval($lnsd_no) - intval($lnso_no);

            if ($number_limit > 100) {
                $success = 'false';
                $msg = 'Sorry, but you may only register up to 100 no. at one time.';
            } else {


                $msg = '';
                $lisspk = '';
                $success = 'false';

                $select_system = new SqlSyntax;
                $select_system->query = "select spk_length,spk_prefix from ssystem ";
                $SqlEngine_system = new SqlEngine;
                $row = $SqlEngine_system->GetData($select_system);
                $spk_length = $row['spk_length'];
                // $spk_prefix = $row['spk_prefix'].'-';
                $spk_prefix = $row['spk_prefix'];
                $length_prefix = strlen($spk_prefix);
                $hit_length_prefix = $spk_length - $length_prefix;

                $prefixso_no = $spk_prefix . str_pad($so_no, $hit_length_prefix, "0", STR_PAD_LEFT);
                $prefixsd_no = $spk_prefix . str_pad($sd_no, $hit_length_prefix, "0", STR_PAD_LEFT);


                /* $sql = new SqlSyntax;
                  $sql->query = "select count(so_no) as n_count from $table ";
                  $sql->where = "(so_no between '$prefixso_no' and '$prefixsd_no') and length(so_no) = length('$so_no')";
                  $SqlEngine = new SqlEngine;
                  $row = $SqlEngine->GetData($sql);
                  $count = $row['n_count'];
                 */

                if (strlen($so_no) > $hit_length_prefix || strlen($sd_no) > $hit_length_prefix) {
                    $success = 'false';
                    $msg = 'Sorry, but maximum SPK no. length is ' . $hit_length_prefix;
                } else {
                    $startspk = $spk_prefix . str_pad($so_no, $hit_length_prefix, "0", STR_PAD_LEFT);
                    $endspk = $spk_prefix . str_pad($sd_no, $hit_length_prefix, "0", STR_PAD_LEFT);

                    $msg = 'SPK No.';
                    for ($x = $so_no; $x <= $sd_no; $x++) {
                        $spk = $spk_prefix . str_pad($x, $hit_length_prefix, "0", STR_PAD_LEFT);
                        $sql = new SqlSyntax;
                        $sql->query = "select count(id) as n_count from veh_spkhst ";
                        //$sql->where = "so_no = '$spk' and use_date not like '0000-00-00 00:00:00'";
                        $sql->where = "so_no = '$spk'";
                        $SqlEngine = new SqlEngine;
                        $row = $SqlEngine->GetData($sql);
                        $count = $row['n_count'];

                        if ($count >> 0) {
                            //echo '{"success":false,"message":"SPK '.$spk. ' already exist"}';
                            $lenmsg = strlen($msg);
                            if ($lenmsg >> 0) {
                                //  $lisspk.=',';
                            }
                            //$msg .= "$spk";
                            $lisspk = $spk;
                            $notadd = true;
                        } else {

                            //kondisi recall
                            $sql_find = new SqlSyntax;
                            $sql_find->query = "select * from veh_spkhst ";
                            $sql_find->where = "so_no like '%$spk%' order by id desc limit 1";

                            $sqlengine_find = new SqlEngine;
                            $row = $SqlEngine->GetData($sql_find);

                            if ($row['action'] == 'Deleted') {
                                $sql = new SqlSyntax;
                                $sql->query = "insert into $table (so_no,so_regdate,srep_code,srep_name,so_reg_by,so_note,use_date,wrhs_code) values ('$spk',NOW(),'','','" . $_SESSION['C_USER'] . "','','0000-00-00 00:00:00','$wrhs_input')";
                                $SqlEngine = new SqlEngine;
                                $row = $SqlEngine->PutData($sql);

                                //Insert to VEH_SPKHST
                                $sql = new SqlSyntax;
                                $sql->query = "insert into veh_spkhst (so_no,so_regdate,srep_code,srep_name,so_reg_by,so_note,action,act_date,use_date,wrhs_code) values ('$spk',NOW(),'','','" . $_SESSION['C_USER'] . "','','Recall',NOW(),'0000-00-00 00:00:00','$wrhs_input')";
                                $SqlEngine = new SqlEngine;
                                $row = $SqlEngine->PutData($sql);

                                $success = 'true';
                                $msg .= $spk . ' has been deleted successfully';
                            }
                            //kondisi insert baru
                            else {
                                //insert to veh_spkreg
                                $sql = new SqlSyntax;
                                $sql->query = "insert into $table (so_no,so_regdate,srep_code,srep_name,so_reg_by,so_note,use_date,wrhs_code) values ('$spk',NOW(),'','','" . $_SESSION['C_USER'] . "','','0000-00-00 00:00:00','$wrhs_input')";
                                $SqlEngine = new SqlEngine;
                                $row = $SqlEngine->PutData($sql);

                                //Insert to VEH_SPKHST
                                $sql = new SqlSyntax;
                                $sql->query = "insert into veh_spkhst (so_no,so_regdate,srep_code,srep_name,so_reg_by,so_note,action,act_date,use_date,wrhs_code) values ('$spk',NOW(),'','','" . $_SESSION['C_USER'] . "','','Generate',NOW(),'0000-00-00 00:00:00','$wrhs_input')";
                                $SqlEngine = new SqlEngine;
                                $row = $SqlEngine->PutData($sql);
                                $success = 'true';
                                $lisspk .= $spk . ',';
                                $add = true;
                                // $msg .= $spk . ' has been registered successfully';
                            }
                        }
                    }
                }
                /* if(empty($notadd)){
                  $msg = $prefixso_no .' up to '. $prefixsd_no.' not has been registered successfully';
                  $success = 'false';
                  } */
            }

            if (!empty($notadd)) {
                // $lisspk = substr($lisspk, 1, 500);

                $msg = $msg . ' ' . $lisspk . ' cannot be made anymore';
            }
            if (!empty($add)) {
                if ($startspk !== $endspk) {
                    $spks = $startspk . ' - ' . $endspk;
                } else {
                    $spks = $startspk;
                }
                $msg = 'SPK No. ' . $spks . ' has been registered successfully';
            }

            $lenmsg = strlen($msg);

            if ($lenmsg >> 0) {

                echo '{"success":' . $success . ',"message":"' . $msg . '"}';
            } else
                echo '{"success":' . $success . ',"message":"SPK has been successfully made and registered."}';
            {
                
            }
        }
    }


    if ($func == 'cmb_sales') {
        $result = " select distinct srep_code, srep_name from $table where srep_name != '' ";

        $result = mysql_query($result);

        $table = array();
        while ($row = mysql_fetch_object($result)) {
            $table[] = $row;
            unset($row);
        }

        echo json_encode($table);
    }
}
?>