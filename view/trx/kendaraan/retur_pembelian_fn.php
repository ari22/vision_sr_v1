<!--table veh_rslh  dan veh_stk-->
<script>
    var table = 'veh_rprh';
    var form = $('#form_validation');
    var save_url = site_url + 'transaction/vehicle/saveReturnPembelian';
    var unclose_url = site_url + 'transaction/vehicle/uncloseReturnPembelian/<?php echo $_SESSION['C_USER']; ?>';
    var close_url = site_url + 'transaction/vehicle/closeReturnPembelian/<?php echo $_SESSION['C_USER']; ?>';
    var delete_inv_url = site_url + 'transaction/vehicle/DeleteVPRReturn';
        
    var ttable = $('#dt_jasa');
    var divtableId = $("#tableId");

    var table2 = 'veh_rsld';
    var ttables = $('#dt_jasa2');
    var divtableId2 = $("#tableId2");


    $("#unit_price").keyup(function () {
        var val = parseCurrency($(this).val());
        var tot = $("#qty").val() * val;

        $("#tot_price").numberbox('setValue', tot);

    });

    $("#pur_base").keyup(function () {
        var pur_base = parseCurrency($(this).val());
        var pur_opt = parseCurrency($('#pur_opt').val());
        var pur_bt = parseCurrency($('#pur_bt').val());
        var pur_pph = parseCurrency($('#pur_pph').val());
        var pur_pbm = parseCurrency($('#pur_pbm').val());
        var pur_misc = parseCurrency($('#pur_misc').val());

        detail_price(pur_base, pur_opt, pur_bt, pur_pph, pur_pbm, pur_misc);
    });

    $("#pur_pbm").keyup(function () {
        var pur_base = parseCurrency($("#pur_base").val());
        var pur_opt = parseCurrency($('#pur_opt').val());
        var pur_bt = parseCurrency($('#pur_bt').val());
        var pur_pph = parseCurrency($('#pur_pph').val());
        var pur_pbm = parseCurrency($(this).val());
        var pur_misc = parseCurrency($('#pur_misc').val());

        detail_price(pur_base, pur_opt, pur_bt, pur_pph, pur_pbm, pur_misc);
    });
    $("#pur_pph").keyup(function () {
        var pur_base = parseCurrency($("#pur_base").val());
        var pur_opt = parseCurrency($('#pur_opt').val());
        var pur_bt = parseCurrency($('#pur_bt').val());
        var pur_pph = parseCurrency($(this).val());
        var pur_pbm = parseCurrency($("#pur_pbm").val());
        var pur_misc = parseCurrency($('#pur_misc').val());

        detail_price(pur_base, pur_opt, pur_bt, pur_pph, pur_pbm, pur_misc);
    });
    $("#pur_misc").keyup(function () {
        var pur_base = parseCurrency($("#pur_base").val());
        var pur_opt = parseCurrency($('#pur_opt').val());
        var pur_bt = parseCurrency($('#pur_bt').val());
        var pur_pph = parseCurrency($("#pur_pph").val());
        var pur_pbm = parseCurrency($("#pur_pbm").val());
        var pur_misc = parseCurrency($(this).val());

        detail_price(pur_base, pur_opt, pur_bt, pur_pph, pur_pbm, pur_misc);
    });


    function parseCurrency(num) {
        return num.replace(/[^0-9]/g, '');
    }

    function detail_price(pur_base, pur_opt, pur_bt, pur_pph, pur_pbm, pur_misc) {
        if (pur_base == '') {
            pur_base = 0;
        }
        if (pur_pbm == '') {
            pur_pbm = 0;
        }
        if (pur_pph == '') {
            pur_pph = 0;
        }
        if (pur_misc == '') {
            pur_misc = 0;
        }


        var pur_bt = parseInt(pur_base) + parseInt(pur_opt);
        var pur_vat = (pur_base / 100) * 10
        var pur_vat1 = (pur_bt / 100) * 10;
        var pur_vat2 = (pur_opt / 100) * 10;

        var pur_pph1 = pur_pph;
        var pur_pbm2 = parseCurrency($("#pur_pbm2").val());

        if (pur_pbm2 == '') {
            pur_pbm2 = 0;
        }
        var pur_pbm1 = parseInt(pur_pbm) + parseInt(pur_pbm2);

        var pur_misc2 = parseCurrency($("#pur_misc2").val());

        if (pur_misc2 == '') {
            pur_misc2 = 0;
        }
        var pur_misc1 = parseInt(pur_misc) + parseInt(pur_misc2);


        var pur_price = parseInt(pur_base) + parseInt(pur_vat) + parseInt(pur_pbm) + parseInt(pur_pph) + parseInt(pur_misc);
        var pur_price2 = parseInt(pur_opt) + parseInt(pur_vat2) + parseInt(pur_pbm2) + parseInt(pur_misc2);
        var pur_price1 = parseInt(pur_bt) + parseInt(pur_vat1) + parseInt(pur_pbm1) + parseInt(pur_pph1) + parseInt(pur_misc1);

        $("#pur_base").numberbox('setValue', pur_base);
        $("#pur_opt").numberbox('setValue', pur_opt);
        $("#pur_bt").numberbox('setValue', pur_bt);

        $("#pur_vat").numberbox('setValue', pur_vat);
        $("#pur_vat1").numberbox('setValue', pur_vat1);
        $("#pur_vat2").numberbox('setValue', pur_vat2);

        $("#pur_pph").numberbox('setValue', pur_pph);
        $("#pur_pph1").numberbox('setValue', pur_pph1);

        $("#pur_pbm1").numberbox('setValue', pur_pbm1);
        $("#pur_pbm2").numberbox('setValue', pur_pbm2);

        $("#pur_misc1").numberbox('setValue', pur_misc1);
        $("#pur_misc2").numberbox('setValue', pur_misc2);

        $("#pur_price").numberbox('setValue', pur_price);
        $("#pur_price2").numberbox('setValue', pur_price2);
        $("#pur_price1").numberbox('setValue', pur_price1);


    }

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
                $('#form_validation .srep_sex_' + rowData.srep_sex).prop("checked", true);

                $.each(rowData, function (i, v) {
                    if (v !== '') {

                        $("#" + i).val(v);
                      

                        if (i == 'pur_date' ||
                                i == 'pred_stk_d' ||
                                i == 'due_date' ||
                                i == 'rpr_date' ||
                                i == 'cls_date' ||
                                i == 'sji_date' ||
                                i == 'kwiti_date' ||
                                i == 'fpi_date' ||
                                i == 'dni_date' ||
                                i == 'do_date' ||
                                i == 'pdi_date' ||
                                i == 'sji2_date' ||
                                i == 'kwiti2date' ||
                                i == 'fpi2_date' ||
                                i == 'dni2_date') {

                            if (v !== '0000-00-00') {
                                var vdate = dateSplit(v);

                                $("#" + i).datebox('setValue', vdate);
                            }
                        }

                        if (i == 'due_day' || i == 'unit_price' ||
                                i == 'tot_price' ||
                                i == 'pur_base' ||
                                i == 'pur_opt' ||
                                i == 'pur_bt' ||
                                i == 'pur_vat' ||
                                i == 'pur_vat2' ||
                                i == 'pur_vat1' ||
                                i == 'pur_pbm' ||
                                i == 'pur_pbm1' ||
                                i == 'pur_pbm2' ||
                                i == 'pur_pph' ||
                                i == 'pur_pph1' ||
                                i == 'pur_misc' ||
                                i == 'pur_misc1' ||
                                i == 'pur_misc2' ||
                                i == 'pur_price' ||
                                i == 'pur_price1' ||
                                i == 'pur_price2') {

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
                    $("#closeOn").empty().append('<button type="button" id="cmdClose" title="<?php getCaption("Close"); ?>" class="easyui-linkbutton easyui-tooltip btn btn-success"  data-options="iconCls:\'icon-close\'" onclick="rolesClose()">Close</button>');

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


        });
    }

    function doSearch() {
        $("#tableSearch").datagrid('load', {
            field1: $('#rpr_inv_no').val(),
            field3: $('#pur_inv_no').val()
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

        $('#cmdDeletePRH').removeAttr('disabled');
        $("#cmdDeletePRH").linkbutton('enable');

        $('#cmdSearchPRH').attr('disabled', true);
        $("#cmdSearchPRH").linkbutton('disable');
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

        $('#cmdSearchPRH').removeAttr('disabled');
        $("#cmdSearchPRH").linkbutton('enable');

        $('#cmdDeletePRH').attr('disabled', true);
        $("#cmdDeletePRH").linkbutton('disable');
    }
    function condReady() {
        scrlTop();
        // formaction();
        $("#qty").val('1');
        $("#unit").val('unit');
        // $('#pur_inv_no').combogrid('enable');
        $("#due_day, #note, #unit_price, #pur_base, #pur_pbm, #pur_pph, #pur_misc, #pur_inv_no").attr('disabled', false);
        $("#sji_no,#kwiti_no,#fpi_no,#dni_no,#do_no,#pdi_no,#sji2_no,#kwiti2_no,#fpi2_no,#dni2_no").attr('disabled', false);
        $("#pur_date, #due_date,#sji_date,#kwiti_date,#fpi_date,#dni_date,#do_date,#pdi_date,#sji2_date,#kwiti2date,#fpi2_date,#dni2_date").datebox('enable');
        cmdcondReady();
    }

    function condDelete() {
        var id = $("#form_validation #id").val();
        var table = $("#form_validation #table").val();
        $.messager.confirm('Warning', 'Do you really want to delete the selected data ?', function (r) {
            if (r) {

                var url = site_url + 'transaction/vehicle/deleteReturnPembelian';
                $.post(url, {table: table, id: id}, function (data) {
                    obj = JSON.parse(data);
                    if (obj.success == true) {
                        $("#id").val('');
                        showAlert("Information", obj.message);

                        read_show('');
                        //$('#pur_inv_no').combogrid('grid').datagrid('reload');
                    } else
                    {
                        showAlert("Error while deleting", '<font color="red">' + obj.message + '</font>');
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

        // $("#due_date").datebox('setValue', '<?php echo date('Y-m-d'); ?>');        
        $.post(site_url + 'transaction/vehicle/get_number/VRP', function (num) {
            $("#form_validation #rpr_inv_no").val(num);
        });

        condReady();

    }

    function condEdit() {
        condReady();

    }
    function condCancel() {
        read_show('');
    }

    function saveData() {

        var pur_inv_no = $("#pur_inv_no").val();
        var stat = true;

        if (pur_inv_no == '') {
            msg = 'Please choose an invoice no.';
            stat = false;
        }

        if (stat !== false) {
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
                        read_show('');
                      //  $('#pur_inv_no').combogrid('grid').datagrid('reload');
                    } else
                    {

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
            url: site_url + '<?php echo 'builder/grid_sld/' . encrypt_decrypt('encrypt', 'veh_rsld'); ?>/' + rsl_inv_no + '/?grid=true',
            title: 'Deskripsi Service',
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
                    {field: 'wk_desc', title: '<?php getCaption("Nama Pekerjaan"); ?>', width: 120, height: 20, sortable: true},
                    {field: 'price_bd', title: '<?php getCaption("Harga Jual"); ?>', width: 100, height: 20, align: 'center', sortable: true},
                    {field: 'disc_pct', title: '<?php getCaption("Diskon"); ?> %', width: 100, height: 20, align: 'center', sortable: true},
                    {field: 'disc_val', title: '<?php getCaption("Jumlah Diskon"); ?>', width: 100, height: 20, align: 'center', sortable: true},
                    {field: 'price_ad', title: '<?php getCaption("Harga Netto"); ?>', width: 100, height: 20, align: 'center', sortable: true},
                    {field: 'add_by', title: '<?php getCaption("Ditambahkan Oleh"); ?>', width: 100, height: 20, align: 'center', sortable: true}

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

                if (due_date == '' || due_date == '<?php echo date("Y-m-d"); ?>') {
                    msg = 'TOP counted from today';
                    stat = false;
                }
                if (due_day == '' || due_day == '0') {
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
                            showAlert("Error while closed", '<font color="red">' + obj.message + '</font>');
                        }
                        scrlTop();
                    });

                } else {
                    showAlert("Error while closed", '<font color="red">' + msg + '</font>');
                }

            }
            read_show('');
        });

    }

    function UncloseBtn() {
        $.messager.confirm('Unclosing Invoice', 'Unclose this Invoice?', function (r) {
            if (r) {

                var id = $("#id").val();

                $.post(unclose_url, {table: table, id: id}, function (data) { //alert(data)

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



    function print_sc(action) {

        var id = $("#id").val();
        var user = '<?php echo $_SESSION['C_USER']; ?>';

        var url = site_url + 'transaction/vehicle/outputpdf/<?php echo encrypt_decrypt('encrypt', 'veh_rprh'); ?>/' + id + '/' + user + '/' + action + '#toolbar=0';

        if (action == 'screen') {
            // $('#sr').window('open');
            //$('#sr').empty().append('<iframe   frameborder="0"  src="' + url + '" style="width:100%;height:auto;min-height: 500px;padding:0px;"></iframe>');
            window.open(url);
        } else {
            $('#sr').empty().append('<iframe   frameborder="0"  src="' + url + '" style="width:100%;height:auto;min-height: 500px;padding:0px;"></iframe>');
        }
    }

    function condFindPRH() {
        var pur_inv_no = $("#pur_inv_no").val();
        var pur_date = $("#pur_date").datebox('getValue');

        stat = true;

        if (pur_date == '') {
            stat = false;
            msg = 'Please enter Purchase Date';
        }
        if (pur_inv_no == '') {
            stat = false;
            msg = 'Please enter Purchase No.';
        }

        
        if (stat !== false) {
            var url = "services/runCRUD.php?func=finddata&lookup=trx/veh_rprh&pk=pur_inv_no&sk=pur_inv_no";

            $.post(url, {pur_inv_no: pur_inv_no, pur_date: pur_date}, function (json) {
    
                if (json !== '[]') {

                    var rows = $.parseJSON(json);

                    if (rows.status !== false) {

                        var rowData = rows.data;

                        $('#form_validation .cust_sex_' + rowData.cust_sex).prop("checked", true);
                        $('#form_validation .cust_type_' + rowData.cust_type).prop("checked", true);
                        $('#form_validation .cust_rsex_' + rowData.cust_rsex).prop("checked", true);
                        $('#form_validation .srep_sex_' + rowData.srep_sex).prop("checked", true);
                        $('#form_validation .srep_sex_' + rowData.srep_sex).prop("checked", true);

                        $.each(rowData, function (i, v) {
                            if (v !== '') {

                                if (i !== 'id') {
                                    $("#" + i).val(v);

                                    if (i == 'pur_date' || i == 'pred_stk_d' || i == 'due_date' || i == 'sji_date' || i == 'kwiti_date' || i == 'fpi_date' || i == 'dni_date' || i == 'do_date' || i == 'pdi_date' || i == 'sji2_date' || i == 'kwiti2date' || i == 'fpi2_date' || i == 'dni2_date') {
                                        if (v !== '0000-00-00') {
                                            var vdate = dateSplit(v);

                                            $("#" + i).datebox('setValue', vdate);
                                        }
                                    }

                                    if (i == 'due_day' || i == 'unit_price' || i == 'tot_price') {
                                        $("#" + i).numberbox('setValue', v);
                                    }


                                }


                            } else {
                                 $("#" + i).val('');
                            }

                        });
                        
                        $("#cls_by").val('');
                        $("#pur_pbm").numberbox('setValue', 0);
                        $("#pur_misc").numberbox('setValue', 0);
                        detail_price(rowData.pur_base, rowData.pur_opt, rowData.pur_bt, rowData.pur_pph, 0, 0)
                    } else {
                        $.messager.alert('Warning', rows.msg, 'warning');
                    }
                }
            });
        }
        
    }
    function condDeletePRH() {
        $.messager.confirm('Warning', 'Do you really want to delete the Purchase No.?', function (r) {
            if (r) {
                var pur_inv_no = $("#pur_inv_no").val();
                var id = $("#id").val();

                $.post(delete_inv_url, {table: table, id: id, pur_inv_no: pur_inv_no}, function (data) {
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
        checkRunMonthYear('VRP');
        tableId();
        dateTop();
        read_show('');
        version('03.17-31');
    });
</script>