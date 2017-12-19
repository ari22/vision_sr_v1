<?php
$key = searcharray('APR', 'inv_type', $inv_seq);
$remark = $inv_seq[$key]['remark'];
?>
<div style=" margin: 10px;" id="form_content">
    <form id="form_validation" method="post" >
        <div id="tableId"></div>

        <div class="single-form teen-margin">
            <table width="99%">
                <tr>
                    <td valign='top'>
                        <table>
                            <tr>
                                <td><?php getCaption('Jenis Faktur'); ?></td>
                                <td class="td-ro">:</td>
                                <td><?php textbox2('inv_type', 357, 350); ?></td>
                            </tr>

                            <tr>
                                <td width="100"><?php getCaption('No. Faktur Beli'); ?></td>
                                <td class="td-ro">:</td>
                                <td>
                                    <table  class='marginmin'>
                                        <tr>
                                            <td width="150"><?php textbox2('pur_inv_no', 142, 150); ?></td>
                                            <td width="100"><?php getCaption('Tgl. Faktur Beli'); ?></td>
                                            <td class="td-ro">:</td>
                                            <td><?php datebox2('pur_date'); ?></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            
                            <?php cmdprtWrhs('wrhs_code', 'Warehouse'); ?>
                            <tr><td colspan="3"></td></tr>
                            <tr><td colspan="3"></td></tr>
                            <?php datebox('rcv_date', 'Tgl. Terima', 100); ?>
                            <?php textbox('note', 'Keterangan', 357, 250); ?>
                        </table>
                    </td>
                    <td valign='top' align="right">

                        <table>
                            <?php cmdAccSupp('supp_code', 'supp_name', 'Supplier', 113, 225); ?>
                            <tr>
                                <td colspan="3">
                                    <table class='marginmin' >
                                        <td valign='top' width="300">
                                            <table class='marginmin'>
                                                <?php textbox('sj_no', 'No. Surat Jalan', 145, 150); ?>
                                                <?php textbox('supp_invno', 'No. Faktur Supplier', 145, 150); ?>
                                                <tr>
                                                    <td><?php getCaption('No. PO'); ?></td>
                                                    <td class="td-ro">:</td>
                                                    <td><select class="easyui-combogrid" id="po_no" name="po_no" style="width:115px"></select>&nbsp;<button type="button" id="cmdDeletePO" title="Delete PO" class="easyui-linkbutton cmdDelete" data-options="iconCls:'icon-no'"  onclick="condDeletePO()" ></button></td>
                                                </tr>
                                                <tr>
                                                    <td><?php getCaption('Billing Term'); ?></td>
                                                    <td class="td-ro">:</td>
                                                    <td> <?php numberbox2('due_day', 50, 100) ?> <?php getCaption("Hari"); ?></td>
                                                </tr>
                                                <tr><td width='130'></td></tr>
                                            </table>
                                        </td>

                                        <td valign='top'>
                                            <table class='marginmin'>
                                                <?php datebox('sj_date', 'Tgl. Surat Jalan') ?>
                                                <?php datebox('supp_invdt', 'Tgl. Faktur') ?>
                                                <tr><td></td></tr>
                                                <tr>
                                                    <td><?php getCaption('Tgl. PO'); ?></td>
                                                    <td class="td-ro">:</td>
                                                    <td><?php datebox2('po_date'); ?></td>
                                                </tr>
                                                <?php datebox('due_date', 'Billing Date') ?>
                                            </table>
                                        </td>

                                    </table>
                                </td>
                            </tr>
                            <tr><td width='130'></td></tr>
                            <?php datebox('cls2_date', 'Tgl Closed', 200); ?>
                        </table>

                    </td>

                </tr>
            </table>
        </div>


        <div class="single-form" style="padding: 10px;">
            <!--<table id="dt_dpccd" class="easyui-datagrid"  title="" style="width:1040px;height:200px;"></table>-->
            <table id="dt" class="easyui-datagrid"  title="" style="width:1080px;height:150px;"></table>
            <br />
            <table style='width:100%'>
                <tr>
                    <td valign="top" >
                        <table>
                            <tr></td><td><?php getCaption('Item'); ?></td> <td><?php getCaption('Total'); ?> Qty</td></tr>

                            <tr>
                                <td><?php numberbox2('tot_item', 50, 70); ?>
                                <td><?php numberbox2('tot_qty', 50, 70); ?></td>
                            </tr>
                        </table>

                    </td>
                    <td valign="top" align="right">
                        <table>

                            <?php
                            numberbox('tot_price', 'Total Harga Netto', 200, 70);
                            numberbox('inv_disc', 'Diskon', 200, 70);
                            ?>
                            <tr><td></td><td class='td-ro'></td><td style="text-align:right;"><hr /></td><td><b>-</b></td></tr>
                            <?php
                            numberbox('inv_bt', 'DPP', 200, 70);
                            numberbox('inv_vat', 'PPN', 200, 70);
                            ?>
                            <tr><td></td><td class='td-ro'></td><td style="text-align:right;"><hr /></td><td><b>+</b></td></tr>
                            <?php
                            numberbox('inv_at', 'Sub Total', 200, 70);
                            numberbox('inv_stamp', 'Lain - Lain', 200, 70);
                            ?>
                            <tr><td></td><td class='td-ro'></td><td style="text-align:right;"><hr /></td><td><b>+</b></td></tr>

                            <?php
                            numberbox('inv_total', 'Grand Total', 200, 70);
                            ?>
                        </table>
                    </td>
                </tr>

            </table>


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
                                    <span id="closeOn"></span>
                                    <button type="button" id="screen" title="<?php getCaption("Screen Faktur"); ?>" class="easyui-linkbutton" data-options="iconCls:'icon-screen'" onclick="rolesPrintScreen('screen');" disabled="true" >Screen</button>
                                    <button type="button" id="print" title="<?php getCaption("Print Faktur"); ?>" class="easyui-linkbutton" data-options="iconCls:'icon-print'" onclick="rolesPrintScreen('print');" disabled="true" >Print</button>
                                    <!--<button type="button" id="download" title="<?php getCaption("Download Faktur"); ?>" class="easyui-linkbutton"  data-options="iconCls:'icon-download'" onclick="rolesPrintScreen('download');" disabled="true" >Download</button>-->

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


<div id="DetailWindow" class="easyui-window" title="Accessories Purchase" data-options="closable:true,minimizable:false,maximizable:false,collapsible:false,closed:true,modal:true,closed:true,inline:true" style="width:1060px;height:500px;padding:5px;top:1;">
    <div style="width: 990; margin: 20px;">
        <table id="dt2" class="easyui-datagrid"  title="" style="width:988px;height:200px;"></table>
        <br />
        <table style="float: right;">
            <tr>
                <td><b>Total <?php getCaption("QTY"); ?></b></td>
                <td class="td-ro">:</td>
                <td><?php numberbox2('hd_paid2', 95, 100); ?></td>
                <td><b>Total <?php getCaption("Harga Netto"); ?></b></td>
                <td class="td-ro">:</td>
                <td><?php numberbox2('hd_disc2', 95, 100); ?></td>
            </tr>
        </table>
        <br /><br /><br />

        <form id="form_validation2" method="post" >
            <div id="tableId2"></div>

            <table class="table" id="detail">
                <input type="hidden" id="pood_id" name="pood_id">
                <tr>
                    <td><b><?php getCaption("Kode Barang"); ?></b></td>
                    <td><b><?php getCaption("Nama Barang"); ?></b></td>
                    <td><b><?php getCaption("Warehouse"); ?></b></td>
                    <td class="right"><b><?php getCaption("QTY"); ?></b></td>
                    <td><b><?php getCaption("Satuan"); ?></b></td>
                    <td class="right"><b><?php getCaption("Harga Satuan"); ?></b></td>
                    <td class="right"><b><?php getCaption("Harga Total"); ?></b></td>
                    <td class="right"><b>Disc. (%)</b></td>
                    <td class="right"><b>Total Disc.</b></td>
                    <td class="right"><b><?php getCaption("Harga Netto"); ?></b></td>
                </tr>

                <tr>
                    <td><input id="part_code" name="part_code" style="width:100px" autocomplete="off" disabled="true"></input></td>
                    <td><?php textbox2('part_name', 240, 150); ?></td>
                    <td><?php textbox2('wrhs_code', 70, 50); ?></td>
                    <td><?php numberbox2('qty', 50, 50); ?></td>
                    <td><table><?php textbox2('unit', 50, 50); ?></table></td>
                    <td><?php numberbox2('price_bd', 90, 50); ?></td>
                    <td><?php numberbox2('price_total', 90, 50); ?></td>
                    <td><input class="easyui-numberbox" autocomplete="off" precision="2" id="disc_pct"  name="disc_pct" style="width:65px"></td>
                    <td><?php numberbox2('disc_val', 90, 50); ?></td>
                    <td><?php numberbox2('price_ad', 90, 50); ?></td>
                </tr>

                <tr><td colspan="10"></td></tr>
                <tr><td colspan="10"></td></tr>

            </table>
            <table  style="float: right;">
                <tr>        
                    <td><b><?php getCaption("Purchaser"); ?></b></td>
                    <td><b>Disc. <?php getCaption("Satuan"); ?> </b></td>
                    <td colspan="2"><b><?php getCaption("Harga Netto Satuan"); ?></b></td>
                </tr>
                <tr> 
                    <td><table><?php cmdAccPrep('prep_code', null, '', 120, null, 'single', 0, 0); ?></table></td>
                    <td><?php numberbox2('disc_unit', 90, 50); ?></td>
                    <td><?php numberbox2('price_ad_unit', 120, 50); ?></td>
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
<div id="SearchOption" style="display:none;">  
    <form id="formSearch" method="post" >    
        <div id="optionSPK" style="padding:10px;">
            <span><?php getCaption("No. Faktur Beli"); ?>:</span>
            <?php textbox2('pur_inv_no2', 150, 150); ?>
            <span><?php getCaption("Tgl. Faktur"); ?>:</span>
            <input id="pur_date2"  name="pur_date2" style="width:90;"></input>

            <a href="#" class="easyui-linkbutton" onclick="doSearch()" iconCls="icon-search">Search</a>
            <button type="button"  title="<?php getCaption("Ok"); ?>" class="easyui-linkbutton easyui-tooltip btn btn-default" data-options="iconCls:'icon-ok'" onclick="getSearchselect()" >Ok </button>
            <button type="button" class="easyui-linkbutton easyui-tooltip btn btn-default" onclick="close_search();">Cancel</button>

        </div>

    </form>
</div>
<?php include 'pembelianacc_fn.php'; ?>