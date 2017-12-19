<?php
$mounth = array
    (
    array("January", "01"),
    array("February", "02"),
    array("March", "03"),
    array("April", "04"),
    array("May", "05"),
    array("June", "06"),
    array("July", "07"),
    array("August", "08"),
    array("September", "09"),
    array("October", "10"),
    array("November", "11"),
    array("December", "12"),
);
$optGroupBy = array
    (
    array("All Data", "1"),
    array("Not Close", "2"),
    array("Closed", "3"),
    array("Selected Masters", "4")
);
$masters = array
    (
    array("Vehicle", "1"),
    array("Accessories", "2"),
);
?>


<div style=" margin: 10px;" id="form_content">
    <div class="single-form">      
        <table>
            <?php localcombobox('group_by', 'Tipe Data', 200, $optGroupBy); ?>
           
            <?php //localcombobox('master', 'Data', 100, $masters); ?>
            <tr><td width="70"></td></tr>
        </table>

    </div>
    <div class="main-nav">
        <table width="100%">
            <tr>
                <td width="400">
                    <a href="#" id="cmdBackup"  class="easyui-linkbutton easyui-tooltip" data-options="group:'g2',disabled:true,iconCls:'icon-save'" onclick="Backupdb()" >Backup</a>
                </td>
                <td align="right"><img src="<?php echo $loc_jui . "themes/icons/version.png" ?>" id="version"></td> 
            </tr>
        </table>
    </div>
</div>
<script>
    var url = site_url + 'utility/backup_db';

    function Backupdb() {
        $(".loader").show();
        $.post(url, function (res) {$(".loader").hide(1000);});
    }
    function setEnable()
    {
        $('.loader').hide();
        //$("#group_by").combobox('enable');
        $('#cmdBackup').linkbutton('enable');
    }
    $(document).ready(function () {
        setEnable();
        $(".loader").hide(1000);
        version('04.17-25');
    });
</script>