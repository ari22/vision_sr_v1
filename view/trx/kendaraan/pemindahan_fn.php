<script>

    var table = 'veh_movh';
    var form = $('#form_validation');
    var save_url = site_url + 'transaction/vehicle/saveMove/<?php echo $_SESSION['C_USER']; ?>';
    var unclose_url = site_url + 'transaction/vehicle/uncloseMove/<?php echo $_SESSION['C_USER']; ?>';
    var close_url = site_url + 'transaction/vehicle/closeMove/<?php echo $_SESSION['C_USER']; ?>';
    var delete_url = site_url + 'transaction/vehicle/deleteMove';

    var divtableId = $("#tableId");
    var ttable = $('#dt');

    var table2 = 'veh_movd';
    var ttable2 = $('#dt2');
    var divtableId2 = $("#tableId2");

    $("#mvrep_name").combogrid({
        onSelect: function (index, rowData) {
            $("#form_validation #mvrep_code").val(rowData.mvrep_code);
        }
    });

    $("#chassis").combogrid({
        onSelect: function (index, rowData) {
            $.each(rowData, function (i, v) {
                if (i !== 'id') {
                    $("#form_validation #" + i).val(v);
                    if (i == 'pr2b_price' || i == 'pr2o_price' || i == 'pr2_vat' || i == 'pr2_pbm' || i == 'pr2_pph' || i == 'pr2_misc' || i == 'pr2_price') {
                        $("#" + i).numberbox('setValue', v);
                    }
                    if (i == 'sji_date' || i == 'do_date' || i == 'pur_date') {
                        if (v !== '0000-00-00') {
                            var vdate = dateSplit(v);

                            $("#" + i).datebox('setValue', vdate);
                        }
                    }
                    if (i == 'wrhs_code') {
                        $("#form_validation #wrhs_from").combogrid('setValue', v);
                    }
                    if (i == 'loc_code') {
                        $("#form_validation #loc_from").combogrid('setValue', v);
                    }
                    if (i == 'mvrep_name') {
                        $("#form_validation #mvrep_name").combogrid('setValue', v);
                    }
                }
            });
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
            $(".easyui-datebox").datebox('setValue', '');

            if (json !== '[]') {

                var rowData = $.parseJSON(json);

                $.each(rowData, function (i, v) {
                    $("#form_validation #" + i).val(v);

                    if (i == 'pr2b_price' || i == 'pr2o_price' || i == 'pr2_vat' || i == 'pr2_pbm' || i == 'pr2_pph' || i == 'pr2_misc' || i == 'pr2_price') {
                        $("#" + i).numberbox('setValue', v);
                    }
                    if (i == 'mov_date' || i == 'opn_date' || i == 'cls_date' || i == 'sji_date' || i == 'do_date' || i == 'pur_date') {
                        if (v !== '0000-00-00') {
                            var vdate = dateSplit(v);

                            $("#" + i).datebox('setValue', vdate);
                        }
                    }
                    if (i == 'wrhs_from' || i == 'loc_from' || i == 'wrhs_to' || i == 'loc_to' || i == 'chassis') {
                        $("#form_validation #" + i).combogrid('setValue', v);
                    }

                    if (i == 'mvrep_code') {
                        $("#form_validation #mvrep_code").val(v);
                    }
                    if (i == 'mvrep_name') {
                        $("#form_validation #mvrep_name").combogrid('setValue', v);
                    }

                });


                var mov_inv_no = rowData.mov_inv_no;
                table_grid(ttable, mov_inv_no);

                cmdcondAwal();
                formDisabled();

                if (rowData.cls_date == null || rowData.cls_date == '0000-00-00' || rowData.cls_date == '0000-00-00 00:00:00') {
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


        });
    }

    function doSearch() {
        $("#tableSearch").datagrid('load', {
            field1: $('#mov_inv_no2').val(),
            field2: $('#mov_date2').datebox('getValue')
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
        var url = site_url + 'transaction/vehicle/outputpdf/<?php echo encrypt_decrypt('encrypt', 'veh_movh'); ?>/' + ids + '/<?php echo $_SESSION['C_USER']; ?>/' + key + '/<?php echo encrypt_decrypt('encrypt', 'mov_inv_no'); ?>/<?php echo encrypt_decrypt('encrypt', 'VMV'); ?>#toolbar=0';

        if (key == 'print') {
            $("#sr").empty().append('<iframe frameborder="0"  src="' + url + '" style="width:100%;height:auto;min-height: 500px;padding:0px;"></iframe>');
            // $("#screenWindow").window('open');
        }

        if (key == 'screen') {
            window.open(url);
        }

        if (key == 'download') {
            $("#sr").empty().append('<iframe frameborder="0"  src="' + url + '" style="width:100%;height:auto;min-height: 500px;padding:0px;"></iframe>');
            // $("#screenWindow").window('open');
        }
    }

    function table_grid(ttable, mov_inv_no) {
        ttable.datagrid({
            method: 'post',
            url: site_url + '<?php echo 'builder/datagrid/' . encrypt_decrypt('encrypt', 'acc_movd'); ?>/mov_inv_no/' + mov_inv_no + '/?grid=true',
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
                    {field: 'part_code', title: '<?php getCaption("Kode Barang"); ?>', width: 80, height: 20, sortable: true},
                    {field: 'part_name', title: '<?php getCaption("Nama Barang"); ?>', width: 250, height: 20, sortable: true},
                    {field: 'wrhs_from', title: '<?php getCaption("Dari Warehouse"); ?>', width: 120, height: 20, sortable: true},
                    {field: 'loc_from', title: '<?php getCaption("Dari Lokasi"); ?> ', width: 120, height: 20, sortable: true},
                    {field: 'wrhs_to', title: '<?php getCaption("Ke Warehouse"); ?>', width: 120, height: 20, sortable: true},
                    {field: 'loc_to', title: '<?php getCaption("Ke Lokasi"); ?>', width: 120, height: 20, sortable: true},
                    {field: 'qty', title: '<?php getCaption("QTY"); ?>', width: 100, height: 20, sortable: true, align: 'right'},
                    {field: 'unit', title: '<?php getCaption("satuan"); ?>', width: 100, height: 20, sortable: true},
                    {field: 'note', title: '<?php getCaption("Catatan"); ?>', width: 250, height: 20, sortable: true},
                    {field: 'add_by', title: '<?php getCaption("Ditambahkan Oleh"); ?>', width: 250, height: 20, sortable: true}

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

        $('#form_validation #mvrep_name').combogrid('enable');
        $('#form_validation #wrhs_to').combogrid('enable');
        $('#form_validation #loc_to').combogrid('enable');
        $('#form_validation #chassis').combogrid('enable');
        $('#form_validation #note').attr('disabled', false);
        /* $(".easyui-datebox").datebox('enable');
         $('#form_validation :input').attr('disabled', false);
         
         $('#form_validation .easyui-combobox').combobox({disabled: false});
         
         
         
         $('#form_validation #mov_date').datebox('disable');
         $('#form_validation #cls_date').datebox('disable');
         $("#form_validation #mov_inv_no, #mvrep_code, #tot_item, #tot_qty").attr('disabled', true);
         
         */

        cmdcondReady();
    }
    $('#form_validation #mvrep_name').combogrid({
        onSelect: function (index, row) {
            $('#form_validation #mvrep_code').val(row.mvrep_code);
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

        $("#form_validation #cmdClose").linkbutton('disable');
        $("#form_validation #cmdUnClose").linkbutton('disable');
        $("#form_validation #screen").linkbutton('disable');
        $("#form_validation #print").linkbutton('disable');

    }

    function condAdd() {
        $('.easyui-numberbox').numberbox('setValue', '');
        $('#form_validation #id').val('');
        $('#form_validation input:text').val('');
        $("#form_validation #table").val(table);
        //$('#form_validation .easyui-combogrid').combogrid('setValue', '');
        $('#form_validation #tot_item, #tot_qty').numberbox('setValue', '');
        $(".easyui-datebox").datebox('setValue', '');
        $('#form_validation #opn_date').datebox('setValue', '<?php echo date('Y-m-d'); ?>');

        $.post(site_url + 'transaction/accessories/get_number/VMV', function (num) {
            $("#form_validation #mov_inv_no").val(num);
        });

        condReady();


    }
    function condEdit() {
        condReady();
    }
    function condDelete() {
        var id = $("#form_validation #id").val();
        var table = $("#form_validation #table").val();
        $.messager.confirm('Warning', 'Do you really want to delete this record?', function (r) {
            if (r) {
                $(".loader").show();
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
                $(".loader").show();
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
            }
        });
    }



    function parseCurrency(num) {
        return num.replace(/[^0-9]/g, '');
    }

    /*End Detail*/

    $(document).ready(function () {
        checkRunMonthYear('VMV');
        tableId();
        read_show('')
        version('03.17-31');

    });
</script>