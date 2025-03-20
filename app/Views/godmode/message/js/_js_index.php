<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            toolbar: [
                ['font', ['bold', 'italic', 'underline']],
            ],
            placeholder: "Message...",
        });

        $('#table_message').DataTable({
            "pageLength": 25,
            "scrollX": true,
            "order": false,
        });

    });

    $(document).on("click", ".edit-message", function(e) {
        e.preventDefault();
        let title = $(this).data("title");
        let message = $(this).closest("tr").find(".message-content").val();
        let msgid = $(this).closest("tr").find(".msgid").val();

        $("input[name='subject']").val(title);
        $("#summernote").summernote("code", message);
        $("#frm-message").attr("action", "<?= BASE_URL ?>godmode/message/editmessage/" + msgid);
    });
</script>