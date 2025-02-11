 <script>
    window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function(){
            $(this).remove(); 
        });
    }, 5000);

    function copyToClipboard(value) {
        navigator.clipboard.writeText(value).then(function () {
            alert('Copied to clipboard: ' + value);
        }, function (err) {
            alert('Failed to copy text: ' + err);
        });
    }
    
     $("#btnwallet").on("click",function(){
        const walletInput = document.getElementById('wallet');
        walletInput.select(); // Select the text
        walletInput.setSelectionRange(0, 99999); // For mobile devices
        navigator.clipboard.writeText(walletInput.value) // Copy to clipboard
            .then(() => {
                alert('Wallet address copied to clipboard!');
            })
            .catch(err => {
                console.error('Failed to copy text: ', err);
            });
    })
 </script>