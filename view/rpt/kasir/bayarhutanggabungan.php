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
?>
<div style=" margin: 10px;" id="form_content">
    <form id="<?php echo $form; ?>" >
        <div class="single-form teen-margin">
            <table>
                <tr><td colspan="3"> <h1 style="font-size:18px"><u>REPORT BY</u></h1></td></tr>
                <?php
                 localcombobox('cls', 'Cetak Faktur', 100, $closed);
                datebox('apg_date1', 'Tanggal Faktur', 200);
                datebox('apg_date2', 's/d', 200);
                ?>
                <tr><td class="col120"></td></tr>
            </table>
        </div>

        <div  class="single-form">  

            <table>
                <tr><td colspan="3"><h1><u>FILTER BY</u></h1></td></tr>
                <?php
                cmdSuppSet('supp_code', 'supp_name', 'Supplier');

                $url = "services/runCRUD.php?func=datasource&lookup=mst/pay_type&pk=pay_type&sk=pay_name&order=pay_name&fields=id,pay_type,pay_name";
                ?>
                <tr> <td><?php getCaption('Cara Bayar'); ?> </td>
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
                        </input></td></tr>
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

        $('#apg_date1').datebox('setValue', date1);
        $('#apg_date2').datebox('setValue', date2);

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

        $('#apg_date1').datebox('enable');
        $('#apg_date2').datebox('enable');
        $('#supp_name').combogrid('enable');
        $('#pay_type').combogrid('enable');
         $('#cls').combobox('enable');

    }
    function doSearch(lcOutput)
    {
        url = "services/runCRUD.php";

        lcapg_date1 = $('#apg_date1').datebox('getValue');
        lcapg_date2 = $('#apg_date2').datebox('getValue');
        if (lcapg_date1.length == 0 || lcapg_date2.length == 0)
        {
            showAlert("Tanggal tidak boleh kosong");
            return false;
        }
        lcpay_type = $('#pay_type').combogrid('getValue');
        lcsupp_code = $('#supp_code').val();
        lccls = $('#cls').combobox('getValue');
        lctrans = $("#trans").val();
        
        var strWindowFeatures = "location=yes,height=650,width=1500,scrollbars=yes,status=yes";
        var URL = url + "?lookup=rpt/kasir/pembayaranhutangkendaraangabungan"
                + "&output=" + lcOutput
                + "&apg_date1=" + lcapg_date1
                + "&apg_date2=" + lcapg_date2
                + "&supp_code=" + lcsupp_code
                + "&pay_type=" + lcpay_type
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
    $('#supp_name').combogrid({
        onSelect: function (index, row) {
            if (row) {
                $("#supp_code").val(row.supp_code);
            }
        },
        onChange: function () {
            if ($('#supp_name').combogrid('getValue') == '')
            {
                $("#supp_code").val('');
            }
        }

    });

</script>
