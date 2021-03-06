<script>

    var table = 'acc_prh';
    var form = $('#form_validation');
    var save_url = site_url + 'transaction/accessories/saveAccessories/<?php echo $_SESSION['C_USER']; ?>';
    var unclose_url = site_url + 'transaction/accessories/unclosePembelian/<?php echo $_SESSION['C_USER']; ?>';
    var close_url = site_url + 'transaction/accessories/closePembelian/<?php echo $_SESSION['C_USER']; ?>';
    var delete_url = site_url + 'transaction/accessories/delete_accesories';

    var divtableId = $("#tableId");
    var ttable = $('#dt');

    var table2 = 'acc_prd';
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

                    if (i == 'pur_date' || i == 'opn_date' || i == 'rcv_date' || i == 'cls2_date' || i == 'sj_date' || i == 'supp_invdt' || i == 'po_date' || i == 'due_date') {
                        if (v !== '0000-00-00') {
                            var v_date = dateSplit(v);
                            $("#" + i).datebox('setValue', v_date);
                        }
                    }

                    if (i == 'wrhs_code' || i == 'supp_name' || i == 'po_no') {
                        $("#form_validation #" + i).combogrid('setValue', v);
                    }


                    if (i == 'tot_item' || i == 'tot_qty' || i == 'tot_price' || i == 'inv_disc' || i == 'inv_bt' || i == 'inv_vat' || i == 'inv_at' || i == 'inv_stamp' || i == 'inv_total' || i == 'due_day') {
                        $("#form_validation #" + i).numberbox('setValue', v);
                    }

                });



                var pur_inv_no = rowData.pur_inv_no;
                table_grid(ttable, pur_inv_no);

                cmdcondAwal();
                formDisabled();

                if (rowData.cls2_date == null || rowData.cls2_date == '0000-00-00' || rowData.cls2_date == '0000-00-00 00:00:00') {
                    $("#cmdDetail").removeAttr('disabled');
                    $('#cmdDetail').linkbutton('enable');
                    $("#closeOn").empty().append('<button type="button" id="cmdClose" title="<?php getCaption("Close"); ?>" class="easyui-linkbutton btn-cls"  data-options="iconCls:\'icon-close\'" onclick="rolesClose()">Close</button>');
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
             var url = site_url + 'transaction/accessories/outputpdf/<?php echo encrypt_decrypt('encrypt', 'acc_prh'); ?>/' + ids + '/<?php echo $_SESSION['C_USER']; ?>/'+key+'/<?php echo encrypt_decrypt('encrypt', 'pur_inv_no'); ?>/<?php echo encrypt_decrypt('encrypt', 'APR'); ?>/pembelian#toolbar=0';
          
        if (key == 'print') {
           
            $("#screenWindow").empty().append('<iframe frameborder="0"  src="' + url + '" style="width:100%;height:auto;min-height: 500px;padding:0px;"></iframe>');
            // $("#screenWindow").window('open');
        }

        if (key == 'download') {
            $("#screenWindow").empty().append('<iframe frameborder="0"  src="' + url + '" style="width:100%;height:auto;min-height: 500px;padding:0px;"></iframe>');
            // $("#screenWindow").window('open');
        }

        if (key == 'screen') {
               window.open(url);
        }

    }

    function table_grid(ttable, pur_inv_no) {
        ttable.datagrid({
            method: 'post',
            url: site_url + '<?php echo 'builder/datagrid/' . encrypt_decrypt('encrypt', 'acc_prd'); ?>/pur_inv_no/' + pur_inv_no + '/?grid=true',
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
                    {field: 'part_code', title: '<?php getCaption("Kode Barang"); ?>', width: 90, height: 20, sortable: true},
                    {field: 'part_name', title: '<?php getCaption("Nama Barang"); ?>', width: 240, height: 20, sortable: true},
                     {field: 'qty', title: '<?php getCaption("QTY"); ?>', width: 50, height: 20, sortable: true, align: 'right'},
                    {field: 'unit', title: '<?php getCaption("Satuan"); ?>', width: 50, height: 20, sortable: true},
                    {field: 'price_bd', title: '<?php getCaption("Harga Satuan"); ?> ', width: 120, height: 20, sortable: true, align: 'right', formatter: formatNumber},
                    {field: 'price_total', title: '<?php getCaption("Harga Total"); ?> ', width: 120, height: 20, sortable: true, align: 'right', formatter: formatNumber},
                    {field: 'disc_pct', title: 'Disc. (%)', width: 120, height: 20, sortable: true, align: 'right', formatter: formatNumber},
                    {field: 'disc_val', title: 'Total Disc.', width: 120, height: 20, sortable: true, align: 'right', formatter: formatNumber},
                    {field: 'price_ad', title: '<?php getCaption("Harga Netto"); ?>', width: 120, height: 20, sortable: true, align: 'right', formatter: formatNumber},
                    {field: 'wrhs_code', title: '<?php getCaption("Warehouse"); ?>', width: 100, height: 20, sortable: true},
                  
                    {field: 'po_no', title: '<?php getCaption("No. PO"); ?>', width: 150, height: 20, sortable: true},
                    {field: 'prep_code', title: '<?php getCaption("Purchaser"); ?>', width: 150, height: 20, sortable: true},
                    {field: 'add_by', title: '<?php getCaption("Ditambahkan Oleh"); ?>', width: 150, height: 20, sortable: true}


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
         $(".easyui-datebox").datebox('enable');
        $('#form_validation :input').attr('disabled', false);
        $('#form_validation .easyui-combogrid').combogrid('enable');
        $('#form_validation .easyui-combobox').combobox({disabled: false});

        $("#form_validation #inv_type").val('<?php echo $remark; ?>');
        var pur_inv_no = $("#form_validation #pur_inv_no").val();

        if (pur_inv_no == '') {
            pur_inv_no = null;
        }
        table_grid(ttable, pur_inv_no);

        $('#form_validation #opn_date,#cls2_date, #pur_date, #po_date, #rcv_date').datebox('disable');
        //$("#form_validation #pur_inv_no, #tot_item, #dept_code, #dunit_code, #due_day, #tot_qty, #supp_code, #inv_type").attr('disabled', true);

        $("#form_validation #inv_type, #pur_inv_no, #supp_code, #tot_item").attr('disabled', true);
        $("#form_validation #tot_qty, #tot_price, #inv_bt, #inv_vat, #inv_at, #inv_stamp, #inv_total").numberbox('disable');
       var po_no = $("#po_no").combogrid('getValue');

       if (po_no !== '') {
            $("#supp_name").combogrid('disable');
            $("#po_no").combogrid('disable');
            $("#cmdDeletePO").linkbutton('enable');
        } else {
            $("#po_no").combogrid('enable');
            $("#supp_name").combogrid('enable');
        }
        cmdcondReady();
        detail_price();
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

        poNew(0)

    }
    $('#form_validation #supp_name').combogrid({
        onSelect: function (index, row) {
            $('#form_validation #supp_code').val(row.supp_code);
            poNew(row.supp_code);
        }
    });

    function detail_price() {
        $("#form_validation #inv_disc").keyup(function () {
            var inv_disc = parseCurrency($(this).val());
            var tot_price = parseCurrency($("#form_validation #tot_price").val());
            var inv_stamp = parseCurrency($("#form_validation #inv_stamp").val());

            var total_bt = tot_price - inv_disc;
            var vat = total_bt / 10;
            var total = total_bt + vat;
            var inv_total = total + parseInt(inv_stamp);

            $("#form_validation #inv_bt").numberbox('setValue', total_bt);
            $("#form_validation #inv_vat").numberbox('setValue', vat);
            $("#form_validation #inv_at").numberbox('setValue', total);
            $("#form_validation #inv_total").numberbox('setValue', inv_total);

        });
    }
    function poNew(supp_code) {
        //alert(site_url + '<?php echo 'builder/combogrid/' . encrypt_decrypt('encrypt', 'acc_poh'); ?>/supp_code/' + supp_code + '/?grid=true')
        $("#po_no").combogrid({
            method: 'post',
            url: site_url + '<?php echo 'builder/combogrid/' . encrypt_decrypt('encrypt', 'acc_poh'); ?>/supp_code/' + supp_code + '/?grid=true',
            idField: 'po_no',
            textField: 'po_no',
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
                    {field: 'po_date', title: '<?php getCaption('Tgl. PO'); ?>', width: 80,formatter:formatDate},
                    {field: 'po_no', title: '<?php getCaption('No. PO'); ?>', width: 120},
                    {field: 'supp_code', title: '<?php getCaption('Kode Supplier'); ?>', width: 150},
                    {field: 'supp_name', title: '<?php getCaption('Nama Supplier'); ?>', width: 150}
                ]]
        });
        //$("#po_no").combogrid('reload');
    }
    function condEdit() {
        $(".easyui-datebox").datebox('enable');
        var supp_code = $("#supp_code").val();
        var po_no = $('#po_no').combogrid('getValue');

        poNew(supp_code);
        $('#po_no').combogrid('setValue', po_no);
        condReady();
    }
        function condDeletePO() {
        $.messager.confirm('Message', 'Do you really want to remove this PO No.?', function (r) {
            if (r) {
                var pur_inv_no = $("#pur_inv_no").val();
                var po_no = $("#po_no").combobox('getValue');
                var id = $("#id").val();

                if (po_no !== '') {
                    $.post(site_url + 'transaction/accessories/checkPO', {pur_inv_no: pur_inv_no, po_no: po_no}, function (res) {
                        var json = $.parseJSON(res);

                        if (json.count > 0) {
                            showAlert("Information", '<font color="red">This PO No. has detail(s). Please delete them</font>');
                        } else {
                            $.post(site_url + 'transaction/accessories/deleteNoPO', {id: id}, function (data) {
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
                    showAlert("Information", '<font color="red">PO No. is empty</font>');
                }
            }
        });
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
            }else{
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
                    success: function (data) { // alert(data)

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
        $.messager.confirm('Unclosing Invoice', 'Unclose this invoice?', function (r) {
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

    /* Detail */
    function cmdDetails() {
        scrlTop();
        var pur_inv_no = $("#form_validation #pur_inv_no").val();

        $.post(site_url + 'transaction/accessories/check_prh', {table: table, pur_inv_no: pur_inv_no}, function (res) {
            var json = $.parseJSON(res);

            if (json.success !== false) {
                tableId2();
                read_show2('');

                table_grid(ttable2, pur_inv_no);
                $("#DetailWindow").window('open');

                var po_no = $("#po_no").combogrid('getValue');
                pood(po_no);

                $('#form_validation2 #prep_code').combogrid({
                    onSelect: function (index, row) {

                        $("#form_validation2 #prep_name").val(row.prep_name);

                    }
                });
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

                    if (i == 'part_code' || i == 'prep_code') {
                        $("#form_validation2 #" + i).combogrid('setValue', v);
                    }

                    if (i == 'qty' || i == 'price_bd' || i == 'disc_pct' || i == 'disc_val' || i == 'price_ad') {
                        $("#form_validation2 #" + i).numberbox('setValue', v);
                    }
                });
                price_disc(rowData.qty, '', '');
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

        var save_url2 = site_url + 'transaction/accessories/save_prd/' + pur_inv_no + '/<?php echo $_SESSION['C_USER']; ?>/pembelian';

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

                    read_show2('');
                    read_show('');
                } else
                {

                    showAlert("Error", '<font color="red">' + obj.message + '</font>');
                    $('#cmdSave2').linkbutton('enable');
                }
            }
        });
    }

    function condDelete2() {
        var pur_inv_no = $("#form_validation #pur_inv_no").val();
        var id = $("#id2").val();

        $.messager.confirm('Delete Confirmation', 'Do you really want to delete this record?', function (r) {
            if (r) {
                var url = site_url + 'transaction/accessories/delete_prd';
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

        $("#form_validation2 #part_code").combogrid('enable');
        $("#form_validation2 #prep_code").combogrid('enable');
        $("#form_validation2 #qty").attr('disabled', false);
        $("#price_bd, #disc_pct, #disc_unit, #price_ad_unit").numberbox({disabled: false});

        cmdcondAwal2();
        cmdcondReady2();

        $("#qty").keyup(function () {
            var qty = parseCurrency($(this).val());

            price_disc(qty, '', '');
        });

        $("#price_bd").keyup(function () {
            var price_bd = parseCurrency($(this).val());

            price_disc('', price_bd, '');
        });

        $("#disc_pct").keyup(function () {
            var disc_pct = $(this).val();

            price_disc('', '', disc_pct);
        });

        $("#disc_unit").keyup(function () {
            var discunit = parseCurrency($(this).val());
            price_unit(discunit)
        });

        $("#price_ad_unit").keyup(function () {
            var discunit = parseCurrency($("#price_bd").val()) - parseCurrency($(this).val());

            price_unit(discunit);
        });
    }

    function price_unit(discunit) {
        var disc_unit = discunit;
        var qty = $("#qty").numberbox('getValue');
        var price_total = $("#price_total").numberbox('getValue');

        var disc = disc_unit * qty;

        var disc_pct = (disc / price_total) * 100;

        $("#disc_pct").numberbox('setValue', disc_pct);
        // alert('diskon: '+disc+' ' + ' diskon %: '+ disc_pct);
        price_disc('', '', disc_pct);
    }
    function price_disc(qty, price_bd, disc_pct) {
        if (qty == '') {
            qty = $("#qty").numberbox('getValue');
        }
        if (price_bd == '') {
            price_bd = $("#price_bd").numberbox('getValue');
        }
        if (disc_pct == '') {
            disc_pct = $("#disc_pct").numberbox('getValue');
        }

        var disc_unit = $("#disc_unit").numberbox('getValue');
        var price_ad_unit = $("#price_ad_unit").numberbox('getValue');

        var price_tot = price_bd * qty;
        var disc_tot = (price_tot / 100) * disc_pct;


        //alert(disc_pct)

        var total = price_tot - disc_tot;

        var disc_unit_val = disc_tot / qty;
        var price_ad_unit_val = price_bd - disc_unit_val;

        if (disc_tot > price_tot) {
            $.messager.alert('Warning','Discount must not exceed the begin price!','warning');
            $("#disc_pct").numberbox('setValue', '0');
            price_disc('', '', '');

        } else {
            $("#price_total").numberbox('setValue', price_tot);
            $("#disc_val").numberbox('setValue', disc_tot);
            $("#price_ad").numberbox('setValue', total);

            $("#disc_unit").numberbox('setValue', disc_unit_val);
            $("#price_ad_unit").numberbox('setValue', price_ad_unit_val);

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
    function pood(po_no) {
        if(po_no == ''){
            po_no = 0;
        }
        
        $("#form_validation2 #part_code").combogrid({
            method: 'get',
            url: site_url + '<?php echo 'builder/combogrid/' . encrypt_decrypt('encrypt', 'acc_pood'); ?>/po_no/' + po_no + '/rcv/?grid=true',
            idField: 'part_code',
            textField: 'part_code',
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
                    {field: 'part_code', title: '<?php getCaption('Kode Barang'); ?>', width: 120},
                    {field: 'part_name', title: '<?php getCaption('Nama Barang'); ?>', width: 200},
                    {field: 'wrhs_code', title: '<?php getCaption('Warehouse'); ?>', width: 150},
                    {field: 'location', title: '<?php getCaption('Lokasi'); ?>', width: 150},
                    {field: 'unit', title: '<?php getCaption('Satuan'); ?>', width: 150},
                    {field: 'qty', title: '<?php getCaption('QTY'); ?>', width: 150},
                    {field: 'rcv_qty', title: '<?php getCaption('Blm Terima'); ?>', width: 150},
                    {field: 'po_no', title: '<?php getCaption('No. PO'); ?>', width: 150},
                    {field: 'po_date', title: '<?php getCaption('Tgl. PO'); ?>',formatter:formatDate, width: 150},
                    {field: 'por_date', title: '<?php getCaption("Tgl. SPOB"); ?>',formatter:formatDate, width: 150, height: 20, sortable: true},
                    {field: 'por_no', title: '<?php getCaption("No. SPOB"); ?> ', width: 150, height: 20, sortable: true},
                    {field: 'por_line', title: '<?php getCaption("Line No"); ?>', width: 150, height: 20, sortable: true},
                    {field: 'dept_code', title: '<?php getCaption("Kode Department"); ?>', width: 150, height: 20, sortable: true},
                    {field: 'add_by', title: '<?php getCaption("Ditambahkan Oleh"); ?>', width: 150, height: 20, sortable: true}



                ]]
        });


        $('#form_validation2 #part_code').combogrid({
            onSelect: function (index, row) {
                $("#form_validation2 #pood_id").val(row.id);
                $("#form_validation2 #part_name").val(row.part_name);
                $("#form_validation2 #wrhs_code").val(row.wrhs_code);
                $("#qty").numberbox('setValue', row.qty);
                $("#form_validation2 #unit").val(row.unit);
                $("#form_validation2 #po_no").val(row.po_no);
                $("#form_validation2 #price_bd").numberbox('setValue', row.price_bd);
                $("#form_validation2 #disc_pct").numberbox('setValue', row.disc_pct);
                $("#form_validation2 #disc_val").numberbox('setValue', row.disc_val);
                $("#form_validation2 #price_ad").numberbox('setValue', row.price_ad);

                total_price = row.price_bd * row.qty;

                $("#form_validation2 #price_total").numberbox('setValue', total_price);
                price_disc('', row.price_bd, '');
                /*  disc_unit = parseCurrency(row.disc_val) / parseCurrency(row.qty);
                 price_ad_unit =  row.price_bd - disc_unit;
                 
                 $("#form_validation2 #disc_unit").numberbox('setValue', disc_unit);
                 $("#form_validation2 #price_ad_unit").numberbox('setValue', price_ad_unit);
                 */
            }
        });

    }
    function condAdd2() {
        $('#form_validation2 .combo-text').val('');
        $('#form_validation2 #id2').val('');
        $('#form_validation2 :input').val('');
        $("#form_validation2 .easyui-numberbox").numberbox('setValue', '');
        var po_no = $("#po_no").combogrid('getValue');
                pood(po_no);
        condReady2();

    }

    function condEdit2() {
        showAlert("Message", '<font color="red">Record(s) can’t be edited. To edit this record, please delete it and add a new record</font>');
    }

    function tableId2() {
        divtableId2.empty().append('<input type="hidden" name="id2"  id="id2"><input type="hidden" name="table2"  id="table2" value="' + table2 + '">');
    }
    /*End Detail*/

    $(document).ready(function () {
        checkRunMonthYear('APR');
        tableId();
        dateTop();
        read_show('');
        version('03.17-31');
    });
</script>