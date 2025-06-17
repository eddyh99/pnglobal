<link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
<script>
    $("#expired").datepicker({
        minDate: 1,
        dateFormat: "yy-mm-dd"
    });

    $('#tbl_freemember').DataTable({
        "pageLength": 50,
        "dom": '<"d-flex justify-content-between align-items-center flex-wrap"lf>t<"d-flex justify-content-between align-items-center"ip>',
        "responsive": true,
        "order": false,
        "ajax": {
            "url": "<?= BASE_URL ?>godmode/course/user/get_mentor",
            "type": "GET",
            "dataSrc": function(data) {
                // Pastikan data.message ada dan merupakan array
                if (data.message && Array.isArray(data.message)) {
                    // Filter hanya baris-baris yang memiliki data pada properti wajib, misalnya 'email'
                    return data.message.filter(function(row) {
                        return row && row.email; // Bisa disesuaikan dengan properti lain yang wajib ada
                    });
                }
                return [];
            }
        },
        "columns": [{
                data: 'email',
            },
            {
                data: 'name',
                defaultContent: '-',
                className: 'text-center'
            },
            {
                data: 'status',
            },
            {
                data: null,
                "mRender": function(data, type, full, meta) {
                    const btndel = `<a href="<?= BASE_URL ?>godmode/course/user/deleteuser/mentor/${encodeURI(btoa(full.email))}" class="ml-3"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="22" viewBox="0 0 20 22" fill="none" onclick="return confirm('Are you sure you want to delete this mentor?')">
  <path d="M7.66675 11V16.5556" stroke="#B48B3D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
  <path d="M12.1111 11V16.5556" stroke="#B48B3D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
  <path d="M1 5.44446H18.7778" stroke="#B48B3D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
  <path d="M3.22217 8.77783V17.6667C3.22217 19.5077 4.71456 21.0001 6.5555 21.0001H13.2222C15.0632 21.0001 16.5555 19.5077 16.5555 17.6667V8.77783" stroke="#B48B3D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
  <path d="M6.55566 3.22222C6.55566 1.99492 7.55059 1 8.77789 1H11.0001C12.2274 1 13.2223 1.99492 13.2223 3.22222V5.44444H6.55566V3.22222Z" stroke="#B48B3D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
</svg></a>`

                    if (full.status != 'disabled') {
                        setStatus = `&nbsp;&nbsp;<a href="#" onclick="disableduser('` + full.email + `')"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="20" viewBox="0 0 18 20" fill="none">
  <path d="M12.5187 2.31456C15.7371 3.70972 18 6.97313 18 10.7944C18 15.8431 13.9638 20 9 20C4.06409 20 0 15.844 0 10.7944C0 6.97313 2.26374 3.70883 5.50926 2.31456V5.41105C3.818 6.58306 2.67303 8.53521 2.67303 10.7944C2.67303 14.3649 5.50926 17.2659 9 17.2659C12.4907 17.2659 15.327 14.3649 15.327 10.7944C15.327 8.53521 14.2091 6.58217 12.5178 5.41105L12.5187 2.31456ZM10.5001 10.7391V0H7.49986V10.7391H10.5001Z" fill="#F80D0D"/>
</svg></a>`
                    } else {
                        setStatus = `&nbsp;&nbsp;<a href="#" onclick="enableuser('` + full.email + `')"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="20" viewBox="0 0 18 20" fill="none">
  <path d="M12.5187 2.31456C15.7371 3.70972 18 6.97313 18 10.7944C18 15.8431 13.9638 20 9 20C4.06409 20 0 15.844 0 10.7944C0 6.97313 2.26374 3.70883 5.50926 2.31456V5.41105C3.818 6.58306 2.67303 8.53521 2.67303 10.7944C2.67303 14.3649 5.50926 17.2659 9 17.2659C12.4907 17.2659 15.327 14.3649 15.327 10.7944C15.327 8.53521 14.2091 6.58217 12.5178 5.41105L12.5187 2.31456ZM10.5001 10.7391V0H7.49986V10.7391H10.5001Z" fill="#0DB82D"/>
</svg>`
                    }
                    return setStatus + btndel;
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
            window.location.replace("<?= BASE_URL ?>godmode/course/user/setstatus_user/mentor/" + encodeURI(btoa(email)) + "/disabled");
        }
    }

    function enableuser(email) {
        if (confirm("Are you sure you want to activate this user?")) {
            window.location.replace("<?= BASE_URL ?>godmode/course/user/setstatus_user/mentor/" + encodeURI(btoa(email)) + "/active");
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