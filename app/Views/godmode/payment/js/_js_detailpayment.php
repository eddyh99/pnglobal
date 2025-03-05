 <script>
     window.setTimeout(function() {
         $(".alert").fadeTo(500, 0).slideUp(500, function() {
             $(this).remove();
         });
     }, 5000);

     function copyToClipboard(value) {
         navigator.clipboard.writeText(value).then(function() {
             Swal.fire({
                 text: 'Successfully copied: ' + value,
                 showCloseButton: true,
                 showConfirmButton: false,
                 background: '#E1FFF7',
                 color: '#000000',
                 position: 'top-end',
                 timer: 2000,
                 timerProgressBar: true,
             });
         }, function(err) {
             Swal.fire({
                 text: 'Failed to copy text: ' + err,
                 showCloseButton: true,
                 showConfirmButton: false,
                 background: '#FFE4DC',
                 color: '#000000',
                 position: 'top-end',
                 timer: 2000,
                 timerProgressBar: true,
             });
         });
     }

     $("#btnwallet").on("click", function() {
         const walletInput = document.getElementById('wallet');
         walletInput.select(); // Select the text
         walletInput.setSelectionRange(0, 99999); // For mobile devices
         navigator.clipboard.writeText(walletInput.value) // Copy to clipboard
             .then(() => {
                 Swal.fire({
                     text: 'Successfully copied: ' + walletInput.value,
                     showCloseButton: true,
                     showConfirmButton: false,
                     background: '#E1FFF7',
                     color: '#000000',
                     position: 'top-end',
                     timer: 2000,
                     timerProgressBar: true,
                 });
             })
             .catch(err => {
                 Swal.fire({
                     text: 'Failed to copy text: ' + err,
                     showCloseButton: true,
                     showConfirmButton: false,
                     background: '#FFE4DC',
                     color: '#000000',
                     position: 'top-end',
                     timer: 2000,
                     timerProgressBar: true,
                 });
             });
     })
 </script>