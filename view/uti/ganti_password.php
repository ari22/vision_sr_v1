
<div style=" margin: 10px;" id="form_content">
    <div class="single-form">
        <form id="<?php echo $form; ?>" >
            <table >
                <?php textbox('c_user', 'Username', 200, 5); ?>
                <?php password('c_oldpwd', 'Old Password', 200, 20); ?>
                <?php password('c_newpwd1', 'New Password', 200, 20); ?>
                <?php password('c_newpwd2', 'Pwd Confirmation', 200, 20); ?>
            </table>
        </form>

    </div>
    <div class="main-nav">
        <table width="100%">
            <tr>
                <td width="400">
                            <a href="#" id="cmdSave"  class="easyui-linkbutton easyui-tooltip"  
           data-options="group:'g2',disabled:true,iconCls:'icon-save'" onclick="saveData()" >Update</a>
                </td>
                <td align="right"><img src="<?php echo $loc_jui . "themes/icons/version.png" ?>" id="version"></td> 
            </tr>
        </table>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('.loader').hide();
        $('#c_user').val('<?php echo $_SESSION['C_USER']; ?>');
        $('#c_oldpwd').attr('disabled', false);
        $('#c_newpwd1').attr('disabled', false);
        $('#c_newpwd2').attr('disabled', false);
        $('#cmdSave').linkbutton('enable');  
        version('07.17-31');
        
    });
    function saveData() {
        url = "services/runCRUD.php";
        data = "lookup=uti/ganti_password"
                + "&c_oldpwd=" + $('#c_oldpwd').val()
                + "&c_newpwd1=" + $('#c_newpwd1').val()
                + "&c_newpwd2=" + $('#c_newpwd2').val();
       
        $.post(url, data)
                .done(function (res) { 
                    obj = JSON.parse(res);
                  
                    if (obj.success == true) {
                        showAlert("Success", obj.message);
                        $('#c_oldpwd').val('');
                        $('#c_newpwd1').val('');
                        $('#c_newpwd2').val('');
                    } else
                    {
                        showAlert("Alert", obj.message);
                    }
                    scrlTop();
                })
                .fail(function () {
                    showAlert("Error", "Error while saving");
                })

    }

</script>