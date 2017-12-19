<div style=" margin: 10px;" id="form_content">
    <form id="form_validation" method="post" >
        <div id="tableId"></div>
        <div class="single-form">
            <table>
                <tr>
                    <td>
                        <table>
                            <tr><td class="col50"><?php echo getCaption('Kode'); ?></td> <td><?php textbox2('form_code', 100, 100); ?></td><td class="col50"><?php echo getCaption('Keterangan'); ?></td> <td><?php textbox2('form_name', 636, 100); ?></td></tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table>
                            <tr>
                                <td>Note1</td>
                                <td><?php textbox2('inote1', 810, 810); ?></td>
                            </tr>
                            <tr>
                                <td>Note2</td>
                                <td><?php textbox2('inote2', 810, 810); ?></td>
                            </tr>
                            <tr>
                                <td>Note3</td>
                                <td><?php textbox2('inote3', 810, 810); ?></td>
                            </tr>
                            <tr>
                                <td>Note4</td>
                                <td><?php textbox2('inote4', 810, 810); ?></td>
                            </tr>
                            <tr>
                                <td>Note5</td>
                                <td><?php textbox2('inote5', 810, 810); ?></td>
                            </tr>
                            <tr><td></td></tr>
                            <tr>
                                <td>eNote1</td>
                                <td><?php textbox2('enote1', 810, 810); ?></td>
                            </tr>
                            <tr>
                                <td>eNote2</td>
                                <td><?php textbox2('enote2', 810, 810); ?></td>
                            </tr>
                            <tr>
                                <td>eNote3</td>
                                <td><?php textbox2('enote3', 810, 810); ?></td>
                            </tr>
                            <tr>
                                <td>eNote4</td>
                                <td><?php textbox2('enote4', 810, 810); ?></td>
                            </tr>
                            <tr>
                                <td>eNote5</td>
                                <td><?php textbox2('enote5', 810, 810); ?></td>
                            </tr>
                            <tr><td class="col50"></td></tr>
                        </table>
                    </td>
                </tr>
                <tr><td><br /></td></tr>
                <tr>
                    <td>
                        <table>
                            <tr><td class="col50"></td><td align="center"><b>(1)</b></td><td align="center"><b>(2)</b></td><td align="center"><b>(3)</b></td><td align="center"><b>(4)</b></td></tr>
                            <tr><td>Sign</td><td><?php textbox2('sign1', 200, 200); ?></td><td><?php textbox2('sign2', 200, 200); ?></td><td><?php textbox2('sign3', 200, 200); ?></td><td><?php textbox2('sign4', 200, 200); ?></td></tr>
                            <tr><td>eSign</td><td><?php textbox2('esign1', 200, 200); ?></td><td><?php textbox2('esign2', 200, 200); ?></td><td><?php textbox2('esign3', 200, 200); ?></td><td><?php textbox2('esign4', 200, 200); ?></td></tr>
                            <tr><td><br /></td></tr>
                            <tr><td>Name</td><td><?php textbox2('name1', 200, 200); ?></td><td><?php textbox2('name2', 200, 200); ?></td><td><?php textbox2('name3', 200, 200); ?></td><td><?php textbox2('name4', 200, 200); ?></td></tr>
                            <tr><td>Title</td><td><?php textbox2('title1', 200, 200); ?></td><td><?php textbox2('title2', 200, 200); ?></td><td><?php textbox2('title3', 200, 200); ?></td><td><?php textbox2('title4', 200, 200); ?></td></tr>
                            <tr><td><br /></td></tr>
                            <tr><td>Form ID</td><td><?php textbox2('form_id', 200, 200); ?></td></tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
        <div class="main-nav">
            <table width="100%">
                <tr>
                    <td width="400"><?php navigation_ci(); ?></td>
                    <td align="right"><img src="<?php echo $loc_jui . "themes/icons/version.png" ?>" id="version"></td> 
                </tr>
            </table>
        </div>
    </form>
</div>
<style>
    #form_code{text-transform: uppercase};
</style>
<script>

    var divtableId = $("#tableId");
    var table = 'set_form';
    var save_url = site_url + 'transaction/setting/saveSet_form';
    var deleteurl = site_url + 'transaction/setting/deleteSet_form';
    var form = $('#form_validation');

    function tableId() {
        divtableId.empty().append('<input type="hidden" name="id"  id="id"><input type="hidden" name="table"  id="table" value="' + table + '">');
    }

    function getSearchselect() {
        var row = $("#tableSearch").datagrid('getSelected');

        if (row) {
            $("#form_validation #id").val(row.id);
            $('#windowSearch').window('close');
            $("#actionSearch").empty()
            $("#SearchOption").hide();
            read_show('');

        }
    }

    function read_show(nav) {
        var id = $("#form_validation #id").val();

        $.post(site_url + 'crud/read', {table: table, nav: nav, id: id}, function (json) {

            $('#form_validation input:text').val('');

            if (json !== '[]') {

                var rowData = $.parseJSON(json);

                $.each(rowData, function (i, v) {
                    $("#" + i).val(v);
                });


            }
            cmdcondAwal();
            formDisabled();
            $('.loader').hide();
        });
    }


    function formDisabled() {
        $('#form_validation :input').attr('disabled', true);
        cmdcondAwal();
    }

    function cmdcondAwal() {
        $('.cmdFirst').removeAttr('disabled');
        $('.cmdPrev').removeAttr('disabled');
        $('.cmdNext').removeAttr('disabled');
        $('.cmdLast').removeAttr('disabled');
        $('.cmdSave').attr('disabled', true);
        $('.cmdCancel').attr('disabled', true);
        $('.cmdAdd').removeAttr('disabled');
        $('.cmdEdit').removeAttr('disabled');
        $('.cmdDelete').removeAttr('disabled');
        $('.cmdSearch').removeAttr('disabled');


        $('.cmdFirst').linkbutton('enable');
        $('.cmdPrev').linkbutton('enable');
        $('.cmdNext').linkbutton('enable');
        $('.cmdLast').linkbutton('enable');
        $('.cmdSave').linkbutton('disable');
        $('.cmdCancel').linkbutton('disable');
        $('.cmdAdd').linkbutton('enable');
        $('.cmdEdit').linkbutton('enable');
        $('.cmdDelete').linkbutton('enable');
        $('.cmdSearch').linkbutton('enable');

    }

    function cmdcondReady() {
        $('.cmdFirst').attr('disabled', true);
        $('.cmdPrev').attr('disabled', true);
        $('.cmdNext').attr('disabled', true);
        $('.cmdLast').attr('disabled', true);
        $('.cmdSave').removeAttr('disabled');
        $('.cmdCancel').removeAttr('disabled');
        $('.cmdAdd').attr('disabled', true);
        $('.cmdEdit').attr('disabled', true);
        $('.cmdDelete').attr('disabled', true);
        $('.cmdSearch').attr('disabled', true);

        $('#cmdAdd').attr('disabled', true);
        $('#cmdEdit').attr('disabled', true);
        $('#cmdDelete').attr('disabled', true);
        $('#cmdSearch').attr('disabled', true);

        $('.cmdFirst').linkbutton('disable');
        $('.cmdPrev').linkbutton('disable');
        $('.cmdNext').linkbutton('disable');
        $('.cmdLast').linkbutton('disable');

        $('.cmdSave').linkbutton('enable');
        $('.cmdCancel').linkbutton('enable');

        $('.cmdAdd').linkbutton('disable');
        $('.cmdEdit').linkbutton('disable');
        $('.cmdDelete').linkbutton('disable');
        $('.cmdSearch').linkbutton('disable');
    }

    function condAdd() {
        $('#form_validation #id').val('');
        $('#form_validation input:text').val('');
        condReady();
    }

    function condEdit() {
        cmdcondReady();
        condReady();

        $("#form_validation #sinv_code_copy").attr('disabled', true);
    }
    function condDelete() {
        var id = $("#form_validation #id").val();
        var table = $("#form_validation #table").val();
        $.messager.confirm('Warning', 'Do you really want to delete the selected data ?', function (r) {
            if (r) {
                $('.loader').show();
                $.post(deleteurl, {table: table, id: id}, function (data) {
                    obj = JSON.parse(data);
                    if (obj.success == true) {
                        $("#id").val('');
                        showAlert("Information", obj.message);

                        read_show('');
                    } else
                    {
                        $('.loader').hide();
                        showAlert("Error while deleting", '<font color="red">' + obj.message + '</font>');
                    }
                });
            }
        });
    }

    function condCancel() {
        cmdcondAwal();
        read_show('');
        $("#form_validation .formError").remove();
    }

    function condReady() {
        $('#form_validation :input').attr('disabled', false);
        cmdcondReady();
    }

    function saveData() {
        $('.loader').show();
        $('#form_validation :input').attr('disabled', false);

        form.form('submit', {
            url: save_url,
            onSubmit: function () {
                return $(this).form('validate');
            },
            success: function (data) {
                var obj = JSON.parse(data);
                if (obj.success == true) {
                    read_show('');
                    showAlert("Information", obj.message);


                } else
                {
                    $('.loader').hide();
                    condReady();
                    $('#form_validation :input').attr('disabled', true);
                    showAlert("Error while saving", '<font color="red">' + obj.message + '</font>');
                }
            }
        });
    }
    $(document).ready(function () {
        tableId();
        read_show('');
        version('05.04-17');
    });

</script>