<script>

    var table = 'acc_poh';
    var form = $('#form_validation');
    var save_url = site_url + 'transaction/accessories/saveAccessories/<?php echo $_SESSION['C_USER']; ?>';
    var unclose_url = site_url + 'transaction/accessories/unclosePO/<?php echo $_SESSION['C_USER']; ?>';
    var close_url = site_url + 'transaction/accessories/closePO/<?php echo $_SESSION['C_USER']; ?>';

    var divtableId = $("#tableId");
    var ttable = $('#dt');

    var table2 = 'acc_pod';
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

    $('#form_validation2 #part_code').combogrid({
        onSelect: function (index, row) {
            $("#form_validation2 #id3").val(row.id);
             $("#form_validation2 #location").val(row.location);
            $("#form_validation2 #part_name").val(row.part_name);
            $("#form_validation2 #wrhs_code").val(row.wrhs_code);
            $("#form_validation2 #unit").val(row.unit);
            $("#price_bd").numberbox('setValue', row.pur_price);
            $("#disc_pct").numberbox('setValue', row.pur_disc);

            price_disc('', '', '');
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

                    if (i == 'po_date' || i == 'opn_date' || i == 'due_date' || i == 'cls_date' || i == 'quote_date' || i == 'prcvd_date') {
                        if (v !== '0000-00-00') {
                           var v_date = dateSplit(v);
                            $("#" + i).datebox('setValue', v_date);
                        }

                    }
                    if (i == 'supp_name' || i == 'prep_name' || i == 'raddr_code' || i == 'curr_code') {
                        $("#form_validation #" + i).combogrid('setValue', v);
                    }
                    if (i == 'tot_price' || i == 'inv_disc' || i == 'inv_bt' || i == 'inv_vat' || i == 'inv_at' || i == 'inv_stamp' || i == 'inv_total'|| i =='due_day') {
                        $("#form_validation #" + i).numberbox('setValue', v);
                    }
                    /*
                     if (i == 'po_type') {                       
                     $("#form_validation #" + i).combobox('setValue', v);                      
                     }
                     */
                });


                //$("#po_type").combobox('setValue', rowData.po_type);
                cmdcondAwal();
                formDisabled();
				
				if(rowData.inv_vat == 0){ 
					$(".deletePPN").attr('disabled', true);
                    $(".deletePPN").linkbutton('disable');
				}

                var po_no = rowData.po_no;
                table_grid(ttable, po_no);

                if (rowData.cls_date == null || rowData.cls_date == '0000-00-00' || rowData.cls_date == '0000-00-00 00:00:00') {
                    $("#cmdDetail").removeAttr('disabled');
                    $('#cmdDetail').linkbutton('enable');
                    $("#closeOn").empty().append('<button type="button" id="cmdClose" title="<?php getCaption("Close"); ?>" class="easyui-linkbutton btn-cls"  data-options="iconCls:\'icon-close\'"  onclick="rolesClose()">Close</button>');
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

                    $(".btn-pick").linkbutton('disable');
                    $("#cmdEdit").attr('disabled', true);
                    $("#cmdDelete").attr('disabled', true);
                    $("#cmdEdit").linkbutton('disable');
                    $("#cmdDelete").linkbutton('disable');
					$(".deletePPN").attr('disabled', true);
                    $(".deletePPN").linkbutton('disable');
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
            //toolbar:'#actionSearch',
            columns: [[
                    {field: 'po_no', title: '<?php getCaption("No. PO"); ?> ', width: 150, height: 20, sortable: true},
                    {field: 'po_date', title: '<?php getCaption("Tgl. PO"); ?> ', width: 100, height: 20, sortable: true,formatter:formatDate},
                    {field: 'opn_date', title: '<?php getCaption("Tgl. Buat"); ?> ', width: 100, height: 20, sortable: true},
                    {field: 'po_type', title: '<?php getCaption("Jenis PO"); ?>  ', width: 200, height: 20, sortable: true},
                    {field: 'quote_no', title: '<?php getCaption("No. Quotation"); ?>  ', width: 250, height: 20, sortable: true},
                    {field: 'quote_date', title: '<?php getCaption("Tgl. Quotation"); ?>  ', width: 120, height: 20, sortable: true,formatter:formatDate},
                    {field: 'supp_code', title: '<?php getCaption("Kode Supplier"); ?>  ', width: 120, height: 20, sortable: true},
                    {field: 'supp_name', title: '<?php getCaption("Nama Supplier"); ?>  ', width: 150, height: 20, sortable: true},
                    {field: 'prep_code', title: '<?php getCaption("Kode Purchaser"); ?>  ', width: 200, height: 20, sortable: true},
                    {field: 'prep_name', title: '<?php getCaption("Nama Purchaser"); ?>  ', width: 150, height: 20, sortable: true},
                    {field: 'raddr_code', title: '<?php getCaption("Kode Penerima"); ?>  ', width: 100, height: 20, sortable: true},
                    {field: 'rname', title: '<?php getCaption("Nama Penerima"); ?>  ', width: 150, height: 20, sortable: true},
                    {field: 'wrhs_code', title: '<?php getCaption("Warehouse"); ?>  ', width: 200, height: 20, sortable: true},
                    {field: 'note', title: 'Note 1', width: 150, height: 20, sortable: true},
                    {field: 'note2', title: 'Note 3', width: 100, height: 20, sortable: true},
                    {field: 'note3', title: 'Note 3', width: 150, height: 20, sortable: true},
                    {field: 'note4', title: 'Note 4', width: 200, height: 20, sortable: true}
                ]]
        });

        $('#windowSearch').window('open');

        var option = $("#SearchOption").html();

        $("#actionSearch").empty().html(option);
       
        $('#po_no2').attr('disabled', false);
           $("#po_date2").datebox();
    }*/
    function doSearch() {
        $("#tableSearch").datagrid('load', {
            field1: $('#po_no2').val(),
            field2: $('#po_date2').datebox('getValue')
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
        var url = site_url + 'transaction/accessories/outputpdf/<?php echo encrypt_decrypt('encrypt', 'acc_poh');?>/' + ids + '/<?php echo $_SESSION['C_USER']; ?>/'+key+'/<?php echo encrypt_decrypt('encrypt', 'po_no');?>/<?php echo encrypt_decrypt('encrypt', 'APO');?>#toolbar=0';
        
        if(key == 'print'){          
            $("#screenWindow").empty().append('<iframe frameborder="0"  src="' + url + '" style="width:100%;height:auto;min-height: 500px;padding:0px;"></iframe>');
        }
        
        if(key == 'screen'){           
            window.open(url);
        }
        
        if(key == 'download'){
           
           // $("#screenWindow").empty().append('<iframe frameborder="0"  src="' + url + '" style="width:100%;height:auto;min-height: 500px;padding:0px;"></iframe>');
        
        }
    }

    function table_grid(ttable, po_no) {

        ttable.datagrid({
            method: 'post',
            url: site_url + '<?php echo 'builder/datagrid/' . encrypt_decrypt('encrypt', 'acc_pod'); ?>/po_no/' + po_no + '/?grid=true',
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
                    {field: 'part_code', title: '<?php getCaption("Kode Barang"); ?>', width: 80, height: 20, sortable: true},
                    {field: 'part_name', title: '<?php getCaption("Nama Barang"); ?>', width: 190, height: 20, sortable: true},
                    {field: 'wrhs_code', title: '<?php getCaption("Warehouse"); ?>', width: 100, height: 20, sortable: true},
                    {field: 'qty', title: '<?php getCaption("QTY"); ?>', width: 80, height: 20, sortable: true,align: 'right', },
                    {field: 'unit', title: '<?php getCaption("Satuan"); ?>', width: 80, height: 20, sortable: true},
                    {field: 'price_bd', title: '<?php getCaption("Harga Satuan"); ?>', width: 120, height: 20, sortable: true, align:'right', formatter: formatNumber},
                    {field: 'disc_pct', title: '<?php getCaption("Diskon"); ?>', width: 120, height: 20, sortable: true, align:'right', formatter: formatNumber},
                    // {field: 'price_total', title: '<?php getCaption("Harga Total"); ?>', width: 150, height: 20, sortable: true},
                    {field: 'disc_val', title: '<?php getCaption("Jumlah Diskon"); ?>', width: 120, height: 20, sortable: true, align:'right', formatter: formatNumber},
                    {field: 'price_ad', title: '<?php getCaption("Harga Netto"); ?>', width: 120, height: 20, sortable: true, align:'right', formatter: formatNumber},
                    {field: 'location', title: '<?php getCaption("Lokasi"); ?> ', width: 120, height: 20, sortable: true},
                    {field: 'por_no', title: '<?php getCaption("No. SPOB"); ?> ', width: 150, height: 20, sortable: true},
                    {field: 'por_date', title: '<?php getCaption("Tgl. SPOB"); ?>', width: 100, height: 20, sortable: true, formatter:formatDate},
                    {field: 'por_line', title: '<?php getCaption("Line No"); ?>', width: 150, height: 20, sortable: true},
                    {field: 'add_by', title: '<?php getCaption("Ditambahkan Oleh"); ?>', width: 150, height: 20, sortable: true}


                ]]
        });

        
        ttable.datagrid({
            onSelect: function (rowIndex, rowData) {
                
                $("#qty").numberbox('setValue',rowData.qty);
                
                $("#part_code").combogrid('setValue', rowData.part_code);
                $("#part_name").val(rowData.part_name);
                
                $("#price_bd").numberbox('setValue',rowData.price_bd);
                $("#disc_pct").numberbox('setValue',rowData.disc_pct);
                price_disc(rowData.qty, rowData.price_bd, rowData.disc_pct)
            }
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
        var po_no = $("#form_validation #po_no").val();

        if (po_no == '') {
            po_no = null;
        }

        table_grid(ttable, po_no);

        $('#form_validation #opn_date').datebox('disable');
        $('#form_validation #cls_date').datebox('disable');
        $('#form_validation #po_date').datebox('disable');
        //$('#form_validation #po_type').combobox('enable');
        $('#form_validation #inv_disc, #inv_stamp').numberbox({disabled: false});
        $('#form_validation #supp_name, #prep_name, #raddr_code, #curr_code').combogrid('enable');
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
        $.post(site_url + 'transaction/accessories/get_number/APO', function (num) {
            $("#form_validation #po_no").val(num);
        });
        condReady();


    }
    function condEdit() {
        condReady();
    }
    function condDelete() {
        var id = $("#form_validation #id").val();
        var table = $("#form_validation #table").val();
        $.messager.confirm('Warning', 'Do you really want to delete this record?', function (r) {
            if (r) {
                $(".loader").show();
                var url = site_url + 'transaction/accessories/delete_PO';
                $.post(url, {table: table, id: id}, function (data) {
                   
                    obj = JSON.parse(data);

                    if (obj.success == true) {
                        read_show('P');
                        showAlert("Information", obj.message);

                    } else
                    {
                        showAlert("Error while deleting", '<font color="red">' + obj.message + '</font>');
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

    function closeBtn() {
        var prcvd_date = $("#prcvd_date").val();


        if (prcvd_date == '0000-00-00') {
            read_show('');
            showAlert("Error while closing", '<font color="red">Please input Sent Date</font>');
        } else {
            $.messager.confirm('Closing PO', 'Close this PO?', function (r) {
                if (r) {
                    $(".loader").show();
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
                                showAlert("Error while close", '<font color="red">' + obj.message + '</font>');
                            }
                            scrlTop();
                        }
                    });
                }
                read_show('');
                //$('#form_validation :input').attr('disabled', true);
            });
        }



    }
    function UncloseBtn() {
        $.messager.confirm('Unclose', 'Unclose this PO?', function (r) {
            if (r) {
                $(".loader").show();
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
                    showAlert("Information", obj.message);

                    if (obj.status == 'update') {
                        read_show('');
                    } else {
                        read_show('');
                        cmdDetails();
                    }
                     $('.loader').hide();
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
        var po_no = $("#form_validation #po_no").val();
        tableId2();
        read_show2('');

        table_grid(ttable2, po_no);
        $("#DetailWindow").window('open');

        $('#wk_code').combogrid({
            onSelect: function (index, row) {
                $("#form_validation2 #wk_desc").val(row.wk_desc);
            }
        });
    }



    function read_show2(nav) {
        var id = $("#id2").val();
        var po_no = $("#form_validation #po_no").val();

        $.post(site_url + 'crud/read/?po_no=' + po_no, {table: table2, nav: nav, id: id}, function (json) {

            $("#form_validation2 :input").val('');
            $("#form_validation2 .easyui-numberbox").numberbox('setValue', '');
            if (json !== '[]') {

                var rowData = $.parseJSON(json);

                $.each(rowData, function (i, v) {
                    $("#form_validation2 #" + i).val(v);

                    if (i == 'part_code' || i == 'srep_code1' || i == 'srep_code2') {
                        $("#form_validation2 #" + i).combogrid('setValue', v);
                    }

                    if (i == 'qty' || i == 'price_bd' || i == 'disc_pct' || i == 'disc_val' || i == 'price_ad') {
                        $("#form_validation2 #" + i).numberbox('setValue', v);
                    }
                });
                  price_disc(rowData.qty, '', '');
                $("#id2").val(rowData.id);


            }
            table_grid(ttable2, po_no);
            formDisabled2();
            cmdcondAwal2();

        });
    }

    function saveData2() {
          $('#cmdSave2').linkbutton('disable');
        var qty  = $("#qty").numberbox('getValue');
       
        stat = true;
        if(qty == ''){
            stat = false;
        }
        if(qty < 0){
            stat = false;
        }
        
        if(stat !== false){
        var po_no = $("#form_validation #po_no").val();

        var save_url2 = site_url + 'transaction/accessories/save_pod/' + po_no + '/<?php echo $_SESSION['C_USER']; ?>';

        $('#form_validation2 :input').attr('disabled', false);

        $("#form_validation2").form('submit', {
            url: save_url2,
            onSubmit: function () {
                return $(this).form('validate');
            },
            success: function (data) { //alert(data)
                var obj = JSON.parse(data);

                if (obj.success !== false) {

                    $("#id2").val('');

                    read_show2('');
                    read_show('');
                } else
                {

                    showAlert("Error", '<font color="red">' + obj.message + '</font>');
                   $('#cmdSave2').linkbutton('enable');
                }
            }
        });
        
        }else{
             read_show2('');
            showAlert("Error", '<font color="red">QTY needs to be larger than 0</font>');
        }
    }

    function condDelete2() {
        var po_no = $("#form_validation #po_no").val();
        var id = $("#id2").val();
         var id3 = $("#id3").val();
         
        $.messager.confirm('Delete Confirmation', 'Do you really want to delete this record?', function (r) {
            if (r) {
                var url = site_url + 'transaction/accessories/delete_pod';
                $.post(url, {table: table2, id: id, id3:id3}, function (data) { 
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
        $('#form_validation2 #table2').val(table2);

        $("#form_validation2 #part_code").combogrid('enable');
        $("#form_validation2 #prep_code").combogrid('enable');
        $("#form_validation2 #qty").attr('disabled', false);
        $("#price_bd, #disc_pct, #disc_unit, #price_ad_unit").numberbox({disabled: false});

        cmdcondAwal2();
        cmdcondReady2();

        $("#qty").keyup(function () {
            var qty = parseCurrency($(this).val());

            price_disc(qty, '', '');
        });

        $("#price_bd").keyup(function () {
            var price_bd = parseCurrency($(this).val());

            price_disc('', price_bd, '');
        });

        $("#disc_pct").keyup(function () {
            var disc_pct = $(this).val();

            price_disc('', '', disc_pct);
        });

        $("#disc_unit").keyup(function () {
            var discunit = parseCurrency($(this).val());
            price_unit(discunit)
        });

        $("#price_ad_unit").keyup(function () {
            var discunit = parseCurrency($("#price_bd").val()) - parseCurrency($(this).val());

            price_unit(discunit);
        });
    }

    function price_unit(discunit) {
        var disc_unit = discunit;
        var qty = $("#qty").numberbox('getValue');
        var price_total = $("#price_total").numberbox('getValue');

        var disc = disc_unit * qty;

        var disc_pct = (disc / price_total) * 100;

        $("#disc_pct").numberbox('setValue', disc_pct);
        // alert('diskon: '+disc+' ' + ' diskon %: '+ disc_pct);
        price_disc('', '', disc_pct);
    }
    function price_disc(qty, price_bd, disc_pct) {
        if (qty == '') {
            qty = $("#qty").numberbox('getValue');
        }
        if (price_bd == '') {
            price_bd = $("#price_bd").numberbox('getValue');
        }
        if (disc_pct == '') {
            disc_pct = $("#disc_pct").numberbox('getValue');
        }

        var disc_unit = $("#disc_unit").numberbox('getValue');
        var price_ad_unit = $("#price_ad_unit").numberbox('getValue');

        var price_tot = price_bd * qty;
        var disc_tot = (price_tot / 100) * disc_pct;


        //alert(disc_pct)

        var total = price_tot - disc_tot;

        var disc_unit_val = disc_tot / qty;
        var price_ad_unit_val = price_bd - disc_unit_val;


        $("#price_total").numberbox('setValue', price_tot);
        $("#disc_val").numberbox('setValue', disc_tot);
        $("#price_ad").numberbox('setValue', total);

        $("#disc_unit").numberbox('setValue', disc_unit_val);
        $("#price_ad_unit").numberbox('setValue', price_ad_unit_val);


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
        $('#form_validation2 .combo-text').val('');
        $('#form_validation2 #id2').val('');
        $('#form_validation2 :input').val('');
        $('#form_validation2 .easyui-numberbox').numberbox('setValue', '');
        condReady2();

    }

    function condEdit2() {
        showAlert("Message", '<font color="red">Record(s) can\'t be edited. To edit this record, please delete it and add a new record.</font>');
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
        checkRunMonthYear('APO');
        tableId();
        dateTop();
        read_show('')
        version('03.17-31');
    });
</script>