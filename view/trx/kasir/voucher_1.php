<?php $session = $_SESSION; ?>
<div style=" margin: 10px;" id="form_content">
    <form id="form_validation" method="post" >
        <div id="tableId"></div>
        <div class="single-form teen-margin">
            <table>
                <tr>
                    <td valign="top" width="520">
                        <table>
                            <tr>
                                <td>
                                    <table>
                                        <tr>
                                            <td width="120"><?php getCaption('No. Faktur'); ?></td>
                                            <td class="td-ro">:</td>
                                            <td>  <?php textbox2('apv_inv_no', 142, 150); ?></td>
                                        </tr>

                                        <?php cmdWrhs('wrhs_code', 'Warehouse'); ?>
                                    </table>
                                </td>
                                <td>
                                    <table>
                                        <?php datebox('apv_date', 'Tgl. Faktur'); ?>
                                        <?php datebox('opn_date', 'Tgl. Buat') ?>
                                    </table>
                                </td>
                            </tr>
                        
                            <tr>
                                <td colspan="2">
                                    <table>
                                        <tr>
                                            <td>
                                                <table>
                                                    <tr>
                                                        <td width="115.5"><?php getCaption("Supplier"); ?></td>
                                                        <td class="td-ro">:</td>
                                                        <td> 
                                                            <table style="margin-left: -2.5px">
                                                                <?php cmdSupp('supp_code', 'supp_name', ''); ?>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <?php textbox('note', 'Catatan', 340, 250); ?>
                                                </table>
                                            </td>
                                        </tr>   

                                    </table>
                                </td>
                            </tr>

                        </table>
                    </td>
                    <td valign="top">
                        <table style="float: right">  <?php datebox('cls_date', 'Tgl Closed', 200); ?></table>
                        <table>
                            <tr><td>  <b> <?php getCaption("Data Pembayaran"); ?></b></td></tr>
                        </table>

                        <div style="background: #f5f5f5;border-radius:4px;padding:5px;margin-top: 10px;">
                            <table>
                                <tr>
                                    <td><?php getCaption("Tgl. Bayar"); ?></td>
                                    <td class="td-ro">:</td>
                                    <td><table><tr><td><?php datebox2('pay_date'); ?></td></tr></table></td>
                                    <td><?php getCaption("Jenis Bayar"); ?></td>
                                    <td class="td-ro">:</td>
                                    <td><table><?php cmdPayType('pay_type', '', $site_url); ?></table></td>                                  
                                </tr>

                                <tr>
                                    <td><?php getCaption("Bank"); ?></td>
                                    <td class="td-ro">:</td>
                                    <td>
                                        <table><?php cmdBank('bank_code', '', $site_url); ?></table>
                                    </td>
                                    <td><?php getCaption("Mesin EDC"); ?></td>
                                    <td class="td-ro">:</td>
                                    <td colspan="4"><table><?php cmdEDC('edc_code', ''); ?></table></td>

                                </tr>

                                <tr>
                                    <td><?php getCaption("No. Check"); ?></td>
                                    <td class="td-ro">:</td>
                                    <td><table><tr><td><?php textbox2('check_no', 130, 150);?></td></tr></table></td>
                                    <td><?php getCaption("Tanggal Check"); ?></td>
                                    <td class="td-ro">:</td>
                                    <td><table><tr><td><?php datebox2('check_date'); ?></td></tr></table></td>
                                </tr>
                                <tr>
                                    <td><?php getCaption("Jatuh Tempo"); ?></td>
                                    <td class="td-ro">:</td>
                                    <td><table><tr><td><?php datebox2('due_date'); ?></td></tr></table></td>
                                    <td><?php getCaption("Kolektor"); ?></td>
                                    <td class="td-ro">:</td>
                                    <td colspan="4"><table><?php cmdCollector('coll_code', '', $site_url); ?></table></td>
                                </tr>

                                <tr>
                                    <td><?php getCaption("Keterangan"); ?></td>
                                    <td class="td-ro">:</td>
                                    <td colspan="4"><table><tr><td><?php textbox2('pay_desc', 400, 400);?></td></tr></table></td>

                                </tr>

                            </table>
                        </div>


                    </td>
                </tr>

            </table>

        </div>
        <div class="single-form">
            <table id="dt_apgd" class="easyui-datagrid"  title="" style="width:1050px;height:200px;"></table>
            <table>
                <tr>
                    <td width="693">
                        <table><tr><td><?php getCaption('Item'); ?></td></tr>
                            <tr><td><?php textbox2('tot_item', 50, 70); ?></td></tr></table>
                    </td>
                    <td>
                        <table>
                            <tr>
                                <td></td>
                                <td><?php getCaption("Pembayaran"); ?></td>
                                <td><?php getCaption("Diskon"); ?></td>
                            </tr>
                            <tr>
                                <td class="right">Total :</td>
                                <td><?php numberbox2('tot_paid', 'Total', 80, 12); ?></td>
                                <td><?php numberbox2('tot_disc', 'Diskon', 80, 12); ?></td>
                            </tr> 
                        </table>
                    </td>
                </tr>
            </table>

        </div>
        <div class="main-nav">
            <table>
                <tr>
                    <td><?php navigation_ci(); ?></td>
                    <td>
                        <table style="width:400px;" border="0">
                            <tr>

                                <td  style="border-top:0px !important;">
                                    <a href="#" id="cmdDetail"  class="easyui-linkbutton"  onclick="cmdDetail()" disabled="true">Detail</a>
                                    <span id="closeOn"></span>
                                    <button type="button" id="screen" title="<?php getCaption("Screen Faktur"); ?>" class="easyui-linkbutton" data-options="iconCls:'icon-search'" onclick="rolesPrintScreen('screen');" disabled="true" >Screen</button>
                                    <button type="button" id="print" title="<?php getCaption("Print Faktur"); ?>" class="easyui-linkbutton" data-options="iconCls:'icon-print'" onclick="rolesPrintScreen('print');" disabled="true" >Print</button>
                                    <button type="button" id="download" title="<?php getCaption("Download Faktur"); ?>" class="easyui-linkbutton"  onclick="rolesPrintScreen('download');" disabled="true" >Download</button>
                                </td>

                            </tr>
                        </table>   
                    </td>
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
                    <td  width="50"><?php getCaption("No. Faktur"); ?></td>
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
                    <td><?php textbox2('pur_inv_no', 100, 205);?></td>
                    <td><?php textbox2('po_no', 100, 205);?></td>
                    <!--<td><input type="text" name="apv_inv_no" id="apv_inv_no" disabled="true" style="width:100px;"></input></td>-->
                    <td  width="50"><?php numberbox2('inv_total', 100, 17); ?></td>
                    <td><?php numberbox2('hd_begin', 100, 17); ?></td>
                    <td><?php numberbox2('hd_paid', 100, 17); ?></td>
                    <td><?php numberbox2('hd_disc', 100, 17); ?></td>
                    <td><?php numberbox2('hd_end', 100, 17); ?></td>

                </tr>


                <tr>
                    <td colspan="5"></td>
                    <td></td>
                    <td colspan="2"></td>
                </tr>

                <tr>
                    <td><?php getCaption("No. Mesin"); ?></td>
                    <td><?php getCaption("Tgl. Faktur"); ?></td>
                    <td><?php getCaption("Tgl. PO"); ?></td>
                    <td><?php getCaption("Tgl. Voucher"); ?></td>
                    <td colspan="2"><?php getCaption("Nama Kendaraan"); ?></td>
                    <td colspan="2"><?php getCaption("Warna"); ?></td>
                    <td></td>
                </tr>
                <tr>
                    <td><?php textbox2('engine', 180, 200);?></td>
                    <td><?php datebox2('pur_date', 100);?></td>
                    <td><?php datebox2('po_date', 100);?></td>
                    <td><?php datebox2('apv_date', 100);?></td>

                    <td colspan="2"><?php textbox2('veh_name', 205, 205);?></td>
                    <td colspan="2"><?php textbox2('color_name', 205, 205);?></td>
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
                                    <button type="button" id="cmdSave2" title="Save" data-options="iconCls:'icon-save',group:'g2'" class="easyui-linkbutton" onclick="saveData2()" disabled="true" ></button>
                                    <button type="button" id="cmdCancel2" title="Batal" data-options="iconCls:'icon-undo',group:'g2'" class="easyui-linkbutton"   onclick="condCancel2()" disabled="true" ></button>
                                </td>
                                <td  style="border-top:0px !important;">
                                    <button type="button" id="cmdAdd2" title="<?php getCaption("Tambah"); ?>"  class="easyui-linkbutton" data-options="iconCls:'icon-add'"  onclick="condAdd2()" disabled="true"></button>
                                    <button type="button" id="cmdEdit2" title="<?php getCaption("Ubah"); ?>" class="easyui-linkbutton" data-options="iconCls:'icon-edit'"  onclick="condEdit2()" disabled="true"></button>
                                    <button type="button" id="cmdDelete2" title="<?php getCaption("Hapus"); ?>" class="easyui-linkbutton" data-options="iconCls:'icon-no'" onclick="deleteDetail()" disabled="true" > </button>
                                    <button id="ok" type="button" class="easyui-linkbutton" data-options="iconCls:'icon-ok'" onclick="$('#DetailWindow').window('close');"></button>
                                </td>

                            </tr>
                        </table>  </td>       
                </tr>
            </table>
        </form>
    </div>
</div>
<div id="screenWindow" class="easyui-window" title="Screen" data-options="closable:true,minimizable:false,maximizable:false,collapsible:false,closed:true,modal:true,closed:true,inline:true" style="width:1050px;height:500px;padding:10px;top:1;"></div>

<div id="SearchOption" style="display:none;">  
    <form id="form_validation3" method="post" >    
        <div id="optionSPK" style="padding:10px;">
            <span><?php getCaption("No. Faktur"); ?>:</span>
            <input id="code" name="code">
            <!--<span><?php getCaption("Nama Pelanggan"); ?>:</span>
            <input class="easyui-datebox" validType='validDate' data-options="required:false" id="arg_date2"  name="arg_date2" style="width:90;" disabled=false></input>
            -->
            <a href="#" class="easyui-linkbutton" onclick="doSearch()" iconCls="icon-search">Search</a>
            <button type="button"  title="<?php getCaption("Ok"); ?>" class="easyui-linkbutton easyui-tooltip btn btn-default" data-options="iconCls:'icon-ok'" onclick="getSearchselect()" >Ok </button>
            <button type="button" class="easyui-linkbutton easyui-tooltip btn btn-default" onclick="close_search();" data-options="iconCls:'icon-no'">Cancel</button>

        </div>
        <br />

    </form>
</div>

<?php include 'voucher_fn.php'; ?>
