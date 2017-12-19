<?php
$mounth = array
    (
    array("January", "1"),
    array("February", "2"),
    array("March", "3"),
    array("April", "4"),
    array("May", "5"),
    array("June", "6"),
    array("July", "7"),
    array("August", "8"),
    array("September", "9"),
    array("October", "10"),
    array("November", "11"),
    array("December", "12"),
);
?>

<div style=" margin: 10px;" id="form_content">
    <div class="single-form">
        <form id="form_validation" method="post" >
            <div id="tableId"></div>
            <table>
                <tr>
                    <td><?php getCaption('Jenis Transaksi'); ?></td>
                    <td class='td-ro'>:</td>
                    <td>
                        <input type='hidden' name='inv_type' id='inv_type'>
                        <input class="easyui-combogrid" id="remark" name="remark" disabled="true" style="width:305px;"></input>
                    </td>
                </tr>
                <?php // cmdInvSeq('inv_type', 'Jenis Transaksi', 305); ?> 
                <tr><td><br /></td></tr>
                <tr>
                    <td colspan="2"></td>
                    <td>
                        <table class="marginmin">
                            <tr>
                                <td width='100'><?php getCaption('bulan1'); ?></td>
                                <td width='50'><?php getCaption('Tahun'); ?></td>
                                <td>No.</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td><?php getCaption('periode'); ?></td>
                    <td class='td-ro'>:</td>
                    <td>
                        <table class="marginmin">
                            <tr>
                                <td><?php localcombobox('inv_mth', '', 100, $mounth); ?></td>
                                <td><?php textbox2('inv_year', 50, 4); ?></td>
                                <td><?php textbox2('inv_no', 115, 100); ?></td>
                                <td><a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-reload'"   onclick="refreshInvno();" ></a></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr><td class='col110'></td></tr>
            </table>
        </form>
    </div>
    <div class="main-nav">
        <table width="100%">
            <tr>
                <td  style="border-top:0px !important;">
                    <button type="button" id="cmdReset" title="Save"  data-options="iconCls:'icon-save',group:'g2'" class="easyui-linkbutton cmdSave" onclick="saveData()" > Reset</button>
                </td>
                <td align="right"><img src="<?php echo $loc_jui . "themes/icons/version.png" ?>" id="version"></td> 
            </tr>
        </table>
    </div>
</div>
<style>
    #inv_year{text-align:right;}
</style>
<?php include 'setinvoice_fn.php';