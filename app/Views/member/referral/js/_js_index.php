<script>
    $(document).ready(function() {

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
                    $('.custom-card:eq(0) .card-bottom').text(referral);
                    $('.custom-card:eq(1) .card-bottom').text('$ ' + formattedCommission);
                } else {
                    // Atur nilai default untuk kedua card
                    $('.custom-card:eq(0) .card-bottom').text("0");
                    $('.custom-card:eq(1) .card-bottom').text("$ 0");
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                // Atur nilai default jika terjadi error
                $('.custom-card:eq(0) .card-bottom').text("0");
                $('.custom-card:eq(1) .card-bottom').text("$ 0");
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
    });
</script>