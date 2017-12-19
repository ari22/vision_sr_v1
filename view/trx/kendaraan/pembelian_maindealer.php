<div style=" margin: 10px;" id="form_content">
    <form id="form_validation" method="post" >
        <div id="tableId"></div>
        <div id="results"></div>

        <table class="main-form">
            <tr>
                <td valign="top" width="400">
                    <table>
                        <?php
                        textbox('pur_inv_no', 'No. Faktur Beli', 90, 70);
                        datebox('pur_date', 'Tgl. Faktur Beli', 90, 70);
                        datebox('stk_date', 'Tgl. terima', 250);
                        textbox('po_no', 'No. PO', 90, 70);
                        datebox('po_date', 'tgl PO', 250);
                        ?>
                        <tr><td width="100"></td></tr>
                    </table>
                </td>
                <td valign="top">
                    <table>
                        <?php cmdSupp('supp_code', 'supp_name', 'Supplier'); ?>
                        <?php cmdWrhs('wrhs_code', 'Warehouse'); ?>
                        <?php cmdLoc('loc_code', 'Location'); ?>
                        <tr>
                            <td><?php getCaption('Jatuh Tempo'); ?>  </td>
                            <td class="td-ro">:</td>
                            <td colspan="6">

                                <table style="margin-left: -3px;">
                                    <tr>
                                        <td><?php numberbox2('due_day', 48, 300);?> </td>
                                        <td> <?php getCaption('Hari'); ?></td>
                                        <td width="20"></td>
                                        <td>
                                            <table>
                                                <?php datebox('due_date', 'Tgl J. Tempo', 250); ?>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>

                        </tr>
                        <?php textbox('note', 'Keterangan', 285, 70); ?>
                        <tr><td width="100"></td></tr>

                    </table>
                </td>
                <td valign="top">
                    <table>
                        <?php datebox('cls2_date', 'Tgl Closed', 200); ?>
                        <?php textbox('cls2_by', 'Closed by', 90, 70); ?>
                        <tr><td width="100"></td></tr>
                    </table>
                </td>
            </tr>
        </table>
        <div class="easyui-tabs">
            <div title="<?php getCaption('Data Kendaraan'); ?>" class="main-tab">
                <table style="width:900px;" >
                    <tr>
                        <td valign="top"  width="400">
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
                                cmdStdopt('stdoptcode', 'Std. Optional');
                                ?>

                                <tr><td colspan="3"></td></tr>
                                <tr><td colspan="3"></td></tr> 
                                <tr><td colspan="3"></td></tr>
                                <tr><td colspan="3"></td></tr>
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
                                        <table style="margin-left: -5px;">
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
                                                            <td><input type="text" name="qty" id="qty" class="disabled" disabled="true" style="width: 30px;"></td>
                                                            <td><input type="text" name="unit" id="unit" class="disabled" disabled="true" style="width: 50px;"></td>
                                                            <td><input type="text" name="unit_price" class="easyui-numberbox" id="unit_price" data-options="precision:0,groupSeparator:',',decimalSeparator:'.'" disabled="true" style="width: 95px;"></td>
                                                            <td><input type="text" name="tot_price" class="easyui-numberbox" id="tot_price"  data-options="precision:0,groupSeparator:',',decimalSeparator:'.'" disabled="true" style="width: 95px;"></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td></td>
                                                <td>
                                                    <table>
                                                        <tr><td><?php getCaption("Perkiraan Stok"); ?></td></tr>
                                                        <tr><td><input class="easyui-datebox" validType='validDate' disabled="true" data-options="required:false" id="pred_stk_d"  name="pred_stk_d" style="width:120;" disabled="false"></td>  </tr>
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

            <div title="<?php getCaption('Dokumen'); ?>" class="main-tab">
                <table>
                    <td valign="top">
                        <table>
                            <tr>
                                <td colspan="2"></td>
                                <td><b><?php getCaption('Nomor'); ?></b></td>
                                <td><b><?php getCaption('Tanggal'); ?></b></td>
                            </tr>
                            <tr>
                                <td><?php getCaption('Surat Jalan'); ?></td>
                                <td class="td-ro">:</td>
                                <td><?php textbox2('sji_no', 150, 30); ?></td>
                                <td><?php datebox2('sji_date'); ?></td>
                            </tr>
                            <tr>
                                <td><?php getCaption('Kwitansi'); ?></td>
                                <td class="td-ro">:</td>
                                <td><?php textbox2('kwiti_no', 150, 30); ?></td>
                                <td><?php datebox2('kwiti_date'); ?></td>
                            </tr>
                            <tr>
                                <td><?php getCaption('Faktur Pajak'); ?></td>
                                <td class="td-ro">:</td>
                                <td><?php textbox2('fpi_no', 150, 30); ?></td>
                                <td><?php datebox2('fpi_date'); ?></td>
                            </tr>
                            <tr>
                                <td><?php getCaption('Debit Note'); ?></td>
                                <td class="td-ro">:</td>
                                <td><?php textbox2('dni_no', 200, 100); ?></td>
                                <td><?php datebox2('dni_date'); ?></td>
                            </tr>
                            <tr><td colspan="4"></td></tr> <tr><td colspan="4"></td></tr>
                            <tr>
                                <td><?php getCaption('DO'); ?></td>
                                <td class="td-ro">:</td>
                                <td><?php textbox2('do_no', 150, 30); ?></td>
                                <td><?php datebox2('do_date'); ?></td>
                            </tr>
                            <tr>
                                <td><?php getCaption('PDI'); ?></td>
                                <td class="td-ro">:</td>
                                <td><?php textbox2('pdi_no', 150, 30); ?></td>
                                <td><?php datebox2('pdi_date'); ?></td>
                            </tr>
                            <tr><td width="100"></td></tr>
                        </table>
                    </td>

                </table>
            </div>

            <div title="<?php getCaption('Harga Beli'); ?>" class="main-tab">
                <table>
                    <tr>
                        <td>
                            <table>
                                <tr>
                                    <td width="130"></td>
                                    <td class="td-ro"></td>
                                    <td style="text-align: right;"><b><?php getCaption("Base Price"); ?> </b></td>
                                    <td class="space2"></td>
                                    <td style="text-align: right;"><b><?php getCaption("Optional"); ?> </b></td>
                                    <td class="space2"></td>
                                    <td style="text-align: right;"><b><?php getCaption("Harga Total"); ?> </b></td>
                                </tr>
                                <tr>
                                    <td width="130"><?php getCaption("Harga"); ?></td>
                                    <td class="td-ro">:</td>
                                    <td><input onkeyup="sumBasePrice()" name="pur_base" id="pur_base" class="easyui-numberbox pricenumber" data-options="min: 0,precision:0,groupSeparator:',',decimalSeparator:'.'" disabled="true" style="width:130px;"></input></td>                              
                                    <td class="space2"></td>
                                    <td><input onkeyup="sumOptPrice()" name="pur_opt" id="pur_opt" class="easyui-numberbox pricenumber" data-options="min: 0,precision:0,groupSeparator:',',decimalSeparator:'.'" disabled="true" style="width:130px;"></input></td>
                                    <td class="space2"></td>
                                    <td><?php numberbox2('pur_bt', 130, 130); ?></td>
                                </tr>
                                <tr>
                                    <td width="130"><?php getCaption("PPN"); ?></td>
                                    <td class="td-ro">:</td>
                                    <td><?php numberbox2('pur_vat1', 130, 130); ?></td>
                                    <td class="space2"></td>
                                    <td><?php numberbox2('pur_vat2', 130, 130); ?></td>
                                    <td class="space2"></td>
                                    <td><?php numberbox2('pur_vat', 130, 130); ?></td>
                                </tr>
                                <tr>
                                    <td width="130"><?php getCaption("PBM"); ?></td>
                                    <td class="td-ro">:</td>
                                    <td><input onkeyup="sumBasePrice()" name="pur_pbm1" id="pur_pbm1" class="easyui-numberbox pricenumber" data-options="min: 0,precision:0,groupSeparator:',',decimalSeparator:'.'" disabled="true" style="width:130px;"></input></td>                                        
                                    <td class="space2"></td>
                                    <td><input onkeyup="sumOptPrice()" name="pur_pbm2" id="pur_pbm2" class="easyui-numberbox pricenumber" data-options="min: 0,precision:0,groupSeparator:',',decimalSeparator:'.'" disabled="true" style="width:130px;"></input></td>
                                    <td class="space2"></td>
                                    <td><?php numberbox2('pur_pbm', 130, 130); ?></td>
                                </tr>
                                <tr>
                                    <td width="130"><?php getCaption("PPH"); ?></td>
                                    <td class="td-ro">:</td>
                                   <td><input onkeyup="sumBasePrice()" name="pur_pph1" id="pur_pph1" class="easyui-numberbox pricenumber" data-options="min: 0,precision:0,groupSeparator:',',decimalSeparator:'.'" disabled="true" style="width:130px;"></input></td>                                        
                                    <td class="space2"></td>
                                    <td></td>
                                    <td class="space2"></td>
                                    <td><?php numberbox2('pur_pph', 130, 130); ?></td>
                                </tr>
                                <tr>
                                    <td width="130"><?php getCaption("Lain - lain"); ?></td>
                                    <td class="td-ro">:</td>
                                    <td><input onkeyup="sumBasePrice()" name="pur_misc1" id="pur_misc1" class="easyui-numberbox pricenumber" data-options="min: 0,precision:0,groupSeparator:',',decimalSeparator:'.'" disabled="true" style="width:130px;"></input></td>                                     
                                    <td class="space2"></td>
                                    <td><input onkeyup="sumOptPrice()" name="pur_misc2" id="pur_misc2" class="easyui-numberbox pricenumber" data-options="min: 0,precision:0,groupSeparator:',',decimalSeparator:'.'" disabled="true" style="width:130px;"></input></td>
                                    <td class="space2"></td>
                                    <td><?php numberbox2('pur_misc', 130, 130); ?></td>
                                </tr>
                                <tr>
                                    <td width="130"></td>
                                    <td class="td-ro"></td>
                                    <td><hr /></td>
                                    <td class="space2">+</td>
                                    <td><hr /></td>
                                    <td class="space2">+</td>
                                    <td><hr /></td>
                                    <td class="space2">+</td>
                                </tr>
                                <tr>
                                    <td width="130"><?php getCaption("Harga Beli"); ?></td>
                                    <td class="td-ro">:</td>
                                    <td><?php numberbox2('pur_price1', 130, 130); ?></td>
                                    <td class="space2"></td>
                                    <td><?php numberbox2('pur_price2', 130, 130); ?></td>
                                    <td class="space2"></td>
                                    <td><?php numberbox2('pur_price', 130, 130); ?></td>
                                    <td></td>
                                    <td><button type="button" id="cmdRefresh"  class="easyui-linkbutton" data-options="iconCls:'icon-reload'"  onclick="cmdRef()" title="Refresh" disabled="true"></button></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>

            <div title="<?php getCaption('Purchase Order'); ?>" class="main-tab">
                <table>
                    <td>
                        <table>
                            <?php
                            textbox('po_made_by', 'Pembuat', 150, 20);
                            textbox('po_appr_by', 'Disetujui', 150, 20);
                            textbox('po_desc', 'Keterangan', 200, 40);
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
                                    <button type="button" id="print" title="<?php getCaption("print"); ?>" class="easyui-linkbutton btn btn-default" data-options="iconCls:'icon-print'" onclick="rolesPrintScreen('print', 'pembelian');" disabled="true" >Print</button>
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

<div id="SearchOption" style="display:none;">  
    <form id="form_validation2" method="post" >    
        <div id="optionSPK" style="padding:10px;">
            <span><?php getCaption("No. Faktur"); ?>:</span>
            <input id="pur_inv_no2" name="pur_inv_no2">
            <span><?php getCaption("No. PO"); ?>:</span>
            <input type="text" id="no_po2" name="no_po2" style="width:103px;"/>
            <a href="#" class="easyui-linkbutton" onclick="doSearch()" iconCls="icon-search">Search</a>
            <button type="button"  title="<?php getCaption("Ok"); ?>" class="easyui-linkbutton easyui-tooltip btn btn-default" data-options="iconCls:'icon-ok'" onclick="getSearchselect()" >Ok </button>
            <button type="button" class="easyui-linkbutton easyui-tooltip btn btn-default" onclick="close_search();">Cancel</button>

        </div>

    </form>
</div>

<div id="sr" class="easyui-window" title="screen" data-options="closable:true,minimizable:false,maximizable:false,collapsible:false,closed:true,modal:true,closed:true,inline:true" style="width:1050px;height:500px;padding:10px;top:1;"></div>
<style>
     .space2{width: 15px !important;}
     .space3{width: 100px !important;}
</style>
<?php include 'pembelian_maindealer_fn.php'; ?>