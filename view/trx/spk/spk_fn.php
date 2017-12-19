<script type="text/javascript">
    $.messager.defaults.ok = 'Yes';
    $.messager.defaults.cancel = 'No';

    var table = 'veh_spk';
    var pk = 'so_no';
    var sk = 'cust_name';


    var form = $('#form_validation');
    var save_url = site_url + 'transaction/spk/save';
    var unclose = '';
    var close = '';
    var divtableId = $("#tableId");


    /*form pekerjaan*/
    var table2 = 'veh_spkd';

    var ttables = $('#dt_jasa');
    var form2 = $("#form_validation2");

    var ttable = $('#dt_jasa2');
    var divtableId2 = $("#tableId2");

    var price_st = true;

    var spklisturl = site_url + '<?php echo 'builder/grid_spkreg/' . encrypt_decrypt('encrypt', 'veh_spkreg'); ?>/?grid=true';


    function price_vehicle(val, disc) {
        if (val == '') {
            val = 0;
        }
        if (disc == '') {
            disc = 0;
        }

        if (parseInt(disc) > parseInt(val)) {
            $("#unit_disc").numberbox('setValue', '');
            $("#tot_price").numberbox('setValue', val);
            showAlert("Message", '<font color="red">Discount can not exceeds Unit Price</font>');
            return false;
        }

        var tot = $("#qty").val() * val;
        var tot = tot - disc;

        $("#tot_price").numberbox('setValue', tot);
        $("#unit_price2").numberbox('setValue', tot);
    }

    $("#unit_disc").keyup(function () {
        var val = parseCurrency($("#unit_price").val());
        var disc = parseCurrency($(this).val());

        price_vehicle(val, disc);
    });

    $("#unit_price").keyup(function () {
        var val = parseCurrency($(this).val());
        var disc = parseCurrency($("#unit_disc").val());

        price_vehicle(val, disc);
    });


    $('#cust_name').combogrid({
        onSelect: function (index, row) {

            if (row.postaddr == 1) {
                $("#cust_addr").val(row.oaddr);
                $("#cust_area").combogrid('setValue', row.oarea);
                $("#cust_city").combogrid('setValue', row.ocity);
                $("#cust_cntry").combogrid('setValue', row.ocountry);
                $("#cust_zipc").val(row.ozipcode);
                $("#cust_phone").val(row.ophone);
                $("#cust_hp").val(row.ohp);
                $("#cust_fax").val(row.ofax);
                $("#cust_ktpno").val(row.ktp_no); 
                $("#cust_rktpno").val(row.ktp_no);
            }
            else if (row.postaddr == 2) {
                $("#cust_addr").val(row.haddr);
                $("#cust_area").combogrid('setValue', row.harea);
                $("#cust_city").combogrid('setValue', row.hcity);
                $("#cust_cntry").combogrid('setValue', row.hcountry);
                $("#cust_zipc").val(row.hzipcode);
                $("#cust_phone").val(row.hphone);
                $("#cust_hp").val(row.hp);
                $("#cust_fax").val(row.hfax);
                $("#cust_ktpno").val(row.ktp_no); 
                $("#cust_rktpno").val(row.ktp_no);
            }

            $("#cust_code").val(row.cust_code);
            $("#cust_npwp").val(row.tx_npwp);
            $("#cust_nppkp").val(row.tx_nppkp);

            $('#cust_type').prop("checked", false);
            $('#cust_sex').prop("checked", false);

            $('.cust_type_' + row.cust_type).prop("checked", true);
            $('.cust_sex_' + row.sex).prop("checked", true);



            if ($("#notif").val() == 'new') {
                $.messager.confirm('STNK Data', 'Do you want to use this customer\'s name and address in STNK?', function (r) {
                    if (r) {

                        if (row.postaddr == 1) {
                            // Pelanggan
                            $("#cust_rname").val(row.cust_name);
                            $("#cust_raddr").val(row.oaddr);
                            $("#cust_rarea").combogrid('setValue', row.oarea);
                            $("#cust_rcntr").combogrid('setValue', row.ocountry);
                            $("#cust_rcity").combogrid('setValue', row.ocity);
                            $("#cust_rzipc").val(row.ozipcode);
                            $("#cust_rphon").val(row.ophone);

                        }
                        else if (row.postaddr == 2) {
                            // Pelanggan
                            $("#cust_rname").val(row.cust_name);
                            $("#cust_raddr").val(row.haddr);
                            $("#cust_rarea").combogrid('setValue', row.harea);
                            $("#cust_rcntr").combogrid('setValue', row.hcountry);
                            $("#cust_rcity").combogrid('setValue', row.hcity);
                            $("#cust_rzipc").val(row.hzipcode);
                            $("#cust_rphon").val(row.hphone);

                        }


                        $('#cust_rsex').prop("checked", false);
                        $('.cust_rsex_' + row.sex).prop("checked", true);
                    }
                });
            }

        }
    });
    $("#srep_name").combogrid({
        onSelect: function (index, row) {
            $("#srep_code").val(row.srep_code);
            $("#srep_lev").val(row.srep_lev);
            $("#sspv_lev").val(row.sspv_lev);
            $("#sspv_code").val(row.sspv_code);
            $("#sspv_name").val(row.sspv_name);

        }
    });
    $("#form #srep_name").combogrid({
        onSelect: function (index, row) {
            $("#form #srep_code").val(row.srep_code);

        }
    });
    $('#veh_name').combogrid({
        onSelect: function (index, row) {
            $("#veh_code").val(row.veh_code);
            $("#veh_brand").val(row.veh_brand);

            $("#veh_transm").val(row.veh_transm);
            $("#veh_year").val(row.veh_year);
            //$("#chassis").val(row.chas_pref);
            // $("#engine").val(row.eng_pref);
            $("#veh_type").val(row.veh_type);
            $("#veh_model").val(row.veh_model);

            $("#veh_brand").attr('disabled', true);
            $("#veh_code").attr('disabled', true);

            $("#veh_transm").attr('disabled', true);
            $("#veh_year").attr('disabled', true);
            $("#chassis").attr('disabled', true);
            $("#engine").attr('disabled', true);
            $("#veh_type").attr('disabled', true);
            $("#veh_model").attr('disabled', true);

            set_price(row.veh_code, $("#color_type").val());
        }
    });
    $('#color_name').combogrid({
        onSelect: function (index, row) {
            $("#color_code").val(row.color_code);
            $("#color_type").val(row.type);

            $("#color_code").attr('disabled', true);
            $("#color_type").attr('disabled', true);

            set_price($("#veh_code").val(), row.type);
        }
    });
    //lease_code','lease_name
    $("#lease_name").combogrid({
        onSelect: function (index, row) {
            $("#lease_code").val(row.lease_code);
            $("#lease_addr").val(row.oaddr);
            $("#lease_city").val(row.ocity);
            $("#lease_zipc").val(row.ozipcode);


            $("#lease_code").attr('disabled', true);
        }
    });

    function sendDesktop(so_no) {
        var posturl = 'http://192.168.0.8/test/runexe.php?so_no=' + so_no;
        $.post(posturl, function (res) {
        });
    }

    function UncloseBtn() { // alert('unclose')
        $.messager.confirm('Unclose SPK', 'Unclose this SPK?', function (r) {
            if (r) {
                var unclose_url = site_url + 'transaction/spk/unclose_spk/<?php echo $_SESSION['C_USER']; ?>';
                var id = $("#id").val();
                $('.loader').show();
                $.post(unclose_url, {table: table, id: id}, function (data) {
                    var obj = JSON.parse(data);
                    if (obj.success == true) {
                        cmdcondAwal();
                        read_show('');
                        $(".formError").remove();

                        var so_no = $("#so_no").val();
                        $(".easyui-datebox").datebox('disable');

                    } else
                    {
                        $('.loader').hide();
                        showAlert("Error while saving", '<font color="red">' + obj.message + '</font>');

                        read_show('');

                    }
                    scrlTop();
                });
            }
            read_show('');
        });

    }
    function closeBtn() {
        $.messager.confirm('Close SPK', 'Close this SPK?', function (r) {
            if (r) {
                var close_url = site_url + 'transaction/spk/close_spk/<?php echo $_SESSION['C_USER']; ?>';
                $(':input').attr('disabled', false);
                $('.loader').show();
                form.form('submit', {
                    url: close_url,
                    onSubmit: function () {
                        return $(this).form('validate');
                    },
                    success: function (data) { //alert(data);return false;

                        var obj = JSON.parse(data);
                        if (obj.success == true) {
                            showAlert("Information", obj.message);

                            cmdcondAwal();
                            read_show('');
                            $(".formError").remove();

                            var so_no = $("#so_no").val();
                            $(".easyui-datebox").datebox('disable');
                            sendDesktop(so_no);
                        } else
                        {
                            $('.loader').hide();
                            showAlert("Error Close", '<font color="red">' + obj.message + '</font>');
                            read_show('');
                        }
                        scrlTop();
                    }
                });
            }
            read_show('');
        });

    }

    function tableId() {
        divtableId.empty().append('<input type="hidden" name="id"  id="id"><input type="hidden" name="table"  id="table" value="' + table + '">');
    }


    function read_show(nav) {
        var id = $("#id").val();
        price_st = false

        $.post(site_url + 'crud/read', {table: table, nav: nav, id: id}, function (json) {
            $("#notif").val('');
            $('#form_validation input:text').val('');
            $('#form_validation textarea').val('');
            $('#form_validation .easyui-combogrid').combogrid('setValue', '');
            $("#form_validation input:radio").prop("checked", false);
            $(".easyui-datebox").datebox('setValue', '');

            if (json !== '[]') {

                var rowData = $.parseJSON(json);

                $('.cust_sex_' + rowData.cust_sex).prop("checked", true);
                $('.cust_rsex_' + rowData.cust_rsex).prop("checked", true);

                $('.salpaytype_' + rowData.salpaytype).prop("checked", true);
                $('.prc_type_' + rowData.prc_type).prop("checked", true);
                $('.cust_type_' + rowData.cust_type).prop("checked", true);

                $.each(rowData, function (i, v) {
                    $("#" + i).val(v);

                    if (i == 'srep_name' || i == 'cust_cntry' || i == 'cust_city' || i == 'cust_area' || i == 'pay_type' || i == 'lease_name' || i == 'color_name' || i == 'veh_name' || i == 'cust_name' || i == 'sosrc_name' || i == 'cust_rcity' || i == 'cust_rarea' || i == 'cust_rcntr' || i == 'sosrc_name' || i == 'lease_city') {

                        $("#" + i).combogrid('setValue', v);
                    }

                    if (i == 'unit_price'
                            || i == 'unit_disc'
                            || i == 'tot_price'
                            || i == 'pay_val'
                            || i == 'srv_price'
                            || i == 'srv_price'
                            || i == 'srv_disc'
                            || i == 'srv_bt'
                            || i == 'srv_vat'
                            || i == 'srv_at'
                            || i == 'comm_val'
                            || i == 'crd_term'
                            || i == 'crd_irate') {
                        $("#" + i).numberbox('setValue', v);
                    }

                    if (i == 'cls_date' || i == 'so_date' || i == 'soseq_date' || i == 'match_date' || i == 'dp_date' || i == 'pred_stk_d' || i == 'pay_date' || i == 'check_date' || i == 'due_date') {
                        if (v !== '0000-00-00') {
                            var vdate = dateSplit(v);
                            $("#" + i).datebox('setValue', vdate);
                        }
                    }
                });


                $("#cust_rname").val(rowData.cust_rname);


                $("#unit_price2").numberbox('setValue', rowData.tot_price);
                //$("#unit_price").numberbox('setValue', rowData.unit_price);
                //$("#unit_disc").numberbox('setValue', rowData.unit_disc);
                //$("#tot_price").numberbox('setValue', rowData.tot_price);
                //$("#pay_val").numberbox('setValue', rowData.pay_val);

                //$("#srv_price").numberbox('setValue', rowData.srv_price);
                //$("#srv_disc").numberbox('setValue', rowData.srv_disc);
                //$("#srv_bt").numberbox('setValue', rowData.srv_bt);
                //$("#srv_vat").numberbox('setValue', rowData.srv_vat);
                //$("#srv_at").numberbox('setValue', rowData.srv_at);

                cmdcondAwal();
                formDisabled();
                var so_no = rowData.so_no;
                var ttable = $('#dt_jasa');

                table_grid(ttable, so_no);

                $("#cmdClose").removeAttr('disabled');


                if (rowData.cls_date == null || rowData.cls_date == '0000-00-00') {
                    $("#print").linkbutton('disable');
                    $("#screen").linkbutton('disable');
                    $("#cmdOptional").removeAttr('disabled');
                    $("#cmdOptional").linkbutton('enable');
                    $("#closeOn").empty().append('<button type="button" id="cmdClose" title="<?php getCaption("Close"); ?>" class="easyui-linkbutton easyui-tooltip btn btn-success" data-options="iconCls:\'icon-close\'"  onclick="rolesClose()">Close</button>');
                } else {
                    $('.cmdEdit').linkbutton('disable');
                    $("#cmdDelete").linkbutton('disable');
                    $("#cmdOptional").removeAttr('disabled')
                    $("#cmdOptional").linkbutton('disable');
                    $("#closeOn").empty().append('<button type="button" id="cmdUnClose" title="<?php getCaption("unClose"); ?>" class="easyui-linkbutton easyui-tooltip btn btn-success" data-options="iconCls:\'icon-unclose\'"  onclick="rolesUnclose()">Unclose</button>');

                    $("#print").removeAttr('disabled')
                    $("#print").linkbutton('enable');
                    $("#screen").removeAttr('disabled')
                    $("#screen").linkbutton('enable');
                }



            } else {
                cmdcondAwal();
                formDisabled();

                // $('.cmdEdit').Attr('disabled');
                //$('.cmdDelete').Attr('disabled');
                $('.cmdEdit').linkbutton('disable');
                $('.cmdDelete').linkbutton('disable');

                $("#cmdOptional").removeAttr('disabled')
                $("#cmdOptional").linkbutton('disable');
                $("#closeOn").empty();
            }
            //alert('halloo')

            $(".loader").hide();
            $('.easyui-linkbutton').linkbutton();
        });
    }

    function doSearch() {
        $("#tableSearch").datagrid('load', {
            field1: $('#code').val(),
            field5: $('#name').val()
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
    function formDisabled() {
        $('#form_validation :input').attr('disabled', true);
        $('.easyui-combogrid').combogrid('disable');
        $('.easyui-combobox').combobox({disabled: true});
        $('.combo-text').removeClass('validatebox-text');
        $('.combo-text').removeClass('validatebox-invalid');
        $(".easyui-datebox").datebox('disable');
        cmdcondAwal();
    }

    function cmdcondAwal() {
        $('.cmdFirst').removeAttr('disabled');
        $('.cmdPrev').removeAttr('disabled');
        $('.cmdNext').removeAttr('disabled');
        $('.cmdLast').removeAttr('disabled');
        $('.cmdSave').attr('disabled', true);
        $('.cmdCancel').attr('disabled', true);
        $('.cmdAdd').removeAttr('disabled');
        $('.cmdEdit').removeAttr('disabled');
        $('.cmdDelete').removeAttr('disabled');
        $('.cmdSearch').removeAttr('disabled');

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
        scrlTop();
        price_st = true;
        $('#form_validation :input').attr('disabled', false);
        $("#cust_code").attr('disabled', true);
        $('.easyui-combogrid').combogrid('enable');
        $('.easyui-combobox').combobox({disabled: false});
        $('#cust_name').focus();

        $("#so_no").attr('disabled', true);
        $("#srep_code").attr('disabled', true);
        $("#srep_name").attr('disabled', true);

        $("#soseq_date").attr('disabled', true);
        $("#soseq_date").val('<?php echo date('Y-m-d'); ?>');

        $("#pur_inv_no").attr('disabled', true);
        $("#dp_inv_no").attr('disabled', true);

        $("#match_date").attr('disabled', true);
        $("#dp_date").attr('disabled', true);
        $("#cls_by").attr('disabled', true);

        $("#veh_code").attr('disabled', true);
        $("#chassis").attr('disabled', true);
        $("#engine").attr('disabled', true);
        $("#veh_type").attr('disabled', true);
        $("#veh_model").attr('disabled', true);
        $("#color_code").attr('disabled', true);

        $("#cls_date").attr('disabled', true);
        $("#soseq_date").datebox('disable');
        $("#cls_date").datebox('disable');
        $("#match_date").datebox('disable');
        $("#dp_date").datebox('disable');
        $("#wrhs_code").attr('disabled', true);
        $("#pay_date").datebox('enable');
        $("#unit_price2").attr('disabled', true);
        $("#tot_price").attr('disabled', true);

        $("#qty").attr('disabled', true);
        $("#unit").attr('disabled', true);
        $("#srv_price").attr('disabled', true);
        $("#srv_bt").attr('disabled', true);
        $("#srv_vat").attr('disabled', true);
        $("#srv_at").attr('disabled', true);

        $("#sspv_code").attr('disabled', true);
        $("#sspv_name").attr('disabled', true);
        $("#sspv_lev").attr('disabled', true);
        $("#srep_lev").attr('disabled', true);

        $("#form_validation #lease_code").attr('disabled', true);
        checkboxClick();
        cmdcondReady();

        optional_price();
    }

    function optional_price() {
        $("#form_validation #srv_disc").keyup(function () {
            var srv_price = parseCurrency($("#form_validation #srv_price").val());
            var srv_disc = parseCurrency($(this).val());

            var total_bt = srv_price - srv_disc;
            var vat = total_bt / 10;
            var total = total_bt + vat;

            $("#form_validation #srv_bt").numberbox('setValue', total_bt);
            $("#form_validation #srv_vat").numberbox('setValue', vat);
            $("#form_validation #srv_at").numberbox('setValue', total);

        });
    }
    function parseCurrency(num) {
        return num.replace(/[^0-9]/g, '');
    }

    function cmdcondReady() {

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

        $("#cmdBrowse").linkbutton('disable');
    }

    function table_grid(ttable, so_no) {
        ttable.datagrid({
            method: 'post',
            url: site_url + '<?php echo 'builder/datagrid/' . encrypt_decrypt('encrypt', 'veh_spkd'); ?>/so_no/' + so_no + '/?grid=true',
            title: '<?php getCaption("Deskripsi Service"); ?>',
            idField: 'id',
            fitColumns: false,
            singleSelect: true,
            nowrap: true,
            fit: false,
            rownumbers: true,
            pageSize: 10,
            showFooter: false,
            pagination: true,
            columns: [[
                    {field: 'wk_code', title: '<?php getCaption("Kode Pekerjaan"); ?>', width: 150, height: 20, sortable: true},
                    {field: 'wk_desc', title: '<?php getCaption("Nama Pekerjaan"); ?>', width: 400, height: 20, sortable: true},
                    {field: 'price_bd', title: '<?php getCaption("Harga Jual"); ?>', width: 120, height: 20, align: 'right', sortable: true, formatter: formatNumber},
                    {field: 'disc_pct', title: '<?php getCaption("Diskon"); ?> %', width: 120, height: 20, align: 'right', sortable: true, formatter: formatNumber},
                    {field: 'disc_val', title: '<?php getCaption("Jumlah Diskon"); ?>', width: 120, height: 20, align: 'right', sortable: true, formatter: formatNumber},
                    {field: 'price_ad', title: '<?php getCaption("Harga Netto"); ?>', width: 120, height: 20, align: 'right', sortable: true, formatter: formatNumber},
                    {field: 'add_by', title: '<?php getCaption("Ditambahkan Oleh"); ?>', width: 100, height: 20, align: 'center', sortable: true}

                ]]
        });
    }
    function table_grid_detail(ttable, so_no) {
        ttable.datagrid({
            method: 'post',
            url: site_url + '<?php echo 'builder/datagrid/' . encrypt_decrypt('encrypt', 'veh_spkd'); ?>/so_no/' + so_no + '/?grid=true',
            title: '<?php getCaption("Deskripsi Service"); ?>',
            idField: 'id',
            fitColumns: true,
            singleSelect: true,
            nowrap: true,
            fit: false,
            rownumbers: true,
            pageSize: 10,
            showFooter: false,
            pagination: true,
            columns: [[
                    {field: 'wk_code', title: '<?php getCaption("Kode Pekerjaan"); ?>', width: 120, height: 20, sortable: true},
                    {field: 'wk_desc', title: '<?php getCaption("Nama Pekerjaan"); ?>', width: 280, height: 20, sortable: true},
                    {field: 'price_bd', title: '<?php getCaption("Harga Jual"); ?>', width: 120, height: 20, align: 'right', sortable: true, formatter: formatNumber},
                    {field: 'disc_pct', title: '<?php getCaption("Diskon"); ?> %', width: 120, height: 20, align: 'right', sortable: true, formatter: formatNumber},
                    {field: 'disc_val', title: '<?php getCaption("Jumlah Diskon"); ?>', width: 120, height: 20, align: 'right', sortable: true, formatter: formatNumber},
                    {field: 'price_ad', title: '<?php getCaption("Harga Netto"); ?>', width: 120, height: 20, align: 'right', sortable: true, formatter: formatNumber},
                    {field: 'add_by', title: '<?php getCaption("Ditambahkan Oleh"); ?>', width: 100, height: 20, align: 'center', sortable: true}

                ]]
        });
    }



    function table_grid_spk(spklisturl) {


        $("#tb_spk").datagrid({
            method: 'post',
            url: spklisturl,
            title: 'SPK List',
            idField: 'id',
            fitColumns: false,
            singleSelect: true,
            nowrap: true,
            fit: false,
            rownumbers: true,
            pageSize: 10,
            showFooter: false,
            pagination: true,
            columns: [[
                    {field: 'so_regdate', title: '<?php getCaption("Tgl. Registrasi"); ?>', width: 120, height: 20, sortable: true, formatter: formatDate},
                    {field: 'so_no', title: '<?php getCaption("SPK Registrasi"); ?>', width: 120, height: 20, sortable: true},
                    //{field: 'srep_code', title: '<?php getCaption("Kode Sales"); ?>', width: 80, height: 20, sortable: true},
                    {field: 'srep_name', title: '<?php getCaption("Nama Sales"); ?>', width: 160, height: 20, sortable: true},
                    //{field: 'sspv_code', title: '<?php getCaption("Kode Supervisor"); ?>', width: 80, height: 20, sortable: true},
                    {field: 'sspv_name', title: '<?php getCaption("Nama Supervisor"); ?>', width: 160, height: 20, sortable: true},
                    {field: 'so_note', title: '<?php getCaption("Catatan"); ?>', width: 150, height: 20, sortable: true},
                    {field: 'so_reg_by', title: '<?php getCaption("Registered By"); ?>', width: 100, height: 20, sortable: true}

                ]]
        });

        $("#tb_spk").datagrid('reload');
    }

    function viewShowAction() {
        var viewShow = $("#viewShow").val();

        optionHide();

        switch (viewShow) {
            case 'all':
                optionHide();
                //tableSPKReg(spklisturl);
                table_grid_spk(spklisturl);
                break;

            case 'so_no':
                $('#TDkeyword').show();
                $("#TDbuttonKeyword").show();
                break;

            case 'so_regdate':
                $('#TDDate').show();
                $("#TDbuttonDate").show();
                $("#from").datebox('setValue', '<?php echo date('Y-m-d'); ?>');
                $("#to").datebox('setValue', '<?php echo date('Y-m-d'); ?>');
                $("#from").datebox('enable');
                $("#to").datebox('enable');
                break;

            case 'srep_code':
                $('#srep_name').combogrid('setValue', '');
                $('#srep_name').combogrid('enable');
                $('#TDsales').show();
                $("#TDbuttonSales").show();


                break;
        }
    }

    function optionHide() {
        $('#TDkeyword').hide();
        $('#TDDate').hide();
        $('#TDsales').hide();
        $("#TDbuttonKeyword").hide();
        $("#TDbuttonDate").hide();
        $("#TDbuttonSales").hide();

        $("#keyword").val('');

        $("#form #srep_code").val('');
        $("#form #srep_name").combogrid('setValue', '');


    }

    function keywordSearch() {
        var viewShow = $("#viewShow").val();
        var keyword = $("#keyword").val();

        var spklisturl = site_url + '<?php echo 'builder/grid_spkreg/' . encrypt_decrypt('encrypt', 'veh_spkreg'); ?>/undistribute/' + viewShow + '/' + keyword + '/?grid=true';

        table_grid_spk(spklisturl);

    }
    function dateSearch() {
        var viewShow = $("#viewShow").val();
        var from = $("#from").datebox('getValue');
        var to = $("#to").datebox('getValue');

        if (Date.parse(from) / 1000 > Date.parse(to) / 1000) {
             $.messager.alert('Warning','Beginning date has to be bigger or equal to end date ', 'warning');
            $("#tb_spk").datagrid('loadData', {"total": 0, "rows": []});
        } else {
            var spklisturl = site_url + '<?php echo 'builder/grid_spkreg/' . encrypt_decrypt('encrypt', 'veh_spkreg'); ?>/undistribute/' + viewShow + '/' + from + '/' + to + '/?grid=true';
            table_grid_spk(spklisturl);
        }

    }

    function salesSearch() {
        var viewShow = $("#viewShow").val();
        var sales = $("#form #srep_code").val();

        var spklisturl = site_url + '<?php echo 'builder/grid_spkreg/' . encrypt_decrypt('encrypt', 'veh_spkreg'); ?>/undistribute/' + viewShow + '/' + sales + '/?grid=true';

        table_grid_spk(spklisturl);

    }

    function condEdit() {
        $("#notif").val('new');
        var id = $("#id").val();

        $.post(site_url + 'transaction/spk/check_close_spk', {table: '<?php echo encrypt_decrypt('encrypt', 'veh_spk'); ?>', id: id}, function (res) {

            var json = $.parseJSON(res);

            if (json.status !== false) {
                $(".easyui-datebox").datebox('enable');
                condReady();
                /*
                 $("#so_no").attr('disabled', true);
                 $("#srep_code").attr('disabled', true);
                 $("#srep_name").attr('disabled', true);
                 
                 $("#soseq_date").attr('disabled', true);
                 
                 $("#pur_inv_no").attr('disabled', true);
                 $("#dp_inv_no").attr('disabled', true);
                 $("#wrhs_code").attr('disabled', true);
                 $("#match_date").attr('disabled', true);
                 $("#dp_date").attr('disabled', true);
                 $("#cls_by").attr('disabled', true);
                 $("#cls_date").datebox('disable');
                 $("#tot_price").attr('disabled', true);
                 $("#unit_price2").attr('disabled', true);
                 $("#cls_date").datebox('setValue', '');
                 $("#cls_by").val('');
                 
                 $(".easyui-datebox").datebox('enable');
                 $("#so_date").datebox('setValue', '<?php echo date('d/m/Y'); ?>');
                 $("#soseq_date").datebox('setValue', '<?php echo date('d/m/Y'); ?>');
                 $("#soseq_date").datebox('disable');
                 $("#cls_date").datebox('disable');
                 $("#match_date").datebox('disable');
                 $("#dp_date").datebox('disable');
                 */
                $("#cmdOptional").removeAttr('disabled');
                $("#cmdOptional").linkbutton('disable');
                $("#cmdClose").removeAttr('disabled')
                $("#cmdClose").linkbutton('disable');

            } else {
                showAlert("Error While Updating SPK", '<font color="red">Sorry, SPK has been closed and can\'t be edited. Please click unclose to edit this SPK</font>');
            }
        });

    }

    function condAdd() {
        $(".easyui-datebox").datebox('setValue', '');
        $(".easyui-datebox").datebox('enable');
        $('.easyui-numberbox').numberbox('enable');
        $('.easyui-numberbox').numberbox('setValue', '');
        $('#id').val('');
        $('#form_validation input:text').val('');

        $("#table").val(table);
        $('#form_validation textarea').val("");
        $("#form_validation input:radio").prop("checked", false);
        condReady();
        $('#spkWindow').window('open');

        optionHide();
        $("#viewShow").val('all');

        table_grid_spk(spklisturl);



        disableFormAdd();
        $("#so_date").datebox('setValue', '<?php echo date('d/m/Y'); ?>');
        $("#soseq_date").datebox('setValue', '<?php echo date('d/m/Y'); ?>');
        $("#soseq_date").datebox('disable');
        $("#cls_date").datebox('disable');
        $("#match_date").datebox('disable');
        $("#dp_date").datebox('disable');
        $("#notif").val('new');
        //$("#unit_price2").attr('disabled', true);
        $("#cls_date").datebox('setValue', '');
        $("#match_date").datebox('setValue', '');
        $("#pred_stk_d").datebox('setValue', '');
        $("#pay_date").datebox('setValue', '');
        $("#check_date").datebox('setValue', '');
        $(".easyui-combogrid").combogrid('setValue', '');
        $("#unit_price2").attr('disabled', true);
        $("#wrhs_code").val('<?php echo $wrhs_input; ?>');
    }

    function disableFormAdd() {
        $("#cmdCancel").linkbutton('enable');
        $("#cmdSave").linkbutton('enable');
        $('#cmdOptional').linkbutton('disable');
        $('#cmdClose').linkbutton('disable');
        $('#cmdUnClose').linkbutton('disable');

        $('#print').linkbutton('disable');
        $('#screen').linkbutton('disable');
        $('#ok').linkbutton('disable');

        $(".disabled").attr('disabled', true);
        $("#color_type").attr('disabled', true);
        $("#veh_year").attr('disabled', true);
        $("#veh_transm").attr('disabled', true);
        $("#veh_brand").attr('disabled', true);
        $("#veh_model").attr('disabled', true);
        $("#veh_type").attr('disabled', true);
        $("#engine").attr('disabled', true);
        $("#chassis").attr('disabled', true);
        $("#tot_price").attr('disabled', true);

        $("#qty").val('1').attr('disabled', true);
        $("#unit").val('unit').attr('disabled', true);
    }

    function get_spk() {
        var row = $("#tb_spk").datagrid('getSelected');
        if (row) {
            $.post(site_url + 'transaction/spk/check_spkreg', {table: '<?php echo encrypt_decrypt('encrypt', 'veh_spkreg'); ?>', id: row.so_no}, function (res) { //alert(res)
                var msg = JSON.parse(res);

                if (msg.status !== false) {
                    //$.post(site_url+'crud/update', {table:'<?php echo encrypt_decrypt('encrypt', 'veh_spkreg'); ?>', id:row.so_no, field:'so_no', use_date:'<?php echo date('Y-m-d h:i:s'); ?>'}, function(res){});
                    var data = [];

                    $("#srep_name").combogrid('grid').datagrid('loadData', data);
                    $("#so_no").val(row.so_no);
                    $("#srep_code").val(row.srep_code);
                    $("#srep_lev").val(row.srep_lev);
                    $("#sspv_lev").val(row.sspv_lev);
                    $("#sspv_code").val(row.sspv_code);
                    $("#sspv_name").val(row.sspv_name);

                    //$("#srep_name").val(row.srep_name);
                    $("#srep_name").combogrid('setValue', row.srep_name);
                    $("#so_date").datebox('setValue', '<?php echo date('Y-m-d'); ?>');

                    $('#spkWindow').window('close');

                    $("#so_no").attr('disabled', true);
                    $("#srep_code").attr('disabled', true);
                    $("#srep_name").attr('disabled', true);

                    $("#soseq_date").attr('disabled', true);
                    $("#soseq_date").datebox('setValue', '<?php echo date('Y-m-d'); ?>');

                    $("#pur_inv_no").attr('disabled', true);
                    $("#dp_inv_no").attr('disabled', true);

                    $("#match_date").attr('disabled', true);
                    $("#dp_date").attr('disabled', true);
                    $("#cls_by").attr('disabled', true);
                    $("#cls_date").attr('disabled', true);

                    // $("#w").empty();

                    var ttable = $('#dt_jasa');

                    table_grid(ttable, row.so_no);

                } else {
                    showAlert("Error While Retrieving SPK number", '<font color="red">SPK No. has been used</font>');
                }
            });
        }

    }

    function cancel_get_spk() {
        $('#spkWindow').window('close');
        cmdcondAwal();
        read_show('');
        $(".formError").remove();
    }

    function condCancel() {
        cmdcondAwal();
        read_show('');
        $(".formError").remove();

        var so_no = $("#so_no").val();
        //$.post(site_url+'crud/update', {table:'<?php echo encrypt_decrypt('encrypt', 'veh_spkreg'); ?>', id:so_no, field:'so_no', use_date:'0000-00-00 00:00:00'}, function(res){});
        $(".easyui-datebox").datebox('disable');
        $('.easyui-numberbox').attr('disabled', true);
    }

    function cmdOptionals() {
        scrlTop();
        $('#w').window('open');

        var so_no = $("#form_validation #so_no").val();

        tableId2();
        read_show2('');
        table_grid(ttable, so_no);

    }


    function saveData() {
        $('.loader').show();
        $('#form_validation :input').attr('disabled', false);
        // form.validationEngine();
        form.form('submit', {
            url: save_url,
            onSubmit: function () {
                return $(this).form('validate');
            },
            success: function (data) {
                var obj = JSON.parse(data);

                if (obj.success == true) {
                    showAlert("Information", obj.message);
                    cmdcondAwal();
                    read_show('');
                    $(".formError").remove();

                    var so_no = $("#so_no").val();
                    $(".easyui-datebox").datebox('disable');
                    // $('.loader').hide();
                } else
                {
                    updateFailed(obj);
                    //$('.loader').hide();
                    //condReady();
                    /*  $("#so_date").val('<?php echo date('Y-m-d'); ?>');
                     
                     
                     $("#so_no").attr('disabled', true);
                     $("#srep_code").attr('disabled', true);
                     $("#srep_name").attr('disabled', true);
                     
                     $("#soseq_date").attr('disabled', true);
                     
                     $("#pur_inv_no").attr('disabled', true);
                     $("#dp_inv_no").attr('disabled', true);
                     
                     $("#match_date").attr('disabled', true);
                     $("#dp_date").attr('disabled', true);
                     $("#cls_by").attr('disabled', true);
                     $("#cls_date").attr('disabled', true);
                     $(".easyui-datebox").datebox('disable');
                     //$('.easyui-numberbox').attr('disabled', true);
                     $("#unit_price2").attr('disabled', true);*/
                    //disableFormAdd();
                    //showAlert("Error while saving", '<font color="red">' + obj.message + '</font>');

                }
                scrlTop();
            }
        });
    }

    /*function condSearch() {
     $('#w').window('open');
     var path = 'trx/spk/';
     $.post(site_url + 'builder/form/form_search_spk', {path: path}, function (html) { //alert(html)
     $("#w").empty().html(html);
     
     $('.easyui-linkbutton').linkbutton();
     });
     
     }
     function getSearchselect() {
     var row = $("#dt_dpklist").datagrid('getSelected');
     
     if (row) {
     $("#id").val(row.id);
     $('#w').window('close');
     read_show('');
     }
     }
     */
    function print_sc(action) {



        var id = $("#id").val();
        var user = '<?php echo $_SESSION['C_USER']; ?>';
        //var url = base_url + 'print/index.php?id=' + id + '&user=' + user ;
        var url = site_url + 'transaction/spk/outputpdf/<?php echo encrypt_decrypt('encrypt', 'veh_spk'); ?>/' + id + '/' + user + '/' + action + '#toolbar=0';


        if (action == 'screen') {
            // $('#sr').window('open');
            window.open(url);
        } else {
            $('#sr').empty().append('<iframe   frameborder="0"  src="' + url + '" style="width:100%;height:auto;min-height: 500px;padding:0px;"></iframe>');
        }

    }


    function condDelete() { // alert('hello');return false;
        var id = $("#id").val();
        var table = $("#table").val();
        $.messager.confirm('Warning', 'Do you really want to delete this SPK? ', function (r) {
            if (r) {

                $('.loader').show();
                var url = site_url + 'transaction/spk/deleteSPK';
                $.post(url, {table: table, id: id}, function (data) {
                    obj = JSON.parse(data);
                    if (obj.success == true) {
                        $("#id").val('');
                        showAlert("Information", obj.message);
                        // cmdcondAwal();
                        read_show('');
                    } else
                    {
                        $('.loader').hide();
                        showAlert("Error while deleting", '<font color="red">' + obj.message + '</font>');
                    }
                    scrlTop();
                });
            }else{
                $('#cmdDelete').linkbutton('enable');
            }
        });
    }


    function set_price(code, type) { //alert(price_st)
        $("#unit_price").numberbox('setValue', '');
        $("#tot_price").numberbox('setValue', '');
        $("#unit_price2").numberbox('setValue', '');
        if (price_st !== false) {
            $.post(site_url + 'transaction/spk/get_price', {code: code, type: type}, function (res) {
                if (res !== '[]') {
                    var price = $.parseJSON(res);
                    $("#unit_price").numberbox('setValue', price.sal_price);
                    $("#tot_price").numberbox('setValue', price.sal_price);
                    $("#unit_price2").numberbox('setValue', price.sal_price);
                }
            });
        }
    }


    function read_show2(nav) {
        var id = $("#id2").val();
        var so_no = $("#form_validation #so_no").val();

        $.post(site_url + 'crud/read/?so_no=' + so_no, {table: table2, nav: nav, id: id}, function (json) { //alert(json)
            $('#form_validation2 #wk_code').combogrid('setValue', '');
            $('#form_validation2 #wk_desc2').val('');
            $('#form_validation2 #sal_price2').numberbox('setValue', '');
            $('#form_validation2 #disc_pct2').numberbox('setValue', '');
            $('#form_validation2 #disc_val2').numberbox('setValue', '');
            $('#form_validation2 #price_ad2').numberbox('setValue', '');

            if (json !== '[]') {

                table_grid(ttables, so_no);
                table_grid(ttable, so_no);
                cmdcondAwal2();
                formDisabled2();
                var rowData = $.parseJSON(json);

                $('#form_validation2').form('load', {
                    wk_code: rowData.wk_code,
                    wk_desc2: rowData.wk_desc,
                    sal_price2: rowData.price_bd,
                    disc_pct2: rowData.disc_pct,
                    disc_val2: rowData.disc_val,
                    price_ad2: rowData.price_ad,
                    id2: rowData.id
                });

                /* $("#id2").val(rowData.id);
                 $('#form_validation2 #wk_desc2').val(rowData.wk_desc);
                 $('#form_validation2 #sal_price2').numberbox('setValue', rowData.price_bd);
                 //$('#form_validation2 #disc_pct2').numberbox(rowData.disc_pct);
                 $('#form_validation2 #disc_val2').numberbox('setValue', rowData.disc_val);
                 $('#form_validation2 #price_ad2').numberbox('setValue', rowData.price_ad);
                 
                 
                 $('#form_validation2 #wk_code').combogrid('setValue', rowData.wk_code);
                 */

            } else {
                table_grid(ttables, so_no);
                table_grid_detail(ttable, so_no);
                cmdcondAwal2();
                formDisabled2();
            }


        });
    }

    function saveData2() {
        $('#cmdSave2').linkbutton('disable');
        var so_no = $("#form_validation #so_no").val();
        var user = '<?php echo $_SESSION['C_USER']; ?>';
        var save_url2 = site_url + 'transaction/spk/save_spkd/' + so_no + '/' + user;

        form2.form('submit', {
            url: save_url2,
            onSubmit: function () {
                return $(this).form('validate');
            },
            success: function (data) {
                var obj = JSON.parse(data);



                if (obj.success == true) {
                    //showAlert("Information", obj.message);

                    $("#id2").val('');
                    read_show('');
                    read_show2('');

                } else
                {
                    showAlert("Error while saving", '<font color="red">' + obj.message + '</font>');
                    //$("#id2").val('');
                    //read_show2('');
                    $('#cmdSave2').linkbutton('enable');
                }
            }
        });
    }

    function condDelete2() {
        var id = $("#id2").val();
        var table = $("#table2").val();
        var so_no = $("#form_validation #so_no").val();
        $.messager.confirm('Warning', 'Are you sure to delete selected data ?', function (r) {
            if (r) {

                var url = site_url + 'transaction/spk/deletework';
                $.post(url, {table: table, id: id}, function (data) { //alert(data)
                    obj = JSON.parse(data);
                    if (obj.success == true) {
                        // showAlert("Information", obj.message);
                        $("#id2").val('');
                        read_show('');
                        read_show2('');

                        ttables.datagrid('reload');
                        ttable.datagrid('reload');
                        //  table_grid(ttables, so_no);
                        //table_grid(ttable, so_no);
                    } else
                    {
                        showAlert("Error while deleting", '<font color="red">' + obj.message + '</font>');
                    }
                });
            }
        });
    }
    $('#wk_code').combogrid({
        onSelect: function (index, row) {
            var sal_price = row.sal_price;
            var optprc_set = '<?php echo $optprc_set; ?>';

            if (optprc_set == 2) {
                sal_price = 0;
            }

            $('#wk_code').val(row.wk_code);
            $('#wk_desc2').val(row.wk_desc);
            $('#sal_price2').numberbox('setValue', sal_price);
            $('#price_ad2').numberbox('setValue', sal_price);
            //$('#disc_pct2').numberbox('setValue', '0');
            $('#disc_val2').numberbox('setValue', '0');
            $('#disc_pct2').numberbox('setValue', '0');

        }
    });

    function condCancel2() {
        cmdcondAwal2();
        read_show2('');
        $(".formError").remove();
    }

    function formDisabled2() {
        //$(':input').attr('disabled', true);
        $('#wk_code').attr('disabled', true);
        $('#wk_desc2').attr('disabled', true);
        $('#sal_price2').attr('disabled', true);
        $('#disc_pct2').attr('disabled', true);
        $('#disc_val2').attr('disabled', true);
        $('#price_ad2').attr('disabled', true);

        $('.easyui-combogrid').combogrid('disable');
        $('.easyui-combobox').combobox({disabled: true});
        $('.combo-text').removeClass('validatebox-text');
        $('.combo-text').removeClass('validatebox-invalid');
        cmdcondAwal2();
    }
    function cmdcondAwal2() {

        $('#cmdFirst2').removeAttr('disabled');
        $('#cmdPrev2').removeAttr('disabled');
        $('#cmdNext2').removeAttr('disabled');
        $('#cmdLast2').removeAttr('disabled');
        $('#cmdSave2').attr('disabled', true);
        $('#cmdCancel2').attr('disabled', true);
        $('#cmdAdd2').removeAttr('disabled');
        $('#cmdEdit2').removeAttr('disabled');
        $('#cmdDelete2').removeAttr('disabled');
        $('#cmdSearch2').removeAttr('disabled');

        $('#cmdFirst2').linkbutton('enable');
        $('#cmdPrev2').linkbutton('enable');
        $('#cmdNext2').linkbutton('enable');
        $('#cmdLast2').linkbutton('enable');
        $('#cmdSave2').linkbutton('disable');
        $('#cmdCancel2').linkbutton('disable');
        $('#cmdAdd2').linkbutton('enable');
        $('#cmdEdit2').linkbutton('enable');
        $('#cmdDelete2').linkbutton('enable');
        $('#cmdSearch2').linkbutton('enable');

        $('#ok2').attr('disabled', false);
        $('#ok2').linkbutton('enable');
    }
    function condReady2() {
        $('#wk_code').attr('disabled', false);
        $('#wk_desc2').attr('disabled', false);
        $('#sal_price2').attr('disabled', false);
        $('#disc_pct2').attr('disabled', false);
        $('#disc_val2').attr('disabled', false);
        $('#price_ad2').attr('disabled', false);

        $('.easyui-combogrid').combogrid('enable');
        $('.easyui-combobox').combobox({disabled: false});
        $('#wk_code').focus();
        cmdcondAwal2();
        cmdcondReady2();
    }

    function cmdcondReady2() {
        //$("#cmdSave").show();
        //$("#cmdCancel").show();
        $('#cmdFirst2').attr('disabled', true);
        $('#cmdPrev2').attr('disabled', true);
        $('#cmdNext2').attr('disabled', true);
        $('#cmdLast2').attr('disabled', true);
        $('#cmdSave2').removeAttr('disabled');
        $('#cmdCancel2').removeAttr('disabled');
        //$("#cmdSave").removeAttr('disabled');
        //$("#cmdCancel").removeAttr('disabled');
        $('#cmdAdd2').attr('disabled', true);
        $('#cmdEdit2').attr('disabled', true);
        $('#cmdDelete2').attr('disabled', true);
        $('#cmdSearch2').attr('disabled', true);


        $('#cmdFirst2').linkbutton('disable');
        $('#cmdPrev2').linkbutton('disable');
        $('#cmdNext2').linkbutton('disable');
        $('#cmdLast2').linkbutton('disable');

        $('#cmdSave2').linkbutton('enable');
        $('#cmdCancel2').linkbutton('enable');
        //$("#cmdSave").removeAttr('disabled');
        //$("#cmdCancel").removeAttr('disabled');
        $('#cmdAdd2').linkbutton('disable');
        $('#cmdEdit2').linkbutton('disable');
        $('#cmdDelete2').linkbutton('disable');
        $('#cmdSearch2').linkbutton('disable');

        $('#ok2').attr('disabled', true);
        $('#ok2').linkbutton('disable');
    }
    function condAdd2() {
        $('.combo-text').val('');
        $('#id2').val('');
        $('#wk_code').val('');
        $('#wk_desc2').val('');
        $('#form_validation2 #wk_desc2').val('');
        $('#form_validation2 #sal_price2').numberbox('setValue', '0');
        $('#form_validation2 #disc_pct2').numberbox('setValue', '0');
        $('#form_validation2 #disc_val2').numberbox('setValue', '0');
        $('#form_validation2 #price_ad2').numberbox('setValue', '0');
        $("#table2").val(table2);

        condReady2();
        optional_price();

        $('#form_validation2 #sal_price2').keyup(function () {
            var harga = parseCurrency($(this).val());
            var disc = parseCurrency($('#form_validation2 #disc_val2').val());

            var jml_disc = (harga / 100) * disc;

            if (jml_disc > harga) {
                  $.messager.alert('Warning','Discount value has to be lower than Unit Price', 'warning');
                $('#form_validation2 #disc_pct2').numberbox('setValue', '0');
                $('#form_validation2 #disc_val2').numberbox('setValue', '0');
                $('#form_validation2 #price_ad2').numberbox('setValue', harga);

            } else {
                var total = harga - jml_disc;
                $('#form_validation2 #disc_val2').numberbox('setValue', jml_disc);
                $('#form_validation2 #price_ad2').numberbox('setValue', total);
            }
        });


        $('#form_validation2 #disc_pct2').keyup(function () {
            var disc = $(this).val();
            var harga = parseCurrency($('#form_validation2 #sal_price2').val());
            var jml_disc = (parseCurrency($('#form_validation2 #sal_price2').val()) / 100) * disc;

            if (disc > 0) {

                if (parseInt(jml_disc) > parseInt(harga)) {
                     $.messager.alert('Warning','Discount value has to be lower than Unit Price', 'warning');
                    $('#form_validation2 #disc_pct2').val('0');
                    $('#form_validation2 #disc_val2').numberbox('setValue', '0');
                    $('#form_validation2 #price_ad2').numberbox('setValue', harga);
                } else {
                    var total = harga - jml_disc;
                    $('#form_validation2 #disc_val2').numberbox('setValue', jml_disc);
                    $('#form_validation2 #price_ad2').numberbox('setValue', total);
                }
            } else {
                $('#form_validation2 #disc_pct2').val('0');
                $('#form_validation2 #disc_val2').numberbox('setValue', '0');
                $('#form_validation2 #price_ad2').numberbox('setValue', harga);
            }
        });

        $('#form_validation2 #disc_val2').keyup(function () {
            var jml_disc = parseCurrency($(this).val());
            var harga = parseCurrency($('#form_validation2 #sal_price2').val());

            if (jml_disc > 0) {

                if (parseInt(jml_disc) > parseInt(harga)) {
                     $.messager.alert('Warning','Discount value has to be lower than Unit Price', 'warning');
                    $('#form_validation2 #disc_pct2').val('0');
                    $('#form_validation2 #disc_val2').numberbox('setValue', '0');
                    $('#form_validation2 #price_ad2').numberbox('setValue', harga);

                } else {
                    var disc = (jml_disc * 100) / harga;
                    var disc = Math.ceil(disc * 100) / 100;
                    var total = harga - jml_disc;

                    $('#form_validation2 #disc_pct2').val(disc)
                    //$('#form_validation2 #disc_pct2').numberbox('setValue',disc);
                    $('#form_validation2 #price_ad2').numberbox('setValue', total);
                }
            } else {
                $('#form_validation2 #disc_pct2').val('0');
                $('#form_validation2 #disc_val2').numberbox('setValue', '0');
                $('#form_validation2 #price_ad2').numberbox('setValue', harga);
            }
        });

    }



    function condEdit2() {

        cmdcondReady2();
        condReady2();
    }


    function tableId2() {
        divtableId2.empty().append('<input type="hidden" name="id2"  id="id2"><input type="hidden" name="table2"  id="table2" value="' + table2 + '">');
    }

    /*End form pekerjaan*/

    $(document).ready(function () {
        tableId();
        read_show('');
        version('03.17-31');
    });

</script>
