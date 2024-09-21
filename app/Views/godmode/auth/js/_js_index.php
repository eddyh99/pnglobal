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
    })
</script>