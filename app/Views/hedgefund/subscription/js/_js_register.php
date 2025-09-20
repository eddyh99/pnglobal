<script>
    window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function(){
            $(this).remove(); 
        });
    }, 5000);

    $(document).ready(function() {
        $('#togglePassword').on('click', function() {
            
            const passwordField = $('#password');
            const passwordFieldType = passwordField.attr('type');

            // Toggle between text and password field type
            if (passwordFieldType === 'password') {
                passwordField.attr('type', 'text');
                $(this).removeClass('la-eye').addClass('la-low-vision'); // Switch icon to "eye-slash"
            } else {
                passwordField.attr('type', 'password');
                $(this).removeClass('la-low-vision').addClass('la-eye'); // Switch icon back to "eye"
            }
        })
        $('#togglePassword2').on('click', function() {
            
            const passwordField = $('#password2');
            const passwordFieldType = passwordField.attr('type');

            // Toggle between text and password field type
            if (passwordFieldType === 'password') {
                passwordField.attr('type', 'text');
                $(this).removeClass('la-eye').addClass('la-low-vision'); // Switch icon to "eye-slash"
            } else {
                passwordField.attr('type', 'password');
                $(this).removeClass('la-low-vision').addClass('la-eye'); // Switch icon back to "eye"
            }
        })
    })
    
    document.addEventListener("DOMContentLoaded", function() {
        var tzElement = document.getElementById("timezone");
        if (tzElement) {
            tzElement.value = Intl.DateTimeFormat().resolvedOptions().timeZone;
        }
    });
</script>