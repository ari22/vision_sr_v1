<div style=" margin: 10px;" id="form_content">
    <?php
    $form = 'uangjaminan';
    $table = "veh_dpch";
    $lookup = 'trx/' . $table;
    $pk = 'dp_inv_no';
    $sk = 'so_no';
    ?>
    <form id="<?php echo $form; ?>" method="post" >
        <div class="single-form teen-margin">
            <div id="tableId"></div>
            <table>
                <td valign="top" width="450">
                    <table>

                        <?php
                        textbox('dp_inv_no', 'No. Faktur', 150, 30);
                        datebox('dp_date', 'Tgl. Faktur', 200);
                        datebox('opn_date', 'Tgl. Buat', 200);
                        ?>
                        <tr><td colspan="3"></td></tr>
                        <tr><td colspan="3"></td></tr>
                        <?php
                        cmdspk('so_no', 'No. SPK', $site_url);
                        datebox('so_date', 'Tanggal SPK', 200);
                        //textbox('srep_code','Sales Representative',250,30);                       
                        //cmdSalSet('srep_code', 'srep_name', 'Sales Representative');
                         ?>
                        <tr><td colspan="3"></td></tr>
                        <tr><td colspan="3"></td></tr>
                        <?php
                        numberbox('veh_price', 'Harga Kendaraan', 80, 30);
                        numberbox('pd_end', 'Sisa Tagihan Uang Jaminan', 150, 30);
                        textbox('srep_name', 'Sales Representative', 200, 30);
                        ?>
                    </table>
                </td>
                <td valign="top">
                    <table>
                        <?php
                        textboxset('cust_code', 'cust_name', 'Pelanggan', 80, 250);
                        ?>
                        <tr><td colspan="3"></td></tr>
                        <tr><td colspan="3"></td></tr>
                        <?php
                        textbox('veh_name', 'Kendaraan', 332, 30);
                        textbox('chassis', 'Chassis', 150, 30);
                        textbox('engine', 'Engine', 150, 30);                      
                        ?>
                        <tr><td colspan="3"></td></tr>
                        <tr><td colspan="3"></td></tr>
                        <?php
                        textboxset('color_code', 'color_name', 'Warna', 80, 250);
                        textbox('wrhs_code', 'Warehouse', 80, 30);
                        textbox('note', 'Keterangan', 332, 30);
                       
                        ?>

                    </table>
                </td>
            </table>
        </div>
        <div class="single-form" style="padding: 10px;">
            <table id="dt" class="easyui-datagrid"  title="" style="width:1080px;height:150px;"></table>

            <table width="100%">
                <td align="right">
                    <table >
                        <?php
                        numberbox('dp_begin', 'Uang Jaminan (Posted)', 90, 30);
                        numberbox('dp_paid', 'Uang Jaminan (Current)', 250, 30);
                        numberbox('dp_used', 'Bayar Piutang', 150, 30);
                        numberbox('dp_end', 'Saldo Akhir', 150, 30);
                        ?>
                    </table>
                </td>
            </table>

        </div>
        <div class="main-nav">
            <table width="100%">
                <tr>
                    <td style="width: 400px !important;"> <?php navigation_ci(); ?></td>
                    <td align=left width="100">
                        <button id="cmdBayar" title="<?php getCaption("Bayar"); ?>" class="cmdBayar easyui-linkbutton" data-options="iconCls:'icon-payment'"  onclick="condBayar();" >Bayar</button>
                    </td>
                    <td align="right"><img src="<?php echo $loc_jui . "themes/icons/version.png" ?>" id="version"></td>
                </tr>
            </table>
        </div>
    </form>
</div>

<div id="SearchOption" style="display:none;">  
    <form id="form_validation2" method="post" >    
        <div id="optionSPK" style="padding:10px;">
            <span><?php getCaption("No. Faktur"); ?>:</span>
            <input id="code" name="code">
            <span><?php getCaption("Tgl. Faktur"); ?>:</span>
            <input id="name" name="name" >
            <a href="#" class="easyui-linkbutton" onclick="doSearch()" iconCls="icon-search">Search</a>
            <button type="button"  title="<?php getCaption("Ok"); ?>" class="easyui-linkbutton easyui-tooltip btn btn-default" data-options="iconCls:'icon-ok'" onclick="getSearchselect()" >Ok </button>
            <button type="button" class="easyui-linkbutton easyui-tooltip btn btn-default" onclick="close_search();">Cancel</button>

        </div>

    </form>
</div>

<?php include_once "pembayaranjaminan_bayar.php"; ?>
<?php include_once "pembayaranjaminan_bbn.php"; ?>
<?php include_once "pembayaranjaminan_fn.php"; ?>

