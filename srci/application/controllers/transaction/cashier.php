<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
//error_reporting(E_ALL ^ E_NOTICE);
//error_reporting(0);
date_default_timezone_set("Asia/Jakarta");

class Cashier extends Application {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('crud_mdl', 'get_data_mdl'));
    }

    function readhtmlDPCanceling($data) {
        $tbl = $data['tbl'];
        $id = $data['id'];
        $user = $data['user'];

        $read = $this->all_m->getId($tbl, 'id', $id);
        $vehdpcch = $read;
        $vehdpccd = $this->all_m->getWhere('vehdpccd', array('dpc_inv_no' => $vehdpcch->dpc_inv_no));

        $dpc_date = $this->dateView($vehdpcch->dpc_date);
        $dp_date = $this->dateView($vehdpcch->dp_date);
        $so_date = $this->dateView($vehdpcch->so_date);
        $pay_date = $this->dateView($vehdpcch->pay_date);
        $check_date = $this->dateView($vehdpcch->check_date);
        $due_date = $this->dateView($vehdpcch->due_date);

        $html .= '<h3 style="text-align:right; margin-bottom:10px;">Pengembalian Uang<br />Jaminan Kendaraan</h3>';
        $html .= '<table class="tables">';
        $html .= '<tr>';
        $html .= '<td width="35%">';
        $html .= '<table class="tables"  style="font-size:12px;">';
        $html .= '<tr><td width="110"><b>No. Faktur</b></td><td width="15">:</td><td width="160"><b>' . $vehdpcch->dpc_inv_no . '</b></td></tr>';
        $html .= '<tr><td ><b>Tgl. Faktur</b></td><td width="15">:</td><td width="160">' . $dpc_date . '</td></tr>';
        $html .= '<tr><td ><b>No. Faktur UJ</b></td><td width="15">:</td><td width="160">' . $vehdpcch->dp_inv_no . '</td></tr>';
        $html .= '<tr><td ><b>Tgl. Faktur UJ</b></td><td width="15">:</td><td width="160">' . $dp_date . '</td></tr>';
        $html .= '</table>';
        $html .= '</td>';
        $html .= '<td width="30%">';
        $html .= '<table class="tables"  style="font-size:12px;" >';
        $html .= '<tr><td width="90"><b>No. SPK</b></td><td width="15">:</td><td width="100">' . $vehdpcch->so_no . '</td></tr>';
        $html .= '<tr><td><b>Tgl. SPK</b></td><td width="15">:</td><td width="100">' . $so_date . '</td></tr>';
        $html .= '<tr><td><b>Tgl. Bayar</b></td><td width="15">:</td><td width="100">' . $pay_date . '</td></tr>';
        $html .= '<tr><td><b>Jenis Bayar</b></td><td width="15">:</td><td width="100">' . $vehdpcch->pay_type . '</td></tr>';
        $html .= '<tr><td><b>Keterangan</b></td><td width="15">:</td><td width="100">' . $vehdpcch->note . '</td></tr>';
        $html .= '</table>';
        $html .= '</td>';
        $html .= '<td width="30%">';
        $html .= '<table class="tables"  style="font-size:12px;">';
        $html .= '<tr><td width="90"><b>Bank</b></td><td width="15">:</td><td width="150">' . $veh_argh->bank_code . '</td></tr>';
        $html .= '<tr><td width="90"><b>No. Check/Giro</b></td><td width="15">:</td><td>' . $veh_argh->check_no . '</td></tr>';
        $html .= '<tr><td width="90"><b>Tgl. Check/Giro</b></td><td width="15">:</td><td>' . $check_date . '</td></tr>';
        $html .= '<tr><td width="90"><b>J.Tempo</b></td><td width="15">:</td><td>' . $due_date . '</td></tr>';
        $html .= '</table>';
        $html .= '</td>';
        $html.= '</tr>';
        $html .= '</table>';

        $html .= '<table class="tables">';
        $html .= '<tr>';
        $html .= '<td width="60%">';
        $html .= '<table class="tables"  style="font-size:12px;" >';
        $html .= '<tr><td width="110"><b>Customer</b></td><td width="15">:</td><td width="300"><b>' . $vehdpcch->cust_name . ' (' . $vehdpcch->cust_code . ')</b></td></tr>';
        $html .= '<tr><td ><b>Kendaraan</b></td><td width="15">:</td><td >' . $vehdpcch->veh_name . '</td></tr>';
        $html .= '<tr><td ><b>Warna</b></td><td width="15">:</td><td>' . $vehdpcch->color_name . '</td></tr>';
        $html .= '<tr><td ><b>Memo</b></td><td width="15">:</td><td>' . $vehdpcch->note . '</td></tr>';
        $html .= '</table>';
        $html .= '</td>';
        $html .= '<td width="40%">';
        $html .= '<table class="tables"  style="font-size:12px;" >';
        $html .= '<tr><td width="90"><b>Chassis</b></td><td width="15">:</td><td width="100">' . $vehdpcch->chassis . '</td></tr>';
        $html .= '<tr><td width="90"><b>Engine</b></td><td width="15">:</td><td width="100">' . $vehdpcch->engine . '</td></tr>';
        $html .= '</table>';
        $html .= '</td>';
        $html.= '</tr>';
        $html .= '</table>';

        $html .= '<table><tr><td><br /></td></tr></table>';
        $html .= '<table class="tables"  style="font-size:11px;">';
        $html .= '<tr>'
                . '<td style="border-bottom:1px solid #000;" width="120"><b>No.Check/Giro UJ</b></td>'
                . '<td style="border-bottom:1px solid #000;" width="120"><b>Tgl.Check/Giro UJ</b></td>'
                . '<td style="border-bottom:1px solid #000;" class="right"><b>Uang Jaminan</b></td>'
                . '<td style="border-bottom:1px solid #000;" class="right"><b>Pemotongan</b></td>'
                . '<td style="border-bottom:1px solid #000;" class="right"><b>Pemotongan Lain</b></td>'
                . '<td style="border-bottom:1px solid #000;" class="right"><b>Pengembalian</b></td></tr>';

        $pay_val = 0;
        $pay_deduct = 0;
        $pay_deduct = 0;
        $pay_rval = 0;

        foreach ($vehdpccd as $dpccd):
            $pay_val += $dpccd->pay_val;
            $pay_deduct += $dpccd->pay_deduct;
            $pay_deduct += $dpccd->pay_deduct;
            $pay_rval += $dpccd->pay_rval;

            $html .= '<tr>';
            $html .= '<td>' . $dpccd->check_no . '</td>';
            $html .= '<td>' . $this->dateView($dpccd->check_date) . '</td>';
            $html .= '<td class="right">' . rupiah($dpccd->pay_val) . '</td>';
            $html .= '<td class="right">' . rupiah($dpccd->pay_deduct) . '</td>';
            $html .= '<td class="right">' . rupiah($dpccd->pay_deduc2) . '</td>';
            $html .= '<td class="right">' . rupiah($dpccd->pay_rval) . '</td>';
            $html .= '</tr>';
            $no++;

        endforeach;


        $html .= '<tr><td colspan="6"></td></tr>';
        $html .= '<tr><td colspan="6"></td></tr>';
        $html .= '<tr><td colspan="6"></td></tr>';
        $html .= '<tr><td colspan="6"></td></tr>';
        $html .= '<tr border="1">'
                . '<td></td>'
                . '<td class="right"><b>Total:</b></td>'
                . '<td class="right" style="border-top:1px solid #000;border-bottom:1px solid #000;">' . rupiah($pay_val) . '</td>'
                . '<td class="right" style="border-top:1px solid #000;border-bottom:1px solid #000;">' . rupiah($pay_deduct) . '</td>'
                . '<td class="right" style="border-top:1px solid #000;border-bottom:1px solid #000;">' . rupiah($pay_deduc2) . '</td>'
                . '<td class="right" style="border-top:1px solid #000;border-bottom:1px solid #000;">' . rupiah($pay_rval) . '</td>'
                . '<td></td></tr>';

        $html .= '</table>';
        $html .= '<br /><br /><br /><br /><br />';

        $html .= '<table class="tables">';
        $html .= '<tr>';
        $html .= '<td width="55%"></td>';
        $html .= '<td width="45%">'
                . '<table class="tables" style="font-size:11px;">'
                . '<tr><td width="15">(</td><td width="100"></td><td width="15">)</td><td width="30"></td><td width="15">(</td><td width="100"></td><td width="15">)</td></tr>'
                . '<tr><td width="15"></td><td width="100" align="center" style="border-top:0.5px solid black;"><b>Pemberi</b></td><td width="15"></td><td width="30"></td><td width="15"></td><td width="100" align="center" style="border-top:0.5px solid black;"><b>Penerima</b></td><td width="15"></td></tr>'
                . '</table></td>';
        $html .= '</tr>';

        /* Counter Printer */
        $user = $data['user'];
        $prn_cnt = $read->prn_cnt;
        $user2 = $read->prn_by;


        if ($prn_cnt !== 0) {
            $user = $user2;
        }

        $viewcnt = array(
            'user' => $user,
            'prn_cnt' => $prn_cnt,
            'action' => $data['action']
        );

        $html .= $this->viewPrnCnt($viewcnt);
        /* Counter Printer */

        $html .= '</table>';

        $output = array(
            'html' => $html,
            'number' => $vehdpcch->dpc_inv_no
        );

        return $output;
    }

    function readhtmlPiutangGabungan($data) {

        $tbl = $data['tbl'];
        $id = $data['id'];
        $user = $data['user'];

        $read = $this->all_m->getId($tbl, 'id', $id);
        $veh_argh = $read;

        $veh_argd = $this->all_m->getWhere('veh_argd', array('arg_inv_no' => $veh_argh->arg_inv_no));
		
		$payment = $this->all_m->query_single("select SUM(pd_paid) as payment from veh_argd where arg_inv_no='$veh_argh->arg_inv_no' ");
		

		$pay_date = $this->dateView($veh_argh->pay_date);
        $check_date = $this->dateView($veh_argh->check_date);
        $due_date = $this->dateView($veh_argh->due_date);
        $arg_date = $this->dateView($veh_argh->arg_date);
		
		if($payment->payment > 0){
			$title = 'KWITANSI';
		}else{
			$title = 'KWITANSI PENGEMBALIAN';
		}
		
        $html = '';
        $html .= '<h3 style="text-align:center; margin-bottom:10px;">'.$title.'</h3>';
        $html .= '<table class="tables">';
        $html .= '<tr>';
        $html .= '<td width="35%">';
        $html .= '<table class="tables"  style="font-size:12px;">';
        $html .= '<tr><td width="90"><b>No. Kwit</b></td><td width="15">:</td><td width="160">' . $veh_argh->arg_inv_no . '</td></tr>';
        $html .= '<tr><td><b>Terima Dari</b></td><td width="15">:</td><td>' . $veh_argh->cust_name . ' (' . $veh_argh->cust_code . ')</td></tr>';
        $html .= '</table>';
        $html .= '</td>';
        $html .= '<td width="30%">';
        $html .= '<table class="tables"  style="font-size:12px;">';
        $html .= '<tr><td width="90"><b>Tgl. Kwit</b></td><td width="15">:</td><td width="100">' . $arg_date . '</td></tr>';
        $html .= '</table>';
        $html .= '</td>';
        $html .= '<td width="30%">';
        $html .= '<table class="tables"  style="font-size:12px;">';
        $html .= '<tr><td width="90"><b>Warehouse</b></td><td width="15">:</td><td>' . $veh_argh->wrhs_code . '</td></tr>';
        $html .= '</table>';
        $html .= '</td>';
        $html.= '</tr>';
        $html .= '<tr>';
        $html .= '<td colspan="3">';
        $html .= '<table class="tables"style="font-size:12px;">';
        $html .= '<tr><td width="90"><b>Jumlah</b></td><td width="15">:</td><td><b>' . rupiah($veh_argh->tot_paid) . '</b></td></tr>';
        $html .= '<tr><td width="90"><b>Terbilang</b></td><td width="15">:</td><td># ' . terbilang($veh_argh->tot_paid) . ' #</td></tr>';
        $html .= '</table>';
        $html .= '</td>';

        $html.= '</tr>';
        $html .= '</table>';

        $html .= '<table><tr><td><br /></td></tr></table>';
        $html .= '<table class="tables" >';
        $html .= '<tr>';
        $html .= '<td width="25%">';
        $html .= '<table class="tables"  style="font-size:12px;">';
        $html .= '<tr><td width="90"><b>Jenis Bayar</b></td><td width="15">:</td><td width="100">' . $veh_argh->pay_type . '</td></tr>';
        $html .= '<tr><td><b>Bank</b></td><td width="15">:</td><td>' . $veh_argh->bank_code . '</td></tr>';
        $html .= '</table>';
        $html .= '</td>';
        $html .= '<td width="25%">';
        $html .= '<table class="tables"  style="font-size:12px;">';
        $html .= '<tr><td width="100"><b>Tgl. Bayar</b></td><td width="15">:</td><td width="100">' . $pay_date . '</td></tr>';
        $html .= '<tr><td width="100"><b>No. Cek/Giro</b></td><td width="15">:</td><td width="100">' . $veh_argh->check_no . '</td></tr>';
        $html .= '</table>';
        $html .= '</td>';
        $html .= '<td width="25%">';
        $html .= '<table class="tables"  style="font-size:12px;">';
        $html .= '<tr><td></td></tr>';
        $html .= '<tr><td width="100"><b>Tgl. Cek/Giro</b></td><td width="15">:</td><td width="90">' . $check_date . '</td></tr>';
        $html .= '</table>';
        $html .= '</td>';
        $html .= '<td width="25%">';
        $html .= '<table class="tables"  style="font-size:12px;">';
        $html .= '<tr><td></td></tr>';
        $html .= '<tr><td width="70"><b>J. Tempo</b></td><td width="15">:</td><td width="90">' . $due_date . '</td></tr>';
        $html .= '</table>';
        $html .= '</td>';
        $html .= '</tr>';
        $html .= '<tr><td colspan="4"><table style="font-size:12px;"><tr><td width="90"><b>Note</b></td><td width="15">:</td><td>' . $veh_argh->note . '</td></tr></table></td></tr>';
        $html .= '</table>';

        $html .= '<table><tr><td><br /></td></tr></table>';
        $html .= '<table class="tables"  style="font-size:11px;">';
        $html .= '<tr>'
                . '<td style="border-bottom:1px solid #000;" width="20"><b>No.</b></td>'
                . '<td style="border-bottom:1px solid #000;" width="130"><b>Chassis</b></td>'
                . '<td style="border-bottom:1px solid #000;" width="100"><b>Faktur Jual</b></td>'
                . '<td style="border-bottom:1px solid #000;" width="70"><b>Tgl. Faktur</b></td>'
                . '<td style="border-bottom:1px solid #000;" class="right"><b>Total Faktur</b></td>'
                . '<td style="border-bottom:1px solid #000;" class="right"><b>Saldo Awal</b></td>'
                . '<td style="border-bottom:1px solid #000;" class="right"><b>Pembayaran</b></td>'
                . '<td style="border-bottom:1px solid #000;" class="right"><b>Disc</b></td>'
                . '<td style="border-bottom:1px solid #000;" class="right"><b>Saldo Akhir</b></td></tr>';

        $no = 1;
        foreach ($veh_argd as $ard):

            $total += $ard->pd_paid;
            $diskon += $ard->pd_disc;

            $html .= '<tr>';
            $html .= '<td>' . $no . '.</td>';
            $html .= '<td>' . $ard->chassis . '</td>';
            $html .= '<td>' . $ard->sal_inv_no . '</td>';
            $html .= '<td>' . $this->dateView($ard->sal_date) . '</td>';
            $html .= '<td class="right">' . rupiah($ard->inv_total) . '</td>';
            $html .= '<td class="right">' . rupiah($ard->pd_begin) . '</td>';
            $html .= '<td class="right">' . rupiah($ard->pd_paid) . '</td>';
            $html .= '<td class="right">' . rupiah($ard->pd_disc) . '</td>';
            $html .= '<td class="right">' . rupiah($ard->pd_end) . '</td>';
            $html .= '</tr>';
            $no++;

        endforeach;
        $html .= '<tr><td colspan="9"></td></tr>';
        $html .= '<tr><td colspan="9"></td></tr>';
        $html .= '<tr><td colspan="9"></td></tr>';
        $html .= '<tr><td colspan="9"></td></tr>';
        $html .= '<tr border="1">'
                . '<td colspan="5"></td>'
                . '<td class="right"><b>Total:</b></td>'
                . '<td class="right" style="border-top:1px solid #000;border-bottom:1px solid #000;">' . rupiah($total) . '</td>'
                . '<td class="right" style="border-top:1px solid #000;border-bottom:1px solid #000;">' . rupiah($diskon) . '</td>'
                . '<td></td></tr>';


        /* Counter Printer */
        $user = $data['user'];
        $prn_cnt = $read->prn_cnt;
        $user2 = $read->prn_by;


        if ($prn_cnt !== 0) {
            $user = $user2;
        }

        $viewcnt = array(
            'user' => $user,
            'prn_cnt' => $prn_cnt,
            'action' => $data['action']
        );

        $html .= $this->viewPrnCnt($viewcnt);
        /* Counter Printer */
        $html .= '</table>';
		
		$html .= '<table class="tables"  style="font-size:11px;">';
		$htmk .= '';
		$html .= '</table>';

        $html .= '<br /><br /><p style="font-size:7.5pt;">Tgl: ' . date('d/m/Y') . '  Jam: '.date('h:i:s').'</p>';
	
        $output = array(
            'html' => $html,
            'number' => $veh_argh->arg_inv_no
        );

        return $output;
    }

    function readhtmlHutangGabungan($data) {
        $tbl = $data['tbl'];
        $id = $data['id'];
        $user = $data['user'];

        if ($tbl == 'veh_apgh') {
            $apgd = 'veh';
        }
        if ($tbl == 'acc_apgh') {
            $apgd = 'acc';
        }

        $read = $this->all_m->getId($tbl, 'id', $id);
        $veh_apgh = $read;
        $veh_apgd = $this->all_m->getWhere($apgd . '_apgd', array('apg_inv_no' => $veh_apgh->apg_inv_no));

        $pay_date = $this->dateView($veh_apgh->pay_date);
        $check_date = $this->dateView($veh_apgh->check_date);
        $due_date = $this->dateView($veh_apgh->due_date);
        $apg_date = $this->dateView($veh_apgh->apg_date);

        $html = '';
        $html .= '<table class="tables">';
        $html .= '<tr>';
        $html .= '<td width="30%"><table class="tables"  style="font-size:12px;">';
        $html .= '<tr><td width="90"><b>No. Faktur</b></td><td width="15">:</td><td width="200">' . $veh_apgh->apg_inv_no . '</td></tr>';
        $html .= '<tr><td><b>Tgl. Faktur</b></td><td width="15">:</td><td>' . $apg_date . '</td></tr>';
        $html .= '<tr><td><b>Warehouse</b></td><td width="15">:</td><td>' . $veh_apgh->wrhs_code . '</td></tr>';

        $html .= '</table></td>';

        $html .= '<td width="40%"><table class="tables" style="font-size:12px;">';
        $html .= '<tr><td width="90"><b>Tgl. Bayar</b></td><td width="15">:</td><td width="120">' . $pay_date . '</td></tr>';
        $html .= '<tr><td><b>Jenis Bayar</b></td><td width="15">:</td><td>' . $veh_apgh->pay_type . '</td></tr>';
        $html .= '<tr><td><b>Bank</b></td><td width="15">:</td><td>' . $veh_apgh->bank_code . '</td></tr>';
        $html .= '<tr><td><b>Keterangan</b></td><td width="15">:</td><td width="200">' . $veh_apgh->pay_desc . '</td></tr>';
        $html .= '</table></td>';

        $html .= '<td width="30%"><table class="tables" style="font-size:12px;">';
        $html .= '<tr><td width="100"><b>No. Cek/Giro</b></td><td width="15">:</td><td width="120">' . $veh_apgh->check_no . '</td></tr>';
        $html .= '<tr><td><b>Tgl. Cek/Giro</b></td><td width="15">:</td><td>' . $check_date . '</td></tr>';
        $html .= '<tr><td><b>J. Tempo</b></td><td width="15">:</td><td>' . $due_date . '</td></tr>';
        $html .= '</table></td>';
        $html .= '</tr>';

        if ($tbl == 'veh_apgh') {
            $supp_code = $veh_apgh->supp_code;
            $supp_name = $veh_apgh->supp_name;
        }
        if ($tbl == 'acc_apgh') {
            $supp_code = $veh_apgh->paid2_code;
            $supp_name = $veh_apgh->paid2_name;
        }

        $html .= '<tr><td colspan="3">';
        $html .= '<table  class="tables" style="font-size:12px;">';
        $html .= '<tr><td  width="90"><b>Supplier</b></td><td width="15">:</td><td>' . $supp_name . ' (' . $supp_code . ')</td></tr>';
        $html .= '<tr><td><b>Note</b></td><td width="15">:</td><td>' . $veh_apgh->note . '</td></tr>';
        $html .= '</table>';
        $html .= '</td></tr>';
        $html .= '</table>';

        //$html .= '<table class="tables"><tr><td></td></tr></table>';
        $html .= '<table  style="font-size:11px;font-family:Courier;" >';
        $html .= '<tr>'
                . '<td style="border-bottom:1px solid #000;" width="30"><b>No.</b></td>';
        if ($tbl == 'veh_apgh') {
            $html .='<td style="border-bottom:1px solid #000;" width="120"><b>Chassis</b></td>';
        }
        $html .= '<td style="border-bottom:1px solid #000;" width="100"><b>Faktur Beli</b></td>'
                . '<td style="border-bottom:1px solid #000;"><b>Tgl. Faktur</b></td>'
                . '<td style="border-bottom:1px solid #000;" class="right"><b>Total Faktur</b></td>'
                . '<td style="border-bottom:1px solid #000;" class="right"><b>Saldo Awal</b></td>'
                . '<td style="border-bottom:1px solid #000;" class="right" width="100"><b>Pembayaran</b></td>'
                . '<td style="border-bottom:1px solid #000;" class="right"><b>Disc</b></td>'
                . '<td style="border-bottom:1px solid #000;" class="right"><b>Saldo Akhir</b></td></tr>';

        $no = 1;
        foreach ($veh_apgd as $apd):

            $total += $apd->hd_paid;
            $diskon += $apd->hd_disc;

            $html .= '<tr>';
            $html .= '<td>' . $no . '.</td>';

            if ($tbl == 'veh_apgh') {
                $html .= '<td>' . $apd->chassis . '</td>';
            }

            $html .= '<td>' . $apd->pur_inv_no . '</td>';
            $html .= '<td>' . $this->dateView($apd->pur_date) . '</td>';
            $html .= '<td class="right">' . rupiah($apd->inv_total) . '</td>';
            $html .= '<td class="right">' . rupiah($apd->hd_begin) . '</td>';
            $html .= '<td class="right" width="100">' . rupiah($apd->hd_paid) . '</td>';
            $html .= '<td class="right">' . rupiah($apd->hd_disc) . '</td>';
            $html .= '<td class="right">' . rupiah($apd->hd_end) . '</td>';
            $html .= '</tr>';
            $no++;

        endforeach;
        $html .= '<tr><td colspan="9"></td></tr>';
        //$html .= '<tr><td colspan="9"></td></tr>';
        //$html .= '<tr><td colspan="9"></td></tr>';
        //$html .= '<tr><td colspan="9"></td></tr>';
        $html .= '<tr border="1">';

        if ($tbl == 'veh_apgh') {
            $html .= '<td colspan="5"></td>';
        }
        if ($tbl == 'acc_apgh') {
            $html .= '<td colspan="4"></td>';
        }

        $html .= '<td class="right"><b>Total:</b></td>'
                . '<td class="right" style="border-top:1px solid #000;border-bottom:1px solid #000;" width="100">' . rupiah($total) . '</td>'
                . '<td class="right" style="border-top:1px solid #000;border-bottom:1px solid #000;">' . rupiah($diskon) . '</td>'
                . '<td></td></tr>';
        $html .= '</table>';

        $html .= '<table class="tables"><tr><td></td></tr></table>';
        $html .= '<table class="tables" width="300" style="font-size:11px;">';
        $html .= '<tr><td class="bold center">Mengetahui</td><td class="bold center">Keuangan</td><td class="bold center">Accounting</td><td class="bold center">Penerima</td></tr>';
        $html .= '<tr><td colspan="4"></td></tr>';
        $html .= '<tr><td colspan="4"></td></tr>';
        $html .= '<tr><td><hr /></td><td><hr /></td><td><hr /></td><td><hr /></td></tr>';


        /* Counter Printer */
        $user = $data['user'];
        $prn_cnt = $read->prn_cnt;
        $user2 = $read->prn_by;


        if ($prn_cnt !== 0) {
            $user = $user2;
        }

        $viewcnt = array(
            'user' => $user,
            'prn_cnt' => $prn_cnt,
            'action' => $data['action']
        );

        $html .= $this->viewPrnCnt($viewcnt);
        /* Counter Printer */
        $html .= '</table>';
        //$html .= '<span style="font-size:7.5pt; float:right;">Dicetak Oleh: ' . $user . '</span>';

        $output = array(
            'html' => $html,
            'number' => $veh_apgh->apg_inv_no
        );

        return $output;
    }

    function saveuangjaminan() {
        $id = $this->input->post('id');
        $table = $this->input->post('table');
        $data = $this->input->post();

        unset($data['table']);
        unset($data['id']);
        //'cust_code', 'cust_name'

        $status = true;

        if ($data['cust_code'] == '') {
            $msg = array('success' => false, 'message' => 'Please input Customer Code & Name');
            $status = false;
        }
        if ($data['veh_type'] == '') {
            $msg = array('success' => false, 'message' => 'Please input Vehicle Code & Name');
            $status = false;
        }
        if ($data['color_type'] == '') {
            $msg = array('success' => false, 'message' => 'Please input Color Code & Name');
            $status = false;
        }
        if ($data['prc_type'] == '') {
            $msg = array('success' => false, 'message' => 'Please input Vehicle Price Type  (ON &#47; OFF the road)');
            $status = false;
        }
        if ($data['salpaytype'] == '') {
            $msg = array('success' => false, 'message' => 'Please input Transaction Type (Cash or Credit)');
            $status = false;
        }
        if ($data['pay_type'] == '') {
            $msg = array('success' => false, 'message' => 'Please input Payment Type');
            $status = false;
        }


        if ($status !== false) {

            $veh_spk = $this->all_m->getId($table, 'id', $id);

            if ($veh_spk->use_date == null || $veh_spk->use_date == '0000-00-00') {
                if ($id !== '') {
                    $this->all_m->updateData($table, 'id', $id, $data);
                    $msg = array('success' => true, 'message' => 'Record updated ');
                } else {

                    $check = $this->all_m->insertData($table, $data);
                    //$data['use_date'] = date('Y-m-d');
                    $this->all_m->updateData('veh_spkreg', 'so_no', $data['so_no'], array('use_date' => date('Y-m-d h:i:s')));
                    $msg = array('success' => true, 'message' => 'Record saved');
                }
            } else {
                $msg = array('success' => false, 'message' => 'Sorry, this SPK No. has been used');
            }
        } else {
            $msg = $msg;
        }

        $this->json($msg);
    }

    function save_arh() {
        $table = $this->input->post('table');
        $id = $this->input->post('id');
        $data = $this->input->post();

        unset($data['table']);
        unset($data['id']);

        if (!empty($data['sal_date'])) {
            $data['sal_date'] = $this->dateFormat($data['sal_date']);
        }
        if (!empty($data['opn_date'])) {
            $data['opn_date'] = $this->dateFormat($data['opn_date']);
        }
        if (!empty($data['due_date'])) {
            $data['due_date'] = $this->dateFormat($data['due_date']);
        }
        if (!empty($data['cls_date'])) {
            $data['cls_date'] = $this->dateFormat($data['cls_date']);
        }

        if (!empty($data['pur_date'])) {
            $data['pur_date'] = $this->dateFormat($data['pur_date']);
        }
        if (!empty($data['stk_date'])) {
            $data['stk_date'] = $this->dateFormat($data['stk_date']);
        }
        if (!empty($data['supp_invdt'])) {
            $data['supp_invdt'] = $this->dateFormat($data['supp_invdt']);
        }
        if (!empty($data['po_date'])) {
            $data['po_date'] = $this->dateFormat($data['po_date']);
        }

        if ($id !== '') {
            $this->all_m->updateData($table, 'id', $id, $data);
            $msg = array('success' => true, 'message' => 'Record updated ', 'status' => 'update');
        } else {
            unset($data['sal_inv_no']);
            $data['sal_inv_no'] = $this->all_m->inv_seq('4', 'VSL');
            $check = $this->all_m->insertData($table, $data);
            $inv_seq = $this->all_m->getOne('inv_seq', array('inv_type' => 'VSL'));
            $this->all_m->updateData('inv_seq', 'id', $inv_seq->id, array('inv_no' => $inv_seq->inv_no + 1));

            $msg = array('success' => true, 'message' => 'Record saved', 'status' => 'save');
        }
        $this->json($msg);
    }

    function checkGroupPiutang() {
        if ($this->input->post()) {

            $sal_inv_no = $this->input->post('sal_inv_no');
            $check = $this->all_m->check('veh_argd', array('sal_inv_no' => $sal_inv_no));

            if ($check > 0) {
                $msg = array('status' => false, 'message' => 'This button is deactivated, please use Vehicle Account Receivable Group Payment to add payment');
            } else {
                $msg = array('status' => true);
            }

            $this->json($msg);
        }
    }

    function prepaid() {
        $data = $this->input->post();
        $cust_code = $data['cust_code'];
        $so_no = $data['so_no'];

        /* $sql = "SELECT a.dp_date, a.dp_inv_no, a.so_no, a.so_date, a.cust_name, 
          b.pay_val, b.check_no, a.chassis, a.engine, a.cust_code, b.pay_type, b.bank_code, b.check_date, b.pay_date,
          b.due_date, b.pay_desc, b.coll_code, b.payer_name, b.payer_addr, b.payer_area, b.payer_city, b.payer_zipc,
          b.fp_no, b.fp_date, b.pay_bt, b.pay_vat, b.pay_bbn
          FROM veh_dpch a,veh_dpcd b
          WHERE a.cust_code = '$cust_code' AND a.so_no = '$so_no' AND a.dp_inv_no = b.dp_inv_no
          AND b.used_val < b.pay_val
          ORDER BY a.dp_inv_no";
         */

        $check = $this->all_m->check('veh_dpch', array('so_no' => $so_no));

        if ($check < 1) {
            $msg = array('status' => false, 'message' => 'Down Payment ' . $data["cust_name"] . ' for SPK No.: ' . $data["so_no"] . ' does not exist or has been used');
        } else {
            $msg = $this->all_m->getId('veh_dpch', 'so_no', $so_no);
        }

        $this->json($msg);
    }

    function outputpdf() {
        $margin = null;
        $font = 'Courier';
        $action = $this->uri->segment(7);

        $data['tbl'] = encrypt_decrypt('decrypt', $this->uri->segment(4));
        //$data['tbl'] = $this->uri->segment(4);
        $data['action'] = $action;
        $data['id'] = $this->uri->segment(5);
        $data['user'] = $this->uri->segment(6);
        $data['signature'] = $this->uri->segment(8);
        $data['jabatan'] = $this->uri->segment(9);
        $data['year'] = null;
        $data['mounth'] = null;

        $prn_cnt = 'prn_cnt';
        $c_array = array();

        $table = encrypt_decrypt('decrypt', $this->uri->segment(4));

        switch ($table) {
            case 'veh_arh':
                $data['type'] = $this->uri->segment(10);
                $data['invoicedate'] = $this->uri->segment(11);

                if ($this->uri->segment(12)) {
                    $data['mounth'] = $this->uri->segment(12);
                }
                if ($this->uri->segment(13)) {
                    $data['year'] = $this->uri->segment(13);
                }

                $read = $this->readHtmlKwitansi($data);

                $prn_cnt = 'prn_cnt_kw';

                $output = array(
                    'html' => $read['html'],
                    'filename' => 'Kwitansi_' . $read['number'],
                    'title' => 'Kwitansi ' . $read['number']
                );
                $margin = "L";


                break;

            case 'veh_ard':
                $read = $this->readHtmlKwitansi($data);
                $output = array(
                    'html' => $read['html'],
                    'filename' => 'Kwitansi_' . $read['number'],
                    'title' => 'Kwitansi ' . $read['number']
                );
                $margin = "L";
                $c_array['prn_by_kw'] = $data['user'];
                $prn_cnt = 'prn_cnt_kw';
                break;
            case 'acc_ard':
                $read = $this->readHtmlKwitansi($data);
                $output = array(
                    'html' => $read['html'],
                    'filename' => 'Kwitansi_' . $read['number'],
                    'title' => 'Kwitansi ' . $read['number']
                );
                $margin = "L";
                $c_array['prn_by_kw'] = $data['user'];
                $prn_cnt = 'prn_cnt_kw';

                break;
            case 'veh_dpcd':
                $data['tts_no'] = $this->uri->segment(10);
                $data['tts_date'] = $this->uri->segment(11);

                $read = $this->readHtmlTTS($data);

                $output = array(
                    'html' => $read['html'],
                    'filename' => 'TTS_' . $read['number'],
                    'title' => 'TTS ' . $read['number']
                );
                $c_array['prn_by_tt'] = $data['user'];
                $prn_cnt = 'prn_cnt_tt';

                if ($action == 'download') {
                    $dpcd = $this->all_m->getId($data['tbl'], 'id', $data['id']);
                    $this->all_m->updateData($table, 'id', $data['id'], array('tts_no' => $data['tts_no'], 'tts_date' => date('Y-m-d'), 'tts_name' => $data['signature'], 'prn_by_tt' => $data['user'], 'prn_cnt_tt' => $dpcd->prn_cnt_tt + 1));
                }
                $margin = "L";

                break;
            case 'veh_argh':

                $read = $this->readhtmlPiutangGabungan($data);
                $output = array(
                    'html' => $read['html'],
                    'filename' => 'Faktur_Piutang_Gabungan_' . $read['number'],
                    'title' => 'Faktur Piutang Gabungan ' . $read['number']
                );
                $margin = "L";
                $c_array['prn_by'] = $data['user'];
                break;

            case 'veh_dpsgh':

                $read = $this->readhtmlDPSupplierGabungan($data);

                $output = array(
                    'html' => $read['html'],
                    'filename' => 'Faktur_Hutang_Gabungan_' . $read['number'],
                    'title' => 'Faktur Hutang Gabungan ' . $read['number']
                );
                $margin = "L";
                $c_array['prn_by'] = $data['user'];
                break;


            case 'veh_apgh':

                $read = $this->readhtmlHutangGabungan($data);
                $output = array(
                    'html' => $read['html'],
                    'filename' => 'Faktur_Hutang_Gabungan_' . $read['number'],
                    'title' => 'Faktur Hutang Gabungan ' . $read['number']
                );
                $margin = "L";
                $c_array['prn_by'] = $data['user'];

                break;

            case 'acc_apgh':

                $read = $this->readhtmlHutangGabungan($data);
                $output = array(
                    'html' => $read['html'],
                    'filename' => 'Faktur_Hutang_Gabungan_Accessoriess' . $read['number'],
                    'title' => 'Faktur Hutang Gabungan Accessoriess' . $read['number']
                );
                $margin = "L";
                $c_array['prn_by'] = $data['user'];

                break;

            case 'vehdpcch':
                $read = $this->readhtmlDPCanceling($data); //print_r($read);exit;
                $output = array(
                    'html' => $read['html'],
                    'filename' => 'Pembatalan_uang_jaminan_' . $read['number'],
                    'title' => 'Pembatalan Uang Jaminan ' . $read['number']
                );
                $margin = "L";
                $c_array['prn_by'] = $data['user'];
                break;
        }


        if ($action !== 'screen') {
            $this->count_prnt($data, $c_array, $prn_cnt);
        }

        $html = $output['html'];

        $this->output_pdf($output['title'], $html, $output['filename'], $action, $margin, $font);
    }

    function readHtmlKwitansi($data) {
        $year = $data['year'];
        $mounth = $data['mounth'];

        $dbs = $this->getDataHistory($year, $mounth);

        $signature = str_replace('%20', ' ', $data['signature']);
        $jabatan = str_replace('%20', ' ', $data['jabatan']);

        $company = $this->all_m->query_single("select * from ssystem limit 1");
        $read = $this->all_m->getId($dbs . '.' . $data['tbl'], 'id', $data['id']);

        if ($data['tbl'] == 'veh_arh') {
            $code = 'VKW';

            $veh_slh = $this->all_m->getId($dbs . '.veh_slh', 'sal_inv_no', $read->sal_inv_no);

            if ($veh_slh->kwit_no !== '') {
                $number = $veh_slh->kwit_no;
            } else {
                $number = $this->all_m->inv_seq('4', $code);
            }
        } else {
            $code = 'VKP';

            if ($data['tbl'] == 'acc_ard') {
                $code = 'AKP';
            }
            $number = $this->all_m->inv_seq('4', $code);
        }



        if ($data['tbl'] == 'veh_arh') {
            $arh = $this->all_m->getId($dbs . '.veh_arh', 'sal_inv_no', $read->sal_inv_no);
        }
        if ($data['tbl'] == 'veh_ard') {
            $arh = $this->all_m->getId($dbs . '.veh_arh', 'sal_inv_no', $read->sal_inv_no);
        }
        if ($data['tbl'] == 'acc_ard') {
            $arh = $this->all_m->getId($dbs . '.acc_arh', 'sal_inv_no', $read->sal_inv_no);
        }

        if ($data['tbl'] == 'veh_arh') {
            $date = $data['invoicedate'];
        } else {
            $date = date('Y-m-d');
        }


        $html = '';
        $html .='<table class="tables" >';
        $html .='<tr>';
        $html .='<td width="60%"s></td>';
        $html .='<td width="40%"><table class="table">';
        $html .='<tr><td colspan="3" style="font-size:13px;"><b>' . $company->comp_name . '</b></td></tr>';
        $html .='<tr><td colspan="3" style="font-size:12px;">' . $company->comp_add1 . '</td></tr>';
        $html .='<tr><td colspan="3" style="font-size:12px;">' . $company->comp_add2 . '</td></tr>';
        $html .='<tr><td style="font-size:12px;"width="50%">Phone : ' . $company->comp_phone . '</td><td width="50%" colspan="2" style="font-size:12px;">Fax : ' . $company->comp_fax . '</td></tr>';
        $html .='<tr><td colspan="3" style="font-size:13px;"><b>Kwitansi No : </b>' . $number . '</td></tr>';
        $html .='</table></td>';
        $html .='</tr>';
        $html .='<tr><td></td><td></td></tr>';
        $html .='</table>';


        $html .='<table class="tables"  style="font-size:12px;">';

        if ($data['tbl'] == 'veh_arh') {
            $type = $data['type'];

            if ($type == 'pelanggan') {
                $name = $read->cust_name;
                $addr = $read->cust_addr;
            } elseif ($type == 'stnk') {
                $name = $read->cust_rname;
                $addr = $read->cust_raddr;
            } elseif ($type == 'debitur') {
                $name = $read->lease_name;
                $addr = $read->lease_addr;
            }

            $html .='<tr><td class="td-title" width="150">Sudah terima dari</td><td width="15">:</td><td  colspan="7">' . $name . '<br />' . $addr . '</td></tr>';
        } else {
            $html .='<tr><td class="td-title" width="150">Sudah terima dari</td><td width="15">:</td><td  colspan="7">' . $read->payer_name . '<br />' . $read->payer_addr . '</td></tr>';
            //$html .='<tr><td class="td-title"></td><td class="td-ro"></td><td colspan="7">' . $read->payer_addr . '</td></tr>';     
        }

        if ($data['tbl'] == 'veh_arh') {
            $html .='<tr><td class="td-title" width="150">Banyaknya Uang</td><td  width="15">:</td><td colspan="7">' . rupiah($read->inv_total) . '</td></tr>';
        }

        if ($data['tbl'] == 'veh_ard') {
            $html .='<tr><td class="td-title" width="150">Banyaknya Uang</td><td  width="15">:</td><td colspan="7">' . rupiah($read->pay_val) . '</td></tr>';
        }
        if ($data['tbl'] == 'acc_ard') {
            $html .='<tr>'
                    . '<td class="td-title" width="150">Banyaknya Uang</td><td  width="15">:</td><td width="120">' . rupiah($read->pay_val) . '</td>'
                    . '<td class="td-title" width="100">Tgl. Bayar</td><td  width="15">:</td><td width="120">' . $this->dateView($read->pay_date) . '</td>'
                    . '<td class="td-title" width="100">Jenis Bayar</td><td  width="15">:</td><td>' . $read->pay_type . '</td></tr>';
        }

        if ($data['tbl'] == 'veh_arh') {
            $html .='<tr><td class="td-title" width="150">Terbilang</td><td width="15">:</td><td colspan="7">#' . terbilang($read->inv_total) . ' Rp.#</td></tr>';
        } else {
            $html .='<tr><td class="td-title" width="150">Terbilang</td><td width="15">:</td><td colspan="7">#' . terbilang($read->pay_val) . ' Rp.#</td></tr>';
        }
        $html .='</table>';

        if ($data['tbl'] == 'veh_ard' || $data['tbl'] == 'veh_arh') {
            $html .='<table class="tables"  style="font-size:12px;"><tr><td></td></tr><tr><td><b>Untuk pembayaran sebuah kendaraan:</b></td></tr></table>';
        }
        if ($data['tbl'] == 'acc_ard') {
            $html .='<table class="tables"  style="font-size:12px;"><tr><td></td></tr><tr><td>Untuk pembayaran optional sesuai dengan Faktur No. <b>' . $arh->sal_inv_no . '</b>   Tanggal: <b>' . $this->dateView($arh->sal_date) . '</b></td></tr></table>';
        }

        $html .='<table class="tables" style="font-size:12px;">';
        $html .='<tr><td width="50"></td><td class="td-title">Merek/Type</td><td width="15">:</td><td width="280">' . $arh->veh_brand . '/' . $arh->veh_type . '</td><td class="td-title">Tahun</td><td width="15">:</td><td width="250">' . $arh->veh_year . '</td></tr>';
        $html .='<tr><td width="50"></td><td class="td-title">Model</td><td width="15">:</td><td>' . $arh->veh_model . '</td><td class="td-title">No. Rangka</td><td width="15">:</td><td>' . $arh->chassis . '</td></tr>';
        $html .='<tr><td width="50"></td><td class="td-title">Warna</td><td width="15">:</td><td>' . $arh->color_name . '</td><td class="td-title">No. Mesin</td><td width="15">:</td><td>' . $arh->engine . '</td></tr>';

        if ($data['tbl'] == 'veh_arh') {
            $html .='<tr><td width="50"></td><td class="td-title">Keterangan</td><td width="15">:</td><td>' . $arh->veh_name . '</td></tr>';
        } else {
            $html .='<tr><td width="50"></td><td class="td-title">Kendaraan</td><td width="15">:</td><td>' . $arh->veh_name . '</td></tr>';
            $html .='<tr><td width="50"></td><td class="td-title">Keterangan</td><td width="15">:</td><td>' . $arh->note . '</td></tr>';
        }

        $html .='</table>';

        if ($code == 'VKW') {
            $html .='<table class="tables"  style="font-size:12px;"><tr><td></td></tr><tr><td><b>* Harga Off The Road</b></td></tr></table>';
        }

        $html .='<table class="tables" style="font-size:12px;">';
        $html .='<tr><td></td><td class="right"></td></tr>';
        $html .='<tr><td></td><td class="right"><b>' . $company->comp_city . ',</b> ' . $this->dateView($date) . '</td></tr>';
        $html .='<tr><td></td><td class="right"></td></tr>';
        $html .='</table>';

        $html .='<table class="tables" style="font-size:12px;">';

        /* Counter Printer */
        $user = $data['user'];
        $prn_cnt = $read->prn_cnt;
        $user2 = $read->prn_by;

        if ($data['tbl'] == 'veh_ard' || $data['tbl'] == 'acc_ard') {
            $prn_cnt = $read->prn_cnt_kw;
            $user2 = $read->prn_by_kw;
        }


        if ($prn_cnt !== 0) {
            $user = $user2;
        }

        $viewcnt = array(
            'user' => $user,
            'prn_cnt' => $prn_cnt,
            'action' => $data['action']
        );

        $html .= $this->viewPrnCnt($viewcnt);
        /* Counter Printer */

        //$html .='<tr><td style="width:100px;">Dicetak(#1)</td><td width="15">:</td><td>' . $data['user'] . '</td></tr>';
        $html .='</table>';

        $html .='<table class="tables">';
        $html .='<tr><td style="width:71%"></td><td width="15">(</td><td class="center" style="border-bottom:0.5px solid #000;font-size:12px;">' . $signature . '</td><td  width="15">)</td></tr>';
        $html .='<tr><td style="width:71%" style="font-size:10px;">Pembayaran dengan cek/giro bilyet sah setelah diuangkan/masuk rekening kami</td><td></td><td class="center" style="font-size:12px;"><b>' . $jabatan . '</b></td><td class="td-ro"></td></tr>';
        $html .='</table>';

        if ($data['tbl'] !== 'acc_ard') {

            if ($data['action'] !== 'screen') {

                if ($data['tbl'] == 'veh_arh') {
                    $veh_slh = $this->all_m->getId($dbs . '.veh_slh', 'sal_inv_no', $read->sal_inv_no);
                    if ($veh_slh->kwit_no == '') {
                        $inv_seq = $this->all_m->getOne('inv_seq', array('inv_type' => $code));
                        $this->all_m->updateData('inv_seq', 'id', $inv_seq->id, array('inv_no' => $inv_seq->inv_no + 1));

                        $this->all_m->updateData($dbs . '.veh_slh', 'sal_inv_no', $read->sal_inv_no, array('kwit_no' => $number, 'kwit_date' => $date));
                    }
                }
            }
        }
        $output = array(
            'html' => $html,
            'number' => $number
        );

        return $output;
    }

    function uangJaminan() {

        if ($this->input->post()) {
            $id = $this->input->post('id');
            $sal_inv_no = $this->input->post('sal_inv_no');
            $dpcd = (array) $this->all_m->getId('veh_dpcd', 'id', $id);

            $checkarh = $this->all_m->countlimit('veh_arh', array('sal_inv_no' => $sal_inv_no));

            $count = $this->all_m->countlimit('veh_dpcd', array('id' => $id));

            $stat = true;

            $check_ard = $this->all_m->countlimit('veh_ard', array('sal_inv_no' => $sal_inv_no, "check_no" => $dpcd['check_no']));

            /* if($dpcd['use_date'] !== NULL){
              $stat = false;
              $msg = array('success' => false, 'message' => 'Sorry, the DP It\'s been used');
              } */
            if ($check_ard > 0) {
                $stat = false;
                $msg = array('success' => false, 'message' => 'Sorry, Duplicate Check No : ' . $dpcd['check_no']);
            }
            if ($dpcd['sal_inv_no'] !== NULL) {
                $stat = false;
                $msg = array('success' => false, 'message' => 'Sorry, the DP It\'s been used');
            }

            if ($checkarh < 1) {
                $stat = false;
                $msg = array('success' => false, 'message' => 'Sorry, data not found');
            }
            if ($count < 1) {
                $stat = false;
                $msg = array('success' => false, 'message' => 'Sorry, the DP that you choose does not exist anymore');
            }


            if ($stat !== false) {

                unset($dpcd['id']);

                // $dpch = (array) $this->all_m->getId('veh_dpch', 'dp_inv_no', $dp_inv_no);
                $veh_arh = $this->all_m->getId('veh_arh', 'sal_inv_no', $sal_inv_no);

                $sql = "show columns from veh_ard";
                $veh_ard = $this->all_m->query_all($sql);

                foreach ($veh_ard as $ard) {
                    $field_ard[$ard->Field] = '';
                }
                unset($field_ard['id']);

                foreach ($dpcd as $k => $v) {

                    if (array_key_exists($k, $field_ard)) {
                        $key[] = $k;
                        $val[] = $v;
                    }
                }
                /* update veh_ard */
                $new_veh_ard = array_combine($key, $val);
                $new_veh_ard['sal_inv_no'] = $sal_inv_no;
                $new_veh_ard['add_by'] = $this->input->post('user');
                $new_veh_ard['pay_date'] = date('Y-m-d');

                $pd_paid = $veh_arh->pd_paid + $new_veh_ard['pay_val'];
                $pd_disc = $veh_arh->pd_disc + $new_veh_ard['disc_val'];
                $total = $veh_arh->pd_begin - $pd_paid - $pd_disc;

                $new_veh_arh['pd_paid'] = $pd_paid;
                $new_veh_arh['pd_disc'] = $pd_disc;
                $new_veh_arh['pd_end'] = $total;

                /* update veh_dpcd */
                $new_dpcd = array(
                    'use_date' => date('Y-m-d'),
                    'used_val' => $new_veh_ard['pay_val'],
                    'sal_inv_no' => $sal_inv_no
                );

                $new_slh = array(
                    'is_paid' => 1
                );

                $veh_dpch = $this->all_m->getId('veh_dpch', 'dp_inv_no', $dpcd['dp_inv_no']);

                $dp_paid = $veh_dpch->dp_paid;
                $dp_used = $veh_dpch->dp_used + $dpcd['pay_val'];
                $dp_end = $dp_paid - $dp_used;

                $new_dpch = array(
                    //'dp_paid' => $dp_paid,
                    'dp_used' => $dp_used,
                    'dp_end' => $dp_end
                );

                $check = $this->all_m->countlimit('veh_ard', $new_veh_ard);

                if ($check > 0) {
                    $msg = array('success' => false, 'message' => 'Sorry, the DP that you choose does not exist anymore');
                } else {
                    // print_r($new_dpch);exit;
                    /* insert veh_ard */
                    $this->all_m->insertData('veh_ard', $new_veh_ard);
                    /* insert veh_arh */
                    $this->all_m->updateData('veh_arh', 'sal_inv_no', $sal_inv_no, $new_veh_arh);

                    $this->all_m->updateData('veh_dpcd', 'id', $id, $new_dpcd);

                    $this->all_m->updateData('veh_slh', 'sal_inv_no', $dpcd['sal_inv_no'], $new_slh);

                    $this->all_m->updateData('veh_dpch', 'id', $veh_dpch->id, $new_dpch);


                    $msg = array('success' => true);
                }
            } else {
                $msg = $msg;
            }
        }

        $this->json($msg);
    }

    function check_id() {
        $table = $this->input->post('tbl');
        $sal_inv_no = $this->input->post('sal_inv_no');
        $res = $this->all_m->getId($table, 'sal_inv_no', $sal_inv_no);

        $this->json($res);
    }

    function saveDownpayment() {
        $data = $this->input->post();

        $so_no = $data['so_no'];

        $dp_inv_no = $number = $this->all_m->inv_seq('4', 'VDC');
        $number = $this->all_m->getId('inv_seq', 'inv_type', 'VDC');
        $num = $number->inv_no + 1;

        unset($data['pd_end']);
        unset($data['table']);
        unset($data['id']);
        unset($data['dp_inv_no']);

        $data['dp_inv_no'] = $dp_inv_no;
        $data['dp_date'] = $this->dateFormat($data['dp_date']);
        $data['opn_date'] = $this->dateFormat($data['opn_date']);
        $data['so_date'] = $this->dateFormat($data['so_date']);

        $table = $this->input->post('table');
        $id = $this->input->post('id');

        $stat = true;

        $veh_spk = $this->all_m->getId('veh_spk', 'so_no', $so_no);

        if ($veh_spk->cls_date == '0000-00-00') {
            $stat = false;
            $msg = array('success' => false, 'message' => 'SPK No = ' . $so_no . ' has not closed');
        }

        $lnfield2 = strlen(trim($so_no));

        if ($lnfield2 == 0) {
            $stat = false;
            $msg = array('success' => false, 'message' => 'Data cannot be empty');
        }

        if ($stat !== false) {
            $msg = array('success' => false, 'message' => 'Data cannot be empty');
            $count = $this->all_m->countlimit($table, array('so_no' => $so_no));

            if ($count >> 0) {
                $msg = array('success' => false, 'message' => 'Data already exist');
            } else {
                $spk = $this->all_m->getId('veh_spk', 'so_no', $so_no);

                $data['cust_type'] = $spk->cust_type;
                $data['srep_code'] = $spk->srep_code;
                $data['cust_sex'] = $spk->cust_sex;
                $data['cust_addr'] = $spk->cust_addr;
                $data['cust_area'] = $spk->cust_area;
                $data['cust_city'] = $spk->cust_city;
                $data['cust_zipc'] = $spk->cust_zipc;
                $data['cust_phone'] = $spk->cust_phone;
                $data['cust_hp'] = $spk->cust_hp;
                $data['veh_brand'] = $spk->veh_brand;
                $data['veh_type'] = $spk->veh_type;
                $data['veh_transm'] = $spk->veh_transm;
                $data['veh_model'] = $spk->veh_model;
                $data['veh_year'] = $spk->veh_year;

                $this->all_m->insertData($table, $data);
                $count = $this->all_m->countlimit($table, array('so_no' => $so_no));

                if ($count >> 0) {
                    $this->all_m->updateData('veh_spk', 'so_no', $so_no, array('dp_inv_no' => $data['dp_inv_no'], 'dp_date' => $data['dp_date']));
                    $this->all_m->updateData('inv_seq', 'inv_type', 'VDC', array('inv_no' => $num));
                    $dpch = $this->all_m->getId('veh_dpch', 'dp_inv_no', $data['dp_inv_no']);
                    $msg = array('success' => true, 'message' => 'Record saved', 'id' => $dpch->id);
                } else {
                    $msg = array('success' => false, 'message' => 'Insert failed');
                }
            }
        }

        $this->json($msg);
    }

    function deleteDownpayment() {
        $table = $this->input->post('table');
        $id = $this->input->post('id');

        $dpch = $this->all_m->getId($table, 'id', $id);

        $number = $this->all_m->getId('inv_seq', 'inv_type', 'VDC');
        $num = $number->inv_no - 1;

        $count = $this->all_m->countlimit('veh_dpcd', array('dp_inv_no' => $dpch->dp_inv_no));

        if ($count >> 0) {
            $msg = array('success' => false, 'message' => 'Sorry, this invoice cannot be deleted because it has detail(s). Please delete them first');
        } else {

            $spk = $this->all_m->getId('veh_spk', 'so_no', $dpch->so_no);

            $this->all_m->updateData('veh_spk', 'id', $spk->id, array('dp_inv_no' => '', 'dp_date' => ''));
            $this->all_m->deleteData($table, 'id', $id);
            $this->all_m->updateData('inv_seq', 'inv_type', 'VDC', array('inv_no' => $num));

            $count = $this->all_m->countlimit($table, array('id' => $id));

            if ($count >> 0) {
                $msg = array('success' => false, 'message' => 'Delete failed');
            } else {
                $msg = array('success' => true, 'message' => 'Delete Success');
            }
        }

        $this->json($msg);
    }

    function readHtmlTTS($data) {
        $dpcd = $this->all_m->getId($data['tbl'], 'id', $data['id']);
        $dpch = $this->all_m->getId('veh_dpch', 'dp_inv_no', $dpcd->dp_inv_no);
        $company = $this->all_m->query_single("select * from ssystem limit 1");

        $date = date('d/m/Y');
        $number = $data['tts_no'];
        $so_date = $this->dateView($dpcd->so_date);
        $pay_date = $this->dateView($dpcd->pay_date);
        $check_date = $this->dateView($dpcd->check_date);
        $due_date = $this->dateView($dpcd->due_date);

        $html = '<br /><br /><br />';
        $html .='<table class="tables"><tr><td><br /><br /></td></tr><tr><td></td></tr></table>';
        $html .='<table class="tables" style="font-size:12px;">';
        $html .='<tr>';
        $html .= '<td style="width:60%">'
                . '<table>'
                . '<tr><td><b>Sudah terima dari :</b></td></tr>'
                . '<tr><td>' . $dpcd->payer_name . '</td></tr>'
                . '<tr><td>' . $dpcd->payer_addr . '</td></tr>'
                . '</table>'
                . '</td>';
        $html .='<td style="width:40%">'
                . '<table>'
                . '<tr><td class="bold" width="70">No TTS</td><td class="td-ro">:</td><td>' . $number . '</td></tr>'
                . '<tr><td class="bold">No SPK</td><td class="td-ro">:</td><td>' . $dpcd->so_no . '</td></tr>'
                . '<tr><td class="bold">Tgl SPK</td><td class="td-ro">:</td><td>' . $so_date . '</td></tr>'
                . '</table>'
                . '</td>';
        $html .='</tr>';
        $html .='</table>';

        $html .='<table class="tables"><tr><td></td></tr><tr><td></td></tr></table>';
        $html .='<table class="tables" style="font-size:12px;">';
        $html .='<tr><td class="bold">Tgl. Bayar</td><td class="bold">Jenis Bayar</td><td class="bold">Bank</td><td class="bold">No.Cek/Giro</td><td class="bold">Tgl.Cek/Giro</td><td class="bold">Tgl.J.T</td><td class="bold">Jumlah</td></tr>';
        $html .='<tr><td>' . $pay_date . '</td>'
                . '<td>' . $dpcd->pay_type . '</td>'
                . '<td>' . $dpcd->bank_code . '</td>'
                . '<td>' . $dpcd->check_no . '</td>'
                . '<td>' . $check_date . '</td>'
                . '<td>' . $due_date . '</td>'
                . '<td>' . rupiah($dpcd->pay_val) . '</td>'
                . '</tr>';
        $html .='<tr><td colspan="7"><b>Terbilang:</b> #' . terbilang($dpcd->pay_val) . ' Rp.#</td></tr>';
        $html .='</table>';

        $html .='<table class="tables"><tr><td></td></tr><tr><td></td></tr></table>';

        $html .='<table class="tables" style="font-size:12px;">';
        $html .= '<tr>';
        $html .= '<td style="width:70%">'
                . '<table>'
                . '<tr><td width="30" class="bold">Memo</td><td class="td-ro">:</td><td></td></tr>'
                . '<tr><td width="50" class="bold">Sales</td><td class="td-ro">:</td><td>' . $dpch->srep_name . '</td></tr>';
        //. '<tr><td colspan="3">DiCetak (#1) : ' . $data['user'] . '</td></tr>'
        /* Counter Printer */
        $user = $data['user'];

        if ($dpcd->prn_cnt_tt !== 0) {
            $user = $dpcd->prn_by_tt;
        }

        $viewcnt = array(
            'user' => $user,
            'prn_cnt' => $dpcd->prn_cnt_tt,
            'action' => $data['action']
        );

        $html .= $this->viewPrnCnt($viewcnt);
        /* Counter Printer */

        $html .= '</table>'
                . '</td>';
        $html .= '<td valign="bottom">' . $company->comp_city . ', ' . $date . '</td>';
        $html .= '</tr>';
        $html .='</table>';

        $html .='<table class="tables"><tr><td></td></tr></table>';

        $html .='<table class="tables" style="font-size:12px;">';
        $html .= '<tr><td colspan="3" class="bold" style="">Untuk pembayaran sebuah kendaraan:</td></tr>';
        $html .= '<tr>'
                . '<td width="30%">'
                . '<table>'
                . '<tr><td class="bold" width="50">Tipe</td><td class="td-ro">:</td><td width="200">' . $dpch->veh_type . '</td></tr>'
                . '<tr><td class="bold" width="50">Model</td><td class="td-ro">:</td><td width="200">' . $dpch->veh_model . '</td></tr>'
                . '<tr><td class="bold" width="50">Warna</td><td class="td-ro">:</td><td width="200">' . $dpch->color_name . '</td></tr>'
                . '</table>'
                . '</td>'
                . '<td width="40%">'
                . '<table width="100%">'
                . '<tr><td class="bold" width="50">Tahun</td><td class="td-ro">:</td><td width="250">' . $dpch->veh_year . '</td></tr>'
                . '<tr><td class="bold" width="50">Rangka</td><td class="td-ro">:</td><td>' . $dpch->chassis . '</td></tr>'
                . '<tr><td class="bold" width="50">Mesin</td><td class="td-ro">:</td><td>' . $dpch->engine . '</td></tr>'
                . '</table>'
                . '</td>'
                . '<td width="30%">'
                . '<table>'
                . '<tr><td class="td-ro">(</td><td class="center" width="60%">' . $data['signature'] . ' </td> <td class="td-ro">)</td></tr>'
                . '<tr><td class="td-ro"></td><td><hr /></td><td class="td-ro"></td></tr>'
                . '<tr><td class="td-ro"></td><td class="center" width="60%">' . str_replace('%20', ' ', $data['jabatan']) . '</td><td class="td-ro"></td></tr>'
                . '</table>'
                . '</td>'
                . '</tr>';



        $html .='</table>';

        $output = array(
            'html' => $html,
            'number' => $number
        );

        return $output;
    }

    function saveBBNDownpayment() { //print_r($this->input->post());exit;
        $id = $this->input->post('id');
        $bbn = $this->input->post('bbn_val');
        $tbl = $this->input->post('table');

        $dpcd = $this->all_m->getId($tbl, 'id', $id);

        if ($dpcd->pay_bbn !== NULL) {

            $msg = array('success' => false, 'message' => 'There is a BBN Payment for this Down Payment');
        } else {
            $this->all_m->updateData($tbl, 'id', $id, array('pay_bbn' => $bbn));
            $msg = array('success' => true, 'message' => 'BBN has been paid successfully');
        }


        $this->json($msg);
    }

    function savePiutangGabungan() {

        $data = $this->input->post();

        $table = $this->input->post('table');
        $id = $this->input->post('id');
        $date = date('Y-m-d');

        unset($data['table']);
        unset($data['id']);

        if (!empty($data['opn_date'])) {
            $data['opn_date'] = $this->dateFormat($data['opn_date']);
        }
        if (!empty($data['pay_date'])) {
            $data['pay_date'] = $this->dateFormat($data['pay_date']);
        }
        if (!empty($data['check_date'])) {
            $data['check_date'] = $this->dateFormat($data['check_date']);
        }
        if (!empty($data['due_date'])) {
            $data['due_date'] = $this->dateFormat($data['due_date']);
        }
        if (!empty($data['arg_date'])) {
            $data['arg_date'] = $this->dateFormat($data['arg_date']);
        }


        $veh_cust = $this->all_m->getOne('veh_cust', array('cust_code' => $data['cust_code'], 'cust_name' => $data['cust_name']));

        $data['cust_type'] = $veh_cust->cust_type;

        if ($veh_cust->postaddr == 1) {
            $data["cust_addr"] = $veh_cust->oaddr;
            $data["cust_area"] = $veh_cust->oarea;
            $data["cust_city"] = $veh_cust->ocity;
            $data["cust_zipc"] = $veh_cust->ozipcode;
        } else if ($veh_cust->postaddr == 2) {
            $data["cust_addr"] = $veh_cust->haddr;
            $data["cust_area"] = $veh_cust->harea;
            $data["cust_city"] = $veh_cust->hcity;
            $data["cust_zipc"] = $veh_cust->hzipcode;
        }

        if (intval(strtotime($data['pay_date'])) <> intval(strtotime($date))) {
            $msg = array('status' => false, 'message' => 'Sorry, Payment Date has to be the same with today\'s date');
        }
        if ($data['check_no'] == '') {
            $msg = array('status' => false, 'message' => 'Please input Cheque No.');
        }
        if ($data['pay_type'] == '') {
            $msg = array('status' => false, 'message' => 'Please input Payment Type');
        }
        if ($data['cust_code'] == '') {
            $msg = array('status' => false, 'message' => 'Please input Customer code');
        }
        if ($data['wrhs_code'] == '') {
            $msg = array('status' => false, 'message' => 'Please input Warehouse');
        }

        if ($msg['status'] !== false) {

            if ($id !== '') {
                $this->all_m->updateData($table, 'id', $id, $data);
                $msg = array('success' => true, 'message' => 'Record updated ', 'status' => 'update');
                $this->updateLocked($table, $id);
            } else {
                unset($data['arg_inv_no']);
                $data['arg_inv_no'] = $this->all_m->inv_seq('4', 'VRG');
                $this->all_m->insertData($table, $data);

                $inv_seq = $this->all_m->getOne('inv_seq', array('inv_type' => 'VRG'));
                $this->all_m->updateData('inv_seq', 'id', $inv_seq->id, array('inv_no' => $inv_seq->inv_no + 1));

                $msg = array('success' => true, 'message' => 'Record saved', 'status' => 'save');
            }
        } else {
            $status = $msg;
        }


        $this->json($msg);
    }

    function closePiutangGabungan() {
        $user = $this->uri->segment(4);
        $data = $this->input->post();
        $tbl = $this->input->post('table');
        $id = $this->input->post('id');
        //$date = date('d/m/Y');
        $date = date('Y-m-d');

        unset($data['id']);
        unset($data['table']);

        $periode = $this->checkPeriode();

        if ($periode == 'false') {
            $msg = $this->msgNotClose();
            $msg['status'] = false;
        }

        $check = $this->all_m->check('veh_argd', array('arg_inv_no' => $data['arg_inv_no']));


        $pay_date = $this->dateFormat($data['pay_date']);

        if (intval(strtotime($pay_date)) <> intval(strtotime($date))) {
            $msg = array('status' => false, 'message' => 'Sorry, Payment Date has to be the same with today\'s date');
        }

        if ($check < 1) {
            $msg = array('status' => false, 'message' => 'Unable to close this invoice because there is no Detail. Please input some Detail(s)');
        }

        $veh_argh = $this->all_m->getId($tbl, 'id', $id);
        $veh_argd = $this->all_m->getWhere('veh_argd', array('arg_inv_no' => $veh_argh->arg_inv_no));

        foreach ($veh_argd as $argd) {
            if (intval(strtotime($argd->sal_date)) > intval(strtotime(date('Y-m-d')))) {
                $msg = array('status' => false, 'message' => 'Sorry, There is a payment Invoice date that is greater than today\'s date');
            }
        }


        if ($msg['status'] !== false) {

            $check = $this->all_m->check($tbl, array('arg_inv_no' => $veh_argh->arg_inv_no));

            $no_inv = '';
            foreach ($veh_argd as $argd) {
                $check_ard = $this->all_m->countlimit('veh_ard', array('sal_inv_no' => $argd->sal_inv_no, "check_no" => $veh_argh->check_no));

                if ($check_ard > 0) {
                    $no_inv = $argd->sal_inv_no . ' ';
                }
                $countard += $check_ard;
            }

            if ($countard > 0) {
                $msg = array('status' => false, 'message' => 'Sorry, Duplicate Check No : ' . $veh_argh->check_no);
            } else {

                foreach ($veh_argd as $argd) {

                    $data_ard = array(
                        "sal_inv_no" => $argd->sal_inv_no,
                        "sal_date" => $argd->sal_date,
                        "bank_code" => $veh_argh->bank_code,
                        "pay_date" => $veh_argh->pay_date,
                        "pay_type" => $veh_argh->pay_type,
                        "check_no" => $veh_argh->check_no,
                        "check_date" => $veh_argh->check_date,
                        "due_date" => $veh_argh->due_date,
                        "pay_val" => $argd->pd_paid,
                        "disc_val" => $argd->pd_disc,
                        "pay_desc" => $veh_argh->pay_desc,
                        "coll_code" => $veh_argh->coll_code,
                        "add_by" => $user,
                        "add_date" => date('Y-m-d'),
                        "ref_no" => $veh_argh->ref_no,
                        "ref_date" => $veh_argh->ref_date,
                        "link_no" => $veh_argh->link_no,
                        //"dp_inv_no" => '',
                        //"dp_date" => '',
                        //"kwit_ono" => '',
                        //"kwit_odate" => '',
                        //"kwit_oname" => '',
                        //"prn_cnt_kw" => '',
                        //"prn_by_kw" => '',
                        "payer_name" => $veh_argh->cust_name,
                        "payer_addr" => $veh_argh->cust_addr,
                        "payer_area" => $veh_argh->cust_area,
                        "payer_city" => $veh_argh->cust_city,
                        "payer_zipc" => $veh_argh->cust_zipc,
                        //"prn_cnt_tt" => '',
                        //"prn_by_tt" => '',
                        "edc_code" => $veh_argh->edc_code,
                        "dppay_date" => '',
                        "arg_inv_no" => $argd->arg_inv_no,
                        "arg_date" => $argd->arg_date,
                        "pay_bt" => $argd->pay_bt,
                        "pay_vat" => $argd->pay_vat,
                        // "fp_no" => '',
                        // "fp_date" => '',
                        "pay_bbn" => $argd->pay_bbn
                            //"dpfp_no" => '',
                            //"dpfp_date" => ''
                    );

                    $this->all_m->insertData('veh_ard', $data_ard);

                    $veh_arh = $this->all_m->getId('veh_arh', 'sal_inv_no', $argd->sal_inv_no);

                    $pd_paid = $veh_arh->pd_paid + $argd->pd_paid;
                    $pd_disc = $veh_arh->pd_disc + $argd->pd_disc;


                    $data_arh = array(
                        // 'inv_total' => $veh_aph->inv_total + $apgd->inv_total,
                        // 'pd_begin' => $veh_aph->pd_begin + $apgd->pd_begin,
                        'pd_paid' => $veh_arh->pd_paid + $argd->pd_paid,
                        'pd_disc' => $veh_arh->pd_disc + $argd->pd_disc,
                        'pd_end' => intval($veh_arh->pd_begin) - intval($pd_paid) - intval($pd_disc)
                    );


                    $this->all_m->updateData('veh_arh', 'sal_inv_no', $argd->sal_inv_no, $data_arh);

                    $this->all_m->updateData('veh_argd', 'id', $argd->id, array('arg_date' => date('Y-m-d')));
                }

                $veh_argh = $this->all_m->getId($tbl, 'id', $id);
                $data_argh = array(
                    'arg_date' => date('Y-m-d'),
                    'cls_date' => date('Y-m-d'),
                    'cls_by' => $user,
                    'cls_cnt' => $veh_argh->cls_cnt + 1
                );

                $this->all_m->updateData($tbl, 'id', $id, $data_argh);
                $msg = array('success' => true);
            }
        } else {
            $res = $msg;
        }

        /*
         * veh_arh
          veh_slh
          veh_ard
          veh_argd
          veh_argh
         */
        $this->json($msg);
    }

    function unclosePiutangGabungan() {
        $user = $this->uri->segment(4);
        $data = $this->input->post();
        $tbl = $this->input->post('table');
        $id = $this->input->post('id');
        $date = date('Y-m-d');

        unset($data['id']);
        unset($data['table']);

        $periode = $this->checkPeriode();

        if ($periode == 'false') {
            $msg = $this->msgNotUnClose();
            $msg['status'] = false;
        }

        $check = $this->all_m->check('veh_argd', array('arg_inv_no' => $data['arg_inv_no']));

        $pay_date = $this->dateFormat($data['pay_date']);
        if (strtotime($pay_date) <> strtotime($date)) {
            $msg = array('status' => false, 'message' => 'Sorry, Payment Date has to be the same with today\'s date');
        }

        if ($check < 1) {
            $msg = array('status' => false, 'message' => 'Unable to close this invoice because there is no Detail. Please input some Detail(s)');
        }

        if ($msg['status'] !== false) {
            $veh_argh = $this->all_m->getId($tbl, 'id', $id);

            $check = $this->all_m->check($tbl, array('arg_inv_no' => $veh_argh->arg_inv_no));

            $veh_argd = $this->all_m->getWhere('veh_argd', array('arg_inv_no' => $veh_argh->arg_inv_no));

            foreach ($veh_argd as $argd) {

                $data_ard = array(
                    "sal_inv_no" => $argd->sal_inv_no,
                    "arg_inv_no" => $argd->arg_inv_no,
                );

                $veh_ard = $this->all_m->getOne('veh_ard', $data_ard);
                if ($veh_ard) {
                    $this->all_m->deleteData('veh_ard', 'id', $veh_ard->id);
                }


                $veh_arh = $this->all_m->getId('veh_arh', 'sal_inv_no', $argd->sal_inv_no);

                $pd_paid = $veh_arh->pd_paid - $argd->pd_paid;
                $pd_disc = $veh_arh->pd_disc - $argd->pd_disc;

                $data_arh = array(
                    // 'inv_total' => $veh_aph->inv_total + $apgd->inv_total,
                    // 'pd_begin' => $veh_aph->pd_begin + $apgd->pd_begin,
                    'pd_paid' => $veh_arh->pd_paid - $argd->pd_paid,
                    'pd_disc' => $veh_arh->pd_disc - $argd->pd_disc,
                    'pd_end' => intval($veh_arh->pd_begin) - intval($pd_paid) - intval($pd_disc)
                );


                $this->all_m->updateData('veh_arh', 'sal_inv_no', $argd->sal_inv_no, $data_arh);

                $this->all_m->updateData('veh_argd', 'id', $argd->id, array('arg_date' => ''));
            }

            $data_argh = array(
                'arg_date' => '',
                'cls_date' => '',
                'cls_by' => ''
            );

            $this->all_m->updateData($tbl, 'id', $id, $data_argh);
            $msg = array('success' => true);
        } else {
            $res = $msg;
        }

        /*
         * veh_arh
          veh_slh
          veh_ard
          veh_argd
          veh_argh
         */
        $this->json($msg);
    }

    function deletePiutangGabungan() {
        $table = $this->input->post('table');
        $id = $this->input->post('id');

        $veh_argh = $this->all_m->getId($table, 'id', $id);
        //$veh_argd = $this->all_m->getWhere($table, array('arg_inv_no' => $veh_argh->arg_inv_no));

        $check = $this->all_m->check('veh_argd', array('arg_inv_no' => $veh_argh->arg_inv_no));

        if ($check > 0) {
            $msg = array('success' => false, 'message' => 'Sorry, this invoice cannot be deleted because it has detail(s). Please delete them first');
        } else {
            $this->all_m->deleteData($table, 'id', $id);
            $msg = array('success' => true, 'message' => 'Data has been deleted successfully');
        }

        $this->json($msg);
    }

    function save_argd() {
        $arg_inv_no = $this->uri->segment(4);
        $data = $this->input->post();
        $table = $this->input->post('table2');
        $veh_argh = $this->all_m->getId('veh_argh', 'arg_inv_no', $arg_inv_no);
        $veh_arh = $this->all_m->getId('veh_arh', 'sal_inv_no', $data['sal_inv_no']);

        $stat = true;

        $checkard = $this->all_m->countlimit($table, array('sal_inv_no' => $data['sal_inv_no'], 'arg_inv_no' => $arg_inv_no));

        $checkarh = $this->all_m->countlimit('veh_arh', array('sal_inv_no' => $data['sal_inv_no']));

        $sal_date = $this->dateFormat($data['sal_date']);

        if (intval(strtotime($veh_argh->pay_date)) < intval(strtotime($sal_date))) {
            $stat = false;
            $msg = array('success' => false, 'message' => 'Sorry, Payment Date has to be the same with Sales Date');
        }

        if ($checkard > 0) {
            $msg = array('success' => false, 'message' => 'Sale invoice no. ' . $data['sal_inv_no'] . ' and Chassis no. ' . $data['chassis'] . ' has been used');
            $stat = false;
        }

        if ($checkarh < 1) {
            $msg = array('success' => false, 'message' => 'Failed to add detail');
            $stat = false;
        }


        if ($stat !== false) {

            $sql_argd = "SHOW COLUMNS FROM $table";
            $veh_argd = $this->all_m->query_all($sql_argd);

            foreach ($veh_argd as $argd) {
                $field_argd[$argd->Field] = '';
            }
            unset($field_argd['id']);


            foreach ($veh_arh as $k => $v) {

                if (array_key_exists($k, $field_argd)) {
                    $key[] = $k;
                    $val[] = $v;
                }
            }

            $newdata_argd = array_combine($key, $val);
            $newdata_argd['arg_inv_no'] = $arg_inv_no;
            $newdata_argd['arg_date'] = date('Y-m-d');

            $newdata_argd['pd_paid'] = $data['pd_paid'];
            $newdata_argd['pd_disc'] = $data['pd_disc'];
            $newdata_argd['pd_end'] = $veh_arh->pd_end - $data['pd_paid'] - $data['pd_disc'];
            $newdata_argd['pd_begin'] = $veh_arh->pd_end;
            //$newdata_argd['pd_end'] = $data['pd_end'];
            //$newdata_argd['pd_begin'] = $data['pd_begin'];


            if (!empty($data['sal_date'])) {
                $newdata_argd['sal_date'] = $this->dateFormat($data['sal_date']);
            }
            if (!empty($data['so_date'])) {
                $newdata_argd['so_date'] = $this->dateFormat($data['so_date']);
            }



            if ($veh_argh) {
                $data_argh = array(
                    'tot_item' => $veh_argh->tot_item + 1,
                    'tot_disc' => $veh_argh->tot_disc + $data['pd_disc'],
                    'tot_paid' => $veh_argh->tot_paid + $data['pd_paid']
                );


                $this->all_m->updateData('veh_argh', 'arg_inv_no', $arg_inv_no, $data_argh);
                $this->all_m->insertData($table, $newdata_argd);
                $msg = array('success' => true, 'message' => 'Record saved', 'status' => 'save');
            } else {
                $msg = array('success' => false, 'message' => 'Failed to add detail');
            }
        } else {
            $msg = $msg;
        }
        $this->json($msg);
    }

    function delete_detail() {
        $table = $this->input->post('table');
        $id = $this->input->post('id');

        $veh_argd = $this->all_m->getId($table, 'id', $id);

        if ($veh_argd) {

            $count = $this->all_m->countlimit('veh_argh', array('arg_inv_no' => $veh_argd->arg_inv_no));

            if ($count > 0) {
                $veh_argh = $this->all_m->getId('veh_argh', 'arg_inv_no', $veh_argd->arg_inv_no);
                $data_argh = array(
                    'tot_item' => $veh_argh->tot_item - 1,
                    'tot_disc' => $veh_argh->tot_disc - $veh_argd->pd_disc,
                    'tot_paid' => $veh_argh->tot_paid - $veh_argd->pd_paid
                );

                $this->all_m->updateData('veh_argh', 'id', $veh_argh->id, $data_argh);
                $this->all_m->deleteData($table, 'id', $id);
                $msg = array('status' => true, 'message' => 'Detail has been deleted successfully');
            } else {
                $msg = array('status' => false, 'message' => 'Failed to delete detail');
            }
        } else {
            $msg = array('status' => false, 'message' => 'Failed to delete detail');
        }
        $this->json($msg);
    }

    function saveHutangGabungan() {

        $data = $this->input->post();

        $table = $this->input->post('table');
        $id = $this->input->post('id');
        $date = date('Y-m-d');

        unset($data['table']);
        unset($data['id']);
        unset($data['cls_date']);

        if (!empty($data['apg_date'])) {
            $data['apg_date'] = $this->dateFormat($data['apg_date']);
        }
        if (!empty($data['opn_date'])) {
            $data['opn_date'] = $this->dateFormat($data['opn_date']);
        }
        if (!empty($data['apv_date'])) {
            $data['apv_date'] = $this->dateFormat($data['apv_date']);
        }
        if (!empty($data['pay_date'])) {
            $data['pay_date'] = $this->dateFormat($data['pay_date']);
        }
        if (!empty($data['check_date'])) {
            $data['check_date'] = $this->dateFormat($data['check_date']);
        }
        if (!empty($data['due_date'])) {
            $data['due_date'] = $this->dateFormat($data['due_date']);
        }

        if (intval(strtotime($data['pay_date'])) <> intval(strtotime($date))) {
            $msg = array('status' => false, 'message' => 'Sorry, Payment Date has to be the same with today\'s date');
        }
        if ($data['check_no'] == '') {
            $msg = array('status' => false, 'message' => 'Please input Cheque No.');
        }
        if ($data['pay_type'] == '') {
            $msg = array('status' => false, 'message' => 'Please input Payment Type');
        }
        if ($data['supp_code'] == '') {
            $msg = array('status' => false, 'message' => 'Please input Supplier code');
        }
        if ($data['wrhs_code'] == '') {
            $msg = array('status' => false, 'message' => 'Please input Warehouse');
        }

        if ($table == 'acc_apgh') {
            $data['paid2_code'] = $data['supp_code'];
            $data['paid2_name'] = $data['supp_name'];

            unset($data['supp_code']);
            unset($data['supp_name']);
            $inv_type = 'APG';
        } else {
            $inv_type = 'VPG';
        }

        if ($msg['status'] !== false) {

            if ($id !== '') {
                $this->all_m->updateData($table, 'id', $id, $data);
                $msg = array('success' => true, 'message' => 'Record updated ', 'status' => 'update');
                $this->updateLocked($table, $id);
            } else {
                unset($data['apg_inv_no']);
                $data['apg_inv_no'] = $this->all_m->inv_seq('4', $inv_type);
                $this->all_m->insertData($table, $data);

                $inv_seq = $this->all_m->getOne('inv_seq', array('inv_type' => $inv_type));
                $this->all_m->updateData('inv_seq', 'id', $inv_seq->id, array('inv_no' => $inv_seq->inv_no + 1));

                $msg = array('success' => true, 'message' => 'Record saved', 'status' => 'save');
            }
        } else {
            $status = $msg;
        }


        $this->json($msg);
    }

    function save_apgd() {
        $C_USER = $this->uri->segment(5);
        $apg_inv_no = $this->uri->segment(4);
        $data = $this->input->post();
        $table = $this->input->post('table2');


        if ($this->uri->segment(6)) {
            $aph = 'acc_aph';
            $prh = 'acc_prh';
            $apgh = 'acc_apgh';
        } else {
            $aph = 'veh_aph';
            $prh = 'veh_prh';
            $apgh = 'veh_apgh';
        }
        // echo $aph;exit;

        $veh_aph = $this->all_m->getId($aph, 'pur_inv_no', $data['pur_inv_no']);
        $veh_prh = $this->all_m->getId($prh, 'pur_inv_no', $data['pur_inv_no']);
        $veh_apgh = $this->all_m->getId($apgh, 'apg_inv_no', $apg_inv_no);

        $stat = true;

        $check = $this->all_m->countlimit($table, array('pur_inv_no' => $data['pur_inv_no'], 'apg_inv_no' => $apg_inv_no));

        $count = $this->all_m->countlimit($aph, array('pur_inv_no' => $data['pur_inv_no']));

        $count2 = $this->all_m->countlimit($apgh, array('apg_inv_no' => $apg_inv_no));

        $pur_date = $this->dateFormat($data['pur_date']);

        if (intval(strtotime($veh_apgh->pay_date)) < intval(strtotime($pur_date))) {
            $stat = false;
            $msg = array('success' => false, 'message' => 'Sorry, Payment Date has to be the same with Purchase Date');
        }

        if ($check > 0) {
            $stat = false;
            $msg = array('success' => false, 'message' => 'Purchase Invoice no. ' . $data['pur_inv_no'] . ' and Chassis No. ' . $data['chassis'] . ' already exist');
        }

        if ($count < 1) {
            $stat = false;
            $msg = array('success' => false, 'message' => 'Failed to add detail');
        }

        if ($count2 < 1) {
            $stat = false;
            $msg = array('success' => false, 'message' => 'Failed to add detail');
        }


        if ($stat !== false) {

            $sql_apgd = "SHOW COLUMNS FROM $table";
            $veh_apgd = $this->all_m->query_all($sql_apgd);

            foreach ($veh_apgd as $apgd) {
                $field_apgd[$apgd->Field] = '';
            }
            unset($field_apgd['id']);

            foreach ($veh_aph as $k => $v) {

                if (array_key_exists($k, $field_apgd)) {
                    $key[] = $k;
                    $val[] = $v;
                }
            }

            $newdata_apgd = array_combine($key, $val);
            $newdata_apgd['apg_inv_no'] = $apg_inv_no;
            $newdata_apgd['apg_date'] = date('Y-m-d');
            $newdata_apgd['hd_paid'] = $data['hd_paid'];
            $newdata_apgd['hd_disc'] = $data['hd_disc'];
            $newdata_apgd['hd_begin'] = $veh_aph->hd_end;

            $newdata_apgd['supp_invdt'] = $veh_prh->supp_invdt;
            $newdata_apgd['supp_invno'] = $veh_prh->supp_invno;

            $newdata_apgd['add_by'] = $C_USER;
            $newdata_apgd['add_date'] = date('Y-m-d');


            if ($table == 'veh_apgd') {
                $newdata_apgd['veh_brand'] = $veh_prh->veh_brand;
                $newdata_apgd['veh_type'] = $veh_prh->veh_type;
                $newdata_apgd['veh_model'] = $veh_prh->veh_model;
                $newdata_apgd['veh_year'] = $veh_prh->veh_year;
                $newdata_apgd['veh_transm'] = $veh_prh->veh_transm;
            }

            if (!empty($data['pur_date'])) {
                $newdata_apgd['pur_date'] = $this->dateFormat($data['pur_date']);
            }
            if (!empty($data['po_date'])) {
                $newdata_apgd['po_date'] = $this->dateFormat($data['po_date']);
            }
            if (!empty($data['apv_date'])) {
                $newdata_apgd['apv_date'] = $this->dateFormat($data['apv_date']);
            }

            //print_r($newdata_apgd);exit;
            //$veh_aph
            //$newdata_apgd['hd_end'] = (intval($data['hd_begin']) - intval($data['hd_paid'])) - intval($data['hd_disc']);
            $newdata_apgd['hd_end'] = (intval($veh_aph->hd_end) - intval($data['hd_paid'])) - intval($data['hd_disc']);


            $data_apgh = array(
                'tot_item' => $veh_apgh->tot_item + 1,
                'tot_disc' => $veh_apgh->tot_disc + $data['hd_disc'],
                'tot_paid' => $veh_apgh->tot_paid + $data['hd_paid']
            );

            //$this->all_m->updateData('veh_aph', 'id', $veh_aph, array('apg_inv_no'=>$apg_inv_no));
            $this->all_m->updateData($apgh, 'apg_inv_no', $apg_inv_no, $data_apgh);
            $this->all_m->insertData($table, $newdata_apgd);
            $msg = array('success' => true, 'message' => 'Record saved', 'status' => 'save');
        } else {
            $msg = $msg;
        }
        $this->json($msg);
    }

    function delete_apgd() {

        $table = $this->input->post('table');
        $id = $this->input->post('id');

        $apgd = $this->all_m->getId($table, 'id', $id);

        if ($this->uri->segment(4)) {
            $apgh = 'acc_apgh';
        } else {
            $apgh = 'veh_apgh';
        }

        $stat = false;
        $check = $this->all_m->countlimit($table, array('id' => $id));
        $checkapgh = $this->all_m->countlimit($apgh, array('apg_inv_no' => $apgd->apg_inv_no));

        $msg = array('status' => false, 'message' => 'Failed to delete detail');

        if ($check > 0) {
            $stat = true;
        }
        if ($checkapgh > 0) {
            $stat = true;
        }


        if ($stat > 0) {

            $d_apgh = $this->all_m->getId($apgh, 'apg_inv_no', $apgd->apg_inv_no);
            $data_apgh = array(
                'tot_item' => $d_apgh->tot_item - 1,
                'tot_disc' => $d_apgh->tot_disc - $apgd->hd_disc,
                'tot_paid' => $d_apgh->tot_paid - $apgd->hd_paid
            );

            $this->all_m->updateData($apgh, 'id', $d_apgh->id, $data_apgh);
            $this->all_m->deleteData($table, 'id', $id);
            $msg = array('status' => true, 'message' => 'Detail has been deleted successfully');
        } else {
            $msg = $msg;
        }

        $this->json($msg);
    }

    function deleteHutangGabungan() {
        $table = $this->input->post('table');
        $id = $this->input->post('id');

        $veh_apgh = $this->all_m->getId($table, 'id', $id);
        //$veh_argd = $this->all_m->getWhere($table, array('arg_inv_no' => $veh_argh->arg_inv_no));

        $check = $this->all_m->check('veh_apgd', array('apg_inv_no' => $veh_apgh->apg_inv_no));

        if ($check > 0) {
            $msg = array('success' => false, 'message' => 'Sorry, this invoice cannot be deleted because it has detail(s). Please delete them first');
        } else {
            $this->all_m->deleteData($table, 'id', $id);
            $msg = array('success' => true, 'message' => 'Data has been deleted successfully');
        }

        $this->json($msg);
    }

    function closeHutangGabungan() {
        $user = $this->uri->segment(4);
        $data = $this->input->post();
        $tbl = $this->input->post('table');
        $id = $this->input->post('id');
        //$date = date('d/m/Y');
        $date = date('Y-m-d');
        unset($data['id']);
        unset($data['table']);

        if ($tbl == 'acc_apgh') {
            $tbl_apgd = 'acc_apgd';
            $tbl_aph = 'acc_aph';
            $tbl_apd = 'acc_apd';
        } else {
            $tbl_apgd = 'veh_apgd';
            $tbl_aph = 'veh_aph';
            $tbl_apd = 'veh_apd';
        }

        $periode = $this->checkPeriode();

        if ($periode == 'false') {
            $msg = $this->msgNotClose();
            $msg['status'] = false;
        }

        $check = $this->all_m->check($tbl_apgd, array('apg_inv_no' => $data['apg_inv_no']));


        $pay_date = $this->dateFormat($data['pay_date']);

        if (intval(strtotime($pay_date)) <> intval(strtotime($date))) {
            $msg = array('status' => false, 'message' => 'Sorry, Payment Date has to be the same with today\'s date');
        }

        if ($check < 1) {
            $msg = array('status' => false, 'message' => 'Unable to close this invoice because there is no Detail. Please input some Detail(s)');
        }

        $veh_apgh = $this->all_m->getId($tbl, 'id', $id);
        $veh_apgd = $this->all_m->getWhere($tbl_apgd, array('apg_inv_no' => $veh_apgh->apg_inv_no));

        foreach ($veh_apgd as $apgd) {
            if (intval(strtotime($apgd->pur_date)) > intval(strtotime(date('Y-m-d')))) {
                $msg = array('status' => false, 'message' => 'Sorry, There is a payment Invoice date that is greater than today\'s date');
            }

            $check_apgd = $this->all_m->countlimit($tbl_apgd, array('pur_inv_no' => $apgd->pur_inv_no, "check_no" => $veh_apgh->check_no));

            if ($check_apgd > 0) {
                $no_inv = $apgd->po_no . ' ';
            }
            $countard += $check_apgd;
        }

        if ($countard > 0) {
            $msg = array('status' => false, 'message' => 'Sorry, Duplicate Check No : ' . $veh_apgh->check_no . ' in Account Payable Payment Invoice No. ' . $no_inv);
        }
        //echo intval(strtotime(date('Y-m-d')));exit;
        if ($msg['status'] !== false) {

            $check = $this->all_m->check($tbl, array('apg_inv_no' => $veh_apgh->apg_inv_no));

            foreach ($veh_apgd as $apgd) {
                $data_apd = array(
                    'pur_inv_no' => $apgd->pur_inv_no,
                    'pur_date' => $apgd->pur_date,
                    'bank_code' => $veh_apgh->bank_code,
                    'pay_date' => $veh_apgh->pay_date,
                    'pay_type ' => $veh_apgh->pay_type,
                    'check_no' => $veh_apgh->check_no,
                    'check_date' => $veh_apgh->check_date,
                    'due_date ' => $veh_apgh->due_date,
                    'pay_val' => $apgd->hd_paid,
                    'disc_val' => $apgd->hd_disc,
                    'pay_desc' => $veh_apgh->pay_desc,
                    'coll_code' => $veh_apgh->coll_code,
                    'add_by ' => $user,
                    'add_date' => date('Y-m-d'),
                    'ref_no' => $veh_apgh->ref_no,
                    'ref_date' => $veh_apgh->ref_date,
                    'link_no' => $veh_apgh->link_no,
                    //'edc_code' => $veh_apgh->edc_code,
                    //'apv_inv_no' => $apgd->apv_inv_no,
                    //'apv_date' => $apgd->apv_date,
                    'apg_inv_no' => $apgd->apg_inv_no,
                    'apg_date' => date('Y-m-d'),
                );

                if ($tbl == 'veh_apgh') {
                    $data_apd['edc_code'] = $veh_apgh->edc_code;
                    $data_apd['apv_inv_no'] = $veh_apgh->apv_inv_no;
                    $data_apd['apv_date'] = $veh_apgh->apv_date;
                }

                $this->all_m->insertData($tbl_apd, $data_apd);

                $veh_aph = $this->all_m->getId($tbl_aph, 'pur_inv_no', $apgd->pur_inv_no);

                $hd_paid = $veh_aph->hd_paid + $apgd->hd_paid;
                $hd_disc = $veh_aph->hd_disc + $apgd->hd_disc;


                $data_aph = array(
                    // 'inv_total' => $veh_aph->inv_total + $apgd->inv_total,
                    // 'pd_begin' => $veh_aph->pd_begin + $apgd->pd_begin,
                    'hd_paid' => $veh_aph->hd_paid + $apgd->hd_paid,
                    'hd_disc' => $veh_aph->hd_disc + $apgd->hd_disc,
                    'hd_end' => intval($veh_aph->hd_begin) - intval($hd_paid) - intval($hd_disc)
                );

                $this->all_m->updateData($tbl_aph, 'pur_inv_no', $apgd->pur_inv_no, $data_aph);

                $this->all_m->updateData($tbl_apgd, 'id', $apgd->id, array('apg_date' => date('Y-m-d')));
            }

            $veh_apgh = $this->all_m->getId($tbl, 'id', $id);
            $data_apgh = array(
                'apg_date' => date('Y-m-d'),
                'cls_date' => date('Y-m-d'),
                'cls_by' => $user,
                'cls_cnt' => $veh_apgh->cls_cnt + 1
            );

            $this->all_m->updateData($tbl, 'id', $id, $data_apgh);
            $msg = array('success' => true);
        } else {
            $res = $msg;
        }

        $this->json($msg);
    }

    function uncloseHutangGabungan() {
        $user = $this->uri->segment(4);
        $data = $this->input->post();
        $tbl = $this->input->post('table');
        $id = $this->input->post('id');
        $date = date('Y-m-d');

        unset($data['id']);
        unset($data['table']);

        if ($tbl == 'acc_apgh') {
            $tbl_apgd = 'acc_apgd';
            $tbl_aph = 'acc_aph';
            $tbl_apd = 'acc_apd';
        } else {
            $tbl_apgd = 'veh_apgd';
            $tbl_aph = 'veh_aph';
            $tbl_apd = 'veh_apd';
        }


        $periode = $this->checkPeriode();

        if ($periode == 'false') {
            $msg = $this->msgNotUnClose();
            $msg['status'] = false;
        }

        $pay_date = $this->dateFormat($data['pay_date']);
        if (strtotime($pay_date) <> strtotime($date)) {
            $msg = array('status' => false, 'message' => 'Sorry, Payment Date has to be the same with today\'s date');
        }


        $check = $this->all_m->check($tbl_apgd, array('apg_inv_no' => $data['apg_inv_no']));


        if ($msg['status'] !== false) {
            $veh_apgh = $this->all_m->getId($tbl, 'id', $id);

            $check = $this->all_m->check($tbl, array('apg_inv_no' => $veh_apgh->apg_inv_no));

            $veh_apgd = $this->all_m->getWhere($tbl_apgd, array('apg_inv_no' => $veh_apgh->apg_inv_no));



            foreach ($veh_apgd as $apgd) {

                $data_apd = array(
                    "pur_inv_no" => $apgd->pur_inv_no,
                    "apg_inv_no" => $apgd->apg_inv_no,
                );

                $veh_apd = $this->all_m->getOne($tbl_apd, $data_apd);

                $veh_aph = $this->all_m->getId($tbl_aph, 'pur_inv_no', $apgd->pur_inv_no);

                $hd_paid = $veh_aph->hd_paid - $apgd->hd_paid;
                $hd_disc = $veh_aph->hd_disc - $apgd->hd_disc;

                $data_aph = array(
                    // 'inv_total' => $veh_aph->inv_total + $apgd->inv_total,
                    // 'pd_begin' => $veh_aph->pd_begin + $apgd->pd_begin,
                    'hd_paid' => $veh_aph->hd_paid - $apgd->hd_paid,
                    'hd_disc' => $veh_aph->hd_disc - $apgd->hd_disc,
                    'hd_end' => $veh_aph->hd_begin - $hd_paid - $hd_disc
                );

                $this->all_m->updateData($tbl_aph, 'pur_inv_no', $apgd->pur_inv_no, $data_aph);

                $check = $this->all_m->countlimit($tbl_apd, $data_apd);

                if ($check > 0) {
                    $this->all_m->deleteData($tbl_apd, 'id', $veh_apd->id);
                }

                $this->all_m->updateData($tbl_apgd, 'id', $apgd->id, array('apg_date' => ''));
            }

            $data_apgh = array(
                'apg_date' => '',
                'cls_date' => '',
                'cls_by' => '',
                'cls_cnt' => 0
            );

            $this->all_m->updateData($tbl, 'id', $id, $data_apgh);
            $msg = array('success' => true);
        } else {
            $res = $msg;
        }

        $this->json($msg);
    }

    function saveBatalUangJaminan() {
        $user = $this->uri->segment(4);
        $table = $this->input->post('table');
        $id = $this->input->post('id');
        $post = $this->input->post();

        unset($post['table']);
        unset($post['id']);
        unset($post['cls_by']);
        unset($post['cls_date']);
        unset($post['inv_rval']);

        $opn_date = $this->dateFormat($post['opn_date']);
        $dp_date = $this->dateFormat($post['dp_date']);

        $stat = true;
        $count = $this->all_m->countlimit('veh_dpch', array('dp_inv_no' => $post['dp_inv_no']));

        if (intval(strtotime($opn_date)) < intval(strtotime($dp_date))) {
            $stat = false;
            $msg = array('status' => false, 'message' => 'Sorry, Invoice Date should not be under with DP Date');
        }

        if ($count < 1) {
            $stat = false;
            $msg = array('status' => false, 'message' => 'Data not saved');
        }

        if ($post['check_no'] == '') {
            $stat = false;
            $msg = array('status' => false, 'message' => 'Please input Cheque No.');
        }
        if ($post['pay_type'] == '') {
            $stat = false;
            $msg = array('status' => false, 'message' => 'Please input Payment Type');
        }

        if ($stat !== false) {

            $sql_dpcch = "SHOW COLUMNS FROM $table";
            $veh_dpcch = $this->all_m->query_all($sql_dpcch);

            foreach ($veh_dpcch as $dpcch) {
                $field_dpcch[$dpcch->Field] = '';
            }
            unset($field_dpcch['id']);

            $veh_dpch = $this->all_m->getId('veh_dpch', 'dp_inv_no', $post['dp_inv_no']);
            foreach ($veh_dpch as $k => $v) {

                if (array_key_exists($k, $field_dpcch)) {
                    $key[] = $k;
                    $val[] = $v;
                }
            }

            $data = array_combine($key, $val);

            unset($data['cls_by']);
            unset($data['cls_date']);
            unset($data['cls_cnt']);

            $data['note'] = $this->input->post('note');
            $data['cust_code'] = $this->input->post('cust_code');
            $data['cust_name'] = $this->input->post('cust_name');
            $data['inv_total'] = 0;
            $data['add_by'] = $user;
            $data['add_date'] = date('Y-m-d');
            $data['bank_code'] = $this->input->post('bank_code');
            $data = $post;

            if (!empty($post['dpc_date'])) {
                $data['dpc_date'] = $this->dateFormat($post['dpc_date']);
            }
            if (!empty($post['opn_date'])) {
                $data['opn_date'] = $this->dateFormat($post['opn_date']);
            }
            if (!empty($post['dp_date'])) {
                $data['dp_date'] = $this->dateFormat($post['dp_date']);
            }
            if (!empty($post['so_date'])) {
                $data['so_date'] = $this->dateFormat($post['so_date']);
            }
            if (!empty($post['pay_date'])) {
                $data['pay_date'] = $this->dateFormat($post['pay_date']);
            }
            if (!empty($post['check_date'])) {
                $data['check_date'] = $this->dateFormat($post['check_date']);
            }
            if (!empty($post['due_date'])) {
                $data['due_date'] = $this->dateFormat($post['due_date']);
            }
            if (!empty($post['cls_date'])) {
                $data['cls_date'] = $this->dateFormat($post['cls_date']);
            }


            if ($id !== '') {
                $this->all_m->updateData($table, 'id', $id, $data);
                $msg = array('success' => true, 'message' => 'Record updated ', 'status' => 'update');
                $this->updateLocked($table, $id);
            } else {
                unset($data['dpc_inv_no']);

                $data['dpc_inv_no'] = $this->all_m->inv_seq('4', 'VRD');
                $check = $this->all_m->insertData($table, $data);
                $inv_seq = $this->all_m->getOne('inv_seq', array('inv_type' => 'VRD'));
                $this->all_m->updateData('inv_seq', 'id', $inv_seq->id, array('inv_no' => $inv_seq->inv_no + 1));

                $msg = array('success' => true, 'message' => 'Record saved', 'status' => 'save');
            }
        } else {
            $msg = $msg;
        }

        $this->json($msg);
    }

    function save_vehdpccd() {
        $data = $this->input->post();
        $dpc_inv_no = $this->uri->segment(4);
        $dp_inv_no = $this->uri->segment(5);
		 $user = $this->uri->segment(6);
        $data = $this->input->post();
        $table = $this->input->post('table2');
        $date = date('Y-m-d');
        unset($data['id2']);
        unset($data['table2']);

        $stat = true;


        $check = $this->all_m->countlimit($table, array('dp_inv_no' => $dp_inv_no, 'dpc_inv_no' => $dpc_inv_no, 'check_no' => $data['check_no']));
        $count = $this->all_m->countlimit('veh_dpcd', array('dp_inv_no' => $dp_inv_no, 'check_no' => $data['check_no']));
        $count2 = $this->all_m->countlimit('vehdpcch', array('dpc_inv_no' => $dpc_inv_no));

        $veh_dpcd = $this->all_m->getOne('veh_dpcd', array('dp_inv_no' => $dp_inv_no, 'check_no' => $data['check_no']));


        $periode = $this->checkPeriode();

        if ($periode == 'false') {
            $stat = false;
            $msg = array('success' => false, 'message' => 'Sorry, Downpayment Cancellation can not be add before the current period');
        }

        if (intval(strtotime($date)) < intval(strtotime($veh_dpcd->add_date))) {
            $stat = false;
            $msg = array('success' => false, 'message' => 'Sorry, Downpayment Cancellation can not be add before the current period');
        }

        if ($veh_dpcd->sal_inv_no !== NULL) {
            $stat = false;
            $msg = array('success' => false, 'message' => 'Sorry, the DP It\'s been used');
        }

        if ($check > 0) {
            $stat = false;
            $msg = array('success' => false, 'message' => 'Invoice No. ' . $dp_inv_no . ' has been used');
        }
        if ($count < 1) {
            $stat = false;
            $msg = array('success' => false, 'message' => 'Failed to add detail');
        }
        if ($count2 < 1) {
            $stat = false;
            $msg = array('success' => false, 'message' => 'Failed to add detail');
        }


        if ($stat !== false) {

            $sql_apgd = "SHOW COLUMNS FROM $table";
            $veh_apgd = $this->all_m->query_all($sql_apgd);

            foreach ($veh_apgd as $apgd) {
                $field_dpccd[$apgd->Field] = '';
            }
            unset($field_dpccd['id']);

            foreach ($veh_dpcd as $k => $v) {

                if (array_key_exists($k, $field_dpccd)) {
                    $key[] = $k;
                    $val[] = $v;
                }
            }

            $newdata_dpccd = array_combine($key, $val);
            $newdata_dpccd['dpc_inv_no'] = $dpc_inv_no;
            $newdata_dpccd['pay_deduct'] = $data['pay_deduct'];
            $newdata_dpccd['pay_deduc2'] = $data['pay_deduc2'];
            $newdata_dpccd['pay_rval'] = $data['pay_rval'];
            $newdata_dpccd['add_date'] = $date;
			$newdata_dpccd['add_by'] = $user;
			

            if (!empty($data['check_date'])) {
                $newdata_dpccd['check_date'] = $this->dateFormat($data['check_date']);
            }
            if (!empty($data['due_date'])) {
                $newdata_dpccd['due_date'] = $this->dateFormat($data['due_date']);
            }
            if (!empty($data['pay_date'])) {
                $newdata_dpccd['pay_date'] = $this->dateFormat($data['pay_date']);
            }



            $dpcch = $this->all_m->getId('vehdpcch', 'dpc_inv_no', $dpc_inv_no);
            $dpch = $this->all_m->getId('veh_dpch', 'dp_inv_no', $dp_inv_no);
			
			$inv_at = $dpcch->inv_at + $newdata_dpccd['pay_val'];
			$inv_bt = $inv_at / 1.1;
            $inv_vat = $inv_bt * 0.1;
			
            $data_dpcch = array(
                'inv_at' => $inv_at,
				'inv_bt' =>  $inv_bt,
				'inv_vat' => $inv_vat,
                'inv_deduct' => $dpcch->inv_deduct + $newdata_dpccd['pay_deduct'],
                'inv_deduc2' => $dpcch->inv_deduc2 + $newdata_dpccd['pay_deduc2'],
                'inv_total' => $dpcch->inv_total + $newdata_dpccd['pay_rval'],
            );

            $data_dpcd = array(
                'sal_inv_no' => $dpc_inv_no
            );

            $dp_used = $dpch->dp_used + $newdata_dpccd['pay_val'];
            $data_dpch = array(
                'dp_used' => $dp_used,
                'dp_end' => ($dpch->dp_begin + $dpch->dp_paid) - $dp_used
            );


            $this->all_m->updateData('vehdpcch', 'dpc_inv_no', $dpc_inv_no, $data_dpcch);
            $this->all_m->updateData('veh_dpcd', 'id', $veh_dpcd->id, $data_dpcd);
            $this->all_m->updateData('veh_dpch', 'dp_inv_no', $dp_inv_no, $data_dpch);

            $this->all_m->insertData($table, $newdata_dpccd);
            $msg = array('success' => true, 'message' => 'Record saved', 'status' => 'save');
        } else {
            $msg = $msg;
        }
        $this->json($msg);
    }

    function deletePembatalanUJ() {
        $table = $this->input->post('table');
        $id = $this->input->post('id');

        $vehdpcch = $this->all_m->getId($table, 'id', $id);
        //$veh_argd = $this->all_m->getWhere($table, array('arg_inv_no' => $veh_argh->arg_inv_no));

        $check = $this->all_m->check('vehdpccd', array('dpc_inv_no' => $vehdpcch->dpc_inv_no));

        if ($check > 0) {
            $msg = array('success' => false, 'message' => 'Sorry, this invoice cannot be deleted because it has detail(s). Please delete them first');
        } else {
            $this->all_m->deleteData($table, 'id', $id);
            $msg = array('success' => true, 'message' => 'Data has been deleted successfully');
        }

        $this->json($msg);
    }

    function delete_vehdpccd() {
        $table = $this->input->post('table');
        $id = $this->input->post('id');

        $count = $this->all_m->countlimit($table, array('id' => $id));

        if ($count > 0) {

            $vehdpccd = $this->all_m->getId($table, 'id', $id);

            $dpc_inv_no = $vehdpccd->dpc_inv_no;
            $dp_inv_no = $vehdpccd->dp_inv_no;

            $veh_dpcd = $this->all_m->getOne('veh_dpcd', array('dp_inv_no' => $dp_inv_no, 'check_no' => $vehdpccd->check_no));
            $dpch = $this->all_m->getId('veh_dpch', 'dp_inv_no', $dp_inv_no);
            $dpcch = $this->all_m->getId('vehdpcch', 'dpc_inv_no', $dpc_inv_no);


            $data_dpcch = array(
                'inv_at' => $dpcch->inv_at - $vehdpccd->pay_val,
                'inv_deduct' => $dpcch->inv_deduct - $vehdpccd->pay_deduct,
                'inv_deduc2' => $dpcch->inv_deduc2 - $vehdpccd->pay_deduc2,
                'inv_total' => $dpcch->inv_total - $vehdpccd->pay_rval
            );


            $data_dpcd = array(
                'sal_inv_no' => (NULL)
            );

            $dp_used = $dpch->dp_used - $vehdpccd->pay_val;
            $data_dpch = array(
                'dp_used' => $dp_used,
                'dp_end' => ($dpch->dp_begin + $dpch->dp_paid) + $dp_used
            );

            $this->all_m->updateData('vehdpcch', 'dpc_inv_no', $dpc_inv_no, $data_dpcch);
            $this->all_m->updateData('veh_dpcd', 'id', $veh_dpcd->id, $data_dpcd);
            $this->all_m->updateData('veh_dpch', 'dp_inv_no', $dp_inv_no, $data_dpch);

            $this->all_m->deleteData($table, 'id', $id);
            $msg = array('success' => true, 'message' => 'Record deleted', 'status' => 'delete');
        } else {
            $msg = array('success' => false, 'message' => 'delete failed!');
        }

        $this->json($msg);
    }

    function closeBatalUangJaminan() {
        $user = $this->uri->segment(4);
        $data = $this->input->post();
        $tbl = $this->input->post('table');
        $id = $this->input->post('id');
        $date = date('Y-m-d');

        $periode = $this->checkPeriode();
        $stat = true;

        if ($periode == 'false') {
            $msg = $this->msgNotClose();
        }

        if ($msg['success'] !== false) {
            $vehdpcch = $this->all_m->getId($tbl, 'id', $id);

            $check = $this->all_m->countlimit('vehdpccd', array('dpc_inv_no' => $vehdpcch->dpc_inv_no));

            if ($check < 1) {
                $stat = false;
                $msg = array('success' => false, 'message' => 'Unable to close this invoice because there is no Detail. Please input some Detail(s)');
            }

            if ($stat !== false) {



                $data_vehdpcch = array(
                    'dpc_date' => $date,
                    'cls_date' => $date,
                    'cls_by' => $user,
                    'cls_cnt' => $vehdpcch->cls_cnt + 1
                );

                $data_vehdpccd = array('dpc_date' => $date);

                $this->all_m->updateData($tbl, 'id', $id, $data_vehdpcch);
                $this->all_m->updateData('vehdpccd', 'dpc_inv_no', $vehdpcch->dpc_inv_no, $data_vehdpccd);
                $msg = array('success' => true, 'message' => 'close', 'status' => 'close');
            } else {
                $msg = $msg;
            }
        }
        $this->json($msg);
    }

    function uncloseBatalUangJaminan() {
        $user = $this->uri->segment(4);
        $data = $this->input->post();
        $tbl = $this->input->post('table');
        $id = $this->input->post('id');
        $date = '0000-00-00';

        $periode = $this->checkPeriode();

        if ($periode == 'false') {
            $msg = $this->msgNotUnClose();
        }

        if ($msg['success'] !== false) {

            $check = $this->all_m->countlimit($tbl, array('id' => $id));

            if ($check > 0) {

                $vehdpcch = $this->all_m->getId($tbl, 'id', $id);
                $data_vehdpcch = array(
                    'dpc_date' => $date,
                    'cls_date' => $date,
                    'cls_by' => ''
                );

                $data_vehdpccd = array('dpc_date' => $date);

                $this->all_m->updateData($tbl, 'id', $id, $data_vehdpcch);
                $this->all_m->updateData('vehdpccd', 'dpc_inv_no', $vehdpcch->dpc_inv_no, $data_vehdpccd);
                $msg = array('success' => true, 'message' => 'unclose', 'status' => 'unclose');
            } else {
                $msg = array('success' => false, 'message' => 'unclose failed!');
            }
        }

        $this->json($msg);
    }

    function saveVoucherKendaraan() {

        $data = $this->input->post();

        $table = $this->input->post('table');
        $id = $this->input->post('id');
        $date = date('Y-m-d');

        unset($data['table']);
        unset($data['id']);
        unset($data['cls_date']);

        if (!empty($data['apv_date'])) {
            $data['apv_date'] = $this->dateFormat($data['apv_date']);
        }
        if (!empty($data['opn_date'])) {
            $data['opn_date'] = $this->dateFormat($data['opn_date']);
        }
        if (!empty($data['pay_date'])) {
            $data['pay_date'] = $this->dateFormat($data['pay_date']);
        }
        if (!empty($data['check_date'])) {
            $data['check_date'] = $this->dateFormat($data['check_date']);
        }
        if (!empty($data['due_date'])) {
            $data['due_date'] = $this->dateFormat($data['due_date']);
        }

        if (intval(strtotime($data['pay_date'])) <> intval(strtotime($date))) {
            $msg = array('status' => false, 'message' => 'Sorry, Payment Date has to be the same with today\'s date');
        }
        if ($data['check_no'] == '') {
            $msg = array('status' => false, 'message' => 'Please input Cheque No.');
        }
        if ($data['pay_type'] == '') {
            $msg = array('status' => false, 'message' => 'Please input Payment Type');
        }
        if ($data['supp_code'] == '') {
            $msg = array('status' => false, 'message' => 'Please input Supplier code');
        }
        if ($data['wrhs_code'] == '') {
            $msg = array('status' => false, 'message' => 'Please input Warehouse');
        }

        if ($msg['status'] !== false) {

            if ($id !== '') {
                $this->all_m->updateData($table, 'id', $id, $data);
                $msg = array('success' => true, 'message' => 'Record updated ', 'status' => 'update');
                $this->updateLocked($table, $id);
            } else {
                unset($data['apv_inv_no']);
                $data['apv_inv_no'] = $this->all_m->inv_seq('4', 'VPV');
                $this->all_m->insertData($table, $data);

                $inv_seq = $this->all_m->getOne('inv_seq', array('inv_type' => 'VPV'));
                $this->all_m->updateData('inv_seq', 'id', $inv_seq->id, array('inv_no' => $inv_seq->inv_no + 1));

                $msg = array('success' => true, 'message' => 'Record saved', 'status' => 'save');
            }
        } else {
            $status = $msg;
        }


        $this->json($msg);
    }

    function save_acc_apd() {
        $user = $this->uri->segment(5);
        $pur_inv_no = $this->uri->segment(4);

        $table = $this->input->post('table2');
        $id = $this->input->post('id2');
        $data = $this->input->post();

        unset($data['table2']);
        unset($data['id2']);

        $check_no = $data['check_no'];

        $checkapd = $this->all_m->countlimit('acc_apd', array('pur_inv_no' => $pur_inv_no, 'check_no' => $check_no));

        $stat = true;

        if ($checkapd > 0) {
            $stat = false;
            $msg = array('status' => false, 'message' => 'Sorry, payment with Cheque No.: ' . $check_no . ' exists in this invoice');
        }

        if ($check_no == '') {
            $msg = array('status' => false, 'message' => 'Please input Cheque No.');
        }


        if ($msg['status'] !== false) {

            $acc_aph = $this->all_m->getId('acc_aph', 'pur_inv_no', $pur_inv_no);

            $hd_paid = $acc_aph->hd_paid + $data['pay_val'];
            $hd_disc = $acc_aph->hd_disc + $data['disc_val'];
            $hd_end = $acc_aph->hd_begin - $hd_paid - $hd_disc;

            $data_aph['hd_paid'] = $hd_paid;
            $data_aph['hd_disc'] = $hd_disc;
            $data_aph['hd_end'] = $hd_end;


            $data['pur_inv_no'] = $pur_inv_no;
            $data['add_by'] = $user;
			$data['add_date'] = date('Y-m-d');

            if (!empty($data['pay_date'])) {
                $data['pay_date'] = $this->dateFormat($data['pay_date']);
            }
            if (!empty($data['check_date'])) {
                $data['check_date'] = $this->dateFormat($data['check_date']);
            }
            if (!empty($data['due_date'])) {
                $data['due_date'] = $this->dateFormat($data['due_date']);
            }

            $this->all_m->updateData('acc_aph', 'id', $acc_aph->id, $data_aph);

            if ($id !== '') {
                $this->all_m->updateData($table, 'id', $id, $data);
                $msg = array('success' => true, 'message' => 'Record updated ', 'status' => 'update');
            } else {
                $this->all_m->insertData($table, $data);

                $msg = array('success' => true, 'message' => 'Record saved', 'status' => 'save');
            }
        } else {
            $status = $msg;
        }


        $this->json($msg);
    }

    function deleteAccApd() {
        $table = $this->input->post('table');
        $id = $this->input->post('id');

        $acc_apd = $this->all_m->getId('acc_apd', 'id', $id);

        $stat = false;
        $check = $this->all_m->countlimit('acc_apd', array('id' => $id));
        $checkaph = $this->all_m->countlimit('acc_aph', array('pur_inv_no' => $acc_apd->pur_inv_no));

        $msg = array('status' => false, 'message' => 'Failed to delete detail');

        if ($check > 0) {
            $stat = true;
        }
        if ($checkaph > 0) {
            $stat = true;
        }

        if (!empty($acc_apd->apg_inv_no)) {
            $stat = false;
            $msg = array('status' => false, 'message' => 'This payment can not be removed because it uses a combined payment with Invoice No. ' . $acc_apd->apg_inv_no);
        }

        if ($stat !== false) {

            $acc_aph = $this->all_m->getId('acc_aph', 'pur_inv_no', $acc_apd->pur_inv_no);

            $hd_paid = $acc_aph->hd_paid - $acc_apd->pay_val;
            $hd_disc = $acc_aph->hd_disc - $acc_apd->disc_val;
            $hd_end = $acc_aph->hd_begin - $hd_paid - $hd_disc;

            $data_aph['hd_paid'] = $hd_paid;
            $data_aph['hd_disc'] = $hd_disc;
            $data_aph['hd_end'] = $hd_end;

            $this->all_m->updateData('acc_aph', 'id', $acc_aph->id, $data_aph);
            $this->all_m->deleteData($table, 'id', $id);
            $msg = array('status' => true, 'message' => 'Detail has been deleted successfully');
        } else {
            $msg = $msg;
        }
        $this->json($msg);
    }

    function save_acc_ard() {
        $user = $this->uri->segment(5);
        $sal_inv_no = $this->uri->segment(4);

        $table = $this->input->post('table2');
        $id = $this->input->post('id2');
        $data = $this->input->post();

        unset($data['table2']);
        unset($data['id2']);

        $check_no = $data['check_no'];

        $checkard = $this->all_m->countlimit('acc_ard', array('sal_inv_no' => $sal_inv_no, 'check_no' => $check_no));

        $stat = true;

        if ($checkard > 0) {
            $stat = false;
            $msg = array('status' => false, 'message' => 'Sorry, payment with Cheque No.: ' . $check_no . ' exists in this invoice');
        }
        if ($check_no == '') {
            $stat = false;
            $msg = array('status' => false, 'message' => 'Please input Cheque No.');
        }


        if ($stat !== false) {

            $acc_arh = $this->all_m->getId('acc_arh', 'sal_inv_no', $sal_inv_no);

            $pd_paid = $acc_arh->pd_paid + $data['pay_val'];
            $pd_disc = $acc_arh->pd_disc + $data['disc_val'];
            $pd_end = $acc_arh->pd_begin - $pd_paid - $pd_disc;

            $data_arh['pd_paid'] = $pd_paid;
            $data_arh['pd_disc'] = $pd_disc;
            $data_arh['pd_end'] = $pd_end;


            $data['sal_inv_no'] = $sal_inv_no;
            $data['add_by'] = $user;
			$data['add_date'] = date('Y-m-d');

            if (!empty($data['pay_date'])) {
                $data['pay_date'] = $this->dateFormat($data['pay_date']);
            }
            if (!empty($data['check_date'])) {
                $data['check_date'] = $this->dateFormat($data['check_date']);
            }
            if (!empty($data['due_date'])) {
                $data['due_date'] = $this->dateFormat($data['due_date']);
            }

            $this->all_m->updateData('acc_arh', 'id', $acc_arh->id, $data_arh);

            if ($id !== '') {
                $this->all_m->updateData($table, 'id', $id, $data);
                $msg = array('success' => true, 'message' => 'Record updated ', 'status' => 'update');
            } else {
                $this->all_m->insertData($table, $data);

                $msg = array('success' => true, 'message' => 'Record saved', 'status' => 'save');
            }
        } else {
            $status = $msg;
        }


        $this->json($msg);
    }

    function deleteAccArd() {
        $table = $this->input->post('table');
        $id = $this->input->post('id');

        $acc_ard = $this->all_m->getId($table, 'id', $id);

        $stat = false;
        $check = $this->all_m->countlimit($table, array('id' => $id));
        $checkarh = $this->all_m->countlimit('acc_arh', array('sal_inv_no' => $acc_ard->sal_inv_no));

        if ($check > 0) {
            $stat = true;
        }
        if ($checkarh > 0) {
            $stat = true;
        }

        if ($stat !== false) {

            $acc_arh = $this->all_m->getId('acc_arh', 'sal_inv_no', $acc_ard->sal_inv_no);

            $pd_paid = $acc_arh->pd_paid - $acc_ard->pay_val;
            $pd_disc = $acc_arh->pd_disc - $acc_ard->disc_val;
            $pd_end = $acc_arh->pd_begin - $pd_paid - $pd_disc;

            $data_arh['pd_paid'] = $pd_paid;
            $data_arh['pd_disc'] = $pd_disc;
            $data_arh['pd_end'] = $pd_end;

            $this->all_m->updateData('acc_arh', 'id', $acc_arh->id, $data_arh);
            $this->all_m->deleteData($table, 'id', $id);
            $msg = array('status' => true, 'message' => 'Detail has been deleted successfully');
        } else {
            $msg = array('status' => false, 'message' => 'Failed to delete detail');
        }
        $this->json($msg);
    }

    function delete_ard() {
        $table = $this->input->post('table');
        $id = $this->input->post('id');

        $veh_ard = $this->all_m->getId($table, 'id', $id);
        $data = (array) $veh_ard;

        $date = date('Y-m-d');
        $stat = true;

        $msg = array('status' => false, 'message' => 'Failed to delete detail');

        if (intval(strtotime($date)) !== intval(strtotime($data['pay_date']))) {
            $stat = false;
            $msg = array('status' => false, 'message' => 'Sorry, This invoice can not be deleted');
        }
        if (!empty($data['arg_inv_no'])) {
            $msg = array('status' => false, 'message' => 'This payment can not be removed because it uses a combined payment with Invoice No. ' . $data['arg_inv_no']);
            $stat = false;
        }

        $check = $this->all_m->countlimit($table, array('id' => $id));
        $checkarh = $this->all_m->countlimit('veh_arh', array('sal_inv_no' => $data['sal_inv_no']));

        if ($check < 1) {
            $stat = false;
        }
        if ($checkarh < 1) {
            $stat = false;
        }

        if ($stat !== false) {

            $veh_arh = $this->all_m->getId('veh_arh', 'sal_inv_no', $data['sal_inv_no']);


            $pd_paid = $veh_arh->pd_paid - $veh_ard->pay_val;
            $pd_disc = $veh_arh->pd_disc - $veh_ard->disc_val;
            $total = $veh_arh->pd_begin - $pd_paid - $pd_disc;

            $dataarh['pd_paid'] = $pd_paid;
            $dataarh['pd_disc'] = $pd_disc;
            $dataarh['pd_end'] = $total;

            $dpcd = array(
                'check_no' => $veh_ard->check_no,
                'sal_inv_no' => $veh_ard->sal_inv_no,
                'dp_inv_no' => $veh_ard->dp_inv_no
            );

            $veh_dpcd = $this->all_m->getOne('veh_dpcd', $dpcd);

            $veh_dpch = $this->all_m->getId('veh_dpch', 'dp_inv_no', $veh_dpcd->dp_inv_no);

            $dp_paid = $veh_dpch->dp_paid;
            $dp_used = $veh_dpch->dp_used - $veh_dpcd->pay_val;
            $dp_end = $dp_paid - $dp_used;

            $datadpch = array(
                //'dp_paid' => $dp_paid,
                'dp_used' => $dp_used,
                'dp_end' => $dp_end
            );


            $this->all_m->updateData('veh_dpch', 'id', $veh_dpch->id, $datadpch);
            $this->all_m->updateData('veh_dpcd', 'id', $veh_dpcd->id, array('use_date' => NULL, 'used_val' => 0, 'sal_inv_no' => NULL));
            $this->all_m->updateData('veh_arh', 'id', $veh_arh->id, $dataarh);
            $this->all_m->deleteData($table, 'id', $id);
            $msg = array('status' => true, 'message' => 'Detail has been deleted successfully');
        }
        $this->json($msg);
    }

    function check_dp_spk() {
        $so_no = $this->input->post('so_no');

        $check = $this->all_m->countlimit('veh_dpch', array('so_no' => $so_no));

        if ($check > 0) {
            $dp = $this->all_m->getId('veh_dpch', 'so_no', $so_no);
            $count = array(
                'id' => $dp->id,
                'dp_inv_no' => $dp->dp_inv_no,
                'count' => $check
            );
        } else {
            $count = array('count' => $check);
        }
        $this->json($count);
    }

    function save_acc_aph() {

        $table = $this->input->post('table');
        $id = $this->input->post('id');
        $date = date('Y-m-d');


        $data['due_date'] = $this->input->post('due_date');
        $data['note'] = $this->input->post('note');

        /*
          if (!empty($data['pur_date'])) {
          $data['pur_date'] = $this->dateFormat($data['pur_date']);
          }
          if (!empty($data['opn_date'])) {
          $data['opn_date'] = $this->dateFormat($data['opn_date']);
          }
          if (!empty($data['due_date'])) {
          $data['due_date'] = $this->dateFormat($data['due_date']);
          }
          if (!empty($data['supp_invdate'])) {
          $data['supp_invdate'] = $this->dateFormat($data['supp_invdate']);
          }
          if (!empty($data['po_date'])) {
          $data['po_date'] = $this->dateFormat($data['po_date']);
          }
          if (!empty($data['so_date'])) {
          $data['so_date'] = $this->dateFormat($data['so_date']);
          }
         */
        if ($id !== '') {
            $this->all_m->updateData($table, 'id', $id, $data);
            $msg = array('success' => true, 'message' => 'Record updated ', 'status' => 'update');
        } else {

            $data['pur_inv_no'] = $this->all_m->inv_seq('4', 'APB');
            $this->all_m->insertData($table, $data);

            $inv_seq = $this->all_m->getOne('inv_seq', array('inv_type' => 'APB'));
            $this->all_m->updateData('inv_seq', 'id', $inv_seq->id, array('inv_no' => $inv_seq->inv_no + 1));

            $msg = array('success' => true, 'message' => 'Record saved', 'status' => 'save');
        }

        $this->json($msg);
    }

    function save_apvd() {
        $apv_inv_no = $this->uri->segment(4);
        $C_USER = $this->uri->segment(5);
        $data = $this->input->post();
        $table = $this->input->post('table2');

        // print_r($data);

        $check = $this->all_m->countlimit($table, array('pur_inv_no' => $data['pur_inv_no'], 'apv_inv_no' => $apv_inv_no));
        if ($check > 0) {
            $msg = array('success' => false, 'message' => 'Purchase Invoice no. ' . $data['pur_inv_no'] . ' and Chassis No. ' . $data['chassis'] . ' already exist');
        } else {
            $sql_apvd = "SHOW COLUMNS FROM $table";
            $veh_apvd = $this->all_m->query_all($sql_apvd);

            foreach ($veh_apvd as $apvd) {
                $field_apvd[$apvd->Field] = '';
            }
            unset($field_apvd['id']);

            $check1 = $this->all_m->countlimit('veh_aph', array('pur_inv_no' => $data['pur_inv_no']));

            if ($check1 > 0) {
                $veh_aph = $this->all_m->getId('veh_aph', 'pur_inv_no', $data['pur_inv_no']);
                $veh_prh = $this->all_m->getId('veh_prh', 'pur_inv_no', $data['pur_inv_no']);


                foreach ($veh_aph as $k => $v) {

                    if (array_key_exists($k, $field_apvd)) {
                        $key[] = $k;
                        $val[] = $v;
                    }
                }

                $newdata_apvd = array_combine($key, $val);
                $newdata_apvd['apv_inv_no'] = $apv_inv_no;
                $newdata_apvd['apv_date'] = date('Y-m-d');
                $newdata_apvd['hd_paid'] = $data['hd_paid'];
                $newdata_apvd['hd_disc'] = $data['hd_disc'];
                $newdata_apvd['hd_begin'] = $data['hd_begin'];

                $newdata_apvd['supp_invdt'] = $veh_prh->supp_invdt;
                $newdata_apvd['supp_invno'] = $veh_prh->supp_invno;
                $newdata_apvd['veh_brand'] = $veh_prh->veh_brand;
                $newdata_apvd['veh_type'] = $veh_prh->veh_type;
                $newdata_apvd['veh_model'] = $veh_prh->veh_model;
                $newdata_apvd['veh_year'] = $veh_prh->veh_year;
                $newdata_apvd['veh_transm'] = $veh_prh->veh_transm;
                $newdata_apvd['ref_no'] = $veh_prh->ref_no;
                $newdata_apvd['ref_date'] = $veh_prh->ref_date;
                $newdata_apvd['link_no'] = $veh_prh->link_no;
                $newdata_apvd['add_by'] = $C_USER;
                $newdata_apvd['add_date'] = date('Y-m-d');

                if (!empty($data['pur_date'])) {
                    $newdata_apvd['pur_date'] = $this->dateFormat($data['pur_date']);
                }
                if (!empty($data['po_date'])) {
                    $newdata_apvd['po_date'] = $this->dateFormat($data['po_date']);
                }
                if (!empty($data['apv_date'])) {
                    $newdata_apvd['apv_date'] = $this->dateFormat($data['apv_date']);
                }

                $newdata_apvd['hd_end'] = (intval($data['hd_begin']) - intval($data['hd_paid'])) - intval($data['hd_disc']);


                $check2 = $this->all_m->countlimit('veh_apvh', array('apv_inv_no' => $apv_inv_no));

                if ($check2 > 0) {

                    $veh_apvh = $this->all_m->getId('veh_apvh', 'apv_inv_no', $apv_inv_no);

                    $data_apvh = array(
                        'tot_item' => $veh_apvh->tot_item + 1,
                        'tot_disc' => $veh_apvh->tot_disc + $data['hd_disc'],
                        'tot_paid' => $veh_apvh->tot_paid + $data['hd_paid']
                    );

                    $this->all_m->updateData('veh_aph', 'id', $veh_aph->id, array('apv_inv_no' => $apv_inv_no));
                    $this->all_m->updateData('veh_apvh', 'apv_inv_no', $apv_inv_no, $data_apvh);
                    $this->all_m->insertData($table, $newdata_apvd);
                    $msg = array('success' => true, 'message' => 'Record saved', 'status' => 'save');
                } else {
                    $msg = array('success' => false, 'message' => 'Failed to add detail');
                }
            } else {
                $msg = array('success' => false, 'message' => 'Failed to add detail');
            }
        }
        $this->json($msg);
    }

    function delete_apvd() {
        $table = $this->input->post('table');
        $id = $this->input->post('id');

        $veh_apvd = $this->all_m->getId($table, 'id', $id);
        $veh_aph = $this->all_m->getId('veh_aph', 'pur_inv_no', $veh_apvd->pur_inv_no);

        $stat = false;
        $check = $this->all_m->countlimit($table, array('id' => $id));
        $checkapvh = $this->all_m->countlimit('veh_apvh', array('apv_inv_no' => $veh_apvd->apv_inv_no));

        if ($check > 0) {
            $stat = true;
        }
        if ($checkapvh > 0) {
            $stat = true;
        }

        if ($stat !== false) {

            $veh_apvh = $this->all_m->getId('veh_apvh', 'apv_inv_no', $veh_apvd->apv_inv_no);

            $data_apvh = array(
                'tot_item' => $veh_apvh->tot_item - 1,
                'tot_disc' => $veh_apvh->tot_disc - $veh_apvd->hd_disc,
                'tot_paid' => $veh_apvh->tot_paid - $veh_apvd->hd_paid
            );

            $this->all_m->updateData('veh_aph', 'id', $veh_aph->id, array('apv_inv_no' => ''));
            $this->all_m->updateData('veh_apvh', 'id', $veh_apvh->id, $data_apvh);
            $this->all_m->deleteData($table, 'id', $id);
            $msg = array('status' => true, 'message' => 'Detail has been deleted successfully');
        } else {
            $msg = array('status' => false, 'message' => 'Failed to delete detail');
        }

        $this->json($msg);
    }

    function closeVoucher() {
        $user = $this->uri->segment(4);
        $data = $this->input->post();
        $tbl = $this->input->post('table');
        $id = $this->input->post('id');
        //$date = date('d/m/Y');
        $date = date('Y-m-d');
        unset($data['id']);
        unset($data['table']);

        $periode = $this->checkPeriode();

        if ($periode == 'false') {
            $msg = $this->msgNotClose();
            $msg['status'] = false;
        }

        $check = $this->all_m->check('veh_apvd', array('apv_inv_no' => $data['apv_inv_no']));

        if (intval(strtotime($data['pay_date'])) <> intval(strtotime($date))) {
            $msg = array('status' => false, 'message' => 'Sorry, Payment Date has to be the same with today\'s date');
        }

        if ($check < 1) {
            $msg = array('status' => false, 'message' => 'Unable to close this invoice because there is no Detail. Please input some Detail(s)');
        }

        if ($msg['status'] !== false) {
            $veh_apvh = $this->all_m->getId($tbl, 'id', $id);

            $check = $this->all_m->check($tbl, array('apv_inv_no' => $veh_apvh->apv_inv_no));

            $veh_apvd = $this->all_m->getWhere('veh_apvd', array('apv_inv_no' => $veh_apvh->apv_inv_no));

            foreach ($veh_apvd as $apvd) {
                $data_vehapvod = (array) $apvd;
                unset($data_vehapvod['id']);
                $data_vehapvod['apv_date'] = date('Y-m-d');

                $this->all_m->insertData('vehapvod', $data_vehapvod);

                $this->all_m->updateData('veh_aph', 'pur_inv_no', $apvd->pur_inv_no, array('apv_date' => date('Y-m-d')));

                $this->all_m->updateData('veh_apvd', 'id', $apvd->id, array('apv_date' => date('Y-m-d')));
            }

            $veh_apvh = $this->all_m->getId($tbl, 'id', $id);
            $data_apvh = array(
                'apv_date' => date('Y-m-d'),
                'cls_date' => date('Y-m-d'),
                'cls_by' => $user,
                'cls_cnt' => $veh_apvh->cls_cnt + 1
            );

            $sql_vehapvoh = "SHOW COLUMNS FROM vehapvoh";
            $vehapvoh = $this->all_m->query_all($sql_vehapvoh);

            foreach ($vehapvoh as $apvoh) {
                $field_apvoh[$apvoh->Field] = '';
            }
            unset($field_apvoh['id']);

            $apvh = (array) $veh_apvh;
            unset($apvh['id']);

            foreach ($apvh as $k => $v) {

                if (array_key_exists($k, $field_apvoh)) {
                    $key[] = $k;
                    $val[] = $v;
                }
            }

            $newdata_apvoh = array_combine($key, $val);
            $newdata_apvoh['apv_date'] = date('Y-m-d');

            $this->all_m->insertData('vehapvoh', $newdata_apvoh);
            $this->all_m->updateData($tbl, 'id', $id, $data_apvh);
            $msg = array('success' => true);
        } else {
            $res = $msg;
        }

        $this->json($msg);
    }

    function uncloseVoucher() {
        $user = $this->uri->segment(4);
        $data = $this->input->post();
        $tbl = $this->input->post('table');
        $id = $this->input->post('id');
        $date = date('Y-m-d');

        unset($data['id']);
        unset($data['table']);

        $check = $this->all_m->check('veh_apvd', array('apv_inv_no' => $data['apv_inv_no']));

        $periode = $this->checkPeriode();

        if ($periode == 'false') {
            $msg = $this->msgNotUnClose();
            $msg['status'] = false;
        }
        $checkhutang = $this->all_m->check('veh_apgd', array('apv_inv_no' => $data['apv_inv_no']));

        if ($checkhutang > 0) {
            $msg['status'] = false;
            $msg['message'] = ' Sorry, this Invoice cannot be unclosed because it already have account payable payment(s). Please delete them first';
        }
        if ($msg['status'] !== false) {
            $veh_apvh = $this->all_m->getId($tbl, 'id', $id);

            $check = $this->all_m->check($tbl, array('apv_inv_no' => $veh_apvh->apv_inv_no));

            $veh_apvd = $this->all_m->getWhere('veh_apvd', array('apv_inv_no' => $veh_apvh->apv_inv_no));

            foreach ($veh_apvd as $apvd) {

                $data_pvod = array(
                    "pur_inv_no" => $apvd->pur_inv_no,
                    "apv_inv_no" => $apvd->apv_inv_no,
                );


                $this->all_m->updateData('veh_aph', 'pur_inv_no', $apvd->pur_inv_no, array('apv_date' => ''));

                $countapvod = $this->all_m->countlimit('vehapvod', $data_pvod);

                if ($countapvod > 0) {
                    $vehapvod = $this->all_m->getOne('vehapvod', $data_pvod);
                    $this->all_m->deleteData('vehapvod', 'id', $vehapvod->id);
                }

                $this->all_m->updateData('veh_apvd', 'id', $apvd->id, array('apv_date' => ''));
            }

            $data_apvh = array(
                'apv_date' => '',
                'cls_date' => '',
                'cls_by' => '',
                'cls_cnt' => 0
            );

            $this->all_m->deleteData('vehapvoh', 'apv_inv_no', $veh_apvh->apv_inv_no);
            $this->all_m->updateData($tbl, 'id', $id, $data_apvh);
            $msg = array('success' => true);
        } else {
            $res = $msg;
        }

        $this->json($msg);
    }

    function deleteVoucher() {
        $table = $this->input->post('table');
        $id = $this->input->post('id');

        $veh_apvh = $this->all_m->getId($table, 'id', $id);
        //$veh_argd = $this->all_m->getWhere($table, array('arg_inv_no' => $veh_argh->arg_inv_no));

        $check = $this->all_m->check('veh_apvd', array('apv_inv_no' => $veh_apvh->apv_inv_no));

        if ($check > 0) {
            $msg = array('success' => false, 'message' => 'Sorry, this invoice cannot be deleted because it has detail(s). Please delete them first');
        } else {
            $this->all_m->deleteData($table, 'id', $id);
            $msg = array('success' => true, 'message' => 'Data has been deleted successfully');
        }

        $this->json($msg);
    }

    function check_sale() {
        $table = $this->input->post('tbl');
        $so_no = $this->input->post('so_no');
        $data = $this->all_m->getId($table, 'so_no', $so_no);

        $check = $this->all_m->countlimit($table, array('so_no' => $so_no));
        if ($check > 0) {
            if ($data->cls_date !== '0000-00-00') {
                $msg = array('success' => false, 'message' => 'Invoice vehicle sale with SPK No. ' . $so_no . ' is already closed');
            } else {
                $msg = array('success' => true);
            }
        } else {
            $msg = array('success' => true);
        }
        $this->json($msg);
    }

    function deleteVehApd() {
        $table = $this->input->post('table');
        $id = $this->input->post('id');

        $veh_apd = $this->all_m->getId('veh_apd', 'id', $id);

        $stat = false;
        $check = $this->all_m->countlimit('veh_apd', array('id' => $id));
        $checkaph = $this->all_m->countlimit('veh_aph', array('pur_inv_no' => $veh_apd->pur_inv_no));

        $msg = array('status' => false, 'message' => 'Failed to delete detail');

        $date = date('Y-m-d');

        if (intval(strtotime($date)) !== intval(strtotime($veh_apd->pay_date))) {
            $stat = false;
            $msg = array('status' => false, 'message' => 'Sorry, This invoice can not be deleted');
        }

        if ($check > 0) {
            $stat = true;
        }
        if ($checkaph > 0) {
            $stat = true;
        }

        if (!empty($veh_apd->apg_inv_no)) {
            $stat = false;
            $msg = array('status' => false, 'message' => 'This payment can not be removed because it uses a combined payment with Invoice No. ' . $veh_apd->apg_inv_no);
        }

        if ($stat !== false) {

            $veh_aph = $this->all_m->getId('veh_aph', 'pur_inv_no', $veh_apd->pur_inv_no);

            $hd_paid = $veh_aph->hd_paid - $veh_apd->pay_val;
            $hd_disc = $veh_aph->hd_disc - $veh_apd->disc_val;
            $hd_end = $veh_aph->hd_begin - $hd_paid - $hd_disc;

            $data_aph['hd_paid'] = $hd_paid;
            $data_aph['hd_disc'] = $hd_disc;
            $data_aph['hd_end'] = $hd_end;


            $new_dpsd = array(
                'use_date' => NULL,
                'used_val' => NULL,
                'pur_inv_no' => NULL,
                'pur_date' => NULL,
            );

            $veh_dpsd = $this->all_m->getOne('veh_dpsd', array('po_no' => $veh_aph->po_no, 'pur_inv_no' => $veh_apd->pur_inv_no, 'check_no' => $veh_apd->check_no));
            $veh_dpsh = $this->all_m->getId('veh_dpsh', 'po_no', $veh_aph->po_no);

            $dp_paid = $veh_dpsh->dp_paid;
            $dp_used = $veh_dpsh->dp_used - $veh_apd->pay_val;
            $dp_end = $dp_paid - $dp_used;

            $new_dpsh = array(
                //'dp_paid' => $dp_paid,
                'dp_used' => $dp_used,
                'dp_end' => $dp_end
            );

            $this->all_m->updateData('veh_dpsd', 'id', $veh_dpsd->id, $new_dpsd);
            $this->all_m->updateData('veh_dpsh', 'id', $veh_dpsh->id, $new_dpsh);
            $this->all_m->updateData('veh_aph', 'id', $veh_aph->id, $data_aph);
            $this->all_m->deleteData($table, 'id', $id);
            $msg = array('status' => true, 'message' => 'Detail has been deleted successfully');
        } else {
            $msg = $msg;
        }
        $this->json($msg);
    }

    function save_comaph() {

        $table = $this->input->post('table');
        $id = $this->input->post('id');

        $data['note'] = $this->input->post('note');

        if ($id !== '') {
            $this->all_m->updateData($table, 'id', $id, $data);
            $msg = array('success' => true, 'message' => 'Record updated ', 'status' => 'update');
        }
        $this->json($msg);
    }

    function save_comapd() {
        $user = $this->uri->segment(5);
        $sal_inv_no = $this->uri->segment(4);

        $table = $this->input->post('table2');
        $id = $this->input->post('id2');
        $data = $this->input->post();

        unset($data['table2']);
        unset($data['id2']);

        $veh_comaph = $this->all_m->getId('veh_comaph', 'sal_inv_no', $sal_inv_no);

        $check_no = $data['check_no'];

        $checkapd = $this->all_m->countlimit('veh_comapd', array('sal_inv_no' => $sal_inv_no, 'check_no' => $check_no));

        $stat = true;

        if ($checkapd > 0) {
            $stat = false;
            $msg = array('status' => false, 'message' => 'Sorry, payment with Cheque No.: ' . $check_no . ' exists in this invoice');
        }

        if ($check_no == '') {
            $stat = false;
            $msg = array('status' => false, 'message' => 'Please input Cheque No.');
        }


        $total_payment = intval($data['pay_val']) + intval($data['disc_val']) + intval($data['pph']);

        if ($total_payment > intval($veh_comaph->hd_end)) {
            $stat = false;
            $msg = array('status' => false, 'message' => 'Sorry, commission payments have exceeded commission payable');
        }

        if ($msg['status'] !== false) {

            $hd_paid = $veh_comaph->hd_paid + $data['pay_val'];
            $hd_disc = $veh_comaph->hd_disc + $data['disc_val'];
            $hd_pph = $veh_comaph->hd_pph + $data['pph'];
            $hd_end = $veh_comaph->hd_begin - $hd_paid - $hd_disc - $hd_pph;

            $data_aph['hd_paid'] = $hd_paid;
            $data_aph['hd_disc'] = $hd_disc;
            $data_aph['hd_pph'] = $hd_pph;
            $data_aph['hd_end'] = $hd_end;


            $data['sal_inv_no'] = $sal_inv_no;
            $data['add_by'] = $user;
			$data['add_date'] = date('Y-m-d');
			
            if (!empty($data['pay_date'])) {
                $data['pay_date'] = $this->dateFormat($data['pay_date']);
            }
            if (!empty($data['check_date'])) {
                $data['check_date'] = $this->dateFormat($data['check_date']);
            }
            if (!empty($data['due_date'])) {
                $data['due_date'] = $this->dateFormat($data['due_date']);
            }
            $data['sal_date'] = $veh_comaph->sal_date;

            $this->all_m->updateData('veh_comaph', 'id', $veh_comaph->id, $data_aph);

            if ($id !== '') {
                $this->all_m->updateData($table, 'id', $id, $data);
                $msg = array('success' => true, 'message' => 'Record updated ', 'status' => 'update');
            } else {
                $this->all_m->insertData($table, $data);

                $msg = array('success' => true, 'message' => 'Record saved', 'status' => 'save');
            }
        } else {
            $status = $msg;
        }


        $this->json($msg);
    }

    function deleteComapd() {
        $table = $this->input->post('table');
        $id = $this->input->post('id');

        $veh_comapd = $this->all_m->getId('veh_comapd', 'id', $id);

        $stat = false;
        $check = $this->all_m->countlimit('veh_comapd', array('id' => $id));
        $checkaph = $this->all_m->countlimit('veh_comaph', array('sal_inv_no' => $veh_comapd->sal_inv_no));

        $msg = array('status' => false, 'message' => 'Failed to delete detail');

        if ($check > 0) {
            $stat = true;
        }
        if ($checkaph > 0) {
            $stat = true;
        }


        if ($stat !== false) {

            $veh_comaph = $this->all_m->getId('veh_comaph', 'sal_inv_no', $veh_comapd->sal_inv_no);

            $hd_paid = $veh_comaph->hd_paid - $veh_comapd->pay_val;
            $hd_disc = $veh_comaph->hd_disc - $veh_comapd->disc_val;
            $hd_pph = $veh_comaph->hd_pph - $veh_comapd->pph;
            $hd_end = $veh_comaph->hd_begin - $hd_paid - $hd_disc - $hd_pph;

            $data_aph['hd_paid'] = $hd_paid;
            $data_aph['hd_disc'] = $hd_disc;
            $data_aph['hd_pph'] = $hd_pph;
            $data_aph['hd_end'] = $hd_end;

            $this->all_m->updateData('veh_comaph', 'id', $veh_comaph->id, $data_aph);
            $this->all_m->deleteData($table, 'id', $id);
            $msg = array('status' => true, 'message' => 'Detail has been deleted successfully');
        } else {
            $msg = $msg;
        }
        $this->json($msg);
    }

    function save_downpaymentSupp() {
        $table = $this->input->post('table');
        $id = $this->input->post('id');
        $data = $this->input->post();

        unset($data['table']);
        unset($data['id']);

        if (!empty($data['po_date'])) {
            $data['po_date'] = $this->dateFormat($data['po_date']);
        }
        if (!empty($data['opn_date'])) {
            $data['opn_date'] = $this->dateFormat($data['opn_date']);
        }

        $count = $this->all_m->countlimit($table, array('po_no' => $data['po_no']));

        if ($count >> 0) {
            $msg = array('success' => false, 'message' => 'Data already exist');
        } else {
            $supp = $this->all_m->getId('veh_supp', 'supp_code', $data['supp_code']);
            $addr = '';
            $area = '';
            $city = '';
            $zipc = '';

            if ($supp->postaddr == 1) {
                $addr = $supp->oaddr;
                $area = $supp->oarea;
                $city = $supp->ocity;
                $zipc = $supp->ozipcode;
            }
            if ($supp->postaddr == 2) {
                $addr = $supp->haddr;
                $area = $supp->harea;
                $city = $supp->hcity;
                $zipc = $supp->hzipcode;
            }

            $data['supp_addr'] = $addr;
            $data['supp_area'] = $area;
            $data['supp_city'] = $city;
            $data['supp_zipc'] = $zipc;

            if ($id !== '') {
                $this->all_m->updateData($table, 'id', $id, $data);
                $msg = array('success' => true, 'message' => 'Record updated ', 'status' => 'update');
            } else {
                $this->all_m->insertData($table, $data);
                $msg = array('success' => true, 'message' => 'Record saved', 'status' => 'save');
            }
        }
        $this->json($msg);
    }

    function save_dpsd() {
        $user = $this->uri->segment(5);
        $po_no = $this->uri->segment(4);

        $table = $this->input->post('table2');
        $id = $this->input->post('id2');
        $data = $this->input->post();

        unset($data['table2']);
        unset($data['id2']);

        $check_no = $data['check_no'];

        $checkdpsd = $this->all_m->countlimit($table, array('po_no' => $po_no, 'check_no' => $check_no));

        $stat = true;

        if ($checkdpsd > 0) {
            $stat = false;
            $msg = array('status' => false, 'message' => 'Sorry, payment with Cheque No.: ' . $check_no . ' exists in this invoice');
        }

        if ($check_no == '') {
            $msg = array('status' => false, 'message' => 'Please input Cheque No.');
        }


        if ($msg['status'] !== false) {

            $veh_dpsh = $this->all_m->getId('veh_dpsh', 'po_no', $po_no);
            $dp_paid = $veh_dpsh->dp_paid + $data['pay_bt'];

            $data_dpsh['dp_paid'] = $dp_paid;
            $data_dpsh['dp_end'] = $veh_dpsh->dp_begin + $dp_paid - $veh_dpsh->dp_used;

            $data['po_date'] = $veh_dpsh->po_date;
            $data['po_no'] = $po_no;
            $data['add_by'] = $user;
            $data['add_date'] = date('Y-m-d');
            $data['posted'] = 0;

            if (!empty($data['pay_date'])) {
                $data['pay_date'] = $this->dateFormat($data['pay_date']);
            }
            if (!empty($data['check_date'])) {
                $data['check_date'] = $this->dateFormat($data['check_date']);
            }
            if (!empty($data['due_date'])) {
                $data['due_date'] = $this->dateFormat($data['due_date']);
            }

            $this->all_m->updateData('veh_dpsh', 'id', $veh_dpsh->id, $data_dpsh);

            $this->all_m->insertData($table, $data);

            $msg = array('success' => true, 'message' => 'Record saved', 'status' => 'save');
        } else {
            $status = $msg;
        }


        $this->json($msg);
    }

    function delete_dpsd() {
        $table = $this->input->post('table');
        $id = $this->input->post('id');
        $po_no = $this->input->post('po_no');

        $veh_dpsd = $this->all_m->getId($table, 'id', $id);
        $data = (array) $veh_dpsd;

        $date = date('Y-m-d');
        $stat = true;

        $msg = array('status' => false, 'message' => 'Failed to delete detail');

        if (intval(strtotime($date)) !== intval(strtotime($data['pay_date']))) {
            $stat = false;
            $msg = array('status' => false, 'message' => 'Sorry, This invoice can not be deleted');
        }
        if (!empty($data['dp_inv_no'])) {
            $msg = array('status' => false, 'message' => 'This payment can not be removed because it uses a combined payment with Invoice No. ' . $data['dp_inv_no']);
            $stat = false;
        }

        $check = $this->all_m->countlimit($table, array('id' => $id));
        $checkdpsh = $this->all_m->countlimit('veh_dpsh', array('po_no' => $po_no));

        if ($check < 1) {
            $stat = false;
        }
        if ($checkdpsh < 1) {
            $stat = false;
        }

        if ($stat !== false) {

            $veh_dpsh = $this->all_m->getId('veh_dpsh', 'po_no', $data['po_no']);

            $dp_paid = $veh_dpsh->dp_paid - $data['pay_bt'];

            $data_dpsh['dp_paid'] = $dp_paid;
            $data_dpsh['dp_end'] = $veh_dpsh->dp_begin + $dp_paid - $veh_dpsh->dp_used;


            $this->all_m->updateData('veh_dpsh', 'id', $veh_dpsh->id, $data_dpsh);
            $this->all_m->deleteData($table, 'id', $id);
            $msg = array('status' => true, 'message' => 'Detail has been deleted successfully');
        }
        $this->json($msg);
    }

    function saveDPGabungan() {

        $data = $this->input->post();

        $table = $this->input->post('table');
        $id = $this->input->post('id');
        $date = date('Y-m-d');

        unset($data['table']);
        unset($data['id']);
        unset($data['cls_date']);

        if (!empty($data['dp_date'])) {
            $data['dp_date'] = $this->dateFormat($data['dp_date']);
        }
        if (!empty($data['opn_date'])) {
            $data['opn_date'] = $this->dateFormat($data['opn_date']);
        }

        if (!empty($data['pay_date'])) {
            $data['pay_date'] = $this->dateFormat($data['pay_date']);
        }
        if (!empty($data['check_date'])) {
            $data['check_date'] = $this->dateFormat($data['check_date']);
        }
        if (!empty($data['due_date'])) {
            $data['due_date'] = $this->dateFormat($data['due_date']);
        }

        if (intval(strtotime($data['pay_date'])) <> intval(strtotime($date))) {
            $msg = array('status' => false, 'message' => 'Sorry, Payment Date has to be the same with today\'s date');
        }
        if ($data['check_no'] == '') {
            $msg = array('status' => false, 'message' => 'Please input Cheque No.');
        }
        if ($data['pay_type'] == '') {
            $msg = array('status' => false, 'message' => 'Please input Payment Type');
        }
        if ($data['supp_code'] == '') {
            $msg = array('status' => false, 'message' => 'Please input Supplier code');
        }
        if ($data['wrhs_code'] == '') {
            $msg = array('status' => false, 'message' => 'Please input Warehouse');
        }

        $inv_type = 'VDP';

        if ($msg['status'] !== false) {
            $supp = $this->all_m->getId('veh_supp', 'supp_code', $data['supp_code']);
            $addr = '';
            $area = '';
            $city = '';
            $zipc = '';

            if ($supp->postaddr == 1) {
                $addr = $supp->oaddr;
                $area = $supp->oarea;
                $city = $supp->ocity;
                $zipc = $supp->ozipcode;
            }
            if ($supp->postaddr == 2) {
                $addr = $supp->haddr;
                $area = $supp->harea;
                $city = $supp->hcity;
                $zipc = $supp->hzipcode;
            }

            $data['supp_addr'] = $addr;
            $data['supp_area'] = $area;
            $data['supp_city'] = $city;
            $data['supp_zipc'] = $zipc;

            $data['prn_cnt'] = 0;

            if ($id !== '') {
                $this->all_m->updateData($table, 'id', $id, $data);
                $msg = array('success' => true, 'message' => 'Record updated ', 'status' => 'update');
                $this->updateLocked($table, $id);
            } else {
                unset($data['dp_inv_no']);
                $data['dp_inv_no'] = $this->all_m->inv_seq('4', $inv_type);
                $this->all_m->insertData($table, $data);

                $inv_seq = $this->all_m->getOne('inv_seq', array('inv_type' => $inv_type));
                $this->all_m->updateData('inv_seq', 'id', $inv_seq->id, array('inv_no' => $inv_seq->inv_no + 1));

                $msg = array('success' => true, 'message' => 'Record saved', 'status' => 'save');
            }
        } else {
            $status = $msg;
        }


        $this->json($msg);
    }

    function save_dpsgd() {
        $C_USER = $this->uri->segment(5);
        $dp_inv_no = $this->uri->segment(4);
        $data = $this->input->post();
        $table = $this->input->post('table2');

        unset($data['id2']);
        unset($data['table2']);
        $po_no = $data['po_no'];


        // $dpsh = 'veh_dpsh';
        $dpsgh = 'veh_dpsgh';
        $po = 'veh_po';

        //$veh_dpsh = $this->all_m->getId($dpsh, 'po_no', $po_no);
        $veh_po = $this->all_m->getId($po, 'po_no', $po_no);
        $veh_dpsgh = $this->all_m->getId($dpsgh, 'dp_inv_no', $dp_inv_no);

        $stat = true;

        $check = $this->all_m->countlimit($table, array('po_no' => $po_no, 'dp_inv_no' => $dp_inv_no));

        $count2 = $this->all_m->countlimit($dpsgh, array('dp_inv_no' => $dp_inv_no));


        $po_date = $this->dateFormat($data['po_date']);

        if (intval(strtotime($veh_dpsgh->pay_date)) < intval(strtotime($po_date))) {
            $stat = false;
            $msg = array('success' => false, 'message' => 'Sorry, Payment Date has to be the same with PO Date');
        }

        if ($check > 0) {
            $stat = false;
            $msg = array('success' => false, 'message' => 'PO No. ' . $po_no . '  already exist');
        }

        if ($count2 < 1) {
            $stat = false;
            $msg = array('success' => false, 'message' => 'Failed to add detail');
        }


        if ($stat !== false) {


            $data['dp_inv_no'] = $dp_inv_no;
            $data['dp_date'] = date('Y-m-d');

            $data['add_by'] = $C_USER;
            $data['add_date'] = date('Y-m-d');

            $data['veh_brand'] = $veh_po->veh_brand;
            $data['veh_type'] = $veh_po->veh_type;
            $data['veh_model'] = $veh_po->veh_model;
            $data['veh_year'] = $veh_po->veh_year;
            $data['veh_transm'] = $veh_po->veh_transm;
            $data['wrhs_code'] = $veh_po->wrhs_code;
            $data['pur_inv_no'] = $veh_po->pur_inv_no;
            $data['pur_date'] = $veh_po->pur_date;
            $data['chassis'] = $veh_po->chassis;
            $data['engine'] = $veh_po->engine;
            $data['dp_begin'] = $data['veh_price'];
            $data['dp_end'] = $data['dp_paid'];

            if (!empty($data['po_date'])) {
                $data['po_date'] = $this->dateFormat($data['po_date']);
            }

            $data_dpsgh = array(
                'tot_item' => $veh_dpsgh->tot_item + 1,
                'tot_paid' => $veh_dpsgh->tot_paid + $data['dp_paid']
            );


            $this->all_m->updateData($dpsgh, 'dp_inv_no', $dp_inv_no, $data_dpsgh);
            $this->all_m->insertData($table, $data);
            $msg = array('success' => true, 'message' => 'Record saved', 'status' => 'save');
        } else {
            $msg = $msg;
        }
        $this->json($msg);
    }

    function delete_dpsgd() {

        $table = $this->input->post('table');
        $id = $this->input->post('id');

        $dpsgd = $this->all_m->getId($table, 'id', $id);

        $dpsgh = 'veh_dpsgh';

        $stat = false;
        $check = $this->all_m->countlimit($table, array('id' => $id));
        $checkdpsgh = $this->all_m->countlimit($dpsgh, array('dp_inv_no' => $dpsgd->dp_inv_no));

        $msg = array('status' => false, 'message' => 'Failed to delete detail');

        if ($check > 0) {
            $stat = true;
        }
        if ($checkapgh > 0) {
            $stat = true;
        }


        if ($stat > 0) {

            $d_dpsgh = $this->all_m->getId($dpsgh, 'dp_inv_no', $dpsgd->dp_inv_no);
            $data_dpsgh = array(
                'tot_item' => $d_dpsgh->tot_item - 1,
                'tot_paid' => $d_dpsgh->tot_paid - $dpsgd->dp_paid
            );

            $this->all_m->updateData($dpsgh, 'id', $d_dpsgh->id, $data_dpsgh);
            $this->all_m->deleteData($table, 'id', $id);
            $msg = array('status' => true, 'message' => 'Detail has been deleted successfully');
        } else {
            $msg = $msg;
        }

        $this->json($msg);
    }

    function deleteDPSupplier() {
        $table = $this->input->post('table');
        $id = $this->input->post('id');

        $veh_dpsh = $this->all_m->getId($table, 'id', $id);
        //$veh_argd = $this->all_m->getWhere($table, array('arg_inv_no' => $veh_argh->arg_inv_no));

        $check = $this->all_m->check('veh_dpsd', array('po_no' => $veh_dpsh->po_no));

        if ($check > 0) {
            $msg = array('success' => false, 'message' => 'Sorry, this invoice cannot be deleted because it has detail(s). Please delete them first');
        } else {
            $this->all_m->deleteData($table, 'id', $id);
            $msg = array('success' => true, 'message' => 'Data has been deleted successfully');
        }

        $this->json($msg);
    }

    function deleteDPSupplierGabungan() {
        $table = $this->input->post('table');
        $id = $this->input->post('id');

        $veh_dpsgh = $this->all_m->getId($table, 'id', $id);
        //$veh_argd = $this->all_m->getWhere($table, array('arg_inv_no' => $veh_argh->arg_inv_no));

        $check = $this->all_m->check('veh_dpsgd', array('dp_inv_no' => $veh_dpsgh->dp_inv_no));

        if ($check > 0) {
            $msg = array('success' => false, 'message' => 'Sorry, this invoice cannot be deleted because it has detail(s). Please delete them first');
        } else {
            $this->all_m->deleteData($table, 'id', $id);
            $msg = array('success' => true, 'message' => 'Data has been deleted successfully');
        }

        $this->json($msg);
    }

    function closeDPGabunganSupp() {
        $user = $this->uri->segment(4);
        $data = $this->input->post();
        $tbl = $this->input->post('table');
        $id = $this->input->post('id');
        $date = date('Y-m-d');

        unset($data['id']);
        unset($data['table']);

        $tbl_dpsgd = 'veh_dpsgd';
        $tbl_dpsh = 'veh_dpsh';
        $tbl_dpsd = 'veh_dpsd';

        $periode = $this->checkPeriode();

        if ($periode == 'false') {
            $msg = $this->msgNotClose();
            $msg['status'] = false;
        }

        $check = $this->all_m->check($tbl_dpsgd, array('dp_inv_no' => $data['dp_inv_no']));


        $pay_date = $this->dateFormat($data['pay_date']);

        if (intval(strtotime($pay_date)) <> intval(strtotime($date))) {
            $msg = array('status' => false, 'message' => 'Sorry, Payment Date has to be the same with today\'s date');
        }

        if ($check < 1) {
            $msg = array('status' => false, 'message' => 'Unable to close this invoice because there is no Detail. Please input some Detail(s)');
        }

        $veh_dpsgh = $this->all_m->getId($tbl, 'id', $id);
        $veh_dpsgd = $this->all_m->getWhere($tbl_dpsgd, array('dp_inv_no' => $veh_dpsgh->dp_inv_no));

        $no_inv = '';

        foreach ($veh_dpsgd as $dpsgd) {
            if (intval(strtotime($dpsgd->po_date)) > intval(strtotime(date('Y-m-d')))) {
                $msg = array('status' => false, 'message' => 'Sorry, There is a payment Invoice date that is greater than today\'s date');
            }
            $check_dpsd = $this->all_m->countlimit($tbl_dpsd, array('po_no' => $dpsgd->po_no, "check_no" => $veh_dpsgh->check_no));

            if ($check_dpsd > 0) {
                $no_inv = $dpsgd->po_no . ' ';
            }
            $countard += $check_dpsd;
        }

        if ($countard > 0) {
            $msg = array('status' => false, 'message' => 'Sorry, Duplicate Check No : ' . $veh_dpsgh->check_no . ' in Booking Fee Supplier PO No. ' . $no_inv);
        }

        //echo intval(strtotime(date('Y-m-d')));exit;
        if ($msg['status'] !== false) {

            $check = $this->all_m->check($tbl, array('dp_inv_no' => $veh_dpsgh->dp_inv_no));

            foreach ($veh_dpsgd as $dpsgd) {
                $dp_paid = 0;
                $dp_end = 0;

                $checkdpsh = $this->all_m->check($tbl_dpsh, array('po_no' => $dpsgd->po_no));

                if ($checkdpsh > 0) {
                    $veh_dpsh = $this->all_m->getId($tbl_dpsh, 'po_no', $dpsgd->po_no);

                    $dp_paid = $veh_dpsh->dp_paid + $dpsgd->dp_paid;

                    $dp_paid = $dp_paid;
                    $dp_end = $veh_dpsh->dp_begin + $dp_paid - $veh_dpsh->dp_used;
                } else {
                    $dp_paid = $dp_paid + $dpsgd->dp_paid;

                    $dp_paid = $dp_paid;
                    $dp_end = $dp_paid;
                }

                $data_dpsd = array(
                    'pay_bt' => $dpsgd->dp_paid,
                    'bank_code' => $veh_dpsgh->bank_code,
                    'pay_date' => $veh_dpsgh->pay_date,
                    'pay_type ' => $veh_dpsgh->pay_type,
                    'check_no' => $veh_dpsgh->check_no,
                    'check_date' => $veh_dpsgh->check_date,
                    'due_date ' => $veh_dpsgh->due_date,
                    'pay_desc' => $veh_dpsgh->pay_desc,
                    'ref_no' => $veh_dpsgh->ref_no,
                    'ref_date' => $veh_dpsgh->ref_date,
                    'link_no' => $veh_dpsgh->link_no,
                    'payer_name' => $veh_dpsgh->payer_name,
                    'payer_addr' => $veh_dpsgh->payer_addr,
                    'payer_area' => $veh_dpsgh->payer_area,
                    'payer_city' => $veh_dpsgh->payer_city,
                    'payer_zipc' => $veh_dpsgh->payer_zipc,
                    'po_no' => $dpsgd->po_no,
                    'po_date' => $dpsgd->po_date,
                    'dp_inv_no' => $dpsgd->dp_inv_no,
                    'dp_date' => $date,
                    'add_by ' => $user,
                    'add_date' => $date,
                    'posted' => 0,
                    'wrhs_code ' => $veh_dpsgh->wrhs_code
                );

                $data_dpsh = array(
                    'veh_price' => $dpsgd->veh_price,
                    'color_code' => $dpsgd->color_code,
                    'color_name' => $dpsgd->color_name,
                    'veh_code' => $dpsgd->veh_code,
                    'veh_name' => $dpsgd->veh_name,
                    'veh_brand' => $dpsgd->veh_brand,
                    'veh_type' => $dpsgd->veh_type,
                    'veh_model' => $dpsgd->veh_model,
                    'veh_year' => $dpsgd->veh_year,
                    'veh_transm' => $dpsgd->veh_transm,
                    'wrhs_code' => $dpsgd->wrhs_code,
                    'engine' => $dpsgd->pur_date,
                    'chassis' => $dpsgd->chassis,
                    'supp_code' => $veh_dpsgh->supp_code,
                    'supp_name' => $veh_dpsgh->supp_name,
                    'supp_addr' => $veh_dpsgh->supp_addr,
                    'supp_area' => $veh_dpsgh->supp_area,
                    'supp_city' => $veh_dpsgh->supp_city,
                    'supp_zipc' => $veh_dpsgh->supp_zipc,
                    'po_no' => $dpsgd->po_no,
                    'po_date' => $dpsgd->po_date,
                    'dp_paid' => $dp_paid,
                    'dp_end' => $dp_end,
                    'opn_date' => $date
                );


                if ($checkdpsh > 0) {
                    $this->all_m->updateData($tbl_dpsh, 'po_no', $dpsgd->po_no, array('dp_paid' => $dp_paid, 'dp_end' => $dp_end));
                } else {
                    $this->all_m->insertData($tbl_dpsh, $data_dpsh);
                }


                $this->all_m->insertData($tbl_dpsd, $data_dpsd);

                $this->all_m->updateData($tbl_dpsgd, 'id', $dpsgd->id, array('dp_date' => $date));
            }

            $veh_dpsgh = $this->all_m->getId($tbl, 'id', $id);
            $data_dpsgh = array(
                'dp_date' => date('Y-m-d'),
                'cls_date' => date('Y-m-d'),
                'cls_by' => $user,
                'cls_cnt' => $veh_dpsgh->cls_cnt + 1
            );

            $this->all_m->updateData($tbl, 'id', $id, $data_dpsgh);
            $msg = array('success' => true);
        } else {
            $res = $msg;
        }

        $this->json($msg);
    }

    function uncloseDPGabunganSupp() {
        $user = $this->uri->segment(4);
        $data = $this->input->post();
        $tbl = $this->input->post('table');
        $id = $this->input->post('id');
        $date = date('Y-m-d');

        unset($data['id']);
        unset($data['table']);

        $tbl_dpsgd = 'veh_dpsgd';
        $tbl_dpsh = 'veh_dpsh';
        $tbl_dpsd = 'veh_dpsd';


        $periode = $this->checkPeriode();

        if ($periode == 'false') {
            $msg = $this->msgNotUnClose();
            $msg['status'] = false;
        }

        $pay_date = $this->dateFormat($data['pay_date']);
        if (strtotime($pay_date) <> strtotime($date)) {
            $msg = array('status' => false, 'message' => 'Sorry, Payment Date has to be the same with today\'s date');
        }


        $check = $this->all_m->check('veh_apd', array('dp_inv_no' => $data['dp_inv_no']));


        if ($check > 0) {
            $msg = array('status' => false, 'message' => 'Sorry, this Invoice cannot be unclosed because it has payment(s) in Account Payable. Please delete them first');
        }
        if (strtotime($pay_date) <> strtotime($date)) {
            $msg = array('status' => false, 'message' => 'Sorry, Payment Date has to be the same with today\'s date');
        }

        if ($msg['status'] !== false) {
            $veh_apgh = $this->all_m->getId($tbl, 'id', $id);

            $check = $this->all_m->check($tbl, array('dp_inv_no' => $veh_apgh->dp_inv_no));

            $veh_dpsgd = $this->all_m->getWhere($tbl_dpsgd, array('dp_inv_no' => $veh_apgh->dp_inv_no));


            foreach ($veh_dpsgd as $dpsgd) {

                $data_dpsd = array(
                    "po_no" => $dpsgd->po_no,
                    "dp_inv_no" => $dpsgd->dp_inv_no,
                );

                $veh_dpsd = $this->all_m->getOne($tbl_dpsd, $data_dpsd);

                $veh_dpsh = $this->all_m->getId($tbl_dpsh, 'po_no', $dpsgd->po_no);

                $dp_paid = $veh_dpsh->dp_paid - $dpsgd->dp_paid;

                $dp_paid = $dp_paid;
                $dp_end = $veh_dpsh->dp_begin + $dp_paid - $veh_dpsh->dp_used;

                $data_dpsh = array(
                    'dp_paid' => $dp_paid,
                    'dp_end' => $dp_end
                );



                $this->all_m->updateData($tbl_dpsh, 'po_no', $dpsgd->po_no, $data_dpsh);

                $check = $this->all_m->countlimit($tbl_dpsd, $data_dpsd);

                if ($check > 0) {
                    $this->all_m->deleteData($tbl_dpsd, 'id', $veh_dpsd->id);
                }

                $this->all_m->updateData($tbl_dpsgd, 'id', $dpsgd->id, array('dp_date' => ''));
            }

            $data_apgh = array(
                'dp_date' => '',
                'cls_date' => '',
                'cls_by' => '',
                'cls_cnt' => 0
            );

            $this->all_m->updateData($tbl, 'id', $id, $data_apgh);
            $msg = array('success' => true);
        } else {
            $res = $msg;
        }

        $this->json($msg);
    }

    function prepaidDPSupplier() {
        $data = $this->input->post();
        $cust_code = $data['cust_code'];
        $po_no = $data['po_no'];

        $check = $this->all_m->check('veh_dpsh', array('po_no' => $po_no));

        if ($check < 1) {
            $msg = array('status' => false, 'message' => 'Down Payment Supplier ' . $data["supp_name"] . ' for PO No.: ' . $data["po_no"] . ' does not exist or has been used');
        } else {
            $msg = $this->all_m->getId('veh_dpsh', 'po_no', $po_no);
        }

        $this->json($msg);
    }

    function uangJaminanSupplier() {

        if ($this->input->post()) {
            $id = $this->input->post('id');
            $pur_inv_no = $this->input->post('pur_inv_no');
            $dpsd = $this->all_m->getId('veh_dpsd', 'id', $id);

            $stat = true;
            $count = $this->all_m->countlimit('veh_dpsd', array('id' => $id));
            $checkaph = $this->all_m->countlimit('veh_po', array('pur_inv_no' => $pur_inv_no));
            $check_apd = $this->all_m->countlimit('veh_apd', array('pur_inv_no' => $pur_inv_no, "check_no" => $dpsd->check_no));

            /* if($dpsd->use_date !== NULL){
              $stat = false;
              $msg = array('success' => false, 'message' => 'Sorry, the DP It\'s been used');
              } */
            if ($check_apd > 0) {
                $stat = false;
                $msg = array('success' => false, 'message' => 'Sorry, Duplicate Check No : ' . $dpsd->check_no);
            }
            if ($dpsd->pur_inv_no !== NULL) {
                $stat = false;
                $msg = array('success' => false, 'message' => 'Sorry, the DP It\'s been used');
            }

            if ($checkaph < 1) {
                $stat = false;
                $msg = array('success' => false, 'message' => 'Sorry, data not found');
            }
            if ($count < 1) {
                $stat = false;
                $msg = array('success' => false, 'message' => 'Sorry, the DP that you choose does not exist anymore');
            }


            $dpsd = (array) $dpsd;

            if ($stat !== false) {

                unset($dpsd['id']);

                $veh_aph = $this->all_m->getId('veh_aph', 'pur_inv_no', $pur_inv_no);

                $sql = "show columns from veh_apd";
                $veh_apd = $this->all_m->query_all($sql);

                foreach ($veh_apd as $apd) {
                    $field_apd[$apd->Field] = '';
                }
                unset($field_apd['id']);

                foreach ($dpsd as $k => $v) {

                    if (array_key_exists($k, $field_apd)) {
                        $key[] = $k;
                        $val[] = $v;
                    }
                }
                /* update veh_apd */
                $new_veh_apd = array_combine($key, $val);
                $new_veh_apd['pur_inv_no'] = $pur_inv_no;
                $new_veh_apd['pur_date'] = $veh_aph->pur_date;
                $new_veh_apd['add_by'] = $this->input->post('user');
                $new_veh_apd['pay_date'] = date('Y-m-d');
                $new_veh_apd['pay_val'] = $dpsd['pay_bt'];


                $hd_paid = $veh_aph->hd_paid + $dpsd['pay_bt'];
                $hd_disc = $veh_aph->hd_disc + 0;
                $total = $veh_aph->hd_begin - $hd_paid - $hd_disc;

                $new_veh_aph['hd_paid'] = $hd_paid;
                $new_veh_aph['hd_disc'] = $hd_disc;
                $new_veh_aph['hd_end'] = $total;

                /* update veh_dpcd */
                $new_dpsd = array(
                    'use_date' => date('Y-m-d'),
                    'used_val' => $dpsd['pay_bt'],
                    'pur_inv_no' => $pur_inv_no,
                    'pur_date' => $veh_aph->pur_date
                );

                $new_prh = array(
                    'is_paid' => 1
                );

                $veh_dpsh = $this->all_m->getId('veh_dpsh', 'po_no', $dpsd['po_no']);

                $dp_paid = $veh_dpsh->dp_paid;
                $dp_used = $veh_dpsh->dp_used + $dpsd['pay_bt'];
                $dp_end = $dp_paid - $dp_used;

                $new_dpsh = array(
                    //'dp_paid' => $dp_paid,
                    'dp_used' => $dp_used,
                    'dp_end' => $dp_end
                );

                $check = $this->all_m->countlimit('veh_apd', $new_veh_apd);

                if ($check > 0) {
                    $msg = array('success' => false, 'message' => 'Sorry, the DP that you choose does not exist anymore');
                } else {
                    // print_r($new_dpch);exit;
                    /* insert veh_ard */
                    $this->all_m->insertData('veh_apd', $new_veh_apd);
                    /* insert veh_arh */
                    $this->all_m->updateData('veh_aph', 'pur_inv_no', $pur_inv_no, $new_veh_aph);

                    $this->all_m->updateData('veh_dpsd', 'id', $id, $new_dpsd);

                    $this->all_m->updateData('veh_prh', 'pur_inv_no', $pur_inv_no, $new_prh);

                    $this->all_m->updateData('veh_dpsh', 'id', $veh_dpsh->id, $new_dpsh);


                    $msg = array('success' => true);
                }
            } else {
                $msg = $msg;
            }
        }

        $this->json($msg);
    }

    function readhtmlDPSupplierGabungan($data) {
        $tbl = $data['tbl'];
        $id = $data['id'];
        $user = $data['user'];


        $read = $this->all_m->getId($tbl, 'id', $id);

        $veh_dpsgh = $read;
        $veh_dpsgd = $this->all_m->getWhere('veh_dpsgd', array('dp_inv_no' => $veh_dpsgh->dp_inv_no));

        $pay_date = $this->dateView($veh_dpsgh->pay_date);
        $check_date = $this->dateView($veh_dpsgh->check_date);
        $due_date = $this->dateView($veh_dpsgh->due_date);
        $dp_date = $this->dateView($veh_dpsgh->dp_date);
        /*
          $html = '';
          $html .= '<table class="tables">';
          $html .= '<tr>';
          $html .= '<td width="30%"><table class="tables"  style="font-size:12px;">';
          $html .= '<tr><td width="90"><b>No. Faktur</b></td><td width="15">:</td><td width="200">' . $veh_dpsgh->dp_inv_no . '</td></tr>';
          $html .= '<tr><td><b>Tgl. Faktur</b></td><td width="15">:</td><td>' . $dp_date . '</td></tr>';
          $html .= '<tr><td><b>Warehouse</b></td><td width="15">:</td><td>' . $veh_dpsgh->wrhs_code . '</td></tr>';

          $html .= '</table></td>';

          $html .= '<td width="40%"><table class="tables" style="font-size:12px;">';
          $html .= '<tr><td width="90"><b>Tgl. Bayar</b></td><td width="15">:</td><td width="120">' . $pay_date . '</td></tr>';
          $html .= '<tr><td><b>Jenis Bayar</b></td><td width="15">:</td><td>' . $veh_dpsgh->pay_type . '</td></tr>';
          $html .= '<tr><td><b>Bank</b></td><td width="15">:</td><td>' . $veh_dpsgh->bank_code . '</td></tr>';
          $html .= '<tr><td><b>Keterangan</b></td><td width="15">:</td><td width="200">' . $veh_dpsgh->pay_desc . '</td></tr>';
          $html .= '</table></td>';

          $html .= '<td width="30%"><table class="tables" style="font-size:12px;">';
          $html .= '<tr><td width="100"><b>No. Cek/Giro</b></td><td width="15">:</td><td width="120">' . $veh_dpsgh->check_no . '</td></tr>';
          $html .= '<tr><td><b>Tgl. Cek/Giro</b></td><td width="15">:</td><td>' . $check_date . '</td></tr>';
          $html .= '<tr><td><b>J. Tempo</b></td><td width="15">:</td><td>' . $due_date . '</td></tr>';
          $html .= '</table></td>';
          $html .= '</tr>';


          $html .= '<tr><td colspan="3">';
          $html .= '<table  class="tables" style="font-size:12px;">';
          $html .= '<tr><td  width="90"><b>Supplier</b></td><td width="15">:</td><td>' . $veh_dpsgh->supp_name . ' (' . $veh_dpsgh->supp_code . ')</td></tr>';
          $html .= '<tr><td><b>Note</b></td><td width="15">:</td><td>' . $veh_dpsgh->note . '</td></tr>';
          $html .= '</table>';
          $html .= '</td></tr>';
          $html .= '</table>';
         */
        //$html .= '<table class="tables"><tr><td></td></tr></table>';
        $html .= '<table>';
        $html .= '<tr>';
        $html .= '<td>';
        $html .= '<table class="tables" style="font-size:11px;">';
        $html .= '<tr><td width="90"><b>No. Faktur</b></td><td width="15">:</td><td width="200">' . $veh_dpsgh->dp_inv_no . '</td></tr>';
        $html .= '<tr><td><b>Tgl. Faktur</b></td><td width="15">:</td><td>' . $dp_date . '</td></tr>';
        $html .= '<tr><td><b>Warehouse</b></td><td width="15">:</td><td>' . $veh_dpsgh->wrhs_code . '</td></tr>';
        $html .= '</table>';
        $html .= '</td>';
        $html .= '<td>';
        $html .= '<table class="tables" style="font-size:11px;">';
        $html .= '<tr><td width="90"><b>Tgl. Bayar</b></td><td width="15">:</td><td width="120">' . $pay_date . '</td></tr>';
        $html .= '<tr><td><b>Jenis Bayar</b></td><td width="15">:</td><td>' . $veh_dpsgh->pay_type . '</td></tr>';
        $html .= '<tr><td><b>Bank</b></td><td width="15">:</td><td>' . $veh_dpsgh->bank_code . '</td></tr>';
        $html .= '<tr><td><b>Keterangan</b></td><td width="15">:</td><td width="200">' . $veh_dpsgh->pay_desc . '</td></tr>';
        $html .= '</table>';
        $html .= '</td>';
        $html .= '<td>';
        $html .= '<table class="tables" style="font-size:11px;">';
        $html .= '<tr><td width="100"><b>No. Cek/Giro</b></td><td width="15">:</td><td width="120">' . $veh_dpsgh->check_no . '</td></tr>';
        $html .= '<tr><td><b>Tgl. Cek/Giro</b></td><td width="15">:</td><td>' . $check_date . '</td></tr>';
        $html .= '<tr><td><b>J. Tempo</b></td><td width="15">:</td><td>' . $due_date . '</td></tr>';
        $html .= '</table>';
        $html .= '</td>';
        $html .= '</tr>';

        $html .= '<tr><td colspan="3"><br /></td></tr>';
        $html .= '<tr>';
        $html .= '<td colspan="3">';
        $html .= '<table  class="tables" style="font-size:11px;">';
        $html .= '<tr><td  width="90"><b>Supplier</b></td><td width="15">:</td><td>' . $veh_dpsgh->supp_name . ' (' . $veh_dpsgh->supp_code . ')</td></tr>';
        $html .= '<tr><td><b>Note</b></td><td width="15">:</td><td>' . $veh_dpsgh->note . '</td></tr>';
        $html .= '</table>';
        $html .= '</td>';
        $html .= '</tr>';
        $html .= '<tr><td colspan="3"><br /></td></tr>';
        $html .= '<table>';

        $html .= '<table  style="font-size:11px;font-family:Courier;" >';
        $html .= '<tr>'
                . '<td style="border-bottom:1px solid #000;border-top:1px solid #000;" width="30" height="15" valign="top"><b>No.</b></td>'
                . '<td style="border-bottom:1px solid #000;border-top:1px solid #000;" width="120"><b>PO No.</b></td>'
                . '<td style="border-bottom:1px solid #000;border-top:1px solid #000;" width="100"><b>Faktur Beli</b></td>'
                . '<td style="border-bottom:1px solid #000;border-top:1px solid #000;"><b>Tgl. Faktur</b></td>'
                . '<td style="border-bottom:1px solid #000;border-top:1px solid #000;" class="right"><b>Harga</b></td>'
                . '<td style="border-bottom:1px solid #000;border-top:1px solid #000;" class="right"><b>Saldo Awal</b></td>'
                . '<td style="border-bottom:1px solid #000;border-top:1px solid #000;" class="right" width="100"><b>Pembayaran</b></td>'
                . '<td style="border-bottom:1px solid #000;border-top:1px solid #000;" class="right"><b>Disc</b></td>'
                . '<td style="border-bottom:1px solid #000;border-top:1px solid #000;" class="right"><b>Saldo Akhir</b></td></tr>';

        $no = 1;
        foreach ($veh_dpsgd as $dpsgd):

            $total += $dpsgd->dp_paid;
            $diskon += $dpsgd->dp_disc;

            $html .= '<tr>';
            $html .= '<td>' . $no . '.</td>';
            $html .= '<td>' . $dpsgd->po_no . '</td>';
            $html .= '<td>' . $dpsgd->pur_inv_no . '</td>';
            $html .= '<td>' . $this->dateView($dpsgd->pur_date) . '</td>';
            $html .= '<td class="right">' . rupiah($dpsgd->veh_price) . '</td>';
            $html .= '<td class="right">' . rupiah($dpsgd->dp_begin) . '</td>';
            $html .= '<td class="right" width="100">' . rupiah($dpsgd->dp_paid) . '</td>';
            $html .= '<td class="right">' . rupiah($dpsgd->dp_disc) . '</td>';
            $html .= '<td class="right">' . rupiah($dpsgd->dp_end) . '</td>';
            $html .= '</tr>';
            $no++;

        endforeach;
        $html .= '<tr><td colspan="9"></td></tr>';
        //$html .= '<tr><td colspan="9"></td></tr>';
        //$html .= '<tr><td colspan="9"></td></tr>';
        //$html .= '<tr><td colspan="9"></td></tr>';
        $html .= '<tr border="1">'
                . '<td colspan="5"></td>'
                . '<td class="right"><b>Total:</b></td>'
                . '<td class="right" style="border-top:1px solid #000;border-bottom:1px solid #000;" width="100">' . rupiah($total) . '</td>'
                . '<td class="right" style="border-top:1px solid #000;border-bottom:1px solid #000;">' . rupiah($diskon) . '</td>'
                . '<td></td></tr>';
        $html .= '</table>';

        $html .= '<table class="tables"><tr><td></td></tr></table>';
        $html .= '<table class="tables" width="300" style="font-size:11px;">';
        $html .= '<tr><td class="bold center">Mengetahui</td><td class="bold center">Keuangan</td><td class="bold center">Accounting</td><td class="bold center">Penerima</td></tr>';
        $html .= '<tr><td colspan="4"></td></tr>';
        $html .= '<tr><td colspan="4"></td></tr>';
        $html .= '<tr><td><hr /></td><td><hr /></td><td><hr /></td><td><hr /></td></tr>';


        /* Counter Printer */
        $user = $data['user'];
        $prn_cnt = $read->prn_cnt;
        $user2 = $read->prn_by;


        if ($prn_cnt !== 0) {
            $user = $user2;
        }

        $viewcnt = array(
            'user' => $user,
            'prn_cnt' => $prn_cnt,
            'action' => $data['action']
        );

        $html .= $this->viewPrnCnt($viewcnt);
        /* Counter Printer */
        $html .= '</table>';
        //$html .= '<span style="font-size:7.5pt; float:right;">Dicetak Oleh: ' . $user . '</span>';

        $output = array(
            'html' => $html,
            'number' => $veh_dpsgh->dp_inv_no
        );

        return $output;
    }

}
