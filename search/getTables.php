<?php

include '../services/globalFunctions.php';
session_start();
$param = $_POST["table"];
$_SESSION["pakai"] = $param;

$cond = '';

function getCaption($lcKeyWord) {
    $lang_id = "ENG";
    if ($lang_id == 'ENG') {

        $conn = connDB();
        $sql = "Select eng from dictionary where keyword='$lcKeyWord'";
        $result = mysql_query($sql) or die(mysql_error() . $sql);
        $row = mysql_fetch_array($result);
        $lcKeyWord = $row['eng'];
    }
    return $lcKeyWord;
}

switch ($param) {
    case "set_vglh":
        $table = array(
            getCaption("Divisi") => 'inv_div',
            getCaption("Transaksi") => 'trx_code',
            getCaption("Keterangan") => 'trx_desc',
            getCaption("Warehouse") => 'wrhs_code'
        );
        $_SESSION['judul'] = "Setting Chart Of Account Link";
        $_SESSION['tabel'] = json_encode($table);
        break;
    case "set_form":
        $table = array(
            getCaption("Kode") => 'form_code',
            getCaption("Keterangan") => 'form_name'
        );
        $_SESSION['judul'] = "Transaction Form";
        $_SESSION['tabel'] = json_encode($table);
        break;
    case "veh_dpch":
        $table = array(getCaption("No. Faktur") => 'dp_inv_no', getCaption("Tgl. Faktur") => 'dp_date', getCaption("No. SPK") => 'so_no', getCaption("Tgl. SPK") => 'so_date', getCaption("Kode Pelanggan") => 'cust_code', getCaption("Nama Pelanggan") => 'cust_name', getCaption("Harga Kendaraan") => 'veh_price', getCaption("Saldo Akhir") => 'dp_end', getCaption("Chassis") => 'chassis', getCaption("Engine") => 'engine', getCaption("Nama Kendaraan") => 'veh_name', getCaption("Transmisi") => 'veh_transm', getCaption("Kode Warna") => 'color_code', getCaption("Nama Warna") => 'color_name');
        $_SESSION['judul'] = "Down Payment";
        $_SESSION['tabel'] = json_encode($table);
        break;
    case "veh_spk":
        $table = array(getCaption("No. SPK") => 'so_no', getCaption("Tgl. SPK") => 'so_date', getCaption("Tanggal Urut SPK") => 'soseq_date', getCaption("Kode Pelanggan") => 'cust_code', getCaption("Nama Pelanggan") => 'cust_name', getCaption("Nama di STNK") => 'cust_rname', getCaption("Kode Sales") => 'srep_code', getCaption("Nama Sales") => 'srep_name', getCaption("Kode Kendaraan") => 'veh_code', getCaption("Nama Kendaraan") => 'veh_name', getCaption("Chassis") => 'chassis', getCaption("Transmisi") => 'veh_transm', getCaption("Kode Warna") => 'color_code');
        $_SESSION['judul'] = "SPK";
        $_SESSION['tabel'] = json_encode($table);
        break;
    case "veh_slh":
        $table = array(getCaption("No. Faktur Jual") => 'sal_inv_no', getCaption("Tgl. Faktur") => 'sal_date', getCaption("No. SPK") => 'so_no', getCaption("Kode Pelanggan") => 'cust_code', getCaption("Nama Pelanggan") => 'cust_name', getCaption("Nama di STNK") => 'cust_rname', getCaption("Kode Sales") => 'srep_code', getCaption("Nama Sales") => 'srep_name', getCaption("Kode Kendaraan") => 'veh_code', getCaption("Nama Kendaraan") => 'veh_name', getCaption("Chassis") => 'chassis', getCaption("Transmisi") => 'veh_transm', getCaption("Kode Warna") => 'color_code', getCaption("Nama Warna") => 'color_name');

        $_SESSION['judul'] = "Vehicle Sales";
        $_SESSION['tabel'] = json_encode($table);
        break;

    case "veh_po":
        $table = array(getCaption("No. PO") => 'po_no', getCaption("Tgl. PO") => 'po_date', getCaption("Warehouse") => 'wrhs_code', getCaption("Kode Supplier") => 'supp_code', getCaption("Nama Supplier") => 'supp_name', getCaption("Chassis") => 'chassis', getCaption("Model") => 'veh_model', getCaption("Nama Warna") => 'color_name', getCaption("Tgl J. Tempo") => 'due_date');
        $_SESSION['judul'] = "Vehicle Purchase Order";
        $_SESSION['tabel'] = json_encode($table);
        break;
    case "veh_prh":
        $table = array(getCaption("No. Faktur") => 'pur_inv_no', getCaption("No. PO") => 'po_no', getCaption("Tgl. PO") => 'po_date', getCaption("Warehouse") => 'wrhs_code', getCaption("Kode Supplier") => 'supp_code', getCaption("Nama Supplier") => 'supp_name', getCaption("Chassis") => 'chassis', getCaption("Model") => 'veh_model', getCaption("Nama Warna") => 'color_name', getCaption("Tgl J. Tempo") => 'due_date');

        $_SESSION['judul'] = "Vehicle Receiving/Purchasing";
        $_SESSION['tabel'] = json_encode($table);

        break;
    case "veh_rslh":
        $table = array(getCaption("Faktur Retur") => 'rsl_inv_no', getCaption("Tgl. Faktur Retur") => 'rsl_date', getCaption("No. Faktur Jual") => 'sal_inv_no', getCaption("Tgl. Faktur Jual") => 'sal_date', getCaption("Kode Pelanggan") => 'cust_code', getCaption("Nama Pelanggan") => 'cust_name', getCaption("Nama di STNK") => 'cust_rname', getCaption("Kode Sales") => 'srep_code', getCaption("Nama Sales") => 'srep_name', getCaption("Kode Kendaraan") => 'veh_code', getCaption("Nama Kendaraan") => 'veh_name', getCaption("Chassis") => 'chassis', getCaption("Transmisi") => 'veh_transm', getCaption("Kode Warna") => 'color_code', getCaption("Nama Warna") => 'color_name');

        $_SESSION['judul'] = "Vehicle Sales Return";
        $_SESSION['tabel'] = json_encode($table);

        break;
    case "veh_rprh":
        $table = array(getCaption("Faktur Retur") => 'rpr_inv_no', getCaption("Tgl. Faktur Retur") => 'rpr_date', getCaption("No. Faktur Beli") => 'pur_inv_no', getCaption("Tgl. Faktur Beli") => 'pur_date', getCaption("Kode Supplier") => 'supp_code', getCaption("Nama Supplier") => 'supp_name', getCaption("No. PO") => 'po_no', getCaption("Tgl. PO") => 'po_date', getCaption("Nama Sales") => 'srep_name', getCaption("Kode Kendaraan") => 'veh_code', getCaption("Nama Kendaraan") => 'veh_name', getCaption("Chassis") => 'chassis', getCaption("Transmisi") => 'veh_transm', getCaption("Kode Warna") => 'color_code', getCaption("Nama Warna") => 'color_name');

        $_SESSION['judul'] = "Vehicle Purchase Return";
        $_SESSION['tabel'] = json_encode($table);

        break;
    case "veh_stk":
        $table = array(getCaption("No. Faktur Beli") => 'pur_inv_no', getCaption("Tgl. Faktur Beli") => 'pur_date', getCaption("Kode Supplier") => 'supp_code', getCaption("Nama Supplier") => 'supp_name', getCaption("No. SPK") => 'so_no', getCaption("Tanggal Match") => 'match_date', getCaption("Kode Kendaraan") => 'veh_code', getCaption("Nama Kendaraan") => 'veh_name', getCaption("Chassis") => 'chassis', getCaption("Lokasi") => 'veh_transm', getCaption("Kode Warna") => 'color_code', getCaption("Nama Warna") => 'color_name');

        $_SESSION['judul'] = "Vehicle Stock";
        $_SESSION['tabel'] = json_encode($table);

        break;
    case "veh_arh":
        $table = array(getCaption("No. Faktur") => 'sal_inv_no', getCaption("Tgl. Faktur") => 'sal_date', getCaption("Tgl J. Tempo") => 'due_date', getCaption("Kode Pelanggan") => 'cust_code', getCaption("Nama Pelanggan") => 'cust_name', getCaption("Kode Kendaraan") => 'veh_code', getCaption("Nama Kendaraan") => 'veh_name', getCaption("Chassis") => 'chassis', getCaption("No. SPK") => 'so_no', getCaption("Jumlah Faktur") => 'inv_total', getCaption("Piutang Akhir") => 'pd_end');
        $_SESSION['judul'] = "Account Receivable Payment 1";
        $_SESSION['tabel'] = json_encode($table);

        break;
    case "veh_ard":
        $table = array(getCaption("No. Faktur Jual") => 'sal_inv_no', getCaption("Tgl. Faktur Jual") => 'sal_date', getCaption("Tanggal Bayar") => 'pay_date', getCaption("Kode Bank") => 'bank_code', getCaption("No. Check") => 'check_no', getCaption("Pembayaran") => 'pay_val', getCaption("Diskon") => 'disc_val', getCaption("Dibayar Oleh") => "payer_name", getCaption("Alamat") => "payer_addr", getCaption("Keterangan") => 'pay_desc', getCaption("No. Kwitansi") => 'kwit_ono', getCaption("Tgl. Kwitansi") => 'kwit_odate');

        $_SESSION['judul'] = "Account Receivable Payment 2";
        $_SESSION['tabel'] = json_encode($table);

        break;
    case "veh_argh":

        $table = array(
            getCaption("No. Faktur") => 'arg_inv_no',
            getCaption("Tgl. Faktur") => 'arg_date',
            getCaption("Tgl. Buat") => 'opn_date',
            getCaption("Kode Pelanggan") => 'cust_code',
            getCaption('Tgl. Bayar') => 'pay_date',
            getCaption('Jenis Bayar') => 'pay_type',
            getCaption("Bank") => 'bank_code',
            getCaption("Pembayaran") => 'tot_paid',
            getCaption("No. Check") => 'check_no',
            getCaption("tanggal Check") => 'check_date',
            getCaption("Tgl J. Tempo") => 'due_date',
            getCaption("Nama Pelanggan") => 'cust_name'
        );

        $_SESSION['judul'] = "Account Receivable Group Payment";
        $_SESSION['tabel'] = json_encode($table);

        break;
    case "veh_argd":
        $table = array(
            getCaption("Chassis") => 'chassis',
            getCaption("No. Faktur Jual") => 'sal_inv_no',
            getCaption("No. SPK") => 'so_no',
            getCaption("Piutang") => 'inv_total',
            getCaption("Saldo Awal") => 'pd_begin',
            getCaption("Pembayaran") => 'pd_paid',
            getCaption("Diskon") => 'pd_disc',
            getCaption("Saldo Akhir") => 'pd_end',
            getCaption("Engine") => 'engine',
            getCaption("Kode Kendaraan") => 'veh_code',
            getCaption("Nama Kendaraan") => 'veh_name',
            getCaption("Tahun") => 'veh_year',
            getCaption("Transmisi") => 'veh_transm',
            getCaption("Kode Warna") => 'color_code',
            getCaption("Nama Warna") => 'color_name'
        );
        $_SESSION['judul'] = "Account Receivable Payment Detail";
        $_SESSION['tabel'] = json_encode($table);

        break;

    case 'vehdpcch':
        $table = array(
            getCaption("No. Faktur Batal") => 'dpc_inv_no',
            getCaption("Tgl. Faktur") => 'dpc_date',
            getCaption("No. Faktur") => 'dp_inv_no',
            getCaption("No. SPK") => 'so_no',
            getCaption("Tgl. SPK") => 'so_date',
            getCaption("Nama Pelanggan") => 'cust_name',
            getCaption("Warna") => 'color_name',
            getCaption("Chassis") => 'chassis',
            getCaption("Nama Kendaraan") => 'veh_name',
            getCaption("Kode Pelanggan") => 'cust_code'
        );

        $_SESSION['judul'] = "Booking Fee Cancellation";
        $_SESSION['tabel'] = json_encode($table);
        break;

    case "acc_aph":
        $table = array(
            getCaption("No. Faktur") => 'pur_inv_no',
            getCaption("Tgl. Faktur") => 'pur_date',
            getCaption("Kode Supplier") => 'supp_code',
            getCaption("Nama Supplier") => 'supp_name',
            getCaption("Tgl J. Tempo") => 'due_date',
            getCaption("No. Faktur Supplier") => 'supp_invno',
            getCaption("Tgl. Faktur Supplier") => 'supp_invdt',
            getCaption("No. PO") => 'po_no',
            getCaption("Tgl. PO") => 'po_date',
            getCaption("Chassis") => 'chassis',
            getCaption("Nama Kendaraan") => 'veh_name',
            getCaption("No. SPK") => 'so_no',
            getCaption('Jumlah Faktur') => 'inv_total',
            getCaption('Hutang Akhir') => 'hd_end');

        $_SESSION['judul'] = "Accessories Payable Payment";
        $_SESSION['tabel'] = json_encode($table);

        break;

    case "acc_arh":
        $table = array(getCaption("No. Faktur") => 'sal_inv_no', getCaption("Tgl. Faktur") => 'sal_date', getCaption("Kode Pelanggan") => 'cust_code', getCaption("Nama Pelanggan") => 'cust_name', getCaption("Tgl J. Tempo") => 'due_date', getCaption("Kode Sales") => 'srep_code', getCaption("Nama Sales") => 'srep_name', getCaption("Jumlah Faktur") => 'inv_total', getCaption("Piutang Akhir") => 'pd_end');

        $_SESSION['judul'] = "Accessories Receivable Payment";
        $_SESSION['tabel'] = json_encode($table);

        break;
    case "acc_poh":
        $table = array(getCaption("No. PO") => 'po_no', getCaption("Tgl. PO") => 'po_date', getCaption("Tgl. Buat") => 'opn_date', getCaption("Jenis PO") => 'po_type', getCaption("No. Quotation") => 'quote_no', getCaption("Tgl. Quotation") => 'quote_date', getCaption("Kode Supplier") => 'supp_code', getCaption("Nama Supplier") => 'supp_name', getCaption("Kode Purchaser") => 'prep_code', getCaption("Nama Purchaser") => 'prep_name', getCaption("Kode Penerima") => 'raddr_code', getCaption("Nama Penerima") => 'rname', getCaption("Warehouse") => 'wrhs_code', 'Note 1' => 'note', 'Note 2' => 'note2', 'Note 3' => 'note3', 'Note 4' => 'note4');

        $_SESSION['judul'] = "Accessories Purchase Order";
        $_SESSION['tabel'] = json_encode($table);

        break;
    case "acc_prh":
        $table = array(getCaption("No. Faktur") => 'pur_inv_no', getCaption("Tgl. Faktur") => 'pur_date', getCaption("Kode Supplier") => 'supp_code', getCaption("Nama Supplier") => 'supp_name', getCaption("Tgl. Terima") => 'rcv_date', getCaption("No. PO") => 'po_no', getCaption("Tgl. PO") => 'po_date', getCaption("No. Surat Jalan") => 'sj_no', getCaption("Tgl. Surat Jalan") => 'sj_date', getCaption("No. Faktur Supplier") => 'supp_invno', getCaption("Tgl. Faktur Supplier") => 'supp_invdt');

        $_SESSION['judul'] = "Accessories Receiving/Purchasing";
        $_SESSION['tabel'] = json_encode($table);

        break;
    case "acc_opnh":
        $table = array(getCaption("No. Faktur") => 'opn_inv_no', getCaption("Tgl. Faktur") => 'opn_date', getCaption("Tgl. Buat") => 'open_date', getCaption("Kode Yang Opname") => 'oprep_code', getCaption("Nama Yang Opname") => 'oprep_name');

        $_SESSION['judul'] = "Accessories Opname";
        $_SESSION['tabel'] = json_encode($table);

        break;
    case "acc_rprh":
        $table = array(getCaption("No. Faktur") => 'rpr_inv_no', getCaption("Tgl. Faktur") => 'rpr_date', getCaption("No. Faktur Beli") => 'pur_inv_no', getCaption("Tgl. Faktur Beli") => 'pur_date', getCaption("Kode Supplier") => 'supp_code', getCaption("Nama Supplier") => 'supp_name', getCaption("No. Surat Jalan") => 'sj_no', getCaption("Tgl. Surat Jalan") => 'sj_date', getCaption("No. PO") => 'po_no', getCaption("Tgl. PO") => 'po_date');

        $_SESSION['judul'] = "Accessories Purchase Return";
        $_SESSION['tabel'] = json_encode($table);

        break;
    case "acc_movh":
        $table = array(getCaption("No. Faktur") => 'mov_inv_no', getCaption("Tgl. Faktur") => 'mov_date', getCaption("Tgl. Buat") => 'opn_date', getCaption("Kode Yang Memindahkan") => 'mvrep_code', getCaption("Nama Yang Memindahkan") => 'mvrep_name', getCaption("Dari Warehouse") => 'wrhs_from', getCaption("Ke Warehouse") => 'wrhs_to');

        $_SESSION['judul'] = "Accessories Moving";
        $_SESSION['tabel'] = json_encode($table);

        break;
    case "acc_worh":
        $table = array(getCaption("No. SPOK") => 'wor_no', getCaption("Tgl. SPOK") => 'wor_date', getCaption("Tgl. Buat") => 'opn_date', getCaption("Jenis SPOK") => 'oreq_type', getCaption("Kode Department") => 'dept_code', getCaption("Nama Department") => 'dept_name', getCaption("Kode Unit") => 'dunit_code', getCaption("Nama Unit") => 'dunit_name');

        $_SESSION['judul'] = "Accessories Work Order Request";
        $_SESSION['tabel'] = json_encode($table);

        break;
    case "acc_woh":
        $table = array(getCaption("No. WO") => 'wo_no', getCaption("Tgl. WO") => 'wo_date', getCaption("Tgl. Buat") => 'opn_date', getCaption("Chassis") => 'chassis', getCaption("No. SPK") => 'so_no', getCaption("Tgl. SPK") => 'so_date', getCaption("No. Quotation") => 'quote_no', getCaption("Tgl. Quotation") => 'quote_date', getCaption("Kode Supplier") => 'supp_code', getCaption("Nama Supplier") => 'supp_name', getCaption("Kode Purchaser") => 'prep_code', getCaption("Nama Purchaser") => 'prep_name', getCaption("Kode Penerima") => 'raddr_code', getCaption("Nama Penerima") => 'rname');

        $_SESSION['judul'] = "Accessories Work Order";
        $_SESSION['tabel'] = json_encode($table);

        break;
    case "acc_wprh":
        $table = array(getCaption("No. Faktur") => 'pur_inv_no', getCaption("Tgl. Faktur") => 'pur_date', getCaption("Tgl. Buat") => 'opn_date', getCaption("Chassis") => 'chassis', getCaption("No. SPK") => 'so_no', getCaption("Tgl. SPK") => 'so_date', getCaption("Kode Supplier") => 'supp_code', getCaption("Nama Supplier") => 'supp_name', getCaption("Tgl. Terima") => 'rcv_date', getCaption("Kode Pelanggan") => 'cust_code', getCaption("Nama Pelanggan") => 'cust_name');

        $_SESSION['judul'] = "Accessories Receiving/Purchasing";
        $_SESSION['tabel'] = json_encode($table);

        break;
    case "veh_slh":
        $table = array(getCaption("No. Faktur Jual") => 'sal_inv_no', getCaption("Tgl. Faktur") => 'sal_date', getCaption("Kode Pelanggan") => 'cust_code', getCaption("Nama Pelanggan") => 'cust_name', getCaption("Nama di STNK") => 'cust_rname', getCaption("Kode Sales") => 'srep_code', getCaption("Nama Sales") => 'srep_name', getCaption("Kode Kendaraan") => 'veh_code', getCaption("Nama Kendaraan") => 'veh_name', getCaption("Chassis") => 'chassis', getCaption("No. Polisi") => 'veh_reg_no', getCaption("Kode Warna") => 'color_code', getCaption("Nama Warna") => 'color_name', getCaption("Kode Leasing") => 'lease_code', getCaption("Nama Leasing") => 'lease_name', "Debitor" => "cust_dname");

        $_SESSION['judul'] = "Credit Application";
        $_SESSION['tabel'] = json_encode($table);

        break;
    case "veh_doc":
        $table = array(getCaption("No. Dokumen") => 'doc_inv_no', getCaption("Tgl. Dokumen") => 'doc_date', getCaption("No. Faktur Jual") => 'sal_inv_no', getCaption("Tgl. Faktur Jual") => 'sal_date', getCaption("Nama Di STNK") => 'cust_rname', getCaption("No. Polisi") => 'veh_reg_no', getCaption("Kode Pelanggan") => 'cust_code', getCaption("Nama Pelanggan") => 'cust_name', getCaption("Kode Sales") => 'srep_code', getCaption("Nama Sales") => 'srep_name', getCaption("Kode Kendaraan") => 'veh_code', getCaption("Nama Kendaraan") => 'veh_name', getCaption("Chassis") => 'chassis', getCaption("Transmisi") => 'veh_transm', getCaption("Kode Warna") => 'color_code', getCaption("Nama Warna") => 'color_name');

        $_SESSION['judul'] = "Vehicle Documents";
        $_SESSION['tabel'] = json_encode($table);

        break;
    case "veh_bwoh":
        $table = array(getCaption("No. WO") => 'wo_no', getCaption("Tgl. WO") => 'wo_date', getCaption("Tgl. Pick") => 'opn_date', getCaption("No. Quotation") => 'quote_no', getCaption("Tgl. Quotation") => 'quote_date', getCaption("Kode Biro Jasa") => 'supp_code', getCaption("Nama Biro Jasa") => 'supp_name', getCaption("Kode Purchaser") => 'prep_code', getCaption("Nama Purchaser") => 'prep_name', getCaption("Kode Penerima") => 'raddr_code', getCaption("Nama Penerima") => 'rname');

        $_SESSION['judul'] = "BBN Work Order 1";
        $_SESSION['tabel'] = json_encode($table);

        break;
    case "veh_bwod":
        $table = array(getCaption("No. WO") => 'wo_no', getCaption("Tgl. WO") => 'wo_date', getCaption("Chassis") => 'chassis', getCaption("No. SPK") => 'so_no', getCaption("Tgl. SPK") => 'so_date', getCaption("Kode Kendaraan") => 'veh_code', getCaption("Nama Kendaraan") => 'veh_name', getCaption("No. Faktur Jual") => 'sal_inv_no', getCaption("Nama Pelanggan") => 'cust_name', getCaption("Nama Sales") => 'srep_name', getCaption("Warna") => 'color_name');

        $_SESSION['judul'] = "BBN Work Order 2";
        $_SESSION['tabel'] = json_encode($table);

        break;
    case "veh_bprh":
        $table = array(getCaption("No. Faktur Beli") => 'pur_inv_no', getCaption("Tgl. Faktur Beli") => 'pur_date', getCaption("Tgl. Buat") => 'opn_date', getCaption("Kode Biro Jasa") => 'supp_code', getCaption("Nama Biro Jasa") => 'supp_name', getCaption("No. Surat Jalan") => 'sj_no', getCaption("No. Faktur Supplier") => 'supp_invno', getCaption("No. WO") => 'wo_no');

        $_SESSION['judul'] = "BBN Registration 1";
        $_SESSION['tabel'] = json_encode($table);

        break;
    case "veh_bprd":
        $table = array(getCaption("No. Faktur Beli") => 'pur_inv_no', getCaption("Tgl. Faktur Beli") => 'pur_date', getCaption("No. WO") => 'wo_no', getCaption("Chassis") => 'chassis', getCaption("No. SPK") => 'so_no', getCaption("Tgl. SPK") => 'so_date', getCaption("Kode Kendaraan") => 'veh_code', getCaption("Nama Kendaraan") => 'veh_name', getCaption("No. Faktur Jual") => 'sal_inv_no', getCaption("Nama Pelanggan") => 'cust_name', getCaption("Nama Sales") => 'srep_name', getCaption("Warna") => 'color_name');

        $_SESSION['judul'] = "BBN Registration 2";
        $_SESSION['tabel'] = json_encode($table);

        break;

    case "veh_aph":
        $table = array(
            getCaption("No. Faktur") => 'pur_inv_no',
            getCaption("Tgl. Faktur") => 'pur_date',
            getCaption("No. PO") => 'po_no',
            getCaption("Nama Supplier") => 'supp_name',
            getCaption("No. Faktur Supplier") => 'supp_invno',
            getCaption("Chassis") => 'chassis',
            getCaption("Nama Kendaraan") => 'veh_name',
            getCaption("Engine") => 'engine',
            getCaption("Jatuh Tempo") => 'due_date',
            getCaption("Kode Supplier") => 'supp_code',
            getCaption("Kode Kendaraan") => 'veh_code',
            getCaption("Jumlah Faktur") => 'inv_total',
            getCaption("Hutang Akhir") => 'hd_end',
        );
        $_SESSION['judul'] = "Account Payable Payment";
        $_SESSION['tabel'] = json_encode($table);
        break;

    case 'veh_apgh':
        $table = array(
            getCaption("No. Faktur") => 'apg_inv_no',
            getCaption("Tgl. Faktur") => 'apg_date',
            getCaption("No. Voucher") => 'apv_inv_no',
            getCaption("Tgl. Voucher") => 'apv_date',
            getCaption("Tgl. Buat") => 'opn_date',
            getCaption("Nama Supplier") => 'supp_name',
            getCaption("Tgl. Bayar") => 'pay_date',
            getCaption("Jenis Bayar") => 'pay_type',
            getCaption("Pembayaran") => 'tot_paid',
            getCaption("Bank") => 'bank_code',
            getCaption("No. Check") => 'check_no',
            getCaption("Tanggal Check") => 'check_date',
            getCaption("Jatuh Tempo") => 'due_date',
            getCaption("Kode Supplier") => 'supp_code'
        );

        $_SESSION['judul'] = "Vehicle Account Payable Group Payment";
        $_SESSION['tabel'] = json_encode($table);
        break;

    case 'veh_apgd':
        $table = array(
            getCaption("Chassis") => 'chassis',
            getCaption("No. Faktur") => 'apg_inv_no',
            getCaption("No. PO") => 'po_no',
            getCaption("No. Voucher") => 'apv_inv_no',
            getCaption("Hutang") => 'inv_total',
            getCaption("Saldo Awal") => 'hd_begin',
            getCaption("Pembayaran") => 'hd_paid',
            getCaption("Diskon") => 'hd_disc',
            getCaption("Saldo Akhir") => 'hd_end',
            getCaption("Engine") => 'engine',
            getCaption("Kode Kendaraan") => 'veh_code',
            getCaption("Nama Kendaraan") => 'veh_name',
            getCaption("Tahun") => 'veh_year',
            getCaption("Transmisi") => 'veh_transm',
            getCaption("Kode Warna") => 'color_code',
            getCaption("Nama Warna") => 'color_name'
        );
        $_SESSION['judul'] = "Vehicle Account Payable Detail";
        $_SESSION['tabel'] = json_encode($table);
        break;

    case 'veh_apvh':
        $table = array(
            getCaption("No. Voucher") => 'apv_inv_no',
            getCaption("Tgl. Voucher") => 'apv_date',
            getCaption("Tgl. Buat") => 'opn_date',
            getCaption("Nama Supplier") => 'supp_name',
            getCaption("Tgl. Bayar") => 'pay_date',
            getCaption("Jenis Bayar") => 'pay_type',
            getCaption("Pembayaran") => 'tot_paid',
            getCaption("Bank") => 'bank_code',
            getCaption("No. Check") => 'check_no',
            getCaption("Jatuh Tempo") => 'due_date',
            getCaption("Kode Supplier") => 'supp_code',
        );

        $_SESSION['judul'] = "Voucher Vehicle Payable";
        $_SESSION['tabel'] = json_encode($table);
        break;

    case "veh_prc":
        $table = array(getCaption("Kode Kendaraan") => 'veh_code', getCaption("Tipe Warna") => 'col_type', getCaption('Deskripsi') => 'veh_name', getCaption('Merek') => 'veh_brand', getCaption("Tipe") => 'veh_type', getCaption("Model") => 'veh_model', getCaption("Tahun") => 'veh_year', getCaption("Transmisi") => 'veh_transm', getCaption("Chassis") => 'chassis', getCaption("Catatan") => 'note', getCaption("Tgl. Aktif") => 'act_date',);

        $_SESSION['judul'] = "Vehicle Price Master Data";
        $_SESSION['tabel'] = json_encode($table);

        break;
    case "veh_srep":
        $table = array(getCaption("Kode Sales") => 'srep_code', getCaption("Nama Sales") => 'srep_name', getCaption("Alamat") => 'haddr', getCaption("Telepon") => 'hphone', getCaption("HP Pribadi") => 'hp', getCaption("Jenis Kelamin") => 'sex', getCaption("Tanggal Masuk") => 'in_date', getCaption("Tanggal Keluar") => 'out_date', getCaption("Tanggal Lahir") => 'dob');

        $_SESSION['judul'] = "Vehicle Sales Person Master Data";
        $_SESSION['tabel'] = json_encode($table);

        break;
    case "veh_supp":
        $table = array(getCaption("Kode Supplier") => 'supp_code', getCaption("Nama Supplier") => 'supp_name', getCaption("Jenis Kelamin") => 'sex', getCaption("Alamat Kantor") => 'oaddr', getCaption("No. Telepon Kantor") => 'ophone', getCaption("Alamat Rumah") => 'haddr', getCaption("No. Telepon Rumah") => 'hphone');

        $_SESSION['judul'] = "Vehicle Supplier Master Data";
        $_SESSION['tabel'] = json_encode($table);

        break;
    case "veh_coll":
        $table = array(getCaption("Kode Kolektor") => 'coll_code', getCaption("Nama Kolektor") => 'coll_name', getCaption("Alamat") => 'haddr', getCaption("Telepon") => 'hphone', getCaption("HP Pribadi") => 'hp', getCaption("Jenis Kelamin") => 'sex', getCaption("Tanggal Masuk") => 'in_date', getCaption("Tanggal Keluar") => 'out_date', getCaption("Tanggal Lahir") => 'dob');

        $_SESSION['judul'] = "Vehicle Collector Master Data";
        $_SESSION['tabel'] = json_encode($table);

        break;
    case "veh_vtyp":
        $table = array(getCaption("Kode Kendaraan") => 'veh_code', getCaption("Nama Kendaraan") => 'veh_name', getCaption("Merek") => 'veh_brand', getCaption("Tipe") => 'veh_type', getCaption("Model") => 'veh_model', getCaption("Tahun") => 'veh_year', getCaption("Transmisi") => 'veh_transm', getCaption("Chassis") => 'chassis', getCaption("Catatan") => 'note', getCaption("Tanggal Aktif") => 'act_date');

        $_SESSION['judul'] = "Vehicle Type Master Data";
        $_SESSION['tabel'] = json_encode($table);

        break;
    case "color":
        $table = array(getCaption("Kode Warna") => 'color_code', getCaption("Nama Warna") => 'color_name', getCaption("Tipe Warna") => 'col_type', getCaption("Catatan") => 'note', getCaption("Tgl. Aktif") => 'act_date', getCaption("Tgl. Non Aktif") => 'exp_date');

        $_SESSION['judul'] = "Vehicle Color Master Data";
        $_SESSION['tabel'] = json_encode($table);

        break;
    case "veh_wkcd":
        $table = array(getCaption("Kode Pekerjaan") => 'wk_code', getCaption("Nama Pekerjaan") => 'wk_desc', getCaption("Harga Beli") => 'pur_price', getCaption("Harga Jual") => 'sal_price', getCaption("Diinput Oleh") => 'add_by', getCaption("Tgl. Input") => 'add_date');

        $_SESSION['judul'] = "Vehicle Work Master Data";
        $_SESSION['tabel'] = json_encode($table);

        break;
    case "insurance":
        $table = array(getCaption("Kode Asuransi") => 'insr_code', getCaption("Nama Asuransi") => 'insr_desc', getCaption("Jenis Kelamin") => 'sex', getCaption("Alamat Kantor") => 'oaddr', getCaption("No. Telepon Kantor") => 'ophone', getCaption("Alamat Rumah") => 'haddr', getCaption("No. Telepon Rumah") => 'hphone');

        $_SESSION['judul'] = "Vehicle Insurance Master Data";
        $_SESSION['tabel'] = json_encode($table);

        break;
    case "bank":
        $table = array(getCaption("Kode Bank") => 'bank_code', getCaption("Nama Bank") => 'bank_name', getCaption("Alamat") => 'oaddr', getCaption("Kode Pos") => 'ozipcode', getCaption("Kota") => 'ocity', getCaption("Telepon") => 'ophone', getCaption("Fax") => 'ofax', getCaption("Catatan") => 'note', getCaption("Email") => 'oemail');

        $_SESSION['judul'] = "Vehicle Bank Master Data";
        $_SESSION['tabel'] = json_encode($table);

        break;
    case "lease":
        $table = array(getCaption("Kode Leasing") => 'lease_code', getCaption("Nama Leasing") => 'lease_name', getCaption("Alamat") => 'oaddr', getCaption("Kode Pos") => 'ozipcode', getCaption("Kota") => 'ocity', getCaption("Telepon") => 'ophone', getCaption("Fax") => 'ofax', getCaption("Catatan") => 'note', getCaption("Email") => 'oemail');

        $_SESSION['judul'] = "Vehicle Leasing Master Data";
        $_SESSION['tabel'] = json_encode($table);

        break;
    case "agent":
        $table = array(getCaption("Kode Biro Jasa") => 'agent_code', getCaption("Nama Biro Jasa") => 'agent_name', getCaption("Alamat") => 'oaddr', getCaption("Kode Pos") => 'ozipcode', getCaption("Kota") => 'ocity', getCaption("Telepon") => 'ophone', getCaption("Fax") => 'ofax', getCaption("Catatan") => 'note', getCaption("Email") => 'oemail');

        $_SESSION['judul'] = "Vehicle Agent Master Data";
        $_SESSION['tabel'] = json_encode($table);

        break;
    case "veh_pcus":
        $table = array(
            getCaption("Kode Pelanggan") => 'cust_code',
            getCaption("Nama Pelanggan") => 'cust_name',
            getCaption("Jenis Kelamin") => 'sex',
            getCaption("Alamat Kantor") => 'oaddr',
            getCaption("No. Telepon Kantor") => 'ophone',
            getCaption("Alamat Rumah") => 'haddr',
            getCaption("No. Telepon Rumah") => 'hphone');

        $_SESSION['judul'] = "Vehicle Prospective Customer Master Data";
        $_SESSION['tabel'] = json_encode($table);

        break;
    case "veh_cust":
        $table = array(getCaption("Kode Pelanggan") => 'cust_code', getCaption("Nama Pelanggan") => 'cust_name', getCaption("Jenis Kelamin") => 'sex', getCaption("Alamat Kantor") => 'oaddr', getCaption("No. Telepon Kantor") => 'ophone', getCaption("Alamat Rumah") => 'haddr', getCaption("No. Telepon Rumah") => 'hphone');

        $_SESSION['judul'] = "Vehicle Customer Master Data";
        $_SESSION['tabel'] = json_encode($table);

        break;

    case "veh_sspv":
        $table = array(getCaption("Kode Supervisor") => 'sspv_code', getCaption("Nama Supervisor") => 'sspv_name', getCaption("Alamat") => 'haddr', getCaption("Telepon") => 'hphone', getCaption("HP Pribadi") => 'hp', getCaption("Tanggal Masuk") => 'in_date', getCaption("Tanggal Keluar") => 'out_date', getCaption("dob") => 'out_date');

        $_SESSION['judul'] = "Vehicle Supervisor Master Data";
        $_SESSION['tabel'] = json_encode($table);

        break;

    case "veh_stdopt":
        $table = array(getCaption("Kode Std. Optional") => 'stdoptcode', getCaption("Nama Std. Optional") => 'stdoptname');

        $_SESSION['judul'] = "Standard Optional Master Data";
        $_SESSION['tabel'] = json_encode($table);

        break;

    case "acc_cust":
        $table = array(getCaption("Kode Pelanggan") => 'cust_code', getCaption("Nama Pelanggan") => 'cust_name', getCaption("Jenis Kelamin") => 'sex', getCaption("Alamat Kantor") => 'oaddr', getCaption("No. Telepon Kantor") => 'ophone', getCaption("Alamat Rumah") => 'haddr', getCaption("No. Telepon Rumah") => 'hphone');

        $_SESSION['judul'] = "Accessories Customer Master Data";
        $_SESSION['tabel'] = json_encode($table);

        break;
    case "acc_supp":
        $table = array(getCaption("Kode Supplier") => 'supp_code', getCaption("Nama Supplier") => 'supp_name', getCaption("Jenis Kelamin") => 'sex', getCaption("Alamat Kantor") => 'oaddr', getCaption("No. Telepon Kantor") => 'ophone', getCaption("Alamat Rumah") => 'haddr', getCaption("No. Telepon Rumah") => 'hphone');

        $_SESSION['judul'] = "Accessories Supplier Master Data";
        $_SESSION['tabel'] = json_encode($table);

        break;
    case "acc_srep":
        $table = array(getCaption("Kode Sales") => 'srep_code', getCaption("Nama Sales") => 'srep_name', getCaption("Alamat") => 'haddr', getCaption("Telepon") => 'hphone', getCaption("HP Pribadi") => 'hp', getCaption("Jenis Kelamin") => 'sex', getCaption("Tanggal Masuk") => 'in_date', getCaption("Tanggal Keluar") => 'out_date', getCaption("Tanggal Lahir") => 'dob');

        $_SESSION['judul'] = "Accessories Sales Person Master Data";
        $_SESSION['tabel'] = json_encode($table);

        break;
    case "acc_coll":
        $table = array(getCaption("Kode Kolektor") => 'coll_code', getCaption("Nama Kolektor") => 'coll_name', getCaption("Alamat") => 'haddr', getCaption("Telepon") => 'hphone', getCaption("HP Pribadi") => 'hp', getCaption("Jenis Kelamin") => 'sex', getCaption("Tanggal Masuk") => 'in_date', getCaption("Tanggal Keluar") => 'out_date', getCaption("Tanggal Lahir") => 'dob');

        $_SESSION['judul'] = "Accessories Collector Master Data";
        $_SESSION['tabel'] = json_encode($table);

        break;
    case "acc_prep":
        $table = array(getCaption("Kode Purchaser") => 'prep_code', getCaption("Nama Purchaser") => 'prep_name', getCaption("Alamat") => 'haddr', getCaption("Telepon") => 'hphone', getCaption("HP Pribadi") => 'hp', getCaption("Jenis Kelamin") => 'sex', getCaption("Tanggal Masuk") => 'in_date', getCaption("Tanggal Keluar") => 'out_date', getCaption("Tanggal Lahir") => 'dob');

        $_SESSION['judul'] = "Accessories Purchaser Master Data";
        $_SESSION['tabel'] = json_encode($table);

        break;
    case "acc_orep":
        $table = array(getCaption("Kode Opname") => 'oprep_code', getCaption("Nama Opname") => 'oprep_name', getCaption("Alamat") => 'haddr', getCaption("Telepon") => 'hphone', getCaption("HP Pribadi") => 'hp', getCaption("Jenis Kelamin") => 'sex', getCaption("Tanggal Masuk") => 'in_date', getCaption("Tanggal Keluar") => 'out_date', getCaption("Tanggal Lahir") => 'dob');

        $_SESSION['judul'] = "Accessories Opname Master Data";
        $_SESSION['tabel'] = json_encode($table);

        break;
    case "acc_wkcd":
        $table = array(getCaption("Kode Pekerjaan") => 'wk_code', getCaption("Nama Pekerjaan") => 'wk_desc', getCaption("Harga Beli") => 'pur_price', getCaption("Harga Jual") => 'sal_price', getCaption("Diinput Oleh") => 'add_by', getCaption("Tgl. Input") => 'add_date');

        $_SESSION['judul'] = "Accessories Work Master Data";
        $_SESSION['tabel'] = json_encode($table);

        break;

    case "acc_mst";
        $table = array(getCaption("No. Part") => 'part_code',
            getCaption("Nama Part") => 'part_name',
            getCaption("Satuan") => 'unit',
            getCaption("Sisa Stok") => 'qty',
            getCaption("Order Qty") => 'qty_order',
            getCaption("Pick Qty") => 'qty_pick',
            getCaption("Back Order Qty") => 'qty_border',
            getCaption("Dipakai Untuk") => 'use4_code',
            getCaption("Harga Jual + PPN") => 'total');
        $_SESSION['judul'] = "Accessories Parts / Accessories";
        $_SESSION['tabel'] = json_encode($table);
        break;

    case 'acc_slh':
        $table = array(
            getCaption("No. Faktur") => 'sal_inv_no',
            getCaption("Tgl. Faktur") => 'sal_date',
            getCaption("Kode Pelanggan") => 'cust_code',
            getCaption("Nama Pelanggan") => 'cust_name',
            getCaption("Jatuh Tempo") => 'due_date'
        );
        $_SESSION['judul'] = "Vehicle Accessories Sales";
        $_SESSION['tabel'] = json_encode($table);
        $cond = $_POST['cond'];
        break;

    case 'acc_rslh':
        $table = array(
            getCaption("No. Faktur") => 'rsl_inv_no',
            getCaption("Tgl. Faktur") => 'rsl_date',
            getCaption("No. Faktur Jual") => 'sal_inv_no',
            getCaption("Tgl. Faktur Jual") => 'sal_date',
            getCaption("Kode Pelanggan") => 'cust_code',
            getCaption("Nama Pelanggan") => 'cust_name',
            getCaption("No. SO") => 'so_no',
            getCaption("Tgl. SO") => 'so_date'
        );
        $_SESSION['judul'] = "Sales Return Accessories";
        $_SESSION['tabel'] = json_encode($table);
        break;

    case 'acc_wslh':
        $table = array(
            getCaption("No. Faktur Jual") => 'sal_inv_no',
            getCaption("Tgl. Faktur Jual") => 'sal_date',
            getCaption("Tgl. Buat") => 'opn_date',
            getCaption("Chassis") => 'chassis',
            getCaption("Kode Pelanggan") => 'cust_code',
            getCaption("Nama Pelanggan") => 'cust_name',
            getCaption("Kode Sales") => 'srep_code',
            getCaption("Nama Sales") => 'srep_name',
            getCaption("No. Surat Jalan") => 'sj_no',
            getCaption("No. WO") => 'wo_no',
            getCaption("Tgl. WO") => 'wo_date'
        );
        $_SESSION['judul'] = "Optional After-Sales";
        $_SESSION['tabel'] = json_encode($table);
        break;

    case 'credit':
        $table = array(
            getCaption("No. Faktur Jual") => 'sal_inv_no',
            getCaption("Tgl. Faktur") => 'sal_date',
            getCaption("Kode Pelanggan") => 'cust_code',
            getCaption("Nama Pelanggan") => 'cust_name',
            getCaption("Nama di STNK") => 'cust_rname',
            getCaption("Kode Sales") => 'srep_code',
            getCaption("Nama Sales") => 'srep_name',
            getCaption("Kode Kendaraan") => 'veh_code',
            getCaption("Nama Kendaraan") => 'veh_name',
            getCaption("Chassis") => 'chassis',
            getCaption("No. Polisi") => 'veh_reg_no',
            getCaption("Kode Warna") => 'color_code',
            getCaption("Nama Warna") => 'color_name',
            getCaption("Kode Leasing") => 'lease_code',
            getCaption("Nama Leasing") => 'lease_name'
        );

        $_SESSION['judul'] = "SPK";
        $_SESSION['tabel'] = json_encode($table);
        break;

    case 'prt_radd':
        $table = array(
            getCaption("Kode Alamat") => 'raddr_code',
            getCaption("Keterangan") => 'raddr_name',
            getCaption("Perusahaan") => 'oname',
            getCaption("Alamat") => 'oaddr',
            getCaption("Wilayah") => 'oarea',
            getCaption("Kota") => 'ocity'
        );
        $_SESSION['judul'] = "Receiving Address";
        $_SESSION['tabel'] = json_encode($table);
        break;

    case "veh_movh":
        $table = array(
            getCaption("No. Faktur") => 'mov_inv_no',
            getCaption("Tgl. Faktur") => 'mov_date',
            getCaption("Tgl. Buat") => 'opn_date',
            getCaption("Kode Yang Memindahkan") => 'mvrep_code',
            getCaption("Nama Yang Memindahkan") => 'mvrep_name',
            getCaption("Dari Warehouse") => 'wrhs_from',
            getCaption("Ke Warehouse") => 'wrhs_to',
            getCaption("Kendaraan") => 'veh_name',
            getCaption("Chassis") => 'chassis',
            getCaption("warna") => 'color_name');

        $_SESSION['judul'] = "Vehicle Movement";
        $_SESSION['tabel'] = json_encode($table);

        break;

    case 'acc_apgh':
        $table = array(
            getCaption("No. Faktur") => 'apg_inv_no',
            getCaption("Tgl. Faktur") => 'apg_date',
            getCaption("Tgl. Buat") => 'opn_date',
            getCaption("Dibayar ke") => 'supp_name',
            getCaption("Tgl. Bayar") => 'pay_date',
            getCaption("Jenis Bayar") => 'pay_type',
            getCaption("Pembayaran") => 'tot_paid',
            getCaption("Bank") => 'bank_code',
            getCaption("No. Check") => 'check_no',
            getCaption("Tanggal Check") => 'check_date',
            getCaption("Jatuh Tempo") => 'due_date',
            getCaption("Kode Supplier") => 'supp_code'
        );

        $_SESSION['judul'] = "Accessories Account Payable Group Payment";
        $_SESSION['tabel'] = json_encode($table);
        break;

    case 'acc_apgd':
        $table = array(
            getCaption("No. Faktur") => 'apg_inv_no',
            getCaption("No. PO") => 'po_no',
            getCaption("Hutang") => 'inv_total',
            getCaption("Saldo Awal") => 'hd_begin',
            getCaption("Pembayaran") => 'hd_paid',
            getCaption("Diskon") => 'hd_disc',
            getCaption("Saldo Akhir") => 'hd_end',
            getCaption("Engine") => 'engine',
            getCaption("Kode Kendaraan") => 'veh_code',
            getCaption("Nama Kendaraan") => 'veh_name',
            getCaption("Tahun") => 'veh_year',
            getCaption("Transmisi") => 'veh_transm',
            getCaption("Kode Warna") => 'color_code',
            getCaption("Nama Warna") => 'color_name'
        );
        $_SESSION['judul'] = "Accessories Account Payable Detail";
        $_SESSION['tabel'] = json_encode($table);
        break;

    case 'veh_comaph':
        $table = array(
            getCaption("No. Faktur") => 'sal_inv_no',
            getCaption("Tgl. Faktur") => 'sal_date',
            getCaption("No. SPK") => 'so_no',
            getCaption("Tgl. SPK") => 'so_date',
            getCaption("Dibayar Ke") => 'pay2_name',
            getCaption("Nama Pelanggan") => 'cust_name',
            getCaption("Hutang Akhir") => 'hd_end',
            getCaption("Pembayaran") => 'hd_paid',
            getCaption("Diskon") => 'hd_disc',
            getCaption("PPH") => 'hd_pph',
            getCaption("Chassis") => 'chassis',
            getCaption("Kode Pelanggan") => 'cust_code'
        );
        $_SESSION['judul'] = "Commission Payable";
        $_SESSION['tabel'] = json_encode($table);
        break;

    case 'veh':
        $table = array(
            getCaption("Chassis") => 'chassis',
            getCaption("Engine") => 'engine',
            getCaption("Nama Pelanggan") => 'cust_name',
            'STNK Name' => 'cust_rname',
            getCaption("Jenis Kelamin") => 'cust_sex',
            getCaption("No. Polisi") => 'veh_reg_no',
            getCaption("Nama Sales") => 'srep_name',
            getCaption("Kode Pelanggan") => 'cust_code',
            getCaption("Kode Kendaraan") => 'veh_code',
            getCaption("No. Faktur Jual") => 'sal_inv_no',
            getCaption("Faktur Pajak") => 'fp_no',
            getCaption("No. Surat Jalan") => 'sj_no'
        );
        $_SESSION['judul'] = "Vehicle Data (ALL IN)";
        $_SESSION['tabel'] = json_encode($table);

        break;

    case 'veh_dpsh':
        $table = array(
            getCaption("No. PO") => 'po_no',
            getCaption("Tgl. PO") => 'po_date',
            getCaption("Tgl. Buat") => 'opn_date',
            getCaption("Harga Kendaraan") => 'veh_price',
            getCaption('Kode Supplier') => 'supp_code',
            getCaption('Nama Supplier') => 'supp_name',
            getCaption('Kode Kendaraan') => 'veh_code',
            getCaption('Nama Kendaraan') => 'veh_name',
            getCaption('Kode Warna') => 'color_code',
            getCaption('Nama Warna') => 'color_name'
        );
        $_SESSION['judul'] = "Booking Fee Supplier";
        $_SESSION['tabel'] = json_encode($table);
        break;
    
    case 'sspv_lev':
        $table = array(
            getCaption("Kode Level") => 'spvlv_code',
            getCaption("Nama Level") => 'spvlv_name',
        );
        $_SESSION['judul'] = "Level Supervisor";
        $_SESSION['tabel'] = json_encode($table);
        break;
    case 'veh_dpsgh':
        $table = array(
            getCaption("No. Faktur") => 'dp_inv_no',
            getCaption("Tgl. Faktur") => 'dp_date',
            getCaption("Warehouse") => 'wrhs_code',
            getCaption("Tgl. Buat") => 'opn_date',
            getCaption('Kode Supplier') => 'supp_code',
            getCaption('Nama Supplier') => 'supp_name',
            getCaption('Tgl. Bayar') => 'pay_date',
            getCaption('Jenis Bayar') => 'pay_type',
            getCaption('Bank') => 'bank_code',
            getCaption('No. Check') => 'check_no',
            getCaption('Tanggal Check') => 'check_date'
        );
        $_SESSION['judul'] = "Booking Fee Supplier";
        $_SESSION['tabel'] = json_encode($table);
        break;

    case 'veh_dpsgd':
        $table = array(
            getCaption("No. Faktur") => 'dp_inv_no',
            getCaption("Tgl. Faktur") => 'dp_date',
            getCaption("No. PO") => 'po_no',
            getCaption("Tgl. PO") => 'po_date',
            getCaption('Kode Kendaraan') => 'veh_code',
            getCaption('Nama Kendaraan') => 'veh_name',
            getCaption('Kode Warna') => 'color_code',
            getCaption('Nama Warna') => 'color_name',
            getCaption('Tahun') => 'veh_year',
            getCaption('Transmisi') => 'veh_transm',
            getCaption('Pembayaran') => 'dp_paid',
            getCaption('Bayar Hutang') => 'dp_used'
        );
        $_SESSION['judul'] = "Booking Fee Supplier";
        $_SESSION['tabel'] = json_encode($table);
        break;
}

$_SESSION['cond'] = $cond;
?>