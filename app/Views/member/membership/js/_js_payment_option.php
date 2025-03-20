<script>
    $(document).ready(function() {
        // Menambahkan event listener untuk tombol yang dinonaktifkan
        $('.disabled-payment-btn').on('click', function(e) {
            e.preventDefault();
            // Opsional: Tambahkan notifikasi atau pesan jika diperlukan
            // alert('Fitur ini akan segera tersedia!');
        });
    });
</script>