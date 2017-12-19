<?php
$form = 'sms_sentitem';
echo '<div style="padding: 0px 10px 20px 20px;">';
echo '<form id="' . $form . '" >';
echo '<table cellpadding="5">';
$optSendStatus = array(
    array('All', ''),
    array('SendingOK', 'SendingOK'),
    array('SendingError', 'SendingError')
        )
?>

<div title="<?php getCaption('Pekerjaan Jasa'); ?>" style="padding:0px 10px;">	
    <table>
        <table id="smssentitem" class="easyui-datagrid"  title="" style="width:720px;height:300px;" toolbar="#tb"
               data-options=" rownumbers:true,singleSelect:true,method:'post', remoteSort:false,fitColumns:true">
            <thead>
                <tr>
                    <th data-options="field:'SendingDateTime',width:150,halign:'center',sortable:true">Sent Date</th>
                    <th data-options="field:'DestinationNumber',width:120,halign:'center',sortable:true">Phone Number</th>
                    <th data-options="field:'Status',width:120,align:'center',sortable:true">Status</th>
                    <th data-options="field:'TextDecoded',width:150,align:'center',align:'left',sortable:true">Message</th>
            </thead>


        </table>
    </table>
</div>
<div id="tb">
    <table>
        <tr>
            <td><b>Sent Messages</b></td>
        </tr>
    </table>
</div>

<div>
    <td>
        <p><b>Filter</b></p>
        <table cellpadding="3" style="margin:0px 0px 0px 50x; padding: -10px -50px -30px -100px;">

            <?php
            datetimebox('dtFrom', 'Tgl. Kirim');
            datetimebox('dtTo', 's/d');
            textbox('DestinationNumber', 'Telepon', 110, 20);
            localcombobox('Status', 'Status', 120, $optSendStatus);
            textbox('pesan', 'Pesan', 300, 100);
            ?>
        </table>

    </td>
</div>
<div style="margin:5px 0px 0px 114px;">
    <a href="#" id="cmdSearch" class="easyui-linkbutton" iconCls="icon-search" onclick="doSearch()">Get Data</a>

</div>


<script>
    $('.loader').hide();

    $(document).ready(function () {
        $('#dtFrom').datetimebox('enable');
        $('#dtTo').datetimebox('enable');
        $('#DestinationNumber').attr('disabled', false);
        $('#Status').combobox('enable');
        $('#pesan').attr('disabled', false);
    });
    function doSearch() {
        //alert();

        url = "services/runCRUD.php?lookup=crm/sms&func=GetSentItem";
        url = url + "&dtFrom=" + $("#dtFrom").datetimebox('getValue');
        url = url + "&dtTo=" + $("#dtTo").datetimebox('getValue');
        url = url + "&DestinationNumber=" + $("#DestinationNumber").val();
        url = url + "&pesan=" + $("#pesan").val();
        url = url + "&Status=" + $("#Status").combobox('getValue');
        //url = "services/runCRUD.php?lookup=crm/sms&func=GetSentItem";
        $('#smssentitem').datagrid({
            url: url,
        });

    }
    ;
</script>