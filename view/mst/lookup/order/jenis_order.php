<div id="wrapper"></div>
<script>

    var field1 = {'name': 'oreq_type', 'caption': '<?php getCaption("Jenis Order"); ?>', 'width': 120, 'maxlength': 4};
    var field2 = {'name': 'oreq_name', 'caption': '<?php getCaption("Nama Order"); ?>', 'width': 250, 'maxlength': 10};
    var table = 'oreqtype';
    var pk = 'oreq_type';
    var sk = 'oreq_name';

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