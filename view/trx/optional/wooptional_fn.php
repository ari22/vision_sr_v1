<script>

    var table = 'acc_woh';
    var form = $('#form_validation');
    var save_url = site_url + 'transaction/optional/save_optional/<?php echo $_SESSION['C_USER']; ?>';
    var unclose_url = site_url + 'transaction/optional/uncloseWO/<?php echo $_SESSION['C_USER']; ?>';
    var close_url = site_url + 'transaction/optional/closeWO/<?php echo $_SESSION['C_USER']; ?>';
    var delete_url = site_url + 'transaction/optional/delete_optional';

    var divtableId = $("#tableId");
    var ttable = $('#dt');

    var table2 = 'acc_wod';
    var ttable2 = $('#dt2');
    var divtableId2 = $("#tableId2");




    $('#prep_name').combogrid({
        onSelect: function (index, row) {
            $("#prep_code").val(row.prep_code);
        }
    });

    $('#raddr_code').combogrid({
        onSelect: function (index, row) {
            $("#rname").val(row.oname);
            $("#raddr").val(row.oaddr);
            $("#rarea").val(row.oarea);
            $("#rcity").val(row.ocity);
            $("#rcountry").val(row.ocountry);
            $("#rzipcode").val(row.ozipcode);
            $("#rphone").val(row.ophone);
            $("#rhp").val(row.ohp);
            $("#rfax").val(row.ofax);
        }
    });

    $('#supp_name').combogrid({
        onSelect: function (index, row) {
            $("#supp_code").val(row.supp_code);

            if (row.postaddr == 1) {
                $("#saddr").val(row.oaddr);
                $("#sarea").val(row.oarea);
                $("#scity").val(row.ocity);
                $("#scountry").val(row.ocountry);
                $("#szipcode").val(row.ozipcode);
                $("#sphone").val(row.ophone);
                $("#shp").val(row.ohp);
                $("#sfax").val(row.ofax);

            }
            else if (row.postaddr == 2) {
                $("#saddr").val(row.haddr);
                $("#sarea").val(row.harea);
                $("#scity").val(row.hcity);
                $("#scountry").val(row.hcountry);
                $("#szipcode").val(row.hzipcode);
                $("#sphone").val(row.hphone);
                $("#shp").val(row.hp);
                $("#sfax").val(row.hfax);

            }

        }
    });

    $("#form_validation #chassis").combogrid({
        /* method: 'post',
         url: site_url + '<?php //echo 'builder/combogrid/' . encrypt_decrypt('encrypt', 'veh_slh');    ?>/pick_date/?grid=true',
         idField: 'id',
         textField: 'chassis',
         panelWidth: 500,
         panelHeight: 200,
         fitColumns: false,
         fit: false,
         mode: 'remote',
         pagination: true,
         remoteSort: true,
         multiSort: true,
         required: false,
         loadMsg: 'Please wait...',
         columns: [[
         {field: 'chassis', title: '<?php getCaption('Chassis'); ?>', width: 150},
         {field: 'so_no', title: '<?php getCaption('No. SPK'); ?>', width: 100},
         {field: 'so_date', title: '<?php getCaption('Tgl. SPK'); ?>', width: 100, formatter: formatDate},
         {field: 'sal_inv_no', title: '<?php getCaption('Faktur Jual'); ?>', width: 150},
         {field: 'cust_name', title: '<?php getCaption('Nama Pelanggan'); ?>', width: 200},
         {field: 'color_name', title: '<?php getCaption('Warna'); ?>', width: 200},
         {field: 'cust_code', title: '<?php getCaption('Kode Pelanggan'); ?>', width: 150}
         ]],*/
        onSelect: function (index, rowData) {
            $.each(rowData, function (i, v) {

                if (i == 'veh_transm' || i == 'veh_year' || i == 'srep_name' || i == 'sal_inv_no' || i == 'so_no' || i == 'color_code' || i == 'color_name' || i == 'veh_code' || i == 'veh_name' || i == 'veh_model' || i == 'veh_type' || i == 'engine') {
                    $("#form_validation #" + i).val(v);
                }

                if (i == 'so_date') {
                    if (v !== '0000-00-00') {
                        var v_date = dateSplit(v);
                        $("#form_validation #" + i).datebox('setValue', v_date);
                    }

                }

            });
        }
    });




    function tableId() {
        divtableId.empty().append('<input type="hidden" name="id"  id="id"><input type="hidden" name="table"  id="table" value="' + table + '">');
    }

    function read_show(nav) {
        var id = $("#form_validation #id").val();

        $.post(site_url + 'crud/read', {table: table, nav: nav, id: id}, function (json) { //alert(json)
            $('#form_validation input:text').val('');
            $('#form_validation textarea').val('');
            $('#form_validation .easyui-combogrid').combogrid('setValue', '');
            $('#form_validation .easyui-combobox').combobox('setValue', '');
            $(".easyui-datebox").datebox('setValue', '');

            if (json !== '[]') {

                var rowData = $.parseJSON(json);

                $.each(rowData, function (i, v) {
                    $("#form_validation #" + i).val(v);

                    if (i == 'wo_date' || i == 'opn_date' || i == 'due_date' || i == 'cls_date' || i == 'quote_date' || i == 'prcvd_date' || i == 'so_date') {
                        if (v !== '0000-00-00') {
                            var v_date = dateSplit(v);
                            $("#form_validation #" + i).datebox('setValue', v_date);
                        }

                    }
                    if (i == 'supp_name' || i == 'prep_name' || i == 'raddr_code' || i == 'curr_code' || i == 'chassis') {
                        $("#form_validation #" + i).combogrid('setValue', v);
                    }
                    if (i == 'tot_price' || i == 'inv_disc' || i == 'inv_bt' || i == 'inv_vat' || i == 'inv_at' || i == 'inv_stamp' || i == 'inv_total') {
                        $("#form_validation #" + i).numberbox('setValue', v);
                    }
                    /*
                     if (i == 'po_type') {                       
                     $("#form_validation #" + i).combobox('setValue', v);                      
                     }
                     */

                });
				
				   
				cmdcondAwal();
                formDisabled();
				
				
				if(rowData.inv_vat == 0){ 
					$(".deletePPN").attr('disabled', true);
                    $(".deletePPN").linkbutton('disable');
				}
                //$("#po_type").combobox('setValue', rowData.po_type);
             

                var wo_no = rowData.wo_no;
                table_grid(ttable, wo_no);

                if (rowData.chassis !== '') {
                    $("#cmdGetSPK").removeAttr('disabled');
                    $("#cmdGetASales").removeAttr('disabled');
                    $("#cmdGetSPK").linkbutton('enable');
                    $("#cmdGetASales").linkbutton('enable');
                }

                if (rowData.cls_date == null || rowData.cls_date == '0000-00-00' || rowData.cls_date == '0000-00-00 00:00:00') {
                    $("#cmdDetail").removeAttr('disabled');
                    $('#cmdDetail').linkbutton('enable');
                    $("#closeOn").empty().append('<button type="button" id="cmdClose" title="<?php getCaption("Close"); ?>" class="easyui-linkbutton btn-cls" data-options="iconCls:\'icon-close\'"  onclick="rolesClose()">Close</button>');
                    $("#print").linkbutton('disable');
                    $("#screen").linkbutton('disable');
                    $("#download").linkbutton('disable');

                    $('#cmdClose').linkbutton();


                } else {
                    $("#cmdDetail").attr('disabled', true);
                    $('#cmdDetail').linkbutton('disable');
                    $("#closeOn").empty().append('<button type="button" id="cmdUnClose" title="<?php getCaption("unClose"); ?>" class="easyui-linkbutton btn-cls"  data-options="iconCls:\'icon-unclose\'" onclick="rolesUnclose()">Unclose</button>');

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
					
					$(".deletePPN").attr('disabled', true);
                    $(".deletePPN").linkbutton('disable');

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


        });
    }

    function doSearch() {
        $("#tableSearch").datagrid('load', {
            field1: $('#wo_no2').val(),
            field2: $('#wo_date2').datebox('getValue')
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
        var ids = $("#form_validation #id").val();
        var url = site_url + 'transaction/optional/outputpdf/<?php echo encrypt_decrypt('encrypt', 'acc_woh'); ?>/' + ids + '/<?php echo $_SESSION['C_USER']; ?>/' + key + '/<?php echo encrypt_decrypt('encrypt', 'wo_no'); ?>/<?php echo encrypt_decrypt('encrypt', 'AWO'); ?>#toolbar=0';

        if (key == 'print') {
            $("#screenWindow").empty().append('<iframe frameborder="0"  src="' + url + '" style="width:100%;height:auto;min-height: 500px;padding:0px;"></iframe>');
            // $("#screenWindow").window('open');
        }
        if (key == 'screen') {
            window.open(url);
        }
        if (key == 'download') {
            $("#screenWindow").empty().append('<iframe frameborder="0"  src="' + url + '" style="width:100%;height:auto;min-height: 500px;padding:0px;"></iframe>');
            // $("#screenWindow").window('open');
        }
    }

    function table_grid(ttable, wo_no) {

        ttable.datagrid({
            method: 'post',
            url: site_url + '<?php echo 'builder/datagrid/' . encrypt_decrypt('encrypt', 'acc_wod'); ?>/wo_no/' + wo_no + '/?grid=true',
            idField: 'id',
            fitColumns: false,
            singleSelect: true,
            nowrap: false,
            fit: false,
            rownumbers: true,
            pageSize: 10,
            showFooter: false,
            pagination: true,
            columns: [[
                    {field: 'wk_code', title: '<?php getCaption("Kode Pekerjaan"); ?>', width: 120, height: 20, sortable: true},
                    {field: 'wk_desc', title: '<?php getCaption("Nama Pekerjaan"); ?>', width: 360, height: 20, sortable: true},
                    {field: 'price_bd', title: '<?php getCaption("Harga Jual"); ?>', width: 120, height: 20, align: 'right', sortable: true, formatter: formatNumber},
                    {field: 'disc_pct', title: '<?php getCaption("Diskon"); ?> %', width: 120, height: 20, align: 'right', sortable: true, formatter: formatNumber},
                    {field: 'disc_val', title: '<?php getCaption("Jumlah Diskon"); ?>', width: 120, height: 20, align: 'right', sortable: true, formatter: formatNumber},
                    {field: 'price_ad', title: '<?php getCaption("Harga Netto"); ?>', width: 120, height: 20, align: 'right', sortable: true, formatter: formatNumber},
                    {field: 'wor_no', title: '<?php getCaption("No. SPOK"); ?>', width: 100, height: 20, align: 'right', sortable: true},
                    {field: 'wor_date', title: '<?php getCaption("Tgl. SPOK"); ?>', width: 100, height: 20, align: 'right', sortable: true, formatter: formatDate},
                    {field: 'wor_line', title: '<?php getCaption("Line No"); ?>', width: 100, height: 20, align: 'right', sortable: true},
                    {field: 'add_by', title: '<?php getCaption("Ditambahkan Oleh"); ?>', width: 100, height: 20, align: 'right', sortable: true}

                ]]
        });

        ttable.datagrid('reload');
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
		$('.deletePPN').removeAttr('disabled');

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
		$('.deletePPN').linkbutton('enable');
    }

    function condReady() {
        scrlTop();
        $(".easyui-datebox").datebox('enable');
        var wo_no = $("#form_validation #wo_no").val();

        if (wo_no == '') {
            wo_no = null;
        }

        table_grid(ttable, wo_no);


        $('#form_validation #wo_date, #cls_date, #so_date').datebox('disable');
        //$('#form_validation #po_type').combobox('enable');
        //$('#form_validation #inv_disc, #inv_stamp').numberbox({disabled: false});
        $('#form_validation #supp_name, #prep_name, #raddr_code, #curr_code, #chassis').combogrid('enable');
        $('#form_validation #quote_no, #due_day, #note, #note2, #note3, #note4, #po_type').attr('disabled', false);
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
		$('.deletePPN').attr('disabled', true);

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
		 $('.deletePPN').linkbutton('disable');
		
        $("#form_validation #cmdDetail").linkbutton('disable');
        $("#form_validation #cmdOptional").linkbutton('disable');
        $("#form_validation #cmdClose").linkbutton('disable');
        $("#form_validation #cmdUnClose").linkbutton('disable');
        $("#form_validation #print").linkbutton('disable');
        $("#form_validation #screen").linkbutton('disable');
        $("#form_validation #download").linkbutton('disable');
    }

    function condAdd() {

        $('#form_validation #id').val('');
        $('#form_validation input:text').val('');
        $("#form_validation #table").val(table);
        $('#form_validation .easyui-combogrid').combogrid('setValue', '');
        $('#form_validation .easyui-combobox').combobox('setValue', '');
        $(".easyui-datebox").datebox('setValue', '');
        $('#form_validation #opn_date').datebox('setValue', '<?php echo date('Y-m-d'); ?>');
        $("#form_validation .easyui-numberbox").numberbox('setValue', '');
        $.post(site_url + 'transaction/cashier/get_number/AWO', function (num) {
            $("#form_validation #wo_no").val(num);
        });
        condReady();


    }
    function condEdit() {
        condReady();
        // $("#chassis").combogrid('disable');
    }
    function condDelete() {
        var id = $("#form_validation #id").val();
        var table = $("#form_validation #table").val();
        $.messager.confirm('Warning', 'Do you really want to delete this record?', function (r) {
            if (r) {
                $('.loader').show();
                var url = delete_url;
                $.post(url, {table: table, id: id}, function (data) {

                    obj = JSON.parse(data);

                    if (obj.success == true) {
                        read_show('P');
                        showAlert("Information", obj.message);

                    } else
                    {
                        showAlert("Error while deleting", '<font color="red">' + obj.message + '</font>');
                        read_show('');
                        $('.loader').hide();
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
        scrlTop();
        var chassis = $("#form_validation #chassis").combogrid('getValue');

        if (chassis !== '') {
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
                                var so_no = $("#form_validation #so_no").val();
                                $.post(site_url + 'transaction/optional/check_dp', {table: 'veh_dpcd', so_no: so_no}, function (json) {
                                    var res = $.parseJSON(json);
                                    scrlTop();
                                    if (res.count == null) {
                                        showAlert("No Down payment yet", 'No Down payment yet');
                                    } else {
                                        showAlert("Downpayment Total", 'Down payment Total : ' + formatNumber(res.total));
                                    }
                                });
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
        } else {
            showAlert("Error while closing", '<font color="red">Please input Chassis No.</font>');
        }
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
            success: function (data) { //alert(data)
                var obj = JSON.parse(data);
                if (obj.success == true) {

                    showAlert("Information", obj.message);
                    scrlTop();
                    if (obj.status == 'update') {
                        read_show('');

                    } else {
                        read_show('');
                        // cmdDetails();
                        var sal_inv_no = $("#sal_inv_no").val();
                        $.post(site_url + 'transaction/optional/check_sld', {table: 'veh_sld', sal_inv_no: sal_inv_no}, function (res) {

                            if (res !== '0') {
                                get_spk();
                            }
                        });
                        //get_spk_aftersales();
                    }

                } else
                {
                    updateFailed(obj);
                }
                scrlTop();
            }
        });
    }


    /* Detail */
    function cmdDetails() {
        scrlTop();
        var chassis = $("#chassis").combogrid('getValue');

        if (chassis !== '') {

            var wo_no = $("#form_validation #wo_no").val();
            tableId2();
            read_show2('');

            table_grid(ttable2, wo_no);
            $("#DetailWindow").window('open');

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

        } else {
            showAlert("Information", '<font color="red">Chassis not empty.</font>');
        }
    }

    function get_aftersales() {
        var chassis = $("#form_validation #chassis").combogrid('getValue');
        var sal_inv_no = $("#form_validation #sal_inv_no").val();
        var spk_no = $("#form_validation #so_no").val();

        if (chassis !== '') {
            optional_aftersales(sal_inv_no);
        } else {
            $.messager.alert('Warning', 'All WO for After-Sales Optional in' + spk_no + ' has been made', 'warning');
        }

    }

    function get_spk() {
        var chassis = $("#form_validation #chassis").combogrid('getValue');
        var sal_inv_no = $("#form_validation #sal_inv_no").val();

        if (chassis !== '') {
            optional_spk(sal_inv_no);
        } else {
            showAlert("Information", 'This SPK No. is nowhere to be found');
        }
    }

    function optional_aftersales(sal_inv_no) {
        var url = site_url + 'transaction/optional/checkOptional';
        var spk_no = $("#form_validation #so_no").val();

        $.post(url, {sal_inv_no: sal_inv_no, tbl: 'acc_wsld'}, function (num) {
            var count = JSON.parse(num);
            if (count.count > 0) {
                $("#dt3").datagrid({
                    method: 'post',
                    title: 'Optional After-Sales : ' + spk_no,
                    url: site_url + '<?php echo 'transaction/optional/get_optional/' . encrypt_decrypt('encrypt', 'acc_wsld'); ?>/vsl_inv_no/' + sal_inv_no + '/?grid=true',
                    idField: 'id',
                    fitColumns: false,
                    singleSelect: false,
                    nowrap: false,
                    fit: false,
                    rownumbers: true,
                    pageSize: 10,
                    showFooter: false,
                    pagination: true,
                    columns: [[
                            {field: 'ck', checkbox: true},
                            {field: 'wk_code', title: '<?php getCaption("Kode Pekerjaan"); ?>', width: 120, height: 20, sortable: true},
                            {field: 'wk_desc', title: '<?php getCaption("Nama Pekerjaan"); ?>', width: 200, height: 20, sortable: true},
                            {field: 'price_bd', title: '<?php getCaption("Harga Jual"); ?>', width: 100, height: 20, align: 'right', sortable: true, formatter: formatNumber},
                            {field: 'disc_pct', title: '<?php getCaption("Diskon"); ?> %', width: 100, height: 20, align: 'right', sortable: true, formatter: formatNumber},
                            {field: 'disc_val', title: '<?php getCaption("Jumlah Diskon"); ?>', width: 100, height: 20, align: 'right', sortable: true, formatter: formatNumber},
                            {field: 'price_ad', title: '<?php getCaption("Harga Netto"); ?>', width: 100, height: 20, align: 'right', sortable: true, formatter: formatNumber}

                        ]]
                });

                $("#GetSPKWindow").window('open');
                $('#tbl_get').val('acc_wsld');
            } else {
                $.messager.alert('Warning', 'All WO for outstanding optional  in ' + spk_no + ' \’s has been made', 'warning');
            }
        });

    }
    function optional_spk(sal_inv_no) {
        scrlTop();
        var url = site_url + 'transaction/optional/checkOptional';
        var spk_no = $("#form_validation #so_no").val();

        $.post(url, {sal_inv_no: sal_inv_no, tbl: 'veh_sld'}, function (num) {
            var count = JSON.parse(num);
            if (count.count > 0) {
                var url_sld = site_url + '<?php echo 'transaction/optional/get_optional/' . encrypt_decrypt('encrypt', 'veh_sld'); ?>/sal_inv_no/' + sal_inv_no + '/?grid=true';
                
                $("#dt3").datagrid({
                    method: 'post',
                    title: 'Work Optional Outstanding SPK : ' + spk_no,
                    url:url_sld,
                    idField: 'id',
                    fitColumns: false,
                    singleSelect: false,
                    nowrap: false,
                    fit: false,
                    rownumbers: true,
                    pageSize: 10,
                    showFooter: false,
                    pagination: true,
                    columns: [[
                            {field: 'ck', checkbox: true},
                            {field: 'wk_code', title: '<?php getCaption("Kode Pekerjaan"); ?>', width: 120, height: 20, sortable: true},
                            {field: 'wk_desc', title: '<?php getCaption("Nama Pekerjaan"); ?>', width: 200, height: 20, sortable: true},
                            {field: 'price_bd', title: '<?php getCaption("Harga Jual"); ?>', width: 100, height: 20, align: 'right', sortable: true, formatter: formatNumber},
                            {field: 'disc_pct', title: '<?php getCaption("Diskon"); ?> %', width: 100, height: 20, align: 'right', sortable: true, formatter: formatNumber},
                            {field: 'disc_val', title: '<?php getCaption("Jumlah Diskon"); ?>', width: 100, height: 20, align: 'right', sortable: true, formatter: formatNumber},
                            {field: 'price_ad', title: '<?php getCaption("Harga Netto"); ?>', width: 100, height: 20, align: 'right', sortable: true, formatter: formatNumber}

                        ]]
                });

                $("#GetSPKWindow").window('open');

                $('#tbl_get').val('veh_sld');
            } else {
                alert('All WO for outstanding optional  in ' + spk_no + ' \’s has been made');
            }
        });

    }
    function  copy_optional() {
        var tbl_get = $('#tbl_get').val();
        //alert(tbl_get);return false;
        var rows = $('#dt3').datagrid('getSelections');
        var sal_inv_no = $("#form_validation #sal_inv_no").val();
        var wo_no = $("#wo_no").val();
        var url = site_url + 'transaction/optional/getSPKafterSaleOptional/' + wo_no + '/<?php echo $_SESSION['C_USER']; ?>';

        $.post(url, {data: rows, tbl: tbl_get,sal_inv_no:sal_inv_no}, function (data) { //alert(data)
            var obj = JSON.parse(data);

            if (obj.success !== false) {
                $("#GetSPKWindow").window('close');
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
        });
        // alert(rows);
    }
    function read_show2(nav) {
        var id = $("#id2").val();
        var wo_no = $("#form_validation #wo_no").val();
        $.post(site_url + 'crud/read/?wo_no=' + wo_no, {table: table2, nav: nav, id: id}, function (json) {

            $("#form_validation2 :input").val('');
            $("#form_validation2 .easyui-numberbox").numberbox('setValue', '');
            if (json !== '[]') {

                var rowData = $.parseJSON(json);

                $.each(rowData, function (i, v) {
                    $("#form_validation2 #" + i).val(v);

                    if (i == 'wk_code') {
                        $("#form_validation2 #" + i).combogrid('setValue', v);
                    }

                    if (i == 'price_bd' || i == 'disc_pct' || i == 'disc_val' || i == 'price_ad') {
                        $("#form_validation2 #" + i).numberbox('setValue', v);
                    }
                });
                // price_disc(rowData.qty, '', '');
                $("#id2").val(rowData.id);


            }
            table_grid(ttable2, wo_no);
            formDisabled2();
            cmdcondAwal2();

        });
    }

    function saveData2() {
        $('#cmdSave2').linkbutton('disable');
        var wo_no = $("#wo_no").val();
        var save_url2 = site_url + 'transaction/optional/save_wod/' + wo_no + '/<?php echo $_SESSION['C_USER']; ?>';
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
                    $('#cmdSave2').linkbutton('enable');
                    read_show2('');
                }
            }
        });
    }

    function condDelete2() {
        var wo_no = $("#form_validation #wo_no").val();
        var id = $("#id2").val();

        $.messager.confirm('Delete Confirmation', 'Do you really want to delete this record?', function (r) {
            if (r) {
                var url = site_url + 'transaction/optional/delete_wod';
                $.post(url, {table: table2, id: id}, function (data) {
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
        $('#form_validation2 #wk_code').attr('disabled', false);
        $('#form_validation2 #wk_desc').attr('disabled', false);
        $('#form_validation2 #price_bd').attr('disabled', false);
        $('#form_validation2 #disc_pct').attr('disabled', false);
        $('#form_validation2 #disc_val').attr('disabled', false);
        //$('#form_validation2 #price_ad').attr('disabled', false);

        $('#form_validation2 .easyui-combogrid').combogrid('enable');
        $('#form_validation2 .easyui-combobox').combobox({disabled: false});
        $('#form_validation2 #wk_code').focus();
        cmdcondAwal2();
        cmdcondReady2();


    }


    function parseCurrency(num) {
        return num.replace(/[^0-9]/g, '');
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
        $('#form_validation2 .easyui-numberbox').numberbox('setValue', '');
        var chassis = $("#form_validation #chassis").combogrid('getValue');
        if (chassis !== '') {
            $.messager.alert('Warning', 'Only SUPERVISOR users are allowed to add detail(s) if chassis no. attached. Please use Get SPK or Get After Sales button to add detail to this invoice', 'warning');
        } else {
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

            $('#form_validation2 #price_bd').keyup(function () {
                var disc = parseCurrency($('#form_validation2 #disc_pct').val());
                var harga = parseCurrency($(this).val());
                var jml_disc = (parseCurrency($(this).val()) / 100) * disc;

                if (parseInt(jml_disc) > parseInt(harga)) {
                    $.messager.alert('Warning', 'Diskon tidak boleh melibihi harga awal!', 'warning');
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
                    $.messager.alert('Warning', 'Diskon tidak boleh melibihi harga awal!', 'warning');
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
                    $.messager.alert('Warning', 'Discount value has to be lower than Unit Price', 'warning');
                    $('#form_validation2 #disc_val').numberbox('setValue', '0');
                } else {
                    var disc = (jml_disc * 100) / harga;
                    var total = harga - jml_disc;

                    $('#form_validation2 #disc_pct').val(disc);
                    $('#form_validation2 #price_ad').numberbox('setValue', total);
                }
            });
        }
    }
    function condEdit2() {
        showAlert("Message", '<font color="red">Record(s) can\'t be edited. To edit this record, please delete it and add a new record</font>');
    }

    function tableId2() {
        divtableId2.empty().append('<input type="hidden" name="id2"  id="id2"><input type="hidden" name="table2"  id="table2" value="' + table2 + '">');
    }
    /*End Detail*/
	
	function deletePPN(){
		$.messager.confirm('Warning', 'Do you really want to delete this VAT?', function (r) {
            if (r) {
                	var inv_bt = $("#form_validation #inv_bt").numberbox('getValue');
					var inv_vat = 0;
					var inv_at = parseInt(inv_bt) + parseInt(inv_vat);
					var inv_stamp = $("#form_validation #inv_stamp").numberbox('getValue');
					var inv_total = parseInt(inv_at) + parseInt(inv_stamp);
					
					$("#form_validation #inv_vat").numberbox('setValue', inv_vat);
					$("#form_validation #inv_at").numberbox('setValue', inv_at);
					$("#form_validation #inv_total").numberbox('setValue', inv_total);
					
					saveData();
            }else{
                $('#cmdDelete').linkbutton('enable');
            }
        });
		
	}

    $(document).ready(function () {
        checkRunMonthYear('AWO');
        tableId();
        dateTop();
        read_show('')
        version('03.17-31');
    });
</script>