<div id="wrapper"></div>
<script>

    var field1 = {'name': 'pay_type', 'caption': '<?php getCaption("Jenis Pembayaran"); ?>', 'width': 150, 'maxlength': 10};
    var field2 = {'name': 'pay_name', 'caption': '<?php getCaption("Keterangan Bayar"); ?>', 'width': 250, 'maxlength': 20};
    var table = 'pay_type';
    var pk = 'pay_type';
    var sk = 'pay_name';

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