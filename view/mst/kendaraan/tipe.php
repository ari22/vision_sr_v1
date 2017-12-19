<div style="margin: 10px;" id="form_content">
    <form id="form_validation" method="post" action="" enctype="multipart/form-data">	
        <input type="hidden" name="id"  id="id">
        <input type="hidden" name="table"  id="table" value="<?php echo 'veh_vtyp'; ?>">

        <div class="single-form">
            <table class="table" >
                <tr>
                    <td valign="top" width="400">
                        <table>
                            <?php
                            textbox('veh_code', 'Kode Kendaraan', 90, 10);
                            textbox('veh_name', 'Deskripsi', 280, 80);
                            cmdBrnd('veh_brand', 'Merek', 1, 1);
                            textbox('veh_type', 'Tipe', 100, 15);
                            cmdMod('veh_model', 'Model');
                            textbox('veh_year', 'Tahun', 50, 4);
                            cmdTransm('veh_transm', 'Transmisi');
                            textbox('note', 'Catatan', 280, 40);
                            ?>                 
                        </table>
                    </td>
                    <td valign="top">
                        <table>
                            <?php
                            textbox('chas_pref', 'Chassis Prefix', 150, 17);
                            textbox('eng_pref', 'Engine Prefix', 150, 20);
                            datebox('act_date', 'Tanggal Aktif', 90);
                            datebox('exp_date', 'Tanggal Non Aktif', 90);
                            ?>
                            <tr>
                                <td>Image</td>
                                <td>:</td>
                                <td>
                                    <input type="file" id="veh_image" name="veh_image" title="browse" class="easyui-validatebox" >
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td width="30"></td>
                    <td>
                        <div id="imagesview"></div>
                    </td>
                </tr>

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
            <span><?php getCaption("Kode Kendaraan"); ?>:</span>
            <input id="code" name="code">
            <span><?php getCaption("Deskripsi"); ?>:</span>
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

    var table = 'veh_vtyp';
    var pk = 'veh_code';
    var sk = 'veh_name';

    var pk_name = '<?php getCaption("Kode Kendaraan"); ?>';
    var sk_name = '<?php getCaption("Deskripsi"); ?>';

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
            $('#form_validation input:file').val('');
            $('#form_validation textarea').val('');
            $('#form_validation .easyui-combogrid').combogrid('setValue', '');
            $("#form_validation input:radio").prop("checked", false);
            $(".easyui-datebox").datebox('setValue', '');


            if (json !== '[]') {

                var rowData = $.parseJSON(json);

                $('#form_validation').form('load', {
                    veh_code: rowData.veh_code,
                    veh_brand: rowData.veh_brand,
                    veh_type: rowData.veh_type,
                    veh_model: rowData.veh_model,
                    veh_year: rowData.veh_year,
                    veh_transm: rowData.veh_transm,
                    veh_name: rowData.veh_name,
                    chas_pref: rowData.chas_pref,
                    eng_pref: rowData.eng_pref,
                    //act_date: rowData.act_date,
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

                /*if (rowData.veh_image !== '') {
                    $("#imagesview").empty().append('<img src="uploads/' + rowData.veh_image + '" width="250"><button type="button" id="cmdDeleteImage" title="Hapus" data-options=\'iconCls:"icon-no"\' class="easyui-linkbutton"  onclick="DelPicture()" >x</button>');

                } else {
                    $("#imagesview").empty().append('<img src="uploads/no-image.png"  width="250" height="250">');
                }*/

            } else {
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
        $('#form_validation .easyui-combogrid').combogrid('disable');
        $('#form_validation .easyui-combobox').combobox({disabled: true});
        $('#form_validation .combo-text').removeClass('validatebox-text');
        $('#form_validation .combo-text').removeClass('validatebox-invalid');
        $(".easyui-datebox").datebox('disable');
        cmdcondAwal();

    }
    function saveData() {
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

        $('#form_validation #id').val('');
        $('#form_validation :input').val('');
        $("#table").val(table);
        condReady();
        $("#form_validation input:radio").prop("checked", false);
    }
    function condEdit() {
        cmdcondReady();
        condReady();
        $("#form_validation #veh_code").attr('disabled', true);
        $('#form_validation #veh_name').focus();
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
	function DelPicture(){
		alert('hellop');
	}

</script>

<style>
    .table td{border:0px !important;padding:2px !important;}
</style>