<script>
    $.ajax({
        url: "<?= BASE_URL ?>member/withdraw/available_commission",
        method: "POST",
        dataType: "json",
        success: function(response) {
            // Cek jika response berhasil dan memiliki properti message.balance
            if (response && response.code === 200 && response.message && typeof response.message.balance !== "undefined") {
                // Format angka: hilangkan koma desimal dan tambahkan pemisah ribuan
                var balance = parseFloat(response.message.balance);
                var formattedBalance = "$ " + balance.toLocaleString('en-US', {
                    maximumFractionDigits: 0
                });
                $(".custom-card.left-card .card-bottom").text(formattedBalance);
            } else {
                $(".custom-card.left-card .card-bottom").text("$ 0");
            }
        },
        error: function(xhr, status, error) {
            console.error("Error fetching available commission:", error);
            $(".custom-card.left-card .card-bottom").text("Error");
        }
    });

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
            url: '<?= BASE_URL ?>member/withdraw/get_withdraw_history',
            type: 'GET',
            dataSrc: function(response) {
                console.log(response);
                return response.message;
            }
        },
        columns: [{
            data: 'requested_at'
        }, {
            data: 'amount'
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
</script>