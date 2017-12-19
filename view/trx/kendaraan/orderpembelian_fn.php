<script>
    var table = 'veh_po';

    var form = $('#form_validation');
    var save_url = site_url + 'transaction/vehicle/savePO';
    var unclose_url = site_url + 'transaction/vehicle/unclosePO/<?php echo $_SESSION['C_USER']; ?>';
    var close_url = site_url + 'transaction/vehicle/closePO/<?php echo $_SESSION['C_USER']; ?>';

    var divtableId = $("#tableId");

    var vmode = 0;

    $("#unit_price").keyup(function () {
        var val = parseCurrency($(this).val());
        var tot = $("#qty").val() * val;

        $("#tot_price").numberbox('setValue', tot);
        $("#unit_price2").numberbox('setValue', val);

    });

    $("#supp_name").combogrid({
        onSelect: function (index, row) {
            var id = $("#id").val();
            $("#supp_code").val(row.supp_code);
        }
    });
    $("#stdoptname").combogrid({
        onSelect: function (index, row) {
            $("#stdoptcode").val(row.stdoptcode);
        }
    });

    $('#veh_name').combogrid({
        onSelect: function (index, row) {
            var id = $("#id").val();

            if (vmode == 1) {
                $("#veh_code").val(row.veh_code);
                $("#veh_brand").val(row.veh_brand);

                $("#veh_transm").val(row.veh_transm);
                $("#veh_year").val(row.veh_year);
                $("#chassis").val(row.chas_pref);
                $("#engine").val(row.eng_pref);
                $("#veh_type").val(row.veh_type);
                $("#veh_model").val(row.veh_model);

                set_price(row.veh_code, $("#color_type").val());
            }
        }
    });

    $('#color_name').combogrid({
        onSelect: function (index, row) {
            //var id = $("#id").val();

            if (vmode == 1) {
                $("#color_code").val(row.color_code);
                $("#color_type").val(row.type);

                $("#color_code").attr('disabled', true);
                $("#color_type").attr('disabled', true);

                set_price($("#veh_code").val(), row.type);
            }
        }
    });

    function gridColorVeh() {

    }
    function parseCurrency(num) {
        return num.replace(/[^0-9]/g, ''); // \(^0^)/\(^8^)/
    }


    function set_price(code, type) {

        $.post(site_url + 'transaction/vehicle/get_price', {code: code, type: type}, function (res) {
            var price = $.parseJSON(res);
            $("#unit_price").numberbox('setValue', price.pur_price);
            $("#tot_price").numberbox('setValue', price.pur_price);
        });
    }
    function tableId() {
        divtableId.empty().append('<input type="hidden" name="id"  id="id"><input type="hidden" name="table"  id="table" value="' + table + '">');
    }
    function read_show(nav) {
        vmode = 0;
        var id = $("#form_validation #id").val();

        $.post(site_url + 'crud/read', {table: table, nav: nav, id: id}, function (json) {
            $("#notif").val('');
            $('#form_validation input:text').val('');
            $('#form_validation textarea').val('');
            $('#form_validation .easyui-combogrid').combogrid('setValue', '');
            $("#form_validation input:radio").prop("checked", false);
            $(".easyui-datebox").datebox('setValue', '');

            if (json !== '[]') {

                var rowData = $.parseJSON(json);

                $.each(rowData, function (i, v) {
                    $("#" + i).val(v);

                    if (i == 'supp_name' || i == 'wrhs_code' || i == 'loc_code' || i == 'veh_name' || i == 'stdoptname' || i == 'color_name') {
                        $("#" + i).combogrid('setValue', v);
                    }

                    if (i == 'unit_price' || i == 'tot_price' || i == 'due_day' || i == 'qty') {
                        $("#" + i).numberbox('setValue', v);
                    }

                    if (i == 'cls_date' || i == 'po_date' || i == 'due_date' || i == 'pred_stk_d') {
                        if (v !== '0000-00-00') {
                            var vdate = dateSplit(v);

                            $("#" + i).datebox('setValue', vdate);
                        }
                    }
                });

                $("#id").val(rowData.id);


                formDisabled();

                if (rowData.cls_date == null || rowData.cls_date == '0000-00-00') {
                    $("#print").linkbutton('disable');
                    $("#screen").linkbutton('disable');
                    $("#closeOn").empty().append('<button type="button" id="cmdClose" title="<?php getCaption("Close"); ?>" class="easyui-linkbutton easyui-tooltip btn btn-success" data-options="iconCls:\'icon-close\'"   onclick="rolesClose()">Close</button>');

                } else {
                    $('.cmdEdit').linkbutton('disable');
                    $("#cmdDelete").linkbutton('disable');
                    $("#closeOn").empty().append('<button type="button" id="cmdUnClose" title="<?php getCaption("unClose"); ?>" class="easyui-linkbutton easyui-tooltip btn btn-success" data-options="iconCls:\'icon-unclose\'"  onclick="rolesUnclose()">Unclose</button>');

                    $("#print").removeAttr('disabled')
                    $("#print").linkbutton('enable');
                    $("#screen").removeAttr('disabled')
                    $("#screen").linkbutton('enable');
                }

                $('.easyui-linkbutton').linkbutton();
                $('.loader').hide();


            } else {
                formDisabled();
                //$('.cmdEdit').attr('disabled', true);
                //$('.cmdDelete').attr('disabled', true);
                $('.cmdEdit').linkbutton('disable');
                $('.cmdDelete').linkbutton('disable');
                $('.loader').hide();
                $("#closeOn").empty();
            }


        });
    }

    function doSearch() {
        $("#tableSearch").datagrid('load', {
            field1: $('#po_no2').val(),
            field2: $('#po_date2').datebox('getValue')
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
    function condAdd() {
        vmode = 1;
        $(".easyui-datebox").datebox('setValue', '');
        $(".easyui-datebox").datebox('enable');
        $('.easyui-numberbox').numberbox('enable');
        $('.easyui-numberbox').numberbox('setValue', '');
        $('#id').val('');
        $('#form_validation input:text').val('');
        $("#form_validation .easyui-combogrid").combogrid('setValue', '');
        $("#table").val(table);
        $('#form_validation textarea').val("");
        $("#form_validation input:radio").prop("checked", false);

        // $("#po_date").datebox('setValue', '<?php echo date('Y-m-d'); ?>');

        $.post(site_url + 'transaction/vehicle/get_number/VPO', function (num) {
            $("#form_validation #po_no").val(num);
        });

        condReady();

    }

    function condEdit() {
        vmode = 1;
        $(".easyui-datebox").datebox('enable');
        condReady();

    }

    function condCancel() {
        read_show('');
    }

    function condDelete() {
        var id = $("#form_validation #id").val();
        var table = $("#form_validation #table").val();
        $.messager.confirm('Warning', 'Do you really want to delete the selected data?', function (r) {
            if (r) {
                $('.loader').show();
                var url = site_url + 'transaction/vehicle/deletePO';
                $.post(url, {table: table, id: id}, function (data) {

                    obj = JSON.parse(data);
                    if (obj.success == true) {
                        $("#id").val('');
                        showAlert("Information", obj.message);
                        read_show('');
                    } else
                    {
                        $('.loader').hide();
                        showAlert("Error while deleting", '<font color="red">' + obj.message + '</font>');
                    }
                    scrlTop();
                });
            } else {
                $('#cmdDelete').linkbutton('enable');
            }
        });
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

    function formDisabled() {
        $('#form_validation :input').attr('disabled', true);
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

    function condReady() {
        scrlTop();
        // formaction();
        $('#form_validation :input').attr('disabled', false);
        $("#cust_code").attr('disabled', true);
        $('.easyui-combogrid').combogrid('enable');
        $('.easyui-combobox').combobox({disabled: false});

        $("#cls_by").attr('disabled', true);

        $("#veh_code").attr('disabled', true);
        $("#veh_brand").attr('disabled', true);
        $("#veh_transm").attr('disabled', true);
        $("#veh_year").attr('disabled', true);
        $("#veh_type").attr('disabled', true);
        $("#veh_model").attr('disabled', true);
        $("#color_code").attr('disabled', true);
        $("#supp_code").attr('disabled', true);
        $("#color_type").attr('disabled', true);
        $("#po_no").attr('disabled', true);
        $("#po_date").datebox('disable');
        $("#stdoptcode").attr('disabled', true);

        $("#cls_date").attr('disabled', true);
        $("#soseq_date").datebox('disable');
        $("#cls_date").datebox('disable');
        $("#match_date").datebox('disable');
        $("#dp_date").datebox('disable');

        $("#wrhs_code").combogrid('setValue', '<?php echo $wrhs_input; ?>');
        $("#wrhs_code").combogrid('disable');

        $("#tot_price").attr('disabled', true);
        $("#qty").val('1').attr('disabled', true);
        $("#unit").val('unit').attr('disabled', true);
        $("#pur_inv_no").attr('disabled', true);
        checkboxClick();
        cmdcondReady();

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

        $("#cmdClose").linkbutton('disable');
        $("#cmdUnClose").linkbutton('disable');
        $("#screen").linkbutton('disable');
        $("#print").linkbutton('disable');
    }

    function saveData() {
        $('.loader').show();
        $('#form_validation :input').attr('disabled', false);

        form.form('submit', {
            url: save_url,
            onSubmit: function () {
                return $(this).form('validate');
            },
            success: function (data) { //alert(data)
                var obj = JSON.parse(data);
                if (obj.success == true) {
                    showAlert("Information", obj.message);
                    read_show('');
                    $(".formError").remove();

                    $(".easyui-datebox").datebox('disable');
                } else
                {
                    updateFailed(obj);

                }
                scrlTop();
            }
        });
    }

    function closeBtn() {
        $.messager.confirm('Closing  Invoice', 'Close this PO? ', function (r) {
            if (r) {
                var id = $("#id").val();
                $('.loader').show();
                $.post(close_url, {table: table, id: id}, function (data) {

                    obj = JSON.parse(data);
                    if (obj.success == true) {

                        showAlert("Information", obj.message);
                        read_show('');
                    } else
                    {
                        $('.loader').hide();
                        showAlert("Error while closing", '<font color="red">' + obj.message + '</font>');
                    }
                    scrlTop();
                });
            }
            read_show('');
        });

    }

    function UncloseBtn() {
        $.messager.confirm('Unclosing PO', 'Unclose this PO?', function (r) {
            if (r) {

                var id = $("#id").val();
                $('.loader').show();
                $.post(unclose_url, {table: table, id: id}, function (data) {

                    obj = JSON.parse(data);
                    if (obj.success == true) {

                        showAlert("Information", obj.message);
                        read_show('');
                    } else
                    {
                        $('.loader').hide();
                        showAlert("Error while closing", '<font color="red">' + obj.message + '</font>');
                    }
                    scrlTop();
                });

            }
            read_show('');
        });

    }

    function print_sc(action) {

        var id = $("#id").val();
        var user = '<?php echo $_SESSION['C_USER']; ?>';

        var url = site_url + 'transaction/vehicle/outputpdf/<?php echo encrypt_decrypt('encrypt', 'veh_po'); ?>/' + id + '/' + user + '/' + action + '#toolbar=0';

        if (action == 'screen') {
            // $('#sr').window('open');
            //$('#sr').empty().append('<iframe   frameborder="0"  src="' + url + '" style="width:100%;height:auto;min-height: 500px;padding:0px;"></iframe>');
            window.open(url);
        } else {
            $('#sr').empty().append('<iframe   frameborder="0"  src="' + url + '" style="width:100%;height:auto;min-height: 500px;padding:0px;"></iframe>');
        }
    }

    $(document).ready(function () {
        checkRunMonthYear('VPO');
        tableId();
        dateTop();
        read_show('')
        version('03.17-31');
    });

</script>