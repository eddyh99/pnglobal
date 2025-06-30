<script src="//cdn.datatables.net/plug-ins/2.3.2/api/sum().js"></script>
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
                $('#mdepo').text((+response.member_deposit || 0).toLocaleString('en'));
                $('#tprofit').text((+response.total_profit || 0).toLocaleString('en'));
                $('#cprofit').text((+response.client_profit || 0).toLocaleString('en'));
                $('#rprofit').text((+response.ref_comm || 0).toLocaleString('en'));
                $('#mprofit').text((+response.master_profit || 0).toLocaleString('en'));
                $('#mwithdraw').text((+response.withdraw || 0).toLocaleString('en'));

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
                return data.filter(function (item) {
                    return item.sell_price != null;
                });
            }
        },
        drawCallback: function () {
            var api = this.api();
            var profit = 0;
            var client = 0;
            var master = 0;
            var komisi = 0;
        
            api.rows({ page: 'current' }).every(function () {
                var row = this.data();
        
                // Compute profit manually (from row data)
                if (row.sell_total_usdt !== null && row.buy_total_usdt !== null) {
                    profit += parseFloat(row.sell_total_usdt) - parseFloat(row.buy_total_usdt);
                }
        
                // Summing other numeric columns directly
                client += parseFloat(row.client_profit || 0);
                master += parseFloat(row.master_profit || 0);
                komisi += parseFloat(row.total_commission || 0);
            });
        
            // Update footer
            api.column(2).footer().innerHTML = profit.toFixed(2).toLocaleString('en', { minimumFractionDigits: 2 });
            api.column(3).footer().innerHTML = client.toFixed(2).toLocaleString('en', { minimumFractionDigits: 2 });
            api.column(4).footer().innerHTML = master.toFixed(2).toLocaleString('en', { minimumFractionDigits: 2 });
            api.column(5).footer().innerHTML = komisi.toFixed(2).toLocaleString('en', { minimumFractionDigits: 2 });
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
                    if (row.sell_total_usdt==null){
                        return '';
                    }else{
                        const profit = parseFloat(row.sell_total_usdt || 0) - parseFloat(row.buy_total_usdt || 0);
                        return profit.toFixed(2);
                    }
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