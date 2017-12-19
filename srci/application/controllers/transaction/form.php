<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
//error_reporting(E_ALL ^ E_NOTICE);
//error_reporting(0);
date_default_timezone_set("Asia/Jakarta");

class Form extends Application {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('crud_mdl', 'get_data_mdl', 'all_m'));
    }

    function outputpdf() {
        $margin = null;
        $font = null;
        $data['tbl'] = encrypt_decrypt('decrypt', $this->uri->segment(4));
        $data['id'] = urldecode($this->uri->segment(5));
        $data['user'] = urldecode($this->uri->segment(6));
        $data['action'] = urldecode($this->uri->segment(7));
        $data['year'] = null;
        $data['mounth'] = null;
        
        $prn_cnt = 'prn_cnt';
        $c_array = array();

        switch ($data['tbl']) {

            case 'veh_slh':
                $data['signature'] = urldecode($this->uri->segment(8));
                $data['jabatan'] = urldecode($this->uri->segment(9));
                $data['invoicedate'] = urldecode($this->uri->segment(10));

                if($this->uri->segment(11)){
                    $data['mounth'] = $this->uri->segment(11);
                }
                if($this->uri->segment(12)){
                     $data['year'] = $this->uri->segment(12);
                }
                
                $data['fp'] = $this->input->get();
                $data['fp_seq'] = (array) $this->all_m->getId('fp_seq', 'id', 1);

                $read = $this->readFP($data);
                $output = array(
                    'html' => $read['html'],
                    'filename' => 'FP_' . $read['number'],
                    'title' => 'FP_ ' . $read['number']
                );

                $margin = "P";
                $font = 'Courier';
                
                $prn_cnt = 'prn_cnt_fp';
                
                break;
            case 'veh_spk':
                $data['inv_code'] = encrypt_decrypt('decrypt', $this->uri->segment(8));
                $data['inv_type'] = encrypt_decrypt('decrypt', $this->uri->segment(9));
                
                if($this->input->get('mounth')){
                    $data['mounth'] = $this->input->get('mounth');
                }
                if($this->input->get('year')){
                     $data['year'] = $this->input->get('year');
                }
               
                $read = $this->readHtml($data);

                $output = array(
                    'html' => $read['html'],
                    'filename' => 'Report' . $read['number'],
                    'title' => 'Report_ ' . $read['number']
                );

                if ($this->uri->segment(11)) {
                    $margin = "L";
                } else {
                    $margin = "P";
                }
                $font = 'Courier';
                break;

            case 'acc_slh':
                $data['inv_code'] = encrypt_decrypt('decrypt', $this->uri->segment(9));
                $data['invoicedate'] = $this->uri->segment(10);
                $read = $this->readHtml($data);

                $output = array(
                    'html' => $read['html'],
                    'filename' => 'Report' . $read['number'],
                    'title' => 'Report_ ' . $read['number']
                );

                if ($this->uri->segment(11)) {
                    $margin = "L";
                } else {
                    $margin = "P";
                }
                $font = 'Courier';
                break;
        }
        
        if($data['tbl'] == 'veh_slh'){
            if($action !== 'screen'){
                 $this->count_prnt($data, $c_array,$prn_cnt);
            }
        }
        $html = $output['html'];
        $pdf = $this->output_pdf($output['title'], $html, $output['filename'], $data['action'], $margin, $font);
    }

    function readFP($data) {
        $year = $data['year'];
        $mounth = $data['mounth'];
        
        $dbs = $this->getDataHistory($year, $mounth);
        
        $company = $this->all_m->query_single("select * from ssystem limit 1");
        $read = $this->all_m->getId($dbs.'.'.$data['tbl'], 'id', $data['id']);

        $fp_seq = $data['fp_seq'];
        $fp = $data['fp'];

        if ($read->fp_no !== '') {
            $inv_no = $read->fp_no;
        } else {
            $fp_no = $fp_seq['fp_no'] + 1;
            //$inv_no = $fp_seq['fp_code1'] . $fp_seq['fp_code2'] . date("y") . '.' . $fp_no;
            $inv_no = $fp['inv_no'];
        }

        $data_by = $fp['data_by'];

        switch ($data_by) {
            case 1:
                $name = $fp['cust_name'];
                $addr = $fp['cust_addr'];
                $npwp = $fp['cust_npwp'];
                break;

            case 2:
                $name = $fp['cust_rname'];
                $addr = $fp['cust_raddr'];
                $npwp = $fp['cust_rnpwp'];
                break;

            case 3:
                $name = $fp['cust_dname'];
                $addr = $fp['cust_daddr'];
                $npwp = $fp['cust_dnpwp'];
                break;
        }

        $html = '';
        $html = '<style>'
                . '.tableborder{border-collapse: collapse; border-spacing: 0; border:1px solid #000;}.left-border{border-left:1px solid black;}.right-border{border-right:1px solid black;}.top-border{border-top:1px solid black;}.bottom{border-bottom:1px solid black;}</style>';

        $html .='<table class="tables">';
        $html .='<tr>';
        $html .= '<td width="60%" align="center"><h1 style="font-size:16px;">Faktur Pajak</h1></td>';
        $html .= '<td width="40%"><table>'
                . '<tr><td width="40">Lembar 1</td><td width="10">:</td><td width="155">Untuk pembeli BKP atau penerima JKP sebagai bukti Pajak Masukan.</td></tr>'
                . '<tr><td>Lembar 2</td><td width="10">:</td><td>Untuk PKP yang menerbitkan Faktur Pajak sebagai bukti Pajak Keluaran.</td></tr></table></td>';
        $html .='</tr>';
        $html .='</table>';

        $html .='<table class="tables tableborder">';
        $html .='<tr>'
                . '<td class="bottom">'
                . '<table><tr><td  width="150">Kode dan Nomor Seri Faktur Pajak</td><td class="td-ro">:</td><td><b>' . $inv_no . '</b></td></tr>'
                . '</table>'
                . '</td>'
                . '</tr>';
        $html .='<tr >'
                . '<td class="bottom">'
                . '<table>'
                . '<tr><td></td></tr>'
                . '<tr><td colspan="3">Pengusaha Kena Pajak</td></tr>'
                . '<tr><td width="150">Nama</td><td class="td-ro">:</td><td>' . $company->comp_name . '</td></tr>'
                . '<tr><td>Alamat</td><td class="td-ro">:</td><td>' . $company->comp_add1 . ' ' . $company->comp_add2 . ' ' . $company->comp_add3 . ' ,' . $company->comp_city . ' ' . $company->comp_zipc . '</td></tr>'
                . '<tr><td>NPWP</td><td class="td-ro">:</td><td>' . $company->comp_npwp . '</td></tr>'
                . '<tr><td></td></tr>'
                . '</table>'
                . '</td>'
                . '</tr>';
        $html .='<tr>'
                . '<td class="bottom">'
                . '<table>'
                . '<tr><td></td></tr>'
                . '<tr><td colspan="3">Pembeli Barang Kena Pajak / Penerima Jasa Kena Pajak</td></tr>'
                . '<tr><td width="150">Nama</td><td class="td-ro">:</td><td>' . $name . '</td></tr>'
                . '<tr><td>Alamat</td><td class="td-ro">:</td><td>' . $addr . '</td></tr>'
                . '<tr><td>NPWP</td><td class="td-ro">:</td><td>' . $npwp . '</td></tr>'
                . '<tr><td></td></tr>'
                . '</table>'
                . '</td>'
                . '</tr>';
        $html .='<tr><td><br /></td></tr>';

        $html .='<tr><td>';
        $html .='<table style="margin-left:-3px !important;border:none;" class="tables tableborder">';
        $html .='<tr>'
                . '<td width="30"  class="bottom right-border top-border">No. Urut</td>'
                . '<td width="60%"  class="bottom right-border top-border">Nama Barang Kena Pajak / Jasa Kena Pajak</td>'
                . '<td  class="bottom top-border" align="right">Harga Jual/Penggantian/Uang Muka/Termijn (Rp.)</td></tr>';
        $html .='<tr>'
                . '<td class="bottom right-border" valign="top">1.</td>'
                . '<td class="bottom right-border" valign="top" style="padding:10px;">'
                . '<table >'
                . '<tr><td colspan="3">' . $read->veh_brand . ' ' . $read->veh_model . ' ' . $read->veh_transm . ' ' . $read->veh_year . '</td></tr>'
                . '<tr><td>No. Rangka</td><td class="td-ro">:</td><td>' . $read->chassis . '</td></tr>'
                . '<tr><td>No. Mesin</td><td class="td-ro">:</td><td>' . $read->engine . '</td></tr>'
                . '<tr><td>Warna</td><td class="td-ro">:</td><td>' . $read->color_name . '</td></tr>'
                . '<tr><td>No. Faktur Jual</td><td class="td-ro">:</td><td><b>' . $read->sal_inv_no . '</b></td></tr>'
                . '<tr><td>No. Kwitansi</td><td class="td-ro">:</td><td><b>' . $read->kwit_no . '</b></td></tr>'
                . '</table>'
                . '</td>'
                . '<td class="bottom" valign="top"  align="right">' . number_format($read->veh_bt) . '</td></tr>';

        $html .='<tr><td class="bottom right-border" colspan="2">Harga Jual</td><td class="bottom" align="right">' . number_format($read->veh_bt) . '</td></tr>';
        $html .='<tr><td class="bottom right-border" colspan="2">Dikurangi Potongan Harga</td><td class="bottom" align="right"></td></tr>';
        $html .='<tr><td class="bottom right-border" colspan="2">Dikurangi Uang  Muka yang telah diterima</td><td class="bottom" align="right"></td></tr>';
        $html .='<tr><td class="bottom right-border" colspan="2">Dasar Pengenaan Pajak</td><td class="bottom" align="right">' . number_format($read->veh_bt) . '</td></tr>';
        $html .='<tr><td class="bottom right-border" colspan="2">PPN = 10% x Dasar Pengenaan Pajak</td><td class="bottom" align="right">' . number_format($read->veh_vat) . '</td></tr>';

        $html .='</table>';
        $html .='</td></tr>';


        $html .='<tr><td><br /></td></tr>';


        $html .='<tr><td>';
        $html .='<table>';

        $html .='<tr>'
                . '<td valign="top" style="padding:10px;">'
                . '<p>Pajak Penjualan Atas Barang Mewah</p>'
                . '<table class="tables tableborder">'
                . '<tr><td class="right-border bottom">TARIF</td><td  class="right-border bottom">DPP</td><td class="bottom">PPn. BM</td></tr></thead>'
                . '<tr><td class="right-border ">..........%</td><td class="right-border">Rp. .........</td><td>Rp. .........</td></tr>'
                . '<tr><td class="right-border ">..........%</td><td class="right-border ">Rp. .........</td><td>Rp. .........</td></tr>'
                . '<tr><td class="right-border ">..........%</td><td class="right-border ">Rp. .........</td><td>Rp. .........</td></tr>'
                . '<tr><td class="right-border ">..........%</td><td class="right-border ">Rp. .........</td><td>Rp. .........</td></tr>'
                . '<tr><td colspan="2" class="top-border right-border" align="right">Jumlah</td><td class="top-border">Rp. .........</td></tr>'
                . '</table>'
                . '<p>*) Coret yang tidak perlu</p>'
                . '</td>';

        $html .='<td  valign="top"  style="padding:10px;">'
                . '<table class="tables">'
                . '<tr><td  align="right" >' . $company->comp_city . ',</td><td width="150">' . date("j F Y", strtotime($data['invoicedate'])) . '</td></tr>'
                . '<tr><td></td><td></td></tr>'
                . '<tr><td></td><td></td></tr>'
                . '<tr><td></td><td></td></tr>';

        if ($data['signature'] !== '') {
            $html .='<tr><td align="center" colspan="2">Nama: ' . $data['signature'] . '</td></tr>';
        }
        if ($data['jabatan'] !== '') {
            $html .='<tr><td align="center"  colspan="2">Jabatan: ' . $data['jabatan'] . '</td></tr>';
        }


        $html .= '</table>'
                . '</td></tr>';
        $html .='</table>';

        $html .='</td></tr>';
        $html .='</table>';
        $html .= $this->set_form('VFP');

        unset($fp['data_by']);
        unset($fp['inv_no']);
        $dataUpdate = $fp;

        if ($data['action'] == 'print') {
            $dataUpdate['fp_no'] = $inv_no;
            $dataUpdate['fp_date'] = $data['invoicedate'];

            if ($read->fp_no == '') {
                $fp_seq = $data['fp_seq'];
                $this->all_m->updateData('fp_seq', 'id', $fp_seq['id'], array('fp_no' => $fp_no));
            }
        }


        $data_cust['cust_code'] = $fp['cust_code'];
        $data_cust['cust_name'] = $fp['cust_name'];

        $data_cust['tx_npwp'] = $fp['cust_npwp'];
        $data_cust['tx_nppkp'] = $fp['cust_nppkp'];



        $this->all_m->updateData($dbs.'.veh_slh', 'id', $read->id, $dataUpdate);

        $veh_cust = $this->all_m->getId('veh_cust', 'cust_code', $fp['cust_code']);
        
        if ($veh_cust->postaddr == 1) {
            $data_cust['oaddr'] = $fp['cust_addr'];
            $data_cust['oarea'] = $fp['cust_area'];
            $data_cust['ocity'] = $fp['cust_city'];
            $data_cust['ozipcode'] = $fp['cust_zipc'];
        }
        if ($veh_cust->postaddr == 2) {
            $data_cust['haddr'] = $fp['cust_addr'];
            $data_cust['harea'] = $fp['cust_area'];
            $data_cust['hcity'] = $fp['cust_city'];
            $data_cust['hzipcode'] = $fp['cust_zipc'];
        }
        $this->all_m->updateData('veh_cust', 'id', $veh_cust->id, $data_cust);

        $output = array(
            'html' => $html,
            'number' => $inv_no
        );

        return $output;
    }

    function readHtml($data) {
        $year = $data['year'];
        $mounth = $data['mounth'];
        
        $dbs = $this->getDataHistory($year, $mounth);
        
        $company = $this->all_m->query_single("select * from ssystem limit 1");
        $read = $this->all_m->getId($dbs.'.'.$data['tbl'], 'id', $data['id']);

        $inv_code = $data['inv_code'];
        $inv_type = $data['inv_type'];

        if ($data['inv_code']) {
            $number = $read->$inv_code;
        }

        $html = '';
        switch ($data['tbl']) {
            case 'veh_spk':
                $number = $read->so_no;
                $spk = $this->all_m->getId($dbs.'.veh_spk', 'so_no', $read->so_no);
                $slh = $this->all_m->getId($dbs.'.veh_slh', 'sal_inv_no', $read->sal_inv_no);
                $dpch = $this->all_m->getId($dbs.'.veh_dpch', 'sal_inv_no', $read->sal_inv_no);

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

                $html .= '<p style="text-align:center;font-weight:bold;">' . $company->comp_name . '</p>';
                $html .= '<p style="text-align:center;font-weight:bold;">Status SPK Kendaraan</p>';
                $html .='<table class="tables">';
                $html .='<tr>';
                $html .='<td>'
                        . '<table class="tables">';



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
                $html .= '<tr><td>Leasing</td><td width="15">:</td><td>' . $spk->lease_code . ' - ' . $spk->lease_name . '</td></tr>';
                $html .= '<tr><td>Kredit Via/Refrensi</td><td width="15">:</td><td>' . $spk->crd_via . '</td></tr>';
                $html .= '<tr><td>No. Kontrak</td><td width="15">:</td><td>' . $slh->crd_cntrno . ' - ' . $crd_cntrdt . '</td></tr>';
                $html .= '<tr><td>Asuransi</td><td width="15">:</td><td>MASIH BELUM DIISI FIELD</td></tr>';
                $html .= '<tr><td>Refund/Komisi</td><td width="15">:</td><td>MASIH BELUM DIISI FIELD</td></tr>';
                $html .= '<tr><td>Subsidi/Discount</td><td width="15">:</td><td>MASIH BELUM DIISI FIELD</td></tr>';
                $html .= '<tr><td>No. / Tgl. Inv. ATPM</td><td width="15">:</td><td>' . $read->veh_inv_no . ' - ' . $veh_inv_dt . '</td></tr>';


                $html .= '</table>'
                        . '</td>';


                $totaloptional = intval($slh->veh_misc) + intval($slh->srv_at) + intval($slh->part_at) + intval($slh->inv_stamp);
                $html .='<td>'
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
                $html .='<tr><td colspan="3"></td></tr>';
                $html .='<tr><td colspan="3"></td></tr>';
                $html .='<tr><td colspan="3"></td></tr>';
                $html .='<tr><td colspan="3"></td></tr>';
                $html .='<tr><td colspan="3"></td></tr>';
                $html .='<tr><td colspan="3"></td></tr>';
                $html .='<tr><td colspan="3"></td></tr>';
                $html .='<tr><td colspan="3"></td></tr>';
                $html .='<tr><td colspan="3"></td></tr>';
                $html .='<tr><td colspan="3"></td></tr>';
                $html .= '<tr><td>Sisa Piutang</td><td width="15">:</td><td align="right">' . number_format($dpch->pd_end) . '</td><td></td></tr>';
                $html .='</table></td>';
                $html .='</tr>';
                $html .='</table>';

                $html .='<br /><br />';
                $html .='<table class="tables">';
                $html .='<tr><td><b>History Kwitansi & Faktur:</b></td></tr>';
                $html .='</table>';

                $veh_dpcd = $this->all_m->getWhere($dbs.'.veh_dpcd', array('so_no' => $read->so_no));

                $html .='<table class="tables">';
                $html .='<tr>'
                        . '<td width="30"><b>No.</b></td>'
                        . '<td><b>No. Faktur<br />No. Kwitansi</b></td>'
                        . '<td><b>Tgl. Faktur<br />Tgl. Kwitansi</b></td>'
                        . '<td><b>Jenis Pembayaran</b></td>'
                        . '<td><b>Tanggal Cek/Giro</b></td>'
                        . '<td><b>Tanggal J Tempo</b></td>'
                        . '<td><b>Keterangan</b></td>'
                        . '<td align="right"><b>Nilai Kwitansi</b></td></tr>';

                $html .='<tr><td colspan="8"><hr /></td></tr>';

                $no = 1;
                $totalval = 0;

                foreach ($veh_dpcd as $dpcd):
                    $totalval +=$dpcd->pay_val;
                    $html .='<tr>'
                            . '<td>' . $no . '.</td>'
                            . '<td>' . $dpcd->sal_inv_no . '</td>'
                            . '<td>' . $this->dateView($dpcd->sal_date) . '</td>'
                            . '<td>' . $dpcd->pay_type . '</td>'
                            . '<td>' . $this->dateView($dpcd->check_date) . '</td>'
                            . '<td></td>'
                            . '<td>' . $dpcd->pay_desc . '</td>'
                            . '<td align="right">' . number_format($dpcd->pay_val) . '</td></tr>';

                    $no++;
                endforeach;

                $html .='<tr><td colspan="6"></td><td><b>Grand Total :</b></td><td align="right;">' . number_format($totalval) . '</td></tr>';
                $html .='</table>';
                break;

            case 'acc_slh':
                $date = $this->dateView($data['invoicedate']);

                $number = $this->all_m->inv_seq('4', $data['inv_code']);

                if ($data['action'] !== 'screen') {

                    if ($data['inv_code'] == 'ADO') {
                        if ($read->sj_no !== '') {
                            $number = $read->sj_no;
                        }
                    }
                    if ($data['inv_code'] == 'AKW') {
                        if ($read->kwit_no !== '') {
                            $number = $read->kwit_no;
                        }
                    }
                }

                $acc_sld = $this->all_m->getWhere($dbs.'.acc_sld', array('sal_inv_no' => $read->sal_inv_no));

                if ($data['inv_code'] == 'ADO') {
                    $html = '';
                    $html .='<table class="tables">';
                    $html .='<tr>';
                    $html .='<td style="width:65%"></td>';
                    $html .='<td><table >';
                    $html .='<tr><td colspan="3" style="font-size:14px;">' . $company->comp_name . '</td></tr>';
                    $html .='<tr><td colspan="3">' . $company->comp_add1 . '</td></tr>';
                    $html .='<tr><td colspan="3">' . $company->comp_add2 . '</td></tr>';
                    $html .='<tr><td width="40"><b>Phone</b></td><td width="10">:</td><td>' . $company->comp_phone . '</td></tr>';
                    $html .='<tr><td width="40"><b>Fax </b></td><td width="10">:</td><td>' . $company->comp_fax . '</td></tr>';
                    $html .='</table></td>';
                    $html .='</tr>';
                    $html .='<tr><td><br /></td></tr>';
                    $html .='</table>';

                    $html .='<table class="tables">';
                    $html .='<tr>';
                    $html .='<td height="60" width="50%">'
                            . '<table class="tables" style="border:1px solid black;border-radius:8px;height:50px !important;">'
                            . '<tr><td><b>Pelanggan/Customer</b></td></tr>'
                            . '<tr><td>' . $read->cust_name . '</td></tr>'
                            . '<tr><td><br /></td></tr>'
                            . '<tr><td><br /></td></tr>'
                            . '</table>'
                            . '</td>';
                    $html .='<td height="60" width="50%">'
                            . '<table class="tables" border="1">'
                             . '<tr><td align="center"><h3>Surat Jalan</h3></td></tr>'
                             . '<tr><td><table>'
                             . '<tr><td width="110">DO (SJ) No.</td><td width="12">:</td><td width="150">' . $number . '</td></tr>'
                            . '<tr><td width="110">DO (SJ) Date</td><td width="12">:</td><td>' . $date . '</td></tr>'
                            . '<tr><td width="110">No. Faktur / Inv No.</td><td width="12">:</td><td>' . $read->sal_inv_no . '</td></tr>'
                             . '<tr><td></td></tr>'
                             . '</table></td></tr>'
                            . '</table>'
                            . '</td>'; 
                    
                    $html .='</tr>';
                    $html .='<tr><td><br /></td></tr>';

                    $html .='<tr><td colspan="2">';
                    $html .='<table class="tables" border="1">';
                    $html .='<tr><th width="30" align="center">No.<br />Line</th><th align="center" width="230">Nama Barang<br />Description / Specification</th><th width="50"  align="center">Satuan<br />U/M</th><th width="70" align="center">Kuantitas<br />Quantity</th><th width="150">Keterangan<br />Note</th></tr>';



                    $no = 1;
                    foreach ($acc_sld as $sld) {
                        $html .='<tr><td align="right">' . $no . '</td><td>' . $sld->part_code . ' - ' . $sld->part_name . '</td><td>' . $sld->unit . '</td><td align="right">' . number_format($sld->qty) . '</td><td></td></tr>';
                        $no++;
                    }

                    $html .='</table>';
                    $html .='</td></tr>';

                    $html .='</table>';
                }
                
                if ($data['inv_code'] == 'AKW') {
                        $html = '';
                    $html .='<table class="tables">';
                    $html .='<tr>';
                    $html .='<td><table >';
                    $html .='<tr><td colspan="3" style="font-size:14px;">' . $company->comp_name . '</td></tr>';
                    $html .='<tr><td colspan="3">' . $company->comp_add1 . '</td></tr>';
                    $html .='<tr><td colspan="3">' . $company->comp_add2 . '</td></tr>';
                    $html .='<tr><td width="40"><b>Phone</b></td><td width="10">:</td><td>' . $company->comp_phone . '</td></tr>';
                    $html .='<tr><td width="40"><b>Fax </b></td><td width="10">:</td><td>' . $company->comp_fax . '</td></tr>';
                    $html .='</table></td>';
                    $html .='</tr>';
                    $html .='<tr><td><br /></td></tr>';
                    $html .='</table>';
                    
                    $html .='<table class="tables">';
                    $html .='<tr>';
                     $html .='<td height="60" width="50%">'
                            . '<table class="tables" border="1">'
                             . '<tr><td align="center"><h3>Kwitansi / Receipt</h3></td></tr>'
                             . '<tr><td><table>'
                             . '<tr><td width="110">No Kwit / Receipt No.</td><td width="12">:</td><td width="150">' . $number . '</td></tr>'
                            . '<tr><td width="110">Tgl Kwit / Receipt Date</td><td width="12">:</td><td>' . $date . '</td></tr>'
                            . '<tr><td width="110">No. Faktur / Inv No.</td><td width="12">:</td><td>' . $read->sal_inv_no . '</td></tr>'
                             . '<tr><td></td></tr>'
                             . '</table></td></tr>'
                            . '</table>'
                            . '</td>';                   
                    $html .='<td height="60" width="50%">'
                            . '<table class="tables" style="border:1px solid black;border-radius:8px;height:50px !important;">'
                            . '<tr><td><b>Pelanggan/Customer</b></td></tr>'
                            . '<tr><td>' . $read->cust_name . '</td></tr>'
                            . '<tr><td><br /></td></tr>'
                            . '<tr><td><br /></td></tr>'
                            . '</table>'
                            . '</td>';
                    $html .='</tr>';     
                               $html .='<tr><td><br /></td></tr>';

                    $html .='<tr><td colspan="2">';
                    $html .='<table class="tables" border="1">';
                    //$html .='<tr><th width="30" align="center">No.<br />Line</th><th align="center" width="230">Nama Barang<br />Description / Specification</th><th width="150">Keterangan<br />Note</th></tr>';
                    $html .='<tr>'
                            . '<th width="30" align="center">No.<br />Line</th>'
                            . '<th align="center" width="167">Nama Barang<br />Description / Specification</th>'
                            . '<th width="50"  align="center">Satuan<br />U/M</th>'
                            . '<th width="60" align="center">Kuantitas<br />Quantity</th>'  
                            . '<th width="75" align="right">Harga Satuan<br />Unit Price</th>'
                            . '<th width="75" align="right">Diskon<br />Discount</th>'
                            . '<th width="75" align="right">Jumlah<br />Amount</th></tr>';
                    $no = 1;
                    foreach ($acc_sld as $sld) {
                        $html .='<tr>'
                                . '<td align="right">' . $no . '</td>'
                                . '<td>' . $sld->part_code . ' - ' . $sld->part_name . '</td>'
                                . '<td>' . $sld->unit . '</td>'
                                . '<td align="right">' . number_format($sld->qty) . '</td>'
                                . '<td align="right">' . number_format($sld->price_bd) . '</td>'
                                . '<td align="right">' . number_format($sld->disc_val) . '</td>'
                                . '<td align="right">' . number_format($sld->price_ad) . '</td>'
                                . '</tr>';
                        $no++;
                    }

                    $html .='</table>';
                    $html .='</td></tr>';
                    
                    $html .='<tr><td colspan="2">';
                    $html .='<table class="tables">';
                    $html .='<tr><td width="457" align="right">Sub Total:</td><td width="75" align="right" class="borders">' . number_format($read->tot_price) . '</td></tr>';
                    $html .='<tr><td align="right">Diskon / Discount:</td><td align="right" class="borders">' . number_format($read->inv_disc) . '</td></tr>';
                    $html .='<tr><td align="right">PPN / Vat:</td><td align="right" class="borders">' . number_format($read->inv_vat) . '</td></tr>';
                    $html .='<tr><td align="right">Biaya Lain / Others Cost:</td><td align="right" class="borders">' . number_format($read->inv_stamp) . '</td></tr>';
                    $html .='<tr><td align="right"><b>Jumlah Total / Total Amount:</b></td><td align="right" class="borders"><b>' . number_format($read->inv_total) . '</b></td></tr>';
                    $html .='</table>';
                    $html .='</td></tr>';
                    
                    $html .='</table>';
                    $html .='<style>.borders{border:1px solid black;"}</style>';
                    
                }
                
                $html .= $this->set_form($data['inv_code']);

                if ($data['action'] !== 'screen') {
                    if ($read->sj_no == '') {
                        $inv_seq = $this->all_m->getOne('inv_seq', array('inv_type' => 'ADO'));
                        $this->all_m->updateData('inv_seq', 'id', $inv_seq->id, array('inv_no' => $inv_seq->inv_no + 1));
                        $this->all_m->updateData($dbs.'.'.$data['tbl'], 'id', $read->id, array('sj_no' => $number, 'sj_date' => $date));
                    }
                    
                    if ($read->kwit_no == '') {
                        $inv_seq = $this->all_m->getOne('inv_seq', array('inv_type' => 'AKW'));
                        $this->all_m->updateData('inv_seq', 'id', $inv_seq->id, array('inv_no' => $inv_seq->inv_no + 1));
                        $this->all_m->updateData($dbs.'.'.$data['tbl'], 'id', $read->id, array('kwit_no' => $number, 'kwit_date' => $date));
                    }
                }
                break;
        }


        $output = array(
            'html' => $html,
            'number' => $number
        );

        return $output;
    }

}
