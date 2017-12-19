<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
//error_reporting(E_ALL ^ E_NOTICE);
//error_reporting(0);
date_default_timezone_set("Asia/Jakarta");

class Builder extends Application {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('crud_mdl', 'get_data_mdl', 'all_m'));
    }

    function datagrid() {
        $table = encrypt_decrypt('decrypt', $this->uri->segment(3));
        $where = null;
        
        $db = '';
        
        if($this->input->get('db')){
            if($this->input->get('db') !== null){
                $db = $this->input->get('db').'.';
            }
        }
        
        if ($this->uri->segment(4) && $this->uri->segment(5)) {
            if ($table == 'usr') {
                $iduser = $this->uri->segment(5);
                $where["id not in ('$iduser')"] = null;
            } else {
                $where[$this->uri->segment(4)] = urldecode($this->uri->segment(5));
            }
        }
        if ($table == 'usr') {
            if ($this->uri->segment(4)) {
                $where['curr_login > 0'] = null;
            }
        }
        if ($this->uri->segment(6)) {
            if ($this->uri->segment(6) == 'year') {
                $where['YEAR(pay_date) <='] = urldecode($this->uri->segment(7));
            } else {
                $where[$this->uri->segment(6)] = urldecode($this->uri->segment(7));
            }
        }
        if ($this->uri->segment(8)) {
            $where[$this->uri->segment(8)] = urldecode($this->uri->segment(9));
        }
        if ($this->uri->segment(10)) {
            $where[$this->uri->segment(10)] = urldecode($this->uri->segment(11));
        }
        $grids = $this->get_data_mdl->get_data($db.$table, $where);

        if ($table == 'veh_dpcd' || $table == 'veh_dpsd') {

            if ($table == 'veh_dpcd') {
                $pay = 'pay_val';
            }
            if ($table == 'veh_dpsd') {
                $pay = 'pay_bt';
            }

            $tables = array();
            foreach ($grids['rows'] as $row) {
                if ($row->posted == 1) {
                    $posted = $row[$pay];
                    $current = 0;
                } else {
                    $posted = 0;
                    $current = $row[$pay];
                }

                $tables[] = array(
                    'pay_date' => $row['pay_date'],
                    'pay_type' => $row['pay_type'],
                    'bank_code' => $row['bank_code'],
                    'check_no' => $row['check_no'],
                    'check_date' => $row['check_date'],
                    'due_date' => $row['due_date'],
                    'posted' => $posted,
                    'current' => $current,
                    'used_val' => $row['used_val'],
                    'pay_desc' => $row['pay_desc'],
                    'edc_code' => $row['edc_code'],
                    'dp_inv_no' => $row['dp_inv_no'],
                    'add_date' => $row['add_date'],
                    'add_by' => $row['add_by'],
                    'tts_no' => $row['tts_no'],
                    'tts_date' => $row['tts_date'],
                    'pay_val' => $row['pay_val'],
                    'disc_val' => $row['disc_val']
                );
            }


            $data = array(
                'rows' => $tables,
                'total' => $grids['total']
            );
        } else {
            $data = $grids;
        }

        $this->json($data);
    }

    function table_grid() {
        if (isset($_GET['grid'])) {
            $table = $this->uri->segment(4);

            if ($table == 'maccs') {
                $val = $this->uri->segment(5);

                if ($val == '') {
                    $grid = array(
                        'total' => 0,
                        'rows' => array()
                    );
                } else {
                    $where = array('part_code' => $val);
                    $grids = $this->get_data_mdl->get_data($table, $where);

                    foreach ($grids['rows'] as $r) {
                        $ppn = ($r['sal_price'] / 100) * 10;
                        $data[] = array(
                            'part_code' => $r['part_code'],
                            'part_name' => $r['part_name'],
                            'wrhs_code' => $r['wrhs_code'],
                            'location' => $r['location'],
                            'unit' => $r['unit'],
                            'unit_price' => $r['unit_price'],
                            'sal_price' => $r['sal_price'],
                            'grp_code' => $r['grp_code'],
                            'sgrp_code' => $r['sgrp_code'],
                            'abc_group' => $r['abc_group'],
                            'qty' => $r['qty'],
                            'qty_pick' => $r['qty_pick'],
                            'qty_order' => $r['qty_order'],
                            'qty_border' => $r['qty_border'],
                            'last_sold' => $r['last_sold'],
                            'brand_code' => $r['brand_code'],
                            'use4_code' => $r['use4_code'],
                            'mdin_code' => $r['mdin_code'],
                            'total' => rupiah($ppn + $r['sal_price'])
                        );
                    }
                    $grid = array(
                        'total' => $grids['total'],
                        'rows' => $data
                    );
                }
            } elseif ($table == 'acc_slh') {
                $sinv_code = $this->uri->segment(5);
                $where = array('sinv_code' => $sinv_code);
                $grid = $this->get_data_mdl->get_data($table, $where);
            } else {
                $grid = $this->get_data_mdl->get_data($table);
            }

            $this->json($grid);
        }
    }

    function grid_spk_stok() {
        if (isset($_GET['grid'])) {
            //$where['match_date NOT IN ("0000-00-00")'] = NULL;
            $where['pick_date IN ("0000-00-00")'] = NULL;

            if ($this->uri->segment(5)) {
                $where[$this->uri->segment(5)] = urldecode($this->uri->segment(6));
            }

            $table = $this->uri->segment(4);
            $grid = $this->get_data_mdl->get_data($table, $where);
            $this->json($grid);
        }
    }

    function grid_dpcd() {
        $dp_inv_no = $this->uri->segment(4);

        if ($this->uri->segment(5)) {
            $v_dpch = $this->all_m->getId('veh_dpch', 'dp_inv_no', $dp_inv_no);
            $where = array('dp_inv_no' => $dp_inv_no, 'use_date' => NULL);
            $read = $this->get_data_mdl->get_data('veh_dpcd', $where);

            foreach ($read['rows'] as $dpcd):
                $rows[] = array(
                    'id' => $dpcd['id'],
                    'dp_inv_no' => $dpcd['dp_inv_no'],
                    'dp_date' => $dpcd['dp_date'],
                    'so_no' => $dpcd['so_no'],
                    'so_date' => $dpcd['so_date'],
                    'cust_code' => $v_dpch->cust_code,
                    'cust_name' => $v_dpch->cust_name,
                    'due_date' => $dpcd['due_date'],
                    'pay_val' => rupiah($dpcd['pay_val']),
                    'check_no' => $dpcd['check_no'],
                    'chassis' => $v_dpch->chassis,
                    'engine' => $v_dpch->engine
                );
            endforeach;

            $data = array(
                'total' => count($rows),
                'rows' => $rows
            );
        }else {
            $where = array('dp_inv_no' => $dp_inv_no);
            $table = encrypt_decrypt('decrypt', $this->uri->segment(3));
            $data = $this->get_data_mdl->get_data($table, $where);
        }

        $this->json($data);
    }

    function grid_dpsd() {
        $po_no = $this->uri->segment(4);

        $v_dpsh = $this->all_m->getId('veh_dpsh', 'po_no', $po_no);
            $where = array('po_no' => $po_no, 'use_date' => NULL, 'pur_inv_no' => NULL);
            
            $read = $this->get_data_mdl->get_data('veh_dpsd', $where);

            foreach ($read['rows'] as $dpsd):
                $rows[] = array(
                    'id' => $dpsd['id'],
                    'dp_inv_no' => $dpsd['dp_inv_no'],
                    'dp_date' => $dpsd['dp_date'],
                    'po_no' => $dpsd['po_no'],
                    'po_date' => $dpsd['po_date'],
                    'supp_code' => $v_dpsh->supp_code,
                    'supp_name' => $v_dpsh->supp_name,
                    'pay_date' => $dpsd['pay_date'],
                    'pay_bt' => $dpsd['pay_bt'],
                    'check_no' => $dpsd['check_no'],
                    'chassis' => $v_dpsh->chassis,
                    'engine' => $v_dpsh->engine
                );
            endforeach;

            $data = array(
                'total' => $read['total'],
                'rows' => $rows
            );

        $this->json($data);
    }

    function grid_spkreg() {
        $table = encrypt_decrypt('decrypt', $this->uri->segment(3));

        $where = array();
        $like = array();

        if ($this->uri->segment(4)) {
            if ($this->uri->segment(4) == 'register') {
                $where['use_date'] = '0000-00-00 00:00:00';
            }
            if ($this->uri->segment(4) == 'distribute') {
                $where['use_date'] = '0000-00-00 00:00:00';
                $where['srep_code IN ("")'] = NULL;
            }
            if ($this->uri->segment(4) == 'undistribute') {
                $where['use_date'] = '0000-00-00 00:00:00';
                $where['srep_code NOT IN ("")'] = NULL;
            }
        } else {
            $where['use_date'] = '0000-00-00 00:00:00';
            $where['srep_code NOT IN ("")'] = NULL;
            //$where = array('use_date' => '0000-00-00 00:00:00', 'srep_code NOT IN ("")' => NULL);
        }

        if ($this->uri->segment(5)) {
            $field = $this->uri->segment(5);
            $value = $this->uri->segment(6);

            switch ($field) {
                case 'so_no':
                    $like = array('field' => $field, 'value' => $value);

                    break;

                case 'srep_code':
                    $where[$field] = $value;
                    break;

                case 'so_regdate':
                    //$date1 = $this->dateFormat($this->uri->segment(6));
                    //$date2 = $this->dateFormat($this->uri->segment(7));
                    $date1 = $this->uri->segment(6) . '/' . $this->uri->segment(7) . '/' . $this->uri->segment(8);
                    $date2 = $this->uri->segment(9) . '/' . $this->uri->segment(10) . '/' . $this->uri->segment(11);
                    //$date1 = date('Y-m-d h:i:s', $date1);
                    //$date2 = date('Y-m-d h:i:s', $date2);

                    $where[$field . ' >='] = $this->dateFormat($date1);
                    $where[$field . ' <='] = $this->dateFormat($date2);

                    break;
            }
        }

        $results = $this->get_data_mdl->get_data($table, $where, $like);

        foreach ($results['rows'] as $row) {
            $srep = $this->all_m->getId('veh_srep', 'srep_code', $row['srep_code']);

            $rows[] = array(
                'so_regdate' => $row['so_regdate'],
                'so_no' => $row['so_no'],
                'srep_code' => $row['srep_code'],
                'srep_name' => $row['srep_name'],
                'so_note' => $row['so_note'],
                'so_reg_by' => $row['so_reg_by'],
                'sspv_code' => $srep->sspv_code,
                'sspv_name' => $srep->sspv_name,
                'sspv_lev' => $srep->sspv_lev,
                'srep_lev' => $srep->srep_lev
            );
        }

        if ($rows == null) {
            $rows = array();
        }

        $data = array(
            'total' => $results['total'],
            'rows' => $rows
        );

        $this->json($data);
    }

    function grid_spk_search() {
        $table = encrypt_decrypt('decrypt', $this->uri->segment(3));
        $data = $this->get_data_mdl->get_data($table);
        $this->json($data);
    }

    function grid_spk() {
        // $dpch = $this->all_m->get_table('veh_dpch');
        $table = encrypt_decrypt('decrypt', $this->uri->segment(3));

        if ($this->uri->segment(4)) {

            if ($this->uri->segment(5)) {
                $field = $this->uri->segment(5);
                $value = $this->uri->segment(6);

                //$where = array('match_date' => '0000-00-00', );
                $where['match_date IN ("0000-00-00")'] = NULL;
                $where['cls_date NOT IN ("0000-00-00")'] = NULL;
                $where['canc_date IN ("0000-00-00")'] = NULL;
                $value = str_replace('%20', ' ', $value);

                $like = array('field' => $field, 'value' => $value);
                //print_r($like);exit;
                $data = $this->get_data_mdl->get_data($table, $where, $like);
            } else {
                //$where = array('match_date' => '0000-00-00');
                $where['match_date IN ("0000-00-00")'] = NULL;
                $where['cls_date NOT IN ("0000-00-00")'] = NULL;
                $where['canc_date IN ("0000-00-00")'] = NULL;
                $data = $this->get_data_mdl->get_data($table, $where);
            }
        } else {
            $data = $this->get_data_mdl->get_data($table);
        }

        $this->json($data);
    }

    function grid_substitusi() {
        $table1 = $this->uri->segment(3);
        $table2 = $this->uri->segment(4);
        $field = $this->uri->segment(5);
        $val = $this->uri->segment(6);

        $sql = "SELECT $table2.part_code, $table2.part_name, $table2.sal_price, $table2.qty, $table2.qty_pick, $table2.unit FROM $table1 INNER JOIN $table2 ON  $table1.part_code2=$table2.part_code WHERE $table1.$field='$val'";
        $result = $this->all_m->query_all($sql);
        $this->json($result);
    }

    function grid_uang_jaminan() {
        if ($this->uri->segment(4)) {
            $where = array('sal_inv_no' => $this->uri->segment(4));
            $table = encrypt_decrypt('decrypt', $this->uri->segment(3));
            $data = $this->get_data_mdl->get_data($table, $where);

            $veh_slh = $this->all_m->getOne('veh_slh', $where);

            foreach ($data['rows'] as $val):
                $grid_val[] = array(
                    'dp_inv_no' => $val['dp_inv_no'],
                    'dp_date' => $val['dp_date'],
                    'so_no' => $val['so_no'],
                    'payer_name' => $val['payer_name'],
                    'used_val' => $val['used_val'],
                    'check_no' => $val['check_no'],
                    'chassis' => $veh_slh->chassis,
                    'engine' => $veh_slh->engine,
                    'cust_code' => $veh_slh->cust_code
                );

            endforeach;

            $grid = array(
                'total' => $data['total'],
                'rows' => $grid_val
            );
        }else {
            $grid = array();
        }

        $this->json($grid);
    }

    function grid_acc_mst() {
        if (isset($_GET['grid'])) {
            $table = $this->uri->segment(4);
            $grids = $this->get_data_mdl->get_data($table);

            foreach ($grids['rows'] as $r) {
                $ppn = ($r['sal_price'] / 100) * 10;
                $data[] = array(
                    'id' => $r['id'],
                    'part_code' => $r['part_code'],
                    'part_name' => $r['part_name'],
                    'part_alias' => $r['part_alias'],
                    'unit' => $r['unit'],
                    'min_qty' => $r['min_qty'],
                    'max_qty' => $r['max_qty'],
                    'qty' => $r['qty'],
                    'qty_pick' => $r['qty_pick'],
                    'qty_order' => $r['qty_order'],
                    'qty_border' => $r['qty_border'],
                    'input_date' => $r['input_date'],
                    'sal_price' => rupiah($r['sal_price']),
                    'brand_code' => $r['brand_code'],
                    'mdin_code' => $r['mdin_code'],
                    'use4_code' => $r['use4_code'],
                    'note' => $r['note'],
                    'pack' => $r['pack'],
                    'pack_cont' => $r['pack_cont'],
                    'sal_pprice' => $r['sal_pprice'],
                    'prt_inact' => $r['prt_inact'],
                    'qtyl' => $r['qty1'],
                    'qtyw' => $r['qtyw'],
                    'total' => rupiah($ppn + $r['sal_price'])
                );
            }
            $grid = array(
                'total' => $grids['total'],
                'rows' => $data
            );
            $this->json($grid);
        }
    }

    function combogrid() {
        $table = encrypt_decrypt('decrypt', $this->uri->segment(3));

        if ($this->uri->segment(4)) {


            if ($table == 'veh_dpcd') {
                //$where = array($this->uri->segment(4) => $this->uri->segment(5));   
                $where[$this->uri->segment(4)] = urldecode($this->uri->segment(5));

                if ($this->uri->segment(6)) {
                    $where['use_date'] = NULL;
                    $where['sal_inv_no'] = NULL;
                }

                // $where['cls_date NOT IN ("0000-00-00")'] = NULL;
                //$where['sal_inv_no IN ("")'] = NULL;
            } elseif ($table == 'veh_bwoh') {
                $where[$this->uri->segment(4)] = urldecode($this->uri->segment(5));
                $where['cls_date NOT IN ("0000-00-00")'] = NULL;
            } elseif ($table == 'acc_woh') {
                $where[$this->uri->segment(4)] = urldecode($this->uri->segment(5));
                $where['cls_date NOT IN ("0000-00-00")'] = NULL;
            } elseif ($table == 'acc_poh') {
                $where[$this->uri->segment(4)] = urldecode($this->uri->segment(5));
                $where['cls_date NOT IN ("0000-00-00")'] = NULL;
            } elseif ($table == 'acc_slh') {

                $where['cls_date NOT IN ("0000-00-00")'] = NULL;

                if ($this->uri->segment(4) == 'sinv_code') {
                    $where['sinv_code NOT IN ("VSL")'] = NULL;
                } elseif ($this->uri->segment(4) == 'retur') {
                    $where['sinv_code'] = 'VSL';
                } else {
                    $where[$this->uri->segment(4)] = urldecode($this->uri->segment(5));
                }
            } elseif ($table == 'maccs') {
                if ($this->uri->segment(4) == 'wrhs_code') {
                    $where[$this->uri->segment(4)] = urldecode($this->uri->segment(5));
                    $where['prt_inact'] = '';
                } else {
                    $where = array($this->uri->segment(4) => null);
                }
            } elseif ($table == 'veh_slh') {
                if ($this->uri->segment(4) == 'pick_date') {
                    // $where['cls_date IN ("0000-00-00")'] = NULL;
                    $where['chassis NOT IN ("")'] = NULL;
                }
                if ($this->uri->segment(4) == 'cls_date') {
                    $where['cls_date NOT IN ("0000-00-00")'] = NULL;
                    $where['chassis NOT IN ("")'] = NULL;
                }
                if ($this->uri->segment(4) == 'accessories') {
                    //$where['chassis NOT IN ("")'] = NULL;
                    //$where['pick_date NOT IN ("0000-00-00")'] = NULL;
                    $where['cls_date IN ("0000-00-00")'] = NULL;

                    // print_r($where);exit;
                }
                if ($this->uri->segment(4) == 'bbnwo_no') {
                    // $where['cls_date IN ("0000-00-00")'] = NULL;
                    $where['bbnwo_no IN ("")'] = NULL;
                }
            } elseif ($table == 'veh_aph') {
                if ($this->uri->segment(6) == 'hutang') {
                    $where['hd_end NOT IN ("0")'] = NULL;
                    $where['apg_inv_no'] = '';

                    if ($this->uri->segment(7) == '2') {
                        $where['apv_inv_no'] = $this->uri->segment(8);
                    }
                }
                if ($this->uri->segment(6) == 'voucher') {
                    if ($this->uri->segment(7)) {
                        //vpg_source
                        $where['vpg_source NOT IN ("", NULL)'] = NULL;
                    }
                    // $where['apv_inv_no'] = '';
                    $where['apv_inv_no IN ("", NULL)'] = NULL;
                    $where['hd_end NOT IN ("0")'] = NULL;
                }
                $where[$this->uri->segment(4)] = urldecode($this->uri->segment(5));
                $where['cls_date NOT IN ("0000-00-00")'] = NULL;
            } elseif ($table == 'veh_arh') {
                if ($this->uri->segment(6) == 'piutang') {
                    $where['pd_end NOT IN ("0")'] = NULL;
                }
                $where[$this->uri->segment(4)] = urldecode($this->uri->segment(5));
                $where['cls_date NOT IN ("0000-00-00")'] = NULL;
                //print_r($where);exit;
            } elseif ($table == 'veh_spk') {
                if ($this->uri->segment(4) == 'pick') {
                    $where['cls_date NOT IN ("0000-00-00")'] = NULL;
                    $where['pick_date IN ("0000-00-00")'] = NULL;
                    $where['match_date IN ("0000-00-00")'] = NULL;
                    $where['match_date IN ("0000-00-00")'] = NULL;
                    $where['canc_date IN ("0000-00-00")'] = NULL;
                }
            } elseif ($table == 'acc_wood') {
                if ($this->uri->segment(6) == 'rcv') {
                    $where['rcv_qty IN ("0")'] = NULL;
                }

                if ($this->uri->segment(5) !== '0') {
                    $where[$this->uri->segment(4)] = urldecode($this->uri->segment(5));
                }
                // print_r($where);exit;
            } elseif ($table == 'acc_pood') {
                if ($this->uri->segment(6) == 'rcv') {
                    $where['rcv_qty IN ("0")'] = NULL;
                }

                if ($this->uri->segment(5) !== '0') {
                    $where[$this->uri->segment(4)] = urldecode($this->uri->segment(5));
                }
                //print_r($where);exit;
            } elseif ($table == 'veh_po') {
                $where['cls_date NOT IN ("0000-00-00")'] = NULL;
            } else {
                $where[$this->uri->segment(4)] = urldecode($this->uri->segment(5));
            }

            if ($table == 'acc_aph') {
                if ($this->uri->segment(6)) {
                    $where[$this->uri->segment(6)] = urldecode($this->uri->segment(7));
                }
            }
            if($table == 'veh'){
                if ($this->uri->segment(4) == 'bbnwo_no') {
                    // $where['cls_date IN ("0000-00-00")'] = NULL;
                    $where['bbnwo_no IN ("")'] = NULL;
                }
            }

            $data = $this->get_data_mdl->get_data($table, $where);
        } else {
            if ($table == 'veh_spk') {
                $where['cls_date NOT IN ("0000-00-00")'] = NULL;
                //$where['dp_date IN ("0000-00-00")'] = NULL;
                //$where['dp_inv_no IN ("")'] = NULL;
                $data = $this->get_data_mdl->get_data($table, $where);
            } elseif ($table == 'veh_po') {
                $where['cls_date NOT IN ("0000-00-00")'] = NULL;
                $where['pur_inv_no IN ("")'] = NULL;
                $data = $this->get_data_mdl->get_data($table, $where);
            } elseif ($table == 'veh_slh') {
                $where['cls_date NOT IN ("0000-00-00")'] = NULL;
                //$where['pur_inv_no IN ("")'] = NULL;
                $data = $this->get_data_mdl->get_data($table, $where);
            } elseif ($table == 'veh_prh') {
                $where['cls2_date NOT IN ("0000-00-00")'] = NULL;
                //$where['pur_inv_no IN ("")'] = NULL;
                $data = $this->get_data_mdl->get_data($table, $where);
            } elseif ($table == 'veh_aph') {
                $where['cls_date NOT IN ("0000-00-00")'] = NULL;
                //$where['hd_begin NOT IN ("0")'] = NULL;
                $data = $this->get_data_mdl->get_data($table, $where);
            } elseif ($table == 'acc_prh') {
                $where['cls2_date NOT IN ("0000-00-00")'] = NULL;
                //$where['pur_inv_no IN ("")'] = NULL;
                $data = $this->get_data_mdl->get_data($table, $where);
            } elseif ($table == 'veh_apvh') {
                $where['cls_date NOT IN ("0000-00-00")'] = NULL;
                //$where['pur_inv_no IN ("")'] = NULL;
                $data = $this->get_data_mdl->get_data($table, $where);
            } else {
                $data = $this->get_data_mdl->get_data($table);
            }
        }

        $this->json($data);
    }

    function combobox() {
        $table = encrypt_decrypt('decrypt', $this->uri->segment(3));
        $name = $this->uri->segment(4);

        $data = $this->get_data_mdl->get_data_combogrid($table);

        foreach ($data as $r) {
            $combobox[] = array(
                'id' => $r['id'],
                'text' => $r[$name]
            );
        }
        $this->json($combobox);
    }

    function read_combogrid() {
        $table = encrypt_decrypt('decrypt', $this->uri->segment(3));
        $field1 = $this->uri->segment(4);
        $field2 = $this->uri->segment(5);
        $rows = $this->all_m->query_all("select $field1, $field2 from $table");
        $total = $this->all_m->query_single("select count(*) as total from $table");

        $data = array(
            'total' => $total->total,
            'rows' => $rows
        );

        $this->json($data);
    }

    function roleLocked() {

        $stat = false;
        $msg = array('status' => false, 'message' => 'Data is currently used by other user');

        $table = $this->input->post('table');
        $id = $this->input->post('id');
        $user = $this->input->post('user');


        $row = $this->all_m->getId($table, 'id', $id);
        
        if($table == 'veh_dpch'){
            unset($row->cls_date);
        }

        $locked_date = date_create($row->locked_date);
        date_add($locked_date, date_interval_create_from_date_string('15 minutes'));
        $locked_date = date_format($locked_date, 'Y-m-d H:i:s');

        if ($row->locked_date == NULL) {
            $stat = true;
        } else {

            if (intval(strtotime(date('Y-m-d H:i:s'))) > intval(strtotime($locked_date))) {
                $stat = true;
            }
        }

        if ($row->locked_by == NULL) {
            $stat = true;
        } else {
            if ($row->locked_by == $user) {
                $stat = true;
            }
        }

        if ($this->input->post('cls_date')) {

            $cls_date = $this->input->post('cls_date');

            if ($row->$cls_date !== '0000-00-00') {
                $stat = false;
                $msg = array('status' => false, 'message' => 'Sorry, Invoice Already Closed');
            }

            if ($row->$cls_date == '') {
                $stat = true;
            }
        }


        if ($this->input->post('print')) {
            if ($row->cls_date == '0000-00-00') {
                $stat = false;
                $msg = array('status' => false, 'message' => 'Sorry, Invoice has been unclosed by other user');
            }
        }

        if ($stat !== false) {
            $msg = array('status' => true);

            if (!empty($this->input->post('action'))) {
                $this->all_m->updateData($table, 'id', $id, array('locked_by' => $user, 'locked_date' => date('Y-m-d H:i:s')));
            }
        }

        $this->json($msg);
    }

    function roleUnclose() {
        $msg = array('status' => false, 'message' => 'Sorry, Invoice Already Unclosed');

        $table = $this->input->post('table');
        $id = $this->input->post('id');
        $user = $this->input->post('user');
        $cls_date = $this->input->post('cls_date');
        $afucls = 1;

        $usr_veh = $this->all_m->getId('usr_veh', 'username', $user);

        if ($table == 'veh_slh') {
            $afucls = $usr_veh->ucpvehslh;
        }

        if ($table == 'veh_spk') {
            $afucls = $usr_veh->ucpvehspk;
        }

        $row = $this->all_m->getId($table, 'id', $id);

        if ($row->$cls_date !== '0000-00-00') {
            $msg = array('status' => true);
        }

        if ($afucls == 0) {
            $prn_cnt = $row->prn_cnt;

            if ($prn_cnt > 0) {
                $msg = array('status' => false, 'message' => 'insufficient access privilege.<br />Invoice has already been printed');
            }
        }
        $this->json($msg);
    }

    function roleCancel() {
        $table = $this->input->post('table');
        $id = $this->input->post('id');

        $update = $this->all_m->updateData($table, 'id', $id, array('locked_by' => '', 'locked_date' => '0000-00-00'));
        $msg = array('status' => true);

        $this->json($msg);
    }

    function checkCLose() {
        $table = $this->input->post('table');
        $id = $this->input->post('id');
        $user = $this->input->post('user');


        $row = $this->all_m->getId($table, 'id', $id);

        $msg = array('status' => true);

        if ($id !== '') {
            if ($this->input->post('cls_date')) {

                $cls_date = $this->input->post('cls_date');

                if ($row->$cls_date) {

                    if ($row->$cls_date !== '0000-00-00') {
                        $stat = false;
                        $msg = array('status' => false, 'message' => 'Sorry, Invoice Already Closed');
                    }

                    if ($row->$cls_date == '') {
                        $stat = true;
                    }
                }
            }
        }
        $this->json($msg);
    }

    function grid_stkMove() {
        // $dpch = $this->all_m->get_table('veh_dpch');
        $table = encrypt_decrypt('decrypt', $this->uri->segment(3));

        $where['match_date IN ("0000-00-00")'] = NULL;
        $where['pick_date IN ("0000-00-00")'] = NULL;
        $data = $this->get_data_mdl->get_data($table, $where);

        $this->json($data);
    }

    function checkRoles() {

        $key = $this->input->post('key');
        $form = $this->input->post('form');
        $user = $this->input->post('user');
        $field = $key . '_' . $form;

        $row = $this->all_m->roleUser($user);
        $access = $row[0];

        $res = array('num' => $access->$field);

        $this->json($res);
    }

}
