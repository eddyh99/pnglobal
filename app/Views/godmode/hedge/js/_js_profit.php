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
                $('#tprofit').text(response.total_profit);
                $('#cprofit').text(response.client_profit);
                $('#rprofit').text(response.ref_comm);
                $('#mprofit').text(response.master_profit);

            },
            error: function(xhr, status, error) {
                console.error("Gagal mengambil data balance:", error);
                $('#fund_balance').text('Error');
                $('#trade_balance').text('Error');
            }
        });
    }
</script>