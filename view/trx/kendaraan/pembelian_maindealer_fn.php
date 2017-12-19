<script>
    //=========CHANGE LOG========
    //VAT dibetulin
    var table = 'veh_prh';
    var divtableId = $("#tableId");
    var close_url = site_url + 'transaction/vehicle/closePembelian/<?php echo $_SESSION['C_USER']; ?>';
    var unclose_url = site_url + 'transaction/vehicle/unclosePembelian/<?php echo $_SESSION['C_USER']; ?>';
    var save_url = site_url + 'transaction/vehicle/savePenerimaan/pembelian';
    var form = $('#form_validation');

    var cls_date = 'cls2_date';

    $("#unit_price").keyup(function () {
        var val = parseCurrency($(this).val());
        var tot = $("#qty").val() * val;

        $("#tot_price").numberbox('setValue', tot);
        //$("#unit_price").numberbox('setValue', val);

    });

    function parseCurrency(num) {
        return num.replace(/[^0-9]/g, '');
    }
    function tableId() {
        divtableId.empty().append('<input type="hidden" name="id"  id="id"><input type="hidden" name="table"  id="table" value="' + table + '">');
    }

    function read_show(nav) {
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

                    if (i == 'pur_date'
                            || i == 'stk_date'
                            || i == 'po_date'
                            || i == 'due_date'
                            || i == 'cls2_date'
                            || i == 'pred_stk_d'
                            || i == 'sji_date'
                            || i == 'kwiti_date'
                            || i == 'fpi_date'
                            || i == 'dni_date'
                            || i == 'do_date'
                            || i == 'pdi_date') {


                        if (v !== '0000-00-00') {
                            var vdate = dateSplit(v);
                            $("#" + i).datebox('setValue', vdate);
                        }
                    }


                    if (i == 'supp_name'
                            || i == 'wrhs_code'
                            || i == 'loc_code'
                            || i == 'veh_name'
                            || i == 'stdoptcode'
                            || i == 'color_name') {

                        $("#" + i).combogrid('setValue', v);

                    }

                    if (i == 'due_day'
                            || i == 'unit_price'
                            || i == 'tot_price'
                            || i == 'pur_base'
                            || i == 'pur_opt'
                            || i == 'pur_bt'
                            || i == 'pur_pbm1'
                            || i == 'pur_pbm2'
                            || i == 'pur_pbm'
                            || i == 'pur_pph1'
                            || i == 'pur_pph'
                            || i == 'pur_misc1'
                            || i == 'pur_misc2'
                            || i == 'pur_misc'
                            || i == 'pur_vat1'
                            || i == 'pur_vat2'
                            || i == 'pur_vat'
                            || i == 'pur_price1'
                            || i == 'pur_price2'
                            || i == 'pur_price'
                            ) {

                        $("#" + i).numberbox('setValue', v);

                    }
                });

                formDisabled();

                if (rowData.cls2_date == null || rowData.cls2_date == '0000-00-00') {
                    $("#print").linkbutton('disable');
                    $("#screen").linkbutton('disable');
                    $("#closeOn").empty().append('<button type="button" id="cmdClose" title="<?php getCaption("Close"); ?>" class="easyui-linkbutton easyui-tooltip btn btn-success" data-options="iconCls:\'icon-close\'"  onclick="rolesClose()">Close</button>');

                } else {
                    $('.cmdEdit').linkbutton('disable');
                    $("#cmdDelete").linkbutton('disable');
                    $("#closeOn").empty().append('<button type="button" id="cmdUnClose" title="<?php getCaption("unClose"); ?>" class="easyui-linkbutton easyui-tooltip btn btn-success" data-options="iconCls:\'icon-unclose\'" onclick="rolesUnclose()">Unclose</button>');

                    $("#print").removeAttr('disabled')
                    $("#print").linkbutton('enable');
                    $("#screen").removeAttr('disabled')
                    $("#screen").linkbutton('enable');
                }

                $('.easyui-linkbutton').linkbutton();
                $('.loader').hide();

            } else {

                $(".loader").hide();

            }

        });
    }

    function doSearch() {
        $("#tableSearch").datagrid('load', {
            field1: $('#pur_inv_no2').val(),
            field2: $('#po_no2').val()
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
        showAlert("Message", 'Unable to add Vehicle Purchase. Please add Vehicle Purchase through vehicle receiving');
    }

    function condEdit() {
        condReady();
    }

    function condCancel() {
        read_show('');
    }

    function condDelete() {
        showAlert("Message", 'Unable to delete Vehicle Purchase. Please delete Vehicle Purchase through Vehicle Receiving');

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
        $("#due_date,#sji_date,#kwiti_date,#fpi_date,#dni_date,#do_date,#pdi_date").datebox('enable');
        $('#due_day, #unit_price, #pur_base, #pur_opt, #pur_pbm1, #pur_pbm2, #pur_pph1, #pur_misc1, #pur_misc2').numberbox('enable');
        $('#note, #alarm, #key_no, #serv_book, #sji_no, #kwiti_no, #fpi_no, #dni_no, #do_no, #pdi_no, #po_made_by, #po_appr_by, #po_desc ').attr('disabled', false);

        checkboxClick();
        cmdcondReady();
    }

    function sumBasePrice() {
        pur_base = $("#form_validation #pur_base").val();
        pur_vat1 = (parsePrice(pur_base) / 100) * 10;

        pur_pbm1 = $("#form_validation #pur_pbm1").val();
        pur_pph1 = $("#form_validation #pur_pph1").val();
        pur_misc1 = $("#form_validation #pur_misc1").val();

        pur_price1 = parsePrice(pur_base) + pur_vat1 + parsePrice(pur_pbm1) + parsePrice(pur_pph1) + parsePrice(pur_misc1);

        $('#form_validation #pur_vat1').numberbox('setValue', pur_vat1);
        $('#form_validation #pur_price1').numberbox('setValue', pur_price1);

        purPriceRow();
    }

    function sumOptPrice() {
        pur_opt = $("#form_validation #pur_opt").val();
        pur_vat2 = (parsePrice(pur_opt) / 100) * 10;
        pur_pbm2 = $("#form_validation #pur_pbm2").val();
        pur_misc2 = $("#form_validation #pur_misc2").val();

        pur_price2 = parsePrice(pur_opt) + pur_vat2 + parsePrice(pur_pbm2) + parsePrice(pur_misc2);

        $('#form_validation #pur_vat2').numberbox('setValue', pur_vat2);
        $('#form_validation #pur_price2').numberbox('setValue', pur_price2);

        purPriceRow();
    }

    function  purPriceRow() {
        pur_base = $("#form_validation #pur_base").val();
        pur_opt = $("#form_validation #pur_opt").val();

        pur_bt = parsePrice(pur_base) + parsePrice(pur_opt);
        $('#form_validation #pur_bt').numberbox('setValue', pur_bt);

        pur_vat1 = $("#form_validation #pur_vat1").val();
        pur_vat2 = $("#form_validation #pur_vat2").val();

        pur_vat = parsePrice(pur_vat1) + parsePrice(pur_vat2);
        $('#form_validation #pur_vat').numberbox('setValue', pur_vat);

        pur_pbm1 = $("#form_validation #pur_pbm1").val();
        pur_pbm2 = $("#form_validation #pur_pbm2").val();

        pur_pbm = parsePrice(pur_pbm1) + parsePrice(pur_pbm2);
        $('#form_validation #pur_pbm').numberbox('setValue', pur_pbm);

        pur_pph1 = $("#form_validation #pur_pph1").val();
        $('#form_validation #pur_pph').numberbox('setValue', pur_pph1);

        pur_misc1 = $("#form_validation #pur_misc1").val();
        pur_misc2 = $("#form_validation #pur_misc2").val();

        pur_misc = parsePrice(pur_misc1) + parsePrice(pur_misc2);
        $('#form_validation #pur_misc').numberbox('setValue', pur_misc);

        pur_price1 = $("#form_validation #pur_price1").val();
        pur_price2 = $("#form_validation #pur_price2").val();

        pur_price = parsePrice(pur_price1) + parsePrice(pur_price2);
        $('#form_validation #pur_price').numberbox('setValue', pur_price);
    }
    function parsePrice(number) {
        return Number(number.replace(/[^0-9\.]+/g, ""));
    }

    function cmdcondReady() {
        $('.cmdFirst').linkbutton('disable');
        $('.cmdPrev').linkbutton('disable');
        $('.cmdNext').linkbutton('disable');
        $('.cmdLast').linkbutton('disable');

        $('.cmdSave').removeAttr('disabled');
        $('.cmdCancel').removeAttr('disabled');

        $('.cmdSave').linkbutton('enable');
        $('.cmdCancel').linkbutton('enable');

        $('.cmdAdd').linkbutton('disable');
        $('.cmdEdit').linkbutton('disable');
        $('.cmdDelete').linkbutton('disable');
        $('.cmdSearch').linkbutton('disable');

        $("#cmdBrowse").linkbutton('disable');

        $("#print").linkbutton('disable');
        $("#screen").linkbutton('disable');
        $("#cmdClose").linkbutton('disable');
        $("#cmdUnClose").linkbutton('disable');
    }

    function saveData() {
        $('.loader').show();
        var id = $("#id").val();
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

                    if (id == '') {
                        $("#id").val('');
                    }
                    read_show('');
                    $(".formError").remove();

                    $(".easyui-datebox").datebox('disable');
                } else
                {
                    updateFailed(obj);
                    /*
                     $('.loader').hide();
                     
                     if(obj.status == 'error'){
                     showAlert("Error while saving", '<font color="red">' + obj.message + '</font>');
                     read_show('P');
                     return false;
                     }
                     condReady();
                     
                     showAlert("Error while saving", '<font color="red">' + obj.message + '</font>');
                     */
                }
                scrlTop();
            }
        });
    }

    function closeBtn() {
        $.messager.confirm('Closing  Invoice', 'Close this Invoice?', function (r) {
            if (r) {
                $('.loader').show();

                var stat = true;
                var msg = '';
                var id = $("#id").val();
                var tot_price = $('#tot_price').val();
                var due_date = $("#due_date").datebox('getValue');

                if (tot_price == '' || tot_price == 0) {
                    stat = false;
                    msg = 'Please enter Vehicle Data -> Vehicle Price';
                }
                if (due_date == '') {
                    stat = false;
                    msg = 'Please input TOP Date';
                }

                if (stat !== false) {
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


                } else {
                    $('.loader').hide();
                    showAlert("Error while closing", '<font color="red">' + msg + '</font>');
                }
            }
            read_show('');
        });

    }

    function UncloseBtn() {
        $.messager.confirm('UnClosing Invoice', 'Open this invoice?', function (r) {
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

            } else {
                read_show('');
                $.messager.show({title: 'Information', msg: 'Invoice unclose aborted', icon: 'info', width: 300, timeout: 2000, showType: 'fade', style: {right: '50%', top: '', bottom: '50%'}});

            }

        });

    }

    function print_sc(action) {

        var id = $("#id").val();
        var user = '<?php echo $_SESSION['C_USER']; ?>';

        var url = site_url + 'transaction/vehicle/outputpdf/<?php echo encrypt_decrypt('encrypt', 'veh_prh'); ?>/' + id + '/' + user + '/' + action + '/pembelian#toolbar=0';

        if (action == 'screen') {
            // $('#sr').window('open');
            //$('#sr').empty().append('<iframe   frameborder="0"  src="' + url + '" style="width:100%;height:auto;min-height: 500px;padding:0px;"></iframe>');
            window.open(url);
        } else {
            $('#sr').empty().append('<iframe   frameborder="0"  src="' + url + '" style="width:100%;height:auto;min-height: 500px;padding:0px;"></iframe>');
        }
    }


    $(document).ready(function () {
        checkRunMonthYear('VPR');
        tableId();
        dateTop();
        read_show('');
        version('03.17-31');
    });
</script>