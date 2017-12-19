<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
//error_reporting(E_ALL ^ E_NOTICE);
//error_reporting(0);
date_default_timezone_set("Asia/Jakarta");

class Utility extends Application {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('crud_mdl', 'get_data_mdl'));
    }

    function processChecking() {
        if ($this->input->post()) {
            $mounth = $this->input->post('mounth');
            $year = $this->input->post('year');
            $tbl = $this->input->post('tbl');
            $cond = $this->input->post('cond');

            $data = $this->checking($mounth, $year, $tbl, $cond);
            $this->json($data);
        }
        // $data = $this->checking(6, 2016, 'veh_slh', 1);
        // echo '<pre>';print_r($data);echo '</pre>';
    }

    function checking($mounth = null, $year = null, $tbl = null, $cond = null) {
        $checkData = $this->all_m->checkingClose($mounth, $year, $tbl, $cond);
        //$sql = "select * from veh_slh  where cls_date NOT IN ('0000-00-00') and MONTH(cls_date) <= '$mounth' and YEAR(cls_date) <='$year' and prn_cnt = 0";
        // $checkData = $this->all_m->query_all($sql);

        $count = 0;

        foreach ($checkData as $r) {
            unset($r->id);
            unset($r->dlt_by);
            unset($r->dlt_date);
            unset($r->locked_by);
            unset($r->locked_date);
            $count++;
            $data[] = (array) $r;
        }
        $rows = array(
            'total' => $count,
            'rows' => $data
        );
        return $rows;
    }

    function getData() {
        //print_r($_GET);exit;
        $fielddate = '';
        $table = $this->input->get('table');
        $date_from = $this->input->get('date_from');
        $date_to = $this->input->get('date_to');
        $wrhs_code = $this->input->get('wrhs_code');


        if ($table == 'veh_slh') {
            $fielddate = 'sal_date';
            $fieldinvno = 'sal_inv_no';
        }
        if ($table == 'veh_prh') {
            $fielddate = 'pur_date';
            $fieldinvno = 'pur_inv_no';
        }

        if ($wrhs_code !== '') {
            $where['wrhs_code'] = $wrhs_code;
        }

        $where[$fielddate . ' >='] = $this->dateFormat($date_from);
        $where[$fielddate . ' <='] = $this->dateFormat($date_to);
        $where['fp_no NOT IN("")'] = NULL;
        //$where = array('part_code' => $val);
        $data = $this->all_m->getWhere($table, $where);

        foreach ($data as $row) {
            $rows[] = array(
                'id' => $row->id,
                'inv_no' => $row->$fieldinvno,
                'inv_date' => $row->$fielddate,
                'fp_no' => $row->fp_no,
                'fp_date' => $row->fp_date,
                'cust_code' => $row->cust_code,
                'cust_name' => $row->cust_name,
                'total' => $row->veh_at
            );
        }
        $count = $this->all_m->countlimit($table, $where);
        $grids = array(
            'total' => $count,
            'rows' => $rows
        );
        $this->json($grids);
    }

    function exportData() {
        $data = $this->input->post('data');

        $comp = $this->all_m->getId('ssystem', 'id', $comp_id);
        $sql = "SELECT * FROM veh_slh WHERE sal_inv_no IN ($data)";
        $datarows = $this->all_m->query_all($sql);

        $header1 = array("FK", "KD_JENIS_TRANSAKSI", "FG_PENGGANTI", "NOMOR_FAKTUR", "MASA_PAJAK", "TAHUN_PAJAK", "TANGGAL_FAKTUR", "NPWP", "NAMA", "ALAMAT_LENGKAP", "JUMLAH_DPP", "JUMLAH_PPN", "JUMLAH_PPNBM", "ID_KETERANGAN_TAMBAHAN", "FG_UANG_MUKA", "UANG_MUKA_DPP", "UANG_MUKA_PPN", "UANG_MUKA_PPNBM", "REFERENSI");
        //$header2 = array("LT","NPWP","NAMA","JALAN","BLOK","NOMOR","RT","RW","KECAMATAN","KELURAHAN","KABUPATEN","PROPINSI","KODE_POS","NOMOR_TELEPON");
        $header3 = array("OF", "KODE_OBJEK", "NAMA", "HARGA_SATUAN", "JUMLAH_BARANG", "HARGA_TOTAL", "DISKON", "DPP", "PPN", "TARIF_PPNBM", "PPNBM");

        $drows = array();
        foreach ($datarows as $row) {
            $lcFpNo = $this->getFpNo($row->fp_no);
            $cust_npwp = str_replace('-', '', $row->cust_npwp);
            $cust_npwp = str_replace('.', '', $cust_npwp);

            $drows[] = array(
                "FK",
                substr($row->fp_no, 0, 2),
                0,
                $lcFpNo,
                SUBSTR($row->fp_date, 5, 2),
                SUBSTR($row->fp_date, 0, 4),
                $this->dateView($row->fp_date),
                $cust_npwp,
                $row->cust_name,
                $row->cust_addr . " " . $row->cust_city . " " . $row->cust_area . " " . $row->cust_zipc,
                $row->veh_bt,
                $row->veh_vat,
                0, '', 0, 0, 0, 0,
                $row->sal_inv_no
            );

            $drows[] = array(
                "OF",
                $row->chassis,
                $row->veh_name . ' - ' . $row->color_name,
                $row->veh_bt,
                1,
                $row->veh_bt,
                0,
                $row->veh_bt,
                $row->veh_vat,
                trim(strstr(0, 12, 0)),
                trim(strstr(0, 12, 0))
            );
        }

        $header = array($header1, $header3);

        $rows = array_merge($header, $drows);

        $this->json($rows);
    }

    function getFpNo($fp_no) {
        $lcFpNo = '';
        $lcFpNo = substr($fp_no, 4, strlen($fp_no) - 5 + 1);
        $lcFpNo = str_replace('-', '', $lcFpNo);
        $lcFpNo = str_replace('.', '', $lcFpNo);

        return $lcFpNo;
    }

    function closebook() {
        $db = $this->db->database;
        $post = $this->input->post();
        $year = $post['year'];
        $mounth = $post['mounth'];

        $escaped_cmd = escapeshellcmd('D:\tutup_buku\tutp_buku.exe "jdbc:mysql://localhost:3306/" "'.$db.'" "root" "" ' . $year . ' ' . $mounth . ' ');
        exec($escaped_cmd);
    }

    public function backup_db() {
        ini_set('memory_limit', '-1');
        $this->load->dbutil();
        $db_name = $this->db->database;

        $prefs = array(
            'format' => 'zip',
            'filename' => $db_name . '_backup.sql'
        );


        $backup = & $this->dbutil->backup($prefs);

        $db_name = 'backup-on-' . date("Y-m-d-H-i-s") . '.zip';
        $save = '../backupdb/' . $db_name;

        $this->load->helper('file');
        write_file($save, $backup);


        $this->load->helper('download');
        force_download($db_name, $backup);
    }

    public function backup_db_() {
        /* Store All Table name in an Array */
        $db_name = $this->content['db_setting'];
        $use = mysql_query('use ' . $db_name);

        $return = "";
        $allTables = array();
        $result = mysql_query('SHOW TABLES');
        while ($row = mysql_fetch_row($result)) {
            $allTables[] = $row[0];
        }

        foreach ($allTables as $table) {
            $result = mysql_query('SELECT * FROM ' . $table);

            $num_fields = mysql_num_fields($result);

            $return.= 'DROP TABLE IF EXISTS ' . $table . ';';

            $row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE ' . $table));

            $return.= "\n\n" . $row2[1] . ";\n\n";

            for ($i = 0; $i < $num_fields; $i++) {
                while ($row = mysql_fetch_row($result)) {
                    $return.= 'INSERT INTO ' . $table . ' VALUES(';
                    for ($j = 0; $j < $num_fields; $j++) {
                        $row[$j] = addslashes($row[$j]);
                        $row[$j] = str_replace("\n", "\\n", $row[$j]);

                        if (isset($row[$j])) {
                            $return.= '"' . $row[$j] . '"';
                        } else {
                            $return.= '""';
                        }

                        if ($j < ($num_fields - 1)) {
                            $return.= ',';
                        }
                    }
                    $return.= ");\n";
                }
            }
            $return.="\n\n";
        }// Create Backup Folder

        $folder = 'Database_Backup/';

        if (!is_dir($folder))
            mkdir($folder, 0755, true);
        chmod($folder, 0755);

        $date = date('m-d-Y-H-i-s', time());
        $filename = $folder . $db_name . '_' . $date;

        $handle = fopen($filename . '.sql', 'w+');

        fwrite($handle, $return);
        fclose($handle);

        $db_backup = array(
            'filename' => $db_name . '_' . $date . '.sql',
            'datetime' => date('Y-m-d h:i:s'),
            'path' => './' . $filename . '.sql'
        );
        $db_name1 = $this->db->database;
        $use = mysql_query('use ' . $db_name1);
        $this->all_m->insertData('backup', $db_backup);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Anda berhasil membackup database </div>');
        $this->session->set_flashdata('message_type', 'information');
        redirect('jurnal/backup_restore/22', 'location');
    }

    public function restore() {

        $this->load->helper('file');
        $config['upload_path'] = "../restoredb";
        $config['allowed_types'] = "sql|x-sql";
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if (!$this->upload->do_upload("datafile")) {
            $error = array('error' => $this->upload->display_errors());
            exit();
        }
        $file = $this->upload->data();
        $fotoupload = $file['file_name'];

        $isi_file = file_get_contents('../restoredb' . $fotoupload);
        $string_query = rtrim($isi_file, "\n;");
        $array_query = explode(";", $string_query);
        foreach ($array_query as $query) {
            $this->db->query($query);
        }

        $path_to_file = '../restoredb' . $fotoupload;
        unlink($path_to_file);


        
    }

}

?>