<script>
    $('.toggle-fav').on('click', function (e) {
        e.stopPropagation();
        const el = $(this);
        const id = el.data('id');
        const status = el.data('status');
        console.log(id);
        $.ajax({
            url: '<?=BASE_URL?>/course/message/updatestatus', 
            method: 'POST',
            data: { id: id, status: status },
            success: function (res) {
                if (res.success) {
                    location.reload();
                } else {
                    alert(res.message || 'Failed to update.');
                }
            },
            error: function () {
                alert('Server error.');
            }
        });
    });
</script>