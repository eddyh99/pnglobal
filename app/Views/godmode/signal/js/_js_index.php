<style>
    .loading-state {
        position: relative;
        pointer-events: none;
        opacity: 0.7;
        color: transparent !important;
    }

    .loading-state:after {
        content: "";
        position: absolute;
        width: 16px;
        height: 16px;
        top: 50%;
        left: 50%;
        margin-top: -8px;
        margin-left: -8px;
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-top-color: #fff;
        border-radius: 50%;
        animation: loading-spinner 0.6s linear infinite;
    }

    @keyframes loading-spinner {
        to {
            transform: rotate(360deg);
        }
    }
</style>
<script>
    window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function() {
            $(this).remove();
        });
    }, 5000);
    $(document).ready(function() {
        // Fungsi untuk menangani loading state
        function handleButtonLoading(button) {
            // Simpan teks asli button sebagai data attribute
            button.setAttribute('data-original-text', button.textContent);
            button.classList.add('loading-state');
            button.disabled = true;
        }

        // Fungsi untuk menghapus loading state
        function removeButtonLoading(button) {
            button.classList.remove('loading-state');
            button.disabled = false;
        }

        // Menangani semua button buy
        document.querySelectorAll('[id^="send-buy-"]').forEach(button => {
            button.addEventListener('click', function(e) {
                handleButtonLoading(this);
                // Loading state akan dihapus setelah ajax selesai
            });
        });

        // Menangani semua button delete
        document.querySelectorAll('[id^="del-buy-"], [id^="del-sell-"]').forEach(button => {
            button.addEventListener('click', function(e) {
                handleButtonLoading(this);
                // Loading state akan dihapus setelah ajax selesai
            });
        });

        // Debug: Log bahwa dokumen sudah siap
        console.log('Document ready - Initializing event handlers');

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

        // Fungsi untuk mengatur status tombol berdasarkan status signal
        function updateButtonStatus() {
            // Periksa status untuk setiap baris
            ['a', 'b', 'c', 'd'].forEach(letter => {
                const buyInput = $(`#buy-${letter}`);
                const buyValue = buyInput.val();
                const buyStatus = buyInput.closest('tr').find('.signal-status').text().trim().toLowerCase();
                const sellInput = $(`#sell-${letter}`);
                const sellValue = sellInput.val();
                const sellStatus = sellInput.closest('tr').find('.signal-status').text().trim().toLowerCase();
                const delBuyBtn = $(`#del-buy-${letter}`);
                const delSellBtn = $(`#del-sell-${letter}`);

                console.log(`Buy ${letter.toUpperCase()} status:`, buyStatus);
                console.log(`Buy ${letter.toUpperCase()} value:`, buyValue);
                console.log(`Sell ${letter.toUpperCase()} status:`, sellStatus);
                console.log(`Sell ${letter.toUpperCase()} value:`, sellValue);

                // Atur tombol DEL BUY berdasarkan nilai input
                if (!buyValue || buyValue === '') {
                    // Jika field kosong, disable tombol DEL dan ubah warna menjadi abu-abu
                    delBuyBtn.prop('disabled', true).addClass('disabled-btn').css({
                        'border-color': '#6c757d',
                        'color': '#6c757d',
                        'cursor': 'not-allowed'
                    });
                } else {
                    // Jika field sudah terisi, enable tombol DEL dan kembalikan warna merah
                    delBuyBtn.prop('disabled', false).removeClass('disabled-btn').css({
                        'border-color': '#f80d0d',
                        'color': '#ffffff',
                        'cursor': 'pointer'
                    });
                }

                // Atur tombol DEL SELL berdasarkan nilai input
                if (!sellValue || sellValue === '') {
                    // Jika field kosong, disable tombol DEL dan ubah warna menjadi abu-abu
                    delSellBtn.prop('disabled', true).addClass('disabled-btn').css({
                        'border-color': '#6c757d',
                        'color': '#6c757d',
                        'cursor': 'not-allowed'
                    });
                } else {
                    // Jika field sudah terisi, enable tombol DEL dan kembalikan warna merah
                    delSellBtn.prop('disabled', false).removeClass('disabled-btn').css({
                        'border-color': '#f80d0d',
                        'color': '#ffffff',
                        'cursor': 'pointer'
                    });
                }

                // Atur tombol FILL berdasarkan status
                if (buyStatus === 'filled') {
                    // Jika status buy adalah filled, disable tombol FILL
                    $(`#fill-buy-${letter}`).prop('disabled', true).addClass('filled');
                } else if (buyStatus === 'new' || buyStatus === 'pending') {
                    // Jika status buy adalah new atau pending, enable tombol FILL
                    $(`#fill-buy-${letter}`).prop('disabled', false).removeClass('filled');
                }

                if (sellStatus === 'filled') {
                    // Jika status sell adalah filled, disable tombol FILL
                    $(`#fill-sell-${letter}`).prop('disabled', true).addClass('filled');
                } else if (sellStatus === 'pending') {
                    // Jika status sell adalah pending, enable tombol FILL
                    $(`#fill-sell-${letter}`).prop('disabled', false).removeClass('filled');
                }

                // Jika status buy masih new, disable tombol SELL
                if (buyStatus === 'new') {
                    $(`#sell-${letter}`).prop('readonly', true);
                    $(`#send-sell-${letter}`).prop('disabled', true);
                } else if (buyStatus === 'filled') {
                    // Jika status buy adalah filled, enable tombol SELL
                    $(`#sell-${letter}`).prop('readonly', false);
                    $(`#send-sell-${letter}`).prop('disabled', false);
                }
            });
        }

        // Panggil fungsi saat halaman dimuat
        updateButtonStatus();

        // Tambahkan event listener untuk input harga BUY
        $('#buy-a, #buy-b, #buy-c, #buy-d').on('input', function() {
            const letter = $(this).attr('id').replace('buy-', '');
            const value = $(this).val();
            const delBtn = $(`#del-buy-${letter}`);

            if (!value || value === '') {
                // Jika field kosong, disable tombol DEL dan ubah warna menjadi abu-abu
                delBtn.prop('disabled', true).addClass('disabled-btn').css({
                    'border-color': '#6c757d',
                    'color': '#6c757d',
                    'cursor': 'not-allowed'
                });
            } else {
                // Jika field sudah terisi, enable tombol DEL dan kembalikan warna merah
                delBtn.prop('disabled', false).removeClass('disabled-btn').css({
                    'border-color': '#f80d0d',
                    'color': '#ffffff',
                    'cursor': 'pointer'
                });
            }
        });

        // Tambahkan event listener untuk input harga SELL
        $('#sell-a, #sell-b, #sell-c, #sell-d').on('input', function() {
            const letter = $(this).attr('id').replace('sell-', '');
            const value = $(this).val();
            const delBtn = $(`#del-sell-${letter}`);

            if (!value || value === '') {
                // Jika field kosong, disable tombol DEL dan ubah warna menjadi abu-abu
                delBtn.prop('disabled', true).addClass('disabled-btn').css({
                    'border-color': '#6c757d',
                    'color': '#6c757d',
                    'cursor': 'not-allowed'
                });
            } else {
                // Jika field sudah terisi, enable tombol DEL dan kembalikan warna merah
                delBtn.prop('disabled', false).removeClass('disabled-btn').css({
                    'border-color': '#f80d0d',
                    'color': '#ffffff',
                    'cursor': 'pointer'
                });
            }
        });

        // Pastikan tombol sell tidak disabled jika sudah ada nilai buy yang diinput
        if ($('#buy-a').val() && $('#buy-a').prop('disabled')) {
            const buyStatusA = $('#buy-a').closest('tr').find('.signal-status').text().trim().toLowerCase();
            if (buyStatusA !== 'new') {
                $('#sell-a').removeAttr('readonly');
                $('#send-sell-a').removeAttr('disabled');
            }
        }
        if ($('#buy-b').val() && $('#buy-b').prop('disabled')) {
            const buyStatusB = $('#buy-b').closest('tr').find('.signal-status').text().trim().toLowerCase();
            if (buyStatusB !== 'new') {
                $('#sell-b').removeAttr('readonly');
                $('#send-sell-b').removeAttr('disabled');
            }
        }
        if ($('#buy-c').val() && $('#buy-c').prop('disabled')) {
            const buyStatusC = $('#buy-c').closest('tr').find('.signal-status').text().trim().toLowerCase();
            if (buyStatusC !== 'new') {
                $('#sell-c').removeAttr('readonly');
                $('#send-sell-c').removeAttr('disabled');
            }
        }
        if ($('#buy-d').val() && $('#buy-d').prop('disabled')) {
            const buyStatusD = $('#buy-d').closest('tr').find('.signal-status').text().trim().toLowerCase();
            if (buyStatusD !== 'new') {
                $('#sell-d').removeAttr('readonly');
                $('#send-sell-d').removeAttr('disabled');
            }
        }

        // Inisialisasi status tombol DEL saat halaman pertama kali dimuat
        ['a', 'b', 'c', 'd'].forEach(letter => {
            const buyInput = $(`#buy-${letter}`);
            const buyValue = buyInput.val();
            const delBtn = $(`#del-buy-${letter}`);

            if (!buyValue || buyValue === '') {
                // Jika field kosong, disable tombol DEL dan ubah warna menjadi abu-abu
                delBtn.prop('disabled', true).addClass('disabled-btn');
            } else {
                // Jika field sudah terisi, enable tombol DEL dan kembalikan warna merah
                delBtn.prop('disabled', false).removeClass('disabled-btn');
            }
        });

        // Fungsi untuk menghitung nilai 1/4 dari total capital
        function calculateQuarterCapital(totalCapital) {
            // Pastikan totalCapital adalah kelipatan 2000
            totalCapital = Math.floor(totalCapital / 2000) * 2000;
            return totalCapital / 4;
        }

        // Event handler untuk input buy-a
        $('#buy-a').on('input', function() {
            // Hanya format angka, tidak menghitung nilai lainnya
            const inputValue = $(this).autoNumeric('get');
            if (inputValue && !isNaN(inputValue)) {
                $(this).autoNumeric('set', inputValue);

                // Hitung 1/4 dari total capital (untuk referensi)
                const totalCapital = parseFloat(inputValue) * 4;
                const quarterValue = calculateQuarterCapital(totalCapital);

                // Tampilkan nilai referensi di console (bisa diubah ke UI jika diperlukan)
                console.log('Total Capital:', totalCapital);
                console.log('1/4 Capital (Reference):', quarterValue);
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
                            didClose: () => {
                                window.location.reload();
                            }
                        });

                        // Change last instructor
                        $(".last-insturctions").text("Buy A");

                        // Add attribute input and button buy for disabled
                        $("#buy-a").attr('disabled', true);
                        $("#send-buy-a").attr('disabled', true);
                        $('#cancel-buy-a').removeAttr('disabled');
                        $("#buy-date-a").text('<?= date('d/m/y | H:i') ?>');

                        // Aktifkan tombol DEL karena sekarang ada nilai
                        $("#del-buy-a").prop('disabled', false).removeClass('disabled-btn');

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
                            didClose: () => {
                                window.location.reload();
                            }
                        });
                    }
                    removeButtonLoading(document.querySelector('#send-buy-a'));
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
                        didClose: () => {
                            window.location.reload();
                        }
                    });
                    removeButtonLoading(document.querySelector('#send-buy-a'));
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
                            didClose: () => {
                                window.location.reload();
                            }
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

                        // Aktifkan tombol DEL karena sekarang ada nilai
                        $("#del-buy-b").prop('disabled', false).removeClass('disabled-btn');

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
                            didClose: () => {
                                window.location.reload();
                            }
                        });
                    }
                    removeButtonLoading(document.querySelector('#send-buy-b'));
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
                        didClose: () => {
                            window.location.reload();
                        }
                    });
                    removeButtonLoading(document.querySelector('#send-buy-b'));
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
                            didClose: () => {
                                window.location.reload();
                            }
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

                        // Aktifkan tombol DEL karena sekarang ada nilai
                        $("#del-buy-c").prop('disabled', false).removeClass('disabled-btn');

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
                            didClose: () => {
                                window.location.reload();
                            }
                        });
                    }
                    removeButtonLoading(document.querySelector('#send-buy-c'));
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
                        didClose: () => {
                            window.location.reload();
                        }
                    });
                    removeButtonLoading(document.querySelector('#send-buy-c'));
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
                            didClose: () => {
                                window.location.reload();
                            }
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

                        // Aktifkan tombol DEL karena sekarang ada nilai
                        $("#del-buy-d").prop('disabled', false).removeClass('disabled-btn');

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
                            didClose: () => {
                                window.location.reload();
                            }
                        });
                    }
                    removeButtonLoading(document.querySelector('#send-buy-d'));
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
                        didClose: () => {
                            window.location.reload();
                        }
                    });
                    removeButtonLoading(document.querySelector('#send-buy-d'));
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
                    data: "admin",
                },

            ],

        });

        // Fungsi untuk menangani tombol FILL pada BUY
        $('#fill-buy-a, #fill-buy-b, #fill-buy-c, #fill-buy-d').click(function(e) {
            e.preventDefault();

            // Jika tombol disabled, jangan lakukan apa-apa
            if ($(this).prop('disabled')) {
                return;
            }

            // Dapatkan ID tombol untuk menentukan tipe signal
            const buttonId = $(this).attr('id');
            const signalType = buttonId.replace('fill-', '').replace('-', ' ').toUpperCase();

            // Dapatkan ID signal dari data-pair-id pada baris
            const signalId = $(this).closest('tr').data('pair-id');

            // Dapatkan status saat ini
            const statusElement = $(this).closest('tr').find('.signal-status');
            const currentStatus = statusElement.text().trim().toLowerCase();

            // Hanya bisa FILL jika status New atau Pending
            if (currentStatus !== 'new' && currentStatus !== 'pending') {
                Swal.fire({
                    text: 'Only signals with New or Pending status can be filled',
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

            // Konfirmasi sebelum melakukan FILL
            Swal.fire({
                title: 'Confirmation',
                text: `Are you sure you want to fill ${signalType}?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, fill it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Kirim data ke server
                    $.ajax({
                        url: '<?= BASE_URL ?>godmode/signal/fillsignal',
                        type: 'POST',
                        data: {
                            id_signal: signalId
                        },
                        success: function(ress) {
                            // Parse Data
                            let result = JSON.parse(ress);

                            // Check if response success
                            if (result.code == '200') {
                                // Update status
                                statusElement.text('Filled');

                                // Update tombol FILL
                                $(this).prop('disabled', true).addClass('filled');

                                // Update status tombol
                                updateButtonStatus();

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
                                    didClose: () => {
                                        window.location.reload();
                                    }
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
                                    didClose: () => {
                                        window.location.reload();
                                    }
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
        console.log('Setting up SELL button event handlers');

        // Event handler untuk tombol SELL
        $('#send-sell-a, #send-sell-b, #send-sell-c, #send-sell-d').on('click', function(e) {
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
            if (!price || isNaN(parseFloat(price)) || parseFloat(price) <= 0) {
                console.log('Validasi harga gagal:', price);
                Swal.fire({
                    text: 'Price must be a valid number',
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

            // Validasi pair_id - pastikan ada pair_id yang valid
            if (!pairId) {
                console.log('Validasi pair_id gagal:', pairId);
                Swal.fire({
                    text: 'Cannot find the corresponding signal ID',
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

            // Konfirmasi sebelum mengirim SELL
            Swal.fire({
                title: 'Confirmation',
                text: `Are you sure you want to sell ${signalType} at price ${parseFloat(price).toLocaleString('en-US')}?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, sell it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
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
                                    didClose: () => {
                                        window.location.reload();
                                    }
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
                                    didClose: () => {
                                        window.location.reload();
                                    }
                                });
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.error('AJAX Error:', textStatus, errorThrown);
                            // Sweet Alert
                            Swal.fire({
                                text: `Error: ${textStatus}`,
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

        // Fungsi untuk menangani tombol DEL pada BUY
        $('#del-buy-a, #del-buy-b, #del-buy-c, #del-buy-d').click(function(e) {
            e.preventDefault();

            // Dapatkan ID tombol untuk menentukan tipe signal
            const buttonId = $(this).attr('id');
            const signalLetter = buttonId.replace('del-buy-', '').toUpperCase();

            // Dapatkan ID signal dari data-pair-id pada baris
            const signalId = $(this).closest('tr').data('pair-id');

            // Jika tidak ada signal ID, tampilkan pesan error
            if (!signalId) {
                Swal.fire({
                    text: 'Cannot find signal ID',
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

            // Konfirmasi penghapusan
            Swal.fire({
                title: 'Confirmation',
                text: `Are you sure you want to delete Buy ${signalLetter} signal?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Kirim data ke server
                    $.ajax({
                        url: '<?= BASE_URL ?>godmode/signal/deletesignal',
                        type: 'POST',
                        data: {
                            id_signal: signalId
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

                                // Reset nilai input dan status
                                priceInput.val('');
                                priceInput.prop('readonly', false);
                                statusElement.text('Pending');

                                // Reset data-pair-id
                                row.removeAttr('data-pair-id');

                                // Enable tombol BUY
                                row.find(`#send-buy-${signalLetter.toLowerCase()}`).prop('disabled', false);

                                // Disable tombol SELL yang sesuai
                                $(`#sell-${signalLetter.toLowerCase()}`).prop('readonly', true);
                                $(`#send-sell-${signalLetter.toLowerCase()}`).prop('disabled', true);

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
                                    didClose: () => {
                                        window.location.reload();
                                    }
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
                                    didClose: () => {
                                        window.location.reload();
                                    }
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
            const signalLetter = buttonId.replace('del-sell-', '').toUpperCase();

            // Dapatkan ID signal dari data-pair-id pada baris
            const signalId = $(this).closest('tr').data('pair-id');

            // Jika tidak ada signal ID, tampilkan pesan error
            if (!signalId) {
                Swal.fire({
                    text: 'Cannot find signal ID',
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

            // Konfirmasi penghapusan
            Swal.fire({
                title: 'Confirmation',
                text: `Are you sure you want to delete Sell ${signalLetter} signal?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Kirim data ke server
                    $.ajax({
                        url: '<?= BASE_URL ?>godmode/signal/deletesignal',
                        type: 'POST',
                        data: {
                            id_signal: signalId
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

                                // Reset nilai input
                                priceInput.val('');
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
                                    didClose: () => {
                                        window.location.reload();
                                    }
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
                                    didClose: () => {
                                        window.location.reload();
                                    }
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
    })
</script>