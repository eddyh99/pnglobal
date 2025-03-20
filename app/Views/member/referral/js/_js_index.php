<style>
    .custom-card {
        transition: all 0.3s ease;
        cursor: pointer;
        border-radius: 10px;
        border: 2px solid #FAFAFA;
        background: linear-gradient(107deg, #737373 50.42%, #D2D1CE 100%);
    }

    .custom-card:hover:not(.active-card) {
        box-shadow: 0 0 15px rgba(180, 139, 61, 0.3);
    }

    .active-card,
    .custom-card.active-card {
        border-radius: 10px;
        border: 2px solid #B48B3D;
        background: linear-gradient(107deg, #B48B3D 50.42%, #BFA573 100%);
        box-shadow: 0 0 15px rgba(180, 139, 61, 0.5);
    }

    /* Menyesuaikan warna teks untuk card yang aktif */
    .active-card .card-row,
    .custom-card.active-card .card-row {
        color: white;
    }

    .qr-code-container {
        position: fixed;
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        z-index: 10000;
        width: 200px;
        left: 52.5% !important;
        /* Override posisi left yang diberikan melalui JavaScript */
        transform: translateX(-50%);
        /* Memastikan QR code berada di tengah */
    }

    .qr-code-container button {
        background-color: #B48B3D;
        color: white;
        border: none;
        padding: 5px 10px;
        border-radius: 4px;
        cursor: pointer;
    }

    /* Container untuk referral link dan QR code */
    .referral-section {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
    }

    .referral-link-container {
        width: 50%;
    }

    .qr-code-section {
        width: 50%;
        text-align: right;
    }
</style>

<script>
    $(document).ready(function() {
        // Set tabel aktif secara default (referral)
        var activeTable = 'referral';

        // Aktifkan card referral secara default
        $('#card-referral').addClass('active-card');

        // Tambahkan style untuk card yang aktif
        function updateActiveCardStyle() {
            // Hapus semua kelas active-card terlebih dahulu
            $('.custom-card').removeClass('active-card');

            // Tambahkan kelas active-card ke card yang aktif
            if (activeTable === 'referral') {
                $('#card-referral').addClass('active-card');
            } else {
                $('#card-commission').addClass('active-card');
            }
        }

        // Fungsi untuk mengganti tabel yang ditampilkan
        function switchTable(table) {
            activeTable = table;

            if (table === 'referral') {
                $('#referral-content').show();
                $('#commission-content').hide();

                // Refresh DataTable jika sudah diinisialisasi
                if ($.fn.dataTable.isDataTable('#table_referral')) {
                    $('#table_referral').DataTable().ajax.reload();
                }
            } else {
                $('#commission-content').show();
                $('#referral-content').hide();

                // Refresh DataTable jika sudah diinisialisasi
                if ($.fn.dataTable.isDataTable('#table_commission')) {
                    $('#table_commission').DataTable().ajax.reload();
                }
            }

            // Perbarui style card yang aktif
            updateActiveCardStyle();
        }

        // Tambahkan event listener untuk card Total Referral
        $('#card-referral').on('click', function() {
            switchTable('referral');
        });

        // Tambahkan event listener untuk card Commission
        $('#card-commission').on('click', function() {
            switchTable('commission');
        });

        // Tambahkan styling untuk card yang bisa diklik
        $('.custom-card').css('cursor', 'pointer');

        // Set card aktif secara default
        updateActiveCardStyle();

        $.ajax({
            url: '<?= BASE_URL ?>member/referral/get_summary',
            type: 'POST',
            dataType: 'json',
            success: function(response) {
                // Cek jika response berhasil dan memiliki properti message.balance
                if (response && response.status && response.message && typeof response.message.referral !== "undefined" && typeof response.message.commission !== "undefined") {
                    // Format angka: hilangkan koma desimal dan tambahkan pemisah ribuan

                    console.log(response.message);
                    var referral = response.message.referral;
                    var commission = response.message.commission;

                    // Pastikan commission adalah angka
                    commission = parseFloat(commission);

                    // Format angka tanpa desimal
                    var formattedCommission = Math.floor(commission).toLocaleString('en-US');

                    // Gunakan selector yang lebih spesifik untuk masing-masing card
                    $('#card-referral .card-bottom').text(referral);
                    $('#card-commission .card-bottom').text('$ ' + formattedCommission);
                } else {
                    // Atur nilai default untuk kedua card
                    $('#card-referral .card-bottom').text("0");
                    $('#card-commission .card-bottom').text("$ 0");
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                // Atur nilai default jika terjadi error
                $('#card-referral .card-bottom').text("0");
                $('#card-commission .card-bottom').text("$ 0");
            }
        });

        var tableReferral = $('#table_referral').DataTable({
            // processing: true,
            serverSide: false,
            responsive: true,
            paging: true,
            searching: true,
            ordering: true,
            info: true,
            lengthChange: true,
            pageLength: 10,
            lengthMenu: [10, 25, 50, 100],
            ajax: {
                url: '<?= BASE_URL ?>member/referral/get_referral',
                type: 'GET',
                dataSrc: function(response) {
                    console.log('API Response:', response);
                    if (response.status) {
                        return response.message;
                    } else {
                        console.error('Error fetching data:', response.message);
                        return [];
                    }
                }
            },
            columns: [{
                    data: 'email'
                },
                {
                    data: 'status'
                },
                {
                    data: 'subscription'
                }
            ]
        });

        // Inisialisasi tabel Commission
        var tableCommission = $('#table_commission').DataTable({
            serverSide: false,
            responsive: true,
            paging: true,
            searching: true,
            ordering: true,
            info: true,
            lengthChange: true,
            pageLength: 10,
            lengthMenu: [10, 25, 50, 100],
            ajax: {
                url: '<?= BASE_URL ?>member/referral/get_referral',
                type: 'GET',
                dataSrc: function(response) {
                    console.log('Commission API Response:', response);
                    if (response.status) {
                        return response.message;
                    } else {
                        console.error('Error fetching commission data:', response.message);
                        return [];
                    }
                }
            },
            columns: [{
                    data: 'date'
                },
                {
                    data: 'amount',
                    render: function(data, type, row) {
                        // Format jumlah dengan $ dan pemisah ribuan
                        return '$ ' + parseFloat(data).toLocaleString('en-US');
                    }
                },
                {
                    data: 'status'
                }
            ]
        });

        // NEW FEATURE: Tambahkan fungsi untuk icon share, icon copy, dan Show QR Code
        var referralLink = $('.referral-link a').attr('href');

        // Event listener untuk icon share (svg pertama di .referral-qr)
        $('.referral-qr svg').eq(0).on('click', function() {
            if (navigator.share) {
                navigator.share({
                    title: 'Referral Link',
                    url: referralLink
                }).then(function() {
                    console.log('Referral link shared successfully');
                }).catch(function(error) {
                    console.error('Error sharing referral link:', error);
                });
            } else {
                alert('Your browser does not support the Share feature.');
            }
        });

        // Event listener untuk icon copy (svg kedua di .referral-qr)
        $('.referral-qr svg').eq(1).on('click', function() {
            navigator.clipboard.writeText(referralLink).then(function() {
                alert('Referral link copied to clipboard!');
            }).catch(function(err) {
                alert('Failed to copy referral link.');
            });
        });

        // Event listener untuk teks 'Show QR Code' (p element di .referral-qr)
        $('.referral-qr p').on('click', function() {
            var qrDiv = $('.qr-code-container');
            var buttonPosition = $(this).offset(); // Get the position of the clicked button
            var buttonWidth = $(this).outerWidth(); // Get the width of the button
            var qrContainerWidth = 200; // Pertahankan lebar QR code container yang asli
            var additionalOffset = 20; // Additional downward offset in pixels (adjust as needed)
            var rightShift = 30; // Jarak tambahan ke kanan (dalam pixel)

            if (qrDiv.length === 0) {
                qrDiv = $('<div class="qr-code-container" style="position: fixed; top: ' + (buttonPosition.top + $(this).outerHeight() + additionalOffset) + 'px; left: ' + (buttonPosition.left + buttonWidth + rightShift - qrContainerWidth) + 'px; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); z-index: 10000; width: ' + qrContainerWidth + 'px;"></div>');

                // QR Code image dengan ukuran yang sama
                var qrImg = $('<img style="display: block; margin: 0 auto; width: 150px; height: 150px;">').attr('src', 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=' + encodeURIComponent(referralLink));

                // Tombol yang lebih menarik
                var closeBtn = $('<button style="display: block; margin: 10px auto 0; padding: 6px 15px; background-color: #c9a95b; color: #000; border: none; border-radius: 4px; cursor: pointer; width: 80px;">Close</button>');

                closeBtn.on('click', function() {
                    qrDiv.remove();
                });

                qrDiv.append(qrImg).append(closeBtn);
                $('body').append(qrDiv);
            } else {
                qrDiv.toggle();
            }

            // Mengatur posisi setelah element ditambahkan ke DOM
            qrDiv.css({
                'top': buttonPosition.top + $(this).outerHeight() + 30, // Mengubah offset top menjadi 30px
                'left': buttonPosition.left + $(this).outerWidth() - qrDiv.outerWidth()
            });
        });
    });
</script>