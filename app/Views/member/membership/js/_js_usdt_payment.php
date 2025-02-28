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
        // Menangani klik tombol "Confirm"
        $(".confirm-payment-btn").on("click", function() {
            // Mendapatkan nilai dari input
            var walletAddress = $("#wallet-address").val();
            var network = $("#network").val();
            var amount = $("#payment-amount").val().replace(/[^0-9.]/g, ''); // Menghapus karakter non-numerik

            // Data untuk dikirim ke server
            var data = {
                type: "usdt",
                address: walletAddress,
                network: network,
                amount: amount
            };

            // Menampilkan loading
            $(this).html('<i class="ri-loader-4-line fa-spin"></i> Processing...');
            $(this).prop('disabled', true);

            // Mengirim permintaan AJAX
            $.ajax({
                url: "<?= BASE_URL ?>member/withdraw/request_withdraw",
                method: "POST",
                data: data,
                dataType: "json",
                success: function(response) {
                    if (response.code === 201) {
                        // Redirect ke halaman withdraw jika kode adalah 201
                        window.location.href = "<?= BASE_URL ?>member/withdraw";
                    } else {
                        // Tampilkan pesan error
                        alert(response.message || "Terjadi kesalahan. Silakan coba lagi nanti.");
                        $(".confirm-payment-btn").html('Confirm');
                        $(".confirm-payment-btn").prop('disabled', false);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                    alert("Terjadi kesalahan server. Silakan coba lagi nanti.");
                    $(".confirm-payment-btn").html('Confirm');
                    $(".confirm-payment-btn").prop('disabled', false);
                }
            });
        });
    });
</script>