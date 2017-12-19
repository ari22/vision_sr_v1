<script>

    $(document).ready(function () {
        tableId();
        read_show('');
        version('03.17-31');
    });

    var table = 'veh_aph';
    var form = $('#form_validation');
    var save_url = site_url + 'transaction/cashier/save_arh';

    var divtableId = $("#tableId");
    var ttable = $("#dt_ard");

    var table2 = 'veh_apd';
    var ttable2 = $("#dt_ard2");

    var divtableId2 = $("#tableId2");

 
    function tableId() {
        divtableId.empty().append('<input type="hidden" name="id"  id="id"><input type="hidden" name="table"  id="table" value="' + table + '">');
    }

    function read_show(nav) {
        var id = $("#form_validation #id").val();
        $.post(site_url + 'crud/read', {table: table, nav: nav, id: id}, function (json) {
             $('#form_validation input:text').val('');

            if (json !== '[]') {
               
                var rowData = $.parseJSON(json);

                $.each(rowData, function (i, v) {
                    if (i !== 'hdd_end' || i !== 'hd_disc' || i !== 'hd_paid' || i !== 'hd_begin' || i !== 'inv_total') {
                        $("#form_validation #" + i).val(v);
                    }
                    
                    if(i == 'pur_date' || i == 'stk_date' || i == 'due_date' || i == 'cls_date' || i == 'supp_invdt' || i == 'po_date'){
                        if (v !== '0000-00-00') {
                             var vdate = dateSplit(v);
                             
                            $("#" + i).datebox('setValue', vdate);
                        }
                    }
                });
                $('#form_validation').form('load', {
                    inv_total: rowData.inv_total,
                    hd_begin: rowData.hd_begin,
                    hd_paid: rowData.hd_paid,
                    hd_disc: rowData.hd_disc,
                    hd_end: rowData.hd_end
                   
                });

                $("#hd_paid2").numberbox('setValue', rowData.hd_paid);
                $("#hd_disc2").numberbox('setValue', rowData.hd_disc);
                $("#wrhs_code").combogrid('setValue', rowData.wrhs_code);



                cmdcondAwal();
                formDisabled();
                table_grid(ttable, rowData.pur_inv_no);
                $('.loader').hide();
            } else {
                cmdcondAwal();
                formDisabled();
                $('.cmdEdit').attr('disabled', true);
                $('.cmdDelete').attr('disabled', true);
                $('.cmdEdit').linkbutton('disable');
                $('.cmdDelete').linkbutton('disable');

                $("#bayar").attr('disabled', true);
                $("#bayar").linkbutton('disable');
                $('.loader').hide();
                 table_grid(ttable, null);
            }
        });
    }

    function condSearch2() {

        $("#tableSearch").datagrid({
            method: 'post',
            url: site_url + 'builder/table_grid/load/' + table2 + '/?grid=true',
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
                    {field: 'pur_inv_no', title: '<?php getCaption("No. Faktur"); ?> ', width: 150, height: 20, sortable: true},
                    {field: 'sal_date', title: '<?php getCaption("Tgl. Faktur"); ?> ', width: 150, height: 20, sortable: true, formatter:formatDate},
                    {field: 'pay_date', title: '<?php getCaption("Tgl. Bayar"); ?> ', width: 150, height: 20, sortable: true, formatter:formatDate},
                    {field: 'bank_code', title: '<?php getCaption("Bank"); ?>  ', width: 200, height: 20, sortable: true},
                    {field: 'pay_val', title: '<?php getCaption("Pembayaran"); ?>  ', width: 150, height: 20, sortable: true},
                    {field: 'disc_val', title: '<?php getCaption("Diskon"); ?>', width: 150, height: 20, sortable: true},
                    {field: 'payer_name', title: '<?php getCaption("Dibayar Oleh"); ?>  ', width: 250, height: 20, sortable: true},
                    {field: 'payer_addr', title: '<?php getCaption("Alamat"); ?>  ', width: 200, height: 20, sortable: true},
                    {field: 'payer_desc', title: '<?php getCaption("Deskripsi"); ?>  ', width: 200, height: 20, sortable: true}
                ]]
        });
        // $("#tableSearch").datagrid('enableFilter');
        $("#tableSearch").datagrid('reload');
        $('#windowSearch').window('open');

        var option = $("#SearchOption2").html();

        $("#actionSearch").empty().html(option);

    }
    function doSearch() {
        $("#tableSearch").datagrid('load', {
            field1: $('#code').val(),
            field2: $('#arg_date2').val()
        });
    }
    function getSearchselect() {
        var row = $("#tableSearch").datagrid('getSelected');

        if (row) {/*coding buat ap y? - nicho
            $.post(site_url + 'transaction/cashier/check_id', {tbl: table, pur_inv_no: row.pur_inv_no}, function (json) {
                var val = $.parseJSON(json);
                $("#form_validation #id").val(val.id);

                read_show('');
            });*/

            $("#form_validation #id").val(row.id);
            read_show('');
            $('#windowSearch').window('close');
            $("#actionSearch").empty();
            $("#SearchOption").hide();
            $("#SearchOption2").hide();
        }
    }
    function getSearchselect2() {
        var row = $("#tableSearch2").datagrid('getSelected');

        if (row) {
            $.post(site_url + 'crud/read/?apg_inv_no=' + row.apg_inv_no, {table: table, nav: '', id: ''}, function (json) {
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
    function table_grid(ttable, pur_inv_no) {
        
        ttable.datagrid({
            method: 'post',
            url: site_url + '<?php echo 'builder/datagrid/' . encrypt_decrypt('encrypt', 'veh_apd'); ?>/pur_inv_no/' + pur_inv_no + '/?grid=true',
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
                    {field: 'pay_date', title: '<?php getCaption("Tgl. Bayar"); ?>', width: 100, height: 20, sortable: true, formatter:formatDate},
                    {field: 'pay_type', title: '<?php getCaption("Jenis Bayar"); ?>', width: 120, height: 20, sortable: true},
                    {field: 'bank_code', title: '<?php getCaption("Bank"); ?>', width: 120, height: 20, sortable: true},
                    {field: 'check_no', title: '<?php getCaption("No. Check"); ?>', width: 120, height: 20, sortable: true},
                    {field: 'check_date', title: '<?php getCaption("Tanggal Check"); ?>', width: 100, height: 20, sortable: true, formatter:formatDate},
                    {field: 'due_date', title: '<?php getCaption("Tgl J. Tempo"); ?>', width: 100, height: 20, sortable: true, formatter:formatDate},
                    {field: 'pay_val', title: '<?php getCaption("Pembayaran"); ?>', width: 120, height: 20, sortable: true,align:"right", formatter: formatNumber},
                    {field: 'disc_val', title: '<?php getCaption("Diskon"); ?>', width: 120, height: 20, sortable: true,align:"right", formatter: formatNumber},
                    {field: 'pay_desc', title: '<?php getCaption("Keterangan"); ?>', width: 200, height: 20, sortable: true},
                    {field: 'coll_code', title: '<?php getCaption("Kolektor"); ?>', width: 120, height: 20, sortable: true},
                    {field: 'add_by', title: 'Added By', width: 120, height: 20, sortable: true}
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
        $('.search2').removeAttr('disabled');
        $('.bayar').removeAttr('disabled');

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
        $('.search2').linkbutton('enable');
        $('.bayar').linkbutton('enable');


    }
    function condReady() {
        $('#form_validation #note').attr('disabled', false);
        $('#form_validation #due_date').datebox('enable');
        var pur_inv_no = $("#form_validation #pur_inv_no").val();
        var ttable = $("#dt_ard");
        table_grid(ttable, pur_inv_no);

        cmdcondReady();
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
        $('.search2').attr('disabled', true);
        $('.bayar').attr('disabled', true);

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
        $('.search2').linkbutton('disable');
        $('.bayar').linkbutton('disable');

        $("#form_validation #cmdClose").linkbutton('disable');
        $("#form_validation #cmdDetail").linkbutton('disable');
    }
    function condAdd() {
        showAlert("Disabled", '<font color="red">This button is deactivated</font>');
    }
    function condEdit() {
        condReady();
    }
    function condDelete() {
        showAlert("Error while delete", '<font color="red">This button is deactivated</font>');
        return false;
        var id = $("#form_validation #id").val();
        var table = $("#form_validation #table").val();
        $.messager.confirm('Warning', 'Do you really want to delete the selected data?', function (r) {
            if (r) {

                var url = site_url + 'transaction/cashier/deletePiutangGabungan';
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
    function saveData() {
        $('#form_validation :input').attr('disabled', false);

        form.form('submit', {
            url: save_url,
            onSubmit: function () {
                return $(this).form('validate');
            },
            success: function (data) {
                // alert(data)
                var obj = JSON.parse(data);
                if (obj.success == true) {
                    showAlert("Information", obj.message);

                    if (obj.status == 'update') {
                        read_show('');
                    } else {
                        read_show('');

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

    function bayarHutang() {
        scrlTop();
        tableId2();
        read_show2('');
        var pur_inv_no = $("#form_validation #pur_inv_no").val();

        table_grid(ttable2, pur_inv_no);
        //$('#BayarWindow').window('center');
        
        $('#BayarWindow').window('open');
    }

    function tableId2() {
        divtableId2.empty().append('<input type="hidden" name="id2"  id="id2"><input type="hidden" name="table2"  id="table2" value="' + table2 + '">');
    }
    function read_show2(nav) {
        var id = $("#id2").val();
        var pur_inv_no = $("#form_validation #pur_inv_no").val();

        $.post(site_url + 'crud/read/?pur_inv_no=' + pur_inv_no, {table: table2, nav: nav, id: id}, function (json) { // alert(json)
            $("#form_validation3 :input").val('');
            $("#form_validation3 .easyui-numberbox").numberbox('setValue', '');
            if (json !== '[]') {

                var rowData = $.parseJSON(json);

                $.each(rowData, function (i, v) {
                    $("#form_validation3 #" + i).val(v);

                    if (i == 'pay_date' || i == 'check_date' || i == 'due_date') {
                        if (v !== '0000-00-00') {
                            var vdate = dateSplit(v);
                            $("#form_validation3 #" + i).datebox('setValue', vdate);
                        }
                    }
                    if (i == 'pay_type') {
                        $("#form_validation3 #" + i).combobox('setValue', v);
                    }
                    if (i == 'pay_val' || i == 'disc_val') {
                        $("#form_validation3 #" + i).numberbox('setValue', v);
                    }
                });
                $("#id2").val(rowData.id);
            }
            formDisabled2();
            cmdcondAwal2();
            table_grid(ttable2, pur_inv_no);
        });
    }

    function saveData2() {
          $('#cmdSave2').linkbutton('disable');
        var pur_inv_no = $("#form_validation #arg_inv_no").val();

        var save_url2 = site_url + 'transaction/cashier/save_apd/' + pur_inv_no;
        $('#form_validation3 :input').attr('disabled', false);

        $("#form_validation3").form('submit', {
            url: save_url2,
            onSubmit: function () {
                return $(this).form('validate');
            },
            success: function (data) {

                var obj = JSON.parse(data);

                if (obj.success == true) {
                    var ttable = $("#dt_argd");
                    var ttable2 = $("#dt_argd2");
                    table_grid(ttable, pur_inv_no);
                    table_grid(ttable2, pur_inv_no);
                    $("#id2").val('');

                    read_show2('');
                    read_show('');
                } else
                {
                    showAlert("Error while saving", '<font color="red">' + obj.message + '</font>');
                    cmdcondAwal2();
                    formDisabled2();

                    $("#id2").val('');
                    read_show2('');
                }
            }
        });
    }



    function condCancel2() {
        cmdcondAwal2();
        read_show2('');
        $("#form_validation3 .formError").remove();
    }

    function formDisabled2() {
        $('#form_validation3 :input').attr('disabled', true);

        $('#form_validation3 .easyui-combogrid').combogrid('disable');
        $('#form_validation3 .easyui-combobox').combobox({disabled: true});
        $('#form_validation3 .combo-text').removeClass('validatebox-text');
        $('#form_validation3 .combo-text').removeClass('validatebox-invalid');
        cmdcondAwal2();
        $('#form_validation3 #ok').removeAttr('disabled');
        $('#form_validation3 #ok').linkbutton('enable');
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
        $('#prepaid').removeAttr('disabled');
        $('#print').removeAttr('disabled');

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

        $('#prepaid').linkbutton('enable');
        $('#print').linkbutton('enable');

    }
    function condReady2() {
        $('#form_validation3 :input').attr('disabled', false);
        $('#form_validation3 #table2').val(table2);
        $("#form_validation3 .easyui-datebox").datebox('enable');
        $('#form_validation3 #pd_paid').attr('disabled', false);
        $('#form_validation3 #pd_disc').attr('disabled', false);

        $('#form_validation3 .easyui-combogrid').combogrid('enable');
        $('#form_validation3 .easyui-combobox').combobox({disabled: false});

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
        $('#prepaid').attr('disabled', true);
        $('#print').attr('disabled', true);

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

        $('#prepaid').linkbutton('disable');
        $('#print').linkbutton('disable');
    }
    function condAdd2() {
        showAlert("Disabled", '<font color="red">This button is deactivated. Please use Vehicle Account Payable Group Payment to pay for this vehicle.</font>');
        /*
         var pur_inv_no = $("#form_validation #pur_inv_no").val(); 
         $.post(site_url + 'transaction/cashier/checkGroupPiutang', {pur_inv_no: pur_inv_no}, function (json) {
         var obj = $.parseJSON(json);
         
         if (obj.status !== false) {
         $('#form_validation3 .combo-text').val('');
         $('#form_validation3 #id2').val('');
         $('#form_validation3 :input').val('');
         
         condReady2();
         } else {
         alert('Tombol ini sudah di-nonaktifkan. Pakailah pembayaran Piutang Kendaraan gabungan');
         }
         });
         return false;*/
    }

    function condEdit2() {
        var opn_date = $('#form_validation #opn_date').val();

        var date = "<?php echo date('Y-m-d'); ?>";

        if (opn_date > date) {
            showAlert("Error", '<font color="red">Sorry, this transaction can’t be edited</font>');
        }
    }

    function prepaids() {
        $('#form_validation :input').attr('disabled', false);
        //table_dpcd();
        form.form('submit', {
            url: site_url + 'transaction/cashier/prepaidDPSupplier',
            onSubmit: function () {
                return $(this).form('validate');
            },
            success: function (data) { 
                var obj = $.parseJSON(data);

                if (obj.status !== false) {
                    var po_no = obj.po_no;
                    $("#dt_uj").empty();
                    table_dpsd(po_no);
                } else {
                     $.messager.alert('Warning',obj.message, 'warning');

                }

                formDisabled();
            }
        });
    }

    function table_dpsd(po_no) { 
        $("#UJWindow").window('open');
        
        var url = site_url + '<?php echo 'builder/grid_dpsd/' . encrypt_decrypt('encrypt', 'veh_dpsd'); ?>/' + po_no + '/hutang/?grid=true';

        $("#dt_uj").datagrid({
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
                    {field: 'po_no', title: '<?php getCaption("No. PO"); ?>', width: 120, height: 20, sortable: true},
                    {field: 'po_date', title: '<?php getCaption("Tgl. PO"); ?>', width: 120, height: 20, sortable: true, formatter:formatDate},
                    {field: 'supp_code', title: '<?php getCaption("Kode Supplier"); ?>', width: 120, height: 20, sortable: true},
                    {field: 'supp_name', title: '<?php getCaption("Nama Supplier"); ?>', width: 250, height: 20, sortable: true},                 
                    {field: 'dp_inv_no', title: 'DP No.', width: 150, height: 20, sortable: true},
                    {field: 'dp_date', title: 'DP Date', width: 150, height: 20, sortable: true, formatter:formatDate},
                    {field: 'pay_bt', title: '<?php getCaption("Uang Jaminan"); ?>', width: 120, height: 20, sortable: true,formatter: formatNumber},
                    {field: 'pay_date', title: '<?php getCaption("Tgl. Bayar"); ?>', width: 120, height: 20, sortable: true, formatter:formatDate},
                    {field: 'check_no', title: '<?php getCaption("No. Check"); ?>', width: 120, height: 20, sortable: true}

                ]]
        });
    }

    function getUJaminan() {
        var row = $("#dt_uj").datagrid('getSelected');
        var pur_inv_no = $("#form_validation #pur_inv_no").val();
        var po_no = $("#po_no").val();
        
        if (row) {
            $.post(site_url + 'transaction/cashier/uangJaminanSupplier', {id: row.id, pur_inv_no: pur_inv_no, user: '<?php echo $_SESSION['C_USER']; ?>'}, function (data) {

                var obj = $.parseJSON(data);

                if (obj.success !== false) { 
                    // var id = $("#form_validation #id").val();
                    read_show('');
                    read_show2('');

                    var pur_inv_no = $("#form_validation #pur_inv_no").val();
                    table_grid(ttable2, pur_inv_no);

                    $("#UJWindow").window('close');
                } else {
                     $.messager.alert('Warning',obj.message, 'warning');
                }

            });
        }
    }
   
      function condDelete2() {
        var id = $("#form_validation3 #id2").val();

        $.messager.confirm('Warning', 'Are you sure delete selected data ?', function (r) {
            if (r) {

                var url = site_url + 'transaction/cashier/deleteVehApd';
                $.post(url, {table: table2, id: id}, function (data) {
                    obj = JSON.parse(data);

                    if (obj.status !== false) {
                        read_show2('');
                        read_show('');
                    } else
                    {
                        showAlert("Error while delete", '<font color="red">' + obj.message + '</font>');
                        read_show2('');
                        read_show('');
                    }
                });
            }
        });
    }
    function print_sc(key) {

        if(key == 'screen'){
            $("#screenWindow").window('open');
            var ids = $("#id2").val();
            var signature = $("#signature").val();
            var jabatan = $("#jabatan").val();

            var url = site_url + 'transaction/cashier/outputpdf/' + table2 + '/' + ids + '/<?php echo $session['C_USER']; ?>/screen/' + signature + '/' + jabatan;

            $("#screenWindow").empty().append('<iframe frameborder="0"  src="' + url + '" style="width:100%;height:auto;min-height: 500px;padding:0px;"></iframe>');
        }
        if(key == 'download'){
            var ids = $("#id2").val();
            var signature = $("#signature").val();
            var jabatan = $("#jabatan").val();

            var url = site_url + 'transaction/cashier/outputpdf/' + table2 + '/' + ids + '/<?php echo $session['C_USER']; ?>/download/' + signature + '/' + jabatan;


            $("#screenWindow").empty().append('<iframe frameborder="0"  src="' + url + '" style="width:100%;height:auto;min-height: 500px;padding:0px;"></iframe>');
            // $("#screenWindow").window('open');
        }
    }

    function prints() {
        $.post(site_url + 'transaction/cashier/get_number/VKP', function (num) {
            $("#no_kwitansi").val(num);
        });
        $("#PrintsWindow").window('open');
    }

</script>