<script>

    $(document).ready(function () {
        checkRunMonthYear('VSL');
        tableId();
        dateTop();
        read_show('');
        // $('.loader').hide();
        version('03.17-31');
    });

    var edited = false;
    var table = 'veh_slh';
    var form = $('#form_validation');
    var save_url = site_url + 'transaction/vehicle/saveVehicleSale';
    var unclose_url = site_url + 'transaction/vehicle/uncloseVehicleSale/<?php echo $session['C_USER']; ?>';
    var close_url = site_url + 'transaction/vehicle/closeVehicleSale/<?php echo $session['C_USER']; ?>';

    var divtableId = $("#tableId");
    var ttable = $('#dt_jasa');

    var table2 = 'veh_sld';
    var so_no = $("#form_validation #so_no").val();
    var sal_inv_no = $("#form_validation #sal_inv_no").val();
    var ttables = $('#dt_jasa2');
    var divtableId2 = $("#tableId2");

    var comp_ppn = parseInt('<?php echo $comp['ppn']; ?>');

    $("#srep_name").combogrid({
        onSelect: function (index, row) {
            $("#srep_code").val(row.srep_code);
            $("#srep_lev").val(row.srep_lev);
            $("#sspv_lev").val(row.sspv_lev);
            $("#sspv_code").val(row.sspv_code);
            $("#sspv_name").val(row.sspv_name);
            $('#form_validation .srep_sex_' + row.sex).prop("checked", true);
        }
    });

    $('#cust_name').combogrid({
        onSelect: function (index, row) {

            if (row.postaddr == 1) {
                $("#cust_addr").val(row.oaddr);
                $("#cust_area").combogrid('setValue',row.oarea);
                $("#cust_city").combogrid('setValue',row.ocity);
                $("#cust_cntry").val(row.ocountry);
                $("#cust_zipc").val(row.ozipcode);
                $("#cust_phone").val(row.ophone);
                $("#cust_hp").val(row.ohp);
                $("#cust_fax").val(row.ofax);

            }
            else if (row.postaddr == 2) {
                $("#cust_addr").val(row.haddr);
                $("#cust_area").combogrid('setValue',row.harea);
                $("#cust_city").combogrid('setValue',row.hcity);
                $("#cust_cntry").val(row.hcountry);
                $("#cust_zipc").val(row.hzipcode);
                $("#cust_phone").val(row.hphone);
                $("#cust_hp").val(row.hp);
                $("#cust_fax").val(row.hfax);

            }

            $("#cust_code").val(row.cust_code);
            $("#cust_npwp").val(row.onpwp);
            $("#cust_nppkp").val(row.opkp);

            $('#cust_type').prop("checked", false);
            $('#cust_sex').prop("checked", false);

            $('.cust_type_' + row.cust_type).prop("checked", true);
            $('.cust_sex_' + row.sex).prop("checked", true);
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
            //$("#form_validation input:radio").prop("checked", false);
            $("#form_validation #salpaytype").prop("checked", false);
            $(".easyui-datebox").datebox('setValue', '');
            $('#form_validation .easyui-numberbox').numberbox('setValue', '');

            if (json !== '[]') {

                var rowData = $.parseJSON(json);

                $('#form_validation .cust_sex_' + rowData.cust_sex).prop("checked", true);
                $('#form_validation .cust_type_' + rowData.cust_type).prop("checked", true);
                $('#form_validation .cust_rsex_' + rowData.cust_rsex).prop("checked", true);
                $('#form_validation .srep_sex_' + rowData.srep_sex).prop("checked", true);
                $('#form_validation .salpaytype_' + rowData.salpaytype).prop("checked", true);
                $('#form_validation .srep_sex_' + rowData.srep_sex).prop("checked", true);
                $('#form_validation .kwit_data_' + rowData.kwit_data).prop("checked", true);
                $('#form_validation .sal_inctyp_' + rowData.sal_inctyp).prop("checked", true);
                $('#form_validation .fp_data_' + rowData.fp_data).prop("checked", true);

                $("#form_validation #so_no2").val(rowData.so_no);

                var total = parseInt(rowData.srv_bt) + parseInt(rowData.srv_vat);
                $.each(rowData, function (i, v) {
                    $("#" + i).val(v);

                    if (i == 'wrhs_code' || i == 'loc_code' || i == 'sosrc_name' || i == 'cust_name' || i == 'srep_name' || i == 'lease_name' || i == 'cust_area' || i == 'cust_city' || i == 'cust_rarea' || i == 'cust_rcity') {
                        $("#" + i).combogrid('setValue', v);
                    }

                    if (i == 'so_date'
                            || i == 'stnk_bdate'
                            || i == 'stnk_edate'
                            || i == 'due_date'
                            || i == 'match_date'
                            || i == 'pick_date'
                            || i == 'sal_date'
                            || i == 'cls_date'
                            || i == 'fp_date'
                            || i == 'kwit_date'
                            || i == 'sj_date'
                            || i == 'crd_cntrdt'
                            ) {
                        if (v !== '0000-00-00') {
                            var v_date = dateSplit(v);
                            $("#" + i).datebox('setValue', v_date);
                        }
                    }

                    if (i == 'veh_price'
                            || i == 'veh_disc'
                            || i == 'veh_at'
                            || i == 'veh_bbn'
                            || i == 'veh_misc'
                            || i == 'veh_total'
                            || i == 'srv_at'
                            || i == 'part_at'
                            || i == 'inv_stamp'
                            || i == 'inv_total'
                            || i == 'veh_pbm'
                            || i == 'veh_bt'
                            || i == 'veh_vat'
                            || i == 'sovehprice'
                            || i == 'bbnwo_prc'
                            || i == 'bbnpur_prc'
                            || i == 'srv_price'
                            || i == 'srv_disc'
                            || i == 'srv_bt'
                            || i == 'srv_vat'
                            || i == 'due_day'
                            || i == 'cust_zipc'
                            || i == 'cust_rzipc'
                            || i == 'crd_amount'
                            || i == 'crd_term'
                            || i == 'comm_val'
                            || i == 'sal_incpnt'
                            || i == 'sal_incpct'
                            ) {

                        $("#" + i).numberbox('setValue', v);
                    }

                });


                $("#bbnwo_no2").val(rowData.bbnwo_no);
                $("#bbnpur_no2").val(rowData.bbnpur_no);

                $("#srv_at2").numberbox('setValue', total);
                $("#veh_at2").numberbox('setValue', rowData.veh_at);
                var sal_inv_no = rowData.sal_inv_no;
                var ttable = $('#dt_jasa');

                table_grid(ttable, sal_inv_no);

                if (edited == false) {
                    cmdcondAwal();
                    formDisabled();
                }

                if (rowData.pick_date == null || rowData.pick_date == '0000-00-00') {
                    $("#cmdPick").removeAttr('disabled');
                    $("#cmdPick").linkbutton('enable');
                    $("#cmdDropPick").linkbutton('disable');
                    //$("#cmdDropPick").removeClass('btn-success');
                    //$("#cmdOptional").linkbutton('disable');
                } else {
                    $("#cmdDropPick").removeAttr('disabled');
                    $("#cmdDropPick").linkbutton('enable');
                    $("#cmdPick").linkbutton('disable');
                    //$("#cmdPick").removeClass('btn-success');
                    // $("#cmdOptional").linkbutton('enable');
                }

                /*
                 if (rowData.pick_date == null || rowData.pick_date == '0000-00-00') {
                 $("#printSJ").linkbutton('disable');
                 } else {
                 $("#printSJ").removeAttr('disabled');
                 $("#printSJ").linkbutton('enable');
                 }
                 */
                if (rowData.cls_date == null || rowData.cls_date == '0000-00-00') {
                    $("#cmdOptional").removeAttr('disabled');
                    $('#cmdOptional').linkbutton('enable');
                    $("#closeOn").empty().append('<button type="button" id="cmdClose" title="<?php getCaption("Close"); ?>" class="easyui-linkbutton easyui-tooltip btn btn-success" data-options="iconCls:\'icon-close\'"  onclick="rolesClose()">Close</button>');
                    $("#print").linkbutton('disable');
                    $("#printSJ").linkbutton('disable');

                    $('#cmdClose').linkbutton();

                } else {
                    $("#cmdOptional").attr('disabled', true);
                    $('#cmdOptional').linkbutton('disable');
                    $("#closeOn").empty().append('<button type="button" id="cmdUnClose" title="<?php getCaption("unClose"); ?>" class="easyui-linkbutton easyui-tooltip btn btn-success" data-options="iconCls:\'icon-unclose\'"  onclick="rolesUnclose()">Unclose</button>');

                    $('#cmdUnClose').linkbutton();
                    $("#print").removeAttr('disabled');
                    $("#print").linkbutton('enable');
                    $("#printSJ").removeAttr('disabled');
                    $("#printSJ").linkbutton('enable');

                    $("#cmdDropPick").attr('disabled', true);
                    $("#cmdPick").attr('disabled', true);

                    $(".btn-pick").linkbutton('disable');
                    $("#cmdEdit").attr('disabled', true);
                    $("#cmdDelete").attr('disabled', true);
                    $("#cmdEdit").linkbutton('disable');
                    $("#cmdDelete").linkbutton('disable');
                }




                $("#sinv_code_copy").attr('disabled', true);
                $("#sinv_code_copy").val('Kendaraan Showroom');

            } else {
                if (edited == false) {
                    cmdcondAwal();
                    formDisabled();
                }

                $('.cmdEdit').linkbutton('disable');
                $('.cmdDelete').linkbutton('disable');
                $('.loader').hide();
                $("#cmdDropPick").attr('disabled', true);
                $("#cmdPick").attr('disabled', true);

                $("#cmdDropPick").linkbutton('disable');
                $("#cmdPick").linkbutton('disable');

                $("#cmdOptional").attr('disabled', true);
                $('#cmdOptional').linkbutton('disable');
                $("#closeOn").empty();
            }

            $('.loader').hide();
        });
    }

    function condSearchbk() {

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
                    {field: 'sal_inv_no', title: '<?php getCaption("No. Faktur Jual"); ?> ', width: 150, height: 20, sortable: true},
                    {field: 'sal_date', title: '<?php getCaption("Tgl. Faktur Jual"); ?> ', width: 150, height: 20, sortable: true, formatter: formatDate},
                    {field: 'so_no', title: '<?php getCaption("No. SPK"); ?> ', width: 120, height: 20, sortable: true},
                    {field: 'cust_code', title: '<?php getCaption("Kode Pelanggan"); ?>  ', width: 120, height: 20, sortable: true},
                    {field: 'cust_name', title: '<?php getCaption("Nama Pelanggan"); ?>  ', width: 250, height: 20, sortable: true},
                    {field: 'cust_rname', title: '<?php getCaption("Nama di STNK"); ?>  ', width: 250, height: 20, sortable: true},
                    {field: 'srep_code', title: '<?php getCaption("Kode Sales"); ?>  ', width: 120, height: 20, sortable: true},
                    {field: 'srep_name', title: '<?php getCaption("Nama Sales"); ?>  ', width: 200, height: 20, sortable: true},
                    {field: 'veh_code', title: '<?php getCaption("Kode Kendaraan"); ?>  ', width: 120, height: 20, sortable: true},
                    {field: 'veh_name', title: '<?php getCaption("Nama Kendaraan"); ?>  ', width: 250, height: 20, sortable: true},
                    {field: 'chassis', title: '<?php getCaption("Chassis"); ?>  ', width: 150, height: 20, sortable: true},
                    {field: 'veh_transm', title: '<?php getCaption("Transmisi"); ?>  ', width: 100, height: 20, sortable: true},
                    {field: 'color_code', title: '<?php getCaption("Kode Warna"); ?>  ', width: 120, height: 20, sortable: true},
                    {field: 'color_name', title: '<?php getCaption("Nama Warna"); ?>  ', width: 200, height: 20, sortable: true}
                ]]
        });
        // $("#tableSearch").datagrid('enableFilter');
        $("#tableSearch").datagrid('reload');
        $('#windowSearch').window('open');

        var option = $("#SearchOption").html();

        $("#actionSearch").empty().html(option);
        //$("#SearchOption").show();
    }
    function doSearch() {
        $("#tableSearch").datagrid('load', {
            field1: $('#code').val(),
            field3: $('#name').val()
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
        var pick_date = $('#pick_date').datebox('getValue');

        if (pick_date == '') {
            var id = $("#form_validation #id").val();
            var table = $("#form_validation #table").val();
            $.messager.confirm('Warning', 'Do you really want to delete the selected data ?', function (r) {
                if (r) {
                    $('.loader').show();
                    var url = site_url + 'transaction/vehicle/deleteVehicleSale';
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
                }else{
                    $('#cmdDelete').linkbutton('enable');
                }
                
            });
        } else {
            showAlert("Error while deleting", '<font color="red">Sorry, Vehicle sale invoice can\'t be deleted</font>');
        }

    }

    function condCancel() {
        edited = false;
        cmdcondAwal();
        read_show('');
        $("#form_validation .formError").remove();
        $("#form_validation .easyui-datebox").datebox('disable');
    }
    function closeBtn(){
        if ($("#form_validation #salpaytype_2").is(':checked')) {
            var lease_code = $("#form_validation #lease_code").val();
            
            if(lease_code == ''){
                $.messager.confirm('Check Transaction Type : CASH/CREDIT', 'Sorry, the transaction marked this CREDIT there is no LEASING. Continue ?', function (r) {
                    if (r) {
                        closeNextBtn();
                    }
                });
            }else{
                 closeNextBtn();
            }
        }else{
            closeNextBtn();
        }
    }
    function closeNextBtn() {

        var cust_type = $("#form_validation input[name='cust_type']:checked").val();

        if (cust_type !== undefined) {
            $.messager.confirm('Closing Invoice', 'Close this Invoice?', function (r) {
                if (r) {

                    if ($("#due_day").val() == '') {
                        $.messager.alert('Warning','Please input TOP', 'warning');
                        return false;
                    }

                    if ($("#veh_price").val() == 0) {
                        $.messager.alert('Warning','Please input vehicle Sale Price ', 'warning');
                        return false;
                    }

                    if ($("#salpaytype:checked").val() == 0) {
                        $.messager.alert('Warning','Please choose Transaction option (Cash or Credit)', 'warning');
                    }


                    $('#form_validation :input').attr('disabled', false);
                    $('.loader').show();
                    form.form('submit', {
                        url: close_url,
                        onSubmit: function () {
                            return $(this).form('validate');
                        },
                        success: function (data) { //alert(data);$('.loader').hide();

                            var obj = JSON.parse(data);
                            if (obj.success == true) {

                                var sal_inv_no = $("#sal_inv_no").val();

                                $.post(site_url + 'transaction/vehicle/check_dpcd', {table: 'veh_dpcd', sal_inv_no: sal_inv_no}, function (res) {

                                    if (res !== '0') {
                                        $("#wUJ").window('open');
                                        table_uj();
                                    }
                                });


                                read_show('');
                            } else
                            {
                                $('.loader').hide();
                                showAlert("Error closed", '<font color="red">' + obj.message + '</font>');
                                read_show('');
                            }
                            
                            scrlTop();
                            cmdcondAwal();
                            formDisabled();
                        }
                    });
                }
                read_show('');

            });

        } else {
            $.messager.alert('Warning','Customer type has to be either End User or Dealer/Reseller', 'warning');
        }

    }

    function UncloseBtn() {
        $.messager.confirm('Unclosing Invoice', 'Unclose this invoice??', function (r) {
            if (r) {

                $('#form_validation :input').attr('disabled', false);
                $('.loader').show();
                form.form('submit', {
                    url: unclose_url,
                    onSubmit: function () {
                        return $(this).form('validate');
                    },
                    success: function (data) {// alert(data);return false;

                        var obj = JSON.parse(data);
                        if (obj.success == true) {
                            showAlert("Information", obj.message);
                            read_show('');
                        } else
                        {
                            $('.loader').hide();
                            read_show('');
                            showAlert("Error unclosed", '<font color="red">' + obj.message + '</font>');
                        }
                        scrlTop();
                    }
                });
            }
            read_show('');

        });

    }

    function table_uj() {
        var sal_inv_no = $("#sal_inv_no").val();

        $("#tableUJ").datagrid({
            method: 'post',
            url: site_url + '<?php echo 'builder/grid_uang_jaminan/' . encrypt_decrypt('encrypt', 'veh_dpcd'); ?>/' + sal_inv_no + '/?grid=true',
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
                    {field: 'dp_inv_no', title: '<?php getCaption('No. Faktur '); ?>', width: 120, height: 20, sortable: true},
                    {field: 'dp_date', title: '<?php getCaption('Tgl. Faktur'); ?>', width: 100, height: 20, sortable: true, formatter: formatDate},
                    {field: 'so_no', title: '<?php getCaption('No. SPK'); ?>', width: 120, height: 20, align: 'left', sortable: true},
                    {field: 'payer_name', title: 'Customer Name', width: 250, height: 20, align: 'left', sortable: true},
                    {field: 'used_val', title: '<?php getCaption('Uang Jaminan'); ?>', width: 150, height: 20, align: 'right', sortable: true, formatter: formatNumber},
                    {field: 'check_no', title: '<?php getCaption('No. Check'); ?>', width: 100, height: 20, sortable: true},
                    {field: 'chassis', title: '<?php getCaption('Chassis'); ?>', width: 150, height: 20, align: 'left', sortable: true},
                    {field: 'engine', title: '<?php getCaption('Engine'); ?>', width: 120, height: 20, align: 'left', sortable: true},
                    {field: 'cust_code', title: 'Customer Code', width: 200, height: 20, align: 'left', sortable: true}

                ]]
        });
    }
    function table_grid(ttable, sal_inv_no) {
        ttable.datagrid({
            method: 'post',
            url: site_url + '<?php echo 'builder/datagrid/' . encrypt_decrypt('encrypt', 'veh_sld'); ?>/sal_inv_no/' + sal_inv_no + '/?grid=true',
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
                    {field: 'wk_code', title: '<?php getCaption("Kode Pekerjaan"); ?>', width: 120, height: 20, sortable: true},
                    {field: 'wk_desc', title: '<?php getCaption("Nama Pekerjaan"); ?>', width: 350, height: 20, sortable: true},
                    {field: 'price_bd', title: '<?php getCaption("Harga Jual"); ?>', width: 120, height: 20, align: 'right', sortable: true, formatter: formatNumber},
                    {field: 'disc_pct', title: '<?php getCaption("Diskon"); ?> %', width: 120, height: 20, align: 'right', sortable: true, formatter: formatNumber},
                    {field: 'disc_val', title: '<?php getCaption("Jumlah Diskon"); ?>', width: 120, height: 20, align: 'right', sortable: true, formatter: formatNumber},
                    {field: 'price_ad', title: '<?php getCaption("Harga Netto"); ?>', width: 120, height: 20, align: 'right', sortable: true, formatter: formatNumber},
                    {field: 'add_by', title: '<?php getCaption("Ditambahkan Oleh"); ?>', width: 100, height: 20, align: 'right', sortable: true}

                ]]
        });
    }

    function condAdd() {
        //$("#form_validation .easyui-datebox").datebox('enable');
        $('.easyui-numberbox').numberbox('setValue', '');
        $("#form_validation .easyui-datebox").datebox('setValue', '');
        $('#form_validation #id').val('');
        $('#form_validation input:text').val('');
        $('#form_validation textarea').val("");

        $("#form_validation #table").val(table);
        //$("#form_validation input:radio").prop("checked", false);
        $("#form_validation .salpaytype").prop("checked", false);
        $('#form_validation .easyui-combogrid').combogrid('setValue', '');
        condReady();

        $("#form_validation #sinv_code_copy").attr('disabled', true);
        $("#form_validation #sinv_code_copy").val('Kendaraan Showroom');


        $.post(site_url + 'transaction/vehicle/get_number/VSL', function (num) {
            $("#form_validation #sal_inv_no").val(num);
        });
        $("#wrhs_code").combogrid('setValue', '<?php echo $wrhs_input; ?>');

        // $("#form_validation #due_day").numberbox('setValue', 0);
        // $("#form_validation #due_date").datebox('setValue', '<?php echo date('Y-m-d'); ?>');
    }

    function condReady() {
        scrlTop();
        $('#form_validation :input').attr('disabled', false);
        $("#form_validation #cust_code").attr('disabled', true);
        $('#form_validation .easyui-combogrid').combogrid('enable');
        $('#form_validation .easyui-combobox').combobox({disabled: false});
        $("#form_validation .easyui-datebox").datebox('enable');
        $("#form_validation input:radio").attr('disabled', true);

        checkboxClick();
        cmdcondReady();


        /* Header*/
        $("input.salpaytype").attr("disabled", false);
        $("#form_validation #sal_inv_no").attr('disabled', true);
        $("#form_validation #sal_date").datebox('disable');
        $('#form_validation #wrhs_code').combogrid('disable');
        $('#form_validation #loc_code').combogrid('disable');
        $('#form_validation #sosrc_name').combogrid('disable');
        $("#form_validation #cls_date").datebox('disable');
        $("#form_validation #cls_by").attr('disabled', true);
        /* End Header */


        /* Tab Vehicle*/

        $("#form_validation #pick_date").datebox('disable');
        $("#form_validation #match_date").datebox('disable');
        $("#form_validation #veh_code").attr('disabled', true);
        $("#form_validation #veh_name").attr('disabled', true);
        $("#form_validation #so_no").attr('disabled', true);
        $("#form_validation #chassis").attr('disabled', true);
        $("#form_validation #bbnwo_no").attr('disabled', true);
        $("#form_validation #bbnpur_no").attr('disabled', true);
        $("#form_validation #engine").attr('disabled', true);
        $("#form_validation #veh_type").attr('disabled', true);
        $("#form_validation #veh_model").attr('disabled', true);
        $("#form_validation #veh_brand").attr('disabled', true);
        $("#form_validation #veh_transm").attr('disabled', true);
        $("#form_validation #veh_year").attr('disabled', true);
        $("#form_validation #color_code").attr('disabled', true);
        $("#form_validation #color_name").attr('disabled', true);
        $("#form_validation #color_type").attr('disabled', true);
        $("#form_validation #stdoptname").attr('disabled', true);
        /* End Tab Vehicle*/

        /* Tab Detail Sale Price*/
        $("#form_validation #veh_at").attr('disabled', true);
        $("#form_validation #veh_total").attr('disabled', true);
        $("#form_validation #srv_at").attr('disabled', true);
        $("#form_validation #part_at").attr('disabled', true);
        $("#form_validation #inv_total").attr('disabled', true);

        $("#form_validation #veh_bt").attr('disabled', true);
        $("#form_validation #veh_vat").attr('disabled', true);
        $("#form_validation #veh_at2").attr('disabled', true);
        $("#form_validation #so_no2").attr('disabled', true);
        $("#form_validation #sovehprice").attr('disabled', true);
        $("#form_validation #bbnpur_no").attr('disabled', true);
        $("#form_validation #bbnwo_no2").attr('disabled', true);
        $("#form_validation #bbnwo_prc").attr('disabled', true);
        $("#form_validation #bbnpur_no2").attr('disabled', true);
        $("#form_validation #bbnpur_prc").attr('disabled', true);
        /* End Tab Detail Sale Price*/

        /* Tab STNK*/
        $("input.cust_rsex").attr("disabled", false);
        /* END Tab STNK*/


        /* Tab Komisi Sales*/
        $("#form_validation #comm_val").attr('disabled', true);
        $("#form_validation #medtr_name").attr('disabled', true);
        $("#form_validation #medtr_addr").attr('disabled', true);

        $("#form_validation #sspv_code").attr('disabled', true);
        $("#form_validation #sspv_name").attr('disabled', true);
        $("#form_validation #sspv_lev").attr('disabled', true);
        $("#form_validation #srep_lev").attr('disabled', true);
        $("#form_validation #srep_code").attr('disabled', true);
        /* END Tab Komisi Sales*/

        /* Tab Insentif*/
        $("input.sal_inctyp").attr("disabled", false);
        /* END Tab Insentif*/

        /* Tab Sales Document*/
        $("#so_date").datebox('disable');
        $("#sj_date").datebox('disable');
        $("#kwit_date").datebox('disable');
        $("#sj_no").attr("disabled", true);
        $("#kwit_no").attr("disabled", true);
        $("#fp_no").attr("disabled", true);
        $("#fp_date").datebox("disable");
        $("input.sal_inctyp").attr("disabled", false);
        $("input.kwit_data").attr("disabled", false);
        $("input.fp_data").attr("disabled", false);
        /* END Tab Sales Document*/

        /* tab Optional*/
        $("#form_validation #srv_price").attr('disabled', true);
        $("#form_validation #srv_bt").attr('disabled', true);
        $("#form_validation #srv_vat").attr('disabled', true);
        $("#form_validation #srv_at").attr('disabled', true);
        $("#form_validation #srv_at2").attr('disabled', true);
        /* End tab Optional*/

        /*  tab leasing */
        $("#form_validation #lease_name").combogrid('disable');
        $("#lease_code, #lease_addr, #lease_city, #lease_zipc, #lcp1_name, #lcp1_title, #crd_note, #crd_via, #crd_amount, #crd_term, #crd_apprby, #crd_cntrno").attr('disabled', true);
        $("#crd_cntrdt").datebox('disable');
        /* end tab leasing */


        input_price();
        optional_price();

        var sal_inv_no = $("#form_validation #sal_inv_no").val();

        if (sal_inv_no == '') {
            sal_inv_no = null;
        }
        table_grid(ttable, sal_inv_no);
    }

    function optional_price() {
        $("#form_validation #srv_disc").keyup(function () {
            var srv_price = parseCurrency($("#form_validation #srv_price").val());
            var srv_disc = parseCurrency($(this).val());

            var total_bt = srv_price - srv_disc;
            var vat = total_bt / 10;
            var total = total_bt + vat;

            $("#form_validation #srv_bt").numberbox('setValue', total_bt);
            $("#form_validation #srv_vat").numberbox('setValue', vat);
            $("#form_validation #srv_at").numberbox('setValue', total);
            $("#form_validation #srv_at2").numberbox('setValue', total);

            price_vehicle();
        });
    }
    function input_price() {
        $("#form_validation #veh_price").keyup(function () {
            price_vehicle();
        });


        $("#form_validation #veh_disc").keyup(function () {
            price_vehicle();

        });

        $("#form_validation #veh_bbn").keyup(function () {

            var bbn_set = '<?php echo $bbn_set; ?>';

            if (bbn_set == '1') {
                bbn_price_min();
            }
            if (bbn_set == '2') {
                price_vehicle();
            }
        });

        $("#form_validation #veh_misc").keyup(function () {
            price_vehicle();
        });

        $("#form_validation #veh_pbm").keyup(function () {
            price_vehicle();
        });

        $("#form_validation #inv_stamp").keyup(function () {
            price_vehicle();
        });
    }


    function bbn_price_min() {
        var veh_bbn = parseCurrency($("#form_validation #veh_bbn").val());
        var veh_misc = parseCurrency($("#form_validation #veh_misc").val());
        var veh_disc = parseCurrency($("#form_validation #veh_disc").val());
        var veh_total = parseCurrency($("#form_validation #veh_total").val());

        if (veh_bbn == '') {
            veh_bbn = 0;
        }
        if (veh_misc == '') {
            veh_misc = 0;
        }
        if (veh_disc == '') {
            veh_disc = 0;
        }
        if (veh_total == '') {
            veh_total = 0;
        }

        var price = (parseInt(veh_total) + parseInt(veh_disc)) - (parseInt(veh_bbn) + parseInt(veh_misc));

        $("#form_validation #veh_price").numberbox('setValue', price);

        price_vehicle();

    }

    function price_vehicle() {
        var veh_price = parseCurrency($("#form_validation #veh_price").val());
        var veh_disc = parseCurrency($("#form_validation #veh_disc").val());

        var veh_bbn = parseCurrency($("#form_validation #veh_bbn").val());
        var veh_misc = parseCurrency($("#form_validation #veh_misc").val());

        var srv_at = parseCurrency($("#form_validation #srv_at").val());

        var veh_pbm = parseCurrency($("#form_validation #veh_pbm").val());
        var veh_bt = parseCurrency($("#form_validation #veh_bt").val());
        var veh_vat = parseCurrency($("#form_validation #veh_vat").val());
        var veh_at2 = parseCurrency($("#form_validation #veh_at2").val());
        var inv_stamp = parseCurrency($("#form_validation #inv_stamp").val());
        var part_at = parseCurrency($("#form_validation #part_at").val());

        /*
         var veh_price = $("#form_validation #veh_price").numberbox('getValue');
         var veh_disc = $("#form_validation #veh_disc").numberbox('getValue');
         
         var veh_bbn  = $("#form_validation #veh_bbn").numberbox('getValue');
         var veh_misc = $("#form_validation #veh_misc").numberbox('getValue');
         
         var srv_at   = $("#form_validation #srv_at").numberbox('getValue');
         
         var veh_pbm  = $("#form_validation #veh_pbm").numberbox('getValue');
         var veh_bt   = $("#form_validation #veh_bt").numberbox('getValue');
         var veh_vat  = $("#form_validation #veh_vat").numberbox('getValue');
         var veh_at2  = $("#form_validation #veh_at2").numberbox('getValue');
         var inv_stamp = $("#form_validation #inv_stamp").numberbox('getValue');
         var part_at   = $("#form_validation #part_at").numberbox('getValue');
         */
        if (veh_price == '') {
            veh_price = 0;
        }
        if (veh_disc == '') {
            veh_disc = 0;
        }
        if (veh_bbn == '') {
            veh_bbn = 0;
        }
        if (veh_misc == '') {
            veh_misc = 0;
        }
        if (srv_at == '') {
            srv_at = 0;
        }
        if (veh_pbm == '') {
            veh_pbm = 0;
        }
        if (veh_bt == '') {
            veh_bt = 0;
        }
        if (veh_vat == '') {
            veh_vat = 0;
        }
        if (veh_at2 == '') {
            veh_at2 = 0;
        }
        if (inv_stamp == '') {
            inv_stamp = 0;
        }
        if (part_at == '') {
            part_at = 0;
        }

        if (veh_bbn > veh_price) {
            $("#veh_price").numberbox('setValue', veh_price);

        }

        var sub_total = veh_price - veh_disc;

        var total_harga = parseInt(sub_total) + parseInt(veh_bbn) + parseInt(veh_misc);

        var grand_total = parseInt(total_harga) + parseInt(inv_stamp) + parseInt(srv_at) + parseInt(part_at);
        // + parseInt(srv_at) + parseInt(part_at) 
        //alert($("#form_validation #part_at").val())


        $("#veh_at").numberbox('setValue', sub_total);
        $("#veh_at2").numberbox('setValue', sub_total);
        $("#veh_total").numberbox('setValue', total_harga);
        $("#inv_total").numberbox('setValue', grand_total);

        price_vehicle_min(sub_total);
    }

    function price_vehicle_min(sub_total) {
        var veh_pbm = parseCurrency($("#form_validation #veh_pbm").val());
        var veh_bt = parseCurrency($("#form_validation #veh_bt").val());
        var veh_vat = parseCurrency($("#form_validation #veh_vat").val());
        var veh_at2 = parseCurrency($("#form_validation #veh_at2").val());

        if (veh_pbm == '') {
            veh_pbm = 0;
        }
        if (veh_bt == '') {
            veh_bt = 0;
        }
        if (veh_vat == '') {
            veh_vat = 0;
        }
        if (veh_at2 == '') {
            veh_at2 = 0;
        }

        var dpp = (parseInt(sub_total) - parseInt(veh_pbm)) / 1.1;
        //var ppn = (parseInt(dpp) * comp_ppn) / 100;
        var ppn = parseInt(sub_total) - dpp;

        $("#veh_bt").numberbox('setValue', dpp);
        $("#veh_vat").numberbox('setValue', ppn);


    }
    function parseCurrency(num) {
        // return parseFloat(num.replace(/[^0-9\.-]+/g,""));
        // return parseFloat(num.replace(/[^0-9\.-]+/g,""));
        return num.replace(/[^0-9]/g, '');
    }

    function saveData() {

        if ($("#form_validation #salpaytype_2").is(':checked')) {
            var lease_code = $("#form_validation #lease_code").val();
            
            if(lease_code == ''){
                $.messager.confirm('Check Transaction Type : CASH/CREDIT', 'Sorry, the transaction marked this CREDIT there is no LEASING. Continue ?', function (r) {
                    if (r) {
                        saveNext();
                    }
                });
            }else{
                 saveNext();
            }
        }else{
            saveNext();
        }

    }

    function saveNext(){
        $('.loader').show();
        $("#form_validation #sinv_code").val('VSL');
        $('#form_validation :input').attr('disabled', false);

        form.form('submit', {
            url: save_url,
            onSubmit: function () {
                return $(this).form('validate');
            },
            success: function (data) {
                var obj = JSON.parse(data);
                if (obj.success == true) {
                    edited = false;
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
    function table_grid_stk(ttable, url) {
        ttable.datagrid({
            method: 'post',
            url: url,
            idField: 'id',
            /*fitColumns: true,*/
            singleSelect: true,
            nowrap: true,
            fit: false,
            rownumbers: true,
            pageSize: 10,
            showFooter: false,
            pagination: true,
            columns: [[
                    {field: 'chassis', title: '<?php getCaption('Chassis'); ?>', width: 180, height: 20, sortable: true},
                    {field: 'engine', title: '<?php getCaption('Engine'); ?>', width: 180, height: 20, sortable: true},
                    {field: 'stk_date', title: 'Stock Date', width: 100, height: 20, sortable: true, formatter: formatDate},
                    {field: 'match_date', title: '<?php getCaption('Tgl. Match'); ?>', width: 100, height: 20, sortable: true, formatter: formatDate},
                    {field: 'veh_code', title: '<?php getCaption('Kode Kendaraan'); ?>', width: 100, height: 20, sortable: true},
                    {field: 'veh_model', title: '<?php getCaption('Model'); ?>', width: 100, height: 20, sortable: true},
                    {field: 'color_code', title: 'Color Code', width: 100, height: 20, sortable: true},
                    {field: 'veh_transm', title: '<?php getCaption('Transmisi'); ?>', width: 100, height: 20, sortable: true},
                    {field: 'veh_name', title: '<?php getCaption('Nama Kendaraan'); ?>', width: 250, height: 20, sortable: true},
                    {field: 'color_name', title: 'Color Name', width: 250, height: 20, sortable: true},
                    {field: 'pur_inv_no', title: '<?php getCaption('No. Faktur Beli'); ?>', width: 150, height: 20, sortable: true},
                    {field: 'so_no', title: '<?php getCaption('No. SPK'); ?>', width: 150, height: 20, sortable: true},
                    {field: 'so_date', title: '<?php getCaption('Tgl. SPK'); ?>', width: 100, height: 20, sortable: true, formatter: formatDate},
                    {field: 'wrhs_code', title: '<?php getCaption('Warehouse'); ?>', width: 100, height: 20, sortable: true}
                    //{field: 'color_code', title: 'Kode Warna', width: 100, height: 20, align: 'center', sortable: true},
                ]]
        });
    }

    function cmdPick() {
        var sal_inv_no = $("#sal_inv_no").val();
        var cust_name = $("#cust_name").combogrid('getValue');
        $.post(site_url + '<?php echo 'transaction/vehicle/check_sld/' . encrypt_decrypt('encrypt', 'veh_sld'); ?>/' + sal_inv_no, function (json) {

            if (json !== '0') {
                showAlert("Invoice already has optional", '<font color="red">This invoice has optional(s). Please delete them first</font>');
            } else {
                $.messager.confirm('Vehicle Pick', 'Customer name ' + cust_name + ' may be replaced if SPK has been matched. <br />Continue to Pick?', function (r) {
                    if (r) {
                        hideshowOption('hide');
                        $("#tableStock").empty().append('<table class="table"><tr><td><table id="tb_stk" class="easyui-datagrid"  title="" style="width:1000px;height:330px;"></table></td></tr>\n\
                                  <tr><td></td></tr><tr><td> <button type="button" id="GetPick" title="Ok" style="width:70px;" class="easyui-linkbutton" data-options="iconCls:\'icon-ok\'" onclick="get_pick()">Ok</button>&nbsp; &nbsp;<button type="button" title="Cancel" class="easyui-linkbutton" data-options="iconCls:\'icon-undo\'" onclick="$(\'#w\').window(\'close\');">Cancel</button></td></tr>');

                        var urls = site_url + 'builder/grid_spk_stok/grid/veh_stk/?grid=true';
                        table_grid_stk($("#tb_stk"), urls);
                        $(".easyui-linkbutton").linkbutton();
                        $('#w').window('open');
                    } else {
                        showAlert("Vehicle Pick Aborted", 'User cancelled vehicle pick');

                    }

                });
            }
        });

    }
    function get_pick() {

        var row = $("#tb_stk").datagrid('getSelected');
        var id = $("#form_validation #id").val();
        //var sal_inv_no = $("#sal_inv_no").val();
        var cust_name = $("#cust_name").combogrid('getValue');

        var statmatchdate = true;

        if (row) {
            var match_date = row.match_date;
            var stat = true;

            if (match_date == '0000-00-00' || match_date == '' || match_date == null) {
                statmatchdate = false;
            }

            $.post(site_url + 'transaction/vehicle/check_matching/<?php echo encrypt_decrypt('encrypt', 'veh_stk'); ?>/', {id: row.id}, function (res) {
                var json = $.parseJSON(res);
                var status = json.status;

                if (status == false) {
                    statmatchdate = false;
                } else {
                    statmatchdate = true;
                }


                if (cust_name == '' && statmatchdate == false) {
                    stat = false;
                }



                if (stat !== false) {

                    if (cust_name !== '') {
                        status = true
                    }

                    if (status !== false) {
                        $.ajax({
                            url: site_url + 'transaction/vehicle/pick_kendaraan/<?php echo encrypt_decrypt('encrypt', 'veh_slh'); ?>/' + id + '/' + row.id,
                            type: 'POST',
                            data: row,
                            success: function (result) {

                                var obj = JSON.parse(result);
                                if (obj.success == true) {

                                    read_show('');
                                    $('#w').window('close');
                                } else
                                {
                                    showAlert("Error while picking", '<font color="red">' + obj.message + '</font>');

                                    if (obj.pick == 'yes') {
                                        read_show('');
                                        $('#w').window('close');
                                    }

                                }
                            }});
                    } else {
                        $('#w').window('close');
                        showAlert("Customer Information Needed", '<font color="red">' + json.message + '</font>');

                    }


                } else {
                    $('#w').window('close');
                    showAlert("Customer Information Needed", '<font color="red">This Vehicle hasn\'t been matched. <br/> Please input Customer Data then Pick this vehicle again</font>');
                }
            });





        }


    }

    function cmdDropPick() {

        $.messager.confirm('Drop Kendaraan', 'Drop this vehicle and put it back into stock?', function (r) {
            if (r) {
                //$('#form_validation :input').attr('disabled', false);
                //var data = $('#form_validation').serialize();
                var url = site_url + 'transaction/vehicle/drop_kendaraan/<?php echo encrypt_decrypt('encrypt', 'veh_slh'); ?>';

                $.post(url, {table: table, id: $("#id").val(), so_no: $("#so_no").val()}, function (result) {
                    var obj = JSON.parse(result);
                    if (obj.success == true) {
                        $(".salpaytype").prop("checked", false);
                        read_show('');
                    } else
                    {
                        showAlert("Error while dropping", '<font color="red">' + obj.message + '</font>');
                    }
                });

            }
        });

    }
    /*-- Optional --*/
    function cmdOptionals() {
        scrlTop();
        var sal_inv_no = $("#form_validation #sal_inv_no").val();

        $("#optionalWindow").window('open');
        tableId2();
        read_show2('');
        table_grid(ttables, sal_inv_no);

    }

    function read_show2(nav) {
        var id = $("#id2").val();
        var sal_inv_no = $("#form_validation #sal_inv_no").val();

        $.post(site_url + 'crud/read/?sal_inv_no=' + sal_inv_no, {table: table2, nav: nav, id: id}, function (json) { //alert(json)

            $("#form_validation2 :input").val('');
            if (json !== '[]') {

                var rowData = $.parseJSON(json); //alert(rowData.price_bd)
                $('#form_validation2').form('load', {
                    wk_code: rowData.wk_code,
                    wk_desc: rowData.wk_desc,
                    price_bd: rowData.price_bd,
                    disc_pct: rowData.disc_pct,
                    disc_val: rowData.disc_val,
                    price_ad: rowData.price_ad
                });
                $("#id2").val(rowData.id);



            }
            formDisabled2();

        });
    }

    function saveData2() {
        $('#cmdSave2').linkbutton('disable');
        var sal_inv_no = $("#sal_inv_no").val();
        var save_url2 = site_url + 'transaction/vehicle/save_sld/' + sal_inv_no + '/<?php echo $session['C_USER']; ?>';
        $('#form_validation2 :input').attr('disabled', false);
        $("#form_validation2").form('submit', {
            url: save_url2,
            onSubmit: function () {
                return $(this).form('validate');
            },
            success: function (data) {

                var obj = JSON.parse(data);

                if (obj.success == true) {
                    //showAlert("Information", obj.message);
                    cmdcondAwal2();
                    formDisabled2();


                    table_grid(ttables, sal_inv_no);
                    table_grid(ttable, sal_inv_no);

                    $("#id2").val('');
                    read_show2('');
                    read_show('');
                } else
                {
                    showAlert("Error while saving", '<font color="red">' + obj.message + '</font>');
                    /*cmdcondAwal2();
                    formDisabled2();

                    $("#id2").val('');
                    read_show2('');*/
                    $('#cmdSave2').linkbutton('enable');
            
                }
            }
        });
    }

    function condDelete2() {
        var id = $("#id2").val();
        var table = 'veh_sld';
        var sal_inv_no = $("#sal_inv_no").val();

        $.messager.confirm('Warning', 'Do you really want to delete the selected data?', function (r) {
            if (r) {

                var url = site_url + 'transaction/vehicle/deleteOptional';
                $.post(url, {table: table, id: id, sal_inv_no: sal_inv_no}, function (data) {

                    obj = JSON.parse(data);
                    if (obj.success == true) {
                        // showAlert("Information", obj.message);
                        $("#id2").val('');
                        sal_inv_no = $("#sal_inv_no").val();
                        cmdcondAwal2();
                        read_show2('');
                        read_show('');
                        table_grid(ttables, sal_inv_no);
                        table_grid(ttable, sal_inv_no);
                    } else
                    {
                        showAlert("Error while deleting", '<font color="red">' + obj.message + '</font>');
                    }
                });
            }
        });
    }
    $('#form_validation2 #wk_code').combogrid({
        onSelect: function (index, row) {
            $('#wk_code').val(row.wk_code);
            $('#wk_desc').val(row.wk_desc);
            $('#price_bd').numberbox('setValue', row.sal_price);


            var disc = $('#form_validation2 #disc_pct').val();
            var harga = row.sal_price;
            var jml_disc = (harga / 100) * disc;

            var total = harga - jml_disc;

            $('#form_validation2 #disc_val').numberbox('setValue', jml_disc);
            $('#form_validation2 #price_ad').numberbox('setValue', total);

        }
    });

    function condCancel2() {
        cmdcondAwal2();
        read_show2('');
        $("#form_validation2 .formError").remove();
    }

    function formDisabled2() {
        //$(':input').attr('disabled', true);
        $('#form_validation2 #wk_code').attr('disabled', true);
        $('#form_validation2 #wk_desc').attr('disabled', true);
        $('#form_validation2 #price_bd').attr('disabled', true);
        $('#form_validation2 #disc_pct').attr('disabled', true);
        $('#form_validation2 #disc_val').attr('disabled', true);
        $('#form_validation2 #price_ad').attr('disabled', true);

        $('#form_validation2 .easyui-combogrid').combogrid('disable');
        $('#form_validation2 .easyui-combobox').combobox({disabled: true});
        $('#form_validation2 .combo-text').removeClass('validatebox-text');
        $('#form_validation2 .combo-text').removeClass('validatebox-invalid');
        cmdcondAwal2();
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
        $('#form_validation2 #wk_code').attr('disabled', false);
        $('#form_validation2 #wk_desc').attr('disabled', false);
        $('#form_validation2 #price_bd').attr('disabled', false);
        $('#form_validation2 #disc_pct').attr('disabled', false);
        $('#form_validation2 #disc_val').attr('disabled', false);
        //$('#form_validation2 #price_ad').attr('disabled', false);

        $('#form_validation2 .easyui-combogrid').combogrid('enable');
        $('#form_validation2 .easyui-combobox').combobox({disabled: false});
        $('#form_validation2 #wk_code').focus();

        $('#form_validation2 #price_bd').keyup(function () {
            var harga = parseCurrency($(this).val());
            var disc = parseCurrency($('#form_validation2 #disc_pct').val());
            var jml_disc = (parseCurrency($('#form_validation2 #price_bd').val()) / 100) * disc;

            if (parseInt(jml_disc) > harga) {
                 $.messager.alert('Warning','Discount value has to be lower than Unit Price', 'warning');
                $(this).val('');
            } else {
                var total = harga - jml_disc;
                $('#form_validation2 #disc_val').numberbox('setValue', jml_disc);
                $('#form_validation2 #price_ad').numberbox('setValue', total);
            }
        });

        $('#form_validation2 #disc_pct').keyup(function () {
            var disc = $(this).val();
            var harga = parseCurrency($('#form_validation2 #price_bd').val());
            var jml_disc = (parseCurrency($('#form_validation2 #price_bd').val()) / 100) * disc;

            if (parseInt(jml_disc) > parseInt(harga)) {
                 $.messager.alert('Warning','Discount value has to be lower than Unit Price', 'warning');
                $(this).val('');
            } else {
                var total = harga - jml_disc;
                $('#form_validation2 #disc_val').numberbox('setValue', jml_disc);
                $('#form_validation2 #price_ad').numberbox('setValue', total);
            }
        });

        $('#form_validation2 #disc_val').keyup(function () {
            var jml_disc = parseCurrency($(this).val());
            var harga = parseCurrency($('#form_validation2 #price_bd').val());

            if (parseInt(jml_disc) > parseInt(harga)) {
                $.messager.alert('Warning','Discount value has to be lower than Unit Price', 'warning');
                $('#form_validation2 #disc_val').numberbox('setValue', '0');

            } else {
                var disc = (jml_disc * 100) / harga;
                var total = harga - jml_disc;

                $('#form_validation2 #disc_pct').val(disc);
                $('#form_validation2 #price_ad').numberbox('setValue', total);
            }
        });
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
        $('#form_validation2 #wk_code').val('');
        $('#form_validation2 #wk_desc').val('');
        $('#form_validation2 #price_bd').val('');
        $('#form_validation2 #disc_pct').val('');
        $('#form_validation2 #disc_val').val('');
        $('#form_validation2 #price_ad').val('');
        $("#form_validation2 #table2").val(table2);
        condReady2();


    }

    function condEdit2() {
        showAlert("Error", '<font color="red">Sorry, this optional detail can’t be edited</font>');
    }


    function tableId2() {
        divtableId2.empty().append('<input type="hidden" name="id2"  id="id2"><input type="hidden" name="table2"  id="table2" value="' + table2 + '">');
    }


    function print_window(action) {
        //$("#form_validation4 input:radio").prop("checked", false);
        $("#form_validation3 #printAction").val(action);
        $("#printWindow").window('open');
        var table = $("#form_validation  #table").val();
        var id = $("#form_validation #id").val();

        $.post(site_url + 'transaction/vehicle/load_invoice', {table: table, id: id}, function (json) { //alert(json)
            var rowData = $.parseJSON(json);

            $('#form_validation4 input:text').val('');


            $("#form_validation4").form('load', {
                wrhs_code: rowData.wrhs_code,
                lease_code: rowData.lease_code,
                lease_name: rowData.lease_name,
                veh_name: rowData.veh_name,
                key_no: rowData.key_no,
                cust_name: rowData.cust_name,
                cust_rname: rowData.cust_rname,
                lease_name2: rowData.lease_name,
                crd_cntrno: rowData.crd_cntrno,
                // crd_cntrdt: rowData.crd_cntrdt,
                crd_amount: rowData.crd_amount
            });

            if (rowData.crd_cntrdt !== '0000-00-00') {
                var vdate = dateSplit(rowData.crd_cntrdt);

                $("#crd_cntrdt").datebox('setValue', vdate);
            }

            $('#form_validation3 input:text').val('');

            var pay_total = rowData.pay_val - rowData.used_val;	//n
            var price_ad = rowData.inv_total - rowData.pay_val;	//n

            $("#form_validation3").form('load', {
                chassis: rowData.chassis,
                inv_total: rowData.inv_total,
                lease_name: rowData.lease_name,
                lease_code: rowData.lease_code,
                crd_cntrno: rowData.crd_cntrno,
                //crd_cntrdt: rowData.crd_cntrdt,
                crd_amount: rowData.crd_amount,
                pd_begin: rowData.pd_begin,
                pd_paid: rowData.pd_paid,
                pd_disc: rowData.pd_disc,
                pd_end: rowData.pd_end,
                pay_val: rowData.pay_val,
                used_val: rowData.used_val,
                pay_total: pay_total,
                price_ad: price_ad
            });

        });

    }

    function screenSJ() {
        var type = $('input[name="data_type"]:checked', '#form_validation4').val();

        //$("#screenWindow").window('open');
        var ids = $("#form_validation #id").val();

        var url = site_url + 'transaction/vehicle/outputpdf/<?php echo encrypt_decrypt('encrypt', 'veh_slh'); ?>/' + ids + '/<?php echo $session['C_USER']; ?>/screen/' + type + '#toolbar=0';
        window.open(url);
        //$("#screenWindow").empty().append('<iframe frameborder="0"  src="' + url + '" style="width:100%;height:auto;min-height: 500px;padding:0px;"></iframe>');
    }

    function downloadSJ() {
        var type = $('input[name="data_type"]:checked', '#form_validation4').val();


        var ids = $("#form_validation #id").val();
        var url = site_url + 'transaction/vehicle/outputpdf/<?php echo encrypt_decrypt('encrypt', 'veh_slh'); ?>/' + ids + '/<?php echo $session['C_USER']; ?>/download/' + type;
        $("#screenWindow").empty().append('<iframe frameborder="0"  src="' + url + '" style="width:100%;height:auto;min-height: 500px;padding:0px;"></iframe>');
        read_show('');
    }


    function print_sc(key) {

        var ids = $("#form_validation #id").val();
        var action = $("#form_validation3 #printAction").val();

        if (key == 'screen') {

            if (action == 'faktur') {

                //$("#screenWindow").window('open');

                var url = site_url + 'transaction/vehicle/outputpdf/<?php echo encrypt_decrypt('encrypt', 'veh_slh'); ?>/' + ids + '/<?php echo $session['C_USER']; ?>/screen#toolbar=0';

                //$("#screenWindow").empty().append('<iframe frameborder="0"  src="' + url + '" style="width:100%;height:auto;min-height: 500px;padding:0px;"></iframe>');
                window.open(url);
            } else {
                checkPiutang(ids, key);
            }
        }

        if (key == 'print') {
            var url = site_url + 'transaction/vehicle/outputpdf/<?php echo encrypt_decrypt('encrypt', 'veh_slh'); ?>/' + ids + '/<?php echo $session['C_USER']; ?>/download';

            if (action == 'faktur') {
                $("#screenWindow").empty().append('<iframe frameborder="0"  src="' + url + '" style="width:100%;height:auto;min-height: 500px;padding:0px;"></iframe>');
            } else {
                checkPiutang(ids, key);
            }
        }
    }

    function dataType() {
        $('.radio').change(function () {
            if ($(this).is(':checked')) {
                var type = $('input[name="data_type"]:checked', '#form_validation4').val();
                var lease_code = $("#form_validation #lease_code").val();

                if (type == 'debitur') {
                    if (lease_code == '') {
                        $("#form_validation4 input:radio").prop("checked", false);
                         $.messager.alert('Warning','Debitur/QQ data is empty. Please select other option(s)','warning');
                        $('#data_type1').prop("checked", true);
                    }
                }
            }
        });


    }


    function checkPiutang(id, action) {
        $.post(site_url + 'transaction/vehicle/load_invoice', {table: table, id: id}, function (json) { //alert(json)
            var rowData = $.parseJSON(json);

            var cust_type =  rowData.cust_type;
                              
                var stat = true;
                
            if(cust_type !== 2){
                    
                var price_ad = rowData.inv_total - rowData.pay_val;	//n
                        //var piutang = price_ad;
                var piutang = rowData.pd_end;
                    
                if (piutang > 0) {

                    if (rowData.lease_code !== '' && rowData.salpaytype == '1') {
                        showAlert("Information", 'There is still outstanding AR : <b>' + formatNumber(piutang) + '</b>');
                    } else {
                        showAlert("Information", 'There is still outstanding AR : <b>' + formatNumber(piutang) + '</b>');
                            //showAlert("Information", 'Sorry, Account Receivable still available : ' + formatNumber(piutang) + '<br /><br />Make sure there are Leasing Name, No. Contract, Contract date and the number of credits exceeds Receivables');
                    }
                    return false;
                    stat = false;
                }
                    
            }

            if (stat !== false) {
                if (action == 'screen') {

                    $("#buttonSJ").empty().append('<button type="button" id="button_FSJ" title="<?php getCaption("Screen Faktur"); ?>" class="easyui-linkbutton" data-options="iconCls:\'icon-print\'" onclick="screenSJ();">Ok</button>');
                    $("#button_FSJ").linkbutton();
                    $("#WindowSJ").window('open');
                    dataType();
                } else {
                    $("#buttonSJ").empty().append('<button type="button" id="button_FSJ" title="<?php getCaption("Print Faktur"); ?>" class="easyui-linkbutton" data-options="iconCls:\'icon-print\'" onclick="downloadSJ();" >Ok</button>');
                    $("#button_FSJ").linkbutton();
                    $("#WindowSJ").window('open');
                    dataType();
                }
            }

        });

    }

    function closeWUJ() {
        read_show('');

        $('#WindowSJ').window('close');
    }


    function showMacthkeyword() {
        var showMacth = $("#showformOption").val();

        if (showMacth !== 'all') {
            hideshowOption('show')

        } else {
            hideshowOption('hide')
            var urls = site_url + 'builder/grid_spk_stok/grid/veh_stk/?grid=true';

            table_grid_stk($("#tb_stk"), urls);
        }
    }

    function hideshowOption(opt) {

        if (opt == 'show') {
            $("#TDkeywordform").show();
            $("#TDbuttonSearchform").show();
        } else {
            $("#TDkeywordform").hide();
            $("#TDbuttonSearchform").hide();
            $("#keywordformMatch").val('');
        }
    }

    function sortirOption() {
        var field = $("#showformOption").val();
        var val = $("#keywordformMatch").val();

        var urls = site_url + 'builder/grid_spk_stok/grid/veh_stk/' + field + '/' + val + '/?grid=true';

        table_grid_stk($("#tb_stk"), urls);
    }
</script>