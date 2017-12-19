<div style="width: 100%; margin: 20px;" id="form_content">
    <form id="form_validation" method="post" action="">	
        <input type="hidden" name="id"  id="id">
        <input type="hidden" name="table"  id="table" value="<?php echo 'agent'; ?>">
        <div class="single-form">
            <table>
                <td width="400">
                    <table valign="top">
                        <?php
                        textbox('agent_code', 'Kode Biro Jasa', 90, 10);
                        textbox('agent_name', 'Nama Biro Jasa', 250, 25);
                        textarea('oaddr', 'Alamat', 250, 70);
                        cmdArea('oarea', 'Wilayah');
                        cmdCity('ocity', 'Kota');
                        zipbox('ozipcode', 'Kode Pos', 80);
                        cmdCountry('ocountry', 'Negara');
                        phonebox('ophone', 'Telepon', 250, 35);
                        phonebox('ofax', 'Fax', 90, 35);
                        textbox('note', 'Catatan', 250, 40);
                        ?>
                    </table>
                </td>

                <td valign="top">
                    <table>
                        <?php
                        phonebox('ohp', 'HP Pribadi', 250, 35);
                        textboxmail('oemail', 'Email', 250, 40);
                        ?>
                        <tr><td colspan="3"></td></tr>
                        <?php
                        phonebox('ocp1_name', 'Hubungi', 150);
                        textbox('ocp1_title', 'Jabatan', 150, 20);
                        ?>
                        <tr><td colspan="3"></td></tr>
                        <?php
                        phonebox('ocp2_name', 'Hubungi', 150);
                        textbox('ocp2_title', 'Jabatan', 150, 20);
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
        <div id="optionSPK" style="padding:10px;">
            <span><?php getCaption("Kode Biro Jasa"); ?>:</span>
            <input id="code" name="code">
            <span><?php getCaption("Nama Biro Jasa"); ?>:</span>
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
    var table = 'agent';
    var pk = 'agent_code';
    var sk = 'agent_name';

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
                    agent_code: rowData.agent_code,
                    agent_name: rowData.agent_name,
                    oaddr: rowData.oaddr,
                    ophone: rowData.ophone,
                    ocity: rowData.ocity,
                    ozipcode: rowData.ozipcode,
                    ocountry: rowData.ocountry,
                    ofax: rowData.ofax,
                    note: rowData.note,
                    oemail: rowData.oemail,
                    ocp1_name: rowData.ocp1_name,
                    ocp1_title: rowData.ocp1_title,
                    ocp2_name: rowData.ocp2_name,
                    ocp2_title: rowData.ocp2_title,
                    ohp: rowData.ohp,
                    oarea: rowData.oarea

                });
                $("#form_validation #id").val(rowData.id);

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
                    read_show('');
                    cmdcondAwal();
                    formDisabled();
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
    }

    function condAdd() {
        $(".easyui-datebox").datebox('enable');
        $('#id').val('');
        $('#form_validation :input').val('');
        $("#table").val(table);
        condReady();

    }
    function condEdit() {
        cmdcondReady();
        condReady();

    }
    function condDelete() {
        var id = $("#id").val();
        var table = $("#table").val();

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
</script>

<style>

    .table td{border:0px !important;padding:2px !important;}
</style>