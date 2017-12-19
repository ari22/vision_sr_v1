<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('set_permalink')) {

    function set_permalink($content) {
        $karakter = array('{', '}', ')', '(', '|', '`', '~', '!', '@', '%', '$', '^', '&', '*', '=', '?', '+', '-', '/', '\\', ',', '.', '#', ':', ';', '\'', '"', '[', ']');
        $hapus_karakter_aneh = strtolower(str_replace($karakter, "-", $content));
        $tambah_strip = strtolower(str_replace(' ', '-', $hapus_karakter_aneh));
        $link_akhir = $tambah_strip;
        return $link_akhir;
    }

    function encrypt_decrypt($action, $string) {
        $output = false;

        if ($action == 'encrypt') {
            $output = strtr(base64_encode($string), '+/', '-_');
        } else if ($action == 'decrypt') {
            $output = base64_decode(strtr($string, '-_', '+/'));
        }

        return $output;
    }

    function bilangan($x) {
        $x = abs($x);
        $angka = array("", "satu", "dua", "tiga", "empat", "lima",
            "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        $temp = "";

        if ($x < 12) {
            $temp = " " . $angka[$x];
        } else if ($x < 20) {
            $temp = bilangan($x - 10) . " belas";
        } else if ($x < 100) {
            $temp = bilangan($x / 10) . " puluh" . bilangan($x % 10);
        } else if ($x < 200) {
            $temp = " seratus" . bilangan($x - 100);
        } else if ($x < 1000) {
            $temp = bilangan($x / 100) . " ratus" . bilangan($x % 100);
        } else if ($x < 2000) {
            $temp = " seribu" . bilangan($x - 1000);
        } else if ($x < 1000000) {
            $temp = bilangan($x / 1000) . " ribu" . bilangan($x % 1000);
        } else if ($x < 1000000000) {
            $temp = bilangan($x / 1000000) . " juta" . bilangan($x % 1000000);
        } else if ($x < 1000000000000) {
            $temp = bilangan($x / 1000000000) . " milyar" . bilangan(fmod($x, 1000000000));
        } else if ($x < 1000000000000000) {
            $temp = bilangan($x / 1000000000000) . " trilyun" . bilangan(fmod($x, 1000000000000));
        }
        return $temp;
    }

    function terbilang($x, $style = 3) {
        if ($x < 0) {
            $hasil = "minus " . trim(bilangan($x));
        } else {
            $hasil = trim(bilangan($x));
        }
        switch ($style) {
            case 1:
                $hasil = strtoupper($hasil);
                break;
            case 2:
                $hasil = strtolower($hasil);
                break;
            case 3:
                $hasil = ucwords($hasil);
                break;
            default:
                $hasil = ucfirst($hasil);
                break;
        }
        return $hasil;
    }

    function rupiah($angka) {
        //$rupiah = "Rp. " . number_format($angka, 0, ',', '.');
        $rupiah = number_format($angka, 0, '.', ',');
        return $rupiah;
    }

}