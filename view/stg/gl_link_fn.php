<script>

    var table = 'set_vglh';
    var form = $('#form_validation');
    var divtableId = $("#tableId");
    var ttable = $('#dt');

    var table2 = 'set_vgld';
    var trx_code = $("#form_validation #trx_code").val();
    var ttable2 = $('#dt2');
    var divtableId2 = $("#tableId2");
    
    var save_url = site_url + 'transaction/setting/save_vglh/<?php echo $_SESSION['C_USER']; ?>/<?php echo $comp_code;?>';
      

    $("#trx_desc").combogrid({
        onSelect: function (index, row) {
            $('#trx_code').val(row.trx_code);
        }
    });

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
    function tableId() {
        divtableId.empty().append('<input type="hidden" name="id"  id="id"><input type="hidden" name="table"  id="table" value="' + table + '">');
    }

    function read_show(nav) {
        var id = $("#form_validation #id").val();

        $(".loader").hide();
        cmdcondAwal();
        formDisabled();

        $.post(site_url + 'crud/read', {table: table, nav: nav, id: id}, function (json) { 
            if (json !== '[]') {
                var rowData = $.parseJSON(json);
                $.each(rowData, function (i, v) {
                    $("#" + i).val(v);

                    if (i == 'wrhs_code' || i == 'trx_desc') {
                        $("#" + i).combogrid('setValue', v);
                    }
                    if (i == 'inv_div') {
                        $("#" + i).combobox('setValue', v);
                    }
                });
                table_grid(ttable, rowData.trx_code, rowData.inv_div)
            } else {
                cmdcondAwal();
                formDisabled();
            }
        });
    }

    function formDisabled() {
        $('#form_validation :input').attr('disabled', true);
        $('#form_validation .easyui-combogrid').combogrid('disable');
        $('#form_validation .easyui-combobox').combobox({disabled: true});
        $('#form_validation .combo-text').removeClass('validatebox-text');
        $('#form_validation .combo-text').removeClass('validatebox-invalid');
        $(".easyui-datebox").datebox('disable');
        cmdcondAwal();
    }
    function condAdd() {
        $('#form_validation input:text').val('');
        $('#form_validation2 .easyui-combogrid').combogrid('setValue', '');
        $('#form_validation2 .easyui-combobox').combobox('setValue', '');
        
        table_grid(ttable, 0, 0)
        condReady();
    }
    function condCancel() {
        cmdcondAwal();
        read_show('');
        $("#form_validation .formError").remove();
        $("#form_validation .easyui-datebox").datebox('disable');
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

        $("#cmdDetail").removeAttr('disabled');
        $('#cmdDetail').linkbutton('enable');
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

        $("#cmdDetail").attr('disabled', true);
        $('#cmdDetail').linkbutton('disable');

    }

    function condEdit() {
        edited = true;
        read_show('');
        cmdcondReady();
        condReady();

        $("#form_validation #sinv_code_copy").attr('disabled', true);
        $("#form_validation #sinv_code_copy").val('Kendaraan Showroom');
    }
    function condDelete() {

            var id = $("#form_validation #id").val();
            var table = $("#form_validation #table").val();
            $.messager.confirm('Warning', 'Do you really want to delete the selected data ?', function (r) {
                if (r) {
                    $('.loader').show();
                    var url = site_url + 'transaction/setting/deleteVglh';
                    $.post(url, {table: table, id: id}, function (data) { 
                        obj = JSON.parse(data);
                        if (obj.success == true) {
                            $("#id").val('');
                            showAlert("Information", obj.message);

                            read_show('');
                        } else
                        {
                            $('.loader').hide();
                            showAlert("Error while deleting", '<font color="red">' + obj.message + '</font>');
                        }
                    });
                }
            });
        
    }

    function condReady() {
        cmdcondReady();
        //$("#form_validation #cust_code").attr('disabled', true);
        $('#form_validation .easyui-combogrid').combogrid('enable');
        $('#form_validation .easyui-combobox').combobox({disabled: false});

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
                    }

                } else
                {
                    updateFailed(obj);
                }
            }
        });
    }
    
    function table_grid(ttable, trx_code, inv_div) {
        var wrhs_code = $("#wrhs_code").combogrid('getValue');
       // alert(site_url + '<?php echo 'builder/datagrid/' . encrypt_decrypt('encrypt', 'set_vgld'); ?>/trx_code/' + trx_code + '/inv_div/' + inv_div + '/wrhs_code/'+ wrhs_code + '/comp_code/<?php echo $comp_code;?>/?grid=true')
        ttable.datagrid({
            method: 'post',
            url: site_url + '<?php echo 'builder/datagrid/' . encrypt_decrypt('encrypt', 'set_vgld'); ?>/trx_code/' + trx_code + '/inv_div/' + inv_div + '/wrhs_code/'+ wrhs_code + '/comp_code/<?php echo $comp_code;?>/?grid=true',
            // title: 'Deskripsi Service',
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
                    {field: 'dc', title: 'D/K', width: 50, height: 20, sortable: true},
                    {field: 'trx_scode', title: 'Type', width: 80, height: 20, sortable: true},
                    {field: 'acc_no', title: 'Account No.', width: 120, height: 20, sortable: true},
                    {field: 'acc_name', title: 'Account Name', width: 250, height: 20, sortable: true},
                    {field: 'prefix', title: '<?php getCaption("Catatan"); ?> (Prefix)', width: 150, height: 20, sortable: true},
                    {field: 'infix', title: '<?php getCaption("Catatan"); ?>  (Infix)', width: 150, height: 20, sortable: true},
                    {field: 'suffix', title: '<?php getCaption("Catatan"); ?> (Suffix)', width: 150, height: 20, sortable: true},
                    {field: 'add_by', title: '<?php getCaption("Ditambahkan Oleh"); ?>', width: 100, height: 20, sortable: true},
                    {field: 'add_date', title: '<?php getCaption("Tgl. Buat"); ?>', width: 100, height: 20, sortable: true, formatter: formatDate}

                ]]
        });
    }

    function cmdDetails() {

        var trx_code = $("#form_validation #trx_code").val();
        var inv_div = $("#form_validation #inv_div").combobox('getValue');

        tableId2();
        read_show2('');

        table_grid(ttable2, trx_code, inv_div);

        $("#DetailWindow").window('open');



    }

    function read_show2(nav) {
        var id = $("#id2").val();
        var trx_code = $("#form_validation #trx_code").val();
        var inv_div = $("#form_validation #inv_div").combobox('getValue');
        var wrhs_code = $("#wrhs_code").combogrid('getValue');
        
       // $('#form_validation2 .easyui-combogrid').combogrid('setValue', '');
        $("#form_validation2 :input").val('');
        
        $.post(site_url + 'crud/read/?inv_div=' + inv_div + '&trx_code=' + trx_code + '&wrhs_code=' + wrhs_code +'&comp_code=<?php echo $comp_code;?>', {table: table2, nav: nav, id: id}, function (json) { //alert(json)

            if (json !== '[]') {

                var rowData = $.parseJSON(json);

                $.each(rowData, function (i, v) {
                    $("#form_validation2 #" + i).val(v);

                    if (i == 'trx_scode') {
                        $("#form_validation2 #" + i).combogrid('setValue', v);
                    }
                    if (i == 'dc') {
                        $("#form_validation2 #" + i).combobox('setValue', v);
                    }
                });
                // price_disc(rowData.qty, '', '');
                $("#id2").val(rowData.id);


            }
            table_grid(ttable2, trx_code, inv_div);
            formDisabled2();
            cmdcondAwal2();

        });
    }

    function saveData2() {
       var trx_code = $("#form_validation #trx_code").val();
       var inv_div = $("#form_validation #inv_div").combobox('getValue');
        var wrhs_code = $("#wrhs_code").combogrid('getValue');
        
        var save_url2 = site_url + 'transaction/setting/save_vgld/' + inv_div + '/'+ trx_code + '/<?php echo $_SESSION['C_USER']; ?>/'+wrhs_code+'/<?php echo $comp_code;?>';
        
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
                    cmdcondAwal2();
                    formDisabled2();

                    $("#id2").val('');
                    read_show2('');
                }
            }
        });
    }

    function deleteDetail() {
        var id = $("#id2").val();

        $.messager.confirm('Delete Confirmation', 'Do you really want to delete this record?', function (r) {
            if (r) {
                var url = site_url + 'transaction/setting/delete_vgld';
                $.post(url, {table: table2, id: id}, function (data) { //alert(data)
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

        //$('#form_validation2 #price_ad').attr('disabled', false);
        $('#form_validation2 input:text').attr('disabled', false);
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
        $('#form_validation2 input:text').val('');
        // $('#form_validation2 .easyui-combogrid').combogrid('setValue', '');
        //$('#form_validation2 .easyui-combobox').combobox('setValue', '');
        
        $('#form_validation2 #table2').val(table2);
        condReady2();
    }
    function condEdit2() {
        showAlert("Message", '<font color="red">Record(s) can\'t be edited. To edit this record, please delete it and add a new record</font>');
    }

    function tableId2() {
        divtableId2.empty().append('<input type="hidden" name="id2"  id="id2"><input type="hidden" name="table2"  id="table2" value="' + table2 + '">');
    }
    /*End Detail*/
    $(document).ready(function () {
        tableId();
        read_show('');
        version('08.17-04');
    });
</script>