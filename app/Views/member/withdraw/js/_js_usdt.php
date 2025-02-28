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

    $(document).ready(function() {
        $('form[action="<?= BASE_URL ?>member/withdraw/request_withdraw"]').on('submit', function(e) {
            e.preventDefault(); // cegah submit form secara default

            $.ajax({
                url: $(this).attr('action'),
                method: "POST",
                data: $(this).serialize(),
                dataType: "json",
                success: function(response) {
                    if (response.code === 200) {
                        $("#modalAvailableCommission .modal-body").html("Your withdraw on process<br>Please check your wallet regularly");
                    } else if (response.code === 400) {
                        $("#modalAvailableCommission .modal-body").html("Insufficient balance. Please ensure you have enough funds and try again.");
                    } else {
                        $("#modalAvailableCommission .modal-body").html("An error occurred. Please try again later or contact support.");
                    }
                    $("#modalAvailableCommission").modal("show");
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                    $("#modalAvailableCommission .modal-body").html("A server error occurred. Please try again later or contact support.");
                    $("#modalAvailableCommission").modal("show");
                }
            });
        });
    });
</script>