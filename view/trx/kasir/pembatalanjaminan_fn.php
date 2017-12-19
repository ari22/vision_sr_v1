<script>
    var table = 'vehdpcch';
    var form = $('#form_validation');
    var save_url = site_url + 'transaction/cashier/saveBatalUangJaminan/<?php echo $_SESSION['C_USER']; ?>';
    var unclose_url = site_url + 'transaction/cashier/uncloseBatalUangJaminan/<?php echo $_SESSION['C_USER']; ?>';
    var close_url = site_url + 'transaction/cashier/closeBatalUangJaminan/<?php echo $_SESSION['C_USER']; ?>';

    var divtableId = $("#tableId");
    var divtableId2 = $("#tableId2");
    var ttable = $('#dt_dpccd');
    var ttable2 = $('#dt_dpccd2');
    var table2 = 'vehdpccd';

    $("#pay_type").combogrid({
        onSelect: function (index, row) {
            if (row.pay_type == 'CASH') {
                $("#check_no").val(row.pay_type);
                $("#check_date").datebox('setValue', '<?php echo date("d/m/Y"); ?>');
                $("#due_date").datebox('setValue', '<?php echo date("d/m/Y"); ?>');
            }
        }
    });
    $('#dp_inv_no').combogrid({
        onSelect: function (index, rowData) {
            $.each(rowData, function (i, v) {
                if (i !== 'id') {
                    $("#" + i).val(v);

                    if (i == 'dp_date' || i == 'so_date') {
                        if (v !== '0000-00-00') {
                            var vdate = dateSplit(v);

                            $("#" + i).datebox('setValue', vdate);
                        }

                    }

                    if (i == 'cust_name') {
                        $("#" + i).combogrid('setValue', v);
                    }
                }
            });
            $("#form_validation #pay_date").datebox('setValue', '<?php echo date("d/m/Y"); ?>');
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
            $("#form_validation .easyui-numberbox").numberbox('setValue', '');

            if (json !== '[]') {

                var rowData = $.parseJSON(json);

                $.each(rowData, function (i, v) {
                    $("#" + i).val(v);

                    if (i == 'dpc_date' || i == 'opn_date' || i == 'dp_date' || i == 'so_date' || i == 'cls_date' || i == 'pay_date' || i == 'due_date' || i == 'check_date') {
                        if (v !== '0000-00-00') {
                            var vdate = dateSplit(v);

                            $("#" + i).datebox('setValue', vdate);
                        }
                    }

                    if (i == 'inv_at' || i == 'inv_total' || i == 'inv_deduct' || i == 'inv_deduc2') {
                        $("#" + i).numberbox('setValue', v);
                    }

                    if (i == 'cust_name' || i == 'dp_inv_no' || i == 'pay_type' || i == 'bank_code') {
                        $("#" + i).combogrid('setValue', v);
                    }

                });

                var dpc_inv_no = rowData.dpc_inv_no;

                table_grid(ttable, dpc_inv_no);

                cmdcondAwal();
                formDisabled();

                if (rowData.cls_date == null || rowData.cls_date == '0000-00-00') {
                    $("#cmdDetail").removeAttr('disabled');
                    $('#cmdDetail').linkbutton('enable');
                    $("#print").linkbutton('disable');
                    $("#screen").linkbutton('disable');
                    $("#download").linkbutton('disable');

                    //if (rowData.inv_total !== '0') {
                    $("#closeOn").empty().append('<button type="button" id="cmdClose" title="<?php getCaption("Close"); ?>" class="easyui-linkbutton btn-cls"  data-options="iconCls:\'icon-close\'" onclick="rolesClose()">Close</button>');
                    $('#cmdClose').linkbutton();
                    //}

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

                table_grid(ttable, null);
            }


        });
    }

    function doSearch() {
        $("#tableSearch").datagrid('load', {
            field1: $('#code').val(),
            field2: $('#arg_date2').val()
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

        if (key == 'screen') {
            var ids = $("#form_validation #id").val();
            var url = site_url + 'transaction/cashier/outputpdf/<?php echo encrypt_decrypt('encrypt', 'vehdpcch'); ?>/' + ids + '/<?php echo $session['C_USER']; ?>/screen#toolbar=0';
            window.open(url);
        }
        if (key == 'download') {
            var ids = $("#form_validation #id").val();
            var url = site_url + 'transaction/cashier/outputpdf/<?php echo encrypt_decrypt('encrypt', 'vehdpcch'); ?>/' + ids + '/<?php echo $session['C_USER']; ?>/download';

            $("#screenWindow").empty().append('<iframe frameborder="0"  src="' + url + '" style="width:100%;height:auto;min-height: 500px;padding:0px;"></iframe>');
            // $("#screenWindow").window('open');
        }
        if (key == 'print') {
            var ids = $("#form_validation #id").val();
            var url = site_url + 'transaction/cashier/outputpdf/<?php echo encrypt_decrypt('encrypt', 'vehdpcch'); ?>/' + ids + '/<?php echo $session['C_USER']; ?>/print';

            $("#screenWindow").empty().append('<iframe frameborder="0"  src="' + url + '" style="width:100%;height:auto;min-height: 500px;padding:0px;"></iframe>');
            // $("#screenWindow").window('open');
        }
    }
    function table_grid(ttable, dpc_inv_no) {
        ttable.datagrid({
            method: 'post',
            url: site_url + '<?php echo 'builder/datagrid/' . encrypt_decrypt('encrypt', 'vehdpccd'); ?>/dpc_inv_no/' + dpc_inv_no + '/?grid=true',
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
                    {field: 'check_no', title: '<?php getCaption("No. Check"); ?>', width: 105, height: 20, sortable: true},
                    {field: 'check_date', title: '<?php getCaption("Tanggal Check"); ?>', width: 100, height: 20, sortable: true, formatter: formatDate},
                    {field: 'due_date', title: '<?php getCaption("Tgl J. Tempo"); ?>', width: 100, height: 20, sortable: true, formatter: formatDate},
                    {field: 'pay_date', title: '<?php getCaption("Tgl. Bayar"); ?>', width: 100, height: 20, sortable: true, formatter: formatDate},
                    {field: 'bank_code', title: '<?php getCaption("Bank"); ?>', width: 100, height: 20, sortable: true},
                    {field: 'edc_code', title: 'EDC', width: 50, height: 20, sortable: true},
                    {field: 'pay_val', title: '<?php getCaption("Uang Jaminan"); ?>', width: 105, height: 20, sortable: true, align: 'right', formatter: formatNumber},
                    {field: 'pay_deduct', title: '<?php getCaption("Pemotongan"); ?>', width: 105, height: 20, sortable: true, align: 'right', formatter: formatNumber},
                    {field: 'pay_deduc2', title: '<?php getCaption("Pemotongan Lain"); ?>', width: 110, height: 20, sortable: true, align: 'right', formatter: formatNumber},
                    {field: 'pay_rval', title: '<?php getCaption("Pengembalian"); ?>', width: 105, height: 20, sortable: true, align: 'right', formatter: formatNumber},
                    {field: 'pay_type', title: '<?php getCaption("Jenis Bayar"); ?>', width: 100, height: 20, sortable: true},
                    {field: 'pay_desc', title: '<?php getCaption("Keterangan"); ?>', width: 275, height: 20, sortable: true},
                    {field: 'payer_name', title: '<?php getCaption("Dibayar oleh"); ?>', width: 200, height: 20, sortable: true},
                    {field: 'payer_addr', title: '<?php getCaption("Alamat"); ?>', width: 250, height: 20, sortable: true}

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
        $('#form_validation :input').attr('disabled', true);
        cmdcondReady();
        $("#form_validation #note, #check_no, #pay_desc").removeAttr('disabled');
        $('#form_validation #dp_inv_no, #cust_name').combogrid('enable');

        $('#form_validation #pay_date, #check_date, #due_date').datebox('enable');
        $("#form_validation #pay_type").combogrid('enable');
        $("#form_validation #bank_code").combogrid('enable');

    }

    $('#form_validation #cust_name').combogrid({
        onSelect: function (index, row) {
            $('#form_validation #cust_code').val(row.cust_code);
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

        $("#form_validation #cmdClose").linkbutton('disable');
        $("#form_validation #cmdDetail").linkbutton('disable');
        $("#form_validation #cmdUnClose").linkbutton('disable');
        $("#print").linkbutton('disable');
        $("#screen").linkbutton('disable');
    }

    function condAdd() {
        //$(".easyui-datebox").datebox('enable');
        $('#form_validation #id').val('');
        $('#form_validation input:text').val('');
        $("#form_validation #table").val(table);
        $("#form_validation .easyui-numberbox").numberbox('setValue', '');
        $('#form_validation .easyui-combobox').combobox('setValue', '');
        $("#form_validation .easyui-datebox").datebox('setValue', '');
        $('#form_validation .easyui-combogrid').combogrid('setValue', '');
        $('#form_validation #wrhs_code').val('<?php echo $wrhs_input; ?>');
        $('#form_validation #opn_date').datebox('setValue', '<?php echo date('d/m/Y'); ?>');

        $.post(site_url + 'transaction/cashier/get_number/VRD', function (num) {
            $("#form_validation #dpc_inv_no").val(num);
        });
        condReady();
        table_grid(ttable, null);
    }
    function condEdit() {
        condReady();
    }
    function condDelete() {
        var id = $("#form_validation #id").val();
        var table = $("#form_validation #table").val();
        $.messager.confirm('Warning', 'Are you sure delete selected data ?', function (r) {
            if (r) {
                $(".loader").show();
                var url = site_url + 'transaction/cashier/deletePembatalanUJ';
                $.post(url, {table: table, id: id}, function (data) {
                    obj = JSON.parse(data);

                    if (obj.success == true) {
                        read_show('P');
                        showAlert("Information", obj.message);

                    } else
                    {
                        $(".loader").hide();
                        showAlert("Error while delete", '<font color="red">' + obj.message + '</font>');
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
        $.messager.confirm('Closing Invoice', 'Close this Invoice?', function (r) {
            if (r) {
                $(".loader").show();
                $('#form_validation :input').attr('disabled', false);
                form.form('submit', {
                    url: close_url,
                    onSubmit: function () {
                        return $(this).form('validate');
                    },
                    success: function (data) { //alert(data);return false;

                        var obj = JSON.parse(data);
                        if (obj.success == true) {
                            //showAlert("Information", obj.message);
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
            $('#form_validation :input').attr('disabled', false);
        });


    }
    function UncloseBtn() {
        $.messager.confirm('Unclosing Invoice', 'Unclose this invoice??', function (r) {
            if (r) {
                $(".loader").show();
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
        var status = true;

        if ($("#dp_inv_no").val() == '') {
            showAlert("Error while saving", '<font color="red">No. Faktur Uang Jaminan harus diisi</font>');
            status = false;
        }
        if ($("#cust_code").val() == '') {
            showAlert("Error while saving", '<font color="red">Kode dan Nama Pelanggan harus diisi</font>');
            status = false;
        }


        if (status !== false) {
            $(".loader").show();
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
                            cmdDetails();
                        }

                    } else
                    {
                        updateFailed(obj);
                    }

                    scrlTop();
                    $(".loader").hide();
                }
            });
        }

    }

    /* Detail */
    function cmdDetails() {
        scrlTop();
        var dpc_inv_no = $("#form_validation #dpc_inv_no").val();
        var dp_inv_no = $("#form_validation #dp_inv_no").val();
        var ttable = $("#dt_dpccd2");
        var cust_code = $("#form_validation #cust_code").val();
        tableId2();
        read_show2('');
        table_grid(ttable, dpc_inv_no);

        $("#DetailWindow").window('open');
        
        var url = "<?php echo $site_url . 'builder/combogrid/' . encrypt_decrypt('encrypt', 'veh_dpcd') . '/dp_inv_no/'; ?>" + dp_inv_no + '/batal';

        $('#form_validation2 #check_no').combogrid({
            fitColumns: false,
            singleSelect: true,
            nowrap: true,
            fit: false,
            rownumbers: true,
            pageSize: 10,
            showFooter: false,
            pagination: true,
            panelWidth: 650,
            mode: 'remote',
            idField: 'check_no',
            textField: 'check_no',
            url: url,
            columns: [[
                    {field: 'dp_inv_no', title: '<?php getCaption("No. Faktur"); ?>', width: 160},
                    {field: 'check_no', title: '<?php getCaption("No. Check"); ?>', width: 150},
                    {field: 'check_date', title: '<?php getCaption("Tanggal Check"); ?>', width: 150, formatter: formatDate},
                    {field: 'pay_date', title: '<?php getCaption("Tgl. Bayar"); ?>', width: 150, formatter: formatDate},
                    {field: 'pay_type', title: '<?php getCaption("Jenis Bayar"); ?>', width: 150},
                    {field: 'bank_code', title: '<?php getCaption("Bank"); ?>', width: 150},
                    {field: 'due_date', title: '<?php getCaption("Tgl J. Tempo"); ?>', width: 150, formatter: formatDate},
                    {field: 'pay_val', title: '<?php getCaption("Uang Jaminan"); ?>', width: 150, formatter: formatNumber},
                    {field: 'pay_desc', title: '<?php getCaption("Keterangan"); ?>', width: 150, formatter: formatNumber}
                ]],
            onSelect: function (index, rowData) {
                $.each(rowData, function (i, v) {

                    if (i !== 'id') {
                        $("#form_validation2 #" + i).val(v);

                        if (i == 'pay_val') {
                            $("#form_validation2 #" + i).numberbox('setValue', v);
                            var pay_deduct = $("#pay_deduct").numberbox('getValue');
                            var pay_deduc2 = $("#pay_deduc2").numberbox('getValue');

                            countrpay_rval(v, pay_deduct, pay_deduc2);
                        }
                        if (i == 'check_date' || i == 'pay_date' || i == 'due_date') {
                            if (v !== '0000-00-00') {
                                var vdate = dateSplit(v);

                                $("#form_validation2 #" + i).datebox('setValue', vdate);
                            }
                        }
                        if (i == 'check_no') {
                            //$("#"+i).combogrid('setValue', v);
                        }

                    }
                });
            }
        });


    }



    function read_show2(nav) {
        var id = $("#id2").val();
        var dpc_inv_no = $("#form_validation #dpc_inv_no").val();

        $.post(site_url + 'crud/read/?dpc_inv_no=' + dpc_inv_no, {table: table2, nav: nav, id: id}, function (json) {
            $("#form_validation2 .easyui-numberbox").numberbox('setValue', '');

            $('#form_validation2 input:text').val('');
            $('#form_validation2 .easyui-combogrid').combogrid('setValue', '');
            $("#form_validation2 .easyui-datebox").datebox('setValue', '');

            if (json !== '[]') {


                var rowData = $.parseJSON(json);

                $.each(rowData, function (i, v) {
                    if (i !== 'id') {
                        $("#form_validation2 #" + i).val(v);

                        if (i == 'pay_val' || i == 'pay_deduct' || i == 'pay_deduc2' || i == 'pay_rval') {
                            $("#form_validation2 #" + i).numberbox('setValue', v);
                        }
                        if (i == 'check_date' || i == 'pay_date' || i == 'due_date') {
                            if (v !== '0000-00-00') {
                                var vdate = dateSplit(v);

                                $("#form_validation2 #" + i).datebox('setValue', vdate);
                            }
                        }
                        if (i == 'check_no') {
                            $("#form_validation2 #" + i).combogrid('setValue', v);
                        }
                    }
                });

                $("#form_validation2 #pay_type").val(rowData.pay_type);
                $("#form_validation2 #id2").val(rowData.id);

            }
            formDisabled2();
            cmdcondAwal2();

        });
    }

    function saveData2() {
        $('#cmdSave2').linkbutton('disable');
        var dpc_inv_no = $("#form_validation #dpc_inv_no").val();
        var dp_inv_no = $("#form_validation #dp_inv_no").val();
        var save_url2 = site_url + 'transaction/cashier/save_vehdpccd/' + dpc_inv_no + '/' + dp_inv_no+'/<?php echo $session['C_USER']; ?>';

        $('#form_validation2 :input').attr('disabled', false);

        $("#form_validation2").form('submit', {
            url: save_url2,
            onSubmit: function () {
                return $(this).form('validate');
            },
            success: function (data) {

                var obj = JSON.parse(data);

                if (obj.success !== false) {

                    table_grid(ttable, dpc_inv_no);
                    table_grid(ttable2, dpc_inv_no);
                    $("#id2").val('');

                    read_show2('');
                    read_show('');

                    $('#form_validation2 #check_no').combogrid('grid').datagrid('reload');
                } else
                {

                    showAlert("Error", '<font color="red">' + obj.message + '</font>');
                    $('#cmdSave2').linkbutton('enable');
                }
            }
        });
    }

    function condDelete2() {
        var dpc_inv_no = $("#form_validation #dpc_inv_no").val();
        var id = $("#id2").val();
        $.messager.confirm('Confirm Delete', 'Are you sure delete selected data ?', function (r) {
            if (r) {
                var url = site_url + 'transaction/cashier/delete_vehdpccd';
                $.post(url, {table: table2, id: id}, function (data) {

                    obj = JSON.parse(data);
                    if (obj.success == true) {

                        table_grid(ttable, dpc_inv_no);
                        table_grid(ttable2, dpc_inv_no);
                        $("#id2").val('');
                        $("#form_validation2 :input").val('');
                        read_show2('');
                        read_show('');
                        $('#form_validation2 #check_no').combogrid('grid').datagrid('reload');
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
        $('#form_validation2 #pay_deduct').attr('disabled', false);
        $('#form_validation2 #pay_deduc2').attr('disabled', false);

        $('#form_validation2 .easyui-combogrid').combogrid('enable');
        $('#form_validation2 .easyui-combobox').combobox({disabled: false});

        cmdcondAwal2();
        cmdcondReady2();
        countpay();
    }

    function countpay() {


        $("#pay_deduct").keyup(function () {
            var pay_val = $("#form_validation2 #pay_val").numberbox('getValue');
            var pay_deduct = parseCurrency($(this).val());
            var pay_deduc2 = $("#pay_deduc2").numberbox('getValue');

            countrpay_rval(pay_val, pay_deduct, pay_deduc2);
        });

        $("#pay_deduc2").keyup(function () {
            var pay_val = $("#form_validation2 #pay_val").numberbox('getValue');
            var pay_deduct = $("#pay_deduct").numberbox('getValue');
            var pay_deduc2 = parseCurrency($(this).val());

            countrpay_rval(pay_val, pay_deduct, pay_deduc2);
        });

    }
    function countrpay_rval(pay_val, pay_deduct, pay_deduc2) {
        var pay_rval = pay_val - pay_deduct - pay_deduc2;

        $("#pay_rval").numberbox('setValue', pay_rval);
    }
    function parseCurrency(num) {
        // return parseFloat(num.replace(/[^0-9\.-]+/g,""));
        // return parseFloat(num.replace(/[^0-9\.-]+/g,""));
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
    function condAdd2() {
        $('#form_validation2 .combo-text').val('');
        $('#form_validation2 #id2').val('');
        $('#form_validation2 :input').val('');
        $('#form_validation2 .easyui-numberbox').numberbox('setValue', '');
        condReady2();

        $('#disc_pct2').keyup(function () {
            var disc = $(this).val();
            var harga = $('#form_validation2 #sal_price2').val();
            var jml_disc = ($('#form_validation2 #sal_price2').val() / 100) * disc;

            var total = harga - jml_disc;
            $('#form_validation2 #disc_val2').val(jml_disc);
            $('#form_validation2 #price_ad2').val(total);
        });
    }

    function condEdit2() {
        $.messager.alert('Warning', 'Record(s) can’t be edited. To edit this record, please delete it and add a new record.', 'warning');
    }


    function tableId2() {
        divtableId2.empty().append('<input type="hidden" name="id2"  id="id2"><input type="hidden" name="table2"  id="table2" value="' + table2 + '">');
    }
    /*End Detail*/

    $(document).ready(function () {
        checkRunMonthYear('VRD');
        tableId();
        read_show('')
        version('03.17-31');
    });
</script>