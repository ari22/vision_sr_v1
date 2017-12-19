<div style=" margin: 10px;" id="form_content">
    <form id="form_validation" method="post" >
        <input type="hidden" name="id" id="id">

        <table style="border:1px solid #ccc;" class="main-form">
            <tr>
                <td valign="top" width="480">
                    <table>
                        <tr><td><br /></td></tr>
                        <tr>
                            <td><?php getCaption('No. SPK'); ?></td>
                            <td class="td-ro">:</td>
                            <td>
                                <table class='marginmin'>
                                    <tr>
                                        <td><table class='marginmin'><?php cmdspkFormPick('so_no', '', $site_url); ?></table></td>
                                        <td align="right" width="80"><?php getCaption('Tgl. SPK'); ?></td>
                                        <td class="td-ro">:</td>
                                        <td><?php datebox2('so_date'); ?></td>
                                    </tr>                                       
                                </table>
                            </td>
                        </tr>
                        <tr><td></td></tr>
                        <tr>
                            <td></td>
                            <td class="td-ro"></td>
                            <td>
                                <table class='marginmin'>
                                    <tr>
                                        <td width="80">Code</td>
                                        <td>Name</td>
                                    </tr>                                         
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td><?php getCaption('Sales'); ?></td>
                            <td class="td-ro">:</td>
                            <td>
                                <table class='marginmin'>
                                    <tr>
                                        <td width="80"><?php textbox2('srep_code', 80, 80); ?></td>
                                        <td><?php textbox2('srep_name', 252, 180); ?></td>
                                    </tr>                                        
                                </table>
                            </td>
                        </tr>
                        <tr><td class="col80"></td></tr>
                    </table>
                </td>

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
            <tr><td><br /></td></tr>
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
                        <tr><td class="col80"></td></tr>
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
                        <tr><td class="col120"></td></tr>
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

                        <tr><td class="col80"></td></tr>
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
                        <tr><td class="col120"></td></tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td valign="top">
                    <table>
                        <?php numberbox('tot_price', 'Harga Kendaraan', 150, 100); ?>
                        <tr><td class="col80"></td></tr>
                    </table>
                </td>
                <td>
                    <table>

                        <?php textbox('canc_note', 'Keterangan Batal', 345, 120); ?>
                        <tr><td class="col120"></td></tr>
                    </table>
                </td>
            </tr>
        </table>
        <div class="single-form">
            <p> Optional/Work</p>
            <table id="tbl_dtl" class="easyui-datagrid"  title="" style="width:1060px;height:130px;"></table>
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
<?php include 'batal_spk_fn.php'; ?>
