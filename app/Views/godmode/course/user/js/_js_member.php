<link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
<script>
    $("#expired").datepicker({
        minDate: 1,
        dateFormat: "yy-mm-dd"
    });

    $('#tbl_freemember').DataTable({
        "pageLength": 50,
        "scrollX": true,
        "order": false,
        "ajax": {
            "url": "<?= BASE_URL ?>godmode/course/user/get_member",
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
                data: 'status',
            },
            {
                data: 'name',
            },
            {
                data: 'material_exam',
            },
            {
                data: 'demo_trade',
            },
            {
                data: null,
                "mRender": function(data, type, full, meta) {
                    const btndel = `<a href="<?= BASE_URL ?>godmode/course/user/deleteuser/member/${encodeURI(btoa(full.email))}" class="ml-3"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="22" viewBox="0 0 20 22" fill="none" onclick="return confirm('Are you sure you want to delete this member?')">
  <path d="M7.66675 11V16.5556" stroke="#B48B3D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
  <path d="M12.1111 11V16.5556" stroke="#B48B3D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
  <path d="M1 5.44446H18.7778" stroke="#B48B3D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
  <path d="M3.22217 8.77783V17.6667C3.22217 19.5077 4.71456 21.0001 6.5555 21.0001H13.2222C15.0632 21.0001 16.5555 19.5077 16.5555 17.6667V8.77783" stroke="#B48B3D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
  <path d="M6.55566 3.22222C6.55566 1.99492 7.55059 1 8.77789 1H11.0001C12.2274 1 13.2223 1.99492 13.2223 3.22222V5.44444H6.55566V3.22222Z" stroke="#B48B3D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
</svg></a>`

                    const btnmsg = `<a href="#" class="ml-3"><svg xmlns="http://www.w3.org/2000/svg" width="28" height="22" viewBox="0 0 28 22" fill="none">
  <path d="M1 5.28571L8.87211 10.4761C10.7254 11.698 11.6521 12.309 12.6535 12.5464C13.5386 12.7561 14.4614 12.7561 15.3465 12.5464C16.3479 12.309 17.2747 11.698 19.1279 10.4761L27 5.28571M5.62222 21H22.3778C23.9957 21 24.8047 21 25.4227 20.6886C25.9662 20.4147 26.4082 19.9776 26.6851 19.44C27 18.8289 27 18.0287 27 16.4286V5.57143C27 3.97129 27 3.1712 26.6851 2.56003C26.4082 2.02241 25.9662 1.58533 25.4227 1.31141C24.8047 1 23.9957 1 22.3778 1H5.62222C4.0043 1 3.19532 1 2.57736 1.31141C2.03377 1.58533 1.59183 2.02241 1.31487 2.56003C1 3.1712 1 3.97127 1 5.57143V16.4286C1 18.0287 1 18.8289 1.31487 19.44C1.59183 19.9776 2.03377 20.4147 2.57736 20.6886C3.19532 21 4.00429 21 5.62222 21Z" stroke="#B48B3D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
</svg></a>`

                    const btndetail = `<a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="22" viewBox="0 0 18 22" fill="none">
  <path d="M1 18.7778V4.55556C1 3.311 1 2.68871 1.24913 2.21336C1.46826 1.79521 1.81793 1.45526 2.24802 1.24221C2.73696 1 3.37703 1 4.65714 1H13.3429C14.623 1 15.2631 1 15.752 1.24221C16.1821 1.45526 16.5318 1.79521 16.7509 2.21336C17 2.68871 17 3.311 17 4.55556V16.5556H3.28571C2.02335 16.5556 1 17.5504 1 18.7778ZM1 18.7778C1 20.0051 2.02335 21 3.28571 21H17M15.8571 16.5556V21M12.4286 12.6667C12.1045 11.3988 10.6926 10.4444 9 10.4444C7.30743 10.4444 5.89559 11.3988 5.57143 12.6667M9 6H9.01143M10.1429 6C10.1429 6.61364 9.6312 7.11111 9 7.11111C8.3688 7.11111 7.85714 6.61364 7.85714 6C7.85714 5.38636 8.3688 4.88889 9 4.88889C9.6312 4.88889 10.1429 5.38636 10.1429 6Z" stroke="#B48B3D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
</a>`

                    if (full.status != 'disabled') {
                        setStatus = `&nbsp;&nbsp;<a href="#" onclick="disableduser('` + full.email + `')"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="20" viewBox="0 0 18 20" fill="none">
  <path d="M12.5187 2.31456C15.7371 3.70972 18 6.97313 18 10.7944C18 15.8431 13.9638 20 9 20C4.06409 20 0 15.844 0 10.7944C0 6.97313 2.26374 3.70883 5.50926 2.31456V5.41105C3.818 6.58306 2.67303 8.53521 2.67303 10.7944C2.67303 14.3649 5.50926 17.2659 9 17.2659C12.4907 17.2659 15.327 14.3649 15.327 10.7944C15.327 8.53521 14.2091 6.58217 12.5178 5.41105L12.5187 2.31456ZM10.5001 10.7391V0H7.49986V10.7391H10.5001Z" fill="#F80D0D"/>
</svg></a>`
                    } else {
                        setStatus = `&nbsp;&nbsp;<a href="#" onclick="enableuser('` + full.email + `')"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="20" viewBox="0 0 18 20" fill="none">
  <path d="M12.5187 2.31456C15.7371 3.70972 18 6.97313 18 10.7944C18 15.8431 13.9638 20 9 20C4.06409 20 0 15.844 0 10.7944C0 6.97313 2.26374 3.70883 5.50926 2.31456V5.41105C3.818 6.58306 2.67303 8.53521 2.67303 10.7944C2.67303 14.3649 5.50926 17.2659 9 17.2659C12.4907 17.2659 15.327 14.3649 15.327 10.7944C15.327 8.53521 14.2091 6.58217 12.5178 5.41105L12.5187 2.31456ZM10.5001 10.7391V0H7.49986V10.7391H10.5001Z" fill="#0DB82D"/>
</svg>`
                    }
                    return btndetail + btnmsg + setStatus + btndel;
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
            window.location.replace("<?= BASE_URL ?>godmode/course/user/setstatus_user/member/" + encodeURI(btoa(email)) + "/disabled");
        }
    }

    function enableuser(email) {
        if (confirm("Are you sure you want to activate this user?")) {
            window.location.replace("<?= BASE_URL ?>godmode/course/user/setstatus_user/member/" + encodeURI(btoa(email)) + "/active");
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