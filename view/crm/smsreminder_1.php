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

<script>
    $('.loader').hide();
</script>

<table>
    <tr>
        <td style="vertical-align:top">
            <table cellpadding="5" >
                <?php
                localcombobox('jnsrmd', 'Jenis Reminder', 200, $jenis_reminder);
                datebox('msperiod', 'Periode');
                ?>
            </table>
            <div style="padding:10px 60px 0px 15px">
                <b>Kriteria tambahan</b>
            </div>

            <div style="padding:10px 60px 0px 53px;">

                <table >
                    <tr>
                        <td>
                            <table cellpadding="5">
                                <?php
                                localcombobox('msgmodel', 'model', 200, $jnsmdl);
                                ?>
                            </table>
                        </td>
                    </tr>
                </table>	
            </div>	

            <div style="padding:10px 60px 0px 15px">
                <b>Pesan SMS</b>
            </div>
            <div style="padding:10px 10px 0px 38px; margin:0 20px 0px 0;">

                <table>
                    <tr>
                        <td >
                            <table cellpadding="5">
                                <?php
                                textarea('msgarea', 'Pesan', 250);
                                ?>
                            </table>
                        </td>
                    </tr>
                </table>	

            </div>	
        </td>

        <td>
            <div>
                <table id="RecList" class="easyui-datagrid"  title="" style="width:350px;height:245;"
                       data-options="singleSelect:false,method:'get',remoteSort:false,multiSort:true,toolbar:'#tb'">
                    <thead>
                        <tr>
                            <th data-options="field:'ck',checkbox:true"> </th>
                            <th data-options="field:'hp',width:130,halign:'center'">No Hp</th>
                            <th data-options="field:'cust_name',width:195,halign:'center'">Nama</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div id="tb">
                <div>
                    <table>
                        <tr>
                            <td><b>Receipent List</b></td>
                            <td><a href="#" id="cmdSearch" class="easyui-linkbutton" iconCls="icon-reload" onclick="doSearch()">get data</a></td>
                        </tr>
                    </table>
                </div>
            </div>	

        </td>
    </tr>

    <tr>
        <td> 
            <!--EMPTY-->
        </td>


        <td align="right"> 
            <a href="#" id="cmdSearch" class="easyui-linkbutton" onclick="getSelections()">Send</a>
        </td>
    </tr>


</table>



<script>



    $(document).ready(function () {
        $('#jnsrmd').combobox('enable');
        $('#dtFrom').datetimebox('enable');
        $('#msperiod').datetimebox('enable');
        $('#msgmodel').combobox('enable');
        $('#msgarea').attr('disabled', false);
        $('#msgarea').attr('readonly', true);

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