<script>
    window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function() {
            $(this).remove();
        });
    }, 5000);

    $("#forgotPasswordForm").on("submit", function(e) {
        e.preventDefault();
        var email = $("#email").val();
        var payload = {
            email: email
        };
        console.log(payload);

        $.ajax({
            url: '<?= BASE_URL ?>auth/send_resetpassword',
            type: "POST",
            data: payload,
            success: function(response) {
                if (response.code === 200) {
                    $(".alert").html('<div class="alert alert-success">' + response.message.text + '</div>');
                } else {
                    $(".alert").html('<div class="alert alert-danger">' + response.message + '</div>');
                }
            },
            error: function(xhr, status, error) {
                $(".alert").html('<div class="alert alert-danger">Terjadi kesalahan: ' + error + '</div>');
            }
        });
    });
</script>