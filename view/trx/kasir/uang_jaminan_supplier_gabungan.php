<?php $session = $_SESSION; ?>

<div style=" margin: 10px;" id="form_content">
    <form id="form_validation" method="post" >
        <div id="tableId"></div>
        <div class="single-form teen-margin">
            <table>
                <tr>
                    <td valign='top' width="535" >
                        <table style="margin-top: 25px;">
                            <tr>
                                <td valign='top'>
                                    <table class='marginmin'>
                                        <?php
                                        textbox('dp_inv_no', 'No. Faktur', 150, 150);
                                        cmdWrhs('wrhs_code', 'Warehouse');
                                        ?>
                                        <tr><td class='col100'></td></tr>
                                    </table>
                                </td>
                                <td valign='top'>
                                    <table class='marginmin'>
                                        <?php datebox('dp_date', 'Tgl. Faktur'); ?>
                                        <?php datebox('opn_date', 'Tgl. Buat') ?>
                                        <tr><td class='col100'></td></tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan='2' valign='top'>
                                    <table class='marginmin'>
                                        <tr>
                                            <td><?php getCaption("Supplier"); ?></td>
                                            <td class="td-ro">:</td>
                                            <td> 
                                                <table class='marginmin'>
                                                    <?php cmdSupp('supp_code', 'supp_name', '', 100, 252); ?>
                                                </table>
                                            </td>
                                        </tr>
                                        <?php textbox('note', 'Catatan', 356, 250); ?>
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
                                        <?php cmdBank('bank_code', 'Bank', $site_url, 90); ?>
                                        <?php textbox('check_no', 'No. Check', 130, 150) ?>
                                        <?php datebox('due_date', 'Tgl J. Tempo'); ?>
                                        <tr><td class='col100'></td></tr>
                                    </table>
                                </td>
                                <td valign='top'>
                                    <table class='marginmin'>
                                        <?php cmdPayType('pay_type', 'Jenis Bayar', $site_url); ?>
                                        <?php // cmdEDC('edc_code', 'Mesin EDC'); ?>
                                        <tr><td><span><br /></span></td></tr>
                                        <tr><td></td></tr>
                                        <?php datebox('check_date', "Tanggal Check"); ?>
                                        <?php // cmdCollector('coll_code', 'Kolektor', $site_url); ?>
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
            <table width="100%">
                <tr>
                    <td  valign="top">
                        <table>
                            <tr><td><?php numberbox2('tot_item', 50, 70); ?></td><td><?php getCaption('Item'); ?></td>
                            </tr></table>
                    </td>
                    <td valign="top" align="right">
                        <table>

                            <tr>
                                <td class="right">Total <?php getCaption("Pembayaran"); ?> : </td>
                                <td><?php numberbox2('tot_paid', 120, 15); ?></td>
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
                                    <button type="button" id="cmdSearch2" title="Search" data-options="iconCls:'icon-search',group:'g2'" class="easyui-linkbutton cmdSearch"  onclick="condSearch2()">Search2</button>
                                    <button type="button" id="cmdDetail"  class="easyui-linkbutton"  onclick="cmdDetails()" disabled="true">Detail</button>
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
<div id="DetailWindow" class="easyui-window" title="Booking Fee Suplier Group Payment" data-options="closable:true,minimizable:false,maximizable:false,collapsible:false,closed:true,modal:true,closed:true,inline:true" style="width:1120px;height:450px;padding:5px;top:1;">
    <div style="margin: 20px;">
        <table id="dt_apgd2" class="easyui-datagrid"  title="" style="width:1065px;height:200px;"></table>
        <br />
        <form id="form_validation2" method="post" >
            <div id="tableId2"></div>

            <table>
                <tr>
                    <td><?php getCaption("No. PO"); ?></td>
                    <td><?php getCaption("Tgl. PO"); ?></td>
                     <td><?php getCaption("Kode Kendaraan"); ?></td>
                    <td><?php getCaption("Nama Kendaraan"); ?></td>
                    <td><?php getCaption("Tahun"); ?></td>
                    <td><?php getCaption("Transmisi"); ?></td>
                     
                    <td><?php getCaption("Harga Kendaraan"); ?></td>
                    <td><?php getCaption("Pembayaran"); ?></td>

                </tr>
                <tr>
                    <td><table class="marginmin"><?php cmdponew('po_no', '', $site_url, 110, 'cls'); ?></table></td>
                    <td><?php datebox2('po_date', 100); ?></td>
                     <td><?php textbox2('veh_code', 80, 100); ?></td>
                     <td><?php textbox2('veh_name', 250, 100); ?></td>
                  
                     <td><?php textbox2('veh_year', 50, 100); ?></td>
                     <td><?php textbox2('veh_transm', 80, 100); ?></td>
                    <td><?php numberbox2('veh_price', 110, 17); ?></td>
                    <td><?php numberbox2('dp_paid', 110, 17); ?></td>
                  
                </tr>
                
                <tr>
                    <td colspan="2"></td>
                     <td><?php getCaption("Kode Warna"); ?></td>
                    <td><?php getCaption("Nama Warna"); ?></td>

                </tr>
                <tr>
                     <td colspan="2"></td>
                    <td><?php textbox2('color_code', 80, 100); ?></td>
                       <td><?php textbox2('color_name', 250, 100); ?></td>
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
                                    <button type="button" id="ok2" class="easyui-linkbutton" data-options="iconCls:'icon-ok'" onclick="$('#DetailWindow').window('close');"></button>
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

<?php include 'uang_jaminan_supplier_gabungan_fn.php'; ?>
