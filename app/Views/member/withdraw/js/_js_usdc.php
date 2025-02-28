<script>
    $.ajax({
        url: "<?= BASE_URL ?>member/withdraw/available_commission",
        method: "POST",
        dataType: "json",
        success: function(response) {
            // Cek jika response berhasil dan memiliki properti message.balance
            if (response && response.code === 200 && response.message && typeof response.message.balance !== "undefined") {
                // Format angka: hilangkan koma desimal dan tambahkan pemisah ribuan
                var balance = parseFloat(response.message.balance);
                var formattedBalance = "$ " + balance.toLocaleString('en-US', {
                    maximumFractionDigits: 0
                });
                $(".custom-card.left-card .card-bottom").text(formattedBalance);
            } else {
                $(".custom-card.left-card .card-bottom").text("$ 0");
            }
        },
        error: function(xhr, status, error) {
            console.error("Error fetching available commission:", error);
            $(".custom-card.left-card .card-bottom").text("Error");
        }
    });
</script>