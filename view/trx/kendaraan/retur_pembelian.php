<div style=" margin: 10px;" id="form_content">
    <form id="form_validation" method="post" >
        <div id="tableId"></div>
        <div id="results"></div>

        <table class="main-form">
            <tr>
                <td valign="top">
                    <table>
                        <?php textbox('rpr_inv_no', 'No. Faktur', 90, 70); ?>
                        <?php datebox('rpr_date', 'Tgl. Faktur', 250); ?>
                        <tr>
                            <td><?php getCaption('No. Faktur Beli');?></td>
                            <td class="td-ro">:</td>
                            <td>
                                <table style="margin-left: -3px;float:left">
                                    <tr>
                                        <td><?php textbox2('pur_inv_no', 120, 120);?></td>
                                        <td><button type="button" id="cmdDeletePRH" title="Delete Faktur" class="easyui-linkbutton cmdDeletePRH" data-options="iconCls:'icon-no'"  onclick="condDeletePRH()" ></button></td>
                                        <td><button type="button" id="cmdSearchPRH" title="Search Faktur" class="easyui-linkbutton cmdSearchPRH" data-options="iconCls:'icon-search'"  onclick="condFindPRH()" ></button></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <?php // cmdprhClose('pur_inv_no', 'No. Faktur Beli', $site_url); ?>
                        <?php datebox('pur_date', 'Tgl. Faktur Beli', 200); ?>
                        <tr><td class="col130"></td></tr>
                    </table>
                </td>
                <td valign="top" >
                    <table >
                        <?php
                        textbox('wrhs_code', 'Warehouse', 200, 50);
                        ?>
                        <tr>
                            <td><?php getCaption('Aging Dalam');?></td>
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
                        datebox('due_date', 'Tgl. Aging', 200);
                       
                        ?>
                        <tr><td class="col130"></td></tr>
                    </table>
                </td>
                <td valign="top" >
                      <table>
                    <?php                  
                    datebox('cls_date', 'Tgl Closed');
                    textbox('cls_by', 'Closed By', 90, 70);
                    textbox('note', 'Keterangan', 200, 3);
                    ?>
                    </table>
                </td>
            </tr>
        </table>

        <div class="easyui-tabs">
            <div title="<?php getCaption('Kendaraan'); ?>"  class="main-tab">
                <table class="table" >
                    <tr>
                        <td valign="top" width="450">
                            <table>
                                <?php
                                textboxset('veh_code', 'veh_name', 'Kendaraan', 80, 200);
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

                                <tr><td colspan="3"></td></tr>
                                <tr><td colspan="3"></td></tr> 
                                <tr><td colspan="3"></td></tr>
                                <tr><td colspan="3"></td></tr>
                                <tr><td class="col130"></td></tr>
                            </table>
                        </td>
                        <td></td>
                        <td valign="top">
                            <table>
                                <?php
                                textboxset('color_code', 'color_name', 'Warna', 80, 250);
                                textbox('color_type', 'Tipe', 40, 10);
                                ?>
                                <tr><td colspan="3"></td></tr>
                                <tr><td colspan="3"></td></tr> 
                                <?php
                                textbox('alarm', 'Alarm', 100, 10);
                                textbox('key_no', 'No. Kunci', 100, 10);
                                textbox('serv_book', 'Buku Service', 100, 10);
                                ?>
                                <tr><td class="col130"></td></tr>
                                <tr><td colspan="3"></td></tr>
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
                                                            <td class='right'><?php getCaption("Harga Satuan"); ?></td>
                                                            <td class='right'><?php getCaption("Harga Kendaraan"); ?></td>

                                                        </tr>
                                                        <tr>

                                                            <td><?php textbox2('qty', 30, 30);?></td>
                                                            <td><?php textbox2('unit', 50, 50);?></td>

                                                            <td><?php numberbox2('unit_price', 95, 25);?></td>
                                                            <td><?php numberbox2('tot_price', 95, 25);?></td>

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
            <div title="<?php getCaption('Dokumen Pembelian'); ?>"  class="main-tab">

                <table>
                    <tr>
                        <td valign="top" width="450">
                            <table>
                                <tr><td colspan="2"></td><td><b><?php getCaption('kendaraan');?></b></td></tr>
                                <?php
                                textbox('supp_name', 'Supplier', 250, 3);
                                textbox('supp_npwp', 'NPWP', 150, 3);
                                textbox('supp_pkp', 'PKP', 150, 3);
                                ?>
                                <input type="hidden" id="supp_code" name="supp_code">
                                <td class="col130"></td>
                            </table>
                        </td>
                        <td valign="top">
                            <table>
                                <tr><td><b><?php getCaption('Optional') ?></b></td></tr>
                                <tr>
                                    <td>
                                        <table style="margin: -2 -3;">
                                            <td>
                                                <input autocomplete="off" class="easyui-validatebox textbox" type="text" id="supp2_code" name="supp2_code" style="width:100px;" disabled=true></input>
                                            </td>
                                            <td>
                                                <input autocomplete="off" class="easyui-validatebox textbox" type="text" id="supp2_name" name="supp2_name" style="width:220px;" disabled=true></input>
                                            </td>
                                        </table>
                                    </td>
                                </tr>
                                <tr><td> <input autocomplete="off" class="easyui-validatebox textbox" type="text" id="supp2_npwp" name="supp2_npwp" style="width:150px;" disabled=true></input></td></tr>
                                <tr><td> <input autocomplete="off" class="easyui-validatebox textbox" type="text" id="supp2_pkp" name="supp2_pkp" style="width:150px;" disabled=true></input></td></tr>
                            </table>
                        </td>
                    </tr>
                    <tr><td></td></tr>
                    <tr>
                        <td>
                            <table>
                                <tr>
                                   <td class="col130"></td>
                                    <td></td>
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
                            </table>
                        </td>

                        <td>
                            <table style="margin-top: -45px;margin-left: 35px;">
                                <tr>
                                    <td colspan="2"></td>
                                    <td><b><?php getCaption('Nomor'); ?></b></td>
                                    <td><b><?php getCaption('Tanggal'); ?></b></td>
                                </tr>
                                <tr>
                                    <td>SJ</td>
                                    <td class="td-ro">:</td>
                                    <td><?php textbox2('sji2_no', 150, 30); ?></td>
                                    <td><?php datebox2('sji2_date'); ?></td>
                                </tr>
                                <tr>
                                    <td>KW</td>
                                    <td class="td-ro">:</td>
                                    <td><?php textbox2('kwiti2_no', 150, 30); ?></td>
                                    <td><?php datebox2('kwiti2date'); ?></td>
                                </tr>
                                <tr>
                                    <td>FP</td>
                                    <td class="td-ro">:</td>
                                    <td><?php textbox2('fpi2_no', 150, 30); ?></td>
                                    <td><?php datebox2('fpi2_date'); ?></td>
                                </tr>
                                <tr>
                                    <td>DN</td>
                                    <td class="td-ro">:</td>
                                    <td><?php textbox2('dni2_no', 200, 100); ?></td>
                                    <td><?php datebox2('dni2_date'); ?></td>
                                </tr>
                                <tr><td colspan="4"></td></tr> <tr><td colspan="4"></td></tr>
                                <tr><td colspan="4"></td></tr> <tr><td colspan="4"></td></tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>

            <div title="<?php getCaption('Perincian Harga Beli'); ?>"  class="main-tab">
                <table>
                    <td valign="top" width="650">
                        <table>
                            <tr>
                                <td colspan="2"></td>
                                <td class='right'><b>Base Price</b></td>
                                <td></td>
                                <td class='right'><b>Optional Price</b></td>
                                <td></td>
                                <td class='right'><b>Total Price</b></td>
                            </tr>
                            <tr>
                                <td><?php getCaption('Harga'); ?></td>
                                <td class="td-ro">:</td>
                                <td><input type="text" name="pur_base" id="pur_base" class="easyui-numberbox" data-options="precision:0,groupSeparator:',',decimalSeparator:'.'" disabled="true" style="width: 115px;"></td>
                                <td width="30"></td>
                                <td><input type="text" name="pur_opt" id="pur_opt" class="easyui-numberbox" data-options="precision:0,groupSeparator:',',decimalSeparator:'.'" disabled="true" style="width: 115px;"></td>
                                <td width="30"></td>
                                <td><input type="text" name="pur_bt" id="pur_bt" class="easyui-numberbox" data-options="precision:0,groupSeparator:',',decimalSeparator:'.'" disabled="true" style="width: 115px;"></td>
                            </tr>
                            <tr>
                                <td><?php getCaption('PPN'); ?></td>
                                <td class="td-ro">:</td>
                                <td><input type="text" name="pur_vat" id="pur_vat" class="easyui-numberbox" data-options="precision:0,groupSeparator:',',decimalSeparator:'.'" disabled="true" style="width: 115px;"></td>
                                <td></td>
                                <td><input type="text" name="pur_vat2" id="pur_vat2" class="easyui-numberbox" data-options="precision:0,groupSeparator:',',decimalSeparator:'.'" disabled="true" style="width: 115px;"></td>
                                <td></td>
                                <td><input type="text" name="pur_vat1" id="pur_vat1" class="easyui-numberbox" data-options="precision:0,groupSeparator:',',decimalSeparator:'.'" disabled="true" style="width: 115px;"></td>
                            </tr>
                            <tr>
                                <td><?php getCaption('PBM'); ?></td>
                                <td class="td-ro">:</td>
                                <td><input type="text" name="pur_pbm" id="pur_pbm" class="easyui-numberbox" data-options="precision:0,groupSeparator:',',decimalSeparator:'.'" disabled="true" style="width: 115px;"></td>
                                <td></td>
                                <td><input type="text" name="pur_pbm2" id="pur_pbm2" class="easyui-numberbox" data-options="precision:0,groupSeparator:',',decimalSeparator:'.'" disabled="true" style="width: 115px;"></td>
                                <td></td>
                                <td><input type="text" name="pur_pbm1" id="pur_pbm1" class="easyui-numberbox" data-options="precision:0,groupSeparator:',',decimalSeparator:'.'" disabled="true" style="width: 115px;"></td>
                            </tr>
                            <tr>
                                <td><?php getCaption('PPH'); ?></td>
                                <td class="td-ro">:</td>
                                <td><input type="text" name="pur_pph" id="pur_pph" class="easyui-numberbox" data-options="precision:0,groupSeparator:',',decimalSeparator:'.'" disabled="true" style="width: 115px;"></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><input type="text" name="pur_pph1" id="pur_pph1" class="easyui-numberbox" data-options="precision:0,groupSeparator:',',decimalSeparator:'.'" disabled="true" style="width: 115px;"></td>
                            </tr>
                            <tr>
                                <td><?php getCaption('Lain - lain'); ?></td>
                                <td class="td-ro">:</td>
                                <td><input type="text" name="pur_misc" id="pur_misc" class="easyui-numberbox" data-options="precision:0,groupSeparator:',',decimalSeparator:'.'" disabled="true" style="width: 115px;"></td>
                                <td></td>
                                <td><input type="text" name="pur_misc2" id="pur_misc2" class="easyui-numberbox" data-options="precision:0,groupSeparator:',',decimalSeparator:'.'" disabled="true" style="width: 115px;"></td>
                                <td></td>
                                <td><input type="text" name="pur_misc1" id="pur_misc1" class="easyui-numberbox" data-options="precision:0,groupSeparator:',',decimalSeparator:'.'" disabled="true" style="width: 115px;"></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td class="td-ro"></td>
                                <td><hr /></td>
                                <td>+</td>
                                <td><hr /></td>
                                <td>+</td>
                                <td><hr /></td>
                                <td>+</td>
                            </tr>
                            <tr>
                                <td><?php getCaption('Harga Beli'); ?></td>
                                <td class="td-ro">:</td>
                                <td><input type="text" name="pur_price" id="pur_price" class="easyui-numberbox" data-options="precision:0,groupSeparator:',',decimalSeparator:'.'" disabled="true" style="width: 115px;"></td>
                                <td></td>
                                <td><input type="text" name="pur_price2" id="pur_price2" class="easyui-numberbox" data-options="precision:0,groupSeparator:',',decimalSeparator:'.'" disabled="true" style="width: 115px;"></td>
                                <td></td>
                                <td><input type="text" name="pur_price1" id="pur_price1" class="easyui-numberbox" data-options="precision:0,groupSeparator:',',decimalSeparator:'.'" disabled="true" style="width: 115px;"></td>
                            </tr>
                        </table>
                    </td>
                </table>
            </div>

            <div title="<?php getCaption('Purchase Order'); ?>"  class="main-tab">
                <table>
                    <td valign="top">
                        <table>
                            <?php
                            textbox('po_made_by', 'Pembuat', 150, 20);
                            textbox('po_appr_by', 'Disetujui', 150, 20);
                            textbox('po_desc', 'Keterangan', 200, 40);
                            ?>
                            <tr><td class="col130"></td></tr>
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
            <span><?php getCaption("Faktur Retur"); ?>:</span>
            <input id="rpr_inv_no" name="rpr_inv_no">
            <span><?php getCaption("No. Faktur Beli"); ?>:</span>
            <input id="pur_inv_no" name="pur_inv_no" >
            <a href="#" class="easyui-linkbutton" onclick="doSearch()" iconCls="icon-search">Search</a>
            <button type="button"  title="<?php getCaption("Ok"); ?>" class="easyui-linkbutton easyui-tooltip btn btn-default" data-options="iconCls:'icon-ok'" onclick="getSearchselect()" >Ok </button>
            <button type="button" class="easyui-linkbutton easyui-tooltip btn btn-default" onclick="close_search();">Cancel</button>

        </div>

    </form>
</div>
<?php include 'retur_pembelian_fn.php'; ?>
