<div style="margin: 10px;" id="form_content">
    <form id="form_validation" method="post" action="">	
        <input type="hidden" name="id"  id="id">
        <input type="hidden" name="table"  id="table" value="<?php echo 'veh_srep'; ?>">
        <div class="single-form">
            <table>
                <td valign="top">
                    <table>
                        <?php
                        textbox('srep_code', 'Kode Sales', 60, 3);
                        textbox('srep_name', 'Nama Sales', 200, 25);
                        textarea('haddr', 'Alamat', 200, 70);
                        phonebox('hphone', 'Telepon', 200);
                        cmdCity('hcity', 'Kota');
                        zipbox('hzipcode', 'Kode Pos', 80);
                        phonebox('hp', 'HP Pribadi', 200);
                        cmdLastEdu('highestedu', 'Pendidikan Tertinggi');
                        textarea('train_exp', 'Pelatihan', 200, 200);
                        textbox('note', 'Catatan', 200, 40);
                        ?>
                    </table>
                </td>
                <td width="50"></td>
                <td valign="top">
                    <table>

                        <tr>
                            <td valign="top" class="checkboxValign"><?php getCaption("Jenis Kelamin"); ?> </td>
                            <td valign="top" class="td-ro checkboxValign">:</td>
                            <td>   
                                <table  width="130" class="checkboxBorder">
                                    <tr><td> <a href="#" class="checkbox" name="sex_1"><input type="radio" id="sex_1" class="sex_1"  name="sex" value="1"> <?php getCaption("Pria"); ?></a></td></tr>
                                    <tr><td><a href="#" class="checkbox" name="sex_2"><input type="radio" id="sex_2" class="sex_2" name="sex" value="2"> <?php getCaption("Wanita"); ?></a></td></tr>
                                    <tr><td><a href="#" class="checkbox" name="sex_3"><input type="radio" id="sex_3" class="sex_3" name="sex" value="3"> <?php getCaption("Perusahaan"); ?></a></td></tr>
                                </table>
                            </td>
                        </tr>

                        <?php
                        //cmdSex('sex', 'Jenis Kelamin');
                        cmdSalesLevel('srep_lev', 'Sales Level', 130);

                        datebox('in_date', 'Tanggal Masuk');
                        datebox('out_date', 'Tanggal Keluar');

                        datebox('dob', 'Tanggal Lahir');
                        //cmdCity('pob', 'Lahir Di');
                        textbox('pob', 'Lahir Di', 200, 40);
                        cmdRelig('relig_code', 'Agama', 130);
                        ?>

                        <tr><td colspan="3"></td></tr>
                        <tr><td colspan="3"></td></tr>
                        <tr><td colspan="3"></td></tr>
                        <?php
                        cmdSpvSet('sspv_code', 'sspv_name', 'Supervisor');
                        textbox('sspv_lev', 'Supervisor Level', 120, 40);
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
            <span><?php getCaption("Kode Sales"); ?>:</span>
            <input id="srep_code2" name="srep_code">
            <span><?php getCaption("Nama Sales"); ?>:</span>
            <input id="srep_name2" name="srep_name" >
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

    var table = 'veh_srep';
    var pk = 'srep_code';
    var sk = 'srep_name';

    var pk_name = '<?php getCaption("Kode Sales"); ?>';
    var sk_name = '<?php getCaption("Nama Sales"); ?>';

    $("#sspv_name").combogrid({
        onSelect: function (index, row) {
            $("#sspv_code").val(row.sspv_code);
            $("#sspv_lev").val(row.sspv_lev);
        }
    });

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
        var id = $("#form_validation #id").val();
        cmdcondAwal();
        formDisabled();
        $('#form_validation input:text').val('');
        $('#form_validation textarea').val('');
        $('#form_validation .easyui-combogrid').combogrid('setValue', '');
        $("#form_validation input:radio").prop("checked", false);
        $(".easyui-datebox").datebox('setValue', '');

        $.post(site_url + 'master/vehicle/read', {table: table, nav: nav, id: id}, function (json) { //alert(json)
            //console.log(json);
            if (json !== '[]') {

                var rowData = $.parseJSON(json);

                $('.sex_' + rowData.sex).prop("checked", true);
                $.each(rowData, function (i, v) {
                    if (i == 'in_date' || i == 'out_date' || i == 'dob') {
                        if (v !== '0000-00-00') {
                            var vdate = dateSplit(v);

                            $("#" + i).datebox('setValue', vdate);
                        }
                    }
                });

                $('#form_validation').form('load', {
                    srep_code: rowData.srep_code,
                    srep_name: rowData.srep_name,
                    haddr: rowData.haddr,
                    hphone: rowData.hphone,
                    hcity: rowData.hcity,
                    hzipcode: rowData.hzipcode,
                    hp: rowData.hp,
                    highestedu: rowData.highestedu,
                    train_exp: rowData.train_exp,
                    note: rowData.note,
                    //sex: rowData.sex,
                    srep_lev: rowData.srep_lev,
                    marital_st: rowData.marital_st,
                    //in_date: rowData.in_date,
                    //out_date: rowData.out_date,
                    //dob: rowData.dob,
                    pob: rowData.pob,
                    relig_code: rowData.relig_code,
                    sspv_lev: rowData.sspv_lev,
                    sspv_code: rowData.sspv_code,
                    sspv_name: rowData.sspv_name

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
            field1: $('#srep_code2').val(),
            field2: $('#srep_name2').val()
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
        //$("#supp_code").attr('disabled', true);
        $('#form_validation .easyui-combogrid').combogrid('enable');
        $("#form_validation .easyui-datebox").datebox('enable');
        $("#sspv_lev").attr('disabled', true);
        $("#sspv_code").attr('disabled', true);
        checkboxClick();
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
    }
    function condAdd() {

        emptyForm();
        $('#form_validation #id').val('');

        $("#table").val(table);
        condReady();
        $("#form_validation input:radio").prop("checked", false);
        $('#srep_code').focus();
    }
    function condEdit() {
        cmdcondReady();
        condReady();
        $("#srep_code").attr('disabled', true);
        $('#srep_name').focus();
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
