<script>
        $('#tbl_freemember').DataTable({
        "pageLength": 50,
        "dom": '<"d-flex p-2 justify-content-between align-items-center flex-wrap"lf>t<"d-flex justify-content-between align-items-center"ip>',
        "responsive": true,
        "order": false,
        "ajax": {
            "url": "<?= BASE_URL ?>godmode/course/user/trade_history",
            "type": "GET",
            "data": function(d) {
                d.email = $('#email').val();
            },
            "dataSrc": function(data) {
                return data;
            }
        },
        "columns": [{
                data: 'order_price',
            },
            {
                data: 'order_type',
            },
            {
                data: 'usdt_qty',
                render : $.fn.dataTable.render.number(',', '.', 2, '')
            },
            {
                data: 'btc_qty',
            },
            {
                data: 'status',
            },
            {
                data: 'created_at',
            },
        ],
        language: {
            emptyTable: "No Data"
        }
    });

</script>