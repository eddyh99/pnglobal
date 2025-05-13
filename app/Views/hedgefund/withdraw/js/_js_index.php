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
</style>
<script>

    var tableWithdraw = $('#table_withdraw').DataTable({
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
            url: '<?= BASE_URL ?>hedgefund/withdraw/get_withdraw_history',
            type: 'GET',
            dataSrc: function(response) {
                console.log(response);
                return response.message;
            }
        },
        columns: [{
            data: 'description'
        },{
            data: 'date'
        }, {
            data: 'amount'
        }, {
            data: 'wallet_address'
        }, {
            data: 'status'
        }],
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
</script>