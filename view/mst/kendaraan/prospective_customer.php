<div style=" margin: 10px;" id="form_content">
    <form id="form_validation" method="post" >
        <input type="hidden" name="id"  id="id">
        <input type="hidden" name="table"  id="table" value="<?php echo 'veh_pcus'; ?>">

        <table class="main-form">

            <td valign="top">
                <table cellpadding="3" class="table" >
                    <?php
                    textbox('cust_code', 'Kode', 90, 10);
                    textbox('cust_name', 'Nama', 250, 65);
                    textbox('cust_alias', 'Alias', 250, 30);
                    ?>
                    <tr><td class="col100"></td></tr>
                </table>
            </td>
            <td valign="top">
                <table>
                    <tr>
                        <td valign="top" class="checkboxValign"><?php getCaption("Jenis Kelamin"); ?> </td>
                        <td valign="top" class="td-ro checkboxValign">:</td>
                        <td  width="100" class="checkboxBorder">   
                            <table>
                                <tr><td> <a href="#" class="checkbox" name="sex_1"><input type="radio" id="sex_1" class="sex_1"  name="sex" value="1"> <?php getCaption("Pria"); ?></a></td></tr>
                                <tr><td><a href="#" class="checkbox" name="sex_2"><input type="radio" id="sex_2" class="sex_2" name="sex" value="2"> <?php getCaption("Wanita"); ?></a></td></tr>
                                <tr><td><a href="#" class="checkbox" name="sex_3"><input type="radio" id="sex_3" class="sex_3" name="sex" value="3"> <?php getCaption("Perusahaan"); ?></a></td></tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
            <td valign="top">
                <table>
                    <tr>
                        <td valign="top" class="checkboxValign"><?php getCaption("Jenis Pelanggan"); ?> </td>
                        <td valign="top" class="td-ro checkboxValign">:</td>
                        <td  width="160" class="checkboxBorder">   
                            <table>
                                <tr><td><a href="#" class="checkbox" name="cust_type_1"><input type="radio" id="cust_type_1" class="cust_type_1" name="cust_type" value="1"> End User</a></td></tr>
                                <tr><td><a href="#" class="checkbox" name="cust_type_2"><input type="radio" id="cust_type_2" class="cust_type_2" name="cust_type" value="2"> Dealer/Reseller</a></td></tr>
                                <tr><td><a href="#" class="checkbox" name="cust_type_3"><input type="radio" id="cust_type_3" class="cust_type_3" name="cust_type" value="3"> Government/BUMN</a></td></tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
            <td valign="top">
                <table>
                    <tr>
                        <td valign="top" class="checkboxValign"><?php getCaption("Surat Ke"); ?> </td>
                        <td valign="top" class="td-ro checkboxValign">:</td>
                        <td  width="130" class="checkboxBorder">   
                            <table>
                                <tr><td><a href="#" class="checkbox" name="postaddr_1"><input type="radio" id="postaddr_1" class="postaddr_1"  name="postaddr" value="1"> <?php getCaption("Kantor"); ?></a></td></tr>
                                <tr><td><a href="#" class="checkbox" name="postaddr_2"><input type="radio" id="postaddr_2" class="postaddr_2" name="postaddr" value="2"> <?php getCaption("Rumah"); ?></a></td></tr>
                                <tr><td><a href="#" class="checkbox" name="postaddr_3"><input type="radio" id="postaddr_3" class="postaddr_3" name="postaddr" value="3"> <?php getCaption("Tidak dikirim"); ?></a></td></tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </table>

        <div class="easyui-tabs" id="tabscoi" >
            <div title="Company" class="tab-pane main-tab" id="Company">
                <table>
                    <tr>
                        <td valign="top" width="390">
                            <table>
                                <?php
                                textbox('oname', 'Nama', 200, 20);
                                textarea('oaddr', 'Alamat', 200, 120);
                                cmdArea('oarea', 'Wilayah', 170);
                                cmdCity('ocity', 'Kota', 170);
                                zipbox('ozipcode', 'Kode Pos', 80, 5);
                                cmdCountry('ocountry', 'Negara', 170);
                                ?>
                                <tr><td colspan="3"></td></tr>
                                <tr><td colspan="3"></td></tr>
                                <?php
                                phonebox('ophone', 'Telepon', 200);
                                //textbox('ophone', 'Telepon', 200, 35);
                                phonebox('ofax', 'Fax', 200, 35);
                                ?>
                                <tr><td class="col100"></td></tr>
                            </table>
                        </td>

                        <td valign="top">
                            <table>
                                <?php
                                phonebox('ohp', 'HP Pribadi', 180);
                                textboxmail('oemail', 'Email', 180, 40);
                                ?>
                                <tr><td colspan="3"></td></tr>
                                <tr><td colspan="3"></td></tr>
                                <?php
                                textbox('ocp1_title', 'Jabatan', 180, 20);
                                phonebox('ocp1_name', 'Hubungi', 180);
                                ?>
                                <tr><td colspan="3"></td></tr>
                                <tr><td colspan="3"></td></tr>
                                <?php
                                textbox('ocp2_title', 'Jabatan', 180, 20);
                                phonebox('ocp2_name', 'Hubungi', 180);
                                ?>
                                <tr><td colspan="3"></td></tr>
                                <tr><td colspan="3"></td></tr>
                                <?php
                                cmdBusType('bus_fld', 'Jenis Usaha', 170);
                                cmdBusProd('bus_item', 'Produk Usaha', 170);
                                ?>	
                                <tr><td colspan="3"></td></tr>
                                <tr><td colspan="3"></td></tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>

            <div title="Home" class="tab-pane main-tab" id="Company" >
                <table>						
                    <td valign="top" width="390">
                        <table>
                            <?php
                            textarea('haddr', 'Alamat', 200, 120);
                            cmdArea('harea', 'Wilayah');
                            cmdCity('hcity', 'Kota');
                            zipbox('hzipcode', 'Kode Pos', 80, 5);
                            cmdCountry('hcountry', 'Negara');
                            ?>
                            <tr><td colspan="3"></td></tr>
                            <tr><td colspan="3"></td></tr>
                            <?php
                            phonebox('hphone', 'Telepon', 200);
                            textbox('hfax', 'Fax', 200, 35);
                            ?>
                            <tr><td class="col100"></td></tr>
                        </table>
                    </td>
                    <td valign="top">
                        <table>
                            <?php
                            phonebox('hp', 'HP Pribadi', 150);
                            textboxmail('hemail', 'Email', 250, 40);
                            cmdCity('pob', 'Tempat Lahir');
                            datebox('dob', 'Tanggal Lahir');
                            cmdRelig('relig_code', 'Agama');
                            cmdJob('job_code', 'Pekerjaan');
                            ?>
                            <tr><td colspan="3"></td></tr>
                            <tr><td colspan="3"></td></tr>
                            <?php
                            textbox('ktp_no', 'No KTP', 150, 35);
                            textbox('drv_lic_no', 'No SIM', 150, 35);
                            ?>	
                        </table>
                    </td>						
                </table>
            </div>

            <div title="Family" class="tab-pane main-tab" id="Family">
                <table>
                    <tr>
                        <td valign="top">
                            <table>
                                <?php
                                textbox('spousename', 'Nama Pasangan', 200, 40);
                                datebox('wed_anniv', 'Ulang Tahun Pernikahan');
                                ?>
                                <tr><td class="col150"></td></tr>
                            </table>
                        </td>

                        <td valign="top">	
                            <table>
                                <?php
                                datebox('spouse_dob', 'Tanggal Lahir', 120);
                                ?>                        		
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top">
                            <table>
                                <?php
                                textbox('child1name', 'Nama Anak Ke. 1', 200, 30);
                                textbox('child2name', 'Nama Anak Ke. 2', 200, 30);
                                ?>
                                <tr><td class="col150"></td></tr>
                            </table>
                        </td>
                        <td valign="top">
                            <table>
                                <?php
                                datebox('child1_dob', 'Tanggal Lahir', 120);
                                datebox('child2_dob', 'Tanggal Lahir', 120);
                                ?>	
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
            <div title="Personal" class="tab-pane main-tab" id="Company" >
                <table style="width: 800px;">
                    <tr>
                        <td valign="top">
                            <table>
                                <tr><td colspan="3" style="text-align: right !important;font-weight: bold;"><?php getCaption("Uang Muka"); ?></td></tr>

                                <?php
                                numberbox('dp_beg', 'Saldo Awal', 200, 120);
                                numberbox('dp_db', 'Debit', 200, 120);
                                numberbox('dp_cr', 'Kredit', 200, 120);
                                numberbox('dp_end', 'Saldo Akhir', 200, 120);
                                ?>
                                <tr><td colspan="3"><br /></td></tr>
                                <tr><td colspan="3"><br /></td></tr>
                            </table>
                        </td>
                        <td valign="top">
                            <table>
                                <tr><td colspan="3" style="text-align: right !important;font-weight: bold;"><?php getCaption("Piutang"); ?></td></tr>
                                <?php
                                numberbox('ar_beg', 'Saldo Awal', 200, 120);
                                numberbox('ar_db', 'Debit', 200, 120);
                                numberbox('ar_cr', 'Kredit', 200, 120);
                                numberbox('ar_end', 'Saldo Akhir', 200, 120);
                                ?>
                                <tr><td colspan="3"><br /></td></tr>
                                <?php //numberbox('ar_limit', 'Batas Kredit', 200, 120);  ?>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>

            <div title="Tax" class="tab-pane main-tab" id="Tax">
                <table>
                    <td>
                        <table>
                            <?php
                            textbox('onpwp', 'NPWP', 200, 20);
                            textbox('opkp', 'PKP / NPPKP', 200, 20);
                            datebox('oest_date', 'Tanggal Pengukuhan');
                            //cmdVat('ovat', 'PPN');
                            ?>
                            <tr>
                                <td><?php getCaption("PPN"); ?></td>
                                <td>:</td>
                                <td><input type="checkbox" id="ovat" name="ovat" value="1" disabled="disabled" style="margin-left: -0.5px;margin-top: 5px;"></td>
                            </tr>
                        </table>
                    </td>
                </table>
            </div>

        </div>
        <div class="main-nav">
            <table width="100%">
                <tr>
                    <td> <?php navigation_ci(); ?></td>
                    <td align="right"><img src="<?php echo $loc_jui . "themes/icons/version.png" ?>" id="version"></td>
                </tr>
            </table>          
        </div>
    </form>	
</div>

<div id="SearchOption" style="display:none;">  
    <form id="form_validation2" method="post" >    
        <div id="optionSPK" style="padding:10px;">
            <span><?php getCaption("Kode Pelanggan"); ?>:</span>
            <input id="cust_code2" name="cust_code">
            <span><?php getCaption("Nama Pelanggan"); ?>:</span>
            <input id="cust_name2" name="cust_name" >
            <a href="#" class="easyui-linkbutton" onclick="doSearch()" iconCls="icon-search">Search</a>
            <button type="button"  title="<?php getCaption("Ok"); ?>" class="easyui-linkbutton easyui-tooltip btn btn-default" data-options="iconCls:'icon-ok'" onclick="getSearchselect()" >Ok </button>
            <button type="button" class="easyui-linkbutton easyui-tooltip btn btn-default" onclick="close_search();">Cancel</button>

        </div>

    </form>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        read_show('');
         version('01.04-17');
    });

    $("#tabscoi").tabs();

    var table = 'veh_pcus';
    var pk = 'cust_code';
    var sk = 'cust_name';

    var pk_name = '<?php getCaption("Kode Pelanggan"); ?>';
    var sk_name = '<?php getCaption("Nama Pelanggan"); ?>';

    function showAlert(title, msg) {
        $.messager.show({
            title: title,
            msg: msg,
            //showType:'show',
            timeout: 1000,
            showType: 'fade',
            style: {
                right: '',
                bottom: ''
            }
        });
    }

    function read_show(nav) { //alert('hello')
        var id = $("#id").val();
        cmdcondAwal();
        formDisabled();

        $.post(site_url + 'master/vehicle/read', {table: table, nav: nav, id: id}, function (json) { //alert(json)

            $('#form_validation input:text').val('');
            $('#form_validation textarea').val('');
            $('#form_validation .easyui-combogrid').combogrid('setValue', '');
            $("#form_validation input:radio").prop("checked", false);
            $(".easyui-datebox").datebox('setValue', '');

            if (json !== '[]') {

                var rowData = $.parseJSON(json);

                $('#form_validation .sex_' + rowData.sex).prop("checked", true);
                $('#form_validation .postaddr_' + rowData.postaddr).prop("checked", true);
                $('#form_validation .cust_type_' + rowData.cust_type).prop("checked", true);

                if (rowData.ovat == 1) {
                    $('#form_validation #ovat').prop("checked", true);
                } else {
                    $('#form_validation #ovat').prop("checked", false);
                }


                $.each(rowData, function (i, v) {
                    $("#form_validation #" + i).val(v);

                    if (i == 'tx_area' || i == 'tx_city' || i == 'tx_country' || i == 'oarea' || i == 'ocity' || i == 'ocountry' || i == 'bus_fld' || i == 'bus_item' || i == 'harea' || i == 'hcity' || i == 'hcountry' || i == 'pob' || i == 'relig_code' || i == 'job_code') {
                        $("#form_validation #" + i).combogrid('setValue', v);

                    }
                    if (i == 'dp_beg' || i == 'dp_db' || i == 'dp_cr' || i == 'dp_end' || i == 'ar_beg' || i == 'ar_db' || i == 'ar_cr' || i == 'ar_end' || i == 'ar_limit') {
                        $("#form_validation #" + i).numberbox('setValue', v);
                    }
                    if (i == 'oest_date' || i == 'dob' || i == 'wed_anniv' || i == 'spouse_dob' || i == 'child1_dob' || i == 'child2_dob') {
                        if (v !== '0000-00-00') {
                            var vdate = dateSplit(v);

                            $("#" + i).datebox('setValue', vdate);
                        }
                    }


                });

            }else {
                cmdcondAwal();
                cmdEmptyData();
            }

            $('.loader').hide();
        });
    }

    function doSearch() {
        $("#tableSearch").datagrid('load', {
            field1: $('#cust_code2').val(),
            field2: $('#cust_name2').val()
        });
    }
    function getSearchselect() {
        var row = $("#tableSearch").datagrid('getSelected');

        if (row) {
            $("#form_validation #id").val(row.id);
            $('#windowSearch').window('close');
            $("#actionSearch").empty()
            $("#SearchOption").hide();
            read_show('');

        }
    }
    function close_search() {
        $('#windowSearch').window('close');
        $("#actionSearch").empty()
        $("#SearchOption").hide();
    }

    function company_copy() {
        var name = $('#oname').val();
        var addr = $('#oaddr').val();
        var area = $('#oarea').val();
        var city = $('#ocity').val();
        var zipcode = $('#ozipcode').val();
        var country = $('#ocountry').val();


        $('#tx_name').val(name);
        $('#tx_addr').val(addr);
        $('#tx_area').val(area);
        $('#tx_city').val(city);
        $('#tx_zipcode').val(zipcode);
        $('#tx_country').val(country);
    }

    function formDisabled() {
        $('#form_validation :input').attr('disabled', true);
        $('#form_validation .easyui-combogrid').combogrid('disable');
        $('#form_validation .easyui-combobox').combobox({disabled: true});
        $('#form_validation .combo-text').removeClass('validatebox-text');
        $('#form_validation .combo-text').removeClass('validatebox-invalid');
        $(".easyui-datebox").datebox('disable');
        cmdcondAwal();

    }

    function saveData() {
        $('.loader').show();
        var url = site_url + 'master/vehicle/save_vehicle';
        $('#form_validation :input').attr('disabled', false);
        $('#form_validation').form('submit', {
            url: url,
            onSubmit: function () {
                return $(this).form('validate');
            },
            success: function (data) {

                var obj = JSON.parse(data);
                if (obj.success == true) {
                    showAlert("Information", obj.message);
                    cmdcondAwal();
                    read_show('');
                    // $('#dt').datagrid('reload');
                } else
                {
                    $('.loader').hide();
                    showAlert("Error while saving", '<font color="red">' + obj.message + '</font>');
                    condReady();

                }
            }
        });
    }

    function cmdcondAwal() {
        $('#cmdFirst').removeAttr('disabled');
        $('#cmdPrev').removeAttr('disabled');
        $('#cmdNext').removeAttr('disabled');
        $('#cmdLast').removeAttr('disabled');
        $('#cmdSave').attr('disabled', true);
        $('#cmdCancel').attr('disabled', true);
        $('#cmdAdd').removeAttr('disabled');
        $('#cmdEdit').removeAttr('disabled');
        $('#cmdDelete').removeAttr('disabled');
        $('#cmdSearch').removeAttr('disabled');

        $('.cmdFirst').linkbutton('enable');
        $('.cmdPrev').linkbutton('enable');
        $('.cmdNext').linkbutton('enable');
        $('.cmdLast').linkbutton('enable');
        $('.cmdSave').linkbutton('disable');
        $('.cmdCancel').linkbutton('disable');
        $('.cmdAdd').linkbutton('enable');
        $('.cmdEdit').linkbutton('enable');
        $('.cmdDelete').linkbutton('enable');
        $('.cmdSearch').linkbutton('enable');

        $('#cmdBrowse').removeAttr('disabled');
        $("#cmdBrowse").linkbutton('enable');

    }

    function condReady() {
        $('#form_validation :input').attr('disabled', false);
        //$("#supp_code").attr('disabled', true);
        $('#form_validation .easyui-combogrid').combogrid('enable');
        $("#form_validation .easyui-datebox").datebox('enable');

        $("#dp_db").attr('disabled', true);
        $("#dp_cr").attr('disabled', true);
        $("#dp_end").attr('disabled', true);

        $("#ar_db").attr('disabled', true);
        $("#ar_cr").attr('disabled', true);
        $("#ar_end").attr('disabled', true);

        checkboxClick();
        cmdcondReady();

    }

    function cmdcondReady() {
        //$("#cmdSave").show();
        //$("#cmdCancel").show();
        $('#cmdFirst').attr('disabled', true);
        $('#cmdPrev').attr('disabled', true);
        $('#cmdNext').attr('disabled', true);
        $('#cmdLast').attr('disabled', true);

        $('#cmdSave').removeAttr('disabled');
        $('#cmdCancel').removeAttr('disabled');
        //$("#cmdSave").removeAttr('disabled');
        //$("#cmdCancel").removeAttr('disabled');
        $('#cmdAdd').attr('disabled', true);
        $('#cmdEdit').attr('disabled', true);
        $('#cmdDelete').attr('disabled', true);
        $('#cmdSearch').attr('disabled', true);

        $('.cmdFirst').linkbutton('disable');
        $('.cmdPrev').linkbutton('disable');
        $('.cmdNext').linkbutton('disable');
        $('.cmdLast').linkbutton('disable');

        $('.cmdSave').linkbutton('enable');
        $('.cmdCancel').linkbutton('enable');

        $('.cmdAdd').linkbutton('disable');
        $('.cmdEdit').linkbutton('disable');
        $('.cmdDelete').linkbutton('disable');
        $('.cmdSearch').linkbutton('disable');

        $(".buttonComp").attr('disabled', false);
        $(".buttonComp").linkbutton('enable');
    }

    function condAdd() {
        $('#form_validation .easyui-combogrid').combogrid('setValue', '');
        //$(".easyui-datebox").datebox('enable');
        // $('.easyui-numberbox').numberbox('enable');
        $('#form_validation .easyui-combobox').combobox('setValue', '');
        $('#form_validation #id').val('');
        $('#form_validation input:text').val('');
        $("#table").val(table);
        $('#form_validation textarea').val("");
        $("#form_validation input:radio").prop("checked", false);
        // $('#form_validation #ovat').prop("checked", false);
        condReady();
        $("#form_validation #table").val(table);

        $('#form_validation #supp_code').focus();
        $("#form_validation #vat").attr('disabled', true);
        $('#form_validation #ovat').prop("checked", true);
        $('.easyui-numberbox').numberbox('setValue', '');
    }
    function condEdit() {
        condReady();
    }
    function condDelete() {
        var id = $("#form_validation #id").val();
        var table = $("#form_validation #table").val();

        $.messager.confirm('Warning', 'Are you sure delete selected data ?', function (r) {
            if (r) {

                var url = site_url + 'master/vehicle/delete';
                $('.loader').show();
                $.post(url, {table: table, id: id}, function (data) {
                    obj = JSON.parse(data);
                    if (obj.success == true) {
                        $("#form_validation #id").val('');
                        showAlert("Information", obj.message);
                        cmdcondAwal();
                        read_show('');
                    } else
                    {
                        $('.loader').hide();
                        showAlert("Error while delete", '<font color="red">' + obj.message + '</font>');
                    }
                });

            }
        });
    }
    function condCancel() {

        cmdcondAwal();
        read_show('');

        $(".formError").remove();
    }

</script>

<style>
    .table td{border:0px !important;padding:2px !important;}
</style>

