
<div style=" margin: 10px;" id="form_content">
    <form id="form_validation" method="post" >
        <div id="tableId"></div>

        <table class="main-form">
            <tr>
                <td valign="top" width="500">
                    <table>
                        <tr>
                            <td></td>
                            <td></td>
                            <td colspan="3">
                                <table>
                                    <tr>
                                        <td><br /></td>
                                        <td ><br /></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <?php textbox('mov_inv_no', 'No. Faktur', 150, 250); ?>
                        <?php datebox('mov_date', 'Tgl. Faktur', 100); ?>
                        <?php datebox('opn_date', 'Tgl. Buat', 100); ?>
                        <tr><td width="85"></td></tr>
                    </table>
                </td>
                <td valign="top">
                    <table>

                        <tr>
                            <td></td>
                            <td></td>
                            <td colspan="3">
                                <table>
                                    <tr>
                                        <td width="100"><b><?php getCaption("Kode"); ?>:</b></td>
                                        <td width="220"><b><?php getCaption("Nama"); ?>:</b></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <?php/// cmdSupp('supp_code', 'supp_name', 'Yang Memindahkan', 105, 240) ?>
                         <?php cmdMstMover('mvrep_code', 'mvrep_name', 'Yang Memindahkan', 105, 240); ?>
                        <tr>
                            <td></td>
                            <td></td>
                            <td colspan="3">
                                <table>
                                    <tr>
                                        <td width="120"><b><?php getCaption("Warehouse"); ?>:</b></td>
                                        <td width="120"><b><?php getCaption("Lokasi"); ?>:</b></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td class="labels"><?php getCaption("Dari"); ?></td>
                            <td class="td-ro">:</td>
                            <td colspan="3">
                                <table class="marginmin">
                                    <tr>
                                        <td width="120"><table class="marginmin"><?php cmdWrhs('wrhs_from', ''); ?></table></td>
                                        <td width="120"><table class="marginmin"><?php cmdLoc('loc_from', '',120,0,0); ?></table></td>
                                    </tr>
                                </table>

                            </td>
                        </tr>
                        <tr>
                            <td class="labels">To</td>
                            <td class="td-ro">:</td>
                            <td colspan="3">
                                <table class="marginmin">
                                    <tr>
                                        <td width="120"><table class="marginmin"><?php cmdWrhs('wrhs_to', ''); ?></table></td>
                                        <td width="120"><table class="marginmin"><?php cmdLoc('loc_to', '',120,0,0); ?></table></td>
                                    </tr>
                                </table>

                            </td>
                        </tr>
                        
                          <?php textbox('note', 'Catatan', 345, 250); ?>
                        <?php datebox('cls_date', 'Tgl Closed', 200); ?>
                      
                          <tr><td width="85"></td></tr>
                    </table>
                </td>
            </tr>
        </table>
        <div class="easyui-tabs" id="tabscoi" >
            <div title="<?php getCaption('Data Kendaraan'); ?>"  class="main-tab">
                <table>
                    <tr>
                        <td valign="top">
                            <table class="table"  >
                                <tr>
                                    <td width="85"></td>
                                    <td></td>
                                    <td colspan="3">
                                        <table>
                                            <tr>
                                                <td width="100"><b><?php getCaption("Kode"); ?>:</b></td>
                                                <td width="220"><b><?php getCaption("Nama"); ?>:</b></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="labels"><?php getCaption("Kendaraan"); ?></td>
                                    <td class="td-ro">:</td>
                                    <td colspan="3">
                                        <table style="margin-left: -2px;">
                                            <tr>
                                                <td width="100"><input type="text" name="veh_code" id="veh_code" disabled="true" style="width:100px;"></td>
                                                <td width="220"> <input type="text" name="veh_name" id="veh_name" disabled="true" style="width:284px;"></td>
                                            </tr>
                                        </table>

                                    </td>
                                </tr>
                                <tr>
                                    <td ><?php getCaption("Chassis"); ?></td>
                                    <td class="td-ro">:</td>
                                    <td width="181"><table class="marginmin"><?php cmdstkMove('chassis', '',$site_url);?></table></td>
                                    <td><?php getCaption("Tipe"); ?>:</td>
                                    <td><input type="text" name="veh_type" id="veh_type" disabled="true" style="width:160px;"></td>
                                </tr>
                                <tr>
                                    <td ><?php getCaption("Engine"); ?></td>
                                    <td class="td-ro">:</td>
                                    <td width="181"><input type="text" name="engine" id="engine" disabled="true" style="width: 160px;"></td>
                                    <td><?php getCaption("Model"); ?>:</td>
                                    <td><input type="text" name="veh_model" id="veh_model" disabled="true" style="width:160px;"></td>
                                </tr>

                                <tr><td><br /></td></tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td colspan="3">
                                        <table>
                                            <tr>
                                                <td width="100"><b><?php getCaption("Kode"); ?>:</b></td>
                                                <td width="220"><b><?php getCaption("Nama"); ?>:</b></td>
                                                <td width="60"><b><?php getCaption("Tipe"); ?>:</b></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                                <tr>
                                    <td><?php getCaption("Warna"); ?></td>
                                    <td class="td-ro" valign="center">:</td>
                                    <td colspan="3">
                                        <table  style="margin-left: -2px;">

                                            <tr>
                                                <td><input type="text" name="color_code" id="color_code" disabled="true" style="width:100px;"></td>
                                                <td><input type="text" name="color_name" id="color_name" disabled="true" style="width:219px;"></td>
                                                <td><input type="text" name="color_type" id="color_type" disabled="true" style="width:60px;"></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr><td><br /></td></tr>
                             
                            </table>
                        </td>

                        <td valign="top">
                            <table class="table" style="width:200px !important;">
                                <tr>
                                    <td width="85"></td>
                                    <td></td>
                                    <td colspan="3">
                                        <table>
                                            <tr>
                                                <td width="100"><br /></td>
                                                <td width="220"></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <?php
                                textbox('veh_brand', 'Merek', 80, 200);
                                textbox('veh_transm', 'Transmisi', 40, 200);
                                textbox('veh_year', 'Tahun', 60, 4);
                                ?>
                            </table>
                        </td>
                        <td valign="top">
                            <table>
                                <tr>
                                    <td width="120"></td>
                                    <td></td>
                                    <td colspan="3">
                                        <table>
                                            <tr>
                                                <td width="100"><br /></td>
                                                <td width="220"></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                 <?php
                                textbox('alarm', 'Alarm', 100, 10);
                                textbox('key_no', 'No. Kunci', 100, 10);
                                textbox('serv_book', 'Buku Service', 100, 10);
                                textbox('veh_reg_no', 'No. Polisi', 100, 70);
                                ?>
                            </table>
                        </td>

                    </tr>
                </table>
            </div>
            <div title="<?php getCaption('Dokumen Pembelian'); ?>"  class="main-tab">
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
                                <td><?php getCaption('DO'); ?></td>
                                <td class="td-ro">:</td>
                                <td><?php textbox2('do_no', 150, 30); ?></td>
                                <td><?php datebox2('do_date'); ?></td>
                            </tr>
                            <tr>
                                <td><?php getCaption('No. Faktur Beli'); ?></td>
                                <td class="td-ro">:</td>
                                <td><?php textbox2('pur_inv_no', 150, 30); ?></td>
                                <td><?php datebox2('pur_date'); ?></td>
                            </tr>
                            <tr><td width="100"></td></tr>
                        </table>
                    </td>

                </table>
            </div> 
            <div title="<?php getCaption('Harga'); ?>" class="main-tab" data-options="disabled:true,disable:true" disabled="true">
                <table>
                    <tr>
                        <td>
                            <table style="margin:0px 0cm 0cm 0cm; ">
                                <?php
                                numberbox('pr2b_price', 'Base Price', 150, 12);
                                numberbox('pr2o_price', 'Optional Price', 150, 12);


                                numberbox('pr2_vat', 'PPN', 150, 12);
                                ?>
                                <tr><td colspan="3"></td></tr>

                                <?php
                                numberbox('pr2_pbm', 'PBM', 150, 70);
                                numberbox('pr2_pph', 'PPH', 150, 70);
                                numberbox('pr2_misc', 'Lain - Lain', 150, 70);
                                ?>
                                <tr><td></td><td class="td-ro"></td><td style="text-align:right;"><hr /></td><td><b>+</b></td></tr>
                                <?php
                                numberbox('pr2_price', 'Harga Beli', 150, 12);
                                ?>
                                <tr><td width="100"></td></tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="main-nav">
            <table width="100%">
                <tr>
                    <td width="400"><?php navigation_ci(); ?></td>
                    <td width="400">
                        <table border="0">
                            <tr>

                                <td  style="border-top:0px !important;">
                                    <!--<button type="button" id="cmdDetail"  class="easyui-linkbutton"  onclick="cmdDetails()" disabled="true">Detail</button>-->
                                    <span id="closeOn"></span>
                                    <button type="button" id="screen" title="<?php getCaption("Screen Faktur"); ?>" class="easyui-linkbutton" data-options="iconCls:'icon-screen'" onclick="rolesPrintScreen('screen');" disabled="true" >Screen</button>
                                    <button type="button" id="print" title="<?php getCaption("Print Faktur"); ?>" class="easyui-linkbutton" data-options="iconCls:'icon-print'" onclick="rolesPrintScreen('print');" disabled="true" >Print</button>
                                    <!--<button type="button" id="download" title="<?php getCaption("Download Faktur"); ?>" class="easyui-linkbutton" data-options="iconCls:'icon-download'"  onclick="rolesPrintScreen('download');" disabled="true" >Download</button>-->
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

<div id="sr" class="easyui-window" title="screen" data-options="closable:true,minimizable:false,maximizable:false,collapsible:false,closed:true,modal:true,closed:true,inline:true" style="width:1050px;height:500px;padding:10px;top:1;"></div>

<?php include 'pemindahan_fn.php'; ?>
<?php 
if($groupmain !== 'MDLR'){
 ?>
<script>
$(document).ready(function(){
    $('#tabscoi').tabs('disableTab',2);
})
</script>
<?php
}
?>