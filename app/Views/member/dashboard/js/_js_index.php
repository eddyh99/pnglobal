<script>
    $(document).ready(function() {
        $('.warning-days').each(function() {
            var days = $(this).text();
            if (days < 5) {
                $(this).addClass('blink');
            }
        });

        // Inisialisasi DataTable untuk tabel total member
        var tableTotalMember = $('#table_totalmember').DataTable({
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
                url: '<?= BASE_URL ?>member/dashboard/get_membership_history',
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
                    data: 'start_date',
                    render: function(data) {
                        // Format tanggal jika diperlukan
                        if (!data) return 'N/A';
                        // Asumsi format tanggal dari API adalah ISO format
                        var date = new Date(data);
                        return date.toLocaleDateString('en-GB'); // Format: DD/MM/YYYY
                    }
                },
                {
                    data: 'initial_capital',
                    render: function(data) {
                        // Format angka dengan $ dan koma
                        if (!data) return '0';
                        return parseFloat(data).toLocaleString('en-US');
                    }
                },
                {
                    data: 'amount_paid',
                    render: function(data) {
                        // Format angka dengan € dan koma
                        if (!data) return '0';
                        return '€ ' + parseFloat(data).toLocaleString('en-US');
                    }
                },
                {
                    data: 'status',
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
        $('.referral-qr p').on('click', function() {
            var qrDiv = $('.qr-code-container');
            var buttonPosition = $(this).offset(); // Get the position of the clicked button
            var buttonWidth = $(this).outerWidth(); // Get the width of the button
            var qrContainerWidth = 200; // Approximate width of the QR code container (adjust as needed)
            var additionalOffset = 20; // Additional downward offset in pixels (adjust as needed)

            if (qrDiv.length === 0) {
                qrDiv = $('<div class="qr-code-container" style="position: absolute; top: ' + (buttonPosition.top + $(this).outerHeight() + additionalOffset) + 'px; left: ' + (buttonPosition.left + buttonWidth - qrContainerWidth) + 'px; background: #fff; padding: 20px; border: 1px solid #000; z-index: 10000; width: ' + qrContainerWidth + 'px;"></div>');
                var qrImg = $('<img>').attr('src', 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=' + encodeURIComponent(referralLink));
                var closeBtn = $('<button style="display:block; margin-top:10px;">Close</button>');
                closeBtn.on('click', function() {
                    qrDiv.remove();
                });
                qrDiv.append(qrImg).append(closeBtn);
                $('body').append(qrDiv);
            } else {
                qrDiv.toggle();
            }
        });
    });
</script>