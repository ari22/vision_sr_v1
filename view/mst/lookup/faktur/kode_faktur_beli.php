<div id="wrapper"></div>
<script>

    var field1 = {'name': 'pinv_code', 'caption': '<?php getCaption("Kode Faktur Beli"); ?>', 'width': 180, 'maxlength': 3};
    var field2 = {'name': 'pinv_name', 'caption': '<?php getCaption("Nama Faktur Beli"); ?>', 'width': 250, 'maxlength': 25};
    var table = 'pinv';
    var pk = 'pinv_code';
    var sk = 'pinv_name';

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