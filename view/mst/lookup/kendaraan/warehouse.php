<div id="wrapper"></div>
<script>

    var field1 = {'name': 'wrhs_code', 'caption': '<?php getCaption("Kode Warehouse"); ?>', 'width': 150, 'maxlength': 7};
    var field2 = {'name': 'wrhs_name', 'caption': '<?php getCaption("Nama Warehouse"); ?>', 'width': 300, 'maxlength': 15};
    var table = 'veh_wrhs';
    var pk = 'wrhs_code';
    var sk = 'wrhs_name';

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