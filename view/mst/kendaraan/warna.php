<div style="margin: 10px;" id="form_content">
    <form id="form_validation" method="post" action="">	
        <input type="hidden" name="id"  id="id">
        <input type="hidden" name="table"  id="table" value="<?php echo 'color'; ?>">
        <div class="single-form">
            <table class="table">
                <td>
                    <table>
                        <?php
                        textbox('color_code', 'Kode', 90, 10);
                        textbox('color_name', 'Warna', 250, 35);
                        cmdColorType('type', 'Tipe');
                        datebox('act_date', 'Tgl. Aktif', 120);
                        datebox('exp_date', 'Tgl. Non Aktif', 120);
                        textbox('note', 'Catatan', 250, 40);
                        ?>
                    </table>
                </td>	
            </table>
        </div>
        <div class="main-nav">
            <table width="100%">
                <tr>
                    <td> <?php navigation_ci(); ?></td>
                    <td align="right"><img src="<?php echo $loc_jui . "themes/icons/version.png" ?>" id="version"></td>
                </tr>
            </table>          
        </div>
    </form>	
</div>

<div id="SearchOption" style="display:none;">  
    <form id="form_validation2" method="post" >    
        <div style="padding:10px;">
            <span><?php getCaption("Kode"); ?>:</span>
            <input id="code" name="code">
            <span><?php getCaption("Warna"); ?>:</span>
            <input id="name" name="name" >
            <a href="#" class="easyui-linkbutton" onclick="doSearch()" iconCls="icon-search">Search</a>
            <button type="button"  title="<?php getCaption("Ok"); ?>" class="easyui-linkbutton easyui-tooltip btn btn-default" data-options="iconCls:'icon-ok'" onclick="getSearchselect()" >Ok </button>
            <button type="button" class="easyui-linkbutton easyui-tooltip btn btn-default" onclick="close_search();">Cancel</button>

        </div>

    </form>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        read_show('');
         version('01.04-17');
    });

    var table = 'color';
    var pk = 'color_code';
    var sk = 'color_name';

    var pk_name = '<?php getCaption("Kode"); ?>';
    var sk_name = '<?php getCaption("Warna"); ?>';

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

    function read_show(nav) {
        var id = $("#id").val();
        cmdcondAwal();
            formDisabled();
        $.post(site_url + 'master/vehicle/read', {table: table, nav: nav, id: id}, function (json) { //alert(json)

            $('#form_validation input:text').val('');
            $('#form_validation textarea').val('');
            $('#form_validation .easyui-combogrid').combogrid('setValue', '');
            $("#form_validation input:radio").prop("checked", false);
            $(".easyui-datebox").datebox('setValue', '');

            if (json !== '[]') {
                var rowData = $.parseJSON(json);

                $('#form_validation').form('load', {
                    color_code: rowData.color_code,
                    color_name: rowData.color_name,
                    type: rowData.type,
                    // act_date: rowData.act_date,
                    //exp_date: rowData.exp_date,
                    note: rowData.note
                });
                $("#id").val(rowData.id);

                $.each(rowData, function (i, v) {
                    if (i == 'act_date' || i == 'exp_date') {
                        if (v !== '0000-00-00') {
                            var vdate = dateSplit(v);

                            $("#" + i).datebox('setValue', vdate);
                        }
                    }
                });


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
        $("#form_validation .easyui-datebox").datebox('disable');
        $('#form_validation input:text').attr('disabled', true);

        $('#form_validation .easyui-combogrid').combogrid('disable');

        $('#form_validation .combo-text').removeClass('validatebox-text');
        $('#form_validation .combo-text').removeClass('validatebox-invalid');
        $(".easyui-datebox").datebox('disable');
    }
    function saveData() {
        $('#form_validation :input').attr('disabled', false);
        var url = site_url + 'master/vehicle/save_vehicle';
        $('.loader').show();
        $('#form_validation').form('submit', {
            url: url,
            onSubmit: function () {
                return $(this).form('validate');
            },
            success: function (data) {//alert(data)

                var obj = JSON.parse(data);
                if (obj.success == true) {
                    showAlert("Information", obj.message);
                    cmdcondAwal();
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

    }

    function condReady() {
        $('#form_validation :input').attr('disabled', false);
        //$("#supp_code").attr('disabled', true);
        $('#form_validation .easyui-combogrid').combogrid('enable');
        $("#form_validation .easyui-datebox").datebox('enable');
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
    }

    function condAdd() {
        $("#form_validation .easyui-datebox").datebox('enable');
        $('#id').val('');
        $('#form_validation :input').val('');
        $("#table").val(table);
        condReady();

        $('#coll_code').focus();
    }
    function condEdit() {
        cmdcondReady();
        condReady();
        $("#color_code").attr('disabled', true);
        $('#color_name').focus();
    }
    function condDelete() {
        var id = $("#id").val();
        var table = $("#table").val();

        $.messager.confirm('Warning', 'Are you sure delete selected data ?', function (r) {
            if (r) {

                var url = site_url + 'master/vehicle/delete';
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

</script>

<style>

    .table td{border:0px !important;padding:2px !important;}
</style>