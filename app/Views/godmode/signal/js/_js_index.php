<script>
    window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function() {
            $(this).remove();
        });
    }, 5000);
    $(document).ready(function() {

        // Buy A when the button is clicked
        $('#send-buy-a').click(function(e) {
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
                url: '<?= BASE_URL ?>godmode/signal/buysignal',
                type: 'POST',
                data: formData,
                success: function(ress) {
                    // Parse Data
                    let result = JSON.parse(ress)

                    // Check if response success
                    if (result.code == '200') {
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
                        $("#buy-date-a").text('<?= date('d/m/y | H:i') ?>');

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

                    } else {
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
        $('#send-buy-b').click(function(e) {
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
                url: '<?= BASE_URL ?>godmode/signal/buysignal',
                type: 'POST',
                data: formData,
                success: function(ress) {
                    // Parse Data
                    let result = JSON.parse(ress)

                    // Check if response success
                    if (result.code == '200') {
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
                        $("#buy-date-b").text('<?= date('d/m/y | H:i') ?>');

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

                    } else {
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
        $('#send-buy-c').click(function(e) {
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
                url: '<?= BASE_URL ?>godmode/signal/buysignal',
                type: 'POST',
                data: formData,
                success: function(ress) {
                    // Parse Data
                    let result = JSON.parse(ress)

                    // Check if response success
                    if (result.code == '200') {
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
                        $("#buy-date-c").text('<?= date('d/m/y | H:i') ?>');

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

                    } else {
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
        $('#send-buy-d').click(function(e) {
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
                url: '<?= BASE_URL ?>godmode/signal/buysignal',
                type: 'POST',
                data: formData,
                success: function(ress) {
                    // Parse Data
                    let result = JSON.parse(ress)

                    // Check if response success
                    if (result.code == '200') {
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
                        $("#buy-date-d").text('<?= date('d/m/y | H:i') ?>');

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

                    } else {
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
                "dataSrc": function(data) {
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
            "columns": [{
                    data: 'type'
                },
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
                    data: "date",
                },
                {
                    data: "time",
                },
                {
                    data: null,
                    "mRender": function(data, type, full, meta) {
                        // Only show button for first "Sell" row
                        if (full.isFirstSell) {
                            return '<a href="<?= BASE_URL ?>godmode/signal/cancel_sell?id=' + full.id + '&pair_id=' + full.pair_id +
                                '" class="btn btn-sm btn-danger">Cancel</a>';
                        }
                        return ''; // Empty for other rows
                    }
                },

            ],

        });

        // Fungsi untuk menangani tombol FILL pada BUY
        $('#fill-buy-a, #fill-buy-b, #fill-buy-c, #fill-buy-d').click(function(e) {
            e.preventDefault();

            // Dapatkan ID tombol untuk menentukan tipe signal
            const buttonId = $(this).attr('id');
            const signalType = buttonId.replace('fill-', '').replace('-', ' ').toUpperCase();

            // Dapatkan status saat ini
            const statusElement = $(this).closest('tr').find('.signal-status');
            const currentStatus = statusElement.text().trim();

            // Hanya bisa FILL jika status Pending
            if (currentStatus !== 'Pending') {
                Swal.fire({
                    text: 'Hanya signal dengan status Pending yang dapat di-Fill',
                    showCloseButton: true,
                    showConfirmButton: false,
                    background: '#FFE4DC',
                    color: '#000000',
                    position: 'top-end',
                    timer: 3000,
                    timerProgressBar: true,
                });
                return;
            }

            // Kirim data ke server
            $.ajax({
                url: '<?= BASE_URL ?>godmode/signal/fillsignal',
                type: 'POST',
                data: {
                    type: signalType
                },
                success: function(ress) {
                    // Parse Data
                    let result = JSON.parse(ress);

                    // Check if response success
                    if (result.code == '200') {
                        // Update status
                        statusElement.text('Filled');

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
                    } else {
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
            });
        });

        // Fungsi untuk menangani tombol FILL pada SELL
        $('#fill-sell-a, #fill-sell-b, #fill-sell-c, #fill-sell-d').click(function(e) {
            e.preventDefault();

            // Dapatkan ID tombol untuk menentukan tipe signal
            const buttonId = $(this).attr('id');
            const signalType = buttonId.replace('fill-', '').replace('-', ' ').toUpperCase();

            // Dapatkan status saat ini
            const statusElement = $(this).closest('tr').find('.signal-status');
            const currentStatus = statusElement.text().trim();

            // Hanya bisa FILL jika status Pending
            if (currentStatus !== 'Pending') {
                Swal.fire({
                    text: 'Hanya signal dengan status Pending yang dapat di-Fill',
                    showCloseButton: true,
                    showConfirmButton: false,
                    background: '#FFE4DC',
                    color: '#000000',
                    position: 'top-end',
                    timer: 3000,
                    timerProgressBar: true,
                });
                return;
            }

            // Kirim data ke server
            $.ajax({
                url: '<?= BASE_URL ?>godmode/signal/fillsignal',
                type: 'POST',
                data: {
                    type: signalType
                },
                success: function(ress) {
                    // Parse Data
                    let result = JSON.parse(ress);

                    // Check if response success
                    if (result.code == '200') {
                        // Update status
                        statusElement.text('Filled');

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
                    } else {
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
            });
        });

        // Fungsi untuk menangani tombol DEL pada BUY
        $('#del-buy-a, #del-buy-b, #del-buy-c, #del-buy-d').click(function(e) {
            e.preventDefault();

            // Dapatkan ID tombol untuk menentukan tipe signal
            const buttonId = $(this).attr('id');
            const signalType = buttonId.replace('del-', '').replace('-', ' ').toUpperCase();

            // Konfirmasi penghapusan
            Swal.fire({
                title: 'Confirmation',
                text: 'Are you sure you want to delete this signal?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Kirim data ke server
                    $.ajax({
                        url: '<?= BASE_URL ?>godmode/signal/deletesignal',
                        type: 'POST',
                        data: {
                            type: signalType
                        },
                        success: function(ress) {
                            // Parse Data
                            let result = JSON.parse(ress);

                            // Check if response success
                            if (result.code == '200') {
                                // Reset input dan status
                                const row = $(`#${buttonId}`).closest('tr');
                                const priceInput = row.find('.signal-price');
                                const statusElement = row.find('.signal-status');

                                priceInput.prop('readonly', false);
                                statusElement.text('Pending');

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
                            } else {
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
                    });
                }
            });
        });

        // Fungsi untuk menangani tombol DEL pada SELL
        $('#del-sell-a, #del-sell-b, #del-sell-c, #del-sell-d').click(function(e) {
            e.preventDefault();

            // Dapatkan ID tombol untuk menentukan tipe signal
            const buttonId = $(this).attr('id');
            const signalType = buttonId.replace('del-', '').replace('-', ' ').toUpperCase();

            // Konfirmasi penghapusan
            Swal.fire({
                title: 'Confirmation',
                text: 'Are you sure you want to delete this signal?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Kirim data ke server
                    $.ajax({
                        url: '<?= BASE_URL ?>godmode/signal/deletesignal',
                        type: 'POST',
                        data: {
                            type: signalType
                        },
                        success: function(ress) {
                            // Parse Data
                            let result = JSON.parse(ress);

                            // Check if response success
                            if (result.code == '200') {
                                // Reset input dan status
                                const row = $(`#${buttonId}`).closest('tr');
                                const priceInput = row.find('.signal-price');
                                const statusElement = row.find('.signal-status');

                                priceInput.prop('readonly', true);
                                statusElement.text('Pending');

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
                            } else {
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
                    });
                }
            });
        });

        // Fungsi untuk menangani tombol SELL
        $('#send-sell-a, #send-sell-b, #send-sell-c, #send-sell-d').click(function(e) {
            e.preventDefault();

            // Dapatkan ID tombol untuk menentukan tipe signal
            const buttonId = $(this).attr('id');
            const signalType = buttonId.replace('send-', '').replace('-', ' ').toUpperCase();
            const signalLetter = signalType.split(' ')[1]; // A, B, C, atau D

            // Dapatkan nilai harga
            const priceInput = $(`#sell-${signalLetter.toLowerCase()}`);
            const price = priceInput.val();

            // Dapatkan pair_id dari buy yang sesuai
            const buyRow = $(`#buy-${signalLetter.toLowerCase()}`).closest('tr');
            const pairId = buyRow.data('pair-id') || null;

            // Validasi harga
            if (!price || isNaN(price)) {
                Swal.fire({
                    text: 'Price must be a number',
                    showCloseButton: true,
                    showConfirmButton: false,
                    background: '#FFE4DC',
                    color: '#000000',
                    position: 'top-end',
                    timer: 3000,
                    timerProgressBar: true,
                });
                return;
            }

            // Kirim data ke server
            $.ajax({
                url: '<?= BASE_URL ?>godmode/signal/sellsignal',
                type: 'POST',
                data: {
                    price: price,
                    type: signalType,
                    pair_id: pairId
                },
                success: function(ress) {
                    // Parse Data
                    let result = JSON.parse(ress);

                    // Check if response success
                    if (result.code == '200') {
                        // Update UI
                        priceInput.prop('readonly', true);
                        $(`#${buttonId}`).prop('disabled', true);

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

                        // Refresh tabel history
                        $('#table_message').DataTable().ajax.reload();
                    } else {
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
            });
        });
    })
</script>