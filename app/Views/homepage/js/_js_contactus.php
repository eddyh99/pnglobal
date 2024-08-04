<!-- SELECT2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<script>  
    var inputTel = document.querySelector(".whatsapp");
    window.intlTelInput(inputTel, {
        autoHideDialCode:false,
        formatOnDisplay: false,
        hiddenInput: "full_number",
        nationalMode: false,
        preferredCountries: ['it', 'us', 'au', 'ky', 'gb', 'id'],
        utilsScript: "./assets/vendor/intl-tel-input-master/build/js/utils.js"
    });

    // Menambahkan Input Lain Email
    $('#addemail').on('click', function(){
        $(this).each(function(index){
        $(this).before('<input class="inp-email2 mt-3 img-fluid" name="email[]" type="text" placeholder="Enter email address">' 
                        +  
                        '<i class="fa-regular fa-circle-xmark fa-add-email text-danger fs-4 ms-3"></i>' 
                        + 
                        '<br class="br-email">' );
        });
    
        $('.fa-add-email').on('click', function(){
        $('.inp-email2').remove();
        $('.br-email').remove();
        $('.fa-add-email').remove();
        });
    
    });

    $(document).ready(function(){
        let timezone = $('#timezone').val();
        $.ajax({
            url: "<?= base_url() ?>homepage/getSlots",
            type: "POST",
            data: {"timezone": timezone},
            success: function (response) {
                const result = JSON.parse(response);
                const slot = result.slot;

                const groupedData = {};
                slot.forEach(item => {
                    const startDate = item.start.split(' ')[0];
                    if (!groupedData[startDate]) {
                        groupedData[startDate] = [];
                    }
                    groupedData[startDate].push(item);
                });

                // Format data for select2 with optgroup
                const select2Data = [];

                Object.keys(groupedData).forEach(date => {
                    const group = {
                        text: date,
                        children: groupedData[date].map(item => ({
                            id: `${item.start}#${item.end}`, // Unique id for each option, can be customized
                            text: `${item.start.split(' ')[1]} - ${item.end.split(' ')[1]}`
                        }))
                    };
                    select2Data.push(group);
                });

                $('#schedule').select2({
                    data: select2Data
                });

            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus);
            }
        });

    });

    $("#timezone").on("change",function(){
        let timezone = $('#timezone').val();
        $.ajax({
            url: "<?= base_url() ?>homepage/getSlots",
            type: "POST",
            data: {"timezone": timezone},
            success: function (response) {
                let result = JSON.parse(response);
                console.log(result);
                let slot = result.slot;
                $('#schedule').empty();

                const groupedData = {};
                slot.forEach(item => {
                    const startDate = item.start.split(' ')[0];
                    if (!groupedData[startDate]) {
                        groupedData[startDate] = [];
                    }
                    groupedData[startDate].push(item);
                });

                // Format data for select2 with optgroup
                const select2Data = [];

                Object.keys(groupedData).forEach(date => {
                    const group = {
                        text: date,
                        children: groupedData[date].map(item => ({
                            id: item.start, // Unique id for each option, can be customized
                            text: `${item.start.split(' ')[1]} - ${item.end.split(' ')[1]}`
                        }))
                    };
                    select2Data.push(group);
                });

                $('#schedule').select2({
                    data: select2Data
                });
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus);
            }
        });
    });


   
  
</script>