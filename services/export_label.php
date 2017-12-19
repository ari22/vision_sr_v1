<?php

//include 'globalFunctions.php';

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

function tblrows($tbl, $keys = null) {

    switch ($tbl) {
        case "veh_spk":
            $table = array(getCaption("Kode Kendaraan") => 'veh_code', getCaption("Nama Kendaraan") => 'veh_name', getCaption("Kode Warna") => 'color_code', getCaption("Nama Warna") => 'color_name', getCaption("Tgl. SPK") => 'so_date', getCaption("No. SPK") => 'so_no', getCaption("Nama Pelanggan") => 'cust_name', getCaption("Tipe") => 'veh_type', getCaption("Tahun") => 'veh_year', getCaption("Transmisi") => 'veh_transm', getCaption("Kode Sales") => 'srep_code', getCaption("Nama Sales") => 'srep_name', getCaption("Kode Supervisor") => 'sspv_code', getCaption("Nama Supervisor") => 'sspv_name', getCaption("Supervisor Level") => 'sspv_lev', getCaption("Perkiraan Stok") => 'pred_stk_d', getCaption("Qty") => 'qty', getCaption("Satuan") => 'unit', getCaption("Harga Satuan") => 'unit_price', getCaption("Diskon") => 'unit_disc', getCaption("Harga Kendaraan") => 'tot_price', getCaption("Transaksi") => 'salpaytype', getCaption("Uang Muka") => 'pay_val', getCaption("Tanggal Bayar") => 'pay_date', getCaption("No. Check") => 'check_no', getCaption("Tanggal Check") => 'check_date', getCaption("Telepon") => 'cust_phone');
            break;

        case "veh_slh":
            if ($keys['key1'] == 'sales') {
                if ($keys['key2'] == '0') {
                    $table = array(
                        'Invoice No.' => 'sal_inv_no', 'Invoice Date' => 'sal_date', 'Chassis' => 'chassis', 'Engine' => 'engine',
                        'Vehicle Code' => 'veh_code', 'Vehicle Name' => 'veh_name', 'Color Code' => 'color_code', 'Color Name' => 'color_name',
                        'Warehouse Code' => 'wrhs_code', 'Sales Code' => 'srep_code', 'Sales Name' => 'srep_name', 'Supervisor Code' => 'sspv_code',
                        'Supervisor Name' => 'sspv_name', 'Customer Code' => 'cust_code', 'Customer Name' => 'cust_name',
                        'SJ No.' => 'sj_no', 'SJ Date' => 'sj_date', 'Receipt No.' => 'kwit_no', 'Receipt Date' => 'kwit_date', 'FP No.' => 'fp_no', 'FP Date' => 'fp_date',
                        'SPK No.' => 'so_no', 'SPK Date' => 'so_date', 'Note' => 'note',
                        'Leasing Code' => 'lease_code', 'Leasing Name' => 'lease_code',
                        'Key No.' => 'key_no', 'Alarm' => 'alarm', 'Debitor Name' => 'cust_rname', 'Debitor Address' => 'cust_raddr', 'Debitor Area' => 'cust_rarea',
                        'Debitor City' => 'cust_rcity', 'Debitor ZIP' => 'cust_rzipc', 'Debitor Phone' => 'cust_rphon',
                        'WO BBN' => 'bbnwo_no', 'Register BBN' => 'bbnpur_no'
                    );
                }
                if ($keys['key2'] == '1') {
                    $table = array(
                        'Invoice No.' => 'sal_inv_no', 'Invoice Date' => 'sal_date', 'Chassis' => 'chassis', 'Engine' => 'engine',
                        'Vehicle Code' => 'veh_code', 'Vehicle Name' => 'veh_name', 'Color Code' => 'color_code', 'Color Name' => 'color_name',
                        'Warehouse Code' => 'wrhs_code', 'Sales Code' => 'srep_code', 'Sales Name' => 'srep_name', 'Supervisor Code' => 'sspv_code',
                        'Supervisor Name' => 'sspv_name', 'Customer Code' => 'cust_code', 'Customer Name' => 'cust_name',
                        'SJ No.' => 'sj_no', 'SJ Date' => 'sj_date', 'Receipt No.' => 'kwit_no', 'Receipt Date' => 'kwit_date', 'FP No.' => 'fp_no', 'FP Date' => 'fp_date',
                        'SPK No.' => 'so_no', 'SPK Date' => 'so_date', 'Note' => 'note',
                        'Sale Price' => 'veh_price',
                        'Discount' => 'veh_disc',
                        'Sub Total' => 'veh_at',
                        'BBN' => 'veh_bbn',
                        'Vehicle Misc' => 'veh_misc',
                        'Total Vehicle Price' => 'veh_total',
                        'Total Optional' => 'srv_at',
                        'Total Accessories' => 'part_at',
                        'Others' => 'inv_stamp',
                        'Grand Total' => 'inv_total',
                        'Price Before Tax' => 'veh_bt',
                        'VAT' => 'veh_vat',
                        'Luxury Tax' => 'veh_pbm',
                        'Leasing Code' => 'lease_code', 'Leasing Name' => 'lease_code',
                        'Key No.' => 'key_no', 'Alarm' => 'alarm', 'Debitor Name' => 'cust_rname', 'Debitor Address' => 'cust_raddr', 'Debitor Area' => 'cust_rarea',
                        'Debitor City' => 'cust_rcity', 'Debitor ZIP' => 'cust_rzipc', 'Debitor Phone' => 'cust_rphon'
                    );
                }
            }

            if ($keys['key1'] == 'do') {
                $table = array(
                    'Vehicle Code' => 'veh_code',
                    'Vehicle Name' => 'veh_name',
                    'Color Code' => 'color_code',
                    'Color Name' => 'color_name',
                    'SJ No.' => 'sj_no',
                    'SJ Date' => 'sj_date',
                    'Sale Invoice No.' => 'sal_inv_no',
                    'Sale Invoice Date' => 'sal_date',
                    'SPK No.' => 'so_no',
                    'SPK Date' => 'so_date',
                    'Chassis' => 'chassis',
                    'Engine' => 'engine',
                    'Warehouse' => 'wrhs_code',
                    'Sales Code' => 'srep_code',
                    'Sales Name' => 'srep_name',
                    'Customer Name' => 'cust_name',
                    'Customer Address' => 'cust_addr',
                    'Customer Area' => 'cust_area',
                    'Customer City' => 'cust_city',
                    'ZIPC' => 'cust_zipc',
                    'Phone' => 'cust_phone',
                    'QTY Unit' => 'qty_unit'
                );
            }

            if ($keys['key1'] == 'creditlease') {
                $table = array(
                    'Invoice No.' => 'sal_inv_no',
                    'Invoice Date' => 'sal_date',
                    'Pick Date' => 'pick_date',
                    'Chassis' => 'chassis',
                    'Engine' => 'engine',
                    'Model' => 'veh_model',
                    'Type' => 'veh_type',
                    'Year' => 'veh_year',
                    'Color Code' => 'color_code',
                    'Color Name' => 'color_name',
                    'Customer Code' => 'cust_code',
                    'Customer Name' => 'cust_name',
                    'Address' => 'cust_addr',
                    'STNK Name' => 'cust_rname',
                    'STNK Address' => 'cust_raddr',
                    'STNK Area' => 'cust_rarea',
                    'STNK City' => 'cust_rcity',
                    'STNK ZIPC' => 'cust_rzipc',
                    'STNK Phone' => 'cust_rphone',
                    'Debitur Name' => 'cust_dname',
                    'Debitur Address' => 'cust_daddr',
                    'Debitur Area' => 'cust_darea',
                    'Debitur City' => 'cust_dcity',
                    'Debitur ZIPC' => 'cust_dzipc',
                    'Debitur Phone' => 'cust_dphone',
                    'SPK No.' => 'so_no',
                    'SPK Date' => 'so_date',
                    'Warehouse' => 'wrhs_code',
                    'Sales Code' => 'srep_code',
                    'Sales Name' => 'srep_name',
                    'Lease Code' => 'lease_code',
                    'Lease Name' => 'lease_name',
                    'Credit Via' => 'crd_via',
                    'Total Credit' => 'crd_amount',
                    'Credit Term' => 'crd_term',
                    'Interest / Year' => 'crd_irate',
                    'Contract No' => 'crd_cntrno',
                    'Contract Date' => 'crd_cntrdt',
                    'Insurance Code' => 'insr_code',
                    'Insurance Name' => 'insr_name',
                    'Refund / Commission' => 'crdinscomm',
                    'Subsidy / Discount' => 'crdinsdisc',
                    'Sales Price' => 'veh_price',
                    'Discount' => 'veh_disc',
                    'Offroad Price' => 'veh_at',
                    'BBN' => 'veh_bbn',
                    'Others' => 'veh_misc',
                    'Total Price' => 'veh_total'
                );
            }
            break;

        case "veh_po":
            $table = array(
                'Vehicle Code' => 'veh_code', 'Vehicle Name' => 'veh_name', 'Color' => 'color_name', 'PO Date' => 'po_date', 'PO No.' => 'po_no', 'Supplier Code' => 'supp_code', 'Brand' => 'veh_brand', 'Type' => 'veh_type', 'Year' => 'veh_year', 'Transmisi' => 'veh_transm', 'Created By' => 'po_made_by', 'Approved By' => 'po_appr_by', 'Qty' => 'qty', 'Unit' => 'unit', 'Purchase Price' => 'tot_price'
            );
            break;

        case "veh_prh":
            if ($keys['key1'] == 'received') {
                $table = array(
                    'Vehicle Code' => 'veh_code', 'Vehicle Name' => 'veh_name', 'Color Code' => 'color_code', 'Color Name' => 'color_name', 'Receive Date' => 'stk_date', 'Invoice No.' => 'pur_inv_no', 'Chassis' => 'chassis', 'Engine' => 'engine', 'Brand' => 'veh_brand', 'Type' => 'veh_type', 'Year' => 'veh_year', 'Transmisi' => 'veh_transm', 'Color Type' => 'color_type', 'Supplier Code' => 'supp_code', 'SJ Date' => 'sj_date', 'SJ No.' => 'sj_no', 'Qty' => 'qty', 'Unit' => 'unit', 'Note' => 'note', 'Created By' => 'po_made_by', 'Approved By' => 'po_appr_by', 'Description' => 'po_desc'
                );
            }
            if ($keys['key1'] == 'purchase') {
                $table = array(
                    'Vehicle Code' => 'veh_code', 'Vehicle Name' => 'veh_name', 'Color Code' => 'color_code', 'Color Name' => 'color_name', 'Invoice Date' => 'pur_date', 'Invoice No.' => 'pur_inv_no', 'Chassis' => 'chassis', 'Engine' => 'engine', 'Brand' => 'veh_brand', 'Type' => 'veh_type', 'Year' => 'veh_year', 'Transmisi' => 'veh_transm', 'Color Type' => 'color_type', 'Supplier Code' => 'supp_code', 'SJ Date' => 'sj_date', 'SJ No.' => 'sj_no', 'Receipt Date' => 'kwiti_date', 'Receipt No.' => 'kwiti_no', 'Tax Invoice Date' => 'fpi_date', 'Tax Invoice No.' => 'fpi_no', 'Qty' => 'qty', 'Purchase Price' => 'pur_price', 'Note' => 'note', 'Created By' => 'po_made_by', 'Approved By' => 'po_appr_by', 'Description' => 'po_desc'
                );
            }

            if ($keys['key1'] == 'debit_note') {
                $table = array(
                    'Type' => 'veh_type', 'Vehicle Code' => 'veh_code', 'Vehicle Name' => 'veh_name', 'Chassis' => 'chassis', 'Engine' => 'engine', 'Color Code' => 'color_code', 'Color Type' => 'color_type', 'SJ Date' => 'sj_date', 'SJ No.' => 'sj_no', 'Debit Note Date' => 'dni_date', 'Debit Note No.' => 'dni_no', 'Tax Invoice Date' => 'fpi_date', 'Tax Invoice No.' => 'fpi_no', 'Qty' => 'qty', 'Base Price' => 'pur_base', 'Optional Price' => 'pur_opt', 'Price Before Tax' => 'pur_bt', 'Tax (VAT)' => 'pur_vat', 'Luxury Tax' => 'pur_pbm', 'Other Tax' => 'pur_pph', 'Others' => 'pur_misc', 'Purchase Price' => 'pur_price'
                );
            }
            break;

        case "veh_rslh":
            $table = array(
                'Vehicle Code' => 'veh_code', 'Vehicle Name' => 'veh_name', 'Color Code' => 'color_code', 'Color Name' => 'color_name', 'Invoice Date' => 'rsl_date', 'Invoice No.' => 'rsl_inv_no', 'Chassis' => 'chassis', 'Warehouse' => 'wrhs_code', 'Customer' => 'cust_name', 'Sales' => 'srep_code', 'Sales Invoice Date' => 'sal_date', 'Sales Invoice No.' => 'sal_inv_no', 'SJ Date' => 'sj_date', 'SJ No.' => 'sj_no', 'Receipt Date' => 'kwiti_date', 'Receipt No.' => 'kwiti_no', 'Luxury Tax' => 'veh_pbm', 'Price Before Tax' => 'veh_bt', 'Tax (VAT)' => 'veh_vat', 'BBN' => 'veh_bbn', 'Others' => 'veh_misc', 'Price' => 'veh_total'
            );
            break;

        case "veh_rprh":
            $table = array(
                'Vehicle Code' => 'veh_code', 'Vehicle Name' => 'veh_name', 'Color Code' => 'color_code', 'Color Name' => 'color_name', 'Invoice Date' => 'rpr_date', 'Invoice No.' => 'rpr_inv_no', 'Chassis' => 'chassis', 'Engine' => 'engine', 'Brand' => 'veh_brand', 'Type' => 'veh_type', 'Year' => 'veh_year', 'Transmisi' => 'veh_transm', 'Color Type' => 'color_type', 'Supplier Code' => 'supp_code', 'Purchase Invoice Date' => 'pur_date', 'Purchase Invoice No.' => 'pur_inv_no', 'SJ Date' => 'sj_date', 'SJ No.' => 'sj_no', 'Receipt Date' => 'kwiti_date', 'Receipt No.' => 'kwiti_no', 'Qty' => 'qty', 'Purchase Price' => 'pur_price'
            );
            break;


        case "veh_stk":
            if ($keys['key1'] == 'stock') {
                $table = array(
                    'Vehicle Code' => 'veh_code', 'Vehicle Name' => 'veh_name', 'Color Code' => 'color_code', 'Color Name' => 'color_name', 'Stock Date' => 'stk_date', 'Chassis' => 'chassis', 'Engine' => 'engine', 'Warehouse' => 'wrhs_code', 'Location' => 'loc_code', 'Supplier Code' => 'supp_code', 'Supplier Name' => 'supp_name', 'key_no' => 'key_no', 'Alarm' => 'alarm', 'Service Book' => 'serv_book', 'Year' => 'veh_year', 'PO No.' => 'po_no', 'PO Date' => 'po_date', 'DO No.' => 'do_no', 'DO Date' => 'do_date', 'Std.Optional Code' => 'stdoptcode', 'Std.Optional Name' => 'stdoptname', 'Stock Status' => 'stk_code', 'Stock Age' => 'age_stk', 'Qty' => 'qty'
                );
            }

            if ($keys['key1'] == 'stock_unit') {
                $table = array(
                    'Stock Date' => 'stk_date', 'Chassis' => 'chassis', 'Engine' => 'engine', 'Supplier Code' => 'supp_code', 'Supplier Name' => 'supp_name', 'Vehicle Code' => 'veh_code', 'Vehicle Name' => 'veh_name', 'Year' => 'veh_year', 'Color Code' => 'color_code', 'Color Name' => 'color_name', 'Beginning Qty' => 'beg_qty', 'Purchase Qty' => 'pur_qty', 'Purchase Return Qty' => 'rpur_qty', 'Pick Qty' => 'pick_qty', 'Sales Qty' => 'sal_qty', 'Sales Return Qty' => 'rsal_qty', 'Open Qty' => 'opn_qty', 'End Qty' => 'end_qty', 'HPP' => 'pur_base'
                );
            }
            break;

        case "veh_arh":
            if ($keys['key1'] == 'default') {
                $table = array(
                    'Invoice No.' => 'sal_inv_no', 
					'Invoice Date' => 'sal_date', 
					'Customer Code' => 'cust_code', 
					'Customer Name' => 'cust_name', 
					'Vehicle Code' => 'veh_code', 
					'Vehicle Name' => 'veh_name', 
					'Color Name' => 'color_name', 
					'Chassis' => 'chassis', 
					'Engine' => 'engine', 
					'Sales Code' => 'srep_code', 
					'Sales Name' => 'srep_name', 
					'Description' => 'note', 
					'Due Date' => 'due_date', 
					'VSL' => 'sinv_code', 
					'Leasing Code' => 'lease_code', 
					'Leasing Name' => 'lease_name', 
					'Grand Total' => 'inv_total', 
					'Beginning Balance' => 'pd_begin', 
					'Payment' => 'pd_paid', 
					'Discount' => 'pd_disc', 
					'Ending Balance' => 'pd_end'
                );
            }
            if ($keys['key1'] == 'payment') {
                $table = array(
                    'Pay Date' => 'pay_date', 'Sales Invoice No.' => 'sal_inv_no', 'Sales Invoice Date' => 'sal_date', 'Customer Code' => 'cust_code', 'Customer Name' => 'cust_name', 'Lease Code' => 'lease_code', 'Lease Name' => 'lease_name', 'Chassis' => 'chassis', 'Payment' => 'pay_val', 'Discount' => 'disc_val', 'DP' => 'dp_usage', 'DP Date' => 'pay_date', 'Payment Type' => 'pay_type', 'Check No.' => 'check_no', 'Check Date' => 'check_date', 'Due Date' => 'due_date', 'Note' => 'note', 'Collector Code' => 'coll_code', 'Add By' => 'add_by', 'Receipt No.' => 'kwit_ono', 'Receipt Date' => 'kwit_odate', 'Receipt Name' => 'kwit_oname'
                );
            }
            break;

        case "veh_argh":
            $table = array(
                'Invoice No.' => 'arg_inv_no', 'Invoice Date' => 'arg_date', 'Customer Name' => 'cust_name', 'Warehouse' => 'wrhs_code', 'Note' => 'note', 'Pay Date' => 'pay_date', 'Pay Type' => 'pay_type', 'Bank Code' => 'bank_code', 'Check No.' => 'check_no', 'Total Item' => 'tot_item', 'Total Payment' => 'tot_paid', 'Total Discount' => 'tot_disc', 'Description' => 'pay_desc'
            );
            break;

        case "veh_aph":
            if ($keys['key1'] == 'default') {
                $table = array(
                    'Invoice Code' => 'pinv_code', 'Invoice No.' => 'pur_inv_no', 'Invoice Date' => 'pur_date', 'Chassis' => 'chassis', 'Engine' => 'engine', 'Supplier Name' => 'supp_name', 'Color' => 'color_name', 'Total Invoice' => 'inv_total', 'Begin' => 'hd_begin', 'Payment' => 'hd_paid', 'Discount' => 'hd_disc', 'End' => 'hd_end', 'Note' => 'note', 'Due Date' => 'due_date'
                );
            }
            if ($keys['key1'] == 'payment') {
                $table = array(
                    'Pay Type' => 'pay_type', 
					'Pay Date' => 'pay_date', 
					'Invoice No.' => 'pur_inv_no', 
					'Invoice Date' => 'pur_date', 
					'Supplier Code' => 'supp_code', 
					'Supplier Name' => 'supp_name', 
					'Chassis' => 'chassis', 
					'Payment' => 'pay_val', 
					'Discount' => 'disc_val', 
					'Check No.' => 'check_no', 
					'Check Date' => 'check_date', 
					'Due Date' => 'due_date', 
					'Bank' => 'bank_code', 
					'Note' => 'note', 
					'Group Payment No.' => 'apg_inv_no', 
					'Group Payment Date' => 'apg_date',
                );
            }
            if ($keys['key1'] == 'optional') {
                $table = array(
                    'Invoice Type' => 'pinv_code', 'Invoice Date' => 'pur_date', 'Invoice No.' => 'pur_inv_no', 'Supplier Code' => 'supp_code', 'Suppplier Name' => 'supp_name', 'Supplier Invoice No.' => 'supp_invno', 'Supplier Invoice Date' => 'supp_invdt', 'Total Invoice' => 'inv_total', 'Begin' => 'hd_begin', 'Payment' => 'hd_paid', 'Discount' => 'hd_disc', 'End' => 'hd_end', 'Note' => 'note', 'Due Date' => 'due_date'
                );
            }
            break;


        case 'veh_apgh':
            $table = array(
                'Invoice No.' => 'apg_inv_no', 'Invoice Date' => 'apg_date', 'Supplier Name' => 'supp_name', 'Warehouse' => 'wrhs_code', 'Note' => 'note', 'Pay Date' => 'pay_date', 'Payment Type' => 'pay_type', 'Bank Code' => 'bank_code', 'Check No.' => 'check_no', 'Check Date' => 'check_date', 'Total Item' => 'tot_item', 'Total Payment' => 'tot_paid', 'Total Discount' => 'tot_disc', 'Description' => 'pay_desc'
            );

            break;

        case "veh_dpch":
            $table = array(
                'Invoice Date' => 'dp_date', 'Invoice No.' => 'dp_inv_no', 'SPK Date' => 'so_date', 'SPK No.' => 'so_no', 'Customer Name' => 'cust_name', 'Vehicle Name' => 'veh_name', 'Color Code' => 'color_code', 'Price' => 'veh_price', 'Begin' => 'dp_begin', 'DP' => 'dp_paid', 'Used' => 'dp_used', 'End' => 'dp_end', 'Note' => 'note'
            );
            break;
        case "acc_woh":
            $table = array(
                'WO No.' => 'wo_no', 'WO Date' => 'wo_date', 'Supplier Name' => 'supp_name', 'SPK No.' => 'so_no', 'Chassis' => 'chassis', 'Price Before Tax' => 'inv_bt', 'inv_vat' => 'Tax', 'Others' => 'inv_stamp', 'Grand Total' => 'inv_total'
            );

            //$table = array('WO No.' => 'wo_no','WO Date' => 'wo_date','Supplier Name' => 'supp_name','Work Code' => 'wk_code','Work Name' => 'wk_name','Optional Price' => 'price_bd','Optional Discount' => 'disc_pct','Netto Price' => 'price_ad','Discount Value' => 'disc_val','Price Before Tax' => 'inv_bt','inv_vat' => 'Tax','Others' => 'inv_stamp','Grand Total' => 'inv_total');
            break;

        case "acc_wprh":
            $table = array(
                'Invoice No.' => 'pur_inv_no', 'Invoice Date' => 'pur_date', 'Supplier Name' => 'supp_name', 'SPK No.' => 'so_no', 'Chassis' => 'chassis', 'Price Before Tax' => 'inv_bt', 'inv_vat' => 'Tax', 'Others' => 'inv_stamp', 'Grand Total' => 'inv_total'
            );
            break;

        case 'acc_wslh':
            $table = array(
                'Invoice No.' => 'sal_inv_no', 'Invoice Date' => 'sal_date', 'Supplier Name' => 'supp_name', 'SPK No.' => 'so_no', 'Chassis' => 'chassis', 'Price Before Tax' => 'inv_bt', 'inv_vat' => 'Tax', 'Others' => 'inv_stamp', 'Grand Total' => 'inv_total'
            );
            break;







        case "set_vglh":
            $table = array(getCaption("Divisi") => 'inv_div', getCaption("Transaksi") => 'trx_code', getCaption("Keterangan") => 'trx_desc', getCaption("Warehouse") => 'wrhs_code');
            break;
        case "set_form":
            $table = array(getCaption("Kode") => 'form_code', getCaption("Keterangan") => 'form_name');
            break;

        case "veh_ard":
            $table = array(getCaption("No. Faktur Jual") => 'sal_inv_no', getCaption("Tgl. Faktur Jual") => 'sal_date', getCaption("Tanggal Bayar") => 'pay_date', getCaption("Kode Bank") => 'bank_code', getCaption("No. Check") => 'check_no', getCaption("Pembayaran") => 'pay_val', getCaption("Diskon") => 'disc_val', getCaption("Dibayar Oleh") => "payer_name", getCaption("Alamat") => "payer_addr", getCaption("Keterangan") => 'pay_desc', getCaption("No. Kwitansi") => 'kwit_ono', getCaption("Tgl. Kwitansi") => 'kwit_odate');
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

            break;

        case 'vehdpcch':
            $table = array(
						'Cancellation Invoice No.'  => 'dpc_inv_no',
						'Cancellation Invoice Date.' => 'dpc_date',
						'DP Invoice No.' => 'dp_inv_no',
						'DP Invoice Date.' => 'dp_date',
						getCaption("Kode Pelanggan") => 'cust_code',
						getCaption("Nama Pelanggan") => 'cust_name',
						'Check No.' => 'check_no',
						'Check Date' => 'check_date',
						'Pay Date' => 'pay_date',
						'Due Date' => 'due_date',
						'Payment Type' => 'pay_type',
						'Downpayment' => 'pay_val',
						'Bank' => 'bank_code',
						'EDC' => 'edc_code',
						'Description' => 'pay_desc',
						'Payer Name' => 'cust_name'

            );

            break;

        case "acc_aph":
			   if ($keys['key1'] == 'default') {
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
						getCaption('Hutang Akhir') => 'hd_end'
						
						);

			   }
			    if ($keys['key1'] == 'payment') {
					$table = array(
						'Invoice Type' => 'pinv_code', 'Invoice Date' => 'pur_date', 'Invoice No.' => 'pur_inv_no', 'Supplier Code' => 'supp_code', 'Suppplier Name' => 'supp_name', 'Supplier Invoice No.' => 'supp_invno', 'Supplier Invoice Date' => 'supp_invdt', 'Total Invoice' => 'inv_total', 'Begin' => 'hd_begin', 'Payment' => 'hd_paid', 'Discount' => 'hd_disc', 'End' => 'hd_end', 'Note' => 'note', 'Due Date' => 'due_date'
					);
				}
            break;

        case "acc_arh":
              if ($keys['key1'] == 'default') {
                $table = array(
					'Invoice No.' => 'sal_inv_no', 
					'Invoice Date' => 'sal_date', 
					'Customer Code' => 'cust_code', 
					'Customer Name' => 'cust_name', 
					'Description' => 'note', 
					'Due Date' => 'due_date', 
					'Invoice' => 'sinv_code',  
					'Grand Total' => 'inv_total', 
					'Beginning Balance' => 'pd_begin', 
					'Payment' => 'pd_paid', 
					'Discount' => 'pd_disc', 
					'Ending Balance' => 'pd_end'
                );
            }
            if ($keys['key1'] == 'payment') {
                $table = array(
                    'Pay Date' => 'pay_date', 
					'Sales Invoice No.' => 'sal_inv_no', 
					'Sales Invoice Date' => 'sal_date', 
					'Customer Code' => 'cust_code', 
					'Customer Name' => 'cust_name', 
					'Payment' => 'pay_val', 
					'Discount' => 'disc_val',  
					'Payment Type' => 'pay_type', 
					'Check No.' => 'check_no', 
					'Check Date' => 'check_date', 
					'Due Date' => 'due_date', 
					'Note' => 'note', 
					'Bank' => 'bank_code', 
					'Collector Code' => 'coll_code', 
					'Invoice' => 'sinv_code', 
					'Add By' => 'add_by', 
					'Add Date' => 'add_date',
                );
            }
		   
            break;
        case "acc_poh":
            $table = array(getCaption("No. PO") => 'po_no', getCaption("Tgl. PO") => 'po_date', getCaption("Tgl. Buat") => 'opn_date', getCaption("Jenis PO") => 'po_type', getCaption("No. Quotation") => 'quote_no', getCaption("Tgl. Quotation") => 'quote_date', getCaption("Kode Supplier") => 'supp_code', getCaption("Nama Supplier") => 'supp_name', getCaption("Kode Purchaser") => 'prep_code', getCaption("Nama Purchaser") => 'prep_name', getCaption("Kode Penerima") => 'raddr_code', getCaption("Nama Penerima") => 'rname', getCaption("Warehouse") => 'wrhs_code', 'Note 1' => 'note', 'Note 2' => 'note2', 'Note 3' => 'note3', 'Note 4' => 'note4');

            break;
        case "acc_prh":
            $table = array(getCaption("No. Faktur") => 'pur_inv_no', getCaption("Tgl. Faktur") => 'pur_date', getCaption("Kode Supplier") => 'supp_code', getCaption("Nama Supplier") => 'supp_name', getCaption("Tgl. Terima") => 'rcv_date', getCaption("No. PO") => 'po_no', getCaption("Tgl. PO") => 'po_date', getCaption("No. Surat Jalan") => 'sj_no', getCaption("Tgl. Surat Jalan") => 'sj_date', getCaption("No. Faktur Supplier") => 'supp_invno', getCaption("Tgl. Faktur Supplier") => 'supp_invdt');

            break;
        case "acc_opnh":
            $table = array(getCaption("No. Faktur") => 'opn_inv_no', getCaption("Tgl. Faktur") => 'opn_date', getCaption("Tgl. Buat") => 'open_date', getCaption("Kode Yang Opname") => 'oprep_code', getCaption("Nama Yang Opname") => 'oprep_name');

            break;
        case "acc_rprh":
            $table = array(getCaption("No. Faktur") => 'rpr_inv_no', getCaption("Tgl. Faktur") => 'rpr_date', getCaption("No. Faktur Beli") => 'pur_inv_no', getCaption("Tgl. Faktur Beli") => 'pur_date', getCaption("Kode Supplier") => 'supp_code', getCaption("Nama Supplier") => 'supp_name', getCaption("No. Surat Jalan") => 'sj_no', getCaption("Tgl. Surat Jalan") => 'sj_date', getCaption("No. PO") => 'po_no', getCaption("Tgl. PO") => 'po_date');

            break;
        case "acc_movh":
            $table = array(getCaption("No. Faktur") => 'mov_inv_no', getCaption("Tgl. Faktur") => 'mov_date', getCaption("Tgl. Buat") => 'opn_date', getCaption("Kode Yang Memindahkan") => 'mvrep_code', getCaption("Nama Yang Memindahkan") => 'mvrep_name', getCaption("Dari Warehouse") => 'wrhs_from', getCaption("Ke Warehouse") => 'wrhs_to');

            break;
        case "acc_worh":
            $table = array(getCaption("No. SPOK") => 'wor_no', getCaption("Tgl. SPOK") => 'wor_date', getCaption("Tgl. Buat") => 'opn_date', getCaption("Jenis SPOK") => 'oreq_type', getCaption("Kode Department") => 'dept_code', getCaption("Nama Department") => 'dept_name', getCaption("Kode Unit") => 'dunit_code', getCaption("Nama Unit") => 'dunit_name');

            break;


        case "veh_doc":
            $table = array(getCaption("No. Dokumen") => 'doc_inv_no', getCaption("Tgl. Dokumen") => 'doc_date', getCaption("No. Faktur Jual") => 'sal_inv_no', getCaption("Tgl. Faktur Jual") => 'sal_date', getCaption("Nama Di STNK") => 'cust_rname', getCaption("No. Polisi") => 'veh_reg_no', getCaption("Kode Pelanggan") => 'cust_code', getCaption("Nama Pelanggan") => 'cust_name', getCaption("Kode Sales") => 'srep_code', getCaption("Nama Sales") => 'srep_name', getCaption("Kode Kendaraan") => 'veh_code', getCaption("Nama Kendaraan") => 'veh_name', getCaption("Chassis") => 'chassis', getCaption("Transmisi") => 'veh_transm', getCaption("Kode Warna") => 'color_code', getCaption("Nama Warna") => 'color_name');

            break;
        case "veh_bwoh":
            $table = array(getCaption("No. WO") => 'wo_no', getCaption("Tgl. WO") => 'wo_date', getCaption("Tgl. Pick") => 'opn_date', getCaption("No. Quotation") => 'quote_no', getCaption("Tgl. Quotation") => 'quote_date', getCaption("Kode Biro Jasa") => 'supp_code', getCaption("Nama Biro Jasa") => 'supp_name', getCaption("Kode Purchaser") => 'prep_code', getCaption("Nama Purchaser") => 'prep_name', getCaption("Kode Penerima") => 'raddr_code', getCaption("Nama Penerima") => 'rname');

            break;
        case "veh_bwod":
            $table = array(getCaption("No. WO") => 'wo_no', getCaption("Tgl. WO") => 'wo_date', getCaption("Chassis") => 'chassis', getCaption("No. SPK") => 'so_no', getCaption("Tgl. SPK") => 'so_date', getCaption("Kode Kendaraan") => 'veh_code', getCaption("Nama Kendaraan") => 'veh_name', getCaption("No. Faktur Jual") => 'sal_inv_no', getCaption("Nama Pelanggan") => 'cust_name', getCaption("Nama Sales") => 'srep_name', getCaption("Warna") => 'color_name');

            break;
        case "veh_bprh":
            $table = array(getCaption("No. Faktur Beli") => 'pur_inv_no', getCaption("Tgl. Faktur Beli") => 'pur_date', getCaption("Tgl. Buat") => 'opn_date', getCaption("Kode Biro Jasa") => 'supp_code', getCaption("Nama Biro Jasa") => 'supp_name', getCaption("No. Surat Jalan") => 'sj_no', getCaption("No. Faktur Supplier") => 'supp_invno', getCaption("No. WO") => 'wo_no');

            break;
        case "veh_bprd":
            $table = array(getCaption("No. Faktur Beli") => 'pur_inv_no', getCaption("Tgl. Faktur Beli") => 'pur_date', getCaption("No. WO") => 'wo_no', getCaption("Chassis") => 'chassis', getCaption("No. SPK") => 'so_no', getCaption("Tgl. SPK") => 'so_date', getCaption("Kode Kendaraan") => 'veh_code', getCaption("Nama Kendaraan") => 'veh_name', getCaption("No. Faktur Jual") => 'sal_inv_no', getCaption("Nama Pelanggan") => 'cust_name', getCaption("Nama Sales") => 'srep_name', getCaption("Warna") => 'color_name');

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

            break;

        case "veh_prc":
            $table = array(getCaption("Kode Kendaraan") => 'veh_code', getCaption("Tipe Warna") => 'col_type', getCaption('Deskripsi') => 'veh_name', getCaption('Merek') => 'veh_brand', getCaption("Tipe") => 'veh_type', getCaption("Model") => 'veh_model', getCaption("Tahun") => 'veh_year', getCaption("Transmisi") => 'veh_transm', getCaption("Chassis") => 'chassis', getCaption("Catatan") => 'note', getCaption("Tgl. Aktif") => 'act_date',);

            break;
        case "veh_srep":
            $table = array(getCaption("Kode Sales") => 'srep_code', getCaption("Nama Sales") => 'srep_name', getCaption("Alamat") => 'haddr', getCaption("Telepon") => 'hphone', getCaption("HP Pribadi") => 'hp', getCaption("Jenis Kelamin") => 'sex', getCaption("Tanggal Masuk") => 'in_date', getCaption("Tanggal Keluar") => 'out_date', getCaption("Tanggal Lahir") => 'dob');

            break;
        case "veh_supp":
            $table = array(getCaption("Kode Supplier") => 'supp_code', getCaption("Nama Supplier") => 'supp_name', getCaption("Jenis Kelamin") => 'sex', getCaption("Alamat Kantor") => 'oaddr', getCaption("No. Telepon Kantor") => 'ophone', getCaption("Alamat Rumah") => 'haddr', getCaption("No. Telepon Rumah") => 'hphone');

            break;
        case "veh_coll":
            $table = array(getCaption("Kode Kolektor") => 'coll_code', getCaption("Nama Kolektor") => 'coll_name', getCaption("Alamat") => 'haddr', getCaption("Telepon") => 'hphone', getCaption("HP Pribadi") => 'hp', getCaption("Jenis Kelamin") => 'sex', getCaption("Tanggal Masuk") => 'in_date', getCaption("Tanggal Keluar") => 'out_date', getCaption("Tanggal Lahir") => 'dob');

            break;
        case "veh_vtyp":
            $table = array(getCaption("Kode Kendaraan") => 'veh_code', getCaption("Nama Kendaraan") => 'veh_name', getCaption("Merek") => 'veh_brand', getCaption("Tipe") => 'veh_type', getCaption("Model") => 'veh_model', getCaption("Tahun") => 'veh_year', getCaption("Transmisi") => 'veh_transm', getCaption("Chassis") => 'chassis', getCaption("Catatan") => 'note', getCaption("Tanggal Aktif") => 'act_date');
            break;
        case "color":
            $table = array(getCaption("Kode Warna") => 'color_code', getCaption("Nama Warna") => 'color_name', getCaption("Tipe Warna") => 'col_type', getCaption("Catatan") => 'note', getCaption("Tgl. Aktif") => 'act_date', getCaption("Tgl. Non Aktif") => 'exp_date');

            break;
        case "veh_wkcd":
            $table = array(getCaption("Kode Pekerjaan") => 'wk_code', getCaption("Nama Pekerjaan") => 'wk_desc', getCaption("Harga Beli") => 'pur_price', getCaption("Harga Jual") => 'sal_price', getCaption("Diinput Oleh") => 'add_by', getCaption("Tgl. Input") => 'add_date');

            break;
        case "insurance":
            $table = array(getCaption("Kode Asuransi") => 'insr_code', getCaption("Nama Asuransi") => 'insr_desc', getCaption("Jenis Kelamin") => 'sex', getCaption("Alamat Kantor") => 'oaddr', getCaption("No. Telepon Kantor") => 'ophone', getCaption("Alamat Rumah") => 'haddr', getCaption("No. Telepon Rumah") => 'hphone');

            break;
        case "bank":
            $table = array(getCaption("Kode Bank") => 'bank_code', getCaption("Nama Bank") => 'bank_name', getCaption("Alamat") => 'oaddr', getCaption("Kode Pos") => 'ozipcode', getCaption("Kota") => 'ocity', getCaption("Telepon") => 'ophone', getCaption("Fax") => 'ofax', getCaption("Catatan") => 'note', getCaption("Email") => 'oemail');

            break;
        case "lease":
            $table = array(getCaption("Kode Leasing") => 'lease_code', getCaption("Nama Leasing") => 'lease_name', getCaption("Alamat") => 'oaddr', getCaption("Kode Pos") => 'ozipcode', getCaption("Kota") => 'ocity', getCaption("Telepon") => 'ophone', getCaption("Fax") => 'ofax', getCaption("Catatan") => 'note', getCaption("Email") => 'oemail');

            break;
        case "agent":
            $table = array(getCaption("Kode Biro Jasa") => 'agent_code', getCaption("Nama Biro Jasa") => 'agent_name', getCaption("Alamat") => 'oaddr', getCaption("Kode Pos") => 'ozipcode', getCaption("Kota") => 'ocity', getCaption("Telepon") => 'ophone', getCaption("Fax") => 'ofax', getCaption("Catatan") => 'note', getCaption("Email") => 'oemail');

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


            break;
        case "veh_cust":
            $table = array(getCaption("Kode Pelanggan") => 'cust_code', getCaption("Nama Pelanggan") => 'cust_name', getCaption("Jenis Kelamin") => 'sex', getCaption("Alamat Kantor") => 'oaddr', getCaption("No. Telepon Kantor") => 'ophone', getCaption("Alamat Rumah") => 'haddr', getCaption("No. Telepon Rumah") => 'hphone');

            break;

        case "veh_sspv":
            $table = array(getCaption("Kode Supervisor") => 'sspv_code', getCaption("Nama Supervisor") => 'sspv_name', getCaption("Alamat") => 'haddr', getCaption("Telepon") => 'hphone', getCaption("HP Pribadi") => 'hp', getCaption("Tanggal Masuk") => 'in_date', getCaption("Tanggal Keluar") => 'out_date', getCaption("dob") => 'out_date');

            break;

        case "veh_stdopt":
            $table = array(getCaption("Kode Std. Optional") => 'stdoptcode', getCaption("Nama Std. Optional") => 'stdoptname');

            break;

        case "acc_cust":
            $table = array(getCaption("Kode Pelanggan") => 'cust_code', getCaption("Nama Pelanggan") => 'cust_name', getCaption("Jenis Kelamin") => 'sex', getCaption("Alamat Kantor") => 'oaddr', getCaption("No. Telepon Kantor") => 'ophone', getCaption("Alamat Rumah") => 'haddr', getCaption("No. Telepon Rumah") => 'hphone');

            break;
        case "acc_supp":
            $table = array(getCaption("Kode Supplier") => 'supp_code', getCaption("Nama Supplier") => 'supp_name', getCaption("Jenis Kelamin") => 'sex', getCaption("Alamat Kantor") => 'oaddr', getCaption("No. Telepon Kantor") => 'ophone', getCaption("Alamat Rumah") => 'haddr', getCaption("No. Telepon Rumah") => 'hphone');

            break;
        case "acc_srep":
            $table = array(getCaption("Kode Sales") => 'srep_code', getCaption("Nama Sales") => 'srep_name', getCaption("Alamat") => 'haddr', getCaption("Telepon") => 'hphone', getCaption("HP Pribadi") => 'hp', getCaption("Jenis Kelamin") => 'sex', getCaption("Tanggal Masuk") => 'in_date', getCaption("Tanggal Keluar") => 'out_date', getCaption("Tanggal Lahir") => 'dob');

            break;
        case "acc_coll":
            $table = array(getCaption("Kode Kolektor") => 'coll_code', getCaption("Nama Kolektor") => 'coll_name', getCaption("Alamat") => 'haddr', getCaption("Telepon") => 'hphone', getCaption("HP Pribadi") => 'hp', getCaption("Jenis Kelamin") => 'sex', getCaption("Tanggal Masuk") => 'in_date', getCaption("Tanggal Keluar") => 'out_date', getCaption("Tanggal Lahir") => 'dob');

            break;
        case "acc_prep":
            $table = array(getCaption("Kode Purchaser") => 'prep_code', getCaption("Nama Purchaser") => 'prep_name', getCaption("Alamat") => 'haddr', getCaption("Telepon") => 'hphone', getCaption("HP Pribadi") => 'hp', getCaption("Jenis Kelamin") => 'sex', getCaption("Tanggal Masuk") => 'in_date', getCaption("Tanggal Keluar") => 'out_date', getCaption("Tanggal Lahir") => 'dob');

            break;
        case "acc_orep":
            $table = array(getCaption("Kode Opname") => 'oprep_code', getCaption("Nama Opname") => 'oprep_name', getCaption("Alamat") => 'haddr', getCaption("Telepon") => 'hphone', getCaption("HP Pribadi") => 'hp', getCaption("Jenis Kelamin") => 'sex', getCaption("Tanggal Masuk") => 'in_date', getCaption("Tanggal Keluar") => 'out_date', getCaption("Tanggal Lahir") => 'dob');

            break;
        case "acc_wkcd":
            $table = array(getCaption("Kode Pekerjaan") => 'wk_code', getCaption("Nama Pekerjaan") => 'wk_desc', getCaption("Harga Beli") => 'pur_price', getCaption("Harga Jual") => 'sal_price', getCaption("Diinput Oleh") => 'add_by', getCaption("Tgl. Input") => 'add_date');

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

            break;

        case 'acc_slh':
            $table = array(
                getCaption("No. Faktur") => 'sal_inv_no',
                getCaption("Tgl. Faktur") => 'sal_date',
                getCaption("Kode Pelanggan") => 'cust_code',
                getCaption("Nama Pelanggan") => 'cust_name',
                getCaption("Jatuh Tempo") => 'due_date'
            );

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


            break;


        // Master
        case 'prt_radd':
            $table = array(getCaption("Kode Alamat") => 'raddr_code', getCaption("Keterangan") => 'raddr_name', getCaption("Perusahaan") => 'oname', getCaption("Alamat") => 'oaddr', getCaption("Wilayah") => 'oarea', getCaption("Kota") => 'ocity', getCaption("Kode Pos") => 'ozipcode', getCaption("Negara") => 'ocountry', getCaption("Telepon") => 'ophone', getCaption("Fax") => 'ofax', getCaption("Hubungi") => 'ocp1_name', getCaption("Jabatan") => 'ocp1_title',);
            break;
        case 'country':
            $table = array(getCaption("Kode") => 'cntry_code', getCaption("Nama") => 'cntry_name');
            break;
        case 'job_fld':
            $table = array(getCaption("Kode") => 'job_code', getCaption("Nama") => 'job_name');
            break;
        case 'bus_fld':
            $table = array(getCaption("Kode") => 'fld_code', getCaption("Nama") => 'fld_name');
            break;
        case 'bus_item':
            $table = array(getCaption("Kode") => 'item_code', getCaption("Nama") => 'item_name');
            break;
        case 'religion':
            $table = array(getCaption("Kode") => 'relig_code', getCaption("Nama") => 'relig_name');
            break;
        case 'rating':
            $table = array(getCaption("Kode") => 'rate_code', getCaption("Nama") => 'rate_name');
            break;
        case 'pay_type':
            $table = array(getCaption("Kode") => 'pay_type', getCaption("Nama") => 'pay_name');
            break;
        case 'so_source':
            $table = array(getCaption("Kode") => 'sosrc_code', getCaption("Nama") => 'sosrc_name');
            break;
        case 'srep_lev':
            $table = array(getCaption("Kode") => 'slev_code', getCaption("Nama") => 'slev_name');
            break;
        case 'educ_lev':
            $table = array(getCaption("Kode") => 'educ_code', getCaption("Nama") => 'educ_name');
            break;
        case 'coll_lev':
            $table = array(getCaption("Kode") => 'clev_code', getCaption("Nama") => 'clev_name');
            break;
        case 'prep_lev':
            $table = array(getCaption("Kode") => 'plev_code', getCaption("Nama") => 'plev_name');
            break;
        case 'opname':
            $table = array(getCaption("Kode") => 'opn_code', getCaption("Nama") => 'opn_name');
            break;
        case 'orep_lev':
            $table = array(getCaption("Kode") => 'oplev_code', getCaption("Nama") => 'oplev_name');
            break;
        case 'prt_movr':
            $table = array(getCaption("Kode") => 'mvrep_code', getCaption("Nama") => 'mvrep_name');
            break;
        case 'dept_unt':
            $table = array(getCaption("Kode") => 'dunit_code', getCaption("Nama") => 'dunit_name');
            break;
        case 'oreqtype':
            $table = array(getCaption("Kode") => 'oreq_type', getCaption("Nama") => 'oreq_name');
            break;
        case 'action':
            $table = array(getCaption("Kode") => 'act_code', getCaption("Nama") => 'act_name');
            break;
        case 'location':
            $table = array(getCaption("Kode") => 'loc_code', getCaption("Nama") => 'loc_name');
            break;
        case 'veh_brnd':
            $table = array(getCaption("Kode") => 'brnd_code', getCaption("Nama") => 'brnd_name');
            break;
        case 'col_type':
            $table = array(getCaption("Kode") => 'coltp_code', getCaption("Nama") => 'coltp_name');
            break;
        case 'veh_tran':
            $table = array(getCaption("Kode") => 'trans_code', getCaption("Nama") => 'trans_name');
            break;
        case 'veh_wrhs':
            $table = array(getCaption("Kode") => 'wrhs_code', getCaption("Nama") => 'wrhs_name');
            break;
        case 'prt_use4':
            $table = array(getCaption("Kode") => 'use4_code', getCaption("Nama") => 'use4_name');
            break;
        case 'prt_grp':
            $table = array(getCaption("Kode") => 'grp_code', getCaption("Nama") => 'grp_name');
            break;
        case 'prt_mdin':
            $table = array(getCaption("Kode") => 'mdin_code', getCaption("Nama") => 'mdin_name');
            break;
        case 'prt_umsr':
            $table = array(getCaption("Kode") => 'unit', getCaption("Nama") => 'unit_name');
            break;
        case 'prt_sgrp':
            $table = array(getCaption("Kode") => 'sgrp_code', getCaption("Nama") => 'sgrp_name');
            break;
        case 'prt_wrhs':
            $table = array(getCaption("Kode") => 'wrhs_code', getCaption("Nama") => 'wrhs_name');
            break;

        case 'maccs':
            $table = array(
                'Part Code' => 'part_code',
                'Part Name' => 'part_name',
                'Unit' => 'unit',
                'Location' => 'location',
                'Rest Stock' => 'qty',
                'Qty Pick' => 'qty_pick',
                'Min Qty' => 'min_qty',
                'Max Qty' => 'max_qty',
                'Qty Order' => 'qty_order',
                'Qty Border' => 'qty_border',
                'Purchase Price' => 'pur_price',
                'HPP Average' => 'aver_price',
                'Sale Price' => 'sal_price'
            );
            break;

        case 'vehspkch':
            $table = array(
                'Vehicle Code' => 'veh_code',
                'Vehicle Name' => 'veh_name',
                'Color Code' => 'color_code',
                'Color Name' => 'color_name',
                'Cancel Date' => 'canc_date',
                'SPK No.' => 'so_no',
                'SPK Date' => 'so_date',
                'Wrhs' => 'wrhs_code',
                'Sales Code' => 'srep_code',
                'Customer Name' => 'cust_name',
                'Note' => 'canc_note',
                'By' => 'canc_by',
                'Qty' => 'qty'
            );
            break;
        case 'veh_sjch':
            $table = array(
                'Vehicle Code' => 'veh_code',
                'Vehicle Name' => 'veh_name',
                'Color Code' => 'color_code',
                'Color Name' => 'color_name',
                'Cancel Date' => 'canc_date',
                'DO No.' => 'sj_no',
                'DO Date' => 'sj_date',
                'Sales No.' => 'sal_inv_no',
                'Sales Date' => 'sal_date',
                'SPK No.' => 'so_no',
                'SPK Date' => 'so_date',
                'Chassis' => 'chassis',
                'Engine' => 'engine',
                'Wrhs' => 'wrhs_code',
                'Sales Code' => 'srep_code',
                'Customer Name' => 'cust_name',
                'Note' => 'canc_note',
                'By' => 'canc_by',
                'Qty' => 'qty'
            );
            break;

        case 'veh_kwch':
            $table = array(
            );
            break;
		
		case 'veh':
			$table = array(
				'Chassis' => 'chassis',
				'Engine' => 'engine',
				'Warehouse' => 'wrhs_code',
				'Vehicle Code' => 'veh_code',
				'Vehicle Name' => 'veh_name',
				'Brand' => 'veh_brand',
				'Type' => 'veh_type',
				'Model' => 'veh_model',
				'Transm' => 'veh_transm',
				'Year' => 'veh_year',
				'Registration No.' => 'veh_reg_no',
				'Key No.' => 'key_no',
				'Serv. Book' => 'serv_book',
				'Color Code' => 'color_code',
				'Color Name' => 'color_name',
				'Customer Code' => 'cust_code',
				'Customer Name' => 'cust_name',
				'PO No.' => 'po_no',
				'PO Date' => 'po_date',
				'SPK No.' => 'so_no',
				'SPK Date' => 'so_date',
				'Supplier Code' => 'supp_code',
				'Supplier Name' => 'supp_name',
				'Purchase No.' => 'pur_inv_no',
				'Purchase Date' => 'pur_date',
				'Customer Code' => 'cust_code',
				'Customer Name' => 'cust_name',
				'Sales No.' => 'sal_inv_no',
				'Sales Date' => 'sal_date'
			);
			break;
    }



    return $table;
}
