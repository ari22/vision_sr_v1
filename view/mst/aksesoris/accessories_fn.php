
<script>
    $(document).ready(function () {
        read_show('');
        version('01.04-17');
    });
    var table = 'acc_mst';
    var pk = 'part_code';
    var sk = 'part_name';
    var part_code = $("#part_code").val();



    function parsePrice(number) {
        return Number(number.replace(/[^0-9\.]+/g, ""));
    }

    function ppn() {
        var nominal = parsePrice($("#sal_price").val());
        var ppn = (nominal / 100) * 10;

        var total = nominal + ppn;
        $('#salvat').numberbox('setValue', total);
    }
    function detail() {
        $('#detailW').window('open');
        var part_code = $("#form_validation  #part_code").val();
        var part_name = $("#form_validation #part_name").val();
        $('#form_validation2 #part_code').val(part_code).attr('disabled', true);
        $('#form_validation2 #part_name').val(part_name).attr('disabled', true);
        $("#id2").val('');
        read_show2('')
    }

    function search_wrhs() {
        $("#windowWrhs").window('open');
        var table2 = 'maccs'

        $("#tableWrhs").datagrid({
            method: 'post',
            url: site_url + 'builder/table_grid/grid/' + table2 + '/?grid=true',
            idField: 'id',
            fitColumns: false,
            singleSelect: true,
            nowrap: true,
            fit: false,
            rownumbers: false,
            pageSize: 20,
            showFooter: true,
            pagination: true,
            columns: [[
                    {field: 'part_code', title: '<?php getCaption("No. Part"); ?>', width: 120, height: 20, sortable: true},
                    {field: 'part_name', title: '<?php getCaption("Nama Part"); ?>', width: 120, height: 20, sortable: true},
                    {field: 'wrhs_code', title: '<?php getCaption("Warehouse"); ?>', width: 140, height: 20, sortable: true},
                    {field: 'location', title: '<?php getCaption("Lokasi"); ?>', width: 120, height: 20, sortable: true},
                    {field: 'unit', title: '<?php getCaption("Satuan"); ?>', width: 60, height: 20, sortable: true},
                    {field: 'unit_price', title: '<?php getCaption("Quantity"); ?>', width: 160, height: 20, sortable: true},
                    {field: 'total', title: '<?php getCaption("Harga Jual + PPN"); ?>', width: 80, height: 20, sortable: true},
                    {field: 'grp_code', title: '<?php getCaption("Group"); ?>', width: 180, height: 20, sortable: true},
                    {field: 'sgrp_code', title: '<?php getCaption("Sub Group"); ?>', width: 140, height: 20, sortable: true},
                    {field: 'abc_group', title: '<?php getCaption("ABC Group"); ?>', width: 120, height: 20, sortable: true}
                ]]
        });

    }


    function closeWindow() {
        $('.easyui-window').window('close');
        read_show('');
    }

    function table_grid() {
        var table2 = 'maccs'
        var part_code = $("#part_code").val();

        $("#dt_table").datagrid({
            method: 'post',
            url: site_url + 'builder/table_grid/grid/' + table2 + '/' + part_code + '/?grid=true',
            idField: 'id',
            fitColumns: false,
            singleSelect: true,
            nowrap: true,
            fit: false,
            rownumbers: false,
            pageSize: 20,
            showFooter: true,
            pagination: true,
            columns: [[
                    {field: 'wrhs_code', title: 'Warehouse', width: 100, height: 20, sortable: true},
                    {field: 'location', title: 'Location', width: 100, height: 20, sortable: true},
                    {field: 'qty', title: 'Qty', width: 60, height: 20, sortable: true, formatter: formatNumber, align: 'right'},
                    {field: 'qty_pick', title: 'Qty (Picked)', width: 85, height: 20, sortable: true, formatter: formatNumber, align: 'right'},
                    {field: 'unit', title: 'Unit', width: 50, height: 20, sortable: true},
                    {field: 'unit_price', title: 'Sale Price/Unit', width: 100, height: 20, sortable: true, formatter: formatNumber, align: 'right'},
                    {field: 'qty_order', title: 'Qty (Order)', width: 85, height: 20, sortable: true, formatter: formatNumber, align: 'right'},
                    {field: 'qty_border', title: 'Qty (B.O)', width: 85, height: 20, sortable: true, formatter: formatNumber, align: 'right'},
                    {field: 'last_sold', title: 'Last Sold', width: 100, height: 20, sortable: true, formatter: formatDate},
                    {field: 'brand_code', title: 'Brand', width: 90, height: 20, sortable: true},
                    {field: 'use4_code', title: 'Used for', width: 90, height: 20, sortable: true},
                    {field: 'mdin_code', title: 'Made in', width: 90, height: 20, sortable: true}
                ]]
        });


    }

    function read_show(nav) { //alert('hell')
        var id = $("#id").val();

        $.post(site_url + 'master/vehicle/read', {table: table, nav: nav, id: id}, function (json) {

            cmdcondAwal();
            formDisabled();
            $('#form_validation input:text').val('');
            $('#form_validation textarea').val('');
            $('#form_validation .easyui-combogrid').combogrid('setValue', '');
            $("#form_validation input:radio").prop("checked", false);
            $(".easyui-datebox").datebox('setValue', '');

            if (json !== '[]') {

                var rowData = $.parseJSON(json);

                $('#form_validation').form('load', {
                    part_code: rowData.part_code,
                    part_name: rowData.part_name,
                    part_alias: rowData.part_alias,
                    unit: rowData.unit,
                    qty: rowData.qty,
                    qty_pick: rowData.qty_pick,
                    qty_order: rowData.qty_order,
                    qty_border: rowData.qty_border,
                    sal_price: rowData.sal_price,
                    //salvat: rowData.salvat,
                    brand_code: rowData.brand_code,
                    mdin_code: rowData.mdin_code,
                    use4_code: rowData.use4_code,
                    // input_date: rowData.input_date,
                    note: rowData.note
                });
                $("#id").val(rowData.id);

                if (rowData.input_date !== '0000-00-00') {
                    var vdate = dateSplit(rowData.input_date);

                    $("#input_date").datebox('setValue', vdate);
                }

                var price = parsePrice(rowData.sal_price);
                var salvat = price + ((price / 100) * 10);

                $('#salvat').numberbox('setValue', salvat);
                table_grid();
            }else {
                cmdcondAwal();
                cmdEmptyData();
            }

            $('.loader').hide();

        });
    }

    function doSearch() {
        $("#tableSearch").datagrid('load', {
            field1: $('#code').val(),
            field2: $('#name').val()
        });
    }
    function getSearchselect() {
        var row = $("#tableSearch").datagrid('getSelected');

        if (row) {
            $("#form_validation #id").val(row.id);
            $('#windowSearch').window('close');
            $("#actionSearch").empty()

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
        $('.easyui-combogrid').combogrid('disable');
        $('.easyui-combobox').combobox({disabled: true});
        $('.combo-text').removeClass('validatebox-text');
        $('.combo-text').removeClass('validatebox-invalid');
        $(".easyui-datebox").datebox('disable');
        cmdcondAwal();
        $("#field1").attr('disabled', false);
        $("#field2").attr('disabled', false);
    }

    function saveData() {
        var url = site_url + 'master/vehicle/save_accesories';
        $('#form_validation :input').attr('disabled', false);
        $('.loader').show();
        $('#form_validation').form('submit', {
            url: url,
            onSubmit: function () {
                return $(this).form('validate');
            },
            success: function (data) { //alert(data)

                var obj = JSON.parse(data);
                if (obj.success == true) {
                    showAlert("Information", obj.message);
                    cmdcondAwal();
                    formDisabled();
                    read_show('');
                    // $('#dt').datagrid('reload');
                } else
                {
                    $('.loader').hide();
                    showAlert("Error while saving", '<font color="red">' + obj.message + '</font>');
                }
            }
        });
    }
    function cmdcondAwal() {
        $('#cmdFirst').removeAttr('disabled');
        $('#cmdPrev').removeAttr('disabled');
        $('#cmdNext').removeAttr('disabled');
        $('#cmdLast').removeAttr('disabled');
        $('#cmdSave').attr('disabled', true);
        $('#cmdCancel').attr('disabled', true);
        $('#cmdAdd').removeAttr('disabled');
        $('#cmdEdit').removeAttr('disabled');
        $('#cmdDelete').removeAttr('disabled');
        $('#cmdSearch').removeAttr('disabled');

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

        $('#detail').linkbutton('enable');
        $('#searchwrhs').linkbutton('enable');
        $('#substitusi').linkbutton('enable');

        $('.cmdRefresh').removeAttr('disabled');
        $('.cmdRefresh').linkbutton('enable');
    }

    function condReady() {
        $(".easyui-datebox").datebox('enable');
        $(':input').attr('disabled', false);
        $('#qty').attr('disabled', true);
        $('#qty_pick').attr('disabled', true);
        $('#qty_order').attr('disabled', true);
        $('#qty_border').attr('disabled', true);
        $("#salvat").attr('disabled', true);
        $('.easyui-combogrid').combogrid('enable');

        cmdcondReady();
    }

    function cmdcondReady() {
        //$("#cmdSave").show();
        //$("#cmdCancel").show();
        $('#cmdFirst').attr('disabled', true);
        $('#cmdPrev').attr('disabled', true);
        $('#cmdNext').attr('disabled', true);
        $('#cmdLast').attr('disabled', true);

        $('#cmdSave').removeAttr('disabled');
        $('#cmdCancel').removeAttr('disabled');
        //$("#cmdSave").removeAttr('disabled');
        //$("#cmdCancel").removeAttr('disabled');
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

        $('#detail').linkbutton('disable');
        $('#searchwrhs').linkbutton('disable');
        $('#substitusi').linkbutton('disable');
    }

    function condAdd() {

        $('#id').val('');
        $(':input').val('');
        $("#table").val(table);
        $("#input_date").datebox('setValue', '<?php echo date('Y-m-d'); ?>');
        condReady();

        table_grid();
    }
    function condEdit() {
        cmdcondReady();
        condReady();
        $("#part_code").attr('disabled', true);
        $('#part_name').focus();
        table_grid();
    }
    function condDelete() {
        var id = $("#id").val();
        var table = $("#table").val();

        $.messager.confirm('Warning', 'Are you sure delete selected data ?', function (r) {
            if (r) {

                var url = site_url + 'master/vehicle/delete_accesories';
                $('.loader').show();
                $.post(url, {table: table, id: id}, function (data) {//alert(data)
                    var obj = JSON.parse(data);
                    if (obj.success == true) {
                        $("#id").val('');
                        showAlert("Information", obj.message);
                        cmdcondAwal();
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
    function condCancel() {
        cmdcondAwal();
        read_show('');
        $(".formError").remove();
    }


    /*Function Detail*/
    function read_show2(nav) { //alert('hell')
        var id = $("#id2").val();
        var part_code = $("#form_validation #part_code").val();

        $.post(site_url + 'master/vehicle/read', {table: 'maccs', nav: nav, id: id, field: 'part_code', val: part_code}, function (json) {
            $('#form_validation2 input:text').val('');
            $('#form_validation2 textarea').val('');
            $('#form_validation2 .easyui-combogrid').combogrid('setValue', '');
            $("#form_validation2 input:checkbox").prop("checked", false);
            $("#form_validation2 .easyui-datebox").datebox('setValue', '');

            cmdcondAwal2();

            if (json !== '[]') {

                var rowData = $.parseJSON(json);
                
                if (rowData.prt_inact == '1') {
                    $("#prt_inact").prop("checked", true);
                } else {
                    $("#prt_inact").prop("checked", false);
                }

                $('#form_validation2').form('load', {
                    part_code: rowData.part_code,
                    part_name: rowData.part_name,
                    wrhs_code: rowData.wrhs_code,
                    location: rowData.location,
                    qty: rowData.qty,
                    qty_pick: rowData.qty_pick,
                    qty_order: rowData.qty_order,
                    qty_border: rowData.qty_border,
                    sal_price: rowData.sal_price,
                    salvat: rowData.salvat,
                    brand_code: rowData.brand_code,
                    mdin_code: rowData.mdin_code,
                    use4_code: rowData.use4_code,
                    min_qty: rowData.min_qty,
                    max_qty: rowData.max_qty,
                    unit: rowData.unit,
                    sal_price: rowData.sal_price,
                            //last_sold: rowData.last_sold,
                            grp_code: rowData.grp_code,
                    sgrp_code: rowData.sgrp_code,
                    abc_group: rowData.abc_group,
                    note: rowData.note,
                    pur_price: rowData.pur_price,
                    pur_disc: rowData.pur_disc,
                    purl_price: rowData.purl_price,
                    aver_price: rowData.aver_price,
                    //last_sold:rowData.last_sold,
                    price_end: rowData.price_end
                });
                $("#id2").val(rowData.id);


                if (rowData.last_sold !== '0000-00-00') {
                    var vdate = dateSplit(rowData.last_sold);

                    $("#last_sold").datebox('setValue', vdate);
                }
                if (rowData.last_pur !== '0000-00-00') {
                    var vdate = dateSplit(rowData.last_pur);

                    $("#form_validation2 #last_pur").datebox('setValue', vdate);
                }

                var price2 = parsePrice(rowData.sal_price);
                var tax2 = (price2 / 100) * 10;
                var total = price2 + tax2;
                $('#salvat2').numberbox('setValue', total);
                $('#price_end').numberbox('setValue', rowData.purl_price);
            } else {

                $('.cmdEdit2').linkbutton('disable');
                $('#cmdEdit2').Attr('disabled');
            }



            formDisabled2();


        });
    }

    function ppn2() {
        var price1 = parsePrice($("#form_validation2 #sal_price").val());
        var tax1 = (price1 / 100) * 10;

        var total = price1 + tax1;
        $('#salvat2').numberbox('setValue', total);
    }

    function formDisabled2() {
        $('#form_validation2 :input').attr('disabled', true);

        $('#form_validation2 .easyui-combogrid').combogrid('disable');
        $('#form_validation2 .easyui-combobox').combobox({disabled: true});
        $('#form_validation2 .combo-text').removeClass('validatebox-text');
        $('#form_validation2 .combo-text').removeClass('validatebox-invalid');

        cmdcondAwal2();

    }

    function saveData2() {
        var url = site_url + 'master/vehicle/save_accesories';

        $('#form_validation2 :input').attr('disabled', false);

        $('#form_validation2').form('submit', {
            url: url,
            onSubmit: function () {
                return $(this).form('validate');
            },
            success: function (data) { 

                var obj = JSON.parse(data);
                if (obj.success == true) {
                    showAlert("Information", obj.message);
                    cmdcondAwal2();
                    formDisabled2();

                    read_show2('');
                    table_grid();
                } else
                {
                    condReady2();
                    showAlert("Error while saving", '<font color="red">' + obj.message + '</font>');
                }
            }
        });
    }

    function diskon_price() {
        var pur_price = parsePrice($("#form_validation2 #pur_price").val());
        var discount = parsePrice($("#form_validation2 #pur_disc").val());
        var result = (pur_price / 100) * discount;

        var price_res = pur_price - result;

        $('#purl_price').numberbox('setValue', price_res);
        $('#price_end').numberbox('setValue', price_res);

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

        $('.cmdFirst2').linkbutton('enable');
        $('.cmdPrev2').linkbutton('enable');
        $('.cmdNext2').linkbutton('enable');
        $('.cmdLast2').linkbutton('enable');
        $('.cmdSave2').linkbutton('disable');
        $('.cmdCancel2').linkbutton('disable');
        $('.cmdAdd2').linkbutton('enable');
        $('.cmdEdit2').linkbutton('enable');
        $('.cmdDelete2').linkbutton('enable');
        $('.cmdSearch2').linkbutton('enable');

        $("#form_validation2 #ok").removeAttr('disabled');
        $("#form_validation2 #ok").linkbutton('enable');
    }

    function condReady2() {
        $("#last_pur").datebox('enable');
        $('#form_validation2 :input').attr('disabled', false);
        $('#form_validation2 #qty').attr('disabled', true);
        $('#form_validation2 #qty_pick').attr('disabled', true);
        $('#form_validation2 #qty_order').attr('disabled', true);
        $('#form_validation2 #qty_border').attr('disabled', true);
        $("#form_validation2 #salvat2").attr('disabled', true);
        $("#form_validation2 #price_end").attr('disabled', true);
        $('#form_validation2 .easyui-combogrid').combogrid('enable');

        $('#form_validation2 #unit').combogrid('disable');

        $("#form_validation2 #brand_code").combogrid('disable');
        $("#form_validation2 #mdin_code").combogrid('disable');
        $("#form_validation2 #use4_code").combogrid('disable');
        $("#form_validation2 #last_sold").datebox('disable');
        $('#form_validation2 #purl_price').attr('disabled', true);
        $('#form_validation2 #aver_price').attr('disabled', true);
        /*
         * 
         * @type @call;$@call;val
         */


        var part_code = $("#form_validation  #part_code").val();
        var part_name = $("#form_validation #part_name").val();
        var unit = $("#form_validation #unit").combogrid('getValue');
        var brand = $("#form_validation #brand_code").combogrid('getValue');
        var madin = $("#form_validation #mdin_code").combogrid('getValue');
        var use4 = $("#form_validation #use4_code").combogrid('getValue');


        $('#form_validation2 #part_code').val(part_code).attr('disabled', true);
        $('#form_validation2 #part_name').val(part_name).attr('disabled', true);

        $('#form_validation2 #unit').combogrid('setValue', unit);
        $('#form_validation2 #brand_code').combogrid('setValue', brand);
        $('#form_validation2 #mdin_code').combogrid('setValue', madin);
        $('#form_validation2 #use4_code').combogrid('setValue', use4);

        checkboxClick();
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

        $('.cmdFirst2').linkbutton('disable');
        $('.cmdPrev2').linkbutton('disable');
        $('.cmdNext2').linkbutton('disable');
        $('.cmdLast2').linkbutton('disable');

        $('.cmdSave2').linkbutton('enable');
        $('.cmdCancel2').linkbutton('enable');

        $('.cmdAdd2').linkbutton('disable');
        $('.cmdEdit2').linkbutton('disable');
        $('.cmdDelete2').linkbutton('disable');
        $('.cmdSearch2').linkbutton('disable');

        $("#form_validation2 #ok").attr('disabled', true);
        $("#form_validation2 #ok").linkbutton('disable');
    }

    function condAdd2() {
        $("#form_validation2 .easyui-datebox").datebox('enable');
        $('#id2').val('');
         $('#form_validation2 .easyui-combogrid').combogrid('setValue', '');
         $('#form_validation2 .easyui-combobox').combobox('setValue', '');
        $('#form_validation2 input:text').val('');
        $("#table2").val('maccs');

        var sal_price = $('#form_validation #sal_price').numberbox('getValue');
        var salvat = $('#form_validation #salvat').numberbox('getValue');

        $('#form_validation2 #sal_price').numberbox('setValue', sal_price);
        $('#form_validation2 #salvat2').numberbox('setValue', salvat);
        //alert(sal_price)
        condReady2();


    }
    function condEdit2() {
        cmdcondReady2();
        condReady2();
        var qty = $("#form_validation2 #qty").numberbox('getValue');
        var qty_pick = $("#form_validation2 #qty_pick").numberbox('getValue');
        var qty_order = $("#form_validation2 #qty_order").numberbox('getValue');
        var qty_border = $("#form_validation2 #qty_border").numberbox('getValue');

        var stat = true;

        if (qty !== 0) {
            var stat = false;
        }
        if (qty_pick !== 0) {
            var stat = false;
        }
        if (qty_order !== 0) {
            var stat = false;
        }
        if (qty_border !== 0) {
            var stat = false;
        }

        if (stat == false) {
            $("#form_validation2 #wrhs_code").combogrid('disable');
        }

        $("#table2").val('maccs');
    }
    function condDelete2() {
        var id = $("#id2").val();
        var table = $("#table2").val();

        $.messager.confirm('Warning', 'Are you sure delete selected data ?', function (r) {
            if (r) {

                var url = site_url + 'master/vehicle/delete';

                $.post(url, {table: table, id: id}, function (data) {//alert(data)
                    var obj = JSON.parse(data);
                    if (obj.success == true) {
                        $("#id2").val('');
                        showAlert("Information", obj.message);
                        cmdcondAwal2();
                        read_show2('');
                        table_grid();
                    } else
                    {
                        showAlert("Error while delete", '<font color="red">' + obj.message + '</font>');
                    }
                });

            }
        });
    }
    function condCancel2() {
        $('#form_validation2 :input').val('');
        cmdcondAwal2();
        read_show2('');
        $(".formError").remove();
    }
    /*End Function Detail*/

    /*Start Function Substitution*/

    function substitution() {
        $("#substitusiW").window('open');
        table_substitution();
        read_show3('');
    }

    function table_substitution() {
        var part_code = $("#form_validation #part_code").val();
        $("#dt_substitution").datagrid({
            method: 'post',
            url: site_url + 'builder/grid_substitusi/acc_subs/acc_mst/part_code1/' + part_code + '/?grid=true',
            idField: 'id',
            fitColumns: true,
            singleSelect: true,
            nowrap: true,
            fit: false,
            rownumbers: false,
            pageSize: 20,
            showFooter: true,
            pagination: true,
            columns: [[
                    {field: 'part_code', title: '<?php getCaption('Kode Barang'); ?>', width: 120, height: 20, sortable: true},
                    {field: 'part_name', title: '<?php getCaption('Nama Barang'); ?>', width: 200, height: 20, sortable: true},
                    {field: 'sal_price', title: '<?php getCaption('Harga Jual'); ?>', width: 100, height: 20, sortable: true, align: 'right', formatter: formatNumber},
                    {field: 'qty', title: 'Qty', width: 100, height: 20, sortable: true, align: 'right', formatter: formatNumber},
                    {field: 'qty_pick', title: 'Qty Pick', width: 100, height: 20, sortable: true, align: 'right', formatter: formatNumber},
                    {field: 'unit', title: '<?php getCaption('Satuan'); ?>', width: 100, height: 20, sortable: true}
                ]]
        });


        $('#dt_substitution').datagrid({
            onSelect: function (rowIndex, rowData) {
                /* $("#<?php echo $field1->name; ?>").val(rowData.<?php echo $field1->name; ?>);
                 $("#<?php echo $field2->name; ?>").val(rowData.<?php echo $field2->name; ?>);
                 $("#id").val(rowData.id);
                 lnRecNo = rowData.id;
                 */
            }
        });

    }
    function read_show3(nav) { //alert('hell')
        var id = $("#id3").val();
        var partcode = $("#part_code").val();


        $.post(site_url + 'master/vehicle/read', {table: 'acc_subs', nav: nav, id: id, field: 'part_code1', val: partcode}, function (res) {
            $('#form_validation3 :input').val('');
            if (res !== '[]') {

                var row = $.parseJSON(res);

                $.post(site_url + 'master/vehicle/read', {table: 'acc_mst', nav: nav, id: '', field: 'part_code', val: row.part_code2}, function (json) {
                    var rowData = $.parseJSON(json);

                    $('#form_validation3').form('load', {
                        part_code2: rowData.part_code,
                        part_name: rowData.part_name,
                        sal_price: rowData.sal_price,
                        qty: rowData.qty,
                        qty_pick: rowData.qty_pick,
                        unit: rowData.unit
                    });

                });

                $("#id3").val(row.id);


            }


            cmdcondAwal3();
            formDisabled3();


        });
    }



    function formDisabled3() {
        $('#form_validation3 :input').attr('disabled', true);

        $('#form_validation3 .easyui-combogrid').combogrid('disable');
        $('#form_validation3 .easyui-combobox').combobox({disabled: true});
        $('#form_validation3 .combo-text').removeClass('validatebox-text');
        $('#form_validation3 .combo-text').removeClass('validatebox-invalid');

        cmdcondAwal3();

    }

    function saveData3() {
        var url = site_url + 'master/vehicle/save_subs';
        var part1 = $("#form_validation #part_code").val();
        var part2 = $("#form_validation3 #part_code_copy").val();

        $.post(url, {part1: part1, part2: part2, table: 'acc_subs'}, function (data) {

            var obj = JSON.parse(data);
            if (obj.success == true) {
                showAlert("Information", obj.message);
                cmdcondAwal3();
                formDisabled3();

                read_show3('');
                table_substitution();
            } else
            {
                condReady3();
                showAlert("Error while saving", '<font color="red">' + obj.message + '</font>');
            }
        });


    }


    function cmdcondAwal3() {
        $('#cmdFirst3').removeAttr('disabled');
        $('#cmdPrev3').removeAttr('disabled');
        $('#cmdNext3').removeAttr('disabled');
        $('#cmdLast3').removeAttr('disabled');
        $('#cmdSave3').attr('disabled', true);
        $('#cmdCancel3').attr('disabled', true);
        $('#cmdAdd3').removeAttr('disabled');
        $('#cmdEdit3').removeAttr('disabled');
        $('#cmdDelete3').removeAttr('disabled');
        $('#cmdSearch3').removeAttr('disabled');

        $('#cmdFirst3').linkbutton('enable');
        $('#cmdPrev3').linkbutton('enable');
        $('#cmdNext3').linkbutton('enable');
        $('#cmdLast3').linkbutton('enable');
        $('#cmdSave3').linkbutton('disable');
        $('#cmdCancel3').linkbutton('disable');
        $('#cmdAdd3').linkbutton('enable');
        $('#cmdEdit3').linkbutton('enable');
        $('#cmdDelete3').linkbutton('enable');
        $('#cmdSearch3').linkbutton('enable');

        $("#form_validation3 #ok").removeAttr('disabled');
        $("#form_validation3 #ok").linkbutton('enable');
    }

    function condReady3() {
        $('#form_validation3 .easyui-combogrid').combogrid('enable');
        cmdcondReady3();
    }

    function cmdcondReady3() {
        //$("#cmdSave").show();
        //$("#cmdCancel").show();
        $('#cmdFirst3').attr('disabled', true);
        $('#cmdPrev3').attr('disabled', true);
        $('#cmdNext3').attr('disabled', true);
        $('#cmdLast3').attr('disabled', true);

        $('#cmdSave3').removeAttr('disabled');
        $('#cmdCancel3').removeAttr('disabled');
        //$("#cmdSave").removeAttr('disabled');
        //$("#cmdCancel").removeAttr('disabled');
        $('#cmdAdd3').attr('disabled', true);
        $('#cmdEdit3').attr('disabled', true);
        $('#cmdDelete3').attr('disabled', true);
        $('#cmdSearch3').attr('disabled', true);

        $('#cmdFirst3').linkbutton('disable');
        $('#cmdPrev3').linkbutton('disable');
        $('#cmdNext3').linkbutton('disable');
        $('#cmdLast3').linkbutton('disable');

        $('#cmdSave3').linkbutton('enable');
        $('#cmdCancel3').linkbutton('enable');

        $('#cmdAdd3').linkbutton('disable');
        $('#cmdEdit3').linkbutton('disable');
        $('#cmdDelete3').linkbutton('disable');
        $('#cmdSearch3').linkbutton('disable');

        $("#form_validation3 #ok").attr('disabled', true);
        $("#form_validation3 #ok").linkbutton('disable');

    }

    function condAdd3() {
        $("#form_validation3 .easyui-datebox").datebox('enable');
        $('#id3').val('');

        $('#form_validation3 :input').val('');
        $("#table3").val(table);
        condReady3();


    }
    function condEdit3() {
        cmdcondReady3();
        condReady3();

    }
    function condDelete3() {
        var id = $("#id3").val();
        if (id !== '') {
            $.messager.confirm('Warning', 'Are you sure delete selected data ?', function (r) {
                if (r) {

                    var url = site_url + 'master/vehicle/delete';

                    $.post(url, {table: 'acc_subs', id: id}, function (data) {//alert(data)
                        var obj = JSON.parse(data);
                        if (obj.success == true) {
                            $("#id3").val('');
                            showAlert("Information", obj.message);
                            cmdcondAwal3();
                            read_show3('');
                            table_substitution();
                        } else
                        {
                            showAlert("Error while delete", '<font color="red">' + obj.message + '</font>');
                        }
                    });

                }
            });
        }
    }
    function condCancel3() {
        $('#form_validation3 :input').val('');
        cmdcondAwal3();
        read_show3('');
        $(".formError").remove();
    }

    $('#form_validation3 #part_code2').combogrid({
        onSelect: function (index, row) {

            $("#form_validation3 #part_code_copy").val(row.part_code);
            $("#form_validation3 #part_name").val(row.part_name);
            $('#form_validation3 #sal_price').numberbox('setValue', row.sal_price);
            $('#form_validation3 #qty').numberbox('setValue', row.qty);
            $('#form_validation3 #qty_pick').numberbox('setValue', row.qty_pick);
            $('#form_validation3 #unit').val(row.unit);

        }
    });
    /*END Function Substitution*/

    function cmdRef(field) {
        var part_code = $("#form_validation #part_code").val();
        var num = 0;
        
        $.post(site_url + 'master/vehicle/refreshQty', {part_code: part_code}, function (json) {

            var val = $.parseJSON(json);
            
            if(field == 'qty'){
                num = val.qty;
            }
            if(field == 'qty_pick'){
                num = val.qty_pick;
            }
            if(field == 'qty_order'){
                num = val.qty_order;
            }
            if(field == 'qty_border'){
               num = val.qty_border;
            }
            
            $('#form_validation #'+field).numberbox('setValue', num);

        });

    }
</script>