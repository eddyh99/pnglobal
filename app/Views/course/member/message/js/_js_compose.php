<style>
    .ck.ck-toolbar {
        background-color: #B48B3D;
    }

    .ck.ck-toolbar .ck-button {
        color: white !important;
    }

    .ck.ck-toolbar .ck-button svg {
        fill: white !important;
    }

    .ck.ck-editor__main .ck-editor__editable:focus {
        border: 2px solid #B48B3D !important;
        /* Border kuning */
        outline: none;
    }

    .ck-editor__editable_inline {
        font-size: 16px;
        font-family: Arial, sans-serif;
    }

    .ck.ck-editor__main>.ck-editor__editable {
        min-height: 350px;
        background-color: #000000;
        color: #B48B3D;
    }
</style>
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        ClassicEditor
            .create(document.querySelector('#editor'), {
                simpleUpload: {
                    uploadUrl: '/upload.php'
                }
            })
            .catch(error => {
                console.error(error);
            });
    });

    $('.subject').on('click', function() {
        $('.subject').removeClass('active');
        $(this).addClass('active');
    });
</script>