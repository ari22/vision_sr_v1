<script>
    $(document).ready(function () {
        tableId();
        read_show('')
        $('.loader').hide();
    });

    var table = 'usr';
    var divtableId = $("#tableId");
    var save_url = site_url + 'transaction/setting/saveUser';
    var deleteurl = site_url + 'transaction/setting/deleteUser';
    var form = $("#form_validation");

    $('#form_validation input[type="checkbox"]').click(function () {
        if ($(this).prop("checked") == true) {
            $(this).val(1);
        }
        else if ($(this).prop("checked") == false) {
            $(this).val(0);
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

        $.post(site_url + 'transaction/setting/read_user', {table: table, nav: nav, id: id, form:'main'}, function (json) {
           
            $('#form_validation input:text').val('');
            $('#form_validation .easyui-combogrid').combogrid('setValue', '');
            $('#form_validation .easyui-combobox').combobox('setValue', '');
            $("#form_validation input:checkbox").prop("checked", false);
            if (json !== '[]') {

                var rowData = $.parseJSON(json);
                $.each(rowData, function (i, v) {
                    $("#" + i).val(v);

                    if (i == 'wrhs_axs' || i == 'wrhs_input') {
                        $("#" + i).combogrid('setValue', v);
                    }
                    if (i == 'userrole') {
                        $("#" + i).combobox('setValue', v);
                    }

                    if (i == 'lin_dtime' || i == 'lout_dtime') {
                        if (v !== '0000-00-00 00:00:00') {
                            $("#" + i).empty().append(v);
                        }
                    }
                    if (i == 'curr_login') {
                        $("#" + i).empty().append(v);
                    }

                    if (i == 'vw_prtradd' || i == 'ed_prtradd' || i == 'pr_prtradd' || i == 'dl_prtradd') {
                        if (v == '1' ) {
                            $("#" + i).prop("checked", true);
                        }
                    }
                    if (i == 'vw_lkup_rl' || i == 'ed_lkup_rl' || i == 'pr_lkup_rl' || i == 'dl_lkup_rl') {
                        if (v == '1') {
                            $("#" + i).prop("checked", true);
                        }
                    }
                    if (i == 'vw_sinv' || i == 'ed_sinv' || i == 'pr_sinv' || i == 'dl_sinv') {
                        if (v == '1') {
                            $("#" + i).prop("checked", true);
                        }
                    }
                    if (i == 'vw_pinv' || i == 'ed_pinv' || i == 'pr_pinv' || i == 'dl_pinv') {
                        if (v == '1') {
                            $("#" + i).prop("checked", true);
                        }
                    }
                    if (i == 'vw_usr_axs' || i == 'ed_usr_axs' || i == 'dl_usr_axs') {
                        if (v == '1') {
                            $("#" + i).prop("checked", true);
                        }
                    }
                    if (i == 'vw_setform' || i == 'ed_setform' || i == 'pr_setform' || i == 'dl_setform') {
                        if (v == '1') {
                            $("#" + i).prop("checked", true);
                        }
                    }

                    if (i == 'ut_settrvn' || i == 'ut_setup' || i == 'vw_setfpno' || i == 'ed_setfpno') {
                        if (v == '1') {
                            $("#" + i).prop("checked", true);
                        }
                    }
                    if (i == 'vw_setvgl' || i == 'ed_setvgl' || i == 'pr_setvgl' || i == 'dl_setvgl') {
                        if (v == '1') {
                            $("#" + i).prop("checked", true);
                        }
                    }

                    if (i == 'ut_mth_cls' || i == 'ut_backup' || i == 'ut_restore' || i == 'ut_reindex' || i == 'ut_import' || i == 'ut_usr_log') {
                        if (v == '1') {
                            $("#" + i).prop("checked", true);
                        }
                    }
                });
            }
        });

        $('.loader').hide();
        cmdcondAwal();
        formDisabled();
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
    }
    function saveData() {
        // $('.loader').show();
        $('#form_validation :input').attr('disabled', false);

        form.form('submit', {
            url: save_url,
            onSubmit: function () {
                return $(this).form('validate');
            },
            success: function (data) {
                
                var obj = JSON.parse(data);
                if (obj.success == true) {
                    read_show('');
                    showAlert("Information", obj.message);

                } else
                {
                    $('.loader').hide();
                    condReady();
                    showAlert("Error while saving", '<font color="red">' + obj.message + '</font>');
                }
            }
        });
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
</script>