<script>
    var table = 'veh_slh';
    var form = $('#form_validation');
    var save_url = site_url + 'transaction/credit_bpkb/saveAppCredit';

    var divtableId = $("#tableId");
    var salpaytype = '';

    $("#form_validation #inv_type").val('<?php echo $remark; ?>');

    $('#lease_name').combogrid({
        onSelect: function (index, row) {
            $("#lease_code").val(row.lease_code);
            $("#lease_addr").val(row.oaddr);
            $("#lease_city").combogrid('setValue', row.ocity);
            $("#lease_zipc").val(row.ozipcode);
        }
    });
    $('#insr_name').combogrid({
        onSelect: function (index, row) {
            $("#insr_code").val(row.insr_code);
        }
    });

    function tableId() {
        divtableId.empty().append('<input type="hidden" name="id"  id="id"><input type="hidden" name="table"  id="table" value="' + table + '">');
    }

    function read_show(nav) {
        var id = $("#form_validation #id").val();

        $.post(site_url + 'crud/read', {table: table, nav: nav, id: id}, function (json) {
            //$.post(site_url + 'transaction/credit_bpkb/read_slh/VSL', {table: table, nav: nav, id: id}, function (json) { //alert(json)
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


                    if (i == 'wrhs_code' || i == 'cust_name' || i == 'lease_name' || i == 'lease_city' || i == 'cust_darea' || i == 'cust_dcity' || i == 'srep_name' || i == 'cust_rarea' || i == 'cust_rcity' || i == 'cust_area' || i == 'cust_city') {
                        $("#form_validation #" + i).combogrid('setValue', v);
                    }
                    if (i == 'crdinsname') {
                        $("#form_validation #insr_name").combogrid('setValue', v);
                    }
                    if (i == 'crdinscode') {
                        $("#form_validation #insr_code").val(v);
                    }

                    if (i == 'cls_date' || i == 'sal_date' || i == 'pick_date' || i == 'so_date' || i == 'due_date' || i == 'crd_cntrdt' || i == 'stnk_bdate' || i == 'stnk_edate') {
                        if (v !== '0000-00-00') {
                            var v_date = dateSplit(v);
                            $("#form_validation #" + i).datebox('setValue', v_date);
                        }

                    }


                    if (i == 'crd_amount' || i == 'crd_term' || i == 'crd_irate' || i == 'crd_mthpay' || i == 'crd_dppo' || i == 'crdinscomm' || i == 'crdinsdisc' || i == 'due_day') {
                        $("#form_validation #" + i).numberbox('setValue', v);
                    }

                    if (i == 'cust_id' || i == 'cust_kk' || i == 'cust_bnkac' || i == 'cust_siup') {
                        if (v !== null) {
                            $("#form_validation #" + i).prop("checked", true);
                        }
                    }
                });

                salpaytype = rowData.salpaytype;
                cmdcondAwal();
                formDisabled();

                $("#cmdClose").removeAttr('disabled');
                if (rowData.cls_date == null || rowData.cls_date == '0000-00-00' || rowData.cls_date == '0000-00-00 00:00:00') {
                    $("#cmdDetail").removeAttr('disabled');
                    $('#cmdDetail').linkbutton('enable');
                    $("#closeOn").empty().append('<button type="button" id="cmdClose" title="<?php getCaption("Close"); ?>" class="easyui-linkbutton btn-cls"  data-options="iconCls:\'icon-close\'" onclick="rolesClose()">Close</button>');
                    $("#print").linkbutton('disable');
                    $("#screen").linkbutton('disable');
                    $("#download").linkbutton('disable');

                    $('#cmdClose').linkbutton();

                } else {
                    $("#cmdDetail").attr('disabled', true);
                    $('#cmdDetail').linkbutton('disable');
                    $("#closeOn").empty().append('<button type="button" id="cmdUnClose" title="<?php getCaption("unClose"); ?>" class="easyui-linkbutton btn-cls" data-options="iconCls:\'icon-unclose\'"  onclick="rolesUnclose()">Unclose</button>');

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
                    $("#cmdAdd").attr('disabled', true);
                    $("#cmdDelete").attr('disabled', true);
                    $("#cmdAdd").linkbutton('disable');
                    $("#cmdDelete").linkbutton('disable');
                    $("#setDiskon").linkbutton('disable');
                }

                $("#cmdDelete").linkbutton('disable');
                $("#cmdAdd").linkbutton('disable');
                $("#form_validation #cmdClose").linkbutton('disable');
                $("#form_validation #cmdUnClose").linkbutton('disable');
                $(".loader").hide();
            } else {
                cmdcondAwal();
                cmdEmptyData();
            }

            $(".loader").hide();

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
    }

    function condReady() {
        scrlTop();
        $("#form_validation #note,#lease_addr,#lease_city,#lease_zipc,#lcp1_name,#lcp1_title,#crd_note, #crd_via,#crd_apprby,#crd_cntrno,#cust_dname,#cust_daddr,#cust_dzipc,#cust_dphon").attr('disabled', false);
        $("#form_validation #lease_name, #lease_city, #insr_name, #cust_darea, #cust_dcity").combogrid('enable');
        $("#form_validation #crd_amount,#crd_term,#crd_irate,#crd_mthpay,#crd_dppo,#crdinscomm,#crdinsdisc").numberbox("enable");
        $("#form_validation #crd_cntrdt").datebox("enable");
        $("#form_validation #cust_id,#cust_kk,#cust_bnkac,#cust_siup").attr('disabled', false);
        $("#form_validation #cust_id,#cust_kk,#cust_bnkac,#cust_siup").val('T');

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

    /*function condSearch(){
     table2 = 'credit';
     condSearch2();
     }*/
    function doSearch() {
        $("#tableSearch").datagrid('load', {
            field1: $('#sal_inv_no2').val(),
            field2: $('#sal_date2').datebox('getValue')
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

    function copyQQData(action) {
        var id = $("#id").val();

        $.post(site_url + 'crud/read', {table: table, nav: '', id: id}, function (data) {
            var row = $.parseJSON(data);

            if (action == 'cust') {
                $.messager.confirm('Copy From Customer', 'Copy data from customer\'s  name & address?', function (r) {
                    if (r) {
                        clearQQ();

                        $("#cust_dname").val(row.cust_name);
                        $("#cust_daddr").val(row.cust_addr);
                        $("#cust_dzipc").val(row.cust_zipc);
                        $("#cust_dphon").val(row.cust_phone);

                        $("#cust_darea").combogrid('setValue', row.cust_area);
                        $("#cust_dcity").combogrid('setValue', row.cust_city);
                    }
                });

            }
            if (action == 'stnk') {
                $.messager.confirm('Copy From STNK', 'Copy data from name and address in STNK?', function (r) {
                    if (r) {
                        clearQQ();

                        $("#cust_dname").val(row.cust_rname);
                        $("#cust_daddr").val(row.cust_raddr);
                        $("#cust_dzipc").val(row.cust_rzipc);
                        $("#cust_dphon").val(row.cust_rphon);

                        $("#cust_darea").combogrid('setValue', row.cust_rarea);
                        $("#cust_dcity").combogrid('setValue', row.cust_rcity);
                    }
                });


            }



        });
    }

    function clearQQ() {
        $("#form_validation #cust_dname,#cust_daddr,#cust_dzipc,#cust_dphon").val('');
        $("#form_validation #cust_darea,#cust_dcity").combogrid('setValue', '');
    }

    function saveData() {

        if (salpaytype == '2') {
            var lease_code = $("#form_validation #lease_code").val();

            if (lease_code == '') {
                $.messager.confirm('Check Transaction Type : CASH/CREDIT', 'Sorry, the transaction marked this CREDIT there is no LEASING. Continue ?', function (r) {
                    if (r) {
                        saveNext();
                    }
                });
            } else {
                saveNext();
            }
        } else {
            saveNext();
        }

    }
    function saveNext() {
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
                }
                scrlTop();
            }
        });
    }

    function showPrint() {
        $('#form_validation3 :input').attr('disabled', false);
        $("#form_validation3 input:radio").prop("checked", false);
        $("#form_validation3 #type_1").prop("checked", true);


        $("#typeOne").show();
        $("#typeTwo").hide();
        $("#nbr").numberbox('setValue', 3);
        $("#bulan").val('bulan');

        $('#windowPrint').window('open');
        $(".checkbox").click(function () {
            var name = $(this).attr('name');
            var atr = $('#form_validation3 #' + name).attr('disabled');
            var val = $('#form_validation3 #' + name).val();

            if (val == 1) {
                $("#typeOne").show();
                $("#typeTwo").hide();
            }
            else if (val == 2) {
                $("#typeOne").hide();
                $("#typeTwo").show();

                $("#rek_name").val('<?php echo $comp['comp_name']; ?>');
            }
            else if (val == 3) {
                $("#typeOne").hide();
                $("#typeTwo").show();
                $("#rek_name").val('<?php echo $comp['comp_name']; ?>');
            } else {
                $("#typeOne").hide();
                $("#typeTwo").hide();
            }

            if (atr !== 'disabled') {
                $('#form_validation3 #' + name).prop("checked", true);
            }
        });


        $("#form_validation3 #screen").linkbutton('enable');
        $("#form_validation3 #print").linkbutton('enable');
        $("#form_validation3 #download").linkbutton('enable');
    }


    function print_sc(key) {
        var form = $("#form_validation3").serialize();

        var ids = $("#form_validation #id").val();
        var url = site_url + 'transaction/credit_bpkb/outputpdf/<?php echo encrypt_decrypt('encrypt', 'veh_slh'); ?>/' + ids + '/<?php echo $_SESSION['C_USER']; ?>/' + key + '/<?php echo encrypt_decrypt('encrypt', 'sal_inv_no'); ?>/<?php echo encrypt_decrypt('encrypt', 'VSL'); ?>/' + form;

        if (key == 'print') {
            $("#screenWindow").empty().append('<iframe frameborder="0"  src="' + url + '" style="width:100%;height:auto;min-height: 500px;padding:0px;"></iframe>');
        }

        if (key == 'download') {

            $("#screenWindow").empty().append('<iframe frameborder="0"  src="' + url + '" style="width:100%;height:auto;min-height: 500px;padding:0px;"></iframe>');

        }
        if (key == 'screen') {
            window.open(url);
        }
        if (key == 'show') {
            showPrint();
        }
    }

    $(document).ready(function () {
        tableId();
        dateTop();
        read_show('')
        version('01.04-17');
    });
</script>