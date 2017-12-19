<script>

    var vMode = 0;
    var lnRecCount = 0;
    var lnRecNo = 0;
     var save_url = site_url + 'transaction/setting/saveSystem';
     
    function clearForm() {
        $('#<?php echo $form; ?>').form('clear');
    }

    function cmdcondAwal() {
        $('#cmdFirst').linkbutton('enable');
        $('#cmdPrev').linkbutton('enable');
        $('#cmdNext').linkbutton('enable');
        $('#cmdLast').linkbutton('enable');
        $('#cmdSave').linkbutton('disable');
        $('#cmdCancel').linkbutton('disable');
        $('#cmdAdd').linkbutton('enable');
        $('#cmdEdit').linkbutton('enable');
        $('#cmdDelete').linkbutton('enable');
        $('#cmdSearch').linkbutton('enable');
        $('#copyFrom').linkbutton('disable');
    }

    function cmdcondReady() {
        $('#cmdFirst').linkbutton('disable');
        $('#cmdPrev').linkbutton('disable');
        $('#cmdNext').linkbutton('disable');
        $('#cmdLast').linkbutton('disable');
        $('#cmdSave').linkbutton('enable');
        $('#cmdCancel').linkbutton('enable');
        $('#copyFrom').linkbutton('enable');
        $('#cmdAdd').linkbutton('disable');
        $('#cmdEdit').linkbutton('disable');
        $('#cmdDelete').linkbutton('disable');
        $('#cmdSearch').linkbutton('disable');
    }

    function setEnable(status) {
        var lcStatus1 = false;
        var lcStatus2 = false;

        if (status == false) {
            lcStatus1 = true;
            lcStatus2 = 'disable';
        } else {
            lcStatus2 = 'enable';
            lcStatus1 = false;
        }

        $('#<?= $form; ?> :input').attr('disabled', lcStatus1);
         $('#<?= $form; ?> :checkbox').attr('disabled', lcStatus1);
        $('#<?= $form; ?> .easyui-combogrid').combogrid(lcStatus2);
        $('#<?= $form; ?> .easyui-combobox').combobox({disabled: lcStatus1});
        $("#<?= $form; ?> .easyui-datebox").datebox(lcStatus2);
    }

    function condAwal() {
        cmdcondAwal.apply(this, arguments);
        setEnable(false);
    }

    function condReady() {
        cmdcondReady.apply(this, arguments);
        setEnable(true);
        $('#bulan').attr('disabled', true);
        $('#tahun').attr('disabled', true);
        
        $('#comp_stamp').click(function () {
            if ($(this).prop("checked") == true) {
                $(this).val(1);
            }
            else if ($(this).prop("checked") == false) {
                $(this).val(0);
            }
        });
        $('#comp_stmpp').click(function () {
            if ($(this).prop("checked") == true) {
                $(this).val(1);
            }
            else if ($(this).prop("checked") == false) {
                $(this).val(0);
            }
        });
        
        $('#<?php echo $pk; ?>').focus();
    }

    function condAdd() {
        vMode = 1;

        $('#<?php echo $pk; ?>').attr('disabled', true);
    <?php getFieldList($table, 'condAdd'); ?>

        condReady();
    }

    function condEdit() {
        vMode = 2;
        condReady();
    }

    function condDelete() {
        vMode = 3;
        condReady();
        saveData();
    }

    function condCancel() {
        condAwal();
        showdata('', lnRecNo)
    }

    function condSearch() {
        $('#windowSearch').window('open');
    }


    function doSearch() {
        url = "services/runCRUD.php?func=read&lookup=<?php echo $lookup; ?>&query=" + $("#searchKeyword").val() + "&pk=<?php echo $pk; ?>&sk=<?php echo $sk; ?>";
        $('#dt').datagrid({url: url});
    }
   
    function saveData() {
        $('.loader').show();
        $('#systemsetup :input').attr('disabled', false);

        $("#systemsetup").form('submit', {
            url: save_url,
            onSubmit: function () {
                return $(this).form('validate');
            },
            success: function (data) { 
                var obj = JSON.parse(data);
                if (obj.success == true) {
                    getData();
                    showAlert("Information", obj.message);
                    

                } else
                {
                    $('.loader').hide();
                    condReady();
                    $('#form_validation :input').attr('disabled', true);
                    showAlert("Error while saving", '<font color="red">' + obj.message + '</font>');
                }
            }
        });
    }
    function saveData2() {
        $('.loader').show();
        url = "services/runCRUD.php";
        var cMode = '';

        if (vMode == 1) {
            cMode = 'create';
        }
        if (vMode == 2) {
            cMode = 'update';
        }
        if (vMode == 3) {
            cMode = 'delete';
        }
        data = "lookup=<?php echo $lookup; ?>"
                + "&func=" + cMode
                + "&id=" + lnRecNo
                + "&pk=<?php echo $pk; ?>"
                + "&sk=<?php echo $sk; ?>";
        data = data + '&' + $("#<?php echo $form; ?>").serialize();

        $.post(url, data).done(function (data) {
            obj = JSON.parse(data);

            if (obj.success == true) {

                if (vMode == 1) {
                    showAlert("Information", obj.message + " with id #" + obj.id);
                    getData(obj.id - 1, 1, 'N');
                }
                if (vMode == 2) {
                    showAlert("Information", obj.message);
                    getData(obj.id - 1, 1, 'N');
                }
                if (vMode == 3) {
                    showAlert("Information", obj.message + " with id #" + obj.id);
                    getData(obj.id, 1, 'P');
                }

                condAwal();

            } else {
                showAlert("Error while saving", obj.message);
            }

            $('.loader').hide();

        }).fail(function () {
            showAlert("Error", "Error while saving");
            $('.loader').hide();
        });
    }

    function getSelected() {
        var row = $('#dt').datagrid('getSelected');
        
        if (row) {
            lnTargetRec = row.id;
            url = "services/runCRUD.php?func=read&lookup=<?php echo $lookup; ?>&id=" + (lnTargetRec) + "&pk=<?php echo $pk; ?>&sk=<?php echo $sk; ?>";
            
            $.getJSON(url, function (data) {
                if (data.total == 0) {
                    lnRecNo = lnTargetRec - 1;
                } else
                {
                    $('#<?php echo $form; ?>').form('load', {<?php getFieldList($table, 'getData'); ?>});
                    lnRecNo = data.rows[0]['id'] * 1;
                }

            });
        }
        $('#windowSearch').window('close');
    }

    function showdata(lcType, lnCurrPos) {    
        getData();
    }

    function getData() {
       /* url = "services/runCRUD.php?func=read&lookup=<?php echo $lookup; ?>&id=" + (lnTargetRec) + "&limit=" + lnRec + "&nav=" + lcType + "&pk=<?php echo $pk; ?>&sk=<?php echo $sk; ?>";
        
        $.getJSON(url, function (data) {
           
            if (data.total == 0) {
                lnRecNo = lnTargetRec - 1;
            } else{
                $('#<?php echo $form; ?>').form('load', {<?php getFieldList($table, 'getData'); ?>});
                lnRecNo = data.rows[0]['id'] * 1;
            }
            $(".loader").hide();
           condAwal();
        }); */
        var id = $('#id').val();
        
        $.post(site_url + 'crud/read', {table: 'ssystem', nav: '', id: id}, function (json) { 
            
            if (json !== '[]') {
                var rowData = $.parseJSON(json);
                                             
                $.each(rowData, function (i, v) {
                    $("#" + i).val(v);
                    
                    if(i== 'comp_city' || i== 'cotx_city' || i == 'dlrw_code' || i == 'mdlrw_code'){
                        $("#" + i).combogrid('setValue', v);
                    }
                    if(i== 'ppn' || i== 'pph'){
                        $("#" + i).numberbox('setValue', v);
                    }
                    if(i == 'comp_pkpdt'){
                        if (v !== '0000-00-00') {
                            var v_date = dateSplit(v);
                            $("#" + i).datebox('setValue', v_date);
                        }
                    }
                });
                
   
                $('.po_source_' + rowData.po_source).prop("checked", true);
                $('.vpg_source_' + rowData.vpg_source).prop("checked", true);
                $('.wo_source_' + rowData.wo_source).prop("checked", true);
                $('.optpur_set_' + rowData.optpur_set).prop("checked", true);
                $('.optprc_set_' + rowData.optprc_set).prop("checked", true);
                $('.bbn_set_' + rowData.bbn_set).prop("checked", true);
 
                if(rowData.comp_stamp == 1){
                    $('#comp_stamp').attr('checked', true);
                }
                if(rowData.comp_stmpp == 1){
                    $('#comp_stmpp').attr('checked', true);
                }
                
                 $(".loader").hide();
            }else{
                 $(".loader").hide();
            }
            
            condAwal();
        });
    }
    
    function copyFrom(){
        var empty = true;
        
        if($("#cotx_name").val() !==''){
            empty = false;
        }
        if($("#cotx_name2").val() !=='' ){
             empty = false;
        }
        if($("#cotx_add1").val() !==''){
             empty = false;
        }
        if($("#cotx_add2").val() !==''){
             empty = false;
        }
        if($("#cotx_add3").val() !==''){
             empty = false;
        }
        if($("#cotx_city").val() !==''){
             empty = false;
        }
        if($("#cotx_zipc").val()!==''){
             empty = false;
        }
        if($("#cotx_phone").val() !==''){
             empty = false;
        }
        if($("#cotx_fax").val() !==''){
             empty = false;
        }
        if($("#cotx_npwp").val() !==''){
             empty = false;
        }
        
        if(empty !==false){
            comp_name = $("#comp_name").val();
            comp_name2 = $("#comp_name2").val();
            comp_add1 = $("#comp_add1").val();
            comp_add2 = $("#comp_add2").val();
            comp_add3 = $("#comp_add3").val();
            comp_city = $("#comp_city").combogrid('getValue');
            comp_zipc = $("#comp_zipc").val();
            comp_phone = $("#comp_phone").val();
            comp_fax = $("#comp_fax").val();
            comp_npwp = $("#comp_npwp").val();
            
            $("#cotx_name").val(comp_name); 
            $("#cotx_name2").val(comp_name2);
            $("#cotx_add1").val(comp_add1);
            $("#cotx_add2").val(comp_add2);
            $("#cotx_add3").val(comp_add3);
            $("#cotx_city").combogrid('setValue',comp_city);
            $("#cotx_zipc").val(comp_zipc);
            $("#cotx_phone").val(comp_phone);
            $("#cotx_fax").val(comp_fax);
            $("#cotx_npwp").val(comp_npwp);

        }else{          
            alert("Untuk Copy Customer Info ke Tax Invoice Info, Semua informasi disini (Nama, Alamat,dsb) harus dikosongkan terlebih dahulu");
        }   
    }
    
    showdata('L', 0);
    version('05.04-17');
</script>