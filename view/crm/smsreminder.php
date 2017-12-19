<?php
$jenis_reminder = array
    (
    array("- Select one - ", "0"),
    array("Birthday - Ulang Tahun", "1"),
    array("Weeding Aniv - Ultah Pernikahan", "2"),
    array("Service 1000KM", "3"),
);

$jnsmdl = array
    (
    array("A", "1"),
    array("B", "2"),
    array("C", "3"),
);
?>
<div style=" margin: 10px;" id="form_content">
    <div class="single-form">
        <table>
            <tr>
                <td valign="top" width="400">
                    <table>
                        <?php
                        localcombobox('jnsrmd', 'Jenis Reminder', 250, $jenis_reminder);
                        datebox('msperiod', 'Periode');
                        ?>
                        <tr><td class="col90"></td></tr>
                        <tr><td class="col90"></td></tr>
                    </table>
                   
                    <table>
                        <tr><td colspan="3"> <h3><u>Kriteria tambahan</u></h3></td></tr>
                        <?php localcombobox('msgmodel', 'model', 250, $jnsmdl); ?>
                        <tr><td class="col90"></td></tr>
                        <tr><td class="col90"></td></tr>
                    </table>
                    <table>
                        <tr><td colspan="3"> <h3><u>Pesan SMS</u></h3></td></tr>
                        <?php textarea('msgarea', 'Pesan', 250); ?>
                        <tr><td class="col90"></td></tr>
                        <tr><td class="col90"></td></tr>
                        <tr>
                            <td colspan="2"></td>
                            <td align="right">
                                <button type="button" id="cmdSave" title="Send"  data-options="iconCls:'icon-ok',group:'g2'" class="easyui-linkbutton cmdSave" onclick="getSelections();" >Send</button>
                            </td>
                        </tr>
                    </table>

                </td>
                <td valign="top">
                    <div>
                        <table id="RecList" class="easyui-datagrid"  title="" style="width:670px;height:230;"
                               data-options="singleSelect:false,method:'get',remoteSort:false,multiSort:true,toolbar:'#tb'">
                            <thead>
                                <tr>
                                    <th data-options="field:'ck',checkbox:true"> </th>
                                    <th data-options="field:'hp',width:130,halign:'center'">No Hp</th>
                                    <th data-options="field:'cust_name',width:500,halign:'center'">Nama</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div id="tb">
                        <div>
                            <table>
                                <tr>
                                    <td><b>Receipent List</b></td>
                                    <td><a href="#" id="cmdSearch" class="easyui-linkbutton" data-options="iconCls:'icon-ok',group:'g2'" iconCls="icon-reload" onclick="doSearch()">get data</a></td>
                                </tr>
                            </table>
                        </div>
                    </div>	
                </td>
            </tr>
        </table>
    </div>
    <div class="main-nav">
        <table width="100%">
            <tr>
                <td align="right"><img src="<?php echo $loc_jui . "themes/icons/version.png" ?>" id="version"></td> 
            </tr>
        </table>
    </div>
</div>
<script>
    $('.loader').hide();
</script>
<script>
    $(document).ready(function () {
        $('#jnsrmd').combobox('enable');
        $('#dtFrom').datetimebox('enable');
        $('#msperiod').datetimebox('enable');
        $('#msgmodel').combobox('enable');
        $('#msgarea').attr('disabled', false);
        $('#msgarea').attr('readonly', true);
         version('06.04-17');
    });

    var month = 0;
    var day = 0;

    $('#msperiod').datebox({
        onSelect: function (d) {
            month = d.getMonth() + 1;
            day = d.getDate();


        }
    });


    function doSearch() {
        //alert('yes');
        url = "services/runCRUD.php?lookup=crm/sms&func=GetData&reminder=sr_birthday&month=" + month + "&day=" + day + "";
        $('#RecList').datagrid({
            url: url
        });
    }

    $('#jnsrmd').combobox({
        onSelect: function (record)
        {
            if (record.value == "0") {
                var text = "";
                $('#msgarea').val(text);
            }
            if (record.value == "1") {
                var text = "Seluruh Staff Honda  Mengucapkan Happy Birthday, Semoga kesuksesan selalu menyertai anda.";
                $('#msgarea').val(text);

            }
            else if (record.value == "2") {
                var text = "Segenap Staff Honda Mengucapkan HAPPY ANNIVERSARY. Semoga Hubungan Kalian Bahagia selalu.";
                $('#msgarea').val(text);
            }
            else if (record.value == "3") {
                var text = "Pelanggan Yth. Silahkan melakukan service 1000KM Terima Kasih";
                $('#msgarea').val(text);
            }
        }

    });

    function getSelections() {
        var s = [];
        var rows = $('#RecList').datagrid('getSelections');
        for (var i = 0; i < rows.length; i++) {
            var row = rows[i];
            s.push(row.hp);
        }
        var num = s.join(';');
        //url = "services/runCRUD.php?lookup=crm/sms&func=create&pesan="+$('#msgarea').val()+"&recipient="+num+"";
        url = "services/runCRUD.php";
        data = "lookup=crm/sms&func=create&pesan=" + $('#msgarea').val() + "&recipient=" + num + "";
        $.post(url, data)
                .done(function (data) {
                    obj = JSON.parse(data);
                    if (obj.success == true) {
                        showAlert("Message Sent", obj.message);

                    } else
                    {
                        $.messager.alert("Sending failed : Data cannot empty", s.join('<br/>'));
                    }
                })
                .fail(function () {
                    showAlert("Error", "Error while saving");
                })

        //$.messager.alert('Info', num);
    }

</script>