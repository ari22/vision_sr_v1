<?php

class SqlSyntax {

    public $query = '';
    public $where = '';
    public $order = '';
    public $limit = "";
    public $group = "";

}

class SqlEngine {

    function GetData($sql) {
        $sqlstat = $sql->query;
        $lenWhere = strlen($sql->where);
        if ($lenWhere == 0) {
            $sqlstat.=" WHERE 1=1";
        } else {
            $sqlstat.=" WHERE " . $sql->where;
        }
        if (!empty($_SESSION['debug'])) {
            if ($_SESSION['debug'] == true) {
                echo "$sqlstat<br>";
            }
        }

        $result = mysql_query($sqlstat);
        $row = mysql_fetch_array($result);
        mysql_free_result($result);
        return $row;
    }

    function GetBulkData($sql) {
        $sqlstat = $sql->query;
        $lenWhere = strlen($sql->where);
        if ($lenWhere == 0) {
            $sqlstat.=" WHERE 1=1";
        } else {
            $sqlstat.=" WHERE " . $sql->where;
        }

        if (!empty($_SESSION['debug'])) {
            if ($_SESSION['debug'] == true) {
                echo "$sqlstat<br>";
            }
        }
        $sqlstat = $sql->query;
        $lenWhere = strlen($sql->limit);
        if ($lenWhere == 0) {
            
        } else {
            $sqlstat.= $sql->limit;
        }

        if (!empty($_SESSION['debug'])) {
            if ($_SESSION['debug'] == true) {
                echo "$sqlstat<br>";
            }
        }
        $result = mysql_query($sqlstat);
        $table = array();
        while (
        $row = mysql_fetch_array($result)) {
            $table[] = $row;
            unset($row);
        }
        return json_encode($table);
    }

    function PutData($sql) {
        $sqlstat = $sql->query;
        $lenWhere = strlen($sql->where);
        if ($lenWhere == 0) {
            $sqlstat.="";
        } else {
            $sqlstat.=" WHERE " . $sql->where;
        }
        if (!empty($_SESSION['debug'])) {
            if ($_SESSION['debug'] == true) {
                echo "$sqlstat<br>";
            }
        }
        $result = mysql_query($sqlstat);
        $row = mysql_affected_rows();
        return $row;
    }

}

//session_start();
error_reporting(E_ALL ^ E_NOTICE);
error_reporting(0);

$_SESSION['debug'] = false;
$result = '';
$sql = '';
$userid = 'SYS';
include 'database.php';
include "globalFunctions.php";
include "getsession.php";
$conn = connDB();

$attr = "";
$val = "";
$attrval = "";
$field1 = "";
$field2 = "";
$table = "";
$where = "";

foreach ($_GET as $key => $value) {
    $$key = $value;
    $date_sementara = date_parse($value);
    if ($key == "lookup") {
        $exp_tab = explode('/', $value);
        $table = end($exp_tab);
    } else if ($key == "func") {
        $func = $value;
    } else if ($key == "pk") {
        $field1 = $value;
    } else if ($key == "sk") {
        $field2 = $value;
    } else if ($key == 'where') {
        $where = $value;
    } else {
        if ($key == $field1) {
            $attr.=$key . ',';
            $val.="a" . ","; //disini aa tinggal diganti function createid
        } else if ($value == "") {
            
        } else {
            $attr.=$key . ','; //untuk kondisi insert
            if (checkdate($date_sementara["month"], $date_sementara["day"], $date_sementara["year"])) {
                $val.=DTOC($value) . ',';
            } else {
                $val.=$value . ',';
            }
        }
    }
    if ($key == "lookup" || $key == "func" || $key == "id" || $key == "limit" || $key == "nav" || $key == "pk" || $key == "sk") {
        
    } else {
        if (checkdate($date_sementara["month"], $date_sementara["day"], $date_sementara["year"])) {
            $attrval.=$key . "='" . DTOC($value) . "'" . ',';
        } else {
            $attrval.=$key . "='" . $value . "'" . ','; //untuk kondisi update
        }
    }
}

foreach ($_POST as $key => $value) {
    $$key = $value;
    $date_sementara = date_parse($value);
    if ($key == "lookup") {
        $exp_tab = explode('/', $value);
        $table = end($exp_tab);
    } else if ($key == "func") {
        $func = $value;
    } else if ($key == "pk") {
        $field1 = $value;
    } else if ($key == "sk") {
        $field2 = $value;
    } else if ($key == 'where') {
        $where = $value;
    } else {
        if ($key == $field1) {
            $attr.=$key . ',';
            $val.="a" . ","; //disini aa tinggal diganti function createid
        } else if ($value == "") {
            
        } else {
            $attr.=$key . ','; //untuk kondisi insert
            if (checkdate($date_sementara["month"], $date_sementara["day"], $date_sementara["year"])) {
                $val.=DTOC($value) . ',';
            } else {
                $val.=$value . ',';
            }
        }
    }
    if ($key == "lookup" || $key == "func" || $key == "id" || $key == "limit" || $key == "nav" || $key == "pk" || $key == "sk") {
        
    } else {
        if (checkdate($date_sementara["month"], $date_sementara["day"], $date_sementara["year"])) {
            $attrval.=$key . "='" . DTOC($value) . "'" . ',';
        } else {
            $attrval.=$key . "='" . $value . "'" . ','; //untuk kondisi update
        }
    }
}
// kondisi insert
$param_attr = explode(',', $attr);
$param_isi = explode(',', $val);
$attr_sementara = "";
$val_sementara = "";
$hit_param_attr = count($param_attr);
for ($i = 0; $i <= ($hit_param_attr - 2); $i++) {
    if (rtrim($param_attr[$i]) == $field1) {
        $attr_sementara.=$param_attr[$i] . ",";
        $val_sementara.="'" . autonumber($table, $$field2, $field1, $$field1) . "'" . ",";
    } else if ($param_attr[$i] == "lookup" || $param_attr[$i] == "func" || $param_attr[$i] == "id" || $param_attr[$i] == "limit" || $param_attr[$i] == "nav" || $param_attr[$i] == "pk" || $param_attr[$i] == "sk") {
        
    } else {
        $attr_sementara.=$param_attr[$i] . ",";
        $val_sementara.="'" . $param_isi[$i] . "'" . ",";
    }
}
$attr_insert = rtrim($attr_sementara, ",");
$val_insert = rtrim($val_sementara, ",");
// end kondisi insert
$attrval_update = rtrim($attrval, ','); // untuk kondisi update

/* echo $attr_sementara."<br>";
  echo $hit_param_attr."<br>";
  echo $table."<br>";
  echo $field1."<br>";
  echo $field2."<br>";
  echo $func."<br>";
  echo $attr_insert."<br>";
  echo $val_insert."<br>";
  echo $attrval_update."<br>";
 */

function dateFormat($date) {
    $b_date = explode('/', $date);
    //$b_date = $b_date[2] . '-' . $b_date[0] . '-' . $b_date[1];
    $b_date = $b_date[2] . '-' . $b_date[1] . '-' . $b_date[0];
    return $b_date;
}

function dateView($in_date) {
    $out_date = '';

    if ($in_date != '0000-00-00') {
        $out_date = date_create($in_date);
        $out_date = date_format($out_date, "d/m/Y");
    }
    return $out_date;
}

function tblstyle() {
    $tbl = "<style>"
            . "table{font-family : 'helvetica';font-size : 11px;border-collapse: collapse; border-spacing: 0;margin-bottom:15px;}"
            . "th, td {padding: 0.25em 0.75em;}"
            . "th{padding-bottom:10px;padding-top:10px;}"
            . "thead th {border-bottom: 1px solid #333;  }"
            . ".border-foot{padding-top:10px;padding-bottom:10px;border-top:2px solid black;border-bottom:2px solid black;}"
            . ".border-head{padding-top:10px;padding-bottom:10px;}"
            . "thead th, thead td {padding-top:10px;padding-bottom:10px;"
            . "tfoot td {padding-top:10px;padding-bottom:10px;}</style>";

    return $tbl;
}

function outputpdf($html, $filename, $output, $font = null) {

    $lib = '../../lib/';
    require_once($lib . 'tcpdf/tcpdf.php');

    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    //$pdf->footer=$footer;
    $pdf->setPrintHeader(false);
    //$pdf->setPrintFooter(false);
    $pdf->SetFooterMargin(20);
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
    $pdf->AddPage('L', 'A3');

    $pdf->SetFont('helvetica', '', 9);
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
    $pdf->writeHTML($html, true, false, false, false, '');

    if ($output == 'screen') {
        //$pdf->SetProtection(array('print','annot-forms','modify','copy'),'1','1');
        $pdf->Output($filename . '.pdf', 'I');
    } else {
        $js = 'print(true);';

        // set javascript
        $pdf->IncludeJS($js);
        $pdf->Output($filename . '.pdf', 'I');
    }
}

function outputReport($output = null, $tbl = null, $filename = null, $statsql = null, $tblimport = null, $keys = null) {
    $out = '';
    if (isset($output)) {
        switch ($output) {

            case 'screen' :
                $out = $tbl;
                //$out = outputpdf($tbl, $filename, $output);
                break;

            case 'export' :
                if ($statsql !== null) {
                    header('Content-type: text/csv');
                    header('Content-Disposition: attachment; filename="' . $filename . '.csv"');

                    header('Pragma: no-cache');
                    header('Expires: 0');
                    $tblexport = exportCsv($statsql, $tblimport, $keys);

                    $out = $tblexport;
                } else {
                    header("Content-type: application/vnd-ms-excel");
                    header("Content-Disposition: attachment; filename=" . $filename . ".xls");
                    $out = $tbl;
                }

                break;

            case 'print' :
                //$out = outputpdf($tbl, $filename, $output);
                $out = $tbl;
                $out .='<script>window.print();</script>';
                break;

            default:
                $out = $row;
                break;
        }
    }
    return $out;
}

function exportCsv($statsql, $tblimport, $keys = null) {
    error_reporting(E_ALL ^ E_NOTICE);
    error_reporting(0);

    include 'export_label.php';

    $tables = tblrows($tblimport, $keys);

    foreach ($tables as $key => $field) {
        $labels[] = $key;
    }

    $dtl = mysql_query($statsql) or die(mysql_error());


    while ($dtlrow = mysql_fetch_array($dtl)) {
        $row = array();

        if ($dtlrow['stk_date']) {
            $datetime1 = new DateTime(date('Y-m-d'));
            $datetime2 = new DateTime($dtlrow['stk_date']);
            $difference = $datetime1->diff($datetime2);
            $agestk = $difference->days;
        }

        if ($dtlrow['arg_inv_no']) {

            $pay = 0;
            $usage = 0;
            $arg_inv_no = $dtlrow['arg_inv_no'];

            if ($arg_inv_no !== '') {
                $pay = $dtlrow['pay_val'];
            } else {
                $usage = $dtlrow['pay_val'];
            }
        }

        $qty_unit = '';

        foreach ($tables as $key2 => $field) {

            $rw = $dtlrow[$field];

            if ($field == 'payment') {
                if ($tblimport == 'veh_arh') {
                    $rw = $pay;
                }
            }

            if ($field == 'dp_usage') {
                if ($tblimport == 'veh_arh') {
                    $rw = $usage;
                }
            }

            if ($field == 'age_stk') {
                $rw = $agestk;
            }

            if ($field == 'qty_unit') {
                $rw = '1';
            }

            if ($field == 'qty') {
                if ($tblimport == 'veh_sjch') {
                    $rw = '1';
                }
                if ($tblimport == 'veh_kwch') {
                    $rw = '1';
                }
            }
            $row[] = $rw;
        }

        $rows[] = $row;
    }



    $file = fopen('php://output', 'w');

    fputcsv($file, $labels);

    $data = $rows;

    foreach ($data as $row) {
        fputcsv($file, $row);
    }

    exit();
}

function rangeMounth($a, $b) {
    $i = date("Ym", strtotime($a));

    $mounth = array();

    while ($i <= date("Ym", strtotime($b))) {
        //echo $i."<br>";
        $mounth[] = $i;
        if (substr($i, 4, 2) == "12")
            $i = (date("Y", strtotime($i . "01")) + 1) . "01";
        else
            $i++;
    }

    return $mounth;
}

function queryUnion($mounth, $db1, $statsql) {

    $sql = '';
    foreach ($mounth as $k => $th) {
        $db = $db1 . '_pr' . $th;

        if (!empty(mysql_fetch_array(mysql_query("SHOW DATABASES LIKE '$db' ")))) {

            $strsql = str_replace($db1, $db, $statsql);
            $sql .= " UNION " . $strsql;

            //$sql .= " UNION select a.*,a.cust_city,a.wrhs_code as wrhs_name,1 as qty from " . $db . ".veh_slh a  " . $where;
        }
    }

    return $sql;
}

session_start();
$usr_id = $_SESSION["C_ID"];
$usrsql = "select wrhs_axs, wrhs_input from usr where id='$usr_id'";
$usr = mysql_query($usrsql);
$usr = mysql_fetch_assoc($usr);

$wrhs_axs = $usr['wrhs_axs'];
$wrhs_input = $usr['wrhs_input'];

$db1 = $db['default']['database'];
include_once $lookup . '.php';
?>