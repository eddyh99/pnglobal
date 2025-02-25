<script>
    $.ajax({
        url: "<?= BASE_URL ?>v1/withdraw/request_payment",
        method: "GET",
        dataType: "json",
        success: function(data) {
            if (data.commission) {
                $('.custom-card.left-card .card-bottom').text('$' + data.commission);
            } else {
                $('.custom-card.left-card .card-bottom').text('$0');
            }
        },
        error: function(error) {
            console.error("Error fetching commission:", error);
            $('.custom-card.left-card .card-bottom').text('Error');
        }
    });
</script>