<script>

    var table = 'acc_wprh';
    var form = $('#form_validation');
    var save_url = site_url + 'transaction/optional/save_optional/<?php echo $_SESSION['C_USER']; ?>';
    var unclose_url = site_url + 'transaction/optional/unclosePembelian/<?php echo $_SESSION['C_USER']; ?>';
    var close_url = site_url + 'transaction/optional/closePembelian/<?php echo $_SESSION['C_USER']; ?>';
    var delete_url = site_url + 'transaction/optional/delete_optional';

    var divtableId = $("#tableId");
    var ttable = $('#dt');

    var table2 = 'acc_wprd';
    var ttable2 = $('#dt2');
    var divtableId2 = $("#tableId2");

    var cls_date = 'cls2_date';


    function tableId() {
        divtableId.empty().append('<input type="hidden" name="id"  id="id"><input type="hidden" name="table"  id="table" value="' + table + '">');
    }

    function read_show(nav) {
        var id = $("#form_validation #id").val();

        $.post(site_url + 'crud/read', {table: table, nav: nav, id: id}, function (json) { //alert(json)
            $('#form_validation input:text').val('');
            $('#form_validation textarea').val('');
            $('#form_validation .easyui-combogrid').combogrid('setValue', '');
            $(".easyui-datebox").datebox('setValue', '');

            if (json !== '[]') {

                var rowData = $.parseJSON(json);

                $.each(rowData, function (i, v) {
                    $("#form_validation #" + i).val(v);

                    if (i == 'cls2_date' || i == 'pur_date' || i == 'opn_date' || i == 'rcv_date' || i == 'cls_date' || i == 'sj_date' || i == 'supp_invdt' || i == 'wo_date' || i == 'due_date' || i == 'so_date') {
                        if (v !== '0000-00-00') {
                            var v_date = dateSplit(v);
                            $("#form_validation #" + i).datebox('setValue', v_date);
                        }
                    }

                    if (i == 'wrhs_code' || i == 'supp_name' || i == 'wo_no') {
                        $("#form_validation #" + i).combogrid('setValue', v);
                    }


                    if (i == 'tot_item' || i == 'tot_price' || i == 'inv_disc' || i == 'inv_bt' || i == 'inv_vat' || i == 'inv_at' || i == 'inv_stamp' || i == 'inv_total' || i == 'due_day') {
                        $("#form_validation #" + i).numberbox('setValue', v);
                    }

                });

                // $("#form_validation #cls2_date").datebox('setValue', rowData.cls2_date);

                var pur_inv_no = rowData.pur_inv_no;
                table_grid(ttable, pur_inv_no);

                cmdcondAwal();
                formDisabled();

                if (rowData.cls2_date == null || rowData.cls2_date == '0000-00-00' || rowData.cls2_date == '0000-00-00 00:00:00') {
                    $("#cmdDetail").removeAttr('disabled');
                    $('#cmdDetail').linkbutton('enable');
                    $("#closeOn").empty().append('<button type="button" id="cmdClose" title="<?php getCaption("Close"); ?>" class="easyui-linkbutton btn-cls" data-options="iconCls:\'icon-close\'"  onclick="rolesClose()">Close</button>');
                    $("#print").linkbutton('disable');
                    $("#screen").linkbutton('disable');
                    $("#download").linkbutton('disable');

                    $('#cmdClose').linkbutton();

                } else {
                    $("#cmdDetail").attr('disabled', true);
                    $('#cmdDetail').linkbutton('disable');
                    $("#closeOn").empty().append('<button type="button" id="cmdUnClose" title="<?php getCaption("unClose"); ?>" class="easyui-linkbutton btn-cls" data-options="iconCls:\'icon-unclose\'"  onclick="rolesUnclose()">Unclose</button>');

                    $('#cmdUnClose').linkbutton();
                    $("#print").removeAttr('disabled');
                    $("#print").linkbutton('enable');
                    $("#screen").removeAttr('disabled');
                    $("#screen").linkbutton('enable');
                    $("#download").removeAttr('disabled');
                    $("#download").linkbutton('enable');

                    $("#cmdDropPick").attr('disabled', true);
                    $("#cmdPick").attr('disabled', true);

                    $(".btn-pick").linkbutton('disable');
                    $("#cmdEdit").attr('disabled', true);
                    $("#cmdDelete").attr('disabled', true);
                    $("#cmdEdit").linkbutton('disable');
                    $("#cmdDelete").linkbutton('disable');
                }


                $(".loader").hide();
            } else {
                cmdcondAwal();
                formDisabled();
                $("#cmdEdit").attr('disabled', true);
                $("#cmdDelete").attr('disabled', true);
                $("#cmdEdit").linkbutton('disable');
                $("#cmdDelete").linkbutton('disable');
                $(".loader").hide();
            }
            $("#form_validation #inv_type").val('<?php echo $remark; ?>');

        });
    }

    function doSearch() {
        $("#tableSearch").datagrid('load', {
            field1: $('#pur_inv_no2').val(),
            field2: $('#pur_date2').datebox('getValue')
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


    function print_sc(key) {
        var ids = $("#form_validation #id").val();
        var url = site_url + 'transaction/optional/outputpdf/<?php echo encrypt_decrypt('encrypt', 'acc_wprh'); ?>/' + ids + '/<?php echo $_SESSION['C_USER']; ?>/' + key + '/<?php echo encrypt_decrypt('encrypt', 'pur_inv_no'); ?>/<?php echo encrypt_decrypt('encrypt', 'APW'); ?>/pembelian#toolbar=0';

        if (key == 'print') {
            $("#screenWindow").empty().append('<iframe frameborder="0"  src="' + url + '" style="width:100%;height:auto;min-height: 500px;padding:0px;"></iframe>');
            // $("#screenWindow").window('open');
        }

        if (key == 'screen') {
            window.open(url);
        }

        if (key == 'download') {
            $("#screenWindow").empty().append('<iframe frameborder="0"  src="' + url + '" style="width:100%;height:auto;min-height: 500px;padding:0px;"></iframe>');
            // $("#screenWindow").window('open');
        }

    }


    function table_grid(ttable, pur_inv_no) {
        ttable.datagrid({
            method: 'post',
            url: site_url + '<?php echo 'builder/datagrid/' . encrypt_decrypt('encrypt', 'acc_wprd'); ?>/pur_inv_no/' + pur_inv_no + '/?grid=true',
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
                    {field: 'wk_desc', title: '<?php getCaption("Nama Pekerjaan"); ?>', width: 360, height: 20, sortable: true},
                    {field: 'price_bd', title: '<?php getCaption("Harga"); ?>', width: 120, height: 20, sortable: true, align: 'right', formatter: formatNumber},
                    {field: 'disc_pct', title: '<?php getCaption("Diskon"); ?> %', width: 120, height: 20, sortable: true, align: 'right', formatter: formatNumber},
                    {field: 'disc_val', title: '<?php getCaption("Jumlah Diskon"); ?>', width: 120, height: 20, sortable: true, align: 'right', formatter: formatNumber},
                    {field: 'price_ad', title: '<?php getCaption("Harga Netto"); ?>', width: 120, height: 20, sortable: true, align: 'right', formatter: formatNumber},
                    {field: 'wo_no', title: '<?php getCaption("No. WO"); ?>', width: 150, height: 20, sortable: true},
                    {field: 'wo_date', title: '<?php getCaption("Tgl. WO"); ?>', width: 150, height: 20, sortable: true, formatter: formatDate},
                    {field: 'sal_inv_no', title: '<?php getCaption("Faktur Jual"); ?>', width: 150, height: 20, sortable: true},
                    {field: 'prep_code', title: '<?php getCaption("Purchaser"); ?>', width: 100, height: 20, sortable: true},
                    {field: 'add_by', title: '<?php getCaption("Ditambahkan Oleh"); ?>', width: 100, height: 20, sortable: true},
                ]]
        });


    }

    function condDeleteWO() {
        $.messager.confirm('Message', 'Do you really want to delete this WO No.?', function (r) {
            if (r) {

                var pur_inv_no = $("#pur_inv_no").val();
                var wo_no = $("#wo_no").combobox('getValue');
                var id = $("#id").val();

                if (wo_no !== '') {
                    $.post(site_url + 'transaction/optional/checkWO', {pur_inv_no: pur_inv_no, wo_no: wo_no}, function (res) {
                        var json = $.parseJSON(res);

                        if (json.count > 0) {
                            showAlert("Information", '<font color="red">No. WO ada detailnya, Hapus Detailnya</font>');
                        } else {
                            $.post(site_url + 'transaction/optional/deleteNoWO', {id: id}, function (data) {
                                var obj = $.parseJSON(data);
                                if (obj.success == true) {
                                    read_show('');

                                } else
                                {
                                    showAlert("Error while saving", '<font color="red">' + obj.message + '</font>');
                                    condReady();
                                }
                            });
                        }
                    });
                } else {
                    showAlert("Information", '<font color="red">Please select a WO No. to be deleted</font>');
                }
            }
        });
    }
    function formDisabled() {
        $('#form_validation :input').attr('disabled', true);
        $('#form_validation .easyui-combogrid').combogrid('disable');
        $('#form_validation .easyui-combobox').combobox({disabled: true});
        $('#form_validation .combo-text').removeClass('validatebox-text');
        $('#form_validation .combo-text').removeClass('validatebox-invalid');

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

    }

    function condReady() {
        scrlTop();
        $('#form_validation :input').attr('disabled', false);
        $('#form_validation .easyui-combogrid').combogrid('enable');
        $('#form_validation .easyui-combobox').combobox({disabled: false});

        $("#form_validation #inv_type").val('<?php echo $remark; ?>');
        var pur_inv_no = $("#form_validation #pur_inv_no").val();

        if (pur_inv_no == '') {
            pur_inv_no = null;
        }
        table_grid(ttable, pur_inv_no);

        $('#form_validation #opn_date,#cls2_date, #pur_date, #rcv_date, #so_date, #wo_date').datebox('disable');
        //$("#form_validation #pur_inv_no, #tot_item, #dept_code, #dunit_code, #due_day, #tot_qty, #supp_code, #inv_type").attr('disabled', true);

        $("#form_validation #inv_type, #pur_inv_no, #supp_code, #tot_item").attr('disabled', true);
        $("#form_validation #tot_qty, #tot_price, #inv_bt, #inv_vat, #inv_at, #inv_total").numberbox('disable');
        $("#form_validation #chassis, #engine, #veh_type, #veh_model, #veh_code, #veh_name, #color_code, #color_name, #so_no, #so_date, #veh_transm, #veh_year, #srep_name, #sal_inv_no").attr('disabled', true);

        cmdcondReady();
        detail_price();

        var wo_no = $("#wo_no").combogrid('getValue');

        if (wo_no !== '') {
            $("#supp_name").combogrid('disable');
            $("#wo_no").combogrid('disable');
            $("#cmdDeleteWO").linkbutton('enable');
        } else {
            $("#wo_no").combogrid('enable');
            $("#supp_name").combogrid('enable');
        }
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

        $("#form_validation #cmdClose").linkbutton('disable');
        $("#form_validation #cmdDetail").linkbutton('disable');
        $("#form_validation #cmdClose").linkbutton('disable');
        $("#form_validation #cmdUnClose").linkbutton('disable');
        $("#form_validation #screen").linkbutton('disable');
        $("#form_validation #print").linkbutton('disable');
    }

    function condAdd() {
        $('.easyui-numberbox').numberbox('setValue', '');
        $(".easyui-datebox").datebox('enable');
        $('#form_validation #id').val('');
        $('#form_validation input:text').val('');
        $("#form_validation #table").val(table);
        $('#form_validation .easyui-combogrid').combogrid('setValue', '');
        $(".easyui-datebox").datebox('setValue', '');
        $('#form_validation #opn_date').datebox('setValue', '<?php echo date('Y-m-d'); ?>');

        $.post(site_url + 'transaction/cashier/get_number/APR', function (num) {
            $("#form_validation #pur_inv_no").val(num);
        });
        condReady();

        woNew(0)

    }
    $('#form_validation #supp_name').combogrid({
        onSelect: function (index, row) {
            $('#form_validation #supp_code').val(row.supp_code);
            woNew(row.supp_code);
        }
    });

    function detail_price() {
        $("#form_validation #inv_disc").keyup(function () {
            var inv_disc = parseCurrency($(this).val());
            var tot_price = parseCurrency($("#form_validation #tot_price").val());
            var inv_stamp = parseCurrency($("#form_validation #inv_stamp").val());

            count_price(inv_disc, tot_price, inv_stamp);
        });

        $("#form_validation #inv_stamp").keyup(function () {
            var inv_disc = parseCurrency($("#form_validation #inv_disc").val());
            var tot_price = parseCurrency($("#form_validation #tot_price").val());
            var inv_stamp = parseCurrency($(this).val());
            count_price(inv_disc, tot_price, inv_stamp);
        });
    }
    function count_price(inv_disc, tot_price, inv_stamp) {
        var total_bt = tot_price - inv_disc;
        var vat = total_bt / 10;
        var total = total_bt + vat;
        var inv_total = total + parseInt(inv_stamp);

        $("#form_validation #inv_bt").numberbox('setValue', total_bt);
        $("#form_validation #inv_vat").numberbox('setValue', vat);
        $("#form_validation #inv_at").numberbox('setValue', total);
        $("#form_validation #inv_total").numberbox('setValue', inv_total);
    }
    function woNew(supp_code) {
        //alert(site_url + '<?php echo 'builder/combogrid/' . encrypt_decrypt('encrypt', 'acc_woh'); ?>/supp_code/' + supp_code + '/?grid=true')
        $("#wo_no").combogrid({
            method: 'post',
            url: site_url + '<?php echo 'builder/combogrid/' . encrypt_decrypt('encrypt', 'acc_woh'); ?>/supp_code/' + supp_code + '/?grid=true',
            idField: 'wo_no',
            textField: 'wo_no',
            panelWidth: 500,
            panelHeight: 340,
            fitColumns: false,
            mode: 'remote',
            pagination: true,
            remoteSort: true,
            multiSort: true,
            required: false,
            loadMsg: 'Please wait...',
            columns: [[
                    {field: 'wo_date', title: '<?php getCaption('Tgl. WO'); ?>', width: 120, formatter: formatDate},
                    {field: 'wo_no', title: '<?php getCaption('No. WO'); ?>', width: 150},
                    {field: 'supp_code', title: '<?php getCaption('Kode Supplier'); ?>', width: 150},
                    {field: 'supp_name', title: '<?php getCaption('Nama Supplier'); ?>', width: 150}
                ]]
        });
        //$("#wo_no").combogrid('reload');
        $('#form_validation #wo_no').combogrid({
            onSelect: function (index, rowData) {

                $.each(rowData, function (i, v) {

                    if (i == 'chassis' || i == 'veh_transm' || i == 'veh_year' || i == 'srep_name' || i == 'sal_inv_no' || i == 'so_no' || i == 'color_code' || i == 'color_name' || i == 'veh_code' || i == 'veh_name' || i == 'veh_model' || i == 'veh_type' || i == 'engine') {
                        $("#form_validation #" + i).val(v);
                    }

                    if (i == 'so_date' || i == 'wo_date') {
                        if (v !== '0000-00-00') {
                            var v_date = dateSplit(v);
                            $("#form_validation #" + i).datebox('setValue', v_date);
                        }

                    }


                });

            }
        });
    }
    function condEdit() {
        $(".easyui-datebox").datebox('enable');
        var supp_code = $("#supp_code").val();
        var wo_no = $('#wo_no').combogrid('getValue');
        $('#wo_no').combogrid('setValue', wo_no);
        condReady();
        poNew(supp_code);


    }
    function condDelete() {
        var id = $("#form_validation #id").val();
        var table = $("#form_validation #table").val();
        $.messager.confirm('Warning', 'Do you really want to delete this record?', function (r) {
            if (r) {
                $('.loader').show();
                var url = delete_url;
                $.post(url, {table: table, id: id}, function (data) {
                    obj = JSON.parse(data);

                    if (obj.success == true) {
                        read_show('P');
                        showAlert("Information", obj.message);

                    } else
                    {
                        showAlert("Error while deleting", '<font color="red">' + obj.message + '</font>');
                        read_show('');
                        $('.loader').hide();
                    }
                    scrlTop();
                });
            } else {
                $('#cmdDelete').linkbutton('enable');
            }
        });
    }
    function condCancel() {
        cmdcondAwal();
        read_show('');
        $(".formError").remove();
        $(".easyui-datebox").datebox('disable');
    }

    function closeBtn() {
        $.messager.confirm('Closing invoice', 'Close this invoice?', function (r) {
            if (r) {
                $('.loader').show();
                $('#form_validation :input').attr('disabled', false);

                form.form('submit', {
                    url: close_url,
                    onSubmit: function () {
                        return $(this).form('validate');
                    },
                    success: function (data) {

                        var obj = JSON.parse(data);
                        if (obj.success == true) {
                            //showAlert("Information", obj.message);
                            read_show('');
                        } else
                        {
                            read_show('');
                            showAlert("Error while closing", '<font color="red">' + obj.message + '</font>');
                            $('.loader').hide();
                        }
                        scrlTop();
                    }
                });
            }
            read_show('');
            //$('#form_validation :input').attr('disabled', true);
        });


    }
    function UncloseBtn() {
        $.messager.confirm('Unclosing invoice', 'Unclose this invoice?', function (r) {
            if (r) {
                $('.loader').show();
                $('#form_validation :input').attr('disabled', false);
                form.form('submit', {
                    url: unclose_url,
                    onSubmit: function () {
                        return $(this).form('validate');
                    },
                    success: function (data) {

                        var obj = JSON.parse(data);
                        if (obj.success == true) {
                            // showAlert("Information", obj.message);
                            read_show('');
                        } else
                        {
                            read_show('');
                            showAlert("Error while saving", '<font color="red">' + obj.message + '</font>');
                            $('.loader').hide();
                        }
                        scrlTop();
                    }
                });
            }
            read_show('');
        });

    }
    function saveData() {
        $('.loader').show();
        $('#form_validation :input').attr('disabled', false);
        form.form('submit', {
            url: save_url,
            onSubmit: function () {
                return $(this).form('validate');
            },
            success: function (data) {

                var obj = JSON.parse(data);
                if (obj.success == true) {
                    showAlert("Information", obj.message);

                    if (obj.status == 'update') {
                        read_show('');
                    } else {
                        read_show('');
                        //cmdDetails();
                    }

                } else
                {
                    updateFailed(obj);
                }

                scrlTop();
            }
        });
    }

    /* Detail */
    function cmdDetails() {
        scrlTop();
        var pur_inv_no = $("#form_validation #pur_inv_no").val();

        $.post(site_url + 'transaction/optional/check_wprh', {table: table, pur_inv_no: pur_inv_no}, function (res) {
            var json = $.parseJSON(res);

            if (json.success !== false) {
                tableId2();
                read_show2('');

                table_grid(ttable2, pur_inv_no);
                $("#DetailWindow").window('open');

                var wo_no = $("#wo_no").combogrid('getValue');
                wood(wo_no)
            } else {
                showAlert("Error while saving", '<font color="red">' + json.message + '</font>');
            }

        });

    }



    function read_show2(nav) {
        var id = $("#id2").val();
        var pur_inv_no = $("#form_validation #pur_inv_no").val();

        $.post(site_url + 'crud/read/?pur_inv_no=' + pur_inv_no, {table: table2, nav: nav, id: id}, function (json) {

            $("#form_validation2 :input").val('');
            $("#form_validation2 .easyui-numberbox").numberbox('setValue', '');
            if (json !== '[]') {

                var rowData = $.parseJSON(json);

                $.each(rowData, function (i, v) {
                    $("#form_validation2 #" + i).val(v);


                    if (i == 'price_bd' || i == 'disc_pct' || i == 'disc_val' || i == 'price_ad') {
                        $("#form_validation2 #" + i).numberbox('setValue', v);
                    }

                    if (i == 'wk_code') {
                        $("#form_validation2 #" + i).combogrid('setValue', v);
                    }
                    if (i == 'wo_date') {
                        if (v !== '0000-00-00') {
                            var v_date = dateSplit(v);
                            $("#form_validation2 #" + i).datebox('setValue', v_date);
                        }
                    }
                });
                // price_disc(rowData.qty, '', '');
                $("#id2").val(rowData.id);


            }

            table_grid(ttable2, pur_inv_no);
            formDisabled2();
            cmdcondAwal2();

        });
    }

    function saveData2() {
        $('#cmdSave2').linkbutton('disable');
        var pur_inv_no = $("#form_validation #pur_inv_no").val();

        var save_url2 = site_url + 'transaction/optional/save_wprd/' + pur_inv_no + '/<?php echo $_SESSION['C_USER']; ?>/pembelian';
        $('.loader').show();
        $('#form_validation2 :input').attr('disabled', false);

        $("#form_validation2").form('submit', {
            url: save_url2,
            onSubmit: function () {
                return $(this).form('validate');
            },
            success: function (data) { alert(data)

                var obj = JSON.parse(data);

                if (obj.success !== false) {

                    $("#id2").val('');

                    read_show2('');
                    read_show('');
                } else
                {

                    showAlert("Error", '<font color="red">' + obj.message + '</font>');
                    $('#cmdSave2').linkbutton('enable');
                    $('.loader').hide();
                }
            }
        });
    }

    function condDelete2() {
        var pur_inv_no = $("#form_validation #pur_inv_no").val();
        var id = $("#id2").val();

        $.messager.confirm('Delete Confirmation', 'Do you really want to delete this record?', function (r) {
            if (r) {
                var url = site_url + 'transaction/optional/delete_wprd';
                $.post(url, {table: table2, id: id}, function (data) {
                    obj = JSON.parse(data);
                    if (obj.status !== false) {
                        $("#id2").val('');
                        read_show2('');
                        read_show('');

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
        $('#form_validation2 :input').attr('disabled', true);

        $('#form_validation2 .easyui-combogrid').combogrid('disable');
        $('#form_validation2 .easyui-combobox').combobox({disabled: true});
        $('#form_validation2 .combo-text').removeClass('validatebox-text');
        $('#form_validation2 .combo-text').removeClass('validatebox-invalid');
        cmdcondAwal2();
        $('#form_validation2 #ok').removeAttr('disabled');
        $('#form_validation2 #ok').linkbutton('enable');
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
        $('#form_validation2 #table2').val(table2);
        $('#form_validation2 #table2').val(table2);
        $('#form_validation2 #wk_code').combogrid('enable');
        $('#form_validation2 #wk_desc').attr('disabled', false);

        $("#price_bd, #disc_pct, #disc_val, #price_ad").numberbox({disabled: false});

        cmdcondAwal2();
        cmdcondReady2();

        $("#qty").keyup(function () {
            var qty = parseCurrency($(this).val());

            price_disc(qty, '', '');
        });

        $("#price_bd").keyup(function () {
            var price_bd = parseCurrency($(this).val());

            price_disc(price_bd, '');
        });

        $("#disc_pct").keyup(function () {
            var disc_pct = $(this).val();

            price_disc('', disc_pct);
        });

        $("#disc_val").keyup(function () {
            var disc_val = parseCurrency($(this).val());

            disc_keyValue(disc_val);
        });

        $("#price_ad").keyup(function () {
            var price_ad = parseCurrency($(this).val());
            total_key(price_ad);
        });
    }

    function total_key(price_ad) {
        price_bd = $("#price_bd").numberbox('getValue');

        if (price_ad > price_bd) {
            $.messager.alert('Warning', 'Discount value has to be lower than or equal to Unit Price', 'warning')
            price_disc('', '0');
        } else {
            disc_val = price_bd - price_ad;
            var disc_pct = (disc_val / price_bd) * 100;

            $("#disc_pct").numberbox('setValue', disc_pct);
            $("#disc_val").numberbox('setValue', disc_val);
        }

    }
    function disc_keyValue(disc_val) {
        price_bd = $("#price_bd").numberbox('getValue');

        var disc_pct = (disc_val / price_bd) * 100;

        $("#disc_pct").numberbox('setValue', disc_pct);
        price_disc('', disc_pct);
    }
    function price_disc(price_bd, disc_pct) {

        if (price_bd == '') {
            price_bd = $("#price_bd").numberbox('getValue');
        }
        if (disc_pct == '') {
            disc_pct = $("#disc_pct").numberbox('getValue');
        }

        var price_tot = price_bd * 1;
        var disc_tot = (price_tot / 100) * disc_pct;


        //alert(disc_pct)

        var total = price_tot - disc_tot;


        if (disc_tot > price_tot) {
            $.messager.alert('Warning', 'Discount value has to be lower than or equal to Unit Price.', 'warning');
            price_disc('', '0');
            $("#disc_pct").numberbox('setValue', 0);
        } else {
            $("#disc_val").numberbox('setValue', disc_tot);
            $("#price_ad").numberbox('setValue', total);
        }


    }
    function parseCurrency(num) {
        return num.replace(/[^0-9]/g, '');
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

    function wood(wo_no) {
        if (wo_no == '') {
            wo_no = 0;
        }
        $("#wk_code").combogrid({
            method: 'get',
            url: site_url + '<?php echo 'builder/combogrid/' . encrypt_decrypt('encrypt', 'acc_wood'); ?>/wo_no/' + wo_no + '/rcv/?grid=true',
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
                    {field: 'wk_code', title: '<?php getCaption('Kode Pekerjaan'); ?>', width: 120},
                    {field: 'wk_desc', title: '<?php getCaption('Nama Pekerjaan'); ?>', width: 200},
                    {field: 'beg_qty', title: '<?php getCaption('Qty Order'); ?>', width: 150},
                    {field: 'end_qty', title: '<?php getCaption('Blm Terima'); ?>', width: 150},
                    {field: 'wo_no', title: '<?php getCaption('No. WO'); ?>', width: 150},
                    {field: 'wo_date', title: '<?php getCaption('Tgl. WO'); ?>', width: 150, formatter: formatDate},
                    {field: 'wor_no', title: '<?php getCaption('No. SPOK'); ?>', width: 150},
                    {field: 'wor_date', title: '<?php getCaption('Tgl. SPOK'); ?>', width: 150, formatter: formatDate},
                    {field: 'wor_line', title: '<?php getCaption('Line'); ?>', width: 150},
                    {field: 'dept_code', title: '<?php getCaption("Department"); ?>', width: 150, height: 20, sortable: true},
                    {field: 'req_code', title: 'Request By', width: 150, height: 20, sortable: true}



                ]]
        });


        $('#form_validation2 #wk_code').combogrid({
            onSelect: function (index, row) {
                $("#wood_id").val(row.id);
                $("#form_validation2 #wk_desc").val(row.wk_desc);
                $("#form_validation2 #price_bd").numberbox('setValue', row.price_bd);
                $("#form_validation2 #disc_pct").numberbox('setValue', row.disc_pct);
                $("#form_validation2 #disc_val").numberbox('setValue', row.disc_val);
                $("#form_validation2 #price_ad").numberbox('setValue', row.price_ad);
                $("#form_validation2 #sal_inv_no").val(row.sal_inv_no);


            }
        });

    }
    function condAdd2() {
        $('#form_validation2 .combo-text').val('');
        $('#form_validation2 #id2').val('');
        $('#form_validation2 :input').val('');
        $("#form_validation2 .easyui-numberbox").numberbox('setValue', '');
        var wo_no = $("#wo_no").combogrid('getValue');
        wood(wo_no)
        condReady2();

    }

    function condEdit2() {
        showAlert("Message", '<font color="red">Record(s) can\'t be edited. To edit this record, please delete it and add a new record</font>');
    }

    function tableId2() {
        divtableId2.empty().append('<input type="hidden" name="id2"  id="id2"><input type="hidden" name="table2"  id="table2" value="' + table2 + '">');
    }
    /*End Detail*/

    $(document).ready(function () {
         checkRunMonthYear('APR');
        tableId();
        dateTop();
        read_show('')
        version('03.17-31');
    });
</script>