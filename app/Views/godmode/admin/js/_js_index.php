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
    document.addEventListener("DOMContentLoaded", function() {
        var userTimeZone = Intl.DateTimeFormat().resolvedOptions().timeZone;
        document.getElementById("timezone").value = userTimeZone;
    });

    $('#tbl_freemember').DataTable({
        "pageLength": 50,
        "scrollX": true,
        "order": false,
        "ajax": {
            "url": "<?= BASE_URL ?>godmode/member/get_freemember",
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
                data: 'role',
            },
            {
                data: null,
                "mRender": function(data, type, full, meta) {
                    const btndetail = `<a href="<?= BASE_URL ?>godmode/freemember/detailmember/${encodeURI(btoa(full.email))}"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M20 3.33333V20H3.33333V3.33333H20ZM17.7778 5.55556H5.55556V17.7778H17.7778V5.55556ZM16.6667 0V2.22222L2.22219 2.22219L2.22222 16.6667H0V0H16.6667ZM15.5556 12.2222V14.4444H7.77778V12.2222H15.5556ZM15.5556 7.77778V10H7.77778V7.77778H15.5556Z" fill="#BFA573"/></svg></a>`
                    return btndetail;
                },
            },
        ],
        language: {
            emptyTable: "No Data"
        }
    });
</script>