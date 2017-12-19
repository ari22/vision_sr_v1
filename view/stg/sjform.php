<div style=" margin: 10px;" id="form_content">
    <form id="form_validation" method="post" >
        <div id="tableId"></div>
        <div class="single-form">
            <table>
                <tr><td colspan="4"><h1 style="font-size: 14px;">Vehicle Equipment</h1></td></tr>
                <tr>
                    <td width="20"></td>
                    <td valign="top">
                        <table>
                            <?php                           
                            for($i=1;$i<=12;$i++){
                                $item = 'sj_item'.$i;
                                echo "<tr><td>$i.</td><td><input type='text' class='easyui-validatebox textbox' name='$item' id='$item' style='width:250px;'></td></tr>";
                            }
                            ?>                          
                        </table>
                    </td>
                    <td valign="top">
                        <table>
                            <?php                           
                            for($i=13;$i<=24;$i++){
                                $item = 'sj_item'.$i;
                                echo "<tr><td>$i.</td><td><input type='text'  class='easyui-validatebox textbox' name='$item' id='$item' style='width:250px;'></td></tr>";
                            }
                            ?>                             
                        </table>
                    </td>
                    <td valign="top">
                        <table>
                            <?php                           
                            for($i=25;$i<=35;$i++){
                                $item = 'sj_item'.$i;
                                echo "<tr><td>$i.</td><td><input type='text'  class='easyui-validatebox textbox' name='$item' id='$item' style='width:250px;'></td></tr>";
                            }
                            ?> 
                        </table>
                    </td>
                </tr>
                <tr><td><br /></td></tr>
                <tr><td colspan="3"><h1 style="font-size: 14px;">Information</h1></td></tr>
                <tr> <td width="20"></td><td colspan="3"><table><tr><td class="col20"></td><td><textarea rows="4" autocomplete="off"  class="easyui-validatebox textbox" type="text" id="sj_note" name="sj_note" style="width:820px;" disabled=true maxlength="560"></textarea></td></tr></table></td></tr>
            </table>
        </div>

        <div class="main-nav">
            <table width="100%">
                <tr>
                    <td><button type="button" id="cmdSave" title="Save"  data-options="iconCls:'icon-save',group:'g2'" class="easyui-linkbutton cmdSave" onclick="saveData()" > Save</button></td>
                    <td align="right"><img src="<?php echo $loc_jui . "themes/icons/version.png" ?>" id="version"></td> 
                </tr>
            </table>
        </div>
    </form>
</div>

<script>
    var table = 'vehsjitm';
    var save_url = site_url + 'transaction/setting/saveSet_form';
    var form = $('#form_validation');
    var divtableId = $("#tableId");

    tableId();
    read_show();
    version('05.04-17');

    function tableId() {
        divtableId.empty().append('<input type="hidden" name="id"  id="id"><input type="hidden" name="table"  id="table" value="' + table + '">');
    }
    function read_show() {
        $(".loader").show();
        $.post(site_url + 'crud/read', {table: table, nav: '', id: 1}, function (json) {
            var rowData = $.parseJSON(json);

            $.each(rowData, function (i, v) {
                $("#" + i).val(v);
            });
            $(".loader").hide();
            $('#form_validation :input').attr('disabled', false);
        });
    }
    function saveData() {
        $('.loader').show();

        form.form('submit', {
            url: save_url,
            onSubmit: function () {
                return $(this).form('validate');
            },
            success: function (data) {
                var obj = JSON.parse(data);
                if (obj.success == true) {
                    read_show();
                    showAlert("Information", obj.message);

                } else
                {
                    $('.loader').hide();
                    showAlert("Error while saving", '<font color="red">' + obj.message + '</font>');
                }
            }
        });

    }
</script>