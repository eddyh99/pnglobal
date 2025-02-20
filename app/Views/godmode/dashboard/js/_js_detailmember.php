<link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
<script>
    $("#btnref").on("click", function() {
        const walletInput = document.getElementById('refcode');
        walletInput.select(); // Select the text
        walletInput.setSelectionRange(0, 99999); // For mobile devices
        navigator.clipboard.writeText(walletInput.value) // Copy to clipboard
            .then(() => {
                alert('Referral copied to clipboard!');
            })
            .catch(err => {
                console.error('Failed to copy text: ', err);
            });
    })

    $("#expired").datepicker();
    window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function() {
            $(this).remove();
        });
    }, 5000);


    function validate() {
        return confirm("Are you sure you want to give a bonus to this user?");
    }
</script>