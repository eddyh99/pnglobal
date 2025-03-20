<script>
    // Menghilangkan alert otomatis setelah 5 detik
    window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function() {
            $(this).remove();
        });
    }, 5000);

    // Menangani submit form
    $("#forgotPasswordForm").on("submit", function(e) {
        e.preventDefault();

        // Mengambil nilai email
        var email = $("#email").val();

        // Validasi email
        if (!email) {
            $("#response-message").removeClass().addClass("alert alert-danger").html("Email tidak boleh kosong").show();
            return false;
        }

        // Menampilkan loading
        $("#response-message").removeClass().addClass("alert alert-info").html("Mengirim permintaan reset password...").show();

        // Data yang akan dikirim
        var payload = {
            email: email
        };

        // Logging untuk debugging
        console.log("Sending payload:", payload);

        // Kirim request AJAX
        $.ajax({
            url: '<?= BASE_URL ?>auth/send_resetpassword',
            type: "POST",
            data: payload,
            dataType: 'json',
            success: function(response) {
                // Logging untuk debugging
                console.log("Raw response:", response);

                // Coba parse response jika berbentuk string
                if (typeof response === 'string') {
                    try {
                        response = JSON.parse(response);
                        console.log("Parsed JSON response:", response);
                    } catch (e) {
                        console.error("Error parsing JSON:", e);
                        // Coba ekstrak JSON dari output campuran
                        try {
                            let jsonStart = response.indexOf('{');
                            let jsonEnd = response.lastIndexOf('}') + 1;

                            if (jsonStart >= 0 && jsonEnd > jsonStart) {
                                let jsonStr = response.substring(jsonStart, jsonEnd);
                                response = JSON.parse(jsonStr);
                                console.log("Extracted JSON:", response);
                            } else {
                                throw new Error("No JSON found in response");
                            }
                        } catch (e2) {
                            console.error("Error extracting JSON:", e2);
                            $("#response-message").removeClass().addClass("alert alert-danger").html("Format respons tidak valid").show();
                            return;
                        }
                    }
                }

                // Proses response berdasarkan kode
                if (response.code === 200) {
                    $("#response-message").removeClass().addClass("alert alert-success").html("Email reset password telah dikirim. Anda akan dialihkan ke halaman OTP...").show();

                    // Redirect setelah delay untuk memberi waktu user membaca pesan
                    setTimeout(function() {
                        window.location.href = '<?= BASE_URL ?>member/auth/forgot_pass_otp/' + btoa(email);
                    }, 2000);
                } else {
                    $("#response-message").removeClass().addClass("alert alert-danger").html(response.message || "Terjadi kesalahan saat mengirim email").show();
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", status, error);
                console.log("Response Text:", xhr.responseText);

                // Coba parse response error jika ada
                try {
                    let errorResponse = JSON.parse(xhr.responseText);
                    $("#response-message").removeClass().addClass("alert alert-danger").html(errorResponse.message || "Terjadi kesalahan: " + error).show();
                } catch (e) {
                    $("#response-message").removeClass().addClass("alert alert-danger").html("Terjadi kesalahan: " + error).show();
                }
            }
        });
    });
</script>