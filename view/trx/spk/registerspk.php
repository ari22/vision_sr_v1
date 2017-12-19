<?php
$form = 'registerspk';
$table = "veh_spkreg";
$lookup = 'trx/' . $table;
?>
<script>


    var urls = site_url + '<?php echo 'builder/grid_spkreg/' . encrypt_decrypt('encrypt', 'veh_spkreg'); ?>/register/?grid=true';


    $.extend($.fn.datagrid.methods, {
        editCell: function (jq, param) {
            return jq.each(function () {
                var opts = $(this).datagrid('options');
                var fields = $(this).datagrid('getColumnFields', true).concat($(this).datagrid('getColumnFields'));
                for (var i = 0; i < fields.length; i++) {
                    var col = $(this).datagrid('getColumnOption', fields[i]);
                    col.editor1 = col.editor;
                    if (fields[i] != param.field) {
                        col.editor = null;
                    }
                }
                $(this).datagrid('beginEdit', param.index);
                for (var i = 0; i < fields.length; i++) {
                    var col = $(this).datagrid('getColumnOption', fields[i]);
                    col.editor = col.editor1;
                }
            });
        }
    });

    var editIndex = undefined;
    function endEditing() {
        if (editIndex == undefined) {
            return true;
        }
        if ($('#dg').datagrid('validateRow', editIndex)) {
            $('#dg').datagrid('endEdit', editIndex);
            editIndex = undefined;
            return true;
        } else {
            return false;
        }
    }
    function onClickCell(index, field) {
        if (endEditing()) {
            $('#dg').datagrid('selectRow', index)
                    .datagrid('editCell', {index: index, field: field});
            editIndex = index;
        }
    }
    function onEndEdit(index, row) {
        if (editIndex == undefined) {
            return false;
        }
        $.post(site_url + 'transaction/spk/save_note_spkreg', {table: '<?php echo encrypt_decrypt('encrypt', 'veh_spkreg'); ?>', so_no: row.so_no, so_note: row.so_note}, function (res) {
            return true;
        });
    }

    function rolesReg() {
        var num = checkRoles('gn');
        if (num == '1') {
            register();
            return false;
        }

        errorAccess();
    }

    function condEnable()
    {
        $('#so_no').attr('disabled', false);
        $('#sd_no').attr('disabled', false);
    }
    function getPrefix()
    {
        url = "services/runCRUD.php?func=prefix&lookup=<?php echo $lookup; ?>";
        $.post(url)
                .done(function (data) {
                    $('#spk_prefix').val(data);
                    $('#spk_prefix2').val(data);
                });
    }

    function register()
    {
        //alert("Register Button clicked");
        RegisterSPK();
    }

    function RegisterSPK() {
        url = "services/runCRUD.php";
        lcSoNo = $('#so_no').val();
        lcSdNo = $('#sd_no').val();

        var stat = true;

        if (lcSdNo == '') {
            stat = false;
            input = 'sd_no';
            text = '<?php getCaption('s/d No.'); ?>'
        }

        if (lcSoNo == '') {
            stat = false;
            input = 'so_no';
            text = '<?php getCaption('No. SPK'); ?>'
        }

        if (stat !== false) {
            if (parseInt(lcSoNo) > parseInt(lcSdNo)) {
                showAlert("Error while saving", 'SPK No. to be registered have to be in ascending order');
            } else {
                var data = "lookup=<?php echo $lookup; ?>" + "&func=create&so_no=" + lcSoNo + "&sd_no=" + lcSdNo;
                $('.loader').show();
                $.post(url, data).done(function (data)
                {

                    obj = JSON.parse(data);
                    if (obj.success == true)
                    {

                        $('#so_no').val('');
                        $('#sd_no').val('');
                        showAlert("Information", obj.message);
                        $('#dg').datagrid('reload');
                        $('.loader').hide();
                    } else
                    {
                        showAlert("Error while saving", obj.message);
                        $('#dg').datagrid('reload');
                        $('.loader').hide();
                    }
                }).fail(function () {
                    showAlert("Error", "Error while saving");
                    $('#dg').datagrid('reload');
                    $('.loader').hide();
                });
            }
        } else {
            $('#' + input).validatebox({required: true});
            showAlert("Error", text + " cannot be empty");

        }
    }


    function tableSPKReg(urls) {
        $("#dg").datagrid({
            method: 'post',
            url: urls,
            idField: 'id',
            fitColumns: false,
            singleSelect: true,
            nowrap: true,
            fit: false,
            rownumbers: true,
            pageSize: 10,
            showFooter: false,
            pagination: true,
            onClickCell: onClickCell,
            onEndEdit: onEndEdit,
            columns: [[
                    {field: 'so_no', title: '<?php getCaption("No. SPK"); ?>', width: 130, height: 20},
                    {field: 'so_regdate', title: 'Registration Date', width: 150, height: 30, sortOrder: 'desc', formatter: formatDate},
                    {field: 'srep_code', title: '<?php getCaption("Kode Sales"); ?>', width: 100, height: 20},
                    {field: 'srep_name', title: '<?php getCaption("Nama Sales"); ?>', width: 250, height: 20},
                    {field: 'so_note', title: '<?php getCaption("Catatan"); ?>', width: 315, height: 20, editor: 'validatebox'},
                    {field: 'so_reg_by', title: 'Registered By', width: 100, height: 20}

                ]]
        });

        $("#dg").datagrid('reload');
    }

    function viewShowAction() {
        var viewShow = $("#viewShow").val();

        optionHide();

        switch (viewShow) {
            case 'all':
                optionHide();
                tableSPKReg(urls);
                break;

            case 'so_no':
                $('#TDkeyword').show();
                $("#TDbuttonKeyword").show();
                break;

            case 'so_regdate':
                $('#TDDate').show();
                $("#TDbuttonDate").show();
                $("#from").datebox('setValue', '<?php echo date('Y-m-d');?>');
                $("#to").datebox('setValue', '<?php echo date('Y-m-d');?>');
                $("#from").datebox('enable');
                $("#to").datebox('enable');
                break;

            case 'srep_code':
                $('#srep_name').combogrid('setValue', '');
                $('#srep_name').combogrid('enable');
                $('#TDsales').show();
                $("#TDbuttonSales").show();


                break;
        }
    }

    function optionHide() {
        $('#TDkeyword').hide();
        $('#TDDate').hide();
        $('#TDsales').hide();
        $("#TDbuttonKeyword").hide();
        $("#TDbuttonDate").hide();
        $("#TDbuttonSales").hide();

        $("#keyword").val('');

        $("#srep_code").val('');
        $("#srep_name").val('');


    }

    function keywordSearch() {
        var viewShow = $("#viewShow").val();
        var keyword = $("#keyword").val();

        var urls = site_url + '<?php echo 'builder/grid_spkreg/' . encrypt_decrypt('encrypt', 'veh_spkreg'); ?>/register/' + viewShow + '/' + keyword + '/?grid=true';

        tableSPKReg(urls);

    }
    function dateSearch() {
        var viewShow = $("#viewShow").val();
        var from = $("#from").datebox('getValue');
        var to = $("#to").datebox('getValue');

        if (Date.parse(from) / 1000 > Date.parse(to) / 1000) {
            alert('Beginning date has to be bigger or equal to end date');
            $('#dg').datagrid('loadData', {"total": 0, "rows": []});
        } else {
            var urls = site_url + '<?php echo 'builder/grid_spkreg/' . encrypt_decrypt('encrypt', 'veh_spkreg'); ?>/register/' + viewShow + '/' + from + '/' + to + '/?grid=true';
            tableSPKReg(urls);
        }

    }

    function salesSearch() {
        var viewShow = $("#viewShow").val();
        var sales = $("#srep_code").val();

        var urls = site_url + '<?php echo 'builder/grid_spkreg/' . encrypt_decrypt('encrypt', 'veh_spkreg'); ?>/register/' + viewShow + '/' + sales + '/?grid=true';

        tableSPKReg(urls);

    }



    $(document).ready(function () {
        $('#prefix').val('');
        $('#prefix1').val('');

        getPrefix();
        condEnable();
        optionHide();
        tableSPKReg(urls);

        $('.loader').hide();

        $('#srep_name').combogrid({
            onSelect: function (index, row) {

                $("#srep_code").val(row.srep_code);

            }
        });

        version('03.17-31');
    });

</script>
<div style="margin:10px;" id="form-content">
    <form id="<?= $form; ?>" name="<?= $name; ?>">
        <table class="main-form">
            <tr>
                <td colspan="2">
                    <b>SPK Number to Generate and Register : </b><hr />
                </td>
            </tr>
            <tr>
                <td width="265px">
                    <table cellpadding="3">
                        <?php
                        textboxset('spk_prefix', 'so_no', 'No. SPK', 40, 140, null, 11);
                        textboxset('spk_prefix2', 'sd_no', 's/d No.', 40, 140, null, 11);
                        ?>
                    </table>
                </td>
                <td>
                    <table cellpadding="2">
                        <td>
                            <a href="#" class="easyui-linkbutton"  onclick="rolesReg()" style="height:53px; width:60px; border-radius:4px;"><p style="margin-top:25%;">Register</p></a>
                        </td>
                    </table>
                </td>
            </tr>
        </table>
    </form>
    <div class="single-form">
        <div>

            <div style="float:left;width: 60%; ">

                <form id="form" action="post">
                    <table>
                        <tr>
                            <td><b>View</b></td>
                            <td>
                                <select  id="viewShow" name="viewShow" style="width:120px;height: 25px;" onchange="viewShowAction()">
                                    <option value="all">ALL</option>
                                    <option value="so_no">Registered SPK</option>
                                    <option value="so_regdate">Registration Date</option>
                                    <option value="srep_code">Distributed To</option>
                                </select>
                            </td>
                            <td id="TDkeyword">
                                <table>
                                    <tr>
                                        <td>Contain</td>
                                        <td>
                                            <input class="easyui-textbox" name="keyword" id="keyword" style="width:100px;height: 25px;">
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td id="TDDate">
                                <table>
                                    <tr>
                                        <td>
                                            <table>
                                                <tr>
                                                    <td>From</td>
                                                    <td><?php datebox2('from'); ?></td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td>
                                            <table>
                                                <tr>
                                                    <td>To</td>
                                                    <td><?php datebox2('to'); ?></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td id="TDsales">
                                <table>
                                    <?php cmdSalSet('srep_code', 'srep_name', 'Sales') ?>
                                </table>
                            </td>

                            <td id="TDbuttonKeyword">
                                <button class="easyui-linkbutton" data-options="iconCls:'icon-reload'"  onclick="keywordSearch()"> Refresh</button>
                            </td>

                            <td id="TDbuttonDate">
                                <button class="easyui-linkbutton" data-options="iconCls:'icon-reload'"  onclick="dateSearch()"> Refresh</button>
                            </td>

                            <td id="TDbuttonSales">
                                <button class="easyui-linkbutton" data-options="iconCls:'icon-reload'"  onclick="salesSearch()"> Refresh</button>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>

        <table id="dg" class="easyui-datagrid"  title="" style="width:1080px;height:310px;"></table>

    </div>
    <div class="main-nav">
        <table class="table" width="100%">
            <tr>
                <td align="right"><img src="<?php echo $loc_jui . "themes/icons/version.png" ?>" id="version"></td>
            </tr>
        </table>
    </div>
</div>

