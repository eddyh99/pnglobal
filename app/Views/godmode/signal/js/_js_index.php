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
        updateBalances();
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
            let lastPendingSell = null;
            ['a', 'b', 'c', 'd'].forEach(letter => {
                const buyInput = $(`#buy-${letter}`);
                const buyValue = buyInput.val();
                const buyRow = buyInput.closest('tr');
                const buyStatus = buyRow.find('.signal-status').text().trim().toLowerCase();
                const sellInput = $(`#sell-${letter}`);
                const sellValue = sellInput.val();
                const sellRow = sellInput.closest('tr');
                const sellStatus = sellRow.find('.signal-status').text().trim().toLowerCase();
                const delBuyBtn = $(`#del-buy-${letter}`);
                const delSellBtn = $(`#del-sell-${letter}`);
                const sendSellBtn = $(`#send-sell-${letter}`);
                const buyStatusElement = buyRow.find('.signal-status');
                const sellStatusElement = sellRow.find('.signal-status');

                console.log(`Buy ${letter.toUpperCase()} status:`, buyStatus);
                console.log(`Buy ${letter.toUpperCase()} value:`, buyValue);
                console.log(`Sell ${letter.toUpperCase()} status:`, sellStatus);
                console.log(`Sell ${letter.toUpperCase()} value:`, sellValue);

                // Reset status jika price kosong
                if (!buyValue || buyValue === '') {
                    buyStatusElement.text('');
                }
                if (!sellValue || sellValue === '') {
                    sellStatusElement.text('');
                }

                // Atur tombol DEL BUY berdasarkan nilai input
                if (buyStatus != 'pending') {
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
                if (sellStatus == 'pending') {
                    // update btn sell pending
                    lastPendingSell = letter;
                }
                delSellBtn.prop('disabled', true).addClass('disabled-btn').css({
                    'border-color': '#6c757d',
                    'color': '#6c757d',
                    'cursor': 'not-allowed'
                });

                // Atur tombol FILL berdasarkan status dan price
                if (buyValue && buyStatus === 'filled') {
                    // Jika ada price dan status buy adalah filled, disable tombol FILL
                    $(`#fill-buy-${letter}`).prop('disabled', true).addClass('filled');
                } else if (buyValue && buyStatus === 'pending') {
                    // Jika ada price dan status buy adalah new, enable tombol FILL
                    $(`#fill-buy-${letter}`).prop('disabled', false).removeClass('filled');
                } else {
                    // Jika tidak ada price, disable tombol FILL
                    $(`#fill-buy-${letter}`).prop('disabled', true).removeClass('filled');
                }

                // Untuk sell, kita hanya mengatur tombol berdasarkan status yang ada dari server
                if (sellValue && sellStatus) {
                    if (sellStatus === 'filled') {
                        // Jika ada price dan status sell adalah filled, disable tombol FILL dan SELL
                        $(`#fill-sell-${letter}`).prop('disabled', true).addClass('filled');
                        sendSellBtn.prop('disabled', true);
                        sellInput.prop('readonly', true);
                    } else {
                        // Untuk status lainnya dan ada price, enable tombol FILL
                        $(`#fill-sell-${letter}`).prop('disabled', false).removeClass('filled');
                    }
                } else {
                    // Jika tidak ada price, disable tombol FILL
                    $(`#fill-sell-${letter}`).prop('disabled', true).removeClass('filled');
                }

                // Jika status buy masih new atau tidak ada price, disable tombol SELL
                if (buyStatus === 'pending' || !buyValue || sellStatus == 'pending') {
                    sellInput.prop('readonly', true);
                    sendSellBtn.prop('disabled', true).addClass('disabled-btn').css({
                        'border-color': '#6c757d',
                        'color': '#6c757d',
                        'cursor': 'not-allowed'
                    });
                } else if (buyValue && buyStatus === 'filled' && (!sellStatus || sellStatus !== 'filled')) {
                    // Jika ada price buy, status buy filled, dan sell belum filled, enable tombol SELL
                    sellInput.prop('readonly', false);
                    sendSellBtn.prop('disabled', false);
                }
            });

            // activate del sell btn
            if (lastPendingSell) {
                $(`#del-sell-${lastPendingSell}`).prop('disabled', false).removeClass('disabled-btn').css({
                    'border-color': '#f80d0d',
                    'color': '#ffffff',
                    'cursor': 'pointer'
                });
            }
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
            if (buyStatusA !== 'pending') {
                $('#sell-a').removeAttr('readonly');
                $('#send-sell-a').removeAttr('disabled');
            }
        }
        if ($('#buy-b').val() && $('#buy-b').prop('disabled')) {
            const buyStatusB = $('#buy-b').closest('tr').find('.signal-status').text().trim().toLowerCase();
            if (buyStatusB !== 'pending') {
                $('#sell-b').removeAttr('readonly');
                $('#send-sell-b').removeAttr('disabled');
            }
        }
        if ($('#buy-c').val() && $('#buy-c').prop('disabled')) {
            const buyStatusC = $('#buy-c').closest('tr').find('.signal-status').text().trim().toLowerCase();
            if (buyStatusC !== 'pending') {
                $('#sell-c').removeAttr('readonly');
                $('#send-sell-c').removeAttr('disabled');
            }
        }
        if ($('#buy-d').val() && $('#buy-d').prop('disabled')) {
            const buyStatusD = $('#buy-d').closest('tr').find('.signal-status').text().trim().toLowerCase();
            if (buyStatusD !== 'pending') {
                $('#sell-d').removeAttr('readonly');
                $('#send-sell-d').removeAttr('disabled');
            }
        }

        // Inisialisasi status tombol DEL saat halaman pertama kali dimuat
        ['a', 'b', 'c', 'd'].forEach(letter => {
            const buyInput = $(`#buy-${letter}`);
            const buyValue = buyInput.val();
            const delBtn = $(`#del-buy-${letter}`);
            const buyRow = buyInput.closest('tr');
            const buyStatus = buyRow.find('.signal-status').text().trim().toLowerCase();

            if (buyStatus == 'pending') {
                // Jika field kosong, disable tombol DEL dan ubah warna menjadi abu-abu
                delBtn.prop('disabled', false).removeClass('disabled-btn')
            } else {
                // Jika field sudah terisi, enable tombol DEL dan kembalikan warna merah
                delBtn.prop('disabled', true).addClass('disabled-btn');
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
                    let result = JSON.parse(ress);
                    console.log(result);


                    // Check if response success
                    if (result.code == '201') {
                        // Sweet Alert Success dengan warna hijau
                        Swal.fire({
                            toast: true,
                            title: 'Info order',
                            html: `<ul style="margin:0; padding-left:20px;">${result.message.map(msg => `<li>${msg}</li>`).join('')}</ul>`,
                            icon: 'warning',
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
                        // Sweet Alert Error dengan warna merah
                        Swal.fire({
                            toast: true,
                            icon: 'error',
                            title: 'Order Failed',
                            html: result.message.join('<br>'),
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 4000,
                            timerProgressBar: true,
                            background: '#FFE4DC',
                            color: '#000000'
                        });
                    }
                    removeButtonLoading(document.querySelector('#send-buy-a'));
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // Sweet Alert
                    Swal.fire({
                        text: 'Something went wrong!',
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
                        // Sweet Alert Success dengan warna hijau
                        Swal.fire({
                            text: `${result.message}`,
                            showCloseButton: true,
                            showConfirmButton: false,
                            background: '#E1FFF7', // Warna hijau muda untuk success
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
                        // Sweet Alert Error dengan warna merah
                        Swal.fire({
                            text: `${result.message}`,
                            showCloseButton: true,
                            showConfirmButton: false,
                            background: '#FFE4DC', // Warna merah muda untuk error
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
                        // Sweet Alert Success dengan warna hijau
                        Swal.fire({
                            text: `${result.message}`,
                            showCloseButton: true,
                            showConfirmButton: false,
                            background: '#E1FFF7', // Warna hijau muda untuk success
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
                        // Sweet Alert Error dengan warna merah
                        Swal.fire({
                            text: `${result.message}`,
                            showCloseButton: true,
                            showConfirmButton: false,
                            background: '#FFE4DC', // Warna merah muda untuk error
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
                        // Sweet Alert Success dengan warna hijau
                        Swal.fire({
                            text: `${result.message}`,
                            showCloseButton: true,
                            showConfirmButton: false,
                            background: '#E1FFF7', // Warna hijau muda untuk success
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
                        // Sweet Alert Error dengan warna merah
                        Swal.fire({
                            text: `${result.message}`,
                            showCloseButton: true,
                            showConfirmButton: false,
                            background: '#FFE4DC', // Warna merah muda untuk error
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
            "dom": '<"d-flex justify-content-between align-items-center flex-wrap"lf>t<"d-flex justify-content-between align-items-center"ip>',
            "responsive": true,
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
                    data: "status",
                },
                {
                    data: "admin",
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        let btnFill = '-';
                        const [orderType, orderSide] = data.type.split(' ');

                        if (data.status == 'pending') {
                            switch (orderType) {
                                case 'Buy':
                                    btnFill = `<button class="btn btn-primary" onclick="fillBuy('${orderSide}', '${data.status}', ${data.id})"><b>F</b></button>`;
                                    break;
                                case 'Sell':
                                    btnFill = `<button class="btn btn-primary" onclick="fillSell('${orderSide}', '${data.status}')"><b>F</b></button>`;
                                    break;
                            }
                        }
                        return btnFill;
                    }
                }
            ],

        });

        // Event handler untuk tombol cancel
        $('#table_message').on('click', '.cancel-signal', function() {
            const signalId = $(this).data('id');

            // Konfirmasi sebelum cancel
            Swal.fire({
                title: 'Confirmation',
                text: 'Are you sure you want to cancel this signal?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, cancel it!',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect ke endpoint cancel_sell dengan parameter yang diperlukan
                    window.location.href = '<?= BASE_URL ?>godmode/signal/cancel_sell?id=' + signalId;
                }
            });
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
            if (currentStatus !== 'pending' && currentStatus !== 'pending') {
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

                                // Sweet Alert Success dengan warna hijau
                                Swal.fire({
                                    text: `${result.message}`,
                                    showCloseButton: true,
                                    showConfirmButton: false,
                                    background: '#E1FFF7', // Warna hijau muda untuk success
                                    color: '#000000',
                                    position: 'top-end',
                                    timer: 3000,
                                    timerProgressBar: true,
                                    didClose: () => {
                                        window.location.reload();
                                    }
                                });
                            } else {
                                // Sweet Alert Error dengan warna merah
                                Swal.fire({
                                    text: `${result.message}`,
                                    showCloseButton: true,
                                    showConfirmButton: false,
                                    background: '#FFE4DC', // Warna merah muda untuk error
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

            // Data yang akan dikirim ke server
            const sendData = {
                price: price,
                type: signalType,
                pair_id: pairId
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
                            if (result.code == '200' || result.code == '201' || result.code == 200 || result.code == 201) {
                                // Update UI berdasarkan response dari server
                                if (result.status) {
                                    statusElement.text(result.status);
                                }

                                // Update tombol dan input berdasarkan response
                                priceInput.prop('readonly', true);
                                $(`#${buttonId}`).prop('disabled', true);

                                // Sweet Alert Success dengan warna hijau
                                Swal.fire({
                                    text: `${result.message}`,
                                    showCloseButton: true,
                                    showConfirmButton: false,
                                    background: '#E1FFF7', // Warna hijau muda untuk success
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
                                // Sweet Alert Error dengan warna merah
                                Swal.fire({
                                    text: `${result.message}`,
                                    showCloseButton: true,
                                    showConfirmButton: false,
                                    background: '#FFE4DC', // Warna merah muda untuk error
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
                } else {
                    removeButtonLoading(this);
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
                } else {
                    removeButtonLoading(this);
                }
            });
        });

        function updateBalances() {

            $.ajax({
                url: '<?= BASE_URL ?>godmode/signal/getmember_balance', // Ganti dengan endpoint sesuai back-end kamu
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    let usdt = parseFloat(response.trade_usdt);
                    $('#usdt_balance').text(
                        !isNaN(usdt) ? usdt.toFixed(2) : '0.00'
                    );

                    $('#btc_balance').text(response.trade_btc);

                },
                error: function(xhr, status, error) {
                    console.error("Gagal mengambil data balance:", error);
                    $('#fund_balance').text('Error');
                    $('#trade_balance').text('Error');
                }
            });
        }
    })

    function fillBuy(type, status, idsignal) {
        if (status == 'pending' && idsignal) {
            const buyPrice = $(`#buy-${type.toLowerCase()}`).val();
            const buyType = type.toUpperCase();
            Swal.fire({
                title: 'Confirmation',
                text: `Are you sure you want to fill BUY ${buyType} at price ${buyPrice}?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, fill it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Data yang akan dikirim ke server
                    const sendData = {
                        price: buyPrice,
                        type: 'BUY ' + buyType,
                        idsignal: idsignal
                    };

                    $.ajax({
                        url: '<?= BASE_URL ?>godmode/signal/fillbuy',
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
                            if (result.code == '200' || result.code == '201' || result.code == 200 || result.code == 201) {
                                // Sweet Alert Success dengan warna hijau
                                Swal.fire({
                                    text: `${result.message}`,
                                    showCloseButton: true,
                                    showConfirmButton: false,
                                    background: '#E1FFF7', // Warna hijau muda untuk success
                                    color: '#000000',
                                    position: 'top-end',
                                    timer: 3000,
                                    timerProgressBar: true,
                                    didClose: () => {
                                        window.location.reload();
                                    }
                                });
                            } else {
                                // Sweet Alert Error dengan warna merah
                                Swal.fire({
                                    toast: true,
                                    icon: 'error',
                                    title: 'Order Failed',
                                    html: result.message.join('<br>'),
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 4000,
                                    timerProgressBar: true,
                                    background: '#FFE4DC',
                                    color: '#000000'
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
            })
        }
    }

    function fillSell(type, status) {
        if (status == 'pending') {
            const sellPrice = $(`#sell-${type.toLowerCase()}`).val();
            const sellType = type.toUpperCase();
            Swal.fire({
                title: 'Confirmation',
                text: `Are you sure you want to fill SELL ${sellType} at price ${sellPrice}?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, fill it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Data yang akan dikirim ke server
                    const sendData = {
                        type: 'SELL ' + sellType,
                    };

                    $.ajax({
                        url: '<?= BASE_URL ?>godmode/signal/fillsell',
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
                            if (result.code == '200' || result.code == '201' || result.code == 200 || result.code == 201) {
                                // Sweet Alert Success dengan warna hijau
                                Swal.fire({
                                    text: `${result.message}`,
                                    showCloseButton: true,
                                    showConfirmButton: false,
                                    background: '#E1FFF7', // Warna hijau muda untuk success
                                    color: '#000000',
                                    position: 'top-end',
                                    timer: 3000,
                                    timerProgressBar: true,
                                    didClose: () => {
                                        window.location.reload();
                                    }
                                });
                            } else {
                                // Sweet Alert Error dengan warna merah
                                Swal.fire({
                                    toast: true,
                                    icon: 'error',
                                    title: 'Order Failed',
                                    html: result.message.join('<br>'),
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 4000,
                                    timerProgressBar: true,
                                    background: '#FFE4DC',
                                    color: '#000000'
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
            })
        }
    }
</script>