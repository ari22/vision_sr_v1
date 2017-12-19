<script>
    $(document).ready(function () {
        version('05.04-17');
        tableId();
        read_show('');
        $('.loader').hide();
    });

    var table = 'usr';
    var divtableId = $("#tableId");
    var save_url = site_url + 'transaction/setting/saveUser';
    var deleteurl = site_url + 'transaction/setting/deleteUser';
    var form = $("#form_validation");


    function checbox(form) {
        $('#' + form + ' input[type="checkbox"]').click(function () {
            if ($(this).prop("checked") == true) {
                $(this).val(1);
            }
            else if ($(this).prop("checked") == false) {
                $(this).val(0);
            }
        });
    }


    $("#form_validation #userrole").combobox({
        onSelect: function () {
            var userrole = $(this).combobox('getValue');
            var form = 'form_validation';

            if (userrole == 'Super User') {
                $('#' + form + ' input:checkbox').prop("checked", true);
                $('#' + form + ' input:checkbox').val(1);
            }
        }
    });
    $("#form_validation #wrhs_axs").combogrid({
        onSelect: function (i,row) {
           $("#wrhs_input").combogrid('setValue', row.wrhs_code)
        }
    });

    $(".checklist").click(function () {
        var name = $(this).attr('name');
        var atr = $('#form_validation #' + name).prop("checked");

        if (atr == true) {
            $('#form_validation #' + name).val(0);
            $('#form_validation #' + name).prop("checked", false);
        }
        else if (atr == false) {
            $('#form_validation #' + name).val(1);
            $('#form_validation #' + name).prop("checked", true);
        }

    });

    function tableId() {
        divtableId.empty().append('<input type="hidden" name="id"  id="id"><input type="hidden" name="table"  id="table" value="' + table + '">');
    }

    function read_show(nav) {
        var id = $("#form_validation #id").val();

        //$.post(site_url + 'transaction/setting/read_user', {table: table, nav: nav, id: id, form:'main'}, function (json) {
        $.post(site_url + 'crud/read', {table: table, nav: nav, id: id}, function (json) {
            $('#form_validation input:text').val('');
            $('#form_validation .easyui-combogrid').combogrid('setValue', '');
            $('#form_validation .easyui-combobox').combobox('setValue', '');
            $("#form_validation input:checkbox").prop("checked", false);
            if (json !== '[]') {

                var rowData = $.parseJSON(json);
                $.each(rowData, function (i, v) {
                    $("#form_validation #" + i).val(v);

                    if (i == 'wrhs_axs' || i == 'wrhs_input') {
                        $("#form_validation #" + i).combogrid('setValue', v);
                    }
                    if (i == 'userrole') {
                        $("#form_validation #" + i).combobox('setValue', v);
                    }

                    if (i == 'lin_dtime' || i == 'lout_dtime') {
                        if (v !== '0000-00-00 00:00:00') {
                            var v_date = formatDateTime(v, '');

                            $("#form_validation #" + i).empty().append(v_date);
                        }
                    }
                    if (i == 'curr_login') {
                        $("#form_validation #" + i).empty().append(v);
                    }

                    if (i == 'vw_prtradd' || i == 'ed_prtradd' || i == 'pr_prtradd' || i == 'dl_prtradd') {
                        if (v == '1') {
                            $("#form_validation #" + i).prop("checked", true);
                        }
                    }
                    if (i == 'vw_lkup_rl' || i == 'ed_lkup_rl' || i == 'pr_lkup_rl' || i == 'dl_lkup_rl') {
                        if (v == '1') {
                            $("#form_validation #" + i).prop("checked", true);
                        }
                    }
                    if (i == 'vw_sinv' || i == 'ed_sinv' || i == 'pr_sinv' || i == 'dl_sinv') {
                        if (v == '1') {
                            $("#form_validation #" + i).prop("checked", true);
                        }
                    }
                    if (i == 'vw_pinv' || i == 'ed_pinv' || i == 'pr_pinv' || i == 'dl_pinv') {
                        if (v == '1') {
                            $("#form_validation #" + i).prop("checked", true);
                        }
                    }
                    if (i == 'vw_usr_axs' || i == 'ed_usr_axs' || i == 'dl_usr_axs') {
                        if (v == '1') {
                            $("#form_validation #" + i).prop("checked", true);
                        }
                    }
                    if (i == 'vw_setform' || i == 'ed_setform' || i == 'pr_setform' || i == 'dl_setform') {
                        if (v == '1') {
                            $("#form_validation #" + i).prop("checked", true);
                        }
                    }

                    if (i == 'ut_settrvn' || i == 'ut_setup' || i == 'vw_setfpno' || i == 'ed_setfpno') {
                        if (v == '1') {
                            $("#form_validation #" + i).prop("checked", true);
                        }
                    }
                    if (i == 'vw_setvgl' || i == 'ed_setvgl' || i == 'pr_setvgl' || i == 'dl_setvgl') {
                        if (v == '1') {
                            $("#form_validation #" + i).prop("checked", true);
                        }
                    }

                    if (i == 'ut_mth_cls' || i == 'ut_backup' || i == 'ut_restore' || i == 'ut_reindex' || i == 'ut_import' || i == 'ut_usr_log') {
                        if (v == '1') {
                            $("#form_validation #" + i).prop("checked", true);
                        }
                    }
                });

                $("#form_validation #username").combogrid('setValue', rowData.username);
            }
        });

        $('.loader').hide();
        cmdcondAwal();
        formDisabled();
    }

    function condSearch() {
        $("#tableSearchUser").datagrid({
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
                    {field: 'username', title: '<?php getCaption("Username"); ?> ', width: 150, height: 20, sortable: true},
                    {field: 'userrole', title: 'User Role', width: 150, height: 20, sortable: true},
                    {field: 'wrhs_axs', title: '<?php getCaption("Warehouse"); ?> ', width: 120, height: 20, sortable: true}
                ]]
        });
        // $("#tableSearch").datagrid('enableFilter');
        $("#tableSearchUser").datagrid('reload');
        $('#windowSearchUser').window('open');

        var option = $("#SearchOption").html();

        $("#actionSearchUser").empty().html(option);
        //$("#SearchOption").show();
    }

    function doSearch() {
        $("#tableSearchUser").datagrid('load', {
            field2: $('#user').val()
        });
    }
    function getSearchselect() {
        var row = $("#tableSearchUser").datagrid('getSelected');

        if (row) {
            $("#form_validation #id").val(row.id);
            $('#windowSearchUser').window('close');
            $("#actionSearchUser").empty()
            $("#SearchOption").hide();
            read_show('');

        }
    }
    function close_search() {
        $('#windowSearchUser').window('close');
        $("#actionSearchUser").empty()
        $("#SearchOption").hide();
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

        $('#pack').removeAttr('disabled');
        $('#clone').removeAttr('disabled');
        $('#veh').removeAttr('disabled');
        $('#veh2').removeAttr('disabled');
        $('#acc').removeAttr('disabled');
        $('#sync').removeAttr('disabled');

        $('#pack').linkbutton('enable');
        $('#clone').linkbutton('enable');
        $('#veh').linkbutton('enable');
        $('#veh2').linkbutton('enable');
        $('#acc').linkbutton('enable');
        $('#sync').linkbutton('enable');

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

        $('#pack').linkbutton('disable');
        $('#clone').linkbutton('disable');
        $('#veh').linkbutton('disable');
        $('#veh2').linkbutton('disable');
        $('#acc').linkbutton('disable');
        $('#sync').linkbutton('disable');

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

    function condAdd() {
        $('#form_validation #id').val('');
        $('#form_validation input:text').val('');
        $("#form_validation input:checkbox").prop("checked", false);
        $('#form_validation .easyui-combogrid').combogrid('setValue', '');
        $('#form_validation .easyui-combobox').combobox('setValue', '');
        condReady();

    }

    function condReady() {
        checbox('form_validation');
        $('#form_validation input:text').attr('disabled', false);
        $('#form_validation input:checkbox').attr('disabled', false);
        $('#form_validation .easyui-combogrid').combogrid('enable');
        $('#form_validation .easyui-combobox').combobox('enable');
        cmdcondReady();
    }
    function condCancel() {
        read_show('');
    }
    function condEdit() {
        cmdcondReady();
        condReady();
        $("#form_validation #username").attr('disabled', true);
    }
    function saveData() {
        var wrhs_input = $("#wrhs_input").combogrid('getValue');
        if (wrhs_input !== 'ALL') {
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
                        $("#id").val('');
                        read_show('');
                        showAlert("Information", obj.message);

                    } else
                    {
                        $('.loader').hide();
                        condReady();
                        showAlert("Error while saving", '<font color="red">' + obj.message + '</font>');
                        $('#cmdSave').linkbutton('enable');
                    }
                }
            });

        } else {
            showAlert("Error while saving", '<font color="red">Default input other than ALL</font>');
            $('#cmdSave').linkbutton('enable');
        }
    }

    function condDelete() {
        var id = $("#form_validation #id").val();
        var table = $("#form_validation #table").val();
        $.messager.confirm('Warning', 'Are you sure delete selected data ?', function (r) {
            if (r) {
                $('.loader').show();

                $.post(deleteurl, {table: table, id: id}, function (data) {
                    obj = JSON.parse(data);
                    if (obj.success == true) {
                        $("#id").val('');
                        showAlert("Information", obj.message);
                        read_show('');
                    } else
                    {
                        $('.loader').hide();
                        showAlert("Error while delete", '<font color="red">' + obj.message + '</font>');
                    }
                });
            }
        });
    }
    function condDelete2(table2, form) {
        var num = checkRoles('dl');

        if (num == '1') {

            var id = $("#form_validation #id").val();
            var table = $("#form_validation #table").val();

            $.messager.confirm('Warning', 'Are you sure delete selected data ?', function (r) {
                if (r) {
                    $('.loader').show();

                    $.post(deleteurl, {table: table, id: id, table2: table2}, function (data) {
                        obj = JSON.parse(data);
                        if (obj.success == true) {
                            showAlert("Information", obj.message);
                            if (form == 'form_validation2') {
                                vehone();
                            }
                            if (form == 'form_validation3') {
                                vehtwo();
                            }
                            if (form == 'form_validation4') {
                                accWind();
                            }
                            $('.loader').hide();
                        } else
                        {
                            $('.loader').hide();
                            showAlert("Error while delete", '<font color="red">' + obj.message + '</font>');
                        }
                    });
                }
            });

            return false;
        }
        errorAccess();
    }
    function formDisabled2(form) {
        $('#' + form + ' :input').attr('disabled', true);
        cmdcondAwal2(form);
    }
    function cmdcondAwal2(form) {
        $('#' + form + ' .cmdSave').attr('disabled', true);
        $('#' + form + ' .cmdCancel').attr('disabled', true);
        $('#' + form + ' .cmdEdit').removeAttr('disabled');
        $('#' + form + ' .cmdClose').removeAttr('disabled');
        $('#' + form + ' .cmdDelete').removeAttr('disabled');

        $('#' + form + ' .cmdSave').linkbutton('disable');
        $('#' + form + ' .cmdCancel').linkbutton('disable');
        $('#' + form + ' .cmdEdit').linkbutton('enable');
        $('#' + form + ' .cmdClose').linkbutton('enable');
        $('#' + form + ' .cmdDelete').linkbutton('enable');
    }

    function cmdcondReady2(form) {

        $('#' + form + ' .cmdSave').removeAttr('disabled');
        $('#' + form + ' .cmdCancel').removeAttr('disabled');
        $('#' + form + ' .cmdClose').attr('disabled', true);
        $('#' + form + ' .cmdEdit').attr('disabled', true);

        $('#' + form + ' .cmdClose').attr('disabled', true);
        $('#' + form + ' .cmdEdit').attr('disabled', true);
        $('#' + form + ' .cmdDelete').attr('disabled', true);

        $('#' + form + ' .cmdSave').linkbutton('enable');
        $('#' + form + ' .cmdCancel').linkbutton('enable');
        $('#' + form + ' .cmdClose').linkbutton('disable');
        $('#' + form + ' .cmdEdit').linkbutton('disable');
        $('#' + form + ' .cmdDelete').linkbutton('disable');

    }

    function condEdit2(form) {
        cmdcondReady2(form);
        condReady2(form);
    }

    function condCancel2(form) {
        if (form == 'form_validation2') {
            vehone();
        }
        if (form == 'form_validation3') {
            vehtwo();
        }
        if (form == 'form_validation4') {
            accWind();
        }

    }

    function condReady2(form) {
        var idform = $('#' + form + ' .id').val();
        var userrole = $("#form_validation #userrole").val();

        checbox(form);

        if (idform == '') {
            if (userrole == 'Super User') {
                $('#' + form + ' input:checkbox').prop("checked", true);
                $('#' + form + ' input:checkbox').val(1);
            }
        }

        $('#' + form + ' input:checkbox').attr('disabled', false);
        $('#' + form + ' input:radio').attr('disabled', false);
        cmdcondReady2(form);

        $('#' + form + ' #checkAll').click(function () {

            var check = $('#' + form + ' #checkAll').prop("checked");

            if (check == true) {
                $('#' + form + ' input:checkbox').prop("checked", true);
                $('#' + form + ' input:checkbox').val(1);
            }
            else {
                $('#' + form + ' input:checkbox').prop("checked", false);
                $('#' + form + ' input:checkbox').val(0);
            }

        });
    }

    function saveData2(form) {
        var saveAccess = site_url + 'transaction/setting/saveAccess/';
        // $('.loader').show();
        $('#' + form + ' :input').attr('disabled', false);

        $('#' + form).form('submit', {
            url: saveAccess,
            onSubmit: function () {
                return $(this).form('validate');
            },
            success: function (data) {

                var obj = JSON.parse(data);
                if (obj.success == true) {
                    if (form == 'form_validation2') {
                        vehone();
                    }
                    if (form == 'form_validation3') {
                        vehtwo();
                    }
                    if (form == 'form_validation4') {
                        accWind();
                    }

                    showAlert("Information", obj.message);

                } else
                {
                    $('.loader').hide();
                    condReady2(form);
                    showAlert("Error while saving", '<font color="red">' + obj.message + '</font>');
                }
            }
        });
    }

    function openClone() {
        $('#formClone input:text').val('');
        $('#formClone .easyui-combobox').combobox('setValue', '');
        $('#cloneWindow').window('open');
        $('#formClone input:text').attr('disabled', false);
        $('#formClone input:password').attr('disabled', false);
        $('#formClone .easyui-combogrid').combogrid('enable');
    }

    function saveClone() {
        $('.loader').show();
        $('#formClone :input').attr('disabled', false);

        $('#formClone').form('submit', {
            url: site_url + 'transaction/setting/saveClone',
            onSubmit: function () {
                return $(this).form('validate');
            },
            success: function (data) {
                var obj = JSON.parse(data);
                if (obj.success == true) {
                    $("#id").val('');
                    read_show('');
                    showAlert("Information", obj.message);
                    $('#cloneWindow').window('close');
                } else
                {
                    $('.loader').hide();
                    condReady();
                    showAlert("Error while saving", '<font color="red">' + obj.message + '</font>');
                }
            }
        });
    }

    function deletedisable(form) {

        $('#' + form + ' .cmdDelete').attr('disabled', true);
        $('#' + form + ' .cmdDelete').linkbutton('disable');

    }

</script>