<script>
    var table = 'veh_prh';

    var form = $('#form_validation');
    var save_url = site_url + 'transaction/vehicle/savePenerimaan/penerimaan';
    var unclose_url = site_url + 'transaction/vehicle/unclosePenerimaan/<?php echo $_SESSION['C_USER']; ?>';
    var close_url = site_url + 'transaction/vehicle/closePenerimaan/<?php echo $_SESSION['C_USER']; ?>';

    var divtableId = $("#tableId");
    var reset = 0;

     $("#stdoptname").combogrid({
            onSelect: function (index, row) {
                $("#form_validation #stdoptcode").val(row.stdoptcode);
            }
        });
    function tableId() {
        divtableId.empty().append('<input type="hidden" name="id"  id="id"><input type="hidden" name="table"  id="table" value="' + table + '">');
    }
    function read_show(nav) {
        var id = $("#form_validation #id").val();
         cmbgridReady('read');
        $.post(site_url + 'crud/read', {table: table, nav: nav, id: id}, function (json) {
            $("#notif").val('');
            $('#form_validation input:text').val('');
            $('#form_validation textarea').val('');
            $('#form_validation .easyui-combogrid').combogrid('setValue', '');
            $("#form_validation input:radio").prop("checked", false);
            $(".easyui-datebox").datebox('setValue', '');

            if (json !== '[]') {

                var rowData = $.parseJSON(json);

                $.each(rowData, function (i, v) {
                    $("#form_validation #" + i).val(v);

                    if(i == 'po_no' || i == 'supp_name'|| i == 'wrhs_code' || i == 'loc_code'|| i == 'veh_name'|| i == 'stdoptname'|| i == 'color_name'){
                         $("#" + i).combogrid('setValue', v);
                    }
                    
                    if(i == 'unit_price' || i == 'tot_price'){
                         $("#" + i).numberbox('setValue', v);
                    }
                    
                    if(i == 'stk_date' || i == 'cls_date' || i == 'po_date' || i == 'pred_stk_d' || i == 'sji_date' || i == 'kwiti_date'|| i == 'fpi_date' || i == 'dni_date' || i == 'sji2_date' || i == 'kwiti2date'|| i == 'fpi2_date' || i == 'dni2_date' || i == 'do_date' || i == 'pdi_date'){
                        if (v !== '0000-00-00') {
                             var vdate = dateSplit(v);
                             
                            $("#" + i).datebox('setValue', vdate);
                        }
                    }
                });
              
                $("#id").val(rowData.id);
                $(".supp_name").val(rowData.supp_name);
                formDisabled();

                if (rowData.cls_date == null || rowData.cls_date == '0000-00-00') {
                    $("#print").linkbutton('disable');
                    $("#screen").linkbutton('disable');
                    $("#closeOn").empty().append('<button type="button" id="cmdClose" title="<?php getCaption("Close"); ?>" class="easyui-linkbutton easyui-tooltip btn btn-success" data-options="iconCls:\'icon-close\'"   onclick="rolesClose()">Close</button>');

                } else {
                    $('.cmdEdit').linkbutton('disable');
                    $(".cmdDelete").linkbutton('disable');

                    $("#closeOn").empty().append('<button type="button" id="cmdUnClose" title="<?php getCaption("unClose"); ?>" class="easyui-linkbutton easyui-tooltip btn btn-success" data-options="iconCls:\'icon-unclose\'"  onclick="rolesUnclose()">Unclose</button>');

                    $("#print").removeAttr('disabled')
                    $("#print").linkbutton('enable');
                    $("#screen").removeAttr('disabled')
                    $("#screen").linkbutton('enable');
                }

                $('.easyui-linkbutton').linkbutton();
                $('.loader').hide();
               
            } else {
                formDisabled();
                //$('.cmdEdit').attr('disabled', true);
                //$('.cmdDelete').attr('disabled', true);
                $('.cmdEdit').linkbutton('disable');
                $('.cmdDelete').linkbutton('disable');
                $('.loader').hide();
                $("#closeOn").empty();
            }




        });
    }

    function doSearch() {
        $("#tableSearch").datagrid('load', {
            field1: $('#pur_inv_no2').val(),
            field2: $('#po_no2').val()
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
    function condAdd() {
        $(".easyui-datebox").datebox('setValue', '');
        $(".easyui-datebox").datebox('enable');
        $('.easyui-numberbox').numberbox('enable');
        $('.easyui-numberbox').numberbox('setValue', '');
        $('#id').val('');
        $('#form_validation input:text').val('');
        $("#form_validation .easyui-combogrid").combogrid('setValue', '');

        $("#table").val(table);
        $('#form_validation textarea').val("");
        $("#form_validation input:radio").prop("checked", false);


        $.post(site_url + 'transaction/vehicle/get_number/VPR', function (num) {
            $("#pur_inv_no").val(num);
        });

        condReady('add');

    }

    function condEdit() {
        $(".easyui-datebox").datebox('enable');
       
             
        condReady('edit');

    }

    function condCancel() {
        read_show('');
    }

    function condDeletePO() {
        var po_no = $("#po_no").combobox('getValue');

        if (po_no !== '') {
            var id = $("#form_validation #id").val();
            var table = $("#form_validation #table").val();
            $.messager.confirm('Delete PO', 'Data related to this PO will be deleted from this vehicle\’s Receiving. <br />Delete PO No., PO Date, ang PO Data in this receiving invoice?', function (r) {
                if (r) {
                    $('.loader').show();
                    var url = site_url + 'transaction/vehicle/deletePOPenerimaan';
                    $.post(url, {table: table, id: id}, function (data) {

                        obj = JSON.parse(data);
                        if (obj.success == true) {
                            showAlert("Information", obj.message);
                            read_show('');
                            $('#po_no').combogrid('grid').datagrid('reload');
                        } else
                        {
                            $('.loader').hide();
                            showAlert("Error while deleting", '<font color="red">' + obj.message + '</font>');
                        }
                    });
                }
            });
        } else {
            showAlert("Information", 'Please select a PO No. to be deleted.');
        }
    }
    function condDelete() {
        var id = $("#form_validation #id").val();
        var table = $("#form_validation #table").val();
        $.messager.confirm('Warning', 'Do you really want to delete the selected data?', function (r) {
            if (r) {
                $('.loader').show();
                var url = site_url + 'transaction/vehicle/deletePenerimaan';
                $.post(url, {table: table, id: id}, function (data) {

                    obj = JSON.parse(data);
                    if (obj.success == true) {
                        $("#id").val('');
                        showAlert("Information", obj.message);
                        read_show('');
                        $('#po_no').combogrid('grid').datagrid('reload');
                    } else
                    {
                        $('.loader').hide();
                        showAlert("Error while delete", '<font color="red">' + obj.message + '</font>');
                    }
                    scrlTop();
                });
            }else{
                $('#cmdDelete').linkbutton('enable');
            }
        });
    }
    function formDisabled() {
        $('#form_validation :input').attr('disabled', true);
        $('.easyui-combogrid').combogrid('disable');
        $('.easyui-combobox').combobox({disabled: true});
        $('.combo-text').removeClass('validatebox-text');
        $('.combo-text').removeClass('validatebox-invalid');
        $(".easyui-datebox").datebox('disable');
        cmdcondAwal();
    }

    function formDisabled() {
        $('#form_validation :input').attr('disabled', true);
        $('.easyui-combogrid').combogrid('disable');
        $('.easyui-combobox').combobox({disabled: true});
        $('.combo-text').removeClass('validatebox-text');
        $('.combo-text').removeClass('validatebox-invalid');

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

        $('#cmdBrowse').removeAttr('disabled');
        $("#cmdBrowse").linkbutton('enable');
    }

    function condReady(opt = null) {
         scrlTop();
        var po_no =$("#po_no").val();
        if(opt !== null){
            if(opt == 'edit'){
                var color_name= $('#color_name').val();
                var veh_name = $('#veh_name').val();
                var supp_name = $("#supp_name").val();

                var chassis = $("#chassis").val();
                var engine =$("#engine").val();
            }  
              cmbgridReady('', color_name, veh_name, supp_name, po_no, chassis, engine);
        }
      
        $('#form_validation :input').attr('disabled', false);
        $('.easyui-combogrid').combogrid('enable');
        $('.easyui-combobox').combobox({disabled: false});

        $("#cls_by").attr('disabled', true);

        $("#veh_code").attr('disabled', true);
        $("#veh_brand").attr('disabled', true);
        $("#veh_transm").attr('disabled', true);
        $("#veh_year").attr('disabled', true);
        $("#veh_type").attr('disabled', true);
        $("#veh_model").attr('disabled', true);
        $("#color_code").attr('disabled', true);
        $("#supp_code").attr('disabled', true);
        $("#color_type").attr('disabled', true);
        $("#stdoptcode").attr('disabled', true);
        $("#po_date").datebox('disable');
        $("#stk_date").datebox('disable');

        $("#cls_date").attr('disabled', true);
        $("#cls_date").datebox('disable');
        $("#pred_stk_d").datebox('disable');


        $("#wrhs_code").combogrid('setValue', '<?php echo $wrhs_input; ?>');
        $("#wrhs_code").combogrid('disable');
        $("#veh_name").combogrid('disable');
        $("#color_name").combogrid('disable');
       // $("#supp_name").combogrid('disable');

        $("#qty").attr('disabled', true);
        $("#unit").val('unit').attr('disabled', true);
        $("#pur_inv_no").attr('disabled', true);

        $("#alarm").attr('disabled', false);
        $("#key_no").attr('disabled', false);
        $("#serv_book").attr('disabled', false);
        $("#chassis").attr('disabled', false);
        $("#engine").attr('disabled', false);
        $("#note").attr('disabled', false);

        $(".supp_name").attr('disabled', true);
        $("#supp_npwp").attr('disabled', true);
        $("#supp_pkp").attr('disabled', true);
        $("#supp2_code").attr('disabled', true);
        $("#supp2_npwp").attr('disabled', true);
        $("#supp2_pkp").attr('disabled', true);
        
        checkboxClick();
        cmdcondReady();
       
        if(po_no !== ''){
          $("#po_no").combogrid('disable');
          $("#cmdDeletePO").linkbutton('enable');
        }else{
             $("#po_no").combogrid('enable');
        }
        
        
        
        
    }

    function  cmbgridReady(load, color_name =null, veh_name =null, supp_name =null, po_no =null, chassis=null, engine=null) {
              
        $("#po_no").combogrid({
            onSelect: function (index, row) {
                if(load !== 'read'){
                    
                    $.each(row, function (i, v) {
                        if(i == 'pur_inv_no' || i == 'id'){
                        
                        }else{
                            $("#form_validation #" + i).val(v);

                            if(i == 'supp_name' || i == 'veh_name' || i == 'color_name' || i == 'stdoptname' || i == 'loc_code'){
                                 $("#" + i).combogrid('setValue', v);
                            }
                            if(i == 'po_date' || i == 'pred_stk_d'){
                                if (v !== '0000-00-00') {
                                     var vdate = dateSplit(v);

                                    $("#" + i).datebox('setValue', vdate);
                                }
                            }
                        }
                        
                       
                    });
                    
                     $('.supp_name').val(row.supp_name);
                /*
                $("#supp_code").val(row.supp_code);
                $("#veh_code").val(row.veh_code);

                $("#supp_name").combogrid('setValue', row.supp_name);
                $("#veh_name").combogrid('setValue', row.veh_name);
                $("#color_name").combogrid('setValue', row.color_name);
                $("#stdoptname").combogrid('setValue', row.stdoptname);
                $("#loc_code").combogrid('setValue', row.loc_code);

                $("#veh_code").val(row.veh_code);
                $("#veh_brand").val(row.veh_brand);

                $("#veh_transm").val(row.veh_transm);
                $("#veh_year").val(row.veh_year);
                $("#chassis").val(row.chassis);
                $("#engine").val(row.engine);
                $("#veh_type").val(row.veh_type);
                $("#veh_model").val(row.veh_model);

                $("#color_code").val(row.color_code);
                $("#color_type").val(row.color_type);

                $("#po_date").datebox('setValue', row.po_date);
                $("#pred_stk_d").datebox('setValue', row.pred_stk_d);
                               
                        
                $("#alarm").val(row.alarm);
                $("#key_no").val(row.key_no);
                $("#serv_book").val(row.serv_book);

                $("#po_made_by").val(row.po_made_by);
                $("#po_appr_by").val(row.po_appr_by);
                $("#po_desc").val(row.note);

                $("#qty").val(row.qty);
                $("#unit").val(row.unit);
                */

                $.post(site_url + 'transaction/vehicle/checkpur', {po_no: row.po_no}, function (res) {
                    var json = $.parseJSON(res);

                    if (json.count == 0) {
                         $.messager.confirm('Price detail NOT found', 'Import vehicle price from vehicle price master?', function (r) {
                         if (r) {
                                reset = 1;
                            } else {
                                reset = 0;
                            }

                            $("#reset").val(reset);
                        });
                    }

                });

        }
            }
        });

        
        $("#supp_name").combogrid({
            onSelect: function (index, row) {
                   if(load !== 'read'){
                       $(".supp_name").val(row.supp_name);
                        $("#supp_code").val(row.supp_code);
                        $("#supp_npwp").val(row.onpwp);
                        $("#supp_pkp").val(row.opkp);
                   }
            }
        });
        $("#supp2_name").combogrid({
            onSelect: function (index, row) {
                   if(load !== 'read'){
  
                       $("#supp2_name").combogrid('setValue',row.supp_name);
                        $("#supp2_code").val(row.supp_code);
                        $("#supp2_npwp").val(row.onpwp);
                        $("#supp2_pkp").val(row.opkp);
                   }
            }
        });
        /*
        $('#veh_name').combogrid({
            onSelect: function (index, row) {
                   if(load !== 'read'){
                $("#veh_code").val(row.veh_code);
                $("#veh_brand").val(row.veh_brand);

                $("#veh_transm").val(row.veh_transm);
                $("#veh_year").val(row.veh_year);
                //$("#chassis").val(row.chas_pref);
                //$("#engine").val(row.eng_pref);
                $("#veh_type").val(row.veh_type);
                $("#veh_model").val(row.veh_model);

                   }
            }
        });

        $('#color_name').combogrid({
            onSelect: function (index, row) {
                   if(load !== 'read'){
                $("#color_code").val(row.color_code);
                $("#color_type").val(row.type);

                $("#color_code").attr('disabled', true);
                $("#color_type").attr('disabled', true);
                   }
            }
        });
        */
        $('#color_name').combogrid('setValue', color_name);
        $('#veh_name').combogrid('setValue', veh_name);
        $("#supp_name").combogrid('setValue', supp_name);       
        $("#chassis").val(chassis);
        $("#engine").val(engine);
      
         $("#po_no").combogrid('setValue', po_no);
        
    }
    function cmdcondReady() {
      
        $('.cmdFirst').linkbutton('disable');
        $('.cmdPrev').linkbutton('disable');
        $('.cmdNext').linkbutton('disable');
        $('.cmdLast').linkbutton('disable');

        $('.cmdSave').removeAttr('disabled');
        $('.cmdCancel').removeAttr('disabled');

        $('.cmdSave').linkbutton('enable');
        $('.cmdCancel').linkbutton('enable');

        $('.cmdAdd').linkbutton('disable');
        $('.cmdEdit').linkbutton('disable');
        $('.cmdDelete').linkbutton('disable');
        $('.cmdSearch').linkbutton('disable');

        $("#cmdBrowse").linkbutton('disable');

        $("#print").linkbutton('disable');
        $("#screen").linkbutton('disable');
        $("#cmdClose").linkbutton('disable');
        $("#cmdUnClose").linkbutton('disable');
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
                    if (id == '') {
                        $("#id").val('');
                    }
                    read_show('');
                    $(".formError").remove();

                    $(".easyui-datebox").datebox('disable');
                    $('#po_no').combogrid('grid').datagrid('reload');
                } else
                {
                   updateFailed(obj);
                   
                   if(obj.status == 'exist'){
                       $("#id").val(obj.inv_no_id );
                       read_show('');
                   }
                }
                scrlTop();
            }
        });
    }

    function closeBtn() {
        var po_no = $("#po_no").combogrid('getValue');
        
        if(po_no !== ''){
        $.messager.confirm('Closing  Invoice', 'Close this Invoice? Stock will increase', function (r) {
            if (r) {
                var id = $("#id").val();
                $('.loader').show();
                $.post(close_url, {table: table, id: id}, function (data) {

                    obj = JSON.parse(data);
                    if (obj.success == true) {

                        showAlert("Information", obj.message);
                        read_show('');
                    } else
                    {
                        $('.loader').hide();
                        showAlert("Error while closing", '<font color="red">' + obj.message + '</font>');
                    }
                    scrlTop();
                });
            }
            read_show('');
        });
      
        }else{
             showAlert("Error while closing", '<font color="red"> Please input PO (Purchase Order) No. </font>');
             read_show('');
        }
    }

    function UncloseBtn() {
        $.messager.confirm('Unclosing Invoice', 'Unclose this invoice? Stock will decrease', function (r) {
            if (r) {

                var id = $("#id").val();
                $('.loader').show();
                $.post(unclose_url, {table: table, id: id}, function (data) {

                    obj = JSON.parse(data);
                    if (obj.success == true) {

                        showAlert("Information", obj.message);
                        read_show('');
                    } else
                    {
                        $('.loader').hide();
                        showAlert("Error while closed", '<font color="red">' + obj.message + '</font>');
                    }
                    scrlTop();
                });

            } else {
                read_show('');
                $.messager.show({title: 'Information', msg: 'Invoice unclose aborted', icon: 'info', width: 300, timeout: 2000, showType: 'fade', style: {right: '50%', top: '', bottom: '50%'}});

            }

        });

    }

    function print_sc(action) {

        var id = $("#id").val();
        var user = '<?php echo $_SESSION['C_USER']; ?>';

        var url = site_url + 'transaction/vehicle/outputpdf/<?php echo encrypt_decrypt('encrypt', 'veh_prh');?>/' + id + '/' + user + '/' + action + '/penerimaan#toolbar=0';

        if (action == 'screen') {
            // $('#sr').window('open');
            //$('#sr').empty().append('<iframe   frameborder="0"  src="' + url + '" style="width:100%;height:auto;min-height: 500px;padding:0px;"></iframe>');
            window.open(url);
        } else {
            $('#sr').empty().append('<iframe   frameborder="0"  src="' + url + '" style="width:100%;height:auto;min-height: 500px;padding:0px;"></iframe>');
        }
    }

    $(document).ready(function () {     
        checkRunMonthYear('VPR');
        tableId();
        read_show('')
        version('03.17-31');
    });

</script>
