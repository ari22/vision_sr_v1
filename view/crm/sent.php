<?php
$form = 'sms_sentitem';

$optSendStatus = array(
    array('All', ''),
    array('SendingOK', 'SendingOK'),
    array('SendingError', 'SendingError')
        )
?>
<div style=" margin: 10px;" id="form_content">
    <div class="single-form">
        <form id="<?php echo $form; ?>">
            <table>
                <tr>
                    <td valign="top" width="380">
                        <table>
                            <tr><td colspan="3"><h3><u>Filter</u></h3></td></tr>
                            <?php
                            datetimebox('dtFrom', 'Tgl. Kirim');
                            datetimebox('dtTo', 's/d');
                            textbox('DestinationNumber', 'Telepon', 110, 20);
                            localcombobox('Status', 'Status', 120, $optSendStatus);
                            textbox('pesan', 'Pesan', 280, 100);
                            ?>
                            <tr>
                                <td colspan="3" align="right"><a href="#" id="cmdGetData" class="easyui-linkbutton" data-options="iconCls:'icon-ok',group:'g2'" onclick="doSearch()">Get Data</a></td>
                            </tr>
                        </table>
                    </td>
                    <td valign="top">
                        <table id="smssentitem" class="easyui-datagrid"  title="" style="width:710px;height:300px;" toolbar="#tb"
                               data-options=" rownumbers:true,singleSelect:true,method:'post', remoteSort:false,fitColumns:true">
                            <thead>
                                <tr>
                                    <th data-options="field:'SendingDateTime',width:150,halign:'center',sortable:true">Sent Date</th>
                                    <th data-options="field:'DestinationNumber',width:120,halign:'center',sortable:true">Phone Number</th>
                                    <th data-options="field:'Status',width:120,align:'center',sortable:true">Status</th>
                                    <th data-options="field:'TextDecoded',width:150,align:'center',align:'left',sortable:true">Message</th>
                            </thead>


                        </table>
                    </td>
                </tr>
            </table>
        </form>
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
    $(document).ready(function () {
        $('#dtFrom').datetimebox('enable');
        $('#dtTo').datetimebox('enable');
        $('#DestinationNumber').attr('disabled', false);
        $('#Status').combobox('enable');
        $('#pesan').attr('disabled', false);
        $('.loader').hide();
        version('06.04-17');
    })
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
        })

    }
</script>