<?php $session = $_SESSION; ?>
<div style=" margin: 10px;" id="form_content">
    <form id="form_validation" method="post" >
        <div id="tableId"></div>
        <div class="single-form teen-margin">
            <table>
                <tr>
                    <td valign='top' width="515">
                        <table style="margin-top: 25px;">
                            <tr>
                                <td valign='top'>
                                    <table class='marginmin'>
                                        <?php textbox('apv_inv_no', 'No. Faktur', 142, 150); ?>
                                        <?php cmdWrhs('wrhs_code', 'Warehouse'); ?>
                                        <tr><td class='col100'></td></tr>
                                    </table>
                                </td>
                                <td valign='top'>
                                    <table class='marginmin'>
                                        <?php datebox('apv_date', 'Tgl. Faktur'); ?>
                                        <?php datebox('opn_date', 'Tgl. Buat') ?>
                                        <tr><td class='col100'></td></tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan='2' valign='top'>
                                    <table class='marginmin'>
                                        <?php cmdSupp('supp_code', 'supp_name', 'Supplier'); ?>

                                        <?php textbox('note', 'Catatan', 350, 250); ?>
                                        <tr><td class='col100'></td></tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td valign='top'>
                        <table style="float: right;margin-right: 5px;">  <?php datebox('cls_date', 'Tgl Closed', 200); ?></table>

                        <table class='marginmin'>
                            <tr><td><b> <?php getCaption("Data Pembayaran"); ?></b></td></tr>
                        </table>
                        <table style='background: #f5f5f5; padding:5px;'>
                            <tr>
                                <td valign='top'>
                                    <table class='marginmin'>
                                        <?php datebox('pay_date', 'Tgl. Bayar'); ?>
                                        <?php cmdBank('bank_code', 'Bank', $site_url); ?>
                                        <?php textbox('check_no', 'No. Check', 130, 150) ?>
                                        <?php datebox('due_date', 'Jatuh Tempo'); ?>
                                        <tr><td class='col100'></td></tr>
                                    </table>
                                </td>
                                <td valign='top'>
                                    <table class='marginmin'>
                                        <?php cmdPayType('pay_type', 'Jenis Bayar', $site_url); ?>
                                        <?php cmdEDC('edc_code', 'Mesin EDC'); ?>
                                        <?php datebox('check_date', "Tanggal Check"); ?>
                                        <?php cmdCollector('coll_code', 'Kolektor', $site_url); ?>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan='2'>
                                    <table class='marginmin'>
                                        <?php textbox('pay_desc', 'Keterangan', 405, 400) ?>
                                        <tr><td class='col100'></td></tr>
                                    </table>
                                </td>
                            </tr>

                        </table>
                    </td>
                </tr>
            </table>

        </div>
        <div class="single-form">
            <table id="dt_apgd" class="easyui-datagrid"  title="" style="width:1080px;height:200px;"></table>
            <table width="86.5%">
                <tr>
                    <td valign="top">
                        <table><tr><td align="right"><?php getCaption('Item'); ?></td></tr>
                            <tr><td><?php textbox2('tot_item', 50, 70); ?></td></tr></table>
                    </td>
                    <td valign="top" align="right">
                        <table>
                            <tr>
                                <td></td>
                                <td align="right"><?php getCaption("Pembayaran"); ?></td>
                                <td align="right"><?php getCaption("Diskon"); ?></td>
                            </tr>
                            <tr>
                                <td class="right">Total :</td>
                                <td><?php numberbox2('tot_paid', 120, 12); ?></td>
                                <td><?php numberbox2('tot_disc', 120, 12); ?></td>
                            </tr> 
                        </table>
                    </td>
                </tr>
            </table>

        </div>
        <div class="main-nav">
            <table width="100%">
                <tr>
                    <td width="400"><?php navigation_ci(); ?></td>
                    <td width="500">
                        <table border="0">
                            <tr>

                                <td  style="border-top:0px !important;">
                                    <button type="button" id="cmdDetail"  class="easyui-linkbutton"  onclick="cmdDetails()" disabled="true">Detail</button>
                                    <span id="closeOn"></span>
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
<div id="DetailWindow" class="easyui-window" title="Detail" data-options="closable:true,minimizable:false,maximizable:false,collapsible:false,closed:true,modal:true,closed:true,inline:true" style="width:1084px;height:500px;padding:5px;top:1;">
    <div style=" margin: 20px;">
        <table id="dt_apgd2" class="easyui-datagrid"  title="" style="width:1010px;height:200px;"></table>
        <br />
        <form id="form_validation2" method="post" >
            <div id="tableId2"></div>

            <table>
                <tr>
                    <td><?php getCaption("Nomor Rangka"); ?></td>
                    <td  width="50"><?php getCaption("No. Faktur Beli"); ?></td>
                    <td><?php getCaption("No. PO"); ?></td>
                    <!--<td><?php getCaption("No. Voucher"); ?></td>-->
                    <td><?php getCaption("Hutang"); ?></td>
                    <td  width="50"><?php getCaption("Saldo Awal"); ?></td>
                    <td  width="50"><?php getCaption("Pembayaran"); ?></td>
                    <td><?php getCaption("Diskon"); ?></td>
                    <td><?php getCaption("Saldo Akhir"); ?></td>
                </tr>
                <tr>
                    <td><input class="easyui-combogrid" id="chassis" name="chassis" disabled="true" style="width: 180px;"></input></td>
                    <td><?php textbox2('pur_inv_no', 120, 205); ?></td>
                    <td><?php textbox2('po_no', 120, 205); ?></td>
                    <!--<td><input type="text" name="apv_inv_no" id="apv_inv_no" disabled="true" style="width:100px;"></input></td>-->
                    <td  width="50"><?php numberbox2('inv_total', 110, 17); ?></td>
                    <td><?php numberbox2('hd_begin', 110, 17); ?></td>
                    <td><?php numberbox2('hd_paid', 110, 17); ?></td>
                    <td><?php numberbox2('hd_disc', 110, 17); ?></td>
                    <td><?php numberbox2('hd_end', 110, 17); ?></td>

                </tr>


                <tr>
                    <td colspan="5"></td>
                    <td></td>
                    <td colspan="2"></td>
                </tr>

                <tr>
                    <td><?php getCaption("No. Mesin"); ?></td>
                    <td><?php getCaption("Tgl. Faktur Beli"); ?></td>
                    <td><?php getCaption("Tgl. PO"); ?></td>
                    <td><?php getCaption("Tgl. Voucher"); ?></td>
                    <td colspan="2"><?php getCaption("Nama Kendaraan"); ?></td>
                    <td colspan="2"><?php getCaption("Warna"); ?></td>
                    <td></td>
                </tr>
                <tr>
                    <td><?php textbox2('engine', 180, 200); ?></td>
                    <td><?php datebox2('pur_date', 100); ?></td>
                    <td><?php datebox2('po_date', 100); ?></td>
                    <td><?php datebox2('apv_date', 100); ?></td>

                    <td colspan="2"><?php textbox2('veh_name', 205, 205); ?></td>
                    <td colspan="2"><?php textbox2('color_name', 205, 205); ?></td>
                    <td></td>
                </tr>


            </table>
            <br />
            <table>
                <tr>
                    <td>  
                        <table class="table" style="width:500px;" border="0">
                            <tr>
                                <td style="border-top:0px !important;">
                                    <button type="button" id="cmdFirst2" title="First" data-options="iconCls:'icon-first'" class="easyui-linkbutton" onclick="read_show2('F')" disabled="true"></button>
                                    <button type="button" id="cmdPrev2" title="Prev" data-options="iconCls:'icon-prev'" class="easyui-linkbutton" onclick="read_show2('P')" disabled="true"></button>
                                    <button type="button" id="cmdNext2" title="Next" data-options="iconCls:'icon-next'" class="easyui-linkbutton"  onclick="read_show2('N')" disabled="true"></button>
                                    <button type="button" id="cmdLast2" title="Last" data-options="iconCls:'icon-last'" class="easyui-linkbutton" onclick="read_show2('L')" disabled="true"></button>
                                </td>
                                <td  style="border-top:0px !important;">
                                    <button type="button" id="cmdSave2" title="Save" data-options="iconCls:'icon-save',group:'g2'" class="easyui-linkbutton" onclick="rolesSave2()" disabled="true" ></button>
                                    <button type="button" id="cmdCancel2" title="Batal" data-options="iconCls:'icon-undo',group:'g2'" class="easyui-linkbutton"   onclick="condCancel2()" disabled="true" ></button>
                                </td>
                                <td  style="border-top:0px !important;">
                                    <button type="button" id="cmdAdd2" title="<?php getCaption("Tambah"); ?>"  class="easyui-linkbutton" data-options="iconCls:'icon-add'"  onclick="rolesAdd2()" disabled="true"></button>
                                    <button type="button" id="cmdEdit2" title="<?php getCaption("Ubah"); ?>" class="easyui-linkbutton" data-options="iconCls:'icon-edit'"  onclick="condEdit2()" disabled="true"></button>
                                    <button type="button" id="cmdDelete2" title="<?php getCaption("Hapus"); ?>" class="easyui-linkbutton" data-options="iconCls:'icon-no'" onclick="rolesDel2()" disabled="true" > </button>
                                    <button id="ok2" type="button" class="easyui-linkbutton" data-options="iconCls:'icon-ok'" onclick="$('#DetailWindow').window('close');"></button>
                                </td>

                            </tr>
                        </table>  
                    </td>       
                </tr>
            </table>
        </form>
    </div>
</div>
<div id="screenWindow" class="easyui-window" title="Screen" data-options="closable:true,minimizable:false,maximizable:false,collapsible:false,closed:true,modal:true,closed:true,inline:true" style="width:1050px;height:500px;padding:10px;top:1;"></div>
<?php include 'voucher_fn.php'; ?>
