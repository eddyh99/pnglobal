<link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
<style>
    /* Change the calendar header (month and year) background and text color */
    .ui-datepicker .ui-datepicker-header {
        background: #555;
        /* Dark grey background */
        color: #fff;
        /* White text color */
        border: none;
        /* Remove default borders if desired */
    }

    /* Optional: Change the navigation arrows color */
    .ui-datepicker .ui-datepicker-prev,
    .ui-datepicker .ui-datepicker-next {
        color: #fff;
        /* White color for arrows */
    }

    .ui-datepicker .ui-datepicker-prev span,
    .ui-datepicker .ui-datepicker-next span {
        background-color: #777;
        /* Slightly lighter grey for arrows */
        border-radius: 50%;
    }
</style>
<script>
    const container = document.getElementById('product-container');
    const template = document.getElementById('product-template').innerHTML;

    addNewProduct();
    // Deteksi timezone pengguna
    var userTimeZone = Intl.DateTimeFormat().resolvedOptions().timeZone;

    // Pastikan elemen timezone ada sebelum mencoba mengatur nilainya
    var timezoneElement = document.getElementById("timezone");
    if (timezoneElement) {
        // Pastikan tidak ada karakter yang perlu di-escape
        timezoneElement.value = userTimeZone;
    } else {
        console.error("Elemen timezone tidak ditemukan");
        // Tambahkan input timezone tersembunyi jika tidak ada
        var hiddenTimezone = document.createElement('input');
        hiddenTimezone.type = 'hidden';
        hiddenTimezone.id = 'timezone';
        hiddenTimezone.name = 'timezone';
        hiddenTimezone.value = userTimeZone;
        var form = document.querySelector('form[action="<?= BASE_URL ?>godmode/admin/create_admin"]');
        if (form) {
            form.appendChild(hiddenTimezone);
        } else {
            console.error("Form tidak ditemukan");
        }
    }

    // Menangani form submission untuk memastikan access dikirim sebagai array
    $('form[action="<?= BASE_URL ?>godmode/admin/create_admin"]').on('submit', function(e) {
        // Periksa apakah setidaknya satu checkbox dipilih
        if ($('input[name="access[]"]:checked').length === 0) {
            e.preventDefault();
            alert("Pilih setidaknya satu akses untuk admin.");
            return false;
        }

        // Modifikasi timezone sebelum submit untuk menghindari escape karakter
        // var tzInput = document.getElementById('timezone');
        // if (tzInput) {
        //     // Ganti karakter / dengan karakter lain yang tidak perlu di-escape
        //     tzInput.value = tzInput.value.replace(/\//g, '|');
        // }
    });

    const formx = document.querySelector('form[action="<?= BASE_URL ?>godmode/admin/create_admin"]');
    const submitBtn = document.getElementById('submitBtn');
    if (formx && submitBtn) {
        formx.addEventListener('submit', function() {
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


    function updateAccessOptions(selectElement) {
        const accessWrapper = selectElement.closest('.product-group').querySelector('.role-wrapper');
        accessWrapper.innerHTML = ''; // kosongkan dulu

        const selectedOption = selectElement.options[selectElement.selectedIndex];
        const accessList = JSON.parse(selectedOption.dataset.access || '[]');

        accessList.forEach(access => {
            const id = `access_${access}_${Date.now()}`;
            const html = `
            <div class="role-item">
                <input type="checkbox" id="${id}" name="access[]" value="${access}">
                <label for="${id}">${access.charAt(0).toUpperCase() + access.slice(1)}</label>
            </div>
        `;
            accessWrapper.insertAdjacentHTML('beforeend', html);
        });
    }

    function getSelectedProducts() {
        return Array.from(container.querySelectorAll('select[name="product[]"]'))
            .map(sel => sel.value)
            .filter(val => val !== "");
    }

    function refreshProductOptions() {
        const selected = getSelectedProducts();
        container.querySelectorAll('select[name="product[]"]').forEach(select => {
            const options = select.querySelectorAll('option');
            options.forEach(opt => {
                if (opt.value === "") return;
                opt.disabled = selected.includes(opt.value) && opt.value !== select.value;
            });
        });
    }

    function addNewProduct() {
        container.insertAdjacentHTML('beforeend', template);
        refreshProductOptions();
        const selects = container.querySelectorAll('select[name="product[]"]');
        const newSelect = selects[selects.length - 1];

        // Panggil updateAccessOptions agar access langsung muncul
        updateAccessOptions(newSelect);
    }


    $('#tbl_freemember').DataTable({
        "pageLength": 50,
        "scrollX": true,
        "order": false,
        "ajax": {
            "url": "<?= BASE_URL ?>godmode/admin/get_admin",
            "type": "POST",
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
                data: 'access',
                "mRender": function(data, type, full, meta) {
                    // Menampilkan access sebagai string yang dipisahkan koma
                    if (Array.isArray(data)) {
                        return data.join(', ');
                    } else if (typeof data === 'string') {
                        try {
                            // Coba parse jika data adalah JSON string
                            const accessArray = JSON.parse(data);
                            if (Array.isArray(accessArray)) {
                                return accessArray.join(', ');
                            }
                        } catch (e) {
                            return data || 'No Access';
                        }
                    }
                    return data || 'No Access';
                }
            },
            {
                data: null,
                "mRender": function(data, type, full, meta) {
                    const btndetail = `<a href="<?= BASE_URL ?>godmode/admin/deladmin/${encodeURI(btoa(full.email))}"><svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path fill="#BFA573" d="M135.2 17.7L128 32 32 32C14.3 32 0 46.3 0 64S14.3 96 32 96l384 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-96 0-7.2-14.3C307.4 6.8 296.3 0 284.2 0L163.8 0c-12.1 0-23.2 6.8-28.6 17.7zM416 128L32 128 53.2 467c1.6 25.3 22.6 45 47.9 45l245.8 0c25.3 0 46.3-19.7 47.9-45L416 128z"></path></svg></a>`
                    return btndetail;
                },
            },
        ],
        language: {
            emptyTable: "No Data"
        }
    });
</script>