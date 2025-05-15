<script>
    // Tab functionality
    $(document).ready(function() {
        console.log("Document ready, initializing tabs");

        // Default active tab
        let activeTab = localStorage.getItem('activeTabMsg') || 'pn-global';
        console.log("Active tab from localStorage:", activeTab);

        // Set active tab on load
        $('.tab-item[data-tab="' + activeTab + '"]').addClass('active').css({
            'background-color': '#BFA573',
            'color': '#000'
        });
        $('#' + activeTab).addClass('active').css('display', 'block');

        // Tab click handler
        $('.tab-item').click(function() {
            const tabId = $(this).data('tab');
            console.log("Tab clicked:", tabId);

            // Remove active class and reset styles from all tabs and contents
            $('.tab-item').removeClass('active').css({
                'background-color': '#444',
                'color': '#fff'
            });
            $('.tab-content').removeClass('active').css('display', 'none');

            // Add active class and styles to clicked tab and its content
            $(this).addClass('active').css({
                'background-color': '#BFA573',
                'color': '#000'
            });
            $('#' + tabId).addClass('active').css('display', 'block');

            // Save active tab to localStorage
            localStorage.setItem('activeTabMsg', tabId);
        });
    });
</script>
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

    .table-bordered {
        border: 3px solid #B48B3D;
        /* Mengatur warna border menjadi biru dan menebalkan */
        border-collapse: collapse;
    }

    .table-bordered td,
    .table-bordered th {
        border: 3px solid #B48B3D;
        /* Menebalkan border pada sel dan mengubah warnanya */
        padding: 10px;
    }

    .table-bordered td {
        border-left: none;
        /* Menghilangkan garis kiri pada setiap sel */
        border-right: none;
        /* Menghilangkan garis kanan pada setiap sel */
    }

    .table-bordered td:nth-child(2) {
        border-right: none;
        /* Menghilangkan garis kanan pada kolom kedua */
    }

    .table-bordered td:first-child {
        border-left: 3px solid #B48B3D;
        /* Menambahkan border kiri pada kolom pertama */
    }

    .table-bordered td:last-child {
        border-right: 3px solid #B48B3D;
        /* Menambahkan border kanan pada kolom terakhir */
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