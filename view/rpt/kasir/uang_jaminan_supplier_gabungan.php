<?php
$form = 'rpt_dpsgd';
$table = "";
$lookup = 'mst/' . $table;
?>
<div style=" margin: 10px;" id="form_content">
    <form id="<?php echo $form; ?>" >
        <div class="single-form teen-margin">
            <table>
                <tr><td colspan="3"> <h1 style="font-size:18px"><u>REPORT BY</u></h1></td></tr>
                <?php
                datebox('dp_date1', 'Tanggal Faktur', 200);
                datebox('dp_date2', 's/d', 200);
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

        $('#dp_date1').datebox('setValue', date1);
        $('#dp_date2').datebox('setValue', date2);

        setEnable();
        $(".loader").hide(1000);
        version('04.17-25');
    });
    function setEnable()
    {
        //window.alert("masuk");

        $('#dp_date1').datebox('enable');
        $('#dp_date2').datebox('enable');
        $('#supp_name').combogrid('enable');
        $('#pay_type').combogrid('enable');

    }
    function doSearch(lcOutput)
    {
        url = "services/runCRUD.php";

        lcdp_date1 = $('#dp_date1').datebox('getValue');
        lcdp_date2 = $('#dp_date2').datebox('getValue');
        if (lcdp_date1.length == 0 || lcdp_date2.length == 0)
        {
            showAlert("Tanggal tidak boleh kosong");
            return false;
        }
        lcpay_type = $('#pay_type').combogrid('getValue');
        lcsupp_code = $('#supp_code').val();
        
        var strWindowFeatures = "location=yes,height=650,width=1500,scrollbars=yes,status=yes";
        var URL = url + "?lookup=rpt/kasir/uang_jaminan_supplier_gabungan"
                + "&output=" + lcOutput
                + "&dp_date1=" + lcdp_date1
                + "&dp_date2=" + lcdp_date2
                + "&supp_code=" + lcsupp_code
                + "&pay_type=" + lcpay_type
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
