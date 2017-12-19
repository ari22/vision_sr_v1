<div style="margin: 10px;" id="form_content">
    <form id="form_validation" method="post" action="">	
        <input type="hidden" name="id"  id="id">
        <input type="hidden" name="table"  id="table" value="<?php echo 'veh_wkcd'; ?>">

        <div class="single-form">
            <table>
                <?php textbox('wk_code', 'Kode Pekerjaan', 150, 150) ?>
                <?php textbox('wk_desc', 'Nama Pekerjaan', 250, 150) ?>
                <tr><td colspan="3"></td></tr> <tr><td colspan="3"></td></tr>
                <tr><td colspan="3"></td></tr> <tr><td colspan="3"></td></tr>
                <?php numberbox('pur_price', 'Harga Beli', 120, 120) ?>
                <?php numberbox('sal_price', 'Harga Jual', 120, 120) ?>
                <tr><td colspan="3"></td></tr> <tr><td colspan="3"></td></tr>
                <tr><td colspan="3"></td></tr> <tr><td colspan="3"></td></tr>
                <?php textbox('add_by', 'Diinput Oleh', 150, 150) ?>
                <?php datebox('add_date', 'Tgl. Input') ?>
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

    <div id="SearchOption" style="display:none;">  
        <form id="form_validation2" method="post" >    
            <div id="optionSPK" style="padding:10px;">
                <span><?php getCaption("Kode Pekerjaan"); ?>:</span>
                <input id="wk_code2" name="wk_code2">
                <span><?php getCaption("Nama Pekerjaan"); ?>:</span>
                <input id="wk_desc2" name="wk_desc2" >
                <a href="#" class="easyui-linkbutton" onclick="doSearch()" iconCls="icon-search">Search</a>
                <button type="button"  title="<?php getCaption("Ok"); ?>" class="easyui-linkbutton easyui-tooltip btn btn-default" data-options="iconCls:'icon-ok'" onclick="getSearchselect()" >Ok </button>
                <button type="button" class="easyui-linkbutton easyui-tooltip btn btn-default" onclick="close_search();">Cancel</button>

            </div>

        </form>
    </div>
</div>

<script>
    $(document).ready(function () {
        read_show('');
         version('01.04-17');
    });

    var table = 'veh_wkcd';
    var pk = 'wk_code';
    var sk = 'wk_desc';

    var pk_name = '<?php getCaption("Kode Sales"); ?>';
    var sk_name = '<?php getCaption("Nama Sales"); ?>';

    function read_show(nav) {
        var id = $("#form_validation #id").val();
        cmdcondAwal();
        formDisabled();

        $('#form_validation input:text').val('');
        //$('#form_validation .easyui-numberbox').numberbox('setValue', '');

        $.post(site_url + 'master/vehicle/read', {table: table, nav: nav, id: id}, function (json) { //alert(json)
            //console.log(json);
            if (json !== '[]') {

                var rowData = $.parseJSON(json);


                $.each(rowData, function (i, v) {
                    $("#" + i).val(v);

                    if (i == 'pur_price' || i == 'sal_price') {
                        $("#" + i).numberbox('setValue', v);
                    }

                    if (i == 'add_date') {
                        if (v !== '0000-00-00') {
                            var vdate = dateSplit(v);

                            $("#add_date").datebox('setValue', vdate);
                        }
                    }
                });
                
              

            }else {
                cmdcondAwal();
                cmdEmptyData();
            }
        });

        $('.loader').hide();
    }


    function doSearch() {
        $("#tableSearch").datagrid('load', {
            field1: $('#wk_code2').val(),
            field2: $('#wk_desc2').val()
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
        $('#form_validation .easyui-numberbox').numberbox('disable');
        $(".easyui-datebox").datebox('disable');
        cmdcondAwal();

    }

    function saveData() {
        $('#form_validation :input').attr('disabled', false);
        //$('#form_validation').validationEngine();
        var url = site_url + 'master/vehicle/save_vehicle';
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

        $('#form_validation .easyui-combogrid').combogrid('enable');
        $("#form_validation .easyui-datebox").datebox('enable');
        $("#add_by").attr('disabled', true);
        $("#add_date").datebox('disable');
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

    function emptyForm() {
        $('#form_validation input:text').val('');
        $('#form_validation textarea').val('');
        $('#form_validation .easyui-combogrid').combogrid('setValue', '');
        $("#form_validation input:radio").prop("checked", false);
        $(".easyui-datebox").datebox('setValue', '');
        $('#form_validation .easyui-numberbox').numberbox('setValue', '');
    }
    function condAdd() {

        emptyForm();
        $('#form_validation #id').val('');

        $("#table").val(table);
        condReady();
        $("#form_validation input:radio").prop("checked", false);
        $('#wk_code').focus();

        $("#add_by").val('<?php echo $username; ?>');
        $("#add_date").datebox('setValue', '<?php echo date('d/m/Y'); ?>');
    }
    function condEdit() {
        cmdcondReady();
        condReady();
        $("#wk_code").attr('disabled', true);
        $('#wk_name').focus();
    }
    function condDelete() {
        var id = $("#form_validation #id").val();
        var table = $("#form_validation #table").val();

        $.messager.confirm('Warning', 'Are you sure delete selected data ?', function (r) {
            if (r) {
                $('.loader').show();
                var url = site_url + 'master/vehicle/delete';

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
    //showAlert("Information", 'Loading...');
</script>