<div id="wrapper"></div>
<script>

    var field1 = {'name': 'spvlv_code', 'caption': '<?php getCaption("Kode Level"); ?>', 'width': 150, 'maxlength': 3};
    var field2 = {'name': 'spvlv_name', 'caption': '<?php getCaption("Nama Level"); ?>', 'width': 250, 'maxlength': 10};
    var table = 'sspv_lev';
    var pk = 'spvlv_code';
    var sk = 'spvlv_name';

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