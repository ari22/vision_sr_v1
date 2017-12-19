<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
//error_reporting(E_ALL ^ E_NOTICE);
//error_reporting(0);
date_default_timezone_set("Asia/Jakarta");

class Credit_bpkb extends Application {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('crud_mdl', 'get_data_mdl'));
    }

    function read_slh() {
        $table = $this->input->post('table');
        $nav = $this->input->post('nav');
        $id = $this->input->post('id');
        $sinv_code = $this->uri->segment(4);

        // print_r($this->input->post());exit;
        //$where['sinv_code'] = $sinv_code;
        $where['cls_date NOT IN ("0000-00-00")'] = NULL;
        $read = $this->crud_mdl->read($table, $nav, $id, $where);
        $this->json($read);
    }

    function saveAppCredit() {

        $table = $this->input->post('table');
        $id = $this->input->post('id');
        $data = $this->input->post();
        $cust_siup = $this->input->post('cust_siup');


        unset($data['table']);
        unset($data['id']);
        unset($data['inv_type']);

        if (!empty($data['cls_date'])) {
            $data['cls_date'] = $this->dateFormat($data['cls_date']);
        }
        if (!empty($data['sal_date'])) {
            $data['sal_date'] = $this->dateFormat($data['sal_date']);
        }
        if (!empty($data['pick_date'])) {
            $data['pick_date'] = $this->dateFormat($data['pick_date']);
        }
        if (!empty($data['so_date'])) {
            $data['so_date'] = $this->dateFormat($data['so_date']);
        }
        if (!empty($data['due_date'])) {
            $data['due_date'] = $this->dateFormat($data['due_date']);
        }
        if (!empty($data['crd_cntrdt'])) {
            $data['crd_cntrdt'] = $this->dateFormat($data['crd_cntrdt']);
        }
        if (!empty($data['stnk_bdate'])) {
            $data['stnk_bdate'] = $this->dateFormat($data['stnk_bdate']);
        }
        if (!empty($data['stnk_edate'])) {
            $data['stnk_edate'] = $this->dateFormat($data['stnk_edate']);
        }


        $data['crdinscode'] = $data['insr_code'];
        $data['crdinsname'] = $data['insr_name'];

        unset($data['insr_name']);
        unset($data['insr_code']);
        
        $count = $this->all_m->countlimit($table, array('id' => $id));
        
        if ($count > 0) {
            
            $veh_slh = $this->all_m->getId($table, 'id', $id);
     
            $stat = true;

            if ($data['cust_id']) {
                $data['cust_id'] = 'F';
            } else {
                $data['cust_id'] = null;
            }
            if ($data['cust_kk']) {
                $data['cust_kk'] = 'F';
            } else {
                $data['cust_kk'] = null;
            }
            if ($data['cust_bnkac']) {
                $data['cust_bnkac'] = 'F';
            } else {
                $data['cust_bnkac'] = null;
            }
            if ($data['cust_siup']) {
                $data['cust_siup'] = 'F';
            } else {
                $data['cust_siup'] = null;
            }

            if ($data['insr_name']) {
                $data['crdinsname'] = $data['insr_name'];
                unset($data['insr_name']);
            }
            if ($data['insr_code']) {
                $data['crdinscode'] = $data['insr_code'];
                unset($data['insr_code']);
            }
           //print_r($data['crd_amount']);exit;
            //print_r($data);exit;
            if ($stat !== false) {
                $check = $this->all_m->countlimit($table, array('id' => $id));
                
                if ($check > 0) {
                    
                    $check2 = $this->all_m->countlimit('veh_arh', array('sal_inv_no' => $veh_slh->sal_inv_no));
                            
                    if ($check2 > 0) {
                        
                        
                    
                        $veh_arh = $this->all_m->getId('veh_arh', 'sal_inv_no', $veh_slh->sal_inv_no);
                        
                        if ($data['lease_code'] !== '') {
                            $data_arh['salpaytype'] = 2;
                        } else {
                            $data_arh['salpaytype'] = 1;
                        }

                        $data_arh['lease_code'] = $data['lease_code'];
                        $data_arh['lease_name'] = $data['lease_name'];
                        $data_arh['lease_addr'] = $data['lease_addr'];
                        $data_arh['lease_city'] = $data['lease_city'];
                        $data_arh['lease_zipc'] = $data['lease_zipc'];

                        $this->all_m->updateData('veh_arh', 'id', $veh_arh->id, $data_arh);
                    }
                    
                    $this->all_m->updateData($table, 'id', $veh_slh->id, $data);
                    
                    $msg = array('success' => true, 'message' => 'Record updated ', 'status' => 'update');
                    $this->updateLocked($table, $id);
                } else {
                    $msg = array('success' => false, 'message' => 'Record updated failed, data not found', 'status' => 'update', 'update' => false);
                }
            }
        } else {
            $msg = array('success' => false, 'message' => 'Record updated failed', 'status' => 'update');
        }


        $this->json($msg);
    }

    function get_QQData() {
        $this->all_m->getOne($tbl, $array);
    }

    function get_stnkData() {
        $this->all_m->getOne($tbl, $array);
    }

    function saveAppBPKB() {
        $table = $this->input->post('table');
        $id = $this->input->post('id');
        $data = $this->input->post();

        unset($data['table']);
        unset($data['id']);
        unset($data['cls_date']);
        unset($data['inv_type']);
        unset($data['cust_rname2']);
        unset($data['chassis1']);

        if (!empty($data['doc_date'])) {
            $data['doc_date'] = $this->dateFormat($data['doc_date']);
        }
        if (!empty($data['cls_date'])) {
            $data['cls_date'] = $this->dateFormat($data['cls_date']);
        }
        if (!empty($data['sal_date'])) {
            $data['sal_date'] = $this->dateFormat($data['sal_date']);
        }
        if (!empty($data['pick_date'])) {
            $data['pick_date'] = $this->dateFormat($data['pick_date']);
        }
        if (!empty($data['so_date'])) {
            $data['so_date'] = $this->dateFormat($data['so_date']);
        }
        if (!empty($data['due_date'])) {
            $data['due_date'] = $this->dateFormat($data['due_date']);
        }
        if (!empty($data['veh_inv_dt'])) {
            $data['veh_inv_dt'] = $this->dateFormat($data['veh_inv_dt']);
        }
        if (!empty($data['veh_invrdt'])) {
            $data['veh_invrdt'] = $this->dateFormat($data['veh_invrdt']);
        }
        if (!empty($data['forma_date'])) {
            $data['forma_date'] = $this->dateFormat($data['forma_date']);
        }
        if (!empty($data['rapp_date'])) {
            $data['rapp_date'] = $this->dateFormat($data['rapp_date']);
        }
        if (!empty($data['rapp_bdate'])) {
            $data['rapp_bdate'] = $this->dateFormat($data['rapp_bdate']);
        }
        if (!empty($data['stnk_bdate'])) {
            $data['stnk_bdate'] = $this->dateFormat($data['stnk_bdate']);
        }
        if (!empty($data['stnk_edate'])) {
            $data['stnk_edate'] = $this->dateFormat($data['stnk_edate']);
        }
        if (!empty($data['stnk_rdate'])) {
            $data['stnk_rdate'] = $this->dateFormat($data['stnk_rdate']);
        }
        if (!empty($data['stnk_sdate'])) {
            $data['stnk_sdate'] = $this->dateFormat($data['stnk_sdate']);
        }
        if (!empty($data['vds_date'])) {
            $data['vds_date'] = $this->dateFormat($data['vds_date']);
        }
        if (!empty($data['bpkb_date'])) {
            $data['bpkb_date'] = $this->dateFormat($data['bpkb_date']);
        }
        if (!empty($data['bpkb_rdate'])) {
            $data['bpkb_rdate'] = $this->dateFormat($data['bpkb_rdate']);
        }
        if (!empty($data['bpkb_sdate'])) {
            $data['bpkb_sdate'] = $this->dateFormat($data['bpkb_sdate']);
        }
        if (!empty($data['vdb_date'])) {
            $data['vdb_date'] = $this->dateFormat($data['vdb_date']);
        }

        $fieldunique = 'doc_inv_no';
        $inv_type = 'VDM';
        $stat = true;

        $data_slh = array(
            'doc_inv_no' => $data['doc_inv_no'],
            'doc_date' => $data['doc_date'],
            'stnk_rname' => $data['stnk_rname'],
            'stnk_ridno' => $data['stnk_ridno'],
            'stnk_rdate' => $data['stnk_rdate'],
            'stnk_sname' => $data['stnk_sname'],
            'stnk_sidno' => $data['stnk_sidno'],
            'stnk_sdate' => $data['stnk_sdate'],
            'bpkb_no' => $data['bpkb_no'],
            'bpkb_date' => $data['bpkb_date'],
            'bpkb_rname' => $data['bpkb_rname'],
            'bpkb_ridno' => $data['bpkb_ridno'],
            'bpkb_rdate' => $data['bpkb_rdate'],
            'bpkb_sname' => $data['bpkb_sname'],
            'bpkb_sidno' => $data['bpkb_sidno'],
            'bpkb_sdate' => $data['bpkb_sdate'],
            'cust_rarea' => $data['cust_rarea'],
            'cust_rcity' => $data['cust_rcity'],
            'cust_rzipc' => $data['cust_rzipc'],
            'cust_rphon' => $data['cust_rphon'],
            'cust_rsex' => $data['cust_rsex'],
            'stnk_no' => $data['stnk_no'],
            'stnk_bdate' => $data['stnk_bdate'],
            'stnk_edate' => $data['stnk_edate'],
            'veh_reg_no' => $data['veh_reg_no']
        );
        if (intval(strtotime($data['bpkb_rdate'])) > intval(strtotime($data['bpkb_sdate']))) {
            $stat = false;
            $msg = array('success' => false, 'message' => ' Date when customer received BPKB has to be later than date when staff received BPKB ');
        }


        if ($data['bpkb_sdate'] !== '' && $data['bpkb_sname'] == '') {
            $stat = false;
            $msg = array('success' => false, 'message' => ' Date when customer received BPKB exist, please input BPKB-receiving-customer Name');
        }

        if ($data['bpkb_sname'] !== '' && $data['bpkb_sdate'] == '') {
            $stat = false;
            $msg = array('success' => false, 'message' => ' BBPKB-Receiving-customer name exist, please input date when Customer received BPKB ');
        }


        if ($data['bpkb_rdate'] !== '' && $data['bpkb_rname'] == '') {
            $stat = false;
            $msg = array('success' => false, 'message' => ' Date when staff received BPKB exist, please input BPKB-receiving-staff name ');
        }

        if ($data['bpkb_rname'] !== '' && $data['bpkb_rdate'] == '') {
            $stat = false;
            $msg = array('success' => false, 'message' => ' BPKB-receiving-staff exist, please input date when staff received BPKB');
        }

        /* STNK VALIDATE */
        if (intval(strtotime($data['stnk_rdate'])) > intval(strtotime($data['stnk_sdate']))) {
            $stat = false;
            $msg = array('success' => false, 'message' => ' Date when customer received STNK has to be later than date when staff received STNK ');
        }


        if ($data['stnk_sdate'] !== '' && $data['stnk_sname'] == '') {
            $stat = false;
            $msg = array('success' => false, 'message' => ' Date when customer received STNK exist, please input STNK-receiving-customer Name');
        }

        if ($data['stnk_sname'] !== '' && $data['stnk_sdate'] == '') {
            $stat = false;
            $msg = array('success' => false, 'message' => ' STNK-Receiving customer name exist, please input date when customer received STNK ');
        }


        if ($data['stnk_rdate'] !== '' && $data['stnk_rname'] == '') {
            $stat = false;
            $msg = array('success' => false, 'message' => ' Date when staff received STNK exist, please input STNK-receiving-staff name ');
        }

        if ($data['stnk_rname'] !== '' && $data['stnk_rdate'] == '') {
            $stat = false;
            $msg = array('success' => false, 'message' => ' STNK-Receiving staff name exist, please input date when staff received STNK ');
        }

        if ($data['chassis'] == '') {
            $stat = false;
            $msg = array('success' => false, 'message' => ' Please input Chassis No.');
        }


        if ($id == '') {
            $check = $this->all_m->countlimit('veh_doc', array('chassis' => $data['chassis'], 'sal_inv_no' => $data['sal_inv_no']));

            if ($check > 0) {
                $stat = false;
                $msg = array('success' => false, 'message' => 'Chassis:' . $data['chassis'] . ' Sale Invoice No. ' . $data['sal_inv_no'] . ' Already exist. Data not Saved');
            }
        }

        if ($stat !== false) {

            $data['cls_date'] = '0000-00-00';
            $data['sinv_code'] = $inv_type;
            $this->all_m->updateData('veh_slh', 'sal_inv_no', $data['sal_inv_no'], $data_slh);

            if ($id !== '') {
                //$check = $this->all_m->getId($table, 'id', $id);
                $check2 = $this->all_m->countlimit($table, array('id' => $id));
                
                if($check2 > 0){
                    $this->all_m->updateData($table, 'id', $id, $data);

                    $msg = array('success' => true, 'message' => 'Record updated ', 'status' => 'update');
                    $this->updateLocked($table, $id);
                }else{
                   $msg = array('success' => false, 'message' => 'Record updated failed, data not found','status' => 'update', 'update' => false);
                }


            } else {

                unset($data[$fieldunique]);

                $data[$fieldunique] = $this->all_m->inv_seq('4', $inv_type);
                $check = $this->all_m->insertData($table, $data);
                $inv_seq = $this->all_m->getOne('inv_seq', array('inv_type' => $inv_type));
                $this->all_m->updateData('inv_seq', 'id', $inv_seq->id, array('inv_no' => $inv_seq->inv_no + 1));

                $msg = array('success' => true, 'message' => 'Record saved', 'status' => 'save');
            }
        }

        $this->json($msg);
    }

    function closeBPKB() {
        $user = $this->uri->segment(4);

        $date = date('Y-m-d');

        $table = $this->input->post('table');
        $id = $this->input->post('id');
        $data = $this->input->post();

        unset($data['table']);
        unset($data['id']);
        
        $periode = $this->checkPeriode();

        if($periode == 'false'){
            $msg = $this->msgNotClose();
        }
        if ($msg['success'] !== false) {
            $veh_doc = $this->all_m->getId($table, 'id', $id);

            $data_doc['cls_date'] = $date;
            $data_doc['cls_by'] = $user;
            $data_doc['cls_cnt'] = $veh_doc->cnt + 1;
            $data_doc['doc_date'] = $date;

            $data_arh = array(
                'stnk_no' => $veh_doc->stnk_no,
                'stnk_rdate' => $veh_doc->stnk_rdate,
                'stnk_sdate' => $veh_doc->stnk_sdate,
                'bpkb_no' => $veh_doc->bpkb_no,
                'bpkb_rdate' => $veh_doc->bpkb_rdate,
                'bpkb_sdate' => $veh_doc->bpkb_sdate
            );

            $this->all_m->updateData('veh_arh', 'sal_inv_no', $veh_doc->sal_inv_no, $data_arh);
            $this->all_m->updateData('veh_slh', 'sal_inv_no', $veh_doc->sal_inv_no, array('doc_date' => $date));
            $this->all_m->updateData($table, 'id', $id, $data_doc);

            $msg = array('success' => true, 'message' => 'success');

        }
        $this->json($msg);
    }

    function uncloseBPKB() {
        $user = $this->uri->segment(4);

        $date = '0000-00-00';

        $table = $this->input->post('table');
        $id = $this->input->post('id');
        $data = $this->input->post();

        unset($data['table']);
        unset($data['id']);
        
        $periode = $this->checkPeriode();
        if($periode == 'false'){
           $msg = $this->msgNotUnClose();
        }
        
        if ($msg['success'] !== false) {
            $veh_doc = $this->all_m->getId($table, 'id', $id);

            $data_doc['cls_date'] = $date;
            $data_doc['cls_by'] = '';
            $data_doc['doc_date'] = $date;

            $data_arh = array(
                'stnk_no' => '',
                'stnk_rdate' => '',
                'stnk_sdate' => '',
                'bpkb_no' => '',
                'bpkb_rdate' => '',
                'bpkb_sdate' => ''
            );

            $this->all_m->updateData('veh_arh', 'sal_inv_no', $veh_doc->sal_inv_no, $data_arh);
            $this->all_m->updateData('veh_slh', 'sal_inv_no', $veh_doc->sal_inv_no, array('doc_date' => $date));
            $this->all_m->updateData($table, 'id', $id, $data_doc);

            $msg = array('success' => true, 'message' => 'success');

        }
        
        $this->json($msg);
    }

    function unserializeForm($str) {
        $returndata = array();
        $strArray = explode("&", $str);
        $i = 0;
        foreach ($strArray as $item) {
            $array = explode("=", $item);
            $returndata[$array[0]] = $array[1];
        }

        return $returndata;
    }

    function outputpdf() {
        $margin = null;
        $font = null;
        $data['tbl'] = encrypt_decrypt('decrypt', $this->uri->segment(4));
        $data['id'] = $this->uri->segment(5);
        $data['user'] = $this->uri->segment(6);
        $action = $this->uri->segment(7);
        $data['inv_code'] = encrypt_decrypt('decrypt', $this->uri->segment(8));
        $data['inv_type'] = encrypt_decrypt('decrypt', $this->uri->segment(9));

        switch ($data['tbl']) {
            case 'veh_slh':

                $data['form'] = $this->unserializeForm($this->uri->segment(10));
                $read = $this->readHtml($data);
                // print_r($read);exit;
                $output = array(
                    'html' => $read['html'],
                    'filename' => 'Report' . $read['number'],
                    'title' => 'Report_ ' . $read['number']
                );

                $type = $data['form']['type'];

                if ($type == '4' || $type == '5') {
                    $margin = "L";
                } else {
                    $margin = "P";
                }
                break;

            case 'veh_doc':

                if ($this->uri->segment(10)) {
                    $data['doc'] = $this->uri->segment(10);
                }
                $read = $this->readHtml($data);
                $output = array(
                    'html' => $read['html'],
                    'filename' => 'Report' . $read['number'],
                    'title' => 'Report_ ' . $read['number']
                );

                if ($this->uri->segment(10)) {
                    $margin = "L";
                } else {
                    $margin = "P";
                }
                $font = 'Courier';
                break;
        }

        $html = $output['html'];
        $this->output_pdf($output['title'], $html, $output['filename'], $action, $margin, $font);
    }

    function readHtml($data) {
        $company = $this->all_m->query_single("select * from ssystem limit 1");
        $read = $this->all_m->getId($data['tbl'], 'id', $data['id']);
        $inv_code = $data['inv_code'];
        $inv_type = $data['inv_type'];
        $number = $read->$inv_code;

        $html = '';

        switch ($data['tbl']) {
            case 'veh_slh':
                $form = $data['form'];
                $nama = str_replace('+', ' ', $form['nama']);
                $jabatan = str_replace('+', ' ', $form['jabatan']);

                $sejak = $form['sejak'];
                if ($sejak == 1) {
                    $sejak = 'dari tanggal surat pernyataan ini dibuat';
                }
                if ($sejak == 2) {
                    $sejak = 'dari tanggal STNK';
                }
                if ($sejak == 3) {
                    $sejak = 'dari tanggal STNK (dengan melampirkan copy STNK)';
                }


                if ($form['type'] == '1') {
                    $html .= '<p style="font-size:10px;">Kepada Yth,</p>';
                    $html .= '<p style="font-size:10px;"><b>' . $read->lease_name . '<br />';
                    $html .= $read->lease_city . '<br />'
                            . '' . $read->lease_zipc . '<br />'
                            . 'Ref. No: ' . $read->sal_inv_no . '</b></p>';
                    $html .='<br /><br />';
                    $html .='<p style="font-size:11px;text-decoration:underline;text-align:center;"><b>SURAT PERNYATAAN PENYERAHAN BPKB DAN FAKTUR</b></p>';
                    $html .='<p style="font-size:10px;">Yang bertanda tangan dibawah ini :</p>';
                    $html .='<table class="tables"  style="font-size:10px;">'
                            . '<tr><td width="10"></td><td width="70">Nama</td><td class="td-ro">:</td><td width="400"><b>' . $nama . '</b></td></tr>'
                            . '<tr><td width="10"></td><td>Jabatan</td><td class="td-ro">:</td><td><b>' . $jabatan . '</b></td></tr>'
                            . '</table>';
                    $html .='<p style="font-size:10px;">Dalam hal ini bertindak untuk dan atas nama :</p>';
                    $html .='<table class="tables"  style="font-size:10px;">'
                            . '<tr><td width="10"></td><td width="70"></td><td class="td-ro"></td><td width="400"><b>' . $company->comp_name . '</b></td></tr>'
                            . '<tr><td width="10"></td><td width="70">Alamat</td><td class="td-ro">:</td><td><b>' . $company->comp_add1 . ' ' . $company->comp_add2 . '</b></td></tr>'
                            . '<tr><td width="10"></td><td>Telepon</td><td class="td-ro">:</td><td>' . $company->comp_phone . '</td></tr>'
                            . '</table>';

                    $html .='<p style="font-size:10px;">Menyatakan dengan sesungguhnya bahwa BPKB untuk kendaraan dengan data-data berikut ini</p>
                              <p style="font-size:10px;">masih dalam proses di kepolisian setempat, dan apabila BPKB dan  Faktur atas nama:</p>
                               <p style="font-size:10px;"><b>' . $read->cust_name . '</b></p>
                              <p style="font-size:10px;">telah selesai, maka ' . $read->lease_name . ' dapat mengambil kepada</p>
                                   <p style="font-size:10px;"><b>' . $company->comp_name . '</b></p>
                              <p style="font-size:10px;">dalam jangka waktu maksimal ' . $form['nbr'] . ' ' . $form['bulan'] . ' ' . $sejak . '</p>';

                    $html .='<p style="font-size:10px;">Adapun data kendaraan adalah sebagai berikut :</p>';
                    $html .='<table class="tables"  style="font-size:10px;">'
                            . '<tr><td width="10"></td><td width="70">Merk</td><td class="td-ro">:</td><td width="400"><b>' . $read->veh_brand . '</b></td></tr>'
                            . '<tr><td width="10"></td><td>Tipe/Model</td><td class="td-ro">:</td><td><b>' . $read->veh_type . '/' . $read->veh_model . '</b></td></tr>'
                            . '<tr><td width="10"></td><td>Keterangan</td><td class="td-ro">:</td><td width="400"><b>' . $read->veh_name . '</b></td></tr>'
                            . '<tr><td width="10"></td><td>Warna</td><td class="td-ro">:</td><td><b>' . $read->color_name . '</b></td></tr>'
                            . '<tr><td width="10"></td><td>No. Rangka</td><td class="td-ro">:</td><td width="400"><b>' . $read->chassis . '</b></td></tr>'
                            . '<tr><td width="10"></td><td>BPKB a/n</td><td class="td-ro">:</td><td><b>' . $read->cust_rname . '</b></td></tr>'
                            . '<tr><td width="10"></td><td>Alamat</td><td class="td-ro">:</td><td width="400"><b>' . $read->cust_raddr . '</b></td></tr>'
                            . '</table>';

                    $html .= '<p style="font-size:10px;">Demikian surat pernyataan ini dibuat dengan sebenarnya untuk dapat diketahui.</p>';
                    $html .= '<p style="font-size:10px;">' . $company->comp_city . ', ' . date('d M Y') . '<br />Yang membuat pernyataan,</p>';
                    $html .= '<p></p><p></p>';
                    $html .= '<p style="font-size:10px;"><b><u>' . $nama . '</u><br />' . $jabatan . '</b></p>';
                }

                if ($form['type'] == '2' || $form['type'] == '3') {
                    $html .= '<p style="font-size:10px;">Kepada Yth,</p>';
                    $html .= '<p style="font-size:10px;"><b>' . $read->lease_name . '<br />';
                    $html .= $read->lease_city . '<br />'
                            . '' . $read->lease_zipc . '<br />'
                            . 'Ref. No : ' . $read->sal_inv_no . '<br />';
                    if ($form['type'] == '2') {
                        $html .= 'Perihal : Pencairan Kredit</b></p>';
                    }
                    if ($form['type'] == '3') {
                        $html .= 'Perihal : Transfer Refund</b></p>';
                    }
                    $html .='<br /><br />';
                    $html .= '<p style="font-size:10px;">Dengan Hormat,</p>';
                    $html .= '<p style="font-size:10px;">Sehubungan dengan penjualan 1 (satu) unit Kendaraan ' . $read->veh_brand . ', yang kreditnya disalurkan melalui</p>';
                    $html .= '<p style="font-size:10px;"><b>' . $read->lease_name . ' ' . $read->lease_city . ' ' . $read->lease_zipc . ' </p>';
                    $html .= '<p style="font-size:10px;">bersama ini kami beritahukan untuk pembayaran Pelunasan kendaraan dengan data sebagai berikut:</p>';

                    $html .='<table class="tables"  style="font-size:10px;">'
                            . '<tr><td width="10"></td><td width="70">Merk</td><td class="td-ro">:</td><td width="400"><b>' . $read->veh_brand . '</b></td></tr>'
                            . '<tr><td width="10"></td><td>Tipe/Model</td><td class="td-ro">:</td><td><b>' . $read->veh_type . '/' . $read->veh_model . '</b></td></tr>'
                            . '<tr><td width="10"></td><td>Tahun</td><td class="td-ro">:</td><td width="400"><b>' . $read->veh_year . '</b></td></tr>'
                            . '<tr><td width="10"></td><td>Keterangan</td><td class="td-ro">:</td><td width="400"><b>' . $read->veh_name . '</b></td></tr>'
                            . '<tr><td width="10"></td><td>Warna</td><td class="td-ro">:</td><td><b>' . $read->color_name . '</b></td></tr>'
                            . '<tr><td width="10"></td><td>No. Rangka</td><td class="td-ro">:</td><td width="400"><b>' . $read->chassis . '</b></td></tr>'
                            . '<tr><td width="10"></td><td>No. Mesin</td><td class="td-ro">:</td><td width="400"><b>' . $read->engine . '</b></td></tr>'
                            . '<tr><td width="10"></td><td>BPKB a/n</td><td class="td-ro">:</td><td><b>' . $read->cust_rname . '</b></td></tr>'
                            . '<tr><td width="10"></td><td>Alamat</td><td class="td-ro">:</td><td width="400"><b>' . $read->cust_raddr . '</b></td></tr>'
                            . '<tr><td colspan="6"></td></tr>'
                            . '<tr><td width="10"></td><td><b>Debitur / QQ</b></td><td class="td-ro">:</td><td width="400"></td></tr>'
                            . '<tr><td colspan="6"></td></tr>'
                            . '<tr><td width="10"></td><td>Telp/HP</td><td class="td-ro">:</td><td width="400"><b>' . $read->cust_dphon . '</b></td></tr>'
                            . '<tr><td width="10"></td><td>Asuransi</td><td class="td-ro">:</td><td width="400"><b>' . $read->crdinscode . '-' . $read->crdinsname . '</b></td></tr>'
                            . '<tr><td width="10"></td><td>Pelunasan</td><td class="td-ro">:</td><td width="400"><b>Rp. ' . number_format($read->crd_amount) . '</b></td></tr>'
                            . '<tr><td width="10"></td><td>Terbilang</td><td class="td-ro">:</td><td width="400"><b>#' . terbilang($read->crd_amount) . ' Rupiah#</b></td></tr>'
                            . '</table>';

                    $html .= '<p style="font-size:10px;">mohon ditransfer melalui:</p>';
                    $html .='<table class="tables"  style="font-size:10px;">'
                            . '<tr><td width="10"></td><td width="70">Bank</td><td class="td-ro">:</td><td width="400"><b>' . str_replace('+', ' ', $form['bank']) . '</b></td></tr>'
                            . '<tr><td width="10"></td><td>Cabang</td><td class="td-ro">:</td><td width="400"><b>' . str_replace('+', ' ', $form['cabang']) . '</b></td></tr>'
                            . '<tr><td width="10"></td><td>Atas Nama</td><td class="td-ro">:</td><td width="400"><b>' . str_replace('+', ' ', $form['rek_no']) . '</b></td></tr>'
                            . '<tr><td width="10"></td><td>No. Rekening</td><td class="td-ro">:</td><td width="400"><b>' . str_replace('+', ' ', $form['rek_name']) . '</b></td></tr>'
                            . '</table>';

                    $html .='<p style="font-size:10px;">Demikian surat permohonan transfer dari kami, terima kasih atas perhatian dan kerjsamanya.
                            <br />Hormat kami,
                            </p>';

                    $html .= '<p style="font-size:10px;"><b>' . $company->comp_name . '</b></p>';
                    $html .= '<p></p><p></p>';
                    $html .= '<p style="font-size:10px;"><b><u>' . $nama . '</u><br />' . $jabatan . '</b></p>';
                }

                if ($form['type'] == '4' || $form['type'] == '5') {
                    $html .='<table class="tables">';
                    $html .= '<tr><td></td>';
                    $html .= '<td><table class="tables">';
                    $html .='<tr><td colspan="2" style="font-size:12px;"><b>' . $company->comp_name . '</b></td></tr>';
                    $html .='<tr><td colspan="2">' . $company->comp_add1 . '</td></tr>';
                    $html .='<tr><td colspan="2">' . $company->comp_add2 . '</td></tr>';
                    $html .='<tr><td><b>Phone : </b>' . $company->comp_phone . '</td><td><b>Fax : </b>' . $company->comp_fax . '</td></tr>';
                    $html .= '</table></td></tr>';

                    $html .='</table>';
                    $html .='<br /><br />';
                    $html .='<p style="text-align:center;"><b>KWITANSI</b></p>';

                    $html .='<table class="tables">';
                    $html .='<tr><td width="120"><b>Kwitansi No.</b></td><td class="td-ro">:</td><td><b>' . $read->sal_inv_no . '</b></td></tr>';
                    $html .='<tr><td><b>Sudah terima dari</b></td><td class="td-ro">:</td><td>' . $read->cust_name . '</td></tr>';
                    if ($form['type'] == '5') {
                        $html .='<tr><td><b>QQ</b></td><td class="td-ro">:</td><td>' . $read->cust_dname . '</td></tr>';
                    }
                    $html .='<tr><td><b>Telp / HP</b></td><td class="td-ro">:</td><td>' . $read->cust_phone . '</td></tr>';
                    $html .='<tr><td colspan="3"></td></tr>';

                    if ($form['type'] == '4') {
                        $html .='<tr><td><b>Banyaknya uang</b></td><td class="td-ro">:</td><td>Rp. ' . number_format($read->crd_dppo) . '</td></tr>';
                        $html .='<tr><td><b>Terbilang</b></td><td class="td-ro">:</td><td>#' . terbilang($read->crd_dppo) . 'Rupiah.#</td></tr>';
                    }

                    if ($form['type'] == '5') {
                        $html .='<tr><td><b>Banyaknya uang</b></td><td class="td-ro">:</td><td>Rp. ' . number_format($read->crd_amount) . '</td></tr>';
                        $html .='<tr><td><b>Terbilang</b></td><td class="td-ro">:</td><td>#' . terbilang($read->crd_amount) . 'Rupiah.#</td></tr>';
                    }

                    $html .='</table>';

                    if ($form['type'] == '4') {
                        $p_title = 'Untuk Pembayaran Uang Muka kendaraan';
                    }
                    if ($form['type'] == '5') {
                        $p_title = 'Untuk Pembayaran Kwitansi Kredit (Pelunasan)';
                    }
                    $html .='<br /><br /><br />';
                    $html .='<table class="tables"><tr><td><p>' . $p_title . ' ' . $read->veh_brand . '</p></td></tr></table>';
                    $html .='<br /><br /><br />';
                    $html .='<table>';
                    $html .='<tr>';
                    $html .='<td>'
                            . '<table class="tables">'
                            . '<tr><td width="20"></td><td><b>No. Rangka</b></td><td class="td-ro">:</td><td width="170">' . $read->chassis . '</td></tr>'
                            . '<tr><td width="20"></td><td><b>No. Mesin</b></td><td class="td-ro">:</td><td>' . $read->engine . '</td></tr>'
                            . '<tr><td width="20"></td><td><b>Kendaraan</b></td><td class="td-ro">:</td><td>' . $read->veh_name . '</td></tr>'
                            . '</table>'
                            . '</td>';
                    $html .='<td>'
                            . '<table class="tables">'
                            . '<tr><td width="50"><b>Tahun</b></td><td class="td-ro">:</td><td width="200">' . $read->veh_year . '</td></tr>'
                            . '<tr><td><b>Model</b></td><td class="td-ro">:</td><td>' . $read->veh_model . '</td></tr>'
                            . '<tr><td><b>Warna</b></td><td class="td-ro">:</td><td>' . $read->color_name . '</td></tr>'
                            . '</table>'
                            . '</td>';
                    $html .='</tr>';
                    $html .='</table>';

                    $html .='<br /><br /><br />';
                    $html .='<table class="tables">'
                            . '<tr>'
                            . '<td width="75%"><p>Asuransi di ' . $read->crdinscode . '-' . $read->crdinsname . '</p></td>'
                            . '<td>' . $company->comp_city . ', ' . date('d M Y') . '</td></tr></table>';

                    $html .='<br /><br /><br /><br /><br /><br /><br /><br /><br />';
                    $html .='<table class="tables"><tr>';
                    $html .='<td width="75%"><p>Pembayaran dengan cek/giro bilyet sah setelah diuangkan/masuk rekening kami</p></td>';
                    $html .= '<td><p><b><u>' . $nama . '</u><br />' . $jabatan . '</b></p></td>';
                    $html .='</tr></table>';
                }
                
                $html .= '<table class="tables">';
                $html .='<tr><td align="right"><table>';
                /* Counter Printer*/
                $user = $data['user'];
                $prn_cnt = $read->prn_cnt;

                    $viewcnt = array(
                        'user' => $user,
                        'prn_cnt' => $prn_cnt,
                        'action' => $data['action']
                    );

                $html .= $this->viewPrnCnt($viewcnt);
                /* Counter Printer*/
                $html .='</table></td></tr>';
                $html .= '</table>';
                
                break;

            case 'veh_doc':
                $spk = $this->all_m->getId('veh_spk', 'so_no', $read->so_no);
                $slh = $this->all_m->getId('veh_slh', 'sal_inv_no', $read->sal_inv_no);
                $arh = $this->all_m->getId('veh_arh', 'sal_inv_no', $read->sal_inv_no);

                if ($data['doc']) {

                    $html .= '<table class="tables">';
                    $html .= '<tr>';
                    $html .= '<td width="50%">';
                    $html .= '<table class="tables" style="font-size:12px;">';
                    $html .='<tr><td colspan="2" style="font-size:12px;"><b>' . $company->comp_name . '</b></td></tr>';
                    $html .='<tr><td colspan="2">' . $company->comp_add1 . '</td></tr>';
                    $html .='<tr><td colspan="2">' . $company->comp_add2 . '</td></tr>';
                    $html .='<tr><td><b>Phone : </b>' . $company->comp_phone . '</td><td><b>Fax : </b>' . $company->comp_fax . '</td></tr>';
                    $html .= '</table>';
                    $html .= '</td>';
                    $html .= '</tr>';
                    $html .= '</table>';

                    if ($data['doc'] == 'stnk') {

                        $html .= '<h3 style="text-align:center;">TANDA TERIMA STNK</h3>';
                        $html .= '<br /><br /><br /><br />';

                        $html .= '<table>';
                        $html .= '<tr>'
                                . '<td>';
                        $html .= '<table>';
                        $html .= '<tr>'
                                . '<td>'
                                . '<table class="tables" style="font-size:12px;">';
                        $html .= '<tr><td width="80"><b  style="font-size:14px;"><u>STNK</u></b></td></tr>';
                        $html .= '<tr><td width="80">&nbsp;&nbsp;<b>NOMOR</b></td><td width="15">:</td><td width="160">' . $read->stnk_no . '</td></tr>';
                        $html .= '<tr><td>&nbsp;&nbsp;<b>TANGGAL</b></td><td width="15">:</td><td>' . $this->dateView($read->stnk_bdate) . '</td></tr>';
                        $html .= '<tr><td>&nbsp;&nbsp;<b>NAMA</b></td><td width="15">:</td><td>' . $read->cust_rname . '</td></tr>';
                        $html .= '<tr><td>&nbsp;&nbsp;<b>ALAMAT</b></td><td width="15">:</td><td width="300">' . $read->cust_raddr . '</td></tr>';
                        $html .= '</table>'
                                . '</td>'
                                . '<td>'
                                . '<table class="tables" style="font-size:12px;">';
                        $html .= '<tr><td><b>NO. TANDA TERIMA</b></td><td width="15">:</td><td>' . $vds_number . '</td></tr>';
                        $html .= '<tr><td><b>NO. DOKUMEN</b></td><td width="15">:</td><td>' . $read->doc_inv_no . '</td></tr>';

                        $html .= '</table>'
                                . '</td>'
                                . '</tr>';

                        $html .= '<tr>'
                                . '<td>'
                                . '<table class="tables" style="font-size:12px;">';
                        $html .= '<tr><td width="80"><b>KENDARAAN</b></td><td width="15">:</td><td width="200">' . $read->veh_name . '</td></tr>';
                        $html .= '<tr><td><b>WARNA</b></td><td width="15">:</td><td>' . $read->color_name . '</td></tr>';

                        $html .= '</table>'
                                . '</td>'
                                . '<td>'
                                . '<table class="tables" style="font-size:12px;">';
                        $html .= '<tr><td><b>NO. FAKTUR</b></td><td width="15">:</td><td>' . $read->veh_inv_no . '</td></tr>';
                        $html .= '<tr><td><b>TGL. FAKTUR</b></td><td width="15">:</td><td>' . $this->dateView($read->veh_inv_dt) . '</td></tr>';
                        $html .= '<tr><td><b>SERTIFIKAT NIK</b></td><td width="15">:</td><td width="200">' . $read->veh_invnik . '</td></tr>';

                        $html .= '</table>'
                                . '</td>'
                                . '</tr>';

                        $html .= '<tr>'
                                . '<td>'
                                . '<table class="tables" style="font-size:12px;">';
                        $html .= '<tr><td width="80"><b>NO. RANGKA</b></td><td width="15">:</td><td>' . $read->chassis . '</td></tr>';
                        $html .= '<tr><td><b>NO. MESIN</b></td><td width="15">:</td><td>' . $read->engine . '</td></tr>';
                        $html .= '<tr><td><b>NO. POLIS</b></td><td width="15">:</td><td>' . $read->veh_reg_no . '</td></tr>';

                        $html .= '</table>'
                                . '</td>'
                                . '</tr>';

                        $html .= '</table>';

                        $html .= '</td></tr></table>';

                        $html .= '<br /><br />';
                        $html .= '<table class="tables"  style="font-size:12px;">';

                        $stnkdate = $this->dateView($read->stnk_sdate);

                        $html .= '<tr><td></td><td></td><td>' . $company->comp_city . ', ' . $stnkdate . '</td></tr>';

                        $html .= '<tr><td></td>';
                        $html .= '<td><table>';
                        $html .= '<tr><td width="20"></td><td width="120" align="center"><b>Diserahkan Oleh,</b></td><td width="20"></td></tr>';
                        $html .= '<tr><td><br /><br /><br /></td></tr>';
                        $html .= '<tr><td>(</td><td align="center">' . $read->stnk_gname . '</td><td  align="right">)</td></tr>';
                        $html .= '</table></td>';

                        $html .= '<td><table>';
                        $html .= '<tr><td width="20"></td><td width="120" align="center"><b>Diterima Oleh,</b></td><td width="20"></td></tr>';
                        $html .= '<tr><td><br /><br /><br /></td></tr>';
                        $html .= '<tr><td>(</td><td align="center">' . $read->stnk_sname . '</td><td  align="right">)</td></tr>';
                        $html .= '</table></td>';

                        $html .= '<td></td></tr>';

                        $html .= '</table>';
                    } else {
                        $bpkb_date = $this->dateView($read->bpkb_date);
                        $veh_inv_dt = $this->dateView($read->veh_inv_dt);
                        $forma_date = $this->dateView($read->veh_inv_dt);


                        $html .= '<h3 style="text-align:center;">TANDA TERIMA BPKB, FAKTUR, SERTIFIKAT NIK & FROM A</h3>';
                        $html .= '<table class="tables" style="font-size:12px;">';
                        $html .= '<tr>';

                        $html .= '<td valign="top">';
                        $html .= '<h3 style="font-size:14px;"><u>BPKB</u></h3>';
                        $html .= '<table>';
                        $html .= '<tr><td><b>NOMOR</b></td><td class="td-ro">:</td><td width="180">' . $read->bpkb_no . '</td></tr>';
                        $html .= '<tr><td><b>TANGGAL</b></td><td class="td-ro">:</td><td width="180">' . $bpkb_date . '</td></tr>';
                        $html .= '<tr><td><b>NAMA</b></td><td class="td-ro">:</td><td width="180">' . $read->cust_rname . '</td></tr>';
                        $html .= '<tr><td><b>ALAMAT</b></td><td class="td-ro">:</td><td width="180">' . $read->cust_addr . '</td></tr>';
                        $html .= '<tr><td><br /></td></tr>';
                        $html .= '<tr><td><b>KENDARAAN</b></td><td class="td-ro">:</td><td width="180">' . $read->veh_name . '</td></tr>';
                        $html .= '<tr><td><b>WARNA</b></td><td class="td-ro">:</td><td width="180">' . $read->color_name . '</td></tr>';
                        $html .= '<tr><td><br /></td></tr>';
                        $html .= '<tr><td><b>NO. RANGKA</b></td><td class="td-ro">:</td><td width="180">' . $read->chassis . '</td></tr>';
                        $html .= '<tr><td><b>NO. MESIN</b></td><td class="td-ro">:</td><td width="180">' . $read->engine . '</td></tr>';
                        $html .= '<tr><td><b>NO. POLISI</b></td><td class="td-ro">:</td><td width="180">' . $read->veh_reg_no . '</td></tr>';
                        $html .= '</table>';
                        $html .= '</td>';

                        $html .= '<td valign="top">';
                        $html .= '<h3 style="font-size:14px;"></h3>';
                        $html .= '<table>';
                        $html .= '<tr><td><b>NO. TANDA TERIMA</b></td><td class="td-ro">:</td><td width="180">' . $read->vdb_inv_no . '</td></tr>';
                        $html .= '<tr><td><b>NO. DOKUMEN</b></td><td class="td-ro">:</td><td width="180">' . $read->doc_inv_no . '</td></tr>';
                        $html .= '<tr><td><br /></td></tr>';
                        $html .= '<tr><td><b>NO. FAKTUR</b></td><td class="td-ro">:</td><td width="180">' . $read->veh_inv_no . '</td></tr>';
                        $html .= '<tr><td><b>TGL. FAKTUR</b></td><td class="td-ro">:</td><td width="180">' . $veh_inv_dt . '</td></tr>';
                        $html .= '<tr><td><br /></td></tr>';
                        $html .= '<tr><td><b>SERTIFIKAT NIK</b></td><td class="td-ro">:</td><td width="180">' . $read->veh_invnik . '</td></tr>';
                        $html .= '<tr><td><b>NO. FORM A</b></td><td class="td-ro">:</td><td width="180">' . $read->forma_no . '</td></tr>';
                        $html .= '<tr><td><b>TGL. FORM A</b></td><td class="td-ro">:</td><td width="180">' . $forma_date . '</td></tr>';
                        $html .= '</table>';
                        $html .= '</td>';

                        $html .= '</tr>';
                        $html .= '</table>';

                        $html .= '<br /><br />';
                        $html .= '<table>';

                        $bpkb_sdate = $this->dateView($read->stnk_sdate);

                        $html .= '<tr><td width="150"></td><td width="350"></td><td>' . $company->comp_city . ', ' . $bpkb_sdate . '</td></tr>';

                        $html .= '<tr>';
                        $html .= '<td width="150"><table>';
                        $html .= '<tr><td width="20"></td><td width="100" align="center"><b>Yang Menyerahkan,</b></td><td width="20"></td></tr>';
                        $html .= '<tr><td><br /><br /><br /><br /></td></tr>';
                        $html .= '<tr><td>(</td><td align="center"></td><td  align="right">)</td></tr>';
                        $html .= '<tr><td></td><td align="center" style="border-top:1px solid black;">STNK/BPKB STAFF</td><td  align="right"></td></tr>';
                        $html .= '</table></td>';

                        $html .= '<td width="350"><table>';
                        $html .= '<tr><td width="20"></td><td width="130" align="center"><b>Diserahkan Oleh,</b></td><td width="20"></td></tr>';
                        $html .= '<tr><td><br /><br /><br /><br /></td></tr>';
                        $html .= '<tr><td>(</td><td align="center">' . $read->bpkb_gname . '</td><td  align="right">)</td></tr>';

                        $html .= '<tr><td></td><td style="border-top:1px solid black;" align="center">ADMINISTRATION HEAD</td><td  align="right"></td></tr>';
                        $html .= '</table></td>';


                        $html .= '<td><table class="table" >';
                        $html .= '<tr><td width="20"></td><td width="100" align="center"><b>Diterima Oleh,</b></td><td width="20"></td></tr>';
                        $html .= '<tr><td><br /><br /><br /><br /></td></tr>';
                        $html .= '<tr><td>(</td><td align="center">' . $read->bpkb_sname . '</td><td  align="right">)</td></tr>';
                        $html .= '<tr><td></td><td style="border-top:1px solid black;" align="center"></td><td  align="right"></td></tr>';
                        $html .= '</table></td>';

                        $html .= '</tr>';


                        $html .= '</table>';
                    }
                } else {
                    $html .= '<p style="text-align:center;font-weight:bold;font-size:14px;">' . $company->comp_name . '</p>';
                    $html .= '<p style="text-align:center;font-weight:bold;font-size:14px;">Status SPK Kendaraan</p>';
                    $html .='<table class="tables">';
                    $html .='<tr>';
                    $html .='<td width="50%">'
                            . '<table class="tables">';

                    $so_date = '';
                    if ($spk->so_date) {
                        $so_date = $this->dateView($spk->so_date);
                    }
                    $stnk_bdate = '';
                    if ($read->stnk_bdate) {
                        $stnk_bdate = $this->dateView($read->stnk_bdate);
                    }
                    $stnk_sdate = '';
                    if ($read->stnk_sdate) {
                        $stnk_sdate = $this->dateView($read->stnk_sdate);
                    }
                    $bpkb_date = '';
                    if ($read->bpkb_date) {
                        $bpkb_date = $this->dateView($read->bpkb_date);
                    }
                    $bpkb_rdate = '';
                    if ($read->bpkb_rdate) {
                        $bpkb_rdate = $this->dateView($read->bpkb_rdate);
                    }

                    $match_date = '';
                    if ($slh->match_date) {
                        $match_date = $this->dateView($slh->match_date);
                    }
                    $pick_date = '';
                    if ($slh->pick_date) {
                        $pick_date = $this->dateView($slh->pick_date);
                    }
                    $sal_date = '';
                    if ($slh->sal_date) {
                        $sal_date = $this->dateView($slh->sal_date);
                    }
                    $sj_date = '';
                    if ($slh->sj_date) {
                        $sj_date = $this->dateView($slh->sj_date);
                    }

                    $pay_date = '';
                    if ($read->pay_date) {
                        $pay_date = $this->dateView($read->pay_date);
                    }
                    $check_date = '';
                    if ($read->check_date) {
                        $check_date = $this->dateView($read->check_date);
                    }

                    $crd_cntrdt = '';
                    if ($slh->crd_cntrdt) {
                        $crd_cntrdt = $this->dateView($slh->crd_cntrdt);
                    }

                    $veh_inv_dt = '';
                    if ($read->veh_inv_dt) {
                        $veh_inv_dt = $this->dateView($read->veh_inv_dt);
                    }


                    $html .= '<tr><td>No. SPK</td><td width="15">:</td><td width="160">' . $spk->so_no . ' - ' . $so_date . '</td></tr>';
                    $html .= '<tr><td>Nama Sales</td><td width="15">:</td><td>' . $spk->srep_code . ' - ' . $spk->srep_name . '</td></tr>';
                    $html .= '<tr><td>Pembuat SPK</td><td width="15">:</td><td>' . $spk->so_made_by . '</td></tr>';
                    $html .= '<tr><td>SPK Disetujui Oleh</td><td width="15">:</td><td>' . $spk->so_appr_by . '</td></tr>';
                    $html .= '<tr><td>Keterangan di SPK</td><td width="15">:</td><td>' . $spk->so_desc . '</td></tr>';
                    $html .= '<tr><td>Harga Kendaraan</td><td width="15">:</td><td>Rp. ' . number_format($spk->unit_price) . '</td></tr>';

                    $html .='<tr><td colspan="3"></td></tr>';
                    $html .='<tr><td colspan="3"><b>Data Pemesan :</b></td></tr>';
                    $html .= '<tr><td>Nama Customer</td><td width="15">:</td><td>' . $spk->cust_name . '</td></tr>';
                    $html .= '<tr><td>Alamat Customer</td><td width="15">:</td><td>' . $spk->cust_addr . '</td></tr>';


                    $html .='<tr><td colspan="3"></td></tr>';
                    $html .='<tr><td colspan="3"><b>Data STNK & BPKB :</b></td></tr>';
                    $html .= '<tr><td>Nama STNK</td><td width="15">:</td><td>' . $read->cust_rname . '</td></tr>';
                    $html .= '<tr><td>Alamat STNK</td><td width="15">:</td><td>' . $read->cust_raddr . '</td></tr>';
                    $html .= '<tr><td>No. /Tgl STNK</td><td width="15">:</td><td>' . $read->stnk_no . ' - ' . $stnk_bdate . '</td></tr>';
                    $html .= '<tr><td>Tgl. Serah STNK</td><td width="15">:</td><td>' . $stnk_sdate . ' - ' . $read->stnk_sname . '</td></tr>';
                    $html .= '<tr><td>No. Polisi</td><td width="15">:</td><td>' . $read->cust_rname . '</td></tr>';
                    $html .= '<tr><td>No. /Tgl BPKB</td><td width="15">:</td><td>' . $read->bpkb_no . ' - ' . $bpkb_date . '</td></tr>';
                    $html .= '<tr><td>Tgl. Serah BPKB</td><td width="15">:</td><td>' . $bpkb_rdate . ' - ' . $read->bpkb_rname . '</td></tr>';

                    $prc_type = $spk->prc_type;

                    if ($prc_type == '1') {
                        $prc_type = 'ON the road';
                    }
                    if ($prc_type == '2') {
                        $prc_type = 'OFF the road';
                    }



                    $html .='<tr><td colspan="3"></td></tr>';
                    $html .='<tr><td colspan="3"><b>Pembayaran & Lain-lain :</b></td></tr>';
                    $html .= '<tr><td>Jenis Harga di SPK</td><td width="15">:</td><td>' . $prc_type . '</td></tr>';
                    $html .= '<tr><td>Jenis Pembayaran</td><td width="15">:</td><td>' . $spk->pay_type . '</td></tr>';
                    $html .= '<tr><td>Uang Muka di SPK</td><td width="15">:</td><td>' . number_format($spk->pay_val) . '</td></tr>';
                    $html .= '<tr><td>Tgl. Bayar di SPK</td><td width="15">:</td><td>' . $pay_date . '</td></tr>';
                    $html .= '<tr><td>No. Cek/Giro</td><td width="15">:</td><td>' . $spk->check_no . ' - ' . $check_date . '</td></tr>';
                    $html .= '<tr><td>Leasing</td><td width="15">:</td><td>' . $slh->lease_code . ' - ' . $slh->lease_name . '</td></tr>';
                    $html .= '<tr><td>Kredit Via/Refrensi</td><td width="15">:</td><td>' . $spk->crd_via . '</td></tr>';
                    $html .= '<tr><td>No. Kontrak</td><td width="15">:</td><td>' . $slh->crd_cntrno . ' - ' . $crd_cntrdt . '</td></tr>';
                    $html .= '<tr><td>Asuransi</td><td width="15">:</td><td>'.$slh->insr_name.'-'.$slh->crdinscode.'</td></tr>';
                    $html .= '<tr><td>Refund/Komisi</td><td width="15">:</td><td>' . number_format($slh->crdinscomm) . '</td></tr>';
                    $html .= '<tr><td>Subsidi/Discount</td><td width="15">:</td><td>' . number_format($slh->crdinsdisc) . '</td></tr>';
                    $html .= '<tr><td>No. / Tgl. Inv. ATPM</td><td width="15">:</td><td>' . $read->veh_inv_no . ' - ' . $veh_inv_dt . '</td></tr>';


                    $html .= '</table>'
                            . '</td>';


                    $totaloptional = intval($slh->veh_misc) + intval($slh->srv_at) + intval($slh->part_at) + intval($slh->inv_stamp);
                    $html .='<td width="50%">'
                            . '<table class="tables">';
                    $html .='<tr><td colspan="3"><b>Data Penjualan :</b></td></tr>';
                    $html .= '<tr><td width="100">No. Faktur Jual</td><td width="15">:</td><td width="120" >' . $slh->sal_inv_no . ' - ' . $sal_date . '</td></tr>';
                    $html .= '<tr><td width="100">No. Surat Jalan</td><td width="15">:</td><td colspan="2">' . $slh->sj_no . ' - ' . $sj_date . '</td></tr>';
                    $html .= '<tr><td width="100">Tgl. Matching</td><td width="15">:</td><td colspan="2">' . $match_date . '</td></tr>';
                    $html .= '<tr><td width="100">Tgl. Pick</td><td width="15">:</td><td colspan="2">' . $pick_date . '</td></tr>';
                    $html .= '<tr><td width="100">Kendaraan</td><td width="15">:</td><td colspan="2">' . $slh->veh_name . '</td></tr>';
                    $html .= '<tr><td width="100">Tipe</td><td width="15">:</td><td colspan="2">' . $slh->veh_type . '</td></tr>';
                    $html .= '<tr><td width="100">Warna</td><td width="15">:</td><td colspan="2">' . $slh->color_name . '</td></tr>';
                    $html .= '<tr><td width="100">Chassis</td><td width="15">:</td><td colspan="2">' . $slh->chassis . '</td></tr>';
                    $html .= '<tr><td width="100">Engine</td><td width="15">:</td><td colspan="2">' . $slh->engine . '</td></tr>';
                    $html .= '<tr><td width="100">No. Kunci</td><td width="15">:</td><td colspan="2">' . $slh->key_no . '</td></tr>';
                    $html .= '<tr><td width="100">Harga Price List</td><td width="15">:</td><td align="right">' . number_format($slh->veh_price) . '</td><td></td></tr>';
                    $html .= '<tr><td width="100">Subsidi Discount</td><td width="15">:</td><td align="right">' . number_format($slh->veh_disc) . '</td><td></td></tr>';
                    $html .= '<tr><td colspan="2"></td><td>-------------------------</td><td><b>-</b></td></tr>';
                    $html .= '<tr><td width="100">Harga Netto</td><td width="15">:</td><td align="right">' . number_format($slh->veh_at) . '</td><td></td></tr>';
                    $html .= '<tr><td width="100">BBN</td><td width="15">:</td><td align="right">' . number_format($slh->veh_bbn) . '</td><td></td></tr>';
                    $html .= '<tr><td colspan="2"></td><td>-------------------------</td><td><b>+</b></td></tr>';
                    $html .= '<tr><td width="100">Total Harga</td><td width="15">:</td><td align="right">' . number_format($slh->veh_total) . '</td><td></td></tr>';
                    $html .= '<tr><td width="100">Optional & Lain-lain</td><td width="15">:</td><td align="right">' . number_format($totaloptional) . '</td><td></td></tr>';
                    $html .= '<tr><td colspan="2"></td><td>-------------------------</td><td><b>+</b></td></tr>';
                    $html .= '<tr><td width="100">Grand Total Harga</td><td width="15">:</td><td align="right">' . number_format($slh->inv_total) . '</td><td></td></tr>';

                    $html .='<tr><td colspan="3"></td></tr>';
                    $html .='<tr><td colspan="3"><b>Pekerjaan Jasa / Optional :</b></td></tr>';
                    
                    $veh_sld = $this->all_m->getWhere('veh_sld', array('sal_inv_no' => $slh->sal_inv_no));
                    
                    foreach($veh_sld as $sld){
                        $html .='<tr><td colspan="3">+ '.$sld->wk_desc.'</td></tr>';
                    }
                    
                    
                    $html .='<tr><td colspan="3"></td></tr>';
                    $html .='<tr><td colspan="3"></td></tr>';
                    $html .='<tr><td colspan="3"></td></tr>';
                    $html .='<tr><td colspan="3"></td></tr>';
                    $html .='<tr><td colspan="3"></td></tr>';
                    $html .='<tr><td colspan="3"></td></tr>';
                    $html .='<tr><td colspan="3"></td></tr>';
                    $html .='<tr><td colspan="3"></td></tr>';
                    $html .='<tr><td colspan="3"></td></tr>';
                    $html .= '<tr><td>Sisa Piutang</td><td width="15">:</td><td align="right">' . number_format($arh->pd_end) . '</td><td></td></tr>';
                    $html .='</table></td>';
                    $html .='</tr>';
                    $html .='</table>';

                    $html .='<br /><br />';
                    $html .='<table class="tables">';
                    $html .='<tr><td><b>History Kwitansi & Faktur:</b></td></tr>';
                    $html .='</table>';

                    $veh_ard = $this->all_m->getWhere('veh_ard', array('sal_inv_no' => $read->sal_inv_no));

                    $html .='<table class="tables">';
                    $html .='<tr>'
                            . '<td width="20"><b>No.</b></td>'
                            . '<td><b>No. Faktur<br />No. Kwitansi</b></td>'
                            . '<td><b>Tgl. Faktur<br />Tgl. Kwitansi</b></td>'
                            . '<td width="55"><b>Jenis Pembayaran</b></td>'
                            . '<td  width="55"><b>Tanggal Cek/Giro</b></td>'
                            . '<td  width="55"><b>Tanggal J Tempo</b></td>'
                            . '<td width="130"><b>Keterangan</b></td>'
                            . '<td align="right"><b>Nilai Kwitansi</b></td></tr>';

                    $html .='<tr><td colspan="8"><hr /></td></tr>';

                    $no = 1;
                    foreach ($veh_ard as $ard):
                        $html .='<tr>'
                                . '<td width="20">' . $no . '.</td>'
                                . '<td>' . $ard->sal_inv_no . '</td>'
                                . '<td>' . $this->dateView($ard->sal_date) . '</td>'
                                . '<td>' . $ard->pay_type . '</td>'
                                . '<td>' . $this->dateView($ard->check_date) . '</td>'
                                . '<td></td>'
                                . '<td>' . $ard->pay_desc . '</td>'
                                . '<td align="right">' . number_format($ard->pay_val) . '</td></tr>';

                        $no++;
                    endforeach;

                    $html .='<tr><td colspan="6"></td><td><b>Grand Total :</b></td><td align="right;">' . number_format($arh->pd_paid) . '</td></tr>';
                    $html .='</table>';
                }
                break;
        }

        $output = array(
            'html' => $html,
            'number' => $number
        );

        return $output;
    }

    function deleteDoc() {

        $table = $this->input->post('table');
        $id = $this->input->post('id');

        $data = array(
             'doc_date', 'stnk_rname', 'stnk_ridno', 'stnk_rdate', 'stnk_sname', 'stnk_sidno', 'stnk_sdate', 'bpkb_no', 'bpkb_date', 'bpkb_rname', 'bpkb_ridno', 'bpkb_rdate', 'bpkb_sname', 'bpkb_sidno', 'bpkb_sdate', 'cust_rarea', 'cust_rcity', 'cust_rzipc', 'cust_rphon', 'cust_rsex', 'stnk_no', 'stnk_bdate', 'stnk_edate', 'veh_reg_no'
        );

        foreach ($data as $slh) {
            $data_slh[$slh] = '';
        }
        $data_slh['doc_inv_no'] = NULL;
         
        $veh_doc = $this->all_m->getId($table, 'id', $id);

        $this->all_m->updateData('veh_slh', 'sal_inv_no', $veh_doc->sal_inv_no, $data_slh);
        $this->all_m->deleteData($table, 'id', $id);

        $check = $this->all_m->countlimit($table, array('id' => $id));

        if ($check > 0) {
            $msg = array('success' => false, 'message' => 'Delete failed');
        } else {
            // $inv_seq = $this->all_m->getOne('inv_seq', array('inv_type' => 'VPR'));
            //$this->all_m->updateData('inv_seq', 'id', $inv_seq->id, array('inv_no' => $inv_seq->inv_no - 1));
            $msg = array('success' => true, 'message' => 'Delete success');
        }

        $this->json($msg);
    }

}
