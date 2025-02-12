<script>
window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 5000);
    $(document).ready(function(){
        
        // Buy A when the button is clicked
        $('#send-buy-a').click(function(e){
            // for not refresh
            e.preventDefault();

            // init data for send to controller
            let formData = {
                price: $("#buy-a").val(),
                type: 'Buy A',
                pair_id: null
            };

            // Ajax Proccess
            $.ajax({
                url: '<?=BASE_URL?>godmode/signal/buysignal',
                type: 'POST',
                data: formData,
                success: function (ress) {
                    // Parse Data
                    let result = JSON.parse(ress)

                    // Check if response success
                    if(result.code == '200'){
                        // Sweet Alert
                        Swal.fire({
                            text: `${result.message}`,
                            showCloseButton: true,
                            showConfirmButton: false,
                            background: '#E1FFF7',
                            color: '#000000',
                            position: 'top-end',
                            timer: 3000,
                            timerProgressBar: true,
                        });

                        // Change last instructor
                        $(".last-insturctions").text("Buy A");

                        // Add attribute input and button buy for disabled
                        $("#buy-a").attr('disabled', true);
                        $("#send-buy-a").attr('disabled', true);
                        $('#cancel-buy-a').removeAttr('disabled');
                        $("#buy-date-a").text('<?= date('d/m/y | H:i')?>');
                        
                        // remove attribute input and button sell for enabled
                        $('#sell-a').removeAttr('readonly');
                        $('#send-sell-a').removeAttr('disabled');
                        $('#sell-a').autoNumeric('destroy');
                        $('#sell-a').autoNumeric('init', {
                            aSep: ',',
                            aDec: '.',
                            aForm: true,
                            vMax: '99999999999',
                            vMin: '0'
                        });

                        // remove attribute input and button buy B for enabled
                        $('#buy-b').removeAttr('readonly');
                        $('#send-buy-b').removeAttr('disabled');
                        $('#buy-b').autoNumeric('destroy');
                        $('#buy-b').autoNumeric('init', {
                            aSep: ',',
                            aDec: '.',
                            aForm: true,
                            vMax: '99999999999',
                            vMin: '0'
                        });

                    }else{
                        // Sweet Alert
                        Swal.fire({
                            text: `${result.message}`,
                            showCloseButton: true,
                            showConfirmButton: false,
                            background: '#FFE4DC',
                            color: '#000000',
                            position: 'top-end',
                            timer: 3000,
                            timerProgressBar: true,
                        });
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // Sweet Alert
                    Swal.fire({
                        text: `${textStatus}`,
                        showCloseButton: true,
                        showConfirmButton: false,
                        background: '#FFE4DC',
                        color: '#000000',
                        position: 'top-end',
                        timer: 3000,
                        timerProgressBar: true,
                    });
                }
            })
        })


        // Buy B when the button is clicked
        $('#send-buy-b').click(function(e){
            // for not refresh
            e.preventDefault();

            // init data for send to controller
            let formData = {
                price: $("#buy-b").val(),
                type: 'Buy B',
                pair_id: null
            };

            // Ajax Proccess
            $.ajax({
                url: '<?=BASE_URL?>godmode/signal/buysignal',
                type: 'POST',
                data: formData,
                success: function (ress) {
                    // Parse Data
                    let result = JSON.parse(ress)

                    // Check if response success
                    if(result.code == '200'){
                        // Sweet Alert
                        Swal.fire({
                            text: `${result.message}`,
                            showCloseButton: true,
                            showConfirmButton: false,
                            background: '#E1FFF7',
                            color: '#000000',
                            position: 'top-end',
                            timer: 3000,
                            timerProgressBar: true,
                        });

                        // Change last instructor
                        $(".last-insturctions").text("Buy B");

                        // Add attribute input and button buy for disabled
                        $("#buy-b").attr('disabled', true);
                        $("#send-buy-b").attr('disabled', true);
                        $('#cancel-buy-b').removeAttr('disabled');
                        $("#buy-date-b").text('<?= date('d/m/y | H:i')?>');

                        // remove attribute input and button sell for enabled
                        $('#sell-b').removeAttr('readonly');
                        $('#send-sell-b').removeAttr('disabled');
                        $('#sell-b').autoNumeric('destroy');
                        $('#sell-b').autoNumeric('init', {
                            aSep: ',',
                            aDec: '.',
                            aForm: true,
                            vMax: '99999999999',
                            vMin: '0'
                        });

                        // remove attribute input and button buy C for enabled
                        $('#buy-c').removeAttr('readonly');
                        $('#send-buy-c').removeAttr('disabled');
                        $('#buy-c').autoNumeric('destroy');
                        $('#buy-c').autoNumeric('init', {
                            aSep: ',',
                            aDec: '.',
                            aForm: true,
                            vMax: '99999999999',
                            vMin: '0'
                        });

                    }else{
                        // Sweet Alert
                        Swal.fire({
                            text: `${result.message}`,
                            showCloseButton: true,
                            showConfirmButton: false,
                            background: '#FFE4DC',
                            color: '#000000',
                            position: 'top-end',
                            timer: 3000,
                            timerProgressBar: true,
                        });
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // Sweet Alert
                    Swal.fire({
                        text: `${textStatus}`,
                        showCloseButton: true,
                        showConfirmButton: false,
                        background: '#FFE4DC',
                        color: '#000000',
                        position: 'top-end',
                        timer: 3000,
                        timerProgressBar: true,
                    });
                }
            })
        })

        // Buy C when the button is clicked
        $('#send-buy-c').click(function(e){
            // for not refresh
            e.preventDefault();

            // init data for send to controller
            let formData = {
                price: $("#buy-c").val(),
                type: 'Buy C',
                pair_id: null
            };

            // Ajax Proccess
            $.ajax({
                url: '<?=BASE_URL?>godmode/signal/buysignal',
                type: 'POST',
                data: formData,
                success: function (ress) {
                    // Parse Data
                    let result = JSON.parse(ress)

                    // Check if response success
                    if(result.code == '200'){
                        // Sweet Alert
                        Swal.fire({
                            text: `${result.message}`,
                            showCloseButton: true,
                            showConfirmButton: false,
                            background: '#E1FFF7',
                            color: '#000000',
                            position: 'top-end',
                            timer: 3000,
                            timerProgressBar: true,
                        });

                        // Change last instructor
                        $(".last-insturctions").text("Buy C");
                        $('#cancel-buy-a').attr('disabled', true);
                        $('#cancel-buy-b').attr('disabled', true);

                        // Add attribute input and button buy for disabled
                        $("#buy-c").attr('disabled', true);
                        $("#send-buy-c").attr('disabled', true);
                        $('#cancel-buy-c').removeAttr('disabled');
                        $("#buy-date-c").text('<?= date('d/m/y | H:i')?>');

                        // remove attribute input and button sell for enabled
                        $('#sell-c').removeAttr('readonly');
                        $('#send-sell-c').removeAttr('disabled');
                        $('#sell-c').autoNumeric('destroy');
                        $('#sell-c').autoNumeric('init', {
                            aSep: ',',
                            aDec: '.',
                            aForm: true,
                            vMax: '99999999999',
                            vMin: '0'
                        });

                        // remove attribute input and button buy D for enabled
                        $('#buy-d').removeAttr('readonly');
                        $('#send-buy-d').removeAttr('disabled');
                        $('#buy-d').autoNumeric('destroy');
                        $('#buy-d').autoNumeric('init', {
                            aSep: ',',
                            aDec: '.',
                            aForm: true,
                            vMax: '99999999999',
                            vMin: '0'
                        });

                    }else{
                        // Sweet Alert
                        Swal.fire({
                            text: `${result.message}`,
                            showCloseButton: true,
                            showConfirmButton: false,
                            background: '#FFE4DC',
                            color: '#000000',
                            position: 'top-end',
                            timer: 3000,
                            timerProgressBar: true,
                        });
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // Sweet Alert
                    Swal.fire({
                        text: `${textStatus}`,
                        showCloseButton: true,
                        showConfirmButton: false,
                        background: '#FFE4DC',
                        color: '#000000',
                        position: 'top-end',
                        timer: 3000,
                        timerProgressBar: true,
                    });
                }
            })
        })
        // Buy D when the button is clicked
        $('#send-buy-d').click(function(e){
            // for not refresh
            e.preventDefault();

            // init data for send to controller
            let formData = {
                price: $("#buy-d").val(),
                type: 'Buy D',
                pair_id: null
            };

            // Ajax Proccess
            $.ajax({
                url: '<?=BASE_URL?>godmode/signal/buysignal',
                type: 'POST',
                data: formData,
                success: function (ress) {
                    // Parse Data
                    let result = JSON.parse(ress)

                    // Check if response success
                    if(result.code == '200'){
                        // Sweet Alert
                        Swal.fire({
                            text: `${result.message}`,
                            showCloseButton: true,
                            showConfirmButton: false,
                            background: '#E1FFF7',
                            color: '#000000',
                            position: 'top-end',
                            timer: 3000,
                            timerProgressBar: true,
                        });

                        // Change last instructor
                        $(".last-insturctions").text("Buy D");

                        $('#cancel-buy-a').attr('disabled', true);
                        $('#cancel-buy-b').attr('disabled', true);
                        $('#cancel-buy-c').attr('disabled', true);

                        // Add attribute input and button buy for disabled
                        $("#buy-d").attr('disabled', true);
                        $("#send-buy-d").attr('disabled', true);
                        $('#cancel-buy-d').removeAttr('disabled');
                        $("#buy-date-d").text('<?= date('d/m/y | H:i')?>');

                        // remove attribute input and button sell for enabled
                        $('#sell-d').removeAttr('readonly');
                        $('#send-sell-d').removeAttr('disabled');
                        $('#sell-d').autoNumeric('destroy');
                        $('#sell-d').autoNumeric('init', {
                            aSep: ',',
                            aDec: '.',
                            aForm: true,
                            vMax: '99999999999',
                            vMin: '0'
                        });

                    }else{
                        // Sweet Alert
                        Swal.fire({
                            text: `${result.message}`,
                            showCloseButton: true,
                            showConfirmButton: false,
                            background: '#FFE4DC',
                            color: '#000000',
                            position: 'top-end',
                            timer: 3000,
                            timerProgressBar: true,
                        });
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // Sweet Alert
                    Swal.fire({
                        text: `${textStatus}`,
                        showCloseButton: true,
                        showConfirmButton: false,
                        background: '#FFE4DC',
                        color: '#000000',
                        position: 'top-end',
                        timer: 3000,
                        timerProgressBar: true,
                    });
                }
            })
        })

        $('#table_message').DataTable({
            "pageLength": 50,
            "scrollX": true,
            "order": false,
            "ajax": {
                "url": "<?= BASE_URL ?>godmode/signal/list_history_order",
                "type": "POST",
                "dataSrc":function (data){
                    let firstSellIndex = null;
                    data.forEach((row, index) => {
                        if (firstSellIndex === null && row.type.toLowerCase().split(" ")[0] === "sell") {
                            firstSellIndex = index; // Store the first occurrence of "Sell"
                        }
                        row.isFirstSell = (index === firstSellIndex); // Add a new key to track
                    });
                    return data;						
                }
            },
            "columns": [
                { data: 'type' },
                { 
                   data: "entry_price", 
                   "mRender": function(data, type, full, meta) {
                        if (type === 'display') {
                            return parseFloat(data).toLocaleString('en-US', {
                                minimumFractionDigits: 0,
                                maximumFractionDigits: 0
                            });
                        }
                        return data;
                    } 
                },
                { 
                   data: "created_at", 
                   "mRender": function(data, type, full, meta) {
                        if (type === 'display') {
                            // Convert the date to the desired format
                            var date = new Date(data);
                            var day = ('0' + date.getDate()).slice(-2);
                            var month = ('0' + (date.getMonth() + 1)).slice(-2);
                            var year = date.getFullYear().toString().slice(-2);
                            return day + '/' + month + '/' + year;
                        }
                        return data;
                    } 
                },
                { 
                   data: "created_at", 
                   "mRender": function(data, type, full, meta) {
                        if (type === 'display') {
                            // Extract the time (HH:mm) from the datetime string
                            var date = new Date(data);
                            var hours = ('0' + date.getHours()).slice(-2);
                            var minutes = ('0' + date.getMinutes()).slice(-2);
                            return hours + ':' + minutes;
                        }
                        return data;
                    } 
                },
                { 
                   data: null, 
                   "mRender": function(data, type, full, meta) {
                       // Only show button for first "Sell" row
                        if (full.isFirstSell) {
                            return '<a href="<?=BASE_URL?>godmode/signal/cancel_sell?id=' + full.id + '&pair_id=' + full.pair_id + 
                                   '" class="btn btn-sm btn-danger">Cancel</a>';
                        }
                        return ''; // Empty for other rows
                    } 
                },
                
            ],

        });

    })

</script>