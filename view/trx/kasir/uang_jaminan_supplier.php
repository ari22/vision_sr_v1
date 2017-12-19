<?php $session = $_SESSION;?>
<div style="margin: 10px;" id="form_content">
    <form id="form_validation" method="post" >
        <div id="tableId"></div>
        <div class="single-form teen-margin">
            <table>
                <tr>
                    <td width="480" valign="top">
                        <table>
                            <?php cmdponew('po_no', 'No. PO', $site_url, null, 'cls'); ?>
                            <?php datebox('po_date', 'Tgl. PO', 200); ?>
                            <tr><td><br /></td></tr>
                            <?php datebox('opn_date', 'Tgl. Buat', 200); ?>
                            <?php numberbox('veh_price', 'Harga Kendaraan', 80, 30); ?>

                            <tr><td class="col80"></td></tr>
                        </table>
                    </td>

                    <td valign="top">
                        <table>
                            <?php textboxset('supp_code', 'supp_name', 'Supplier', 100, 273); ?>
                            <tr><td><br /></td></tr>
                            <tr>
                                <td><?php getCaption("Chassis"); ?></td>
                                <td class="td-ro">:</td>
                                <td>
                                    <table class="marginmin">
                                        <tr>
                                            <td><?php textbox2('chassis', 150, 17); ?></td>
                                            <td width="60"><?php getCaption("Engine"); ?></td>
                                            <td class="td-ro">:</td>
                                            <td align="right"><?php textbox2('engine', 150, 15); ?></td>
                                        </tr>
                                    </table>
                                </td>

                            </tr>
                            <?php textbox('veh_name', 'Nama Kendaraan', 376, 300); ?>
                            <?php textboxset('color_code', 'color_name', 'Warna', 100, 273); ?>
                            <?php cmdWrhs('wrhs_code', 'Warehouse'); ?>
                            <?php textbox('note', 'Keterangan', 376, 375); ?>
                            <tr><td class="col80"></td></tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
        <div class="single-form" style="padding: 10px;">
            <table id="dt_ard" class="easyui-datagrid"  title="" style="width:1080px;height:200px;"></table>

            <table width="100%">
                <td align="right">
                    <table >
                        <?php
                        numberbox('dp_begin', 'Uang Jaminan (Posted)', 90, 30);
                        numberbox('dp_paid', 'Uang Jaminan (Current)', 250, 30);
                        numberbox('dp_used', 'Bayar Hutang', 150, 30);
                        numberbox('dp_end', 'Saldo Akhir', 150, 30);
                        ?>
                    </table>
                </td>
            </table>
        </div>

        <div class="main-nav">
            <table width="100%">
                <tr>
                    <td width="400"><?php navigation_ci(); ?></td>
                    <td width="100">
                        <table border="0">
                            <tr>
                                <td  style="border-top:0px !important;">
                                    <button type="button" id="bayar" title="<?php getCaption("Bayar"); ?>" class="bayar easyui-linkbutton"  onclick="bayarHutang();" data-options="iconCls:'icon-payment'">Bayar</button>
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

<div id="BayarWindow" class="easyui-window" title="<?php getCaption("Pembayaran Uang Jaminan"); ?> Supplier"  data-options="modal:true,closed:true,resizable:false,maximizable:true,minimizable:false,collapsible:false" 
     style="width:1090px;height:450px;padding:10px;top:1;">
    <table id="dt_ard2" class="easyui-datagrid"  title="" style="width:1050px;height:200px;"></table><br />

            <form id="formBayar" method="post">
            <div id="tableId2"></div>

            <table>
                <tr>
                    <td width="80px"><?php getCaption("Tgl. Bayar"); ?></td>
                    <td width="70px"><?php getCaption("Jenis Pembayaran"); ?></td>
                    <td width="70px"><?php getCaption("Bank"); ?></td>
                    <td width="100px"><?php getCaption("No. Check"); ?></td>
                    <td width="80px"><?php getCaption("Tanggal Check"); ?></td>
                    <td width="80px"><?php getCaption("Tgl J. Tempo"); ?></td>
                    <td width="105px"><?php getCaption("Uang Jaminan"); ?></td>
                    <td width="105px"><?php getCaption("Bayar Hutang"); ?></td>
                    <td width="200px"><?php getCaption("Keterangan"); ?></td>
                </tr>
                <tr>
                    <td><?php datebox2('pay_date'); ?></td>
                    <td>
                        <table><?php cmdPayType('pay_type', '', $site_url, 150); ?></table>
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
                    <td><?php textbox2('check_no', 90, 200); ?></td>
                    <td><?php datebox2('check_date'); ?></td>
                    <td><?php datebox2('due_date'); ?></td>
                    <td><?php numberbox2('pay_bt', 100, 250) ?></td>
                    <td><?php numberbox2('used_val', 100, 250) ?></td>
                    <td><?php textbox2('pay_desc', 175, 200); ?></td>

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
                        <button type="button" id="cmdSave2" title="Save" data-options="iconCls:'icon-save',group:'g2'" class="easyui-linkbutton"   onclick="saveData2()" disabled="true" ></button>
                        <button type="button" id="cmdCancel2" title="Batal" data-options="iconCls:'icon-undo',group:'g2'" class="easyui-linkbutton "  onclick="read_show2('')" disabled="true" ></button>
                        <button type="button" id="cmdAdd2" title="<?php getCaption("Tambah"); ?>"  class="easyui-linkbutton" data-options="iconCls:'icon-add'"  onclick="condAdd2()" disabled="true"></button>
                        <!--<button type="button" id="cmdEdit2" title="<?php getCaption("Ubah"); ?>" class="easyui-linkbutton easyui-tooltip glyphicon glyphicon-pencil btn btn-default" data-options="iconCls:'icon-edit'"  onclick="condEdit2()" disabled="true"></button>-->
                        <button type="button" id="cmdDelete2" title="<?php getCaption("Hapus"); ?>" class="cmdDelete2 easyui-linkbutton " data-options="iconCls:'icon-no'" onclick="rolesDel2()" disabled="true" > </button>
                    </td>
                    <td width="30"></td>
                    <td style="border-top:0px !important;">
                        <button id="cmdBayarBBN" title="Bayar BBN" class="cmdBayarBBN easyui-linkbutton" onclick="condBayarBBN()" data-options="iconCls:'icon-payment'">Bayar BBN</button>
                        <button id="cmdPrint1" title="Print" class="easyui-linkbutton" data-options="iconCls:'icon-print'" onclick="rolesPrintBuy()" >Print</button>
                        <button type="button" class="easyui-linkbutton" data-options="iconCls:'icon-redo'" onclick=" $('#BayarWindow').window('close');">Exit</button>
                    </td>

                </tr>

            </table>
        </form>
</div>

<div id="UJWindow" class="easyui-window" title="Uang Hutang" data-options="closable:true,minimizable:false,maximizable:false,collapsible:false,closed:true,modal:true,closed:true,inline:true" style="width:724px;height:300px;padding:10px;top:1;">
    <table id="dt_uj" class="easyui-datagrid"  title="" style="width:660px;height:200px;"></table>
    <br />
    <button type="button" id="getUJ" title="<?php getCaption("Get Uang Jaminan"); ?>" class="easyui-linkbutton" onclick="getUJaminan();" >Get</button>
    <button id="ok" type="button" class="easyui-linkbutton" onclick="$('#UJWindow').window('close');">Cancel</button>

</div>

<div id="PrintsWindow" class="easyui-window" title="Print Kwitansi Kendaraan" data-options="closable:true,minimizable:false,maximizable:false,collapsible:false,closed:true,modal:true,closed:true,inline:true" style="width:450px;height:250px;padding:10px;top:1;">
    <form id="form_validation4" method="post" style="text-align:center;padding:10px;">
        <table>
            <tr>
                <td style="width: 15%;"></td>
                <td style="width:70%;">
                    <table>
                        <tr>
                            <td>No. Kwitansi</td>
                            <td class="td-ro">:</td>
                            <td><input type="text" class="textbox" id="no_kwitansi" name="no_kwitansi" disabled="true"></input></td>
                        </tr>
                        <tr>
                            <td>Tgl. Kwitansi</td>
                            <td class="td-ro">:</td>
                            <td><input type="text" class="textbox" id="tgl_kwintansi" name="tgl_kwintansi" disabled="true" value="<?php echo date('Y-m-d'); ?>"></input></td>
                        </tr>
                        <tr>
                            <td>Signature</td>
                            <td class="td-ro">:</td>
                            <td><input type="text" class="textbox" id="signature" name="signature" value="<?php echo $session['C_USER']; ?>"></input></td>
                        </tr>
                        <tr>
                            <td>Jabatan</td>
                            <td class="td-ro">:</td>
                            <td><input type="text" class="textbox" id="jabatan" name="jabatan"  style="text-transform: uppercase;" value="KEPALA CABANG"></input></td>
                        </tr>
                        <tr><td colspan="3"></td></tr>
                        <tr><td colspan="3"></td></tr>
                        <tr><td colspan="3"></td></tr>
                        <tr>
                            <td colspan="3" style="text-align: center;">
                                <button type="button" title="<?php getCaption("Screen"); ?>" data-options="iconCls:'icon-search'" class="easyui-linkbutton" onclick="rolesPrintScreen('screen');" >Screen</button>
                                <button type="button" title="<?php getCaption("Print"); ?>" data-options="iconCls:'icon-print'" class="easyui-linkbutton" onclick="rolesPrintScreen('print');" >Print</button>
                                <button id="ok" type="button" class="easyui-linkbutton" onclick="$('#PrintsWindow').window('close');" data-options="iconCls:'icon-no'">Cancel</button>
                            </td>
                        </tr>        
                    </table>
                </td>
                <td style="width:15%;"></td>
            </tr>
        </table>
    </form>
</div>

<div id="screenWindow" class="easyui-window" title="Screen" data-options="closable:true,minimizable:false,maximizable:false,collapsible:false,closed:true,modal:true,closed:true,inline:true" style="width:1050px;height:500px;padding:10px;top:1;"></div>
<script>
    $('.loader').hide();
</script>

<?php  include 'uang_jaminan_supplier_fn.php'; ?>

