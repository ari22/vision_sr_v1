<?php
$optGroupBy = array
    (
    array("Chassis / SPK", "1"),
    array("Invoice Not Close", "2")
);
?>
<div style=" margin: 10px;" id="form_content">
    <form id="form_validation" method="post" >
        <input type="hidden" name="id" id="id">

        <div class="single-form">
            <table>
                <tr>
                    <td valign="top" width="30%">
                        <table>
                            <?php localcombobox('group_by', 'Group By', 200, $optGroupBy); ?>
                            <tr><td><br /></td></tr>
                        </table>
                        <table style="border:1px solid #ccc;border-radius:8px;width: 270px;padding: 10px;">
                            <tr><td>Chassis / SPK / DO (SJ) No.</td></tr>
                            <tr><td><input class="easyui-combogrid" id="chassis" name="chassis" disabled="true" style="width:200px;"></input></td></tr>
                            <tr><td>Invoice Not Close</td></tr>
                            <tr>
                                <td>
                                    <select id="chassis2" name="chassis2" size="4" style="width: 200px;height: 200px;"></select>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td valign="top">
                        <table class="marginmin">
                            <tr>
                                <td valign="top">
                                    <table >
                                        <?php
                                        textbox('sj_no', 'No. Surat Jalan', 150, 100);
                                        textbox('so_no', 'No. SPK', 150, 100);
                                        textbox('sal_inv_no', 'No. Faktur', 150, 100);
                                        ?>
                                        <tr><td class="col120"></td></tr>
                                    </table>
                                </td>

                                <td valign="top">
                                    <table class="marginmin">
                                        <?php
                                        datebox('sj_date', 'Tgl. Surat Jalan');
                                        datebox('so_date', 'Tgl. SPK');
                                        datebox('sal_date', 'Tgl. Faktur');
                                        ?>
                                        <tr><td class="col100"></td></tr>
                                    </table>
                                </td>
                            </tr>

                            <tr>
                                <td valign="top">
                                    <table>
                                        <tr>
                                            <td></td>
                                            <td class="td-ro"></td>
                                            <td width="80"><?php getCaption("Kode"); ?></td>
                                            <td width="220"><?php getCaption("Nama"); ?></td>
                                        </tr>
                                        <tr>
                                            <td><?php getCaption("Kendaraan"); ?></td>
                                            <td class="td-ro">:</td>
                                            <td width="80"><?php textbox2('veh_code', 80, 250); ?></td>
                                            <td width="220"><?php textbox2('veh_name', 252, 350); ?></td>
                                        </tr>
                                        <tr>
                                            <td><?php getCaption("Chassis"); ?></td>
                                            <td class="td-ro">:</td>
                                            <td colspan="4" style='padding:0px !important'>
                                                <table class='marginmin'>
                                                    <tr>                                               
                                                        <td><?php textbox2('chassis', 150, 250); ?></td>
                                                        <td class='col50'><?php getCaption("Tipe"); ?></td>
                                                        <td class='td-ro'>:</td>
                                                        <td><?php textbox2('veh_type', 120, 250); ?></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td ><?php getCaption("Engine"); ?></td>
                                            <td class="td-ro">:</td>
                                            <td colspan="4">
                                                <table class='marginmin'>
                                                    <tr>
                                                        <td><?php textbox2('engine', 150, 250); ?></td>
                                                        <td class='col50'><?php getCaption("Model"); ?></td>
                                                        <td class='td-ro'>:</td>
                                                        <td><?php textbox2('veh_model', 120, 250); ?></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr><td class="col120"></td></tr>
                                    </table>
                                </td>
                                <td valign="top">
                                    <table>
                                        <tr>
                                            <td></td><td class="td-ro"></td><td>&nbsp;</td>
                                        </tr>
                                        <?php
                                        textbox('veh_brand', 'Merek', 90, 120);
                                        textbox('veh_transm', 'Transmisi', 90, 120);
                                        textbox('veh_year', 'Tahun', 90, 120);
                                        ?>
                                        <tr><td class="col100"></td></tr>
                                    </table>
                                </td>
                            </tr>

                            <tr>
                                <td valign="top">
                                    <table>
                                        <tr>
                                            <td></td>
                                            <td class="td-ro"></td>
                                            <td width="80"><?php getCaption("Kode"); ?></td>
                                            <td width="220"><?php getCaption("Nama"); ?></td>
                                        </tr>
                                        <tr>
                                            <td><?php getCaption("Warna"); ?></td>
                                            <td class="td-ro">:</td>
                                            <td width="80"><?php textbox2('color_code', 80, 250); ?></td>
                                            <td width="220"><?php textbox2('color_name', 252, 350); ?></td>
                                        </tr>

                                        <tr><td class="col120"></td></tr>
                                    </table>
                                </td>
                                <td valign="top">
                                    <table>
                                        <tr>
                                            <td></td><td class="td-ro"></td><td>&nbsp;</td>
                                        </tr>
                                        <?php
                                        textbox('color_type', 'Tipe', 90, 120);
                                        ?>
                                        <tr><td class="col100"></td></tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td valign="top">
                                    <table>
                                        <tr>
                                            <td></td>
                                            <td class="td-ro"></td>
                                            <td>
                                                <table class='marginmin'>
                                                    <tr>
                                                        <td width="90">Code</td>
                                                        <td>Name</td>
                                                    </tr>                                         
                                                </table>
                                            </td>
                                        </tr>
                                        <?php textboxset('cust_code', 'cust_name', 'Pelanggan', 90, 250); ?>
                                        <?php textbox('cust_addr', 'Alamat', 345, 200); ?>
                                        <tr>
                                            <td></td>
                                            <td class="td-ro"></td>
                                            <td>
                                                <table class='marginmin'>
                                                    <tr>
                                                        <td><?php textbox2('cust_area', 142, 12); ?></td>
                                                        <td><?php textbox2('cust_city', 142, 12); ?></td>
                                                        <!--<td><?php textbox2('cust_country', 80, 12); ?></td>-->
                                                        <td><?php textbox2('cust_zipcode', 53, 12); ?></td>
                                                    </tr>

                                                </table>
                                            </td>
                                        </tr>
                                        <tr><td class="col120"></td></tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td><table> <?php textbox('canc_note', 'Keterangan Batal', 345, 120); ?> <tr><td class="col120"></td></tr></table></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
        <div class="main-nav">
            <table width="100%">
                <tr>
                    <td width="100">
                        <table border="0">
                            <tr>
                                <td><button type="button" id="process" title="<?php getCaption("Process"); ?>" class="easyui-linkbutton" data-options="iconCls:'icon-ok'" onclick="cancelling();"  disabled="true">Process</button></td>
                            </tr>
                        </table>   
                    </td>
                    <td align="right"><img src="<?php echo $loc_jui . "themes/icons/version.png" ?>" id="version"></td>
                </tr>
            </table>
        </div>
    </form>

</div>
<div id="sr" class="easyui-window" title="Screen" data-options="closable:true,minimizable:false,maximizable:false,collapsible:false,closed:true,modal:true,closed:true,inline:true" style="width:1050px;height:500px;padding:10px;top:1;"></div>

<style>
    .marginmin{margin: -3px;}
</style>
<?php include 'batal_sj_fn.php'; ?>

