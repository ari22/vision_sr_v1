<script>

    $(document).ready(function () {
        tableId();
        read_show('');
        version('03.17-31');
    });

    var table = 'veh_dpsh';
    var form = $('#form_validation');
    var save_url = site_url + 'transaction/cashier/save_downpaymentSupp';


    var divtableId = $("#tableId");
    var ttable = $("#dt_ard");

    var table2 = 'veh_dpsd';
    var ttable2 = $("#dt_ard2");

    var divtableId2 = $("#tableId2");



    $("#po_no").combogrid({
        onSelect: function (index, row) {
            $.each(row, function (i, v) {
                if (i == 'po_no' || i == 'id') {

                } else {
                    $("#form_validation #" + i).val(v);


                    if (i == 'wrhs_code') {
                        $("#form_validation #" + i).combogrid('setValue', v);
                    }

                    if (i == 'po_date' || i == 'opn_date') {
                        if (v !== '0000-00-00') {
                            var vdate = dateSplit(v);

                            $("#form_validation #" + i).datebox('setValue', vdate);
                        }
                    }
                }


            });

            $("#form_validation #veh_price").numberbox('setValue', row.unit_price);
        }
    });
    
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
    function tableId() {
        divtableId.empty().append('<input type="hidden" name="id"  id="id"><input type="hidden" name="table"  id="table" value="' + table + '">');
    }

    function read_show(nav) {
        var id = $("#form_validation #id").val();
        $.post(site_url + 'crud/read', {table: table, nav: nav, id: id}, function (json) {
            $('#form_validation input:text').val('');

            if (json !== '[]') {

                var rowData = $.parseJSON(json);

                $.each(rowData, function (i, v) {
                    $("#form_validation #" + i).val(v);

                    if (i == 'dp_begin' || i == 'dp_paid' || i == 'dp_used' || i == 'dp_end' || i == 'veh_price') {
                        $("#form_validation #" + i).numberbox('setValue', v);
                    }
                    if (i == 'po_no' || i == 'wrhs_code') {
                        $("#form_validation #" + i).combogrid('setValue', v);
                    }
                    if (i == 'opn_date' || i == 'po_date') {
                        if (v !== '0000-00-00') {
                            var vdate = dateSplit(v);

                            $("#form_validation #" + i).datebox('setValue', vdate);
                        }
                    }
                });

                cmdcondAwal();
                formDisabled();
                table_grid(ttable, rowData.po_no);
                $('.loader').hide();
            } else {
                cmdcondAwal();
                formDisabled();
                $('.cmdEdit').attr('disabled', true);
                $('.cmdDelete').attr('disabled', true);
                $('.cmdEdit').linkbutton('disable');
                $('.cmdDelete').linkbutton('disable');

                $("#bayar").attr('disabled', true);
                $("#bayar").linkbutton('disable');
                $('.loader').hide();
                table_grid(ttable, null);
            }
        });
    }

    function cmdcondAwal() {
        $('.cmdFirst').removeAttr('disabled');
        $('.cmdPrev').removeAttr('disabled');
        $('.cmdNext').removeAttr('disabled');
        $('.cmdLast').removeAttr('disabled');
        $('.cmdSave').attr('disabled', true);
        $('.cmdCancel').attr('disabled', true);
        $('.cmdAdd').removeAttr('disabled');
        // $('.cmdEdit').removeAttr('disabled');
        $('.cmdDelete').removeAttr('disabled');
        $('.cmdSearch').removeAttr('disabled');
        $('.search2').removeAttr('disabled');
        $('.bayar').removeAttr('disabled');

        $('.cmdFirst').linkbutton('enable');
        $('.cmdPrev').linkbutton('enable');
        $('.cmdNext').linkbutton('enable');
        $('.cmdLast').linkbutton('enable');
        $('.cmdSave').linkbutton('disable');
        $('.cmdCancel').linkbutton('disable');
        $('.cmdAdd').linkbutton('enable');
        $('.cmdEdit').linkbutton('disable');
        $('.cmdDelete').linkbutton('enable');
        $('.cmdSearch').linkbutton('enable');
        $('.search2').linkbutton('enable');
        $('.bayar').linkbutton('enable');

    }

    function condReady() {
        $('#form_validation #note').attr('disabled', false);
        $("#form_validation #po_no").combogrid('enable');
        //var po_no = $("#form_validation #po").combogrid('getValue');
        //var ttable = $("#dt_ard");
        //table_grid(ttable, po_no);
        table_grid(ttable, po_no);
        cmdcondReady();
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
        $('.search2').attr('disabled', true);
        $('.bayar').attr('disabled', true);

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
        $('.search2').linkbutton('disable');
        $('.bayar').linkbutton('disable');

        $("#form_validation #cmdClose").linkbutton('disable');
        $("#form_validation #cmdDetail").linkbutton('disable');
    }
    function condAdd() {       
        showAlert("Disabled", '<font color="red">This button is deactivated</font>');
        /*
         $('.easyui-numberbox').numberbox('setValue', '');
        $("#form_validation .easyui-datebox").datebox('setValue', '');
        $('#form_validation input:text').val('');
         $('#form_validation #id').val('');
        $("#wrhs_code").combogrid('setValue', '<?php echo $wrhs_input; ?>');
        $('#form_validation #opn_date').datebox('setValue', '<?php echo date('Y-m-d'); ?>');
        condReady();*/
    }
    function condEdit() {
        condReady();
    }
    function condDelete() {

        var id = $("#form_validation #id").val();
        var table = $("#form_validation #table").val();

        $.messager.confirm('Warning', 'Do you really want to delete the selected data?', function (r) {
            if (r) {

                var url = site_url + 'transaction/cashier/deleteDPSupplier';
                $.post(url, {table: table, id: id}, function (data) {
                    obj = JSON.parse(data);

                    if (obj.success == true) {
                        read_show('P');
                        showAlert("Information", obj.message);

                    } else
                    {
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
    function saveData() {
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

                    }

                } else
                {
                    showAlert("Error while saving", '<font color="red">' + obj.message + '</font>');
                   read_show('');
                }

                scrlTop();
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

    function table_grid(ttable, po_no) {
        url = site_url + '<?php echo 'builder/datagrid/' . encrypt_decrypt('encrypt', 'veh_dpsd'); ?>/po_no/' + po_no + '/?grid=true';

        ttable.datagrid({
            method: 'post',
            url: url,
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
                    {field: 'pay_date', title: '<?php getCaption("Tgl. Bayar"); ?>', width: 80, height: 20, sortable: true, formatter: formatDate},
                    {field: 'pay_type', title: '<?php getCaption("Jenis Pembayaran"); ?>', width: 150, height: 20, sortable: true},
                    {field: 'bank_code', title: '<?php getCaption("Bank"); ?>', width: 100, height: 20, sortable: true},
                    //{field: 'edc_code', title: 'EDC', width: 100, height: 20, sortable: true},
                    {field: 'check_no', title: '<?php getCaption("No. Check"); ?>', width: 150, height: 20, sortable: true},
                    {field: 'check_date', title: '<?php getCaption("Tanggal Check"); ?>', width: 100, height: 20, sortable: true, formatter: formatDate},
                    {field: 'due_date', title: '<?php getCaption("Tgl J. Tempo"); ?>', width: 100, height: 20, sortable: true, formatter: formatDate},
                    {field: 'posted', title: '<?php getCaption("Uang Jaminan (Posted)"); ?>', width: 120, height: 20, align: 'right', sortable: true, formatter: formatNumber},
                    {field: 'current', title: '<?php getCaption("Uang Jaminan (Current)"); ?>', width: 120, height: 20, align: 'right', sortable: true, formatter: formatNumber},
                    {field: 'used_val', title: '<?php getCaption("Bayar Hutang"); ?>', width: 120, height: 20, align: 'right', sortable: true, formatter: formatNumber},
                    {field: 'pay_desc', title: '<?php getCaption("Keterangan"); ?>', width: 285, height: 20, sortable: true}

                ]]
        });
    }

    function bayarHutang() {
        scrlTop();
        tableId2();
        read_show2('');

        var po_no = $("#form_validation #po_no").combogrid('getValue');

        table_grid(ttable2, po_no);
        $('#BayarWindow').window('open');
    }


    function tableId2() {
        divtableId2.empty().append('<input type="hidden" name="id2"  id="id2"><input type="hidden" name="table2"  id="table2" value="' + table2 + '">');
    }

    function read_show2(nav) {
        var po_no = $("#po_no").combogrid('getValue');
        var id = $("#id2").val();

        $.post(site_url + 'crud/read/?po_no=' + po_no, {table: table2, nav: nav, id: id}, function (json) { //alert(json)
            formbayarempty();

            if (json !== '[]') {

                var row = $.parseJSON(json);
                $.each(row, function (i, v) {
                    $("#formBayar #" + i).val(v);

                    if (i == 'pay_date' || i == 'check_date' || i == 'due_date') {
                        if (v !== '0000-00-00') {
                            var vdate = dateSplit(v);

                            $("#formBayar #" + i).datebox('setValue', vdate);
                        }
                    }

                    if (i == 'pay_type' || i == 'bank_code' || i == 'edc_code') {
                        $("#formBayar #" + i).combogrid('setValue', v);
                    }

                });
                $("#id2").val(row.id);
                $("#pay_bt").numberbox('setValue', row.pay_bt);

                //var remain = row.pay_bt - row.used_val;
                $("#used_val").numberbox('setValue', row.used_val);


                table_grid(ttable2, po_no);
                cmdcondAwal2();

                $('#cmdPrint1').linkbutton('enable');
                $('#cmdPrint1').removeAttr('disabled');
                $('#cmdDelete2').linkbutton('enable');
                $('#cmdDelete2').removeAttr('disabled');

               // $('#cmdBayarBBN').removeAttr('disabled');
                //$('#cmdBayarBBN').linkbutton('enable');
            } else {
                table_grid(ttable2, po_no);
                cmdcondAwal2();

                $('#cmdPrint1').linkbutton('disable');
                $('#cmdPrint1').attr('disabled', true);
                $('#cmdDelete2').linkbutton('disable');
                $('#cmdDelete2').attr('disabled', true);
            }

        });
    }

    function conReady2() {
        $('#payer_name').attr('disabled', false);
        $('#payer_addr').attr('disabled', false);
        $('#payer_area').attr('disabled', false);
        $('#payer_city').attr('disabled', false);
        $('#payer_zipc').attr('disabled', false);
        $('#pay_date').datebox('enable');
        $('#pay_type').combogrid('enable');
        $('#bank_code').combogrid('enable');
        $('#edc_code').combogrid('enable');
        $('#check_no').attr('disabled', false);
        $('#check_date').datebox('enable');
        $('#due_date').datebox('enable');
        $('#pay_bt').attr('disabled', false);
        $('#pay_desc').attr('disabled', false);

        cmdcondReady2()
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

    function condDelete2() {
        var po_no = $("#form_validation #po_no").combogrid('getValue');
        var id = $("#id2").val();

        $.messager.confirm('Delete Confirmation', 'Do you really want to delete this record?', function (r) {
            if (r) {
                var url = site_url + 'transaction/cashier/delete_dpsd/' + po_no;
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
    function cmdcondAwal2()
    {
        $('#cmdFirst2').removeAttr('disabled');
        $('#cmdPrev2').removeAttr('disabled');
        $('#cmdNext2').removeAttr('disabled');
        $('#cmdLast2').removeAttr('disabled');
        $('#cmdSave2').attr('disabled', true);
        $('#cmdCancel2').attr('disabled', true);
        $('#cmdAdd2').removeAttr('disabled');
        $('#cmdEdit2').removeAttr('disabled');
        //$('#cmdDelete2').removeAttr('disabled');
        $('#cmdSearch2').removeAttr('disabled');
        $('#cmdBayarBBN').attr('disabled', true);

        $('#cmdFirst2').linkbutton('enable');
        $('#cmdPrev2').linkbutton('enable');
        $('#cmdNext2').linkbutton('enable');
        $('#cmdLast2').linkbutton('enable');
        $('#cmdSave2').linkbutton('disable');
        $('#cmdCancel2').linkbutton('disable');
        $('#cmdAdd2').linkbutton('enable');
        $('#cmdEdit2').linkbutton('enable');
        //$('#cmdDelete2').linkbutton('enable');
        $('#cmdSearch2').linkbutton('enable');
        $('#cmdBayarBBN').linkbutton('disable');

        $('#payer_name').attr('disabled', true);
        $('#payer_addr').attr('disabled', true);
        $('#payer_area').attr('disabled', true);
        $('#payer_city').attr('disabled', true);
        $('#payer_zipc').attr('disabled', true);
        $('#pay_date').datebox('disable');
        $('#pay_type').combogrid('disable');
        $('#bank_code').combogrid('disable');
        $('#edc_code').combogrid('disable');
        $('#check_no').attr('disabled', true);
        $('#check_date').datebox('disable');
        $('#due_date').datebox('disable');
        $('#pay_bt').attr('disabled', true);
        $('#used_val').attr('disabled', true);
        $('#pay_desc').attr('disabled', true);

    }
    function formbayarempty() {
        $('#id2').val('');
        $('#payer_name').val('');
        $('#payer_addr').val('');
        $('#payer_area').val('');
        $('#payer_city').val('');
        $('#payer_zipc').val('');
        $('#pay_date').datebox('setValue', '');
        $('#pay_type').combogrid('setValue', '');
        $('#bank_code').combogrid('setValue', '');
        $('#edc_code').combogrid('setValue', '');
        $('#check_no').val('');
        $('#check_date').datebox('setValue', '');
        $('#due_date').datebox('setValue', '');
        // $('#pay_bt').val('');
        //$('#used_val').val('');
        $('#pay_desc').val('');
        $("#pay_bt").numberbox('setValue', '0');
        $('#formBayar .easyui-numberbox').numberbox('setValue', '');
    }
    function condAdd2() {
        var num = checkRoles('ed');

        if (num == '1') {
            formbayarempty();
            $('#pay_type').combogrid('setValue', '');
            $('#bank_code').combogrid('setValue', '');
            $('#edc_code').combogrid('setValue', '');
            $('#check_no').val('');
            $('#check_date').val('');
            $('#due_date').val('');
            $('#pay_bt').val('');
            $('#used_val').val('');
            $('#pay_desc').val('');
            $("#pay_date").datebox('setValue', '<?php echo date("Y-m-d"); ?>');
            $("#check_date").datebox('setValue', '<?php echo date("Y-m-d"); ?>');
            $("#due_date").datebox('setValue', '<?php echo date("Y-m-d"); ?>');
            conReady2();
        } else {
            errorAccess();
        }


    }
    function saveData2() {
        $('#formBayar :input').attr('disabled', false);

        var po_no = $("#po_no").combogrid('getValue');

        var save_url2 = site_url + 'transaction/cashier/save_dpsd/' + po_no+ '/<?php echo $session['C_USER']; ?>';

        $("#formBayar").form('submit', {
            url: save_url2,
            onSubmit: function () {
                return $(this).form('validate');
            },
            success: function (data) { 
               
                var obj = JSON.parse(data);

                if (obj.success == true) {

                    //table_grid(ttable, po_no);
                   // table_grid(ttable2, po_no);
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

                scrlTop();
            }
        });
    }
</script>