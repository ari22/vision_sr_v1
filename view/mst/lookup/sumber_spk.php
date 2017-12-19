<div id="wrapper"></div>
<script>

    var field1 = {'name': 'sosrc_code', 'caption': '<?php getCaption("Kode Sumber SPK"); ?>', 'width': 150, 'maxlength': 10};
    var field2 = {'name': 'sosrc_name', 'caption': '<?php getCaption("Nama Sumber SPK"); ?>', 'width': 250, 'maxlength': 40};
    var table = 'so_source';
    var pk = 'sosrc_code';
    var sk = 'sosrc_name';
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