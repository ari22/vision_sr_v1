<?php
$mounth = array(
    array('', ''),
    array('JANUARY', '01'),
    array('FEBRUARY', '02'),
    array('MARCH', '03'),
    array('APRIL', '04'),
    array('MAY', '05'),
    array('JUNE', '06'),
    array('JULY', '07'),
    array('AUGUST', '08'),
    array('SEPTEMBER', '09'),
    array('OCTOBER', '10'),
    array('NOVEMBER', '11'),
    array('DECEMBER', '12')
);

/* $bulan = $mounth[$_SESSION['bulan']];
  $bulan = $bulan[1];

  $tahun = $_SESSION['tahun'];
 */

?>
<div style=" margin: 10px;" id="form_content">
    <form id="form_validation" method="post" >
        <div class="single-form">
            <table>

                <tr>
                    <td valign="top" width="450">
                        <table>
                            <?php textbox('sal_inv_no', 'No. Faktur Jual', 120, 120); ?>
                            <tr>
                                <td width="120"><?php getCaption('Periode'); ?></td>
                                <td class="td-ro">:</td>
                                <td>
                                    <table class='marginmin'>
                                        <tr>
                                            <td>
                                                <select class="easyui-combobox" 
                                                        id="period1" 
                                                        name="period1" 
                                                        style="width:120px;" 
                                                        data-options="panelHeight:100,editable:false,width:120"
                                                        disabled=true
                                                        >
                                                            <?php
                                                            foreach ($mounth as $val) {
                                                                if ($val[1] == $bulan) {
                                                                    echo '<option value="' . $val[1] . '" selected>' . $val[0] . '</option>';
                                                                } else {
                                                                    echo '<option value="' . $val[1] . '">' . $val[0] . '</option>';
                                                                }
                                                            }
                                                            ?>				
                                                </select>
                                            </td>
                                            <td align="right" width="80"><?php getCaption('Tahun'); ?></td>
                                            <td class="td-ro">:</td>
                                            <td><input class="easyui-validatebox textbox" autocomplete="off" type="text" id="year1" name="year1" style="width:50px;text-align:right;" disabled=true value="<?php echo $tahun; ?>" maxlength="4" oninput="this.value=this.value.replace(/[^0-9]/g,'');"></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td><?php getCaption('Sampai'); ?></td>
                                <td class="td-ro">:</td>
                                <td>
                                    <table class='marginmin'>
                                        <tr>
                                            <td>
                                                <select class="easyui-combobox" 
                                                        id="period2" 
                                                        name="period2" 
                                                        style="width:120px;" 
                                                        data-options="panelHeight:100,editable:false,width:120"
                                                        disabled=true
                                                        >
                                                            <?php
                                                            foreach ($mounth as $val) {
                                                                if ($val[1] == $bulan) {
                                                                    echo '<option value="' . $val[1] . '" selected>' . $val[0] . '</option>';
                                                                } else {
                                                                    echo '<option value="' . $val[1] . '">' . $val[0] . '</option>';
                                                                }
                                                            }
                                                            ?>				
                                                </select>
                                            </td>
                                            <td align="right" width="80"><?php getCaption('Tahun'); ?></td>
                                            <td class="td-ro">:</td>
                                            <td><input class="easyui-validatebox textbox" autocomplete="off" type="text" id="year2" name="year2" style="width:50px;text-align:right;" disabled=true value="<?php echo $tahun; ?>"  maxlength="4" oninput="this.value=this.value.replace(/[^0-9]/g,'');"></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>


                        </table>
                    </td>

                    <td valign="top">
                        <table>
                            <?php
                            textboxset('cust_code', 'cust_name', 'Pelanggan', 90, 235);
                            textboxset('srep_code', 'srep_name', 'Sales', 90, 235);
                            ?>
                            <tr><td class="col120"></td></tr>
                            <tr><td></td></tr><tr><td></td></tr>
                        </table>


                    </td>
                </tr>
                <tr><td></td></tr>
                <tr>
                    <td valign="top">
                        <table>

                            <tr><td><br /><br /><br /></td></tr>
                            <?php numberbox('inv_total', 'Jumlah Faktur', 120, 100); ?>
                            <tr><td class="col120"></td></tr>
                        </table>
                    </td>
                    <td valign="top">
                        <table>
                            <?php
                            numberbox('pd_begin', 'Hutang Awal', 200, 70);
                            numberbox('pd_paid', 'Pembayaran', 200, 70);

                            numberbox('pd_disc', 'Discount', 200, 70);
                            ?>
                            <tr><td></td><td class='td-ro'></td><td style="text-align:right;"><hr /></td><td><b>-</b></td></tr>
                            <?php
                            numberbox('pd_end', 'Hutang Akhir', 200, 70);
                            ?>
                            <tr><td class="col120"></td></tr>
                        </table>
                    </td>
                </tr>
            </table>
            <br />
            <table id="dt_ard" class="easyui-datagrid"  title="" style="width:1060px;height:130px;"></table>
        </div>
        <div class="main-nav">
            <table width="100%">
                <tr>
                    <td>
                        <table style="width:250px;" border="0">
                            <tr>
                                <td><button type="button" id="process" title="<?php getCaption("Process"); ?>" class="easyui-linkbutton" data-options="iconCls:'icon-ok'" onclick="showSearch('process');"  disabled="true">Process</button></td>
                                <td><button type="button" id="screen" title="<?php getCaption("Screen Faktur"); ?>" class="easyui-linkbutton" data-options="iconCls:'icon-screen'" onclick="showSearch('screen');">Screen</button></td>
                                <td><button type="button" id="print" title="<?php getCaption("Print Faktur"); ?>" class="easyui-linkbutton" data-options="iconCls:'icon-print'" onclick="showSearch('print');" >Print</button></td>
                            </tr>
                        </table>   
                    </td>
                     <td align="right" width="200"><img src="<?php echo $loc_jui . "themes/icons/version.png" ?>" id="version"></td>

                </tr>
            </table>
        </div>
    </form>

</div>
<style>
    .marginmin{margin: -3px;}
</style>

<script>

    $(document).ready(function () {

        setEnable();
        $(".loader").hide(1000);
         version('04.17-25');
    });

    function disableButton() {
        $("#screen").linkbutton('disable');
        $("#print").linkbutton('disable');
    }
    function enableButton() {
        $("#screen").linkbutton('enable');
        $("#print").linkbutton('enable');
    }
    function setEnable()
    {
        $('#process').linkbutton('enable');
        //$("#sal_inv_no").combogrid('enable');
        $('.easyui-combobox').combobox('enable');
        $('#form_validation #year1,#sal_inv_no').attr('disabled', false);
        //$('#form_validation #year2').attr('disabled', true);
        $('#form_validation #period2').combobox('disable');
       // $("#sal_inv_no").combogrid('enable');
        table_grid(null);
        disableButton();
    }
    function showSearch(lcOutput) {
        $('.loader').show();

        var sal_inv_no = $("#sal_inv_no").val();
        var state = true;
        var msg = '';

        mounth1 = $("#period1").combobox('getValue');
        year1 = $("#year1").val();

        mounth2 = $("#period2").combobox('getValue');
        year2 = $("#year2").val();

        var date1 = new Date(mounth1 + '/01/' + year1);
        var date1 = date1.getTime();
        var date2 = new Date(mounth2 + '/01/' + year2);
        var date2 = date2.getTime();

        if (sal_inv_no == '') {
            state = false;
            msg = 'Sales Invoice No. not empty!';
        }
        if (mounth1 == '') {
            state = false;
            msg = 'Period not empty!';
        }
        if (mounth2 == '') {
            state = false;
            msg = 'Until not empty!';
        }
        if (year1 == '') {
            state = false;
            msg = 'Year not empty!';
        }
        if (year2 == '') {
            state = false;
            msg = 'Year not empty!';
        }


        if (parseInt(date1) > parseInt(date2)) {
            state = false;
            msg = 'Period not be more than Until';
        }


        if (state !== false) {
            newdate1 = year1 + '-' + mounth1 + '-01';
            newdate2 = year2 + '-' + mounth2 + '-31';

            if (lcOutput == 'process') {
                $("#so_no, #wrhs_code, #cust_code, #cust_name, #veh_code, #veh_name, #color_code, #color_name, #chassis, #engine, #veh_type, #veh_transm, #veh_model, #veh_year").val('');
                $('#form_validation .easyui-numberbox').numberbox('setValue', '');

                table_grid(null);
               
               var emptydata = {total:0,rows:[]};
               $('#dt_ard').datagrid('loadData', emptydata);
               
                disableButton();

                url = "services/runCRUD.php";

                $.post( url + '?lookup=rpt/history&inv_no=sal_inv_no&val_no=' + sal_inv_no + '&date1=' + newdate1 + '&date2=' + newdate2, {table1: 'acc_arh', table2: 'acc_ard'}, function (json) { 
                   if (json !== '[]') {

                            var alldata = $.parseJSON(json);
                        
                        var rowData = alldata.header;
                        var detailData = alldata.detail;
                        
                        $.each(rowData, function (i, v) {
                            if (v !== '') {
                                $("#form_validation #" + i).val(v);
                            }
                        });
                        $('#form_validation').form('load', {
                            inv_total: rowData.inv_total,
                            pd_begin: rowData.pd_begin,
                            pd_paid: rowData.pd_paid,
                            pd_disc: rowData.pd_disc,
                            pd_end: rowData.pd_end,
                            inv_stamp: rowData.inv_stamp
                        });
                                               $('#dt_ard').datagrid('loadData', detailData);
                    } else {
                        showAlert("Message", '<font color="red">Data not available</font>');
                    }
                      $('.loader').hide();
                });

                enableButton();
            } else {
                url = "services/runCRUD.php";

                var strWindowFeatures = "location=yes,height=650,width=1500,scrollbars=yes,status=yes";
                var URL = url + "?lookup=rpt/history/piutangacc"
                        + "&output=" + lcOutput
                        + "&sal_inv_no=" + sal_inv_no
                        + "&date1=" + newdate1
                        + "&date2=" + newdate2;

                URL = URL + '#toolbar=0';
                if (lcOutput !== 'screen') {
                    $("#screenWindow").empty().append('<iframe frameborder="0"  src="' + URL + '" style="width:100%;height:auto;min-height: 500px;padding:0px;"></iframe>');
                } else {
                    var win = window.open(URL, "_blank", strWindowFeatures);
                }
                  $('.loader').hide();
            }


        } else {
            $("#so_no, #wrhs_code, #cust_code, #cust_name, #veh_code, #veh_name, #color_code, #color_name, #chassis, #engine, #veh_type, #veh_transm, #veh_model, #veh_year").val('');
            $('#form_validation .easyui-numberbox').numberbox('setValue', '');

            table_grid(null);
            disableButton();
            showAlert("Message", '<font color="red">' + msg + '</font>');
             $('.loader').hide();
        }
    }

    function table_grid(jsonRows) {
        $("#dt_ard").datagrid({
            method: 'post',
            url:jsonRows,
            idField: 'id',
            fitColumns: false,
            singleSelect: true,
            nowrap: true,
            fit: false,
            rownumbers: true,
            pageSize: 10,
            showFooter: false,
            pagination: true,
            columns: [[
                    {field: 'pay_date', title: '<?php getCaption("Tgl. Bayar"); ?>', width: 100, height: 20, sortable: true, formatter: formatDate},
                    {field: 'pay_type', title: '<?php getCaption("Jenis Bayar"); ?>', width: 120, height: 20, sortable: true},
                    {field: 'bank_code', title: '<?php getCaption("Bank"); ?>', width: 120, height: 20, sortable: true},
                    {field: 'check_no', title: '<?php getCaption("No. Check"); ?>', width: 120, height: 20, sortable: true},
                    {field: 'check_date', title: '<?php getCaption("Tanggal Check"); ?>', width: 100, height: 20, sortable: true, formatter: formatDate},
                    {field: 'due_date', title: '<?php getCaption("Tgl J. Tempo"); ?>', width: 100, height: 20, sortable: true, formatter: formatDate},
                    {field: 'pay_val', title: '<?php getCaption("Pembayaran"); ?>', width: 120, height: 20, sortable: true, align: "right", formatter: formatNumber},
                    {field: 'disc_val', title: '<?php getCaption("Diskon"); ?>', width: 120, height: 20, sortable: true, align: "right", formatter: formatNumber},
                    {field: 'pay_desc', title: '<?php getCaption("Keterangan"); ?>', width: 200, height: 20, sortable: true},
                    {field: 'coll_code', title: '<?php getCaption("Kolektor"); ?>', width: 120, height: 20, sortable: true},
                    {field: 'kwit_ono', title: '<?php getCaption("No. Kwitansi"); ?>', width: 120, height: 20, sortable: true},
                    {field: 'kwit_odate', title: '<?php getCaption("Tgl. Kwitansi"); ?>', width: 100, height: 20, sortable: true, formatter: formatDate},
                    {field: 'pay_bbn', title: '<?php getCaption("Bayar BBN"); ?>', width: 120, height: 20, sortable: true, align: "right", formatter: formatNumber},
                    {field: 'dpfp_no', title: '<?php getCaption("No. FP"); ?>', width: 120, height: 20, sortable: true},
                    {field: 'dpfp_date', title: '<?php getCaption("Tgl. FP"); ?>', width: 100, height: 20, sortable: true, formatter: formatDate},
                    {field: 'add_by', title: 'Added By', width: 120, height: 20, sortable: true}
                ]]
        });
    }

</script>