<div style=" margin: 10px;" id="form_content">
    <div class="single-form">
        <h3>Log file of Online Users currently using the program</h3>
        <table id="tbl_dtl" class="easyui-datagrid"  title="" style="width:675px;height:310px;"></table>
    </div>
    <div class="main-nav">
        <table width="100%">
            <tr>
                <td width="400">
                    <button type="button" id="cmdAll" title="all"  data-options="iconCls:'icon-all-user',group:'g2'" class="easyui-linkbutton cmdSave" onclick="allUser()" >All Users</button>
                    <button type="button" id="cmdOnline" title="online"  data-options="iconCls:'icon-online-user',group:'g2'" class="easyui-linkbutton cmdSave" onclick="OnlineUser()" >Online User</button>
                </td>
                <td align="right"><img src="<?php echo $loc_jui . "themes/icons/version.png" ?>" id="version"></td> 
            </tr>
        </table>
    </div>
</div>

<script>
    $(".loader").hide();
    version('05.04-17');

    url = site_url + '<?php echo 'builder/datagrid/' . encrypt_decrypt('encrypt', 'usr'); ?>/id/<?php echo $_SESSION['C_ID']; ?>/?grid=true';
    table_grid(url);

    function allUser() {
        url = site_url + '<?php echo 'builder/datagrid/' . encrypt_decrypt('encrypt', 'usr'); ?>?grid=true';
        table_grid(url);
    }
    function OnlineUser() {
        url = site_url + '<?php echo 'builder/datagrid/' . encrypt_decrypt('encrypt', 'usr'); ?>/1/?grid=true';
        table_grid(url);
    }
    function table_grid(url) {

        $("#tbl_dtl").datagrid({
            method: 'post',
            url: url,
            title: '',
            idField: 'id',
            fitColumns: false,
            singleSelect: true,
            nowrap: true,
            fit: false,
            rownumbers: true,
            pageSize: 10,
            showFooter: false,
            pagination: true,
            columns: [[
                    {field: 'username', title: '<?php getCaption("Username"); ?>', width: 120, height: 20, sortable: true},
                    {field: 'lin_dtime', title: 'Last Login', width: 150, height: 20, sortable: true, formatter: formatDateTime},
                    {field: 'lout_dtime', title: 'Last Logout', width: 150, height: 20, sortable: true, formatter: formatDateTime},
                    {field: 'curr_login', title: 'Online Now', width: 120, height: 20, sortable: true, align: 'center'},
                    {field: 'wrhs_axs', title: 'Warehouse', width: 100, height: 20, sortable: true},
                     //{field: 'wrhs_axs', title: 'Memo', width: 100, height: 20, sortable: true}
                ]]
        });
    }
</script>

