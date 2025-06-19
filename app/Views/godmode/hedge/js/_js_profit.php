<script>
    updateProfits();
    function updateProfits() {
        $.ajax({
            url: '<?= BASE_URL ?>godmode/hedge/get_profit', // Ganti dengan endpoint sesuai back-end kamu
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                console.log(response);

                // Pastikan response punya struktur { fund_balance: ..., trade_balance: ... }
                $('#tprofit').text(response.total_profit ?? 0);
                $('#cprofit').text(response.client_profit ?? 0);
                $('#rprofit').text(response.ref_comm ?? 0);
                $('#mprofit').text(response.master_profit ?? 0);


            },
            error: function(xhr, status, error) {
                console.error("Gagal mengambil data balance:", error);
                $('#fund_balance').text('Error');
                $('#trade_balance').text('Error');
            }
        });
    }
    
    $('#table_message').DataTable({
        "pageLength": 100,
        "dom": '<"d-flex justify-content-between align-items-center flex-wrap"lf>t<"d-flex justify-content-between align-items-center"ip>',
        "responsive": true,
        "ajax": {
            "url": "<?= BASE_URL ?>godmode/hedge/get_detailprofit",
            "type": "POST",
            "dataSrc": function(data) {
                return data ? data.filter(item => item.status == 'active') : [];
            }
        },
        "columns": [{
                data: 'open_price'
            },
            {
                data: 'close_price',
            },
            {
                data: 'profit',
            },
            {
                data: 'client_profit'
            },
            {
                data: 'wallet_profit', render: $.fn.dataTable.render.number( ',', '.', 2, '' )
            },
            {
                data: 'referral', render: $.fn.dataTable.render.number( ',', '.', 2, '' )
            },
            {
                data: null,
            },

        ],
    });
    
</script>