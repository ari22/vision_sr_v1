<?php
$form = 'rpt_uj';
$table = "";
$lookup = 'mst/' . $table;

$optGroupBy = array
    (
    array("Supplier", "1"),
    array("Invoice Type", "2"),
    array("Payment Type", "3")
);

$optInvoice = array
    (
    array('All', ''),
    array('APR', 'APR'),
    array('APW', 'APW')
);


$site_url = str_replace("loader_rpt.php", '', $site_url);
?>

<div style=" margin: 10px;" id="form_content">
    <form id="<?php echo $form; ?>" >
        <div class="single-form teen-margin">
            <table> 
                <tr><td colspan="3"> <h1 style="font-size:18px"><u>REPORT BY</u></h1></td></tr>
                <tr>
                    <td><?php getCaption('Tanggal Bayar'); ?></td>
                    <td class="td-ro">:</td>
                    <td colspan="3">
                        <?php datebox2('date1') ?>
                        <?php datebox2('date2') ?>
                    </td>
                </tr>
                <?php
                localcombobox('group_by', 'Group By', 200, $optGroupBy);
                ?>
                 <tr><td class="col120"></td></tr>
            </table>
        </div>

        <div class="single-form">  
 	
                    <table>
                         <tr><td colspan="3"><h1><u>FILTER BY</u></h1></td></tr>
                        <?php
                        cmdSuppSet('supp_code', 'supp_name', 'Supplier');
                        localcombobox('pinv_code', 'Jenis Faktur', 160, $optInvoice);
                        cmdPayType('pay_type', 'Jenis Bayar', $site_url, 100);
                        ?>
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

        $('#date1').datebox('setValue', date1);
        $('#date2').datebox('setValue', date2);

        setEnable();
        $(".loader").hide(1000);
         version('04.17-25');
    });
    function setEnable()
    {
        //window.alert("masuk");

        $('#date1').datebox('enable');
        $('#date2').datebox('enable');
        $('#group_by').combobox('enable');
        //$('#sinv_code').combobox('enable');
        //  $('#pay_type').combogrid('enable');
        $('#supp_name').combogrid('enable');

    }
    function doSearch(lcOutput)
    {
        url = "services/runCRUD.php";

        lcso_date1 = $('#date1').datebox('getValue');
        lcso_date2 = $('#date2').datebox('getValue');
        if ((lcso_date1.length == 0) || (lcso_date2.length == 0))
        {
            showAlert("Warning", "<font color='red'>Tanggal tidak boleh kosong!</font>");
            return false;
        }

        date1 = $('#date1').datebox('getValue');
        date2 = $('#date2').datebox('getValue');
        group_by = $('#group_by').combobox('getValue');
        pinv_code = $('#pinv_code').combobox('getValue');
        pay_type = $('#pay_type').combogrid('getValue');
        supp_name = $('#supp_name').combogrid('getValue');

        var strWindowFeatures = "location=yes,height=650,width=1500,scrollbars=yes,status=yes";
        var URL = url + "?lookup=rpt/kasir/bayarhutangacc"
                + "&output=" + lcOutput
                + "&date1=" + date1
                + "&date2=" + date2
                + "&group_by=" + group_by
                + "&pinv_code=" + pinv_code
                + "&pay_type=" + pay_type
                + "&supp_name=" + supp_name;


        URL = URL + '#toolbar=0';
        if (lcOutput !== 'screen') {
            $("#screenWindow").empty().append('<iframe frameborder="0"  src="' + URL + '" style="width:100%;height:auto;min-height: 500px;padding:0px;"></iframe>');
        } else {
            var win = window.open(URL, "_blank", strWindowFeatures);
        }
    }

    $("#group_by").combobox({
        onChange: function () {

            $('#supp_name').val('');
            $('.easyui-combogrid').combogrid('setValue', '');
            $('#sinv_code').combobox('setValue', '');


            $('#pinv_code').combogrid('disable');
            $("#supp_name").combogrid('disable');

            var group = $(this).combobox('getValue');

            if (group == '1') {
                $("#supp_name").combogrid('enable');
            }
            if (group == '2') {
                $('#pinv_code').combogrid('enable');
            }
            if (group == '3') {
                $('#pay_type').combogrid('enable');
            }

        }
    });



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
