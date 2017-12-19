<div style="margin: 10px;" id="form_content">
    <form id="form_validation" method="post">
        <div class="single-form">
        <table>
            <tr>
                <td>
                    <input  type="hidden" name="id" id="id">
                    <input type="hidden" name="table"  id="table" value="<?php echo 'prt_radd'; ?>">

                    <table cellpadding="5" class="table" style="width:500px;">
                        <?php
                        textbox('raddr_code', 'Kode Alamat', 90, 10);
                        textbox('raddr_name', 'Keterangan', 250, 40);

                        textbox('oname', 'Perusahaan', 250, 40);
                        textarea('oaddr', 'Alamat', 250, 70);
                        cmdArea('oarea', 'Wilayah');
                        cmdCity('ocity', 'Kota');
                        ?>
                    </table>
                </td>
                <td>
                    <table cellpadding="5" class="table" style="width:500px;">
                        <?php
                         zipbox('ozipcode', 'Kode Pos', 90);
                        cmdCountry('ocountry', 'Negara');
                        phonebox('ophone', 'Telepon', 150, 35);
                        phonebox('ofax', 'Fax', 150, 35);
                         phonebox('ocp1_name', 'Hubungi', 150, 35);
                        textbox('ocp1_title', 'Jabatan', 250, 20);
                        ?>
                    </table>
                </td>
            </tr>        
        </table>
        </div>
        
         <div class="main-nav">
            <table width="100%">
                <tr>
                    <td> <?php navigation_ci(); ?></td>
                   <td align="right"><img src="<?php echo $loc_jui . "themes/icons/version.png" ?>" id="version"></td>
             </tr>
            </table>          
        </div>
    </form>
</div>


<script>
     $(document).ready(function () {
        read_show('');
         version('01.04-17');
        $('.loader').hide();
    });
    var table = 'prt_radd';

    function showAlert(title, msg) {
        $.messager.show({
            title: title,
            msg: msg,
            //showType:'show',
            timeout: 2000,
            showType: 'fade',
            style: {
                right: '',
                bottom: ''
            }
        });
    }

    function read_show(nav) {
        var id = $("#id").val();
         formDisabled();
         cmdcondAwal();
            
        $.post(site_url + 'master/lookup/read', {table: table, nav: nav, id: id}, function (json) {

            if (json !== '[]') {
                var rowData = $.parseJSON(json);

                $('#form_validation').form('load', {
                    //keyword:rowData.keyword'],  
                    //en:rowData.en'],      
                    raddr_code: rowData.raddr_code,
                    raddr_name: rowData.raddr_name,
                    oname: rowData.oname,
                    oaddr: rowData.oaddr,
                    oarea:rowData.oarea,
                    ocity: rowData.ocity,
                    ocountry: rowData.ocountry,
                    ozipcode: rowData.ozipcode,
                    ophone: rowData.ophone,
                    ofax: rowData.ofax,
                    ocp1_name: rowData.ocp1_name,
                    ocp1_title: rowData.ocp1_title
                });
                $("#id").val(rowData.id);
                
            }else {
                cmdcondAwal();
                cmdEmptyData();
            }
            $('.loader').hide();
           

        });
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
    function close_search() {
        $('#windowSearch').window('close');
        $("#actionSearch").empty()
        $("#SearchOption").hide();
    }

    function condReady() {

        $('#raddr_code').attr('disabled', false);
        $('#raddr_name').attr('disabled', false);
        $('#oname').attr('disabled', false);
        $('#oaddr').attr('disabled', false);
        $('#oarea').combogrid('enable');
        $('#ocity').combogrid('enable');
        $('#ocountry').combogrid('enable');
        $('#ozipcode').attr('disabled', false);
        $('#ophone').attr('disabled', false);
        $('#ofax').attr('disabled', false);
        $('#ocp1_name').attr('disabled', false);
        $('#ocp1_title').attr('disabled', false);
        $('#raddr_code').focus();

        cmdcondReady();

    }

    function cmdcondReady() {
        //$("#cmdSave").show();
        //$("#cmdCancel").show();
        $('#cmdFirst').attr('disabled', true);
        $('#cmdPrev').attr('disabled', true);
        $('#cmdNext').attr('disabled', true);
        $('#cmdLast').attr('disabled', true);

        $('#cmdSave').removeAttr('disabled');
        $('#cmdCancel').removeAttr('disabled');
        //$("#cmdSave").removeAttr('disabled');
        //$("#cmdCancel").removeAttr('disabled');
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
        $('#id').val('');
        $('#raddr_code').val('');
        $('#raddr_name').val('');
        $('#oname').val('');
        $('#oaddr').val('');

        $('#ozipcode').val('');
        $('#ophone').val('');
        $('#ofax').val('');
        $('#ocp1_name').val('');
        $('#ocp1_title').val('');
        $('#oarea').combogrid('setValue', '');
        $('#ocity').combogrid('setValue', '');
        $('#ocountry').combogrid('setValue', '');
        condReady();
    }



    function condEdit() {
        cmdcondReady();
        condReady();
    }

    function condCancel() {
        cmdcondAwal();
        read_show('');
        $(".formError").remove();
    }

    function formDisabled() {
        $('#raddr_code').attr('disabled', true);
        $('#raddr_name').attr('disabled', true);
        $('#oname').attr('disabled', true);
        $('#oaddr').attr('disabled', true);

        $('#ozipcode').attr('disabled', true);
        $('#ophone').attr('disabled', true);
        $('#ofax').attr('disabled', true);
        $('#ocp1_name').attr('disabled', true);
        $('#ocp1_title').attr('disabled', true);
        $('#ocity').combogrid('disable');
        $('#oarea').combogrid('disable');
        $('#ocountry').combogrid('disable');
    }
    function cmdcondAwal() {
        $('#cmdFirst').removeAttr('disabled');
        $('#cmdPrev').removeAttr('disabled');
        $('#cmdNext').removeAttr('disabled');
        $('#cmdLast').removeAttr('disabled');
        $('#cmdSave').attr('disabled', true);
        $('#cmdCancel').attr('disabled', true);
        $('#cmdAdd').removeAttr('disabled');
        $('#cmdEdit').removeAttr('disabled');
        $('#cmdDelete').removeAttr('disabled');
        $('#cmdSearch').removeAttr('disabled');

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

    function condDelete() {
        var id = $("#id").val();
        $.messager.confirm('Warning', 'Are you sure delete selected data ?', function (r) {
            if (r) {

                var url = site_url + 'master/lookup/delete';
                $('#form_validation').form('submit', {
                    url: url,
                    onSubmit: function () {
                        return $(this).form('validate');
                    },
                    success: function (data) {
                        obj = JSON.parse(data);
                        if (obj.success == true) {
                            $("#id").val('');
                            read_show('');
                            showAlert("Information", obj.message);
                            cmdcondAwal();

                        } else
                        {
                            showAlert("Error while delete", '<font color="red">' + obj.message + '</font>');
                        }
                    }
                });
            }
        });
    }
    function saveData() {
        // $('#form_validation').validationEngine();
        var url = site_url + 'master/lookup/save_receiving';

        $('#form_validation').form('submit', {
            url: url,
            onSubmit: function () {
                return $(this).form('validate');
            },
            success: function (data) { //alert(data);return false;
                var obj = JSON.parse(data);
                if (obj.success == true) {
                    showAlert("Information", obj.message);
                    cmdcondAwal();
                    read_show('');
                    // $('#dt').datagrid('reload');
                } else
                {
                    showAlert("Error while saving", '<font color="red">' + obj.message + '</font>');
                }
            }
        });
    }

</script>
