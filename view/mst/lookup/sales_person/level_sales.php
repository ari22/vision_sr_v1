<div id="wrapper"></div>
<script>

    var field1 = {'name': 'slev_code', 'caption': '<?php getCaption("Kode Level Sales"); ?>', 'width': 150, 'maxlength': 10};
    var field2 = {'name': 'slev_name', 'caption': '<?php getCaption("Nama Level Sales"); ?>', 'width': 250, 'maxlength': 20};
    var table = 'srep_lev';
    var pk = 'slev_code';
    var sk = 'slev_name';

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