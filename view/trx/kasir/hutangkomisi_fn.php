<script>

    $(document).ready(function () {
        tableId();
        read_show('');
        version('03.17-31');
    });

    var table = 'veh_comaph';
    var form = $('#form_validation');
    var save_url = site_url + 'transaction/cashier/save_comaph';

    var divtableId = $("#tableId");
    var ttable = $("#dt");

    var table2 = 'veh_comapd';
    var ttable2 = $("#dt2");

    var divtableId2 = $("#tableId2");

    $("#form_validation3 #pay_type").combogrid({
        onSelect: function (index, row) {
            if (row.pay_type == 'CASH') {
                $("#form_validation3 #check_no").val(row.pay_type);
                $("#form_validation3 #check_date").datebox('setValue', '<?php echo date("Y-m-d"); ?>');
                $("#form_validation3 #due_date").datebox('setValue', '<?php echo date("Y-m-d"); ?>');
            }
        }
    });

    function tableId() {
        divtableId.empty().append('<input type="hidden" name="id"  id="id"><input type="hidden" name="table"  id="table" value="' + table + '">');
    }

    function read_show(nav) {
        var id = $("#form_validation #id").val();
        $.post(site_url + 'crud/read', {table: table, nav: nav, id: id}, function (json) { //alert(json)
            $('#form_validation input:text').val('');
            $("#form_validation .easyui-datebox").datebox('setValue', '');

            if (json !== '[]') {

                var rowData = $.parseJSON(json);

                $.each(rowData, function (i, v) {
                    $("#form_validation #" + i).val(v);
                    
                     if (i == 'sal_date' || i == 'so_date' ){
                        if (v !== '0000-00-00') {
                             var vdate = dateSplit(v);
                            $("#" + i).datebox('setValue', vdate);
                        }
                    }
                    if(i == 'hd_begin' || i == 'hd_paid' || i == 'hd_disc' || i == 'hd_pph' || i == 'hd_end' ){
                        $("#" + i).numberbox('setValue', v);
                    }
                  
                });
                
                
                $("#hd_paid2").numberbox('setValue', rowData.hd_paid);
                $("#hd_disc2").numberbox('setValue', rowData.hd_disc);
                $("#hd_pph2").numberbox('setValue', rowData.hd_pph);
                
                cmdcondAwal();
                formDisabled();
                table_grid(ttable, rowData.sal_inv_no);
            
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
            }
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
            columns: [[
                    {field: 'sal_inv_no', title: '<?php getCaption("No. Faktur"); ?> ', width: 150, height: 20, sortable: true},
                    {field: 'sal_date', title: '<?php getCaption("Tgl. Faktur"); ?> ', width: 150, height: 20, sortable: true, formatter:formatDate},
                    {field: 'so_no', title: '<?php getCaption("No. SPK"); ?> ', width: 150, height: 20, sortable: true},
                    {field: 'cust_name', title: '<?php getCaption("Nama Pelanggan"); ?>  ', width: 200, height: 20, sortable: true},
                    {field: 'chassis', title: '<?php getCaption("Chassis"); ?>  ', width: 150, height: 20, sortable: true},
                    {field: 'inv_total', title: '<?php getCaption("Jumlah Faktur"); ?>', width: 150, height: 20, sortable: true},
                    {field: 'pd_end', title: '<?php getCaption("Piutang Akhir"); ?>  ', width: 250, height: 20, sortable: true},
                    {field: 'veh_name', title: '<?php getCaption("Nama Kendaraan"); ?>  ', width: 200, height: 20, sortable: true},
                    {field: 'due_date', title: '<?php getCaption("Jatuh Tempo"); ?>  ', width: 200, height: 20, sortable: true, formatter:formatDate},
                    {field: 'cust_code', title: '<?php getCaption("Kode Pelanggan"); ?>  ', width: 200, height: 20, sortable: true},
                    {field: 'veh_code', title: '<?php getCaption("Kode Kendaraan"); ?>  ', width: 150, height: 20, sortable: true}
                ]]
        });
    }
    */
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
                    {field: 'sal_inv_no', title: '<?php getCaption("No. Faktur"); ?> ', width: 150, height: 20, sortable: true},
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

        if (row) {/*//kenaoa ada coding ini? buat ap? - nicho
            $.post(site_url + 'transaction/cashier/check_id', {tbl: table, sal_inv_no: row.sal_inv_no}, function (json) {
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
    /*function getSearchselect2() {
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
    }*/
    function close_search() {
        $('#windowSearch').window('close');
        $("#actionSearch").empty()
        $("#SearchOption").hide();
    }
    function table_grid(ttable, sal_inv_no) {

        ttable.datagrid({
            method: 'post',
            url: site_url + '<?php echo 'builder/datagrid/' . encrypt_decrypt('encrypt', 'veh_comapd'); ?>/sal_inv_no/' + sal_inv_no + '/?grid=true',
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
                    {field: 'pay_date', title: '<?php getCaption("Tgl. Bayar"); ?>', width: 120, height: 20, sortable: true, formatter:formatDate},
                    {field: 'pay_type', title: '<?php getCaption("Jenis Bayar"); ?>', width: 150, height: 20, sortable: true},
                    {field: 'check_no', title: '<?php getCaption("No. Check"); ?>', width: 120, height: 20, sortable: true},
                    {field: 'check_date', title: '<?php getCaption("Tanggal Check"); ?>', width: 120, height: 20, sortable: true, formatter:formatDate},
                    {field: 'due_date', title: '<?php getCaption("Tgl J. Tempo"); ?>', width: 120, height: 20, sortable: true, formatter:formatDate},
                    {field: 'pay_val', title: '<?php getCaption("Pembayaran"); ?>', width: 120, height: 20, sortable: true, align: 'right', formatter: formatNumber},
                    {field: 'disc_val', title: '<?php getCaption("Diskon"); ?>', width: 120, height: 20, sortable: true, align: 'right', formatter: formatNumber},
                    {field: 'pph', title: '<?php getCaption("pph"); ?>', width: 120, height: 20, sortable: true, align: 'right', formatter: formatNumber},                 
                    {field: 'pay_desc', title: '<?php getCaption("Keterangan"); ?>', width: 120, height: 20, sortable: true}
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
        scrlTop();
        $('#form_validation #note').attr('disabled', false);
        $('#form_validation #due_date').datebox('enable');
        var sal_inv_no = $("#form_validation #sal_inv_no").val();
        var ttable = $("#dt_ard");
        table_grid(ttable, sal_inv_no);

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
       showAlert("Error while deleting", '<font color="red">This button is deactivated</font>');
        return false;
        var id = $("#form_validation #id").val();
        var table = $("#form_validation #table").val();
        $.messager.confirm('Warning', 'Are you sure delete selected data ?', function (r) {
            if (r) {
                $(".loader").show();
                var url = site_url + 'transaction/cashier/deletePiutangGabungan';
                $.post(url, {table: table, id: id}, function (data) {
                    obj = JSON.parse(data);

                    if (obj.success == true) {
                        read_show('P');
                        showAlert("Information", obj.message);
                        $(".loader").hide();
                    } else
                    {
                        $(".loader").hide();
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
        $(".loader").show();
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
                    $(".loader").hide();
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
        var sal_inv_no = $("#form_validation #sal_inv_no").val();

        table_grid(ttable2, sal_inv_no);
        //$('#BayarWindow').window('center');

        $('#BayarWindow').window('open');
    }

    function tableId2() {
        divtableId2.empty().append('<input type="hidden" name="id2"  id="id2"><input type="hidden" name="table2"  id="table2" value="' + table2 + '">');
    }
    function read_show2(nav) {
        var id = $("#id2").val();
        var sal_inv_no = $("#form_validation #sal_inv_no").val();

        $.post(site_url + 'crud/read/?sal_inv_no=' + sal_inv_no, {table: table2, nav: nav, id: id}, function (json) { //alert(json)
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

                    if (i == 'coll_code' || i == 'pay_type') {
                        $("#form_validation3 #" + i).combogrid('setValue', v);
                    }
                    if (i == 'pay_val' || i == 'disc_val') {
                        $("#form_validation3 #" + i).numberbox('setValue', v);
                    }
                });
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

        var save_url2 = site_url + 'transaction/cashier/save_comapd/' + sal_inv_no + '/<?php echo $session['C_USER']; ?>';
        $('#form_validation3 :input').attr('disabled', false);

        $("#form_validation3").form('submit', {
            url: save_url2,
            onSubmit: function () {
                return $(this).form('validate');
            },
            success: function (data) {

                var obj = JSON.parse(data);

                if (obj.success == true) {

                    table_grid(ttable, sal_inv_no);
                    table_grid(ttable2, sal_inv_no);
                    $("#id2").val('');

                    read_show2('');
                    read_show('');
                } else
                {
                    showAlert("Error while saving", '<font color="red">' + obj.message + '</font>');
                     $('#cmdSave2').linkbutton('enable');
                }
            }
        });
    }

    function condDelete2() {
        var id = $("#form_validation3 #id2").val();

        $.messager.confirm('Warning', 'Are you sure delete selected data ?', function (r) {
            if (r) {

                var url = site_url + 'transaction/cashier/deleteComapd';
                $.post(url, {table: table2, id: id}, function (data) { //alert(data)
                    obj = JSON.parse(data);

                    if (obj.status !== false) {
                        read_show2('');
                        read_show('');
                    } else
                    {
                        showAlert("Error while delete", '<font color="red">' + obj.message + '</font>');
                        read_show('');
                    }
                });
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
        
        $('#ok2').attr('disabled', false);
        $('#ok2').linkbutton('enable');
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
        
        $('#ok2').attr('disabled', true);
        $('#ok2').linkbutton('disable');
    }
    function condAdd2() {

        $('#form_validation3 .combo-text').val('');
        $('#form_validation3 #id2').val('');
        $('#form_validation3 :input').val('');
        $('#form_validation3 #pay_date').datebox('setValue', '<?php echo date('Y-m-d'); ?>');
        $('#form_validation3 .easyui-numberbox').numberbox('setValue', '');
        
        var hd_end = $("#form_validation #hd_end").numberbox('getValue');
        $('#form_validation3 #pay_val').numberbox('setValue', hd_end);
        
        condReady2();
    }

    function condEdit2() {
        var opn_date = $('#form_validation #opn_date').val();

        var date = "<?php echo date('Y-m-d'); ?>";

        if (opn_date > date) {
            showAlert("Error", '<font color="red">Maaf, transaksi ini sudah tidak bisa diubah</font>');
        }
    }

    function prepaids() {
        $('#form_validation :input').attr('disabled', false);
        //table_dpcd();
        form.form('submit', {
            url: site_url + 'transaction/cashier/prepaid',
            onSubmit: function () {
                return $(this).form('validate');
            },
            success: function (data) { //alert(data)
                var obj = $.parseJSON(data);

                if (obj.status !== false) {
                    var dp_inv_no = obj.dp_inv_no;
                    table_dpcd(dp_inv_no);
                } else {
                    $.messager.alert('Warning',obj.message, 'warning');
                }

                formDisabled();
            }
        });
    }

    function table_dpcd(dp_inv_no) {

        $("#UJWindow").window('open');

        $("#dt_uj").datagrid({
            method: 'post',
            url: site_url + '<?php echo 'builder/grid_dpcd/' . encrypt_decrypt('encrypt', 'veh_dpcd'); ?>/' + dp_inv_no + '/piutang/?grid=true',
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
                    {field: 'dp_inv_no', title: '<?php getCaption("No. Faktur"); ?>', width: 150, height: 20, sortable: true},
                    {field: 'dp_date', title: '<?php getCaption("Tgl. Faktur"); ?>', width: 150, height: 20, sortable: true, formatter:formatDate},
                    {field: 'so_no', title: '<?php getCaption("No. SPK"); ?>', width: 120, height: 20, sortable: true},
                    {field: 'so_date', title: '<?php getCaption("Tgl. SPK"); ?>', width: 120, height: 20, sortable: true, formatter:formatDate},
                    {field: 'cust_code', title: '<?php getCaption("Kode Pelanggan"); ?>', width: 120, height: 20, sortable: true},
                    {field: 'cust_name', title: '<?php getCaption("Nama Pelanggan"); ?>', width: 120, height: 20, sortable: true},
                    {field: 'due_date', title: '<?php getCaption("Uang Jaminan"); ?>', width: 120, height: 20, sortable: true, formatter:formatDate},
                    {field: 'pay_val', title: '<?php getCaption("Tgl. Terima"); ?>', width: 120, height: 20, sortable: true, align: 'right', formatter: formatNumber},
                    {field: 'check_no', title: '<?php getCaption("No. Check"); ?>', width: 120, height: 20, sortable: true},
                    {field: 'chassis', title: '<?php getCaption("Chassis"); ?>', width: 120, height: 20, sortable: true},
                    {field: 'engine', title: '<?php getCaption("Engine"); ?>', width: 120, height: 20, sortable: true}
                ]]
        });
    }

    function getUJaminan() {
        var row = $("#dt_uj").datagrid('getSelected');

        if (row) {
            $.post(site_url + 'transaction/cashier/uangJaminan', {id: row.id}, function (data) {

                var obj = $.parseJSON(data);

                if (obj.status !== false) {
                    // var id = $("#form_validation #id").val();
                    read_show('');
                    read_show2('');

                    var sal_inv_no = $("#form_validation #sal_inv_no").val();
                    table_grid(ttable2, sal_inv_no);

                    $("#UJWindow").window('close');

                } else {
                    $.messager.alert('Warning',obj.message, 'warning');
                }

            });
        }
    }
    function screen_view() {
        $("#screenWindow").window('open');
        var ids = $("#id2").val();
        var signature = $("#signature").val();
        var jabatan = $("#jabatan").val();

        var url = site_url + 'transaction/cashier/outputpdf/' + table2 + '/' + ids + '/<?php echo $session['C_USER']; ?>/screen/' + signature + '/' + jabatan;

        $("#screenWindow").empty().append('<iframe frameborder="0"  src="' + url + '" style="width:100%;height:auto;min-height: 500px;padding:0px;"></iframe>');
    }

    function print_sc() {

        var ids = $("#id2").val();
        var signature = $("#signature").val();
        var jabatan = $("#jabatan").val();

        var url = site_url + 'transaction/cashier/outputpdf/' + table2 + '/' + ids + '/<?php echo $session['C_USER']; ?>/download/' + signature + '/' + jabatan;


        $("#screenWindow").empty().append('<iframe frameborder="0"  src="' + url + '" style="width:100%;height:auto;min-height: 500px;padding:0px;"></iframe>');
        // $("#screenWindow").window('open');
    }

    function prints() {
        $.post(site_url + 'transaction/cashier/get_number/VKP', function (num) {
            $("#no_kwitansi").val(num);
        });
        $("#PrintsWindow").window('open');
    }


</script>