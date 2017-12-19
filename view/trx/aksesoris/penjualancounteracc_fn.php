<script>
    var table = 'acc_slh';
    var form = $('#form_validation');
    var save_url = site_url + 'transaction/accessories/saveAccessories/<?php echo $_SESSION['C_USER']; ?>/ASC';
    var unclose_url = site_url + 'transaction/accessories/unclosePemakaian/<?php echo $_SESSION['C_USER']; ?>';
    var close_url = site_url + 'transaction/accessories/closePemakaian/<?php echo $_SESSION['C_USER']; ?>';
    var delete_url = site_url + 'transaction/accessories/delete_accesories';

    var divtableId = $("#tableId");
    var ttable = $('#dt');

    var table2 = 'acc_sld';
    var ttable2 = $('#dt2');
    var divtableId2 = $("#tableId2");

    var sinv_code = 'ASC';


    $('#form_validation #cust_name').combogrid({
        onSelect: function (index, row) {
            $('#form_validation #cust_code').val(row.cust_code);
            // $('#form_validation #dept_name').val(row.dept_name);
        }
    });
    $('#form_validation #srep_name').combogrid({
        onSelect: function (index, row) {
            $('#form_validation #srep_code').val(row.srep_code);

        }
    });


    function tableId() {
        divtableId.empty().append('<input type="hidden" name="id"  id="id"><input type="hidden" name="table"  id="table" value="' + table + '">');
    }

    function read_show(nav) {
        var id = $("#form_validation #id").val();

        $.post(site_url + 'transaction/accessories/read_slh/ASC', {table: table, nav: nav, id: id}, function (json) { //alert(json)
            $('#form_validation input:text').val('');
            $('#form_validation textarea').val('');
            $('#form_validation .easyui-combogrid').combogrid('setValue', '');
            $(".easyui-datebox").datebox('setValue', '');

            if (json !== '[]') {

                var rowData = $.parseJSON(json);

                $.each(rowData, function (i, v) {
                    $("#form_validation #" + i).val(v);


                    if (i == 'wrhs_code' || i == 'cust_name' || i == 'srep_name') {
                        $("#form_validation #" + i).combogrid('setValue', v);
                    }

                    if (i == 'sal_date' || i == 'opn_date' || i == 'due_date' || i == 'cls_date') {
                        if (v !== '0000-00-00') {
                            var v_date = dateSplit(v);
                            $("#form_validation #" + i).datebox('setValue', v_date);
                        }

                    }

                    if (i == 'tot_item' || i == 'tot_qty' || i == 'tot_price' || i == 'inv_disc' || i == 'inv_bt' || i == 'inv_vat' || i == 'inv_at' || i == 'inv_stamp' || i == 'inv_total' || i == 'due_day') {
                        $("#form_validation #" + i).numberbox('setValue', v);
                    }


                });


                var sal_inv_no = rowData.sal_inv_no;
                table_grid(ttable, sal_inv_no);

                cmdcondAwal();
                formDisabled();

                if (rowData.cls_date == null || rowData.cls_date == '0000-00-00' || rowData.cls_date == '0000-00-00 00:00:00') {
                    $("#cmdDetail").removeAttr('disabled');
                    $('#cmdDetail').linkbutton('enable');
                    $("#closeOn").empty().append('<button type="button" id="cmdClose" title="<?php getCaption("Close"); ?>" class="easyui-linkbutton btn-cls"  data-options="iconCls:\'icon-close\'"  onclick="rolesClose()">Close</button>');
                    $("#print").linkbutton('disable');
                    $("#screen").linkbutton('disable');
                    $("#download").linkbutton('disable');

                    $('#cmdClose').linkbutton();
                    $("#setDiskon").linkbutton('enable');
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
                    $("#setDiskon").linkbutton('disable');
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
            field1: $('#sal_inv_no2').val(),
            field2: $('#sal_date2').datebox('getValue'),
            field11: $('#cust_code2').val(),
            field4: $('#cust_name2').val()
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
        var url = site_url + 'transaction/accessories/outputpdf/<?php echo encrypt_decrypt('encrypt', 'acc_slh'); ?>/' + ids + '/<?php echo $_SESSION['C_USER']; ?>/' + key + '/<?php echo encrypt_decrypt('encrypt', 'sal_inv_no'); ?>/<?php echo encrypt_decrypt('encrypt', 'ASC'); ?>#toolbar=0';

        if (key == 'print') {
            $("#screenWindow").empty().append('<iframe frameborder="0"  src="' + url + '" style="width:100%;padding:0px;"></iframe>');
            // $("#screenWindow").window('open');
        }

        if (key == 'screen') {
            window.open(url);
        }

        if (key == 'download') {
            $("#screenWindow").empty().append('<iframe frameborder="0"  src="' + url + '" style="width:100%;height:auto;min-height: 500px;padding:0px;"></iframe>');
            // $("#screenWindow").window('open');
        }
    }

    function table_grid(ttable, sal_inv_no) {
        ttable.datagrid({
            method: 'post',
            url: site_url + '<?php echo 'builder/datagrid/' . encrypt_decrypt('encrypt', 'acc_sld'); ?>/sal_inv_no/' + sal_inv_no + '/?grid=true',
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
                    {field: 'part_name', title: '<?php getCaption("Nama Barang"); ?>', width: 180, height: 20, sortable: true},
                    {field: 'wrhs_code', title: '<?php getCaption("Warehouse"); ?>', width: 100, height: 20, sortable: true},
                    {field: 'qty', title: '<?php getCaption("QTY"); ?>', width: 100, height: 20, sortable: true, align: 'right', },
                    {field: 'unit', title: '<?php getCaption("Satuan"); ?>', width: 80, height: 20, sortable: true},
                    {field: 'price_bd', title: '<?php getCaption("Harga Satuan"); ?>', width: 120, height: 20, sortable: true, align: 'right', formatter: formatNumber},
                    {field: 'disc_pct', title: '<?php getCaption("Diskon"); ?>', width: 120, height: 20, sortable: true, align: 'right', formatter: formatNumber},
                    //{field: 'price_total', title: '<?php getCaption("Harga Total"); ?>', width: 150, height: 20, sortable: true},                    
                    {field: 'disc_val', title: 'Total <?php getCaption("Diskon"); ?>', width: 120, height: 20, sortable: true, align: 'right', formatter: formatNumber},
                    {field: 'price_ad', title: '<?php getCaption("Harga Netto"); ?>', width: 120, height: 20, sortable: true, align: 'right', formatter: formatNumber},
                    {field: 'srep_code1', title: '<?php getCaption("Sales"); ?> 1', width: 120, height: 20, sortable: true},
                    {field: 'srep_code2', title: '<?php getCaption("Sales"); ?> 2', width: 150, height: 20, sortable: true},
                    //{field: 'sj_no', title: '<?php getCaption("NO. Surat Jalan"); ?>', width: 150, height: 20, sortable: true},
                    //{field: 'sj_date', title: '<?php getCaption("Tgl. Surat Jalan"); ?>', width: 150, height: 20, sortable: true},
                    {field: 'add_by', title: '<?php getCaption("Ditambahkan Oleh"); ?>', width: 150, height: 20, sortable: true}


                ]]
        });
        /*
         * part_code
         part_name
         wrhs_code
         qty
         unit
         price_bd
         disc_pct
         disc_val
         price_ad
         
         * @returns {undefined}         */
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

        var sal_inv_no = $("#form_validation #sal_inv_no").val();

        if (sal_inv_no == '') {
            sal_inv_no = null;
        }
        table_grid(ttable, sal_inv_no);

        $('#form_validation #sal_date, #cls_date').datebox('disable');
        $("#form_validation #sal_inv_no,#inv_type,#cust_code,#srep_code,#tot_item, #tot_qty,#tot_price,#inv_disc,#inv_bt,#inv_vat,#inv_at,#inv_stamp,#inv_total").attr('disabled', true);

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


        $("#cmdDetail").attr('disabled', true);
        $("#download").attr('disabled', true);
        $("#cmdClose").attr('disabled', true);
        $("#cmdUnClose").attr('disabled', true);
        $("#print").attr('disabled', true);
        $("#screen").attr('disabled', true);

        $("#cmdDetail").linkbutton('disable');
        $("#download").linkbutton('disable');
        $("#cmdClose").linkbutton('disable');
        $("#cmdUnClose").linkbutton('disable');
        $("#print").linkbutton('disable');
        $("#screen").linkbutton('disable');
    }

    function condAdd() {
        $(".easyui-datebox").datebox('enable');
        $('#form_validation #id').val('');
        $('#form_validation input:text').val('');
        $("#form_validation #table").val(table);
        $('#form_validation .easyui-combogrid').combogrid('setValue', '');
        $('#form_validation .easyui-numberbox').numberbox('setValue', '');
        $(".easyui-datebox").datebox('setValue', '');
        $('#form_validation #opn_date').datebox('setValue', '<?php echo date('Y-m-d'); ?>');

        $.post(site_url + 'transaction/accessories/get_number/ASC', function (num) {
            $("#form_validation #sal_inv_no").val(num);
        });

        $("#form_validation #inv_type").val('<?php echo $remark; ?>');
        condReady();
    }
    function condEdit() {
        $(".easyui-datebox").datebox('enable');
        condReady();
    }
    function condDelete() {
        var id = $("#form_validation #id").val();
        var table = $("#form_validation #table").val();
        $.messager.confirm('Warning', 'Do you really want to delete this record?', function (r) {
            if (r) {
                $('.loader').show();
                var url = delete_url;
                $.post(url, {table: table, id: id}, function (data) {
                    obj = JSON.parse(data);

                    if (obj.success == true) {
                        $("#id").val('');
                        showAlert("Information", obj.message);

                        read_show('');
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
                $('#form_validation :input').attr('disabled', false);
                $('.loader').show();
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
                            $('.loader').hide();
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
                $('.loader').show();
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
                            $('.loader').hide();
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
    function setDiskonVal() {
        $('#form_diskon .easyui-numberbox').numberbox('setValue', '');
        $("#form_diskon input:radio").prop("checked", false);
        var sal_inv_no = $("#form_validation #sal_inv_no").val();
        $(".checkbox").click(function () {
            var name = $(this).attr('name');
            var atr = $('#form_diskon #' + name).attr('disabled');
            var val = $(this).val();

            if (atr !== 'disabled') {
                $('#form_diskon #' + name).prop("checked", true);
            }

            if (name == 'checkbox_2') {
                $("#form_diskon #part_code").combogrid('enable');
                $("#form_diskon #part_code").combogrid('setValue', '');
            } else {
                $("#form_diskon #disc1").numberbox('setValue', '0');
                $("#form_diskon #disc2").numberbox('setValue', '0');
                $("#form_diskon #part_code").combogrid('disable');
            }
        });
        $("#SetDiskonWindow").window('open');
        $("#disc1, #disc2").numberbox('enable');
        $("#form_diskon #part_code").combogrid({
            method: 'get',
            url: site_url + '<?php echo 'builder/combogrid/' . encrypt_decrypt('encrypt', 'acc_sld'); ?>/sal_inv_no/' + sal_inv_no + '/?grid=true',
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
                    {field: 'part_name', title: '<?php getCaption('Nama Barang'); ?>', width: 200}

                ]]
        });

        $('#form_diskon #part_code').combogrid({
            onSelect: function (index, row) {
                $("#form_diskon #disc1").numberbox('setValue', row.disc_pct);
                $("#form_diskon #disc2").numberbox('setValue', row.disc_pct);
            }
        });
    }
    function saveDiskon() {

        var sal_inv_no = $("#form_validation #sal_inv_no").val();

        var save_diskon = site_url + 'transaction/accessories/save_diskon/' + sal_inv_no + '/<?php echo $_SESSION['C_USER']; ?>';

        $("#form_diskon").form('submit', {
            url: save_diskon,
            onSubmit: function () {
                return $(this).form('validate');
            },
            success: function (data) {

                var obj = JSON.parse(data);
                if (obj.success == true) {
                    showAlert("Information", obj.message);
                    read_show('');
                    $('#SetDiskonWindow').window('close');

                } else
                {
                    $('#SetDiskonWindow').window('close');
                    showAlert("Failed", '<font color="red">' + obj.message + '</font>');
                }
            }
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
                    updateFailed(obj);
                }
                scrlTop();
            }
        });
    }

    /* Detail */
    function cmdDetails() {
           scrlTop();
        var sal_inv_no = $("#form_validation #sal_inv_no").val();
        tableId2();
        read_show2('');

        table_grid(ttable2, sal_inv_no);
        $("#DetailWindow").window('open');
        var wrhs_code = $("#form_validation #wrhs_code").combogrid('getValue');

        part_code_detail(wrhs_code)
    }



    function read_show2(nav) {
        var id = $("#id2").val();
        var sal_inv_no = $("#form_validation #sal_inv_no").val();

        $.post(site_url + 'crud/read/?sal_inv_no=' + sal_inv_no, {table: table2, nav: nav, id: id}, function (json) {

            $("#form_validation2 :input").val('');
            $("#form_validation2 .easyui-numberbox").numberbox('setValue', '');
            if (json !== '[]') {

                var rowData = $.parseJSON(json);

                $.each(rowData, function (i, v) {
                    $("#form_validation2 #" + i).val(v);

                    if (i == 'part_code' || i == 'srep_code1' || i == 'srep_code2') {
                        $("#form_validation2 #" + i).combogrid('setValue', v);
                    }

                    if (i == 'qty' || i == 'price_bd' || i == 'disc_pct' || i == 'disc_val' || i == 'price_ad') {
                        $("#form_validation2 #" + i).numberbox('setValue', v);
                    }
                });
                price_disc(rowData.qty, '', '');
                $("#id2").val(rowData.id);


            }
            table_grid(ttable2, sal_inv_no);
            formDisabled2();
            cmdcondAwal2();

        });
    }

    function saveData2() {
          $('#cmdSave2').linkbutton('disable');
        var sal_inv_no = $("#form_validation #sal_inv_no").val();

        var save_url2 = site_url + 'transaction/accessories/save_sld/' + sal_inv_no + '/<?php echo $_SESSION['C_USER']; ?>';

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
        var sal_inv_no = $("#form_validation #sal_inv_no").val();
        var id = $("#id2").val();

        $.messager.confirm('Delete Confirmation', 'Do you really want to delete this record?', function (r) {
            if (r) {
                var url = site_url + 'transaction/accessories/delete_sld';
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
        $('#form_validation2 :input').attr('disabled', false);

        $('#form_validation2 .easyui-combogrid').combogrid('enable');
        //$('#form_validation2 .easyui-combobox').combobox({disabled: false});

        $('#form_validation2 .easyui-combogrid').combogrid('setValue', '');
        //$('#form_validation2 .easyui-combobox').combobox('setValue', '');
        $('#form_validation2 #part_name,#wrhs_code,#unit,#disc_val,#price_ad, #price_total').attr('disabled', true);
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


        $("#price_total").numberbox('setValue', price_tot);
        $("#disc_val").numberbox('setValue', disc_tot);
        $("#price_ad").numberbox('setValue', total);

        $("#disc_unit").numberbox('setValue', disc_unit_val);
        $("#price_ad_unit").numberbox('setValue', price_ad_unit_val);


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

    function part_code_detail(wrhs_code) {
        $("#form_validation2 #part_code").combogrid({
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
                    {field: 'wrhs_code', title: '<?php getCaption('Warehouse'); ?>', width: 80},
                    {field: 'location', title: '<?php getCaption('Lokasi'); ?>', width: 80},
                    {field: 'unit', title: '<?php getCaption('Satuan'); ?>', width: 80},
                    {field: 'qty', title: '<?php getCaption('QTY'); ?>', width: 80, align: 'right', formatter: formatNumber},
                    {field: 'qty_pick', title: 'QTY Pick', width: 80, align: 'right', formatter: formatNumber},
                    {field: 'qty_order', title: 'QTY Order', width: 80, align: 'right', formatter: formatNumber},
                    {field: 'sal_price', title: '<?php getCaption('Harga Beli'); ?>', width: 150, align: 'right', formatter: formatNumber},
                    {field: 'sal_disc', title: '<?php getCaption("Diskon Beli"); ?>', width: 150, height: 20, sortable: true, formatter: formatNumber, align: 'right'}


                ]]
        });


        $('#form_validation2 #part_code').combogrid({
            onSelect: function (index, row) {
                $("#form_validation2 #id3").val(row.id);
                $("#form_validation2 #part_name").val(row.part_name);
                $("#form_validation2 #wrhs_code").val(row.wrhs_code);
                $("#form_validation2 #disc_pct").numberbox('setValue', row.pur_disc);
                $("#form_validation2 #unit").val(row.unit);
                $("#form_validation2 #price_bd").numberbox('setValue', row.sal_price);

            }
        });

    }

    function condEdit2() {
        showAlert("Message", '<font color="red">Record(s) can�t be edited. To edit this record, please delete it and add a new record.</font>');
    }

    function tableId2() {
        divtableId2.empty().append('<input type="hidden" name="id2"  id="id2"><input type="hidden" name="table2"  id="table2" value="' + table2 + '">');
    }
    /*End Detail*/

    $(document).ready(function () {
        checkRunMonthYear('ASC');
        tableId();
        dateTop();
        read_show('')
        version('03.17-31');
    });
</script>