<script>
    $('#tbl_member').DataTable({
        "pageLength": 50,
        "dom": '<"d-flex justify-content-between align-items-center flex-wrap"lf>t<"d-flex justify-content-between align-items-center"ip>',
        "responsive": true,
        "order": false,
        "ajax": {
            "url": "<?= BASE_URL ?>godmode/onetoone/dashboard/get_member",
            "type": "POST",
            "dataSrc": function(data) {
                return data.filter(row => row.is_deleted == 0);
            }
        },
        "columns": [{
                data: null,
                title: "#",
                render: function(data, type, full, meta) {
                    return meta.row + 1;
                },
                searchable: false,
                width: "30px"
            },
            {
                title: "Email",
                data: 'email',
                searchable: true,
            },
            {
                title: "Date Invoice",
                data: 'last_invoice_date',
                render: function(data, type, full, meta) {
                    return data ? new Date(data).toLocaleDateString() : '-';
                }
            },
            {
                title: "Link Invoice",
                data: 'last_link_invoice',
                render: function(data, type, full, meta) {
                    if (data === null) {
                        return '-';
                    }
                    return `<a href="${data}" target="_blank">View Invoice</a>`;
                },
                searchable: false,
            },
            {
                title: "Status",
                data: 'last_status_invoice',
                render: function(data, type, full, meta) {
                    if (data === null) {
                        return `<span class="text-muted">No transaction yet</span>`;
                    } else if (data === "unpaid") {
                        return `<span class="text-danger">Unpaid</span>`;
                    } else if (data === "paid") {
                        return `<span class="text-success">Paid</span>`;
                    }
                },
                searchable: true,
            },
            {
                data: null,
                mRender: function(data, type, full, meta) {
                    const btndetail = `<a href="<?= BASE_URL ?>godmode/onetoone/dashboard/detailmember/${full.id}">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M20 3.33333V20H3.33333V3.33333H20ZM17.7778 5.55556H5.55556V17.7778H17.7778V5.55556ZM16.6667 0V2.22222L2.22219 2.22219L2.22222 16.6667H0V0H16.6667ZM15.5556 12.2222V14.4444H7.77778V12.2222H15.5556ZM15.5556 7.77778V10H7.77778V7.77778H15.5556Z" fill="#BFA573" />
                        </svg>
                    </a>`;
                    const btndelete = `<a href="<?= BASE_URL ?>godmode/onetoone/dashboard/deleteuser/${full.id}">
                        <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                            <path fill="#BFA573" d="M135.2 17.7L128 32 32 32C14.3 32 0 46.3 0 64S14.3 96 32 96l384 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-96 0-7.2-14.3C307.4 6.8 296.3 0 284.2 0L163.8 0c-12.1 0-23.2 6.8-28.6 17.7zM416 128L32 128 53.2 467c1.6 25.3 22.6 45 47.9 45l245.8 0c25.3 0 46.3-19.7 47.9-45L416 128z" />
                        </svg>
                    </a>`;
                    return btndetail + ' ' + btndelete;
                }
            }
        ],
        language: {
            emptyTable: "No Data"
        }
    });
</script>