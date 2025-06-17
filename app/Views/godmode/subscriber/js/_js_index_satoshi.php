<script>
     
    $('#table_referralmember').DataTable({
        "pageLength": 50,
        "dom": '<"d-flex justify-content-between align-items-center flex-wrap"lf>t<"d-flex justify-content-between align-items-center"ip>',
        "responsive": true,
        "order": false,
        "ajax": {
            "url": "<?= BASE_URL ?>godmode/subscriber/get_activesubscription_satoshi",
            "type": "POST",
            "dataSrc":function (data){
                console.log(data);
                return data;							
            }
        },
        "columns": [
            { data: 'email'},
            { data: 'start_date'},
            { data: 'end_date'},
            {
                data: 'remaining_days',
                render: function(data, type, row) {
                    return data + ' day';
                }
            }

        ],
    });
</script>