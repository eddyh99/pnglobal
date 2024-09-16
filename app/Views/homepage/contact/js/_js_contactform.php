<script>
    var inputTel = document.querySelector(".whatsapp");
    window.intlTelInput(inputTel, {
        autoHideDialCode:false,
        formatOnDisplay: false,
        hiddenInput: "full_number",
        nationalMode: false,
        preferredCountries: ['it', 'us', 'au', 'ky', 'gb', 'id'],
    });

    $("#contact-form").on("submit", function(e) {
      $('#loadingcontent').modal('show'); 
    });
</script>