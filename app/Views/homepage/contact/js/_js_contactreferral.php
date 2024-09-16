<script>
    var inputTel = document.querySelector(".whatsapp");
    window.intlTelInput(inputTel, {
        autoHideDialCode:false,
        formatOnDisplay: false,
        hiddenInput: "full_number",
        nationalMode: false,
        preferredCountries: ['it', 'us', 'au', 'ky', 'gb', 'id'],
    });

    const actualBtn = document.getElementById('identity-ref');

    const fileChosen = document.getElementById('file-chosen');

    actualBtn.addEventListener('change', function(){
        fileChosen.textContent = this.files[0].name
    })

    $("#contact-form").on("submit", function(e) {
      $('#loadingcontent').modal('show'); 
    });
</script>