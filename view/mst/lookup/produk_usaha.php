<div id="wrapper"></div>
<script>
    var field1 = {'name': 'item_code', 'caption': '<?php getCaption("Kode Produk Usaha"); ?>', 'width': 180, 'maxlength': 10};
    var field2 = {'name': 'item_name', 'caption': '<?php getCaption("Nama Produk Usaha"); ?>', 'width': 250, 'maxlength': 20};
    var table = 'bus_item';
    var pk = 'item_code';
    var sk = 'item_name';

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