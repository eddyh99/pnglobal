<style>
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
    
    .btn-withdraw{
        display: inline-block;
        flex: 1;     
        border-radius: 10px;
        border: 2px solid #b48b3d;
        background: linear-gradient(107deg, #b48b3d 50.42%, #bfa573 100%);
        color: #000;
        font-family: 'Poppins', sans-serif;
        font-size: 20px;
        font-weight: 600;
        line-height: normal;
        text-align: center;
        padding: 10px 20px;
        cursor: pointer;
        max-width:200px;
    }

    .btn-withdraw:hover {
        color: #000 !important;
    }    
</style>
<script>
    $(document).ready(function() {
        $('.warning-days').each(function() {
            var days = $(this).text();
            if (days < 5) {
                $(this).addClass('blink');
            }
        });

        // Inisialisasi DataTable untuk tabel total member
        var tableTotalMember = $('#table_tradehistory').DataTable({
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
            language: {
                // processing: 'Loading data...',
                search: 'Search:',
                lengthMenu: 'Show _MENU_ entries',
                info: 'Showing _START_ to _END_ of _TOTAL_ entries',
                infoEmpty: 'Showing 0 to 0 of 0 entries',
                infoFiltered: '(filtered from _MAX_ total entries)',
                zeroRecords: 'No matching records found',
                emptyTable: 'No data available in table',
                paginate: {
                    first: 'First',
                    previous: 'Previous',
                    next: 'Next',
                    last: 'Last'
                }
            },
            ajax: {
                url: '<?= BASE_URL ?>elite/dashboard/get_trade_history',
                type: 'GET',
                dataSrc: function(response) {
                    console.log('API Response:', response);
                    if (response.status) {
                        // Pastikan data yang diterima adalah array
                        if (Array.isArray(response.message)) {
                            return response.message;
                        } else if (typeof response.message === 'object') {
                            // Jika data adalah objek, konversi ke array
                            return Object.values(response.message);
                        } else {
                            console.error('Invalid data format:', response.message);
                            return [];
                        }
                    } else {
                        console.error('Error fetching data:', response.message);
                        return [];
                    }
                }
            },
            columns: [{
                    data: 'date',
                    render: function(data) {
                        // Format tanggal jika diperlukan
                        if (!data) return 'N/A';
                        // Asumsi format tanggal dari API adalah ISO format
                        var date = new Date(data);
                        return date.toLocaleDateString('en-GB'); // Format: DD/MM/YYYY
                    }
                },
                {
                    data: 'usdt',
                    render: function(data) {
                        // Format angka dengan $ dan koma
                        if (!data) return '0';
                        return parseFloat(data).toLocaleString('en-US');
                    }
                },
                {
                    data: 'entry_price',
                    render: function(data) {
                        // Format angka dengan € dan koma
                        if (!data) return '0';
                        return parseFloat(data).toLocaleString('en-US');
                    }
                },
                {
                    data: 'amount_btc',
                },
                {
                    data: 'position',
                    className: 'text-uppercase'
                }
            ],
            // Tambahkan error handling untuk AJAX request
            error: function(xhr, error, thrown) {
                console.error('DataTables error:', error, thrown);
                $('#table_totalmember').html('<div class="alert alert-danger">Error loading data from API. Please try again later.</div>');
            },
            // Tambahkan callback ketika data selesai dimuat
            initComplete: function() {
                console.log('DataTable initialization complete');
            }
        });

        // Refresh data setiap 60 detik
        setInterval(function() {
            tableTotalMember.ajax.reload(null, false);
        }, 60000);

        // Handle tombol Renew
        $('.btn-renew').on('click', function() {
            // Tampilkan konfirmasi
            if (confirm('Are you sure you want to renew your membership?')) {
                // Tampilkan loading indicator
                $(this).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...');
                $(this).prop('disabled', true);
                // Redirect ke halaman set_investment_capital
                window.location.href = '<?= BASE_URL ?>member/membership/set_investment_capital';
            }
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