<?php $session = $_SESSION; ?>
<div style="margin: 10px;" id="form_content">
    <form id="form_validation" method="post" >
        <div id="tableId"></div>
        <div class="single-form teen-margin">
            <table>
                <tr>
                    <td width="480" valign="top">
                        <table>
                            <?php
                            textbox('pur_inv_no', 'No. Faktur', 145, 12);
                            datebox('pur_date', 'Tgl. Faktur', 200);
                            datebox('stk_date', 'Tgl. Stock', 200);
                            datebox('due_date', 'Jatuh Tempo', 200);
                            cmdWrhs('wrhs_code', 'Warehouse');
                            ?>
                            <tr><td class="col100"></td></tr>
                        </table>
                    </td>
                    <td valign="top">
                        <table>
                            <?php textboxset('supp_code', 'supp_name', 'Supplier', 80, 256); ?>
                            <tr>
                                <td><?php getCaption("No. Faktur Supplier"); ?></td>
                                <td class="td-ro">:</td>
                                <td>
                                    <table  class="marginmin">
                                        <tr>
                                            <td><?php textbox2('supp_invno', 100, 12); ?></td>
                                            <td width="134"><?php getCaption("Tgl. Faktur Supplier"); ?></td>
                                            <td class="td-ro">:</td>
                                            <td><?php datebox2('supp_invdt'); ?></td>
                                        </tr>
                                    </table>
                                </td>

                            </tr>
                            <tr>
                                <td><?php getCaption("No. PO"); ?></td>
                                <td class="td-ro">:</td>
                                <td>
                                    <table class="marginmin">
                                        <tr>
                                            <td><?php textbox2('po_no', 100, 12); ?></td>
                                            <td width="134"><?php getCaption("Tgl. PO"); ?></td>
                                            <td class="td-ro">:</td>
                                            <td align="right"><?php datebox2('po_date'); ?></td>
                                        </tr>
                                    </table>
                                </td>

                            </tr>
                            <tr><td colspan="3"></td></tr>
                            <tr><td colspan="3"></td></tr>
                            <?php textbox('note', 'Keterangan', 340, 12); ?>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
        <div class="single-form" style="padding: 10px;">
            <table id="dt_ard" class="easyui-datagrid"  title="" style="width:1080px;height:200px;"></table>

            <table width="100%" style="margin-top:10px;" >
                <tr>
                    <td>
                        <table style="margin-top: -35px;">
                            <?php
                            textboxset('color_code', 'color_name', 'Warna', 80, 256);
                            textboxset('veh_code', 'veh_name', 'Kendaraan', 80, 256);
                            textbox('chassis', 'Chassis', 150, 17);
                            textbox('engine', 'Engine', 150, 13);
                            ?>
                        </table>
                    </td>

                    <td align="right">

                        <table class="table" >
                            <?php
                            numberbox('inv_total', 'Total Faktur', 200, 70);
                            numberbox('hd_begin', 'Hutang Awal', 200, 70);

                            numberbox('hd_paid', 'Pembayaran', 200, 70);
                            numberbox('hd_disc', 'Diskon', 200, 70);
                            ?>
                            <tr><td></td><td class='td-ro'></td><td style="text-align:right;"><hr /></td><td><b>-</b></td></tr>
                            <?php
                            numberbox('hd_end', 'Hutang Akhir', 200, 70);
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
                    <td width="100">
                        <table border="0">
                            <tr>
                                <td  style="border-top:0px !important;">
                                    <button type="button" id="bayar" title="<?php getCaption("Bayar"); ?>" class="bayar easyui-linkbutton"  onclick="bayarHutang();" data-options="iconCls:'icon-payment'">Bayar</button>
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

<div id="BayarWindow" class="easyui-window" title="Vehicle Account Payable Payment"  data-options="modal:true,closed:true,resizable:false,maximizable:true,minimizable:false,collapsible:false" 
     style="width:1050px;height:450px;padding:10px;top:1;">
    <table id="dt_ard2" class="easyui-datagrid"  title="" style="width:1020px;height:200px;"></table><br />

    <table style="float: right;">
        <tr>
            <td><b>Total <?php getCaption("Pembayaran"); ?></b></td>
            <td class="td-ro">:</td>
            <td><?php numberbox2('hd_paid2', 95, 100); ?></td>
            <td><b>Total <?php getCaption("Diskon"); ?></b></td>
            <td class="td-ro">:</td>
            <td><?php numberbox2('hd_disc2', 95, 100); ?></td>
        </tr>
    </table>
    <br /><br /><br />
    <form id="form_validation3" method="post" >
        <div id="tableId2"></div>
        <table>
            <tr>
                <td><?php getCaption("Tgl. Bayar"); ?></td>
                <td><?php getCaption("Jenis Bayar"); ?></td>
                <td><?php getCaption("No. Check"); ?></td>
                <td><?php getCaption("Tanggal Check"); ?></td>
                <td><?php getCaption("Tgl J. Tempo"); ?></td>
                <td><?php getCaption("Pembayaran"); ?></td>
                <td><?php getCaption("Diskon"); ?></td>
                <td><?php getCaption("Keterangan"); ?></td>
                <td><?php getCaption("Kolektor"); ?></td>
            </tr>
            <tr>
                <td><?php datebox2('pay_date'); ?> </td>
                <td>
                    <select class="easyui-combobox" id="pay_type" name="pay_type" style="width: 100px;" disabled="true"><option value=""></option><option value="TRANS">TRANS</option><option value="CASH">CASH</select>
                </td>
                <td><?php textbox2('check_no', 120, 200); ?> </td>
                <td><?php datebox2('check_date'); ?> </td>
                <td><?php datebox2('due_date'); ?> </td>
                <td><?php numberbox2('pay_val', 90, 100); ?> </td>
                <td><?php numberbox2('disc_val', 90, 100); ?> </td>
                <td><?php textbox2('pay_desc', 220, 200); ?> </td>               
                <td><?php textbox2('coll_code', 90, 200); ?> </td>
            </tr>
        </table>



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
                            </td>
                            <td  style="border-top:0px !important;">
                                <button type="button" id="prepaid" title="<?php getCaption("prepaid"); ?>" class="easyui-linkbutton" onclick="prepaids();" data-options="iconCls:'icon-payment'" >Prepaid</button>
                                <button id="ok" type="button" class="easyui-linkbutton" data-options="iconCls:'icon-ok'" onclick="$('#BayarWindow').window('close');"></button>

                            </td>

                        </tr>
                    </table>  </td>       
            </tr>
        </table>

    </form>
</div>

<div id="UJWindow" class="easyui-window" title="<?php getCaption("Uang Jaminan"); ?> Supplier" data-options="closable:true,minimizable:false,maximizable:false,collapsible:false,closed:true,modal:true,closed:true,inline:true" style="width:724px;height:320px;padding:10px;top:1;">
    <table id="dt_uj" class="easyui-datagrid"  title="" style="width:690px;height:200px;"></table>
    <br />
    <div class="main-nav">
        <table width="100%">
            <tr>
                <td align="right">
                    <button type="button" id="getUJ" title="<?php getCaption("Get Uang Jaminan"); ?>" class="easyui-linkbutton" onclick="getUJaminan();" data-options="iconCls:'icon-ok'" style="width:70px;" >Get</button>
                    <button id="ok" type="button" class="easyui-linkbutton" onclick="$('#UJWindow').window('close');" data-options="iconCls:'icon-no'" style="width:70px;">Cancel</button>
                </td>
            </tr>
        </table>
    </div>
</div>


<div id="screenWindow" class="easyui-window" title="Screen" data-options="closable:true,minimizable:false,maximizable:false,collapsible:false,closed:true,modal:true,closed:true,inline:true" style="width:1050px;height:500px;padding:10px;top:1;"></div>

<?php include 'hutangkendaraan_fn.php'; ?>

