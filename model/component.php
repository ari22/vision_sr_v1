<?php
/* component untuk remotecombobox / drop down field
  =================================================== CITY ======================================================================= */

function cmdCity($name, $caption, $width = null) {
    $url = "services/runCRUD.php?func=datasource&lookup=mst/city&pk=city_code&sk=city_name&order=city_name";
    //remotecombobox($name,$caption,100,$url,'city_code','city_name');
    $field = array
        (
        array("city_code", "Code", 100),
        array("city_name", "Name", 220),
    );
    if ($width == null) {
        $width = 170;
    }
    cmbGridSingle($name, $caption, $url, $field, $width, 1, 1);
}
?>

<?php

//=================================================== LOCATION =======================================================================//
function cmdLoc($name, $caption, $width = null, $key1 = null, $key2 = null) {
    $url = "services/runCRUD.php?func=datasource&lookup=mst/location&pk=loc_code&sk=loc_name&order=loc_name";
    //remotecombobox($name,$caption,100,$url,'cntry_code','cntry_name');
    $field = array
        (
        array("loc_code", "Code", 100),
        array("loc_name", "Name", 220),
    );
    cmbGridSingle($name, $caption, $url, $field, $width, $key1, $key2);
}
?>

<?php

//=================================================== COUNTRY =======================================================================//
function cmdCountry($name, $caption, $width = null) {
    $url = "services/runCRUD.php?func=datasource&lookup=mst/country&pk=cntry_code&sk=cntry_name&order=cntry_name";
    //remotecombobox($name,$caption,100,$url,'cntry_code','cntry_name');
    $field = array
        (
        array("cntry_code", "Code", 100),
        array("cntry_name", "Name", 220),
    );

    if ($width == null) {
        $width = 170;
    }
    cmbGridSingle($name, $caption, $url, $field, $width);
}
?>


<?php

//=================================================== SALES =======================================================================//
function cmdSales($name, $caption, $width = null) {
    //$url = "services/runCRUD.php?func=datasource&lookup=mst/veh_srep&pk=srep_code&sk=srep_name&order=srep_name";
    $url = "services/runCRUD.php?func=read&lookup=mst/veh_srep&pk=srep_code&sk=srep_name&order=srep_name&fields=id,srep_code,srep_name";
    //remotecombobox($name,$caption,220,$url,'srep_code','srep_name');
    $field = array
        (
        array("srep_code", "Code", 100),
        array("srep_name", "Name", 220),
    );
    cmbGridSingle($name, $caption, $url, $field, $width);
}
?>


<?php

//=================================================== CUSTOMER =======================================================================//
function cmdCust($name, $caption, $width = null) {
    $url = "services/runCRUD.php?func=datasource&lookup=mst/veh_cust&pk=cust_code&sk=cust_name&order=cust_name&fields=id,cust_code,cust_name";
    //remotecombobox($name,$caption,100,$url,'cust_code','cust_name');
    $field = array
        (
        array("cust_code", "Code", 100),
        array("cust_name", "Name", 220),
    );
    cmbGridSingle($name, $caption, $url, $field, $width);
}
?>


<?php

//=========================================================== RELIGION ==========================================================//
function cmdRelig($name, $caption, $width = null) {
    $url = "services/runCRUD.php?func=datasource&lookup=mst/religion&pk=relig_code&sk=relig_name&order=relig_name";
    //remotecombobox($name,$caption,100,$url,'relig_code','relig_name');
    $field = array
        (
        array("relig_code", "Code", 100),
        array("relig_name", "Name", 220),
    );
    cmbGridSingle($name, $caption, $url, $field, $width);
}
?>


<?php

//=========================================================== AREA ==========================================================//
function cmdArea($name, $caption, $width = null) {
    if ($width == null) {
        $width = 170;
    }
    $url = "services/runCRUD.php?func=datasource&lookup=mst/area&pk=area_code&sk=area_name&order=area_name";
    //remotecombobox($name,$caption,100,$url,'area_code','area_name');
    $field = array
        (
        array("area_code", "Code", 100),
        array("area_name", "Name", 220),
    );
    cmbGridSingle($name, $caption, $url, $field, $width);
}
?>

<?php

//=========================================================== LAST EDUCATION ==========================================================//
function cmdLastEdu($name, $caption, $width = null) {
    $url = "services/runCRUD.php?func=datasource&lookup=mst/educ_lev&pk=educ_code&sk=educ_name&order=educ_name";
    //remotecombobox($name,$caption,100,$url,'educ_code','educ_name');
    $field = array
        (
        array("educ_code", "Code", 100),
        array("educ_name", "Name", 220),
    );
    cmbGridSingle($name, $caption, $url, $field, $width);
}
?>
<?php

//=========================================================== LEVEL PURCHASER ==========================================================//
function cmdPurLev($name, $caption, $width = null) {
    $url = "services/runCRUD.php?func=datasource&lookup=mst/prep_lev&pk=plev_code&sk=plev_name&order=plev_name";
    //remotecombobox($name,$caption,100,$url,'plev_code','plev_name');
    $field = array
        (
        array("plev_code", "Code", 100),
        array("plev_name", "Name", 220),
    );
    cmbGridSingle($name, $caption, $url, $field, $width);
}
?>


<?php

//=========================================================== SALES LEVEL ==========================================================//
function cmdSalesLevel($name, $caption, $width = null) {
    $url = "services/runCRUD.php?func=datasource&lookup=mst/srep_lev&pk=slev_code&sk=slev_name&order=slev_name";
    //remotecombobox($name,$caption,100,$url,'slev_code','slev_name');
    $field = array
        (
        array("slev_code", "Code", 100),
        array("slev_name", "Name", 220),
    );
    cmbGridSingle($name, $caption, $url, $field, $width);
}
?>
<?php

//=========================================================== COLLECTOR LEVEL ==========================================================//
function cmdCollectorLevel($name, $caption, $width = null) {
    $url = "services/runCRUD.php?func=datasource&lookup=mst/coll_lev&pk=clev_code&sk=clev_name&order=clev_name";
    //remotecombobox($name,$caption,100,$url,'clev_code','clev_name');
    $field = array
        (
        array("clev_code", "Code", 100),
        array("clev_name", "Name", 220),
    );
    cmbGridSingle($name, $caption, $url, $field, $width);
}
?>

<?php

//=========================================================== BUSINESS TYPE ==========================================================//
function cmdBusType($name, $caption, $width = null) {
    $url = "services/runCRUD.php?func=datasource&lookup=mst/bus_fld&pk=fld_code&sk=fld_name&order=fld_name";
    //remotecombobox($name,$caption,100,$url,'fld_code','fld_name');
    $field = array
        (
        array("fld_code", "Code", 100),
        array("fld_name", "Name", 220),
    );

    if ($width == null) {
        $width = 170;
    }
    cmbGridSingle($name, $caption, $url, $field, $width);
}
?>


<?php

//=========================================================== BUSINESS PRODUCT ==========================================================//
function cmdBusProd($name, $caption, $width = null) {
    $url = "services/runCRUD.php?func=datasource&lookup=mst/bus_item&pk=item_code&sk=item_name&order=item_name";
    //remotecombobox($name,$caption,100,$url,'item_code','item_name');
    $field = array
        (
        array("item_code", "Code", 100),
        array("item_name", "Name", 220),
    );

    if ($width == null) {
        $width = 170;
    }
    cmbGridSingle($name, $caption, $url, $field, $width);
}
?>

<?php

//=========================================================== JOB DESCRIPTION ==========================================================//
function cmdJob($name, $caption, $width = null) {
    $url = "services/runCRUD.php?func=datasource&lookup=mst/job_fld&pk=job_code&sk=job_name&order=job_name";
    //remotecombobox($name,$caption,100,$url,'job_code','job_name');
    $field = array
        (
        array("job_code", "Code", 100),
        array("job_name", "Name", 220),
    );

    if ($width == null) {
        $width = 170;
    }

    cmbGridSingle($name, $caption, $url, $field, $width);
    // remotecombobox($name,$caption, $width,$url,'job_code','job_name');
}
?>

<?php

//=========================================================== WAREHOUSE ==========================================================//
function cmdWrhs($name, $caption, $width = null) {
    $url = "services/runCRUD.php?func=datasource&lookup=mst/veh_wrhs&pk=wrhs_code&sk=wrhs_name&order=wrhs_code";
    //remotecombobox($name,$caption,180,$url,'wrhs_code','wrhs_name');
    $field = array
        (
        array("wrhs_code", "Code", 120),
        array("wrhs_name", "Name", 220),
    );

    cmbGridSingle($name, $caption, $url, $field, $width);
}
function cmdWrhsAll($name, $caption, $width = null) {
    $url = "services/runCRUD.php?func=datasource&lookup=mst/veh_wrhs_all&pk=wrhs_code&sk=wrhs_name&order=wrhs_code";
    //remotecombobox($name,$caption,180,$url,'wrhs_code','wrhs_name');
    $field = array
        (
        array("wrhs_code", "Code", 120),
        array("wrhs_name", "Name", 220),
    );

    cmbGridSingle($name, $caption, $url, $field, $width);
}
?>
<?php

//=========================================================== SUPPLIER ==========================================================//
function cmdSupp($name1, $name2, $caption, $width1 = null, $width2 = null) {
    $url = "services/runCRUD.php?func=read&lookup=mst/veh_supp&pk=supp_code&sk=supp_name&order=supp_code";
    //remotecombobox($name,$caption,180,$url,'wrhs_code','wrhs_name');
    $field = array
        (
        array("supp_code", "Code", 100),
        array("supp_name", "Name", 220),
    );
    cmbGrid($name1, $name2, $caption, $url, $field, $width1, $width2);
}
?>


<?php

//=========================================================== PO NO ==========================================================//
function cmbPoNo($name1, $caption, $width = null) {
    $url = "services/runCRUD.php?func=datasource&lookup=trx/veh_prh";
    //remotecombobox($name,$caption,180,$url,'wrhs_code','wrhs_name');
    $field = array
        (
        array("po_date", "Date", 220, 'formatDate'),
        array("po_no", "Code", 100),
    );
    cmbGridSingle($name1, $caption, $url, $field, $width);
}
?>


<?php

//=========================================================== SPK SOURCE ==========================================================//
function cmdSoSrc($name, $caption, $width = null) {
    $url = "services/runCRUD.php?func=datasource&lookup=mst/so_source&pk=sosrc_code&sk=sosrc_name&order=id";
    //remotecombobox($name,$caption,100,$url,'sosrc_code','sosrc_name');
    $field = array
        (
        array("sosrc_code", "Code", 100),
        array("sosrc_name", "Name", 220),
    );
    cmbGridSingle($name, $caption, $url, $field, $width, 1, 1);
}
?>

<?php
/* component untuk remotecombobox / drop down field
  =================================================== COLOR TYPE NAME ======================================================================= */

function cmdColorType($name, $caption, $width = null) {
    $url = "services/runCRUD.php?func=datasource&lookup=mst/col_type&pk=coltp_code&sk=coltp_name&order=id";
    //remotecombobox($name,$caption,100,$url,'color_code','coltp_name');
    $field = array
        (
        array("coltp_code", "Code", 150),
        array("coltp_name", "Name", 220),
    );
    cmbGridSingle($name, $caption, $url, $field, $width);
}
?>
<?php

//========================================================== PEMBAYARAN UANG MUKA ==========================================================//
function cmdUangMuka($name, $caption, $width = null) {
    $url = "services/runCRUD.php?func=datasource&lookup=mst/pay_type&pk=pay_type&sk=pay_name&order=pay_type";
    //remotecombobox($name,$caption,100,$url,'pay_code','pay_name');
    $field = array
        (
        array("pay_code", "Code", 100),
        array("pay_name", "Name", 220),
    );
    cmbGridSingle($name, $caption, $url, $field, $width);
}
?>
<?php

//========================================================== STANDARD OPTIONAL ==========================================================//
function cmdStdopt($name, $caption, $width = null) {
    $url = "services/runCRUD.php?func=datasource&lookup=mst/veh_stdopt&pk=stdoptcode&sk=stdoptname&order=stdoptname";
    //remotecombobox($name,$caption,100,$url,'brnd_code','brnd_name');
    $field = array
        (
        array("stdoptcode", "Code", 100),
        array("stdoptname", "Name", 220),
    );
    cmbGridSingle($name, $caption, $url, $field, $width);
}
?>
<?php

//========================================================== BRAND ==========================================================//
function cmdBrnd($name, $caption, $key = null, $key2 = null, $width = null) {
    $url = "services/runCRUD.php?func=datasource&lookup=mst/veh_brnd&pk=brnd_code&sk=brnd_name&order=brnd_name";
    //remotecombobox($name,$caption,100,$url,'brnd_code','brnd_name');
    $field = array
        (
        array("brnd_code", "Code", 100),
        array("brnd_name", "Name", 220),
    );
    cmbGridSingle($name, $caption, $url, $field, $width, $key, $key2);
}
?>
<?php

//========================================================== MODEL ==========================================================//
function cmdMod($name, $caption, $width = null) {
    $url = "services/runCRUD.php?func=datasource&lookup=mst/model&pk=model_code&sk=model_name&order=model_name";
    //remotecombobox($name,$caption,100,$url,'brnd_code','brnd_name');
    $field = array
        (
        array("model_code", "Code", 100),
        array("model_name", "Name", 220),
    );
    cmbGridSingle($name, $caption, $url, $field, $width);
}
?>
<?php

//========================================================== BRAND ACC ==========================================================//
function cmdBrndAcc($name, $caption, $width = null) {
    $url = "services/runCRUD.php?func=datasource&lookup=mst/brand&pk=brand_code&sk=brand_name&order=brand_name";
    //remotecombobox($name,$caption,100,$url,'brand_code','brand_name');
    $field = array
        (
        array("brand_code", "Code", 100),
        array("brand_name", "Name", 220),
    );
    cmbGridSingle($name, $caption, $url, $field, $width);
}
?>
<?php

//========================================================== TRANSMISI ==========================================================//
function cmdTransm($name, $caption, $width = null) {
    $url = "services/runCRUD.php?func=datasource&lookup=mst/veh_tran&pk=trans_code&sk=trans_name&order=trans_name";
    //remotecombobox($name,$caption,100,$url,'trans_code','trans_name');
    $field = array
        (
        array("trans_code", "Code", 100),
        array("trans_name", "Name", 220),
    );
    cmbGridSingle($name, $caption, $url, $field, $width);
}
?>
<?php

//========================================================== UNIT ==========================================================//
function cmdUnit($name, $caption, $key = null, $key2 = null, $width = null) {
    $url = "services/runCRUD.php?func=datasource&lookup=mst/prt_umsr&pk=unit&sk=unit_name&order=unit_name";
    //remotecombobox($name,$caption,100,$url,'unit','unit_name');
    $field = array
        (
        array("unit", "Code", 100),
        array("unit_name", "Name", 220),
    );
    cmbGridSingle($name, $caption, $url, $field, $width, $key, $key2);
}
?>
<?php

//========================================================== UNIT ==========================================================//
function cmdMdin($name, $caption, $width = null) {
    $url = "services/runCRUD.php?func=datasource&lookup=mst/prt_mdin&pk=mdin_code&sk=mdin_name&order=mdin_name";
    //remotecombobox($name,$caption,100,$url,'mdin_code','mdin_name');
    $field = array
        (
        array("mdin_code", "Code", 100),
        array("mdin_name", "Name", 220),
    );
    cmbGridSingle($name, $caption, $url, $field, $width);
}
?>
<?php

//========================================================== UNIT ==========================================================//
function cmdUse4($name, $caption, $width = null) {
    $url = "services/runCRUD.php?func=datasource&lookup=mst/prt_use4&pk=use4_code&sk=use4_name&order=use4_name";
    //remotecombobox($name,$caption,100,$url,'use4_code','use4_name');
    $field = array
        (
        array("use4_code", "Code", 100),
        array("use4_name", "Name", 220),
    );
    cmbGridSingle($name, $caption, $url, $field, $width);
}
?>
<?php

//========================================================== UNIT ==========================================================//
function cmdOpnameLev($name, $caption, $width = null) {
    $url = "services/runCRUD.php?func=datasource&lookup=mst/orep_lev&pk=oplev_code&sk=oplev_name&order=oplev_name";
    //remotecombobox($name,$caption,100,$url,'oplev_code','oplev_name');
    $field = array
        (
        array("oplev_code", "Code", 100),
        array("oplev_name", "Name", 220),
    );
    cmbGridSingle($name, $caption, $url, $field, $width);
}
?>
<?php

//========================================================== GROUP ==========================================================//
function cmdGroup($name, $caption, $width = null) {
    $url = "services/runCRUD.php?func=datasource&lookup=mst/prt_grp&pk=grp_code&sk=grp_name&order=grp_name";
    //remotecombobox($name,$caption,100,$url,'grp_code','grp_name');
    $field = array
        (
        array("grp_code", "Code", 100),
        array("grp_name", "Name", 220),
    );
    cmbGridSingle($name, $caption, $url, $field, $width);
}
?>
<?php

//========================================================== SUB GROUP ==========================================================//
function cmdSubGroup($name, $caption, $width = null) {
    $url = "services/runCRUD.php?func=datasource&lookup=mst/prt_sgrp&pk=sgrp_code&sk=sgrp_name&order=sgrp_name";
    //remotecombobox($name,$caption,100,$url,'sgrp_code','sgrp_name');
    $field = array
        (
        array("sgrp_code", "Code", 100),
        array("sgrp_name", "Name", 220),
    );
    cmbGridSingle($name, $caption, $url, $field, $width);
}
?>

<?php
/* component untuk combogrid / drop down field
  ===================================================== COMBOGRID ==========================================================================
  =================================================== KODE KENDARAAN ======================================================================= */

function cmdVeh($name, $caption, $key = null, $key2 = null, $width = null) {
    $url = "services/runCRUD.php?func=read&lookup=mst/veh_vtyp&pk=veh_code&sk=veh_name&field=id,veh_code,veh_name";
    $field = array
        (
        array("veh_code", "Code", 150),
        array("veh_name", "Name", 300),
    );
    cmbGridSingle($name, $caption, $url, $field, $width, $key, $key2);
}

function cmdCustSet($name1, $name2, $caption, $width1 = null, $width2 = null) {
    $url = "services/runCRUD.php?func=read&lookup=mst/veh_cust&pk=cust_code&sk=cust_name&order=cust_name";
    $field = array
        (
        array("cust_code", "Code", 100),
        array("cust_name", "Name", 220),
    );
    cmbGrid($name1, $name2, $caption, $url, $field, $width1, $width2);
}

function cmdSuppSet($name1, $name2, $caption) {
    $url = "services/runCRUD.php?func=read&lookup=mst/veh_supp&pk=supp_code&sk=supp_name&order=supp_name";
    $field = array
        (
        array("supp_code", "Code", 100),
        array("supp_name", "Name", 220),
    );
    cmbGrid($name1, $name2, $caption, $url, $field);
}

function cmdSalSet($name1, $name2, $caption) {
    $field = array
        (
        array("srep_code", "Code", 100),
        array("srep_name", "Name", 220),
    );
    $url = "services/runCRUD.php?func=read&lookup=mst/veh_srep&pk=srep_code&sk=srep_name&order=srep_name&fields=id,srep_code,srep_name,srep_lev,sex,sspv_code,sspv_name,sspv_lev";
    cmbGrid($name1, $name2, $caption, $url, $field);
}

function cmdVehSet($name1, $name2, $caption, $width1 = null, $width2 = null) {//n
    $url = "services/runCRUD.php?func=read&lookup=mst/veh_vtyp&pk=veh_code&sk=veh_name&join=veh_prc/on veh_vtyp.veh_code=veh_prc.veh_code&fields=id,veh_vtyp.veh_code,veh_vtyp.veh_name,veh_vtyp.veh_model,veh_vtyp.veh_type,veh_vtyp.veh_year,veh_vtyp.veh_brand,veh_vtyp.veh_transm,veh_vtyp.chas_pref,veh_vtyp.eng_pref";
    $field = array
        (
        array("veh_code", "Code", 100),
        array("veh_name", "Name", 220),
    );
    cmbGrid($name1, $name2, $caption, $url, $field, $width1, $width2); //n
}

function cmdSupSet($name1, $name2, $caption) {

    $url = "services/runCRUD.php?func=read&lookup=mst/veh_supp&pk=supp_code&sk=supp_name";
    $field = array
        (
        array("supp_code", "Code", 100),
        array("supp_name", "Name", 220),
    );
    cmbGrid($name1, $name2, $caption, $url, $field);
}

function cmdColSet($name1, $name2, $caption, $width1 = null, $width2 = null) {//n
    $field = array
        (
        array("color_code", "Code", 100),
        array("color_name", "Name", 250),
    );
    $url = "services/runCRUD.php?func=read&lookup=mst/color&pk=color_code&sk=color_name";
    cmbGrid($name1, $name2, $caption, $url, $field, $width1, $width2); //n
}

function cmdLeaseSet($name1, $name2, $caption,$width1=null, $width2=null) {
    $field = array
        (
        array("lease_code", "Code", 100),
        array("lease_name", "Name", 220),
    );
    $url = "services/runCRUD.php?func=read&lookup=mst/lease&pk=lease_code&sk=lease_name";
    cmbGrid($name1, $name2, $caption, $url, $field, $width1, $width2);
}

function cmdSpkNo($name1, $caption, $width = null) {
    $url = "services/runCRUD.php?func=read&lookup=trx/veh_spkreg&pk=so_no&sk=so_regdate&fields=so_no,so_regdate,srep_code,srep_name&where1=1&where2=2&order=so_regdate desc";
    $field = array
        (
        array("so_regdate", "Registration Date", 90, 'formatDate'),
        array("so_no", "SPK No", 100),
        array("srep_name", "Sales Name", 80),
    );
    cmbGridSingle($name1, $caption, $url, $field, $width);
}

function cmdAccWorkOptSet($name1, $name2, $caption) {
    $url = "services/runCRUD.php?func=read&lookup=mst/acc_wkcd&pk=wk_code&sk=wk_desc&order=wk_desc";
    $field = array
        (
        array("wk_code", "Code", 100),
        array("wk_desc", "Name", 200),
    );
    cmbGrid($name1, $name2, $caption, $url, $field, 150);
}

function cmdPo($name, $caption, $width = null) {
    $url = "services/runCRUD.php?func=datasource&lookup=mst/veh_po&pk=veh_code&sk=veh_name";
    $field = array
        (
        array("veh_code", "Code", 100),
        array("veh_name", "Name", 220),
    );
    cmbGridSingle($name, $caption, $url, $field, $width);
}
?>


<?php

//==============================================================================================================================//
//=========================================================== ARRAY ============================================================//
//==============================================================================================================================//
//=========================================================== MAIL TO ==========================================================//

function cmdMailTo($name, $caption) {
    $optpostaddr = array
        (
        array("", ""),
        array("Office", "1"),
        array("Home", "2"),
        array("Do not send", "3"),
    );
    ?>
    <tr>
        <td><?php getCaption($caption); ?> :</td>
        <td>
            <select class="easyui-combobox"
                    id="<?php echo $name; ?>"
                    name="<?php echo $name; ?>"
                    style="width:120;"
                    data-options="panelHeight:100,editable:false,width:120"
                    disabled=true
                    >
                        <?php
                        foreach ($optpostaddr as $val) {
                            echo '<option value="' . $val[1] . '">' . $val[0] . '</option>';
                        }
                        ?>
            </select>
        </td>
    </tr>
    <?php
}
?>


<?php

//=========================================================== SEX ==========================================================//
function cmdSex($name, $caption) {
    $optsex = array
        (
        array("", ""),
        array("Male", "1"),
        array("Female", "2"),
        array("Company", "3"),
    );
    ?>
    <tr>
        <td><?php getCaption($caption); ?> :</td>
        <td>
            <select class="easyui-combobox"
                    id="<?php echo $name; ?>"
                    name="<?php echo $name; ?>"
                    style="width:120px;"
                    data-options="panelHeight:100,editable:false,width:120"
                    disabled=true
                    >
                        <?php
                        foreach ($optsex as $val) {
                            echo '<option value="' . $val[1] . '">' . $val[0] . '</option>';
                        }
                        ?>
            </select>
        </td>
    </tr>
    <?php
}
?>



<?php

//=========================================================== CUSTOMER TYPE ==========================================================//
function cmdCustType($name, $caption) {
    $optcust_type = array
        (
        array("", ""),
        array("End User", "1"),
        array("Dealer / Reseller", "2"),
        array("Goverment / BUMN", "3"),
    );
    ?>
    <tr>
        <td><?php getCaption($caption); ?> :</td>
        <td>
            <select class="easyui-combobox"
                    id="<?php echo $name; ?>"
                    name="<?php echo $name; ?>"
                    style="width:120px;"
                    data-options="panelHeight:100,editable:false,width:200"
                    disabled=true
                    >
                        <?php
                        foreach ($optcust_type as $val) {
                            echo '<option value="' . $val[1] . '">' . $val[0] . '</option>';
                        }
                        ?>
            </select>
        </td>
    </tr>
    <?php
}
?>


<?php

//=========================================================== MARITAL STATUS ==========================================================//
function cmdMarital($name, $caption) {
    $optmarital = array
        (
        array("", ""),
        array("Single", "1"),
        array("Married", "2"),
    );
    ?>
    <tr>
        <td><?php getCaption($caption); ?> :</td>
        <td>
            <select class="easyui-combobox"
                    id="<?php echo $name; ?>"
                    name="<?php echo $name; ?>"
                    style="width:120px;"
                    data-options="panelHeight:100,editable:false,width:200"
                    disabled=true
                    >
                        <?php
                        foreach ($optmarital as $val) {
                            echo '<option value="' . $val[1] . '">' . $val[0] . '</option>';
                        }
                        ?>
            </select>
        </td>
    </tr>
    <?php
}
?>

<?php

//=========================================================== JENIS HARGA ==========================================================//
function cmdJenHar($name, $caption) {
    $optJenHar = array
        (
        array("", ""),
        array("On the road", "1"),
        array("OFF the road", "2"),
    );
    ?>
    <tr>
        <td><?php getCaption($caption); ?> :</td>
        <td>
            <select class="easyui-combobox"
                    id="<?php echo $name; ?>"
                    name="<?php echo $name; ?>"
                    style="width:120px;"
                    data-options="panelHeight:100,editable:false,width:200"
                    disabled=true
                    >
                        <?php
                        foreach ($optJenHar as $val) {
                            echo '<option value="' . $val[1] . '">' . $val[0] . '</option>';
                        }
                        ?>
            </select>
        </td>
    </tr>
    <?php
}
?>

<?php

//=========================================================== TRANSAKSI ==========================================================//
function cmdTrans($name, $caption) {
    $optTrans = array
        (
        array("", ""),
        array("Cash", "1"),
        array("Credit", "2"),
    );
    ?>
    <tr>
        <td><?php getCaption($caption); ?> :</td>
        <td>
            <select class="easyui-combobox"
                    id="<?php echo $name; ?>"
                    name="<?php echo $name; ?>"
                    style="width:120px;"
                    data-options="panelHeight:100,editable:false,width:200"
                    disabled=true
                    >
                        <?php
                        foreach ($optTrans as $val) {
                            echo '<option value="' . $val[1] . '">' . $val[0] . '</option>';
                        }
                        ?>
            </select>
        </td>
    </tr>
    <?php
}
?>

<?php

//=========================================================== PURCHASE TERHITUNG SEJAK ==========================================================//
function cmdSinceP($name, $caption) {
    $optsinceP = array
        (
        array("", ""),
        array("Order", "1"),
        array("Received", "2"),
        array("Purchase", "3"),
    );
    ?>
    <tr>
        <td>Day</td>
        <td>
            <select class="easyui-combobox"
                    id="<?php echo $name; ?>"
                    name="<?php echo $name; ?>"
                    style="width:120px;"
                    data-options="panelHeight:100,editable:false,width:120"
                    disabled=true
                    >
                        <?php
                        foreach ($optsinceP as $val) {
                            echo '<option value="' . $val[1] . '">' . $val[0] . '</option>';
                        }
                        ?>
            </select>
        </td>
    </tr>
    <?php
}
?>

<?php

//=========================================================== SALES TERHITUNG SEJAK ==========================================================//
function cmdSinceS($name, $caption) {
    $optsinceS = array
        (
        array("", ""),
        array("Delivery Order", "1"),
        array("Sales Invoice", "2"),
    );
    ?>
    <tr>
        <td>Hari</td>
        <td>
            <select class="easyui-combobox"
                    id="<?php echo $name; ?>"
                    name="<?php echo $name; ?>"
                    style="width:120px;"
                    data-options="panelHeight:100,editable:false,width:120"
                    disabled=true
                    >
                        <?php
                        foreach ($optsinceS as $val) {
                            echo '<option value="' . $val[1] . '">' . $val[0] . '</option>';
                        }
                        ?>
            </select>
        </td>
    </tr>
    <?php
}
?>
<?php

//=========================================================== PAJAK ==========================================================//
function cmdVat($name, $caption) {
    $optsinceS = array
        (
        array("", ""),
        array("No", "0"),
        array("Yes", "1"),
    );
    ?>
    <tr>
        <td><?php getCaption($caption); ?> :</td>
        <td>
            <select class="easyui-combobox"
                    id="<?php echo $name; ?>"
                    name="<?php echo $name; ?>"
                    style="width:120px;"
                    data-options="panelHeight:100,editable:false,width:120"
                    disabled=true
                    >
                        <?php
                        foreach ($optsinceS as $val) {
                            echo '<option value="' . $val[1] . '">' . $val[0] . '</option>';
                        }
                        ?>
            </select>
        </td>
    </tr>
    <?php
}
?>

<?php

//=========================================================== PAJAK ==========================================================//
function cmdInsentif($name, $caption) {
    $optinstf = array
        (
        array("", ""),
        array("No Incentives", "1"),
        array("Use Point", "2"),
        array("Percentage", "3"),
        array("Point & Percentage Combination", "4"),
    );
    ?>
    <tr>
        <td><?php getCaption($caption); ?> :</td>
        <td>
            <select class="easyui-combobox"
                    id="<?php echo $name; ?>"
                    name="<?php echo $name; ?>"
                    style="width:120px;"
                    data-options="panelHeight:100,editable:false,width:120"
                    disabled=true
                    >
                        <?php
                        foreach ($optinstf as $val) {
                            echo '<option value="' . $val[1] . '">' . $val[0] . '</option>';
                        }
                        ?>
            </select>
        </td>
    </tr>
    <?php
}

/* ---- Combo Master Barang Accesoris---- */

function cmdacc_mst($name, $caption, $key = null, $key2 = null, $width2 = null) {
    $url = "services/runCRUD.php?func=datasource&lookup=mst/acc_mst&pk=part_code&sk=part_name";
    //remotecombobox($name,$caption,100,$url,'sgrp_code','sgrp_name');
    $field = array
        (
        array("part_code", "Code", 100),
        array("part_name", "Name", 220)
    );
    cmbGridSingle2($name, $caption, $url, $field, 350, $key, $key2, $width2);
}

function cmdSpvSet($name1, $name2, $caption) {
    $field = array
        (
        array("sspv_code", "Code", 100),
        array("sspv_name", "Name", 220),
    );
    $url = "services/runCRUD.php?func=read&lookup=mst/veh_sspv&pk=sspv_code&sk=sspv_name&order=sspv_name&fields=id,sspv_code,sspv_name,sspv_lev";
    cmbGrid($name1, $name2, $caption, $url, $field);
}

function cmdEDC($name, $caption, $width = null) {
    $url = "services/runCRUD.php?func=datasource&lookup=mst/edc&pk=edc_code&sk=edc_name";
    //remotecombobox($name,$caption,100,$url,'city_code','city_name');
    $field = array
        (
        array("edc_code", "Code", 100),
        array("edc_name", "Name", 220),
    );
    if ($width == null) {
        $width = 150;
    }
    cmbGridSingle($name, $caption, $url, $field, $width, $key = null, 0);
}

function cmdDepartment($name1, $name2, $caption, $width1 = null, $width2 = null) {
    $field = array
        (
        array("dept_code", "Code", 100),
        array("dept_name", "Name", 220),
    );
    $url = "services/runCRUD.php?func=read&lookup=mst/dept&pk=dept_code&sk=dept_name&fields=id,dept_code,dept_name";
    //cmbGrid($name1,$name2,$caption,$url,$field);
    cmbGrid($name1, $name2, $caption, $url, $field, $width1, $width2);
}

function cmdDepartUnit($name1, $name2, $caption, $width1 = null, $width2 = null) {
    $field = array
        (
        array("dunit_code", "Code", 100),
        array("dunit_name", "Name", 220),
    );
    $url = "services/runCRUD.php?func=read&lookup=mst/dept_unt&pk=dunit_code&sk=dunit_name&fields=id,dunit_code,dunit_name";
    //cmbGrid($name1,$name2,$caption,$url,$field);
    cmbGrid($name1, $name2, $caption, $url, $field, $width1, $width2);
}

function cmdaccSales($name, $caption, $key = null, $key2 = null, $width2 = null) {
    //$url = "services/runCRUD.php?func=datasource&lookup=mst/veh_srep&pk=srep_code&sk=srep_name&order=srep_name";
    $url = "services/runCRUD.php?func=read&lookup=mst/acc_srep&pk=srep_code&sk=srep_name&order=srep_name&fields=id,srep_code,srep_name";
    //remotecombobox($name,$caption,220,$url,'srep_code','srep_name');
    $field = array
        (
        array("srep_code", "Code", 100),
        array("srep_name", "Name", 220),
    );

    cmbGridSingle2($name, $caption, $url, $field, 250, $key, $key2, $width2);
}

function cmdAccSupp($name1, $name2, $caption, $width1 = null, $width2 = null) {
    $url = "services/runCRUD.php?func=datasource&lookup=mst/acc_supp&pk=supp_code&sk=supp_name&order=supp_code";
    //remotecombobox($name,$caption,180,$url,'wrhs_code','wrhs_name');


    $field = array
        (
        array("supp_code", "Code", 100),
        array("supp_name", "Name", 220),
    );
    cmbGrid($name1, $name2, $caption, $url, $field, $width1, $width2);
}

function cmdAccCust($name1, $name2, $caption, $width1 = null, $width2 = null) {
    $url = "services/runCRUD.php?func=datasource&lookup=mst/acc_cust&pk=cust_code&sk=cust_name&order=cust_code";
    //remotecombobox($name,$caption,180,$url,'wrhs_code','wrhs_name');


    $field = array
        (
        array("cust_code", "Code", 100),
        array("cust_name", "Name", 220),
    );
    cmbGrid($name1, $name2, $caption, $url, $field, $width1, $width2);
}

function cmdAccSalesPerson($name1, $name2, $caption, $width1 = null, $width2 = null) {
    $url = "services/runCRUD.php?func=datasource&lookup=mst/acc_srep&pk=srep_code&sk=srep_name&order=srep_code";

    $field = array
        (
        array("srep_code", "Code", 100),
        array("srep_name", "Name", 220),
    );

    cmbGrid($name1, $name2, $caption, $url, $field, $width1, $width2);
}

function cmdAccPrep($name1, $name2, $caption, $width1 = null, $width2 = null, $cmb = null, $key = null, $key2 = null) {
    $url = "services/runCRUD.php?func=datasource&lookup=mst/acc_prep&pk=prep_code&sk=prep_name&order=prep_code";
    //remotecombobox($name,$caption,180,$url,'wrhs_code','wrhs_name');


    $field = array
        (
        array("prep_code", "Code", 100),
        array("prep_name", "Name", 220),
    );

    if ($cmb == 'single') {
        cmbGridSingle($name1, $caption, $url, $field, $width1, $key, $key2);
    } else {
        cmbGrid($name1, $name2, $caption, $url, $field, $width1, $width2);
    }
}

function cmdAccOrep($name1, $name2, $caption, $width1 = null, $width2 = null) {
    $url = "services/runCRUD.php?func=datasource&lookup=mst/acc_orep&pk=oprep_code&sk=oprep_name&order=oprep_code";
    //remotecombobox($name,$caption,180,$url,'wrhs_code','wrhs_name');


    $field = array
        (
        array("oprep_code", "Code", 100),
        array("oprep_name", "Name", 220),
    );
    cmbGrid($name1, $name2, $caption, $url, $field, $width1, $width2);
}

function cmdsingleAccOrep($name, $caption) {
    $url = "services/runCRUD.php?func=datasource&lookup=mst/acc_orep&pk=oprep_code&sk=oprep_name&order=oprep_code";
    //remotecombobox($name,$caption,180,$url,'wrhs_code','wrhs_name');


    $field = array
        (
        array("oprep_code", "Code", 100),
        array("oprep_name", "Name", 220),
    );


    cmbGridSingle2($name, $caption, $url, $field, 300);
}

function cmdRAddress($name, $caption, $key = null, $key2 = null, $width = null) {
    $url = "services/runCRUD.php?func=datasource&lookup=mst/prt_radd&pk=raddr_code&sk=raddr_name&order=raddr_code";
    //remotecombobox($name,$caption,100,$url,'cust_code','cust_name');
    $field = array
        (
        array("raddr_code", "Kode Alamat", 100),
        array("oname", "Perusahaan", 150),
        array("raddr_name", "Keterangan", 220),
    );
    cmbGridSingle($name, $caption, $url, $field, $width, $key, $key2);
}

function cmdCurr($name, $caption, $width = null) {
    $url = "services/runCRUD.php?func=datasource&lookup=mst/curr&pk=curr_code&sk=curr_name&order=curr_code";
    //remotecombobox($name,$caption,100,$url,'cust_code','cust_name');
    $field = array
        (
        array("curr_code", "Code", 100),
        array("curr_name", "Name", 150)
    );
    cmbGridSingle($name, $caption, $url, $field, $width);
}

function cmdMaccs($name, $caption, $key = null, $key2 = null, $width = null) {
    $url = "services/runCRUD.php?func=datasource&lookup=mst/maccs&pk=part_code&sk=part_name&order=part_code";
    //remotecombobox($name,$caption,100,$url,'cust_code','cust_name');
    $field = array
        (
        array("part_code", "Item Code", 120),
        array("part_name", "Item Name", 150),
        array('wrhs_code', 'Warehouse', 100),
        array('location', 'Location', 100),
        array("unit", "Unit", 80),
        array("qty", "Qty", 250, 'formatNumber', 'right'),
        array('qty_pick', 'Qty Pick', 50, 'formatNumber', 'right'),
        array('qty_order', 'Qty Order', 50, 'formatNumber', 'right'),
        array("min_qty", "Min Qty", 50, 'formatNumber', 'right'),
        array("max_qty", "Max Qty", 50, 'formatNumber', 'right'),
        array('pur_price', 'Purchase Price', 120, 'formatNumber', 'right'),
        array('pur_disc', 'Sale Disc.', 120, 'formatNumber', 'right'),
    );
    cmbGridSingle($name, $caption, $url, $field, $width, $key, $key2);
}

function cmdAccPOOD($name, $caption, $key = null, $key2 = null, $width = null) {
    $url = "services/runCRUD.php?func=datasource&lookup=mst/acc_pood&pk=part_code&sk=part_name&order=part_code";
    //remotecombobox($name,$caption,100,$url,'cust_code','cust_name');
    $field = array
        (
        array("part_code", "Code", 120),
        array("part_name", "Name", 250)
    );
    cmbGridSingle($name, $caption, $url, $field, $width, $key, $key2);
}

function cmdMstMover($name1, $name2, $caption, $width1 = null, $width2 = null) {
    $url = "services/runCRUD.php?func=datasource&lookup=mst/prt_movr&pk=mvrep_code&sk=mvrep_name&order=mvrep_code";

    $field = array
        (
        array("mvrep_code", "Code", 100),
        array("mvrep_name", "Name", 220),
    );
    cmbGrid($name1, $name2, $caption, $url, $field, $width1, $width2);
}

function cmdprtWrhs($name, $caption, $width = null) {
    $url = "services/runCRUD.php?func=datasource&lookup=mst/prt_wrhs&pk=wrhs_code&sk=wrhs_name&order=wrhs_code";
    //remotecombobox($name,$caption,180,$url,'wrhs_code','wrhs_name');
    $field = array
        (
        array("wrhs_code", "Code", 120),
        array("wrhs_name", "Name", 220),
    );
    cmbGridSingle($name, $caption, $url, $field, $width);
}

function cmdInsurance($name1, $name2, $caption, $width1 = null, $width2 = null) {
    $url = "services/runCRUD.php?func=datasource&lookup=mst/insurance&pk=insr_code&sk=insr_name&order=insr_code";

    $field = array
        (
        array("insr_code", "Code", 100),
        array("insr_name", "Name", 220),
    );
    cmbGrid($name1, $name2, $caption, $url, $field, $width1, $width2);
}

function cmdAgent($name1, $name2, $caption, $width1 = null, $width2 = null) {
    $url = "services/runCRUD.php?func=datasource&lookup=mst/agent&pk=agent_code&sk=agent_name&order=agent_code";

    $field = array
        (
        array("agent_code", "Code", 100),
        array("agent_name", "Name", 220),
    );
    cmbGrid($name1, $name2, $caption, $url, $field, $width1, $width2);
}

function cmdAccSuppSet($name1, $name2, $caption) {
    $url = "services/runCRUD.php?func=read&lookup=mst/acc_supp&pk=supp_code&sk=supp_name&order=supp_name";
    $field = array
        (
        array("supp_code", "Code", 100),
        array("supp_name", "Name", 220),
    );
    cmbGrid($name1, $name2, $caption, $url, $field);
}

function cmdUsr($name, $caption, $width = null) {
    $url = "services/runCRUD.php?func=datasource&lookup=stg/usr&fields=userrole,username";
    $field = array
        (
        array("userrole", "Userrole", 100),
        array("username", "Username", 250),
    );
    cmbGridSingle($name, $caption, $url, $field, $width, 1, 1);
}

function cmdInvSeq($name, $caption, $width = null) {
    $url = "services/runCRUD.php?func=datasource&lookup=stg/inv_seq&pk=inv_type&sk=remark&order=remark";
    //remotecombobox($name,$caption,100,$url,'city_code','city_name');
    $field = array
        (
        array("inv_type", "Code", 100),
        array("remark", "Name", 220),
    );
    if ($width == null) {
        $width = 170;
    }
    cmbGridSingle($name, $caption, $url, $field, $width, 1, 1);
}

function cmdWrhsVehAcc($name, $caption, $width = null) {
    $url = "services/runCRUD.php?func=datasource&lookup=mst/mst_wrhs_all&pk=wrhs_code&sk=wrhs_name&order=wrhs_code";
    //remotecombobox($name,$caption,180,$url,'wrhs_code','wrhs_name');
    $field = array
        (
        array("wrhs_code", "Code", 120),
        array("wrhs_name", "Name", 220),
    );

    cmbGridSingle($name, $caption, $url, $field, $width);
}

function cmdStdoptSet($name1, $name2, $caption, $width1 = null, $width2 = null) {//n
    $url = "services/runCRUD.php?func=datasource&lookup=mst/veh_stdopt&pk=stdoptcode&sk=stdoptname&order=stdoptname";
    //remotecombobox($name,$caption,100,$url,'brnd_code','brnd_name');
    $field = array
        (
        array("stdoptcode", "Code", 100),
        array("stdoptname", "Name", 220),
    );
    cmbGrid($name1, $name2, $caption, $url, $field, $width1, $width2); //n
}

function cmdTrx_code($name1, $name2, $caption, $width1 = null, $width2 = null) {//n
    $url = "services/runCRUD.php?func=datasource&lookup=stg/trx_code&pk=trx_code&sk=trx_desc&order=trx_code";
    //remotecombobox($name,$caption,100,$url,'brnd_code','brnd_name');
    $field = array
        (
        array("trx_code", "Code", 100),
        array("trx_desc", "Name", 220),
    );
    cmbGrid($name1, $name2, $caption, $url, $field, $width1, $width2); //n

}


function cmdTrx_scode($name, $caption, $width = null) {//n
    $url = "services/runCRUD.php?func=datasource&lookup=stg/trx_scode&pk=trx_scode&sk=trx_sdesc&order=trx_scode";
    $field = array
        (
        array("trx_scode", "Code", 120),
        array("trx_sdesc", "Name", 220),
    );

    cmbGridSingle($name, $caption, $url, $field, $width,0,0);
}

function cmdDealerSet($name1, $name2, $caption, $width1 = null, $width2 = null) {
    $url = "services/runCRUD.php?func=read&lookup=mst/veh_dealer&pk=cust_code&sk=cust_name&order=cust_name";
    $field = array
        (
        array("cust_code", "Code", 100),
        array("cust_name", "Name", 200),
        array("oaddr", "Address", 220),
    );
    cmbGrid($name1, $name2, $caption, $url, $field, $width1, $width2);
}

function cmdSPVLevel($name, $caption, $width = null) {
    $url = "services/runCRUD.php?func=datasource&lookup=mst/sspv_lev&pk=spvlv_code&sk=spvlv_name&order=spvlv_code";
    //remotecombobox($name,$caption,100,$url,'slev_code','slev_name');
    $field = array
        (
        array("spvlv_code", "Code", 100),
        array("spvlv_name", "Name", 220),
    );
    cmbGridSingle($name, $caption, $url, $field, $width);
}
?>

