<div id="wrapper"></div>
<script>

    var field1 = {'name': 'model_code', 'caption': '<?php getCaption("Kode Model"); ?>', 'width': 150, 'maxlength': 15};
    var field2 = {'name': 'model_name', 'caption': '<?php getCaption("Nama Model"); ?>', 'width': 250, 'maxlength': 35};
    var table = 'model';
    var pk = 'model_code';
    var sk = 'model_name';

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