<div id="wrapper"></div>
<script>

    var field1 = {'name': 'job_code', 'caption': '<?php getCaption("Kode Pekerjaan"); ?>', 'width': 150, 'maxlength': 10};
    var field2 = {'name': 'job_name', 'caption': '<?php getCaption("Nama Pekerjaan"); ?>', 'width': 250, 'maxlength': 20};
    var table = 'job_fld';
    var pk = 'job_code';
    var sk = 'job_name';

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