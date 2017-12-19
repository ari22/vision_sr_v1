<div id="veh2Window" class="easyui-window" title="User Access: <?php getCaption("Kendaraan"); ?>" data-options="closable:true,minimizable:false,maximizable:false,collapsible:false,closed:true,modal:true,closed:true,inline:true" style="width:1050px;height: 600px;padding:10px;top:1;">
    <div style="width: 1000px; margin: 5px;">
        <form id="form_validation3" method="post" >
            
            <table class="main-form" style="width: 100% !important;">
                <tr>
                    <td width="100"><table><?php textbox('username', 'Username', 150, 70); ?></table></td>
                    <td width="200"><table><?php textbox('userrole', 'User Role', 150, 70); ?></table></td>
                    <td width="200"><table><tr><td><input type="checkbox" id="checkAll"> Check All</td></tr></table></td>
                </tr>
            </table>
            <input type="hidden"  name="table" value="usr_veh2">
            <input type="hidden"  name="id" class="id">

            <div class="easyui-tabs">

                <div title="<?php getCaption("Transaksi Kendaraan"); ?>" class="main-tab">
                    <table style="margin-top: 10px;">
                        <tr>
                            <td></td>
                            <td width="300"></td>
                            <td width="70" valign="top"><b>View</b></td>
                            <td width="70" valign="top"><b>Edit</b></td>
                            <td width="70" valign="top"><b>Print</b></td>
                            <td width="70" valign="top"><b>Delete</b></td>
                            <td width="70" valign="top"><b>Close</b></td>
                            <td width="70" valign="top"><b>Unclose</b></td>
                            <td width="120"><b>Unclose <br /><span style="font-size: 9px;">(After First Print)</span></b></td>  
                        </tr>
                        <tr><td colspan="9"></td></tr> <tr><td colspan="9"></td></tr> <tr><td colspan="9"></td></tr> <tr><td colspan="9"></td></tr>
                        <tr>
                            <td><b>1.</b></td>
                            <td><b>Vehicle Receiving Main Dealer</b></td>
                            <td class="text-center"><input type="checkbox" name="vw_vehrcvm" id="vw_vehrcvm"></td>
                            <td class="text-center"><input type="checkbox" name="ed_vehrcvm" id="ed_vehrcvm"></td>
                            <td class="text-center"><input type="checkbox" name="pr_vehrcvm" id="pr_vehrcvm"></td>
                            <td class="text-center"><input type="checkbox" name="dl_vehrcvm" id="dl_vehrcvm"></td>
                            <td class="text-center"><input type="checkbox" name="cl_vehrcvm" id="cl_vehrcvm"></td>
                            <td class="text-center"><input type="checkbox" name="uc_vehrcvm" id="uc_vehrcvm"></td>
                        </tr>
                        <tr>
                            <td><b>2.</b></td>
                            <td><b>Vehicle Purchase Main Dealer</b></td>
                            <td class="text-center"><input type="checkbox" name="vw_vehprhm" id="vw_vehprhm"></td>
                            <td class="text-center"><input type="checkbox" name="ed_vehprhm" id="ed_vehprhm"></td>
                            <td class="text-center"><input type="checkbox" name="pr_vehprhm" id="pr_vehprhm"></td>
                            <td class="text-center"><input type="checkbox" name="dl_vehprhm" id="dl_vehprhm"></td>
                            <td class="text-center"><input type="checkbox" name="cl_vehprhm" id="cl_vehprhm"></td>
                            <td class="text-center"><input type="checkbox" name="uc_vehprhm" id="uc_vehprhm"></td>
                        </tr>

                        <tr><td colspan="9"></td></tr> <tr><td colspan="9"></td></tr> <tr><td colspan="9"></td></tr> <tr><td colspan="9"></td></tr>

                        <tr>
                            <td></td>
                            <td width="300"></td>
                            <td width="70"><b>Import</b></td>
                        </tr>
                        <tr><td colspan="9"></td></tr> <tr><td colspan="9"></td></tr> <tr><td colspan="9"></td></tr> <tr><td colspan="9"></td></tr>
                        <tr>
                            <td><b>3.</b></td>
                            <td><b>Purchase Order</b></td>
                            <td class="text-center"><input type="checkbox" name="im_vehpo" id="im_vehpo"></td>
                        </tr>

                        <tr><td colspan="9"></td></tr> <tr><td colspan="9"></td></tr> <tr><td colspan="9"></td></tr> <tr><td colspan="9"></td></tr>

                        <tr>
                            <td></td>
                            <td width="300"></td>
                            <td width="70" valign="top"><b>View</b></td>
                            <td width="70" valign="top"><b>Edit</b></td>
                            <td width="70" valign="top"><b>Print</b></td>
                            <td width="70" valign="top"><b>Delete</b></td>
                            <td width="70"><b>Create<br /><span style="font-size: 9px;">SPK No.</span></b></td>
                            <td width="70" valign="top"><b>Distribute</b></td>
                            <td width="120"><b>UnDistribute <br /><span style="font-size: 9px;">SPK No.</span></b></td>
                            <td width="70" valign="top"><b>Export</b></td>
                        </tr>
                        <tr><td colspan="9"></td></tr> <tr><td colspan="9"></td></tr> <tr><td colspan="9"></td></tr> <tr><td colspan="9"></td></tr>

                        <tr>
                            <td><b>4.</b></td>
                            <td><b>SPK Management Center</b></td>
                            <td class="text-center"><input type="checkbox" name="vw_vehspkr" id="vw_vehspkr"></td>
                            <td class="text-center"></td>
                            <td class="text-center"><input type="checkbox" name="pr_vehspkr" id="pr_vehspkr"></td>
                            <td class="text-center"><input type="checkbox" name="dl_vehspkr" id="dl_vehspkr"></td>
                            <td class="text-center"><input type="checkbox" name="gn_vehspkr" id="gn_vehspkr"></td>
                            <td class="text-center"><input type="checkbox" name="ds_vehspkr" id="ds_vehspkr"></td>
                            <td class="text-center"><input type="checkbox" name="cn_vehspkr" id="cn_vehspkr"></td>
                            <td class="text-center"><input type="checkbox" name="xp_vehspkr" id="xp_vehspkr"></td>
                        </tr>
                        <tr>
                            <td><b>5.</b></td>
                            <td><b>Sales Activity</b></td>
                            <td class="text-center"><input type="checkbox" name="vw_sl_act" id="vw_sl_act"></td>
                            <td class="text-center"><input type="checkbox" name="ed_sl_act" id="ed_sl_act"></td>
                            <td class="text-center"><input type="checkbox" name="pr_sl_act" id="pr_sl_act"></td>
                            <td class="text-center"><input type="checkbox" name="dl_sl_act" id="dl_sl_act"></td>
                        </tr>
                        <tr><td colspan="9"></td></tr> <tr><td colspan="9"></td></tr> <tr><td colspan="9"></td></tr> <tr><td colspan="9"></td></tr>

                    </table>
                </div>

                <div title="<?php getCaption("Master Kendaraan"); ?>" class="main-tab">
                    <table style="margin-top: 10px;">
                        <tr>
                            <td></td>
                            <td width="300"></td>
                            <td width="70" valign="top"><b>View</b></td>
                            <td width="70" valign="top"><b>Edit</b></td>
                            <td width="70" valign="top"><b>Print</b></td>
                            <td width="70" valign="top"><b>Delete</b></td>
                            <td width="70" valign="top"><b>Discount</b></td>
                        </tr>
                        <tr><td colspan="7"></td></tr> <tr><td colspan="7"></td></tr>
                        <tr><td colspan="7"></td></tr> <tr><td colspan="7"></td></tr>

                        <tr><td colspan="7"><b>Master</b></td></tr>
                        <tr><td colspan="7"></td></tr> <tr><td colspan="7"></td></tr>

                        <tr>
                            <td style="padding-left:10px;"><b>1.</b></td>
                            <td><b>Vehicle Price Main Dealer:</b></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="padding-left: 10px;"><b>1.a.</b> <b> Dealer Price & Sale Price</b></td>
                            <td class="text-center"><input type="checkbox" name="vw_vehprcd" id="vw_vehprcd"></td>
                            <td class="text-center"><input type="checkbox" name="ed_vehprcd" id="ed_vehprcd"></td>
                            <td class="text-center"><input type="checkbox" name="pr_vehprcd" id="pr_vehprcd"></td>
                            <td class="text-center"><input type="checkbox" name="dl_vehprcd" id="dl_vehprcd"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="padding-left: 10px;"><b>1.b.</b> <b> Supplier Price / ATPM & Dealer</b></td>
                            <td class="text-center"><input type="checkbox" name="vw_vehprcm" id="vw_vehprcm"></td>
                            <td class="text-center"><input type="checkbox" name="ed_vehprcm" id="ed_vehprcm"></td>
                            <td class="text-center"><input type="checkbox" name="pr_vehprcm" id="pr_vehprcm"></td>
                            <td class="text-center"><input type="checkbox" name="dl_vehprcm" id="dl_vehprcm"></td>
                            <td class="text-center"><input type="checkbox" name="ds_vehprcm" id="ds_vehprcm"></td>
                        </tr>

                        <tr><td colspan="7"></td></tr> <tr><td colspan="7"></td></tr>
                        <tr><td colspan="7"></td></tr> <tr><td colspan="7"></td></tr>
                        <tr>
                            <td style="padding-left:10px;"><b>2.</b></td>
                            <td><b>Standart Optional Default:</b></td>
                            <td class="text-center"><input type="checkbox" name="vw_stdopt" id="vw_stdopt"></td>
                            <td class="text-center"><input type="checkbox" name="ed_stdopt" id="ed_stdopt"></td>
                            <td class="text-center"><input type="checkbox" name="pr_stdopt" id="pr_stdopt"></td>
                            <td class="text-center"><input type="checkbox" name="dl_stdopt" id="dl_stdopt"></td>
                        </tr>

                        <tr><td colspan="7"></td></tr> <tr><td colspan="7"></td></tr>
                        <tr><td colspan="7"></td></tr> <tr><td colspan="7"></td></tr>
                    </table>
                </div>

                <div title="<?php getCaption("Stock Kendaraan"); ?>" class="main-tab">
                    <table style="margin-top: 10px;">
                        <tr>
                            <td width="250"></td>
                            <td width="70" valign="top"><b>View</b></td>
                            <td width="70" valign="top"><b>Edit</b></td>
                            <td width="70" valign="top"><b>Print</b></td>
                            <td width="70" valign="top"><b>Export</b></td>
                        </tr>
                        <tr><td colspan="5"></td></tr> <tr><td colspan="5"></td></tr>
                        <tr><td colspan="5"></td></tr> <tr><td colspan="5"></td></tr>

                        <tr><td colspan="5"><b>Stock Table Main Dealer</b></td></tr>
                        <tr><td colspan="5"></td></tr> <tr><td colspan="5"></td></tr>
                        <tr>
                            <td style="padding-left:10px;"><b>Main Dealer Stock(Unit)</b></td>
                            <td class="text-center"><input type="checkbox" name="vw_vehstum" id="vw_vehstum"></td>
                            <td class="text-center"></td>
                            <td class="text-center"><input type="checkbox" name="pr_vehstum" id="pr_vehstum"></td>
                            <td class="text-center"><input type="checkbox" name="xp_vehstum" id="xp_vehstum"></td>
                        </tr>
                        <tr>
                            <td style="padding-left:10px;"><b>Main Dealer Stock (Price)</b></td>
                            <td class="text-center"><input type="checkbox" name="vw_vehstpm" id="vw_vehstpm"></td>
                            <td class="text-center"></td>
                            <td class="text-center"><input type="checkbox" name="pr_vehstpm" id="pr_vehstpm"></td>
                            <td class="text-center"><input type="checkbox" name="xp_vehstpm" id="xp_vehstpm"></td>
                        </tr>
                        <tr><td colspan="5"></td></tr> <tr><td colspan="5"></td></tr>
                        <tr><td colspan="5"></td></tr> <tr><td colspan="5"></td></tr>
                    </table>
                </div>

                <div title="CRM" class="main-tab">
                    <table style="margin-top: 10px;">
                        <tr>
                            <td width="250"></td>
                            <td width="70" valign="top"><b>View</b></td>
                            <td width="70" valign="top"><b>Edit</b></td>
                            <td width="70" valign="top"><b>Print</b></td>
                            <td width="70" valign="top"><b>Export</b></td>
                            <td width="70" valign="top"><b>SMS</b></td>
                        </tr>
                        <tr><td colspan="6"></td></tr> <tr><td colspan="6"></td></tr>
                        <tr><td colspan="6"></td></tr> <tr><td colspan="6"></td></tr>
                        <tr>
                            <td><b>Reminder</b></td>
                            <td class="text-center"><input type="checkbox" name="vw_vehrmd" id="vw_vehrmd"></td>
                            <td class="text-center"><input type="checkbox" name="ed_vehrmd" id="ed_vehrmd"></td>
                            <td class="text-center"><input type="checkbox" name="pr_vehrmd" id="pr_vehrmd"></td>
                            <td class="text-center"><input type="checkbox" name="xp_vehrmd" id="xp_vehrmd"></td>
                            <td class="text-center"><input type="checkbox" name="sn_vehrmd" id="sn_vehrmd"></td>
                        </tr>
                        <tr>
                            <td><b>Vehicle Sales (CRM)</b></td>
                            <td class="text-center"><input type="checkbox" name="vw_vehslcr" id="vw_vehslcr"></td>
                            <td class="text-center"></td>
                            <td class="text-center"><input type="checkbox" name="pr_vehslcr" id="pr_vehslcr"></td>
                            <td class="text-center"><input type="checkbox" name="xp_vehslcr" id="xp_vehslcr"></td>
                        </tr>
                        <tr><td colspan="6"></td></tr> <tr><td colspan="6"></td></tr>
                        <tr><td colspan="6"></td></tr> <tr><td colspan="6"></td></tr>
                    </table>
                </div>

                <div title="<?php getCaption("Komisi"); ?>" class="main-tab">
                    <table style="margin-top: 10px;">
                        <tr>
                            <td width="250"></td>
                            <td width="70" valign="top"><b>View</b></td>
                            <td width="70" valign="top"><b>Edit</b></td>
                            <td width="70" valign="top"><b>Print</b></td>
                            <td width="70" valign="top"><b>Delete</b></td>
                            <td width="70" valign="top"><b>Export</b></td>
                        </tr>
                        <tr><td colspan="6"></td></tr> <tr><td colspan="6"></td></tr>
                        <tr><td colspan="6"></td></tr> <tr><td colspan="6"></td></tr>
                        <tr>
                            <td><b>Commission Fee & Payment</b></td>
                            <td class="text-center"><input type="checkbox" name="vw_vehcom" id="vw_vehcom"></td>
                            <td class="text-center"><input type="checkbox" name="ed_vehcom" id="ed_vehcom"></td>
                            <td class="text-center"><input type="checkbox" name="pr_vehcom" id="pr_vehcom"></td>
                            <td class="text-center"><input type="checkbox" name="dl_vehcom" id="dl_vehcom"></td>
                            <td class="text-center"><input type="checkbox" name="xp_vehcom" id="xp_vehcom"></td>
                        </tr>
                        <tr>
                            <td><b>Receipt Commision</b></td>
                            <td class="text-center"><input type="checkbox" name="vw_vehcomt" id="vw_vehcomt"></td>
                            <td class="text-center"></td>
                            <td class="text-center"><input type="checkbox" name="pr_vehcomt" id="pr_vehcomt"></td>
                        </tr>
                        <tr><td colspan="6"></td></tr> <tr><td colspan="6"></td></tr>
                        <tr><td colspan="6"></td></tr> <tr><td colspan="6"></td></tr>
                    </table>
                </div>

                <div title="<?php getCaption("Insentif"); ?>" class="main-tab">
                    <table style="margin-top: 10px;">
                        <tr>
                            <td width="250"></td>
                            <td width="70" valign="top"><b>View</b></td>
                            <td width="70" valign="top"><b>Edit</b></td>
                            <td width="70" valign="top"><b>Print</b></td>
                            <td width="70" valign="top"><b>Delete</b></td>
                        </tr>
                        <tr><td colspan="6"></td></tr> <tr><td colspan="6"></td></tr>
                        <tr><td colspan="6"></td></tr> <tr><td colspan="6"></td></tr>
                        <tr>
                            <td><b>Sales Insentif</b></td>
                            <td class="text-center"><input type="checkbox" name="vw_vehebns" id="vw_vehebns"></td>
                            <td class="text-center"></td>
                            <td class="text-center"><input type="checkbox" name="pr_vehebns" id="pr_vehebns"></td>
                        </tr>
                        <tr><td colspan="6"></td></tr> <tr><td colspan="6"></td></tr>
                        <tr><td colspan="6"></td></tr> <tr><td colspan="6"></td></tr>
                    </table>
                </div>
                                <div title="<?php getCaption("Dealer Financing"); ?>" class="main-tab">
                    <table style="margin-top: 10px;">
                        <tr>
                            <td></td>
                            <td width="250"></td>
                            <td width="70"><b>View</b></td>
                            <td width="70"><b>Print</b></td>
                            <td width="70"><b>Export</b></td>
                        </tr>
                        <tr><td colspan="5"></td></tr>
                        <tr><td colspan="5"></td></tr>
                        <tr>
                            <td>1.</td>
                            <td>Vehivle Registration Number Application</td>
                            <td class="text-center"><input type="checkbox" name="vw_vehinvr" id="vw_vehinvr"></td>
                            <td class="text-center"><input type="checkbox" name="pr_vehinvr" id="pr_vehinvr"></td>
                            <td class="text-center"><input type="checkbox" name="xp_vehinvr" id="xp_vehinvr"></td>

                        </tr>
                        <tr>
                            <td>2.</td>
                            <td>Dealer Financing  Disbursement of funds</td>
                            <td class="text-center"><input type="checkbox" name="vw_vehdlrf" id="vw_vehdlrf"></td>
                            <td class="text-center"><input type="checkbox" name="pr_vehdlrf" id="pr_vehdlrf"></td>
                            <td class="text-center"><input type="checkbox" name="xp_vehdlrf" id="xp_vehdlrf"></td>

                        </tr>
                        <tr>
                            <td>3.</td>
                            <td>Sales Invoice</td>
                            <td class="text-center"><input type="checkbox" name="vw_fp2xl" id="vw_fp2xl"></td>
                            <td class="text-center"><input type="checkbox" name="pr_fp2xl" id="pr_fp2xl"></td>
                            <td class="text-center"><input type="checkbox" name="xp_fp2xl" id="xp_fp2xl"></td>

                        </tr>
                    </table>
                </div>
                <div title="Miscellaneous" class="main-tab">
                    <table style="margin-top: 10px;">
                        <tr>
                            <td width="250"></td>
                            <td width="70" valign="top"><b>View</b></td>
                            <td width="70" valign="top"><b>Edit</b></td>
                            <td width="70" valign="top"><b>Print</b></td>
                            <td width="70" valign="top"><b>Delete</b></td>
                        </tr>
                        <tr><td colspan="6"></td></tr> <tr><td colspan="6"></td></tr>
                        <tr><td colspan="6"></td></tr> <tr><td colspan="6"></td></tr>
                        <tr>
                            <td><b>PDI (Delivery Plan display screen)</b></td>
                            <td class="text-center"><input type="checkbox" name="vw_wod_pdi" id="vw_wod_pdi"></td>
                            <td class="text-center"></td>
                            <td class="text-center"><input type="checkbox" name="ed_wod_pdi" id="ed_wod_pdi"></td>
                        </tr>
                        <tr><td colspan="6"></td></tr> <tr><td colspan="6"></td></tr>
                        <tr><td colspan="6"></td></tr> <tr><td colspan="6"></td></tr>
                    </table>
                </div>
            </div>

            <div class=" main-nav">
                <table class="table" style="width:500px;" border="0">
                    <tr>

                        <td style="border-top:0px !important;">
                            <button type="button" id="cmdSave" title="Save"  data-options="iconCls:'icon-save',group:'g2'" class="easyui-linkbutton cmdSave" onclick="saveData2('form_validation3')"> Save</button>
                            <button type="button" id="cmdCancel" title="Batal" data-options="iconCls:'icon-undo',group:'g2'" class="easyui-linkbutton cmdCancel"  onclick="condCancel2('form_validation3')"> Cancel</button>
                            <button type="button" id="cmdEdit" title="<?php getCaption("Ubah"); ?>" data-options="iconCls:'icon-edit'" class="easyui-linkbutton cmdEdit"  onclick="condEdit2('form_validation3')" > Edit</button>
                            <button type="button" id="cmdDelete" title="<?php getCaption("Hapus"); ?>" data-options="iconCls:'icon-no'" class="easyui-linkbutton cmdDelete"  onclick=" condDelete2('usr_veh2', 'form_validation3');" ></button>
                            <button type="button" id="cmdClose" title="<?php getCaption("Close"); ?>" data-options="iconCls:'icon-ok'" class="easyui-linkbutton cmdClose"  onclick=" $('#veh2Window').window('close');" > Ok</button>
                        </td>

                    </tr>
                </table> 
            </div>

        </form>
    </div>
</div>
<script>
    function vehtwo() {
        var user = $("#form_validation #username").val();

        $("#form_validation3 #username").val($("#form_validation #username").val());
        $("#form_validation3 #userrole").val($("#form_validation #userrole").val());


        $("#form_validation3 input:checkbox").prop("checked", false);

        $.post(site_url + 'transaction/setting/read_access/', {table: 'usr_veh2', nav: '', id: '', user: user}, function (json) {
             formDisabled2('form_validation3');
            if (json !== '[]') {
                var rowData = $.parseJSON(json);

                $("#form_validation3 .id").val(rowData.id);

                $.each(rowData, function (i, v) {
                    if (v == '1') {
                        $("#form_validation3 #" + i).prop("checked", true);
                        $("#form_validation3 #" + i).val(1);
                    }

                });

            } else {
                deletedisable('form_validation3');
            }
           
        });
    }

    function openVehTwo() {
        $('#veh2Window').window('open');
        vehtwo();
    }
</script>
