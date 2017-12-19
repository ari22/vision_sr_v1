<?php
$key = searcharray('VSL', 'inv_type', $inv_seq);
$remark = $inv_seq[$key]['remark'];
?>
<div style=" margin: 10px;" id="form_content">
    <form id="form_validation" method="post" >
        <div id="tableId"></div>

        <div class="single-form teen-margin">
            <table>
                <tr>
                    <td width="600" valign="top">
                        <table>
                            <?php textbox('inv_type', 'Jenis Faktur', 350, 250); ?>
                            <tr>
                                <td width="120"><?php getCaption('No. Faktur'); ?></td>
                                <td class="td-ro">:</td>
                                <td>
                                    <table class='marginmin'>
                                        <tr>
                                            <td width="163">
                                                <select class="easyui-combogrid" id="sal_inv_no" name="sal_inv_no" style="width:142px" disabled="true"></select>

                                            <td width="80"><?php getCaption('Tgl. Faktur'); ?></td>
                                            <td class="td-ro">:</td>
                                            <td><?php datebox2('sal_date'); ?></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td width="120"><?php getCaption('Warehouse'); ?></td>
                                <td class="td-ro">:</td>
                                <td>
                                    <table class='marginmin'>
                                        <tr>
                                            <td width="163"><table style="margin-left: -3px;"><?php  cmdprtWrhs('wrhs_code', '',142); ?></table></td>
                                            <td width="80"><?php getCaption('Tgl. Pick'); ?></td>
                                            <td class="td-ro">:</td>
                                            <td><?php datebox2('opn_date'); ?></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td width="120"><?php getCaption('Billing Term'); ?></td>
                                <td class="td-ro">:</td>
                                <td>
                                    <table class='marginmin'>
                                        <tr>
                                            <td> <?php numberbox2('due_day', 50, 100) ?></td>
                                            <td><?php getCaption("Hari"); ?></td>
                                        </tr>
                                    </table>

                                </td>
                            </tr>
                            <?php
                            datebox('due_date', 'Tgl J. Tempo', 100);
                            ?>
                        </table>

                    </td>
                    <td valign="top">
                     
                        <table style="top: 1;">
                            <?php textboxset('cust_code', 'cust_name', 'Pelanggan', 80, 250); ?>
                            <?php textboxset('srep_code', 'srep_name', 'Sales', 80, 250); ?>
                            <tr><td colspan="3"></td></tr>
                            <tr><td colspan="3"></td></tr>
                            <tr><td colspan="3"></td></tr>
                            <?php datebox('cls_date', 'Tgl Closed', 200); ?>
                            <?php textbox('note', 'Keterangan', 335, 250); ?>
                            
                        </table>
                    </td>
                </tr>
            </table>
        </div>

        <div class="single-form">
            <!--<table id="dt_dpccd" class="easyui-datagrid"  title="" style="width:1040px;height:200px;"></table>-->
            <table id="dt" class="easyui-datagrid" style="width:1080px;height:150px;"></table>
            <br />
            <table  style="width:99%">
                <tr>
                    <td valign="top">
                        <table>
                            <tr>
                                <td width="350"> 
                                    <table>
                                        <tr><td><?php numberbox2('tot_item', 50, 70); ?></td><td><?php getCaption('Item'); ?></td></tr>
                                    </table>
                                </td>
                                <td>
                                    <table>

                                        <tr>
                                            <td class="right"><table> <tr><td><?php getCaption('Total'); ?> Qty:</td><td><?php numberbox2('tot_qty', 50, 70); ?></td></tr></table></td>
                                            <td><a href="#" id="setDiskon"  class="easyui-linkbutton"  onclick="setDiskonVal();" disabled="true">Set Disc</a></td>
                                        </tr> 
                                    </table>
                                </td>
                            </tr>
                        </table>

                    </td>
                    <td valign="top">
                        <table class="table" style="float:right; background: #A9CEDB;padding: 10px;">

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
                    <td width="200">
                        <table>
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
<div id="DetailWindow" class="easyui-window" title="Vehicle Accessories Sales" data-options="closable:true,minimizable:false,maximizable:false,collapsible:false,closed:true,modal:true,closed:true,inline:true" style="width:1060px;height:550px;padding:5px;top:1;">
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
            <input type="hidden" id="id3" name="id3">
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

                    <td><input id="part_code" name="part_code" style="width:100px" class="easyui-combogrid" autocomplete="off" disabled="true"></input></td>

                    <td><?php textbox2('part_name', 205, 150); ?></td>
                    <td><?php textbox2('wrhs_code', 70, 50); ?></td>
                    <td><?php numberbox2('qty', 50, 50); ?></td>
                    <td><table><?php textbox2('unit', 50, 50); ?></table></td>
                    <td class="right"><?php numberbox2('price_bd', 100, 50); ?></td>
                    <td class="right"><?php numberbox2('price_total', 100, 50); ?></td>
                    <td class="right"><input class="easyui-numberbox" precision="2" id="disc_pct"  name="disc_pct" style="width:65px"></td>
                    <td class="right"><?php numberbox2('disc_val', 100, 50); ?></td>
                    <td class="right"><?php numberbox2('price_ad', 100, 50); ?></td>
                </tr>

                <tr><td colspan="10"></td></tr>
                <tr><td colspan="10"></td></tr>

            </table>
            <table  style="float: right;">
                <tr>        
                    <td><b><?php getCaption("Sales"); ?> 1</b></td>
                    <td><b><?php getCaption("Sales"); ?> 2</b></td>
                    <td class="right"><b>Disc. <?php getCaption("Satuan"); ?> </b></td>
                    <td colspan="2" class="right"><b><?php getCaption("Harga Netto Satuan"); ?></b></td>
                </tr>
                <tr> 
                    <td><?php cmdaccSales('srep_code1', '', 0, 0, 100); ?></td>
                    <td><?php cmdaccSales('srep_code2', '', 0, 0, 100); ?></td>
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
<div id="SetDiskonWindow" class="easyui-window" title="Discount Setting" data-options="closable:true,minimizable:false,maximizable:false,collapsible:false,closed:true,modal:true,closed:true,inline:true" style="width:400px;height:330px;padding:5px;top:1;padding-top:15px;">
    <form id="form_diskon" method="post">
        <div style="width: 80%; margin: 0 auto;font-size:14px;font-weight: bold;">Discount Update:</div>
        <table style="border:1px solid #ccc;padding: 10px;padding-left: 5px !important;width: 80%; margin: 0 auto; ">
            <tr>
                <td>
                    <a href="#" class="checkbox" name="checkbox_1"><input type="radio" id="checkbox_1" class="checkbox_1" name="checkbox" value="1"> All Item</a>
                </td>
            </tr>
            <tr><td></td></tr>
            <tr>
                <td>
                    <a href="#" class="checkbox" name="checkbox_2"><input type="radio" id="checkbox_2" class="checkbox_2" name="checkbox" value="2"> Item Code</a>

                </td>
            </tr>
            <tr>
                <td style="padding-left: 25px;"> <input id="part_code" name="part_code" style="width:150px;margin-left:50px !important;" class="easyui-combogrid" autocomplete="off" disabled="true"></input></td>
            </tr>
        </table>
        <table style="padding: 10px;padding-left: 5px !important;width: 80%; margin: 0 auto; ">
            <tr>
                <td><?php getCaption('Yang Bernilai Diskon'); ?></td>
                <td class="td-ro">:</td>
                <td><?php numberbox2('disc1', 80, 10) ?> %</td>
            </tr>
            <tr>
                <td><?php getCaption('Menjadi'); ?></td>
                <td class="td-ro">:</td>
                <td><?php numberbox2('disc2', 80, 10) ?> %</td>
            </tr>
        </table>
        <div class="main-nav" style="margin-top: 10px;">
            <table style="padding: 10px;padding-left: 5px !important;width: 80%; margin: 0 auto; ">
                <tr>
                    <td>
                        <button id="ok" type="button" class="easyui-linkbutton" data-options="iconCls:'icon-ok'" onclick="saveDiskon();"> Process</button>
                        <button style="width: 80px;" type="button" id="Quit" title="<?php getCaption("Quit"); ?>" class="easyui-linkbutton" data-options="iconCls:'icon-no'" onclick="$('#SetDiskonWindow').window('close');"> Quit</button>
                    </td>
                </tr>
            </table>
        </div>
    </form>
</div>
<div id="SearchOption" style="display:none;">  
    <form id="formSearch" method="post" >    
        <div id="optionSPK" style="padding:10px;">
            <span><?php getCaption("No. Faktur"); ?>:</span>
            <?php textbox2('sal_inv_no2', 150, 150); ?>
            <span><?php getCaption("Tgl. Faktur"); ?>:</span>
            <input id="sal_date2"  name="sal_date2" style="width:90;"></input>
            <span><?php getCaption("Kode Pelanggan"); ?>:</span>
            <?php textbox2('cust_code2', 90, 150); ?>
            <span><?php getCaption("Nama Pelanggan"); ?>:</span>
            <?php textbox2('cust_name2', 90, 150); ?>

            <div class="main-nav" style="margin-top: 20px;">
                <a href="#" class="easyui-linkbutton" onclick="doSearch()" iconCls="icon-search">Search</a>
                <button type="button"  title="<?php getCaption("Ok"); ?>" class="easyui-linkbutton easyui-tooltip btn btn-default" data-options="iconCls:'icon-ok'" onclick="getSearchselect()" >Ok </button>
                <button type="button" class="easyui-linkbutton easyui-tooltip btn btn-default" onclick="close_search();">Cancel</button>
            </div>
        </div>

    </form>
</div>
<style>
    #form_diskon a{text-decoration:none !important;color:#000;}
</style>
<?php include 'penjualanacc_fn.php'; ?>