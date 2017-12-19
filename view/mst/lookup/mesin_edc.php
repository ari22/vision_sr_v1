<div id="wrapper"></div>
<script>

    var field1 = {'name': 'edc_code', 'caption': '<?php getCaption("Kode EDC"); ?>', 'width': 150, 'maxlength': 8};
    var field2 = {'name': 'edc_name', 'caption': '<?php getCaption("Nama EDC"); ?>', 'width': 250, 'maxlength': 15};
    var table = 'edc';
    var pk = 'edc_code';
    var sk = 'edc_name';

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