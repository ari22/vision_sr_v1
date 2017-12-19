<?php
$form = 'systemsetup';
$table = "ssystem";
$lookup = 'stg/' . $table;
$pk = 'comp_name';
$sk = 'comp_name2';

$optpo_source = array
    (
    array("P.O mengambil data dari SPOB (Surat Permintaan Order Barang", "1"),
    array("P.O mengambil dari Master Barang", "2"),
);
$optwo_source = array
    (
    array("W.O mengambil data dari SPOK (Surat Permintaan Order Pekerjaan", "1"),
    array("W.O mengambil dari Master Pekerjaan", "2"),
);
$optspklen = array
    (
    array("4", "4"),
    array("5", "5"),
    array("6", "6"),
    array("7", "7"),
    array("8", "8"),
    array("9", "9"),
    array("10", "10"),
    array("11", "11"),
    array("12", "12"),
);
$optvpg_source = array
    (
    array("Pembayaran Hutang tidak memakai Voucher", "1"),
    array("Pembayaran Hutang melalui pembuatan Voucher terlebih dahulu", "2"),
);
$optoptpur_set = array
    (
    array("Langsung Masuk ke Penjualan Optional (berdasarkan Chassis)", "1"),
    array("Tidak ada hubungan antara Pembelian Optional Kendaraan & Penjualannya", "2"),
);
$optoptprc_set = array
    (
    array("Ketika Optional dimasukkan Harga Optional keluar sesuai Harga di Master", "1"),
    array("Ketika Optional dimassukan Harga Optional dari Master di-reset ke Nol", "2"),
);
$optoptbbn = array
    (
    array("Harga Jual Kendaraan Tetap & DPP Berubah", "1"),
    array("Harga Jual Kendaraan Berubah & DPP Tetap", "2"),
);
$optcomp_stamp = array
    (
    array("Ya", "1"),
    array("Tidak", "2"),
);
$optcomp_stampp = array
    (
    array("Ya", "1"),
    array("Tidak", "2"),
);
?>
<div style=" margin: 10px;" id="form_content">
    <form id="<?= $form; ?>" name="<?= $form; ?>" method="post">
        <div class="easyui-tabs" id="tabscoi" >

            <input type="hidden" name="id" id="id">
            <div title="<?php getCaption('Data Perusahaan'); ?>" class="main-tab">
                <table>
                    <tr>
                        <td valign="top" width="550">
                            <table class="table">
                                <?php
                                textbox('comp_name', 'Nama Perusahaan', 250, 35);
                                textbox('comp_name2', 'Alias', 250, 35);
                                textbox('comp_id', 'ID Perusahaan', 90, 10);
                                ?>
                                <tr height="10px;">	</tr>
                                <?php
                                textbox('comp_add1', 'Alamat', 350, 50);
                                ?>
                                <tr>
                                    <td> </td>
                                    <td> </td>
                                    <td><input class="easyui-validatebox textbox" type="text" id="comp_add2" name="comp_add2" style="width:350px;" disabled="true" /></td>
                                </tr>
                                <tr>
                                    <td> </td>
                                    <td> </td>
                                    <td><input class="easyui-validatebox textbox" type="text" id="comp_add3" name="comp_add3" style="width:350px;" disabled="true" /></td>
                                </tr>
                                <?php
                                cmdCity('comp_city', 'Kota');
                                ?>
                                <tr height="10px;">	</tr>
                                <?php
                                zipbox('comp_zipc', 'Kode Pos', 80);
                                textbox('comp_phone', 'Telepon', 150, 35);
                                textbox('comp_fax', 'Fax', 150, 15);
                                textbox('comp_npwp', 'NPWP', 150, 20);
                                ?>
                                <tr height="25px;">	</tr>
                            </table>
                        </td>
                        <td valign="top">
                            <table>
                                <?php
                                datebox('comp_pkpdt', 'Tanggal Pengukuhan', 120);
                                ?>
                                <tr>
                                    <td><?php getCaption('ppn'); ?></td>
                                    <td>:</td>
                                    <td><?php numberbox2('ppn', 60, 100) ?>&nbsp;%</td>
                                </tr>
                                <tr>
                                    <td><?php getCaption('pph'); ?></td>
                                    <td>:</td>
                                    <td><?php numberbox2('pph', 60, 100) ?>&nbsp;%</td>
                                </tr>
                                <?php
                                textboxset('bulan', 'tahun', 'Periode Aktif', 40, 45);
                                ?>
                            </table>
                        </td>


                </table>
            </div>

            <div title="<?php getCaption('Setting'); ?>" class="main-tab">
                <table class="table">
                    <tr>
                        <td>
                            <b>PO (Purchase Order):</b>
                            <div style="background: #f5f5f5;border-radius:4px;margin-top:10px;padding:5px;">
                                <table>
                                    <tr>
                                        <td><input type="radio" value="1" id="po_source_1" class="po_source_1" name="po_source" disabled="true"> PO mengambil data dari SPOB (Surat Permintaan Order Barang)</td>
                                    </tr>
                                    <tr>
                                        <td><input type="radio" value="2" id="po_source_2" class="po_source_2" name="po_source" disabled="true"> PO mengambil data dari Master Barang</td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                        <td width="30px;"> </td>
                        <td>
                            <b>Pembayaran Hutang Kendaraan:</b>
                            <div style="background: #f5f5f5;border-radius:4px;margin-top:10px;padding:5px;">
                                <table>
                                    <tr>
                                        <td><input type="radio" value="1" id="vpg_source_1" class="vpg_source_1" name="vpg_source" disabled="true">Pembayaran Hutang Tidak memakai Voucher</td>
                                    </tr>
                                    <tr>
                                        <td><input type="radio" value="2" id="vpg_source_2" class="vpg_source_2" name="vpg_source" disabled="true">Pembayaran Hutang Melalui pembuatan Voucher terlebih dahulu</td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>
                    <tr height="20px;">
                    </tr>

                    <tr>
                        <td>
                            <b>WO (Work Order):</b>
                            <div style="background: #f5f5f5;border-radius:4px;margin-top:10px;padding:5px;">
                                <table>
                                    <tr>
                                        <td><input type="radio" value="1" id="wo_source_1" name="wo_source" class="wo_source_1" disabled="true"> WO mengambil data dari SPOK (Surat Permintaan Order Kerja)</td>
                                    </tr>
                                    <tr>
                                        <td><input type="radio" value="2" id="wo_source_1" name="wo_source" class="wo_source_2" disabled="true"> WO mengambil data dari Master Pekerjaan</td>
                                    </tr>
                                </table>
                            </div>
                        </td>

                        <td> </td>

                        <td>
                            <b>Pembelian Optional Kendaraan</b>
                            <div style="background: #f5f5f5;border-radius:4px;margin-top:10px;padding:5px;">
                                <table>
                                    <tr>
                                        <td><input type="radio" value="1" id="optpur_set_1" name="optpur_set"  class="optpur_set_1" disabled="true">Langsung Masuk ke Penjualan Optional (berdasarkan Chassis)</td>
                                    </tr>
                                    <tr>
                                        <td><input type="radio" value="2" id="optpur_set_2" name="optpur_set"  class="optpur_set_2" disabled="true">Tidak ada hubungan antara Pembelian Optional Kendaraan & Penjualannya</td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>

                    <tr height="20px;">
                    </tr>

                    <tr>
                        <td>
                            <table>
                                <tr>
                                    <td><b>SPK Prefix (Kode terdepan SPK) :</td>
                                    <td><input class="easyui-validatebox textbox" type="text" id="spk_prefix" name="spk_prefix" style="width:50px;" disabled="true" /></td>
                                </tr>
                                <tr>
                                    <td colspan="2">(lihat penomoran SPK di preprinted SPK form)</td>
                                </tr>
                                <tr height="5px"> </tr>
                                <tr>
                                    <td><b>SPK Length (Panjang No. SPK) :</td>
                                    <td><input class="easyui-validatebox textbox" type="text" id="spk_length" name="spk_length" style="width:50px;" disabled="true"/></td>

                                </tr>
                            </table>
                        </td>

                        <td> </td>

                        <td>
                            <b>Harga Optional di SPK</b>
                            <div style="background: #f5f5f5;border-radius:4px;margin-top:10px;padding:5px;">
                                <table>
                                    <tr>
                                        <td><input type="radio" value="1" id="optprc_set_1" name="optprc_set" class="optprc_set_1" disabled="true">Ketika Optional dimasukkan Harga Optional keluar sesuai Harga di Master</td>
                                    </tr>
                                    <tr>
                                        <td><input type="radio" value="2" id="optprc_set_2" name="optprc_set" class="optprc_set_2" disabled="true">Ketika Optional dimasukkan Harga Optional dari Master di-reset ke Nol</td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>

                    <tr>
                    </tr>

                    <tr valign="top">
                        <td> </td>
                        <td> </td>
                        <td>
                            <b>BBN Setting</b><br/>
                            Ketika harga BBN diubah di menu Penjualan Kendaraan :
                            <div style="background: #f5f5f5;border-radius:4px;margin-top:10px;padding:5px;">
                                <table>
                                    <tr>
                                        <td><input type="radio" value="1" id="bbn_set_1" name="bbn_set" class="bbn_set_1" disabled="true">Harga Jual Kendaraan Tetap & DPP Berubah</td>
                                    </tr>
                                    <tr>
                                        <td><input type="radio" value="2" id="bbn_set_2" name="bbn_set" class="bbn_set_2" disabled="true">Harga Jual Kendaraan Berubah & DPP Tetap</td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>

                </table>
            </div>

            <div title="<?php getCaption('Miscellaneous / Lain-lain'); ?>" class="main-tab">
                <table class="table">
                    <?php cmdWrhsAll('dlrw_code', 'Kode Dealer', 150); ?>
                    <?php cmdWrhsAll('mdlrw_code', 'Kode Main Dealer', 150); ?>
                    <tr><td colspan="3"></td></tr><tr><td colspan="3"></td></tr><tr><td colspan="3"></td></tr>
                    <tr>
                        <td>Cetak Materai di Faktur Service</td>
                        <td class="td-ro">:</td>
                        <td><input type="checkbox" name="comp_stamp" id="comp_stamp" disabled="true"></td>
                    </tr>
                    <tr>
                        <td>Cetak Materai di Faktur Spare Parts</td>
                        <td class="td-ro">:</td>
                        <td><input type="checkbox" name="comp_stmpp" id="comp_stmpp" disabled="true"></td>
                    </tr>

                </table>
                <style>
                    #comp_stamp,#comp_stmpp {  vertical-align: middle; margin-top: 5px; margin-left: -1px;}
                </style>
            </div>
            
            <div title="Tax Invoice Information" class="main-tab">
                <table class="table">
                    <tr>
                        <td>Copy From</td>
                        <td class="td-ro">:</td>
                        <td><a href="#" id="copyFrom" title="Save" class="easyui-linkbutton"  data-options="disabled:true" onclick="copyFrom()" >Company Info</a></td>
                    </tr>
                    <?php
                    textbox('cotx_name', 'Nama Perusahaan', 250, 35);
                    textbox('cotx_name2', 'Alias', 250, 35);
                    ?>
                    <tr height="10px;"></tr>
                    <?php textbox('cotx_add1', 'Alamat', 350, 50); ?>
                    <tr>
                        <td> </td>
                        <td> </td>
                        <td><?php textbox2('cotx_add2', 350, 350); ?></td>
                    </tr>
                    <tr>
                        <td> </td>
                        <td> </td>
                        <td><?php textbox2('cotx_add3', 350, 350); ?></td>
                    </tr>
                    <?php
                    cmdCity('cotx_city', 'Kota');
                    zipbox('cotx_zipc', 'Kode Pos', 80);
                    ?>
                    <tr height="10px;"></tr>
                    <?php
                    textbox('cotx_phone', 'Telepon', 150, 35);
                    textbox('cotx_fax', 'Fax', 150, 15);
                    textbox('cotx_npwp', 'NPWP', 150, 20);
                    ?>
                </table>
            </div>
        </div>

        <div class="main-nav">
            <table width="100%">
                <tr>
                <td width="300">
                    <table>
                        <tr>
                            <td align=left width="200px">
                                <a href="#" id="cmdSave" title="Save" class="easyui-linkbutton easyui-tooltip"  data-options="iconCls:'icon-save',group:'g2',disabled:true" onclick="saveData()" ></a>
                                <a href="#" id="cmdEdit" title="<?php getCaption("Ubah"); ?>" class="easyui-linkbutton easyui-tooltip" data-options="iconCls:'icon-edit'"  onclick="condEdit()"></a>
                                <a href="#" id="cmdCancel" title="Batal" class="easyui-linkbutton easyui-tooltip" data-options="iconCls:'icon-undo',group:'g2',disabled:true"  onclick="condCancel()" ></a>
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
<style>
    #bulan,#tahun{text-align: right;}
</style>
<?php include 'systemsetup_fn.php'; ?>