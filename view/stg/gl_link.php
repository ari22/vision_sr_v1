<?php
$division = array
    (
    array("Vehicle", "VEH"),
    array("Accessories", "ACC")
);
$dk = array
    (
    array("Debit", "D"),
    array("Kredit", "K")
);
$comp_code= $comp['comp_code'];
?>
<div style=" margin: 10px;" id="form_content">
    <form id="form_validation" method="post" >
        <div id="tableId"></div>
        <div id="results"></div>

        <div class="single-form teen-margin">
            <table>
                <tr>
                    <td valign="top">
                        <table>
                            <?php localcombobox('inv_div', 'Divisi', 120, $division); ?>
                            <tr><td><br /></td></tr>
                            <tr>
                                <td colspan="2"></td>
                                <td>
                                    <table>
                                        <tr><td width="60">Code</td><td>Name</td></tr>
                                    </table>
                                </td>
                            </tr>
                            <?php cmdTrx_code('trx_code', 'trx_desc', 'Transaksi', 60, 250); ?>
                            <?php cmdWrhsVehAcc('wrhs_code', 'Warehouse'); ?>

                        </table>
                    </td>
                    <td valign="top">
                        <table>

                        </table>
                    </td>
                </tr>
            </table>
        </div>
        <div class="single-form" style="padding: 10px;">
            <table id="dt" class="easyui-datagrid" style="width:1085px;height:250px;"></table>
        </div>
        <div class="main-nav">
            <table width="100%">
                <tr>
                    <td width="400"><?php navigation_ci(); ?></td>
                    <td width="400">
                        <table>
                            <tr>
                                <td  style="border-top:0px !important;">
                                    <button type="button" id="cmdDetail"  class="easyui-linkbutton"  onclick="cmdDetails()" disabled="true">Detail</button>
                                </td>
                            </tr>
                        </table>   
                    </td>
                    <td align="right"><img src="<?php echo $loc_jui . "themes/icons/version.png" ?>" id="version"></td>
                </tr>
            </table>
        </div>
    </form>
</div>

<div id="DetailWindow" class="easyui-window" title="Account" data-options="closable:true,minimizable:false,maximizable:false,collapsible:false,closed:true,modal:true,closed:true,inline:true" style="width:1090px;height:500px;padding:10px;top:1;">

    <div style="width: 820; margin: 20px;">
        <table id="dt2" class="easyui-datagrid"  title="" style="width:1010px;height:250px;"></table>
        <br />

        <form id="form_validation2" method="post" >
            <div id="tableId2"></div>

            <table>
                <tr>
                    <td>
                        <table>
                            <tr>
                                <td><b>D/K</b></td>
                                <td><b><?php getCaption("Tipe"); ?> </b></td>
                                <td><b>Account No.</b></td>
                                <td><b>Account Name</b></td>
                                <td><b><?php getCaption("Catatan"); ?> (Prefix)</b></td>
                                <td><b><?php getCaption("Catatan"); ?> (Infix)</b></td>    
                                <td><b><?php getCaption("Catatan"); ?> (Suffix)</b></td>
                            </tr>
                            <tr>
                                <td><table><?php localcombobox('dc', '', 80, $dk); ?></table></td>
                                <td><table><?php cmdTrx_scode('trx_scode', '', 120); ?></table></td>
                                <td><?php textbox2('acc_no', 150, 17); ?></td>
                                <td><?php textbox2('acc_name', 150, 17); ?></td>
                                <td><?php textbox2('prefix', 150, 17); ?></td>
                                <td><?php textbox2('infix', 150, 17); ?></td>
                                <td><?php textbox2('suffix', 150, 17); ?></td>
                            </tr>

                        </table>
                    </td>
                </tr>
                <tr>
                    <td>  
                        <table style="width:500px;" border="0">
                            <tr>
                                <td style="border-top:0px !important;">
                                    <button type="button" id="cmdFirst2" title="First" data-options="iconCls:'icon-first'" class="easyui-linkbutton" onclick="read_show2('F')" disabled="true"></button>
                                    <button type="button" id="cmdPrev2" title="Prev" data-options="iconCls:'icon-prev'" class="easyui-linkbutton" onclick="read_show2('P')" disabled="true"></button>
                                    <button type="button" id="cmdNext2" title="Next" data-options="iconCls:'icon-next'" class="easyui-linkbutton"  onclick="read_show2('N')" disabled="true"></button>
                                    <button type="button" id="cmdLast2" title="Last" data-options="iconCls:'icon-last'" class="easyui-linkbutton" onclick="read_show2('L')" disabled="true"></button>
                                </td>
                                <td  style="border-top:0px !important;">
                                    <button type="button" id="cmdSave2" title="Save" data-options="iconCls:'icon-save',group:'g2'" class="easyui-linkbutton" onclick="saveData2()" disabled="true" ></button>
                                    <button type="button" id="cmdCancel2" title="Batal" data-options="iconCls:'icon-undo',group:'g2'" class="easyui-linkbutton"   onclick="condCancel2()" disabled="true" ></button>
                                </td>
                                <td  style="border-top:0px !important;">
                                    <button type="button" id="cmdAdd2" title="<?php getCaption("Tambah"); ?>"  class="easyui-linkbutton" data-options="iconCls:'icon-add'"  onclick="condAdd2()" disabled="true"></button>
                                    <button type="button" id="cmdEdit2" title="<?php getCaption("Ubah"); ?>" class="easyui-linkbutton" data-options="iconCls:'icon-edit'"  onclick="condEdit2()" disabled="true"></button>
                                    <button type="button" id="cmdDelete2" title="<?php getCaption("Hapus"); ?>" class="easyui-linkbutton" data-options="iconCls:'icon-no'" onclick="deleteDetail()" disabled="true" > </button>
                                    <button type="button" id="ok2" class="easyui-linkbutton" data-options="iconCls:'icon-ok'" onclick="$('#DetailWindow').window('close');"></button>
                                </td>

                            </tr>
                        </table>  </td>       
                </tr>
            </table>
        </form>
    </div>
</div>
<?php include 'gl_link_fn.php'; ?>