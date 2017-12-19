<div style=" margin: 10px;" id="form_content">
    <form id="form_validation" method="post" >
        <div id="tableId"></div>
        <div id="results"></div>

        <table class="main-form">
            <td valign="top" width="450">
                <table>
                    <?php
                    textbox('po_no', 'No. PO', 90, 10);
                    datebox('po_date', 'Tgl PO', 100);
                    ?>
                    <tr>
                        <td width="100"><?php getCaption('Jatuh Tempo');?></td>
                        <td class="td-ro">:</td>
                        <td>
                            <table class='marginmin'>
                                <tr>
                                    <td> <?php numberbox2('due_day', 45, 100) ?></td>
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
                <table >
                    <?php cmdSupp('supp_code', 'supp_name', 'Supplier'); ?>
                    <?php cmdWrhs('wrhs_code', 'Warehouse'); ?>
                     <?php cmdLoc('loc_code', 'Location',200,0,1); ?>
                    <?php textbox('note', 'Keterangan', 285, 70); ?>
                    <?php datebox('cls_date', 'Tgl Closed', 200); ?>
                    <tr><td width="100"></td></tr>
                </table>
            </td>
        </table>

        <div class="easyui-tabs">
            <div title="<?php getCaption('Data Kendaraan'); ?>"  class="main-tab">	
                <table>
                    <tr>
                        <td valign="top" width="450">
                            <table>
                                <?php
                                cmdVehSet('veh_code', 'veh_name', 'Kendaraan');
                                textbox('chassis', 'Chassis', 150, 17);
                                textbox('engine', 'Engine', 150, 15);
                                ?>
                                <tr><td colspan="3"></td></tr>
                                <tr><td colspan="3"></td></tr>
                                <?php
                                textbox('veh_type', 'Tipe', 150, 10);
                                textbox('veh_model', 'Model', 150, 20);
                                ?>
                                <tr><td colspan="3"></td></tr>
                                <tr><td colspan="3"></td></tr>
                                <?php
                                textbox('veh_brand', 'Merek', 150, 15);
                                textbox('veh_transm', 'Transmisi', 40, 2);
                                textbox('veh_year', 'Tahun', 40, 4);
                                ?>
                                <tr><td colspan="3"></td></tr>
                                <tr><td colspan="3"></td></tr>
                                <?php
                                cmdStdoptSet('stdoptcode','stdoptname', 'Std. Optional');
                                //cmdStdopt('stdoptcode', 'Std. Optional');
                                ?>

                                <tr><td width="100"></td></tr>

                            </table>
                        </td>
                        <td></td>
                        <td valign="top">
                            <table>
                                <?php
                                cmdColSet('color_code', 'color_name', 'Warna');
                                textbox('color_type', 'Tipe', 40, 10);
                                ?>
                                <tr><td colspan="3"></td></tr>
                                <tr><td colspan="3"></td></tr> 
                                <?php
                                textbox('alarm', 'Alarm', 100, 10);
                                textbox('key_no', 'No. Kunci', 100, 10);
                                textbox('serv_book', 'Buku Service', 100, 10);
                                ?>
                                <tr><td width="100"></td></tr>
                                <tr><td colspan="3"></td></tr> 
                                <tr><td colspan="3"></td></tr>
                                <tr><td colspan="3"></td></tr> 
                                <tr><td colspan="3"></td></tr>
                                <tr><td colspan="3"></td></tr> 
                                <tr><td colspan="3"></td></tr>
                                <tr><td colspan="3"></td></tr> 
                                <tr>
                                    <td colspan="3">
                                        <table>
                                            <tr>                       
                                                <td>
                                                    <table>
                                                        <tr>

                                                            <td><?php getCaption("Qty"); ?></td>
                                                            <td><?php getCaption("Satuan"); ?></td>
                                                            <td class="right"><?php getCaption("Harga Satuan"); ?></td>
                                                            <td class="right"><?php getCaption("Harga Kendaraan"); ?></td>

                                                        </tr>
                                                        <tr>

                                                            <td><?php numberbox2('qty', 30, 50);?></td>
                                                            <td><?php textbox2('unit', 50, 100);?></td>

                                                            <td><?php numberbox2('unit_price', 95, 150);?></td>
                                                            <td><?php numberbox2('tot_price', 95, 150);?></td>

                                                        </tr>
                                                    </table>
                                                </td>
                                                <td></td>
                                                <td>
                                                    <table>
                                                        <tr><td><?php getCaption("Perkiraan Stok"); ?></td></tr>
                                                        <tr><td><?php datebox2('pred_stk_d', 120);?></td>  </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>


                </table>
            </div>

            <div title="<?php getCaption('Dokumen'); ?>"   class="main-tab">
                <table >						
                    <td>
                        <table>
                            <?php
                            textbox('po_made_by', 'Pembuat', 200, 50);
                            textbox('po_appr_by', 'Disetujui', 200, 50);
                            ?>
                             <tr><td width="100"></td></tr>
                        </table>
                    </td>						
                </table>
            </div>
        </div>

        <div class="main-nav">
            <table class="table">
                <tr>
                    <td style="width: 400px !important;"> <?php navigation_ci(); ?></td>
                    <td>
                        <table class="table" style="width:500px;" border="0">
                            <tr>

                                <td  style="border-top:0px !important;">
                                    <span id="closeOn"></span>
                                    <button type="button" id="screen" title="<?php getCaption("screen"); ?>" class="easyui-linkbutton btn btn-default" data-options="iconCls:'icon-screen'" onclick="rolesPrintScreen('screen');" disabled="true" >Screen</button>
                                    <button type="button" id="print" title="<?php getCaption("print"); ?>" class="easyui-linkbutton btn btn-default" data-options="iconCls:'icon-print'" onclick="rolesPrintScreen('print');" disabled="true" >Print</button>
                                </td>
                                <td>
                                    <table><?php  textbox('pur_inv_no', 'No. Faktur Beli', 120, 50);?></table>
                                </td>
                            </tr>
                        </table>   
                    </td>
                     <td align="right" width="200"><img src="<?php echo $loc_jui . "themes/icons/version.png" ?>" id="version"></td>
                </tr>
            </table>
        </div>
    </form>
</div>

<div id="sr" class="easyui-window" title="screen" data-options="closable:true,minimizable:false,maximizable:false,collapsible:false,closed:true,modal:true,closed:true,inline:true" style="width:1050px;height:500px;padding:10px;top:1;"></div>

<div id="SearchOption" style="display:none;">  
    <form id="form_validation2" method="post" >    
        <div id="optionSPK" style="padding:10px;">
            <span><?php getCaption("No. PO"); ?>:</span>
            <input id="po_no2" name="po_no2">
            <span><?php getCaption("Tgl. PO"); ?>:</span>
            <input type="text" id="po_date2" name="po_date2" style="width:103px;"/>
            <a href="#" class="easyui-linkbutton" onclick="doSearch()" iconCls="icon-search">Search</a>
            <button type="button"  title="<?php getCaption("Ok"); ?>" class="easyui-linkbutton easyui-tooltip btn btn-default" data-options="iconCls:'icon-ok'" onclick="getSearchselect()" >Ok </button>
            <button type="button" class="easyui-linkbutton easyui-tooltip btn btn-default" onclick="close_search();">Cancel</button>

        </div>

    </form>
</div>
<?php
include 'orderpembelian_fn.php';
