<div style="margin: 10px;" id="form_content">
    <div class="single-form">
        <?php
        $form = 'rpt_spk_management';
        $table = "";
        $lookup = 'mst/' . $table;

        echo '<form id="' . $form . '" >';
        echo '<table cellpadding="5">';

        $spk = array
            (
            array("Registered Only", "1"),
            array("Registered & Distributed", "2"),
            array("All SPK", "0"),
        );
        $status = array
            (
            array("Unused", "1"),
            array("Used", "2"),
            array("ALL", "0"),
        );
        echo '</table>';
//echo '<script src="../lib/xls/jquery.battatech.excelexport.js"></script>';	
        ?>
        <table cellpadding="5" style="margin: 0cm 0px 0px 0px">
            <?php
            localcombobox('so_reg', 'SPK', 200, $spk);
            localcombobox('so_status', 'Status', 200, $status);
            //textbox('','Eksport',200);
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

                    <a href="#" class="easyui-linkbutton"  onclick="doSearch('export')">Export</a>
                    &nbsp;&nbsp;
                </td>

            </tr>
        </table>
    </div>

</div>
<script>


    $(document).ready(function () {
        //console.log( "ready!" );
        setEnable();
    });
    function setEnable()
    {
        //window.alert("masuk");
        $('#so_reg').combobox('enable');
        $('#so_status').combobox('enable');

    }
    function doSearch(lcOutput)
    {
        lcso_reg = $('#so_reg').combobox('getValue');
        lcso_status = $('#so_reg').combobox('getValue');
        url = "services/runCRUD.php";
        data = "&lookup=rpt/spk_management"
                + "&so_reg=" + lcso_reg
                + "&so_status=" + lcso_status
                + "&output=" + lcOutput;
        /*$.post( url, data )
         .done(function( data ) {
         obj = JSON.parse(data);
         if (obj.success==true){
         
         }else
         {
         showAlert("Error while saving",obj.message);
         }
         })
         .fail(function() {
         showAlert("Error","Error while saving");
         })*/
        var strWindowFeatures = "location=yes,height=570,width=520,scrollbars=yes,status=yes";
        var strWindowFeatures = "location=yes,scrollbars=yes,status=yes";
        var URL = url + "?lookup=rpt/spk_management"
                + "&so_reg=" + lcso_reg
                + "&so_status=" + lcso_status
                + "&output=" + lcOutput;
        var win = window.open(URL, "_blank", strWindowFeatures);
    }
</script>
