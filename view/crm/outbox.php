<div style=" margin: 10px;" id="form_content">
    <div class="single-form">
        <div title="" style="padding:0px 10px;">	
            <table >

                <table id="outList" class="easyui-datagrid"  title="" style="width:1080px;height:300px;" toolbar="#tb" 
                       data-options="rownumbers:true,singleSelect:true,method:'post',
                       remoteSort:false,multiSort:true,fitColumns:true"  pagination="true">
                    <thead>
                        <tr>
                            <th data-options="field:'SendingDateTime',width:150,halign:'center'" sortable="true">Insert Date</th>
                            <th data-options="field:'DestinationNumber',width:130,halign:'left'">Phone Number</th>
                            <th data-options="field:'cust_name',width:160,align:'left'">Name</th>
                            <th data-options="field:'TextDecoded',width:300,align:'left'">Message</th>
                    </thead>
                </table>
        </div>

        <div id="tb">
            <div>
                <table>
                    <tr>
                        <td><b>Outbox Message</b></td>
                        <td><a href="#" id="cmdSearch" class="easyui-linkbutton" iconCls="icon-reload" onclick="doSearch()">Refresh</a></td>
                    </tr>
                </table>
            </div>
        </div>
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
    version('06.04-17');
    function doSearch() {
        //alert('yes');
        url = "services/runCRUD.php?lookup=crm/sms&func=GetOutBox";
        $('#outList').datagrid({
            url: url
        });
    }
</script>

