<script>

    var table = 'veh_dpch';
    var table2 = 'veh_dpcd';
    var pk = 'dp_inv_no';
    var sk = 'so_no';


    var form = $('#<?php echo $form; ?>');
    var divtableId = $("#tableId");
    var divtableId2 = $("#tableId2");

    var save_url = site_url + 'transaction/cashier/saveDownpayment';
    var delete_url = site_url + 'transaction/cashier/deleteDownpayment';
    var tblgrid1 = $("#dt");
    var tblgrid2 = $("#inputBayar");
    var lnRecCount = 0;
    var lnRecNo = 0;

    var stat = null;


    function doSearch() {
        $("#tableSearch").datagrid('load', {
            field1: $('#code').val(),
            field2: $('#name').val()
        });
    }
    function getSearchselect() {
        var row = $("#tableSearch").datagrid('getSelected');

        if (row) {
            $("#<?php echo $form; ?> #id").val(row.id);
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
        $('#<?php echo $form; ?> :input').attr('disabled', true);
        $('.easyui-combogrid').combogrid('disable');
        $('.easyui-combobox').combobox({disabled: true});
        $('.combo-text').removeClass('validatebox-text');
        $('.combo-text').removeClass('validatebox-invalid');

        cmdcondAwal();
    }

    function tableId() {
        divtableId.empty().append('<input type="hidden" name="id"  id="id"><input type="hidden" name="table"  id="table" value="' + table + '">');
    }

    function read_show(nav) {
        var id = $("#<?php echo $form; ?> #id").val();

        $.post(site_url + 'crud/read', {table: table, nav: nav, id: id}, function (json) {

            $('#<?php echo $form; ?> input:text').val('');
            $('#<?php echo $form; ?> textarea').val('');
            $('#<?php echo $form; ?> .easyui-combogrid').combogrid('setValue', '');
            $("#<?php echo $form; ?> input:radio").prop("checked", false);
            $(".easyui-datebox").datebox('setValue', '');


            if (json !== '[]') {

                var rowData = $.parseJSON(json);

                $.each(rowData, function (i, v) {
                    $("#" + i).val(v);

                    if (i == 'dp_date' || i == 'opn_date' || i == 'so_date') {
                        if (v !== '0000-00-00') {
                            var vdate = dateSplit(v);

                            $("#" + i).datebox('setValue', vdate);
                        }
                    }

                });


                $("#so_no").combogrid('setValue', rowData.so_no);
                $("#veh_price").numberbox('setValue', rowData.veh_price);
                $("#dp_begin").numberbox('setValue', rowData.dp_begin);
                $("#dp_paid").numberbox('setValue', rowData.dp_paid);
                $("#dp_used").numberbox('setValue', rowData.dp_used);
                $("#dp_end").numberbox('setValue', rowData.dp_end);

                var pd_end = rowData.veh_price - (parseInt(rowData.dp_used) + parseInt(rowData.dp_end));
                //alert((rowData.dp_used +"==="+ rowData.dp_end))
                $("#pd_end").numberbox('setValue', pd_end);



                formDisabled();
                table_grid(tblgrid1, rowData.dp_inv_no);
                $('.loader').hide();
                $('.cmdEdit').linkbutton('disable');
                $(".cmdBayar").removeAttr('disabled');
                $(".cmdBayar").linkbutton('enable');

                $("#so_no").combogrid('disable');
            } else {
                formDisabled();
                $('.cmdEdit').attr('disabled', true);
                $('.cmdDelete').attr('disabled', true);
                $('.cmdEdit').linkbutton('disable');
                $('.cmdDelete').linkbutton('disable');
                $("#cmdBayar").attr('disabled', true);
                $("#cmbBayar").linkbutton('disable');

                table_grid(tblgrid1, null);

                $('.loader').hide();
            }

            stat = 'read';
        });
    }
    function formDisabled() {
        $('#<?php echo $form; ?> :input').attr('disabled', true);
        $('.easyui-combogrid').combogrid('disable');
        $('.easyui-combobox').combobox({disabled: true});
        $('.combo-text').removeClass('validatebox-text');
        $('.combo-text').removeClass('validatebox-invalid');

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

    function condCancel() {
        read_show('');
        $(".formError").remove();
        $(".easyui-datebox").datebox('disable');
        $('.easyui-numberbox').attr('disabled', true);
    }

    function condAdd() {
        $('.easyui-numberbox').numberbox('setValue', '');
        vMode = 1;
        $('#<?php echo $form; ?> input:text').val('');
        $('#so_no').combogrid('setValue', '');
        $('#so_date').datebox('setValue', '');
        $('#pd_end').numberbox('setValue', '0');
        $('.easyui-numberbox').numberbox('setValue', '0');
        $("#dp_date").datebox('setValue', '<?php echo date('Y-m-d'); ?>');
        $("#opn_date").datebox('setValue', '<?php echo date('Y-m-d'); ?>');

        $.post(site_url + 'builder/get_number/VDC', function (num) {
            $("#dp_inv_no").val(num);
        });
        condReady();
        $('#so_no').focus();

        table_grid(tblgrid1, 'NULL');

    }
    function condDelete() {
        $.messager.confirm('Warning', 'Do you really want to delete the selected data?', function (r) {
            if (r) {
                var id = $("#id").val();
                var data = 'table=' + table + '&id=' + id;

                $.ajax({
                    url: delete_url,
                    data: data,
                    method: 'post',
                    success: function (json) {
                        var obj = JSON.parse(json);

                        if (obj.success == true) {
                            showAlert("Information", obj.message);
                            $("#id").val('');
                            read_show('');
                            $("#dt").datagrid('reload');
                            // condBayar();
                        } else
                        {
                            showAlert("Error while deleted", '<font color="red">' + obj.message + '</font>');
                        }

                        scrlTop();
                    }
                });

            } else {
                $('#cmdDelete').linkbutton('enable');
            }
        });
    }
    function cmdcondReady() {
        $('.cmdCancel').removeAttr('disabled');
        $('.cmdSave').removeAttr('disabled');

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

        $('#cmdBayar').linkbutton('disable');
    }

    function condReady() {
        scrlTop();
        cmdcondReady()
        var dp_inv_no = $("#dp_inv_no").val();

        if (dp_inv_no == '') {
            dp_inv_no = 0;
        }

        table_grid(tblgrid1, dp_inv_no)
        $('#note').attr('disabled', false);
        spknumber();
        $('#so_no').combogrid('enable');

        stat = null;
    }

    function spknumber() {


        $('#so_no').combogrid({
            onSelect: function (index, row) {
                $("#cust_code").val(row.cust_code);
                $("#cust_name").val(row.cust_name);
                $("#chassis").val(row.chassis);
                $("#engine").val(row.engine);
                $("#veh_name").val(row.veh_name);
                $("#color_code").val(row.color_code);
                $("#color_name").val(row.color_name);
                $("#wrhs_code").val(row.wrhs_code);
                $("#srep_name").val(row.srep_name);
                $("#veh_price").numberbox('setValue', row.tot_price);
                $("#so_date").datebox('setValue', row.so_date);

                $("#pd_end").numberbox('setValue', row.tot_price);

                var url_check_spk = site_url + 'transaction/cashier/check_dp_spk';


                $.post(url_check_spk, {so_no: row.so_no}, function (res) {
                    var count = $.parseJSON(res);

                    if (stat !== 'read') {
                        if (count.count > 0) {
                            $.messager.confirm('SPK already  in Down Payment', 'This SPK No. is already in down payment: ' + count.dp_inv_no + '. to the down payment invoice?', function (r) {
                                if (r) {
                                    $("#id").val(count.id);
                                    read_show('');
                                    stat = 'read';
                                }
                            });
                            return false;
                        }
                    }
                });

            }
        });


    }
    function saveData() {
        $('.loader').show();
        $('#<?php echo $form; ?> :input').attr('disabled', false);
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
                    $("#id").val(obj.id);
                    read_show('');
                    $("#dt").datagrid('reload');
                    condBayar();
                    stat = 'read';
                } else
                {
                    formDisabled()
                    condAdd();
                    showAlert("Error while saving", '<font color="red">' + obj.message + '</font>');
                    $('.loader').hide();
                }
            }
        });

    }

    var vModeBayar = 0;
    /* $('#inputBayar').datagrid({
     onClickRow: function (index, row) {
     $('#id2').val(row.id);
     $('#payer_name').val(row.payer_name);
     $('#payer_addr').val(row.payer_addr);
     $('#payer_area').val(row.payer_area);
     $('#payer_city').val(row.payer_city);
     $('#payer_zipc').val(row.payer_zipc);
     $('#pay_date').datebox('setValue', row.pay_date);
     $('#pay_type').combogrid('setValue', row.pay_type);
     $('#bank_code').combogrid('setValue', row.bank_code);
     $('#check_no').val(row.check_no);
     $('#check_date').datebox('setValue', row.check_date);
     $('#due_date').val(row.due_date);
     $('#pay_val').val(row.pay_val);
     $('#used_val').val(row.used_val);
     $('#pay_desc').val(row.pay_desc);
     $('#cmdEdit1').linkbutton('enable');
     $('#cmdDelete1').linkbutton('enable');
     $('#cmdPrint1').linkbutton('enable');
     }
     });*/


    function editBayar(lMode) {
        var num = checkRoles('ed');

        if (num == '1') {
            var so_no = $("#so_no").combogrid('getValue');

            $.post(site_url + 'transaction/cashier/check_sale', {tbl: 'veh_slh', so_no: so_no}, function (json) {
                var out = $.parseJSON(json);

                if (out.success !== false) {
                    formbayarempty();

                    vModeBayar = lMode;
                    if (lMode == 1)
                    {
                        url = "services/runCRUD.php";
                        data = "func=read&lookup=mst/veh_cust&pk=cust_code&sk=cust_name&q=" + $('#cust_code').val();
                        $.post(url, data)
                                .done(function (data) {
                                    obj = JSON.parse(data);
                                    if (obj.total >> 0)
                                    {
                                        $('#payer_name').val(obj.rows[0]['cust_name']);
                                        if (obj.rows[0]['cust_type'] == '1')
                                        {
                                            $('#payer_addr').val(obj.rows[0]['haddr']);
                                            $('#payer_area').val(obj.rows[0]['harea']);
                                            $('#payer_city').val(obj.rows[0]['hcity']);
                                            $('#payer_zipc').val(obj.rows[0]['hzipcode']);
                                        }
                                        if (obj.rows[0]['cust_type'] == '2')
                                        {
                                            $('#payer_addr').val(obj.rows[0]['oaddr']);
                                            $('#payer_area').val(obj.rows[0]['oarea']);
                                            $('#payer_city').val(obj.rows[0]['ocity']);
                                            $('#payer_zipc').val(obj.rows[0]['ozipcode']);
                                        }
                                    } else {
                                        $('#payer_name').val('');
                                        $('#payer_addr').val('');
                                        $('#payer_area').val('');
                                        $('#payer_city').val('');
                                        $('#payer_zipc').val('');
                                    }
                                })
                                .fail(function () {
                                    showAlert("Error", "Error while saving");
                                })


                        // $('#pay_date').val('');
                        $('#pay_type').combogrid('setValue', '');
                        $('#bank_code').combogrid('setValue', '');
                        $('#edc_code').combogrid('setValue', '');
                        $('#check_no').val('');
                        $('#check_date').val('');
                        $('#due_date').val('');
                        $('#pay_val').val('');
                        $('#used_val').val('');
                        $('#pay_desc').val('');
                        $("#pay_date").datebox('setValue', '<?php echo date("Y-m-d"); ?>');
                        $("#check_date").datebox('setValue', '<?php echo date("Y-m-d"); ?>');
                        $("#due_date").datebox('setValue', '<?php echo date("Y-m-d"); ?>');

                    }

                    conReady2();
                } else {
                    showAlert("Error while saving", '<font color="red">' + out.message + '</font>');
                }

            });
            return false;
        } else {
            errorAccess();
        }


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
        $('#pay_val').attr('disabled', false);
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

    function condDelete2()
    {
        $.messager.confirm('Delete Confirmation', 'Do you really want to delete this record?', function (r) {
            if (r) {
                url = "services/runCRUD.php";
                data = "lookup=trx/veh_dpcd"
                        + "&func=delete"
                        + "&dp_inv_no=" + $('#dp_inv_no').val()
                        + "&check_no=" + $('#check_no').val()
                        + "&id=" + $('#id2').val();

                $.post(url, data)
                        .done(function (res) {
                            var obj = $.parseJSON(res);

                            if (obj.success == true)
                            {
                                $("#id2").val('');
                                read_show('');
                                read_show2('');
                            } else {
                                showAlert("Informasi", '<font color="red">' + obj.message + '</font>');
                            }
                        })
                        .fail(function () {
                            showAlert("Error", "<font color='red'>Error while saving</font>");
                        });
            }
        });

    }
    function saveBayar()
    {
        var num = checkRoles('ed');

        if (num == '1') {
            $('#cmdSave2').linkbutton('disable');
            var so_no = $("#so_no").combogrid('getValue');

            $.post(site_url + 'transaction/cashier/check_sale', {tbl: 'veh_slh', so_no: so_no}, function (json) {
                var out = $.parseJSON(json);

                if (out.success !== false) {
                    var lcMode = 'update';
                    if (vModeBayar == 1) {
                        lcMode = 'create';
                    }

                    url = "services/runCRUD.php";
                    data = "lookup=trx/veh_dpcd"
                            + "&func=" + lcMode
                            + "&dp_inv_no=" + $('#dp_inv_no').val()
                            + "&so_no=" + $('#so_no').val()
                            + "&so_date=" + $('#so_date').datebox('getValue')
                            + "&dp_date=" + $('#dp_date').datebox('getValue')
                            + "&coll_code=" + $('#coll_code').val()
                            + "&payer_name=" + $('#payer_name').val()
                            + "&payer_addr=" + $('#payer_addr').val()
                            + "&payer_area=" + $('#payer_area').val()
                            + "&payer_city=" + $('#payer_city').val()
                            + "&payer_zipc=" + $('#payer_zipc').val()
                            + "&pay_date=" + $('#pay_date').datebox('getValue')
                            + "&pay_type=" + $('#pay_type').combogrid('getValue')
                            + "&bank_code=" + $('#bank_code').combogrid('getValue')
                            + "&edc_code=" + $('#edc_code').combogrid('getValue')
                            + "&check_no=" + $('#check_no').val()
                            + "&check_date=" + $('#check_date').datebox('getValue')
                            + "&due_date=" + $('#due_date').datebox('getValue')
                            + "&pay_val=" + $('#pay_val').val()
                            + "&used_val=" + $('#used_val').val()
                            + "&pay_desc=" + $('#pay_desc').val()
                            + "&wrhs_code=" + '<?php echo$_SESSION["comp_code"]; ?>'
                            ;

                    $.post(url, data)
                            .done(function (data) { //alert(data)

                                obj = JSON.parse(data);
                                if (obj.success == true)
                                {
                                    $("#id2").val('');
                                    read_show('');
                                    read_show2('');

                                } else {
                                    showAlert("information", '<font color="red">' + obj.message + '</font>');
                                    $('#cmdSave2').linkbutton('enable');
                                }
                            })
                            .fail(function () {
                                showAlert("Error", "Error while saving");
                                $('#cmdSave2').linkbutton('enable');
                            })
                } else {
                    showAlert("Error while saving", '<font color="red">' + out.message + '</font>');
                    read_show('');
                    read_show2('');

                }

                scrlTop();
            });

            return false;
        }
        errorAccess();

    }
    function printBayar()
    {
        $.post(site_url + 'builder/get_number/VTT', function (num) {
            $("#tts_no").val(num);
        });
        $("#tts_date").val('<?php echo date('d-m-Y'); ?>');
        $("#signature").val('<?php echo $_SESSION['C_USER']; ?>');

        $('#signature').attr('disabled', false);
        $('#jabatan').attr('disabled', false);
        $("#PrintWindow").window('open');


    }

    function print_sc(action) {

        var id = $("#id2").val();
        var tts_no = $("#tts_no").val();
        var tts_date = $("#tts_date").val();
        var signature = $("#signature").val();
        var jabatan = $('#jabatan').val();
        var user = '<?php echo $_SESSION['C_USER']; ?>';

        msg = true;

        if (jabatan == '') {
            showAlert("Error", "<font color='red'>Job Position can not be empty</font>");
            msg = false;
        }
        if (signature == '') {
            showAlert("Error", "<font color='red'>Signature can not be empty</font>");
            msg = false;
        }

        if (msg !== false) {
            var url = site_url + 'transaction/cashier/outputpdf/<?php echo encrypt_decrypt('encrypt', 'veh_dpcd'); ?>/' + id + '/' + user + '/' + action + '/' + signature + '/' + jabatan + '/' + tts_no + '/' + tts_date + '#toolbar=0';

            if (action == 'screen') {
                // $('#sr').window('open');
                //$('#sr').empty().append('<iframe   frameborder="0"  src="' + url + '" style="width:100%;height:auto;min-height: 500px;padding:0px;"></iframe>');
                window.open(url);
            } else {

                $('#sr').empty().append('<iframe   frameborder="0"  src="' + url + '" style="width:100%;height:auto;min-height: 500px;padding:0px;"></iframe>');
            }
        }

    }


    var lnRecCount = 0;
    var lnRecNo = 0;




    function setEnable(status)
    {
        var lcStatus1 = false;
        var lcStatus2 = false;
        if (status == false)
        {
            lcStatus1 = true;
            lcStatus2 = 'disable';
        } else
        {
            lcStatus2 = 'enable';
            lcStatus3 = true;
        }
        $('#dp_inv_no').attr('disabled', lcStatus1);
        $('#so_no').combobox(lcStatus2);
        $('#note').attr('disabled', lcStatus1);
    }


    function condAwalBayar()
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
        $('#pay_val').attr('disabled', true);
        $('#used_val').attr('disabled', true);
        $('#pay_desc').attr('disabled', true);

    }

    function formbayarempty() {
        $('#payer_name').val('');
        $('#payer_addr').val('');
        $('#payer_area').val('');
        $('#payer_city').val('');
        $('#payer_zipc').val('');
        $('#pay_date').datebox('setValue', '');
        $('#pay_type').combogrid('setValue', '');
        $('#bank_code').combogrid('setValue', '');
        $('#check_no').val('');
        $('#check_date').datebox('setValue', '');
        $('#due_date').datebox('setValue', '');
        // $('#pay_val').val('');
        //$('#used_val').val('');
        $('#pay_desc').val('');
        $("#pay_val").numberbox('setValue', '0');
        $('#formBayar .easyui-numberbox').numberbox('setValue', '');
    }
    function condBayar() {
        scrlTop();
        $('#detailBayar').window('open');
        tableId2();
        read_show2('');
    }

    function table_grid(ttable, dp_inv_no) {
        //var url = "services/runCRUD.php?func=read&lookup=trx/veh_dpcd&query=" + dp_inv_no;
        var url = site_url + '<?php echo 'builder/datagrid/' . encrypt_decrypt('encrypt', 'veh_dpcd'); ?>/dp_inv_no/' + dp_inv_no + '/?grid=true';
//alert(url)
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
                    {field: 'pay_type', title: '<?php getCaption("Jenis Pembayaran"); ?>', width: 100, height: 20, sortable: true},
                    {field: 'bank_code', title: '<?php getCaption("Bank"); ?>', width: 100, height: 20, sortable: true},
                    {field: 'edc_code', title: 'EDC', width: 100, height: 20, sortable: true},
                    {field: 'check_no', title: '<?php getCaption("No. Check"); ?>', width: 100, height: 20, sortable: true},
                    {field: 'check_date', title: '<?php getCaption("Tanggal Check"); ?>', width: 100, height: 20, sortable: true, formatter: formatDate},
                    {field: 'due_date', title: '<?php getCaption("Tgl J. Tempo"); ?>', width: 100, height: 20, sortable: true, formatter: formatDate},
                    {field: 'posted', title: '<?php getCaption("Uang Jaminan (Posted)"); ?>', width: 120, height: 20, align: 'right', sortable: true, formatter: formatNumber},
                    {field: 'current', title: '<?php getCaption("Uang Jaminan (Current)"); ?>', width: 120, height: 20, align: 'right', sortable: true, formatter: formatNumber},
                    {field: 'used_val', title: '<?php getCaption("Bayar Piutang"); ?>', width: 120, height: 20, align: 'right', sortable: true, formatter: formatNumber},
                    {field: 'pay_desc', title: '<?php getCaption("Keterangan"); ?>', width: 285, height: 20, sortable: true}


                ]]
        });

    }

    function read_show2(nav) {
        var dp_inv_no = $("#dp_inv_no").val();
        var id = $("#id2").val();

        $.post(site_url + 'crud/read/?dp_inv_no=' + dp_inv_no, {table: table2, nav: nav, id: id}, function (json) { //alert(json)
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
                $("#pay_val").numberbox('setValue', row.pay_val);

                //var remain = row.pay_val - row.used_val;
                $("#used_val").numberbox('setValue', row.used_val);

                table_grid(tblgrid2, $("#dp_inv_no").val());
                condAwalBayar();

                $('#cmdPrint1').linkbutton('enable');
                $('#cmdPrint1').removeAttr('disabled');
                $('#cmdDelete2').linkbutton('enable');
                $('#cmdDelete2').removeAttr('disabled');

                $('#cmdBayarBBN').removeAttr('disabled');
                $('#cmdBayarBBN').linkbutton('enable');
            } else {
                table_grid(tblgrid2, $("#dp_inv_no").val());
                condAwalBayar();

                $('#cmdPrint1').linkbutton('disable');
                $('#cmdPrint1').attr('disabled', true);
                $('#cmdDelete2').linkbutton('disable');
                $('#cmdDelete2').attr('disabled', true);
            }

        });
    }
    function tableId2() {
        divtableId2.empty().append('<input type="hidden" name="id2"  id="id2"><input type="hidden" name="table2"  id="table2" value="' + table2 + '">');
    }
    $(document).ready(function () {
        checkRunMonthYear('VDC');
        tableId();
        read_show('');
        version('03.17-31');
    });

</script>