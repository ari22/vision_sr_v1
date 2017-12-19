<div style=" margin: 10px;" id="form_content">
    <form id="form_validation" method="post" >
        <div id="tableId"></div>
        <div class="single-form">
            <table>
                <tr>
                    <td></td>
                    <td class="td-ro"></td>
                    <td><b>Code#1</b></td>
                    <td><b>Code#2</b></td>
                    <td width="30"><b>Year</b></td>
                    <td><b>Sequence#</b></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Tax Invoice No</td>
                    <td class="td-ro">:</td>
                    <td><?php textbox2('fp_code1', 50, 50); ?></td>
                    <td><?php textbox2('fp_code2', 50, 50); ?></td>
                    <td width="30"></td>
                    <td><?php textbox2('fp_no', 78, 50); ?></td>
                    <td style="color:red;">Important: This number can not be changed</td>
                </tr>
                <tr>
                    <td>Example</td>
                    <td class="td-ro">:</td>
                    <td style="color:#003399;">010.</td>
                    <td style="color:#003399;">900-</td>
                    <td style="color:#003399;" width="30">13.</td>
                    <td style="color:#003399;">12345678</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Next Tax Invoice No</td>
                    <td class="td-ro">:</td>
                    <td colspan="4"><?php textbox2('inv_no', 234, 234); ?></td>
                    <td style="color:#003399;">(May change if any other User is print a Tax Invoice)</td>
                </tr>

                <tr>
                    <td></td>
                    <td class="td-ro"></td>
                    <td colspan="2" align='right'><b>From</b></td>
                    <td colspan="2" align='right'><b>To</b></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Allocated Tax Invoice No</td>
                    <td class="td-ro">:</td>
                    <td colspan="2"><?php textbox2('fp_no_beg', 114, 114); ?></td>
                    <td colspan="2"><?php textbox2('fp_no_end', 114, 114); ?></td>
                    <td></td>
                </tr>
                <tr><td><br /></td></tr>
                <tr>
                    <td></td>
                    <td class="td-ro"></td>
                    <td colspan="4"><b>Signed by/Yg tanda tangan</b></td>
                    <td><b>Title/Jabatan</b></td>
                </tr>

                <tr>
                    <td>Showroom</td>
                    <td class="td-ro">:</td>
                    <td colspan="4"><?php textbox2('sign_sr', 234, 234); ?></td>
                    <td><?php textbox2('title_sr', 234, 234); ?></td>
                </tr>

                <tr>
                    <td>Service</td>
                    <td class="td-ro">:</td>
                    <td colspan="4"><?php textbox2('sign_srv', 234, 234); ?></td>
                    <td><?php textbox2('title_srv', 234, 234); ?></td>
                </tr>

                <tr>
                    <td>Spare Parts</td>
                    <td class="td-ro">:</td>
                    <td colspan="4"><?php textbox2('sign_prt', 234, 234); ?></td>
                    <td><?php textbox2('title_prt', 234, 234); ?></td>
                </tr>

                <tr>
                    <td>Body & Paint</td>
                    <td class="td-ro">:</td>
                    <td colspan="4"><?php textbox2('sign_bdp', 234, 234); ?></td>
                    <td><?php textbox2('title_bdp', 234, 234); ?></td>
                </tr>

                <tr>
                    <td>General</td>
                    <td class="td-ro">:</td>
                    <td colspan="4"><?php textbox2('sign', 234, 234); ?></td>
                    <td><?php textbox2('title', 234, 234); ?></td>
                </tr>
            </table>
        </div>
        <div class="main-nav">
            <table width="100%">
                <tr>
                    <td width="300">
                        <button type="button" id="cmdSave" title="Save"  data-options="iconCls:'icon-save',group:'g2'" class="easyui-linkbutton cmdSave" onclick="saveData()" ></button>
                        <button type="button" id="cmdCancel" title="Batal" data-options="iconCls:'icon-undo',group:'g2'" class="easyui-linkbutton cmdCancel"  onclick="rolesCancel()"  ></button>                   
                        <button type="button" id="cmdEdit" title="<?php getCaption("Ubah"); ?>" data-options="iconCls:'icon-edit'" class="easyui-linkbutton cmdEdit"  onclick="rolesEdit()" ></button>
                    </td>
                    <td align="right"><img src="<?php echo $loc_jui . "themes/icons/version.png" ?>" id="version"></td> 
                </tr>
            </table>
        </div>
    </form>
</div>
<style>
    #fp_no,#fp_no_beg,#fp_no_end{text-align: right;}
</style>
<script>
    var table = 'fp_seq';
    var save_url = site_url + 'transaction/setting/saveSet_form';
    var form = $('#form_validation');
    var divtableId = $("#tableId");


    function tableId() {
        divtableId.empty().append('<input type="hidden" name="id"  id="id"><input type="hidden" name="table"  id="table" value="' + table + '">');
    }
    function read_show() {
        $.post(site_url + 'crud/read', {table: table, nav: '', id: 1}, function (json) {
            var rowData = $.parseJSON(json);

            $.each(rowData, function (i, v) {
                $("#" + i).val(v);
            });

            var inv_no = rowData.fp_code1 + rowData.fp_code2 + '<?php echo date("y"); ?>.' + rowData.fp_no;
            $("#inv_no").val(inv_no);
            $(".loader").hide();
        });
        formDisabled();
        cmdcondAwal();
    }

    function condEdit() {
        condReady();
    }
    function condReady() {
        $('#form_validation #fp_code1,#fp_code2,#fp_no,#fp_no_beg,#fp_no_end,#sign_sr,#title_sr').attr('disabled', false);
        cmdcondReady();
    }
    function cmdcondReady() {
        $('.cmdSave').removeAttr('disabled');
        $('.cmdCancel').removeAttr('disabled');
        $('.cmdEdit').attr('disabled', true);

        $('.cmdSave').linkbutton('enable');
        $('.cmdCancel').linkbutton('enable');
        $('.cmdEdit').linkbutton('disable');
    }
    function cmdcondAwal() {
        $('.cmdSave').attr('disabled', true);
        $('.cmdCancel').attr('disabled', true);
        $('.cmdEdit').removeAttr('disabled');

        $('.cmdSave').linkbutton('disable');
        $('.cmdCancel').linkbutton('disable');
        $('.cmdEdit').linkbutton('enable');


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

    function condCancel() {
        cmdcondAwal();
        read_show('');
        $("#form_validation .formError").remove();
        $("#form_validation .easyui-datebox").datebox('disable');
    }

    function formDisabled() {
        $('#form_validation #fp_code1,#fp_code2,#fp_no,#fp_no_beg,#fp_no_end,#sign_sr,#title_sr').attr('disabled', true);
        //$('#form_validation :input').attr('disabled', true);
    }
    $(document).ready(function () {
        tableId();
        read_show();
        version('05.04-17');
    });
</script>