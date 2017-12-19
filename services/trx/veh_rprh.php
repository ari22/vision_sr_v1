<?php

session_start();
if (isset($func)) {
    if ($func == 'finddata') {
        $dtl = 0;
        $pur_inv_no = $_POST['pur_inv_no'];
        $pur_date = explode('/', $_POST['pur_date']);

        $year = $pur_date[2];
        $mounth = $pur_date[1];

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
        $periodselect = strtotime($year . $mounth);

        if ($periodselect < $period) {
            $dbs = $db1 . '_pr' . $year . $mth;
        } else {
            $dbs = $db1;
        }

        if (!empty(mysql_fetch_array(mysql_query("SHOW DATABASES LIKE '$dbs' ")))) {
            $statsql = "select * from " . $dbs . ".veh_prh where pur_inv_no='$pur_inv_no' limit 1";

            $result = mysql_query($statsql) or die(mysql_error());

            if (mysql_num_rows($result)) {
                $row = mysql_fetch_assoc($result) or die(mysql_error());

                $rows = array('status' => true, 'data' => $row);
            }
        } else {
            $rows = array('status' => false, 'msg' => 'Data not found');
        }

        echo json_encode($rows);
    }
}
