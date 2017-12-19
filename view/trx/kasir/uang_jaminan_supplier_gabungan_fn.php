<script>

    var table = 'veh_dpsgh';
    var form = $('#form_validation');
    var save_url = site_url + 'transaction/cashier/saveDPGabungan';
    var unclose_url = site_url + 'transaction/cashier/uncloseDPGabunganSupp/<?php echo $session['C_USER']; ?>';
    var close_url = site_url + 'transaction/cashier/closeDPGabunganSupp/<?php echo $session['C_USER']; ?>';

    var divtableId = $("#tableId");
    var ttable = $("#dt_apgd");

    var table2 = 'veh_dpsgd';
    var po_no = $("#form_validation #po_no").val();

    var ttable2 = $("#dt_apgd2");
    var divtableId2 = $("#tableId2");

    $("#pay_type").combogrid({
        onSelect: function (index, row) {
            if (row.pay_type == 'CASH') {
                $("#check_no").val(row.pay_type);
                $("#check_date").datebox('setValue', '<?php echo date("Y-m-d"); ?>');
                $("#due_date").datebox('setValue', '<?php echo date("Y-m-d"); ?>');
            }
        }
    });



    function tableId() {
        divtableId.empty().append('<input type="hidden" name="id"  id="id"><input type="hidden" name="table"  id="table" value="' + table + '">');
    }

    function read_show(nav) {
        var id = $("#form_validation #id").val();

        $.post(site_url + 'crud/read', {table: table, nav: nav, id: id}, function (json) {
            $('#form_validation input:text').val('');
            $('#form_validation textarea').val('');
            $('#form_validation .easyui-combogrid').combogrid('setValue', '');
            $("#form_validation input:radio").prop("checked", false);
            $("#form_validation .easyui-datebox").datebox('setValue', '');

            if (json !== '[]') {
                $('#form_validation input:text').val('');
                $("#form_validation input:radio").prop("checked", false);

                var rowData = $.parseJSON(json);


                $.each(rowData, function (i, v) {
                    $("#form_validation #" + i).val(v);


                    if (i == 'supp_name' || i == 'bank_code' || i == 'pay_type' || i == 'wrhs_code') {
                        $("#form_validation #" + i).combogrid('setValue', v);
                    }
                    if (i == 'dp_date' || i == 'opn_date' || i == 'pay_date' || i == 'check_date' || i == 'due_date' || i == 'cls_date') {
                        if (v !== '0000-00-00') {
                            var vdate = dateSplit(v);

                            $("#form_validation #" + i).datebox('setValue', vdate);
                        }
                    }

                    if (i == 'tot_item' || i == 'tot_paid') {
                        $("#form_validation #" + i).numberbox('setValue', v);
                    }
                });


                var dp_inv_no = rowData.dp_inv_no;

                table_grid(ttable, dp_inv_no);

                cmdcondAwal();
                formDisabled();

                if (rowData.cls_date == null || rowData.cls_date == '0000-00-00') {
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
                    $("#closeOn").empty().append('<button type="button" id="cmdUnClose" title="<?php getCaption("unClose"); ?>" class="easyui-linkbutton btn-cls"  data-options="iconCls:\'icon-unclose\'" onclick="rolesUnclose()">Unclose</button>');

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
                cmdEmptyData();
                table_grid(ttable, null);
                $('#cmdDetail').linkbutton('disable');
            }

            $(".loader").hide();
        });
    }
    function doSearch() {
        $("#tableSearch").datagrid('load', {
            field1: $('#code').val(),
            field2: $('#dp_date2').val()
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
    function getSearchselect2() {
        var row = $("#tableSearch2").datagrid('getSelected');

        if (row) {
            $.post(site_url + 'crud/read/?dp_inv_no=' + row.dp_inv_no, {table: table, nav: '', id: ''}, function (json) {
                var rowData = JSON.parse(json);
                $("#form_validation #id").val(rowData.id);
                $('#windowSearch2').window('close');
                $("#actionSearch").empty()
                $("#SearchOption").hide();
                read_show('');
            });

        }
    }
    function close_search() {
        $('#windowSearch').window('close');
        $("#actionSearch").empty()
        $("#SearchOption").hide();
    }

    function print_sc(key) {
        if (key == 'print') {
            var ids = $("#form_validation #id").val();
            var url = site_url + 'transaction/cashier/outputpdf/<?php echo encrypt_decrypt('encrypt', 'veh_dpsgh'); ?>/' + ids + '/<?php echo $session['C_USER']; ?>/print';

            $("#screenWindow").empty().append('<iframe frameborder="0"  src="' + url + '" style="width:100%;height:auto;min-height: 500px;padding:0px;"></iframe>');
            // $("#screenWindow").window('open');
        }
        if (key == 'screen') {
            var ids = $("#form_validation #id").val();
            var url = site_url + 'transaction/cashier/outputpdf/<?php echo encrypt_decrypt('encrypt', 'veh_dpsgh'); ?>/' + ids + '/<?php echo $session['C_USER']; ?>/screen#toolbar=0';
            window.open(url);
        }
        if (key == 'download') {
            var ids = $("#form_validation #id").val();
            var url = site_url + 'transaction/cashier/outputpdf/<?php echo encrypt_decrypt('encrypt', 'veh_dpsgh'); ?>/' + ids + '/<?php echo $session['C_USER']; ?>/download';

            $("#screenWindow").empty().append('<iframe frameborder="0"  src="' + url + '" style="width:100%;height:auto;min-height: 500px;padding:0px;"></iframe>');
            // $("#screenWindow").window('open');
        }

    }

    function table_grid(ttable, dp_inv_no) {

        ttable.datagrid({
            method: 'post',
            url: site_url + '<?php echo 'builder/datagrid/' . encrypt_decrypt('encrypt', 'veh_dpsgd'); ?>/dp_inv_no/' + dp_inv_no + '/?grid=true',
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
                    //{field: 'chassis', title: '<?php getCaption("Nomor Rangka"); ?>', width: 150, height: 20, sortable: true},
                    //{field: 'pur_inv_no', title: '<?php getCaption("No. Faktur Beli"); ?>', width: 110, height: 20, sortable: true},
                    {field: 'po_no', title: '<?php getCaption("No. PO"); ?>', width: 110, height: 20, sortable: true},
                    {field: 'po_date', title: '<?php getCaption("Tgl. PO"); ?>', width: 80, height: 20, sortable: true, formatter: formatDate},
                    {field: 'veh_code', title: '<?php getCaption("Kode Kendaraan"); ?>', width: 100, height: 20, sortable: true},
                    {field: 'veh_name', title: '<?php getCaption("Nama Kendaraan"); ?>', width: 250, height: 20, sortable: true},
                    {field: 'color_name', title: '<?php getCaption("Nama Warna"); ?>', width: 220, height: 20, sortable: true},
                    {field: 'veh_year', title: '<?php getCaption("Tahun"); ?>', width: 60, height: 20, sortable: true},
                    {field: 'veh_transm', title: '<?php getCaption("Transmisi"); ?>', width: 100, height: 20, sortable: true},
                    {field: 'dp_paid', title: '<?php getCaption("Uang Muka"); ?>', width: 120, height: 20, sortable: true, align: "right", formatter: formatNumber},
                    {field: 'veh_price', title: '<?php getCaption("Harga Kendaraan"); ?>', width: 120, height: 20, sortable: true, align: "right", formatter: formatNumber},
                    {field: 'color_code', title: '<?php getCaption("Kode Warna"); ?>', width: 100, height: 20, sortable: true},
                ]]
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
        var vpg_source = '<?php echo $vpg_source; ?>';


        $('#form_validation :input').attr('disabled', false);
        $('#form_validation .easyui-combogrid').combogrid('enable');
        $('#form_validation .easyui-combobox').combobox({disabled: false});

        var dp_inv_no = $("#form_validation #dp_inv_no").val();
        var ttable = $("#dt_apgd");

        if (dp_inv_no == '') {
            dp_inv_no = null;
        }
        table_grid(ttable, dp_inv_no);

        $('#form_validation #wrhs_code').combogrid('disable');
        $('#form_validation #opn_date').datebox('disable');
        $('#form_validation #cls_date').datebox('disable');
        $('#form_validation #dp_date').datebox('disable');
        $('#form_validation #supp_code').attr('disabled', true);
        $("#form_validation #dp_inv_no").attr('disabled', true);
        $("#form_validation #tot_item").attr('disabled', true);
        $("#form_validation #tot_paid").attr('disabled', true);
        $("#form_validation #tot_disc").attr('disabled', true);
        $("#form_validation #apv_inv_no").combogrid('disable');
        $('#form_validation #apv_date').datebox('disable');
        $('#form_validation #pay_date').datebox('enable');
        $('#form_validation #check_date').datebox('enable');
        $('#form_validation #due_date').datebox('enable');

        if (vpg_source == '2') {
            //$('#form_validation #apv_date').datebox('enable');

            $("#form_validation #apv_inv_no").combogrid({
                onSelect: function (index, row) {
                    $("#apv_date").datebox('setValue', row.apv_date);
                }
            });

            $("#form_validation #apv_inv_no").combogrid('enable');
        }
        cmdcondReady();
    }

    $('#form_validation #supp_name').combogrid({
        onSelect: function (index, row) {
            $('#form_validation #supp_code').val(row.supp_code);
        }
    });
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

        $("#form_validation #cmdUnClose").linkbutton('disable');
        $("#form_validation #cmdClose").linkbutton('disable');
        $("#form_validation #cmdDetail").linkbutton('disable');
        $("#form_validation #screen").linkbutton('disable');
        $("#form_validation #print").linkbutton('disable');
        $("#form_validation #download").linkbutton('disable');
    }

    function condAdd() {
        $('#form_validation .easyui-combogrid').combogrid('setValue', '');
        $('.easyui-numberbox').numberbox('setValue', '');
        $(".easyui-datebox").datebox('enable');
        $('#form_validation #id').val('');
        $('#form_validation input:text').val('');
        $("#form_validation #table").val(table);


        $('#form_validation #wrhs_code').combogrid('setValue', '<?php echo $wrhs_input; ?>');
        $('#form_validation #pay_type').combogrid('setValue', '');
        $('#form_validation #pay_date').datebox('setValue', '<?php echo date('Y-m-d'); ?>');
        $('#form_validation #opn_date').datebox('setValue', '<?php echo date('Y-m-d'); ?>');

        $.post(site_url + 'transaction/cashier/get_number/VDP', function (num) {
            $("#form_validation #dp_inv_no").val(num);
        });
        condReady();

        $("#form_validation #tot_paid").numberbox('setValue', 0);
        $("#form_validation #tot_disc").numberbox('setValue', 0);

    }
    function condEdit() {
        condReady();
        var tot_item = $("#form_validation #tot_item").val();

        if (tot_item > 0) {
            $('#form_validation #supp_name').combogrid('disable');
            $("#form_validation #apv_inv_no").combogrid('disable');
            $('#form_validation #apv_date').datebox('disable');
        }
    }
    function condDelete() {
        var id = $("#form_validation #id").val();
        var table = $("#form_validation #table").val();
        $.messager.confirm('Warning', 'Do you really want to delete the selected data?', function (r) {
            if (r) {
                $(".loader").show();
                var url = site_url + 'transaction/cashier/deleteDPSupplierGabungan';
                $.post(url, {table: table, id: id}, function (data) {
                    obj = JSON.parse(data);

                    if (obj.success == true) {
                        read_show('P');
                        showAlert("Information", obj.message);

                    } else
                    {
                        $(".loader").hide();
                        showAlert("Error while deleting", '<font color="red">' + obj.message + '</font>');
                        read_show('');
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
        $.messager.confirm('Closing Invoice', 'Close this invoice?', function (r) {
            if (r) {
                $(".loader").show();
                $('#form_validation :input').attr('disabled', false);
                form.form('submit', {
                    url: close_url,
                    onSubmit: function () {
                        return $(this).form('validate');
                    },
                    success: function (data) { //alert(data);

                        var obj = JSON.parse(data);
                        if (obj.success == true) {
                            //showAlert("Information", obj.message);
                            read_show('');
                        } else
                        {
                            read_show('');
                            $(".loader").hide();
                            showAlert("Error while saving", '<font color="red">' + obj.message + '</font>');
                        }
                        scrlTop();
                    }
                });
            }
            read_show('');
            $('#form_validation :input').attr('disabled', false);
        });


    }
    function UncloseBtn() {
        $.messager.confirm('Unclose', 'Unclose this invoice?', function (r) {
            if (r) {
                $(".loader").show();
                $('#form_validation :input').attr('disabled', false);
                form.form('submit', {
                    url: unclose_url,
                    onSubmit: function () {
                        return $(this).form('validate');
                    },
                    success: function (data) { //alert(data)

                        var obj = JSON.parse(data);
                        if (obj.success == true) {
                            // showAlert("Information", obj.message);
                            read_show('');
                        } else
                        {
                            $(".loader").hide();
                            read_show('');
                            showAlert("Error while saving", '<font color="red">' + obj.message + '</font>');
                        }
                        scrlTop();
                    }
                });
            }
            read_show('');
        });

    }
    function saveData() {
        $(".loader").show();
        $('#form_validation :input').attr('disabled', false);
        form.form('submit', {
            url: save_url,
            onSubmit: function () {
                return $(this).form('validate');
            },
            success: function (data) {// alert(data)

                var obj = JSON.parse(data);
                if (obj.success == true) {
                    showAlert("Information", obj.message);

                    if (obj.status == 'update') {
                        read_show('');
                    } else {
                        read_show('');
                        cmdDetails();
                    }

                } else
                {
                    $(".loader").hide();
                    showAlert("Error while saving", '<font color="red">' + obj.message + '</font>');
                    condReady();
                }
                scrlTop();
            }
        });
    }

    /* Detail */
    function cmdDetails() {
        scrlTop();
        var dp_inv_no = $("#form_validation #dp_inv_no").val();

        var supp_code = $("#form_validation #supp_code").val();
        tableId2();
        read_show2('');
        table_grid(ttable2, dp_inv_no);

        $("#DetailWindow").window('open');

        $("#po_no").combogrid({
            onSelect: function (index, row) {
                $.each(row, function (i, v) {
                    if (i == 'po_no' || i == 'id') {

                    } else {
                        $("#form_validation2 #" + i).val(v);

                        if (i == 'po_date') {
                            if (v !== '0000-00-00') {
                                var vdate = dateSplit(v);

                                $("#form_validation2 #" + i).datebox('setValue', vdate);
                            }
                        }
                        /* if (i == 'wrhs_code') {
                         $("#form_validation #" + i).combogrid('setValue', v);
                         }
                         
                         */
                    }


                });

                $("#form_validation2 #veh_price").numberbox('setValue', row.unit_price);
                $("#form_validation2 #dp_paid").numberbox('setValue', row.unit_price);
            }
        });
    }



    function parseCurrency(num) {
        return num.replace(/[^0-9]/g, '');
    }

    function read_show2(nav) {
        var id = $("#id2").val();
        var dp_inv_no = $("#form_validation #dp_inv_no").val();

        $.post(site_url + 'crud/read/?dp_inv_no=' + dp_inv_no, {table: table2, nav: nav, id: id}, function (json) {

            $("#form_validation2 :input").val('');
            $("#form_validation2 .easyui-numberbox").numberbox('setValue', '');
            if (json !== '[]') {

                var rowData = $.parseJSON(json);



                $.each(rowData, function (i, v) {
                    $("#form_validation2 #" + i).val(v);

                    if (i == 'po_no') {
                        $("#form_validation2 #" + i).combogrid('setValue', v);
                    }
                    if (i == 'po_date') {
                        if (v !== '0000-00-00') {
                            var vdate = dateSplit(v);

                            $("#form_validation2 #" + i).datebox('setValue', vdate);
                        }
                    }

                    if (i == 'veh_price' || i == 'dp_paid' || i == 'dp_used') {
                        $("#form_validation2 #" + i).numberbox('setValue', v);
                    }

                });

                $("#id2").val(rowData.id);

            }

            formDisabled2();
            cmdcondAwal2();

            table_grid(ttable2, dp_inv_no)
        });


    }

    function saveData2() {
        $('#cmdSave2').linkbutton('disable');
        var dp_inv_no = $("#form_validation #dp_inv_no").val();

        var save_url2 = site_url + 'transaction/cashier/save_dpsgd/' + dp_inv_no + '/<?php echo $session['C_USER']; ?>';

        $('#form_validation2 :input').attr('disabled', false);

        $("#form_validation2").form('submit', {
            url: save_url2,
            onSubmit: function () {
                return $(this).form('validate');
            },
            success: function (data) {

                var obj = JSON.parse(data);

                if (obj.success !== false) {
                    $("#id2").val('');
                    read_show('');
                    read_show2('');
                    $('#form_validation2 #po_no').combogrid('grid').datagrid('reload');
                } else
                {

                    showAlert("Failed", '<font color="red">' + obj.message + '</font>');
                    $('#cmdSave2').linkbutton('enable');
                }
            }
        });
    }

    function condDelete2() {
        var dp_inv_no = $("#form_validation #dp_inv_no").val();
        var id = $("#id2").val();

        $.messager.confirm('Delete Confirmation', 'Do you really want to delete the selected data?', function (r) {
            if (r) {
                var url = site_url + 'transaction/cashier/delete_dpsgd';
                $.post(url, {table: table2, id: id}, function (data) {

                    obj = JSON.parse(data);
                    if (obj.status == true) {

                        $("#id2").val('');
                        $("#form_validation2 :input").val('');
                        read_show2('');
                        read_show('');
                        $('#form_validation2 #chassis').combogrid('grid').datagrid('reload');
                    } else
                    {
                        showAlert("Error while delete", '<font color="red">' + obj.message + '</font>');
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
        $('#form_validation2 #dp_paid').attr('disabled', false);

        $('#form_validation2 .easyui-combogrid').combogrid('enable');
        $('#form_validation2 .easyui-combobox').combobox({disabled: false});

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
        $('#form_validation2 .combo-text').val('');
        $('#form_validation2 #id2').val('');
        $('#form_validation2 :input').val('');
        $('#form_validation2 .easyui-numberbox').numberbox('setValue', '');
        condReady2();


    }

    function condEdit2() {
        $.messager.alert('Warning', 'Record(s) can’t be edited. To edit this record, please delete it and add a new record.', 'warning');
    }


    function tableId2() {
        divtableId2.empty().append('<input type="hidden" name="id2"  id="id2"><input type="hidden" name="table2"  id="table2" value="' + table2 + '">');
    }
    /*End Detail*/


    $(document).ready(function () {
        checkRunMonthYear('VDP');
        tableId();
        read_show('')
        version('03.17-31');
    });
</script>