<script>
    $(document).ready(function() {
        $("#resendotp").on("click", function(e) {
            e.preventDefault();

            var emailAddress = "<?= base64_decode($emailuser) ?>";
            var formData = {
                email: emailAddress
            };
            $.ajax({
                url: "<?= BASE_URL ?>auth/send_resetpassword",
                type: "POST",
                data: formData,
                dataType: "json",
                success: function(response) {
                    if (response.code === 200) {
                        alert("Kode OTP telah berhasil dikirim ulang ke email Anda.");
                    } else {
                        alert("Resend gagal: " + response.message);
                    }
                },
                error: function() {
                    alert("Terjadi kesalahan, silahkan coba lagi.");
                }
            });
        });

        function combineOTP() {
            var otp = document.getElementById('first').value +
                document.getElementById('second').value +
                document.getElementById('third').value +
                document.getElementById('fourth').value;
            document.getElementById('otpInput').value = otp;
        }
    });
</script>