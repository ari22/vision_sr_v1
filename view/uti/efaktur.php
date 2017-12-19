<?php
$invoiceFrom = array
    (
    array("Vision Showroom", "1")
);

$invoiceType = array
    (
    array("Masukan", "1"),
    array("Keluaran", "2")
);
?>
<div style=" margin: 10px;" id="form_content">
    <div class="single-form teen-margin">      
        <form id="form_validation" method="post" >
            <input type="hidden" name="table" id="table">
            <table>
                <tr>
                    <td valign="top" width="250">
                        <table>
                            <tr><td class="col80"></td></tr>
                            <?php localcombobox('inv', 'Faktur Dari', 150, $invoiceFrom); ?>
                            <?php localcombobox('inv_type', 'Jenis Faktur', 150, $invoiceType); ?>
                            <tr><td class="col80"></td></tr>
                        </table>
                    </td>
                    <td valign="top" width="390">
                        <table>
                            <tr><td class="col80"></td></tr>
                            <?php cmdSupp('supp_code', 'supp_name', 'Supplier') ?>
                            <?php cmdWrhs('wrhs_code', 'Warehouse'); ?>   

                            <tr><td class="col80"></td></tr>
                        </table>
                    </td>
                    <td valign="top" width="220">
                        <table>
                            <tr><td class="col60"></td></tr>
                            <?php datebox('date_from', 'Dari') ?>   
                            <?php datebox('date_to', 'Sampai') ?>   
                            <tr><td class="col60"></td></tr>
                        </table>
                    </td>
                    <td valign="top">
                        <table>
                            <tr><td class="col80"></td></tr>
                            <tr>

                                <td>                                    <button type="button" id="get" title="<?php getCaption("get"); ?>" class="easyui-linkbutton" data-options="iconCls:'icon-ok'" onclick="getData();" style="width:80px;">Get Data</button></td>
                            </tr>
                            <tr><td class="col80"></td></tr>
                        </table>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <div class="single-form"> 
        <table id="dt_tbl" class="easyui-datagrid"  title="" style="width:1080px;height:300px;"></table>
    </div>

    <div class="main-nav">
        <table width="100%">
            <tr>
                <td>
                    <table style="width:400px;" border="0">
                        <tr>
                            <td  style="border-top:0px !important;">
                                <button type="button" id="export" title="<?php getCaption("export"); ?>" class="easyui-linkbutton" data-options="iconCls:'icon-export'" onclick="exportTable();" style="width:80px;">Export</button>
                            </td>
                        </tr>
                    </table>   
                </td>
                <td align="right"><img src="<?php echo $loc_jui . "themes/icons/version.png" ?>" id="version"></td>
            </tr>
        </table>
    </div>
</div>
<?php include 'efaktur_fn.php'; ?>
