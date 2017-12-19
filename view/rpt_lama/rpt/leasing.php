<?php
$close = array
    (
    array("Closed", "1"),
    array("Not Closed", "2"),
    array("All", "3"),
);
$optGroupBy = array
    (
    array('Nama Pelanggan & Kode Leasing', '1'),
    array('Kode Leasing & Nama Pelanggan', '2'),
    array('Kode Asuransi & Nama Pelanggan', '3'),
    array('No.Rangka & Model', '4'),
    array('Nama Sales & Nama Pelanggan', '5')
);
?>
<div style=" margin: 10px;" id="form_content">
    <form id="formactive" >
        <h1 style="font-size:20px">Leasing & Refund Report</h1>
        <div class="single-form teen-margin">
            <table>
                <table >
                    <?php
                    localcombobox('cls', 'Cetak Faktur Jual', 200, $close);
                    datebox('date1', 'Tanggal', 200);
                    datebox('date2', 's/d', 200);
                    localcombobox('group_by', 'Group By', 250, $optGroupBy);
                    ?>
                </table>
            </table>
        </div>

        <div  class="single-form">  
            <strong> FILTER BY </strong>
            <table>
                <?php
                cmdLeaseSet('lease_code', 'lease_name', 'Leasing');
                cmdCustSet('cust_code', 'cust_name', 'Pelanggan');
                cmdSalSet('srep_code', 'srep_name', 'Sales');
                cmdInsurance('insr_code', 'insr_name', 'Asuransi');
                cmdWrhs('wrhs_code', 'Warehouse', 150);
                ?>
            </table>
        </div>
        <div class="main-nav">
            <table>		
                <tr>
                    <td >
                        <a href="#" class="easyui-linkbutton"  onclick="doSearch('screen')">Screen</a>
                        &nbsp;&nbsp;

                        <a href="#" class="easyui-linkbutton"  onclick="doSearch('print')">Printer</a>
                        &nbsp;&nbsp;

                        <a href="#" class="easyui-linkbutton"  onclick="doSearch('export')"><?php getCaption('Eksport'); ?></a>
                        &nbsp;&nbsp;
                    </td>
                </tr>
            </table>
        </div>

    </form>
</div>
<script>
    $(document).ready(function () {
        setEnable();
        $(".loader").hide(1000);
         var ldServer = '<?php echo date('y-m-d'); ?>';
        $('#date1').datebox('setValue', ldServer);
        $('#date2').datebox('setValue', ldServer);
    });

    function setEnable() {
        $('#cls').combobox('enable');
        $('#date1').datebox('enable');
        $('#date2').datebox('enable');
        $('#group_by').combobox('enable');
        $("#formactive .easyui-combogrid").combogrid('enable');
    }

    function doSearch(Output) {
        url = "services/runCRUD.php";

        cls = $('#cls').combobox('getValue');
        date1 = $('#date1').datebox('getValue');
        date2 = $('#date2').datebox('getValue');

        if ((date1.length == 0) || (date2.length == 0))
        {
            showAlert("Warning", "<font color='red'>Tanggal tidak boleh kosong!</font>");
            return false;
        }

        wrhs_code  = $('#wrhs_code').combobox('getValue');
        group_by   = $('#group_by').combobox('getValue');
        lease_code = $("#lease_code").val();
        cust_code  = $("#cust_code").val();
        srep_code  = $("#srep_code").val();
        insr_code  = $("#insr_code").val();

        var strWindowFeatures = "location=yes,height=570,width=520,scrollbars=yes,status=yes";
        var strWindowFeatures = "location=yes,scrollbars=yes,status=yes";
        var URL = url + "?lookup=rpt/leasingrefund"
                + "&cls=" + cls
                + "&date1=" + date1
                + "&date2=" + date2
                + "&lease_code="+lease_code
                + "&cust_code="+cust_code
                + "&srep_code="+srep_code
                + "&insr_code="+insr_code
                + "&wrhs_code=" + wrhs_code
                + "&output=" + Output
                + "&group_by=" + group_by;
        var win = window.open(URL, "_blank", strWindowFeatures);
    }

    $('#lease_name').combogrid({
        onSelect: function (index, row) {
            if (row) {
                $("#lease_code").val(row.lease_code);
            }
        },
        onChange: function () {
            if ($('#lease_name').combogrid('getValue') == '')
            {
                $("#lease_code").val('');
            }
        }

    });

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

    $('#srep_name').combogrid({
        onSelect: function (index, row) {
            if (row) {
                $("#srep_code").val(row.srep_code);
            }
        },
        onChange: function () {
            if ($('#srep_name').combogrid('getValue') == '')
            {
                $("#srep_code").val('');
            }
        }

    });

    $('#insr_name').combogrid({
        onSelect: function (index, row) {
            if (row) {
                $("#insr_code").val(row.insr_code);
            }
        },
        onChange: function () {
            if ($('#insr_name').combogrid('getValue') == '')
            {
                $("#insr_code").val('');
            }
        }

    });
</script>