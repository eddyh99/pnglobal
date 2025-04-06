<script>
    $(document).ready(function() {
        function OTPInput() {
            const inputs = document.querySelectorAll('#otp > input');
            for (let i = 0; i < inputs.length; i++) {
                inputs[i].addEventListener('input', function() {
                    if (this.value.length > 1) {
                        this.value = this.value[0];
                    }
                    if (this.value !== '' && i < inputs.length - 1) {
                        inputs[i + 1].focus();
                    }
                });

                inputs[i].addEventListener('keydown', function(event) {
                    if (event.key === 'Backspace') {
                        this.value = '';
                        if (i > 0) {
                            inputs[i - 1].focus();
                        }
                    }
                });
            }
        }
        OTPInput();

        $("#satoshi-otp-form").on("submit", function(e) {
            e.preventDefault();
            console.log("asd");
            let otp = $("#first").val() + $("#second").val() + $("#third").val() + $("#fourth").val();
            let formData = {
                email: "<?= base64_decode($emailuser) ?>",
                otp: otp
            };

            // return alert("asd");

            console.log(formData);

            $.ajax({
                url: '<?= BASE_URL ?>elite/auth/process_otp',
                type: 'POST',
                data: formData,
                success: function(ress) {
                    // Parse Data
                    let result = ress;
                    console.log(result);

                    if (result.code == "200") {
                        $('#loadingcontent').modal('show');
                        setTimeout(() => {
                            window.location.href = '<?= BASE_URL ?>elite/auth/set_capital/<?= base64_encode($emailuser) ?>';
                        }, 3000);
                    } else {
                        $(".show-failed").append(`
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>
                                    ${result.message}
                                </strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>               
                        `)

                    }

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $(".show-failed").append(`
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>
                                Please check your internet again
                            </strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>               
                    `)
                    console.log(textStatus);
                }
            })
        });

        $("#resendotp").on("click", function(e) {
            e.preventDefault();
            var emailAddress = "<?= base64_decode($emailuser) ?>";
            let formData = {
                email: emailAddress
            };
            console.log("Email yang dikirim untuk resend OTP: " + emailAddress);
            $.ajax({
                url: '<?= BASE_URL ?>auth/resend_token',
                type: 'POST',
                data: formData,
                success: function(response) {
                    console.log(response);
                    if (response.code == "200") {
                        alert("Kode telah berhasil dikirim ulang ke email Anda.");
                    } else {
                        alert("Resend gagal: " + response.message);
                    }
                },
                error: function() {
                    alert("Terjadi kesalahan, silahkan coba lagi.");
                }
            });
        });
    })
</script>