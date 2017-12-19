<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class crud_mdl extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    function read($table, $nav, $id, $where = null) {
        $this->db->from($table);

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

        if ($id !== '') {
            if ($nav !== '') {
                if ($nav == 'f' || $nav == 'F') {
                    $this->db->order_by('id', 'asc');
                }
                if ($nav == 'p' || $nav == 'P') {
                    $query = $this->get_prev($table, $id, $where);
                    return $query;
                    exit;
                }
                if ($nav == 'n' || $nav == 'N') {
                    $query = $this->get_next($table, $id, $where);
                    return $query;
                    exit;
                }
                if ($nav == 'l' || $nav == 'L') {
                    $this->db->order_by('id', 'desc');
                }
            } else {
                if ($id !== '') {
                    $this->db->where('id', $id);
                } else {
                    $this->db->order_by('id', 'desc');
                }
            }
        } else {
            $this->db->order_by('id', 'desc');
        }


        $this->db->limit(1);
        $query = $this->db->get();
        //$query = $this->db->last_query(); 
        
        //return $query;
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return array();
        }
    }

    function read_relation($table, $nav, $id, $relation = null) {
        $this->db->from($table);

        if ($id !== '') {
            if ($nav !== '') {
                if ($nav == 'f' || $nav == 'F') {
                    $this->db->order_by('id', 'asc');
                }
                if ($nav == 'p' || $nav == 'P') {
                    $query = $this->get_prev($table, $id);
                    return $query;
                    exit;
                }
                if ($nav == 'n' || $nav == 'N') {
                    $query = $this->get_next($table, $id);
                    return $query;
                    exit;
                }
                if ($nav == 'l' || $nav == 'L') {
                    $this->db->order_by('id', 'desc');
                }
            } else {
                if ($id !== '') {
                    $this->db->where('id', $id);
                } else {
                    $this->db->order_by('id', 'desc');
                }
            }
        } else {
            $this->db->order_by('id', 'desc');
        }

        if ($relation) {
            $this->db->where($relation);
        }

        $this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return array();
        }
    }

    public function get_next($table, $id, $where = null) {
        $this->db->where('id >', $id);

        /*if ($where !== null) {
            $this->db->or_where($where);
        }
        */
                
        $this->db->limit(1);
        $query = $this->db->get();
        //$query = $this->db->query("select * from $table where id > $id and $where limit 1");
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return $this->read($table, 'L', $id);
            //return array();
        }
    }

    public function get_prev($table, $id, $where = null) {
        $this->db->where('id <', $id);

       /* if ($where !== null) {
            $this->db->or_where($where);
        }        
       */
        $this->db->order_by('id', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();
        //$query = $this->db->last_query(); 
        
        //return $query;
        //$query = $this->db->query("select * from $table where id < $id order by id desc limit 1");
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return $this->read($table, 'F', $id);
        }
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
