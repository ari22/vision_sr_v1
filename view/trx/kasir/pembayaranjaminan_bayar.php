<div id="detailBayar" class="easyui-window" title="<?php getCaption("Pembayaran Uang Jaminan"); ?>" 
     data-options="modal:true,closed:true,resizable:false,maximizable:true,minimizable:false,collapsible:false" 
     style="width:1100px;height:500px;padding:10px;top:1;">
    <form id="formBayar" method="post">
        <div id="tableId2"></div>
        <table id= "inputBayar" class="easyui-datagrid" title="" style="height:250px"></table>
        <br>
        <table>
            <tr>
                <td width="200px"><?php getCaption("Dibayar oleh"); ?></td>
                <td width="310px"><?php getCaption("Alamat"); ?></td>
                <td width="150px"><?php getCaption("Wilayah"); ?></td>
                <td width="150px"><?php getCaption("Kota"); ?></td>
                <td width="100px"><?php getCaption("Kode Pos"); ?></td>
            </tr>
            <tr>
                <td><?php textbox2('payer_name', 210, 200); ?></td>
                <td><?php textbox2('payer_addr', 395, 200); ?></td>
                <td><?php textbox2('payer_area', 150, 200); ?></td>
                <td><?php textbox2('payer_city', 150, 200); ?></td>
                <td><?php textbox2('payer_zipc', 100, 200); ?></td>
            </tr>
        </table>
        <table>
            <tr>
                <td width="80px"><?php getCaption("Tgl. Bayar"); ?></td>
                <td width="70px"><?php getCaption("Jenis Pembayaran"); ?></td>
                <td width="70px"><?php getCaption("Bank"); ?></td>
                <td>EDC</td>
                <td width="100px"><?php getCaption("No. Check"); ?></td>
                <td width="80px"><?php getCaption("Tanggal Check"); ?></td>
                <td width="80px"><?php getCaption("Tgl J. Tempo"); ?></td>
                <td width="105px"><?php getCaption("Uang Jaminan"); ?></td>
                <td width="105px"><?php getCaption("Bayar Piutang"); ?></td>
                <td width="200px"><?php getCaption("Keterangan"); ?></td>
            </tr>
            <tr>
                <td><?php datebox2('pay_date'); ?></td>
                <td>
                    <table><?php cmdPayType('pay_type', '', $site_url, 100); ?></table>
                    <script>
                        $('#pay_type').combogrid({
                            onSelect: function (index, row) {
                                //$("#bank_code").combogrid('setValue', '');
                                if (row.pay_type == 'CASH') {
                                    $("#check_no").val(row.pay_type);
                                }
                            }
                        });</script>
                </td>
                <td><table><?php cmdBank('bank_code', '', $site_url, 100); ?></table></td>
                <td><table><?php cmdEDC('edc_code', '',80); ?></table></td>
                <td><?php textbox2('check_no', 90, 200); ?></td>
                <td><?php datebox2('check_date'); ?></td>
                <td><?php datebox2('due_date'); ?></td>
                <td><?php numberbox2('pay_val', 100, 250) ?></td>
                <td><?php numberbox2('used_val', 100, 250) ?></td>
                <td><?php textbox2('pay_desc', 165, 200); ?></td>

            </tr>
        </table>
        <br>

        <table>
            <tr>
                <td style="border-top:0px !important;">
                    <button type="button" id="cmdFirst2" title="First" data-options="iconCls:'icon-first'" class="easyui-linkbutton" onclick="read_show2('F')" disabled="true"></button>
                    <button type="button" id="cmdPrev2" title="Prev" data-options="iconCls:'icon-prev'" class="easyui-linkbutton" onclick="read_show2('P')" disabled="true"></button>
                    <button type="button" id="cmdNext2" title="Next" data-options="iconCls:'icon-next'" class="easyui-linkbutton"  onclick="read_show2('N')" disabled="true"></button>
                    <button type="button" id="cmdLast2" title="Last" data-options="iconCls:'icon-last'" class="easyui-linkbutton" onclick="read_show2('L')" disabled="true"></button>
                </td>
                <td width="30"></td>
                <td  style="border-top:0px !important;">
                    <button type="button" id="cmdSave2" title="Save" data-options="iconCls:'icon-save',group:'g2'" class="easyui-linkbutton"   onclick="saveBayar()" disabled="true" ></button>
                    <button type="button" id="cmdCancel2" title="Batal" data-options="iconCls:'icon-undo',group:'g2'" class="easyui-linkbutton "  onclick="read_show2('')" disabled="true" ></button>
                    <button type="button" id="cmdAdd2" title="<?php getCaption("Tambah"); ?>"  class="easyui-linkbutton" data-options="iconCls:'icon-add'"  onclick="editBayar(1)" disabled="true"></button>
    <!--<button type="button" id="cmdEdit2" title="<?php getCaption("Ubah"); ?>" class="easyui-linkbutton easyui-tooltip glyphicon glyphicon-pencil btn btn-default" data-options="iconCls:'icon-edit'"  onclick="condEdit2()" disabled="true"></button>-->
                    <button type="button" id="cmdDelete2" title="<?php getCaption("Hapus"); ?>" class="cmdDelete2 easyui-linkbutton " data-options="iconCls:'icon-no'" onclick="rolesDel2()" disabled="true" > </button>
                </td>
                <td width="30"></td>
                <td style="border-top:0px !important;">
                    <button id="cmdBayarBBN" title="Bayar BBN" class="cmdBayarBBN easyui-linkbutton" onclick="condBayarBBN()" data-options="iconCls:'icon-payment'">Bayar BBN</button>
                    <button id="cmdPrint1" title="Print" class="easyui-linkbutton" data-options="iconCls:'icon-print'" onclick="rolesPrintBuy()" >Print</button>
                    <button type="button" class="easyui-linkbutton" data-options="iconCls:'icon-redo'" onclick=" $('#detailBayar').window('close');">Exit</button>
                </td>

            </tr>

        </table>
    </form>
</div>

<div id="PrintWindow" title="Print vehicle temporary receipt" class="easyui-window" data-options="closable:true,minimizable:false,maximizable:true,collapsible:false,closed:true,modal:true,closed:true,inline:true" style="width:430px;height:250px;padding:10px;top:100;">
    <form id='form_print'>
        <table cellpadding="3" class="table" style="margin-top: 0px;" >
            <input type="hidden" id="codeOption" name="codeOption">
            <tr>   
                <td style="width: 15%"></td>
                <td>                             
                    <table>
                        <?php
                        textbox('tts_no', 'No. TTS', 150, 30);
                        textbox('tts_date', 'Tgl. TTS', 80, 30);
                        textbox('signature', 'Signature', 150, 30);
                        textbox('jabatan', 'Jabatan', 150, 30);
                        ?>
                    </table>
                </td>
                <td style="width: 15%"></td>
            </tr>
            <tr><td colspan="3"></td></tr>
            <tr>
                <td></td>
                <td>
                    <button class="easyui-linkbutton" data-options="iconCls:'icon-screen'" onclick="rolesPrintScreen('screen');">Screen</button>
                    <button class="easyui-linkbutton" data-options="iconCls:'icon-print'" onclick="rolesPrintScreen('download');">Print</button>
                    <button class="easyui-linkbutton" data-options="iconCls:'icon-no'" onclick="$('#PrintWindow').window('close')">Exit</button>
                </td>
                <td></td>
            </tr>
        </table>
    </form>
</div>

<div id="sr" class="easyui-window" title="screen" data-options="closable:true,minimizable:false,maximizable:false,collapsible:false,closed:true,modal:true,closed:true,inline:true" style="width:1050px;height:500px;padding:10px;top:1;"></div>
<script>
    function rolesPrintBuy() {
        var num = checkRoles('pr');
        if (num == '1') {
            printBayar();
            return false;
        }

        errorAccess();
    }
</script>