<script>
    $.ajax({
        url: "<?= BASE_URL ?>elite/withdraw/available_commission",
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
        // Fungsi untuk menutup modal dan redirect
        function closeModalAndRedirect(redirectUrl, delay) {
            setTimeout(function() {
                $("#modalAvailableCommission").modal("hide");
                setTimeout(function() {
                    window.location.href = redirectUrl;
                }, 300); // Memberikan sedikit waktu untuk animasi modal menutup
            }, delay);
        }

        $('form[action="<?= BASE_URL ?>elite/withdraw/request_withdraw"]').on('submit', function(e) {
            e.preventDefault(); // cegah submit form secara default

            // Disable the button and show loading indicator
            const submitBtn = document.getElementById('submitBtn');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...';
            }

            $.ajax({
                url: $(this).attr('action'),
                method: "POST",
                data: $(this).serialize(),
                dataType: "json",
                success: function(response) {
                    if (response.code === 201) {
                        $("#modalAvailableCommission .modal-body").html("Your withdraw on process<br>Please check your wallet regularly");
                        $("#modalAvailableCommission").modal("show");
                        // Tutup modal dan redirect setelah 3 detik
                        closeModalAndRedirect("<?= BASE_URL ?>elite/withdraw", 3000);
                    } else if (response.code === 400) {
                        $("#modalAvailableCommission .modal-body").html("Insufficient balance. Please ensure you have enough funds and try again.");
                        $("#modalAvailableCommission").modal("show");

                        // Re-enable the button if there's an error 
                        if (submitBtn) {
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = 'Confirm';
                        }
                    } else {
                        $("#modalAvailableCommission .modal-body").html("An error occurred. Please try again later or contact support.");
                        $("#modalAvailableCommission").modal("show");

                        // Re-enable the button if there's an error
                        if (submitBtn) {
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = 'Confirm';
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                    $("#modalAvailableCommission .modal-body").html("A server error occurred. Please try again later or contact support.");
                    $("#modalAvailableCommission").modal("show");

                    // Re-enable the button if there's an error
                    if (submitBtn) {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = 'Confirm';
                    }
                }
            });
        });
    });
</script>