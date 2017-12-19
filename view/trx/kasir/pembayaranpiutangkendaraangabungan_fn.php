<script>

    var table = 'veh_argh';
    var form = $('#form_validation');
    var save_url = site_url + 'transaction/cashier/savePiutangGabungan';
    var unclose_url = site_url + 'transaction/cashier/unclosePiutangGabungan/<?php echo $session['C_USER']; ?>';
    var close_url = site_url + 'transaction/cashier/closePiutangGabungan/<?php echo $session['C_USER']; ?>';

    var divtableId = $("#tableId");
    var ttable = $('#dt_jasa');

    var table2 = 'veh_argd';
    var so_no = $("#form_validation #so_no").val();
    var sal_inv_no = $("#form_validation #sal_inv_no").val();
    var ttables = $('#dt_jasa2');
    var divtableId2 = $("#tableId2");

    $("#pay_type").combogrid({
        onSelect: function (index, row) {
            if (row.pay_type == 'CASH') {
                $("#check_no").val(row.pay_type);
                $("#check_date").datebox('setValue', '<?php echo date("Y-m-d"); ?>');
                $("#due_date").datebox('setValue', '<?php echo date("Y-m-d"); ?>');
            }
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
            $(".easyui-datebox").datebox('setValue', '');

            if (json !== '[]') {

                var rowData = $.parseJSON(json);

                $('#form_validation').form('load', {
                    id: rowData.id,
                    arg_inv_no: rowData.arg_inv_no,
                    wrhs_code: rowData.wrhs_code,
                    cust_code: rowData.cust_code,
                    cust_name: rowData.cust_name,
                    note: rowData.note,
                    pay_type: rowData.pay_type,
                    bank_code: rowData.bank_code,
                    edc_code: rowData.edc_code,
                    check_no: rowData.check_no,
                    pay_desc: rowData.pay_desc,
                    coll_code: rowData.coll_code,
                    tot_item: rowData.tot_item,
                    tot_disc: rowData.tot_disc,
                    tot_paid: rowData.tot_paid
                            /* arg_date: rowData.arg_date,
                             opn_date: rowData.opn_date,
                             pay_date: rowData.pay_date,
                             check_date: rowData.check_date,
                             due_date: rowData.due_date*/
                });

                $.each(rowData, function (i, v) {
                    if (i == 'arg_date' || i == 'opn_date' || i == 'pay_date' || i == 'check_date' || i == 'due_date' || i == 'cls_date') {
                        if (v !== '0000-00-00') {
                            var vdate = dateSplit(v);
                            $("#" + i).datebox('setValue', vdate);
                        }
                    }
                });


                var arg_inv_no = rowData.arg_inv_no;
                var ttable = $("#dt_argd");
                table_grid(ttable, arg_inv_no);

                cmdcondAwal();
                formDisabled();

                if (rowData.cls_date == null || rowData.cls_date == '0000-00-00') {
                    $("#cmdDetail").removeAttr('disabled');
                    $('#cmdDetail').linkbutton('enable');
                    $("#closeOn").empty().append('<button type="button" id="cmdClose" title="<?php getCaption("Close"); ?>" data-options="iconCls:\'icon-close\'" class="easyui-linkbutton btn-cls"   onclick="rolesClose()">Close</button>');
                    $("#print").linkbutton('disable');
                    $("#screen").linkbutton('disable');
                    $("#download").linkbutton('disable');

                    $('#cmdClose').linkbutton();

                } else {
                    $("#cmdDetail").attr('disabled', true);
                    $('#cmdDetail').linkbutton('disable');
                    $("#closeOn").empty().append('<button type="button" id="cmdUnClose" title="<?php getCaption("unClose"); ?>" data-options="iconCls:\'icon-unclose\'" class="easyui-linkbutton btn-cls"   onclick="rolesUnclose()">Unclose</button>');

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
                cmdEmptyData();
                var ttable = $("#dt_argd");
                table_grid(ttable, null);
            }

            $(".loader").hide();


        });
    }

    /*
     function condSearch() {
     
     $("#tableSearch").datagrid({
     method: 'post',
     url: site_url + 'builder/table_grid/load/' + table + '/?grid=true',
     idField: 'id',
     fitColumns: false,
     singleSelect: true,
     nowrap: true,
     fit: false,
     rownumbers: true,
     pageSize: 10,
     showFooter: false,
     pagination: true,
     //toolbar:'#actionSearch',
     columns: [[
     {field: 'arg_inv_no', title: '<?php getCaption("No. Faktur"); ?> ', width: 150, height: 20, sortable: true},
     {field: 'arg_date', title: '<?php getCaption("Tgl. Faktur"); ?> ', width: 150, height: 20, sortable: true, formatter:formatDate},
     {field: 'opn_date', title: '<?php getCaption("Tgl. Buat"); ?> ', width: 150, height: 20, sortable: true, formatter:formatDate},
     {field: 'cust_name', title: '<?php getCaption("Nama Pelanggan"); ?>  ', width: 200, height: 20, sortable: true},
     {field: 'cust_rname', title: '<?php getCaption("Nama di STNK"); ?>  ', width: 250, height: 20, sortable: true},
     {field: 'srep_code', title: '<?php getCaption("Kode Sales"); ?>  ', width: 120, height: 20, sortable: true},
     {field: 'srep_name', title: '<?php getCaption("Nama Sales"); ?>  ', width: 120, height: 20, sortable: true},
     {field: 'veh_code', title: '<?php getCaption("Kode Kendaraan"); ?>  ', width: 150, height: 20, sortable: true},
     {field: 'veh_name', title: '<?php getCaption("Nama Kendaraan"); ?>  ', width: 200, height: 20, sortable: true},
     {field: 'chassis', title: '<?php getCaption("Chassis"); ?>  ', width: 150, height: 20, sortable: true},
     {field: 'veh_transm', title: '<?php getCaption("Transmisi"); ?>  ', width: 100, height: 20, sortable: true},
     {field: 'color_code', title: '<?php getCaption("Kode Warna"); ?>  ', width: 150, height: 20, sortable: true},
     {field: 'color_name', title: '<?php getCaption("Nama Warna"); ?>  ', width: 200, height: 20, sortable: true}
     ]]
     });
     }*/
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
    function getSearchselect2() {
        var row = $("#tableSearch2").datagrid('getSelected');

        if (row) {
            $.post(site_url + 'crud/read/?arg_inv_no=' + row.arg_inv_no, {table: table, nav: '', id: ''}, function (json) {
                var rowData = JSON.parse(json);
                $("#form_validation #id").val(rowData.id);
                $('#windowSearch2').window('close');
                $("#actionSearch").empty()
                $("#SearchOption").hide();
                read_show('');
            });

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
            var url = site_url + 'transaction/cashier/outputpdf/<?php echo encrypt_decrypt('encrypt', 'veh_argh'); ?>/' + ids + '/<?php echo $session['C_USER']; ?>/screen#toolbar=0';
            window.open(url);
        }
        if (key == 'download') {
            var ids = $("#form_validation #id").val();
            var url = site_url + 'transaction/cashier/outputpdf/<?php echo encrypt_decrypt('encrypt', 'veh_argh'); ?>/' + ids + '/<?php echo $session['C_USER']; ?>/download';

            $("#screenWindow").empty().append('<iframe frameborder="0"  src="' + url + '" style="width:100%;height:auto;min-height: 500px;padding:0px;"></iframe>');
            // $("#screenWindow").window('open');
        }
        if (key == 'print') {
            var ids = $("#form_validation #id").val();
            var url = site_url + 'transaction/cashier/outputpdf/<?php echo encrypt_decrypt('encrypt', 'veh_argh'); ?>/' + ids + '/<?php echo $session['C_USER']; ?>/print';

            $("#screenWindow").empty().append('<iframe frameborder="0"  src="' + url + '" style="width:100%;height:auto;min-height: 500px;padding:0px;"></iframe>');
            // $("#screenWindow").window('open');
        }
    }

    function table_grid(ttable, arg_inv_no) {
        ttable.datagrid({
            method: 'post',
            url: site_url + '<?php echo 'builder/datagrid/' . encrypt_decrypt('encrypt', 'veh_argd'); ?>/arg_inv_no/' + arg_inv_no + '/?grid=true',
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
                    {field: 'chassis', title: '<?php getCaption("Nomor Rangka"); ?>', width: 150, height: 20, sortable: true},
                    {field: 'engine', title: '<?php getCaption("No. Mesin"); ?>', width: 150, height: 20, sortable: true},
                    {field: 'sal_inv_no', title: '<?php getCaption("No. Faktur Jual"); ?>', width: 120, height: 20, sortable: true},
                    {field: 'so_no', title: '<?php getCaption("No. SPK"); ?>', width: 120, height: 20, sortable: true},
                    {field: 'inv_total', title: '<?php getCaption("Piutang"); ?>', align: 'right', width: 120, height: 20, sortable: true, formatter: formatNumber},
                    {field: 'pd_begin', title: '<?php getCaption("Saldo Awal"); ?>', align: 'right', width: 120, height: 20, sortable: true, formatter: formatNumber},
                    {field: 'pd_paid', title: '<?php getCaption("Pembayaran"); ?>', align: 'right', width: 120, height: 20, sortable: true, formatter: formatNumber},
                    {field: 'pd_disc', title: '<?php getCaption("Diskon"); ?>', align: 'right', width: 120, height: 20, sortable: true, formatter: formatNumber},
                    {field: 'pd_end', title: '<?php getCaption("Saldo Akhir"); ?>', align: 'right', width: 120, height: 20, sortable: true, formatter: formatNumber},
                    {field: 'veh_code', title: '<?php getCaption("Kode Kendaraan"); ?>', width: 120, height: 20, sortable: true},
                    {field: 'veh_name', title: '<?php getCaption("Nama Kendaraan"); ?>', width: 200, height: 20, sortable: true},
                    {field: 'veh_year', title: '<?php getCaption("Tahun"); ?>', width: 120, height: 20, sortable: true},
                    {field: 'veh_transm', title: '<?php getCaption("Transmisi"); ?>', width: 120, height: 20, sortable: true},
                    {field: 'color_code', title: '<?php getCaption("Kode Warna"); ?>', width: 200, height: 20, sortable: true},
                    {field: 'color_name', title: '<?php getCaption("Warna"); ?>', width: 120, height: 20, sortable: true}
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

        var arg_inv_no = $("#form_validation #arg_inv_no").val();
        var ttable = $("#dt_argd");

        if (arg_inv_no == '') {
            var arg_inv_no = null;
        }
        table_grid(ttable, arg_inv_no);

        $('#form_validation #wrhs_code').combogrid('disable');
        $('#form_validation #opn_date').datebox('disable');
        $('#form_validation #cls_date').datebox('disable');
        $('#form_validation #arg_date').datebox('disable');
        $('#form_validation #cust_code').attr('disabled', true);
        $("#form_validation #arg_inv_no").attr('disabled', true);
        $("#form_validation #tot_item").attr('disabled', true);
        $("#form_validation #tot_paid").attr('disabled', true);
        $("#form_validation #tot_disc").attr('disabled', true);

        $('#form_validation #pay_date').datebox('enable');
        $('#form_validation #check_date').datebox('enable');
        $('#form_validation #due_date').datebox('enable');
        cmdcondReady();
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
        $("#form_validation #cmdUnClose").linkbutton('disable');
        $("#print").linkbutton('disable');
        $("#screen").linkbutton('disable');
        $("#form_validation #cmdDetail").linkbutton('disable');
    }

    function condAdd() {
        $('.easyui-numberbox').numberbox('setValue', '');
        $(".easyui-datebox").datebox('enable');
        $('#form_validation #id').val('');
        $('#form_validation input:text').val('');
        $("#form_validation #table").val(table);


        $('#form_validation #wrhs_code').combogrid('setValue', '<?php echo $wrhs_input; ?>');
        $('#form_validation #pay_type').combogrid('setValue', '');
        $('#form_validation #pay_date').datebox('setValue', '<?php echo date('Y-m-d'); ?>');
        $('#form_validation #opn_date').datebox('setValue', '<?php echo date('Y-m-d'); ?>');

        $.post(site_url + 'transaction/cashier/get_number/VRG', function (num) {
            $("#form_validation #arg_inv_no").val(num);
        });
        condReady();

        $("#form_validation #tot_paid").numberbox('setValue', 0);
        $("#form_validation #tot_disc").numberbox('setValue', 0);

    }
    function condEdit() {
        condReady();
        var tot_item = $("#form_validation #tot_item").val();

        if (tot_item > 0) {
            $('#form_validation #cust_name').combogrid('disable');
        }
    }
    function condDelete() {
        var id = $("#form_validation #id").val();
        var table = $("#form_validation #table").val();
        $.messager.confirm('Warning', 'Do you really want to delete this record?', function (r) {
            if (r) {
                $(".loader").show();
                var url = site_url + 'transaction/cashier/deletePiutangGabungan';
                $.post(url, {table: table, id: id}, function (data) {
                    obj = JSON.parse(data);

                    if (obj.success == true) {
                        read_show('P');
                        showAlert("Information", obj.message);

                    } else
                    {
                        $(".loader").hide();
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
        $.messager.confirm('Close', 'Close this invoice?', function (r) {
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
            $('#form_validation :input').attr('disabled', false);
            read_show('');
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
                    $(".loader").hide();
                    showAlert("Error while saving", '<font color="red">' + obj.message + '</font>');
                    condReady();
                }
                scrlTop();
            }
        });
    }

    /* Detail */
    function cmdDetails() {
        scrlTop();
        var arg_inv_no = $("#form_validation #arg_inv_no").val();
        var ttable = $("#dt_argd2");
        var cust_code = $("#form_validation #cust_code").val();
        tableId2();
        read_show2('');
        table_grid(ttable, arg_inv_no);

        $("#DetailWindow").window('open');
        //alert("<?php echo $site_url . 'builder/combogrid/' . encrypt_decrypt('encrypt', 'veh_arh') . '/cust_code/'; ?>" + cust_code+'/piutang')
        $('#form_validation2 #chassis').combogrid({
            panelWidth: 650,
            mode: 'remote',
            idField: 'chassis',
            textField: 'chassis',
            fitColumns: false,
            fit: false,
            mode: 'remote',
                    pagination: true,
            remoteSort: true,
            multiSort: true,
            required: false,
            loadMsg: 'Please wait...',
            url: "<?php echo $site_url . 'builder/combogrid/' . encrypt_decrypt('encrypt', 'veh_arh') . '/cust_code/'; ?>" + cust_code + '/piutang',
            columns: [[
                    {field: 'chassis', title: '<?php getCaption("Nomor Rangka"); ?>', width: 160},
                    {field: 'sal_inv_no', title: '<?php getCaption("No. Faktur Jual"); ?>', width: 120},
                    {field: 'sal_date', title: '<?php getCaption("Tgl. Faktur Jual"); ?>', width: 100, formatter: formatDate},
                    {field: 'veh_name', title: '<?php getCaption("Nama Kendaraan"); ?>', width: 200},
                    {field: 'color_name', title: '<?php getCaption("Warna"); ?>', width: 200},
                    {field: 'srep_name', title: '<?php getCaption("Nama Sales"); ?>', width: 150},
                    {field: 'so_no', title: '<?php getCaption("No. SPK"); ?>', width: 120},
                    {field: 'so_date', title: '<?php getCaption("Tgl. SPK"); ?>', width: 90, formatter: formatDate},
                    {field: 'inv_total', title: '<?php getCaption("Piutang"); ?>', align: 'right', width: 120, formatter: formatNumber}
                ]],
            onSelect: function (index, rowData) {

                $('#form_validation2').form('load', {
                    sal_inv_no: rowData.sal_inv_no,
                    so_no: rowData.so_no,
                    inv_total: rowData.inv_total,
                    pd_begin: rowData.pd_end,
                    pd_paid: rowData.pd_end,
                    //pd_disc: rowData.pd_disc,
                    //pd_end: rowData.pd_end,
                    engine: rowData.engine,
                    // so_date: rowData.so_date,
                    //sal_date: rowData.sal_date,
                    veh_name: rowData.veh_name,
                    color_name: rowData.color_name
                });

                $.each(rowData, function (i, v) {
                    if (i == 'sal_date' || i == 'so_date') {
                        if (v !== '0000-00-00') {
                            var vdate = dateSplit(v);

                            $("#form_validation2 #" + i).datebox('setValue', vdate);
                        }
                    }
                });

                var pd_disc = 0;
                var pd_end = rowData.pd_end - rowData.pd_end - pd_disc;
                $("#form_validation2 #pd_disc").numberbox('setValue', pd_disc);
                $("#form_validation2 #pd_end").numberbox('setValue', pd_end);
            }
        });

        $("#pd_paid").keyup(function () {
            var pd_paid = parseCurrency($(this).val());
            var pd_disc = parseCurrency($("#pd_disc").val());
            total_pd_end(pd_paid, pd_disc);
        });

        $("#pd_disc").keyup(function () {
            var pd_paid = parseCurrency($("#pd_paid").val());
            var pd_disc = parseCurrency($(this).val());
            total_pd_end(pd_paid, pd_disc);
        });
    }

    function total_pd_end(pd_paid, pd_disc) {
        var pd_begin = parseCurrency($("#pd_begin").val());

        var total = pd_begin - pd_paid - pd_disc;

        $("#form_validation2 #pd_end").numberbox('setValue', total);
    }
    function parseCurrency(num) {
        return num.replace(/[^0-9]/g, '');
    }

    function read_show2(nav) {
        var id = $("#id2").val();
        var arg_inv_no = $("#form_validation #arg_inv_no").val();

        $.post(site_url + 'crud/read/?arg_inv_no=' + arg_inv_no, {table: table2, nav: nav, id: id}, function (json) {
            $("#form_validation2 :input").val('');
            $("#form_validation2 .easyui-numberbox").numberbox('setValue', '');

            if (json !== '[]') {


                var rowData = $.parseJSON(json);

                $('#form_validation2').form('load', {
                    chassis: rowData.chassis,
                    sal_inv_no: rowData.sal_inv_no,
                    so_no: rowData.so_no,
                    inv_total: rowData.inv_total,
                    pd_begin: rowData.pd_begin,
                    pd_paid: rowData.pd_paid,
                    pd_disc: rowData.pd_disc,
                    pd_end: rowData.pd_end,
                    engine: rowData.engine,
                    //so_date: rowData.so_date,
                    //sal_date: rowData.sal_date,
                    veh_name: rowData.veh_name,
                    color_name: rowData.color_name
                });
                $.each(rowData, function (i, v) {

                    if (i == 'sal_date' || i == 'so_date') {
                        if (v !== '0000-00-00') {
                            var vdate = dateSplit(v);

                            $("#form_validation2 #" + i).datebox('setValue', vdate);
                        }
                    }
                });
                $("#id2").val(rowData.id);

            }
            formDisabled2();
            cmdcondAwal2();

        });
    }

    function saveData2() {
        $('#cmdSave2').linkbutton('disable');

        var arg_inv_no = $("#form_validation #arg_inv_no").val();

        var save_url2 = site_url + 'transaction/cashier/save_argd/' + arg_inv_no;

        $('#form_validation2 :input').attr('disabled', false);

        $("#form_validation2").form('submit', {
            url: save_url2,
            onSubmit: function () {
                return $(this).form('validate');
            },
            success: function (data) {
                var obj = JSON.parse(data);

                if (obj.success !== false) {

                    var ttable = $("#dt_argd");
                    var ttable2 = $("#dt_argd2");
                    table_grid(ttable, arg_inv_no);
                    table_grid(ttable2, arg_inv_no);
                    $("#id2").val('');

                    read_show2('');
                    read_show('');
                    $('#form_validation2 #chassis').combogrid('grid').datagrid('reload');
                } else
                {

                    showAlert("Error", '<font color="red">' + obj.message + '</font>');
                    $('#cmdSave2').linkbutton('enable');
                }
            }
        });
    }

    function condDelete2() {
        var arg_inv_no = $("#form_validation #arg_inv_no").val();
        var id = $("#id2").val();
        var table = 'veh_argd';
        $.messager.confirm('Delete Confirmation', 'Do you really want to delete this record?', function (r) {
            if (r) {
                var url = site_url + 'transaction/cashier/delete_detail';
                $.post(url, {table: table, id: id}, function (data) { //alert(data)
                    obj = JSON.parse(data);
                    if (obj.status == true) {
                        var ttable = $("#dt_argd");
                        var ttable2 = $("#dt_argd2");
                        table_grid(ttable, arg_inv_no);
                        table_grid(ttable2, arg_inv_no);
                        $("#id2").val('');
                        $("#form_validation2 :input").val('');
                        read_show2('');
                        read_show('');
                        $('#form_validation2 #chassis').combogrid('grid').datagrid('reload');
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
        $('#form_validation2 #pd_paid').attr('disabled', false);
        $('#form_validation2 #pd_disc').attr('disabled', false);

        $('#form_validation2 .easyui-combogrid').combogrid('enable');
        $('#form_validation2 .easyui-combobox').combobox({disabled: false});

        cmdcondAwal2();
        cmdcondReady2();
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
        $.messager.alert('Warning', 'Record(s) can’t be edited. To edit this record, please delete it and add a new record', 'warning');
    }


    function tableId2() {
        divtableId2.empty().append('<input type="hidden" name="id2"  id="id2"><input type="hidden" name="table2"  id="table2" value="' + table2 + '">');
    }
    /*End Detail*/
    $(document).ready(function () {
        checkRunMonthYear('VRG');
        tableId();
        read_show('')
        version('03.17-31');
    });
</script>