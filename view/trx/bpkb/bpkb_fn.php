<script>
    var table = 'veh_doc';
    var form = $('#form_validation');
    var save_url = site_url + 'transaction/credit_bpkb/saveAppBPKB';
    var unclose_url = site_url + 'transaction/credit_bpkb/uncloseBPKB/<?php echo $_SESSION['C_USER']; ?>';
    var close_url = site_url + 'transaction/credit_bpkb/closeBPKB/<?php echo $_SESSION['C_USER']; ?>';

    var divtableId = $("#tableId");

    $("#form_validation #inv_type").val('<?php echo $remark; ?>');

    /* $('#lease_name').combogrid({
     onSelect: function (index, row) {
     $("#lease_code").val(row.lease_code);
     $("#lease_addr").val(row.oaddr);
     $("#lease_city").combogrid('setValue', row.ocity);
     $("#lease_zipc").val(row.ozipcode);
     }
     });
     
     */

    $('#chassis').combogrid({
        onSelect: function (index, rowData) {

            $('.cust_sex_' + rowData.cust_sex).prop("checked", true);
            $('.cust_type_' + rowData.cust_type).prop("checked", true);
            $('#form_validation .cust_rsex_' + rowData.cust_rsex).prop("checked", true);
            $('#form_validation .srep_sex_' + rowData.srep_sex).prop("checked", true);
            $(".easyui-datebox").datebox('setValue', '');
            $.each(rowData, function (i, v) {
                if (i !== 'id') {

                    if (i !== 'doc_inv_no') {
                        $("#form_validation #" + i).val(v);
                    }
                    if (i == 'chassis') {
                        $("#form_validation #" + i + "1").val(v);
                    }
                    if (i == 'cust_name' || i == 'srep_name' || i == 'wrhs_code' || i == 'cust_rarea' || i == 'cust_rcity') {
                        $("#form_validation #" + i).combogrid('setValue', v);
                    }

                    if (i == 'sal_date' || i == 'pick_date' || i == 'so_date' || i == 'due_date' || i == 'stnk_bdate' || i == 'stnk_edate') {
                        if (v !== '0000-00-00') {
                            var v_date = dateSplit(v);
                            $("#form_validation #" + i).datebox('setValue', v_date);
                        }
                    }
                }


            });

            $("#form_validation #inv_type").val('<?php echo $remark; ?>');
        }
    });
    $('#agent_name').combogrid({
        onSelect: function (index, row) {
            $("#agent_code").val(row.agent_code);
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
            $("#form_validation input:radio").prop("checked", false);

            if (json !== '[]') {

                var rowData = $.parseJSON(json);

                $('.cust_sex_' + rowData.cust_sex).prop("checked", true);
                $('.cust_type_' + rowData.cust_type).prop("checked", true);
                $('#form_validation .cust_rsex_' + rowData.cust_rsex).prop("checked", true);
                $('#form_validation .srep_sex_' + rowData.srep_sex).prop("checked", true);

                $.each(rowData, function (i, v) {
                    $("#form_validation #" + i).val(v);

                    if (i == 'chassis' || i == 'wrhs_code' || i == 'cust_rarea' || i == 'cust_rcity' || i == 'agent_name' || i == 'cust_name' || i == 'srep_name') {
                        $("#form_validation #" + i).combogrid('setValue', v);
                    }
                    if (i == 'cls_date' || i == 'sal_date' || i == 'pick_date' || i == 'so_date' || i == 'due_date' || i == 'veh_inv_dt' || i == 'veh_invrdt' || i == 'forma_date' || i == 'rapp_date' || i == 'rapp_bdate' || i == 'stnk_bdate' || i == 'stnk_edate' || i == 'stnk_rdate' || i == 'stnk_sdate' || i == 'vds_date' || i == 'bpkb_date' || i == 'bpkb_rdate' || i == 'bpkb_sdate' || i == 'vdb_date') {
                        if (v !== '0000-00-00') {
                            var v_date = dateSplit(v);
                            $("#form_validation #" + i).datebox('setValue', v_date);
                        }
                    }
                });


                $("#form_validation #chassis1").val(rowData.chassis);
                $("#cust_rname2").val(rowData.cust_rname);
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


                    $("#cmdEdit").attr('disabled', true);
                    $("#cmdDelete").attr('disabled', true);
                    $("#cmdEdit").linkbutton('disable');
                    $("#cmdDelete").linkbutton('disable');

                    $("#cmdGetSPK").linkbutton('disable');
                    $("#cmdGetASales").linkbutton('disable');
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

    function formDisabled() {
        $('#form_validation :input').attr('disabled', true);
        $('#form_validation .easyui-combogrid').combogrid('disable');
        $('#form_validation .easyui-combobox').combobox({disabled: true});
        $('#form_validation .combo-text').removeClass('validatebox-text');
        $('#form_validation .combo-text').removeClass('validatebox-invalid');
        $(".easyui-datebox").datebox('disable');
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

        $(".btn-cls").removeAttr('disabled');
        $('.btn-cls').linkbutton('enable');

        $('.copyQQbtn').linkbutton('disable');

        $(".print").removeAttr('disabled');
        $(".print").linkbutton('enable');

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

        $("#form_validation #cmdOptional").linkbutton('disable');
        $("#form_validation #cmdClose").linkbutton('disable');
        $("#form_validation #cmdUnClose").linkbutton('disable');
        $("#form_validation #printSJ").linkbutton('disable');
        $("#form_validation #print").linkbutton('disable');
        $("#cmdDropPick").attr('disabled', true);
        $("#cmdPick").attr('disabled', true);

        $("#cmdDropPick").linkbutton('disable');
        $("#cmdPick").linkbutton('disable');
        $("#screen").linkbutton('disable');

        $('.copyQQbtn').linkbutton('enable');
        $(".print").linkbutton('disable');
    }

    function condReady() {

        scrlTop();
        /*  $("#form_validation #note,#lease_addr,#lease_city,#lease_zipc,#lcp1_name,#lcp1_title,#crd_note, #crd_via,#crd_apprby,#crd_cntrno,#cust_dname,#cust_daddr,#cust_dzipc,#cust_dphon").attr('disabled', false);
         $("#form_validation #lease_name, #lease_city, #insr_name, #cust_darea, #cust_dcity").combogrid('enable');
         $("#form_validation #crd_amount,#crd_term,#crd_irate,#crd_mthpay,#crd_dppo,#crdinscomm,#crdinsdisc").numberbox("enable");
         $("#form_validation #crd_cntrdt").datebox("enable");
         $("#form_validation #cust_id,#cust_kk,#cust_bnkac,#cust_siup").attr('disabled', false);
         $("#form_validation #cust_id,#cust_kk,#cust_bnkac,#cust_siup").val('T');
         */
        checkboxClick();
        $('#FakturKendaraan input:text').attr('disabled', false);
        $("#FakturKendaraan .easyui-datebox").datebox('enable');
        $('#STNKTD input:text').attr('disabled', false);
        $("#STNKTD .easyui-datebox").datebox('enable');
        $('#STNKTD .easyui-combogrid').combogrid('enable');
        $("#cust_raddr, .cust_rsex").attr('disabled', false);
        $('#BKPNdiv input:text').attr('disabled', false);
        $("#BKPNdiv .easyui-datebox").datebox('enable');
        $("#cust_rname2").attr('disabled', true);

        $('#form_validation #agent_code, #vds_inv_no, #vdb_inv_no').attr('disabled', true);
        $("#form_validation #vds_date, #vdb_date").datebox('disable');
        $("#agent_name").combogrid('enable');
        $('#form_validation #note').attr('disabled', false);



        // chassisCmb();
        cmdcondReady();

        $('#chassis').combogrid('enable');
    }

    function condDelete() {
        var id = $("#form_validation #id").val();
        var table = $("#form_validation #table").val();
        $.messager.confirm('Warning', 'Do you really want to delete this record?', function (r) {
            if (r) {
                $('.loader').show();
                var url = site_url + 'transaction/credit_bpkb/deleteDoc';
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
                    scrlTop();
                });
            } else {
                $('#cmdDelete').linkbutton('enable');
            }
        });
    }
    function condAdd() {
        // $(".easyui-datebox").datebox('enable');
        $('.easyui-numberbox').numberbox('setValue', '');
        $('#form_validation #id').val('');
        $('#form_validation input:text').val('');
        $('#form_validation textarea').val('');
        $("#form_validation input:radio").prop("checked", false);
        $("#form_validation #table").val(table);
        $('#form_validation .easyui-combogrid').combogrid('setValue', '');
        $(".easyui-datebox").datebox('setValue', '');

        $.post(site_url + 'transaction/optional/get_number/VDM', function (num) {
            $("#form_validation #doc_inv_no").val(num);
        });
        condReady();
        $("#form_validation #inv_type").val('<?php echo $remark; ?>');
        //poNew(0)

    }

    function condEdit() {
        cmdcondReady();
        condReady();

    }


    function condCancel() {
        cmdcondAwal();
        read_show('');
        $("#form_validation .formError").remove();
        $("#form_validation .easyui-datebox").datebox('disable');
    }

    function doSearch() {
        $("#tableSearch").datagrid('load', {
            field1: $('#doc_inv_no2').val(),
            field3: $('#doc_date2').datebox('getValue')
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




    function closeBtn() {
        $.messager.confirm('Closing invoice', 'Close this invoice?', function (r) {
            if (r) {
                $('.loader').show();
                $('#form_validation :input').attr('disabled', false);
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
                            read_show('');
                            showAlert("Error while closing", '<font color="red">' + obj.message + '</font>');
                            $('.loader').hide();
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
                            read_show('');
                            showAlert("Error while saving", '<font color="red">' + obj.message + '</font>');
                            $('.loader').hide();
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
                    read_show('');
                    showAlert("Information", obj.message);

                } else
                {
                    updateFailed(obj);
                    read_show('');
                }
                scrlTop();
            }
        });
    }

    function status_spk() {
        var form = $("#form_validation3").serialize();

        var ids = $("#form_validation #id").val();
        var url = site_url + 'transaction/credit_bpkb/outputpdf/<?php echo encrypt_decrypt('encrypt', 'veh_doc'); ?>/' + ids + '/<?php echo $_SESSION['C_USER']; ?>/screen/<?php echo encrypt_decrypt('encrypt', 'doc_inv_no'); ?>/<?php echo encrypt_decrypt('encrypt', 'VDM'); ?>/' + form;
        window.open(url);
    }
    function printbpkbstnk(opt, key) {
        //$("#printBPKBSTNK").window('open');

        $("#doc").val(opt);

        rolesPrintScreen(key);
    }

    function print_sc(key) {

        if (key == 'print') {
            var doc = $("#doc").val();
            var ids = $("#form_validation #id").val();
            var url = site_url + 'transaction/credit_bpkb/outputpdf/<?php echo encrypt_decrypt('encrypt', 'veh_doc'); ?>/' + ids + '/<?php echo $_SESSION['C_USER']; ?>/print/<?php echo encrypt_decrypt('encrypt', 'doc_inv_no'); ?>/<?php echo encrypt_decrypt('encrypt', 'VDM'); ?>/' + doc;

            $("#screenWindow").empty().append('<iframe frameborder="0"  src="' + url + '" style="width:100%;height:auto;min-height: 500px;padding:0px;"></iframe>');
        }

        if (key == 'screen') {
            var doc = $("#doc").val();
            var ids = $("#form_validation #id").val();
            var url = site_url + 'transaction/credit_bpkb/outputpdf/<?php echo encrypt_decrypt('encrypt', 'veh_doc'); ?>/' + ids + '/<?php echo $_SESSION['C_USER']; ?>/screen/<?php echo encrypt_decrypt('encrypt', 'doc_inv_no'); ?>/<?php echo encrypt_decrypt('encrypt', 'VDM'); ?>/' + doc;
            window.open(url);
        }

        if (key == 'download') {
            var doc = $("#doc").val();
            var ids = $("#form_validation #id").val();
            var url = site_url + 'transaction/credit_bpkb/outputpdf/<?php echo encrypt_decrypt('encrypt', 'veh_doc'); ?>/' + ids + '/<?php echo $_SESSION['C_USER']; ?>/download/<?php echo encrypt_decrypt('encrypt', 'doc_inv_no'); ?>/<?php echo encrypt_decrypt('encrypt', 'VDM'); ?>';

            $("#screenWindow").empty().append('<iframe frameborder="0"  src="' + url + '" style="width:100%;height:auto;min-height: 500px;padding:0px;"></iframe>');

        }

        if (key == 'status') {
            status_spk();
        }

    }

    $(document).ready(function () {
        checkRunMonthYear('VDM');
        tableId();
        read_show('');
        version('01.04-17');
    });
</script>