<div id="wrapper"></div>
<script>

    var field1 = {'name': 'coltp_code', 'caption': '<?php getCaption("Kode Tipe Warna"); ?>', 'width': 150, 'maxlength': 2};
    var field2 = {'name': 'coltp_name', 'caption': '<?php getCaption("Nama Tipe Warna"); ?>', 'width': 250, 'maxlength': 10};
    var table = 'col_type';
    var pk = 'coltp_code';
    var sk = 'coltp_name';

    $(document).ready(function () {
        grid_master('wrapper');
    });

    function grid_master(selector) {
        var div = $("#" + selector);

        $.post(site_url + 'master/lookup/grid_lookup',
                {
                    field1: field1,
                    field2: field2,
                    table: table,
                    pk: pk,
                    sk: sk,
                    v: '01.04-17'
                },
        function (data) {
            div.html(data);
            $('.easyui-linkbutton').linkbutton();
        });

    }


</script>