<?php $session = $_SESSION; ?>
<div style=" margin: 10px;" id="form_content">
    <form id="form_validation" method="post" >
        <div id="tableId"></div>
        <div class="single-form teen-margin">
            <table>
                <td valign="top">
                    <table>
                        <?php
                        textbox('sal_inv_no', 'No. Faktur Jual', 90, 20);
                        datebox('sal_date', 'Tgl. Faktur Jual', 200);
                        textbox('so_no', 'No. SPK', 90, 20);
                        datebox('so_date', 'Tanggal SPK', 200);
                        textboxset('srep_code', 'srep_name', 'Nama Sales',  90, 265);
                        textbox('wrhs_code', 'Warehouse', 90, 20); 
                        ?>
                        <tr><td class="col120"></td></tr>
                    </table>
                </td>
                <td valign="top">
                    <table>
                        <?php
                            textbox('pay2_name', 'Perantara', 360, 360);
                            textbox('pay2_addr', 'Alamat', 360, 360);
                            textboxset('cust_code', 'cust_name', 'Pelanggan', 80, 275);
                        ?>
                        <tr>
                            <td><?php echo getCaption('Tipe');?></td>
                            <td>:</td>
                            <td>
                                <table class="marginmin">
                                    <tr>
                                        <td><?php textbox2('veh_type', 100, 100) ?></td>
                                        <td><?php echo getCaption('Tahun');?></td>
                                        <td class="td-ro">:</td>
                                        <td><?php textbox2('veh_year', 50, 100) ?></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <?php  textbox('color_name', 'Warna', 300, 300);?>
                        <tr>
                            <td><?php echo getCaption('Chassis');?></td>
                            <td>:</td>
                            <td>
                                <table class="marginmin">
                                    <tr>
                                        <td><?php textbox2('chassis', 150, 100) ?></td>
                                        <td><?php echo getCaption('Engine');?></td>
                                        <td class="td-ro">:</td>
                                        <td><?php textbox2('engine', 150, 100) ?></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <?php  textbox('note', 'Keterangan', 360, 20); ?>
                         <tr><td class="col80"></td></tr>
                    </table>
                </td>

            </table>
        </div>

        <div class="single-form">
            <table id="dt" class="easyui-datagrid"  title="" style="width:1080px;height:150px;"></table>
            <br />
            <table width="100%">
                <tr>
                    <td valign="top">

                    </td>
                    <td align="right">

                        <table class="table" >
                            <?php
                            numberbox('hd_begin', 'Hutang Awal', 200, 70);
                            numberbox('hd_paid', 'Pembayaran', 200, 70);
                            numberbox('hd_disc', 'Diskon', 200, 70);
                            numberbox('hd_pph', 'pph', 200, 70);
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
<div id="BayarWindow" class="easyui-window" title="Commission Payable Payment"  data-options="modal:true,closed:true,resizable:false,maximizable:true,minimizable:false,collapsible:false" 
     style="width:1070px;height:450px;padding:10px;top:1;">
    <table id="dt2" class="easyui-datagrid"  title="" style="width:1035px;height:200px;"></table><br />

    <table style="float: right;">
        <tr>
            <td><b>Total</b></td>
            <td class="td-ro">:</td>
            <td><?php numberbox2('hd_paid2', 120, 100); ?></td>
            <td><?php numberbox2('hd_disc2', 120, 100); ?></td>
            <td><?php numberbox2('hd_pph2', 120, 100); ?></td>
        </tr>
    </table>
    <br /> <br /><br />
    <form id="form_validation3" method="post" >
        <div id="tableId2"></div>
        <table>
            <tr>
                <td><?php getCaption("Tgl. Bayar"); ?></td>
                <td><?php getCaption("Jenis Bayar"); ?></td>
                <td><?php getCaption("Bank"); ?></td>
                <td><?php getCaption("No. Check"); ?></td>
                <td><?php getCaption("Tanggal Check"); ?></td>
                <td><?php getCaption("Tgl J. Tempo"); ?></td>
                <td class='right'><?php getCaption("Pembayaran"); ?></td>
                <td class='right'><?php getCaption("Diskon"); ?></td>
                <td><?php getCaption("PPH"); ?></td>
                <td><?php getCaption("Keterangan"); ?></td>
            </tr>
            <tr>
                <td><?php datebox2('pay_date'); ?> </td>
                <td>
                    <table><?php cmdPayType('pay_type', '', $site_url, 100); ?></table>
                </td>
                <td><table><?php cmdBank('bank_code', '', $site_url, 100); ?></table></td>
                <td><?php textbox2('check_no', 100, 200); ?> </td>
                <td><?php datebox2('check_date'); ?> </td>
                <td><?php datebox2('due_date'); ?> </td>
                <td><?php numberbox2('pay_val', 90, 100); ?> </td>
                <td><?php numberbox2('disc_val', 90, 100); ?> </td>
                <td><?php numberbox2('pph', 90, 100); ?> </td>
                <td><?php textbox2('pay_desc', 140, 200); ?> </td>               
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

                                <button id="ok2" type="button" class="easyui-linkbutton" data-options="iconCls:'icon-ok'" onclick="$('#BayarWindow').window('close');"></button>

                            </td>

                        </tr>
                    </table>  </td>       
            </tr>
        </table>

    </form>
</div>
<div id="SearchOption" style="display:none;">  
    <form id="form_validation5" method="post" >    
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

<?php include 'hutangkomisi_fn.php'; ?>