<style>
    /* For Chrome, Safari, Edge, Opera */
    .no-spinner::-webkit-outer-spin-button,
    .no-spinner::-webkit-inner-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }
    
    /* For Firefox */
    .no-spinner {
      -moz-appearance: textfield;
    }
</style>
<script>
    let balance = parseFloat("<?= $balance['fund']->usdt ?? 0 ?>") || 0;

    $("#maxbalance").on("click", function () {
        $("#amount").val(balance);
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

        $('form[action="<?= BASE_URL ?>hedgefund/withdraw/request_withdraw"]').on('submit', function(e) {
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
                        closeModalAndRedirect("<?= BASE_URL ?>hedgefund/withdraw", 3000);
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