<div id="bayarBBN" class="easyui-window" title="BBN Payment" data-options="modal:true,closed:true,resizable:false,maximizable:true,minimizable:false,collapsible:false" 
     style="padding:10px;top:1;">
    <br>
    <table>
        <tbody>
            <?php
            numberbox('bbn_val', 'BBN', 100, 30);
            numberbox('bbn_dpp', 'DPP', 100, 30);
            numberbox('bbn_ppn', 'PPN', 100, 30);
            numberbox('pay_val1', 'Uang Jaminan', 100, 30);
            ?>
        </tbody>
    </table>
    <br>
    <table>	
        <tr>
            <td align=right width=100>

            </td>
            <td align=center width=150>
                <a href="#" id="cmdSave2" title="Save" class="easyui-linkbutton easyui-tooltip" data-options="iconCls:'icon-save'" onclick="saveBayarBBN()" >Save</a>
                <a href="#" id="cmdCancel2" title="Cancel" class="easyui-linkbutton easyui-tooltip" data-options="iconCls:'icon-undo'" onclick="condAwalBayarBBN()" >Cancel</a>
            </td>
        </tr>
    </table>
    <br>
</div>
<script>
    function condBayarBBN()
    {
        var pay_val = $("#pay_val").numberbox('getValue');

        msg = true;

        if (pay_val == '') {
            msg = false;
        }
        if (pay_val == 0) {
            msg = false;
        }

        if (msg !== false) {
            var dpp = Math.round(pay_val / 1.1);
            var ppn = Math.round((dpp / 100) * 10);
            var pay_val1 = dpp + ppn;


            $("#bbn_val").attr('disabled', false);
            $("#bbn_dpp").numberbox('setValue', dpp);
            $("#bbn_ppn").numberbox('setValue', ppn);
            $("#pay_val1").numberbox('setValue', pay_val1);
            $("#bbn_val").numberbox('setValue', '');
            $('#bayarBBN').window('open');
        } else {
            showAlert("Please enter Down Payment", "<font color='red'>Masukkan dulu nilai uang jaminan yang akan diperinci</font>");

        }

    }
    function saveBayarBBN()
    {
        var save_bbn = site_url + 'transaction/cashier/saveBBNDownpayment';
        var data = "&id=" + $('#id2').val()
                + "&bbn_val=" + $('#bbn_val').numberbox('getValue')
                + "&table=veh_dpcd";

        $.post(save_bbn, data).done(function (res) {
            //alert(res)
            obj = JSON.parse(res);
            if (obj.success == true)
            {
                read_show('');
                read_show2('');

            } else {
                showAlert("Informasi", '<font color="red">' + obj.message + '</font>');
            }
        }).fail(function () {
            showAlert("Error", "<font color='red'>Error while saving</font>");
        });
        $('#bayarBBN').window('close');
    }
    function condAwalBayarBBN()
    {
        $('#bayarBBN').window('close');
    }
</script>