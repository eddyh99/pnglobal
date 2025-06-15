<link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
<script>
    $("#expired").datepicker({
        minDate: 1,
        dateFormat: "yy-mm-dd"
    });

    $('#tbl_live').DataTable({
        "pageLength": 50,
        "scrollX": true,
        "order": false,
        "ajax": {
            "url": "<?= BASE_URL ?>course/mentor/live/get_schedule",
            "type": "GET",
            "dataSrc": function(data) {
                // Pastikan data.message ada dan merupakan array
                if (data.message && Array.isArray(data.message)) {
                    // Filter hanya baris-baris yang memiliki data pada properti wajib, misalnya 'email'
                    return data.message.filter(function(row) {
                        return row; // Bisa disesuaikan dengan properti lain yang wajib ada
                    });
                }
                return [];
            }
        },
        "columns": [{
                data: null,
                className: 'text-center',
                render: function(data, type, row, meta) {
                    return meta.row + 1;
                }
            },
            {
                data: 'title',
            },
            {
                data: 'start_date',
            },
            {
                data: 'mentor',
            },
            {
                data: null,
                "mRender": function(data, type, full, meta) {
                    const btnplay = `<a href="<?= BASE_URL ?>godmode/course/live/host?room_id=${full.roomid}" target="__blank"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="20" viewBox="0 0 30 20" fill="none">
  <path d="M27.64 1H2.44C1.64471 1 1 1.64471 1 2.44V17.56C1 18.3553 1.64471 19 2.44 19H27.64C28.4353 19 29.08 18.3553 29.08 17.56V2.44C29.08 1.64471 28.4353 1 27.64 1Z" fill="#B48B3D" stroke="#B48B3D" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
  <path d="M19.3602 10.0002L12.1602 5.84326V14.1571L19.3602 10.0002Z" fill="black" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
</svg></a>`;

                    const btnshow = `<a href="#" class="mx-2"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="18" viewBox="0 0 30 18" fill="none">
  <path d="M15 6.41581C16.4355 6.41581 17.6051 7.58594 17.6051 9.01932C17.6051 10.4527 16.4343 11.5854 15 11.5854C13.5657 11.5854 12.4323 10.4527 12.4323 9.01932C12.4323 7.58594 13.5657 6.41581 15 6.41581ZM15 0C23.5343 0 29.6883 8.00013 29.6883 8.00013C30.1039 8.52905 30.1039 9.47216 29.6883 9.99987C29.6883 9.99987 23.5331 18 15 18C6.46689 18 0.311745 9.99987 0.311745 9.99987C-0.103915 9.47095 -0.103915 8.52784 0.311745 8.00013C0.311745 8.00013 6.46689 0 15 0ZM15 15.4726C18.55 15.4726 21.4572 12.5672 21.4572 9.01932C21.4572 5.47149 18.55 2.56608 15 2.56608C11.45 2.56608 8.54277 5.47149 8.54277 9.01932C8.54277 12.5672 11.45 15.4726 15 15.4726Z" fill="#B48B3D"/>
</svg></a>`;

                    const btndel = `<a href="<?= BASE_URL ?>course/mentor/live/deletelive/${encodeURI(btoa(full.id))}"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="22" viewBox="0 0 20 22" fill="none" onclick="return confirm('Are you sure you want to delete this live?')">
  <path d="M7.66675 11V16.5556" stroke="#B48B3D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
  <path d="M12.1111 11V16.5556" stroke="#B48B3D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
  <path d="M1 5.44434H18.7778" stroke="#B48B3D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
  <path d="M3.22217 8.77783V17.6667C3.22217 19.5077 4.71456 21.0001 6.5555 21.0001H13.2222C15.0632 21.0001 16.5555 19.5077 16.5555 17.6667V8.77783" stroke="#B48B3D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
  <path d="M6.55566 3.22222C6.55566 1.99492 7.55059 1 8.77789 1H11.0001C12.2274 1 13.2223 1.99492 13.2223 3.22222V5.44444H6.55566V3.22222Z" stroke="#B48B3D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
</svg></a>`;

                    return btnplay + btnshow + btndel;
                },
            },
        ],
        language: {
            emptyTable: "No Data"
        }
    });

    $("#role").on('change', function() {
        $('#amount-wrapper').prop('hidden', $(this).val() != 'member');
    });

    function disableduser(email) {
        if (confirm("Are you sure you want to disabled this user?")) {
            window.location.replace("<?= BASE_URL ?>godmode/course/setstatus_user/" + encodeURI(btoa(email)) + "/disabled");
        }
    }

    function enableuser(email) {
        if (confirm("Are you sure you want to activate this user?")) {
            window.location.replace("<?= BASE_URL ?>godmode/course/setstatus_user/" + encodeURI(btoa(email)) + "/active");
        }
    }

    // Prevent double submission
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form[action="<?= BASE_URL ?>godmode/freemember/createfree"]');
        const submitBtn = document.getElementById('submitBtn');

        if (form && submitBtn) {
            form.addEventListener('submit', function() {
                // Disable the button
                submitBtn.disabled = true;

                // Change button text to show processing
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...';

                // Enable the button after 10 seconds (failsafe in case form submission fails)
                setTimeout(function() {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'Create';
                }, 10000);

                // Allow the form to submit
                return true;
            });
        }
    });
</script>