<div style=" margin: 10px;" id="form_content">
    <form id="form_validation" action="" method="post" >
        <div class="single-form">
            <table>
                <tr>
                    <td style="border:1px solid #ddd !important;border-radius:4px;background: #f4f4f4">
                        <input type="hidden" id="status">
                        <table class="table"  style="
                        <?php
                        if ($table == 'bus_item') {
                            
                        } elseif ($table == 'action') {
                            
                        } elseif ($table == 'veh_tran') {
                            
                        } elseif ($table == 'veh_wrhs') {
                            
                        } elseif ($table == 'prt_mdin') {
                            
                        } elseif ($table == 'prt_use4') {
                            
                        } elseif ($table == 'prt_sgrp') {
                            
                        } elseif ($table == 'prt_wrhs') {
                            
                        } elseif ($table == 'pinv') {
                            
                        } else {
                            echo ' width:400px;';
                        }
                        ?>
                               ">
                            <input type="hidden" name="id"  id="id">
                            <input type="hidden" name="table"  id="table" value="<?php echo $table; ?>">
                            <tr>
                                <td><?php echo $field1->caption; ?></td>
                                <td class="td-ro">:</td>
                                <td><input class="textbox" type="text" id="<?php echo $field1->name; ?>" name="<?php echo $field1->name; ?>" style="width:<?php echo $field1->width; ?>px;" disabled=true maxlength="<?php echo $field1->maxlength; ?>"></input></td>
                            </tr>
                            <tr>
                                <td><?php echo $field2->caption; ?></td>
                                <td class="td-ro">:</td>
                                <td><input class="textbox" type="text" id="<?php echo $field2->name; ?>" name="<?php echo $field2->name; ?>" style="width:<?php echo $field2->width; ?>px;" disabled=true maxlength="<?php echo $field2->maxlength; ?>"></input></td>
                            </tr>                                                                                                          
                        </table>
                    </td>
                </tr>
                <tr><td></td></tr>
                <tr>
                    <td>
                        <table id="dt" class="easyui-datagrid table"  title="" style="width:780px;height:345px;padding: 0px 10px 20px 20px;"></table>

                    </td>
                </tr>
            </table>
        </div>
        <div class="main-nav">

            <table width="100%">
                <tr>
                    <td> 
                        <table class="table" style="width:500px;" border="0">
                            <tr>
                                <td  style="border-top:0px !important;">
                                    <button type="button" id="cmdFirst" title="First"  data-options="iconCls:'icon-first'" class="easyui-linkbutton easyui-tooltip cmdFirst" onclick="read_show('F')"></button>
                                    <button type="button" id="cmdPrev" title="Prev" data-options="iconCls:'icon-prev'" class="easyui-linkbutton easyui-tooltip cmdPrev"  onclick="read_show('P')" ></button>
                                    <button type="button" id="cmdNext" title="Next" data-options="iconCls:'icon-next'" class="easyui-linkbutton easyui-tooltip cmdNext"  onclick="read_show('N')" ></button>
                                    <button type="button" id="cmdLast" title="Last" data-options="iconCls:'icon-last'" class="easyui-linkbutton easyui-tooltip cmdLast"  onclick="read_show('L')" ></button>
                                </td>
                                <td  style="border-top:0px !important;">
                                    <button type="button" id="cmdSave" title="Save"  data-options="iconCls:'icon-save',group:'g2'" class="easyui-linkbutton easyui-tooltip cmdSave" onclick="saveData()" ></button>
                                    <button type="button" id="cmdCancel" title="Batal" data-options="iconCls:'icon-undo',group:'g2'" class="easyui-linkbutton easyui-tooltip cmdCancel"  onclick="condCancel()"  ></button>
                                </td>
                                <td  style="border-top:0px !important;">
                                    <button type="button" id="cmdAdd" title="Add" data-options="iconCls:'icon-add'" class="easyui-linkbutton easyui-tooltip cmdAdd"  onclick="rolesAdd()"></button>
                                    <button type="button" id="cmdEdit" title="Update" data-options="iconCls:'icon-edit'" class="easyui-linkbutton easyui-tooltip cmdEdit"  onclick="rolesEdit()" ></button>
                                    <button type="button" id="cmdDelete" title="Delete" data-options="iconCls:'icon-no'" class="easyui-linkbutton easyui-tooltip cmdDelete"  onclick="rolesDel()" ></button>
                                    <!--<a href="#" id="cmdSearch" title="Search" class="glyphicon glyphicon-search btn btn-default" data-options="iconCls:'icon-search'" onclick="condSearch()" ></a>-->
                                    <!---<a  data-options="iconCls:'icon-ok'" class="glyphicon glyphicon-ok btn btn-default" href="javascript:void(0)" onclick="window_close()" ></a>-->
                                </td>

                            </tr>
                        </table>   
                    </td>
                    <td align="right"><img src="<?php echo "../lib/jeasyui/themes/icons/version.png" ?>" id="version"></td>
                </tr>
            </table>    
            <script>
                function condSearch() {
                    $('#windowSearch').window('open');
                }
                $('.easyui-linkbutton').linkbutton();
            </script>
        </div>


        <div id="toolbar" style="padding:3px">
            <span><?php echo $field1->caption; ?>:</span>
            <input id="field1" name="field1" class="easyui-validatebox">
            <span><?php echo $field2->caption; ?>:</span>
            <input id="field2" name="field2" class="easyui-validatebox">
            <a href="#" title="Search" data-options="iconCls:'icon-search'" id="search" class="easyui-linkbutton easyui-tooltip" plain="true" onclick="doSearch()" ></a>
            <a href="#" title="Refresh" data-options="iconCls:'icon-reload'" id="refresh" class="easyui-linkbutton easyui-tooltip" plain="true" onclick="refresh()" ></a>

        </div>

    </form>
</div>

<script>

    var table = '<?php echo $table; ?>';

    function showAlert(title, msg) {
        $.messager.show({
            title: title,
            msg: msg,
            //showType:'show',
            timeout: 2000,
            showType: 'fade',
            style: {
                right: '',
                bottom: ''
            }
        });
    }



    function table_grid() {
        $("#dt").datagrid({
            method: 'post',
            url: site_url + 'master/lookup/grid_lookup/' + table + '/?grid=true',
            // title: 'Master Standart Optional',
            idField: 'id',
            fitColumns: true,
            singleSelect: true,
            nowrap: true,
            fit: false,
            rownumbers: false,
            pageSize: 10,
            showFooter: true,
            pagination: true,
            toolbar: '#toolbar',
            columns: [[
                    {field: '<?php echo $field1->name; ?>', title: '<?php echo $field1->caption; ?>', width: 120, height: 20, sortable: true},
                    {field: '<?php echo $field2->name; ?>', title: '<?php echo $field2->caption; ?>', width: 120, height: 20, sortable: true}
                ]]
        });





        $('#dt').datagrid({
            onSelect: function (rowIndex, rowData) {
                var status = $("#status").val();
                if (status == '') {
                    $("#<?php echo $field1->name; ?>").val(rowData.<?php echo $field1->name; ?>);
                    $("#<?php echo $field2->name; ?>").val(rowData.<?php echo $field2->name; ?>);
                    $("#id").val(rowData.id);
                    //lnRecNo = rowData.id;
                } else {
                    $('#<?php echo $field2->name; ?>').focus();
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

        $("#<?php echo $field1->name; ?>").attr('disabled', true);
        $("#<?php echo $field2->name; ?>").attr('disabled', true);


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
    }

    function condReady() {

        $("#<?php echo $field1->name; ?>").val('').removeAttr('disabled');
        $("#<?php echo $field2->name; ?>").val('').removeAttr('disabled');
        $('#<?php echo $field1->name; ?>').focus();

        $("#field1, #field2, #refresh, #search").attr('disabled', true);
        $('#refresh').linkbutton('disable');
        $('#search').linkbutton('disable');


    }

    function condEditReady() {

        $("#<?php echo $field2->name; ?>").removeAttr('disabled');
        $('#<?php echo $field2->name; ?>').focus();
        $("#field1, #field2, #refresh, #search").attr('disabled', true);
        $('#refresh').linkbutton('disable');
        $('#search').linkbutton('disable');
    }
    function condAdd() {
        cmdcondReady();
        condReady();
        $("#id").val('');

    }
    function condEdit() {
        cmdcondReady();
        condEditReady();
        $("#status").val('1');
    }
    function condCancel() {
        cmdcondAwal();
        read_show();

        $(".formError").remove();
        $("#status").val('');
    }
    function saveData() {
        $('.loader').show();
        var url = site_url + 'master/lookup/save_lookup';

        $('#form_validation').form('submit', {
            url: url,
            onSubmit: function () {
                return $(this).form('validate');
            },
            success: function (data) {
                obj = JSON.parse(data);
                if (obj.success == true) {
                    showAlert("Information", 'saving');
                    cmdcondAwal();
                    $('#dt').datagrid('reload');
                    read_show('');
                    $("#status").val('');
                    $('.loader').hide();
                } else
                {
                    $('.loader').hide();
                    showAlert("Error while saving", '<font color="red">' + obj.message + '</font>');
                }
            }
        });
    }

    function condDelete() {
        var id = $("#id").val();
        $.messager.confirm('Warning', 'Are you sure delete selected data ?', function (r) {
            if (r) {
                $('.loader').show();
                var url = site_url + 'master/lookup/delete';
                $('#form_validation').form('submit', {
                    url: url,
                    onSubmit: function () {
                        return $(this).form('validate');
                    },
                    success: function (data) {
                        obj = JSON.parse(data);
                        if (obj.success == true) {
                            $("#id").val('');
                            read_show('');
                            showAlert("Information", obj.message);
                            cmdcondAwal();
                            $("#status").val('');
                            $('#dt').datagrid('reload');
                            $('.loader').hide();

                        } else
                        {
                            $('.loader').hide();
                            showAlert("Error while delete", '<font color="red">' + obj.message + '</font>');
                        }
                    }
                });
            }
        });
    }

    function doSearch() {
        $('#dt').datagrid('load', {
            field1: $('#field1').val(),
            field2: $('#field2').val()
        });
    }


    function refresh() {
        $('#field1').val('');
        $('#field2').val('');
        $('#dt').datagrid('load', {
            field1: $('#field1').val(),
            field2: $('#field2').val()
        });
    }
    function read_show(nav) {
        var id = $("#id").val();
         cmdcondAwal();
        $.post('<?php echo site_url(); ?>master/lookup/read', {table: table, nav: nav, id: id}, function (json) {

            $('#form_validation input:text').val('');
            if (json !== '[]') {
                var rowData = $.parseJSON(json);


                $("#<?php echo $field1->name; ?>").val(rowData.<?php echo $field1->name; ?>);
                $("#<?php echo $field2->name; ?>").val(rowData.<?php echo $field2->name; ?>);
                $("#id").val(rowData.id);
            }
            else {
                cmdcondAwal();
                cmdEmptyData();
            }
            table_grid();

            $("#field1, #field2, #refresh, #search").attr('disabled', false);
            $('#refresh').linkbutton('enable');
            $('#search').linkbutton('enable');
            $('.loader').hide();
        });
    }

    $(document).ready(function () {
       
        read_show('');
        version('<?php echo $v; ?>');

        $('#dd').window({
            width: 735,
            center: true
                    //  title:'<?php echo $form_title; ?>'
        });
        dialog_page();
        
    });


</script>
