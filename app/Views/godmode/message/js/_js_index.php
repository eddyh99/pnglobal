<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            toolbar: [
                ['font', ['bold', 'italic', 'underline']],
            ],
            placeholder: "Message...",
        });

        $('#table_message').DataTable({
            pageLength: 50,
            "scrollX": true,
        });
    });
</script>