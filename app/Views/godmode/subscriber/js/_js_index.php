<script>
     
    $('#table_referralmember').DataTable({
        "pageLength": 50,
        "scrollX": true,
        "order": false,
        "ajax": {
            "url": "<?= BASE_URL ?>godmode/subscriber/get_activesubscription",
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
                data: 'remaining_day',
                render: function(data, type, row) {
                    return data + ' day';
                }
            }

        ],
    });
</script>