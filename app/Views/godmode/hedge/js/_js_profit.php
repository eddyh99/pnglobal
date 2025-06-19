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
                return data;
            }
        },
        "columns": [
            {
                title: "Buy Price",
                data: 'buy_price',
                render: $.fn.dataTable.render.number(',', '.', 2, '')
            },
            {
                title: "Sell Price",
                data: 'sell_price',
                render: $.fn.dataTable.render.number(',', '.', 2, '')
            },
            {
                title: "Profit (USDT)",
                data: null,
                render: function (data, type, row) {
                    // Calculate profit: sell_total_usdt - buy_total_usdt
                    const profit = parseFloat(row.sell_total_usdt || 0) - parseFloat(row.buy_total_usdt || 0);
                    return profit.toFixed(2);
                }
            },
            {
                title: "Client Profit",
                data: 'client_profit',
                render: $.fn.dataTable.render.number(',', '.', 2, '')
            },
            {
                title: "Master Profit",
                data: 'master_profit',
                render: $.fn.dataTable.render.number(',', '.', 2, '')
            },
            {
                title: "Commission",
                data: 'total_commission',
                render: function (data, type, row) {
                    const commission = data !== null ? parseFloat(data).toFixed(2) : '0.00';
                    return commission;
                }
            }
        ]
    });
    
</script>