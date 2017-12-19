<div style=" margin: 10px;" id="form_content">
    <form id="form_validation" method="post" >
        <div id="tableId"></div>
        <div class="single-form teen-margin">
            <table>
                <tr>
                    <td valign="top">
                        <table style="width: 600px;">
                            <tr>
                                <td><?php getCaption("No. PO"); ?></td>
                                <td class="td-ro">:</td>
                                <td>
                                    <table class='marginmin'>
                                        <tr>
                                            <td><?php textbox2('po_no', 130, 12); ?></td>

                                            <td width="110"><?php getCaption("Tgl. PO"); ?></td>
                                            <td class="td-ro">:</td>
                                            <td><?php datebox2('po_date'); ?></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td><?php getCaption("Jenis PO"); ?></td>
                                <td class="td-ro">:</td>
                                <td>
                                    <table class='marginmin'>
                                        <tr>
                                            <td>
                                                <select class="select" name="po_type" id="po_type" style="width:130px;" disabled="true">
                                                    <option value="HOTLINE">Hotline</option>
                                                    <option value="NORMAL">Normal</option>
                                                    <option value="U.UDARA">Via Udara</option>
                                                    <option value="URGENT">Urgent</option>
                                                </select>
                                            </td>
                                            <td width="110"><?php getCaption("Tgl. Buat"); ?></td>
                                            <td class="td-ro">:</td>
                                            <td><?php datebox2('opn_date'); ?></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td><?php getCaption("No. Quotation"); ?></td>
                                <td class="td-ro">:</td>
                                <td>
                                    <table class='marginmin'>
                                        <tr>
                                            <td><?php textbox2('quote_no', 130, 12); ?></td>

                                            <td width="110"><?php getCaption("Tgl. Quotation"); ?></td>
                                            <td class="td-ro">:</td>
                                            <td><?php datebox2('quote_date'); ?></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr><td colspan="3"></td></tr>
                            <tr><td colspan="3"></td></tr>
                            <?php cmdAccSupp('supp_code', 'supp_name', 'Supplier', 100, 242); ?>
                            <?php textbox('saddr', 'Alamat', 345, 200); ?>
                            <tr>
                                <td></td>
                                <td class="td-ro"></td>
                                <td>
                                    <table class='marginmin'>
                                        <tr>
                                            <td><?php textbox2('sarea', 102, 12); ?></td>
                                            <td><?php textbox2('scity', 102, 12); ?></td>
                                            <td><?php textbox2('scountry', 80, 12); ?></td>
                                            <td><?php textbox2('szipcode', 50, 12); ?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><?php getCaption("Telepon"); ?>: <?php textbox2('sphone', 102, 12); ?></td>
                                            <td colspan="2"><?php getCaption("Fax"); ?>: <?php textbox2('sfax', 104, 12); ?></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>

                    </td>
                    <td valign="top">

                        <table style="border:1px solid #fff;padding: 2px;margin-bottom: 5px;">
                            <?php cmdAccPrep('prep_code', 'prep_name', 'Purchaser', 100, 260); ?>
                            <tr><td  width="70"></td></tr>
                        </table>
                        <table style="border:1px solid #ccc;padding: 2px;">
                            <tr>
                                <td width="70"><?php getCaption("Dikirim ke"); ?></td>
                                <td class="td-ro">:</td>
                                <td>
                                    <table class='marginmin'>
                                        <tr>
                                            <td>
                                                <table class='marginmin'> <?php cmdRAddress('raddr_code', '', 0, 0); ?></table>
                                            </td>
                                            <td colspan="3"><?php textbox2('rname', 236, 12); ?></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <?php textbox('raddr', 'Alamat', 345, 200); ?>
                            <tr>
                                <td></td>
                                <td class="td-ro"></td>
                                <td>
                                    <table class='marginmin'>
                                        <tr>
                                            <td><?php textbox2('rarea', 102, 12); ?></td>
                                            <td><?php textbox2('rcity', 102, 12); ?></td>
                                            <td><?php textbox2('rcountry', 80, 12); ?></td>
                                            <td><?php textbox2('rzipcode', 50, 12); ?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><?php getCaption("Telepon"); ?>: <?php textbox2('rphone', 102, 12); ?></td>
                                            <td colspan="2"><?php getCaption("Fax"); ?>: <?php textbox2('rfax', 104, 12); ?></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>

                        </table>
                        <table style="border:1px solid #fff;padding: 2px;">
                            <tr>
                                <td width="70"><?php getCaption("Tgl. Kirim"); ?></td>
                                <td class="td-ro">:</td>
                                <td>
                                    <table class='marginmin'>
                                        <tr>
                                            <td width="150"><?php datebox2('prcvd_date'); ?></td>

                                            <td  width='80'><?php getCaption("Jatuh Tempo"); ?></td>
                                            <td class="td-ro">:</td>
                                            <td>
                                                <table class='marginmin'>
                                                    <tr>
                                                        <td> <?php numberbox2('due_day', 60, 100) ?></td>
                                                        <td><?php getCaption("Hari"); ?></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td class="td-ro"></td>
                                <td>
                                    <table class='marginmin'>
                                        <tr>
                                            <td width="150"></td>

                                            <td width='80'><?php getCaption("Tgl J. Tempo"); ?></td>
                                            <td class="td-ro">:</td>
                                            <td><?php datebox2('due_date'); ?></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <?php datebox('cls_date', 'Tgl Closed', 200); ?>
                        </table>
                    </td>

                </tr>
            </table>
        </div>
        <div class="single-form" style="padding: 10px;">
            <table id="dt" class="easyui-datagrid"  title="" style="width:1080px;height:200px;"></table>

            <br />
            <table width="98%">
                <tr>
                    <td colspan="2">
                        <table>
                            <tr>
                                <td valign="top"><table><?php textbox('tot_item', 'Item', 50, 250); ?></table></td>
                                <td valign="top"><table><?php cmdCurr('curr_code', 'Currency'); ?></table></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td valign="top">
                        <table>
                            <?php textbox('note', '1', 350, 250); ?>
                            <?php textbox('note2', '2', 350, 250); ?>
                            <?php textbox('note3', '3', 350, 250); ?>
                            <?php textbox('note4', '4', 350, 250); ?>
                        </table>
                    </td>
                    <td valign="top" align="right">
                        <table class="table">

                            <?php
                            numberbox('tot_price', 'Total Harga Netto', 200, 70);
                            numberbox('inv_disc', 'Diskon', 200, 70);
                            ?>
                            <tr><td></td><td class='td-ro'></td><td style="text-align:right;"><hr /></td><td><b>-</b></td></tr>
                            <?php
                            numberbox('inv_bt', 'DPP', 200, 70);
                            //numberbox('inv_vat', 'PPN', 200, 70);
                            ?>
							<tr>
								<td><?php getCaption('PPN');?></td>
								<td>:</td>
								<td><?php numberbox2('inv_vat', 120, 70);?></td>
								<td><button type="button" data-options="iconCls:'icon-no'"  title="Tax(VAT) deleted" class="easyui-linkbutton deletePPN"  onclick="deletePPN()" ></button></td>
							</tr>
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
                        <table border="0">
                            <tr>
                                <td  style="border-top:0px !important;">
                                    <button type="button" id="cmdDetail"  class="easyui-linkbutton"  onclick="cmdDetails()" disabled="false">Detail</button>
                                    <span id="closeOn"></span>
                                    <button type="button" id="screen" title="<?php getCaption("Screen Faktur"); ?>" class="easyui-linkbutton" data-options="iconCls:'icon-screen'" onclick="rolesPrintScreen('screen');" disabled="true" >Screen</button>
                                    <button type="button" id="print" title="<?php getCaption("Print Faktur"); ?>" class="easyui-linkbutton" data-options="iconCls:'icon-print'" onclick="rolesPrintScreen('print');" disabled="true" >Print</button>
                                    <!--<button type="button" id="download" title="<?php getCaption("Download Faktur"); ?>" class="easyui-linkbutton" data-options="iconCls:'icon-download'" onclick="rolesPrintScreen('download');" disabled="true" >Download</button>-->
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
<div id="DetailWindow" class="easyui-window" title="Accessories Purchase Order " data-options="closable:true,minimizable:false,maximizable:false,collapsible:false,closed:true,modal:true,closed:true,inline:true" style="width:1060px;height:550px;padding:5px;top:1;">
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
            <input type="hidden" name="id3" id="id3">
            <input type="hidden" name="location" id="location">
            <table class="table" id="detail">
                <tr>
                    <td><b><?php getCaption("Kode Barang"); ?></b></td>
                    <td><b><?php getCaption("Nama Barang"); ?></b></td>
                    <td><b><?php getCaption("Warehouse"); ?></b></td>
                    <td><b><?php getCaption("QTY"); ?></b></td>
                    <td><b><?php getCaption("Satuan"); ?></b></td>
                    <td><b><?php getCaption("Harga Satuan"); ?></b></td>
                    <td><b><?php getCaption("Harga Total"); ?></b></td>
                    <td><b>Disc. (%)</b></td>
                    <td><b>Total Disc.</b></td>
                    <td><b><?php getCaption("Harga Netto"); ?></b></td>
                </tr>

                <tr>
                    <td><table><?php cmdMaccs('part_code', '', 0, 0, 100); ?></table></td>
                    <td><?php textbox2('part_name', 205, 150); ?></td>
                    <td><?php textbox2('wrhs_code', 70, 50); ?></td>
                    <td><?php numberbox2('qty', 50, 50); ?></td>
                    <td><table><?php textbox2('unit', 50, 50); ?></table></td>
                    <td><?php numberbox2('price_bd', 90, 50); ?></td>
                    <td><?php numberbox2('price_total', 90, 50); ?></td>
                    <td><input class="easyui-numberbox" precision="2" id="disc_pct"  name="disc_pct" style="width:65px"></td>
                    <td><?php numberbox2('disc_val', 90, 50); ?></td>
                    <td><?php numberbox2('price_ad', 90, 50); ?></td>
                </tr>

                <tr><td colspan="10"></td></tr>
                <tr><td colspan="10"></td></tr>

            </table>
            <table  style="float: right;">
                <tr>

                    <td><b>Disc. <?php getCaption("Satuan"); ?> </b></td>
                    <td colspan="2"><b><?php getCaption("Harga Netto Satuan"); ?></b></td>
                </tr>
                <tr>

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
            <span><?php getCaption("No. PO"); ?>:</span>
            <?php textbox2('po_no2', 150, 150); ?>
            <span><?php getCaption("Tgl. PO"); ?>:</span>
            <input id="po_date2"  name="po_date2" style="width:90;"></input>

            <a href="#" class="easyui-linkbutton" onclick="doSearch()" iconCls="icon-search">Search</a>
            <button type="button"  title="<?php getCaption("Ok"); ?>" class="easyui-linkbutton easyui-tooltip btn btn-default" data-options="iconCls:'icon-ok'" onclick="getSearchselect()" >Ok </button>
            <button type="button" class="easyui-linkbutton easyui-tooltip btn btn-default" onclick="close_search();">Cancel</button>

        </div>

    </form>
</div>
<?php include 'orderacc_fn.php'; ?>
