<?php
$form = 'spkdistribute';

$table = "veh_spkreg";
$lookup = 'trx/' . $table;
echo '<form id="' . $form . '" >';
?>

<div style="margin: 10px;" id="form_content">

    <div class="single-form">
        <div style="float:left;width: 60%;margin-bottom: 15px; ">

            <form id="form" action="post">
                <table>
                    <tr>
                        <td><b>View</b></td>
                        <td>
                            <select  id="viewShow" name="viewShow" style="width:120px;height: 25px;" onchange="viewShowAction()">
                                <option value="all">ALL</option>
                                <option value="so_no">Registered SPK</option>
                                <option value="so_regdate">Registration Date</option>
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


                        <td id="TDbuttonKeyword">
                            <button class="easyui-linkbutton" data-options="iconCls:'icon-reload'"  onclick="keywordSearch()"> Refresh</button>
                        </td>

                        <td id="TDbuttonDate">
                            <button class="easyui-linkbutton" data-options="iconCls:'icon-reload'"  onclick="dateSearch()"> Refresh</button>
                        </td>


                    </tr>
                </table>
            </form>
        </div>

        <table id="dg" class="easyui-datagrid"  title="" style="width:1080px;height:350px;"></table>
    </div>
    <div class="main-nav">
        <table width="100%">
            <tr>
                <td width="300">
                    <table>
                        <?php
                        cmdSales('srep_code', 'Nama Sales', 200);
                        ?>
                    </table>
                </td>
                <td width="100">
                    <table>
                        <td >
                            <a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-add'"  onclick="rolesDistSPK()">Distribute</a>
                            <!--<a href="#" class="easyui-linkbutton"  onclick="doSearch()">Quit</a>-->
                        </td>
                    </table>
                </td>
                <td align="right"><img src="<?php echo $loc_jui . "themes/icons/version.png" ?>" id="version"></td>
            </tr>
        </table>
    </div>

</div>

<script type="text/javascript">

    //var urls = 'services/runCRUD.php?lookup=trx/spk_distribute&func=read&where1=1&where3=3';
    var urls = site_url + '<?php echo 'builder/grid_spkreg/' . encrypt_decrypt('encrypt', 'veh_spkreg'); ?>/distribute/?grid=true';

    function rolesDistSPK() {
        var num = checkRoles('ds');
        if (num == '1') {
            getSelections();
            return false;
        }

        errorAccess();
    }


    function tableSPKReg(urls) {
        var toolbar = [{
                text: 'Refresh',
                iconCls: 'icon-reload',
                handler: function () {
                    $('#dg').datagrid('reload');

                }
            }];
        $("#dg").datagrid({
            method: 'post',
            url: urls,
            rownumbers: true,
            singleSelect: false,
            toolbar: toolbar,
            remoteSort: true,
            multiSort: true,
            pagination: true,
            columns: [[
                    {field: 'ck', checkbox: true},
                    {field: 'so_no', title: '<?php getCaption("No. SPK"); ?>', width: 130, height: 20},
                    {field: 'so_regdate', title: 'Registration Date', width: 120, height: 30, sortOrder: 'desc', formatter: formatDate},
                    {field: 'srep_code', title: '<?php getCaption("Kode Sales"); ?>', width: 100, height: 20},
                    {field: 'srep_name', title: '<?php getCaption("Nama Sales"); ?>', width: 200, height: 20},
                    {field: 'so_note', title: '<?php getCaption("Catatan"); ?>', width: 285, height: 20},
                    {field: 'so_reg_by', title: 'Registered By', width: 100, height: 20},
                    {field: 'use_date', title: 'Use Date', width: 100, height: 20, formatter: formatDate}
                ]]
        });

        $("#dg").datagrid('reload');
    }

    function optionHide() {
        $('#TDkeyword').hide();
        $('#TDDate').hide();

        $("#TDbuttonKeyword").hide();
        $("#TDbuttonDate").hide();


        $("#keyword").val('');

        $("#srep_code").val('');
        $("#srep_name").val('');


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

        }
    }
    function keywordSearch() {
        var viewShow = $("#viewShow").val();
        var keyword = $("#keyword").val();

        var urls = site_url + '<?php echo 'builder/grid_spkreg/' . encrypt_decrypt('encrypt', 'veh_spkreg'); ?>/distribute/' + viewShow + '/' + keyword + '/?grid=true';

        tableSPKReg(urls);

    }
    function dateSearch() {
        var viewShow = $("#viewShow").val();
        var from = $("#from").datebox('getValue');
        var to = $("#to").datebox('getValue');

        if (Date.parse(from) / 1000 > Date.parse(to) / 1000) {
            alert('Beginning date has to be bigger or equal to end date ');
            $('#dg').datagrid('loadData', {"total": 0, "rows": []});
        } else {
            var urls = site_url + '<?php echo 'builder/grid_spkreg/' . encrypt_decrypt('encrypt', 'veh_spkreg'); ?>/distribute/' + viewShow + '/' + from + '/' + to + '/?grid=true';
            tableSPKReg(urls);
        }

    }

    function getSelections() {
        var ss = [];
        var rows = $('#dg').datagrid('getSelections');
        var data = "";
        for (var i = 0; i < rows.length; i++) {
            var row = rows[i];
            ss.push('<span>' + row.so_no + '</span>');
            if (data.length >> 0) {
                data = data + ",";
            }
            data = data + row.so_no;
        }
        data = data + '&' + $("#<?php echo $form; ?>").serialize();
        //$.messager.alert('Info', ss.join('<br/>'));

        url = "services/runCRUD.php";
        link = "lookup=trx/spk_distribute&func=dist&list_so_no=" + data;
        $.post(url, link)
                .done(function (data) {
                    obj = JSON.parse(data);
                    if (obj.success == true) {
                        showAlert("Information", obj.message);
                        $('#dg').datagrid('reload');
                        $('#srep_code').combogrid('setValue', '');
                    } else
                    {
                        showAlert("Error while saving", obj.message);
                        $('#dg').datagrid('reload');
                    }
                })
                .fail(function () {
                    showAlert("Error", "Error while saving");
                    $('#dg').datagrid('reload');
                })
        /*.always(function() {
         alert( "complete" );
         });*/
    }
    $(document).ready(function () {
        $('.loader').hide();
        tableSPKReg(urls);
        optionHide()
        $('#srep_code').combogrid('enable');
        version('03.17-31');
    });
</script>