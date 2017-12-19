<div id="veh1Window" class="easyui-window" title="User Access: <?php getCaption("Kendaraan"); ?>" data-options="closable:true,minimizable:false,maximizable:false,collapsible:false,closed:true,modal:true,closed:true,inline:true" style="width:1050px;height: 600px;padding:10px;top:1;">
    <div style="width: 1000px; margin: 5px;">
        <form id="form_validation2" method="post" >
            <table class="main-form" style="width: 100% !important;">
                <tr>
                    <td width="100"><table><?php textbox('username', 'Username', 150, 70); ?></table></td>
                    <td width="200"><table><?php textbox('userrole', 'User Role', 150, 70); ?></table></td>
                    <td width="200"><table><tr><td><input type="checkbox" id="checkAll"> Check All</td></tr></table></td>
                </tr>
            </table>
            <input type="hidden"  name="table" value="usr_veh">
            <input type="hidden"  name="id" class="id">
            <div class="easyui-tabs" id="tabscoi2">
                <div title="<?php getCaption("Transaksi Kendaraan"); ?>" class="main-tab">
                    <table style="margin-top: 10px;" >
                        <tr>
                            <td width="30"></td>
                            <td width="250"></td>
                            <td width="70" valign="top"><b>View</b></td>
                            <td width="70" valign="top"><b>Edit</b></td>
                            <td width="70" valign="top"><b>Print</b></td>
                            <td width="70" valign="top"><b>Delete</b></td>
                            <td width="70" valign="top"><b>Close</b></td>
                            <td width="70" valign="top"><b>Unclose</b></td>
                            <td width="120"><b>Unclose <br /><span style="font-size: 9px;">(After First Print)</span></b></td>
                            <td width="70" valign="top"><b>Export</b></td>
                        </tr>
                        <tr><td colspan="10"></td></tr><tr><td colspan="10"></td></tr>
                        <tr>
                            <td colspan="2"><b>SPK</b></td>
                            <td class="text-center"><input type="checkbox" name="vw_vehspk" id="vw_vehspk"></td>
                            <td class="text-center"><input type="checkbox" name="ed_vehspk" id="ed_vehspk"></td>
                            <td class="text-center"><input type="checkbox" name="pr_vehspk" id="pr_vehspk"></td>
                            <td class="text-center"><input type="checkbox" name="dl_vehspk" id="dl_vehspk"></td>
                            <td class="text-center"><input type="checkbox" name="cl_vehspk" id="cl_vehspk"></td>
                            <td class="text-center"><input type="checkbox" name="uc_vehspk" id="uc_vehspk"></td>
                            <td class="text-center"><input type="checkbox" name="ucpvehspk" id="ucpvehspk"></td>
                            <td class="text-center"><input type="checkbox" name="xp_vehspk" id="xp_vehspk"></td>
                        </tr>
                        <tr>
                            <td  colspan="10"><b><?php getCaption("Transaksi Kendaraan"); ?></b></td>
                        </tr>
                        <tr>
                            <td style="padding-left:10px;">1.</td>
                            <td>Sales:</td>
                            <td class="text-center"><input type="checkbox" name="vw_vehslh" id="vw_vehslh"></td>
                            <td class="text-center"><input type="checkbox" name="ed_vehslh" id="ed_vehslh"></td>
                            <td class="text-center"><input type="checkbox" name="pr_vehslh" id="pr_vehslh"></td>
                            <td class="text-center"><input type="checkbox" name="dl_vehslh" id="dl_vehslh"></td>
                            <td class="text-center"><input type="checkbox" name="cl_vehslh" id="cl_vehslh"></td>
                            <td class="text-center"><input type="checkbox" name="uc_vehslh" id="uc_vehslh"></td>
                            <td class="text-center"><input type="checkbox" name="ucpvehslh" id="ucpvehslh"></td>
                            <td class="text-center"><input type="checkbox" name="xp_vehslh" id="xp_vehslh"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Sale Price</td>
                            <td class="text-center"><input type="checkbox" name="vw_vehsprc" id="vw_vehsprc"></td>
                        </tr>
                        <tr><td  colspan="10"></td></tr>
                        <tr>
                            <td style="padding-left:10px;">2.</td>
                            <td>Purchase Order</td>
                            <td class="text-center"><input type="checkbox" name="vw_vehpo" id="vw_vehpo"></td>
                            <td class="text-center"><input type="checkbox" name="ed_vehpo" id="ed_vehpo"></td>
                            <td class="text-center"><input type="checkbox" name="pr_vehpo" id="pr_vehpo"></td>
                            <td class="text-center"><input type="checkbox" name="dl_vehpo" id="dl_vehpo"></td>
                            <td class="text-center"><input type="checkbox" name="cl_vehpo" id="cl_vehpo"></td>
                            <td class="text-center"><input type="checkbox" name="uc_vehpo" id="uc_vehpo"></td>
                            <td class="text-center"></td>
                            <td class="text-center"><input type="checkbox" name="xp_vehpo" id="xp_vehpo"></td>
                        </tr>
                        <tr>
                            <td style="padding-left:10px;">3.</td>
                            <td>Receiving</td>
                            <td class="text-center"><input type="checkbox" name="vw_vehrcv" id="vw_vehrcv"></td>
                            <td class="text-center"><input type="checkbox" name="ed_vehrcv" id="ed_vehrcv"></td>
                            <td class="text-center"><input type="checkbox" name="pr_vehrcv" id="pr_vehrcv"></td>
                            <td class="text-center"><input type="checkbox" name="dl_vehrcv" id="dl_vehrcv"></td>
                            <td class="text-center"><input type="checkbox" name="cl_vehrcv" id="cl_vehrcv"></td>
                            <td class="text-center"><input type="checkbox" name="uc_vehrcv" id="uc_vehrcv"></td>
                            <td class="text-center"></td>
                            <td class="text-center"><input type="checkbox" name="xp_vehrcv" id="xp_vehrcv"></td>
                        </tr>
                        <tr>
                            <td style="padding-left:10px;">4.</td>
                            <td>Purchase</td>
                            <td class="text-center"><input type="checkbox" name="vw_vehprh" id="vw_vehprh"></td>
                            <td class="text-center"><input type="checkbox" name="ed_vehprh" id="ed_vehprh"></td>
                            <td class="text-center"><input type="checkbox" name="pr_vehprh" id="pr_vehprh"></td>
                            <td class="text-center"><input type="checkbox" name="dl_vehprh" id="dl_vehprh"></td>
                            <td class="text-center"><input type="checkbox" name="cl_vehprh" id="cl_vehprh"></td>
                            <td class="text-center"><input type="checkbox" name="uc_vehprh" id="uc_vehprh"></td>
                            <td class="text-center"></td>
                            <td class="text-center"><input type="checkbox" name="xp_vehprh" id="xp_vehprh"></td>
                        </tr>
                        <tr>
                            <td style="padding-left:10px;">5.</td>
                            <td>Sales Return</td>
                            <td class="text-center"><input type="checkbox" name="vw_vehrslh" id="vw_vehrslh"></td>
                            <td class="text-center"><input type="checkbox" name="ed_vehrslh" id="ed_vehrslh"></td>
                            <td class="text-center"><input type="checkbox" name="pr_vehrslh" id="pr_vehrslh"></td>
                            <td class="text-center"><input type="checkbox" name="dl_vehrslh" id="dl_vehrslh"></td>
                            <td class="text-center"><input type="checkbox" name="cl_vehrslh" id="cl_vehrslh"></td>
                            <td class="text-center"><input type="checkbox" name="uc_vehrslh" id="uc_vehrslh"></td>
                            <td class="text-center"></td>
                            <td class="text-center"><input type="checkbox" name="xp_vehrslh" id="xp_vehrslh"></td>
                        </tr>
                        <tr>
                            <td style="padding-left:10px;">6.</td>
                            <td>Purchase Return</td>
                            <td class="text-center"><input type="checkbox" name="vw_vehrprh" id="vw_vehrprh"></td>
                            <td class="text-center"><input type="checkbox" name="ed_vehrprh" id="ed_vehrprh"></td>
                            <td class="text-center"><input type="checkbox" name="pr_vehrprh" id="pr_vehrprh"></td>
                            <td class="text-center"><input type="checkbox" name="dl_vehrprh" id="dl_vehrprh"></td>
                            <td class="text-center"><input type="checkbox" name="cl_vehrprh" id="cl_vehrprh"></td>
                            <td class="text-center"><input type="checkbox" name="uc_vehrprh" id="uc_vehrprh"></td>
                            <td class="text-center"></td>
                            <td class="text-center"><input type="checkbox" name="xp_vehrprh" id="xp_vehrprh"></td>
                        </tr>
                        <tr>
                            <td style="padding-left:10px;">7.</td>
                            <td>Vehicle Movement</td>
                            <td class="text-center"><input type="checkbox" name="vw_vehmov" id="vw_vehmov"></td>
                            <td class="text-center"><input type="checkbox" name="ed_vehmov" id="ed_vehmov"></td>
                            <td class="text-center"><input type="checkbox" name="pr_vehmov" id="pr_vehmov"></td>
                            <td class="text-center"><input type="checkbox" name="dl_vehmov" id="dl_vehmov"></td>
                            <td class="text-center"><input type="checkbox" name="cl_vehmov" id="cl_vehmov"></td>
                            <td class="text-center"><input type="checkbox" name="uc_vehmov" id="uc_vehmov"></td>
                        </tr>
                        <tr>
                            <td style="padding-left:10px;" valign="top">8.</td>
                            <td>Outstanding PO (Purchase Order) & <span>Mutation Card Outstanding PO</td>
                            <td class="text-center" valign="top"><input type="checkbox" name="vw_vehpoo" id="vw_vehpoo"></td>
                            <td class="text-center"></td>
                            <td class="text-center" valign="top"><input type="checkbox" name="pr_vehpoo" id="pr_vehpoo"></td>

                        </tr>
                        <tr><td colspan="10"></td></tr>
                        <tr>
                            <td colspan="2"><b>Vehicle Distribution</b></td>
                            <td class="text-center"><input type="checkbox" name="vw_vehdist" id="vw_vehdist"></td>
                            <td class="text-center"></td>
                            <td class="text-center"><input type="checkbox" name="pr_vehdist" id="pr_vehdist"></td>
                        </tr>
                        <tr>
                            <td colspan="2"><b>Vehicle Data</b></td>
                            <td class="text-center"><input type="checkbox" name="vw_veh" id="vw_veh"></td>
                            <td class="text-center"><input type="checkbox" name="ed_veh" id="ed_veh"></td>
                            <td class="text-center"><input type="checkbox" name="pr_veh" id="pr_veh"></td>
                        </tr>
                        <tr>
                            <td colspan="2"><b>Debit Note (Purchase)</b></td>
                            <td class="text-center"><input type="checkbox" name="vw_vehdbnt" id="vw_vehdbnt"></td>
                            <td class="text-center"></td>
                            <td class="text-center"><input type="checkbox" name="pr_vehdbnt" id="pr_vehdbnt"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"><input type="checkbox" name="xp_vehdbnt" id="xp_vehdbnt"></td>
                        </tr>
                    </table>
                </div>
                <div title="<?php getCaption("Matching/UnMatching SPK & Stock"); ?>" class="main-tab">
                    <table style="margin-top: 10px;">
                        <tr>
                            <td width="30"></td>
                            <td width="250"></td>
                            <td width="70"><b>View</b></td>
                            <td width="70"><b>Edit</b></td>
                            <td width="70"><b>Print</b></td>
                            <td width="200"><b>UnMatch (Delete Matching)</b></td>
                        </tr>
                        <tr><td colspan="6"></td></tr><tr><td colspan="10"></td></tr>
                        <tr>
                            <td colspan="6"><b>Matching SPK & Stock</b></td>
                        </tr>
                        <tr>
                            <td>1.</td>
                            <td>Manual Matching</td>
                            <td class="text-center"><input type="checkbox" name="vw_vehmtcm" id="vw_vehmtcm"></td>
                            <td class="text-center"><input type="checkbox" name="ed_vehmtcm" id="ed_vehmtcm"></td>
                            <td class="text-center"><input type="checkbox" name="pr_vehmtcm" id="pr_vehmtcm"></td>
                            <td class="text-center"><input type="checkbox" name="dl_vehmtcm" id="dl_vehmtcm"></td>
                        </tr>
                        <tr>
                            <td>2.</td>
                            <td>Automatic Matching</td>
                            <td class="text-center"><input type="checkbox" name="vw_vehmtca" id="vw_vehmtca"></td>
                            <td class="text-center"><input type="checkbox" name="ed_vehmtca" id="ed_vehmtca"></td>
                            <td class="text-center"><input type="checkbox" name="pr_vehmtca" id="pr_vehmtca"></td>
                            <td class="text-center"><input type="checkbox" name="dl_vehmtca" id="dl_vehmtca"></td>
                        </tr>
                        <tr> <td colspan="6"></td></tr>  <tr> <td colspan="6"></td></tr>
                        <tr> <td colspan="6"></td></tr>  <tr> <td colspan="6"></td></tr>
                        <tr>
                            <td colspan="4" valign="top"><b><br />SPK Order Date during UnMatching is set to be the same as :</b></td>
                            <td colspan="2" valign="top" class="checkboxBorder">
                                <table  style="padding:10px;">
                                    <tr>
                                        <td> <a href="#" class="checkbox" name="unmtch_pos_1"><input type="radio" id="unmtch_pos_1" class="unmtch_pos_1"  name="unmtch_pos" value="1">SPK Date</a></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <a href="#" class="checkbox" name="unmtch_pos_2"><input type="radio" id="unmtch_pos_2" class="unmtch_pos_2" name="unmtch_pos" value="2">UnMatch Date</a>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>

                <div title="<?php getCaption("Stock Kendaraan"); ?>" class="main-tab">
                    <table style="margin-top: 10px;">
                        <tr>
                            <td width="250"></td>
                            <td width="70"><b>View</b></td>
                            <td width="70"><b>Edit</b></td>
                            <td width="70"><b>Print</b></td>
                            <td width="70"><b>Export</b></td>
                        </tr>

                        <tr><td colspan="5"></td></tr><tr><td colspan="5"></td></tr>
                        <tr><td colspan="5"></td></tr><tr><td colspan="5"></td></tr>

                        <tr><td colspan="5"><b>Showroom Dealer</b></td></tr>
                        <tr>
                            <td style="padding-left:10px;">Vehicle Stock</td>
                            <td class="text-center"><input type="checkbox" name="vw_vehstk" id="vw_vehstk"></td>
                            <td class="text-center"><input type="checkbox" name="ed_vehstk" id="ed_vehstk"></td>
                            <td class="text-center"><input type="checkbox" name="pr_vehstk" id="pr_vehstk"></td>
                            <td class="text-center"><input type="checkbox" name="xp_vehstk" id="xp_vehstk"></td>

                        </tr>

                        <tr><td colspan="5"></td></tr><tr><td colspan="5"></td></tr>
                        <tr><td colspan="5"></td></tr><tr><td colspan="5"></td></tr>

                        <tr><td colspan="5"><b>Dealer Stock Card</b></td></tr>
                        <tr>
                            <td style="padding-left:10px;">Dealer Stock / Counter Sales (Unit)</td>
                            <td class="text-center"><input type="checkbox" name="vw_vehstud" id="vw_vehstud"></td>
                            <td class="text-center"></td>
                            <td class="text-center"><input type="checkbox" name="pr_vehstud" id="pr_vehstud"></td>
                            <td class="text-center"><input type="checkbox" name="xp_vehstud" id="xp_vehstud"></td>

                        </tr>
                        <tr>
                            <td style="padding-left:10px;">Dealer Stock / Counter Sales (Price)</td>
                            <td class="text-center"><input type="checkbox" name="vw_vehstpd" id="vw_vehstpd"></td>
                            <td class="text-center"></td>
                            <td class="text-center"><input type="checkbox" name="pr_vehstpd" id="pr_vehstpd"></td>
                            <td class="text-center"><input type="checkbox" name="xp_vehstpd" id="xp_vehstpd"></td>
                        </tr>
                    </table>
                </div>


                <div title="<?php getCaption("Master Kendaraan"); ?>" class="main-tab">
                    <table style="margin-top: 10px;">
                        <tr>
                            <td></td>
                            <td width="280"></td>
                            <td width="70"><b>View</b></td>
                            <td width="70"><b>Edit</b></td>
                            <td width="70"><b>Print</b></td>
                            <td width="70"><b>Delete</b></td>
                            <td width="70"><b>Export</b></td>
                        </tr>
                        <tr><td colspan="7"></td></tr><tr><td colspan="7"></td></tr>
                        <tr>
                            <td colspan="7"><b>Master</b></td>
                        </tr>
                        <tr><td colspan="7"></td></tr><tr><td colspan="7"></td></tr>
                        <tr>
                            <td style="padding-left:10px;">1.</td>
                            <td>Customer</td>
                            <td class="text-center"><input type="checkbox" name="vw_vehcust" id="vw_vehcust"></td>
                            <td class="text-center"><input type="checkbox" name="ed_vehcust" id="ed_vehcust"></td>
                            <td class="text-center"><input type="checkbox" name="pr_vehcust" id="pr_vehcust"></td>
                            <td class="text-center"><input type="checkbox" name="dl_vehcust" id="dl_vehcust"></td>
                            <td class="text-center"><input type="checkbox" name="xp_vehcust" id="xp_vehcust"></td>
                        </tr>
                        <tr>
                            <td style="padding-left:10px;">2.</td>
                            <td>Supplier</td>
                            <td class="text-center"><input type="checkbox" name="vw_vehsupp" id="vw_vehsupp"></td>
                            <td class="text-center"><input type="checkbox" name="ed_vehsupp" id="ed_vehsupp"></td>
                            <td class="text-center"><input type="checkbox" name="pr_vehsupp" id="pr_vehsupp"></td>
                            <td class="text-center"><input type="checkbox" name="dl_vehsupp" id="dl_vehsupp"></td>
                            <td class="text-center"></td>
                        </tr>
                        <tr>
                            <td style="padding-left:10px;">3.</td>
                            <td>Sales Person</td>
                            <td class="text-center"><input type="checkbox" name="vw_vehsrep" id="vw_vehsrep"></td>
                            <td class="text-center"><input type="checkbox" name="ed_vehsrep" id="ed_vehsrep"></td>
                            <td class="text-center"><input type="checkbox" name="pr_vehsrep" id="pr_vehsrep"></td>
                            <td class="text-center"><input type="checkbox" name="dl_vehsrep" id="dl_vehsrep"></td>
                            <td class="text-center"></td>
                        </tr>
                        <tr>
                            <td style="padding-left:10px;">3.</td>
                            <td>Sales Supervisor</td>
                            <td class="text-center"><input type="checkbox" name="vw_vehsspv" id="vw_vehsspv"></td>
                            <td class="text-center"><input type="checkbox" name="ed_vehsspv" id="ed_vehsspv"></td>
                            <td class="text-center"><input type="checkbox" name="pr_vehsspv" id="pr_vehsspv"></td>
                            <td class="text-center"><input type="checkbox" name="dl_vehsspv" id="dl_vehsspv"></td>
                            <td class="text-center"></td>
                        </tr>
                        <tr>
                            <td style="padding-left:10px;">4.</td>
                            <td>Collector</td>
                            <td class="text-center"><input type="checkbox" name="vw_vehcoll" id="vw_vehcoll"></td>
                            <td class="text-center"><input type="checkbox" name="ed_vehcoll" id="ed_vehcoll"></td>
                            <td class="text-center"><input type="checkbox" name="pr_vehcoll" id="pr_vehcoll"></td>
                            <td class="text-center"><input type="checkbox" name="dl_vehcoll" id="dl_vehcoll"></td>
                            <td class="text-center"></td>
                        </tr>
                        <tr>
                            <td style="padding-left:10px;">5.</td>
                            <td>Vehicle Type</td>
                            <td class="text-center"><input type="checkbox" name="vw_vehvtyp" id="vw_vehvtyp"></td>
                            <td class="text-center"><input type="checkbox" name="ed_vehvtyp" id="ed_vehvtyp"></td>
                            <td class="text-center"><input type="checkbox" name="pr_vehvtyp" id="pr_vehvtyp"></td>
                            <td class="text-center"><input type="checkbox" name="dl_vehvtyp" id="dl_vehvtyp"></td>
                            <td class="text-center"><input type="checkbox" name="xp_vehvtyp" id="xp_vehvtyp"></td>
                        </tr>
                        <tr>
                            <td style="padding-left:10px;">6.</td>
                            <td>Vehicle Color</td>
                            <td class="text-center"><input type="checkbox" name="vw_color" id="vw_color"></td>
                            <td class="text-center"><input type="checkbox" name="ed_color" id="ed_color"></td>
                            <td class="text-center"><input type="checkbox" name="pr_color" id="pr_color"></td>
                            <td class="text-center"><input type="checkbox" name="dl_color" id="dl_color"></td>
                            <td class="text-center"><input type="checkbox" name="xp_color" id="xp_color"></td>
                        </tr>
                        <tr>
                            <td style="padding-left:10px;">7.</td>
                            <td>Vehicle Price (Purchase & Sales)</td>
                            <td class="text-center"><input type="checkbox" name="vw_vehprc" id="vw_vehprc"></td>
                            <td class="text-center"><input type="checkbox" name="ed_vehprc" id="ed_vehprc"></td>
                            <td class="text-center"><input type="checkbox" name="pr_vehprc" id="pr_vehprc"></td>
                            <td class="text-center"><input type="checkbox" name="dl_vehprc" id="dl_vehprc"></td>
                            <td class="text-center"></td>
                        </tr>
                        <tr>
                            <td style="padding-left:10px;">8.</td>
                            <td>Work</td>
                            <td class="text-center"><input type="checkbox" name="vw_vehwkcd" id="vw_vehwkcd"></td>
                            <td class="text-center"><input type="checkbox" name="ed_vehwkcd" id="ed_vehwkcd"></td>
                            <td class="text-center"><input type="checkbox" name="pr_vehwkcd" id="pr_vehwkcd"></td>
                            <td class="text-center"><input type="checkbox" name="dl_vehwkcd" id="dl_vehwkcd"></td>
                            <td class="text-center"><input type="checkbox" name="xp_vehwkcd" id="xp_vehwkcd"></td>
                        </tr>
                        <tr><td colspan="7"></td></tr>
                        <tr><td colspan="7"></td></tr>
                        <tr><td colspan="7"></td></tr>
                        <tr><td colspan="7"></td></tr>
                        <tr>
                            <td colspan="2"><b>Insurance</b></td>
                            <td class="text-center"><input type="checkbox" name="vw_vehinsr" id="vw_vehinsr"></td>
                            <td class="text-center"><input type="checkbox" name="ed_vehinsr" id="ed_vehinsr"></td>
                            <td class="text-center"><input type="checkbox" name="pr_vehinsr" id="pr_vehinsr"></td>
                            <td class="text-center"><input type="checkbox" name="dl_vehinsr" id="dl_vehinsr"></td>          
                        </tr>
                        <tr>
                            <td colspan="2"><b>Bank</b></td>
                            <td class="text-center"><input type="checkbox" name="vw_bank" id="vw_bank"></td>
                            <td class="text-center"><input type="checkbox" name="ed_bank" id="ed_bank"></td>
                            <td class="text-center"><input type="checkbox" name="pr_bank" id="pr_bank"></td>
                            <td class="text-center"><input type="checkbox" name="dl_bank" id="dl_bank"></td>          
                        </tr>
                        <tr>
                            <td colspan="2"><b>Leasing</b></td>
                            <td class="text-center"><input type="checkbox" name="vw_lease" id="vw_lease"></td>
                            <td class="text-center"><input type="checkbox" name="ed_lease" id="ed_lease"></td>
                            <td class="text-center"><input type="checkbox" name="pr_lease" id="pr_lease"></td>
                            <td class="text-center"><input type="checkbox" name="dl_lease" id="dl_lease"></td>          
                        </tr>
                        <tr>
                            <td colspan="2"><b>Agent</b></td>
                            <td class="text-center"><input type="checkbox" name="vw_agent" id="vw_agent"></td>
                            <td class="text-center"><input type="checkbox" name="ed_agent" id="ed_agent"></td>
                            <td class="text-center"><input type="checkbox" name="pr_agent" id="pr_agent"></td>
                            <td class="text-center"><input type="checkbox" name="dl_agent" id="dl_agent"></td>          
                        </tr>
                        <tr>
                            <td colspan="2"><b>Prospective Customer</b></td>
                            <td class="text-center"><input type="checkbox" name="vw_vehpcus" id="vw_vehpcus"></td>
                            <td class="text-center"><input type="checkbox" name="ed_vehpcus" id="ed_vehpcus"></td>
                            <td class="text-center"><input type="checkbox" name="pr_vehpcus" id="pr_vehpcus"></td>
                            <td class="text-center"><input type="checkbox" name="dl_vehpcus" id="dl_vehpcus"></td>          
                        </tr>
                    </table>
                </div>

                <div title="<?php getCaption("Kasir"); ?>" class="main-tab">
                    <table style="margin-top: 10px;">
                        <tr>
                            <td></td>
                            <td width="300"></td>
                            <td width="70"><b>View</b></td>
                            <td width="70"><b>Edit</b></td>
                            <td width="70"><b>Print</b></td>
                            <td width="70"><b>Delete</b></td>
                            <td width="70"><b>Close</b></td>
                            <td width="70"><b>Unclose</b></td>
                            <td width="70"><b>Export</b></td>
                        </tr>
                        <tr><td colspan="9"></td></tr><tr><td colspan="9"></td></tr>
                        <tr>
                            <td colspan="9"><b><?php getCaption("Kasir"); ?></b></td>
                        </tr>
                        <tr>
                            <td style="padding-left:10px;">1.</td>
                            <td>Account Payable Payment</td>
                            <td class="text-center"><input type="checkbox" name="vw_vehap" id="vw_vehap" class="vw_vehap" onclick="checklistChashier('vw_vehap');"></td>
                            <td class="text-center"><input type="checkbox" name="ed_vehap" id="ed_vehap" class="ed_vehap" onclick="checklistChashier('ed_vehap');"></td>
                            <td class="text-center"><input type="checkbox" name="pr_vehap" id="pr_vehap" class="pr_vehap" onclick="checklistChashier('pr_vehap');"></td>
                            <td class="text-center"><input type="checkbox" name="dl_vehap" id="dl_vehap" class="dl_vehap" onclick="checklistChashier('dl_vehap');"></td>   
                            <td></td>
                            <td></td>  
                            <td class="text-center"><input type="checkbox" name="xp_vehap" id="xp_vehap"></td>        
                        </tr>
                        <tr>
                            <td style="padding-left:10px;">2.</td>
                            <td>Account Receivable Payment</td>
                            <td class="text-center"><input type="checkbox" name="vw_vehar" id="vw_vehar" class="vw_vehar" onclick="checklistChashier('vw_vehar');"></td>
                            <td class="text-center"><input type="checkbox" name="ed_vehar" id="ed_vehar" class="ed_vehar" onclick="checklistChashier('ed_vehar');"></td>
                            <td class="text-center"><input type="checkbox" name="pr_vehar" id="pr_vehar" class="pr_vehar" onclick="checklistChashier('pr_vehar');"></td>
                            <td class="text-center"><input type="checkbox" name="dl_vehar" id="dl_vehar" class="dl_vehar" onclick="checklistChashier('dl_vehar');"></td>   
                            <td></td>
                            <td></td>  
                            <td class="text-center"><input type="checkbox" name="xp_vehar" id="xp_vehar"></td>        
                        </tr>
                        <tr>
                            <td style="padding-left:10px;">3.</td>
                            <td>Booking Fee</td>
                            <td class="text-center"><input type="checkbox" name="vw_vehdpc" id="vw_vehdpc"></td>
                            <td class="text-center"><input type="checkbox" name="ed_vehdpc" id="ed_vehdpc"></td>
                            <td class="text-center"><input type="checkbox" name="pr_vehdpc" id="pr_vehdpc"></td>
                            <td class="text-center"><input type="checkbox" name="dl_vehdpc" id="dl_vehdpc"></td>   
                            <td></td>
                            <td></td>  
                            <td class="text-center"><input type="checkbox" name="xp_vehdpc" id="xp_vehdpc"></td>        
                        </tr>
                        <tr>
                            <td style="padding-left:10px;">4.</td>
                            <td>Booking Fee Cancellation</td>
                            <td class="text-center"><input type="checkbox" name="vw_vehdpcc" id="vw_vehdpcc"></td>
                            <td class="text-center"><input type="checkbox" name="ed_vehdpcc" id="ed_vehdpcc"></td>
                            <td class="text-center"><input type="checkbox" name="pr_vehdpcc" id="pr_vehdpcc"></td>
                            <td class="text-center"><input type="checkbox" name="dl_vehdpcc" id="dl_vehdpcc"></td>
                            <td class="text-center"><input type="checkbox" name="cl_vehdpcc" id="cl_vehdpcc"></td>
                            <td class="text-center"><input type="checkbox" name="uc_vehdpcc" id="uc_vehdpcc"></td>
                            <td class="text-center"><input type="checkbox" name="xp_vehdpcc" id="xp_vehdpcc"></td>
                        </tr>
                        <tr><td colspan="7"></td></tr><tr><td colspan="7"></td></tr>
                        <tr><td colspan="7"></td></tr><tr><td colspan="7"></td></tr>
                        <tr>
                            <td style="padding-left:10px;">5.</td>
                            <td>Voucher Vehicle Payable</td>
                            <td class="text-center"><input type="checkbox" name="vw_vehapv" id="vw_vehapv"></td>
                            <td class="text-center"><input type="checkbox" name="ed_vehapv" id="ed_vehapv"></td>
                            <td class="text-center"><input type="checkbox" name="pr_vehapv" id="pr_vehapv"></td>
                            <td class="text-center"><input type="checkbox" name="dl_vehapv" id="dl_vehapv"></td>
                            <td class="text-center"><input type="checkbox" name="cl_vehapv" id="cl_vehapv"></td>
                            <td class="text-center"><input type="checkbox" name="uc_vehapv" id="uc_vehapv"></td>
                        </tr>
                        <tr>
                            <td style="padding-left:10px;">2.</td>
                            <td>Booking Fee Supplier</td>
                            <td class="text-center"><input type="checkbox" name="vw_vehdps" id="vw_vehdps" class="vw_vehdps" onclick="checklistChashier('vw_vehdps');"></td>
                            <td class="text-center"><input type="checkbox" name="ed_vehdps" id="ed_vehdps" class="ed_vehdps" onclick="checklistChashier('ed_vehdps');"></td>
                            <td class="text-center"><input type="checkbox" name="pr_vehdps" id="pr_vehdps" class="pr_vehdps" onclick="checklistChashier('pr_vehdps');"></td>
                            <td class="text-center"><input type="checkbox" name="dl_vehdps" id="dl_vehdps" class="dl_vehdps" onclick="checklistChashier('dl_vehdps');"></td>   
                            <td></td>
                            <td></td>  
                            <td class="text-center"><input type="checkbox" name="xp_vehdps" id="xp_vehdps"></td>        
                        </tr>
                        <tr>
                            <td style="padding-left:10px;">6.</td>
                            <td>Booking Fee Supplier Group Payment</td>
                            <td class="text-center"><input type="checkbox" name="vw_vehdpsg" id="vw_vehdpsg" class="vw_vehdps" onclick="checklistChashier('vw_vehdps');"></td>
                            <td class="text-center"><input type="checkbox" name="ed_vehdpsg" id="ed_vehdpsg" class="ed_vehdps" onclick="checklistChashier('ed_vehdps');"></td>
                            <td class="text-center"><input type="checkbox" name="pr_vehdpsg" id="pr_vehdpsg" class="pr_vehdps" onclick="checklistChashier('pr_vehdps');"></td>
                            <td class="text-center"><input type="checkbox" name="dl_vehdpsg" id="dl_vehdpsg" class="dl_vehdps" onclick="checklistChashier('dl_vehdps');"></td>
                            <td class="text-center"><input type="checkbox" name="cl_vehdpsg" id="cl_vehdpsg"></td>
                            <td class="text-center"><input type="checkbox" name="uc_vehdpsg" id="uc_vehdpsg"></td>
                        </tr>
                        <tr>
                            <td style="padding-left:10px;">6.</td>
                            <td>Vehicle Account Payable Group Payment</td>
                            <td class="text-center"><input type="checkbox" name="vw_vehapg" id="vw_vehapg" class="vw_vehap" onclick="checklistChashier('vw_vehap');"></td>
                            <td class="text-center"><input type="checkbox" name="ed_vehapg" id="ed_vehapg" class="ed_vehap" onclick="checklistChashier('ed_vehap');"></td>
                            <td class="text-center"><input type="checkbox" name="pr_vehapg" id="pr_vehapg" class="pr_vehap" onclick="checklistChashier('pr_vehap');"></td>
                            <td class="text-center"><input type="checkbox" name="dl_vehapg" id="dl_vehapg" class="dl_vehap" onclick="checklistChashier('dl_vehap');"></td>
                            <td class="text-center"><input type="checkbox" name="cl_vehapg" id="cl_vehapg"></td>
                            <td class="text-center"><input type="checkbox" name="uc_vehapg" id="uc_vehapg"></td>
                        </tr>
                        <tr>
                            <td style="padding-left:10px;">7.</td>
                            <td>Vehicle Account Receivable Group Payment</td>
                            <td class="text-center"><input type="checkbox" name="vw_veharg" id="vw_veharg" class="vw_vehar" onclick="checklistChashier('vw_vehar');"></td>
                            <td class="text-center"><input type="checkbox" name="ed_veharg" id="ed_veharg" class="ed_vehar" onclick="checklistChashier('ed_vehar');"></td>
                            <td class="text-center"><input type="checkbox" name="pr_veharg" id="pr_veharg" class="pr_vehar" onclick="checklistChashier('pr_vehar');"></td>
                            <td class="text-center"><input type="checkbox" name="dl_veharg" id="dl_veharg" class="dl_vehar" onclick="checklistChashier('dl_vehar');"></td>
                            <td class="text-center"><input type="checkbox" name="cl_veharg" id="cl_veharg"></td>
                            <td class="text-center"><input type="checkbox" name="uc_veharg" id="uc_veharg"></td>
                        </tr>
                        <tr><td colspan="9"></td></tr><tr><td colspan="9"></td></tr>
                        <tr><td colspan="9"></td></tr><tr><td colspan="9"></td></tr>

                        <tr>
                            <td colspan="9"><b>History</b></td>
                        </tr>
                        <tr>
                            <td style="padding-left:10px;">1.</td>
                            <td>Account Receivable Payment</td>
                            <td class="text-center"><input type="checkbox" name="vw_veharhs" id="vw_veharhs"></td>
                            <td class="text-center"></td>
                            <td class="text-center"><input type="checkbox" name="pr_veharhs" id="pr_veharhs"></td>
                        </tr>
                        <tr>
                            <td style="padding-left:10px;">2.</td>
                            <td>Account Payable Payment</td>
                            <td class="text-center"><input type="checkbox" name="vw_vehaphs" id="vw_vehaphs"></td>
                            <td class="text-center"></td>
                            <td class="text-center"><input type="checkbox" name="pr_vehaphs" id="pr_vehaphs"></td>
                        </tr>
                    </table>
                </div>

                <div title="<?php getCaption("Analisa"); ?>" class="main-tab">
                    <table style="margin-top: 10px;">
                        <tr>
                            <td width="250"></td>
                            <td width="70"><b>View</b></td>
                            <td width="70"><b>Edit</b></td>
                            <td width="70"><b>Print</b></td>
                            <td width="70"><b>Delete</b></td>
                            <td width="70"><b>Export</b></td>
                        </tr>
                        <tr><td colspan="6"></td></tr><tr><td colspan="6"></td></tr>
                        <tr>
                            <td><b>Vehicle Profit Loss (Total)</b></td>
                            <td class="text-center"><input type="checkbox" name="vw_vehrl" id="vw_vehrl"></td>
                            <td class="text-center"></td>
                            <td class="text-center"><input type="checkbox" name="pr_vehrl" id="pr_vehrl"></td>
                            <td class="text-center"></td>
                            <td class="text-center"><input type="checkbox" name="xp_vehrl" id="xp_vehrl"></td>
                        </tr>
                        <tr><td colspan="6"></td></tr><tr><td colspan="6"></td></tr>
                        <tr>
                            <td style="padding-left: 10px;">Vehicle Profit Loss Dealer</td>
                            <td class="text-center"><input type="checkbox" name="vw_vehrld" id="vw_vehrld"></td>
                            <td class="text-center"></td>
                            <td class="text-center"><input type="checkbox" name="pr_vehrld" id="pr_vehrld"></td>
                            <td class="text-center"></td>
                            <td class="text-center"><input type="checkbox" name="xp_vehrld" id="xp_vehrld"></td>
                        </tr>
                        <tr>
                            <td style="padding-left: 10px;">Vehicle Profit Loss Main Dealer</td>
                            <td class="text-center"><input type="checkbox" name="vw_vehrlm" id="vw_vehrlm"></td>
                            <td class="text-center"></td>
                            <td class="text-center"><input type="checkbox" name="pr_vehrlm" id="pr_vehrlm"></td>
                            <td class="text-center"></td>
                            <td class="text-center"><input type="checkbox" name="xp_vehrlm" id="xp_vehrlm"></td>
                        </tr>
                    </table>
                </div>

                <div title="<?php getCaption("Form & Document"); ?>" class="main-tab">
                    <table style="margin-top: 10px;">
                        <tr>
                            <td width="280"></td>
                            <td width="70"><b>View</b></td>
                            <td width="70"><b>Edit</b></td>
                            <td width="70"><b>Print</b></td>
                            <td width="70"><b>Delete</b></td>
                            <td width="70"><b>Close</b></td>
                            <td width="70"><b>Unclose</b></td>
                            <td width="70"><b>Cancel</b></td>
                            <td width="70"><b>Export</b></td>
                            <td width="100"><b>Generate No</b></td>
                        </tr>
                        <tr><td colspan="10"></td></tr>
                        <tr><td colspan="10"></td></tr>

                        <tr><td colspan="10"><b>Vehicle Form</b></td></tr>
                        <tr><td colspan="10"></td></tr>
                        <tr>
                            <td style="padding-left:10px;"><b>SPK</b></td>
                            <td class="text-center"><input type="checkbox" name="vw_vehspk2" id="vw_vehspk2"></td>
                            <td class="text-center"></td>
                            <td class="text-center"><input type="checkbox" name="pr_vehspk2" id="pr_vehspk2"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"><input type="checkbox" name="cn_vehspk2" id="cn_vehspk2"></td>
                            <td class="text-center"><input type="checkbox" name="xp_vehspk2" id="xp_vehspk2"></td>
                            <td class="text-center"></td>
                        </tr>
                        <tr>
                            <td style="padding-left:10px;"><b>Delivery Order</b></td>
                            <td class="text-center"><input type="checkbox" name="vw_vehsj" id="vw_vehsj"></td>
                            <td class="text-center"></td>
                            <td class="text-center"><input type="checkbox" name="pr_vehsj" id="pr_vehsj"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"><input type="checkbox" name="cn_vehsj" id="cn_vehsj"></td>
                            <td class="text-center"><input type="checkbox" name="xp_vehsj" id="xp_vehsj"></td>
                            <td class="text-center"></td>
                        </tr>
                        <tr>
                            <td style="padding-left:10px;"><b>Full Invoice</b></td>
                            <td class="text-center"><input type="checkbox" name="vw_vehkw" id="vw_vehkw"></td>
                            <td class="text-center"></td>
                            <td class="text-center"><input type="checkbox" name="pr_vehkw" id="pr_vehkw"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"><input type="checkbox" name="cn_vehkw" id="cn_vehkw"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                        </tr>
                        <tr>
                            <td style="padding-left:10px;"><b>Invoice/Payment</b></td>
                            <td class="text-center"><input type="checkbox" name="vw_vehkwd" id="vw_vehkwd"></td>
                            <td></td>
                            <td class="text-center"><input type="checkbox" name="pr_vehkwd" id="pr_vehkwd"></td>
                        </tr>

                        <tr><td colspan="10"></td></tr>
                        <tr><td colspan="10"></td></tr>
                        <tr><td colspan="10"></td></tr>
                        <tr><td colspan="10"></td></tr>
                        <tr>
                            <td style="padding-left:10px;"><b>Temporary Receipts/Payment</b></td>
                            <td class="text-center"><input type="checkbox" name="vw_vehttd" id="vw_vehttd"></td>
                            <td></td>
                            <td class="text-center"><input type="checkbox" name="pr_vehttd" id="pr_vehttd"></td>
                        </tr>
                        <tr>
                            <td style="padding-left:10px;"><b>Tax Invoice</b></td>
                            <td class="text-center"><input type="checkbox" name="vw_vehfp" id="vw_vehfp"></td>
                            <td class="text-center"><input type="checkbox" name="ed_vehfp" id="ed_vehfp"></td>
                            <td class="text-center"><input type="checkbox" name="pr_vehfp" id="pr_vehfp"></td>
                            <td class="text-center"><input type="checkbox" name="dl_vehfp" id="dl_vehfp"></td>
                            <td class="text-center"><input type="checkbox" name="cl_vehfp" id="cl_vehfp"></td>
                            <td class="text-center"><input type="checkbox" name="uc_vehfp" id="uc_vehfp"></td>
                            <td class="text-center"></td>
                            <td class="text-center"><input type="checkbox" name="xp_vehfp" id="xp_vehfp"></td>
                            <td class="text-center"><input type="checkbox" name="gn_vehfp" id="gn_vehfp"></td>
                        </tr>
                        <tr>
                            <td style="padding-left:10px;"><b>Vehicle Status</b></td>
                            <td class="text-center"><input type="checkbox" name="vw_vehsost" id="vw_vehsost"></td>
                            <td></td>
                            <td class="text-center"><input type="checkbox" name="pr_vehsost" id="pr_vehsost"></td>
                        </tr>
                        <tr><td colspan="10"></td></tr><tr><td colspan="10"></td></tr>
                        <tr>
                            <td style="padding-left:10px;" colspan="10"><b>Vehicle Setting Form</b></td>
                        </tr>
                        <tr>
                            <td style="padding-left:25px;">Delivery Order (Additional Items)</td>
                            <td class="text-center"><input type="checkbox" name="vw_vehsjit" id="vw_vehsjit"></td>
                            <td class="text-center"><input type="checkbox" name="ed_vehsjit" id="ed_vehsjit"></td>
                        </tr>
                        <tr><td colspan="10"></td></tr><tr><td colspan="10"></td></tr>
                        <tr><td colspan="10"></td></tr><tr><td colspan="10"></td></tr>
                        <tr>
                            <td style="padding-left:10px;"><b>Credit Application</b></td>
                            <td class="text-center"><input type="checkbox" name="vw_crdappl" id="vw_crdappl"></td>
                            <td class="text-center"><input type="checkbox" name="ed_crdappl" id="ed_crdappl"></td>
                            <td class="text-center"><input type="checkbox" name="pr_crdappl" id="pr_crdappl"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"><input type="checkbox" name="xp_crdappl" id="xp_crdappl"></td>
                            <td class="text-center"></td>
                        </tr>
                        <tr>
                            <td style="padding-left:10px;"><b>STNK/BPKB Application</b></td>
                            <td class="text-center"><input type="checkbox" name="vw_vehdoc" id="vw_vehdoc"></td>
                            <td class="text-center"><input type="checkbox" name="ed_vehdoc" id="ed_vehdoc"></td>
                            <td class="text-center"><input type="checkbox" name="pr_vehdoc" id="pr_vehdoc"></td>
                            <td class="text-center"><input type="checkbox" name="dl_vehdoc" id="dl_vehdoc"></td>
                            <td class="text-center"><input type="checkbox" name="cl_vehdoc" id="cl_vehdoc"></td>
                            <td class="text-center"><input type="checkbox" name="uc_vehdoc" id="uc_vehdoc"></td>
                            <td class="text-center"></td>
                            <td class="text-center"><input type="checkbox" name="xp_vehdoc" id="xp_vehdoc"></td>

                        </tr>
                        <tr><td colspan="10"></td></tr><tr><td colspan="10"></td></tr>
                        <tr><td colspan="10"></td></tr><tr><td colspan="10"></td></tr>
                        <tr>
                            <td style="padding-left:10px;"><b>BBN Work Order</b></td>
                            <td class="text-center"><input type="checkbox" name="vw_vehbwo" id="vw_vehbwo"></td>
                            <td class="text-center"><input type="checkbox" name="ed_vehbwo" id="ed_vehbwo"></td>
                            <td class="text-center"><input type="checkbox" name="pr_vehbwo" id="pr_vehbwo"></td>
                            <td class="text-center"><input type="checkbox" name="dl_vehbwo" id="dl_vehbwo"></td>
                            <td class="text-center"><input type="checkbox" name="cl_vehbwo" id="cl_vehbwo"></td>
                            <td class="text-center"><input type="checkbox" name="uc_vehbwo" id="uc_vehbwo"></td>
                            <td class="text-center"></td>
                            <td class="text-center"><input type="checkbox" name="xp_vehbwo" id="xp_vehbwo"></td>

                        </tr>
                        <tr>
                            <td style="padding-left:10px;"><b>BBN Registration</b></td>
                            <td class="text-center"><input type="checkbox" name="vw_vehbpr" id="vw_vehbpr"></td>
                            <td class="text-center"><input type="checkbox" name="ed_vehbpr" id="ed_vehbpr"></td>
                            <td class="text-center"><input type="checkbox" name="pr_vehbpr" id="pr_vehbpr"></td>
                            <td class="text-center"><input type="checkbox" name="dl_vehbpr" id="dl_vehbpr"></td>
                            <td class="text-center"><input type="checkbox" name="cl_vehbpr" id="cl_vehbpr"></td>
                            <td class="text-center"><input type="checkbox" name="uc_vehbpr" id="uc_vehbpr"></td>
                            <td class="text-center"></td>
                            <td class="text-center"><input type="checkbox" name="xp_vehbpr" id="xp_vehbpr"></td>

                        </tr>
                    </table>
                </div>


            </div>

            <div class=" main-nav">
                <table class="table" style="width:500px;" border="0">
                    <tr>

                        <td style="border-top:0px !important;">
                            <button type="button" id="cmdSave" title="Save"  data-options="iconCls:'icon-save',group:'g2'" class="easyui-linkbutton cmdSave" onclick="saveData2('form_validation2');"> Save</button>
                            <button type="button" id="cmdCancel" title="Batal" data-options="iconCls:'icon-undo',group:'g2'" class="easyui-linkbutton cmdCancel"  onclick="condCancel2('form_validation2');"> Cancel</button>
                            <button type="button" id="cmdEdit" title="<?php getCaption("Ubah"); ?>" data-options="iconCls:'icon-edit'" class="easyui-linkbutton cmdEdit"  onclick="condEdit2('form_validation2');" > Edit</button>
                            <button type="button" id="cmdDelete" title="<?php getCaption("Hapus"); ?>" data-options="iconCls:'icon-no'" class="easyui-linkbutton cmdDelete"  onclick=" condDelete2('usr_veh', 'form_validation2');" ></button>
                            <button type="button" id="cmdClose" title="<?php getCaption("Close"); ?>" data-options="iconCls:'icon-ok'" class="easyui-linkbutton cmdClose"  onclick=" $('#veh1Window').window('close');" > Ok</button>
                        </td>

                    </tr>
                </table> 
            </div>

        </form>
    </div>
</div>
<style>
    #form_validation2 a{text-decoration:none !important;color:#000;}
</style>
<script>
    
    
    
    function checklistChashier(div){ //alert(div)
        var this_form = $('.'+div);
        
       // this_form.click(function () {
        if (this_form.prop("checked") == true) {
            this_form.prop("checked", true);
            this_form.val(1);
            
        }
        else if (this_form.prop("checked") == false) {
            this_form.prop("checked", false);
            this_form.val(0);
        }
        
    //});
    }
    
    function vehone() {
        //var id = $("#form_validation #id").val();
        var user = $("#form_validation #username").val();
        
        $("#form_validation2 #username").val($("#form_validation #username").val());
        $("#form_validation2 #userrole").val($("#form_validation #userrole").val());
        
        
        $("#form_validation2 input:checkbox").prop("checked", false);

        $.post(site_url + 'transaction/setting/read_access/', {table: 'usr_veh', nav: '', id: '', user: user}, function (json) {
            formDisabled2('form_validation2');
                        
            if (json !== '[]') {
                var rowData = $.parseJSON(json);

                $("#form_validation2 .id").val(rowData.id);
                
                
                $.each(rowData, function (i, v) {
                    if(i == 'vw_vehspk' || i == 'pr_vehspk' || i == 'cn_vehspk' || i == 'xp_vehspk'){
                          if (v == '1') {
                            $("#form_validation2 #" + i+'2').prop("checked", true);
                          }
                    }
                    if (i == 'vw_vehap' || i == 'ed_vehap' || i == 'pr_vehap' || i == 'dl_vehap') {
                        if (v == '1') {
                            $("#form_validation2 #" + i + 'g').prop("checked", true);
                            $("#form_validation2 #" + i + 'g').val(1);
                        }
                    }
                    if (i == 'vw_vehar' || i == 'ed_vehar' || i == 'pr_vehar' || i == 'dl_vehar') {
                        if (v == '1') {
                            $("#form_validation2 #" + i + 'g').prop("checked", true);
                            $("#form_validation2 #" + i + 'g').val(1);
                        }
                    }
                    if (i == 'vw_vehdps' || i == 'ed_vehdps' || i == 'pr_vehdps' || i == 'dl_vehdps') {
                        if (v == '1') {
                            $("#form_validation2 #" + i + 'g').prop("checked", true);
                            $("#form_validation2 #" + i + 'g').val(1);
                        }
                    }
                    if (v == '1') {
                        $("#form_validation2 #" + i).prop("checked", true);
                        $("#form_validation2 #" + i).val(1);
                    }


                });

                $('#form_validation2 #unmtch_pos_' + rowData.unmtch_pos).prop("checked", true);
            }else{
               
                deletedisable('form_validation2');
            }

        });
    }

    function openVehOne() {
        $('#veh1Window').window('open');
        vehone();
    }
</script>