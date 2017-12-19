<div id="accWindow" class="easyui-window" title="User Access: Accessories" data-options="closable:true,minimizable:false,maximizable:false,collapsible:false,closed:true,modal:true,closed:true,inline:true" style="width:1050px;height: 600px;padding:10px;top:1;">
    <div style="width: 1000px; margin: 5px;">
        <form id="form_validation4" method="post" >           
            <table class="main-form" style="width: 100% !important;">
                <tr>
                    <td width="100"><table><?php textbox('username', 'Username', 150, 70); ?></table></td>
                    <td width="200"><table><?php textbox('userrole', 'User Role', 150, 70); ?></table></td>
                    <td width="200"><table><tr><td><input type="checkbox" id="checkAll"> Check All</td></tr></table></td>
                </tr>
            </table>
            <input type="hidden"  name="table" value="usr_acc">
            <input type="hidden"  name="id" class="id">

            <div class="easyui-tabs">
                <div title="<?php getCaption("Order Barang, Order Kerja / Optional"); ?>" class="main-tab">
                    <table style="margin-top: 10px;">
                        <tr>
                            <td></td>
                            <td width="250"></td>
                            <td width="70" valign="top"><b>View</b></td>
                            <td width="70" valign="top"><b>Edit</b></td>
                            <td width="70" valign="top"><b>Print</b></td>
                            <td width="70" valign="top"><b>Delete</b></td>
                            <td width="70" valign="top"><b>Close</b></td>
                            <td width="70" valign="top"><b>Unclose</b></td>
                            <td width="70" valign="top"><b>Export</b></td>
                        </tr>
                        <tr><td colspan="9"></td></tr><tr><td colspan="9"></td></tr>
                        <tr><td colspan="9"></td></tr><tr><td colspan="9"></td></tr>

                        <tr><td colspan="9"><b>Order Barang</b></td></tr>
                        <tr><td colspan="9"></td></tr><tr><td colspan="9"></td></tr>

                        <tr>
                            <td style="padding-left:10px;">1.</td>
                            <td>Request Item Order(POB)</td>
                            <td class="text-center"><input type="checkbox" name="vw_prtpor" id="vw_prtpor"></td>
                            <td class="text-center"><input type="checkbox" name="ed_prtpor" id="ed_prtpor"></td>
                            <td class="text-center"><input type="checkbox" name="pr_prtpor" id="pr_prtpor"></td>
                            <td class="text-center"><input type="checkbox" name="dl_prtpor" id="dl_prtpor"></td>
                            <td class="text-center"><input type="checkbox" name="cl_prtpor" id="cl_prtpor"></td>
                            <td class="text-center"><input type="checkbox" name="uc_prtpor" id="uc_prtpor"></td>
                            <td class="text-center"><input type="checkbox" name="xp_prtpor" id="xp_prtpor"></td>
                        </tr>
                        <tr>
                            <td style="padding-left:10px;">2.</td>
                            <td>Purchase Order (PO)</td>
                            <td class="text-center"><input type="checkbox" name="vw_prtpo" id="vw_prtpo"></td>
                            <td class="text-center"><input type="checkbox" name="ed_prtpo" id="ed_prtpo"></td>
                            <td class="text-center"><input type="checkbox" name="pr_prtpo" id="pr_prtpo"></td>
                            <td class="text-center"><input type="checkbox" name="dl_prtpo" id="dl_prtpo"></td>
                            <td class="text-center"><input type="checkbox" name="cl_prtpo" id="cl_prtpo"></td>
                            <td class="text-center"><input type="checkbox" name="uc_prtpo" id="uc_prtpo"></td>
                            <td class="text-center"><input type="checkbox" name="xp_prtpo" id="xp_prtpo"></td>
                        </tr>
                        <tr>
                            <td style="padding-left:10px;">3.</td>
                            <td>Outstanding POB</td>
                            <td class="text-center"><input type="checkbox" name="vw_prtporo" id="vw_prtporo"></td>
                            <td class="text-center"></td>
                            <td class="text-center"><input type="checkbox" name="pr_prtporo" id="pr_prtporo"></td>
                        </tr>
                        <tr>
                            <td style="padding-left:10px;">4.</td>
                            <td>Outstanding PO</td>
                            <td class="text-center"><input type="checkbox" name="vw_prtpoo" id="vw_prtpoo"></td>
                            <td class="text-center"></td>
                            <td class="text-center"><input type="checkbox" name="pr_prtpoo" id="pr_prtpoo"></td>
                        </tr>

                        <tr><td colspan="9"></td></tr><tr><td colspan="9"></td></tr>
                        <tr><td colspan="9"></td></tr><tr><td colspan="9"></td></tr>

                        <tr><td colspan="9"><b>Order Kerja / Optional</b></td></tr>
                        <tr><td colspan="9"></td></tr><tr><td colspan="9"></td></tr>

                        <tr>
                            <td style="padding-left:10px;">1.</td>
                            <td>Request Work Order (POK)</td>
                            <td class="text-center"><input type="checkbox" name="vw_prtwor" id="vw_prtwor"></td>
                            <td class="text-center"><input type="checkbox" name="ed_prtwor" id="ed_prtwor"></td>
                            <td class="text-center"><input type="checkbox" name="pr_prtwor" id="pr_prtwor"></td>
                            <td class="text-center"><input type="checkbox" name="dl_prtwor" id="dl_prtwor"></td>
                            <td class="text-center"><input type="checkbox" name="cl_prtwor" id="cl_prtwor"></td>
                            <td class="text-center"><input type="checkbox" name="uc_prtwor" id="uc_prtwor"></td>
                            <td class="text-center"><input type="checkbox" name="xp_prtwor" id="xp_prtwor"></td>
                        </tr>
                        <tr>
                            <td style="padding-left:10px;">2.</td>
                            <td>Work Order (WO) / Optional</td>
                            <td class="text-center"><input type="checkbox" name="vw_prtwo" id="vw_prtwo"></td>
                            <td class="text-center"><input type="checkbox" name="ed_prtwo" id="ed_prtwo"></td>
                            <td class="text-center"><input type="checkbox" name="pr_prtwo" id="pr_prtwo"></td>
                            <td class="text-center"><input type="checkbox" name="dl_prtwo" id="dl_prtwo"></td>
                            <td class="text-center"><input type="checkbox" name="cl_prtwo" id="cl_prtwo"></td>
                            <td class="text-center"><input type="checkbox" name="uc_prtwo" id="uc_prtwo"></td>
                            <td class="text-center"><input type="checkbox" name="xp_prtwo" id="xp_prtwo"></td>
                        </tr>
                        <tr>
                            <td style="padding-left:10px;">3.</td>
                            <td>Outstanding POK</td>
                            <td class="text-center"><input type="checkbox" name="vw_prtworo" id="vw_prtworo"></td>
                            <td class="text-center"></td>
                            <td class="text-center"><input type="checkbox" name="pr_prtworo" id="pr_prtworo"></td>
                        </tr>
                        <tr>
                            <td style="padding-left:10px;">4.</td>
                            <td>Outstanding WO</td>
                            <td class="text-center"><input type="checkbox" name="vw_prtwoo" id="vw_prtwoo"></td>
                            <td class="text-center"></td>
                            <td class="text-center"><input type="checkbox" name="pr_prtwoo" id="pr_prtwoo"></td>
                        </tr>
                        <tr><td colspan="9"></td></tr><tr><td colspan="9"></td></tr>
                        <tr><td colspan="9"></td></tr><tr><td colspan="9"></td></tr>
                    </table>
                </div>
                <div title="<?php getCaption("Transaksi Barang"); ?>" class="main-tab">
                    <table style="margin-top: 10px;">
                        <tr>
                            <td></td>
                            <td width="250"></td>
                            <td width="70" valign="top"><b>View</b></td>
                            <td width="70" valign="top"><b>Edit</b></td>
                            <td width="70" valign="top"><b>Print</b></td>
                            <td width="70" valign="top"><b>Delete</b></td>
                            <td width="70" valign="top"><b>Close</b></td>
                            <td width="70" valign="top"><b>Unclose</b></td>
                            <td width="70" valign="top"><b>Export</b></td>
                        </tr>
                        <tr><td colspan="9"></td></tr><tr><td colspan="9"></td></tr>
                        <tr><td colspan="9"></td></tr><tr><td colspan="9"></td></tr>

                        <tr><td colspan="9"><b><?php getCaption("Transaksi Barang"); ?></b></td></tr>
                        <tr><td colspan="9"></td></tr><tr><td colspan="9"></td></tr>

                        <tr>
                            <td style="padding-left: 10px;">1. </td>
                            <td>Accessories Sales</td>
                            <td colspan="6"></td>
                            <td class="text-center"><input type="checkbox" name="pr_prtslh" id="pr_prtslh"></td>
                        </tr>
                        <tr>
                            <td style="padding-left: 10px;"></td>
                            <td style="padding-left: 10px;">1. Vehicle</td>
                            <td class="text-center"><input type="checkbox" name="vw_prtvslh" id="vw_prtvslh"></td>
                            <td class="text-center"><input type="checkbox" name="ed_prtvslh" id="ed_prtvslh"></td>
                            <td class="text-center"><input type="checkbox" name="pr_prtvslh" id="pr_prtvslh"></td>
                            <td class="text-center"><input type="checkbox" name="dl_prtvslh" id="dl_prtvslh"></td>
                            <td class="text-center"><input type="checkbox" name="cl_prtvslh" id="cl_prtvslh"></td>
                            <td class="text-center"><input type="checkbox" name="uc_prtvslh" id="uc_prtvslh"></td>
                        </tr>
                        <tr>
                            <td style="padding-left: 10px;"></td>
                            <td style="padding-left: 10px;">2. Counter Sales</td>
                            <td class="text-center"><input type="checkbox" name="vw_prtslh" id="vw_prtslh"></td>
                            <td class="text-center"><input type="checkbox" name="ed_prtslh" id="ed_prtslh"></td>
                            <td class="text-center"><input type="checkbox" name="pr_prtslh" id="pr_prtslh"></td>
                            <td class="text-center"><input type="checkbox" name="dl_prtslh" id="dl_prtslh"></td>
                            <td class="text-center"><input type="checkbox" name="cl_prtslh" id="cl_prtslh"></td>
                            <td class="text-center"><input type="checkbox" name="uc_prtslh" id="uc_prtslh"></td>
                        </tr>
                        <tr><td colspan="9"></td></tr><tr><td colspan="9"></td></tr>
                        <tr>
                            <td style="padding-left: 10px;">2. </td>
                            <td>Receiving</td>
                            <td class="text-center"><input type="checkbox" name="vw_prtrcv" id="vw_prtrcv"></td>
                            <td class="text-center"><input type="checkbox" name="ed_prtrcv" id="ed_prtrcv"></td>
                            <td class="text-center"><input type="checkbox" name="pr_prtrcv" id="pr_prtrcv"></td>
                            <td class="text-center"><input type="checkbox" name="dl_prtrcv" id="dl_prtrcv"></td>
                            <td class="text-center"><input type="checkbox" name="cl_prtrcv" id="cl_prtrcv"></td>
                            <td class="text-center"><input type="checkbox" name="uc_prtrcv" id="uc_prtrcv"></td>
                            <td class="text-center"><input type="checkbox" name="xp_prtrcv" id="xp_prtrcv"></td>
                        </tr>
                        <tr>
                            <td style="padding-left: 10px;">3. </td>
                            <td>Purchase</td>
                            <td class="text-center"><input type="checkbox" name="vw_prtprh" id="vw_prtprh"></td>
                            <td class="text-center"><input type="checkbox" name="ed_prtprh" id="ed_prtprh"></td>
                            <td class="text-center"><input type="checkbox" name="pr_prtprh" id="pr_prtprh"></td>
                            <td class="text-center"><input type="checkbox" name="dl_prtprh" id="dl_prtprh"></td>
                            <td class="text-center"><input type="checkbox" name="cl_prtprh" id="cl_prtprh"></td>
                            <td class="text-center"><input type="checkbox" name="uc_prtprh" id="uc_prtprh"></td>
                            <td class="text-center"><input type="checkbox" name="xp_prtprh" id="xp_prtprh"></td>
                        </tr>
                        <tr>
                            <td style="padding-left: 10px;">4. </td>
                            <td>Opname</td>
                            <td class="text-center"><input type="checkbox" name="vw_prtopnh" id="vw_prtopnh"></td>
                            <td class="text-center"><input type="checkbox" name="ed_prtopnh" id="ed_prtopnh"></td>
                            <td class="text-center"><input type="checkbox" name="pr_prtopnh" id="pr_prtopnh"></td>
                            <td class="text-center"><input type="checkbox" name="dl_prtopnh" id="dl_prtopnh"></td>
                            <td class="text-center"><input type="checkbox" name="cl_prtopnh" id="cl_prtopnh"></td>
                            <td class="text-center"><input type="checkbox" name="uc_prtopnh" id="uc_prtopnh"></td>
                            <td class="text-center"><input type="checkbox" name="xp_prtopnh" id="xp_prtopnh"></td>
                        </tr>
                        <tr>
                            <td style="padding-left: 10px;">5. </td>
                            <td>Sales Return</td>
                            <td class="text-center"><input type="checkbox" name="vw_prtrslh" id="vw_prtrslh"></td>
                            <td class="text-center"><input type="checkbox" name="ed_prtrslh" id="ed_prtrslh"></td>
                            <td class="text-center"><input type="checkbox" name="pr_prtrslh" id="pr_prtrslh"></td>
                            <td class="text-center"><input type="checkbox" name="dl_prtrslh" id="dl_prtrslh"></td>
                            <td class="text-center"><input type="checkbox" name="cl_prtrslh" id="cl_prtrslh"></td>
                            <td class="text-center"><input type="checkbox" name="uc_prtrslh" id="uc_prtrslh"></td>
                            <td class="text-center"><input type="checkbox" name="xp_prtrslh" id="xp_prtrslh"></td>
                        </tr>
                        <tr>
                            <td style="padding-left: 10px;">6. </td>
                            <td>Purchase Return</td>
                            <td class="text-center"><input type="checkbox" name="vw_prtrprh" id="vw_prtrprh"></td>
                            <td class="text-center"><input type="checkbox" name="ed_prtrprh" id="ed_prtrprh"></td>
                            <td class="text-center"><input type="checkbox" name="pr_prtrprh" id="pr_prtrprh"></td>
                            <td class="text-center"><input type="checkbox" name="dl_prtrprh" id="dl_prtrprh"></td>
                            <td class="text-center"><input type="checkbox" name="cl_prtrprh" id="cl_prtrprh"></td>
                            <td class="text-center"><input type="checkbox" name="uc_prtrprh" id="uc_prtrprh"></td>
                            <td class="text-center"><input type="checkbox" name="xp_prtrprh" id="xp_prtrprh"></td>
                        </tr>
                        <tr>
                            <td style="padding-left: 10px;">7. </td>
                            <td>Usage</td>
                            <td class="text-center"><input type="checkbox" name="vw_prtuse" id="vw_prtuse"></td>
                            <td class="text-center"><input type="checkbox" name="ed_prtuse" id="ed_prtuse"></td>
                            <td class="text-center"><input type="checkbox" name="pr_prtuse" id="pr_prtuse"></td>
                            <td class="text-center"><input type="checkbox" name="dl_prtuse" id="dl_prtuse"></td>
                            <td class="text-center"><input type="checkbox" name="cl_prtuse" id="cl_prtuse"></td>
                            <td class="text-center"><input type="checkbox" name="uc_prtuse" id="uc_prtuse"></td>
                            <td class="text-center"><input type="checkbox" name="xp_prtuse" id="xp_prtuse"></td>
                        </tr>
                        <tr>
                            <td style="padding-left: 10px;">8. </td>
                            <td>Movement</td>
                            <td class="text-center"><input type="checkbox" name="vw_prtmov" id="vw_prtmov"></td>
                            <td class="text-center"><input type="checkbox" name="ed_prtmov" id="ed_prtmov"></td>
                            <td class="text-center"><input type="checkbox" name="pr_prtmov" id="pr_prtmov"></td>
                            <td class="text-center"><input type="checkbox" name="dl_prtmov" id="dl_prtmov"></td>
                            <td class="text-center"><input type="checkbox" name="cl_prtmov" id="cl_prtmov"></td>
                            <td class="text-center"><input type="checkbox" name="uc_prtmov" id="uc_prtmov"></td>
                            <td class="text-center"><input type="checkbox" name="xp_prtmov" id="xp_prtmov"></td>

                        </tr>


                        <tr><td colspan="9"></td></tr><tr><td colspan="9"></td></tr>
                        <tr><td colspan="9"></td></tr><tr><td colspan="9"></td></tr>

                        <tr><td colspan="9"><b><?php getCaption("Kartu Transaksi Barang"); ?></b></td></tr>
                        <tr><td colspan="9"></td></tr><tr><td colspan="9"></td></tr>

                        <tr>
                            <td style="padding-left: 10px;">1. </td>
                            <td>By Item Master</td>
                            <td class="text-center"><input type="checkbox" name="vw_prttrxm" id="vw_prttrxm"></td>
                            <td></td>
                            <td class="text-center"><input type="checkbox" name="pr_prttrxm" id="pr_prttrxm"></td>
                            <td colspan="3"></td>
                            <td class="text-center"><input type="checkbox" name="xp_prttrxm" id="xp_prttrxm"></td>
                        </tr>
                        <tr>
                            <td style="padding-left: 10px;">2. </td>
                            <td>By Parts & Warehouse</td>                            
                            <td class="text-center"><input type="checkbox" name="vw_prttrxc" id="vw_prttrxc"></td>
                            <td></td>
                            <td class="text-center"><input type="checkbox" name="pr_prttrxc" id="pr_prttrxc"></td>
                            <td colspan="3"></td>
                            <td class="text-center"><input type="checkbox" name="xp_prttrxc" id="xp_prttrxc"></td>
                        </tr>

                        <tr><td colspan="9"></td></tr><tr><td colspan="9"></td></tr>
                        <tr><td colspan="9"></td></tr><tr><td colspan="9"></td></tr>

                        <tr>
                            <td colspan="2"><b><?php getCaption("History Transaksi Barang"); ?></b></td>
                            <td class="text-center"><input type="checkbox" name="vw_prthst" id="vw_prthst"></td>
                            <td></td>
                            <td class="text-center"><input type="checkbox" name="pr_prthst" id="pr_prthst"></td>
                        </tr>
                        <tr><td colspan="9"></td></tr><tr><td colspan="9"></td></tr>
                    </table>
                </div>
                <div title="<?php getCaption("Master Barang"); ?>" class="main-tab">
                    <table style="margin-top: 10px;">
                        <tr>
                            <td></td>
                            <td width="300"></td>
                            <td width="70" valign="top"><b>View</b></td>
                            <td width="70" valign="top"><b>Edit</b></td>
                            <td width="70" valign="top"><b>Print</b></td>
                            <td width="70" valign="top"><b>Delete</b></td>
                            <td width="70" valign="top"><b>Export</b></td>
                        </tr>
                        <tr><td colspan="7"></td></tr><tr><td colspan="7"></td></tr>
                        <tr><td colspan="7"></td></tr><tr><td colspan="7"></td></tr>

                        <tr><td colspan="7"><b style="font-size: 14px;">Accessories / Optional Master</b></td></tr>
                        <tr><td colspan="7"></td></tr><tr><td colspan="7"></td></tr>

                        <tr>
                            <td style="padding-left:10px;"><b>1.</b></td>
                            <td><b>Customer Master</b></td>
                            <td class="text-center"><input type="checkbox" name="vw_prtcust" id="vw_prtcust"></td>
                            <td class="text-center"><input type="checkbox" name="ed_prtcust" id="ed_prtcust"></td>
                            <td class="text-center"><input type="checkbox" name="pr_prtcust" id="pr_prtcust"></td>
                            <td class="text-center"><input type="checkbox" name="dl_prtcust" id="dl_prtcust"></td>
                            <td class="text-center"><input type="checkbox" name="xp_prtcust" id="xp_prtcust"></td>
                        </tr>
                        <tr>
                            <td style="padding-left:10px;"><b>2.</b></td>
                            <td><b>Supplier Master</b></td>
                            <td class="text-center"><input type="checkbox" name="vw_prtsupp" id="vw_prtsupp"></td>
                            <td class="text-center"><input type="checkbox" name="ed_prtsupp" id="ed_prtsupp"></td>
                            <td class="text-center"><input type="checkbox" name="pr_prtsupp" id="pr_prtsupp"></td>
                            <td class="text-center"><input type="checkbox" name="dl_prtsupp" id="dl_prtsupp"></td>
                            <td class="text-center"><input type="checkbox" name="xp_prtsupp" id="xp_prtsupp"></td>
                        </tr>
                        <tr>
                            <td style="padding-left:10px;"><b>3.</b></td>
                            <td><b>Sales Repsentative Master</b></td>
                            <td class="text-center"><input type="checkbox" name="vw_prtsrep" id="vw_prtsrep"></td>
                            <td class="text-center"><input type="checkbox" name="ed_prtsrep" id="ed_prtsrep"></td>
                            <td class="text-center"><input type="checkbox" name="pr_prtsrep" id="pr_prtsrep"></td>
                            <td class="text-center"><input type="checkbox" name="dl_prtsrep" id="dl_prtsrep"></td>
                            <td class="text-center"><input type="checkbox" name="xp_prtsrep" id="xp_prtsrep"></td>
                        </tr>
                        <tr>
                            <td style="padding-left:10px;"><b>4.</b></td>
                            <td><b>Collector Master</b></td>
                            <td class="text-center"><input type="checkbox" name="vw_prtcoll" id="vw_prtcoll"></td>
                            <td class="text-center"><input type="checkbox" name="ed_prtcoll" id="ed_prtcoll"></td>
                            <td class="text-center"><input type="checkbox" name="pr_prtcoll" id="pr_prtcoll"></td>
                            <td class="text-center"><input type="checkbox" name="dl_prtcoll" id="dl_prtcoll"></td>
                            <td class="text-center"><input type="checkbox" name="xp_prtcoll" id="xp_prtcoll"></td>
                        </tr>
                        <tr>
                            <td style="padding-left:10px;"><b>5.</b></td>
                            <td><b>Purchaser Master</b></td>
                            <td class="text-center"><input type="checkbox" name="vw_prtprep" id="vw_prtprep"></td>
                            <td class="text-center"><input type="checkbox" name="ed_prtprep" id="ed_prtprep"></td>
                            <td class="text-center"><input type="checkbox" name="pr_prtprep" id="pr_prtprep"></td>
                            <td class="text-center"><input type="checkbox" name="dl_prtprep" id="dl_prtprep"></td>
                            <td class="text-center"><input type="checkbox" name="xp_prtprep" id="xp_prtprep"></td>
                        </tr>
                        <tr>
                            <td style="padding-left:10px;"><b>6.</b></td>
                            <td><b>Opname Master</b></td>
                            <td class="text-center"><input type="checkbox" name="vw_prtorep" id="vw_prtorep"></td>
                            <td class="text-center"><input type="checkbox" name="ed_prtorep" id="ed_prtorep"></td>
                            <td class="text-center"><input type="checkbox" name="pr_prtorep" id="pr_prtorep"></td>
                            <td class="text-center"><input type="checkbox" name="dl_prtorep" id="dl_prtorep"></td>
                            <td class="text-center"><input type="checkbox" name="xp_prtorep" id="xp_prtorep"></td>
                        </tr>
                        <tr><td colspan="7"></td></tr><tr><td colspan="7"></td></tr>
                        <tr>
                            <td style="padding-left:10px;"><b>7.</b></td>
                            <td><b>Item Master</b></td>
                        </tr>
                        <tr>
                            <td style="padding-left:10px;"></td>
                            <td  style="padding-left:10px;">1. Item</td>
                            <td class="text-center"><input type="checkbox" name="vw_prtmst" id="vw_prtmst"></td>
                            <td class="text-center"><input type="checkbox" name="ed_prtmst" id="ed_prtmst"></td>
                            <td class="text-center"><input type="checkbox" name="pr_prtmst" id="pr_prtmst"></td>
                            <td class="text-center"><input type="checkbox" name="dl_prtmst" id="dl_prtmst"></td>
                            <td class="text-center"><input type="checkbox" name="xp_prtmst" id="xp_prtmst"></td>
                        </tr>
                        <tr>
                            <td style="padding-left:10px;"></td>
                            <td  style="padding-left:10px;">2. Item by Warehouse</td>
                            <td class="text-center"><input type="checkbox" name="vw_mparts" id="vw_mparts"></td>
                            <td class="text-center"><input type="checkbox" name="ed_mparts" id="ed_mparts"></td>
                            <td class="text-center"><input type="checkbox" name="pr_mparts" id="pr_mparts"></td>
                            <td class="text-center"><input type="checkbox" name="dl_mparts" id="dl_mparts"></td>
                            <td class="text-center"><input type="checkbox" name="xp_mparts" id="xp_mparts"></td>
                        </tr>
                        <tr><td colspan="7"></td></tr><tr><td colspan="7"></td></tr>
                        <tr>
                            <td style="padding-left:10px;"><b>8.</b></td>
                            <td><b>Work/Optional Master</b></td>
                            <td class="text-center"><input type="checkbox" name="vw_prtwkcd" id="vw_prtwkcd"></td>
                            <td class="text-center"><input type="checkbox" name="ed_prtwkcd" id="ed_prtwkcd"></td>
                            <td class="text-center"><input type="checkbox" name="pr_prtwkcd" id="pr_prtwkcd"></td>
                            <td class="text-center"><input type="checkbox" name="dl_prtwkcd" id="dl_prtwkcd"></td>
                            <td class="text-center"><input type="checkbox" name="xp_prtwkcd" id="xp_prtwkcd"></td>
                        </tr>

                        <tr><td colspan="7"></td></tr><tr><td colspan="7"></td></tr>
                        <tr><td colspan="7"></td></tr><tr><td colspan="7"></td></tr>

                        <tr>
                            <td colspan="2"><b style="font-size: 14px;">Purchase Item</b></td>
                            <td class="text-center"><input type="checkbox" name="vw_prtpprc" id="vw_prtpprc"></td>
                            <td class="text-center"><input type="checkbox" name="ed_prtpprc" id="ed_prtpprc"></td>
                            <td class="text-center"><input type="checkbox" name="pr_prtpprc" id="pr_prtpprc"></td>
                            <td class="text-center"><input type="checkbox" name="dl_prtpprc" id="dl_prtpprc"></td>
                        </tr>
                        <tr><td colspan="7"></td></tr><tr><td colspan="7"></td></tr>
                        <tr><td colspan="7"></td></tr><tr><td colspan="7"></td></tr>
                    </table>
                </div>

                <div title="<?php getCaption("Stock Barang"); ?>" class="main-tab">
                    <table style="margin-top: 10px;">
                        <tr>
                            <td></td>
                            <td width="250"></td>
                            <td width="70" valign="top"><b>View</b></td>
                            <td width="70" valign="top"><b>Edit</b></td>
                            <td width="70" valign="top"><b>Print</b></td>
                            <td width="70" valign="top"><b>Delete</b></td>
                            <td width="70" valign="top"><b>Close</b></td>
                            <td width="70" valign="top"><b>Unclose</b></td>
                            <td width="70" valign="top"><b>Export</b></td>
                        </tr>
                        <tr><td colspan="9"></td></tr><tr><td colspan="9"></td></tr>
                        <tr><td colspan="9"></td></tr><tr><td colspan="9"></td></tr>

                        <tr><td colspan="9"><b style="font-size: 14px;"><?php getCaption("Stock Barang"); ?></b></td></tr>
                        <tr><td colspan="9"></td></tr><tr><td colspan="9"></td></tr>

                        <tr>
                            <td style="padding-left:10px;"><b>1.</b> </td>
                            <td><b>Item Stock (By Warehouse)</b></td>
                            <td class="text-center"><input type="checkbox" name="vw_mparts2" id="vw_mparts2"></td>
                            <td></td>
                            <td class="text-center"><input type="checkbox" name="pr_mparts2" id="pr_mparts2"></td>
                            <td colspan="3"></td>
                            <td class="text-center"><input type="checkbox" name="xp_mparts2" id="xp_mparts2"></td>
                        </tr>

                        <tr>
                            <td style="padding-left:10px;"><b>2.</b> </td>
                            <td><b>Item Stock & Substitution</b></td>
                            <td class="text-center"><input type="checkbox" name="vw_prtsubs" id="vw_prtsubs"></td>
                            <td></td>
                            <td class="text-center"><input type="checkbox" name="pr_prtsubs" id="pr_prtsubs"></td>
                            <td colspan="3"></td>
                            <td class="text-center"><!--<input type="checkbox" name="xp_prtsubs" id="xp_prtsubs">--></td>
                        </tr>

                        <tr>
                            <td style="padding-left:10px;"><b>2.</b> </td>
                            <td><b>Minimum Stock</b></td>
                            <td class="text-center"><input type="checkbox" name="vw_prtminq" id="vw_prtminq"></td>
                            <td></td>
                            <td class="text-center"><input type="checkbox" name="pr_prtminq" id="pr_prtminq"></td>
                            <td colspan="3"></td>
                            <td class="text-center"><input type="checkbox" name="xp_prtminq" id="xp_prtminq"></td>
                        </tr>

                        <tr><td colspan="9"></td></tr><tr><td colspan="9"></td></tr>
                        <tr><td colspan="9"></td></tr><tr><td colspan="9"></td></tr>

                        <tr><td colspan="9"><b style="font-size: 14px;">Stock Opname</b></td></tr>
                        <tr><td colspan="9"></td></tr><tr><td colspan="9"></td></tr>

                        <tr>
                            <td style="padding-left:10px;"><b>1.</b> </td>
                            <td><b>Item List for Stock Opname</b></td>
                            <td class="text-center"><input type="checkbox" name="vw_prtsopn" id="vw_prtsopn"></td>
                            <td></td>
                            <td class="text-center"><input type="checkbox" name="pr_prtsopn" id="pr_prtsopn"></td>
                            <td colspan="3"></td>
                            <td class="text-center"><input type="checkbox" name="xp_prtsopn" id="xp_prtsopn"></td>
                        </tr>

                        <tr><td colspan="9"></td></tr><tr><td colspan="9"></td></tr>
                        <tr><td colspan="9"></td></tr><tr><td colspan="9"></td></tr>
                    </table>
                </div>

                <div title="<?php getCaption("Kasir"); ?>" class="main-tab">
                    <table style="margin-top: 10px;">
                        <tr>
                            <td></td>
                            <td width="300"></td>
                            <td width="70" valign="top"><b>View</b></td>
                            <td width="70" valign="top"><b>Edit</b></td>
                            <td width="70" valign="top"><b>Print</b></td>
                            <td width="70" valign="top"><b>Delete</b></td>
                            <td width="70" valign="top"><b>Export</b></td>
                            <td width="70" valign="top"><b>Close</b></td>
                            <td width="70" valign="top"><b>Unclose</b></td>
                        </tr>
                        <tr><td colspan="7"></td></tr><tr><td colspan="7"></td></tr>
                        <tr><td colspan="7"></td></tr><tr><td colspan="7"></td></tr>

                        <tr><td colspan="7"><b style="font-size: 14px;"><?php getCaption("Kasir"); ?></b></td></tr>
                        <tr><td colspan="7"></td></tr><tr><td colspan="7"></td></tr>

                        <tr>
                            <td style="padding-left:10px;"><b>1.</b></td>
                            <td><b>Accessories Payable &  Payment</b></td>
                            <td class="text-center"><input type="checkbox" name="vw_prtap" id="vw_prtap" class="vw_prtap" onclick="checklistChashier('vw_prtap');"></td>
                            <td class="text-center"><input type="checkbox" name="ed_prtap" id="ed_prtap" class="ed_prtap" onclick="checklistChashier('ed_prtap');"></td>
                            <td class="text-center"><input type="checkbox" name="pr_prtap" id="pr_prtap" class="pr_prtap" onclick="checklistChashier('pr_prtap');"></td>
                            <td class="text-center"><input type="checkbox" name="dl_prtap" id="dl_prtap" class="dl_prtap" onclick="checklistChashier('dl_prtap');"></td>
                            <td class="text-center"><input type="checkbox" name="xp_prtap" id="xp_prtap" class="xp_prtap" onclick="checklistChashier('xp_prtap');"></td>
                        </tr>

                        <tr>
                            <td style="padding-left:10px;"><b>2.</b></td>
                            <td><b>Optional & Payment Receivable</b></td>
                            <td class="text-center"><input type="checkbox" name="vw_prtapw" id="vw_prtapw"></td>
                            <td class="text-center"><input type="checkbox" name="ed_prtapw" id="ed_prtapw"></td>
                            <td class="text-center"><input type="checkbox" name="pr_prtapw" id="pr_prtapw"></td>
                            <td class="text-center"><input type="checkbox" name="dl_prtapw" id="dl_prtapw"></td>
                            <td class="text-center"><input type="checkbox" name="xp_prtapw" id="xp_prtapw"></td>
                        </tr>

                        <tr>
                            <td style="padding-left:10px;"><b>3.</b></td>
                            <td><b>BBN & Payment Payable</b></td>
                            <td class="text-center"><input type="checkbox" name="vw_prtapb" id="vw_prtapb"></td>
                            <td class="text-center"><input type="checkbox" name="ed_prtapb" id="ed_prtapb"></td>
                            <td class="text-center"><input type="checkbox" name="pr_prtapb" id="pr_prtapb"></td>
                            <td class="text-center"><input type="checkbox" name="dl_prtapb" id="dl_prtapb"></td>
                            <td class="text-center"><input type="checkbox" name="xp_prtapb" id="xp_prtapb"></td>
                        </tr>

                        <tr>
                            <td style="padding-left:10px;"><b>4.</b></td>
                            <td><b>Accessories & Payment Receivable</b></td>
                            <td class="text-center"><input type="checkbox" name="vw_prtar" id="vw_prtar"></td>
                            <td class="text-center"><input type="checkbox" name="ed_prtar" id="ed_prtar"></td>
                            <td class="text-center"><input type="checkbox" name="pr_prtar" id="pr_prtar"></td>
                            <td class="text-center"><input type="checkbox" name="dl_prtar" id="dl_prtar"></td>
                            <td class="text-center"><input type="checkbox" name="xp_prtar" id="xp_prtar"></td>
                        </tr>
                        <tr><td colspan="7"></td></tr><tr><td colspan="7"></td></tr>
                        <tr>
                            <td style="padding-left:10px;"><b>5.</b></td>
                            <td><b>Accessories Payable Group Payment</b></td>
                            <td class="text-center"><input type="checkbox" name="vw_prtapg" id="vw_prtapg" class="vw_prtap" onclick="checklistChashier('vw_prtap');"></td>
                            <td class="text-center"><input type="checkbox" name="ed_prtapg" id="ed_prtapg" class="ed_prtap" onclick="checklistChashier('ed_prtap');"></td>
                            <td class="text-center"><input type="checkbox" name="pr_prtapg" id="pr_prtapg" class="pr_prtap" onclick="checklistChashier('pr_prtap');"></td>
                            <td class="text-center"><input type="checkbox" name="dl_prtapg" id="dl_prtapg" class="dl_prtap" onclick="checklistChashier('dl_prtap');"></td>
                            <td class="text-center"><input type="checkbox" name="xp_prtapg" id="xp_prtapg" class="xp_prtap" onclick="checklistChashier('xp_prtap');"></td>
                            <td class="text-center"><input type="checkbox" name="cl_prtapg" id="cl_prtapg" class="cl_prtap" onclick="checklistChashier('cl_prtap');"></td>
                            <td class="text-center"><input type="checkbox" name="uc_prtapg" id="uc_prtapg" class="uc_prtap" onclick="checklistChashier('uc_prtap');"></td>
                        </tr>
                        <!--<tr>
                            <td style="padding-left:10px;">7.</td>
                            <td>Account Receivable Group Payment</td>
                            <td class="text-center"><input type="checkbox" name="vw_prtarg" id="vw_prtarg" class="vw_prtar" onclick="checklistChashier('vw_prtar');"></td>
                            <td class="text-center"><input type="checkbox" name="ed_prtarg" id="ed_prtarg" class="ed_prtar" onclick="checklistChashier('ed_prtar');"></td>
                            <td class="text-center"><input type="checkbox" name="pr_prtarg" id="pr_prtarg" class="pr_prtar" onclick="checklistChashier('pr_prtar');"></td>
                            <td class="text-center"><input type="checkbox" name="dl_prtarg" id="dl_prtarg" class="dl_prtar" onclick="checklistChashier('dl_prtar');"></td>
                            <td class="text-center"><input type="checkbox" name="cl_prtarg" id="cl_prtarg"></td>
                            <td class="text-center"><input type="checkbox" name="uc_prtarg" id="uc_prtarg"></td>
                        </tr>-->

                        <tr><td colspan="7"></td></tr><tr><td colspan="7"></td></tr>
                        <tr><td colspan="7"></td></tr><tr><td colspan="7"></td></tr>

                        <tr><td colspan="7"><b style="font-size: 14px;">History</b></td></tr>
                        <tr><td colspan="7"></td></tr><tr><td colspan="7"></td></tr>

                        <tr>
                            <td style="padding-left:10px;"><b>1.</b></td>
                            <td><b>Accessories Receivable Payment</b></td>
                            <td class="text-center"><input type="checkbox" name="vw_prtarhs" id="vw_prtarhs"></td>
                            <td class="text-center"></td>
                            <td class="text-center"><input type="checkbox" name="pr_prtarhs" id="pr_prtarhs"></td>
                        </tr>
                        <tr>
                            <td style="padding-left:10px;"><b>2.</b></td>
                            <td><b>Accessories Payable Payment</b></td>
                            <td class="text-center"><input type="checkbox" name="vw_prtaphs" id="vw_prtaphs"></td>
                            <td class="text-center"></td>
                            <td class="text-center"><input type="checkbox" name="pr_prtaphs" id="pr_prtaphs"></td>
                        </tr>
                        <tr><td colspan="7"></td></tr><tr><td colspan="7"></td></tr>
                        <tr><td colspan="7"></td></tr><tr><td colspan="7"></td></tr>
                    </table>
                </div>
                <div title="<?php getCaption("Transaksi Jasa / Optional / Form"); ?>" class="main-tab">
                    <table style="margin-top: 10px;">
                        <tr>
                            <td></td>
                            <td width="250"></td>
                            <td width="70" valign="top"><b>View</b></td>
                            <td width="70" valign="top"><b>Edit</b></td>
                            <td width="70" valign="top"><b>Print</b></td>
                            <td width="70" valign="top"><b>Delete</b></td>
                            <td width="70" valign="top"><b>Close</b></td>
                            <td width="70" valign="top"><b>Unclose</b></td>
                            <td width="70" valign="top"><b>Export</b></td>
                        </tr>
                        <tr><td colspan="9"></td></tr><tr><td colspan="9"></td></tr>
                        <tr><td colspan="9"></td></tr><tr><td colspan="9"></td></tr>

                        <tr><td colspan="9"><b style="font-size: 14px;"><?php getCaption("Transaksi Jasa / Optional"); ?></b></td></tr>
                        <tr><td colspan="9"></td></tr><tr><td colspan="9"></td></tr>

                        <tr>
                            <td style="padding-left:10px;"><b>1.</b> </td>
                            <td><b>Services Receiving/ Optional</b></td>
                            <td class="text-center"><input type="checkbox" name="vw_prtwrcv" id="vw_prtwrcv"></td>
                            <td class="text-center"><input type="checkbox" name="ed_prtwrcv" id="ed_prtwrcv"></td>
                            <td class="text-center"><input type="checkbox" name="pr_prtwrcv" id="pr_prtwrcv"></td>
                            <td class="text-center"><input type="checkbox" name="dl_prtwrcv" id="dl_prtwrcv"></td>
                            <td class="text-center"><input type="checkbox" name="cl_prtwrcv" id="cl_prtwrcv"></td>
                            <td class="text-center"><input type="checkbox" name="uc_prtwrcv" id="uc_prtwrcv"></td>
                            <td class="text-center"><input type="checkbox" name="xp_prtwrcv" id="xp_prtwrcv"></td>
                        </tr>
                        <tr>
                            <td style="padding-left:10px;"><b>2.</b> </td>
                            <td><b>Services Purchase / Optional</b></td>
                            <td class="text-center"><input type="checkbox" name="vw_prtwpr" id="vw_prtwpr"></td>
                            <td class="text-center"><input type="checkbox" name="ed_prtwpr" id="ed_prtwpr"></td>
                            <td class="text-center"><input type="checkbox" name="pr_prtwpr" id="pr_prtwpr"></td>
                            <td class="text-center"><input type="checkbox" name="dl_prtwpr" id="dl_prtwpr"></td>
                            <td class="text-center"><input type="checkbox" name="cl_prtwpr" id="cl_prtwpr"></td>
                            <td class="text-center"><input type="checkbox" name="uc_prtwpr" id="uc_prtwpr"></td>
                            <td class="text-center"><input type="checkbox" name="xp_prtwpr" id="xp_prtwpr"></td>
                        </tr>

                        <tr>
                            <td style="padding-left:10px;"><b>3.</b> </td>
                            <td><b>Services Sales / Optional</b></td>
                            <td class="text-center"><input type="checkbox" name="vw_prtwsl" id="vw_prtwsl"></td>
                            <td class="text-center"><input type="checkbox" name="ed_prtwsl" id="ed_prtwsl"></td>
                            <td class="text-center"><input type="checkbox" name="pr_prtwsl" id="pr_prtwsl"></td>
                            <td class="text-center"><input type="checkbox" name="dl_prtwsl" id="dl_prtwsl"></td>
                            <td class="text-center"><input type="checkbox" name="cl_prtwsl" id="cl_prtwsl"></td>
                            <td class="text-center"><input type="checkbox" name="uc_prtwsl" id="uc_prtwsl"></td>
                            <td class="text-center"><input type="checkbox" name="xp_prtwsl" id="xp_prtwsl"></td>
                        </tr>

                        <tr><td colspan="9"></td></tr><tr><td colspan="9"></td></tr>
                        <tr><td colspan="9"></td></tr><tr><td colspan="9"></td></tr>

                        <tr><td colspan="9"><b style="font-size: 14px;">Optional Form</b></td></tr>
                        <tr><td colspan="9"></td></tr><tr><td colspan="9"></td></tr>

                        <tr>
                            <td style="padding-left:10px;"></td>
                            <td><b>Optional Tax Invoice</b></td>
                            <td class="text-center"><input type="checkbox" name="vw_accwfp" id="vw_accwfp"></td>
                            <td class="text-center"><input type="checkbox" name="ed_accwfp" id="ed_accwfp"></td>
                            <td class="text-center"><input type="checkbox" name="pr_accwfp" id="pr_accwfp"></td>
                            <td class="text-center"><input type="checkbox" name="dl_accwfp" id="dl_accwfp"></td>
                            <td class="text-center"><input type="checkbox" name="cl_accwfp" id="cl_accwfp"></td>
                            <td class="text-center"><input type="checkbox" name="uc_accwfp" id="uc_accwfp"></td>
                            <td class="text-center"><input type="checkbox" name="xp_accwfp" id="xp_accwfp"></td>
                        </tr>

                        <tr><td colspan="9"></td></tr><tr><td colspan="9"></td></tr>
                        <tr><td colspan="9"></td></tr><tr><td colspan="9"></td></tr>

                    </table>
                </div>
                <div title="<?php getCaption("Form Accessories"); ?>" class="main-tab">
                    <table style="margin-top: 10px;">
                        <tr>
                            <td width="250"></td>
                            <td width="70" valign="top"><b>View</b></td>
                            <td width="70" valign="top"><b>Edit</b></td>
                            <td width="70" valign="top"><b>Print</b></td>
                            <td width="70" valign="top"><b>Delete</b></td>
                            <td width="70" valign="top"><b>Generate No.</b></td>
                        </tr>
                        <tr><td colspan="6"></td></tr><tr><td colspan="6"></td></tr>
                        <tr><td colspan="6"></td></tr><tr><td colspan="6"></td></tr>

                        <tr>
                            <td><b>Delivery Order</b></td>
                            <td class="text-center"><input type="checkbox" name="vw_prtsj" id="vw_prtsj"></td>
                            <td></td>
                            <td class="text-center"><input type="checkbox" name="pr_prtsj" id="pr_prtsj"></td>
                        </tr>
                        <tr>
                            <td><b>Invoice</b></td>
                            <td class="text-center"><input type="checkbox" name="vw_prtkw" id="vw_prtkw"></td>
                            <td></td>
                            <td class="text-center"><input type="checkbox" name="pr_prtkw" id="pr_prtkw"></td>
                        </tr>
                        <tr>
                            <td><b>Accessories Tax Invoice</b></td>
                            <td class="text-center"><input type="checkbox" name="vw_prtfp" id="vw_prtfp"></td>
                            <td class="text-center"><input type="checkbox" name="ed_prtfp" id="ed_prtfp"></td>
                            <td class="text-center"><input type="checkbox" name="pr_prtfp" id="pr_prtfp"></td>
                            <td class="text-center"><input type="checkbox" name="dl_prtfp" id="dl_prtfp"></td>
                            <td class="text-center"><input type="checkbox" name="gn_prtfp" id="gn_prtfp"></td>
                        </tr>

                        <tr><td colspan="7"></td></tr><tr><td colspan="7"></td></tr>
                        <tr><td colspan="7"></td></tr><tr><td colspan="7"></td></tr>
                    </table>
                </div>
            </div>

            <div class=" main-nav">
                <table class="table" style="width:500px;" border="0">
                    <tr>

                        <td style="border-top:0px !important;">
                            <button type="button" id="cmdSave" title="Save"  data-options="iconCls:'icon-save',group:'g2'" class="easyui-linkbutton cmdSave" onclick="saveData2('form_validation4')"> Save</button>
                            <button type="button" id="cmdCancel" title="Batal" data-options="iconCls:'icon-undo',group:'g2'" class="easyui-linkbutton cmdCancel"  onclick="condCancel2('form_validation4')"> Cancel</button>
                            <button type="button" id="cmdEdit" title="<?php getCaption("Ubah"); ?>" data-options="iconCls:'icon-edit'" class="easyui-linkbutton cmdEdit"  onclick="condEdit2('form_validation4')" > Edit</button>
                            <button type="button" id="cmdDelete" title="<?php getCaption("Hapus"); ?>" data-options="iconCls:'icon-no'" class="easyui-linkbutton cmdDelete"  onclick=" condDelete2('usr_acc', 'form_validation4');" ></button>
                            <button type="button" id="cmdClose" title="<?php getCaption("Close"); ?>" data-options="iconCls:'icon-ok'" class="easyui-linkbutton cmdClose"  onclick=" $('#accWindow').window('close');" > Ok</button>
                        </td>

                    </tr>
                </table> 
            </div>

        </form>
    </div>
</div>

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
    function accWind() {
        var user = $("#form_validation #username").val();

        $("#form_validation4 #username").val($("#form_validation #username").val());
        $("#form_validation4 #userrole").val($("#form_validation #userrole").val());


        $("#form_validation4 input:checkbox").prop("checked", false);

        $.post(site_url + 'transaction/setting/read_access/', {table: 'usr_acc', nav: '', id: '', user: user}, function (json) {

            if (json !== '[]') {
                var rowData = $.parseJSON(json);

                $("#form_validation4 .id").val(rowData.id);

                $.each(rowData, function (i, v) {
                    if (i == 'vw_mparts' || i == 'pr_mparts' || i == 'xp_mparts') {
                        if (v == '1') {
                            $("#form_validation4 #" + i + '2').prop("checked", true);
                        }
                    }
                    if (i == 'vw_prtap' || i == 'ed_prtap' || i == 'pr_prtap' || i == 'dl_prtap' || i == 'xp_prtap') {
                       
                        if (v == '1') {
                            $("#form_validation4 #" + i + 'g').prop("checked", true);
                            $("#form_validation4 #" + i + 'g').val(1);
                        }
                    }
                    if (v == '1') {
                        $("#form_validation4 #" + i).prop("checked", true);
                        $("#form_validation4 #" + i).val(1);
                    }

                });
                
            }else{
                deletedisable('form_validation4');
            }
            formDisabled2('form_validation4');
        });
    }

    function openAccWindow() {
        $('#accWindow').window('open');
        accWind();
    }
</script>