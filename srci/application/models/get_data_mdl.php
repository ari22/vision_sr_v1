<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class get_data_mdl extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_data($table, $where = null, $like = null, $cond = null) {

        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';

        $q = isset($_POST['q']) ? strval($_POST['q']) : '';

        $field1 = isset($_POST['field1']) ? mysql_real_escape_string($_POST['field1']) : '';
        $field2 = isset($_POST['field2']) ? mysql_real_escape_string($_POST['field2']) : '';

        $query = $this->db->limit(1)->get($table);
        if ($query->num_rows() > 0) {
            $tbl = (array) $query->row();
        }

        if (!empty($tbl)) {
            foreach ($tbl as $k => $v) {
                $key[] = $k;
            }
        }

        $offset = ($page - 1) * $rows;

        $result = array();

        $getwrhs = $this->getwrhs($table);

        if ($getwrhs !== false) {
            $wrhs_field = $this->getwrhsfield($table);
            $wrhs_code = $this->getwrhscode();

            if ($wrhs_code !== 'ALL') {
                $this->db->where($wrhs_field, $wrhs_code);
            }
        }

        if ($where !== null) {
            $total = $this->db->where($where)->get($table)->num_rows();

            $this->db->where($where);

            if ($field1 !== '') {
                $this->db->like($key[1], $field1);
            }
            if ($field2 !== '') {
                $this->db->or_like($key[2], $field2);
            }

            if ($cond == null) {
                if ($q !== '') {
                    $this->db->like($key[1], $q);
                    $this->db->or_like($key[2], $q);
                }
            }
            /* Search Keyword */
            if ($like !== null) {
                $search = $like['value'];

                if (preg_match('/\s/', $like['value']) > 0) {
                    $search = array_map('trim', array_filter(explode(' ', $search)));

                    foreach ($search as $key => $value) {
                        $this->db->or_like($like['field'], $value);
                    }
                } else if ($search !== null) {

                    $this->db->like($like['field'], $search);
                }
            }
            /* End Search Keyword */

            $query = $this->db->get($table);
            $total = $query->num_rows();
        } else {

            if ($field1 !== '') {
                $this->db->like($key[1], $field1);
            }
            if ($field2 !== '') {
                $this->db->or_like($key[2], $field2);
            }
            if ($cond == null) {
                if ($q !== '') {
                    $this->db->like($key[1], $q);
                    $this->db->or_like($key[2], $q);
                }
            }

            /* Search Keyword */
            if ($like !== null) {
                $search = $like['value'];

                if (preg_match('/\s/', $like['value']) > 0) {
                    $search = array_map('trim', array_filter(explode(' ', $search)));

                    foreach ($search as $key => $value) {
                        $this->db->or_like($like['field'], $value);
                    }
                } else if ($search !== null) {

                    $this->db->like($like['field'], $search);
                }
            }
            /* End Search Keyword */

            $query = $this->db->get($table);
            $total = $query->num_rows();
        }



        $result['total'] = $total;

        $row = array();

        if ($field1 !== '') {
            $this->db->like($key[1], $field1);
        }
        if ($field2 !== '') {
            $this->db->or_like($key[2], $field2);
        }
        if ($cond == null) {
            if ($q !== '') {
                $this->db->like($key[1], $q);
                $this->db->or_like($key[2], $q);
            }
        }

        /* Search Keyword */
        if ($like !== null) {
            $search = $like['value'];

            if (preg_match('/\s/', $like['value']) > 0) {
                $search = array_map('trim', array_filter(explode(' ', $search)));

                foreach ($search as $key => $value) {
                    $this->db->or_like($like['field'], $value);
                }
            } else if ($search !== null) {

                $this->db->like($like['field'], $search);
            }
        }
        /* End Search Keyword */

        if ($where !== null) {
            $this->db->where($where);
        }
        $getwrhs = $this->getwrhs($table);

        if ($getwrhs !== false) {
            $wrhs_field = $this->getwrhsfield($table);
            $wrhs_code = $this->getwrhscode();

            if ($wrhs_code !== 'ALL') {
                $this->db->where($wrhs_field, $wrhs_code);
            }
        }

        $this->db->limit($rows, $offset);
        $this->db->order_by($sort, $order);
        $criteria = $this->db->get($table);
        //return $this->db->last_query();
        $criteria = $criteria->result_array();
        $result = array_merge($result, array('rows' => $criteria));
        return $result;
    }

    function get_data_combogrid($table) {

        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';

        $q = isset($_POST['q']) ? strval($_POST['q']) : '';

        $query = $this->db->limit(1)->get($table);
        if ($query->num_rows() > 0) {
            $tbl = (array) $query->row();
        }

        foreach ($tbl as $k => $v) {
            $key[] = $k;
        }


        $offset = ($page - 1) * $rows;

        $result = array();

        $row = array();


        if ($q !== '') {
            $this->db->like($key[1], $q);
            $this->db->or_like($key[2], $q);
        }

        $this->db->limit($rows, $offset);
        $this->db->order_by($sort, $order);
        $criteria = $this->db->get($table);
        $criteria = $criteria->result_array();
        $result = array_merge($result, $criteria);
        return $result;
    }

    function getwrhs($tbl) {
        $db1 = $this->db->database;
        
        $stat = false;
        
        if($tbl == $db1.'.veh_spk' || $tbl == 'veh_spk'){
             $stat = true;
        }
        if($tbl == $db1.'.veh_slh' || $tbl == 'veh_slh'){
             $stat = true;
        }
        if($tbl == $db1.'.veh_po' || $tbl == 'veh_po'){
             $stat = true;
        }
        if($tbl == $db1.'.veh_prh' || $tbl == 'veh_prh'){
             $stat = true;
        }
        if($tbl == $db1.'.veh_movh' || $tbl == 'veh_movh'){
             $stat = true;
        }
        if($tbl == $db1.'.veh_rslh' || $tbl == 'veh_rslh'){
             $stat = true;
        }
        if($tbl == $db1.'.veh_rprh' || $tbl == 'veh_rprh'){
             $stat = true;
        }
        if($tbl == $db1.'.veh_dpch' || $tbl == 'veh_dpch'){
             $stat = true;
        }
        if($tbl == $db1.'.veh_argh' || $tbl == 'veh_argh'){
             $stat = true;
        }
        if($tbl == $db1.'.veh_aph' || $tbl == 'veh_aph'){
             $stat = true;
        }
        if($tbl == $db1.'.veh_apgh' || $tbl == 'veh_apgh'){
             $stat = true;
        }
        if($tbl == $db1.'.veh_argd' || $tbl == 'veh_argd'){
             $stat = true;
        }
        if($tbl == $db1.'.veh_apgd' || $tbl == 'veh_apgd'){
             $stat = true;
        }
        if($tbl == $db1.'.veh_spkhst' || $tbl == 'veh_spkhst'){
             $stat = true;
        }
        if($tbl == $db1.'.veh_spkreg' || $tbl == 'veh_spkreg'){
             $stat = true;
        }
        if($tbl == $db1.'.veh_bwoh' || $tbl == 'veh_bwoh'){
             $stat = true;
        }
        if($tbl == $db1.'.veh_bwod' || $tbl == 'veh_bwod'){
             $stat = true;
        }
        if($tbl == $db1.'.veh_bprh' || $tbl == 'veh_bprh'){
             $stat = true;
        }
        if($tbl == $db1.'.veh_bprd' || $tbl == 'veh_bprd'){
             $stat = true;
        }
        if($tbl == $db1.'.veh_stk' || $tbl == 'veh_stk'){
             $stat = true;
        }
        if($tbl == $db1.'.veh_dpsh' || $tbl == 'veh_dpsh'){
             $stat = true;
        }
        if($tbl == $db1.'.veh_dpsd' || $tbl == 'veh_dpsd'){
             $stat = true;
        }
        if($tbl == $db1.'.veh_dpsh' || $tbl == 'veh_dpsh'){
             $stat = true;
        }
        if($tbl == $db1.'.veh_dpsgd' || $tbl == 'veh_dpsgd'){
             $stat = true;
        }
        if($tbl == $db1.'.veh_dpsgh' || $tbl == 'veh_dpsgh'){
             $stat = true;
        }



        return $stat;
    }

    function getwrhsfield($tbl) {
       $db1 = $this->db->database;
        $field = 'wrhs_code';

        if ($tbl == $db1.'.veh_movh' || $tbl == 'veh_movh') {
            $field = 'wrhs_from';
        }


        return $field;
    }

    function getwrhscode() {

        $usr = $this->warehouse_q();
        $wrhs_axs = $usr->wrhs_axs;


        return $wrhs_axs;
    }

    function warehouse_q() {
        session_start();

        $usr_id = $_SESSION["C_ID"];
        $sql = $this->db->query("select wrhs_axs, wrhs_input from usr where id='$usr_id'");
        if ($sql->num_rows() > 0) {
            return $sql->row();
        } else {
            return array();
        }
    }

}
