<!--table veh_rslh  dan veh_stk-->
<script>
    var table = 'veh_rslh';
    var form = $('#form_validation');
    var save_url = site_url + 'transaction/vehicle/saveReturnPenjualan';
    var unclose_url = site_url + 'transaction/vehicle/uncloseReturnPenjualan/<?php echo $_SESSION['C_USER']; ?>';
    var close_url = site_url + 'transaction/vehicle/closeReturnPenjualan/<?php echo $_SESSION['C_USER']; ?>';
    var delete_inv_url = site_url + 'transaction/vehicle/DeleteVSLReturn';

    var ttable = $('#dt_jasa');
    var divtableId = $("#tableId");

    var table2 = 'veh_rsld';
    var ttables = $('#dt_jasa2');
    var divtableId2 = $("#tableId2");

    /*
     
     $("#sal_inv_no").combogrid({
     onSelect: function (index, rowData) {
     
     /*$('#form_validation .cust_sex_' + rowData.cust_sex).prop("checked", true);
     $('#form_validation .cust_type_' + rowData.cust_type).prop("checked", true);
     $('#form_validation .cust_rsex_' + rowData.cust_rsex).prop("checked", true);
     $('#form_validation .srep_sex_' + rowData.srep_sex).prop("checked", true);
     $('#form_validation .srep_sex_' + rowData.srep_sex).prop("checked", true);
     */

    /*
     $('#form_validation .cust_sex_' + rowData.cust_sex).prop("checked", true);
     $('#form_validation .cust_type_' + rowData.cust_type).prop("checked", true);
     $('#form_validation .cust_rsex_' + rowData.cust_rsex).prop("checked", true);
     $('#form_validation .srep_sex_' + rowData.srep_sex).prop("checked", true);
     
     $('#form_validation .sal_inctyp_' + rowData.sal_inctyp).prop("checked", true);
     $('#form_validation .kwit_data_' + rowData.kwit_data).prop("checked", true);
     $('#form_validation .fp_data_' + rowData.fp_data).prop("checked", true);
     
     $.each(rowData, function (i, v) {
     if (v !== '') {
     
     if (i !== 'id') {
     $("#form_validation #" + i).val(v);
     
     
     if (
     i == 'cust_name' ||
     i == 'srep_name' ||
     i == 'cust_area' ||
     i == 'cust_city' ||
     i == 'cust_rarea' ||
     i == 'cust_rcity') {
     
     $("#form_validation #" + i).combogrid('setValue', v);
     }
     
     if (
     i == 'fp_date' ||
     i == 'rsl_date' ||
     i == 'due_date' ||
     i == 'sal_date' ||
     i == 'stnk_bdate' ||
     i == 'stnk_edate' ||
     i == 'so_date' ||
     i == 'sj_date' ||
     i == 'kwit_date'
     ) {
     if (v !== '0000-00-00') {
     var vdate = dateSplit(v);
     $("#form_validation #" + i).datebox('setValue', vdate);
     }
     }
     
     if (
     i == 'veh_price'
     || i == 'veh_disc'
     || i == 'veh_at'
     || i == 'veh_bbn'
     || i == 'veh_misc'
     || i == 'veh_total'
     || i == 'srv_at'
     || i == 'part_at'
     || i == 'inv_stamp'
     || i == 'inv_total'
     || i == 'veh_pbm'
     || i == 'veh_bt'
     || i == 'veh_vat'
     
     
     || i == 'srv_price'
     || i == 'srv_disc'
     || i == 'srv_bt'
     || i == 'srv_vat'
     || i == 'due_day'
     || i == 'cust_zipc'
     || i == 'cust_rzipc'
     
     
     || i == 'sal_incpnt'
     || i == 'sal_incpct'
     
     ) {
     $("#form_validation #" + i).numberbox('setValue', v);
     }
     
     if (i == 'id') {
     $("#form_validation #" + i).val('');
     }
     }
     } else {
     $("#form_validation" + i).val('');
     }
     
     });
     
     var total = parseInt(rowData.srv_bt) + parseInt(rowData.srv_vat);
     
     $("#srv_at2").numberbox('setValue', total);
     $("#veh_at2").numberbox('setValue', rowData.veh_at);
     }
     });*/


    function tableId() {
        divtableId.empty().append('<input type="hidden" name="id"  id="id"><input type="hidden" name="table"  id="table" value="' + table + '">');
    }
    function read_show(nav) {
        var id = $("#form_validation #id").val();

        $.post(site_url + 'crud/read', {table: table, nav: nav, id: id}, function (json) {

            emptyForm();

            if (json !== '[]') {

                var rowData = $.parseJSON(json);

                $('#form_validation .cust_sex_' + rowData.cust_sex).prop("checked", true);
                $('#form_validation .cust_type_' + rowData.cust_type).prop("checked", true);
                $('#form_validation .cust_rsex_' + rowData.cust_rsex).prop("checked", true);
                $('#form_validation .srep_sex_' + rowData.srep_sex).prop("checked", true);
                $('#form_validation .sal_inctyp_' + rowData.sal_inctyp).prop("checked", true);

                $('#form_validation .kwit_data_' + rowData.kwit_data).prop("checked", true);
                $('#form_validation .fp_data_' + rowData.fp_data).prop("checked", true);

                $.each(rowData, function (i, v) {
                    if (v !== '') {

                        $("#" + i).val(v);

                        if (
                                i == 'cust_name' ||
                                i == 'srep_name' ||
                                i == 'cust_area' ||
                                i == 'cust_city' ||
                                i == 'cust_rarea' ||
                                i == 'cust_rcity') {

                            $("#form_validation #" + i).combogrid('setValue', v);
                        }


                        //if (i == 'rsl_date' || i == 'due_date' || i == 'cls_date' || i == 'sal_date' || i == 'stnk_bdate' || i == 'stnk_edate' || i == 'so_date') {
                        if (
                                i == 'fp_date' ||
                                i == 'rsl_date' ||
                                i == 'cls_date' ||
                                i == 'due_date' ||
                                i == 'sal_date' ||
                                i == 'stnk_bdate' ||
                                i == 'stnk_edate' ||
                                i == 'so_date' ||
                                i == 'sj_date' ||
                                i == 'kwit_date'

                                ) {
                            if (v !== '0000-00-00') {
                                var vdate = dateSplit(v);

                                $("#" + i).datebox('setValue', vdate);
                            }
                        }

                        if (
                                i == 'veh_price'
                                || i == 'veh_disc'
                                || i == 'veh_at'
                                || i == 'veh_bbn'
                                || i == 'veh_misc'
                                || i == 'veh_total'
                                || i == 'srv_at'
                                || i == 'part_at'
                                || i == 'inv_stamp'
                                || i == 'inv_total'
                                || i == 'veh_pbm'
                                || i == 'veh_bt'
                                || i == 'veh_vat'


                                || i == 'srv_price'
                                || i == 'srv_disc'
                                || i == 'srv_bt'
                                || i == 'srv_vat'
                                || i == 'due_day'
                                || i == 'cust_zipc'
                                || i == 'cust_rzipc'


                                || i == 'sal_incpnt'
                                || i == 'sal_incpct'

                                ) {
                            $("#" + i).numberbox('setValue', v);
                        }


                    } else {
                        $("#" + i).val('');
                    }

                });

                $("#id").val(rowData.id);

                var total = parseInt(rowData.srv_bt) + parseInt(rowData.srv_vat);

                $("#srv_at2").numberbox('setValue', total);
                $("#veh_at2").numberbox('setValue', rowData.veh_at);

                table_grid(ttable, rowData.rsl_inv_no);

                formDisabled();

                if (rowData.cls_date == null || rowData.cls_date == '0000-00-00') {
                    $("#cmdOptional").removeAttr('disabled');
                    $('#cmdOptional').linkbutton('enable');
                    $("#print").linkbutton('disable');
                    $("#screen").linkbutton('disable');
                    $("#closeOn").empty().append('<button type="button" id="cmdClose" title="<?php getCaption("Close"); ?>" class="easyui-linkbutton easyui-tooltip btn btn-success" data-options="iconCls:\'icon-close\'"  onclick="rolesClose()">Close</button>');

                } else {
                    $("#cmdOptional").attr('disabled', true);
                    $('#cmdOptional').linkbutton('disable');
                    $('.cmdEdit').linkbutton('disable');
                    $("#cmdDelete").linkbutton('disable');
                    $("#closeOn").empty().append('<button type="button" id="cmdUnClose" title="<?php getCaption("unClose"); ?>" class="easyui-linkbutton easyui-tooltip btn btn-success" data-options="iconCls:\'icon-unclose\'" onclick="rolesUnclose()">Unclose</button>');

                    $("#print").removeAttr('disabled')
                    $("#print").linkbutton('enable');
                    $("#screen").removeAttr('disabled')
                    $("#screen").linkbutton('enable');

                    $('#cmdDeleteVSL').attr('disabled', true);
                    $("#cmdDeleteVSL").linkbutton('disable');
                }

                $('.easyui-linkbutton').linkbutton();

                $('.loader').hide();
            } else {
                cmdcondAwal();
                formDisabled();

                $('.cmdEdit').linkbutton('disable');
                $('.cmdDelete').linkbutton('disable');
                $('.loader').hide();


                $("#cmdOptional").attr('disabled', true);
                $('#cmdOptional').linkbutton('disable');

            }

            $('.loader').hide();
        });
    }

    function doSearch() {
        $("#tableSearch").datagrid('load', {
            field1: $('#rsl_inv_no').val(),
            field3: $('#sal_inv_no').val()
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
        $('#form_validation .easyui-combogrid').combogrid('disable');
        $('#form_validation .easyui-combobox').combobox({disabled: true});
        $('#form_validation .combo-text').removeClass('validatebox-text');
        $('#form_validation .combo-text').removeClass('validatebox-invalid');
        $("#form_validation #srv_disc").attr('disabled', true);
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

        $(".btn-cls").removeAttr('disabled');
        $('.btn-cls').linkbutton('enable');

        $('#cmdDeleteVSL').removeAttr('disabled');
        $("#cmdDeleteVSL").linkbutton('enable');

        $('#cmdSearchVSL').attr('disabled', true);
        $("#cmdSearchVSL").linkbutton('disable');
    }

    function cmdcondReady() {
        //$("#cmdSave").show();
        //$("#cmdCancel").show();
        $('.cmdFirst').attr('disabled', true);
        $('.cmdPrev').attr('disabled', true);
        $('.cmdNext').attr('disabled', true);
        $('.cmdLast').attr('disabled', true);
        $('.cmdSave').removeAttr('disabled');
        $('.cmdCancel').removeAttr('disabled');
        //$("#cmdSave").removeAttr('disabled');
        //$("#cmdCancel").removeAttr('disabled');
        $('.cmdAdd').attr('disabled', true);
        $('.cmdEdit').attr('disabled', true);
        $('.cmdDelete').attr('disabled', true);
        $('.cmdSearch').attr('disabled', true);

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

        $("#form_validation #cmdOptional").linkbutton('disable');
        $("#form_validation #cmdClose").linkbutton('disable');
        $("#form_validation #cmdUnClose").linkbutton('disable');

        $("#cmdDropPick").attr('disabled', true);
        $("#cmdPick").attr('disabled', true);

        $("#cmdDropPick").linkbutton('disable');
        $("#cmdPick").linkbutton('disable');

        $('#cmdSearchVSL').removeAttr('disabled');
        $("#cmdSearchVSL").linkbutton('enable');

        $('#cmdDeleteVSL').attr('disabled', true);
        $("#cmdDeleteVSL").linkbutton('disable');
    }
    function condReady() {
        scrlTop();

        // formaction();
        //$('#sal_inv_no').combogrid('enable');
        $("#due_day, #note, #sal_inv_no").attr('disabled', false);
        $("#due_date, #sal_date").datebox('enable');
        cmdcondReady();
        var rsl_inv_no = $("#rsl_inv_no").val();

        if (rsl_inv_no == '') {
            rsl_inv_no = null;
        }
        table_grid(ttable, rsl_inv_no)
    }

    function condDelete() {
        var id = $("#form_validation #id").val();
        var table = $("#form_validation #table").val();
        $.messager.confirm('Warning', 'Do you really want to delete the selected data?', function (r) {
            if (r) {
                $(".loader").show();
                var url = site_url + 'transaction/vehicle/deleteReturnPenjualan';
                $.post(url, {table: table, id: id}, function (data) {
                    obj = JSON.parse(data);
                    if (obj.success == true) {
                        $("#id").val('');
                        showAlert("Information", obj.message);

                        read_show('');
                        $(".loader").hide();
                        //$('#sal_inv_no').val();
                    } else
                    {
                        $(".loader").hide();
                        showAlert("Error while delete", '<font color="red">' + obj.message + '</font>');
                    }
                    scrlTop();
                });
            } else {
                $('#cmdDelete').linkbutton('enable');
            }
        });
    }
    function condAdd() {
        $(".easyui-datebox").datebox('setValue', '');
        $('.easyui-numberbox').numberbox('setValue', '');
        $('#id').val('');
        $('#form_validation input:text').val('');

        $("#table").val(table);
        $('#form_validation textarea').val("");
        $("#form_validation input:radio").prop("checked", false);

        // $("#rsl_date").datebox('setValue', '<?php echo date('Y-m-d'); ?>');        
        $.post(site_url + 'transaction/vehicle/get_number/VRS', function (num) {
            $("#form_validation #rsl_inv_no").val(num);
        });
          $("#wrhs_code").val('<?php echo $wrhs_input; ?>');
        condReady();

    }

    function condCancel() {
        read_show('');
    }

    function condEdit() {
        condReady();
    }
    function saveData() {

        var sal_inv_no = $("#sal_inv_no").val();
        var stat = true;

        if (sal_inv_no == '') {
            msg = 'Please choose a sales invoice no.';
            stat = false;
        }

        if (stat !== false) {
            $('#form_validation :input').attr('disabled', false);
            $(".loader").show();
            form.form('submit', {
                url: save_url,
                onSubmit: function () {
                    return $(this).form('validate');
                },
                success: function (data) {  

                    var obj = JSON.parse(data);
                    if (obj.success == true) {
                        showAlert("Information", obj.message);
                        read_show('');
                        $(".loader").hide();
                    } else
                    {
                        formDisabled();
                        updateFailed(obj);

                        if (obj.status == 'exist') {
                            $("#id").val(obj.inv_no_id);
                            read_show('');
                        }
                    }
                    scrlTop();

                }
            });

        } else {
            $(".loader").hide();
            showAlert("Error while saving", '<font color="red">' + msg + '</font>');
        }
    }
    function emptyForm() {
        $('#form_validation input:text').val('');
        $('#form_validation textarea').val('');
        $('#form_validation .easyui-combogrid').combogrid('setValue', '');
        $("#form_validation input:radio").prop("checked", false);
        $(".easyui-datebox").datebox('setValue', '');
        $('#form_validation .easyui-numberbox').numberbox('setValue', '');
    }

    function table_grid(ttable, rsl_inv_no) {
        ttable.datagrid({
            method: 'post',
            url: site_url + '<?php echo 'builder/datagrid/' . encrypt_decrypt('encrypt', 'veh_rsld'); ?>/rsl_inv_no/' + rsl_inv_no + '/?grid=true',
            title: 'Service Description',
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
                    {field: 'wk_code', title: '<?php getCaption("Kode Pekerjaan"); ?>', width: 120, height: 20, sortable: true},
                    {field: 'wk_desc', title: '<?php getCaption("Nama Pekerjaan"); ?>', width: 350, height: 20, sortable: true},
                    {field: 'price_bd', title: '<?php getCaption("Harga Jual"); ?>', width: 120, height: 20, align: 'right', sortable: true, formatter: formatNumber},
                    {field: 'disc_pct', title: '<?php getCaption("Diskon"); ?> %', width: 120, height: 20, align: 'right', sortable: true, formatter: formatNumber},
                    {field: 'disc_val', title: '<?php getCaption("Jumlah Diskon"); ?>', width: 120, height: 20, align: 'right', sortable: true, formatter: formatNumber},
                    {field: 'price_ad', title: '<?php getCaption("Harga Netto"); ?>', width: 120, height: 20, align: 'right', sortable: true, formatter: formatNumber},
                    {field: 'add_by', title: '<?php getCaption("Ditambahkan Oleh"); ?>', width: 100, height: 20, align: 'right', sortable: true}

                ]]
        });
    }

    function closeBtn() {
        $.messager.confirm('Closing  Invoice', 'Close This invoice? ', function (r) {
            if (r) {
                var id = $("#id").val();
                var chassis = $("#chassis").val();
                var due_date = $("#due_date").val();
                var due_day = $("#due_day").val();

                var stat = true;

                if (due_date == '') {
                    msg = 'TOP counted from today';
                    stat = false;
                }
                if (due_day == '') {
                    msg = 'TOP counted from today';
                    stat = false;
                }
                if (chassis == '') {
                    msg = 'Chassis no. not found';
                    stat = false;
                }
                if (stat !== false) {

                    $.post(close_url, {table: table, id: id}, function (data) {

                        obj = JSON.parse(data);
                        if (obj.success == true) {

                            showAlert("Information", obj.message);
                            read_show('');
                        } else
                        {
                            showAlert("Error while closing", '<font color="red">' + obj.message + '</font>');
                        }
                        scrlTop();
                    });

                } else {
                    showAlert("Error while closing", '<font color="red">' + msg + '</font>');
                }

            }
            read_show('');
        });

    }

    function UncloseBtn() {
        $.messager.confirm('Unclosing Invoice', 'Unclose this Invoice?', function (r) {
            if (r) {

                var id = $("#id").val();
                $.post(unclose_url, {table: table, id: id}, function (data) {

                    obj = JSON.parse(data);
                    if (obj.success == true) {

                        showAlert("Information", obj.message);
                        read_show('');
                    } else
                    {
                        showAlert("Error while closing", '<font color="red">' + obj.message + '</font>');
                    }
                    scrlTop();
                });

            }
            read_show('');

        });

    }

    /*-- Optional --*/
    function cmdOptionals() {
        var rsl_inv_no = $("#form_validation #rsl_inv_no").val();

        $("#optionalWindow").window('open');
        tableId2();
        read_show2('');
        table_grid(ttables, rsl_inv_no);

    }

    function optionalSale() {
        var sal_inv_no = $("#form_validation #sal_inv_no").val();
        $("#form_validation2 #wk_code").combogrid({
            method: 'get',
            url: site_url + '<?php echo 'builder/combogrid/' . encrypt_decrypt('encrypt', 'veh_sld'); ?>/sal_inv_no/' + sal_inv_no + '/?grid=true',
            idField: 'wk_code',
            textField: 'wk_code',
            panelWidth: 500,
            panelHeight: 200,
            fitColumns: false,
            fit: false,
            mode: 'remote',
            pagination: true,
            remoteSort: true,
            multiSort: true,
            required: false,
            loadMsg: 'Please wait...',
            columns: [[
                    {field: 'wk_code', title: '<?php getCaption("Kode Pekerjaan"); ?>', width: 150, height: 20, sortable: true},
                    {field: 'wk_desc', title: '<?php getCaption("Nama Pekerjaan"); ?>', width: 200, height: 20, sortable: true},
                    {field: 'price_bd', title: '<?php getCaption("Harga Jual"); ?>', width: 120, height: 20, align: 'right', sortable: true, formatter: formatNumber},
                    {field: 'disc_pct', title: '<?php getCaption("Diskon"); ?> %', width: 120, height: 20, align: 'right', sortable: true, formatter: formatNumber},
                    {field: 'disc_val', title: '<?php getCaption("Jumlah Diskon"); ?>', width: 120, height: 20, align: 'right', sortable: true, formatter: formatNumber},
                    {field: 'price_ad', title: '<?php getCaption("Harga Netto"); ?>', width: 120, height: 20, align: 'right', sortable: true, formatter: formatNumber}

                ]]
        });

        $('#form_validation2 #wk_code').combogrid({
            onSelect: function (index, row) {
                $('#wk_code').val(row.wk_code);
                $('#wk_desc').val(row.wk_desc);
                $('#price_bd').numberbox('setValue', row.price_bd);
                /*
                 
                 var disc = $('#form_validation2 #disc_pct').numberbox('getValue');  
                 var harga = row.price_bd;
                 var jml_disc = (harga / 100) * disc;
                 
                 var total = harga - jml_disc;
                 */
                $('#form_validation2 #disc_pct').numberbox('setValue', row.disc_pct);
                $('#form_validation2 #disc_val').numberbox('setValue', row.disc_val);
                $('#form_validation2 #price_ad').numberbox('setValue', row.price_ad);

            }
        });
    }
    function tableId2() {
        divtableId2.empty().append('<input type="hidden" name="id2"  id="id2"><input type="hidden" name="table2"  id="table2" value="' + table2 + '">');
    }

    function read_show2(nav) {
        var id = $("#id2").val();
        var rsl_inv_no = $("#form_validation #rsl_inv_no").val();

        $.post(site_url + 'crud/read/?rsl_inv_no=' + rsl_inv_no, {table: table2, nav: nav, id: id}, function (json) { //alert(json)

            $("#form_validation2 :input").val('');
            if (json !== '[]') {

                var rowData = $.parseJSON(json); //alert(rowData.price_bd)
                $('#form_validation2').form('load', {
                    wk_code: rowData.wk_code,
                    wk_desc: rowData.wk_desc,
                    price_bd: rowData.price_bd,
                    disc_pct: rowData.disc_pct,
                    disc_val: rowData.disc_val,
                    price_ad: rowData.price_ad
                });
                $("#id2").val(rowData.id);
            }
            formDisabled2();

        });
    }

    function saveData2() {
        var rsl_inv_no = $("#rsl_inv_no").val();
        var save_url2 = site_url + 'transaction/vehicle/save_rsld/' + rsl_inv_no + '/<?php echo $_SESSION['C_USER']; ?>';
        $('#form_validation2 :input').attr('disabled', false);
        $("#form_validation2").form('submit', {
            url: save_url2,
            onSubmit: function () {
                return $(this).form('validate');
            }, success: function (data) {

                var obj = JSON.parse(data);

                if (obj.success == true) {
                    //showAlert("Information", obj.message);
                    cmdcondAwal2();
                    formDisabled2();


                    table_grid(ttables, rsl_inv_no);
                    table_grid(ttable, rsl_inv_no);

                    $("#id2").val('');
                    read_show2('');
                    read_show('');
                } else
                {
                    showAlert("Error while saving", '<font color="red">' + obj.message + '</font>');
                    cmdcondAwal2();
                    formDisabled2();

                    $("#id2").val('');
                    read_show2('');
                }
            }
        });
    }

    function condDelete2() {
        var id = $("#id2").val();
        var table = 'veh_rsld';
        var rsl_inv_no = $("#rsl_inv_no").val();

        $.messager.confirm('Warning', 'Do you really want to delete the selected data?', function (r) {
            if (r) {
                var url = site_url + 'transaction/vehicle/deleteOptionalrsld';
                $.post(url, {table: table, id: id, rsl_inv_no: rsl_inv_no}, function (data) {

                    obj = JSON.parse(data);
                    if (obj.success == true) {
                        // showAlert("Information", obj.message);
                        $("#id2").val('');
                        cmdcondAwal2();
                        read_show2('');
                        read_show('');
                        table_grid(ttables, rsl_inv_no);
                        table_grid(ttable, rsl_inv_no);
                    } else
                    {
                        showAlert("Error while deleting", '<font color="red">' + obj.message + '</font>');
                    }
                });
            }
        });
    }


    function condCancel2() {
        cmdcondAwal2();
        read_show2('');
        $("#form_validation2 .formError").remove();
    }

    function formDisabled2() {
        //$(':input').attr('disabled', true);
        $('#form_validation2 #wk_code').attr('disabled', true);
        $('#form_validation2 #wk_desc').attr('disabled', true);
        $('#form_validation2 #price_bd').attr('disabled', true);
        $('#form_validation2 #disc_pct').attr('disabled', true);
        $('#form_validation2 #disc_val').attr('disabled', true);
        $('#form_validation2 #price_ad').attr('disabled', true);

        $('#form_validation2 .easyui-combogrid').combogrid('disable');
        $('#form_validation2 .easyui-combobox').combobox({disabled: true});
        $('#form_validation2 .combo-text').removeClass('validatebox-text');
        $('#form_validation2 .combo-text').removeClass('validatebox-invalid');
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

    }
    function condReady2() {
        $('#form_validation2 #wk_code').attr('disabled', false);
        $('#form_validation2 #wk_desc').attr('disabled', false);
        $('#form_validation2 #price_bd').attr('disabled', false);
        $('#form_validation2 #disc_pct').attr('disabled', false);
        $('#form_validation2 #disc_val').attr('disabled', false);
        //$('#form_validation2 #price_ad').attr('disabled', false);

        $('#form_validation2 .easyui-combogrid').combogrid('enable');
        $('#form_validation2 .easyui-combobox').combobox({disabled: false});
        $('#form_validation2 #wk_code').focus();
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
    }
    function condAdd2() { 
        //optionalSale();
        $('#form_validation2 .combo-text').val('');
        $('#form_validation2 #id2').val('');
        $('#form_validation2 #wk_code').val('');
        $('#form_validation2 #wk_desc').val('');
        $('#form_validation2 #price_bd').val('');
        $('#form_validation2 #disc_pct').val('');
        $('#form_validation2 #disc_val').val('');
        $('#form_validation2 #price_ad').val('');
        $("#form_validation2 #table2").val(table2);
        condReady2();

        $('#form_validation2 #disc_pct').keyup(function () {
            var disc = $(this).val();
            var harga = parseCurrency($('#form_validation2 #price_bd').val());
            var jml_disc = (parseCurrency($('#form_validation2 #price_bd').val()) / 100) * disc;

            if (parseInt(jml_disc) > parseInt(harga)) {
                $.messager.alert('Warning', 'Discount value has to be lower than Sale Price', 'warning');
                $(this).val('');
            } else {
                var total = harga - jml_disc;
                $('#form_validation2 #disc_val').numberbox('setValue', jml_disc);
                $('#form_validation2 #price_ad').numberbox('setValue', total);
            }
        });

        $('#form_validation2 #disc_val').keyup(function () {
            var jml_disc = parseCurrency($(this).val());
            var harga = parseCurrency($('#form_validation2 #price_bd').val());
            if (parseInt(jml_disc) > parseInt(harga)) {
                $.messager.alert('Warning', 'Discount value has to be lower than Sale Price', 'warning');
                $('#form_validation2 #disc_val').numberbox('setValue', '0');

            } else {
                var disc = (jml_disc * 100) / harga;
                var total = harga - jml_disc;

                $('#form_validation2 #disc_pct').val(disc);
                $('#form_validation2 #price_ad').numberbox('setValue', total);
            }
        });
    }

    function parseCurrency(num) {
        // return parseFloat(num.replace(/[^0-9\.-]+/g,""));
        // return parseFloat(num.replace(/[^0-9\.-]+/g,""));
        return num.replace(/[^0-9]/g, '');
    }
    function condEdit2() {
        showAlert("Error", '<font color="red">Sorry, this optional detail can’t be edited</font>');
    }

    function print_sc(action) {

        var id = $("#id").val();
        var user = '<?php echo $_SESSION['C_USER']; ?>';

        var url = site_url + 'transaction/vehicle/outputpdf/<?php echo encrypt_decrypt('encrypt', 'veh_rslh'); ?>/' + id + '/' + user + '/' + action + '#toolbar=0';

        if (action == 'screen') {
            //$('#sr').window('open');
            //$('#sr').empty().append('<iframe   frameborder="0"  src="' + url + '" style="width:100%;height:auto;min-height: 500px;padding:0px;"></iframe>');
            window.open(url);

        } else {
            $('#sr').empty().append('<iframe   frameborder="0"  src="' + url + '" style="width:100%;height:auto;min-height: 500px;padding:0px;"></iframe>');
        }
    }

    function condFindVSL() {
        var sal_inv_no = $("#sal_inv_no").val();
        var sal_date = $("#sal_date").datebox('getValue');

        stat = true;

        if (sal_date == '') {
            stat = false;
            msg = 'Please enter Sales Date';
        }
        if (sal_inv_no == '') {
            stat = false;
            msg = 'Please enter Sales Invoice No.';
        }

        if (stat !== false) {
            var url = "services/runCRUD.php?func=finddata&lookup=trx/veh_rslh&pk=sal_inv_no&sk=rsl_inv_no";
            $.post(url, {sal_inv_no: sal_inv_no, sal_date: sal_date}, function (json) { 
                if (json !== '[]') {

                    var rows = $.parseJSON(json);

                    if (rows.status !== false) {

                        var rowData = rows.data;

                        $('#form_validation .cust_sex_' + rowData.cust_sex).prop("checked", true);
                        $('#form_validation .cust_type_' + rowData.cust_type).prop("checked", true);
                        $('#form_validation .cust_rsex_' + rowData.cust_rsex).prop("checked", true);
                        $('#form_validation .srep_sex_' + rowData.srep_sex).prop("checked", true);

                        $('#form_validation .sal_inctyp_' + rowData.sal_inctyp).prop("checked", true);
                        $('#form_validation .kwit_data_' + rowData.kwit_data).prop("checked", true);
                        $('#form_validation .fp_data_' + rowData.fp_data).prop("checked", true);

                        $.each(rowData, function (i, v) {
                            if (v !== '') {

                                if (i !== 'id') {
                                    $("#form_validation #" + i).val(v);


                                    if (
                                            i == 'cust_name' ||
                                            i == 'srep_name' ||
                                            i == 'cust_area' ||
                                            i == 'cust_city' ||
                                            i == 'cust_rarea' ||
                                            i == 'cust_rcity') {

                                        $("#form_validation #" + i).combogrid('setValue', v);
                                    }

                                    if (
                                            i == 'fp_date' ||
                                            i == 'rsl_date' ||
                                            i == 'due_date' ||
                                            i == 'sal_date' ||
                                            i == 'stnk_bdate' ||
                                            i == 'stnk_edate' ||
                                            i == 'so_date' ||
                                            i == 'sj_date' ||
                                            i == 'kwit_date'
                                            ) {
                                        if (v !== '0000-00-00') {
                                            var vdate = dateSplit(v);
                                            $("#form_validation #" + i).datebox('setValue', vdate);
                                        }
                                    }

                                    if (
                                            i == 'veh_price'
                                            || i == 'veh_disc'
                                            || i == 'veh_at'
                                            || i == 'veh_bbn'
                                            || i == 'veh_misc'
                                            || i == 'veh_total'
                                            || i == 'srv_at'
                                            || i == 'part_at'
                                            || i == 'inv_stamp'
                                            || i == 'inv_total'
                                            || i == 'veh_pbm'
                                            || i == 'veh_bt'
                                            || i == 'veh_vat'


                                            || i == 'srv_price'
                                            || i == 'srv_disc'
                                            || i == 'srv_bt'
                                            || i == 'srv_vat'
                                            || i == 'due_day'
                                            || i == 'cust_zipc'
                                            || i == 'cust_rzipc'


                                            || i == 'sal_incpnt'
                                            || i == 'sal_incpct'

                                            ) {
                                        $("#form_validation #" + i).numberbox('setValue', v);
                                    }

                                    if (i == 'id') {
                                        $("#form_validation #" + i).val('');
                                    }
                                }
                            } else {
                                $("#form_validation" + i).val('');
                            }

                        });

                        var total = parseInt(rowData.srv_bt) + parseInt(rowData.srv_vat);

                        $("#srv_at2").numberbox('setValue', total);
                        $("#veh_at2").numberbox('setValue', rowData.veh_at);

                    } else {
                        $.messager.alert('Warning', rows.msg, 'warning');
                    }

                }
            });
        } else {
            $.messager.alert('Warning', msg, 'warning');
        }

    }

    function condDeleteVSL() {
        $.messager.confirm('Warning', 'Do you really want to delete the Sales Invoice No.?', function (r) {
            if (r) {
                var sal_inv_no = $("#sal_inv_no").val();
                var id = $("#id").val();

                $.post(delete_inv_url, {table: table, id: id, sal_inv_no: sal_inv_no}, function (data) {
                    var obj = JSON.parse(data);
                    if (obj.success == true) {
                        read_show('');
                        $(".loader").hide();
                    } else
                    {
                        formDisabled();
                        updateFailed(obj);

                        if (obj.status == 'exist') {
                            $("#id").val(obj.inv_no_id);
                            read_show('');
                        }
                    }
                    scrlTop();
                });

            }

        });

    }
    $(document).ready(function () {
        checkRunMonthYear('VRS');
        tableId();
        dateTop();
        read_show('');
        version('03.17-31');
    });
</script>