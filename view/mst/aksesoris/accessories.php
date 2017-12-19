<div style="margin: 10px;" id="form_content">
    <form id="form_validation" method="post" action="">	
        <input type="hidden" name="id"  id="id">
        <input type="hidden" name="table"  id="table" value="<?php echo 'acc_mst'; ?>">

        <table border="0"  class="main-form" >
            <td> <table style="width: 650px;">
                    <?php
                    textbox('part_code', 'No. Part', 90, 17);
                    textbox('part_name', 'Nama Part', 250, 50);
                    textbox('part_alias', 'Part Alias', 250, 35);
                    ?>
                </table>
            </td>
        </table>

        <div class="easyui-tabs" id="tabscoi" >
            <div title="General" class="tab-pane main-tab" id="General">
                <table>
                    <tr>
                        <td valign="top">
                            <table>
                                 <tr>
                                <td>&nbsp;

                                </td>
                            </tr>
                                <?php
                                cmdUnit('unit', 'Satuan', 0, 0);
                                ?>
                                <tr><td colspan="3"></td></tr>
                                <?php
                                //numberbox('qty', 'Sisa Stok', 150, 10);
                                //numberbox('qty_pick', 'Pick Qty', 150, 10);
                                //numberbox('qty_order', 'Order Qty', 150, 10);
                                //numberbox('qty_border', 'Back Order Qty', 150, 10);
                                ?>
                                <tr>
                                    <td><?php getCaption('Sisa Stok'); ?> </td>
                                    <td class="td-ro">:</td>
                                    <td><?php numberbox2('qty', 120, 150) ?></td>
                                    <td><button type="button"  class="easyui-linkbutton cmdRefresh" data-options="iconCls:'icon-reload'"  onclick="cmdRef('qty')" title="Refresh" disabled="true"></button></td>
                                </tr>
                                <tr>
                                    <td><?php getCaption('Pick Qty'); ?> </td>
                                    <td class="td-ro">:</td>
                                    <td><?php numberbox2('qty_pick', 120, 150) ?></td>
                                    <td><button type="button" class="easyui-linkbutton cmdRefresh" data-options="iconCls:'icon-reload'"  onclick="cmdRef('qty_pick')" title="Refresh" disabled="true"></button></td>
                                </tr>
                                 <tr>
                                    <td><?php getCaption('Order Qty'); ?> </td>
                                    <td class="td-ro">:</td>
                                    <td><?php numberbox2('qty_order', 120, 150) ?></td>
                                    <td><button type="button" class="easyui-linkbutton cmdRefresh" data-options="iconCls:'icon-reload'"  onclick="cmdRef('qty_order')" title="Refresh" disabled="true"></button></td>
                                </tr>
                                <tr>
                                    <td><?php getCaption('Back Order Qty'); ?> </td>
                                    <td class="td-ro">:</td>
                                    <td><?php numberbox2('qty_border', 120, 150) ?></td>
                                    <td><button type="button" class="easyui-linkbutton cmdRefresh" data-options="iconCls:'icon-reload'"  onclick="cmdRef('qty_border')" title="Refresh" disabled="true"></button></td>
                                </tr>
                            </table>
                        </td>

                        <td valign="top">
                            <table style="margin-left: 30px;">
                                <tr><td></td><td></td><td style="font-weight: bold;"> <?php getCaption('Harga Satuan'); ?> </td></tr>
                                <tr>
                                    <td><?php getCaption('Harga Jual'); ?> </td>
                                    <td class="td-ro">:</td>
                                    <td><input onkeyup="ppn();" style="width:120px;" name="sal_price" id="sal_price" class="easyui-numberbox" data-options="min: 0,precision:0,groupSeparator:','" disabled="true"></input></td>
                                </tr>
                                <?php
                                //ppn(val, sal)
                                //numberbox('sal_price', 'Harga Jual', 200, 12);
                                numberbox('salvat', 'Harga Jual + PPN', 150, 20);
                                ?>
                                <tr><td colspan="2"></td></tr> <tr><td colspan="2"></td></tr>
                                <?php
                                cmdBrndAcc('brand_code', 'Merek');
                                cmdMdin('mdin_code', 'Made In');
                                cmdUse4('use4_code', 'Dipakai Untuk');
                                ?>
                                <tr><td colspan="2"></td></tr> <tr><td colspan="2"></td></tr>
                                <?php
                                datebox('input_date', 'Tanggal Input', 250);
                                textbox('note', 'Catatan', 300, 35);
                                ?>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
            <div title="Detail" class="tab-pane main-tab" id="Detail" >
                <table id="dt_table" class="easyui-datagrid"  title="" style="width:1050px;height:250px;"></table>
            </div>
        </div>

        <div class="main-nav">
            <table width="100%">
                <tr>
                    <td width="400"> <?php navigation_ci(); ?></td>
                    <td width="400">
                        <table border="0">
                            <tr>

                                <td  style="border-top:0px !important;">
                                    <a id="searchwrhs" class="easyui-linkbutton " href="javascript:void(0)" onclick="search_wrhs();" >Search Wrhs</a>
                                    <a href="#" id="detail"  class="easyui-linkbutton "  onclick="detail()"  href="javascript:void(0)">Detail</a>
                                    <span id="closeOn"></span>
                                    <a href="#" id="substitusi"  class="easyui-linkbutton"  onclick="substitution()"  href="javascript:void(0)">Substitusi</a>

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
<div id="detailW" class="easyui-window" title="<?php getCaption('Barang Per Warehouse');?>" data-options="closable:true,minimizable:false,maximizable:false,collapsible:false,closed:true,modal:true,closed:true,inline:true" style="width:1080px;height:500px;padding:10px;top:1;">
    <div id="form_content">
        <form id="form_validation2" method="post" action="">	
            <input type="hidden" name="id"  id="id2">
            <input type="hidden" name="table"  id="table2" value="<?php echo 'maccs'; ?>">

            <table border="0" style="width: 520px;">
                <tr>
                    <td>Part No </td>
                    <td class="td-ro">:</td>
                    <td><input type="text" name="part_code" id="part_code" disabled="true"></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Part Name </td>
                    <td class="td-ro">:</td>
                    <td><input type="text" name="part_name" id="part_name" disabled="true" style="width: 250px;"></td>
                    <td><input type="checkbox" name="prt_inact" id="prt_inact" value="1">Non Active </td>
                </tr>
            </table>
            <br />
            <div class="easyui-tabs">
                <div title="General" class="tab-pane main-tab">
                    <table>
                        <tr>
                            <td valign="top">
                                <table>
                                     <tr>
                                <td>&nbsp;

                                </td>
                            </tr>
                                    <?php
                                     cmdprtWrhs('wrhs_code', 'Warehouse');

                                    textbox('location', 'Lokasi', 120, 17);
                                    ?>
                                    <tr><td></td><td></td></tr>
                                    <tr><td></td><td></td></tr>
                                    <?php
                                    numberbox('qty', 'Sisa Stok', 150, 10);
                                    numberbox('qty_pick', 'Pick Qty', 150, 10);
                                    numberbox('qty_order', 'Order Qty', 150, 10);
                                    numberbox('qty_border', 'Back Order Qty', 150, 10);
                                    ?>
                                    <tr><td></td><td></td></tr>
                                    <tr><td></td><td></td></tr>
                                    <?php
                                    numberbox('min_qty', 'Min. Qty', 150, 10);
                                    numberbox('max_qty', 'Max. Qty', 150, 10);
                                    cmdUnit('unit', 'Satuan', 0, 0);
                                    ?>
                                </table>
                            </td>
                            <td valign="top">
                                <table style="margin-left: 20px; ">
                                    <tr><td></td><td></td><td style="font-weight: bold;"> <?php getCaption('Harga Satuan'); ?> :</td></tr>
                                    <tr>
                                        <td><?php getCaption('Harga Jual'); ?>  </td>
                                        <td class="td-ro">:</td>
                                        <td><input onkeyup="ppn2();" name="sal_price" id="sal_price" class="easyui-numberbox" data-options="min: 0,precision:0,groupSeparator:','" disabled="true" style="width:120px;"></input></td>
                                    </tr>
                                    <?php
                                    //numberbox('sal_price', 'Harga Jual', 200, 12);
                                    numberbox('salvat2', 'Harga Jual + PPN', 120, 20);
                                    ?>
                                    <tr><td colspan="2"></td></tr>
                                    <tr><td></td><td></td></tr>
                                    <?php
                                    datebox('last_sold', 'Tgl Jual Akhir', 250);
                                    cmdBrndAcc('brand_code', 'Merek');
                                    cmdMdin('mdin_code', 'Made In');
                                    cmdUse4('use4_code', 'Dipakai Untuk');
                                    ?>

                                </table>
                            </td>
                            <td valign="top">
                                <table style="margin-left: 20px;">
                                     <tr>
                                <td>&nbsp;

                                </td>
                            </tr>
                                    <?php
                                    cmdGroup('grp_code', 'Group');
                                    cmdSubGroup('sgrp_code', 'Sub Group');
                                    textbox('abc_group', 'ABC Group', 50, 17);
                                    ?>
                                    <tr><td colspan="2"></td></tr>
                                    <tr><td colspan="2"></td></tr>
                                    <?php
                                    textbox('note', 'Catatan', 250, 35);
                                    ?>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
                <div title="Purchase" class="tab-pane main-tab" >
                    <table>
                        <tr>
                            <td>
                                <table>
                                    <tr>
                                        <td><?php getCaption('Harga Beli'); ?></td>
                                        <td class="td-ro">:</td>
                                        <td><input onkeyup="diskon_price();" name="pur_price" id="pur_price" class="easyui-numberbox" data-options="min: 0,precision:0,groupSeparator:','" disabled="true"></input></td>
                                    </tr>
                                    <tr>
                                        <td><?php getCaption('Discount Beli'); ?></td>
                                        <td class="td-ro">:</td>
                                        <td><input onkeyup="diskon_price();" name="pur_disc" id="pur_disc" class="easyui-numberbox" data-options="min: 0,precision:0,groupSeparator:','" disabled="true" style="width:50px;"></input> %</td>
                                    </tr>
                                    <?php
                                    numberbox('purl_price', 'Harga Beli Netto', 150, 10);
                                    numberbox('aver_price', 'HPP Rata-rata', 150, 10);
                                    ?>
                                </table>
                            </td>
                            <td>
                                <table>
                                    <tr><td colspan="3"></td></tr>
                                    <?php datebox('last_pur', 'Tgl Beli Terakhir', 250); ?>
                                    <?php numberbox('price_end', 'Harga Beli Netto Terakhir', 100, 10); ?>
                                    <tr><td colspan="3"></td></tr>

                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="main-nav">
                <table class="table" style="width:500px;" border="0">
                    <tr>
                        <td  style="border-top:0px !important;">
                            <button type="button" id="cmdFirst2" title="First"  data-options="iconCls:'icon-first'" class="easyui-linkbutton cmdFirst2 " onclick="read_show2('F')"></button>
                            <button type="button" id="cmdPrev2" title="Prev" data-options="iconCls:'icon-prev'" class="easyui-linkbutton cmdPrev2"  onclick="read_show2('P')" ></button>
                            <button type="button" id="cmdNext2" title="Next" data-options="iconCls:'icon-next'" class="easyui-linkbutton cmdNext2"  onclick="read_show2('N')" ></button>
                            <button type="button" id="cmdLast2" title="Last" data-options="iconCls:'icon-last'" class="easyui-linkbutton cmdLast2"  onclick="read_show2('L')" ></button>
                        </td>
                        <td  style="border-top:0px !important;">
                            <button type="button" id="cmdSave2" title="Save"  data-options="iconCls:'icon-save',group:'g2'" class="easyui-linkbutton cmdSave2" onclick="saveData2()" ></button>
                            <button type="button" id="cmdCancel2" title="Batal" data-options="iconCls:'icon-undo',group:'g2'" class="easyui-linkbutton  cmdCancel2"  onclick="condCancel2()"  ></button>
                        </td>
                        <td  style="border-top:0px !important;">
                            <button type="button" id="cmdAdd2" title="<?php getCaption("Tambah"); ?>" data-options="iconCls:'icon-add'" class="easyui-linkbutton cmdAdd2"  onclick="condAdd2()"></button>
                            <button type="button" id="cmdEdit2" title="<?php getCaption("Ubah"); ?>" data-options="iconCls:'icon-edit'" class="easyui-linkbutton  cmdEdit2"  onclick="condEdit2()" ></button>
                            <button type="button" id="cmdDelete2" title="<?php getCaption("Hapus"); ?>" data-options="iconCls:'icon-no'" class="easyui-linkbutton cmdDelete2"  onclick="condDelete2()" ></button>
                            <button type="button" id='ok' class="easyui-linkbutton" data-options="iconCls:'icon-ok'"  onclick="closeWindow()" ></button>
                        </td>

                    </tr>
                </table>    
            </div>
        </form>
    </div>
</div>

<div id="substitusiW" class="easyui-window" title="Substitusi" data-options="closable:true,minimizable:false,maximizable:false,collapsible:false,closed:true,modal:true,closed:true,inline:true" style="width:1030px;height:500px;padding:10px;">
    <div style="width: 950; margin: 20px;">

        <table id="dt_substitution" class="easyui-datagrid"  title="" style="width:950px;height:250px;"></table>
        <br />
        <form id="form_validation3" method="post" action="">    
            <input type="hidden" name="id"  id="id3">
            <input type="hidden" name="table"  id="table3" value="<?php echo 'acc_subs'; ?>">

            <input type="hidden" name="part_code_copy" id="part_code_copy">
            <table class="table">
                <tr>
                    <td>
                        <table class="table">
                            <tr>
                                <td><b><?php getCaption('Kode Barang'); ?> </b></td>
                                <td><b><?php getCaption('Nama Barang'); ?> </b></td>
                                <td align="right"><b><?php getCaption('Harga Jual'); ?></b></td>
                                <td align="right"><b><?php getCaption('Qty'); ?></b></td>
                                <td align="right"><b><?php getCaption('Qty'); ?>  Pick</b></td>
                                <td><b><?php getCaption('Satuan'); ?></b></td>
                            </tr>
                            <tr>
                                <td><?php cmdacc_mst('part_code2', 'Kode', 0,0, 150); ?></td>

                                <td><?php textbox2('part_name', 260, 17); ?></td>
                                <td><?php numberbox2('sal_price', 120, 120) ?></td>
                                <td><?php numberbox2('qty', 120, 120) ?></td>
                                <td><?php numberbox2('qty_pick', 120, 120) ?></td>
                                <td><?php textbox2('unit', 100, 120) ?></td>                       
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>  
                        <table class="table" style="width:500px;" border="0">
                            <tr>
                                <td style="border-top:0px !important;">
                                    <button type="button" id="cmdFirst3" title="First" data-options="iconCls:'icon-first'" class="easyui-linkbutton" onclick="read_show3('F')" disabled="true"></button>
                                    <button type="button" id="cmdPrev3" title="Prev" data-options="iconCls:'icon-prev'" class="easyui-linkbutton" onclick="read_show3('P')" disabled="true"></button>
                                    <button type="button" id="cmdNext3" title="Next" data-options="iconCls:'icon-next'" class="easyui-linkbutton"  onclick="read_show3('N')" disabled="true"></button>
                                    <button type="button" id="cmdLast3" title="Last" data-options="iconCls:'icon-last'" class="easyui-linkbutton" onclick="read_show3('L')" disabled="true"></button>
                                </td>
                                <td  style="border-top:0px !important;">
                                    <button type="button" id="cmdSave3" title="Save" data-options="iconCls:'icon-save',group:'g2'" class="easyui-linkbutton"   onclick="saveData3()" disabled="true" ></button>
                                    <button type="button" id="cmdCancel3" title="Batal" data-options="iconCls:'icon-undo',group:'g2'" class="easyui-linkbutton"   onclick="condCancel3()" disabled="true" ></button>
                                </td>
                                <td  style="border-top:0px !important;">
                                    <button type="button" id="cmdAdd3" title="<?php getCaption("Tambah"); ?>"  class="easyui-linkbutton" data-options="iconCls:'icon-add'"  onclick="condAdd3()" disabled="true"></button>
                                    <!--<button type="button" id="cmdEdit3" title="<?php getCaption("Ubah"); ?>" class="easyui-linkbutton" data-options="iconCls:'icon-edit'"  onclick="condEdit3()" disabled="true"></button>-->
                                    <button type="button" id="cmdDelete3" title="<?php getCaption("Hapus"); ?>" class="easyui-linkbutton" data-options="iconCls:'icon-no'" onclick="condDelete3()" disabled="true" > </button>
                                    <button type="button" id="ok" class="easyui-linkbutton btn btn-default" data-options="iconCls:'icon-ok'"  onclick="closeWindow()"></button>
                                </td>

                            </tr>
                        </table>  </td>       
                </tr>
            </table>
        </form>
    </div>
</div>

<div id="SearchOption" style="display:none;">  
    <form id="form_validation4" method="post" >    
        <div id="optionSPK" style="padding:10px;">
            <span><?php getCaption("No. Part"); ?>:</span>
            <input id="code" name="code">
            <span><?php getCaption("Nama Part"); ?>:</span>
            <input id="name" name="name" >
            <a href="#" class="easyui-linkbutton" onclick="doSearch()" iconCls="icon-search">Search</a>
            <button type="button"  title="<?php getCaption("Ok"); ?>" class="easyui-linkbutton easyui-tooltip btn btn-default" data-options="iconCls:'icon-ok'" onclick="getSearchselect()" >Ok </button>
            <button type="button" class="easyui-linkbutton easyui-tooltip btn btn-default" onclick="close_search();">Cancel</button>

        </div>

    </form>
</div>

<div id="windowWrhs" class="easyui-window" title="Search Warehouse" data-options="closable:false,minimizable:false,maximizable:false,collapsible:false,closed:false,modal:true,closed:true,inline:true" style="width:900px;height:auto; max-height: 550px;padding:10px;">
    <table id="tableWrhs"></table> 

    <form id="form_validation5" method="post" >    
        <div style="padding:10px;">
            <span><?php getCaption("No. Part"); ?>:</span>
            <input id="code" name="code">
            <span><?php getCaption("Nama Part"); ?>:</span>
            <input id="name" name="name" >
            <a href="#" class="easyui-linkbutton" onclick="doSearchWrhs()" iconCls="icon-search">Search</a>
            <button type="button"  title="<?php getCaption("Ok"); ?>" class="easyui-linkbutton easyui-tooltip btn btn-default" data-options="iconCls:'icon-ok'" onclick="$('#windowWrhs').window('close');" >Ok </button>
            <button type="button" class="easyui-linkbutton easyui-tooltip btn btn-default" onclick="$('#windowWrhs').window('close');">Cancel</button>


        </div>

    </form>
</div>

<?php include 'accessories_fn.php';?>