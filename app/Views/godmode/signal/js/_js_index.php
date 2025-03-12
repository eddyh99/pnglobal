<script>
    window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function() {
            $(this).remove();
        });
    }, 5000);
    $(document).ready(function() {
        // Inisialisasi autoNumeric pada semua input harga
        $('#buy-a, #buy-b, #buy-c, #buy-d, #sell-a, #sell-b, #sell-c, #sell-d').autoNumeric('init', {
            aSep: ',',
            aDec: '.',
            aForm: true,
            vMax: '99999999999',
            vMin: '0'
        });

        // Debug: Log status tombol sell saat halaman dimuat
        console.log('Status tombol sell-a:', $('#send-sell-a').prop('disabled'));
        console.log('Status tombol sell-b:', $('#send-sell-b').prop('disabled'));
        console.log('Status tombol sell-c:', $('#send-sell-c').prop('disabled'));
        console.log('Status tombol sell-d:', $('#send-sell-d').prop('disabled'));

        // Pastikan tombol sell tidak disabled jika sudah ada nilai buy yang diinput
        if ($('#buy-a').val() && $('#buy-a').prop('disabled')) {
            $('#sell-a').removeAttr('readonly');
            $('#send-sell-a').removeAttr('disabled');
        }
        if ($('#buy-b').val() && $('#buy-b').prop('disabled')) {
            $('#sell-b').removeAttr('readonly');
            $('#send-sell-b').removeAttr('disabled');
        }
        if ($('#buy-c').val() && $('#buy-c').prop('disabled')) {
            $('#sell-c').removeAttr('readonly');
            $('#send-sell-c').removeAttr('disabled');
        }
        if ($('#buy-d').val() && $('#buy-d').prop('disabled')) {
            $('#sell-d').removeAttr('readonly');
            $('#send-sell-d').removeAttr('disabled');
        }

        // Fungsi untuk menghitung nilai buy berdasarkan aturan bisnis
        function calculateBuyValues(initialCapital) {
            // Pastikan initialCapital adalah kelipatan 2000
            initialCapital = Math.floor(initialCapital / 2000) * 2000;

            // Setiap buy adalah 1/4 dari initial capital
            const buyValue = initialCapital / 4;

            return {
                buyA: buyValue,
                buyB: buyValue,
                buyC: buyValue,
                buyD: buyValue,
                total: initialCapital
            };
        }

        // Event handler untuk input buy-a untuk menghitung nilai buy secara otomatis
        $('#buy-a').on('input', function() {
            // Hanya lakukan perhitungan jika buy-a belum disubmit
            if (!$('#send-buy-a').prop('disabled')) {
                const inputValue = $(this).autoNumeric('get');
                if (inputValue && !isNaN(inputValue)) {
                    const initialCapital = parseFloat(inputValue) * 4; // Total capital adalah 4x nilai buy-a
                    const values = calculateBuyValues(initialCapital);

                    // Update nilai di UI
                    $('#buy-a').autoNumeric('set', values.buyA);
                }
            }
        });

        // Buy A when the button is clicked
        $('#send-buy-a').click(function(e) {
            // for not refresh
            e.preventDefault();

            // init data for send to controller
            let formData = {
                price: $("#buy-a").val(),
                type: 'BUY A',
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

                        // Dapatkan nilai buy-a untuk menghitung nilai buy lainnya
                        const buyAValue = $("#buy-a").autoNumeric('get');
                        const values = calculateBuyValues(buyAValue * 4); // Total capital adalah 4x nilai buy-a

                        // Add attribute input and button buy for disabled
                        $("#buy-a").attr('disabled', true);
                        $("#send-buy-a").attr('disabled', true);
                        $('#cancel-buy-a').removeAttr('disabled');
                        $("#buy-date-a").text('<?= date('d/m/y | H:i') ?>');

                        // Jika ada ID dalam respons, tambahkan sebagai pair_id ke baris
                        if (result.id) {
                            $("#send-buy-a").closest('tr').attr('data-pair-id', result.id);
                        }

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

                        // Set nilai buy-b sama dengan buy-a (1/4 dari total capital)
                        $('#buy-b').autoNumeric('set', values.buyB);

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
                type: 'BUY B',
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

                        // Dapatkan nilai buy-a untuk menghitung nilai buy lainnya
                        const buyAValue = $("#buy-a").autoNumeric('get');
                        const values = calculateBuyValues(buyAValue * 4); // Total capital adalah 4x nilai buy-a

                        // Add attribute input and button buy for disabled
                        $("#buy-b").attr('disabled', true);
                        $("#send-buy-b").attr('disabled', true);
                        $('#cancel-buy-b').removeAttr('disabled');
                        $("#buy-date-b").text('<?= date('d/m/y | H:i') ?>');

                        // Jika ada ID dalam respons, tambahkan sebagai pair_id ke baris
                        if (result.id) {
                            $("#send-buy-b").closest('tr').attr('data-pair-id', result.id);
                        }

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

                        // Set nilai buy-c sama dengan buy-a dan buy-b (1/4 dari total capital)
                        $('#buy-c').autoNumeric('set', values.buyC);

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
                type: 'BUY C',
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

                        // Dapatkan nilai buy-a untuk menghitung nilai buy lainnya
                        const buyAValue = $("#buy-a").autoNumeric('get');
                        const values = calculateBuyValues(buyAValue * 4); // Total capital adalah 4x nilai buy-a

                        // Add attribute input and button buy for disabled
                        $("#buy-c").attr('disabled', true);
                        $("#send-buy-c").attr('disabled', true);
                        $('#cancel-buy-c').removeAttr('disabled');
                        $("#buy-date-c").text('<?= date('d/m/y | H:i') ?>');

                        // Jika ada ID dalam respons, tambahkan sebagai pair_id ke baris
                        if (result.id) {
                            $("#send-buy-c").closest('tr').attr('data-pair-id', result.id);
                        }

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

                        // Set nilai buy-d sama dengan buy-a, buy-b, dan buy-c (1/4 dari total capital)
                        $('#buy-d').autoNumeric('set', values.buyD);

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
                type: 'BUY D',
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

                        // Jika ada ID dalam respons, tambahkan sebagai pair_id ke baris
                        if (result.id) {
                            $("#send-buy-d").closest('tr').attr('data-pair-id', result.id);
                        }

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
            if (currentStatus !== 'new') {
                Swal.fire({
                    text: 'Only New Signal Can Be Filled',
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

            // Debug: Log tombol yang diklik
            console.log('Tombol sell diklik:', this.id);

            // Dapatkan ID tombol untuk menentukan tipe signal
            const buttonId = $(this).attr('id');
            const signalType = buttonId.replace('send-', '').replace('-', ' ').toUpperCase();
            const signalLetter = signalType.split(' ')[1]; // A, B, C, atau D

            console.log('Signal Type:', signalType);
            console.log('Signal Letter:', signalLetter);

            // Dapatkan nilai harga
            const priceInput = $(`#sell-${signalLetter.toLowerCase()}`);
            console.log('Price Input Element:', priceInput.length > 0 ? 'Found' : 'Not Found');
            console.log('Price Input Value:', priceInput.val());
            console.log('Price Input Disabled:', priceInput.prop('disabled'));
            console.log('Price Input Readonly:', priceInput.prop('readonly'));

            // Pastikan nilai harga diambil dengan benar dari autoNumeric
            // Gunakan autoNumeric('get') untuk mendapatkan nilai numerik tanpa format
            let price;
            try {
                // Coba dapatkan nilai dengan autoNumeric jika tersedia
                price = priceInput.autoNumeric('get');
                console.log('Price from autoNumeric:', price);
            } catch (error) {
                // Jika error, gunakan nilai biasa
                price = priceInput.val();
                // Hapus koma jika ada
                price = price.replace(/,/g, '');
                console.log('Price from val():', price);
                console.log('AutoNumeric error:', error.message);
            }

            // Dapatkan pair_id dari buy yang sesuai
            const buyRow = $(`#buy-${signalLetter.toLowerCase()}`).closest('tr');
            const pairId = buyRow.data('pair-id') || null;
            console.log('Pair ID:', pairId);

            // Validasi harga - pastikan nilai tidak kosong dan merupakan angka
            if (!price || price.trim() === '' || isNaN(parseFloat(price))) {
                console.log('Validasi harga gagal:', price);
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

            // Implementasi aturan bisnis berdasarkan tipe SELL
            let affectedBuys = [];
            let sellMessage = '';

            // Menerapkan aturan bisnis:
            // 1. Buy A, B, C, D trus SELL D -> hanya dari Buy D
            // 2. Buy A, B, C, D trus SELL C -> Buy C+D
            // 3. Buy A, B, C, D trus SELL B -> Buy B+C+D
            // 4. Buy A, B, C, D trus SELL A -> Buy A+B+C+D
            switch (signalLetter) {
                case 'A':
                    affectedBuys = ['A', 'B', 'C', 'D'];
                    sellMessage = 'Menjual posisi A+B+C+D';
                    break;
                case 'B':
                    affectedBuys = ['B', 'C', 'D'];
                    sellMessage = 'Menjual posisi B+C+D';
                    break;
                case 'C':
                    affectedBuys = ['C', 'D'];
                    sellMessage = 'Menjual posisi C+D';
                    break;
                case 'D':
                    affectedBuys = ['D'];
                    sellMessage = 'Menjual posisi D';
                    break;
            }

            console.log('Affected Buys:', affectedBuys);
            console.log('Sell Message:', sellMessage);

            // Data yang akan dikirim ke server
            const sendData = {
                price: price,
                type: signalType,
                pair_id: pairId,
                affected_buys: affectedBuys.join(',') // Mengirim informasi buy yang terpengaruh
            };

            console.log('Data yang dikirim ke server:', sendData);

            // Kirim data ke server
            $.ajax({
                url: '<?= BASE_URL ?>godmode/signal/sellsignal',
                type: 'POST',
                data: sendData,
                success: function(ress) {
                    console.log('Response dari server:', ress);

                    // Parse Data
                    let result;
                    try {
                        result = JSON.parse(ress);
                        console.log('Parsed result:', result);
                    } catch (error) {
                        console.error('Error parsing JSON:', error);
                        console.log('Raw response:', ress);
                        Swal.fire({
                            text: 'Error processing server response',
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

                    // Check if response success
                    if (result.code == '200') {
                        // Update UI
                        priceInput.prop('readonly', true);
                        $(`#${buttonId}`).prop('disabled', true);

                        // Nonaktifkan tombol SELL untuk buy yang terpengaruh
                        affectedBuys.forEach(letter => {
                            $(`#sell-${letter.toLowerCase()}`).prop('readonly', true);
                            $(`#send-sell-${letter.toLowerCase()}`).prop('disabled', true);
                        });

                        // Sweet Alert dengan pesan yang lebih informatif
                        Swal.fire({
                            text: `${result.message} - ${sellMessage}`,
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