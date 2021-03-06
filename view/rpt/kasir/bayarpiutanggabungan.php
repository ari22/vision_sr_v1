<?php
$form = 'rpt_argd';
$table = "";
$lookup = 'mst/' . $table;

$closed = array
    (
    array("Closed", "1"),
    array("Not Closed", "2"),
    array("All", "3"),
);
$optSortBy = array
    (
    array("Invoice No. / Invoice Date", "1"),
    array("Invoice Date / Invoice No.", "2"),
    array('Customer / Debitor' , '3')
);

?>
<div style=" margin: 10px;" id="form_content">
    <form id="<?php echo $form; ?>" >
        <div class="single-form teen-margin">
            <table>
                <tr><td colspan="3"> <h1 style="font-size:18px"><u>REPORT BY</u></h1></td></tr>
                <?php
                localcombobox('cls', 'Cetak Faktur', 100, $closed);
                datebox('arg_date1', 'Tanggal Faktur', 200);
                datebox('arg_date2', 's/d', 200);
                ?>
                
                
                <tr><td class="col120"></td></tr>
            </table>
        </div>

        <div  class="single-form">  

            <table>
                <tr><td colspan="3"><h1><u>FILTER BY</u></h1></td></tr>
                <?php
                cmdCustSet('cust_code', 'cust_name', 'Pelanggan');

                $url = "services/runCRUD.php?func=datasource&lookup=mst/pay_type&pk=pay_type&sk=pay_name&order=pay_name&fields=id,pay_type,pay_name";
                
                 localcombobox('sort_by', 'Urutkan Bedasarkan', 200, $optSortBy);
                ?>
                
                <!--<tr> <td><?php getCaption('Cara Bayar'); ?> </td>
                    <td style="max-width: 5px !important;" class="td-ro">:</td>
                    <td><input class="easyui-combogrid" id="pay_type"	name="pay_type" style="width:200" disabled=true
                               data-options="panelWidth: 300,panelHeight:340,delay: 500,method:'post',
                               idField:'pay_type',textField:'pay_name',fitColumns: true,mode:'remote', pagination:true,
                               remoteSort:true,multiSort:true,required:false,loadMsg:'Please wait...',editable:false,
                               url:'services/runCRUD.php?func=datasource&lookup=mst/pay_type&pk=pay_type&sk=pay_name&order=pay_name&fields=id,pay_type,pay_name',
                               columns: [[               
                               {field:'pay_type',title:'Type',width:80,sortable:true},
                               {field:'pay_name',title:'Name',width:230,sortable:true},
                               ]],
                               " >
                        </input></td></tr>-->
                
                <tr>
                    <td>Transaction Detail</td>
                    <td>:</td>
                    <td>
                        <input id="trans" name="trans" value="0" type="checkbox"  style="margin-left: -0.5px;margin-top: 5px;">
                    </td>
                </tr>
                <tr><td class="col120"></td></tr>
            </table>

        </div>
        <div class="main-nav">
            <table width="100%">
                <tr>
                    <td>
                        <a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-screen'"  onclick="doSearch('screen')">Screen</a>
                        &nbsp;&nbsp;

                        <a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-print'"  onclick="doSearch('print')">Printer</a>
                        &nbsp;&nbsp;

                        <a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-export'" onclick="doSearch('export')"><?php getCaption('Eksport'); ?></a>
                        &nbsp;&nbsp;
                    </td>
                    <td align="right" width="200"><img src="<?php echo $loc_jui . "themes/icons/version.png" ?>" id="version"></td>

                </tr>
            </table>
        </div>
    </form>
</div>
<script>


    $(document).ready(function ()
    {


        $('#arg_date1').datebox('setValue', date1);
        $('#arg_date2').datebox('setValue', date2);

        setEnable();
        $(".loader").hide(1000);
        version('04.17-25');
        
        $('#trans').click(function () {
            if ($(this).prop("checked") == true) {
                $(this).val(1);
            }
            else if ($(this).prop("checked") == false) {
                $(this).val(0);
            }
        });
    });
    function setEnable()
    {
        //window.alert("masuk");

        $('#arg_date1').datebox('enable');
        $('#arg_date2').datebox('enable');
        $('#cls').combobox('enable');
        $('#cust_name').combogrid('enable');
        $('#sort_by').combobox('enable');
        
    }
    function doSearch(lcOutput)
    {
        url = "services/runCRUD.php";

        lcarg_date1 = $('#arg_date1').datebox('getValue');
        lcarg_date2 = $('#arg_date2').datebox('getValue');
        if (lcarg_date1.length == 0 || lcarg_date2.length == 0)
        {
            showAlert("Tanggal tidak boleh kosong");
            return false;
        }
        lcsort_by = $('#sort_by').combobox('getValue');
        lccust_code = $('#cust_code').val();
        lccls = $('#cls').combobox('getValue');
        lctrans = $("#trans").val();
        
        
        var strWindowFeatures = "location=yes,height=650,width=1500,scrollbars=yes,status=yes";
        var URL = url + "?lookup=rpt/kasir/pembayaranpiutangkendaraangabungan"
                + "&output=" + lcOutput
                + "&arg_date1=" + lcarg_date1
                + "&arg_date2=" + lcarg_date2
                + "&cust_code=" + lccust_code
                + "&sort_by=" + lcsort_by
                + "&cls=" + lccls
                + "&trans=" + lctrans
                ;

        URL = URL + '#toolbar=0';
        if (lcOutput !== 'screen') {
            $("#screenWindow").empty().append('<iframe frameborder="0"  src="' + URL + '" style="width:100%;height:auto;min-height: 500px;padding:0px;"></iframe>');
        } else {
            var win = window.open(URL, "_blank", strWindowFeatures);
        }
    }
    $('#cust_name').combogrid({
        onSelect: function (index, row) {
            if (row) {
                $("#cust_code").val(row.cust_code);
            }
        },
        onChange: function () {
            if ($('#cust_name').combogrid('getValue') == '')
            {
                $("#cust_code").val('');
            }
        }

    });


</script>
