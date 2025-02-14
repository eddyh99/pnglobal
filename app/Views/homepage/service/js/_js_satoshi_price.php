<script>
    $(document).ready(function() {
        $('#togglePassword').on('click', function() {

            const passwordField = $('#password');
            const passwordFieldType = passwordField.attr('type');

            // Toggle between text and password field type
            if (passwordFieldType === 'password') {
                passwordField.attr('type', 'text');
                $(this).removeClass('fa-eye').addClass('fa-eye-slash'); // Switch icon to "eye-slash"
            } else {
                passwordField.attr('type', 'password');
                $(this).removeClass('fa-eye-slash').addClass('fa-eye'); // Switch icon back to "eye"
            }
        })

        $('#togglePassword2').on('click', function() {

            const passwordField = $('#password2');
            const passwordFieldType = passwordField.attr('type');

            // Toggle between text and password field type
            if (passwordFieldType === 'password') {
                passwordField.attr('type', 'text');
                $(this).removeClass('fa-eye').addClass('fa-eye-slash'); // Switch icon to "eye-slash"
            } else {
                passwordField.attr('type', 'password');
                $(this).removeClass('fa-eye-slash').addClass('fa-eye'); // Switch icon back to "eye"
            }
        })
    })

    document.addEventListener("DOMContentLoaded", function() {
        var tzElement = document.getElementById("timezone");
        if (tzElement) {
            tzElement.value = Intl.DateTimeFormat().resolvedOptions().timeZone;
        }
    });



    $("#satoshi-register-form").on("submit", function(e) {
        $('#loadingcontent').modal('show');
    });
</script>