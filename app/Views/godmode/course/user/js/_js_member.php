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

                    const btnmsg = `<a href="<?=BASE_URL?>godmode/course/message?tab=compose&id=${encodeURI(btoa(full.email))}>" class="ml-3"><svg xmlns="http://www.w3.org/2000/svg" width="28" height="22" viewBox="0 0 28 22" fill="none">
  <path d="M1 5.28571L8.87211 10.4761C10.7254 11.698 11.6521 12.309 12.6535 12.5464C13.5386 12.7561 14.4614 12.7561 15.3465 12.5464C16.3479 12.309 17.2747 11.698 19.1279 10.4761L27 5.28571M5.62222 21H22.3778C23.9957 21 24.8047 21 25.4227 20.6886C25.9662 20.4147 26.4082 19.9776 26.6851 19.44C27 18.8289 27 18.0287 27 16.4286V5.57143C27 3.97129 27 3.1712 26.6851 2.56003C26.4082 2.02241 25.9662 1.58533 25.4227 1.31141C24.8047 1 23.9957 1 22.3778 1H5.62222C4.0043 1 3.19532 1 2.57736 1.31141C2.03377 1.58533 1.59183 2.02241 1.31487 2.56003C1 3.1712 1 3.97127 1 5.57143V16.4286C1 18.0287 1 18.8289 1.31487 19.44C1.59183 19.9776 2.03377 20.4147 2.57736 20.6886C3.19532 21 4.00429 21 5.62222 21Z" stroke="#B48B3D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
</svg></a>`

                    const btndetail = `<a href="<?=BASE_URL?>godmode/course/user/tradehistory"><svg fill="#b48b3d" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" 
	 width="28px" height="28px" viewBox="0 0 503.379 503.379"
	 xml:space="preserve">
<g>
	<path d="M458.091,128.116v326.842c0,26.698-21.723,48.421-48.422,48.421h-220.92c-26.699,0-48.421-21.723-48.421-48.421V242.439
		c6.907,1.149,13.953,1.894,21.184,1.894c5.128,0,10.161-0.381,15.132-0.969v211.594c0,6.673,5.429,12.104,12.105,12.104h220.92
		c6.674,0,12.105-5.432,12.105-12.104V128.116c0-6.676-5.432-12.105-12.105-12.105H289.835c0-12.625-1.897-24.793-5.297-36.315
		h125.131C436.368,79.695,458.091,101.417,458.091,128.116z M159.49,228.401c-62.973,0-114.202-51.229-114.202-114.199
		C45.289,51.229,96.517,0,159.49,0c62.971,0,114.202,51.229,114.202,114.202C273.692,177.172,222.461,228.401,159.49,228.401z
		 M159.49,204.19c49.618,0,89.989-40.364,89.989-89.988c0-49.627-40.365-89.991-89.989-89.991
		c-49.626,0-89.991,40.364-89.991,89.991C69.499,163.826,109.87,204.19,159.49,204.19z M227.981,126.308
		c6.682,0,12.105-5.423,12.105-12.105s-5.423-12.105-12.105-12.105h-56.386v-47.52c0-6.682-5.423-12.105-12.105-12.105
		s-12.105,5.423-12.105,12.105v59.625c0,6.682,5.423,12.105,12.105,12.105H227.981z M367.697,224.456h-131.14
		c-6.682,0-12.105,5.423-12.105,12.105c0,6.683,5.423,12.105,12.105,12.105h131.14c6.685,0,12.105-5.423,12.105-12.105
		C379.803,229.879,374.382,224.456,367.697,224.456z M367.91,297.885h-131.14c-6.682,0-12.105,5.42-12.105,12.105
		s5.423,12.105,12.105,12.105h131.14c6.685,0,12.104-5.42,12.104-12.105S374.601,297.885,367.91,297.885z M367.91,374.353h-131.14
		c-6.682,0-12.105,5.426-12.105,12.105c0,6.685,5.423,12.104,12.105,12.104h131.14c6.685,0,12.104-5.42,12.104-12.104
		C380.015,379.778,374.601,374.353,367.91,374.353z"/>
</g>
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