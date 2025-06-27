
<script>

    var tableHistory = $('#table_history').DataTable({
        "pageLength": 50,
        "dom": '<"d-flex justify-content-between align-items-center flex-wrap"lf>t<"d-flex justify-content-between align-items-center"ip>',
        "responsive": true,
        "order": false,
        "ajax": {
            url: '<?= BASE_URL ?>hedgefund/dashboard/get_fundwallet_history',
            "type": "POST",
            "dataSrc":function (data){
                console.log(data);
                return data;
            },
        },
        "columns": [
            {
                data: 'date',
                render: $.fn.dataTable.render.number(',', '.', 3, '')
            },
            {
                data: 'desc',
                render: $.fn.dataTable.render.number(',', '.', 3, '')
            },
            {
                data: 'usdt',
                render: $.fn.dataTable.render.number(',', '.', 3, '')
            },
        ],
    });
    tableHistory.ajax.reload(null, false);

</script>