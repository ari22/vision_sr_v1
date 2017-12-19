<div style="margin: 10px;" id="form_content">
    <form id="form_validation" method="post" action="">	
        <input type="hidden" name="id"  id="id">
        <input type="hidden" name="table"  id="table" value="<?php echo 'acc_wkcd'; ?>">
        <div class="single-form">
            <table cellpadding="3">
                <?php
                textbox('wk_code', 'Kode Pekerjaan', 70, 17);
                textbox('wk_desc', 'Nama Pekerjaan', 250, 50);
                ?>
                <tr>
                    <td>&nbsp;

                    </td>
                </tr>
                <?php
                numberbox('pur_price', 'Harga Beli', 80, 10);
                numberbox('sal_price', 'Harga Jual', 80, 10);
                ?>
                <tr>
                    <td>&nbsp;

                    </td>
                </tr>
                <?php
                textbox('add_by', 'Diinput Oleh', 90, 10);
                datebox('add_date', 'Tanggal Input', 250);
                ?>
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
        <div id="optionSPK" style="padding:10px;">
            <span><?php getCaption("Kode Kolektor"); ?>:</span>
            <input id="code" name="code">
            <span><?php getCaption("Nama kolektor"); ?>:</span>
            <input id="name" name="name" >
            <a href="#" class="easyui-linkbutton" onclick="doSearch()" iconCls="icon-search">Search</a>
            <button type="button"  title="<?php getCaption("Ok"); ?>" class="easyui-linkbutton easyui-tooltip btn btn-default" data-options="iconCls:'icon-ok'" onclick="getSearchselect()" >Ok </button>
            <button type="button" class="easyui-linkbutton easyui-tooltip btn btn-default" onclick="close_search();">Cancel</button>

        </div>

    </form>
</div>
<script>
    $(document).ready(function () {
        read_show('');
         version('01.04-17');
    });

    var table = 'acc_wkcd';
    var pk = 'wk_code';
    var sk = 'wk_desc';

    var pk_name = '<?php getCaption("Kode Pekerjaan"); ?>';
    var sk_name = '<?php getCaption("Nama Pekerjaan"); ?>';

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



    function read_show(nav) { //alert('hell')
        var id = $("#id").val();
            cmdcondAwal();
            formDisabled();
            //table_grid();
        $.post(site_url + 'master/vehicle/read', {table: table, nav: nav, id: id}, function (json) { //alert(json)
            
            $('#form_validation input:text').val('');
            $('#form_validation textarea').val('');
            $('#form_validation .easyui-combogrid').combogrid('setValue', '');
            $("#form_validation input:radio").prop("checked", false);
            $(".easyui-datebox").datebox('setValue', '');


            if (json !== '[]') {

                var rowData = $.parseJSON(json);

                $('#form_validation').form('load', {
                    wk_code: rowData.wk_code,
                    wk_desc: rowData.wk_desc,
                    pur_price: rowData.pur_price,
                    sal_price: rowData.sal_price,
                    add_by: rowData.add_by,
                    //add_date: rowData.add_date
                });
                $("#id").val(rowData.id);

                if (rowData.add_date !== '0000-00-00') {
                    var vdate = dateSplit(rowData.add_date);

                    $("#add_date").datebox('setValue', vdate);
                }

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
        var url = site_url + 'master/vehicle/save_vehicle';
        $('.loader').show();
        $('#form_validation').form('submit', {
            url: url,
            onSubmit: function () {
                return $(this).form('validate');
            },
            success: function (data) {

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

    }

    function condReady() {
        $('#form_validation :input').attr('disabled', false);
        $("#add_date").datebox('disable');
        $('#add_by').attr('disabled', true);
        $('.easyui-combogrid').combogrid('enable');

        cmdcondReady();
    }

    function cmdcondReady() {

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
        $(".easyui-datebox").datebox('enable');
        $('#id').val('');
        $('#form_validation :input').val('');
        $("#table").val(table);
        condReady();
        $("#add_date").datebox('setValue', '<?php echo date('d/m/Y');?>');
        $('#add_by').val('<?php echo $username;?>');
    }
    function condEdit() {
        cmdcondReady();
        condReady();
        $("#table").val(table);
    }
    function condDelete() {
        var id = $("#id").val();
        //var table = $("#table").val();

        $.messager.confirm('Warning', 'Are you sure delete selected data ?', function (r) {
            if (r) {

                var url = site_url + 'master/vehicle/delete';

                $('.loader').show();

                $.post(url, {table: table, id: id}, function (data) { //alert(data)
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
