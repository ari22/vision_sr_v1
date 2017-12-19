<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class all_m extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function get_table($tbl) {
        return $this->db->get($tbl)->result();
    }

    function getId($tbl, $field, $value) {
        $query = $this->db->where($field, $value)->limit(1)->get($tbl);
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return array();
        }
    }

    function getWhere($tbl, $array) {
        $query = $this->db->where($array)->get($tbl);

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }

    function updateData($tbl, $field, $id, $data = array()) {
        $this->db->where($field, $id)->update($tbl, $data);
    }

    function deleteData($tbl, $field, $id) {
        $this->db->where($field, $id)->delete($tbl);
    }

    function insertData($tbl, $data) {
        $this->db->insert($tbl, $data);
    }

    function getOne($tbl, $array) {
        $query = $this->db->where($array)->get($tbl);
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return array();
        }
    }

    function countlimit($tbl, $array) {
        $query = $this->db->where($array)->get($tbl);
        $total = $query->num_rows();
        return $total;
    }

    function check($tbl, $array) {
        $query = $this->db->where($array)->get($tbl);
        $total = $query->num_rows();
        return $total;
    }

    function query_all($query) {
        $sql = $this->db->query($query);
        if ($sql->num_rows() > 0) {
            return $sql->result();
        } else {
            return array();
        }
    }

    function query_single($query) {
        $sql = $this->db->query($query);
        if ($sql->num_rows() > 0) {
            return $sql->row();
        } else {
            return array();
        }
    }

    function truncate($tbl) {
        return $this->db->truncate($tbl);
    }

    function autoNumber($table, $field, $count, $default) {
        $cust_name = strtoupper($default);
        $trimmed = str_replace(' ', '', $cust_name);
        $name = substr($trimmed, 0, 3);
        $q = $this->db->query("SELECT MAX(RIGHT($field,$count)) AS idmax FROM " . $table . " WHERE $field LIKE '$name%' order by id desc");
        //$q = $this->db->query($query = "SELECT max($field) AS maxID FROM $table WHERE $field LIKE '$name%' order by id desc");
        $kd = '';

        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {

                $tmp = ((int) $k->idmax) + 1;
                $kd = str_pad($tmp, $count, "0", STR_PAD_LEFT);
            }
        } else {
            //$kd  =  sprintf("%%s = %s", 1);
            $kd = str_pad('1', $count, "0", STR_PAD_LEFT);
        }
        //return $kd;
        return $name . '-' . $kd;
    }

    function inv_seq($count, $val) {
        $table = 'inv_seq';
        $name = strtoupper($val);
        $name = str_replace(' ', '', $name);
        $name = substr($name, 0, 3);

        $q = $this->db->query($query = "SELECT max(inv_no) AS maxID, inv_year, inv_mth FROM $table WHERE inv_type ='$val' order by id desc");
        $kd = '';
        
        $period = date('ym');
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                //return $k->maxID + 1;
                $tmp = $k->maxID + 1;
                $kd = str_pad($tmp, $count, "0", STR_PAD_LEFT);
                $year = substr($k->inv_year,2);
                $cnt = strlen($k->inv_mth);               
                
                $mounth = $k->inv_mth; 
                
                if($cnt < 2){
                    $mounth = 0 . $k->inv_mth; 
                }
                
                $period = $year.$mounth;
                //$period = date_format($period,"ym");
            }
        } else {
            //$kd  =  sprintf("%%s = %s", 1);
            $kd = str_pad('1', $count, "0", STR_PAD_LEFT);
        }
        //return $kd;
        
        return $name . '-' . $period . $kd;
    }

    function menu() {
        $query = $this->db->query('SELECT * from menu');

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }

    function checkingClose($mounth, $year, $tbl, $cond){
        $this->db->select("a.*");
        $this->db->from($tbl.' a');
        $this->db->where('MONTH(a.cls_date) =', $mounth);
        $this->db->where('YEAR(a.cls_date) =', $year);
        $this->db->where('a.cls_date NOT IN ("0000-00-00")', NULL);
        
        if($cond == 1){
            $this->db->where('a.prn_cnt > 1', NULL);
        }
        if($cond == 0){
            $this->db->where('a.prn_cnt = 0', NULL);
        }
        
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }
    
    function refreshingStock($chassis=null){
        
        $this->db->select("a.cls_date as prh_cls, a.cls2_date as prh_cls2, b.cls_date as rprh_cls, c.cls_date as slh_cls, c.pick_date, d.cls_date as rslh_cls ");
        $this->db->from('veh_prh a');
        $this->db->join('veh_rprh b', 'a.chassis = b.chassis', 'left');
        $this->db->join('veh_slh c', 'a.chassis = c.chassis', 'left');
        $this->db->join('veh_rslh d', 'a.chassis = d.chassis', 'left');
        
        $this->db->where('a.chassis', $chassis);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }
    function checkingSales($mounth, $year) {
        $this->db->select("veh_slh.id, veh_slh.sal_inv_no, veh_slh.cls_date, veh_slh.chassis,veh_slh.so_no,veh_slh.cust_code,veh_slh.cust_name,veh_slh.srep_code,veh_slh.srep_name,veh_slh.veh_code,veh_slh.veh_name,veh_slh.veh_transm,veh_slh.color_code,veh_slh.color_name");
        $this->db->from('veh_slh');
        $this->db->join('veh_spk', 'veh_spk.chassis = veh_slh.chassis', 'left');
        $this->db->join('veh_arh', 'veh_arh.chassis = veh_slh.chassis', 'left');
        $this->db->join('veh_argd', 'veh_argd.chassis = veh_slh.chassis', 'left');
        $this->db->where('MONTH(veh_slh.cls_date) <=', $mounth);
        $this->db->where('YEAR(veh_slh.cls_date) <=', $year);
        $this->db->where('veh_slh.chassis NOT IN ("")', NULL);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }
    
    function checkingAcc($mounth, $year) {
        //$this->db->select("veh_slh.id, veh_slh.sal_inv_no, veh_slh.cls_date, veh_slh.chassis,veh_slh.so_no,veh_slh.cust_code,veh_slh.cust_name,veh_slh.srep_code,veh_slh.srep_name,veh_slh.veh_code,veh_slh.veh_name,veh_slh.veh_transm,veh_slh.color_code,veh_slh.color_name");
        $this->db->select('acc_slh.*');
        $this->db->from('acc_slh');
        
        $this->db->where('MONTH(acc_slh.cls_date) <=', $mounth);
        $this->db->where('YEAR(acc_slh.cls_date) <=', $year);
        //$this->db->where('veh_slh.chassis NOT IN ("")', NULL);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }
    
    function roleUser($username){
        //$this->db->select('a.*, b.*, c.*, d.*, e.*, f.*, g.*');
        $this->db->select('a.*, b.*, c.*, d.*');
        $this->db->from('usr a');
        $this->db->join('usr_acc b', 'a.username = b.username', 'left');
        $this->db->join('usr_veh c', 'a.username = c.username', 'left');
        $this->db->join('usr_veh2 d', 'a.username = d.username', 'left');
        
        $this->db->where('a.username', $username);
        
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }
}
