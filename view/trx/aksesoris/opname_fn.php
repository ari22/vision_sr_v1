<script>
    var table = 'acc_opnh';
    var form = $('#form_validation');
    var save_url = site_url + 'transaction/accessories/saveAccessories/<?php echo $_SESSION['C_USER']; ?>';
    var unclose_url = site_url + 'transaction/accessories/uncloseOpname/<?php echo $_SESSION['C_USER']; ?>';
    var close_url = site_url + 'transaction/accessories/closeOpname/<?php echo $_SESSION['C_USER']; ?>';
     var delete_url = site_url + 'transaction/accessories/delete_accesories';
    
    var divtableId = $("#tableId");
    var ttable = $('#dt');

    var table2 = 'acc_opnd';
    var ttable2 = $('#dt2');
    var divtableId2 = $("#tableId2");


    $('#oprep_name').combogrid({
        onSelect: function (index, row) {
            $("#oprep_code").val(row.oprep_code);
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

                    if (i == 'opn_date' || i == 'open_date' || i == 'cls_date') {
                        if (v !== '0000-00-00') {
                            var v_date = dateSplit(v);
                            $("#form_validation #" + i).datebox('setValue', v_date);
                        }
                    }

                    if (i == 'wrhs_code' || i == 'oprep_name') {
                        $("#form_validation #" + i).combogrid('setValue', v);
                    }

                    if (i == 'tot_item' || i == 'tot_qty' || i == 'tot_price') {
                        $("#form_validation #" + i).numberbox('setValue', v);
                    }


                });


                var opn_inv_no = rowData.opn_inv_no;
                table_grid(ttable, opn_inv_no);

                cmdcondAwal();
                formDisabled();

                if (rowData.cls_date == null || rowData.cls_date == '0000-00-00' || rowData.cls_date == '0000-00-00 00:00:00') {
                    $("#cmdDetail").removeAttr('disabled');
                    $('#cmdDetail').linkbutton('enable');
                    $("#closeOn").empty().append('<button type="button" id="cmdClose" title="<?php getCaption("Close"); ?>" class="easyui-linkbutton btn-cls"   data-options="iconCls:\'icon-close\'" onclick="rolesClose()">Close</button>');
                    $("#print").linkbutton('disable');
                    $("#screen").linkbutton('disable');
                    $("#download").linkbutton('disable');

                    $('#cmdClose').linkbutton();

                } else {
                    $("#cmdDetail").attr('disabled', true);
                    $('#cmdDetail').linkbutton('disable');
                    $("#closeOn").empty().append('<button type="button" id="cmdUnClose" title="<?php getCaption("unClose"); ?>" class="easyui-linkbutton btn-cls"  data-options="iconCls:\'icon-unclose\'"  onclick="rolesUnclose()">Unclose</button>');

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
            field1: $('#opn_inv_no2').val(),
            field2: $('#opn_date2').combogrid('getValue')
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
            var url = site_url + 'transaction/accessories/outputpdf/<?php echo encrypt_decrypt('encrypt', 'acc_opnh');?>/' + ids + '/<?php echo $_SESSION['C_USER']; ?>/'+key+'/<?php echo encrypt_decrypt('encrypt', 'opn_inv_no');?>/<?php echo encrypt_decrypt('encrypt', 'AOP');?>#toolbar=0';
     
        if(key == 'print'){
              $("#screenWindow").empty().append('<iframe frameborder="0"  src="' + url + '" style="width:100%;height:auto;min-height: 500px;padding:0px;"></iframe>');
            // $("#screenWindow").window('open');
        }
        
        if(key == 'download'){
             $("#screenWindow").empty().append('<iframe frameborder="0"  src="' + url + '" style="width:100%;height:auto;min-height: 500px;padding:0px;"></iframe>');

        }
        
        if(key == 'screen'){
                  window.open(url);
        }
    }

    function table_grid(ttable, opn_inv_no) {
        ttable.datagrid({
            method: 'post',
            url: site_url + '<?php echo 'builder/datagrid/' . encrypt_decrypt('encrypt', 'acc_opnd'); ?>/opn_inv_no/' + opn_inv_no + '/?grid=true',
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
                    {field: 'wrhs_code', title: '<?php getCaption("Warehouse"); ?>', width: 80, height: 20, sortable: true},
                    {field: 'loc_code', title: '<?php getCaption("Lokasi"); ?> ', width: 80, height: 20, sortable: true},
                    {field: 'qty', title: '<?php getCaption("QTY"); ?>', width: 80, height: 20, sortable: true},
                    {field: 'unit', title: '<?php getCaption("Satuan"); ?>', width: 80, height: 20, sortable: true},
                    {field: 'price_bd', title: '<?php getCaption("Harga Satuan"); ?>', width: 150, height: 20, sortable: true, align: 'right',formatter: formatNumber},
                    {field: 'price_total', title: '<?php getCaption("Harga Total"); ?>', width: 150, height: 20, sortable: true, align: 'right',formatter: formatNumber},
                    {field: 'opn_code', title: '<?php getCaption("Kode OPN"); ?>', width: 80, height: 20, sortable: true},
                    {field: 'note', title: '<?php getCaption("Catatan"); ?>', width: 250, height: 20, sortable: true},
                    {field: 'oprep_code', title: '<?php getCaption("Yang OPN"); ?>', width: 80, height: 20, sortable: true},
                    {field: 'add_by', title: '<?php getCaption("Ditambahkan Oleh"); ?>', width: 80, height: 20, sortable: true}


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
        $('#form_validation :input').attr('disabled', false);
        $('#form_validation .easyui-combogrid').combogrid('enable');
        $('#form_validation .easyui-combobox').combobox({disabled: false});

        var opn_inv_no = $("#form_validation #opn_inv_no").val();

        if (opn_inv_no == '') {
            opn_inv_no = null;
        }

        table_grid(ttable, opn_inv_no);

        $('#form_validation #opn_date').datebox('disable');
        $('#form_validation #cls_date').datebox('disable');
        $("#form_validation #opn_inv_no, #tot_item, #tot_qty, #tot_price, #oprep_code").attr('disabled', true);



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
        $('#form_validation #tot_item, #tot_qty, #tot_price').numberbox('setValue', '');
        $(".easyui-datebox").datebox('setValue', '');
        $('#form_validation #open_date').datebox('setValue', '<?php echo date('Y-m-d'); ?>');

        $.post(site_url + 'transaction/accessories/get_number/AOP', function (num) {
            $("#form_validation #opn_inv_no").val(num);
        });
        condReady();


    }
    function condEdit() {
         $("#open_date").datebox('enable');
        condReady();
    }
    function condDelete() {
        var id = $("#form_validation #id").val();
        var table = $("#form_validation #table").val();
        $.messager.confirm('Warning', 'Are you sure delete selected data ?', function (r) {
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
        $.messager.confirm('Closing invoice', 'Close this invoice?', function (r) {
            if (r) {
                 $(".loader").show();
                $('#form_validation :input').attr('disabled', false);
                form.form('submit', {
                    url: close_url,
                    onSubmit: function () {
                        return $(this).form('validate');
                    },
                    success: function (data) { //alert(data)

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
                        cmdDetails();
                    }

                } else
                {
                    $('.loader').hide();
                     updateFailed(obj);
                }
                
                scrlTop();
            }
        });
    }

    /* Detail */
    function cmdDetails() {
        scrlTop();
        var opn_inv_no = $("#form_validation #opn_inv_no").val();
        tableId2();
        read_show2('');

        table_grid(ttable2, opn_inv_no);
        $("#DetailWindow").window('open');

        var wrhs_code = $("#form_validation #wrhs_code").combogrid('getValue');
        maccs(wrhs_code);
    }



    function read_show2(nav) {
        var id = $("#id2").val();
        var opn_inv_no = $("#form_validation #opn_inv_no").val();

        $.post(site_url + 'crud/read/?opn_inv_no=' + opn_inv_no, {table: table2, nav: nav, id: id}, function (json) {

            $("#form_validation2 :input").val('');
            $("#form_validation2 .easyui-numberbox").numberbox('setValue', '');
            if (json !== '[]') {

                var rowData = $.parseJSON(json);

                $.each(rowData, function (i, v) {
                    $("#form_validation2 #" + i).val(v);

                    if (i == 'part_code' || i == 'opn_code' || i == 'oprep_code2') {
                        $("#form_validation2 #" + i).combogrid('setValue', v);
                    }

                    if (i == 'qty' || i == 'price_bd' || i == 'disc_pct' || i == 'disc_val' || i == 'price_ad') {
                        $("#form_validation2 #" + i).numberbox('setValue', v);
                    }
                    
                   
                     
                });
                detail_price(rowData.qty)
                $("#id2").val(rowData.id);


            }
            table_grid(ttable2, opn_inv_no);
            formDisabled2();
            cmdcondAwal2();

        });
    }

    function saveData2() {
           $('#cmdSave2').linkbutton('disable');
        var opn_inv_no = $("#form_validation #opn_inv_no").val();

        var save_url2 = site_url + 'transaction/accessories/save_opnd/' + opn_inv_no + '/<?php echo $_SESSION['C_USER']; ?>';

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
        var opn_inv_no = $("#form_validation #opn_inv_no").val();
        var id = $("#id2").val();
        var id3 = $("#id3").val();

        $.messager.confirm('Delete Confirmation', 'Do you really want to delete this record?', function (r) {
            if (r) {
                var url = site_url + 'transaction/accessories/delete_opnd';
                $.post(url, {table: table2, id: id, id3: id3}, function (data) {
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
        $('#form_validation2 :input').attr('disabled', false);

        $('#form_validation2 .easyui-combogrid').combogrid('enable');
        $('#form_validation2 .easyui-combobox').combobox({disabled: false});

        $('#form_validation2 .easyui-combogrid').combogrid('setValue', '');
        $('#form_validation2 .easyui-combobox').combobox('setValue', '');
        $('#form_validation2 #add_date').datebox('disable');

        $('#part_name, #wrhs_code, #location, #unit, #price_total,#price_bd').attr('disabled', true);
        cmdcondAwal2();
        cmdcondReady2();


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
    function condAdd2() {
        $('#form_validation2 .combo-text').val('');
        $('#form_validation2 #id2').val('');
        $('#form_validation2 :input').val('');
        $('#form_validation2 .easyui-numberbox').numberbox('setValue', '');
        condReady2();

    }

    function maccs(wrhs_code) {

        $("#part_code").combogrid({
            method: 'get',
            url: site_url + '<?php echo 'builder/combogrid/' . encrypt_decrypt('encrypt', 'maccs'); ?>/wrhs_code/' + wrhs_code + '/?grid=true',
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
                    {field: 'qty', title: 'Qty', width: 150},
                    {field: 'qty_pick', title: 'Qty Pick', width: 150},
                    {field: 'qty_order', title: 'Qty Order', width: 150},
                    {field: 'aver_price', title: '<?php getCaption('Harga Rata-rata'); ?>', width: 150}

                ]]
        });


        $('#form_validation2 #part_code').combogrid({
            onSelect: function (index, row) {
                $("#form_validation2 #id3").val(row.id);
                $("#form_validation2 #part_name").val(row.part_name);
                $("#form_validation2 #wrhs_code").val(row.wrhs_code);
                $("#form_validation2 #unit").val(row.unit);
                $("#form_validation2 #price_bd").numberbox('setValue', row.pur_price);
                $("#form_validation2 #location").val(row.location);
            }
        });

        $("#form_validation2 #qty").keyup(function () {
            var qty = parseCurrency($(this).val());

            detail_price(qty);
        });

    }

    function detail_price(qty) {
        var price = parseCurrency($("#price_bd").val());
        var total = price * qty;

        $("#form_validation2 #price_total").numberbox('setValue', total);
    }
    function condEdit2() {
        showAlert("Message", '<font color="red">Record(s) can\'t be edited. To edit this record, please delete it and add a new record</font>');
    }


    function tableId2() {
        divtableId2.empty().append('<input type="hidden" name="id2"  id="id2"><input type="hidden" name="table2"  id="table2" value="' + table2 + '">');
    }
    /*End Detail*/

    $(document).ready(function () {
        checkRunMonthYear('AOP');
        tableId();
        read_show('')
        version('03.17-31');
    });
</script>