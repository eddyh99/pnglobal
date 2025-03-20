<script>
    function copyToClipboard(elementId) {
        var copyText = document.getElementById(elementId);
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        document.execCommand("copy");

        // Tampilkan notifikasi kecil
        var tooltip = document.createElement("div");
        tooltip.innerHTML = "Copied!";
        tooltip.style.position = "fixed";
        tooltip.style.backgroundColor = "#b48b3d";
        tooltip.style.color = "#000";
        tooltip.style.padding = "5px 10px";
        tooltip.style.borderRadius = "5px";
        tooltip.style.top = "20px";
        tooltip.style.right = "20px";
        tooltip.style.zIndex = "9999";
        document.body.appendChild(tooltip);

        // Hilangkan notifikasi setelah 2 detik
        setTimeout(function() {
            tooltip.style.opacity = "0";
            tooltip.style.transition = "opacity 0.5s";
            setTimeout(function() {
                document.body.removeChild(tooltip);
            }, 500);
        }, 2000);
    }

    $(document).ready(function() {
        // Fungsi untuk menampilkan pesan sukses dan redirect otomatis
        function showSuccessAndRedirect(message) {
            // Gunakan modal yang sudah ada (usdcSuccessModal)
            $("#usdcSuccessModal .modal-body").html(`
                <div class="text-center">
                    <div>${message || '<p>Your payment is being processed and your account will be ready within 48 hours.</p><p>We will send you an email when your account is active.</p>'}</div>
                </div>
            `);

            // Tampilkan modal
            $("#usdcSuccessModal").modal("show");

            // Set timer untuk menutup modal dan redirect
            setTimeout(function() {
                $("#usdcSuccessModal").modal("hide");
                setTimeout(function() {
                    window.location.href = "<?= BASE_URL ?>member/membership";
                }, 500);
            }, 3000); // Tampilkan modal selama 3 detik sebelum redirect
        }

        // Fungsi untuk menampilkan pesan error
        function showErrorMessage(message) {
            // Gunakan modal yang sudah ada (usdcSuccessModal) tapi dengan konten error
            $("#usdcSuccessModal .modal-body").html(`
                <div class="text-center">
                    <div class="mb-4">
                        <i class="ri-error-warning-line text-danger" style="font-size: 4rem;"></i>
                    </div>
                    <div>${message || '<p>An error occurred while processing your USDC payment.</p>'}</div>
                </div>
            `);

            // Tampilkan modal
            $("#usdcSuccessModal").modal("show");
        }

        // Handle form submission untuk konfirmasi pembayaran USDC
        $("#usdc-payment-form").on("submit", function(e) {
            e.preventDefault();
            console.log("Form submitted"); // Debugging

            // Tampilkan loading modal jika ada
            if ($("#loadingcontent").length > 0) {
                $("#loadingcontent").modal("show");
            }

            // Kirim form dengan AJAX
            $.ajax({
                url: $(this).attr("action"),
                type: "POST",
                data: $(this).serialize(),
                dataType: "json",
                success: function(response) {
                    console.log("AJAX success:", response); // Debugging

                    // Sembunyikan loading modal
                    if ($("#loadingcontent").length > 0) {
                        $("#loadingcontent").modal("hide");
                    }

                    if (response.status === "success") {
                        // Tampilkan modal sukses dan redirect otomatis
                        showSuccessAndRedirect(response.message);
                    } else {
                        // Tampilkan pesan error jika ada
                        showErrorMessage(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.log("AJAX error:", status, error); // Debugging

                    // Sembunyikan loading modal
                    if ($("#loadingcontent").length > 0) {
                        $("#loadingcontent").modal("hide");
                    }

                    console.error("Error AJAX:", status, error);

                    // Coba parse response JSON jika ada
                    let errorMessage = "An error occurred while connecting to the server. Please try again.";
                    try {
                        const responseJson = JSON.parse(xhr.responseText);
                        if (responseJson && responseJson.message) {
                            errorMessage = responseJson.message;
                        }
                    } catch (e) {
                        console.error("Error parsing JSON response:", e);
                    }

                    // Tampilkan pesan error
                    showErrorMessage(errorMessage);
                }
            });
        });

        // Tambahkan test button untuk debugging
        $("body").append('<button id="test-modal" style="position: fixed; bottom: 10px; right: 10px; z-index: 9999; display: none;">Test Modal</button>');
        $("#test-modal").on("click", function() {
            showSuccessAndRedirect('<p>Test modal message</p>');
        });
    });
</script>