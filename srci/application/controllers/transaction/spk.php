<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
//error_reporting(E_ALL ^ E_NOTICE);
//error_reporting(0);
date_default_timezone_set("Asia/Jakarta");

class Spk extends Application {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('crud_mdl', 'get_data_mdl'));
    }

    function check_spkreg() {
        $tbl = encrypt_decrypt('decrypt', $this->input->post('table'));
        $id = $this->input->post('id');

        $spkreg = $this->all_m->getId($tbl, 'so_no', $id);

        if ($spkreg->use_date !== '0000-00-00 00:00:00') {
            $res = array('status' => false);
        } else {
            $res = array('status' => true);
        }

        $this->json($res);
    }

    function check_close_spk() {

        $user = $this->session->userdata('username');
        $tbl = encrypt_decrypt('decrypt', $this->input->post('table'));
        $id = $this->input->post('id');
        $veh_spk = $this->all_m->getId($tbl, 'id', $id);

        if ($veh_spk->cls_date == null || $veh_spk->cls_date == '0000-00-00') {
            $res = array('status' => true);
        } else {
            $res = array('status' => false);
        }
        $this->json($res);
    }

    function close_spk() {
        $user = $this->uri->segment(4);

        $tbl = $this->input->post('table');
        $id = $this->input->post('id');
        $veh_spk = $this->all_m->getId($tbl, 'id', $id);

        $periode = $this->checkPeriode();

        if ($periode == 'false') {
            $msg = $this->msgNotClose();
        }

        if ($msg['success'] !== false) {
            if ($veh_spk->cls_date == null || $veh_spk->cls_date == '0000-00-00') {
                $close = array(
                    'cls_by' => $user,
                    'cls_date' => date('Y-m-d h:i:s'),
                    'cls_cnt' => $veh_spk->cls_cnt + 1,
                    'pick_date' => '0000-00-00',
                    'match_date' => '0000-00-00'
                );

                $this->all_m->updateData($tbl, 'id', $id, $close);

                $veh_spk = (array) $this->all_m->getId($tbl, 'id', $id);
                unset($veh_spk['id']);
                unset($veh_spk['so_date']);
                unset($veh_spk['soseq_date']);

                $veh_spk['so_date'] = date('Y-m-d');
                $veh_spk['soseq_date'] = date('Y-m-d');

                $veh_spkd = $this->all_m->getWhere('veh_spkd', array('so_no' => $veh_spk['so_no']));

                foreach ($veh_spkd as $spkd) {
                    $vehspkod = array(
                        'so_no' => $spkd->so_no,
                        'so_date' => $spkd->so_date,
                        'wk_code' => $spkd->wk_code,
                        'wk_desc' => $spkd->wk_desc,
                        'price_bd' => $spkd->price_bd,
                        'disc_pct' => $spkd->disc_pct,
                        'disc_val' => $spkd->disc_val,
                        'price_ad' => $spkd->price_ad,
                        'srep_code1' => $spkd->srep_code1,
                        'srep_name1' => $spkd->srep_name1,
                        'add_by' => $spkd->add_by,
                        'add_date' => $spkd->add_date,
                        'qtywo' => 1,
                        'beg_qtywo' => 1,
                        'ord_qtywo' => 0,
                        'end_qtywo' => 1
                    );

                    $this->all_m->insertData('vehspkod', $vehspkod);
                }


                $this->all_m->insertData('vehspko', $veh_spk);

                $msg = array('success' => true, 'message' => 'SPK has been closed successfully');
            } else {
                $msg = array('success' => false);
            }
        }
        $this->json($msg);
    }

    function unclose_spk() {

        $user = $this->session->userdata('username');
        $tbl = $this->input->post('table');
        $id = $this->input->post('id');
        $veh_spk = $this->all_m->getId($tbl, 'id', $id);

        $periode = $this->checkPeriode();

        if ($periode == 'false') {
            $msg = $this->msgNotUnClose();
        }

        if ($veh_spk->dp_inv_no !== '' || $veh_spk->dp_date !== '0000-00-00') {
            $msg = array('success' => false, 'message' => 'Sorry, DP for this SPK existed in ' . $veh_spk->dp_inv_no);
        }
        if ($veh_spk->cls_date == null || $veh_spk->cls_date == '0000-00-00') {
            $msg = array('success' => false, 'message' => 'Please close this SPK first');
        }
        if ($veh_spk->match_date !== '0000-00-00') {
            $msg = array('success' => false, 'message' => 'This SPK cannot be unclosed. It has been matched with ' . $veh_spk->pur_inv_no);
        }

        if ($msg['success'] !== false) {
            $close = array(
                'cls_date' => '0000-00-00'
            );

            $vehspkod = $this->all_m->getWhere('vehspkod', array('so_no' => $veh_spk->so_no));

            foreach ($vehspkod as $spkod) {
                $this->all_m->deleteData('vehspkod', 'id', $spkod->id);
            }

            $this->all_m->updateData($tbl, 'id', $id, $close);
            $this->all_m->deleteData('vehspko', 'so_no', $veh_spk->so_no);

            $msg = array('success' => true);
        } else {
            $msg = $msg;
        }

        $this->json($msg);
    }

    function save() {

        $id = $this->input->post('id');
        $table = $this->input->post('table');
        $data = $this->input->post();

        unset($data['table']);
        unset($data['id']);
        unset($data['unit_price2']);

        $vehsrep = $this->all_m->getId('veh_srep', 'srep_code', $data['srep_code']);
        $data['pred_stk_d'] = $this->dateFormat($data['pred_stk_d']);

        $data['so_date'] = $this->dateFormat($data['so_date']);
        $data['soseq_date'] = $this->dateFormat($data['soseq_date']);
        $data['dp_date'] = $this->dateFormat($data['dp_date']);
        $data['match_date'] = $this->dateFormat($data['match_date']);
        //$data['crd_irate']= $this->dateFormat($data['crd_irate']);
        $data['pay_date'] = $this->dateFormat($data['pay_date']);
        $data['check_date'] = $this->dateFormat($data['check_date']);
        $data['due_date'] = $this->dateFormat($data['due_date']);
        $data['srep_sex'] = $vehsrep->sex;

        $distrub = true;

        $spkreg = $this->all_m->getId('veh_spkreg', 'so_no', $data['so_no']);

        if ($spkreg->srep_code == '' || $spkreg->srep_name == '') {
            $distrub = false;
        } else {
            $distrub = true;
        }

        $stat = true;

        if ($data['pay_type'] == '') {
            $msg = array('success' => false, 'message' => 'Please input Payment Type');
            $stat = false;
        }
        if ($data['salpaytype'] == '') {
            $msg = array('success' => false, 'message' => 'Please input Transaction Method (Cash or Credit');
            $stat = false;
        }

        if ($data['prc_type'] == '') {
            $msg = array('success' => false, 'message' => 'Please input Vehicle Price Type  (ON &#47; OFF the road)');
            $stat = false;
        }

        if ($data['color_type'] == '') {
            $msg = array('success' => false, 'message' => 'Please input Color Code& Name');
            $stat = false;
        }
        if ($data['veh_type'] == '') {
            $msg = array('success' => false, 'message' => 'Please input Vehicle Code & Name');
            $stat = false;
        }
        if ($data['cust_code'] == '') {
            $msg = array('success' => false, 'message' => 'Please input Customer Code & Name');
            $stat = false;
        }
        if ($distrub == false) {
            $msg = array('success' => false, 'message' => 'Sorry, SPK No. has been used or has been Undistributed');
            $stat = false;
        }

        if ($id == '') {
            if ($spkreg->use_date !== '0000-00-00 00:00:00') {
                $msg = array('success' => false, 'message' => 'Sorry, SPK No. has been used');
                $stat = false;
            }
        }

        if ($stat !== false) {

            if ($id !== '') {
                $check = $this->all_m->countlimit($table, array('id' => $id));
                if ($check > 0) {
                    $this->all_m->updateData($table, 'id', $id, $data);
                    $msg = array('success' => true, 'message' => 'Record updated ');
                    //Update Locked Coloum
                    $this->updateLocked($table, $id);
                } else {
                    $msg = array('success' => false, 'message' => 'Record updated failed, data not found', 'status' => 'update', 'update' => false);
                }
            } else {

                $this->all_m->insertData($table, $data);
                $this->all_m->updateData('veh_spkreg', 'so_no', $data['so_no'], array('use_date' => date('Y-m-d h:i:s')));
                $msg = array('success' => true, 'message' => 'Record saved');
            }
        } else {
            $msg = $msg;
        }

        $this->json($msg);
    }

    function save_spkd() {

        $user = $this->uri->segment(5);
        $so_no = $this->uri->segment(4);
        $wk_code = $this->input->post('wk_code');

        $table = $this->input->post('table2');

        if ($wk_code !== '') {
            $check = $this->all_m->countlimit($table, array('so_no' => $so_no, 'wk_code' => $wk_code));

            if ($check > 0) {

                $msg = array('success' => false, 'message' => 'Sorry, data cannot be saved because it has been used in this invoice');
            } else {
                $spk = $this->all_m->getId('veh_spk', 'so_no', $so_no);

                $data['so_date'] = $spk->so_date;
                $data['so_no'] = $so_no;
                $data['wk_code'] = $wk_code;
                $data['wk_desc'] = $this->input->post('wk_desc2');

                $sal_price = $this->input->post('sal_price2');
                $disc_pct = $this->input->post('disc_pct2');
                $disc_val = $this->input->post('disc_val2');
                $price_ad = $sal_price - $disc_val;


                $data['price_bd'] = $sal_price;
                $data['disc_pct'] = $disc_pct;
                $data['disc_val'] = $disc_val;
                $data['price_ad'] = $price_ad;
                $data['add_by'] = $user;
                $data['add_date'] = date('Y-m-d');
                //print_r($data);exit;
                $this->all_m->insertData($table, $data);

                $veh_spk = $this->all_m->getId('veh_spk', 'so_no', $so_no);

                $srv_price = $veh_spk->srv_price + $price_ad;
                $srv_disc = $veh_spk->srv_disc;
                $srv_bt = $srv_price - $srv_disc;
                //$srv_vat = $srv_bt / $this->ppn();
                $srv_vat = $this->vat($srv_bt);
                $srv_at = $srv_bt + $srv_vat;
                $srv_item = $veh_spk->srv_item + 1;

                $data_spk = array(
                    'srv_price' => $srv_price,
                    'srv_disc' => $srv_disc,
                    'srv_bt' => $srv_bt,
                    'srv_vat' => $srv_vat,
                    'srv_at' => $srv_at,
                    'srv_item' => $srv_item
                );

                $this->all_m->updateData('veh_spk', 'so_no', $so_no, $data_spk);
                $msg = array('success' => true, 'message' => 'Record saved');
            }
        } else {
            $msg = array('success' => false, 'message' => 'Please input Work Code');
        }

        $this->json($msg);
    }

    function htmlreadspk($data) {
        $year = $data['year'];
        $mounth = $data['mounth'];
        
        $dbs = $this->getDataHistory($year, $mounth);
                
        $tbl = $data['tbl'];
        $id = $data['id'];
        $user = $data['user'];
        $company = $this->all_m->query_single("select * from ssystem limit 1");
        $veh_spk = $this->all_m->getId($dbs.'.'.$tbl, 'id', $id);
        $row = (array) $veh_spk;
        $html = '';

        $pelunasan = intval($row['unit_price']) - intval($row['pay_val']);
        $html .='<table><tr><td width="50%"></td><td width="50%" align="right"><table class="tables">';
        $html .='<tr><td colspan="3" style="font-size:14px;">' . $company->comp_name . '</td></tr>';
        $html .='<tr><td colspan="3">' . $company->comp_add1 . '</td></tr>';
        $html .='<tr><td colspan="3">' . $company->comp_add2 . '</td></tr>';
        $html .='<tr><td colspan="3"><b>Phone : </b>' . $company->comp_phone . '</td></tr>';
        $html .='<tr><td colspan="3"><b>Fax : </b>' . $company->comp_fax . '</td></tr>';
        $html .='</table></td></tr></table>';

        $html .= '<h3>Surat Pesanan Kendaraan</h3>';
        $html .= '<table  class="tables">';
        $html .= '<tr>';
        $html .= '<td width="25%">';
        $html .= '<table class="tables"  border="1">
                        <tr><td height="32"><b>No. Surat Pesanan : </b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $row['so_no'] . '</td></tr>
                        <tr><td height="32"><b>Tgl. Surat Pesanan : </b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $this->dateView($row['so_date']) . '</td></tr>
                        <tr><td height="32"><b>No. Surat Pemesanan/Ref :</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>
                        <tr><td height="32"><b>Tanggal Penyerahan :</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>
                        <tr><td height="32"><b>Kode Wiraniaga :</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $row['srep_code'] . '</td></tr>
                 </table>
                 </td>';

        $html .= '<td width="75%">
                        <table class="tables" border="1">
                           <tr>
                             <td>
                                 <table class="tables">
                                    <tr><td width="100"><b>NAMA PEMESAN</b></td><td class="td-ro"><b>:</b></td><td>' . $row['cust_name'] . '</td></tr>
                                    <tr><td><b>ALAMAT</b></td><td class="td-ro"><b>:</b></td><td width="250" height="36">' . $row['cust_addr'] . '<br />' . $row['cust_city'] . '-' . $row['cust_cntry'] . '</td></tr>
                                    <tr><td><b>TELP./HP</b></td><td class="td-ro"><b>:</b></td><td>' . $row['cust_phone'] . '</td></tr>
                                    <tr><td><b>NPWP</b></td><td class="td-ro"><b>:</b></td><td>' . $row['cust_npwp'] . '</td></tr>
                                </table>
                             </td>
                           </tr>
                           <tr>
                             <td style="border-top:1px solid #000;">
                                <table class="tables">
                                    <tr><td width="100"><b>NAMA di STNK</b></td><td class="td-ro">:</td><td width="305">' . $row['cust_rname'] . '</td></tr>
                                    <tr><td><b>ALAMAT di STNK</b></td><td class="td-ro">:</td><td width="250" height="35">' . $row['cust_raddr'] . '<br />' . $row['cust_rcity'] . '-' . $row['cust_rcntr'] . '</td></tr>
                                    <tr><td><b>TELP./HP</b></td><td class="td-ro">:</td><td>' . $row['cust_rphon'] . '</td></tr>
                              
                                </table>
                             </td>
                           </tr>
                        </table>
                    </td>';
        $html .= '</tr>';

        $html .='<tr><td colspan="2">';

        $html .= '<table class="tables" style="border:1px solid #000 ; padding-left:2pt;">';
        $html .= '<tr>
                        <th border="1" colspan="3" class="center">Keterangan</th>
                        <th border="1" class="right">Qty</th>
                        <th border="1" class="right">Harga Satuan</th>
                        <th border="1" class="right">Diskon</th>
                        <th border="1" class="right">Harga</th>
                  </tr>';
        $html .= '<tr>
                        <td><b>Kendaraan</b></td>
                        <td width="8">:</td>
                        <td width="144.1">' . $row['veh_name'] . '</td>
                        <td rowspan="4" border="1" class="right">1 UNIT</td>
                        <td rowspan="4" border="1" class="right">' . rupiah($row['unit_price']) . '</td>
                        <td rowspan="4" border="1" class="right">' . rupiah($row['unit_disc']) . '</td>
                        <td rowspan="4" border="1" class="right">' . rupiah($row['tot_price']) . '</td>
                  </tr>';
        $html .= '<tr>
                            <td><b>Tipe</b></td>
                            <td width="8">:</td>
                            <td>' . $row['veh_type'] . '</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                  </tr>';
        $html .= '<tr>
                            <td><b>Model</b></td>
                             <td width="8">:</td>
                            <td>' . $row['veh_model'] . '</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><b>Warna</b></td>
                             <td width="8">:</td>
                            <td>' . $row['color_name'] . '</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="5"></td>
                            <td style="text-align: right !important;">Jumlah:</td>
                            <td border="1" style="text-align: right !important;"><b>' . rupiah($row['tot_price']) . '</b></td>
                        </tr>
                        <tr>
                            <td colspan="6"></td>                  
                            <td>*Harga ON the road</td>
                        </tr>';
        $html .= '</table>';
        $html .= '</td></tr>';

        $html .= '<tr>
                    <td colspan="2">
                      <table class="tables">
                         <tr><td><b>KETENTUAN:</b></td></tr>
                         <tr><td></td></tr>
                         <tr><td></td></tr>
                         <tr><td></td></tr>
                         <tr><td></td></tr>
                     </table>
                    </td>
                 </tr>';

        $html .= '<tr>';
        $html .= '<td width="75%" >';
        $html .= '<table class="tables"  style="border:1px solid black;">';
        $html .= '<tr><th colspan="9" border="1" class="center">SYARAT PEMBAYARAN</th></tr>';
        $html .= '<tr>
                        <td width="70" border="0" ><b>Cara Pembayaran</b></td>
                        <td class="td-ro">:</td>
                        <td style="width:100px !important;">' . $row['pay_type'] . '</td>
                        <td width="60"><b>No. Cek/Giro</b></td>
                        <td class="td-ro">:</td>
                        <td>' . $row['check_no'] . '</td>
                        <td>' . $this->dateView($row['check_date']) . '</td>
                        <td></td>
                       
                  </tr>';

        $html .= '<tr>
                        <td><b>Uang Muka</b></td>
                        <td class="td-ro">:</td>
                        <td>Rp. ' . rupiah($row['pay_val']) . '</td>
                        <td><b>Bayar Tgl</b></td>
                        <td class="td-ro">:</td>
                        <td>' . $this->dateView($row['pay_date']) . '</td>                  
                  </tr>';

        $html .= '<tr>
                        <td><b>Terbilang</b></td>
                        <td  class="td-ro">:</td>
                        <td># ' . terbilang($row['pay_val']) . ' rupiah #</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                 </tr>
                <tr><td colspan="7"></td></tr>';

        $html .= '<tr>
                                <td><b>No.Kwitansi</b></td>
                                <td class="td-ro">:</td>
                                <td></td>
                                <td><b>Tgl.</b></td>
                                <td class="td-ro">:</td>
                                <td></td>
                                <td></td>
                            </tr>';

        $html .= '<tr>
                        <td><b>Pelunasan</b></td>
                        <td class="td-ro">:</td>
                        <td>Rp. ' . rupiah($pelunasan) . '</td>
                        <td><b>J. Tempo Tgl </b></td>
                        <td class="td-ro">:</td>
                        <td>' . $this->dateView($row['due_date']) . '</td>
                        <td></td>
                </tr>';
        $html .= '<tr>
                        <td><b>Terbilang</b></td>
                        <td class="td-ro">:</td>
                        <td colspan="5"># ' . terbilang($pelunasan) . ' rupiah #</td>                               
                 </tr>
                 <tr><td colspan="7"></td></tr>';

        $html .= '<tr>
                        <td><b>Kredit Via</b></td>
                        <td class="td-ro">:</td>
                        <td>' . $row['crd_via'] . '</td>
                        <td><b>Lama Kredit</b></td>
                        <td class="td-ro">:</td>
                        <td>' . $row['crd_term'] . ' Bulan</td>
                        <td><b>Bunga</b></td>
                        <td class="td-ro">:</td>
                        <td>' . $row['crd_irate'] . ' %</td>
                </tr>';

        $html .= '<tr>
                        <td><b>Leasing</b></td>
                        <td class="td-ro">:</td>
                        <td>' . $row['lease_code'] . '-' . $row['lease_name'] . '</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                 </tr>';
        $html .= '<tr>
                        <td><b>Keterangan</b></td>
                        <td class="td-ro">:</td>
                        <td>' . $row['so_desc'] . '</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                 </tr>';


        $html .= '</table>';
        $html .= '</td>';

        $html .= '<td width="25%" >'
                . '<table style="border:1px solid black;" class="tables">'
                . '<tr><td height="43"><b>Dipesan Oleh :</b></td></tr>'
                . '<tr><td align="center" style="border-top:1px solid #000;border-bottom:2px solid #000;background:#f4f4f4;">Pemesan</td></tr>'
                . '<tr><td height="43"><b>Dibuat Oleh :</b></td></tr>'
                . '<tr><td align="center"  style="border-top:1px solid #000;border-bottom:2px solid #000;">' . $row['so_made_by'] . '</td></tr>'
                . '<tr><td height="43"><b>Disetujui Oleh :</b></td></tr>'
                . '<tr><td align="center" style="border-top:1px solid #000;">Kepala Cabang/Penyelia Penjualan<br />' . $row['so_appr_by'] . '</td></tr>'
                . '</table>';
        $html .= '</td>';

        $html .= '</tr>';

        $viewcnt = array(
            'user' => $user,
            'prn_cnt' => $row['prn_cnt'],
            'action' => $data['action']
        );

        $html .= $this->viewPrnCnt($viewcnt);

        $html .= '</table>';

        /*


          $html .= '<table class="tables">';
          $html .= '<tr>';
          $html .= '<td width="390">';
          $html .= '<table class="tables"  style="border:0.5px solid #000 "  >';
          $html .= '<tr><th colspan="7" border="1" class="center">SYARAT PEMBAYARAN</th></tr>';







          $html .= '</table>';
          $html .= '</td>';

          $html .= '</tr>';
          $html .= '<tr>
          <td>
          <table class="tables">
          <tr>
          <td>Dicetak Olehsdf : ' . $user . '</td>
          </tr>
          </table>
          </td>
          </tr>';
          $html .= '</table>';
         */
        $output = array(
            'html' => $html,
            'number' => $row['so_no']
        );

        return $output;
    }

    function outputpdf() {
        $action = $this->uri->segment(7);
        $tbl = encrypt_decrypt('decrypt', $this->uri->segment(4));
        $id = $this->uri->segment(5);

        $prn_cnt = 'prn_cnt';
        $c_array = array();

        $data['action'] = $action;
        $data['id'] = $id;
        $data['user'] = $this->uri->segment(6);
        $data['tbl'] = $tbl;

        $data['year'] = null;
        $data['mounth'] = null;

        if ($this->uri->segment(8)) {
            $data['mounth'] = $this->uri->segment(8);
        }
        if ($this->uri->segment(9)) {
            $data['year'] = $this->uri->segment(9);
        }

        $read = $this->htmlreadspk($data);
        $output = array(
            'html' => $read['html'],
            'filename' => 'Surat_Pesanan_Kendaraan_' . $read['number'],
            'title' => 'Surat Pesanan Kendaraan ' . $read['number']
        );

        if ($action !== 'screen') {
            $this->count_prnt($data, $c_array, $prn_cnt);
        }
        $html = $output['html'];
        $this->output_pdf($output['title'], $html, $output['filename'], $action);
        //exit;
    }

    function printNotSpkMatch() {
        /* $url = site_url() . 'builder/grid_spk/' . encrypt_decrypt('encrypt', 'veh_spk') . '/match/?grid=false';
          $curl = file_get_contents($url);
          $result = json_decode($curl); */
        $where = array('match_date' => '0000-00-00');
        $result = $this->all_m->getWhere('veh_spk', $where);

        $user = $this->uri->segment(4);
        $action = $this->uri->segment(5);
        $option = $this->uri->segment(6);
        $code = $this->uri->segment(7);

        $data = array(
            'user' => $user,
            'option' => $option,
            'code' => $code,
            'action' => $action
        );

        $read = $this->htmlNotSpkMatch($result, $data);

        if ($action == 'export') {
            $tbl = '<table border=1>';
            $tbl .= '<tr>'
                    . '<td><b>SPK No.</b></td>'
                    . '<td><b>Purchase No.</b></td>'
                    . '<td><b>Vehicle Code</b></td>'
                    . '<td><b>Vehicle Name</b></td>'
                    . '<td><b>Transm</b></td>'
                    . '<td><b>Color Code</b></td>'
                    . '<td><b>Color Name</b></td>'
                    . '<td><b>Color Type</b></td>'
                    . '<td><b>Vehilce Type</b></td>'
                    . '<td><b>Chassis</b></td>'
                    . '<td><b>Engine</b></td>'
                    . '<td><b>Model</b></td>'
                    . '<td><b>Year</b></td>'
                    . '<td><b>Brand</b></td>'
                    . '<td><b>Match Date</b></td>'
                    . '<td><b>SPK Date</b></td>'
                    . '<td><b>Customer</b></td>'
                    . '<td><b>Sales</b></td>'
                    . '</tr>';

            foreach ($result as $r) {
                $tbl .= '<tr>';
                $tbl .= '<td>' . $r->so_no . '</td>';
                $tbl .= '<td>' . $r->pur_inv_no . '</td>';
                $tbl .= '<td>' . $r->veh_code . '</td>';
                $tbl .= '<td>' . $r->veh_name . '</td>';
                $tbl .= '<td>' . $r->veh_transm . '</td>';
                $tbl .= '<td>' . $r->color_code . '</td>';
                $tbl .= '<td>' . $r->color_name . '</td>';
                $tbl .= '<td>' . $r->color_type . '</td>';
                $tbl .= '<td>' . $r->veh_type . '</td>';
                $tbl .= '<td>' . $r->chassis . '</td>';
                $tbl .= '<td>' . $r->engine . '</td>';
                $tbl .= '<td>' . $r->veh_model . '</td>';
                $tbl .= '<td>' . $r->veh_year . '</td>';
                $tbl .= '<td>' . $r->veh_brand . '</td>';
                $tbl .= '<td>' . $this->dateView($r->match_date) . '</td>';
                $tbl .= '<td>' . $this->dateView($r->so_date) . '</td>';
                //$tbl .= '<td>' . $r->soseq_date . '</td>';
                $tbl .= '<td>' . $r->cust_name . '</td>';
                $tbl .= '<td>' . $r->srep_name . '</td>';
                $tbl .='</tr>';
            }
            $tbl .= '</table>';

            header("Content-type: application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename=SPKNoMatched.xls");
            echo $tbl;
        } elseif ($action == 'screen') {
            $html = $read['html'];
            echo $html;
        } else {
            $html = $read['html'];
            $html .='<script>window.print();</script>';
            echo $html;
        }
    }

    function printSpkMatch() {
        $sql = "select * from veh_spk where 1=1 and pick_date='0000-00-00' and match_date>0000-00-00 AND Length(chassis)>0 AND Length(engine)>0";
        $result = $this->all_m->query_all($sql);

        $user = $this->uri->segment(4);
        $action = $this->uri->segment(5);
        $option = $this->uri->segment(6);
        $code = $this->uri->segment(7);

        $data = array(
            'user' => $user,
            'option' => $option,
            'code' => $code,
            'action' => $action
        );

        $read = $this->htmlSpkMatch($result, $data);

        if ($action == 'export') {
            $tbl = '<table border=1>';
            $tbl .= '<tr>';
            $tbl .='<td><b>SPK No.</b></td>';
            $tbl .='<td><b>Invoice No.</b></td>';
            $tbl .='<td><b>Vehicle Code</b></td>';
            $tbl .='<td><b>Vehicle Name</b></td>';
            $tbl .='<td><b>Transm</b></td>';
            $tbl .='<td><b>Color Code</b></td>';
            $tbl .='<td><b>Color Name</b></td>';
            $tbl .='<td><b>Color Type</b></td>';
            $tbl .='<td><b>Vehicle Type</b></td>';
            $tbl .='<td><b>Chassis</b></td>';
            $tbl .='<td><b>Engine</b></td>';
            $tbl .='<td><b>Model</b></td>';
            $tbl .='<td><b>Year</b></td>';
            $tbl .='<td><b>Brande</b></td>';
            $tbl .='<td><b>Match Date</b></td>';
            $tbl .='<td><b>SPK Date</b></td>';
            $tbl .='<td><b>Sort SPK Date</b></td>';
            $tbl .='<td><b>Customer</b></td>';
            $tbl .='<td><b>Sales</b></td>';
            $tbl .='<td><b>Warehouse</b></td>';
            $tbl .='<td><b>Location Code</b></td>';
            $tbl .= '</tr>';

            foreach ($result as $r) {
                $tbl .= '<tr>';
                $tbl .= '<td>' . $r->so_no . '</td>';
                $tbl .= '<td>' . $r->pur_inv_no . '</td>';
                $tbl .= '<td>' . $r->veh_code . '</td>';
                $tbl .= '<td>' . $r->veh_name . '</td>';
                $tbl .= '<td>' . $r->veh_transm . '</td>';
                $tbl .= '<td>' . $r->color_code . '</td>';
                $tbl .= '<td>' . $r->color_name . '</td>';
                $tbl .= '<td>' . $r->color_type . '</td>';
                $tbl .= '<td>' . $r->veh_type . '</td>';
                $tbl .= '<td>' . $r->chassis . '</td>';
                $tbl .= '<td>' . $r->engine . '</td>';
                $tbl .= '<td>' . $r->veh_model . '</td>';
                $tbl .= '<td>' . $r->veh_year . '</td>';
                $tbl .= '<td>' . $r->veh_brand . '</td>';
                $tbl .= '<td>' . $this->dateView($r->match_date) . '</td>';
                $tbl .= '<td>' . $this->dateView($r->so_date) . '</td>';
                $tbl .= '<td>' . $this->dateView($r->soseq_date) . '</td>';
                $tbl .= '<td>' . $r->cust_name . '</td>';
                $tbl .= '<td>' . $r->srep_name . '</td>';
                $tbl .= '<td>' . $r->wrhs_code . '</td>';
                $tbl .= '<td>' . $r->loc_code . '</td>';
                $tbl .= '</tr>';
            }
            $tbl .= '</table>';
            header("Content-type: application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename=SPKMatched.xls");
            echo $tbl;
        } elseif ($action == 'screen') {
            $html = $read['html'];
            echo $html;
        } else {
            $html = $read['html'];
            $html .='<script>window.print();</script>';
            echo $html;
        }
    }

    function printStock() {
        $sql = "select * from veh_stk where match_date=0000-00-00 and length(so_no)=0 ";
        $result = $this->all_m->query_all($sql);

        $user = $this->uri->segment(4);
        $action = $this->uri->segment(5);
        $option = $this->uri->segment(6);
        $code = $this->uri->segment(7);

        $data = array(
            'user' => $user,
            'option' => $option,
            'code' => $code,
            'action' => $action
        );

        $read = $this->htmlStknotMatch($result, $data);

        if ($action == 'export') {
            $tbl .= '<table border="1">';
            $tbl .='<tr>';
            $tbl .='<td><b>Invoice No. Faktur</b></td>';
            $tbl .='<td><b>SPK No.</b></td>';
            $tbl .='<td><b>Vehicle Code</b></td>';
            $tbl .='<td><b>Vehicle Name</b></td>';
            $tbl .='<td><b>Transm</b></td>';
            $tbl .='<td><b>Color Code</b></td>';
            $tbl .='<td><b>Color Name</b></td>';
            $tbl .='<td><b>Color Type</b></td>';
            $tbl .='<td><b>Vehicle Type</b></td>';
            $tbl .='<td><b>Chassis</b></td>';
            $tbl .='<td><b>Engine</b></td>';
            $tbl .='<td><b>Model</b></td>';
            $tbl .='<td><b>Year</b></td>';
            $tbl .='<td><b>Brand</b></td>';
            $tbl .='<td><b>Match Date</b></td>';
            $tbl .='<td><b>Stock Date</b></td>';
            $tbl .='<td><b>Purchase Date</b></td>';
            $tbl .='<td><b>Warehouse</b></td>';
            $tbl .='<td><b>Location Date</b></td>';
            $tbl .='</tr>';
            foreach ($result as $r) {
                $tbl .='<tr>';
                $tbl .= '<td>' . $r->pur_inv_no . '</td>';
                $tbl .= '<td>' . $r->so_no . '</td>';
                $tbl .= '<td>' . $r->veh_code . '</td>';
                $tbl .= '<td>' . $r->veh_name . '</td>';
                $tbl .= '<td>' . $r->veh_transm . '</td>';
                $tbl .= '<td>' . $r->color_code . '</td>';
                $tbl .= '<td>' . $r->color_name . '</td>';
                $tbl .= '<td>' . $r->color_type . '</td>';
                $tbl .= '<td>' . $r->veh_type . '</td>';
                $tbl .= '<td>' . $r->chassis . '</td>';
                $tbl .= '<td>' . $r->engine . '</td>';
                $tbl .= '<td>' . $r->veh_model . '</td>';
                $tbl .= '<td>' . $r->veh_year . '</td>';
                $tbl .= '<td>' . $r->veh_brand . '</td>';
                $tbl .= '<td>' . $this->dateView($r->match_date) . '</td>';
                $tbl .= '<td>' . $this->dateView($r->stk_date) . '</td>';
                $tbl .= '<td>' . $this->dateView($r->pur_date) . '</td>';
                $tbl .= '<td>' . $r->wrhs_code . '</td>';
                $tbl .= '<td>' . $r->loc_code . '</td>';
                $tbl .='</tr>';
            }

            $tbl .= '</table>';
            header("Content-type: application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename=Stock.xls");
            echo $tbl;
        } elseif ($action == 'screen') {
            $html = $read['html'];
            echo $html;
        } else {
            $html = $read['html'];
            $html .='<script>window.print();</script>';
            echo $html;
        }
    }

    function htmlStknotMatch($result, $data) {
        $html = '<div align="center">';
        $html .= "<style>"
                . "table{font-family : 'helvetica';font-size : 11px;border-collapse: collapse; border-spacing: 0;margin-bottom:15px;}"
                . "th, td {padding: 0.25em 0.75em;}"
                . "th{padding-bottom:10px;padding-top:10px;}"
                . "thead th {border-bottom: 1px solid #333;  }.th-match{font-weight:bold;}</style>";

        if ($data['option'] == '1') {
            $html .= '<table class="tables" id="tables">';
            $html .= '<tr><td valign="top"  colspan="7" align="center"><p class="center" style="margin-bottom:10px;font-size:12px ;font-weight:bold;">Vehicle Stock not yet matched with SPK<br />Sort By Vehicle Code ,Color Code, Stock Date </p></td></tr>';
            $html .= '<tr><td valign="top"  colspan="7"></td></tr>';
            $html .= '</table>';
            $html .= '<table>';
            $html .= '<thead style="border:2px solid black !important;">';
            $html .= '<tr><td valign="top"  width="30" class="center th-match bold">#</td><td valign="top"  class="th-match bold">Vehicle Code<br />Vehicle Name</td><td valign="top"   class="th-match bold">Vehicle Type</td><td valign="top"  class="th-match bold" >Model</td><td valign="top"  class="th-match bold">Color Code <br />Color Name</td><td valign="top"  class="th-match bold center" >Color Type</td><td valign="top"  class="th-match bold">Warehouse<br />Location</td><td valign="top"  class="th-match bold center">Transmission<br />Year</td><td valign="top"  class="th-match bold">Stock Date<br />Chassis</td></tr>';
            $html .= '</thead>';

            $html .= '<tr><td></td></th>';
            $no = 1;
            foreach ($result as $row):

                $html .= '<tr>';
                $html .= '<td valign="top"  class="center" width="30">' . $no . '.</td>';
                $html .= '<td valign="top" >' . $row->veh_code . '<br />' . $row->veh_name . '</td>';
                $html .= '<td valign="top" >' . $row->veh_type . '</td>';
                $html .= '<td valign="top" >' . $row->veh_model . '</td>';
                $html .= '<td valign="top" >' . $row->color_code . '<br />' . $row->color_name . '</td>';
                $html .= '<td valign="top"  class="center">' . $row->color_type . '</td>';
                $html .= '<td valign="top" >' . $row->wrhs_code . '<br />' . $row->loc_code . '</td>';
                $html .= '<td valign="top"  class="center">' . $row->veh_transm . '<br />' . $row->veh_year . '</td>';
                $html .= '<td valign="top" >' . $this->dateView($row->stk_date) . '<br />' . $row->chassis . '</td>';
                $html .= '</tr>';
                $no++;
            endforeach;

            $html .= '</table>';
        }
        if ($data['option'] == '2') {
            $html .= '<table class="tables" id="tables">';
            $html .= '<tr><td valign="top"  colspan="7" align="center"><p class="center" style="margin-bottom:10px;font-size:12px ;font-weight:bold;">Vehicle Stock not yet matched with SPK<br />Sort By Stock Date & Purchase invoice no. </p></td></tr>';
            $html .= '<tr><td valign="top"  colspan="7"></td></tr>';
            $html .= '</table>';
            $html .= '<table>';
            $html .= '<thead style="border:2px solid black !important;">';
            $html .= '<tr><td valign="top"  width="30" class="center th-match bold">#</td><td valign="top"  class="th-match bold">Stock Date</td><td valign="top"   class="th-match bold">Purchase Invoice No.<br />Chassis</td><td valign="top"  class="th-match bold" >Vehicle Name<br />Vehicle Code</td><td valign="top"  class="th-match bold">Type </td><td valign="top"  class="th-match bold center" >Model</td><td valign="top"  class="th-match bold center">Transmission<br />Year</td><td valign="top"  class="th-match bold">Color Name<br />Color Code</td></tr>';
            $html .= '</thead>';

            $html .= '<tr><td></td></th>';
            $no = 1;
            foreach ($result as $row):

                $html .= '<tr>';
                $html .= '<td valign="top"  class="center" width="30">' . $no . '.</td>';
                $html .= '<td valign="top" >' . $this->dateView($row->stk_date) . '</td>';
                $html .= '<td valign="top" ><b>' . $row->pur_inv_no . '</b><br />' . $row->chassis . '</td>';
                $html .= '<td valign="top" ><b>' . $row->veh_name . '</b><br />' . $row->veh_code . '</td>';
                $html .= '<td valign="top"  class="center">' . $row->veh_type . '</td>';
                $html .= '<td valign="top"  class="center">' . $row->veh_model . '</td>';
                $html .= '<td valign="top"  class="center">' . $row->veh_transm . '<br />' . $row->veh_year . '</td>';
                $html .= '<td valign="top" >' . $row->color_name . '<br />' . $row->color_code . '</td>';
                $html .= '</tr>';
                $no++;
            endforeach;
            $html .='</table>';
        }

        if ($data['option'] == '3') {
            $html .= '<table class="tables" id="tables">';
            $html .= '<tr><td valign="top"  colspan="7" align="center"><p class="center" style="margin-bottom:10px;font-size:12px ;font-weight:bold;">Vehicle Stock not yet matched with SPK<br />Sort By Purchase invoice no.</p></td></tr>';
            $html .= '<tr><td valign="top"  colspan="7"></td></tr>';
            $html .= '</table>';
            $html .= '<table>';
            $html .= '<thead style="border:2px solid black !important;">';
            $html .= '<tr><td valign="top"  width="30" class="center th-match bold">#</td><td valign="top"  class="th-match bold">Purchase Invoice No.<br />Stock Date</td><td valign="top"   class="th-match bold">Chassis</td><td valign="top"  class="th-match bold" >Vehicle Name<br />Vehicle Code</td><td valign="top"  class="th-match bold">Type </td><td valign="top"  class="th-match bold center" >Model</td><td valign="top"  class="th-match bold center">Transmission<br />Year</td><td valign="top"  class="th-match bold">Color Name<br />Color Code</td></tr>';
            $html .= '</thead>';

            $html .= '<tr><td></td></th>';
            $no = 1;
            foreach ($result as $row):

                $html .= '<tr>';
                $html .= '<td valign="top"  class="center" width="30">' . $no . '.</td>';
                $html .= '<td valign="top" ><b>' . $row->pur_inv_no . '</b><br />' . $this->dateView($row->stk_date) . '</td>';
                $html .= '<td valign="top" >' . $row->chassis . '</td>';
                $html .= '<td valign="top" ><b>' . $row->veh_name . '</b><br />' . $row->veh_code . '</td>';
                $html .= '<td valign="top"  class="center">' . $row->veh_type . '</td>';
                $html .= '<td valign="top"  class="center">' . $row->veh_model . '</td>';
                $html .= '<td valign="top"  class="center">' . $row->veh_transm . '<br />' . $row->veh_year . '</td>';
                $html .= '<td valign="top" >' . $row->color_name . '<br />' . $row->color_code . '</td>';
                $html .= '</tr>';
                $no++;
            endforeach;
            $html .='</table>';
        }
        $html .='</div>';
        $output = array(
            'html' => $html
        );
        return $output;
    }

    function htmlSpkMatch($result, $data) {
        $html = '<div align="center">';

        $html .= "<style>"
                . "table{font-family : 'helvetica';font-size : 11px;border-collapse: collapse; border-spacing: 0;margin-bottom:15px;}"
                . "th, td {padding: 0.25em 0.75em;}"
                . "th{padding-bottom:10px;padding-top:10px;}"
                . "thead th {border-bottom: 1px solid #333;  }.th-match{font-weight:bold;}</style>";

        if ($data['option'] == '1' || $data['option'] == '2') {

            $html .= '<table class="tables" id="tables">';
            $html .= '<tr><td valign="top"  colspan="7" align="center"><p class="center" style="margin-bottom:10px;font-size:12px ;font-weight:bold;" >SPK Already Matched with Vehicle Stock List<br />(Sorted by SPK Date, SPK No.)</p></td></tr>';
            $html .= '<tr><td valign="top"  colspan="7"></td></tr>';
            $html .= '</table>';
            $html .= '<table>';
            $html .= '<thead style="border:2px solid black !important;">';
            $html .= '<tr><td valign="top"  width="30" class="center th-match bold">#</td><td valign="top"  class="th-match bold">SPK No.<br />SPK Date</td><td valign="top"   class="th-match bold">Purchase Invoice No.s<br />Sales Name</td><td valign="top"  class="th-match bold" >Vehicle Name <br />Customer Name</td><td valign="top"  class="th-match bold center">Transmission <br />Year</td><td valign="top"  class="th-match bold" >Chassis</td><td valign="top"  class="th-match bold">Match Date</td></tr>';
            $html .= '</thead>';
            $no = 1;
            foreach ($result as $row):

                $html .= '<tr>';
                $html .= '<td valign="top"  class="center" width="30">' . $no . '.</td>';
                $html .= '<td valign="top" >' . $row->so_no . '<br />' . $this->dateView($row->so_date) . '</td>';
                $html .= '<td valign="top" >' . $row->pur_inv_no . '<br />' . $row->srep_name . '</td>';
                $html .= '<td valign="top" >' . $row->veh_name . '<br />' . $row->cust_name . '</td>';
                $html .= '<td valign="top"  class="center">' . $row->veh_transm . '<br />' . $row->veh_year . '</td>';
                $html .= '<td valign="top" >' . $row->chassis . '</td>';
                $html .= '<td valign="top" >' . $this->dateView($row->match_date) . '</td>';
                $html .= '</tr>';
                $no++;
            endforeach;

            $html .= '</table>';
        } elseif ($data['option'] == '3') {
            $html .= '<table class="tables" id="tables">';
            $html .= '<tr><td valign="top"  colspan="7" align="center"><p class="center" style="margin-bottom:10px;font-size:12px ;font-weight:bold;">SPK Already Matched with Vehicle Stock List<br />(Sorted by SPK No., SPK Date)</p></td></tr>';
            $html .= '<tr><td valign="top"  colspan="7"></td></tr>';
            $html .= '</table>';
            $html .= '<table>';
            $html .= '<thead style="border:2px solid black !important;">';
            $html .= '<tr><td valign="top"  width="30" class="center th-match bold">#</td><td valign="top"   class="th-match bold">Purchase Invoice No.<br />Sales Name</td><td valign="top"  class="th-match bold">SPK No.<br />SPK Date</td><td valign="top"  class="th-match bold" >Vehicle Name <br />Customer Name</td><td valign="top"  class="th-match bold center">Transmission <br />Year</td><td valign="top"  class="th-match bold">Color</td><td valign="top"  class="th-match bold" >Chassis</td><td valign="top"  class="th-match bold">Match Date</td></tr>';
            $html .= '</thead>';

            $no = 1;
            foreach ($result as $row):

                $html .= '<tr>';
                $html .= '<td valign="top"  class="center" width="30">' . $no . '.</td>';
                $html .= '<td valign="top" >' . $row->pur_inv_no . '<br />' . $row->srep_name . '</td>';
                $html .= '<td valign="top" >' . $row->so_no . '<br />' . $this->dateView($row->so_date) . '</td>';
                $html .= '<td valign="top" >' . $row->veh_name . '<br />' . $row->cust_name . '</td>';
                $html .= '<td valign="top"  class="center">' . $row->veh_transm . '<br />' . $row->veh_year . '</td>';
                $html .= '<td valign="top" >' . $row->color_code . '</td>';
                $html .= '<td valign="top" >' . $row->chassis . '</td>';
                $html .= '<td valign="top" >' . $this->dateView($row->match_date) . '</td>';
                $html .= '</tr>';
                $no++;
            endforeach;

            $html .= '</table>';
        }

        $html .= '</div>';

        $output = array(
            'html' => $html
        );
        return $output;
    }

    function htmlNotSpkMatch($result, $data) {
        $html = '<div align="center">';

        $html .= "<style>"
                . "table{font-family : 'helvetica';font-size : 11px;border-collapse: collapse; border-spacing: 0;margin-bottom:15px;}"
                . "th, td {padding: 0.25em 0.75em;}"
                . "th{padding-bottom:10px;padding-top:10px;}"
                . "thead th {border-bottom: 1px solid #333;  }.th-match{font-weight:bold;}</style>";

        if ($data['code'] == 'spk_code') {

            if ($data['option'] == '1') {
                $html .= '<table>';
                $html .= '<tr><td valign="top"  colspan="7" align="center"><p class="center" style="margin-bottom:10px;font-size:12px;font-weight:bold;">Vehicle Stock List to Match with SPK Above<br />(Sorted by Vehicle Code, Transmission, Color Code)</p></td></tr>';
                $html .= '<tr><td valign="top"  colspan="7"></td></tr>';
                $html .= '</table>';
                $html .= '<table>';
                $html .= '<thead style="border:2px solid black !important;">';
                $html .= '<tr><td valign="top"  class="center th-match bold" width="30" valign="top" style="border-left:2px solid black;">#</td><td valign="top"  class="th-match bold" valign="top">Vehicle Code</td><td valign="top"  class="th-match bold" valign="top">Vehicle Name<br />Customer Name</td><td valign="top"  class="th-match bold" valign="top">Transmission <br />Year</td><td valign="top"  class="th-match bold" valign="top">Color <br />Sales Name</td><td valign="top"  class="th-match bold" valign="top">SPK No.<br />SPK Date</td><td valign="top"  class="th-match bold" valign="top" style="border-right:2px solid black;">SPK Order</td></tr>';
                $html .= '</thead>';
                $html .= '<tr><td colspan="7"></td></tr>';

                $no = 1;
                foreach ($result as $row) {

                    $html .= '<tr>';
                    $html .= '<td valign="top"  class="center" width="30">' . $no . '.</td>';
                    $html .= '<td valign="top"  valign="top">' . $row->veh_code . '</td>';
                    $html .= '<td valign="top"  valign="top">' . $row->veh_name . '<br /><b>' . $row->cust_name . '</b></td>';
                    $html .= '<td valign="top"  valign="top">' . $row->veh_transm . '<br /><b>' . $row->veh_year . '</b></td>';
                    $html .= '<td valign="top"  valign="top">' . $row->color_name . '<br /><b>' . $row->srep_name . '</b></td>';
                    $html .= '<td valign="top"  valign="top"><b><b>' . $row->so_no . '</b></b><br />' . $this->dateView($row->so_date) . '</td>';
                    $html .= '<td valign="top"  valign="top">' . $this->dateView($row->soseq_date) . '</td>';
                    $html .= '</tr>';

                    $no++;
                }

                $html .= '</table>';
            } elseif ($data['option'] == '2') {
                $html .= '<table class="tables" id="tables">';
                $html .= '<tr><td valign="top"  colspan="7" align="center"><p class="center" style="margin-bottom:10px;font-size:12px;font-weight:bold;">Vehicle Stock List to Match with SPK Above<br />(Sorted by SPK No.)</p></td></tr>';
                $html .= '<tr><td valign="top"  colspan="7"></td></tr>';
                $html .= '</table>';
                $html .= '<table>';
                $html .= '<thead style="border:2px solid black !important;">';
                $html .= '<tr><td valign="top"  valign="top" class="center th-match bold" width="30" style="border-left:2px solid black;">#</td><td valign="top"  class="th-match bold" valign="top">SPK No.</td><td valign="top"  class="th-match bold" valign="top">SPK Date</td><td valign="top"  class="th-match bold"  valign="top">Vehicle Name<br />Customer Name</td><td valign="top"  class="th-match bold"  valign="top">Transmission <br />Year</td><td valign="top"  class="th-match bold"  valign="top">Color <br />Sales Name</td><td valign="top"  class="th-match bold"  valign="top" style="border-right:2px solid black;">Chassis</td></tr>';
                $html .= '</thead>';
                $no = 1;
                foreach ($result as $row) {

                    $html .= '<tr>';
                    $html .= '<td valign="top"  class="center" valign="top">' . $no . '.</td>';
                    $html .= '<td valign="top"  valign="top">' . $row->so_no . '</td>';
                    $html .= '<td valign="top"  valign="top">' . $this->dateView($row->so_date) . '</td>';
                    $html .= '<td valign="top"  valign="top">' . $row->veh_name . '<br /><b>' . $row->cust_name . '</b></td>';
                    $html .= '<td valign="top"  valign="top"><b>' . $row->veh_transm . '</b><br />' . $row->veh_year . '</td>';
                    $html .= '<td valign="top"  valign="top">' . $row->color_name . '<br /><b>' . $row->srep_name . '</b></td>';
                    $html .= '<td valign="top"  valign="top">' . $row->chassis . '</td>';

                    $html .= '</tr>';

                    $no++;
                }

                $html .= '</table>';
            } elseif ($data['option'] == '3') {
                $html .= '<table class="tables" id="tables">';
                $html .= '<tr><td valign="top"  colspan="7" align="center"><p class="center" style="margin-bottom:10px;font-size:12px;font-weight:bold;">Vehicle Stock List to Match with SPK Above<br />(Sorted by SPK Date)</p></td></tr>';
                $html .= '<tr><td valign="top"  colspan="7"></td></tr>';
                $html .= '</table>';
                $html .= '<table>';
                $html .= '<thead style="border:2px solid black !important;">';
                $html .= '<tr><td valign="top"  class="center th-match bold" width="30" valign="top" style="border-left:2px solid black;">#</td><td valign="top"  class="th-match bold" valign="top">SPK No.<br />SPK Date</td><td valign="top"  class="th-match bold"  valign="top">SPK Order</td><td valign="top"  class="th-match bold" valign="top">Vehicle Name<br />Customer Name</td><td valign="top"  class="th-match bold" valign="top">Transmission <br />Year</td><td valign="top"  class="th-match bold" valign="top" style="border-right:2px solid black;">Color <br />Sales Name</td></tr>';
                $html .= '</thead>';
                $no = 1;
                foreach ($result as $row) {

                    $html .= '<tr>';
                    $html .= '<td valign="top"  class="center" valign="top">' . $no . '.</td>';
                    $html .= '<td valign="top"  valign="top">' . $row->so_no . '<br /><b>' . $this->dateView($row->so_date) . '</b></td>';
                    $html .= '<td valign="top"  valign="top">' . $this->dateView($row->soseq_date) . '</td>';
                    $html .= '<td valign="top"  valign="top">' . $row->veh_name . '<br /><b>' . $row->cust_name . '</b></td>';
                    $html .= '<td valign="top"  valign="top">' . $row->veh_transm . '<br /><b>' . $row->veh_year . '</b></td>';
                    $html .= '<td valign="top"  valign="top">' . $row->color_name . '<br /><b>' . $row->srep_name . '</b></td>';

                    $html .= '</tr>';

                    $no++;
                }

                $html .= '</table>';
            }
        } elseif ($data['code'] == 'tgl_urut') {
            if ($data['option'] == '1') {
                $html .= '<table class="tables" id="tables">';
                $html .= '<tr><td valign="top"  valign="top"  colspan="7" align="center"><p class="center" style="margin-bottom:10px;font-size:12px;font-weight:bold;">Vehicle Stock List to Match with SPK Above<br />(Sorted by Vehicle Code, Transmission, Color Code)</p></td></tr>';
                $html .= '<tr><td valign="top"  valign="top"  colspan="7"></td></tr>';
                $html .= '</table>';
                $html .= '<table>';
                $html .= '<thead style="border:2px solid black !important;">';
                $html .= '<tr><td valign="top"  valign="top"  class="center th-match bold" width="30" style="border-left:2px solid black;">#</td><td valign="top"  valign="top"  class="th-match bold">SPK Order</td><td valign="top"  valign="top"  class="th-match bold">Vehicle Code</td><td valign="top"  valign="top"  class="th-match bold">Vehicle Name<br />Customer Name</td><td valign="top"  valign="top"  class="th-match bold">Transmission <br />Year</td><td valign="top"  valign="top"  class="th-match bold">Color <br />Sales Name</td><td valign="top"  valign="top"  class="th-match bold"  style="border-right:2px solid black;">SPK No.<br />SPK Date</td></tr>';
                $html .= '</thead>';
                $no = 1;
                foreach ($result as $row) {

                    $html .= '<tr>';
                    $html .= '<td valign="top"  valign="top"  class="center">' . $no . '.</td>';
                    $html .= '<td valign="top"  valign="top" >' . $this->dateView($row->soseq_date) . '</td>';
                    $html .= '<td valign="top"  valign="top" >' . $row->veh_code . '</td>';
                    $html .= '<td valign="top"  valign="top" >' . $row->veh_name . '<br /><b>' . $row->cust_name . '</b></td>';
                    $html .= '<td valign="top"  valign="top" >' . $row->veh_transm . '<br />' . $row->veh_year . '</td>';
                    $html .= '<td valign="top"  valign="top" >' . $row->color_name . '<br />' . $row->srep_name . '</td>';
                    $html .= '<td valign="top"  valign="top" >' . $row->so_no . '<br />' . $this->dateView($row->so_date) . '</td>';

                    $html .= '</tr>';

                    $no++;
                }

                $html .= '</table>';
            } elseif ($data['option'] == '2') {
                $html .= '<table class="tables" id="tables">';
                $html .= '<tr><td valign="top"  valign="top"  colspan="7" align="center"><p class="center" style="margin-bottom:10px;font-size:12px;font-weight:bold;">Vehicle Stock List to Match with SPK Above<br />(Sorted by SPK No.)</p></td></tr>';
                $html .= '<tr><td valign="top"  valign="top"  colspan="7"></td></tr>';
                $html .= '</table>';
                $html .= '<table>';
                $html .= '<thead style="border:2px solid black !important;">';
                $html .= '<tr><td valign="top"  valign="top"  class="center th-match bold" width="30" style="border-left:2px solid black;">#</td><td valign="top"  valign="top"  class="th-match bold">Nomor SPK</td><td valign="top"  valign="top"  class="th-match bold">Tgl. SPK</td><td valign="top"  valign="top"  class="th-match bold">Vehicle Name<br />Customer Name</td><td valign="top"  valign="top"  class="th-match bold">Transmission <br />Year</td><td valign="top"  valign="top"  class="th-match bold">Color<br />Sales Name</td><td valign="top"  valign="top"  class="th-match bold" style="border-right:2px solid black;">Chassiss</td></tr>';
                $html .= '</thead>';
                $no = 1;
                foreach ($result as $row) {

                    $html .= '<tr>';
                    $html .= '<td valign="top"  valign="top"  class="center">' . $no . '.</td>';
                    $html .= '<td valign="top"  valign="top" >' . $row->so_no . '</td>';
                    $html .= '<td valign="top"  valign="top" >' . $this->dateView($row->so_date) . '</td>';
                    $html .= '<td valign="top"  valign="top" >' . $row->veh_name . '<br /><b>' . $row->cust_name . '</b></td>';
                    $html .= '<td valign="top"  valign="top" >' . $row->veh_transm . '<br />' . $row->veh_year . '</td>';
                    $html .= '<td valign="top"  valign="top" >' . $row->color_name . '<br />' . $row->srep_name . '</td>';
                    $html .= '<td valign="top"  valign="top" >' . $row->chassis . '</td>';

                    $html .= '</tr>';

                    $no++;
                }

                $html .= '</table>';
            } elseif ($data['option'] == '3') {
                $html .= '<table class="tables" id="tables">';
                $html .= '<tr><td valign="top"  valign="top"  colspan="7" align="center"><p class="center" style="margin-bottom:10px;font-size:12px;font-weight:bold;">Vehicle Stock List to Match with SPK Above<br />(Sorted by SPK Date)</p></td></tr>';
                $html .= '<tr><td valign="top"  valign="top"  colspan="7"></td></tr>';
                $html .= '</table>';
                $html .= '<table>';
                $html .= '<thead style="border:2px solid black !important;">';
                $html .= '<tr><td valign="top"  valign="top"  class="center th-match bold" width="30" style="border-left:2px solid black;">#</td><td valign="top"  valign="top"  class="th-match">SPK No.<br />SPK Date</td><td valign="top"  valign="top"  class="th-match bold">SPK Order</td><td valign="top"  valign="top"  class="th-match bold">Vehicle Name<br />Customer Name</td><td valign="top"  valign="top"  class="th-match bold">Transmission <br />Year</td><td valign="top"  valign="top"  class="th-match bold" style="border-right:2px solid black;">Color <br />Sales Name</td></tr>';
                $html .= '</thead>';
                $no = 1;
                foreach ($result as $row) {

                    $html .= '<tr>';
                    $html .= '<td valign="top"  valign="top"  class="center">' . $no . '.</td>';
                    $html .= '<td valign="top"  valign="top" >' . $row->so_no . '<br />' . $this->dateView($row->so_date) . '</td>';
                    $html .= '<td valign="top"  valign="top" >' . $this->dateView($row->soseq_date) . '</td>';
                    $html .= '<td valign="top"  valign="top" >' . $row->veh_name . '<br /><b>' . $row->cust_name . '</b></td>';
                    $html .= '<td valign="top"  valign="top" >' . $row->veh_transm . '<br />' . $row->veh_year . '</td>';
                    $html .= '<td valign="top"  valign="top" >' . $row->color_name . '<br />' . $row->srep_name . '</td>';

                    $html .= '</tr>';

                    $no++;
                }

                $html .= '</table>';
            }
        }

        $html .='</div>';
        $output = array(
            'html' => $html
        );
        return $output;
    }

    function printSlipSpkMatch() {

        $action = $this->uri->segment(6);
        $data = array(
            'tbl' => encrypt_decrypt('decrypt', $this->uri->segment(4)),
            'id' => $this->uri->segment(7),
            'user' => $this->uri->segment(5),
            'action' => $action
        );


        $read = $this->htmlSlipSpk($data);
        //echo $read['html'];exit;
        $output = array(
            'html' => $read['html'],
            'filename' => 'Slip_Pengambilan Kendaraan dari_Gudang' . $read['number'],
            'title' => 'Slip Pengambilan Kendaraan dari Gudang ' . $read['number']
        );

        $html = $output['html'];
        $this->output_pdf($output['title'], $html, $output['filename'], $action, 'L');
    }

    function htmlSlipSpk($data) {
        $html = "<style>"
                . "table{font-family : 'helvetica';font-size : 11px;border-collapse: collapse; border-spacing: 0;margin-bottom:15px;}"
                . "th, td {padding: 0.25em 0.75em;}"
                . "th{padding-bottom:10px;padding-top:10px;}"
                . "thead th {border-bottom: 1px solid #333;  }.th-match{font-weight:bold;}</style>";


        if ($data) {
            $company = $this->all_m->query_single("select * from ssystem limit 1");
            $row = $this->all_m->getId($data['tbl'], 'id', $data['id']);
            $so_date = $this->dateView($row->so_date);


            $html .='<div style="padding-left:100px !important;padding-right:30px;" >';
            $html .='<table  style="font-size:11px;">';
            $html .='<tr><td colspan="3" style="font-size:14px;">' . $company->comp_name . '</td></tr>';
            $html .='<tr><td colspan="3">' . $company->comp_add1 . '</td></tr>';
            $html .='<tr><td colspan="3">' . $company->comp_add2 . '</td></tr>';
            $html .='<tr><td width="50"><b>Phone </b></td><td class="td-ro">:</td><td>' . $company->comp_phone . '</td></tr>';
            $html .='<tr><td><b>Fax</b></td><td class="td-ro">:</td><td>' . $company->comp_fax . '</td></tr>';
            $html .='</table>';

            $html .='<table class="tables"  style="font-size:11px;">';
            $html .='<tr><td></td><td></td><td></td></tr>';
            $html .= '</table>';

            $html .= '<h1 class="center"style="font-size:14px;"><b>SLIP PENGAMBILAN KENDARAAN</b></h1><br /><br />';

            $html .='<table class="tables">';
            $html .='<tr><td></td><td></td><td></td></tr>';
            $html .= '</table>';

            $html .= '<table  style="font-size:11px;">';
            $html .= '<tr><td valign="top" class="bold">Kendaraan</td><td valign="top" class="td-ro">:</td><td width="200">' . $row->veh_brand . ' ' . $row->veh_model . ' ' . $row->veh_year . '<br />' . $row->veh_name . '</td><td class="bold" valign="top">No. Rangka</td><td valign="top" class="td-ro">:</td><td valign="top">' . $row->chassis . '</td></tr>';
            $html .= '<tr><td class="bold">Warna</td><td class="td-ro">:</td><td>' . $row->color_name . '</td><td class="bold">No. Mesin</td><td class="td-ro">:</td><td>' . $row->engine . '</td></tr>';
            $html .= '<tr><td class="bold">No. S.P.K</td><td class="td-ro">:</td><td>' . $row->so_no . '</td></tr>';
            $html .= '<tr><td class="bold">Tgl. S.P.K</td><td class="td-ro">:</td><td>' . $so_date . '</td></tr>';
            $html .= '<tr><td class="bold">Customer</td><td class="td-ro">:</td><td>' . $row->cust_name . '</td></tr>';
            $html .= '<tr><td class="bold">Sales</td><td class="td-ro">:</td><td>' . $row->srep_name . '</td></tr>';
            $html .= '</table>';

            $html .='<table class="tables">';
            $html .='<tr><td></td><td></td><td></td></tr>';
            $html .= '</table>';

            $html .= '<p style="font-size:11px;">Keterangan:<br />Bila SPK masih dalam proses, harap kendaraan jangan ditarik dulu</p>';

            $html .='<table   style="font-size:11px;">';
            $html .='<tr>';
            $html .='<td>'
                    . '<table>'
                    . '<tr><td colspan="3"><b>Tgl. Distribusi: ' . date('d/m/Y') . '</b><br /><b>Distribusi,</b></td></tr>'
                    . '<tr><td colspan="3"><br /><br /><br /></td></tr><tr><td width="10">(</td><td width="150" style="border-bottom:1px solid black;"></td><td width="10">)</td></tr></table></td>';
            $html .='<td></td>';
            $html .='<td>'
                    . '<table>'
                    . '<tr><td colspan="3"><b>Tgl Ambil:</b><br /><b>Marketing Support,</b></td></tr>'
                    . '<tr><td colspan="3"><br /><br /><br /></td></tr><tr><td width="10">(</td><td width="150" style="border-bottom:1px solid black;"></td><td width="10">)</td></tr></table></td>';

            $html .= '</tr>';
            $html .='</table>';
            $html .='</div>';

            $output = array(
                'html' => $html,
                'number' => $row->so_no
            );
            return $output;
        }
    }

    function deleteSPK() {
        $table = $this->input->post('table');
        $id = $this->input->post('id');
        $spk = $this->all_m->getId($table, 'id', $id);

        $check_spkd = $this->all_m->countlimit('veh_spkd', array('so_no' => $spk->so_no));
        //$check_slh = $this->all_m->countlimit('veh_slh', array('so_no' => $spk->so_no));

        if ($spk->cls_date !== '0000-00-00') {
            $msg = array('success' => false, 'message' => 'Sorry, SPK already closed');
        } else {
            if ($spk->dp_inv_no !== '' || $spk->dp_date !== '0000-00-00') {
                $msg = array('success' => false, 'message' => 'Sorry, this SPK already has booking fee, spk can not be deleted');
            } else {
                if ($check_spkd > 0) {
                    $msg = array('success' => false, 'message' => 'Sorry, this SPK cannot be deleted because it has detail(s). Please delete them first');
                    //$msg = array('success' => false, 'message' => 'Record SPK ini ada detailnya. Silahkan hapus dulu detailnya');
                } else {
                    $this->all_m->updateData('veh_spkreg', 'so_no', $spk->so_no, array('use_date' => date('0000-00-00 00:00:00')));

                    $this->all_m->deleteData($table, 'id', $id);

                    $check = $this->all_m->countlimit($table, array('id' => $id));
                    if ($check > 0) {
                        $msg = array('success' => false, 'message' => 'Delete failed');
                    } else {
                        $msg = array('success' => true, 'message' => 'Delete success');
                    }
                }
            }
        }
        $this->json($msg);
    }

    function deletework() {

        $table = $this->input->post('table');
        $id = $this->input->post('id');

        $veh_spkd = $this->all_m->getId($table, 'id', $id);


        $veh_spk = $this->all_m->getId('veh_spk', 'so_no', $veh_spkd->so_no);


        $srv_price = $veh_spk->srv_price - $veh_spkd->price_ad;
        $srv_disc = $veh_spk->srv_disc;
        $srv_bt = $srv_price - $srv_disc;
        //$srv_bt = ($veh_slh->srv_bt - $veh_sld->price_ad) - $srv_disc;
        //$srv_vat = $srv_bt / 10;
        $srv_vat = $this->vat($srv_bt);

        $srv_at = $srv_bt + $srv_vat;
        $srv_item = $veh_spk->srv_item - 1;

        $data_spk = array(
            'srv_price' => $srv_price,
            'srv_disc' => $srv_disc,
            'srv_bt' => $srv_bt,
            'srv_vat' => $srv_vat,
            'srv_at' => $srv_at,
            'srv_item' => $srv_item
        );

        $this->all_m->updateData('veh_spk', 'so_no', $veh_spkd->so_no, $data_spk);

        $this->all_m->deleteData($table, 'id', $id);

        $check = $this->all_m->countlimit($table, array('id' => $id));
        if ($check > 0) {
            $msg = array('success' => false, 'message' => 'Delete failed');
        } else {
            $msg = array('success' => true, 'message' => 'Delete success');
        }
        $this->json($msg);
    }

    function save_note_spkreg() {

        $tbl = encrypt_decrypt('decrypt', $this->input->post('table'));
        $so_no = $this->input->post('so_no');
        $so_note = $this->input->post('so_note');

        $this->all_m->updateData($tbl, 'so_no', $so_no, array('so_note' => $so_note));

        return true;
    }

}
