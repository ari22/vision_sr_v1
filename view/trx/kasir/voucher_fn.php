<script>

    var table = 'veh_apvh';
    var form = $('#form_validation');
    var save_url = site_url + 'transaction/cashier/saveVoucherKendaraan';
    var unclose_url = site_url + 'transaction/cashier/uncloseVoucher/<?php echo $session['C_USER']; ?>';
    var close_url = site_url + 'transaction/cashier/closeVoucher/<?php echo $session['C_USER']; ?>';

    var divtableId = $("#tableId");
    var ttable = $('#dt_jasa');

    var table2 = 'veh_apvd';
    var po_no = $("#form_validation #po_no").val();
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
            $('#form_validation .easyui-combogrid').combogrid('setValue', '');
            $("#form_validation .easyui-datebox").datebox('setValue', '');

            if (json !== '[]') {

                var rowData = $.parseJSON(json);

                $.each(rowData, function (i, v) {
                    $("#form_validation #" + i).val(v);

                    if (i == 'apv_date' || i == 'opn_date' || i == 'apv_date' || i == 'cls_date' || i == 'pay_date' || i == 'check_date' || i == 'due_date') {
                        if (v !== '0000-00-00') {
                            var vdate = dateSplit(v);
                            $("#" + i).datebox('setValue',vdate);
                        }
                    }
                    if (i == 'wrhs_code' || i == 'supp_name' || i == 'pay_type' || i == 'bank_code' || i == 'edc_code' || i == 'coll_code') {
                        $("#" + i).combogrid('setValue', v);
                    }
                    if (i == 'tot_paid' || i == 'tot_disc') {
                        $("#" + i).numberbox('setValue', v);
                    }
                });

                var apv_inv_no = rowData.apv_inv_no;
                var ttable = $("#dt_apgd");
                table_grid(ttable, apv_inv_no);

                cmdcondAwal();
                formDisabled();

                if (rowData.cls_date == null || rowData.cls_date == '0000-00-00') {
                    $("#cmdDetail").removeAttr('disabled');
                    $('#cmdDetail').linkbutton('enable');
                    $("#closeOn").empty().append('<button type="button" id="cmdClose" title="<?php getCaption("Close"); ?>" class="easyui-linkbutton btn-cls" data-options="iconCls:\'icon-close\'"  onclick="closeBtn()">Close</button>');
                    $("#print").linkbutton('disable');
                    $("#screen").linkbutton('disable');
                    $("#download").linkbutton('disable');

                    $('#cmdClose').linkbutton();

                } else {
                    $("#cmdDetail").attr('disabled', true);
                    $('#cmdDetail').linkbutton('disable');
                    $("#closeOn").empty().append('<button type="button" id="cmdUnClose" title="<?php getCaption("unClose"); ?>" class="easyui-linkbutton btn-cls" data-options="iconCls:\'icon-unclose\'"  onclick="UncloseBtn()">Unclose</button>');

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
            }else {
                cmdcondAwal();
                cmdEmptyData();
                 var ttable = $("#dt_apgd");
                table_grid(ttable, null);
            }

             $(".loader").hide();


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

        if (key == 'print') {
            var ids = $("#form_validation #id").val();
            var url = site_url + 'transaction/cashier/outputpdf/' + table + '/' + ids + '/<?php echo $session['C_USER']; ?>/print';

            $("#screenWindow").empty().append('<iframe frameborder="0"  src="' + url + '" style="width:100%;height:auto;min-height: 500px;padding:0px;"></iframe>');
            // $("#screenWindow").window('open');
        }

        if (key == 'download') {
            var ids = $("#form_validation #id").val();
            var url = site_url + 'transaction/cashier/outputpdf/' + table + '/' + ids + '/<?php echo $session['C_USER']; ?>/download';

            $("#screenWindow").empty().append('<iframe frameborder="0"  src="' + url + '" style="width:100%;height:auto;min-height: 500px;padding:0px;"></iframe>');
            // $("#screenWindow").window('open');
        }

        if (key == 'screen') {
            var ids = $("#form_validation #id").val();
            var url = site_url + 'transaction/cashier/outputpdf/' + table + '/' + ids + '/<?php echo $session['C_USER']; ?>/screen';
            window.open(url);
        }
    }

    function table_grid(ttable, apv_inv_no) {
        ttable.datagrid({
            method: 'post',
            url: site_url + '<?php echo 'builder/datagrid/' . encrypt_decrypt('encrypt', 'veh_apvd'); ?>/apv_inv_no/' + apv_inv_no + '/?grid=true',
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
                    {field: 'pur_inv_no', title: '<?php getCaption("No. Faktur Beli"); ?>', width: 150, height: 20, sortable: true},
                    //{field: 'apv_inv_no', title: '<?php getCaption("No. Voucher"); ?>', width: 120, height: 20, sortable: true},
                    {field: 'po_no', title: '<?php getCaption("No. PO"); ?>', width: 120, height: 20, sortable: true},                  
                    {field: 'inv_total', title: '<?php getCaption("Hutang"); ?>', width: 120, height: 20, sortable: true,align: 'right', formatter: formatNumber},
                    {field: 'hd_begin', title: '<?php getCaption("Saldo Awal"); ?>', width: 120, height: 20, sortable: true,align: 'right', formatter: formatNumber},
                    {field: 'hd_paid', title: '<?php getCaption("Pembayaran"); ?>', width: 120, height: 20, sortable: true,align: 'right', formatter: formatNumber},
                    {field: 'hd_disc', title: '<?php getCaption("Diskon"); ?>', width: 120, height: 20, sortable: true,align: 'right', formatter: formatNumber},
                    {field: 'hd_end', title: '<?php getCaption("Saldo Akhir"); ?>', width: 120, height: 20, sortable: true,align: 'right', formatter: formatNumber},
                    
                     {field: 'engine', title: '<?php getCaption("No. Mesin"); ?>', width: 120, height: 20, sortable: true},
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

        var apv_inv_no = $("#form_validation #apv_inv_no").val();
        var ttable = $("#dt_apgd");
      
        if(apv_inv_no == ''){
            apv_inv_no = null;
        }
        
        table_grid(ttable, apv_inv_no);

        $('#form_validation #wrhs_code').combogrid('disable');
        $('#form_validation #opn_date').datebox('disable');
        $('#form_validation #cls_date').datebox('disable');
        $('#form_validation #apv_date').datebox('disable');
        $('#form_validation #supp_code').attr('disabled', true);
        $("#form_validation #apv_inv_no").attr('disabled', true);
        $("#form_validation #tot_item").attr('disabled', true);
        $("#form_validation #tot_paid").attr('disabled', true);
        $("#form_validation #tot_disc").attr('disabled', true);
        $("#form_validation #apv_inv_no").attr('disabled', true);
        $('#form_validation #apv_date').datebox('disable');
        $('#form_validation #pay_date').datebox('enable');
        $('#form_validation #check_date').datebox('enable');
        $('#form_validation #due_date').datebox('enable');
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
    }

    function condAdd() {
        $(".easyui-datebox").datebox('enable');
        $('#form_validation #id').val('');
        $('#form_validation input:text').val('');
        $("#form_validation #table").val(table);


        $('#form_validation #wrhs_code').combogrid('setValue', '<?php echo $wrhs_input; ?>');
        $('#form_validation #pay_type').combogrid('setValue', '');
        $('#form_validation #pay_date').datebox('setValue', '<?php echo date('Y-m-d'); ?>');
        $('#form_validation #opn_date').datebox('setValue', '<?php echo date('Y-m-d'); ?>');

        $.post(site_url + 'transaction/cashier/get_number/VPV', function (num) {
            $("#form_validation #apv_inv_no").val(num);
        });
        condReady();

        $("#form_validation #tot_paid").numberbox('setValue', 0);
        $("#form_validation #tot_disc").numberbox('setValue', 0);

    }
    function condEdit() {
        condReady();
    }
    function condDelete() {
        var id = $("#form_validation #id").val();
        var table = $("#form_validation #table").val();
        $.messager.confirm('Warning', 'Are you sure delete selected data ?', function (r) {
            if (r) {

                var url = site_url + 'transaction/cashier/deleteVoucher';
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
                            read_show('');
                            showAlert("Error while saving", '<font color="red">' + obj.message + '</font>');
                        }
                        scrlTop();
                    }
                });
            }
            read_show('');
            $('#form_validation :input').attr('disabled', false);
        });


    }
    function UncloseBtn() {
          $.messager.confirm('Unclose', 'Unclose this invoice?', function (r) {
            if (r) {
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
                        cmdDetail();
                    }

                } else
                {
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
        var apv_inv_no = $("#form_validation #apv_inv_no").val();
        var ttable = $("#dt_apgd2");
        var supp_code = $("#form_validation #supp_code").val();
        tableId2();
        read_show2('');
        table_grid(ttable, apv_inv_no);
        $("#DetailWindow").window('open');

        $('#form_validation2 #chassis').combogrid({
            panelWidth: 650,
             mode: 'remote',
            idField: 'id',
            textField: 'chassis',
            fitColumns: false,
            pagination: true,
            sortName: 'chassis',
            sortOrder: 'asc',
            remoteSort: true,
            multiSort: true,
            url: "<?php echo $site_url . 'builder/combogrid/' . encrypt_decrypt('encrypt', 'veh_aph') . '/supp_code/'; ?>" + supp_code+'/voucher',
            columns: [[
                    {field: 'chassis', title: '<?php getCaption("Nomor Rangka"); ?>', width: 160},
                    {field: 'pur_inv_no', title: '<?php getCaption("No. Faktur Beli"); ?>', width: 120},
                    {field: 'pur_date', title: '<?php getCaption("Tgl. Faktur Beli"); ?>', width: 100, formatter: formatDate},                   
                    {field: 'veh_name', title: '<?php getCaption("Nama Kendaraan"); ?>', width: 250},
                    {field: 'color_name', title: '<?php getCaption("Warna"); ?>', width: 200},
                    {field: 'po_no', title: '<?php getCaption("No. PO"); ?>', width: 120},
                    {field: 'po_date', title: '<?php getCaption("Tgl. PO"); ?>', width: 90, formatter: formatDate},
                    {field: 'inv_total', title: '<?php getCaption("Hutang"); ?>', align:'right', width: 120,formatter: formatNumber}
                ]],
            onSelect: function (index, rowData) {

                $('#form_validation2').form('load', {
                    pur_inv_no: rowData.pur_inv_no,
                    apv_inv_no: rowData.apv_inv_no,
                    po_no: rowData.po_no,
                    inv_total: rowData.inv_total,
                    hd_begin: rowData.hd_begin,
                    hd_paid: rowData.inv_total,
                    hd_disc: rowData.hd_disc,
                    // hd_end: rowData.hd_end,
                    engine: rowData.engine,
                    //po_date: rowData.po_date,
                    //pur_date: rowData.pur_date,
                    //apv_date: rowData.apv_date,
                    veh_name: rowData.veh_name,
                    color_name: rowData.color_name


                });
                
                $.each(rowData, function (i, v) {
                    if (i == 'apv_date' || i == 'pur_date' || i == 'po_date') {
                        if (v !== '0000-00-00') {
                             var vdate = dateSplit(v);
                            $("#form_validation2 #" + i).datebox('setValue', vdate);
                        }
                    }
                });

                var total = rowData.hd_begin - rowData.inv_total - rowData.hd_disc;

                $("#form_validation2 #hd_end").numberbox('setValue', total);

            }
        });

        $("#hd_paid").keyup(function () {
            var hd_paid = parseCurrency($(this).val());
            var hd_disc = parseCurrency($("#hd_disc").val());
            total_hd_end(hd_paid, hd_disc);
        });

        $("#hd_disc").keyup(function () {
            var hd_paid = parseCurrency($("#hd_paid").val());
            var hd_disc = parseCurrency($(this).val());
            total_hd_end(hd_paid, hd_disc);
        });
    }

    function total_hd_end(hd_paid, hd_disc) {
        var hd_begin = parseCurrency($("#hd_begin").val());

        var total = hd_begin - hd_paid - hd_disc;

        $("#form_validation2 #hd_end").numberbox('setValue', total);
    }

    function parseCurrency(num) {
        return num.replace(/[^0-9]/g, '');
    }

    function read_show2(nav) {
        var id = $("#id2").val();
        var apv_inv_no = $("#form_validation #apv_inv_no").val();

        $.post(site_url + 'crud/read/?apv_inv_no=' + apv_inv_no, {table: table2, nav: nav, id: id}, function (json) {

            $("#form_validation2 :input").val('');
            $("#form_validation2 .easyui-numberbox").numberbox('setValue', '');
            if (json !== '[]') {

                var rowData = $.parseJSON(json);

                $('#form_validation2').form('load', {
                    chassis: rowData.chassis,
                    pur_inv_no: rowData.pur_inv_no,
                    apv_inv_no: rowData.apv_inv_no,
                    po_no: rowData.po_no,
                    inv_total: rowData.inv_total,
                    hd_begin: rowData.hd_begin,
                    hd_paid: rowData.hd_paid,
                    hd_disc: rowData.hd_disc,
                    hd_end: rowData.hd_end,
                    engine: rowData.engine,
                    //po_date: rowData.po_date,
                    //pur_date: rowData.pur_date,
                    //apv_date: rowData.apv_date,
                    veh_name: rowData.veh_name,
                    color_name: rowData.color_name
                });
                
                $.each(rowData, function (i, v) {
                    if (i == 'apv_date' || i == 'pur_date' || i == 'po_date') {
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
        var apv_inv_no = $("#form_validation #apv_inv_no").val();

        var save_url2 = site_url + 'transaction/cashier/save_apvd/' + apv_inv_no+'/<?php echo $session['C_USER']; ?>';

        $('#form_validation2 :input').attr('disabled', false);

        $("#form_validation2").form('submit', {
            url: save_url2,
            onSubmit: function () {
                return $(this).form('validate');
            },
            success: function (data) { 
                var obj = JSON.parse(data);

                if (obj.success !== false) {

                    var ttable = $("#dt_apgd");
                    var ttable2 = $("#dt_apgd2");
                    table_grid(ttable, apv_inv_no);
                    table_grid(ttable2, apv_inv_no);
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
        var apv_inv_no = $("#form_validation #apv_inv_no").val();
        var id = $("#id2").val();

        $.messager.confirm('Confirm Delete', 'Are you sure delete selected data ?', function (r) {
            if (r) {
                var url = site_url + 'transaction/cashier/delete_apvd';
                $.post(url, {table: table2, id: id}, function (data) {

                    obj = JSON.parse(data);
                    if (obj.status == true) {
                        var ttable = $("#dt_apgd");
                        var ttable2 = $("#dt_apgd2");
                        table_grid(ttable, apv_inv_no);
                        table_grid(ttable2, apv_inv_no);
                        $("#id2").val('');
                        $("#form_validation2 :input").val('');
                        read_show2('');
                        read_show('');
                    } else
                    {
                        showAlert("Error while delete", '<font color="red">' + obj.message + '</font>');
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
        $('#form_validation2 #hd_paid').attr('disabled', false);
        $('#form_validation2 #hd_disc').attr('disabled', false);

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
        $.messager.alert('Edited','Delete this Record Then Add New Record', 'warning');
    }


    function tableId2() {
        divtableId2.empty().append('<input type="hidden" name="id2"  id="id2"><input type="hidden" name="table2"  id="table2" value="' + table2 + '">');
    }
    /*End Detail*/

    $(document).ready(function () {
         checkRunMonthYear('AWO');
        tableId();
        read_show('');
        version('03.17-31');
    });
</script>